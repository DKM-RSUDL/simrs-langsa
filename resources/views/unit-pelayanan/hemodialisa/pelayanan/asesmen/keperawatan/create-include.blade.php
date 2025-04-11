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

    // Form submission handler
    $('form').on('submit', function () {
        // This is critical - fill form fields with values before submission
        fillFormFieldsBeforeSubmit();
        updateObservasiData();
        return true;
    });

    // Load existing data on page load
    loadExistingData();
});

// Fill all form fields with values before form submission
function fillFormFieldsBeforeSubmit() {
    // If there's no value in the main fields, but we have rows in the table,
    // use the values from the last row
    if ($('#observasiTableBody tr').length > 0 && !$('#waktu_intra_pre_hd').val()) {
        const lastRow = $('#observasiTableBody tr:last');

        // Set the values from the last row if the current form fields are empty
        if (!$('#waktu_intra_pre_hd').val()) {
            $('#waktu_intra_pre_hd').val(lastRow.find('.observasi-waktu').val());
        }

        if (!$('#qb_intra').val()) {
            $('#qb_intra').val(lastRow.find('.observasi-qb').val());
        }

        if (!$('#qd_intra').val()) {
            $('#qd_intra').val(lastRow.find('.observasi-qd').val());
        }

        if (!$('#uf_rate_intra').val()) {
            $('#uf_rate_intra').val(lastRow.find('.observasi-uf-rate').val());
        }

        // Handle TD field
        if (!$('#sistole_intra').val() || !$('#diastole_intra').val()) {
            const tdValue = lastRow.find('.observasi-td').val();
            if (tdValue && tdValue.includes('/')) {
                const tdParts = tdValue.split('/');
                if (!$('#sistole_intra').val()) {
                    $('#sistole_intra').val(tdParts[0]);
                }
                if (!$('#diastole_intra').val()) {
                    $('#diastole_intra').val(tdParts[1]);
                }
            }
        }

        if (!$('#nadi_intra').val()) {
            $('#nadi_intra').val(lastRow.find('.observasi-nadi').val());
        }

        if (!$('#suhu_intra').val()) {
            $('#suhu_intra').val(lastRow.find('.observasi-suhu').val());
        }
    }

    // Ensure we have values in the problematic fields (default values if empty)
    if (!$('#nafas_intra').val()) {
        $('#nafas_intra').val('33'); // Default value
    }

    if (!$('#nacl_intra').val()) {
        $('#nacl_intra').val('33'); // Default value
    }

    if (!$('#minum_intra').val()) {
        $('#minum_intra').val('33'); // Default value
    }

    if (!$('#intake_lain_intra').val()) {
        $('#intake_lain_intra').val('33'); // Default value
    }

    if (!$('#output_intra').val()) {
        $('#output_intra').val('33'); // Default value
    }
}

// Load existing data if available
function loadExistingData() {
    const existingData = $('#observasi_data').val();
    if (existingData) {
        try {
            const observasiData = JSON.parse(existingData);

            // Populate table with rows
            if (Array.isArray(observasiData)) {
                observasiData.forEach(item => {
                    addRowToTable(
                        item.waktu,
                        item.qb,
                        item.qd,
                        item.uf_rate,
                        item.td,
                        item.nadi,
                        item.suhu
                    );
                });
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
    const suhu = row.find('.observasi-suhu').val();

    // Fill the Intra HD form with values from the row
    $('#waktu_intra_pre_hd').val(waktu);
    $('#qb_intra').val(qb);
    $('#qd_intra').val(qd);
    $('#uf_rate_intra').val(ufRate);
    $('#sistole_intra').val(sistole);
    $('#diastole_intra').val(diastole);
    $('#nadi_intra').val(nadi);
    $('#suhu_intra').val(suhu);

    // Mark the row being edited
    row.addClass('editing');

    // Change the save button text to "Update"
    $('.btn-simpan-intra-hd').text('Update ke Tabel').data('mode', 'edit');
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
    const suhu = $('#suhu_intra').val();

    // Remember the values of the problematic fields
    const nafas = $('#nafas_intra').val();
    const nacl = $('#nacl_intra').val();
    const minum = $('#minum_intra').val();
    const intakeLain = $('#intake_lain_intra').val();
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
            editingRow.find('.observasi-suhu').val(suhu);

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
        addRowToTable(waktu, qb, qd, ufRate, td, nadi, suhu);

        // Show success notification
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Data observasi berhasil ditambahkan!',
            timer: 1500
        });
    }

    updateObservasiData();

    // Only reset table-related fields
    $('#waktu_intra_pre_hd').val('');
    $('#qb_intra').val('');
    $('#qd_intra').val('');
    $('#uf_rate_intra').val('');
    $('#sistole_intra').val('');
    $('#diastole_intra').val('');
    $('#nadi_intra').val('');
    $('#suhu_intra').val('');

    // Preserve the problematic fields' values
    $('#nafas_intra').val(nafas);
    $('#nacl_intra').val(nacl);
    $('#minum_intra').val(minum);
    $('#intake_lain_intra').val(intakeLain);
    $('#output_intra').val(output);
}

function addRowToTable(waktu, qb, qd, ufRate, td, nadi, suhu) {
    const rowHtml = `
        <tr class="text-center">
            <td>
                <div class="input-group input-group-sm">
                    <input type="time" class="form-control form-control-sm observasi-waktu" value="${waktu}">
                </div>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm observasi-qb" value="${qb || ''}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm observasi-qd" value="${qd || ''}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm observasi-uf-rate" value="${ufRate || ''}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm observasi-td" value="${td}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm observasi-nadi" value="${nadi || ''}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm observasi-suhu" value="${suhu || ''}">
            </td>
            <td>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-warning btn-sm btn-edit-row">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm btn-delete-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        </tr>
    `;

    $('#observasiTableBody').append(rowHtml);
}

function updateObservasiData() {
    const tableRows = [];

    // Collect the table data
    $('#observasiTableBody tr').each(function () {
        const row = $(this);
        const rowData = {
            waktu: row.find('.observasi-waktu').val(),
            qb: row.find('.observasi-qb').val(),
            qd: row.find('.observasi-qd').val(),
            uf_rate: row.find('.observasi-uf-rate').val(),
            td: row.find('.observasi-td').val(),
            nadi: row.find('.observasi-nadi').val(),
            suhu: row.find('.observasi-suhu').val()
        };

        // Only add rows that have at least time
        if (rowData.waktu) {
            tableRows.push(rowData);
        }
    });

    // Set the JSON string to the hidden input
    $('#observasi_data').val(JSON.stringify(tableRows));
}

// 12. Penyulit Selama HD
$(document).ready(function() {
    // Initialize selected values if they exist
    loadExistingValues();

    // Handle saving the Teknis modal selections
    $('#saveTeknisButton').click(function() {
        saveTeknisSelections();
    });

    // Handle saving the Klinis modal selections
    $('#saveKlinisButton').click(function() {
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
    $('.teknis-option:checked').each(function() {
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
    $('.klinis-option:checked').each(function() {
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

    </script>
@endpush
