<?php

declare(strict_types=1);

use App\Models\Campaign;
use App\Models\Character;
use App\Models\Item;
use App\Models\Monster;
use App\Models\Species;
use App\Models\Timeline;
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

    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Creator/Dashboard');
        })->middleware(['verified'])->name('dashboard');

        Route::controller(App\Http\Controllers\ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::patch('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });

        Route::resource(Campaign::TABLE_NAME, App\Http\Controllers\Creator\CampaignController::class);

        Route::resource(Campaign::TABLE_NAME . '.' . Item::TABLE_NAME, App\Http\Controllers\Creator\ItemController::class);

        Route::resource(Campaign::TABLE_NAME . '.' . Timeline::TABLE_NAME, App\Http\Controllers\Creator\TimelineController::class);

        Route::resource(Campaign::TABLE_NAME . '.' . Species::TABLE_NAME, App\Http\Controllers\Creator\SpeciesController::class);

        Route::resource(Campaign::TABLE_NAME . '.' . Character::TABLE_NAME, App\Http\Controllers\Creator\CharacterController::class);

        Route::resource(Campaign::TABLE_NAME . '.' . Monster::TABLE_NAME, App\Http\Controllers\Creator\MonsterController::class);
    });
});

Route::get('/dice-roller', function () {
    return Inertia::render('DiceRoller/DiceRoller');
})->name('dice-roller');

require __DIR__ . '/auth.php';
