<?php

namespace App\Http\Controllers;

use App\Models\UserAmbulance;
use Illuminate\Http\Request;

class UserAmbulanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
