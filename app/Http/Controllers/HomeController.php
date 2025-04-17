<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Show dashboard (only for authenticated users)
    public function dashboard()
    {
        return view('pages.dashboard'); // create this Blade file
    }
}
