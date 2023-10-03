<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Notification;
use App\Notifications\newsNotification;

class news_and_events extends Controller{

    #load new and event create form
    public function create_event_form(){
        return view('admin/news/create_events');
    }
    
    #save the created events
    public function save_events(Request $value){
        #validate form
        $value->validate([
            'file' => 'required',
            'title'         => 'required',
            'content'       => 'required',
            'eventDate'     => 'required',
            'eventTime'     => 'required',
            'eventPrice'    => 'required',
            'eventVenue'    => 'required',
            'eventAddress'  => 'required',
        ]);

        #insert to news and event table
        date_default_timezone_set('Asia/Manila');
        $id = DB::table('news_and_events')->insertGetId([
            'title'         => $value->title,
            'author'        => Auth::user()['email'],
            'category'      => 'EVENTS',
            'featuredImage' => '',
            'content'       => $value->content,
            'isComment'     => $value->isComments == 'on' ? 'ON' : 'OFF' ,
            "created_at"    => \Carbon\Carbon::now(),
            "updated_at"    => \Carbon\Carbon::now(),
        ]);

        #upload featured image and update db
        if($files = $value->file('file')){
            $destination_path = 'public/featured_image';
            $file_name = time() .'-'. $files->getClientOriginalName();
            $files->storeAs($destination_path, $file_name );
            DB::table('news_and_events')->where('id', $id)->update(['featuredImage' => $file_name]);
        }

        #insert to events tables
        DB::table('events')->insertGetId([
            'referenceId'  => $id,
            'eventDate'    => $value->eventDate,
            'eventTime'    => $value->eventTime,
            'eventPrice'   => $value->eventPrice,
            'eventVenue'   => $value->eventVenue,
            'eventAddress' => $value->eventAddress,
            "created_at"   => \Carbon\Carbon::now(),
            "updated_at"   => \Carbon\Carbon::now(),
        ]);

        $this->newsAndEventNotification($value->title);
        
        #redirect to create event form with session success
        session()->flash('success', 'true');
        return redirect()->action([news_and_events::class, 'create_event_form']);
    }

    #save image attachement
    public function save_image_attachement(Request $value){
        date_default_timezone_set('Asia/Manila');

        if($files = $value->file('addDynamicImage')){
            $destination_path = 'public/news_attachement';
            $file_name = time() .'-'. $files->getClientOriginalName();
            $files->storeAs($destination_path, $file_name );

            #database to save the attachement
            $id = DB::table('news_and_events_attachement')->insertGetId([
                'referenceId' => '',
                'attachement' => $file_name,
                'status'      => 'PENDING',
                "created_at"  => \Carbon\Carbon::now(),
                "updated_at"  => \Carbon\Carbon::now(),
            ]);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'success',
            'id'      => $id
        ]);
    }

    #remove pre attach image in database
    public function remove_pre_attachement(Request $value){
        $file_name = DB::table('news_and_events_attachement')->where('id', $value->id)->get('attachement');
        #delete physical image
        // Storage::disk('public')->delete('news_attachement/'.$file_name);
        DB::table('news_and_events_attachement')->where('id', $value->id)->delete();
        return response()->json(['status' => 200,'message' => $file_name]);
    }

    #save the created news in the db
    public function save_news(Request $value){
        #insert to news and event table
        date_default_timezone_set('Asia/Manila');
        $id = DB::table('news_and_events')->insertGetId([
            'title'         => $value->title,
            'author'        => Auth::user()['email'],
            'category'      => 'NEWS',
            'featuredImage' => '',
            'content'       => $value->content,
            'isComment'     => $value->isComments == 'on' ? 'ON' : 'OFF' ,
            "created_at"    => \Carbon\Carbon::now(),
            "updated_at"    => \Carbon\Carbon::now(),
        ]);

        #upload featured image and update db
        if($files = $value->file('file')){
            $destination_path = 'public/featured_image';
            $file_name = time() .'-'. $files->getClientOriginalName();
            $files->storeAs($destination_path, $file_name );
            DB::table('news_and_events')->where('id', $id)->update(['featuredImage' => $file_name]);
        }

        #update pre attach image reference id
        if($value->attachementToUpdate){
            for($i = 0 ; $i < count($value->attachementToUpdate); $i++){
                DB::table('news_and_events_attachement')->where('id', $value->attachementToUpdate[$i])->update(['referenceId' => $id ]);
            }
        }

        session()->flash('success', 'true');
        return back();
    }

    public function load_news(){
        $news = DB::table('news_and_events')
        ->leftJoin('events','news_and_events.id', "=" ,'events.referenceId')                                                                                                    
        ->select('news_and_events.*', 'events.eventPrice', 'events.eventDate')
        ->orderBy('news_and_events.id', 'DESC')
        ->paginate(10);

        return view('admin/news/news_list', [ 'news' => $news ]);
    }

    public function news_details($id){
        $news        = DB::table('news_and_events')->where('id', $id)->get();
        $attachement = DB::table('news_and_events_attachement')->where('referenceId', $id)->get();

        return view('admin/news/news_details', [ 'news' => $news, 'attachement' => $attachement ]);
    }

    public function events_details($id){
        $news = DB::table('news_and_events')->where('id', $id)->get();
        $events = DB::table('events')->where('referenceId', $id)->get();

        return view('admin/news/event_details', [ 'news' => $news, 'events' => $events]);
    }

    public function newsAndEventNotification($subject){
        $notifData = [
            'subject'          => $subject,
            'greetings'        => 'Good Day!',
            'body'             => 'We hope this message finds you well. We are excited to inform you about the latest news and events that have been posted on our platform. Stay connected and dont miss out on these exciting updates!',
            'body1'            => ' ',
            'notificationText' => 'View',
            'url'              => url('/read-news'),
            'thankyou'         => ' '
        ];

        //send to a multiple users or email
        //queue has been implemented in this notification
        //run php artisan queue:work
        Notification::route('mail', ['jestreecarl@gmail.com'])->notify(new newsNotification($notifData));
    }

}
