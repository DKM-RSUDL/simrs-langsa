@props([
    'href' => url()->previous(),
    'class' => 'btn btn-outline-secondary w-min d-flex align-items-center gap-2',
])

<a href="{{ $href }}" {{ $attributes->merge(['class' => $class]) }}>
    <i class="ti-arrow-left"></i>
   {{ $slot->isEmpty() ? 'Kembali' : $slot }}
</a>
