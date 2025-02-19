<div class="modal fade" id="modal-create-riwayat-obat" tabindex="-1" aria-labelledby="verticalCenterLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="verticalCenterLabel">Tambah Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formRiwayatObat">
                    <div class="mb-3">
                        <label class="form-label">Nama Obat</label>
                        <input type="text" class="form-control" id="namaObat" placeholder="nama obat">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small">Frekuensi/interval</label>
                                <select class="form-select" id="frekuensi">
                                    <option value="1 x 1 hari">1 x 1 hari</option>
                                    <option value="2 x 1 hari">2 x 1 hari</option>
                                    <option value="3 x 1 hari" selected>3 x 1 hari</option>
                                    <option value="4 x 1 hari">4 x 1 hari</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keterangan</label>
                                <select class="form-select" id="keterangan">
                                    <option value="Sebelum Makan">Sebelum Makan</option>
                                    <option value="Sesudah Makan" selected>Sesudah Makan</option>
                                    <option value="Saat Makan">Saat Makan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Dosis sekali minum</label>
                            <select class="form-select" id="dosis">
                                <option value="1/4">1/4</option>
                                <option value="1/2" selected>1/2</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" value="Tablet">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnTambahObat">Tambah Obat</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#btn-riwayat-obat').on('click', function() {
        $('#modal-create-riwayat-obat').modal('show');
    });

    $(document).ready(function() {
        // Inisialisasi data dari database jika ada
        let dataObat = @json($dataResume->riwayat_penggunaan_obat ?? []);

        // Fungsi untuk memperbarui tabel dan hidden input
        function updateTable() {
            let tableBody = '';
            dataObat.forEach((obat, index) => {
                // Format dosis untuk tampilan
                const dosisDisplay = `${obat.dosis} ${obat.satuan} ${obat.frekuensi}`;

                tableBody += `
                <tr>
                    <td>${obat.namaObat}</td>
                    <td>${dosisDisplay}</td>
                    <td>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>${obat.keterangan}</span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-link edit-obat" data-index="${index}">
                                    <i class="bi bi-pencil text-primary"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-link delete-obat" data-index="${index}">
                                    <i class="bi bi-trash text-danger"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
            });

            $('#createRiwayatObatTable tbody').html(tableBody);
            updateHiddenInput();
        }

        // Fungsi untuk update hidden input
        function updateHiddenInput() {
            $('#riwayatObatData').val(JSON.stringify(dataObat));
        }

        // Fungsi untuk reset form dengan nilai default
        function resetForm() {
            $('#formRiwayatObat')[0].reset();
            setDefaultValues();
        }

        // Fungsi untuk set nilai default
        function setDefaultValues() {
            $('#dosis').val('1/2');
            $('#satuan').val('Tablet');
            $('#frekuensi').val('3 x 1 hari');
            $('#keterangan').val('Sesudah Makan');
        }

        // Event handler untuk tombol Tambah Obat
        $('#btnTambahObat').click(function() {
            const obat = {
                namaObat: $('#namaObat').val().trim(),
                frekuensi: $('#frekuensi').val(),
                dosis: $('#dosis').val(),
                satuan: $('#satuan').val(),
                keterangan: $('#keterangan').val()
            };

            if (!obat.namaObat) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Nama obat harus diisi!'
                });
                return;
            }

            // Cek duplikasi
            const isDuplicate = dataObat.some(item =>
                item.namaObat.toLowerCase() === obat.namaObat.toLowerCase() &&
                item.dosis === obat.dosis &&
                item.satuan === obat.satuan
            );

            if (isDuplicate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Obat dengan dosis yang sama sudah ada dalam daftar!'
                });
                return;
            }

            dataObat.push(obat);
            updateTable();
            $('#modal-create-riwayat-obat').modal('hide');
            resetForm();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data obat berhasil ditambahkan',
                timer: 1500,
                showConfirmButton: false
            });
        });

        // Event handler untuk tombol Edit
        $(document).on('click', '.edit-obat', function() {
            const index = $(this).data('index');
            const obat = dataObat[index];

            $('#namaObat').val(obat.namaObat);
            $('#frekuensi').val(obat.frekuensi);
            $('#dosis').val(obat.dosis);
            $('#satuan').val(obat.satuan);
            $('#keterangan').val(obat.keterangan);

            dataObat.splice(index, 1);
            $('#modal-create-riwayat-obat').modal('show');
        });

        // Event handler untuk tombol Delete
        $(document).on('click', '.delete-obat', function() {
            const index = $(this).data('index');
            const obat = dataObat[index];

            Swal.fire({
                title: 'Hapus Obat',
                text: `Apakah Anda yakin ingin menghapus ${obat.namaObat}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    dataObat.splice(index, 1);
                    updateTable();

                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'Data obat berhasil dihapus',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Reset form saat modal ditutup
        $('#modal-create-riwayat-obat').on('hidden.bs.modal', function() {
            resetForm();
        });

        // Inisialisasi tampilan awal
        updateTable();
    });
</script>
