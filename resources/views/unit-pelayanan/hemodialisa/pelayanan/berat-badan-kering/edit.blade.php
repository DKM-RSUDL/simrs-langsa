@extends('layouts.administrator.master')

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

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .section-header {
            background-color: #f8f9fa;
            padding: 0.75rem;
            font-weight: 600;
            text-align: center;
            border: 1px solid #dee2e6;
            margin-bottom: 1rem;
            color: #097dd6;
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

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .form-row label {
            min-width: 200px;
            margin-bottom: 0;
            margin-right: 1rem;
        }

        .form-row .form-control {
            flex: 1;
            max-width: 300px;
        }

        .calculation-display {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            text-align: center;
            margin-top: 1rem;
        }

        .calculation-result {
            font-size: 1.5rem;
            font-weight: bold;
            color: #097dd6;
            margin-bottom: 0.5rem;
        }

        .calculation-formula {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .imt-status {
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-weight: 600;
            margin-top: 0.5rem;
            display: inline-block;
            font-size: 0.875rem;
        }

        .imt-underweight {
            background-color: #cce5ff;
            color: #004085;
        }

        .imt-normal {
            background-color: #d4edda;
            color: #155724;
        }

        .imt-overweight {
            background-color: #fff3cd;
            color: #856404;
        }

        .imt-obese {
            background-color: #f8d7da;
            color: #721c24;
        }

        .readonly-field {
            background-color: #f8f9fa !important;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .form-row label {
                min-width: auto;
                margin-bottom: 0.5rem;
                margin-right: 0;
            }

            .form-row .form-control {
                max-width: 100%;
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Perbarui Data Berat Badan Kering Pasien Hemodialisa',
                    'description' =>
                        ' Perbarui data Asesmen medis Hemodialisa dengan mengisi formulir di bawah ini.',
                ])

                <form id="beratBadanForm" method="POST"
                    action="{{ route('hemodialisa.pelayanan.berat-badan-kering.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $beratBadanKering->id]) }}">
                    @csrf
                    @method('PUT')
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif


                    <div class="section-separator mt-0">
                        <div class="section-header">DATA AWAL</div>

                        <div class="form-row">
                            <label class="form-label">Mulai HD:</label>
                            <input type="text" class="form-control readonly-field"
                                value="{{ $beratBadanKering->mulai_hd ? $beratBadanKering->mulai_hd->format('d/m/Y') : '-' }}"
                                readonly>
                            <input type="hidden" name="mulai_hd"
                                value="{{ $beratBadanKering->mulai_hd ? $beratBadanKering->mulai_hd->format('Y-m-d') : '' }}">
                        </div>

                        <div class="mt-3 mb-3">
                            <label class="col-form-label">
                                Periode yang akan diedit:
                                <span class="text-primary">{{ $beratBadanKering->nama_bulan }}
                                    {{ $beratBadanKering->tahun }}</span>
                            </label>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-row">
                                    <label for="tahun" class="form-label">Tahun:</label>
                                    <input type="text" class="form-control readonly-field"
                                        value="{{ $beratBadanKering->tahun }}" readonly>
                                    <input type="hidden" name="periode_tahun" value="{{ $beratBadanKering->tahun }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-row">
                                    <label for="bulan" class="form-label">Bulan:</label>
                                    <input type="text" class="form-control readonly-field"
                                        value="{{ $beratBadanKering->nama_bulan }}" readonly>
                                    <input type="hidden" name="periode_bulan" value="{{ $beratBadanKering->bulan }}">
                                </div>
                            </div>
                        </div>

                        <small class="text-info d-block">
                            <i class="ti-info-circle"></i> Periode tidak dapat diubah saat edit. Untuk
                            mengubah periode, hapus data ini dan buat data baru.
                        </small>
                    </div>

                    <!-- INPUT DATA -->
                    <div class="section-separator">
                        <div class="section-header">INPUT DATA</div>

                        <div class="form-row">
                            <label for="bbk">Berat Badan Kering (BBK):</label>
                            <div class="input-group">
                                <input type="number" id="bbk" name="bbk" class="form-control" step="0.1"
                                    min="0" max="200" placeholder="0.0"
                                    value="{{ old('bbk', $beratBadanKering->bbk) }}" required>
                                <div class="input-group-text">Kg</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="berat_badan">Berat Badan:</label>
                            <div class="input-group">
                                <input type="number" id="berat_badan" name="berat_badan" class="form-control"
                                    step="0.1" min="0" max="200" placeholder="0.0"
                                    value="{{ old('berat_badan', $beratBadanKering->berat_badan) }}" required>
                                <div class="input-group-text">Kg</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="tinggi_badan">Tinggi Badan:</label>
                            <div class="input-group">
                                <input type="number" id="tinggi_badan" name="tinggi_badan" class="form-control"
                                    step="0.1" min="50" max="250" placeholder="0.0"
                                    value="{{ old('tinggi_badan', $beratBadanKering->tinggi_badan) }}" required>
                                <div class="input-group-text">cm</div>
                            </div>
                        </div>

                        <!-- HASIL IMT -->
                        <div class="calculation-display">
                            <div class="calculation-result" id="imtResult">
                                {{ $beratBadanKering->imt }}
                            </div>
                            <div class="calculation-formula" id="imtFormula">
                                IMT = Berat Badan (kg) ÷ (Tinggi Badan (m))²
                            </div>
                            <div id="imtStatus">
                                <span
                                    class="imt-status imt-{{ strtolower($beratBadanKering->status_imt) }}">{{ $beratBadanKering->status_imt }}</span>
                            </div>
                        </div>

                        <input type="hidden" id="imt_calculated" name="imt"
                            value="{{ old('imt', $beratBadanKering->imt) }}">
                    </div>

                    <!-- CATATAN -->
                    <div class="section-separator">
                        <div class="section-header">CATATAN</div>

                        <div class="form-group">
                            <label for="catatan" class="form-label">Catatan:</label>
                            <textarea id="catatan" name="catatan" class="form-control" rows="3"
                                placeholder="Catatan kondisi pasien atau informasi penting lainnya...">{{ old('catatan', $beratBadanKering->catatan) }}</textarea>
                        </div>
                    </div>

                    <div class="text-end">
                        <x-button-submit>Perbarui</x-button-submit>
                    </div>
        </div>
    </div>
    </div>
    </form>
    </x-content-card>
    </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const beratBadanInput = document.getElementById('berat_badan');
            const tinggiBadanInput = document.getElementById('tinggi_badan');
            const imtResult = document.getElementById('imtResult');
            const imtFormula = document.getElementById('imtFormula');
            const imtStatus = document.getElementById('imtStatus');
            const imtCalculated = document.getElementById('imt_calculated');

            function calculateIMT() {
                const beratBadan = parseFloat(beratBadanInput.value) || 0;
                const tinggiBadan = parseFloat(tinggiBadanInput.value) || 0;

                if (beratBadan > 0 && tinggiBadan > 0) {
                    const tinggiMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiMeter * tinggiMeter);

                    imtResult.textContent = imt.toFixed(1);
                    imtFormula.textContent = `${beratBadan} ÷ (${tinggiMeter.toFixed(2)})² = ${imt.toFixed(1)}`;
                    imtCalculated.value = imt.toFixed(1);

                    let status = '';
                    let className = '';

                    if (imt < 18.5) {
                        status = 'Kurus';
                        className = 'imt-underweight';
                    } else if (imt >= 18.5 && imt < 25) {
                        status = 'Normal';
                        className = 'imt-normal';
                    } else if (imt >= 25 && imt < 30) {
                        status = 'Overweight';
                        className = 'imt-overweight';
                    } else {
                        status = 'Obesitas';
                        className = 'imt-obese';
                    }

                    imtStatus.innerHTML = `<span class="imt-status ${className}">${status}</span>`;
                } else {
                    imtResult.textContent = 'Masukkan berat dan tinggi badan';
                    imtFormula.textContent = 'IMT = Berat Badan (kg) ÷ (Tinggi Badan (m))²';
                    imtStatus.innerHTML = '';
                    imtCalculated.value = '';
                }
            }

            // Hitung IMT saat halaman dimuat dengan data existing
            calculateIMT();

            beratBadanInput.addEventListener('input', calculateIMT);
            tinggiBadanInput.addEventListener('input', calculateIMT);

            document.getElementById('beratBadanForm').addEventListener('submit', function(e) {
                const bbk = parseFloat(document.getElementById('bbk').value);
                const beratBadan = parseFloat(beratBadanInput.value);
                const tinggiBadan = parseFloat(tinggiBadanInput.value);
                const imt = parseFloat(imtCalculated.value);

                if (!bbk || !beratBadan || !tinggiBadan) {
                    e.preventDefault();
                    alert('BBK, Berat Badan, dan Tinggi Badan harus diisi!');
                    return;
                }

                if (bbk <= 0 || beratBadan <= 0 || tinggiBadan <= 0) {
                    e.preventDefault();
                    alert('BBK, Berat Badan, dan Tinggi Badan harus lebih dari 0!');
                    return;
                }

                if (!imt) {
                    e.preventDefault();
                    alert('IMT tidak berhasil dihitung!');
                    return;
                }
            });

            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('focus', function() {
                    this.select();
                });
            });
        });
    </script>
@endpush
