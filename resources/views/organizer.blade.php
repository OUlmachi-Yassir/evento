<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Events') }}
        </h2>
    </x-slot>

    <div class="container">
        <!-- Display Create Event Form -->
    <div class="max-w-md mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Create Event</h2>
    <form method="POST" action="{{ route('events.store') }}" class="space-y-4">
        @csrf
        <input type="text" name="titre" placeholder="Event Title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-400">
        <textarea name="description" placeholder="Event Description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-400"></textarea>
        <input type="datetime-local" name="date" placeholder="Event Date and Time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-400">
        <input type="text" name="lieu" placeholder="Event Location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-400">
        <input type="number" name="places_disponibles" placeholder="Available Places" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-400">
        <input type="text" class = "hidden" name = "id_user" value = "{{ Auth::user()->id }}">
        <!-- Select Category -->
        <select name="id_categorie" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-400">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Create</button>
    </form>
</div>

<br><br>
        <!-- Display Events List -->
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($events as $event)
            <div class="max-w-sm rounded overflow-hidden shadow-lg">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">{{ $event->titre }}</div>
                    
                    <p class="text-gray-700 text-base">Date: {{ $event->date }}</p>
                    
                    <p class="text-gray-700 text-base">Places disponibles: {{ $event->places_disponibles }}</p>
                    <p class="text-gray-700 text-base">Catégorie: {{ $event->categorie->name }}</p>
                    <!-- Ajoutez ici d'autres informations de l'événement -->
                </div>
                <div class="flex justify-center gap-3">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold  px-4 rounded edit-btn" data-event-id="{{ $event->id }}">
                        Editer
                    </button>
                    <form method="POST" action="{{ route('events.destroy', $event->id) }}" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Supprimer
                        </button>
                    </form>
                    
                <button  data-event-id="{{ $event->id }}" class=" show-reservations-btn bg-gray-950 text-gray-400 border border-gray-400 border-b-4 font-medium overflow-hidden relative px-4 py-2 rounded-md hover:brightness-150 hover:border-t-4 hover:border-b active:opacity-75 outline-none duration-300 group">
                <span class="bg-gray-400 shadow-gray-400 absolute -top-[150%] left-0 inline-flex w-80 h-[5px] rounded-md opacity-50 group-hover:top-[150%] duration-500 shadow-[0_0_10px_10px_rgba(0,0,0,0.3)]"></span>
                Show Reservations
                </button>
                </div>
                <div class="px-6 py-4 edit-form hidden" data-event-id="{{ $event->id }}">
                    <!-- Edit Form - Initially Hidden -->
                    <form method="POST" action="{{ route('events.update', $event->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="text" name="titre" value="{{ $event->titre }}" placeholder="Event Title" class="bg-gray-200 rounded-lg px-4 py-2 mb-2 w-full">
                        <input type="text" name="description" value="{{ $event->description }}" placeholder="Event Description" class="bg-gray-200 rounded-lg px-4 py-2 mb-2 w-full">
                        <input type="datetime-local" name="date" value="{{ date('Y-m-d\TH:i', strtotime($event->date)) }}" class="bg-gray-200 rounded-lg px-4 py-2 mb-2 w-full">
                        <input type="text" name="lieu" value="{{ $event->lieu }}" placeholder="Event Location" class="bg-gray-200 rounded-lg px-4 py-2 mb-2 w-full">
                        <input type="number" name="places_disponibles" value="{{ $event->places_disponibles }}" placeholder="Available Places" class="bg-gray-200 rounded-lg px-4 py-2 mb-2 w-full">
                        <input type="text" class = "hidden" name = "id_user" value = "{{ Auth::user()->id }}">
                        <!-- Add other fields as needed -->
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Enregistrer
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    

    

    <!-- Modal for the reservation table -->
<div id="modal" class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="modal-content bg-white p-8 rounded shadow-lg">
        <span class="close-btn absolute top-0 right-0 p-2 cursor-pointer">&times;</span>
        <div class="reservations-content"></div>
    </div>
</div>

<div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach($events as $event)
        <div class="max-w-sm rounded overflow-hidden shadow-lg">
            <div class="px-6 py-4">
                <!-- Other event details -->

                <div id="event-reservations-{{ $event->id }}" class="reservations-popup hidden" data-event-id="{{ $event->id }}">
                    <p class="text-gray-700 text-base">Reservations:</p>
                    @if($event->reservations)
                        <table class="table-auto">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Number of Places</th>
                                    <th>Reservation Date</th>
                                    <th>Status</th>
                                    <th>Actions</th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->reservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->user->name }}</td>
                                        <td>{{ $reservation->nombre_places }}</td>
                                        <td>{{ $reservation->date_reservation }}</td>
                                        <td>{{ $reservation->statut }}</td>
                                        <td>
                                            @if($reservation->statut == 'en_attente')
                                            <a href="{{ route('reservations.confirm', $reservation->id) }}" class="confirm-reservation-btn bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" data-reservation-id="{{ $reservation->id }}">Confirm</a>
                                            <a href="{{ route('reservations.cancel', $reservation->id) }}" class="cancel-reservation-btn bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" data-reservation-id="{{ $reservation->id }}">Cancel</a>
                                            @else
                                                <span>Already {{ $reservation->statut }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No reservations for this event.</p>
                    @endif
                </div>
                
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const showReservationsButtons = document.querySelectorAll(".show-reservations-btn");
        const modal = document.getElementById("modal");
        const closeBtn = document.querySelector(".close-btn");
        const reservationsContent = document.querySelector(".reservations-content");

        showReservationsButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                const eventId = this.getAttribute("data-event-id");
                const eventReservations = document.querySelector(`#event-reservations-${eventId}`).innerHTML;
                reservationsContent.innerHTML = eventReservations;
                modal.classList.remove("hidden");
            });
        });

        closeBtn.addEventListener("click", function() {
            modal.classList.add("hidden");
        });
    });


//....................

// document.addEventListener("DOMContentLoaded", function() {
//     const confirmReservationButtons = document.querySelectorAll(".confirm-reservation-btn");
//     const cancelReservationButtons = document.querySelectorAll(".cancel-reservation-btn");
//     console.log(confirmReservationButtons);
//     console.log(cancelReservationButtons);
//     confirmReservationButtons.forEach(function(button) {
//         button.addEventListener("click", function() {
//             const reservationId = this.getAttribute("data-reservation-id");
//             updateReservationStatus(reservationId, 'confirm');
//         });
//     });

//     cancelReservationButtons.forEach(function(button) {
//         button.addEventListener("click", function() {
//             const reservationId = this.getAttribute("data-reservation-id");
//             updateReservationStatus(reservationId, 'cancel');
//         });
//     });

    
    
//     function updateReservationStatus(reservationId, action) {
//         // Send an AJAX request to update the reservation status
//         // You can use Fetch API or Axios for AJAX requests
//         // Example using Fetch API
//         fetch(`/update-reservation-status/${reservationId}?action=${action}`, {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
//             },
//             body: JSON.stringify({
//                 reservationId: reservationId,
//                 action: action
//             })
//         })
//         .then(response => {
//             if (response.ok) {
//                 // Update the status in the UI if the request is successful
//                 const statusElement = document.querySelector(`[data-reservation-id="${reservationId}"] .reservation-status`);
//                 statusElement.innerText = action === 'confirm' ? 'Confirmed' : 'Canceled';
//             } else {
//                 console.error('Failed to update reservation status');
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//         });
//     }
// });

</script>


    
</x-app-layout>
        