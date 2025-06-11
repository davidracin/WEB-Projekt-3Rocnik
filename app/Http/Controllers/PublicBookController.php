<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicBookController extends Controller
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
        
        // Determine if we're on the homepage (no search query or genre filter)
        $isHomepage = !$genre_id && !$request->has('query');
        
        // Set up featured books only if we're on the homepage
        $featuredBooks = $isHomepage ? collect($books->items())->take(5) : null;
        
        // Prepare page heading and message
        $pageHeading = 'Nejnovější knihy';
        $pageIcon = 'fa-book-open';
        $emptyMessage = 'V databázi zatím nejsou žádné knihy.';
        
        if ($genre_id && $genre = Genres::find($genre_id)) {
            $pageHeading = 'Knihy v žánru: ' . $genre->name;
            $pageIcon = 'fa-tag';
            $emptyMessage = 'V tomto žánru zatím nejsou žádné knihy.';
        }
        
        // Prepare book data with processed display values
        $bookData = $this->prepareBookData($books, $featuredBooks);
        
        return view('books.index', [
            'books' => $books,
            'processedBooks' => $bookData['books'],
            'processedFeaturedBooks' => $bookData['featuredBooks'],
            'pagination' => $bookData['pagination'],
            'genres' => $genres,
            'currentGenre' => $genre_id ? Genres::find($genre_id) : null,
            'isHomepage' => $isHomepage,
            'featuredBooks' => $featuredBooks,
            'pageHeading' => $pageHeading,
            'pageIcon' => $pageIcon,
            'emptyMessage' => $emptyMessage
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
        // Get the book with its relationships including reviews
        $book = Book::with(['authors', 'genres', 'publisher', 'publishingCity.country', 'reviews.user'])
            ->findOrFail($id);
        
        // Get reviews ordered by newest first
        $reviews = $book->reviews()->with('user')->newest()->paginate(10);
        
        // Calculate average rating
        $averageRating = $book->reviews()->avg('rating') ?: 0;
        $totalReviews = $book->reviews()->count();
        
        // Check if current user has already reviewed this book
        $userReview = null;
        if (auth()->check()) {
            $userReview = $book->reviews()->where('users_id', auth()->id())->first();
        }
        
        return view('books.show', [
            'book' => $book,
            'reviews' => $reviews,
            'averageRating' => round($averageRating, 1),
            'totalReviews' => $totalReviews,
            'userReview' => $userReview
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
        
        // Page context
        $pageHeading = 'Knihy v žánru: ' . $genre->name;
        $pageIcon = 'fa-tag';
        $emptyMessage = 'V tomto žánru zatím nejsou žádné knihy.';
        $isHomepage = false;
        
        // Prepare book data with processed display values
        $bookData = $this->prepareBookData($books);
        
        return view('books.index', [
            'books' => $books,
            'processedBooks' => $bookData['books'],
            'pagination' => $bookData['pagination'],
            'genres' => $genres,
            'currentGenre' => $genre,
            'isHomepage' => $isHomepage,
            'pageHeading' => $pageHeading,
            'pageIcon' => $pageIcon,
            'emptyMessage' => $emptyMessage
        ]);
    }

    /**
     * Display books filtered by author.
     * 
     * This method retrieves all books by a specific author,
     * orders them by published year, and paginates the results.
     *
     * @param  int  $authorId
     * @return \Illuminate\View\View
     */
    public function byAuthor($authorId): View
    {
        // Get the specified author
        $author = Author::findOrFail($authorId);
        
        // Get all books by this author with eager loading
        $books = $author->books()->with(['authors', 'genres', 'publisher'])
            ->orderBy('published_year', 'desc')
            ->paginate(12);
        
        // Get all genres for the sidebar filter
        $genres = Genres::all();
        
        // Page context
        $pageHeading = 'Knihy od autora: ' . $author->name;
        $pageIcon = 'fa-user-edit';
        $emptyMessage = 'Tento autor zatím nemá v databázi žádné knihy.';
        $isHomepage = false;
        
        // Prepare book data with processed display values
        $bookData = $this->prepareBookData($books);
        
        return view('books.index', [
            'books' => $books,
            'processedBooks' => $bookData['books'],
            'pagination' => $bookData['pagination'],
            'genres' => $genres,
            'currentAuthor' => $author,
            'isHomepage' => $isHomepage,
            'pageHeading' => $pageHeading,
            'pageIcon' => $pageIcon,
            'emptyMessage' => $emptyMessage
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
        
        // Set page heading, icon and message for search results
        $pageHeading = 'Výsledky vyhledávání: "' . $searchQuery . '"';
        $pageIcon = 'fa-search';
        $emptyMessage = 'Nebyly nalezeny žádné knihy odpovídající vašemu dotazu.';
        $isHomepage = false; // Search results are never homepage
        
        // Prepare book data with processed display values
        $bookData = $this->prepareBookData($books);
        
        return view('books.index', [
            'books' => $books,
            'processedBooks' => $bookData['books'],
            'pagination' => $bookData['pagination'],
            'genres' => $genres,
            'searchQuery' => $searchQuery,
            'sortBy' => $sort_by,
            'sortDir' => $sort_dir,
            'isHomepage' => $isHomepage,
            'pageHeading' => $pageHeading,
            'pageIcon' => $pageIcon,
            'emptyMessage' => $emptyMessage
        ]);
    }
    
    /**
     * Prepare book data for view presentation.
     * 
     * This method processes books and featured books to handle conditional logic
     * that would otherwise be in the view.
     *
     * @param  \Illuminate\Pagination\LengthAwarePaginator  $books
     * @param  \Illuminate\Support\Collection|null  $featuredBooks
     * @return array
     */
    private function prepareBookData($books, $featuredBooks = null): array
    {
        // Process main book list for display
        $processedBooks = [];
        foreach ($books as $book) {
            $processedBooks[] = [
                'id' => $book->id,
                'title' => $book->title,
                'cover_image' => $book->cover_image,
                'published_year' => $book->published_year,
                'publisher' => $book->publisher ? [
                    'name' => $book->publisher->name
                ] : null,
                'description' => \Illuminate\Support\Str::limit($book->description, 120),
                'author_names' => $book->authors->count() > 0 
                    ? $book->authors->pluck('name')->join(', ') 
                    : 'Neznámý autor',
                'has_authors' => $book->authors->count() > 0,
                'genres' => $book->genres->take(2),
                'additional_genres_count' => $book->genres->count() > 2 
                    ? $book->genres->count() - 2 
                    : 0,
                'pages' => $book->pages,
                'isbn' => $book->ISBN,
                'has_isbn' => !empty($book->ISBN)
            ];
        }

        // Process featured books if provided
        $processedFeaturedBooks = [];
        if ($featuredBooks) {
            foreach ($featuredBooks as $book) {
                $processedFeaturedBooks[] = [
                    'id' => $book->id,
                    'title' => $book->title,
                    'cover_image' => $book->cover_image,
                    'author_names' => $book->authors->count() > 0 
                        ? $book->authors->pluck('name')->join(', ') 
                        : 'Neznámý autor',
                    'has_authors' => $book->authors->count() > 0,
                    'description' => \Illuminate\Support\Str::limit($book->description, 60)
                ];
            }
        }
        
        return [
            'books' => $processedBooks,
            'featuredBooks' => $processedFeaturedBooks,
            'pagination' => [
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
                'links' => $books->links('pagination::bootstrap-5')->toHtml()
            ]
        ];
    }
}
