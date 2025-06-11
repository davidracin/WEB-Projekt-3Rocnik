<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookFilterController extends Controller
{
    /**
     * Display books filtered by both genre and author.
     * 
     * This method retrieves books that match both the specified genre and author,
     * orders them by published year, and paginates the results.
     *
     * @param  int  $genreId
     * @param  int  $authorId
     * @return \Illuminate\View\View
     */
    public function byGenreAndAuthor($genreId, $authorId): View
    {
        // Get the specified genre and author
        $genre = Genres::findOrFail($genreId);
        $author = Author::findOrFail($authorId);
        
        // Get books that match both genre and author with eager loading
        $books = Book::with(['authors', 'genres', 'publisher'])
            ->whereHas('genres', function ($query) use ($genreId) {
                $query->where('genres.id', $genreId);
            })
            ->whereHas('authors', function ($query) use ($authorId) {
                $query->where('authors.id', $authorId);
            })
            ->orderBy('published_year', 'desc')
            ->paginate(12);
        
        // Get all genres for the sidebar filter
        $genres = Genres::all();
        
        // Page context
        $pageHeading = 'Knihy v žánru "' . $genre->name . '" od autora "' . $author->name . '"';
        $pageIcon = 'fa-filter';
        $emptyMessage = 'Tento autor nemá v tomto žánru žádné knihy.';
        $isHomepage = false;
        
        // Set current filters for the view
        $currentGenre = $genre;
        $currentAuthor = $author;        // Prepare book data with processed display values
        $bookData = $this->prepareBookData($books);
        
        return view('books.index', [
            'books' => $books,
            'processedBooks' => $bookData['books'],
            'processedFeaturedBooks' => $bookData['featuredBooks'],
            'pagination' => $bookData['pagination'],
            'genres' => $genres, 
            'pageHeading' => $pageHeading, 
            'pageIcon' => $pageIcon, 
            'emptyMessage' => $emptyMessage, 
            'isHomepage' => $isHomepage, 
            'currentGenre' => $currentGenre,
            'currentAuthor' => $currentAuthor
        ]);
    }
    
    /**
     * Get authors by genre for AJAX filtering
     * 
     * @param  int  $genreId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthorsByGenre($genreId)
    {
        $genre = Genres::findOrFail($genreId);
        
        // Get unique authors who have books in this genre
        $authors = Author::whereHas('books', function ($query) use ($genreId) {
            $query->whereHas('genres', function ($subQuery) use ($genreId) {
                $subQuery->where('genres.id', $genreId);
            });
        })
        ->orderBy('name')
        ->get(['id', 'name']);
        
        return response()->json($authors);
    }    /**
     * Prepare book data with processed display values
     * This is similar to the method in PublicBookController
     */
    private function prepareBookData($books): array
    {
        $processedBooks = [];
        
        foreach ($books as $book) {
            $processedBooks[] = [
                'id' => $book->id,
                'title' => $book->title,
                'cover_image' => $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/no-cover.jpg'),
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
        
        return [
            'books' => $processedBooks,
            'featuredBooks' => [], // Empty for this controller since we don't have featured books
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
