@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-neonatologi.edit-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-asesmen-tht')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Edit Asesmen Pengkajian Awal Medis Neonatologi Bayi Sakit',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])
            <form method="POST" enctype="multipart/form-data"
                action="{{ route('rawat-inap.asesmen.medis.medis-neonatologi.update', [
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

                <div class="section-separator mt-0" id="data-masuk">
                    <h5 class="section-title">1. Data masuk</h5>

                    <div class="form-group">
                        <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                        <div class="d-flex gap-3" style="width: 100%;">
                            <input type="date" class="form-control" name="tanggal"
                                value="{{ $asesmen->asesmenMedisNeonatologi->tanggal ? $asesmen->asesmenMedisNeonatologi->tanggal->format('Y-m-d') : date('Y-m-d') }}">
                            <input type="time" class="form-control" name="jam"
                                value="{{ $asesmen->asesmenMedisNeonatologi->jam ? date('H:i', strtotime($asesmen->asesmenMedisNeonatologi->jam)) : date('H:i') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="min-width: 200px;">Nama keluarga yang bisa </br> dihubungi No Hp/
                            Telp</label>
                        <div class="d-flex gap-3" style="width: 100%;">
                            <input type="number" class="form-control" name="no_hp"
                                value="{{ $asesmen->asesmenMedisNeonatologi->no_hp }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label style="min-width: 200px; vertical-align: top;">Transportasi waktu
                                    datang:</label>
                                <div class="mt-2">
                                    @php
                                        $transportasi = is_array(
                                            $asesmen->asesmenMedisNeonatologi->transportasi,
                                        )
                                            ? $asesmen->asesmenMedisNeonatologi->transportasi
                                            : [];
                                    @endphp
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="transportasi[]"
                                            id="kendaraan_pribadi" value="kendaraan_pribadi"
                                            {{ in_array('kendaraan_pribadi', $transportasi) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kendaraan_pribadi">
                                            Kendaraan pribadi
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="transportasi[]"
                                            id="ambulance" value="ambulance"
                                            {{ in_array('ambulance', $transportasi) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ambulance">
                                            Ambulance
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="transportasi[]"
                                            id="kendaraan_lainnya" value="kendaraan_lainnya"
                                            {{ in_array('kendaraan_lainnya', $transportasi) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kendaraan_lainnya">
                                            Kendaraan lainnya:
                                        </label>
                                        <input type="text" class="form-control mt-2"
                                            name="kendaraan_lainnya_detail"
                                            value="{{ $asesmen->asesmenMedisNeonatologi->kendaraan_lainnya_detail }}"
                                            placeholder="Sebutkan lainnya">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="alergi">
                    <h5 class="section-title">2. Alergi</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openAlergiModal"
                        data-bs-toggle="modal" data-bs-target="#alergiModal">
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
                                    <td colspan="5" class="text-center text-muted">Tidak ada data alergi
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @push('modals')
                        @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-medis-neonatologi.modal-create-alergi')
                    @endpush
                </div>

                <div class="section-separator" id="">
                    <h5 class="section-title">3. Anamnesis</h5>

                    <div class="form-group">
                        <label style="min-width: 200px;">Anamnesis</label>
                        <textarea class="form-control" name="anamnesis" rows="3" placeholder="Anamnesis">{{ $asesmen->asesmenMedisNeonatologi->anamnesis }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">

                                <label style="min-width: 200px; vertical-align: top;">Lahir:</label>
                                <div class="mt-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="lahir"
                                            id="lahir_rsudlangsa" value="1"
                                            {{ $asesmen->asesmenMedisNeonatologi->lahir == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="lahir_rsudlangsa">
                                            Lahir di RSU Langsa
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="lahir"
                                            id="lahir_rs_lain" value="0"
                                            {{ $asesmen->asesmenMedisNeonatologi->lahir == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="lahir_rs_lain">
                                            Luar RSU Langsa:
                                        </label>
                                    </div>
                                    <input type="text" class="form-control mt-2" name="lahir_rs_lain"
                                        value="{{ $asesmen->asesmenMedisNeonatologi->lahir_rs_lain ?? '' }}"
                                        placeholder="Sebutkan lainnya">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="min-width: 200px;">Keluhan Bayi</label>
                        <textarea class="form-control" name="keluahan_bayi" rows="3" placeholder="Keluhan Bayi">{{ $asesmen->asesmenMedisNeonatologi->keluahan_bayi }}</textarea>
                    </div>

                </div>

                <div class="section-separator" id="riwayat-antenatal">
                    <h5 class="section-title">4. Riwayat Antenatal</h5>

                    <div class="container-fluid">
                        <!-- Anak ke -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Anak ke:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="anak_ke" min="1"
                                    placeholder="1" value="{{ $asesmen->asesmenMedisNeonatologi->anak_ke }}">
                            </div>
                        </div>

                        <!-- ANC -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">ANC:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anc"
                                        id="anc_tidak" value="0"
                                        {{ $asesmen->asesmenMedisNeonatologi->anc == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="anc_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anc"
                                        id="anc_ya" value="1"
                                        {{ $asesmen->asesmenMedisNeonatologi->anc == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="anc_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- USG -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">USG:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="usg_kali"
                                    placeholder="Berapa kali"
                                    value="{{ $asesmen->asesmenMedisNeonatologi->usg_kali }}">
                            </div>
                        </div>

                        <!-- HPHT -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">HPHT:</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="hpht_tanggal"
                                    value="{{ $asesmen->asesmenMedisNeonatologi->hpht_tanggal ? $asesmen->asesmenMedisNeonatologi->hpht_tanggal->format('Y-m-d') : date('Y-m-d') }}">
                            </div>
                        </div>

                        <!-- Taksiran persalinan -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Taksiran persalinan:</label>
                            </div>
                            <div class="col-md-4">
                                <input type="date" class="form-control" name="taksiran_tanggal"
                                    value="{{ $asesmen->asesmenMedisNeonatologi->taksiran_tanggal ? $asesmen->asesmenMedisNeonatologi->taksiran_tanggal->format('Y-m-d') : date('Y-m-d') }}">
                            </div>
                        </div>

                        <!-- Nyeri BAK -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Nyeri BAK:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="nyeri_bak"
                                        id="nyeri_bak_tidak" value="0"
                                        {{ $asesmen->asesmenMedisNeonatologi->nyeri_bak == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="nyeri_bak_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="nyeri_bak"
                                        id="nyeri_bak_ya" value="1"
                                        {{ $asesmen->asesmenMedisNeonatologi->nyeri_bak == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="nyeri_bak_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Keputihan -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Keputihan:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="keputihan"
                                        id="keputihan_tidak" value="0"
                                        {{ $asesmen->asesmenMedisNeonatologi->keputihan == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="keputihan_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="keputihan"
                                        id="keputihan_ya" value="1"
                                        {{ $asesmen->asesmenMedisNeonatologi->keputihan == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="keputihan_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Header Riwayat Intranatal -->
                        <div class="row mb-3 mt-4">
                            <div class="col-12">
                                <h6 class="text-center bg-secondary text-white p-2 mb-0">Riwayat Intranatal
                                </h6>
                            </div>
                        </div>

                        <!-- Perdarahan -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Perdarahan:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="perdarahan"
                                        id="perdarahan_tidak" value="0"
                                        {{ $asesmen->asesmenMedisNeonatologi->perdarahan == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perdarahan_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="perdarahan"
                                        id="perdarahan_ya" value="1"
                                        {{ $asesmen->asesmenMedisNeonatologi->perdarahan == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perdarahan_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Ketuban pecah -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Ketuban pecah:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ketuban_pecah"
                                        id="ketuban_tidak" value="0"
                                        {{ $asesmen->asesmenMedisNeonatologi->ketuban_pecah == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ketuban_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ketuban_pecah"
                                        id="ketuban_ya" value="1"
                                        {{ $asesmen->asesmenMedisNeonatologi->ketuban_pecah == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ketuban_ya">Ya</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input type="time" class="form-control" name="ketuban_jam"
                                    placeholder="Jam"
                                    value="{{ $asesmen->asesmenMedisNeonatologi->ketuban_jam ? date('H:i', strtotime($asesmen->asesmenMedisNeonatologi->ketuban_jam)) : '' }}">
                            </div>
                        </div>

                        <!-- Gawat janin -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Gawat janin:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gawat_janin"
                                        id="gawat_janin_tidak" value="0"
                                        {{ $asesmen->asesmenMedisNeonatologi->gawat_janin == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gawat_janin_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gawat_janin"
                                        id="gawat_janin_ya" value="1"
                                        {{ $asesmen->asesmenMedisNeonatologi->gawat_janin == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gawat_janin_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Demam -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Demam:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="demam"
                                        id="demam_tidak" value="0"
                                        {{ $asesmen->asesmenMedisNeonatologi->demam == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="demam_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="demam"
                                        id="demam_ya" value="1"
                                        {{ $asesmen->asesmenMedisNeonatologi->demam == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="demam_ya">Ya</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="demam_suhu"
                                        step="0.1" min="35" max="45" placeholder="36.5"
                                        value="{{ $asesmen->asesmenMedisNeonatologi->demam_suhu }}">
                                    <span class="input-group-text">°C</span>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat terapi deksametason -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Riwayat terapi deksametason:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="terapi_deksametason"
                                        id="deksametason_tidak" value="0"
                                        {{ $asesmen->asesmenMedisNeonatologi->terapi_deksametason == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="deksametason_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="terapi_deksametason"
                                        id="deksametason_ya" value="1"
                                        {{ $asesmen->asesmenMedisNeonatologi->terapi_deksametason == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="deksametason_ya">Ya</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="deksametason_kali"
                                        min="0" placeholder="0"
                                        value="{{ $asesmen->asesmenMedisNeonatologi->deksametason_kali }}">
                                    <span class="input-group-text">kali</span>
                                </div>
                            </div>
                        </div>

                        <!-- Riwayat terapi lain -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Riwayat terapi lain:</label>
                            </div>
                            <div class="col-md-8">
                                <textarea class="form-control" name="terapi_lain" rows="3"
                                    placeholder="Sebutkan riwayat terapi lainnya jika ada...">{{ $asesmen->asesmenMedisNeonatologi->terapi_lain }}</textarea>
                            </div>
                        </div>

                        <!-- Header Riwayat Penyakit Ibu -->
                        <div class="row mb-3 mt-4">
                            <div class="col-12">
                                <h6 class="text-center bg-secondary text-white p-2 mb-0">Riwayat Penyakit Ibu
                                </h6>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            @php
                                $riwayatPenyakitIbu = is_array(
                                    $asesmen->asesmenMedisNeonatologi->riwayat_penyakit_ibu,
                                )
                                    ? $asesmen->asesmenMedisNeonatologi->riwayat_penyakit_ibu
                                    : [];
                            @endphp
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_dm"
                                        value="dm"
                                        {{ in_array('dm', $riwayatPenyakitIbu) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="riwayat_penyakit_ibu_dm">DM</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_hepatitis"
                                        value="hepatitisb"
                                        {{ in_array('hepatitisb', $riwayatPenyakitIbu) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_hepatitis">Hepatitis B</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_ekimosis"
                                        value="ekimosis"
                                        {{ in_array('ekimosis', $riwayatPenyakitIbu) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_ekimosis">Ekimosis</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_tb"
                                        value="tb"
                                        {{ in_array('tb', $riwayatPenyakitIbu) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="riwayat_penyakit_ibu_tb">TB</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_hypertensi"
                                        value="hypertensi"
                                        {{ in_array('hypertensi', $riwayatPenyakitIbu) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_hypertensi">Hypertensi</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_hiv"
                                        value="hiv_aids"
                                        {{ in_array('hiv_aids', $riwayatPenyakitIbu) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_hiv">HIV/AIDS</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_jantung"
                                        value="jantung"
                                        {{ in_array('jantung', $riwayatPenyakitIbu) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_jantung">Jantung</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="riwayat_penyakit_ibu[]" id="riwayat_penyakit_ibu_asthma"
                                        value="asthma"
                                        {{ in_array('asthma', $riwayatPenyakitIbu) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="riwayat_penyakit_ibu_asthma">Asthma</label>
                                </div>
                            </div>
                            <label class="form-check-label mt-2"
                                for="riwayat_penyakit_ibu_lain">Lainnya</label>
                            <input type="text" class="form-control" name="riwayat_penyakit_ibu_lain"
                                id="riwayat_penyakit_ibu_lain" placeholder="Lainnya"
                                value="{{ $asesmen->asesmenMedisNeonatologi->riwayat_penyakit_ibu_lain ?? '' }}">
                        </div>

                    </div>
                </div>

                <div class="section-separator" id="pemeriksaan-fisik">
                    <h5 class="section-title">5. Pemeriksaan Fisik</h5>
                    <h6>ST. PRESENT</h6>

                    <div class="container-fluid">
                        <!-- Postur tubuh -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Postur tubuh:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="postur_tubuh"
                                    placeholder="Jelaskan postur tubuh pasien"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->postur_tubuh ?? '' }}">
                            </div>
                        </div>

                        <!-- Tangis -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Tangis:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="tangis"
                                    placeholder="Jelaskan kondisi tangisan"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->tangis ?? '' }}">
                            </div>
                        </div>

                        <!-- Anemia -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Anemia:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anemia"
                                        id="anemia_tidak" value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->anemia ?? '') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="anemia_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="anemia"
                                        id="anemia_ya" value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->anemia ?? '') === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="anemia_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Dispnoe -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Dispnoe:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dispnoe"
                                        id="dispnoe_tidak" value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->dispnoe ?? '') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dispnoe_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="dispnoe"
                                        id="dispnoe_ya" value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->dispnoe ?? '') === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dispnoe_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Edema -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Edema:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edema"
                                        id="edema_tidak" value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->edema ?? '') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edema_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="edema"
                                        id="edema_ya" value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->edema ?? '') === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="edema_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Ikterik -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Ikterik:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ikterik"
                                        id="ikterik_tidak" value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->ikterik ?? '') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ikterik_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ikterik"
                                        id="ikterik_ya" value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->ikterik ?? '') === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ikterik_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Sianosis -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Sianosis:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sianosis"
                                        id="sianosis_tidak" value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->sianosis ?? '') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sianosis_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sianosis"
                                        id="sianosis_ya" value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->sianosis ?? '') === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sianosis_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Denyut jantung -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Denyut jantung:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="denyut_jantung"
                                        min="0" max="300"
                                        value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->denyut_jantung ?? '' }}"
                                        placeholder="0">
                                    <span class="input-group-text">x/mnt</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nadi -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Nadi:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="nadi" min="0"
                                        max="300"
                                        value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->nadi ?? '' }}"
                                        placeholder="0">
                                    <span class="input-group-text">x/mnt</span>
                                </div>
                            </div>
                        </div>

                        <!-- Respirasi -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Respirasi:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="respirasi"
                                        value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->respirasi ?? '' }}"
                                        placeholder="0">
                                    <span class="input-group-text">x/mnt</span>
                                </div>
                            </div>
                        </div>

                        <!-- SpO -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">SpO:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="spo"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->spo ?? '' }}"
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Merintih -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Merintih:</label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="merintih"
                                        id="merintih_tidak" value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->merintih ?? '') === '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="merintih_tidak">Tidak</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="merintih"
                                        id="merintih_ya" value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->merintih ?? '') === '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="merintih_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- Temperatur -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Temperatur:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="temperatur"
                                        value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->temperatur ?? '' }}"
                                        placeholder="36.5">
                                    <span class="input-group-text">°C</span>
                                </div>
                            </div>
                        </div>

                        <!-- BBL/PBL -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">BBL/PBL:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="bbl_pbl"
                                    placeholder="Berat badan lahir / Panjang badan lahir"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->bbl_pbl ?? '' }}">
                            </div>
                        </div>

                        <!-- LK/LD -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">LK/LD:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="lk_ld"
                                    placeholder="Lingkar kepala / Lingkar dada"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->lk_ld ?? '' }}">
                            </div>
                        </div>

                        <!-- BB sekarang -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">BB sekarang:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="bb_sekarang"
                                        step="0.01" min="0"
                                        value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->bb_sekarang ?? '' }}"
                                        placeholder="0.00">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                        </div>

                        <!-- PB sekarang -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">PB sekarang:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="pb_sekarang"
                                        step="0.1" min="0"
                                        value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->pb_sekarang ?? '' }}"
                                        placeholder="0.0">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </div>

                        <!-- LK sekarang -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">LK sekarang:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="lk_sekarang"
                                        step="0.1" min="0"
                                        value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->lk_sekarang ?? '' }}"
                                        placeholder="0.0">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bollard score -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Bollard score:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="number" class="form-control" name="bollard_score"
                                    min="0"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->bollard_score ?? '' }}"
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Skor nyeri -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Skor nyeri:</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="skor_nyeri"
                                        id="skor_nyeri_5" value="<5"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->skor_nyeri ?? '') === '<5' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="skor_nyeri_5">
                                        < 5</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="skor_nyeri"
                                        id="skor_nyeri_5_9" value="5-9"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->skor_nyeri ?? '') === '5-9' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="skor_nyeri_5_9">5-9</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="skor_nyeri"
                                        id="skor_nyeri_10" value=">=10"
                                        {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->skor_nyeri ?? '') === '>=10' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="skor_nyeri_10">>= 10</label>
                                </div>
                            </div>
                        </div>

                        <!-- Down score -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Down score:</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="down_score"
                                    placeholder="Masukkan down score"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->down_score ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Status Generalis -->
                <div class="section-separator" id="pemeriksaan-fisik">
                    <h5 class="section-title">6. Status Generalis</h5>
                    <div class="card-body">
                        <!-- 1. Kepala -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">1. KEPALA</h6>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">a. Bentuk:</label>
                                <input type="text" class="form-control" name="kepala_bentuk"
                                    placeholder="Normal/Abnormal"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->kepala_bentuk ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">b. UUB:</label>
                                <input type="text" class="form-control" name="kepala_uub"
                                    placeholder="Datar/Cembung/Cekung"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->kepala_uub ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">c. UUK:</label>
                                <input type="text" class="form-control" name="kepala_uuk"
                                    placeholder="Terbuka/Tertutup"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->kepala_uuk ?? '' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">d. Caput sucedaneum:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="caput_sucedaneum" id="caput_tidak" value="0"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->caput_sucedaneum ?? '') === '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="caput_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="caput_sucedaneum" id="caput_ya" value="1"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->caput_sucedaneum ?? '') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="caput_ya">Ya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">e. Cephalohematom:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cephalohematom"
                                            id="cepha_tidak" value="0"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->cephalohematom ?? '') === '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cepha_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="cephalohematom"
                                            id="cepha_ya" value="1"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->cephalohematom ?? '') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cepha_ya">Ya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Ø:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="kepala_lp"
                                        step="0.1"
                                        value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->kepala_lp ?? '' }}"
                                        placeholder="0">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">f. Lainnya:</label>
                                <input type="text" class="form-control" name="kepala_lain"
                                    placeholder="Isi keterangan lainnya"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->kepala_lain ?? '' }}">
                            </div>
                        </div>

                        <hr>

                        <!-- 2. Mata -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">2. MATA</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="mata_pucat"
                                            id="mata_pucat" value="1"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->mata_pucat ?? '') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mata_pucat">Pucat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="mata_ikterik"
                                            id="mata_ikterik" value="1"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->mata_ikterik ?? '') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mata_ikterik">Ikterik</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pupil:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pupil"
                                            id="pupil_isokor" value="isokor"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->pupil ?? '') === 'isokor' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pupil_isokor">Isokor</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pupil"
                                            id="pupil_anisokor" value="anisokor"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->pupil ?? '') === 'anisokor' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pupil_anisokor">Anisokor</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Refleks Cahaya:</label>
                                <input type="text" class="form-control" name="refleks_cahaya"
                                    placeholder="( ... / ... )"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->refleks_cahaya ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Refleks Kornea:</label>
                                <input type="text" class="form-control" name="refleks_kornea"
                                    placeholder="( ... / ... )"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->refleks_kornea ?? '' }}">
                            </div>
                        </div>

                        <hr>

                        <!-- 3. Hidung -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">3. HIDUNG</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nafas cuping hidung:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nafas_cuping"
                                            id="nafas_cuping_ya" value="1"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->nafas_cuping ?? '') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nafas_cuping_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="nafas_cuping"
                                            id="nafas_cuping_tidak" value="0"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->nafas_cuping ?? '') === '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nafas_cuping_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lain-lain:</label>
                                <input type="text" class="form-control" name="hidung_lain"
                                    placeholder="Lainnya"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->hidung_lain ?? '' }}">
                            </div>
                        </div>

                        <hr>

                        <!-- 4. Telinga -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">4. TELINGA</h6>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="text" class="form-control" name="telinga_keterangan"
                                    placeholder="Masukkan keterangan telinga"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->telinga_keterangan ?? '' }}">
                            </div>
                        </div>

                        <hr>

                        <!-- 5. Mulut -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">5. MULUT</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bibir/lidah sianosis:</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mulut_sianosis"
                                            id="mulut_sianosis_ya" value="1"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->mulut_sianosis ?? '') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mulut_sianosis_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="mulut_sianosis"
                                            id="mulut_sianosis_tidak" value="0"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->mulut_sianosis ?? '') === '0' ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="mulut_sianosis_tidak">Tidak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lidah:</label>
                                <input type="text" class="form-control" name="mulut_lidah"
                                    placeholder="Isi keterangan lidah"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->mulut_lidah ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tenggorokan:</label>
                                <input type="text" class="form-control" name="mulut_tenggorokan"
                                    placeholder="Isi keterangan tenggorokan"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->mulut_tenggorokan ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lain-lain:</label>
                                <input type="text" class="form-control" name="mulut_lain"
                                    placeholder="Isi keterangan lain-lain mulut"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->mulut_lain ?? '' }}">
                            </div>
                        </div>

                        <hr>

                        <!-- 6. Leher -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">6. LEHER</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">KGB:</label>
                                <input type="text" class="form-control" name="leher_kgb"
                                    placeholder="Keterangan KGB"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->leher_kgb ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">TVJ:</label>
                                <input type="text" class="form-control" name="leher_tvj"
                                    placeholder="Keterangan TVJ"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->leher_tvj ?? '' }}">
                            </div>
                        </div>

                        <hr>

                        <!-- 7. Thoraks -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">7. THORAKS</h6>
                            </div>
                            <div class="col-md-6 mb-3">
                                @php
                                    $thoraksBentuk = is_array(
                                        $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_bentuk ??
                                            [],
                                    )
                                        ? $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_bentuk
                                        : [];
                                @endphp
                                <label class="form-label">a. Bentuk:</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="thoraks_bentuk[]" id="thoraks_simetris" value="simetris"
                                            {{ in_array('simetris', $thoraksBentuk) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="thoraks_simetris">Simetris</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="thoraks_bentuk[]" id="thoraks_asimetris"
                                            value="asimetris"
                                            {{ in_array('asimetris', $thoraksBentuk) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="thoraks_asimetris">Asimetris</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Areola mamae ∅:</label>
                                <input type="text" class="form-control" name="thoraks_areola_mamae"
                                    placeholder="Diameter areola"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_areola_mamae ?? '' }}">
                            </div>
                            <label class="form-label fw-bold">b. Jantung:</label><br>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small">HR:</label>
                                <input type="text" class="form-control" name="thoraks_hr"
                                    placeholder="Heart Rate"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_hr ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Murmur:</label>
                                <input type="text" class="form-control" name="thoraks_murmur"
                                    placeholder="Ada/Tidak"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_murmur ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bunyi jantung:</label>
                                <input type="text" class="form-control" name="thoraks_bunyi_jantung"
                                    placeholder="Normal/Abnormal"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_bunyi_jantung ?? '' }}">
                            </div>
                            <label class="form-label fw-bold">c. Paru:</label><br>
                            <div class="col-md-4 mb-3">
                                <label class="form-label small">Retraksi:</label>
                                <input type="text" class="form-control" name="thoraks_retraksi"
                                    placeholder="Ada/Tidak"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_retraksi ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Merintih:</label>
                                <input type="text" class="form-control" name="thoraks_merintih"
                                    placeholder="Ada/Tidak"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_merintih ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">RR:</label>
                                <input type="text" class="form-control" name="thoraks_rr"
                                    placeholder="Respiratory Rate"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_rr ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Suara pernafasan:</label>
                                <input type="text" class="form-control" name="thoraks_suara_nafas"
                                    placeholder="Vesikuler/Bronkial"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_suara_nafas ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Suara nafas tambahan:</label>
                                <input type="text" class="form-control" name="thoraks_suara_tambahan"
                                    placeholder="Ronki/Wheezing"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->thoraks_suara_tambahan ?? '' }}">
                            </div>
                        </div>

                        <hr>

                        <!-- 8. Abdomen -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">8. ABDOMEN</h6>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">a. Distensi:</label>
                                <input type="text" class="form-control" name="abdomen_distensi"
                                    placeholder="Ada/Tidak"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_distensi ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">b. Bising usus:</label>
                                <input type="text" class="form-control" name="abdomen_bising_usus"
                                    placeholder="Normal/Hiperaktif"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_bising_usus ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">c. Venektasi:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="abdomen_venektasi" id="abdomen_venektasi_tidak"
                                            value="0"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_venektasi ?? '') === '0' ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="abdomen_venektasi_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="abdomen_venektasi" id="abdomen_venektasi_ya"
                                            value="1"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_venektasi ?? '') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="abdomen_venektasi_ya">Ya</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">d. Hepar:</label>
                                <input type="text" class="form-control" name="abdomen_hepar"
                                    placeholder="Teraba/Tidak teraba"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_hepar ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lien:</label>
                                <input type="text" class="form-control" name="abdomen_lien"
                                    placeholder="Teraba/Tidak teraba"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_lien ?? '' }}">
                            </div>
                            <!-- e. Tali pusat -->
                            <div class="col-12 mb-3">
                                <label class="form-label">e. Tali pusat:</label>
                                @php
                                    $taliPusat = is_array(
                                        $asesmen->asesmenMedisNeonatologiFisikGeneralis
                                            ->abdomen_tali_pusat ?? [],
                                    )
                                        ? $asesmen->asesmenMedisNeonatologiFisikGeneralis
                                            ->abdomen_tali_pusat
                                        : [];
                                @endphp
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_segar"
                                                value="segar"
                                                {{ in_array('segar', $taliPusat) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="abdomen_segar">Segar</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_layu"
                                                value="layu"
                                                {{ in_array('layu', $taliPusat) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="abdomen_layu">Layu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_bau"
                                                value="bau"
                                                {{ in_array('bau', $taliPusat) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="abdomen_bau">Bau</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_kering"
                                                value="kering"
                                                {{ in_array('kering', $taliPusat) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="abdomen_kering">Kering</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="abdomen_tali_pusat[]" id="abdomen_basah"
                                                value="basah"
                                                {{ in_array('basah', $taliPusat) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="abdomen_basah">Basah</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Arteri dan Vena -->
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Arteri:</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="abdomen_arteri" id="abdomen_arteri_1"
                                                    value="1"
                                                    {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_arteri ?? '') === '1' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="abdomen_arteri_1">1</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="abdomen_arteri" id="abdomen_arteri_2"
                                                    value="2"
                                                    {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_arteri ?? '') === '2' ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="abdomen_arteri_2">2</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Vena:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="abdomen_vena" id="abdomen_vena_1" value="1"
                                                {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_vena ?? '') === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="abdomen_vena_1">1</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Kelainan:</label>
                                        <input type="text" class="form-control" name="abdomen_kelainan"
                                            placeholder="Kelainan"
                                            value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->abdomen_kelainan ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- 9. Genetalia -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">9. GENETALIA</h6>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="genetalia"
                                            id="genetalia_laki" value="laki-laki"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->genetalia ?? '') === 'laki-laki' ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="genetalia_laki">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="genetalia"
                                            id="genetalia_perempuan" value="perempuan"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->genetalia ?? '') === 'perempuan' ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="genetalia_perempuan">Perempuan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="genetalia"
                                            id="genetalia_ambigus" value="ambigus"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->genetalia ?? '') === 'ambigus' ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="genetalia_ambigus">Ambigus</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- 10. Anus -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">10. ANUS</h6>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="text" class="form-control" name="anus_keterangan"
                                    placeholder="Normal/Atresia/Stenosis"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->anus_keterangan ?? '' }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mekonium:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="anus_mekonium" id="anus_mekonium_tidak" value="0"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->anus_mekonium ?? '') === '0' ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="anus_mekonium_tidak">Tidak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="anus_mekonium" id="anus_mekonium_ya" value="1"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->anus_mekonium ?? '') === '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="anus_mekonium_ya">Ya</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- 11. Ekstremitas -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">11. EKSTREMITAS</h6>
                            </div>
                            <!-- Plantar Creases -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Plantar Creases:</label>
                                @php
                                    $plantarCreases = is_array(
                                        $asesmen->asesmenMedisNeonatologiFisikGeneralis->plantar_creases ??
                                            [],
                                    )
                                        ? $asesmen->asesmenMedisNeonatologiFisikGeneralis->plantar_creases
                                        : [];
                                @endphp
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="plantar_creases[]" id="plantar_1_3_anterior"
                                                value="1/3 anterior"
                                                {{ in_array('1/3 anterior', $plantarCreases) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="plantar_1_3_anterior">1/3
                                                anterior</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="plantar_creases[]" id="plantar_2_3_anterior"
                                                value="2/3 anterior"
                                                {{ in_array('2/3 anterior', $plantarCreases) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="plantar_2_3_anterior">2/3
                                                anterior</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="plantar_creases[]" id="plantar_lebih_2_3_anterior"
                                                value=">2/3 anterior"
                                                {{ in_array('>2/3 anterior', $plantarCreases) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="plantar_lebih_2_3_anterior">>2/3 anterior</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Waktu pengisian kapiler -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu pengisian kapiler:</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="waktu_pengisian_kapiler" id="kapiler_kurang_2"
                                            value="<2"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->waktu_pengisian_kapiler ?? '') === '<2' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kapiler_kurang_2">&lt;2</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="waktu_pengisian_kapiler" id="kapiler_lebih_2"
                                            value=">2"
                                            {{ ($asesmen->asesmenMedisNeonatologiFisikGeneralis->waktu_pengisian_kapiler ?? '') === '>2' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kapiler_lebih_2">&gt;2</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- 12. Kulit -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">12. KULIT</h6>
                            </div>
                            <div class="col-12 mb-3">
                                @php
                                    $kulit = is_array(
                                        $asesmen->asesmenMedisNeonatologiFisikGeneralis->kulit ?? [],
                                    )
                                        ? $asesmen->asesmenMedisNeonatologiFisikGeneralis->kulit
                                        : [];
                                @endphp
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_pucat" value="pucat"
                                            {{ in_array('pucat', $kulit) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kulit_pucat">Pucat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_ikterik" value="ikterik"
                                            {{ in_array('ikterik', $kulit) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kulit_ikterik">Ikterik</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_mottled" value="mottled"
                                            {{ in_array('mottled', $kulit) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kulit_mottled">Mottled</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_ptekie" value="ptekie"
                                            {{ in_array('ptekie', $kulit) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kulit_ptekie">Ptekie</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_ekimosis" value="ekimosis"
                                            {{ in_array('ekimosis', $kulit) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="kulit_ekimosis">Ekimosis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_hematoma" value="hematoma"
                                            {{ in_array('hematoma', $kulit) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="kulit_hematoma">Hematoma</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kulit[]"
                                            id="kulit_sklerema" value="sklerema"
                                            {{ in_array('sklerema', $kulit) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="kulit_sklerema">Sklerema</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Lainnya:</label>
                                <input type="text" class="form-control" name="kulit_lainnya"
                                    placeholder="Isi keterangan lainnya"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->kulit_lainnya ?? '' }}">
                            </div>
                        </div>

                        <hr>

                        <!-- 13. Kuku -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary mb-3">13. KUKU</h6>
                            </div>
                            <div class="col-12 mb-3">
                                @php
                                    $kuku = is_array(
                                        $asesmen->asesmenMedisNeonatologiFisikGeneralis->kuku ?? [],
                                    )
                                        ? $asesmen->asesmenMedisNeonatologiFisikGeneralis->kuku
                                        : [];
                                @endphp
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kuku[]"
                                            id="kuku_sianosis" value="sianosis"
                                            {{ in_array('sianosis', $kuku) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kuku_sianosis">Sianosis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kuku[]"
                                            id="kuku_meconium" value="meconium stain"
                                            {{ in_array('meconium stain', $kuku) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kuku_meconium">Meconium
                                            stain</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kuku[]"
                                            id="kuku_panjang" value="panjang"
                                            {{ in_array('panjang', $kuku) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kuku_panjang">Panjang</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Lainnya:</label>
                                <input type="text" class="form-control" name="kuku_lainnya"
                                    placeholder="Isi keterangan lainnya"
                                    value="{{ $asesmen->asesmenMedisNeonatologiFisikGeneralis->kuku_lainnya ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="apgar-score">
                    <h5 class="section-title">7. Apgar Skor</h5>

                    <div class="container-fluid">
                        <!-- Appearance (warna kulit) -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Appearance (warna kulit):</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="appearance_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->appearance_1 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Pucat</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->appearance_1 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - Badan merah, ekstermitas biru</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->appearance_1 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - Seluruh tubuh kemerah-merahan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="appearance_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->appearance_5 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Pucat</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->appearance_5 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - Badan merah, ekstermitas biru</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->appearance_5 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - Seluruh tubuh kemerah-merahan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Pulse (Nadi) -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Pulse (Nadi):</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="pulse_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->pulse_1 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Tidak ada</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->pulse_1 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - < 100</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->pulse_1 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - > 100</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="pulse_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->pulse_5 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Tidak ada</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->pulse_5 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - < 100</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->pulse_5 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - > 100</option>
                                </select>
                            </div>
                        </div>

                        <!-- Grimace (Reaksi rangsangan) -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Grimace (Reaksi rangsangan):</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="grimace_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->grimace_1 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Tidak ada</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->grimace_1 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - Sedikit gerakan mimik</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->grimace_1 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - Batuk/ bersin</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="grimace_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->grimace_5 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Tidak ada</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->grimace_5 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - Sedikit gerakan mimik</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->grimace_5 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - Batuk/ bersin</option>
                                </select>
                            </div>
                        </div>

                        <!-- Activity -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Activity:</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="activity_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->activity_1 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Tidak ada</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->activity_1 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - Ekstremitas dalam sedikit fleksi</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->activity_1 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - Gerakan aktif</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="activity_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->activity_5 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Tidak ada</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->activity_5 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - Ekstremitas dalam sedikit fleksi</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->activity_5 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - Gerakan aktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Respiration -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Respiration:</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">1 menit:</label>
                                <select class="form-select" name="respiration_1">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->respiration_1 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Tidak ada</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->respiration_1 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - Lemah/ tidak teratur</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->respiration_1 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - Baik/ menangis</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">5 menit:</label>
                                <select class="form-select" name="respiration_5">
                                    <option value="">Pilih skor</option>
                                    <option value="0"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->respiration_5 ?? '') === '0' ? 'selected' : '' }}>
                                        0 - Tidak ada</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->respiration_5 ?? '') === '1' ? 'selected' : '' }}>
                                        1 - Lemah/ tidak teratur</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->respiration_5 ?? '') === '2' ? 'selected' : '' }}>
                                        2 - Baik/ menangis</option>
                                </select>
                            </div>
                        </div>

                        <!-- Total Score -->
                        <div class="row mt-4 pt-3 border-top">
                            <div class="col-md-12">
                                <label class="form-label fw-bold mb-3">TOTAL SKOR:</label>
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <div class="text-center">
                                        <div class="fw-semibold">1 menit:</div>
                                        <span id="total_1_minute_display"
                                            class="badge bg-primary fs-5">{{ $asesmen->asesmenMedisNeonatologiDtl->total_1_minute ?? 0 }}</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-semibold">5 menit:</div>
                                        <span id="total_5_minute_display"
                                            class="badge bg-primary fs-5">{{ $asesmen->asesmenMedisNeonatologiDtl->total_5_minute ?? 0 }}</span>
                                    </div>
                                    <div class="text-center">
                                        <div class="fw-semibold">Total Gabungan:</div>
                                        <span id="total_combined_display"
                                            class="badge bg-success fs-5">{{ $asesmen->asesmenMedisNeonatologiDtl->total_combined ?? 0 }}</span>
                                    </div>
                                </div>

                                <!-- Hidden inputs untuk menyimpan data -->
                                <input type="hidden" id="total_1_minute" name="total_1_minute"
                                    value="{{ $asesmen->asesmenMedisNeonatologiDtl->total_1_minute ?? 0 }}">
                                <input type="hidden" id="total_5_minute" name="total_5_minute"
                                    value="{{ $asesmen->asesmenMedisNeonatologiDtl->total_5_minute ?? 0 }}">
                                <input type="hidden" id="total_combined" name="total_combined"
                                    value="{{ $asesmen->asesmenMedisNeonatologiDtl->total_combined ?? 0 }}">
                                <input type="hidden" id="apgar_data" name="apgar_data"
                                    value="{{ json_encode($asesmen->asesmenMedisNeonatologiDtl->apgar_data ?? []) }}">
                                <input type="hidden" id="apgar_interpretation"
                                    name="apgar_interpretation"
                                    value="{{ $asesmen->asesmenMedisNeonatologiDtl->apgar_interpretation ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="diagnosisIbu">
                    <h5 class="section-title">8. Diagnosis</h5>
                    <!-- Diagnosis IBU -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3">Diagnosis Ibu</h6>

                            <!-- Nomor diagnosis -->
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-1"><strong>1</strong></div>
                                    <div class="col-11">
                                        <input type="text" class="form-control" name="diagnosis_ibu_1"
                                            placeholder="Diagnosis 1"
                                            value="{{ $asesmen->asesmenMedisNeonatologiDtl->diagnosis_ibu_1 ?? '' }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-1"><strong>2</strong></div>
                                    <div class="col-11">
                                        <input type="text" class="form-control" name="diagnosis_ibu_2"
                                            placeholder="Diagnosis 2"
                                            value="{{ $asesmen->asesmenMedisNeonatologiDtl->diagnosis_ibu_2 ?? '' }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-1"><strong>3</strong></div>
                                    <div class="col-11">
                                        <input type="text" class="form-control" name="diagnosis_ibu_3"
                                            placeholder="Diagnosis 3"
                                            value="{{ $asesmen->asesmenMedisNeonatologiDtl->diagnosis_ibu_3 ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Cara Persalinan -->
                            <h6 class="text-primary mb-3">Cara Persalinan</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="cara_persalinan[]" id="spontan" value="spontan"
                                            {{ in_array('spontan', $asesmen->asesmenMedisNeonatologiDtl->cara_persalinan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="spontan">Spontan</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="cara_persalinan[]" id="sc" value="sc"
                                            {{ in_array('sc', $asesmen->asesmenMedisNeonatologiDtl->cara_persalinan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sc">SC</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="cara_persalinan[]" id="vacum" value="vacum"
                                            {{ in_array('vacum', $asesmen->asesmenMedisNeonatologiDtl->cara_persalinan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vacum">Vacum</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="cara_persalinan[]" id="forceps" value="forceps"
                                            {{ in_array('forceps', $asesmen->asesmenMedisNeonatologiDtl->cara_persalinan ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="forceps">Forceps</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Indikasi -->
                            <div class="mb-4">
                                <label class="form-label"><strong>Indikasi:</strong></label>
                                <textarea class="form-control" name="indikasi" rows="3" placeholder="Masukkan indikasi...">{{ $asesmen->asesmenMedisNeonatologiDtl->indikasi ?? '' }}</textarea>
                            </div>

                            <!-- Faktor Resiko IBU -->
                            <h6 class="text-primary mb-3">Faktor Resiko Ibu</h6>

                            <!-- Mayor -->
                            <div class="mb-3">
                                <label class="form-label"><strong>Mayor:</strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="demam" value="demam"
                                                {{ in_array('demam', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_mayor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="demam">Demam (T>38
                                                °C)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="kpd_18" value="kpd_18"
                                                {{ in_array('kpd_18', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_mayor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kpd_18">KPD > 18
                                                Jam</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="korioamnionitis"
                                                value="korioamnionitis"
                                                {{ in_array('korioamnionitis', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_mayor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="korioamnionitis">Korioamnionitis</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="fetal_distress"
                                                value="fetal_distress"
                                                {{ in_array('fetal_distress', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_mayor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="fetal_distress">Fetal
                                                distress, DJJ > 160 x/″</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_mayor[]" id="ketuban_berbau"
                                                value="ketuban_berbau"
                                                {{ in_array('ketuban_berbau', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_mayor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ketuban_berbau">Ketuban
                                                berbau</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Minor -->
                            <div class="mb-3">
                                <label class="form-label"><strong>Minor:</strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="kpd_12" value="kpd_12"
                                                {{ in_array('kpd_12', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_minor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kpd_12">KPD > 12
                                                Jam</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="apgar_skor"
                                                value="apgar_skor"
                                                {{ in_array('apgar_skor', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_minor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="apgar_skor">APGAR Skor 1'<5
                                                    atau 5'< 7</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="bblsr" value="bblsr"
                                                {{ in_array('bblsr', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_minor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bblsr">BBLSR (<1500
                                                    g)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="gestasi"
                                                value="gestasi"
                                                {{ in_array('gestasi', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_minor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gestasi">Gestasi < 37
                                                    mggu</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="gemelli"
                                                value="gemelli"
                                                {{ in_array('gemelli', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_minor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gemelli">Gemelli</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="keputihan_tdk_diobati"
                                                value="keputihan_tdk_diobati"
                                                {{ in_array('keputihan_tdk_diobati', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_minor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="keputihan_tdk_diobati">Keputihan tdk diobati</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="isk_susp_isk"
                                                value="isk_susp_isk"
                                                {{ in_array('isk_susp_isk', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_minor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="isk_susp_isk">ISK/ Susp.
                                                ISK</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="faktor_resiko_minor[]" id="ibu_demam"
                                                value="ibu_demam"
                                                {{ in_array('ibu_demam', $asesmen->asesmenMedisNeonatologiDtl->faktor_resiko_minor ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ibu_demam">Ibu demam > 38
                                                °C</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="refleksPrimitif">
                    <h5 class="section-title">9. Refleks Primitif</h5>

                    <!-- Refleks Primitif -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <!-- Baris 1: Refleks moro dan Refleks rooting -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks moro</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_moro" id="refleks_moro_ya"
                                                        value="1"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_moro ?? '') === '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_moro_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_moro" id="refleks_moro_tidak"
                                                        value="0"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_moro ?? '') === '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_moro_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks rooting</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_rooting" id="refleks_rooting_ya"
                                                        value="1"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_rooting ?? '') === '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_rooting_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_rooting" id="refleks_rooting_tidak"
                                                        value="0"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_rooting ?? '') === '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_rooting_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 2: Refleks palmar grasping dan Refleks sucking -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks palmar grasping</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_palmar_grasping"
                                                        id="refleks_palmar_grasping_ya" value="1"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_palmar_grasping ?? '') === '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_palmar_grasping_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_palmar_grasping"
                                                        id="refleks_palmar_grasping_tidak" value="0"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_palmar_grasping ?? '') === '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_palmar_grasping_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks sucking</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_sucking" id="refleks_sucking_ya"
                                                        value="1"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_sucking ?? '') === '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_sucking_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_sucking" id="refleks_sucking_tidak"
                                                        value="0"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_sucking ?? '') === '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_sucking_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 3: Refleks plantar grasping dan Refleks tonic neck -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks plantar grasping</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_plantar_grasping"
                                                        id="refleks_plantar_grasping_ya" value="1"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_plantar_grasping ?? '') === '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_plantar_grasping_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_plantar_grasping"
                                                        id="refleks_plantar_grasping_tidak" value="0"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_plantar_grasping ?? '') === '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_plantar_grasping_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-md-5">
                                            <label class="form-label">Refleks tonic neck</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_tonic_neck" id="refleks_tonic_neck_ya"
                                                        value="1"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_tonic_neck ?? '') === '1' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_tonic_neck_ya">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="refleks_tonic_neck"
                                                        id="refleks_tonic_neck_tidak" value="0"
                                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->refleks_tonic_neck ?? '') === '0' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="refleks_tonic_neck_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="kelainanBawaan">
                    <h5 class="section-title">10. Kelainan Bawaan</h5>

                    <!-- Kelainan Bawaan -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-1"><strong>1</strong></div>
                                <div class="col-11">
                                    <input type="text" class="form-control mb-2"
                                        name="kelainan_bawaan_1" placeholder="Kelainan bawaan 1"
                                        value="{{ $asesmen->asesmenMedisNeonatologiDtl->kelainan_bawaan_1 ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"><strong>2</strong></div>
                                <div class="col-11">
                                    <input type="text" class="form-control mb-2"
                                        name="kelainan_bawaan_2" placeholder="Kelainan bawaan 2"
                                        value="{{ $asesmen->asesmenMedisNeonatologiDtl->kelainan_bawaan_2 ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"><strong>3</strong></div>
                                <div class="col-11">
                                    <input type="text" class="form-control mb-2"
                                        name="kelainan_bawaan_3" placeholder="Kelainan bawaan 3"
                                        value="{{ $asesmen->asesmenMedisNeonatologiDtl->kelainan_bawaan_3 ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1"><strong>4</strong></div>
                                <div class="col-11">
                                    <input type="text" class="form-control mb-2"
                                        name="kelainan_bawaan_4" placeholder="Kelainan bawaan 4"
                                        value="{{ $asesmen->asesmenMedisNeonatologiDtl->kelainan_bawaan_4 ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="hasilPemeriksaanPenunjang">
                    <h5 class="section-title">11. Hasil Pemeriksaan Penunjang</h5>
                    <div class="form-floating">
                        <textarea class="form-control" name="hasil_laboratorium" placeholder="Hasil Laboratorium" id="laboratorium"
                            style="height: 100px">{{ $asesmen->asesmenMedisNeonatologiDtl->hasil_laboratorium ?? '' }}</textarea>
                        <label for="laboratorium">1. Laboratorium</label>
                    </div>
                    <div class="form-floating mt-3">
                        <textarea class="form-control" name="hasil_radiologi" placeholder="Hasil Radiologi" id="radiologi"
                            style="height: 100px">{{ $asesmen->asesmenMedisNeonatologiDtl->hasil_radiologi ?? '' }}</textarea>
                        <label for="radiologi">2. Radiologi</label>
                    </div>
                    <div class="form-floating mt-3">
                        <textarea class="form-control" name="hasil_lainnya" placeholder="Hasil Lainnya" id="lainnya"
                            style="height: 100px">{{ $asesmen->asesmenMedisNeonatologiDtl->hasil_lainnya ?? '' }}</textarea>
                        <label for="lainnya">3. Lainnya</label>
                    </div>
                </div>

                <div class="section-separator" id="diagnosis">
                    <h5 class="fw-semibold mb-4">12. Diagnosis</h5>
                    <!-- Diagnosis Banding -->
                    <div class="mb-4">
                        <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
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

                        <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                            <!-- Diagnosis items will be added here dynamically -->
                        </div>

                        <!-- Hidden input to store JSON data -->
                        <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                            value="{{ old('diagnosis_banding', json_encode($asesmen->asesmenMedisNeonatologiDtl->diagnosis_banding ?? [])) }}">
                    </div>

                    <!-- Diagnosis Kerja -->
                    <div class="mb-4">
                        <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
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

                        <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                            <!-- Diagnosis items will be added here dynamically -->
                        </div>

                        <!-- Hidden input to store JSON data -->
                        <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                            value="{{ old('diagnosis_kerja', json_encode($asesmen->asesmenMedisNeonatologiDtl->diagnosis_kerja ?? [])) }}">
                    </div>
                </div>

                <div class="section-separator" id="rencana_pengobatan">
                    <h5 class="fw-semibold mb-4">13. Rencana Penatalaksanaan dan Pengobatan</h5>
                    <textarea class="form-control" name="rencana_pengobatan" rows="4"
                        placeholder="Rencana Penatalaksanaan Dan Pengobatan">{{ old('rencana_pengobatan', $asesmen->asesmenMedisNeonatologiDtl->rencana_pengobatan ?? '') }}</textarea>
                </div>

                <div class="section-separator" id="prognosis">
                    <h5 class="fw-semibold mb-4">14. Prognosis</h5>
                    <select class="form-select" name="prognosis">
                        <option value="" disabled>--Pilih Prognosis--</option>
                        @forelse ($satsetPrognosis as $item)
                            <option value="{{ $item->prognosis_id }}"
                                {{ old('prognosis', $asesmen->asesmenMedisNeonatologiDtl->prognosis ?? '') == $item->prognosis_id ? 'selected' : '' }}>
                                {{ $item->value ?? 'Field tidak ditemukan' }}
                            </option>
                        @empty
                            <option value="" disabled>Tidak ada data</option>
                        @endforelse
                    </select>
                </div>

                <div class="section-separator" id="discharge-planning">
                    <h5 class="section-title">15. Perencanaan Pulang Pasien (Discharge Planning)</h5>
                    <div class="card-body">
                        <!-- 1. Usia yang menarik bayi di rumah -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ada yang  merawat bayi dirumah</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                            name="usia_menarik_bayi" id="usia_ya" value="ya"
                                            {{ ($asesmen->asesmenMedisNeonatologiDtl->usia_menarik_bayi ?? '') === 'ya' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="usia_ya">Ya: Ibu/ Ayah/
                                            Keluarga lainnya</label>
                                    </div>
                                    <input type="text" class="form-control" name="keterangan_usia"
                                        placeholder="Sebutkan siapa..."
                                        value="{{ $asesmen->asesmenMedisNeonatologiDtl->keterangan_usia ?? '' }}"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->usia_menarik_bayi ?? '') !== 'ya' ? 'disabled' : '' }}>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                            name="usia_menarik_bayi" id="usia_tidak" value="tidak"
                                            {{ ($asesmen->asesmenMedisNeonatologiDtl->usia_menarik_bayi ?? '') === 'tidak' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="usia_tidak">Tidak,
                                            jelaskan</label>
                                    </div>
                                    <input type="text" class="form-control"
                                        name="keterangan_tidak_usia" placeholder="Jelaskan alasan..."
                                        value="{{ $asesmen->asesmenMedisNeonatologiDtl->keterangan_tidak_usia ?? '' }}"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->usia_menarik_bayi ?? '') !== 'tidak' ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Antisipasi terhadap masalah saat pulang -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Antisipasi terhadap masalah saat pulang</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            name="masalah_pulang" id="masalah_tidak" value="tidak"
                                            {{ ($asesmen->asesmenMedisNeonatologiDtl->masalah_pulang ?? '') === 'tidak' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="masalah_tidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio"
                                            name="masalah_pulang" id="masalah_ya" value="ya"
                                            {{ ($asesmen->asesmenMedisNeonatologiDtl->masalah_pulang ?? '') === 'ya' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="masalah_ya">Ya,
                                            jelaskan</label>
                                    </div>
                                    <textarea class="form-control" name="keterangan_masalah_pulang" rows="2"
                                        placeholder="Jelaskan masalah yang mungkin terjadi..."
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->masalah_pulang ?? '') !== 'ya' ? 'disabled' : '' }}>{{ $asesmen->asesmenMedisNeonatologiDtl->keterangan_masalah_pulang ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Beresiko finansial -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Beresiko finansial</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="beresiko_finansial" id="finansial_tidak" value="tidak"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->beresiko_finansial ?? '') === 'tidak' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="finansial_tidak">Tidak</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        name="beresiko_finansial" id="finansial_ya" value="ya"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->beresiko_finansial ?? '') === 'ya' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="finansial_ya">Ya</label>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Edukasi diperlukan dalam hal -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Edukasi diperlukan dalam hal</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_menyusui" value="menyusui"
                                            {{ in_array('menyusui', $asesmen->asesmenMedisNeonatologiDtl->edukasi ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="edukasi_menyusui">Menyusui</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_memandikan" value="memandikan"
                                            {{ in_array('memandikan', $asesmen->asesmenMedisNeonatologiDtl->edukasi ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="edukasi_memandikan">Memandikan</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_berpakaian" value="berpakaian"
                                            {{ in_array('berpakaian', $asesmen->asesmenMedisNeonatologiDtl->edukasi ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="edukasi_berpakaian">Berpakaian</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_perawatan_bayi" value="perawatan_bayi_dasar"
                                            {{ in_array('perawatan_bayi_dasar', $asesmen->asesmenMedisNeonatologiDtl->edukasi ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="edukasi_perawatan_bayi">Perawatan bayi dasar (basic infant
                                            care)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_mengukur_suhu" value="mengukur_suhu"
                                            {{ in_array('mengukur_suhu', $asesmen->asesmenMedisNeonatologiDtl->edukasi ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edukasi_mengukur_suhu">Mengukur
                                            suhu</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_perawatan_kulit" value="perawatan_kulit_kelamin"
                                            {{ in_array('perawatan_kulit_kelamin', $asesmen->asesmenMedisNeonatologiDtl->edukasi ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="edukasi_perawatan_kulit">Perawatan kulit/ kelamin</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="edukasi[]"
                                            id="edukasi_lainnya" value="lainnya"
                                            {{ in_array('lainnya', $asesmen->asesmenMedisNeonatologiDtl->edukasi ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="edukasi_lainnya">Lainnya</label>
                                    </div>
                                    <input type="text" class="form-control"
                                        name="edukasi_lainnya_keterangan"
                                        placeholder="Sebutkan edukasi lainnya..."
                                        value="{{ $asesmen->asesmenMedisNeonatologiDtl->edukasi_lainnya_keterangan ?? '' }}"
                                        {{ !in_array('lainnya', $asesmen->asesmenMedisNeonatologiDtl->edukasi ?? []) ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Ada yang membantu keperluan di atas -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ada yang membantu keperluan di atas?</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ada_membantu"
                                            id="membantu_tidak" value="tidak"
                                            {{ ($asesmen->asesmenMedisNeonatologiDtl->ada_membantu ?? '') === 'tidak' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="membantu_tidak">Tidak</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="ada_membantu"
                                            id="membantu_ada" value="ada"
                                            {{ ($asesmen->asesmenMedisNeonatologiDtl->ada_membantu ?? '') === 'ada' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="membantu_ada">Ada,
                                            siapa</label>
                                    </div>
                                    <input type="text" class="form-control" name="keterangan_membantu"
                                        placeholder="Sebutkan siapa yang membantu..."
                                        value="{{ $asesmen->asesmenMedisNeonatologiDtl->keterangan_membantu ?? '' }}"
                                        {{ ($asesmen->asesmenMedisNeonatologiDtl->ada_membantu ?? '') !== 'ada' ? 'disabled' : '' }}>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Perkiraan lama hari dirawat -->
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Perkiraan lama hari dirawat</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control"
                                            name="perkiraan_lama_rawat" placeholder="0" min="0"
                                            value="{{ $asesmen->asesmenMedisNeonatologiDtl->perkiraan_lama_rawat ?? '' }}">
                                        <span class="input-group-text">Hari</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Rencana Tanggal Pulang</label>
                                    <input type="date" class="form-control"
                                        name="rencana_tanggal_pulang"
                                        value="{{ $asesmen->asesmenMedisNeonatologiDtl->rencana_tanggal_pulang ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <x-button-submit>Perbarui</x-button-submit>
                </div>

            </form>
        </x-content-card>
        </div>
    </div>
@endsection
