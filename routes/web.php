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
    return view('welcome');
})->name('home');

// Define the route for the genre page (both singular and plural forms)
Route::get('/genre', [Genre::class, 'genre'])->name('genre');
Route::post('/delete-genre', [Genre::class, 'deleteGenre'])->name('delete-genre');
Route::post('/add-genre', [Genre::class, 'addGenre'])->name('add-genre');
Route::post('/edit-genre', [Genre::class, 'editGenre'])->name('edit-genre');
Route::get('/genres', [Genre::class, 'genre'])->name('genres');

//Routes for the login and register pages
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');
