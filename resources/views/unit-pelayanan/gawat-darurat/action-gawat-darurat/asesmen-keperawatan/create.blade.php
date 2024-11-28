@extends('layouts.administrator.master')


@section('content')
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
                                                                class="form-check-input diagnosis-checkbox" id="jalan_nafas_tidak_efektif"
                                                                name="diagnosis[]" value="jalan_nafas_tidak_efektif"
                                                                data-aktual="aktual_1" data-risiko="risiko_1">
                                                            <label class="form-check-label" for="jalan_nafas_tidak_efektif">
                                                                Jalan nafas tidak efektif
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]" value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                id="btnTambahTindakan">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="selectedTindakanList" class="d-flex flex-column gap-2">
                                            </div>

                                            <!-- Modal for intervention selection -->
                                            <div class="modal fade" id="tindakanModal" tabindex="-1"
                                                aria-labelledby="tindakanModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tindakanModalLabel">Tindakan
                                                                keperawatan</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="text-muted small">[ket: multiple choice]</p>
                                                            <div class="tindakan-options">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan1" value="Bersihkan jalan nafas">
                                                                    <label class="form-check-label"
                                                                        for="tindakan1">Bersihkan jalan nafas</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan2" value="Memasang collar neck">
                                                                    <label class="form-check-label"
                                                                        for="tindakan2">Memasang collar neck</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan3" value="Suction/ penghisapan">
                                                                    <label class="form-check-label"
                                                                        for="tindakan3">Suction/ penghisapan</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan4"
                                                                        value="Melakukan head tilt- chin lift">
                                                                    <label class="form-check-label"
                                                                        for="tindakan4">Melakukan head tilt- chin
                                                                        lift</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan5" value="Melakukan jaw thrust">
                                                                    <label class="form-check-label"
                                                                        for="tindakan5">Melakukan jaw thrust</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan6"
                                                                        value="Melakukan oro/ nasofaringeal airway">
                                                                    <label class="form-check-label"
                                                                        for="tindakan6">Melakukan oro/ nasofaringeal
                                                                        airway</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan7" value="Melakukan Heimlick manuver">
                                                                    <label class="form-check-label"
                                                                        for="tindakan7">Melakukan Heimlick manuver</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan8"
                                                                        value="Melakukan posisi nyaman fowler/semi fowler">
                                                                    <label class="form-check-label"
                                                                        for="tindakan8">Melakukan posisi nyaman fowler/semi
                                                                        fowler</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan9"
                                                                        value="Mengajarkan tekhnik batuk efektif">
                                                                    <label class="form-check-label"
                                                                        for="tindakan9">Mengajarkan tekhnik batuk
                                                                        efektif</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="tindakan10" value="Lainnya">
                                                                    <label class="form-check-label"
                                                                        for="tindakan10">Lainnya</label>
                                                                </div>
                                                                <div class="mt-3 lainnya-input" style="display: none;">
                                                                    <input type="text" class="form-control"
                                                                        id="tindakanLainnya"
                                                                        placeholder="Sebutkan tindakan lainnya">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="button" class="btn btn-primary"
                                                                id="btnSimpanTindakan">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                            <label class="form-check-label" for="pola_nafas_tidak_efektif">
                                                                Pola Nafas Tidak Efektif
                                                            </label>
                                                        </div>
                                                        <div class="d-flex gap-4">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_2" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_2">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="tambahTindakanBreathing">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="tindakanBreathingList" class="d-flex flex-column gap-2">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal for breathing interventions -->
                                    <div class="modal fade" id="tindakanBreathingModal" tabindex="-1" aria-labelledby="tindakanBreathingModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="tindakanBreathingModalLabel">Tindakan keperawatan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="text-muted small">[ket: multiple choice]</p>
                                                    <div class="tindakan-breathing-options">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="tindakanBreathing1" value="Observasi frekuensi, irama, kedalaman pernafasan jalan nafas">
                                                            <label class="form-check-label" for="tindakanBreathing1">Observasi frekuensi, irama, kedalaman pernafasan jalan nafas</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="tindakanBreathing2" value="Observasi tanda-tanda distress pernafasan; penggunaan otot bantu; retraksi intercostae; nafas cuping hidung">
                                                            <label class="form-check-label" for="tindakanBreathing2">Observasi tanda-tanda distress pernafasan; penggunaan otot bantu; retraksi intercostae; nafas cuping hidung</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="tindakanBreathing3" value="Memberikan posisi semi fowler jika tidak ada kontra indikasi">
                                                            <label class="form-check-label" for="tindakanBreathing3">Memberikan posisi semi fowler jika tidak ada kontra indikasi</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="tindakanBreathing4" value="Melakukan fisioterapi dada jika tidak ada kontra indikasi">
                                                            <label class="form-check-label" for="tindakanBreathing4">Melakukan fisioterapi dada jika tidak ada kontra indikasi</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="tindakanBreathing5" value="Berikan oksigen O2">
                                                            <label class="form-check-label" for="tindakanBreathing5">Berikan oksigen O2</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="tindakanBreathing6" value="Pemeriksaan AGD">
                                                            <label class="form-check-label" for="tindakanBreathing6">Pemeriksaan AGD</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="tindakanBreathing7" value="Lainnya">
                                                            <label class="form-check-label" for="tindakanBreathing7">Lainnya</label>
                                                        </div>
                                                        <div class="mt-3 lainnya-breathing-input" style="display: none;">
                                                            <input type="text" class="form-control" id="tindakanBreathingLainnya" placeholder="Sebutkan tindakan lainnya">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="button" class="btn btn-primary" id="btnSimpanTindakanBreathing">Simpan</button>
                                                </div>
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
                                            <option value="< 2 Detik">< 2 Detik</option>
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_2" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_2">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                id="tambahTindakan">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="tindakanList" class="d-flex flex-column gap-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">4. Status Disablity</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option selected disabled>Pilih</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pupil</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <div class="mb-1">
                                                    <small class="text-muted">Isokor</small>
                                                </div>
                                                <input class="form-control" type="text" name="isokor">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="mb-1">
                                                    <small class="text-muted">Respon Cahaya</small>
                                                </div>
                                                <input class="form-control" type="text" name="respon_cahaya">
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
                                                <input class="form-control" type="text" name="motorik">
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="mb-1">
                                                    <small class="text-muted">Sensorik</small>
                                                </div>
                                                <input class="form-control" type="text" name="sensorik">
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_2" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_2">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_3" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_3">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_4" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_4">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_5" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_5">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                id="tambahTindakan">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="tindakanList" class="d-flex flex-column gap-2">
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
                                                    <input type="checkbox" class="form-check-input" id="deformitas_tidak"
                                                        name="deformitas" value="tidak">
                                                    <label class="form-check-label" for="deformitas_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="deformitas_ya"
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
                                                    <input type="checkbox" class="form-check-input" id="kontusion_tidak"
                                                        name="kontusion" value="tidak">
                                                    <label class="form-check-label" for="kontusion_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="kontusion_ya"
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
                                                    <input type="checkbox" class="form-check-input" id="abrasi_tidak"
                                                        name="abrasi" value="tidak">
                                                    <label class="form-check-label" for="abrasi_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="abrasi_ya"
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
                                                    <input type="checkbox" class="form-check-input" id="penetrasi_tidak"
                                                        name="penetrasi" value="tidak">
                                                    <label class="form-check-label" for="penetrasi_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="penetrasi_ya"
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
                                                    <input type="checkbox" class="form-check-input" id="laserasi_tidak"
                                                        name="laserasi" value="tidak">
                                                    <label class="form-check-label" for="laserasi_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="laserasi_ya"
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
                                                    <input type="checkbox" class="form-check-input" id="edema_tidak"
                                                        name="edema" value="tidak">
                                                    <label class="form-check-label" for="edema_tidak">Tidak</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="edema_ya"
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_1" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_1">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="aktual_2" name="diagnosis_type[]"
                                                                    value="aktual">
                                                                <label class="form-check-label"
                                                                    for="aktual_2">Aktual</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input"
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
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                id="tambahTindakan">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="tindakanList" class="d-flex flex-column gap-2">
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

                                        <div class="tindakan-list mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="me-2">1.</span>
                                                <span>Edukasi pasien dan keluarga</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="me-2">2.</span>
                                                <span>Pasang pita kuning</span>
                                            </div>
                                        </div>

                                        <button type="button"
                                            class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2">
                                            <i class="ti-plus"></i>
                                            <span>Tambah</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="section-separator">
                                    <h5 class="section-title">8. Status Psikologis</h5>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Kondisi psikologis</label>
                                        <select class="form-select" name="kondisi_psikologis">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Potensi menyakiti diri sendiri/orang lain</label>
                                        <select class="form-select" name="potensi_menyakiti">
                                            <option value="" selected disabled>pilih</option>
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
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat penghasilan</label>
                                        <select class="form-select" name="tingkat_penghasilan">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status pernikahan</label>
                                        <select class="form-select" name="status_pernikahan">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status pendidikan</label>
                                        <select class="form-select" name="status_pendidikan">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tempat tinggal</label>
                                        <select class="form-select" name="tempat_tinggal">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status tinggal dengan keluarga</label>
                                        <select class="form-select" name="status_tinggal_keluarga">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Curiga penganiayaan</label>
                                        <select class="form-select" name="curiga_penganiayaan">
                                            <option value="" selected disabled>pilih</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lainnya</label>
                                        <textarea class="form-control" name="sosial_ekonomi_lainnya" rows="3"></textarea>
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

@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen-keperawatan.include')
