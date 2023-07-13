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
}
