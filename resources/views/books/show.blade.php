@extends('layouts.layout')

@section('title', $book->title)

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Knihy</a></li>
        @if($book->genres->isNotEmpty())
        <li class="breadcrumb-item">
            <a href="{{ route('books.by-genre', $book->genres->first()->id) }}">
                {{ $book->genres->first()->name }}
            </a>
        </li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
    </ol>
</nav>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <!-- Book cover and key info -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <img src="{{ $book->cover_image }}" class="card-img-top book-detail-cover" alt="{{ $book->title }}">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 text-muted">Základní informace</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-calendar-alt me-2"></i> Rok vydání</span>
                        <span class="badge bg-primary rounded-pill">{{ $book->published_year }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-book-open me-2"></i> Počet stran</span>
                        <span class="badge bg-primary rounded-pill">{{ $book->pages }}</span>
                    </li>
                    @if($book->isbn)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-barcode me-2"></i> ISBN</span>
                        <span class="badge bg-secondary rounded-pill">{{ $book->isbn }}</span>
                    </li>
                    @endif
                    @if(isset($totalReviews) && $totalReviews > 0)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-star me-2"></i> Hodnocení</span>
                        <span>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $averageRating)
                                    <i class="fas fa-star text-warning"></i>
                                @else
                                    <i class="far fa-star text-muted"></i>
                                @endif
                            @endfor
                            <small class="text-muted">({{ number_format($averageRating, 1) }}/5)</small>
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-comments me-2"></i> Recenze</span>
                        <span class="badge bg-secondary rounded-pill">{{ $totalReviews }}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <!-- Book details -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="card-title mb-3">{{ $book->title }}</h1>

                <!-- Authors -->
                <div class="mb-3">
                    <h5 class="text-muted">
                        <i class="fas fa-user-edit me-2"></i>
                        {{ $book->authors->count() > 1 ? 'Autoři' : 'Autor' }}
                    </h5>
                    <div>
                        @forelse($book->authors as $author)
                        <a href="{{ route('books.by-author', $author->id) }}" class="btn btn-sm btn-outline-secondary mb-1 me-1">
                            {{ $author->name }}
                        </a>
                        @empty
                        <span class="text-muted">Autor neuveden</span>
                        @endforelse
                    </div>
                </div>

                <!-- Publisher and publishing info -->
                <div class="mb-3">
                    <h5 class="text-muted">
                        <i class="fas fa-building me-2"></i> Nakladatelské údaje
                    </h5>
                    <p>
                        @if($book->publisher)
                        <strong>Nakladatel:</strong> {{ $book->publisher->name }}<br>
                        @endif

                        @if($book->publishingCity)
                        <strong>Místo vydání:</strong> {{ $book->publishingCity->name }}
                        @if($book->publishingCity->country)
                        ({{ $book->publishingCity->country->name }})
                        @endif
                        @endif
                    </p>
                </div>

                <!-- Genres -->
                <div class="mb-4">
                    <h5 class="text-muted">
                        <i class="fas fa-tags me-2"></i> Žánry
                    </h5>
                    <div>
                        @forelse($book->genres as $genre)
                        <a href="{{ route('books.by-genre', $genre->id) }}" class="btn btn-sm btn-outline-primary mb-1 me-1">
                            {{ $genre->name }}
                        </a>
                        @empty
                        <span class="text-muted">Žádné žánry</span>
                        @endforelse
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h5 class="text-muted">
                        <i class="fas fa-align-left me-2"></i> Popis
                    </h5>
                    <p class="card-text">{{ $book->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    <i class="fas fa-comments me-2"></i>
                    Recenze
                    @if(isset($totalReviews) && $totalReviews > 0)
                        <span class="badge bg-light text-dark">{{ $totalReviews }}</span>
                        @if(isset($averageRating) && $averageRating > 0)
                            <span class="ms-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $averageRating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-light"></i>
                                    @endif
                                @endfor
                                <small>({{ number_format($averageRating, 1) }}/5)</small>
                            </span>
                        @endif
                    @endif
                </h3>
            </div>
            <div class="card-body">
                @auth
                    @if(!isset($userReview) || !$userReview)
                        <!-- Add Review Form -->
                        <div class="mb-4">
                            <h5><i class="fas fa-plus-circle me-2"></i>Přidat recenzi</h5>
                            <form action="{{ route('reviews.store', $book->id) }}" method="POST" id="review-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Hodnocení <span class="text-danger">*</span></label>
                                    <div class="rating-stars mb-2" id="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="far fa-star rating-star" data-rating="{{ $i }}"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}" required>
                                    @error('rating')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div id="rating-error" class="text-danger small d-none">Prosím vyberte hodnocení</div>
                                </div>
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Váš komentář <span class="text-danger">*</span></label>
                                    <textarea name="comment" id="comment" class="form-control wysiwyg-editor" rows="6" placeholder="Napište svou recenzi knihy..." required>{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Odeslat recenzi
                                </button>
                            </form>
                        </div>
                        <hr>
                    @else
                        <!-- Edit User's Review -->
                        <div class="mb-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Již jste tuto knihu ohodnotili. Svou recenzi můžete upravit nebo smazat.
                            </div>
                            <h5><i class="fas fa-edit me-2"></i>Upravit mou recenzi</h5>
                            <form action="{{ route('reviews.update', $userReview->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="edit-rating" class="form-label">Hodnocení</label>
                                    <div class="rating-stars mb-2" id="edit-rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $userReview->rating ? 'text-warning' : 'text-muted' }} rating-star" data-rating="{{ $i }}"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="edit-rating-input" value="{{ $userReview->rating }}">
                                    @error('rating')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="edit-comment" class="form-label">Váš komentář</label>
                                    <textarea name="comment" id="edit-comment" class="form-control wysiwyg-editor" rows="6">{!! old('comment', $userReview->comment) !!}</textarea>
                                    @error('comment')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Uložit změny
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="deleteReview('{{ $userReview->id }}')">
                                        <i class="fas fa-trash me-2"></i>Smazat recenzi
                                    </button>
                                </div>
                            </form>

                            <!-- Hidden delete form -->
                            <form id="delete-review-form-{{ $userReview->id }}" action="{{ route('reviews.destroy', $userReview->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        <hr>
                    @endif
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Pro přidání recenze se <a href="{{ route('login') }}" class="alert-link">přihlaste</a>.
                    </div>
                @endauth

                <!-- Display Reviews -->
                @if(isset($reviews) && $reviews->count() > 0)
                    <h5><i class="fas fa-list me-2"></i>Všechny recenze</h5>
                    @foreach($reviews as $review)
                        <div class="review-item mb-4 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <strong>{{ $review->user->name }}</strong>
                                    <div class="rating-display">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-1">({{ $review->rating }}/5)</span>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    {{ $review->created_at->format('d.m.Y H:i') }}
                                    @if($review->created_at != $review->updated_at)
                                        <br><em>Upraveno: {{ $review->updated_at->format('d.m.Y H:i') }}</em>
                                    @endif
                                </small>
                            </div>
                            <div class="review-content">
                                {!! $review->comment !!}
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    @if(isset($reviews) && $reviews->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $reviews->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tato kniha zatím nemá žádné recenze. Buďte první, kdo ji ohodnotí!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- TinyMCE CDN -->
<script src="https://cdn.tiny.cloud/1/5dq16he46eydbqjp0c2occgwsc7ywynay2uq1w6lf9youklx/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Book show page loaded successfully');

    // Initialize TinyMCE after a short delay to ensure Bootstrap is fully loaded
    setTimeout(function() {
        if (typeof tinymce !== 'undefined') {
            console.log('Initializing TinyMCE editor...');

            tinymce.init({
                selector: '.wysiwyg-editor',
                height: 300,
                menubar: false,
                branding: false,
                statusbar: false,
                plugins: [
                    'lists', 'link', 'charmap', 'preview', 'searchreplace',
                    'visualblocks', 'code', 'fullscreen', 'insertdatetime',
                    'help', 'wordcount', 'emoticons'
                ],
                toolbar: 'undo redo | formatselect | bold italic underline | ' +
                    'forecolor backcolor | alignleft aligncenter alignright | ' +
                    'bullist numlist | link emoticons | removeformat | code help',
                block_formats: 'Paragraph=p; Header 3=h3; Header 4=h4; Header 5=h5; Header 6=h6',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; font-size: 14px; line-height: 1.6; }',
                placeholder: 'Napište svou recenzi knihy...',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                },
                // Ensure TinyMCE doesn't interfere with Bootstrap
                init_instance_callback: function (editor) {
                    console.log('TinyMCE editor initialized successfully');

                    // Ensure TinyMCE dialogs have lower z-index than Bootstrap navbar
                    editor.on('OpenWindow', function() {
                        setTimeout(function() {
                            const dialogs = document.querySelectorAll('.tox-dialog-wrap');
                            dialogs.forEach(function(dialog) {
                                dialog.style.zIndex = '1040';
                            });
                        }, 50);
                    });
                },
                // Content filtering for security
                valid_elements: 'p,br,strong,em,u,a[href],ul,ol,li,h3,h4,h5,h6,span[style]',
                valid_styles: {
                    '*': 'color,background-color,text-align'
                },
                // Mobile responsive
                mobile: {
                    theme: 'mobile',
                    plugins: ['lists', 'autolink'],
                    toolbar: ['undo', 'redo', 'bold', 'italic', 'removeformat']
                }
            });
        } else {
            console.warn('TinyMCE not loaded, using plain textarea');
        }
    }, 300); // Wait 300ms for Bootstrap to fully initialize

    // Ensure Bootstrap dropdowns still work (this runs before TinyMCE)
    setTimeout(function() {
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        console.log('Found dropdown elements on book page:', dropdownElementList.length);

        dropdownElementList.forEach(function (dropdownToggleEl) {
            if (!dropdownToggleEl.hasAttribute('data-bs-dropdown-page-initialized')) {
                try {
                    new bootstrap.Dropdown(dropdownToggleEl);
                    dropdownToggleEl.setAttribute('data-bs-dropdown-page-initialized', 'true');
                    console.log('Page-level dropdown initialized for:', dropdownToggleEl.id || dropdownToggleEl.className);
                } catch (error) {
                    console.warn('Bootstrap dropdown failed, using fallback');
                }
            }
        });
    }, 100);

    // Star Rating System
    initStarRating();
    initEditStarRating();

    // Form validation
    const reviewForm = document.getElementById('review-form');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            const ratingInput = document.getElementById('rating-input');
            const ratingError = document.getElementById('rating-error');

            if (!ratingInput.value) {
                e.preventDefault();
                ratingError.classList.remove('d-none');
                document.getElementById('rating-stars').scrollIntoView({ behavior: 'smooth' });
                return false;
            } else {
                ratingError.classList.add('d-none');
            }
        });
    }
});

function initStarRating() {
    const starsContainer = document.getElementById('rating-stars');
    const ratingInput = document.getElementById('rating-input');
    const ratingError = document.getElementById('rating-error');

    if (!starsContainer || !ratingInput) return;

    const stars = starsContainer.querySelectorAll('.rating-star');

    // Set initial state from old input
    const initialRating = parseInt(ratingInput.value) || 0;
    updateStarsDisplay(stars, initialRating);

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            const rating = parseInt(star.dataset.rating);
            ratingInput.value = rating;
            updateStarsDisplay(stars, rating);

            // Hide error message when rating is selected
            if (ratingError) {
                ratingError.classList.add('d-none');
            }
        });

        star.addEventListener('mouseenter', () => {
            const rating = parseInt(star.dataset.rating);
            updateStarsDisplay(stars, rating, true);
        });
    });

    starsContainer.addEventListener('mouseleave', () => {
        const currentRating = parseInt(ratingInput.value) || 0;
        updateStarsDisplay(stars, currentRating);
    });
}

function initEditStarRating() {
    const starsContainer = document.getElementById('edit-rating-stars');
    const ratingInput = document.getElementById('edit-rating-input');

    if (!starsContainer || !ratingInput) return;

    const stars = starsContainer.querySelectorAll('.rating-star');

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            const rating = parseInt(star.dataset.rating);
            ratingInput.value = rating;
            updateStarsDisplay(stars, rating);
        });

        star.addEventListener('mouseenter', () => {
            const rating = parseInt(star.dataset.rating);
            updateStarsDisplay(stars, rating, true);
        });
    });

    starsContainer.addEventListener('mouseleave', () => {
        const currentRating = parseInt(ratingInput.value) || 0;
        updateStarsDisplay(stars, currentRating);
    });
}

function updateStarsDisplay(stars, rating, isHover = false) {
    stars.forEach((star, index) => {
        const starRating = index + 1;
        star.classList.remove('fas', 'far', 'text-warning', 'text-muted');

        if (starRating <= rating) {
            star.classList.add('fas', 'text-warning');
        } else {
            star.classList.add('far', 'text-muted');
        }
    });
}

function deleteReview(reviewId) {
    if (confirm('Opravdu chcete smazat svou recenzi? Tato akce je nevratná.')) {
        document.getElementById('delete-review-form-' + reviewId).submit();
    }
}
</script>

<style>
.rating-stars {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.rating-star {
    cursor: pointer;
    transition: color 0.2s ease;
    margin-right: 0.25rem;
}

.rating-star:hover {
    color: #ffc107 !important;
}

.rating-display i {
    font-size: 1rem;
}

.review-content {
    line-height: 1.6;
}

.review-content h3,
.review-content h4,
.review-content h5,
.review-content h6 {
    margin-top: 1em;
    margin-bottom: 0.5em;
    color: #333;
}

.review-content p {
    margin-bottom: 1em;
}

.review-content ul,
.review-content ol {
    margin-bottom: 1em;
    padding-left: 2em;
}

.review-content strong {
    font-weight: 600;
}

.review-content em {
    font-style: italic;
}

/* Ensure TinyMCE doesn't interfere with dropdowns */
.tox-dialog-wrap {
    z-index: 1040 !important;
}

/* Review item styling */
.review-item {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}

.review-item:hover {
    background-color: #f1f3f4;
    transition: background-color 0.2s ease;
}

.book-detail-cover {
    height: 400px;
    object-fit: cover;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

@media (max-width: 767px) {
    .book-detail-cover {
        height: 300px;
    }
}
</style>
@endsection
