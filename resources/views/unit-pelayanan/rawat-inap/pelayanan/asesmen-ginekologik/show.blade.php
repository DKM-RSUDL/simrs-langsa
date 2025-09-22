@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.show-include')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                <div class="d-flex justify-content-end">
                    {{-- <a href="{{ route('rawat-inap.asesmen.medis.ginekologik.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $asesmen->id]) }}"
                        class="btn btn-sm btn-info">
                        <i class="fas fa-print"></i> print
                    </a> --}}
                    <a href="{{ route('rawat-inap.asesmen.medis.ginekologik.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $asesmen->id]) }}"
                        class="btn btn-sm btn-secondary ms-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>

            <div class="">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Asesmen Awal Medis Ginekologik</h5>
                    <p class="mb-0">Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan</p>
                </div>
                <div class="card-body">

                    <!-- 1. Data masuk -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">1. Data masuk</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Petugas:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->user->name ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kondisi Masuk:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologik->kondisi_masuk ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tanggal Dan Jam Masuk:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologik->tanggal ? date('d M Y', strtotime($asesmen->rmeAsesmenGinekologik->tanggal)) : '-' }}
                                                {{ $asesmen->rmeAsesmenGinekologik->jam_masuk ? date('H:i', strtotime($asesmen->rmeAsesmenGinekologik->jam_masuk)) : '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kondisi Masuk:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologik->diagnosis_masuk ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. G/P/A (Gravida, Para, Abortus) -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">2. G/P/A (Gravida, Para, Abortus)</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Gravida:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologik->gravida ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Para:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologik->para ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Abortus:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologik->abortus ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Keluhan Utama -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">3. Keluhan Utama</h5>
                        <div class="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Keluhan Utama/Alasan Masuk RS:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologik->keluhan_utama ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Riwayat Penyakit:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologik->riwayat_penyakit ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-calendar-heart me-2 text-primary"></i>
                                                Riwayat Haid:
                                            </label>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label">Siklus:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologik->siklus ? $asesmen->rmeAsesmenGinekologik->siklus . ' Hari' : '-' }}
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">HPHT:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if ($asesmen->rmeAsesmenGinekologik->hpht)
                                                            {{ \Carbon\Carbon::parse($asesmen->rmeAsesmenGinekologik->hpht)->format('d/m/Y') }}
                                                            <small class="text-muted d-block">
                                                                {{ \Carbon\Carbon::parse($asesmen->rmeAsesmenGinekologik->hpht)->diffForHumans() }}
                                                            </small>
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Usia Kehamilan:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if ($asesmen->rmeAsesmenGinekologik->usia_kehamilan_display)
                                                            <span class="badge bg-success">
                                                                {{ $asesmen->rmeAsesmenGinekologik->usia_kehamilan_display }}
                                                            </span>
                                                            @if ($asesmen->rmeAsesmenGinekologik->usia_kehamilan_total_hari)
                                                                <small class="text-muted d-block">
                                                                    Total:
                                                                    {{ $asesmen->rmeAsesmenGinekologik->usia_kehamilan_total_hari }}
                                                                    hari
                                                                </small>
                                                            @endif
                                                        @elseif($asesmen->rmeAsesmenGinekologik->usia_minggu || $asesmen->rmeAsesmenGinekologik->usia_hari)
                                                            <span class="badge bg-info">
                                                                {{ $asesmen->rmeAsesmenGinekologik->usia_minggu ?? 0 }}
                                                                minggu
                                                                {{ $asesmen->rmeAsesmenGinekologik->usia_hari ?? 0 }} hari
                                                            </span>
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>

                                            @if ($asesmen->rmeAsesmenGinekologik->hpht && $asesmen->rmeAsesmenGinekologik->usia_minggu)
                                                <!-- Detail Summary Card -->
                                                <div class="mt-3">
                                                    <div class="border-success">
                                                        <div class="card-header bg-success text-white py-2">
                                                            <h6 class="mb-0">
                                                                <i class="fas fa-info-circle me-2"></i>
                                                                Ringkasan Kehamilan
                                                            </h6>
                                                        </div>
                                                        <div class="card-body py-2">
                                                            <div class="row text-center">
                                                                <div class="col-md-3">
                                                                    <div class="border-end">
                                                                        <h5 class="text-primary mb-1">
                                                                            {{ $asesmen->rmeAsesmenGinekologik->usia_minggu ?? 0 }}
                                                                        </h5>
                                                                        <small class="text-muted">Minggu</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="border-end">
                                                                        <h5 class="text-info mb-1">
                                                                            {{ $asesmen->rmeAsesmenGinekologik->usia_hari ?? 0 }}
                                                                        </h5>
                                                                        <small class="text-muted">Hari</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="border-end">
                                                                        <h5 class="text-warning mb-1">
                                                                            {{ $asesmen->rmeAsesmenGinekologik->usia_kehamilan_total_hari ?? 0 }}
                                                                        </h5>
                                                                        <small class="text-muted">Total Hari</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Perkawinan:</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label">Jumlah:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologik->jumlah ? $asesmen->rmeAsesmenGinekologik->jumlah . ' Kali' : '-' }}
                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Dengan Suami Sekarang:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologik->tahun ? ucfirst($asesmen->rmeAsesmenGinekologik->tahun) : '-' }}
                                                    </p>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Jumlah Suami:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologik->jumlah_suami ? $asesmen->rmeAsesmenGinekologik->jumlah_suami . ' Orang' : '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Riwayat Obstetrik -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">4. Riwayat Obstetrik</h5>
                        <div class="card">
                            <div class="card-body">
                                @if (!empty($asesmen->rmeAsesmenGinekologik->riwayat_obstetrik))
                                    @php
                                        // Safely decode JSON, with error handling
                                        $riwayatObstetrik =
                                            json_decode($asesmen->rmeAsesmenGinekologik->riwayat_obstetrik, true) ?? [];
                                    @endphp
                                    @if (!empty($riwayatObstetrik) && is_array($riwayatObstetrik))
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Keadaan</th>
                                                        <th>Kehamilan</th>
                                                        <th>Cara Persalinan</th>
                                                        <th>Keadaan Nifas</th>
                                                        <th>Tanggal Lahir</th>
                                                        <th>Keadaan Anak</th>
                                                        <th>Tempat dan Penolong</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($riwayatObstetrik as $index => $item)
                                                        <tr>
                                                            <td>{{ $item['keadaan'] ?? '-' }}</td>
                                                            <td>{{ $item['kehamilan'] ?? '-' }}</td>
                                                            <td>{{ $item['caraPersalinan'] ?? '-' }}</td>
                                                            <td>{{ $item['keadaanNifas'] ?? '-' }}</td>
                                                            <td>
                                                                {{ !empty($item['tanggalLahir']) ? date('d M Y', strtotime($item['tanggalLahir'])) : '-' }}
                                                            </td>
                                                            <td>{{ $item['keadaanAnak'] ?? '-' }}</td>
                                                            <td>{{ $item['tempatPenolong'] ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="form-control-plaintext border-bottom">
                                            <span class="text-muted">Tidak ada</span>
                                        </p>
                                    @endif
                                @else
                                    <p class="form-control-plaintext border-bottom">
                                        <span class="text-muted">Tidak ada</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 5. Riwayat Penyakit Dahulu -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">5. Riwayat Penyakit Dahulu/Termasuk Operasi dan Keluarga Berencana</h5>
                        <div class="card">
                            <div class="card-body">
                                <p class="form-control-plaintext border-bottom">
                                    {{ $asesmen->rmeAsesmenGinekologik->riwayat_penyakit_dahulu ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="section-separator">
                        <h5 class="section-title">
                            <i class="fas fa-heartbeat me-2 text-danger"></i>
                            6. Tanda Vital
                        </h5>

                        <!-- Tekanan Darah -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tekanan Darah:</label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Sistole (mmHg):</label>
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikTandaVital->tekanan_darah_sistole ?? '-' }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Diastole (mmHg):</label>
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikTandaVital->tekanan_darah_diastole ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Vital Signs Row 1 -->
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Suhu:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        @if ($asesmen->rmeAsesmenGinekologikTandaVital->suhu)
                                            @php
                                                $suhu = $asesmen->rmeAsesmenGinekologikTandaVital->suhu;
                                            @endphp
                                            <span>
                                                {{ $suhu }}°C
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Respirasi:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        @if ($asesmen->rmeAsesmenGinekologikTandaVital->respirasi)
                                            @php
                                                $respirasi = $asesmen->rmeAsesmenGinekologikTandaVital->respirasi;
                                            @endphp
                                            <span>
                                                {{ $respirasi }} x/menit
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">saturasi oksigen:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        @if ($asesmen->rmeAsesmenGinekologikTandaVital->nadi)
                                            @php
                                                $nadi = $asesmen->rmeAsesmenGinekologikTandaVital->nadi;
                                            @endphp
                                            <span>
                                                {{ $nadi }} x/menit
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Antropometri -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-weight me-2 text-info"></i>
                                Antropometri:
                            </label>
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Berat Badan:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikTandaVital->berat_badan ? $asesmen->rmeAsesmenGinekologikTandaVital->berat_badan . ' kg' : '-' }}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tinggi Badan:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikTandaVital->tinggi_badan ? $asesmen->rmeAsesmenGinekologikTandaVital->tinggi_badan . ' cm' : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 7. Pemeriksaan Fisik -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">7. Pemeriksaan Fisik</h5>
                        <div class=" my-3">

                            <!-- Kesadaran -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Kesadaran:</label>
                                </div>
                                <div class="col-9">
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->paru_kesadaran ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Kepala -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Kepala:</label>
                                </div>
                                <div class="col-9">
                                    <p class="form-control-plaintext border-bottom">
                                        @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->kepala ?? 1) == 1)
                                            Normal
                                        @else
                                            Abnormal:
                                            {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->kepala_keterangan ?? '-' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Hidung -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Hidung:</label>
                                </div>
                                <div class="col-9">
                                    <p class="form-control-plaintext border-bottom">
                                        @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->hidung ?? 1) == 1)
                                            Normal
                                        @else
                                            Abnormal:
                                            {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->hidung_keterangan ?? '-' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Mata -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Mata:</label>
                                </div>
                                <div class="col-9">
                                    <p class="form-control-plaintext border-bottom">
                                        @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->mata ?? 1) == 1)
                                            Normal
                                        @else
                                            Abnormal:
                                            {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->mata_keterangan ?? '-' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Leher -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Leher:</label>
                                </div>
                                <div class="col-9">
                                    <p class="form-control-plaintext border-bottom">
                                        @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->leher ?? 1) == 1)
                                            Normal
                                        @else
                                            Abnormal:
                                            {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->leher_keterangan ?? '-' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Tenggorokan -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Tenggorokan:</label>
                                </div>
                                <div class="col-9">
                                    <p class="form-control-plaintext border-bottom">
                                        @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->tenggorokan ?? 1) == 1)
                                            Normal
                                        @else
                                            Abnormal:
                                            {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->tenggorokan_keterangan ?? '-' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Dada -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Dada:</label>
                                </div>
                                <div class="col-9">
                                    <!-- Jantung -->
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            <span class="text-muted">Jantung:</span>
                                        </div>
                                        <div class="col-9">
                                            <p class="form-control-plaintext border-bottom">
                                                @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->jantung ?? 1) == 1)
                                                    Normal
                                                @else
                                                    Abnormal:
                                                    {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->jantung_keterangan ?? '-' }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Paru -->
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            <span class="text-muted">Paru:</span>
                                        </div>
                                        <div class="col-9">
                                            <p class="form-control-plaintext border-bottom">
                                                @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->paru ?? 1) == 1)
                                                    Normal
                                                @else
                                                    Abnormal:
                                                    {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->paru_keterangan ?? '-' }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Perut -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Perut:</label>
                                </div>
                                <div class="col-9">
                                    <!-- Hati -->
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            <span class="text-muted">Hati:</span>
                                        </div>
                                        <div class="col-9">
                                            <p class="form-control-plaintext border-bottom">
                                                @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->hati ?? 1) == 1)
                                                    Normal
                                                @else
                                                    Abnormal:
                                                    {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->hati_keterangan ?? '-' }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Limpa -->
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            <span class="text-muted">Limpa:</span>
                                        </div>
                                        <div class="col-9">
                                            <p class="form-control-plaintext border-bottom">
                                                @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->limpa ?? 1) == 1)
                                                    Normal
                                                @else
                                                    Abnormal:
                                                    {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->limpa_keterangan ?? '-' }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kulit -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Kulit:</label>
                                </div>
                                <div class="col-9">
                                    <p class="form-control-plaintext border-bottom">
                                        @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->kulit ?? 1) == 1)
                                            Normal
                                        @else
                                            Abnormal:
                                            {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->kulit_keterangan ?? '-' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Mulut/ gigi -->
                            <div class="row mb-3">
                                <div class="col-3">
                                    <label class="form-label fw-bold">Mulut/ gigi:</label>
                                </div>
                                <div class="col-9">
                                    <p class="form-control-plaintext border-bottom">
                                        @if (($asesmen->rmeAsesmenGinekologikPemeriksaanFisik->mulut_gigi ?? 1) == 1)
                                            Normal
                                        @else
                                            Abnormal:
                                            {{ $asesmen->rmeAsesmenGinekologikPemeriksaanFisik->mulut_gigi_keterangan ?? '-' }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- <div class="card-body">
                                <p class="mb-3 small bg-info bg-opacity-10 text-dark rounded-3 p-2">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Centang normal jika fisik yang dinilai normal. Jika tidak dipilih, maka pemeriksaan
                                    tidak dilakukan.
                                </p>

                                @if ($asesmen->pemeriksaanFisik->count() > 0 && $itemFisik->count() > 0)
                                <div class="row">
                                    @php
                                    // Buat mapping pemeriksaan fisik berdasarkan id_item_fisik
                                    $pemeriksaanFisikMap = [];
                                    foreach ($asesmen->pemeriksaanFisik as $item) {
                                    $pemeriksaanFisikMap[$item->id_item_fisik] = $item;
                                    }

                                    // Buat mapping nama item fisik
                                    $itemFisikNames = [];
                                    foreach ($itemFisik as $item) {
                                    $itemFisikNames[$item->id] = $item->nama;
                                    }

                                    // Bagi item fisik menjadi 2 kolom
                                    $totalItems = $itemFisik->count();
                                    $halfCount = ceil($totalItems / 2);
                                    $firstColumn = $itemFisik->take($halfCount);
                                    $secondColumn = $itemFisik->skip($halfCount);
                                    @endphp

                                    <!-- Kolom Pertama -->
                                    <div class="col-md-6">
                                        @foreach ($firstColumn as $fisikItem)
                                        @php
                                        // Cek apakah item ini ada dalam pemeriksaan
                                        $pemeriksaanItem = $pemeriksaanFisikMap[$fisikItem->id] ?? null;
                                        $status = $pemeriksaanItem->is_normal ?? null;
                                        $keterangan = $pemeriksaanItem->keterangan ?? '';
                                        $namaItem = $fisikItem->nama;
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                            <span>{{ $namaItem }}</span>
                                            <div class="d-flex align-items-center">
                                                @if ($status === '0' || $status === 0)
                                                <span class="badge bg-warning text-dark me-2">Tidak Normal</span>
                                                @elseif ($status === '1' || $status === 1)
                                                <span class="badge bg-success me-2">Normal</span>
                                                @else
                                                <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($keterangan && ($status === '0' || $status === 0))
                                        <div class="mt-1 mb-2">
                                            <small class="text-muted">Keterangan: {{ $keterangan }}</small>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>

                                    <!-- Kolom Kedua -->
                                    <div class="col-md-6">
                                        @foreach ($secondColumn as $fisikItem)
                                        @php
                                        // Cek apakah item ini ada dalam pemeriksaan
                                        $pemeriksaanItem = $pemeriksaanFisikMap[$fisikItem->id] ?? null;
                                        $status = $pemeriksaanItem->is_normal ?? null;
                                        $keterangan = $pemeriksaanItem->keterangan ?? '';
                                        $namaItem = $fisikItem->nama;
                                        @endphp
                                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                            <span>{{ $namaItem }}</span>
                                            <div class="d-flex align-items-center">
                                                @if ($status === '0' || $status === 0)
                                                <span class="badge bg-warning text-dark me-2">Tidak Normal</span>
                                                @elseif ($status === '1' || $status === 1)
                                                <span class="badge bg-success me-2">Normal</span>
                                                @else
                                                <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($keterangan && ($status === '0' || $status === 0))
                                        <div class="mt-1 mb-2">
                                            <small class="text-muted">Keterangan: {{ $keterangan }}</small>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Data pemeriksaan fisik tidak tersedia.
                                    <br>
                                    <small class="text-muted">
                                        Debug Info:
                                        Pemeriksaan Fisik: {{ $asesmen->pemeriksaanFisik->count() }} item,
                                        Item Fisik: {{ $itemFisik->count() }} item
                                    </small>
                                </div>
                                @endif
                            </div> --}}
                        </div>
                    </div>

                    <!-- 8. Pemeriksaan Ekstremitas -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">8. Pemeriksaan Ekstremitas</h5>
                        <div class="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0 fw-semibold">Ekstremitas Atas</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Edema:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->edema_atas ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Varises:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->varises_atas ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Refleks:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->refleks_atas ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card h-100">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0 fw-semibold">Ekstremitas Bawah</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Edema:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->edema_bawah ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Varises:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->varises_bawah ?? '-' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Refleks:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->refleks_bawah ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Catatan Tambahan:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->catatan_ekstremitas ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 9. Status Ginekologik dan Pemeriksaan -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">9. Status Ginekologik dan Pemeriksaan</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Keadaan Umum:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->keadaan_umum ?? '-' }}
                                            </p>
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label class="form-label fw-bold">Status Ginekologik:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->status_ginekologik ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pemeriksaan:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->pemeriksaan ?? '-' }}
                                            </p>
                                        </div> --}}

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Inspekulo:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->inspekulo ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">VT (Vaginal Toucher):</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->vt ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">RT (Rectal Toucher):</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->rt ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 10. Hasil Pemeriksaan Penunjang -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">10. Hasil Pemeriksaan Penunjang</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Laboratorium:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->laboratorium ?? '-' }}
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">USG:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->usg ?? '-' }}
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Radiologi:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->radiologi ?? '-' }}
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Lainnya:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->penunjang_lainnya ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 11. Discharge Planning -->
                    {{-- <div class="section-separator mb-4">
                        <h5 class="section-title">11. Discharge Planning</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis Medis:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->diagnosis_medis ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Usia Lanjut:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->usia_lanjut == '0' ? 'Ya' : ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->usia_lanjut == '1' ? 'Tidak' : '-') }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Hambatan Mobilisasi:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->hambatan_mobilisasi == '0' ? 'Ya' : ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->hambatan_mobilisasi == '1' ? 'Tidak' : '-') }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Membutuhkan Penggunaan Media
                                                Berkelanjutan:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->penggunaan_media_berkelanjutan ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Ketergantungan dengan Orang Lain dalam
                                                Aktivitas Harian:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->ketergantungan_aktivitas ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pasien/Keluarga Memerlukan Keterampilan Khusus
                                                Setelah Pulang:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->keterampilan_khusus ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pasien Memerlukan Alat Bantu Setelah Keluar
                                                Rumah Sakit:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->alat_bantu ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pasien Memiliki Nyeri Kronis dan/atau
                                                Kebiasaan Setelah Pulang:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->nyeri_kronis ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Perkiraan Lama Hari Dirawat:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->perkiraan_hari ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Rencana Tanggal Pulang:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->tanggal_pulang ? date('d M Y', strtotime($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->tanggal_pulang)) : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Kesimpulan:</label>
                                    <p class="form-control-plaintext border-bottom">
                                        {{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->kesimpulan_planing ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- 12. Diagnosis -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">11. Diagnosis</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="text-primary fw-semibold mb-2">Prognosis</label>
                                            <select class="form-select" name="paru_prognosis" disabled>
                                                <option value="" disabled
                                                    {{ !old(
                                                        'paru_prognosis',
                                                        isset($asesmen->rmeAsesmenGinekologik) ? $asesmen->rmeAsesmenGinekologik->paru_prognosis : '',
                                                    )
                                                        ? 'selected'
                                                        : '' }}>
                                                    --Pilih Prognosis--</option>
                                                @forelse ($satsetPrognosis as $item)
                                                    <option value="{{ $item->prognosis_id }}"
                                                        {{ old(
                                                            'paru_prognosis',
                                                            isset($asesmen->rmeAsesmenGinekologik) ? $asesmen->rmeAsesmenGinekologik->paru_prognosis : '',
                                                        ) == $item->prognosis_id
                                                            ? 'selected'
                                                            : '' }}>
                                                        {{ $item->value ?? 'Field tidak ditemukan' }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled>Tidak ada data</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis Banding:</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis banding yang tidak ditemukan.</small>
                                            @php
                                                $diagnosisBanding = [];
                                                $diagnosisKerja = [];
                                                $observasi = [];
                                                $terapeutik = [];
                                                $edukasi = [];
                                                $kolaborasi = [];
                                                $prognosis = [];

                                                if ($asesmen->rmeAsesmenGinekologikDiagnosisImplementasi) {
                                                    $implementasi =
                                                        $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi;
                                                    $diagnosisBanding = json_decode(
                                                        $implementasi->diagnosis_banding ?? '[]',
                                                        true,
                                                    );
                                                    $diagnosisKerja = json_decode(
                                                        $implementasi->diagnosis_kerja ?? '[]',
                                                        true,
                                                    );
                                                    $observasi = json_decode($implementasi->observasi ?? '[]', true);
                                                    $terapeutik = json_decode($implementasi->terapeutik ?? '[]', true);
                                                    $edukasi = json_decode($implementasi->edukasi ?? '[]', true);
                                                    $kolaborasi = json_decode($implementasi->kolaborasi ?? '[]', true);
                                                    $prognosis = json_decode($implementasi->prognosis ?? '[]', true);
                                                }
                                            @endphp

                                            @if (!empty($diagnosisBanding))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Diagnosis Banding</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($diagnosisBanding as $index => $diagnosis)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $diagnosis }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="form-control-plaintext border-bottom">
                                                    <span class="text-muted">Tidak ada</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis Kerja:</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis kerja yang tidak ditemukan.</small>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($diagnosisKerja))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Diagnosis Kerja</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($diagnosisKerja as $index => $diagnosis)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $diagnosis }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="form-control-plaintext border-bottom">
                                                    <span class="text-muted">Tidak ada</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 13. Implementasi -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">12. Implementasi</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan Pengobatan</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                        rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Observasi:</label>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($observasi))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Observasi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($observasi as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="form-control-plaintext border-bottom">
                                                    <span class="text-muted">Tidak ada</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Terapeutik:</label>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($terapeutik))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Terapeutik</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($terapeutik as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="form-control-plaintext border-bottom">
                                                    <span class="text-muted">Tidak ada</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Edukasi:</label>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($edukasi))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Edukasi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($edukasi as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="form-control-plaintext border-bottom">
                                                    <span class="text-muted">Tidak ada</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kolaborasi:</label>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($kolaborasi))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kolaborasi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($kolaborasi as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="form-control-plaintext border-bottom">
                                                    <span class="text-muted">Tidak ada</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label style="min-width: 200px;">Rencana Penatalaksanaan <br> Dan
                                                Pengobatan</label>
                                            <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                                placeholder="Rencana Penatalaksanaan Dan Pengobatan">{{ old('rencana_pengobatan', isset($asesmen->rmeAsesmenGinekologik) ? $asesmen->rmeAsesmenGinekologik->rencana_pengobatan : '') }}</textarea>
                                        </div>
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
