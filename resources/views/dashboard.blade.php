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
    <div>
    <img src="{{ asset('images/Show_Reservations-removebg-preview (2).png') }}" class="h-[200px] m-auto" alt="OLM">
    </div>
    <div class="container grid grid-cols-1 place-items-center  md:grid-cols-3">
    @foreach($events as $event)
    <div class="max-w-sm h-FULL w-[30em] rounded overflow-hidden shadow-lg bg-white">
        <div class="px-4 py-4">
            <div class="flex justify-between gap-6 items-center">
                <h1 class="font-bold font-Poppin text-[1.4em] ">{{ $event->titre }}</h1>
                <p class="text-gray-700 text-base"> {{ $event->date }}</p>
        </div>
            <p class="text-gray-700 text-base indent-8">{{ $event->description }}</p>
        <div class="flex items-center ">
            <svg width="20px" height="20px" viewBox="0 0 13 10">
                <path d="M1,5 L11,5"></path>
                <polyline points="8 1 12 5 8 9"></polyline>
            </svg>
            <p class="text-gray-700 text-base">
            Lieu:
            <span class="font-bold text-l">{{ $event->lieu }}</span></p>
        </div>
        <div class="flex items-center ">
            <svg width="20px" height="20px" viewBox="0 0 13 10">
                <path d="M1,5 L11,5"></path>
                <polyline points="8 1 12 5 8 9"></polyline>
            </svg>
            <p class="text-gray-700 text-base">Catégorie: {{ $event->categorie->name }}</p>

        </div>
        <div class="flex items-center ">
            <svg width="20px" height="20px" viewBox="0 0 13 10">
                <path d="M1,5 L11,5"></path>
                <polyline points="8 1 12 5 8 9"></polyline>
            </svg>
            <p class="text-gray-700 text-base">Places disponibles: <span id="places-disponibles-{{ $event->id }}">{{ $event->places_disponibles }}</span></p>

        </div>

            
            <button class="reserve-btn font-bold relative hover:text-black rounded-[15px] py-2 px-6 after:absolute after:h-1 after:hover:h-[200%] transition-all duration-500 hover:transition-all hover:duration-500 after:transition-all after:duration-500 after:hover:transition-all after:hover:duration-500 overflow-hidden z-20 after:z-[-20] after:bg-[#abd373] after:rounded-t-full after:w-full after:bottom-0 after:left-0 text-black" data-event-id="{{ $event->id }}">Réserver</button>            
            <form method = "POST" action = "{{ route('reserve.place', $event->id) }}" data-event-id="{{ $event->id }}" class="reserve-form hidden">
                @csrf
                <input type="number" name="places" id="places-{{ $event->id }}" placeholder="Nombre de places">
                <button type="submit" class="bg-[#abd373] hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Confirmer</button>
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
