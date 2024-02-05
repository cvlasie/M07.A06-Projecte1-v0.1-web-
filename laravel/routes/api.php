<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;

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