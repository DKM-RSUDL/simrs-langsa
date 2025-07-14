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
                document.getElementById('namaPenyakit').value = '';
                document.getElementById('namaObat').value = '';
            });

            document.getElementById('btnTambahRiwayatModal')?.addEventListener('click', function() {
                const namaPenyakit = document.getElementById('namaPenyakit').value.trim();
                const namaObat = document.getElementById('namaObat').value.trim();
                const tbody = document.querySelector('#riwayatTable tbody');

                if (namaPenyakit || namaObat) {
                    const riwayatEntry = {
                        penyakit: namaPenyakit || '-',
                        obat: namaObat || '-'
                    };

                    riwayatArray.push(riwayatEntry);

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${namaPenyakit || '-'}</td>
                        <td>${namaObat || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm hapus-riwayat">Hapus</button>
                        </td>
                    `;

                    tbody.appendChild(row);

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

                    updateRiwayatJson();
                    bootstrap.Modal.getInstance(document.getElementById('riwayatModal')).hide();
                } else {
                    alert('Mohon isi setidaknya salah satu field (Penyakit atau Obat)');
                }
            });

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
            function preventEnterSubmit(event) {
                if (event.keyCode === 13 || event.which === 13) {
                    if (event.target.tagName.toLowerCase() !== 'textarea') {
                        event.preventDefault();
                        return false;
                    }
                    else if (event.target.tagName.toLowerCase() === 'textarea' && !event.shiftKey) {
                        return true;
                    }
                }
            }

            const formElements = document.querySelectorAll(
                'input[type="text"], input[type="number"], input[type="date"], input[type="time"], select, textarea'
            );
            formElements.forEach(function(element) {
                element.addEventListener('keypress', preventEnterSubmit);
            });

            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('keypress', function(event) {
                    if (event.keyCode === 13 || event.which === 13) {
                        if (event.target.tagName.toLowerCase() !== 'textarea' &&
                            event.target.type !== 'submit') {
                            event.preventDefault();
                            return false;
                        }
                    }
                });
            }

            //==================================================================================================//
            // Z-Score Calculator untuk Anak berdasarkan standar WHO
            //==================================================================================================//
            let whoDataFromDB = {
                weightForAge: @json($WhoWeightForAge ?? []),
                heightForAge: @json($WhoHeightForAge ?? []),
                bmiForAge: @json($WhoBmiForAge ?? []),
                weightForHeight: @json($WhoWeightForHeight ?? []),
                weightForLength: @json($WhoWeightForLength ?? []),
                headCircumferenceForAge: @json($WhoHeadCircumferenceForAge ?? [])
            };

            function safeParseDecimal(value) {
                if (typeof value === 'number' && !isNaN(value)) {
                    return value;
                }

                if (typeof value === 'string') {
                    const cleaned = value.replace(/['"]/g, '').trim();
                    const parsed = parseFloat(cleaned);
                    return isNaN(parsed) ? null : parsed;
                }

                if (typeof value === 'object' && value !== null) {
                    if (value.hasOwnProperty('value')) return safeParseDecimal(value.value);
                    if (value.hasOwnProperty('val')) return safeParseDecimal(value.val);
                    return null;
                }

                return null;
            }

            function extractLMSValues(dataItem) {
                let L = null, M = null, S = null;

                // Coba field names dengan huruf kecil sesuai model
                if (dataItem.l !== undefined) L = safeParseDecimal(dataItem.l);
                else if (dataItem.L !== undefined) L = safeParseDecimal(dataItem.L);

                if (dataItem.m !== undefined) M = safeParseDecimal(dataItem.m);
                else if (dataItem.M !== undefined) M = safeParseDecimal(dataItem.M);

                if (dataItem.s !== undefined) S = safeParseDecimal(dataItem.s);
                else if (dataItem.S !== undefined) S = safeParseDecimal(dataItem.S);

                if (L === null || M === null || S === null || M === 0 || S === 0) {
                    return null;
                }

                return { L, M, S };
            }

            function hitungBBIFromWHO(tinggiBadan, jenisKelamin, umurBulan) {
                if (!tinggiBadan || !jenisKelamin) {
                    return null;
                }

                let wfhData = null;
                if (umurBulan < 24 && whoDataFromDB.weightForLength && whoDataFromDB.weightForLength.length > 0) {
                    wfhData = whoDataFromDB.weightForLength;
                } else if (whoDataFromDB.weightForHeight && whoDataFromDB.weightForHeight.length > 0) {
                    wfhData = whoDataFromDB.weightForHeight;
                }

                if (!wfhData) {
                    return null;
                }

                const filteredData = wfhData.filter(item => {
                    const itemSex = parseInt(item.sex);
                    return itemSex === jenisKelamin;
                });

                if (filteredData.length === 0) {
                    return null;
                }

                const sample = filteredData[0];
                let heightKey;
                if ('height_cm' in sample) heightKey = 'height_cm';
                else if ('length_cm' in sample) heightKey = 'length_cm';
                else return null;

                filteredData.sort((a, b) => {
                    const aVal = safeParseDecimal(a[heightKey]);
                    const bVal = safeParseDecimal(b[heightKey]);
                    return (aVal || 0) - (bVal || 0);
                });

                // Cari exact match
                const exactMatch = filteredData.find(item => {
                    const itemHeight = safeParseDecimal(item[heightKey]);
                    return itemHeight !== null && Math.abs(itemHeight - tinggiBadan) < 0.1;
                });

                if (exactMatch) {
                    return safeParseDecimal(exactMatch.m) || safeParseDecimal(exactMatch.M);
                }

                // Interpolasi linear
                for (let i = 0; i < filteredData.length - 1; i++) {
                    const current = filteredData[i];
                    const next = filteredData[i + 1];
                    const currentHeight = safeParseDecimal(current[heightKey]);
                    const nextHeight = safeParseDecimal(next[heightKey]);

                    if (currentHeight !== null && nextHeight !== null && 
                        tinggiBadan >= currentHeight && tinggiBadan <= nextHeight) {
                        
                        const currentMedian = safeParseDecimal(current.m) || safeParseDecimal(current.M);
                        const nextMedian = safeParseDecimal(next.m) || safeParseDecimal(next.M);
                        
                        if (currentMedian !== null && nextMedian !== null) {
                            const ratio = (tinggiBadan - currentHeight) / (nextHeight - currentHeight);
                            return currentMedian + ratio * (nextMedian - currentMedian);
                        }
                    }
                }

                // Gunakan nilai terdekat jika di luar range
                const validHeights = filteredData.map(item => safeParseDecimal(item[heightKey])).filter(val => val !== null);
                if (validHeights.length === 0) return null;

                const minHeight = Math.min(...validHeights);
                const maxHeight = Math.max(...validHeights);

                if (tinggiBadan < minHeight) {
                    const firstItem = filteredData.find(item => safeParseDecimal(item[heightKey]) === minHeight);
                    return firstItem ? (safeParseDecimal(firstItem.m) || safeParseDecimal(firstItem.M)) : null;
                }

                if (tinggiBadan > maxHeight) {
                    const lastItem = filteredData.find(item => safeParseDecimal(item[heightKey]) === maxHeight);
                    return lastItem ? (safeParseDecimal(lastItem.m) || safeParseDecimal(lastItem.M)) : null;
                }

                return null;
            }

            function findLMSData(dataArray, sex, ageOrHeight, isHeight = false) {
                if (!dataArray || dataArray.length === 0) {
                    return null;
                }

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

                const filteredData = dataArray.filter(item => {
                    const itemSex = parseInt(item.sex);
                    return itemSex === sex;
                });

                if (filteredData.length === 0) {
                    return null;
                }

                filteredData.sort((a, b) => {
                    const aVal = safeParseDecimal(a[key]);
                    const bVal = safeParseDecimal(b[key]);
                    return (aVal || 0) - (bVal || 0);
                });

                const validValues = filteredData.map(item => safeParseDecimal(item[key])).filter(val => val !== null);
                if (validValues.length === 0) {
                    return null;
                }

                const minVal = Math.min(...validValues);
                const maxVal = Math.max(...validValues);

                const exactMatch = filteredData.find(item => {
                    const itemValue = safeParseDecimal(item[key]);
                    return itemValue !== null && Math.abs(itemValue - ageOrHeight) < 0.1;
                });

                if (exactMatch) {
                    return extractLMSValues(exactMatch);
                }

                if (ageOrHeight < minVal) {
                    return extractLMSValues(filteredData[0]);
                }

                if (ageOrHeight > maxVal) {
                    return extractLMSValues(filteredData[filteredData.length - 1]);
                }

                for (let i = 0; i < filteredData.length - 1; i++) {
                    const current = filteredData[i];
                    const next = filteredData[i + 1];
                    const currentVal = safeParseDecimal(current[key]);
                    const nextVal = safeParseDecimal(next[key]);

                    if (currentVal !== null && nextVal !== null && ageOrHeight >= currentVal && ageOrHeight <= nextVal) {
                        const ratio = (ageOrHeight - currentVal) / (nextVal - currentVal);

                        const currentLMS = extractLMSValues(current);
                        const nextLMS = extractLMSValues(next);

                        if (!currentLMS || !nextLMS) {
                            return null;
                        }

                        return {
                            L: currentLMS.L + ratio * (nextLMS.L - currentLMS.L),
                            M: currentLMS.M + ratio * (nextLMS.M - currentLMS.M),
                            S: currentLMS.S + ratio * (nextLMS.S - currentLMS.S)
                        };
                    }
                }

                return null;
            }

            function calculateZScore(value, L, M, S) {
                if (!value || value <= 0 || !M || M <= 0 || !S || S <= 0) {
                    return null;
                }

                let zScore;

                if (Math.abs(L) < 0.01) {
                    zScore = Math.log(value / M) / S;
                } else {
                    zScore = (Math.pow(value / M, L) - 1) / (L * S);
                }

                if (Math.abs(zScore) > 6) {
                    return null;
                }

                return zScore;
            }

            function determineZScoreStatus(zScore, type) {
                if (zScore === null || isNaN(zScore)) return '';
                
                switch (type) {
                    case 'bb_usia':
                        if (zScore < -3) return 'severely_underweight';
                        if (zScore < -2) return 'underweight';
                        if (zScore > 1) return 'overweight';
                        return 'normal';
                        
                    case 'pb_tb_usia':
                        if (zScore < -3) return 'severely_stunted';
                        if (zScore < -2) return 'stunted';
                        if (zScore > 3) return 'tall';
                        return 'normal';
                        
                    case 'bb_tb':
                        if (zScore < -3) return 'severely_wasted';
                        if (zScore < -2) return 'wasted';
                        if (zScore > 2) return 'obese';
                        if (zScore > 1) return 'overweight';
                        return 'normal';
                        
                    case 'imt_usia':
                        if (zScore < -3) return 'severely_underweight';
                        if (zScore < -2) return 'underweight';
                        if (zScore > 2) return 'obese';
                        if (zScore > 1) return 'overweight';
                        return 'normal';
                        
                    default:
                        return '';
                }
            }

            // Function untuk check stunting status
            function checkStuntingStatus() {
                const bbUsiaZScore = parseFloat(document.querySelector('input[name="bb_usia"]')?.value || 0);
                const pbTbUsiaZScore = parseFloat(document.querySelector('input[name="pb_tb_usia"]')?.value || 0);
                const bbUsiaStatus = document.getElementById('bb_usia_status')?.value || '';
                const pbTbUsiaStatus = document.getElementById('pb_tb_usia_status')?.value || '';
                
                const stuntingSection = document.getElementById('stunting_section');
                const statusStuntingField = document.getElementById('status_stunting');
                
                if (!stuntingSection || !statusStuntingField) return;
                
                // Cek apakah ada status yang tidak normal
                const isAbnormal = (bbUsiaStatus && bbUsiaStatus !== 'normal') || 
                                  (pbTbUsiaStatus && pbTbUsiaStatus !== 'normal');
                
                // Cek apakah kedua Z-Score tersedia
                const hasValidZScores = bbUsiaZScore !== 0 && pbTbUsiaZScore !== 0 && 
                                       !isNaN(bbUsiaZScore) && !isNaN(pbTbUsiaZScore);
                
                if (isAbnormal && hasValidZScores) {
                    // Tampilkan section stunting
                    stuntingSection.style.display = 'block';
                    
                    // Tentukan status stunting berdasarkan perbandingan Z-Score
                    if (bbUsiaZScore < pbTbUsiaZScore) {
                        statusStuntingField.value = 'Stunting';
                        statusStuntingField.style.color = '#dc3545';
                        statusStuntingField.style.backgroundColor = '#f8d7da';
                    } else {
                        statusStuntingField.value = 'Tidak Stunting';
                        statusStuntingField.style.color = '#198754';
                        statusStuntingField.style.backgroundColor = '#d1e7dd';
                    }
                } else {
                    // Sembunyikan section stunting jika semua normal atau data tidak lengkap
                    stuntingSection.style.display = 'none';
                    statusStuntingField.value = '';
                }
            }

            //==================================================================================//
            // Data kalori dan makronutrien
            //==================================================================================//
            const kaloriData = {
                '1': { pria: '110-120', wanita: '110-120', min: 110, max: 120 },
                '2': { pria: '100', wanita: '100', min: 100, max: 100 },
                '3': { pria: '90', wanita: '90', min: 90, max: 90 },
                '4': { pria: '80-90', wanita: '60-80', min_pria: 80, max_pria: 90, min_wanita: 60, max_wanita: 80 },
                '5': { pria: '50-70', wanita: '40-55', min_pria: 50, max_pria: 70, min_wanita: 40, max_wanita: 55 },
                '6': { pria: '40-50', wanita: '40', min_pria: 40, max_pria: 50, min_wanita: 40, max_wanita: 40 }
            };

            const kaloriGiziBurukData = {
                '7': { range: '80-100', min: 80, max: 100 },
                '8': { range: '100-150', min: 100, max: 150 },
                '9': { range: '150-220', min: 150, max: 220 }
            };

            const makronutrienGiziBurukData = {
                '7': {
                    protein: { min: 1, max: 1.5 },
                    lemak: { min: 0.5, max: 1 }
                },
                '8': {
                    protein: { min: 2, max: 3 },
                    lemak: { min: 1, max: 1.5 }
                },
                '9': {
                    protein: { min: 4, max: 6 },
                    lemak: { min: 2, max: 2 } 
                }
            };

            // Function untuk check gizi buruk status
            function checkGiziBurukStatus() {
                const bbTbStatus = document.getElementById('bb_tb_status')?.value || '';
                const isGiziBuruk = bbTbStatus === 'severely_wasted';
                
                // Toggle tampilan berdasarkan status
                toggleGiziBurukMode(isGiziBuruk);
                
                return isGiziBuruk;
            }

            // Function untuk toggle makronutrien mode
            function toggleMakronutrienMode(isGiziBuruk) {
                const makronutrienNormal = document.getElementById('makronutrien_normal');
                const makronutrienGiziBuruk = document.getElementById('makronutrien_gizi_buruk');
                
                if (!makronutrienNormal || !makronutrienGiziBuruk) return;
                
                if (isGiziBuruk) {
                    makronutrienNormal.style.display = 'none';
                    makronutrienGiziBuruk.style.display = 'block';
                    resetMakronutrienGiziBuruk();
                } else {
                    makronutrienNormal.style.display = 'block';
                    makronutrienGiziBuruk.style.display = 'none';
                    resetMakronutrienNormal();
                }
            }

            function resetMakronutrienNormal() {
                const fields = ['protein_gram', 'lemak_gram', 'kh_gram'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }

            function resetMakronutrienGiziBuruk() {
                const fields = ['protein_gram_per_kg', 'protein_gram_total', 'lemak_gram_per_kg', 'lemak_gram_total', 'kh_gram_per_kg', 'kh_gram_total'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
                
                // Reset range info
                const proteinRangeInfo = document.getElementById('protein_range_info');
                const lemakRangeInfo = document.getElementById('lemak_range_info');
                if (proteinRangeInfo) proteinRangeInfo.textContent = 'Rentang: -';
                if (lemakRangeInfo) lemakRangeInfo.textContent = 'Rentang: -';
            }

            // Function untuk toggle mode normal vs gizi buruk
            function toggleGiziBurukMode(isGiziBuruk) {
                const tableNormal = document.getElementById('table_normal');
                const tableGiziBuruk = document.getElementById('table_gizi_buruk');
                const infoNormal = document.getElementById('info_normal');
                const infoGiziBuruk = document.getElementById('info_gizi_buruk');
                const pilihanNormal = document.getElementById('pilihan_normal');
                const pilihanGiziBuruk = document.getElementById('pilihan_gizi_buruk');
                const modePerhitungan = document.getElementById('mode_perhitungan');
                
                // Get kedua select element
                const golonganUmurSelect = document.getElementById('golongan_umur');
                const faseRehabilitasiSelect = document.getElementById('fase_rehabilitasi');
                
                if (!tableNormal || !tableGiziBuruk) return;
                
                if (isGiziBuruk) {
                    // Mode gizi buruk
                    tableNormal.style.display = 'none';
                    tableGiziBuruk.style.display = 'block';
                    if (infoNormal) infoNormal.style.display = 'none';
                    if (infoGiziBuruk) infoGiziBuruk.style.display = 'block';
                    if (pilihanNormal) pilihanNormal.style.display = 'none';
                    if (pilihanGiziBuruk) pilihanGiziBuruk.style.display = 'block';
                    if (modePerhitungan) modePerhitungan.value = 'gizi_buruk';
                    
                    // Disable select normal dan reset nilainya
                    if (golonganUmurSelect) {
                        golonganUmurSelect.disabled = true;
                        golonganUmurSelect.value = '';
                    }
                    
                    // Enable select fase rehabilitasi
                    if (faseRehabilitasiSelect) {
                        faseRehabilitasiSelect.disabled = false;
                    }
                    
                    // Toggle makronutrien mode
                    toggleMakronutrienMode(true);
                    
                } else {
                    // Mode normal
                    tableNormal.style.display = 'block';
                    tableGiziBuruk.style.display = 'none';
                    if (infoNormal) infoNormal.style.display = 'block';
                    if (infoGiziBuruk) infoGiziBuruk.style.display = 'none';
                    if (pilihanNormal) pilihanNormal.style.display = 'block';
                    if (pilihanGiziBuruk) pilihanGiziBuruk.style.display = 'none';
                    if (modePerhitungan) modePerhitungan.value = 'normal';
                    
                    // Enable select normal
                    if (golonganUmurSelect) {
                        golonganUmurSelect.disabled = false;
                    }
                    
                    // Disable select fase dan reset nilainya
                    if (faseRehabilitasiSelect) {
                        faseRehabilitasiSelect.disabled = true;
                        faseRehabilitasiSelect.value = '';
                    }
                    
                    // Toggle makronutrien mode
                    toggleMakronutrienMode(false);
                }
                
                // Reset form kalori
                resetKaloriForm();
            }

            // Function untuk reset form kalori
            function resetKaloriForm() {
                const fields = ['rentang_kalori', 'kebutuhan_kalori_per_kg', 'total_kebutuhan_kalori', 'protein_gram', 'lemak_gram', 'kh_gram'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
                
                const kebutuhanKaloriField = document.getElementById('kebutuhan_kalori_per_kg');
                if (kebutuhanKaloriField) {
                    kebutuhanKaloriField.disabled = true;
                }
            }

            // Function untuk update makronutrien range saat fase berubah
            function updateMakronutrienRange() {
                const faseRehabilitasi = document.getElementById('fase_rehabilitasi')?.value;
                const proteinField = document.getElementById('protein_gram_per_kg');
                const lemakField = document.getElementById('lemak_gram_per_kg');
                const proteinRangeInfo = document.getElementById('protein_range_info');
                const lemakRangeInfo = document.getElementById('lemak_range_info');
                
                if (!faseRehabilitasi || !proteinField || !lemakField) return;
                
                const makronutrienInfo = makronutrienGiziBurukData[faseRehabilitasi];
                if (!makronutrienInfo) return;
                
                // Set range untuk protein
                proteinField.min = makronutrienInfo.protein.min;
                proteinField.max = makronutrienInfo.protein.max;
                proteinField.placeholder = `${makronutrienInfo.protein.min}-${makronutrienInfo.protein.max}`;
                if (proteinRangeInfo) {
                    proteinRangeInfo.textContent = `Rentang: ${makronutrienInfo.protein.min}-${makronutrienInfo.protein.max} gr/kg BB`;
                }
                
                // Set range untuk lemak
                lemakField.min = makronutrienInfo.lemak.min;
                lemakField.max = makronutrienInfo.lemak.max;
                if (makronutrienInfo.lemak.min === makronutrienInfo.lemak.max) {
                    lemakField.value = makronutrienInfo.lemak.min;
                    lemakField.placeholder = makronutrienInfo.lemak.min.toString();
                    if (lemakRangeInfo) {
                        lemakRangeInfo.textContent = `Nilai: ${makronutrienInfo.lemak.min} gr/kg BB (tetap)`;
                    }
                } else {
                    lemakField.placeholder = `${makronutrienInfo.lemak.min}-${makronutrienInfo.lemak.max}`;
                    if (lemakRangeInfo) {
                        lemakRangeInfo.textContent = `Rentang: ${makronutrienInfo.lemak.min}-${makronutrienInfo.lemak.max} gr/kg BB`;
                    }
                }
                
                // Set default values
                if (makronutrienInfo.protein.min === makronutrienInfo.protein.max) {
                    proteinField.value = makronutrienInfo.protein.min;
                } else {
                    proteinField.value = (makronutrienInfo.protein.min + makronutrienInfo.protein.max) / 2;
                }
                
                // Hitung makronutrien
                calculateMakronutrienGiziBuruk();
            }

            // Function untuk hitung makronutrien gizi buruk
            function calculateMakronutrienGiziBuruk() {
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
                const totalKalori = parseFloat(document.getElementById('total_kebutuhan_kalori')?.value || 0);
                const proteinPerKg = parseFloat(document.getElementById('protein_gram_per_kg')?.value || 0);
                const lemakPerKg = parseFloat(document.getElementById('lemak_gram_per_kg')?.value || 0);
                
                if (!beratBadan || !totalKalori) {
                    resetMakronutrienGiziBuruk();
                    return;
                }
                
                // Hitung total protein dan lemak
                const proteinTotal = proteinPerKg * beratBadan;
                const lemakTotal = lemakPerKg * beratBadan;
                
                // Hitung kalori dari protein dan lemak
                const kaloriProtein = proteinTotal * 4; // 1g protein = 4 kkal
                const kaloriLemak = lemakTotal * 9; // 1g lemak = 9 kkal
                
                // Hitung sisa kalori untuk karbohidrat
                const sisaKalori = totalKalori - kaloriProtein - kaloriLemak;
                const karbohidratTotal = Math.max(0, sisaKalori / 4); // 1g karbohidrat = 4 kkal
                const karbohidratPerKg = beratBadan > 0 ? karbohidratTotal / beratBadan : 0;
                
                // Update fields
                const proteinTotalField = document.getElementById('protein_gram_total');
                const lemakTotalField = document.getElementById('lemak_gram_total');
                const khPerKgField = document.getElementById('kh_gram_per_kg');
                const khTotalField = document.getElementById('kh_gram_total');
                
                if (proteinTotalField) proteinTotalField.value = proteinTotal.toFixed(1);
                if (lemakTotalField) lemakTotalField.value = lemakTotal.toFixed(1);
                if (khPerKgField) khPerKgField.value = karbohidratPerKg.toFixed(1);
                if (khTotalField) khTotalField.value = karbohidratTotal.toFixed(1);
                
                // Update field tersembunyi untuk kompatibilitas dengan form submission
                const proteinGramField = document.getElementById('protein_gram');
                const lemakGramField = document.getElementById('lemak_gram');
                const khGramField = document.getElementById('kh_gram');
                
                if (proteinGramField) proteinGramField.value = proteinTotal.toFixed(1);
                if (lemakGramField) lemakGramField.value = lemakTotal.toFixed(1);
                if (khGramField) khGramField.value = karbohidratTotal.toFixed(1);
            }

            function updateZScoreStatus(zScore, statusFieldId, type) {
                const statusField = document.getElementById(statusFieldId);
                if (statusField) {
                    const status = determineZScoreStatus(zScore, type);
                    statusField.value = status;
                    
                    // Check stunting status
                    setTimeout(checkStuntingStatus, 100);
                    
                    // Check gizi buruk status
                    if (statusFieldId === 'bb_tb_status') {
                        setTimeout(checkGiziBurukStatus, 150);
                    }
                }
            }

            function hitungIMTdanBBI() {
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan')?.value || 0);
                const umurBulan = parseFloat(document.querySelector('input[name="umur_bulan"]')?.value || 0);
                const jenisKelamin = parseInt(document.getElementById('jenis_kelamin_who')?.value || 0);

                if (beratBadan && tinggiBadan) {
                    const tinggiMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiMeter * tinggiMeter);

                    if (tinggiBadan && jenisKelamin && umurBulan !== null) {
                        const bbi = hitungBBIFromWHO(tinggiBadan, jenisKelamin, umurBulan);
                        const bbiField = document.getElementById('bbi');
                        if (bbiField && bbi !== null) {
                            bbiField.value = bbi.toFixed(1);
                        } else if (bbiField) {
                            bbiField.value = '';
                        }
                    }
                }
            }

            function calculateAllZScoresFromDB() {
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan')?.value || 0);
                const umurBulan = parseFloat(document.querySelector('input[name="umur_bulan"]')?.value || 0);
                const jenisKelamin = parseInt(document.getElementById('jenis_kelamin_who')?.value || 0);

                if (!beratBadan || !tinggiBadan || !umurBulan || !jenisKelamin) {
                    return;
                }

                if (beratBadan <= 0 || beratBadan > 100 || tinggiBadan <= 0 || tinggiBadan > 200 || umurBulan < 0 || umurBulan > 240) {
                    return;
                }

                const tinggiMeter = tinggiBadan / 100;
                const imt = beratBadan / (tinggiMeter * tinggiMeter);

                try {
                    // Weight-for-Age Z-Score
                    if (whoDataFromDB.weightForAge && whoDataFromDB.weightForAge.length > 0) {
                        const wfaLMS = findLMSData(whoDataFromDB.weightForAge, jenisKelamin, umurBulan);
                        if (wfaLMS) {
                            const wfaZScore = calculateZScore(beratBadan, wfaLMS.L, wfaLMS.M, wfaLMS.S);
                            if (wfaZScore !== null) {
                                const bbUsiaField = document.querySelector('input[name="bb_usia"]');
                                if (bbUsiaField) {
                                    bbUsiaField.value = wfaZScore.toFixed(2);
                                }
                                updateZScoreStatus(wfaZScore, 'bb_usia_status', 'bb_usia');
                            }
                        }
                    }

                    // Height-for-Age Z-Score
                    if (whoDataFromDB.heightForAge && whoDataFromDB.heightForAge.length > 0) {
                        const hfaLMS = findLMSData(whoDataFromDB.heightForAge, jenisKelamin, umurBulan);
                        if (hfaLMS) {
                            const hfaZScore = calculateZScore(tinggiBadan, hfaLMS.L, hfaLMS.M, hfaLMS.S);
                            if (hfaZScore !== null) {
                                const pbTbUsiaField = document.querySelector('input[name="pb_tb_usia"]');
                                if (pbTbUsiaField) {
                                    pbTbUsiaField.value = hfaZScore.toFixed(2);
                                }
                                updateZScoreStatus(hfaZScore, 'pb_tb_usia_status', 'pb_tb_usia');
                            }
                        }
                    }

                    // Weight-for-Height Z-Score
                    let wfhData = null;
                    if (umurBulan < 24 && whoDataFromDB.weightForLength && whoDataFromDB.weightForLength.length > 0) {
                        wfhData = whoDataFromDB.weightForLength;
                    } else if (whoDataFromDB.weightForHeight && whoDataFromDB.weightForHeight.length > 0) {
                        wfhData = whoDataFromDB.weightForHeight;
                    }

                    if (wfhData) {
                        const wfhLMS = findLMSData(wfhData, jenisKelamin, tinggiBadan, true);
                        if (wfhLMS) {
                            const wfhZScore = calculateZScore(beratBadan, wfhLMS.L, wfhLMS.M, wfhLMS.S);
                            if (wfhZScore !== null) {
                                const bbTbField = document.querySelector('input[name="bb_tb"]');
                                if (bbTbField) {
                                    bbTbField.value = wfhZScore.toFixed(2);
                                }
                                updateZScoreStatus(wfhZScore, 'bb_tb_status', 'bb_tb');
                            }
                        }
                    }

                    // BMI-for-Age Z-Score
                    if (whoDataFromDB.bmiForAge && whoDataFromDB.bmiForAge.length > 0) {
                        const bmiLMS = findLMSData(whoDataFromDB.bmiForAge, jenisKelamin, umurBulan);
                        if (bmiLMS) {
                            const bmiZScore = calculateZScore(imt, bmiLMS.L, bmiLMS.M, bmiLMS.S);
                            if (bmiZScore !== null) {
                                const imtUsiaField = document.querySelector('input[name="imt_usia"]');
                                if (imtUsiaField) {
                                    imtUsiaField.value = bmiZScore.toFixed(2);
                                }
                                updateZScoreStatus(bmiZScore, 'imt_usia_status', 'imt_usia');
                            }
                        }
                    }
                } catch (error) {
                    // Silent error handling
                }
            }

            function updateKaloriRange() {
                const modePerhitungan = document.getElementById('mode_perhitungan')?.value || 'normal';
                const rentangKaloriField = document.getElementById('rentang_kalori');
                const kebutuhanKaloriField = document.getElementById('kebutuhan_kalori_per_kg');
                
                if (!rentangKaloriField || !kebutuhanKaloriField) return;
                
                if (modePerhitungan === 'gizi_buruk') {
                    // Mode gizi buruk - ambil nilai dari fase_rehabilitasi
                    const faseRehabilitasi = document.getElementById('fase_rehabilitasi')?.value;
                    
                    if (!faseRehabilitasi) {
                        resetKaloriForm();
                        return;
                    }
                    
                    const kaloriInfo = kaloriGiziBurukData[faseRehabilitasi];
                    if (!kaloriInfo) return;
                    
                    rentangKaloriField.value = kaloriInfo.range;
                    
                    kebutuhanKaloriField.min = kaloriInfo.min;
                    kebutuhanKaloriField.max = kaloriInfo.max;
                    kebutuhanKaloriField.disabled = false;
                    kebutuhanKaloriField.placeholder = `Masukkan nilai antara ${kaloriInfo.min}-${kaloriInfo.max}`;
                    kebutuhanKaloriField.value = Math.round((kaloriInfo.min + kaloriInfo.max) / 2);
                    
                } else {
                    // Mode normal - ambil nilai dari golongan_umur
                    const golonganUmur = document.getElementById('golongan_umur')?.value;
                    const jenisKelamin = parseInt(document.getElementById('jenis_kelamin_who')?.value || 0);
                    
                    if (!golonganUmur || !jenisKelamin) {
                        resetKaloriForm();
                        return;
                    }

                    const genderKey = jenisKelamin === 1 ? 'pria' : 'wanita';
                    const kaloriInfo = kaloriData[golonganUmur];
                    
                    if (!kaloriInfo) return;

                    rentangKaloriField.value = kaloriInfo[genderKey];
                    
                    let minVal, maxVal;
                    if (kaloriInfo[`min_${genderKey}`] !== undefined) {
                        minVal = kaloriInfo[`min_${genderKey}`];
                        maxVal = kaloriInfo[`max_${genderKey}`];
                    } else {
                        minVal = kaloriInfo.min;
                        maxVal = kaloriInfo.max;
                    }
                    
                    kebutuhanKaloriField.min = minVal;
                    kebutuhanKaloriField.max = maxVal;
                    kebutuhanKaloriField.disabled = false;
                    kebutuhanKaloriField.placeholder = `Masukkan nilai antara ${minVal}-${maxVal}`;
                    
                    if (minVal === maxVal) {
                        kebutuhanKaloriField.value = minVal;
                    } else {
                        kebutuhanKaloriField.value = Math.round((minVal + maxVal) / 2);
                    }
                }
                
                // Hitung total kalori
                calculateTotalNutrition();
            }

            function calculateTotalNutrition() {
                const kaloriPerKg = parseFloat(document.getElementById('kebutuhan_kalori_per_kg')?.value || 0);
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
                
                if (!kaloriPerKg || !beratBadan) {
                    const fields = ['total_kebutuhan_kalori', 'protein_gram', 'lemak_gram', 'kh_gram'];
                    fields.forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (field) field.value = '';
                    });
                    return;
                }
                
                const totalKalori = kaloriPerKg * beratBadan;
                const totalKaloriField = document.getElementById('total_kebutuhan_kalori');
                if (totalKaloriField) {
                    totalKaloriField.value = totalKalori.toFixed(0);
                }
                
                calculateMacronutrients(totalKalori);
            }
            
            function calculateMacronutrients(totalKalori = null) {
                const modePerhitungan = document.getElementById('mode_perhitungan')?.value || 'normal';
                
                if (modePerhitungan === 'gizi_buruk') {
                    calculateMakronutrienGiziBuruk();
                    return;
                }
                
                // Mode normal - gunakan persentase
                if (!totalKalori) {
                    const totalKaloriField = document.getElementById('total_kebutuhan_kalori');
                    totalKalori = parseFloat(totalKaloriField?.value || 0);
                }
                
                if (!totalKalori) return;
                
                const proteinPersen = parseFloat(document.getElementById('protein_persen')?.value || 0);
                const lemakPersen = parseFloat(document.getElementById('lemak_persen')?.value || 0);
                const khPersen = parseFloat(document.getElementById('kh_persen')?.value || 0);
                
                if (proteinPersen > 0) {
                    const proteinGram = (totalKalori * proteinPersen / 100) / 4;
                    const proteinField = document.getElementById('protein_gram');
                    if (proteinField) proteinField.value = proteinGram.toFixed(1);
                }
                
                if (lemakPersen > 0) {
                    const lemakGram = (totalKalori * lemakPersen / 100) / 9;
                    const lemakField = document.getElementById('lemak_gram');
                    if (lemakField) lemakField.value = lemakGram.toFixed(1);
                }
                
                if (khPersen > 0) {
                    const khGram = (totalKalori * khPersen / 100) / 4;
                    const khField = document.getElementById('kh_gram');
                    if (khField) khField.value = khGram.toFixed(1);
                }
            }

            function autoSelectAgeGroup() {
                const umurBulan = parseFloat(document.querySelector('input[name="umur_bulan"]')?.value || 0);
                const umurTahun = umurBulan / 12;
                
                let selectedGroup = '';
                if (umurTahun <= 1) selectedGroup = '1';
                else if (umurTahun <= 3) selectedGroup = '2';
                else if (umurTahun <= 6) selectedGroup = '3';
                else if (umurTahun <= 9) selectedGroup = '4';
                else if (umurTahun <= 13) selectedGroup = '5';
                else if (umurTahun <= 18) selectedGroup = '6';
                
                const golonganUmurField = document.getElementById('golongan_umur');
                const modePerhitungan = document.getElementById('mode_perhitungan')?.value || 'normal';
                
                // Hanya set jika dalam mode normal dan field tidak disabled
                if (selectedGroup && golonganUmurField && modePerhitungan === 'normal' && !golonganUmurField.disabled) {
                    golonganUmurField.value = selectedGroup;
                    updateKaloriRange();
                }
            }

            // Event listeners untuk Z-Score
            const beratBadanField = document.getElementById('berat_badan');
            const tinggiBadanField = document.getElementById('tinggi_badan');

            if (beratBadanField) {
                beratBadanField.addEventListener('input', function() {
                    hitungIMTdanBBI();
                    calculateAllZScoresFromDB();
                });
            }

            if (tinggiBadanField) {
                tinggiBadanField.addEventListener('input', function() {
                    hitungIMTdanBBI();
                    calculateAllZScoresFromDB();
                });
            }

            setTimeout(() => {
                if (beratBadanField?.value && tinggiBadanField?.value) {
                    hitungIMTdanBBI();
                    calculateAllZScoresFromDB();
                }
            }, 1000);

            // Event listeners untuk kalori dan nutrisi
            document.getElementById('golongan_umur')?.addEventListener('change', function() {
                if (!this.disabled) {
                    updateKaloriRange();
                }
            });

            document.getElementById('fase_rehabilitasi')?.addEventListener('change', function() {
                if (!this.disabled) {
                    updateKaloriRange();
                    updateMakronutrienRange();
                }
            });
            
            document.getElementById('kebutuhan_kalori_per_kg')?.addEventListener('input', function() {
                const value = parseInt(this.value);
                const min = parseInt(this.min);
                const max = parseInt(this.max);
                
                if (value < min || value > max) {
                    this.setCustomValidity(`Nilai harus antara ${min} - ${max}`);
                } else {
                    this.setCustomValidity('');
                }
                
                calculateTotalNutrition();
            });
            
            document.getElementById('protein_persen')?.addEventListener('input', function() {
                calculateMacronutrients();
            });
            
            document.getElementById('lemak_persen')?.addEventListener('input', function() {
                calculateMacronutrients();
            });
            
            document.getElementById('kh_persen')?.addEventListener('input', function() {
                calculateMacronutrients();
            });
            
            document.getElementById('berat_badan')?.addEventListener('input', function() {
                setTimeout(calculateTotalNutrition, 100);
            });

            // Event listeners untuk makronutrien gizi buruk
            document.getElementById('protein_gram_per_kg')?.addEventListener('input', function() {
                const faseRehabilitasi = document.getElementById('fase_rehabilitasi')?.value;
                if (!faseRehabilitasi) return;
                
                const makronutrienInfo = makronutrienGiziBurukData[faseRehabilitasi];
                if (!makronutrienInfo) return;
                
                const value = parseFloat(this.value);
                const min = makronutrienInfo.protein.min;
                const max = makronutrienInfo.protein.max;
                
                if (value < min || value > max) {
                    this.setCustomValidity(`Nilai harus antara ${min} - ${max} gr/kg BB`);
                } else {
                    this.setCustomValidity('');
                }
                
                calculateMakronutrienGiziBuruk();
            });
            
            document.getElementById('lemak_gram_per_kg')?.addEventListener('input', function() {
                const faseRehabilitasi = document.getElementById('fase_rehabilitasi')?.value;
                if (!faseRehabilitasi) return;
                
                const makronutrienInfo = makronutrienGiziBurukData[faseRehabilitasi];
                if (!makronutrienInfo) return;
                
                const value = parseFloat(this.value);
                const min = makronutrienInfo.lemak.min;
                const max = makronutrienInfo.lemak.max;
                
                if (value < min || value > max) {
                    this.setCustomValidity(`Nilai harus antara ${min} - ${max} gr/kg BB`);
                } else {
                    this.setCustomValidity('');
                }
                
                calculateMakronutrienGiziBuruk();
            });

            // Monitor perubahan status untuk stunting dan gizi buruk
            const bbUsiaField = document.querySelector('input[name="bb_usia"]');
            const pbTbUsiaField = document.querySelector('input[name="pb_tb_usia"]');
            const bbUsiaStatusField = document.getElementById('bb_usia_status');
            const pbTbUsiaStatusField = document.getElementById('pb_tb_usia_status');
            const bbTbStatusField = document.getElementById('bb_tb_status');
            
            if (bbUsiaField) {
                bbUsiaField.addEventListener('change', checkStuntingStatus);
            }
            
            if (pbTbUsiaField) {
                pbTbUsiaField.addEventListener('change', checkStuntingStatus);
            }
            
            if (bbUsiaStatusField) {
                bbUsiaStatusField.addEventListener('change', checkStuntingStatus);
            }
            
            if (pbTbUsiaStatusField) {
                pbTbUsiaStatusField.addEventListener('change', checkStuntingStatus);
            }

            if (bbTbStatusField) {
                bbTbStatusField.addEventListener('change', checkGiziBurukStatus);
            }

            // Auto-select age group on page load
            setTimeout(autoSelectAgeGroup, 1500);

        });
    </script>
@endpush