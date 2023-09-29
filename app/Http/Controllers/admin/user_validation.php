<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Notifications\registrationValidation;

class user_validation extends Controller{
    
    public function display_unverified_user(){   
        $data =  DB::table('users')->where('isVerified', 'NO')->get();
        return view('admin/user_validation', ['users' => $data]);
    }

    public function verify_user($id){
        $user = DB::table('users')->find($id);
        DB::table('users')->where('id', $id)->update(['isVerified' => 'YES']);

        $verificationData =[
            'subject'          => 'IT SUPPORT: ACCOUNT VERIFIED',
            'greetings'        => 'Good Day '.ucwords($user->firstName).' '.ucwords($user->lastName),
            'body'             => 'Your account has been approved!',
            'body2'            => '',
            'notificationText' => 'Login',
            'url'              => url('/'),
            'thankyou'         => 'This is a system-generated message. Please do not reply to this email.',
        ];

        Notification::route('mail', $user->email)->route('nexmo', '5555555555')->notify(new registrationValidation($verificationData));

        return redirect()->action([user_validation::class, 'display_unverified_user']);
    }
}
