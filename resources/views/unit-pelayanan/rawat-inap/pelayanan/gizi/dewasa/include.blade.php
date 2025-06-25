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
            // Fungsi IMT dan BBI
            //==================================================================================================//
            // Fungsi untuk menghitung IMT dan BBI
            function hitungIMTdanBBI() {
                const beratBadan = parseFloat(document.getElementById('berat_badan').value);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan').value);
                
                if (beratBadan && tinggiBadan) {
                    // Hitung IMT (kg/m²)
                    const tinggiMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiMeter * tinggiMeter);
                    document.getElementById('imt').value = imt.toFixed(2);
                    
                    // Hitung BBI untuk anak menggunakan rumus Broca yang disesuaikan
                    let bbi;
                    if (tinggiBadan <= 100) {
                        bbi = tinggiBadan - 100;
                    } else if (tinggiBadan <= 110) {
                        bbi = (tinggiBadan - 100) * 0.9;
                    } else {
                        bbi = (tinggiBadan - 100) * 0.9 - ((tinggiBadan - 110) * 0.1);
                    }
                    
                    // Untuk anak, BBI minimal 3 kg
                    if (bbi < 3) bbi = 3;
                    
                    document.getElementById('bbi').value = bbi.toFixed(1);
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
            // Fungsi
            //==================================================================================//
            // Fungsi debug untuk memeriksa semua nilai
            function debugValues() {
                console.log('=== DEBUG NUTRITION CALCULATION ===');
                
                const beratBadan = document.getElementById('berat_badan');
                const tinggiBadan = document.getElementById('tinggi_badan');
                const umur = document.getElementById('umur');
                const jenisKelamin = document.querySelector('input[name="jenis_kelamin"]');
                
                console.log('Elements found:');
                console.log('- berat_badan element:', beratBadan);
                console.log('- tinggi_badan element:', tinggiBadan);
                console.log('- umur element:', umur);
                console.log('- jenis_kelamin element:', jenisKelamin);
                
                if (beratBadan) console.log('- berat_badan value:', beratBadan.value);
                if (tinggiBadan) console.log('- tinggi_badan value:', tinggiBadan.value);
                if (umur) console.log('- umur value:', umur.value);
                if (jenisKelamin) console.log('- jenis_kelamin value:', jenisKelamin.value);
                
                console.log('===================================');
            }
            
            // Fungsi untuk menghitung BEE yang lebih robust
            function hitungBEE() {
                try {
                    console.log('hitungBEE() dipanggil...');
                    
                    // Ambil element
                    const beratBadanEl = document.getElementById('berat_badan');
                    const tinggiBadanEl = document.getElementById('tinggi_badan');
                    const umurEl = document.getElementById('umur');
                    const jenisKelaminEl = document.querySelector('input[name="jenis_kelamin"]');
                    
                    // Debug element
                    if (!beratBadanEl) {
                        console.error('Element berat_badan tidak ditemukan!');
                        return;
                    }
                    if (!tinggiBadanEl) {
                        console.error('Element tinggi_badan tidak ditemukan!');
                        return;
                    }
                    if (!umurEl) {
                        console.error('Element umur tidak ditemukan!');
                        return;
                    }
                    if (!jenisKelaminEl) {
                        console.error('Element jenis_kelamin tidak ditemukan!');
                        return;
                    }
                    
                    // Ambil nilai
                    const beratBadan = parseFloat(beratBadanEl.value);
                    const tinggiBadan = parseFloat(tinggiBadanEl.value);
                    const umur = parseFloat(umurEl.value);
                    const jenisKelamin = jenisKelaminEl.value;
                    
                    console.log('Nilai yang diambil:');
                    console.log('- Berat Badan:', beratBadan, 'kg');
                    console.log('- Tinggi Badan:', tinggiBadan, 'cm');
                    console.log('- Umur:', umur, 'tahun');
                    console.log('- Jenis Kelamin:', jenisKelamin, '(1=Laki, 0=Perempuan)');
                    
                    // Validasi input
                    if (isNaN(beratBadan) || beratBadan <= 0) {
                        console.warn('Berat badan tidak valid:', beratBadan);
                        return;
                    }
                    if (isNaN(tinggiBadan) || tinggiBadan <= 0) {
                        console.warn('Tinggi badan tidak valid:', tinggiBadan);
                        return;
                    }
                    if (isNaN(umur) || umur < 0) {
                        console.warn('Umur tidak valid:', umur);
                        return;
                    }
                    
                    // Hitung BEE
                    let bee;
                    if (jenisKelamin == '1') { // Laki-laki
                        bee = 66 + (13.7 * beratBadan) + (5 * tinggiBadan) - (6.8 * umur);
                        console.log('Rumus Laki-laki: 66 + (13.7 × ' + beratBadan + ') + (5 × ' + tinggiBadan + ') - (6.8 × ' + umur + ')');
                    } else { // Perempuan
                        bee = 655 + (9.6 * beratBadan) + (1.7 * tinggiBadan) - (4.7 * umur);
                        console.log('Rumus Perempuan: 655 + (9.6 × ' + beratBadan + ') + (1.7 × ' + tinggiBadan + ') - (4.7 × ' + umur + ')');
                    }
                    
                    console.log('BEE hasil perhitungan:', bee);
                    
                    // Set nilai BEE dan BMR
                    const beeEl = document.getElementById('bee');
                    const bmrEl = document.getElementById('bmr');
                    
                    if (beeEl) {
                        beeEl.value = Math.round(bee);
                        console.log('BEE di-set ke:', Math.round(bee));
                    } else {
                        console.error('Element bee tidak ditemukan!');
                    }
                    
                    if (bmrEl) {
                        bmrEl.value = Math.round(bee);
                        console.log('BMR di-set ke:', Math.round(bee));
                    } else {
                        console.error('Element bmr tidak ditemukan!');
                    }
                    
                    // Trigger perhitungan TEE
                    hitungTEE();
                    
                } catch (error) {
                    console.error('Error dalam hitungBEE:', error);
                }
            }
            
            // Fungsi untuk menghitung TEE
            function hitungTEE() {
                try {
                    console.log('hitungTEE() dipanggil...');
                    
                    const beeEl = document.getElementById('bee');
                    const faktorAktivitasEl = document.getElementById('faktor_aktivitas');
                    const faktorStressEl = document.getElementById('faktor_stress');
                    
                    if (!beeEl || !faktorAktivitasEl || !faktorStressEl) {
                        console.warn('Element untuk TEE tidak lengkap');
                        return;
                    }
                    
                    const bee = parseFloat(beeEl.value);
                    const faktorAktivitas = parseFloat(faktorAktivitasEl.value);
                    const faktorStress = parseFloat(faktorStressEl.value);
                    
                    console.log('Nilai untuk TEE:');
                    console.log('- BEE:', bee);
                    console.log('- Faktor Aktivitas:', faktorAktivitas);
                    console.log('- Faktor Stress:', faktorStress);
                    
                    if (bee && faktorAktivitas && faktorStress) {
                        const tee = bee * faktorAktivitas * faktorStress;
                        console.log('TEE = ' + bee + ' × ' + faktorAktivitas + ' × ' + faktorStress + ' = ' + tee);
                        
                        const teeEl = document.getElementById('tee');
                        if (teeEl) {
                            teeEl.value = Math.round(tee);
                            console.log('TEE di-set ke:', Math.round(tee));
                        }
                        
                        // Set kebutuhan kalori default sama dengan TEE jika kosong
                        const kebutuhanKaloriEl = document.getElementById('kebutuhan_kalori');
                        if (kebutuhanKaloriEl && !kebutuhanKaloriEl.value) {
                            kebutuhanKaloriEl.value = Math.round(tee);
                            console.log('Kebutuhan kalori di-set ke:', Math.round(tee));
                        }
                        
                        hitungMakronutrien();
                    } else {
                        console.warn('Nilai untuk TEE tidak lengkap');
                    }
                    
                } catch (error) {
                    console.error('Error dalam hitungTEE:', error);
                }
            }
            
            // Fungsi untuk menghitung makronutrien
            function hitungMakronutrien() {
                try {
                    console.log('hitungMakronutrien() dipanggil...');
                    
                    const kebutuhanKaloriEl = document.getElementById('kebutuhan_kalori');
                    if (!kebutuhanKaloriEl) {
                        console.warn('Element kebutuhan_kalori tidak ditemukan');
                        return;
                    }
                    
                    const kebutuhanKalori = parseFloat(kebutuhanKaloriEl.value);
                    if (!kebutuhanKalori) {
                        console.warn('Kebutuhan kalori belum di-set');
                        return;
                    }
                    
                    console.log('Kebutuhan kalori:', kebutuhanKalori);
                    
                    // Hitung protein
                    const proteinPersenEl = document.getElementById('protein_persen');
                    if (proteinPersenEl) {
                        const proteinPersen = parseFloat(proteinPersenEl.value) || 15;
                        const proteinGram = (proteinPersen / 100 * kebutuhanKalori) / 4;
                        const proteinGramEl = document.getElementById('protein_gram');
                        if (proteinGramEl) {
                            proteinGramEl.value = Math.round(proteinGram * 10) / 10;
                            console.log('Protein:', proteinPersen + '% = ' + Math.round(proteinGram * 10) / 10 + 'g');
                        }
                    }
                    
                    // Hitung lemak
                    const lemakPersenEl = document.getElementById('lemak_persen');
                    if (lemakPersenEl) {
                        const lemakPersen = parseFloat(lemakPersenEl.value) || 25;
                        const lemakGram = (lemakPersen / 100 * kebutuhanKalori) / 9;
                        const lemakGramEl = document.getElementById('lemak_gram');
                        if (lemakGramEl) {
                            lemakGramEl.value = Math.round(lemakGram * 10) / 10;
                            console.log('Lemak:', lemakPersen + '% = ' + Math.round(lemakGram * 10) / 10 + 'g');
                        }
                    }
                    
                    // Hitung karbohidrat
                    const khPersenEl = document.getElementById('kh_persen');
                    if (khPersenEl) {
                        const khPersen = parseFloat(khPersenEl.value) || 60;
                        const khGram = (khPersen / 100 * kebutuhanKalori) / 4;
                        const khGramEl = document.getElementById('kh_gram');
                        if (khGramEl) {
                            khGramEl.value = Math.round(khGram * 10) / 10;
                            console.log('Karbohidrat:', khPersen + '% = ' + Math.round(khGram * 10) / 10 + 'g');
                        }
                    }
                    
                } catch (error) {
                    console.error('Error dalam hitungMakronutrien:', error);
                }
            }
            
            // Event listeners yang lebih robust
            function setupEventListeners() {
                console.log('Setting up event listeners...');
                
                // Event listener untuk berat badan
                const beratBadanEl = document.getElementById('berat_badan');
                if (beratBadanEl) {
                    beratBadanEl.addEventListener('input', function() {
                        console.log('Berat badan berubah:', this.value);
                        hitungIMTdanBBI(); // fungsi yang sudah ada
                        setTimeout(hitungBEE, 100); // delay untuk memastikan nilai ter-update
                    });
                    console.log('Event listener berat_badan terpasang');
                }
                
                // Event listener untuk tinggi badan
                const tinggiBadanEl = document.getElementById('tinggi_badan');
                if (tinggiBadanEl) {
                    tinggiBadanEl.addEventListener('input', function() {
                        console.log('Tinggi badan berubah:', this.value);
                        hitungIMTdanBBI(); // fungsi yang sudah ada
                        setTimeout(hitungBEE, 100);
                    });
                    console.log('Event listener tinggi_badan terpasang');
                }
                
                // Event listener untuk umur
                const umurEl = document.getElementById('umur');
                if (umurEl) {
                    umurEl.addEventListener('input', function() {
                        console.log('Umur berubah:', this.value);
                        setTimeout(hitungBEE, 100);
                    });
                    console.log('Event listener umur terpasang');
                }
                
                // Event listener untuk faktor aktivitas
                const faktorAktivitasEl = document.getElementById('faktor_aktivitas');
                if (faktorAktivitasEl) {
                    faktorAktivitasEl.addEventListener('change', function() {
                        console.log('Faktor aktivitas berubah:', this.value);
                        hitungTEE();
                    });
                    console.log('Event listener faktor_aktivitas terpasang');
                }
                
                // Event listener untuk faktor stress
                const faktorStressEl = document.getElementById('faktor_stress');
                if (faktorStressEl) {
                    faktorStressEl.addEventListener('change', function() {
                        console.log('Faktor stress berubah:', this.value);
                        hitungTEE();
                    });
                    console.log('Event listener faktor_stress terpasang');
                }
                
                // Event listener untuk kebutuhan kalori
                const kebutuhanKaloriEl = document.getElementById('kebutuhan_kalori');
                if (kebutuhanKaloriEl) {
                    kebutuhanKaloriEl.addEventListener('input', function() {
                        console.log('Kebutuhan kalori berubah:', this.value);
                        hitungMakronutrien();
                    });
                }
                
                // Event listener untuk persentase makronutrien
                ['protein_persen', 'lemak_persen', 'kh_persen'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.addEventListener('input', hitungMakronutrien);
                    }
                });
            }
            
            // Inisialisasi dengan delay lebih lama
            setTimeout(() => {
                console.log('=== INISIALISASI PERHITUNGAN NUTRISI ===');
                debugValues();
                setupEventListeners();
                
                // Trigger perhitungan awal
                setTimeout(() => {
                    console.log('Memulai perhitungan awal...');
                    hitungBEE();
                }, 500);
                
            }, 1000); // Delay 1 detik untuk memastikan semua element sudah loaded
            
            // Expose fungsi ke global scope untuk debugging manual
            window.debugNutrition = {
                debugValues: debugValues,
                hitungBEE: hitungBEE,
                hitungTEE: hitungTEE,
                hitungMakronutrien: hitungMakronutrien
            };
            
            console.log('Script perhitungan nutrisi siap. Untuk debug manual, gunakan: window.debugNutrition.debugValues()');


        });
    </script>
@endpush
