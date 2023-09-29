<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket_status extends Model
{
    use HasFactory;
    public $table="ticket_status";

    public function getCreatedatAttribute($value){
        $date = date($value);
        return date('F d, Y | h:i:s A', strtotime($date));
    }

    
}
