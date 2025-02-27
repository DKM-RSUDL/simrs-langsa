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
                    const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector('.form-check-input');
                    if (keteranganDiv && normalCheckbox) {
                        if (keteranganDiv.style.display === 'none') {
                            keteranganDiv.style.display = 'block';
                            normalCheckbox.checked = false;
                        } else {
                            keteranganDiv.style.display = 'block';
                        }
                    }
                });
            });

            document.querySelectorAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const keteranganDiv = this.closest('.pemeriksaan-item')?.querySelector('.keterangan');
                    if (keteranganDiv && this.checked) {
                        keteranganDiv.style.display = 'none';
                        keteranganDiv.querySelector('input').value = '';
                    }
                });
            });

            // Hanya centang checkbox di dalam .pemeriksaan-item secara default
            document.querySelectorAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                checkbox.checked = true; // Hanya berlaku untuk pemeriksaan fisik
                const keteranganDiv = checkbox.closest('.pemeriksaan-item')?.querySelector('.keterangan');
                if (keteranganDiv) {
                    keteranganDiv.style.display = 'none';
                    const input = keteranganDiv.querySelector('input');
                    if (input) input.value = '';
                }
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
                        row.remove();
                    });

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
            Serra} else if (total >= 4 && total <= 6) {
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

        });
    </script>
@endpush