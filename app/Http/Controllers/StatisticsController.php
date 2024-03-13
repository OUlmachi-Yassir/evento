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
        $events = event::where('status','notAproved')->get();
        $categories = category::all();
        $userCount = User::count();
        $users = User::all();
        $reservationCount = Reservation::count();

        return view('admin', compact('eventCount', 'userCount', 'reservationCount','categories','users','events'));
    }
    public function changeStatus(Event $event)
{
    $eventCount = event::count();
        $events = event::where('status','notAproved')->get();
        $categories = category::all();
        $userCount = User::count();
        $users = User::all();
        $reservationCount = Reservation::count();
    // Mettez à jour le statut de l'événement
    $event->status = 'aproved';
    $event->save();

    // Retournez une réponse JSON pour indiquer que la mise à jour a réussi
    return view('admin',compact('eventCount', 'userCount', 'reservationCount','categories','users','events'));
}
}
