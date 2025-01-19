@extends('layouts.administrator.master')


@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.include')

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
                                <div class="col-md-8">
                                    <h4 class="header-asesmen">Asesmen Awal Keperawatan Perinatology</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                                <div class="col-md-4">
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
                        </div>

                        {{-- FORM ASESMEN AWAL KEPERATAWAN --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.keperawatan.perinatology.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}">
                            @csrf
                            <div class="px-3">
                                <div>
                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal_masuk">
                                                <input type="time" class="form-control" name="jam_masuk">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Agama Orang Tua</label>
                                            <select class="form-select" name="agama_orang_tua">
                                                <option selected disabled>Pilih</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen">Kristen</option>
                                                <option value="Katolik">Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Budha">Budha</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Section 2: Identitas Bayi -->
                                    <div class="section-separator" id="identitas-bayi">
                                        <h5 class="section-title">2. Identitas Bayi</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Lahir Dan Jam</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal_lahir">
                                                <input type="time" class="form-control" name="jam_lahir">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nama Bayi</label>
                                            <input type="text" class="form-control" name="nama_bayi"
                                                placeholder="Masukkan nama bayi">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Kelamin</label>
                                            <select class="form-select" name="jenis_kelamin">
                                                <option value="" selected disabled>Pilih jenis kelamin</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nama Ibu</label>
                                            <input type="text" class="form-control" name="nama_ibu"
                                                placeholder="Masukkan nama ibu">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">NIK Ibu Kandung</label>
                                            <input type="text" class="form-control" name="nik_ibu"
                                                placeholder="Masukkan NIK ibu kandung">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sidik Telapak Kaki Bayi</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Kaki Kiri</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" name="sidik_kaki_kiri">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kaki Kanan</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" name="sidik_kaki_kanan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sidik Jari Ibu Bayi</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Jari Kiri</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control"
                                                            name="sidik_jari_kiri">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Jari Kanan</label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control"
                                                            name="sidik_jari_kanan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Alamat</label>
                                            <textarea class="form-control" name="alamat" rows="4" placeholder="Masukkan alamat"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="anamnesis">
                                        <h5 class="section-title">3. Anamnesis</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Anamnesis</label>
                                            <textarea class="form-control" name="anamnesis" rows="4"
                                                placeholder="keluhan utama dan riwayat penyakit sekarang"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="pemeriksaan-fisik">
                                        <h5 class="section-title">4. Pemeriksaan fisik</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Kelamin</label>
                                            <select class="form-select" name="jenis_kelamin">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="L">Laki-laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Frekuensi Denyut Nadi (X/Mnt)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="frekuensi"
                                                        placeholder="frekuensi">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <select class="form-select" name="status">
                                                        <option value="" selected disabled>pilih</option>
                                                        <option value="kuat">kuat</option>
                                                        <option value="lemah">lemah</option>
                                                        <option value="teratur">teratur</option>
                                                        <option value="tidak teratur">tidak teratur</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                            <input type="text" class="form-control" name="nafas"
                                                placeholder="frekuensi nafas per menit">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suhu (C)</label>
                                            <input type="text" class="form-control" name="suhu"
                                                placeholder="suhu dalam celcius">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Tanpa O2</label>
                                                    <input type="text" class="form-control" name="tanpa_o2"
                                                        placeholder="tanpa_o2">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Dengan O2</label>
                                                    <input type="text" class="form-control" name="dengan_o2"
                                                        placeholder="dengan_o2">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesadaran</label>
                                            <select class="form-select" name="kesadaran">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="Compos Mentis">Compos Mentis</option>
                                                <option value="Apatis">Apatis</option>
                                                <option value="Sopor">Sopor</option>
                                                <option value="Coma">Coma</option>
                                                <option value="Somnolen">Somnolen</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">AVPU</label>
                                            <select class="form-select" name="avpu">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="0">Sadar Baik/Alert : 0</option>
                                                <option value="1">Berespon dengan kata-kata/Voice: 1</option>
                                                <option value="2">Hanya berespon jika dirangsang nyeri/pain: 2
                                                </option>
                                                <option value="3">Pasien tidak sadar/unresponsive: 3</option>
                                                <option value="4">Gelisah atau bingung: 4</option>
                                                <option value="5">Acute Confusional States: 5</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <h6>Pemeriksaan Lanjutan</h6>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Warna Kulit</label>
                                                <select class="form-select" name="warna_kulit">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Pink">Pink</option>
                                                    <option value="Kuning">Kuning</option>
                                                    <option value="Pucat">Pucat</option>
                                                    <option value="Kuning dan Merah">Kuning dan Merah</option>
                                                    <option value="Kuning dan Hijau">Kuning dan Hijau</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Sianosis</label>
                                                <select class="form-select" name="sianosis">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Kuku">Kuku</option>
                                                    <option value="Sekitar Mulut">Sekitar Mulut</option>
                                                    <option value="Sekitar Mata">Sekitar Mata</option>
                                                    <option value="Ekstremitas Atas">Ekstremitas Atas</option>
                                                    <option value="Ekstremitas Bawah">Ekstremitas Bawah</option>
                                                    <option value="Seluruh Tubuh">Seluruh Tubuh</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Kemerahan/Rash</label>
                                                <select class="form-select" name="kemerahan">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Tidak Ada">Tidak Ada</option>
                                                    <option value="Ada">Ada</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Turgor Kulut</label>
                                                <select class="form-select" name="turgor_kulit">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Elastis">Elastis</option>
                                                    <option value="Tidak Elastis">Tidak Elastis</option>
                                                    <option value="Edema">Edema</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tanda Lahir</label>
                                                <input type="text" class="form-control" name="tanda_lahir"
                                                    placeholder="sebutkan">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Fontanel Anterior</label>
                                                <select class="form-select" name="fontanel">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Lunak">Lunak</option>
                                                    <option value="Tegas">Tegas</option>
                                                    <option value="Datar">Datar</option>
                                                    <option value="Menonjol">Menonjol</option>
                                                    <option value="Cekung">Cekung</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Sutura Sagitalis</label>
                                                <select class="form-select" name="sutura">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Tepat">Tepat</option>
                                                    <option value="Terpisah">Terpisah</option>
                                                    <option value="Menjauh">Menjauh</option>
                                                    <option value="Tumpang Tindih">Tumpang Tindih</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Gambaran Wajah</label>
                                                <select class="form-select" name="gamaban_wajah">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Simetris">Simetris</option>
                                                    <option value="Asimetris">Asimetris</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Cephalhemeton</label>
                                                <select class="form-select" name="cephalhemeton">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Ada">Ada</option>
                                                    <option value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Caput Succedaneun</label>
                                                <select class="form-select" name="caput_succedaneun">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Ada">Ada</option>
                                                    <option value="Tidak Ada">Tidak Ada</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Mulut</label>
                                                <select class="form-select" name="mulut">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Bibir Sumbing">Bibir Sumbing</option>
                                                    <option value="Sumbing Platum">Sumbing Platum</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Mucosa Mulut</label>
                                                <select class="form-select" name="mucosa_mulut">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Lembab">Lembab</option>
                                                    <option value="Kering">Kering</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Dada dan Paru-paru</label>
                                                <select class="form-select" name="dada_dan_paru-paru">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Simetris">Simetris</option>
                                                    <option value="Asimetris">Asimetris</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Suara Nafas</label>
                                                <select class="form-select" name="suara_nafas">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Kanan Kiri Sama">Kanan Kiri Sama</option>
                                                    <option value="Tidak Sama">Tidak Sama</option>
                                                    <option value="Bersih">Bersih</option>
                                                    <option value="Wheezing">Wheezing</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Respirasi</label>
                                                <select class="form-select" name="respirasi">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Spontan tanpa alat bantu">Spontan tanpa alat bantu
                                                    </option>
                                                    <option value="Spontan dengan alat bantu">Spontan dengan alat bantu
                                                    </option>
                                                    <option value="Tidak Spontan">Tidak Spontan</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Down Score</label>
                                                <input type="text" class="form-control" name="down_score">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Bunyi Jantung</label>
                                                <select class="form-select" name="bunyi_jantung">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Gallop">Gallop</option>
                                                    <option value="Friction">Friction</option>
                                                    <option value="Rub">Rub</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Waktu Pengisian Kapiler (CRT)</label>
                                                <select class="form-select" name="crt">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Tidak Normal">Tidak Normal</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Keadaan Perut</label>
                                                <select class="form-select" name="keadaan_perut">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Lunak">Lunak</option>
                                                    <option value="Datar">Datar</option>
                                                    <option value="Distensi">Distensi</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Umbilikus</label>
                                                <select class="form-select" name="umbilikus">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Basah">Basah</option>
                                                    <option value="Kering">Kering</option>
                                                    <option value="Bau">Bau</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Warna Umbilikus</label>
                                                <select class="form-select" name="warna_umbilikus">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Putih">Putih</option>
                                                    <option value="Kuning">Kuning</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Genitalis</label>
                                                <select class="form-select" name="genitalis">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Perempuan, Normal">Perempuan, Normal</option>
                                                    <option value="Laki-Laki, Normal">Laki-Laki, Normal</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Gerakan</label>
                                                <select class="form-select" name="gerakan">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Terbatas">Terbatas</option>
                                                    <option value="Tidak Terkaji">Tidak Terkaji</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Ekstremitas Atas</label>
                                                <select class="form-select" name="ekstremitas_atas">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Tidak Normal">Tidak Normal</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Ekstremitas Bawah</label>
                                                <select class="form-select" name="ekstremitas_bawah">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Tidak Normal">Tidak Normal</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tulang Belakang</label>
                                                <select class="form-select" name="tulang_belakang">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Tidak Normal">Tidak Normal</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Refleks</label>
                                                <select class="form-select" name="refleks">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Tidak Normal">Tidak Normal</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Genggaman</label>
                                                <select class="form-select" name="Genggaman">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Kuat">Kuat</option>
                                                    <option value="Lemah">Lemah</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Menghisap</label>
                                                <select class="form-select" name="menghisap">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Kuat">Kuat</option>
                                                    <option value="Lemah">Lemah</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tonus/Aktivitas</label>
                                                <select class="form-select" name="tonus">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Aktif">Aktif</option>
                                                    <option value="Tenang">Tenang</option>
                                                    <option value="Letargi">Letargi</option>
                                                    <option value="Kejang">Kejang</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Menangis</label>
                                                <select class="form-select" name="meanghis">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="Keras">Keras</option>
                                                    <option value="Lemah">Lemah</option>
                                                    <option value="Melengking">Melengking</option>
                                                    <option value="Sulit Menangis">Sulit Menangis</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="mt-4">
                                            <h6>Antropometri</h6>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tinggi Badan (Kg)</label>
                                                <input type="text" class="form-control" name="tinggi_badan">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                                <input type="text" class="form-control" name="berat_badan">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">IMT</label>
                                                <input type="text" class="form-control" name="imt">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">LPT</label>
                                                <input type="text" class="form-control" name="lpt">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Lingkar Kepala (Cm)</label>
                                                <input type="text" class="form-control" name="lingkar_kepala">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Lingkar Dada (Cm)</label>
                                                <input type="text" class="form-control" name="lingkar_dada">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Lingkar Perut (Cm)</label>
                                                <input type="text" class="form-control" name="lingkar_perut">
                                            </div>
                                        </div>

                                        <div class="alert alert-info mb-3 mt-4">
                                            <p class="mb-0 small">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk
                                                menambah
                                                keterangan fisik yang ditemukan tidak normal.
                                                Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                            </p>
                                        </div>

                                        <div class="row g-3">
                                            @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column gap-3">
                                                        @foreach ($chunk as $item)
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center border-bottom pb-2">
                                                                    <div class="flex-grow-1">{{ $item->nama }}</div>
                                                                    <div class="form-check me-3">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="{{ strtolower($item->nama) }}-normal"
                                                                            checked>
                                                                        <label class="form-check-label"
                                                                            for="{{ strtolower($item->nama) }}-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        type="button"
                                                                        data-target="{{ strtolower($item->nama) }}-keterangan">
                                                                        <i class="bi bi-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="keterangan mt-2"
                                                                    id="{{ strtolower($item->nama) }}-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ strtolower($item->nama) }}_keterangan"
                                                                        placeholder="Tambah keterangan jika tidak normal...">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="section-separator" id="riwayat-kesehatan">
                                        <h5 class="section-title">5. Riwayat Kesehatan Ibu</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pemeriksaan Kehamilan</label>
                                            <select class="form-select" name="pemeriksaan_kehamilan">
                                                <option value="" selected disabled>Pilih</option>
                                                <option value="teratur">Teratur</option>
                                                <option value="tidak_teratur">Tidak Teratur</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tempat Pemeriksaan</label>
                                            <select class="form-select" name="tempat_pemeriksaan">
                                                <option value="" selected disabled>Pilih</option>
                                                <option value="puskesmas">Puskesmas</option>
                                                <option value="rumah_sakit">Rumah Sakit</option>
                                                <option value="klinik">Klinik</option>
                                                <option value="dokter_praktek">Dokter Praktek</option>
                                                <option value="bidan">Bidan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Usia Kehamilan/Masa Gestasi</label>
                                            <input type="text" class="form-control" name="usia_kehamilan"
                                                placeholder="Masukkan usia kehamilan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Cara Persalinan</label>
                                            <select class="form-select" name="cara_persalinan">
                                                <option value="" selected disabled>Pilih</option>
                                                <option value="normal">Normal</option>
                                                <option value="sectio_caesaria">Sectio Caesaria</option>
                                                <option value="vakum">Vakum</option>
                                                <option value="forcep">Forcep</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Riwayat Penyakit dan Pengobatan</label>
                                            <p class="text-muted small">Pilih tanda tambah untuk menambah keterangan
                                                penyakit dan pegobatan yang ada, bila tidak terdapat penyakit dan pengobatan
                                                maka tidak perlu untuk ditambahkan.</p>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-nyeri">
                                        <h5 class="section-title">6. Status Nyeri</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                            <select class="form-select" name="jenis_skala_nyeri">
                                                <option value="" selected disabled>Pilih</option>
                                                <option value="NRS">Numeric Rating Scale (NRS)</option>
                                                <option value="VAS">Visual Analog Scale (VAS)</option>
                                                <option value="FLACC">FLACC Scale</option>
                                                <option value="Wong-Baker">Wong-Baker FACES Scale</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                            <input type="number" class="form-control" name="nilai_skala_nyeri"
                                                min="0" max="10">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                            <div class="alert alert-success">
                                                Nyeri Ringan
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h6>Karakteristik Nyeri</h6>

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Lokasi</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="lokasi_nyeri"
                                                            placeholder="Lokasi nyeri">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Durasi</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="durasi_nyeri"
                                                            placeholder="Durasi nyeri">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Jenis nyeri</label>
                                                    <div class="form-group">
                                                        <select class="form-select" name="jenis_nyeri">
                                                            <option value="" selected disabled>Pilih</option>
                                                            <option value="akut">Akut</option>
                                                            <option value="kronik">Kronik</option>
                                                            <option value="menetap">Menetap</option>
                                                            <option value="hilang_timbul">Hilang Timbul</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Frekuensi</label>
                                                    <div class="form-group">
                                                        <select class="form-select" name="frekuensi_nyeri">
                                                            <option value="" selected disabled>Pilih</option>
                                                            <option value="jarang">Jarang</option>
                                                            <option value="sering">Sering</option>
                                                            <option value="terus_menerus">Terus Menerus</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Menjalar?</label>
                                                    <div class="form-group">
                                                        <select class="form-select" name="nyeri_menjalar">
                                                            <option value="" selected disabled>Pilih</option>
                                                            <option value="ya">Ya</option>
                                                            <option value="tidak">Tidak</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Kualitas</label>
                                                    <div class="form-group">
                                                        <select class="form-select" name="kualitas_nyeri">
                                                            <option value="" selected disabled>Pilih</option>
                                                            <option value="seperti_ditusuk">Seperti Ditusuk</option>
                                                            <option value="terbakar">Terbakar</option>
                                                            <option value="tertindih">Tertindih</option>
                                                            <option value="tertiban">Tertiban</option>
                                                            <option value="tertekan">Tertekan</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Faktor pemberat</label>
                                                    <div class="form-group">
                                                        <select class="form-select" name="faktor_pemberat">
                                                            <option value="" selected disabled>Pilih</option>
                                                            <option value="aktivitas">Aktivitas</option>
                                                            <option value="pergerakan">Pergerakan</option>
                                                            <option value="batuk">Batuk</option>
                                                            <option value="stress">Stress</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Faktor peringan</label>
                                                    <div class="form-group">
                                                        <select class="form-select" name="faktor_peringan">
                                                            <option value="" selected disabled>Pilih</option>
                                                            <option value="istirahat">Istirahat</option>
                                                            <option value="medikasi">Medikasi</option>
                                                            <option value="posisi">Posisi</option>
                                                            <option value="kompres">Kompres</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label">Efek Nyeri</label>
                                                    <div class="form-group">
                                                        <textarea class="form-control" name="efek_nyeri" rows="3" placeholder="Jelaskan efek nyeri yang dirasakan..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">7. Alergi</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openAlergiModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>

                                        <div class="table-responsive">
                                            <table class="table" id="createAlergiTable">
                                                <thead>
                                                    <tr>
                                                        <th>Alergen</th>
                                                        <th>Reaksi</th>
                                                        <th>Severe</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table content will be dynamically populated -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="risiko-jatuh">
                                        <h5 class="section-title">8. Risiko Jatuh</h5>

                                        <p class="text-muted">Pilih jenis Skala Risiko Jatuh sesuai kondisi pasien</p>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pilih skala jatuh</label>
                                            <select class="form-select" name="skala_jatuh">
                                                <option value="" selected disabled>Pilih skala jatuh</option>
                                                <option value="skala_umum">Skala Umum</option>
                                                <option value="skala_morse">Skala Morse</option>
                                                <option value="skala_humpty">Skala Humpty-Dumpty/ Anak</option>
                                                <option value="skala_ontario">Skala Ontario Modified Stratify Sydney/
                                                    Lansia</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <!-- Form untuk Skala yang dipilih akan muncul di sini -->
                                        <div id="form-skala-container" class="mt-4" style="display: none;">
                                            <!-- Konten form akan di-load sesuai skala yang dipilih -->
                                        </div>

                                        <div class="mt-4">
                                            <h6>Intervensi Risiko Jatuh</h6>
                                            <p class="text-muted small">Tambah tindakan intervensi risiko jatuh:</p>

                                            <div class="mb-3">
                                                <div class="list-group" id="intervensi-list">
                                                    <!-- Existing interventions will be listed here -->
                                                    <div class="list-group-item">
                                                        1. Edukasi pasien dan keluarga
                                                        <button class="btn btn-sm btn-outline-danger float-end"
                                                            onclick="removeIntervention(this)">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="list-group-item">
                                                        2. Pasang pita kuning
                                                        <button class="btn btn-sm btn-outline-danger float-end"
                                                            onclick="removeIntervention(this)">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="input-group">
                                                <input type="text" class="form-control" id="new-intervention"
                                                    placeholder="Tambah intervensi baru">
                                                <button class="btn btn-outline-primary" type="button"
                                                    onclick="addIntervention()">
                                                    <i class="bi bi-plus"></i> Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="decubitus">
                                        <h5 class="section-title">9. Risiko dekubitus</h5>
                                        <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>

                                        <div class="form-group mb-4">
                                            <select class="form-select" id="skalaRisikoDekubitus"
                                                name="jenis_skala_dekubitus">
                                                <option value="" selected disabled>Pilih skala Decubitus</option>
                                                <option value="norton">Skala Norton</option>
                                                <option value="braden">Skala Braden</option>
                                                <option value="waterlow">Skala Waterlow</option>
                                            </select>
                                        </div>

                                        <!-- Form Skala Norton -->
                                        <div id="formNorton" class="decubitus-form" style="display: none;">
                                            <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                            <div class="mb-4">
                                                <label class="form-label">Kondisi Fisik</label>
                                                <select class="form-select bg-light" name="kondisi_fisik">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="4">Baik</option>
                                                    <option value="3">Sedang</option>
                                                    <option value="2">Buruk</option>
                                                    <option value="1">Sangat Buruk</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Kondisi mental</label>
                                                <select class="form-select bg-light" name="kondisi_mental">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="4">Sadar</option>
                                                    <option value="3">Apatis</option>
                                                    <option value="2">Bingung</option>
                                                    <option value="1">Stupor</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Aktivitas</label>
                                                <select class="form-select bg-light" name="aktivitas">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="4">Aktif</option>
                                                    <option value="3">Jalan dengan bantuan</option>
                                                    <option value="2">Terbatas di kursi</option>
                                                    <option value="1">Terbatas di tempat tidur</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Mobilitas</label>
                                                <select class="form-select bg-light" name="mobilitas">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="4">Bebas bergerak</option>
                                                    <option value="3">Agak terbatas</option>
                                                    <option value="2">Sangat terbatas</option>
                                                    <option value="1">Tidak dapat bergerak</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Inkontinensia</label>
                                                <select class="form-select bg-light" name="inkontinensia">
                                                    <option value="" selected disabled>pilih</option>
                                                    <option value="4">Tidak ada</option>
                                                    <option value="3">Kadang-kadang</option>
                                                    <option value="2">Biasanya urin</option>
                                                    <option value="1">Urin dan feses</option>
                                                </select>
                                            </div>

                                            <div class="mt-4">
                                                <div class="d-flex gap-2">
                                                    <span class="fw-bold">Kesimpulan :</span>
                                                    <div id="kesimpulanNorton"
                                                        class="alert alert-success mb-0 flex-grow-1">
                                                        Risiko Rendah
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Skala Braden -->
                                        <div id="formBraden" class="decubitus-form" style="display: none;">
                                            <!-- Add Braden scale form fields -->
                                        </div>

                                        <!-- Form Skala Waterlow -->
                                        <div id="formWaterlow" class="decubitus-form" style="display: none;">
                                            <!-- Add Waterlow scale form fields -->
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-gizi">
                                        <h5 class="section-title">11. Status Gizi</h5>
                                        <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>
                                        <div class="form-group">
                                            <select class="form-select" name="jenis_skala_gizi">
                                                <option value="" selected disabled>Pilih skala</option>
                                                <option value="malnutrisi">Malnutrisi</option>
                                                <option value="normal">Normal</option>
                                                <option value="obesitas">Obesitas</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-fungsional">
                                        <h5 class="section-title">12. Status Fungsional</h5>
                                        <label class="form-label">Pilih jenis Skala Pengkajian Aktivitas Harian
                                                (ADL) sesuai kondisi pasien</label>
                                        <div class="form-group">
                                            <select class="form-select" name="skala_fungsional">
                                                <option value="" selected disabled>Pilih Skala Fungsional</option>
                                                <option value="barthel">Barthel Index</option>
                                                <option value="katz">Katz Index</option>
                                                <option value="lawton">Lawton-Brody Scale</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nilai Skala ADL</label>
                                            <select class="form-select" name="nilai_adl">
                                                <option value="" selected disabled>Pilih nilai</option>
                                                <option value="mandiri">Mandiri</option>
                                                <option value="bantuan_ringan">Bantuan Ringan</option>
                                                <option value="bantuan_sedang">Bantuan Sedang</option>
                                                <option value="bantuan_berat">Bantuan Berat</option>
                                                <option value="ketergantungan_total">Ketergantungan Total</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesimpulan Fungsional</label>
                                            <div class="alert alert-success">
                                                BANTUAN SEDANG
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="kebutuhan-edukasi">
                                        <h5 class="section-title">13. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran
                                        </h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Gaya Bicara</label>
                                            <select class="form-select" name="gaya_bicara">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="normal">Normal</option>
                                                <option value="lambat">Lambat</option>
                                                <option value="cepat">Cepat</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bahasa Sehari-Hari</label>
                                            <select class="form-select" name="bahasa_sehari_hari">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="indonesia">Bahasa Indonesia</option>
                                                <option value="daerah">Bahasa Daerah</option>
                                                <option value="asing">Bahasa Asing</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Perlu Penerjemah</label>
                                            <select class="form-select" name="perlu_penerjemah">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Hambatan Komunikasi</label>
                                            <select class="form-select" name="hambatan_komunikasi">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="tidak_ada">Tidak Ada</option>
                                                <option value="pendengaran">Gangguan Pendengaran</option>
                                                <option value="bicara">Gangguan Bicara</option>
                                                <option value="bahasa">Perbedaan Bahasa</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Media Disukai</label>
                                            <select class="form-select" name="media_disukai">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="cetak">Media Cetak</option>
                                                <option value="video">Video</option>
                                                <option value="diskusi">Diskusi Langsung</option>
                                                <option value="demonstrasi">Demonstrasi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tingkat Pendidikan</label>
                                            <select class="form-select" name="tingkat_pendidikan">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="sd">SD</option>
                                                <option value="smp">SMP</option>
                                                <option value="sma">SMA</option>
                                                <option value="diploma">Diploma</option>
                                                <option value="sarjana">Sarjana</option>
                                                <option value="tidak_sekolah">Tidak Sekolah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="discharge-planning">
                                        <h5 class="section-title">14. Disharge Planning</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Lokasi nyeri">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Usia lanjut</label>
                                            <select class="form-select" name="usia_lanjut">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Hambatan mobilisasi</label>
                                            <select class="form-select" name="hambatan_mobilisasi">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                            <select class="form-select" name="penggunaan_media_berkelanjutan">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                                harian</label>
                                            <select class="form-select" name="ketergantungan_aktivitas">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Perkiraan lama hari dirawat</label>
                                            <input type="text" class="form-control" name="perkiraan_hari"
                                                placeholder="hari">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Rencana Tanggal Pulang</label>
                                            <input type="date" class="form-control" name="tanggal_pulang">
                                        </div>

                                        <div class="mt-4">
                                            <label class="form-label">KESIMPULAN</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="alert alert-warning">
                                                    Mebutuhkan rencana pulang khusus
                                                </div>
                                                <div class="alert alert-success">
                                                    Tidak mebutuhkan rencana pulang khusus
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="section-title">15. Diagnosis</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis Diferensial</label>
                                            <p class="text-muted small">Pilih tanda dokumen untuk mencari diagnosis
                                                diferensial, apabila tidak ada, pilih tanda tambah untuk menambah keterangan
                                                diagnosis diferensial yang tidak ditemukan.</p>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="diagnosisDiferensialInput"
                                                    placeholder="Cari dan tambah Diagnosis Diferensial">
                                                <button class="btn btn-outline-primary" type="button"
                                                    id="btnAddDiagnosisDiferensial">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <div class="list-group" id="diagnosisDiferensialList">
                                                <!-- List akan muncul disini -->
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis Kerja</label>
                                            <p class="text-muted small">Pilih tanda dokumen untuk mencari diagnosis kerja,
                                                apabila tidak ada, Pilih tanda tambah untuk menambah keterangan diagnosis
                                                kerja yang tidak ditemukan.</p>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="diagnosisKerjaInput"
                                                    placeholder="Cari dan tambah Diagnosis Kerja">
                                                <button class="btn btn-outline-primary" type="button"
                                                    id="btnAddDiagnosisKerja">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <div class="list-group" id="diagnosisKerjaList">
                                                <!-- List akan muncul disini -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="implementasi">
                                        <h5 class="section-title">16. Implementasi</h5>

                                        <div class="mb-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="Cari dan tambah Implemtasi">
                                                <button class="btn btn-outline-primary" type="button">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="list-group">
                                            <div class="list-group-item list-group-item-light">
                                                1. Memberikan antibiotik intravena sesuai jadwal.
                                            </div>
                                            <div class="list-group-item list-group-item-light">
                                                2. Mengajarkan pasien cara menggunakan inhaler untuk asma
                                            </div>
                                            <div class="list-group-item list-group-item-light">
                                                3. Membersihkan luka dengan cairan NaCl dan mengganti balutan setiap hari
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="implementasi-evaluasi">
                                        <h5 class="section-title">17. Evaluasi</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Tambah Evaluasi Keperawatan</label>
                                            <textarea class="form-control" rows="4" name="evaluasi_keperawatan"
                                                placeholder="Tambah evaluasi keperawatan..."></textarea>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.modal-create-alergi')
@endsection
