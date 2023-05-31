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

    public function personnel()
    {
        return $this->hasMany(Personnel::class);
    }

    public function response_teams()
    {
        return $this->belongsTo(ResponseTeam::class);
    }
}
