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
        $this->books->load('genres', 'authors'); // Eager load genres and authors for each book
    }
    public function books()
    {
        return view('books', [
            'bookss' => $this->books, // Pass the books to the view
            'books' => $this->books, // Pass the books to the view
            'genres' => Genres::all(), // Fetch all genres from the database
            'authors' => Authors::all(), // Fetch all authors from the database
            'publishers' => Publishers::all(), // Fetch all publishers from the database
            'publishingCities' => PublishingCities::all(), // Fetch all publishing cities from the database
        ]);

    }

    public function addBook(Request $request)
    {

        $book = new Books();
        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
        $book->cover_image = $request->file('cover_image')->store('covers', 'public'); // Store the cover image in the 'covers' directory
        }
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->publishers_id = $request->input('publishers_id');
        $book->publishing_cities_id = $request->input('publishing_cities_id');
        $book->published_year = $request->input('published_year');
        $book->isbn = $request->input('isbn');
        $book->pages = $request->input('pages');
        $book->save(); // Save the book to the database


        $genre_ids = $request->input('genres_id');
        $author_ids = $request->input('authors_id');
        foreach ($genre_ids as $genre_id) {
            $book->genres()->attach($genre_id); // Attach genres to the book
        }
        foreach ($author_ids as $author_id) {
            $book->authors()->attach($author_id); // Attach authors to the book
        }
        return redirect()->route('dashboard')->with('success', 'Book added successfully!');
    }

    public function deleteBook($id)
    {
        $book = Books::findOrFail($id); // Find the book by ID
        $book->delete(); // Delete the book from the database
        return redirect()->route('dashboard')->with('success', 'Book deleted successfully!');
    }

    public function editBook($id, Request $request)
    {
        $book = Books::findOrFail($id); // Find the book by ID
        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $book->cover_image = $request->file('cover_image')->store('covers', 'public'); // Store the cover image in the 'covers' directory
        }
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->publishers_id = $request->input('publishers_id');
        $book->publishing_cities_id = $request->input('publishing_cities_id');
        $book->published_year = $request->input('published_year');
        $book->isbn = $request->input('isbn');
        $book->pages = $request->input('pages');
        $book->save(); // Save the book to the database

        // Detach existing genres and authors
        $book->genres()->detach();
        $book->authors()->detach();

        // Attach new genres and authors
        $genre_ids = $request->input('genres_id');
        $author_ids = $request->input('authors_id');
        foreach ($genre_ids as $genre_id) {
            $book->genres()->attach($genre_id); // Attach genres to the book
        }
        foreach ($author_ids as $author_id) {
            $book->authors()->attach($author_id); // Attach authors to the book
        }

        return redirect()->route('dashboard')->with('success', 'Book updated successfully!');
    }
}
