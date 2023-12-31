@props([
    'multiline' => false,
    'value' => '',
])

@php
$class = 'block w-full rounded-lg bg-white border text-sm/6 py-1.5 px-3 border-zinc-950/10';

$attrs = $attributes->merge([
    'class' => $class,
]);

if (! $multiline) {
    $attrs = $attrs->merge(['type' => 'text']);
}
@endphp

@if($multiline)
    <textarea {{ $attrs }}>{{ $value }}</textarea>
@else
    <input {{ $attrs }} value="{{ $value }}" />
@endif
