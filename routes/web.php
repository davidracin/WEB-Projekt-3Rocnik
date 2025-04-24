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

Route::get('/test', function () {
    return view('welcome');
});
Route::get('genre',  [genre::class, 'genre'])->name('genre'); // Define the route for the genre page
