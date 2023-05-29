<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospital_name',   
        'hospital_abbreviation',   
        'hospital_address', 
        'email',  
        'contact_1', 
        'contact_2',    
        'user_id',  
    ];
}
