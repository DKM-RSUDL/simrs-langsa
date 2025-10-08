@push('js')
    <script>
        // Antropometri
        document.addEventListener('DOMContentLoaded', function () {
            // Ambil elemen input
            const tinggiBadanInput = document.getElementById('tinggi_badan');
            const beratBadanInput = document.getElementById('berat_badan');
            const imtInput = document.getElementById('imt');
            const lptInput = document.getElementById('lpt');

            // Fungsi untuk menghitung IMT
            function hitungIMT() {
                const tinggiBadan = parseFloat(tinggiBadanInput.value) || 0;
                const beratBadan = parseFloat(beratBadanInput.value) || 0;

                if (tinggiBadan > 0 && beratBadan > 0) {
                    const tinggiMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiMeter * tinggiMeter);
                    imtInput.value = imt.toFixed(2);
                } else {
                    imtInput.value = '';
                }
            }

            // Fungsi untuk menghitung LPT (Luas Permukaan Tubuh) dengan rumus DuBois
            function hitungLPT() {
                const tinggiBadan = parseFloat(tinggiBadanInput.value) || 0;
                const beratBadan = parseFloat(beratBadanInput.value) || 0;

                if (tinggiBadan > 0 && beratBadan > 0) {
                    const lpt = 0.007184 * Math.pow(tinggiBadan, 0.725) * Math.pow(beratBadan, 0.425);
                    lptInput.value = lpt.toFixed(2);
                } else {
                    lptInput.value = '';
                }
            }

            // Jalankan perhitungan saat halaman dimuat (jika ada data awal)
            hitungIMT();
            hitungLPT();

            // Jalankan perhitungan saat nilai tinggi atau berat berubah
            tinggiBadanInput.addEventListener('input', function () {
                hitungIMT();
                hitungLPT();
            });

            beratBadanInput.addEventListener('input', function () {
                hitungIMT();
                hitungLPT();
            });
        });

        //pemeriksaan fisik
        document.addEventListener('DOMContentLoaded', function () {
            //------------------------------------------------------------//
            // Event handler untuk tombol tambah keterangan di pemeriksaan fisik //
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

            // Memuat data dari server untuk mode edit
            // Memuat data obat pasien
            try {
                const obatPasienJson = document.getElementById('obat_pasien_json').value;
                if (obatPasienJson && obatPasienJson !== '') {
                    window.obatPasienData = JSON.parse(obatPasienJson);
                }
            } catch (error) {
                console.error('Error parsing obat pasien data:', error);
                window.obatPasienData = [];
            }

            // Memuat data obat dokter
            try {
                const obatDokterJson = document.getElementById('obat_dokter_json').value;
                if (obatDokterJson && obatDokterJson !== '') {
                    window.obatDokterData = JSON.parse(obatDokterJson);
                }
            } catch (error) {
                console.error('Error parsing obat dokter data:', error);
                window.obatDokterData = [];
            }

            // Render data awal
            renderObatPasienTable();
            renderObatDokterTable();
        });

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
                container.removeClass('alert-primary alert-warning alert-danger alert-success');

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

            // Inisialisasi tampilan berdasarkan data yang sudah ada
            function initializeFromExistingData() {
                // Jika ada data skor dan kesimpulan yang sudah ada, gunakan itu
                const existingSkor = $('#risiko_jatuh_skor').val();
                const existingKesimpulan = $('#risiko_jatuh_kesimpulan').val();

                if (existingKesimpulan && existingKesimpulan !== '') {
                    $('#kesimpulan-text').text(existingKesimpulan);
                    updateWarnaBgKesimpulan(existingKesimpulan);
                } else {
                    // Jika tidak ada kesimpulan yang tersimpan, hitung ulang berdasarkan pilihan yang ada
                    updateTampilan();
                }
            }

            // Periksa apakah semua select sudah memiliki nilai terpilih
            // Ini penting untuk mode edit agar kita tahu apakah perlu menghitung ulang atau tidak
            function checkAllSelectsHaveValue() {
                let allSelected = true;
                $('.risiko-jatuh-select').each(function() {
                    if (!$(this).val()) {
                        allSelected = false;
                        return false; // break the loop
                    }
                });
                return allSelected;
            }

            // Inisialisasi saat halaman load
            if (checkAllSelectsHaveValue()) {
                // Jika semua select sudah memiliki nilai (mode edit)
                initializeFromExistingData();
            } else {
                // Jika tidak semua select memiliki nilai (mode tambah)
                updateTampilan();
            }
        });

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
                    // Jangan kosongkan field pada mode edit jika user tidak mengubah pilihan
                    if (!document.getElementById('jika_ya_jelaskan').hasAttribute('data-original-value')) {
                        document.getElementById('jika_ya_jelaskan').value = '';
                    }
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

            // Simpan nilai asli jika_ya_jelaskan untuk mode edit
            const jikaYaJelaskan = document.getElementById('jika_ya_jelaskan');
            if (jikaYaJelaskan.value) {
                jikaYaJelaskan.setAttribute('data-original-value', jikaYaJelaskan.value);
            }

            // Update kondisi_psikologis_json saat halaman dimuat
            updateKondisiPsikologisJSON();

            // Initialize kepatuhan_layanan toggle - tidak perlu dipanggil karena display sudah diatur lewat HTML
            // toggleJikaYa();

            // Untuk form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function () {
                    updateKondisiPsikologisJSON();
                });
            }
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
                if (!$('#conductivity_check').is(':checked') && !$('#conductivity').data('has-value')) {
                    $('#conductivity').val('');
                }

                // Kalium
                $('#kalium').prop('disabled', !$('#kalium_check').is(':checked'));
                if (!$('#kalium_check').is(':checked') && !$('#kalium').data('has-value')) {
                    $('#kalium').val('');
                }

                // Suhu Dialisat
                $('#suhu_dialisat').prop('disabled', !$('#suhu_dialisat_check').is(':checked'));
                if (!$('#suhu_dialisat_check').is(':checked') && !$('#suhu_dialisat').data('has-value')) {
                    $('#suhu_dialisat').val('');
                }

                // Base Na
                $('#base_na').prop('disabled', !$('#base_na_check').is(':checked'));
                if (!$('#base_na_check').is(':checked') && !$('#base_na').data('has-value')) {
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

            // Mengisi form dari data dari model keperawatanMonitoringPreekripsi yang berbeda
            try {
                // Inisiasi
                $('#hd_ke').val('{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_hd_ke ?? "" }}');
                $('#nomor_mesin').val('{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_nomor_mesin ?? "" }}');
                $('#bb_hd_lalu').val('{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_bb_hd_lalu ?? "" }}');
                $('#tekanan_vena').val('{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_tekanan_vena ?? "" }}');
                $('#lama_hd').val('{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_lama_hd ?? "" }}');

                // Program profiling
                @if($asesmen->keperawatanMonitoringPreekripsi->uf_profiling ?? false)
                    $('#uf_profiling').prop('checked', true);
                    $('#uf_profiling_detail').val('{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_uf_profiling_detail ?? "" }}');
                @endif

                @if($asesmen->keperawatanMonitoringPreekripsi->bicarbonat_profiling ?? false)
                    $('#bicarbonat_profiling').prop('checked', true);
                    $('#bicarbonat_profiling_detail').val('{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_bicarbonat_profiling_detail ?? "" }}');
                @endif

                @if($asesmen->keperawatanMonitoringPreekripsi->na_profiling ?? false)
                    $('#na_profiling').prop('checked', true);
                    $('#na_profiling_detail').val('{{ $asesmen->keperawatanMonitoringPreekripsi->inisiasi_na_profiling_detail ?? "" }}');
                @endif

                // Akut
                $('#type_dializer').val('{{ $asesmen->keperawatanMonitoringPreekripsi->akut_type_dializer ?? "" }}');
                $('#uf_goal').val('{{ $asesmen->keperawatanMonitoringPreekripsi->akut_uf_goal ?? "" }}');
                $('#bb_pre_hd').val('{{ $asesmen->keperawatanMonitoringPreekripsi->akut_bb_pre_hd ?? "" }}');
                $('#tekanan_arteri').val('{{ $asesmen->keperawatanMonitoringPreekripsi->akut_tekanan_arteri ?? "" }}');
                $('#laju_uf').val('{{ $asesmen->keperawatanMonitoringPreekripsi->akut_laju_uf ?? "" }}');
                $('#lama_laju_uf').val('{{ $asesmen->keperawatanMonitoringPreekripsi->akut_lama_laju_uf ?? "" }}');

                // Rutin
                $('#nr_ke').val('{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_nr_ke ?? "" }}');
                $('#bb_kering').val('{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_kering ?? "" }}');
                $('#bb_post_hd').val('{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_bb_post_hd ?? "" }}');
                $('#tmp').val('{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_tmp ?? "" }}');

                // Program aksesbilling
                @if($asesmen->keperawatanMonitoringPreekripsi->av_shunt ?? false)
                    $('#av_shunt').prop('checked', true);
                    $('#av_shunt_detail').val('{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_av_shunt_detail ?? "" }}');
                @endif

                @if($asesmen->keperawatanMonitoringPreekripsi->cdl ?? false)
                    $('#cdl').prop('checked', true);
                    $('#cdl_detail').val('{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_cdl_detail ?? "" }}');
                @endif

                @if($asesmen->keperawatanMonitoringPreekripsi->femoral ?? false)
                    $('#femoral').prop('checked', true);
                    $('#femoral_detail').val('{{ $asesmen->keperawatanMonitoringPreekripsi->rutin_femoral_detail ?? "" }}');
                @endif

                // Pre Op
                @if($asesmen->keperawatanMonitoringPreekripsi->dialisat_asetat ?? false)
                    $('#dialisat_asetat').prop('checked', true);
                @endif

                @if($asesmen->keperawatanMonitoringPreekripsi->dialisat_bicarbonat ?? false)
                    $('#dialisat_bicarbonat').prop('checked', true);
                @endif

                @if($asesmen->keperawatanMonitoringPreekripsi->conductivity_check ?? false)
                    $('#conductivity_check').prop('checked', true);
                    $('#conductivity').val('{{ $asesmen->keperawatanMonitoringPreekripsi->preop_conductivity ?? "" }}');
                    $('#conductivity').data('has-value', true);
                @endif

                @if($asesmen->keperawatanMonitoringPreekripsi->kalium_check ?? false)
                    $('#kalium_check').prop('checked', true);
                    $('#kalium').val('{{ $asesmen->keperawatanMonitoringPreekripsi->preop_kalium ?? "" }}');
                    $('#kalium').data('has-value', true);
                @endif

                @if($asesmen->keperawatanMonitoringPreekripsi->suhu_dialisat_check ?? false)
                    $('#suhu_dialisat_check').prop('checked', true);
                    $('#suhu_dialisat').val('{{ $asesmen->keperawatanMonitoringPreekripsi->preop_suhu_dialisat ?? "" }}');
                    $('#suhu_dialisat').data('has-value', true);
                @endif

                @if($asesmen->keperawatanMonitoringPreekripsi->base_na_check ?? false)
                    $('#base_na_check').prop('checked', true);
                    $('#base_na').val('{{ $asesmen->keperawatanMonitoringPreekripsi->preop_base_na ?? "" }}');
                    $('#base_na').data('has-value', true);
                @endif

                // Update tampilan setelah mengisi data
                toggleDetailFields();
                togglePreOpFields();

                // Setelah memuat data, update hidden input dengan data yang sudah diolah
                const formData = collectFormData();
                $('#monitoring_hemodialisis_data').val(JSON.stringify(formData));
            } catch (e) {
                console.error('Error loading monitoring data:', e);
            }
        });
    
        // Edit lanjutan bagian Intra HD
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
                updateObservasiData();
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
                                item.waktu || '',
                                item.qb || '',
                                item.qd || '',
                                item.uf_rate || '',
                                item.td || '',
                                item.nadi || '',
                                item.nafas || '',
                                item.suhu || '',
                                item.nacl || '',
                                item.minum || '',
                                item.lain_lain || '',
                                item.output || ''
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
                sistole = tdParts[0].trim();
                diastole = tdParts[1].trim();
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
                        timer: 1500,
                        showConfirmButton: false
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
                    timer: 1500,
                    showConfirmButton: false
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

        // Helper function untuk debug
        function checkObservasiData() {
            const data = $('#observasi_data').val();
            console.log('Current observasi_data:', data);
            try {
                const parsed = JSON.parse(data);
                console.log('Parsed data:', parsed);
            } catch(e) {
                console.log('Not valid JSON');
            }
            return data;
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

            // Load existing values if they exist
            loadExistingRencanaPulangValues();

            // Menyimpan pilihan saat tombol Simpan ditekan
            saveRencanaPulangButton.addEventListener('click', function () {
                const selectedOptions = Array.from(rencanaPulangOptions)
                    .filter(option => option.checked)
                    .map(option => option.value);

                // Memperbarui input tersembunyi dengan nilai yang dipilih (JSON string)
                rencanaPulangValues.value = JSON.stringify(selectedOptions);

                // Memperbarui tampilan
                updateRencanaPulangDisplay(selectedOptions);
            });

            // Function to load existing values
            function loadExistingRencanaPulangValues() {
                try {
                    if (rencanaPulangValues.value) {
                        const selectedOptions = JSON.parse(rencanaPulangValues.value);
                        
                        // Check the appropriate checkboxes
                        selectedOptions.forEach(value => {
                            const option = Array.from(rencanaPulangOptions).find(opt => opt.value === value);
                            if (option) {
                                option.checked = true;
                            }
                        });
                        
                        // Update the display
                        updateRencanaPulangDisplay(selectedOptions);
                    }
                } catch (e) {
                    console.error('Error parsing rencana pulang values:', e);
                }
            }

            // Function to update the display
            function updateRencanaPulangDisplay(selectedOptions) {
                if (selectedOptions.length > 0) {
                    rencanaPulangDisplay.value = `${selectedOptions.length} item dipilih`;
                    rencanaPulangSelectedItems.innerHTML = selectedOptions.map(item =>
                        `<span class="badge bg-light text-dark me-1 mb-1">${item}</span>`
                    ).join('');
                } else {
                    rencanaPulangDisplay.value = 'Pemulangan Asupan Cairan';
                    rencanaPulangSelectedItems.innerHTML = '';
                }
            }
        });
    
        // 8. Diagnosis Diagnosis Banding
        document.addEventListener('DOMContentLoaded', function () {
            // Get master diagnosis data from PHP
            const dbMasterDiagnosis = @json($rmeMasterDiagnosis->pluck('nama_diagnosis'));

            // Initialize both diagnosis sections
            initDiagnosisManagement('diagnosis-banding', 'diagnosis_banding');
            initDiagnosisManagement('diagnosis-kerja', 'diagnosis_kerja');

            function initDiagnosisManagement(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);

                // Create suggestions container
                const suggestionsList = document.createElement('div');
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow-sm';
                suggestionsList.style.cssText = 'z-index: 1000; max-height: 200px; overflow-y: auto; width: calc(100% - 30px); display: none;';
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Initialize diagnosis list from hidden input
                let diagnosisList = [];
                try {
                    diagnosisList = JSON.parse(hiddenInput.value) || [];
                    renderDiagnosisList();
                } catch (e) {
                    console.error('Error parsing initial diagnosis data:', e);
                    diagnosisList = [];
                    updateHiddenInput();
                }

                // Handle input changes for suggestions
                inputField.addEventListener('input', function () {
                    const searchTerm = this.value.trim().toLowerCase();
                    if (!searchTerm) {
                        suggestionsList.style.display = 'none';
                        return;
                    }

                    // Filter suggestions from master data
                    const matches = dbMasterDiagnosis.filter(diagnosis =>
                        diagnosis.toLowerCase().includes(searchTerm)
                    );

                    // Show suggestions
                    showSuggestions(matches, searchTerm);
                });

                // Handle suggestion display
                function showSuggestions(matches, searchTerm) {
                    suggestionsList.innerHTML = '';

                    // Add matching items
                    matches.forEach(match => {
                        const div = document.createElement('div');
                        div.className = 'suggestion-item p-2 cursor-pointer hover:bg-gray-100';
                        div.textContent = match;
                        div.addEventListener('click', () => {
                            addDiagnosis(match);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(div);
                    });

                    // Add option to create new if no exact match
                    if (!matches.some(m => m.toLowerCase() === searchTerm)) {
                        const newOption = document.createElement('div');
                        newOption.className = 'suggestion-item p-2 cursor-pointer text-primary hover:bg-gray-100';
                        newOption.textContent = `Tambah "${searchTerm}"`;
                        newOption.addEventListener('click', () => {
                            addDiagnosis(searchTerm);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOption);
                    }

                    suggestionsList.style.display = matches.length || searchTerm ? 'block' : 'none';
                }

                // Add diagnosis handler
                function addDiagnosis(text) {
                    if (!diagnosisList.includes(text)) {
                        diagnosisList.push(text);
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Duplikasi',
                            text: `"${text}" sudah ada dalam daftar`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }

                // Render diagnosis list
                function renderDiagnosisList() {
                    listContainer.innerHTML = '';
                    diagnosisList.forEach((diagnosis, index) => {
                        const item = document.createElement('div');
                        item.className = 'diagnosis-item d-flex justify-content-between align-items-center mb-2';

                        const text = document.createElement('span');
                        text.textContent = `${index + 1}. ${diagnosis}`;

                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'btn btn-sm text-danger';
                        deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteBtn.type = 'button';
                        deleteBtn.onclick = () => {
                            diagnosisList.splice(index, 1);
                            renderDiagnosisList();
                            updateHiddenInput();
                        };

                        item.appendChild(text);
                        item.appendChild(deleteBtn);
                        listContainer.appendChild(item);
                    });
                }

                // Update hidden input
                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(diagnosisList);
                }

                // Event listeners for add button and enter key
                addButton.addEventListener('click', () => {
                    const text = inputField.value.trim();
                    if (text) addDiagnosis(text);
                });

                inputField.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const text = inputField.value.trim();
                        if (text) addDiagnosis(text);
                    }
                });

                // Close suggestions on outside click
                document.addEventListener('click', (e) => {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });
            }
        });

        // 9.Implementasi
        document.addEventListener('DOMContentLoaded', function () {
            const sections = ['observasi', 'terapeutik', 'edukasi', 'kolaborasi', 'prognosis'];
            const masterImplementasi = @json($rmeMasterImplementasi);

            sections.forEach(section => {
                initImplementationSection(section);
            });

            function initImplementationSection(section) {
                const inputField = document.getElementById(`${section}-input`);
                const addButton = document.getElementById(`add-${section}`);
                const listContainer = document.getElementById(`${section}-list`);
                const hiddenInput = document.getElementById(section);

                // Create suggestions container
                const suggestionsList = document.createElement('div');
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow-sm';
                suggestionsList.style.cssText = 'z-index: 1000; max-height: 200px; overflow-y: auto; width: calc(100% - 40px); display: none;';
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Get options from database
                const dbOptions = masterImplementasi
                    .filter(item => item[section] && item[section] !== '(N/A)' && item[section] !== '(Null)')
                    .map(item => item[section]);
                const uniqueOptions = [...new Set(dbOptions)];

                // Initialize list from hidden input
                let itemsList = [];
                try {
                    itemsList = JSON.parse(hiddenInput.value) || [];
                    renderItemsList();
                } catch (e) {
                    console.error(`Error parsing ${section} data:`, e);
                    itemsList = [];
                    updateHiddenInput();
                }

                // Handle input changes
                inputField.addEventListener('input', function () {
                    const searchTerm = this.value.trim().toLowerCase();
                    if (!searchTerm) {
                        suggestionsList.style.display = 'none';
                        return;
                    }

                    const matches = uniqueOptions.filter(option =>
                        option.toLowerCase().includes(searchTerm)
                    );
                    showSuggestions(matches, searchTerm);
                });

                function showSuggestions(matches, searchTerm) {
                    suggestionsList.innerHTML = '';

                    // Add matching items
                    matches.forEach(match => {
                        const div = document.createElement('div');
                        div.className = 'suggestion-item p-2 cursor-pointer hover:bg-gray-100';
                        div.textContent = match;
                        div.addEventListener('click', () => {
                            addItem(match);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(div);
                    });

                    // Add "create new" option if no exact match
                    if (!matches.some(m => m.toLowerCase() === searchTerm)) {
                        const newOption = document.createElement('div');
                        newOption.className = 'suggestion-item p-2 cursor-pointer text-primary hover:bg-gray-100';
                        newOption.innerHTML = `<i class="bi bi-plus-circle me-1"></i>Tambah "${searchTerm}"`;
                        newOption.addEventListener('click', () => {
                            addItem(searchTerm);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOption);
                    }

                    suggestionsList.style.display = 'block';
                }

                function addItem(text) {
                    if (!itemsList.includes(text)) {
                        itemsList.push(text);
                        inputField.value = '';
                        renderItemsList();
                        updateHiddenInput();
                    } else {
                        // Show duplicate warning
                        Swal.fire({
                            icon: 'warning',
                            title: 'Duplikasi',
                            text: `"${text}" sudah ada dalam daftar`,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }

                function renderItemsList() {
                    listContainer.innerHTML = '';

                    if (itemsList.length === 0) {
                        const emptyMsg = document.createElement('div');
                        emptyMsg.className = 'text-muted fst-italic small';
                        emptyMsg.textContent = 'Belum ada data';
                        listContainer.appendChild(emptyMsg);
                        return;
                    }

                    itemsList.forEach((item, index) => {
                        const itemElement = document.createElement('div');
                        itemElement.className = 'd-flex justify-content-between align-items-center mb-2';

                        const itemSpan = document.createElement('span');
                        itemSpan.textContent = `${index + 1}. ${item}`;

                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'btn btn-sm text-danger';
                        deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteBtn.type = 'button';
                        deleteBtn.onclick = () => {
                            itemsList.splice(index, 1);
                            renderItemsList();
                            updateHiddenInput();
                        };

                        itemElement.appendChild(itemSpan);
                        itemElement.appendChild(deleteBtn);
                        listContainer.appendChild(itemElement);
                    });
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(itemsList);
                }

                // Event listeners
                addButton.addEventListener('click', () => {
                    const text = inputField.value.trim();
                    if (text) addItem(text);
                });

                inputField.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const text = inputField.value.trim();
                        if (text) addItem(text);
                    }
                });

                // Close suggestions on outside click
                document.addEventListener('click', (e) => {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });
            }
        });
    
        // 17. Tanda Tangan dan Verifikasi
        document.addEventListener('DOMContentLoaded', function() {
            let petugasCounter = 0;
            const petugasList = []; // Array untuk menyimpan data perawat
            let qrPemeriksa = null;
            let qrDokter = null;

            // Cek apakah QRCode library ada
            function waitForQRCode(callback) {
                if (typeof QRCode !== 'undefined') {
                    callback();
                } else {
                    setTimeout(() => waitForQRCode(callback), 100);
                }
            }

            // Fungsi untuk update JSON di hidden input
            function updateJSONInput() {
                const jsonInput = document.getElementById('perawat-bertugas-json');
                if (jsonInput) {
                    jsonInput.value = JSON.stringify(petugasList);
                    // console.log('Data JSON:', jsonInput.value);
                }
            }

            // Fungsi untuk render item perawat
            function renderPetugasItem(perawat) {
                const listContainer = document.getElementById('list-perawat-bertugas');
                if (!listContainer) return;

                const petugasItem = document.createElement('div');
                petugasItem.className = 'border-bottom pb-2 mb-2';
                petugasItem.dataset.kode = perawat.kd_karyawan;
                petugasItem.innerHTML = `
                    <div class="row align-items-center py-2">
                        <div class="col-auto">
                            <span class="badge bg-primary rounded-circle" style="width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; font-size: 13px;">
                                ${perawat.urutan}
                            </span>
                        </div>
                        <div class="col">
                            <strong>${perawat.nama}</strong>
                        </div>
                        <div class="col-auto">
                            <div id="qr-bertugas-${perawat.kd_karyawan}" class="d-inline-block"></div>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted">No. ${perawat.kd_karyawan}</small>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger btn-sm" onclick="window.removePetugasHandler('${perawat.kd_karyawan}')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                `;
                
                listContainer.appendChild(petugasItem);
                
                // Generate QR Code - tunggu library ready
                waitForQRCode(() => {
                    const qrContainer = document.getElementById(`qr-bertugas-${perawat.kd_karyawan}`);
                    if (qrContainer) {
                        new QRCode(qrContainer, {
                            text: `PERAWAT_BERTUGAS:${perawat.kd_karyawan}`,
                            width: 60,
                            height: 60,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    }
                });
            }

            // Fungsi hapus petugas
            function removePetugas(kdKaryawan) {
                if (confirm('Apakah Anda yakin ingin menghapus perawat ini?')) {
                    // Hapus dari array
                    const index = petugasList.findIndex(p => p.kd_karyawan === kdKaryawan);
                    if (index > -1) {
                        petugasList.splice(index, 1);
                    }

                    // Update JSON input
                    updateJSONInput();

                    // Hapus elemen dari DOM
                    const item = document.querySelector(`[data-kode="${kdKaryawan}"]`);
                    if (item) {
                        item.remove();
                    }

                    // Update nomor urut
                    updatePetugasNumbers();

                    // Tampilkan pesan kosong jika tidak ada petugas
                    const emptyMsg = document.getElementById('empty-message');
                    if (petugasList.length === 0 && emptyMsg) {
                        emptyMsg.style.display = 'block';
                        petugasCounter = 0;
                    }
                }
            }

            // Expose ke window agar bisa dipanggil dari onclick
            window.removePetugasHandler = removePetugas;

            // Fungsi update nomor urut
            function updatePetugasNumbers() {
                const items = document.querySelectorAll('#list-perawat-bertugas > div[data-kode]');
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

            // ===== LOAD DATA EXISTING (UNTUK EDIT) =====
            @if(isset($asesmen->keperawatan->perawat_bertugas) && !empty($asesmen->keperawatan->perawat_bertugas))
                try {
                    const existingData = @json(json_decode($asesmen->keperawatan->perawat_bertugas, true));
                    
                    if (existingData && Array.isArray(existingData) && existingData.length > 0) {
                        existingData.forEach((perawat) => {
                            petugasList.push(perawat);
                            petugasCounter = Math.max(petugasCounter, perawat.urutan);
                            renderPetugasItem(perawat);
                        });
                        
                        const emptyMsg = document.getElementById('empty-message');
                        if (emptyMsg) {
                            emptyMsg.style.display = 'none';
                        }
                        updateJSONInput();
                    }
                } catch (e) {
                    console.error('Error loading existing data:', e);
                }
            @endif

            // ===== LOAD QR CODE PERAWAT PEMERIKSA (JIKA ADA) =====
            @if(isset($asesmen->keperawatan->perawat_pemeriksa) && !empty($asesmen->keperawatan->perawat_pemeriksa))
                waitForQRCode(() => {
                    const kdPemeriksa = '{{ $asesmen->keperawatan->perawat_pemeriksa }}';
                    const qrContainerPemeriksa = document.getElementById('qr-pemeriksa');
                    const noContainerPemeriksa = document.getElementById('no-pemeriksa');
                    
                    if (kdPemeriksa && qrContainerPemeriksa) {
                        qrPemeriksa = new QRCode(qrContainerPemeriksa, {
                            text: `PERAWAT_PEMERIKSA:${kdPemeriksa}`,
                            width: 100,
                            height: 100,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                        if (noContainerPemeriksa) {
                            noContainerPemeriksa.textContent = `No. ${kdPemeriksa}`;
                        }
                    }
                });
            @endif

            // ===== LOAD QR CODE DOKTER DPJP (JIKA ADA) =====
            @if(isset($asesmen->keperawatan->dokter_pelaksana) && !empty($asesmen->keperawatan->dokter_pelaksana))
                waitForQRCode(() => {
                    const kdDokter = '{{ $asesmen->keperawatan->dokter_pelaksana }}';
                    const qrContainerDokter = document.getElementById('qr-dokter');
                    const noContainerDokter = document.getElementById('no-dokter');
                    
                    if (kdDokter && qrContainerDokter) {
                        qrDokter = new QRCode(qrContainerDokter, {
                            text: `DOKTER_DPJP:${kdDokter}`,
                            width: 100,
                            height: 100,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                        if (noContainerDokter) {
                            noContainerDokter.textContent = `No. ${kdDokter}`;
                        }
                    }
                });
            @endif

            // ===== PERAWAT PEMERIKSA (Single Select dengan QR) =====
            const perawatPemeriksaEl = document.getElementById('perawat-pemeriksa');
            if (perawatPemeriksaEl) {
                perawatPemeriksaEl.addEventListener('change', function() {
                    const kdKaryawan = this.value;
                    const qrContainer = document.getElementById('qr-pemeriksa');
                    const noContainer = document.getElementById('no-pemeriksa');
                    
                    if (!qrContainer) return;
                    
                    // Clear previous QR
                    qrContainer.innerHTML = '';
                    
                    if (kdKaryawan) {
                        waitForQRCode(() => {
                            qrPemeriksa = new QRCode(qrContainer, {
                                text: `PERAWAT_PEMERIKSA:${kdKaryawan}`,
                                width: 100,
                                height: 100,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                                correctLevel: QRCode.CorrectLevel.H
                            });
                            
                            if (noContainer) {
                                noContainer.textContent = `No. ${kdKaryawan}`;
                            }
                        });
                    } else if (noContainer) {
                        noContainer.textContent = 'No..........................';
                    }
                });
            }

            // ===== DOKTER DPJP (Single Select dengan QR) =====
            const dokterPelaksanaEl = document.getElementById('dokter-pelaksana');
            if (dokterPelaksanaEl) {
                dokterPelaksanaEl.addEventListener('change', function() {
                    const kdDokter = this.value;
                    const qrContainer = document.getElementById('qr-dokter');
                    const noContainer = document.getElementById('no-dokter');
                    
                    if (!qrContainer) return;
                    
                    // Clear previous QR
                    qrContainer.innerHTML = '';
                    
                    if (kdDokter) {
                        waitForQRCode(() => {
                            qrDokter = new QRCode(qrContainer, {
                                text: `DOKTER_DPJP:${kdDokter}`,
                                width: 100,
                                height: 100,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                                correctLevel: QRCode.CorrectLevel.H
                            });
                            
                            if (noContainer) {
                                noContainer.textContent = `No. ${kdDokter}`;
                            }
                        });
                    } else if (noContainer) {
                        noContainer.textContent = 'No..........................';
                    }
                });
            }

            // ===== PERAWAT BERTUGAS (Multiple Select dengan QR) =====
            const btnTambahPerawat = document.getElementById('btn-tambah-perawat');
            if (btnTambahPerawat) {
                btnTambahPerawat.addEventListener('click', function() {
                    const selector = document.getElementById('perawat-selector');
                    if (!selector) return;
                    
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
                    const emptyMsg = document.getElementById('empty-message');
                    if (emptyMsg) {
                        emptyMsg.style.display = 'none';
                    }

                    // Render item
                    renderPetugasItem(petugasData);

                    // Reset selector
                    selector.value = '';
                    if (typeof $ !== 'undefined' && typeof $(selector).select2 !== 'undefined') {
                        $(selector).val(null).trigger('change');
                    }
                });
            }
        });
    </script>
@endpush
