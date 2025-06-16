@php
    $class = implode(' ', [
        'w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/70 backdrop-blur-sm text-slate-900',
        'focus:border-blue-500 focus:ring-2 focus:ring-blue-200 focus:outline-none',
        'hover:border-slate-300 transition-all duration-200',
        'disabled:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-50',
        'appearance-none bg-no-repeat bg-right bg-[length:20px] bg-[url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3e%3cpath stroke=\'%236b7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'m6 8 4 4 4-4\'/%3e%3c/svg%3e")]',
    ]);
@endphp

<select {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</select>
