<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $bookId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $bookId)
    {        // Validate the request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:5000',
        ], [
            'rating.required' => 'Hodnocení je povinné.',
            'rating.min' => 'Hodnocení musí být alespoň 1 hvězdička.',
            'rating.max' => 'Hodnocení může být maximálně 5 hvězdiček.',
            'comment.required' => 'Komentář je povinný.',
            'comment.min' => 'Komentář musí mít alespoň 10 znaků.',
            'comment.max' => 'Komentář může mít maximálně 5000 znaků.',
        ]);

        // Check if the book exists
        $book = Book::findOrFail($bookId);

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Pro přidání recenze se musíte přihlásit.');
        }

        // Check if user has already reviewed this book
        $existingReview = Review::where('users_id', Auth::id())
                               ->where('books_id', $bookId)
                               ->first();

        if ($existingReview) {
            return back()->with('error', 'Již jste tuto knihu hodnotili. Můžete upravit svou stávající recenzi.');
        }

        // Create the review
        $review = Review::create([
            'rating' => $request->rating,
            'review_text' => $request->comment,
            'users_id' => Auth::id(),
            'books_id' => $bookId,
        ]);

        return back()->with('success', 'Vaše recenze byla úspěšně přidána!');
    }

    /**
     * Update the specified review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $reviewId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $reviewId)
    {
        // Validate the request
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:5000',
        ], [
            'rating.required' => 'Hodnocení je povinné.',
            'rating.min' => 'Hodnocení musí být alespoň 1 hvězdička.',
            'rating.max' => 'Hodnocení může být maximálně 5 hvězdiček.',
            'comment.required' => 'Komentář je povinný.',
            'comment.min' => 'Komentář musí mít alespoň 10 znaků.',
            'comment.max' => 'Komentář může mít maximálně 5000 znaků.',
        ]);

        // Find the review
        $review = Review::findOrFail($reviewId);

        // Check if the user owns this review
        if ($review->users_id !== Auth::id()) {
            return back()->with('error', 'Nemáte oprávnění upravovat tuto recenzi.');
        }        // Update the review
        $review->update([
            'rating' => $request->rating,
            'review_text' => $request->comment,
        ]);

        return back()->with('success', 'Vaše recenze byla úspěšně aktualizována!');
    }

    /**
     * Remove the specified review from storage.
     *
     * @param  int  $reviewId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($reviewId)
    {
        // Find the review
        $review = Review::findOrFail($reviewId);

        // Check if the user owns this review or is an admin
        if ($review->users_id !== Auth::id() && !Auth::user()->is_admin) {
            return back()->with('error', 'Nemáte oprávnění smazat tuto recenzi.');
        }

        // Delete the review
        $review->delete();

        return back()->with('success', 'Recenze byla úspěšně smazána.');
    }
}
