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
}
