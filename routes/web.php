<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\NewsletterController;
use App\Jobs\SendNewsletter;
use App\Mail\Newsletter;

Route::view('/','welcome');
//Route::view('/dashboard','dashboard')->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'getDashboard'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

Route::get('/admin', [AdminController::class, 'show'])
        ->middleware(['auth', 'admin'])
        ->name('admin');

Route::get('/analytics', [ChartController::class, 'show'])
        ->middleware(['auth', 'admin'])
        ->name('analytics');

Route::get('/marketing/newsletter',[NewsletterController::class, 'send'])->middleware(['throttle:newsletter']);

Route::view('/marketing','marketing')->name('marketing');

Route::post('/add-details', [FormController::class, 'store']);

Route::get('/show-details', [FormController::class, 'show'])
        ->middleware('auth')
        ->name('show-details');






require __DIR__.'/auth.php';
