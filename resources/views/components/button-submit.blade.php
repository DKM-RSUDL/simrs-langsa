@props([
    'id' => null,
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'size' => null,               // contoh: 'btn-sm'
    'label' => 'Simpan',
    'loadingLabel' => 'Menyimpan...',
    'spinner' => true,            // true = tampilkan spinner
    'title' => null,              // tooltip optional
    'icon' => null,               // HTML ikon awal optional
])

<button
    {{ $attributes->merge([
        'id' => $id,
        'type' => $type,
        'class' => trim($class . ' ' . ($size ?? '')),
        'title' => $title ?? $label,
        'data-submit-once' => 'true',
        'data-loading-label' => $loadingLabel,
        'data-spinner' => $spinner ? '1' : '0',
    ]) }}
>
    {!! $icon ?? '' !!}
    <span class="btn-text">{{ $slot->isEmpty() ? $label : $slot }}</span>
</button>

@once
    @push('scripts')
        <script>
        (function () {
            function initSubmitOnce(btn) {
                if (!btn || btn.dataset.submitOnceInit === '1') return;
                btn.dataset.submitOnceInit = '1';

                var form = btn.form || btn.closest('form');
                if (!form) return;

                form.addEventListener('submit', function (e) {
                    if (btn.disabled) { e.preventDefault(); return; }
                    try {
                        btn.disabled = true;
                        var showSpinner = btn.dataset.spinner === '1';
                        var loadingLabel = btn.dataset.loadingLabel || 'Processing...';

                        if (showSpinner) {
                            btn.innerHTML =
                                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' +
                                loadingLabel;
                        } else {
                            var t = btn.querySelector('.btn-text');
                            if (t) t.textContent = loadingLabel; else btn.textContent = loadingLabel;
                        }
                    } catch (err) {
                        btn.disabled = true;
                    }
                }, { once: false });
            }

            // Inisialisasi awal
            document.querySelectorAll('button[data-submit-once="true"]').forEach(initSubmitOnce);

            // Saat DOM ready
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('button[data-submit-once="true"]').forEach(initSubmitOnce);
            });

            // Jaga-jaga untuk elemen yang muncul dinamis (Inertia/Livewire/Alpine)
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('button[data-submit-once="true"]');
                if (btn) initSubmitOnce(btn);
            });
        })();
        </script>
    @endpush
@endonce

