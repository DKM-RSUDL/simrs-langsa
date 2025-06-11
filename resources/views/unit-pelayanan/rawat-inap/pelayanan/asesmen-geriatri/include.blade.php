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
            min-width: 300px;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
            z-index: 1000;
            transform: translateY(5px);
            max-height: 400px;
            overflow-y: auto;
        }

        /* Style untuk checkbox asesmen geriatri */
        .form-check-input:checked[name*="adl"],
        .form-check-input:checked[name*="kognitif"],
        .form-check-input:checked[name*="depresi"],
        .form-check-input:checked[name*="inkontinensia"],
        .form-check-input:checked[name*="insomnia"],
        .form-check-input:checked[name*="kategori_imt"] {
            background-color: #097dd6;
            border-color: #097dd6;
        }

    </style>
@endpush

@push('js')
    <script>
        //====================================================================================//

        document.addEventListener('DOMContentLoaded', function() {

            // Cek apakah elemen skala nyeri ada sebelum menambahkan event listener
            const skalaNyeriInput = document.getElementById('skala_nyeri');
            if (skalaNyeriInput) {
                skalaNyeriInput.addEventListener('input', function() {
                    const nilai = parseInt(this.value);
                    const kategoriField = document.getElementById('kategori_nyeri');
                    
                    if (kategoriField) {
                        if (nilai >= 1 && nilai <= 3) {
                            kategoriField.value = 'Nyeri Ringan';
                        } else if (nilai >= 4 && nilai <= 6) {
                            kategoriField.value = 'Nyeri Sedang';
                        } else if (nilai >= 7 && nilai <= 9) {
                            kategoriField.value = 'Nyeri Berat';
                        } else if (nilai === 10) {
                            kategoriField.value = 'Nyeri Tak Tertahankan';
                        } else {
                            kategoriField.value = '';
                        }
                    }
                });
            }

            //====================================================================================//
            // BMI Calculator dan Kategori IMT
            //====================================================================================//

            function calculateBMI() {
                const beratBadanInput = document.getElementById('berat_badan');
                const tinggiBadanInput = document.getElementById('tinggi_badan');
                const imtField = document.getElementById('imt');
                
                if (!beratBadanInput || !tinggiBadanInput || !imtField) return;
                
                const beratBadan = parseFloat(beratBadanInput.value);
                const tinggiBadan = parseFloat(tinggiBadanInput.value);
                
                // Reset semua checkbox kategori IMT
                const kategoriCheckboxes = document.querySelectorAll('input[name="kategori_imt[]"]');
                kategoriCheckboxes.forEach(checkbox => checkbox.checked = false);

                if (beratBadan && tinggiBadan && beratBadan > 0 && tinggiBadan > 0) {
                    // Konversi tinggi badan dari cm ke meter
                    const tinggiBadanMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiBadanMeter * tinggiBadanMeter);
                    
                    // Tampilkan hasil IMT dengan 2 desimal
                    imtField.value = imt.toFixed(2);

                    // Tentukan kategori dan centang checkbox yang sesuai
                    if (imt < 18.0) {
                        const underweightCheckbox = document.getElementById('underweight');
                        if (underweightCheckbox) underweightCheckbox.checked = true;
                    } else if (imt >= 18.0 && imt <= 22.9) {
                        const normoweightCheckbox = document.getElementById('normoweight');
                        if (normoweightCheckbox) normoweightCheckbox.checked = true;
                    } else if (imt >= 23.0 && imt <= 24.9) {
                        const overweightCheckbox = document.getElementById('overweight');
                        if (overweightCheckbox) overweightCheckbox.checked = true;
                    } else if (imt >= 25.0 && imt <= 30.0) {
                        const obeseCheckbox = document.getElementById('obese');
                        if (obeseCheckbox) obeseCheckbox.checked = true;
                    } else if (imt > 30) {
                        const morbidObeseCheckbox = document.getElementById('morbid_obese');
                        if (morbidObeseCheckbox) morbidObeseCheckbox.checked = true;
                    }
                } else {
                    imtField.value = '';
                }
            }

            // Event listener untuk kalkulasi BMI
            const beratBadanInput = document.getElementById('berat_badan');
            const tinggiBadanInput = document.getElementById('tinggi_badan');
            
            if (beratBadanInput) {
                beratBadanInput.addEventListener('input', calculateBMI);
            }
            if (tinggiBadanInput) {
                tinggiBadanInput.addEventListener('input', calculateBMI);
            }

            //====================================================================================//
            // Checkbox handling untuk asesmen geriatri (mutual exclusive)
            //====================================================================================//

            // Fungsi untuk membuat checkbox saling eksklusif dalam grup yang sama
            function setupMutualExclusiveCheckboxes(groupName) {
                const checkboxes = document.querySelectorAll(`input[name="${groupName}[]"]`);
                
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            // Uncheck semua checkbox lain dalam grup yang sama
                            checkboxes.forEach(otherCheckbox => {
                                if (otherCheckbox !== this) {
                                    otherCheckbox.checked = false;
                                }
                            });
                        }
                    });
                });
            }

            // Setup untuk semua grup checkbox asesmen geriatri - cek dulu apakah elemen ada
            if (document.querySelector('input[name="adl[]"]')) {
                setupMutualExclusiveCheckboxes('adl');
            }
            if (document.querySelector('input[name="kognitif[]"]')) {
                setupMutualExclusiveCheckboxes('kognitif');
            }
            if (document.querySelector('input[name="depresi[]"]')) {
                setupMutualExclusiveCheckboxes('depresi');
            }
            if (document.querySelector('input[name="inkontinensia[]"]')) {
                setupMutualExclusiveCheckboxes('inkontinensia');
            }
            if (document.querySelector('input[name="insomnia[]"]')) {
                setupMutualExclusiveCheckboxes('insomnia');
            }

            // Untuk kategori IMT, biarkan hanya satu yang bisa dipilih
            const kategoriImtCheckboxes = document.querySelectorAll('input[name="kategori_imt[]"]');
            if (kategoriImtCheckboxes.length > 0) {
                kategoriImtCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            kategoriImtCheckboxes.forEach(otherCheckbox => {
                                if (otherCheckbox !== this) {
                                    otherCheckbox.checked = false;
                                }
                            });
                        }
                    });
                });
            }


            //====================================================================================//
            // Checkbox handling untuk asesmen geriatri (mutual exclusive)
            //====================================================================================//

            // Fungsi untuk membuat checkbox saling eksklusif dalam grup yang sama
            function setupMutualExclusiveCheckboxes(groupName) {
                const checkboxes = document.querySelectorAll(`input[name="${groupName}[]"]`);
                
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            // Uncheck semua checkbox lain dalam grup yang sama
                            checkboxes.forEach(otherCheckbox => {
                                if (otherCheckbox !== this) {
                                    otherCheckbox.checked = false;
                                }
                            });
                        }
                    });
                });
            }

            // Setup untuk semua grup checkbox asesmen geriatri - cek dulu apakah elemen ada
            if (document.querySelector('input[name="adl[]"]')) {
                setupMutualExclusiveCheckboxes('adl');
            }
            if (document.querySelector('input[name="kognitif[]"]')) {
                setupMutualExclusiveCheckboxes('kognitif');
            }
            if (document.querySelector('input[name="depresi[]"]')) {
                setupMutualExclusiveCheckboxes('depresi');
            }
            if (document.querySelector('input[name="inkontinensia[]"]')) {
                setupMutualExclusiveCheckboxes('inkontinensia');
            }
            if (document.querySelector('input[name="insomnia[]"]')) {
                setupMutualExclusiveCheckboxes('insomnia');
            }

            //====================================================================================//
            // Pemeriksaan Fisik (ditambahkan pengecekan null)
            //===================================================================================//

            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector(
                        '.form-check-input');
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
                    const keteranganDiv = this.closest('.pemeriksaan-item')?.querySelector(
                        '.keterangan');
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


            //====================================================================================//
            // Event handler untuk tombol Tambah Riwayat
            //====================================================================================// 
            let riwayatArray = [];

            function updateRiwayatJson() {
                const riwayatJsonInput = document.getElementById('riwayatJson');
                if (riwayatJsonInput) {
                    riwayatJsonInput.value = JSON.stringify(riwayatArray);
                }
            }

            const btnTambahRiwayat = document.getElementById('btnTambahRiwayat');
            if (btnTambahRiwayat) {
                btnTambahRiwayat.addEventListener('click', function() {
                    // Reset input di modal saat dibuka
                    const namaPenyakitInput = document.getElementById('namaPenyakit');
                    const namaObatInput = document.getElementById('namaObat');
                    if (namaPenyakitInput) namaPenyakitInput.value = '';
                    if (namaObatInput) namaObatInput.value = '';
                });
            }

            const btnTambahRiwayatModal = document.getElementById('btnTambahRiwayatModal');
            if (btnTambahRiwayatModal) {
                btnTambahRiwayatModal.addEventListener('click', function() {
                    const namaPenyakitInput = document.getElementById('namaPenyakit');
                    const namaObatInput = document.getElementById('namaObat');
                    const tbody = document.querySelector('#riwayatTable tbody');
                    
                    if (!namaPenyakitInput || !namaObatInput || !tbody) return;
                    
                    const namaPenyakit = namaPenyakitInput.value.trim();
                    const namaObat = namaObatInput.value.trim();

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
                        const hapusButton = row.querySelector('.hapus-riwayat');
                        if (hapusButton) {
                            hapusButton.addEventListener('click', function() {
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
                        }

                        // Update hidden input
                        updateRiwayatJson();

                        // Tutup modal
                        const riwayatModalElement = document.getElementById('riwayatModal');
                        if (riwayatModalElement && typeof bootstrap !== 'undefined') {
                            const modalInstance = bootstrap.Modal.getInstance(riwayatModalElement);
                            if (modalInstance) modalInstance.hide();
                        }
                    } else {
                        alert('Mohon isi setidaknya salah satu field (Penyakit atau Obat)');
                    }
                });
            }

            // Reset modal saat ditutup
            const riwayatModal = document.getElementById('riwayatModal');
            if (riwayatModal) {
                riwayatModal.addEventListener('hidden.bs.modal', function() {
                    const namaPenyakitInput = document.getElementById('namaPenyakit');
                    const namaObatInput = document.getElementById('namaObat');
                    if (namaPenyakitInput) namaPenyakitInput.value = '';
                    if (namaObatInput) namaObatInput.value = '';
                });
            }



            //====================================================================================//
            // 5. Inisialisasi Discharge Planning
            //==================================================================================================//
            const dischargePlanningSection = document.getElementById('discharge-planning');
            if (dischargePlanningSection) {
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

                    // Jika belum semua dipilih, sembunyikan kedua alert
                    if (!allSelected) {
                        if (alertInfo) alertInfo.style.display = 'block';
                        if (alertWarning) alertWarning.style.display = 'none';
                        if (alertSuccess) alertSuccess.style.display = 'none';
                        if (kesimpulanInput) kesimpulanInput.value = 'Pilih semua Planning';
                        return;
                    }

                    // Update tampilan kesimpulan
                    if (needsSpecialPlan) {
                        if (alertWarning) alertWarning.style.display = 'block';
                        if (alertSuccess) alertSuccess.style.display = 'none';
                        if (alertInfo) alertInfo.style.display = 'none';
                        if (kesimpulanInput) kesimpulanInput.value = 'Mebutuhkan rencana pulang khusus';
                    } else {
                        if (alertWarning) alertWarning.style.display = 'none';
                        if (alertSuccess) alertSuccess.style.display = 'block';
                        if (alertInfo) alertInfo.style.display = 'none';
                        if (kesimpulanInput) kesimpulanInput.value = 'Tidak mebutuhkan rencana pulang khusus';
                    }
                }

                allSelects.forEach(select => {
                    select.addEventListener('change', updateDischargePlanningConclusion);
                });

                updateDischargePlanningConclusion();
            }



            //==================================================================================================//
            // 6. Inisialisasi Diagnosis Banding dan Kerja
            //==================================================================================================//
            // Cek apakah elemen diagnosis ada sebelum inisialisasi
            if (document.getElementById('diagnosis-banding-input')) {
                initDiagnosisManagement('diagnosis-banding', 'diagnosis_banding');
            }
            if (document.getElementById('diagnosis-kerja-input')) {
                initDiagnosisManagement('diagnosis-kerja', 'diagnosis_kerja');
            }

            function initDiagnosisManagement(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                
                if (!inputField || !addButton || !listContainer || !hiddenInput) {
                    return; // Exit jika elemen tidak ditemukan
                }
                
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

                // Database options - cek apakah variable ada
                let diagnosisOptions = [];
                try {
                    const dbMasterDiagnosis = @if(isset($rmeMasterDiagnosis)){!! json_encode($rmeMasterDiagnosis->pluck('nama_diagnosis')) !!}@else[]@endif;
                    diagnosisOptions = dbMasterDiagnosis.map(text => ({
                        id: text.toLowerCase().replace(/\s+/g, '_'),
                        text: text
                    }));
                } catch (e) {
                    diagnosisOptions = [];
                }

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

        });
    </script>
@endpush