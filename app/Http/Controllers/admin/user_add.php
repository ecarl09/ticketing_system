<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\registrationNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class user_add extends Controller{
    //
    public function add_user_form(){
        return view("admin/user_add");
    }

    public function submit_registration_form(Request $value){
        $value->validate([
            'firstName'     => 'required',
            'middleName'    => 'required',
            'lastName'      => 'required',
            'gender'        => 'required',
            'birthday'      => 'required',
            'civilStatus'   => 'required',
            'chapter'       => 'required',
            'position'      => 'required',
            'address'       => 'required',
            'contactNumber' => 'min:11 | max:11 | required',
            'email'         => 'email | required',
            'password'      => 'min:8 | required',
            'userType'      => 'required',
        ]);

        $isExist = User::where('email', $value->email)->get();

        if(!$isExist->isEmpty()){
            session()->flash('existing', 'true');
            return redirect()->action([user_add::class, 'add_user_form']);
        }else{
            $userCategory = '';
            if($value->userType === '0'){$userCategory = 'ADMIN';
            }else{ $userCategory = 'CHAPTER';}

            $user                = new User;
            $user ->firstName    = $value->firstName;
            $user ->middleName   = $value->middleName;
            $user ->lastName     = $value->lastName;
            $user ->gender       = $value->gender;
            $user ->birthday     = $value->birthday;
            $user ->civilStatus  = $value->civilStatus;
            $user ->chapterName  = $value->chapter;
            $user ->position     = $value->position;
            $user ->userType     = $value->userType;
            $user ->userCategory = $userCategory;
            $user ->userStatus   = 'ACTIVE';
            $user ->isFirstLogin = 'YES';
            $user ->isVerified   = 'YES';
            $user ->address      = $value->address;
            $user ->email        = $value->email;
            $user ->number       = $value->contactNumber;
            $user ->password     = Hash::make($value->password);
            $user ->profile_picture = 'men.svg';
            $user->save();

            session()->flash('saved', 'true');
            $this->send_confirmation($value->firstName, $value->email, $value->password);
            return redirect()->action([user_add::class, 'add_user_form']);  
        }


    }

    public function send_confirmation($name, $email, $password){
        $registrationData = [
            'subject'          => 'FEDCIS IT SUPPORT: NEW USER ACCOUNT',
            'greetings'        => 'Hello '.ucwords($name),
            'body'             => 'A new account has been created for you at FEDCIS IT SUPPORT website and you have been issued with a new temporary password.',
            'body0'            => '',
            'body1'            => 'Your current login information is:',
            'body2'            => 'User name: '.$email,
            'body3'            => 'Password: '.$password,
            'notificationText' => 'LOGIN',
            'url'              => url('/'),
            'thankyou'         => 'This is a system-generated message. Please do not reply to this email.'
        ];
        
        //send to a specific users or email
        //queue has been implemented in this notification
        // run php artisan queue:work
        Notification::route('mail', $email)->route('nexmo', '5555555555')->notify(new registrationNotification($registrationData));
    }
}
