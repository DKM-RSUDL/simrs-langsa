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
        // PERBAIKAN UNTUK MASALAH LMS DATA PARSING

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
            const formElements = document.querySelectorAll(
                'input[type="text"], input[type="number"], input[type="date"], input[type="time"], select, textarea'
                );
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

            //==================================================================================================//
            // Z-Score Calculator untuk Anak berdasarkan standar WHO - Production Version
            //==================================================================================================//

            // Data WHO dari database
            let whoDataFromDB = {
                weightForAge: @json($WhoWeightForAge ?? []),
                heightForAge: @json($WhoHeightForAge ?? []),
                bmiForAge: @json($WhoBmiForAge ?? []),
                weightForHeight: @json($WhoWeightForHeight ?? []),
                weightForLength: @json($WhoWeightForLength ?? []),
                headCircumferenceForAge: @json($WhoHeadCircumferenceForAge ?? [])
            };

            // Function untuk parsing data decimal dari SQL Server
            function safeParseDecimal(value) {
                // Handle berbagai format data dari database
                if (typeof value === 'number' && !isNaN(value)) {
                    return value;
                }

                if (typeof value === 'string') {
                    // Remove quotes dan whitespace
                    const cleaned = value.replace(/['"]/g, '').trim();
                    const parsed = parseFloat(cleaned);
                    return isNaN(parsed) ? null : parsed;
                }

                // Handle object dengan properties numerik
                if (typeof value === 'object' && value !== null) {
                    // Jika value adalah object, coba ambil property yang sesuai
                    if (value.hasOwnProperty('value')) return safeParseDecimal(value.value);
                    if (value.hasOwnProperty('val')) return safeParseDecimal(value.val);
                    // Jika object kosong atau tidak ada property yang sesuai
                    return null;
                }

                return null;
            }

            // Function untuk extract LMS values dengan multiple fallbacks
            function extractLMSValues(dataItem) {
                // Coba berbagai kemungkinan field names dan formats
                let L = null,
                    M = null,
                    S = null;

                // Kemungkinan field names untuk L
                if (dataItem.L !== undefined) L = safeParseDecimal(dataItem.L);
                else if (dataItem.l !== undefined) L = safeParseDecimal(dataItem.l);
                else if (dataItem.lambda !== undefined) L = safeParseDecimal(dataItem.lambda);

                // Kemungkinan field names untuk M
                if (dataItem.M !== undefined) M = safeParseDecimal(dataItem.M);
                else if (dataItem.m !== undefined) M = safeParseDecimal(dataItem.m);
                else if (dataItem.mu !== undefined) M = safeParseDecimal(dataItem.mu);
                else if (dataItem.median !== undefined) M = safeParseDecimal(dataItem.median);

                // Kemungkinan field names untuk S
                if (dataItem.S !== undefined) S = safeParseDecimal(dataItem.S);
                else if (dataItem.s !== undefined) S = safeParseDecimal(dataItem.s);
                else if (dataItem.sigma !== undefined) S = safeParseDecimal(dataItem.sigma);

                // Validasi bahwa semua nilai valid
                if (L === null || M === null || S === null || M === 0 || S === 0) {
                    return null;
                }

                return {
                    L,
                    M,
                    S
                };
            }

            // Fungsi BBI yang diperbaiki untuk anak
            function hitungBBIAnak(umurBulan, tinggiBadan, jenisKelamin) {
                let bbi;

                if (umurBulan <= 12) {
                    // Untuk bayi 0-12 bulan: BBI = (umur bulan + 9) / 2
                    bbi = (umurBulan + 9) / 2;
                } else if (umurBulan <= 60) {
                    // Untuk anak 1-5 tahun: BBI = umur tahun × 2 + 8
                    const umurTahun = umurBulan / 12;
                    bbi = (umurTahun * 2) + 8;
                } else {
                    // Untuk anak > 5 tahun, gunakan rumus berdasarkan tinggi
                    if (tinggiBadan <= 100) {
                        bbi = tinggiBadan - 100;
                    } else if (tinggiBadan <= 150) {
                        bbi = (tinggiBadan - 100) * 0.9;
                    } else {
                        bbi = (tinggiBadan - 100) * 0.9 - ((tinggiBadan - 150) * 0.1);
                    }
                }

                // Minimum BBI untuk anak adalah 3 kg
                return Math.max(bbi, 3);
            }

            // Function untuk mencari data LMS berdasarkan sex dan age/height
            function findLMSData(dataArray, sex, ageOrHeight, isHeight = false) {
                if (!dataArray || dataArray.length === 0) {
                    return null;
                }

                // Tentukan field key berdasarkan struktur data
                const sample = dataArray[0];
                let key;

                if (isHeight) {
                    if ('height_cm' in sample) key = 'height_cm';
                    else if ('length_cm' in sample) key = 'length_cm';
                    else return null;
                } else {
                    if ('age_months' in sample) key = 'age_months';
                    else return null;
                }

                // Filter berdasarkan jenis kelamin
                const filteredData = dataArray.filter(item => {
                    const itemSex = parseInt(item.sex);
                    return itemSex === sex;
                });

                if (filteredData.length === 0) {
                    return null;
                }

                // Sort data
                filteredData.sort((a, b) => {
                    const aVal = safeParseDecimal(a[key]);
                    const bVal = safeParseDecimal(b[key]);
                    return (aVal || 0) - (bVal || 0);
                });

                // Validasi data
                const validValues = filteredData.map(item => safeParseDecimal(item[key])).filter(val => val !==
                    null);
                if (validValues.length === 0) {
                    return null;
                }

                const minVal = Math.min(...validValues);
                const maxVal = Math.max(...validValues);

                // Cari exact match (dengan toleransi 0.1)
                const exactMatch = filteredData.find(item => {
                    const itemValue = safeParseDecimal(item[key]);
                    return itemValue !== null && Math.abs(itemValue - ageOrHeight) < 0.1;
                });

                if (exactMatch) {
                    return extractLMSValues(exactMatch);
                }

                // Jika di luar range, gunakan nilai terdekat
                if (ageOrHeight < minVal) {
                    return extractLMSValues(filteredData[0]);
                }

                if (ageOrHeight > maxVal) {
                    return extractLMSValues(filteredData[filteredData.length - 1]);
                }

                // Interpolasi linear
                for (let i = 0; i < filteredData.length - 1; i++) {
                    const current = filteredData[i];
                    const next = filteredData[i + 1];
                    const currentVal = safeParseDecimal(current[key]);
                    const nextVal = safeParseDecimal(next[key]);

                    if (currentVal !== null && nextVal !== null && ageOrHeight >= currentVal && ageOrHeight <=
                        nextVal) {
                        const ratio = (ageOrHeight - currentVal) / (nextVal - currentVal);

                        const currentLMS = extractLMSValues(current);
                        const nextLMS = extractLMSValues(next);

                        if (!currentLMS || !nextLMS) {
                            return null;
                        }

                        const interpolated = {
                            L: currentLMS.L + ratio * (nextLMS.L - currentLMS.L),
                            M: currentLMS.M + ratio * (nextLMS.M - currentLMS.M),
                            S: currentLMS.S + ratio * (nextLMS.S - currentLMS.S)
                        };

                        return interpolated;
                    }
                }

                return null;
            }

            // Function untuk menghitung Z-Score menggunakan LMS method (WHO standard)
            function calculateZScore(value, L, M, S) {
                if (!value || value <= 0 || !M || M <= 0 || !S || S <= 0) {
                    return null;
                }

                let zScore;

                if (Math.abs(L) < 0.01) {
                    // L ≈ 0, gunakan log-normal distribution
                    zScore = Math.log(value / M) / S;
                } else {
                    // Gunakan Box-Cox transformation
                    zScore = (Math.pow(value / M, L) - 1) / (L * S);
                }

                // Validasi hasil (Z-Score normal biasanya antara -6 dan +6)
                if (Math.abs(zScore) > 6) {
                    return null;
                }

                return zScore;
            }

            // Function untuk menentukan status gizi berdasarkan Z-Score WHO
            function determineNutritionalStatus(wfaZScore, wfhZScore, hfaZScore, bmiZScore) {
                // Prioritas indikator: WFH > BMI-for-Age
                const primaryIndicator = wfhZScore !== null ? wfhZScore : bmiZScore;

                if (primaryIndicator !== null) {
                    // Severe acute malnutrition (SAM)
                    if (primaryIndicator < -3) return "Gizi Buruk";

                    // Moderate acute malnutrition (MAM)
                    if (primaryIndicator < -2) return "Gizi Kurang";

                    // Obesity
                    if (primaryIndicator > 3) return "Obesitas";

                    // Overweight
                    if (primaryIndicator > 2) return "Gizi Lebih";
                }

                // Check for underweight (weight-for-age)
                if (wfaZScore !== null && wfaZScore < -2) {
                    return "Gizi Kurang";
                }

                return "Gizi Baik/Normal";
            }

            // Fungsi IMT dan BBI
            function hitungIMTdanBBI() {
                const beratBadan = parseFloat(document.getElementById('berat_badan').value);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan').value);
                const umurBulan = parseFloat(document.querySelector('input[name="umur_bulan"]')?.value);
                const jenisKelamin = parseInt(document.getElementById('jenis_kelamin_who')?.value);

                if (beratBadan && tinggiBadan) {
                    // Hitung IMT (kg/m²)
                    const tinggiMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiMeter * tinggiMeter);
                    document.getElementById('imt').value = imt.toFixed(2);

                    // Hitung BBI menggunakan fungsi yang diperbaiki
                    if (umurBulan && jenisKelamin) {
                        const bbi = hitungBBIAnak(umurBulan, tinggiBadan, jenisKelamin);
                        document.getElementById('bbi').value = bbi.toFixed(1);
                    }
                }
            }

            // Main calculation function
            function calculateAllZScoresFromDB() {
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan')?.value);
                const umurBulan = parseFloat(document.querySelector('input[name="umur_bulan"]')?.value);
                const jenisKelamin = parseInt(document.getElementById('jenis_kelamin_who')?.value);

                if (!beratBadan || !tinggiBadan || umurBulan === null || jenisKelamin === null) {
                    return;
                }

                // Validasi input
                if (beratBadan <= 0 || beratBadan > 100 || tinggiBadan <= 0 || tinggiBadan > 200 || umurBulan < 0 ||
                    umurBulan > 240) {
                    return;
                }

                // Hitung IMT
                const tinggiMeter = tinggiBadan / 100;
                const imt = beratBadan / (tinggiMeter * tinggiMeter);
                document.getElementById('imt').value = imt.toFixed(2);

                // Hitung BBI
                const bbi = hitungBBIAnak(umurBulan, tinggiBadan, jenisKelamin);
                document.getElementById('bbi').value = bbi.toFixed(1);

                let wfaZScore = null,
                    hfaZScore = null,
                    wfhZScore = null,
                    bmiZScore = null;

                try {
                    // 1. Weight-for-Age Z-Score
                    if (whoDataFromDB.weightForAge && whoDataFromDB.weightForAge.length > 0) {
                        const wfaLMS = findLMSData(whoDataFromDB.weightForAge, jenisKelamin, umurBulan);
                        if (wfaLMS) {
                            wfaZScore = calculateZScore(beratBadan, wfaLMS.L, wfaLMS.M, wfaLMS.S);
                            if (wfaZScore !== null) {
                                document.querySelector('input[name="bb_usia"]').value = wfaZScore.toFixed(2);
                            }
                        }
                    }

                    // 2. Height-for-Age Z-Score
                    if (whoDataFromDB.heightForAge && whoDataFromDB.heightForAge.length > 0) {
                        const hfaLMS = findLMSData(whoDataFromDB.heightForAge, jenisKelamin, umurBulan);
                        if (hfaLMS) {
                            hfaZScore = calculateZScore(tinggiBadan, hfaLMS.L, hfaLMS.M, hfaLMS.S);
                            if (hfaZScore !== null) {
                                document.querySelector('input[name="pb_tb_usia"]').value = hfaZScore.toFixed(2);
                            }
                        }
                    }

                    // 3. Weight-for-Height Z-Score
                    let wfhData = null;
                    if (umurBulan < 24 && whoDataFromDB.weightForLength && whoDataFromDB.weightForLength.length >
                        0) {
                        wfhData = whoDataFromDB.weightForLength;
                    } else if (whoDataFromDB.weightForHeight && whoDataFromDB.weightForHeight.length > 0) {
                        wfhData = whoDataFromDB.weightForHeight;
                    }

                    if (wfhData) {
                        const wfhLMS = findLMSData(wfhData, jenisKelamin, tinggiBadan, true);
                        if (wfhLMS) {
                            wfhZScore = calculateZScore(beratBadan, wfhLMS.L, wfhLMS.M, wfhLMS.S);
                            if (wfhZScore !== null) {
                                document.querySelector('input[name="bb_tb"]').value = wfhZScore.toFixed(2);
                            }
                        }
                    }

                    // 4. BMI-for-Age Z-Score
                    if (whoDataFromDB.bmiForAge && whoDataFromDB.bmiForAge.length > 0) {
                        const bmiLMS = findLMSData(whoDataFromDB.bmiForAge, jenisKelamin, umurBulan);
                        if (bmiLMS) {
                            bmiZScore = calculateZScore(imt, bmiLMS.L, bmiLMS.M, bmiLMS.S);
                            if (bmiZScore !== null) {
                                document.querySelector('input[name="imt_usia"]').value = bmiZScore.toFixed(2);
                            }
                        }
                    }

                    // 5. Tentukan Status Gizi
                    const statusGizi = determineNutritionalStatus(wfaZScore, wfhZScore, hfaZScore, bmiZScore);
                    document.getElementById('status_gizi').value = statusGizi;

                } catch (error) {
                    // Silent error handling - tidak menampilkan error ke user
                    // Error akan ditangani secara internal tanpa mengganggu UX
                }
            }

            // Event listeners untuk input berat badan dan tinggi badan
            document.getElementById('berat_badan')?.addEventListener('input', function() {
                hitungIMTdanBBI();
                calculateAllZScoresFromDB();
            });

            document.getElementById('tinggi_badan')?.addEventListener('input', function() {
                hitungIMTdanBBI();
                calculateAllZScoresFromDB();
            });

            // Initialize calculation jika data sudah ada saat load page
            setTimeout(() => {
                const beratField = document.getElementById('berat_badan');
                const tinggiField = document.getElementById('tinggi_badan');

                if (beratField?.value && tinggiField?.value) {
                    hitungIMTdanBBI();
                    calculateAllZScoresFromDB();
                }
            }, 500);

            //==================================================================================//
            // End of Functions
            //==================================================================================//

        });
    </script>
@endpush
