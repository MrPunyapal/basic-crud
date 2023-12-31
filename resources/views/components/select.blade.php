@php
    $class = implode(' ', [
        'appearance-none block w-full rounded-lg bg-white border text-sm/6 py-[calc(theme(spacing[1.5])+theme(spacing.px))] px-3 border-zinc-950/10',
        // focus
        'focus:border-zinc-950/20 focus:outline focus:outline-offset-2 focus:outline-2 focus:outline-blue-500',
        // hover
        'hover:border-zinc-950/20',
    ]);
@endphp

<select {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</select>
