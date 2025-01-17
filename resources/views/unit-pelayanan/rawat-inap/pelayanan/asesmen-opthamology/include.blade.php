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
                    const keteranganDiv = this.closest('.pemeriksaan-item').querySelector(
                        '.keterangan');
                    if (this.checked) {
                        keteranganDiv.style.display = 'none';
                        keteranganDiv.querySelector('input').value = ''; // Reset input value
                    }
                });
            });

            // Inisialisasi semua checkbox sebagai checked dan sembunyikan keterangan
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.checked = true;
                const keteranganDiv = checkbox.closest('.pemeriksaan-item').querySelector('.keterangan');
                if (keteranganDiv) {
                    keteranganDiv.style.display = 'none';
                    const input = keteranganDiv.querySelector('input');
                    if (input) input.value = '';
                }
            });
            //------------------------------------------------------------//

            // Handle add diagnosis
            // Inisialisasi array untuk menyimpan diagnosis
            let diagnosisDiferensial = [];
            let diagnosisKerja = [];

            // Input Diagnosis Diferensial
            const diagnosisDiferensialInput = document.getElementById('diagnosisDiferensialInput');
            const btnDiagnosisDiferensial = document.getElementById('btnDiagnosisDiferensial');

            // Input Diagnosis Kerja
            const diagnosisKerjaInput = document.getElementById('diagnosisKerjaInput');
            const btnDiagnosisKerja = document.getElementById('btnDiagnosisKerja');

            // Event Listener untuk Enter key di input Diferensial
            if (diagnosisDiferensialInput) {
                diagnosisDiferensialInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        tambahDiagnosisDiferensial();
                    }
                });
            }

            // Event Listener untuk button Diferensial
            if (btnDiagnosisDiferensial) {
                btnDiagnosisDiferensial.addEventListener('click', function() {
                    tambahDiagnosisDiferensial();
                });
            }

            // Event Listener untuk Enter key di input Kerja
            if (diagnosisKerjaInput) {
                diagnosisKerjaInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        tambahDiagnosisKerja();
                    }
                });
            }

            // Event Listener untuk button Kerja
            if (btnDiagnosisKerja) {
                btnDiagnosisKerja.addEventListener('click', function() {
                    tambahDiagnosisKerja();
                });
            }

            // Fungsi untuk menambah diagnosis diferensial
            function tambahDiagnosisDiferensial() {
                const value = diagnosisDiferensialInput.value.trim();
                if (value !== '') {
                    diagnosisDiferensial.push(value);
                    diagnosisDiferensialInput.value = '';
                    updateDiagnosisDiferensialList();
                    diagnosisDiferensialInput.focus();
                }
            }

            // Fungsi untuk menambah diagnosis kerja
            function tambahDiagnosisKerja() {
                const value = diagnosisKerjaInput.value.trim();
                if (value !== '') {
                    diagnosisKerja.push(value);
                    diagnosisKerjaInput.value = '';
                    updateDiagnosisKerjaList();
                    diagnosisKerjaInput.focus();
                }
            }

            // Fungsi untuk update list diagnosis diferensial
            function updateDiagnosisDiferensialList() {
                const listContainer = document.getElementById('diagnosisDiferensialList');
                if (!listContainer) return;

                if (diagnosisDiferensial.length === 0) {
                    listContainer.innerHTML = `
                        <div class="text-center text-muted p-3">
                            <i class="bi bi-clipboard-x"></i>
                            <p class="mb-0">Belum ada diagnosis diferensial</p>
                        </div>
                    `;
                    return;
                }

                listContainer.innerHTML = diagnosisDiferensial.map((item, index) => `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-bold">${index + 1}. ${item}</span>
                        <button class="btn btn-sm btn-outline-danger" onclick="hapusDiagnosisDiferensial(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `).join('');
            }

            // Fungsi untuk update list diagnosis kerja
            function updateDiagnosisKerjaList() {
                const listContainer = document.getElementById('diagnosisKerjaList');
                if (!listContainer) return;

                if (diagnosisKerja.length === 0) {
                    listContainer.innerHTML = `
                        <div class="text-center text-muted p-3">
                            <i class="bi bi-clipboard-x"></i>
                            <p class="mb-0">Belum ada diagnosis kerja</p>
                        </div>
                    `;
                    return;
                }

                listContainer.innerHTML = diagnosisKerja.map((item, index) => `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="fw-bold">${index + 1}. ${item}</span>
                        <button class="btn btn-sm btn-outline-danger" onclick="hapusDiagnosisKerja(${index})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `).join('');
            }

            // Fungsi untuk menghapus diagnosis
            window.hapusDiagnosisDiferensial = function(index) {
                diagnosisDiferensial.splice(index, 1);
                updateDiagnosisDiferensialList();
            }

            window.hapusDiagnosisKerja = function(index) {
                diagnosisKerja.splice(index, 1);
                updateDiagnosisKerjaList();
            }

            // Initialize lists
            updateDiagnosisDiferensialList();
            updateDiagnosisKerjaList();

  
            //------------------------------------------------------------//
        });
    </script>
@endpush
