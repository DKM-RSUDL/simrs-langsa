<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form
                action="{{ route('rawat-jalan.asesmen-keperawatan.store', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ]) }}"
                method="POST">
                @csrf

                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">
                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Asesmen Keperawatan Rawat Jalan</h4>
                                <p>
                                    Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                </p>
                            </div>

                            {{-- FORM ASESMEN AWAL KEPERATAWAN --}}

                            <div class="px-3">
                                <div>
                                    <div class="section-separator d-flex align-items-center flex-nowrap gap-4">
                                        <div class="col">
                                            <div>
                                                <label class="form-label">Tanggal Asesmen</label>
                                                <input type="date" name="tgl_masuk" id="tgl_asesmen_keperawatan"
                                                    class="form-control" value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <label class="form-label">Jam Asesmen</label>
                                                <input type="time" name="tgl_masuk" id="jam_asesmen_keperawatan"
                                                    class="form-control" value="{{ date('H:i') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="section-separator" id="riwayat-kesehatan">
                                        <h5 class="section-title">1. Riwayat Kesehatan</h5>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Keluhan utama</label>
                                            <textarea class="form-control" name="keluhan_utama" rows="3"></textarea>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                        <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="createAlergiTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="20%">Jenis Alergi</th>
                                                        <th width="25%">Alergen</th>
                                                        <th width="25%">Reaksi</th>
                                                        <th width="20%">Tingkat Keparahan</th>
                                                        <th width="10%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="no-alergi-row">
                                                        <td colspan="5" class="text-center text-muted">Tidak ada data
                                                            alergi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        @push('modals')
                                            @include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.modal-create-alergi')
                                        @endpush

                                    </div>

                                    <div class="section-separator" id="pemeriksaan-fisik">
                                        <h5 class="section-title">2. Pemeriksaan Fisik</h5>
                                        <h5 class="section-title">Tanda-Tanda Vital</h5>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Tekanan Darah</label>
                                            <div class="d-flex w-100 align-items-center gap-2">
                                                <input class="form-control" placeholder="Sistolik" type="number"
                                                    name="sistolik">
                                                <input class="form-control" placeholder="Diastolik" type="number"
                                                    name="diastolik">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Nadi</label>
                                            <input class="form-control" type="number" name="nadi" />
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">RR</label>
                                            <input class="form-control" type="number" name="nafas_per_menit" />
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Suhu</label>
                                            <input class="form-control" type="text" name="suhu" />
                                        </div>

                                        <h5 class="section-title mt-5">Status Nyeri</h5>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start gap-4">
                                                    <div class="d-flex align-items-center gap-3" style="min-width: 350px;">
                                                        <input type="number"
                                                            class="form-control flex-grow-1 @error('skala_nyeri') is-invalid @enderror"
                                                            name="skala_nyeri" style="width: 100px;"
                                                            value="{{ old('skala_nyeri', 0) }}" min="0"
                                                            max="10">
                                                        @error('skala_nyeri')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                        <button type="button" class="btn btn-sm btn-success"
                                                            id="skalaNyeriBtn">
                                                            Tidak Nyeri
                                                            <input type="number" class="form-control flex-grow-1"
                                                                name="skala_nyeri_nilai" style="width: 100px;"
                                                                value="0" min="0" max="10">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <!-- Button Controls -->
                                                <div class="btn-group mb-3">
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        data-scale="numeric">
                                                        A. Numeric Rating Pain Scale
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-primary"
                                                        data-scale="wong-baker">
                                                        B. Wong Baker Faces Pain Scale
                                                    </button>
                                                </div>

                                                <!-- Pain Scale Images -->
                                                <div id="wongBakerScale" class="pain-scale-image flex-grow-1"
                                                    style="display: none;">
                                                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                        alt="Wong Baker Pain Scale" style="width: 450px; height: auto;">
                                                </div>

                                                <div id="numericScale" class="pain-scale-image flex-grow-1"
                                                    style="display: none;">
                                                    <img src="{{ asset('assets/img/asesmen/numerik.png') }}"
                                                        alt="Numeric Pain Scale" style="width: 450px; height: auto;">
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
                                                    <select class="form-select" name="skala_nyeri_pemberat_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($faktorPemberat as $pemberat)
                                                            <option value="{{ $pemberat->id }}">{{ $pemberat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Kualitas</label>
                                                    <select class="form-select" name="skala_nyeri_kualitas_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($kualitasNyeri as $kualitas)
                                                            <option value="{{ $kualitas->id }}">{{ $kualitas->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Menjalar</label>
                                                    <select class="form-select" name="skala_nyeri_menjalar_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($menjalar as $menj)
                                                            <option value="{{ $menj->id }}">{{ $menj->name }}
                                                            </option>
                                                        @endforeach
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
                                                    <select class="form-select" name="skala_nyeri_peringan_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($faktorPeringan as $peringan)
                                                            <option value="{{ $peringan->id }}">{{ $peringan->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Frekuensi</label>
                                                    <select class="form-select" name="skala_nyeri_frekuensi_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($frekuensiNyeri as $frekuensi)
                                                            <option value="{{ $frekuensi->id }}">{{ $frekuensi->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Jenis</label>
                                                    <select class="form-select" name="skala_nyeri_jenis_id">
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($jenisNyeri as $jenis)
                                                            <option value="{{ $jenis->id }}">{{ $jenis->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-psikologi">
                                        <h5 class="section-title">3. Status Psikologis</h5>

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
                                            <label style="min-width: 300px;">Lainnya</label>
                                            <input class="form-control" name="psikologis_lainnya" />
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Permasalahan yang dikonsulkan</label>
                                            <textarea class="form-control" name="psikologis_permasalahan_yang_dikonsulkan" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-sosial-budaya">
                                        <h5 class="section-title">4. Status Sosial Budaya</h5>

                                        <div class="form-group mb-3">
                                            <label style="min-width: 300px;">Pekerjaan</label>
                                            <select class="form-select select2" name="sosial_budaya_pekerjaan"
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
                                            <label style="min-width: 300px;">Kesulitan Memenuhi Kebutuhan Dasar</label>
                                            <textarea class="form-control" name="sosial_budaya_kesulitan_memenuhi_kebutuhan_dasar" rows="3"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Hubungan dengan Anggota Keluarga</label>
                                            <select class="form-select"
                                                name="sosial_budaya_hubungan_dengan_anggota_keluarga">
                                                <option value="">--Pilih--</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Tidak Baik">Tidak Baik</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Suku</label>
                                            <input type="text" class="form-control" name="sosial_budaya_suku"
                                                id="sosial_budaya_suku">
                                        </div>


                                        <div class="form-group">
                                            <label style="min-width: 300px;">Tingkat pendidikan</label>
                                            <select class="form-select select2" name="sosial_budaya_status_pendidikan">
                                                <option value="">--Pilih--</option>
                                                @foreach ($pendidikan as $didikan)
                                                    <option value="{{ $didikan->kd_pendidikan }}">
                                                        {{ $didikan->pendidikan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Budaya/Adat istiadat yang dipercaya
                                                pasien</label>
                                            <textarea class="form-control" name="sosial_budaya_budaya_atau_yang_dipercaya" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-spiritual">
                                        <h5 class="section-title">5. Status Spiritual</h5>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Agama/Kepercayaan</label>
                                            <select class="form-select" name="spiritual_agama">
                                                <option value="">--Pilih--</option>
                                                @foreach ($agama as $agam)
                                                    <option value="{{ $agam->kd_agama }}">{{ $agam->agama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Nilai Nilai Spritiual Pasien</label>
                                            <textarea class="form-control" name="spiritual_nilai" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="risiko-jatuh">
                                        <h5 class="section-title">6. Risiko Jatuh</h5>

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
                                                <label class="form-label">Apakah pasien didiagnosis sebagai pasien
                                                    dengan
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
                                                <label class="form-label">Pasien memiliki diagnosis
                                                    skunder?</label>
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

                                    <div class="section-separator" id="skrining-batuk">
                                        <h5 class="section-title">7. Skrining Batuk</h5>

                                        <div class="form-group mb-3">
                                            <label class="me-3" style="min-width:300px;">Kejadian batuk</label>
                                            <div class="d-flex flex-column flex-md-row gap-3 align-items-center">
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_kejadian" value="1" id="batuk_ada">
                                                <label style="min-width:50px;" for="batuk_ada">Ada</label>
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_kejadian" value="0" id="batuk_tidak">
                                                <label style="min-width:50px;" for="batuk_tidak">Tidak</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" id="skrining_batuk_jika_tidak_ada">
                                            <label class="me-3" style="min-width:300px;">Jika ada, > 2 minggu</label>
                                            <div class="d-flex flex-column flex-md-row gap-3 align-items-center">
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_jika_tidak_ada" value="1"
                                                    id="batuk_lama_ya">
                                                <label style="min-width:50px;" for="batuk_lama_ya">Ya</label>
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_jika_tidak_ada" value="0"
                                                    id="batuk_lama_tidak">
                                                <label style="min-width:50px;" for="batuk_lama_tidak">Tidak</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="me-3" style="min-width:300px;">Penurunan BB</label>
                                            <div class="d-flex flex-column flex-md-row gap-3 align-items-center">
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_penurunan_bb" value="1"
                                                    id="penurunan_bb_ada">
                                                <label style="min-width:50px;" for="penurunan_bb_ada">Ada</label>
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_penurunan_bb" value="0"
                                                    id="penurunan_bb_tidak">
                                                <label style="min-width:50px;" for="penurunan_bb_tidak">Tidak</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="me-3" style="min-width:300px;">Keringat malam</label>
                                            <div class="d-flex flex-column flex-md-row gap-3 align-items-center">
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_keringat_malam" value="1"
                                                    id="keringat_malam_ada">
                                                <label style="min-width:50px;" for="keringat_malam_ada">Ada</label>
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_keringat_malam" value="0"
                                                    id="keringat_malam_tidak">
                                                <label style="min-width:50px;" for="keringat_malam_tidak">Tidak</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="me-3" style="min-width:300px;">Sesak nafas</label>
                                            <div class="d-flex flex-column flex-md-row gap-3 align-items-center">
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_sesak_nafas" value="1"
                                                    id="sesak_nafas_ada">
                                                <label style="min-width:50px;" for="sesak_nafas_ada">Ada</label>
                                                <input type="radio" class="form-check-input"
                                                    name="skrining_batuk_sesak_nafas" value="0"
                                                    id="sesak_nafas_tidak">
                                                <label style="min-width:50px;" for="sesak_nafas_tidak">Tidak</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="me-3" style="min-width:300px;">Keputusan</label>
                                            <select name="skrining_batuk_keputusan" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="sesuai_antrian">Sesuai antrian</option>
                                                <option value="poliklinik">Poliklinik disegerakan</option>
                                                <option value="igd">IGD</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-gizi">
                                        <h5 class="section-title">8. Status Gizi</h5>
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
                                            <input type="hidden" name="gizi_mst_kesimpulan" id="gizi_mst_kesimpulan">
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
                                            <input type="number" name="gizi_mna_tinggi_badan" class="form-control"
                                                id="mnaHeight" min="1" step="0.1"
                                                placeholder="Masukkan tinggi badan dalam cm">
                                        </div>

                                        <!-- IMT -->
                                        <div class="mb-3">
                                            <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                            <div class="text-muted small mb-2">
                                                <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                            </div>
                                            <input type="number" name="gizi_mna_imt" class="form-control bg-light"
                                                id="mnaBMI" readonly placeholder="IMT akan terhitung otomatis">
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
                                            <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan">
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
                                                tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1 tahun)
                                                    selama 3 bulan terakhir)</label>
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
                                            <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-fungsional">
                                        <h5 class="section-title">9. Status Fungsional</h5>
                                        <div class="form-group mb-3">
                                            <label class="me-3" style="min-width:300px;">Status</label>
                                            <div class="d-flex flex-column flex-md-row gap-3 align-items-center">
                                                <input type="radio" class="form-check-input"
                                                    name="fungsional_status" value="tidak" id="mandiri">
                                                <label style="min-width:50px;" for="mandiri">Tidak</label>
                                                <input type="radio" class="form-check-input"
                                                    name="fungsional_status" value="sebutkan" id="sebutkan">
                                                <label style="min-width:50px;" for="sebutkan">Sebutkan</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3" id="fungsional_sebutkan_field"
                                            style="display:none;">
                                            <label class="me-3" style="min-width:300px;">Sebutkan</label>
                                            <input type="text" class="form-control w-100"
                                                name="fungsional_sebutkan" id="fungsional_sebutkan"
                                                placeholder="Sebutkan status fungsional...">
                                        </div>

                                        <div class="form-group">
                                            <label for="fungsional_ketergantungan_total"
                                                style="min-width: 300px;">Ketergantungan Total</label>
                                            <input type="text" class="form-control"
                                                name="fungsional_ketergantungan_total"
                                                id="fungsional_ketergantungan_total">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="kebutuhan-edukasi">
                                        <h5 class="section-title">10. Edukasi/Pendidikan Dan Pengajaran</h5>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Gaya bicara</label>
                                            <select class="form-select" name="kebutuhan_edukasi_gaya_bicara">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Normal</option>
                                                <option value="1">Tidak Normal</option>
                                                <option value="2">Belum Bisa Bicara</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Bahasa sehari-hari</label>
                                            <select class="form-select" name="kebutuhan_edukasi_bahasa_sehari_hari">
                                                <option value="">--Pilih--</option>
                                                <option value="Indonesia">Indonesia</option>
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
                                            <label style="min-width: 300px;">Perlu penerjemah</label>
                                            <select class="form-select" name="kebutuhan_edukasi_perlu_penerjemah">
                                                <option value="">--Pilih--</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Hambatan komunikasi</label>
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
                                            <label style="min-width: 300px;">Media belajar yang disukai</label>
                                            <select class="form-select" name="kebutuhan_edukasi_media_belajar">
                                                <option value="">--Pilih--</option>
                                                <option value="audio">Audio-Visual</option>
                                                <option value="brosur">Brosur</option>
                                                <option value="diskusi">Diskusi</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Tingkat pendidikan</label>
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
                                            <label style="min-width: 300px;">Edukasi yang dibutuhkan</label>
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
                                            <label style="min-width: 300px;">Lainnya</label>
                                            <textarea class="form-control" name="kebutuhan_edukasi_keterangan_lain" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="rencana-pemulangan">
                                        <h5 class="section-title">11. Perencanaan Pemulangan Pasien/Discharge Planning
                                        </h5>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Diagnosis medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                id="diagnosis_medis">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Usia lanjut</label>
                                            <select class="form-select discharge-select" name="usia_lanjut"
                                                id="usia_lanjut">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Hambatan mobilisasi</label>
                                            <select class="form-select discharge-select" name="hambatan_mobilisasi"
                                                id="hambatan_mobilisasi">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Membutuhkan pelayanan medis
                                                berkelanjutan</label>
                                            <select class="form-select discharge-select" name="layanan_medis_lanjutan"
                                                id="pelayanan_medis_berkelanjutan">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Ketergantungan dengan orang lain dalam
                                                aktivitas harian</label>
                                            <select class="form-select discharge-select"
                                                name="ketergantungan_orang_lain" id="ketergantungan_orang_lain">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Rencana Pulang</label>
                                            <input type="date" name="rencana_pulang" class="form-control"
                                                id="rencana_pulang_input">
                                        </div>

                                        <div class="form-group mt-4">
                                            <label style="min-width: 300px;">KESIMPULAN</label>
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
                                            <input type="hidden" name="kesimpulan" id="kesimpulan_value">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="keperawatan">
                                        <h5 class="section-title">12. Daftar Masalah dan Rencana Keperawatan</h5>
                                        <div class="form-group mt-4">
                                            <label style="min-width: 300px;">Masalah Keperawatan</label>
                                            <div class="w-100 d-flex flex-column">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="diagnosis-input" class="form-control"
                                                        placeholder="Masukkan masalah keperawatan">
                                                    <span class="input-group-text bg-white" id="add-diagnosis"
                                                        style="cursor: pointer;">
                                                        <i class="bi bi-plus-circle text-primary"></i>
                                                    </span>
                                                </div>

                                                <!-- List Diagnosis -->
                                                <div id="diagnosis-list" class="diagnosis-list rounded w-100">
                                                    <p class="text-danger text-small" id="no-diagnosis">Belum
                                                        ada
                                                        diagnosis
                                                        ditambahkan</p>
                                                </div>

                                                <!-- Hidden input untuk dikirim ke backend -->
                                                <input type="hidden" id="keperawatan_masalah"
                                                    name="keperawatan_masalah" value="[]">
                                            </div>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label style="min-width: 300px;">Rencana Keperawatan</label>
                                            <div class="w-100 d-flex flex-column">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="rencanaKeperawatan-input"
                                                        class="form-control" placeholder="Masukkan rencana keperawatan">
                                                    <span class="input-group-text bg-white" id="add-rencanaKeperawatan"
                                                        style="cursor: pointer;">
                                                        <i class="bi bi-plus-circle text-primary"></i>
                                                    </span>
                                                </div>

                                                <!-- List Diagnosis -->
                                                <div id="rencanaKeperawatan-list"
                                                    class="rencanaKeperawatan-list rounded w-100">
                                                    <p class="text-danger text-small" id="no-rencanaKeperawatan">Belum
                                                        ada
                                                        rencanaKeperawatan
                                                        ditambahkan</p>
                                                </div>

                                                <!-- Hidden input untuk dikirim ke backend -->
                                                <input type="hidden" id="keperawatan_rencana"
                                                    name="keperawatan_rencana" value="[]">
                                            </div>
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
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const batukAda = document.getElementById('batuk_ada');
            const batukTidak = document.getElementById('batuk_tidak');
            const batukLamaDiv = document.getElementById('skrining_batuk_jika_tidak_ada');

            // Kondisi awal: cek radio yang terpilih
            if (batukAda.checked) {
                batukLamaDiv.style.display = 'flex';
            } else {
                batukLamaDiv.style.display = 'none';
            }

            batukAda.addEventListener('change', function() {
                if (batukAda.checked) {
                    batukLamaDiv.style.display = 'flex';
                }
            });

            batukTidak.addEventListener('change', function() {
                if (batukTidak.checked) {
                    batukLamaDiv.style.display = 'none';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var sebutkanField = document.getElementById('fungsional_sebutkan_field');
            var radios = document.getElementsByName('fungsional_status');
            radios.forEach(function(radio) {
                radio.addEventListener('change', function() {
                    if (this.value === 'sebutkan') {
                        sebutkanField.style.display = '';
                    } else {
                        sebutkanField.style.display = 'none';
                    }
                });
            });
            // Hide on load if not selected
            var checked = Array.from(radios).find(r => r.checked);
            if (!checked || checked.value !== 'sebutkan') {
                sebutkanField.style.display = 'none';
            }
        });

        // Masalah Keperawatan
        // Masalah Keperawatan
        let diagnosisData = [];
        const masalahInput = document.getElementById("diagnosis-input");
        const masalahAddBtn = document.getElementById("add-diagnosis");
        const masalahList = document.getElementById("diagnosis-list");
        const masalahHiddenInput = document.getElementById("keperawatan_masalah");
        const masalahNoDiagnosis = document.getElementById("no-diagnosis");

        function renderMasalahKeperawatan() {
            masalahList.innerHTML = "";
            if (diagnosisData.length === 0) {
                masalahList.appendChild(masalahNoDiagnosis);
                masalahNoDiagnosis.style.display = "block";
                return;
            }
            masalahNoDiagnosis.style.display = "none";
            diagnosisData.forEach((diag, index) => {
                const item = document.createElement("div");
                item.className =
                    "d-flex justify-content-between align-items-center border rounded px-3 py-2 mb-2 bg-white";
                item.innerHTML = `
                        <span>${diag}</span>
                        <button type="button" class="btn btn-sm btn-danger" data-index="${index}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                masalahList.appendChild(item);
            });
            masalahList.querySelectorAll("button").forEach(btn => {
                btn.addEventListener("click", function() {
                    const idx = this.getAttribute("data-index");
                    diagnosisData.splice(idx, 1);
                    updateMasalahHiddenInput();
                    renderMasalahKeperawatan();
                });
            });
        }

        function updateMasalahHiddenInput() {
            masalahHiddenInput.value = JSON.stringify(diagnosisData);
        }

        masalahAddBtn.addEventListener("click", function() {
            const value = masalahInput.value.trim();
            if (value !== "") {
                diagnosisData.push(value);
                updateMasalahHiddenInput();
                renderMasalahKeperawatan();
                masalahInput.value = "";
            }
        });

        masalahInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                masalahAddBtn.click();
            }
        });

        // Rencana Keperawatan
        let rencanaKeperawatanData = [];
        const rencanaInput = document.getElementById("rencanaKeperawatan-input");
        const rencanaAddBtn = document.getElementById("add-rencanaKeperawatan");
        const rencanaList = document.getElementById("rencanaKeperawatan-list");
        const rencanaHiddenInput = document.getElementById("keperawatan_rencana");
        const rencanaNoDiagnosis = document.getElementById("no-rencanaKeperawatan");

        function renderRencanaKeperawatan() {
            rencanaList.innerHTML = "";
            if (rencanaKeperawatanData.length === 0) {
                rencanaList.appendChild(rencanaNoDiagnosis);
                rencanaNoDiagnosis.style.display = "block";
                return;
            }
            rencanaNoDiagnosis.style.display = "none";
            rencanaKeperawatanData.forEach((diag, index) => {
                const item = document.createElement("div");
                item.className =
                    "d-flex justify-content-between align-items-center border rounded px-3 py-2 mb-2 bg-white";
                item.innerHTML = `
                        <span>${diag}</span>
                        <button type="button" class="btn btn-sm btn-danger" data-index="${index}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                rencanaList.appendChild(item);
            });
            rencanaList.querySelectorAll("button").forEach(btn => {
                btn.addEventListener("click", function() {
                    const idx = this.getAttribute("data-index");
                    rencanaKeperawatanData.splice(idx, 1);
                    updateRencanaHiddenInput();
                    renderRencanaKeperawatan();
                });
            });
        }

        function updateRencanaHiddenInput() {
            rencanaHiddenInput.value = JSON.stringify(rencanaKeperawatanData);
        }

        rencanaAddBtn.addEventListener("click", function() {
            const value = rencanaInput.value.trim();
            if (value !== "") {
                rencanaKeperawatanData.push(value);
                updateRencanaHiddenInput();
                renderRencanaKeperawatan();
                rencanaInput.value = "";
            }
        });

        rencanaInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
                rencanaAddBtn.click();
            }
        });
        // Discharge Planning - Rencana Pulang Logic
        // This logic will be handled by the include.blade.php file
        // with the discharge-select class listeners
    </script>
@endpush

@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.modal-intervensirisikojatuh')
@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.include')
