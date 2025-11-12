@extends('layouts.administrator.master')

@section('content')

    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.create-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Asesmen Pengkajian Awal Medis',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])


                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('rawat-inap.asesmen.medis.pengkajian-awal-medis.update', [
                        'kd_unit' => request()->route('kd_unit'),
                        'kd_pasien' => request()->route('kd_pasien'),
                        'tgl_masuk' => request()->route('tgl_masuk'),
                        'urut_masuk' => request()->route('urut_masuk'),
                        'id' => $asesmen->id,
                    ]) }}">
                    @csrf
                    @if (isset($asesmen))
                        @method('PUT')
                    @endif

                    <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                    <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                    <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                    <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                    <!-- FORM ASESMEN -->
                    <div class="px-3">
                        <div class="section-separator" id="data-masuk">
                            <h5 class="section-title">1. Data masuk</h5>

                            <div class="form-group">
                                <label style="min-width: 200px;">Tanggal Dan Jam Pengisian</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    <input type="date" class="form-control" name="tanggal"
                                        value="{{ $asesmen->asesmenMedisRanap->tanggal ? \Carbon\Carbon::parse($asesmen->asesmenMedisRanap->tanggal)->format('Y-m-d') : date('Y-m-d') }}"
                                        {{ $readonly ?? false ? 'readonly' : '' }}>
                                    <input type="time" class="form-control" name="jam_masuk"
                                        value="{{ $asesmen->asesmenMedisRanap->jam ? \Carbon\Carbon::parse($asesmen->asesmenMedisRanap->jam)->format('H:i') : date('H:i') }}"
                                        {{ $readonly ?? false ? 'readonly' : '' }}>
                                </div>
                            </div>
                        </div>

                        <div class="section-separator" id="">
                            <h5 class="section-title">2. Anamnesis</h5>

                            <div class="form-group">
                                <label style="min-width: 200px;">Keluhan Utama</label>
                                <textarea class="form-control" name="keluhan_utama" rows="3" placeholder="Keluhan utama pasien"
                                    {{ $readonly ?? false ? 'readonly' : '' }}>{{ old('keluhan_utama', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->keluhan_utama : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Riwayat penyakit sekarang</label>
                                <textarea class="form-control" name="riwayat_penyakit_sekarang" rows="4" placeholder="Riwayat penyakit sekarang"
                                    {{ $readonly ?? false ? 'readonly' : '' }}>{{ old('riwayat_penyakit_sekarang', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->riwayat_penyakit_sekarang : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Riwayat penyakit terdahulu</label>
                                <textarea class="form-control" name="riwayat_penyakit_terdahulu" rows="4" placeholder="Riwayat penyakit terdahulu"
                                    {{ $readonly ?? false ? 'readonly' : '' }}>{{ old('riwayat_penyakit_terdahulu', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->riwayat_penyakit_terdahulu : '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Riwayat penyakit keluarga</label>
                                <textarea class="form-control" name="riwayat_penyakit_keluarga" rows="4"
                                    placeholder="Riwayat penyakit dalam keluarga" {{ $readonly ?? false ? 'readonly' : '' }}>{{ old('riwayat_penyakit_keluarga', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->riwayat_penyakit_keluarga : '') }}</textarea>
                            </div>
                        </div>

                        <div class="section-separator" id="riwayatObat">
                            <h5 class="section-title">3. Riwayat Penggunaan Obat</h5>

                            @if (!($readonly ?? false))
                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openObatModal">
                                    <i class="ti-plus"></i> Tambah
                                </button>
                            @endif

                            <input type="hidden" name="riwayat_penggunaan_obat" id="riwayatObatData"
                                value="{{ old('riwayat_penggunaan_obat', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->riwayat_penggunaan_obat : '[]') }}">

                            <div class="table-responsive">
                                <table class="table" id="createRiwayatObatTable">
                                    <thead>
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Dosis</th>
                                            <th>Aturan Pakai</th>
                                            @if (!($readonly ?? false))
                                                <th></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Table content will be dynamically populated -->
                                    </tbody>
                                </table>
                            </div>

                            @if (!($readonly ?? false))
                                @push('modals')
                                    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.modal-edit-obat')
                                @endpush
                            @endif
                        </div>

                        <div class="section-separator" id="alergi">
                            <h5 class="section-title">4. Alergi</h5>

                            @if (!($readonly ?? false))
                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openAlergiModal"
                                    data-bs-toggle="modal" data-bs-target="#alergiModal">
                                    <i class="ti-plus"></i> Tambah Alergi
                                </button>
                            @endif

                            <input type="hidden" name="alergis" id="alergisInput"
                                value="{{ old('alergis', isset($asesmen) ? $asesmen->alergis : '[]') }}">

                            <div class="table-responsive">
                                <table class="table table-bordered" id="createAlergiTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="20%">Jenis Alergi</th>
                                            <th width="25%">Alergen</th>
                                            <th width="25%">Reaksi</th>
                                            <th width="20%">Tingkat Keparahan</th>
                                            @if (!($readonly ?? false))
                                                <th width="10%">Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="no-alergi-row">
                                            <td colspan="{{ $readonly ?? false ? '4' : '5' }}"
                                                class="text-center text-muted">Tidak ada data alergi</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            @push('modals')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-pengkajian-awal-medis.modal-create-alergi')
                            @endpush
                        </div>

                        <div class="section-separator" id="riwayat-pengobatan">
                            <h5 class="section-title">5. Status present</h5>
                            <div class="form-group">
                                <label for="tingkat_kesadaran" style="min-width: 200px;">Tingkat Kesadaran</label>
                                <select class="form-select" name="tingkat_kesadaran"
                                    id="tingkat_kesadaran"{{ $readonly ?? false ? 'readonly' : '' }}>
                                    <option value=""
                                        {{ empty($asesmen->asesmenMedisRanap->tingkat_kesadaran) ? 'selected' : '' }}>
                                        Pilih tingkat kesadaran
                                    </option>
                                    <option value="1"
                                        {{ $asesmen->asesmenMedisRanap->tingkat_kesadaran == 1 ? 'selected' : '' }}>Compos
                                        Mentis</option>
                                    <option value="2"
                                        {{ $asesmen->asesmenMedisRanap->tingkat_kesadaran == 2 ? 'selected' : '' }}>Apatis
                                    </option>
                                    <option value="3"
                                        {{ $asesmen->asesmenMedisRanap->tingkat_kesadaran == 3 ? 'selected' : '' }}>
                                        Somnolen</option>
                                    <option value="4"
                                        {{ $asesmen->asesmenMedisRanap->tingkat_kesadaran == 4 ? 'selected' : '' }}>Sopor
                                    </option>
                                    <option value="5"
                                        {{ $asesmen->asesmenMedisRanap->tingkat_kesadaran == 5 ? 'selected' : '' }}>Koma
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    <div class="flex-grow-1">
                                        <label class="form-label">Sistole</label>
                                        <input type="number" class="form-control" name="sistole" placeholder="Sistole"
                                            value="{{ old('sistole', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->sistole : '') }}"
                                            {{ $readonly ?? false ? 'readonly' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label">Diastole</label>
                                        <input type="number" class="form-control" name="diastole"
                                            placeholder="Diastole"
                                            value="{{ old('diastole', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->diastole : '') }}"
                                            {{ $readonly ?? false ? 'readonly' : '' }}>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Respirasi (x/menit)</label>
                                <input type="number" class="form-control" name="respirasi"
                                    placeholder="Respirasi per menit"
                                    value="{{ old('respirasi', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->respirasi : '') }}"
                                    {{ $readonly ?? false ? 'readonly' : '' }}>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Suhu (C)</label>
                                <input type="text" class="form-control" name="suhu" placeholder="Suhu"
                                    value="{{ old('suhu', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->suhu : '') }}"
                                    {{ $readonly ?? false ? 'readonly' : '' }}>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Nadi (x/menit)</label>
                                <input type="number" class="form-control" name="nadi" placeholder="Nadi"
                                    value="{{ old('nadi', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->nadi : '') }}"
                                    {{ $readonly ?? false ? 'readonly' : '' }}>
                            </div>
                        </div>

                        <!-- 6. Pemeriksaan Fisik -->
                        <div class="section-separator" id="pemeriksaan-fisik">
                            <h5 class="section-title">6. Pemeriksaan Fisik</h5>
                            <div class="" id="pemeriksaan-fisik">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-asesmen">
                                        <tbody>
                                            @php
                                                $pemeriksaanFisik = [
                                                    ['key' => 'kepala', 'label' => 'a. Kepala:'],
                                                    ['key' => 'mata', 'label' => 'b. Mata:'],
                                                    ['key' => 'tht', 'label' => 'c. THT:'],
                                                    ['key' => 'leher', 'label' => 'd. Leher:'],
                                                    ['key' => 'mulut', 'label' => 'e. Mulut:'],
                                                    [
                                                        'key' => 'jantung',
                                                        'label' => 'f. Jantung dan pembuluh darah:',
                                                    ],
                                                    ['key' => 'thorax', 'label' => 'g. Thorax:'],
                                                    ['key' => 'abdomen', 'label' => 'h. Abdomen:'],
                                                    [
                                                        'key' => 'tulang_belakang',
                                                        'label' => 'i. Tulang belakang dan anggota
                                        gerak:',
                                                    ],
                                                    ['key' => 'sistem_syaraf', 'label' => 'j. Sistem Syaraf:'],
                                                    ['key' => 'genetalia', 'label' => 'k. Genetalia:'],
                                                    ['key' => 'status_lokasi', 'label' => 'l. Status Lokasi:'],
                                                ];
                                            @endphp

                                            @foreach ($pemeriksaanFisik as $item)
                                                @php
                                                    $fieldName = 'pengkajian_' . $item['key'];
                                                    $keteranganName = $fieldName . '_keterangan';
                                                    $currentValue = old(
                                                        $fieldName,
                                                        isset($asesmen->asesmenMedisRanapFisik) &&
                                                        $asesmen->asesmenMedisRanapFisik
                                                            ? $asesmen->asesmenMedisRanapFisik->{$fieldName}
                                                            : 1,
                                                    );
                                                    $currentKeterangan = old(
                                                        $keteranganName,
                                                        isset($asesmen->asesmenMedisRanapFisik) &&
                                                        $asesmen->asesmenMedisRanapFisik
                                                            ? $asesmen->asesmenMedisRanapFisik->{$keteranganName}
                                                            : '',
                                                    );
                                                @endphp

                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label class="fw-semibold">{{ $item['label'] }}</label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                @if ($readonly ?? false)
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <span
                                                                            class="badge {{ $currentValue == 1 ? 'bg-success' : 'bg-warning' }}">
                                                                            {{ $currentValue == 1 ? 'Normal' : 'Tidak Normal' }}
                                                                        </span>
                                                                        @if ($currentValue == 0 && $currentKeterangan)
                                                                            <span
                                                                                class="text-muted">{{ $currentKeterangan }}</span>
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="{{ $fieldName }}" value="1"
                                                                                id="{{ $fieldName }}_normal"
                                                                                {{ $currentValue == 1 ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="{{ $fieldName }}_normal">Normal</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="{{ $fieldName }}" value="0"
                                                                                id="{{ $fieldName }}_tidak_normal"
                                                                                {{ $currentValue == 0 ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="{{ $fieldName }}_tidak_normal">Tidak
                                                                                Normal</label>
                                                                        </div>
                                                                        <input type="text" class="form-control"
                                                                            name="{{ $keteranganName }}"
                                                                            id="{{ $keteranganName }}"
                                                                            placeholder="Keterangan jika tidak normal..."
                                                                            value="{{ $currentKeterangan }}"
                                                                            {{ $currentValue == 1 ? 'disabled' : '' }}>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="section-separator">
                            <h5 class="section-title">7. Skala Nyeri</h5>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-4">
                                        <div class="d-flex align-items-center gap-3" style="min-width: 350px;">
                                            @php
                                                $skalaNyeri = old(
                                                    'skala_nyeri',
                                                    isset($asesmen->asesmenMedisRanap)
                                                        ? $asesmen->asesmenMedisRanap->skala_nyeri_nilai
                                                        : 0,
                                                );
                                            @endphp

                                            <!-- Input utama untuk skala nyeri -->
                                            <input type="number"
                                                class="form-control @error('skala_nyeri') is-invalid @enderror"
                                                name="skala_nyeri" style="width: 100px;" value="{{ $skalaNyeri }}"
                                                min="0" max="10" placeholder="0-10"
                                                {{ $readonly ?? false ? 'readonly' : '' }}>

                                            @error('skala_nyeri')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <!-- Button status nyeri -->
                                            <button type="button" class="btn btn-sm btn-success" id="skalaNyeriBtn"
                                                style="min-width: 150px;">
                                                @if (isset($asesmen->asesmenMedisRanap))
                                                    {{ $asesmen->asesmenMedisRanap->skala_nyeri_status }}
                                                @else
                                                    Tidak Nyeri
                                                @endif
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Hidden input untuk nilai skala nyeri (jika diperlukan backend) -->
                                    <input type="hidden" name="skala_nyeri_nilai" value="{{ $skalaNyeri }}">
                                </div>

                                <div class="col-md-6">
                                    <!-- Pain Scale Images - Tampil langsung -->
                                    <div id="wongBakerScale" class="pain-scale-image">
                                        <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                            alt="Wong Baker Pain Scale" class="img-fluid"
                                            style="max-width: auto; height: auto;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 8. Diagnosis -->
                        <div class="section-separator" id="diagnosis">
                            <h5 class="fw-semibold mb-4">8. Diagnosis</h5>

                            <!-- Diagnosis Banding -->
                            <div class="mb-4">
                                <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>

                                @if (!($readonly ?? false))
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        diagnosis banding,
                                        apabila tidak ada, Pilih tanda tambah untuk menambah
                                        keterangan diagnosis banding yang tidak ditemukan.</small>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="diagnosis-banding-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Diagnosis Banding">
                                        <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                @endif

                                <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                    <!-- Diagnosis items will be added here dynamically -->
                                </div>

                                <!-- Hidden input to store JSON data -->
                                <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                    value="{{ old('diagnosis_banding', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->diagnosis_banding : '[]') }}">
                            </div>

                            <!-- Diagnosis Kerja -->
                            <div class="mb-4">
                                <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>

                                @if (!($readonly ?? false))
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                        keterangan diagnosis kerja yang tidak ditemukan.</small>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="diagnosis-kerja-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Diagnosis Kerja">
                                        <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>
                                @endif

                                <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                    <!-- Diagnosis items will be added here dynamically -->
                                </div>

                                <!-- Hidden input to store JSON data -->
                                <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                    value="{{ old('diagnosis_kerja', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->diagnosis_kerja : '[]') }}">
                            </div>


                        </div>

                        <div class="section-separator" id="rencana_pengobatan">
                            <h5 class="fw-semibold mb-4">9. Rencana Penatalaksanaan Dan Pengobatan</h5>
                            <div class="form-group">
                                <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                    placeholder="Rencana Penatalaksanaan Dan Pengobatan" {{ $readonly ?? false ? 'readonly' : '' }}>{{ old('rencana_pengobatan', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->rencana_pengobatan : '') }}</textarea>
                            </div>
                        </div>

                        <div class="section-separator" id="prognosis">
                            <h5 class="fw-semibold mb-4">10. Prognosis</h5>

                            @if ($readonly ?? false)
                                <div class="form-control-plaintext">
                                    @if (isset($asesmen->asesmenMedisRanap) && $asesmen->asesmenMedisRanap->paru_prognosis)
                                        @php
                                            $selectedPrognosis = $satsetPrognosis
                                                ->where('prognosis_id', $asesmen->asesmenMedisRanap->paru_prognosis)
                                                ->first();
                                        @endphp
                                        {{ $selectedPrognosis ? $selectedPrognosis->value : 'Tidak ditemukan' }}
                                    @else
                                        <span class="text-muted">Tidak ada prognosis</span>
                                    @endif
                                </div>
                            @else
                                <select class="form-select" name="paru_prognosis">
                                    <option value="" disabled
                                        {{ !old('paru_prognosis', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->paru_prognosis : '')
                                            ? 'selected'
                                            : '' }}>
                                        --Pilih Prognosis--</option>
                                    @forelse ($satsetPrognosis as $item)
                                        <option value="{{ $item->prognosis_id }}"
                                            {{ old(
                                                'paru_prognosis',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->paru_prognosis : '',
                                            ) == $item->prognosis_id
                                                ? 'selected'
                                                : '' }}>
                                            {{ $item->value ?? 'Field tidak ditemukan' }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Tidak ada data</option>
                                    @endforelse
                                </select>
                            @endif
                        </div>

                        <!-- 9. Perencanaan Pulang Pasien -->
                        <div class="section-separator" id="discharge-planning">
                            <h5 class="section-title">11. Perencanaan Pulang Pasien (Discharge Planning)</h5>

                            {{-- <div class="mb-4">
                            <label class="form-label fw-bold">Diagnosis medis:</label>
                            @if ($readonly ?? false)
                            <div class="form-control-plaintext">
                                {{ isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->diagnosis_medis : 'Tidak ada diagnosis medis' }}
                            </div>
                            @else
                            <input type="text" class="form-control" name="diagnosis_medis" placeholder="Diagnosis"
                                value="{{ old('diagnosis_medis', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->diagnosis_medis : '') }}">
                            @endif
                        </div> --}}

                            <div class="mb-4">
                                <label class="form-label fw-bold">Usia lanjut (>60 th):</label>
                                @if ($readonly ?? false)
                                    <div class="form-control-plaintext">
                                        @if (isset($asesmen->asesmenMedisRanap))
                                            {{ $asesmen->asesmenMedisRanap->usia_lanjut == 0 ? 'Ya' : 'Tidak' }}
                                        @else
                                            <span class="text-muted">Tidak ada data:</span>
                                        @endif
                                    </div>
                                @else
                                    <select class="form-select" name="usia_lanjut">
                                        <option value="" disabled
                                            {{ !old('usia_lanjut', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->usia_lanjut : '') &&
                                            old('usia_lanjut', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->usia_lanjut : '') !== 0
                                                ? 'selected'
                                                : '' }}>
                                            --Pilih--</option>
                                        <option value="0"
                                            {{ old('usia_lanjut', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->usia_lanjut : '') == 0
                                                ? 'selected'
                                                : '' }}>
                                            Ya</option>
                                        <option value="1"
                                            {{ old('usia_lanjut', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->usia_lanjut : '') == 1
                                                ? 'selected'
                                                : '' }}>
                                            Tidak</option>
                                    </select>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Hambatan mobilitas:</label>
                                @if ($readonly ?? false)
                                    <div class="form-control-plaintext">
                                        @if (isset($asesmen->asesmenMedisRanap))
                                            {{ $asesmen->asesmenMedisRanap->hambatan_mobilisasi == 0 ? 'Ya' : 'Tidak' }}
                                        @else
                                            <span class="text-muted">Tidak ada data</span>
                                        @endif
                                    </div>
                                @else
                                    <select class="form-select" name="hambatan_mobilisasi">
                                        <option value="" disabled
                                            {{ !old(
                                                'hambatan_mobilisasi',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->hambatan_mobilisasi : '',
                                            ) &&
                                            old(
                                                'hambatan_mobilisasi',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->hambatan_mobilisasi : '',
                                            ) !== 0
                                                ? 'selected'
                                                : '' }}>
                                            --Pilih--</option>
                                        <option value="0"
                                            {{ old(
                                                'hambatan_mobilisasi',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->hambatan_mobilisasi : '',
                                            ) == 0
                                                ? 'selected'
                                                : '' }}>
                                            Ya</option>
                                        <option value="1"
                                            {{ old(
                                                'hambatan_mobilisasi',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->hambatan_mobilisasi : '',
                                            ) == 1
                                                ? 'selected'
                                                : '' }}>
                                            Tidak</option>
                                    </select>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Membutuhkan pelayanan medis berkelanjutan:</label>
                                @if ($readonly ?? false)
                                    <div class="form-control-plaintext">
                                        @if (isset($asesmen->asesmenMedisRanap))
                                            {{ ucfirst($asesmen->asesmenMedisRanap->penggunaan_media_berkelanjutan ?? 'Tidak ada data') }}
                                        @else
                                            <span class="text-muted">Tidak ada data</span>
                                        @endif
                                    </div>
                                @else
                                    <select class="form-select" name="penggunaan_media_berkelanjutan">
                                        <option value="" disabled
                                            {{ !old(
                                                'penggunaan_media_berkelanjutan',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->penggunaan_media_berkelanjutan : '',
                                            )
                                                ? 'selected'
                                                : '' }}>
                                            --Pilih--
                                        </option>
                                        <option value="ya"
                                            {{ old(
                                                'penggunaan_media_berkelanjutan',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->penggunaan_media_berkelanjutan : '',
                                            ) == 'ya'
                                                ? 'selected'
                                                : '' }}>
                                            Ya
                                        </option>
                                        <option value="tidak"
                                            {{ old(
                                                'penggunaan_media_berkelanjutan',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->penggunaan_media_berkelanjutan : '',
                                            ) == 'tidak'
                                                ? 'selected'
                                                : '' }}>
                                            Tidak</option>
                                    </select>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Keteraturan dalam mengonsumsi obat dalam aktivitas
                                    harian:</label>
                                @if ($readonly ?? false)
                                    <div class="form-control-plaintext">
                                        @if (isset($asesmen->asesmenMedisRanap))
                                            {{ ucfirst($asesmen->asesmenMedisRanap->ketergantungan_aktivitas ?? 'Tidak ada data') }}
                                        @else
                                            <span class="text-muted">Tidak ada data</span>
                                        @endif
                                    </div>
                                @else
                                    <select class="form-select" name="ketergantungan_aktivitas">
                                        <option value="" disabled
                                            {{ !old(
                                                'ketergantungan_aktivitas',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->ketergantungan_aktivitas : '',
                                            )
                                                ? 'selected'
                                                : '' }}>
                                            --Pilih--</option>
                                        <option value="ya"
                                            {{ old(
                                                'ketergantungan_aktivitas',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->ketergantungan_aktivitas : '',
                                            ) == 'ya'
                                                ? 'selected'
                                                : '' }}>
                                            Ya</option>
                                        <option value="tidak"
                                            {{ old(
                                                'ketergantungan_aktivitas',
                                                isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->ketergantungan_aktivitas : '',
                                            ) == 'tidak'
                                                ? 'selected'
                                                : '' }}>
                                            Tidak
                                        </option>
                                    </select>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Rencana Pulang Khusus:</label>
                                @if ($readonly ?? false)
                                    <div class="form-control-plaintext">
                                        {{ isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->rencana_pulang_khusus : 'Tidak ada rencana khusus' }}
                                    </div>
                                @else
                                    <input type="text" class="form-control" name="rencana_pulang_khusus"
                                        placeholder="Rencana Pulang Khusus"
                                        value="{{ old('rencana_pulang_khusus', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->rencana_pulang_khusus : '') }}">
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Rencana Lama Perawatan:</label>
                                @if ($readonly ?? false)
                                    <div class="form-control-plaintext">
                                        {{ isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->rencana_lama_perawatan : 'Tidak ada rencana' }}
                                    </div>
                                @else
                                    <input type="text" class="form-control" name="rencana_lama_perawatan"
                                        placeholder="Rencana Lama Perawatan"
                                        value="{{ old('rencana_lama_perawatan', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->rencana_lama_perawatan : '') }}">
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Rencana Tanggal Pulang:</label>
                                @if ($readonly ?? false)
                                    <div class="form-control-plaintext">
                                        @if (isset($asesmen->asesmenMedisRanap) && $asesmen->asesmenMedisRanap->rencana_tgl_pulang)
                                            {{ \Carbon\Carbon::parse($asesmen->asesmenMedisRanap->rencana_tgl_pulang)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">Tidak ada tanggal pulang</span>
                                        @endif
                                    </div>
                                @else
                                    <input type="date" class="form-control" name="rencana_tgl_pulang"
                                        value="{{ $asesmen->asesmenMedisRanap->rencana_tgl_pulang ? date('Y-m-d', strtotime($asesmen->asesmenMedisRanap->rencana_tgl_pulang)) : date('Y-m-d') }}">
                                @endif
                            </div>

                            <div class="mt-4">
                                <label class="form-label fw-bold">KESIMPULAN</label>
                                @if ($readonly ?? false)
                                    <div class="form-control-plaintext">
                                        @if (isset($asesmen->asesmenMedisRanap) && $asesmen->asesmenMedisRanap->kesimpulan_planing)
                                            <div class="alert alert-info">
                                                {{ $asesmen->asesmenMedisRanap->kesimpulan_planing }}
                                            </div>
                                        @else
                                            <div class="alert alert-secondary">
                                                Tidak ada kesimpulan
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="d-flex flex-column gap-2">
                                        <div class="alert alert-info d-none">
                                            <!-- Alasan akan ditampilkan di sini -->
                                        </div>
                                        <div class="alert alert-warning d-none">
                                            Membutuhkan rencana pulang khusus
                                        </div>
                                        <div class="alert alert-success">
                                            Tidak membutuhkan rencana pulang khusus
                                        </div>
                                    </div>
                                    <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                        value="{{ old('kesimpulan_planing', isset($asesmen->asesmenMedisRanap) ? $asesmen->asesmenMedisRanap->kesimpulan_planing : 'Tidak membutuhkan rencana pulang khusus') }}">
                                @endif
                            </div>

                            @if (!($readonly ?? false))
                                <!-- Tombol Reset (Opsional) -->
                                <div class="mt-3">
                                    <button type="button" class="btn btn-secondary" onclick="resetDischargePlanning()">
                                        Reset Discharge Planning
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    @if (!($readonly ?? false))
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-2"></i>{{ isset($asesmen) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    @endif
                </form>
        </div>
        </x-content-card>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Load existing data saat pertama kali
            loadExistingObatData();
            loadExistingAlergiData();
            loadExistingDiagnosisData();
            initSkalaNyeri();
        });

        // Function untuk load data obat existing
        function loadExistingObatData() {
            const riwayatObatData = document.getElementById('riwayatObatData');
            const obatTable = document.querySelector('#createRiwayatObatTable tbody');
            const isReadonly = {{ $readonly ?? false ? 'true' : 'false' }};

            if (riwayatObatData && riwayatObatData.value && riwayatObatData.value !== '[]') {
                try {
                    const obatData = JSON.parse(riwayatObatData.value);
                    if (Array.isArray(obatData) && obatData.length > 0) {
                        const colSpan = isReadonly ? '3' : '4';
                        obatTable.innerHTML = obatData.map(obat => `
                    <tr>
                        <td><strong>${obat.namaObat}</strong></td>
                        <td>${obat.dosis} ${obat.satuan}</td>
                        <td>
                            <span class="badge bg-primary">${obat.frekuensi}</span>
                            <br><small class="text-muted">${obat.keterangan}</small>
                        </td>
                        ${!isReadonly ? `
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeObat(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                        ` : ''}
                    </tr>
                `).join('');
                    }
                } catch (e) {
                    console.error('Error parsing riwayat obat data:', e);
                }
            }
        }

        // Function untuk load data alergi existing
        function loadExistingAlergiData() {
            const alergisInput = document.getElementById('alergisInput');
            const alergiTable = document.querySelector('#createAlergiTable tbody');
            const isReadonly = {{ $readonly ?? false ? 'true' : 'false' }};

            console.log('Loading alergi data...', alergisInput?.value);

            if (alergisInput && alergisInput.value && alergisInput.value !== '[]') {
                try {
                    const alergiData = JSON.parse(alergisInput.value);
                    console.log('Parsed alergi data:', alergiData);

                    if (Array.isArray(alergiData) && alergiData.length > 0) {
                        // Remove "no data" row first
                        const noDataRow = document.getElementById('no-alergi-row');
                        if (noDataRow) {
                            noDataRow.remove();
                        }

                        // Build table content
                        const tableContent = alergiData.map((alergi, index) => {
                            // Handle different possible field names
                            const jenisAlergi = alergi.jenis_alergi || alergi.jenisAlergi || 'Tidak diketahui';
                            const namaAlergi = alergi.nama_alergi || alergi.alergen || alergi.namaAlergi ||
                                'Tidak diketahui';
                            const reaksi = alergi.reaksi || 'Tidak diketahui';
                            const tingkatKeparahan = alergi.tingkat_keparahan || alergi.tingkatKeparahan ||
                                'Tidak diketahui';

                            return `
                        <tr>
                            <td>${jenisAlergi}</td>
                            <td>${namaAlergi}</td>
                            <td>${reaksi}</td>
                            <td>
                                <span class="badge ${getBadgeClass(tingkatKeparahan)}">
                                    ${tingkatKeparahan}
                                </span>
                            </td>
                            ${!isReadonly ? `
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeAlergi(this, ${index})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                            ` : ''}
                        </tr>
                    `;
                        }).join('');

                        alergiTable.innerHTML = tableContent;
                        console.log('Alergi table updated successfully');
                    } else {
                        console.log('No alergi data found or empty array');
                    }
                } catch (e) {
                    console.error('Error parsing alergi data:', e);
                    console.error('Raw data:', alergisInput.value);
                }
            } else {
                console.log('No alergi input found or empty value');
            }
        }

        // Function untuk load diagnosis existing
        function loadExistingDiagnosisData() {
            loadDiagnosisList('diagnosis_banding', 'diagnosis-banding-list');
            loadDiagnosisList('diagnosis_kerja', 'diagnosis-kerja-list');
        }

        function loadDiagnosisList(inputId, listId) {
            const input = document.getElementById(inputId);
            const list = document.getElementById(listId);
            const isReadonly = {{ $readonly ?? false ? 'true' : 'false' }};

            if (input && input.value && input.value !== '[]') {
                try {
                    const diagnosisData = JSON.parse(input.value);
                    if (Array.isArray(diagnosisData) && diagnosisData.length > 0) {
                        list.innerHTML = diagnosisData.map(diagnosis => `
                    <div class="diagnosis-item mb-2 p-2 border rounded">
                        <span class="fw-medium">${diagnosis}</span>
                        ${!isReadonly ? `
                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="removeDiagnosis(this, '${inputId}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        ` : ''}
                    </div>
                `).join('');
                    }
                } catch (e) {
                    console.error('Error parsing diagnosis data:', e);
                }
            }
        }

        // Helper functions
        function getBadgeClass(tingkat) {
            switch (tingkat?.toLowerCase()) {
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

        function removeObat(button) {
            if (confirm('Hapus obat ini?')) {
                button.closest('tr').remove();
                updateObatData();
            }
        }

        function removeAlergi(button) {
            if (confirm('Hapus alergi ini?')) {
                button.closest('tr').remove();
                updateAlergiData();
            }
        }

        function removeDiagnosis(button, inputId) {
            if (confirm('Hapus diagnosis ini?')) {
                button.closest('.diagnosis-item').remove();
                updateDiagnosisData(inputId);
            }
        }

        function updateObatData() {
            // Update logic for obat data
        }

        function updateAlergiData() {
            // Update logic for alergi data
        }

        function updateDiagnosisData(inputId) {
            // Update logic for diagnosis data
        }

        // Skala Nyeri - JavaScript yang disederhanakan
        function initSkalaNyeri() {
            const input = $('input[name="skala_nyeri"]');
            const hiddenInput = $('input[name="skala_nyeri_nilai"]');
            const button = $('#skalaNyeriBtn');

            // Trigger saat pertama kali load
            const initialValue = parseInt(input.val()) || 0;
            updateButton(initialValue);

            // Sinkronkan hidden input dengan input utama
            hiddenInput.val(initialValue);

            // Event handler untuk input utama
            input.on('input change', function() {
                let nilai = parseInt($(this).val()) || 0;

                nilai = Math.min(Math.max(nilai, 0), 10);
                $(this).val(nilai);

                hiddenInput.val(nilai);

                updateButton(nilai);
            });

            // Event handler untuk hidden input (jika diubah manual)
            hiddenInput.on('input change', function() {
                let nilai = parseInt($(this).val()) || 0;

                nilai = Math.min(Math.max(nilai, 0), 10);
                $(this).val(nilai);

                input.val(nilai);

                updateButton(nilai);
            });

            // Fungsi untuk update button
            function updateButton(nilai) {
                let buttonClass, textNyeri;

                if (nilai === 0) {
                    buttonClass = 'btn-success';
                    textNyeri = 'Tidak Nyeri';
                } else if (nilai >= 1 && nilai <= 3) {
                    buttonClass = 'btn-success';
                    textNyeri = 'Nyeri Ringan';
                } else if (nilai >= 4 && nilai <= 5) {
                    buttonClass = 'btn-warning';
                    textNyeri = 'Nyeri Sedang';
                } else if (nilai >= 6 && nilai <= 7) {
                    buttonClass = 'btn-warning';
                    textNyeri = 'Nyeri Berat';
                } else if (nilai >= 8 && nilai <= 9) {
                    buttonClass = 'btn-danger';
                    textNyeri = 'Nyeri Sangat Berat';
                } else if (nilai >= 10) {
                    buttonClass = 'btn-danger';
                    textNyeri = 'Nyeri Tak Tertahankan';
                }

                button
                    .removeClass('btn-success btn-warning btn-danger')
                    .addClass(buttonClass)
                    .text(textNyeri);
            }
        }

        // Pemeriksaan Fisik - JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Function to toggle keterangan input based on radio selection
            function toggleKeteranganInput(radioName, keteranganId) {
                const radios = document.getElementsByName(radioName);
                const keteranganInput = document.getElementById(keteranganId);

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        if (this.value === '0') { // Tidak Normal
                            keteranganInput.disabled = false;
                            keteranganInput.focus();
                        } else { // Normal
                            keteranganInput.disabled = true;
                            keteranganInput.value = null;
                        }
                    });
                });

                // Initialize state saat pertama kali load
                const selectedRadio = Array.from(radios).find(radio => radio.checked);
                if (selectedRadio) {
                    if (selectedRadio.value === '0') {
                        keteranganInput.disabled = false;
                    } else {
                        keteranganInput.disabled = true;
                        keteranganInput.value = null;
                    }
                }
            }

            // Apply toggle functionality ke semua item pemeriksaan fisik
            // Sesuaikan dengan name yang ada di HTML
            toggleKeteranganInput('pengkajian_kepala', 'pengkajian_kepala_keterangan');
            toggleKeteranganInput('pengkajian_mata', 'pengkajian_mata_keterangan');
            toggleKeteranganInput('pengkajian_tht', 'pengkajian_tht_keterangan');
            toggleKeteranganInput('pengkajian_leher', 'pengkajian_leher_keterangan');
            toggleKeteranganInput('pengkajian_mulut', 'pengkajian_mulut_keterangan');
            toggleKeteranganInput('pengkajian_jantung', 'pengkajian_jantung_keterangan');
            toggleKeteranganInput('pengkajian_thorax', 'pengkajian_thorax_keterangan');
            toggleKeteranganInput('pengkajian_abdomen', 'pengkajian_abdomen_keterangan');
            toggleKeteranganInput('pengkajian_tulang_belakang', 'pengkajian_tulang_belakang_keterangan');
            toggleKeteranganInput('pengkajian_sistem_syaraf', 'pengkajian_sistem_syaraf_keterangan');
            toggleKeteranganInput('pengkajian_genetalia', 'pengkajian_genetalia_keterangan');
            toggleKeteranganInput('pengkajian_status_lokasi', 'pengkajian_status_lokasi_keterangan');

            // Function untuk update JSON hidden input based on checkbox selections (jika ada)
            function updateCheckboxJSON(checkboxClass, hiddenInputId) {
                const checkboxes = document.querySelectorAll('.' + checkboxClass);
                const hiddenInput = document.getElementById(hiddenInputId);

                // Cek apakah element ada sebelum diproses
                if (!hiddenInput || checkboxes.length === 0) return;

                function updateJSON() {
                    const selectedValues = [];
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            selectedValues.push(checkbox.value);
                        }
                    });

                    hiddenInput.value = selectedValues.length > 0 ? JSON.stringify(selectedValues) : '';
                    console.log(`${hiddenInputId}:`, hiddenInput.value);
                }

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateJSON);
                });

                updateJSON();
            }

            // Apply checkbox JSON functionality (jika diperlukan)
            updateCheckboxJSON('paru-suara-pernafasan', 'paru_suara_pernafasan_json');
            updateCheckboxJSON('paru-suara-tambahan', 'paru_suara_tambahan_json');

            // Form validation sebelum submit
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Validasi tambahan jika diperlukan
                    console.log('Form submitted with pemeriksaan fisik data');
                });
            }
        });
    </script>
@endpush
