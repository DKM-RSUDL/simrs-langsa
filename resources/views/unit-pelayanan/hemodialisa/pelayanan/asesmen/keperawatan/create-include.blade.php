@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .progress-wrapper {
            background: #f8f9fa;
            border-radius: 8px;
        }

        .progress-status {
            display: flex;
            justify-content: space-between;
        }

        .progress-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        .progress-percentage {
            color: #198754;
            font-weight: 600;
        }

        .custom-progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-custom {
            height: 100%;
            background-color: #097dd6;
            transition: width 0.6s ease;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .form-group label {
            margin-right: 1rem;
            padding-top: 0.5rem;
        }

        .diagnosis-section {
            margin-top: 1.5rem;
        }

        .diagnosis-row {
            padding: 0.5rem 1rem;
            border-color: #dee2e6 !important;
        }

        .diagnosis-item {
            background-color: transparent;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .pain-scale-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .pain-scale-image {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Optional: Styling untuk tombol aktif */
        .tambah-keterangan.active {
            background-color: #0d6efd;
            color: white;
        }

        /* Style untuk field yang dimuat dari data lama */
        .loaded-from-previous {
            border-left: 3px solid #0d6efd !important;
            background-color: #f8fff9 !important;
        }

        .loaded-indicator {
            font-size: 12px;
            color: #0d6efd;
            font-style: italic;
            margin-top: 2px;
        }

        /* Perbaikan styling checkbox agar tanda centang terlihat jelas */
        .form-check-input {
            width: 1.2em !important;
            height: 1.2em !important;
            margin-top: 0.1em !important;
            border: 2px solid #6c757d !important;
            border-radius: 0.25em !important;
            background-color: #fff !important;
            position: relative !important;
        }

        .form-check-input:checked {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e") !important;
            background-size: 100% 100% !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
        }

        .form-check-input:focus {
            border-color: #86b7fe !important;
            outline: 0 !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        .form-check-input:checked.loaded-from-previous {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }

        /* Styling untuk checkbox label */
        .form-check-label {
            font-weight: 500 !important;
            margin-left: 0.5rem !important;
            cursor: pointer !important;
        }

        /* Hover effect untuk checkbox */
        .form-check-input:hover {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.1rem rgba(13, 110, 253, 0.15) !important;
        }
    </style>
@endpush

@push('js')
    <script>
        // 2. Pemeriksaan Fisik Antropometri
        // Ambil referensi ke elemen input
        const tinggiBadanInput = document.getElementById('tinggi_badan');
        const beratBadanInput = document.getElementById('berat_badan');
        const imtInput = document.getElementById('imt');
        const lptInput = document.getElementById('lpt');

        // Fungsi untuk menghitung IMT
        function hitungIMT() {
            const tinggiBadan = parseFloat(tinggiBadanInput.value) || 0;
            const beratBadan = parseFloat(beratBadanInput.value) || 0;

            // Pastikan kedua nilai diisi
            if (tinggiBadan > 0 && beratBadan > 0) {
                // Rumus IMT: Berat (kg) / (Tinggi (m))²
                const tinggiMeter = tinggiBadan / 100; // konversi cm ke m
                const imt = beratBadan / (tinggiMeter * tinggiMeter);

                // Tampilkan hasil dengan 2 angka desimal
                imtInput.value = imt.toFixed(2);
            } else {
                imtInput.value = '';
            }
        }

        // Fungsi untuk menghitung LPT (Luas Permukaan Tubuh) dengan rumus DuBois
        function hitungLPT() {
            const tinggiBadan = parseFloat(tinggiBadanInput.value) || 0;
            const beratBadan = parseFloat(beratBadanInput.value) || 0;

            // Pastikan kedua nilai diisi
            if (tinggiBadan > 0 && beratBadan > 0) {
                // Rumus DuBois: LPT(m²) = 0.007184 × tinggi(cm)^0.725 × berat(kg)^0.425
                const lpt = 0.007184 * Math.pow(tinggiBadan, 0.725) * Math.pow(beratBadan, 0.425);

                // Tampilkan hasil dengan 2 angka desimal
                lptInput.value = lpt.toFixed(2);
            } else {
                lptInput.value = '';
            }
        }

        // Jalankan perhitungan saat nilai tinggi atau berat berubah
        tinggiBadanInput.addEventListener('input', function () {
            hitungIMT();
            hitungLPT();
        });

        beratBadanInput.addEventListener('input', function () {
            hitungIMT();
            hitungLPT();
        });

        // Tunggu sampai DOM sepenuhnya dimuat
        document.addEventListener('DOMContentLoaded', function () {
            // Event handler untuk tombol tambah keterangan
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item').querySelector(
                        '.form-check-input');

                    // Toggle tampilan keterangan
                    if (keteranganDiv.style.display === 'none') {
                        keteranganDiv.style.display = 'block';
                        normalCheckbox.checked = false; // Uncheck normal checkbox
                    } else {
                        keteranganDiv.style.display = 'block';
                    }
                });
            });

            // Event handler untuk checkbox normal
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const keteranganDiv = this.closest('.pemeriksaan-item').querySelector(
                        '.keterangan');
                    if (this.checked) {
                        keteranganDiv.style.display = 'none';
                        keteranganDiv.querySelector('input').value = ''; // Reset input value
                    }
                });
            });
        });

        // 5. Riwayat Obat dan Rekomendasi Dokter
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi array kosong untuk data obat
            window.obatPasienData = [];
            window.obatDokterData = [];

            // Inisialisasi modal obat pasien
            const modalObatPasien = new bootstrap.Modal(document.getElementById('modalTambahObat'));

            // Inisialisasi modal obat dokter
            const modalObatDokter = new bootstrap.Modal(document.getElementById('modalTambahObatDokter'));

            // Fungsi untuk mengupdate input hidden dengan data JSON
            function updateObatPasienJSON() {
                document.getElementById('obat_pasien_json').value = JSON.stringify(window.obatPasienData);
            }

            function updateObatDokterJSON() {
                document.getElementById('obat_dokter_json').value = JSON.stringify(window.obatDokterData);
            }

            // Event listener untuk simpan obat pasien
            document.getElementById('btn-simpan-obat-pasien').addEventListener('click', function () {
                const id = document.getElementById('obat-pasien-id').value;
                const nama = document.getElementById('obat-pasien-nama').value;
                const dosis = document.getElementById('obat-pasien-dosis').value;
                const waktu = document.getElementById('obat-pasien-waktu').value;

                if (!nama) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Nama obat tidak boleh kosong',
                    });
                    return;
                }

                if (id) {
                    // Update
                    const index = window.obatPasienData.findIndex(item => item.id == id);
                    window.obatPasienData[index] = { id: parseInt(id), nama, dosis, waktu };

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data obat berhasil diperbarui',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    // Tambah baru
                    const newId = window.obatPasienData.length > 0 ? Math.max(...window.obatPasienData.map(item => item.id)) + 1 : 1;
                    window.obatPasienData.push({ id: newId, nama, dosis, waktu });

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data obat berhasil ditambahkan',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }

                renderObatPasienTable();
                updateObatPasienJSON(); // Update JSON di input hidden
                resetFormObatPasien();
                modalObatPasien.hide();
            });

            // Event listener untuk simpan obat dokter
            document.getElementById('btn-simpan-obat-dokter').addEventListener('click', function () {
                const id = document.getElementById('obat-dokter-id').value;
                const nama = document.getElementById('obat-dokter-nama').value;
                const dosis = document.getElementById('obat-dokter-dosis').value;
                const waktu = document.getElementById('obat-dokter-waktu').value;

                if (!nama) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Nama obat tidak boleh kosong',
                    });
                    return;
                }

                if (id) {
                    // Update
                    const index = window.obatDokterData.findIndex(item => item.id == id);
                    window.obatDokterData[index] = { id: parseInt(id), nama, dosis, waktu };

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data obat berhasil diperbarui',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else {
                    // Tambah baru
                    const newId = window.obatDokterData.length > 0 ? Math.max(...window.obatDokterData.map(item => item.id)) + 1 : 1;
                    window.obatDokterData.push({ id: newId, nama, dosis, waktu });

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data obat berhasil ditambahkan',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }

                renderObatDokterTable();
                updateObatDokterJSON(); // Update JSON di input hidden
                resetFormObatDokter();
                modalObatDokter.hide();
            });

            // Fungsi untuk render tabel obat pasien
            window.renderObatPasienTable = function () {
                const tableBody = document.getElementById('tableObatPasien');
                tableBody.innerHTML = '';

                if (window.obatPasienData.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = '<td colspan="4" class="text-center">Belum ada data obat</td>';
                    tableBody.appendChild(emptyRow);
                    return;
                }

                window.obatPasienData.forEach(item => {
                    const row = document.createElement('tr');
                    row.id = `obat-pasien-row-${item.id}`;

                    row.innerHTML = `
                                            <td>${item.nama}</td>
                                            <td>${item.dosis}</td>
                                            <td>${item.waktu}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editObatPasien(${item.id})">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeObatPasien(${item.id})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        `;

                    tableBody.appendChild(row);
                });

                // Update JSON dalam input hidden
                updateObatPasienJSON();
            };

            // Fungsi untuk render tabel obat dokter
            window.renderObatDokterTable = function () {
                const tableBody = document.getElementById('tableObatDokter');
                tableBody.innerHTML = '';

                if (window.obatDokterData.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = '<td colspan="4" class="text-center">Belum ada data obat tambahan</td>';
                    tableBody.appendChild(emptyRow);
                    return;
                }

                window.obatDokterData.forEach(item => {
                    const row = document.createElement('tr');
                    row.id = `obat-dokter-row-${item.id}`;

                    row.innerHTML = `
                                            <td>${item.nama}</td>
                                            <td>${item.dosis}</td>
                                            <td>${item.waktu}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="editObatDokter(${item.id})">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeObatDokter(${item.id})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        `;

                    tableBody.appendChild(row);
                });

                // Update JSON dalam input hidden
                updateObatDokterJSON();
            };

            // Reset form obat pasien
            function resetFormObatPasien() {
                document.getElementById('obat-pasien-id').value = '';
                document.getElementById('obat-pasien-nama').value = '';
                document.getElementById('obat-pasien-dosis').value = '';
                document.getElementById('obat-pasien-waktu').value = '';
            }

            // Reset form obat dokter
            function resetFormObatDokter() {
                document.getElementById('obat-dokter-id').value = '';
                document.getElementById('obat-dokter-nama').value = '';
                document.getElementById('obat-dokter-dosis').value = '';
                document.getElementById('obat-dokter-waktu').value = '';
            }

            // Event listener untuk tombol tambah obat pasien
            document.querySelector('[data-bs-target="#modalTambahObat"]').addEventListener('click', function () {
                resetFormObatPasien();
            });

            // Event listener untuk tombol tambah obat dokter
            document.querySelector('[data-bs-target="#modalTambahObatDokter"]').addEventListener('click', function () {
                resetFormObatDokter();
            });

            // Fungsi edit obat pasien
            window.editObatPasien = function (id) {
                const item = window.obatPasienData.find(item => item.id === id);
                if (item) {
                    document.getElementById('obat-pasien-id').value = item.id;
                    document.getElementById('obat-pasien-nama').value = item.nama;
                    document.getElementById('obat-pasien-dosis').value = item.dosis;
                    document.getElementById('obat-pasien-waktu').value = item.waktu;

                    modalObatPasien.show();
                }
            };

            // Fungsi hapus obat pasien
            window.removeObatPasien = function (id) {
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data obat akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.obatPasienData = window.obatPasienData.filter(item => item.id !== id);
                        renderObatPasienTable();
                        updateObatPasienJSON();

                        Swal.fire(
                            'Terhapus!',
                            'Data obat berhasil dihapus.',
                            'success'
                        );
                    }
                });
            };

            // Fungsi edit obat dokter
            window.editObatDokter = function (id) {
                const item = window.obatDokterData.find(item => item.id === id);
                if (item) {
                    document.getElementById('obat-dokter-id').value = item.id;
                    document.getElementById('obat-dokter-nama').value = item.nama;
                    document.getElementById('obat-dokter-dosis').value = item.dosis;
                    document.getElementById('obat-dokter-waktu').value = item.waktu;

                    modalObatDokter.show();
                }
            };

            // Fungsi hapus obat dokter
            window.removeObatDokter = function (id) {
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data obat akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.obatDokterData = window.obatDokterData.filter(item => item.id !== id);
                        renderObatDokterTable();
                        updateObatDokterJSON();

                        Swal.fire(
                            'Terhapus!',
                            'Data obat berhasil dihapus.',
                            'success'
                        );
                    }
                });
            };

            // Render data awal
            renderObatPasienTable();
            renderObatDokterTable();

            // Jika ada data dari server, muat data tersebut
            if (typeof initialObatPasienData !== 'undefined' && Array.isArray(initialObatPasienData)) {
                window.obatPasienData = initialObatPasienData;
                renderObatPasienTable();
            }

            if (typeof initialObatDokterData !== 'undefined' && Array.isArray(initialObatDokterData)) {
                window.obatDokterData = initialObatDokterData;
                renderObatDokterTable();
            }
        });

        // Fungsi edit obat pasien
        function editObatPasien(id) {
            const modalObatPasien = new bootstrap.Modal(document.getElementById('modalTambahObat'));
            const item = window.obatPasienData.find(item => item.id === id);

            if (item) {
                document.getElementById('obat-pasien-id').value = item.id;
                document.getElementById('obat-pasien-nama').value = item.nama;
                document.getElementById('obat-pasien-dosis').value = item.dosis;
                document.getElementById('obat-pasien-waktu').value = item.waktu;

                modalObatPasien.show();
            }
        }

        // Fungsi hapus obat pasien
        function removeObatPasien(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data obat yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.obatPasienData = window.obatPasienData.filter(item => item.id !== id);
                    window.renderObatPasienTable();

                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'Data obat berhasil dihapus.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }

        // Fungsi edit obat dokter
        function editObatDokter(id) {
            const modalObatDokter = new bootstrap.Modal(document.getElementById('modalTambahObatDokter'));
            const item = window.obatDokterData.find(item => item.id === id);

            if (item) {
                document.getElementById('obat-dokter-id').value = item.id;
                document.getElementById('obat-dokter-nama').value = item.nama;
                document.getElementById('obat-dokter-dosis').value = item.dosis;
                document.getElementById('obat-dokter-waktu').value = item.waktu;

                modalObatDokter.show();
            }
        }

        // Fungsi hapus obat dokter
        function removeObatDokter(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data obat yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.obatDokterData = window.obatDokterData.filter(item => item.id !== id);
                    window.renderObatDokterTable();

                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: 'Data obat berhasil dihapus.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }

        // Fungsi untuk menyimpan data ke database (contoh implementasi AJAX)
        function saveToDatabase() {
            // Tambahkan spinner atau indikator loading
            Swal.fire({
                title: 'Menyimpan data...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Data yang akan dikirim
            const data = {
                obat_pasien: window.obatPasienData,
                obat_dokter: window.obatDokterData
            };

            // AJAX request
            fetch('/api/save-obat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Semua data obat berhasil disimpan',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Terjadi kesalahan saat menyimpan data',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan pada server',
                    });
                });
        }

        // Fungsi untuk memuat data dari server (jika perlu)
        function loadDataFromServer() {
            // AJAX request untuk memuat data
            fetch('/api/get-obat', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.obatPasienData = data.obat_pasien || [];
                        window.obatDokterData = data.obat_dokter || [];

                        renderObatPasienTable();
                        renderObatDokterTable();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data obat berhasil dimuat',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Terjadi kesalahan saat memuat data',
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan pada server saat memuat data',
                    });
                });
        }

        // 9. Risiko Jatuh
        $(document).ready(function () {
            // Konstanta untuk skor risiko
            const RISIKO_RENDAH = 0;
            const RISIKO_SEDANG = 25;
            const RISIKO_TINGGI = 45;

            // Fungsi untuk menghitung total skor
            function hitungTotalSkor() {
                let totalSkor = 0;

                // Iterasi setiap select yang memiliki class risiko-jatuh-select dan telah dipilih (tidak disabled)
                $('.risiko-jatuh-select').each(function () {
                    const selectedOption = $(this).find('option:selected');
                    if (!selectedOption.is(':disabled')) {
                        const skor = parseInt(selectedOption.data('skor') || 0);
                        totalSkor += skor;
                    }
                });

                return totalSkor;
            }

            // Fungsi untuk menentukan kesimpulan berdasarkan skor
            function tentukanKesimpulan(skor) {
                if (skor >= RISIKO_TINGGI) {
                    return "Risiko Tinggi";
                } else if (skor >= RISIKO_SEDANG) {
                    return "Risiko Sedang";
                } else {
                    return "Risiko Rendah";
                }
            }

            // Fungsi untuk mewarnai background kesimpulan
            function updateWarnaBgKesimpulan(kesimpulan) {
                const container = $('#kesimpulan-container');

                // Reset class
                container.removeClass('alert-primary alert-warning alert-danger');

                // Set class berdasarkan kesimpulan
                switch (kesimpulan) {
                    case "Risiko Tinggi":
                        container.addClass('alert-danger');
                        break;
                    case "Risiko Sedang":
                        container.addClass('alert-warning');
                        break;
                    case "Risiko Rendah":
                        container.addClass('alert-success');
                        break;
                    default:
                        container.addClass('alert-primary');
                }
            }

            // Fungsi untuk update tampilan
            function updateTampilan() {
                const totalSkor = hitungTotalSkor();
                const kesimpulan = tentukanKesimpulan(totalSkor);

                // Update tampilan
                $('#total-skor').text(totalSkor);
                $('#kesimpulan-text').text(kesimpulan);

                // Update warna background kesimpulan
                updateWarnaBgKesimpulan(kesimpulan);

                // Update hidden input untuk database
                $('#risiko_jatuh_skor').val(totalSkor);
                $('#risiko_jatuh_kesimpulan').val(kesimpulan);
            }

            // Event handler untuk perubahan select
            $('.risiko-jatuh-select').change(function () {
                updateTampilan();
            });

            // Inisialisasi saat halaman load
            updateTampilan();

            // Jika ada data dari server, set nilai select
            if (typeof initialRisikoJatuhData !== 'undefined') {
                const data = initialRisikoJatuhData;

                // Set nilai select dari data
                $('#riwayat_jatuh').val(data.riwayat_jatuh);
                $('#diagnosa_sekunder').val(data.diagnosa_sekunder);
                $('#alat_bantu').val(data.alat_bantu);
                $('#infus').val(data.infus);
                $('#cara_berjalan').val(data.cara_berjalan);
                $('#status_mental').val(data.status_mental);

                // Update tampilan
                updateTampilan();
            }
        });

        $(document).ready(function () {
            // Inisialisasi datepicker
            $('.datepicker').datepicker({
                format: 'd M yyyy',
                autoclose: true,
                todayHighlight: true
            });

            // Set tanggal hari ini sebagai default
            // const today = new Date();
            // $('#tanggal_pengkajian_psiko').datepicker('setDate', today);

            // Update hidden input saat checkbox berubah
            $('input[name="kondisi_psikologis[]"]').change(function () {
                updateKondisiPsikologisJSON();
            });

            // Fungsi untuk memperbarui input JSON kondisi psikologis
            function updateKondisiPsikologisJSON() {
                const selectedValues = [];
                $('input[name="kondisi_psikologis[]"]:checked').each(function () {
                    selectedValues.push($(this).val());
                });
                $('#kondisi_psikologis_json').val(JSON.stringify(selectedValues));
            }

            // Set initial value
            updateKondisiPsikologisJSON();

            // Jika ada data dari server, isi form
            if (typeof initialPsikososialData !== 'undefined') {
                const data = initialPsikososialData;

                // Set tanggal
                if (data.tanggal_pengkajian) {
                    $('#tanggal_pengkajian_psiko').datepicker('setDate', new Date(data.tanggal_pengkajian));
                }

                // Set select values
                $('#kendala_komunikasi').val(data.kendala_komunikasi);
                $('#yang_merawat').val(data.yang_merawat);
                $('#kepatuhan_layanan').val(data.kepatuhan_layanan);
                $('#jika_ya_jelaskan').val(data.jika_ya_jelaskan);

                // Set kondisi psikologis
                if (data.kondisi_psikologis && Array.isArray(data.kondisi_psikologis)) {
                    data.kondisi_psikologis.forEach(function (kondisi) {
                        $(`#kondisi_${kondisi.toLowerCase()}`).prop('checked', true);
                    });
                    updateKondisiPsikologisJSON();
                }

                // Show/hide jika ya container
                toggleJikaYa();
            }
        });

        // Fungsi untuk menampilkan/menyembunyikan field penjelasan "Jika Iya"
        function toggleJikaYa() {
            const kepatuhanValue = $('#kepatuhan_layanan').val();
            if (kepatuhanValue === 'Ya') {
                $('#jika_ya_container').show();
            } else {
                $('#jika_ya_container').hide();
                $('#jika_ya_jelaskan').val('');
            }
        }

        // 10. Status Psikososial
        document.addEventListener('DOMContentLoaded', function () {
            // Function untuk toggle jika_ya container
            window.toggleJikaYa = function () {
                const kepatuhanLayanan = document.getElementById('kepatuhan_layanan');
                const jikaYaContainer = document.getElementById('jika_ya_container');

                if (kepatuhanLayanan.value === 'Ya') {
                    jikaYaContainer.style.display = 'flex';
                } else {
                    jikaYaContainer.style.display = 'none';
                    document.getElementById('jika_ya_jelaskan').value = '';
                }
            };

            // Function untuk update hidden JSON field
            function updateKondisiPsikologisJSON() {
                const checkboxes = document.querySelectorAll('input[name="kondisi_psikologis[]"]:checked');
                const values = Array.from(checkboxes).map(cb => cb.value);
                document.getElementById('kondisi_psikologis_json').value = JSON.stringify(values);
            }

            // Tambahkan event listener ke semua checkbox kondisi psikologis
            const checkboxes = document.querySelectorAll('input[name="kondisi_psikologis[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateKondisiPsikologisJSON);
            });

            // Update kondisi_psikologis_json saat halaman dimuat
            updateKondisiPsikologisJSON();

            // Initialize kepatuhan_layanan toggle
            toggleJikaYa();

            // Untuk form submission
            const form = document.querySelector('form');
            form.addEventListener('submit', function () {
                updateKondisiPsikologisJSON();
            });
        });

        // 11. Monitoring Hemodialisis
        $(document).ready(function () {
            // Inisialisasi detail field yang disembunyikan saat awal
            toggleDetailFields();
            togglePreOpFields(); // Menambahkan inisialisasi untuk fields Pre Op

            // Event listener untuk checkbox program profiling
            $('input[name="program_profiling[]"]').change(function () {
                toggleDetailFields();
            });

            // Event listener untuk checkbox program aksesbilling
            $('input[name="program_aksesbilling[]"]').change(function () {
                toggleDetailFields();
            });

            // Event listener untuk checkbox di bagian Pre Op
            $('#conductivity_check, #kalium_check, #suhu_dialisat_check, #base_na_check').change(function () {
                togglePreOpFields();
            });

            // Fungsi untuk toggle detail fields
            function toggleDetailFields() {
                // Program profiling
                $('#uf_profiling_detail').prop('disabled', !$('#uf_profiling').is(':checked'));
                $('#bicarbonat_profiling_detail').prop('disabled', !$('#bicarbonat_profiling').is(':checked'));
                $('#na_profiling_detail').prop('disabled', !$('#na_profiling').is(':checked'));

                // Program aksesbilling
                $('#av_shunt_detail').prop('disabled', !$('#av_shunt').is(':checked'));
                $('#cdl_detail').prop('disabled', !$('#cdl').is(':checked'));
                $('#femoral_detail').prop('disabled', !$('#femoral').is(':checked'));
            }

            // Fungsi untuk toggle fields di bagian Pre Op
            function togglePreOpFields() {
                // Conductivity
                $('#conductivity').prop('disabled', !$('#conductivity_check').is(':checked'));
                if (!$('#conductivity_check').is(':checked')) {
                    $('#conductivity').val('');
                }

                // Kalium
                $('#kalium').prop('disabled', !$('#kalium_check').is(':checked'));
                if (!$('#kalium_check').is(':checked')) {
                    $('#kalium').val('');
                }

                // Suhu Dialisat
                $('#suhu_dialisat').prop('disabled', !$('#suhu_dialisat_check').is(':checked'));
                if (!$('#suhu_dialisat_check').is(':checked')) {
                    $('#suhu_dialisat').val('');
                }

                // Base Na
                $('#base_na').prop('disabled', !$('#base_na_check').is(':checked'));
                if (!$('#base_na_check').is(':checked')) {
                    $('#base_na').val('');
                }
            }

            // Fungsi untuk mengumpulkan semua data form ke dalam JSON
            function collectFormData() {
                const formData = {
                    preekripsi: {
                        inisiasi: {
                            hd_ke: $('#hd_ke').val(),
                            nomor_mesin: $('#nomor_mesin').val(),
                            bb_hd_lalu: $('#bb_hd_lalu').val(),
                            tekanan_vena: $('#tekanan_vena').val(),
                            lama_hd: $('#lama_hd').val(),
                            program_profiling: []
                        },
                        akut: {
                            type_dializer: $('#type_dializer').val(),
                            uf_goal: $('#uf_goal').val(),
                            bb_pre_hd: $('#bb_pre_hd').val(),
                            tekanan_arteri: $('#tekanan_arteri').val(),
                            laju_uf: $('#laju_uf').val(),
                            lama_laju_uf: $('#lama_laju_uf').val()
                        },
                        rutin: {
                            nr_ke: $('#nr_ke').val(),
                            bb_kering: $('#bb_kering').val(),
                            bb_post_hd: $('#bb_post_hd').val(),
                            tmp: $('#tmp').val(),
                            program_aksesbilling: []
                        },
                        pre_op: {
                            dialisat: [],
                            conductivity: $('#conductivity_check').is(':checked') ? $('#conductivity').val() : null,
                            kalium: $('#kalium_check').is(':checked') ? $('#kalium').val() : null,
                            suhu_dialisat: $('#suhu_dialisat_check').is(':checked') ? $('#suhu_dialisat').val() : null,
                            base_na: $('#base_na_check').is(':checked') ? $('#base_na').val() : null
                        }
                    },
                    heparinisasi: {
                        dosis_sirkulasi: $('#dosis_sirkulasi').val(),
                        dosis_awal: $('#dosis_awal').val(),
                        maintenance_kontinyu: $('#maintenance_kontinyu').val(),
                        maintenance_intermiten: $('#maintenance_intermiten').val(),
                        tanpa_heparin: $('#tanpa_heparin').val(),
                        lmwh: $('#lmwh').val(),
                        program_bilas_nacl: $('#program_bilas_nacl').val()
                    }
                };

                // Kumpulkan data program profiling
                if ($('#uf_profiling').is(':checked')) {
                    formData.preekripsi.inisiasi.program_profiling.push({
                        type: 'UF Profiling Mode',
                        detail: $('#uf_profiling_detail').val()
                    });
                }

                if ($('#bicarbonat_profiling').is(':checked')) {
                    formData.preekripsi.inisiasi.program_profiling.push({
                        type: 'Bicarbonat Profiling',
                        detail: $('#bicarbonat_profiling_detail').val()
                    });
                }

                if ($('#na_profiling').is(':checked')) {
                    formData.preekripsi.inisiasi.program_profiling.push({
                        type: 'Na Profiling Mode',
                        detail: $('#na_profiling_detail').val()
                    });
                }

                // Kumpulkan data program aksesbilling
                if ($('#av_shunt').is(':checked')) {
                    formData.preekripsi.rutin.program_aksesbilling.push({
                        type: 'AV Shunt',
                        detail: $('#av_shunt_detail').val()
                    });
                }

                if ($('#cdl').is(':checked')) {
                    formData.preekripsi.rutin.program_aksesbilling.push({
                        type: 'CDL',
                        detail: $('#cdl_detail').val()
                    });
                }

                if ($('#femoral').is(':checked')) {
                    formData.preekripsi.rutin.program_aksesbilling.push({
                        type: 'Femoral',
                        detail: $('#femoral_detail').val()
                    });
                }

                // Kumpulkan data dialisat
                if ($('#dialisat_asetat').is(':checked')) {
                    formData.preekripsi.pre_op.dialisat.push('Asetat');
                }

                if ($('#dialisat_bicarbonat').is(':checked')) {
                    formData.preekripsi.pre_op.dialisat.push('Bicarbonat');
                }

                return formData;
            }

            // Update hidden input saat form berubah
            $('input, select').change(function () {
                const formData = collectFormData();
                $('#monitoring_hemodialisis_data').val(JSON.stringify(formData));
            });

            // Inisialisasi data form dari server jika ada
            if (typeof initialMonitoringData !== 'undefined' && initialMonitoringData) {
                try {
                    const data = JSON.parse(initialMonitoringData);

                    // Pre Op Fields
                    if (data.preekripsi && data.preekripsi.pre_op) {
                        // Dialisat
                        if (data.preekripsi.pre_op.dialisat) {
                            for (const item of data.preekripsi.pre_op.dialisat) {
                                if (item === 'Asetat') {
                                    $('#dialisat_asetat').prop('checked', true);
                                }
                                if (item === 'Bicarbonat') {
                                    $('#dialisat_bicarbonat').prop('checked', true);
                                }
                            }
                        }

                        // Conductivity
                        if (data.preekripsi.pre_op.conductivity) {
                            $('#conductivity_check').prop('checked', true);
                            $('#conductivity').val(data.preekripsi.pre_op.conductivity);
                        }

                        // Kalium
                        if (data.preekripsi.pre_op.kalium) {
                            $('#kalium_check').prop('checked', true);
                            $('#kalium').val(data.preekripsi.pre_op.kalium);
                        }

                        // Suhu Dialisat
                        if (data.preekripsi.pre_op.suhu_dialisat) {
                            $('#suhu_dialisat_check').prop('checked', true);
                            $('#suhu_dialisat').val(data.preekripsi.pre_op.suhu_dialisat);
                        }

                        // Base Na
                        if (data.preekripsi.pre_op.base_na) {
                            $('#base_na_check').prop('checked', true);
                            $('#base_na').val(data.preekripsi.pre_op.base_na);
                        }
                    }

                    // Inisialisasi kembali toggle fields
                    toggleDetailFields();
                    togglePreOpFields();
                } catch (e) {
                    console.error('Error parsing initial data:', e);
                }
            }
        });

        // lanjutan bagian Intra HD
        $(document).ready(function () {
            // Event delegation for buttons
            $('#observasiTableBody').on('click', '.btn-delete-row', function () {
                const row = $(this).closest('tr');
                deleteRow(row);
            });

            $('#observasiTableBody').on('click', '.btn-edit-row', function () {
                const row = $(this).closest('tr');
                editRow(row);
            });

            // Save button for Intra HD form
            $('.btn-simpan-intra-hd').click(function (e) {
                e.preventDefault();
                addDataToTable();
            });

            // Auto-calculate on input change in table
            $('#observasiTableBody').on('input', '.observasi-nacl, .observasi-minum, .observasi-lain, .observasi-output', function() {
                calculateTotals();
                updateObservasiData(); // Update observasi_data setiap ada perubahan
            });

            // Update observasi_data setiap ada perubahan di tabel
            $('#observasiTableBody').on('input', 'input', function() {
                updateObservasiData();
            });

            // Form submission handler
            $('form').on('submit', function (e) {
                // Pastikan observasi_data ter-update sebelum submit
                updateObservasiData();
                
                // Validasi apakah ada data observasi
                const observasiData = $('#observasi_data').val();
                if (!observasiData || observasiData === '[]' || observasiData === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Belum ada data observasi yang ditambahkan. Silakan tambahkan minimal 1 data observasi.'
                    });
                    return false;
                }
                
                return true;
            });

            // Load existing data on page load
            loadExistingData();
        });

        // Load existing data if available
        function loadExistingData() {
            const existingData = $('#observasi_data').val();
            if (existingData) {
                try {
                    const observasiData = JSON.parse(existingData);

                    // Populate table with rows
                    if (Array.isArray(observasiData) && observasiData.length > 0) {
                        observasiData.forEach(item => {
                            addRowToTable(
                                item.waktu,
                                item.qb,
                                item.qd,
                                item.uf_rate,
                                item.td,
                                item.nadi,
                                item.nafas,
                                item.suhu,
                                item.nacl,
                                item.minum,
                                item.lain_lain,
                                item.output
                            );
                        });
                        
                        // Calculate totals after loading
                        calculateTotals();
                    }
                } catch (e) {
                    console.error('Error parsing existing data:', e);
                }
            }
        }

        function deleteRow(row) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data observasi ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove();
                    calculateTotals();
                    updateObservasiData();
                    Swal.fire(
                        'Terhapus!',
                        'Data observasi telah dihapus.',
                        'success'
                    );
                }
            });
        }

        function editRow(row) {
            // Get values from the row
            const waktu = row.find('.observasi-waktu').val();
            const qb = row.find('.observasi-qb').val();
            const qd = row.find('.observasi-qd').val();
            const ufRate = row.find('.observasi-uf-rate').val();

            // Split TD value into systole and diastole
            const tdValue = row.find('.observasi-td').val();
            let sistole = '';
            let diastole = '';
            if (tdValue && tdValue.includes('/')) {
                const tdParts = tdValue.split('/');
                sistole = tdParts[0];
                diastole = tdParts[1];
            }

            const nadi = row.find('.observasi-nadi').val();
            const nafas = row.find('.observasi-nafas').val();
            const suhu = row.find('.observasi-suhu').val();
            const nacl = row.find('.observasi-nacl').val();
            const minum = row.find('.observasi-minum').val();
            const lainLain = row.find('.observasi-lain').val();
            const output = row.find('.observasi-output').val();

            // Fill the Intra HD form with values from the row
            $('#waktu_intra_pre_hd').val(waktu);
            $('#qb_intra').val(qb);
            $('#qd_intra').val(qd);
            $('#uf_rate_intra').val(ufRate);
            $('#sistole_intra').val(sistole);
            $('#diastole_intra').val(diastole);
            $('#nadi_intra').val(nadi);
            $('#nafas_intra').val(nafas);
            $('#suhu_intra').val(suhu);
            $('#nacl_intra').val(nacl);
            $('#minum_intra').val(minum);
            $('#intake_lain_intra').val(lainLain);
            $('#output_intra').val(output);

            // Mark the row being edited
            row.addClass('editing');

            // Change the save button text to "Update"
            $('.btn-simpan-intra-hd').text('Update ke Tabel').data('mode', 'edit');

            // Scroll to form
            $('html, body').animate({
                scrollTop: $('.intraHD').offset().top - 100
            }, 500);
        }

        function addDataToTable() {
            const waktu = $('#waktu_intra_pre_hd').val();
            const qb = $('#qb_intra').val();
            const qd = $('#qd_intra').val();
            const ufRate = $('#uf_rate_intra').val();
            const sistole = $('#sistole_intra').val();
            const diastole = $('#diastole_intra').val();
            const td = (sistole || diastole) ? `${sistole || ''}/${diastole || ''}` : '';
            const nadi = $('#nadi_intra').val();
            const nafas = $('#nafas_intra').val();
            const suhu = $('#suhu_intra').val();
            const nacl = $('#nacl_intra').val();
            const minum = $('#minum_intra').val();
            const lainLain = $('#intake_lain_intra').val();
            const output = $('#output_intra').val();

            // Validate minimum data
            if (!waktu) {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Tidak Lengkap',
                    text: 'Waktu Intra Pre HD harus diisi!'
                });
                return;
            }

            // Check if in edit mode
            const editMode = $('.btn-simpan-intra-hd').data('mode') === 'edit';

            if (editMode) {
                // Update the row being edited
                const editingRow = $('#observasiTableBody tr.editing');
                if (editingRow.length) {
                    editingRow.find('.observasi-waktu').val(waktu);
                    editingRow.find('.observasi-qb').val(qb);
                    editingRow.find('.observasi-qd').val(qd);
                    editingRow.find('.observasi-uf-rate').val(ufRate);
                    editingRow.find('.observasi-td').val(td);
                    editingRow.find('.observasi-nadi').val(nadi);
                    editingRow.find('.observasi-nafas').val(nafas);
                    editingRow.find('.observasi-suhu').val(suhu);
                    editingRow.find('.observasi-nacl').val(nacl);
                    editingRow.find('.observasi-minum').val(minum);
                    editingRow.find('.observasi-lain').val(lainLain);
                    editingRow.find('.observasi-output').val(output);

                    // Remove editing class
                    editingRow.removeClass('editing');

                    // Reset button to "Save"
                    $('.btn-simpan-intra-hd').text('Simpan ke Tabel').removeData('mode');

                    // Show success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data observasi berhasil diperbarui!',
                        timer: 1500
                    });
                }
            } else {
                // Add new data to the table
                addRowToTable(waktu, qb, qd, ufRate, td, nadi, nafas, suhu, nacl, minum, lainLain, output);

                // Show success notification
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data observasi berhasil ditambahkan!',
                    timer: 1500
                });
            }

            // Calculate totals
            calculateTotals();
            
            // Update observasi_data JSON
            updateObservasiData();

            // Reset form fields untuk input baru
            $('#waktu_intra_pre_hd').val('');
            $('#qb_intra').val('');
            $('#qd_intra').val('');
            $('#uf_rate_intra').val('');
            $('#sistole_intra').val('');
            $('#diastole_intra').val('');
            $('#nadi_intra').val('');
            $('#nafas_intra').val('');
            $('#suhu_intra').val('');
            $('#nacl_intra').val('');
            $('#minum_intra').val('');
            $('#intake_lain_intra').val('');
            $('#output_intra').val('');

            // Focus ke field waktu untuk input berikutnya
            $('#waktu_intra_pre_hd').focus();
        }

        function addRowToTable(waktu, qb, qd, ufRate, td, nadi, nafas, suhu, nacl, minum, lainLain, output) {
            const rowHtml = `
                <tr>
                    <td style="min-width: 120px;">
                        <input type="time" 
                            class="form-control form-control-sm observasi-waktu" 
                            value="${waktu || ''}"
                            style="min-width: 110px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-qb text-center" 
                            value="${qb || ''}"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-qd text-center" 
                            value="${qd || ''}"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 90px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-uf-rate text-center" 
                            value="${ufRate || ''}"
                            style="min-width: 80px; font-size: 13px;">
                    </td>
                    <td style="min-width: 110px;">
                        <input type="text" 
                            class="form-control form-control-sm observasi-td text-center" 
                            value="${td || ''}"
                            placeholder="120/80"
                            style="min-width: 100px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-nadi text-center" 
                            value="${nadi || ''}"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-nafas text-center" 
                            value="${nafas || ''}"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 80px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-suhu text-center" 
                            value="${suhu || ''}"
                            step="0.1"
                            style="min-width: 70px; font-size: 13px;">
                    </td>
                    <td style="min-width: 90px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-nacl text-center" 
                            value="${nacl || ''}"
                            style="min-width: 80px; font-size: 13px;">
                    </td>
                    <td style="min-width: 90px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-minum text-center" 
                            value="${minum || ''}"
                            style="min-width: 80px; font-size: 13px;">
                    </td>
                    <td style="min-width: 100px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-lain text-center" 
                            value="${lainLain || ''}"
                            style="min-width: 90px; font-size: 13px;">
                    </td>
                    <td style="min-width: 90px;">
                        <input type="number" 
                            class="form-control form-control-sm observasi-output text-center" 
                            value="${output || ''}"
                            style="min-width: 80px; font-size: 13px;">
                    </td>
                    <td style="min-width: 100px;">
                        <div class="btn-group btn-group-sm d-flex" role="group">
                            <button type="button" 
                                    class="btn btn-warning btn-sm btn-edit-row flex-fill" 
                                    title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" 
                                    class="btn btn-danger btn-sm btn-delete-row flex-fill" 
                                    title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;

            $('#observasiTableBody').append(rowHtml);
        }

        function calculateTotals() {
            let totalNacl = 0;
            let totalMinum = 0;
            let totalLain = 0;
            let totalOutput = 0;

            // Loop through all rows and sum up the values
            $('#observasiTableBody tr').each(function () {
                const row = $(this);
                
                const nacl = parseFloat(row.find('.observasi-nacl').val()) || 0;
                const minum = parseFloat(row.find('.observasi-minum').val()) || 0;
                const lain = parseFloat(row.find('.observasi-lain').val()) || 0;
                const output = parseFloat(row.find('.observasi-output').val()) || 0;

                totalNacl += nacl;
                totalMinum += minum;
                totalLain += lain;
                totalOutput += output;
            });

            // Update footer totals
            $('#total-nacl').text(totalNacl);
            $('#total-minum').text(totalMinum);
            $('#total-lain').text(totalLain);
            $('#total-output').text(totalOutput);

            // Calculate intake and ultrafiltration
            const totalIntake = totalNacl + totalMinum + totalLain;
            const ultrafiltrationTotal = totalIntake - totalOutput;

            // Update the summary fields (jika ada di form Anda)
            $('#jumlah_cairan_intake').val(totalIntake);
            $('#jumlah_cairan_output').val(totalOutput);
            $('#ultrafiltration_total').val(ultrafiltrationTotal);
        }

        function updateObservasiData() {
            const tableRows = [];

            // Collect the table data
            $('#observasiTableBody tr').each(function () {
                const row = $(this);
                const rowData = {
                    waktu: row.find('.observasi-waktu').val() || '',
                    qb: row.find('.observasi-qb').val() || '',
                    qd: row.find('.observasi-qd').val() || '',
                    uf_rate: row.find('.observasi-uf-rate').val() || '',
                    td: row.find('.observasi-td').val() || '',
                    nadi: row.find('.observasi-nadi').val() || '',
                    nafas: row.find('.observasi-nafas').val() || '',
                    suhu: row.find('.observasi-suhu').val() || '',
                    nacl: row.find('.observasi-nacl').val() || '',
                    minum: row.find('.observasi-minum').val() || '',
                    lain_lain: row.find('.observasi-lain').val() || '',
                    output: row.find('.observasi-output').val() || ''
                };

                // Only add rows that have at least time
                if (rowData.waktu) {
                    tableRows.push(rowData);
                }
            });

            // Set the JSON string to the hidden input
            $('#observasi_data').val(JSON.stringify(tableRows));
            
            // Debug: tampilkan di console
            console.log('Observasi Data Updated:', tableRows);
        }

        // 12. Penyulit Selama HD
        $(document).ready(function () {
            // Initialize selected values if they exist
            loadExistingValues();

            // Handle saving the Teknis modal selections
            $('#saveTeknisButton').click(function () {
                saveTeknisSelections();
            });

            // Handle saving the Klinis modal selections
            $('#saveKlinisButton').click(function () {
                saveKlinisSelections();
            });
        });

        /**
         * Load existing values from hidden inputs if they exist
         */
        function loadExistingValues() {
            // Load Teknis values
            if ($('#teknis_values').val()) {
                try {
                    const teknisValues = JSON.parse($('#teknis_values').val());

                    // Check the appropriate checkboxes
                    teknisValues.forEach(value => {
                        $('.teknis-option[value="' + value + '"]').prop('checked', true);
                    });

                    // Update the display
                    updateTeknisDisplay(teknisValues);
                } catch (e) {
                    console.error('Error parsing teknis values:', e);
                }
            }

            // Load Klinis values
            if ($('#klinis_values').val()) {
                try {
                    const klinisValues = JSON.parse($('#klinis_values').val());

                    // Check the appropriate checkboxes
                    klinisValues.forEach(value => {
                        $('.klinis-option[value="' + value + '"]').prop('checked', true);
                    });

                    // Update the display
                    updateKlinisDisplay(klinisValues);
                } catch (e) {
                    console.error('Error parsing klinis values:', e);
                }
            }
        }

        /**
         * Save the selected teknis options
         */
        function saveTeknisSelections() {
            const selectedValues = [];

            // Get all checked options
            $('.teknis-option:checked').each(function () {
                selectedValues.push($(this).val());
            });

            // Store the values in the hidden input as JSON
            $('#teknis_values').val(JSON.stringify(selectedValues));

            // Update the display
            updateTeknisDisplay(selectedValues);
        }

        /**
         * Save the selected klinis options
         */
        function saveKlinisSelections() {
            const selectedValues = [];

            // Get all checked options
            $('.klinis-option:checked').each(function () {
                selectedValues.push($(this).val());
            });

            // Store the values in the hidden input as JSON
            $('#klinis_values').val(JSON.stringify(selectedValues));

            // Update the display
            updateKlinisDisplay(selectedValues);
        }

        /**
         * Update the teknis display area with selected values
         */
        function updateTeknisDisplay(selectedValues) {
            if (selectedValues.length > 0) {
                // Update the input display with a summary
                $('#teknis_display').val(selectedValues.length + ' item dipilih');

                // Show detailed list below
                const itemsList = selectedValues.map(value => `<span class="badge bg-primary me-1 mb-1">${value}</span>`).join('');
                $('#teknis_selected_items').html(itemsList);
            } else {
                $('#teknis_display').val('');
                $('#teknis_selected_items').html('');
            }
        }

        /**
         * Update the klinis display area with selected values
         */
        function updateKlinisDisplay(selectedValues) {
            if (selectedValues.length > 0) {
                // Update the input display with a summary
                $('#klinis_display').val(selectedValues.length + ' item dipilih');

                // Show detailed list below
                const itemsList = selectedValues.map(value => `<span class="badge bg-primary me-1 mb-1">${value}</span>`).join('');
                $('#klinis_selected_items').html(itemsList);
            } else {
                $('#klinis_display').val('');
                $('#klinis_selected_items').html('');
            }
        }

        // 13. Disharge Planning
        // Modal untuk Rencana Pulang
        document.addEventListener('DOMContentLoaded', function () {
            const rencanaPulangOptions = document.querySelectorAll('.rencana-pulang-option');
            const rencanaPulangDisplay = document.getElementById('rencana_pulang_display');
            const rencanaPulangValues = document.getElementById('rencana_pulang_values');
            const rencanaPulangSelectedItems = document.getElementById('rencana_pulang_selected_items');
            const saveRencanaPulangButton = document.getElementById('saveRencanaPulangButton');

            // Menyimpan pilihan saat tombol Simpan ditekan
            saveRencanaPulangButton.addEventListener('click', function () {
                const selectedOptions = Array.from(rencanaPulangOptions)
                    .filter(option => option.checked)
                    .map(option => option.value);

                // Memperbarui input tersembunyi dengan nilai yang dipilih (JSON string)
                rencanaPulangValues.value = JSON.stringify(selectedOptions);

                // Memperbarui tampilan
                if (selectedOptions.length > 0) {
                    rencanaPulangDisplay.value = `${selectedOptions.length} item dipilih`;
                    rencanaPulangSelectedItems.innerHTML = selectedOptions.map(item =>
                        `<span class="badge bg-light text-dark me-1 mb-1">${item}</span>`
                    ).join('');
                } else {
                    rencanaPulangDisplay.value = 'Pemulangan Asupan Cairan';
                    rencanaPulangSelectedItems.innerHTML = '';
                }
            });
        });


        // 14. Diagnosis Diagnosis Banding
        document.addEventListener('DOMContentLoaded', function () {
            initDiagnosisManagement('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagement('diagnosis-kerja', 'diagnosis_kerja');

            function initDiagnosisManagement(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                const suggestionsList = document.createElement('div');

                // Style suggestions list
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 30px)';
                suggestionsList.style.display = 'none';

                // Insert suggestions list after input
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Database options
                const dbMasterDiagnosis = {!! json_encode($rmeMasterDiagnosis->pluck('nama_diagnosis')) !!};

                // Prepare options array
                const diagnosisOptions = dbMasterDiagnosis.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                // Load initial data if available
                let diagnosisList = [];
                try {
                    diagnosisList = JSON.parse(hiddenInput.value) || [];
                    renderDiagnosisList();
                } catch (e) {
                    diagnosisList = [];
                    updateHiddenInput();
                }

                // Input event listener for suggestions
                inputField.addEventListener('input', function () {
                    const inputValue = this.value.trim().toLowerCase();

                    if (inputValue) {
                        // Filter database options
                        const filteredOptions = diagnosisOptions.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );

                        // Show suggestions
                        showSuggestions(filteredOptions, inputValue);
                    } else {
                        // Hide suggestions if input is empty
                        suggestionsList.style.display = 'none';
                    }
                });

                // Function to show suggestions
                function showSuggestions(options, inputValue) {
                    suggestionsList.innerHTML = '';

                    if (options.length > 0) {
                        // Render existing options
                        options.forEach(option => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'suggestion-item p-2 cursor-pointer';
                            suggestionItem.textContent = option.text;
                            suggestionItem.addEventListener('click', () => {
                                addDiagnosis(option.text);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(suggestionItem);
                        });

                        // Add option to create new if no exact match
                        if (!options.some(opt => opt.text.toLowerCase() === inputValue)) {
                            const newOptionItem = document.createElement('div');
                            newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                            newOptionItem.textContent = `Tambah "${inputValue}"`;
                            newOptionItem.addEventListener('click', () => {
                                addDiagnosis(inputValue);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(newOptionItem);
                        }

                        suggestionsList.style.display = 'block';
                    } else {
                        // If no options, show add new option
                        const newOptionItem = document.createElement('div');
                        newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                        newOptionItem.textContent = `Tambah "${inputValue}"`;
                        newOptionItem.addEventListener('click', () => {
                            addDiagnosis(inputValue);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOptionItem);
                        suggestionsList.style.display = 'block';
                    }
                }

                // Add diagnosis when plus button is clicked
                addButton.addEventListener('click', function () {
                    const diagnosisText = inputField.value.trim();
                    if (diagnosisText) {
                        addDiagnosis(diagnosisText);
                    }
                });

                // Add diagnosis when Enter key is pressed
                inputField.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const diagnosisText = this.value.trim();
                        if (diagnosisText) {
                            addDiagnosis(diagnosisText);
                        }
                    }
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function (e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                function addDiagnosis(diagnosisText) {
                    // Check for duplicates
                    if (!diagnosisList.includes(diagnosisText)) {
                        diagnosisList.push(diagnosisText);
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';
                    } else {
                        // Optional: Show feedback that it's a duplicate
                        alert(`"${diagnosisText}" sudah ada dalam daftar`);
                    }
                }

                function renderDiagnosisList() {
                    listContainer.innerHTML = '';

                    diagnosisList.forEach((diagnosis, index) => {
                        const diagnosisItem = document.createElement('div');
                        diagnosisItem.className =
                            'diagnosis-item d-flex justify-content-between align-items-center mb-2';

                        const diagnosisSpan = document.createElement('span');
                        diagnosisSpan.textContent = `${index + 1}. ${diagnosis}`;

                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'btn btn-sm text-danger';
                        deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteButton.type = 'button';
                        deleteButton.addEventListener('click', function () {
                            diagnosisList.splice(index, 1);
                            renderDiagnosisList();
                            updateHiddenInput();
                        });

                        diagnosisItem.appendChild(diagnosisSpan);
                        diagnosisItem.appendChild(deleteButton);
                        listContainer.appendChild(diagnosisItem);
                    });
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(diagnosisList);
                }
            }
        });

        // 15.Implementasi
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize all sections
            initImplementationSection('rencana', 'rencana_penatalaksanaan', 'prognosis');
            initImplementationSection('observasi', 'observasi', 'observasi');
            initImplementationSection('terapeutik', 'terapeutik', 'terapeutik');
            initImplementationSection('edukasi', 'edukasi', 'edukasi');
            initImplementationSection('kolaborasi', 'kolaborasi', 'kolaborasi');

            /**
             * Initialize implementation section with dynamic options
             * @param {string} prefix - The prefix for element IDs
             * @param {string} hiddenFieldId - The ID of the hidden input field
             * @param {string} dbColumn - The column name in database
             */
            function initImplementationSection(prefix, hiddenFieldId, dbColumn) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                const suggestionsList = document.createElement('div');

                // Style suggestions list
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 40px)';
                suggestionsList.style.display = 'none';

                // Insert
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Get database
                const rmeMasterImplementasi = {!! json_encode($rmeMasterImplementasi) !!};

                // Filter out non-null values
                let optionsFromDb = [];
                if (rmeMasterImplementasi && rmeMasterImplementasi.length > 0) {
                    optionsFromDb = rmeMasterImplementasi
                        .filter(item => item[dbColumn] !== null &&
                            item[dbColumn] !== '(N/A)' &&
                            item[dbColumn] !== '(Null)')
                        .map(item => item[dbColumn]);
                }

                // Remove duplicates
                const uniqueOptions = [...new Set(optionsFromDb)];

                // Prepare options array
                const options = uniqueOptions.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                // Load initial data if available
                let itemsList = [];
                try {
                    itemsList = JSON.parse(hiddenInput.value) || [];
                    renderItemsList();
                } catch (e) {
                    itemsList = [];
                    updateHiddenInput();
                }

                // Input event listener for suggestions
                inputField.addEventListener('input', function () {
                    const inputValue = this.value.trim().toLowerCase();

                    if (inputValue) {
                        const filteredOptions = options.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );

                        const exactMatch = options.some(opt =>
                            opt.text.toLowerCase() === inputValue
                        );

                        showSuggestions(filteredOptions, inputValue, exactMatch);
                    } else {
                        suggestionsList.style.display = 'none';
                    }
                });

                // Function to show
                function showSuggestions(filtered, inputValue, exactMatch) {
                    suggestionsList.innerHTML = '';

                    if (filtered.length > 0) {
                        filtered.forEach(option => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'suggestion-item p-2 cursor-pointer hover:bg-light';
                            suggestionItem.style.cursor = 'pointer';

                            const text = option.text;
                            const lowerText = text.toLowerCase();
                            const lowerInput = inputValue.toLowerCase();
                            const index = lowerText.indexOf(lowerInput);

                            if (index >= 0) {
                                const before = text.substring(0, index);
                                const match = text.substring(index, index + inputValue.length);
                                const after = text.substring(index + inputValue.length);
                                suggestionItem.innerHTML = `${before}<strong>${match}</strong>${after}`;
                            } else {
                                suggestionItem.textContent = text;
                            }

                            suggestionItem.addEventListener('click', () => {
                                addItem(option.text);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(suggestionItem);
                        });

                        // Add option to create new if no exact match
                        if (!exactMatch) {
                            const newOptionItem = document.createElement('div');
                            newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                            newOptionItem.style.cursor = 'pointer';
                            newOptionItem.innerHTML =
                                `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                            newOptionItem.addEventListener('click', () => {
                                addItem(inputValue);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(newOptionItem);
                        }

                        suggestionsList.style.display = 'block';
                    } else {
                        // If no options, show add new option
                        const newOptionItem = document.createElement('div');
                        newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                        newOptionItem.style.cursor = 'pointer';
                        newOptionItem.innerHTML = `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                        newOptionItem.addEventListener('click', () => {
                            addItem(inputValue);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOptionItem);
                        suggestionsList.style.display = 'block';
                    }
                }

                // Add item
                addButton.addEventListener('click', function () {
                    const itemText = inputField.value.trim();
                    if (itemText) {
                        addItem(itemText);
                    }
                });

                // Add item when Enter
                inputField.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const itemText = this.value.trim();
                        if (itemText) {
                            addItem(itemText);
                        }
                    }
                });

                // Close
                document.addEventListener('click', function (e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                /**
                 * Add item to the list
                 * @param {string} itemText - The text to add
                 */
                function addItem(itemText) {
                    // Check for duplicates
                    if (!itemsList.includes(itemText)) {
                        // Check if in database
                        const existsInDb = optionsFromDb.includes(itemText);

                        itemsList.push(itemText);
                        inputField.value = '';
                        renderItemsList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';

                        if (existsInDb) {
                            const notification = document.createElement('div');
                            notification.className = 'alert alert-info alert-dismissible fade show mt-2';
                            notification.innerHTML = `
                                                                <small>Item "${itemText}" sudah ada di database dan akan digunakan.</small>
                                                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                                                            `;
                            listContainer.parentNode.insertBefore(notification, listContainer.nextSibling);

                            // Auto-dismiss after 3 seconds
                            setTimeout(() => {
                                notification.classList.remove('show');
                                setTimeout(() => notification.remove(), 150);
                            }, 3000);
                        }
                    } else {
                        // Show feedback that it's a duplicate
                        const toastContainer = document.createElement('div');
                        toastContainer.className = 'position-fixed top-0 end-0 p-3';
                        toastContainer.style.zIndex = '1050';

                        const toast = document.createElement('div');
                        toast.className = 'toast align-items-center text-white bg-danger border-0';
                        toast.setAttribute('role', 'alert');
                        toast.innerHTML = `
                                                            <div class="d-flex">
                                                                <div class="toast-body">
                                                                    <i class="bi bi-exclamation-circle me-2"></i>
                                                                    "${itemText}" sudah ada dalam daftar
                                                                </div>
                                                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                                                            </div>
                                                        `;

                        toastContainer.appendChild(toast);
                        document.body.appendChild(toastContainer);

                        // Show toast
                        const bsToast = new bootstrap.Toast(toast, {
                            delay: 3000
                        });
                        bsToast.show();

                        // Remove container after toast is hidden
                        toast.addEventListener('hidden.bs.toast', function () {
                            document.body.removeChild(toastContainer);
                        });
                    }
                }

                /**
                 * Render items list in the container
                 */
                function renderItemsList() {
                    listContainer.innerHTML = '';

                    itemsList.forEach((item, index) => {
                        const itemElement = document.createElement('div');
                        itemElement.className =
                            'list-group-item d-flex justify-content-between align-items-center border-0 ps-0';

                        const itemSpan = document.createElement('span');
                        itemSpan.textContent = `${index + 1}. ${item}`;

                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'btn btn-link text-danger p-0';
                        deleteButton.type = 'button';
                        deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteButton.addEventListener('click', function () {
                            itemsList.splice(index, 1);
                            renderItemsList();
                            updateHiddenInput();
                        });

                        itemElement.appendChild(itemSpan);
                        itemElement.appendChild(deleteButton);
                        listContainer.appendChild(itemElement);
                    });

                    // Show "Tidak ada data" message if the list is empty
                    if (itemsList.length === 0) {
                        const emptyMessage = document.createElement('div');
                        emptyMessage.className = 'text-muted fst-italic small';
                        emptyMessage.textContent = 'Belum ada data';
                        listContainer.appendChild(emptyMessage);
                    }
                }

                /**
                 * Update hidden input with JSON data
                 */
                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(itemsList);
                }
            }
        });


        // 17. Tanda Tangan dan Verifikasi
        document.addEventListener('DOMContentLoaded', function () {
            let petugasCounter = 0;
            const petugasList = []; // Array untuk menyimpan data perawat
            let qrPemeriksa = null;
            let qrDokter = null;

            // Fungsi untuk update JSON di hidden input
            function updateJSONInput() {
                const jsonInput = document.getElementById('perawat-bertugas-json');
                jsonInput.value = JSON.stringify(petugasList);
                // console.log('Data JSON:', jsonInput.value); // Debug
            }

            // ===== PERAWAT PEMERIKSA (Single Select dengan QR) =====
            document.getElementById('perawat-pemeriksa').addEventListener('change', function () {
                const kdKaryawan = this.value;
                const qrContainer = document.getElementById('qr-pemeriksa');
                const noContainer = document.getElementById('no-pemeriksa');

                // Clear previous QR
                qrContainer.innerHTML = '';

                if (kdKaryawan) {
                    // Generate QR Code
                    qrPemeriksa = new QRCode(qrContainer, {
                        text: `PERAWAT_PEMERIKSA:${kdKaryawan}`,
                        width: 100,
                        height: 100,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });

                    noContainer.textContent = `No. ${kdKaryawan}`;
                } else {
                    noContainer.textContent = 'No..........................';
                }
            });

            // ===== DOKTER DPJP (Single Select dengan QR) =====
            document.getElementById('dokter-pelaksana').addEventListener('change', function () {
                const kdDokter = this.value;
                const qrContainer = document.getElementById('qr-dokter');
                const noContainer = document.getElementById('no-dokter');

                // Clear previous QR
                qrContainer.innerHTML = '';

                if (kdDokter) {
                    // Generate QR Code
                    qrDokter = new QRCode(qrContainer, {
                        text: `DOKTER_DPJP:${kdDokter}`,
                        width: 100,
                        height: 100,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });

                    noContainer.textContent = `No. ${kdDokter}`;
                } else {
                    noContainer.textContent = 'No..........................';
                }
            });

            // ===== PERAWAT BERTUGAS (Multiple Select dengan QR) =====
            document.getElementById('btn-tambah-perawat').addEventListener('click', function () {
                const selector = document.getElementById('perawat-selector');
                const selectedOption = selector.options[selector.selectedIndex];
                const kdKaryawan = selectedOption.value;
                const namaPetugas = selectedOption.text;

                if (!kdKaryawan) {
                    alert('Silakan pilih perawat terlebih dahulu!');
                    return;
                }

                // Cek apakah sudah ada
                const exists = petugasList.find(p => p.kd_karyawan === kdKaryawan);
                if (exists) {
                    alert('Perawat ini sudah ditambahkan!');
                    return;
                }

                petugasCounter++;

                // Tambahkan ke array
                const petugasData = {
                    kd_karyawan: kdKaryawan,
                    nama: namaPetugas,
                    urutan: petugasCounter,
                    timestamp: new Date().toISOString()
                };
                petugasList.push(petugasData);

                // Update JSON input
                updateJSONInput();

                // Sembunyikan pesan kosong
                document.getElementById('empty-message').style.display = 'none';

                // Buat elemen perawat baru dengan Bootstrap classes
                const petugasItem = document.createElement('div');
                petugasItem.className = 'border-bottom pb-2 mb-2';
                petugasItem.dataset.kode = kdKaryawan;
                petugasItem.innerHTML = `
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-1">
                                <span class="badge bg-primary rounded-circle p-2" style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; font-size: 12px;">
                                    ${petugasCounter}
                                </span>
                            </div>
                            <div class="col-5">
                                <strong>${namaPetugas}</strong>
                            </div>
                            <div class="col-4 text-center">
                                <div id="qr-bertugas-${kdKaryawan}"></div>
                                <small class="text-muted">No. ${kdKaryawan}</small>
                            </div>
                            <div class="col-2 text-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removePetugas('${kdKaryawan}')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                // Tambahkan ke list
                document.getElementById('list-perawat-bertugas').appendChild(petugasItem);

                // Generate QR Code untuk petugas ini
                setTimeout(() => {
                    new QRCode(document.getElementById(`qr-bertugas-${kdKaryawan}`), {
                        text: `PERAWAT_BERTUGAS:${kdKaryawan}`,
                        width: 60,
                        height: 60,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }, 100);

                // Reset selector
                selector.value = '';
                if (typeof $(selector).select2 !== 'undefined') {
                    $(selector).val(null).trigger('change');
                }
            });

            // Fungsi hapus petugas
            window.removePetugas = function (kdKaryawan) {
                if (confirm('Apakah Anda yakin ingin menghapus perawat ini?')) {
                    // Hapus dari array
                    const index = petugasList.findIndex(p => p.kd_karyawan === kdKaryawan);
                    if (index > -1) {
                        petugasList.splice(index, 1);
                    }

                    // Update JSON input
                    updateJSONInput();

                    // Hapus elemen dari DOM
                    const item = document.querySelector(`.card[data-kode="${kdKaryawan}"]`);
                    if (item) {
                        item.remove();
                    }

                    // Update nomor urut
                    updatePetugasNumbers();

                    // Tampilkan pesan kosong jika tidak ada petugas
                    if (petugasList.length === 0) {
                        document.getElementById('empty-message').style.display = 'block';
                        petugasCounter = 0;
                    }
                }
            };

            // Fungsi update nomor urut
            function updatePetugasNumbers() {
                const items = document.querySelectorAll('#list-perawat-bertugas .card');
                items.forEach((item, index) => {
                    const badge = item.querySelector('.badge');
                    const kdKaryawan = item.dataset.kode;

                    if (badge) {
                        badge.textContent = index + 1;
                    }

                    // Update urutan di array
                    const petugas = petugasList.find(p => p.kd_karyawan === kdKaryawan);
                    if (petugas) {
                        petugas.urutan = index + 1;
                    }
                });
                petugasCounter = items.length;

                // Update JSON input
                updateJSONInput();
            }
        });

        // Load data terbaru untuk Pre Op fields
        document.addEventListener('DOMContentLoaded', function() {
            // Debug: Log bahwa script dimuat
            console.log('Script preload data dimuat!');
            
            // Cek apakah ada data monitoring preekripsi terbaru
            @if(isset($latestMonitoringPreekripsi) && $latestMonitoringPreekripsi)
                console.log('Data preekripsi ditemukan:', @json($latestMonitoringPreekripsi));
                
                // Jalankan after a short delay to ensure all other scripts are loaded
                setTimeout(function() {
                    console.log('Memulai loading data preekripsi...');
                    
                    // === BAGIAN INISIASI ===
                    // HD Ke
                    @if($latestMonitoringPreekripsi->inisiasi_hd_ke)
                        const hdKeElement = document.querySelector('input[name="inisiasi_hd_ke"]');
                        if (hdKeElement) {
                            hdKeElement.value = '{{ $latestMonitoringPreekripsi->inisiasi_hd_ke + 1 }}'; // Increment untuk sesi berikutnya
                            hdKeElement.classList.add('loaded-from-previous');
                            addLoadedIndicator(hdKeElement, 'Sesi HD ke-{{ $latestMonitoringPreekripsi->inisiasi_hd_ke + 1 }} (dari data sebelumnya)');
                            console.log('HD Ke loaded:', hdKeElement.value);
                        }
                    @endif

                    // Nomor Mesin (biasanya sama)
                    @if($latestMonitoringPreekripsi->inisiasi_nomor_mesin)
                        const nomorMesinElement = document.querySelector('input[name="inisiasi_nomor_mesin"]');
                        if (nomorMesinElement) {
                            nomorMesinElement.value = '{{ $latestMonitoringPreekripsi->inisiasi_nomor_mesin }}';
                            nomorMesinElement.classList.add('loaded-from-previous');
                            addLoadedIndicator(nomorMesinElement, 'Mesin yang sama dengan sesi sebelumnya');
                            console.log('Nomor Mesin loaded:', nomorMesinElement.value);
                        }
                    @endif

                    // Lama HD (biasanya sama)
                    @if($latestMonitoringPreekripsi->inisiasi_lama_hd)
                        const lamaHdElement = document.querySelector('input[name="inisiasi_lama_hd"]');
                        if (lamaHdElement) {
                            lamaHdElement.value = '{{ $latestMonitoringPreekripsi->inisiasi_lama_hd }}';
                            lamaHdElement.classList.add('loaded-from-previous');
                            addLoadedIndicator(lamaHdElement, 'Durasi HD sama dengan sesi sebelumnya');
                            console.log('Lama HD loaded:', lamaHdElement.value);
                        }
                    @endif

                    // === BAGIAN RUTIN ===
                    // BB Kering (data penting untuk dirujuk)
                    @if($latestMonitoringPreekripsi->rutin_bb_kering)
                        const bbKeringElement = document.querySelector('input[name="rutin_bb_kering"]');
                        if (bbKeringElement) {
                            bbKeringElement.value = '{{ $latestMonitoringPreekripsi->rutin_bb_kering }}';
                            bbKeringElement.classList.add('loaded-from-previous');
                            addLoadedIndicator(bbKeringElement, 'BB kering dari sesi sebelumnya - sesuaikan jika perlu');
                            console.log('BB Kering loaded:', bbKeringElement.value);
                        }
                    @endif

                    // TMP (biasanya konsisten)
                    @if($latestMonitoringPreekripsi->rutin_tmp)
                        const tmpElement = document.querySelector('input[name="rutin_tmp"]');
                        if (tmpElement) {
                            tmpElement.value = '{{ $latestMonitoringPreekripsi->rutin_tmp }}';
                            tmpElement.classList.add('loaded-from-previous');
                            addLoadedIndicator(tmpElement, 'TMP dari sesi sebelumnya');
                            console.log('TMP loaded:', tmpElement.value);
                        }
                    @endif

                    // === BAGIAN PRE OP ===
                    // Set nilai checkbox dan input untuk Dialisat
                    @if($latestMonitoringPreekripsi->preop_dialisat === 'Asetat')
                        const dialAsetatElement = document.getElementById('dialisat_asetat');
                        if (dialAsetatElement) {
                            dialAsetatElement.checked = true;
                            dialAsetatElement.classList.add('loaded-from-previous');
                            // Tambahkan label indicator
                            const asetatLabel = document.querySelector('label[for="dialisat_asetat"]');
                            if (asetatLabel) {
                                asetatLabel.innerHTML += ' <small class="loaded-indicator">(dari sesi sebelumnya)</small>';
                            }
                            console.log('Dialisat Asetat checked');
                        }
                    @endif
                    
                    @if($latestMonitoringPreekripsi->preop_bicarbonat === 'Bicarbonat')
                        const dialBicarbonatElement = document.getElementById('dialisat_bicarbonat');
                        if (dialBicarbonatElement) {
                            dialBicarbonatElement.checked = true;
                            dialBicarbonatElement.classList.add('loaded-from-previous');
                            // Tambahkan label indicator
                            const bicarbonatLabel = document.querySelector('label[for="dialisat_bicarbonat"]');
                            if (bicarbonatLabel) {
                                bicarbonatLabel.innerHTML += ' <small class="loaded-indicator">(dari sesi sebelumnya)</small>';
                            }
                            console.log('Dialisat Bicarbonat checked');
                        }
                    @endif

                    // Set nilai untuk Conductivity
                    @if($latestMonitoringPreekripsi->preop_conductivity)
                        const conductivityCheckElement = document.getElementById('conductivity_check');
                        const conductivityElement = document.getElementById('conductivity');
                        console.log('Setting conductivity:', '{{ $latestMonitoringPreekripsi->preop_conductivity }}');
                        if (conductivityCheckElement && conductivityElement) {
                            conductivityCheckElement.checked = true;
                            conductivityCheckElement.classList.add('loaded-from-previous');
                            conductivityElement.value = '{{ $latestMonitoringPreekripsi->preop_conductivity }}';
                            conductivityElement.disabled = false;
                            conductivityElement.classList.add('loaded-from-previous');
                            addLoadedIndicator(conductivityElement, 'Nilai conductivity dari sesi sebelumnya: {{ $latestMonitoringPreekripsi->preop_conductivity }}');
                            // Tambahkan indicator pada label checkbox
                            const conductivityLabel = document.querySelector('label[for="conductivity_check"]');
                            if (conductivityLabel) {
                                conductivityLabel.innerHTML += ' <small class="loaded-indicator">✓</small>';
                            }
                            console.log('Conductivity loaded - checkbox:', conductivityCheckElement.checked, 'value:', conductivityElement.value);
                        } else {
                            console.error('Conductivity elements not found!');
                        }
                    @endif

                    // Set nilai untuk Kalium
                    @if($latestMonitoringPreekripsi->preop_kalium)
                        const kaliumCheckElement = document.getElementById('kalium_check');
                        const kaliumElement = document.getElementById('kalium');
                        console.log('Setting kalium:', '{{ $latestMonitoringPreekripsi->preop_kalium }}');
                        if (kaliumCheckElement && kaliumElement) {
                            kaliumCheckElement.checked = true;
                            kaliumCheckElement.classList.add('loaded-from-previous');
                            kaliumElement.value = '{{ $latestMonitoringPreekripsi->preop_kalium }}';
                            kaliumElement.disabled = false;
                            kaliumElement.classList.add('loaded-from-previous');
                            addLoadedIndicator(kaliumElement, 'Nilai kalium dari sesi sebelumnya: {{ $latestMonitoringPreekripsi->preop_kalium }}');
                            // Tambahkan indicator pada label checkbox
                            const kaliumLabel = document.querySelector('label[for="kalium_check"]');
                            if (kaliumLabel) {
                                kaliumLabel.innerHTML += ' <small class="loaded-indicator">✓</small>';
                            }
                            console.log('Kalium loaded - checkbox:', kaliumCheckElement.checked, 'value:', kaliumElement.value);
                        } else {
                            console.error('Kalium elements not found!');
                        }
                    @endif

                    // Set nilai untuk Suhu Dialisat
                    @if($latestMonitoringPreekripsi->preop_suhu_dialisat)
                        const suhuDialisatCheckElement = document.getElementById('suhu_dialisat_check');
                        const suhuDialisatElement = document.getElementById('suhu_dialisat');
                        console.log('Setting suhu dialisat:', '{{ $latestMonitoringPreekripsi->preop_suhu_dialisat }}');
                        if (suhuDialisatCheckElement && suhuDialisatElement) {
                            suhuDialisatCheckElement.checked = true;
                            suhuDialisatCheckElement.classList.add('loaded-from-previous');
                            suhuDialisatElement.value = '{{ $latestMonitoringPreekripsi->preop_suhu_dialisat }}';
                            suhuDialisatElement.disabled = false;
                            suhuDialisatElement.classList.add('loaded-from-previous');
                            addLoadedIndicator(suhuDialisatElement, 'Suhu dialisat dari sesi sebelumnya: {{ $latestMonitoringPreekripsi->preop_suhu_dialisat }}');
                            // Tambahkan indicator pada label checkbox
                            const suhuLabel = document.querySelector('label[for="suhu_dialisat_check"]');
                            if (suhuLabel) {
                                suhuLabel.innerHTML += ' <small class="loaded-indicator">✓</small>';
                            }
                            console.log('Suhu Dialisat loaded - checkbox:', suhuDialisatCheckElement.checked, 'value:', suhuDialisatElement.value);
                        } else {
                            console.error('Suhu Dialisat elements not found!');
                        }
                    @endif

                    // Set nilai untuk Base Na
                    @if($latestMonitoringPreekripsi->preop_base_na)
                        const baseNaCheckElement = document.getElementById('base_na_check');
                        const baseNaElement = document.getElementById('base_na');
                        console.log('Setting base na:', '{{ $latestMonitoringPreekripsi->preop_base_na }}');
                        if (baseNaCheckElement && baseNaElement) {
                            baseNaCheckElement.checked = true;
                            baseNaCheckElement.classList.add('loaded-from-previous');
                            baseNaElement.value = '{{ $latestMonitoringPreekripsi->preop_base_na }}';
                            baseNaElement.disabled = false;
                            baseNaElement.classList.add('loaded-from-previous');
                            addLoadedIndicator(baseNaElement, 'Base Na dari sesi sebelumnya: {{ $latestMonitoringPreekripsi->preop_base_na }}');
                            // Tambahkan indicator pada label checkbox
                            const baseNaLabel = document.querySelector('label[for="base_na_check"]');
                            if (baseNaLabel) {
                                baseNaLabel.innerHTML += ' <small class="loaded-indicator">✓</small>';
                            }
                            console.log('Base Na loaded - checkbox:', baseNaCheckElement.checked, 'value:', baseNaElement.value);
                        } else {
                            console.error('Base Na elements not found!');
                        }
                    @endif

                    // Function untuk menambahkan indikator visual
                    function addLoadedIndicator(element, message) {
                        const indicator = document.createElement('small');
                        indicator.className = 'loaded-indicator';
                        indicator.textContent = message;
                        
                        // Insert indicator setelah element atau setelah parent terdekat
                        const parentDiv = element.closest('.col-sm-10, .col-sm-6, .form-group');
                        if (parentDiv) {
                            parentDiv.appendChild(indicator);
                        } else {
                            element.parentNode.insertBefore(indicator, element.nextSibling);
                        }
                    }

                    // Trigger toggle untuk memastikan field yang sesuai aktif/non-aktif
                    if (typeof togglePreOpFields === 'function') {
                        console.log('Triggering togglePreOpFields...');
                        togglePreOpFields();
                    } else {
                        console.warn('togglePreOpFields function not found');
                    }

                    // Show notification that data has been loaded
                    console.log('Data monitoring preekripsi terbaru telah dimuat untuk:', {
                        hdKe: '{{ $latestMonitoringPreekripsi->inisiasi_hd_ke ?? 'N/A' }}',
                        nomorMesin: '{{ $latestMonitoringPreekripsi->inisiasi_nomor_mesin ?? 'N/A' }}',
                        bbKering: '{{ $latestMonitoringPreekripsi->rutin_bb_kering ?? 'N/A' }}',
                        conductivity: '{{ $latestMonitoringPreekripsi->preop_conductivity ?? 'N/A' }}',
                        kalium: '{{ $latestMonitoringPreekripsi->preop_kalium ?? 'N/A' }}',
                        suhuDialisat: '{{ $latestMonitoringPreekripsi->preop_suhu_dialisat ?? 'N/A' }}',
                        baseNa: '{{ $latestMonitoringPreekripsi->preop_base_na ?? 'N/A' }}',
                        tanggalData: '{{ $latestMonitoringPreekripsi->created_at ?? 'N/A' }}'
                    });

                    // Optional: Tambahkan notifikasi visual jika menggunakan library notifikasi
                    if (typeof toastr !== 'undefined') {
                        toastr.info('Data monitoring preekripsi terbaru telah dimuat', 'Info', {
                            "closeButton": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "timeOut": "5000"
                        });
                    } else if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Data Dimuat',
                            text: 'Data monitoring preekripsi terbaru telah dimuat otomatis',
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    }
                    
                }, 1000); // 1 second delay to ensure all scripts are loaded
                
            @else
                console.log('Tidak ada data monitoring preekripsi sebelumnya untuk pasien ini');
            @endif
        });
    </script>
@endpush