@extends('layouts.template')

@section('title', 'Genres')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Genres</h1>
            
            <div class="mb-3 p-3 bg-primary text-white rounded">
                <h5 class="mb-0">Seznam žánrů</h5>
            </div>
            <div class="table-responsive shadow rounded">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Název</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($genres as $genre)
                            <tr>
                                <td>{{ $genre->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
