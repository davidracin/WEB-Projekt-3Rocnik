<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use HTMLPurifier;
use HTMLPurifier_Config;

class Review extends Model
{
    use HasFactory;    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reviews';    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rating',
        'review_text',
        'users_id',
        'books_id'
    ];

    /**
     * Set the review_text attribute with HTML sanitization.
     *
     * @param  string  $value
     * @return void
     */
    public function setReviewTextAttribute($value)
    {
        $this->attributes['review_text'] = $this->purifyHtml($value);
    }

    /**
     * Get the review_text attribute (for backward compatibility, also accessible as 'comment').
     *
     * @return string
     */
    public function getCommentAttribute()
    {
        return $this->review_text;
    }

    /**
     * Purify HTML content to prevent XSS attacks while preserving formatting.
     *
     * @param  string  $html
     * @return string
     */
    private function purifyHtml($html)
    {
        $config = HTMLPurifier_Config::createDefault();
        
        // Allow safe HTML elements that TinyMCE might use
        $config->set('HTML.Allowed', 'p,br,strong,em,u,s,a[href],ul,ol,li,h3,h4,h5,h6,blockquote,code,span[style]');
        
        // Allow safe CSS properties
        $config->set('CSS.AllowedProperties', 'color,background-color,text-align,font-weight,font-style,text-decoration');
        
        // Auto-paragraphs for better formatting
        $config->set('AutoFormat.AutoParagraph', true);
        $config->set('AutoFormat.RemoveEmpty', true);
        
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($html);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Get the book that owns the review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'books_id');
    }

    /**
     * Scope for filtering reviews by rating.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $rating
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope for ordering reviews by newest first.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
