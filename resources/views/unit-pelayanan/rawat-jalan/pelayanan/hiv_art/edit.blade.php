@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.include')

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

                <form id="hivArtEditForm" method="POST"
                    action="{{ route('rawat-jalan.hiv_art.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $hivArt->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-warning text-dark text-center py-3">
                            <h5 class="mb-0 font-weight-bold">EDIT - IKHTISAR PERAWATAN PASIEN HIV DAN TERAPI ANTIRETROVIRAL (ART)</h5>
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
                                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                                    name="tanggal" value="{{ old('tanggal', $hivArt->tanggal ? $hivArt->tanggal->format('Y-m-d') : '') }}">
                                                @error('tanggal')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label fw-bold">Jam</label>
                                                <input type="time" class="form-control @error('jam') is-invalid @enderror"
                                                    name="jam" value="{{ old('jam', $hivArt->jam) }}">
                                                @error('jam')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alergi -->
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0 fw-bold text-primary"><i class="fas fa-allergies"></i> Alergi</h6>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3 mt-2"
                                        id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                        <i class="ti-plus"></i> Tambah Alergi
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="section-separator" id="alergi">
                                                <input type="hidden" name="alergis" id="alergisInput" value="{{ old('alergis', '[]') }}">
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
                                                                <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                            <input type="number" class="form-control @error('no_reg_nas') is-invalid @enderror"
                                                name="no_reg_nas" placeholder="No registrasi Nasional"
                                                value="{{ old('no_reg_nas', $hivArt->no_reg_nas) }}">
                                            @error('no_reg_nas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">NIK</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control @error('nik') is-invalid @enderror"
                                                name="nik" placeholder="Nomor Induk Kependudukan"
                                                value="{{ old('nik', $hivArt->nik) }}">
                                            @error('nik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Nama Ibu Kandung</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control @error('nama_ibu_kandung') is-invalid @enderror"
                                                name="nama_ibu_kandung" placeholder="Nama Ibu Kandung"
                                                value="{{ old('nama_ibu_kandung', $hivArt->nama_ibu_kandung) }}">
                                            @error('nama_ibu_kandung')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Alamat dan No. Telp. Pasien</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control @error('alamat_telp') is-invalid @enderror"
                                                name="alamat_telp" rows="2" placeholder="Alamat dan No. Telp. Pasien">{{ old('alamat_telp', $hivArt->alamat_telp) }}</textarea>
                                            @error('alamat_telp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Nama Pengawas Minum Obat (PMO)</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control @error('pmo') is-invalid @enderror"
                                                name="pmo" placeholder="Nama Pengawas Minum Obat"
                                                value="{{ old('pmo', $hivArt->pmo) }}">
                                            @error('pmo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Hubungannya dgn Pasien</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control @error('hubungan_pasien') is-invalid @enderror"
                                                name="hubungan_pasien" placeholder="Hubungan dengan Pasien"
                                                value="{{ old('hubungan_pasien', $hivArt->hubungan_pasien) }}">
                                            @error('hubungan_pasien')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Alamat dan No. Telp. PMO</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control @error('alamat_no_telp_pmo') is-invalid @enderror"
                                                name="alamat_no_telp_pmo" placeholder="Alamat dan No. Telp. PMO"
                                                value="{{ old('alamat_no_telp_pmo', $hivArt->alamat_no_telp_pmo) }}">
                                            @error('alamat_no_telp_pmo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Tanggal Konfirmasi tes HIV</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="date" class="form-control @error('tgl_tes_hiv') is-invalid @enderror"
                                                name="tgl_tes_hiv" value="{{ old('tgl_tes_hiv', $hivArt->tgl_tes_hiv ? $hivArt->tgl_tes_hiv->format('Y-m-d') : '') }}">
                                            @error('tgl_tes_hiv')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Tempat</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control @error('tempat_tes_hiv') is-invalid @enderror"
                                                name="tempat_tes_hiv" placeholder="Tempat Tes HIV"
                                                value="{{ old('tempat_tes_hiv', $hivArt->tempat_tes_hiv) }}">
                                            @error('tempat_tes_hiv')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold"><i>Entry Point</i></label>
                                        </div>
                                        <div class="col-md-9">
                                            @php
                                                $selectedKiaDetails = old('kia_details', $hivArt->kia_details_array ?? []);
                                                $selectedKiaDetail = is_array($selectedKiaDetails) && count($selectedKiaDetails) > 0 ? $selectedKiaDetails[0] : '';
                                            @endphp

                                            <!-- 1. KIA -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="kia" id="kia"
                                                    name="kia_details[]" {{ $selectedKiaDetail == 'kia' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kia">
                                                    1. KIA
                                                </label>
                                            </div>

                                            <!-- 2-Rujukan Jalan dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="rujukan_jalan_tb"
                                                    id="kia_rujukan_jalan_tb" name="kia_details[]" {{ $selectedKiaDetail == 'rujukan_jalan_tb' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kia_rujukan_jalan_tb">
                                                    2. Rujukan Jalan (TB, Anak, Penyakit Dalam, MIS, Lainnya...)
                                                </label>
                                            </div>
                                            <div id="rujukan-details" class="{{ $selectedKiaDetail == 'rujukan_jalan_tb' ? '' : 'd-none' }} bg-light p-3 mb-3 rounded">
                                                <textarea class="form-control" name="rujukan_keterangan" rows="2"
                                                    placeholder="Sebutkan detail...">{{ old('rujukan_keterangan', $hivArt->rujukan_keterangan) }}</textarea>
                                            </div>

                                            <!-- 3-Rawat Inap -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="rujukan_rawat_inap"
                                                    id="kia_rawat_inap" name="kia_details[]" {{ $selectedKiaDetail == 'rujukan_rawat_inap' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kia_rawat_inap">
                                                    3. Rawat Inap
                                                </label>
                                            </div>

                                            <!-- 4-Praktek Swasta -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="praktek_swasta"
                                                    id="kia_praktek_swasta" name="kia_details[]" {{ $selectedKiaDetail == 'praktek_swasta' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kia_praktek_swasta">
                                                    4. Praktek Swasta
                                                </label>
                                            </div>

                                            <!-- 5-Jangkauan dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="jangkauan"
                                                    id="kia_jangkauan" name="kia_details[]" {{ $selectedKiaDetail == 'jangkauan' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kia_jangkauan">
                                                    5. Jangkauan (Penasun, WPS, LSL, ...)
                                                </label>
                                            </div>
                                            <div id="jangkauan-details" class="{{ $selectedKiaDetail == 'jangkauan' ? '' : 'd-none' }} bg-light p-3 mb-3 rounded">
                                                <textarea class="form-control" name="jangkauan_keterangan" rows="2"
                                                    placeholder="Sebutkan detail jangkauan...">{{ old('jangkauan_keterangan', $hivArt->jangkauan_keterangan) }}</textarea>
                                            </div>

                                            <!-- 6-LSM -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="lsm" id="kia_lsm"
                                                    name="kia_details[]" {{ $selectedKiaDetail == 'lsm' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kia_lsm">
                                                    6. LSM
                                                </label>
                                            </div>

                                            <!-- 7-Datang sendiri -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="datang_sendiri"
                                                    id="kia_datang_sendiri" name="kia_details[]" {{ $selectedKiaDetail == 'datang_sendiri' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kia_datang_sendiri">
                                                    7. Datang sendiri
                                                </label>
                                            </div>

                                            <!-- 8-Lainnya dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" value="lainnya_uraikan"
                                                    id="kia_lainnya" name="kia_details[]" {{ $selectedKiaDetail == 'lainnya_uraikan' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kia_lainnya">
                                                    8. Lainnya, uraikan...
                                                </label>
                                            </div>
                                            <div id="lainnya-kia-details" class="{{ $selectedKiaDetail == 'lainnya_uraikan' ? '' : 'd-none' }} bg-light p-3 mb-3 rounded">
                                                <textarea class="form-control" name="lainnya_kia_keterangan" rows="2"
                                                    placeholder="Sebutkan lainnya...">{{ old('lainnya_kia_keterangan', $hivArt->lainnya_kia_keterangan) }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

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
                                            <select class="form-select @error('pendidikan') is-invalid @enderror" name="pendidikan">
                                                <option value="">--pilih--</option>
                                                <option value="0" {{ old('pendidikan', $hivArt->pendidikan) == '0' ? 'selected' : '' }}>Tidak Sekolah</option>
                                                <option value="1" {{ old('pendidikan', $hivArt->pendidikan) == '1' ? 'selected' : '' }}>SD</option>
                                                <option value="2" {{ old('pendidikan', $hivArt->pendidikan) == '2' ? 'selected' : '' }}>SMP</option>
                                                <option value="3" {{ old('pendidikan', $hivArt->pendidikan) == '3' ? 'selected' : '' }}>SMU</option>
                                                <option value="4" {{ old('pendidikan', $hivArt->pendidikan) == '4' ? 'selected' : '' }}>Akademi/PT</option>
                                            </select>
                                            @error('pendidikan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Kerja</label>
                                        </div>
                                        <div class="col-md-9">
                                            <select class="form-select @error('pekerjaan') is-invalid @enderror" name="pekerjaan">
                                                <option value="">--pilih--</option>
                                                <option value="0" {{ old('pekerjaan', $hivArt->pekerjaan) == '0' ? 'selected' : '' }}>Tidak Bekerja</option>
                                                <option value="1" {{ old('pekerjaan', $hivArt->pekerjaan) == '1' ? 'selected' : '' }}>Bekerja</option>
                                                <option value="2" {{ old('pekerjaan', $hivArt->pekerjaan) == '2' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                            @error('pekerjaan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Faktor Risiko</label>
                                        </div>
                                        <div class="col-md-9">
                                            @php
                                                $selectedFaktorRisiko = old('faktor_risiko', $hivArt->faktor_risiko_array ?? []);
                                            @endphp

                                            <!-- Seks Vaginal Berisiko -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox"
                                                    value="Seks Vaginal Berisiko" id="seks_vaginal" name="faktor_risiko[]"
                                                    {{ in_array('Seks Vaginal Berisiko', $selectedFaktorRisiko) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="seks_vaginal">
                                                    Seks Vaginal Berisiko
                                                </label>
                                            </div>

                                            <!-- Seks Anal Berisiko -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="Seks Anal Berisiko"
                                                    id="seks_anal" name="faktor_risiko[]"
                                                    {{ in_array('Seks Anal Berisiko', $selectedFaktorRisiko) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="seks_anal">
                                                    Seks Anal Berisiko
                                                </label>
                                            </div>

                                            <!-- Perinatal -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="Perinatal"
                                                    id="perinatal" name="faktor_risiko[]"
                                                    {{ in_array('Perinatal', $selectedFaktorRisiko) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perinatal">
                                                    Perinatal
                                                </label>
                                            </div>

                                            <!-- Transfusi Darah -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="Transfusi Darah"
                                                    id="transfusi_darah" name="faktor_risiko[]"
                                                    {{ in_array('Transfusi Darah', $selectedFaktorRisiko) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="transfusi_darah">
                                                    Transfusi Darah
                                                </label>
                                            </div>

                                            <!-- NAPZA Suntik -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="NAPZA Suntik"
                                                    id="napza_suntik" name="faktor_risiko[]"
                                                    {{ in_array('NAPZA Suntik', $selectedFaktorRisiko) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="napza_suntik">
                                                    NAPZA Suntik
                                                </label>
                                            </div>

                                            <!-- Lain-lainnya dengan input tambahan -->
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" value="Lain-lainnya"
                                                    id="lain_lainnya" name="faktor_risiko[]"
                                                    {{ in_array('Lain-lainnya', $selectedFaktorRisiko) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="lain_lainnya">
                                                    Lain-lain, Uraikan...
                                                </label>
                                            </div>
                                            <div id="lain-lainnya-details" class="{{ in_array('Lain-lainnya', $selectedFaktorRisiko) ? '' : 'd-none' }} bg-light p-3 mb-3 rounded">
                                                <textarea class="form-control" name="lain_lainnya_keterangan" rows="2"
                                                    placeholder="Sebutkan faktor risiko lainnya...">{{ old('lain_lainnya_keterangan', $hivArt->lain_lainnya_keterangan) }}</textarea>
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
                                                    name="status_pernikahan" value="Menikah"
                                                    {{ old('status_pernikahan', $hivArt->status_pernikahan) == 'Menikah' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inlineCheckbox1">Menikah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inlineCheckbox2"
                                                    name="status_pernikahan" value="Belum Menikah"
                                                    {{ old('status_pernikahan', $hivArt->status_pernikahan) == 'Belum Menikah' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inlineCheckbox2">Belum Menikah</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inlineCheckbox3"
                                                    name="status_pernikahan" value="Janda/Duda"
                                                    {{ old('status_pernikahan', $hivArt->status_pernikahan) == 'Janda/Duda' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inlineCheckbox3">Janda/Duda</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">Data Keluarga / Mitra</h6>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#tambahMitraModal">
                                                    <i class="fas fa-plus"></i> Tambah
                                                </button>
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
                                                            <th width="10%">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="no-data-row">
                                                            <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- Hidden input untuk mengirim JSON ke backend -->
                                                <input type="hidden" name="data_keluarga" id="dataKeluargaInput"
                                                    value="{{ old('data_keluarga', $hivArt->data_keluarga) }}">
                                                <input type="hidden" id="existing-mitra-data"
                                                    value="{{ json_encode($hivArt->data_keluarga_array ?? []) }}">
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
                                                <input class="form-check-input" type="radio" id="menerima_art_ya" value="Ya"
                                                    name="menerima_art" {{ old('menerima_art', $hivArt->menerima_art) == 'Ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="menerima_art_ya">1. Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="menerima_art_tidak"
                                                    value="Tidak" name="menerima_art" {{ old('menerima_art', $hivArt->menerima_art) == 'Tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="menerima_art_tidak">2. Tidak</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detail ART -->
                                    <div id="art_details" class="art-details" style="display: {{ old('menerima_art', $hivArt->menerima_art) == 'Ya' ? 'block' : 'none' }};">
                                        <!-- Jika ya, pilih jenis -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Jika ya</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="ppia" value="PPIA"
                                                        name="jenis_art" {{ old('jenis_art', $hivArt->jenis_art) == 'PPIA' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="ppia">1. PPIA</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="art" value="ART"
                                                        name="jenis_art" {{ old('jenis_art', $hivArt->jenis_art) == 'ART' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="art">2. ART</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="ppp" value="PPP"
                                                        name="jenis_art" {{ old('jenis_art', $hivArt->jenis_art) == 'PPP' ? 'checked' : '' }}>
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
                                                        value="RS Pemerintah" name="tempat_art" {{ old('tempat_art', $hivArt->tempat_art) == 'RS Pemerintah' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="rs_pemerintah">1. RS Pem</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="rs_swasta"
                                                        value="RS Swasta" name="tempat_art" {{ old('tempat_art', $hivArt->tempat_art) == 'RS Swasta' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="rs_swasta">2. RS Swasta</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" id="pkm" value="PKM"
                                                        name="tempat_art" {{ old('tempat_art', $hivArt->tempat_art) == 'PKM' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pkm">3. PKM</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Nama, dosis ARV & lama penggunaannya -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label fw-bold">Nama, dosis ARV & lama penggunaannya</label>
                                            </div>
                                            <div class="col-md-9">
                                                <textarea class="form-control @error('nama_dosis_arv') is-invalid @enderror"
                                                    name="nama_dosis_arv" rows="4"
                                                    placeholder="Sebutkan nama obat ARV, dosis, dan lama penggunaan secara detail...">{{ old('nama_dosis_arv', $hivArt->nama_dosis_arv) }}</textarea>
                                                @error('nama_dosis_arv')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Include pemeriksaan klinis section from create.blade.php -->
                            @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.partials.pemeriksaan-klinis-edit', ['hivArt' => $hivArt])

                            <!-- Include terapi ART section from create.blade.php -->
                            @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.partials.terapi-art-edit', ['hivArt' => $hivArt])

                            <!-- Include TB section from create.blade.php -->
                            @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.partials.tb-edit', ['hivArt' => $hivArt])

                            <!-- Include indikasi section from create.blade.php -->
                            @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.partials.indikasi-edit', ['hivArt' => $hivArt])

                        </div>

                        <!-- Form Buttons -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.modal-create-alergi')
    @include('unit-pelayanan.rawat-jalan.pelayanan.hiv_art.modal-datakeluarga-mitra')
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show/hide ART details based on selection
    const artRadios = document.querySelectorAll('input[name="menerima_art"]');
    const artDetails = document.getElementById('art_details');

    artRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'Ya') {
                artDetails.style.display = 'block';
            } else {
                artDetails.style.display = 'none';
            }
        });
    });

    // Show/hide entry point details based on selection
    const entryPointRadios = document.querySelectorAll('input[name="kia_details[]"]');
    entryPointRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Hide all detail sections
            document.getElementById('rujukan-details').classList.add('d-none');
            document.getElementById('jangkauan-details').classList.add('d-none');
            document.getElementById('lainnya-kia-details').classList.add('d-none');

            // Show relevant detail section
            if (this.value === 'rujukan_jalan_tb') {
                document.getElementById('rujukan-details').classList.remove('d-none');
            } else if (this.value === 'jangkauan') {
                document.getElementById('jangkauan-details').classList.remove('d-none');
            } else if (this.value === 'lainnya_uraikan') {
                document.getElementById('lainnya-kia-details').classList.remove('d-none');
            }
        });
    });

    // Show/hide factor risiko details
    const faktorrisikoCheckbox = document.getElementById('lain_lainnya');
    if (faktorrisikoCheckbox) {
        faktorrisikoCheckbox.addEventListener('change', function() {
            const details = document.getElementById('lain-lainnya-details');
            if (this.checked) {
                details.classList.remove('d-none');
            } else {
                details.classList.add('d-none');
            }
        });
    }

    // TB classification change event
    const tbEkstraRadio = document.getElementById('tb_ekstra_paru');
    if (tbEkstraRadio) {
        document.querySelectorAll('input[name="klasifikasi_tb"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const lokasiTbEkstra = document.getElementById('lokasi_tb_ekstra');
                if (this.value === 'tb_ekstra_paru') {
                    lokasiTbEkstra.classList.remove('d-none');
                } else {
                    lokasiTbEkstra.classList.add('d-none');
                }
            });
        });
    }
});
</script>
@endpush
