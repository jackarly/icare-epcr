<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personnel;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personnels = Personnel::latest()->paginate(12);

        return view('personnel.index', [
            'personnels' => $personnels,
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
}
