<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResponseTeam;

class Personnel extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'personnel_first_name',
        'personnel_mid_name',
        'personnel_last_name',
        'personnel_other',
        'contact',
        'birthday',
        'sex', 
        'personnel_img',
    ];

    public function response_teams()
    {
        return $this->hasMany(ResponseTeam::class);
    }

    public function medicStatus()
    {
        $id = 1;

    
        return $this->hasOne(UserHospital::class);
    }
}
