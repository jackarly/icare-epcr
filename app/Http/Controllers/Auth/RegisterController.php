<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' =>   ['required', 'string', 'max:255', 'unique:users'],
            'password' =>   ['required', 'string', 'min:8', 'confirmed'],
            'email' =>      ['string', 'email', 'max:255'],

            'contact_1' =>  ['required', 'numeric', 'max_digits:11'],
            'contact_2' =>  ['numeric', 'max_digits:11'],

            'plate_no' =>   ['required', 'string', 'max:16'], 

            'first_name' => ['required', 'string', 'max:255'], 
            'mid_name' =>   ['string', 'max:255'], 
            'last_name' =>  ['required', 'string', 'max:255'], 

            'hospital_name' =>      ['string', 'string', 'max:255'],
            'hospital_address' =>   ['string', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // dd('okay');

        return User::create([
            'username' =>   $data['username'],
            'password' =>   Hash::make($data['password']),
            'email' =>      $data['email'],

            'user_type' =>  'admin',

            'contact_1' =>  $data['contact_1'],
            'contact_2' =>  $data['contact_2'],
            
            'plate_no' =>   $data['plate_no'],

            'first_name' => $data['first_name'],
            'mid_name' =>   $data['mid_name'],
            'last_name' =>  $data['last_name'],
            
            'hospital_name' =>      $data['hospital_name'],
            'hospital_address' =>   $data['hospital_address'],
        ]);
    }
}
