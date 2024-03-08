<x-app-layout>
    

    @if(auth()->user()->ban)
    <div class="container mx-auto">
        <div class="alert alert-danger">
            Désolé, vous ne pouvez pas accéder à votre compte car il a été banni en raison de violations des conditions d'accès.
        </div>
    </div>
    @else
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach($events as $event)
    <div class="max-w-sm rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">{{ $event->titre }}</div>
            <p class="text-gray-700 text-base">{{ $event->description }}</p>
            <p class="text-gray-700 text-base">Date: {{ $event->date }}</p>
            <p class="text-gray-700 text-base">Lieu: {{ $event->lieu }}</p>
            <p class="text-gray-700 text-base">Places disponibles: <span id="places-disponibles-{{ $event->id }}">{{ $event->places_disponibles }}</span></p>
            <p class="text-gray-700 text-base">Catégorie: {{ $event->categorie->name }}</p>
            <button class="reserve-btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-event-id="{{ $event->id }}">Réserver</button>
            <form method = "POST" action = "{{ route('reserve.place', $event->id) }}" data-event-id="{{ $event->id }}" class="reserve-form hidden">
                @csrf
                <input type="number" name="places" id="places-{{ $event->id }}" placeholder="Nombre de places">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Confirmer</button>
            </form>
            <div data-event-id="{{ $event->id }}" class="reservation-message hidden bg-yellow-200 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-md mt-2 text-sm">
                <!-- Message de réservation -->
            </div> 
        </div>
    </div>
    @endforeach
</div>
@endif

<script>
document.addEventListener("DOMContentLoaded", function() {
    const reserveButtons = document.querySelectorAll(".reserve-btn");

    reserveButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            const eventId = this.getAttribute("data-event-id");
            const reserveForm = document.querySelector('.reserve-form[data-event-id="'+ eventId +'"]');
            if (reserveForm) {
                reserveForm.classList.toggle('hidden');
            }
        });
    });

//     document.querySelectorAll('.reserve-form').forEach(form => {
//         form.addEventListener('submit', function(event) {
//             event.preventDefault();
//             const eventId = this.getAttribute('data-event-id');
//             const placesInput = document.querySelector('#places-' + eventId);
//             const places = parseInt(placesInput.value);
//             const placesDisponibles = parseInt(document.querySelector('#places-disponibles-' + eventId).innerText);

//             if (places <= placesDisponibles) {
//                 // Utilisez fetch ou axios pour envoyer la requête au serveur et gérer la réservation
//                 // Mettez à jour le nombre de places disponibles dans la base de données
//                 document.querySelector('.reservation-message[data-event-id="' + eventId + '"]').classList.remove('hidden');
//                 document.querySelector('.reservation-message[data-event-id="' + eventId + '"]').innerText = 'Votre réservation a été envoyée. En attente de l\'acceptation de l\'organisateur.';
//                 document.querySelector('#places-disponibles-' + eventId).innerText = placesDisponibles - places;
//             } else {
//                 alert('Désolé, il n\'y a pas assez de places disponibles pour cette réservation.');
//             }
//         });
//     });
 });
</script>
</x-app-layout>
