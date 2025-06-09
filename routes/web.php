<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

require __DIR__ . '/auth.php';

Route::get('/', [FrontController::class, 'home'])->name('home');

// itineraries
Route::middleware('auth')->group(function () {
    Route::get('/itinerary/user/created', [ItineraryController::class, 'user_itineraries'])->name('itinerary.user.created');
    Route::get('/itinerary/{itinerary}/destroy/confirm', [ItineraryController::class, 'confirmDestroy'])->name('itinerary.destroy.confirm');
});

Route::get('/itinerary/search/results', [ItineraryController::class, 'search_results'])->name('itinerary.search.results');
Route::get('/itinerary/search', [ItineraryController::class, 'search'])->name('itinerary.search');
Route::resource('itinerary', ItineraryController::class); // quasi tutti auth

// favourites/saved itineraries
// all auth
Route::middleware('auth')->group(function () {
    Route::get('/favourites', [FavoritesController::class, 'index'])->name('favourites.index');
    Route::post('/favourites/add', [FavoritesController::class, 'store'])->name('favourites.add');
    Route::delete('/favourites/{favourite}/destroy', [FavoritesController::class, 'destroy'])->name('favourites.remove');
});

// stages
Route::middleware('auth')->group(function () {
    Route::get('/itinerary/{itinerary}/stage/new', [StageController::class, 'create'])->name('stage.create');
    Route::get('/itinerary/{itinerary}/stage/add', [StageController::class, 'add'])->name('stage.add');
    Route::post('/stage/store', [StageController::class, 'store'])->name('stage.store');
    Route::get('/stage/{stage}/edit', [StageController::class, 'edit'])->name('stage.edit');
    Route::put('/stage/{stage}/update', [StageController::class, 'update'])->name('stage.update');
    Route::delete('/stage/{stage}/destroy', [StageController::class, 'destroy'])->name('stage.destroy');
    Route::get('/stage/{stage}/destroy/confirm', [StageController::class, 'destroyConfirm'])->name('stage.destroy.confirm');
});


// Route::middleware(['auth'])->group(function () {
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });