<?php

namespace App\Http\Controllers;

use App\Models\UserHospital;
use Illuminate\Http\Request;

class UserHospitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
