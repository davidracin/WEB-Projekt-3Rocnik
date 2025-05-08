<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Genre; // Import the genre controller

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
Route::post('/delete-genre', [Genre::class, 'deleteGenre'])->name('delete-genre');
Route::post('/add-genre', [Genre::class, 'addGenre'])->name('add-genre');
Route::post('/edit-genre', [Genre::class, 'editGenre'])->name('edit-genre');
Route::get('/genres', [Genre::class, 'genre'])->name('genres');

//Routes for the login and register pages
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
