/*
* View based on the genre id
*/

@extends('layouts.layout')

@section('title', $genre->name)

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="mt-5 mb-4">{{ $genre->name }}</h1>
            <p>Books in this genre:</p>

            @if ($books->isEmpty())
                <p>No books found for this genre.</p>
            @else
                <ul class="list-group">
                    @foreach ($books as $book)
                        <li class="list-group-item">
                            <strong>{{ $book->title }}</strong> by {{ $book->author }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection