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
            <form id="asesmenForm" method="POST">
                @csrf

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
                                            <input type="date" name="tgl_masuk" id="tgl_asesmen_keperawatan"
                                                class="form-control"
                                                value="{{ old('tgl_masuk', date('Y-m-d', strtotime($asesmen->tgl_masuk))) }}">
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
                                                <option value="bebas"
                                                    {{ $asesmen->asesmenKepUmum->airway_status == 'bebas' ? 'selected' : '' }}>
                                                    Bebas</option>
                                                <option value="pangkal lidah jatuh"
                                                    {{ $asesmen->asesmenKepUmum->airway_status == 'pangkal lidah jatuh' ? 'selected' : '' }}>
                                                    Tidak Bebas (Pangkal Lidah Jatuh)</option>
                                                <option value="sputum"
                                                    {{ $asesmen->asesmenKepUmum->airway_status == 'sputum' ? 'selected' : '' }}>
                                                    Tidak Bebas (Sputum)</option>
                                                <option value="darah"
                                                    {{ $asesmen->asesmenKepUmum->airway_status == 'darah' ? 'selected' : '' }}>
                                                    Tidak Bebas (darah)</option>
                                                <option value="spasm"
                                                    {{ $asesmen->asesmenKepUmum->airway_status == 'spasm' ? 'selected' : '' }}>
                                                    Tidak Bebas (Spasm)</option>
                                                <option value="benda asing"
                                                    {{ $asesmen->asesmenKepUmum->airway_status == 'benda asing' ? 'selected' : '' }}>
                                                    Tidak Bebas (Benda Asing)</option>
                                                <option value="lainnya"
                                                    {{ $asesmen->asesmenKepUmum->airway_status == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suara Nafas</label>
                                            <select class="form-select" name="airway_suara_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="normal"
                                                    {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'normal' ? 'selected' : '' }}>
                                                    Normal</option>
                                                <option value="whezing"
                                                    {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'whezing' ? 'selected' : '' }}>
                                                    Whezing</option>
                                                <option value="ronchi"
                                                    {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'ronchi' ? 'selected' : '' }}>
                                                    Ronchi</option>
                                                <option value="crackles"
                                                    {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'crackles' ? 'selected' : '' }}>
                                                    Crackles</option>
                                                <option value="stridor"
                                                    {{ $asesmen->asesmenKepUmum->airway_suara_nafas == 'stridor' ? 'selected' : '' }}>
                                                    Stridor</option>
                                            </select>
                                        </div>
                                        <!-- Diagnosis Section -->
                                        <div class="form-group diagnosis-section" id="airway-diagnosis">
                                            <label style="min-width: 200px;">Diagnosis Keperawatan</label>
                                            <div class="w-100">
                                                <div class="diagnosis-item">
                                                    <div class="diagnosis-row border-top border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-radio diagnose-prwt-checkbox"
                                                                    id="jalan_nafas_tidak_efektif" name="airway_diagnosis[]"
                                                                    value="jalan_nafas_tidak_efektif"
                                                                    {{ !empty($asesmen->asesmenKepUmum->airway_tindakan) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="jalan_nafas_tidak_efektif">
                                                                    Jalan nafas tidak efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="airway_aktual" name="airway_diagnosis_type"
                                                                        value="1"
                                                                        {{ old('airway_diagnosis_type', $asesmen->asesmenKepUmum->airway_diagnosis ?? '') == '1' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="airway_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="airway_risiko" name="airway_diagnosis_type"
                                                                        value="2"
                                                                        {{ old('airway_diagnosis_type', $asesmen->asesmenKepUmum->airway_diagnosis ?? '') == '2' ? 'checked' : '' }}>
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
                                                <!-- Hidden input to store existing tindakan for JavaScript initialization -->
                                                <input type="hidden" id="existingTindakan-airway"
                                                    value="{{ $asesmen->asesmenKepUmum->airway_tindakan ?? '' }}">

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanAirwayModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-airway" class="d-flex flex-column gap-2">
                                                    <!-- Existing tindakan will be dynamically populated by JavaScript -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-breathing">
                                        <h5 class="section-title">2. Status Breathing</h5>

                                        {{-- <div class="form-group">
                                            <label style="min-width: 200px;">Frekuensi nafas/menit</label>
                                            <input type="text" class="form-control" name="breathing_frekuensi_nafas">
                                        </div> --}}

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pola nafas</label>
                                            <select class="form-select" name="breathing_pola_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="Normal" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Apnea" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Apnea' ? 'selected' : '' }}>Apnea</option>
                                                <option value="Sesak" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Sesak' ? 'selected' : '' }}>Sesak</option>
                                                <option value="Bradipnea" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Bradipnea' ? 'selected' : '' }}>Bradipnea</option>
                                                <option value="Takipnea" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Takipnea' ? 'selected' : '' }}>Takipnea</option>
                                                <option value="Othopnea" {{ old('breathing_pola_nafas', $asesmen->asesmenKepUmumBreathing->breathing_pola_nafas ?? '') == 'Othopnea' ? 'selected' : '' }}>Othopnea</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bunyi nafas</label>
                                            <select class="form-select" name="breathing_bunyi_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="Normal" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                                <option value="Veskuler" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Veskuler' ? 'selected' : '' }}>Veskuler</option>
                                                <option value="Wheezing" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Wheezing' ? 'selected' : '' }}>Whezing</option>
                                                <option value="Stridor" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Stridor' ? 'selected' : '' }}>Stridor</option>
                                                <option value="Ronchi" {{ old('breathing_bunyi_nafas', $asesmen->asesmenKepUmumBreathing->breathing_bunyi_nafas ?? '') == 'Ronchi' ? 'selected' : '' }}>Ronchi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Irama Nafas</label>
                                            <select class="form-select" name="breathing_irama_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ old('breathing_irama_nafas', $asesmen->asesmenKepUmumBreathing->breathing_irama_nafas ?? '') == '1' ? 'selected' : '' }}>Teratur</option>
                                                <option value="0" {{ old('breathing_irama_nafas', $asesmen->asesmenKepUmumBreathing->breathing_irama_nafas ?? '') == '0' ? 'selected' : '' }}>Tidak Teratur</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanda Distress Nafas</label>
                                            <select class="form-select" name="breathing_tanda_distress">
                                                <option value="">--Pilih--</option>
                                                <option value="Tidak Ada Tanda Distress" {{ old('breathing_tanda_distress', $asesmen->asesmenKepUmumBreathing->breathing_tanda_distress ?? '') == 'Tidak Ada Tanda Distress' ? 'selected' : '' }}>Tidak Ada Tanda Distress</option>
                                                <option value="Penggunaan Otot Bantu" {{ old('breathing_tanda_distress', $asesmen->asesmenKepUmumBreathing->breathing_tanda_distress ?? '') == 'Penggunaan Otot Bantu' ? 'selected' : '' }}>Penggunaan Otot Bantu</option>
                                                <option value="Retraksi Dada/Intercosta" {{ old('breathing_tanda_distress', $asesmen->asesmenKepUmumBreathing->breathing_tanda_distress ?? '') == 'Retraksi Dada/Intercosta' ? 'selected' : '' }}>Retraksi Dada/Intercosta</option>
                                                <option value="Cupling Hidung" {{ old('breathing_tanda_distress', $asesmen->asesmenKepUmumBreathing->breathing_tanda_distress ?? '') == 'Cupling Hidung' ? 'selected' : '' }}>Cupling Hidung</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jalan Pernafasan</label>
                                            <select class="form-select" name="breathing_jalan_nafas">
                                                <option value="">Pilih</option>
                                                <option value="1" {{ old('breathing_jalan_nafas', $asesmen->asesmenKepUmumBreathing->breathing_jalan_nafas ?? '') == '1' ? 'selected' : '' }}>Pernafasan Dada</option>
                                                <option value="2" {{ old('breathing_jalan_nafas', $asesmen->asesmenKepUmumBreathing->breathing_jalan_nafas ?? '') == '2' ? 'selected' : '' }}>Pernafasan Perut</option>
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
                                                                    name="breathing_diagnosis_nafas[]"
                                                                    value="pola_nafas" {{ !empty($asesmen->asesmenKepUmumBreathing->breathing_diagnosis_nafas) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="pola_nafas_tidak_efektif">
                                                                    Pola Nafas Tidak Efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_aktual"
                                                                        name="breathing_diagnosis_type"
                                                                        value="1"
                                                                        {{ old('breathing_diagnosis_type', $asesmen->asesmenKepUmumCirculation->circulation_diagnosis_perfusi ?? '') == '1' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="breathing_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_risiko"
                                                                        name="breathing_diagnosis_type"
                                                                        value="2"
                                                                        {{ old('breathing_diagnosis_type', $asesmen->asesmenKepUmumCirculation->circulation_diagnosis_perfusi ?? '') == '2' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="breathing_risiko">Risiko</label>
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
                                                                    id="gangguan_pertukaran_gas"
                                                                    name="breathing_gangguan[]"
                                                                    value="gangguan"
                                                                    {{ !empty($asesmen->asesmenKepUmumBreathing->breathing_gangguan) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="gangguan_pertukaran_gas">
                                                                    Gangguan Pertukaran Gas
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_aktual_1"
                                                                        name="breathing_gangguan_type"
                                                                        value="1"
                                                                        {{ old('breathing_gangguan_type', $asesmen->asesmenKepUmumBreathing->breathing_gangguan ?? '') == '1' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="breathing_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_risiko_1"
                                                                        name="breathing_gangguan_type"
                                                                        value="2"
                                                                        {{ old('breathing_gangguan_type', $asesmen->asesmenKepUmumBreathing->breathing_gangguan ?? '') == '2' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="breathing_risiko_1">Risiko</label>
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
                                                <!-- Hidden input to store existing tindakan for JavaScript initialization -->
                                                <input type="hidden" id="existingTindakan-breathing"
                                                    value="{{ $asesmen->asesmenKepUmumBreathing->breathing_tindakan ?? '' }}">

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanBreathingModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-breathing" class="d-flex flex-column gap-2">
                                                    <!-- Existing tindakan will be dynamically populated by JavaScript -->
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
                                                    <input class="form-control" type="text"
                                                        name="circulation_sistole">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Diastole</small>
                                                    </div>
                                                    <input class="form-control" type="text"
                                                        name="circulation_diastole">
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Akral</label>
                                            <select class="form-select" name="circulation_akral">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_akral == '1' ? 'selected' : '' }}>Hangat</option>
                                                <option value="2" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_akral == '2' ? 'selected' : '' }}>Dingin</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pucat</label>
                                            <select class="form-select" name="circulation_pucat">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_pucat == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_pucat == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Cianoisis</label>
                                            <select class="form-select" name="circulation_cianosis">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_cianosis == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_cianosis == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pengisian Kapiler</label>
                                            <select class="form-select" name="circulation_kapiler">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_kapiler == '1' ? 'selected' : '' }}>< 2 Detik</option>
                                                <option value="2" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_kapiler == '2' ? 'selected' : '' }}>> 2 Detik</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kelembapan Kulit</label>
                                            <select class="form-select" name="circulation_kelembapan_kulit">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_kelembapan_kulit == '1' ? 'selected' : '' }}>Lembab</option>
                                                <option value="2" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_kelembapan_kulit == '2' ? 'selected' : '' }}>Kering</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tugor</label>
                                            <select class="form-select" name="circulation_turgor">
                                                <option value="">--Pilih--</option>
                                                <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_turgor == '1' ? 'selected' : '' }}>Normal</option>
                                                <option value="0" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_turgor == '0' ? 'selected' : '' }}>Kurang</option>
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
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_transfusi == '1' ? 'selected' : '' }}>Ya</option>
                                                        <option value="0" {{ optional($asesmen->asesmenKepUmumCirculation)->circulation_transfusi == '0' ? 'selected' : '' }}>Tidak</option>
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
                                                placeholder="isikan jika ada keluhan nafas lainnya"
                                                name="circulation_lain"
                                                value="{{ optional($asesmen->asesmenKepUmumCirculation)->circulation_lain }}">
                                        </div>
                                        <div class="form-group diagnosis-section">
                                            <label style="min-width: 200px;">Diagnosis Keperawatan</label>
                                            <div class="w-100">
                                                <div class="diagnosis-item">
                                                    <!-- Diagnosis 1 -->
                                                    <div class="diagnosis-row border-top border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="perfusi_jaringan_perifer_tidak_efektif"
                                                                    name="circulation_diagnosis_perfusi[]"
                                                                    value="perfusi_jaringan_perifer_tidak_efektif"
                                                                    {{ !empty($asesmen->asesmenKepUmumCirculation->circulation_diagnosis_perfusi) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="perfusi_jaringan_perifer_tidak_efektif">
                                                                    Perfusi Jaringan Perifer Tidak Efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_aktual"
                                                                        name="circulation_diagnosis_perfusi_type"
                                                                        value="aktual"
                                                                        {{ old('circulation_diagnosis_perfusi_type',
                                                                            optional($asesmen->asesmenKepUmumCirculation)->circulation_diagnosis_perfusi) == '1'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="circulation_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_risiko"
                                                                        name="circulation_diagnosis_perfusi_type"
                                                                        value="risiko"
                                                                        {{ old('circulation_diagnosis_perfusi_type',
                                                                            optional($asesmen->asesmenKepUmumCirculation)->circulation_diagnosis_perfusi) == '2'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="circulation_risiko">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 2 -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="defisit_volume_cairan"
                                                                    name="circulation_diagnosis_defisit[]"
                                                                    value="defisit_volume_cairan"
                                                                    {{ !empty($asesmen->asesmenKepUmumCirculation->circulation_diagnosis_defisit) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="defisit_volume_cairan">
                                                                    Defisit Volume Cairan
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_aktual_1"
                                                                        name="circulation_diagnosis_defisit_type"
                                                                        value="aktual"
                                                                        {{ old('circulation_diagnosis_defisit_type',
                                                                            optional($asesmen->asesmenKepUmumCirculation)->circulation_diagnosis_defisit) == '1'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="circulation_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_risiko_1"
                                                                        name="circulation_diagnosis_defisit_type"
                                                                        value="risiko"
                                                                        {{ old('circulation_diagnosis_defisit_type',
                                                                            optional($asesmen->asesmenKepUmumCirculation)->circulation_diagnosis_defisit) == '2'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="circulation_risiko_1">Risiko</label>
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
                                                <!-- Hidden input to store existing interventions -->
                                                <input type="hidden" id="existingTindakan-circulation" value='{{ optional($asesmen->asesmenKepUmumCirculation)->circulation_tindakan ?? '[]' }}'>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanCirculationModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-circulation" class="d-flex flex-column gap-2">
                                                    <!-- Interventions will be dynamically populated here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">4. Status Disability</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesadaran</label>
                                            <select class="form-select" name="disability_kesadaran">
                                                <option value="">--Pilih--</option>
                                                <option value="Compos Mentis" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Compos Mentis' ? 'selected' : '' }}>Compos Mentis</option>
                                                <option value="Apatis" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Apatis' ? 'selected' : '' }}>Apatis</option>
                                                <option value="Somnolen" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Somnolen' ? 'selected' : '' }}>Somnolen</option>
                                                <option value="Sopor" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Sopor' ? 'selected' : '' }}>Sopor</option>
                                                <option value="Coma" {{ optional($asesmen->asesmenKepUmumDisability)->disability_kesadaran == 'Coma' ? 'selected' : '' }}>Coma</option>
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
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumDisability)->disability_isokor == '1' ? 'selected' : '' }}>Isokor</option>
                                                        <option value="2" {{ optional($asesmen->asesmenKepUmumDisability)->disability_isokor == '2' ? 'selected' : '' }}>Anisokor</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Respon Cahaya</small>
                                                    </div>
                                                    <select class="form-select" name="disability_respon_cahaya">
                                                        <option value="">--Pilih--</option>
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumDisability)->disability_respon_cahaya == '1' ? 'selected' : '' }}>Ya</option>
                                                        <option value="0" {{ optional($asesmen->asesmenKepUmumDisability)->disability_respon_cahaya == '0' ? 'selected' : '' }}>Tidak</option>
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
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumDisability)->disability_motorik == '1' ? 'selected' : '' }}>Ya</option>
                                                        <option value="0" {{ optional($asesmen->asesmenKepUmumDisability)->disability_motorik == '0' ? 'selected' : '' }}>Tidak</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Sensorik</small>
                                                    </div>
                                                    <select class="form-select" name="disability_sensorik">
                                                        <option value="">--Pilih--</option>
                                                        <option value="1" {{ optional($asesmen->asesmenKepUmumDisability)->disability_sensorik == '1' ? 'selected' : '' }}>Ya</option>
                                                        <option value="0" {{ optional($asesmen->asesmenKepUmumDisability)->disability_sensorik == '0' ? 'selected' : '' }}>Tidak</option>
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
                                                                    value="perfusi_jaringan_cereberal_tidak_efektif"
                                                                        {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_perfusi) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="perfusi_jaringan_cereberal_tidak_efektif">
                                                                    Perfusi jaringan cereberal tidak efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual"
                                                                        name="disability_diagnosis_perfusi_type"
                                                                        value="1"
                                                                        {{ old('disability_diagnosis_perfusi_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_perfusi) == '1'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko"
                                                                        name="disability_diagnosis_perfusi_type"
                                                                        value="2"
                                                                        {{ old('disability_diagnosis_perfusi_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_perfusi) == '2'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_risiko">Risiko</label>
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
                                                                    value="intoleransi_aktivitas"
                                                                        {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_intoleransi) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="intoleransi_aktivitas">
                                                                    Intoleransi aktivitas
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_1"
                                                                        name="disability_diagnosis_intoleransi_type"
                                                                        value="1"
                                                                        {{ old('disability_diagnosis_intoleransi_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_intoleransi) == '1'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_1"
                                                                        name="disability_diagnosis_intoleransi_type"
                                                                        value="2"
                                                                        {{ old('disability_diagnosis_intoleransi_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_intoleransi) == '2'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_risiko_1">Risiko</label>
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
                                                                    value="kendala_komunikasi_verbal"
                                                                        {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_komunikasi) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kendala_komunikasi_verbal">
                                                                    Kendala komunikasi verbal
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_2"
                                                                        name="disability_diagnosis_komunikasi_type"
                                                                        value="1"
                                                                        {{ old('disability_diagnosis_komunikasi_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_komunikasi) == '1'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_aktual_2">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_2"
                                                                        name="disability_diagnosis_komunikasi_type"
                                                                        value="2"
                                                                        {{ old('disability_diagnosis_komunikasi_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_komunikasi) == '2'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_risiko_2">Risiko</label>
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
                                                                    id="kejang_ulang"
                                                                    name="disability_diagnosis_kejang[]"
                                                                    value="kejang_ulang"
                                                                        {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_kejang) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kejang_ulang">
                                                                    Kejang ulang
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_3"
                                                                        name="disability_diagnosis_kejang_type"
                                                                        value="1"
                                                                        {{ old('disability_diagnosis_kejang_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_kejang) == '1'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_aktual_3">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_3"
                                                                        name="disability_diagnosis_kejang_type"
                                                                        value="2"
                                                                        {{ old('disability_diagnosis_kejang_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_kejang) == '2'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_risiko_3">Risiko</label>
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
                                                                    value="penurunan_kesadaran"
                                                                        {{ !empty($asesmen->asesmenKepUmumDisability->disability_diagnosis_kesadaran) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="penurunan_kesadaran">
                                                                    Penurunan kesadaran
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_4"
                                                                        name="disability_diagnosis_kesadaran_type"
                                                                        value="1"
                                                                        {{ old('disability_diagnosis_kesadaran_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_kesadaran) == '1'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_aktual_4">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_4"
                                                                        name="disability_diagnosis_kesadaran_type"
                                                                        value="2"
                                                                        {{ old('disability_diagnosis_kesadaran_type',
                                                                            optional($asesmen->asesmenKepUmumDisability)->disability_diagnosis_kesadaran) == '2'
                                                                            ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="disability_risiko_4">Risiko</label>
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
                                                <!-- Hidden input to store existing interventions -->
                                                <input type="hidden"
                                                        id="existingTindakan-disability"
                                                        value='{{ optional($asesmen->asesmenKepUmumDisability)->disability_tindakan ?? '[]' }}'>

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanDisabilityModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-disability" class="d-flex flex-column gap-2">
                                                    <!-- Interventions will be dynamically populated here -->
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
                                                        <input type="radio" class="form-check-input"
                                                            id="deformitas_tidak"
                                                            name="exposure_deformitas"
                                                            value="0"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_deformitas == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="deformitas_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            id="deformitas_ya"
                                                            name="exposure_deformitas"
                                                            value="1"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_deformitas == '1' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="deformitas_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control"
                                                        name="exposure_deformitas_daerah"
                                                        placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_deformitas_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kontusion</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            id="kontusion_tidak" name="exposure_kontusion"
                                                            value="0"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_kontusion == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="kontusion_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="kontusion_ya"
                                                            name="exposure_kontusion" value="1"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_kontusion == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kontusion_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control"
                                                        name="exposure_kontusion_daerah" placeholder="Daerah"
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
                                                            name="exposure_abrasi" value="0"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_abrasi == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="abrasi_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="abrasi_ya"
                                                            name="exposure_abrasi" value="1"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_abrasi == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="abrasi_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control"
                                                        name="exposure_abrasi_daerah" placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_abrasi_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Penetrasi</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            id="penetrasi_tidak" name="exposure_penetrasi"
                                                            value="0"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_penetrasi == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="penetrasi_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="penetrasi_ya"
                                                            name="exposure_penetrasi" value="1"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_penetrasi == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="penetrasi_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control"
                                                        name="exposure_penetrasi_daerah" placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_abrasi_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Laserasi</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            id="laserasi_tidak" name="exposure_laserasi" value="0"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_laserasi == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="laserasi_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="laserasi_ya"
                                                            name="exposure_laserasi" value="1"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_laserasi == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="laserasi_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control"
                                                        name="exposure_laserasi_daerah" placeholder="Daerah"
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
                                                            name="exposure_edema" value="0"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_edema == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="edema_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="edema_ya"
                                                            name="exposure_edema" value="1"
                                                            {{ optional($asesmen->asesmenKepUmumExposure)->exposure_edema == '0' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="edema_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control"
                                                        name="exposure_edema_daerah" placeholder="Daerah"
                                                        value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_edema_daerah }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kedalaman luka (cm)</label>
                                            <input type="number" class="form-control"
                                                   name="exposure_kedalaman_luka"
                                                   value="{{ optional($asesmen->asesmenKepUmumExposure)->exposure_kedalaman_luka }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <input type="text" class="form-control"
                                                   name="exposure_lainnya"
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
                                                                    value="mobilitasi_type"
                                                                    {{ $asesmen->asesmenKepUmumExposure->exposure_diagnosis_mobilitasi ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kerusakan_mobilitas_fisik">
                                                                    Kerusakan Mobilitas Fisik
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_aktual"
                                                                        name="exposure_diagnosis_mobilitasi_type"
                                                                        value="1"
                                                                        {{ optional($asesmen->asesmenKepUmumExposure)->exposure_diagnosis_mobilitasi == '1' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="exposure_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_risiko"
                                                                        name="exposure_diagnosis_mobilitasi_type"
                                                                        value="2"
                                                                        {{ optional($asesmen->asesmenKepUmumExposure)->exposure_diagnosis_mobilitasi == '2' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="exposure_risiko">Risiko</label>
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
                                                                    value="integritas_type"
                                                                    {{ $asesmen->asesmenKepUmumExposure->exposure_diagosis_integritas ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kerusakan_integritas_jaringan">
                                                                    Kerusakan Integritas Jaringan
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_aktual_1"
                                                                        name="exposure_diagosis_integritas_type"
                                                                        value="1"
                                                                        {{ optional($asesmen->asesmenKepUmumExposure)->exposure_diagosis_integritas == '1' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="exposure_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_risiko_1"
                                                                        name="exposure_diagosis_integritas_type"
                                                                        value="2"
                                                                        {{ optional($asesmen->asesmenKepUmumExposure)->exposure_diagosis_integritas == '2' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="exposure_risiko_1">Risiko</label>
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
                                                <input type="hidden"
                                                       id="existingTindakan-exposure"
                                                       value='{{ optional($asesmen->asesmenKepUmumExposure)->exposure_tindakan ?? '[]' }}'>

                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanExposureModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>

                                                <div id="selectedTindakanList-exposure" class="d-flex flex-column gap-2">
                                                    <!-- Interventions will be dynamically populated here -->
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
                                                            name="skala_nyeri"
                                                            style="width: 100px;"
                                                            value="{{ old('skala_nyeri', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri ?? 0) }}"
                                                            min="0"
                                                            max="10">
                                                        @error('skala_nyeri')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                        <button type="button" class="btn btn-sm btn-success" id="skalaNyeriBtn">
                                                            Tidak Nyeri
                                                            <input type="number"
                                                                class="form-control flex-grow-1"
                                                                name="skala_nyeri_nilai"
                                                                style="width: 100px;"
                                                                value="{{ old('skala_nyeri_nilai', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_nilai ?? 0) }}"
                                                                min="0"
                                                                max="10">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Button Controls -->
                                                <div class="btn-group mb-3">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" data-scale="numeric">
                                                        A. Numeric Rating Pain Scale
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-primary" data-scale="wong-baker">
                                                        B. Wong Baker Faces Pain Scale
                                                    </button>
                                                </div>

                                                <!-- Pain Scale Images -->
                                                <div id="wongBakerScale" class="pain-scale-image flex-grow-1" style="display: none;">
                                                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}" alt="Wong Baker Pain Scale" style="width: 450px; height: auto;">
                                                </div>

                                                <div id="numericScale" class="pain-scale-image flex-grow-1" style="display: none;">
                                                    <img src="{{ asset('assets/img/asesmen/numerik.png') }}" alt="Numeric Pain Scale" style="width: 450px; height: auto;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Lokasi</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="skala_nyeri_lokasi"
                                                        value="{{ old('skala_nyeri_lokasi', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_lokasi ?? '') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Pemberat</label>
                                                    <select class="form-select" name="skala_nyeri_pemberat_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($faktorPemberat as $pemberat)
                                                            <option value="{{ $pemberat->id }}"
                                                                {{ old('skala_nyeri_pemberat_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_pemberat_id ?? '') == $pemberat->id ? 'selected' : '' }}>
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
                                                            <option value="{{ $kualitas->id }}"
                                                                {{ old('skala_nyeri_kualitas_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_kualitas_id ?? '') == $kualitas->id ? 'selected' : '' }}>
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
                                                            <option value="{{ $menj->id }}"
                                                                {{ old('skala_nyeri_menjalar_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_menjalar_id ?? '') == $menj->id ? 'selected' : '' }}>
                                                                {{ $menj->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Durasi</label>
                                                    <input type="text"
                                                        class="form-control"
                                                        name="skala_nyeri_durasi"
                                                        value="{{ old('skala_nyeri_durasi', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_durasi ?? '') }}">
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Peringan</label>
                                                    <select class="form-select" name="skala_nyeri_peringan_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($faktorPeringan as $peringan)
                                                            <option value="{{ $peringan->id }}"
                                                                {{ old('skala_nyeri_peringan_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_peringan_id ?? '') == $peringan->id ? 'selected' : '' }}>
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
                                                            <option value="{{ $frekuensi->id }}"
                                                                {{ old('skala_nyeri_frekuensi_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_frekuensi_id ?? '') == $frekuensi->id ? 'selected' : '' }}>
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
                                                            <option value="{{ $jenis->id }}"
                                                                {{ old('skala_nyeri_jenis_id', $asesmen->asesmenKepUmumSkalaNyeri->skala_nyeri_jenis_id ?? '') == $jenis->id ? 'selected' : '' }}>
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
                                            <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan kondisi pasien:</label>
                                            <select class="form-select" id="risikoJatuhSkala" name="resiko_jatuh_jenis" onchange="showForm(this.value)">
                                                <option value="">--Pilih Skala--</option>
                                                <option value="1" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '1' ? 'selected' : '' }}>Skala Umum</option>
                                                <option value="2" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '2' ? 'selected' : '' }}>Skala Morse</option>
                                                <option value="3" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '3' ? 'selected' : '' }}>Skala Humpty-Dumpty / Pediatrik</option>
                                                <option value="4" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '4' ? 'selected' : '' }}>Skala Ontario Modified Stratify Sydney / Lansia</option>
                                                <option value="5" {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '5' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </div>

                                        <!-- Form Skala Umum 1 -->
                                        <div id="skala_umumForm" class="risk-form" style="display: {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '1' ? 'block' : 'none' }}">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Umum</h5>

                                            <!-- Usia -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien berusia < dari 2 tahun?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_usia" onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_umum_usia', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_usia ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_umum_usia', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_usia ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Kondisi Khusus -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien dalam kondisi sebagai geriatri, dizzines, vertigo, gangguan keseimbangan, gangguan penglihatan, penggunaan obat sedasi, status kesadaran dan atau kejiwaan, konsumsi alkohol?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_kondisi_khusus" onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_umum_kondisi_khusus', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kondisi_khusus ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_umum_kondisi_khusus', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kondisi_khusus ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Diagnosis Parkinson -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien didiagnosis sebagai pasien dengan penyakit parkinson?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_diagnosis_parkinson" onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_umum_diagnosis_parkinson', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_umum_diagnosis_parkinson', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Pengobatan Berisiko -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien sedang mendapatkan obat sedasi, riwayat tirah baring lama, perubahan posisi yang akan meningkatkan risiko jatuh?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_pengobatan_berisiko" onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_umum_pengobatan_berisiko', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_umum_pengobatan_berisiko', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Lokasi Berisiko -->
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien saat ini sedang berada pada salah satu lokasi ini: rehab medik, ruangan dengan penerangan kurang dan bertangga?</label>
                                                <select class="form-select" name="risiko_jatuh_umum_lokasi_berisiko" onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_umum_lokasi_berisiko', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_umum_lokasi_berisiko', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span id="kesimpulanTextForm">{{ old('risiko_jatuh_umum_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kesimpulan ?? 'Tidak berisiko jatuh') }}</span></p>
                                                <input type="hidden" name="risiko_jatuh_umum_kesimpulan" id="risiko_jatuh_umum_kesimpulan"
                                                    value="{{ old('risiko_jatuh_umum_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_umum_kesimpulan ?? '') }}">
                                            </div>
                                        </div>

                                        <!-- Form Skala Morse 2 -->
                                        <div id="skala_morseForm" class="risk-form" style="display: {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '2' ? 'block' : 'none' }}">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Morse</h5>

                                            <!-- Riwayat Jatuh -->
                                            <div class="mb-3">
                                                <label class="form-label">Pasien pernah mengalami Jatuh?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_riwayat_jatuh" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="25" {{ old('risiko_jatuh_morse_riwayat_jatuh', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh ?? '') == '25' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_riwayat_jatuh', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Diagnosis Sekunder -->
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki diagnosis skunder?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_diagnosis_sekunder" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="15" {{ old('risiko_jatuh_morse_diagnosis_sekunder', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder ?? '') == '15' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_diagnosis_sekunder', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Bantuan Ambulasi -->
                                            <div class="mb-3">
                                                <label class="form-label">Pasien membutuhkan bantuan ambulasi?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_bantuan_ambulasi" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="30" {{ old('risiko_jatuh_morse_bantuan_ambulasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '') == '30' ? 'selected' : '' }}>Meja/ kursi</option>
                                                    <option value="15" {{ old('risiko_jatuh_morse_bantuan_ambulasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '') == '15' ? 'selected' : '' }}>Kruk/ tongkat/ alat bantu berjalan</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_bantuan_ambulasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '') == '0' ? 'selected' : '' }}>Tidak ada/ bed rest/ bantuan perawat</option>
                                                </select>
                                            </div>

                                            <!-- Terpasang Infus -->
                                            <div class="mb-3">
                                                <label class="form-label">Pasien terpasang infus?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_terpasang_infus" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="20" {{ old('risiko_jatuh_morse_terpasang_infus', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_terpasang_infus ?? '') == '20' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_terpasang_infus', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_terpasang_infus ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Cara Berjalan -->
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_cara_berjalan" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_cara_berjalan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '') == '0' ? 'selected' : '' }}>Normal/ bed rest/ kursi roda</option>
                                                    <option value="20" {{ old('risiko_jatuh_morse_cara_berjalan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '') == '20' ? 'selected' : '' }}>Terganggu</option>
                                                    <option value="10" {{ old('risiko_jatuh_morse_cara_berjalan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '') == '10' ? 'selected' : '' }}>Lemah</option>
                                                </select>
                                            </div>

                                            <!-- Status Mental -->
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana status mental pasien?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_status_mental" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="0" {{ old('risiko_jatuh_morse_status_mental', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_status_mental ?? '') == '0' ? 'selected' : '' }}>Beroroentasi pada kemampuannya</option>
                                                    <option value="15" {{ old('risiko_jatuh_morse_status_mental', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_status_mental ?? '') == '15' ? 'selected' : '' }}>Lupa akan keterbatasannya</option>
                                                </select>
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span id="kesimpulanTextForm">{{ old('risiko_jatuh_morse_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_kesimpulan ?? 'Risiko Rendah') }}</span></p>
                                                <input type="hidden" name="risiko_jatuh_morse_kesimpulan" id="risiko_jatuh_morse_kesimpulan"
                                                    value="{{ old('risiko_jatuh_morse_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_morse_kesimpulan ?? '') }}">
                                            </div>
                                        </div>

                                        <!-- Form Risiko Skala Humpty Dumpty 3 -->
                                        <div id="skala_humptyForm" class="risk-form" style="display: {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '3' ? 'block' : 'none' }}">
                                            <h5 class="mb-4">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik</h5>

                                            <!-- Usia Anak -->
                                            <div class="mb-3">
                                                <label class="form-label">Usia Anak?</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_usia_anak" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4" {{ old('risiko_jatuh_pediatrik_usia_anak', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak ?? '') == '4' ? 'selected' : '' }}>Dibawah 3 tahun</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_usia_anak', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak ?? '') == '3' ? 'selected' : '' }}>3-7 tahun</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_usia_anak', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak ?? '') == '2' ? 'selected' : '' }}>7-13 tahun</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_usia_anak', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_usia_anak ?? '') == '1' ? 'selected' : '' }}>Diatas 13 tahun</option>
                                                </select>
                                            </div>

                                            <!-- Jenis Kelamin -->
                                            <div class="mb-3">
                                                <label class="form-label">Jenis kelamin</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_jenis_kelamin" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_jenis_kelamin', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin ?? '') == '2' ? 'selected' : '' }}>Laki-laki</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_jenis_kelamin', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin ?? '') == '1' ? 'selected' : '' }}>Perempuan</option>
                                                </select>
                                            </div>

                                            <!-- Diagnosis -->
                                            <div class="mb-3">
                                                <label class="form-label">Diagnosis</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_diagnosis" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4" {{ old('risiko_jatuh_pediatrik_diagnosis', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis ?? '') == '4' ? 'selected' : '' }}>Diagnosis Neurologis</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_diagnosis', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis ?? '') == '3' ? 'selected' : '' }}>Perubahan oksigennasi (diangnosis respiratorik, dehidrasi, anemia, syncope, pusing, dsb)</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_diagnosis', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis ?? '') == '2' ? 'selected' : '' }}>Gangguan perilaku /psikiatri</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_diagnosis', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_diagnosis ?? '') == '1' ? 'selected' : '' }}>Diagnosis lainnya</option>
                                                </select>
                                            </div>

                                            <!-- Gangguan Kognitif -->
                                            <div class="mb-3">
                                                <label class="form-label">Gangguan Kognitif</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_gangguan_kognitif" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_gangguan_kognitif', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif ?? '') == '3' ? 'selected' : '' }}>Tidak menyadari keterbatasan dirinya</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_gangguan_kognitif', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif ?? '') == '2' ? 'selected' : '' }}>Lupa akan adanya keterbatasan</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_gangguan_kognitif', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif ?? '') == '1' ? 'selected' : '' }}>Orientasi baik terhadap dari sendiri</option>
                                                </select>
                                            </div>

                                            <!-- Faktor Lingkungan -->
                                            <div class="mb-3">
                                                <label class="form-label">Faktor Lingkungan</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_faktor_lingkungan" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4" {{ old('risiko_jatuh_pediatrik_faktor_lingkungan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? '') == '4' ? 'selected' : '' }}>Riwayat jatuh /bayi diletakkan di tempat tidur dewasa</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_faktor_lingkungan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? '') == '3' ? 'selected' : '' }}>Pasien menggunakan alat bantu /bayi diletakkan di tempat tidur bayi / perabot rumah</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_faktor_lingkungan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? '') == '2' ? 'selected' : '' }}>Pasien diletakkan di tempat tidur</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_faktor_lingkungan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? '') == '1' ? 'selected' : '' }}>Area di luar rumah sakit</option>
                                                </select>
                                            </div>

                                            <!-- Pembedahan -->
                                            <div class="mb-3">
                                                <label class="form-label">Pembedahan/ sedasi/ Anestesi</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_pembedahan" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_pembedahan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan ?? '') == '3' ? 'selected' : '' }}>Dalam 24 jam</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_pembedahan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan ?? '') == '2' ? 'selected' : '' }}>Dalam 48 jam</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_pembedahan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_pembedahan ?? '') == '1' ? 'selected' : '' }}>> 48 jam atau tidak menjalani pembedahan/sedasi/anestesi</option>
                                                </select>
                                            </div>

                                            <!-- Penggunaan Medika Mentosa -->
                                            <div class="mb-3">
                                                <label class="form-label">Penggunaan Medika mentosa</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_penggunaan_mentosa" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_pediatrik_penggunaan_mentosa', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa ?? '') == '3' ? 'selected' : '' }}>Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi, antidepresan, pencahar, diuretik, narkose</option>
                                                    <option value="2" {{ old('risiko_jatuh_pediatrik_penggunaan_mentosa', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa ?? '') == '2' ? 'selected' : '' }}>Penggunaan salah satu obat diatas</option>
                                                    <option value="1" {{ old('risiko_jatuh_pediatrik_penggunaan_mentosa', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa ?? '') == '1' ? 'selected' : '' }}>Penggunaan medikasi lainnya/tidak ada mediksi</option>
                                                </select>
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span id="kesimpulanTextForm">{{ old('risiko_jatuh_pediatrik_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan ?? 'Risiko Rendah') }}</span></p>
                                                <input type="hidden" name="risiko_jatuh_pediatrik_kesimpulan" id="risiko_jatuh_pediatrik_kesimpulan"
                                                    value="{{ old('risiko_jatuh_pediatrik_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan ?? '') }}">
                                            </div>
                                        </div>

                                        <div id="skala_ontarioForm" class="risk-form" style="display: {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepUmumRisikoJatuh->resiko_jatuh_jenis ?? '') == '4' ? 'block' : 'none' }}">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify Sydney/ Lansia</h5>

                                            <!-- 1. Riwayat Jatuh -->
                                            <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien datang kerumah sakit karena jatuh?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_jatuh_saat_masuk_rs" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="6" {{ old('risiko_jatuh_lansia_jatuh_saat_masuk_rs', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs ?? '') == '6' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_jatuh_saat_masuk_rs', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki 2 kali atau apakah pasien mengalami jatuh dalam 2 bulan terakhir ini/ diagnosis multiple?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_riwayat_jatuh_2_bulan" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="6" {{ old('risiko_jatuh_lansia_riwayat_jatuh_2_bulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan ?? '') == '6' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_riwayat_jatuh_2_bulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 2. Status Mental -->
                                            <h6 class="mb-3">2. Status Mental</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien bingung? (Tidak dapat membuat keputusan, jaga jarak tempatnya, gangguan daya ingat)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_status_bingung" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="14" {{ old('risiko_jatuh_lansia_status_bingung', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_bingung ?? '') == '14' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_status_bingung', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_bingung ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan waktu, tempat atau orang)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_status_disorientasi" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="14" {{ old('risiko_jatuh_lansia_status_disorientasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_disorientasi ?? '') == '14' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_status_disorientasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_disorientasi ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami agitasi? (keresahan, gelisah, dan cemas)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_status_agitasi" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="14" {{ old('risiko_jatuh_lansia_status_agitasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_agitasi ?? '') == '14' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_status_agitasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_status_agitasi ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 3. Penglihatan -->
                                            <h6 class="mb-3">3. Penglihatan</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien memakai Kacamata?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_kacamata" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_kacamata', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kacamata ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_kacamata', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kacamata ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami kelainan penglihatan/buram?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_kelainan_penglihatan" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_kelainan_penglihatan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_kelainan_penglihatan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mempunyai glukoma/ katarak/ degenerasi makula?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_glukoma" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_glukoma', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_glukoma ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_glukoma', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_glukoma ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 4. Kebiasaan Berkemih -->
                                            <h6 class="mb-3">4. Kebiasaan Berkemih</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah terdapat perubahan perilaku berkemih? (frekuensi, urgensi, inkontinensia, noktura)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_perubahan_berkemih" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2" {{ old('risiko_jatuh_lansia_perubahan_berkemih', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih ?? '') == '2' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_perubahan_berkemih', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 5. Transfer -->
                                            <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_transfer_mandiri" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_mandiri', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri ?? '') == '0' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_mandiri', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam pengawasan</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_transfer_bantuan_sedikit" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_transfer_bantuan_sedikit', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_bantuan_sedikit', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_transfer_bantuan_nyata" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2" {{ old('risiko_jatuh_lansia_transfer_bantuan_nyata', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata ?? '') == '2' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_bantuan_nyata', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan total</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_transfer_bantuan_total" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_lansia_transfer_bantuan_total', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total ?? '') == '3' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_transfer_bantuan_total', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 6. Mobilitas Pasien -->
                                            <h6 class="mb-3">6. Mobilitas Pasien</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (dapat menggunakan alat bantu jalan)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_mobilitas_mandiri" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_mandiri', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri ?? '') == '0' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_mandiri', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Berjalan dengan bantuan 1 orang (verbal/fisik)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_mobilitas_bantuan_1_orang" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1" {{ old('risiko_jatuh_lansia_mobilitas_bantuan_1_orang', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang ?? '') == '1' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_bantuan_1_orang', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Menggunakan kursi roda</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_mobilitas_kursi_roda" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2" {{ old('risiko_jatuh_lansia_mobilitas_kursi_roda', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda ?? '') == '2' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_kursi_roda', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Imobilisasi</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_mobilitas_imobilisasi" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="3" {{ old('risiko_jatuh_lansia_mobilitas_imobilisasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi ?? '') == '3' ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ old('risiko_jatuh_lansia_mobilitas_imobilisasi', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi ?? '') == '0' ? 'selected' : '' }}>Tidak</option>
                                                </select>
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span id="kesimpulanTextForm">{{ old('risiko_jatuh_lansia_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kesimpulan ?? 'Risiko Rendah') }}</span></p>
                                                <input type="hidden" name="risiko_jatuh_lansia_kesimpulan" id="risiko_jatuh_lansia_kesimpulan"
                                                    value="{{ old('risiko_jatuh_lansia_kesimpulan', $asesmen->asesmenKepUmumRisikoJatuh->risiko_jatuh_lansia_kesimpulan ?? '') }}">
                                            </div>
                                        </div>
                                        </div>

                                        <div class="mb-4">
                                            <h6 class="mb-3">Intervensi Risiko Jatuh</h6>
                                            <p class="mb-2">Tambah tindakan intervensi risiko jatuh:</p>

                                            <input type="hidden"
                                                   id="existingTindakan-risikojatuh"
                                                   value='{{ optional($asesmen->asesmenKepUmumRisikoJatuh)->risik_jatuh_tindakan ?? '[]' }}'>



                                            <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanRisikoJatuhModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="selectedTindakanList-risikojatuh" class="d-flex flex-column gap-2">
                                                <!-- Will be populated by JavaScript -->
                                                {{-- @php
                                                    $rjtindakan = json_decode($asesmen->asesmenKepUmumRisikoJatuh);

                                                    $rjTindakanEl = '';

                                                    foreach($rjTindakan as $rjt) {
                                                        $rjTindakanEl .= "<div class='selected-tindakan d-flex align-items-center justify-content-between p-2 border rounded'>
                                                                            <span>${tindakan}</span>
                                                                            <input type='hidden' name='risik_jatuh_tindakan[]' value='${id}'>
                                                                            <button type='button' class='btn btn-sm btn-danger remove-tindakan'>
                                                                                <i class='ti-trash'></i>
                                                                            </button>
                                                                        </div>";
                                                    }
                                                @endphp --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">8. Status Psikologis</h5>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Kondisi psikologis</label>
                                            <select class="form-select" name="psikologis_kondisi">
                                                <option value="">--Pilih--</option>
                                                <option value="Tidak Ada Kelainan">Tidak Ada Kelainan</option>
                                                <option value="Cemas">Cemas</option>
                                                <option value="Takut">Takut</option>
                                                <option value="Marah">Marah</option>
                                                <option value="Sedih">Sedih</option>
                                                <option value="Tenang">Tenang</option>
                                                <option value="Tidak Semangat">Tidak Semangat</option>
                                                <option value="Tertekan">Tertekan</option>
                                                <option value="Depresi">Depresi</option>
                                                <option value="Sulit Tidur">Sulit Tidur</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Potensi menyakiti diri sendiri/orang
                                                lain</label>
                                            <select class="form-select" name="psikologis_potensi_menyakiti">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Lainnya</label>
                                            <textarea class="form-control" name="psikologis_lainnya" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">9. Status Spiritual</h5>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Agama/Kepercayaan</label>
                                            <select class="form-select" name="spiritual_agama">
                                                <option value="">--Pilih--</option>
                                                <option value="islam">Islam</option>
                                                <option value="kristen">Kristen</option>
                                                <option value="katolik">Katolik</option>
                                                <option value="hindu">Hindu</option>
                                                <option value="buddha">Buddha</option>
                                                <option value="konghucu">Konghucu</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Nilai Nilai Spritiual Pasien</label>
                                            <textarea class="form-control" name="spiritual_nilai" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">10. Status Sosial Ekonomi</h5>

                                        <div class="form-group mb-3">
                                            <label class="form-label" style="min-width: 200px;">Pekerjaan</label>
                                            <select class="form-select" name="sosial_ekonomi_pekerjaan"
                                                id="sosial_pekerjaan">
                                                <option value="">--Pilih Pekerjaan--</option>
                                                @foreach ($pekerjaan as $kerjaan)
                                                    <option value="{{ $kerjaan->kd_pekerjaan }}">
                                                        {{ $kerjaan->pekerjaan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tingkat penghasilan</label>
                                            <select class="form-select" name="sosial_ekonomi_tingkat_penghasilan">
                                                <option value="">--Pilih--</option>
                                                <option value="Penghasilan Tinggi">Penghasilan Tinggi</option>
                                                <option value="Penghasilan Sedang">Penghasilan Sedang</option>
                                                <option value="Penghasilan Rendah">Penghasilan Rendah</option>
                                                <option value="Tidak Ada Penghasilan">Tidak Ada Penghasilan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status pernikahan</label>
                                            <select class="form-select" name="sosial_ekonomi_status_pernikahan">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Belum Kawin</option>
                                                <option value="1">Kawin</option>
                                                <option value="2">Janda</option>
                                                <option value="3">Duda</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status pendidikan</label>
                                            <select class="form-select" name="sosial_ekonomi_status_pendidikan">
                                                <option value="">--Pilih--</option>
                                                <option value="1">TK</option>
                                                <option value="2">SD/MIN</option>
                                                <option value="3">SLTP/SMP/MTSN/SLP</option>
                                                <option value="4">SLTA/SMA/SMU/SMK/MAN/SLA</option>
                                                <option value="5">D2</option>
                                                <option value="6">D3</option>
                                                <option value="7">S1</option>
                                                <option value="8">S2</option>
                                                <option value="9">S3</option>
                                                <option value="10">TIDAK SEKOLAH</option>
                                                <option value="13">BELUM SEKOLAH</option>
                                                <option value="14">PAUD</option>
                                                <option value="15">D4</option>
                                                <option value="16">D1</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tempat tinggal</label>
                                            <select class="form-select" name="sosial_ekonomi_tempat_tinggal">
                                                <option value="">--Pilih--</option>
                                                <option value="Rumah Sendiri">Rumah Sendiri</option>
                                                <option value="Rumah Orang Tua">Rumah Orang Tua</option>
                                                <option value="Tempat Lain">Tempat Lain</option>
                                                <option value="Tidak Ada Tempat Tinggal">Tidak Ada Tempat Tinggal
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status tinggal dengan keluarga</label>
                                            <select class="form-select" name="sosial_ekonomi_tinggal_dengan_keluarga">
                                                <option value="">--Pilih--</option>
                                                <option value="Dengan Keluarga">Dengan Keluarga</option>
                                                <option value="Tidak Dengan Keluarga">Tidak Dengan Keluarga</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Curiga penganiayaan</label>
                                            <select class="form-select" name="sosial_ekonomi_curiga_penganiayaan">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Ada</option>
                                                <option value="0">Tidak Ada</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <textarea class="form-control" name="sosial_ekonomi_keterangan_lain" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">11. Status Gizi</h5>
                                        <div class="form-group mb-4">
                                            <select class="form-select" name="gizi_jenis" id="nutritionAssessment">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Malnutrition Screening Tool (MST)</option>
                                                <option value="2">The Mini Nutritional Assessment (MNA)</option>
                                                <option value="3">Strong Kids (1 bln - 18 Tahun)</option>
                                                {{-- <option value="4">Nutrtition Risk Screening 2002 (NRS 2002)</option> --}}
                                                <option value="5">Tidak Dapat Dinilai</option>
                                            </select>
                                        </div>

                                        <!-- MST Form -->
                                        <div id="mst" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami penurunan BB yang
                                                    tidak
                                                    diinginkan dalam 6 bulan
                                                    terakhir?</label>
                                                <select class="form-select" name="gizi_mst_penurunan_bb">
                                                    <option value="">pilih</option>
                                                    <option value="0">Tidak ada penurunan Berat Badan (BB)
                                                    </option>
                                                    <option value="2">Tidak yakin/ tidak tahu/ terasa baju lebi
                                                        longgar</option>
                                                    <option value="3">Ya ada penurunan BB</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB",
                                                    berapa
                                                    penurunan BB
                                                    tersebut?</label>
                                                <select class="form-select" name="gizi_mst_jumlah_penurunan_bb">
                                                    <option value="0">pilih</option>
                                                    <option value="1">1-5 kg</option>
                                                    <option value="2">6-10 kg</option>
                                                    <option value="3">11-15 kg</option>
                                                    <option value="4">>15 kg</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah asupan makan berkurang karena tidak
                                                    nafsu
                                                    makan?</label>
                                                <select class="form-select" name="gizi_mst_nafsu_makan_berkurang">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer
                                                    (kemoterapi), Geriatri, GGk
                                                    (hemodialisis), Penurunan Imum</label>
                                                <select class="form-select" name="gizi_mst_diagnosis_khusus">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <!-- Nilai -->
                                            <div id="mstConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko
                                                    malnutrisi
                                                </div>
                                                <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi
                                                </div>
                                                <input type="hidden" name="gizi_mst_kesimpulan"
                                                    id="gizi_mst_kesimpulan">
                                            </div>
                                        </div>

                                        <!-- MNA Form -->
                                        <div id="mna" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi The Mini Nutritional Assessment (MNA) /
                                                Lansia</h6>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Apakah pasien mengalami penurunan asupan makanan selama 3 bulan
                                                    terakhir
                                                    karena hilang selera makan, masalah pencernaan, kesulitan mengunyah
                                                    atau
                                                    menelan?
                                                </label>
                                                <select class="form-select" name="gizi_mna_penurunan_asupan_3_bulan">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0">Mengalami penurunan asupan makanan yang
                                                        parah
                                                    </option>
                                                    <option value="1">Mengalami penurunan asupan makanan sedang
                                                    </option>
                                                    <option value="2">Tidak mengalami penurunan asupan makanan
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Apakah pasien mengalami kehilangan Berat Badan (BB) selama 3 bulan
                                                    terakhir?
                                                </label>
                                                <select class="form-select" name="gizi_mna_kehilangan_bb_3_bulan">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="0">Kehilangan BB lebih dari 3 Kg</option>
                                                    <option value="1">Tidak tahu</option>
                                                    <option value="2">Kehilangan BB antara 1 s.d 3 Kg</option>
                                                    <option value="3">Tidak ada kehilangan BB</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana mobilisasi atau pergerakan
                                                    pasien?</label>
                                                <select class="form-select" name="gizi_mna_mobilisasi">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="0">Hanya di tempat tidur atau kursi roda
                                                    </option>
                                                    <option value="1">Dapat turun dari tempat tidur tapi tidak
                                                        dapat
                                                        jalan-jalan</option>
                                                    <option value="2">Dapat jalan-jalan</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Apakah Pasien mengalami stres psikologi atau penyakit akut selama 3
                                                    bulan terakhir?
                                                </label>
                                                <select class="form-select" name="gizi_mna_stress_penyakit_akut">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="1">Tidak</option>
                                                    <option value="0">Ya</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami masalah
                                                    neuropsikologi?</label>
                                                <select class="form-select" name="gizi_mna_status_neuropsikologi">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="0">Demensia atau depresi berat</option>
                                                    <option value="1">Demensia ringan</option>
                                                    <option value="2">Tidak mengalami masalah neuropsikologi
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                                <input type="number" name="gizi_mna_berat_badan" class="form-control"
                                                    id="mnaWeight" min="1" step="0.1"
                                                    placeholder="Masukkan berat badan dalam Kg">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Berapa Tinggi Badan (TB) pasien?
                                                    (cm)</label>
                                                <input type="number" name="gizi_mna_tinggi_badan"
                                                    class="form-control" id="mnaHeight" min="1"
                                                    step="0.1" placeholder="Masukkan tinggi badan dalam cm">
                                            </div>

                                            <!-- IMT -->
                                            <div class="mb-3">
                                                <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                                <div class="text-muted small mb-2">
                                                    <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                                </div>
                                                <input type="number" name="gizi_mna_imt"
                                                    class="form-control bg-light" id="mnaBMI" readonly
                                                    placeholder="IMT akan terhitung otomatis">
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div id="mnaConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-info mb-3">
                                                    Silakan isi semua parameter di atas untuk melihat kesimpulan
                                                </div>
                                                <div class="alert alert-success" style="display: none;">
                                                    Kesimpulan: Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)
                                                </div>
                                                <div class="alert alert-warning" style="display: none;">
                                                    Kesimpulan: Total Skor ≤ 11 (Beresiko Malnutrisi)
                                                </div>
                                                <input type="hidden" name="gizi_mna_kesimpulan"
                                                    id="gizi_mna_kesimpulan">
                                            </div>
                                        </div>

                                        <!-- Strong Kids Form -->
                                        <div id="strong-kids" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah anak tampa kurus kehilangan lemak
                                                    subkutan, kehilangan massa otot, dan/ atau wajah cekung?</label>
                                                <select class="form-select" name="gizi_strong_status_kurus">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah terdapat penurunan BB selama satu
                                                    bulan
                                                    terakhir (untuk semua usia)?
                                                    (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif
                                                    dari
                                                    orang tua pasien ATAu
                                                    tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1
                                                        tahun) selama 3 bulan terakhir)</label>
                                                        <select class="form-select" name="gizi_strong_penurunan_bb">
                                                            <option value="">pilih</option>
                                                            <option value="1">Ya</option>
                                                            <option value="0">Tidak</option>
                                                        </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Apakah salah satu dari hal berikut ini ada?
                                                    <br>
                                                    - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai
                                                    perhari)
                                                    selama 1-3 hari terakhir
                                                    - Penurunan asupan makanan selama 1-3 hari terakhir
                                                    - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau
                                                    pemberian
                                                    maka selang)</label>
                                                <select class="form-select" name="gizi_strong_gangguan_pencernaan">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah terdapat penyakit atau keadaan yang
                                                    mengakibatkan pasien berisiko
                                                    mengalaman mainutrisi? <br>
                                                    <a href="#"><i>Lihat penyakit yang berisiko
                                                            malnutrisi</i></a></label>
                                                <select class="form-select" name="gizi_strong_penyakit_berisiko">
                                                    <option value="">pilih</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <!-- Nilai -->
                                            <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-success">Kesimpulan: 0 (Beresiko rendah)</div>
                                                <div class="alert alert-warning">Kesimpulan: 1-3 (Beresiko sedang)
                                                </div>
                                                <div class="alert alert-success">Kesimpulan: 4-5 (Beresiko Tinggi)
                                                </div>
                                                <input type="hidden" name="gizi_strong_kesimpulan"
                                                    id="gizi_strong_kesimpulan">
                                            </div>
                                        </div>

                                        <!-- Form NRS -->
                                        <div id="nrs" class="risk-form">
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
                                                <input type="hidden" name="gizi_nrs_kesimpulan"
                                                    id="gizi_nrs_kesimpulan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">12. Status Fungsional</h5>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status Fungsional</label>
                                            <select class="form-select" name="status_fungsional">
                                                <option value="">--Pilih--</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="Ketergantungan Ringan">Ketergantungan Ringan</option>
                                                <option value="Ketergantungan Sedang">Ketergantungan Sedang</option>
                                                <option value="Ketergantungan Berat">Ketergantungan Berat</option>
                                                <option value="Ketergantungan Total">Ketergantungan Total</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">13. Kebutuhan Edukasi, Pendidikan dan Pengajaran
                                        </h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Gaya bicara</label>
                                            <select class="form-select" name="kebutuhan_edukasi_gaya_bicara">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Normal</option>
                                                <option value="1">Tidak Normal</option>
                                                <option value="2">Belum Bisa Bicara</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bahasa sehari-hari</label>
                                            <select class="form-select" name="kebutuhan_edukasi_bahasa_sehari_hari">
                                                <option value="">--Pilih--</option>
                                                <option value="">--Pilih--</option>
                                                <option value="aceh">Aceh</option>
                                                <option value="batak">Batak</option>
                                                <option value="minangkabau">Minangkabau</option>
                                                <option value="melayu">Melayu</option>
                                                <option value="sunda">Sunda</option>
                                                <option value="jawa">Jawa</option>
                                                <option value="madura">Madura</option>
                                                <option value="bali">Bali</option>
                                                <option value="sasak">Sasak</option>
                                                <option value="banjar">Banjar</option>
                                                <option value="bugis">Bugis</option>
                                                <option value="toraja">Toraja</option>
                                                <option value="makassar">Makassar</option>
                                                <option value="dayak">Dayak</option>
                                                <option value="tidung">Tidung</option>
                                                <option value="ambon">Ambon</option>
                                                <option value="ternate">Ternate</option>
                                                <option value="tidore">Tidore</option>
                                                <option value="papua">Papua</option>
                                                <option value="asmat">Asmat</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Perlu penerjemah</label>
                                            <select class="form-select" name="kebutuhan_edukasi_perlu_penerjemah">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Hambatan komunikasi</label>
                                            <select class="form-select" name="kebutuhan_edukasi_hambatan_komunikasi">
                                                <option value="">--Pilih--</option>
                                                <option value="bahasa">Bahasa</option>
                                                <option value="menulis">Menulis</option>
                                                <option value="cemas">Cemas</option>
                                                <option value="cemas">Cemas</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Media belajar yang disukai</label>
                                            <select class="form-select" name="kebutuhan_edukasi_media_belajar">
                                                <option value="">--Pilih--</option>
                                                <option value="audio">Audio-Visual</option>
                                                <option value="brosur">Brosur</option>
                                                <option value="diskusi">Diskusi</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tingkat pendidikan</label>
                                            <select class="form-select" name="kebutuhan_edukasi_tingkat_pendidikan">
                                                <option value="">--Pilih--</option>
                                                <option value="sd">SD</option>
                                                <option value="smp">SMP</option>
                                                <option value="sma">SMA</option>
                                                <option value="sarjana">Sarjana</option>
                                                <option value="master">Master</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Edukasi yang dibutuhkan</label>
                                            <select class="form-select" name="kebutuhan_edukasi_edukasi_dibutuhkan">
                                                <option value="">--Pilih--</option>
                                                <option value="Proses Penyakit">Proses Penyakit</option>
                                                <option value="Pengobatan/Tindakan">Pengobatan/Tindakan</option>
                                                <option value="Terapi/Obat">Terapi/Obat</option>
                                                <option value="Nutrisi">Nutrisi</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <textarea class="form-control" name="kebutuhan_edukasi_keterangan_lain" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">14. Discharge Planning</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis medis</label>
                                            <input type="text" class="form-control"
                                                name="discharge_planning_diagnosis_medis" id="diagnosis_medis">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Usia lanjut</label>
                                            <select class="form-select discharge-select"
                                                name="discharge_planning_usia_lanjut" id="usia_lanjut">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Hambatan mobilisasi</label>
                                            <select class="form-select discharge-select"
                                                name="discharge_planning_hambatan_mobilisasi" id="hambatan_mobilisasi">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Membutuhkan pelayanan medis
                                                berkelanjutan</label>
                                            <select class="form-select discharge-select"
                                                name="discharge_planning_pelayanan_medis"
                                                id="pelayanan_medis_berkelanjutan">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Ketergantungan dengan orang lain dalam
                                                aktivitas harian</label>
                                            <select class="form-select discharge-select"
                                                name="discharge_planning_ketergantungan_aktivitas"
                                                id="ketergantungan_aktivitas">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group mt-4">
                                            <label style="min-width: 200px;">KESIMPULAN</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="alert alert-warning" id="kesimpulan_khusus"
                                                    style="display: none;">
                                                    Membutuhkan rencana pulang khusus
                                                </div>
                                                <div class="alert alert-success" id="kesimpulan_tidak_khusus"
                                                    style="display: none;">
                                                    Tidak membutuhkan rencana pulang khusus
                                                </div>
                                            </div>
                                            <input type="hidden" name="discharge_planning_kesimpulan"
                                                id="kesimpulan_value">
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
                                                <input type="hidden" name="masalah_keperawatan"
                                                    id="masalahKeperawatanValue">
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

                                    <div class="section-separator">
                                        <h5 class="section-title">15. Evaluasi</h5>

                                        <div class="form-group">
                                            <label>Evaluasi</label>
                                            <textarea class="form-control" name="evaluasi" rows="3"></textarea>
                                        </div>
                                    </div>

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
    </div>

    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.modal-tindakankeperawatan')
@endsection
