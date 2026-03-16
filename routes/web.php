<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PersonalBestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/create', [CalendarController::class, 'create'])->name('calendar.create');
    Route::post('/calendar', [CalendarController::class, 'store'])->name('calendar.store');

    Route::get('/pbs', [PersonalBestController::class, 'index'])->name('pbs.index');
    Route::post('/pbs', [PersonalBestController::class, 'store'])->name('pbs.store');
    Route::patch('/pbs/{pb}', [PersonalBestController::class, 'update'])->name('pbs.update');
    Route::delete('/pbs/{pb}', [PersonalBestController::class, 'destroy'])->name('pbs.destroy');
});

require __DIR__.'/auth.php';
