<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        App - @yield('title', 'Home')
    </title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

    @stack('styles')
</head>

<body>
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>

</html>
