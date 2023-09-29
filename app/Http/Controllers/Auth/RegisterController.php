<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\registrationValidation;

class RegisterController extends Controller 
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data){
        return Validator::make($data, [
            'firstName'   => ['required', 'string', 'max:255'],
            'middleName'  => ['required', 'string', 'max:255'],
            'lastName'    => ['required', 'string', 'max:255'],
            'gender'      => ['required', 'string', 'max:10'],
            'birthday'    => ['required', 'string', 'max:15'],
            'civilStatus' => ['required', 'string', 'max:25'],
            'chapter'     => ['required', 'string', 'max:100'],
            'position'    => ['required', 'string', 'max:100'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'number'      => ['required', 'string', 'min:11', 'max:11', 'unique:users'],
            'password'    => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data){

        $this->sendNotification($data['firstName'], $data['lastName'], $data['chapter']);

        return User::create([
            'firstName'       => $data['firstName'],
            'middleName'      => $data['middleName'],
            'lastName'        => $data['lastName'],
            'gender'          => $data['gender'],
            'birthday'        => $data['birthday'],
            'civilStatus'     => $data['civilStatus'],
            'address'         => $data['address'],
            'chapterName'     => $data['chapter'],
            'position'        => $data['position'],
            'email'           => $data['email'],
            'number'          => $data['number'],
            'password'        => Hash::make($data['password']),
            'userType'        => '1',
            'userStatus'      => 'ACTIVE',
            'isFirstLogin'    => 'NO',
            'userCategory'    => 'CHAPTER',
            'profile_picture' => 'men.svg',
            'isVerified'      => 'NO',
        ]);
    }

    public function sendNotification($firstName, $lastName, $chapter){
        $admin = User::where('userType', '0')->get();

        $verificationData =[
            'subject'          => 'IT SUPPORT: MEMBER LOGIN REQUEST',
            'greetings'        => 'Good Day System Admin!',
            'body'             => ucwords($firstName).' '.ucwords($lastName).' from '.$chapter.' has been requesting access to the IT SUPPORT website.',
            'body2'            => '',
            'notificationText' => 'View and verify',
            'url'              => url('/validate-user'),
            'thankyou'         => 'This is a system-generated message. Please do not reply to this email.',
        ];

        // Notification::route('mail', 'jestreecarl@gmail.com')->route('nexmo', '5555555555')->notify(new registrationValidation($verificationData));
        Notification::send($admin, new registrationValidation($verificationData));
    }
}
