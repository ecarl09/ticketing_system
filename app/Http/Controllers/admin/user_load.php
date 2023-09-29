<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class user_load extends Controller{

    public function user_display_all(){   
        $data =  User::all();
        return view('admin/user_load', ['users' => $data]);
    }
}
