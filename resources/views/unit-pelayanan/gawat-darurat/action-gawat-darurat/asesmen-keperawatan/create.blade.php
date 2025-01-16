@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.include')

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
                            <div class="px-3">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Tanggal Asesmen</label>
                                            <input type="date" name="tgl_masuk" id="tgl_asesmen_keperawatan"
                                                class="form-control" value="{{ date('Y-m-d') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label">Jam Asesmen</label>
                                            <input type="time" name="tgl_masuk" id="jam_asesmen_keperawatan"
                                                class="form-control" value="{{ date('H:i') }}">
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
                                                <option value="bebas">Bebas</option>
                                                <option value="pangkal lidah jatuh">Tidak Bebas (Pangkal Lidah Jatuh)</option>
                                                <option value="sputum">Tidak Bebas (Sputum)</option>
                                                <option value="darah">Tidak Bebas (darah)</option>
                                                <option value="spasm">Tidak Bebas (Spasm)</option>
                                                <option value="benda asing">Tidak Bebas (Benda Asing)</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suara Nafas</label>
                                            <select class="form-select" name="airway_suara_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="normal">Normal</option>
                                                <option value="whezing">Whezing</option>
                                                <option value="ronchi">Ronchi</option>
                                                <option value="crackles">Crackles</option>
                                                <option value="stridor">Stridor</option>
                                            </select>
                                        </div>
                                        <div class="form-group diagnosis-section" id="airway-diagnosis">
                                            <label style="min-width: 200px;">Diagnosis Keperawatan</label>
                                            <div class="w-100">
                                                <div class="diagnosis-item">
                                                    <!-- Diagnosis 1 -->
                                                    <div class="diagnosis-row border-top border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-radio diagnose-prwt-checkbox"
                                                                    id="jalan_nafas_tidak_efektif" name="airway_diagnosis[]"
                                                                    value="jalan_nafas_tidak_efektif">
                                                                <label class="form-check-label"
                                                                    for="jalan_nafas_tidak_efektif">
                                                                    Jalan nafas tidak efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="airway_aktual" name="airway_diagnosis_type"
                                                                        value="1">
                                                                    <label class="form-check-label"
                                                                        for="airway_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="airway_risiko" name="airway_diagnosis_type"
                                                                        value="2">
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
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanAirwayModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedTindakanList-airway" class="d-flex flex-column gap-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-breathing">
                                        <h5 class="section-title">2. Status Breathing</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Frekuensi nafas/menit</label>
                                            <input type="text" class="form-control" name="breathing_frekuensi_nafas">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pola nafas</label>
                                            <select class="form-select" name="breathing_pola_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Apnea">Apnea</option>
                                                <option value="Sesak">Sesak</option>
                                                <option value="Bradipnea">Bradipnea</option>
                                                <option value="Takipnea">Takipnea</option>
                                                <option value="Othopnea">Othopnea</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bunyi nafas</label>
                                            <select class="form-select" name="breathing_bunyi_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Veskuler">Veskuler</option>
                                                <option value="Wheezing">Whezing</option>
                                                <option value="Stridor">Stridor</option>
                                                <option value="Ronchi">Ronchi</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Irama Nafas</label>
                                            <select class="form-select" name="breathing_irama_nafas">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Teratur</option>
                                                <option value="0">Tidak Teratur</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanda Distress Nafas</label>
                                            <select class="form-select" name="breathing_tanda_distress">
                                                <option value="">--Pilih--</option>
                                                <option value="Tidak Ada Tanda Distress">Tidak Ada Tanda Distress</option>
                                                <option value="Penggunaan Otot Bantu">Penggunaan Otot Bantu</option>
                                                <option value="Retraksi Dada/Intercosta">Retraksi Dada/Intercosta</option>
                                                <option value="Cupling Hidung">Cupling Hidung</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jalan Pernafasan</label>
                                            <select class="form-select" name="breathing_jalan_nafas">
                                                <option value="">Pilih</option>
                                                <option value="1">Pernafasan Dada</option>
                                                <option value="2">Pernafasan Perut</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <input class="form-control" type="text" name="breathing_lainnya">
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
                                                                    id="pola_nafas_tidak_efektif"
                                                                    name="breathing_diagnosis_nafas[]"
                                                                    value="breathing_diagnosis_nafas">
                                                                <label class="form-check-label"
                                                                    for="pola_nafas_tidak_efektif">
                                                                    Pola Nafas Tidak Efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_aktual"
                                                                        name="breathing_gangguan[pola_nafas_tidak_efektif]"
                                                                        value="1">
                                                                    <label class="form-check-label"
                                                                        for="breathing_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_risiko"
                                                                        name="breathing_gangguan[pola_nafas_tidak_efektif]"
                                                                        value="2">
                                                                    <label class="form-check-label"
                                                                        for="breathing_risiko">Risiko</label>
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
                                                                    id="gangguan_pertukaran_gas"
                                                                    name="breathing_diagnosis_nafas[]"
                                                                    value="breathing_diagnosis_nafas">
                                                                <label class="form-check-label"
                                                                    for="gangguan_pertukaran_gas">
                                                                    Gangguan Pertukaran Gas
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_aktual_1"
                                                                        name="breathing_gangguan[gangguan_pertukaran_gas]"
                                                                        value="1">
                                                                    <label class="form-check-label"
                                                                        for="breathing_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="breathing_risiko_1"
                                                                        name="breathing_gangguan[gangguan_pertukaran_gas]"
                                                                        value="2">
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
                                            <label style="min-width: 200px;">Tindakan Keperawatan</label>
                                            <div class="w-100">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanBreathingModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedTindakanList-breathing" class="d-flex flex-column gap-2">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">3. Status Circulation</h5>

                                        <div class="form-group" id="status-disability">
                                            <label style="min-width: 200px;">Nadi Frekuensi/menit</label>
                                            <input type="text" class="form-control" name="circulation_nadi_frekuensi">
                                        </div>

                                        <div class="form-group">
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
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Akral</label>
                                            <select class="form-select" name="circulation_akral">
                                                <option value="">--Pilih--</option>
                                                <option value="Hangat">Hangat</option>
                                                <option value="Dingin">Dingin</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pucat</label>
                                            <select class="form-select" name="circulation_pucat">
                                                <option value="">--Pilih--</option>
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Cianoisis</label>
                                            <select class="form-select" name="circulation_cianoisis">
                                                <option value="">--Pilih--</option>
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pengisian Kapiler</label>
                                            <select class="form-select" name="circulation_pengisian_kapiler">
                                                <option value="">--Pilih--</option>
                                                <option value="< 2 Detik">
                                                    < 2 Detik</option>
                                                <option value="> 2 Detik">> 2 Detik</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kelembapan Kulit</label>
                                            <select class="form-select" name="circulation_kelembapan_kulit">
                                                <option value="">--Pilih--</option>
                                                <option value="Lembab">Lembab</option>
                                                <option value="Kering">Kering</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tugor</label>
                                            <select class="form-select" name="circulation_tugor">
                                                <option value="">--Pilih--</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Kurang">Kurang</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Transfursi Darah</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Diberikan?</small>
                                                    </div>
                                                    <select class="form-select" name="circulation_transfursi_darah">
                                                        <option value="">--Pilih--</option>
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Jumlah Transfursi (cc)</small>
                                                    </div>
                                                    <input class="form-control" type="text"
                                                        name="circulation_jumlah_transfusi">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <input class="form-control" type="text"
                                                placeholder="isikan jika ada keluhan nafas lainnya"
                                                name="circulation_lainnya">
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
                                                                    name="diagnosis_circulation[]"
                                                                    value="perfusi_jaringan_perifer_tidak_efektif">
                                                                <label class="form-check-label"
                                                                    for="perfusi_jaringan_perifer_tidak_efektif">
                                                                    Perfusi Jaringan Perifer Tidak Efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_aktual"
                                                                        name="circulation_diagnosis_type[perfusi_jaringan_perifer_tidak_efektif]"
                                                                        value="aktual">
                                                                    <label class="form-check-label"
                                                                        for="circulation_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_risiko"
                                                                        name="circulation_diagnosis_type[perfusi_jaringan_perifer_tidak_efektif]"
                                                                        value="risiko">
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
                                                                    name="diagnosis_circulation[]"
                                                                    value="defisit_volume_cairan">
                                                                <label class="form-check-label"
                                                                    for="defisit_volume_cairan">
                                                                    Defisit Volume Cairan
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_aktual_1"
                                                                        name="circulation_diagnosis_type[defisit_volume_cairan]"
                                                                        value="aktual">
                                                                    <label class="form-check-label"
                                                                        for="circulation_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="circulation_risiko_1"
                                                                        name="circulation_diagnosis_type[defisit_volume_cairan]"
                                                                        value="risiko">
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
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanCirculationModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedTindakanList-circulation"
                                                    class="d-flex flex-column gap-2">
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
                                                <option value="Compos Mentis">Compos Mentis</option>
                                                <option value="Apatis">Apatis</option>
                                                <option value="Somnolen">Somnolen</option>
                                                <option value="Sopor">Sopor</option>
                                                <option value="Coma">Coma</option>
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
                                                        <option value="Isokor">Isokor</option>
                                                        <option value="Anisokor">Anisokor</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Respon Cahaya</small>
                                                    </div>
                                                    <select class="form-select" name="disability_respon_cahaya">
                                                        <option value="">--Pilih--</option>
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diameter Pupil (mm)</label>
                                            <input type="text" class="form-control" name="disability_diameter_Pupil">
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
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                    </select>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="mb-1">
                                                        <small class="text-muted">Sensorik</small>
                                                    </div>
                                                    <select class="form-select" name="disability_sensorik">
                                                        <option value="">--Pilih--</option>
                                                        <option value="Ya">Ya</option>
                                                        <option value="Tidak">Tidak</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kekuatan Otot</label>
                                            <input class="form-control" type="text" name="disability_kekutan_otot">
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
                                                                    id="perfusi_jaringan_cereberal_tidak_efektif"
                                                                    name="diagnosis_disability[]"
                                                                    value="perfusi_jaringan_cereberal_tidak_efektif">
                                                                <label class="form-check-label"
                                                                    for="perfusi_jaringan_cereberal_tidak_efektif">
                                                                    Perfusi jaringan cereberal tidak efektif
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual"
                                                                        name="disability_diagnosis_type[perfusi_jaringan_cereberal_tidak_efektif]"
                                                                        value="aktual">
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko"
                                                                        name="disability_diagnosis_type[perfusi_jaringan_cereberal_tidak_efektif]"
                                                                        value="risiko">
                                                                    <label class="form-check-label"
                                                                        for="disability_risiko">Risiko</label>
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
                                                                    id="intoleransi_aktivitas"
                                                                    name="diagnosis_disability[]"
                                                                    value="intoleransi_aktivitas">
                                                                <label class="form-check-label"
                                                                    for="intoleransi_aktivitas">
                                                                    Intoleransi aktivitas
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_1"
                                                                        name="disability_diagnosis_type[intoleransi_aktivitas]"
                                                                        value="aktual">
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_1"
                                                                        name="disability_diagnosis_type[intoleransi_aktivitas]"
                                                                        value="risiko">
                                                                    <label class="form-check-label"
                                                                        for="disability_risiko_1">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 3 -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="kendala_komunikasi_verbal"
                                                                    name="diagnosis_disability[]"
                                                                    value="kendala_komunikasi_verbal">
                                                                <label class="form-check-label"
                                                                    for="kendala_komunikasi_verbal">
                                                                    Kendala komunikasi verbal
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_2"
                                                                        name="disability_diagnosis_type[kendala_komunikasi_verbal]"
                                                                        value="aktual">
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual_2">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_2"
                                                                        name="disability_diagnosis_type[kendala_komunikasi_verbal]"
                                                                        value="risiko">
                                                                    <label class="form-check-label"
                                                                        for="disability_risiko_2">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 4 -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="kejang_ulang" name="diagnosis_disability[]"
                                                                    value="kejang_ulang">
                                                                <label class="form-check-label" for="kejang_ulang">
                                                                    Kejang ulang
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_3"
                                                                        name="disability_diagnosis_type[kejang_ulang]"
                                                                        value="aktual">
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual_3">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_3"
                                                                        name="disability_diagnosis_type[kejang_ulang]"
                                                                        value="risiko">
                                                                    <label class="form-check-label"
                                                                        for="disability_risiko_3">Risiko</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Diagnosis 5 -->
                                                    <div class="diagnosis-row border-bottom py-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input diagnosis-checkbox diagnose-prwt-checkbox"
                                                                    id="penurunan_kesadaran" name="diagnosis_disability[]"
                                                                    value="penurunan_kesadaran">
                                                                <label class="form-check-label" for="penurunan_kesadaran">
                                                                    Penurunan kesadaran
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_aktual_4"
                                                                        name="disability_diagnosis_type[penurunan_kesadaran]"
                                                                        value="aktual">
                                                                    <label class="form-check-label"
                                                                        for="disability_aktual_4">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="disability_risiko_4"
                                                                        name="disability_diagnosis_type[penurunan_kesadaran]"
                                                                        value="risiko">
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
                                                        name="disability_lainnya">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tindakan Keperawatan</label>
                                            <div class="w-100">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                    data-bs-target="#tindakanKeperawatanDisabilityModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedTindakanList-disability"
                                                    class="d-flex flex-column gap-2">
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
                                                            id="deformitas_tidak" name="exposure_deformitas"
                                                            value="0">
                                                        <label class="form-check-label"
                                                            for="deformitas_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="deformitas_ya"
                                                            name="exposure_deformitas" value="1">
                                                        <label class="form-check-label" for="deformitas_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="deformitas_daerah"
                                                        placeholder="Daerah">
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
                                                            value="0">
                                                        <label class="form-check-label"
                                                            for="kontusion_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="kontusion_ya"
                                                            name="exposure_kontusion" value="1">
                                                        <label class="form-check-label" for="kontusion_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="kontusion_daerah"
                                                        placeholder="Daerah">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Abrasi</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="abrasi_tidak"
                                                            name="exposure_abrasi" value="0">
                                                        <label class="form-check-label" for="abrasi_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="abrasi_ya"
                                                            name="exposure_abrasi" value="1">
                                                        <label class="form-check-label" for="abrasi_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="abrasi_daerah"
                                                        placeholder="Daerah">
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
                                                            value="0">
                                                        <label class="form-check-label"
                                                            for="penetrasi_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="penetrasi_ya"
                                                            name="exposure_penetrasi" value="1">
                                                        <label class="form-check-label" for="penetrasi_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="penetrasi_daerah"
                                                        placeholder="Daerah">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Laserasi</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input"
                                                            id="laserasi_tidak" name="exposure_laserasi" value="0">
                                                        <label class="form-check-label" for="laserasi_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="laserasi_ya"
                                                            name="exposure_laserasi" value="1">
                                                        <label class="form-check-label" for="laserasi_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="laserasi_daerah"
                                                        placeholder="Daerah">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Edema</label>
                                            <div class="d-flex align-items-center gap-4" style="width: 100%;">
                                                <div class="d-flex gap-4">
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="edema_tidak"
                                                            name="exposure_edema" value="0">
                                                        <label class="form-check-label" for="edema_tidak">Tidak</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" id="edema_ya"
                                                            name="exposure_edema" value="1">
                                                        <label class="form-check-label" for="edema_ya">Ya</label>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="edema_daerah"
                                                        placeholder="Daerah">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kedalaman luka (cm)</label>
                                            <input type="text" class="form-control" name="exposure_kedalaman_luka">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <input type="text" class="form-control" name="exposure_lainnya">
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
                                                                    id="kerusakan_mobilitas_fisik"
                                                                    name="diagnosis_exposure[]"
                                                                    value="kerusakan_mobilitas_fisik">
                                                                <label class="form-check-label"
                                                                    for="kerusakan_mobilitas_fisik">
                                                                    Kerusakan Mobilitas Fisik
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_aktual"
                                                                        name="exposure_diagnosis_type[kerusakan_mobilitas_fisik]"
                                                                        value="aktual">
                                                                    <label class="form-check-label"
                                                                        for="exposure_aktual">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_risiko"
                                                                        name="exposure_diagnosis_type[kerusakan_mobilitas_fisik]"
                                                                        value="risiko">
                                                                    <label class="form-check-label"
                                                                        for="exposure_risiko">Risiko</label>
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
                                                                    id="kerusakan_integritas_jaringan"
                                                                    name="diagnosis_exposure[]"
                                                                    value="kerusakan_integritas_jaringan">
                                                                <label class="form-check-label"
                                                                    for="kerusakan_integritas_jaringan">
                                                                    Kerusakan Integritas Jaringan
                                                                </label>
                                                            </div>
                                                            <div class="d-flex gap-4">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_aktual_1"
                                                                        name="exposure_diagnosis_type[kerusakan_integritas_jaringan]"
                                                                        value="aktual">
                                                                    <label class="form-check-label"
                                                                        for="exposure_aktual_1">Aktual</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input"
                                                                        id="exposure_risiko_1"
                                                                        name="exposure_diagnosis_type[kerusakan_integritas_jaringan]"
                                                                        value="risiko">
                                                                    <label class="form-check-label"
                                                                        for="exposure_risiko_1">Risiko</label>
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
                                                        name="exposure_diagnosis_lainnya">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tindakan Keperawatan</label>
                                            <div class="w-100">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
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
                                            <div class="col-md-12">
                                                <div class="d-flex align-items-start gap-4">
                                                    <div class="d-flex align-items-center gap-3"
                                                        style="min-width: 350px;">
                                                        <input type="number" class="form-control flex-grow-1"
                                                            name="skala_nyeri_nilai" style="width: 100px;" value="0"
                                                            min="0" max="10" required>
                                                        <button class="btn btn-warning btn-sm">
                                                            Nyeri Hebat
                                                        </button>
                                                    </div>
                                                    <div class="pain-scale-image flex-grow-1">
                                                        <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                            alt="Pain Scale" style="width: 450px; height: auto;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Lokasi</label>
                                                    <input type="text" class="form-control" name="skala_nyeri_lokasi">
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Pemberat</label>
                                                    <select class="form-select" name="skala_nyeri_pemberat">
                                                        <option value="">--Pilih--</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Kualitas</label>
                                                    <select class="form-select" name="skala_nyeri_kualitas">
                                                        <option value="">--Pilih--</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Menjalar</label>
                                                    <select class="form-select" name="skala_nyeri_menjalar">
                                                        <option value="">--Pilih--</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Durasi</label>
                                                    <input type="text" class="form-control" name="skala_nyeri_durasi">
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Peringan</label>
                                                    <select class="form-select" name="skala_nyeri_peringan">
                                                        <option value="">--Pilih--</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Frekuensi</label>
                                                    <select class="form-select" name="skala_nyeri_frekuensi">
                                                        <option value="">--Pilih--</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Jenis</label>
                                                    <select class="form-select" name="skala_nyeri_jenis">
                                                        <option value="">--Pilih--</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">7. Risiko Jatuh</h5>

                                        <div class="mb-4">
                                            {{-- <label class="mb-2">Pilih jenis penilaian risiko jatuh sesuai dengan kondisi
                                                pasien:</label>
                                            <select class="form-select" name="risiko_jatuh_skala">
                                                <option value="">--Pilih Skala--</option>
                                                <option value="skala_umum">Skala Umum</option>
                                                <option value="skala_morse">Skala Morse</option>
                                                <option value="skala_humpty">Skala Humpty-Dumpty / Anak</option>
                                                <option value="skala_ontario">Skala Ontario Modified Stratify Sydney / Lansia
                                                </option>
                                                <option value="lainnya">Lainnya</option>
                                            </select> --}}

                                            <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan
                                                kondisi
                                                pasien:</label>
                                            <select class="form-select" id="risikoJatuhSkala"
                                                onchange="showForm(this.value)">
                                                <option value="">--Pilih Skala--</option>
                                                <option value="skala_umum">Skala Umum</option>
                                                <option value="skala_morse">Skala Morse</option>
                                                <option value="skala_humpty">Skala Humpty-Dumpty / Pediatrik</option>
                                                <option value="skala_ontario">Skala Ontario Modified Stratify Sydney /
                                                    Lansia
                                                </option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <!-- Form Skala Umum -->
                                        <div id="skala_umumForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Umum</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien berusia < dari 2 tahun?</label>
                                                        <select class="form-select" onchange="updateConclusion('umum')">
                                                            <option value="">pilih</option>
                                                            <option value="ya">Ya</option>
                                                            <option value="tidak">Tidak</option>
                                                        </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien dalam kondisi sebagai geriatri,
                                                    dizzines, vertigo,
                                                    gangguan keseimbangan, gangguan penglihatan, penggunaan obat sedasi,
                                                    status
                                                    kesadaran dan
                                                    atau kejiwaan, konsumsi alkohol?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien didiagnosis sebagai pasien dengan
                                                    penyakit
                                                    parkinson?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien sedang mendapatkan obat sedasi,
                                                    riwayat
                                                    tirah baring
                                                    lama, perubahan posisi yang akan meningkatkan risiko jatuh?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien saat ini sedang berada pada salah
                                                    satu
                                                    lokasi ini: rehab
                                                    medik, ruangan dengan penerangan kurang dan bertangga?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')">
                                                    <option value="">pilih</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span id="kesimpulanTextForm">Tidak
                                                        berisiko jatuh</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Memperbaiki bagian Form Skala Morse -->
                                        <div id="skala_morseForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Morse</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien pernah mengalami Jatuh?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="25">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki diagnosis skunder?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="15">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien membutuhkan bantuan ambulasi?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Meja/ kursi</option>
                                                    <option value="15">Kruk/ tongkat/ alat bantu berjalan</option>
                                                    <option value="30">Tidak ada/ bed rest/ bantuan perawat</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien terpasang infus?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="20">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Normal/ bed rest/ kursi roda</option>
                                                    <option value="10">Terganggu</option>
                                                    <option value="20">Lemah</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana status mental pasien?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Beroroentasi pada kemampuannya</option>
                                                    <option value="15">Lupa akan keterbatasannya</option>
                                                </select>
                                            </div>
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">Tidak
                                                        berisiko jatuh</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Form Risiko Skala Humpty Dumpty -->
                                        <div id="skala_humptyForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Usia Anak?</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4">Dibawah 3 tahun</option>
                                                    <option value="3">3-7 tahun</option>
                                                    <option value="2">7-13 tahun</option>
                                                    <option value="1">Diatas 13 tahun</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis kelamin</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="2">Laki-laki</option>
                                                    <option value="1">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Diagnosis</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4">Diagnosis Neurologis</option>
                                                    <option value="3">Perubahan oksigennasi (diangnosis respiratorik,
                                                        dehidrasi, anemia,
                                                        syncope, pusing, dsb)</option>
                                                    <option value="2">Gangguan perilaku /psikiatri</option>
                                                    <option value="1">Diagnosis lainnya</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Gangguan Kognitif</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3">Tidak menyadari keterbatasan dirinya</option>
                                                    <option value="2">Lupa akan adanya keterbatasan</option>
                                                    <option value="1">Orientasi baik terhadap dari sendiri</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Faktor Lingkungan</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4">Riwayat jatuh /bayi diletakkan di tempat tidur
                                                        dewasa</option>
                                                    <option value="3">Pasien menggunakan alat bantu /bayi diletakkan
                                                        di
                                                        tempat tidur bayi /
                                                        perabot rumah</option>
                                                    <option value="2">Pasien diletakkan di tempat tidur</option>
                                                    <option value="1">Area di luar rumah sakit</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pembedahan/ sedasi/ Anestesi</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3">Dalam 24 jam</option>
                                                    <option value="2">Dalam 48 jam</option>
                                                    <option value="1">> 48 jam atau tidak menjalani pembedahan
                                                        /sedasi
                                                        /anestesi</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Penggunaan Medika mentosa</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3">Penggunaan multiple: sedative, obat hipnosis,
                                                        barbiturate, fenotiazi,
                                                        antidepresan, pencahar, diuretik, narkose</option>
                                                    <option value="2">Penggunaan salah satu obat diatas</option>
                                                    <option value="1">Penggunaan medikasi lainnya/tidak ada mediksi
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">Tidak
                                                        berisiko jatuh</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Form Skala Humpty Dumpty -->
                                        <div id="skala_ontarioForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify
                                                Sydney/
                                                Lansia</h5>

                                            <!-- 1. Riwayat Jatuh -->
                                            <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                    jatuh?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki 2 kali atau apakah pasien
                                                    mengalami
                                                    jatuh dalam 2
                                                    bulan terakhir ini/ diagnosis multiple?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 2. Status Mental -->
                                            <h6 class="mb-3">2. Status Mental</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien bingung? (Tidak dapat membuat
                                                    keputusan, jaga jarak
                                                    tempatnya, gangguan daya ingat)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan
                                                    waktu, tempat atau
                                                    orang)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami agitasi? (keresahan,
                                                    gelisah, dan
                                                    cemas)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 3. Penglihatan -->
                                            <h6 class="mb-3">3. Penglihatan</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien memiliki kataraks?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami kelainya
                                                    penglihatan/buram?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mempunyai glukoma/ katarak/
                                                    degenerasi
                                                    makula?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
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
                                                    inkontinensia, noktura)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur) -->
                                            <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                                tempat tidur)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Ya</option>
                                                    <option value="1">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                    pengawasan</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                    total</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
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
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Ya</option>
                                                    <option value="1">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                                    fisik)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Menggunakan kusi roda</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Imobilisasi</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">Tidak
                                                        berisiko jatuh</span>
                                                </p>
                                            </div>
                                        </div>


                                        <div class="mb-4">
                                            <h6 class="mb-3">Intervensi Risiko Jatuh</h6>
                                            <p class="mb-2">Tambah tindakan intervensi risiko jatuh:</p>

                                            <button type="button"
                                                class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                data-bs-target="#tindakanKeperawatanRisikoJatuhModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="selectedTindakanList-risikojatuh" class="d-flex flex-column gap-2">
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
                                            <select class="form-select" name="spiritual_agama" required>
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

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pekerjaan</label>
                                            <select class="form-select" name="sosial_pekerjaan">
                                                <option value="">--Pilih--</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tingkat penghasilan</label>
                                            <select class="form-select" name="sosial_tingkat_penghasilan">
                                                <option value="">--Pilih--</option>
                                                <option value="Penghasilan Tinggi">Penghasilan Tinggi</option>
                                                <option value="Penghasilan Sedang">Penghasilan Sedang</option>
                                                <option value="Penghasilan Rendah">Penghasilan Rendah</option>
                                                <option value="Tidak Ada Penghasilan">Tidak Ada Penghasilan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status pernikahan</label>
                                            <select class="form-select" name="sosial_status_pernikahan">
                                                <option value="">--Pilih--</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status pendidikan</label>
                                            <select class="form-select" name="sosial_status_pendidikan">
                                                <option value="">--Pilih--</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tempat tinggal</label>
                                            <select class="form-select" name="sosial_tempat_tinggal">
                                                <option value="">--Pilih--</option>
                                                <option value="Rumah Sendiri">Rumah Sendiri</option>
                                                <option value="Rumah Orang Tua">Rumah Orang Tua</option>
                                                <option value="Tempat Lain">Tempat Lain</option>
                                                <option value="Tidak Ada Tempat Tinggal">Tidak Ada Tempat Tinggal</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status tinggal dengan keluarga</label>
                                            <select class="form-select" name="sosial_status_tinggal_keluarga">
                                                <option value="">--Pilih--</option>
                                                <option value="Dengan Keluarga">Dengan Keluarga</option>
                                                <option value="Tidak Dengan Keluarga">Tidak Dengan Keluarga</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Curiga penganiayaan</label>
                                            <select class="form-select" name="sosial_curiga_penganiayaan">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Ada</option>
                                                <option value="0">Tidak Ada</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lainnya</label>
                                            <textarea class="form-control" name="sosial_ekonomi_lainnya" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        {{-- <h5 class="section-title">11. Status Gizi</h5>
                                        <div class="form-group">
                                            <select class="form-select" name="gizi_status">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Malnutrition Screening Tool (MST)</option>
                                                <option value="2">The Mini Nutritional Assessment (MNA)</option>
                                                <option value="3">Strong Kids (1 bln - 18 Tahun)</option>
                                                <option value="4">Nutrtition Risk Screening 2002 (NRS 2002)</option>
                                                <option value="5">Tidak Dapat Dinilai</option>
                                            </select>
                                        </div> --}}

                                        <h5 class="section-title">11. Status Gizi</h5>
                                        <div class="form-group mb-4">
                                            <select class="form-select" id="nutritionAssessment">
                                                <option value="">--Pilih--</option>
                                                <option value="mst">Malnutrition Screening Tool (MST)</option>
                                                <option value="mna">The Mini Nutritional Assessment (MNA)</option>
                                                <option value="strong-kids">Strong Kids (1 bln - 18 Tahun)</option>
                                                <option value="nrs">Nutrtition Risk Screening 2002 (NRS 2002)</option>
                                                <option value="cannot-assess">Tidak Dapat Dinilai</option>
                                            </select>
                                        </div>

                                        <!-- MST Form -->
                                        <div id="mst" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak
                                                    diinginkan dalam 6 bulan
                                                    terakhir?</label>
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="0">Tidak ada penurunan Berat Badan (BB)</option>
                                                    <option value="2">Tidak yakin/ tidak tahu/ terasa baju lebih
                                                        longgar
                                                    </option>
                                                    <option value="2">Ya ada penurunan BB</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB",
                                                    berapa
                                                    penurunan BB
                                                    tersebut?</label>
                                                <select class="form-select">
                                                    <option value="0">pilih</option>
                                                    <option value="1">1-5 kg</option>
                                                    <option value="2">6-10 kg</option>
                                                    <option value="3">11-15 kg</option>
                                                    <option value="4">>15 kg</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu
                                                    makan?</label>
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer
                                                    (kemoterapi), Geriatri, GGk
                                                    (hemodialisis), Penurunan Imum</label>
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <!-- Nilai -->
                                            <div id="mstConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko malnutrisi
                                                </div>
                                                <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi</div>
                                            </div>
                                        </div>

                                        <!-- MNA Form -->
                                        <div id="mna" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi The Mini Nutritional Assesmen (MNA) / Lansia
                                            </h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami penurunan asupan makanan
                                                    selama 3 bulan terakhir
                                                    dikarnakan hilang selera makan, masalah pencernaan, kesulitan menggunyah
                                                    atau menelan?</label>
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami kehilangan Berat Badan
                                                    (BB)
                                                    selama 3 bulan
                                                    terakhir?</label>
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="0">Kehilangan BB lebih dari 3 Kg</option>
                                                    <option value="2">Tidak tahu</option>
                                                    <option value="3">kehilangan BB antara 1 s.d 3 Kg</option>
                                                    <option value="4">Tidak ada kehilangan BB</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana mobilisasi atau pergerakan
                                                    pasien?</label>
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="0">Hanya di tempat tidur atau kursi roda</option>
                                                    <option value="1">Dapat turun dari tempat tidur tapi tidak dapat
                                                        jalan-jalan</option>
                                                    <option value="2">Dapat jalan-jalan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah Pasien Mengalami stres psikologi atau
                                                    penyakit akut selama 3 bulan
                                                    terakhir?</label>
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami neuropsikologi?</label>
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="0">Dementia atau depresi berat</option>
                                                    <option value="1">Dementia ringan</option>
                                                    <option value="2">Tidak mengalami masalah neuropsikologi</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Berapa Berat Badan (BB) pasien (Kg)?</label>
                                                <input type="number" class="form-control" id="mnaWeight">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Berapa Tinggi Badan (TB) pasien (cm)?</label>
                                                <input type="number" class="form-control" id="mnaHeight">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Indeks Masa Tubuh (IMT)</label>
                                                <br>
                                                <i>Rumus BMI: (BB dalam Kg/kuadrat TB dalam meter)</i>
                                                <input type="number" class="form-control bg-secondary" id="mnaBMI"
                                                    readonly>
                                            </div>
                                            <div id="mnaConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-success">Kesimpulan: ≥ 12 (Tidak Beresiko)</div>
                                                <div class="alert alert-warning">Kesimpulan: ≤ 11 (Beresiko malnutrisi)
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Strong Kids Form -->
                                        <div id="strong-kids" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah anak tampa kurus kehilangan lemak
                                                    subkutan,
                                                    kehilangan massa otot, dan/
                                                    atau wajah cekung?</label>
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah terdapat penurunan BB selama satu bulan
                                                    terakhir (untuk semua usia)?
                                                    (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif
                                                    dari
                                                    orang tua pasien ATAu
                                                    tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1
                                                        tahun) selama 3 bulan terakhir)</label>
                                                        <select class="form-select">
                                                            <option value="">pilih</option>
                                                            <option value="1">Ya</option>
                                                            <option value="0">Tidak</option>
                                                        </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Apakah salah satu dari hal berikut ini ada? <br>
                                                    - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari)
                                                    selama 1-3 hari terakhir
                                                    - Penurunan asupan makanan selama 1-3 hari terakhir
                                                    - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau
                                                    pemberian
                                                    maka selang)</label>
                                                <select class="form-select">
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
                                                <select class="form-select">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <!-- Nilai -->
                                            <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-success">Kesimpulan: 0 (Beresiko rendah)</div>
                                                <div class="alert alert-warning">Kesimpulan: 1-3 (Beresiko sedang)</div>
                                                <div class="alert alert-success">Kesimpulan: 4-5 (Beresiko Tinggi)</div>
                                            </div>
                                        </div>

                                        <!-- Form Skala Humpty Dumpty -->
                                        <div id="nrs" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify
                                                Sydney/
                                                Lansia</h5>

                                            <!-- 1. Riwayat Jatuh -->
                                            <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                    jatuh?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
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
                                                <select class="form-select" onchange="updateConclusion('ontario')">
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
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan
                                                    waktu, tempat atau
                                                    orang)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami agitasi? (keresahan,
                                                    gelisah, dan
                                                    cemas)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 3. Penglihatan -->
                                            <h6 class="mb-3">3. Penglihatan</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien memakai kacamata?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengaluh adanya penglihatan
                                                    buram?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien menpunyai glaukoma/ katarak/
                                                    degenerasi makula?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
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
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur) -->
                                            <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                                tempat tidur)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Ya</option>
                                                    <option value="1">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                    pengawasan</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                    total</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
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
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Ya</option>
                                                    <option value="1">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                                    fisik)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Menggunakan kusi roda</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Imobilisasi</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
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
                                            </div>
                                        </div>

                                        <!-- Tambahkan div untuk cannot-assess -->
                                        <div id="cannot-assess" class="assessment-form" style="display: none;">
                                            <div class="alert alert-info">
                                                Pasien tidak dapat dinilai status gizinya
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
                                        <h5 class="section-title">13. Kebutuhan Edukasi, Pendidikan dan Pengajaran</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Gaya bicara</label>
                                            <select class="form-select" name="kebutuhan_edukasi_gaya_bicara">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Normal</option>
                                                <option value="1">Tidak Normal</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bahasa sehari-hari</label>
                                            <select class="form-select" name="kebutuhan_edukasi_bahasa_sehari_hari">
                                                <option value="">--Pilih--</option>
                                                <option value="aceh">Aceh</option>
                                                <option value="melayu">Melayu</option>
                                                <option value="jawa">Jawa</option>
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
                                            <input type="text" class="form-control" name="discharge_planning_diagnosis_medis" id="diagnosis_medis" required>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Usia lanjut</label>
                                            <select class="form-select discharge-select" name="discharge_planning_usia_lanjut" id="usia_lanjut" required>
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Hambatan mobilisasi</label>
                                            <select class="form-select discharge-select" name="discharge_planning_hambatan_mobilisasi" id="hambatan_mobilisasi" required>
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Membutuhkan pelayanan medis berkelanjutan</label>
                                            <select class="form-select discharge-select" name="discharge_planning_pelayanan_medis" id="pelayanan_medis_berkelanjutan" required>
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Ketergantungan dengan orang lain dalam aktivitas harian</label>
                                            <select class="form-select discharge-select" name="discharge_planning_ketergantungan_aktivitas" id="ketergantungan_aktivitas" required>
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group mt-4">
                                            <label style="min-width: 200px;">KESIMPULAN</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="alert alert-warning" id="kesimpulan_khusus" style="display: none;">
                                                    Membutuhkan rencana pulang khusus
                                                </div>
                                                <div class="alert alert-success" id="kesimpulan_tidak_khusus" style="display: none;">
                                                    Tidak membutuhkan rencana pulang khusus
                                                </div>
                                            </div>
                                            <input type="hidden" name="discharge_planning_kesimpulan" id="kesimpulan_value">
                                        </div>
                                    </div>

                                    {{-- <div class="section-separator">
                                        <h5 class="section-title">15. Masalah Keperawatan</h5>
                                        <div class="form-group">
                                            <div class="w-100">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="searchMasalah" placeholder="Cari dan tambah masalah keperawatan">
                                                    <div class="search-results" id="masalahResults" style="display: none;"></div>
                                                    <button class="btn btn-outline-secondary" type="button" id="btnTambahMasalah">
                                                        <i class="ti-plus"></i> Tambah
                                                    </button>
                                                </div>
                                                <div id="selectedMasalahList" class="d-flex flex-column gap-2"></div>
                                                <input type="hidden" name="masalah_keperawatan" id="masalahKeperawatanValue">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">16. Implementasi</h5>
                                        <div class="form-group">
                                            <div class="w-100">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="searchImplementasi" placeholder="Cari dan tambah Implementasi">
                                                    <div class="search-results" id="implementasiResults" style="display: none;"></div>
                                                    <button class="btn btn-outline-secondary" type="button" id="btnTambahImplementasi">
                                                        <i class="ti-plus"></i> Tambah
                                                    </button>
                                                </div>
                                                <div id="selectedImplementasiList" class="d-flex flex-column gap-2"></div>
                                                <input type="hidden" name="implementasi" id="implementasiValue">
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="section-separator">
                                        <h5 class="section-title">15. Masalah Keperawatan</h5>
                                        <div class="form-group">
                                            <div class="w-100">
                                                <select class="form-control select2" id="selectMasalah" style="width: 100%;">
                                                    <option value="">Pilih Masalah Keperawatan</option>
                                                    <optgroup label="Masalah Keperawatan">
                                                        <option value="nyeri_akut">Nyeri akut</option>
                                                        <option value="gangguan_mobilitas">Gangguan mobilitas fisik</option>
                                                        <option value="risiko_infeksi">Risiko infeksi</option>
                                                        <option value="gangguan_tidur">Gangguan pola tidur</option>
                                                        <option value="kecemasan">Kecemasan</option>
                                                        <option value="defisit_perawatan">Defisit perawatan diri</option>
                                                        <option value="gangguan_eliminasi">Gangguan eliminasi</option>
                                                        <option value="risiko_jatuh">Risiko jatuh</option>
                                                        <option value="ketidakseimbangan_nutrisi">Ketidakseimbangan nutrisi</option>
                                                        <option value="gangguan_kulit">Gangguan integritas kulit</option>
                                                    </optgroup>
                                                </select>

                                                <div id="selectedMasalahList" class="selected-items mt-3">
                                                    <!-- Selected items will appear here -->
                                                </div>
                                                <input type="hidden" name="masalah_keperawatan" id="masalahKeperawatanValue">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">16. Implementasi</h5>
                                        <div class="form-group">
                                            <div class="w-100">
                                                <select class="form-control select2" id="selectImplementasi" style="width: 100%;">
                                                    <option value="">Pilih Implementasi</option>
                                                    <optgroup label="Implementasi">
                                                        <option value="monitoring_vital">Monitoring tanda vital</option>
                                                        <option value="manajemen_nyeri">Manajemen nyeri</option>
                                                        <option value="bantuan_mobilisasi">Bantuan mobilisasi</option>
                                                        <option value="pencegahan_infeksi">Pencegahan infeksi</option>
                                                        <option value="perawatan_luka">Perawatan luka</option>
                                                        <option value="pemberian_obat">Pemberian obat</option>
                                                        <option value="edukasi_pasien">Edukasi pasien</option>
                                                        <option value="bantuan_eliminasi">Bantuan eliminasi</option>
                                                        <option value="manajemen_nutrisi">Manajemen nutrisi</option>
                                                        <option value="pencegahan_jatuh">Pencegahan jatuh</option>
                                                    </optgroup>
                                                </select>

                                                <div id="selectedImplementasiList" class="selected-items mt-3">
                                                    <!-- Selected items will appear here -->
                                                </div>
                                                <input type="hidden" name="implementasi" id="implementasiValue">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">17. Evaluasi</h5>

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
