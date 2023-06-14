<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserAmbulance;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    public function index($user_type = null)
    {
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
