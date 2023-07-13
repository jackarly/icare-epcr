<?php

namespace App\Http\Controllers;

use App\Models\Hotline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Set search keyword to null
        $keyword = null;
        
        // Check if request is from search box
        if ($request->searchedQuery) {
            $keyword = $request->keyword;
            $order = $request->order;

            // Set result order
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

    public function create(Request $request)
    {
        // Only allow comcen and admin accounts
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('hotline.create');
        } else {
            return view('errors.404');
        }
        
    }   

    public function store(Request $request)
    {
        // Only allow comcen and admin accounts
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'facility'=> 'required|string',
                'location'=> 'required|string',
                'contact'=> 'required|string',
            ]);
    
            Hotline::create([
                'facility'=> $request->facility,
                'location'=> $request->location,
                'contact'=> $request->contact,
            ]);
            return redirect()->route('hotline')->with('success', 'New hotline added successfully');
        } else {
            return view('errors.404');
        }
    }

    public function edit(Request $request, Hotline $hotline)
    {
        // Only allow comcen and admin accounts
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            return view('hotline.edit', [
                'hotline' => $hotline,
            ]);
        } else {
            return view('errors.404');
        }
        
    } 
    
    public function update(Request $request, Hotline $hotline)
    {
        // Only allow comcen and admin accounts
        if ( (Auth::user()->user_type == 'comcen') || (Auth::user()->user_type == 'admin') ){
            $this->validate($request, [
                'facility'=> 'required|string',
                'location'=> 'required|string',
                'contact'=> 'required|string',
            ]);
    
            $hotline->update([
                'facility'=> $request->facility,
                'location'=> $request->location,
                'contact'=> $request->contact,
            ]);
            return redirect()->route('hotline')->with('success', 'Hotline updated successfully');
        } else {
            return view('errors.404');
        }
    }
}
