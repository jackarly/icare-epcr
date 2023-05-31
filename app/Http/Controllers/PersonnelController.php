<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\ResponsePersonnel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PersonnelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($status = null)
    {
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            switch($status) {
                case('available'):
                    $responsePersonnels = ResponsePersonnel::whereDate('created_at', Carbon::today())->pluck('personnel_id');
                    $personnels = Personnel::whereNotIn('id', $responsePersonnels)->latest()->paginate(12);
                    break;
    
                case('assigned'):
                    $responsePersonnels = ResponsePersonnel::whereDate('created_at', Carbon::today())->pluck('personnel_id');
                    $personnels = Personnel::whereIn('id', $responsePersonnels)->latest()->paginate(12);
                    break;
    
                default:
                    $personnels = Personnel::latest()->paginate(12);
                    $status = 'all medics';
            }
    
            return view('personnel.index', [
                'personnels' => $personnels,
                'status' => $status,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function create()
    {
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('personnel.create');
        }
        else{
            return view('errors.404');
        }
        
    }

    public function store(Request $request)
    {
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'personnel_first_name'=> 'required|string',
                'personnel_mid_name'=> 'required|string',
                'personnel_last_name'=> 'required|string',
                'personnel_other'=> 'nullable|string',
                'contact'=> 'required|string',
                'birthday'=> 'required|string',
                'sex'=> 'required|string',
                'personnel_img' => 'image|nullable'
            ]);
    
            Personnel::create([
                'personnel_first_name'=> $request->personnel_first_name,
                'personnel_mid_name'=> $request->personnel_mid_name,
                'personnel_last_name'=> $request->personnel_last_name,
                'personnel_other'=> $request->personnel_other,
                'contact'=> $request->contact,
                'birthday'=> $request->birthday,
                'sex'=> $request->sex,
                'personnel_img' => $request->personnel_img,
            ]);
            return redirect()->route('personnel')->with('success', 'New medic added successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function show(Personnel $personnel)
    {
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('personnel.show', [
                'personnel' => $personnel,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function edit(Personnel $personnel)
    {
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('personnel.edit', [
                'personnel' => $personnel,
            ]);
        }
        else{
            return view('errors.404');
        }
    }

    public function update(Request $request, Personnel $personnel)
    {
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'personnel_first_name'=> 'required|string',
                'personnel_mid_name'=> 'required|string',
                'personnel_last_name'=> 'required|string',
                'personnel_other'=> 'nullable|string',
                'contact'=> 'required|string',
                'birthday'=> 'required|string',
                'sex'=> 'required|string',
                'personnel_img' => 'image|nullable'
            ]);
    
            $personnel->personnel_first_name = $request->personnel_first_name;
            $personnel->personnel_mid_name = $request->personnel_mid_name;
            $personnel->personnel_last_name = $request->personnel_last_name;
            $personnel->personnel_other = $request->personnel_other;
            $personnel->contact = $request->contact;
            $personnel->birthday = $request->birthday;
            $personnel->sex = $request->sex;
            $personnel->save();
    
            return redirect()->route('personnel.show', $personnel->id )->with('success', 'Medic updated successfully');
        }
        else{
            return view('errors.404');
        }
    }
    
    // TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE 
    public function sample()
    {

        if (Auth::user()->user_type == 'admin'){
        }
        else{
            return view('errors.404');
        }



        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
        }
        else{
            return view('errors.404');
        }



        if ( (Auth::user()->user_type == 'ambulance') || (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
        }
        else{
            return view('errors.404');
        }


    }
    // TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE TEMPLATE 

}
