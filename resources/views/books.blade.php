@extends('layouts.admin.layout')

@section('title', 'Knihy')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="mt-5 mb-4">Knihy</h1>

            <div class="mb-3 p-3 bg-primary text-white rounded">
                <h5 class="mb-0">Seznam knih</h5>
            </div>
            <div class="table-responsive shadow rounded">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Číslo</th>
                            <th>Název</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                                <td>{{ $book->title }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
        {{-- Display pagination links --}}
        {{ $books->links('pagination::bootstrap-5') }}
    </div>
@endsection