<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\genre; // Import the genre controller

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
Route::get('/genre', [genre::class, 'genre'])->name('genre');
Route::get('/genres', [genre::class, 'genre'])->name('genres');
