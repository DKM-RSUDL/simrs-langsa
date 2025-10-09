@extends('layouts.administrator.master')


@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit-include')
    @push('modals')
        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit-modal-riwayat-kehamilan')
        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit-modal-riwayat-penyakin-keluarwa')
        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit-modal-riwayat-obstetrik')
        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit-modal-nyeri-efek-nyeri')
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form method="POST" enctype="multipart/form-data"
                action="{{ route('rawat-inap.asesmen.medis.obstetri-maternitas.update', [
                    'kd_unit' => request()->route('kd_unit'),
                    'kd_pasien' => request()->route('kd_pasien'),
                    'tgl_masuk' => request()->route('tgl_masuk'),
                    'urut_masuk' => request()->route('urut_masuk'),
                    'id' => $asesmen->id,
                ]) }}">
                @csrf
                @method('PUT')

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <div class="px-3">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <h4 class="header-asesmen">Edit Asesmen Awal Medis Obstetri</h4>
                                        <p>
                                            Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                        </p>
                                    </div>
                                    {{-- <div class="col-md-4">
                                    <div class="progress-wrapper">
                                        <div class="progress-status">
                                            <span class="progress-label">Progress Pengisian</span>
                                            <span class="progress-percentage">60%</span>
                                        </div>
                                        <div class="custom-progress">
                                            <div class="progress-bar-custom" style="width: 60%"></div>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">6/10 bagian telah diisi</small>
                                        </div>
                                    </div>
                                </div> --}}
                                </div>
                            </div>

                            {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                            <div class="px-3">
                                <div>
                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data Masuk</h5>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Tanggal dan Jam Masuk</label>
                                            <div class="col-sm-8 d-flex gap-3">
                                                @php
                                                    $datetime = $asesmen->asesmenObstetri->tgl_masuk ?? null;
                                                    $date = date('Y-m-d');
                                                    $time = date('H:i');

                                                    if ($datetime) {
                                                        // Ubah string datetime ke objek DateTime PHP
                                                        $dt = new DateTime($datetime);
                                                        $date = $dt->format('Y-m-d');
                                                        $time = $dt->format('H:i');
                                                    }
                                                @endphp

                                                <input type="date" class="form-control" name="tgl_masuk"
                                                    value="{{ $date }}">
                                                <input type="time" class="form-control" name="jam_masuk"
                                                    value="{{ $time }}">
                                            </div>
                                        </div>

                                        <div class="form-group row mt-3">
                                            <label class="col-sm-3 col-form-label">Pemeriksaan antenatal di RS
                                                Langsa</label>
                                            <div class="col-sm-8 d-flex align-items-center gap-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="antenatal_rs"
                                                        id="rs_tidak" value="0"
                                                        {{ ($asesmen->asesmenObstetri->antenatal_rs ?? '') == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="rs_tidak">Tidak</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="antenatal_rs"
                                                        id="rs_ya" value="1"
                                                        {{ ($asesmen->asesmenObstetri->antenatal_rs ?? '') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="rs_ya">Ya</label>
                                                </div>

                                                <div class="input-group" style="width: 150px;">
                                                    <input type="number" class="form-control" name="antenatal_rs_count"
                                                        placeholder="Berapa kali" min="0"
                                                        value="{{ $asesmen->asesmenObstetri->antenatal_rs_count ?? '' }}"
                                                        {{ ($asesmen->asesmenObstetri->antenatal_rs ?? '') != '1' ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-3">
                                            <label class="col-sm-3 col-form-label">Pemeriksaan antenatal di tempat
                                                lain</label>
                                            <div class="col-sm-8 d-flex align-items-center gap-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="antenatal_lain"
                                                        id="lain_tidak" value="0"
                                                        {{ ($asesmen->asesmenObstetri->antenatal_lain ?? '') == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="lain_tidak">Tidak</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="antenatal_lain"
                                                        id="lain_ya" value="1"
                                                        {{ ($asesmen->asesmenObstetri->antenatal_lain ?? '') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="lain_ya">Ya</label>
                                                </div>

                                                <div class="input-group" style="width: 150px;">
                                                    <input type="number" class="form-control" name="antenatal_lain_count"
                                                        placeholder="Berapa kali" min="0"
                                                        value="{{ $asesmen->asesmenObstetri->antenatal_lain_count ?? '' }}"
                                                        {{ ($asesmen->asesmenObstetri->antenatal_lain ?? '') != '1' ? 'disabled' : '' }}>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row mt-3">
                                            <label class="col-sm-3 col-form-label">Nama Pemeriksa</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="nama_pemeriksa" disabled
                                                    placeholder="Nama dokter/bidan/perawat"
                                                    value="{{ $asesmen->asesmenObstetri->nama_pemeriksa ?? (auth()->user()->name ?? '-') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="anamnesis">
                                        <h5 class="section-title">2. Anamnesis</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Anamnesis</label>
                                            <textarea class="form-control" name="anamnesis_anamnesis" rows="4" placeholder="keluhan utama pasien">{{ $asesmen->asesmenObstetri->anamnesis_anamnesis ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="pemeriksaan-fisik">
                                        <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                        <!-- Pemeriksaan Awal -->
                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Keadaan Umum</label>
                                            <input type="text" class="form-control" name="keadaan_umum"
                                                placeholder="jelaskan"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->keadaan_umum ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Tek Darah (mmHg)</label>
                                            <div class="d-flex gap-2">
                                                <input type="number" class="form-control" name="tekanan_darah_sistole"
                                                    placeholder="Sistole"
                                                    value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->tekanan_darah_sistole ?? '' }}">
                                                <input type="number" class="form-control" name="tekanan_darah_diastole"
                                                    placeholder="Diastole"
                                                    value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->tekanan_darah_diastole ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Nadi (Per Menit)</label>
                                            <input type="number" class="form-control" name="nadi"
                                                placeholder="frekuensi nadi per menit"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->nadi ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Pernafasan (Per
                                                Menit)</label>
                                            <input type="number" class="form-control" name="pernafasan"
                                                placeholder="frekuensi nafas per menit"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->pernafasan ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Suhu (C)</label>
                                            <input type="text" class="form-control" name="suhu"
                                                placeholder="suhu dalam celcius"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->suhu ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Kesadaran</label>
                                            <select class="form-select" name="kesadaran">
                                                <option value="" selected>pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">AVPU</label>
                                            <select class="form-select" name="avpu">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->avpu ?? '') == '0' ? 'selected' : '' }}>
                                                    Sadar Baik/Alert : 0</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->avpu ?? '') == '1' ? 'selected' : '' }}>
                                                    Berespon dengan kata-kata/Voice: 1
                                                </option>
                                                <option value="2"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->avpu ?? '') == '2' ? 'selected' : '' }}>
                                                    Hanya berespon jika dirangsang nyeri/pain:
                                                    2</option>
                                                <option value="3"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->avpu ?? '') == '3' ? 'selected' : '' }}>
                                                    Pasien tidak sadar/unresponsive: 3
                                                </option>
                                                <option value="4"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->avpu ?? '') == '4' ? 'selected' : '' }}>
                                                    Gelisah atau bingung: 4</option>
                                                <option value="5"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->avpu ?? '') == '5' ? 'selected' : '' }}>
                                                    Acute Confusional States: 5</option>
                                            </select>
                                        </div>

                                        <!-- Pemeriksaan Fisik Komprehensif -->
                                        <div class="mt-4 mb-3">
                                            <h6 class="fw-bold">Pemeriksaan Fisik Komprehensif</h6>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Posisi Janin</label>
                                            <select class="form-select" name="komprehensif_posisi_janin">
                                                <option value="" selected>pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Tinggi Fundus Uteri
                                                (Cm)</label>
                                            <input type="number" class="form-control" name="komprehensif_tinggi_fundus"
                                                placeholder="dalam cm"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_tinggi_fundus ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2 fw-bold" style="min-width: 200px;">Kontraksi
                                                (HIS)</label>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Frekuensi</label>
                                            <input type="text" class="form-control" name="kontraksi_frekuensi"
                                                placeholder="Frekuensi"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_frekuensi ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Kekuatan</label>
                                            <select class="form-select" name="kontraksi_kekuatan">
                                                <option value="" selected>pilih</option>
                                                <option value="baik"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_kekuatan ?? '') == 'baik' ? 'selected' : '' }}>
                                                    Baik</option>
                                                <option value="sedang"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_kekuatan ?? '') == 'sedang' ? 'selected' : '' }}>
                                                    Sedang</option>
                                                <option value="lemah"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_kekuatan ?? '') == 'lemah' ? 'selected' : '' }}>
                                                    Lemah</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Irama</label>
                                            <select class="form-select" name="kontraksi_irama">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_irama ?? '') == '1' ? 'selected' : '' }}>
                                                    Teratur</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_irama ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak Teratur</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Letak Janin</label>
                                            <select class="form-select" name="kontraksi_letak_janin">
                                                <option value="" selected>pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_letak_janin ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_letak_janin ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Presentasi Janin</label>
                                            <select class="form-select" name="kontraksi_presentasi_janin">
                                                <option value="" selected>pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Sikap Janin</label>
                                            <select class="form-select" name="kontraksi_sikap_janin">
                                                <option value="" selected>pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2 fw-bold" style="min-width: 200px;">Denyut Jantung
                                                Janin (DJJ)</label>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Frekuensi</label>
                                            <input type="text" class="form-control" name="djj_frekuensi"
                                                placeholder="Frekuensi"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_frekuensi ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Irama</label>
                                            <select class="form-select" name="djj_irama">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_irama ?? '') == '1' ? 'selected' : '' }}>
                                                    Teratur</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_irama ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak Teratur</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2 fw-bold" style="min-width: 200px;">Serviks</label>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Konsistensi</label>
                                            <select class="form-select" name="serviks_konsistensi">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_konsistensi ?? '') == '1' ? 'selected' : '' }}>
                                                    Teratur</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_konsistensi ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak Teratur</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Station</label>
                                            <div class="d-flex gap-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="serviks_station" value="-3" id="station-3"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_station ?? '') == '-3' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="station-3">-3</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="serviks_station" value="-2" id="station-2"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_station ?? '') == '-2' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="station-2">-2</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="serviks_station" value="-1" id="station-1"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_station ?? '') == '-1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="station-1">-1</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="serviks_station" value="0" id="station0"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_station ?? '') == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="station0">0</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="serviks_station" value="+1" id="station1"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_station ?? '') == '+1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="station1">+1</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="serviks_station" value="+2" id="station2"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_station ?? '') == '+2' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="station2">+2</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="serviks_station" value="+3" id="station3"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_station ?? '') == '+3' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="station3">+3</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Penurunan</label>
                                            <select class="form-select" name="serviks_penurunan">
                                                <option value="">pilih</option>
                                                <option value="<50%"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_penurunan ?? '') == '<50%' ? 'selected' : '' }}>
                                                    < 50%</option>
                                                <option value=">50%"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_penurunan ?? '') == '>50%' ? 'selected' : '' }}>
                                                    > 50%</option>
                                                <option value="100%"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_penurunan ?? '') == '100%' ? 'selected' : '' }}>
                                                    100%</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Pembukaan</label>
                                            <input type="text" class="form-control" name="serviks_pembukaan"
                                                placeholder=""
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_pembukaan ?? '' }}">
                                            <label class="d-block mr-2">Jam</label>
                                            @php
                                                $jam_pembukaan =
                                                    $asesmen->rmeAsesmenObstetriPemeriksaanFisik
                                                        ->serviks_jam_pembukaan ?? null;

                                                $formatted_time = date('H:i');

                                                if ($jam_pembukaan) {
                                                    if (preg_match('/^\d{2}:\d{2}(:\d{2})?$/', $jam_pembukaan)) {
                                                        $formatted_time = substr($jam_pembukaan, 0, 5);
                                                    } else {
                                                        $timestamp = strtotime($jam_pembukaan);
                                                        if ($timestamp !== false) {
                                                            $formatted_time = date('H:i', $timestamp);
                                                        }
                                                    }
                                                }
                                            @endphp

                                            <input type="time" class="form-control" name="serviks_jam_pembukaan"
                                                value="{{ $formatted_time }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Posisi</label>
                                            <select class="form-select" name="serviks_posisi">
                                                <option value="">pilih</option>
                                                <option value="Belakang"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_posisi ?? '') == 'Belakang' ? 'selected' : '' }}>
                                                    Belakang</option>
                                                <option value="Tengah"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_posisi ?? '') == 'Tengah' ? 'selected' : '' }}>
                                                    Tengah</option>
                                                <option value="Depan"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_posisi ?? '') == 'Depan' ? 'selected' : '' }}>
                                                    Depan</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Irama</label>
                                            <select class="form-select" name="serviks_irama">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_irama ?? '') == '1' ? 'selected' : '' }}>
                                                    Teratur</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_irama ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak Teratur</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2 fw-bold" style="min-width: 200px;">Panggul</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="d-block mb-2" style="min-width: 200px;">Promontorium</label>
                                                <select class="form-select" name="panggul_promontorium">
                                                    <option value="">pilih</option>
                                                    <option value="1"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_promontorium ?? '') == '1' ? 'selected' : '' }}>
                                                        Teratur</option>
                                                    <option value="0"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_promontorium ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak Teratur</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="d-block mb-2" style="min-width: 200px;">Line
                                                    Terminalis</label>
                                                <select class="form-select" name="panggul_line_terminalis">
                                                    <option value="">pilih</option>
                                                    <option value="1"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_line_terminalis ?? '') == '1' ? 'selected' : '' }}>
                                                        Teraba = 2/3</option>
                                                    <option value="0"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_line_terminalis ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak Teraba</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="d-block mb-2" style="min-width: 200px;">Spina
                                                    Ischiadika</label>
                                                <select class="form-select" name="panggul_spina_ischiadika">
                                                    <option value="">pilih</option>
                                                    <option value="1"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika ?? '') == '1' ? 'selected' : '' }}>
                                                        Menonjol</option>
                                                    <option value="0"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak Menonjol</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="d-block mb-2" style="min-width: 200px;">Arkus Pubis</label>
                                                <select class="form-select" name="panggul_arkus_pubis">
                                                    <option value="">pilih</option>
                                                    <option value="lancip"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_arkus_pubis ?? '') == 'lancip' ? 'selected' : '' }}>
                                                        Lancip</option>
                                                    <option value="tumpul"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_arkus_pubis ?? '') == 'tumpul' ? 'selected' : '' }}>
                                                        Tumpul</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="d-block mb-2" style="min-width: 200px;">Lengkung
                                                    Sakrum</label>
                                                <select class="form-select" name="panggul_lengkung_sakrum">
                                                    <option value="">pilih</option>
                                                    <option value="Cekung"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_lengkung_sakrum ?? '') == 'Cekung' ? 'selected' : '' }}>
                                                        Cekung</option>
                                                    <option value="Datar"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_lengkung_sakrum ?? '') == 'Datar' ? 'selected' : '' }}>
                                                        Datar</option>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="d-block mb-2" style="min-width: 200px;">Dinding
                                                    Samping</label>
                                                <select class="form-select" name="panggul_dinding_samping">
                                                    <option value="">pilih</option>
                                                    <option value="Tegak"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_dinding_samping ?? '') == 'Tegak' ? 'selected' : '' }}>
                                                        Tegak</option>
                                                    <option value="Konvergen"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_dinding_samping ?? '') == 'Konvergen'
                                                            ? 'selected'
                                                            : '' }}>
                                                        Konvergen</option>
                                                    <option value="Diverger"
                                                        {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_dinding_samping ?? '') == 'Diverger'
                                                            ? 'selected'
                                                            : '' }}>
                                                        Diverger</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Simpulan</label>
                                            <select class="form-select" name="panggul_simpulan">
                                                <option value="">pilih</option>
                                                <option value="Normal"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_simpulan ?? '') == 'Normal' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="Sempit"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_simpulan ?? '') == 'Sempit' ? 'selected' : '' }}>
                                                    Sempit</option>
                                                <option value="Borderline"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_simpulan ?? '') == 'Borderline' ? 'selected' : '' }}>
                                                    Borderline</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Pembukaan (Cm)</label>
                                            <input type="number" class="form-control" name="panggul_pembukaan_cm"
                                                placeholder="dalam cm"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_pembukaan_cm ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Selaput Ketuban</label>
                                            <select class="form-select" name="panggul_selaput_ketuban">
                                                <option value="">pilih</option>
                                                <option value="Utuh"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_selaput_ketuban ?? '') == 'Utuh' ? 'selected' : '' }}>
                                                    Utuh</option>
                                                <option value="Pecah"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_selaput_ketuban ?? '') == 'Pecah' ? 'selected' : '' }}>
                                                    Pecah</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Air Ketuban</label>
                                            <select class="form-select" name="panggul_air_ketuban">
                                                <option value="">pilih</option>
                                                <option value="Jernih"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_air_ketuban ?? '') == 'Jernih' ? 'selected' : '' }}>
                                                    Jernih</option>
                                                <option value="Keruh"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_air_ketuban ?? '') == 'Keruh' ? 'selected' : '' }}>
                                                    Keruh</option>
                                                <option value="Bau"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_air_ketuban ?? '') == 'Bau' ? 'selected' : '' }}>
                                                    Bau</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="d-block mb-2" style="min-width: 200px;">Presentasi</label>
                                            <select class="form-select" name="panggul_presentasi">
                                                <option value="">pilih</option>
                                                <option value="Belakang Kepala"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_presentasi ?? '') == 'Belakang Kepala'
                                                        ? 'selected'
                                                        : '' }}>
                                                    Belakang Kepala</option>
                                                <option value="Puncak Kepala"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_presentasi ?? '') ==
                                                    'Puncak
                                                                                                                                                                                                                                                                                                                    Kepala'
                                                        ? 'selected'
                                                        : '' }}>
                                                    Puncak Kepala</option>
                                                <option value="Dahi"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_presentasi ?? '') == 'Dahi' ? 'selected' : '' }}>
                                                    Dahi</option>
                                                <option value="Muka"
                                                    {{ ($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_presentasi ?? '') == 'Muka' ? 'selected' : '' }}>
                                                    Muka</option>
                                            </select>
                                        </div>

                                        <!-- Antropometri -->
                                        <div class="mt-4 mb-3">
                                            <h6>Antropometri</h6>
                                        </div>

                                        <div class="form-group mt-4">
                                            <label style="min-width: 200px;">Tinggi Badan</label>
                                            <input type="number" class="form-control" name="antropometri_tinggi_badan"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometri_tinggi_badan ?? '' }}">
                                        </div>
                                        <div class="form-group mt-4">
                                            <label style="min-width: 200px;">Berat Badan</label>
                                            <input type="number" class="form-control" name="antropometr_berat_badan"
                                                value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometr_berat_badan ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" style="min-width: 200px;">Indeks Massa Tubuh
                                                (IMT)</label>
                                            <div class="flex-grow-1">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="antropometri_imt"
                                                        value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometri_imt ?? '' }}"
                                                        readonly>
                                                    <span class="input-group-text text-muted fst-italic">rumus: IMT = berat
                                                        (kg) / tinggi (m) / tinggi (m)</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" style="min-width: 200px;">Luas Permukaan Tubuh
                                                (LPT)</label>
                                            <div class="flex-grow-1">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="antropometri_lpt"
                                                        value="{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometri_lpt ?? '' }}"
                                                        readonly>
                                                    <span class="input-group-text text-muted fst-italic">rumus: LPT =
                                                        tinggi
                                                        (m2) x berat (kg) / 3600</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 row align-items-center">
                                            <p class="col-3">
                                                Pemeriksaan Fisik
                                            </p>
                                            <div class="col-9">
                                                <div class="alert alert-info mb-3 mt-4">
                                                    <p class="mb-0 small">
                                                        <i class="bi bi-info-circle me-2"></i>
                                                        Centang normal jika fisik yang dinilai normal, pilih tanda tambah
                                                        untuk
                                                        menambah
                                                        keterangan fisik yang ditemukan tidak normal.
                                                        Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

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
                                                                            $keterangan = $pemeriksaanData->keterangan;
                                                                            $isNormal = empty($keterangan);
                                                                        }
                                                                    @endphp
                                                                    <div class="pemeriksaan-item">
                                                                        <div
                                                                            class="d-flex align-items-center border-bottom pb-2">
                                                                            <div class="flex-grow-1">{{ $item->nama }}
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
                                    </div>

                                    <div class="section-separator" id="status-nyeri">
                                        <h5 class="section-title mb-4">4. Status Nyeri</h5>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Jenis Skala
                                                NYERI</label>
                                            <select class="form-select" id="jenisSkalaSelect" name="jenis_skala_nyeri">
                                                <option value="">Pilih</option>
                                                <option value="nrs"
                                                    {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->jenis_skala_nyeri ?? '') == 'nrs' ? 'selected' : '' }}>
                                                    Scale NRS, VAS, VRS</option>
                                                <option value="flacc"
                                                    {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->jenis_skala_nyeri ?? '') == 'flacc' ? 'selected' : '' }}>
                                                    Face, Legs, Activity, Cry,
                                                    Consolability (FLACC)</option>
                                                <option value="cries"
                                                    {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->jenis_skala_nyeri ?? '') == 'cries' ? 'selected' : '' }}>
                                                    Crying, Requires, Increased,
                                                    Expression, Sleepless (CRIES)</option>
                                            </select>
                                        </div>

                                        <div id="selectedScaleInfo" class="mt-3 d-none">
                                            <button id="scaleInfoBtn" class="btn btn-info" hidden></button>
                                        </div>
                                        <div id="selectedScaleDisplay" class="mt-3 d-none">
                                            {{-- Akan diisi melalui JavaScript saat tombol simpan di modal ditekan --}}
                                        </div>
                                        @push('modals')
                                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit-modal-skala-nyeri')
                                        @endpush

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Nilai Skala
                                                Nyeri</label>
                                            <input type="number" class="form-control" name="skala_nyeri"
                                                id="skala_nyeri_main"
                                                value="{{ $asesmen->rmeAsesmenObstetriStatusNyeri->skala_nyeri ?? 0 }}"
                                                min="0" max="10" readonly>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Kesimpulan Nyeri</label>
                                            <div id="kesimpulanNyeri" class="p-3 bg-success text-white rounded">
                                                {{ $asesmen->rmeAsesmenObstetriStatusNyeri->kesimpulan_nyeri ??
                                                    'Nyeri
                                                                                                                                                                                                                                                                                            Ringan' }}
                                            </div>
                                            <input type="hidden" name="kesimpulan_nyeri" id="kesimpulanNyeriInput"
                                                value="{{ $asesmen->rmeAsesmenObstetriStatusNyeri->kesimpulan_nyeri ?? 'Nyeri Ringan' }}">
                                        </div>

                                        <div class="mt-4 mb-3">
                                            <h6>Karakteristik Nyeri</h6>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="d-block mb-2" style="min-width: 100px;">Lokasi</label>
                                                    <input type="text" class="form-control" name="lokasi_nyeri"
                                                        value="{{ $asesmen->rmeAsesmenObstetriStatusNyeri->lokasi_nyeri ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="d-block mb-2" style="min-width: 100px;">Durasi</label>
                                                    <input type="text" class="form-control" name="durasi_nyeri"
                                                        value="{{ $asesmen->rmeAsesmenObstetriStatusNyeri->durasi_nyeri ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="d-block mb-2" style="min-width: 100px;">Jenis
                                                        nyeri</label>
                                                    <select class="form-select" name="jenis_nyeri">
                                                        <option value="">Pilih</option>
                                                        <option value="Akut"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->jenis_nyeri ?? '') == 'Akut' ? 'selected' : '' }}>
                                                            Akut</option>
                                                        <option value="Kronik"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->jenis_nyeri ?? '') == 'Kronik' ? 'selected' : '' }}>
                                                            Kronik</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="d-block mb-2"
                                                        style="min-width: 100px;">Frekuensi</label>
                                                    <select class="form-select" name="frekuensi_nyeri">
                                                        <option value="">Pilih</option>
                                                        <option value="Jarang"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->frekuensi_nyeri ?? '') == 'Jarang' ? 'selected' : '' }}>
                                                            Jarang</option>
                                                        <option value="Hilang Timbul"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->frekuensi_nyeri ?? '') == 'Hilang Timbul' ? 'selected' : '' }}>
                                                            Hilang Timbul</option>
                                                        <option value="Terus Menerus"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->frekuensi_nyeri ?? '') == 'Terus Menerus' ? 'selected' : '' }}>
                                                            Terus Menerus</option>
                                                        <option value="Tidak Terbuka"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->frekuensi_nyeri ?? '') == 'Tidak Terbuka' ? 'selected' : '' }}>
                                                            Tidak Terbuka</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="d-block mb-2"
                                                        style="min-width: 100px;">Menjalar?</label>
                                                    <select class="form-select" name="menjalar">
                                                        <option value="">Pilih</option>
                                                        <option value="1"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->menjalar ?? '') == '1' ? 'selected' : '' }}>
                                                            Ya</option>
                                                        <option value="0"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->menjalar ?? '') == '0' ? 'selected' : '' }}>
                                                            Tidak</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="d-block mb-2" style="min-width: 100px;">Kualitas</label>
                                                    <select class="form-select" name="kualitas_nyeri">
                                                        <option value="">Pilih</option>
                                                        <option value="Nyeri Tumpul"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->kualitas_nyeri ?? '') == 'Nyeri Tumpul' ? 'selected' : '' }}>
                                                            Nyeri Tumpul</option>
                                                        <option value="Nyeri Tajam"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->kualitas_nyeri ?? '') == 'Nyeri Tajam' ? 'selected' : '' }}>
                                                            Nyeri Tajam</option>
                                                        <option value="Panas/ Terbakar"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->kualitas_nyeri ?? '') == 'Panas/ Terbakar' ? 'selected' : '' }}>
                                                            Panas/ Terbakar
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="d-block mb-2" style="min-width: 100px;">Faktor
                                                        pemberat</label>
                                                    <select class="form-select" name="faktor_pemberat">
                                                        <option value="">Pilih</option>
                                                        <option value="Cahaya"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->faktor_pemberat ?? '') == 'Cahaya' ? 'selected' : '' }}>
                                                            Cahaya</option>
                                                        <option value="Gelap"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->faktor_pemberat ?? '') == 'Gelap' ? 'selected' : '' }}>
                                                            Gelap</option>
                                                        <option value="Berbaring"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->faktor_pemberat ?? '') == 'Berbaring' ? 'selected' : '' }}>
                                                            Berbaring</option>
                                                        <option value="Gerakan"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->faktor_pemberat ?? '') == 'Gerakan' ? 'selected' : '' }}>
                                                            Gerakan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="d-block mb-2" style="min-width: 100px;">Faktor
                                                        peringan</label>
                                                    <select class="form-select" name="faktor_peringan">
                                                        <option value="">Pilih</option>
                                                        <option value="Cahaya"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->faktor_peringan ?? '') == 'Cahaya' ? 'selected' : '' }}>
                                                            Cahaya</option>
                                                        <option value="Gelap"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->faktor_peringan ?? '') == 'Gelap' ? 'selected' : '' }}>
                                                            Gelap</option>
                                                        <option value="Berbaring"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->faktor_peringan ?? '') == 'Berbaring' ? 'selected' : '' }}>
                                                            Berbaring</option>
                                                        <option value="Gerakan"
                                                            {{ ($asesmen->rmeAsesmenObstetriStatusNyeri->faktor_peringan ?? '') == 'Gerakan' ? 'selected' : '' }}>
                                                            Gerakan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Main Form Section -->
                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 100px;">Efek Nyeri</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="efekNyeriDisplay"
                                                    placeholder="Pilih efek nyeri yang dirasakan" readonly>
                                                <button type="button" class="btn btn-primary" id="btnPilihEfekNyeri"
                                                    title="Pilih Efek Nyeri">
                                                    <i class="bi bi-list-check me-1"></i> Pilih
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Badges Container -->
                                        <div class="selected-items mt-2" id="efekNyeriPilihan">
                                            <!-- Will be populated by JavaScript -->
                                        </div>

                                        <!-- Hidden input to store JSON data -->
                                        <input type="hidden" name="efek_nyeri" id="efekNyeriInput"
                                            value="{{ is_array($asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri ?? null)
                                                ? json_encode($asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri)
                                                : $asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri ?? '' }}">

                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">5. Riwayat Kesehatan</h5>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Status Obstetri</label>
                                            <div class="d-flex gap-3">
                                                <input type="text" class="form-control" name="gravid"
                                                    placeholder="Gravid"
                                                    value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->gravid ?? '' }}">
                                                <input type="text" class="form-control" name="partus"
                                                    placeholder="Partus"
                                                    value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->partus ?? '' }}">
                                                <input type="text" class="form-control" name="abortus"
                                                    placeholder="Abortus"
                                                    value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->abortus ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Siklus</label>
                                            <select class="form-select" name="siklus">
                                                <option value="" selected>pilih</option>
                                                <option value="Nyeri Tumpul"
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->siklus ?? '') == 'Nyeri Tumpul' ? 'selected' : '' }}>
                                                    Nyeri Tumpul</option>
                                                <option value="Nyeri Tajam"
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->siklus ?? '') == 'Nyeri Tajam' ? 'selected' : '' }}>
                                                    Nyeri Tajam</option>
                                                <option value="Panas/ Terbakar"
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->siklus ?? '') == 'Panas/ Terbakar' ? 'selected' : '' }}>
                                                    Panas/ Terbakar</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Lama Haid</label>
                                            <input type="number" class="form-control" name="lama_haid"
                                                placeholder="Hari"
                                                value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->lama_haid ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Hari Pertama Haid
                                                Terakhir</label>
                                            <input type="date" class="form-control" name="hari_pht"
                                                value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->hari_pht ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Usia Kehamilan</label>
                                            <input type="number" class="form-control" name="usia_kehamilan"
                                                value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->usia_kehamilan ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Perkawinan</label>
                                            <div class="d-flex gap-3">
                                                <div style="flex: 1;">
                                                    <input type="number" class="form-control" name="perkawinan_kali"
                                                        placeholder="Kali"
                                                        value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->perkawinan_kali ?? '' }}">
                                                </div>
                                                <div style="flex: 1;">
                                                    <input type="number" class="form-control" name="perkawinan_usia"
                                                        placeholder="Tahun" min="1900" max="2100"
                                                        value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->perkawinan_usia ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Main Content Section for Riwayat Kehamilan Sekarang -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong class="fw-normal">
                                                    Riwayat Kehamilan Sekarang
                                                </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="hidden" name="riwayat_kehamilan_sekarang"
                                                    id="riwayatKehamilanSekarangInput"
                                                    value="{{ json_encode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang ?? []) }}">

                                                <a href="javascript:void(0)"
                                                    class="text-secondary text-decoration-none fw-bold ms-3"
                                                    id="btnRiwayatKehamilan">
                                                    <i class="bi bi-plus-square"></i> Tambah
                                                </a>
                                                <div class="bg-light p-3 border rounded">
                                                    <div style="max-height: 150px; overflow-y: auto;">
                                                        <div class="riwayat-kehamilan-list">
                                                            <!-- Data akan ditampilkan disini dalam format list sederhana -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="form-group mb-3">
                                                <label class="d-block mb-2" style="min-width: 200px;">Kebiasaan Ibu
                                                    Sewaktu
                                                    Hamil</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="kebiasaanHamilDisplay"
                                                        placeholder="Pilih kebiasaan ibu sewaktu hamil" readonly>
                                                    <button type="button" class="btn btn-primary"
                                                        id="btnPilihKebiasaanHamil" title="Pilih Kebiasaan">
                                                        <i class="bi bi-list-check me-1"></i> Pilih
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <div class="selected-items mt-2" id="kebiasaanHamilPilihan"></div>
                                                <input type="hidden" name="kebiasaan_ibu_hamil" id="kebiasaanHamilInput"
                                                    value="{{ is_array($asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil ?? null)
                                                        ? json_encode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil)
                                                        : $asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil ?? '' }}">
                                            </div>
                                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit-modal-kebiasaan-hamil')
                                        </div>


                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Penambahan BB Selama
                                                Hamil
                                                (Kg)</label>
                                            <input type="number" class="form-control" name="penambahan_bb"
                                                value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->penambahan_bb ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Kehamilan
                                                Diinginkan</label>
                                            <select class="form-select" name="kehamilan_diinginkan">
                                                <option value="" selected>pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->kehamilan_diinginkan ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->kehamilan_diinginkan ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Dukungan Sosial</label>
                                            <select class="form-select" name="dukungan_sosial">
                                                <option value="" selected>pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->dukungan_sosial ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->dukungan_sosial ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="form-group mb-3">
                                                <label class="d-block mb-2" style="min-width: 200px;">Pengambilan
                                                    Keputusan</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        id="pengambilanKeputusanDisplay"
                                                        placeholder="Pengambilan Keputusan" readonly>
                                                    <button type="button" class="btn btn-primary"
                                                        id="btnPilihPengambilanKeputusan"
                                                        title="Pilih Pengambilan Keputusan">
                                                        <i class="bi bi-list-check me-1"></i> Pilih
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <div class="selected-items mt-2" id="PengambilanKeputusanPilihan"></div>
                                                <input type="hidden" name="pengambilan_keputusan"
                                                    id="PengambilanKeputusanlInput"
                                                    value="{{ is_array($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan ?? null)
                                                        ? json_encode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan)
                                                        : $asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan ?? '' }}">
                                            </div>
                                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit-modal-pengambilan-keputusan')
                                        </div>

                                        <div class="row mt-2">
                                            <div class="form-group mb-3">
                                                <label class="d-block mb-2" style="min-width: 200px;">Pendamping</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="pendampingDisplay"
                                                        placeholder="Pendamping" readonly>
                                                    <button type="button" class="btn btn-primary"
                                                        id="btnPilihPendamping" title="Pilih Pendamping">
                                                        <i class="bi bi-list-check me-1"></i> Pilih
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3">
                                                <div class="selected-items mt-2" id="pendampingPilihan"></div>
                                                <input type="hidden" name="pendamping" id="pendampingInput"
                                                    value="{{ is_array($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping ?? null)
                                                        ? json_encode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping)
                                                        : $asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping ?? '' }}">
                                            </div>
                                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-obstetri-maternitas.edit-modal-pendamping')
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Eliminasi
                                                (Defekasi)</label>
                                            <input type="text" class="form-control" name="eliminasi"
                                                placeholder="Masukkan informasi terkait defekasi..."
                                                value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->eliminasi ?? '' }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Riwayat Rawat
                                                Inap</label>
                                            <div class="d-flex gap-3">
                                                <select class="form-select" name="riwayat_rawat_inap">
                                                    <option value=""
                                                        {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_rawat_inap ?? '') == '' ? 'selected' : '' }}>
                                                        pilih</option>
                                                    <option value="1"
                                                        {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_rawat_inap ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya, Pernah</option>
                                                    <option value="0"
                                                        {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_rawat_inap ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak Pernah</option>
                                                </select>
                                                <label class="d-block mb-2">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal_rawat"
                                                    value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->tanggal_rawat ?? '' }}"
                                                    style="flex: 1;">
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Konsumsi Obat-Obatan
                                                (Jika
                                                Ada)</label>
                                            <select class="form-select" name="konsumsi_obat">
                                                <option value=""
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->konsumsi_obat ?? '') == '' ? 'selected' : '' }}>
                                                    pilih</option>
                                                <option value="1"
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->konsumsi_obat ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->konsumsi_obat ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong class="fw-normal">
                                                    Riwayat Penyakit Keluarga
                                                </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="hidden" name="riwayat_penyakin_keluarwa"
                                                    id="riwayatPenyakinKeluarwaInput"
                                                    value="{{ is_array($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa ?? null)
                                                        ? json_encode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa)
                                                        : $asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa ?? '' }}">

                                                <a href="javascript:void(0)"
                                                    class="text-secondary text-decoration-none fw-bold ms-3"
                                                    id="btnRiwayatPenyakinKeluarwa">
                                                    <i class="bi bi-plus-square"></i> Tambah
                                                </a>
                                                <div class="bg-light p-3 border rounded">
                                                    <div style="max-height: 150px; overflow-y: auto;">
                                                        <div class="riwayat-penyakin-keluarwa-list">
                                                            <!-- Items will be inserted here -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 mt-3">
                                            <label class="d-block mb-2" style="min-width: 200px;">Pemeriksaan antenatal di
                                                tempat lain</label>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="antenatal_lain"
                                                        id="antenatal_tidak" value="0"
                                                        {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->antenatal_lain ?? '') == '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="antenatal_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="antenatal_lain"
                                                        id="antenatal_ya" value="1"
                                                        {{ ($asesmen->rmeAsesmenObstetriRiwayatKesehatan->antenatal_lain ?? '') == '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="antenatal_ya">Ya</label>
                                                </div>
                                                <input type="number" class="form-control" style="width: 120px;"
                                                    placeholder="berapa kali" name="berapa_kali"
                                                    value="{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->berapa_kali ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="d-block mb-2 text-primary" style="min-width: 200px;">Riwayat
                                                Obstetrik</label>
                                            <small class="text-muted d-block mb-2">Pilih tanda tambah untuk menambah
                                                keterangan Riwayat Obstetrik yang ada.</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="table-responsive">
                                                <a href="javascript:void(0)"
                                                    class="text-secondary text-decoration-none fw-bold ms-3"
                                                    id="btn-riwayat-obstetrik">
                                                    <i class="bi bi-plus-square"></i> Tambah
                                                </a>
                                                <!-- Hidden input to store the JSON data -->
                                                <input type="hidden" name="riwayat_obstetrik" id="riwayatObstetrikInput"
                                                    value="{{ is_array($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik ?? null)
                                                        ? json_encode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik)
                                                        : $asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik ?? '[]' }}">
                                                <table class="table table-bordered" id="tabelRiwayatObstetrik">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Keadaan Kehamilan</th>
                                                            <th>Cara Persalinan</th>
                                                            <th>Keadaan Nifas</th>
                                                            <th>Tanggal Lahir</th>
                                                            <th>Keadaan Anak</th>
                                                            <th>Tempat dan Penolong</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Data will be populated dynamically -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="section-separator" style="margin-bottom: 2rem;"
                                        id="hasil-pemeriksaan-penunjang">
                                        <h5 class="fw-semibold mb-4">6. Hasil Pemeriksaan Penunjang</h5>

                                        <div class="mt-4">
                                            @php
                                                $examTypes = [
                                                    'darah' => 'Darah',
                                                    'urine' => 'Urine',
                                                    'rontgent' => 'Rontgent',
                                                    'histopatology' => 'Histopatology',
                                                ];
                                            @endphp

                                            @foreach ($examTypes as $key => $label)
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-3 col-md-2">
                                                        <span class="text-secondary">{{ $label }}</span>
                                                    </div>
                                                    <div class="col col-md-8">
                                                        <div class="border rounded p-2 bg-white">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center flex-grow-1">
                                                                    <i class="bi bi-file-text text-primary me-2"></i>
                                                                    <div
                                                                        class="file-input-wrapper position-relative w-100">
                                                                        <input type="file" class="form-control"
                                                                            name="hasil_pemeriksaan_penunjang_{{ $key }}"
                                                                            id="{{ $key }}File"
                                                                            accept=".pdf,.jpg,.jpeg,.png"
                                                                            data-preview-container="{{ $key }}Preview">
                                                                        <div class="file-info small text-muted mt-1"
                                                                            id="{{ $key }}FileInfo">
                                                                            @php
                                                                                $file_path =
                                                                                    $asesmen->asesmenObstetri
                                                                                        ->{'hasil_pemeriksaan_penunjang_' .
                                                                                            $key} ?? null;
                                                                                $file_url = $file_path
                                                                                    ? asset('storage/' . $file_path)
                                                                                    : null;
                                                                            @endphp
                                                                            @if ($file_path)
                                                                                <span class="text-primary">File terpilih:
                                                                                    {{ basename($file_path) }}</span>
                                                                                <a href="{{ $file_url }}"
                                                                                    class="btn btn-link text-primary p-0 ms-2 view-file"
                                                                                    target="_blank" title="Lihat File">
                                                                                    <i class="bi bi-eye"></i>
                                                                                </a>
                                                                                <button type="button"
                                                                                    class="btn btn-link text-danger p-0 ms-2 clear-file"
                                                                                    data-input="{{ $key }}File">
                                                                                    <i class="bi bi-x-circle"></i>
                                                                                </button>
                                                                                <input type="hidden"
                                                                                    name="existing_hasil_pemeriksaan_penunjang_{{ $key }}"
                                                                                    value="{{ $file_path }}">
                                                                            @else
                                                                                <span>Format: PDF, JPG, PNG (Max 2MB)</span>
                                                                            @endif
                                                                        </div>
                                                                        @error('hasil_pemeriksaan_penunjang_' . $key)
                                                                            <div class="invalid-feedback d-block">
                                                                                {{ $message }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div id="{{ $key }}Preview" class="preview-container">
                                                            @php
                                                                $file_path =
                                                                    $asesmen->asesmenObstetri
                                                                        ->{'hasil_pemeriksaan_penunjang_' . $key} ??
                                                                    null;
                                                            @endphp
                                                            @if ($file_path)
                                                                @php
                                                                    $file_extension = pathinfo(
                                                                        $file_path,
                                                                        PATHINFO_EXTENSION,
                                                                    );
                                                                    $file_url = asset('storage/' . $file_path);
                                                                @endphp

                                                                @if (in_array(strtolower($file_extension), ['jpg', 'jpeg', 'png']))
                                                                    <a href="{{ $file_url }}" target="_blank"
                                                                        title="Lihat gambar dalam ukuran penuh">
                                                                        <img src="{{ $file_url }}"
                                                                            style="max-width: 100px; max-height: 100px;"
                                                                            class="mt-2 rounded">
                                                                    </a>
                                                                @elseif(strtolower($file_extension) == 'pdf')
                                                                    <a href="{{ $file_url }}" target="_blank"
                                                                        title="Buka PDF">
                                                                        <i
                                                                            class="bi bi-file-pdf text-danger fs-1 mt-2"></i>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="fw-semibold mb-4">7. Diagnosis</h5>
                                        @php
                                            // Parse existing diagnosis data from database
                                            $diagnosisBanding = !empty(
                                                $asesmen->rmeAsesmenKepOphtamology[0]->diagnosis_banding
                                            )
                                                ? json_decode(
                                                    $asesmen->rmeAsesmenKepOphtamology[0]->diagnosis_banding,
                                                    true,
                                                )
                                                : [];
                                            $diagnosisKerja = !empty(
                                                $asesmen->rmeAsesmenKepOphtamology[0]->diagnosis_kerja
                                            )
                                                ? json_decode(
                                                    $asesmen->rmeAsesmenKepOphtamology[0]->diagnosis_kerja,
                                                    true,
                                                )
                                                : [];
                                        @endphp

                                        <!-- Diagnosis Banding -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
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

                                            <div id="diagnosis-banding-list"
                                                class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Existing diagnosis will be loaded here -->
                                            </div>

                                            <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                                value="{{ json_encode($diagnosisBanding) }}">
                                        </div>

                                        <!-- Diagnosis Kerja -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan
                                                diagnosis kerja yang tidak ditemukan.</small>

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

                                            <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Existing diagnosis will be loaded here -->
                                            </div>

                                            <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                                value="{{ json_encode($diagnosisKerja) }}">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="rencana_pengobatan">
                                    <h5 class="fw-semibold mb-4">8. Rencana Penatalaksanaan dan Pengobatan</h5>
                                     <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                                placeholder="Rencana Penatalaksanaan Dan Pengobatan">{{ old('rencana_pengobatan', isset($asesmen->asesmenObstetri) ? $asesmen->asesmenObstetri->rencana_pengobatan : '') }}</textarea>
                                    </div>

                                    <div class="section-separator" id="prognosis">
                                    <h5 class="fw-semibold mb-4">9. Prognosis</h5>
                                    <select class="form-select" name="paru_prognosis">
                                                <option value="" disabled
                                                    {{ !old('paru_prognosis', isset($asesmen->asesmenObstetri) ? $asesmen->asesmenObstetri->paru_prognosis : '')
                                                        ? 'selected'
                                                        : '' }}>
                                                    --Pilih Prognosis--</option>
                                                @forelse ($satsetPrognosis as $item)
                                                    <option value="{{ $item->prognosis_id }}"
                                                        {{ old('paru_prognosis', isset($asesmen->asesmenObstetri) ? $asesmen->asesmenObstetri->paru_prognosis : '') ==
                                                        $item->prognosis_id
                                                            ? 'selected'
                                                            : '' }}>
                                                        {{ $item->value ?? 'Field tidak ditemukan' }}
                                                    </option>
                                                @empty
                                                    <option value="" disabled>Tidak ada data</option>
                                                @endforelse
                                            </select>
                                    </div>

                                    <div class="section-separator" style="margin-bottom: 2rem;">
                                        <h5 class="fw-semibold mb-4">10. Discharge Planning</h5>
                                        {{-- <div class="mb-3 row align-items-center">
                                            <label class="col-md-3 text-secondary">Diagnosis medis</label>
                                            <div class="col-md-9">
                                                <select class="form-select bg-light" id="diagnosisMedis"
                                                    name="dp_diagnosis_medis">
                                                    <option value="">Lokalis nyeri</option>
                                                    <option value="Penyakit jantung"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_diagnosis_medis ?? '') == 'Penyakit jantung'
                                                            ? 'selected'
                                                            : '' }}>
                                                        Penyakit jantung
                                                    </option>
                                                    <option value="Penyakit paru"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_diagnosis_medis ?? '') == 'Penyakit paru'
                                                            ? 'selected'
                                                            : '' }}>
                                                        Penyakit paru
                                                    </option>
                                                    <option value="Lainnya"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_diagnosis_medis ?? '') == 'Lainnya' ? 'selected' : '' }}>
                                                        Lainnya</option>
                                                </select>
                                            </div>
                                        </div> --}}

                                        <div class="mb-3 row align-items-center">
                                            <label class="col-md-3 text-secondary">Usia lanjut</label>
                                            <div class="col-md-9">
                                                <select class="form-select bg-light risk-factor" id="usiaLanjut"
                                                    name="dp_usia_lanjut">
                                                    <option value="">--pilih--</option>
                                                    <option value="1"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_usia_lanjut ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_usia_lanjut ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row align-items-center">
                                            <label class="col-md-3 text-secondary">Hambatan mobilisasi</label>
                                            <div class="col-md-9">
                                                <select class="form-select bg-light risk-factor" id="hambatanMobilisasi"
                                                    name="dp_hambatan_mobilisasi">
                                                    <option value="">--pilih--</option>
                                                    <option value="1"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_hambatan_mobilisasi ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_hambatan_mobilisasi ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row align-items-center">
                                            <label class="col-md-3 text-secondary">Membutuhkan pelayanan medis
                                                berkelanjutan</label>
                                            <div class="col-md-9">
                                                <select class="form-select bg-light risk-factor"
                                                    id="layananMedisLanjutan" name="dp_layanan_medis_lanjutan">
                                                    <option value="">--pilih--</option>
                                                    <option value="1"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_layanan_medis_lanjutan ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_layanan_medis_lanjutan ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row align-items-center">
                                            <label class="col-md-3 text-secondary">Ketergantungan dengan orang lain dalam
                                                aktivitas harian</label>
                                            <div class="col-md-9">
                                                <select class="form-select bg-light risk-factor" id="ketergantungan"
                                                    name="dp_tergantung_orang_lain">
                                                    <option value="">--pilih--</option>
                                                    <option value="1"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_tergantung_orang_lain ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0"
                                                        {{ ($asesmen->rmeAsesmenObstetriDischargePlanning->dp_tergantung_orang_lain ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-4 row align-items-center">
                                            <label class="col-md-3 text-secondary">Perkiraan lama hari dirawat</label>
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <input type="number" id="lamaDirawat" name="dp_lama_dirawat"
                                                        class="form-control bg-light" placeholder="Hari"
                                                        min="1"
                                                        value="{{ $asesmen->rmeAsesmenObstetriDischargePlanning->dp_lama_dirawat ?? '' }}">
                                                    <span class="input-group-text bg-light">Hari</span>
                                                </div>
                                            </div>
                                            <label class="col-md-2 text-secondary text-end">Rencana Pulang</label>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" id="rencanaPulang" name="dp_rencana_pulang"
                                                        class="form-control bg-light"
                                                        value="{{ isset($asesmen->rmeAsesmenObstetriDischargePlanning->dp_rencana_pulang)
                                                            ? \Carbon\Carbon::parse($asesmen->rmeAsesmenObstetriDischargePlanning->dp_rencana_pulang)->format('d M Y')
                                                            : \Carbon\Carbon::now()->addDays(7)->format('d M Y') }}">
                                                    <span class="input-group-text bg-light date-picker-toggle"
                                                        id="datePickerToggle">
                                                        <i class="bi bi-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-2" id="conclusionContainer">
                                            @php
                                                $currentConclusion =
                                                    $asesmen->rmeAsesmenObstetriDischargePlanning->dp_kesimpulan ?? '';
                                            @endphp
                                            <div class="alert alert-warning mb-2" id="needSpecialPlanAlert"
                                                style="background-color: #fff3cd; display: {{ $currentConclusion == 'Membutuhkan rencana pulang khusus' ? 'block' : 'none' }};">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="dp_kesimpulan" id="need_special"
                                                        value="Membutuhkan rencana pulang khusus"
                                                        {{ $currentConclusion == 'Membutuhkan rencana pulang khusus' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="need_special">
                                                        Membutuhkan rencana pulang khusus
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="alert alert-success mb-2" id="noSpecialPlanAlert"
                                                style="background-color: #d1e7dd; display: {{ $currentConclusion == 'Tidak membutuhkan rencana pulang khusus' ? 'block' : 'none' }};">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="dp_kesimpulan" id="no_special"
                                                        value="Tidak membutuhkan rencana pulang khusus"
                                                        {{ $currentConclusion == 'Tidak membutuhkan rencana pulang khusus' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="no_special">
                                                        Tidak membutuhkan rencana pulang khusus
                                                    </label>
                                                </div>
                                            </div>
                                            <input type="hidden" id="dp_kesimpulan_hidden" name="dp_kesimpulan"
                                                value="{{ $currentConclusion }}">
                                        </div>

                                        <div id="conclusionSection" class="mt-4 p-3 border rounded"
                                            style="display: {{ $currentConclusion ? 'block' : 'none' }};">
                                            <h6 class="fw-bold">Kesimpulan:</h6>
                                            <p id="conclusionText" class="mb-0">{{ $currentConclusion }}</p>
                                        </div>
                                    </div>

                                    {{-- @php
                                        // Parse existing diagnosis data from database
                                        $diagnosisBanding = !empty(
                                            $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_banding
                                        )
                                            ? json_decode(
                                                $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_banding,
                                                true,
                                            )
                                            : [];
                                        $diagnosisKerja = !empty(
                                            $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_kerja
                                        )
                                            ? json_decode(
                                                $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_kerja,
                                                true,
                                            )
                                            : [];
                                    @endphp

                                    <!-- Diagnosis Banding -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            diagnosis banding,
                                            apabila tidak ada, Pilih tanda tambah untuk menambah keterangan diagnosis
                                            banding yang tidak ditemukan.</small>

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

                                        <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                            <!-- Existing diagnosis will be loaded here -->
                                        </div>

                                        <!-- Hidden input for form submission -->
                                        <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                            value="{{ json_encode($diagnosisBanding) }}">
                                    </div>

                                    <!-- Diagnosis Kerja -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            diagnosis kerja,
                                            apabila tidak ada, Pilih tanda tambah untuk menambah keterangan diagnosis
                                            kerja yang tidak ditemukan.</small>

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

                                        <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                            <!-- Existing diagnosis will be loaded here -->
                                        </div>

                                        <!-- Hidden input for form submission -->
                                        <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                            value="{{ json_encode($diagnosisKerja) }}">
                                    </div> --}}
                                </div>

                                {{-- <div class="section-separator" style="margin-bottom: 2rem;">
                                    <h5 class="fw-semibold mb-4">10. Evaluasi</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tambah Evaluasi Keperawatan</label>
                                        <textarea class="form-control" name="evaluasi_evaluasi" rows="4"
                                            placeholder="Evaluasi Keperawaran">{{ $asesmen->asesmenObstetri->evaluasi_evaluasi ?? '' }}</textarea>
                                    </div> --}}
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>

                        </div>
                    </div>
                </div>
        </div>
    </div>
    </form>
    </div>
    </div>
@endsection
