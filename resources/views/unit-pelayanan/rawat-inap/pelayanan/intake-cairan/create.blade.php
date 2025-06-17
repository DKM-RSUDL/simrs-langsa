@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .output-section, .intake-section {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .section-header {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="intakeCairanForm" method="POST"
                action="{{ route('rawat-inap.intake-cairan.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Intake dan Output Cairan per Shift</h4>
                                <p class="text-muted mb-0">Catat asupan dan keluaran cairan pasien berdasarkan shift perawatan</p>
                            </div>

                            <div class="px-3">
                                {{-- Info Umum --}}
                                <div class="section-separator">
                                    <div class="form-group">
                                        <label for="tanggal" style="min-width: 200px;">Tanggal</label>
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ date('Y-m-d') }}" required readonly>
                                    </div>
                                </div>

                                {{-- Pemilihan Shift --}}
                                <div class="section-separator">
                                    <div class="form-group">
                                        <label for="shift" style="min-width: 200px;">Shift Perawatan</label>
                                        <select name="shift" id="shift" class="form-control" required>
                                            <option value="">-- Pilih Shift --</option>
                                            <option value="1">Shift 1 (07:00 - 14:00)</option>
                                            <option value="2">Shift 2 (14:00 - 20:00)</option>
                                            <option value="3">Shift 3 (20:00 - 07:00)</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Form Input Intake dan Output --}}
                                <div id="intakeOutputContainer" class="intake-output-container">
                                    {{-- Output Section --}}
                                    <div class="output-section">
                                        <h4 class="section-header">Output</h4>

                                        <div class="form-group">
                                            <label for="output_urine" style="min-width: 200px;">Urine (ml)</label>
                                            <input type="number" name="output_urine" id="output_urine" 
                                                class="form-control" value="" min="0" placeholder="0" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="output_muntah" style="min-width: 200px;">Muntah (ml)</label>
                                            <input type="number" name="output_muntah" id="output_muntah" 
                                                class="form-control" value="" min="0" placeholder="0" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="output_drain" style="min-width: 200px;">Drain (ml)</label>
                                            <input type="number" name="output_drain" id="output_drain" 
                                                class="form-control" value="" min="0" placeholder="0" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="output_iwl" style="min-width: 200px;">IWL (Insensible Water Loss) (ml)</label>
                                            <input type="number" name="output_iwl" id="output_iwl" 
                                                class="form-control" value="" min="0" placeholder="0" required>
                                        </div>
                                    </div>

                                    {{-- Intake Section --}}
                                    <div class="intake-section">
                                        <h4 class="section-header">Intake</h4>

                                        <div class="form-group">
                                            <label for="intake_iufd" style="min-width: 200px;">IUFD (ml)</label>
                                            <input type="number" name="intake_iufd" id="intake_iufd" 
                                                class="form-control" value="" min="0" placeholder="0" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="intake_minum" style="min-width: 200px;">Minum (ml)</label>
                                            <input type="number" name="intake_minum" id="intake_minum" 
                                                class="form-control" value="" min="0" placeholder="0" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="intake_makan" style="min-width: 200px;">Makan (ml)</label>
                                            <input type="number" name="intake_makan" id="intake_makan" 
                                                class="form-control" value="" min="0" placeholder="0" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="intake_ngt" style="min-width: 200px;">NGT (ml)</label>
                                            <input type="number" name="intake_ngt" id="intake_ngt" 
                                                class="form-control" value="" min="0" placeholder="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('intakeCairanForm');
            const tanggalInput = document.getElementById('tanggal');
            const shiftSelect = document.getElementById('shift');

            // Cek duplikasi tanggal dan shift
            async function checkDuplicate() {
                const tanggal = tanggalInput.value;
                const shift = shiftSelect.value;
                
                if (tanggal && shift) {
                    try {
                        const response = await fetch(`{{ route('rawat-inap.intake-cairan.check-duplicate', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}?tanggal=${tanggal}&shift=${shift}`);
                        const data = await response.json();
                        
                        if (data.exists) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Sudah Ada!',
                                text: `Data untuk tanggal ${tanggal} ${data.shift_name} sudah tersimpan. Silahkan Edit di halaman Utama`,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#f39c12'
                            });
                            shiftSelect.value = '';
                            return false;
                        }
                    } catch (error) {
                        console.error('Error checking duplicate:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Terjadi kesalahan saat mengecek data.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#e74c3c'
                        });
                    }
                }
                return true;
            }

            // Event listener untuk perubahan shift
            shiftSelect.addEventListener('change', checkDuplicate);

            // Validasi sebelum submit
            form.addEventListener('submit', async function(e) {
                const isValid = await checkDuplicate();
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection