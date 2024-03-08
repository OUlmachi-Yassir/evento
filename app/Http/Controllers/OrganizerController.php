<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    
    public function index()
    {
        // Add logic here specific to the organizer view
        return view('organizer');
    }
}
