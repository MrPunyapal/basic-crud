@use('App\Support\Settings')
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|newsreader:400,500,600,700" rel="stylesheet" />
    @vite(['resources/js/app.js', 'resources/css/app.css'])

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @stack('styles')
</head>

<body dir="{{ Settings::getDirection() }}" class="min-h-screen bg-stone-50 text-stone-950 antialiased selection:bg-red-600/15">
    <div class="pointer-events-none fixed left-1/2 top-0 -z-10 h-72 w-[68rem] -translate-x-1/2 rounded-full bg-red-100/70 blur-3xl"></div>
    <div class="pointer-events-none fixed right-0 top-48 -z-10 h-64 w-64 rounded-full bg-stone-200/60 blur-3xl"></div>

    <header class="sticky top-0 z-40 border-b border-stone-200/80 bg-stone-50/90 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 py-4 lg:flex-row lg:items-center lg:justify-between">
                <a href="{{ route('posts.index') }}" class="flex items-center gap-4">
                    <span class="grid size-11 place-items-center rounded-2xl border border-stone-300 bg-white text-sm font-semibold text-red-600 shadow-sm">L</span>
                    <span>
                        <span class="block text-[11px] font-medium uppercase tracking-[0.24em] text-stone-500">Laravel posts</span>
                        <span class="block text-base font-semibold text-stone-950">Basic CRUD</span>
                    </span>
                </a>

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between lg:justify-end">
                    <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-stone-600">
                        <a href="{{ route('posts.index') }}" class="rounded-full px-4 py-2 transition hover:bg-white hover:text-stone-950">{{ __('posts.index.Posts') }}</a>
                        <a href="{{ route('posts.create') }}" class="rounded-full border border-stone-950 bg-stone-950 px-4 py-2 text-white transition hover:border-stone-800 hover:bg-stone-800">{{ __('posts.form.Create Post') }}</a>
                        <a href="https://github.com/mr-punyapal/basic-crud" target="_blank" rel="noopener noreferrer" class="rounded-full px-4 py-2 transition hover:bg-white hover:text-stone-950">GitHub</a>
                    </nav>

                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="inline-flex items-center gap-2 rounded-full border border-stone-300 bg-white px-4 py-2 text-sm font-medium text-stone-700 shadow-sm transition hover:border-stone-400 hover:text-stone-950">
                            <span>{{ Settings::getLocales()[app()->getLocale()] ?? 'Language' }}</span>
                            <svg class="size-4 transition-transform" :class="{ 'rotate-180': open }" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute right-0 mt-2 w-44 overflow-hidden rounded-2xl border border-stone-200 bg-white p-2 shadow-lg">
                            @foreach (Settings::getLocales() as $locale => $label)
                                <a href="{{ route('set-locale', ['locale' => $locale]) }}"
                                   class="block rounded-xl px-3 py-2 text-sm text-stone-700 transition hover:bg-stone-100 hover:text-stone-950 {{ $locale == app()->getLocale() ? 'bg-stone-100 font-medium text-stone-950' : '' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="pb-16">
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <footer class="border-t border-stone-200 bg-white/70">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-8 text-sm text-stone-600 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <p>&copy; {{ date('Y') }} Basic CRUD. A quieter interface for everyday publishing.</p>
            <div class="flex flex-wrap items-center gap-4">
                <span>Built with Laravel and Tailwind CSS.</span>
                <a href="https://github.com/mr-punyapal/basic-crud" target="_blank" rel="noopener noreferrer" class="font-medium text-stone-950 transition hover:text-red-600">GitHub</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
