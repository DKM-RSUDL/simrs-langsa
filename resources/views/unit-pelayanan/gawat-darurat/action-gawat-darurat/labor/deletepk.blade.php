<!-- Form Hapus (dihilangkan dari modal, tetap ada untuk digunakan oleh JS) -->
<form id="delete-form-{{ $laborPK->kd_order }}"
    action="{{ route('labor.destroy', [$laborPK->kd_order, $laborPK->kd_pasien, $laborPK->tgl_masuk]) }}" method="POST"
    style="display: none;">
    @method('DELETE')
    @csrf
</form>


@push('js')
    <script>
        // sweetalert hapus data
        function confirmDelete(orderId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data ini tidak bisa dikembalikan setelah dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form jika pengguna mengonfirmasi penghapusan
                    document.getElementById('delete-form-' + orderId).submit();
                }
            });
        }
    </script>
@endpush
