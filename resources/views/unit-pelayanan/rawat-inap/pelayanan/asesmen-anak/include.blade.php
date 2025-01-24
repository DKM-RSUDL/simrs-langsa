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

            //Fngsi Hitung IMT dan LPT
            function hitungIMT_LPT() {
                let tinggi = parseFloat(document.getElementById("tinggi_badan").value) / 100; // Konversi ke meter
                let berat = parseFloat(document.getElementById("berat_badan").value);

                if (!isNaN(tinggi) && !isNaN(berat) && tinggi > 0) {
                    let imt = berat / (tinggi * tinggi);
                    let lpt = (tinggi * 100 * berat) / 3600; // Tinggi dikonversi ke cm
                    
                    document.getElementById("imt").value = imt.toFixed(2); // Menampilkan 2 desimal
                    document.getElementById("lpt").value = lpt.toFixed(2);
                } else {
                    document.getElementById("imt").value = "";
                    document.getElementById("lpt").value = "";
                }
            }

            document.getElementById("tinggi_badan").addEventListener("input", hitungIMT_LPT);
            document.getElementById("berat_badan").addEventListener("input", hitungIMT_LPT);

            //------------------------------------------------------------//
            // Event handler untuk tombol tambah keterangan di pemeriksaan fisik //
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

            // Event handler untuk checkbox normal
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

            // Inisialisasi semua checkbox sebagai checked dan sembunyikan keterangan
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                const pemeriksaanItem = checkbox.closest('.pemeriksaan-item');
                if (pemeriksaanItem) {
                    checkbox.checked = true;
                    const keteranganDiv = pemeriksaanItem.querySelector('.keterangan');
                    if (keteranganDiv) {
                        keteranganDiv.style.display = 'none';
                        const input = keteranganDiv.querySelector('input');
                        if (input) input.value = '';
                    }
                }
            });
            //------------------------------------------------------------//

            //------------------------------------------------------------//

            // Event handler waktu default sesuai sekarang
            const currentDate = new Date();
    
            // Format date as YYYY-MM-DD
            const formattedDate = currentDate.toISOString().split('T')[0];
            document.getElementById('tanggal_masuk').value = formattedDate;
            
            const hours = String(currentDate.getHours()).padStart(2, '0');
            const minutes = String(currentDate.getMinutes()).padStart(2, '0');
            document.getElementById('jam_masuk').value = `${hours}:${minutes}`;

            //------------------------------------------------------------//
            //------------------------------------------------------------//
            //JENIS SKALA//

            const skalaSelect = document.getElementById('jenis_skala_nyeri');
            const nrsModal = document.getElementById('modalNRS');
            const flaccModal = document.getElementById('modalFLACC');
            const criesModal = document.getElementById('modalCRIES');
            const nrsValue = document.getElementById('nrs_value');
            const nrsKesimpulan = document.getElementById('nrs_kesimpulan');
            const simpanNRS = document.getElementById('simpanNRS');
            const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
            const kesimpulanNyeriAlert = document.querySelector('#status-nyeri .alert');

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
                    const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
                    const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');
                    if (nilaiSkalaNyeri && nrsValue && kesimpulanNyeriAlert) {
                        nilaiSkalaNyeri.value = nrsValue.value;
                        kesimpulanNyeriAlert.innerHTML = nrsKesimpulan.innerHTML;
                        kesimpulanNyeriAlert.className = nrsKesimpulan.className;
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
                const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
                const kesimpulanNyeriAlert = document.querySelector('#status-nyeri .alert');
                
                let total = 0;
                flaccChecks.forEach(check => {
                    total += parseInt(check.value);
                });
                
                flaccTotal.value = total;
                nilaiSkalaNyeri.value = total;

                // Update kesimpulan
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

                // Update kesimpulan di modal FLACC
                if (flaccKesimpulan) {
                    flaccKesimpulan.textContent = kesimpulan.toUpperCase(); // FLACC tetap pakai uppercase
                    flaccKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                }

                // Update kesimpulan di form utama dengan format yang sama seperti NRS
                if (kesimpulanNyeriAlert) {
                    kesimpulanNyeriAlert.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${emoji} fs-4"></i>
                            <span>${kesimpulan}</span>
                        </div>
                    `;
                    kesimpulanNyeriAlert.className = `alert ${alertClass}`;
                }
            };

            // Add event listeners to FLACC checkboxes
            document.querySelectorAll('.flacc-check').forEach(check => {
                check.addEventListener('change', updateFLACCTotal);
            });

            // Handle FLACC save button
            const simpanFLACC = document.getElementById('simpanFLACC');
            if (simpanFLACC) {
                simpanFLACC.addEventListener('click', function() {
                    const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
                    const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');
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

                        // Update nilai
                        nilaiSkalaNyeri.value = total;

                        // Update kesimpulan
                        if (kesimpulanNyeriAlert) {
                            kesimpulanNyeriAlert.innerHTML = `
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi ${emoji} fs-4"></i>
                                    <span>${kesimpulan}</span>
                                </div>
                            `;
                            kesimpulanNyeriAlert.className = `alert ${alertClass}`;
                        }

                        // Tutup modal
                        bootstrap.Modal.getInstance(document.getElementById('modalFLACC')).hide();
                    }
                });
            }

            // Reset FLACC form when modal is closed
            const modalFLACC = document.getElementById('modalFLACC');
            if (modalFLACC) {
                modalFLACC.addEventListener('hidden.bs.modal', function() {
                    document.querySelectorAll('.flacc-check').forEach(check => {
                        check.checked = false;
                    });
                    const flaccTotal = document.getElementById('flaccTotal');
                    if (flaccTotal) {
                        flaccTotal.value = '';
                    }
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
                const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
                const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');
                
                let total = 0;
                criesChecks.forEach(check => {
                    total += parseInt(check.value);
                });
                
                criesTotal.value = total;
                nilaiSkalaNyeri.value = total;

                // Update kesimpulan
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

                // Update kesimpulan di modal CRIES
                if (criesKesimpulan) {
                    criesKesimpulan.textContent = kesimpulan.toUpperCase();
                    criesKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
                }
            };

            // Add event listeners to CRIES checkboxes
            document.querySelectorAll('.cries-check').forEach(check => {
                check.addEventListener('change', updateCRIESTotal);
            });

            // Handle CRIES save button
            const simpanCRIES = document.getElementById('simpanCRIES');
            if (simpanCRIES) {
                simpanCRIES.addEventListener('click', function() {
                    const nilaiSkalaNyeri = document.getElementById('nilai_skala_nyeri');
                    const kesimpulanNyeriAlert = document.getElementById('kesimpulan_nyeri_alert');
                    const criesTotal = document.getElementById('criesTotal');
                    
                    if (nilaiSkalaNyeri && criesTotal && criesTotal.value !== '') {
                        let total = parseInt(criesTotal.value);
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

                        // Update nilai
                        nilaiSkalaNyeri.value = total;

                        // Update kesimpulan
                        if (kesimpulanNyeriAlert) {
                            kesimpulanNyeriAlert.innerHTML = `
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi ${emoji} fs-4"></i>
                                    <span>${kesimpulan}</span>
                                </div>
                            `;
                            kesimpulanNyeriAlert.className = `alert ${alertClass}`;
                        }

                        // Tutup modal
                        const modalCRIES = document.getElementById('modalCRIES');
                        if (modalCRIES) {
                            const modalInstance = bootstrap.Modal.getInstance(modalCRIES);
                            if (modalInstance) {
                                modalInstance.hide();
                            }
                        }
                    }
                });
            }

            // Reset CRIES form when modal is closed
            const modalCRIES = document.getElementById('modalCRIES');
            if (modalCRIES) {
                modalCRIES.addEventListener('hidden.bs.modal', function() {
                    document.querySelectorAll('.cries-check').forEach(check => {
                        check.checked = false;
                    });
                    const criesTotal = document.getElementById('criesTotal');
                    if (criesTotal) {
                        criesTotal.value = '';
                    }
                    const criesKesimpulan = document.getElementById('criesKesimpulan');
                    if (criesKesimpulan) {
                        criesKesimpulan.textContent = 'Pilih semua kategori untuk melihat kesimpulan';
                        criesKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                    }
                });
            }

            //------------------------------------------------------------//
            //------------------------------------------------------------//
            // Event handler untuk Modal penyakit di derita


            //------------------------------------------------------------//
            //------------------------------------------------------------//
            // Event handler untuk skala risiko jatuh
             // Fungsi untuk menampilkan form risiko jatuh
            function showForm(selectedValue) {
                // Sembunyikan semua form terlebih dahulu
                document.querySelectorAll('.risk-form').forEach(form => {
                    form.style.display = 'none';
                });

                // Tampilkan form yang dipilih
                if (selectedValue) {
                    const selectedForm = document.getElementById(selectedValue + 'Form');
                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                    }
                }
            }

            // Event listener untuk perubahan select skala
            const risikoJatuhSelect = document.getElementById('risikoJatuhSkala');
            if (risikoJatuhSelect) {
                risikoJatuhSelect.addEventListener('change', function() {
                    showForm(this.value);
                });

                // Sembunyikan semua form saat halaman dimuat
                showForm('');
            }

            // Fungsi untuk update kesimpulan berdasarkan jenis skala
            function updateConclusion(type) {
                let total = 0;
                let conclusion = '';
                let bgColor = '';

                const form = document.getElementById('skala_' + type + 'Form');
                if (!form) return;

                switch(type) {
                    case 'umum':
                        const umumSelects = form.querySelectorAll('select');
                        let yaCount = 0;
                        umumSelects.forEach(select => {
                            if (select.value === 'ya') yaCount++;
                        });
                        conclusion = yaCount > 0 ? 'Risiko Jatuh' : 'Tidak Berisiko Jatuh';
                        bgColor = yaCount > 0 ? 'bg-warning' : 'bg-success';
                        break;

                    case 'morse':
                        const morseSelects = form.querySelectorAll('select');
                        morseSelects.forEach(select => {
                            total += parseInt(select.value) || 0;
                        });
                        if (total >= 45) {
                            conclusion = 'Risiko Tinggi';
                            bgColor = 'bg-danger';
                        } else if (total >= 25) {
                            conclusion = 'Risiko Sedang';
                            bgColor = 'bg-warning';
                        } else {
                            conclusion = 'Risiko Rendah';
                            bgColor = 'bg-success';
                        }
                        break;

                    case 'humpty':
                        const humptySelects = form.querySelectorAll('select');
                        humptySelects.forEach(select => {
                            total += parseInt(select.value) || 0;
                        });
                        if (total >= 13) {
                            conclusion = 'Risiko Tinggi';
                            bgColor = 'bg-danger';
                        } else {
                            conclusion = 'Risiko Rendah';
                            bgColor = 'bg-success';
                        }
                        break;

                    case 'ontario':
                        const ontarioSelects = form.querySelectorAll('select');
                        ontarioSelects.forEach(select => {
                            total += parseInt(select.value) || 0;
                        });
                        if (total >= 9) {
                            conclusion = 'Risiko Tinggi';
                            bgColor = 'bg-danger';
                        } else if (total >= 5) {
                            conclusion = 'Risiko Sedang';
                            bgColor = 'bg-warning';
                        } else {
                            conclusion = 'Risiko Rendah';
                            bgColor = 'bg-success';
                        }
                        break;
                }

                // Update tampilan kesimpulan
                const conclusionDiv = form.querySelector('.conclusion');
                if (conclusionDiv) {
                    conclusionDiv.className = `conclusion ${bgColor}`;
                    const conclusionSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
                    if (conclusionSpan) {
                        conclusionSpan.textContent = conclusion;
                    }
                }
            }

            // Tambahkan event listeners untuk semua select di setiap form risiko jatuh
            document.querySelectorAll('.risk-form select').forEach(select => {
                select.addEventListener('change', function() {
                    const formId = this.closest('.risk-form').id;
                    const type = formId.replace('Form', '').replace('skala_', '');
                    updateConclusion(type);
                });
            });


            //------------------------------------------------------------//
            //------------------------------------------------------------//
            // Handler untuk Risko Decubitus
            function showDecubitusForm(selectedValue) {
                // Sembunyikan semua form terlebih dahulu
                document.querySelectorAll('.decubitus-form').forEach(form => {
                    form.style.display = 'none';
                });

                // Tampilkan form yang dipilih
                if (selectedValue) {
                    const selectedForm = document.getElementById('form' + selectedValue.charAt(0).toUpperCase() + selectedValue.slice(1));
                    if (selectedForm) {
                        selectedForm.style.display = 'block';
                    }
                }
            }

            // Event listener untuk perubahan select skala decubitus
            const skalaRisikoDekubitus = document.getElementById('skalaRisikoDekubitus');
            if (skalaRisikoDekubitus) {
                skalaRisikoDekubitus.addEventListener('change', function() {
                    showDecubitusForm(this.value);
                    resetKesimpulanDecubitus(this.value);
                });
            }

            // Fungsi untuk menghitung total skor Norton
            function calculateNortonScore() {
                let total = 0;
                const nortonFields = ['kondisi_fisik', 'kondisi_mental', 'aktivitas', 'mobilitas', 'inkontinensia'];
                
                nortonFields.forEach(field => {
                    const select = document.querySelector(`select[name="${field}"]`);
                    if (select && select.value) {
                        total += parseInt(select.value);
                    }
                });

                // Update kesimpulan berdasarkan total skor
                const kesimpulanNorton = document.getElementById('kesimpulanNorton');
                if (kesimpulanNorton) {
                    let conclusion = '';
                    let alertClass = '';

                    if (total <= 12) {
                        conclusion = 'Risiko Tinggi';
                        alertClass = 'alert-danger';
                    } else if (total <= 14) {
                        conclusion = 'Risiko Sedang';
                        alertClass = 'alert-warning';
                    } else {
                        conclusion = 'Risiko Rendah';
                        alertClass = 'alert-success';
                    }

                    kesimpulanNorton.className = `alert mb-0 flex-grow-1 ${alertClass}`;
                    kesimpulanNorton.textContent = conclusion;
                }
            }

            // Reset kesimpulan saat berganti skala
            function resetKesimpulanDecubitus(scale) {
                if (scale === 'norton') {
                    const kesimpulanNorton = document.getElementById('kesimpulanNorton');
                    if (kesimpulanNorton) {
                        kesimpulanNorton.className = 'alert alert-info mb-0 flex-grow-1';
                        kesimpulanNorton.textContent = 'Pilih semua kriteria untuk melihat kesimpulan';
                    }
                }
                // Tambahkan reset untuk skala lain jika diperlukan
            }

            // Event listener untuk setiap select di form Norton
            document.querySelectorAll('#formNorton select').forEach(select => {
                select.addEventListener('change', calculateNortonScore);
            });

            // Sembunyikan semua form saat halaman dimuat
            showDecubitusForm('');
            
            //------------------------------------------------------------//
            //------------------------------------------------------------//



            //------------------------------------------------------------//
            //------------------------------------------------------------//
            // Handler untuk Status Psikologis dropdown
            function toggleDropdown(dropdownId) {
                const dropdown = document.getElementById(dropdownId);
                const isVisible = dropdown.style.display === 'block';
                dropdown.style.display = isVisible ? 'none' : 'block';
            }

            // Fungsi untuk memperbarui tampilan item yang dipilih
            function updateSelectedItems(containerId, items, type) {
                const container = document.getElementById(containerId);
                container.innerHTML = items.map(item => `
                    <div class="alert alert-light border d-flex justify-content-between align-items-center py-1 px-2 mb-1">
                        <span>${item}</span>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0 ms-2" 
                                onclick="removeItem('${containerId}', '${item}')">
                            <i class="bi bi-x" style="font-size: 1.2rem;"></i>
                        </button>
                    </div>
                `).join('');
            }

            // Fungsi untuk menangani checkbox Kondisi Psikologis
            function handleKondisiPsikologis() {
                const kondisiCheckboxes = document.querySelectorAll('.kondisi-options input[type="checkbox"]');
                const selectedItems = [];

                kondisiCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedItems.push(checkbox.value);
                    }
                });

                updateSelectedItems('selectedKondisiPsikologis', selectedItems, 'kondisi');

                // Handle "Tidak ada kelainan" logic
                const noKelainanCheckbox = document.getElementById('kondisi1');
                if (noKelainanCheckbox && noKelainanCheckbox.checked) {
                    kondisiCheckboxes.forEach(cb => {
                        if (cb !== noKelainanCheckbox) {
                            cb.checked = false;
                            cb.disabled = true;
                        }
                    });
                } else {
                    kondisiCheckboxes.forEach(cb => {
                        if (cb) cb.disabled = false;
                    });
                }
            }

            // Fungsi untuk menangani checkbox Gangguan Perilaku
            function handleGangguanPerilaku() {
                const perilakuCheckboxes = document.querySelectorAll('.perilaku-options input[type="checkbox"]');
                const selectedItems = [];

                perilakuCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedItems.push(checkbox.value);
                    }
                });

                updateSelectedItems('selectedGangguanPerilaku', selectedItems, 'perilaku');

                // Handle "Tidak Ada Gangguan" logic
                const noGangguanCheckbox = document.getElementById('perilaku1');
                if (noGangguanCheckbox && noGangguanCheckbox.checked) {
                    perilakuCheckboxes.forEach(cb => {
                        if (cb !== noGangguanCheckbox) {
                            cb.checked = false;
                            cb.disabled = true;
                        }
                    });
                } else {
                    perilakuCheckboxes.forEach(cb => {
                        if (cb) cb.disabled = false;
                    });
                }
            }

            // Event listeners
            const btnKondisiPsikologis = document.getElementById('btnKondisiPsikologis');
            const btnGangguanPerilaku = document.getElementById('btnGangguanPerilaku');

            if (btnKondisiPsikologis) {
                btnKondisiPsikologis.addEventListener('click', () => toggleDropdown('dropdownKondisiPsikologis'));
            }

            if (btnGangguanPerilaku) {
                btnGangguanPerilaku.addEventListener('click', () => toggleDropdown('dropdownGangguanPerilaku'));
            }

            // Event listeners untuk checkbox
            document.querySelectorAll('.kondisi-options input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', handleKondisiPsikologis);
            });

            document.querySelectorAll('.perilaku-options input[type="checkbox"]').forEach(checkbox => {
                checkbox.addEventListener('change', handleGangguanPerilaku);
            });

            // Click outside to close dropdowns
            document.addEventListener('click', function(event) {
                if (!event.target.closest('.dropdown-wrapper')) {
                    document.getElementById('dropdownKondisiPsikologis').style.display = 'none';
                    document.getElementById('dropdownGangguanPerilaku').style.display = 'none';
                }
            });

            // Inisialisasi pertama kali
            handleKondisiPsikologis();
            handleGangguanPerilaku();

            //------------------------------------------------------------//
            //------------------------------------------------------------//

            // Event listeners untuk status gizi

            const nutritionSelect = document.getElementById('nutritionAssessment');
            if (nutritionSelect) {
                nutritionSelect.addEventListener('change', function() {
                    showNutritionForm(this.value);
                });
            }

            // Event listeners untuk form MST
            document.querySelectorAll('#mst select').forEach(select => {
                select.addEventListener('change', updateMSTConclusion);
            });

            // Event listeners untuk form MNA
            document.querySelectorAll('#mna select').forEach(select => {
                select.addEventListener('change', updateMNAConclusion);
            });

            // Event listeners untuk BMI calculation di MNA
            const mnaWeight = document.getElementById('mnaWeight');
            const mnaHeight = document.getElementById('mnaHeight');
            if (mnaWeight && mnaHeight) {
                mnaWeight.addEventListener('input', calculateMNABMI);
                mnaHeight.addEventListener('input', calculateMNABMI);
            }

            // Event listeners untuk form Strong Kids
            document.querySelectorAll('#strong-kids select').forEach(select => {
                select.addEventListener('change', updateStrongKidsConclusion);
            });

            // Event listeners untuk form NRS 2002 (bisa ditambahkan jika diperlukan)

            // Sembunyikan semua form saat halaman dimuat
            showNutritionForm('');

        });

        // Fungsi untuk menampilkan form penilaian gizi yang dipilih
        function showNutritionForm(selectedValue) {
            // Sembunyikan semua form terlebih dahulu
            document.querySelectorAll('.assessment-form').forEach(form => {
                form.style.display = 'none';
            });

            // Tampilkan form yang dipilih
            if (selectedValue) {
                const selectedForm = document.getElementById(selectedValue);
                if (selectedForm) {
                    selectedForm.style.display = 'block';
                }
            }
        }

        // Fungsi untuk menghitung skor MST dan update kesimpulan
        function updateMSTConclusion() {
            let total = 0;
            const mstSelects = document.querySelectorAll('#mst select');
            
            mstSelects.forEach(select => {
                if (select.value) {
                    total += parseInt(select.value);
                }
            });

            const conclusion = document.getElementById('mstConclusion');
            if (conclusion) {
                conclusion.querySelector('.alert-success').style.display = total < 2 ? 'block' : 'none';
                conclusion.querySelector('.alert-warning').style.display = total >= 2 ? 'block' : 'none';
            }
        }

        // Fungsi untuk menghitung skor MNA dan update kesimpulan
        function updateMNAConclusion() {
            let total = 0;
            const mnaSelects = document.querySelectorAll('#mna select');
            
            mnaSelects.forEach(select => {
                if (select.value) {
                    total += parseInt(select.value);
                }
            });

            const conclusion = document.getElementById('mnaConclusion');
            if (conclusion) {
                conclusion.querySelector('.alert-success').style.display = total >= 12 ? 'block' : 'none';
                conclusion.querySelector('.alert-warning').style.display = total <= 11 ? 'block' : 'none';
            }
        }

        // Fungsi untuk menghitung BMI di form MNA
        function calculateMNABMI() {
            const weight = parseFloat(document.getElementById('mnaWeight').value);
            const height = parseFloat(document.getElementById('mnaHeight').value) / 100; // Convert cm to meters

            if (!isNaN(weight) && !isNaN(height) && height > 0) {
                const bmi = weight / (height * height);
                document.getElementById('mnaBMI').value = bmi.toFixed(2);
            } else {
                document.getElementById('mnaBMI').value = '';
            }
        }

        // Fungsi untuk menghitung skor Strong Kids dan update kesimpulan
        function updateStrongKidsConclusion() {
            let total = 0;
            const strongKidsSelects = document.querySelectorAll('#strong-kids select');
            
            strongKidsSelects.forEach(select => {
                if (select.value) {
                    total += parseInt(select.value);
                }
            });

            const conclusion = document.getElementById('strongKidsConclusion');
            if (conclusion) {
                conclusion.querySelector('.alert-success:first-child').style.display = total === 0 ? 'block' : 'none';
                conclusion.querySelector('.alert-warning').style.display = total >= 1 && total <= 3 ? 'block' : 'none';
                conclusion.querySelector('.alert-success:last-child').style.display = total >= 4 ? 'block' : 'none';
            }
        }

        // Fungsi global untuk menghapus item yang dipilih
        function removeItem(containerId, item) {
            const container = document.getElementById(containerId);
            
            // Uncheck checkbox yang sesuai
            if (containerId === 'selectedKondisiPsikologis') {
                document.querySelectorAll('.kondisi-options input[type="checkbox"]').forEach(checkbox => {
                    if (checkbox.value === item) {
                        checkbox.checked = false;
                        const event = new Event('change');
                        checkbox.dispatchEvent(event);
                    }
                });
            } else if (containerId === 'selectedGangguanPerilaku') {
                document.querySelectorAll('.perilaku-options input[type="checkbox"]').forEach(checkbox => {
                    if (checkbox.value === item) {
                        checkbox.checked = false;
                        const event = new Event('change');
                        checkbox.dispatchEvent(event);
                    }
                });
            }
        }

    </script>
@endpush
