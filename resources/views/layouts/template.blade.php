<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    <!-- Import Bootstrap via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Include navbar -->
    @include('layouts.navbar')
    
    <!-- Main content container -->
    <div class="container">
        @yield('content')
    </div>
</body>
</html>