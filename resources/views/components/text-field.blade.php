@props([
    'multiline' => false,
])

@php
    $class = implode(' ', [
        'appearance-none block w-full rounded-lg bg-white border text-sm/6 h-9 px-3 border-zinc-950/10',
        // focus
        'focus:border-zinc-950/20 focus:outline focus:outline-offset-2 focus:outline-2 focus:outline-blue-500',
        // hover
        'hover:border-zinc-950/20',
    ]);

    $attrs = $attributes->merge([
        'class' => $class,
    ]);

    if (! $multiline) {
        $attrs = $attrs->merge(['type' => 'text']);
    }
@endphp

@if ($multiline)
    <textarea {{ $attrs }}>{{ $slot }}</textarea>
@else
    <input {{ $attrs }} />
@endif
