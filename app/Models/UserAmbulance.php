<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResponseTeam;

class UserAmbulance extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_no',
        'user_id',  
    ];

    public function response_team()
    {
        return $this->hasOne(ResponseTeam::class);
    }
}
