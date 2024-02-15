<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')->post('/register', [TokenController::class, 'register']);
Route::middleware('guest')->post('/login', [TokenController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [TokenController::class, 'logout']);

Route::apiResource('files', FileController::class);
Route::post('files/{file}', [FileController::class, 'update_workaround']);

Route::apiResource('places', PlaceController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('places', PlaceController::class)->except(['index', 'show']);
    Route::apiResource('places.reviews', ReviewController::class);

    Route::post('/places/{place}/favorites', [PlaceController::class, 'favorite'])->name('places.favorite');
    Route::delete('/places/{place}/favorites', [PlaceController::class, 'unfavorite'])->name('places.unfavorite');
    Route::get('/places/{place}/favorites', [PlaceController::class, 'showFavorites'])->name('places.showFavorites');
});

Route::middleware('auth')->group(function () {
    Route::post('/places/{place}/reviews', [ReviewController::class, 'store'])->name('places.reviews.store');
    Route::delete('/places/{place}/reviews/{review}', [ReviewController::class, 'destroy'])->name('places.reviews.destroy');
});
