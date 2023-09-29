<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class news extends Controller{
    public function load_news(){
        $news = DB::table('news_and_events')
        ->leftJoin('events','news_and_events.id', "=" ,'events.referenceId')                                                                                                    
        ->select('news_and_events.*', 'events.eventPrice', 'events.eventDate')
        ->orderBy('news_and_events.id', 'DESC')
        ->paginate(10);

        return view('users/news_and_update', [ 'news' => $news ]);
    }

    public function news_details($id){
        $news        = DB::table('news_and_events')->where('id', $id)->get();
        $attachement = DB::table('news_and_events_attachement')->where('referenceId', $id)->get();

        return view('users/news_details', [ 'news' => $news, 'attachement' => $attachement ]);
    }

    public function events_details($id){
        $news = DB::table('news_and_events')->where('id', $id)->get();
        $events = DB::table('events')->where('referenceId', $id)->get();

        return view('users/event_details', [ 'news' => $news, 'events' => $events]);
    }
}
