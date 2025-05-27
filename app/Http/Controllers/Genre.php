<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\genres; // Import the genre model

class Genre extends Controller
{
    var $genres;


    public function __construct()
    {
        $this->genres = genres::all(); // Fetch all genres from the database
    }
    public function genre()
    {
        return view('genre', [
            'genres' => $this->genres, // Pass the genres to the view
        ]);
    }

    public function genreAdmin()
    {
        return view('admin.genre', [
            'genres' => $this->genres, // Pass the genres to the view
        ]);
    }

    public function deleteGenre(Request $request)
    {
        $genreId = $request->input('id'); // Get the genre ID from the request

        // Find the genre by ID and delete it
        $genre = genres::find($genreId);
        if ($genre) {
            $genre->delete();
            return redirect()->route('genreAdmin')->with('success', 'Genre deleted successfully.');
        }

        return redirect()->route('genreAdmin')->with('error', 'Genre not found.');
    }

    public function addGenre(Request $request)
    {
        $genreName = $request->input('id'); // Get the genre name from the request

        // Create a new genre
        $genre = new genres();
        $genre->name = $genreName;
        $genre->save();

        return redirect()->route('genres')->with('success', 'Genre added successfully.');
    }

    public function editGenre(Request $request)
    {
        $genreId = $request->input('genre_id'); // Get the genre ID from the request
        $genreName = $request->input('genre_name'); // Get the genre name from the request

        // Find the genre by ID and update it
        $genre = genres::find($genreId);
        if ($genre) {
            $genre->name = $genreName;
            $genre->save();
            return redirect()->route('genres')->with('success', 'Genre updated successfully.');
        }

        return redirect()->route('genres')->with('error', 'Genre not found.');
    }

}
