<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserAdmin;
use App\Models\UserAmbulance;
use App\Models\UserComcen;
use App\Models\UserHospital;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',  
        'email',    
        'user_type',    
        'status', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at','datetime',
    ];

    // Set user and admin relationship
    public function user_admin()
    {
        return $this->hasOne(UserAdmin::class);
    }

    // Set user and ambulance relationship
    public function user_ambulance()
    {
        return $this->hasOne(UserAmbulance::class);
    }

    // Set user and comcen relationship
    public function user_comcen()
    {
        return $this->hasOne(UserComcen::class);
    }

    // Set user and hospital relationship
    public function user_hospital()
    {
        return $this->hasOne(UserHospital::class);
    }

}
