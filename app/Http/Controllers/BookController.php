<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{    /**
     * Display the main page with a list of books.
     * 
     * This method retrieves all books from the database with optional filtering
     * and sorting based on query parameters, orders them based on user preference
     * or by published year in descending order by default, and paginates the results
     * to show 12 books per page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // Get query parameters for filtering and sorting
        $genre_id = $request->query('genre');
        $sort_by = $request->query('sort_by', 'published_year'); // Default sort by published year
        $sort_dir = $request->query('sort_dir', 'desc'); // Default sort direction descending
        
        // Start building the query with eager loading
        $query = Book::with(['authors', 'genres', 'publisher']);
        
        // Apply genre filter if selected
        if ($genre_id) {
            $query->whereHas('genres', function($q) use ($genre_id) {
                $q->where('genres.id', $genre_id);
            });
        }
        
        // Apply sorting (validate sort_by to prevent SQL injection)
        $allowed_sort_fields = ['title', 'published_year', 'pages'];
        $sort_by = in_array($sort_by, $allowed_sort_fields) ? $sort_by : 'published_year';
        $sort_dir = in_array($sort_dir, ['asc', 'desc']) ? $sort_dir : 'desc';
        
        $query->orderBy($sort_by, $sort_dir);
        
        // Paginate results - 12 is a good number for grid display
        $books = $query->paginate(12)->appends($request->except('page'));
        
        // Get all genres for the sidebar filter
        $genres = Genres::orderBy('name')->get();
        
        return view('books.index', [
            'books' => $books,
            'genres' => $genres,
            'currentGenre' => $genre_id ? Genres::find($genre_id) : null
        ]);
    }
    
    /**
     * Display the specified book.
     * 
     * This method retrieves a specific book with its associated data
     * (authors, genres, publisher, publishing city and country).
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id): View
    {
        // Get the book with its relationships
        $book = Book::with(['authors', 'genres', 'publisher', 'publishingCity.country'])
            ->findOrFail($id);
        
        return view('books.show', [
            'book' => $book
        ]);
    }
    
    /**
     * Display books filtered by genre.
     * 
     * This method retrieves all books of a specific genre,
     * orders them by published year, and paginates the results.
     *
     * @param  int  $genreId
     * @return \Illuminate\View\View
     */
    public function byGenre($genreId): View
    {
        // Get the specified genre
        $genre = Genres::findOrFail($genreId);
        
        // Get all books of this genre
        $books = $genre->books()->orderBy('published_year', 'desc')
            ->paginate(12);
        
        // Get all genres for the sidebar filter
        $genres = Genres::all();
        
        return view('books.index', [
            'books' => $books,
            'genres' => $genres,
            'currentGenre' => $genre
        ]);
    }
      /**
     * Search for books by title, author, or genre.
     * 
     * This method retrieves books whose titles, descriptions, author names or genres
     * match the search query, orders them by published year,
     * and paginates the results. It provides a comprehensive search
     * experience for users looking for specific books.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View
    {
        // Validate search input
        $request->validate([
            'query' => 'required|string|min:2|max:100',
        ]);
        
        $searchQuery = $request->input('query');
        $sort_by = $request->query('sort_by', 'published_year');
        $sort_dir = $request->query('sort_dir', 'desc');
        
        // Apply validation to sort parameters
        $allowed_sort_fields = ['title', 'published_year', 'pages'];
        $sort_by = in_array($sort_by, $allowed_sort_fields) ? $sort_by : 'published_year';
        $sort_dir = in_array($sort_dir, ['asc', 'desc']) ? $sort_dir : 'desc';
          // Start with eager loading of relationships
        $books = Book::with(['authors', 'genres', 'publisher'])
            ->where(function($q) use ($searchQuery) {
                // Search in book title and description
                $q->where('title', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('description', 'LIKE', "%{$searchQuery}%")
                  // Search in author names
                  ->orWhereHas('authors', function($query) use ($searchQuery) {
                      $query->where('name', 'LIKE', "%{$searchQuery}%");
                  })
                  // Search in genre names
                  ->orWhereHas('genres', function($query) use ($searchQuery) {
                      $query->where('name', 'LIKE', "%{$searchQuery}%");
                  })
                  // Search by ISBN
                  ->orWhere('ISBN', 'LIKE', "%{$searchQuery}%");
            })
            ->orderBy($sort_by, $sort_dir)
            ->paginate(12)
            ->appends($request->except('page')); // Append query parameters to pagination links
        
        // Get all genres for the sidebar filter
        $genres = Genres::orderBy('name')->get();
        
        return view('books.index', [
            'books' => $books,
            'genres' => $genres,
            'searchQuery' => $searchQuery,
            'sortBy' => $sort_by,
            'sortDir' => $sort_dir
        ]);
    }
}
