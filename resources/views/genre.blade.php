@extends('layouts.template')

@section('title', 'Genres')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Genres</h1>
            
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Genre List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
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
        </div>
    </div>
@endsection
