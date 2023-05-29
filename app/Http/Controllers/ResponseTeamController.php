<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResponseTeam;
use App\Models\UserAmbulance;
use App\Models\Personnel;
use App\Models\ResponsePersonnel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResponseTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $responses = ResponseTeam::whereDate('created_at', Carbon::today())->latest()->paginate(12);
        // $responses = ResponseTeam::latest()->paginate(12);
        // $responses = ResponseTeam::latest()->with(['incidents', 'incidentsCount' => function($query){
        //     $query->whereDate('created_at', Carbon::today())->count();
        //     }])->paginate(12);

        // $responses = ResponseTeam::latest()->with(['incidents', 'user_ambulance'])->paginate(12);
        $responses = ResponseTeam::whereDate('created_at', Carbon::today())->latest()->with(['incidents', 'user_ambulance'])->paginate(12);

        // $responses = ResponseTeam::latest()->with(['incidents'])->paginate(12);

        return view('response-team.index', [
            'responses' => $responses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medics_active = DB::table('personnels')
            ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
            ->whereDate('response_personnels.created_at', Carbon::today())
            ->pluck('personnels.id');

        $ambulance_active = DB::table('user_ambulances')
            ->join('response_teams', 'user_ambulances.id', '=', 'response_teams.user_ambulance_id')
            ->whereDate('response_teams.created_at', Carbon::today())
            ->pluck('user_ambulances.id');

        $ambulances = UserAmbulance::whereNotIn('id', $ambulance_active)->get();
        $medics = Personnel::whereNotIn('id', $medics_active)->get();

        return view('response-team.create', [
            'ambulances' => $ambulances,
            'medics' => $medics,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ambulance'=> 'required',
            'medic1'=> 'required',
            'medic2'=> 'required'
        ]);

        if ($request->medic1 === $request->medic2){
            return back()->with('error', 'Select medic only once');
        }
        else{
            
            $response= ResponseTeam::create([
                'user_ambulance_id'=> $request->ambulance,
            ]);

            $response->response_personnels()->create([
                'personnel_id'=> $request->medic1,
            ]);

            $response->response_personnels()->create([
                'personnel_id'=> $request->medic2,
            ]);
        }
        
        return redirect()->route('response')->with('success', 'New response team added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ResponseTeam $responseTeam)
    {   
        // dd($responseTeam);
        $medics = DB::table('personnels')
            ->join('response_personnels', 'personnels.id', '=', 'response_personnels.personnel_id')
            ->join('response_teams', 'response_teams.id', '=', 'response_personnels.response_team_id')
            ->where('response_teams.id','=',$responseTeam->id)
            ->get();

        return view('response-team.show', [
            'response' => $responseTeam,
            'medics' => $medics,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResponseTeam $responseTeam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResponseTeam $responseTeam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResponseTeam $responseTeam)
    {
        //
    }
}
