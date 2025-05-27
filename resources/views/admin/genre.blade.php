@extends('layouts.admin.layout')

@section('title', 'Žánry')

@section('content')
    <div class="row"> <div class="col-12">
            <h1 class="mt-4 mb-4">Genres</h1>

            <div class="table-responsive shadow rounded">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table">
                        <tr>
                            <th>Název</th>
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($genres as $genre)
                            <tr>
                                <td>{{ $genre->name }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
