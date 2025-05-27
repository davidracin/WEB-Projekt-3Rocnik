
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Laravel App')</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <!-- Include navbar -->
    @include('layouts.admin.navbar')

    <!-- Main content container -->
    <div class="container">
        @yield('content')
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
