<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-r from-orange-200 to-indigo-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
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
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const editButtons = document.querySelectorAll(".edit-btn");

            editButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    const eventId = this.getAttribute("data-event-id");
                    const editForm = document.querySelector(`.edit-form[data-event-id="${eventId}"]`);
                    editForm.classList.toggle("hidden");
                });
            });
        });
    </script>