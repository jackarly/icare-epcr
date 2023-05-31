<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\ResponsePersonnel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PersonnelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index($status = null)
    {
        // $responsePersonnels = ResponsePersonnel::whereDate('created_at', Carbon::today())->pluck('personnel_id');
        // dd($responsePersonnels);

        // $personnels = Personnel::whereIn('id', $responsePersonnels)->latest()->paginate(12);
        // dd($personnels);

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('personnel.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

        // dd("okay");

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

        // dd("okay");
        return redirect()->route('personnel')->with('success', 'New medic added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Personnel $personnel)
    {
        return view('personnel.show', [
            'personnel' => $personnel,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personnel $personnel)
    {
        return view('personnel.edit', [
            'personnel' => $personnel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Personnel $personnel)
    {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
