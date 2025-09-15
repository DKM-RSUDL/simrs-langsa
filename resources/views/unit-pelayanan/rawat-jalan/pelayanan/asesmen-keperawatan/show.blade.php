<!-- edit -->
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
            <form>
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}" disabled>
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
                                                    class="form-control"
                                                    value="{{ old('tgl_masuk', date('Y-m-d', strtotime($asesmen->waktu_asesmen))) }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <label class="form-label">Jam Asesmen</label>
                                                <input type="time" name="tgl_masuk" id="jam_asesmen_keperawatan"
                                                    class="form-control"
                                                    value="{{ old('jam_asesmen', date('H:i', strtotime($asesmen->waktu_asesmen))) }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="section-separator" id="riwayat-kesehatan">
                                        <h5 class="section-title">1. Riwayat Kesehatan</h5>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Keluhan utama</label>
                                            <textarea class="form-control" name="keluhan_utama" rows="3" disabled>{{ old('keluhan_utama', $asesmen->asesmenKepRajal->keluhan_utama ?? '') }}</textarea>
                                        </div>
                                        <input type="hidden" name="alergis" id="alergisInput" value="[]" disabled>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="createAlergiTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="20%">Jenis Alergi</th>
                                                        <th width="25%">Alergen</th>
                                                        <th width="25%">Reaksi</th>
                                                        <th width="20%">Tingkat Keparahan</th>
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
                                            @include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.show-alergi')
                                        @endpush

                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">2. Pemeriksaan Fisik</h5>
                                        <h5 class="section-title">Tanda-Tanda Vital</h5>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Tekanan Darah</label>
                                            <div class="d-flex w-100 align-items-center gap-2">
                                                <input class="form-control" placeholder="Sistolik" type="number"
                                                    name="sistolik"
                                                    value="{{ old('sistolik', $asesmen->asesmenKepRajalTtv->sistolik ?? '') }}"
                                                    disabled>
                                                <input class="form-control" placeholder="Diastolik" type="number"
                                                    name="diastolik"
                                                    value="{{ old('diastolik', $asesmen->asesmenKepRajalTtv->diastolik ?? '') }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Nadi</label>
                                            <input class="form-control" type="number" name="nadi"
                                                value="{{ old('nadi', $asesmen->asesmenKepRajalTtv->nadi ?? '') }}"
                                                disabled />
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">RR</label>
                                            <input class="form-control" type="number" name="nafas_per_menit"
                                                value="{{ old('nafas_per_menit', $asesmen->asesmenKepRajalTtv->nafas_per_menit ?? '') }}"
                                                disabled />
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Suhu</label>
                                            <input class="form-control" type="number" name="suhu"
                                                value="{{ old('suhu', $asesmen->asesmenKepRajalTtv->suhu ?? '') }}"
                                                disabled />
                                        </div>

                                        <h5 class="section-title mt-5">Status Nyeri</h5>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-start gap-4">
                                                    <div class="d-flex align-items-center gap-3" style="min-width: 350px;">
                                                        <input type="number"
                                                            class="form-control flex-grow-1 @error('skala_nyeri') is-invalid @enderror"
                                                            name="skala_nyeri" style="width: 100px;"
                                                            value="{{ old('skala_nyeri', $asesmen->asesmenKepRajalSkalaNyeri->skala_nyeri ?? 0) }}"
                                                            min="0" max="10" disabled>
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
                                                                value="{{ old('skala_nyeri_nilai', $asesmen->asesmenKepRajalSkalaNyeri->skala_nyeri ?? 0) }}"
                                                                min="0" max="10" disabled>
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
                                                    <input type="text" class="form-control" name="skala_nyeri_lokasi"
                                                        value="{{ old('skala_nyeri_lokasi', $asesmen->asesmenKepRajalSkalaNyeri->skala_nyeri_lokasi ?? '') }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Pemberat</label>
                                                    <select class="form-select" name="skala_nyeri_pemberat_id" disabled>
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($faktorPemberat as $pemberat)
                                                            <option value="{{ $pemberat->id }}"
                                                                {{ old('skala_nyeri_pemberat_id', $asesmen->asesmenKepRajalSkalaNyeri->skala_nyeri_pemberat_id ?? '') == $pemberat->id ? 'selected' : '' }}>
                                                                {{ $pemberat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Menjalar</label>
                                                    <select class="form-select" name="skala_nyeri_menjalar_id" disabled>
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($menjalar as $menj)
                                                            <option value="{{ $menj->id }}"
                                                                {{ old('skala_nyeri_menjalar_id', $asesmen->asesmenKepRajalSkalaNyeri->skala_nyeri_menjalar_id ?? '') == $menj->id ? 'selected' : '' }}>
                                                                {{ $menj->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Durasi</label>
                                                    <input type="text" class="form-control" name="skala_nyeri_durasi"
                                                        value="{{ old('skala_nyeri_durasi', $asesmen->asesmenKepRajalSkalaNyeri->skala_nyeri_durasi ?? '') }}"
                                                        disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Peringan</label>
                                                    <select class="form-select" name="skala_nyeri_peringan_id" disabled>
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($faktorPeringan as $peringan)
                                                            <option value="{{ $peringan->id }}"
                                                                {{ old('skala_nyeri_peringan_id', $asesmen->asesmenKepRajalSkalaNyeri->skala_nyeri_peringan_id ?? '') == $peringan->id ? 'selected' : '' }}>
                                                                {{ $peringan->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Frekuensi</label>
                                                    <select class="form-select" name="skala_nyeri_frekuensi_id" disabled>
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($frekuensiNyeri as $frekuensi)
                                                            <option value="{{ $frekuensi->id }}"
                                                                {{ old('skala_nyeri_frekuensi_id', $asesmen->asesmenKepRajalSkalaNyeri->skala_nyeri_frekuensi_id ?? '') == $frekuensi->id ? 'selected' : '' }}>
                                                                {{ $frekuensi->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label style="min-width: 120px;">Jenis</label>
                                                    <select class="form-select" name="skala_nyeri_jenis_id" disabled>
                                                        <option value="">--Pilih--</option>
                                                        @foreach ($jenisNyeri as $jenis)
                                                            <option value="{{ $jenis->id }}"
                                                                {{ old('skala_nyeri_jenis_id', $asesmen->asesmenKepRajalSkalaNyeri->skala_nyeri_jenis_id ?? '') == $jenis->id ? 'selected' : '' }}>
                                                                {{ $jenis->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">3. Status Psikologis</h5>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Kondisi psikologis</label>
                                            <select class="form-select" name="psikologis_kondisi" disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="Tidak Ada Kelainan"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Tidak Ada Kelainan' ? 'selected' : '' }}>
                                                    Tidak Ada Kelainan</option>
                                                <option value="Cemas"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Cemas' ? 'selected' : '' }}>
                                                    Cemas</option>
                                                <option value="Takut"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Takut' ? 'selected' : '' }}>
                                                    Takut</option>
                                                <option value="Marah"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Marah' ? 'selected' : '' }}>
                                                    Marah</option>
                                                <option value="Sedih"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Sedih' ? 'selected' : '' }}>
                                                    Sedih</option>
                                                <option value="Tenang"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Tenang' ? 'selected' : '' }}>
                                                    Tenang</option>
                                                <option value="Tidak Semangat"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Tidak Semangat' ? 'selected' : '' }}>
                                                    Tidak Semangat</option>
                                                <option value="Tertekan"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Tertekan' ? 'selected' : '' }}>
                                                    Tertekan</option>
                                                <option value="Depresi"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Depresi' ? 'selected' : '' }}>
                                                    Depresi</option>
                                                <option value="Sulit Tidur"
                                                    {{ old('psikologis_kondisi', $asesmen->asesmenKepRajal->psikologis_kondisi ?? '') == 'Sulit Tidur' ? 'selected' : '' }}>
                                                    Sulit Tidur</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Lainnya</label>
                                            <input class="form-control" name="psikologis_lainnya"
                                                value="{{ old('psikologis_lainnya', $asesmen->asesmenKepRajal->psikologis_lainnya ?? '') }}"
                                                disabled />
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Permasalahan yang dikonsulkan</label>
                                            <textarea class="form-control" name="psikologis_permasalahan_yang_dikonsulkan" rows="3" disabled>{{ old('psikologis_permasalahan_yang_dikonsulkan', $asesmen->asesmenKepRajal->psikologis_permasalahan_yang_dikonsulkan ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">4. Status Sosial Budaya</h5>

                                        <div class="form-group mb-3">
                                            <label style="min-width: 300px;">Pekerjaan</label>
                                            <select class="form-select" name="sosial_budaya_pekerjaan"
                                                id="sosial_pekerjaan" disabled>
                                                <option value="">--Pilih Pekerjaan--</option>
                                                @foreach ($pekerjaan as $kerjaan)
                                                    <option value="{{ $kerjaan->kd_pekerjaan }}"
                                                        {{ old('sosial_budaya_pekerjaan', $asesmen->asesmenKepRajalSosialBudaya->pekerjaan ?? '') == $kerjaan->kd_pekerjaan ? 'selected' : '' }}>
                                                        {{ $kerjaan->pekerjaan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Kesulitan Memenuhi Kebutuhan Dasar</label>
                                            <textarea class="form-control" name="sosial_budaya_kesulitan_memenuhi_kebutuhan_dasar" rows="3" disabled>{{ old('sosial_budaya_kesulitan_memenuhi_kebutuhan_dasar', $asesmen->asesmenKepRajalSosialBudaya->kesulitan_memenuhi_kebutuhan_dasar ?? '') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Hubungan dengan Anggota Keluarga</label>
                                            <select class="form-select" disabled
                                                name="sosial_budaya_hubungan_dengan_anggota_keluarga">
                                                <option value="">--Pilih--</option>
                                                <option value="Baik"
                                                    {{ old('sosial_budaya_hubungan_dengan_anggota_keluarga', $asesmen->asesmenKepRajalSosialBudaya->hubungan_dengan_anggota_keluarga ?? '') == 'Baik' ? 'selected' : '' }}>
                                                    Baik</option>
                                                <option value="Tidak Baik"
                                                    {{ old('sosial_budaya_hubungan_dengan_anggota_keluarga', $asesmen->asesmenKepRajalSosialBudaya->hubungan_dengan_anggota_keluarga ?? '') == 'Tidak Baik' ? 'selected' : '' }}>
                                                    Tidak Baik</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Suku</label>
                                            <input type="text" class="form-control" name="sosial_budaya_suku"
                                                id="sosial_budaya_suku"
                                                value="{{ old('sosial_budaya_suku', $asesmen->asesmenKepRajalSosialBudaya->suku ?? '') }}"
                                                disabled>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Tingkat pendidikan</label>
                                            <select class="form-select" name="sosial_budaya_pendidikan" disabled>
                                                <option value="">--Pilih--</option>
                                                @foreach ($pendidikan as $didikan)
                                                    <option value="{{ $didikan->kd_pendidikan }}"
                                                        {{ old('pendidikan', $asesmen->asesmenKepRajalSosialBudaya->pendidikan ?? '') == $didikan->kd_pendidikan ? 'selected' : '' }}>
                                                        {{ $didikan->pendidikan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Budaya/Adat istiadat yang dipercaya
                                                pasien</label>
                                            <textarea class="form-control" name="sosial_budaya_budaya_atau_yang_dipercaya" rows="3" disabled>{{ old('sosial_budaya_budaya_atau_yang_dipercaya', $asesmen->asesmenKepRajalSosialBudaya->budaya_atau_yang_dipercaya ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">5. Status Spiritual</h5>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Agama/Kepercayaan</label>
                                            <select class="form-select" name="spiritual_agama" disabled>
                                                <option value="">--Pilih--</option>
                                                @foreach ($agama as $agam)
                                                    <option value="{{ $agam->kd_agama }}"
                                                        {{ old('spiritual_agama', $asesmen->asesmenKepRajal->spiritual_agama ?? '') == $agam->kd_agama ? 'selected' : '' }}>
                                                        {{ $agam->agama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Nilai Nilai Spritiual Pasien</label>
                                            <textarea class="form-control" name="spiritual_nilai" rows="3" disabled>{{ old('spiritual_nilai', $asesmen->asesmenKepRajal->spiritual_nilai ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">6. Risiko Jatuh</h5>
                                        <div class="mb-4">
                                            <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan
                                                kondisi pasien:</label>
                                            <select class="form-select" id="risikoJatuhSkala" name="resiko_jatuh_jenis"
                                                onchange="showForm(this.value)" disabled>
                                                <option value="">--Pilih Skala--</option>
                                                <option value="1"
                                                    {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepRajalRisikoJatuh->resiko_jatuh_jenis ?? '') == '1' ? 'selected' : '' }}>
                                                    Skala Umum</option>
                                                <option value="2"
                                                    {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepRajalRisikoJatuh->resiko_jatuh_jenis ?? '') == '2' ? 'selected' : '' }}>
                                                    Skala Morse</option>
                                                <option value="3"
                                                    {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepRajalRisikoJatuh->resiko_jatuh_jenis ?? '') == '3' ? 'selected' : '' }}>
                                                    Skala Humpty-Dumpty / Pediatrik</option>
                                                <option value="4"
                                                    {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepRajalRisikoJatuh->resiko_jatuh_jenis ?? '') == '4' ? 'selected' : '' }}>
                                                    Skala Ontario Modified Stratify Sydney / Lansia</option>
                                                <option value="5"
                                                    {{ old('resiko_jatuh_jenis', $asesmen->asesmenKepRajalRisikoJatuh->resiko_jatuh_jenis ?? '') == '5' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">7. Skrining Batuk</h5>
                                        <div class="form-group mb-3">
                                            <label class="me-3" style="min-width:300px;">Kejadian batuk</label>
                                            <div class="d-flex flex-column flex-md-row gap-3 align-items-center">
                                                <input type="radio" class="form-check-input" disabled
                                                    name="skrining_batuk_kejadian" value="1" id="batuk_ada"
                                                    {{ old('skrining_batuk_kejadian', $asesmen->asesmenKepRajal->skrining_batuk_kejadian ?? '') == '1' ? 'checked' : '' }}>
                                                <label style="min-width:50px;" for="batuk_ada">Ada</label>
                                                <input type="radio" class="form-check-input" disabled
                                                    name="skrining_batuk_kejadian" value="0" id="batuk_tidak"
                                                    {{ old('skrining_batuk_kejadian', $asesmen->asesmenKepRajal->skrining_batuk_kejadian ?? '') == '0' ? 'checked' : '' }}>
                                                <label style="min-width:50px;" for="batuk_tidak">Tidak</label>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="me-3" style="min-width:300px;">Keputusan</label>
                                            <select name="skrining_batuk_keputusan" class="form-select" disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="sesuai_antrian"
                                                    {{ old('skrining_batuk_keputusan', $asesmen->asesmenKepRajal->skrining_batuk_keputusan ?? '') == 'sesuai_antrian' ? 'selected' : '' }}>
                                                    Sesuai antrian</option>
                                                <option value="poliklinik"
                                                    {{ old('skrining_batuk_keputusan', $asesmen->asesmenKepRajal->skrining_batuk_keputusan ?? '') == 'poliklinik' ? 'selected' : '' }}>
                                                    Poliklinik disegerakan</option>
                                                <option value="igd"
                                                    {{ old('skrining_batuk_keputusan', $asesmen->asesmenKepRajal->skrining_batuk_keputusan ?? '') == 'igd' ? 'selected' : '' }}>
                                                    IGD</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">8. Status Gizi</h5>
                                        <div class="form-group mb-4">
                                            <select class="form-select" name="gizi_jenis" id="nutritionAssessment"
                                                disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    {{ old('gizi_jenis', $asesmen->asesmenKepRajalGizi->gizi_jenis ?? '') == '1' ? 'selected' : '' }}>
                                                    Malnutrition Screening Tool (MST)</option>
                                                <option value="2"
                                                    {{ old('gizi_jenis', $asesmen->asesmenKepRajalGizi->gizi_jenis ?? '') == '2' ? 'selected' : '' }}>
                                                    The Mini Nutritional Assessment (MNA)</option>
                                                <option value="3"
                                                    {{ old('gizi_jenis', $asesmen->asesmenKepRajalGizi->gizi_jenis ?? '') == '3' ? 'selected' : '' }}>
                                                    Strong Kids (1 bln - 18 Tahun)</option>
                                                <option value="5"
                                                    {{ old('gizi_jenis', $asesmen->asesmenKepRajalGizi->gizi_jenis ?? '') == '5' ? 'selected' : '' }}>
                                                    Tidak Dapat Dinilai</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">9. Status Fungsional</h5>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Status fungsional</label>
                                            <select class="form-select" name="fungsional_status" disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="mandiri"
                                                    {{ old('fungsional_status', $asesmen->asesmenKepRajal->fungsional_status ?? '') == 'mandiri' ? 'selected' : '' }}>
                                                    Mandiri</option>
                                                <option value="ketergantungan_ringan"
                                                    {{ old('fungsional_status', $asesmen->asesmenKepRajal->fungsional_status ?? '') == 'ketergantungan_ringan' ? 'selected' : '' }}>
                                                    Ketergantungan Ringan</option>
                                                <option value="ketergantungan_sedang"
                                                    {{ old('fungsional_status', $asesmen->asesmenKepRajal->fungsional_status ?? '') == 'ketergantungan_sedang' ? 'selected' : '' }}>
                                                    Ketergantungan Sedang</option>
                                                <option value="ketergantungan_berat"
                                                    {{ old('fungsional_status', $asesmen->asesmenKepRajal->fungsional_status ?? '') == 'ketergantungan_berat' ? 'selected' : '' }}>
                                                    Ketergantungan Berat</option>
                                                <option value="ketergantungan_total"
                                                    {{ old('fungsional_status', $asesmen->asesmenKepRajal->fungsional_status ?? '') == 'ketergantungan_total' ? 'selected' : '' }}>
                                                    Ketergantungan Total</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3" id="fungsional_sebutkan_field"
                                            style="display:none;">
                                            <label class="me-3" style="min-width:300px;">Sebutkan</label>
                                            <input type="text" class="form-control w-100" name="fungsional_sebutkan"
                                                id="fungsional_sebutkan" placeholder="Sebutkan status fungsional..."
                                                value="{{ old('fungsional_sebutkan', $asesmen->asesmenKepRajal->fungsional_sebutkan ?? '') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="fungsional_ketergantungan_total"
                                                style="min-width: 300px;">Ketergantungan Total</label>
                                            <input disabled type="text" class="form-control"
                                                name="fungsional_ketergantungan_total"
                                                id="fungsional_ketergantungan_total"
                                                value="{{ old('fungsional_ketergantungan_total', $asesmen->asesmenKepRajal->fungsional_ketergantungan_total ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">10. Edukasi/Pendidikan Dan Pengajaran</h5>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Gaya bicara</label>
                                            <select class="form-select" name="kebutuhan_edukasi_gaya_bicara" disabled>
                                                <option value="">--Pilih--</option>
                                                @php
                                                    $gayaBicaraOptions = [
                                                        '0' => 'Normal',
                                                        '1' => 'Tidak Normal',
                                                        '2' => 'Belum Bisa Bicara',
                                                    ];
                                                @endphp
                                                @foreach ($gayaBicaraOptions as $value => $label)
                                                    <option value="{{ $value }}"
                                                        {{ old('gaya_bicara', $asesmen->asesmenKepRajalPendidikan->gaya_bicara ?? '') == $value ? 'selected' : '' }}>
                                                        {{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Bahasa sehari-hari</label>
                                            <select class="form-select" name="kebutuhan_edukasi_bahasa_sehari_hari"
                                                disabled>
                                                <option value="">--Pilih--</option>
                                                @php
                                                    $bahasaOptions = [
                                                        'Indonesia' => 'Indonesia',
                                                        'aceh' => 'Aceh',
                                                        'batak' => 'Batak',
                                                        'minangkabau' => 'Minangkabau',
                                                        'melayu' => 'Melayu',
                                                        'sunda' => 'Sunda',
                                                        'jawa' => 'Jawa',
                                                        'madura' => 'Madura',
                                                        'bali' => 'Bali',
                                                        'sasak' => 'Sasak',
                                                        'banjar' => 'Banjar',
                                                        'bugis' => 'Bugis',
                                                        'toraja' => 'Toraja',
                                                        'makassar' => 'Makassar',
                                                        'dayak' => 'Dayak',
                                                        'tidung' => 'Tidung',
                                                        'ambon' => 'Ambon',
                                                        'ternate' => 'Ternate',
                                                        'tidore' => 'Tidore',
                                                        'papua' => 'Papua',
                                                        'asmat' => 'Asmat',
                                                    ];
                                                @endphp
                                                @foreach ($bahasaOptions as $value => $label)
                                                    <option value="{{ $value }}"
                                                        {{ old('bahasa_sehari_hari', $asesmen->asesmenKepRajalPendidikan->bahasa_sehari_hari ?? '') == $value ? 'selected' : '' }}>
                                                        {{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Perlu penerjemah</label>
                                            <select class="form-select" name="kebutuhan_edukasi_perlu_penerjemah"
                                                disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="0"
                                                    {{ old('perlu_penerjemah', $asesmen->asesmenKepRajalPendidikan->perlu_penerjemah ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                                <option value="1"
                                                    {{ old('perlu_penerjemah', $asesmen->asesmenKepRajalPendidikan->perlu_penerjemah ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Hambatan komunikasi</label>
                                            <select class="form-select" name="kebutuhan_edukasi_hambatan_komunikasi"
                                                disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="bahasa"
                                                    {{ old('hambatan_komunikasi', $asesmen->asesmenKepRajalPendidikan->hambatan_komunikasi ?? '') == 'bahasa' ? 'selected' : '' }}>
                                                    Bahasa</option>
                                                <option value="menulis"
                                                    {{ old('hambatan_komunikasi', $asesmen->asesmenKepRajalPendidikan->hambatan_komunikasi ?? '') == 'menulis' ? 'selected' : '' }}>
                                                    Menulis</option>
                                                <option value="cemas"
                                                    {{ old('hambatan_komunikasi', $asesmen->asesmenKepRajalPendidikan->hambatan_komunikasi ?? '') == 'cemas' ? 'selected' : '' }}>
                                                    Cemas</option>
                                                <option value="lainnya"
                                                    {{ old('hambatan_komunikasi', $asesmen->asesmenKepRajalPendidikan->hambatan_komunikasi ?? '') == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Media belajar yang disukai</label>
                                            <select class="form-select" name="kebutuhan_edukasi_media_belajar" disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="audio"
                                                    {{ old('media_belajar_yang_disukai', $asesmen->asesmenKepRajalPendidikan->media_belajar_yang_disukai ?? '') == 'audio' ? 'selected' : '' }}>
                                                    Audio-Visual</option>
                                                <option value="brosur"
                                                    {{ old('media_belajar_yang_disukai', $asesmen->asesmenKepRajalPendidikan->media_belajar_yang_disukai ?? '') == 'brosur' ? 'selected' : '' }}>
                                                    Brosur</option>
                                                <option value="diskusi"
                                                    {{ old('media_belajar_yang_disukai', $asesmen->asesmenKepRajalPendidikan->media_belajar_yang_disukai ?? '') == 'diskusi' ? 'selected' : '' }}>
                                                    Diskusi</option>
                                                <option value="lainnya"
                                                    {{ old('media_belajar_yang_disukai', $asesmen->asesmenKepRajalPendidikan->media_belajar_yang_disukai ?? '') == 'lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Tingkat pendidikan</label>
                                            <select class="form-select" name="kebutuhan_edukasi_tingkat_pendidikan"
                                                disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="sd"
                                                    {{ old('tingkat_pendidikan', $asesmen->asesmenKepRajalPendidikan->tingkat_pendidikan ?? '') == 'sd' ? 'selected' : '' }}>
                                                    SD</option>
                                                <option value="smp"
                                                    {{ old('tingkat_pendidikan', $asesmen->asesmenKepRajalPendidikan->tingkat_pendidikan ?? '') == 'smp' ? 'selected' : '' }}>
                                                    SMP</option>
                                                <option value="sma"
                                                    {{ old('tingkat_pendidikan', $asesmen->asesmenKepRajalPendidikan->tingkat_pendidikan ?? '') == 'sma' ? 'selected' : '' }}>
                                                    SMA</option>
                                                <option value="sarjana"
                                                    {{ old('tingkat_pendidikan', $asesmen->asesmenKepRajalPendidikan->tingkat_pendidikan ?? '') == 'sarjana' ? 'selected' : '' }}>
                                                    Sarjana</option>
                                                <option value="master"
                                                    {{ old('tingkat_pendidikan', $asesmen->asesmenKepRajalPendidikan->tingkat_pendidikan ?? '') == 'master' ? 'selected' : '' }}>
                                                    Master</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Edukasi yang dibutuhkan</label>
                                            <select class="form-select" name="kebutuhan_edukasi_edukasi_dibutuhkan"
                                                disabled>
                                                <option value="">--Pilih--</option>
                                                <option value="Proses Penyakit"
                                                    {{ old('edukasi_yang_dibutuhkan', $asesmen->asesmenKepRajalPendidikan->edukasi_yang_dibutuhkan ?? '') == 'Proses Penyakit' ? 'selected' : '' }}>
                                                    Proses Penyakit</option>
                                                <option value="Pengobatan/Tindakan"
                                                    {{ old('edukasi_yang_dibutuhkan', $asesmen->asesmenKepRajalPendidikan->edukasi_yang_dibutuhkan ?? '') == 'Pengobatan/Tindakan' ? 'selected' : '' }}>
                                                    Pengobatan/Tindakan</option>
                                                <option value="Terapi/Obat"
                                                    {{ old('edukasi_yang_dibutuhkan', $asesmen->asesmenKepRajalPendidikan->edukasi_yang_dibutuhkan ?? '') == 'Terapi/Obat' ? 'selected' : '' }}>
                                                    Terapi/Obat</option>
                                                <option value="Nutrisi"
                                                    {{ old('edukasi_yang_dibutuhkan', $asesmen->asesmenKepRajalPendidikan->edukasi_yang_dibutuhkan ?? '') == 'Nutrisi' ? 'selected' : '' }}>
                                                    Nutrisi</option>
                                                <option value="Lainnya"
                                                    {{ old('edukasi_yang_dibutuhkan', $asesmen->asesmenKepRajalPendidikan->edukasi_yang_dibutuhkan ?? '') == 'Lainnya' ? 'selected' : '' }}>
                                                    Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Lainnya</label>
                                            <textarea disabled class="form-control" name="kebutuhan_edukasi_keterangan_lain" rows="3">{{ old('lainnya', $asesmen->asesmenKepRajalPendidikan->lainnya ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">11. Perencanaan Pemulangan Pasien/Discharge Planning</h5>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Diagnosis medis</label>
                                            <input disabled type="text" class="form-control" name="diagnosis_medis"
                                                id="diagnosis_medis"
                                                value="{{ old('diagnosis_medis', $asesmen->asesmenKepRajalDischargePlanning->diagnosis_medis ?? '') }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Usia lanjut</label>
                                            <select class="form-select discharge-select" name="usia_lanjut"
                                                id="usia_lanjut" disabled>
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1"
                                                    {{ old('usia_lanjut', $asesmen->asesmenKepRajalDischargePlanning->usia_lanjut ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ old('usia_lanjut', $asesmen->asesmenKepRajalDischargePlanning->usia_lanjut ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Hambatan mobilisasi</label>
                                            <select class="form-select discharge-select" name="hambatan_mobilisasi"
                                                id="hambatan_mobilisasi" disabled>
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1"
                                                    {{ old('hambatan_mobilisasi', $asesmen->asesmenKepRajalDischargePlanning->hambatan_mobilisasi ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ old('hambatan_mobilisasi', $asesmen->asesmenKepRajalDischargePlanning->hambatan_mobilisasi ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Membutuhkan pelayanan medis
                                                berkelanjutan</label>
                                            <select class="form-select discharge-select" name="layanan_medis_lanjutan"
                                                id="pelayanan_medis_berkelanjutan" disabled>
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1"
                                                    {{ old('layanan_medis_lanjutan', $asesmen->asesmenKepRajalDischargePlanning->layanan_medis_lanjutan ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ old('layanan_medis_lanjutan', $asesmen->asesmenKepRajalDischargePlanning->layanan_medis_lanjutan ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Ketergantungan dengan orang lain dalam
                                                aktivitas harian</label>
                                            <select class="form-select discharge-select" name="ketergantungan_orang_lain"
                                                id="ketergantungan_orang_lain" disabled>
                                                <option value="" selected disabled>pilih</option>
                                                <option value="1"
                                                    {{ old('ketergantungan_orang_lain', $asesmen->asesmenKepRajalDischargePlanning->ketergantungan_orang_lain ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ old('ketergantungan_orang_lain', $asesmen->asesmenKepRajalDischargePlanning->ketergantungan_orang_lain ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Rencana Pulang</label>
                                            <input disabled type="date" name="rencana_pulang" class="form-control"
                                                id="rencana_pulang_input"
                                                value="{{ old('rencana_pulang', $asesmen->asesmenKepRajalDischargePlanning->rencana_pulang ?? '') }}">
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
                                            <input type="hidden" name="kesimpulan" id="kesimpulan_value"
                                                value="{{ old('kesimpulan', $asesmen->asesmenKepRajalDischargePlanning->kesimpulan ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="section-title">12. Daftar Masalah dan Rencana Keperawatan</h5>
                                        <div class="form-group mt-4">
                                            <label style="min-width: 300px;">Masalah Keperawatan</label>
                                            <div class="w-100 d-flex flex-column">

                                                <!-- List Diagnosis -->
                                                <div id="diagnosis-list" class="diagnosis-list rounded w-100">
                                                    <p class="text-danger text-small" id="no-diagnosis">Belum
                                                        ada
                                                        diagnosis
                                                        ditambahkan</p>
                                                </div>

                                                <!-- Hidden input untuk dikirim ke backend -->
                                                <input type="hidden" id="keperawatan_masalah" name="keperawatan_masalah"
                                                    value="{{ old('keperawatan_masalah', json_encode($asesmen->asesmenKepRajal->keperawatan_masalah ?? [])) }}">
                                            </div>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label style="min-width: 300px;">Rencana Keperawatan</label>
                                            <div class="w-100 d-flex flex-column">
                                                <!-- List Diagnosis -->
                                                <div id="rencanaKeperawatan-list"
                                                    class="rencanaKeperawatan-list rounded w-100">
                                                    <p class="text-danger text-small" id="no-rencanaKeperawatan">Belum
                                                        ada
                                                        rencanaKeperawatan
                                                        ditambahkan</p>
                                                </div>

                                                <!-- Hidden input untuk dikirim ke backend -->
                                                <input type="hidden" id="keperawatan_rencana" name="keperawatan_rencana"
                                                    value="{{ old('keperawatan_rencana', json_encode($asesmen->asesmenKepRajal->keperawatan_rencana ?? [])) }}">
                                            </div>
                                        </div>
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
            if (batukAda && batukAda.checked) {
                batukLamaDiv.style.display = 'flex';
            } else {
                batukLamaDiv.style.display = 'none';
            }

            if (batukAda) {
                batukAda.addEventListener('change', function() {
                    if (batukAda.checked) {
                        batukLamaDiv.style.display = 'flex';
                    }
                });
            }

            if (batukTidak) {
                batukTidak.addEventListener('change', function() {
                    if (batukTidak.checked) {
                        batukLamaDiv.style.display = 'none';
                    }
                });
            }
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
            // Show field if already selected
            var checked = Array.from(radios).find(r => r.checked);
            if (checked && checked.value === 'sebutkan') {
                sebutkanField.style.display = '';
            } else {
                sebutkanField.style.display = 'none';
            }
        });

        // Masalah Keperawatan
        let diagnosisData = JSON.parse(document.getElementById('keperawatan_masalah').value || '[]');
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

        if (masalahAddBtn) {
            masalahAddBtn.addEventListener("click", function() {
                const value = masalahInput.value.trim();
                if (value !== "") {
                    diagnosisData.push(value);
                    updateMasalahHiddenInput();
                    renderMasalahKeperawatan();
                    masalahInput.value = "";
                }
            });
        }

        if (masalahInput) {
            masalahInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    masalahAddBtn.click();
                }
            });
        }

        // Rencana Keperawatan
        let rencanaKeperawatanData = JSON.parse(document.getElementById('keperawatan_rencana').value || '[]');
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

        if (rencanaAddBtn) {
            rencanaAddBtn.addEventListener("click", function() {
                const value = rencanaInput.value.trim();
                if (value !== "") {
                    rencanaKeperawatanData.push(value);
                    updateRencanaHiddenInput();
                    renderRencanaKeperawatan();
                    rencanaInput.value = "";
                }
            });
        }

        if (rencanaInput) {
            rencanaInput.addEventListener("keypress", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    rencanaAddBtn.click();
                }
            });
        }

        // Initialize existing data
        document.addEventListener('DOMContentLoaded', function() {
            renderMasalahKeperawatan();
            renderRencanaKeperawatan();
        });
    </script>
@endpush

@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.modal-intervensirisikojatuh')
@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-keperawatan.include')
