@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Attach SweetAlert to all delete forms
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data Resiko Jatuh Skala Morse ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Filter button functionality
            document.getElementById('filterButton').addEventListener('click', function(e) {
                e.preventDefault();

                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const currentUrl = new URL(window.location);

                if (startDate) {
                    currentUrl.searchParams.set('start_date', startDate);
                } else {
                    currentUrl.searchParams.delete('start_date');
                }

                if (endDate) {
                    currentUrl.searchParams.set('end_date', endDate);
                } else {
                    currentUrl.searchParams.delete('end_date');
                }

                // Reset pagination
                currentUrl.searchParams.delete('page');

                window.location.href = currentUrl.toString();
            });

            // Clear filter when dates are cleared
            document.getElementById('start_date').addEventListener('change', function() {
                if (!this.value && !document.getElementById('end_date').value) {
                    const currentUrl = new URL(window.location);
                    currentUrl.searchParams.delete('start_date');
                    currentUrl.searchParams.delete('end_date');
                    currentUrl.searchParams.delete('page');
                    window.location.href = currentUrl.toString();
                }
            });

            document.getElementById('end_date').addEventListener('change', function() {
                if (!this.value && !document.getElementById('start_date').value) {
                    const currentUrl = new URL(window.location);
                    currentUrl.searchParams.delete('start_date');
                    currentUrl.searchParams.delete('end_date');
                    currentUrl.searchParams.delete('page');
                    window.location.href = currentUrl.toString();
                }
            });
        });
    </script>
@endpush
