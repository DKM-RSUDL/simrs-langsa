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
            <a href="{{ route('rawat-inap.pneumonia.curb-65.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="curb65Form" method="POST"
                action="{{ route('rawat-inap.pneumonia.curb-65.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="text-center text-primary fw-bold mb-4">Form Kriteria CURB-65</h4>

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

                        <!-- CURB-65 Assessment Section -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Kriteria CURB-65</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-primary">
                                            <tr>
                                                <th width="15%" class="text-center">CURB-65</th>
                                                <th width="50%">Gambaran Klinis</th>
                                                <th width="15%" class="text-center">Skor</th>
                                                <th width="20%" class="text-center">Pilihan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center fw-bold fs-4">C</td>
                                                <td>Confusion</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input curb-item" type="checkbox" 
                                                               name="confusion" value="1" id="confusion">
                                                        <label class="form-check-label" for="confusion">Ya</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center fw-bold fs-4">U</td>
                                                <td>Blood Urea Nitrogen ≥ 20 mg/dL</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input curb-item" type="checkbox" 
                                                               name="urea" value="1" id="urea">
                                                        <label class="form-check-label" for="urea">Ya</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center fw-bold fs-4">R</td>
                                                <td>Respiratory Rate ≥ 30 x/menit</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input curb-item" type="checkbox" 
                                                               name="respiratory" value="1" id="respiratory">
                                                        <label class="form-check-label" for="respiratory">Ya</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center fw-bold fs-4">B</td>
                                                <td>Systolic BP ≤ 90 mmHg atau Diastolic BP ≤ 60 mmHg</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input curb-item" type="checkbox" 
                                                               name="blood_pressure" value="1" id="blood_pressure">
                                                        <label class="form-check-label" for="blood_pressure">Ya</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center fw-bold fs-4">65</td>
                                                <td>Usia 65 Tahun</td>
                                                <td class="text-center">1</td>
                                                <td class="text-center">
                                                    <div class="form-check">
                                                        <input class="form-check-input curb-item" type="checkbox" 
                                                               name="age_65" value="1" id="age_65">
                                                        <label class="form-check-label" for="age_65">Ya</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="table-warning">
                                                <td colspan="2" class="text-center fw-bold">Total Skor</td>
                                                <td class="text-center">
                                                    <span id="total_skor" class="fw-bold fs-5 text-primary">0</span>
                                                    <input type="hidden" name="total_skor" id="total_skor_input" value="0">
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Interpretation Section -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Interpretasi</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th width="15%" class="text-center">Total Skor</th>
                                                <th width="15%" class="text-center">% Mortalitas</th>
                                                <th width="25%">Level Resiko</th>
                                                <th width="45%">Perawatan Yang disarankan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="result_0" class="result-row d-none">
                                                <td class="text-center fw-bold">0</td>
                                                <td class="text-center">0,6 %</td>
                                                <td><span class="badge bg-success">Rendah</span></td>
                                                <td>Rawat Jalan</td>
                                            </tr>
                                            <tr id="result_1" class="result-row d-none">
                                                <td class="text-center fw-bold">1</td>
                                                <td class="text-center">2,7 %</td>
                                                <td><span class="badge bg-success">Rendah</span></td>
                                                <td>Rawat Jalan</td>
                                            </tr>
                                            <tr id="result_2" class="result-row d-none">
                                                <td class="text-center fw-bold">2</td>
                                                <td class="text-center">6,8 %</td>
                                                <td><span class="badge bg-warning text-dark">Sedang</span></td>
                                                <td>Rawat Inap singkat / Rawat jalan dengan pengawasan</td>
                                            </tr>
                                            <tr id="result_3" class="result-row d-none">
                                                <td class="text-center fw-bold">3</td>
                                                <td class="text-center">14,0 %</td>
                                                <td><span class="badge bg-warning text-dark">Sedang-Berat</span></td>
                                                <td>Rawat Inap</td>
                                            </tr>
                                            <tr id="result_4_5" class="result-row d-none">
                                                <td class="text-center fw-bold">4 atau 5</td>
                                                <td class="text-center">27,8 %</td>
                                                <td><span class="badge bg-danger">Berat</span></td>
                                                <td>Rawat ICU</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Current Result Display -->
                                <div id="current_result" class="mt-3 p-3 border rounded bg-white d-none">
                                    <h6 class="fw-bold text-primary mb-2">Hasil Penilaian:</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Skor:</strong> <span id="display_skor" class="text-primary"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Mortalitas:</strong> <span id="display_mortalitas"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Resiko:</strong> <span id="display_resiko"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Perawatan:</strong> <span id="display_perawatan"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden inputs for interpretation -->
                                <input type="hidden" name="mortalitas" id="mortalitas_input">
                                <input type="hidden" name="level_resiko" id="level_resiko_input">
                                <input type="hidden" name="perawatan_disarankan" id="perawatan_input">
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
    const curbItems = document.querySelectorAll('.curb-item');
    const totalSkorDisplay = document.getElementById('total_skor');
    const totalSkorInput = document.getElementById('total_skor_input');
    const currentResult = document.getElementById('current_result');
    const resultRows = document.querySelectorAll('.result-row');

    // Interpretation data
    const interpretations = {
        0: { mortalitas: '0,6 %', resiko: 'Rendah', perawatan: 'Rawat Jalan', badge: 'bg-success' },
        1: { mortalitas: '2,7 %', resiko: 'Rendah', perawatan: 'Rawat Jalan', badge: 'bg-success' },
        2: { mortalitas: '6,8 %', resiko: 'Sedang', perawatan: 'Rawat Inap singkat / Rawat jalan dengan pengawasan', badge: 'bg-warning text-dark' },
        3: { mortalitas: '14,0 %', resiko: 'Sedang-Berat', perawatan: 'Rawat Inap', badge: 'bg-warning text-dark' },
        4: { mortalitas: '27,8 %', resiko: 'Berat', perawatan: 'Rawat ICU', badge: 'bg-danger' },
        5: { mortalitas: '27,8 %', resiko: 'Berat', perawatan: 'Rawat ICU', badge: 'bg-danger' }
    };

    function calculateTotal() {
        let total = 0;
        curbItems.forEach(item => {
            if (item.checked) {
                total += parseInt(item.value);
            }
        });
        
        // Update display
        totalSkorDisplay.textContent = total;
        totalSkorInput.value = total;
        
        // Show interpretation
        showInterpretation(total);
        
        // Highlight corresponding row in interpretation table
        highlightResultRow(total);
    }

    function showInterpretation(skor) {
        const interpretation = interpretations[skor];
        if (interpretation) {
            currentResult.classList.remove('d-none');
            document.getElementById('display_skor').textContent = skor;
            document.getElementById('display_mortalitas').textContent = interpretation.mortalitas;
            document.getElementById('display_resiko').innerHTML = `<span class="badge ${interpretation.badge}">${interpretation.resiko}</span>`;
            document.getElementById('display_perawatan').textContent = interpretation.perawatan;
            
            // Set hidden inputs
            document.getElementById('mortalitas_input').value = interpretation.mortalitas;
            document.getElementById('level_resiko_input').value = interpretation.resiko;
            document.getElementById('perawatan_input').value = interpretation.perawatan;
        } else {
            currentResult.classList.add('d-none');
        }
    }

    function highlightResultRow(skor) {
        // Hide all result rows first
        resultRows.forEach(row => {
            row.classList.add('d-none');
            row.classList.remove('table-success');
        });
        
        // Show and highlight the corresponding row
        let targetRow;
        if (skor === 0) targetRow = document.getElementById('result_0');
        else if (skor === 1) targetRow = document.getElementById('result_1');
        else if (skor === 2) targetRow = document.getElementById('result_2');
        else if (skor === 3) targetRow = document.getElementById('result_3');
        else if (skor >= 4) targetRow = document.getElementById('result_4_5');
        
        if (targetRow) {
            targetRow.classList.remove('d-none');
            targetRow.classList.add('table-success');
        }
    }

    // Add event listeners
    curbItems.forEach(item => {
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