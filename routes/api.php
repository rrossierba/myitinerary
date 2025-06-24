<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, (string)$user->password)) {
        return response()->json(['message' => trans('passwords.wrong_credentials')], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware(['auth:sanctum','isRegisteredApiUser'])->group(function() {
    Route::get('/itineraries', [ApiController::class, 'getItineraries']);
    Route::get('/itineraries/{title}', [ApiController::class, 'getItinerariesByTitle']);
});

Route::middleware(['auth:sanctum','isAdminApi'])->group(function() {
    Route::get('/cities', [ApiController::class, 'getCities']);
    Route::get('/cities/{state}', [ApiController::class, 'getCitiesByState']);
    Route::get('/cities/{state}/{region}', [ApiController::class, 'getCitiesByStateRegion']);
});

Route::middleware(['auth:sanctum'])->group(function() {
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout effettuato']);
    });
});