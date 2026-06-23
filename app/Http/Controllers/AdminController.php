<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * View Dashboard
     */
    public function dashboard(){
        return view('dashboard.dashboard');
    }
}
