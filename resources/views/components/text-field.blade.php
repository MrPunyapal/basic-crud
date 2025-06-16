@props([
    'multiline' => false,
])

@php
    $class = implode(' ', [
        'w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/70 backdrop-blur-sm text-slate-900 placeholder-slate-500',
        'focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none',
        'hover:border-slate-300 transition-all duration-200',
        'disabled:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50',
        $multiline ? 'min-h-[120px] resize-y' : 'h-12',
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
