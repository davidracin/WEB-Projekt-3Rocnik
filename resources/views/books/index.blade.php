@extends('layouts.layout')

@section('title', isset($currentGenre) ? $currentGenre->name : (isset($searchQuery) ? 'Výsledky vyhledávání' : 'Knihy'))

@section('content')
<!-- Hero section with search -->
<div class="bg-primary text-white p-5 rounded-3 mb-5 shadow">
    <div class="py-2">
        <h1 class="display-5 fw-bold mb-4">Knihovna Online</h1>
        <p class="col-md-8 fs-4">Objevte svou další oblíbenou knihu v naší rozsáhlé knihovně.</p>

        <form action="{{ route('books.search') }}" method="GET" class="mt-4 search-form">
            <div class="input-group input-group-lg">
                <input type="text" name="query" class="form-control" placeholder="Hledejte podle názvu, autora nebo žánru..." value="{{ $searchQuery ?? '' }}">
                <button class="btn btn-light" type="submit">
                    <i class="fas fa-search"></i> Hledat
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Featured Books Carousel (Only visible on homepage) -->
@if($isHomepage)
<div class="mb-5">
    <h2 class="mb-4 fw-bold"><i class="fas fa-star me-2"></i>Doporučené knihy</h2>
    <div class="featured-books-carousel">
        <div class="row flex-nowrap overflow-auto pb-2 g-4" style="scroll-behavior: smooth;">
            @foreach($processedFeaturedBooks as $featuredBook)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="card featured-book-card h-100 shadow-lg">
                    <div class="row g-0 h-100">
                        <div class="col-4">
                            <img src="{{ asset('storage/' . $featuredBook['cover_image']) }}" class="img-fluid h-100" style="object-fit: cover;" alt="{{ $featuredBook['title'] }}">
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <span class="badge bg-warning text-dark mb-2">Doporučujeme</span>
                                <h5 class="card-title fw-bold">{{ $featuredBook['title'] }}</h5>
                                <p class="card-text small mb-1">
                                    @if($featuredBook['has_authors'])
                                    <i class="fas fa-user-edit me-1"></i> {{ $featuredBook['author_names'] }}
                                    @endif
                                </p>
                                <p class="card-text small text-truncate-2">{{ $featuredBook['description'] }}</p>
                                <a href="{{ route('books.show', $featuredBook['id']) }}" class="btn btn-sm btn-primary stretched-link">Zobrazit detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="row">

<!-- Sidebar with filters -->
    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm filter-sidebar rounded-3 border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-filter me-2"></i> Filtry
                </h5>
            </div>
            <div class="card-body">

                <!-- Genres filter -->
                <div class="mb-4">
                    <h6 class="border-bottom pb-2 mb-3">Žánry</h6>
                    <div class="list-group">
                        <a href="{{ route('books.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ !isset($currentGenre) ? 'active' : '' }}">
                            <span><i class="fas fa-book-open me-2"></i> Všechny žánry</span>
                            <span class="badge bg-secondary rounded-pill">{{ count($books) }}</span>
                        </a>
                        @foreach($genres as $genre)
                        <a href="{{ route('books.by-genre', $genre->id) }}"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ isset($currentGenre) && $currentGenre->id == $genre->id ? 'active' : '' }}">
                            <span><i class="fas fa-tag me-2"></i> {{ $genre->name }}</span>
                            <span class="badge bg-secondary rounded-pill">{{ $genre->books->count() }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>


                <!-- Reset filters button -->
                <div class="d-grid gap-2">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo me-2"></i>Resetovat filtry
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content with book list -->
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">
                <i class="fas {{ $pageIcon }} me-2"></i>{{ $pageHeading }}
            </h2>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-sort me-1"></i> Seřadit
                </button>
                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                    <li><a class="dropdown-item" href="?sort_by=title&sort_dir=asc">Název (A-Z)</a></li>
                    <li><a class="dropdown-item" href="?sort_by=title&sort_dir=desc">Název (Z-A)</a></li>
                    <li><a class="dropdown-item" href="?sort_by=published_year&sort_dir=desc">Nejnovější</a></li>
                    <li><a class="dropdown-item" href="?sort_by=published_year&sort_dir=asc">Nejstarší</a></li>
                </ul>
            </div>
        </div>

        @if($books->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            {{ $emptyMessage }}
        </div> @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($processedBooks as $book)
            <div class="col">
                <div class="card h-100 book-card shadow-sm border-0 rounded-3 overflow-hidden">
                    <a href="{{ route('books.show', $book['id']) }}" class="text-decoration-none">
                        <div class="position-relative book-cover-container">
                            <img src="{{ $book['cover_image'] }}" class="card-img-top book-cover" alt="{{ $book['title'] }}">
                            <div class="position-absolute top-0 start-0 w-100 p-2 d-flex justify-content-between">
                                <span class="badge bg-primary rounded-pill">{{ $book['published_year'] }}</span>
                                @if($book['publisher'])
                                <span class="badge bg-dark rounded-pill" title="Vydavatel">{{ $book['publisher']['name'] }}</span>
                                @endif
                            </div>
                            <div class="book-overlay">
                                <button class="btn btn-sm btn-light rounded-pill">
                                    <i class="fas fa-eye me-1"></i> Detail knihy
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark fw-bold mb-1 text-truncate-1" title="{{ $book['title'] }}">{{ $book['title'] }}</h5>

                            <!-- Authors -->
                            <p class="card-text text-secondary mb-2">
                                <small>
                                    <i class="fas fa-user-edit me-1"></i>
                                    {{ $book['author_names'] }}
                                </small>
                            </p>

                            <!-- Genre badges -->
                            <div class="mb-3">
                                @foreach($book['genres'] as $genre)
                                <a href="{{ route('books.by-genre', $genre->id) }}" class="badge bg-primary badge-hover genre-badge text-decoration-none">{{ $genre->name }}</a>
                                @endforeach
                                @if($book['additional_genres_count'] > 0)
                                <span class="badge bg-secondary genre-badge">+{{ $book['additional_genres_count'] }}</span>
                                @endif
                            </div>

                            <!-- Description -->
                            <p class="card-text text-truncate-2 text-muted">
                                {{ $book['description'] }}
                            </p>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text-muted small me-3">
                                        <i class="fas fa-book me-1"></i> {{ $book['pages'] }} stran
                                    </span>
                                    @if($book['has_isbn'])
                                    <span class="text-muted small d-none d-lg-inline-block">
                                        <i class="fas fa-barcode me-1"></i> ISBN: {{ $book['isbn'] }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {!! $pagination['links'] !!}
        </div>
        @endif
    </div>
    @endsection
