@props([
    'id' => 'global-button-submit-confirm',
    'type' => 'submit',
    'class' => 'btn btn-primary',
    'size' => null,
    'label' => 'Simpan',
    'title' => null,
    'icon' => null,

    // Loading
    'spinner' => true,
    'loadingLabel' => 'Memproses...',
    'loadingOverlay' => null,

    // SweetAlert
    'confirmTitle' => 'Simpan data?',
    'confirmText' => 'Pastikan semua isian sudah benar.',
    'confirmCancel' => 'Batal',
    'confirmOk' => 'Simpan',

    // Submit-once
    'submitOnce' => true,
])

@php
    $finalClass = trim($class . ' ' . ($size ?? ''));
    $loadingHTML = $spinner
        ? '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' .
            e($loadingLabel)
        : e($loadingLabel);
@endphp

<button
    {{ $attributes->merge([
        'id' => $id,
        'type' => $type,
        'class' => $finalClass,
        'title' => $title ?? $label,

        // --- SweetAlert ---
        'data-confirm' => true,
        'data-confirm-title' => $confirmTitle,
        'data-confirm-text' => $confirmText,
        'data-confirm-ok' => $confirmOk,
        'data-confirm-cancel' => $confirmCancel,

        // --- Loading & overlay ---
        'data-loading-text' => $loadingHTML,
        'data-loading-overlay' => $loadingOverlay,

        // --- Submit-once ---
        'data-submit-once' => $submitOnce ? 'true' : 'false',
        'data-loading-label' => $loadingLabel,
        'data-spinner' => $spinner ? '1' : '0',
    ]) }}>
    {!! $icon ?? '' !!}
    <span class="btn-text">{{ $slot->isEmpty() ? $label : $slot }}</span>
</button>

@once
    @push('scripts')
        <script>
            (function() {
                // SweetAlert helper
                window.swalConfirm = function(opts = {}) {
                    const defaults = {
                        title: "Anda yakin?",
                        text: "Aksi ini tidak dapat dibatalkan.",
                        icon: "warning",
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: "Ya",
                        cancelButtonText: "Tidak",
                    };
                    const cfg = Object.assign({}, defaults, opts);
                    if (window.Swal && typeof Swal.fire === "function") {
                        return Swal.fire(cfg).then(r => !!r.isConfirmed);
                    }
                    const msg = [cfg.title, cfg.text].filter(Boolean).join("\n\n");
                    return Promise.resolve(window.confirm(msg));
                };

                // Global handler tombol konfirmasi
                document.addEventListener("click", function(e) {
                    const el = e.target.closest("[data-confirm]");
                    if (!el) return;

                    const form = el.closest("form");
                    if (form && !form.reportValidity()) {
                        // Form invalid, browser akan tunjukkan pesan error
                        return;
                    }

                    e.preventDefault();

                    const opts = {
                        title: el.dataset.confirmTitle,
                        text: el.dataset.confirmText,
                        confirmButtonText: el.dataset.confirmOk,
                        cancelButtonText: el.dataset.confirmCancel,
                    };

                    window.swalConfirm(opts).then((ok) => {
                        if (!ok) return;

                        // Loading state
                        const loadingText = el.dataset.loadingText;
                        if (loadingText) {
                            el.disabled = true;
                            el.innerHTML = loadingText;
                        }
                        const overlaySel = el.dataset.loadingOverlay;
                        if (overlaySel) {
                            const overlay = document.querySelector(overlaySel);
                            if (overlay) overlay.style.display = "block";
                        }

                        // Submit hormati HTML5 validation
                        if (form) {
                            form.requestSubmit(el);
                        } else if (el.tagName === "A" && el.href) {
                            window.location.href = el.href;
                        }
                    });
                });

                // Submit-once: cegah double submit
                function initSubmitOnce(btn) {
                    if (!btn || btn.dataset.submitOnceInit === '1') return;
                    if (btn.dataset.submitOnce !== 'true') return;
                    btn.dataset.submitOnceInit = '1';

                    const form = btn.form || btn.closest('form');
                    if (!form) return;

                    form.addEventListener('submit', function() {
                        if (btn.disabled) return;
                        btn.disabled = true;
                        const showSpinner = btn.dataset.spinner === '1';
                        const loadingLabel = btn.dataset.loadingLabel || 'Memproses...';
                        const injected = btn.getAttribute('data-loading-text');

                        if (showSpinner) {
                            btn.innerHTML = injected ||
                                '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' +
                                loadingLabel;
                        } else {
                            btn.innerHTML = injected || loadingLabel;
                        }
                    }, {
                        once: false
                    });
                }

                function scan() {
                    document.querySelectorAll('button[data-submit-once="true"]').forEach(initSubmitOnce);
                }

                scan();
                document.addEventListener('DOMContentLoaded', scan);
                document.addEventListener('click', function(e) {
                    const btn = e.target.closest('button[data-submit-once="true"]');
                    if (btn) initSubmitOnce(btn);
                });
            })
            ();
        </script>
    @endpush
@endonce
