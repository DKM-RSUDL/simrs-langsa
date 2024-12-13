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
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Asesmen</label>
                                        <input type="date" name="tgl_asesmen_keperawatan" id="tgl_asesmen_keperawatan"
                                            class="form-control" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="time" name="jam_asesmen_keperawatan" id="jam_asesmen_keperawatan"
                                            class="form-control" value="{{ date('H:i') }}">
                                    </div>
                                </div>
                                <div class="col-md-7">
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
                                </div>
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
                                        <select class="form-select" name="status_airway">
                                            <option value="bebas">Bebas</option>
                                            <option value="pangkal_lidah_jatuh">Tidak Bebas (Pangkal Lidah Jatuh)</option>
                                            <option value="sputum">Tidak Bebas (Sputum)</option>
                                            <option value="darah">Tidak Bebas (darah)</option>
                                            <option value="spasm">Tidak Bebas (Spasm)</option>
                                            <option value="benda_asing">Tidak Bebas (Benda Asing)</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Suara Nafas</label>
                                        <select class="form-select" name="suara_nafas">
                                            <option selected disabled>Pilih</option>
                                            <option value="normal">Normal</option>
                                            <option value="whezing">Whezing</option>
                                            <option value="ronchi">Ronchi</option>
                                            <option value="crackles">Crackles</option>
                                            <option value="stridor">Stridor</option>
                                        </select>
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
                                                                class="form-check-input diagnosis-radio"
                                                                id="jalan_nafas_tidak_efektif" name="diagnosis[]"
                                                                value="jalan_nafas_tidak_efektif" data-aktual="aktual_1"
                                                                data-risiko="risiko_1">
                                                            <label class="form-check-label" for="jalan_nafas_tidak_efektif">
                                                                Jalan nafas tidak efektif
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]" value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_1" name="diagnosis_type[]" value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_1">Risiko</label>
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
                                        <input type="text" class="form-control" name="frekuensi_nafas"
                                            placeholder="frekuensi nafas per menit">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pola nafas</label>
                                        <select class="form-select" name="pola_nafas">
                                            <option selected disabled>pilih</option>
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
                                        <select class="form-select" name="bunyi_nafas">
                                            <option selected disabled>Pilih</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Veskuler">Veskuler</option>
                                            <option value="Wheezing">Whezing</option>
                                            <option value="Stridor">Stridor</option>
                                            <option value="Ronchi">Ronchi</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Irama Nafas</label>
                                        <select class="form-select" name="irama_nafas">
                                            <option selected disabled>Pilih</option>
                                            <option value="Teratur">Teratur</option>
                                            <option value="Tidak Teratur">Tidak Teratur</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanda Distress Nafas</label>
                                        <select class="form-select" name="tanda_distress_nafas">
                                            <option selected disabled>Pilih</option>
                                            <option value="Tidak Ada Tanda Distress">Tidak Ada Tanda Distress</option>
                                            <option value="Penggunaan Otot Bantu">Penggunaan Otot Bantu</option>
                                            <option value="Retraksi Dada/Intercosta">Retraksi Dada/Intercosta</option>
                                            <option value="Cupling Hidung">Cupling Hidung</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jalan Pernafasan</label>
                                        <select class="form-select" name="jalan_pernafasan">
                                            <option selected disabled>Pilih</option>
                                            <option value="Pernafasan Dada">Pernafasan Dada</option>
                                            <option value="Pernafasan Perut">Pernafasan Perut</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lainnya</label>
                                        <input class="form-control" type="text">
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
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="pola_nafas_tidak_efektif" name="diagnosis[]"
                                                                value="pola_nafas_tidak_efektif" data-aktual="aktual_1"
                                                                data-risiko="risiko_1">
                                                            <label class="form-check-label"
                                                                for="pola_nafas_tidak_efektif">
                                                                Pola Nafas Tidak Efektif
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_1" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_1">Risiko</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diagnosis 2 -->
                                                <div class="diagnosis-row border-bottom py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="gangguan_pertukaran_gas" name="diagnosis[]"
                                                                value="gangguan_pertukaran_gas" data-aktual="aktual_2"
                                                                data-risiko="risiko_2">
                                                            <label class="form-check-label" for="gangguan_pertukaran_gas">
                                                                Gangguan Pertukaran Gas
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_2" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_2">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_2" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_2">Risiko</label>
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
                                        <input type="text" class="form-control" name="nadi_frekuensi"
                                            placeholder="frekuensi nafas per menit">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tekanan Darah (mmHg)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <div class="mb-1">
                                                    <small class="text-muted">Sistole</small>
                                                </div>
                                                <input class="form-control" type="text" name="sistole"
                                                    placeholder="sistole">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="mb-1">
                                                    <small class="text-muted">Diastole</small>
                                                </div>
                                                <input class="form-control" type="text" name="diastole"
                                                    placeholder="diastole">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Akral</label>
                                        <select class="form-select" name="akral">
                                            <option selected disabled>Pilih</option>
                                            <option value="Hangat">Hangat</option>
                                            <option value="Dingin">Dingin</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pucat</label>
                                        <select class="form-select" name="pucat">
                                            <option selected disabled>Pilih</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Cianoisis</label>
                                        <select class="form-select" name="cianoisis">
                                            <option selected disabled>Pilih</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pengisian Kapiler</label>
                                        <select class="form-select" name="pengisian_kapiler">
                                            <option selected disabled>Pilih</option>
                                            <option value="< 2 Detik">
                                                < 2 Detik</option>
                                            <option value="> 2 Detik">> 2 Detik</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kelembapan Kulit</label>
                                        <select class="form-select" name="kelembapan_kulit">
                                            <option selected disabled>Pilih</option>
                                            <option value="Lembab">Lembab</option>
                                            <option value="Kering">Kering</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tugor</label>
                                        <select class="form-select" name="tugor">
                                            <option selected disabled>Pilih</option>
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
                                                <select class="form-select" name="Transfursi_darah">
                                                    <option selected disabled>Pilih</option>
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="mb-1">
                                                    <small class="text-muted">Jumlah Transfursi (cc)</small>
                                                </div>
                                                <input class="form-control" type="text" name="diastole">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lainnya</label>
                                        <input class="form-control" type="text"
                                            placeholder="isikan jika ada keluhan nafas lainnya">
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
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="diagnosis_1" name="diagnosis[]"
                                                                value="perfusi_jaringan_cereberal" data-aktual="aktual_1"
                                                                data-risiko="risiko_1">
                                                            <label class="form-check-label" for="diagnosis_1">
                                                                Perfusi Jaringan Perifer Tidak Efektif
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_1" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_1">Risiko</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diagnosis 2 -->
                                                <div class="diagnosis-row border-bottom py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="diagnosis_2" name="diagnosis[]"
                                                                value="intoleransi_aktivitas" data-aktual="aktual_2"
                                                                data-risiko="risiko_2">
                                                            <label class="form-check-label" for="diagnosis_2">
                                                                Defisit Volume Cairan
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_2" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_2">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_2" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_2">Risiko</label>
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
                                            <div id="selectedTindakanList-circulation" class="d-flex flex-column gap-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">4. Status Disability</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option selected disabled>Pilih</option>
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
                                                <select class="form-select" name="isokor">
                                                    <option selected disabled>Pilih</option>
                                                    <option value="Isokor">Isokor</option>
                                                    <option value="Anisokor">Anisokor</option>
                                                </select>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="mb-1">
                                                    <small class="text-muted">Respon Cahaya</small>
                                                </div>
                                                <select class="form-select" name="respon_cahaya">
                                                    <option selected disabled>Pilih</option>
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Diameter Pupil (mm)</label>
                                        <input type="text" class="form-control" name="diameter_Pupil">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Ekstremitas</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <div class="mb-1">
                                                    <small class="text-muted">Motorik</small>
                                                </div>
                                                <select class="form-select" name="motorik">
                                                    <option selected disabled>Pilih</option>
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="mb-1">
                                                    <small class="text-muted">Sensorik</small>
                                                </div>
                                                <select class="form-select" name="sensorik">
                                                    <option selected disabled>Pilih</option>
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kekuatan Otot</label>
                                        <input class="form-control" type="text" name="kekutan_otot">
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
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="diagnosis_1" name="diagnosis[]"
                                                                value="perfusi_jaringan_cereberal" data-aktual="aktual_1"
                                                                data-risiko="risiko_1">
                                                            <label class="form-check-label" for="diagnosis_1">
                                                                Perfusi jaringan cereberal tidak efektif
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_1" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_1">Risiko</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diagnosis 2 -->
                                                <div class="diagnosis-row border-bottom py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="diagnosis_2" name="diagnosis[]"
                                                                value="intoleransi_aktivitas" data-aktual="aktual_2"
                                                                data-risiko="risiko_2">
                                                            <label class="form-check-label" for="diagnosis_2">
                                                                Intoleransi aktivitas
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_2" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_2">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_2" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_2">Risiko</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diagnosis 3 -->
                                                <div class="diagnosis-row border-bottom py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="diagnosis_3" name="diagnosis[]"
                                                                value="kendala_komunikasi" data-aktual="aktual_3"
                                                                data-risiko="risiko_3">
                                                            <label class="form-check-label" for="diagnosis_3">
                                                                Kendala komunikasi verbal
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_3" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_3">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_3" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_3">Risiko</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diagnosis 4 -->
                                                <div class="diagnosis-row border-bottom py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="diagnosis_4" name="diagnosis[]" value="kejang_ulang"
                                                                data-aktual="aktual_4" data-risiko="risiko_4">
                                                            <label class="form-check-label" for="diagnosis_4">
                                                                Kejang ulang
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_4" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_4">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_4" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_4">Risiko</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diagnosis 5 -->
                                                <div class="diagnosis-row border-bottom py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="diagnosis_5" name="diagnosis[]"
                                                                value="penurunan_kesadaran" data-aktual="aktual_5"
                                                                data-risiko="risiko_5">
                                                            <label class="form-check-label" for="diagnosis_5">
                                                                Penurunan kesadaran
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_5" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_5">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_5" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_5">Risiko</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Input untuk diagnosis lainnya -->
                                            <div class="mt-3">
                                                <label class="form-label">Lainnya:</label>
                                                <input type="text" class="form-control"
                                                    placeholder="isikan jika ada diagnosis lainnya">
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
                                                        name="deformitas" value="tidak">
                                                    <label class="form-check-label" for="deformitas_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="deformitas_ya"
                                                        name="deformitas" value="ya">
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
                                                    <input type="radio" class="form-check-input" id="kontusion_tidak"
                                                        name="kontusion" value="tidak">
                                                    <label class="form-check-label" for="kontusion_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="kontusion_ya"
                                                        name="kontusion" value="ya">
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
                                                        name="abrasi" value="tidak">
                                                    <label class="form-check-label" for="abrasi_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="abrasi_ya"
                                                        name="abrasi" value="ya">
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
                                                    <input type="radio" class="form-check-input" id="penetrasi_tidak"
                                                        name="penetrasi" value="tidak">
                                                    <label class="form-check-label" for="penetrasi_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="penetrasi_ya"
                                                        name="penetrasi" value="ya">
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
                                                    <input type="radio" class="form-check-input" id="laserasi_tidak"
                                                        name="laserasi" value="tidak">
                                                    <label class="form-check-label" for="laserasi_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="laserasi_ya"
                                                        name="laserasi" value="ya">
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
                                                        name="edema" value="tidak">
                                                    <label class="form-check-label" for="edema_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="edema_ya"
                                                        name="edema" value="ya">
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
                                        <input type="text" class="form-control" name="kedalaman_luka">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lainnya</label>
                                        <input type="text" class="form-control" name="lainnya">
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
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="diagnosis_1" name="diagnosis[]"
                                                                value="perfusi_jaringan_cereberal" data-aktual="aktual_1"
                                                                data-risiko="risiko_1">
                                                            <label class="form-check-label" for="diagnosis_1">
                                                                Kerusakan Mobilitas Fisik
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_1" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_1">Risiko</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diagnosis 2 -->
                                                <div class="diagnosis-row border-bottom py-2">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                class="form-check-input diagnosis-checkbox"
                                                                id="diagnosis_2" name="diagnosis[]"
                                                                value="intoleransi_aktivitas" data-aktual="aktual_2"
                                                                data-risiko="risiko_2">
                                                            <label class="form-check-label" for="diagnosis_2">
                                                                Kerusakan Integritas Jaringan
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="aktual_2" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_2">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input"
                                                                    id="risiko_2" name="diagnosis_type[]"
                                                                    value="risiko">
                                                                <label class="form-check-label"
                                                                    for="risiko_2">Risiko</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Input untuk diagnosis lainnya -->
                                            <div class="mt-3">
                                                <label class="form-label">Lainnya:</label>
                                                <input type="text" class="form-control"
                                                    placeholder="isikan jika ada diagnosis lainnya">
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
                                                <div class="d-flex align-items-center gap-3" style="min-width: 350px;">
                                                    <input type="number" class="form-control flex-grow-1"
                                                        style="width: 100px;" value="0" min="0"
                                                        max="10">
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
                                                <input type="text" class="form-control" name="lokasi">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 120px;">Pemberat</label>
                                                <select class="form-select" name="pemberat">
                                                    <option value="" selected disabled>---Pilih---</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 120px;">Kualitas</label>
                                                <select class="form-select" name="kualitas">
                                                    <option value="" selected disabled>---Pilih---</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 120px;">Menjalar</label>
                                                <select class="form-select" name="menjalar">
                                                    <option value="" selected disabled>---Pilih---</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label style="min-width: 120px;">Durasi</label>
                                                <input type="text" class="form-control" name="durasi">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 120px;">Peringan</label>
                                                <select class="form-select" name="peringan">
                                                    <option value="" selected disabled>---Pilih---</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 120px;">Frekuensi</label>
                                                <select class="form-select" name="frekuensi">
                                                    <option value="" selected disabled>---Pilih---</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 120px;">Jenis</label>
                                                <select class="form-select" name="jenis">
                                                    <option value="" selected disabled>---Pilih---</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">7. Risiko Jatuh</h5>

                                    <div class="mb-4">
                                        <label class="mb-2">Pilih jenis penilaian risiko jatuh sesuai dengan kondisi
                                            pasien:</label>
                                        <select class="form-select" name="skala_risiko_jatuh">
                                            <option value="" selected disabled>Pilih skala</option>
                                        </select>
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
                                        <select class="form-select" name="kondisi_psikologis">
                                            <option value="" selected disabled>pilih</option>
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
                                        <label style="min-width: 300px;">Potensi menyakiti diri sendiri/orang lain</label>
                                        <select class="form-select" name="potensi_menyakiti">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="Tidak">Tidak</option>
                                            <option value="Ya">Ya</option>
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
                                        <select class="form-select" name="agama_kepercayaan">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Budha">Budha</option>
                                            <option value="Konghucu">Konghucu</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Nilai Nilai Spritiual Pasien</label>
                                        <textarea class="form-control" name="niailai_spiritual" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">10. Status Sosial Ekonomi</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pekerjaan</label>
                                        <select class="form-select" name="pekerjaan">
                                            <option value="" selected disabled>Nanti Sesuai Database</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat penghasilan</label>
                                        <select class="form-select" name="tingkat_penghasilan">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="Penghasilan Tinggi">Penghasilan Tinggi</option>
                                            <option value="Penghasilan Sedang">Penghasilan Sedang</option>
                                            <option value="Penghasilan Rendah">Penghasilan Rendah</option>
                                            <option value="Tidak Ada Penghasilan">Tidak Ada Penghasilan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status pernikahan</label>
                                        <select class="form-select" name="status_pernikahan">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Tidak Menikah">Tidak Menikah</option>
                                            <option value="Cerai">Cerai</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status pendidikan</label>
                                        <select class="form-select" name="status_pendidikan">
                                            <option value="" selected disabled>Sesuai Database</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tempat tinggal</label>
                                        <select class="form-select" name="tempat_tinggal">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="Rumah Sendiri">Rumah Sendiri</option>
                                            <option value="Rumah Orang Tua">Rumah Orang Tua</option>
                                            <option value="Tempat Lain">Tempat Lain</option>
                                            <option value="Tidak Ada Tempat Tinggal">Tidak Ada Tempat Tinggal</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status tinggal dengan keluarga</label>
                                        <select class="form-select" name="status_tinggal_keluarga">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="Dengan Keluarga">Dengan Keluarga</option>
                                            <option value="Tidak Dengan Keluarga">Tidak Dengan Keluarga</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Curiga penganiayaan</label>
                                        <select class="form-select" name="curiga_penganiayaan">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="Ada">Ada</option>
                                            <option value="Tidak Ada">Tidak Ada</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lainnya</label>
                                        <textarea class="form-control" name="sosial_ekonomi_lainnya" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">11. Status Gizi</h5>
                                    <div class="form-group">
                                        <select class="form-select" name="status_gizi">
                                            <option value="" selected disabled>Pilih Skala</option>
                                            <option value="1">Malnutrition Screening Tool (MST)</option>
                                            <option value="2">The Mini Nutritional Assessment (MNA)</option>
                                            <option value="3">Strong Kids (1 bln - 18 Tahun)</option>
                                            <option value="4">Nutrtition Risk Screening 2002 (NRS 2002)</option>
                                            <option value="5">Tidak Dapat Dinilai</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">12. Status Fungsional</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status Fungsional</label>
                                        <select class="form-select" name="status_fungsional">
                                            <option value="" selected disabled>pilih</option>
                                            <option value="Mnadiri">Mnadiri</option>
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
                                        <select class="form-select" name="gaya_bicara">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Bahasa sehari-hari</label>
                                        <select class="form-select" name="bahasa_sehari_hari">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Perlu penerjemah</label>
                                        <select class="form-select" name="perlu_penerjemah">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hambatan komunikasi</label>
                                        <select class="form-select" name="hambatan_komunikasi">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media belajar yang disukai</label>
                                        <select class="form-select" name="media_belajar">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat pendidikan</label>
                                        <select class="form-select" name="tingkat_pendidikan">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Edukasi yang dibutuhkan</label>
                                        <select class="form-select" name="edukasi_dibutuhkan">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lainnya</label>
                                        <textarea class="form-control" name="edukasi_lainnya" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">14. Discharge Planning</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Diagnosis medis</label>
                                        <input type="text" class="form-control" name="diagnosis_medis">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Usia lanjut</label>
                                        <select class="form-select" name="usia_lanjut">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hambatan mobilisasi</label>
                                        <select class="form-select" name="hambatan_mobilisasi">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Membutuhkan pelayanan medis berkelanjutan</label>
                                        <select class="form-select" name="pelayanan_medis_berkelanjutan">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Ketergantungan dengan orang lain dalam aktivitas
                                            harian</label>
                                        <select style="min-width: 50%;" class="form-select"
                                            name="ketergantungan_aktivitas">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group mt-4">
                                        <label style="min-width: 200px;">KESIMPULAN</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="alert alert-warning">
                                                Membutuhkan rencana pulang khusus
                                            </div>
                                            <div class="alert alert-success">
                                                Tidak membutuhkan rencana pulang khusus
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">15. Masalah Keperawatan</h5>

                                    <div class="form-group">
                                        <div class="w-100">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="searchMasalah"
                                                    placeholder="Cari dan tambah masalah keperawatan">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="btnTambahMasalah">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                            </div>
                                            <div id="selectedMasalahList" class="d-flex flex-column gap-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">16. Implementasi</h5>

                                    <div class="form-group">
                                        <div class="w-100">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="searchImplementasi"
                                                    placeholder="Cari dan tambah Implementasi">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="btnTambahImplementasi">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                            </div>
                                            <div id="selectedImplementasiList" class="d-flex flex-column gap-2">
                                            </div>
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.modal-tindakankeperawatan')
