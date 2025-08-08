@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('rawat-inap.pneumonia.psi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="psiForm" method="POST"
                action="{{ route('rawat-inap.pneumonia.psi.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center text-primary fw-bold mb-4">Form Pneumonia Severity Index (PSI)</h4>

                        <!-- Basic Information Section -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Informasi Dasar</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Tanggal dan Jam Implementasi</label>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal_implementasi"
                                                id="tanggal_implementasi" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">Jam</label>
                                            <input type="time" class="form-control" name="jam_implementasi"
                                                id="jam_implementasi" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PSI Assessment Section -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Kriteria Pneumonia Severity Index (PSI)</h5>
                            </div>
                            <div class="card-body">
                                <!-- Faktor Demografik -->
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3">Faktor Demografik</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="table-secondary">
                                                <tr>
                                                    <th width="50%">Karakteristik Pasien</th>
                                                    <th width="20%" class="text-center">Nilai</th>
                                                    <th width="30%" class="text-center">Pilihan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="fw-semibold">Umur</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">- Laki-laki</td>
                                                    <td class="text-center">Umur (tahun)</td>
                                                    <td class="text-center">
                                                        @if ($dataMedis->pasien->jenis_kelamin == 1)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender_age" value="male" id="male" checked>
                                                                <label class="form-check-label" for="male">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm d-inline-block"
                                                                        style="width: 80px;" name="umur_laki" id="umur_laki"
                                                                        min="0"
                                                                        value="{{ $dataMedis->pasien->umur ?? 0 }}"
                                                                        readonly>
                                                                </label>
                                                            </div>
                                                            <small class="text-muted">Skor:
                                                                {{ $dataMedis->pasien->umur ?? 0 }}</small>
                                                        @else
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender_age" value="male" id="male"
                                                                    disabled>
                                                                <label class="form-check-label text-muted" for="male">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm d-inline-block"
                                                                        style="width: 80px;" name="umur_laki" id="umur_laki"
                                                                        min="0" disabled>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">- Perempuan</td>
                                                    <td class="text-center">Umur (tahun) - 10</td>
                                                    <td class="text-center">
                                                        @if ($dataMedis->pasien->jenis_kelamin == 0)
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender_age" value="female" id="female" checked>
                                                                <label class="form-check-label" for="female">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm d-inline-block"
                                                                        style="width: 80px;" name="umur_perempuan"
                                                                        id="umur_perempuan" min="0"
                                                                        value="{{ $dataMedis->pasien->umur ?? 0 }}"
                                                                        readonly>
                                                                </label>
                                                            </div>
                                                            @php $skorPerempuan = max(0, ($dataMedis->pasien->umur ?? 0) - 10); @endphp
                                                            <small class="text-muted">Skor: {{ $skorPerempuan }}</small>
                                                        @else
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender_age" value="female" id="female"
                                                                    disabled>
                                                                <label class="form-check-label text-muted" for="female">
                                                                    <input type="number"
                                                                        class="form-control form-control-sm d-inline-block"
                                                                        style="width: 80px;" name="umur_perempuan"
                                                                        id="umur_perempuan" min="0" disabled>
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-4">- Penghuni Panti Werdha</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="panti_werdha" value="10" id="panti_werdha">
                                                            <label class="form-check-label" for="panti_werdha">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Penyakit Komorbid -->
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3">Penyakit Komorbid</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td width="50%">Keganasan</td>
                                                    <td width="20%" class="text-center">+ 30</td>
                                                    <td width="30%" class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="keganasan" value="30" id="keganasan">
                                                            <label class="form-check-label" for="keganasan">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Penyakit Hati</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="penyakit_hati" value="20" id="penyakit_hati">
                                                            <label class="form-check-label" for="penyakit_hati">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Penyakit Jantung Kongestif</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="jantung_kongestif" value="10"
                                                                id="jantung_kongestif">
                                                            <label class="form-check-label"
                                                                for="jantung_kongestif">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Penyakit Serebrovaskular</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="serebrovaskular" value="10"
                                                                id="serebrovaskular">
                                                            <label class="form-check-label"
                                                                for="serebrovaskular">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Penyakit Ginjal</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="penyakit_ginjal" value="10"
                                                                id="penyakit_ginjal">
                                                            <label class="form-check-label"
                                                                for="penyakit_ginjal">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Pemeriksaan Fisik -->
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3">Pemeriksaan Fisik</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td width="50%">Gangguan Kesadaran</td>
                                                    <td width="20%" class="text-center">+ 20</td>
                                                    <td width="30%" class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="gangguan_kesadaran" value="20"
                                                                id="gangguan_kesadaran">
                                                            <label class="form-check-label"
                                                                for="gangguan_kesadaran">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Frekuensi nafas > 30 kali/menit</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="frekuensi_nafas" value="20"
                                                                id="frekuensi_nafas">
                                                            <label class="form-check-label"
                                                                for="frekuensi_nafas">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tekanan Darah Sistolik < 90 mmHg</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="tekanan_sistolik" value="20"
                                                                id="tekanan_sistolik">
                                                            <label class="form-check-label"
                                                                for="tekanan_sistolik">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Suhu Tubuh < 35°C atau> 40°C</td>
                                                    <td class="text-center">+ 15</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="suhu_tubuh" value="15" id="suhu_tubuh">
                                                            <label class="form-check-label" for="suhu_tubuh">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Frekuensi Nadi > 125 kali/menit</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="frekuensi_nadi" value="10" id="frekuensi_nadi">
                                                            <label class="form-check-label"
                                                                for="frekuensi_nadi">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Hasil Laboratorium -->
                                <div class="mb-4">
                                    <h6 class="fw-bold text-primary mb-3">Hasil Laboratorium</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td width="50%">pH < 7.35</td>
                                                    <td width="20%" class="text-center">+ 30</td>
                                                    <td width="30%" class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="ph_rendah" value="30" id="ph_rendah">
                                                            <label class="form-check-label" for="ph_rendah">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Ureum > 64.2 mg/dL</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="ureum_tinggi" value="20" id="ureum_tinggi">
                                                            <label class="form-check-label" for="ureum_tinggi">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Natrium < 130 mEq/L</td>
                                                    <td class="text-center">+ 20</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="natrium_rendah" value="20" id="natrium_rendah">
                                                            <label class="form-check-label"
                                                                for="natrium_rendah">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Glukosa > 250 mg/dL</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="glukosa_tinggi" value="10" id="glukosa_tinggi">
                                                            <label class="form-check-label"
                                                                for="glukosa_tinggi">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Hematokrit < 30%</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="hematokrit_rendah" value="10"
                                                                id="hematokrit_rendah">
                                                            <label class="form-check-label"
                                                                for="hematokrit_rendah">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Tekanan O₂ darah arteri < 60 mmHg</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="o2_rendah" value="10" id="o2_rendah">
                                                            <label class="form-check-label" for="o2_rendah">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Efusi Pleura</td>
                                                    <td class="text-center">+ 10</td>
                                                    <td class="text-center">
                                                        <div class="form-check">
                                                            <input class="form-check-input psi-item" type="checkbox"
                                                                name="efusi_pleura" value="10" id="efusi_pleura">
                                                            <label class="form-check-label" for="efusi_pleura">Ya</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Total Score -->
                                <div class="card bg-warning bg-opacity-25 border-warning">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <h5 class="fw-bold mb-0">Total Skor PSI</h5>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span id="total_skor" class="fs-2 fw-bold text-primary">0</span>
                                                <input type="hidden" name="total_skor" id="total_skor_input"
                                                    value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Interpretation Section -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Interpretasi dan Rekomendasi</h5>
                            </div>
                            <div class="card-body">
                                <!-- Current Result Display -->
                                <div id="current_result" class="p-3 border rounded bg-white">
                                    <h6 class="fw-bold text-primary mb-3">Hasil Penilaian PSI:</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <strong>Total Skor:</strong> <span id="display_skor"
                                                class="text-primary fw-bold">0</span>
                                        </div>
                                        <div class="col-md-8">
                                            <strong>Rekomendasi:</strong> <span id="display_rekomendasi"
                                                class="fw-bold">-</span>
                                        </div>
                                    </div>

                                    <!-- Additional Criteria Check -->
                                    <div id="additional_criteria" class="d-none">
                                        <div class="alert alert-warning">
                                            <h6 class="fw-bold">Perhatian! Meskipun skor PSI < 70, pasien tetap perlu
                                                    dirawat inap karena memenuhi kriteria berikut:</h6>
                                                    <ul id="criteria_list" class="mb-0"></ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden inputs for results -->
                                <input type="hidden" name="rekomendasi_perawatan" id="rekomendasi_input">
                                <input type="hidden" name="kriteria_tambahan" id="kriteria_tambahan_input">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4" id="simpan">
                                <i class="ti-save me-2"></i> Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const psiItems = document.querySelectorAll('.psi-item');
            const totalSkorDisplay = document.getElementById('total_skor');
            const totalSkorInput = document.getElementById('total_skor_input');
            const currentResult = document.getElementById('current_result');
            const form = document.getElementById('psiForm');
            const submitBtn = document.getElementById('simpan');
            const genderAge = document.querySelectorAll('input[name="gender_age"]');
            const umurLaki = document.getElementById('umur_laki');
            const umurPerempuan = document.getElementById('umur_perempuan');
            const additionalCriteria = document.getElementById('additional_criteria');
            const criteriaList = document.getElementById('criteria_list');

            // Store original button content
            const originalBtnContent = submitBtn.innerHTML;

            function calculateTotal() {
                let total = 0;

                // Calculate age score
                const selectedGender = document.querySelector('input[name="gender_age"]:checked');
                if (selectedGender) {
                    if (selectedGender.value === 'male') {
                        const umurLakiValue = parseInt(umurLaki.value) || 0;
                        total += umurLakiValue;
                    } else if (selectedGender.value === 'female') {
                        const umurPerempuanValue = parseInt(umurPerempuan.value) || 0;
                        total += Math.max(0, umurPerempuanValue - 10);
                    }
                }

                // Calculate other PSI items
                psiItems.forEach(function(item) {
                    if (item.checked) {
                        total += parseInt(item.value) || 0;
                    }
                });

                // Update display
                totalSkorDisplay.textContent = total;
                totalSkorInput.value = total;
                document.getElementById('display_skor').textContent = total;

                // Show interpretation
                showInterpretation(total);
            }

            function showInterpretation(skor) {
                let rekomendasi = '';
                let kriteriaTambahan = [];

                // Basic PSI interpretation
                if (skor >= 70) {
                    rekomendasi = 'Rawat Inap (Skor PSI ≥ 70)';
                    document.getElementById('display_rekomendasi').innerHTML =
                        '<span class="badge bg-danger">Rawat Inap</span>';
                } else {
                    // Check additional criteria for hospitalization even if PSI < 70
                    const additionalCriteriaChecked = checkAdditionalCriteria();

                    if (additionalCriteriaChecked.length > 0) {
                        rekomendasi = 'Rawat Inap (Memenuhi kriteria tambahan meskipun PSI < 70)';
                        kriteriaTambahan = additionalCriteriaChecked;
                        document.getElementById('display_rekomendasi').innerHTML =
                            '<span class="badge bg-warning text-dark">Rawat Inap (Kriteria Tambahan)</span>';

                        // Show additional criteria warning
                        additionalCriteria.classList.remove('d-none');
                        criteriaList.innerHTML = '';
                        additionalCriteriaChecked.forEach(function(criteria) {
                            const li = document.createElement('li');
                            li.textContent = criteria;
                            criteriaList.appendChild(li);
                        });
                    } else {
                        rekomendasi = 'Rawat Jalan (Skor PSI < 70 dan tidak memenuhi kriteria tambahan)';
                        document.getElementById('display_rekomendasi').innerHTML =
                            '<span class="badge bg-success">Rawat Jalan</span>';
                        additionalCriteria.classList.add('d-none');
                    }
                }

                // Set hidden inputs
                document.getElementById('rekomendasi_input').value = rekomendasi;
                document.getElementById('kriteria_tambahan_input').value = kriteriaTambahan.join('; ');
            }

            function checkAdditionalCriteria() {
                const criteria = [];

                // a. Frekuensi nafas > 30 kali/menit
                if (document.getElementById('frekuensi_nafas').checked) {
                    criteria.push('Frekuensi nafas > 30 kali/menit');
                }

                // b. PaO2/FiO2 kurang dari 250 mmHg (represented by O2 < 60 mmHg)
                if (document.getElementById('o2_rendah').checked) {
                    criteria.push('PaO2/FiO2 kurang dari 250 mmHg');
                }

                // d. Tekanan sistolik < 90 mmHg
                if (document.getElementById('tekanan_sistolik').checked) {
                    criteria.push('Tekanan sistolik < 90 mmHg');
                }

                return criteria;
            }

            function setLoadingState(isLoading) {
                if (isLoading) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';

                    // Disable all form inputs
                    const formInputs = form.querySelectorAll('input, select, textarea, button');
                    formInputs.forEach(function(input) {
                        if (input !== submitBtn) {
                            input.disabled = true;
                        }
                    });
                } else {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnContent;

                    // Re-enable all form inputs
                    const formInputs = form.querySelectorAll('input, select, textarea, button');
                    formInputs.forEach(function(input) {
                        input.disabled = false;
                    });
                }
            }

            // Event listeners
            psiItems.forEach(function(item) {
                item.addEventListener('change', calculateTotal);
            });

            // Set current date and time
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            const currentTime = now.toTimeString().slice(0, 5);

            document.getElementById('tanggal_implementasi').value = today;
            document.getElementById('jam_implementasi').value = currentTime;

            // Initial calculation
            calculateTotal();
        });
    </script>
@endpush
