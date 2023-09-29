<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

use App\Mail\ticketReport;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $value;
    private $recipient;
    private $CCrecipients;
    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($value, $recipient, $CCrecipients){
        $this->value        = $value;
        $this->recipient    = $recipient;
        $this->CCrecipients = $CCrecipients;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        $pdfContent     = $this->mailReportAttachment($this->value['from'], $this->value['to'], $this->value['chapter']);
        $email          = new ticketReport($this->value);
        $fileName       = 'Ticket Summary Report '.date('M j, Y', strtotime($this->value['from'])).' to '.date('M j, Y', strtotime($this->value['to'])).'.pdf';
        $email->attachData($pdfContent, $fileName, ['mime' => 'application/pdf']);
        
        Mail::to($this->recipient)->cc($this->CCrecipients)->send($email);
    }

    public function mailReportAttachment($from, $to, $chapter){
        $record = $this->report($from, $to, $chapter);

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'landscape');

        $html = View::make('admin/reports/admin_reports', $record)->render();

        $pdf->loadHTML($html);
        return $pdf->stream();
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
}
