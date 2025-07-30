<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

use App\Mail\ticketReport;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailJob;
use App\Models\ticket;
use App\Models\ticket_status;

class reports extends Controller{

    public function displayReports(){
        return view('admin/reports');
    }

    private function generateTicketReport($from, $to, $chapter){
        $from = Carbon::parse($from)->startOfDay();
        $to   = Carbon::parse($to)->endOfDay();

        // Step 1: Get ticket_status records within date range
        $statusesInRange = DB::table('ticket_status')
            ->whereBetween('created_at', [$from, $to])
            ->get();

        // Step 2: Extract unique ticket IDs from those statuses
        $ticketIds = $statusesInRange->pluck('reference_id')->unique()->values();

        // Step 3: Get those tickets
        $tickets = DB::table('tickets')
            ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
            ->where('chapterName', $chapter)
            ->whereIn('tickets.id', $ticketIds)
            ->select(
                'tickets.id',
                'tickets.ticket_code',
                'tickets.ticket_type',
                'tickets.department',
                'tickets.narrative',
                'tickets.status',
                'tickets.created_at',
                'users.chapterName',
                'users.firstName',
                'users.lastName'
            )
            ->orderBy('tickets.created_at', 'desc')
            ->get();

        // Step 4: Get all statuses (not just within the range)
        $allStatuses = DB::table('ticket_status')->get();

        // Step 5: Group all statuses by ticket ID
        $groupedStatuses = $allStatuses->groupBy(function ($status) {
            return (int) $status->reference_id;
        });

        // Step 6: Attach all statuses to the tickets
        $finalResult = $tickets->map(function ($ticket) use ($groupedStatuses) {
            $ticketId = (int) $ticket->id;

            return (object) [
                'ticket_code'   => $ticket->ticket_code,
                'ticket_type'   => $ticket->ticket_type,
                'department'    => $ticket->department,
                'narrative'     => $ticket->narrative,
                'status'        => $ticket->status,
                'created_at'    => $ticket->created_at,
                'chapterName'   => $ticket->chapterName,
                'firstName'     => $ticket->firstName,
                'lastName'      => $ticket->lastName,
                'ticket_status' => collect($groupedStatuses->get($ticketId, []))
                    ->sortBy('created_at')
                    ->map(function ($status) {
                        return (object) [
                            'id'         => $status->id,
                            'user_name'  => $status->user_name,
                            'status'     => $status->status,
                            'feedback'   => $status->feedback,
                            'created_at' => $status->created_at,
                        ];
                    })->values()->all(),
            ];
        });

        $categoryTotal = $this->getCategoryTotal($from, $to, $chapter);

        return [
            'results'       => $finalResult,
            'categoryTotal' => $categoryTotal,
            'total'         => $categoryTotal->sum('total'),
            'from'          => $from,
            'to'            => $to,
            'chapter'       => $chapter
        ];
    }

    private function getCategoryTotal($from, $to, $chapter){
        return DB::table('tickets')
        ->leftJoin('users', 'tickets.user_id', '=', 'users.id')
        ->where('users.chapterName', $chapter)
        ->whereIn('tickets.id', function ($query) use ($from, $to) {
            $query->select('reference_id')
                  ->from('ticket_status')
                  ->whereBetween('created_at', [$from, $to]);
        })
        ->select('tickets.ticket_type', DB::raw('COUNT(*) as total'))
        ->groupBy('tickets.ticket_type')
        ->get();
        
        // $categoryTotal = DB::table('tickets')
        // ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        // ->select('ticket_type', DB::raw('COUNT(*) as total'))
        // ->whereBetween('tickets.created_at', [$from, $to])
        // ->when($chapter !== 'ALL', function ($query) use ($chapter) {
        //     return $query->where('users.chapterName', $chapter);
        // }, function ($query) {
        //     return $query;
        // })->whereIn('ticket_type', ['General Inquiry', 'Implementation Support', 'Error Encounter', 'Change Request', 'Others'])
        // ->groupBy('ticket_type')
        // ->get();

        // return $categoryTotal;
    }

    public function generateReports(Request $value){
        $value->validate([
            'chapter' => 'required',
            'from'    => 'required',
            'to'      => 'required',
        ]);

        $ticketResult = $this->generateTicketReport($value->from, $value->to, $value->chapter);

        return view('admin/reports', $ticketResult);
    }

    public function exportTicketReport($from, $to, $chapter){
        $record = $this->generateTicketReport($from, $to, $chapter);

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');

        $html = View::make('admin/reports/admin_reports', $record)->render();

        $fromFormatted = Carbon::parse($from)->format('M d, Y');
        $toFormatted = Carbon::parse($to)->format('M d, Y');
        $fileName = "($chapter) ticket summary report: {$fromFormatted} to {$toFormatted}.pdf"; 

        $pdf->loadHTML($html);
        return $pdf->stream($fileName);
    }

    public function printTicket($id){
        $details = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*', 'users.firstName', 'users.lastName', 'users.email', 'users.number', 'users.chapterName')
        ->where('tickets.id', $id)
        ->first();

        $comment = DB::table('ticket_comments')->where('ticket_id', $id)->orderBy('id', 'asc')->get();

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'portrait');

        $html = View::make('admin/reports/ticket_print', ['details' => $details, 'comment' => $comment])->render();

        $pdf->loadHTML($html);
        return $pdf->stream();
    }

    public function mailReportAttachment($from, $to, $chapter){
        $record = $this->generateTicketReport($from, $to, $chapter);
    
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');
    
        $html = View::make('admin/reports/admin_reports', $record)->render();
    
        $pdf->loadHTML($html);
        return $pdf->stream();
    }
    

    public function mailReport(Request $form){
        $value  = [
            'subject' => $form->subject,
            'content' => $form->content,
            'from'    => $form->from,
            'to'      => $form->to,
            'chapter' => $form->chapter,
        ];

        SendEmailJob::dispatch($value, $form->recipients, $form->CCrecipients);

        return redirect()->route('return.report.page', ['from' => $form->from, 'to' => $form->to, 'chapter' => $form->chapter,])->with('message', 'success');
    }

    public function backToReportPage($from, $to, $chapter){
        $record = $this->generateTicketReport($from, $to, $chapter);

        return view('admin/reports', $record );
    }

    public function composeMailTicketReport($from, $to, $chapter){
        $recipientsList = DB::table('recipients')->select('chapter')->groupBy('chapter')->get();
        return view('admin/reports/mailReport', ['from' => $from, 'to' => $to, 'chapter' => $chapter, 'recipientsList' => $recipientsList]);
    }

    public function saveRecipient(Request $value){
        date_default_timezone_set('Asia/Manila'); 

        DB::table('recipients')->insert([
            'recepients' => $value->email,
            'chapter'    => $value->chapter,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return response()->json(['status' => 200,'message' => 'success']);
    }

    public function fetchEmails(){
        $result = DB::table('recipients')->select('id','recepients', 'chapter')->get();
        return response()->json($result);
    }

    public function deleteEmail(Request $value){
        DB::table('recipients')->where('id', $value->id)->delete();
        return response()->json(['status' => 200,'message' => 'success']);
    }

    public function fetchRecipients($value){
        $recipientsList = DB::table('recipients')->select('recepients')->where('chapter', $value)->get();
        return response()->json($recipientsList);
    }
}
