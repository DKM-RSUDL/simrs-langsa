@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .card-header {
                font-weight: bold;
            }

            .form-label {
                font-weight: 600;
                margin-bottom: 0.3rem;
            }

            .required::after {
                content: '*';
                color: red;
                margin-left: 0.2rem;
            }

            .input-group-text {
                background-color: #f8f9fa;
                border: 1px solid #ced4da;
                font-size: 12px;
                min-width: 50px;
            }

            /* Select2 Custom Styling */
            .select2-container--default .select2-selection--single {
                height: 38px;
                border: 1px solid #ced4da;
                border-radius: 4px;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #495057;
                line-height: 36px;
                padding-left: 12px;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px;
                right: 10px;
            }

            .select2-dropdown {
                border: 1px solid #ced4da;
                border-radius: 4px;
            }

            .info-text {
                font-size: 0.875rem;
                color: #6c757d;
                font-style: italic;
                margin-top: 0.25rem;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Perbarui Data Monitoring Transfusi Darah',
                    'description' =>
                        'Perbarui data monitoring transfusi darah pasien gawat darurat dengan mengisi formulir di bawah ini.',
                ])

                <form
                    action="{{ isset($monitoring)
                        ? route('pengawasan-darah.monitoring.update', [
                            'kd_pasien' => $dataMedis->kd_pasien,
                            'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                            'urut_masuk' => $dataMedis->urut_masuk,
                            'id' => $monitoring->id,
                        ])
                        : route('pengawasan-darah.monitoring.store', [
                            'kd_pasien' => $dataMedis->kd_pasien,
                            'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                            'urut_masuk' => $dataMedis->urut_masuk,
                        ]) }}"
                    method="post" id="monitoringForm">
                    @csrf
                    @if (isset($monitoring))
                        @method('PUT')
                    @endif

                    <!-- Informasi Dasar -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Informasi Dasar</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" class="form-control required" name="tanggal" required
                                            value="{{ old('tanggal', isset($monitoring) ? $monitoring->tanggal : date('Y-m-d')) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Jam</label>
                                        <input type="time" class="form-control required" name="jam" required
                                            value="{{ old('jam', isset($monitoring) ? date('H:i', strtotime($monitoring->jam)) : date('H:i')) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 15 Menit Sebelum Transfusi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">15 Menit Sebelum Transfusi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">TD Sistole</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="pre_td_sistole"
                                                placeholder="ex: 120" min="0" max="300"
                                                value="{{ old('pre_td_sistole', isset($monitoring) ? $monitoring->pre_td_sistole : '') }}">
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">TD Diastole</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="pre_td_diastole"
                                                placeholder="ex: 80" min="0" max="200"
                                                value="{{ old('pre_td_diastole', isset($monitoring) ? $monitoring->pre_td_diastole : '') }}">
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Nadi</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="pre_nadi" placeholder="ex: 80"
                                                min="0" max="200"
                                                value="{{ old('pre_nadi', isset($monitoring) ? $monitoring->pre_nadi : '') }}">
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" class="form-control" name="pre_temp"
                                                placeholder="ex: 36.5" min="30" max="45"
                                                value="{{ old('pre_temp', isset($monitoring) ? $monitoring->pre_temp : '') }}">
                                            <span class="input-group-text">°C</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">RR</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="pre_rr" placeholder="ex: 20"
                                                min="0" max="50"
                                                value="{{ old('pre_rr', isset($monitoring) ? $monitoring->pre_rr : '') }}">
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jam Mulai Transfusi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Jam Mulai Transfusi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="jam_mulai_transfusi"
                                        value="{{ old('jam_mulai_transfusi', isset($monitoring) ? $monitoring->jam_mulai_transfusi : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 15 Menit Setelah Darah Masuk -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">15 Menit Setelah Darah Masuk</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">TD Sistole</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post15_td_sistole"
                                                placeholder="ex: 120" min="0" max="300"
                                                value="{{ old('post15_td_sistole', isset($monitoring) ? $monitoring->post15_td_sistole : '') }}">
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">TD Diastole</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post15_td_diastole"
                                                placeholder="ex: 80" min="0" max="200"
                                                value="{{ old('post15_td_diastole', isset($monitoring) ? $monitoring->post15_td_diastole : '') }}">
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Nadi</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post15_nadi"
                                                placeholder="ex: 80" min="0" max="200"
                                                value="{{ old('post15_nadi', isset($monitoring) ? $monitoring->post15_nadi : '') }}">
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" class="form-control" name="post15_temp"
                                                placeholder="ex: 36.5" min="30" max="45"
                                                value="{{ old('post15_temp', isset($monitoring) ? $monitoring->post15_temp : '') }}">
                                            <span class="input-group-text">°C</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">RR</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post15_rr"
                                                placeholder="ex: 20" min="0" max="50"
                                                value="{{ old('post15_rr', isset($monitoring) ? $monitoring->post15_rr : '') }}">
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1 Jam Setelah Darah Masuk -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">1 Jam Setelah Darah Masuk</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">TD Sistole</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post1h_td_sistole"
                                                placeholder="ex: 120" min="0" max="300"
                                                value="{{ old('post1h_td_sistole', isset($monitoring) ? $monitoring->post1h_td_sistole : '') }}">
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">TD Diastole</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post1h_td_diastole"
                                                placeholder="ex: 80" min="0" max="200"
                                                value="{{ old('post1h_td_diastole', isset($monitoring) ? $monitoring->post1h_td_diastole : '') }}">
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Nadi</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post1h_nadi"
                                                placeholder="ex: 80" min="0" max="200"
                                                value="{{ old('post1h_nadi', isset($monitoring) ? $monitoring->post1h_nadi : '') }}">
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" class="form-control" name="post1h_temp"
                                                placeholder="ex: 36.5" min="30" max="45"
                                                value="{{ old('post1h_temp', isset($monitoring) ? $monitoring->post1h_temp : '') }}">
                                            <span class="input-group-text">°C</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">RR</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post1h_rr"
                                                placeholder="ex: 20" min="0" max="50"
                                                value="{{ old('post1h_rr', isset($monitoring) ? $monitoring->post1h_rr : '') }}">
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reaksi Selama Transfusi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Reaksi Selama Transfusi</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Reaksi Selama Transfusi</label>
                                <textarea class="form-control" name="reaksi_selama_transfusi" rows="3"
                                    placeholder="Deskripsikan reaksi yang terjadi selama transfusi (jika ada)">{{ old('reaksi_selama_transfusi', isset($monitoring) ? $monitoring->reaksi_selama_transfusi : '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Jam Selesai Transfusi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Jam Selesai Transfusi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="time" class="form-control" name="jam_selesai_transfusi"
                                        value="{{ old('jam_selesai_transfusi', isset($monitoring) ? $monitoring->jam_selesai_transfusi : '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4 Jam Setelah Transfusi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">4 Jam Setelah Transfusi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">TD Sistole</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post4h_td_sistole"
                                                placeholder="ex: 120" min="0" max="300"
                                                value="{{ old('post4h_td_sistole', isset($monitoring) ? $monitoring->post4h_td_sistole : '') }}">
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">TD Diastole</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post4h_td_diastole"
                                                placeholder="ex: 80" min="0" max="200"
                                                value="{{ old('post4h_td_diastole', isset($monitoring) ? $monitoring->post4h_td_diastole : '') }}">
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Nadi</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post4h_nadi"
                                                placeholder="ex: 80" min="0" max="200"
                                                value="{{ old('post4h_nadi', isset($monitoring) ? $monitoring->post4h_nadi : '') }}">
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Suhu</label>
                                        <div class="input-group">
                                            <input type="number" step="0.1" class="form-control" name="post4h_temp"
                                                placeholder="ex: 36.5" min="30" max="45"
                                                value="{{ old('post4h_temp', isset($monitoring) ? $monitoring->post4h_temp : '') }}">
                                            <span class="input-group-text">°C</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">RR</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="post4h_rr"
                                                placeholder="ex: 20" min="0" max="50"
                                                value="{{ old('post4h_rr', isset($monitoring) ? $monitoring->post4h_rr : '') }}">
                                            <span class="input-group-text">x/mnt</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reaksi Transfusi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Reaksi Transfusi</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Reaksi Transfusi</label>
                                <textarea class="form-control" name="reaksi_transfusi" rows="3"
                                    placeholder="Deskripsikan reaksi yang terjadi setelah transfusi (jika ada)">{{ old('reaksi_transfusi', isset($monitoring) ? $monitoring->reaksi_transfusi : '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Petugas -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Dokter/Perawat</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Dokter</label>
                                        <select name="dokter" class="form-select select2">
                                            <option value="">--Pilih Dokter--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}"
                                                    {{ old('dokter', isset($monitoring) ? $monitoring->dokter : '') == $dok->kd_dokter ? 'selected' : '' }}>
                                                    {{ $dok->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Perawat</label>
                                        <select name="perawat" class="form-select select2">
                                            <option value="">--Pilih Perawat--</option>
                                            @foreach ($perawat as $prwt)
                                                <option value="{{ $prwt->kd_karyawan }}"
                                                    {{ old('perawat', isset($monitoring) ? $monitoring->perawat : '') == $prwt->kd_karyawan ? 'selected' : '' }}>
                                                    {{ "$prwt->gelar_depan $prwt->nama $prwt->gelar_belakang" }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button Actions -->
                    <div class="text-end">
                        <x-button-submit-confirm label="Perbarui" confirmTitle="Sudah Yakin?"
                            confirmText="Pastikan semua data sudah lengkap sebelum disimpan. Lanjutkan menyimpan?"
                            confirmOk="Simpan" confirmCancel="Batal" :spinner="true" loadingLabel="Menyimpan..."
                            loadingOverlay="#loadingOverlay" />
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2
            $('.select2').select2({
                placeholder: 'Pilih...',
                allowClear: true,
                width: '100%'
            });

            // Validasi jam mulai dan selesai transfusi (hanya jika keduanya diisi)
            const jamMulaiInput = document.querySelector('input[name="jam_mulai_transfusi"]');
            const jamSelesaiInput = document.querySelector('input[name="jam_selesai_transfusi"]');

            function validateTransfusionTime() {
                if (jamMulaiInput.value && jamSelesaiInput.value) {
                    const jamMulai = new Date('2000-01-01 ' + jamMulaiInput.value);
                    const jamSelesai = new Date('2000-01-01 ' + jamSelesaiInput.value);

                    if (jamSelesai <= jamMulai) {
                        Swal.fire({
                            title: 'Peringatan',
                            text: 'Jam selesai transfusi harus lebih besar dari jam mulai transfusi',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        jamSelesaiInput.value = '';
                    }
                }
            }

            jamSelesaiInput.addEventListener('change', validateTransfusionTime);

            // Validasi form sebelum submit (dikurangi karena tidak ada required fields)
            document.getElementById('monitoringForm').addEventListener('submit', function(e) {
                // Validasi dokter dan perawat tidak boleh sama (jika keduanya diisi)
                const dokter = document.querySelector('select[name="dokter"]').value;
                const perawat = document.querySelector('select[name="perawat"]').value;

                if (dokter && perawat && dokter === perawat) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Dokter dan Perawat tidak boleh orang yang sama',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
            });

            // Auto-fill jam berdasarkan jam mulai (opsional)
            jamMulaiInput.addEventListener('change', function() {
                if (this.value && !jamSelesaiInput.value) {
                    // Auto suggest jam selesai 2 jam setelah jam mulai (opsional)
                    const jamMulai = new Date('2000-01-01 ' + this.value);
                    jamMulai.setHours(jamMulai.getHours() + 2);

                    if (jamMulai.getDate() === new Date('2000-01-01').getDate()) { // Tidak melewati hari
                        jamSelesaiInput.value = jamMulai.toTimeString().slice(0, 5);
                    }
                }
            });
        });
    </script>
@endpush
