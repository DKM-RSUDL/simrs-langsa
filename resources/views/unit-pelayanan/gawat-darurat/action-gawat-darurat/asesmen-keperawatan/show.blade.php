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
                                        <p id="showBreathingTandaDistress" class="form-control-plaintext border-bottom">
                                        </p>
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
                                        <p id="breathing_tindakan" class="form-control-plaintext border-bottom">
                                        </p>
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
                                        <p id="circulation_pucat" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Cianoisis :</label>
                                        <p id="circulation_cianosis" class="form-control-plaintext border-bottom">
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
                                        <p id="circulation_tindakan" class="form-control-plaintext border-bottom">
                                        </p>
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
                                            <span id="disability_diagnosis_perfusi"></span></p>
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
                                        <p id="disability_tindakan" class="form-control-plaintext border-bottom">
                                        </p>
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
                                        <p id="exposure_tindakan" class="form-control-plaintext border-bottom">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skala Nyeri -->
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
                                        <p id="skala_nyeri_peringan_id" class="form-control-plaintext  border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Frekuensi :</label>
                                        <p id="skala_nyeri_frekuensi_id" class="form-control-plaintext  border-bottom"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Jenis :</label>
                                        <p id="skala_nyeri_jenis_id" class="form-control-plaintext  border-bottom"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Risiko Jatuh -->
                <div class="tab-pane fade show mt-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>7. Risiko Jatuh</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Skala Nyeri :</label>
                                        <p id="" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Skala Nyeri :</label>
                                        <p id="" class="form-control-plaintext border-bottom"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
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
                            pasien
                        } = response.data;

                        // Data pasien
                        $('#patientName').text(pasien.nama || '-');
                        $('#patientGender').text(pasien.jenis_kelamin === '1' ? 'Laki-laki' : 'Perempuan');
                        $('#patientAge').text(`${pasien.umur || '-'} Tahun`);
                        $('#assessmentDate').text(asesmen.waktu_asesmen ? new Date(asesmen.waktu_asesmen)
                            .toLocaleString() : '-');

                        // Pastikan objek asesmen tersedia dengan fallback
                        const asesmenKepUmum = asesmen.asesmen_kep_umum || {};
                        const asesmenBreathing = asesmen.asesmen_kep_umum_breathing || {};
                        const asesmenCirculation = asesmen.asesmen_kep_umum_circulation || {};
                        const asesmenDisability = asesmen.asesmen_kep_umum_disability || {};
                        const asesmenExposure = asesmen.asesmen_kep_umum_exposure || {};
                        const asesmenSkalaNyeri = asesmen.asesmen_kep_umum_skala_nyeri || {};
                        const asesmenRisikoJatuh = asesmen.asesmen_kep_umum_risiko_jatuh || {};

                        // Data airway
                        $('#showAirwayStatus').text(asesmenKepUmum.airway_status || '-');
                        $('#showAirwaySuaraNafas').text(asesmenKepUmum.airway_suara_nafas || '-');

                        // Pola nafas
                        $('#showBreathingPolaNafas').text(
                            asesmenKepUmum.airway_diagnosis == 1 ? 'Aktual' :
                            asesmenKepUmum.airway_diagnosis == 2 ? 'Risiko' : '-'
                        );

                        // Tanda distress dengan robust parsing
                        $('#showBreathingTandaDistress').text(
                            asesmenKepUmum.airway_tindakan ?
                            (() => {
                                try {
                                    const tindakanArray = typeof asesmenKepUmum.airway_tindakan ===
                                        'string' ?
                                        JSON.parse(asesmenKepUmum.airway_tindakan) :
                                        asesmenKepUmum.airway_tindakan;
                                    return Array.isArray(tindakanArray) ? tindakanArray.join(', ') :
                                        '-';
                                } catch (error) {
                                    console.error('Parsing error:', error);
                                    return asesmenKepUmum.airway_tindakan || '-';
                                }
                            })() :
                            '-'
                        );

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
                        $('#breathing_tindakan').text(
                            asesmenBreathing.breathing_tindakan ?
                            (() => {
                                try {
                                    const tindakanArray = typeof asesmenBreathing.breathing_tindakan ===
                                        'string' ?
                                        JSON.parse(asesmenBreathing.breathing_tindakan) :
                                        asesmenBreathing.breathing_tindakan;
                                    return Array.isArray(tindakanArray) ? tindakanArray.join(', ') :
                                        '-';
                                } catch (error) {
                                    console.error('Parsing error:', error);
                                    return asesmenBreathing.breathing_tindakan || '-';
                                }
                            })() :
                            '-'
                        );

                        // Data Circulation
                        $('#circulation_akral').text(
                            asesmenCirculation.circulation_akral == 1 ? 'Hangat' :
                            asesmenCirculation.circulation_akral == 2 ? 'Dingin' : '-'
                        );
                        $('#circulation_pucat').text(
                            asesmenCirculation.circulation_pucat == 0 ? 'Tidak' :
                            asesmenCirculation.circulation_pucat == 1 ? 'Ya' : '-'
                        );
                        $('#circulation_cianosis').text(
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
                        $('#circulation_tindakan').text(
                            asesmenCirculation.circulation_tindakan ?
                            (() => {
                                try {
                                    const tindakanArray = typeof asesmenCirculation
                                        .circulation_tindakan ===
                                        'string' ?
                                        JSON.parse(asesmenCirculation.circulation_tindakan) :
                                        asesmenCirculation.circulation_tindakan;
                                    return Array.isArray(tindakanArray) ? tindakanArray.join(', ') :
                                        '-';
                                } catch (error) {
                                    console.error('Parsing error:', error);
                                    return asesmenCirculation.circulation_tindakan || '-';
                                }
                            })() :
                            '-'
                        );

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
                        $('#disability_tindakan').text(
                            asesmenDisability.disability_tindakan ?
                            (() => {
                                try {
                                    const tindakanArray = typeof asesmenDisability
                                        .disability_tindakan ===
                                        'string' ?
                                        JSON.parse(asesmenDisability.disability_tindakan) :
                                        asesmenDisability.disability_tindakan;
                                    return Array.isArray(tindakanArray) ? tindakanArray.join(', ') :
                                        '-';
                                } catch (error) {
                                    console.error('Parsing error:', error);
                                    return asesmenDisability.disability_tindakan || '-';
                                }
                            })() :
                            '-'
                        );

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
                        $('#exposure_tindakan').text(
                            asesmenExposure.exposure_tindakan ?
                            (() => {
                                try {
                                    const tindakanArray = typeof asesmenExposure
                                        .exposure_tindakan ===
                                        'string' ?
                                        JSON.parse(asesmenExposure.exposure_tindakan) :
                                        asesmenExposure.exposure_tindakan;
                                    return Array.isArray(tindakanArray) ? tindakanArray.join(', ') :
                                        '-';
                                } catch (error) {
                                    console.error('Parsing error:', error);
                                    return asesmenExposure.exposure_tindakan || '-';
                                }
                            })() :
                            '-'
                        );

                        // Data Skala Nyeri
                        $('#skala_nyeri').text(asesmenSkalaNyeri.skala_nyeri || '-');
                        $('#skala_nyeri_lokasi').text(asesmenSkalaNyeri.skala_nyeri_lokasi || '-');
                        function getPemberatText(id) {
                            id = parseInt(id);
                            switch(id) {
                                case 1: return 'Cahaya';
                                case 2: return 'Gelap';
                                case 3: return 'Berbaring';
                                case 4: return 'Gerakan';
                                case 5: return 'Lainnya';
                                default: return '-';
                            }
                        }
                        if (asesmenSkalaNyeri && asesmenSkalaNyeri.skala_nyeri_pemberat_id !== undefined) {
                            $('#skala_nyeri_pemberat_id').text(getPemberatText(asesmenSkalaNyeri.skala_nyeri_pemberat_id));
                        } else {
                            $('#skala_nyeri_pemberat_id').text('-');
                        }
                        function getKualitasText(id) {
                            id = parseInt(id);
                            switch(id) {
                                case 1: return 'Nyeri Tumpul';
                                case 2: return 'Nyeri Tajam';
                                case 3: return 'Panas/Terbakar';
                                default: return '-';
                            }
                        }
                        if (asesmenSkalaNyeri && asesmenSkalaNyeri.skala_nyeri_pemberat_id !== undefined) {
                            $('#skala_nyeri_kualitas_id').text(getKualitasText(asesmenSkalaNyeri.skala_nyeri_kualitas_id));
                        } else {
                            $('#skala_nyeri_kualitas_id').text('-');
                        }
                        $('#skala_nyeri_menjalar_id').text(
                            asesmenSkalaNyeri.skala_nyeri_menjalar_id == 1 ? 'Ya' :
                            asesmenSkalaNyeri.skala_nyeri_menjalar_id == 2 ? 'Tidak' : '-'
                        );
                        $('#skala_nyeri_durasi').text(asesmenSkalaNyeri.skala_nyeri_durasi || '-');
                        function getPeringanText(id) {
                            id = parseInt(id);
                            switch(id) {
                                case 1: return 'Cahaya';
                                case 2: return 'Gelap';
                                case 3: return 'Berbaring';
                                case 4: return 'Gerakan';
                                case 5: return 'Lainnya';
                                default: return '-';
                            }
                        }
                        if (asesmenSkalaNyeri && asesmenSkalaNyeri.skala_nyeri_peringan_id !== undefined) {
                            $('#skala_nyeri_peringan_id').text(getPeringanText(asesmenSkalaNyeri.skala_nyeri_peringan_id));
                        } else {
                            $('#skala_nyeri_peringan_id').text('-');
                        }
                        function getFrekuensiText(id) {
                            id = parseInt(id);
                            switch(id) {
                                case 1: return 'Jarang';
                                case 2: return 'Hilang Timbul';
                                case 3: return 'Panas/Terbakar';
                                default: return '-';
                            }
                        }
                        if (asesmenSkalaNyeri && asesmenSkalaNyeri.skala_nyeri_frekuensi_id !== undefined) {
                            $('#skala_nyeri_frekuensi_id').text(getFrekuensiText(asesmenSkalaNyeri.skala_nyeri_frekuensi_id));
                        } else {
                            $('#skala_nyeri_frekuensi_id').text('-');
                        }
                        function getJenisText(id) {
                            id = parseInt(id);
                            switch(id) {
                                case 1: return 'Nyeri Akut';
                                case 2: return 'Kronik';
                                default: return '-';
                            }
                        }
                        if (asesmenSkalaNyeri && asesmenSkalaNyeri.skala_nyeri_jenis_id !== undefined) {
                            $('#skala_nyeri_jenis_id').text(getJenisText(asesmenSkalaNyeri.skala_nyeri_jenis_id));
                        } else {
                            $('#skala_nyeri_jenis_id').text('-');
                        }


                        $('#showasesmenKeperawatanModal').modal('show');
                        Swal.close();
                    } else {
                        Swal.fire('Peringatan', 'Data tidak ditemukan', 'warning');
                    }

                    // Data Skala Nyeri
                    // $resikoJatuh
                    // $('#skala_nyeri').text(asesmenRisikoJatuh.skala_nyeri || '-');

                    // log($response);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    Swal.fire('Error', `Gagal memuat data: ${error}`, 'error');
                }
            });
        }
    </script>
@endpush
