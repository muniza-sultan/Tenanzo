<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PropertyController;



Route::get('/', [PropertyController::class, 'index'])->name('home');



Route::middleware(['auth', 'verified'])->group(function () {
    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Landlord routes
    Route::get('/dashboard', function () {
        if (auth()->user()->isLandlord()) {
            return app(ApplicationController::class)->landlordDashboard();
        }
        return app(ApplicationController::class)->myApplications();
    })->name('dashboard');
    Route::get('/properties/create', fn() => inertia('Properties/Form'))->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::patch('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');

    // Tenant routes
    Route::get('/my-applications', [ApplicationController::class, 'myApplications'])->name('my-applications');
    Route::post('/properties/{property}/apply', [ApplicationController::class, 'store'])->name('applications.store');

});

Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

require __DIR__.'/auth.php';
