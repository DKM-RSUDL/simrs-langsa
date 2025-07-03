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
        }

        .form-label {
            margin-bottom: 0.8rem;
            font-weight: 500;
        }

        .form-group label {
            margin-right: 1rem;
            padding-top: 0.5rem;
        }

        .fw-bold {
            font-weight: 600;
        }

        textarea.form-control {
            resize: vertical;
            padding: 12px;
            line-height: 1.5;
        }

        h6 {
            font-weight: 600;
            font-size: 1rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .border {
            border: 1px solid #dee2e6 !important;
        }

        .rounded {
            border-radius: 8px !important;
        }

        .text-center {
            text-align: center !important;
        }

        .form-check-label {
            cursor: pointer;
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
    </style>
@endpush

@push('js')
    <script>

        document.addEventListener('DOMContentLoaded', function() {

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

            //==================================================================================================//
            // Fungsi untuk auto select status gizi berdasarkan IMT
            //==================================================================================================//
            function autoSelectStatusGizi() {
                const imtEl = document.getElementById('imt');
                const statusGiziEl = document.getElementById('status_gizi');
                
                if (!imtEl || !statusGiziEl) {
                    return;
                }
                
                const imt = parseFloat(imtEl.value);
                
                if (isNaN(imt) || imt <= 0) {
                    return;
                }
                
                let statusGizi = '';
                
                // Klasifikasi berdasarkan standar WHO untuk dewasa
                if (imt < 16.0) {
                    statusGizi = 'Gizi Buruk';
                } else if (imt >= 12.0 && imt < 18.4) {
                    statusGizi = 'Gizi Kurang';
                } else if (imt >= 18.5 && imt < 24.9) {
                    statusGizi = 'Gizi Baik/Normal';
                } else if (imt >= 25.0 && imt < 29.9) {
                    statusGizi = 'Gizi Lebih';
                } else if (imt >= 30.0) {
                    statusGizi = 'Obesitas';
                }
                
                // Set nilai pada select jika ada option yang sesuai
                if (statusGizi) {
                    const optionExists = Array.from(statusGiziEl.options).some(option => option.value === statusGizi);
                    if (optionExists) {
                        statusGiziEl.value = statusGizi;
                    }
                }
            }

            //==================================================================================================//
            // Fungsi IMT dan BBI
            //==================================================================================================//
            // Fungsi untuk menghitung IMT dan BBI
            function hitungIMTdanBBI() {
                const beratBadan = parseFloat(document.getElementById('berat_badan').value);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan').value);
                const jenisKelaminEl = document.querySelector('input[name="jenis_kelamin"]');
                
                if (beratBadan && tinggiBadan && jenisKelaminEl) {
                    // Hitung IMT (kg/m²)
                    const tinggiMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiMeter * tinggiMeter);
                    document.getElementById('imt').value = imt.toFixed(2);
                    
                    // Hitung BBI menggunakan rumus Broca yang BENAR
                    const jenisKelamin = jenisKelaminEl.value;
                    let bbi;
                    
                    if (jenisKelamin == '1') { 
                        // Laki-laki: BBI = (TB - 100) × 0.9
                        bbi = (tinggiBadan - 100) * 0.9;
                    } else { 
                        // Perempuan: BBI = (TB - 100) × 0.85
                        bbi = (tinggiBadan - 100) * 0.85;
                    }
                    
                    document.getElementById('bbi').value = bbi.toFixed(1);
                    setTimeout(autoSelectStatusGizi, 100);
                }
            }

            // Event listener untuk input berat badan dan tinggi badan
            document.getElementById('berat_badan')?.addEventListener('input', hitungIMTdanBBI);
            document.getElementById('tinggi_badan')?.addEventListener('input', hitungIMTdanBBI);

            //==================================================================================================//
            // Fungsi section riwayat gizi
            //==================================================================================================//
            document.getElementById('alergi_makanan_tidak')?.addEventListener('change', function() {
                if (this.checked) {
                    const textarea = document.getElementById('jenis_alergi');
                    textarea.style.backgroundColor = '#f8f9fa';
                    textarea.setAttribute('readonly', true);
                    textarea.value = '';
                }
            });

            document.getElementById('alergi_makanan_ya')?.addEventListener('change', function() {
                if (this.checked) {
                    const textarea = document.getElementById('jenis_alergi');
                    textarea.style.backgroundColor = '#ffffff';
                    textarea.removeAttribute('readonly');
                    textarea.focus();
                }
            });

            // Event listeners untuk pantangan makanan
            document.getElementById('pantangan_makanan_tidak')?.addEventListener('change', function() {
                if (this.checked) {
                    const textarea = document.getElementById('jenis_pantangan');
                    textarea.style.backgroundColor = '#f8f9fa';
                    textarea.setAttribute('readonly', true);
                    textarea.value = '';
                }
            });

            document.getElementById('pantangan_makanan_ya')?.addEventListener('change', function() {
                if (this.checked) {
                    const textarea = document.getElementById('jenis_pantangan');
                    textarea.style.backgroundColor = '#ffffff';
                    textarea.removeAttribute('readonly');
                    textarea.focus();
                }
            });

            //==================================================================================================//
            // Mencegah form submit dengan tombol Enter
            //==================================================================================================//

            // Fungsi untuk mencegah submit form ketika Enter ditekan
            function preventEnterSubmit(event) {
                // Jika yang ditekan adalah Enter (keyCode 13)
                if (event.keyCode === 13 || event.which === 13) {
                    // Jika bukan textarea, prevent default
                    if (event.target.tagName.toLowerCase() !== 'textarea') {
                        event.preventDefault();
                        return false;
                    }
                    // Jika textarea, hanya prevent jika tidak ada Shift yang ditekan
                    else if (event.target.tagName.toLowerCase() === 'textarea' && !event.shiftKey) {
                        // Biarkan Enter untuk baris baru di textarea
                        return true;
                    }
                }
            }

            // Terapkan ke semua input dan textarea dalam form
            const formElements = document.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], input[type="time"], select, textarea');
            formElements.forEach(function(element) {
                element.addEventListener('keypress', preventEnterSubmit);
            });

            // Alternatif: Terapkan ke seluruh form
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('keypress', function(event) {
                    if (event.keyCode === 13 || event.which === 13) {
                        // Kecuali jika target adalah textarea atau tombol submit
                        if (event.target.tagName.toLowerCase() !== 'textarea' && 
                            event.target.type !== 'submit') {
                            event.preventDefault();
                            return false;
                        }
                    }
                });
            }

            //==================================================================================//
            // Fungsi Perhitungan Nutrisi - DIPERBAIKI
            //==================================================================================//
            
            // Fungsi debug untuk memeriksa semua nilai (opsional untuk debugging)
            function debugValues() {
                // Function untuk debugging - bisa dihapus di production
                const elements = {
                    berat_badan: document.getElementById('berat_badan'),
                    tinggi_badan: document.getElementById('tinggi_badan'),
                    umur: document.getElementById('umur'),
                    jenis_kelamin: document.querySelector('input[name="jenis_kelamin"]'),
                    faktor_aktivitas: document.getElementById('faktor_aktivitas'),
                    faktor_stress: document.getElementById('faktor_stress'),
                    bee: document.getElementById('bee'),
                    tee: document.getElementById('tee'),
                    kebutuhan_kalori: document.getElementById('kebutuhan_kalori')
                };
                
                // Log hanya jika diperlukan untuk debugging
                return elements;
            }
            
            // Fungsi untuk menghitung BEE
            function hitungBEE() {
                try {
                    // Ambil element
                    const beratBadanEl = document.getElementById('berat_badan');
                    const tinggiBadanEl = document.getElementById('tinggi_badan');
                    const umurEl = document.getElementById('umur');
                    const jenisKelaminEl = document.querySelector('input[name="jenis_kelamin"]');
                    
                    // Validasi element
                    if (!beratBadanEl || !tinggiBadanEl || !umurEl || !jenisKelaminEl) {
                        return;
                    }
                    
                    // Ambil nilai
                    const beratBadan = parseFloat(beratBadanEl.value);
                    const tinggiBadan = parseFloat(tinggiBadanEl.value);
                    const umur = parseFloat(umurEl.value);
                    const jenisKelamin = jenisKelaminEl.value;
                    
                    // Validasi input
                    if (isNaN(beratBadan) || beratBadan <= 0 || 
                        isNaN(tinggiBadan) || tinggiBadan <= 0 || 
                        isNaN(umur) || umur < 0) {
                        return;
                    }
                    
                    // Hitung BEE
                    let bee;
                    if (jenisKelamin == '1') { // Laki-laki
                        bee = 66 + (13.7 * beratBadan) + (5 * tinggiBadan) - (6.8 * umur);
                    } else { // Perempuan
                        bee = 655 + (9.6 * beratBadan) + (1.7 * tinggiBadan) - (4.7 * umur);
                    }
                    
                    // Set nilai BEE dan BMR
                    const beeEl = document.getElementById('bee');
                    const bmrEl = document.getElementById('bmr');
                    
                    if (beeEl) {
                        beeEl.value = Math.round(bee);
                    }
                    
                    if (bmrEl) {
                        bmrEl.value = Math.round(bee);
                    }
                    
                    // Trigger perhitungan TEE dengan delay
                    setTimeout(hitungTEE, 50);
                    
                } catch (error) {
                    // Silent error handling
                }
            }
            
            // Fungsi untuk menghitung TEE
            function hitungTEE() {
                try {
                    const beeEl = document.getElementById('bee');
                    const faktorAktivitasEl = document.getElementById('faktor_aktivitas');
                    const faktorStressEl = document.getElementById('faktor_stress');
                    
                    if (!beeEl || !faktorAktivitasEl || !faktorStressEl) {
                        return;
                    }
                    
                    const bee = parseFloat(beeEl.value);
                    const faktorAktivitas = parseFloat(faktorAktivitasEl.value);
                    const faktorStress = parseFloat(faktorStressEl.value);
                    
                    if (!bee || bee <= 0 || !faktorAktivitas || faktorAktivitas <= 0 || 
                        !faktorStress || faktorStress <= 0) {
                        return;
                    }
                    
                    const tee = bee * faktorAktivitas * faktorStress;
                    
                    const teeEl = document.getElementById('tee');
                    if (teeEl) {
                        teeEl.value = Math.round(tee);
                    }
                    
                    // Set kebutuhan kalori default sama dengan TEE jika kosong
                    const kebutuhanKaloriEl = document.getElementById('kebutuhan_kalori');
                    if (kebutuhanKaloriEl) {
                        if (!kebutuhanKaloriEl.value || parseFloat(kebutuhanKaloriEl.value) === 0) {
                            kebutuhanKaloriEl.value = Math.round(tee);
                        }
                    }
                    
                    // Trigger makronutrien dengan delay
                    setTimeout(hitungMakronutrien, 50);
                    
                } catch (error) {
                    // Silent error handling
                }
            }
            
            // Fungsi untuk menghitung makronutrien
            function hitungMakronutrien() {
                try {
                    const kebutuhanKaloriEl = document.getElementById('kebutuhan_kalori');
                    
                    if (!kebutuhanKaloriEl) {
                        return;
                    }
                    
                    const kebutuhanKalori = parseFloat(kebutuhanKaloriEl.value);
                    
                    if (!kebutuhanKalori || kebutuhanKalori <= 0) {
                        return;
                    }
                    
                    // === PERHITUNGAN PROTEIN ===
                    const proteinPersenEl = document.getElementById('protein_persen');
                    const proteinGramEl = document.getElementById('protein_gram');
                    
                    if (proteinPersenEl && proteinGramEl) {
                        let proteinPersen = parseFloat(proteinPersenEl.value);
                        
                        // Set default jika kosong
                        if (!proteinPersen || proteinPersen <= 0) {
                            proteinPersen = 15; // 15% default untuk dewasa
                            proteinPersenEl.value = proteinPersen;
                        }
                        
                        // Perhitungan protein berdasarkan kalori = (% kalori) / 4 Kkal/gram
                        const proteinGramDariKalori = (proteinPersen / 100 * kebutuhanKalori) / 4;
                        proteinGramEl.value = Math.round(proteinGramDariKalori * 10) / 10;
                    }
                    
                    // === PERHITUNGAN LEMAK ===
                    const lemakPersenEl = document.getElementById('lemak_persen');
                    const lemakGramEl = document.getElementById('lemak_gram');
                    
                    if (lemakPersenEl && lemakGramEl) {
                        let lemakPersen = parseFloat(lemakPersenEl.value);
                        
                        // Set default jika kosong
                        if (!lemakPersen || lemakPersen <= 0) {
                            lemakPersen = 25; // 25% default untuk dewasa
                            lemakPersenEl.value = lemakPersen;
                        }
                        
                        // Perhitungan lemak berdasarkan kalori = (% kalori) / 9 Kkal/gram
                        const lemakGram = (lemakPersen / 100 * kebutuhanKalori) / 9;
                        lemakGramEl.value = Math.round(lemakGram * 10) / 10;
                    }
                    
                    // === PERHITUNGAN KARBOHIDRAT ===
                    const khPersenEl = document.getElementById('kh_persen');
                    const khGramEl = document.getElementById('kh_gram');
                    
                    if (khPersenEl && khGramEl) {
                        let khPersen = parseFloat(khPersenEl.value);
                        
                        // Set default jika kosong
                        if (!khPersen || khPersen <= 0) {
                            khPersen = 60; // 60% default untuk dewasa
                            khPersenEl.value = khPersen;
                        }
                        
                        // Perhitungan karbohidrat berdasarkan kalori = (% kalori) / 4 Kkal/gram
                        const khGram = (khPersen / 100 * kebutuhanKalori) / 4;
                        khGramEl.value = Math.round(khGram * 10) / 10;
                    }
                    
                    // === VALIDASI TOTAL PERSENTASE ===
                    const totalPersen = (parseFloat(proteinPersenEl?.value) || 0) + 
                                       (parseFloat(lemakPersenEl?.value) || 0) + 
                                       (parseFloat(khPersenEl?.value) || 0);
                    
                    // Auto-adjust karbohidrat agar total = 100% jika diperlukan
                    if (Math.abs(totalPersen - 100) > 0.1) {
                        if (khPersenEl && proteinPersenEl && lemakPersenEl) {
                            const proteinPersen = parseFloat(proteinPersenEl.value) || 15;
                            const lemakPersen = parseFloat(lemakPersenEl.value) || 25;
                            const sisaKH = 100 - proteinPersen - lemakPersen;
                            
                            if (sisaKH > 0) {
                                khPersenEl.value = sisaKH;
                                const khGramBaru = (sisaKH / 100 * kebutuhanKalori) / 4;
                                if (khGramEl) {
                                    khGramEl.value = Math.round(khGramBaru * 10) / 10;
                                }
                            }
                        }
                    }
                    
                } catch (error) {
                    // Silent error handling
                }
            }

            // Fungsi alternatif perhitungan protein berdasarkan berat badan
            function hitungProteinBerdasarkanBB() {
                const beratBadanEl = document.getElementById('berat_badan');
                const proteinGramEl = document.getElementById('protein_gram');
                
                if (beratBadanEl && proteinGramEl) {
                    const beratBadan = parseFloat(beratBadanEl.value);
                    
                    if (beratBadan) {
                        // Rekomendasi protein untuk dewasa: 0.8-1.2 g/kg BB
                        // Untuk pasien rumah sakit: 1.0-1.5 g/kg BB
                        // Untuk kondisi stress/sakit: 1.2-2.0 g/kg BB
                        
                        const proteinPerKgBB = 1.2; // default 1.2 g/kg BB
                        const proteinGram = beratBadan * proteinPerKgBB;
                        
                        proteinGramEl.value = Math.round(proteinGram * 10) / 10;
                        
                        // Hitung balik ke persentase kalori
                        const kebutuhanKaloriEl = document.getElementById('kebutuhan_kalori');
                        const proteinPersenEl = document.getElementById('protein_persen');
                        
                        if (kebutuhanKaloriEl && proteinPersenEl) {
                            const kebutuhanKalori = parseFloat(kebutuhanKaloriEl.value);
                            if (kebutuhanKalori) {
                                const proteinKalori = proteinGram * 4; // protein = 4 Kkal/gram
                                const proteinPersen = (proteinKalori / kebutuhanKalori) * 100;
                                proteinPersenEl.value = Math.round(proteinPersen * 10) / 10;
                            }
                        }
                    }
                }
            }

            // Fungsi untuk set nilai default makronutrien
            function setDefaultMakronutrien() {
                const proteinPersenEl = document.getElementById('protein_persen');
                const lemakPersenEl = document.getElementById('lemak_persen');
                const khPersenEl = document.getElementById('kh_persen');
                
                // Set default jika kosong
                if (proteinPersenEl && !proteinPersenEl.value) proteinPersenEl.value = 15;
                if (lemakPersenEl && !lemakPersenEl.value) lemakPersenEl.value = 25;
                if (khPersenEl && !khPersenEl.value) khPersenEl.value = 60;
                
                // Trigger perhitungan
                hitungMakronutrien();
            }

            // Event listeners yang diperbaiki untuk makronutrien
            function setupMakronutrienListeners() {
                // Event listener untuk persentase makronutrien
                ['protein_persen', 'lemak_persen', 'kh_persen'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.addEventListener('input', function() {
                            hitungMakronutrien();
                        });
                        
                        // Validasi input (0-100%)
                        el.addEventListener('blur', function() {
                            let value = parseFloat(this.value);
                            if (value < 0) this.value = 0;
                            if (value > 100) this.value = 100;
                        });
                    }
                });
                
                // Event listener untuk kebutuhan kalori
                const kebutuhanKaloriEl = document.getElementById('kebutuhan_kalori');
                if (kebutuhanKaloriEl) {
                    kebutuhanKaloriEl.addEventListener('input', function() {
                        setTimeout(hitungMakronutrien, 50);
                    });
                }
            }
            
            // Event listeners yang lebih robust untuk input utama
            function setupEventListeners() {
                // Event listener untuk berat badan
                const beratBadanEl = document.getElementById('berat_badan');
                if (beratBadanEl) {
                    beratBadanEl.addEventListener('input', function() {
                        hitungIMTdanBBI(); // fungsi yang sudah ada
                        setTimeout(hitungBEE, 100); // delay untuk memastikan nilai ter-update
                    });
                }
                
                // Event listener untuk tinggi badan
                const tinggiBadanEl = document.getElementById('tinggi_badan');
                if (tinggiBadanEl) {
                    tinggiBadanEl.addEventListener('input', function() {
                        hitungIMTdanBBI(); // fungsi yang sudah ada
                        setTimeout(hitungBEE, 100);
                    });
                }
                
                // Event listener untuk umur
                const umurEl = document.getElementById('umur');
                if (umurEl) {
                    umurEl.addEventListener('input', function() {
                        setTimeout(hitungBEE, 100);
                    });
                }
                
                // Event listener untuk faktor aktivitas
                const faktorAktivitasEl = document.getElementById('faktor_aktivitas');
                if (faktorAktivitasEl) {
                    faktorAktivitasEl.addEventListener('change', function() {
                        setTimeout(hitungTEE, 50);
                    });
                }
                
                // Event listener untuk faktor stress
                const faktorStressEl = document.getElementById('faktor_stress');
                if (faktorStressEl) {
                    faktorStressEl.addEventListener('change', function() {
                        setTimeout(hitungTEE, 50);
                    });
                }
            }
            
            // Fungsi untuk memaksa recalculate semua
            function forceRecalculateAll() {
                setTimeout(() => {
                    hitungIMTdanBBI();
                    setTimeout(() => {
                        hitungBEE();
                        setTimeout(() => {
                            hitungTEE();
                            setTimeout(() => {
                                hitungMakronutrien();
                            }, 100);
                        }, 100);
                    }, 100);
                }, 100);
            }
            
            // Inisialisasi
            setTimeout(() => {
                debugValues();
                setupEventListeners();
                setupMakronutrienListeners();
                setDefaultMakronutrien();
                
                // Trigger perhitungan awal
                setTimeout(() => {
                    forceRecalculateAll();
                }, 500);
                
            }, 1000); // Delay 1 detik untuk memastikan semua element sudah loaded
            
            // Expose fungsi ke global scope untuk debugging manual (opsional)
            window.debugNutrition = {
                debugValues: debugValues,
                hitungBEE: hitungBEE,
                hitungTEE: hitungTEE,
                hitungMakronutrien: hitungMakronutrien,
                hitungIMTdanBBI: hitungIMTdanBBI,
                forceRecalculateAll: forceRecalculateAll,
                setDefaultMakronutrien: setDefaultMakronutrien
            };

        });
    </script>
@endpush