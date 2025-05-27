<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'published_year',
        'pages',
        'ISBN',
        'publishers_id',
        'publishing_cities_id'
    ];

    /**
     * Get the authors that belong to the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'books_has_authors', 'books_id', 'authors_id');
    }

    /**
     * Get the genres that belong to the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genres::class, 'books_has_genres', 'books_id', 'genres_id');
    }

    /**
     * Get the publisher that owns the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'publishers_id');
    }

    /**
     * Get the publishing city that owns the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publishingCity(): BelongsTo
    {
        return $this->belongsTo(PublishingCity::class, 'publishing_cities_id');
    }
}
