<?php

use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\ItineraryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CityController;


Route::get('/language/set/{language}', [LanguageController::class, 'changeLanguage'])->name('language.set');

Route::middleware(['language'])->group(function () {
    require __DIR__ . '/auth.php';
    Route::get('/', [FrontController::class, 'home'])->name('home');
    
    Route::get('/search', [SearchController::class, 'searchIndex'])->name('search');
    Route::post('/search', [SearchController::class, 'search'])->name('search.store');
    Route::get('/search/results/{query}', [SearchController::class, 'search_results'])->name('search.results');
    
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
        Route::get('/stage/{stage}/destroy/confirm', [StageController::class, 'destroyConfirm'])->name('stage.destroy.confirm');
        Route::prefix('itinerary/{itinerary}')->group(function () {
            Route::get('stage/create', [StageController::class, 'create'])->name('stage.create');
            Route::post('stage', [StageController::class, 'store'])->name('stage.store');
        });    
        Route::resource('stage', StageController::class)->except(['create', 'store']);
    });
    
    Route::middleware(['auth', 'isAdmin'])->group(function () {
        Route::get('/admin', function(){
            return 'admin page';
        });
        Route::get('city/{city}/destroy/confirm', [CityController::class, 'destroyConfirm'])->name('city.destroy.confirm');
        Route::resource('city', CityController::class)->except('show');
    });
    
    Route::middleware('auth')->group(function () {
        Route::get('API/city/exist', [CityController::class, 'exist'])->name('api.city.exist');
    });
});
