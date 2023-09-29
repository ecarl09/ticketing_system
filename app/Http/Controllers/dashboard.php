<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\users\users_dashboard;
use App\Http\Controllers\admin\admin_dashboard;
use App\Http\Controllers\admin\technical_support;

class dashboard extends Controller{

    public function loadDashBoard(){
        if(Auth::user()['isFirstLogin'] == 'YES'){
            return redirect()->action([resetInitialPassword::class, 'initial_password']);
        }else if(Auth::user()['isVerified'] == 'NO'){
            return view('auth/userValidation');
        }else{
            if(Auth::user()['userType'] == '0'){
                return redirect()->action([admin_dashboard::class, 'dashboard']);
            }else{
                return redirect()->action([users_dashboard::class, 'dashboard']);
            }
        }
    }

}
