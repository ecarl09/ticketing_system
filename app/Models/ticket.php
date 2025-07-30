<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ticket_status;
use App\Models\User;

class ticket extends Model{
    use HasFactory;
    public $table="tickets";
}
