<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->middleware('redirectIfAuthenticatedWithRole');


Route::middleware(['auth', 'verified', 'redirectIfAuthenticatedWithRole'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/leave-request/create', [HomeController::class,'create'])->name('leave-request.create');
    Route::post('/leave-request', [HomeController::class,'store'])->name('leave-request.store');
    Route::get('/leave-request/{id}/edit', [HomeController::class,'edit'])->name('leave-request.edit');
    Route::put('/leave-request/{id}', [HomeController::class,'update'])->name('leave-request.update');
    Route::delete('/leave-request/{id}', [HomeController::class,'destroy'])->name('leave-request.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
