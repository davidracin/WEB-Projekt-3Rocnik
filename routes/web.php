<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Genre; // Import the genre controller
use App\Http\Controllers\AuthController; // Import the auth controller

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
    return view('auth.login');
})->name('home');

// Define the route for the genre page (both singular and plural forms)
Route::get('/genre', [Genre::class, 'genre'])->name('genre');
Route::get('/genre/admin', [Genre::class, 'genreAdmin'])->middleware('auth')->name('genreAdmin');
Route::delete('/genre/delete', [Genre::class, 'deleteGenre'])->middleware('auth')->name('genreDelete');
Route::post('/genre/add', [Genre::class, 'addGenre'])->middleware('auth')->name('genreAdd');
Route::put('/genre/edit', [Genre::class, 'editGenre'])->middleware('auth')->name('genreEdit');

//Routes for the login and register pages
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');
