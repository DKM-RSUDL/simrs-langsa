@props([
    'class' => 'card h-auto',
    'bodyClass' => 'card-body d-flex flex-column gap-4',
])

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class="{{ $bodyClass }}">
        {{ $slot }}
    </div>
</div>
