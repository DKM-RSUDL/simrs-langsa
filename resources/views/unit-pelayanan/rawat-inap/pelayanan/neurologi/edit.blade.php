@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>

    </style>
@endpush

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.neurologi.edit-include')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            {{-- @include('components.navigation-ranap') --}}

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">

                        <a href="{{ url()->previous() }}" class="btn">
                            <i class="ti-arrow-left"></i> Kembali
                        </a>

                        <div class="col-md-8">
                            <h4 class="header-asesmen">Asesmen Awal Medis Penyakit Syaraf (Neurologi)</h4>
                            <p class="text-muted mb-4">
                                <i class="bi bi-info-circle me-2"></i>
                                Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayananc
                            </p>
                        </div>

                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('rawat-inap.asesmen.medis.neurologi.update', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                                'id' => $asesmen->id,
                            ]) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                            <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                            <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                            <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                            <div class="card-body">
                                <div class="mb-4">
                                    <h5 class="mb-0">ANAMNESIS</h5>
                                    <div class="card-body">
                                        <!-- Form group untuk semua input -->
                                        <div class="form-group">
                                            <!-- Keluhan Utama -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-file-medical me-1 text-primary"></i>
                                                    Keluhan utama/ Alasan masuk RS mulai, lama, pencetus:
                                                </label>
                                                <textarea class="form-control" id="keluhan_utama" name="keluhan_utama" rows="2"
                                                    placeholder="Tuliskan keluhan utama dan alasan pasien masuk RS...">{{ $asesmen->rmeAsesmenNeurologi->keluhan_utama ?? '' }}</textarea>
                                            </div>

                                            <!-- Riwayat Penyakit Sekarang -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-clipboard-plus me-1 text-primary"></i>
                                                    Riwayat penyakit sekarang:
                                                </label>
                                                <textarea class="form-control" id="riwayat_penyakit_sekarang" name="riwayat_penyakit_sekarang" rows="3"
                                                    placeholder="Tuliskan riwayat penyakit yang sedang dialami...">{{ $asesmen->rmeAsesmenNeurologi->riwayat_penyakit_sekarang ?? '' }}</textarea>
                                            </div>

                                            <!-- Riwayat Penyakit Terdahulu -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-calendar-minus me-1 text-primary"></i>
                                                    Riwayat penyakit terdahulu:
                                                </label>
                                                <textarea class="form-control" id="riwayat_penyakit_terdahulu" name="riwayat_penyakit_terdahulu" rows="2"
                                                    placeholder="Tuliskan riwayat penyakit yang pernah dialami sebelumnya...">{{ $asesmen->rmeAsesmenNeurologi->riwayat_penyakit_terdahulu ?? '' }}</textarea>
                                            </div>

                                            <!-- Riwayat Penyakit Keluarga -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-people me-1 text-primary"></i>
                                                    Riwayat penyakit dalam keluarga:
                                                </label>
                                                <textarea class="form-control" id="riwayat_penyakit_keluarga" name="riwayat_penyakit_keluarga" rows="2"
                                                    placeholder="Tuliskan riwayat penyakit yang ada dalam keluarga...">{{ $asesmen->rmeAsesmenNeurologi->riwayat_penyakit_keluarga ?? '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="mb-4">

                                            <!-- Riwayat Pengobatan --> <!-- Riwayat Pengobatan -->
                                            <h6 class="text-dark">Riwayat Pengobatan</h6>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="riwayat_pengobatan" id="tidak_ada" value="0"
                                                            {{ ($asesmen->rmeAsesmenNeurologi->riwayat_pengobatan ?? 0) == 0 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="tidak_ada">Tidak ada</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="riwayat_pengobatan" id="ada" value="1"
                                                            {{ ($asesmen->rmeAsesmenNeurologi->riwayat_pengobatan ?? 0) == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="ada">Ada</label>
                                                    </div>
                                                </div>

                                                <div class="mt-3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="input-group">
                                                                <span class="input-group-text bg-light">Keterangan</span>
                                                                <textarea class="form-control" name="riwayat_pengobatan_keterangan" rows="2"
                                                                    placeholder="Tuliskan detail riwayat pengobatan pasien...">{{ $asesmen->rmeAsesmenNeurologi->riwayat_pengobatan_keterangan ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Riwayat Alergi -->
                                            <div class="mb-3">
                                                <h6 class="text-dark">Riwayat Alergi</h6>
                                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                    id="openAlergiModal" data-bs-toggle="modal"
                                                    data-bs-target="#alergiModal">
                                                    <i class="ti-plus"></i> Tambah Alergi
                                                </button>
                                                <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="createAlergiTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="20%">Jenis Alergi</th>
                                                                <th width="25%">Alergen</th>
                                                                <th width="25%">Reaksi</th>
                                                                <th width="20%">Tingkat Keparahan</th>
                                                                <th width="10%">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="no-alergi-row">
                                                                <td colspan="5" class="text-center text-muted">Tidak
                                                                    ada data alergi</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                @push('modals')
                                                    @include('unit-pelayanan.rawat-inap.pelayanan.neurologi.modal-edit-elergi')
                                                @endpush
                                            </div>

                                            <!-- Status Present -->
                                            <h6 class="mb-0">STATUS PRESENT</h6>
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <!-- Tekanan Darah -->
                                                    <div class="form-group">
                                                        <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                                        <div class="d-flex gap-3" style="width: 100%;">
                                                            <div class="flex-grow-1">
                                                                <input type="number" class="form-control"
                                                                    name="darah_sistole" placeholder="Sistole"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologi->darah_sistole ?? '' }}">
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <input type="number" class="form-control"
                                                                    name="darah_diastole" placeholder="Diastole"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologi->darah_diastole ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text bg-light text-dark fw-bold"
                                                                style="width: 150px;">
                                                                Respirasi
                                                            </span>
                                                            <input type="text" class="form-control text-center"
                                                                id="respirasi" name="respirasi" placeholder="0"
                                                                value="{{ $asesmen->rmeAsesmenNeurologi->respirasi ?? '' }}">
                                                            <span class="input-group-text">x/menit</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text bg-light text-dark fw-bold"
                                                                style="width: 150px;">
                                                                Suhu
                                                            </span>
                                                            <input type="text" class="form-control text-center"
                                                                id="suhu" name="suhu" placeholder="0"
                                                                value="{{ $asesmen->rmeAsesmenNeurologi->suhu ?? '' }}">
                                                            <span class="input-group-text">°C</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-">
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text bg-light text-dark fw-bold"
                                                                style="width: 150px;">
                                                                Nadi
                                                            </span>
                                                            <input type="text" class="form-control text-center"
                                                                id="nadi" name="nadi" placeholder="0"
                                                                value="{{ $asesmen->rmeAsesmenNeurologi->nadi ?? '' }}">
                                                            <span class="input-group-text">x/menit</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="border-3 border-primary">

                                            <div class="row g-3">
                                                <div class="pemeriksaan-fisik">
                                                    <h6>Pemeriksaan Fisik</h6>
                                                    <p class="text-small">Centang normal jika fisik yang dinilai
                                                        normal,
                                                        pilih tanda tambah
                                                        untuk menambah keterangan fisik yang ditemukan tidak normal.
                                                        Jika
                                                        tidak dipilih salah satunya, maka pemeriksaan tidak
                                                        dilakukan.
                                                    </p>
                                                    <div class="row">
                                                        @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                            <div class="col-md-6">
                                                                <div class="d-flex flex-column gap-3">
                                                                    @foreach ($chunk as $item)
                                                                        @php
                                                                            // Cari data pemeriksaan fisik untuk item ini
                                                                            $pemeriksaanData = $asesmen->pemeriksaanFisik
                                                                                ->where('id_item_fisik', $item->id)
                                                                                ->first();
                                                                            $keterangan = '';
                                                                            $isNormal = true;

                                                                            if ($pemeriksaanData) {
                                                                                $keterangan =
                                                                                    $pemeriksaanData->keterangan;
                                                                                $isNormal = empty($keterangan);
                                                                            }
                                                                        @endphp
                                                                        <div class="pemeriksaan-item">
                                                                            <div
                                                                                class="d-flex align-items-center border-bottom pb-2">
                                                                                <div class="flex-grow-1">
                                                                                    {{ $item->nama }}
                                                                                </div>
                                                                                <div class="form-check me-3">
                                                                                    <input type="checkbox"
                                                                                        class="form-check-input"
                                                                                        id="{{ $item->id }}-normal"
                                                                                        name="{{ $item->id }}-normal"
                                                                                        {{ $isNormal ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="{{ $item->id }}-normal">Normal</label>
                                                                                </div>
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                                    type="button"
                                                                                    data-target="{{ $item->id }}-keterangan">
                                                                                    <i class="bi bi-plus"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="keterangan mt-2"
                                                                                id="{{ $item->id }}-keterangan"
                                                                                style="display:{{ $isNormal ? 'none' : 'block' }};">
                                                                                <input type="text" class="form-control"
                                                                                    name="{{ $item->id }}_keterangan"
                                                                                    placeholder="Tambah keterangan jika tidak normal..."
                                                                                    value="{{ $keterangan }}">
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="border-3 border-primary">

                                            <div class="card-body">
                                                <h5 class="fw-bold mb-4">I. Sistem Syaraf</h5>

                                                <!-- Kesadaran -->
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label>Kesadaran Kualitatif</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control"
                                                            name="kesadaran_kulitatif"
                                                            value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label>Kesadaran Kuantitatif</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                            <span class="input-group-text">E:</span>
                                                            <input type="text" class="form-control"
                                                                name="kesadaran_kulitatif_e"
                                                                value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif_e ?? '' }}">
                                                            <span class="input-group-text">M:</span>
                                                            <input type="text" class="form-control"
                                                                name="kesadaran_kulitatif_m"
                                                                value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif_m ?? '' }}">
                                                            <span class="input-group-text">V:</span>
                                                            <input type="text" class="form-control"
                                                                name="kesadaran_kulitatif_v"
                                                                value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif_v ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Pupil -->
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <div class="input-group">
                                                                <label style="min-width: 170px;"
                                                                    class="fw-normal">Pupil</label>
                                                                <select class="form-select" name="pupil_isokor"
                                                                    id="pupil_isokor">
                                                                    <option value="">Pilih...</option>
                                                                    <option value="Isokor"
                                                                        {{ ($asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_isokor ?? '') == 'Isokor' ? 'selected' : '' }}>
                                                                        Isokor</option>
                                                                    <option value="Anisokor"
                                                                        {{ ($asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_isokor ?? '') == 'Anisokor' ? 'selected' : '' }}>
                                                                        Anisokor</option>
                                                                </select>
                                                                <span class="input-group-text">Ø:</span>
                                                                <input type="text" class="form-control"
                                                                    style="width: 60px" name="pupil_anisokor"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_anisokor ?? '' }}">
                                                                <span class="input-group-text">mm</span>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2 d-flex gap-4">
                                                            <!-- Refleks Cahaya -->
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-2">
                                                                    <label class="form-check-label" for="refleks_cahaya">
                                                                        Refleks cahaya:
                                                                    </label>
                                                                </div>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Kiri" name="pupil_cahaya_kiri"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_cahaya_kiri ?? '' }}">
                                                                    <span class="input-group-text">/</span>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Kanan" name="pupil_cahaya_kanan"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_cahaya_kanan ?? '' }}">
                                                                </div>
                                                            </div>

                                                            <!-- Refleks Kornea -->
                                                            <div class="d-flex align-items-center">
                                                                <div class="form-check me-2">
                                                                    <label class="form-check-label" for="refleks_kornea">
                                                                        Refleks kornea:
                                                                    </label>
                                                                </div>
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Kiri" name="pupil_kornea_kiri"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_kornea_kiri ?? '' }}">
                                                                    <span class="input-group-text">/</span>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="Kanan" name="pupil_kornea_kanan"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_kornea_kanan ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Nervus Cranialis -->
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label>Nervus Cranialis</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control"
                                                            name="nervus_cranialis"
                                                            value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->nervus_cranialis ?? '' }}">
                                                    </div>
                                                </div>

                                                <!-- Ekstremitas -->
                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label>Ekstremitas Gerakan</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="ekstremitas_atas" placeholder="Kanan Atas"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_atas ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="ekstremitas_kanan" placeholder="Kiri Atas"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_kanan ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="ekstremitas_bawah" placeholder="Kanan Bawah"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_bawah ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="ekstremitas_kiri" placeholder="Kiri Bawah"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_kiri ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label>Refleks</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="refleks_atas" placeholder="Kanan Atas"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_atas ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="refleks_kanan" placeholder="Kiri Atas"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_kanan ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="refleks_bawah" placeholder="Kanan Bawah"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_bawah ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="refleks_kiri" placeholder="Kiri Bawah"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_kiri ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label>Refleks Patologis</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="refleks_patologis_atas" placeholder="Kanan Atas"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_atas ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="refleks_patologis_kanan" placeholder="Kiri Atas"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_kanan ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="refleks_patologis_bawah"
                                                                    placeholder="Kanan Bawah"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_bawah ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="refleks_patologis_kiri" placeholder="Kiri Bawah"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_kiri ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-2">
                                                        <label>Kekuatan</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="kekuatan_atas" placeholder="Kanan Atas"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_atas ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="kekuatan_kanan" placeholder="Kiri Atas"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_kanan ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="kekuatan_bawah" placeholder="Kanan Bawah"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_bawah ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" class="form-control"
                                                                    name="kekuatan_kiri" placeholder="Kiri Bawah"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_kiri ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="">
                                                    <!-- Section 1: -->
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 col-lg-3">
                                                                <label class="form-label fw-medium">Klonus</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Kiri" name="klonus_kiri"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->klonus_kiri ?? '' }}">
                                                                    <span
                                                                        class="input-group-text border-secondary">/</span>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Kanan" name="klonus_kanan"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->klonus_kanan ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <label class="form-label fw-medium">Laseque</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Kiri" name="laseque_kiri"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->laseque_kiri ?? '' }}">
                                                                    <span
                                                                        class="input-group-text border-secondary">/</span>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Kanan" name="laseque_kanan"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->laseque_kanan ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <label class="form-label fw-medium">Patrick</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Kiri" name="patrick_kiri"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->patrick_kiri ?? '' }}">
                                                                    <span
                                                                        class="input-group-text border-secondary">/</span>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Kanan" name="patrick_kanan"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->patrick_kanan ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <label class="form-label fw-medium">Kontra Patrick</label>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Kiri" name="kontra_kiri"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kontra_kiri ?? '' }}">
                                                                    <span
                                                                        class="input-group-text border-secondary">/</span>
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Kanan" name="kontra_kanan"
                                                                        value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kontra_kanan ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Section 2: -->
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-medium">Kaku Kuduk</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Hasil pemeriksaan" name="kaku_kuduk"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kaku_kuduk ?? '' }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-medium">Tes Brudzinski</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Hasil pemeriksaan" name="tes_brudzinski"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tes_brudzinski ?? '' }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-medium">Tanda Kernig</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Hasil pemeriksaan" name="tanda_kerning"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tanda_kerning ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Section 3: -->
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label">Nistagmus</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Hasil pemeriksaan" name="nistagmus"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->nistagmus ?? '' }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Dismitri</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Hasil pemeriksaan" name="dismitri"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->dismitri ?? '' }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label">Disdiadokokinesis</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Hasil pemeriksaan"
                                                                    name="disdiadokokinesis"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->disdiadokokinesis ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Section 4: -->
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-medium">Tes Romberg</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Hasil tes" name="tes_romberg"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tes_romberg ?? '' }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-medium">Ataksia</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Ada/Tidak" name="ataksia"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ataksia ?? '' }}">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-medium">Cara Berjalan</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Deskripsi cara berjalan"
                                                                    name="cara_berjalan"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->cara_berjalan ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Section 5: -->
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Tremor</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Ada/Tidak" name="tremor"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tremor ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Khorea</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Ada/Tidak" name="khorea"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->khorea ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Balismus</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Ada/Tidak" name="balismus"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->balismus ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Atetose</label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    placeholder="Ada/Tidak" name="atetose"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->atetose ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Sensibilitas -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label>Sensibilitas:</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control"
                                                                name="sensibilitas"
                                                                value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->sensibilitas ?? '' }}">
                                                        </div>
                                                    </div>

                                                    <!-- Fungsi Vegetatif -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label>Fungsi Vegetatif:</label>
                                                        </div>
                                                        <div class="col-md-10">
                                                            <div class="input-group">
                                                                <span class="input-group-text">Miksi:</span>
                                                                <input type="text" class="form-control" name="miksi"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->miksi ?? '' }}">
                                                            </div>
                                                            <div class="input-group mt-2">
                                                                <span class="input-group-text">Defekasi:</span>
                                                                <input type="text" class="form-control"
                                                                    name="defekasi"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->defekasi ?? '' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr class="border-3 border-primary">

                                            <div class="card-body">
                                                <h5 class="fw-bold mb-4">m. Intensitas Nyeri</h5>

                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-start gap-4">
                                                            <div class="d-flex align-items-center gap-3"
                                                                style="min-width: 350px;">
                                                                <input type="number"
                                                                    class="form-control flex-grow-1 @error('skala_nyeri') is-invalid @enderror"
                                                                    name="skala_nyeri" style="width: 100px;"
                                                                    value="{{ old('skala_nyeri', $asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri ?? 0) }}"
                                                                    min="0" max="10">
                                                                @error('skala_nyeri')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                                <button type="button" class="btn btn-sm btn-success"
                                                                    id="skalaNyeriBtn">
                                                                    Tidak Nyeri
                                                                    <input type="number" class="form-control flex-grow-1"
                                                                        name="skala_nyeri_nilai" style="width: 100px;"
                                                                        value="{{ old('skala_nyeri_nilai', $asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri_nilai ?? 0) }}"
                                                                        min="0" max="10">
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <!-- Button Controls -->
                                                        <div class="btn-group mb-3">
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-scale="numeric">
                                                                A. Numeric Rating Pain Scale
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                                data-scale="wong-baker">
                                                                B. Wong Baker Faces Pain Scale
                                                            </button>
                                                        </div>

                                                        <!-- Pain Scale Images -->
                                                        <div id="wongBakerScale" class="pain-scale-image flex-grow-1"
                                                            style="display: none;">
                                                            <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                                alt="Wong Baker Pain Scale"
                                                                style="width: 450px; height: auto;">
                                                        </div>

                                                        <div id="numericScale" class="pain-scale-image flex-grow-1"
                                                            style="display: none;">
                                                            <img src="{{ asset('assets/img/asesmen/numerik.png') }}"
                                                                alt="Numeric Pain Scale"
                                                                style="width: 450px; height: auto;">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="section-separator" id="diagnosis">
                                                    <h5 class="fw-semibold mb-4">Diagnosis</h5>

                                                    @php
                                                        // Parse existing diagnosis data from database
                                                        $diagnosisBanding = !empty(
                                                            $asesmen->rmeAsesmenNeurologiIntensitasNyeri
                                                                ->diagnosis_banding
                                                        )
                                                            ? json_decode(
                                                                $asesmen->rmeAsesmenNeurologiIntensitasNyeri
                                                                    ->diagnosis_banding,
                                                                true,
                                                            )
                                                            : [];
                                                        $diagnosisKerja = !empty(
                                                            $asesmen->rmeAsesmenNeurologiIntensitasNyeri
                                                                ->diagnosis_kerja
                                                        )
                                                            ? json_decode(
                                                                $asesmen->rmeAsesmenNeurologiIntensitasNyeri
                                                                    ->diagnosis_kerja,
                                                                true,
                                                            )
                                                            : [];
                                                    @endphp

                                                    <!-- Diagnosis Banding -->
                                                    <div class="mb-4">
                                                        <label class="text-primary fw-semibold mb-2">Diagnosis
                                                            Banding</label>
                                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen
                                                            untuk mencari
                                                            diagnosis banding,
                                                            apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                                            diagnosis
                                                            banding yang tidak ditemukan.</small>

                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text bg-white border-end-0">
                                                                <i class="bi bi-search text-secondary"></i>
                                                            </span>
                                                            <input type="text" id="diagnosis-banding-input"
                                                                class="form-control border-start-0 ps-0"
                                                                placeholder="Cari dan tambah Diagnosis Banding">
                                                            <span class="input-group-text bg-white"
                                                                id="add-diagnosis-banding">
                                                                <i class="bi bi-plus-circle text-primary"></i>
                                                            </span>
                                                        </div>

                                                        <div id="diagnosis-banding-list"
                                                            class="diagnosis-list bg-light p-3 rounded">
                                                            <!-- Existing diagnosis will be loaded here -->
                                                        </div>

                                                        <!-- Hidden input for form submission -->
                                                        <input type="hidden" id="diagnosis_banding"
                                                            name="diagnosis_banding"
                                                            value="{{ json_encode($diagnosisBanding) }}">
                                                    </div>

                                                    <!-- Diagnosis Kerja -->
                                                    <div class="mb-4">
                                                        <label class="text-primary fw-semibold mb-2">Diagnosis
                                                            Kerja</label>
                                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen
                                                            untuk mencari
                                                            diagnosis kerja,
                                                            apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                                            diagnosis
                                                            kerja yang tidak ditemukan.</small>

                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text bg-white border-end-0">
                                                                <i class="bi bi-search text-secondary"></i>
                                                            </span>
                                                            <input type="text" id="diagnosis-kerja-input"
                                                                class="form-control border-start-0 ps-0"
                                                                placeholder="Cari dan tambah Diagnosis Kerja">
                                                            <span class="input-group-text bg-white"
                                                                id="add-diagnosis-kerja">
                                                                <i class="bi bi-plus-circle text-primary"></i>
                                                            </span>
                                                        </div>

                                                        <div id="diagnosis-kerja-list"
                                                            class="diagnosis-list bg-light p-3 rounded">
                                                            <!-- Existing diagnosis will be loaded here -->
                                                        </div>

                                                        <!-- Hidden input for form submission -->
                                                        <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                                            value="{{ json_encode($diagnosisKerja) }}">
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="form-label fw-bold">
                                                            <i class="bi bi-clipboard-plus me-1 text-primary"></i>
                                                            Rencana penatalaksanaan dan pengobatan:
                                                        </label>
                                                        <textarea class="form-control" id="rencana_pengobatan" name="rencana_pengobatan" rows="3"
                                                            placeholder="Tuliskan Rencana penatalaksanaan dan pengobatan...">{{ old('rencana_pengobatan', $asesmen->rmeAsesmenNeurologiIntensitasNyeri->rencana_pengobatan ?? '') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="section-separator" id="prognosis">
                                                    <h5 class="fw-semibold mb-4">Prognosis</h5>
                                                    <select class="form-select" name="neurologi_prognosis">
                                                        <option value="" disabled>--Pilih Prognosis--</option>
                                                        @forelse ($satsetPrognosis as $item)
                                                            <option value="{{ $item->prognosis_id }}"
                                                                {{ old('neurologi_prognosis', $asesmen->rmeAsesmenNeurologiIntensitasNyeri[0]->neurologi_prognosis ?? '') == $item->prognosis_id ? 'selected' : '' }}>
                                                                {{ $item->value ?? 'Field tidak ditemukan' }}
                                                            </option>
                                                        @empty
                                                            <option value="" disabled>Tidak ada data</option>
                                                        @endforelse
                                                    </select>
                                                </div>

                                                {{-- <div class="section-separator" style="margin-bottom: 2rem;">
                                                    <h5 class="fw-semibold mb-4">10. Implementasi</h5>

                                                    @php
                                                        // Parse existing implementation data
                                                        $implementationData = [
                                                            'observasi' => !empty(
                                                                $asesmen->rmeAsesmenNeurologiIntensitasNyeri->observasi
                                                            )
                                                                ? json_decode(
                                                                    $asesmen->rmeAsesmenNeurologiIntensitasNyeri
                                                                        ->observasi,
                                                                    true,
                                                                )
                                                                : [],
                                                            'terapeutik' => !empty(
                                                                $asesmen->rmeAsesmenNeurologiIntensitasNyeri->terapeutik
                                                            )
                                                                ? json_decode(
                                                                    $asesmen->rmeAsesmenNeurologiIntensitasNyeri
                                                                        ->terapeutik,
                                                                    true,
                                                                )
                                                                : [],
                                                            'edukasi' => !empty(
                                                                $asesmen->rmeAsesmenNeurologiIntensitasNyeri->edukasi
                                                            )
                                                                ? json_decode(
                                                                    $asesmen->rmeAsesmenNeurologiIntensitasNyeri
                                                                        ->edukasi,
                                                                    true,
                                                                )
                                                                : [],
                                                            'kolaborasi' => !empty(
                                                                $asesmen->rmeAsesmenNeurologiIntensitasNyeri->kolaborasi
                                                            )
                                                                ? json_decode(
                                                                    $asesmen->rmeAsesmenNeurologiIntensitasNyeri
                                                                        ->kolaborasi,
                                                                    true,
                                                                )
                                                                : [],
                                                            'prognosis' => !empty(
                                                                $asesmen->rmeAsesmenNeurologiIntensitasNyeri->prognosis
                                                            )
                                                                ? json_decode(
                                                                    $asesmen->rmeAsesmenNeurologiIntensitasNyeri
                                                                        ->prognosis,
                                                                    true,
                                                                )
                                                                : [],
                                                        ];
                                                    @endphp

                                                    <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                                    <div class="mb-4">
                                                        <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan
                                                            Pengobatan</label>
                                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen
                                                            untuk mencari
                                                            rencana, apabila tidak ada,
                                                            Pilih tanda tambah untuk menambah keterangan rencana yang tidak
                                                            ditemukan.</small>
                                                    </div>

                                                    <!-- Observasi Section -->
                                                    <div class="mb-4">
                                                        <label class="fw-semibold mb-2">Observasi</label>
                                                        <div class="input-group mt-2">
                                                            <span class="input-group-text bg-white border-end-0">
                                                                <i class="bi bi-search text-secondary"></i>
                                                            </span>
                                                            <input type="text" id="observasi-input"
                                                                class="form-control border-start-0 ps-0"
                                                                placeholder="Cari dan tambah Observasi">
                                                            <span class="input-group-text bg-white" id="add-observasi">
                                                                <i class="bi bi-plus-circle text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <div id="observasi-list"
                                                            class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                            <!-- Items will be added here dynamically -->
                                                        </div>
                                                        <input type="hidden" id="observasi" name="observasi"
                                                            value="{{ json_encode($implementationData['observasi']) }}">
                                                    </div>

                                                    <!-- Terapeutik Section -->
                                                    <div class="mb-4">
                                                        <label class="fw-semibold mb-2">Terapeutik</label>
                                                        <div class="input-group mt-2">
                                                            <span class="input-group-text bg-white border-end-0">
                                                                <i class="bi bi-search text-secondary"></i>
                                                            </span>
                                                            <input type="text" id="terapeutik-input"
                                                                class="form-control border-start-0 ps-0"
                                                                placeholder="Cari dan tambah Terapeutik">
                                                            <span class="input-group-text bg-white" id="add-terapeutik">
                                                                <i class="bi bi-plus-circle text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <div id="terapeutik-list"
                                                            class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                            <!-- Items will be added here dynamically -->
                                                        </div>
                                                        <input type="hidden" id="terapeutik" name="terapeutik"
                                                            value="{{ json_encode($implementationData['terapeutik']) }}">
                                                    </div>

                                                    <!-- Edukasi Section -->
                                                    <div class="mb-4">
                                                        <label class="fw-semibold mb-2">Edukasi</label>
                                                        <div class="input-group mt-2">
                                                            <span class="input-group-text bg-white border-end-0">
                                                                <i class="bi bi-search text-secondary"></i>
                                                            </span>
                                                            <input type="text" id="edukasi-input"
                                                                class="form-control border-start-0 ps-0"
                                                                placeholder="Cari dan tambah Edukasi">
                                                            <span class="input-group-text bg-white" id="add-edukasi">
                                                                <i class="bi bi-plus-circle text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <div id="edukasi-list"
                                                            class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                            <!-- Items will be added here dynamically -->
                                                        </div>
                                                        <input type="hidden" id="edukasi" name="edukasi"
                                                            value="{{ json_encode($implementationData['edukasi']) }}">
                                                    </div>

                                                    <!-- Kolaborasi Section -->
                                                    <div class="mb-4">
                                                        <label class="fw-semibold mb-2">Kolaborasi</label>
                                                        <div class="input-group mt-2">
                                                            <span class="input-group-text bg-white border-end-0">
                                                                <i class="bi bi-search text-secondary"></i>
                                                            </span>
                                                            <input type="text" id="kolaborasi-input"
                                                                class="form-control border-start-0 ps-0"
                                                                placeholder="Cari dan tambah Kolaborasi">
                                                            <span class="input-group-text bg-white" id="add-kolaborasi">
                                                                <i class="bi bi-plus-circle text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <div id="kolaborasi-list"
                                                            class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                            <!-- Items will be added here dynamically -->
                                                        </div>
                                                        <input type="hidden" id="kolaborasi" name="kolaborasi"
                                                            value="{{ json_encode($implementationData['kolaborasi']) }}">
                                                    </div>

                                                    <!-- Prognosis Section -->
                                                    <div class="mb-4">
                                                        <label class="text-primary fw-semibold">Prognosis</label>
                                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen
                                                            untuk mencari
                                                            Prognosis,
                                                            apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                                            Prognosis
                                                            yang tidak ditemukan.</small>
                                                        <div class="input-group mt-2">
                                                            <span class="input-group-text bg-white border-end-0">
                                                                <i class="bi bi-search text-secondary"></i>
                                                            </span>
                                                            <input type="text" id="prognosis-input"
                                                                class="form-control border-start-0 ps-0"
                                                                placeholder="Cari dan tambah Prognosis">
                                                            <span class="input-group-text bg-white" id="add-prognosis">
                                                                <i class="bi bi-plus-circle text-primary"></i>
                                                            </span>
                                                        </div>
                                                        <div id="prognosis-list"
                                                            class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                                            <!-- Items will be added here dynamically -->
                                                        </div>
                                                        <input type="hidden" id="prognosis" name="prognosis"
                                                            value="{{ json_encode($implementationData['prognosis']) }}">
                                                    </div>
                                                </div> --}}

                                            </div>

                                            <hr class="border-3 border-primary">

                                            <div class="border-0">
                                                <!-- Header Section -->
                                                <h6 class="mb-0 fw-bold text-primary">
                                                    <i class="bi bi-hospital me-2"></i>
                                                    PERENCANAAN PULANG PASIEN (DISCHARGE PLANNING)
                                                </h6>

                                                <!-- Main Content -->
                                                <div class="card-body pt-4">
                                                    <!-- Checklist Questions -->
                                                    <div class="row g-4">
                                                        <!-- Usia Lanjut -->
                                                        <div class="col-lg-6">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between border-bottom pb-2">
                                                                <label class="form-check-label">Usia lanjut (> 60
                                                                    th)</label>
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <input type="radio" class="btn-check"
                                                                        name="usia_lanjut" id="usia_ya" value="ya"
                                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->usia_lanjut == 'ya' ? 'checked' : '' }}>
                                                                    <label class="btn btn-outline-primary px-4"
                                                                        for="usia_ya">Ya</label>
                                                                    <input type="radio" class="btn-check"
                                                                        name="usia_lanjut" id="usia_tidak" value="tidak"
                                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->usia_lanjut == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="btn btn-outline-primary px-4"
                                                                        for="usia_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Hambatan Mobilisasi -->
                                                        <div class="col-lg-6">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between border-bottom pb-2">
                                                                <label class="form-check-label">Hambatan mobilisasi</label>
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <input type="radio" class="btn-check"
                                                                        name="hambatan_mobilisasi" id="hambatan_ya"
                                                                        value="ya"
                                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->hambatan_mobilisasi == 'ya' ? 'checked' : '' }}>
                                                                    <label class="btn btn-outline-primary px-4"
                                                                        for="hambatan_ya">Ya</label>
                                                                    <input type="radio" class="btn-check"
                                                                        name="hambatan_mobilisasi" id="hambatan_tidak"
                                                                        value="tidak"
                                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->hambatan_mobilisasi == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="btn btn-outline-primary px-4"
                                                                        for="hambatan_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Membutuhkan pelayanan -->
                                                        <div class="col-lg-6">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between border-bottom pb-2">
                                                                <label class="form-check-label">Membutuhkan pelayanan medis
                                                                    berkelanjutan</label>
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <input type="radio" class="btn-check"
                                                                        name="pelayanan_medis" id="pelayanan_ya"
                                                                        value="ya"
                                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->pelayanan_medis == 'ya' ? 'checked' : '' }}>
                                                                    <label class="btn btn-outline-primary px-4"
                                                                        for="pelayanan_ya">Ya</label>
                                                                    <input type="radio" class="btn-check"
                                                                        name="pelayanan_medis" id="pelayanan_tidak"
                                                                        value="tidak"
                                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->pelayanan_medis == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="btn btn-outline-primary px-4"
                                                                        for="pelayanan_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Ketergantungan -->
                                                        <div class="col-lg-6">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between border-bottom pb-2">
                                                                <label class="form-check-label">Ketergantungan dengan orang
                                                                    lain dalam aktivitas harian</label>
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <input type="radio" class="btn-check"
                                                                        name="ketergantungan" id="ketergantungan_ya"
                                                                        value="ya"
                                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->ketergantungan == 'ya' ? 'checked' : '' }}>
                                                                    <label class="btn btn-outline-primary px-4"
                                                                        for="ketergantungan_ya">Ya</label>
                                                                    <input type="radio" class="btn-check"
                                                                        name="ketergantungan" id="ketergantungan_tidak"
                                                                        value="tidak"
                                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->ketergantungan == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="btn btn-outline-primary px-4"
                                                                        for="ketergantungan_tidak">Tidak</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Info Alert -->
                                                    <div class="alert alert-warning bg-opacity-10 border border-warning border-opacity-25 mt-4 mb-4"
                                                        id="discharge-planning-label">
                                                        <small class="d-flex align-items-center">
                                                            Tidak membutuhkan rencana pulang
                                                            khusus
                                                        </small>
                                                    </div>

                                                    <!-- Tambahkan id dan name yang spesifik untuk form fields -->
                                                    <div class="mb-4">
                                                        <label class="form-label fw-semibold mb-2">Rencana Pulang
                                                            Khusus:</label>
                                                        <textarea class="form-control bg-light" id="rencana_pulang_khusus" name="rencana_pulang_khusus" rows="3"
                                                            placeholder="Tuliskan rencana pulang khusus jika diperlukan..." style="resize: none;" disabled>{{ $asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_pulang_khusus ?? '' }}</textarea>
                                                    </div>

                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label fw-semibold mb-2">Rencana Lama
                                                                    Perawatan:</label>
                                                                <input type="text" class="form-control bg-light"
                                                                    id="rencana_lama_perawatan"
                                                                    name="rencana_lama_perawatan"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_lama_perawatan ?? '' }}"
                                                                    placeholder="Contoh: 7 hari" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label fw-semibold mb-2">Rencana Tanggal
                                                                    Pulang:</label>
                                                                <input type="date" class="form-control bg-light"
                                                                    id="rencana_tanggal_pulang"
                                                                    name="rencana_tanggal_pulang"
                                                                    value="{{ $asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_tanggal_pulang ?? '' }}"
                                                                    disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="section-separator" style="margin-bottom: 2rem;" id="evaluasi">
                                                <h5 class="fw-semibold mb-4">Evaluasi</h5>
                                                <div class="form-group">
                                                    <label style="min-width: 200px;">Tambah Evaluasi Keperawatan</label>
                                                    <textarea class="form-control" name="evaluasi_evaluasi_keperawatan" rows="4"
                                                        placeholder="Evaluasi Keperawaran">{{ $asesmen->rmeAsesmenNeurologi->evaluasi_evaluasi_keperawatan ?? '' }}</textarea>
                                                </div>
                                            </div> --}}

                                            <div class="d-flex justify-content-end mt-4">
                                                <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">
                                                    <i class="ti-arrow-left"></i> Kembali
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-save me-1"></i>
                                                    Update Data
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
