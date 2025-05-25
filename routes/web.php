<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;

require __DIR__.'/auth.php';

Route::get('/', [FrontController::class,'home'])->name('home');

// itineraries
Route::get('/itinerary/search/results', [ItineraryController::class, 'search_results'])->name('itinerary.search.results');
Route::get('/itinerary/search', [ItineraryController::class, 'search'])->name('itinerary.search');
Route::get('/itinerary/user/created', [ItineraryController::class, 'user_itineraries'])->name('itinerary.user.created');
Route::resource('itinerary', ItineraryController::class);

// favourites/saved itinerariess
Route::get('/favourites', [FavoritesController::class, 'index'])->name('favourites.index');
Route::post('/favourites/add', [FavoritesController::class, 'store'])->name('favourites.add');
Route::delete('/favourites/{favourite}/destroy', [FavoritesController::class, 'destroy'])->name('favourites.remove');

// stages
Route::resource('stage', StageController::class);

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