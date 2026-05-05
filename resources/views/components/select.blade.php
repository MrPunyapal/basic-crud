@php
    $class = implode(' ', [
        'w-full rounded-2xl border border-stone-300 bg-white px-4 py-3 text-sm text-stone-900 shadow-sm transition',
        'focus:border-red-500 focus:outline-none focus:ring-4 focus:ring-red-500/10',
        'disabled:cursor-not-allowed disabled:bg-stone-100 disabled:text-stone-500',
    ]);
@endphp

<select {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</select>
