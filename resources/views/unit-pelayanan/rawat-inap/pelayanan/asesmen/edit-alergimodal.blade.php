<button type="button" class="btn btn-sm" id="openEditAlergiModal">
    <i class="bi bi-plus-square"></i> Tambah
</button>

<div class="modal fade" id="editAlergiModal" tabindex="-1" aria-labelledby="editAlergiModalLabel" aria-hidden="true"
    style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAlergiModalLabel">Edit Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAlergiForm">
                    <h6 class="fw-bold">Tambah Alergi</h6>
                    <p class="text-muted">(Isi informasi alergi pada kolom di bawah dan Tekan tambah untuk menambah ke
                        daftar alergi)</p>
                    <div class="mb-3">
                        <select class="form-select" id="editJenisAlergiInput">
                            <option value="">Pilih Jenis</option>
                            <option value="Obat">Obat</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Udara">Udara</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="editAlergenInput" placeholder="Nama Alergen"
                            autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="editReaksiInput" placeholder="Reaksi"
                            autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <select class="form-select" id="editTingkatKeparahanInput">
                            <option value="">Pilih Tingkat Keparahan</option>
                            <option value="Ringan">Ringan</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Berat">Berat</option>
                        </select>
                    </div>
                    <button type="button" id="btnEditListAlergi" class="btn btn-sm btn-primary mt-2">Tambah</button>
                </form>

                <h6 class="fw-bold mt-5">Daftar Alergi</h6>
                <ul id="editListAlergi" class="list-unstyled"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btnSaveEditAlergi" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Deklarasikan variabel untuk modal dan data di scope yang bisa diakses
        let editAlergiModal;
        let editAlergis = [];

        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi modal
            editAlergiModal = new bootstrap.Modal(document.getElementById('editAlergiModal'));

            // Fungsi untuk mengupdate tampilan list di modal
            function updateEditModalView() {
                const editListAlergi = document.getElementById('editListAlergi');
                if (!editListAlergi) return;

                if (editAlergis.length === 0) {
                    editListAlergi.innerHTML = '<li class="text-muted">Tidak ada data alergi</li>';
                    return;
                }

                editListAlergi.innerHTML = editAlergis.map((a, index) => `
                <li class="d-flex justify-content-between align-items-center mb-2">
                    <span>${a.jenis} - ${a.alergen} - ${a.reaksi} (${a.keparahan})</span>
                    <button class="btn btn-sm btn-link delete-modal-alergi p-0" data-index="${index}">
                        <i class="bi bi-trash-fill text-danger"></i>
                    </button>
                </li>
            `).join('');
            }

            // Fungsi untuk mengupdate tampilan tabel
            function updateEditTableView() {
                const tbody = $('#editAlergiTable tbody');
                tbody.empty();

                if (editAlergis.length === 0) {
                    tbody.html(`
                    <tr>
                        <td colspan="5" class="text-center">
                            <em>Tidak ada data alergi</em>
                        </td>
                    </tr>
                `);
                    return;
                }

                editAlergis.forEach((alergi, index) => {
                    const row = `
                    <tr>
                        <td>${alergi.jenis || '-'}</td>
                        <td>${alergi.alergen || '-'}</td>
                        <td>${alergi.reaksi || '-'}</td>
                        <td>${alergi.keparahan || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger delete-edit-alergi" data-index="${index}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    tbody.append(row);
                });
            }

            // Fungsi untuk mereset form
            function resetEditForm() {
                $('#editJenisAlergiInput').val('');
                $('#editAlergenInput').val('');
                $('#editReaksiInput').val('');
                $('#editTingkatKeparahanInput').val('');
            }

            // Event handler untuk membuka modal
            $(document).on('click', '#openEditAlergiModal', function(event) {
                event.preventDefault();
                event.stopPropagation();
                console.log('Opening modal with data:', originalAlergiData); // Debug log

                // Reset form dan data
                resetEditForm();
                editAlergis = Array.isArray(originalAlergiData) ? [...originalAlergiData] :
                    (originalAlergiData ? [originalAlergiData] : []);

                updateEditModalView();
                editAlergiModal.show();
            });

            // Event handler untuk menambah alergi
            $(document).on('click', '#btnEditListAlergi', function(e) {
                e.preventDefault();
                console.log('Add button clicked'); // Debug log

                const jenisAlergi = $('#editJenisAlergiInput').val();
                const alergen = $('#editAlergenInput').val();
                const reaksi = $('#editReaksiInput').val();
                const keparahan = $('#editTingkatKeparahanInput').val();

                console.log('Form values:', {
                    jenisAlergi,
                    alergen,
                    reaksi,
                    keparahan
                }); // Debug log

                if (!jenisAlergi || !alergen || !reaksi || !keparahan) {
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Harap isi semua field alergi',
                        icon: 'warning'
                    });
                    return;
                }

                editAlergis.push({
                    jenis: jenisAlergi,
                    alergen: alergen,
                    reaksi: reaksi,
                    keparahan: keparahan
                });

                console.log('Updated editAlergis:', editAlergis); // Debug log

                resetEditForm();
                updateEditModalView();
            });

            // Event handler untuk menyimpan perubahan
            $(document).on('click', '#btnSaveEditAlergi', function(e) {
                e.preventDefault();
                console.log('Saving data:', editAlergis); // Debug log

                originalAlergiData = [...editAlergis];
                updateEditTableView();
                editAlergiModal.hide();
            });

            // Event handler untuk menghapus dari modal
            $(document).on('click', '.delete-modal-alergi', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const index = $(this).data('index');
                editAlergis.splice(index, 1);
                updateEditModalView();
            });

            // Event handler untuk menghapus dari tabel
            $(document).on('click', '.delete-edit-alergi', function(e) {
                e.preventDefault();
                const index = $(this).data('index');
                editAlergis.splice(index, 1);
                originalAlergiData = [...editAlergis];
                updateEditTableView();
            });

            // Prevent modal from closing parent
            $('#editAlergiModal').on('hidden.bs.modal', function(event) {
                event.stopPropagation();
                resetEditForm();
            });
        });

        // Fungsi untuk mengumpulkan data alergi (digunakan saat submit form utama)
        function collectEditAlergi() {
            console.log('Collecting alergi data:', originalAlergiData); // Debug log
            return originalAlergiData;
        }
    </script>
@endpush
