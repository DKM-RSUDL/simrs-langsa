<div class="modal fade" id="modal-create-alergi" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallModalLabel">Input ALERGI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="elergi" class="form-label">Input ALERGI</label>
                <input class="form-control" id="elergi" name="alergi">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="btn-simpan-alergi">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Inisialisasi array alergi dari data yang ada
            let alergiList = @json($dataResume->alergi ?? []);

            // Fungsi untuk menampilkan daftar alergi
            function displayAlergi() {
                const listContainer = $('#list-alergi');
                listContainer.empty();

                if (alergiList.length === 0) {
                    listContainer.append('<li class="list-group-item text-muted">Belum ada data alergi</li>');
                    return;
                }

                alergiList.forEach((item, index) => {
                    const listItem = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ${item}
                        <button type="button" class="btn remove-alergi" data-index="${index}">
                            <i class="fas fa-times text-danger"></i>
                        </button>
                    </li>
                `;
                    listContainer.append(listItem);
                });
            }

            // Tampilkan alergi yang sudah ada saat halaman dimuat
            displayAlergi();

            // Handler untuk menampilkan modal tambah alergi
            $('#btn-create-alergi').on('click', function() {
                $('#modal-create-alergi').modal('show');
            });

            // Handler untuk menyimpan alergi baru
            $('#btn-simpan-alergi').on('click', function() {
                const alergiValue = $('#elergi').val().trim();

                if (!alergiValue) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan masukkan alergi terlebih dahulu!'
                    });
                    return;
                }

                // Cek duplikasi
                if (alergiList.includes(alergiValue)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Alergi ini sudah ada dalam daftar!'
                    });
                    return;
                }

                // Tambahkan alergi baru
                alergiList.push(alergiValue);

                // Perbarui tampilan
                displayAlergi();

                // Reset form dan tutup modal
                $('#elergi').val('');
                $('#modal-create-alergi').modal('hide');

                // Tampilkan notifikasi sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Alergi berhasil ditambahkan',
                    timer: 1500,
                    showConfirmButton: false
                });
            });

            // Handler untuk menghapus alergi
            $('#list-alergi').on('click', '.remove-alergi', function() {
                const index = $(this).data('index');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah Anda yakin ingin menghapus alergi ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        alergiList.splice(index, 1);
                        displayAlergi();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Alergi berhasil dihapus',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Reset input saat modal ditutup
            $('#modal-create-alergi').on('hidden.bs.modal', function() {
                $('#elergi').val('');
            });
        });
    </script>
@endpush
