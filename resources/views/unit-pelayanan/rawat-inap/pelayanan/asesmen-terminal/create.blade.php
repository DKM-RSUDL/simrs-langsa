@extends('layouts.administrator.master')

@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-terminal.include')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}"
                class="btn btn-outline-info">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center mt-2">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">
                                        <i class="fas fa-clipboard-list me-2"></i>
                                        Asesmen Awal dan Ulang Pasien Terminal dan Keluarganya
                                    </h4>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Isikan Asesmen Keperawatan dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('rawat-inap.asesmen.keperawatan.terminal.index', [
        'kd_unit' => $kd_unit,
        'kd_pasien' => $kd_pasien,
        'tgl_masuk' => $tgl_masuk,
        'urut_masuk' => $urut_masuk,
    ]) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="px-3">
                                <!-- Data Masuk -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        Data Masuk
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label required-field">Tanggal Masuk</label>
                                            <input type="date" class="form-control" name="tanggal" id="tanggal_masuk"
                                                value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required-field">Jam Masuk</label>
                                            <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                value="{{ date('H:i') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 1 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">1</span>
                                        Gejala seperti mau muntah dan kesulitan bernafas
                                    </h5>

                                    <div class="subsection-title">1.1. Kegawatan pernafasan:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="dyspnoe" id="dyspnoe" value="1">
                                                    <label for="dyspnoe">Dyspnoe</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="nafas_tak_teratur" id="nafas_tak_teratur"
                                                        value="1">
                                                    <label for="nafas_tak_teratur">Nafas Tak teratur</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="ada_sekret" id="ada_sekret" value="1">
                                                    <label for="ada_sekret">Ada sekret</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="nafas_cepat_dangkal"
                                                        id="nafas_cepat_dangkal" value="1">
                                                    <label for="nafas_cepat_dangkal">Nafas cepat dan dangkal</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="nafas_melalui_mulut"
                                                        id="nafas_melalui_mulut" value="1">
                                                    <label for="nafas_melalui_mulut">Nafas melalui mulut</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="spo2_normal" id="spo2_normal" value="1">
                                                    <label for="spo2_normal">SpO₂ < normal</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="nafas_lambat" id="nafas_lambat" value="1">
                                                    <label for="nafas_lambat">Nafas lambat</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="mukosa_oral_kering" id="mukosa_oral_kering"
                                                        value="1">
                                                    <label for="mukosa_oral_kering">Mukosa oral kering</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="tak" id="tak" value="1">
                                                    <label for="tak">T.A.K</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title">1.2. Kegawatan Tinus otot:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="mual" id="mual" value="1">
                                                    <label for="mual">Mual</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="sulit_menelan" id="sulit_menelan"
                                                        value="1">
                                                    <label for="sulit_menelan">Sulit menelan</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="inkontinensia_alvi" id="inkontinensia_alvi"
                                                        value="1">
                                                    <label for="inkontinensia_alvi">Inkontinensia alvi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="penurunan_pergerakan"
                                                        id="penurunan_pergerakan" value="1">
                                                    <label for="penurunan_pergerakan">Penurunan Pergerakan tubuh</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="distensi_abdomen" id="distensi_abdomen"
                                                        value="1">
                                                    <label for="distensi_abdomen">Distensi Abdomen</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="tak2" id="tak2" value="1">
                                                    <label for="tak2">T.A.K</label>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="sulit_berbicara" id="sulit_berbicara"
                                                        value="1">
                                                    <label for="sulit_berbicara">Sulit Berbicara</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="inkontinensia_urine"
                                                        id="inkontinensia_urine" value="1">
                                                    <label for="inkontinensia_urine">Inkontinensia Urine</label>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div class="subsection-title">1.3. Nyeri:</div>
                                    <div class="radio-group">
                                        <div class="radio-item">
                                            <input type="radio" name="nyeri" id="nyeri_tidak" value="0">
                                            <label for="nyeri_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item">
                                            <input type="radio" name="nyeri" id="nyeri_ya" value="1">
                                            <label for="nyeri_ya">Ya</label>
                                        </div>
                                    </div>
                                    <div class="text-input-group" id="nyeri_keterangan" style="display: none;">
                                        <label class="form-label">Keterangan:</label>
                                        <textarea class="form-control" name="nyeri_keterangan" rows="2"
                                            placeholder="Jelaskan lokasi, intensitas, dan karakteristik nyeri..."></textarea>
                                    </div>

                                    <div class="subsection-title mt-4">1.4. Perlambatan Sirkulasi:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="bercerak_sianosis" id="bercerak_sianosis"
                                                        value="1">
                                                    <label for="bercerak_sianosis">Bercak dan sianosis pada ekstremitas</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="gelisah" id="gelisah" value="1">
                                                    <label for="gelisah">Gelisah</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="lemas" id="lemas" value="1">
                                                    <label for="lemas">Lemas</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="kulit_dingin" id="kulit_dingin" value="1">
                                                    <label for="kulit_dingin">Kulit dingin dan berkeringat</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="tekanan_darah" id="tekanan_darah"
                                                        value="1">
                                                    <label for="tekanan_darah">Tekanan Darah menurun Nadi lambat dan lemah</label>
                                                </div>
                                                {{-- <div class="text-input-group">
                                                    <label class="form-label">Nadi lambat dan lemah:</label>
                                                    <input type="text" class="form-control" name="nadi_lambat"
                                                        placeholder="Masukkan nilai...">
                                                </div> --}}
                                                {{-- <div class="checkbox-item">
                                                    <input type="checkbox" name="tak3" id="tak3" value="1">
                                                    <label for="tak3">T.A.K</label>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">2</span>
                                        Faktor-faktor yang meningkatkan dan membangkitkan gejala fisik
                                    </h5>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="melakukan_aktivitas"
                                                        id="melakukan_aktivitas" value="1">
                                                    <label for="melakukan_aktivitas">Melakukan aktivitas fisik</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="pindah_posisi" id="pindah_posisi"
                                                        value="1">
                                                    <label for="pindah_posisi">Pindah posisi</label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="text-input-group">
                                            <label class="form-label">Lainnya:</label>
                                            <textarea class="form-control" name="faktor_lainnya" rows="2"
                                                placeholder="Sebutkan faktor lainnya..."></textarea>
                                        </div> --}}
                                    </div>
                                </div>

                                <!-- Section 3 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">3</span>
                                        Manajemen gejala saat ini dan respon pasien
                                    </h5>

                                    <div class="subsection-title">Masalah keperawatan:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="masalah_mual" id="masalah_mual" value="1">
                                                    <label for="masalah_mual">Mual</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="masalah_perubahan_persepsi"
                                                        id="masalah_perubahan_persepsi" value="1">
                                                    <label for="masalah_perubahan_persepsi">Perubahan persepsi
                                                        sensori</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="masalah_pola_nafas" id="masalah_pola_nafas"
                                                        value="1">
                                                    <label for="masalah_pola_nafas">Pola Nafas tidak efektif</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="masalah_konstipasi" id="masalah_konstipasi"
                                                        value="1">
                                                    <label for="masalah_konstipasi">Konstipasi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="masalah_bersihan_jalan_nafas"
                                                        id="masalah_bersihan_jalan_nafas" value="1">
                                                    <label for="masalah_bersihan_jalan_nafas">Bersihan jalan nafas tidak
                                                        efektif</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="masalah_defisit_perawatan"
                                                        id="masalah_defisit_perawatan" value="1">
                                                    <label for="masalah_defisit_perawatan">Defisit perawatan diri</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="masalah_nyeri_akut" id="masalah_nyeri_akut"
                                                        value="1">
                                                    <label for="masalah_nyeri_akut">Nyeri akut</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="masalah_nyeri_kronis"
                                                        id="masalah_nyeri_kronis" value="1">
                                                    <label for="masalah_nyeri_kronis">Nyeri Kronis</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Text area untuk masalah lainnya -->
                                    {{-- <div class="text-input-group mt-3">
                                        <label class="form-label">Masalah keperawatan lainnya:</label>
                                        <textarea class="form-control" name="masalah_keperawatan_lainnya" rows="3"
                                            placeholder="Sebutkan masalah keperawatan lainnya yang ditemukan..."></textarea>
                                    </div> --}}
                                </div>

                                <!-- Section 4 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">4</span>
                                        Orientasi spiritual pasien dan keluarga
                                    </h5>

                                    <div class="subsection-title">Apakah perlu pelayanan spiritual?</div>
                                    <div class="radio-group">
                                        <div class="radio-item">
                                            <input type="radio" name="perlu_pelayanan_spiritual" id="spiritual_tidak"
                                                value="0">
                                            <label for="spiritual_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item">
                                            <input type="radio" name="perlu_pelayanan_spiritual" id="spiritual_ya"
                                                value="1">
                                            <label for="spiritual_ya">Ya, oleh:</label>
                                        </div>
                                    </div>

                                    <div class="text-input-group" id="spiritual_keterangan" style="display: none;">
                                        <label class="form-label">Keterangan pelayanan spiritual:</label>
                                        <input type="text" class="form-control" name="spiritual_keterangan"
                                            placeholder="Sebutkan siapa yang memberikan pelayanan spiritual...">
                                    </div>
                                </div>

                                <!-- Section 5 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">5</span>
                                        urusan dan kebutuhan spiritual pasien dan keluarga seperti putus asa, penderitaan, rasa bersalah atau pengampunan:
                                    </h5>

                                    <div class="subsection-title">Perlu didoakan :</div>
                                    <div class="radio-group">
                                        <div class="radio-item">
                                            <input type="radio" name="perlu_didoakan" id="didoakan_tidak" value="0">
                                            <label for="didoakan_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item">
                                            <input type="radio" name="perlu_didoakan" id="didoakan_ya" value="1">
                                            <label for="didoakan_ya">Ya</label>
                                        </div>
                                    </div>

                                    <div class="subsection-title mt-3">Perlu bimbingan rohani :</div>
                                    <div class="radio-group">
                                        <div class="radio-item">
                                            <input type="radio" name="perlu_bimbingan_rohani" id="bimbingan_tidak" value="0">
                                            <label for="bimbingan_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item">
                                            <input type="radio" name="perlu_bimbingan_rohani" id="bimbingan_ya" value="1">
                                            <label for="bimbingan_ya">Ya</label>
                                        </div>
                                    </div>

                                    <div class="subsection-title mt-3">Perlu pendampingan rohani :</div>
                                    <div class="radio-group">
                                        <div class="radio-item">
                                            <input type="radio" name="perlu_pendampingan_rohani" id="pendampingan_tidak" value="0">
                                            <label for="pendampingan_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item">
                                            <input type="radio" name="perlu_pendampingan_rohani" id="pendampingan_ya" value="1">
                                            <label for="pendampingan_ya">Ya</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 6 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">6</span>
                                        Status psikososial dan keluarga
                                    </h5>

                                    <div class="subsection-title">6.1. Apakah ada orang yang ingin dihubungi saat ini?</div>
                                    <div class="radio-group">
                                        <div class="radio-item">
                                            <input type="radio" name="orang_dihubungi" id="orang_dihubungi_tidak" value="0">
                                            <label for="orang_dihubungi_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item">
                                            <input type="radio" name="orang_dihubungi" id="orang_dihubungi_ya" value="1">
                                            <label for="orang_dihubungi_ya">Ya siapa:</label>
                                        </div>
                                    </div>

                                    <div class="text-input-group" id="orang_dihubungi_keterangan" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Nama:</label>
                                                <input type="text" class="form-control" name="nama_dihubungi"
                                                    placeholder="Masukkan nama...">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Hubungan dengan pasien sebagai:</label>
                                                <input type="text" class="form-control" name="hubungan_pasien"
                                                    placeholder="Contoh: Anak, Suami, Istri, dll...">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Dinama:</label>
                                                <input type="text" class="form-control" name="dinama"
                                                    placeholder="Lokasi/tempat...">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">No. Telp/HP:</label>
                                                <input type="text" class="form-control" name="no_telp_hp"
                                                    placeholder="Nomor telepon/HP...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title mt-4">6.2. Bagaimana rencana perawatan selanjutnya?</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="tetap_dirawat_rs" id="tetap_dirawat_rs" value="1">
                                                    <label for="tetap_dirawat_rs">Tetap dirawat di RS</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="dirawat_rumah" id="dirawat_rumah" value="1">
                                                    <label for="dirawat_rumah">Dirawat di rumah</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-input-group mt-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Apakah lingkungan rumah sudah disiapkan?</label>
                                                    <div class="radio-group mt-2">
                                                        <div class="radio-item">
                                                            <input type="radio" name="lingkungan_rumah_siap" id="lingkungan_ya" value="1">
                                                            <label for="lingkungan_ya">Ya</label>
                                                        </div>
                                                        <div class="radio-item">
                                                            <input type="radio" name="lingkungan_rumah_siap" id="lingkungan_tidak" value="0">
                                                            <label for="lingkungan_tidak">Tidak</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-input-group mt-3">
                                            <label class="form-label">Jika Ya, apakah ada yang mampu merawat pasien di rumah?</label>
                                            <div class="radio-group mt-2">
                                                <div class="radio-item">
                                                    <input type="radio" name="mampu_merawat_rumah" id="mampu_merawat_ya" value="1">
                                                    <label for="mampu_merawat_ya">Ya, oleh:</label>
                                                </div>
                                                <div class="radio-item">
                                                    <input type="radio" name="mampu_merawat_rumah" id="mampu_merawat_tidak" value="0">
                                                    <label for="mampu_merawat_tidak">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="text-input-group" id="perawat_rumah_keterangan" style="display: none;">
                                                <label class="form-label">Oleh siapa:</label>
                                                <input type="text" class="form-control" name="perawat_rumah_oleh"
                                                    placeholder="Sebutkan siapa yang akan merawat...">
                                            </div>
                                        </div>

                                        <div class="text-input-group mt-3">
                                            <label class="form-label">Jika tidak, apakah perlu difasilitasi RS (Home Care)?</label>
                                            <div class="radio-group mt-2">
                                                <div class="radio-item">
                                                    <input type="radio" name="perlu_home_care" id="home_care_ya" value="1">
                                                    <label for="home_care_ya">Ya</label>
                                                </div>
                                                <div class="radio-item">
                                                    <input type="radio" name="perlu_home_care" id="home_care_tidak" value="0">
                                                    <label for="home_care_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title mt-4">6.3. Reaksi pasien atas penyakitnya</div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="fw-bold">Asesmen informasi</span>
                                            <div class="checkbox-group mt-2">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="reaksi_menyangkal" id="reaksi_menyangkal" value="1">
                                                    <label for="reaksi_menyangkal">Menyangkal</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="reaksi_marah" id="reaksi_marah" value="1">
                                                    <label for="reaksi_marah">Marah</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="reaksi_takut" id="reaksi_takut" value="1">
                                                    <label for="reaksi_takut">Takut</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkbox-group mt-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="reaksi_sedih_menangis" id="reaksi_sedih_menangis" value="1">
                                                    <label for="reaksi_sedih_menangis">Sedih / menangis</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="reaksi_rasa_bersalah" id="reaksi_rasa_bersalah" value="1">
                                                    <label for="reaksi_rasa_bersalah">Rasa bersalah</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="reaksi_ketidak_berdayaan" id="reaksi_ketidak_berdayaan" value="1">
                                                    <label for="reaksi_ketidak_berdayaan">Ketidak berdayaan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-input-group mt-3">
                                        <label class="form-label required-field">Masalah keperawatan:</label>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="reaksi_anxietas" id="reaksi_anxietas" value="1">
                                                    <label for="reaksi_anxietas">Anxietas</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="reaksi_distress_spiritual" id="reaksi_distress_spiritual" value="1">
                                                    <label for="reaksi_distress_spiritual">Distress Spiritual</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title mt-4">6.4. Reaksi keluarga atas penyakit pasien:</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <span class="fw-bold">Asesmen informasi</span>
                                                <div class="checkbox-group mt-2">
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="keluarga_marah" id="keluarga_marah" value="1">
                                                        <label for="keluarga_marah">Marah</label>
                                                    </div>
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="keluarga_gangguan_tidur" id="keluarga_gangguan_tidur" value="1">
                                                        <label for="keluarga_gangguan_tidur">Gangguan tidur</label>
                                                    </div>
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="keluarga_penurunan_konsentrasi" id="keluarga_penurunan_konsentrasi" value="1">
                                                        <label for="keluarga_penurunan_konsentrasi">Penurunan Konsentrasi</label>
                                                    </div>
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="keluarga_ketidakmampuan_memenuhi_peran" id="keluarga_ketidakmampuan_memenuhi_peran" value="1">
                                                        <label for="keluarga_ketidakmampuan_memenuhi_peran">Ketidakmampuan memenuhi peran yang diharapkan</label>
                                                    </div>
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="keluarga_kurang_berkomunikasi" id="keluarga_kurang_berkomunikasi" value="1">
                                                        <label for="keluarga_kurang_berkomunikasi">Keluarga kurang berkomunikasi dengan pasien</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-group mt-4">
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="keluarga_leth_lelah" id="keluarga_leth_lelah" value="1">
                                                        <label for="keluarga_leth_lelah">Letih/lelah</label>
                                                    </div>
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="keluarga_rasa_bersalah" id="keluarga_rasa_bersalah" value="1">
                                                        <label for="keluarga_rasa_bersalah">Rasa bersalah</label>
                                                    </div>
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="keluarga_perubahan_pola_komunikasi" id="keluarga_perubahan_pola_komunikasi" value="1">
                                                        <label for="keluarga_perubahan_pola_komunikasi">Perubahan kebiasaan pola komunikasi</label>
                                                    </div>
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="keluarga_kurang_berpartisipasi" id="keluarga_kurang_berpartisipasi" value="1">
                                                        <label for="keluarga_kurang_berpartisipasi">Keluarga kurang berpartisipasi membuat keputusan dalam perawatan pasien</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-input-group mt-3">
                                            <label class="form-label required-field">Masalah keperawatan:</label>
                                            <div class="checkbox-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="checkbox-item">
                                                            <input type="checkbox" name="masalah_koping_individu_tidak_efektif" id="masalah_koping_individu_tidak_efektif" value="1">
                                                            <label for="masalah_koping_individu_tidak_efektif">Koping individu tidak efektif</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="checkbox-item">
                                                            <input type="checkbox" name="masalah_distress_spiritual" id="masalah_distress_spiritual" value="1">
                                                            <label for="masalah_distress_spiritual">Distress Spiritual</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 7 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">7</span>
                                        Kebutuhan dukungan atau kelonggaran pelayanan bagi pasien, keluarga dan pemberi pelayanan lain:
                                    </h5>

                                    <div class="checkbox-group">
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="pasien_perlu_didampingi" id="pasien_perlu_didampingi" value="1">
                                            <label for="pasien_perlu_didampingi">Pasien perlu didampingi keluarga</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="keluarga_dapat_mengunjungi_luar_waktu" id="keluarga_dapat_mengunjungi_luar_waktu" value="1">
                                            <label for="keluarga_dapat_mengunjungi_luar_waktu">Keluarga dapat mengunjungi pasien di luar waktu berkunjung</label>
                                        </div>
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="sahabat_dapat_mengunjungi" id="sahabat_dapat_mengunjungi" value="1">
                                            <label for="sahabat_dapat_mengunjungi">Sahabat dapat mengunjungi pasien di luar waktu berkunjung</label>
                                        </div>
                                    </div>

                                    <div class="text-input-group mt-3">
                                        <label class="form-label">Lainnya:</label>
                                        <textarea class="form-control" name="kebutuhan_dukungan_lainnya" rows="3"
                                                placeholder="Sebutkan kebutuhan dukungan lainnya..."></textarea>
                                    </div>
                                </div>

                                <!-- Section 8 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">8</span>
                                        Apakah ada kebutuhan akan alternatif atau tingkat pelayanan lain:
                                    </h5>

                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="alternatif_tidak" id="alternatif_tidak" value="0">
                                                    <label for="alternatif_tidak">Tidak</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="alternatif_autopsi" id="alternatif_autopsi" value="1">
                                                    <label for="alternatif_autopsi">Autopsi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="alternatif_donasi_organ" id="alternatif_donasi_organ" value="1">
                                                    <label for="alternatif_donasi_organ">Donasi Organ:</label>
                                                </div>
                                                <!-- Field keterangan donasi organ langsung di bawah checkbox -->
                                                <div class="text-input-group mt-2" id="donasi_organ_keterangan" style="display: none;">
                                                    <input type="text" class="form-control" name="donasi_organ_detail"
                                                        placeholder="Sebutkan organ yang akan didonasikan...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-input-group mt-3">
                                        <label class="form-label">Lainnya:</label>
                                        <textarea class="form-control" name="alternatif_pelayanan_lainnya" rows="3"
                                                placeholder="Sebutkan alternatif pelayanan lainnya..."></textarea>
                                    </div>
                                </div>

                                <!-- Section 9 -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">9</span>
                                        Faktor resiko bagi keluarga yang ditinggalkan
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <span class="fw-bold">Asesmen informasi</span>
                                            <div class="checkbox-group mt-2">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="faktor_resiko_marah" id="faktor_resiko_marah" value="1">
                                                    <label for="faktor_resiko_marah">Marah</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="faktor_resiko_depresi" id="faktor_resiko_depresi" value="1">
                                                    <label for="faktor_resiko_depresi">Depresi</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="faktor_resiko_rasa_bersalah" id="faktor_resiko_rasa_bersalah" value="1">
                                                    <label for="faktor_resiko_rasa_bersalah">Rasa bersalah</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="faktor_resiko_perubahan_kebiasaan" id="faktor_resiko_perubahan_kebiasaan" value="1">
                                                    <label for="faktor_resiko_perubahan_kebiasaan">Perubahan kebiasaan pola komunikasi</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="faktor_resiko_tidak_mampu_memenuhi" id="faktor_resiko_tidak_mampu_memenuhi" value="1">
                                                    <label for="faktor_resiko_tidak_mampu_memenuhi">Ketidak mampuan memenuhi peran yang diharapkan</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkbox-group mt-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="faktor_resiko_leth_lelah" id="faktor_resiko_leth_lelah" value="1">
                                                    <label for="faktor_resiko_leth_lelah">Letih/lelah</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="faktor_resiko_gangguan_tidur" id="faktor_resiko_gangguan_tidur" value="1">
                                                    <label for="faktor_resiko_gangguan_tidur">Gangguan tidur</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="faktor_resiko_sedih_menangis" id="faktor_resiko_sedih_menangis" value="1">
                                                    <label for="faktor_resiko_sedih_menangis">Sedih/menangis</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="faktor_resiko_penurunan_konsentrasi" id="faktor_resiko_penurunan_konsentrasi" value="1">
                                                    <label for="faktor_resiko_penurunan_konsentrasi">Penurunan konsentrasi</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-input-group mt-3">
                                        <label class="form-label required-field">Masalah keperawatan:</label>
                                        <div class="checkbox-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="masalah_koping_keluarga_tidak_efektif" id="masalah_koping_keluarga_tidak_efektif" value="1">
                                                        <label for="masalah_koping_keluarga_tidak_efektif">Koping keluarga tidak efektif</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="checkbox-item">
                                                        <input type="checkbox" name="masalah_distress_spiritual_keluarga" id="masalah_distress_spiritual_keluarga" value="1">
                                                        <label for="masalah_distress_spiritual_keluarga">Distress Spiritual</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // bagian : 6.2. Bagaimana rencana perawatan selanjutnya?
        // Script untuk mengatur tampilan form rencana perawatan
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua elemen yang dibutuhkan dengan ID spesifik
            const tetapRsCheckbox = document.getElementById('tetap_dirawat_rs');
            const dirawatRumahCheckbox = document.getElementById('dirawat_rumah');
            const lingkunganYa = document.getElementById('lingkungan_ya');
            const lingkunganTidak = document.getElementById('lingkungan_tidak');
            const mamputMerawatYa = document.getElementById('mampu_merawat_ya');
            const mamputMerawatTidak = document.getElementById('mampu_merawat_tidak');
            const perawatRumahKeterangan = document.getElementById('perawat_rumah_keterangan');
            const homeCareYa = document.getElementById('home_care_ya');
            const homeCareNot = document.getElementById('home_care_tidak');

            // Buat ID unik untuk setiap bagian
            const lingkunganRumahSection = document.getElementById('lingkungan_rumah_section');
            const mamputMerawatSection = document.getElementById('mampu_merawat_section');
            const homeCareSection = document.getElementById('home_care_section');

            // Jika belum ada ID, buat berdasarkan struktur yang ada
            if (!lingkunganRumahSection) {
                // Cari berdasarkan parent element yang mengandung radio lingkungan
                const lingkunganParent = lingkunganYa.closest('.text-input-group');
                if (lingkunganParent) {
                    lingkunganParent.id = 'lingkungan_rumah_section';
                }
            }

            if (!mamputMerawatSection) {
                const mamputParent = mamputMerawatYa.closest('.text-input-group');
                if (mamputParent) {
                    mamputParent.id = 'mampu_merawat_section';
                }
            }

            if (!homeCareSection) {
                const homeCareParent = homeCareYa.closest('.text-input-group');
                if (homeCareParent) {
                    homeCareParent.id = 'home_care_section';
                }
            }

            // Fungsi untuk menyembunyikan semua bagian
            function hideAllSections() {
                const sections = [
                    document.getElementById('lingkungan_rumah_section'),
                    document.getElementById('mampu_merawat_section'),
                    document.getElementById('home_care_section')
                ];

                sections.forEach(section => {
                    if (section) {
                        section.style.display = 'none';
                    }
                });

                if (perawatRumahKeterangan) {
                    perawatRumahKeterangan.style.display = 'none';
                }
            }

            // Fungsi untuk reset semua pilihan
            function resetAllChoices() {
                if (lingkunganYa) lingkunganYa.checked = false;
                if (lingkunganTidak) lingkunganTidak.checked = false;
                if (mamputMerawatYa) mamputMerawatYa.checked = false;
                if (mamputMerawatTidak) mamputMerawatTidak.checked = false;
                if (homeCareYa) homeCareYa.checked = false;
                if (homeCareNot) homeCareNot.checked = false;

                const perawatInput = document.querySelector('input[name="perawat_rumah_oleh"]');
                if (perawatInput) {
                    perawatInput.value = '';
                }
            }

            // Event listener untuk checkbox "Tetap dirawat di RS"
            if (tetapRsCheckbox) {
                tetapRsCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Uncheck "Dirawat di rumah"
                        if (dirawatRumahCheckbox) {
                            dirawatRumahCheckbox.checked = false;
                        }
                        // Sembunyikan semua bagian
                        hideAllSections();
                        resetAllChoices();
                    }
                });
            }

            // Event listener untuk checkbox "Dirawat di rumah"
            if (dirawatRumahCheckbox) {
                dirawatRumahCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Uncheck "Tetap dirawat di RS"
                        if (tetapRsCheckbox) {
                            tetapRsCheckbox.checked = false;
                        }
                        // Tampilkan pertanyaan lingkungan rumah
                        const lingkunganSection = document.getElementById('lingkungan_rumah_section');
                        if (lingkunganSection) {
                            lingkunganSection.style.display = 'block';
                        }
                        // Sembunyikan bagian lainnya
                        const mamputSection = document.getElementById('mampu_merawat_section');
                        const homeCareSection = document.getElementById('home_care_section');
                        if (mamputSection) mamputSection.style.display = 'none';
                        if (homeCareSection) homeCareSection.style.display = 'none';
                        if (perawatRumahKeterangan) perawatRumahKeterangan.style.display = 'none';
                        resetAllChoices();
                    } else {
                        // Jika unchecked, sembunyikan semua
                        hideAllSections();
                        resetAllChoices();
                    }
                });
            }

            // Event listener untuk radio "Lingkungan rumah siap - Ya"
            if (lingkunganYa) {
                lingkunganYa.addEventListener('change', function() {
                    if (this.checked) {
                        // Tampilkan pertanyaan mampu merawat
                        const mamputSection = document.getElementById('mampu_merawat_section');
                        if (mamputSection) {
                            mamputSection.style.display = 'block';
                        }
                        // Sembunyikan pertanyaan home care
                        const homeCareSection = document.getElementById('home_care_section');
                        if (homeCareSection) {
                            homeCareSection.style.display = 'none';
                        }
                        if (perawatRumahKeterangan) {
                            perawatRumahKeterangan.style.display = 'none';
                        }
                        // Reset pilihan home care dan mampu merawat
                        if (homeCareYa) homeCareYa.checked = false;
                        if (homeCareNot) homeCareNot.checked = false;
                        if (mamputMerawatYa) mamputMerawatYa.checked = false;
                        if (mamputMerawatTidak) mamputMerawatTidak.checked = false;
                        const perawatInput = document.querySelector('input[name="perawat_rumah_oleh"]');
                        if (perawatInput) perawatInput.value = '';
                    }
                });
            }

            // Event listener untuk radio "Lingkungan rumah siap - Tidak"
            if (lingkunganTidak) {
                lingkunganTidak.addEventListener('change', function() {
                    if (this.checked) {
                        // Tampilkan pertanyaan home care
                        const homeCareSection = document.getElementById('home_care_section');
                        if (homeCareSection) {
                            homeCareSection.style.display = 'block';
                        }
                        // Sembunyikan pertanyaan mampu merawat
                        const mamputSection = document.getElementById('mampu_merawat_section');
                        if (mamputSection) {
                            mamputSection.style.display = 'none';
                        }
                        if (perawatRumahKeterangan) {
                            perawatRumahKeterangan.style.display = 'none';
                        }
                        // Reset pilihan mampu merawat
                        if (mamputMerawatYa) mamputMerawatYa.checked = false;
                        if (mamputMerawatTidak) mamputMerawatTidak.checked = false;
                        const perawatInput = document.querySelector('input[name="perawat_rumah_oleh"]');
                        if (perawatInput) perawatInput.value = '';
                    }
                });
            }

            // Event listener untuk radio "Mampu merawat - Ya"
            if (mamputMerawatYa) {
                mamputMerawatYa.addEventListener('change', function() {
                    if (this.checked) {
                        if (perawatRumahKeterangan) {
                            perawatRumahKeterangan.style.display = 'block';
                        }
                    }
                });
            }

            // Event listener untuk radio "Mampu merawat - Tidak"
            if (mamputMerawatTidak) {
                mamputMerawatTidak.addEventListener('change', function() {
                    if (this.checked) {
                        if (perawatRumahKeterangan) {
                            perawatRumahKeterangan.style.display = 'none';
                        }
                        const perawatInput = document.querySelector('input[name="perawat_rumah_oleh"]');
                        if (perawatInput) {
                            perawatInput.value = '';
                        }
                    }
                });
            }

            // Inisialisasi - sembunyikan semua bagian saat halaman dimuat
            hideAllSections();

        });
    </script>
@endpush
