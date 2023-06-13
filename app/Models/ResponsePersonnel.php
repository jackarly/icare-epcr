<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Personnel;
use App\Models\ResponseTeam;

class ResponsePersonnel extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_team_id',    
        'personnel_id', 
    ];

    // Set response personnel and personnel relationship
    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }

    // Set response personnel and response team relationship
    public function response_teams()
    {
        return $this->belongsTo(ResponseTeam::class);
    }
}
