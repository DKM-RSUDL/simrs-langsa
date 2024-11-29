<!-- Modal Tindakan Keperawatan 1. Air Way -->
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

<!-- Modal Tindakan Keperawatan 2. Status Breathing -->
<div class="modal fade" id="tindakanBreathingModal" tabindex="-1"
    aria-labelledby="tindakanBreathingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tindakanBreathingModalLabel">Tindakan
                    keperawatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tindakan-breathing-options">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanBreathing1"
                            value="Observasi frekuensi, irama, kedalaman pernafasan jalan nafas">
                        <label class="form-check-label"
                            for="tindakanBreathing1">Observasi frekuensi, irama,
                            kedalaman pernafasan jalan nafas</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanBreathing2"
                            value="Observasi tanda-tanda distress pernafasan; penggunaan otot bantu; retraksi intercostae; nafas cuping hidung">
                        <label class="form-check-label"
                            for="tindakanBreathing2">Observasi tanda-tanda distress
                            pernafasan; penggunaan otot bantu; retraksi intercostae;
                            nafas cuping hidung</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanBreathing3"
                            value="Memberikan posisi semi fowler jika tidak ada kontra indikasi">
                        <label class="form-check-label"
                            for="tindakanBreathing3">Memberikan posisi semi fowler jika
                            tidak ada kontra indikasi</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanBreathing4"
                            value="Melakukan fisioterapi dada jika tidak ada kontra indikasi">
                        <label class="form-check-label"
                            for="tindakanBreathing4">Melakukan fisioterapi dada jika
                            tidak ada kontra indikasi</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanBreathing5" value="Berikan oksigen O2">
                        <label class="form-check-label"
                            for="tindakanBreathing5">Berikan oksigen O2</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanBreathing6" value="Pemeriksaan AGD">
                        <label class="form-check-label"
                            for="tindakanBreathing6">Pemeriksaan AGD</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanBreathing7" value="Lainnya">
                        <label class="form-check-label"
                            for="tindakanBreathing7">Lainnya</label>
                    </div>
                    <div class="mt-3 lainnya-breathing-input" style="display: none;">
                        <input type="text" class="form-control"
                            id="tindakanBreathingLainnya"
                            placeholder="Sebutkan tindakan lainnya">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary"
                    id="btnSimpanTindakanBreathing">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tindakan Keperawatan 3. Status Circulation -->
<div class="modal fade" id="tindakanCirculationModal" tabindex="-1"
    aria-labelledby="tindakanCirculationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tindakanCirculationModalLabel">Tindakan
                    keperawatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tindakan-circulation-options">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation1"
                            value="Mengkaji nadi : frekuensi, irama dan kekuatan">
                        <label class="form-check-label"
                            for="tindakanCirculation1">Mengkaji nadi : frekuensi, irama
                            dan kekuatan</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation2" value="Menilai akral">
                        <label class="form-check-label"
                            for="tindakanCirculation2">Menilai akral</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation3" value="Mengukur tekanan darah">
                        <label class="form-check-label"
                            for="tindakanCirculation3">Mengukur tekanan darah</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation4"
                            value="Memberikan cairan per oral">
                        <label class="form-check-label"
                            for="tindakanCirculation4">Memberikan cairan per
                            oral</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation5"
                            value="Memonitor perubahan turgor, membran mucosa, dan capillary refill time">
                        <label class="form-check-label"
                            for="tindakanCirculation5">Memonitor perubahan turgor,
                            membran mucosa, dan capillary refill time</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation6"
                            value="Mengidentifikasi sumber perdarahan">
                        <label class="form-check-label"
                            for="tindakanCirculation6">Mengidentifikasi sumber
                            perdarahan</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation7"
                            value="Memberikan penekanan langsung ke sumber perdarahan">
                        <label class="form-check-label"
                            for="tindakanCirculation7">Memberikan penekanan langsung ke
                            sumber perdarahan</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation8"
                            value="Memberi posisi shock (tungkai lebih tinggi dari jantung)">
                        <label class="form-check-label"
                            for="tindakanCirculation8">Memberi posisi shock (tungkai
                            lebih tinggi dari jantung)</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation9" value="Memasang kateter">
                        <label class="form-check-label"
                            for="tindakanCirculation9">Memasang kateter</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation10"
                            value="Memonitor intake-output cairan">
                        <label class="form-check-label"
                            for="tindakanCirculation10">Memonitor intake-output
                            cairan</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation11" value="Memasang infus IV">
                        <label class="form-check-label"
                            for="tindakanCirculation11">Memasang infus IV</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation12" value="Transfusi darah">
                        <label class="form-check-label"
                            for="tindakanCirculation12">Transfusi darah</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input"
                            id="tindakanCirculation13" value="Lainnya">
                        <label class="form-check-label"
                            for="tindakanCirculation13">Lainnya</label>
                    </div>
                    <div class="mt-3 lainnya-circulation-input"
                        style="display: none;">
                        <input type="text" class="form-control"
                            id="tindakanCirculationLainnya"
                            placeholder="Sebutkan tindakan lainnya">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary"
                    id="btnSimpanTindakanCirculation">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tindakan Keperawatan 4. Status Disability -->
<div class="modal fade" id="tindakanDisabilityModal" tabindex="-1" aria-labelledby="tindakanDisabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tindakanDisabilityModalLabel">Tindakan keperawatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tindakan-disability-options">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanDisability1" value="Observasi tingkat kesadaran">
                        <label class="form-check-label" for="tindakanDisability1">Observasi tingkat kesadaran</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanDisability2" value="Mengkaji pupil (isokor, diameter dan respon cahaya)">
                        <label class="form-check-label" for="tindakanDisability2">Mengkaji pupil (isokor, diameter dan respon cahaya)</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanDisability3" value="Mengukur kekuatan otot">
                        <label class="form-check-label" for="tindakanDisability3">Mengukur kekuatan otot</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanDisability4" value="Mengkaji karakteristik nyeri">
                        <label class="form-check-label" for="tindakanDisability4">Mengkaji karakteristik nyeri</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanDisability5" value="Meninggikan kepala 15-30 derajat jika tidak ada kontra indikasi">
                        <label class="form-check-label" for="tindakanDisability5">Meninggikan kepala 15-30 derajat jika tidak ada kontra indikasi</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanDisability6" value="Kolaborasi">
                        <label class="form-check-label" for="tindakanDisability6">Kolaborasi</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanDisability7" value="Memberikan terapi sesuai indikasi">
                        <label class="form-check-label" for="tindakanDisability7">Memberikan terapi sesuai indikasi</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanDisability8" value="Lainnya">
                        <label class="form-check-label" for="tindakanDisability8">Lainnya</label>
                    </div>
                    <div class="mt-3 lainnya-disability-input" style="display: none;">
                        <input type="text" class="form-control" id="tindakanDisabilityLainnya" placeholder="Sebutkan tindakan lainnya">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanTindakanDisability">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tindakan Keperawatan 5. Status eXposure -->
<div class="modal fade" id="tindakanExposureModal" tabindex="-1" aria-labelledby="tindakanExposureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tindakanExposureModalLabel">Tindakan keperawatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tindakan-exposure-options">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure1" value="Mengkaji karakteristik nyeri">
                        <label class="form-check-label" for="tindakanExposure1">Mengkaji karakteristik nyeri</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure2" value="Perawatan luka">
                        <label class="form-check-label" for="tindakanExposure2">Perawatan luka</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure3" value="Hecting">
                        <label class="form-check-label" for="tindakanExposure3">Hecting</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure4" value="Mengajarkan teknik relaksasi">
                        <label class="form-check-label" for="tindakanExposure4">Mengajarkan teknik relaksasi</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure5" value="Membatasi aktivitas yang meningkatkan nyeri">
                        <label class="form-check-label" for="tindakanExposure5">Membatasi aktivitas yang meningkatkan nyeri</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure6" value="Mengidentifikasi sumber perdarahan">
                        <label class="form-check-label" for="tindakanExposure6">Mengidentifikasi sumber perdarahan</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure7" value="Mengobservasi tanda-tanda adanya sindrome kompartmen (nyeri lokal daerah cidera, pucat, penurunan mobilitas, penurunan tekanan nadi, nyeri saat bergerak, perubahan sensori/ baal dan kesemutan)">
                        <label class="form-check-label" for="tindakanExposure7">Mengobservasi tanda-tanda adanya sindrome kompartmen (nyeri lokal daerah cidera, pucat, penurunan mobilitas, penurunan tekanan nadi, nyeri saat bergerak, perubahan sensori/ baal dan kesemutan)</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure8" value="Melakukan pembalutan">
                        <label class="form-check-label" for="tindakanExposure8">Melakukan pembalutan</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure9" value="Melakukan pembidaian">
                        <label class="form-check-label" for="tindakanExposure9">Melakukan pembidaian</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure10" value="Kolaborasi analgetik">
                        <label class="form-check-label" for="tindakanExposure10">Kolaborasi analgetik</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="tindakanExposure11" value="Lainnya">
                        <label class="form-check-label" for="tindakanExposure11">Lainnya</label>
                    </div>
                    <div class="mt-3 lainnya-exposure-input" style="display: none;">
                        <input type="text" class="form-control" id="tindakanExposureLainnya" placeholder="Sebutkan tindakan lainnya">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanTindakanExposure">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for risiko jatuh interventions -->
<div class="modal fade" id="intervensiRisikoJatuhModal" tabindex="-1" aria-labelledby="intervensiRisikoJatuhModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="intervensiRisikoJatuhModalLabel">Intervensi Risiko Jatuh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="intervensi-risiko-jatuh-options">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="intervensiRisikoJatuh1" value="Edukasi pasien dan keluarga">
                        <label class="form-check-label" for="intervensiRisikoJatuh1">Edukasi pasien dan keluarga</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="intervensiRisikoJatuh2" value="Pasang pita kuning">
                        <label class="form-check-label" for="intervensiRisikoJatuh2">Pasang pita kuning</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="intervensiRisikoJatuh3" value="Beri bantuan berjalan">
                        <label class="form-check-label" for="intervensiRisikoJatuh3">Beri bantuan berjalan</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="intervensiRisikoJatuh4" value="Tidak ada intervensi">
                        <label class="form-check-label" for="intervensiRisikoJatuh4">Tidak ada intervensi</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnSimpanIntervensiRisikoJatuh">Simpan</button>
            </div>
        </div>
    </div>
</div>