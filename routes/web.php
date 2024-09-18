<?php

declare(strict_types=1);

use App\Models\Campaign;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::name('creator.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Creator/Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::controller(App\Http\Controllers\ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::patch('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });

        Route::resource(Campaign::TABLE_NAME, App\Http\Controllers\Creator\CampaignController::class);
    });
});

Route::get('/dice-roller', function () {
    return Inertia::render('DiceRoller/DiceRoller');
})->name('dice-roller');

require __DIR__ . '/auth.php';
