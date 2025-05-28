<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books; // Import the Books model
use App\Models\Genres;
use App\Models\Authors; // Import the Authors model
use App\Models\Publishers; // Import the Publishers model
use App\Models\PublishingCities; // Import the PublishingCities model

class BooksController extends Controller
{
    var $books;

    public function __construct()
    {
        $this->books = Books::paginate(50); // Fetch all books from the database
    }
    public function books()
    {
        return view('books', [
            'books' => $this->books, // Pass the books to the view
            'genres' => Genres::all(), // Fetch all genres from the database
            'authors' => Authors::all(), // Fetch all authors from the database
            'publishers' => Publishers::all(), // Fetch all publishers from the database
            'publishingCities' => PublishingCities::all(), // Fetch all publishing cities from the database
        ]);
    }

    public function addBook(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'publishing_city_id' => 'required|exists:publishing_cities,id',
            'genre_id' => 'required|exists:genres,id',
            'published_date' => 'required|date',
        ]);

        // Create a new book instance
        echo var_dump($request->all());
    }
}
