<?php

use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Models\category;
use App\Models\event;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/organizer', function () {
    $idUser = Auth::id();
    $events = Event::with('reservations')->where('id_user', $idUser)->get();
    $categories = Category::all();
    return view('organizer', compact('events', 'categories'));
})->name('organizer.dashboard');



Route::get('/dashboard', [EventController::class, 'AnotherPage'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-reservations',[EventController::class, 'myReservations'])->name('my.reservations');
});
Route::post('/reserve/place/{eventId}', [EventController::class, 'reservePlace'])->name('reserve.place');

Route::middleware('organizer')->group(function () {
    Route::get('/organizer/index', [EventController::class, 'index'])->name('events.index');
    Route::post('events', [EventController::class, 'store'])->name('events.store');
    Route::put('events/{id}', [EventController::class, 'update'])->name('events.update');
    Route::delete('events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/reservations/{id}/confirm', [EventController::class, 'confirmReservation'])->name('reservations.confirm');
    Route::get('/reservations/{id}/cancel', [EventController::class, 'cancelReservation'])->name('reservations.cancel');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin', [CategoryController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin', [CategoryController::class, 'create'])->name('admin.dashboard');
    Route::post('/admin', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/{category}/edit', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::delete('/admin/{category}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');

    Route::get('/admin', [UserController::class, 'user'])->name('admin.dashboard');
    Route::put('/admin/users/{user}/ban', [UserController::class, 'ban'])->name('admin.ban');
    Route::put('/admin/users/{user}/toggleBan', [UserController::class, 'toggleBan'])->name('admin.toggleBan');

    Route::get('/admin/statistics', [StatisticsController::class, 'index'])->name('admin.dashboard');
    Route::get('/change-status/{event}',[StatisticsController::class, 'changeStatus'])->name('event.changeStatus');
});

require __DIR__.'/auth.php';
