<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.include-edit')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="asesmenForm" method="POST" action="{{ route('asesmen-keperawatan.update', [
        'kd_pasien' => $dataMedis->kd_pasien,
        'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'),
        'urut_masuk' => $dataMedis->urut_masuk,
        'id' => $asesmen->id
    ]) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">
                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <!-- <h4 class="header-asesmen text-end">Edit Asesmen Awal Keperawatan Gawat Darurat</h4> -->
                            <div class="px-3">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Asesmen</label>
                                            <input type="date" name="waktu_asesmen" id="tgl_asesmen_keperawatan"
                                                class="form-control"
                                                value="{{ old('waktu_asesmen', date('Y-m-d', strtotime($asesmen->waktu_asesmen))) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label">Jam Asesmen</label>
                                            <input type="time" name="jam_asesmen" id="jam_asesmen_keperawatan"
                                                class="form-control"
                                                value="{{ old('jam_asesmen', date('H:i', strtotime($asesmen->waktu_asesmen))) }}">
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-7">
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
                                <h4 class="header-asesmen">Asesmen Awal Keperawatan Gawat Darurat</h4>
                                <p>
                                    Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                </p>
                            </div>

                            {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                            <div class="px-3">
                                <div>
                                    <div class="section-separator" id="status-airway">
                                        <h5 class="section-title">1. Status Air way</h5>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status Airway</label>
                                            <select class="form-select" name="airway_status">
                                                <option value="">--Pilih--</option>
                                                <option value="bebas" {{ $asesmen->asesmenKepUmum->airway_status == 'bebas' ? 'selected' : '' }}>
                                                    Bebas</option>
                                                <option value="pangkal lidah jatuh" {{ $asesmen->asesmenKepUmum->airway_status == 'pangkal lidah jatuh' ? 'selected' : '' }}>
                                                    Tidak Bebas (Pangkal Lidah Jatuh)</option>
                                                <option value="sputum" {{ $asesmen->asesmenKepUmum->airway_status == 'sputum' ? 'selected' : '' }}>
                                                    Tidak Bebas (Sputum)</option>
                                                <option value="darah" {{ $asesmen->asesmenKepUmum->airway_status == 'darah' ? 'selected' : '' }}>
                                                    Tidak Bebas (darah)</option>
                                                <option value="spasm" {{ $asesmen->asesmenKepUmum->airway_status == 'spasm' ? 'selected' : '' }}>
                                                    Tidak Bebas (Spasm)</option>
                                                <option value="benda asing" {{ $asesmen->asesmenKepUmum->airway_status == 'benda asing' ? 'selected' : '' }}>
                                                    Tidak Bebas (Benda Asing)</option>
                                                <option value="lainnya" {{ $asesmen->asesmenKepUmum->airway_status == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suara Nafas</label>
                                            <select class="form-select" name="airway_suara_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="normal" {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'normal' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="whezing" {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'whezing' ? 'selected' : '' }}>
                                                    Whezing</option>
                                                <option value="ronchi" {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'ronchi' ? 'selected' : '' }}>
                                                    Ronchi</option>
                                                <option value="crackles" {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'crackles' ? 'selected' : '' }}>
                                                    Crackles</option>
                                                <option value="stridor" {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'stridor' ? 'selected' : '' }}>
                                                    Stridor</option>
                                            </select>
                                        </div>

                                        <div class="form-group diagnosis-section" id="airway-diagnosis">
                                            <label style="min-width: 200px;">Diagnosis Keperawatan</label>
                                            <div class="w-100">
                                                <div class="diagnosis-item">
                                                    <div class="diagnosis-row border-top border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-radio diagnose-prwt-checkbox"
                                                                    id="jalan_nafas_tidak_efektif" name="airway_diagnosis"
                                                                    value="1" {{ $asesmen->asesmenKepUmum && !is_null($asesmen->asesmenKepUmum->airway_diagnosis) ? 'checked' : '' }}>
                                                                <!-- Tambahkan hidden input untuk memastikan field selalu dikirim -->
                                                                <input type="hidden" name="current_airway_diagnosis"
                                                                    value="{{ $asesmen->asesmenKepUmum->airway_diagnosis ?? '' }}">
                                                                <label class="form-check-label"
                                                                    for="jalan_nafas_tidak_efektif">
                                                                    Jalan nafas tidak efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="airway_aktual" name="airway_diagnosis_type"
                                                                        value="1" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->airway_diagnosis == '1' ? 'checked' : '' }} {{ !$asesmen->asesmenKepUmum || is_null($asesmen->asesmenKepUmum->airway_diagnosis) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="airway_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="airway_risiko" name="airway_diagnosis_type"
                                                                        value="2" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->airway_diagnosis == '2' ? 'checked' : '' }} {{ !$asesmen->asesmenKepUmum || is_null($asesmen->asesmenKepUmum->airway_diagnosis) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="airway_risiko">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tindakan Keperawatan</label>
                                            <div class="w-100">
                                                <input type="hidden" id="existingTindakan-airway"
                                                    value="{{ optional($asesmen->asesmenKepUmum)->airway_tindakan }}">

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-airway mb-3"
                                                    data-bs-target="#tindakanKeperawatanAirwayModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-airway" class="d-flex flex-column gap-2">
                                                    <!-- Airway tindakan list will be populated by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-breathing">
                                        <h5 class="section-title">2. Status Breathing</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Frekuensi nafas/menit</label>
                                            <input type="text" class="form-control" name="breathing_frekuensi_nafas"
                                                value="{{ optional($asesmen->asesmenKepUmumBreathing)->breathing_frekuensi_nafas }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pola nafas</label>
                                            <select class="form-select" name="breathing_pola_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="Normal" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Normal' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="Apnea" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Apnea' ? 'selected' : '' }}>
                                                    Apnea</option>
                                                <option value="Sesak" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Sesak' ? 'selected' : '' }}>
                                                    Sesak</option>
                                                <option value="Bradipnea" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Bradipnea' ? 'selected' : '' }}>
                                                    Bradipnea</option>
                                                <option value="Takipnea" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Takipnea' ? 'selected' : '' }}>
                                                    Takipnea</option>
                                                <option value="Othopnea" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Othopnea' ? 'selected' : '' }}>
                                                    Othopnea</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bunyi nafas</label>
                                            <select class="form-select" name="breathing_bunyi_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="Normal" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Normal' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="Veskuler" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Veskuler' ? 'selected' : '' }}>
                                                    Veskuler</option>
                                                <option value="Wheezing" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Wheezing' ? 'selected' : '' }}>
                                                    Whezing</option>
                                                <option value="Stridor" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Stridor' ? 'selected' : '' }}>
                                                    Stridor</option>
                                                <option value="Ronchi" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Ronchi' ? 'selected' : '' }}>
                                                    Ronchi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Irama Nafas</label>
                                            <select class="form-select" name="breathing_irama_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ old('breathing_irama_nafas', $asesmen->asesmenKepUmumBreathing->breathing_irama_nafas ?? '') == '1' ? 'selected' : '' }}>
                                                    Teratur</option>
                                                <option value="0" {{ old('breathing_irama_nafas', $asesmen->asesmenKepUmumBreathing->breathing_irama_nafas ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak Teratur</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanda Distress Nafas</label>
                                            <select class="form-select" name="breathing_tanda_distress">
                                                <option value="">--Pilih--</option>
                                                <option value="Tidak Ada Tanda Distress" {{ old('breathing_tanda_distress', $asesmen->asesmenKepUmumBreathing->breathing_tanda_distress ?? '') == 'Tidak Ada Tanda Distress' ? 'selected' : '' }}>
                                                    Tidak Ada Tanda Distress</option>
                                                <option value="Penggunaan Otot Bantu" {{ old('breathing_tanda_distress', $asesmen->asesmenKepUmumBreathing->breathing_tanda_distress ?? '') == 'Penggunaan Otot Bantu' ? 'selected' : '' }}>
                                                    Penggunaan Otot Bantu</option>
                                                <option value="Retraksi Dada/Intercosta" {{ old('breathing_tanda_distress', $asesmen->asesmenKepUmumBreathing->breathing_tanda_distress ?? '') == 'Retraksi Dada/Intercosta' ? 'selected' : '' }}>
                                                    Retraksi Dada/Intercosta</option>
                                                <option value="Cupling Hidung" {{ old('breathing_tanda_distress', $asesmen->asesmenKepUmumBreathing->breathing_tanda_distress ?? '') == 'Cupling Hidung' ? 'selected' : '' }}>
                                                    Cupling Hidung</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jalan Pernafasan</label>
                                            <select class="form-select" name="breathing_jalan_nafas">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ old('breathing_jalan_nafas', $asesmen->asesmenKepUmumBreathing->breathing_jalan_nafas ?? '') == '1' ? 'selected' : '' }}>
                                                    Pernafasan Dada</option>
                                                <option value="2" {{ old('breathing_jalan_nafas', $asesmen->asesmenKepUmumBreathing->breathing_jalan_nafas ?? '') == '2' ? 'selected' : '' }}>
                                                    Pernafasan Perut</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <input class="form-control" type="text" name="breathing_lainnya"
                                                value="{{ old('breathing_lainnya', $asesmen->asesmenKepUmumBreathing->breathing_lainnya ?? '') }}">
                                        </div>
                                        <div class="form-group diagnosis-section">
                                            <label style="min-width: 200px;">Diagnosis Keperawatan</label>
                                            <div class="w-100">
                                                <div class="diagnosis-item">
                                                    <!-- Diagnosis 1: Pola Nafas Tidak Efektif -->
                                                    <div class="diagnosis-row border-top border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="pola_nafas_tidak_efektif"
                                                                    name="breathing_diagnosis_nafas[]" value="pola_nafas" {{ !empty($asesmen->asesmenKepUmumBreathing->breathing_diagnosis_nafas) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden"
                                                                    name="current_breathing_diagnosis_nafas"
                                                                    value="{{ $asesmen->asesmenKepUmumBreathing->breathing_diagnosis_nafas ?? '' }}">
                                                                <label class="form-check-label"
                                                                    for="pola_nafas_tidak_efektif">
                                                                    Pola Nafas Tidak Efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_aktual"
                                                                        name="breathing_diagnosis_type" value="1" {{ $asesmen->asesmenKepUmumBreathing && $asesmen->asesmenKepUmumBreathing->breathing_diagnosis_nafas == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumBreathing->breathing_diagnosis_nafas) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="breathing_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_risiko"
                                                                        name="breathing_diagnosis_type" value="2" {{ $asesmen->asesmenKepUmumBreathing && $asesmen->asesmenKepUmumBreathing->breathing_diagnosis_nafas == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumBreathing->breathing_diagnosis_nafas) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="breathing_risiko">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 2: Gangguan Pertukaran Gas -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="gangguan_pertukaran_gas" name="breathing_gangguan[]"
                                                                    value="gangguan" {{ !empty($asesmen->asesmenKepUmumBreathing->breathing_gangguan) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="current_breathing_gangguan"
                                                                    value="{{ $asesmen->asesmenKepUmumBreathing->breathing_gangguan ?? '' }}">
                                                                <label class="form-check-label"
                                                                    for="gangguan_pertukaran_gas">
                                                                    Gangguan Pertukaran Gas
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_aktual_1"
                                                                        name="breathing_gangguan_type" value="1" {{ $asesmen->asesmenKepUmumBreathing && $asesmen->asesmenKepUmumBreathing->breathing_gangguan == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumBreathing->breathing_gangguan) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="breathing_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_risiko_1"
                                                                        name="breathing_gangguan_type" value="2" {{ $asesmen->asesmenKepUmumBreathing && $asesmen->asesmenKepUmumBreathing->breathing_gangguan == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumBreathing->breathing_gangguan) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="breathing_risiko_1">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" style="min-width: 200px;">Tindakan Keperawatan</label>
                                            <div class="w-100">
                                                <input type="hidden" id="existingTindakan-breathing"
                                                    value="{{ optional($asesmen->asesmenKepUmumBreathing)->breathing_tindakan }}">

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-breathing mb-3"
                                                    data-bs-target="#tindakanKeperawatanBreathingModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-breathing" class="d-flex flex-column gap-2">
                                                    <!-- Tindakan list will be populated by JavaScript -->
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">3. Status Circulation</h5>

                                        {{-- <div class="form-group" id="status-disability">
                                            <label style="min-width: 200px;">Nadi Frekuensi/menit</label>
                                            <input type="text" class="form-control" name="circulation_nadi">
                                        </div> --}}

                                        {{-- <div class="form-group">
                                            <label style="min-width: 200px;">Tekanan Darah (mmHg)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Sistole</small>
                                                    </div>
                                                    <input class="form-control" type="text" name="circulation_sistole">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Diastole</small>
                                                    </div>
                                                    <input class="form-control" type="text" name="circulation_diastole">
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Akral</label>
                                            <select class="form-select" name="circulation_akral">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_akral == '1' ? 'selected' : '' }}>
                                                    Hangat</option>
                                                <option value="2" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_akral == '2' ? 'selected' : '' }}>
                                                    Dingin</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pucat</label>
                                            <select class="form-select" name="circulation_pucat">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_pucat == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_pucat == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sianosis</label>
                                            <select class="form-select" name="circulation_cianosis">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_cianosis == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_cianosis == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pengisian Kapiler</label>
                                            <select class="form-select" name="circulation_kapiler">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_kapiler == '1' ? 'selected' : '' }}>
                                                    < 2 Detik</option>
                                                <option value="2" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_kapiler == '2' ? 'selected' : '' }}>
                                                    > 2 Detik</option>
                                            </select>
                                        </div>
                                        <label style="min-width: 200px;" class="fw-bold">Nadi</label>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Frekuensi</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Diberikan?</small>
                                                    </div>
                                                    <select class="form-select" name="circulation_transfusi">
                                                        <option value="">--Pilih--</option>
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_transfusi == '1' ? 'selected' : '' }}>Ya</option>
                                                        <option value="0" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_transfusi == '0' ? 'selected' : '' }}>Tidak</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Jumlah Frekuensi (x/mnt)</small>
                                                    </div>
                                                    <input class="form-control" type="number"
                                                        name="circulation_transfusi_jumlah"
                                                        value="{{ optional($asesmen->asesmenKepUmumCirculation)->circulation_transfusi_jumlah }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nadi Irama</label>
                                            <select class="form-select" name="circulation_nadi_irama">
                                                <option value="">--Pilih--</option>
                                                <option value="reguler" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_nadi_irama == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                                <option value="irreguler" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_nadi_irama == 'irreguler' ? 'selected' : '' }}>Irreguler</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nadi Kekuatan</label>
                                            <select class="form-select" name="circulation_nadi_kekuatan">
                                                <option value="">--Pilih--</option>
                                                <option value="kuat" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_nadi_kekuatan == 'kuat' ? 'selected' : '' }}>Kuat</option>
                                                <option value="lemah" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_nadi_kekuatan == 'lemah' ? 'selected' : '' }}>Lemah</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kelembapan Kulit</label>
                                            <select class="form-select" name="circulation_kelembapan_kulit">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_kelembapan_kulit == '1' ? 'selected' : '' }}>
                                                    Lembab</option>
                                                <option value="2" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_kelembapan_kulit == '2' ? 'selected' : '' }}>
                                                    Kering</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tugor</label>
                                            <select class="form-select" name="circulation_turgor">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_turgor == '1' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="0" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_turgor == '0' ? 'selected' : '' }}>
                                                    Kurang</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Transfursi Darah</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Diberikan?</small>
                                                    </div>
                                                    <select class="form-select" name="circulation_transfusi">
                                                        <option value="">--Pilih--</option>
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_transfusi == '1' ? 'selected' : '' }}>
                                                            Ya</option>
                                                        <option value="0" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_transfusi == '0' ? 'selected' : '' }}>
                                                            Tidak</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Jumlah Transfursi (cc)</small>
                                                    </div>
                                                    <input class="form-control" type="text"
                                                        name="circulation_transfusi_jumlah"
                                                        value="{{ optional($asesmen->asesmenKepUmumCirculation)->circulation_transfusi_jumlah }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <input class="form-control" type="text"
                                                placeholder="isikan jika ada keluhan nafas lainnya" name="circulation_lain"
                                                value="{{ optional($asesmen->asesmenKepUmumCirculation)->circulation_lain }}">
                                        </div>

                                        <div class="form-group diagnosis-section">
                                            <label style="min-width: 200px;">Diagnosis Keperawatan</label>
                                            <div class="w-100">
                                                <div class="diagnosis-list">
                                                    <!-- Diagnosis 1: Perfusi Jaringan -->
                                                    <div class="diagnosis-row border-top border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnose-prwt-checkbox"
                                                                    id="circulation_diagnosis_perfusi"
                                                                    name="circulation_diagnosis_perfusi" value="1" {{ !empty($asesmen->asesmenKepUmumCirculation->circulation_diagnosis_perfusi) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="circulation_diagnosis_perfusi"
                                                                    value="{{ $asesmen->asesmenKepUmumCirculation->circulation_diagnosis_perfusi ?? '' }}">
                                                                <label class="form-check-label"
                                                                    for="circulation_diagnosis_perfusi">
                                                                    Perfusi Jaringan Perifer Tidak Efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_perfusi_aktual"
                                                                        name="circulation_diagnosis_perfusi_type" value="1"
                                                                        {{ $asesmen->asesmenKepUmumCirculation && $asesmen->asesmenKepUmumCirculation->circulation_diagnosis_perfusi == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumCirculation->circulation_diagnosis_perfusi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="circulation_perfusi_aktual">
                                                                        Aktual
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_perfusi_risiko"
                                                                        name="circulation_diagnosis_perfusi_type" value="2"
                                                                        {{ $asesmen->asesmenKepUmumCirculation && $asesmen->asesmenKepUmumCirculation->circulation_diagnosis_perfusi == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumCirculation->circulation_diagnosis_perfusi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="circulation_perfusi_risiko">
                                                                        Risiko
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 2: Defisit Volume -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnose-prwt-checkbox"
                                                                    id="circulation_diagnosis_defisit"
                                                                    name="circulation_diagnosis_defisit" value="1" {{ !empty($asesmen->asesmenKepUmumCirculation->circulation_diagnosis_defisit) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="circulation_diagnosis_defisit"
                                                                    value="{{ $asesmen->asesmenKepUmumCirculation->circulation_diagnosis_defisit ?? '' }}">
                                                                <label class="form-check-label"
                                                                    for="circulation_diagnosis_defisit">
                                                                    Defisit Volume Cairan
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_defisit_aktual"
                                                                        name="circulation_diagnosis_defisit_type" value="1"
                                                                        {{ $asesmen->asesmenKepUmumCirculation && $asesmen->asesmenKepUmumCirculation->circulation_diagnosis_defisit == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumCirculation->circulation_diagnosis_defisit) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="circulation_defisit_aktual">
                                                                        Aktual
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_defisit_risiko"
                                                                        name="circulation_diagnosis_defisit_type" value="2"
                                                                        {{ $asesmen->asesmenKepUmumCirculation && $asesmen->asesmenKepUmumCirculation->circulation_diagnosis_defisit == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumCirculation->circulation_diagnosis_defisit) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="circulation_defisit_risiko">
                                                                        Risiko
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tindakan Keperawatan</label>
                                            <div class="w-100">
                                                <input type="hidden" id="existingTindakan-circulation"
                                                    value='{{ optional($asesmen->asesmenKepUmumCirculation)->circulation_tindakan ?? '[]' }}'>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-circulation mb-3"
                                                    data-bs-target="#tindakanKeperawatanCirculationModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-circulation" class="d-flex flex-column gap-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">4. Status Disability</h5>

                                        <div class="form-group mb-3">
                                            <label class="form-label">GCS</label>
                                            <div class="input-group">
                                                @php
                                                    // Ambil data GCS dari database
                                                    $gcsValue = '';
                                                    if (isset($asesmen) && $asesmen->asesmenKepUmumDisability) {
                                                        $vitalSigns = json_decode($asesmen->asesmenKepUmumDisability->vital_sign, true);
                                                        $gcsValue = $vitalSigns['gcs'] ?? '';
                                                    }
                                                @endphp

                                                <input type="text" class="form-control" name="vital_sign[gcs]" id="gcsInput"
                                                    value="{{ old('vital_sign.gcs', $gcsValue) }}"
                                                    placeholder="Contoh: 15 E4 V5 M6" readonly>

                                                <button type="button" class="btn btn-outline-primary"
                                                    onclick="openGCSModal()" title="Buka Kalkulator GCS">
                                                    <i class="ti-calculator"></i> Hitung GCS
                                                </button>
                                            </div>

                                            @push('modals')
                                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.edit-gcs-modal')
                                            @endpush
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesadaran</label>
                                            <select class="form-select" name="disability_kesadaran">
                                                <option value="">--Pilih--</option>
                                                <option value="Compos Mentis" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Compos Mentis' ? 'selected' : '' }}>
                                                    Compos Mentis</option>
                                                <option value="Apatis" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Apatis' ? 'selected' : '' }}>
                                                    Apatis</option>
                                                <option value="Somnolen" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Somnolen' ? 'selected' : '' }}>
                                                    Somnolen</option>
                                                <option value="Sopor" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Sopor' ? 'selected' : '' }}>
                                                    Sopor</option>
                                                <option value="Coma" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Coma' ? 'selected' : '' }}>
                                                    Coma</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pupil</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Isokor/Anisokor</small>
                                                    </div>
                                                    <select class="form-select" name="disability_isokor">
                                                        <option value="">--Pilih--</option>
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumDisability)->disability_isokor == '1' ? 'selected' : '' }}>
                                                            Isokor</option>
                                                        <option value="2" {{ optional($asesmen->asesmenKepUmumDisability)->disability_isokor == '2' ? 'selected' : '' }}>
                                                            Anisokor</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Respon Cahaya</small>
                                                    </div>
                                                    <select class="form-select" name="disability_respon_cahaya">
                                                        <option value="">--Pilih--</option>
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumDisability)->disability_respon_cahaya == '1' ? 'selected' : '' }}>
                                                            Ya</option>
                                                        <option value="0" {{ optional($asesmen->asesmenKepUmumDisability)->disability_respon_cahaya == '0' ? 'selected' : '' }}>
                                                            Tidak</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diameter Pupil (mm)</label>
                                            <input type="text" class="form-control" name="disability_diameter_pupil"
                                                value="{{ optional($asesmen->asesmenKepUmumDisability)->disability_diameter_pupil }}">
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Ekstremitas</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Motorik</small>
                                                    </div>
                                                    <select class="form-select" name="disability_motorik">
                                                        <option value="">--Pilih--</option>
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumDisability)->disability_motorik == '1' ? 'selected' : '' }}>
                                                            Ya</option>
                                                        <option value="0" {{ optional($asesmen->asesmenKepUmumDisability)->disability_motorik == '0' ? 'selected' : '' }}>
                                                            Tidak</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Sensorik</small>
                                                    </div>
                                                    <select class="form-select" name="disability_sensorik">
                                                        <option value="">--Pilih--</option>
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumDisability)->disability_sensorik == '1' ? 'selected' : '' }}>
                                                            Ya</option>
                                                        <option value="0" {{ optional($asesmen->asesmenKepUmumDisability)->disability_sensorik == '0' ? 'selected' : '' }}>
                                                            Tidak</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kekuatan Otot</label>
                                            <input class="form-control" type="text" name="disability_kekuatan_otot"
                                                value="{{ optional($asesmen->asesmenKepUmumDisability)->disability_kekuatan_otot }}">
                                        </div>
                                        <div class="form-group diagnosis-section">
                                            <label style="min-width: 200px;">Diagnosis Keperawatan</label>
                                            <div class="w-100">
                                                <div class="diagnosis-item">
                                                    <!-- Diagnosis 1: Perfusi Jaringan Cereberal -->
                                                    <div class="diagnosis-row border-top border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="perfusi_jaringan_cereberal_tidak_efektif"
                                                                    name="disability_diagnosis_perfusi[]"
                                                                    value="perfusi_jaringan_cereberal_tidak_efektif" {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_perfusi) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="disability_diagnosis_perfusi"
                                                                    value="{{ $asesmen->asesmenKepUmumDisability->disability_diagnosis_perfusi ?? '' }}">

                                                                <label class="form-check-label"
                                                                    for="perfusi_jaringan_cereberal_tidak_efektif">
                                                                    Perfusi jaringan cereberal tidak efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual"
                                                                        name="disability_diagnosis_perfusi_type" value="1"
                                                                        {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_perfusi == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_perfusi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko"
                                                                        name="disability_diagnosis_perfusi_type" value="2"
                                                                        {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_perfusi == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_perfusi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_risiko">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 2: Intoleransi Aktivitas -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="intoleransi_aktivitas"
                                                                    name="disability_diagnosis_intoleransi[]"
                                                                    value="intoleransi_aktivitas" {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_intoleransi) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="disability_diagnosis_intoleransi"
                                                                    value="{{ $asesmen->asesmenKepUmumDisability->disability_diagnosis_intoleransi ?? '' }}">
                                                                <label class="form-check-label" for="intoleransi_aktivitas">
                                                                    Intoleransi aktivitas
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_1"
                                                                        name="disability_diagnosis_intoleransi_type"
                                                                        value="1" {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_intoleransi == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_intoleransi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_1"
                                                                        name="disability_diagnosis_intoleransi_type"
                                                                        value="2" {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_intoleransi == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_intoleransi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_risiko_1">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 3: Kendala Komunikasi Verbal -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="kendala_komunikasi_verbal"
                                                                    name="disability_diagnosis_komunikasi[]"
                                                                    value="kendala_komunikasi_verbal" {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_komunikasi) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="disability_diagnosis_komunikasi"
                                                                    value="{{ $asesmen->asesmenKepUmumDisability->disability_diagnosis_komunikasi ?? '' }}">
                                                                <label class="form-check-label"
                                                                    for="kendala_komunikasi_verbal">
                                                                    Kendala komunikasi verbal
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_2"
                                                                        name="disability_diagnosis_komunikasi_type"
                                                                        value="1" {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_komunikasi == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_komunikasi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual_2">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_2"
                                                                        name="disability_diagnosis_komunikasi_type"
                                                                        value="2" {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_komunikasi == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_komunikasi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_risiko_2">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 4: Kejang Ulang -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="kejang_ulang" name="disability_diagnosis_kejang[]"
                                                                    value="kejang_ulang" {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_kejang) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="disability_diagnosis_perfusi"
                                                                    value="{{ $asesmen->asesmenKepUmumDisability->disability_diagnosis_kejang ?? '' }}">
                                                                <label class="form-check-label" for="kejang_ulang">
                                                                    Kejang ulang
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_3"
                                                                        name="disability_diagnosis_kejang_type" value="1" {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_kejang == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_kejang) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual_3">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_3"
                                                                        name="disability_diagnosis_kejang_type" value="2" {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_kejang == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_kejang) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_risiko_3">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 5: Penurunan Kesadaran -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="penurunan_kesadaran"
                                                                    name="disability_diagnosis_kesadaran[]"
                                                                    value="penurunan_kesadaran" {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_kesadaran) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="disability_diagnosis_kesadaran"
                                                                    value="{{ $asesmen->asesmenKepUmumDisability->disability_diagnosis_kesadaran ?? '' }}">
                                                                <label class="form-check-label" for="penurunan_kesadaran">
                                                                    Penurunan kesadaran
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_4"
                                                                        name="disability_diagnosis_kesadaran_type" value="1"
                                                                        {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_kesadaran == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_kesadaran) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual_4">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_4"
                                                                        name="disability_diagnosis_kesadaran_type" value="2"
                                                                        {{ $asesmen->asesmenKepUmumDisability && $asesmen->asesmenKepUmumDisability->disability_diagnosis_kesadaran == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_kesadaran) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="disability_risiko_4">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Input untuk diagnosis lainnya -->
                                                <div class="mt-3">
                                                    <label class="form-label">Lainnya:</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="isikan jika ada diagnosis lainnya"
                                                        name="disability_lainnya"
                                                        value="{{ optional($asesmen->asesmenKepUmumDisability)->disability_lainnya }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tindakan Keperawatan</label>
                                            <div class="w-100">
                                                <input type="hidden" id="existingTindakan-disability"
                                                    value='{{ optional($asesmen->asesmenKepUmumDisability)->disability_tindakan ?? '[]' }}'>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-disability mb-3"
                                                    data-bs-target="#tindakanKeperawatanDisabilityModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-disability" class="d-flex flex-column gap-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">5. Status Exposure</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Deformitas</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="deformitas_tidak"
                                                            name="exposure_deformitas" value="0" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_deformitas == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="deformitas_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="deformitas_ya"
                                                            name="exposure_deformitas" value="1" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_deformitas == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="deformitas_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control"
                                                        name="exposure_deformitas_daerah" placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_deformitas_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kontusion</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="kontusion_tidak"
                                                            name="exposure_kontusion" value="0" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_kontusion == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kontusion_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="kontusion_ya"
                                                            name="exposure_kontusion" value="1" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_kontusion == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kontusion_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="exposure_kontusion_daerah"
                                                        placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_kontusion_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Abrasi</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="abrasi_tidak"
                                                            name="exposure_abrasi" value="0" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_abrasi == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="abrasi_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="abrasi_ya"
                                                            name="exposure_abrasi" value="1" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_abrasi == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="abrasi_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="exposure_abrasi_daerah"
                                                        placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_abrasi_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Penetrasi</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="penetrasi_tidak"
                                                            name="exposure_penetrasi" value="0" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_penetrasi == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="penetrasi_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="penetrasi_ya"
                                                            name="exposure_penetrasi" value="1" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_penetrasi == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="penetrasi_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="exposure_penetrasi_daerah"
                                                        placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_abrasi_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Laserasi</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="laserasi_tidak"
                                                            name="exposure_laserasi" value="0" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_laserasi == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="laserasi_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="laserasi_ya"
                                                            name="exposure_laserasi" value="1" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_laserasi == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="laserasi_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="exposure_laserasi_daerah"
                                                        placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_laserasi_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Edema</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="edema_tidak"
                                                            name="exposure_edema" value="0" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_edema == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="edema_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="edema_ya"
                                                            name="exposure_edema" value="1" {{ optional($asesmen->asesmenKepUmumExposure)->exposure_edema == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="edema_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="exposure_edema_daerah"
                                                        placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_edema_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kedalaman luka (cm)</label>
                                            <input type="number" class="form-control" name="exposure_kedalaman_luka"
                                                value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_kedalaman_luka }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <input type="text" class="form-control" name="exposure_lainnya"
                                                value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_lainnya }}">
                                        </div>

                                        <div class="form-group diagnosis-section">
                                            <label style="min-width: 200px;">Diagnosis Keperawatan</label>
                                            <div class="w-100">
                                                <div class="diagnosis-item">
                                                    <!-- Diagnosis 1: Mobilitas Fisik -->
                                                    <div class="diagnosis-row border-top border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="kerusakan_mobilitas_fisik"
                                                                    name="exposure_diagnosis_mobilitasi[]"
                                                                    value="mobilitasi_type" {{ !empty($asesmen->asesmenKepUmumExposure->exposure_diagnosis_mobilitasi) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="exposure_diagnosis_mobilitasi"
                                                                    value="{{ $asesmen->asesmenKepUmumExposure->exposure_diagnosis_mobilitasi ?? '' }}">
                                                                <label class="form-check-label"
                                                                    for="kerusakan_mobilitas_fisik">
                                                                    Kerusakan Mobilitas Fisik
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_aktual"
                                                                        name="exposure_diagnosis_mobilitasi_type" value="1"
                                                                        {{ $asesmen->asesmenKepUmumExposure && $asesmen->asesmenKepUmumExposure->exposure_diagnosis_mobilitasi == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumExposure->exposure_diagnosis_mobilitasi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="exposure_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_risiko"
                                                                        name="exposure_diagnosis_mobilitasi_type" value="2"
                                                                        {{ $asesmen->asesmenKepUmumExposure && $asesmen->asesmenKepUmumExposure->exposure_diagnosis_mobilitasi == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumExposure->exposure_diagnosis_mobilitasi) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="exposure_risiko">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 2: Integritas Jaringan -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="kerusakan_integritas_jaringan"
                                                                    name="exposure_diagosis_integritas[]"
                                                                    value="integritas_type" {{ !empty($asesmen->asesmenKepUmumExposure->exposure_diagosis_integritas) ? 'checked' : '' }}>
                                                                <!-- Hidden input untuk menjaga nilai saat ini -->
                                                                <input type="hidden" name="exposure_diagosis_integritas"
                                                                    value="{{ $asesmen->asesmenKepUmumExposure->exposure_diagosis_integritas ?? '' }}">
                                                                <label class="form-check-label"
                                                                    for="kerusakan_integritas_jaringan">
                                                                    Kerusakan Integritas Jaringan
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_aktual_1"
                                                                        name="exposure_diagosis_integritas_type" value="1"
                                                                        {{ $asesmen->asesmenKepUmumExposure && $asesmen->asesmenKepUmumExposure->exposure_diagosis_integritas == '1' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumExposure->exposure_diagosis_integritas) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="exposure_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_risiko_1"
                                                                        name="exposure_diagosis_integritas_type" value="2"
                                                                        {{ $asesmen->asesmenKepUmumExposure && $asesmen->asesmenKepUmumExposure->exposure_diagosis_integritas == '2' ? 'checked' : '' }} {{ empty($asesmen->asesmenKepUmumExposure->exposure_diagosis_integritas) ? 'disabled' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="exposure_risiko_1">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diagnosis Lainnya -->
                                                <div class="mt-3">
                                                    <label class="form-label">Lainnya:</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="isikan jika ada diagnosis lainnya"
                                                        name="exposure_diagnosis_lainnya"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_diagnosis_lainnya }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tindakan Keperawatan</label>
                                            <div class="w-100">
                                                <input type="hidden" id="existingTindakan-exposure"
                                                    value='{{ optional($asesmen->asesmenKepUmumExposure)->exposure_tindakan ?? '[]' }}'>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-exposure mb-3"
                                                    data-bs-target="#tindakanKeperawatanExposureModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-exposure" class="d-flex flex-column gap-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">6. Skala Nyeri</h5>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start gap-4">
                                                    <div class="d-flex align-items-center gap-3" style="min-width: 350px;">
                                                        <input type="number"
                                                            class="form-control flex-grow-1 @error('skala_nyeri') is-invalid @enderror"
                                                            name="skala_nyeri" style="width: 100px;"
                                                            value="{{ old('skala_nyeri', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri ?? 0) }}"
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
                                                                value="{{ old('skala_nyeri_nilai', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_nilai ?? 0) }}"
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
                                                        alt="Wong Baker Pain Scale" style="width: 450px; height: auto;">
                                                </div>

                                                <div id="numericScale" class="pain-scale-image flex-grow-1"
                                                    style="display: none;">
                                                    <img src="{{ asset('assets/img/asesmen/numerik.png') }}"
                                                        alt="Numeric Pain Scale" style="width: 450px; height: auto;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Lokasi</label>
                                                    <input type="text" class="form-control" name="skala_nyeri_lokasi"
                                                        value="{{ old('skala_nyeri_lokasi', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_lokasi ?? '') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Pemberat</label>
                                                    <select class="form-select" name="skala_nyeri_pemberat_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($faktorPemberat as $pemberat)
                                                            <option value="{{ $pemberat->id }}" {{ old('skala_nyeri_pemberat_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_pemberat_id ?? '') == $pemberat->id ? 'selected' : '' }}>
                                                                {{ $pemberat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Kualitas</label>
                                                    <select class="form-select" name="skala_nyeri_kualitas_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($kualitasNyeri as $kualitas)
                                                            <option value="{{ $kualitas->id }}" {{ old('skala_nyeri_kualitas_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_kualitas_id ?? '') == $kualitas->id ? 'selected' : '' }}>
                                                                {{ $kualitas->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Menjalar</label>
                                                    <select class="form-select" name="skala_nyeri_menjalar_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($menjalar as $menj)
                                                            <option value="{{ $menj->id }}" {{ old('skala_nyeri_menjalar_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_menjalar_id ?? '') == $menj->id ? 'selected' : '' }}>
                                                                {{ $menj->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Durasi</label>
                                                    <input type="text" class="form-control" name="skala_nyeri_durasi"
                                                        value="{{ old('skala_nyeri_durasi', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_durasi ?? '') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Peringan</label>
                                                    <select class="form-select" name="skala_nyeri_peringan_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($faktorPeringan as $peringan)
                                                            <option value="{{ $peringan->id }}" {{ old('skala_nyeri_peringan_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_peringan_id ?? '') == $peringan->id ? 'selected' : '' }}>
                                                                {{ $peringan->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Frekuensi</label>
                                                    <select class="form-select" name="skala_nyeri_frekuensi_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($frekuensiNyeri as $frekuensi)
                                                            <option value="{{ $frekuensi->id }}" {{ old('skala_nyeri_frekuensi_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_frekuensi_id ?? '') == $frekuensi->id ? 'selected' : '' }}>
                                                                {{ $frekuensi->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Jenis</label>
                                                    <select class="form-select" name="skala_nyeri_jenis_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($jenisNyeri as $jenis)
                                                            <option value="{{ $jenis->id }}" {{ old('skala_nyeri_jenis_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_jenis_id ?? '') == $jenis->id ? 'selected' : '' }}>
                                                                {{ $jenis->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">7. Risiko Jatuh</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan
                                                kondisi pasien:</label>
                                            <select class="form-select" id="risikoJatuhSkala" name="resiko_jatuh_jenis"
                                                onchange="showForm(this.value)">
                                                <option value="">--Pilih Skala--</option>
                                                <option value="1" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '1' ? 'selected' : '' }}>
                                                    Skala Umum</option>
                                                <option value="2" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '2' ? 'selected' : '' }}>
                                                    Skala Morse</option>
                                                <option value="3" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '3' ? 'selected' : '' }}>
                                                    Skala Humpty-Dumpty / Pediatrik</option>
                                                <option value="4" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '4' ? 'selected' : '' }}>
                                                    Skala Ontario Modified Stratify Sydney / Lansia</option>
                                                <option value="5" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '5' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>

                                        <!-- Form Skala Umum 1 -->
                                        <div id="skala_umumForm" class="risk-form"
                                            style="display: {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '1' ? 'block' : 'none' }}">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Umum</h5>

                                            <!-- Usia -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien berusia < dari 2 tahun?</label>
                                                        <select class="form-select" name="risiko_jatuh_umum_usia"
                                                            onchange="updateConclusion('umum')">
                                                            <option value="">pilih</option>
                                                            <option value="1" {{ old('risiko_jatuh_umum_usia', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_usia ?? '') == '1' ? 'selected' : '' }}>
                                                                Ya</option>
                                                            <option value="0" {{ old('risiko_jatuh_umum_usia', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_usia ?? '') == '0' ? 'selected' : '' }}>
                                                                Tidak</option>
                                                        </select>
                                            </div>

                                            <!-- Kondisi Khusus -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien dalam kondisi sebagai geriatri,
                                                    dizzines, vertigo, gangguan keseimbangan, gangguan penglihatan,
                                                    penggunaan obat sedasi, status kesadaran dan atau kejiwaan, konsumsi
                                                    alkohol?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_kondisi_khusus"
                                                    onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_umum_kondisi_khusus', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kondisi_khusus ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_umum_kondisi_khusus', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kondisi_khusus ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Diagnosis Parkinson -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien didiagnosis sebagai pasien dengan
                                                    penyakit parkinson?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_diagnosis_parkinson"
                                                    onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_umum_diagnosis_parkinson', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_umum_diagnosis_parkinson', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Pengobatan Berisiko -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien sedang mendapatkan obat sedasi,
                                                    riwayat tirah baring lama, perubahan posisi yang akan meningkatkan
                                                    risiko jatuh?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_pengobatan_berisiko"
                                                    onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_umum_pengobatan_berisiko', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_umum_pengobatan_berisiko', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Lokasi Berisiko -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien saat ini sedang berada pada salah
                                                    satu lokasi ini: rehab medik, ruangan dengan penerangan kurang dan
                                                    bertangga?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_lokasi_berisiko"
                                                    onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_umum_lokasi_berisiko', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_umum_lokasi_berisiko', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">{{ old('risiko_jatuh_umum_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kesimpulan ?? 'Tidak berisiko jatuh') }}</span>
                                                </p>
                                                <input type="hidden" name="risiko_jatuh_umum_kesimpulan"
                                                    id="risiko_jatuh_umum_kesimpulan"
                                                    value="{{ old('risiko_jatuh_umum_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kesimpulan ?? '') }}">
                                            </div>
                                        </div>

                                        <!-- Form Skala Morse 2 -->
                                        <div id="skala_morseForm" class="risk-form"
                                            style="display: {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '2' ? 'block' : 'none' }}">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Morse</h5>

                                            <!-- Riwayat Jatuh -->
                                            <div class="mb-3">
                                                <label class="form-label">Pasien pernah mengalami Jatuh?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_riwayat_jatuh"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="25" {{ old('risiko_jatuh_morse_riwayat_jatuh', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh ?? '') == '25' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_riwayat_jatuh', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Diagnosis Sekunder -->
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki diagnosis skunder?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_diagnosis_sekunder"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="15" {{ old('risiko_jatuh_morse_diagnosis_sekunder', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder ?? '') == '15' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_diagnosis_sekunder', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Bantuan Ambulasi -->
                                            <div class="mb-3">
                                                <label class="form-label">Pasien membutuhkan bantuan ambulasi?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_bantuan_ambulasi"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="30" {{ old('risiko_jatuh_morse_bantuan_ambulasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '') == '30' ? 'selected' : '' }}>
                                                        Meja/ kursi</option>
                                                    <option value="15" {{ old('risiko_jatuh_morse_bantuan_ambulasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '') == '15' ? 'selected' : '' }}>
                                                        Kruk/ tongkat/ alat bantu berjalan</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_bantuan_ambulasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak ada/ bed rest/ bantuan perawat</option>
                                                </select>
                                            </div>

                                            <!-- Terpasang Infus -->
                                            <div class="mb-3">
                                                <label class="form-label">Pasien terpasang infus?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_terpasang_infus"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="20" {{ old('risiko_jatuh_morse_terpasang_infus', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_terpasang_infus ?? '') == '20' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_terpasang_infus', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_terpasang_infus ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Cara Berjalan -->
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_cara_berjalan"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_cara_berjalan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '') == '0' ? 'selected' : '' }}>
                                                        Normal/ bed rest/ kursi roda</option>
                                                    <option value="20" {{ old('risiko_jatuh_morse_cara_berjalan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '') == '20' ? 'selected' : '' }}>
                                                        Terganggu</option>
                                                    <option value="10" {{ old('risiko_jatuh_morse_cara_berjalan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '') == '10' ? 'selected' : '' }}>
                                                        Lemah</option>
                                                </select>
                                            </div>

                                            <!-- Status Mental -->
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana status mental pasien?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_status_mental"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_status_mental', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_status_mental ?? '') == '0' ? 'selected' : '' }}>
                                                        Beroroentasi pada kemampuannya</option>
                                                    <option value="15" {{ old('risiko_jatuh_morse_status_mental', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_status_mental ?? '') == '15' ? 'selected' : '' }}>
                                                        Lupa akan keterbatasannya</option>
                                                </select>
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">{{ old('risiko_jatuh_morse_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_kesimpulan ?? 'Risiko Rendah') }}</span>
                                                </p>
                                                <input type="hidden" name="risiko_jatuh_morse_kesimpulan"
                                                    id="risiko_jatuh_morse_kesimpulan"
                                                    value="{{ old('risiko_jatuh_morse_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_kesimpulan ?? '') }}">
                                            </div>
                                        </div>

                                        <!-- Form Risiko Skala Humpty Dumpty 3 -->
                                        <div id="skala_humptyForm" class="risk-form"
                                            style="display: {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '3' ? 'block' : 'none' }}">
                                            <h5 class="mb-4">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik</h5>

                                            <!-- Usia Anak -->
                                            <div class="mb-3">
                                                <label class="form-label">Usia Anak?</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_usia_anak"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4" {{ old('risiko_jatuh_pediatrik_usia_anak', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak ?? '') == '4' ? 'selected' : '' }}>
                                                        Dibawah 3 tahun</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_usia_anak', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak ?? '') == '3' ? 'selected' : '' }}>
                                                        3-7 tahun</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_usia_anak', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak ?? '') == '2' ? 'selected' : '' }}>
                                                        7-13 tahun</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_usia_anak', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak ?? '') == '1' ? 'selected' : '' }}>
                                                        Diatas 13 tahun</option>
                                                </select>
                                            </div>

                                            <!-- Jenis Kelamin -->
                                            <div class="mb-3">
                                                <label class="form-label">Jenis kelamin</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_jenis_kelamin"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_jenis_kelamin', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin ?? '') == '2' ? 'selected' : '' }}>
                                                        Laki-laki</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_jenis_kelamin', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin ?? '') == '1' ? 'selected' : '' }}>
                                                        Perempuan</option>
                                                </select>
                                            </div>

                                            <!-- Diagnosis -->
                                            <div class="mb-3">
                                                <label class="form-label">Diagnosis</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_diagnosis"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4" {{ old('risiko_jatuh_pediatrik_diagnosis', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis ?? '') == '4' ? 'selected' : '' }}>
                                                        Diagnosis Neurologis</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_diagnosis', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis ?? '') == '3' ? 'selected' : '' }}>
                                                        Perubahan oksigennasi (diangnosis respiratorik, dehidrasi, anemia,
                                                        syncope, pusing, dsb)</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_diagnosis', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis ?? '') == '2' ? 'selected' : '' }}>
                                                        Gangguan perilaku /psikiatri</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_diagnosis', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis ?? '') == '1' ? 'selected' : '' }}>
                                                        Diagnosis lainnya</option>
                                                </select>
                                            </div>

                                            <!-- Gangguan Kognitif -->
                                            <div class="mb-3">
                                                <label class="form-label">Gangguan Kognitif</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_gangguan_kognitif"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_gangguan_kognitif', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif ?? '') == '3' ? 'selected' : '' }}>
                                                        Tidak menyadari keterbatasan dirinya</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_gangguan_kognitif', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif ?? '') == '2' ? 'selected' : '' }}>
                                                        Lupa akan adanya keterbatasan</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_gangguan_kognitif', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif ?? '') == '1' ? 'selected' : '' }}>
                                                        Orientasi baik terhadap dari sendiri</option>
                                                </select>
                                            </div>

                                            <!-- Faktor Lingkungan -->
                                            <div class="mb-3">
                                                <label class="form-label">Faktor Lingkungan</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_faktor_lingkungan"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4" {{ old('risiko_jatuh_pediatrik_faktor_lingkungan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? '') == '4' ? 'selected' : '' }}>
                                                        Riwayat jatuh /bayi diletakkan di tempat tidur dewasa</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_faktor_lingkungan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? '') == '3' ? 'selected' : '' }}>
                                                        Pasien menggunakan alat bantu /bayi diletakkan di tempat tidur bayi
                                                        / perabot rumah</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_faktor_lingkungan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? '') == '2' ? 'selected' : '' }}>
                                                        Pasien diletakkan di tempat tidur</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_faktor_lingkungan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? '') == '1' ? 'selected' : '' }}>
                                                        Area di luar rumah sakit</option>
                                                </select>
                                            </div>

                                            <!-- Pembedahan -->
                                            <div class="mb-3">
                                                <label class="form-label">Pembedahan/ sedasi/ Anestesi</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_pembedahan"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_pembedahan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan ?? '') == '3' ? 'selected' : '' }}>
                                                        Dalam 24 jam</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_pembedahan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan ?? '') == '2' ? 'selected' : '' }}>
                                                        Dalam 48 jam</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_pembedahan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan ?? '') == '1' ? 'selected' : '' }}>
                                                        > 48 jam atau tidak menjalani pembedahan/sedasi/anestesi</option>
                                                </select>
                                            </div>

                                            <!-- Penggunaan Medika Mentosa -->
                                            <div class="mb-3">
                                                <label class="form-label">Penggunaan Medika mentosa</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_penggunaan_mentosa"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_penggunaan_mentosa', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa ?? '') == '3' ? 'selected' : '' }}>
                                                        Penggunaan multiple: sedative, obat hipnosis, barbiturate,
                                                        fenotiazi, antidepresan, pencahar, diuretik, narkose</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_penggunaan_mentosa', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa ?? '') == '2' ? 'selected' : '' }}>
                                                        Penggunaan salah satu obat diatas</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_penggunaan_mentosa', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa ?? '') == '1' ? 'selected' : '' }}>
                                                        Penggunaan medikasi lainnya/tidak ada mediksi</option>
                                                </select>
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">{{ old('risiko_jatuh_pediatrik_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan ?? 'Risiko Rendah') }}</span>
                                                </p>
                                                <input type="hidden" name="risiko_jatuh_pediatrik_kesimpulan"
                                                    id="risiko_jatuh_pediatrik_kesimpulan"
                                                    value="{{ old('risiko_jatuh_pediatrik_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan ?? '') }}">
                                            </div>
                                        </div>

                                        <div id="skala_ontarioForm" class="risk-form"
                                            style="display: {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '4' ? 'block' : 'none' }}">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify
                                                Sydney/ Lansia</h5>

                                            <!-- 1. Riwayat Jatuh -->
                                            <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                    jatuh?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_jatuh_saat_masuk_rs"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="6" {{ old('risiko_jatuh_lansia_jatuh_saat_masuk_rs', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs ?? '') == '6' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_jatuh_saat_masuk_rs', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki 2 kali atau apakah pasien
                                                    mengalami jatuh dalam 2 bulan terakhir ini/ diagnosis multiple?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_riwayat_jatuh_2_bulan"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="6" {{ old('risiko_jatuh_lansia_riwayat_jatuh_2_bulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan ?? '') == '6' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_riwayat_jatuh_2_bulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 2. Status Mental -->
                                            <h6 class="mb-3">2. Status Mental</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien bingung? (Tidak dapat membuat
                                                    keputusan, jaga jarak tempatnya, gangguan daya ingat)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_status_bingung"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="14" {{ old('risiko_jatuh_lansia_status_bingung', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_bingung ?? '') == '14' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_status_bingung', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_bingung ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan
                                                    waktu, tempat atau orang)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_status_disorientasi"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="14" {{ old('risiko_jatuh_lansia_status_disorientasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_disorientasi ?? '') == '14' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_status_disorientasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_disorientasi ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami agitasi? (keresahan,
                                                    gelisah, dan cemas)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_status_agitasi"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="14" {{ old('risiko_jatuh_lansia_status_agitasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_agitasi ?? '') == '14' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_status_agitasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_agitasi ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 3. Penglihatan -->
                                            <h6 class="mb-3">3. Penglihatan</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien memakai Kacamata?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_kacamata"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_kacamata', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kacamata ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_kacamata', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kacamata ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami kelainan
                                                    penglihatan/buram?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_kelainan_penglihatan"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_kelainan_penglihatan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_kelainan_penglihatan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mempunyai glukoma/ katarak/
                                                    degenerasi makula?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_glukoma"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_glukoma', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_glukoma ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_glukoma', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_glukoma ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 4. Kebiasaan Berkemih -->
                                            <h6 class="mb-3">4. Kebiasaan Berkemih</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah terdapat perubahan perilaku berkemih?
                                                    (frekuensi, urgensi, inkontinensia, noktura)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_perubahan_berkemih"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2" {{ old('risiko_jatuh_lansia_perubahan_berkemih', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih ?? '') == '2' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_perubahan_berkemih', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 5. Transfer -->
                                            <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                                tempat tidur)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_transfer_mandiri"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_mandiri', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri ?? '') == '0' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_mandiri', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                    pengawasan</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_transfer_bantuan_sedikit"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_transfer_bantuan_sedikit', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_bantuan_sedikit', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_transfer_bantuan_nyata"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2" {{ old('risiko_jatuh_lansia_transfer_bantuan_nyata', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata ?? '') == '2' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_bantuan_nyata', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                    total</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_transfer_bantuan_total"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_lansia_transfer_bantuan_total', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total ?? '') == '3' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_bantuan_total', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 6. Mobilitas Pasien -->
                                            <h6 class="mb-3">6. Mobilitas Pasien</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (dapat menggunakan alat bantu
                                                    jalan)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_mobilitas_mandiri"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_mandiri', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri ?? '') == '0' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_mandiri', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Berjalan dengan bantuan 1 orang
                                                    (verbal/fisik)</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_mobilitas_bantuan_1_orang"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_mobilitas_bantuan_1_orang', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang ?? '') == '1' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_bantuan_1_orang', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Menggunakan kursi roda</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_mobilitas_kursi_roda"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2" {{ old('risiko_jatuh_lansia_mobilitas_kursi_roda', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda ?? '') == '2' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_kursi_roda', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Imobilisasi</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_mobilitas_imobilisasi"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_lansia_mobilitas_imobilisasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi ?? '') == '3' ? 'selected' : '' }}>
                                                        Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_imobilisasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">{{ old('risiko_jatuh_lansia_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kesimpulan ?? 'Risiko Rendah') }}</span>
                                                </p>
                                                <input type="hidden" name="risiko_jatuh_lansia_kesimpulan"
                                                    id="risiko_jatuh_lansia_kesimpulan"
                                                    value="{{ old('risiko_jatuh_lansia_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kesimpulan ?? '') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h6 class="mb-3">Intervensi Risiko Jatuh</h6>
                                        <p class="mb-2">Tambah tindakan intervensi risiko jatuh:</p>

                                        <input type="hidden" id="existingTindakan-risikojatuh"
                                            value='{{ old('risik_jatuh_tindakan', optional($asesmen->asesmenKepUmumRisikoJatuh)->risik_jatuh_tindakan ?? '[]') }}'>

                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                            data-bs-target="#tindakanKeperawatanRisikoJatuhModal"
                                            data-section="risikojatuh">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedTindakanList-risikojatuh" class="d-flex flex-column gap-2">
                                            <!-- Will be populated by JavaScript -->
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">8. Status Psikologis</h5>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Kondisi psikologis</label>
                                        <select class="form-select" name="psikologis_kondisi">
                                            <option value="">--Pilih--</option>
                                            <option value="Tidak Ada Kelainan" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Tidak Ada Kelainan' ? 'selected' : '' }}>
                                                Tidak Ada Kelainan</option>
                                            <option value="Cemas" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Cemas' ? 'selected' : '' }}>
                                                Cemas</option>
                                            <option value="Takut" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Takut' ? 'selected' : '' }}>
                                                Takut</option>
                                            <option value="Marah" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Marah' ? 'selected' : '' }}>
                                                Marah</option>
                                            <option value="Sedih" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Sedih' ? 'selected' : '' }}>
                                                Sedih</option>
                                            <option value="Tenang" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Tenang' ? 'selected' : '' }}>
                                                Tenang</option>
                                            <option value="Tidak Semangat" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Tidak Semangat' ? 'selected' : '' }}>
                                                Tidak Semangat</option>
                                            <option value="Tertekan" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Tertekan' ? 'selected' : '' }}>
                                                Tertekan</option>
                                            <option value="Depresi" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Depresi' ? 'selected' : '' }}>
                                                Depresi</option>
                                            <option value="Sulit Tidur" {{ old('psikologis_kondisi', $asesmen->asesmenKepUmum->psikologis_kondisi ?? '') == 'Sulit Tidur' ? 'selected' : '' }}>
                                                Sulit Tidur</option>
                                        </select>
                                        @error('psikologis_kondisi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Potensi menyakiti diri sendiri/orang
                                            lain</label>
                                        <select class="form-select" name="psikologis_potensi_menyakiti">
                                            <option value="">--Pilih--</option>
                                            <option value="0" {{ old('psikologis_potensi_menyakiti', $asesmen->asesmenKepUmum->psikologis_potensi_menyakiti ?? '') == '0' ? 'selected' : '' }}>
                                                Tidak</option>
                                            <option value="1" {{ old('psikologis_potensi_menyakiti', $asesmen->asesmenKepUmum->psikologis_potensi_menyakiti ?? '') == '1' ? 'selected' : '' }}>
                                                Ya</option>
                                        </select>
                                        @error('psikologis_potensi_menyakiti')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Lainnya</label>
                                        <textarea class="form-control @error('psikologis_lainnya') is-invalid @enderror"
                                            name="psikologis_lainnya"
                                            rows="3">{{ old('psikologis_lainnya', $asesmen->asesmenKepUmum->psikologis_lainnya ?? '') }}</textarea>
                                        @error('psikologis_lainnya')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">9. Status Spiritual</h5>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Agama/Kepercayaan</label>
                                        <select class="form-select" name="spiritual_agama">
                                            <option value="">--Pilih--</option>
                                            @foreach ($agama as $agam)
                                                <option value="{{ $agam->kd_agama }}" {{ old('spiritual_agama', $asesmen->asesmenKepUmum->spiritual_agama ?? '') == $agam->kd_agama ? 'selected' : '' }}>
                                                    {{ $agam->agama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Nilai Nilai Spritiual Pasien</label>
                                        <textarea class="form-control" name="spiritual_nilai"
                                            rows="3">{{ old('spiritual_nilai', $asesmen->asesmenKepUmum->spiritual_nilai ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">10. Status Sosial Ekonomi</h5>

                                    <div class="form-group mb-3">
                                        <label class="form-label" style="min-width: 200px;">Pekerjaan</label>
                                        <select
                                            class="form-select select2 @error('sosial_ekonomi_pekerjaan') is-invalid @enderror"
                                            name="sosial_ekonomi_pekerjaan" id="sosial_pekerjaan">
                                            <option value="">--Pilih Pekerjaan--</option>
                                            @foreach ($pekerjaan as $kerjaan)
                                                <option value="{{ $kerjaan->kd_pekerjaan }}" {{ old('sosial_ekonomi_pekerjaan', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_pekerjaan ?? '') == $kerjaan->kd_pekerjaan ? 'selected' : '' }}>
                                                    {{ $kerjaan->pekerjaan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sosial_ekonomi_pekerjaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat penghasilan</label>
                                        <select
                                            class="form-select @error('sosial_ekonomi_tingkat_penghasilan') is-invalid @enderror"
                                            name="sosial_ekonomi_tingkat_penghasilan">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $penghasilanOptions = [
                                                    'Penghasilan Tinggi',
                                                    'Penghasilan Sedang',
                                                    'Penghasilan Rendah',
                                                    'Tidak Ada Penghasilan',
                                                ];
                                            @endphp
                                            @foreach ($penghasilanOptions as $option)
                                                <option value="{{ $option }}" {{ old('sosial_ekonomi_tingkat_penghasilan', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_tingkat_penghasilan ?? '') == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sosial_ekonomi_tingkat_penghasilan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status pernikahan</label>
                                        <select
                                            class="form-select @error('sosial_ekonomi_status_pernikahan') is-invalid @enderror"
                                            name="sosial_ekonomi_status_pernikahan">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $pernikahanOptions = [
                                                    '0' => 'Belum Kawin',
                                                    '1' => 'Kawin',
                                                    '2' => 'Janda',
                                                    '3' => 'Duda',
                                                ];
                                            @endphp
                                            @foreach ($pernikahanOptions as $value => $label)
                                                <option value="{{ $value }}" {{ old('sosial_ekonomi_status_pernikahan', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_status_pernikahan ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sosial_ekonomi_status_pernikahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status pendidikan</label>
                                        <select
                                            class="form-select @error('sosial_ekonomi_status_pendidikan') is-invalid @enderror"
                                            name="sosial_ekonomi_status_pendidikan">
                                            <option value="">--Pilih--</option>
                                            @foreach ($pendidikan as $pendidik)
                                                <option value="{{ $pendidik->kd_pendidikan }}" {{ old('sosial_ekonomi_status_pendidikan', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_status_pendidikan ?? '') == $pendidik->kd_pendidikan ? 'selected' : '' }}>
                                                    {{ $pendidik->pendidikan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sosial_ekonomi_status_pendidikan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tempat tinggal</label>
                                        <select
                                            class="form-select @error('sosial_ekonomi_tempat_tinggal') is-invalid @enderror"
                                            name="sosial_ekonomi_tempat_tinggal">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $tempatTinggalOptions = [
                                                    'Rumah Sendiri',
                                                    'Rumah Orang Tua',
                                                    'Tempat Lain',
                                                    'Tidak Ada Tempat Tinggal',
                                                ];
                                            @endphp
                                            @foreach ($tempatTinggalOptions as $option)
                                                <option value="{{ $option }}" {{ old('sosial_ekonomi_tempat_tinggal', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_tempat_tinggal ?? '') == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sosial_ekonomi_tempat_tinggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status tinggal dengan keluarga</label>
                                        <select
                                            class="form-select @error('sosial_ekonomi_tinggal_dengan_keluarga') is-invalid @enderror"
                                            name="sosial_ekonomi_tinggal_dengan_keluarga">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $tinggalDenganKeluargaOptions = [
                                                    'Dengan Keluarga',
                                                    'Tidak Dengan Keluarga',
                                                ];
                                            @endphp
                                            @foreach ($tinggalDenganKeluargaOptions as $option)
                                                <option value="{{ $option }}" {{ old('sosial_ekonomi_tinggal_dengan_keluarga', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_tinggal_dengan_keluarga ?? '') == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sosial_ekonomi_tinggal_dengan_keluarga')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Curiga penganiayaan</label>
                                        <select
                                            class="form-select @error('sosial_ekonomi_curiga_penganiayaan') is-invalid @enderror"
                                            name="sosial_ekonomi_curiga_penganiayaan">
                                            <option value="">--Pilih--</option>
                                            <option value="1" {{ old('sosial_ekonomi_curiga_penganiayaan', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_curiga_penganiayaan ?? '') == '1' ? 'selected' : '' }}>
                                                Ada</option>
                                            <option value="0" {{ old('sosial_ekonomi_curiga_penganiayaan', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_curiga_penganiayaan ?? '') == '0' ? 'selected' : '' }}>
                                                Tidak Ada</option>
                                        </select>
                                        @error('sosial_ekonomi_curiga_penganiayaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Ada kesulitan memenuhi kebutuhan dasar</label>
                                        <select class="form-select" name="sosial_ekonomi_curiga_kesulitan">
                                            <option value="">--Pilih--</option>
                                            <option value="1" {{ old('sosial_ekonomi_curiga_kesulitan', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_curiga_kesulitan ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                            <option value="0" {{ old('sosial_ekonomi_curiga_kesulitan', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_curiga_kesulitan ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hubungan dengan anggota keluarga</label>
                                        <select class="form-select" name="sosial_ekonomi_curiga_hubungan_keluarga">
                                            <option value="">--Pilih--</option>
                                            <option value="1" {{ old('sosial_ekonomi_curiga_hubungan_keluarga', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_curiga_hubungan_keluarga ?? '') == '1' ? 'selected' : '' }}>Baik</option>
                                            <option value="0" {{ old('sosial_ekonomi_curiga_hubungan_keluarga', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_curiga_hubungan_keluarga ?? '') == '0' ? 'selected' : '' }}>Tidak Baik</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Suku</label>
                                        <input type="text" class="form-control" name="sosial_ekonomi_curiga_suku"
                                            value="{{ old('sosial_ekonomi_curiga_suku', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_curiga_suku ?? '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Budaya</label>
                                        <input type="text" class="form-control" name="sosial_ekonomi_curiga_budaya"
                                            value="{{ old('sosial_ekonomi_curiga_budaya', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_curiga_budaya ?? '') }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lainnya</label>
                                        <textarea
                                            class="form-control @error('sosial_ekonomi_keterangan_lain') is-invalid @enderror"
                                            name="sosial_ekonomi_keterangan_lain"
                                            rows="3">{{ old('sosial_ekonomi_keterangan_lain', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_keterangan_lain ?? '') }}</textarea>
                                        @error('sosial_ekonomi_keterangan_lain')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">11. Status Gizi</h5>
                                    <div class="form-group mb-4">
                                        <select class="form-select @error('gizi_jenis') is-invalid @enderror"
                                            name="gizi_jenis" id="nutritionAssessment">
                                            <option value="">--Pilih--</option>
                                            <option value="1" {{ old('gizi_jenis', $asesmen->asesmenKepUmumGizi->gizi_jenis ?? '') == '1' ? 'selected' : '' }}>
                                                Malnutrition Screening Tool (MST)
                                            </option>
                                            <option value="2" {{ old('gizi_jenis', $asesmen->asesmenKepUmumGizi->gizi_jenis ?? '') == '2' ? 'selected' : '' }}>
                                                The Mini Nutritional Assessment (MNA)
                                            </option>
                                            <option value="3" {{ old('gizi_jenis', $asesmen->asesmenKepUmumGizi->gizi_jenis ?? '') == '3' ? 'selected' : '' }}>
                                                Strong Kids (1 bln - 18 Tahun)
                                            </option>
                                            <option value="5" {{ old('gizi_jenis', $asesmen->asesmenKepUmumGizi->gizi_jenis ?? '') == '5' ? 'selected' : '' }}>
                                                Tidak Dapat Dinilai
                                            </option>
                                        </select>
                                        @error('gizi_jenis')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- MST Form -->
                                    <div id="mst" class="assessment-form"
                                        style="display: {{ old('gizi_jenis', $asesmen->asesmenKepUmumGizi->gizi_jenis ?? '') == '1' ? 'block' : 'none' }};">
                                        <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak
                                                diinginkan dalam 6 bulan terakhir?</label>
                                            <select class="form-select @error('gizi_mst_penurunan_bb') is-invalid @enderror"
                                                name="gizi_mst_penurunan_bb">
                                                <option value="">pilih</option>
                                                <option value="0" {{ old('gizi_mst_penurunan_bb', $asesmen->asesmenKepUmumGizi->gizi_mst_penurunan_bb ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak ada penurunan Berat Badan (BB)
                                                </option>
                                                <option value="2" {{ old('gizi_mst_penurunan_bb', $asesmen->asesmenKepUmumGizi->gizi_mst_penurunan_bb ?? '') == '2' ? 'selected' : '' }}>
                                                    Tidak yakin/ tidak tahu/ terasa baju lebih longgar
                                                </option>
                                                <option value="3" {{ old('gizi_mst_penurunan_bb', $asesmen->asesmenKepUmumGizi->gizi_mst_penurunan_bb ?? '') == '3' ? 'selected' : '' }}>
                                                    Ya ada penurunan BB
                                                </option>
                                            </select>
                                            @error('gizi_mst_penurunan_bb')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB",
                                                berapa
                                                penurunan BB
                                                tersebut?</label>
                                            <select
                                                class="form-select @error('gizi_mst_jumlah_penurunan_bb') is-invalid @enderror"
                                                name="gizi_mst_jumlah_penurunan_bb">
                                                <option value="0">pilih</option>
                                                @php
                                                    $penurunanBBOptions = [
                                                        1 => '1-5 kg',
                                                        2 => '6-10 kg',
                                                        3 => '11-15 kg',
                                                        4 => '>15 kg',
                                                    ];
                                                @endphp
                                                @foreach ($penurunanBBOptions as $value => $label)
                                                    <option value="{{ $value }}" {{ old('gizi_mst_jumlah_penurunan_bb', $asesmen->asesmenKepUmumGizi->gizi_mst_jumlah_penurunan_bb ?? '') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('gizi_mst_jumlah_penurunan_bb')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu
                                                makan?</label>
                                            <select
                                                class="form-select @error('gizi_mst_nafsu_makan_berkurang') is-invalid @enderror"
                                                name="gizi_mst_nafsu_makan_berkurang">
                                                <option value="">pilih</option>
                                                <option value="1" {{ old('gizi_mst_nafsu_makan_berkurang', $asesmen->asesmenKepUmumGizi->gizi_mst_nafsu_makan_berkurang ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0" {{ old('gizi_mst_nafsu_makan_berkurang', $asesmen->asesmenKepUmumGizi->gizi_mst_nafsu_makan_berkurang ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                            @error('gizi_mst_nafsu_makan_berkurang')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer
                                                (kemoterapi), Geriatri, GGK (hemodialisis), Penurunan Imun</label>
                                            <select
                                                class="form-select @error('gizi_mst_diagnosis_khusus') is-invalid @enderror"
                                                name="gizi_mst_diagnosis_khusus">
                                                <option value="">pilih</option>
                                                <option value="1" {{ old('gizi_mst_diagnosis_khusus', $asesmen->asesmenKepUmumGizi->gizi_mst_diagnosis_khusus ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0" {{ old('gizi_mst_diagnosis_khusus', $asesmen->asesmenKepUmumGizi->gizi_mst_diagnosis_khusus ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                            @error('gizi_mst_diagnosis_khusus')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- Nilai -->
                                        <div id="mstConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success" style="display: none;">
                                                Kesimpulan: 0-1 tidak berisiko malnutrisi
                                            </div>
                                            <div class="alert alert-warning" style="display: none;">
                                                Kesimpulan: ≥ 2 berisiko malnutrisi
                                            </div>
                                            <input type="hidden" name="gizi_mst_kesimpulan" id="gizi_mst_kesimpulan"
                                                value="{{ old('gizi_mst_kesimpulan', $asesmen->asesmenKepUmumGizi->gizi_mst_kesimpulan ?? '') }}">
                                        </div>
                                    </div>

                                    <!-- MNA Form -->
                                    <div id="mna" class="assessment-form"
                                        style="display: {{ old('gizi_jenis', $asesmen->asesmenKepUmumGizi->gizi_jenis ?? '') == '2' ? 'block' : 'none' }};">
                                        <h6 class="mb-3">Penilaian Gizi The Mini Nutritional Assessment (MNA) / Lansia
                                        </h6>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah pasien mengalami penurunan asupan makanan selama 3 bulan terakhir
                                                karena hilang selera makan, masalah pencernaan, kesulitan mengunyah atau
                                                menelan?
                                            </label>
                                            <select
                                                class="form-select @error('gizi_mna_penurunan_asupan_3_bulan') is-invalid @enderror"
                                                name="gizi_mna_penurunan_asupan_3_bulan">
                                                <option value="">--Pilih--</option>
                                                <option value="0" {{ old('gizi_mna_penurunan_asupan_3_bulan', $asesmen->asesmenKepUmumGizi->gizi_mna_penurunan_asupan_3_bulan ?? '') == '0' ? 'selected' : '' }}>
                                                    Mengalami penurunan asupan makanan yang parah
                                                </option>
                                                <option value="1" {{ old('gizi_mna_penurunan_asupan_3_bulan', $asesmen->asesmenKepUmumGizi->gizi_mna_penurunan_asupan_3_bulan ?? '') == '1' ? 'selected' : '' }}>
                                                    Mengalami penurunan asupan makanan sedang
                                                </option>
                                                <option value="2" {{ old('gizi_mna_penurunan_asupan_3_bulan', $asesmen->asesmenKepUmumGizi->gizi_mna_penurunan_asupan_3_bulan ?? '') == '2' ? 'selected' : '' }}>
                                                    Tidak mengalami penurunan asupan makanan
                                                </option>
                                            </select>
                                            @error('gizi_mna_penurunan_asupan_3_bulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah pasien mengalami kehilangan Berat Badan (BB) selama 3 bulan terakhir?
                                            </label>
                                            <select
                                                class="form-select @error('gizi_mna_kehilangan_bb_3_bulan') is-invalid @enderror"
                                                name="gizi_mna_kehilangan_bb_3_bulan">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ old('gizi_mna_kehilangan_bb_3_bulan', $asesmen->asesmenKepUmumGizi->gizi_mna_kehilangan_bb_3_bulan ?? '') == '0' ? 'selected' : '' }}>
                                                    Kehilangan BB lebih dari 3 Kg
                                                </option>
                                                <option value="1" {{ old('gizi_mna_kehilangan_bb_3_bulan', $asesmen->asesmenKepUmumGizi->gizi_mna_kehilangan_bb_3_bulan ?? '') == '1' ? 'selected' : '' }}>
                                                    Tidak tahu
                                                </option>
                                                <option value="2" {{ old('gizi_mna_kehilangan_bb_3_bulan', $asesmen->asesmenKepUmumGizi->gizi_mna_kehilangan_bb_3_bulan ?? '') == '2' ? 'selected' : '' }}>
                                                    Kehilangan BB antara 1 s.d 3 Kg
                                                </option>
                                                <option value="3" {{ old('gizi_mna_kehilangan_bb_3_bulan', $asesmen->asesmenKepUmumGizi->gizi_mna_kehilangan_bb_3_bulan ?? '') == '3' ? 'selected' : '' }}>
                                                    Tidak ada kehilangan BB
                                                </option>
                                            </select>
                                            @error('gizi_mna_kehilangan_bb_3_bulan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana mobilisasi atau pergerakan pasien?</label>
                                            <select class="form-select @error('gizi_mna_mobilisasi') is-invalid @enderror"
                                                name="gizi_mna_mobilisasi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ old('gizi_mna_mobilisasi', $asesmen->asesmenKepUmumGizi->gizi_mna_mobilisasi ?? '') == '0' ? 'selected' : '' }}>
                                                    Hanya di tempat tidur atau kursi roda
                                                </option>
                                                <option value="1" {{ old('gizi_mna_mobilisasi', $asesmen->asesmenKepUmumGizi->gizi_mna_mobilisasi ?? '') == '1' ? 'selected' : '' }}>
                                                    Dapat turun dari tempat tidur tapi tidak dapat jalan-jalan
                                                </option>
                                                <option value="2" {{ old('gizi_mna_mobilisasi', $asesmen->asesmenKepUmumGizi->gizi_mna_mobilisasi ?? '') == '2' ? 'selected' : '' }}>
                                                    Dapat jalan-jalan
                                                </option>
                                            </select>
                                            @error('gizi_mna_mobilisasi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah Pasien mengalami stres psikologi atau penyakit akut selama 3 bulan
                                                terakhir?
                                            </label>
                                            <select
                                                class="form-select @error('gizi_mna_stress_penyakit_akut') is-invalid @enderror"
                                                name="gizi_mna_stress_penyakit_akut">
                                                <option value="">-- Pilih --</option>
                                                <option value="1" {{ old('gizi_mna_stress_penyakit_akut', $asesmen->asesmenKepUmumGizi->gizi_mna_stress_penyakit_akut ?? '') == '1' ? 'selected' : '' }}>
                                                    Tidak
                                                </option>
                                                <option value="0" {{ old('gizi_mna_stress_penyakit_akut', $asesmen->asesmenKepUmumGizi->gizi_mna_stress_penyakit_akut ?? '') == '0' ? 'selected' : '' }}>
                                                    Ya
                                                </option>
                                            </select>
                                            @error('gizi_mna_stress_penyakit_akut')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami masalah
                                                neuropsikologi?</label>
                                            <select
                                                class="form-select @error('gizi_mna_status_neuropsikologi') is-invalid @enderror"
                                                name="gizi_mna_status_neuropsikologi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ old('gizi_mna_status_neuropsikologi', $asesmen->asesmenKepUmumGizi->gizi_mna_status_neuropsikologi ?? '') == '0' ? 'selected' : '' }}>
                                                    Demensia atau depresi berat
                                                </option>
                                                <option value="1" {{ old('gizi_mna_status_neuropsikologi', $asesmen->asesmenKepUmumGizi->gizi_mna_status_neuropsikologi ?? '') == '1' ? 'selected' : '' }}>
                                                    Demensia ringan
                                                </option>
                                                <option value="2" {{ old('gizi_mna_status_neuropsikologi', $asesmen->asesmenKepUmumGizi->gizi_mna_status_neuropsikologi ?? '') == '2' ? 'selected' : '' }}>
                                                    Tidak mengalami masalah neuropsikologi
                                                </option>
                                            </select>
                                            @error('gizi_mna_status_neuropsikologi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                            <input type="number" name="gizi_mna_berat_badan"
                                                class="form-control @error('gizi_mna_berat_badan') is-invalid @enderror"
                                                id="mnaWeight" min="1" step="0.1"
                                                placeholder="Masukkan berat badan dalam Kg"
                                                value="{{ old('gizi_mna_berat_badan', $asesmen->asesmenKepUmumGizi->gizi_mna_berat_badan ?? '') }}">
                                            @error('gizi_mna_berat_badan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Tinggi Badan (TB) pasien? (cm)</label>
                                            <input type="number" name="gizi_mna_tinggi_badan"
                                                class="form-control @error('gizi_mna_tinggi_badan') is-invalid @enderror"
                                                id="mnaHeight" min="1" step="0.1"
                                                placeholder="Masukkan tinggi badan dalam cm"
                                                value="{{ old('gizi_mna_tinggi_badan', $asesmen->asesmenKepUmumGizi->gizi_mna_tinggi_badan ?? '') }}">
                                            @error('gizi_mna_tinggi_badan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- IMT -->
                                        <div class="mb-3">
                                            <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                            <div class="text-muted small mb-2">
                                                <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                            </div>
                                            <input type="number" name="gizi_mna_imt"
                                                class="form-control bg-light @error('gizi_mna_imt') is-invalid @enderror"
                                                id="mnaBMI" readonly placeholder="IMT akan terhitung otomatis"
                                                value="{{ old('gizi_mna_imt', $asesmen->asesmenKepUmumGizi->gizi_mna_imt ?? '') }}">
                                            @error('gizi_mna_imt')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Kesimpulan -->
                                        <div id="mnaConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success" style="display: none;">
                                                Kesimpulan: Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)
                                            </div>
                                            <div class="alert alert-warning" style="display: none;">
                                                Kesimpulan: Total Skor ≤ 11 (Beresiko Malnutrisi)
                                            </div>
                                            <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan"
                                                value="{{ old('gizi_mna_kesimpulan', $asesmen->asesmenKepUmumGizi->gizi_mna_kesimpulan ?? '') }}">
                                        </div>
                                    </div>

                                    <!-- Strong Kids Form -->
                                    <div id="strong-kids" class="assessment-form"
                                        style="display: {{ old('gizi_jenis', $asesmen->asesmenKepUmumGizi->gizi_jenis ?? '') == '3' ? 'block' : 'none' }};">
                                        <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah anak tampak kurus kehilangan lemak subkutan,
                                                kehilangan massa otot, dan/ atau wajah cekung?</label>
                                            <select
                                                class="form-select @error('gizi_strong_status_kurus') is-invalid @enderror"
                                                name="gizi_strong_status_kurus">
                                                <option value="">pilih</option>
                                                <option value="1" {{ old('gizi_strong_status_kurus', $asesmen->asesmenKepUmumGizi->gizi_strong_status_kurus ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0" {{ old('gizi_strong_status_kurus', $asesmen->asesmenKepUmumGizi->gizi_strong_status_kurus ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                            @error('gizi_strong_status_kurus')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penurunan BB selama satu bulan
                                                terakhir (untuk semua usia)?
                                                (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif dari
                                                orang tua pasien ATAU
                                                tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1 tahun)
                                                    selama 3 bulan terakhir)</label>
                                                    <select
                                                        class="form-select @error('gizi_strong_penurunan_bb') is-invalid @enderror"
                                                        name="gizi_strong_penurunan_bb">
                                                        <option value="">pilih</option>
                                                        <option value="1" {{ old('gizi_strong_penurunan_bb', $asesmen->asesmenKepUmumGizi->gizi_strong_penurunan_bb ?? '') == '1' ? 'selected' : '' }}>
                                                            Ya</option>
                                                        <option value="0" {{ old('gizi_strong_penurunan_bb', $asesmen->asesmenKepUmumGizi->gizi_strong_penurunan_bb ?? '') == '0' ? 'selected' : '' }}>
                                                            Tidak</option>
                                                    </select>
                                                    @error('gizi_strong_penurunan_bb')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah salah satu dari hal berikut ini ada?<br>
                                                - Diare berlebihan (>= 5 kali perhari) dan/atau muntah(>3 kali perhari)
                                                selama 1-3 hari terakhir<br>
                                                - Penurunan asupan makanan selama 1-3 hari terakhir<br>
                                                - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau pemberian
                                                makan selang)</label>
                                            <select
                                                class="form-select @error('gizi_strong_gangguan_pencernaan') is-invalid @enderror"
                                                name="gizi_strong_gangguan_pencernaan">
                                                <option value="">pilih</option>
                                                <option value="1" {{ old('gizi_strong_gangguan_pencernaan', $asesmen->asesmenKepUmumGizi->gizi_strong_gangguan_pencernaan ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0" {{ old('gizi_strong_gangguan_pencernaan', $asesmen->asesmenKepUmumGizi->gizi_strong_gangguan_pencernaan ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                            @error('gizi_strong_gangguan_pencernaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penyakit atau keadaan yang
                                                mengakibatkan pasien berisiko mengalami malnutrisi?<br>
                                                <a href="#"><i>Lihat penyakit yang berisiko
                                                        malnutrisi</i></a></label>
                                            <select
                                                class="form-select @error('gizi_strong_penyakit_berisiko') is-invalid @enderror"
                                                name="gizi_strong_penyakit_berisiko">
                                                <option value="">pilih</option>
                                                <option value="2" {{ old('gizi_strong_penyakit_berisiko', $asesmen->asesmenKepUmumGizi->gizi_strong_penyakit_berisiko ?? '') == '2' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0" {{ old('gizi_strong_penyakit_berisiko', $asesmen->asesmenKepUmumGizi->gizi_strong_penyakit_berisiko ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                            @error('gizi_strong_penyakit_berisiko')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Nilai -->
                                        <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success" style="display: none;">
                                                Kesimpulan: 0 (Beresiko rendah)
                                            </div>
                                            <div class="alert alert-warning" style="display: none;">
                                                Kesimpulan: 1-3 (Beresiko sedang)
                                            </div>
                                            <div class="alert alert-danger" style="display: none;">
                                                Kesimpulan: 4-5 (Beresiko Tinggi)
                                            </div>
                                            <input type="hidden" name="gizi_strong_kesimpulan" id="gizi_strong_kesimpulan"
                                                value="{{ old('gizi_strong_kesimpulan', $asesmen->asesmenKepUmumGizi->gizi_strong_kesimpulan ?? '') }}">
                                        </div>
                                    </div>

                                    <!-- Form NRS -->
                                    <div id="nrs" class="risk-form"
                                        style="display: {{ old('gizi_jenis', $asesmen->asesmenKepUmumGizi->gizi_jenis ?? '') == '4' ? 'block' : 'none' }};">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify
                                            Sydney/
                                            Lansia</h5>

                                        <!-- 1. Riwayat Jatuh -->
                                        <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                jatuh?</label>
                                            <select class="form-select" name="gizi_nrs_jatuh_saat_masuk_rs"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien memiliki jika tidak, apakah pasien
                                                mengalami
                                                jatuh dalam 2 bulan
                                                terakhir ini? diagnosis skunder?</label>
                                            <select class="form-select" name="gizi_nrs_jatuh_2_bulan_terakhir"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 2. Status Mental -->
                                        <h6 class="mb-3">2. Status Mental</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien delirium? (Tidak dapat membuat
                                                keputusan, pola pikir tidak
                                                terorganisir, gangguan daya ingat)</label>
                                            <select class="form-select" name="gizi_nrs_status_delirium"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien disorientasi? (tidak
                                                menyadarkan
                                                waktu, tempat atau
                                                orang)</label>
                                            <select class="form-select" name="gizi_nrs_status_disorientasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami agitasi? (keresahan,
                                                gelisah, dan
                                                cemas)</label>
                                            <select class="form-select" name="gizi_nrs_status_agitasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 3. Penglihatan -->
                                        <h6 class="mb-3">3. Penglihatan</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien memakai kacamata?</label>
                                            <select class="form-select" name="gizi_nrs_menggunakan_kacamata"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengaluh adanya penglihatan
                                                buram?</label>
                                            <select class="form-select" name="gizi_nrs_keluhan_penglihatan_buram"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien menpunyai glaukoma/ katarak/
                                                degenerasi makula?</label>
                                            <select class="form-select" name="gizi_nrs_degenerasi_makula"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 4. Kebiasaan Berkemih -->
                                        <h6 class="mb-3">4. Kebiasaan Berkemih</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat perubahan perilaku berkemih?
                                                (frekuensi, urgensi,
                                                inkontinensia, nokturia)</label>
                                            <select class="form-select" name="gizi_nrs_perubahan_berkemih"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur) -->
                                        <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali
                                            lagi ke
                                            tempat tidur)</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Mandiri (boleh menolak saat bantu
                                                jatuh)</label>
                                            <select class="form-select" name="gizi_nrs_transfer_mandiri"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="0">Ya</option>
                                                <option value="1">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                pengawasan</label>
                                            <select class="form-select" name="gizi_nrs_transfer_bantuan_1_orang"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan bantuan yang nyata (2
                                                orang)</label>
                                            <select class="form-select" name="gizi_nrs_transfer_bantuan_2_orang"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tidak dapat duduk dengan seimbang, perlu
                                                bantuan
                                                total</label>
                                            <select class="form-select" name="gizi_nrs_transfer_bantuan_total"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 6. Mobilitas Pasien -->
                                        <h6 class="mb-3">6. Mobilitas Pasien</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Mandiri (dapat menggunakan alat bantu
                                                jalan)</label>
                                            <select class="form-select" name="gizi_nrs_mobilitas_mandiri"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="0">Ya</option>
                                                <option value="1">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                                fisik)</label>
                                            <select class="form-select" name="gizi_nrs_mobilitas_bantuan_1_orang"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Menggunakan kusi roda</label>
                                            <select class="form-select" name="gizi_nrs_mobilitas_kursi_roda"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Imobilisasi</label>
                                            <select class="form-select" name="gizi_nrs_mobilitas_imobilisasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="nrsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success">Kesimpulan: Beresiko rendah</div>
                                            <div class="alert alert-warning">Kesimpulan: Beresiko sedang</div>
                                            <div class="alert alert-danger">Kesimpulan: Beresiko Tinggi</div>
                                            <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan">
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">12. Status Fungsional</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status Fungsional</label>
                                        <select class="form-select @error('status_fungsional') is-invalid @enderror"
                                            name="status_fungsional">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $statusFungsionalOptions = [
                                                    'Mandiri',
                                                    'Ketergantungan Ringan',
                                                    'Ketergantungan Sedang',
                                                    'Ketergantungan Berat',
                                                    'Ketergantungan Total',
                                                ];
                                            @endphp
                                            @foreach ($statusFungsionalOptions as $option)
                                                <option value="{{ $option }}" {{ old('status_fungsional', $asesmen->asesmenKepUmum->status_fungsional ?? '') == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status_fungsional')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">13. Kebutuhan Edukasi, Pendidikan dan Pengajaran</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gaya bicara</label>
                                        <select
                                            class="form-select @error('kebutuhan_edukasi_gaya_bicara') is-invalid @enderror"
                                            name="kebutuhan_edukasi_gaya_bicara">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $gayaBicaraOptions = [
                                                    '0' => 'Normal',
                                                    '1' => 'Tidak Normal',
                                                    '2' => 'Belum Bisa Bicara',
                                                ];
                                            @endphp
                                            @foreach ($gayaBicaraOptions as $value => $label)
                                                <option value="{{ $value }}" {{ old('kebutuhan_edukasi_gaya_bicara', $asesmen->asesmenKepUmum->kebutuhan_edukasi_gaya_bicara ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kebutuhan_edukasi_gaya_bicara')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Bahasa sehari-hari</label>
                                        <select
                                            class="form-select @error('kebutuhan_edukasi_bahasa_sehari_hari') is-invalid @enderror"
                                            name="kebutuhan_edukasi_bahasa_sehari_hari">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $bahasaOptions = [
                                                    'aceh' => 'Aceh',
                                                    'batak' => 'Batak',
                                                    'minangkabau' => 'Minangkabau',
                                                    'melayu' => 'Melayu',
                                                    'sunda' => 'Sunda',
                                                    'jawa' => 'Jawa',
                                                    'madura' => 'Madura',
                                                    'bali' => 'Bali',
                                                    'sasak' => 'Sasak',
                                                    'banjar' => 'Banjar',
                                                    'bugis' => 'Bugis',
                                                    'toraja' => 'Toraja',
                                                    'makassar' => 'Makassar',
                                                    'dayak' => 'Dayak',
                                                    'tidung' => 'Tidung',
                                                    'ambon' => 'Ambon',
                                                    'ternate' => 'Ternate',
                                                    'tidore' => 'Tidore',
                                                    'papua' => 'Papua',
                                                    'asmat' => 'Asmat',
                                                ];
                                            @endphp
                                            @foreach ($bahasaOptions as $value => $label)
                                                <option value="{{ $value }}" {{ old('kebutuhan_edukasi_bahasa_sehari_hari', $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kebutuhan_edukasi_bahasa_sehari_hari')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Perlu penerjemah</label>
                                        <select
                                            class="form-select @error('kebutuhan_edukasi_perlu_penerjemah') is-invalid @enderror"
                                            name="kebutuhan_edukasi_perlu_penerjemah">
                                            <option value="">--Pilih--</option>
                                            <option value="0" {{ old('kebutuhan_edukasi_perlu_penerjemah', $asesmen->asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah ?? '') == '0' ? 'selected' : '' }}>
                                                Tidak</option>
                                            <option value="1" {{ old('kebutuhan_edukasi_perlu_penerjemah', $asesmen->asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah ?? '') == '1' ? 'selected' : '' }}>
                                                Ya</option>
                                        </select>
                                        @error('kebutuhan_edukasi_perlu_penerjemah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hambatan komunikasi</label>
                                        <select
                                            class="form-select @error('kebutuhan_edukasi_hambatan_komunikasi') is-invalid @enderror"
                                            name="kebutuhan_edukasi_hambatan_komunikasi">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $hambatanOptions = [
                                                    'bahasa' => 'Bahasa',
                                                    'menulis' => 'Menulis',
                                                    'cemas' => 'Cemas',
                                                    'lainnya' => 'Lainnya',
                                                ];
                                            @endphp
                                            @foreach ($hambatanOptions as $value => $label)
                                                <option value="{{ $value }}" {{ old('kebutuhan_edukasi_hambatan_komunikasi', $asesmen->asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kebutuhan_edukasi_hambatan_komunikasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media belajar yang disukai</label>
                                        <select
                                            class="form-select @error('kebutuhan_edukasi_media_belajar') is-invalid @enderror"
                                            name="kebutuhan_edukasi_media_belajar">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $mediaBelajarOptions = [
                                                    'audio' => 'Audio-Visual',
                                                    'brosur' => 'Brosur',
                                                    'diskusi' => 'Diskusi',
                                                    'lainnya' => 'Lainnya',
                                                ];
                                            @endphp
                                            @foreach ($mediaBelajarOptions as $value => $label)
                                                <option value="{{ $value }}" {{ old('kebutuhan_edukasi_media_belajar', $asesmen->asesmenKepUmum->kebutuhan_edukasi_media_belajar ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kebutuhan_edukasi_media_belajar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat pendidikan</label>
                                        <select
                                            class="form-select @error('kebutuhan_edukasi_tingkat_pendidikan') is-invalid @enderror"
                                            name="kebutuhan_edukasi_tingkat_pendidikan">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $pendidikanOptions = [
                                                    'sd' => 'SD',
                                                    'smp' => 'SMP',
                                                    'sma' => 'SMA',
                                                    'sarjana' => 'Sarjana',
                                                    'master' => 'Master',
                                                ];
                                            @endphp
                                            @foreach ($pendidikanOptions as $value => $label)
                                                <option value="{{ $value }}" {{ old('kebutuhan_edukasi_tingkat_pendidikan', $asesmen->asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kebutuhan_edukasi_tingkat_pendidikan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukasi yang dibutuhkan</label>
                                        <select
                                            class="form-select @error('kebutuhan_edukasi_edukasi_dibutuhkan') is-invalid @enderror"
                                            name="kebutuhan_edukasi_edukasi_dibutuhkan">
                                            <option value="">--Pilih--</option>
                                            @php
                                                $edukasiOptions = [
                                                    'Proses Penyakit' => 'Proses Penyakit',
                                                    'Pengobatan/Tindakan' => 'Pengobatan/Tindakan',
                                                    'Terapi/Obat' => 'Terapi/Obat',
                                                    'Nutrisi' => 'Nutrisi',
                                                    'Lainnya' => 'Lainnya',
                                                ];
                                            @endphp
                                            @foreach ($edukasiOptions as $value => $label)
                                                <option value="{{ $value }}" {{ old('kebutuhan_edukasi_edukasi_dibutuhkan', $asesmen->asesmenKepUmum->kebutuhan_edukasi_edukasi_dibutuhkan ?? '') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kebutuhan_edukasi_edukasi_dibutuhkan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lainnya</label>
                                        <textarea
                                            class="form-control @error('kebutuhan_edukasi_keterangan_lain') is-invalid @enderror"
                                            name="kebutuhan_edukasi_keterangan_lain"
                                            rows="3">{{ old('kebutuhan_edukasi_keterangan_lain', $asesmen->asesmenKepUmum->kebutuhan_edukasi_keterangan_lain ?? '') }}</textarea>
                                        @error('kebutuhan_edukasi_keterangan_lain')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">14. Discharge Planning</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Diagnosis medis</label>
                                        <input type="text"
                                            class="form-control @error('discharge_planning_diagnosis_medis') is-invalid @enderror"
                                            name="discharge_planning_diagnosis_medis" id="diagnosis_medis"
                                            value="{{ old('discharge_planning_diagnosis_medis', $asesmen->asesmenKepUmum->discharge_planning_diagnosis_medis ?? '') }}">
                                        @error('discharge_planning_diagnosis_medis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Usia lanjut</label>
                                        <select
                                            class="form-select discharge-select @error('discharge_planning_usia_lanjut') is-invalid @enderror"
                                            name="discharge_planning_usia_lanjut" id="usia_lanjut">
                                            <option value="">pilih</option>
                                            <option value="ya" {{ old('discharge_planning_usia_lanjut', $asesmen->asesmenKepUmum->discharge_planning_usia_lanjut ?? '') == 'ya' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="tidak" {{ old('discharge_planning_usia_lanjut', $asesmen->asesmenKepUmum->discharge_planning_usia_lanjut ?? '') == 'tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                        @error('discharge_planning_usia_lanjut')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hambatan mobilisasi</label>
                                        <select
                                            class="form-select discharge-select @error('discharge_planning_hambatan_mobilisasi') is-invalid @enderror"
                                            name="discharge_planning_hambatan_mobilisasi" id="hambatan_mobilisasi">
                                            <option value="">pilih</option>
                                            <option value="ya" {{ old('discharge_planning_hambatan_mobilisasi', $asesmen->asesmenKepUmum->discharge_planning_hambatan_mobilisasi ?? '') == 'ya' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="tidak" {{ old('discharge_planning_hambatan_mobilisasi', $asesmen->asesmenKepUmum->discharge_planning_hambatan_mobilisasi ?? '') == 'tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                        @error('discharge_planning_hambatan_mobilisasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Membutuhkan pelayanan medis berkelanjutan</label>
                                        <select
                                            class="form-select discharge-select @error('discharge_planning_pelayanan_medis') is-invalid @enderror"
                                            name="discharge_planning_pelayanan_medis" id="pelayanan_medis_berkelanjutan">
                                            <option value="">pilih</option>
                                            <option value="ya" {{ old('discharge_planning_pelayanan_medis', $asesmen->asesmenKepUmum->discharge_planning_pelayanan_medis ?? '') == 'ya' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="tidak" {{ old('discharge_planning_pelayanan_medis', $asesmen->asesmenKepUmum->discharge_planning_pelayanan_medis ?? '') == 'tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                        @error('discharge_planning_pelayanan_medis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Ketergantungan dengan orang lain dalam aktivitas
                                            harian</label>
                                        <select
                                            class="form-select discharge-select @error('discharge_planning_ketergantungan_aktivitas') is-invalid @enderror"
                                            name="discharge_planning_ketergantungan_aktivitas"
                                            id="ketergantungan_aktivitas">
                                            <option value="">pilih</option>
                                            <option value="ya" {{ old('discharge_planning_ketergantungan_aktivitas', $asesmen->asesmenKepUmum->discharge_planning_ketergantungan_aktivitas ?? '') == 'ya' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="tidak" {{ old('discharge_planning_ketergantungan_aktivitas', $asesmen->asesmenKepUmum->discharge_planning_ketergantungan_aktivitas ?? '') == 'tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                        @error('discharge_planning_ketergantungan_aktivitas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-4">
                                        <label style="min-width: 200px;">KESIMPULAN</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="alert alert-warning" id="kesimpulan_khusus" style="display: none;">
                                                Membutuhkan rencana pulang khusus
                                            </div>
                                            <div class="alert alert-success" id="kesimpulan_tidak_khusus"
                                                style="display: none;">
                                                Tidak membutuhkan rencana pulang khusus
                                            </div>
                                        </div>
                                        <input type="hidden" name="discharge_planning_kesimpulan" id="kesimpulan_value"
                                            value="{{ old('discharge_planning_kesimpulan', $asesmen->asesmenKepUmum->discharge_planning_kesimpulan ?? '') }}">
                                    </div>
                                </div>

                                {{-- <div class="section-separator">
                                    <h5 class="section-title">15. Masalah Keperawatan</h5>
                                    <div class="form-group">
                                        <div class="w-100">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="inputMasalah"
                                                    placeholder="Ketik masalah keperawatan...">
                                            </div>
                                            <div id="masalahSuggestions" class="suggestions-list"></div>
                                            <div id="selectedMasalahList" class="selected-items mt-3"></div>
                                            <input type="hidden" name="masalah_keperawatan" id="masalahKeperawatanValue">
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="section-separator">
                                    <h5 class="section-title">16. Implementasi</h5>
                                    <div class="form-group">
                                        <div class="w-100">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="inputImplementasi"
                                                    placeholder="Ketik implementasi...">
                                            </div>
                                            <div id="implementasiSuggestions" class="suggestions-list"></div>
                                            <div id="selectedImplementasiList" class="selected-items mt-3"></div>
                                            <input type="hidden" name="implementasi" id="implementasiValue">
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="">
                                    @php
                                        // Ambil data dari database untuk edit mode
                                        $implementasiData = '';
                                        $evaluasiData = '';

                                        if (isset($asesmen) && $asesmen->asesmenKepUmum) {
                                            $implementasiData = $asesmen->asesmenKepUmum->implementasi_keperawatan ?? '';
                                            $evaluasiData = $asesmen->asesmenKepUmum->evaluasi_keperawatan ?? '';
                                        }
                                    @endphp

                                    <!-- Hidden inputs untuk menyimpan data JSON -->
                                    <input type="hidden" id="implementationDataInput" name="implementasi_keperawatan"
                                        value="{{ old('implementasi_keperawatan', $implementasiData) }}">
                                    <input type="hidden" id="evaluationDataInput" name="evaluasi_keperawatan"
                                        value="{{ old('evaluasi_keperawatan', $evaluasiData) }}">

                                    <!-- Implementasi Section -->
                                    <div class="section-separator">
                                        <h5 class="section-title">15. Implementasi</h5>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Daftar Tindakan Keperawatan</span>
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="openImplementationModal()">
                                                <i class="bi bi-plus-circle"></i> Tambah Tindakan
                                            </button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm" id="implementationTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="15%">Tanggal</th>
                                                        <th width="10%">Jam</th>
                                                        <th width="60%">Tindakan Keperawatan</th>
                                                        <th width="15%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center text-muted">
                                                        <td colspan="4">Belum ada data tindakan</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Evaluasi Keperawatan Section -->
                                    <div class="section-separator">
                                        <h5 class="section-title">16. Evaluasi Keperawatan (SOAP)</h5>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Daftar Evaluasi Keperawatan</span>
                                            <button type="button" class="btn btn-success btn-sm"
                                                onclick="openEvaluationModal()">
                                                <i class="bi bi-plus-circle"></i> Tambah Evaluasi
                                            </button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm" id="evaluationTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="15%">Tanggal</th>
                                                        <th width="10%">Jam</th>
                                                        <th width="60%">Evaluasi SOAP</th>
                                                        <th width="15%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="text-center text-muted">
                                                        <td colspan="4">Belum ada data evaluasi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="section-separator">
                                    <h5 class="section-title">15. Evaluasi</h5>

                                    <div class="form-group">
                                        <label>Evaluasi</label>
                                        <textarea class="form-control @error('evaluasi') is-invalid @enderror"
                                            name="evaluasi"
                                            rows="3">{{ old('evaluasi', $asesmen->asesmenKepUmum->evaluasi ?? '') }}</textarea>
                                        @error('evaluasi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </div>

        </form>
    </div>

    <!-- Modal Implementasi -->
    <div class="modal fade" id="implementationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="implementationModalTitle">Tambah Tindakan Keperawatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="implementationForm">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Tindakan</label>
                            <input type="date" class="form-control" id="impl_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jam Tindakan</label>
                            <input type="time" class="form-control" id="impl_time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tindakan Keperawatan</label>
                            <textarea class="form-control" id="impl_action" rows="4" required
                                placeholder="Masukkan detail tindakan keperawatan yang dilakukan..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary"
                        onclick="saveImplementation(); return false;">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Evaluasi -->
    <div class="modal fade" id="evaluationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="evaluationModalTitle">Tambah Evaluasi Keperawatan (SOAP)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="soap-guide">
                        <strong>Format SOAP:</strong><br>
                        <strong>S (Subjective):</strong> Keluhan pasien, apa yang dirasakan<br>
                        <strong>O (Objective):</strong> Data yang dapat diobservasi (vital sign, pemeriksaan fisik)<br>
                        <strong>A (Assessment):</strong> Analisa masalah keperawatan<br>
                        <strong>P (Planning):</strong> Rencana tindakan selanjutnya
                    </div>

                    <form id="evaluationForm">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Evaluasi</label>
                            <input type="date" class="form-control" id="eval_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jam Evaluasi</label>
                            <input type="time" class="form-control" id="eval_time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">S (Subjective) - Keluhan Pasien</label>
                            <textarea class="form-control soap-format" id="eval_subjective" rows="2"
                                placeholder="S: Pasien mengeluh..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">O (Objective) - Data Objektif</label>
                            <textarea class="form-control soap-format" id="eval_objective" rows="2"
                                placeholder="O: TD: 120/80 mmHg, N: 80x/menit, RR: 20x/menit, S: 36.5°C..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">A (Assessment) - Analisa</label>
                            <textarea class="form-control soap-format" id="eval_assessment" rows="2"
                                placeholder="A: Masalah keperawatan..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">P (Planning) - Rencana</label>
                            <textarea class="form-control soap-format" id="eval_planning" rows="2"
                                placeholder="P: Lanjutkan terapi, observasi..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="saveEvaluation(); return false;">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.modal-tindakankeperawatan-edit')
@endsection

@push('js')
    <script>
        // Data storage
        let implementationData = [];
        let evaluationData = [];
        let editingIndex = -1;
        let editingType = '';

        // Initialize current date and time
        document.addEventListener('DOMContentLoaded', function () {
            const now = new Date();
            const currentDate = now.toISOString().split('T')[0];
            const currentTime = now.toTimeString().slice(0, 5);

            document.getElementById('impl_date').value = currentDate;
            document.getElementById('impl_time').value = currentTime;
            document.getElementById('eval_date').value = currentDate;
            document.getElementById('eval_time').value = currentTime;

            // Load existing data dari hidden inputs - PERBAIKAN UTAMA
            loadExistingDataFromDatabase();
        });

        /**
         * FUNGSI BARU: Load data existing dari database
         */
        function loadExistingDataFromDatabase() {
            // Load Implementation Data
            const implInput = document.getElementById('implementationDataInput');
            if (implInput && implInput.value && implInput.value.trim()) {
                try {
                    const parsedImplData = JSON.parse(implInput.value);
                    if (Array.isArray(parsedImplData) && parsedImplData.length > 0) {
                        implementationData = parsedImplData;
                        updateImplementationTable();
                        console.log('Loaded implementation data:', implementationData);
                    }
                } catch (e) {
                    console.error('Error parsing existing implementation data:', e);
                    console.log('Raw implementation data:', implInput.value);
                }
            }

            // Load Evaluation Data
            const evalInput = document.getElementById('evaluationDataInput');
            if (evalInput && evalInput.value && evalInput.value.trim()) {
                try {
                    const parsedEvalData = JSON.parse(evalInput.value);
                    if (Array.isArray(parsedEvalData) && parsedEvalData.length > 0) {
                        evaluationData = parsedEvalData;
                        updateEvaluationTable();
                        console.log('Loaded evaluation data:', evaluationData);
                    }
                } catch (e) {
                    console.error('Error parsing existing evaluation data:', e);
                    console.log('Raw evaluation data:', evalInput.value);
                }
            }
        }

        // Implementation Modal Functions
        function openImplementationModal(index = -1) {
            // Prevent any default behavior
            event?.preventDefault();

            editingIndex = index;
            editingType = 'implementation';

            const modal = new bootstrap.Modal(document.getElementById('implementationModal'));
            const title = document.getElementById('implementationModalTitle');

            if (index >= 0) {
                // Edit mode
                title.textContent = 'Edit Tindakan Keperawatan';
                const data = implementationData[index];
                document.getElementById('impl_date').value = data.date;
                document.getElementById('impl_time').value = data.time;
                document.getElementById('impl_action').value = data.action;
            } else {
                // Add mode
                title.textContent = 'Tambah Tindakan Keperawatan';
                document.getElementById('implementationForm').reset();

                // Set current date/time
                const now = new Date();
                document.getElementById('impl_date').value = now.toISOString().split('T')[0];
                document.getElementById('impl_time').value = now.toTimeString().slice(0, 5);
            }

            modal.show();
            return false;
        }

        function saveImplementation(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            const date = document.getElementById('impl_date').value;
            const time = document.getElementById('impl_time').value;
            const action = document.getElementById('impl_action').value;

            if (!date || !time || !action.trim()) {
                alert('Harap lengkapi semua field!');
                return false;
            }

            const data = {
                date: date,
                time: time,
                action: action.trim()
            };

            if (editingIndex >= 0) {
                implementationData[editingIndex] = data;
            } else {
                implementationData.push(data);
            }

            updateImplementationTable();
            updateHiddenInputs();

            // Close modal manually
            const modalElement = document.getElementById('implementationModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }

            return false;
        }

        function updateImplementationTable() {
            const tbody = document.querySelector('#implementationTable tbody');

            if (implementationData.length === 0) {
                tbody.innerHTML = '<tr class="text-center text-muted"><td colspan="4">Belum ada data tindakan</td></tr>';
                return;
            }

            tbody.innerHTML = implementationData.map((item, index) => `
                    <tr>
                        <td>${formatDate(item.date)}</td>
                        <td>${item.time}</td>
                        <td>${item.action}</td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-action" onclick="event.preventDefault(); openImplementationModal(${index}); return false;">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-action" onclick="event.preventDefault(); removeImplementation(${index}); return false;">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
        }

        function removeImplementation(index) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                implementationData.splice(index, 1);
                updateImplementationTable();
                updateHiddenInputs();
            }
        }

        // Evaluation Modal Functions
        function openEvaluationModal(index = -1) {
            // Prevent any default behavior
            event?.preventDefault();

            editingIndex = index;
            editingType = 'evaluation';

            const modal = new bootstrap.Modal(document.getElementById('evaluationModal'));
            const title = document.getElementById('evaluationModalTitle');

            if (index >= 0) {
                // Edit mode
                title.textContent = 'Edit Evaluasi Keperawatan (SOAP)';
                const data = evaluationData[index];
                document.getElementById('eval_date').value = data.date;
                document.getElementById('eval_time').value = data.time;
                document.getElementById('eval_subjective').value = data.subjective || '';
                document.getElementById('eval_objective').value = data.objective || '';
                document.getElementById('eval_assessment').value = data.assessment || '';
                document.getElementById('eval_planning').value = data.planning || '';
            } else {
                // Add mode
                title.textContent = 'Tambah Evaluasi Keperawatan (SOAP)';
                document.getElementById('evaluationForm').reset();

                // Set current date/time
                const now = new Date();
                document.getElementById('eval_date').value = now.toISOString().split('T')[0];
                document.getElementById('eval_time').value = now.toTimeString().slice(0, 5);
            }

            modal.show();
            return false;
        }

        function saveEvaluation(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            const date = document.getElementById('eval_date').value;
            const time = document.getElementById('eval_time').value;
            const subjective = document.getElementById('eval_subjective').value;
            const objective = document.getElementById('eval_objective').value;
            const assessment = document.getElementById('eval_assessment').value;
            const planning = document.getElementById('eval_planning').value;

            if (!date || !time) {
                alert('Harap isi tanggal dan jam!');
                return false;
            }

            const data = {
                date: date,
                time: time,
                subjective: subjective.trim(),
                objective: objective.trim(),
                assessment: assessment.trim(),
                planning: planning.trim()
            };

            if (editingIndex >= 0) {
                evaluationData[editingIndex] = data;
            } else {
                evaluationData.push(data);
            }

            updateEvaluationTable();
            updateHiddenInputs();

            // Close modal manually
            const modalElement = document.getElementById('evaluationModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }

            return false;
        }

        function updateEvaluationTable() {
            const tbody = document.querySelector('#evaluationTable tbody');

            if (evaluationData.length === 0) {
                tbody.innerHTML = '<tr class="text-center text-muted"><td colspan="4">Belum ada data evaluasi</td></tr>';
                return;
            }

            tbody.innerHTML = evaluationData.map((item, index) => {
                let soapText = '';
                if (item.subjective) soapText += `S: ${item.subjective}\n`;
                if (item.objective) soapText += `O: ${item.objective}\n`;
                if (item.assessment) soapText += `A: ${item.assessment}\n`;
                if (item.planning) soapText += `P: ${item.planning}`;

                return `
                        <tr>
                            <td>${formatDate(item.date)}</td>
                            <td>${item.time}</td>
                            <td style="white-space: pre-line; font-family: monospace; font-size: 0.9rem;">${soapText}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-action" onclick="event.preventDefault(); openEvaluationModal(${index}); return false;">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-action" onclick="event.preventDefault(); removeEvaluation(${index}); return false;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
            }).join('');
        }

        function removeEvaluation(index) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                evaluationData.splice(index, 1);
                updateEvaluationTable();
                updateHiddenInputs();
            }
        }

        // Update hidden inputs dengan data JSON
        function updateHiddenInputs() {
            document.getElementById('implementationDataInput').value = JSON.stringify(implementationData);
            document.getElementById('evaluationDataInput').value = JSON.stringify(evaluationData);
        }

        // Utility function
        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('id-ID');
        }

        // Function to get data for form submission
        function getImplementationData() {
            return implementationData;
        }

        function getEvaluationData() {
            return evaluationData;
        }

        // Function untuk debugging - cek isi hidden inputs
        function checkHiddenInputs() {
            console.log('Implementation Data:', document.getElementById('implementationDataInput').value);
            console.log('Evaluation Data:', document.getElementById('evaluationDataInput').value);
        }
    </script>
@endpush
