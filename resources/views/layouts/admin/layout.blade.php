
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Knihovna Online')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    @vite(['resources/css/app.css'])
    @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Include navbar -->
    @include('layouts.admin.navbar')

    <!-- Main content container -->
    <main class="container py-4 flex-grow-1">
        <div class="row">
            <!-- Admin Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="list-group">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('genreAdmin') }}" class="list-group-item list-group-item-action {{ request()->routeIs('genreAdmin') ? 'active' : '' }}">
                        <i class="fas fa-tags me-2"></i>Správa žánrů
                    </a>
                    <a href="{{ route('books.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-book me-2"></i>Zpět na web
                    </a>
                    <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Odhlásit se
                    </a>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-lg-9">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">© {{ date('Y') }} Knihovna Online - Admin Panel</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Přihlášen jako: {{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js'])
    @yield('scripts')
</body>
</html>
