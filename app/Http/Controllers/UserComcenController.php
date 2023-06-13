<?php

namespace App\Http\Controllers;

use App\Models\UserComcen;
use Illuminate\Http\Request;

class UserComcenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
