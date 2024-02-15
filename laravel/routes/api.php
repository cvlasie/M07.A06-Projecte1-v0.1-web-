<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;


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

Route::apiResource('files', FileController::class);
Route::post('files/{file}', [FileController::class, 'update_workaround']);

Route::middleware('auth:sanctum')->get('/user', [TokenController::class, 'user']);
Route::middleware('guest')->post('/register', [TokenController::class, 'register']);
Route::middleware('guest')->post('/login', [TokenController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [TokenController::class, 'logout']);

Route::apiResource('posts', PostController::class)->except(['index', 'show']);
Route::apiResource('posts', PostController::class)->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts/{post}/likes', [PostController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/likes', [PostController::class, 'unlike'])->name('posts.unlike');
});

Route::apiResource('posts.comments', CommentController::class);