<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserAmbulance;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    public function index(Request $request, $user_type = null)
    {

        $searchKeyword = null;

        // Check if form search query
        if ($request->searchedQuery) {
            
            // Set search keywords & status
            $searchKeyword = $request->search_name;
            $user_type = $request->status;

            // Only allow logged on comcen or admin; else redirect to error page
            if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
                // Show all accounts to admin
                if (Auth::user()->user_type == 'admin'){
                    // Get accounts by user_type
                    switch($user_type) {
                        case('ambulance'):
                            // $accounts = User::where('user_type', $user_type)->latest()->with(['user_ambulance'])->paginate(12);
                            $accounts = DB::table('users')
                                ->join('user_ambulances', 'users.id', '=', 'user_ambulances.user_id')
                                ->where('users.username', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_ambulances.plate_no', 'like', '%'.$searchKeyword.'%')
                                ->select('users.*', 'user_ambulances.plate_no')
                                ->latest('users.created_at')
                                ->paginate(12);
                            break;
            
                        case('hospital'):
                            // $accounts = User::where('user_type', $user_type)->latest()->with(['user_hospital'])->paginate(12);
                            $accounts = DB::table('users')
                                ->join('user_hospitals', 'users.id', '=', 'user_hospitals.user_id')
                                ->where('users.username', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_abbreviation', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_address', 'like', '%'.$searchKeyword.'%')
                                ->select('users.*', 'user_hospitals.hospital_name', 'user_hospitals.hospital_abbreviation', 'user_hospitals.hospital_address')
                                ->latest('users.created_at')
                                ->paginate(12);
                            break;
            
                        case('comcen'):
                            // $accounts = User::where('user_type', $user_type)->latest()->with(['user_comcen'])->paginate(12);
                            $accounts = DB::table('users')
                                ->join('user_comcens', 'users.id', '=', 'user_comcens.user_id')
                                ->where('users.username', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_comcens.first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_comcens.mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_comcens.last_name', 'like', '%'.$searchKeyword.'%')
                                ->select('users.*', 'user_comcens.first_name as comcen_first_name', 'user_comcens.mid_name as comcen_mid_name', 'user_comcens.last_name as comcen_last_name')
                                ->latest('users.created_at')
                                ->paginate(12);
                            break;
            
                        case('admin'):
                            // $accounts = User::where('user_type', $user_type)->latest()->with(['user_admin'])->paginate(12);
                            $accounts = DB::table('users')
                                ->join('user_admins', 'users.id', '=', 'user_admins.user_id')
                                ->where('users.username', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_admins.first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_admins.mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_admins.last_name', 'like', '%'.$searchKeyword.'%')
                                ->select('users.*', 'user_admins.first_name', 'user_admins.mid_name', 'user_admins.last_name')
                                ->latest('users.created_at')
                                ->paginate(12);
                            break;
            
                        default:
                            // $accounts = User::latest()->with(['user_admin', 'user_ambulance', 'user_comcen', 'user_hospital'])->paginate(12);
                            $accounts = DB::table('users')
                                ->leftJoin('user_ambulances', 'users.id', '=', 'user_ambulances.user_id')
                                ->leftJoin('user_hospitals', 'users.id', '=', 'user_hospitals.user_id')
                                ->leftJoin('user_comcens', 'users.id', '=', 'user_comcens.user_id')
                                ->leftJoin('user_admins', 'users.id', '=', 'user_admins.user_id')
                                ->where('users.username', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_ambulances.plate_no', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_abbreviation', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_address', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_comcens.first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_comcens.mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_comcens.last_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_admins.first_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_admins.mid_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_admins.last_name', 'like', '%'.$searchKeyword.'%')
                                ->select('users.*', 'user_ambulances.plate_no', 'user_hospitals.hospital_name', 'user_hospitals.hospital_abbreviation', 'user_hospitals.hospital_address', 'user_comcens.first_name as comcen_first_name', 'user_comcens.mid_name as comcen_mid_name', 'user_comcens.last_name as comcen_last_name', 'user_admins.first_name', 'user_admins.mid_name', 'user_admins.last_name')
                                ->latest('users.created_at')
                                ->paginate(12);
                            $user_type = 'all users';
                    }
                // Show only ambulance & hospital accounts to comcen
                }else{
                    // Get accounts by user_type
                    switch($user_type) {
                        case('ambulance'):
                            // $accounts = User::where('user_type', $user_type)->latest()->with(['user_ambulance'])->paginate(12);
                            $accounts = DB::table('users')
                                ->join('user_ambulances', 'users.id', '=', 'user_ambulances.user_id')
                                ->where('users.username', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_ambulances.plate_no', 'like', '%'.$searchKeyword.'%')
                                ->select('users.*', 'user_ambulances.plate_no')
                                ->latest('users.created_at')
                                ->paginate(12);
                            break;
            
                        case('hospital'):
                            // $accounts = User::where('user_type', $user_type)->latest()->with(['user_hospital'])->paginate(12);
                            $accounts = DB::table('users')
                                ->join('user_hospitals', 'users.id', '=', 'user_hospitals.user_id')
                                ->where('users.username', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_abbreviation', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_address', 'like', '%'.$searchKeyword.'%')
                                ->select('users.*', 'user_hospitals.hospital_name', 'user_hospitals.hospital_abbreviation', 'user_hospitals.hospital_address')
                                ->latest('users.created_at')
                                ->paginate(12);
                            break;
            
                        default:
                            // $accounts = User::whereIN('user_type', ['ambulance', 'hospital'])->latest()->with(['user_admin', 'user_ambulance', 'user_comcen', 'user_hospital'])->paginate(12);
                            $accounts = DB::table('users')
                                ->leftJoin('user_ambulances', 'users.id', '=', 'user_ambulances.user_id')
                                ->leftJoin('user_hospitals', 'users.id', '=', 'user_hospitals.user_id')
                                ->where('users.user_type', '=', 'ambulance')
                                ->orWhere('users.user_type', '=', 'hospital')
                                ->where('users.username', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_ambulances.plate_no', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_name', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_abbreviation', 'like', '%'.$searchKeyword.'%')
                                ->orWhere('user_hospitals.hospital_address', 'like', '%'.$searchKeyword.'%')
                                ->select('users.*', 'user_ambulances.plate_no', 'user_hospitals.hospital_name', 'user_hospitals.hospital_abbreviation', 'user_hospitals.hospital_address')
                                ->latest('users.created_at')
                                ->paginate(12);
                            // dd($accounts);
                            $user_type = 'all users';
                    }
                }
                
                return view('auth.index', [
                    'accounts' => $accounts,
                    'user_type' => $user_type,
                ]);
            }
            else{
                return view('errors.404');
            }
        } else {
            // Only allow logged on comcen or admin; else redirect to error page
            if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
                // Show all accounts to admin
                if (Auth::user()->user_type == 'admin'){
                    // Get accounts by user_type
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
                            $user_type = 'all users';
                    }
                // Show only ambulance & hospital accounts to comcen
                }else{
                    // Get accounts by user_type
                    switch($user_type) {
                        case('ambulance'):
                            $accounts = User::where('user_type', $user_type)->latest()->with(['user_ambulance'])->paginate(12);
                            break;
            
                        case('hospital'):
                            $accounts = User::where('user_type', $user_type)->latest()->with(['user_hospital'])->paginate(12);
                            break;
            
                        default:
                            $accounts = User::whereIN('user_type', ['ambulance', 'hospital'])->latest()->with(['user_admin', 'user_ambulance', 'user_comcen', 'user_hospital'])->paginate(12);
                            $user_type = 'all users';
                    }
                }
                
                return view('auth.index', [
                    'accounts' => $accounts,
                    'user_type' => $user_type,
                ]);
            }
            else{
                return view('errors.404');
            }
        }
    }

    public function create($userType = 'ambulance')
    {   
        // Set default to ambulance
        if ($userType == 'all users'){
            $userType = 'ambulance';
        }

        // Only allow comcen or admin account; else redirect to error page
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')) {
            return view('auth.register', [
                'user_type' => $userType,
            ]);
        }
        else{
            return view('errors.404');
        }
        
    }

    public function store(Request $request)
    {
        // Only allow comcen or admin account; else redirect to error page
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')) {
            // Check if default_user is true, set username as password, else set inputted password
            if($request->default_user){
                // Check which user_type to store
                switch($request->user_type) {
                    case('ambulance'):
                        $this->validate($request, [
                            'username' => 'required|string|max:255|unique:users',
                            'plate_no' => 'required|string|max:16', 
                        ]);
                        $user = User::create([
                            'username' => $request->username,
                            'password'  => Hash::make($request->username),  
                            'user_type' => $request->user_type,
                        ]);
                        $user->user_ambulance()->create([
                            'plate_no' => strtoupper($request->plate_no),
                        ]);
                        break;
    
                    case('hospital'):
                        $this->validate($request, [
                            'username' => 'required|string|max:255|unique:users',
                            'hospital_name' => 'string|string|max:255',
                            'hospital_abbreviation' => 'string|string|max:255',
                            'hospital_address' => 'string|string|max:255',
                            'email' =>  'string|email|max:255',
                            'contact_1' => 'required|numeric|max_digits:11',
                            'contact_2' => 'numeric|max_digits:11',
                        ]);
                        $user = User::create([
                            'username' => $request->username,
                            'password'  => Hash::make($request->username), 
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
                        if (Auth::user()->user_type == 'admin'){
                            $this->validate($request, [
                                'username' => 'required|string|max:255|unique:users',
                                'first_name' => 'required|string|max:255', 
                                'mid_name' => 'nullable|string|max:255', 
                                'last_name' => 'required|string|max:255', 
                                'email' =>  'string|email|max:255',
                                'contact_1' => 'required|numeric|max_digits:11',
                            ]);
                            $user = User::create([
                                'username' => $request->username,
                                'password'  => Hash::make($request->username),  
                                'user_type' => $request->user_type,
                            ]);
                            $user->user_comcen()->create([
                                'first_name' => $request->first_name,
                                'mid_name' => $request->mid_name,
                                'last_name' => $request->last_name,
                                'email' => $request->email,
                                'contact_1' => $request->contact_1,
                            ]);
                        }
                        else{
                            return view('errors.404');
                        }
                        break;
    
                    case('admin'):
                        if (Auth::user()->user_type == 'admin'){
                            $this->validate($request, [
                                'username' => 'required|string|max:255|unique:users',
                                'first_name' => 'required|string|max:255', 
                                'mid_name' => 'nullable|string|max:255', 
                                'last_name' => 'required|string|max:255', 
                                'email' =>  'string|email|max:255',
                                'contact_1' => 'required|numeric|max_digits:11',
                            ]);
                            $user = User::create([
                                'username' => $request->username,
                                'password'  => Hash::make($request->username), 
                                'user_type' => $request->user_type,
                            ]);
                            $user->user_admin()->create([
                                'first_name' => $request->first_name,
                                'mid_name' => $request->mid_name,
                                'last_name' => $request->last_name,
                                'email' => $request->email,
                                'contact_1' => $request->contact_1,
                            ]);
                        }
                        else{
                            return view('errors.404');
                        }
                        break;
    
                    default:
                        dd('Something went wrong.');
                }
            }else{
                // Check which user_type to store
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
                        if (Auth::user()->user_type == 'admin'){
                            $this->validate($request, [
                                'username' => 'required|string|max:255|unique:users',
                                'password' => 'required|string|min:8|confirmed',
                                'first_name' => 'required|string|max:255', 
                                'mid_name' => 'nullable|string|max:255', 
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
                        }
                        else{
                            return view('errors.404');
                        }
                        break;
    
                    case('admin'):
                        if (Auth::user()->user_type == 'admin'){
                            $this->validate($request, [
                                'username' => 'required|string|max:255|unique:users',
                                'password' => 'required|string|min:8|confirmed',
                                'first_name' => 'required|string|max:255', 
                                'mid_name' => 'nullable|string|max:255', 
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
                        }
                        else{
                            return view('errors.404');
                        }
                        break;
    
                    default:
                        return view('errors.404');
                }
            }
            return redirect()->route('account.overview')->with('success', 'User added successfully');
        }
        else{
            return view('errors.404');
        }
        
    }

    public function show(string $id)
    {
        // Only allow logged on comcen or admin accounts; else redirect to error page
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
            // Check if logged on is admin
            // Allow admin to view all account types
            if (Auth::user()->user_type == 'admin'){
                $account = User::find($id);
                return view('auth.show', [
                    'account' => $account,
                ]);
            }
            // Check if logged on is comcen
            else{
                $account = User::find($id);
                // Only allow comcen to view ambulance and hospital accounts
                if (($account->user_type == 'admin') || ($account->user_type == 'comcen')){
                    return view('errors.404');
                }else{
                    return view('auth.show', [
                        'account' => $account,
                    ]);
                }
            }
            
        }
        else{
            return view('errors.404');
        }
        
    }

    public function editAmbulance(User $user)
    {
        // Only allow logged on comcen or admin accounts; else redirect to error page
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
            $ambulance = $user->user_ambulance()->first();
            
            return view('account.edit-ambulance', [
                'account' => $user,
                'ambulance' => $ambulance,
            ]);
        }
        else{
            return view('errors.404');
        }
        
    }

    public function updateAmbulance(Request $request, User $user)
    {
        // Only allow logged on comcen or admin accounts; else redirect to error page
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
            if($request->default_user){
                $this->validate($request, [
                    "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                    'plate_no' => 'required|string|max:16', 
                ]);
                $user->update([
                    'username' => $request->username,
                    'password'  => Hash::make($request->username),  
                ]);
                $user->user_ambulance()->update([
                    'plate_no' => strtoupper($request->plate_no),
                ]);
            }else{
                $this->validate($request, [
                    "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                    'password' => 'required|string|min:8|confirmed',
                    'plate_no' => 'required|string|max:16', 
                ]);
                $user->update([
                    'username' => $request->username,
                    'password'  => Hash::make($request->password),  
                ]);
                $user->user_ambulance()->update([
                    'plate_no' => strtoupper($request->plate_no),
                ]);
            }
            return redirect()->route('account.show', $user->id)->with('success', 'Account updated successfully');
        }
        else{
            return view('errors.404');
        }
        
    }

    public function editHospital(User $user)
    {
        // Only allow logged on comcen or admin accounts; else redirect to error page
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
            $hospital = $user->user_hospital()->first();
            return view('account.edit-hospital', [
                'account' => $user,
                'hospital' => $hospital,
            ]);
        }
        else{
            return view('errors.404');
        }
        
    }
    
    public function updateHospital(Request $request, User $user)
    {
        // Only allow logged on comcen or admin accounts; else redirect to error page
        if ((Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin')){
            // Check if default_user is true, set username as password, else set inputted password
            if($request->default_user){
                $this->validate($request, [
                    "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                    'hospital_name' => 'string|string|max:255',
                    'hospital_abbreviation' => 'string|string|max:255',
                    'hospital_address' => 'string|string|max:255',
                    'email' =>  'string|email|max:255',
                    'contact_1' => 'required|numeric|max_digits:11',
                    'contact_2' => 'numeric|max_digits:11',
                ]);
                $user->update([
                    'username' => $request->username,
                    'password'  => Hash::make($request->username), 
                ]);
                $user->user_hospital()->update([
                    'hospital_name' => $request->hospital_name,
                    'hospital_abbreviation' => $request->hospital_abbreviation,
                    'hospital_address' => $request->hospital_address,
                    'email' => $request->email,
                    'contact_1' => $request->contact_1,
                    'contact_2' => $request->contact_2,
                ]);
            }else{
                $this->validate($request, [
                    "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                    'password' => 'required|string|min:8|confirmed',
                    'hospital_name' => 'string|string|max:255',
                    'hospital_abbreviation' => 'string|string|max:255',
                    'hospital_address' => 'string|string|max:255',
                    'email' =>  'string|email|max:255',
                    'contact_1' => 'required|numeric|max_digits:11',
                    'contact_2' => 'numeric|max_digits:11',
                ]);
                $user->update([
                    'username' => $request->username,
                    'password'  => Hash::make($request->password), 
                ]);
                $user->user_hospital()->update([
                    'hospital_name' => $request->hospital_name,
                    'hospital_abbreviation' => $request->hospital_abbreviation,
                    'hospital_address' => $request->hospital_address,
                    'email' => $request->email,
                    'contact_1' => $request->contact_1,
                    'contact_2' => $request->contact_2,
                ]);
            }
            return redirect()->route('account.show', $user->id)->with('success', 'Account updated successfully');
        }
        else{
            return view('errors.404');
        }
        
    }

    public function editComcen(User $user)
    {
        // Only allow logged on admin accounts; else redirect to error page
        if (Auth::user()->user_type == 'admin'){
            $comcen = $user->user_comcen()->first();

            return view('account.edit-comcen', [
                'account' => $user,
                'comcen' => $comcen,
            ]);
        }
        else{
            return view('errors.404');
        }
        
    }

    public function updateComcen(Request $request, User $user)
    {
        // Only allow logged on admin accounts; else redirect to error page
        if (Auth::user()->user_type == 'admin'){
            // Check if default_user is true, set username as password, else set inputted password
            if($request->default_user){
                $this->validate($request, [
                    "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                    'first_name' => 'required|string|max:255', 
                    'mid_name' => 'string|max:255', 
                    'last_name' => 'required|string|max:255', 
                    'email' =>  'string|email|max:255',
                    'contact_1' => 'required|numeric|max_digits:11',
                ]);
                $user->update([
                    'username' => $request->username,
                    'password'  => Hash::make($request->username),  
                ]);
                $user->user_comcen()->update([
                    'first_name' => $request->first_name,
                    'mid_name' => $request->mid_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'contact_1' => $request->contact_1,
                ]);
            }else{
                $this->validate($request, [
                    "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                    'password' => 'required|string|min:8|confirmed',
                    'first_name' => 'required|string|max:255', 
                    'mid_name' => 'string|max:255', 
                    'last_name' => 'required|string|max:255', 
                    'email' =>  'string|email|max:255',
                    'contact_1' => 'required|numeric|max_digits:11',
                ]);
                $user->update([
                    'username' => $request->username,
                    'password'  => Hash::make($request->password), 
                ]);
                $user->user_comcen()->update([
                    'first_name' => $request->first_name,
                    'mid_name' => $request->mid_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'contact_1' => $request->contact_1,
                ]);
            }
            return redirect()->route('account.show', $user->id)->with('success', 'Account updated successfully');
        }
        else{
            return view('errors.404');
        }
        
    }

    public function editAdmin(User $user)
    {
        // Only allow logged on admin accounts; else redirect to error page
        if (Auth::user()->user_type == 'admin'){
            $admin = $user->user_admin()->first();
            return view('account.edit-admin', [
                'account' => $user,
                'admin' => $admin,
            ]);
        }
        else{
            return view('errors.404');
        }
        
    }

    public function updateAdmin(Request $request, User $user)
    {
        // Only allow logged on admin accounts; else redirect to error page
        if (Auth::user()->user_type == 'admin'){
            // Check if default_user is true, set username as password, else set inputted password
            if($request->default_user){
                $this->validate($request, [
                    "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                    'first_name' => 'required|string|max:255', 
                    'mid_name' => 'string|max:255', 
                    'last_name' => 'required|string|max:255', 
                    'email' =>  'string|email|max:255',
                    'contact_1' => 'required|numeric|max_digits:11',
                ]);
                $user->update([
                    'username' => $request->username,
                    'password'  => Hash::make($request->username), 
                ]);
                $user->user_admin()->update([
                    'first_name' => $request->first_name,
                    'mid_name' => $request->mid_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'contact_1' => $request->contact_1,
                ]);
            }else{
                $this->validate($request, [
                    "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                    'password' => 'required|string|min:8|confirmed',
                    'first_name' => 'required|string|max:255', 
                    'mid_name' => 'string|max:255', 
                    'last_name' => 'required|string|max:255', 
                    'email' =>  'string|email|max:255',
                    'contact_1' => 'required|numeric|max_digits:11',
                ]);
                $user->update([
                    'username' => $request->username,
                    'password'  => Hash::make($request->password), 
                ]);
                $user->user_admin()->update([
                    'first_name' => $request->first_name,
                    'mid_name' => $request->mid_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'contact_1' => $request->contact_1,
                ]);
            }
            return redirect()->route('account.show', $user->id)->with('success', 'Account updated successfully');
        }
        else{
            return view('errors.404');
        }
        
    }

    public function showMyAccount()
    {
        // Show own account page
        $account = Auth::user();
        
        return view('auth.show', [
            'account' => $account,
        ]);
    }

    public function editMyAccount()
    {
        $user = Auth::user();

        // Check user_type then get details based on user_type
        switch ($user->user_type) {
            case 'ambulance':
                $ambulance = $user->user_ambulance()->first();
            
                return view('account.edit-ambulance', [
                    'account' => $user,
                    'ambulance' => $ambulance,
                ]);
                break;

            case 'hospital':
                $hospital = $user->user_hospital()->first();
                return view('account.edit-hospital', [
                    'account' => $user,
                    'hospital' => $hospital,
                ]);
                break;

            case 'comcen':
                $comcen = $user->user_comcen()->first();
                return view('account.edit-comcen', [
                    'account' => $user,
                    'comcen' => $comcen,
                ]);
                break;
            
            default:
                return view('errors.404');
                break;
        }

        return view('auth.show', [
            'account' => $account,
        ]);
    }

    public function updateMyAccount(Request $request)
    {
        $user = Auth::user();

        // Check user_type then update details based on user_type
        switch ($user->user_type) {
            case 'ambulance':
                // Check if default_user is true, set username as password, else set inputted password
                if($request->default_user){
                    $this->validate($request, [
                        "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                        'plate_no' => 'required|string|max:16', 
                    ]);
                    $user->update([
                        'username' => $request->username,
                        'password'  => Hash::make($request->username),  
                    ]);
                    $user->user_ambulance()->update([
                        'plate_no' => strtoupper($request->plate_no),
                    ]);
                }else{
                    $this->validate($request, [
                        "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                        'password' => 'required|string|min:8|confirmed',
                        'plate_no' => 'required|string|max:16', 
                    ]);
                    $user->update([
                        'username' => $request->username,
                        'password'  => Hash::make($request->password),  
                    ]);
                    $user->user_ambulance()->update([
                        'plate_no' => strtoupper($request->plate_no),
                    ]);
                }
                return redirect()->route('account.own', $user->id)->with('success', 'Account updated successfully');
                break;

            case 'hospital':
                // Check if default_user is true, set username as password, else set inputted password
                if($request->default_user){
                    $this->validate($request, [
                        "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                        'hospital_name' => 'string|string|max:255',
                        'hospital_abbreviation' => 'string|string|max:255',
                        'hospital_address' => 'string|string|max:255',
                        'email' =>  'string|email|max:255',
                        'contact_1' => 'required|numeric|max_digits:11',
                        'contact_2' => 'numeric|max_digits:11',
                    ]);
                    $user->update([
                        'username' => $request->username,
                        'password'  => Hash::make($request->username), 
                    ]);
                    $user->user_hospital()->update([
                        'hospital_name' => $request->hospital_name,
                        'hospital_abbreviation' => $request->hospital_abbreviation,
                        'hospital_address' => $request->hospital_address,
                        'email' => $request->email,
                        'contact_1' => $request->contact_1,
                        'contact_2' => $request->contact_2,
                    ]);
                }else{
                    $this->validate($request, [
                        "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                        'password' => 'required|string|min:8|confirmed',
                        'hospital_name' => 'string|string|max:255',
                        'hospital_abbreviation' => 'string|string|max:255',
                        'hospital_address' => 'string|string|max:255',
                        'email' =>  'string|email|max:255',
                        'contact_1' => 'required|numeric|max_digits:11',
                        'contact_2' => 'numeric|max_digits:11',
                    ]);
                    $user->update([
                        'username' => $request->username,
                        'password'  => Hash::make($request->password), 
                    ]);
                    $user->user_hospital()->update([
                        'hospital_name' => $request->hospital_name,
                        'hospital_abbreviation' => $request->hospital_abbreviation,
                        'hospital_address' => $request->hospital_address,
                        'email' => $request->email,
                        'contact_1' => $request->contact_1,
                        'contact_2' => $request->contact_2,
                    ]);
                }
                return redirect()->route('account.own', $user->id)->with('success', 'Account updated successfully');
                break;

            case 'comcen':
                // Check if default_user is true, set username as password, else set inputted password
                if($request->default_user){
                    $this->validate($request, [
                        "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                        'first_name' => 'required|string|max:255', 
                        'mid_name' => 'string|max:255', 
                        'last_name' => 'required|string|max:255', 
                        'email' =>  'string|email|max:255',
                        'contact_1' => 'required|numeric|max_digits:11',
                    ]);
                    $user->update([
                        'username' => $request->username,
                        'password'  => Hash::make($request->username),  
                    ]);
                    $user->user_comcen()->update([
                        'first_name' => $request->first_name,
                        'mid_name' => $request->mid_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'contact_1' => $request->contact_1,
                    ]);
                }else{
                    $this->validate($request, [
                        "username" => 'required|string|max:255|unique:users,id,'.$user->id,
                        'password' => 'required|string|min:8|confirmed',
                        'first_name' => 'required|string|max:255', 
                        'mid_name' => 'string|max:255', 
                        'last_name' => 'required|string|max:255', 
                        'email' =>  'string|email|max:255',
                        'contact_1' => 'required|numeric|max_digits:11',
                    ]);
                    $user->update([
                        'username' => $request->username,
                        'password'  => Hash::make($request->password), 
                    ]);
                    $user->user_comcen()->update([
                        'first_name' => $request->first_name,
                        'mid_name' => $request->mid_name,
                        'last_name' => $request->last_name,
                        'email' => $request->email,
                        'contact_1' => $request->contact_1,
                    ]);
                }
                return redirect()->route('account.own', $user->id)->with('success', 'Account updated successfully');
                break;
            
            default:
                return view('errors.404');
                break;
        }
    }
}
