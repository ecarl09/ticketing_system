<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

//this is a test controller only .. go to app/console/commands/commentNotification for the running code

class workerComment extends Controller{

    public function checkComment(){
        date_default_timezone_set('Asia/Manila');

        //get all comments
        $result = DB::table('ticket_comments')
        ->leftJoin('tickets', 'tickets.id', '=', 'ticket_comments.ticket_id')
        ->leftJoin('users', 'users.id', '=', 'ticket_comments.user_id')
        ->select(
            'ticket_comments.ticket_id', 
            'users.chapterName',
            'tickets.user_id',
            'tickets.ticket_code'
        )
        ->where('seen', 'NO')
        ->where('isSent', 'NO')
        ->where('ticket_comments.created_at', '<=', Carbon::now()->subMinutes(15)) //get all that are greater than 30 minutes
        ->groupBy('ticket_comments.ticket_id', 'users.chapterName', 'tickets.user_id', 'tickets.ticket_code')
        ->get();

        foreach($result as $result){
            if('MMG Federation' == $result->chapterName){
                //send notification to chapter sa nag himo sang ticket
                $mobile  = DB::table('users')->where('id', $result->user_id)->value('number');
                $message = 'Support.mmgphil.org [ '.$result->ticket_code.' ] - Your ticket has an unread comment that is awaiting for your response.';
                $this->notification($mobile, $message);

                //update admin comments
                $this->updateAdminComment($result->ticket_id, $result->user_id);
            }else{
                //send notification to admin sa nag comment
                $adminId = DB::table('ticket_comments')
                ->leftJoin('users', 'users.id', '=', 'ticket_comments.user_id')
                ->where('ticket_id', $result->ticket_id)
                ->where('users.chapterName', 'MMG Federation')
                ->where('ticket_comments.created_at', '<=', Carbon::now()->subMinutes(15)) 
                ->select('ticket_comments.user_id', 'users.number', 'users.email')
                ->groupBy('ticket_comments.user_id', 'users.number', 'users.email')
                ->get();

                foreach($adminId as $adminId){
                    // send notification to admin
                    $message = $result->ticket_code.' has an unread comment that is awaiting for your response.';
                    $this->notification($adminId->number, $message);
                }

                // update chapter comments
                $this->updateChapterComment($result->ticket_id, $result->user_id);
            }
        }
    }

    private function updateChapterComment($ticket_id, $userId){
        date_default_timezone_set('Asia/Manila');

        DB::table('ticket_comments')
        ->where('ticket_id', $ticket_id)
        ->where('user_id', $userId)
        ->where('created_at', '<=', Carbon::now()->subMinutes(15))//update all that are greater that 30 minutes
        ->update(['isSent' => 'YES']);
    }

    private function updateAdminComment($ticket_id, $userId){
        date_default_timezone_set('Asia/Manila');

        DB::table('ticket_comments')
        ->where('ticket_id', $ticket_id)
        ->where('user_id', '!=', $userId)
        ->where('created_at', '<=', Carbon::now()->subMinutes(15))//update all that are greater that 30 minutes
        ->update(['isSent' => 'YES']);
    }

    private function notification($mobile, $message){
        $data = array(
            "app_key"        => "MIoLFf8ofGIk7YDV",
            "app_secret"     => "apiHKAhAyoyS4dVqr7lYoXBwitMmRXWS",
            "msisdn"         => $mobile,
            "content"        => $message,
            "shortcode_mask" => "MMGFED",
            "rcvd_transid"   => "12334512312312",
            "is_intl"        => false
        );
  
        $data_string = json_encode($data);
        $curl = curl_init('https://api.m360.com.ph/v3/api/broadcast');
  
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data
  
        // Send the request
        $result = curl_exec($curl);

        // Free up the resources $curl is using
        curl_close($curl);
  
        // echo $result;
    }
}
