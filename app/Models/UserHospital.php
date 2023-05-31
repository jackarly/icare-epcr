<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public static function dashboardEnrouteToday() 
    {   
        $hospital = Auth::user()->user_hospital;
        
        return $incidents =  DB::table('patient_managements')
        ->join('user_hospitals', 'patient_managements.user_hospital_id', '=', 'user_hospitals.id')
        ->join('patients', 'patient_managements.patient_id', '=', 'patients.id')
        ->where('user_hospitals.id', '=', $hospital->id)
        ->whereDate('patients.created_at', Carbon::today())
        ->whereNull('patients.completed_at')
        ->count();
    }

    public static function dashboardCompletedToday() 
    {   
        $hospital = Auth::user()->user_hospital;
        
        return $incidents =  DB::table('patient_managements')
        ->join('user_hospitals', 'patient_managements.user_hospital_id', '=', 'user_hospitals.id')
        ->join('patients', 'patient_managements.patient_id', '=', 'patients.id')
        ->where('user_hospitals.id', '=', $hospital->id)
        ->whereDate('patients.created_at', Carbon::today())
        ->whereNotNull('patients.completed_at')
        ->count();
    }

    public static function dashboardCompletedOverall() 
    {   
        $hospital = Auth::user()->user_hospital;
        
        return $incidents =  DB::table('patient_managements')
        ->join('user_hospitals', 'patient_managements.user_hospital_id', '=', 'user_hospitals.id')
        ->join('patients', 'patient_managements.patient_id', '=', 'patients.id')
        ->where('user_hospitals.id', '=', $hospital->id)
        ->whereNotNull('patients.completed_at')
        ->count();
    }
}
