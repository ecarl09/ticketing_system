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

class reports extends Controller{

    public function displayReports(){
        return view('admin/reports');
    }

    private function report($from, $to, $chapter){
        $from = Carbon::parse($from)->startOfDay();
        $to   = Carbon::parse($to)->endOfDay();

        $results = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->leftJoin('ticket_status', function ($join) {
            $join->on('tickets.id', '=', 'ticket_status.reference_id')
                ->whereRaw('ticket_status.created_at = (SELECT MAX(created_at) FROM ticket_status WHERE reference_id = tickets.id)');
        })->select(
            'tickets.*',
            'users.chapterName',
            'users.firstName', 
            'users.lastName',
            'ticket_status.created_at as resolvedDate',
            'ticket_status.user_name as resolvedBy',
            'ticket_status.feedback'
            )
        ->whereBetween('tickets.created_at', [$from, $to])
        ->when($chapter !== 'ALL', function ($query) use ($chapter) {
            return $query->where('users.chapterName', $chapter);
        }, function ($query) {
            return $query; // Don't apply the where clause when $chapter is 'ALL'
        })->orderBY('tickets.created_at', 'desc')
        ->get();

        $categoryTotal = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('ticket_type', DB::raw('COUNT(*) as total'))
        ->whereBetween('tickets.created_at', [$from, $to])
        ->when($chapter !== 'ALL', function ($query) use ($chapter) {
            return $query->where('users.chapterName', $chapter);
        }, function ($query) {
            return $query;
        })->whereIn('ticket_type', ['General Inquiry', 'Implementation Support', 'Error Encounter', 'Change Request', 'Others'])
        ->groupBy('ticket_type')
        ->get();

        return [
            'results'       => $results,
            'categoryTotal' => $categoryTotal,
            'total'         => $categoryTotal->sum('total'),
            'from'          => $from,
            'to'            => $to,
            'chapter'       => $chapter
        ];
    }

    public function generateReports(Request $value){
        $value->validate([
            'chapter' => 'required',
            'from'    => 'required',
            'to'      => 'required',
        ]);
    
        $record = $this->report($value->from, $value->to, $value->chapter);

        return view('admin/reports', $record );
    }

    public function exportTicketReport($from, $to, $chapter){
        $record = $this->report($from, $to, $chapter);

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');

        $html = View::make('admin/reports/admin_reports', $record)->render();

        $pdf->loadHTML($html);
        return $pdf->stream();
    }

    public function printTicket($id){
        $details = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*', 'users.firstName', 'users.lastName', 'users.email', 'users.number', 'users.chapterName')
        ->where('tickets.id', $id)
        ->first();

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'portrait');

        $html = View::make('admin/reports/ticket_print', ['details' => $details])->render();

        $pdf->loadHTML($html);
        return $pdf->stream();
    }

    public function mailReportAttachment($from, $to, $chapter){
        $record = $this->report($from, $to, $chapter);
    
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
        $record = $this->report($from, $to, $chapter);

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
