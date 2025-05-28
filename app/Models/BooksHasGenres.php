<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksHasGenres extends Model
{
    use HasFactory;
    protected $table = 'books_has_genres'; // Specify the table name
    protected $primaryKey = 'books_id';
    public $incrementing = false;
}
