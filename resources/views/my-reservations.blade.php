<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Reservations') }}
        </h2>
    </x-slot>

    <div class="container mx-auto">
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-4">Your Reservations</h3>
        </div>
    </div>
    <link href="https://fonts.googleapis.com/css?family=Cabin|Indie+Flower|Inknut+Antiqua|Lora|Ravi+Prakash" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"  />

    <div class="container">
        <h1 class="upcomming">Your Reservations</h1>

        @if($userReservations->isEmpty())
            <p>You have no reservations.</p>
        @else
            @foreach($userReservations as $reservation)
                <div class="item" id="reservationDiv">
                    <div class="item-right">
                        <h2 class="num">{{ $reservation->id }}</h2>
                        <p class="day">NP:{{ $reservation->nombre_places }}</p>
                        <span class="up-border"></span>
                        <span class="down-border"></span>
                    </div>
                    <div class="item-left">
                        <p class="event">Music Event</p>
                        <h2 class="title">{{ $reservation->event->titre }}</h2>
                        <div class="sce">
                            <div class="icon">
                                <i class="fa fa-table"></i>
                            </div>
                            <p>{{ $reservation->event->date }}</p>
                        </div>
                        <div class="fix"></div>
                        <div class="loc">
                            <div class="icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <p>{{ $reservation->event->lieu }}</p>
                        </div>
                        <div class="fix"></div>
                        @if($reservation->statut === 'confirmé')
                            <button class="tickets1">{{ $reservation->statut }}</button>
                        @elseif($reservation->statut === 'annulé')
                            <button class="tickets2">{{ $reservation->statut }}</button>
                        @else
                            <button class="tickets">{{ $reservation->statut }}</button>
                        @endif
                        @if($reservation->statut === 'confirmé')
                            <button onclick="printTicket('{{ $reservation->id }}')" class="print-ticket-btn">Print Ticket</button>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- ........................... -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        function printTicket(reservationId) {
            // Retrieve reservation information
            var reservation = document.getElementById('reservationDiv_' + reservationId).innerHTML;
            // Create a new instance of jsPDF
            var doc = new jsPDF();
            // Add reservation information to the PDF
            doc.html(reservation, {
                callback: function (doc) {
                    // Download the PDF
                    doc.save('reservation_ticket.pdf');
                }
            });
        }
    </script>
</x-app-layout>
