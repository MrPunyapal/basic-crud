@use('App\Support\Settings')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title', config('app.name'))
    </title>
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

    @stack('styles')
</head>

<body dir="{{ Settings::getDir() }}">
    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>

</html>
