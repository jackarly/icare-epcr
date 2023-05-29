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

    public function user_admin()
    {
        return $this->hasOne(UserAdmin::class);
    }

    public function user_ambulance()
    {
        return $this->hasOne(UserAmbulance::class);
    }

    public function user_comcen()
    {
        return $this->hasOne(UserComcen::class);
    }

    public function user_hospital()
    {
        return $this->hasOne(UserHospital::class);
    }

    // public function setDefaultUsername($data, $usertype)
    public static function setDefaultUsername($value)
    {
        // switch($usertype) 
        // {
        //     case('hospital'):
        //         break;

        //     case('comcen'):
        //         break;

        //     case('admin'):
        //         break;

        //     default:
        //         $msg = 'Something went wrong.';
        // }
        // return $this->hasMany(Patient::class);

        $firstName = $value['first_name'];
        $lastName = strtolower($value['last_name']);

        $username = $firstName[0] . $lastName;

        $i = 0;
        while(User::whereUsername($username)->exists())
        {
            $i++;
            $username = $firstName[0] . $lastName . $i;
        }

        return $value['username'] = $username;

    }

    // public function userInfo(User $user)
    // {
    //     return $this->user_ambulance->contains('user_id', $user->id);
    // }

}
