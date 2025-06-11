@extends('layouts.admin.layout')

@section('title', 'Žánry')

@section('content')
    <div class="row">
        <div class="col-sm-auto">
            <h1 class="mt-4 mb-4">Žánry</h1>
        </div>
        <div class="mt-4 mb-4 col-sm-auto ms-auto">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGenre">Přidat žánr</button>
        </div>
    </div>
    <?php $add = [[
        'name' => 'name',
        'label' => 'Název',
        'type' => 'text',
        'required' => true,
        'placeholder' => 'Zadejte název'
    ]]; ?>
    <?php echo add_modal('addGenre', 'Přidat žánr', 'add', $add); ?>


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
                                <td><button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{ $genre->id }}">Upravit</button></td>
                                <td><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del{{ $genre->id }}">Odstranit</button></td>
                                <?php echo delete_modal('del'.$genre->id, $genre->id, 'Odstranit žánr', 'Opravdu chcete odstranit tento žánr?', 'delete') ?>
                                <?php echo edit_modal('edit'.$genre->id, 'Upravit žánr', 'edit', $genre->getAttributes()); ?>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
