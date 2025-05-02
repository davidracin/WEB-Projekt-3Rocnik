@extends('layouts.template')

@section('title', 'Welcome to Laravel')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="text-center py-4">
                <img src="{{ asset('favicon.ico') }}" alt="Laravel Logo" class="mb-3" width="80">
                <h1>Welcome to Laravel with Bootstrap</h1>
                <p class="lead">A powerful PHP framework with an elegant syntax</p>
            </div>

            <div class="row mt-5">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Documentation</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Laravel has wonderful documentation covering every aspect of the framework. Whether you are a newcomer or have prior experience with Laravel, we recommend reading our documentation from beginning to end.</p>
                            <a href="https://laravel.com/docs" class="btn btn-outline-primary">View Documentation</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Laracasts</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills.</p>
                            <a href="https://laracasts.com" class="btn btn-outline-primary">Start Learning</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Laravel News</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem.</p>
                            <a href="https://laravel-news.com" class="btn btn-outline-primary">Read News</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Ecosystem</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Laravel's robust library of first-party tools and libraries, such as Forge, Vapor, Nova, and Envoyer help you take your projects to the next level.</p>
                            <a href="https://laravel.com/ecosystem" class="btn btn-outline-primary">Explore Ecosystem</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center text-muted small mt-5">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                @if (Route::has('login'))
                    <div class="mt-2">
                        @auth
                            <a href="{{ url('/home') }}" class="text-decoration-none">Home</a>
                        @else
                            <a href="{{ route('login') }}" class="text-decoration-none">Log in</a>

                            @if (Route::has('register'))
                                <span class="mx-1">|</span>
                                <a href="{{ route('register') }}" class="text-decoration-none">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
