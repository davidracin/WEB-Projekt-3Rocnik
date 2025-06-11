
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-lock me-2"></i> Knihovna Online - Admin
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.books') ? 'active' : '' }}" href="{{ route('admin.books') }}">
                        <i class="fas fa-tags me-1"></i> Knihy
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('genreAdmin') ? 'active' : '' }}" href="{{ route('genreAdmin') }}">
                        <i class="fas fa-tags me-1"></i> Žánry
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('books.index') }}">
                        <i class="fas fa-arrow-left me-1"></i> Zpět na web
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-1"></i> Odhlásit se
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
