<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\HomeController;

use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    Log::info('Loading welcome page');
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    $request->session()->flash('info', 'TEST flash messages');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Mail

Route::get('mail/test', [MailController::class, 'test']);

// Files

Route::resource('files', FileController::class)->middleware(['auth']);
Route::get('files/{file}/delete', [FileController::class, 'delete'])->name('files.delete')->middleware(['auth']);

// Posts

Route::resource('posts', PostController::class)->middleware(['auth']);
Route::get('posts/{post}/delete', [PostController::class, 'delete'])->name('posts.delete')->middleware(['auth']);

// Places

Route::resource('places', PlaceController::class)->middleware(['auth']);
Route::get('places/{place}/delete', [PlaceController::class, 'delete'])->name('places.delete')->middleware(['auth']);

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas para "likes"
Route::post('/posts/{post}/likes', [PostController::class, 'like'])->name('posts.like');
Route::delete('/posts/{post}/likes', [PostController::class, 'unlike'])->name('posts.unlike');

// Rutes per a favorits en llocs (places)
Route::post('/places/{place}/favorite', [PlaceController::class, 'addFavorite'])
    ->name('places.favorite')
    ->middleware('can:favorite,place');

Route::delete('/places/{place}/unfavorite', [PlaceController::class, 'removeFavorite'])
    ->name('places.unfavorite')
    ->middleware('can:favorite,place');