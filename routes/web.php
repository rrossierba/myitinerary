<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CityController;

require __DIR__ . '/auth.php';

Route::get('/', [FrontController::class, 'home'])->name('home');

Route::get('/search/results', [SearchController::class, 'search_results'])->name('search.results');
Route::get('/search', [SearchController::class, 'search'])->name('search');

// AJAX
Route::get('/API/cities/name', [CityController::class, 'search'])->name('api.city.name');
Route::get('/API/regions/state', [CityController::class, 'searchRegion'])->name('api.regions.state');
Route::get('/API/cities/regions', [CityController::class, 'searchCitiesByRegion'])->name('api.city.region');

// itineraries
Route::middleware(['auth', 'isRegisteredUser'])->group(function () {
    // itineraries
    Route::get('/itinerary/{itinerary}/destroy/confirm', [ItineraryController::class, 'confirmDestroy'])->name('itinerary.destroy.confirm');
    Route::resource('itinerary', ItineraryController::class);
    
    // favourites
    Route::get('/favourites', [FavoritesController::class, 'index'])->name('favourites.index');
    Route::post('/API/favourites/add', [FavoritesController::class, 'store'])->name('favourites.add');
    Route::delete('/API/favourites/destroy', [FavoritesController::class, 'destroy'])->name('favourites.remove');

    // stages
    Route::get('/itinerary/{itinerary}/stage/new', [StageController::class, 'new'])->name('stage.new');
    Route::get('/itinerary/{itinerary}/stage/add', [StageController::class, 'add'])->name('stage.add');
    Route::get('/stage/{stage}/destroy/confirm', [StageController::class, 'destroyConfirm'])->name('stage.destroy.confirm');
    Route::resource('stage', StageController::class);
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', function(){
        return 'admin page';
    });
    Route::get('city/{city}/destroy/confirm', [CityController::class, 'destroyConfirm'])->name('city.destroy.confirm');
    Route::resource('city', CityController::class);
    Route::get('API/city/exist', [CityController::class, 'exist'])->name('api.city.exist');
});

Route::middleware('auth')->group(function () {
    Route::get('API/city/exist', [CityController::class, 'exist'])->name('api.city.exist');
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