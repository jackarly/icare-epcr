<?php

namespace App\Http\Controllers;

use App\Models\Hotline;
use Illuminate\Http\Request;

class HotlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = null;
        
        if ($request->searchedQuery) {
            $keyword = $request->keyword;
            $order = $request->order;

            if ($order == 'alpahbetical') {
                $hotlines = Hotline::where('facility', 'like', '%'.$keyword.'%')->orWhere('location', 'like', '%'.$keyword.'%')->orderBy('facility', 'asc')->paginate(15);
            } else {
                $hotlines = Hotline::where('facility', 'like', '%'.$keyword.'%')->orWhere('location', 'like', '%'.$keyword.'%')->orderBy('id', 'asc')->paginate(15);
            }
            
            
        } else {
            $hotlines = Hotline::orderBy('id', 'asc')->paginate(15);
        }
        return view('hotline.index', [
            'hotlines' => $hotlines,
            'searchResults' => $keyword,
        ]);
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
    public function show(Hotline $hotline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotline $hotline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotline $hotline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotline $hotline)
    {
        //
    }
}
