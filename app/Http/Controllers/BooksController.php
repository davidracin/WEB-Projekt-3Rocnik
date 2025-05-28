<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books; // Import the Books model

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
        ]);
    }
}
