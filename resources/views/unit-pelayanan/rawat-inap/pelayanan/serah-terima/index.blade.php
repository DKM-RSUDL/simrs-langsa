@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .header-background {
            height: 100%;
            background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
        }
    </style>
@endpush

@section('content')
    @php
        $transferFormReady =
            !empty($serahTerima->kd_spesial) &&
            !empty($serahTerima->kd_dokter) &&
            !empty($serahTerima->kd_kelas) &&
            !empty($serahTerima->no_kamar);
    @endphp

    <div class="row">
        <div class="col-md-3">

            <div class="card h-auto sticky-top" style="top:1rem; z-index: 0;">
                <div class="card-body">
                    <div class="position-absolute top-0 end-0 p-3 d-flex flex-column align-items-center gap-1">
                        <span class="d-block rounded-circle bg-danger" style="width:8px;height:8px;"></span>
                        <span class="d-block rounded-circle bg-warning" style="width:8px;height:8px;"></span>
                        <span class="d-block rounded-circle bg-success" style="width:8px;height:8px;"></span>
                    </div>

                    <div class="row g-3">
                        {{-- Foto pasien --}}
                        <div class="col-5">
                            <img src="{{ asset('assets/img/profile.jpg') }}" alt="Patient Photo"
                                class="object-fit-cover rounded w-100 h-100">
                        </div>

                        {{-- Info pasien --}}
                        <div class="col-7 col-md-12 d-flex flex-column justify-content-center">
                            <h6 class="h6 mb-1 fw-semibold">
                                {{ $serahTerima->pasien->nama ?? 'Tidak Diketahui' }}
                            </h6>

                            <p class="mb-1">
                                @if (($serahTerima->pasien->jenis_kelamin ?? '') == 1)
                                    Laki-laki
                                @elseif (($serahTerima->pasien->jenis_kelamin ?? '') == 0)
                                    Perempuan
                                @else
                                    Tidak Diketahui
                                @endif
                            </p>

                            <div class="small text-body-secondary mb-2">
                                {{ !empty($serahTerima->pasien->tgl_lahir) ? hitungUmur($serahTerima->pasien->tgl_lahir) : 'Tidak Diketahui' }}
                                Thn
                                (
                                {{ $serahTerima->pasien->tgl_lahir
                                    ? \Carbon\Carbon::parse($serahTerima->pasien->tgl_lahir)->format('d/m/Y')
                                    : 'Tidak Diketahui' }}
                                )
                            </div>

                            <div class="d-flex flex-column gap-1">
                                <div class="fw-semibold">
                                    RM: {{ $serahTerima->pasien->kd_pasien ?? '-' }}
                                </div>

                                <div class="d-inline-flex align-items-start gap-2">
                                    <i class="bi bi-hospital"></i>
                                    <span>
                                        {{ $serahTerima->unitTujuan->bagian->bagian ?? '-' }}
                                        ({{ $serahTerima->unitTujuan->nama_unit ?? '-' }})
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-9">

            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Serah Terima Pasien Antar Ruang',
                    'description' => 'Lengkapi form serah terima pasien antar ruang berikut ini',
                ])

                <form
                    action="{{ route('rawat-inap.unit.serah-terima.store', [$serahTerima->kd_unit_tujuan, encrypt($serahTerima->id)]) }}"
                    method="post">
                    @csrf
                    @method('put')

                    <div class="row">
                        @if ($transferFormReady)
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <h5 class="fw-bold">SBAR</h5>
                                    <div class="row g-3">
                                        <div class="col-12 mb-3">
                                            <label>Subjective</label>
                                            <textarea name="subjective" placeholder="Data subjektif" class="form-control" rows="5" disabled>{{ old('subjective', $serahTerima->subjective ?? '') }}</textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Background</label>
                                            <textarea name="background" placeholder="Background" class="form-control" rows="5" disabled>{{ old('background', $serahTerima->background ?? '') }}</textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Assessment</label>
                                            <textarea name="assessment" placeholder="Assessment" class="form-control" rows="5" disabled>{{ old('assessment', $serahTerima->assessment ?? '') }}</textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Recommendation</label>
                                            <textarea name="recomendation" placeholder="Recommendation" class="form-control" rows="5" disabled>{{ old('recomendation', $serahTerima->recomendation ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="{{ $transferFormReady ? 'col-md-6' : 'col-12' }}">
                            <div class="row">
                                <div class="{{ $transferFormReady ? 'mb-4' : 'col-md-6' }}">
                                    <h5 class="fw-bold">Yang Menyerahkan:</h5>
                                    <div class="mb-3">
                                        <label for="kd_unit_asal">Dari Unit/ Ruang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $serahTerima->unitAsal->nama_unit ?? '' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kd_unit_tujuan">Tujuan ke Unit/ Ruang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $serahTerima->unitTujuan->nama_unit ?? '' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="petugas_menyerahkan">Petugas yang Menyerahkan</label>
                                        <input type="text" class="form-control"
                                            value="{{ ($serahTerima->petugasAsal->gelar_depan ?? '') . ' ' . str()->title($serahTerima->petugasAsal->nama ?? '') . ' ' . ($serahTerima->petugasAsal->gelar_belakang ?? '') }}"
                                            disabled>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label>Tanggal</label>
                                            <input type="date" name="tanggal_menyerahkan"
                                                value="{{ !empty($serahTerima->tanggal_menyerahkan) ? date('Y-m-d', strtotime($serahTerima->tanggal_menyerahkan)) : '' }}"
                                                class="form-control" disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Jam</label>
                                            <input type="time" name="jam_menyerahkan"
                                                value="{{ !empty($serahTerima->jam_menyerahkan) ? date('H:i', strtotime($serahTerima->jam_menyerahkan)) : date('H:i') }}"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    {{-- <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button> --}}
                                </div>

                                <div class="{{ $transferFormReady ? 'mb-4' : 'col-md-6' }}">
                                    <h5 class="fw-bold">Yang Menerima:</h5>
                                    <div class="mb-3">
                                        <label>Diterima di Ruang/ Unit Pelayanan</label>
                                        <input type="text" class="form-control"
                                            value="{{ $serahTerima->unitTujuan->nama_unit ?? '' }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label>Petugas yang Menerima</label>
                                        <select name="petugas_terima" id="petugas_terima" class="form-select select2">
                                            <option value="">--Pilih--</option>
                                            <option
                                                value="{{ $serahTerima->petugas_terima ?? auth()->user()->kd_karyawan }}"
                                                selected>
                                                {{ $serahTerima->petugasTerima->name ?? auth()->user()->name }}
                                            </option>

                                            @foreach ($petugas as $item)
                                                @if ($item->kd_karyawan != auth()->user()->kd_karyawan && $item->kd_karyawan != $serahTerima->petugas_terima)
                                                    <option value="{{ $item->kd_karyawan }}">
                                                        {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' . $item->gelar_belakang }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label>Tanggal</label>
                                            <input type="date" name="tanggal_terima"
                                                value="{{ !empty($serahTerima->tanggal_terima) ? date('Y-m-d', strtotime($serahTerima->tanggal_terima)) : date('Y-m-d') }}"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Jam</label>
                                            <input type="time" name="jam_terima"
                                                value="{{ !empty($serahTerima->jam_terima) ? date('H:i', strtotime($serahTerima->jam_terima)) : date('H:i') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    {{-- <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($serahTerima->status == 1)
                        <div class="d-flex justify-content-end gap-2">
                            <x-button-submit>Terima Order</x-button-submit>
                        </div>
                    @endif
                </form>
            </x-content-card>

            @if (!empty($serahTerima->transfer))
                <x-content-card>

                    <!-- Informasi Medis -->
                    <div class="form-section">
                        <div class="section-header">Informasi Medis</div>
                        <div class="section-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Dokter yang Merawat</label>
                                        <select name="dokter_merawat" class="form-select select2" disabled>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $item)
                                                <option value="{{ $item->kd_dokter }}" @selected(old('dokter_merawat', $transfer->dokter_merawat) == $item->kd_dokter)>
                                                    {{ $item->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dokter_merawat')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Diagnosis Utama</label>
                                        <textarea name="diagnosis_utama" class="form-control" rows="3" disabled>{{ old('diagnosis_utama', $transfer->diagnosis_utama) }}</textarea>
                                        @error('diagnosis_utama')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Diagnosis Sekunder</label>
                                        <textarea name="diagnosis_sekunder" class="form-control" rows="3" disabled>{{ old('diagnosis_sekunder', $transfer->diagnosis_sekunder) }}</textarea>
                                        @error('diagnosis_sekunder')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">DPJP (Dokter Penanggung Jawab Pelayanan)</label>
                                        <select name="dpjp" class="form-select select2" disabled>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $item)
                                                <option value="{{ $item->kd_dokter }}" @selected(old('dpjp', $transfer->dpjp) == $item->kd_dokter)>
                                                    {{ $item->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dpjp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="form-label fw-bold">Perlu Menjadi Perhatian:</label>
                                        <div class="mb-3">
                                            <label for="mrsa" class="form-label">MRSA:</label>
                                            <input type="text" name="mrsa" class="form-control"
                                                value="{{ old('mrsa', $transfer->mrsa) }}" disabled>
                                            @error('mrsa')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="lainnya_perhatian" class="form-label">Lainnya:</label>
                                            <input type="text" name="lainnya_perhatian" class="form-control"
                                                value="{{ old('lainnya_perhatian', $transfer->lainnya_perhatian) }}"
                                                disabled>
                                            @error('lainnya_perhatian')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator" id="alergi">
                                    <p class="fw-bold">Alergi</p>
                                    <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="createAlergiTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="20%">Jenis Alergi</th>
                                                    <th width="25%">Alergen</th>
                                                    <th width="25%">Reaksi</th>
                                                    <th width="20%">Tingkat Keparahan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="no-alergi-row">
                                                    <td colspan="5" class="text-center text-muted">Tidak ada data
                                                        alergi</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Persetujuan Pasien/Keluarga -->
                    <div class="form-section">
                        <div class="section-header">Persetujuan dan Alasan Pemindahan</div>
                        <div class="section-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pasien/keluarga mengetahui dan menyetujui
                                            pemindahan:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="persetujuan"
                                                value="ya" id="setuju_ya" @checked(old('persetujuan', $transfer->persetujuan) == 'ya') required
                                                disabled>
                                            <label class="form-check-label" for="setuju_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="persetujuan"
                                                value="tidak" id="setuju_tidak" @checked(old('persetujuan', $transfer->persetujuan) == 'tidak') required
                                                disabled>
                                            <label class="form-check-label" for="setuju_tidak">Tidak</label>
                                        </div>
                                        @error('persetujuan')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3" id="keluarga-section" style="display: none;">
                                        <label class="form-label">Bila pemberi persetujuan adalah keluarga:</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="nama_keluarga" class="form-control"
                                                    value="{{ old('nama_keluarga', $transfer->nama_keluarga) }}" disabled>
                                                @error('nama_keluarga')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Hubungan</label>
                                                <input type="text" name="hubungan_keluarga" class="form-control"
                                                    value="{{ old('hubungan_keluarga', $transfer->hubungan_keluarga) }}"
                                                    disabled>
                                                @error('hubungan_keluarga')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $alasan = is_string($transfer->alasan)
                                        ? json_decode($transfer->alasan, true)
                                        : $transfer->alasan ?? [];
                                @endphp

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Alasan Pemindahan:</label>
                                    <div class="checkbox-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan[]"
                                                value="kondisi_pasien" id="kondisi" @checked(is_array(old('alasan', $alasan)) && in_array('kondisi_pasien', old('alasan', $alasan)))
                                                disabled>
                                            <label class="form-check-label" for="kondisi">
                                                Kondisi pasien: memburuk/stabil/tidak ada perubahan
                                            </label>
                                        </div>
                                    </div>
                                    <div class="checkbox-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan[]"
                                                value="fasilitas" id="fasilitas" @checked(is_array(old('alasan', $alasan)) && in_array('fasilitas', old('alasan', $alasan))) disabled>
                                            <label class="form-check-label" for="fasilitas">
                                                Fasilitas: kurang memadai/butuh peralatan yang lebih baik
                                            </label>
                                        </div>
                                    </div>
                                    <div class="checkbox-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan[]"
                                                value="tenaga" id="tenaga" @checked(is_array(old('alasan', $alasan)) && in_array('tenaga', old('alasan', $alasan))) disabled>
                                            <label class="form-check-label" for="tenaga">
                                                Tenaga: membutuhkan tenaga yang lebih ahli/tenaga kurang
                                            </label>
                                        </div>
                                    </div>
                                    <div class="checkbox-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan[]"
                                                value="lainnya_alasan" id="lainnya_alasan" @checked(is_array(old('alasan', $alasan)) && in_array('lainnya_alasan', old('alasan', $alasan)))
                                                onchange="toggleOtherInput('lainnya_alasan', 'lainnya_alasan_detail_input')"
                                                disabled>
                                            <label class="form-check-label" for="lainnya_alasan">Lainnya:</label>
                                            <input type="text" name="lainnya_alasan_detail"
                                                id="lainnya_alasan_detail_input" class="form-control form-control-sm mt-1"
                                                placeholder="Sebutkan alasan lainnya"
                                                value="{{ old('lainnya_alasan_detail', $transfer->lainnya_alasan_detail) }}"
                                                style="{{ is_array(old('alasan', $alasan)) && in_array('lainnya_alasan', old('alasan', $alasan)) ? 'display: block;' : 'display: none;' }}"
                                                disabled>
                                            @error('lainnya_alasan_detail')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $metode = is_string($transfer->metode)
                                    ? json_decode($transfer->metode, true)
                                    : $transfer->metode ?? [];
                            @endphp

                            <div class="mb-3">
                                <label class="form-label fw-bold">Metode Pemindahan:</label>
                                <div class="checkbox-group d-flex gap-3 flex-wrap">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="metode[]"
                                            value="kursi_roda" id="kursi_roda" @checked(is_array(old('metode', $metode)) && in_array('kursi_roda', old('metode', $metode))) disabled>
                                        <label class="form-check-label" for="kursi_roda">Kursi Roda</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="metode[]" value="brankar"
                                            id="brankar" @checked(is_array(old('metode', $metode)) && in_array('brankar', old('metode', $metode))) disabled>
                                        <label class="form-check-label" for="brankar">Brankar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="metode[]"
                                            value="tempat_tidur" id="tempat_tidur" @checked(is_array(old('metode', $metode)) && in_array('tempat_tidur', old('metode', $metode))) disabled>
                                        <label class="form-check-label" for="tempat_tidur">Tempat Tidur</label>
                                    </div>
                                </div>
                                @error('metode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Keadaan Pasien Saat Pindah -->
                    <div class="form-section">
                        <div class="section-header">Keadaan Pasien Saat Pindah</div>
                        <div class="section-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Keadaan Umum</label>
                                        <input type="text" name="keadaan_umum" class="form-control"
                                            value="{{ old('keadaan_umum', $transfer->keadaan_umum) }}" disabled>
                                        @error('keadaan_umum')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="kesadaran" class="form-label">Kesadaran</label>
                                        <select name="kesadaran" id="kesadaran" class="form-select select2" disabled>
                                            <option value="">--Pilih--</option>
                                            <option value="Compos Mentis" @selected(old('kesadaran', $transfer->kesadaran) == 'Compos Mentis')>Compos Mentis
                                            </option>
                                            <option value="Apatis" @selected(old('kesadaran', $transfer->kesadaran) == 'Apatis')>Apatis</option>
                                            <option value="Sopor" @selected(old('kesadaran', $transfer->kesadaran) == 'Sopor')>Sopor</option>
                                            <option value="Coma" @selected(old('kesadaran', $transfer->kesadaran) == 'Coma')>Coma</option>
                                            <option value="Somnolen" @selected(old('kesadaran', $transfer->kesadaran) == 'Somnolen')>Somnolen</option>
                                        </select>
                                        @error('kesadaran')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tekanan Darah</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="tekanan_darah_sistole" class="form-label">Sistole</label>
                                                <input type="number" class="form-control" name="tekanan_darah_sistole"
                                                    id="tekanan_darah_sistole"
                                                    value="{{ old('tekanan_darah_sistole', $transfer->tekanan_darah_sistole) }}"
                                                    disabled>
                                                @error('tekanan_darah_sistole')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tekanan_darah_diastole" class="form-label">Diastole</label>
                                                <input type="number" class="form-control" name="tekanan_darah_diastole"
                                                    id="tekanan_darah_diastole" placeholder="Diastole (mmHg)"
                                                    value="{{ old('tekanan_darah_diastole', $transfer->tekanan_darah_diastole) }}"
                                                    disabled>
                                                @error('tekanan_darah_diastole')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="nadi" class="form-label">Nadi</label>
                                                <input type="number" class="form-control" name="nadi" id="nadi"
                                                    value="{{ old('nadi', $transfer->nadi) }}" disabled>
                                                @error('nadi')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="suhu" class="form-label">Suhu</label>
                                                <input type="number" step="0.1" class="form-control" name="suhu"
                                                    id="suhu" value="{{ old('suhu', $transfer->suhu) }}" disabled>
                                                @error('suhu')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="resp" class="form-label">Respirasi</label>
                                                <input type="number" class="form-control" name="resp" id="resp"
                                                    value="{{ old('resp', $transfer->resp) }}" disabled>
                                                @error('resp')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="status_nyeri" class="form-label">Status Nyeri</label>
                                                <select name="status_nyeri" id="status_nyeri" class="form-select select2"
                                                    disabled>
                                                    <option value="">--Pilih--</option>
                                                    <option value="tidak_ada" @selected(old('status_nyeri', $transfer->status_nyeri) == 'tidak_ada')>Tidak Ada
                                                    </option>
                                                    <option value="ringan" @selected(old('status_nyeri', $transfer->status_nyeri) == 'ringan')>Ringan</option>
                                                    <option value="sedang" @selected(old('status_nyeri', $transfer->status_nyeri) == 'sedang')>Sedang</option>
                                                    <option value="berat" @selected(old('status_nyeri', $transfer->status_nyeri) == 'berat')>Berat</option>
                                                </select>
                                                @error('status_nyeri')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Medis dan Peralatan yang menyertai saat pindah -->
                    @php
                        $info_medis = is_string($transfer->info_medis)
                            ? json_decode($transfer->info_medis, true)
                            : $transfer->info_medis ?? [];
                        $peralatan = is_string($transfer->peralatan)
                            ? json_decode($transfer->peralatan, true)
                            : $transfer->peralatan ?? [];
                    @endphp

                    <!-- Informasi Medis dan Peralatan yang Menyertai Saat Pindah -->
                    <div class="form-section">
                        <div class="section-header">Informasi Medis dan Peralatan yang Menyertai Saat Pindah</div>
                        <div class="section-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Informasi Medis:</label>
                                    <div class="checkbox-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="info_medis[]"
                                                value="disabilitas" id="disabilitas" @checked(is_array(old('info_medis', $info_medis)) && in_array('disabilitas', old('info_medis', $info_medis)))
                                                disabled>
                                            <label class="form-check-label" for="disabilitas">Disabilitas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="info_medis[]"
                                                value="amputasi" id="amputasi" @checked(is_array(old('info_medis', $info_medis)) && in_array('amputasi', old('info_medis', $info_medis))) disabled>
                                            <label class="form-check-label" for="amputasi">Amputasi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="info_medis[]"
                                                value="paralisis" id="paralisis" @checked(is_array(old('info_medis', $info_medis)) && in_array('paralisis', old('info_medis', $info_medis))) disabled>
                                            <label class="form-check-label" for="paralisis">Paralisis</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="info_medis[]"
                                                value="kontraktur" id="kontraktur" @checked(is_array(old('info_medis', $info_medis)) && in_array('kontraktur', old('info_medis', $info_medis))) disabled>
                                            <label class="form-check-label" for="kontraktur">Kontraktur</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="info_medis[]"
                                                value="ulkus_dekubitus" id="ulkus_dekubitus" @checked(is_array(old('info_medis', $info_medis)) && in_array('ulkus_dekubitus', old('info_medis', $info_medis)))
                                                disabled>
                                            <label class="form-check-label" for="ulkus_dekubitus">Ulkus Dekubitus</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="info_medis[]"
                                                value="lainnya" id="lainnya_info_medis" @checked(is_array(old('info_medis', $info_medis)) && in_array('lainnya', old('info_medis', $info_medis)))
                                                onchange="toggleOtherInput('lainnya_info_medis', 'info_medis_lainnya_input')"
                                                disabled>
                                            <label class="form-check-label" for="lainnya_info_medis">Lainnya:</label>
                                            <input type="text" name="info_medis_lainnya" id="info_medis_lainnya_input"
                                                class="form-control form-control-sm mt-1"
                                                placeholder="Spesifikasi lainnya"
                                                value="{{ old('info_medis_lainnya', $transfer->info_medis_lainnya) }}"
                                                style="{{ is_array(old('info_medis', $info_medis)) && in_array('lainnya', old('info_medis', $info_medis)) ? 'display: block;' : 'display: none;' }}"
                                                disabled>
                                            @error('info_medis_lainnya')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    @error('info_medis')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Peralatan yang Menyertai Saat Pindah:</label>
                                    <div class="checkbox-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="peralatan[]"
                                                value="portable_o2" id="portable_o2" @checked(is_array(old('peralatan', $peralatan)) && in_array('portable_o2', old('peralatan', $peralatan)))
                                                onchange="toggleOtherInput('portable_o2', 'o2_kebutuhan_input')" disabled>
                                            <label class="form-check-label" for="portable_o2">Portable O2</label>
                                            <input type="text" name="o2_kebutuhan" id="o2_kebutuhan_input"
                                                class="form-control form-control-sm mt-1"
                                                placeholder="Kebutuhan (l/menit)"
                                                value="{{ old('o2_kebutuhan', $transfer->o2_kebutuhan) }}"
                                                style="{{ is_array(old('peralatan', $peralatan)) && in_array('portable_o2', old('peralatan', $peralatan)) ? 'display: block;' : 'display: none;' }}"
                                                disabled>
                                            @error('o2_kebutuhan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="peralatan[]"
                                                value="ngt" id="ngt" @checked(is_array(old('peralatan', $peralatan)) && in_array('ngt', old('peralatan', $peralatan))) disabled>
                                            <label class="form-check-label" for="ngt">NGT</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="peralatan[]"
                                                value="alat_penghisap" id="alat_penghisap" @checked(is_array(old('peralatan', $peralatan)) && in_array('alat_penghisap', old('peralatan', $peralatan)))
                                                disabled>
                                            <label class="form-check-label" for="alat_penghisap">Alat Penghisap</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="peralatan[]"
                                                value="ventilator" id="ventilator" @checked(is_array(old('peralatan', $peralatan)) && in_array('ventilator', old('peralatan', $peralatan))) disabled>
                                            <label class="form-check-label" for="ventilator">Ventilator</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="peralatan[]"
                                                value="bagging" id="bagging" @checked(is_array(old('peralatan', $peralatan)) && in_array('bagging', old('peralatan', $peralatan))) disabled>
                                            <label class="form-check-label" for="bagging">Bagging</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="peralatan[]"
                                                value="kateter_urin" id="kateter_urin" @checked(is_array(old('peralatan', $peralatan)) && in_array('kateter_urin', old('peralatan', $peralatan)))
                                                disabled>
                                            <label class="form-check-label" for="kateter_urin">Kateter Urin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="peralatan[]"
                                                value="pompa_infus" id="pompa_infus" @checked(is_array(old('peralatan', $peralatan)) && in_array('pompa_infus', old('peralatan', $peralatan)))
                                                disabled>
                                            <label class="form-check-label" for="pompa_infus">Pompa Infus</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="peralatan[]"
                                                value="lainnya" id="lainnya_peralatan" @checked(is_array(old('peralatan', $peralatan)) && in_array('lainnya', old('peralatan', $peralatan)))
                                                onchange="toggleOtherInput('lainnya_peralatan', 'peralatan_lainnya_input')"
                                                disabled>
                                            <label class="form-check-label" for="lainnya_peralatan">Lainnya:</label>
                                            <input type="text" name="peralatan_lainnya" id="peralatan_lainnya_input"
                                                class="form-control form-control-sm mt-1"
                                                placeholder="Spesifikasi lainnya"
                                                value="{{ old('peralatan_lainnya', $transfer->peralatan_lainnya) }}"
                                                style="{{ is_array(old('peralatan', $peralatan)) && in_array('lainnya', old('peralatan', $peralatan)) ? 'display: block;' : 'display: none;' }}"
                                                disabled>
                                            @error('peralatan_lainnya')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    @error('peralatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $gangguan = is_string($transfer->gangguan)
                            ? json_decode($transfer->gangguan, true)
                            : $transfer->gangguan ?? [];
                        $inkontinensia = is_string($transfer->inkontinensia)
                            ? json_decode($transfer->inkontinensia, true)
                            : $transfer->inkontinensia ?? [];
                    @endphp

                    <!-- Gangguan dan Kondisi Khusus -->
                    <div class="form-section">
                        <div class="section-header">Gangguan dan Kondisi Khusus</div>
                        <div class="section-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Gangguan:</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                    value="mental" id="mental" @checked(is_array(old('gangguan', $gangguan)) && in_array('mental', old('gangguan', $gangguan))) disabled>
                                                <label class="form-check-label" for="mental">Mental</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                    value="pendengaran" id="pendengaran" @checked(is_array(old('gangguan', $gangguan)) && in_array('pendengaran', old('gangguan', $gangguan)))
                                                    disabled>
                                                <label class="form-check-label" for="pendengaran">Pendengaran</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                    value="sensasi" id="sensasi" @checked(is_array(old('gangguan', $gangguan)) && in_array('sensasi', old('gangguan', $gangguan))) disabled>
                                                <label class="form-check-label" for="sensasi">Sensasi</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                    value="bicara" id="bicara" @checked(is_array(old('gangguan', $gangguan)) && in_array('bicara', old('gangguan', $gangguan))) disabled>
                                                <label class="form-check-label" for="bicara">Bicara</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                    value="penglihatan" id="penglihatan" @checked(is_array(old('gangguan', $gangguan)) && in_array('penglihatan', old('gangguan', $gangguan)))
                                                    disabled>
                                                <label class="form-check-label" for="penglihatan">Penglihatan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="gangguan[]"
                                                    value="lainnya" id="lainnya_gangguan" @checked(is_array(old('gangguan', $gangguan)) && in_array('lainnya', old('gangguan', $gangguan)))
                                                    onchange="toggleOtherInput('lainnya_gangguan', 'gangguan_lainnya_input')"
                                                    disabled>
                                                <label class="form-check-label" for="lainnya_gangguan">Lainnya:</label>
                                                <input type="text" name="gangguan_lainnya" id="gangguan_lainnya_input"
                                                    class="form-control form-control-sm mt-1"
                                                    placeholder="Spesifikasi lainnya"
                                                    value="{{ old('gangguan_lainnya', $transfer->gangguan_lainnya) }}"
                                                    style="{{ is_array(old('gangguan', $gangguan)) && in_array('lainnya', old('gangguan', $gangguan)) ? 'display: block;' : 'display: none;' }}"
                                                    disabled>
                                                @error('gangguan_lainnya')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @error('gangguan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Inkontinensia:</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="inkontinensia[]" value="urine" id="urine"
                                                        @checked(is_array(old('inkontinensia', $inkontinensia)) && in_array('urine', old('inkontinensia', $inkontinensia))) disabled>
                                                    <label class="form-check-label" for="urine">Urine</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="inkontinensia[]" value="saliva" id="saliva"
                                                        @checked(is_array(old('inkontinensia', $inkontinensia)) && in_array('saliva', old('inkontinensia', $inkontinensia))) disabled>
                                                    <label class="form-check-label" for="saliva">Saliva</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="inkontinensia[]" value="alvi" id="alvi"
                                                        @checked(is_array(old('inkontinensia', $inkontinensia)) && in_array('alvi', old('inkontinensia', $inkontinensia))) disabled>
                                                    <label class="form-check-label" for="alvi">Alvi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="inkontinensia[]" value="lainnya" id="lainnya_inkontinensia"
                                                        @checked(is_array(old('inkontinensia', $inkontinensia)) && in_array('lainnya', old('inkontinensia', $inkontinensia)))
                                                        onchange="toggleOtherInput('lainnya_inkontinensia', 'inkontinensia_lainnya_input')"
                                                        disabled>
                                                    <label class="form-check-label"
                                                        for="lainnya_inkontinensia">Lainnya:</label>
                                                    <input type="text" name="inkontinensia_lainnya"
                                                        id="inkontinensia_lainnya_input"
                                                        class="form-control form-control-sm mt-1"
                                                        placeholder="Spesifikasi lainnya"
                                                        value="{{ old('inkontinensia_lainnya', $transfer->inkontinensia_lainnya) }}"
                                                        style="{{ is_array(old('inkontinensia', $inkontinensia)) && in_array('lainnya', old('inkontinensia', $inkontinensia)) ? 'display: block;' : 'display: none;' }}"
                                                        disabled>
                                                    @error('inkontinensia_lainnya')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        @error('inkontinensia')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Potensi untuk Dilakukan Rehabilitasi:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="rehabilitasi"
                                                value="baik" id="rehab_baik" @checked(old('rehabilitasi', $transfer->rehabilitasi) == 'baik') disabled>
                                            <label class="form-check-label" for="rehab_baik">Baik</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="rehabilitasi"
                                                value="sedang" id="rehab_sedang" @checked(old('rehabilitasi', $transfer->rehabilitasi) == 'sedang') disabled>
                                            <label class="form-check-label" for="rehab_sedang">Sedang</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="rehabilitasi"
                                                value="buruk" id="rehab_buruk" @checked(old('rehabilitasi', $transfer->rehabilitasi) == 'buruk') disabled>
                                            <label class="form-check-label" for="rehab_buruk">Buruk</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="rehabilitasi"
                                                value="lainnya" id="lainnya_rehabilitasi" @checked(old('rehabilitasi', $transfer->rehabilitasi) == 'lainnya')
                                                onchange="toggleOtherInputRadio('lainnya_rehabilitasi', 'rehabilitasi_lainnya_input', 'rehabilitasi')"
                                                disabled>
                                            <label class="form-check-label" for="lainnya_rehabilitasi">Lainnya:</label>
                                            <input type="text" name="rehabilitasi_lainnya"
                                                id="rehabilitasi_lainnya_input" class="form-control form-control-sm mt-1"
                                                placeholder="Spesifikasi lainnya"
                                                value="{{ old('rehabilitasi_lainnya', $transfer->rehabilitasi_lainnya) }}"
                                                style="{{ old('rehabilitasi', $transfer->rehabilitasi) == 'lainnya' ? 'display: block;' : 'display: none;' }}"
                                                disabled>
                                            @error('rehabilitasi_lainnya')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        @error('rehabilitasi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Pendamping saat pasien pindah:</label>
                                        <div class="mb-2">
                                            <label class="form-label">Nama petugas 1:</label>
                                            <select name="petugas1" class="form-select select2" disabled>
                                                <option value="">--Pilih--</option>
                                                @foreach ($petugas as $item)
                                                    @if ($item->kd_karyawan != auth()->user()->kd_karyawan)
                                                        <option value="{{ $item->kd_karyawan }}"
                                                            @selected(old('petugas1', $transfer->petugas1) == $item->kd_karyawan)>
                                                            {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' . $item->gelar_belakang }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('petugas1')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Nama petugas 2:</label>
                                            <select name="petugas2" class="form-select select2" disabled>
                                                <option value="">--Pilih--</option>
                                                @foreach ($petugas as $item)
                                                    @if ($item->kd_karyawan != auth()->user()->kd_karyawan)
                                                        <option value="{{ $item->kd_karyawan }}"
                                                            @selected(old('petugas2', $transfer->petugas2) == $item->kd_karyawan)>
                                                            {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' . $item->gelar_belakang }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('petugas2')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Nama petugas 3:</label>
                                            <select name="petugas3" class="form-select select2" disabled>
                                                <option value="">--Pilih--</option>
                                                @foreach ($petugas as $item)
                                                    @if ($item->kd_karyawan != auth()->user()->kd_karyawan)
                                                        <option value="{{ $item->kd_karyawan }}"
                                                            @selected(old('petugas3', $transfer->petugas3) == $item->kd_karyawan)>
                                                            {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' . $item->gelar_belakang }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('petugas3')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <label class="form-label fw-bold">Pemeriksaan Fisik:</label>
                                        <div class="mb-3">
                                            <label class="form-label">Status generalis (temuan yang signifikan):</label>
                                            <textarea name="status_generalis" class="form-control" rows="3"
                                                placeholder="Tuliskan temuan pemeriksaan fisik generalis yang signifikan" disabled>{{ old('status_generalis', $transfer->status_generalis) }}</textarea>
                                            @error('status_generalis')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status lokalis (temuan yang signifikan):</label>
                                            <textarea name="status_lokalis" class="form-control" rows="3"
                                                placeholder="Tuliskan temuan pemeriksaan fisik lokalis yang signifikan" disabled>{{ old('status_lokalis', $transfer->status_lokalis) }}</textarea>
                                            @error('status_lokalis')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Kemandirian -->
                    <div class="form-section">
                        <div class="section-header">STATUS KEMANDIRIAN</div>
                        <div class="section-content">
                            <p class="text-muted small">(Berikan tanda centang (✓) pada kolom yang sesuai)</p>
                            <div class="table-responsive">
                                <table class="table table-bordered table-status">
                                    <thead>
                                        <tr>
                                            <th width="30%"></th>
                                            <th width="23%" class="text-center">Mandiri</th>
                                            <th width="23%" class="text-center">Butuh bantuan</th>
                                            <th width="24%" class="text-center">Tidak dapat melakukan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Aktivitas di tempat tidur</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Berguling</td>
                                            <td class="text-center"><input type="radio" name="berguling"
                                                    value="mandiri" class="form-check-input" @checked(old('berguling', $transfer->berguling) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="berguling"
                                                    value="bantuan" class="form-check-input" @checked(old('berguling', $transfer->berguling) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="berguling"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('berguling', $transfer->berguling) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Duduk</td>
                                            <td class="text-center"><input type="radio" name="duduk" value="mandiri"
                                                    class="form-check-input" @checked(old('duduk', $transfer->duduk) == 'mandiri') disabled></td>
                                            <td class="text-center"><input type="radio" name="duduk" value="bantuan"
                                                    class="form-check-input" @checked(old('duduk', $transfer->duduk) == 'bantuan') disabled></td>
                                            <td class="text-center"><input type="radio" name="duduk"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('duduk', $transfer->duduk) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        @error('berguling')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        @error('duduk')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        <tr>
                                            <td><strong>Higiene pribadi</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Wajah, rambut, tangan</td>
                                            <td class="text-center"><input type="radio" name="higiene_wajah"
                                                    value="mandiri" class="form-check-input" @checked(old('higiene_wajah', $transfer->higiene_wajah) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="higiene_wajah"
                                                    value="bantuan" class="form-check-input" @checked(old('higiene_wajah', $transfer->higiene_wajah) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="higiene_wajah"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('higiene_wajah', $transfer->higiene_wajah) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Tubuh, perineum</td>
                                            <td class="text-center"><input type="radio" name="higiene_tubuh"
                                                    value="mandiri" class="form-check-input" @checked(old('higiene_tubuh', $transfer->higiene_tubuh) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="higiene_tubuh"
                                                    value="bantuan" class="form-check-input" @checked(old('higiene_tubuh', $transfer->higiene_tubuh) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="higiene_tubuh"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('higiene_tubuh', $transfer->higiene_tubuh) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Ekstremitas bawah</td>
                                            <td class="text-center"><input type="radio"
                                                    name="higiene_ekstremitas_bawah" value="mandiri"
                                                    class="form-check-input" @checked(old('higiene_ekstremitas_bawah', $transfer->higiene_ekstremitas_bawah) == 'mandiri') disabled></td>
                                            <td class="text-center"><input type="radio"
                                                    name="higiene_ekstremitas_bawah" value="bantuan"
                                                    class="form-check-input" @checked(old('higiene_ekstremitas_bawah', $transfer->higiene_ekstremitas_bawah) == 'bantuan') disabled></td>
                                            <td class="text-center"><input type="radio"
                                                    name="higiene_ekstremitas_bawah" value="tidak_bisa"
                                                    class="form-check-input" @checked(old('higiene_ekstremitas_bawah', $transfer->higiene_ekstremitas_bawah) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Traktus digestivus</td>
                                            <td class="text-center"><input type="radio" name="traktus_digestivus"
                                                    value="mandiri" class="form-check-input" @checked(old('traktus_digestivus', $transfer->traktus_digestivus) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="traktus_digestivus"
                                                    value="bantuan" class="form-check-input" @checked(old('traktus_digestivus', $transfer->traktus_digestivus) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="traktus_digestivus"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('traktus_digestivus', $transfer->traktus_digestivus) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Traktus urinarius</td>
                                            <td class="text-center"><input type="radio" name="traktus_urinarius"
                                                    value="mandiri" class="form-check-input" @checked(old('traktus_urinarius', $transfer->traktus_urinarius) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="traktus_urinarius"
                                                    value="bantuan" class="form-check-input" @checked(old('traktus_urinarius', $transfer->traktus_urinarius) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="traktus_urinarius"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('traktus_urinarius', $transfer->traktus_urinarius) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        @error('higiene_wajah')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        @error('higiene_tubuh')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        @error('higiene_ekstremitas_bawah')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        @error('traktus_digestivus')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        @error('traktus_urinarius')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        <tr>
                                            <td><strong>Berpakaian</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Ekstremitas atas</td>
                                            <td class="text-center"><input type="radio" name="pakaian_atas"
                                                    value="mandiri" class="form-check-input" @checked(old('pakaian_atas', $transfer->pakaian_atas) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="pakaian_atas"
                                                    value="bantuan" class="form-check-input" @checked(old('pakaian_atas', $transfer->pakaian_atas) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="pakaian_atas"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('pakaian_atas', $transfer->pakaian_atas) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Batang tubuh</td>
                                            <td class="text-center"><input type="radio" name="pakaian_tubuh"
                                                    value="mandiri" class="form-check-input" @checked(old('pakaian_tubuh', $transfer->pakaian_tubuh) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="pakaian_tubuh"
                                                    value="bantuan" class="form-check-input" @checked(old('pakaian_tubuh', $transfer->pakaian_tubuh) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="pakaian_tubuh"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('pakaian_tubuh', $transfer->pakaian_tubuh) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Ekstremitas bawah</td>
                                            <td class="text-center"><input type="radio" name="pakaian_bawah"
                                                    value="mandiri" class="form-check-input" @checked(old('pakaian_bawah', $transfer->pakaian_bawah) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="pakaian_bawah"
                                                    value="bantuan" class="form-check-input" @checked(old('pakaian_bawah', $transfer->pakaian_bawah) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="pakaian_bawah"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('pakaian_bawah', $transfer->pakaian_bawah) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        @error('pakaian_atas')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        @error('pakaian_tubuh')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        @error('pakaian_bawah')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        <tr>
                                            <td><strong>Makan</strong></td>
                                            <td class="text-center"><input type="radio" name="makan" value="mandiri"
                                                    class="form-check-input" @checked(old('makan', $transfer->makan) == 'mandiri') disabled></td>
                                            <td class="text-center"><input type="radio" name="makan" value="bantuan"
                                                    class="form-check-input" @checked(old('makan', $transfer->makan) == 'bantuan') disabled></td>
                                            <td class="text-center"><input type="radio" name="makan"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('makan', $transfer->makan) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        @error('makan')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        <tr>
                                            <td><strong>Pergerakan</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Jalan kaki</td>
                                            <td class="text-center"><input type="radio" name="jalan_kaki"
                                                    value="mandiri" class="form-check-input" @checked(old('jalan_kaki', $transfer->jalan_kaki) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="jalan_kaki"
                                                    value="bantuan" class="form-check-input" @checked(old('jalan_kaki', $transfer->jalan_kaki) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="jalan_kaki"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('jalan_kaki', $transfer->jalan_kaki) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;Kursi roda</td>
                                            <td class="text-center"><input type="radio" name="kursi_roda_kemandirian"
                                                    value="mandiri" class="form-check-input" @checked(old('kursi_roda_kemandirian', $transfer->kursi_roda_kemandirian) == 'mandiri')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="kursi_roda_kemandirian"
                                                    value="bantuan" class="form-check-input" @checked(old('kursi_roda_kemandirian', $transfer->kursi_roda_kemandirian) == 'bantuan')
                                                    disabled></td>
                                            <td class="text-center"><input type="radio" name="kursi_roda_kemandirian"
                                                    value="tidak_bisa" class="form-check-input"
                                                    @checked(old('kursi_roda_kemandirian', $transfer->kursi_roda_kemandirian) == 'tidak_bisa') disabled></td>
                                        </tr>
                                        @error('jalan_kaki')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                        @error('kursi_roda_kemandirian')
                                            <tr>
                                                <td colspan="4"><small class="text-danger">{{ $message }}</small>
                                                </td>
                                            </tr>
                                        @enderror
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                <div class="mb-3">
                                    <label class="form-label">Pemeriksaan penunjang diagnostik yang sudah dilakukan (EKG,
                                        Lab,
                                        dll):</label>
                                    <textarea name="pemeriksaan_penunjang" class="form-control" rows="3" disabled>{{ old('pemeriksaan_penunjang', $transfer->pemeriksaan_penunjang) }}</textarea>
                                    @error('pemeriksaan_penunjang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Intervensi/tindakan yang sudah dilakukan:</label>
                                    <textarea name="intervensi" class="form-control" rows="3" disabled>{{ old('intervensi', $transfer->intervensi) }}</textarea>
                                    @error('intervensi')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Diet:</label>
                                    <textarea name="diet" class="form-control" rows="3" disabled>{{ old('diet', $transfer->diet) }}</textarea>
                                    @error('diet')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rencana perawatan selanjutnya:</label>
                                    <textarea name="rencana_perawatan" class="form-control" rows="3" disabled>{{ old('rencana_perawatan', $transfer->rencana_perawatan) }}</textarea>
                                    @error('rencana_perawatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terapi Saat Pindah Section -->
                    <div class="form-section">
                        <div class="section-header">TERAPI SAAT PINDAH</div>
                        <div class="section-content">

                            <!-- Tabel Display Terapi -->
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Jumlah</th>
                                            <th>Dosis</th>
                                            <th>Frekuensi</th>
                                            <th>Cara Pemberian</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabelData">
                                        <tr id="barisKosong">
                                            <td colspan="6" class="text-center text-muted py-4">
                                                Belum ada data terapi obat
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" id="terapiData" name="terapi_data"
                                    value="{{ old('terapi_data', json_encode($transfer->terapi_data ?? [])) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Derajat Pasien -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="derajat_pasien" class="form-label">Derajat Pasien</label>
                                <select name="derajat_pasien" id="derajat_pasien" class="form-select" disabled>
                                    <option value="">--Pilih--</option>
                                    <option value="Derajat 1" @selected(old('derajat_pasien', $transfer->derajat_pasien) == 'Derajat 1')>Derajat 1 - Transporter -
                                        Perawat
                                    </option>
                                    <option value="Derajat 2" @selected(old('derajat_pasien', $transfer->derajat_pasien) == 'Derajat 2')>Derajat 2 - Transporter -
                                        Perawat
                                        - Dokter</option>
                                    <option value="Derajat 3" @selected(old('derajat_pasien', $transfer->derajat_pasien) == 'Derajat 3')>Derajat 3 - Transporter -
                                        Perawat
                                        - Dokter yang kompeten</option>
                                    <option value="Derajat 4" @selected(old('derajat_pasien', $transfer->derajat_pasien) == 'Derajat 4')>Derajat 4 - Transporter -
                                        Perawat
                                        - Dokter yang kompeten menangani pasien kritis dan berpengalaman minimal 6 bulan
                                        bekerja
                                        di IGD/ ICU</option>
                                </select>
                                @error('derajat_pasien')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </x-content-card>
            @endif
        </div>
    </div>
@endsection
