<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\users\users_dashboard;
use App\Http\Controllers\admin\admin_dashboard;

class resetInitialPassword extends Controller{

    public function initial_password(){
        return view('auth/resetPassword');
    }

    public function update_password_submit(Request $value){
        $value->validate([
            'newPassword'     => 'same:confirmPassword|min:8|required',
            'confirmPassword' => 'required',
        ]);

        User::whereId(auth()->user()->id)->update([
            'isFirstLogin' => 'NO',
            'password' => Hash::make($value->newPassword)
        ]);

        if(Auth::user()['userType'] == '0'){
            return redirect()->action([admin_dashboard::class, 'dashboard']);
        }else{
            return redirect()->action([users_dashboard::class, 'dashboard']);
        }
    }
}
