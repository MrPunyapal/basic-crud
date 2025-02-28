@props([
    'color' => 'zinc',
    'href' => null,
])

@php
$class = implode(' ', [
    'inline-flex h-9 px-3 items-center justify-center rounded-lg text-sm/6 font-medium bg-(--button-background-color) border border-(--button-border-color)',
    // focus
    'focus:outline-hidden focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500',
]);
$colorClass = [
    'blue' => implode(' ', [
        'text-white [--button-background-color:var(--color-blue-600)] [--button-border-color:var(--color-blue-700)]/80',
        // hover
        'hover:[--button-background-color:var(--color-blue-600)]/90'
    ]),
    'green' => implode(' ', [
        'text-white [--button-background-color:var(--color-green-600)] [--button-border-color:var(--color-green-700)]/80',
        // hover
        'hover:[--button-background-color:var(--color-green-600)]/90'
    ]),
    'red' => implode(' ', [
        'text-white [--button-background-color:var(--color-red-600)] [--button-border-color:var(--color-red-700)]/80',
        // hover
        'hover:[--button-background-color:var(--color-red-600)]/90'
    ]),
    'yellow' => implode(' ', [
        'text-yellow-950 [--button-background-color:var(--color-yellow-300)] [--button-border-color:var(--color-yellow-400)]/80',
        // hover
        'hover:[--button-background-color:var(--color-yellow-300)]/90'
    ]),
    'zinc' => implode(' ', [
        'text-white [--button-background-color:var(--color-zinc-600)] [--button-border-color:var(--color-zinc-700)]/80',
        // hover
        'hover:[--button-background-color:var(--color-zinc-600)]/90'
    ]),
][$color];
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
