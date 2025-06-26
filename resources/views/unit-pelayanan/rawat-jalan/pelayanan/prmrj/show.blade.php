@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .card {
            border-radius: 10px;
        }

        .card-header {
            border-radius: 10px 10px 0 0;
        }

        .form-label {
            font-size: 0.9rem;
            color: #333;
        }

        .form-control,
        .form-check-input {
            border-radius: 5px;
        }

        .btn {
            border-radius: 5px;
        }

        .text-primary {
            color: #007bff !important;
        }

        .shadow-sm {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Patient Card -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('components.patient-card')
            </div>

            <!-- Main Form -->
            <div class="col-lg-9 col-md-8">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('rawat-jalan.prmrj.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $prmrj->id]) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                </div>

                <form id="praAnestesiForm" method="" action="#">

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 font-weight-bold">DETAIL PROFIL RINGKAS MEDIS RAWAT JALAN</h5>
                        </div>

                        <div class="card-body p-4">

                            <!-- Masuk -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-clock me-2"></i>Waktu</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal" value="{{ \Carbon\Carbon::parse($prmrj->tanggal)->format('Y-m-d') }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time" class="form-control" name="jam" value="{{ \Carbon\Carbon::parse($prmrj->jam)->format('H:i') }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alergi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-allergies"></i> Alergi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="section-separator" id="alergi">
                                                <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="createAlergiTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="20%">Jenis Alergi</th>
                                                                <th width="25%">Alergen</th>
                                                                <th width="25%">Reaksi</th>
                                                                <th width="20%">Tingkat Keparahan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="no-alergi-row">
                                                                <td colspan="5" class="text-center text-muted">Tidak ada data
                                                                    alergi</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Diagnosis -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-notes-medical me-2"></i>Diagnosis</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Diagnosis</label>
                                                <input type="text" class="form-control" name="diagnosis" value="{{ $prmrj->diagnosis }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Rawat Inap -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-notes-medical me-2"></i>Riwayat Rawat Inap</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Data klinis penting termasuk riwayat rawat inap atau prosedur bedah sejak kunjungan terakhir</label>
                                                <input type="text" class="form-control" name="riwayat_rawat" value="{{ $prmrj->riwayat_rawat }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan Penunjang -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-stethoscope me-2"></i>Pemeriksaan Penunjang</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Pemeriksaan Penunjang</label>
                                                <input type="text" class="form-control" name="pemeriksaan_penunjang" value="{{ $prmrj->pemeriksaan_penunjang }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tindakan/Prosedur/Terapi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-procedures me-2"></i>Tindakan/Prosedur/Terapi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tindakan/Prosedur/Terapi</label>
                                                <input type="text" class="form-control" name="tindakan_prosedur" value="{{ $prmrj->tindakan_prosedur }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            //====================================================================================//
            // ALERGI - EDIT MODE
            //====================================================================================//

            // Array untuk menyimpan data alergi sementara
            let alergiDataArray = [];

            // Load existing alergi data from PHP
            try {
                const existingAlergiData = @json($alergiPasien ?? []);
                alergiDataArray = existingAlergiData.map(item => ({
                    jenis_alergi: item.jenis_alergi || '',
                    alergen: item.nama_alergi || '',
                    reaksi: item.reaksi || '',
                    tingkat_keparahan: item.tingkat_keparahan || '',
                    is_existing: true,
                    id: item.id || null
                }));
            } catch (e) {
                console.log('Data alergi tidak tersedia');
                alergiDataArray = [];
            }

            // Event listeners untuk alergi
            const openAlergiModal = document.getElementById('openAlergiModal');
            if (openAlergiModal) {
                openAlergiModal.addEventListener('click', function() {
                    updateModalAlergiList();
                });
            }

            const addToAlergiList = document.getElementById('addToAlergiList');
            if (addToAlergiList) {
                addToAlergiList.addEventListener('click', function() {
                    const jenisAlergi = document.getElementById('modal_jenis_alergi')?.value?.trim();
                    const alergen = document.getElementById('modal_alergen')?.value?.trim();
                    const reaksi = document.getElementById('modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value
                        ?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        alert('Harap isi semua field alergi');
                        return;
                    }

                    const isDuplicate = alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        alert('Data alergi sudah ada');
                        return;
                    }

                    alergiDataArray.push({
                        jenis_alergi: jenisAlergi,
                        alergen: alergen,
                        reaksi: reaksi,
                        tingkat_keparahan: tingkatKeparahan,
                        is_existing: false
                    });

                    updateModalAlergiList();
                    resetAlergiForm();
                });
            }

            const saveAlergiData = document.getElementById('saveAlergiData');
            if (saveAlergiData) {
                saveAlergiData.addEventListener('click', function() {
                    updateMainAlergiTable();
                    updateHiddenAlergiInput();

                    const alergiModal = document.getElementById('alergiModal');
                    if (alergiModal && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getInstance(alergiModal);
                        if (modalInstance) modalInstance.hide();
                    }
                });
            }

            // Functions untuk alergi
            function updateModalAlergiList() {
                const tbody = document.getElementById('modalAlergiList');
                const noDataMessage = document.getElementById('noAlergiMessage');
                const countBadge = document.getElementById('alergiCount');

                if (!tbody) return;

                tbody.innerHTML = '';

                if (alergiDataArray.length === 0) {
                    if (noDataMessage) noDataMessage.style.display = 'block';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'none';
                } else {
                    if (noDataMessage) noDataMessage.style.display = 'none';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'table';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }

                if (countBadge) countBadge.textContent = alergiDataArray.length;
            }

            function updateMainAlergiTable() {
                const tbody = document.querySelector('#createAlergiTable tbody');
                const noAlergiRow = document.getElementById('no-alergi-row');

                if (!tbody || !noAlergiRow) return;

                const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                existingRows.forEach(row => row.remove());

                if (alergiDataArray.length === 0) {
                    noAlergiRow.style.display = 'table-row';
                } else {
                    noAlergiRow.style.display = 'none';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            }

            function updateHiddenAlergiInput() {
                const hiddenInput = document.getElementById('alergisInput');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(alergiDataArray);
                }
            }

            function resetAlergiForm() {
                const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi', 'modal_tingkat_keparahan'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }

            function getKeparahanBadgeClass(keparahan) {
                switch (keparahan.toLowerCase()) {
                    case 'ringan':
                        return 'bg-success';
                    case 'sedang':
                        return 'bg-warning';
                    case 'berat':
                        return 'bg-danger';
                    default:
                        return 'bg-secondary';
                }
            }

            // Global functions untuk onclick events
            window.removeAlergiFromModal = function(index) {
                alergiDataArray.splice(index, 1);
                updateModalAlergiList();
            };

            window.removeAlergiFromMain = function(index) {
                alergiDataArray.splice(index, 1);
                updateMainAlergiTable();
                updateHiddenAlergiInput();
            };

            // Initial load untuk alergi
            updateMainAlergiTable();
            updateHiddenAlergiInput();

            // PERBAIKAN: Pemeriksaan Fisik Logic
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const targetDiv = document.getElementById(targetId);
                    const itemId = targetId.replace('-keterangan', '');
                    const checkbox = document.querySelector(`input[name="${itemId}-normal"]`);

                    if (targetDiv.style.display === 'none' || targetDiv.style.display === '') {
                        targetDiv.style.display = 'block';
                        // Uncheck normal when adding keterangan
                        if (checkbox) checkbox.checked = false;
                    } else {
                        targetDiv.style.display = 'none';
                        // Clear the input when hiding
                        const input = targetDiv.querySelector('input');
                        if (input) input.value = '';
                    }
                });
            });

            // PERBAIKAN: Handle normal checkbox changes
            document.querySelectorAll('input[type="checkbox"][id$="-normal"]').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const itemId = this.id.replace('-normal', '');
                    const keteranganDiv = document.getElementById(itemId + '-keterangan');
                    const keteranganInput = keteranganDiv ? keteranganDiv.querySelector('input') : null;

                    if (this.checked) {
                        // Hide keterangan when normal is checked
                        if (keteranganDiv) {
                            keteranganDiv.style.display = 'none';
                            if (keteranganInput) keteranganInput.value = '';
                        }
                    }
                });
            });

            // PERBAIKAN: Function to toggle input fields based on radio button selection
            function toggleInputFields(radioName, inputIds, yesValue = 'ya') {
                const radios = document.getElementsByName(radioName);
                const inputs = inputIds.map(id => document.getElementById(id)).filter(input => input !== null);

                // Initialize state based on current selection
                const selectedValue = Array.from(radios).find(radio => radio.checked)?.value;
                inputs.forEach(input => {
                    input.disabled = selectedValue !== yesValue;
                });

                // Add event listeners to radio buttons
                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        inputs.forEach(input => {
                            input.disabled = this.value !== yesValue;
                            if (this.value !== yesValue) {
                                input.value = ''; // Clear input when disabled
                                input.classList.remove('is-invalid');
                            }
                        });
                    });
                });
            }

            // Toggle inputs for Merokok
            toggleInputFields('merokok', ['merokok_jumlah', 'merokok_lama']);

            // Toggle inputs for Alkohol
            toggleInputFields('alkohol', ['alkohol_jumlah']);

            // Toggle inputs for Obat-obatan
            toggleInputFields('obat_obatan', ['obat_jenis']);

            // PERBAIKAN: Toggle 'lainnya' input based on checkbox
            const lainnyaCheck = document.getElementById('lainnya_check');
            const lainnyaInput = document.getElementById('lainnya');

            if (lainnyaCheck && lainnyaInput) {
                // Initialize state
                lainnyaInput.disabled = !lainnyaCheck.checked;

                // Add event listener to checkbox
                lainnyaCheck.addEventListener('change', function () {
                    lainnyaInput.disabled = !this.checked;
                    if (!this.checked) {
                        lainnyaInput.value = '';
                        lainnyaInput.classList.remove('is-invalid');
                    }
                });
            }

            // PERBAIKAN: Client-side validation on form submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function (event) {
                    let errors = [];

                    // Check Merokok
                    const merokok = document.querySelector('input[name="merokok"]:checked')?.value;
                    if (merokok === 'ya') {
                        const jumlah = document.getElementById('merokok_jumlah');
                        const lama = document.getElementById('merokok_lama');

                        if (jumlah && (!jumlah.value || jumlah.value < 0)) {
                            errors.push('Jumlah batang/hari harus diisi dan tidak boleh negatif.');
                            jumlah.classList.add('is-invalid');
                        }
                        if (lama && (!lama.value || lama.value < 0)) {
                            errors.push('Lama merokok harus diisi dan tidak boleh negatif.');
                            lama.classList.add('is-invalid');
                        }
                    }

                    // Check Alkohol
                    const alkohol = document.querySelector('input[name="alkohol"]:checked')?.value;
                    const alkoholJumlah = document.getElementById('alkohol_jumlah');
                    if (alkohol === 'ya' && alkoholJumlah && !alkoholJumlah.value.trim()) {
                        errors.push('Jumlah konsumsi alkohol harus diisi.');
                        alkoholJumlah.classList.add('is-invalid');
                    }

                    // Check Obat-obatan
                    const obat = document.querySelector('input[name="obat_obatan"]:checked')?.value;
                    const obatJenis = document.getElementById('obat_jenis');
                    if (obat === 'ya' && obatJenis && !obatJenis.value.trim()) {
                        errors.push('Jenis obat-obatan harus diisi.');
                        obatJenis.classList.add('is-invalid');
                    }

                    // Validate 'lainnya' field
                    if (lainnyaCheck && lainnyaInput) {
                        if (lainnyaCheck.checked && !lainnyaInput.value.trim()) {
                            errors.push('Rencana lainnya wajib diisi jika dicentang.');
                            lainnyaInput.classList.add('is-invalid');
                        } else {
                            lainnyaInput.classList.remove('is-invalid');
                        }
                    }

                    // If there are errors, prevent form submission and show alert
                    if (errors.length > 0) {
                        event.preventDefault();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Belum Lengkap',
                                html: errors.join('<br>'),
                                confirmButtonColor: '#3085d6',
                            });
                        } else {
                            alert('Data Belum Lengkap:\n' + errors.join('\n'));
                        }
                    }
                });
            }
        });
    </script>
@endpush
