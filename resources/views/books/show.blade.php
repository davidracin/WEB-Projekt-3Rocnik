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

    <div class="row">
        <!-- Book cover and key info -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="{{ $book->cover_image }}" class="card-img-top" alt="{{ $book->title }}">
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
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-barcode me-2"></i> ISBN</span>
                            <span>{{ $book->ISBN }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Book details -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title">{{ $book->title }}</h1>

                    <!-- Authors -->
                    @if($book->authors->isNotEmpty())
                        <div class="mb-3">
                            <h5 class="text-muted">
                                <i class="fas fa-user-edit me-2"></i> Autoři
                            </h5>
                            <div>
                                @foreach($book->authors as $author)
                                    <div class="d-flex align-items-center mb-2">
                                        @if($author->profile_image)
                                            <img src="{{ $author->profile_image }}" class="me-2 rounded-circle" width="40" height="40" alt="{{ $author->name }}">
                                        @else
                                            <div class="me-2 rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <span>{{ $author->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

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
                        <p class="card-text">{{ $book->description }}</p>                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
