<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::post('/register', [TokenController::class, 'register']);
    Route::post('/login', [TokenController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [TokenController::class, 'logout']);
    Route::get('/user', [TokenController::class, 'user']);
});

// Rutas de archivos
Route::apiResource('files', FileController::class);
Route::post('files/{file}', [FileController::class, 'update_workaround']);

// Rutas de lugares
Route::apiResource('places', PlaceController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('places', PlaceController::class)->except(['index', 'show']);
    Route::apiResource('places.reviews', ReviewController::class);
    
    Route::post('/places/{place}/favorites', [PlaceController::class, 'favorite'])->name('places.favorite');
    Route::delete('/places/{place}/favorites', [PlaceController::class, 'unfavorite'])->name('places.unfavorite');
    Route::get('/places/{place}/favorites', [PlaceController::class, 'showFavorites'])->name('places.showFavorites');
});

// Rutas de revisiones de lugares
Route::middleware('auth')->group(function () {
    Route::post('/places/{place}/reviews', [ReviewController::class, 'store'])->name('places.reviews.store');
    Route::delete('/places/{place}/reviews/{review}', [ReviewController::class, 'destroy'])->name('places.reviews.destroy');
});

// Rutas de publicaciones
Route::apiResource('posts', PostController::class)->except(['index', 'show']);
Route::apiResource('posts', PostController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts/{post}/likes', [PostController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/likes', [PostController::class, 'unlike'])->name('posts.unlike');
});

// Rutas de comentarios de publicaciones
Route::apiResource('posts.comments', CommentController::class);