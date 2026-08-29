<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\HallController;

Route::get('/', [MovieController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/screenings/{screening}/reserve', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/screenings/{screening}/reserve', [ReservationController::class, 'store'])->name('reservations.store');

    Route::get('/reservations/{reservation}/pay', [ReservationController::class, 'pay'])->name('reservations.pay');
    Route::post('/reservations/{reservation}/pay', [ReservationController::class, 'processPayment'])->name('reservations.processPayment');

    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('reservations.index');
});

Route::resource('movies', MovieController::class)->only(['index', 'show']);
Route::resource('screenings', ScreeningController::class)->only(['index', 'show']);
Route::resource('halls', HallController::class)->only(['index', 'show']);

require __DIR__.'/auth.php';