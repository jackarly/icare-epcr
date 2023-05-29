<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserComcen extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'mid_name',  
        'last_name', 
        'email',    
        'contact_1',      
        'user_id',  
    ];
}
