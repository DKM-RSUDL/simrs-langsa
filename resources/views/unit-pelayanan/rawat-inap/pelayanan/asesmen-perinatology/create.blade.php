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
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Asesmen Awal Keperawatan Perinatology</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
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
                            ]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="px-3">
                                <div>
                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal_masuk"
                                                    value="{{ date('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk"
                                                    value="{{ date('H:i') }}">
                                            </div>
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
                                                <option value="0">Laki-laki</option>
                                                <option value="1">Perempuan</option>
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

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sidik Telapak Kaki Bayi</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Kaki Kiri</label>
                                                    <div class="input-group">
                                                        <input type="file" 
                                                            class="form-control @error('sidik_kaki_kiri') is-invalid @enderror" 
                                                            name="sidik_kaki_kiri">
                                                    </div>
                                                    <small class="text-muted">Format: JPG, PNG, PDF | Maks: 10MB</small>
                                                    @error('sidik_kaki_kiri')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kaki Kanan</label>
                                                    <div class="input-group">
                                                        <input type="file" 
                                                            class="form-control @error('sidik_kaki_kanan') is-invalid @enderror" 
                                                            name="sidik_kaki_kanan">
                                                    </div>
                                                    <small class="text-muted">Format: JPG, PNG, PDF | Maks: 10MB</small>
                                                    @error('sidik_kaki_kanan')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
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
                                            <label style="min-width: 200px;">Frekuensi Denyut Nadi (X/Mnt)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="frekuensi"
                                                        placeholder="frekuensi">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <select class="form-select" name="status_frekuensi">
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
                                            <input type="text" class="form-control" name="frekuensi_nafas"
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
                                                    <input type="text" class="form-control" name="spo_tanpa_o2"
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
                                                <label style="min-width: 200px;">Turgor Kulit</label>
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
                                                <select class="form-select" name="fontanel_anterior">
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
                                                <select class="form-select" name="sutura_sagitalis">
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
                                                <select class="form-select" name="dada_paru">
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
                                                <div class="d-flex">
                                                    <input type="text" class="form-control" name="down_score"
                                                        id="down_score" readonly>
                                                    <button type="button" class="btn btn-primary ms-2" id="btnDownScore"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#downScoreModal">Skor</button>
                                                </div>
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
                                                <select class="form-select" name="waktu_pengisian_kapiler">
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
                                                <select class="form-select" name="aktivitas">
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
                                                <label style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                                <input type="number" id="tinggi_badan" name="tinggi_badan"
                                                    class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                                <input type="number" id="berat_badan" name="berat_badan"
                                                    class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">IMT</label>
                                                <input type="text" class="form-control bg-light" id="imt"
                                                    name="imt" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">LPT</label>
                                                <input type="text" class="form-control bg-light" id="lpt"
                                                    name="lpt" readonly>
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

                                        <div class="row g-3">
                                            <div class="pemeriksaan-fisik">
                                                <h6>Pemeriksaan Fisik</h6>
                                                <p class="text-small">Centang normal jika fisik yang dinilai
                                                    normal,
                                                    pilih tanda tambah
                                                    untuk menambah keterangan fisik yang ditemukan tidak normal.
                                                    Jika
                                                    tidak dipilih salah satunya, maka pemeriksaan tidak
                                                    dilakukan.
                                                </p>
                                                <div class="row">
                                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                        <div class="col-md-6">
                                                            <div class="d-flex flex-column gap-3">
                                                                @foreach ($chunk as $item)
                                                                    <div class="pemeriksaan-item">
                                                                        <div
                                                                            class="d-flex align-items-center border-bottom pb-2">
                                                                            <div class="flex-grow-1">{{ $item->nama }}
                                                                            </div>
                                                                            <div class="form-check me-3">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    id="{{ $item->id }}-normal"
                                                                                    name="{{ $item->id }}-normal"
                                                                                    checked>
                                                                                <label class="form-check-label"
                                                                                    for="{{ $item->id }}-normal">Normal</label>
                                                                            </div>
                                                                            <button
                                                                                class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                                type="button"
                                                                                data-target="{{ $item->id }}-keterangan">
                                                                                <i class="bi bi-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="keterangan mt-2"
                                                                            id="{{ $item->id }}-keterangan"
                                                                            style="display:none;">
                                                                            <input type="text" class="form-control"
                                                                                name="{{ $item->id }}_keterangan"
                                                                                placeholder="Tambah keterangan jika tidak normal...">
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
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

                                        <div class="row g-3">
                                            <label style="min-width: 200px;">Riwayat Penyakit dan Pengobatan</label>
                                            <p class="text-muted small">Pilih tanda tambah untuk menambah keterangan
                                                penyakit dan pengobatan yang ada, bila tidak terdapat penyakit dan
                                                pengobatan maka tidak perlu untuk ditambahkan.</p>
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                id="btnTambahRiwayat" data-bs-toggle="modal"
                                                data-bs-target="#riwayatModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>

                                            <div class="table-responsive">
                                                <table class="table" id="riwayatTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Penyakit</th>
                                                            <th>Obat</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Table content will be dynamically populated -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" name="riwayat_penyakit_pengobatan" id="riwayatJson">
                                        </div>
                                    </div>

                                    <!-- Modal untuk Riwayat Penyakit dan Pengobatan -->
                                    <div class="modal fade" id="riwayatModal" tabindex="-1"
                                        aria-labelledby="riwayatModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="riwayatModalLabel">Tambah Riwayat Penyakit
                                                        dan Pengobatan</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="namaPenyakit">Nama Penyakit</label>
                                                        <input type="text" class="form-control" id="namaPenyakit"
                                                            placeholder="Masukkan nama penyakit">
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="namaObat">Nama Obat</label>
                                                        <input type="text" class="form-control" id="namaObat"
                                                            placeholder="Masukkan nama obat">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="btnTambahRiwayatModal">Tambah</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="section-separator" id="status-nyeri">
                                        <h5 class="section-title">6. Status nyeri</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                            <select class="form-select" name="jenis_skala_nyeri" id="jenis_skala_nyeri">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="NRS">Numeric Rating Scale (NRS)</option>
                                                <option value="FLACC">Face, Legs, Activity, Cry, Consolability (FLACC)
                                                </option>
                                                <option value="CRIES">Crying, Requires, Increased, Expression, Sleepless
                                                    (CRIES)</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                            <input type="text" class="form-control" id="nilai_skala_nyeri"
                                                name="nilai_skala_nyeri" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                            <input type="hidden" class="form-control" id="kesimpulan_nyeri"
                                                name="kesimpulan_nyeri">
                                            <div class="alert alert-success" id="kesimpulan_nyeri_alert">
                                                Pilih skala nyeri terlebih dahulu
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h6 class="mb-3">Karakteristik Nyeri</h6>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Lokasi</label>
                                                    <input type="text" class="form-control" name="lokasi_nyeri">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Durasi</label>
                                                    <input type="text" class="form-control" name="durasi_nyeri">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Jenis nyeri</label>
                                                    <select class="form-select" name="jenis_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($jenisnyeri as $jenis)
                                                            <option value="{{ $jenis->id }}">{{ $jenis->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Frekuensi</label>
                                                    <select class="form-select" name="frekuensi_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($frekuensinyeri as $frekuensi)
                                                            <option value="{{ $frekuensi->id }}">{{ $frekuensi->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Menjalar?</label>
                                                    <select class="form-select" name="nyeri_menjalar">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($menjalar as $menjalar)
                                                            <option value="{{ $menjalar->id }}">{{ $menjalar->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kualitas</label>
                                                    <select class="form-select" name="kualitas_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($kualitasnyeri as $kualitas)
                                                            <option value="{{ $kualitas->id }}">{{ $kualitas->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Faktor pemberat</label>
                                                    <select class="form-select" name="faktor_pemberat">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($faktorpemberat as $pemberat)
                                                            <option value="{{ $pemberat->id }}">{{ $pemberat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Faktor peringan</label>
                                                    <select class="form-select" name="faktor_peringan">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($faktorperingan as $peringan)
                                                            <option value="{{ $peringan->id }}">{{ $peringan->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">Efek Nyeri</label>
                                                    <select class="form-select" name="efek_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($efeknyeri as $efek)
                                                            <option value="{{ $efek->id }}">{{ $efek->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                        <input type="hidden" name="alergis" id="alergisInput">
                                        <div class="table-responsive">
                                            <table class="table" id="createAlergiTable">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis</th>
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

                                    <div class="section-separator" id="risiko_jatuh">
                                        <h5 class="section-title">8. Risiko Jatuh</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan
                                                kondisi
                                                pasien:</label>
                                            <select class="form-select" id="risikoJatuhSkala" name="resiko_jatuh_jenis"
                                                onchange="showForm(this.value)">
                                                <option value="">--Pilih Skala--</option>
                                                <option value="1">Skala Umum</option>
                                                <option value="2">Skala Morse</option>
                                                <option value="3">Skala Humpty-Dumpty / Pediatrik</option>
                                                <option value="4">Skala Ontario Modified Stratify Sydney / Lansia
                                                </option>
                                                <option value="5">Lainnya</option>
                                            </select>
                                        </div>

                                        <!-- Form Skala Umum 1 -->
                                        <div id="skala_umumForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Umum</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien berusia < dari 2 tahun?</label>
                                                        <select class="form-select" name="risiko_jatuh_umum_usia"
                                                            onchange="updateConclusion('umum')">
                                                            <option value="">pilih</option>
                                                            <option value="1">Ya</option>
                                                            <option value="0">Tidak</option>
                                                        </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien dalam kondisi sebagai geriatri,
                                                    dizzines, vertigo,
                                                    gangguan keseimbangan, gangguan penglihatan, penggunaan obat sedasi,
                                                    status
                                                    kesadaran dan
                                                    atau kejiwaan, konsumsi alkohol?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')"
                                                    name="risiko_jatuh_umum_kondisi_khusus">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien didiagnosis sebagai pasien dengan
                                                    penyakit
                                                    parkinson?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')"
                                                    name="risiko_jatuh_umum_diagnosis_parkinson">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien sedang mendapatkan obat sedasi,
                                                    riwayat
                                                    tirah baring
                                                    lama, perubahan posisi yang akan meningkatkan risiko jatuh?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')"
                                                    name="risiko_jatuh_umum_pengobatan_berisiko">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien saat ini sedang berada pada salah
                                                    satu
                                                    lokasi ini: rehab
                                                    medik, ruangan dengan penerangan kurang dan bertangga?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')"
                                                    name="risiko_jatuh_umum_lokasi_berisiko">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm"></span></p>
                                                <input type="hidden" name="risiko_jatuh_umum_kesimpulan"
                                                    id="risiko_jatuh_umum_kesimpulan">
                                            </div>
                                        </div>

                                        <!-- Memperbaiki bagian Form Skala Morse 2 -->
                                        <div id="skala_morseForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Morse</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien pernah mengalami Jatuh?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_riwayat_jatuh"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="25">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki diagnosis skunder?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_diagnosis_sekunder"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="15">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien membutuhkan bantuan ambulasi?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_bantuan_ambulasi"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="30">Meja/ kursi</option>
                                                    <option value="15">Kruk/ tongkat/ alat bantu berjalan</option>
                                                    <option value="0">Tidak ada/ bed rest/ bantuan perawat</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien terpasang infus?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_terpasang_infus"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="20">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_cara_berjalan"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Normal/ bed rest/ kursi roda</option>
                                                    <option value="20">Terganggu</option>
                                                    <option value="10">Lemah</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana status mental pasien?</label>
                                                <select class="form-select" name="risiko_jatuh_morse_status_mental"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Beroroentasi pada kemampuannya</option>
                                                    <option value="15">Lupa akan keterbatasannya</option>
                                                </select>
                                            </div>
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm"></span></p>
                                                <input type="hidden" name="risiko_jatuh_morse_kesimpulan"
                                                    id="risiko_jatuh_morse_kesimpulan">
                                            </div>
                                        </div>

                                        <!-- Form Risiko Skala Humpty Dumpty 3 -->
                                        <div id="skala_humptyForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Usia Anak?</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_usia_anak"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="4">Dibawah 3 tahun</option>
                                                    <option value="3">3-7 tahun</option>
                                                    <option value="2">7-13 tahun</option>
                                                    <option value="1">Diatas 13 tahun</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis kelamin</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_jenis_kelamin"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="2">Laki-laki</option>
                                                    <option value="1">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Diagnosis</label>
                                                <select class="form-select" name="risiko_jatuh_pediatrik_diagnosis"
                                                    onchange="updateConclusion('humpty')">
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
                                                <select class="form-select"
                                                    name="risiko_jatuh_pediatrik_gangguan_kognitif"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3">Tidak menyadari keterbatasan dirinya</option>
                                                    <option value="2">Lupa akan adanya keterbatasan</option>
                                                    <option value="1">Orientasi baik terhadap dari sendiri</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Faktor Lingkungan</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_pediatrik_faktor_lingkungan"
                                                    onchange="updateConclusion('humpty')">
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
                                                <select class="form-select" name="risiko_jatuh_pediatrik_pembedahan"
                                                    onchange="updateConclusion('humpty')">
                                                    <option value="">pilih</option>
                                                    <option value="3">Dalam 24 jam</option>
                                                    <option value="2">Dalam 48 jam</option>
                                                    <option value="1">> 48 jam atau tidak menjalani
                                                        pembedahan/sedasi/anestesi</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Penggunaan Medika mentosa</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_pediatrik_penggunaan_mentosa"
                                                    onchange="updateConclusion('humpty')">
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
                                                        id="kesimpulanTextForm"></span></p>
                                                <input type="hidden" name="risiko_jatuh_pediatrik_kesimpulan"
                                                    id="risiko_jatuh_pediatrik_kesimpulan">
                                            </div>
                                        </div>

                                        <!-- Form Skala Humpty Dumpty 4 -->
                                        <div id="skala_ontarioForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify
                                                Sydney/
                                                Lansia</h5>

                                            <!-- 1. Riwayat Jatuh -->
                                            <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                    jatuh?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_jatuh_saat_masuk_rs"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="6">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki 2 kali atau apakah pasien
                                                    mengalami
                                                    jatuh dalam 2
                                                    bulan terakhir ini/ diagnosis multiple?</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_riwayat_jatuh_2_bulan"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="6">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 2. Status Mental -->
                                            <h6 class="mb-3">2. Status Mental</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien bingung? (Tidak dapat membuat
                                                    keputusan, jaga jarak
                                                    tempatnya, gangguan daya ingat)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_status_bingung"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="14">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan
                                                    waktu, tempat atau
                                                    orang)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_status_disorientasi"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="14">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami agitasi? (keresahan,
                                                    gelisah, dan
                                                    cemas)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_status_agitasi"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="14">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 3. Penglihatan -->
                                            <h6 class="mb-3">3. Penglihatan</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien memakai Kacamata? </label>
                                                <select class="form-select" name="risiko_jatuh_lansia_kacamata"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami kelainya
                                                    penglihatan/buram?</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_kelainan_penglihatan"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mempunyai glukoma/ katarak/
                                                    degenerasi
                                                    makula?</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_glukoma"
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
                                                    inkontinensia, noktura)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_perubahan_berkemih"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur) -->
                                            <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                                tempat tidur)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                                <select class="form-select" name="risiko_jatuh_lansia_transfer_mandiri"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                    pengawasan</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_transfer_bantuan_sedikit"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_transfer_bantuan_nyata"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                    total</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_transfer_bantuan_total"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="3">Ya</option>
                                                    <option value="0">Tidak</option>
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
                                                    <option value="0">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                                    fisik)</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_mobilitas_bantuan_1_orang"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Menggunakan kusi roda</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_mobilitas_kursi_roda"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Imobilisasi</label>
                                                <select class="form-select"
                                                    name="risiko_jatuh_lansia_mobilitas_imobilisasi"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="3">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm"></span></p>
                                                <input type="hidden" name="risiko_jatuh_lansia_kesimpulan"
                                                    id="risiko_jatuh_lansia_kesimpulan">
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
                                            <input type="hidden" name="intervensi_risiko_jatuh_json"
                                                id="intervensi_risiko_jatuh_json" value="[]">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="decubitus">
                                        <h5 class="section-title">9. Risiko dekubitus</h5>
                                        <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>

                                        <div class="form-group mb-4">
                                            <select class="form-select" id="skalaRisikoDekubitus"
                                                name="jenis_skala_dekubitus">
                                                <option value="" selected disabled>--Pilih Skala--</option>
                                                <option value="norton">Skala Norton</option>
                                                <option value="braden">Skala Braden</option>
                                            </select>
                                        </div>

                                        <!-- Form Skala Norton -->
                                        <div id="formNorton" class="decubitus-form" style="display: none;">
                                            <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                            <div class="mb-4">
                                                <label class="form-label">Kondisi Fisik</label>
                                                <select class="form-select bg-light" name="kondisi_fisik">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="4">Baik</option>
                                                    <option value="3">Sedang</option>
                                                    <option value="2">Buruk</option>
                                                    <option value="1">Sangat Buruk</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Kondisi mental</label>
                                                <select class="form-select bg-light" name="kondisi_mental">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="4">Sadar</option>
                                                    <option value="3">Apatis</option>
                                                    <option value="2">Bingung</option>
                                                    <option value="1">Stupor</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Aktivitas</label>
                                                <select class="form-select bg-light" name="norton_aktivitas">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="4">Aktif</option>
                                                    <option value="3">Jalan dengan bantuan</option>
                                                    <option value="2">Terbatas di kursi</option>
                                                    <option value="1">Terbatas di tempat tidur</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Mobilitas</label>
                                                <select class="form-select bg-light" name="norton_mobilitas">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="4">Bebas bergerak</option>
                                                    <option value="3">Agak terbatas</option>
                                                    <option value="2">Sangat terbatas</option>
                                                    <option value="1">Tidak dapat bergerak</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Inkontinensia</label>
                                                <select class="form-select bg-light" name="inkontinensia">
                                                    <option value="" selected disabled>--Pilih--</option>
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
                                            <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Braden</h6>
                                            <div class="mb-4">
                                                <label class="form-label">Persepsi Sensori</label>
                                                <select class="form-select bg-light" name="persepsi_sensori">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="1">Keterbatasan Penuh</option>
                                                    <option value="2">Sangat Terbatas</option>
                                                    <option value="3">Keterbatasan Ringan</option>
                                                    <option value="4">Tidak Ada Gangguan</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Kelembapan</label>
                                                <select class="form-select bg-light" name="kelembapan">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="1">Selalu Lembap</option>
                                                    <option value="2">Umumnya Lembap</option>
                                                    <option value="3">Kadang-Kadang Lembap</option>
                                                    <option value="4">Jarang Lembap</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Aktivitas</label>
                                                <select class="form-select bg-light" name="braden_aktivitas">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="1">Total di Tempat Tidur</option>
                                                    <option value="2">Dapat Duduk</option>
                                                    <option value="3">Berjalan Kadang-kadang</option>
                                                    <option value="4">Dapat Berjalan-jalan</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Mobilitas</label>
                                                <select class="form-select bg-light" name="braden_mobilitas">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="1">Tidak Mampu Bergerak Sama sekali</option>
                                                    <option value="2">Sangat Terbatas</option>
                                                    <option value="3">Tidak Ada Masalah</option>
                                                    <option value="4">Tanpa Keterbatasan</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Nutrisi</label>
                                                <select class="form-select bg-light" name="nutrisi">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="1">Sangat Buruk</option>
                                                    <option value="2">Kurang Menucukup</option>
                                                    <option value="3">Mencukupi</option>
                                                    <option value="4">Sangat Baik</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Pergesekan dan Pergeseran</label>
                                                <select class="form-select bg-light" name="pergesekan">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="1">Bermasalah</option>
                                                    <option value="2">Potensial Bermasalah</option>
                                                    <option value="3">Keterbatasan Ringan</option>
                                                </select>
                                            </div>

                                            <div class="mt-4">
                                                <div class="d-flex gap-2">
                                                    <span class="fw-bold">Kesimpulan :</span>
                                                    <div id="kesimpulanNorton"
                                                        class="alert alert-success mb-0 flex-grow-1">
                                                        Kesimpulan Skala Braden
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="section-separator" id="status_gizi">
                                        <h5 class="section-title">10. Status Gizi</h5>
                                        <div class="form-group mb-4">
                                            <select class="form-select" name="gizi_jenis" id="nutritionAssessment">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Malnutrition Screening Tool (MST)</option>
                                                <option value="2">The Mini Nutritional Assessment (MNA)</option>
                                                <option value="3">Strong Kids (1 bln - 18 Tahun)</option>
                                                <option value="5">Tidak Dapat Dinilai</option>
                                            </select>
                                        </div>

                                        <!-- MST Form -->
                                        <div id="mst" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak
                                                    diinginkan dalam 6 bulan
                                                    terakhir?</label>
                                                <select class="form-select" name="gizi_mst_penurunan_bb">
                                                    <option value="">pilih</option>
                                                    <option value="0">Tidak ada penurunan Berat Badan (BB)</option>
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
                                                <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu
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
                                                <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko malnutrisi
                                                </div>
                                                <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi</div>
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
                                                    Apakah pasien mengalami penurunan asupan makanan selama 3 bulan terakhir
                                                    karena hilang selera makan, masalah pencernaan, kesulitan mengunyah atau
                                                    menelan?
                                                </label>
                                                <select class="form-select" name="gizi_mna_penurunan_asupan_3_bulan">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0">Mengalami penurunan asupan makanan yang parah
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
                                                    <option value="0">Hanya di tempat tidur atau kursi roda</option>
                                                    <option value="1">Dapat turun dari tempat tidur tapi tidak dapat
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
                                                    <option value="2">Tidak mengalami masalah neuropsikologi</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                                <input type="number" name="gizi_mna_berat_badan" class="form-control"
                                                    id="mnaWeight" min="1" step="0.1"
                                                    placeholder="Masukkan berat badan dalam Kg">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Berapa Tinggi Badan (TB) pasien? (cm)</label>
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
                                                <label class="form-label">Apakah terdapat penurunan BB selama satu bulan
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
                                                <label class="form-label">Apakah salah satu dari hal berikut ini ada? <br>
                                                    - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari)
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
                                                <div class="alert alert-warning">Kesimpulan: 1-3 (Beresiko sedang)</div>
                                                <div class="alert alert-success">Kesimpulan: 4-5 (Beresiko Tinggi)</div>
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
                                                <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan
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
                                            <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                                tempat tidur)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
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
                                                <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                                <select class="form-select" name="gizi_nrs_transfer_bantuan_2_orang"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
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

                                    <div class="section-separator" id="status-fungsional">
                                        <h5 class="section-title">11. Status Fungsional</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Pilih jenis Skala Pengkajian Aktivitas Harian (ADL) sesuai kondisi pasien</label>
                                            <select class="form-select" name="skala_fungsional" id="skala_fungsional">
                                                <option value="" selected disabled>Pilih Skala Fungsional</option>
                                                <option value="Pengkajian Aktivitas">Pengkajian Aktivitas Harian</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nilai Skala ADL</label>
                                            <input type="text" class="form-control" id="adl_total" name="adl_total" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesimpulan Fungsional</label>
                                            <div id="adl_kesimpulan" class="alert alert-info">
                                                Pilih skala aktivitas harian terlebih dahulu
                                            </div>
                                        </div>
                                        <!-- Hidden fields untuk menyimpan data ADL -->
                                        <input type="hidden" id="adl_jenis_skala" name="adl_jenis_skala" value="">
                                        <input type="hidden" id="adl_makan" name="adl_makan" value="">
                                        <input type="hidden" id="adl_makan_value" name="adl_makan_value" value="">
                                        <input type="hidden" id="adl_berjalan" name="adl_berjalan" value="">
                                        <input type="hidden" id="adl_berjalan_value" name="adl_berjalan_value" value="">
                                        <input type="hidden" id="adl_mandi" name="adl_mandi" value="">
                                        <input type="hidden" id="adl_mandi_value" name="adl_mandi_value" value="">
                                        <input type="hidden" id="adl_kesimpulan_value" name="adl_kesimpulan_value" value="">
                                    </div>

                                    <div class="section-separator" id="kebutuhan-edukasi">
                                        <h5 class="section-title">12. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran
                                        </h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Gaya Bicara</label>
                                            <select class="form-select" name="gaya_bicara">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="normal">Normal</option>
                                                <option value="lambat">Lambat</option>
                                                <option value="cepat">Cepat</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bahasa Sehari-Hari</label>
                                            <select class="form-select" name="bahasa_sehari_hari">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="Bahasa Indoneisa" selected>Bahasa Indonesia</option>
                                                <option value="Aceh">Aceh</option>
                                                <option value="Batak">Batak</option>
                                                <option value="Minangkabau">Minangkabau</option>
                                                <option value="Melayu">Melayu</option>
                                                <option value="Sunda">Sunda</option>
                                                <option value="Jawa">Jawa</option>
                                                <option value="Madura">Madura</option>
                                                <option value="Bali">Bali</option>
                                                <option value="Sasak">Sasak</option>
                                                <option value="Banjar">Banjar</option>
                                                <option value="Bugis">Bugis</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Perlu Penerjemah</label>
                                            <select class="form-select" name="perlu_penerjemah">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Hambatan Komunikasi</label>
                                            <select class="form-select" name="hambatan_komunikasi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="tidak_ada">Tidak Ada</option>
                                                <option value="pendengaran">Gangguan Pendengaran</option>
                                                <option value="bicara">Gangguan Bicara</option>
                                                <option value="bahasa">Perbedaan Bahasa</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Media Disukai</label>
                                            <select class="form-select" name="media_disukai">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="cetak">Media Cetak</option>
                                                <option value="video">Video</option>
                                                <option value="diskusi">Diskusi Langsung</option>
                                                <option value="demonstrasi">Demonstrasi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tingkat Pendidikan</label>
                                            <select class="form-select" name="tingkat_pendidikan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="SD">SD</option>
                                                <option value="SMP">SMP</option>
                                                <option value="SMA">SMA</option>
                                                <option value="Diploma">Diploma</option>
                                                <option value="Sarjana">Sarjana</option>
                                                <option value="Tidak Sekolah">Tidak Sekolah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="discharge-planning">
                                        <h5 class="section-title">13. Disharge Planning</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Lokasi nyeri">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Usia lanjut</label>
                                            <select class="form-select" name="usia_lanjut">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Hambatan mobilisasi</label>
                                            <select class="form-select" name="hambatan_mobilisasi">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                            <select class="form-select" name="penggunaan_media_berkelanjutan">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                                harian</label>
                                            <select class="form-select" name="ketergantungan_aktivitas">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
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
                                        <h5 class="fw-semibold mb-4">14. Diagnosis</h5>

                                        <!-- Diagnosis Banding -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis banding yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-banding-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Banding">
                                                <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Diagnosis items will be added here dynamically -->
                                            </div>
                                            
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="diagnosis_banding" name="diagnosis_banding" value="[]">
                                        </div>

                                        <!-- Diagnosis Kerja -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis kerja yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-kerja-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Kerja">
                                                <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Diagnosis items will be added here dynamically -->
                                            </div>
                                            
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja" value="[]">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="implemetasi" style="margin-bottom: 2rem;">
                                        <h5 class="fw-semibold mb-4">15. Implementasi</h5>

                                        <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan Pengobatan</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                                rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                        </div>

                                        <!-- Observasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Observasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="observasi-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Observasi">
                                                <span class="input-group-text bg-white" id="add-observasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="observasi-list" class="list-group mb-2 bg-light">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="observasi" name="observasi" value="[]">
                                        </div>

                                        <!-- Terapeutik Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Terapeutik</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="terapeutik-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Terapeutik">
                                                <span class="input-group-text bg-white" id="add-terapeutik">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="terapeutik-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="terapeutik" name="terapeutik" value="[]">
                                        </div>

                                        <!-- Edukasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Edukasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="edukasi-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Edukasi">
                                                <span class="input-group-text bg-white" id="add-edukasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="edukasi-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="edukasi" name="edukasi" value="[]">
                                        </div>

                                        <!-- Kolaborasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Kolaborasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="kolaborasi-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Kolaborasi">
                                                <span class="input-group-text bg-white" id="add-kolaborasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="kolaborasi-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="kolaborasi" name="kolaborasi" value="[]">
                                        </div>

                                        <!-- Kolaborasi Section -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold">Prognosis</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan
                                                Prognosis yang tidak ditemukan.</small>
                                                <!-- sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis -->
                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="rencana-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Rencana Penatalaksanaan">
                                                <span class="input-group-text bg-white" id="add-rencana">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="rencana-list" class="list-group mb-3">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="rencana_penatalaksanaan" name="prognosis" value="[]">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="evaluasi">
                                        <h5 class="section-title">16. Evaluasi</h5>

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
                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.modal-create-alergi')
                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.modal-create-downscore')
                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.modal-skalanyeri')
                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.modal-skala-adl')
                            @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-perinatology.modal-intervensirisikojatuh')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
