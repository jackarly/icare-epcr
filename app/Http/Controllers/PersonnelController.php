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

    public function index(Request $request, $status = null)
    {
        $searchKeyword = null;
        
        // Check if form search query
        if ($request->searchedQuery) {
            
            // Set search keywords & status
            $searchKeyword = $request->search_name;
            $status = $request->status;

            // Only show medics to comcen and admin accounts
            if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
                // Show medics by status
                switch($status) {
                    case('available'):
                        $responsePersonnels = ResponsePersonnel::whereDate('created_at', Carbon::today())->pluck('personnel_id');
                        $personnels = Personnel::whereNotIn('id', $responsePersonnels)
                            ->where('personnel_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('personnel_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('personnel_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);
                        break;
        
                    case('assigned'):
                        $responsePersonnels = ResponsePersonnel::whereDate('created_at', Carbon::today())->pluck('personnel_id');
                        $personnels = Personnel::whereIn('id', $responsePersonnels)
                            ->where('personnel_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('personnel_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('personnel_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()
                            ->paginate(12);
                        break;
        
                    default:
                        $personnels = Personnel::where('personnel_first_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('personnel_mid_name', 'like', '%'.$searchKeyword.'%')
                            ->orWhere('personnel_last_name', 'like', '%'.$searchKeyword.'%')
                            ->latest()->paginate(12);
                        $status = 'all personnel';
                }
        
                return view('personnel.index', [
                    'personnels' => $personnels,
                    'status' => $status,
                    'searchKeyword' => $searchKeyword,
                ]);
            }
            else{
                return view('errors.404');
            }
        } 
        else {
           // Only show medics to comcen and admin accounts
            if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            // Show medics by status
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
                    $status = 'all personnel';
            }
    
            return view('personnel.index', [
                'personnels' => $personnels,
                'status' => $status,
                'searchKeyword' => $searchKeyword,
            ]);
        }
        else{
            return view('errors.404');
        }
        }
    }

    public function create()
    {
        // Only allow comcen and admin to create medic profile
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('personnel.create');
        }
        else{
            return view('errors.404');
        }
        
    }

    public function store(Request $request)
    {
        // Only allow comcen and admin to save medic profile
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'personnel_first_name'=> 'required|string',
                'personnel_mid_name'=> 'required|string',
                'personnel_last_name'=> 'required|string',
                'personnel_other'=> 'nullable|string',
                'contact'=> 'required|string',
                'birthday'=> 'required|string',
                'sex'=> 'required|string',
                'personnel_img' => 'image|nullable',
                'personnel_type' => 'required'
                
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
                'personnel_type' => $request->personnel_type,
            ]);
            return redirect()->route('personnel')->with('success', 'New medic added successfully');
        }
        else{
            return view('errors.404');
        }
    }

    public function show(Personnel $personnel)
    {
        // Only allow comcen and admin to view medic profile
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
        // Only allow comcen and admin to edit medic profile
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
        // Only allow comcen and admin to update medic profile
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'personnel_first_name'=> 'required|string',
                'personnel_mid_name'=> 'required|string',
                'personnel_last_name'=> 'required|string',
                'personnel_other'=> 'nullable|string',
                'contact'=> 'required|string',
                'birthday'=> 'required|string',
                'sex'=> 'required|string',
                'personnel_img' => 'image|nullable',
                'personnel_type' => 'required'
            ]);
    
            $personnel->personnel_first_name = $request->personnel_first_name;
            $personnel->personnel_mid_name = $request->personnel_mid_name;
            $personnel->personnel_last_name = $request->personnel_last_name;
            $personnel->personnel_other = $request->personnel_other;
            $personnel->contact = $request->contact;
            $personnel->birthday = $request->birthday;
            $personnel->sex = $request->sex;
            $personnel->personnel_type = $request->personnel_type;
            $personnel->save();
    
            return redirect()->route('personnel.show', $personnel->id )->with('success', 'Medic updated successfully');
        }
        else{
            return view('errors.404');
        }
    }

}
