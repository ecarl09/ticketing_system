<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class users_dashboard extends Controller{

    public function dashboard(){
        $tickets = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*', 'users.firstName', 'users.lastName', 'users.profile_picture', 'users.chapterName')
        ->where('tickets.user_id', Auth::user()['id'])
        ->whereIn('tickets.status', array('NEW', 'OPENED', 'AWAITING REPLAY', 'ACTION TAKEN', 'ON HOLD'))
        ->orderBy('id', 'desc')
        ->get();

        $totalTickets = DB::table('tickets')->where('user_id', Auth::user()['id'])->count();
        $opened = DB::table('tickets')->where('user_id', Auth::user()['id'])->whereIn('status', array('NEW', 'OPENED', 'AWAITING REPLAY', 'ACTION TAKEN', 'ON HOLD'))->count();

        return view('users/home', [
            'list'          => $tickets,
            'tickets'       => $totalTickets,
            'currentTicket' => $opened,
        ]);
    }


}
