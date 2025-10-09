@props([
    'class' => 'card h-auto',
    'bodyClass' => 'card-body d-flex flex-column gap-3',
])

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class="{{ $bodyClass }}">
        {{ $slot }}
    </div>
</div>
