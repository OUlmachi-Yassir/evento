<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Reservation;
use App\Models\User;
use App\Models\event;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $eventCount = event::count();
        $categories = category::all();
        $userCount = User::count();
        $users = User::all();
        $reservationCount = Reservation::count();

        return view('admin', compact('eventCount', 'userCount', 'reservationCount','categories','users'));
    }
}
