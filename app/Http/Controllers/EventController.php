<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Reservation;
use App\Notifications\ReservationMadeNotification;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session as FacadesSession;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('reservations')->get();
        $categories = Category::all();
        return view('organizer', compact('events', 'categories'));
    }
    public function AnotherPage()
    {
        $events = Event::all();
        $categories = Category::all();
        return view('dashboard', compact('events', 'categories'));
    }


    public function store(Request $request)
    {
        Event::create($request->all());
        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    public function reservePlace(Request $request, $eventId)
    {
        // Validez la demande de réservation
        $request->validate([
            'places' => 'required|integer|min:1', // Validez le nombre de places
        ]);

        // Récupérez l'événement par son ID
        $event = Event::findOrFail($eventId);

        // Vérifiez si le nombre de places demandées est disponible
        if ($request->places <= $event->places_disponibles) {
            // Create a new reservation record
            $reservation = new Reservation();
            $reservation->id_evenement = $eventId;
            $reservation->id_utilisateur = auth()->id(); // Assuming the user is authenticated
            $reservation->nombre_places = $request->places;
            $reservation->date_reservation = now(); // Use the current date and time for the reservation
            $reservation->statut = 'en_attente';
            $reservation->save();

            // Update the number of available places in the event
            $event->places_disponibles -= $request->places;
            $event->save();

            // Flash message de succès pour l'affichage dans la vue
            FacadesSession::flash('status', $eventId);

            // Redirigez l'utilisateur vers la page précédente
            return redirect()->back();
        } else {
            // Renvoyez une réponse JSON pour indiquer que la réservation a échoué en raison du nombre insuffisant de places disponibles
            return response()->json(['success' => false, 'message' => 'Désolé, il n\'y a pas assez de places disponibles pour cette réservation.']);
        }
    }

}

