<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $primaryKey = 'id';
    public $incrementing = true;

    public function genres()
    {
        return $this->belongsToMany(Genres::class, 'books_has_genres', 'books_id', 'genres_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Authors::class, 'books_has_authors', 'books_id', 'authors_id');
    }

}
