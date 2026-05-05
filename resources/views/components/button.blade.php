@props([
    'color' => 'zinc',
    'href' => null,
])

@php
$class = implode(' ', [
    'inline-flex items-center justify-center rounded-full border px-4 py-2 text-sm font-medium transition',
    'focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600',
    'disabled:cursor-not-allowed disabled:opacity-50',
]);
$colorClass = [
    'blue' => 'border-stone-950 bg-stone-950 text-white hover:border-stone-800 hover:bg-stone-800',
    'green' => 'border-stone-950 bg-stone-950 text-white hover:border-stone-800 hover:bg-stone-800',
    'red' => 'border-red-200 bg-red-50 text-red-700 hover:border-red-300 hover:bg-red-100',
    'yellow' => 'border-amber-200 bg-amber-50 text-amber-800 hover:border-amber-300 hover:bg-amber-100',
    'zinc' => 'border-stone-300 bg-white text-stone-700 hover:border-stone-400 hover:text-stone-950',
    'purple' => 'border-stone-950 bg-stone-950 text-white hover:border-stone-800 hover:bg-stone-800',
    'indigo' => 'border-stone-950 bg-stone-950 text-white hover:border-stone-800 hover:bg-stone-800',
][$color] ?? 'border-stone-300 bg-white text-stone-700 hover:border-stone-400 hover:text-stone-950';
@endphp

@isset($href)
    <a {{ $attributes->merge(['class' => "$class $colorClass"]) }} href="{{ $href }}">
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['class' => "$class $colorClass"]) }}>
        {{ $slot }}
    </button>
@endisset
