@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .verification-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .nav-link.active {
            background-color: #007bff !important;
            color: white !important;
        }

        .status-progress {
            font-size: 0.7rem;
            margin-top: 2px;
        }

        .progress-mini {
            height: 8px;
            margin-top: 3px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .required {
            color: red;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">

            <div class="d-flex justify-content-center">
                <div class="card-body">
                    <div class="tab-pane fade show active">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-asesmen">Monitoring dan Evaluasi Gizi</h4>
                                        {{-- Info TEE --}}
                                        @if ($energyValue)
                                            <div class="alert alert-info">
                                                <i class="ti-info-alt me-2"></i>
                                                <strong>{{ $energySource }}:</strong>
                                                {{ number_format($energyValue, 0) }} Kkal
                                                @if($isAnak)
                                                    <br><small>Perhitungan nilai gizi akan berdasarkan persentase dari total kebutuhan kalori anak ini.</small>
                                                @else
                                                    <br><small>Perhitungan nilai gizi akan berdasarkan persentase dari TEE ini.</small>
                                                @endif
                                            </div>
                                        @else
                                            <div class="alert alert-warning">
                                                <i class="ti-alert-triangle me-2"></i>
                                                <strong>Peringatan:</strong> 
                                                @if($isAnak)
                                                    Data kebutuhan kalori anak belum tersedia. Silakan isi pengkajian gizi anak terlebih dahulu.
                                                @else
                                                    Data TEE belum tersedia. Silakan isi pengkajian gizi dewasa terlebih dahulu.
                                                @endif
                                            </div>
                                        @endif

                                        <form id="formTambahMonitoring" method="POST"
                                            action="{{ route('rawat-inap.gizi.monitoring.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                            @csrf
                                            <input type="hidden" id="energyValue" value="{{ $energyValue ?? 0 }}">
                                            <input type="hidden" id="isAnak" value="{{ $isAnak ? 1 : 0 }}">
                                            
                                            {{-- Hidden inputs untuk hasil kalori yang akan dikirim ke database --}}
                                            <input type="hidden" name="energi" id="energi_calculated">
                                            <input type="hidden" name="protein" id="protein_calculated">
                                            <input type="hidden" name="karbohidrat" id="karbohidrat_calculated">
                                            <input type="hidden" name="lemak" id="lemak_calculated">
                                            
                                            {{-- Error Messages --}}
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul class="mb-0">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            {{-- Success/Error Messages --}}
                                            @if (session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            @if (session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif

                                            <div class="row">
                                                {{-- Tanggal dan Jam --}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tanggal" class="form-label">Tanggal <span
                                                                class="required">*</span></label>
                                                        <input type="date"
                                                            class="form-control @error('tanggal') is-invalid @enderror"
                                                            id="tanggal" name="tanggal"
                                                            value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                                        @error('tanggal')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="jam" class="form-label">Jam <span
                                                                class="required">*</span></label>
                                                        <input type="time"
                                                            class="form-control @error('jam') is-invalid @enderror"
                                                            id="jam" name="jam"
                                                            value="{{ old('jam', date('H:i')) }}" required>
                                                        @error('jam')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Energi dan Protein --}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="energi_persen" class="form-label">Energi <span
                                                                class="required">*</span></label>
                                                        <div class="input-group">
                                                            <input type="number"
                                                                class="form-control @error('energi_persen') is-invalid @enderror"
                                                                id="energi_persen" name="energi_persen"
                                                                placeholder="Masukkan persentase energi" step="0.1"
                                                                min="0" max="100"
                                                                value="{{ old('energi_persen') }}" required
                                                                {{ !$energyValue ? 'disabled' : '' }}>
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        <small class="text-muted">Hasil: <span id="energi_hasil">0</span>
                                                            Kkal</small>
                                                        @error('energi_persen')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="protein_persen" class="form-label">Protein <span
                                                                class="required">*</span></label>
                                                        <div class="input-group">
                                                            <input type="number"
                                                                class="form-control @error('protein_persen') is-invalid @enderror"
                                                                id="protein_persen" name="protein_persen"
                                                                placeholder="Masukkan persentase protein" step="0.1"
                                                                min="0" max="100"
                                                                value="{{ old('protein_persen') }}" required
                                                                {{ !$energyValue ? 'disabled' : '' }}>
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        <small class="text-muted">Hasil: <span id="protein_hasil">0</span>
                                                            Kkal</small>
                                                        @error('protein_persen')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Karbohidrat dan Lemak --}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="karbohidrat_persen" class="form-label">Karbohidrat (KH)
                                                            <span class="required">*</span></label>
                                                        <div class="input-group">
                                                            <input type="number"
                                                                class="form-control @error('karbohidrat_persen') is-invalid @enderror"
                                                                id="karbohidrat_persen" name="karbohidrat_persen"
                                                                placeholder="Masukkan persentase karbohidrat"
                                                                step="0.1" min="0" max="100"
                                                                value="{{ old('karbohidrat_persen') }}" required
                                                                {{ !$energyValue ? 'disabled' : '' }}>
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        <small class="text-muted">Hasil: <span
                                                                id="karbohidrat_hasil">0</span> Kkal</small>
                                                        @error('karbohidrat_persen')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lemak_persen" class="form-label">Lemak <span
                                                                class="required">*</span></label>
                                                        <div class="input-group">
                                                            <input type="number"
                                                                class="form-control @error('lemak_persen') is-invalid @enderror"
                                                                id="lemak_persen" name="lemak_persen"
                                                                placeholder="Masukkan persentase lemak" step="0.1"
                                                                min="0" max="100"
                                                                value="{{ old('lemak_persen') }}" required
                                                                {{ !$energyValue ? 'disabled' : '' }}>
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        <small class="text-muted">Hasil: <span id="lemak_hasil">0</span>
                                                            Kkal</small>
                                                        @error('lemak_persen')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Masalah Perkembangan --}}
                                            <div class="form-group">
                                                <label for="masalah_perkembangan" class="form-label">Masalah
                                                    Perkembangan</label>
                                                <textarea class="form-control" id="masalah_perkembangan" name="masalah_perkembangan" rows="3"
                                                    placeholder="Deskripsikan masalah perkembangan yang ditemukan (jika ada)">{{ old('masalah_perkembangan') }}</textarea>
                                            </div>

                                            {{-- Tindak Lanjut --}}
                                            <div class="form-group">
                                                <label for="tindak_lanjut" class="form-label">Tindak
                                                    Lanjut</label>
                                                <textarea class="form-control" id="tindak_lanjut" name="tindak_lanjut" rows="3"
                                                    placeholder="Deskripsikan tindak lanjut yang akan dilakukan">{{ old('tindak_lanjut') }}</textarea>
                                            </div>

                                            {{-- Buttons --}}
                                            <div class="form-group mt-4">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{ route('rawat-inap.gizi.monitoring.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                        class="btn btn-secondary">
                                                        <i class="ti-arrow-left me-2"></i>Kembali
                                                    </a>
                                                    <button type="submit" class="btn btn-primary"
                                                        {{ !$energyValue ? 'disabled' : '' }}>
                                                        <i class="ti-save me-2"></i>Simpan Data
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            const energyValue = parseFloat($('#energyValue').val()) || 0;
            const isAnak = parseInt($('#isAnak').val()) || 0;

            // Fungsi untuk menghitung nilai berdasarkan persentase
            function calculateValues() {
                const energiPersen = parseFloat($('#energi_persen').val()) || 0;
                const proteinPersen = parseFloat($('#protein_persen').val()) || 0;
                const karbohidratPersen = parseFloat($('#karbohidrat_persen').val()) || 0;
                const lemakPersen = parseFloat($('#lemak_persen').val()) || 0;

                if (energyValue > 0) {
                    // Hitung energi berdasarkan persentase dari energy value (TEE untuk dewasa, total_kebutuhan_kalori untuk anak)
                    const energiValue = (energiPersen / 100) * energyValue;

                    // Hitung protein, karbohidrat, lemak berdasarkan persentase dari energi
                    const proteinValue = (proteinPersen / 100) * energiValue;
                    const karbohidratValue = (karbohidratPersen / 100) * energiValue;
                    const lemakValue = (lemakPersen / 100) * energiValue;

                    // Update tampilan hasil
                    $('#energi_hasil').text(Math.round(energiValue * 100) / 100);
                    $('#protein_hasil').text(Math.round(proteinValue * 100) / 100);
                    $('#karbohidrat_hasil').text(Math.round(karbohidratValue * 100) / 100);
                    $('#lemak_hasil').text(Math.round(lemakValue * 100) / 100);

                    // Update hidden inputs untuk dikirim ke controller (HASIL KALORI, BUKAN PERSENTASE)
                    $('#energi_calculated').val(Math.round(energiValue * 100) / 100);
                    $('#protein_calculated').val(Math.round(proteinValue * 100) / 100);
                    $('#karbohidrat_calculated').val(Math.round(karbohidratValue * 100) / 100);
                    $('#lemak_calculated').val(Math.round(lemakValue * 100) / 100);
                }
            }

            // Event listeners untuk perhitungan otomatis
            $('#energi_persen, #protein_persen, #karbohidrat_persen, #lemak_persen').on('input keyup', function() {
                calculateValues();
            });

            // Perhitungan awal jika ada nilai old
            calculateValues();

            // Form validation
            $('#formTambahMonitoring').on('submit', function(e) {
                let isValid = true;
                let errorMessage = '';
                const sourceType = isAnak ? 'kebutuhan kalori anak' : 'TEE';
                const assessmentType = isAnak ? 'pengkajian gizi anak' : 'pengkajian gizi dewasa';

                // Validasi energy value tersedia
                if (energyValue <= 0) {
                    isValid = false;
                    errorMessage += `Data ${sourceType} tidak tersedia. Silakan isi ${assessmentType} terlebih dahulu.\n`;
                }

                // Validasi field required
                $(this).find('input[required]').each(function() {
                    if ($(this).val().trim() === '' && !$(this).prop('disabled')) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                        errorMessage += 'Field ' + $(this).prev('label').text().replace('*', '') +
                            ' harus diisi\n';
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Validasi persentase
                const persentaseFields = ['energi_persen', 'protein_persen', 'karbohidrat_persen', 'lemak_persen'];
                persentaseFields.forEach(function(field) {
                    const value = parseFloat($('#' + field).val());
                    if (isNaN(value) || value < 0 || value > 100) {
                        isValid = false;
                        $('#' + field).addClass('is-invalid');
                        errorMessage += 'Field ' + $('#' + field).prev('label').text().replace('*', '') + 
                            ' harus berisi angka antara 0-100\n';
                    }
                });

                // Validasi bahwa hasil kalori sudah dihitung
                if (parseFloat($('#energi_calculated').val()) <= 0) {
                    isValid = false;
                    errorMessage += 'Perhitungan energi belum valid. Pastikan persentase energi sudah diisi.\n';
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Terjadi kesalahan:\n' + errorMessage);
                    return false;
                }

                // Show loading state
                $(this).find('button[type="submit"]').prop('disabled', true).html(
                    '<i class="ti-reload me-2"></i>Menyimpan...');
            });

            // Remove invalid class on input change
            $('.form-control').on('input change', function() {
                $(this).removeClass('is-invalid');
            });

            // Auto focus on first field
            $('#tanggal').focus();
        });
    </script>
@endpush