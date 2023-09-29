<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\ticket_update_notification;
use Illuminate\Support\Facades\Notification;
use App\Models\ticket_status;
use App\Http\Controllers\smsTxtMessage;

class admin_tickets extends Controller{
    protected $notificationController;

    public function __construct(smsTxtMessage $notificationController) {
        $this->notificationController = $notificationController;
    }

    public function ticket_list(){
        $tickets = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*', 'users.firstName', 'users.lastName', 'users.chapterName', 'users.number', 'users.profile_picture')
        ->whereNotIn('status', ['RESOLVED', 'CLOSED'])
        ->orderBy('tickets.created_at', 'desc')
        ->get();

        return view('admin/ticket_list', ['list' => $tickets]);
    }

    public function resolved_ticket(){
        $tickets = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*', 'users.firstName', 'users.lastName', 'users.chapterName', 'users.number', 'users.profile_picture')
        ->whereIn('status', ['RESOLVED', 'CLOSED'])
        ->orderBy('tickets.updated_at', 'desc')
        ->get();

        return view('admin/resolved_tickets', ['list' => $tickets]);
    }

    public function view_ticket_details($id, $status){
        date_default_timezone_set('Asia/Manila');

        if($status == 'NEW'){
            ticket::whereId($id)->update(['status' => "OPENED" ]);
            $isExist = DB::table('ticket_status')->where('reference_id', $id)->where('status', 'OPENED')->get();

            if($isExist->isEmpty()){
                DB::table('ticket_status')->insert([
                    'reference_id' => $id,
                    'user_id'      => Auth::user()['id'],
                    'user_name'    => Auth::user()['firstName'].' '.Auth::user()['lastName'],
                    'status'       => 'OPENED',
                    'feedback'     => '',
                    "created_at"   => \Carbon\Carbon::now(),                                  # new \Datetime()
                    "updated_at"   => \Carbon\Carbon::now(),                                  # new \Datetime()
                ]);

                $this->send_ticket_notification($id);
            }

            $attachements  = DB::table('tickets_attachements')->where('ticket_id', $id)->get();
            $ticketComment = DB::table('ticket_comments')->where('ticket_id', $id)->count();

            $this->updateCommentStatus($id);

            return view('admin/ticket_details', [
                'id'            => $id,
                'attachements'  => $attachements,
                'ticketComment' => $ticketComment
            ]);
        }else{
            $attachements = DB::table('tickets_attachements')->where('ticket_id', $id)->get();
            $ticketComment = DB::table('ticket_comments')->where('ticket_id', $id)->count();

            $this->updateCommentStatus($id);

            return view('admin/ticket_details', [
                'id'            => $id,
                'attachements'  => $attachements,
                'ticketComment' => $ticketComment
            ]);
        }
        
    }

    private function updateCommentStatus($id){
        $userID = DB::table('tickets')->where('id', $id)->value('user_id');
        DB::table('ticket_comments')->where('ticket_id', $id)->where('user_id', $userID)->update(['seen' => 'YES']);
    }

    public function send_ticket_notification($id){
        $user = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.id', 'tickets.ticket_code', 'users.firstName', 'users.email')
        ->where('tickets.id', $id)
        ->get();

        $ticketData = [
            'subject'          => 'FEDCIS IT SUPPORT: TICKET UPDATE (['.$user[0]->ticket_code.'])[OPENED]',
            'greetings'        => 'Hello '.ucwords($user[0]->firstName),
            'body'             => 'Thank you for reaching out to us. We are working on your issue (['.$user[0]->ticket_code.']) and will get back to you soon.',
            'body1'            => 'Please let us know if you have any more questions. We will be happy to help.',
            'notificationText' => 'VIEW TICKET',
            'url'              => url('/ticket-list/view-ticket/'.$id),
            'thankyou'         => 'This is a system-generated message. Please do not reply to this email.'
        ];

        Notification::route('mail', $user[0]->email)->route('nexmo', '5555555555')->notify(new ticket_update_notification($ticketData));   
    }

    public function get_ticket_details($id){
        $tickets = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*', 'users.firstName', 'users.lastName', 'users.chapterName', 'users.email', DB::raw("DATE_FORMAT(tickets.created_at, '%h:%i %p - %d %b, %Y') as date"))
        ->where('tickets.id', $id)
        ->get();

        return response()->json($tickets);
    }

    public function get_status($id){
        // $status = DB::table('ticket_status')->where('reference_id', $id)->get();
        $status = DB::table('ticket_status')->where('reference_id', $id)
        ->select("ticket_status.*", DB::raw("DATE_FORMAT(ticket_status.created_at, '%b %d, %Y, %h:%i %p') as date"))
        ->get();
        return response()->json($status);
    }

    public function update_priority(Request $value){
        date_default_timezone_set('Asia/Manila');

        ticket::whereId($value->id)->update(['priority' => $value->priority,"updated_at"   => \Carbon\Carbon::now(),  ]);
        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);
    }

    public function update_status(Request $value){
        date_default_timezone_set('Asia/Manila');
        
        $result = DB::table('tickets')->where('id', $value->id)->update(['status' => $value->status,"updated_at" => \Carbon\Carbon::now()]);

        if ($result > 0) {
            DB::table('ticket_status')->insert([
                'reference_id' => $value->id,
                'user_id'      => Auth::user()['id'],
                'user_name'    => Auth::user()['firstName'].' '.Auth::user()['lastName'],
                'status'       => $value->status,
                'feedback'     => $value->feedback ? $value->feedback : '-',
                "created_at"   => \Carbon\Carbon::now(),                                  # new \Datetime()
                "updated_at"   => \Carbon\Carbon::now(),                                  # new \Datetime()
            ]);
            
            $this->send_ticket_status_notification($value->status, $value->id);
            $this->notifyUsers($value->status, $value->id);

            return response()->json(['status' => 200,'message' => 'success']);
        } else {
            return response()->json(['status' => 200,'message' => 'failed']);
        }
    }

    public function notifyUsers($status, $id){
        $user = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.id', 'tickets.ticket_code', 'users.number')
        ->where('tickets.id', $id)
        ->first();

        $message = "";

        if($status == 'ACTION TAKEN'){
            $message = 'Your '.$user->ticket_code.' is currently being worked on by our team.';
        }else if($status == 'AWAITING REPLY'){
            $message = 'We are awaiting your response to your ticket # ('.$user->ticket_code.').';
        }else if($status == 'ON HOLD'){
            $message = 'Your '.$user->ticket_code.' is currently being put to ON HOLD.';
        }else{
            $message = 'Your '.$user->ticket_code.' is resolved. We are closing the ticket now.';
        }

        $this->notificationController->smsNotification($user->number, $message);
    }

    public function send_ticket_status_notification($status, $id){
        $user = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.id', 'tickets.ticket_code', 'tickets.ticket_code', 'users.firstName', 'users.email')
        ->where('tickets.id', $id)
        ->get();

        $body        = '';
        $body1       = '';
        $buttonTitle = '';

        if($status == 'ACTION TAKEN'){
            $body        = 'Your issue (['.$user[0]->ticket_code.']) is currently being worked on by our team.';
            $body1       = 'We will get back to you soon. Thank you for your patience.';
            $buttonTitle = "VIEW TICKET";
        }else if($status == 'AWAITING REPLY'){
            $body        = 'Thank you for submitting your query (['.$user[0]->ticket_code.']). We need more data to proceed with your request.';
            $body1       = 'You can update the information by replying to the comment section of the ticket. Once we get this information, we will be able to resolve your query soon.';
            $buttonTitle = "ADD COMMENT";
        }else if($status == 'ON HOLD'){
            $body        = 'Your issue (['.$user[0]->ticket_code.']) is currently being put to ON HOLD.';
            $body1       = 'We will get back to you soon. Thank you for your patience.';
            $buttonTitle = 'VIEW TICKET';
        }else{
            $body        = 'Your issue (['.$user[0]->ticket_code.']) is resolved. We are closing the ticket now.';
            $body1       = 'If there is anything else you need help with, feel free to email us at info@mmgphil.org. We will be happy to help. ';
            $buttonTitle = "VIEW TICKET";
        }

        $ticketData = [
            'subject'          => 'FEDCIS IT SUPPORT: TICKET UPDATE (['.$user[0]->ticket_code.'])['.$status.']',
            'greetings'        => 'Hello '.ucwords($user[0]->firstName),
            'body'             => $body,
            'body1'            => $body1,
            'notificationText' => $buttonTitle,
            'url'              => url('/ticket-list/view-ticket/'.$id),
            'thankyou'         => ' '
        ];

        Notification::route('mail', $user[0]->email)->route('nexmo', '5555555555')->notify(new ticket_update_notification($ticketData));   
    }

    public function getComments(Request $value){
        $comments = DB::table('ticket_comments')
        ->leftJoin('users','ticket_comments.user_id', "=" ,'users.id')
        ->select('ticket_comments.*', 'users.chapterName', 'users.profile_picture', DB::raw("DATE_FORMAT(ticket_comments.created_at, '%b %d, %Y, %h:%i %p') as date"))
        ->where('ticket_comments.ticket_id', $value->id)
        ->get();
        
        return response()->json($comments);
    }

    public function getAttachments(Request $value){
        $images = DB::table('ticket_comment_attachements')->where('comment_code', $value->id)->get();
        return response()->json($images);
    }

    public function send_comments(Request $value){
        date_default_timezone_set('Asia/Manila');

        $id = DB::table('ticket_comments')->insertGetId([
            'user_id'    => Auth::user()['id'],
            'ticket_id'  => $value->ticket_id,
            'sender'     => Auth::user()['firstName'].' '.Auth::user()['lastName'],
            'comments'   => $value->comment ? $value->comment : '-',
            'seen'       => 'NO',
            'isSent'     => 'NO',
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);
        
        if($files = $value->file('file')){
            $destination_path = 'public/ticket_comments_attachenent';
            foreach($files as $file){
                $file_name = time() .'-'. $file->getClientOriginalName();
                $file->storeAs($destination_path, $file_name );

                DB::table('ticket_comment_attachements')->insert([
                    'ticket_code'  => $value->ticket_id,
                    'comment_code' => $id,
                    'file_name'    => $file_name ,
                    "created_at"   => \Carbon\Carbon::now(),
                    "updated_at"   => \Carbon\Carbon::now(), 
                ]);
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);
    }

    public function deleteComment(Request $value){
        DB::table('ticket_comments')->where('id', $value->id)->delete();
        DB::table('ticket_comment_attachements')->where('comment_code', $value->id)->delete();
        return response()->json(['status' => 200,'message' => 'success']);
    }
}
