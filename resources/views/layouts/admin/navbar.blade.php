
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('genre*') ? 'active' : '' }}" href="{{ route('genre') }}">Genres</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('logout*') ? 'active' : '' }}" href="{{ route('logout') }}">Odhlásit se</a>
                </li>
            </ul>


        </div>
</nav>
