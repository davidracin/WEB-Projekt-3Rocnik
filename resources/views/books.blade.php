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
        'name' => 'genres_id[]',
        'label' => 'Žánr',
        'type' => 'select-multiple',
        'options' => $genres->pluck('name', 'id')->toArray(),
        'required' => true,
    ],
    [
        'name' => 'authors_id[]',
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
                            <th>Akce</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookss as $book)
                            <tr>
                                <td>{{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}</td>
                                <td>{{ $book->title }}</td>

                                <td>
                                    <a data-bs-toggle="modal" data-bs-target="#edit{{ $book->id }}"
                                        class="btn btn-warning btn-sm">Upravit</a>
                                    <a data-bs-toggle="modal" data-bs-target="#del{{ $book->id }}"
                                        class="btn btn-danger btn-sm">Smazat</a>
                            </tr>
                            <?php echo add_modal('edit' . $book->id, 'Upravit knihu', 'books/edit/' . $book->id, [
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
                                    'value' => $book->title,
                                ],
                                [
                                    'name' => 'description',
                                    'label' => 'Popis',
                                    'type' => 'textarea',
                                    'required' => true,
                                    'placeholder' => 'Zadejte popis knihy',
                                    'value' => $book->description,
                                ],
                                [
                                    'name' => 'genres_id[]',
                                    'label' => 'Žánr',
                                    'type' => 'select-multiple',
                                    'options' => $genres->pluck('name', 'id')->toArray(),
                                    'required' => true,
                                    // Preselect the genres of the book
                                    'selected' => $book->genres->pluck('id')->toArray(),
                                ],
                                [
                                    'name' => 'authors_id[]',
                                    'label' => 'Autoři',
                                    'type' => 'select-multiple',
                                    'options' => $authors->pluck('name', 'id')->toArray(),
                                    'required' => true,
                                    'selected' => $book->authors->pluck('id')->toArray(),
                                ],
                                [
                                    'name' => 'pages',
                                    'label' => 'Počet stran',
                                    'type' => 'number',
                                    'required' => true,
                                    'placeholder' => 'Zadejte počet stran knihy',
                                    'value' => $book->pages,
                                ],
                                [
                                    'name' => 'published_year',
                                    'label' => 'Rok vydání',
                                    'type' => 'number',
                                    'required' => true,
                                    'placeholder' => 'Zadejte rok vydání knihy',
                                    'value' => $book->published_year,
                                ],
                                [
                                    'name' => 'isbn',
                                    'label' => 'ISBN',
                                    'type' => 'text',
                                    'required' => false,
                                    'placeholder' => 'Zadejte ISBN knihy (pokud je k dispozici)',
                                    'value' => $book->isbn,
                                ],
                                [
                                    'name' => 'publishers_id',
                                    'label' => 'Vydavatel',
                                    'type' => 'select',
                                    'options' => $publishers->pluck('name', 'id')->toArray(),
                                    'required' => true,
                                    // Preselect the publisher of the book
                                    'selected' => $book->publishers_id,
                                ],
                                [
                                    'name' => 'publishing_cities_id',
                                    'label' => 'Město vydání',
                                    'type' => 'select',
                                    'options' => $publishingCities->pluck('name', 'id')->toArray(),
                                    'required' => true,
                                    // Preselect the publishing city of the book
                                    'selected' => $book->publishing_cities_id,
                                ]
                            ], 'warning', 'Upravit'); ?>

                            {{-- Debugging output for genres --}}
                            {{-- Uncomment the line below to see the genres of the book --}}
                            {{-- <p>Genres: {{ $book->genres->pluck('name')->implode(', ') }}</p> --}}
                            {{-- Uncomment the line below to see the IDs of the genres --}}
                            {{-- Add genres_id and authors_id as hidden inputs --}}


                            {{-- Delete modal --}}
                            <?php echo delete_modal('del' . $book->id, $book->id, 'Smazat knihu',  'Opravdu chcete smazat knihu: ' . $book->title . '?', 'books/delete/' . $book->id); ?>
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
