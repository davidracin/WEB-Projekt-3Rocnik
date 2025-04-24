<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\genre; // Import the genre model

class genre extends Controller
{
    public function genre()
    {
        $genres = genre::all(); // Fetch all genres from the database
        return view('genre', ['genres' => $genres]); // Pass the genres to the view
    }

}
