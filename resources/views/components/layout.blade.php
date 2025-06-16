@use('App\Support\Settings')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <!-- Modern UI Dependencies -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>

<body dir="{{ Settings::getDirection() }}" class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen antialiased">
    <!-- Navigation Header -->
    <nav class="glass sticky top-0 z-50 border-b border-white/20">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('posts.index') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <i class="fas fa-blog text-white"></i>
                        </div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-700 to-purple-700 bg-clip-text text-transparent">{{ config('app.name', 'Blog') }}</h1>
                    </a>
                </div>

                <div class="flex items-center space-x-6">
                    <!-- Navigation Links -->
                    <a href="{{ route('posts.index') }}" class="flex items-center space-x-2 text-slate-600 hover:text-blue-600 transition-all duration-200 font-medium hover:scale-105">
                        <i class="fas fa-list"></i>
                        <span>{{ __('posts.index.Posts') }}</span>
                    </a>

                    <a href="{{ route('posts.create') }}" class="flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2.5 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-200 font-medium hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-plus"></i>
                        <span>{{ __('posts.form.Create Post') }}</span>
                    </a>

                    <!-- Language Selector -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-slate-600 hover:text-blue-600 transition-colors duration-200 font-medium px-3 py-2 rounded-lg hover:bg-white/50">
                            <i class="fas fa-globe"></i>
                            <span>{{ Settings::getLocales()[app()->getLocale()] ?? 'Language' }}</span>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 glass rounded-xl shadow-xl border border-white/20 py-2 z-50">
                            @foreach (Settings::getLocales() as $locale => $label)
                                <a href="{{ route('set-locale', ['locale' => $locale]) }}"
                                   class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-blue-50/50 hover:text-blue-600 transition-colors duration-200 mx-2 rounded-lg {{ $locale == app()->getLocale() ? 'bg-blue-50/50 text-blue-600 font-medium' : '' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen">
        <div class="container mx-auto px-6 py-8">
            <div class="animate-fade-in">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="glass border-t border-white/20 mt-16">
        <div class="container mx-auto px-6 py-8">
            <div class="text-center text-slate-600">
                <p class="flex items-center justify-center space-x-2">
                    <span>&copy; {{ date('Y') }} {{ config('app.name') }}.</span>
                    <span>Built with</span>
                    <i class="fas fa-heart text-red-500 animate-pulse"></i>
                    <span>using Laravel & Tailwind CSS</span>
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
