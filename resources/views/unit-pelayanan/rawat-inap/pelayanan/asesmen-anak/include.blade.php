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
            //STATUS FUNGSINOAL//

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
                            adlKesimpulanAlert.textContent = 'Pilih skala aktivitas harian terlebih dahulu';
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
                const checkedCategories = new Set(Array.from(adlChecks).map(check => check.getAttribute('data-category')));
                const allCategoriesSelected = checkedCategories.size === 3; // 3 kategori: makan, berjalan, mandi

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
                        adlKesimpulanAlert.className = adlModalKesimpulan.className.replace('py-1 px-3 mb-0', '');
                        adlKesimpulanAlert.textContent = adlModalKesimpulan.textContent;
                        
                        // Tutup modal
                        bootstrap.Modal.getInstance(document.getElementById('modalADL')).hide();
                    }
                });
            }

            // Reset form ADL when modal is closed
            const modalADL = document.getElementById('modalADL');
            if (modalADL) {
                modalADL.addEventListener('hidden.bs.modal', function() {
                    document.querySelectorAll('.adl-check').forEach(check => {
                        check.checked = false;
                    });
                    const adlModalTotal = document.getElementById('adlTotal');
                    if (adlModalTotal) {
                        adlModalTotal.value = '';
                    }
                    const adlModalKesimpulan = document.getElementById('adlKesimpulan');
                    if (adlModalKesimpulan) {
                        adlModalKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                        adlModalKesimpulan.textContent = 'Pilih semua kategori terlebih dahulu';
                    }
                });
            }



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
                    flaccKesimpulan.textContent = kesimpulan;
                    flaccKesimpulan.className = `alert py-1 px-3 mb-0 ${alertClass}`;
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

                        // Update all relevant fields
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

            // Reset FLACC form when modal is closed
            const modalFLACC = document.getElementById('modalFLACC');
            if (modalFLACC) {
                modalFLACC.addEventListener('hidden.bs.modal', function() {
                    // document.querySelectorAll('.flacc-check').forEach(check => {
                    //     check.checked = false;
                    // });
                    // const flaccTotal = document.getElementById('flaccTotal');
                    // if (flaccTotal) {
                    //     flaccTotal.value = '';
                    // }
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
                    criesKesimpulan.textContent = kesimpulan;
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
                    const criesTotal = document.getElementById('criesTotal');
                    
                    if (nilaiSkalaNyeri && criesTotal && criesTotal.value !== '') {
                        let total = criesTotal.value ? parseInt(criesTotal.value) : null;
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

                        // Update all relevant fields
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

            // Reset CRIES form when modal is closed
            const modalCRIES = document.getElementById('modalCRIES');
            if (modalCRIES) {
                modalCRIES.addEventListener('hidden.bs.modal', function() {
                    // document.querySelectorAll('.cries-check').forEach(check => {
                    //     check.checked = false;
                    // });
                    // const criesTotal = document.getElementById('criesTotal');
                    // if (criesTotal) {
                    //     criesTotal.value = '';
                    // }
                    const criesKesimpulan = document.getElementById('criesKesimpulan');
                    if (criesKesimpulan) {
                        criesKesimpulan.textContent = 'Pilih semua kategori untuk melihat kesimpulan';
                        criesKesimpulan.className = 'alert alert-info py-1 px-3 mb-0';
                    }
                });
            }

            //------------------------------------------------------------//
            //------------------------------------------------------------//


            // 6. Event handler untuk Risiko Jatuh
            // Event listener untuk perubahan select skala
            const risikoJatuhSelect = document.getElementById('risikoJatuhSkala');
            if (risikoJatuhSelect) {
                risikoJatuhSelect.addEventListener('change', function() {
                    // Bersihkan form sebelumnya
                    showForm('');
                    // Tampilkan form yang dipilih
                    if (this.value) {
                        showForm(this.value);
                    }
                });
            }

            // Event listener untuk semua select di form risiko jatuh
            document.querySelectorAll('.risk-form select').forEach(select => {
                select.addEventListener('change', function() {
                    const formId = this.closest('.risk-form').id;
                    const type = formId.replace('Form', '');
                    updateConclusion(type);
                });
            });

            showForm('');
            
            //------------------------------------------------------------//
            //------------------------------------------------------------//

            // 7. Event handler untuk Decubitus

            const formNorton = document.getElementById('formNorton');
            if (formNorton) {
                formNorton.querySelectorAll('select').forEach(select => {
                    select.addEventListener('change', () => updateDecubitusConclusion('norton'));
                });
            }

            const skalaDecubitusSelect = document.getElementById('skalaRisikoDekubitus');
            if (skalaDecubitusSelect) {
                skalaDecubitusSelect.addEventListener('change', function() {
                    showDecubitusForm(this.value);
                });
                // Sembunyikan semua form saat halaman dimuat
                showDecubitusForm('');
            }


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

            // EVENT LISTENER UNTUK STATUS GIZI
            const nutritionSelect = document.getElementById('nutritionAssessment');
            const allForms = document.querySelectorAll('.assessment-form');

            // Event listener untuk perubahan select
            nutritionSelect.addEventListener('change', function() {
                const selectedValue = this.value;

                // Sembunyikan semua form
                allForms.forEach(form => {
                    form.style.display = 'none';
                });

                if (selectedValue === '5') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: 'Pasien tidak dapat dinilai status gizinya',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Ok'
                    });
                    document.getElementById('cannot-assess').value = 'tidak ada status gizi';
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
            });

            //------------------------------------------------------------//
            //------------------------------------------------------------//
            // 16. Discharge PLANING
            const dischargePlanningSection = document.getElementById('discharge-planning');
            const allSelects = dischargePlanningSection.querySelectorAll('select');
            const alertWarning = dischargePlanningSection.querySelector('.alert-warning');
            const alertSuccess = dischargePlanningSection.querySelector('.alert-success');

            // Function untuk update kesimpulan
            function updateDischargePlanningConclusion() {
                let needsSpecialPlan = false;
                let allSelected = true;

                // Cek semua select
                allSelects.forEach(select => {
                    if (!select.value) {
                        allSelected = false;
                    } else if (select.value === 'ya') {
                        needsSpecialPlan = true;
                    }
                });

                // Jika belum semua dipilih, sembunyikan kedua alert
                if (!allSelected) {
                    alertWarning.style.display = 'none';
                    alertSuccess.style.display = 'none';
                    return;
                }

                // Update tampilan kesimpulan
                if (needsSpecialPlan) {
                    alertWarning.style.display = 'block';
                    alertSuccess.style.display = 'none';
                } else {
                    alertWarning.style.display = 'none';
                    alertSuccess.style.display = 'block';
                }
            }

            // Tambahkan event listener untuk setiap select
            allSelects.forEach(select => {
                select.addEventListener('change', updateDischargePlanningConclusion);
            });

            // Inisialisasi awal
            updateDischargePlanningConclusion();
            

            //------------------------------------------------------------//
            //------------------------------------------------------------//


        });

        //#END EVENT HANDLER DECLARATION
        // ------------------------------------------------------------//
        // ------------------------------------------------------------//



        // ------------------------------------------------------------//
        // Event handler untuk skala risiko jatuh
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

        // Fungsi untuk menampilkan form yang dipilih
        function showForm(formType) {
            document.querySelectorAll('.risk-form').forEach(form => {
                form.style.display = 'none';
            });

            // Handle untuk opsi "Lainnya"
            if (formType === 'lainnya') {
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
                    backdrop: `rgba(244, 244, 244, 0.7)`
                });
                document.getElementById('risikoJatuhSkala').value = '';
                return;
            }

            // Tampilkan form yang dipilih
            const selectedForm = document.getElementById(formType + 'Form');
            if (selectedForm) {
                selectedForm.style.display = 'block';
                resetForm(selectedForm);
            }
        }

        // Reset form saat berganti
        function resetForm(form) {
            if (!form) return;
            
            form.querySelectorAll('select').forEach(select => select.value = '');
            const formType = form.id.replace('Form', '');
            const conclusionDiv = form.querySelector('.conclusion');
            const defaultConclusion = formType === 'skala_umum' ? 'Tidak berisiko jatuh' : 'Risiko Rendah';

            if (conclusionDiv) {
                conclusionDiv.className = 'conclusion bg-success';
                const conclusionSpan = conclusionDiv.querySelector('#kesimpulanTextForm');
                if (conclusionSpan) {
                    conclusionSpan.textContent = defaultConclusion;
                }
            }
        }
        // Update kesimpulan berdasarkan pilihan
        function updateConclusion(formType) {
            const form = document.getElementById('skala_' + formType + 'Form');
            // Tambahkan pengecekan form
            if (!form) return;

            // Pengecekan untuk memastikan elemen yang diperlukan ada
            const conclusionDiv = form.querySelector('.conclusion');
            const conclusionSpan = conclusionDiv?.querySelector('#kesimpulanTextForm');
            if (!conclusionDiv || !conclusionSpan) return;

            const selects = form.querySelectorAll('select');
            if (!selects.length) return;

            let score = 0;
            let hasYes = false;
            let allFilled = true;

            // Hitung skor
            selects.forEach(select => {
                if (!select.value) {
                    allFilled = false;
                    return;
                }
                if (select.value === 'ya') {
                    hasYes = true;
                }
                score += parseInt(select.value) || 0;
            });

            // Jika belum semua diisi, return
            if (!allFilled) return;

            let conclusion = '';
            let bgClass = '';

            // Tentukan kesimpulan berdasarkan tipe form
            switch (formType) {
                case 'umum':
                    conclusion = hasYes ? 'Berisiko jatuh' : 'Tidak berisiko jatuh';
                    bgClass = hasYes ? 'bg-warning' : 'bg-success';
                    break;

                case 'morse':
                    if (score >= forms.morse.high) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else if (score >= forms.morse.medium) {
                        conclusion = 'Risiko Sedang';
                        bgClass = 'bg-warning';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    conclusion += ` (Skor: ${score})`;
                    break;

                case 'humpty':
                    if (score >= forms.humpty.high) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    conclusion += ` (Skor: ${score})`;
                    break;

                case 'ontario':
                    if (score >= forms.ontario.high) {
                        conclusion = 'Risiko Tinggi';
                        bgClass = 'bg-danger';
                    } else if (score >= forms.ontario.medium) {
                        conclusion = 'Risiko Sedang';
                        bgClass = 'bg-warning';
                    } else {
                        conclusion = 'Risiko Rendah';
                        bgClass = 'bg-success';
                    }
                    conclusion += ` (Skor: ${score})`;
                    break;
            }

            // Update tampilan kesimpulan
            conclusionDiv.className = `conclusion ${bgClass}`;
            conclusionSpan.textContent = conclusion;
        }
        // ------------------------------------------------------------//
        // ------------------------------------------------------------//



        // ------------------------------------------------------------//
        // Event handler untuk Decuibitus

        const decubitusScores = {
            norton: {
                low: 15,    // > 15 risiko rendah
                medium: 13,  // 13-14 risiko sedang
                high: 12     // < 12 risiko tinggi
            }
        };

        // Fungsi untuk menampilkan form decubitus yang dipilih
        function showDecubitusForm(formType) {
            // Sembunyikan semua form terlebih dahulu
            document.querySelectorAll('.decubitus-form').forEach(form => {
                form.style.display = 'none';
            });

            // Tampilkan form yang dipilih
            if (formType) {
                const selectedForm = document.getElementById('form' + formType.charAt(0).toUpperCase() + formType.slice(1));
                if (selectedForm) {
                    selectedForm.style.display = 'block';
                    resetDecubitusForm(selectedForm);
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
                const fields = ['kondisi_fisik', 'kondisi_mental', 'aktivitas', 'mobilitas', 'inkontinensia'];

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
            }
        }

        // ------------------------------------------------------------//
        // ------------------------------------------------------------//


        // Fungsi untuk menampilkan form penilaian gizi yang dipilih
        // Inisialisasi listener untuk setiap form
        function initializeFormListeners(formId) {
            const form = document.getElementById(formId);
            const selects = form.querySelectorAll('select');

            switch (formId) {
                case 'mst':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateMSTScore(form));
                    });
                    break;
                case 'mna':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateMNAScore(form));
                    });
                    initializeBMICalculation();
                    break;
                case 'strong-kids':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateStrongKidsScore(form));
                    });
                    break;
                case 'nrs':
                    selects.forEach(select => {
                        select.addEventListener('change', () => calculateNRSScore(form));
                    });
                    break;
            }
        }

        // Fungsi perhitungan MST
        function calculateMSTScore() {
            const form = document.getElementById('mst');
            const selects = form.querySelectorAll('select');
            let total = 0;

            selects.forEach(select => {
                total += parseInt(select.value || 0);
            });

            const kesimpulan = total <= 1 ? 'Tidak berisiko malnutrisi' : 'Berisiko malnutrisi';
            document.getElementById('gizi_mst_kesimpulan').value = kesimpulan;

            const conclusions = form.querySelectorAll('.alert');
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


        //------------------------------------------------------------//
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
