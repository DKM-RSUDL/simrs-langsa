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

        .dropdown-menu {
            display: none;
            position: fixed;
            /* Ubah ke absolute */
            min-width: 300px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
            z-index: 1000;
            transform: translateY(5px);
            /* Tambahkan sedikit offset */
            max-height: 400px;
            overflow-y: auto;
        }

        /* Tambahkan wrapper untuk positioning yang lebih baik */
        .dropdown-wrapper {
            position: relative;
            display: inline-block;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //====================================================================================//
            // Fungsi Hitung IMT dan LPT
            //====================================================================================//
            function hitungIMT_LPT() {
                let tinggi = parseFloat(document.getElementById("tinggi_badan").value) / 100;
                let berat = parseFloat(document.getElementById("berat_badan").value);
                if (!isNaN(tinggi) && !isNaN(berat) && tinggi > 0) {
                    let imt = berat / (tinggi * tinggi);
                    let lpt = (tinggi * 100 * berat) / 3600;
                    document.getElementById("imt").value = imt.toFixed(2);
                    document.getElementById("lpt").value = lpt.toFixed(2);
                } else {
                    document.getElementById("imt").value = "";
                    document.getElementById("lpt").value = "";
                }
            }

            document.getElementById("tinggi_badan")?.addEventListener("input", hitungIMT_LPT);
            document.getElementById("berat_badan")?.addEventListener("input", hitungIMT_LPT);

            //====================================================================================//
            // Pemeriksaan Fisik (ditambahkan pengecekan null)
            //===================================================================================//

            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
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

            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const pemeriksaanItem = this.closest('.pemeriksaan-item');
                    if (pemeriksaanItem) {
                        const keteranganDiv = pemeriksaanItem.querySelector('.keterangan');
                        if (keteranganDiv) {
                            if (this.checked) {
                                keteranganDiv.style.display = 'none';
                                const input = keteranganDiv.querySelector('input');
                                if (input) input.value = '';
                            }
                        }
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.pemeriksaan-item').forEach(item => {
                    const keteranganInput = item.querySelector('.keterangan input');
                    const normalCheckbox = item.querySelector('.form-check-input');
                    const keteranganDiv = item.querySelector('.keterangan');

                    // Jika ada nilai keterangan
                    if (keteranganInput && keteranganInput.value) {
                        normalCheckbox.checked = false;
                        keteranganDiv.style.display = 'block';
                    }
                });
            });

            //====================================================================================//
            // Down Score Modal
            //====================================================================================//
            const downScoreModal = document.getElementById('downScoreModal');
            const checkboxes = document.querySelectorAll('.down-score-check');
            const totalScore = document.getElementById('totalScore');
            const kesimpulan = document.getElementById('kesimpulanBox');
            const downScoreInput = document.getElementById('down_score');
            const simpanBtn = document.getElementById('btnSimpanScore');

            // Fungsi hitung skor
            function hitungSkor() {
                let skor = 0;
                const kategori = ['frekuensi_nafas', 'retraksi', 'sianosis', 'airway', 'merintih'];
                kategori.forEach(kat => {
                    const checked = document.querySelector(`input[name="${kat}"]:checked`);
                    if (checked) {
                        skor += parseInt(checked.value);
                    }
                });
                totalScore.value = skor;
                if (skor < 3) {
                    kesimpulan.textContent = 'TIDAK GAWAT NAFAS';
                    kesimpulan.style.backgroundColor = '#28a745';
                    kesimpulan.style.color = 'white';
                } else if (skor >= 3 && skor <= 6) {
                    kesimpulan.textContent = 'GAWAT NAFAS';
                    kesimpulan.style.backgroundColor = '#ffc107';
                    kesimpulan.style.color = 'black';
                } else {
                    kesimpulan.textContent = 'GAWAT NAFAS MENGANCAM';
                    kesimpulan.style.backgroundColor = '#dc3545';
                    kesimpulan.style.color = 'white';
                }
            }

            // Event checkbox
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const nama = this.name;
                    document.querySelectorAll(`input[name="${nama}"]`).forEach(cb => {
                        if (cb !== this) cb.checked = false;
                    });
                    hitungSkor();
                });
            });

            // Event simpan
            simpanBtn.addEventListener('click', function() {
                const skor = parseInt(totalScore.value) || 0;
                downScoreInput.value = skor;
                const modal = bootstrap.Modal.getInstance(downScoreModal);
                if (modal) {
                    modal.hide();
                } else {
                    downScoreModal.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    const backdrop = document.querySelector('.modal-backdrop');
                    if (backdrop) backdrop.remove();
                }
            });

            // Reset saat modal dibuka
            downScoreModal.addEventListener('shown.bs.modal', function() {
                checkboxes.forEach(cb => cb.checked = false); // Hapus semua centang
                totalScore.value = '0'; // Set skor awal ke 0
                kesimpulan.textContent = 'TIDAK GAWAT NAFAS';
                kesimpulan.style.backgroundColor = '#28a745';
                kesimpulan.style.color = 'white';
            });

            // Hitung awal
            hitungSkor();

            //====================================================================================//
            // Event handler untuk tombol Tambah Riwayat
            //====================================================================================// 
            let riwayatArray = [];

            function updateRiwayatJson() {
                document.getElementById('riwayatJson').value = JSON.stringify(riwayatArray);
            }

            document.getElementById('btnTambahRiwayat')?.addEventListener('click', function() {
                // Reset input di modal saat dibuka
                document.getElementById('namaPenyakit').value = '';
                document.getElementById('namaObat').value = '';
            });

            document.getElementById('btnTambahRiwayatModal')?.addEventListener('click', function() {
                const namaPenyakit = document.getElementById('namaPenyakit').value.trim();
                const namaObat = document.getElementById('namaObat').value.trim();
                const tbody = document.querySelector('#riwayatTable tbody');

                if (namaPenyakit || namaObat) {
                    // Buat object untuk riwayat
                    const riwayatEntry = {
                        penyakit: namaPenyakit || '-',
                        obat: namaObat || '-'
                    };

                    // Tambahkan ke array
                    riwayatArray.push(riwayatEntry);

                    // Buat baris baru untuk tabel
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${namaPenyakit || '-'}</td>
                        <td>${namaObat || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm hapus-riwayat">Hapus</button>
                        </td>
                    `;

                    tbody.appendChild(row);

                    // Tambahkan event untuk tombol hapus
                    row.querySelector('.hapus-riwayat')?.addEventListener('click', function() {
                        const index = riwayatArray.findIndex(item =>
                            item.penyakit === (namaPenyakit || '-') &&
                            item.obat === (namaObat || '-')
                        );
                        if (index !== -1) {
                            riwayatArray.splice(index, 1);
                        }
                        row.remove();
                        updateRiwayatJson();
                    });

                    // Update hidden input
                    updateRiwayatJson();

                    // Tutup modal
                    bootstrap.Modal.getInstance(document.getElementById('riwayatModal')).hide();
                } else {
                    alert('Mohon isi setidaknya salah satu field (Penyakit atau Obat)');
                }
            });

            // Reset modal saat ditutup
            const riwayatModal = document.getElementById('riwayatModal');
            riwayatModal?.addEventListener('hidden.bs.modal', function() {
                document.getElementById('namaPenyakit').value = '';
                document.getElementById('namaObat').value = '';
            });

            //====================================================================================//
            // Event handler untuk status nyeri
            //====================================================================================//
            const skalaSelect = document.getElementById('jenis_skala_nyeri');
            const nrsModal = document.getElementById('modalNRS');
            const flaccModal = document.getElementById('modalFLACC');
            const criesModal = document.getElementById('modalCRIES');
            const nrsValue = document.getElementById('nrs_value');
            const nrsKesimpulan = document.getElementById('nrs_kesimpulan');
            const simpanNRS = document.getElementById('simpanNRS');
            const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
            const kesimpulanNyeri = document.getElementById('kesimpulan_nyeri');
            const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');

            if (skalaSelect) {
                skalaSelect.addEventListener('change', function() {
                    // Close any open modals first
                    const openModals = document.querySelectorAll('.modal.show');
                    openModals.forEach(modal => {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) modalInstance.hide();
                    });

                    // Show the selected modal
                    if (this.value === 'NRS') {
                        const modal = new bootstrap.Modal(nrsModal);
                        modal.show();
                    } else if (this.value === 'FLACC') {
                        const modal = new bootstrap.Modal(flaccModal);
                        modal.show();
                    } else if (this.value === 'CRIES') {
                        const modal = new bootstrap.Modal(criesModal);
                        modal.show();
                    }
                });
            }

            // NRS value handler
            if (nrsValue) {
                nrsValue.addEventListener('input', function() {
                    let value = parseInt(this.value);

                    // Validate range
                    if (value < 0) this.value = 0;
                    if (value > 10) this.value = 10;
                    value = parseInt(this.value);

                    // Set kesimpulan
                    let kesimpulan = '';
                    let alertClass = '';
                    let emoji = '';

                    if (value >= 0 && value <= 3) {
                        kesimpulan = 'Nyeri Ringan';
                        alertClass = 'alert-success';
                        emoji = 'bi-emoji-smile';
                    } else if (value >= 4 && value <= 6) {
                        kesimpulan = 'Nyeri Sedang';
                        alertClass = 'alert-warning';
                        emoji = 'bi-emoji-neutral';
                    } else if (value >= 7 && value <= 10) {
                        kesimpulan = 'Nyeri Berat';
                        alertClass = 'alert-danger';
                        emoji = 'bi-emoji-frown';
                    }

                    if (nrsKesimpulan) {
                        nrsKesimpulan.className = 'alert ' + alertClass;
                        nrsKesimpulan.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${emoji} fs-4"></i>
                                <span>${kesimpulan}</span>
                            </div>
                        `;
                    }
                });
            }

            // Save NRS value
            if (simpanNRS) {
                simpanNRS.addEventListener('click', function() {
                    if (nilaiSkalaNyeri && nrsValue && kesimpulanNyeri && kesimpulanNyeriAlert) {
                        const value = parseInt(nrsValue.value);
                        nilaiSkalaNyeri.value = value;

                        let kesimpulan = '';
                        let alertClass = '';
                        let emoji = '';

                        if (value >= 0 && value <= 3) {
                            kesimpulan = 'Nyeri Ringan';
                            alertClass = 'alert-success';
                            emoji = 'bi-emoji-smile';
                        } else if (value >= 4 && value <= 6) {
                            kesimpulan = 'Nyeri Sedang';
                            alertClass = 'alert-warning';
                            emoji = 'bi-emoji-neutral';
                        } else if (value >= 7 && value <= 10) {
                            kesimpulan = 'Nyeri Berat';
                            alertClass = 'alert-danger';
                            emoji = 'bi-emoji-frown';
                        }

                        // Update both the input and alert
                        kesimpulanNyeri.value = kesimpulan;
                        kesimpulanNyeriAlert.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${emoji} fs-4"></i>
                                <span>${kesimpulan}</span>
                            </div>
                        `;
                        kesimpulanNyeriAlert.className = `alert ${alertClass}`;

                        bootstrap.Modal.getInstance(nrsModal).hide();
                    }
                });
            }

            // Reset form when modal is closed
            if (nrsModal) {
                nrsModal.addEventListener('hidden.bs.modal', function() {
                    if (nrsValue && nrsKesimpulan) {
                        nrsValue.value = '';
                        nrsKesimpulan.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-emoji-smile fs-4"></i>
                                <span>Pilih nilai nyeri terlebih dahulu</span>
                            </div>
                        `;
                        nrsKesimpulan.className = 'alert alert-info';
                    }
                });
            }

            // FLACC Handler
            const updateFLACCTotal = () => {
                const flaccChecks = document.querySelectorAll('.flacc-check:checked');
                const flaccTotal = document.getElementById('flaccTotal');
                const flaccKesimpulan = document.getElementById('flaccKesimpulan');

                let total = 0;
                flaccChecks.forEach(check => {
                    total += parseInt(check.value);
                });

                flaccTotal.value = total;

                let kesimpulan = '';
                let alertClass = '';
                let emoji = '';

                if (total >= 0 && total <= 3) {
                    kesimpulan = 'Nyeri Ringan';
                    alertClass = 'alert-success';
                    emoji = 'bi-emoji-smile';
                } else if (total >= 4 && total <= 6) {
                    kesimpulan = 'Nyeri Sedang';
                    alertClass = 'alert-warning';
                    emoji = 'bi-emoji-neutral';
                } else {
                    kesimpulan = 'Nyeri Berat';
                    alertClass = 'alert-danger';
                    emoji = 'bi-emoji-frown';
                }

                if (flaccKesimpulan) {
                    flaccKesimpulan.textContent = kesimpulan;
                    flaccKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                }
            };

            document.querySelectorAll('.flacc-check').forEach(check => {
                check.addEventListener('change', updateFLACCTotal);
            });

            const simpanFLACC = document.getElementById('simpanFLACC');
            if (simpanFLACC) {
                simpanFLACC.addEventListener('click', function() {
                    const flaccTotal = document.getElementById('flaccTotal');

                    if (nilaiSkalaNyeri && flaccTotal && flaccTotal.value !== '') {
                        let total = parseInt(flaccTotal.value);
                        let kesimpulan = '';
                        let alertClass = '';
                        let emoji = '';

                        if (total >= 0 && total <= 3) {
                            kesimpulan = 'Nyeri Ringan';
                            alertClass = 'alert-success';
                            emoji = 'bi-emoji-smile';
                        } else if (total >= 4 && total <= 6) {
                            kesimpulan = 'Nyeri Sedang';
                            alertClass = 'alert-warning';
                            emoji = 'bi-emoji-neutral';
                        } else {
                            kesimpulan = 'Nyeri Berat';
                            alertClass = 'alert-danger';
                            emoji = 'bi-emoji-frown';
                        }

                        nilaiSkalaNyeri.value = total;
                        kesimpulanNyeri.value = kesimpulan;
                        kesimpulanNyeriAlert.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${emoji} fs-4"></i>
                                <span>${kesimpulan}</span>
                            </div>
                        `;
                        kesimpulanNyeriAlert.className = `alert ${alertClass}`;
                        bootstrap.Modal.getInstance(flaccModal).hide();
                    }
                });
            }

            const modalFLACC = document.getElementById('modalFLACC');
            if (modalFLACC) {
                modalFLACC.addEventListener('shown.bs.modal', function() {
                    document.querySelectorAll('.flacc-check').forEach(check => {
                        check.checked = false; // Pastikan tidak tercentang saat dibuka
                    });
                    const flaccTotal = document.getElementById('flaccTotal');
                    if (flaccTotal) flaccTotal.value = '0';
                    const flaccKesimpulan = document.getElementById('flaccKesimpulan');
                    if (flaccKesimpulan) {
                        flaccKesimpulan.textContent = 'Pilih kategori untuk melihat kesimpulan';
                        flaccKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                    }
                });
            }


            // CRIES Handler
            const updateCRIESTotal = () => {
                const criesChecks = document.querySelectorAll('.cries-check:checked');
                const criesTotal = document.getElementById('criesTotal');
                const criesKesimpulan = document.getElementById('criesKesimpulan');

                let total = 0;
                criesChecks.forEach(check => {
                    total += parseInt(check.value);
                });

                criesTotal.value = total;

                let kesimpulan = '';
                let alertClass = '';
                let emoji = '';

                if (total >= 0 && total <= 3) {
                    kesimpulan = 'Nyeri Ringan';
                    alertClass = 'alert-success';
                    emoji = 'bi-emoji-smile';
                    Serra
                } else if (total >= 4 && total <= 6) {
                    kesimpulan = 'Nyeri Sedang';
                    alertClass = 'alert-warning';
                    emoji = 'bi-emoji-neutral';
                } else {
                    kesimpulan = 'Nyeri Berat';
                    alertClass = 'alert-danger';
                    emoji = 'bi-emoji-frown';
                }

                if (criesKesimpulan) {
                    criesKesimpulan.textContent = kesimpulan;
                    criesKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                }
            };

            document.querySelectorAll('.cries-check').forEach(check => {
                check.addEventListener('change', updateCRIESTotal);
            });

            const simpanCRIES = document.getElementById('simpanCRIES');
            if (simpanCRIES) {
                simpanCRIES.addEventListener('click', function() {
                    const criesTotal = document.getElementById('criesTotal');

                    if (nilaiSkalaNyeri && criesTotal && criesTotal.value !== '') {
                        let total = criesTotal.value ? parseInt(criesTotal.value) : null;
                        let kesimpulan = '';
                        let alertClass = '';
                        let emoji = '';

                        if (total >= 0 && total <= 3) {
                            kesimpulan = 'Ny oNyeri Ringan';
                            alertClass = 'alert-success';
                            emoji = 'bi-emoji-smile';
                        } else if (total >= 4 && total <= 6) {
                            kesimpulan = 'Nyeri Sedang';
                            alertClass = 'alert-warning';
                            emoji = 'bi-emoji-neutral';
                        } else {
                            kesimpulan = 'Nyeri Berat';
                            alertClass = 'alert-danger';
                            emoji = 'bi-emoji-frown';
                        }

                        nilaiSkalaNyeri.value = total;
                        kesimpulanNyeri.value = kesimpulan;
                        kesimpulanNyeriAlert.innerHTML = `
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi ${emoji} fs-4"></i>
                                <span>${kesimpulan}</span>
                            </div>
                        `;
                        kesimpulanNyeriAlert.className = `alert ${alertClass}`;
                        bootstrap.Modal.getInstance(criesModal).hide();
                    }
                });
            }

            const modalCRIES = document.getElementById('modalCRIES');
            if (modalCRIES) {
                modalCRIES.addEventListener('shown.bs.modal', function() {
                    document.querySelectorAll('.cries-check').forEach(check => {
                        check.checked = false; // Pastikan tidak tercentang saat dibuka
                    });
                    const criesTotal = document.getElementById('criesTotal');
                    if (criesTotal) criesTotal.value = '0';
                    const criesKesimpulan = document.getElementById('criesKesimpulan');
                    if (criesKesimpulan) {
                        criesKesimpulan.textContent = 'Pilih semua kategori untuk melihat kesimpulan';
                        criesKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                    }
                });
            }

            //====================================================================================//
            // Event handler untuk Risiko Jatuh
            //====================================================================================//
            const forms = {
                umum: {
                    threshold: 1,
                    type: 'boolean'
                },
                morse: {
                    low: 0,
                    medium: 25,
                    high: 45,
                    type: 'score'
                },
                ontario: {
                    low: 0,
                    medium: 4,
                    high: 9,
                    type: 'score'
                },
                humpty: {
                    low: 0,
                    high: 12,
                    type: 'score'
                }
            };

            const risikoJatuhSkala = document.getElementById('risikoJatuhSkala');
            if (risikoJatuhSkala) {
                risikoJatuhSkala.addEventListener('change', function() {
                    showForm(this.value);
                });
                // Hide all forms initially
                showForm('');
            }

            //====================================================================================//
            // Fungsi untuk menampilkan form status Gizi
            //====================================================================================//
            const nutritionSelect = document.getElementById('nutritionAssessment');
            const allForms = document.querySelectorAll('.assessment-form');

            if (nutritionSelect) {
                const initialValue = nutritionSelect.value;
                if (initialValue) {
                    // Tampilkan form yang sesuai dengan nilai yang sudah dipilih
                    showSelectedNutritionForm();
                }
            }

            // Tampilkan form yang dipilih saat halaman dimuat
            function showSelectedNutritionForm() {
                const selectedValue = nutritionSelect.value;

                // Sembunyikan semua form
                allForms.forEach(form => {
                    form.style.display = 'none';
                });

                if (selectedValue === '5') {
                    return;
                }

                // Mapping ID form sesuai value
                const formMapping = {
                    '1': 'mst',
                    '2': 'mna',
                    '3': 'strong-kids',
                    '4': 'nrs'
                };

                // Tampilkan form yang dipilih
                const formId = formMapping[selectedValue];
                if (formId) {
                    const selectedForm = document.getElementById(formId);
                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                        initializeFormListeners(formId);
                    }
                }
            }

            nutritionSelect.addEventListener('change', showSelectedNutritionForm);

            //====================================================================================//
            // Fungsi untuk menampilkan form Skala Fungsional ADL
            //====================================================================================//
            // Event handler untuk Status Fungsional
            const statusFungsionalSelect = document.getElementById('skala_fungsional');
            const adlTotal = document.getElementById('adl_total');
            const adlKesimpulanAlert = document.getElementById('adl_kesimpulan');

            if (statusFungsionalSelect) {
                statusFungsionalSelect.addEventListener('change', function() {
                    if (this.value === 'Pengkajian Aktivitas') {
                        // Reset nilai sebelum menampilkan modal
                        adlTotal.value = '';
                        adlKesimpulanAlert.className = 'alert alert-info';
                        adlKesimpulanAlert.textContent = 'Pilih skala aktivitas harian terlebih dahulu';

                        const modal = new bootstrap.Modal(document.getElementById('modalADL'));
                        modal.show();
                    } else if (this.value === 'Lainnya') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Skala pengukuran lainnya belum tersedia',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok'
                        }).then((result) => {
                            // Reset pilihan setelah menampilkan alert
                            this.value = '';
                            adlTotal.value = '';
                            adlKesimpulanAlert.className = 'alert alert-info';
                            adlKesimpulanAlert.textContent =
                                'Pilih skala aktivitas harian terlebih dahulu';
                        });
                    }
                });
            }

            // ADL Handler - Perhitungan total dan kesimpulan
            const updateADLTotal = () => {
                const adlChecks = document.querySelectorAll('.adl-check:checked');
                const adlModalTotal = document.getElementById('adlTotal');
                const adlModalKesimpulan = document.getElementById('adlKesimpulan');

                let total = 0;
                adlChecks.forEach(check => {
                    total += parseInt(check.value);
                });

                // Update total di modal
                if (adlModalTotal) {
                    adlModalTotal.value = total;
                }

                // Hitung jumlah kategori yang sudah dipilih
                const checkedCategories = new Set(Array.from(adlChecks).map(check => check.getAttribute(
                    'data-category')));
                const allCategoriesSelected = checkedCategories.size ===
                    3; // 3 kategori: makan, berjalan, mandi

                if (!allCategoriesSelected) {
                    if (adlModalKesimpulan) {
                        adlModalKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                        adlModalKesimpulan.textContent = 'Pilih semua kategori terlebih dahulu';
                    }
                    return;
                }

                // Update kesimpulan berdasarkan total skor
                let kesimpulan = '';
                let alertClass = '';

                if (total <= 4) {
                    kesimpulan = 'Mandiri';
                    alertClass = 'alert-success';
                } else if (total <= 8) {
                    kesimpulan = 'Ketergantungan Ringan';
                    alertClass = 'alert-info';
                } else if (total <= 11) {
                    kesimpulan = 'Ketergantungan Sedang';
                    alertClass = 'alert-warning';
                } else {
                    kesimpulan = 'Ketergantungan Berat';
                    alertClass = 'alert-danger';
                }

                // Update kesimpulan di modal
                if (adlModalKesimpulan) {
                    adlModalKesimpulan.className = `alert ${alertClass} py-1 px-3 mb-0`;
                    adlModalKesimpulan.textContent = kesimpulan;
                }
            };

            // Event listeners untuk ADL checkboxes
            document.querySelectorAll('.adl-check').forEach(check => {
                check.addEventListener('change', updateADLTotal);
            });

            // Handle ADL save button
            const simpanADL = document.getElementById('simpanADL');
            if (simpanADL) {
                simpanADL.addEventListener('click', function() {
                    const adlModalTotal = document.getElementById('adlTotal');
                    const adlModalKesimpulan = document.getElementById('adlKesimpulan');

                    if (adlModalTotal && adlModalTotal.value !== '' && adlKesimpulanAlert) {
                        // Update nilai total
                        adlTotal.value = adlModalTotal.value;

                        // Update kesimpulan di form utama
                        adlKesimpulanAlert.className = adlModalKesimpulan.className.replace(
                            'py-1 px-3 mb-0', '');
                        adlKesimpulanAlert.textContent = adlModalKesimpulan.textContent;

                        // Tutup modal
                        bootstrap.Modal.getInstance(document.getElementById('modalADL')).hide();
                    }
                });
            }

            //Get Value
            const getSelectedADLValues = () => {
                const makanValue = document.querySelector('input[name="makan"]:checked')?.value || '';
                const berjalanValue = document.querySelector('input[name="berjalan"]:checked')?.value || '';
                const mandiValue = document.querySelector('input[name="mandi"]:checked')?.value || '';

                // Map nilai menjadi teks
                const getTextValue = (value) => {
                    switch (value) {
                        case '1':
                            return 'Mandiri';
                        case '2':
                            return '25% Dibantu';
                        case '3':
                            return '50% Dibantu';
                        case '4':
                            return '75% Dibantu';
                        default:
                            return '';
                    }
                };

                return {
                    makan: getTextValue(makanValue),
                    makanValue: makanValue,
                    berjalan: getTextValue(berjalanValue),
                    berjalanValue: berjalanValue,
                    mandi: getTextValue(mandiValue),
                    mandiValue: mandiValue
                };
            };

            // Reset form ADL when modal is closed
            const modalADL = document.getElementById('modalADL');
            if (simpanADL) {
                simpanADL.addEventListener('click', function() {
                    const adlModalTotal = document.getElementById('adlTotal');
                    const adlModalKesimpulan = document.getElementById('adlKesimpulan');

                    if (adlModalTotal && adlModalTotal.value !== '' && adlKesimpulanAlert) {
                        // Update nilai total
                        adlTotal.value = adlModalTotal.value;

                        // Update kesimpulan di form utama
                        adlKesimpulanAlert.className = adlModalKesimpulan.className.replace(
                            'py-1 px-3 mb-0', '');
                        adlKesimpulanAlert.textContent = adlModalKesimpulan.textContent;

                        // Simpan nilai-nilai tersembunyi
                        const adlValues = getSelectedADLValues();
                        document.getElementById('adl_makan').value = adlValues.makan;
                        document.getElementById('adl_makan_value').value = adlValues.makanValue;
                        document.getElementById('adl_berjalan').value = adlValues.berjalan;
                        document.getElementById('adl_berjalan_value').value = adlValues.berjalanValue;
                        document.getElementById('adl_mandi').value = adlValues.mandi;
                        document.getElementById('adl_mandi_value').value = adlValues.mandiValue;
                        document.getElementById('adl_kesimpulan_value').value = adlModalKesimpulan
                            .textContent;
                        document.getElementById('adl_jenis_skala').value = '1'; // 1 untuk ADL

                        // Tutup modal
                        bootstrap.Modal.getInstance(document.getElementById('modalADL')).hide();
                    }
                });
            }

            //====================================================================================//
            // Fungsi untuk DISCHARGE PLANNING
            //====================================================================================//
            const dischargePlanningSection = document.getElementById('discharge-planning');
            const allSelects = dischargePlanningSection.querySelectorAll('select');
            const alertWarning = dischargePlanningSection.querySelector('.alert-warning');
            const alertSuccess = dischargePlanningSection.querySelector('.alert-success');
            const alertInfo = dischargePlanningSection.querySelector('.alert-info');

            function updateDischargePlanningConclusion() {
                let needsSpecialPlan = false;
                let allSelected = true;
                const kesimpulanInput = document.getElementById('kesimpulan');

                // Cek semua select
                allSelects.forEach(select => {
                    if (!select.value) {
                        allSelected = false;
                    } else if (select.value === 'ya') {
                        needsSpecialPlan = true;
                    }
                });

                if (!allSelected) {
                    alertInfo.style.display = 'block';
                    alertWarning.style.display = 'none';
                    alertSuccess.style.display = 'none';
                    kesimpulanInput.value = 'Pilih semua Planning';
                    return;
                }

                if (needsSpecialPlan) {
                    alertWarning.style.display = 'block';
                    alertSuccess.style.display = 'none';
                    alertInfo.style.display = 'none';
                    kesimpulanInput.value = 'Mebutuhkan rencana pulang khusus';
                } else {
                    alertWarning.style.display = 'none';
                    alertSuccess.style.display = 'block';
                    alertInfo.style.display = 'none';
                    kesimpulanInput.value = 'Tidak mebutuhkan rencana pulang khusus';
                }
            }

            // Tambahkan event listener untuk setiap select
            allSelects.forEach(select => {
                select.addEventListener('change', updateDischargePlanningConclusion);
            });

            // Inisialisasi awal
            updateDischargePlanningConclusion();


            //====================================================================================//
            // Fungsi untuk menampilkan form skala decubitus
            //====================================================================================//
            const formNorton = document.getElementById('formNorton');
            if (formNorton) {
                formNorton.querySelectorAll('select').forEach(select => {
                    select.addEventListener('change', () => updateDecubitusConclusion('norton'));
                });
            }
            const formBraden = document.getElementById('formBraden');
            if (formBraden) {
                formBraden.querySelectorAll('select').forEach(select => {
                    select.addEventListener('change', () => updateDecubitusConclusion('braden'));
                });
            }

            const skalaDecubitusSelect = document.getElementById('skalaRisikoDekubitus');
            if (skalaDecubitusSelect && skalaDecubitusSelect.value) {
                showDecubitusForm(skalaDecubitusSelect.value);
            }


            //====================================================================================//
            // Fungsi untuk DIAGNOSIS BANDING
            //====================================================================================//
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
                inputField.addEventListener('input', function() {
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
                addButton.addEventListener('click', function() {
                    const diagnosisText = inputField.value.trim();
                    if (diagnosisText) {
                        addDiagnosis(diagnosisText);
                    }
                });

                // Add diagnosis when Enter key is pressed
                inputField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const diagnosisText = this.value.trim();
                        if (diagnosisText) {
                            addDiagnosis(diagnosisText);
                        }
                    }
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
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
                        deleteButton.addEventListener('click', function() {
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

            //====================================================================================//
        });


        //====================================================================================//
        // Fungsi untuk menampilkan form risiko jatuh
        //====================================================================================//
        function showForm(formType) {
            // Sembunyikan semua form terlebih dahulu
            document.querySelectorAll('.risk-form').forEach(form => {
                form.style.display = 'none';
            });

            // Handle untuk opsi "Lainnya"
            if (formType === '5') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pasien tidak dapat dinilai status resiko jatuh',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Ok',
                    showCancelButton: false,
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        popup: 'animated fadeInDown faster'
                    },
                    backdrop: `
                        rgba(244, 244, 244, 0.7)
                    `
                });
                document.getElementById('skala_lainnya').value = 'resiko jatuh lainnya';
                return;
            }

            // Mapping nilai select ke id form
            const formMapping = {
                '1': 'skala_umumForm',
                '2': 'skala_morseForm',
                '3': 'skala_humptyForm',
                '4': 'skala_ontarioForm'
            };

            // Tampilkan form yang dipilih
            if (formType && formMapping[formType]) {
                const selectedForm = document.getElementById(formMapping[formType]);
                if (selectedForm) {
                    selectedForm.style.display = 'block';
                    resetForm(selectedForm);
                }
            }
        }

        function resetForm(form) {
            form.querySelectorAll('select').forEach(select => select.value = '');
            const formType = form.id.replace('skala_', '').replace('Form', '');
            const conclusionDiv = form.querySelector('.conclusion');
            const defaultConclusion = formType === 'umum' ? 'Tidak berisiko jatuh' : 'Risiko Rendah';

            // Reset kesimpulan ke default
            if (conclusionDiv) {
                conclusionDiv.className = 'conclusion bg-success';
                conclusionDiv.querySelector('p span').textContent = defaultConclusion;

                // Reset hidden input value
                const hiddenInput = conclusionDiv.querySelector('input[type="hidden"]');
                if (hiddenInput) {
                    hiddenInput.value = defaultConclusion;
                }
            }
        }

        function updateConclusion(formType) {
            const form = document.getElementById('skala_' + formType + 'Form');
            const selects = form.querySelectorAll('select');
            let score = 0;
            let hasYes = false;

            // Hitung skor
            selects.forEach(select => {
                if (select.value === '1') {
                    hasYes = true;
                }
                score += parseInt(select.value) || 0;
            });

            // Dapatkan div kesimpulan dari form yang aktif
            const conclusionDiv = form.querySelector('.conclusion');
            const conclusionSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
            const conclusionInput = conclusionDiv.querySelector('input[type="hidden"]');
            let conclusion = '';
            let bgClass = '';

            // Tentukan kesimpulan berdasarkan tipe form
            switch (formType) {
                case 'umum':
                    if (hasYes) {
                        conclusion = 'Berisiko jatuh';
                        bgClass = 'bg-danger';
                    } else {
                        conclusion = 'Tidak berisiko jatuh';
                        bgClass = 'bg-success';
                    }
                    // Update hidden input untuk form umum
                    if (conclusionInput) {
                        conclusionInput.value = conclusion;
                    }
                    break;

                case 'morse':
                    if (score >= 45) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else if (score >= 25) {
                        conclusion = 'Risiko Sedang';
                        bgClass = 'bg-warning';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    conclusion += ' (Skor: ' + score + ')';
                    // Update hidden input untuk form morse
                    document.getElementById('risiko_jatuh_morse_kesimpulan').value = conclusion;
                    break;

                case 'humpty':
                    if (score >= 12) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    conclusion += ' (Skor: ' + score + ')';
                    document.getElementById('risiko_jatuh_pediatrik_kesimpulan').value = conclusion;
                    break;

                case 'ontario':
                    if (score >= 9) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else if (score >= 4) {
                        conclusion = 'Risiko Sedang';
                        bgClass = 'bg-warning';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    conclusion += ' (Skor: ' + score + ')';
                    document.getElementById('risiko_jatuh_lansia_kesimpulan').value = conclusion;
                    break;
            }

            // Update tampilan kesimpulan
            if (conclusionDiv) {
                conclusionDiv.className = 'conclusion ' + bgClass;
                conclusionSpan.textContent = conclusion;
            }
        }


        //========================================================================//
        // Event Listener untuk form status gizi
        //=======================================================================//

        function initializeFormListeners(formId) {
            const form = document.getElementById(formId);
            const selects = form.querySelectorAll('select');

            switch (formId) {
                case 'mst':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateMSTScore(form));
                    });
                    calculateMSTScore(form);
                    break;
                case 'mna':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateMNAScore(form));
                    });
                    initializeBMICalculation();
                    calculateMNAScore(form);
                    break;
                case 'strong-kids':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateStrongKidsScore(form));
                    });
                    calculateStrongKidsScore(form);
                    break;
                case 'nrs':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateNRSScore(form));
                    });
                    calculateNRSScore(form);
                    break;
            }
        }

        // Fungsi perhitungan MST
        function calculateMSTScore(form) {
            // Periksa jika form ada
            if (!form) return;

            const selects = form.querySelectorAll('select');
            let total = 0;
            let allSelected = true;

            // Hitung total skor
            selects.forEach(select => {
                if (select.value === '') {
                    allSelected = false;
                } else {
                    total += parseInt(select.value || 0);
                }
            });

            // Jika tidak semua field dipilih, jangan update kesimpulan
            if (!allSelected) return;

            const kesimpulan = total <= 1 ? 'Tidak berisiko malnutrisi' : 'Berisiko malnutrisi';
            document.getElementById('gizi_mst_kesimpulan').value = kesimpulan;

            const conclusions = form.querySelectorAll('.risk-indicators .alert');
            conclusions.forEach(alert => {
                if ((total <= 1 && alert.classList.contains('alert-success')) ||
                    (total >= 2 && alert.classList.contains('alert-warning'))) {
                    alert.style.display = 'block';
                } else {
                    alert.style.display = 'none';
                }
            });
        }

        // Fungsi perhitungan BMI
        function initializeBMICalculation() {
            const weightInput = document.getElementById('mnaWeight');
            const heightInput = document.getElementById('mnaHeight');
            const bmiInput = document.getElementById('mnaBMI');

            function calculateBMI() {
                const weight = parseFloat(weightInput.value || 0);
                const height = parseFloat(heightInput.value || 0);

                if (weight > 0 && height > 0) {
                    const heightInMeters = height / 100;
                    const bmi = weight / (heightInMeters * heightInMeters);
                    bmiInput.value = bmi.toFixed(2);
                }
            }

            if (weightInput && heightInput) {
                weightInput.addEventListener('input', calculateBMI);
                heightInput.addEventListener('input', calculateBMI);
            }
        }

        // Fungsi perhitungan MNA
        function calculateMNAScore(form) {
            const selects = form.querySelectorAll('select[name^="gizi_mna_"]');
            let total = 0;

            // Hitung total skor
            selects.forEach(select => {
                const value = parseInt(select.value || 0);
                total += value;
            });

            // Set kesimpulan berdasarkan total skor
            const kesimpulan = total >= 12 ? '≥ 12 Tidak Beresiko' : '≤ 11 Beresiko malnutrisi';

            // Update hidden input untuk kesimpulan
            const kesimpulanInput = document.getElementById('gizi_mna_kesimpulan');
            if (kesimpulanInput) {
                kesimpulanInput.value = kesimpulan;
            }

            // Update UI untuk menampilkan kesimpulan
            const conclusionDiv = document.getElementById('mnaConclusion');
            if (conclusionDiv) {
                const alertClass = total >= 12 ? 'alert-success' : 'alert-warning';
                conclusionDiv.innerHTML = `
                <div class="alert ${alertClass}">
                    Kesimpulan: ${kesimpulan} (Total Score: ${total})
                </div>
                <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan" value="${kesimpulan}">
                `;
            }
        }

        // Fungsi perhitungan Strong Kids
        function calculateStrongKidsScore(form) {
            const selects = form.querySelectorAll('select');
            let total = 0;

            // Hitung total score
            selects.forEach(select => {
                total += parseInt(select.value || 0);
            });

            // Tentukan kesimpulan dan type alert
            let kesimpulan, type, kesimpulanText;
            if (total === 0) {
                kesimpulan = 'Beresiko rendah';
                kesimpulanText = '0 (Beresiko rendah)';
                type = 'success';
            } else if (total >= 1 && total <= 3) {
                kesimpulan = 'Beresiko sedang';
                kesimpulanText = '1-3 (Beresiko sedang)';
                type = 'warning';
            } else {
                kesimpulan = 'Beresiko Tinggi';
                kesimpulanText = '4-5 (Beresiko Tinggi)';
                type = 'danger';
            }

            // Update hidden input untuk kesimpulan
            const kesimpulanInput = document.getElementById('gizi_strong_kesimpulan');
            if (kesimpulanInput) {
                kesimpulanInput.value = kesimpulanText;
            }

            // Update UI untuk menampilkan kesimpulan
            const conclusionDiv = document.getElementById('strongKidsConclusion');
            if (conclusionDiv) {
                conclusionDiv.innerHTML = `
                <div class="alert alert-${type}">
                    Kesimpulan: ${kesimpulanText} (Total Score: ${total})
                </div>
                <input type="hidden" name="gizi_strong_kesimpulan" id="gizi_strong_kesimpulan" value="${kesimpulanText}">
                `;
            }

            // Update tampilan form conclusion
            updateFormConclusion(form, kesimpulan, type);
        }

        // Fungsi perhitungan NRS
        function calculateNRSScore(form) {
            const selects = form.querySelectorAll('select');
            let total = 0;

            // Hitung total score
            selects.forEach(select => {
                total += parseInt(select.value || 0);
            });

            // Tentukan kesimpulan dan type alert
            let kesimpulan, type, kesimpulanText;
            if (total <= 5) {
                kesimpulan = 'Beresiko rendah';
                kesimpulanText = '≤ 5 (Beresiko rendah)';
                type = 'success';
            } else if (total <= 10) {
                kesimpulan = 'Beresiko sedang';
                kesimpulanText = '6-10 (Beresiko sedang)';
                type = 'warning';
            } else {
                kesimpulan = 'Beresiko Tinggi';
                kesimpulanText = '> 10 (Beresiko Tinggi)';
                type = 'danger';
            }

            // Update hidden input untuk kesimpulan
            const kesimpulanInput = document.getElementById('gizi_nrs_kesimpulan');
            if (kesimpulanInput) {
                kesimpulanInput.value = kesimpulanText;
            }

            // Update UI untuk menampilkan kesimpulan
            const conclusionDiv = document.getElementById('nrsConclusion');
            if (conclusionDiv) {
                conclusionDiv.innerHTML = `
                <div class="alert alert-${type}">
                    Kesimpulan: ${kesimpulanText} (Total Score: ${total})
                </div>
                <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan" value="${kesimpulanText}">
                `;
            }

            // Update tampilan form conclusion
            updateFormConclusion(form, kesimpulan, type);
        }

        // Fungsi untuk update tampilan kesimpulan
        function updateFormConclusion(form, text, type) {
            const conclusions = form.querySelectorAll('.alert');
            conclusions.forEach(alert => {
                if (alert.classList.contains(`alert-${type}`)) {
                    alert.style.display = 'block';
                } else {
                    alert.style.display = 'none';
                }
            });

            // Update hidden input if exists
            const hiddenInput = form.querySelector('input[type="hidden"]');
            if (hiddenInput) {
                hiddenInput.value = text;
            }
        }

        //========================================================================//
        // Fungsi untuk Implementasi
        //========================================================================//
        document.addEventListener('DOMContentLoaded', function() {
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
                inputField.addEventListener('input', function() {
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
                addButton.addEventListener('click', function() {
                    const itemText = inputField.value.trim();
                    if (itemText) {
                        addItem(itemText);
                    }
                });

                // Add item when Enter
                inputField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const itemText = this.value.trim();
                        if (itemText) {
                            addItem(itemText);
                        }
                    }
                });

                // Close
                document.addEventListener('click', function(e) {
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
                        toast.addEventListener('hidden.bs.toast', function() {
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
                            'list-group-item d-flex justify-content-between align-items-center border-0 ps-0 bg-light';

                        const itemSpan = document.createElement('span');
                        itemSpan.textContent = `${index + 1}. ${item}`;

                        const deleteButton = document.createElement('button');
                        deleteButton.className = 'btn btn-link text-danger p-0';
                        deleteButton.type = 'button';
                        deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                        deleteButton.addEventListener('click', function() {
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



        //====================================================================================//
        // Fungsi untuk menampilkan form skala decubitus
        //====================================================================================//
        const decubitusScores = {
            norton: {
                low: 15, // > 15 risiko rendah
                medium: 13, // 13-14 risiko sedang
                high: 12 // < 12 risiko tinggi
            },
            braden: {
                high: 12, // ≤ 12 risiko tinggi
                medium: 16, // 13-16 risiko sedang
                low: 17 // ≥ 17 risiko rendah
            }
        };

        // Fungsi untuk menampilkan form decubitus yang dipilih
        function showDecubitusForm(formType) {
            document.querySelectorAll('.decubitus-form').forEach(form => {
                form.style.display = 'none';
            });

            let formElement = null;
            if (formType === 'norton') {
                formElement = document.getElementById('formNorton');
            } else if (formType === 'braden') {
                formElement = document.getElementById('formBraden');
            }

            // Tampilkan form yang dipilih
            if (formElement) {
                formElement.style.display = 'block';

                // Cek apakah form sudah memiliki nilai
                const hasValues = Array.from(formElement.querySelectorAll('select')).some(select => select.value);

                // Hanya reset jika tidak ada nilai
                if (!hasValues) {
                    resetDecubitusForm(formElement);
                } else {
                    // Jika sudah ada nilai, update kesimpulan
                    updateDecubitusConclusion(formType);
                }
            }
        }


        // Reset form saat berganti
        function resetDecubitusForm(form) {
            if (!form) return;

            form.querySelectorAll('select').forEach(select => select.value = '');
            const kesimpulanDiv = form.querySelector('#kesimpulanNorton');
            if (kesimpulanDiv) {
                kesimpulanDiv.className = 'alert alert-success mb-0 flex-grow-1';
                kesimpulanDiv.textContent = 'Risiko Rendah';
            }
        }

        // Update kesimpulan berdasarkan pilihan
        function updateDecubitusConclusion(formType) {
            const form = document.getElementById('form' + formType.charAt(0).toUpperCase() + formType.slice(1));
            if (!form) return;

            const kesimpulanDiv = form.querySelector('#kesimpulanNorton');
            if (!kesimpulanDiv) return;

            if (formType === 'norton') {
                let total = 0;
                let allFilled = true;
                const fields = ['kondisi_fisik', 'kondisi_mental', 'norton_aktivitas', 'norton_mobilitas', 'inkontinensia'];

                fields.forEach(field => {
                    const select = form.querySelector(`select[name="${field}"]`);
                    if (!select || !select.value) {
                        allFilled = false;
                        return;
                    }
                    total += parseInt(select.value);
                });

                // Debug untuk melihat nilai
                console.log('Total Score:', total);
                console.log('All Fields Filled:', allFilled);

                if (!allFilled) {
                    kesimpulanDiv.className = 'alert alert-info mb-0 flex-grow-1';
                    kesimpulanDiv.textContent = 'Pilih semua kriteria untuk melihat kesimpulan';
                    return;
                }

                let conclusion = '';
                let alertClass = '';

                // Cek total skor dan tentukan kesimpulan
                if (total <= decubitusScores.norton.high) {
                    conclusion = 'Risiko Tinggi';
                    alertClass = 'alert-danger';
                } else if (total <= decubitusScores.norton.medium) {
                    conclusion = 'Risiko Sedang';
                    alertClass = 'alert-warning';
                } else {
                    conclusion = 'Risiko Rendah';
                    alertClass = 'alert-success';
                }

                conclusion += ` (Skor: ${total})`;
                kesimpulanDiv.className = `alert ${alertClass} mb-0 flex-grow-1`;
                kesimpulanDiv.textContent = conclusion;
            } else if (formType === 'braden') {
                let total = 0;
                let allFilled = true;
                const fields = ['persepsi_sensori', 'kelembapan', 'braden_aktivitas', 'braden_mobilitas', 'nutrisi',
                    'pergesekan'
                ];

                fields.forEach(field => {
                    const select = form.querySelector(`select[name="${field}"]`);
                    if (!select || !select.value) {
                        allFilled = false;
                        return;
                    }
                    total += parseInt(select.value);
                });

                // Debug untuk melihat nilai
                console.log('Total Braden Score:', total);
                console.log('All Braden Fields Filled:', allFilled);

                if (!allFilled) {
                    kesimpulanDiv.className = 'alert alert-info mb-0 flex-grow-1';
                    kesimpulanDiv.textContent = 'Pilih semua kriteria untuk melihat kesimpulan';
                    return;
                }

                let conclusion = '';
                let alertClass = '';

                // Cek total skor dan tentukan kesimpulan
                if (total <= 12) {
                    conclusion = 'Risiko Tinggi';
                    alertClass = 'alert-danger';
                } else if (total <= 16) {
                    conclusion = 'Risiko Sedang';
                    alertClass = 'alert-warning';
                } else {
                    conclusion = 'Risiko Rendah';
                    alertClass = 'alert-success';
                }

                conclusion += ` (Skor: ${total})`;
                kesimpulanDiv.className = `alert ${alertClass} mb-0 flex-grow-1`;
                kesimpulanDiv.textContent = conclusion;
            }
        }

        //====================================================================================//
    </script>
@endpush
