<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:job-seeker'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/job-applications', [JobApplicationController::class, 'index'])->name('job-applications.index');
    Route::get('/job-vacancy/{id}', [JobVacancyController::class, 'show'])->name('job-vacancy.show');
    Route::get('/job-vacancy/{id}/apply', [JobVacancyController::class, 'apply'])->name('job-vacancy.apply');
    Route::post('/job-vacancy/{id}/apply', [JobVacancyController::class, 'storeApplication'])->name('job-vacancy.storeApplication');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
