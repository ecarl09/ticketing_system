<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class admin_dashboard extends Controller{

    public function dashboard(){
        $tickets = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*', 'users.firstName', 'users.lastName', 'users.chapterName', 'users.profile_picture')
        ->whereIn('tickets.status', array('NEW', 'OPENED', 'AWAITING REPLAY', 'ACTION TAKEN', 'ON HOLD'))
        ->orderBy('id', 'desc')
        ->get();

        $totalTickets = DB::table('tickets')->count();
        $users        = DB::table('users')->count();
        $opened       = DB::table('tickets')->whereIn('status', array('NEW', 'OPENED', 'AWAITING REPLAY', 'ACTION TAKEN', 'ON HOLD'))->count();
        $usersList    = DB::table('users')->orderBy('id', 'desc')->get();

        return view('admin/home', [
            'list'          => $tickets,
            'tickets'       => $totalTickets,
            'users'         => $users,
            'opened'        => $opened,
            'usersList'     => $usersList
        ]);
    }
}
