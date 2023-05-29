<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserAmbulance;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($user_type = null)
    {
        // $accounts = User::all();
        
        // dd($account->username);
        // dd($accounts);

        switch($user_type) {
            case('ambulance'):
                $accounts = User::where('user_type', $user_type)->latest()->with(['user_ambulance'])->paginate(12);
                break;

            case('hospital'):
                $accounts = User::where('user_type', $user_type)->latest()->with(['user_hospital'])->paginate(12);
                break;

            case('comcen'):
                $accounts = User::where('user_type', $user_type)->latest()->with(['user_comcen'])->paginate(12);
                break;

            case('admin'):
                $accounts = User::where('user_type', $user_type)->latest()->with(['user_admin'])->paginate(12);
                break;

            default:
                $accounts = User::latest()->with(['user_admin', 'user_ambulance', 'user_comcen', 'user_hospital'])->paginate(12);
        }

        return view('auth.index', [
            'accounts' => $accounts,
            'user_type' => $user_type,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($userType = 'ambulance')
    {
        // $user_type = 'ambulance';

        return view('auth.register', [
            'user_type' => $userType,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        switch($request->user_type) {
            case('ambulance'):
                $this->validate($request, [
                    'username' => 'required|string|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                    'plate_no' => 'required|string|max:16', 
                ]);
                $user = User::create([
                    'username' => $request->username,
                    'password'  => Hash::make($request->password),  
                    'user_type' => $request->user_type,
                ]);
                $user->user_ambulance()->create([
                    'plate_no' => strtoupper($request->plate_no),
                ]);
                break;

            case('hospital'):
                $this->validate($request, [
                    'username' => 'required|string|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                    'hospital_name' => 'string|string|max:255',
                    'hospital_abbreviation' => 'string|string|max:255',
                    'hospital_address' => 'string|string|max:255',
                    'email' =>  'string|email|max:255',
                    'contact_1' => 'required|numeric|max_digits:11',
                    'contact_2' => 'numeric|max_digits:11',
                ]);
                $user = User::create([
                    'username' => $request->username,
                    'password'  => Hash::make($request->password), 
                    'user_type' => $request->user_type,
                ]);
                $user->user_hospital()->create([
                    'hospital_name' => $request->hospital_name,
                    'hospital_abbreviation' => $request->hospital_abbreviation,
                    'hospital_address' => $request->hospital_address,
                    'email' => $request->email,
                    'contact_1' => $request->contact_1,
                    'contact_2' => $request->contact_2,
                ]);
                break;

            case('comcen'):
                $this->validate($request, [
                    'username' => 'required|string|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                    'first_name' => 'required|string|max:255', 
                    'mid_name' => 'string|max:255', 
                    'last_name' => 'required|string|max:255', 
                    'email' =>  'string|email|max:255',
                    'contact_1' => 'required|numeric|max_digits:11',
                ]);
                $user = User::create([
                    'username' => $request->username,
                    'password'  => Hash::make($request->password),  
                    'user_type' => $request->user_type,
                ]);
                $user->user_comcen()->create([
                    'first_name' => $request->first_name,
                    'mid_name' => $request->mid_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'contact_1' => $request->contact_1,
                ]);
                break;

            case('admin'):
                $this->validate($request, [
                    'username' => 'required|string|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                    'first_name' => 'required|string|max:255', 
                    'mid_name' => 'string|max:255', 
                    'last_name' => 'required|string|max:255', 
                    'email' =>  'string|email|max:255',
                    'contact_1' => 'required|numeric|max_digits:11',
                ]);
                $user = User::create([
                    'username' => $request->username,
                    'password'  => Hash::make($request->password), 
                    'user_type' => $request->user_type,
                ]);
                $user->user_admin()->create([
                    'first_name' => $request->first_name,
                    'mid_name' => $request->mid_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'contact_1' => $request->contact_1,
                ]);
                break;

            default:
                dd('Something went wrong.');
        }
        return redirect()->route('account.overview');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $account = User::find($id);
        // dd($account->username);

        return view('auth.show', [
            'account' => $account,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    /**
     * Display the specified resource.
     */
    public function showMyAccount()
    {
        $account = Auth::user();
        // dd($account->username);

        return view('auth.show', [
            'account' => $account,
        ]);
    }
}
