@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.edit-include')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Patient Card -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('components.patient-card')
            </div>

            <!-- Main Form -->
            <div class="col-lg-9 col-md-8">
                <div class="d-flex align-items-center mb-3">
                    <a href="{{ route('rawat-jalan.hiv_art.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                        class="btn btn-outline-primary btn-sm me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

                <form id="praAnestesiForm" method=""
                    action="">
                    @csrf

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white text-center py-3">
                            <h5 class="mb-0 font-weight-bold"><strong class="text-info fw-bold">(DETAIL)</strong> IKHTISAR PERAWATAN PASIEN HIV DAN TERAPI ANTIRETROVIRAL (ART)
                            </h5>
                        </div>

                        <div class="card-body p-4">

                            <!-- Waktu -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-clock me-2"></i>Waktu</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal"
                                                    value="{{ old('tanggal', $hivArt->tanggal ? $hivArt->tanggal->format('Y-m-d') : '') }}"
                                                    required disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time" class="form-control" name="jam"
                                                    value="{{ $hivArt->jam_masuk ? \Carbon\Carbon::parse($hivArt->jam_masuk)->format('H:i') : date('H:i') }}"
                                                    required disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alergi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary">Alergi</h6>
                                </div>
                                <div class="section-separator" id="alergi">
                                    <input type="hidden" name="alergis" id="alergisInput" value="[]">
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
                                </div>

                                <!-- Data Identitas Pasien -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="section-header">
                                        1. Data Identitas Pasien
                                    </div>
                                    <div class="p-3">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">No Reg Nas</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" name="no_reg_nas"
                                                    value="{{ old('no_reg_nas', $hivArt->no_reg_nas) }}"
                                                    placeholder="No registrasi Nasional" disabled>
                                                @error('no_reg_nas')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">NIK</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" name="nik"
                                                    placeholder="Nomor Indok Kependudukan"
                                                    value="{{ old('nik', $hivArt->nik) }}" disabled>
                                                @error('nik')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Nama Ibu Kandung</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="nama_ibu_kandung"
                                                    placeholder="Nama Ibu Kandung"
                                                    value="{{ old('nama_ibu_kandung', $hivArt->nama_ibu_kandung) }}" disabled>
                                                @error('nama_ibu_kandung')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Alamat Pasien</label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea class="form-control" name="alamat_telp" rows="2"
                                                    placeholder="Alamat Pasien" disabled>{{ $hivArt->alamat_telp }}</textarea>
                                                @error('alamat_telp')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">No. Telp. Pasien</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" name="no_telp_pasien"
                                                    placeholder="No. Telp. Pasien" max="12"
                                                    value="{{ old('no_telp_pasien', $hivArt->no_telp_pasien) }}" disabled>
                                                @error('no_telp_pasien')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Nama Pengawas Minum Obat (PMO)</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="pmo"
                                                    placeholder="Nama Pengawas Minum Obat"
                                                    value="{{ old('pmo', $hivArt->pmo) }}" disabled>
                                                @error('pmo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Hubungannya dgn Pasien</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="hubungan_pasien"
                                                    placeholder="Hubungan dengan Pasien"
                                                    value="{{ old('hubungan_pasien', $hivArt->hubungan_pasien) }}" disabled>
                                                @error('hubungan_pasien')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Alamat PMO</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="alamat_no_telp_pmo"
                                                    placeholder="Alamat PMO"
                                                    value="{{ old('alamat_no_telp_pmo', $hivArt->alamat_no_telp_pmo) }}" disabled>
                                                @error('alamat_no_telp_pmo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">No. Telp. Pasien</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="number" class="form-control" name="no_telp_pmo"
                                                    placeholder="No. Telp. Pasien" max="12"
                                                    value="{{ old('no_telp_pmo', $hivArt->no_telp_pmo) }}" disabled>
                                                @error('no_telp_pmo')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Tanggal Konfirmasi tes HIV</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control" name="tgl_tes_hiv"
                                                    value="{{ old('tgl_tes_hiv', $hivArt->tgl_tes_hiv ? $hivArt->tgl_tes_hiv->format('Y-m-d') : '') }}" disabled>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Tempat</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="tempat_tes_hiv"
                                                    placeholder="Tempat Tes HIV"
                                                    value="{{ old('tempat_tes_hiv', $hivArt->tempat_tes_hiv) }}" disabled>
                                            </div>
                                        </div>

                                        @php
                                            // Parse JSON data dari database untuk mendapatkan nilai yang dipilih
                                            $selectedKiaDetails = [];
                                            $selectedValue = '';

                                            if (isset($hivArt) && isset($hivArt->kia_details)) {
                                                $selectedKiaDetails = is_string($hivArt->kia_details)
                                                    ? json_decode($hivArt->kia_details, true) ?? []
                                                    : (is_array($hivArt->kia_details) ? $hivArt->kia_details : []);

                                                $selectedValue = !empty($selectedKiaDetails) ? $selectedKiaDetails[0] : '';
                                            }
                                        @endphp

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold"><i>Entry Point</i></label>
                                            </div>
                                            <div class="col-md-9">
                                                <!-- 1. KIA -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" value="kia" id="kia"
                                                        name="kia_details[]" {{ $selectedValue == 'kia' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="kia">
                                                        1. KIA
                                                    </label>
                                                </div>

                                                <!-- 2-Rujukan Jalan dengan input tambahan -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" value="rujukan_jalan_tb"
                                                        id="kia_rujukan_jalan_tb" name="kia_details[]" {{ $selectedValue == 'rujukan_jalan_tb' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="kia_rujukan_jalan_tb">
                                                        2. Rujukan Jalan (TB, Anak, Penyakit Dalam, MIS, Lainnya...)
                                                    </label>
                                                </div>
                                                <div id="rujukan-details"
                                                    class="bg-light p-3 mb-3 rounded {{ $selectedValue == 'rujukan_jalan_tb' ? '' : 'd-none' }}">
                                                    <textarea class="form-control" name="rujukan_keterangan" rows="2"
                                                        placeholder="Sebutkan detail..." disabled>{{ isset($hivArt) ? $hivArt->rujukan_keterangan : '' }}</textarea>
                                                </div>

                                                <!-- 3-Rawat Inap -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" value="rujukan_rawat_inap"
                                                        id="kia_rawat_inap" name="kia_details[]" {{ $selectedValue == 'rujukan_rawat_inap' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="kia_rawat_inap">
                                                        3. Rawat Inap
                                                    </label>
                                                </div>

                                                <!-- 4-Praktek Swasta -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" value="praktek_swasta"
                                                        id="kia_praktek_swasta" name="kia_details[]" {{ $selectedValue == 'praktek_swasta' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="kia_praktek_swasta">
                                                        4. Praktek Swasta
                                                    </label>
                                                </div>

                                                <!-- 5-Jangkauan dengan input tambahan -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" value="jangkauan"
                                                        id="kia_jangkauan" name="kia_details[]" {{ $selectedValue == 'jangkauan' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="kia_jangkauan">
                                                        5. Jangkauan (Penasun, WPS, LSL, ...)
                                                    </label>
                                                </div>
                                                <div id="jangkauan-details"
                                                    class="bg-light p-3 mb-3 rounded {{ $selectedValue == 'jangkauan' ? '' : 'd-none' }}">
                                                    <textarea class="form-control" name="jangkauan_keterangan" rows="2"
                                                        placeholder="Sebutkan detail jangkauan..." disabled>{{ isset($hivArt) ? $hivArt->jangkauan_keterangan : '' }}</textarea>
                                                </div>

                                                <!-- 6-LSM -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" value="lsm" id="kia_lsm"
                                                        name="kia_details[]" {{ $selectedValue == 'lsm' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="kia_lsm">
                                                        6. LSM
                                                    </label>
                                                </div>

                                                <!-- 7-Datang sendiri -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" value="datang_sendiri"
                                                        id="kia_datang_sendiri" name="kia_details[]" {{ $selectedValue == 'datang_sendiri' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="kia_datang_sendiri">
                                                        7. Datang sendiri
                                                    </label>
                                                </div>

                                                <!-- 8-Lainnya dengan input tambahan -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" value="lainnya_uraikan"
                                                        id="kia_lainnya" name="kia_details[]" {{ $selectedValue == 'lainnya_uraikan' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="kia_lainnya">
                                                        8. Lainnya, uraikan...
                                                    </label>
                                                </div>
                                                <div id="lainnya-kia-details"
                                                    class="bg-light p-3 mb-3 rounded {{ $selectedValue == 'lainnya_uraikan' ? '' : 'd-none' }}">
                                                    <textarea class="form-control" name="lainnya_kia_keterangan" rows="2"
                                                        placeholder="Sebutkan lainnya..." disabled>{{ isset($hivArt) ? $hivArt->lainnya_kia_keterangan : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Data Riwayat Pribadi -->
                                @php
                                    // Parse JSON data faktor risiko dari database
                                    $selectedFaktorRisiko = [];
                                    if (isset($hivArt) && isset($hivArt->faktor_risiko)) {
                                        $selectedFaktorRisiko = is_string($hivArt->faktor_risiko)
                                            ? json_decode($hivArt->faktor_risiko, true) ?? []
                                            : (is_array($hivArt->faktor_risiko) ? $hivArt->faktor_risiko : []);
                                    }

                                    // Check apakah "Lain-lainnya" dipilih
                                    $isLainLainnyaSelected = in_array('Lain-lainnya', $selectedFaktorRisiko);
                                @endphp

                                <!-- Data Riwayat Pribadi -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="section-header">
                                        2. Data Riwayat Pribadi
                                    </div>
                                    <div class="p-3">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Pendidikan</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-select" name="pendidikan" disabled>
                                                    <option value="">--pilih--</option>
                                                    <option value="0" {{ (isset($hivArt) && $hivArt->pendidikan == '0') ? 'selected' : '' }}>Tidak Sekolah</option>
                                                    <option value="1" {{ (isset($hivArt) && $hivArt->pendidikan == '1') ? 'selected' : '' }}>SD</option>
                                                    <option value="2" {{ (isset($hivArt) && $hivArt->pendidikan == '2') ? 'selected' : '' }}>SMP</option>
                                                    <option value="3" {{ (isset($hivArt) && $hivArt->pendidikan == '3') ? 'selected' : '' }}>SMU</option>
                                                    <option value="4" {{ (isset($hivArt) && $hivArt->pendidikan == '4') ? 'selected' : '' }}>Akademi/PT</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Kerja</label>
                                            </div>
                                            <div class="col-md-9">
                                                <select class="form-select" name="pekerjaan" disabled>
                                                    <option value="">--pilih--</option>
                                                    <option value="0" {{ (isset($hivArt) && $hivArt->pekerjaan == '0') ? 'selected' : '' }}>Tidak Bekerja</option>
                                                    <option value="1" {{ (isset($hivArt) && $hivArt->pekerjaan == '1') ? 'selected' : '' }}>Bekerja</option>
                                                    <option value="2" {{ (isset($hivArt) && $hivArt->pekerjaan == '2') ? 'selected' : '' }}>lainnya</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Faktor Risiko</label>
                                            </div>
                                            <div class="col-md-9">
                                                <!-- Seks Vaginal Berisiko -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="Seks Vaginal Berisiko" id="seks_vaginal"
                                                        name="faktor_risiko[]" {{ in_array('Seks Vaginal Berisiko', $selectedFaktorRisiko) ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="seks_vaginal">
                                                        Seks Vaginal Berisiko
                                                    </label>
                                                </div>

                                                <!-- Seks Anal Berisiko -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="Seks Anal Berisiko" id="seks_anal" name="faktor_risiko[]" {{ in_array('Seks Anal Berisiko', $selectedFaktorRisiko) ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="seks_anal">
                                                        Seks Anal Berisiko
                                                    </label>
                                                </div>

                                                <!-- Perinatal -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" value="Perinatal"
                                                        id="perinatal" name="faktor_risiko[]" {{ in_array('Perinatal', $selectedFaktorRisiko) ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="perinatal">
                                                        Perinatal
                                                    </label>
                                                </div>

                                                <!-- Transfusi Darah -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" value="Transfusi Darah"
                                                        id="transfusi_darah" name="faktor_risiko[]" {{ in_array('Transfusi Darah', $selectedFaktorRisiko) ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="transfusi_darah">
                                                        Transfusi Darah
                                                    </label>
                                                </div>

                                                <!-- NAPZA Suntik -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" value="NAPZA Suntik"
                                                        id="napza_suntik" name="faktor_risiko[]" {{ in_array('NAPZA Suntik', $selectedFaktorRisiko) ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="napza_suntik">
                                                        NAPZA Suntik
                                                    </label>
                                                </div>

                                                <!-- Lain-lainnya dengan input tambahan -->
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" value="Lain-lainnya"
                                                        id="lain_lainnya" name="faktor_risiko[]" {{ $isLainLainnyaSelected ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="lain_lainnya">
                                                        Lain-lain, Uraikan...
                                                    </label>
                                                </div>
                                                <div id="lain-lainnya-details"
                                                    class="bg-light p-3 mb-3 rounded {{ $isLainLainnyaSelected ? '' : 'd-none' }}">
                                                    <textarea class="form-control" name="lain_lainnya_keterangan" rows="2"
                                                        placeholder="Sebutkan faktor risiko lainnya..." disabled>{{ isset($hivArt) ? $hivArt->lain_lainnya_keterangan : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Data Riwayat Keluarga / Mitra Seksual / Mitra Penasun -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="section-header">
                                        3. Riwayat Keluarga / Mitra Seksual / Mitra Penasun
                                    </div>
                                    <div class="p-3">
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Status Pernikahan</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="inlineCheckbox1"
                                                        name="status_pernikahan" value="Menikah" {{ (isset($hivArt) && $hivArt->status_pernikahan == 'Menikah') ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="inlineCheckbox1">Menikah</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="inlineCheckbox2"
                                                        name="status_pernikahan" value="Belum Menikah" {{ (isset($hivArt) && $hivArt->status_pernikahan == 'Belum Menikah') ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="inlineCheckbox2">Belum
                                                        Menikah</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="inlineCheckbox3"
                                                        name="status_pernikahan" value="Janda/Duda" {{ (isset($hivArt) && $hivArt->status_pernikahan == 'Janda/Duda') ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="inlineCheckbox3">Janda/Duda</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        // Parse existing mitra data dari database untuk edit
                                        $existingMitraData = [];
                                        if (isset($hivArt) && isset($hivArt->data_keluarga)) {
                                            if (is_string($hivArt->data_keluarga)) {
                                                $existingMitraData = json_decode($hivArt->data_keluarga, true) ?? [];
                                            } elseif (is_array($hivArt->data_keluarga)) {
                                                $existingMitraData = $hivArt->data_keluarga;
                                            }
                                        }
                                    @endphp

                                    <div class="p-3">
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="mb-0">Data Keluarga / Mitra</h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover" id="mitraTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th width="20%">Nama</th>
                                                                <th width="10%">Hub</th>
                                                                <th width="10%">Umur</th>
                                                                <th width="15%">HIV +/-</th>
                                                                <th width="15%">ART Y/T</th>
                                                                <th width="20%">NoRegNas</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($existingMitraData) > 0)
                                                                @foreach($existingMitraData as $index => $mitra)
                                                                    <tr>
                                                                        <td>{{ $mitra['nama'] ?? '' }}</td>
                                                                        <td>{{ $mitra['hubungan'] ?? '' }}</td>
                                                                        <td>{{ $mitra['umur'] ?? '' }}</td>
                                                                        <td>
                                                                            @php
                                                                                $hivStatus = $mitra['status_hiv'] ?? '';
                                                                                $hivBadgeClass = '';
                                                                                switch ($hivStatus) {
                                                                                    case 'Positif':
                                                                                        $hivBadgeClass = 'bg-danger';
                                                                                        break;
                                                                                    case 'Negatif':
                                                                                        $hivBadgeClass = 'bg-success';
                                                                                        break;
                                                                                    case 'Tidak Diketahui':
                                                                                        $hivBadgeClass = 'bg-warning text-dark';
                                                                                        break;
                                                                                    case 'Belum Tes':
                                                                                        $hivBadgeClass = 'bg-secondary';
                                                                                        break;
                                                                                    default:
                                                                                        $hivBadgeClass = 'bg-light text-dark';
                                                                                }
                                                                            @endphp
                                                                            <span class="badge {{ $hivBadgeClass }}">
                                                                                {{ $hivStatus ?: '-' }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                $artStatus = $mitra['status_art'] ?? '';
                                                                                $artBadgeClass = '';
                                                                                switch ($artStatus) {
                                                                                    case 'Ya':
                                                                                        $artBadgeClass = 'bg-success';
                                                                                        break;
                                                                                    case 'Tidak':
                                                                                        $artBadgeClass = 'bg-danger';
                                                                                        break;
                                                                                    case 'Tidak Berlaku':
                                                                                        $artBadgeClass = 'bg-secondary';
                                                                                        break;
                                                                                    default:
                                                                                        $artBadgeClass = 'bg-light text-dark';
                                                                                }
                                                                            @endphp
                                                                            <span class="badge {{ $artBadgeClass }}">
                                                                                {{ $artStatus ?: '-' }}
                                                                            </span>
                                                                        </td>
                                                                        <td>{{ $mitra['no_reg_nas'] ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr id="no-data-row">
                                                                    <td colspan="7" class="text-center text-muted">Tidak ada
                                                                        data</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <!-- Hidden input untuk mengirim JSON ke backend -->
                                                    <input type="hidden" name="data_keluarga" id="dataKeluargaInput"
                                                        value="{{ json_encode($existingMitraData) }}">
                                                    <!-- Hidden input untuk JavaScript -->
                                                    <input type="hidden" id="existing-mitra-data"
                                                        value="{{ json_encode($existingMitraData) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Data Riwayat Terapi Antiretroviral -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="section-header">
                                        4. Riwayat Terapi Antiretroviral
                                    </div>
                                    <div class="p-3">
                                        <!-- Pernah Menerima ART -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Pernah menerima ART?</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="menerima_art_ya"
                                                        value="Ya" name="menerima_art" {{ (isset($hivArt) && $hivArt->menerima_art == 'Ya') ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="menerima_art_ya">1. Ya</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="menerima_art_tidak"
                                                        value="Tidak" name="menerima_art" {{ (isset($hivArt) && $hivArt->menerima_art == 'Tidak') ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label" for="menerima_art_tidak">2.
                                                        Tidak</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Detail ART (show/hide based on selection) -->
                                        <div id="art_details" class="art-details"
                                            style="display: {{ (isset($hivArt) && $hivArt->menerima_art == 'Ya') ? 'block' : 'none' }};">
                                            <!-- Jika ya, pilih jenis -->
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">Jika ya</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" id="ppia" value="PPIA"
                                                            name="jenis_art" {{ (isset($hivArt) && $hivArt->jenis_art == 'PPIA') ? 'checked' : '' }} disabled>
                                                        <label class="form-check-label" for="ppia">1. PPIA</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" id="art" value="ART"
                                                            name="jenis_art" {{ (isset($hivArt) && $hivArt->jenis_art == 'ART') ? 'checked' : '' }} disabled>
                                                        <label class="form-check-label" for="art">2. ART</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" id="ppp" value="PPP"
                                                            name="jenis_art" {{ (isset($hivArt) && $hivArt->jenis_art == 'PPP') ? 'checked' : '' }} disabled>
                                                        <label class="form-check-label" for="ppp">3. PPP</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tempat ART Dulu -->
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">Tempat ART dulu</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" id="rs_pemerintah"
                                                            value="RS Pemerintah" name="tempat_art" {{ (isset($hivArt) && $hivArt->tempat_art == 'RS Pemerintah') ? 'checked' : '' }} disabled>
                                                        <label class="form-check-label" for="rs_pemerintah">1. RS
                                                            Pem</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" id="rs_swasta"
                                                            value="RS Swasta" name="tempat_art" {{ (isset($hivArt) && $hivArt->tempat_art == 'RS Swasta') ? 'checked' : '' }} disabled>
                                                        <label class="form-check-label" for="rs_swasta">2. RS Swasta</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" id="pkm" value="PKM"
                                                            name="tempat_art" {{ (isset($hivArt) && $hivArt->tempat_art == 'PKM') ? 'checked' : '' }} disabled>
                                                        <label class="form-check-label" for="pkm">3. PKM</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Nama, dosis ARV & lama penggunaannya (Free text) -->
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold">Nama, dosis ARV & lama
                                                        penggunaannya</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <textarea class="form-control" name="nama_dosis_arv" rows="4"
                                                        placeholder="Sebutkan nama obat ARV, dosis, dan lama penggunaan secara detail..." disabled>{{ isset($hivArt) ? $hivArt->nama_dosis_arv : '' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Pemeriksaan Klinis dan Laboratorium -->
                                <div class="card shadow-sm">
                                    <div class="section-header">
                                        <h5 class="mb-0">
                                            5. Data Pemeriksaan Klinis dan Laboratorium
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Info Panel -->
                                        <div class="alert alert-info border-0 mb-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <div>
                                                    <strong>Petunjuk Pengisian:</strong><br>
                                                    <small>Isi data pemeriksaan pada setiap tahap kunjungan pasien. Tidak
                                                        semua kolom wajib diisi.</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Grid -->
                                        <div class="row g-4">
                                            <!-- Kunjungan Pertama -->
                                            <div class="col-12">
                                                <div class="card border-start border-success border-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-success">
                                                            <i class="fas fa-calendar-plus me-2"></i>
                                                            Kunjungan Pertama
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Tanggal Kunjungan</label>
                                                                <input type="date" name="kunjungan_pertama_tanggal"
                                                                    class="form-control"
                                                                    value="{{ old('kunjungan_pertama_tanggal', $hivArt->dataPemeriksaanKlinis->kunjungan_pertama_tanggal ? $hivArt->dataPemeriksaanKlinis->kunjungan_pertama_tanggal->format('Y-m-d') : '') }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Stad. Klinis</label>
                                                                <input type="text" name="kunjungan_pertama_klinis"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->kunjungan_pertama_klinis : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">BB</label>
                                                                <div class="input-group">
                                                                    <input type="number" name="kunjungan_pertama_bb"
                                                                        class="form-control" placeholder="0"
                                                                        value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->kunjungan_pertama_bb : '' }}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Status Fungsional
                                                                    <br>
                                                                    <small class="text-muted">1 = kerja / 2 = ambulatori / 3
                                                                        = baring</small>
                                                                </label>
                                                                <input type="text"
                                                                    name="kunjungan_pertama_status_fungsional"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->kunjungan_pertama_status_fungsional : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">JumlahCD4
                                                                    <br><small class="text-muted">(CD4 % pd
                                                                        anak)</small></label>
                                                                <input type="number" name="kunjungan_pertama_cd4"
                                                                    class="form-control" placeholder="0"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->kunjungan_pertama_cd4 : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Lain-lain</label>
                                                                <textarea name="kunjungan_pertama_lain" class="form-control"
                                                                    rows="2"
                                                                    placeholder="Isi Lainnya..." disabled>{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->kunjungan_pertama_lain : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Memenuhi syarat medis utk ART -->
                                            <div class="col-12">
                                                <div class="card border-start border-warning border-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-warning">
                                                            <i class="fas fa-check-circle me-2"></i>
                                                            Memenuhi syarat medis utk ART
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Tanggal</label>
                                                                <input type="date" name="memenuhi_syarat_tanggal"
                                                                    class="form-control"
                                                                    value="{{ old('memenuhi_syarat_tanggal', $hivArt->dataPemeriksaanKlinis->memenuhi_syarat_tanggal ? $hivArt->dataPemeriksaanKlinis->memenuhi_syarat_tanggal->format('Y-m-d') : '') }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Stad. Klinis</label>
                                                                <input type="text" name="memenuhi_syarat_klinis"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->memenuhi_syarat_klinis : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">BB</label>
                                                                <div class="input-group">
                                                                    <input type="number" name="memenuhi_syarat_bb"
                                                                        class="form-control" placeholder="0"
                                                                        value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->memenuhi_syarat_bb : '' }}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Status Fungsional
                                                                    <br>
                                                                    <small class="text-muted">1 = kerja / 2 = ambulatori / 3
                                                                        = baring</small>
                                                                </label>
                                                                <input type="text" name="memenuhi_syarat_status_fungsional"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->memenuhi_syarat_status_fungsional : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">JumlahCD4
                                                                    <br><small class="text-muted">(CD4 % pd
                                                                        anak)</small></label>
                                                                <input type="number" name="memenuhi_syarat_cd4"
                                                                    class="form-control" placeholder="0"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->memenuhi_syarat_cd4 : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Lain-lain</label>
                                                                <textarea name="memenuhi_syarat_lain" class="form-control"
                                                                    rows="2"
                                                                    placeholder="Isi Lainnya..." disabled>{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->memenuhi_syarat_lain : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Saat mulai ART -->
                                            <div class="col-12">
                                                <div class="card border-start border-primary border-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-primary">
                                                            <i class="fas fa-play-circle me-2"></i>
                                                            Saat mulai ART
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Tanggal</label>
                                                                <input type="date" name="saat_mulai_art_tanggal"
                                                                    class="form-control"
                                                                    value="{{ old('saat_mulai_art_tanggal', $hivArt->dataPemeriksaanKlinis->saat_mulai_art_tanggal ? $hivArt->dataPemeriksaanKlinis->saat_mulai_art_tanggal->format('Y-m-d') : '') }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Stad. Klinis</label>
                                                                <input type="text" name="saat_mulai_art_klinis"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->saat_mulai_art_klinis : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">BB</label>
                                                                <div class="input-group">
                                                                    <input type="number" name="saat_mulai_art_bb"
                                                                        class="form-control" placeholder="0"
                                                                        value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->saat_mulai_art_bb : '' }}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Status Fungsional
                                                                    <br>
                                                                    <small class="text-muted">1 = kerja / 2 = ambulatori / 3
                                                                        = baring</small>
                                                                </label>
                                                                <input type="text" name="saat_mulai_art_status_fungsional"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->saat_mulai_art_status_fungsional : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">JumlahCD4
                                                                    <br><small class="text-muted">(CD4 % pd
                                                                        anak)</small></label>
                                                                <input type="number" name="saat_mulai_art_cd4"
                                                                    class="form-control" placeholder="0"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->saat_mulai_art_cd4 : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Lain-lain</label>
                                                                <textarea name="saat_mulai_art_lain" class="form-control"
                                                                    rows="2"
                                                                    placeholder="Isi Lainnya..." disabled>{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->saat_mulai_art_lain : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Setelah 6 bulan ART -->
                                            <div class="col-12">
                                                <div class="card border-start border-info border-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-info">
                                                            <i class="fas fa-calendar-check me-2"></i>
                                                            Setelah 6 bulan ART
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Tanggal</label>
                                                                <input type="date" name="setelah_6_bulan_tanggal"
                                                                    class="form-control"
                                                                    value="{{ old('setelah_6_bulan_tanggal', $hivArt->dataPemeriksaanKlinis->setelah_6_bulan_tanggal ? $hivArt->dataPemeriksaanKlinis->setelah_6_bulan_tanggal->format('Y-m-d') : '') }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Stad. Klinis</label>
                                                                <input type="text" name="setelah_6_bulan_klinis"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_6_bulan_klinis : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">BB</label>
                                                                <div class="input-group">
                                                                    <input type="number" name="setelah_6_bulan_bb"
                                                                        class="form-control" placeholder="0"
                                                                        value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_6_bulan_bb : '' }}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Status Fungsional
                                                                    <br>
                                                                    <small class="text-muted">1 = kerja / 2 = ambulatori / 3
                                                                        = baring</small>
                                                                </label>
                                                                <input type="text" name="setelah_6_bulan_status_fungsional"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_6_bulan_status_fungsional : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">JumlahCD4
                                                                    <br><small class="text-muted">(CD4 % pd
                                                                        anak)</small></label>
                                                                <input type="number" name="setelah_6_bulan_cd4"
                                                                    class="form-control" placeholder="0"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_6_bulan_cd4 : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Lain-lain</label>
                                                                <textarea name="setelah_6_bulan_lain" class="form-control"
                                                                    rows="2"
                                                                    placeholder="Isi Lainnya..." disabled>{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_6_bulan_lain : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Setelah 12 bulan ART -->
                                            <div class="col-12">
                                                <div class="card border-start border-secondary border-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-secondary">
                                                            <i class="fas fa-calendar-alt me-2"></i>
                                                            Setelah 12 bulan ART
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Tanggal</label>
                                                                <input type="date" name="setelah_12_bulan_tanggal"
                                                                    class="form-control"
                                                                    value="{{ old('setelah_12_bulan_tanggal', $hivArt->dataPemeriksaanKlinis->setelah_12_bulan_tanggal ? $hivArt->dataPemeriksaanKlinis->setelah_12_bulan_tanggal->format('Y-m-d') : '') }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Stad. Klinis</label>
                                                                <input type="text" name="setelah_12_bulan_klinis"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_12_bulan_klinis : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">BB</label>
                                                                <div class="input-group">
                                                                    <input type="number" name="setelah_12_bulan_bb"
                                                                        class="form-control" placeholder="0"
                                                                        value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_12_bulan_bb : '' }}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Status Fungsional
                                                                    <br>
                                                                    <small class="text-muted">1 = kerja / 2 = ambulatori / 3
                                                                        = baring</small>
                                                                </label>
                                                                <input type="text" name="setelah_12_bulan_status_fungsional"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_12_bulan_status_fungsional : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">JumlahCD4
                                                                    <br><small class="text-muted">(CD4 % pd
                                                                        anak)</small></label>
                                                                <input type="number" name="setelah_12_bulan_cd4"
                                                                    class="form-control" placeholder="0"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_12_bulan_cd4 : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Lain-lain</label>
                                                                <textarea name="setelah_12_bulan_lain" class="form-control"
                                                                    rows="2"
                                                                    placeholder="Isi Lainnya..." disabled>{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_12_bulan_lain : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Setelah 24 bulan ART -->
                                            <div class="col-12">
                                                <div class="card border-start border-dark border-4">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-dark">
                                                            <i class="fas fa-calendar me-2"></i>
                                                            Setelah 24 bulan ART
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Tanggal</label>
                                                                <input type="date" name="setelah_24_bulan_tanggal"
                                                                    class="form-control"
                                                                    value="{{ old('setelah_24_bulan_tanggal', $hivArt->dataPemeriksaanKlinis->setelah_24_bulan_tanggal ? $hivArt->dataPemeriksaanKlinis->setelah_24_bulan_tanggal->format('Y-m-d') : '') }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Stad. Klinis</label>
                                                                <input type="text" name="setelah_24_bulan_klinis"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_24_bulan_klinis : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">BB</label>
                                                                <div class="input-group">
                                                                    <input type="number" name="setelah_24_bulan_bb"
                                                                        class="form-control" placeholder="0"
                                                                        value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_24_bulan_bb : '' }}" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Status Fungsional
                                                                    <br>
                                                                    <small class="text-muted">1 = kerja / 2 = ambulatori / 3
                                                                        = baring</small>
                                                                </label>
                                                                <input type="text" name="setelah_24_bulan_status_fungsional"
                                                                    class="form-control"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_24_bulan_status_fungsional : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">JumlahCD4
                                                                    <br><small class="text-muted">(CD4 % pd
                                                                        anak)</small></label>
                                                                <input type="number" name="setelah_24_bulan_cd4"
                                                                    class="form-control" placeholder="0"
                                                                    value="{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_24_bulan_cd4 : '' }}" disabled>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="form-label fw-bold">Lain-lain</label>
                                                                <textarea name="setelah_24_bulan_lain" class="form-control"
                                                                    rows="2"
                                                                    placeholder="Isi Lainnya..." disabled>{{ isset($hivArt->dataPemeriksaanKlinis) ? $hivArt->dataPemeriksaanKlinis->setelah_24_bulan_lain : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data api Antiretroviral (ART) -->
                                @php
                                    // Parse existing ART data dari database untuk edit - dengan safety check penuh
                                    $existingArtData = [];
                                    $artDataCount = 0;

                                    try {
                                        if (isset($hivArt) && $hivArt !== null) {
                                            if (isset($hivArt->terapiAntiretroviral) && $hivArt->terapiAntiretroviral !== null) {
                                                if (isset($hivArt->terapiAntiretroviral->data_terapi_art) && $hivArt->terapiAntiretroviral->data_terapi_art !== null) {
                                                    $rawData = $hivArt->terapiAntiretroviral->data_terapi_art;

                                                    if (is_string($rawData)) {
                                                        $decodedData = json_decode($rawData, true);
                                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedData)) {
                                                            $existingArtData = $decodedData;
                                                        }
                                                    } elseif (is_array($rawData)) {
                                                        $existingArtData = $rawData;
                                                    }
                                                }
                                            }
                                        }
                                    } catch (Exception $e) {
                                        // Jika ada error, set ke array kosong
                                        $existingArtData = [];
                                    }

                                    // Final safety check - pastikan selalu array
                                    if (!is_array($existingArtData)) {
                                        $existingArtData = [];
                                    }

                                    // Jika data adalah object tunggal, convert ke array
                                    if (!empty($existingArtData) && is_array($existingArtData) && !array_key_exists(0, $existingArtData)) {
                                        // Check apakah ini associative array (single object)
                                        $keys = array_keys($existingArtData);
                                        if (!empty($keys) && !is_numeric($keys[0])) {
                                            $existingArtData = [$existingArtData];
                                        }
                                    }

                                    // Count yang benar-benar aman
                                    $artDataCount = is_array($existingArtData) ? count($existingArtData) : 0;

                                    // Pastikan minimal 1 untuk tampilan
                                    if ($artDataCount === 0) {
                                        $artDataCount = 1;
                                        $hasExistingData = false;
                                    } else {
                                        $hasExistingData = true;
                                    }
                                @endphp

                                <!-- Data Terapi Antiretroviral (ART) -->
                                <div class="card shadow-sm">
                                    <div class="section-header">
                                        <h5 class="mb-0">
                                            6. Terapi Antiretroviral (ART)
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Info Panel -->
                                        <div class="alert alert-info border-0 mb-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <div>
                                                    <strong>Petunjuk Pengisian:</strong><br>
                                                    <small>Pilih nama paduan ART dan isi data substitusi/switch jika
                                                        diperlukan.
                                                        Gunakan tombol "Tambah ART Baru" untuk menambah riwayat
                                                        terapi.</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dynamic ART Sections -->
                                        <div id="artSections">
                                            @if($hasExistingData && is_array($existingArtData) && count($existingArtData) > 0)
                                                @foreach($existingArtData as $index => $artData)
                                                    @php
                                                        $sectionNumber = $index + 1;
                                                        $borderColors = ['primary', 'success', 'warning', 'info', 'secondary', 'danger'];
                                                        $borderColor = $borderColors[$index % count($borderColors)];
                                                        $isLainnyaSelected = isset($artData['nama_paduan_art']) && $artData['nama_paduan_art'] === 'lainnya';
                                                    @endphp

                                                    <!-- ART Section -->
                                                    <div class="art-section mb-4" data-section="{{ $sectionNumber }}">
                                                        <div class="card border-start border-{{ $borderColor }} border-4">
                                                            <div
                                                                class="card-header bg-body-secondary d-flex justify-content-between align-items-center">
                                                                <h6 class="mb-0 text-{{ $borderColor }}">
                                                                    <i class="fas fa-pills me-2"></i>
                                                                    Terapi ART #{{ $sectionNumber }}
                                                                </h6>

                                                            </div>
                                                            <div class="card-body">
                                                                <!-- Nama Paduan ART -->
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label fw-bold text-dark">Nama Paduan ART
                                                                            Original</label>
                                                                        <div class="bg-light-subtle">
                                                                            <div class="card-body p-3">
                                                                                <div class="form-check mb-2">
                                                                                    <input class="form-check-input" type="radio"
                                                                                        name="nama_paduan_art_{{ $sectionNumber }}"
                                                                                        value="TDF+3TC+EFV"
                                                                                        id="art1_{{ $sectionNumber }}" {{ (isset($artData['nama_paduan_art']) && $artData['nama_paduan_art'] == 'TDF+3TC+EFV') ? 'checked' : '' }} disabled>
                                                                                    <label class="form-check-label"
                                                                                        for="art1_{{ $sectionNumber }}">
                                                                                        1. TDF+3TC+EFV
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check mb-2">
                                                                                    <input class="form-check-input" type="radio"
                                                                                        name="nama_paduan_art_{{ $sectionNumber }}"
                                                                                        value="TDF+FTC+EFV"
                                                                                        id="art2_{{ $sectionNumber }}" {{ (isset($artData['nama_paduan_art']) && $artData['nama_paduan_art'] == 'TDF+FTC+EFV') ? 'checked' : '' }} disabled>
                                                                                    <label class="form-check-label"
                                                                                        for="art2_{{ $sectionNumber }}">
                                                                                        2. TDF+FTC+EFV
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check mb-2">
                                                                                    <input class="form-check-input" type="radio"
                                                                                        name="nama_paduan_art_{{ $sectionNumber }}"
                                                                                        value="TDF+3TC+NVP"
                                                                                        id="art3_{{ $sectionNumber }}" {{ (isset($artData['nama_paduan_art']) && $artData['nama_paduan_art'] == 'TDF+3TC+NVP') ? 'checked' : '' }} disabled>
                                                                                    <label class="form-check-label"
                                                                                        for="art3_{{ $sectionNumber }}">
                                                                                        3. TDF+3TC+NVP
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check mb-2">
                                                                                    <input class="form-check-input" type="radio"
                                                                                        name="nama_paduan_art_{{ $sectionNumber }}"
                                                                                        value="TDF+FTC+NVP"
                                                                                        id="art4_{{ $sectionNumber }}" {{ (isset($artData['nama_paduan_art']) && $artData['nama_paduan_art'] == 'TDF+FTC+NVP') ? 'checked' : '' }} disabled>
                                                                                    <label class="form-check-label"
                                                                                        for="art4_{{ $sectionNumber }}">
                                                                                        4. TDF+FTC+NVP
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check mb-2">
                                                                                    <input class="form-check-input" type="radio"
                                                                                        name="nama_paduan_art_{{ $sectionNumber }}"
                                                                                        value="AZT+3TC+EFV"
                                                                                        id="art5_{{ $sectionNumber }}" {{ (isset($artData['nama_paduan_art']) && $artData['nama_paduan_art'] == 'AZT+3TC+EFV') ? 'checked' : '' }} disabled>
                                                                                    <label class="form-check-label"
                                                                                        for="art5_{{ $sectionNumber }}">
                                                                                        5. AZT+3TC+EFV
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check mb-2">
                                                                                    <input class="form-check-input" type="radio"
                                                                                        name="nama_paduan_art_{{ $sectionNumber }}"
                                                                                        value="AZT+3TC+NVP"
                                                                                        id="art6_{{ $sectionNumber }}" {{ (isset($artData['nama_paduan_art']) && $artData['nama_paduan_art'] == 'AZT+3TC+NVP') ? 'checked' : '' }} disabled>
                                                                                    <label class="form-check-label"
                                                                                        for="art6_{{ $sectionNumber }}">
                                                                                        6. AZT+3TC+NVP
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check mb-3">
                                                                                    <input class="form-check-input" type="radio"
                                                                                        name="nama_paduan_art_{{ $sectionNumber }}"
                                                                                        value="lainnya"
                                                                                        id="art7_{{ $sectionNumber }}" {{ $isLainnyaSelected ? 'checked' : '' }} disabled>
                                                                                    <label class="form-check-label"
                                                                                        for="art7_{{ $sectionNumber }}">
                                                                                        7. Lainnya
                                                                                    </label>
                                                                                </div>
                                                                                <div id="lainnya-art-details-{{ $sectionNumber }}"
                                                                                    class="{{ $isLainnyaSelected ? '' : 'd-none' }}">
                                                                                    <input type="text"
                                                                                        name="art_lainnya_{{ $sectionNumber }}"
                                                                                        class="form-control form-control-sm"
                                                                                        placeholder="Sebutkan nama paduan ART lainnya"
                                                                                        value="{{ isset($artData['art_lainnya']) ? $artData['art_lainnya'] : '' }}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-8">
                                                                        <label class="form-label fw-bold text-dark">SUBSTITUSI dalam
                                                                            lini-1, SWITCH ke lini-2, STOP</label>
                                                                        <div class="row g-3">
                                                                            <div class="col-md-4">
                                                                                <label class="form-label fw-bold">Tanggal</label>
                                                                                <input type="date"
                                                                                    name="substitusi_tanggal_{{ $sectionNumber }}"
                                                                                    class="form-control"
                                                                                    value="{{ isset($artData['substitusi_tanggal']) ? $artData['substitusi_tanggal'] : '' }}" disabled>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label class="form-label fw-bold">Substitusi</label>
                                                                                <input type="text"
                                                                                    name="substitusi_{{ $sectionNumber }}"
                                                                                    class="form-control"
                                                                                    value="{{ isset($artData['substitusi']) ? $artData['substitusi'] : '' }}" disabled>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label class="form-label fw-bold">Switch</label>
                                                                                <input type="text"
                                                                                    name="switch_{{ $sectionNumber }}"
                                                                                    class="form-control"
                                                                                    value="{{ isset($artData['switch']) ? $artData['switch'] : '' }}" disabled>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row g-3">
                                                                            <div class="col-md-4">
                                                                                <label class="form-label fw-bold">Stop</label>
                                                                                <input type="text" name="stop_{{ $sectionNumber }}"
                                                                                    class="form-control"
                                                                                    value="{{ isset($artData['stop']) ? $artData['stop'] : '' }}" disabled>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label class="form-label fw-bold">Restart</label>
                                                                                <input type="text"
                                                                                    name="restart_{{ $sectionNumber }}"
                                                                                    class="form-control"
                                                                                    value="{{ isset($artData['restart']) ? $artData['restart'] : '' }}" disabled>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label class="form-label fw-bold">Alasan</label>
                                                                                <select name="alasan_{{ $sectionNumber }}"
                                                                                    class="form-select" disabled>
                                                                                    <option value="">Pilih alasan</option>
                                                                                    <option value="1" {{ (isset($artData['alasan']) && $artData['alasan'] == '1') ? 'selected' : '' }}>1. Toksisitas/efek samping</option>
                                                                                    <option value="2" {{ (isset($artData['alasan']) && $artData['alasan'] == '2') ? 'selected' : '' }}>2. Hamil</option>
                                                                                    <option value="3" {{ (isset($artData['alasan']) && $artData['alasan'] == '3') ? 'selected' : '' }}>3. Risiko hamil</option>
                                                                                    <option value="4" {{ (isset($artData['alasan']) && $artData['alasan'] == '4') ? 'selected' : '' }}>4. TB baru</option>
                                                                                    <option value="5" {{ (isset($artData['alasan']) && $artData['alasan'] == '5') ? 'selected' : '' }}>5. Ada obat baru</option>
                                                                                    <option value="6" {{ (isset($artData['alasan']) && $artData['alasan'] == '6') ? 'selected' : '' }}>6. Stok obat habis</option>
                                                                                    <option value="7" {{ (isset($artData['alasan']) && $artData['alasan'] == '7') ? 'selected' : '' }}>7. Alasan lain</option>
                                                                                    <option value="8" {{ (isset($artData['alasan']) && $artData['alasan'] == '8') ? 'selected' : '' }}>8. Gagal pengobatan klinis</option>
                                                                                    <option value="9" {{ (isset($artData['alasan']) && $artData['alasan'] == '9') ? 'selected' : '' }}>9. Gagal imunologis</option>
                                                                                    <option value="10" {{ (isset($artData['alasan']) && $artData['alasan'] == '10') ? 'selected' : '' }}>10. Gagal virologis</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row g-3">
                                                                            <div class="col-md-6">
                                                                                <label class="form-label fw-bold">Nama Paduan
                                                                                    Baru</label>
                                                                                <input type="text"
                                                                                    name="nama_paduan_baru_{{ $sectionNumber }}"
                                                                                    class="form-control"
                                                                                    value="{{ isset($artData['nama_paduan_baru']) ? $artData['nama_paduan_baru'] : '' }}" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <!-- Initial ART Section (jika tidak ada data existing) -->
                                                <div class="art-section mb-4" data-section="1">
                                                    <div class="card border-start border-primary border-4">

                                                        <div class="card-body">
                                                            <!-- Empty form structure sama seperti di atas, tapi tanpa value -->
                                                            <div class="row mb-3">
                                                                <div class="col-md-4">
                                                                    <label class="form-label fw-bold text-dark">Nama Paduan ART
                                                                        Original</label>
                                                                    <div class="bg-light-subtle">
                                                                        <div class="card-body p-3">
                                                                            <div class="form-check mb-2">
                                                                                <input class="form-check-input" type="radio"
                                                                                    name="nama_paduan_art_1" value="TDF+3TC+EFV"
                                                                                    id="art1_1" disabled>
                                                                                <label class="form-check-label" for="art1_1">1.
                                                                                    TDF+3TC+EFV</label>
                                                                            </div>
                                                                            <!-- dst radio buttons lainnya tanpa checked -->
                                                                            <div class="form-check mb-2">
                                                                                <input class="form-check-input" type="radio"
                                                                                    name="nama_paduan_art_1" value="TDF+FTC+EFV"
                                                                                    id="art2_1" disabled>
                                                                                <label class="form-check-label" for="art2_1">2.
                                                                                    TDF+FTC+EFV</label>
                                                                            </div>
                                                                            <div class="form-check mb-2">
                                                                                <input class="form-check-input" type="radio"
                                                                                    name="nama_paduan_art_1" value="TDF+3TC+NVP"
                                                                                    id="art3_1" disabled>
                                                                                <label class="form-check-label" for="art3_1">3.
                                                                                    TDF+3TC+NVP</label>
                                                                            </div>
                                                                            <div class="form-check mb-2">
                                                                                <input class="form-check-input" type="radio"
                                                                                    name="nama_paduan_art_1" value="TDF+FTC+NVP"
                                                                                    id="art4_1" disabled>
                                                                                <label class="form-check-label" for="art4_1">4.
                                                                                    TDF+FTC+NVP</label>
                                                                            </div>
                                                                            <div class="form-check mb-2">
                                                                                <input class="form-check-input" type="radio"
                                                                                    name="nama_paduan_art_1" value="AZT+3TC+EFV"
                                                                                    id="art5_1" disabled>
                                                                                <label class="form-check-label" for="art5_1">5.
                                                                                    AZT+3TC+EFV</label>
                                                                            </div>
                                                                            <div class="form-check mb-2">
                                                                                <input class="form-check-input" type="radio"
                                                                                    name="nama_paduan_art_1" value="AZT+3TC+NVP"
                                                                                    id="art6_1" disabled>
                                                                                <label class="form-check-label" for="art6_1">6.
                                                                                    AZT+3TC+NVP</label>
                                                                            </div>
                                                                            <div class="form-check mb-3">
                                                                                <input class="form-check-input" type="radio"
                                                                                    name="nama_paduan_art_1" value="lainnya"
                                                                                    id="art7_1" disabled>
                                                                                <label class="form-check-label" for="art7_1">7.
                                                                                    Lainnya</label>
                                                                            </div>
                                                                            <div id="lainnya-art-details-1" class="d-none">
                                                                                <input type="text" name="art_lainnya_1"
                                                                                    class="form-control form-control-sm"
                                                                                    placeholder="Sebutkan nama paduan ART lainnya" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <label class="form-label fw-bold text-dark">SUBSTITUSI dalam
                                                                        lini-1, SWITCH ke lini-2, STOP</label>
                                                                    <div class="row g-3">
                                                                        <div class="col-md-4">
                                                                            <label class="form-label fw-bold">Tanggal</label>
                                                                            <input type="date" name="substitusi_tanggal_1"
                                                                                class="form-control" disabled>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label fw-bold">Substitusi</label>
                                                                            <input type="text" name="substitusi_1"
                                                                                class="form-control" disabled>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label fw-bold">Switch</label>
                                                                            <input type="text" name="switch_1"
                                                                                class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row g-3">
                                                                        <div class="col-md-4">
                                                                            <label class="form-label fw-bold">Stop</label>
                                                                            <input type="text" name="stop_1"
                                                                                class="form-control" disabled>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label fw-bold">Restart</label>
                                                                            <input type="text" name="restart_1"
                                                                                class="form-control" disabled>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label fw-bold">Alasan</label>
                                                                            <select name="alasan_1" class="form-select" disabled>
                                                                                <option value="">Pilih alasan</option>
                                                                                <option value="1">1. Toksisitas/efek samping
                                                                                </option>
                                                                                <option value="2">2. Hamil</option>
                                                                                <option value="3">3. Risiko hamil</option>
                                                                                <option value="4">4. TB baru</option>
                                                                                <option value="5">5. Ada obat baru</option>
                                                                                <option value="6">6. Stok obat habis</option>
                                                                                <option value="7">7. Alasan lain</option>
                                                                                <option value="8">8. Gagal pengobatan klinis
                                                                                </option>
                                                                                <option value="9">9. Gagal imunologis</option>
                                                                                <option value="10">10. Gagal virologis</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row g-3">
                                                                        <div class="col-md-6">
                                                                            <label class="form-label fw-bold">Nama Paduan
                                                                                Baru</label>
                                                                            <input type="text" name="nama_paduan_baru_1"
                                                                                class="form-control" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Add New ART Button -->
                                        {{-- <div class="text-center mb-4">
                                            <button type="button" class="btn btn-success btn-sm" onclick="addArtSection()">
                                                <i class="fas fa-plus-circle me-2"></i>
                                                Tambah ART Baru
                                            </button>
                                        </div> --}}

                                        <!-- Hidden Inputs -->
                                        <input type="hidden" name="data_terapi_art" id="dataARTInput"
                                            value="{{ json_encode($existingArtData) }}">
                                        <input type="hidden" id="existing-art-data"
                                            value="{{ json_encode($existingArtData) }}">

                                        <!-- Keterangan Alasan -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="bg-info-subtle border-0">
                                                    <div class="card-header">
                                                        <h6 class="mb-0 text-primary">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            Keterangan Alasan
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <h6 class="text-warning">Alasan Substitusi/Switch:</h6>
                                                                <ul class="list-unstyled small">
                                                                    <li><strong>1.</strong> Toksisitas/efek samping</li>
                                                                    <li><strong>2.</strong> Hamil</li>
                                                                    <li><strong>3.</strong> Risiko hamil</li>
                                                                    <li><strong>4.</strong> TB baru</li>
                                                                    <li><strong>5.</strong> Ada obat baru</li>
                                                                    <li><strong>6.</strong> Stok obat habis</li>
                                                                    <li><strong>7.</strong> Alasan lain (uraikan)</li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h6 class="text-info">Alasan hanya untuk SWITCH:</h6>
                                                                <ul class="list-unstyled small">
                                                                    <li><strong>8.</strong> Gagal pengobatan klinis</li>
                                                                    <li><strong>9.</strong> Gagal imunologis</li>
                                                                    <li><strong>10.</strong> Gagal virologis</li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <h6 class="text-danger">Alasan STOP:</h6>
                                                                <ul class="list-unstyled small">
                                                                    <li><strong>1.</strong> Toksisitas/efek samping</li>
                                                                    <li><strong>2.</strong> Hamil</li>
                                                                    <li><strong>3.</strong> Gagal pengobatan</li>
                                                                    <li><strong>4.</strong> Adherens buruk</li>
                                                                    <li><strong>5.</strong> Sakit/MRS</li>
                                                                    <li><strong>6.</strong> Kekurangan biaya</li>
                                                                    <li><strong>7.</strong> Alasan lain</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Pengobatan TB selama perawatan HIV -->
                                <div class="card shadow-sm">
                                    <div class="section-header">
                                        <h5 class="mb-0">
                                            7. Pengobatan TB selama perawatan HIV
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Tanggal Terapi -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Tgl. Mulai terapi TB</label>
                                                    <input type="date" class="form-control" name="tgl_mulai_terapi_tb"
                                                        value="{{ old('tgl_mulai_terapi_tb', $hivArt->terapiAntiretroviral->tgl_mulai_terapi_tb ?? '') }}"
                                                        placeholder="Pilih tanggal mulai terapi" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label fw-bold">Tgl. Selesai terapi TB</label>
                                                    <input type="date" class="form-control" name="tgl_selesai_terapi_tb"
                                                        value="{{ old('tgl_selesai_terapi_tb', $hivArt->terapiAntiretroviral->tgl_selesai_terapi_tb ?? '') }}"
                                                        placeholder="Pilih tanggal selesai terapi" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Form Grid -->
                                        <div class="row g-4">
                                            <!-- Klasifikasi TB -->
                                            <div class="col-md-6">
                                                <div class="border-start">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-warning">
                                                            <i class="fas fa-lungs me-2"></i>
                                                            Klasifikasi TB (pilih)
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio"
                                                                name="klasifikasi_tb" value="tb_paru" id="tb_paru" {{ old('klasifikasi_tb', $hivArt->terapiAntiretroviral->klasifikasi_tb) == 'tb_paru' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="tb_paru">
                                                                <i class="fas fa-lungs text-danger me-2"></i>
                                                                1. TB Paru
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio"
                                                                name="klasifikasi_tb" value="tb_ekstra_paru"
                                                                id="tb_ekstra_paru" {{ old('klasifikasi_tb', $hivArt->terapiAntiretroviral->klasifikasi_tb) == 'tb_ekstra_paru' ? 'checked' : '' }} >
                                                            <label class="form-check-label fw-bold" for="tb_ekstra_paru">
                                                                <i class="fas fa-user-injured text-warning me-2"></i>
                                                                2. TB Ekstra Paru
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio"
                                                                name="klasifikasi_tb" value="tidak_ada" id="tidak_ada" {{ old('klasifikasi_tb', $hivArt->terapiAntiretroviral->klasifikasi_tb) == 'tidak_ada' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="tidak_ada">
                                                                <i class="fas fa-times-circle text-success me-2"></i>
                                                                Tidak Ada
                                                            </label>
                                                        </div>
                                                        <div id="lokasi_tb_ekstra"
                                                            class="{{ $hivArt->terapiAntiretroviral->klasifikasi_tb == 'tb_ekstra_paru' ? '' : 'd-none' }} mt-3">
                                                            <label class="form-label fw-bold text-warning">Lokasi TB Ekstra
                                                                Paru:</label>
                                                            <input type="text" name="lokasi_tb_ekstra" class="form-control"
                                                                value="{{ old('lokasi_tb_ekstra', $hivArt->terapiAntiretroviral->lokasi_tb_ekstra) }}"
                                                                placeholder="Sebutkan lokasi TB ekstra paru" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Paduan TB -->
                                            <div class="col-md-6">
                                                <div class="border-start">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-success">
                                                            <i class="fas fa-pills me-2"></i>
                                                            Paduan TB
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="paduan_tb"
                                                                value="kategori_1" id="kategori_1" {{ old('paduan_tb', $hivArt->terapiAntiretroviral->paduan_tb) == 'kategori_1' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="kategori_1">
                                                                <span class="badge bg-success me-2">1</span>
                                                                Kategori I
                                                                <i class="fas fa-info-circle text-muted ms-2"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Untuk TB baru (belum pernah diobati)"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="paduan_tb"
                                                                value="kategori_2" id="kategori_2" {{ old('paduan_tb', $hivArt->terapiAntiretroviral->paduan_tb) == 'kategori_2' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="kategori_2">
                                                                <span class="badge bg-warning me-2">2</span>
                                                                Kategori II
                                                                <i class="fas fa-info-circle text-muted ms-2"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Untuk TB kambuh/putus berobat"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="paduan_tb"
                                                                value="kategori_anak" id="kategori_anak" {{ old('paduan_tb', $hivArt->terapiAntiretroviral->paduan_tb) == 'kategori_anak' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="kategori_anak">
                                                                <span class="badge bg-info me-2">3</span>
                                                                Kategori Anak
                                                                <i class="fas fa-info-circle text-muted ms-2"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Untuk pasien anak - Dosis disesuaikan dengan berat badan"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="paduan_tb"
                                                                value="oat_lini_2" id="oat_lini_2" {{ old('paduan_tb', $hivArt->terapiAntiretroviral->paduan_tb) == 'oat_lini_2' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="oat_lini_2">
                                                                <span class="badge bg-danger me-2">4</span>
                                                                OAT Lini 2 (MDR)
                                                                <i class="fas fa-info-circle text-muted ms-2"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Untuk TB resistan obat - Pengobatan khusus dengan obat lini kedua"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tipe TB -->
                                            <div class="col-md-6">
                                                <div class="border-start">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-primary">
                                                            <i class="fas fa-stethoscope me-2"></i>
                                                            Tipe TB
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="tipe_tb"
                                                                value="baru" id="tb_baru" {{ old('tipe_tb', $hivArt->terapiAntiretroviral->tipe_tb) == 'baru' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="tb_baru">
                                                                <i class="fas fa-plus-circle text-success me-2"></i>
                                                                1. Baru
                                                                <i class="fas fa-info-circle text-muted ms-2"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Belum pernah diobati sebelumnya atau sudah diobati kurang dari 1 bulan"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="tipe_tb"
                                                                value="kambuh" id="tb_kambuh" {{ old('tipe_tb', $hivArt->terapiAntiretroviral->tipe_tb) == 'kambuh' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="tb_kambuh">
                                                                <i class="fas fa-redo text-warning me-2"></i>
                                                                2. Kambuh
                                                                <i class="fas fa-info-circle text-muted ms-2"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Sudah sembuh dari TB sebelumnya, kemudian sakit TB lagi"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="tipe_tb"
                                                                value="default" id="tb_default" {{ old('tipe_tb', $hivArt->terapiAntiretroviral->tipe_tb) == 'default' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="tb_default">
                                                                <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                                                                3. Default
                                                                <i class="fas fa-info-circle text-muted ms-2"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Putus berobat lebih dari 2 bulan berturut-turut"></i>
                                                            </label>
                                                        </div>
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input" type="radio" name="tipe_tb"
                                                                value="gagal" id="tb_gagal" {{ old('tipe_tb', $hivArt->terapiAntiretroviral->tipe_tb) == 'gagal' ? 'checked' : '' }} disabled>
                                                            <label class="form-check-label fw-bold" for="tb_gagal">
                                                                <i class="fas fa-times-circle text-danger me-2"></i>
                                                                4. Gagal
                                                                <i class="fas fa-info-circle text-muted ms-2"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="Tidak sembuh setelah menjalani pengobatan lengkap sesuai kategori"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tempat Pengobatan -->
                                            <div class="col-md-6">
                                                <div class="border-start">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 text-info">
                                                            <i class="fas fa-hospital me-2"></i>
                                                            Tempat Pengobatan TB
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold">Kabupaten:</label>
                                                                <input type="text" name="kabupaten_tb" class="form-control"
                                                                    value="{{ old('kabupaten_tb', $hivArt->terapiAntiretroviral->kabupaten_tb) }}"
                                                                    placeholder="Nama kabupaten tempat pengobatan" disabled>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold">Nama Sarana
                                                                    Kesehatan:</label>
                                                                <input type="text" name="nama_sarana_kesehatan"
                                                                    class="form-control"
                                                                    value="{{ old('nama_sarana_kesehatan', $hivArt->terapiAntiretroviral->nama_sarana_kesehatan) }}"
                                                                    placeholder="Nama Puskesmas/RS tempat pengobatan" disabled>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold">No Reg TB
                                                                    Kabupaten/Kota:</label>
                                                                <input type="text" name="no_reg_tb" class="form-control"
                                                                    value="{{ old('no_reg_tb', $hivArt->terapiAntiretroviral->no_reg_tb) }}"
                                                                    placeholder="Nomor registrasi TB" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Indikasi Inisiasi ART -->
                                <div class="card shadow-sm">
                                    <div class="section-header">
                                        <h5 class="mb-0">
                                            8. Indikasi Inisiasi ART
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Info Panel -->
                                        <div class="alert alert-info border-0 mb-4">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <div>
                                                    <strong>Petunjuk Pengisian:</strong><br>
                                                    <small>Pilih salah satu indikasi yang sesuai dengan kondisi pasien untuk
                                                        memulai terapi ART.</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Radio Button Options -->
                                        <div class="row">
                                            <!-- Baris 1 -->
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check p-3 border rounded">
                                                    <input class="form-check-input" type="radio"
                                                        name="indikasi_inisiasi_art" value="penasun" id="penasun" {{ old('indikasi_inisiasi_art', $hivArt->terapiAntiretroviral->indikasi_inisiasi_art) == 'penasun' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label fw-bold" for="penasun">
                                                        <i class="fas fa-syringe text-danger me-2"></i>
                                                        Penasun
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check p-3 border rounded">
                                                    <input class="form-check-input" type="radio"
                                                        name="indikasi_inisiasi_art" value="lsl" id="lsl" {{ old('indikasi_inisiasi_art', $hivArt->terapiAntiretroviral->indikasi_inisiasi_art) == 'lsl' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label fw-bold" for="lsl">
                                                        <i class="fas fa-male text-info me-2"></i>
                                                        LSL
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check p-3 border rounded">
                                                    <input class="form-check-input" type="radio"
                                                        name="indikasi_inisiasi_art" value="pasien_ko_infeksi_tb_hiv"
                                                        id="pasien_ko_infeksi_tb_hiv" {{ old('indikasi_inisiasi_art', $hivArt->terapiAntiretroviral->indikasi_inisiasi_art) == 'pasien_ko_infeksi_tb_hiv' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label fw-bold" for="pasien_ko_infeksi_tb_hiv">
                                                        <i class="fas fa-lungs text-danger me-2"></i>
                                                        Pasien Ko-Infeksi TB-HIV
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Baris 2 -->
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check p-3 border rounded">
                                                    <input class="form-check-input" type="radio"
                                                        name="indikasi_inisiasi_art" value="wps" id="wps" {{ old('indikasi_inisiasi_art', $hivArt->terapiAntiretroviral->indikasi_inisiasi_art) == 'wps' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label fw-bold" for="wps">
                                                        <i class="fas fa-female text-warning me-2"></i>
                                                        WPS
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check p-3 border rounded">
                                                    <input class="form-check-input" type="radio"
                                                        name="indikasi_inisiasi_art" value="waria" id="waria" {{ old('indikasi_inisiasi_art', $hivArt->terapiAntiretroviral->indikasi_inisiasi_art) == 'waria' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label fw-bold" for="waria">
                                                        <i class="fas fa-transgender text-info me-2"></i>
                                                        Waria
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check p-3 border rounded">
                                                    <input class="form-check-input" type="radio"
                                                        name="indikasi_inisiasi_art"
                                                        value="pasien_ko_infeksi_hepatitis_b_hiv"
                                                        id="pasien_ko_infeksi_hepatitis_b_hiv" {{ old('indikasi_inisiasi_art', $hivArt->terapiAntiretroviral->indikasi_inisiasi_art) == 'pasien_ko_infeksi_hepatitis_b_hiv' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label fw-bold"
                                                        for="pasien_ko_infeksi_hepatitis_b_hiv">
                                                        <i class="fas fa-virus text-warning me-2"></i>
                                                        Pasien Ko-Infeksi Hepatitis B-HIV
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Baris 3 -->
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check p-3 border rounded">
                                                    <input class="form-check-input" type="radio"
                                                        name="indikasi_inisiasi_art" value="odha_dengan_pasangan_negatif"
                                                        id="odha_dengan_pasangan_negatif" {{ old('indikasi_inisiasi_art', $hivArt->terapiAntiretroviral->indikasi_inisiasi_art) == 'odha_dengan_pasangan_negatif' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label fw-bold"
                                                        for="odha_dengan_pasangan_negatif">
                                                        <i class="fas fa-heart text-danger me-2"></i>
                                                        ODHA dengan Pasangan Negatif
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check p-3 border rounded">
                                                    <input class="form-check-input" type="radio"
                                                        name="indikasi_inisiasi_art" value="ibu_hamil" id="ibu_hamil" {{ old('indikasi_inisiasi_art', $hivArt->terapiAntiretroviral->indikasi_inisiasi_art) == 'ibu_hamil' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label fw-bold" for="ibu_hamil">
                                                        <i class="fas fa-baby text-success me-2"></i>
                                                        Ibu Hamil
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check p-3 border rounded">
                                                    <input class="form-check-input" type="radio"
                                                        name="indikasi_inisiasi_art" value="lainnya" id="lainnya_indikasi"
                                                        {{ old('indikasi_inisiasi_art', $hivArt->terapiAntiretroviral->indikasi_inisiasi_art) == 'lainnya' ? 'checked' : '' }} disabled>
                                                    <label class="form-check-label fw-bold" for="lainnya_indikasi">
                                                        <i class="fas fa-plus-circle text-secondary me-2"></i>
                                                        Lainnya (Stadium Klinis 3 atau 4 / CD4&lt;350)
                                                    </label>
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
    </div>

    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.show-alergi')
    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.edit-modal-datakeluarga-mitra')
@endsection
