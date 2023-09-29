<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class user_account extends Controller{

    public function account(){
        // $data = User::where('id', Auth::user()['id'])->get();
        $data = User::find(Auth::user()['id']);
        return view('admin/user_account', ['user' => $data]);
    }

    public function get_user_details_to_update(){
        $data = User::find(Auth::user()['id']);
        return view('admin/user_account_update', ['user' => $data]);
    }

    public function update_user_account_form(Request $value){
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
        ]);

        $data = User::find(Auth::user()['id']);
        $data ->firstName   = $value->firstName;
        $data ->middleName  = $value->middleName;
        $data ->lastName    = $value->lastName;
        $data ->gender      = $value->gender;
        $data ->birthday    = $value->birthday;
        $data ->civilStatus = $value->civilStatus;
        $data ->chapterName = $value->chapter;
        $data ->position    = $value->position;
        $data ->address     = $value->address;
        $data ->email       = $value->email;
        $data ->number      = $value->contactNumber;
        $data->save();

        session()->flash('updated', 'true');
        return redirect()->action([user_account::class, 'account']);
    }

    public function update_password(){
        return view('admin/user_update_password');
    }

    public function update_password_submit(Request $value){
        $value->validate([
            'currentPassword' => 'required',
            'newPassword'     => 'same:confirmPassword|min:8|required',
            'confirmPassword' => 'required',
        ]);

        if(!Hash::check($value->currentPassword, auth()->user()->password)){
            session()->flash('notMatch', 'true');
            return back();
        }else{
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($value->newPassword)
            ]);

            session()->flash('updated', 'true');
            return back();
        }
    }

    public function uploadProfilePicture(Request $value){
        
        if($files = $value->file('file')){
            $destination_path = 'public/profile_picture';
            $file_name = time() .'-'. $files->getClientOriginalName();
            $files->storeAs($destination_path, $file_name );

            DB::table('users')->where('id', Auth::user()['id'])->update(['profile_picture' => $file_name]);
        }
        return back();
    }
}
