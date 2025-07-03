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
            <a href="{{ route('hemodialisa.pelayanan.berat-badan-kering.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="beratBadanForm" method="POST"
                action="{{ route('hemodialisa.pelayanan.berat-badan-kering.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Form Tambah Data Berat Badan Kering Pasien Hemodialisis</h4>
                            </div>

                            <div class="px-3">
                                <div class="section-separator">
                                    <div class="section-header">DATA AWAL</div>

                                    @php
                                        $existingHdData = App\Models\RmeHdBeratBadanKering::where(
                                            'kd_pasien',
                                            $dataMedis->kd_pasien,
                                        )->first();
                                        $mulaiHd = $existingHdData ? $existingHdData->mulai_hd : null;
                                        
                                        // Ambil data pengisian terakhir
                                        $pengisianTerakhir = App\Models\RmeHdBeratBadanKering::where(
                                            'kd_pasien',
                                            $dataMedis->kd_pasien,
                                        )->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->first();
                                    @endphp

                                    @if ($mulaiHd)
                                        <small class="text-danger mb-3 d-block">
                                            <i class="ti-info-circle"></i> Tanggal mulai HD sudah ditetapkan sebelumnya dan
                                            tidak dapat diubah
                                        </small>
                                        <div class="form-row">
                                            <label class="form-label">Mulai HD:</label>
                                            <input type="text" class="form-control"
                                                value="{{ $mulaiHd->format('d/m/Y') }}" readonly
                                                style="background-color: #f8f9fa;">
                                            <input type="hidden" name="mulai_hd" value="{{ $mulaiHd->format('Y-m-d') }}">
                                        </div>
                                    @else
                                        <div class="form-row">
                                            <label for="mulai_hd" class="form-label">Mulai HD:</label>
                                            <input type="date" id="mulai_hd" name="mulai_hd" class="form-control"
                                                value="{{ old('mulai_hd') }}" required>
                                        </div>
                                        <small class="text-warning mb-3 d-block">
                                            <i class="ti-alert-triangle"></i> <strong>Penting:</strong> Tanggal ini akan
                                            digunakan untuk semua periode data selanjutnya dan tidak dapat diubah lagi
                                        </small>
                                    @endif

                                    <div class="mt-3 mb-3">
                                        @if($pengisianTerakhir)
                                            <label class="col-form-label">
                                                Silahkan pilih periode 
                                                <span class="text-primary">(*Pengisian terakhir: {{ $pengisianTerakhir->nama_bulan }} {{ $pengisianTerakhir->tahun }})</span>
                                            </label>
                                        @else
                                            <label class="col-form-label">
                                                Silahkan pilih periode 
                                                <span class="text-muted">(Belum ada data sebelumnya)</span>
                                            </label>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-row">
                                                <label for="tahun" class="form-label">Tahun:</label>
                                                <select id="tahun" name="periode_tahun" class="form-control" required>
                                                    <option value="">-- Pilih Tahun --</option>
                                                    @for ($year = date('Y') - 2; $year <= date('Y') + 5; $year++)
                                                        <option value="{{ $year }}"
                                                            {{ $year == date('Y') ? 'selected' : '' }}>
                                                            {{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-row">
                                            <label for="bulan" class="form-label">Bulan:</label>
                                            <select id="bulan" name="periode_bulan" class="form-control" required>
                                                <option value="">-- Pilih Bulan --</option>
                                                <option value="1">Januari</option>
                                                <option value="2">Februari</option>
                                                <option value="3">Maret</option>
                                                <option value="4">April</option>
                                                <option value="5">Mei</option>
                                                <option value="6">Juni</option>
                                                <option value="7">Juli</option>
                                                <option value="8">Agustus</option>
                                                <option value="9">September</option>
                                                <option value="10">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- INPUT DATA -->
                                <div class="section-separator">
                                    <div class="section-header">INPUT DATA</div>

                                    <div class="form-row">
                                        <label for="bbk">Berat Badan Kering (BBK):</label>
                                        <div class="input-group">
                                            <input type="number" id="bbk" name="bbk" class="form-control"
                                                step="0.1" min="0" max="200" placeholder="0.0" required>
                                            <div class="input-group-text">Kg</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <label for="berat_badan">Berat Badan:</label>
                                        <div class="input-group">
                                            <input type="number" id="berat_badan" name="berat_badan" class="form-control"
                                                step="0.1" min="0" max="200" placeholder="0.0" required>
                                            <div class="input-group-text">Kg</div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <label for="tinggi_badan">Tinggi Badan:</label>
                                        <div class="input-group">
                                            <input type="number" id="tinggi_badan" name="tinggi_badan"
                                                class="form-control" step="0.1" min="50" max="250"
                                                placeholder="0.0" required>
                                            <div class="input-group-text">cm</div>
                                        </div>
                                    </div>

                                    <!-- HASIL IMT -->
                                    <div class="calculation-display">
                                        <div class="calculation-result" id="imtResult">
                                            Masukkan berat dan tinggi badan
                                        </div>
                                        <div class="calculation-formula" id="imtFormula">
                                            IMT = Berat Badan (kg) ÷ (Tinggi Badan (m))²
                                        </div>
                                        <div id="imtStatus"></div>
                                    </div>

                                    <input type="hidden" id="imt_calculated" name="imt">
                                </div>

                                <!-- CATATAN -->
                                <div class="section-separator">
                                    <div class="section-header">CATATAN</div>

                                    <div class="form-group">
                                        <label for="catatan" class="form-label">Catatan:</label>
                                        <textarea id="catatan" name="catatan" class="form-control" rows="3"
                                            placeholder="Catatan kondisi pasien atau informasi penting lainnya..."></textarea>
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
