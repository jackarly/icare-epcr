<?php

namespace App\Http\Controllers;

use App\Models\ResponsePersonnel;
use Illuminate\Http\Request;

class ResponsePersonnelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ResponsePersonnel $responsePersonnel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResponsePersonnel $responsePersonnel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResponsePersonnel $responsePersonnel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResponsePersonnel $responsePersonnel)
    {
        //
    }
}
