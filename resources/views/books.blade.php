@extends('layouts.admin.layout')

@section('title', 'Knihy')

@section('content')
    <div class="row">
        <div class="col-sm-auto">
            <h1 class="mt-4 mb-4">Knihy</h1>
        </div>
        <div class="mt-4 mb-4 col-sm-auto ms-auto">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBook">Přidat knihu</button>
        </div>
    </div>
    <?php $add = [
    [
        'name' => 'cover_image',
        'label' => 'Obrázek obálky',
        'type' => 'file',
        'required' => false,
        'placeholder' => 'Zvolte obrázek obálky knihy',
    ],
    [
        'name' => 'title',
        'label' => 'Název',
        'type' => 'text',
        'required' => true,
        'placeholder' => 'Zadejte název knihy',
    ],
    [
        'name' => 'description',
        'label' => 'Popis',
        'type' => 'textarea',
        'required' => true,
        'placeholder' => 'Zadejte popis knihy',
    ],
    [
        'name' => 'genres_id',
        'label' => 'Žánr',
        'type' => 'select-multiple',
        'options' => $genres->pluck('name', 'id')->toArray(),
        'required' => true,
    ],
    [
        'name' => 'authors_id',
        'label' => 'Autoři',
        'type' => 'select-multiple',
        'options' => $authors->pluck('name', 'id')->toArray(),
        'required' => true,
    ],
    [
        'name' => 'pages',
        'label' => 'Počet stran',
        'type' => 'number',
        'required' => true,
        'placeholder' => 'Zadejte počet stran knihy',
    ],
    [
        'name' => 'published_year',
        'label' => 'Rok vydání',
        'type' => 'number',
        'required' => true,
        'placeholder' => 'Zadejte rok vydání knihy',
    ],
    [
        'name' => 'isbn',
        'label' => 'ISBN',
        'type' => 'text',
        'required' => false,
        'placeholder' => 'Zadejte ISBN knihy (pokud je k dispozici)',
    ],
    [
        'name' => 'publishers_id',
        'label' => 'Vydavatel',
        'type' => 'select',
        'options' => $publishers->pluck('name', 'id')->toArray(),
        'required' => true,
    ],
    [
        'name' => 'publishing_cities_id',
        'label' => 'Město vydání',
        'type' => 'select',
        'options' => $publishingCities->pluck('name', 'id')->toArray(),
        'required' => true,
    ],
    ]; ?>
    <?php echo add_modal('addBook', 'Přidat knihu', 'books/add', $add); ?>

            <div class="table-responsive shadow rounded">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table">
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
