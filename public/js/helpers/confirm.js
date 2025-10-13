// Confirmation dialog using SweetAlert2
window.swalConfirm = function (options = {}) {
    const defaults = {
        title: "Anda yakin?",
        text: "Aksi ini tidak dapat dibatalkan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
    };
    const cfg = Object.assign({}, defaults, options);
    return Swal.fire(cfg).then((result) => result.isConfirmed);
};

// Delegated handler: tombol dengan atribut data-confirm akan memicu dialog dan submit form terdekat
document.addEventListener("click", function (e) {
    const el = e.target.closest("[data-confirm]");
    if (!el) return;
    e.preventDefault();

    // prefer data-* attrs, fallback to title attribute for accessibility/tooltip
    const title = el.dataset.confirmTitle || el.getAttribute('title') || undefined;
    const text = el.dataset.confirmText || el.getAttribute('data-confirm-text') || undefined;
    const ok = el.dataset.confirmOk;
    const cancel = el.dataset.confirmCancel;

    // build options only with defined values so defaults are preserved
    const opts = {};
    if (title !== undefined) opts.title = title;
    if (text !== undefined) opts.text = text;
    if (ok !== undefined) opts.confirmButtonText = ok;
    if (cancel !== undefined) opts.cancelButtonText = cancel;

    window.swalConfirm(opts).then((confirmed) => {
        if (!confirmed) return;
        const form = el.closest("form");
        if (form) form.submit();
        const cb = el.dataset.confirmCallback;
        if (cb && typeof window[cb] === "function") window[cb](el);
    });
});
