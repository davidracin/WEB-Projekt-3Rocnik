<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Genre; // Import the genre controller
use App\Http\Controllers\AuthController; // Import the auth controller
use App\Http\Controllers\PublicBookController; // Import the public book controller
use App\Http\Controllers\BooksController; // Import the books controller (admin)
use App\Http\Controllers\ReviewController; // Import the review controller
use App\Http\Controllers\PasswordResetController; // Import the password reset controller
use App\Http\Controllers\DocumentationController; // Import the documentation controller

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

// Set books index as the home page
Route::get('/', [PublicBookController::class, 'index'])->name('home');

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

// Password Reset Routes
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// Public Book Routes (for visitors and users)
Route::get('/books', [PublicBookController::class, 'index'])->name('books.index');
Route::get('/books/search', [PublicBookController::class, 'search'])->name('books.search');
Route::get('/books/genre/{id}', [PublicBookController::class, 'byGenre'])->name('books.by-genre');
Route::get('/books/author/{id}', [PublicBookController::class, 'byAuthor'])->name('books.by-author');
Route::get('/books/{id}', [PublicBookController::class, 'show'])->name('books.show');

// Admin Book Management Routes 
Route::get('/admin/books', [BooksController::class, 'books'])->middleware('auth')->name('admin.books');
Route::post('/admin/books/add', [BooksController::class, 'addBook'])->middleware('auth')->name('addBook');
Route::delete('/admin/books/delete/{id}', [BooksController::class, 'deleteBook'])->middleware('auth')->name('deleteBook');
Route::post('/admin/books/edit/{id}', [BooksController::class, 'editBook'])->middleware('auth')->name('editBook');

// Review routes
Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');
Route::put('/reviews/{review}', [ReviewController::class, 'update'])->middleware('auth')->name('reviews.update');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->middleware('auth')->name('reviews.destroy');

// Documentation route
Route::get('/documentation', [DocumentationController::class, 'documentation'])->name('documentation');