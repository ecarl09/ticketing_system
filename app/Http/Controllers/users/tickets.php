<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ticket;
use App\Models\tickets_code;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ticket_notification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\smsTxtMessage;

class tickets extends Controller{
    protected $notificationController;

    public function __construct(smsTxtMessage $notificationController) {
        $this->notificationController = $notificationController;
    }

    public function save_ticket_form(Request $value){
        date_default_timezone_set('Asia/Manila');

        $id          = tickets_code::create();
        $ticket_code = 'TICKET-'.date("Y").'-'. $id->id;

        $value->validate([
            'ticketType' => 'required',
            'department' => 'required',
            'narrative'  => 'required',
        ]);

        $ticket               = new ticket;
        $ticket ->ticket_code = $ticket_code;
        $ticket ->user_id     = Auth::user()['id'];
        $ticket ->ticket_type = $value->ticketType;
        $ticket ->department  = $value->department;
        $ticket ->narrative   = $value->narrative;
        $ticket ->attachment  = '';
        $ticket ->anydeskId   = $value->anydesk;
        $ticket ->status      = 'NEW';
        $ticket ->priority    = 'NORMAL';
        $ticket ->created_at  = \Carbon\Carbon::now();
        $ticket ->updated_at  = \Carbon\Carbon::now();
        $saved                = $ticket->save();
        $id                   = $ticket->id;

        if($files = $value->file('file')){
            $destination_path = 'public/ticket_attachments';
            foreach($files as $file){
                $file_name        = time() .'-'. $file->getClientOriginalName();
                $file->storeAs($destination_path, $file_name );

                DB::table('tickets_attachements')->insert([
                    'user_id'      => Auth::user()['id'],
                    'ticket_id'    => $id,
                    'file_name'    => $file_name ,
                    "created_at"   => \Carbon\Carbon::now(),
                    "updated_at"   => \Carbon\Carbon::now(), 
                ]);
            }
        }

        $this->saveTicketStatus($id);

        if($saved){
            // $this->send_ticket_notification($value->ticketType, $id, $ticket_code);
            // $this->NotifyAdminUsers($ticket_code);

            session()->flash('saved', 'true');
            return back();
        }else{
            return back();
        }
    }

    private function saveTicketStatus($id){
        DB::table('ticket_status')->insert([
            'user_id'      => Auth::user()['id'],
            'reference_id' => $id,
            'user_name'    => Auth::user()['firstName'].' '.Auth::user()['lastName'],
            'status'       => 'NEW',
            'feedback'     => '',
            "created_at"   => \Carbon\Carbon::now(),
            "updated_at"   => \Carbon\Carbon::now(),
        ]);
    }

    private function NotifyAdminUsers($ticket_code){
        $contacts = DB::table('users')->where('userType', '0')->select('number')->get();
        $message  = $ticket_code.' has been created by '.Auth::user()['firstName'].' '.Auth::user()['lastName'].' from '. ucwords(Auth::user()['chapterName']);

        foreach($contacts as $contacts){
            $this->notificationController->smsNotification($contacts->number, $message);
        }
    }

    public function send_ticket_notification($ticket_type, $id, $ticket_code){
        $admin = User::where('userType', '0')->get();

        $ticketData = [
            'subject'          => 'FEDCIS IT SUPPORT: NEW TICKET (['.$ticket_code.'])',
            'greetings'        => 'Hello ',
            'body'             => 'A new ticket has been created by '.Auth::user()['firstName'].' '.Auth::user()['lastName'].' from '. ucwords(Auth::user()['chapterName']),
            'body2'            => 'Ticket type: ' . $ticket_type,
            'notificationText' => 'OPEN TICKET',
            'url'              => url('/user-ticket-list/view-ticket/'.$id.'/NEW'),
            'thankyou'         => 'This is a system-generated message. Please do not reply to this email.'
        ];
        
        //send to a multiple users or email
        //queue has been implemented in this notification
        //run php artisan queue:work
        Notification::send($admin, new ticket_notification($ticketData, $admin) );
    }

    public function ticket_list(){
        $tickets = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*', 'users.firstName', 'users.lastName', 'users.profile_picture', 'users.chapterName', 'users.number')
        ->where('tickets.user_id', Auth::user()['id'])
        ->orderBy('id', 'desc')
        ->get();

        return view('users/ticket_list', ['list' => $tickets]);
    }

    public function view_ticket_details($id){
        $tickets = DB::table('tickets')
        ->leftJoin('users','tickets.user_id', "=" ,'users.id')
        ->select('tickets.*', 'users.firstName', 'users.lastName', 'users.chapterName', 'users.email')
        ->where('tickets.id', $id)
        ->get();

        $attachements = DB::table('tickets_attachements')->where('ticket_id', $tickets['0']->id)->get();
        $this->updateCommentStatus($id);
        
        return view('users/ticket_details', [
            'list'         => $tickets,
            'attachements' => $attachements
        ]);
    }

    private function updateCommentStatus($id){
        DB::table('ticket_comments')->where('ticket_id', $id)->where('user_id', '!=', Auth::user()['id'])->update(['seen' => 'YES']);
    }

    public function send_comments(Request $value){
        date_default_timezone_set('Asia/Manila');

        $id = DB::table('ticket_comments')->insertGetId([
            'user_id'    => Auth::user()['id'],
            'ticket_id'  => $value->ticket_id,
            'sender'     => Auth::user()['firstName'].' '.Auth::user()['lastName'],
            'comments'   => $value->comment ? $value->comment : '',
            'seen'       => 'NO',
            'isSent'     => 'NO',
            "created_at" => \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ]);

        if($files = $value->file('file')){
            $destination_path = 'public/ticket_comments_attachenent';
            foreach($files as $file){
                $file_name        = time() .'-'. $file->getClientOriginalName();
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

        return response()->json(['status' => 200,'message' => 'success']);
    }

    public function getComments(Request $value){
        $comments = DB::table('ticket_comments')
        ->leftJoin('users','ticket_comments.user_id', "=" ,'users.id')
        ->select('ticket_comments.*', 'users.chapterName', 'users.profile_picture', DB::raw("DATE_FORMAT(ticket_comments.created_at, '%b %d, %Y | %h:%i %p') as date"))
        ->where('ticket_comments.ticket_id', $value->id)
        ->get();
        
        return response()->json($comments);
    }

    public function deleteComment(Request $value){
        DB::table('ticket_comments')->where('id', $value->id)->delete();
        DB::table('ticket_comment_attachements')->where('comment_code', $value->id)->delete();
        return response()->json(['status' => 200,'message' => 'success']);
    }

    public function getAttachments(Request $value){
        $images = DB::table('ticket_comment_attachements')->where('comment_code', $value->id)->get();
        return response()->json($images);
    }

    public function get_status($id){
        $status = DB::table('ticket_status')->where('reference_id', $id)
        ->select("ticket_status.*", DB::raw("DATE_FORMAT(ticket_status.created_at, '%b %d, %Y, %h:%i %p') as date"))
        ->get();
        return response()->json($status);
    }

}
