<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ticketReport extends Controller{

    public function displayReports(){
        return view('users/reports');
    }

    private function report($from, $to){
        $from    = Carbon::parse($from)->startOfDay();
        $to      = Carbon::parse($to)->endOfDay();
        $chapter = Auth::user()['chapterName'];

        $results = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*',  'users.chapterName', 'users.firstName', 'users.lastName')
        ->whereBetween('tickets.created_at', [$from, $to])
        ->when($chapter !== 'ALL', function ($query) use ($chapter) {
            return $query->where('users.chapterName', $chapter);
        }, function ($query) {
            return $query;
        })
        ->orderBY('tickets.id', 'desc')
        ->get();

        $categoryTotal = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('ticket_type', DB::raw('COUNT(*) as total'))
        ->when($chapter !== 'ALL', function ($query) use ($chapter) {
            return $query->where('users.chapterName', $chapter);
        }, function ($query) {
            return $query;
        })
        ->whereIn('ticket_type', ['General Inquiry', 'Implementation Support', 'Error Encounter', 'Change Request', 'Others'])
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
            'from'    => 'required',
            'to'      => 'required',
        ]);
    
        $record = $this->report($value->from, $value->to);
        return view('users/reports', $record );
    }

    public function exportTicketReport($from, $to){
        $record = $this->report($from, $to);

        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('A4', 'portrait');

        $html = View::make('users/reports/admin_reports', $record)->render();

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

        $html = View::make('users/reports/ticket_print', ['details' => $details])->render();

        $pdf->loadHTML($html);
        return $pdf->stream();
    }
}


