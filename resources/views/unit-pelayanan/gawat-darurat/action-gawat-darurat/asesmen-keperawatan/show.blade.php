<div class="modal fade" id="showasesmenKeperawatanModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detail Asesmen Keperawatan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Patient Card -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ asset('assets/img/profile.jpg') }}" class="img-fluid rounded"
                                    alt="Patient Photo">
                            </div>
                            <div class="col-md-9">
                                <h5 class="card-title" id="patientName">-</h5>
                                <p class="card-text" id="patientGender">-</p>
                                <p class="card-text" id="patientAge">-</p>
                                <p class="text-muted" id="assessmentDate">-</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Airway -->
                <div class="tab-pane fade show">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>1. Status Air way</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status Airway :</label>
                                        <p id="showAirwayStatus" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Suara Nafas :</label>
                                        <p id="showAirwaySuaraNafas" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Diagnosis Keperawatan :</label>
                                        <p id="showBreathingPolaNafas" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tindakan Keperawatan :</label>
                                        <ul class="list-unstyled border-start border-primary ps-2"
                                            id="showBreathingTandaDistress"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Breathing -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>2. Status Breathing</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pola Nafas :</label>
                                        <p id="breathingPolaNafas" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Bunyi nafas :</label>
                                        <p id="breathingBunyiNafas" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Irama Nafas :</label>
                                        <p id="breathing_irama_nafas" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanda Distress Nafas :</label>
                                        <p id="breathing_tanda_distress" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jalan Pernafasan :</label>
                                        <p id="breathing_jalan_nafas" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lainnya :</label>
                                        <p id="breathing_lainnya" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <span class="form-label fw-bold">Diagnosis Keperawatan :</span><br>
                                        <p class="form-control-plaintext">Pola Nafas Tidak Efektif : <span
                                                id="breathing_diagnosis_nafas"></span></p>
                                        <p class="form-control-plaintext border-bottom">Gangguan Pertukaran Gas : <span
                                                id="breathing_gangguan"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tindakan Keperawatan :</label>
                                        <ul class="list-unstyled border-start border-primary ps-2"
                                            id="breathing_tindakan"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Circulation -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>3. Status Circulation</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Akral :</label>
                                        <p id="circulation_akral" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pucat :</label>
                                        <p id="circulationPucat" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Cianoisis :</label>
                                        <p id="circulationCianosis" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pengisian Kapiler :</label>
                                        <p id="circulation_kapiler" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kelembapan Kulit :</label>
                                        <p id="circulation_kelembapan_kulit"
                                            class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tugor :</label>
                                        <p id="circulation_turgor" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Transfursi Darah :</label>
                                        <p id="circulation_transfusi"></p>
                                        <p class="form-control-plaintext border-bottom">Jumlah Transfursi (cc) : <span
                                                id="circulation_transfusi_jumlah"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lainnya :</label>
                                        <p id="circulation_lain" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <span class="form-label fw-bold">Diagnosis Keperawatan :</span><br>
                                        <p class="form-control-plaintext">Perfusi Jaringan Perifer Tidak Efektif :
                                            <span id="circulation_diagnosis_perfusi"></span>
                                        </p>
                                        <p class="form-control-plaintext border-bottom">Defisit Volume Cairan : <span
                                                id="circulation_diagnosis_defisit"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tindakan Keperawatan :</label>
                                        <ul class="list-unstyled border-start border-primary ps-2"
                                            id="circulation_tindakan"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Disability -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>4. Status Disability</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kesadaran :</label>
                                        <p id="disability_kesadaran" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <span class="form-label fw-bold">Pupil :</span><br>
                                        <p class="form-control-plaintext">Isokor/Anisokor : <span
                                                id="disability_isokor"></span></p>
                                        <p class="form-control-plaintext border-bottom">Respon Cahaya : <span
                                                id="disability_respon_cahaya"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Diameter Pupil (mm) :</label>
                                        <p id="disability_diameter_pupil"
                                            class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <span class="form-label fw-bold">Ekstremitas :</span><br>
                                        <p class="form-control-plaintext">Motorik : <span
                                                id="disability_motorik"></span></p>
                                        <p class="form-control-plaintext border-bottom">Sensorik : <span
                                                id="disability_sensorik"></span></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kekuatan Otot :</label>
                                        <p id="disability_kekuatan_otot" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <span class="form-label fw-bold">Diagnosis Keperawatan :</span><br>
                                        <p class="form-control-plaintext">Perfusi jaringan cereberal tidak efektif :
                                            <span id="disability_diagnosis_perfusi"></span>
                                        </p>
                                        <p class="form-control-plaintext">Intoleransi aktivitas : <span
                                                id="disability_diagnosis_intoleransi"></span></p>
                                        <p class="form-control-plaintext">Kendala komunikasi verbal : <span
                                                id="disability_diagnosis_komunikasi"></span></p>
                                        <p class="form-control-plaintext">Kejang ulang : <span
                                                id="disability_diagnosis_kejang"></span></p>
                                        <p class="form-control-plaintext border-bottom">Penurunan kesadaran : <span
                                                id="disability_diagnosis_kesadaran"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lainnya :</label>
                                        <p id="disability_lainnya" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tindakan Keperawatan :</label>
                                        <ul class="list-unstyled border-start border-primary ps-2"
                                            id="disability_tindakan"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exposure -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>5. Status Exposure</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Deformitas :</label>
                                        <p id="exposure_deformitas" class="form-control-plaintext"></p>
                                        <p class="form-control-plaintext border-bottom">Daerah : <span
                                                id="exposure_deformitas_daerah"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kontusion :</label>
                                        <p id="exposure_kontusion" class="form-control-plaintext"></p>
                                        <p class="form-control-plaintext border-bottom">Daerah : <span
                                                id="exposure_kontusion_daerah"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Abrasi :</label>
                                        <p id="exposure_abrasi" class="form-control-plaintext"></p>
                                        <p class="form-control-plaintext border-bottom">Daerah : <span
                                                id="exposure_abrasi_daerah"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Penetrasi :</label>
                                        <p id="exposure_penetrasi" class="form-control-plaintext"></p>
                                        <p class="form-control-plaintext border-bottom">Daerah : <span
                                                id="exposure_penetrasi_daerah"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Laserasi :</label>
                                        <p id="exposure_laserasi" class="form-control-plaintext"></p>
                                        <p class="form-control-plaintext border-bottom">Daerah : <span
                                                id="exposure_laserasi_daerah"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Edema :</label>
                                        <p id="exposure_edema" class="form-control-plaintext"></p>
                                        <p class="form-control-plaintext border-bottom">Daerah : <span
                                                id="exposure_edema_daerah"></span></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kedalaman luka (cm) :</label>
                                        <p id="exposure_kedalaman_luka" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lainnya :</label>
                                        <p id="exposure_lainnya" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Diagnosis Keperawatan :</label>
                                        <p class="form-control-plaintext">Kerusakan Mobilitas Fisik : <span
                                                id="exposure_diagnosis_mobilitasi"></span></p>
                                        <p class="form-control-plaintext">Kerusakan Integritas Jaringan : <span
                                                id="exposure_diagosis_integritas"></span></p>
                                        <p class="form-control-plaintext border-bottom">Lainnya: : <span
                                                id="exposure_diagnosis_lainnya"></span></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tindakan Keperawatan :</label>
                                        <ul class="list-unstyled border-start border-primary ps-2"
                                            id="exposure_tindakan"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Skala Nyeri -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>6. Skala Nyeri</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Skala Nyeri :</label>
                                        <p id="skala_nyeri" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lokasi :</label>
                                        <p id="skala_nyeri_lokasi" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pemberat :</label>
                                        <p id="skala_nyeri_pemberat_id" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kualitas :</label>
                                        <p id="skala_nyeri_kualitas_id" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Menjalar :</label>
                                        <p id="skala_nyeri_menjalar_id" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Durasi :</label>
                                        <p id="skala_nyeri_durasi" class="form-control-plaintext  border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Peringan :</label>
                                        <p id="skala_nyeri_peringan_id" class="form-control-plaintext  border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Frekuensi :</label>
                                        <p id="skala_nyeri_frekuensi_id"
                                            class="form-control-plaintext  border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jenis :</label>
                                        <p id="skala_nyeri_jenis_id" class="form-control-plaintext  border-bottom">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 7. Risiko Jatuh -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>7. Risiko Jatuh</h5>
                            <!-- Form Skala Umum -->
                            <div id="form_skala_umum" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien berusia < dari 2 tahun?
                                                    :</label>
                                                    <p id="risiko_jatuh_umum_usia"
                                                        class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien dalam kondisi sebagai
                                                geriatri, dizzines, vertigo, gangguan keseimbangan, gangguan
                                                penglihatan, penggunaan obat sedasi, status kesadaran dan atau kejiwaan,
                                                konsumsi alkohol? :</label>
                                            <p id="risiko_jatuh_umum_kondisi_khusus"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien didiagnosis sebagai pasien
                                                dengan penyakit parkinson? :</label>
                                            <p id="risiko_jatuh_umum_diagnosis_parkinson"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien sedang mendapatkan obat
                                                sedasi, riwayat tirah baring lama, perubahan posisi yang akan
                                                meningkatkan risiko jatuh? :</label>
                                            <p id="risiko_jatuh_umum_pengobatan_berisiko"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien saat ini sedang berada pada
                                                salah satu lokasi ini: rehab medik, ruangan dengan penerangan kurang dan
                                                bertangga? :</label>
                                            <p id="risiko_jatuh_umum_lokasi_berisiko"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kesimpulan :</label>
                                            <p id="risiko_jatuh_umum_kesimpulan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Skala Morse -->
                            <div id="form_skala_morse" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pasien pernah mengalami Jatuh? :</label>
                                            <p id="risiko_jatuh_morse_riwayat_jatuh"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pasien memiliki diagnosis skunder?
                                                :</label>
                                            <p id="risiko_jatuh_morse_diagnosis_sekunder"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pasien membutuhkan bantuan ambulasi?
                                                :</label>
                                            <p id="risiko_jatuh_morse_bantuan_ambulasi"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pasien terpasang infus? :</label>
                                            <p id="risiko_jatuh_morse_terpasang_infus"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Bagaimana cara berjalan pasien? :</label>
                                            <p id="risiko_jatuh_morse_cara_berjalan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Bagaimana status mental pasien? :</label>
                                            <p id="risiko_jatuh_morse_status_mental"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kesimpulan :</label>
                                            <p id="risiko_jatuh_morse_kesimpulan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Isi form humpty -->
                            <div id="form_skala_humpty" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Usia Anak? :</label>
                                            <p id="risiko_jatuh_pediatrik_usia_anak"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Jenis kelamin :</label>
                                            <p id="risiko_jatuh_pediatrik_jenis_kelamin"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis :</label>
                                            <p id="risiko_jatuh_pediatrik_diagnosis"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Gangguan Kognitif :</label>
                                            <p id="risiko_jatuh_pediatrik_gangguan_kognitif"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Faktor Lingkungan :</label>
                                            <p id="risiko_jatuh_pediatrik_faktor_lingkungan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pembedahan/ sedasi/ Anestesi :</label>
                                            <p id="risiko_jatuh_pediatrik_pembedahan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Penggunaan Medika mentosa :</label>
                                            <p id="risiko_jatuh_pediatrik_penggunaan_mentosa"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kesimpulan :</label>
                                            <p id="risiko_jatuh_pediatrik_kesimpulan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Isi form ontario -->
                            <div id="form_skala_ontario" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="fw-bold">1. Riwayat Jatuh</span>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien datang kerumah sakit karena
                                                jatuh? :</label>
                                            <p id="risiko_jatuh_lansia_jatuh_saat_masuk_rs"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pasien memiliki 2 kali atau apakah pasien
                                                mengalami jatuh dalam 2 bulan terakhir ini/ diagnosis multiple?
                                                :</label>
                                            <p id="risiko_jatuh_lansia_riwayat_jatuh_2_bulan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <span class="fw-bold">2. Status Mental</span>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien bingung? (Tidak dapat
                                                membuat keputusan, jaga jarak tempatnya, gangguan daya ingat) :</label>
                                            <p id="risiko_jatuh_lansia_status_bingung"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien disorientasi? (tidak
                                                menyadarkan waktu, tempat atau orang) :</label>
                                            <p id="risiko_jatuh_lansia_status_disorientasi"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien mengalami agitasi?
                                                (keresahan, gelisah, dan cemas) :</label>
                                            <p id="risiko_jatuh_lansia_status_agitasi"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <span class="fw-bold">3. Status Mental</span>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien memakai Kacamata? :</label>
                                            <p id="risiko_jatuh_lansia_kacamata"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien mengalami kelainya
                                                penglihatan/buram? :</label>
                                            <p id="risiko_jatuh_lansia_kelainan_penglihatan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien mempunyai glukoma/ katarak/
                                                degenerasi makula? :</label>
                                            <p id="risiko_jatuh_lansia_glukoma"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <span class="fw-bold">4. Kebiasaan Berkemih</span>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah terdapat perubahan perilaku
                                                berkemih? (frekuensi, urgensi, inkontinensia, noktura) :</label>
                                            <p id="risiko_jatuh_lansia_perubahan_berkemih"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="fw-bold">5. Transfer (dari tempat tidur ke kursi dan kembali lagi
                                            ke tempat tidur)</span>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mandiri (boleh menolak saat bantu jatuh)
                                                :</label>
                                            <p id="risiko_jatuh_lansia_transfer_mandiri"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Memerlukan sedikit bantuan (1 orang) /
                                                dalam pengawasan :</label>
                                            <p id="risiko_jatuh_lansia_transfer_bantuan_sedikit"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Memerlukan bantuan yang nyata (2 orang)
                                                :</label>
                                            <p id="risiko_jatuh_lansia_transfer_bantuan_nyata"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tidak dapat duduk dengan seimbang, perlu
                                                bantuan total :</label>
                                            <p id="risiko_jatuh_lansia_transfer_bantuan_total"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <span class="fw-bold">6. Mobilitas Pasien</span>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mandiri (dapat menggunakan alat bantu
                                                jalan) :</label>
                                            <p id="risiko_jatuh_lansia_mobilitas_mandiri"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">berjalan dengan bantuan 1 orang (verbal/
                                                fisik) :</label>
                                            <p id="risiko_jatuh_lansia_mobilitas_bantuan_1_orang"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Menggunakan kusi roda :</label>
                                            <p id="risiko_jatuh_lansia_mobilitas_kursi_roda"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Imobilisasi :</label>
                                            <p id="risiko_jatuh_lansia_mobilitas_imobilisasi"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kesimpulan :</label>
                                            <p id="risiko_jatuh_lansia_kesimpulan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="form_tidak_ada_resiko" style="display: none;">
                                <p>Tidak ada risiko jatuh yang teridentifikasi</p>
                            </div>

                            <label class="form-label fw-bold">Resiko Jatuh Tindakan :</label>
                            <ul class="list-unstyled border-start border-primary ps-2" id="risik_jatuh_tindakan"></ul>

                        </div>
                    </div>
                </div>

                <!-- 8. Status Psikologis -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>8. Status Psikologis</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kondisi psikologis :</label>
                                        <p id="psikologis_kondisi" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Potensi menyakiti diri sendiri/orang lain
                                            :</label>
                                        <p id="psikologis_potensi_menyakiti"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lainnya :</label>
                                        <p id="psikologis_lainnya" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 9. Status Spiritual -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>9. Status Spiritual</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Agama/Kepercayaan :</label>
                                        <p id="spiritual_agama" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nilai Nilai Spritiual Pasien :</label>
                                        <p id="spiritual_nilai" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 10. Status Sosial Ekonomi -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>10. Status Sosial Ekonomi</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Pekerjaan :</label>
                                        <p id="sosial_ekonomi_pekerjaan" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tingkat penghasilan :</label>
                                        <p id="sosial_ekonomi_tingkat_penghasilan"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status pernikahan :</label>
                                        <p id="sosial_ekonomi_status_pernikahan"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status pendidikan :</label>
                                        <p id="sosial_ekonomi_status_pendidikan"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tempat tinggal :</label>
                                        <p id="sosial_ekonomi_tempat_tinggal"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status tinggal dengan keluarga :</label>
                                        <p id="sosial_ekonomi_tinggal_dengan_keluarga"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Curiga penganiayaan :</label>
                                        <p id="sosial_ekonomi_curiga_penganiayaan"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lainnya :</label>
                                        <p id="sosial_ekonomi_keterangan_lain"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 11. Status Gizi -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>11. Status Gizi</h5>
                            <!-- Form mst -->
                            <div id="form_mst" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien mengalami penurunan BB yang
                                                tidak diinginkan dalam 6 bulan terakhir? :</label>
                                            <p id="gizi_mst_penurunan_bb"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Jika jawaban di atas "Ya ada penurunan
                                                BB", berapa penurunan BB tersebut? :</label>
                                            <p id="gizi_mst_jumlah_penurunan_bb"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah asupan makan berkurang karena
                                                tidak nafsu makan? :</label>
                                            <p id="gizi_mst_nafsu_makan_berkurang"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Pasien didiagnosa khusus seperti: DM,
                                                Cancer (kemoterapi), Geriatri, GGk (hemodialisis), Penurunan Imum
                                                :</label>
                                            <p id="gizi_mst_diagnosis_khusus"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kesimpulan</label>
                                            <p id="gizi_mst_kesimpulan" class="form-control-plaintext border-bottom">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form mna -->
                            <div id="form_mna" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien mengalami penurunan asupan
                                                makanan selama 3 bulan terakhir karena hilang selera makan, masalah
                                                pencernaan, kesulitan mengunyah atau menelan? :</label>
                                            <p id="gizi_mna_penurunan_asupan_3_bulan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien mengalami kehilangan Berat
                                                Badan (BB) selama 3 bulan terakhir? :</label>
                                            <p id="gizi_mna_kehilangan_bb_3_bulan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Bagaimana mobilisasi atau pergerakan
                                                pasien? :</label>
                                            <p id="gizi_mna_mobilisasi" class="form-control-plaintext border-bottom">
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah Pasien mengalami stres psikologi
                                                atau penyakit akut selama 3 bulan terakhir? :</label>
                                            <p id="gizi_mna_stress_penyakit_akut"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien mengalami masalah
                                                neuropsikologi? :</label>
                                            <p id="gizi_mna_status_neuropsikologi"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Berapa Berat Badan (BB) pasien? (Kg)
                                                :</label>
                                            <p id="gizi_mna_berat_badan" class="form-control-plaintext border-bottom">
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Berapa Tinggi Badan (TB) pasien? (cm)
                                                :</label>
                                            <p id="gizi_mna_tinggi_badan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Indeks Massa Tubuh (IMT) :</label>
                                            <p id="gizi_mna_imt" class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kesimpulan :</label>
                                            <p id="gizi_mna_kesimpulan" class="form-control-plaintext border-bottom">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form strong-kids -->
                            <div id="form_strong-kids" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah anak tampa kurus kehilangan lemak
                                                subkutan, kehilangan massa otot, dan/ atau wajah cekung? :</label>
                                            <p id="gizi_strong_status_kurus"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah terdapat penurunan BB selama satu
                                                bulan terakhir (untuk semua usia)? (berdasarkan penilaian objektif data
                                                BB bila ada/penilaian subjektif dari orang tua pasien ATAu tidak ada
                                                peningkatan berat badan atau tinggi badan (pada bayi < 1 tahun) selama 3
                                                    bulan terakhir) :</label>
                                                    <p id="gizi_strong_penurunan_bb"
                                                        class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah salah satu dari hal berikut ini
                                                ada?
                                                - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari)
                                                selama 1-3 hari terakhir - Penurunan asupan makanan selama 1-3 hari
                                                terakhir - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau
                                                pemberian maka selang) :</label>
                                            <p id="gizi_strong_gangguan_pencernaan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah terdapat penyakit atau keadaan
                                                yang mengakibatkan pasien berisiko mengalaman mainutrisi?
                                                <a href="#">Lihat penyakit yang berisiko malnutrisi</a> :</label>
                                            <p id="gizi_strong_penyakit_berisiko"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Kesimpulan :</label>
                                            <p id="gizi_strong_kesimpulan"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Form nrs -->
                            <div id="form_nrs" style="display: none;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien berusia < dari 2 tahun?
                                                    :</label>
                                                    <p id="risiko_jatuh_umum_usia"
                                                        class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Apakah pasien sedang mendapatkan obat
                                                sedasi, riwayat tirah baring lama, perubahan posisi yang akan
                                                meningkatkan risiko jatuh? :</label>
                                            <p id="risiko_jatuh_umum_pengobatan_berisiko"
                                                class="form-control-plaintext border-bottom"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="form_tidak_ada_satus_gizi" style="display: none;">
                                <p>Tidak ada status gizi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 12. Status Fungsional -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>12. Status Fungsional</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Status Fungsional :</label>
                                        <p id="status_fungsional" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 13. Kebutuhan Edukasi -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>13. Kebutuhan Edukasi, Pendidikan dan Pengajaran</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Gaya bicara :</label>
                                        <p id="kebutuhan_edukasi_gaya_bicara"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Bahasa sehari-hari :</label>
                                        <p id="kebutuhan_edukasi_bahasa_sehari_hari"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Perlu penerjemah :</label>
                                        <p id="kebutuhan_edukasi_perlu_penerjemah"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Hambatan komunikasi :</label>
                                        <p id="kebutuhan_edukasi_hambatan_komunikasi"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Media belajar yang disukai :</label>
                                        <p id="kebutuhan_edukasi_media_belajar"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tingkat pendidikan :</label>
                                        <p id="kebutuhan_edukasi_tingkat_pendidikan"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Edukasi yang dibutuhkan :</label>
                                        <p id="kebutuhan_edukasi_edukasi_dibutuhkan"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lainnya :</label>
                                        <p id="kebutuhan_edukasi_keterangan_lain"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 14. Discharge Planning -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>14. Discharge Planning</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Diagnosis medis :</label>
                                        <p id="discharge_planning_diagnosis_medis"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Usia lanjut :</label>
                                        <p id="discharge_planning_usia_lanjut"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Hambatan mobilisasi :</label>
                                        <p id="discharge_planning_hambatan_mobilisasi"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Membutuhkan pelayanan medis berkelanjutan
                                            :</label>
                                        <p id="discharge_planning_pelayanan_medis"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Ketergantungan dengan orang lain dalam
                                            aktivitas harian :</label>
                                        <p id="discharge_planning_ketergantungan_aktivitas"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kesimpulan :</label>
                                        <p id="discharge_planning_kesimpulan"
                                            class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 15. Evaluasi -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>15. Evaluasi</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Evaluasi :</label>
                                        <p id="evaluasi" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button
                    class="btn btn-info print-pdf-btn"
                    onclick="printPDF(this)"
                    data-kd-pasien="{{ $dataMedis->kd_pasien }}"
                    data-tgl-masuk="{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d') }}"
                  >
                    <i class="fas fa-print"></i> Print PDF
                  </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>

            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function printPDF(element) {
            const id = element.dataset.id;
            const kdPasien = element.dataset.kdPasien;
            const tglMasuk = element.dataset.tglMasuk;

            if (!id || !kdPasien || !tglMasuk) {
                Swal.fire('Error', 'Data tidak lengkap untuk generate PDF', 'error');
                return;
            }

            Swal.fire({
                title: 'Generating PDF...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();

                    // Generate URL PDF dengan data yang benar
                    const url = `/unit-pelayanan/gawat-darurat/pelayanan/${kdPasien}/${tglMasuk}/asesmen-keperawatan/${id}/print-pdf`;

                    // Buka PDF di tab baru
                    window.open(url, '_blank');

                    // Tutup loading setelah 2 detik
                    setTimeout(() => {
                        Swal.close();
                    }, 2000);
                }
            });
        }

        // Tambahkan event listener saat modal show untuk update tombol print
        $('#showasesmenKeperawatanModal').on('show.bs.modal', function(e) {
            const button = $(e.relatedTarget);
            const id = button.data('id');
            const kdPasien = button.data('kd-pasien');
            const tglMasuk = button.data('tgl-masuk');

            // Update tombol print di dalam modal
            const printButton = $(this).find('.print-pdf-btn');
            printButton.attr('data-id', id);
            printButton.attr('data-kd-pasien', kdPasien);
            printButton.attr('data-tgl-masuk', tglMasuk);
        });


        function showAsesmenKeperawatan(id, kdPasien, tglMasuk) {
            const url = `/unit-pelayanan/gawat-darurat/pelayanan/${kdPasien}/${tglMasuk}/asesmen-keperawatan/${id}`;

            Swal.fire({
                title: 'Loading...',
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    if (response.status === 'success') {
                        const {
                            asesmen,
                            pasien,
                            pekerjaan,
                            faktorPemberat,
                            faktorPeringan,
                            kualitasNyeri,
                            frekuensiNyeri,
                            jenisNyeri,
                            agama,
                            pendidikan,
                        } = response.data;

                        // Update print button data
                        const printBtn = $('#showasesmenKeperawatanModal .print-pdf-btn');
                        printBtn.attr('data-id', id);
                        printBtn.attr('data-kd-pasien', kdPasien);
                        printBtn.attr('data-tgl-masuk', tglMasuk);

                        // Data pasien
                        $('#patientName').text(pasien.nama || '-');
                        $('#patientGender').text(pasien.jenis_kelamin === '1' ? 'Laki-laki' : 'Perempuan');
                        $('#patientAge').text(
                            `${formatDate(pasien.tgl_lahir)} (${calculateAge(pasien.tgl_lahir)} Tahun)`);
                        $('#assessmentDate').text(pasien.kd_pasien || '-');

                        function calculateAge(dateString) {
                            const dob = new Date(dateString);
                            const today = new Date();
                            let age = today.getFullYear() - dob.getFullYear();
                            const monthDiff = today.getMonth() - dob.getMonth();

                            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                                age--;
                            }
                            return age;
                        }

                        function formatDate(dateString) {
                            const options = {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric'
                            };
                            return new Date(dateString).toLocaleDateString('id-ID', options);
                        }

                        // Pastikan objek asesmen tersedia dengan fallback
                        const asesmenKepUmum = asesmen.asesmen_kep_umum || {};
                        const asesmenBreathing = asesmen.asesmen_kep_umum_breathing || {};
                        const asesmenCirculation = asesmen.asesmen_kep_umum_circulation || {};
                        const asesmenDisability = asesmen.asesmen_kep_umum_disability || {};
                        const asesmenExposure = asesmen.asesmen_kep_umum_exposure || {};
                        const asesmenSkalaNyeri = asesmen.asesmen_kep_umum_skala_nyeri || {};
                        const asesmenRisikoJatuh = asesmen.asesmen_kep_umum_risiko_jatuh || {};
                        const asesmenSosialEkonomi = asesmen.asesmen_kep_umum_sosial_ekonomi || {};
                        const asesmenStatusGizi = asesmen.asesmen_kep_umum_gizi || {};

                        // Data airway
                        $('#showAirwayStatus').text(asesmenKepUmum.airway_status || '-');
                        $('#showAirwaySuaraNafas').text(asesmenKepUmum.airway_suara_nafas || '-');

                        // Pola nafas
                        $('#showBreathingPolaNafas').text(
                            asesmenKepUmum.airway_diagnosis == 1 ? 'Aktual' :
                            asesmenKepUmum.airway_diagnosis == 2 ? 'Risiko' : '-'
                        );

                        // Tanda distress dengan robust parsing
                        let tindakanArray = JSON.parse(asesmenKepUmum.airway_tindakan);
                        let tindakanArrayHtml = '';
                        $.each(tindakanArray, function(i, e) {
                            tindakanArrayHtml += `<li>${e}</li>`;
                        });
                        $('#showBreathingTandaDistress').html(tindakanArrayHtml);

                        // Data Breathing
                        $('#breathingPolaNafas').text(asesmenBreathing.breathing_pola_nafas || '-');
                        $('#breathingBunyiNafas').text(asesmenBreathing.breathing_bunyi_nafas || '-');
                        $('#breathing_irama_nafas').text(
                            asesmenBreathing.breathing_irama_nafas == 0 ? 'tidak teratur' :
                            asesmenBreathing.breathing_irama_nafas == 1 ? 'teratur' : '-'
                        );
                        $('#breathing_tanda_distress').text(asesmenBreathing.breathing_tanda_distress || '-');
                        $('#breathing_jalan_nafas').text(
                            asesmenBreathing.breathing_jalan_nafas == 1 ? 'nafas dada' :
                            asesmenBreathing.breathing_jalan_nafas == 2 ? 'nafas perut' : '-'
                        );
                        $('#breathing_lainnya').text(asesmenBreathing.breathing_lainnya || '-');
                        $('#breathing_diagnosis_nafas').text(
                            asesmenBreathing.breathing_diagnosis_nafas == 1 ? 'Aktual' :
                            asesmenBreathing.breathing_diagnosis_nafas == 2 ? 'Risiko' : '-'
                        );
                        $('#breathing_gangguan').text(
                            asesmenBreathing.breathing_gangguan == 1 ? 'Aktual' :
                            asesmenBreathing.breathing_gangguan == 2 ? 'Risiko' : '-'
                        );
                        let breathingTindakanArray = JSON.parse(asesmenBreathing.breathing_tindakan);
                        let breathingTindakanHtml = '';
                        $.each(breathingTindakanArray, function(i, e) {
                            breathingTindakanHtml += `<li>${e}</li>`;
                        });
                        $('#breathing_tindakan').html(breathingTindakanHtml);

                        // Data Circulation
                        $('#circulation_akral').text(
                            asesmenCirculation.circulation_akral == 1 ? 'Hangat' :
                            asesmenCirculation.circulation_akral == 2 ? 'Dingin' : '-'
                        );
                        $('#circulationPucat').text(
                            asesmenCirculation.circulation_pucat == 0 ? 'Tidak' :
                            asesmenCirculation.circulation_pucat == 1 ? 'Ya' : '-'
                        );
                        $('#circulationCianosis').text(
                            asesmenCirculation.circulation_cianosis == 0 ? 'Tidak' :
                            asesmenCirculation.circulation_cianosis == 1 ? 'Ya' : '-'
                        );
                        $('#circulation_kapiler').text(
                            asesmenCirculation.circulation_kapiler == 1 ? '< 2 detik' :
                            asesmenCirculation.circulation_kapiler == 2 ? '> 2detik' : '-'
                        );
                        $('#circulation_kelembapan_kulit').text(
                            asesmenCirculation.circulation_kelembapan_kulit == 1 ? 'Lembab' :
                            asesmenCirculation.circulation_kelembapan_kulit == 2 ? 'Kering' : '-'
                        );
                        $('#circulation_turgor').text(
                            asesmenCirculation.circulation_turgor == 0 ? 'Kurang' :
                            asesmenCirculation.circulation_turgor == 1 ? 'Normal' : '-'
                        );
                        $('#circulation_transfusi').text(
                            asesmenCirculation.circulation_transfusi == 0 ? 'Tidak' :
                            asesmenCirculation.circulation_transfusi == 1 ? 'Ya' : '-'
                        );
                        $('#circulation_transfusi_jumlah').text(asesmenCirculation
                            .circulation_transfusi_jumlah || '-');
                        $('#circulation_lain').text(asesmenCirculation.circulation_lain || '-');
                        $('#circulation_diagnosis_perfusi').text(
                            asesmenCirculation.circulation_diagnosis_perfusi == 1 ? 'Aktual' :
                            asesmenCirculation.circulation_diagnosis_perfusi == 2 ? 'Resiko' : '-'
                        );
                        $('#circulation_diagnosis_defisit').text(
                            asesmenCirculation.circulation_diagnosis_defisit == 1 ? 'Aktual' :
                            asesmenCirculation.circulation_diagnosis_defisit == 2 ? 'Resiko' : '-'
                        );
                        let circulation_tindakanArray = JSON.parse(asesmenCirculation.circulation_tindakan);
                        let circulation_tindakanHtml = '';
                        $.each(circulation_tindakanArray, function(i, e) {
                            circulation_tindakanHtml += `<li>${e}</li>`;
                        });
                        $('#circulation_tindakan').html(circulation_tindakanHtml);

                        // Data Disability
                        $('#disability_kesadaran').text(asesmenDisability.disability_kesadaran || '-');
                        $('#disability_isokor').text(
                            asesmenDisability.disability_isokor == 1 ? 'isokor' :
                            asesmenDisability.disability_isokor == 2 ? 'anisokor' : '-'
                        );
                        $('#disability_respon_cahaya').text(
                            asesmenDisability.disability_respon_cahaya == 0 ? 'Tidak' :
                            asesmenDisability.disability_respon_cahaya == 1 ? 'Ya' : '-'
                        );
                        $('#disability_diameter_pupil').text(asesmenDisability.disability_diameter_pupil ||
                            '-');
                        $('#disability_motorik').text(
                            asesmenDisability.disability_motorik == 0 ? 'Tidak' :
                            asesmenDisability.disability_motorik == 1 ? 'Ya' : '-'
                        );
                        $('#disability_sensorik').text(
                            asesmenDisability.disability_sensorik == 0 ? 'Tidak' :
                            asesmenDisability.disability_sensorik == 1 ? 'Ya' : '-'
                        );
                        $('#disability_kekuatan_otot').text(asesmenDisability.disability_kekuatan_otot || '-');
                        $('#disability_diagnosis_perfusi').text(
                            asesmenDisability.disability_diagnosis_perfusi == 1 ? 'Aktual' :
                            asesmenDisability.disability_diagnosis_perfusi == 2 ? 'Resiko' : '-'
                        );
                        $('#disability_diagnosis_intoleransi').text(
                            asesmenDisability.disability_diagnosis_intoleransi == 1 ? 'Aktual' :
                            asesmenDisability.disability_diagnosis_intoleransi == 2 ? 'Resiko' : '-'
                        );
                        $('#disability_diagnosis_komunikasi').text(
                            asesmenDisability.disability_diagnosis_komunikasi == 1 ? 'Aktual' :
                            asesmenDisability.disability_diagnosis_komunikasi == 2 ? 'Resiko' : '-'
                        );
                        $('#disability_diagnosis_kejang').text(
                            asesmenDisability.disability_diagnosis_kejang == 1 ? 'Aktual' :
                            asesmenDisability.disability_diagnosis_kejang == 2 ? 'Resiko' : '-'
                        );
                        $('#disability_diagnosis_kesadaran').text(
                            asesmenDisability.disability_diagnosis_kesadaran == 1 ? 'Aktual' :
                            asesmenDisability.disability_diagnosis_kesadaran == 2 ? 'Resiko' : '-'
                        );
                        $('#disability_lainnya').text(asesmenDisability.disability_lainnya || '-');

                        let disability_tindakanArray = JSON.parse(asesmenDisability.disability_tindakan);
                        let disability_tindakanHtml = '';
                        $.each(disability_tindakanArray, function(i, e) {
                            disability_tindakanHtml += `<li>${e}</li>`;
                        });
                        $('#disability_tindakan').html(disability_tindakanHtml);

                        // Data Exposure
                        $('#exposure_deformitas').text(
                            asesmenExposure.exposure_deformitas == 0 ? 'Tidak' :
                            asesmenExposure.exposure_deformitas == 1 ? 'Ya' : '-'
                        );
                        $('#exposure_deformitas_daerah').text(asesmenExposure.exposure_deformitas_daerah ||
                            '-');
                        $('#exposure_kontusion').text(
                            asesmenExposure.exposure_kontusion == 0 ? 'Tidak' :
                            asesmenExposure.exposure_kontusion == 1 ? 'Ya' : '-'
                        );
                        $('#exposure_kontusion_daerah').text(asesmenExposure.exposure_kontusion_daerah || '-');
                        $('#exposure_abrasi').text(
                            asesmenExposure.exposure_abrasi == 0 ? 'Tidak' :
                            asesmenExposure.exposure_abrasi == 1 ? 'Ya' : '-'
                        );
                        $('#exposure_abrasi_daerah').text(asesmenExposure.exposure_abrasi_daerah || '-');
                        $('#exposure_penetrasi').text(
                            asesmenExposure.exposure_penetrasi == 0 ? 'Tidak' :
                            asesmenExposure.exposure_penetrasi == 1 ? 'Ya' : '-'
                        );
                        $('#exposure_penetrasi_daerah').text(asesmenExposure.exposure_penetrasi_daerah || '-');
                        $('#exposure_laserasi').text(
                            asesmenExposure.exposure_laserasi == 0 ? 'Tidak' :
                            asesmenExposure.exposure_laserasi == 1 ? 'Ya' : '-'
                        );
                        $('#exposure_laserasi_daerah').text(asesmenExposure.exposure_laserasi_daerah || '-');
                        $('#exposure_edema').text(
                            asesmenExposure.exposure_edema == 0 ? 'Tidak' :
                            asesmenExposure.exposure_edema == 1 ? 'Ya' : '-'
                        );
                        $('#exposure_edema_daerah').text(asesmenExposure.exposure_edema_daerah || '-');
                        $('#exposure_kedalaman_luka').text(asesmenExposure.exposure_kedalaman_luka || '-');
                        $('#exposure_lainnya').text(asesmenExposure.exposure_lainnya || '-');
                        $('#exposure_diagnosis_mobilitasi').text(
                            asesmenExposure.exposure_diagnosis_mobilitasi == 1 ? 'Aktual' :
                            asesmenExposure.exposure_diagnosis_mobilitasi == 2 ? 'Resiko' : '-'
                        );
                        $('#exposure_diagosis_integritas').text(
                            asesmenExposure.exposure_diagosis_integritas == 1 ? 'Aktual' :
                            asesmenExposure.exposure_diagosis_integritas == 2 ? 'Resiko' : '-'
                        );
                        $('#exposure_diagnosis_lainnya').text(asesmenExposure.exposure_diagnosis_lainnya ||
                            '-');

                        let exposure_tindakanArray = JSON.parse(asesmenExposure.exposure_tindakan);
                        let exposure_tindakanHtml = '';
                        $.each(exposure_tindakanArray, function(i, e) {
                            exposure_tindakanHtml += `<li>${e}</li>`;
                        });
                        $('#exposure_tindakan').html(exposure_tindakanHtml);

                        // Data Skala Nyeri
                        $('#skala_nyeri').text(asesmenSkalaNyeri.skala_nyeri || '-');
                        $('#skala_nyeri_lokasi').text(asesmenSkalaNyeri.skala_nyeri_lokasi || '-');

                        const pemberatMap = (faktorPemberat || []).reduce((map, item) => {
                            map[item.id] = item.name;
                            return map;
                        }, {});
                        // Display pekerjaan
                        $('#skala_nyeri_pemberat_id').text(
                            pemberatMap[asesmenSkalaNyeri.skala_nyeri_pemberat_id] || '-'
                        );

                        const kualitasMap = (kualitasNyeri || []).reduce((map, item) => {
                            map[item.id] = item.name;
                            return map;
                        }, {});
                        // Display pekerjaan
                        $('#skala_nyeri_kualitas_id').text(
                            kualitasMap[asesmenSkalaNyeri.skala_nyeri_kualitas_id] || '-'
                        );

                        $('#skala_nyeri_menjalar_id').text(
                            asesmenSkalaNyeri.skala_nyeri_menjalar_id == 1 ? 'Ya' :
                            asesmenSkalaNyeri.skala_nyeri_menjalar_id == 2 ? 'Tidak' : '-'
                        );
                        $('#skala_nyeri_durasi').text(asesmenSkalaNyeri.skala_nyeri_durasi || '-');

                        const peringanMap = (faktorPeringan || []).reduce((map, item) => {
                            map[item.id] = item.name;
                            return map;
                        }, {});
                        // Display pekerjaan
                        $('#skala_nyeri_peringan_id').text(
                            peringanMap[asesmenSkalaNyeri.skala_nyeri_peringan_id] || '-'
                        );

                        const frekuensiNyeriMap = (frekuensiNyeri || []).reduce((map, item) => {
                            map[item.id] = item.name;
                            return map;
                        }, {});
                        // Display pekerjaan
                        $('#skala_nyeri_frekuensi_id').text(
                            frekuensiNyeriMap[asesmenSkalaNyeri.skala_nyeri_frekuensi_id] || '-'
                        );

                        const jenisNyeriMap = (jenisNyeri || []).reduce((map, item) => {
                            map[item.id] = item.name;
                            return map;
                        }, {});
                        // Display pekerjaan
                        $('#skala_nyeri_jenis_id').text(
                            jenisNyeriMap[asesmenSkalaNyeri.skala_nyeri_jenis_id] || '-'
                        );

                        // Data Risiko Jatuh
                        showRisikoJatuhForm(asesmenRisikoJatuh.resiko_jatuh_jenis, asesmenRisikoJatuh);
                        // Set tindakan

                        let risik_jatuh_tindakanArray = JSON.parse(asesmenRisikoJatuh.risik_jatuh_tindakan);
                        let risik_jatuh_tindakanHtml = '';
                        $.each(risik_jatuh_tindakanArray, function(i, e) {
                            risik_jatuh_tindakanHtml += `<li>${e}</li>`;
                        });
                        $('#risik_jatuh_tindakan').html(risik_jatuh_tindakanHtml);

                        // 8. Status Psikologis
                        $('#psikologis_kondisi').text(asesmenKepUmum.psikologis_kondisi || '-');
                        $('#psikologis_potensi_menyakiti').text(
                            asesmenKepUmum.psikologis_potensi_menyakiti == 1 ? 'Ya' :
                            asesmenKepUmum.psikologis_potensi_menyakiti == 0 ? 'Tidak' : '-'
                        );
                        $('#psikologis_lainnya').text(asesmenKepUmum.psikologis_lainnya || '-');

                        // 9. Status Spiritual
                        const agamaMap = (agama || []).reduce((map, item) => {
                            map[item.kd_agama] = item.agama;
                            return map;
                        }, {});
                        // Display pekerjaan
                        $('#spiritual_agama').text(
                            agamaMap[asesmenKepUmum.spiritual_agama] || '-'
                        );

                        $('#spiritual_nilai').text(asesmenKepUmum.spiritual_nilai || '-');

                        // 10. Status Sosial Ekonomi
                        // pekerjaan mapping
                        const pekerjaanMap = (pekerjaan || []).reduce((map, item) => {
                            map[item.kd_pekerjaan] = item.pekerjaan;
                            return map;
                        }, {});
                        // Display pekerjaan
                        $('#sosial_ekonomi_pekerjaan').text(
                            pekerjaanMap[asesmenSosialEkonomi.sosial_ekonomi_pekerjaan] || '-'
                        );

                        $('#sosial_ekonomi_tingkat_penghasilan').text(asesmenSosialEkonomi
                            .sosial_ekonomi_tingkat_penghasilan || '-');

                        function getstatus_pernikahanText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 0:
                                    return 'Belum Kawin';
                                case 1:
                                    return 'Kawin';
                                case 2:
                                    return 'Janda';
                                case 3:
                                    return 'Duda';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenSosialEkonomi && asesmenSosialEkonomi.sosial_ekonomi_status_pernikahan !==
                            undefined) {
                            $('#sosial_ekonomi_status_pernikahan').text(getstatus_pernikahanText(
                                asesmenSosialEkonomi.sosial_ekonomi_status_pernikahan));
                        } else {
                            $('#sosial_ekonomi_status_pernikahan').text('-');
                        }

                        const pendidikanMap = (pendidikan || []).reduce((map, item) => {
                            map[item.kd_pendidikan] = item.pendidikan;
                            return map;
                        }, {});
                        // Display pekerjaan
                        $('#sosial_ekonomi_status_pendidikan').text(
                            pendidikanMap[asesmenSosialEkonomi.sosial_ekonomi_status_pendidikan] || '-'
                        );

                        $('#sosial_ekonomi_tempat_tinggal').text(asesmenSosialEkonomi
                            .sosial_ekonomi_tempat_tinggal || '-');
                        $('#sosial_ekonomi_tinggal_dengan_keluarga').text(asesmenSosialEkonomi
                            .sosial_ekonomi_tinggal_dengan_keluarga || '-');
                        $('#sosial_ekonomi_curiga_penganiayaan').text(
                            asesmenSosialEkonomi.sosial_ekonomi_curiga_penganiayaan == 1 ? 'Ya' :
                            asesmenSosialEkonomi.sosial_ekonomi_curiga_penganiayaan == 0 ? 'Tidak' : '-'
                        );
                        $('#sosial_ekonomi_keterangan_lain').text(asesmenSosialEkonomi
                            .sosial_ekonomi_keterangan_lain || '-');

                        // 11. Status Gizi
                        showStatusGiziForm(asesmenStatusGizi.gizi_jenis, asesmenStatusGizi);

                        // 12. Status Fungsional
                        $('#status_fungsional').text(asesmenKepUmum.status_fungsional || '-');

                        // 13. Kebutuhan Edukasi
                        function getedukasi_gaya_bicaraText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 0:
                                    return 'Normal';
                                case 1:
                                    return 'Tidak Normal';
                                case 2:
                                    return 'Belum Bisa Bicara';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenKepUmum && asesmenKepUmum.kebutuhan_edukasi_gaya_bicara !== undefined) {
                            $('#kebutuhan_edukasi_gaya_bicara').text(getedukasi_gaya_bicaraText(asesmenKepUmum
                                .kebutuhan_edukasi_gaya_bicara));
                        } else {
                            $('#kebutuhan_edukasi_gaya_bicara').text('-');
                        }
                        $('#kebutuhan_edukasi_bahasa_sehari_hari').text(asesmenKepUmum
                            .kebutuhan_edukasi_bahasa_sehari_hari || '-');
                        $('#kebutuhan_edukasi_perlu_penerjemah').text(
                            asesmenKepUmum.kebutuhan_edukasi_perlu_penerjemah == 1 ? 'Ya' :
                            asesmenKepUmum.kebutuhan_edukasi_perlu_penerjemah == 0 ? 'Tidak' : '-'
                        );
                        $('#kebutuhan_edukasi_hambatan_komunikasi').text(asesmenKepUmum
                            .kebutuhan_edukasi_hambatan_komunikasi || '-');
                        $('#kebutuhan_edukasi_media_belajar').text(asesmenKepUmum
                            .kebutuhan_edukasi_media_belajar || '-');
                        $('#kebutuhan_edukasi_tingkat_pendidikan').text(asesmenKepUmum
                            .kebutuhan_edukasi_tingkat_pendidikan || '-');
                        $('#kebutuhan_edukasi_edukasi_dibutuhkan').text(asesmenKepUmum
                            .kebutuhan_edukasi_edukasi_dibutuhkan || '-');
                        $('#kebutuhan_edukasi_keterangan_lain').text(asesmenKepUmum
                            .kebutuhan_edukasi_keterangan_lain || '-');

                        // 14. Discharge Planning
                        $('#discharge_planning_diagnosis_medis').text(asesmenKepUmum
                            .discharge_planning_diagnosis_medis || '-');
                        $('#discharge_planning_usia_lanjut').text(asesmenKepUmum
                            .discharge_planning_usia_lanjut || '-');
                        $('#discharge_planning_hambatan_mobilisasi').text(asesmenKepUmum
                            .discharge_planning_hambatan_mobilisasi || '-');
                        $('#discharge_planning_pelayanan_medis').text(asesmenKepUmum
                            .discharge_planning_pelayanan_medis || '-');
                        $('#discharge_planning_ketergantungan_aktivitas').text(asesmenKepUmum
                            .discharge_planning_ketergantungan_aktivitas || '-');
                        $('#discharge_planning_kesimpulan').text(asesmenKepUmum.discharge_planning_kesimpulan ||
                            '-');

                        // 15. Evaluasi
                        $('#evaluasi').text(asesmenKepUmum.evaluasi || '-');


                        $('#showasesmenKeperawatanModal').modal('show');
                        Swal.close();
                    } else {
                        Swal.fire('Peringatan', 'Data tidak ditemukan', 'warning');
                    }
                    // log($response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    Swal.fire('Error', `Gagal memuat data: ${error}`, 'error');
                }
            });

            // Data Risiko Jatuh
            // Fungsi untuk mendapatkan nama jenis risiko jatuh
            function getJenisRisikoText(id) {
                switch (parseInt(id)) {
                    case 1:
                        return 'Skala Umum';
                    case 2:
                        return 'Skala Morse';
                    case 3:
                        return 'Skala Pediatrik';
                    case 4:
                        return 'Skala Lansia';
                    case 5:
                        return 'Lainnya';
                    default:
                        return '-';
                }
            }

            // Fungsi untuk mengubah nilai boolean/integer menjadi Ya/Tidak
            function getYesNoText(value) {
                if (value === 1 || value === true) return 'Ya';
                if (value === 0 || value === false) return 'Tidak';
                return '-';
            }

            // Fungsi utama untuk menampilkan form
            function showRisikoJatuhForm(jenisId, asesmenRisikoJatuh) {
                console.log('Received jenisId:', jenisId);
                console.log('Received data:', asesmenRisikoJatuh);

                // Sembunyikan semua form
                $('#form_skala_umum, #form_skala_morse, #form_skala_humpty, #form_skala_ontario, #form_tidak_ada_resiko')
                    .hide();

                // Tampilkan jenis risiko jatuh
                $('#jenis_risiko_jatuh').text(getJenisRisikoText(jenisId));

                if (!asesmenRisikoJatuh) {
                    console.error('asesmenRisikoJatuh is undefined');
                    $('#form_tidak_ada_resiko').show();
                    return;
                }

                const parsedId = parseInt(jenisId);
                console.log('Parsed ID:', parsedId);

                switch (parsedId) {
                    case 1: // Skala Umum
                        $('#form_skala_umum').show();
                        $('#risiko_jatuh_umum_usia').text(
                            asesmenRisikoJatuh.risiko_jatuh_umum_usia == 0 ? 'Tidak' :
                            asesmenRisikoJatuh.risiko_jatuh_umum_usia == 1 ? 'Ya' : '-'
                        );
                        $('#risiko_jatuh_umum_kondisi_khusus').text(
                            asesmenRisikoJatuh.risiko_jatuh_umum_kondisi_khusus == 0 ? 'Tidak' :
                            asesmenRisikoJatuh.risiko_jatuh_umum_kondisi_khusus == 1 ? 'Ya' : '-'
                        );
                        $('#risiko_jatuh_umum_diagnosis_parkinson').text(
                            asesmenRisikoJatuh.risiko_jatuh_umum_diagnosis_parkinson == 0 ? 'Tidak' :
                            asesmenRisikoJatuh.risiko_jatuh_umum_diagnosis_parkinson == 1 ? 'Ya' : '-'
                        );
                        $('#risiko_jatuh_umum_pengobatan_berisiko').text(
                            asesmenRisikoJatuh.risiko_jatuh_umum_pengobatan_berisiko == 0 ? 'Tidak' :
                            asesmenRisikoJatuh.risiko_jatuh_umum_pengobatan_berisiko == 1 ? 'Ya' : '-'
                        );
                        $('#risiko_jatuh_umum_lokasi_berisiko').text(
                            asesmenRisikoJatuh.risiko_jatuh_umum_lokasi_berisiko == 0 ? 'Tidak' :
                            asesmenRisikoJatuh.risiko_jatuh_umum_lokasi_berisiko == 1 ? 'Ya' : '-'
                        );
                        $('#risiko_jatuh_umum_kesimpulan').text(asesmenRisikoJatuh.risiko_jatuh_umum_kesimpulan || '-');
                        break;
                    case 2: // Skala Morse
                        $('#form_skala_morse').show();
                        $('#risiko_jatuh_morse_riwayat_jatuh').text(
                            asesmenRisikoJatuh.risiko_jatuh_morse_riwayat_jatuh == 0 ? 'Tidak' :
                            asesmenRisikoJatuh.risiko_jatuh_morse_riwayat_jatuh == 25 ? 'Ya' : '-'
                        );
                        $('#risiko_jatuh_morse_diagnosis_sekunder').text(
                            asesmenRisikoJatuh.risiko_jatuh_morse_diagnosis_sekunder == 0 ? 'Tidak' :
                            asesmenRisikoJatuh.risiko_jatuh_morse_diagnosis_sekunder == 15 ? 'Ya' : '-'
                        );

                        function getBantuanAmbulasiText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 0:
                                    return 'Tidak ada/ bed rest/ bantuan perawat';
                                case 15:
                                    return 'Kruk/ tongkat/ alat bantu berjalan';
                                case 30:
                                    return 'Meja/ kursi';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenRisikoJatuh && asesmenRisikoJatuh.risiko_jatuh_morse_bantuan_ambulasi !== undefined) {
                            $('#risiko_jatuh_morse_bantuan_ambulasi').text(getBantuanAmbulasiText(asesmenRisikoJatuh
                                .risiko_jatuh_morse_bantuan_ambulasi));
                        } else {
                            $('#risiko_jatuh_morse_bantuan_ambulasi').text('-');
                        }
                        $('#risiko_jatuh_morse_terpasang_infus').text(
                            asesmenRisikoJatuh.risiko_jatuh_morse_terpasang_infus == 0 ? 'Tidak' :
                            asesmenRisikoJatuh.risiko_jatuh_morse_terpasang_infus == 15 ? 'Ya' : '-'
                        );

                        function getCaraBerjalanText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 0:
                                    return 'Normal/ bed rest/ kursi roda';
                                case 20:
                                    return 'Terganggu';
                                case 15:
                                    return 'Lemah';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenRisikoJatuh && asesmenRisikoJatuh.risiko_jatuh_morse_cara_berjalan !== undefined) {
                            $('#risiko_jatuh_morse_cara_berjalan').text(getCaraBerjalanText(asesmenRisikoJatuh
                                .risiko_jatuh_morse_cara_berjalan));
                        } else {
                            $('#risiko_jatuh_morse_cara_berjalan').text('-');
                        }
                        $('#risiko_jatuh_morse_status_mental').text(
                            asesmenRisikoJatuh.risiko_jatuh_morse_status_mental == 0 ?
                            'Beroroentasi pada kemampuannya' :
                            asesmenRisikoJatuh.risiko_jatuh_morse_status_mental == 15 ? 'Lupa akan keterbatasannya' :
                            '-'
                        );
                        $('#risiko_jatuh_morse_kesimpulan').text(asesmenRisikoJatuh.risiko_jatuh_morse_kesimpulan || '-');
                        break;
                    case 3: // Skala Pediatrik
                        $('#form_skala_humpty').show();

                        function getUsiaAnakText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 4:
                                    return 'Dibawah 3 tahun';
                                case 3:
                                    return '3-7 tahun';
                                case 2:
                                    return '7-13 tahun';
                                case 1:
                                    return 'Diatas 13 tahun';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenRisikoJatuh && asesmenRisikoJatuh.risiko_jatuh_pediatrik_usia_anak !== undefined) {
                            $('#risiko_jatuh_pediatrik_usia_anak').text(getUsiaAnakText(asesmenRisikoJatuh
                                .risiko_jatuh_pediatrik_usia_anak));
                        } else {
                            $('#risiko_jatuh_pediatrik_usia_anak').text('-');
                        }
                        $('#risiko_jatuh_pediatrik_jenis_kelamin').text(
                            asesmenRisikoJatuh.risiko_jatuh_pediatrik_jenis_kelamin == 2 ? 'Laki-Laki' :
                            asesmenRisikoJatuh.risiko_jatuh_pediatrik_jenis_kelamin == 1 ? 'Perempuan' : '-'
                        );
                        $('#risiko_jatuh_pediatrik_jenis_kelamin').text(
                            asesmenRisikoJatuh.risiko_jatuh_pediatrik_jenis_kelamin == 2 ? 'Laki-Laki' :
                            asesmenRisikoJatuh.risiko_jatuh_pediatrik_jenis_kelamin == 1 ? 'Perempuan' : '-'
                        );

                        function getPediatrikDiagnosisText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 4:
                                    return 'Diagnosis Neurologis';
                                case 3:
                                    return `Perubahan oksigennasi (diangnosis respiratorik, dehidrasi, anemia, syncope, pusing, dsb)`;
                                case 2:
                                    return 'Gangguan perilaku /psikiatri';
                                case 1:
                                    return 'Diagnosis lainnya';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenRisikoJatuh && asesmenRisikoJatuh.risiko_jatuh_pediatrik_diagnosis !== undefined) {
                            $('#risiko_jatuh_pediatrik_diagnosis').text(getPediatrikDiagnosisText(asesmenRisikoJatuh
                                .risiko_jatuh_pediatrik_diagnosis));
                        } else {
                            $('#risiko_jatuh_pediatrik_diagnosis').text('-');
                        }

                        function getGangguanKognitifText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 3:
                                    return 'Tidak menyadari keterbatasan dirinya';
                                case 2:
                                    return 'Lupa akan adanya keterbatasan';
                                case 1:
                                    return 'Orientasi baik terhadap dari sendiri';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenRisikoJatuh && asesmenRisikoJatuh.risiko_jatuh_pediatrik_gangguan_kognitif !==
                            undefined) {
                            $('#risiko_jatuh_pediatrik_gangguan_kognitif').text(getGangguanKognitifText(asesmenRisikoJatuh
                                .risiko_jatuh_pediatrik_gangguan_kognitif));
                        } else {
                            $('#risiko_jatuh_pediatrik_gangguan_kognitif').text('-');
                        }

                        function getpediatrik_faktor_lingkunganText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 4:
                                    return `Riwayat jatuh /bayi diletakkan di tempat tidur dewasa`;
                                case 3:
                                    return `Pasien menggunakan alat bantu /bayi diletakkan di tempat tidur bayi /perabot rumah`;
                                case 2:
                                    return 'Pasien diletakkan di tempat tidur';
                                case 1:
                                    return 'Area di luar rumah sakit';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenRisikoJatuh && asesmenRisikoJatuh.risiko_jatuh_pediatrik_faktor_lingkungan !==
                            undefined) {
                            $('#risiko_jatuh_pediatrik_faktor_lingkungan').text(getpediatrik_faktor_lingkunganText(
                                asesmenRisikoJatuh.risiko_jatuh_pediatrik_faktor_lingkungan));
                        } else {
                            $('#risiko_jatuh_pediatrik_faktor_lingkungan').text('-');
                        }

                        function getpediatrik_pembedahanText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 3:
                                    return 'Dalam 24 jam';
                                case 2:
                                    return 'Dalam 48 jam';
                                case 1:
                                    return '<48 jam atau tidak menjalani pembedahan/sedasi/anestesi';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenRisikoJatuh && asesmenRisikoJatuh.risiko_jatuh_pediatrik_pembedahan !== undefined) {
                            $('#risiko_jatuh_pediatrik_pembedahan').text(getpediatrik_pembedahanText(asesmenRisikoJatuh
                                .risiko_jatuh_pediatrik_pembedahan));
                        } else {
                            $('#risiko_jatuh_pediatrik_pembedahan').text('-');
                        }

                        function getpediatrik_penggunaan_mentosaText(id) {
                            id = parseInt(id);
                            switch (id) {
                                case 3:
                                    return 'Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi, antidepresan, pencahar, diuretik, narkose';
                                case 2:
                                    return 'Penggunaan salah satu obat diatas';
                                case 1:
                                    return 'Penggunaan medikasi lainnya/tidak ada mediksi';
                                default:
                                    return '-';
                            }
                        }
                        if (asesmenRisikoJatuh && asesmenRisikoJatuh.risiko_jatuh_pediatrik_penggunaan_mentosa !==
                            undefined) {
                            $('#risiko_jatuh_pediatrik_penggunaan_mentosa').text(getpediatrik_penggunaan_mentosaText(
                                asesmenRisikoJatuh.risiko_jatuh_pediatrik_penggunaan_mentosa));
                        } else {
                            $('#risiko_jatuh_pediatrik_penggunaan_mentosa').text('-');
                        }
                        $('#risiko_jatuh_pediatrik_kesimpulan').text(asesmenRisikoJatuh.risiko_jatuh_pediatrik_kesimpulan ||
                            '-');
                        break;
                    case 4: // Skala Lansia
                        $('#form_skala_ontario').show();
                        $('#risiko_jatuh_lansia_jatuh_saat_masuk_rs').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_jatuh_saat_masuk_rs == 6 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_jatuh_saat_masuk_rs == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_riwayat_jatuh_2_bulan').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 6 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_status_bingung').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_status_bingung == 14 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_status_bingung == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_status_disorientasi').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_status_disorientasi == 14 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_status_disorientasi == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_status_agitasi').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_status_agitasi == 14 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_status_agitasi == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_kacamata').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_kacamata == 1 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_kacamata == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_kelainan_penglihatan').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_kelainan_penglihatan == 1 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_kelainan_penglihatan == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_glukoma').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_glukoma == 1 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_glukoma == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_perubahan_berkemih').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_perubahan_berkemih == 2 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_perubahan_berkemih == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_transfer_mandiri').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_transfer_mandiri == 0 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_transfer_mandiri == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_transfer_bantuan_sedikit').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_transfer_bantuan_sedikit == 1 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_transfer_bantuan_sedikit == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_transfer_bantuan_nyata').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_transfer_bantuan_nyata == 2 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_transfer_bantuan_nyata == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_transfer_bantuan_total').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_transfer_bantuan_total == 3 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_transfer_bantuan_total == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_mobilitas_mandiri').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_mobilitas_mandiri == 0 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_mobilitas_mandiri == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_mobilitas_bantuan_1_orang').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_mobilitas_bantuan_1_orang == 1 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_mobilitas_bantuan_1_orang == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_mobilitas_kursi_roda').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_mobilitas_kursi_roda == 2 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_mobilitas_kursi_roda == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_mobilitas_imobilisasi').text(
                            asesmenRisikoJatuh.risiko_jatuh_lansia_mobilitas_imobilisasi == 3 ? 'Ya' :
                            asesmenRisikoJatuh.risiko_jatuh_lansia_mobilitas_imobilisasi == 0 ? 'Tidak' : '-'
                        );
                        $('#risiko_jatuh_lansia_kesimpulan').text(asesmenRisikoJatuh.risiko_jatuh_lansia_kesimpulan || '-');
                        break;
                    case 5: // Lainnya
                        $('#form_tidak_ada_resiko').show();
                        break;
                    default:
                        $('#form_tidak_ada_resiko').show();
                }
            }

            // 11. Status Gizi
            function showStatusGiziForm(jenisId, asesmenStatusGizi) {
                // Hide all forms first
                $('#form_mst, #form_mna, #form_strong-kids, #form_nrs, #form_tidak_ada_satus_gizi').hide();

                // Exit if no data
                if (!asesmenStatusGizi) {
                    $('#form_tidak_ada_satus_gizi').show();
                    return;
                }

                const parsedId = parseInt(jenisId);

                switch (parsedId) {
                    case 1: // MST
                        $('#form_mst').show();
                        displayMSTData(asesmenStatusGizi);
                        break;
                    case 2: // MNA
                        $('#form_mna').show();
                        displayMNAData(asesmenStatusGizi);
                        break;
                    case 3: // Strong Kids
                        $('#form_strong-kids').show();
                        displayStrongKidsData(asesmenStatusGizi);
                        break;
                    case 4: // NRS
                        $('#form_nrs').show();
                        displayNRSData(asesmenStatusGizi);
                        break;
                    default:
                        $('#form_tidak_ada_satus_gizi').show();
                }
            }

            // MST Form Display
            function displayMSTData(data) {
                function getMstPenurunanBBText(id) {
                    switch (parseInt(id)) {
                        case 0:
                            return 'Tidak ada penurunan Berat Badan (BB)';
                        case 2:
                            return 'Tidak yakin/ tidak tahu/ terasa baju lebih longgar';
                        case 3:
                            return 'Ya ada penurunan BB';
                        default:
                            return '-';
                    }
                }

                function getMstJumlahPenurunanBBText(id) {
                    switch (parseInt(id)) {
                        case 1:
                            return '1-5 kg';
                        case 2:
                            return '6-10 kg';
                        case 3:
                            return '11-15 kg';
                        case 4:
                            return '>15 kg';
                        default:
                            return '-';
                    }
                }

                $('#gizi_mst_penurunan_bb').text(getMstPenurunanBBText(data.gizi_mst_penurunan_bb));
                $('#gizi_mst_jumlah_penurunan_bb').text(getMstJumlahPenurunanBBText(data.gizi_mst_jumlah_penurunan_bb));
                $('#gizi_mst_nafsu_makan_berkurang').text(data.gizi_mst_nafsu_makan_berkurang == 1 ? 'Ya' : 'Tidak');
                $('#gizi_mst_diagnosis_khusus').text(data.gizi_mst_diagnosis_khusus == 1 ? 'Ya' : 'Tidak');
                $('#gizi_mst_kesimpulan').text(data.gizi_mst_kesimpulan || '-');
            }

            // MNA Form Display
            function displayMNAData(data) {
                function getmna_penurunan_asupan_3_bulan(id) {
                    switch (parseInt(id)) {
                        case 0:
                            return 'Mengalami penurunan asupan makanan yang parah';
                        case 1:
                            return 'Mengalami penurunan asupan makanan sedang';
                        case 2:
                            return 'Tidak mengalami penurunan asupan makanan';
                        default:
                            return '-';
                    }
                }

                function getmna_kehilangan_bb_3_bulan(id) {
                    switch (parseInt(id)) {
                        case 0:
                            return 'Kehilangan BB lebih dari 3 Kg';
                        case 1:
                            return 'Tidak tahu';
                        case 2:
                            return 'Kehilangan BB antara 1 s.d 3 Kg';
                        case 3:
                            return 'Tidak ada kehilangan BB';
                        default:
                            return '-';
                    }
                }

                function getmna_mobilisasi(id) {
                    switch (parseInt(id)) {
                        case 0:
                            return 'Hanya di tempat tidur atau kursi roda';
                        case 1:
                            return 'Dapat turun dari tempat tidur tapi tidak dapat jalan-jalan';
                        case 2:
                            return 'Dapat jalan-jalan';
                        default:
                            return '-';
                    }
                }

                function getgizi_mna_status_neuropsikologi(id) {
                    switch (parseInt(id)) {
                        case 0:
                            return 'Demensia atau depresi berat';
                        case 1:
                            return 'Demensia ringan';
                        case 2:
                            return 'Tidak mengalami masalah neuropsikologi';
                        default:
                            return '-';
                    }
                }
                $('#gizi_mna_penurunan_asupan_3_bulan').text(getmna_penurunan_asupan_3_bulan(data
                    .gizi_mna_penurunan_asupan_3_bulan));
                $('#gizi_mna_kehilangan_bb_3_bulan').text(getmna_kehilangan_bb_3_bulan(data
                .gizi_mna_kehilangan_bb_3_bulan));
                $('#gizi_mna_mobilisasi').text(getmna_mobilisasi(data.gizi_mna_mobilisasi));
                $('#gizi_mna_stress_penyakit_akut').text(data.gizi_mna_stress_penyakit_akut == 1 ? 'Ya' : 'Tidak');
                $('#gizi_mna_status_neuropsikologi').text(getgizi_mna_status_neuropsikologi(data
                    .gizi_mna_status_neuropsikologi));
                $('#gizi_mna_berat_badan').text(data.gizi_mna_berat_badan || '-');
                $('#gizi_mna_tinggi_badan').text(data.gizi_mna_tinggi_badan || '-');
                $('#gizi_mna_imt').text(data.gizi_mna_imt || '-');
                $('#gizi_mna_kesimpulan').text(data.gizi_mna_kesimpulan || '-');
            }

            // Strong Kids Form Display
            function displayStrongKidsData(data) {
                $('#gizi_strong_status_kurus').text(data.gizi_strong_status_kurus == 1 ? 'Ya' : 'Tidak');
                $('#gizi_strong_penurunan_bb').text(data.gizi_strong_penurunan_bb == 1 ? 'Ya' : 'Tidak');
                $('#gizi_strong_gangguan_pencernaan').text(data.gizi_strong_gangguan_pencernaan == 1 ? 'Ya' : 'Tidak');
                $('#gizi_strong_penyakit_berisiko').text(data.gizi_strong_penyakit_berisiko == 2 ? 'Ya' : 'Tidak');
                $('#gizi_strong_kesimpulan').text(data.gizi_strong_kesimpulan || '-');
            }

            // NRS Form Display
            function displayNRSData(data) {

                // Add other NRS fields
            }
        }
    </script>
@endpush
