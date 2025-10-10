@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.include-edit')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                    @include('components.page-header', [
                        'title' => 'Detail Asesmen Awal Keperawatan Rawat Inap Dewasa',
                        'description' =>
                        'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                    ])
                    <form method="" action="" class="d-flex flex-column gap-4">
                        @csrf
                        <div class="section-separator" id="data-umum">
                            <h5 class="section-title">1. DATA UMUM</h5>

                            <!-- Tanggal dan Jam Masuk -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Tanggal dan Jam Masuk:</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="date" class="form-control" name="tanggal" id="tanggal_masuk"
                                                value="{{ old('tanggal', $asesmen->asesmenKetDewasaRanap->tanggal ?? date('Y-m-d')) }}"
                                                required disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="time" class="form-control" name="jam" id="jam_masuk"
                                                value="{{ old('jam', $asesmen->asesmenKetDewasaRanap->jam ? substr($asesmen->asesmenKetDewasaRanap->jam, 0, 5) : date('H:i')) }}"
                                                required disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vital Signs -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nadi:</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" name="nadi"
                                            value="{{ $asesmen->asesmenKetDewasaRanap->nadi }}" disabled>
                                        <span class="input-group-text">kali/mnt</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Sistole:</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" name="sistole"
                                            value="{{ $asesmen->asesmenKetDewasaRanap->sistole }}" disabled>
                                        <span class="input-group-text">mmHg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Distole:</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" name="distole"
                                            value="{{ $asesmen->asesmenKetDewasaRanap->sistole }}" disabled>
                                        <span class="input-group-text">mmHg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nafas:</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" name="nafas"
                                            value="{{ $asesmen->asesmenKetDewasaRanap->nafas }}" disabled>
                                        <span class="input-group-text">kali/mnt</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Suhu:</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input type="text" step="0.1" class="form-control" name="suhu"
                                            value="{{ $asesmen->asesmenKetDewasaRanap->suhu }}" disabled>
                                        <span class="input-group-text">°C</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">SaO2:</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" name="sao2"
                                            value="{{ $asesmen->asesmenKetDewasaRanap->sao2 }}" disabled>
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">TB:</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input type="number" class="form-control" name="tb"
                                            value="{{ $asesmen->asesmenKetDewasaRanap->tb }}" disabled>
                                        <span class="input-group-text">cm</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">BB:</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-2">
                                        <input type="number" step="0.1" class="form-control" name="bb"
                                            value="{{ $asesmen->asesmenKetDewasaRanap->bb }}" disabled>
                                        <span class="input-group-text">Kg</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Status:</label>
                                <div class="col-sm-9">
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="status[]"
                                                id="berdiri" value="berdiri"
                                                {{ in_array('berdiri', old('status', $asesmen->asesmenKetDewasaRanap->status ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="berdiri">Berdiri</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="status[]"
                                                id="tidur" value="tidur"
                                                {{ in_array('tidur', old('status', $asesmen->asesmenKetDewasaRanap->status ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="tidur">Tidur</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="status[]"
                                                id="duduk" value="duduk"
                                                {{ in_array('duduk', old('status', $asesmen->asesmenKetDewasaRanap->status ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="duduk">Duduk</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kondisi saat masuk -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Kondisi saat masuk:</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="kondisi_masuk"
                                            id="mandiri" value="mandiri"
                                            {{ old('kondisi_masuk', $asesmen->asesmenKetDewasaRanap->kondisi_masuk ?? '') === 'mandiri' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="mandiri">Mandiri</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="kondisi_masuk"
                                            id="tempat_tidur" value="tempat_tidur"
                                            {{ old('kondisi_masuk', $asesmen->asesmenKetDewasaRanap->kondisi_masuk ?? '') === 'tempat_tidur' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="tempat_tidur">Tempat tidur</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="kondisi_masuk"
                                            id="lainnya_kondisi" value="lainnya"
                                            {{ old('kondisi_masuk', $asesmen->asesmenKetDewasaRanap->kondisi_masuk ?? '') === 'lainnya' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="lainnya_kondisi">Lainnya:</label>
                                        <input type="text" class="form-control d-inline-block ms-2"
                                            name="kondisi_masuk_lainnya" style="width: 300px;"
                                            value="{{ old('kondisi_masuk_lainnya', $asesmen->asesmenKetDewasaRanap->kondisi_masuk_lainnya ?? '') }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Dokter DPJP -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Dokter (DPJP):</label>
                                <div class="col-sm-9">
                                    <select name="kd_dokter" id="kd_dokter" class="form-select select2" required
                                        disabled>
                                        <option value="">--Pilih--</option>
                                        @foreach ($dokter as $dok)
                                            <option value="{{ $dok->kd_dokter }}"
                                                {{ old('kd_dokter', $asesmen->asesmenKetDewasaRanap->kd_dokter ?? '') == $dok->kd_dokter ? 'selected' : '' }}>
                                                {{ $dok->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Diagnosis masuk -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Diagnosis masuk:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="diagnosis_masuk" rows="3" disabled>{{ old('diagnosis_masuk', $asesmen->asesmenKetDewasaRanap->diagnosis_masuk ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- Keluhan utama -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Keluhan utama:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="keluhan_utama" rows="3" disabled>{{ old('keluhan_utama', $asesmen->asesmenKetDewasaRanap->keluhan_utama ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- Barang berharga -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Barang berharga:</label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="barang_berharga"
                                            id="perhiasan" value="perhiasan"
                                            {{ old('barang_berharga', $asesmen->asesmenKetDewasaRanap->barang_berharga ?? '') === 'perhiasan' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="perhiasan">Perhiasan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="barang_berharga"
                                            id="uang" value="uang"
                                            {{ old('barang_berharga', $asesmen->asesmenKetDewasaRanap->barang_berharga ?? '') === 'uang' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="uang">Uang</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="barang_berharga"
                                            id="lainnya_barang" value="lainnya"
                                            {{ old('barang_berharga', $asesmen->asesmenKetDewasaRanap->barang_berharga ?? '') === 'lainnya' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="lainnya_barang">Lainnya:</label>
                                        <input type="text" class="form-control d-inline-block ms-2"
                                            name="barang_berharga_lainnya" style="width: 200px;"
                                            value="{{ old('barang_berharga_lainnya', $asesmen->asesmenKetDewasaRanap->barang_berharga_lainnya ?? '') }}"
                                            disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Alat bantu yang digunakan -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Alat bantu yang digunakan:</label>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data_umum_alat_bantu[]"
                                            id="kacamata" value="kacamata"
                                            {{ in_array('kacamata', old('data_umum_alat_bantu', $asesmen->asesmenKetDewasaRanap->data_umum_alat_bantu ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="kacamata">Kacamata</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data_umum_alat_bantu[]"
                                            id="lensa_kontak" value="lensa_kontak"
                                            {{ in_array('lensa_kontak', old('data_umum_alat_bantu', $asesmen->asesmenKetDewasaRanap->data_umum_alat_bantu ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="lensa_kontak">Lensa kontak</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data_umum_alat_bantu[]"
                                            id="gigi_palsu" value="gigi_palsu"
                                            {{ in_array('gigi_palsu', old('data_umum_alat_bantu', $asesmen->asesmenKetDewasaRanap->data_umum_alat_bantu ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="gigi_palsu">Gigi palsu</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="data_umum_alat_bantu[]"
                                            id="alat_bantu_dengar" value="alat_bantu_dengar"
                                            {{ in_array('alat_bantu_dengar', old('data_umum_alat_bantu', $asesmen->asesmenKetDewasaRanap->data_umum_alat_bantu ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="alat_bantu_dengar">Alat bantu dengar</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-separator" id="alergi">
                            <h5 class="section-title">2. Alergi</h5>
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
                                            <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @push('modals')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-show-alergi')
                            @endpush
                        </div>

                        <div class="section-separator" id="riwayat-pasien">
                            <h5 class="section-title">3. RIWAYAT PASIEN</h5>

                            <div class="col-12 mb-3">
                                <h6 class="fw-bold">Riwayat pasien: (penyakit utama/ operasi/ cidera mayor)</h6>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_hypertensi" value="hypertensi"
                                            {{ in_array('hypertensi', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_hypertensi">Hypertensi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_infark_myiokard" value="infark_myiokard"
                                            {{ in_array('infark_myiokard', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_infark_myiokard">Infark
                                            myiokard</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_stroke" value="stroke"
                                            {{ in_array('stroke', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_stroke">Stroke</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_jantung_koroner" value="jantung_koroner"
                                            {{ in_array('jantung_koroner', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_jantung_koroner">Jantung
                                            koroner</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_opok" value="opok"
                                            {{ in_array('opok', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_opok">PPOK</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_asthma" value="asthma"
                                            {{ in_array('asthma', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_asthma">Asthma</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_tb" value="tb"
                                            {{ in_array('tb', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_tb">TB</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_penyakit_paru_lainnya" value="penyakit_paru_lainnya"
                                            {{ in_array('penyakit_paru_lainnya', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="riwayat_pasien_penyakit_paru_lainnya">Penyakit
                                            paru lainnya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_diabetes_mellitus" value="diabetes_mellitus"
                                            {{ in_array('diabetes_mellitus', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_diabetes_mellitus">Diabetes
                                            Mellitus</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_hepatitis" value="hepatitis"
                                            {{ in_array('hepatitis', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_hepatitis">Hepatitis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_ulkus" value="ulkus"
                                            {{ in_array('ulkus', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_ulkus">Ulkus</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_gagal_ginjal" value="gagal_ginjal"
                                            {{ in_array('gagal_ginjal', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_gagal_ginjal">Gagal
                                            ginjal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_kanker" value="kanker"
                                            {{ in_array('kanker', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_kanker">Kanker</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_kejang" value="kejang"
                                            {{ in_array('kejang', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_kejang">Kejang</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_pasien[]"
                                            id="riwayat_pasien_jiwa" value="jiwa"
                                            {{ in_array('jiwa', old('riwayat_pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_pasien_jiwa">Jiwa</label>
                                    </div>

                                </div>
                                <label class="form-check-label mt-2" for="lainnya">Lainnya</label>
                                <input type="text" class="form-control" name="riwayat_pasien_lain"
                                    value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_pasien_lain }}"
                                    disabled>
                            </div>

                            <!-- Riwayat Alkohol/Obat dan Merokok -->
                            @php
                                // prepare arrays (may be JSON string in DB)
                                $alkoholObat = $asesmen->asesmenKetDewasaRanapRiwayatPasien->alkohol_obat ?? '';
                                $alkoholJenis = $asesmen->asesmenKetDewasaRanapRiwayatPasien->alkohol_jenis ?? null;
                                $alkoholJumlah = $asesmen->asesmenKetDewasaRanapRiwayatPasien->alkohol_jumlah ?? null;

                                if (is_string($alkoholJenis) && $alkoholJenis !== '') {
                                    $alkoholJenis = json_decode($alkoholJenis, true) ?: [];
                                }
                                if (!is_array($alkoholJenis)) {
                                    $alkoholJenis = (array) $alkoholJenis;
                                }

                                if (is_string($alkoholJumlah) && $alkoholJumlah !== '') {
                                    $alkoholJumlah = json_decode($alkoholJumlah, true) ?: [];
                                }
                                if (!is_array($alkoholJumlah)) {
                                    $alkoholJumlah = (array) $alkoholJumlah;
                                }

                                $merokok = $asesmen->asesmenKetDewasaRanapRiwayatPasien->merokok ?? '';
                                $merokokJenis = $asesmen->asesmenKetDewasaRanapRiwayatPasien->merokok_jenis ?? null;
                                $merokokJumlah = $asesmen->asesmenKetDewasaRanapRiwayatPasien->merokok_jumlah ?? null;

                                if (is_string($merokokJenis) && $merokokJenis !== '') {
                                    $merokokJenis = json_decode($merokokJenis, true) ?: [];
                                }
                                if (!is_array($merokokJenis)) {
                                    $merokokJenis = (array) $merokokJenis;
                                }

                                if (is_string($merokokJumlah) && $merokokJumlah !== '') {
                                    $merokokJumlah = json_decode($merokokJumlah, true) ?: [];
                                }
                                if (!is_array($merokokJumlah)) {
                                    $merokokJumlah = (array) $merokokJumlah;
                                }

                                $alkoholCount = max(1, max(count($alkoholJenis), count($alkoholJumlah)));
                                $merokokCount = max(1, max(count($merokokJenis), count($merokokJumlah)));
                            @endphp

                            <div class="col-12 mb-3 section-separator">
                                <h6 class="fw-bold">Riwayat Konsumsi</h6>

                                <div class="d-flex flex-column gap-4">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Alkohol/obat:</label>
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled
                                                    {{ $alkoholObat === 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label">Tidak</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled
                                                    {{ $alkoholObat === 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled
                                                    {{ $alkoholObat === 'berhenti' ? 'checked' : '' }}>
                                                <label class="form-check-label">Berhenti</label>
                                            </div>
                                        </div>

                                        <div class="alkohol-detail"
                                            style="display: {{ $alkoholObat === 'ya' ? 'block' : 'none' }};">
                                            <div id="alkoholContainerShow">
                                                @for ($i = 0; $i < $alkoholCount; $i++)
                                                    <div class="d-flex gap-2 align-items-center mb-2">
                                                        <div class="col">
                                                            <label class="form-label mb-1">Jenis:</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                readonly value="{{ $alkoholJenis[$i] ?? '' }}">
                                                        </div>
                                                        <div class="col">
                                                            <label class="form-label mb-1">Jumlah/hari:</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                readonly value="{{ $alkoholJumlah[$i] ?? '' }}">
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Merokok:</label>
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled
                                                    {{ $merokok === 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label">Tidak</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled
                                                    {{ $merokok === 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled
                                                    {{ $merokok === 'berhenti' ? 'checked' : '' }}>
                                                <label class="form-check-label">Berhenti</label>
                                            </div>
                                        </div>

                                        <div class="merokok-detail"
                                            style="display: {{ $merokok === 'ya' ? 'block' : 'none' }};">
                                            <div id="merokokContainerShow">
                                                @for ($i = 0; $i < $merokokCount; $i++)
                                                    <div class="d-flex gap-2 align-items-center mb-2">
                                                        <div class="col">
                                                            <label class="form-label mb-1">Jenis:</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                readonly value="{{ $merokokJenis[$i] ?? '' }}">
                                                        </div>
                                                        <div class="col">
                                                            <label class="form-label mb-1">Jumlah/hari:</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                readonly value="{{ $merokokJumlah[$i] ?? '' }}">
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Riwayat Keluarga -->
                            <div class="col-12 mb-3 section-separator">
                                <h6 class="fw-bold">Riwayat keluarga</h6>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_penyakit_jantung" value="penyakit_jantung"
                                            {{ in_array('penyakit_jantung', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_penyakit_jantung">Penyakit
                                            jantung</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_hypertensi" value="hypertensi"
                                            {{ in_array('hypertensi', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="riwayat_keluarga_hypertensi">Hypertensi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_stroke" value="stroke"
                                            {{ in_array('stroke', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_stroke">Stroke</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_asthma" value="asthma"
                                            {{ in_array('asthma', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_asthma">Asthma</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_gangguan_jiwa" value="gangguan_jiwa"
                                            {{ in_array('gangguan_jiwa', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_gangguan_jiwa">Gangguan
                                            jiwa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_gagal_ginjal" value="gagal_ginjal"
                                            {{ in_array('gagal_ginjal', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_gagal_ginjal">Gagal
                                            ginjal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_lainnya_checkbox" value="lainnya"
                                            {{ in_array('lainnya', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="riwayat_keluarga_lainnya_checkbox">Lainnya</label>
                                    </div>
                                </div>

                                <!-- Baris kedua -->
                                <div class="d-flex flex-wrap gap-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_kanker" value="kanker"
                                            {{ in_array('kanker', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_kanker">Kanker</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_kejang" value="kejang"
                                            {{ in_array('kejang', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_kejang">Kejang</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_gangguan_hematologi" value="gangguan_hematologi"
                                            {{ in_array('gangguan_hematologi', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="riwayat_keluarga_gangguan_hematologi">Gangguan hematologi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_diabetes" value="diabetes"
                                            {{ in_array('diabetes', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_diabetes">Diabetes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_hepatitis" value="hepatitis"
                                            {{ in_array('hepatitis', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_hepatitis">Hepatitis</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="riwayat_keluarga[]"
                                            id="riwayat_keluarga_tb" value="tb"
                                            {{ in_array('tb', old('riwayat_keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="riwayat_keluarga_tb">TB</label>
                                    </div>
                                </div>

                                <!-- Input untuk Diabetes Lainnya -->
                                <div class="mt-2" id="diabetes_lainnya_container">
                                    <label class="form-label">Diabetes Lainnya:</label>
                                    <input type="text" class="form-control" name="diabetes_lainnya"
                                        value="{{ old('diabetes_lainnya', $asesmen->asesmenKetDewasaRanapRiwayatPasien->diabetes_lainnya ?? '') }}"
                                        disabled>
                                </div>
                            </div>

                            <!-- Psikososial/Ekonomi -->
                            <div class="section-separator" id="psikososial-ekonomi">
                                <h5 class="section-title">Psikososial/ ekonomi</h5>

                                <!-- Status pernikahan -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Status pernikahan:</label>
                                    <div class="col-sm-9">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_status_pernikahan" id="menikah" value="menikah"
                                                    {{ old('menikah', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_status_pernikahan ?? '') === 'menikah' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="menikah">Menikah</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_status_pernikahan" id="belum_menikah"
                                                    value="belum_menikah"
                                                    {{ old('belum_menikah', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_status_pernikahan ?? '') === 'belum_menikah' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="belum_menikah">Belum menikah</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_status_pernikahan" id="duda_janda"
                                                    value="duda_janda"
                                                    {{ old('duda_janda', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_status_pernikahan ?? '') === 'duda_janda' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="duda_janda">Duda/janda</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Keluarga -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Keluarga:</label>
                                    <div class="col-sm-9">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_keluarga" id="tinggal_serumah"
                                                    value="tinggal_serumah"
                                                    {{ old('tinggal_serumah', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_keluarga ?? '') === 'tinggal_serumah' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="tinggal_serumah">Tinggal
                                                    serumah</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_keluarga" id="tinggal_sendiri"
                                                    value="tinggal_sendiri"
                                                    {{ old('tinggal_sendiri', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_keluarga ?? '') === 'tinggal_sendiri' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="tinggal_sendiri">Tinggal
                                                    sendiri</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tempat tinggal -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Tempat tinggal:</label>
                                    <div class="col-sm-9">
                                        <div class="d-flex flex-wrap gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_tempat_tinggal" id="rumah" value="rumah"
                                                    {{ old('rumah', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_tempat_tinggal ?? '') === 'rumah' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="rumah">Rumah</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_tempat_tinggal" id="panti_asuhan"
                                                    value="panti_asuhan"
                                                    {{ old('panti_asuhan', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_tempat_tinggal ?? '') === 'panti_asuhan' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="panti_asuhan">Panti asuhan</label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_tempat_tinggal" id="tempat_tinggal_lainnya"
                                                    value="lainnya"
                                                    {{ old('lainnya', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_tempat_tinggal ?? '') === 'lainnya' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label me-2"
                                                    for="tempat_tinggal_lainnya">Lainnya:</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="psikososial_lainnya" style="width: 200px;"
                                                    value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_lainnya }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pekerjaan -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Pekerjaan:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="psikososial_pekerjaan"
                                            value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_pekerjaan }}"
                                            disabled>
                                    </div>
                                </div>

                                <!-- Aktivitas -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Aktivitas:</label>
                                    <div class="col-sm-9">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="psikososial_aktivitas[]" id="purnawaktu" value="purnawaktu"
                                                    {{ in_array('purnawaktu', old('psikososial_aktivitas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="purnawaktu">Purnawaktu</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="psikososial_aktivitas[]" id="paruh_waktu" value="paruh_waktu"
                                                    {{ in_array('paruh_waktu', old('psikososial_aktivitas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="paruh_waktu">Paruh waktu</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="psikososial_aktivitas[]" id="pensiunan" value="pensiunan"
                                                    {{ in_array('pensiunan', old('psikososial_aktivitas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="pensiunan">Pensiunan</label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input" type="checkbox"
                                                    name="psikososial_aktivitas[]" id="aktivitas_lainnya" value="lainnya"
                                                    {{ in_array('lainnya', old('psikososial_aktivitas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label me-2"
                                                    for="aktivitas_lainnya">Lainnya:</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="psikososial_aktivitas_lain" style="width: 150px;"
                                                    value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas_lain }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-wrap gap-3 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="psikososial_aktivitas[]" id="aktivitas_mandiri" value="mandiri"
                                                    {{ in_array('mandiri', old('psikososial_aktivitas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="aktivitas_mandiri">Mandiri</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="psikososial_aktivitas[]" id="tongkat" value="tongkat"
                                                    {{ in_array('tongkat', old('psikososial_aktivitas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="tongkat">Tongkat</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="psikososial_aktivitas[]" id="kursi_roda" value="kursi_roda"
                                                    {{ in_array('kursi_roda', old('psikososial_aktivitas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="kursi_roda">Kursi roda</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="psikososial_aktivitas[]" id="tirah_baring" value="tirah_baring"
                                                    {{ in_array('tirah_baring', old('psikososial_aktivitas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="tirah_baring">Tirah baring</label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input" type="checkbox"
                                                    name="psikososial_aktivitas[]" id="aktivitas_lainnya2"
                                                    value="lainnya2"
                                                    {{ in_array('lainnya2', old('psikososial_aktivitas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label me-2"
                                                    for="aktivitas_lainnya2">Lainnya:</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="psikososial_aktivitas_lainnya2" style="width: 150px;"
                                                    value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_aktivitas_lainnya2 }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Curiga penganiayaan/penelantaran -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Curiga penganiayaan/penelantaran:</label>
                                    <div class="col-sm-9">
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_curiga_penganiayaan" id="curiga_ya" value="ya"
                                                    {{ old('ya', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_curiga_penganiayaan ?? '') === 'ya' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="curiga_ya">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_curiga_penganiayaan" id="curiga_tidak"
                                                    value="tidak"
                                                    {{ old('tidak', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_curiga_penganiayaan ?? '') === 'tidak' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="curiga_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status emosional -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Status emosional:</label>
                                    <div class="col-sm-9">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_status_emosional" id="kooperatif"
                                                    value="kooperatif"
                                                    {{ old('kooperatif', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_status_emosional ?? '') === 'kooperatif' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="kooperatif">Kooperatif</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_status_emosional" id="cemas" value="cemas"
                                                    {{ old('cemas', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_status_emosional ?? '') === 'cemas' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="cemas">Cemas</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_status_emosional" id="depresi" value="depresi"
                                                    {{ old('depresi', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_status_emosional ?? '') === 'depresi' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="depresi">Depresi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_status_emosional" id="ingin_mengakhiri_hidup"
                                                    value="ingin_mengakhiri_hidup"
                                                    {{ old('ingin_mengakhiri_hidup', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_status_emosional ?? '') === 'ingin_mengakhiri_hidup' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="ingin_mengakhiri_hidup">Ingin
                                                    mengakhiri hidup</label>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input" type="radio"
                                                    name="psikososial_status_emosional" id="status_emosional_lainnya"
                                                    value="lainnya"
                                                    {{ old('lainnya', $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_status_emosional ?? '') === 'lainnya' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label me-2"
                                                    for="status_emosional_lainnya">Lainnya:</label>
                                                <input type="text" class="form-control form-control-sm d-inline-block"
                                                    name="psikososial_status_emosional_lainnya" style="width: 300px;"
                                                    value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->psikososial_status_emosional_lainnya }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Keluarga terdekat -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Keluarga terdekat:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="keluarga_terdekat_nama"
                                            value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->keluarga_terdekat_nama }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Hubungan:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="keluarga_terdekat_hubungan"
                                            value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->keluarga_terdekat_hubungan }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Telepon:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="keluarga_terdekat_telepon"
                                            value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->keluarga_terdekat_telepon }}"
                                            disabled>
                                    </div>
                                </div>


                                <!-- Informasi didapat dari -->
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Informasi didapat dari:</label>
                                    <div class="col-sm-9">
                                        <div class="d-flex flex-wrap gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="informasi_didapat_dari" id="pasien" value="pasien"
                                                    {{ old('pasien', $asesmen->asesmenKetDewasaRanapRiwayatPasien->informasi_didapat_dari ?? '') === 'pasien' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="pasien">Pasien</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="informasi_didapat_dari" id="keluarga_info" value="keluarga"
                                                    {{ old('keluarga', $asesmen->asesmenKetDewasaRanapRiwayatPasien->informasi_didapat_dari ?? '') === 'keluarga' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="keluarga_info">Keluarga</label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input" type="radio"
                                                    name="informasi_didapat_dari" id="informasi_lainnya" value="lainnya"
                                                    {{ old('lainnya', $asesmen->asesmenKetDewasaRanapRiwayatPasien->informasi_didapat_dari ?? '') === 'lainnya' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label me-2"
                                                    for="informasi_lainnya">Lainnya:</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="informasi_didapat_dari_lainnya" style="width: 200px;"
                                                    value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->informasi_didapat_dari_lainnya }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Spiritual -->
                            <div class="col-12 mb-3 section-separator">
                                <h6 class="fw-bold">Spiritual</h6>

                                <!-- Agama -->
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Agama:</label>
                                    <div class="col-sm-10">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="agama[]"
                                                    id="agama_islam" value="islam"
                                                    {{ in_array('islam', old('agama', $asesmen->asesmenKetDewasaRanapRiwayatPasien->agama ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="agama_islam">Islam</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="agama[]"
                                                    id="agama_katolik" value="katolik"
                                                    {{ in_array('katolik', old('agama', $asesmen->asesmenKetDewasaRanapRiwayatPasien->agama ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="agama_katolik">Katolik</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="agama[]"
                                                    id="agama_protestan" value="protestan"
                                                    {{ in_array('protestan', old('agama', $asesmen->asesmenKetDewasaRanapRiwayatPasien->agama ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="agama_protestan">Protestan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="agama[]"
                                                    id="agama_budha" value="budha"
                                                    {{ in_array('budha', old('agama', $asesmen->asesmenKetDewasaRanapRiwayatPasien->agama ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="agama_budha">Budha</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="agama[]"
                                                    id="agama_hindu" value="hindu"
                                                    {{ in_array('hindu', old('agama', $asesmen->asesmenKetDewasaRanapRiwayatPasien->agama ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="agama_hindu">Hindu</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="agama[]"
                                                    id="agama_konghucu" value="konghucu"
                                                    {{ in_array('konghucu', old('agama', $asesmen->asesmenKetDewasaRanapRiwayatPasien->agama ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="agama_konghucu">Konghucu</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pandangan spiritual pasien terhadap penyakitnya -->
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Pandangan spiritual pasien terhadap
                                        penyakitnya:</label>
                                    <div class="col-sm-10">
                                        <div class="d-flex flex-wrap gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pandangan_spiritual"
                                                    id="pandangan_takdir" value="takdir"
                                                    {{ old('takdir', $asesmen->asesmenKetDewasaRanapRiwayatPasien->pandangan_spiritual ?? '') === 'takdir' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="pandangan_takdir">Takdir</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pandangan_spiritual"
                                                    id="pandangan_hukuman" value="hukuman"
                                                    {{ old('hukuman', $asesmen->asesmenKetDewasaRanapRiwayatPasien->pandangan_spiritual ?? '') === 'hukuman' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="pandangan_hukuman">Hukuman</label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input" type="radio" name="pandangan_spiritual"
                                                    id="pandangan_lainnya" value="lainnya"
                                                    {{ old('lainnya', $asesmen->asesmenKetDewasaRanapRiwayatPasien->pandangan_spiritual ?? '') === 'lainnya' ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label me-2"
                                                    for="pandangan_lainnya">Lainnya:</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="pandangan_spiritual_lainnya" style="width: 300px;"
                                                    value="{{ $asesmen->asesmenKetDewasaRanapRiwayatPasien->pandangan_spiritual_lainnya }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="section-separator" id="pemeriksaan-fisik">
                            <h5 class="section-title">4. PEMERIKSAAN FISIK</h5>

                            <!-- Pemeriksaan mata, telinga, hidung, tenggorokan -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">Pemeriksaan mata, telinga, hidung, tenggorokan</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="mata_telinga_hidung_normal"
                                            id="mata_telinga_hidung_normal" value="normal"
                                            {{ old('mata_telinga_hidung_normal', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung_normal ?? '') == 'normal' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label fw-bold" for="mata_telinga_hidung">Normal</label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="gangguan_visus"
                                                    value="gangguan_visus"
                                                    {{ in_array('gangguan_visus', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="gangguan_visus">Gangguan
                                                    visus</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="galucoma" value="galucoma"
                                                    {{ in_array('galucoma', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="galucoma">Galucoma</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="sulit_mendengar"
                                                    value="sulit_mendengar"
                                                    {{ in_array('sulit_mendengar', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="sulit_mendengar">Sulit
                                                    mendengar</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="gusi" value="gusi"
                                                    {{ in_array('gusi', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="gusi">Gusi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="kemerahan" value="kemerahan"
                                                    {{ in_array('kemerahan', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="kemerahan">Kemerahan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="drainase" value="drainase"
                                                    {{ in_array('drainase', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="drainase">Drainase</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="buta" value="buta"
                                                    {{ in_array('buta', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="buta">Buta</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="tuli" value="tuli"
                                                    {{ in_array('tuli', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="tuli">Tuli</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="gigi" value="gigi"
                                                    {{ in_array('gigi', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="gigi">Gigi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="rasa_terbakar"
                                                    value="rasa_terbakar"
                                                    {{ in_array('rasa_terbakar', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="rasa_terbakar">Rasa
                                                    terbakar</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="luka" value="luka"
                                                    {{ in_array('luka', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="luka">Luka</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="mata_telinga_hidung[]" id="lainnya" value="lainnya"
                                                    {{ in_array('lainnya', old('mata_telinga_hidung', $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="lainnya">Lainnya</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Catatan:</label>
                                        <textarea class="form-control" name="mata_telinga_hidung_catatan" rows="2" disabled>{{ $asesmen->asesmenKetDewasaRanapFisik->mata_telinga_hidung_catatan ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan paru (kecepatan, kedalaman, pola, suara nafas) -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">Pemeriksaan paru (kecepatan, kedalaman, pola, suara nafas)
                                    </h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="pemeriksaan_paru_normal"
                                            id="pemeriksaan_paru_normal" value="normal"
                                            {{ old('pemeriksaan_paru_normal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru_normal ?? '') == 'normal' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label fw-bold"
                                            for="pemeriksaan_paru_normal">Normal</label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="asimetris" value="asimetris"
                                                    {{ in_array('asimetris', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="asimetris">Asimetris</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="takipnea" value="takipnea"
                                                    {{ in_array('takipnea', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="takipnea">Takipnea</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="ronki" value="ronki"
                                                    {{ in_array('ronki', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="ronki">Ronki</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="kiri_1" value="kiri_1"
                                                    {{ in_array('kiri_1', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="kiri_1">Kiri</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="kanan_1" value="kanan_1"
                                                    {{ in_array('kanan_1', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="kanan_1">Kanan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="batuk" value="batuk"
                                                    {{ in_array('batuk', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="batuk">Batuk</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="barrel_chest" value="barrel_chest"
                                                    {{ in_array('barrel_chest', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="barrel_chest">Barrel chest</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="bradipnea_1" value="bradipnea_1"
                                                    {{ in_array('bradipnea_1', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="bradipnea_1">Bradipnea</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="mengi_wheezing"
                                                    value="mengi_wheezing"
                                                    {{ in_array('mengi_wheezing', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="mengi_wheezing">Mengi/
                                                    wheezing</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="kiri_2" value="kiri_2"
                                                    {{ in_array('kiri_2', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="kiri_2">Kiri</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="kanan_2" value="kanan_2"
                                                    {{ in_array('kanan_2', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="kanan_2">Kanan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="warna_dahak" value="warna_dahak"
                                                    {{ in_array('warna_dahak', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="warna_dahak">Warna dahak</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="sesak" value="sesak"
                                                    {{ in_array('sesak', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="sesak">Sesak</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="dangkal" value="dangkal"
                                                    {{ in_array('dangkal', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="dangkal">Dangkal</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="menghilang" value="menghilang"
                                                    {{ in_array('menghilang', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="menghilang">Menghilang</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="kiri_3" value="kiri_3"
                                                    {{ in_array('kiri_3', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="kiri_3">Kiri</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="kanan_3" value="kanan_3"
                                                    {{ in_array('kanan_3', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="kanan_3">Kanan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_paru[]" id="lainnya_paru" value="lainnya"
                                                    {{ in_array('lainnya', old('pemeriksaan_paru', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="lainnya_paru">Lainnya</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Catatan:</label>
                                        <textarea class="form-control" name="pemeriksaan_paru_catatan" rows="2" disabled>{{ old('pemeriksaan_paru_catatan', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_paru_catatan ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan Gastrointestinal -->
                            <div class="form-section mt-3">
                                <div class="section-header d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Pemeriksaan gastrointestinal</span>
                                    <div class="form-check normal-checkbox">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal_normal"
                                            id="pemeriksaan_gastrointestinal_normal" value="normal"
                                            {{ old('pemeriksaan_gastrointestinal_normal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal_normal ?? '') == 'normal' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label fw-bold"
                                            for="pemeriksaan_gastrointestinal_normal">Normal</label>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_distensi" value="distensi"
                                            {{ in_array('distensi', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_distensi">Distensi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_bisingususmenurun"
                                            value="bising_usus_menurun"
                                            {{ in_array('bising_usus_menurun', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_bisingususmenurun">Bising usus
                                            menurun</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_anoreksia" value="anoreksia"
                                            {{ in_array('anoreksia', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_anoreksia">Anoreksia</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_disfagia" value="disfagia"
                                            {{ in_array('disfagia', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_disfagia">Disfagia</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_diare" value="diare"
                                            {{ in_array('diare', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_diare">Diare</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_klismagliserin"
                                            value="klisma_sput_gliserin"
                                            {{ in_array('klisma_sput_gliserin', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_klismagliserin">Klisma sput gliserin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]" id="pemeriksaan_gastrointestinal_mual"
                                            value="mual_muntah"
                                            {{ in_array('mual_muntah', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_mual">Mual/muntah</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_bisingusmenurun2"
                                            value="bising_usus_menurun2"
                                            {{ in_array('bising_usus_menurun2', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_bisingusmenurun2">Bising usus
                                            menurun</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_intoleransidiet" value="intoleransi_diet"
                                            {{ in_array('intoleransi_diet', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_intoleransidiet">Intoleransi diet</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_konstipasi" value="konstipasi"
                                            {{ in_array('konstipasi', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_konstipasi">Konstipasi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_gastrointestinal[]"
                                            id="pemeriksaan_gastrointestinal_babberakhir" value="bab_berakhir"
                                            {{ in_array('bab_berakhir', old('pemeriksaan_gastrointestinal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_gastrointestinal_babberakhir">BAB terakhir:</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="text" class="form-control"
                                            name="pemeriksaan_gastrointestinal_bab_terakhir"
                                            value="{{ old('pemeriksaan_gastrointestinal_bab_terakhir', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal_bab_terakhir ?? '') }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Diet khusus:</label>
                                        <input type="text" class="form-control" name="fisik_diet_khusus"
                                            value="{{ old('fisik_diet_khusus', $asesmen->asesmenKetDewasaRanapFisik->fisik_diet_khusus ?? '') }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label">Catatan:</label>
                                    <textarea class="form-control" name="pemeriksaan_gastrointestinal_catatan" rows="2" disabled>{{ old('pemeriksaan_gastrointestinal_catatan', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_gastrointestinal_catatan ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- Pemeriksaan Kardiovaskular -->
                            <div class="form-section mt-3">
                                <div class="section-header d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Pemeriksaan Kardiovaskular</span>
                                    <div class="form-check normal-checkbox">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular_normal"
                                            id="pemeriksaan_kardiovaskular_normal" value="normal"
                                            {{ old('pemeriksaan_kardiovaskular_normal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular_normal ?? '') == 'normal' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label fw-bold"
                                            for="pemeriksaan_kardiovaskular_normal">Normal</label>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]"
                                            id="pemeriksaan_kardiovaskular_takikardi" value="takikardi"
                                            {{ in_array('takikardi', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_takikardi">Takikardi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_iregular"
                                            value="iregular"
                                            {{ in_array('iregular', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_iregular">Iregular</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_tingling"
                                            value="tingling"
                                            {{ in_array('tingling', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_tingling">Tingling</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_edema"
                                            value="edema"
                                            {{ in_array('edema', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_edema">Edema</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]"
                                            id="pemeriksaan_kardiovaskular_denyutnadilemah" value="denyut_nadi_lemah"
                                            {{ in_array('denyut_nadi_lemah', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_denyutnadilemah">Denyut nadi lemah</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]"
                                            id="pemeriksaan_kardiovaskular_bradikardi" value="bradikardi"
                                            {{ in_array('bradikardi', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_bradikardi">Bradikardi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_murmur"
                                            value="murmur"
                                            {{ in_array('murmur', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_murmur">Murmur</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_baal"
                                            value="baal"
                                            {{ in_array('baal', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_baal">Baal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]" id="pemeriksaan_kardiovaskular_fatique"
                                            value="fatique"
                                            {{ in_array('fatique', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_fatique">Fatique</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_kardiovaskular[]"
                                            id="pemeriksaan_kardiovaskular_denyuttidakada" value="denyut_tidak_ada"
                                            {{ in_array('denyut_tidak_ada', old('pemeriksaan_kardiovaskular', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label"
                                            for="pemeriksaan_kardiovaskular_denyuttidakada">Denyut tidak ada</label>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label class="form-label">Catatan:</label>
                                    <textarea class="form-control" name="pemeriksaan_kardiovaskular_catatan" rows="2" disabled>{{ old('pemeriksaan_kardiovaskular_catatan', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_kardiovaskular_catatan ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- Pemeriksaan Genitourinaria dan Ginekologi -->
                            <div class="mb-4 mt-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">Pemeriksaan Genitourinaria dan Ginekologi</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_genitourinaria_ginekologi_normal"
                                            id="pemeriksaan_genitourinaria_ginekologi_normal" value="normal"
                                            {{ old('pemeriksaan_genitourinaria_ginekologi_normal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi_normal ?? '') == 'normal' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label fw-bold"
                                            for="pemeriksaan_genitourinaria_ginekologi_normal">Normal</label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_ginekologi_kateteri" value="kateter"
                                                    {{ in_array('kateter', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_ginekologi_kateteri">Kateter</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_ginekologi_hesitansi"
                                                    value="hesitansi"
                                                    {{ in_array('hesitansi', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_ginekologi_hesitansi">Hesitansi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_ginekologi_hematuria"
                                                    value="hematuria"
                                                    {{ in_array('hematuria', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_ginekologi_hematuria">Hematuria</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_ginekologi_menopouse"
                                                    value="menopouse"
                                                    {{ in_array('menopouse', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_ginekologi_menopouse">Menopouse</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_ginekologi_sekret_abnormal"
                                                    value="sekret_abnormal"
                                                    {{ in_array('sekret_abnormal', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_ginekologi_sekret_abnormal">Sekret
                                                    abnormal</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_ginekologi_urostomy" value="urostomy"
                                                    {{ in_array('urostomy', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_ginekologi_urostomy">Urostomy</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_inkontinesia" value="inkontinesia"
                                                    {{ in_array('inkontinesia', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_inkontinesia">Inkontinesia</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_nokturia" value="nokturia"
                                                    {{ in_array('nokturia', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_nokturia">Nokturia</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_disuria" value="disuria"
                                                    {{ in_array('disuria', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_disuria">Disuria</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_menstruasi_terakhir"
                                                    value="menstruasi_terakhir"
                                                    {{ in_array('menstruasi_terakhir', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_menstruasi_terakhir">Menstruasi
                                                    terakhir</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_genitourinaria_ginekologi[]"
                                                    id="pemeriksaan_genitourinaria_hamil" value="hamil"
                                                    {{ in_array('hamil', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_hamil">Hamil</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Catatan:</label>
                                        <textarea class="form-control" name="pemeriksaan_genitourinaria_ginekologi_catatan" rows="2" disabled>{{ old('pemeriksaan_genitourinaria_ginekologi_catatan', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_genitourinaria_ginekologi_catatan ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Pemeriksaan Neurologi (orientasi, verbal, kekuatan) -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0">Pemeriksaan Neurologi (orientasi, verbal, kekuatan)</h6>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="pemeriksaan_neurologi_normal" id="pemeriksaan_neurologi_normal"
                                            value="normal"
                                            {{ old('pemeriksaan_neurologi_normal', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi_normal ?? '') == 'normal' ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label fw-bold"
                                            for="pemeriksaan_neurologi_normal">Normal</label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_neurologi_dalam_sedasi" value="dalam_sedasi"
                                                    {{ in_array('dalam_sedasi', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_neurologi_dalam_sedasi">Dalam sedasi</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_vertigo"
                                                    value="vertigo"
                                                    {{ in_array('vertigo', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_neurologi_vertigo">Vertigo</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_afasia"
                                                    value="afasia"
                                                    {{ in_array('afasia', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_neurologi_afasia">Afasia</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_tremor"
                                                    value="tremor"
                                                    {{ in_array('tremor', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_neurologi_tremor">Tremor</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_neurologi_tidak_stabil" value="tidak_stabil"
                                                    {{ in_array('tidak_stabil', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_neurologi_tidak_stabil">Tidak stabil</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]" id="pemeriksaan_neurologi_letargi"
                                                    value="letargi"
                                                    {{ in_array('letargi', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_neurologi_letargi">Letargi</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_genitourinaria_sakit_kepala" value="sakit_kepala"
                                                    {{ in_array('sakit_kepala', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_sakit_kepala">Sakit kepala</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_genitourinaria_Bicara_tidak_jelas"
                                                    value="Bicara_tidak_jelas"
                                                    {{ in_array('Bicara_tidak_jelas', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_Bicara_tidak_jelas">Bicara tidak
                                                    jelas</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]" id="pemeriksaan_genitourinaria_baal"
                                                    value="baal"
                                                    {{ in_array('baal', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_baal">Baal</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_genitourinaria_paralisis" value="paralisis"
                                                    {{ in_array('paralisis', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_paralisis">Paralisis</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_genitourinaria_semi_koma" value="semi_koma"
                                                    {{ in_array('semi_koma', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_semi_koma">Semi koma</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_genitourinaria_pupil_tidak_reaktif"
                                                    value="pupil_tidak_reaktif"
                                                    {{ in_array('pupil_tidak_reaktif', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_pupil_tidak_reaktif">Pupil tidak
                                                    reaktif</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_genitourinaria_kejang" value="kejang"
                                                    {{ in_array('kejang', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_kejang">Kejang</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_genitourinaria_tingling" value="tingling"
                                                    {{ in_array('tingling', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_tingling">Tingling</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_genitourinaria_genggaman_lemah"
                                                    value="genggaman_lemah"
                                                    {{ in_array('genggaman_lemah', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_genggaman_lemah">Genggaman
                                                    lemah</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="pemeriksaan_neurologi[]"
                                                    id="pemeriksaan_genitourinaria_lainnya" value="lainnya"
                                                    {{ in_array('lainnya', old('pemeriksaan_neurologi', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label"
                                                    for="pemeriksaan_genitourinaria_lainnya">Lainnya</label>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Catatan:</label>
                                        <textarea class="form-control" name="pemeriksaan_neurologi_catatan" rows="2" disabled>{{ old('pemeriksaan_neurologi_catatan', $asesmen->asesmenKetDewasaRanapFisik->pemeriksaan_neurologi_catatan ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Kesadaran -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Kesadaran:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                                id="kesadaran_compos_mentis" value="compos_mentis"
                                                {{ in_array('compos_mentis', old('kesadaran', $asesmen->asesmenKetDewasaRanapFisik->kesadaran ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="kesadaran_compos_mentis">Compos
                                                mentis</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                                id="kesadaran_apatis" value="apatis"
                                                {{ in_array('apatis', old('kesadaran', $asesmen->asesmenKetDewasaRanapFisik->kesadaran ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="kesadaran_apatis">Apatis</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                                id="kesadaran_somnolen" value="somnolen"
                                                {{ in_array('somnolen', old('kesadaran', $asesmen->asesmenKetDewasaRanapFisik->kesadaran ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="kesadaran_somnolen">Somnolen</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                                id="kesadaran_sopor_koma" value="sopor_koma"
                                                {{ in_array('sopor_koma', old('kesadaran', $asesmen->asesmenKetDewasaRanapFisik->kesadaran ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="kesadaran_sopor_koma">Sopor
                                                Koma</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="kesadaran[]"
                                                id="kesadaran_koma" value="koma"
                                                {{ in_array('koma', old('kesadaran', $asesmen->asesmenKetDewasaRanapFisik->kesadaran ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="kesadaran_koma">Koma</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">GCS</label>
                                <div class="input-group">
                                    @php
                                        // Ambil data GCS dari database
                                        $gcsValue = '';
                                        if (isset($asesmen->asesmenKetDewasaRanapFisik) && $asesmen) {
                                            // Periksa apakah vital_sign sudah array atau masih string JSON
                                            $vitalSigns = is_array($asesmen->vital_sign)
                                                ? $asesmen->vital_sign
                                                : (is_string($asesmen->asesmenKetDewasaRanapFisik->vital_sign)
                                                    ? json_decode(
                                                        $asesmen->asesmenKetDewasaRanapFisik->vital_sign,
                                                        true,
                                                    )
                                                    : []);
                                            $gcsValue = $vitalSigns['gcs'] ?? '';
                                        }
                                    @endphp

                                    <input type="text" class="form-control" name="vital_sign[gcs]" id="gcsInput"
                                        value="{{ old('vital_sign.gcs', $gcsValue) }}" readonly disabled>

                                    <button type="button" class="btn btn-outline-primary" onclick="openGCSModal()"
                                        title="Buka Kalkulator GCS">
                                        <i class="ti-calculator"></i> Detail Hitung GCS
                                    </button>
                                </div>
                            </div>
                            @push('modals')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.show-gcs-modal')
                            @endpush
                        </div>

                        <div class="section-separator" id="pengkajian_status_nutrisi">
                            <h5 class="section-title">5. PENGKAJIAN STATUS NUTRISI</h5>
                            <div class="card-body">
                                <!-- Pertanyaan 1 -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-start">
                                        <span class="badge bg-primary me-3 mt-1">1</span>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-3">Apakah pasien mengalami penurunan BB yang tidak
                                                diinginkan dalam 6 bulan terakhir?</h6>
                                            <div class="mb-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="bb_turun"
                                                        id="bb_tidak_ada" value="0"
                                                        {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->bb_turun == 0 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="bb_tidak_ada">Tidak ada <span
                                                            class="badge bg-secondary ms-2">Skor: 0</span></label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="bb_turun"
                                                        id="bb_tidak_yakin" value="2"
                                                        {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->bb_turun == 2 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="bb_tidak_yakin">Tidak yakin /
                                                        tidak tahu / terasa baju longgar <span
                                                            class="badge bg-secondary ms-2">Skor: 2</span></label>
                                                </div>
                                            </div>
                                            <div class="ms-3">
                                                <p class="text-muted mb-2"><em>Jika "Ya" berapa penurunan berat badan
                                                        tersebut:</em></p>
                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="bb_turun_range" id="bb_1_5kg" value="1"
                                                                {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->bb_turun_range == 1 ? 'checked' : '' }}
                                                                disabled>
                                                            <label class="form-check-label" for="bb_1_5kg">1 sd 5 Kg
                                                                <span class="badge bg-secondary ms-2">Skor:
                                                                    1</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="bb_turun_range" id="bb_6_10kg" value="2"
                                                                {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->bb_turun_range == 2 ? 'checked' : '' }}
                                                                disabled>
                                                            <label class="form-check-label" for="bb_6_10kg">6 sd 10 Kg
                                                                <span class="badge bg-secondary ms-2">Skor:
                                                                    2</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="bb_turun_range" id="bb_11_15kg" value="3"
                                                                {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->bb_turun_range == 3 ? 'checked' : '' }}
                                                                disabled>
                                                            <label class="form-check-label" for="bb_11_15kg">11 sd 15 Kg
                                                                <span class="badge bg-secondary ms-2">Skor:
                                                                    3</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="bb_turun_range" id="bb_lebih_15kg"
                                                                value="4"
                                                                {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->bb_turun_range == 4 ? 'checked' : '' }}
                                                                disabled>
                                                            <label class="form-check-label" for="bb_lebih_15kg">> 15 Kg
                                                                <span class="badge bg-secondary ms-2">Skor:
                                                                    4</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Pertanyaan 2 -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-start">
                                        <span class="badge bg-primary me-3 mt-1">2</span>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-3">Apakah asupan makanan berkurang karena tidak nafsu
                                                makan?</h6>
                                            <div class="mb-3">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="nafsu_makan"
                                                        id="nafsu_tidak" value="0"
                                                        {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->nafsu_makan == 0 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="nafsu_tidak">Tidak <span
                                                            class="badge bg-secondary ms-2">Skor: 0</span></label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="nafsu_makan"
                                                        id="nafsu_ya" value="1"
                                                        {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->nafsu_makan == 1 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="nafsu_ya">Ya <span
                                                            class="badge bg-secondary ms-2">Skor: 1</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Pertanyaan 3 -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-start">
                                        <span class="badge bg-primary me-3 mt-1">3</span>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-3">Pasien dengan diagnosa khusus:</h6>
                                            <div class="mb-3">
                                                <div class="form-check form-check-inline me-4">
                                                    <input class="form-check-input" type="radio"
                                                        name="diagnosa_khusus" id="diagnosa_ya" value="ya"
                                                        {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->diagnosa_khusus == 'ya' ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="diagnosa_ya">Ya</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="diagnosa_khusus" id="diagnosa_tidak" value="tidak"
                                                        {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->diagnosa_khusus == 'tidak' ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="diagnosa_tidak">Tidak</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-muted">
                                                    <em>(Diabetes, Kemo, HD, geriatri, penurunan imun, dll sebutkan:</em>
                                                </label>
                                                <textarea class="form-control" rows="2" name="status_nutrisi_lainnya" disabled>{{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->status_nutrisi_lainnya }}</textarea>
                                            </div>
                                            <div class="mb-3 text-center">
                                                <h6 class="card-title mb-2">TOTAL SKOR</h6>
                                                <div class="display-1 text-primary fw-bold" id="total_skor_display">
                                                    {{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->status_nutrisi_total }}
                                                </div>
                                                <input type="hidden" id="total_skor_nutrisi"
                                                    value="{{ $asesmen->asesmenKetDewasaRanapStatusNutrisi->status_nutrisi_total }}"
                                                    name="status_nutrisi_total">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-separator">
                            <h5 class="section-title">6. SKALA NYERI</h5>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start gap-4">
                                        <div class="d-flex align-items-center gap-3" style="min-width: 350px;">
                                            <input type="number"
                                                class="form-control flex-grow-1 @error('skala_nyeri') is-invalid @enderror"
                                                name="skala_nyeri" id="skalaNyeriInput" style="width: 100px;"
                                                value="{{ old('skala_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->skala_nyeri ?? 0) }}"
                                                min="0" max="10" disabled>

                                            <input type="hidden" name="tipe_skala_nyeri" id="tipeSkalaHidden"
                                                value="{{ old('tipe_skala_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->tipe_skala_nyeri ?? 'numeric') }}">

                                            @error('skala_nyeri')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <button type="button" class="btn btn-sm btn-success" id="skalaNyeriBtn">
                                                Tidak Nyeri
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <small class="text-muted">
                                            Nilai: <span
                                                id="debugNilai">{{ old('skala_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->skala_nyeri ?? 0) }}</span>
                                            |
                                            Tipe: <span
                                                id="debugTipe">{{ old('tipe_skala_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->tipe_skala_nyeri ?? 'numeric') }}</span>
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="btn-group mb-3" role="group">
                                        <button type="button" class="btn btn-sm" id="numericBtn"
                                            data-scale="numeric">A. Numeric Rating Pain Scale</button>
                                        <button type="button" class="btn btn-sm" id="wongBakerBtn"
                                            data-scale="wong-baker">B. Wong Baker Faces Pain Scale</button>
                                    </div>

                                    <div class="pain-scale-container">
                                        <div id="numericScale" class="pain-scale-image"
                                            style="display: {{ old('tipe_skala_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->tipe_skala_nyeri ?? 'numeric') == 'numeric' ? 'block' : 'none' }};">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <h6 class="card-title">Numeric Rating Pain Scale</h6>
                                                    <img src="{{ asset('assets/img/asesmen/numerik.png') }}"
                                                        alt="Numeric Pain Scale" class="img-fluid"
                                                        style="max-width: auto; height: auto;"
                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                    <div style="display: none; padding: 20px;">
                                                        <p><strong>Skala Nyeri Numerik (0-10)</strong></p>
                                                        <div class="d-flex justify-content-between">
                                                            <span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="wongBakerScale" class="pain-scale-image"
                                            style="display: {{ old('tipe_skala_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->tipe_skala_nyeri ?? 'numeric') == 'wong-baker' ? 'block' : 'none' }};">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <h6 class="card-title">Wong Baker Faces Pain Scale</h6>
                                                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                        alt="Wong Baker Pain Scale" class="img-fluid"
                                                        style="max-width: auto; height: auto;"
                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                    <div style="display: none; padding: 20px;">
                                                        <p><strong>Wong Baker Faces Pain Rating Scale</strong></p>
                                                        <div class="row">
                                                            <div class="col-2 text-center">
                                                                <div style="font-size: 24px;">😊</div><small>0<br>Tidak
                                                                    Nyeri</small>
                                                            </div>
                                                            <div class="col-2 text-center">
                                                                <div style="font-size: 24px;">🙂</div>
                                                                <small>2<br>Sedikit</small>
                                                            </div>
                                                            <div class="col-2 text-center">
                                                                <div style="font-size: 24px;">😐</div><small>4<br>Sedikit
                                                                    Lebih</small>
                                                            </div>
                                                            <div class="col-2 text-center">
                                                                <div style="font-size: 24px;">😣</div>
                                                                <small>6<br>Lebih</small>
                                                            </div>
                                                            <div class="col-2 text-center">
                                                                <div style="font-size: 24px;">😖</div>
                                                                <small>8<br>Sangat</small>
                                                            </div>
                                                            <div class="col-2 text-center">
                                                                <div style="font-size: 24px;">😭</div>
                                                                <small>10<br>Terburuk</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Lokasi nyeri -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="lokasi_nyeri">Lokasi nyeri:</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="lokasi_nyeri" id="lokasi_nyeri"
                                        value="{{ old('lokasi_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->lokasi_nyeri ?? '') }}"
                                        disabled>
                                </div>
                            </div>

                            <!-- Jenis nyeri -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jenis nyeri:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="jenis_nyeri[]"
                                                id="jenis_nyeri_akut" value="akut"
                                                {{ in_array('akut', old('jenis_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->jenis_nyeri ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="jenis_nyeri_akut">Akut</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="jenis_nyeri[]"
                                                id="jenis_nyeri_kronik" value="kronik"
                                                {{ in_array('kronik', old('jenis_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->jenis_nyeri ?? [])) ? 'checked' : '' }}
                                                disabled>
                                            <label class="form-check-label" for="jenis_nyeri_kronik">Kronik</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Frekuensi nyeri -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Frekuensi nyeri:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="frekuensi_nyeri[]" id="frekuensi_jarang" value="jarang"
                                                {{ in_array('jarang', old('frekuensi_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->frekuensi_nyeri ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="frekuensi_jarang">Jarang</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="frekuensi_nyeri[]" id="frekuensi_hilang_timbul"
                                                value="hilang_timbul"
                                                {{ in_array('hilang_timbul', old('frekuensi_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->frekuensi_nyeri ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="frekuensi_hilang_timbul">Hilang
                                                timbul</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="frekuensi_nyeri[]" id="frekuensi_terus_menerus"
                                                value="terus_menerus"
                                                {{ in_array('terus_menerus', old('frekuensi_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->frekuensi_nyeri ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="frekuensi_terus_menerus">Terus
                                                menerus</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="durasi_nyeri">Durasi nyeri:</label>
                                <div class="col-sm-10">
                                    <input disabled class="form-control" type="text" name="durasi_nyeri"
                                        id="durasi_nyeri"
                                        value="{{ old('durasi_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->durasi_nyeri ?? '') }}">
                                </div>
                            </div>

                            <!-- Menjalar -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Menjalar:</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="radio"
                                                    name="nyeri_menjalar" id="nyeri_menjalar_tidak" value="tidak"
                                                    {{ old('nyeri_menjalar', $asesmen->asesmenKetDewasaRanapSkalaNyeri->nyeri_menjalar ?? '') == 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="nyeri_menjalar_tidak">Tidak</label>
                                            </div>
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="radio"
                                                    name="nyeri_menjalar" id="nyeri_menjalar_ya" value="ya"
                                                    {{ old('nyeri_menjalar', $asesmen->asesmenKetDewasaRanapSkalaNyeri->nyeri_menjalar ?? '') == 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="nyeri_menjalar_ya">Ya, ke:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input disabled type="text" class="form-control"
                                                name="durasi_nyeri_lokasi" id="nyeri_menjalar_lokasi"
                                                value="{{ old('durasi_nyeri_lokasi', $asesmen->asesmenKetDewasaRanapSkalaNyeri->durasi_nyeri_lokasi ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kualitas nyeri -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Kualitas nyeri:</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="kualitas_nyeri[]" id="kualitas_nyeri_tumpul"
                                                    value="nyeri_tumpul"
                                                    {{ in_array('nyeri_tumpul', old('kualitas_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->kualitas_nyeri ?? [])) ? 'checked' : '' }}>
                                                <label disabled class="form-check-label"
                                                    for="kualitas_nyeri_tumpul">Nyeri tumpul</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="kualitas_nyeri[]" id="kualitas_nyeri_tajam"
                                                    value="nyeri_tajam"
                                                    {{ in_array('nyeri_tajam', old('kualitas_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->kualitas_nyeri ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kualitas_nyeri_tajam">Nyeri
                                                    tajam</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="kualitas_nyeri[]" id="kualitas_nyeri_panas"
                                                    value="panas_terbakar"
                                                    {{ in_array('panas_terbakar', old('kualitas_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->kualitas_nyeri ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="kualitas_nyeri_panas">Panas/terbakar</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Faktor pemberat -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Faktor pemberat:</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="faktor_pemberat[]" id="faktor_pemberat_cahaya"
                                                    value="cahaya"
                                                    {{ in_array('cahaya', old('faktor_pemberat', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_pemberat ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="faktor_pemberat_cahaya">Cahaya</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="faktor_pemberat[]" id="faktor_pemberat_gelap" value="gelap"
                                                    {{ in_array('gelap', old('faktor_pemberat', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_pemberat ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="faktor_pemberat_gelap">Gelap</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="faktor_pemberat[]" id="faktor_pemberat_berbaring"
                                                    value="berbaring"
                                                    {{ in_array('berbaring', old('faktor_pemberat', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_pemberat ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="faktor_pemberat_berbaring">Berbaring</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="faktor_pemberat[]" id="faktor_pemberat_gerakan"
                                                    value="gerakan"
                                                    {{ in_array('gerakan', old('faktor_pemberat', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_pemberat ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="faktor_pemberat_gerakan">Gerakan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Faktor peringan -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Faktor peringan:</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="faktor_peringan[]" id="faktor_peringan_cahaya"
                                                    value="cahaya"
                                                    {{ in_array('cahaya', old('faktor_peringan', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_peringan ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="faktor_peringan_cahaya">Cahaya</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="faktor_peringan[]" id="faktor_peringan_gelap" value="gelap"
                                                    {{ in_array('gelap', old('faktor_peringan', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_peringan ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="faktor_peringan_gelap">Gelap</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="faktor_peringan[]" id="faktor_peringan_sunyi" value="sunyi"
                                                    {{ in_array('sunyi', old('faktor_peringan', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_peringan ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="faktor_peringan_sunyi">Sunyi</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="faktor_peringan[]" id="faktor_peringan_dingin"
                                                    value="Dingin"
                                                    {{ in_array('Dingin', old('faktor_peringan', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_peringan ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="faktor_peringan_dingin">Dingin</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="faktor_peringan[]" id="faktor_peringan_lainnya"
                                                    value="lainnya"
                                                    {{ in_array('lainnya', old('faktor_peringan', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_peringan ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="faktor_peringan_lainnya">Lainnya:</label>
                                                <input disabled type="text" class="form-control mt-2"
                                                    id="faktor_peringan_lainnya_text"
                                                    name="faktor_peringan_lainnya_text"
                                                    value="{{ old('faktor_peringan_lainnya_text', $asesmen->asesmenKetDewasaRanapSkalaNyeri->faktor_peringan_lainnya_text ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Efek nyeri -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Efek nyeri:</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="efek_nyeri[]" id="efek_nyeri_mual" value="mual_muntah"
                                                    {{ in_array('mual_muntah', old('efek_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->efek_nyeri ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="efek_nyeri_mual">Mual/Muntah</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="efek_nyeri[]" id="efek_nyeri_tidur" value="tidur"
                                                    {{ in_array('tidur', old('efek_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->efek_nyeri ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="efek_nyeri_tidur">Tidur</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="efek_nyeri[]" id="efek_nyeri_nafsu_makan"
                                                    value="nafsu_makan"
                                                    {{ in_array('nafsu_makan', old('efek_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->efek_nyeri ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="efek_nyeri_nafsu_makan">Nafsu
                                                    makan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check mb-2">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="efek_nyeri[]" id="efek_nyeri_emosi" value="emosi"
                                                    {{ in_array('emosi', old('efek_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->efek_nyeri ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="efek_nyeri_emosi">Emosi</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="efek_nyeri[]" id="efek_nyeri_lainnya" value="lainnya"
                                                    {{ in_array('lainnya', old('efek_nyeri', $asesmen->asesmenKetDewasaRanapSkalaNyeri->efek_nyeri ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="efek_nyeri_lainnya">Lainnya:</label>
                                                <input disabled type="text" class="form-control mt-2"
                                                    id="efek_nyeri_lainnya_text" name="efek_nyeri_lainnya_text"
                                                    value="{{ old('efek_nyeri_lainnya_text', $asesmen->asesmenKetDewasaRanapSkalaNyeri->efek_nyeri_lainnya_text ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-separator" id="risiko_jatuh">
                            <h5 class="section-title">7. RESIKO JATUH</h5>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih jenis penilaian risiko jatuh sesuai dengan kondisi
                                    pasien:</label>
                                <select disabled class="form-select custom-select" id="risikoJatuhSkala"
                                    name="resiko_jatuh_jenis" onchange="showForm(this.value)">
                                    <option value="">--Pilih Skala--</option>
                                    <option value="1"
                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->resiko_jatuh_jenis ?? '') == '1' ? 'selected' : '' }}>
                                        Skala Umum</option>
                                    <option value="2"
                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->resiko_jatuh_jenis ?? '') == '2' ? 'selected' : '' }}>
                                        Skala Morse</option>
                                    <option value="4"
                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->resiko_jatuh_jenis ?? '') == '4' ? 'selected' : '' }}>
                                        Skala Ontario Modified Stratify Sydney / Lansia</option>
                                    <option value="5"
                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->resiko_jatuh_jenis ?? '') == '5' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                            </div>

                            <!-- Form Skala Umum -->
                            <div id="skala_umumForm" class="risk-form"
                                style="display: {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->resiko_jatuh_jenis ?? '') == '1' ? 'block' : 'none' }};">
                                <h5 class="mb-4 text-center">Penilaian Risiko Jatuh Skala Umum</h5>

                                <div class="question-card">
                                    <div class="question-text">Apakah pasien berusia < dari 2 tahun?</div>
                                            <select disabled class="form-select custom-select"
                                                name="risiko_jatuh_umum_usia" onchange="updateConclusion('umum')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_usia ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_usia ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                    </div>

                                    <div class="question-card">
                                        <div class="question-text">Apakah pasien dalam kondisi sebagai geriatri,
                                            dizziness, vertigo, gangguan keseimbangan, gangguan penglihatan, penggunaan obat
                                            sedasi, status kesadaran dan atau kejiwaan, konsumsi alkohol?</div>
                                        <select disabled class="form-select custom-select"
                                            onchange="updateConclusion('umum')" name="risiko_jatuh_umum_kondisi_khusus">
                                            <option value="">Pilih jawaban</option>
                                            <option value="1"
                                                {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_kondisi_khusus ?? '') == '1' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_kondisi_khusus ?? '') == '0' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>

                                    <div class="question-card">
                                        <div class="question-text">Apakah pasien didiagnosis sebagai pasien dengan
                                            penyakit parkinson?</div>
                                        <select disabled class="form-select custom-select"
                                            onchange="updateConclusion('umum')"
                                            name="risiko_jatuh_umum_diagnosis_parkinson">
                                            <option value="">Pilih jawaban</option>
                                            <option value="1"
                                                {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_diagnosis_parkinson ?? '') == '1' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_diagnosis_parkinson ?? '') == '0' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>

                                    <div class="question-card">
                                        <div class="question-text">Apakah pasien sedang mendapatkan obat sedasi, riwayat
                                            tirah baring lama, perubahan posisi yang akan meningkatkan risiko jatuh?</div>
                                        <select disabled class="form-select custom-select"
                                            onchange="updateConclusion('umum')"
                                            name="risiko_jatuh_umum_pengobatan_berisiko">
                                            <option value="">Pilih jawaban</option>
                                            <option value="1"
                                                {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_pengobatan_berisiko ?? '') == '1' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_pengobatan_berisiko ?? '') == '0' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>

                                    <div class="question-card">
                                        <div class="question-text">Apakah pasien saat ini sedang berada pada salah satu
                                            lokasi ini: rehab medik, ruangan dengan penerangan kurang dan bertangga?</div>
                                        <select disabled class="form-select custom-select"
                                            onchange="updateConclusion('umum')"
                                            name="risiko_jatuh_umum_lokasi_berisiko">
                                            <option value="">Pilih jawaban</option>
                                            <option value="1"
                                                {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_lokasi_berisiko ?? '') == '1' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="0"
                                                {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_lokasi_berisiko ?? '') == '0' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>

                                    <div class="conclusion alert alert-success">
                                        <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                        <p class="conclusion-text mb-0 fs-5"><span
                                                id="kesimpulanUmum">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_kesimpulan ?? 'Tidak berisiko jatuh' }}</span>
                                        </p>
                                        <input type="hidden" name="risiko_jatuh_umum_kesimpulan"
                                            id="risiko_jatuh_umum_kesimpulan"
                                            value="{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_umum_kesimpulan ?? 'Tidak berisiko jatuh' }}">
                                    </div>
                                </div>

                                <!-- Form Skala Morse -->
                                <div id="skala_morseForm" class="risk-form"
                                    style="display: {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->resiko_jatuh_jenis ?? '') == '2' ? 'block' : 'none' }};">
                                    <h5 class="mb-4 text-center">6.A. PENGKAJIAN RESIKO JATUH SKALA MORSE (USIA 19 s.d 59
                                        Tahun)</h5>

                                    <div class="factor-card">
                                        <div class="factor-title">Riwayat Jatuh</div>
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <select disabled class="form-select custom-select"
                                                    name="risiko_jatuh_morse_riwayat_jatuh"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">Pilih kondisi</option>
                                                    <option value="0"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_riwayat_jatuh ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak (Skor: 0)</option>
                                                    <option value="25"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_riwayat_jatuh ?? '') == '25' ? 'selected' : '' }}>
                                                        Ya (Skor: 25)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <span class="score-badge"
                                                    id="score_riwayat_jatuh">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_riwayat_jatuh ?? '0' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="factor-card">
                                        <div class="factor-title">Diagnosis Sekunder (> 2 diagnosis)</div>
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <select disabled class="form-select custom-select"
                                                    name="risiko_jatuh_morse_diagnosis_sekunder"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">Pilih kondisi</option>
                                                    <option value="0"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_diagnosis_sekunder ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak (Skor: 0)</option>
                                                    <option value="15"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_diagnosis_sekunder ?? '') == '15' ? 'selected' : '' }}>
                                                        Ya (Skor: 15)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <span class="score-badge"
                                                    id="score_diagnosis_sekunder">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_diagnosis_sekunder ?? '0' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="factor-card">
                                        <div class="factor-title">Alat Bantu</div>
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <select disabled class="form-select custom-select"
                                                    name="risiko_jatuh_morse_bantuan_ambulasi"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">Pilih kondisi</option>
                                                    <option value="0"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak ada / bedrest / bantuan perawat (Skor: 0)</option>
                                                    <option value="15"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '') == '15' ? 'selected' : '' }}>
                                                        Kruk / tongkat / alat bantu berjalan (Skor: 15)</option>
                                                    <option value="30"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '') == '30' ? 'selected' : '' }}>
                                                        Meja / kursi (Skor: 30)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <span class="score-badge"
                                                    id="score_bantuan_ambulasi">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '0' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="factor-card">
                                        <div class="factor-title">Terpasang Infus</div>
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <select disabled class="form-select custom-select"
                                                    name="risiko_jatuh_morse_terpasang_infus"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">Pilih kondisi</option>
                                                    <option value="0"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_terpasang_infus ?? '') == '0' ? 'selected' : '' }}>
                                                        Tidak (Skor: 0)</option>
                                                    <option value="20"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_terpasang_infus ?? '') == '20' ? 'selected' : '' }}>
                                                        Ya (Skor: 20)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <span class="score-badge"
                                                    id="score_terpasang_infus">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_terpasang_infus ?? '0' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="factor-card">
                                        <div class="factor-title">Gaya Berjalan</div>
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <select disabled class="form-select custom-select"
                                                    name="risiko_jatuh_morse_cara_berjalan"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">Pilih kondisi</option>
                                                    <option value="0"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '') == '0' ? 'selected' : '' }}>
                                                        Normal / bedrest / kursi roda (Skor: 0)</option>
                                                    <option value="10"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '') == '10' ? 'selected' : '' }}>
                                                        Lemah (Skor: 10)</option>
                                                    <option value="20"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '') == '20' ? 'selected' : '' }}>
                                                        Terganggu (Skor: 20)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <span class="score-badge"
                                                    id="score_cara_berjalan">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '0' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="factor-card">
                                        <div class="factor-title">Status Mental</div>
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <select disabled class="form-select custom-select"
                                                    name="risiko_jatuh_morse_status_mental"
                                                    onchange="updateConclusion('morse')">
                                                    <option value="">Pilih kondisi</option>
                                                    <option value="0"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_status_mental ?? '') == '0' ? 'selected' : '' }}>
                                                        Berorientasi pada kemampuannya (Skor: 0)</option>
                                                    <option value="15"
                                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_status_mental ?? '') == '15' ? 'selected' : '' }}>
                                                        Lupa akan keterbatasannya (Skor: 15)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <span class="score-badge"
                                                    id="score_status_mental">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_status_mental ?? '0' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="total-score-card">
                                        <h4 class="mb-3">TOTAL SKOR</h4>
                                        <div class="score-display" id="totalSkorMorse">0</div>
                                    </div>

                                    <div class="risk-level-cards">
                                        <div class="risk-card risk-low" id="resikoRendahMorse">
                                            <div>Resiko Rendah</div>
                                            <div>(0-24)</div>
                                        </div>
                                        <div class="risk-card risk-medium" id="resikoSedangMorse">
                                            <div>Resiko Sedang</div>
                                            <div>(25-44)</div>
                                        </div>
                                        <div class="risk-card risk-high" id="resikoTinggiMorse">
                                            <div>Resiko Tinggi</div>
                                            <div>(>45)</div>
                                        </div>
                                    </div>

                                    <div class="conclusion alert alert-success">
                                        <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                        <p class="conclusion-text mb-0 fs-5"><span
                                                id="kesimpulanMorse">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_kesimpulan ?? 'Risiko Rendah' }}</span>
                                        </p>
                                        <input type="hidden" name="risiko_jatuh_morse_kesimpulan"
                                            id="risiko_jatuh_morse_kesimpulan"
                                            value="{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_morse_kesimpulan ?? 'Risiko Rendah' }}">
                                    </div>
                                </div>

                                <!-- Form Skala Ontario -->
                                <div id="skala_ontarioForm" class="risk-form"
                                    style="display: {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->resiko_jatuh_jenis ?? '') == '4' ? 'block' : 'none' }};">
                                    <h5 class="mb-4 text-center">6.B. PENGKAJIAN RESIKO JATUH KHUSUS LANSIA/ GERIATRI
                                        (Usia > 60 Thn)</h5>

                                    <div class="parameter-section">
                                        <div class="parameter-title">1. Riwayat Jatuh</div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Apakah pasien datang ke rumah sakit karena jatuh?
                                            </div>
                                            <select disabled class="form-select custom-select"
                                                name="ontario_jatuh_saat_masuk" onchange="updateConclusion('ontario')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="6"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_jatuh_saat_masuk ?? '') == '6' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_jatuh_saat_masuk ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Jika tidak, apakah pasien mengalami jatuh dalam 2
                                                bulan terakhir ini?</div>
                                            <select disabled class="form-select custom-select"
                                                name="ontario_jatuh_2_bulan" onchange="updateConclusion('ontario')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="6"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_jatuh_2_bulan ?? '') == '6' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_jatuh_2_bulan ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="text-muted small">Keterangan: Salah satu jawaban ya = 6</div>
                                        <div class="text-end mt-2">
                                            <span class="score-badge" id="skor_riwayat_jatuh">0</span>
                                        </div>
                                    </div>

                                    <div class="parameter-section">
                                        <div class="parameter-title">2. Status Mental</div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Apakah pasien delirium? (Tidak dapat membuat
                                                keputusan, pola pikir tidak terorganisir, gangguan daya ingat)</div>
                                            <select disabled class="form-select custom-select" name="ontario_delirium"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="14"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_delirium ?? '') == '14' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_delirium ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Apakah pasien disorientasi? (salah menyebutkan
                                                waktu, tempat atau orang)</div>
                                            <select disabled class="form-select custom-select"
                                                name="ontario_disorientasi" onchange="updateConclusion('ontario')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="14"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_disorientasi ?? '') == '14' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_disorientasi ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Apakah pasien mengalami agitasi? (keresahan,
                                                gelisah, dan cemas)</div>
                                            <select disabled class="form-select custom-select" name="ontario_agitasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="14"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_agitasi ?? '') == '14' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_agitasi ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="text-muted small">Keterangan: Salah satu jawaban ya = 14</div>
                                        <div class="text-end mt-2">
                                            <span class="score-badge" id="skor_status_mental">0</span>
                                        </div>
                                    </div>

                                    <div class="parameter-section">
                                        <div class="parameter-title">3. Penglihatan</div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Apakah pasien memakai kacamata?</div>
                                            <select disabled class="form-select custom-select" name="ontario_kacamata"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_kacamata ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_kacamata ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Apakah pasien mengalami adanya penglihatan buram?
                                            </div>
                                            <select disabled class="form-select custom-select"
                                                name="ontario_penglihatan_buram" onchange="updateConclusion('ontario')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_penglihatan_buram ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_penglihatan_buram ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Apakah pasien mempunyai Glaukoma/katarak/degenerasi
                                                makula?</div>
                                            <select disabled class="form-select custom-select" name="ontario_glaukoma"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_glaukoma ?? '') == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_glaukoma ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="text-muted small">Keterangan: Salah satu jawaban ya = 1</div>
                                        <div class="text-end mt-2">
                                            <span class="score-badge" id="skor_penglihatan">0</span>
                                        </div>
                                    </div>

                                    <div class="parameter-section">
                                        <div class="parameter-title">4. Kebiasaan berkemih</div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Apakah terdapat perubahan perilaku berkemih?
                                                (frekuensi, urgensi, inkontinensia, noktura)</div>
                                            <select disabled class="form-select custom-select" name="ontario_berkemih"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">Pilih jawaban</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_berkemih ?? '') == '2' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_berkemih ?? '') == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="text-muted small">Keterangan: Ya = 2</div>
                                        <div class="text-end mt-2">
                                            <span class="score-badge" id="skor_berkemih">0</span>
                                        </div>
                                    </div>

                                    <div class="parameter-section">
                                        <div class="parameter-title">5. Transfer (dari tempat tidur ke kursi dan kembali
                                            lagi ke tempat tidur)</div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Kemampuan Transfer Pasien:</div>
                                            <select disabled class="form-select custom-select" name="ontario_transfer"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_transfer ?? '') == '0' ? 'selected' : '' }}>
                                                    Mandiri (boleh memakai alat bantu jalan)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_transfer ?? '') == '1' ? 'selected' : '' }}>
                                                    Memerlukan sedikit bantuan (1 orang) / dalam pengawasan</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_transfer ?? '') == '2' ? 'selected' : '' }}>
                                                    Memerlukan bantuan yang nyata (2 orang)</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_transfer ?? '') == '3' ? 'selected' : '' }}>
                                                    Tidak dapat duduk dengan seimbang, perlu bantuan total</option>
                                            </select>
                                        </div>
                                        <div class="text-muted small">
                                            <div>0 = Mandiri</div>
                                            <div>1 = Bantuan 1 orang</div>
                                            <div>2 = Bantuan 2 orang</div>
                                            <div>3 = Bantuan total</div>
                                        </div>
                                    </div>

                                    <div class="parameter-section">
                                        <div class="parameter-title">6. Mobilitas</div>
                                        <div class="sub-question-card">
                                            <div class="question-text">Kemampuan Mobilitas Pasien:</div>
                                            <select disabled class="form-select custom-select" name="ontario_mobilitas"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_mobilitas ?? '') == '0' ? 'selected' : '' }}>
                                                    Mandiri (boleh menggunakan alat bantu jalan)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_mobilitas ?? '') == '1' ? 'selected' : '' }}>
                                                    Berjalan dengan bantuan 1 orang (verbal/fisik)</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_mobilitas ?? '') == '2' ? 'selected' : '' }}>
                                                    Menggunakan kursi roda</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->ontario_mobilitas ?? '') == '3' ? 'selected' : '' }}>
                                                    Imobilisasi</option>
                                            </select>
                                        </div>
                                        <div class="text-muted small">
                                            <div>0 = Mandiri</div>
                                            <div>1 = Bantuan 1 orang</div>
                                            <div>2 = Kursi roda</div>
                                            <div>3 = Imobilisasi</div>
                                            <div class="mt-2 fw-bold">Jumlah nilai transfer dan mobilitas:</div>
                                            <div>Jika nilai total 0 s/d 6, maka skor = 0</div>
                                            <div>Jika nilai > 6, maka skor = 3</div>
                                        </div>
                                        <div class="text-end mt-2">
                                            <span class="score-badge" id="skor_transfer_mobilitas">0</span>
                                        </div>
                                    </div>

                                    <div class="total-score-card">
                                        <h4 class="mb-3">TOTAL SKOR</h4>
                                        <div class="score-display" id="totalSkorOntario">0</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-center mb-3">
                                                <strong>Keterangan skor:</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="risk-level-cards">
                                        <div class="risk-card risk-low" id="resikoRendahOntario">
                                            <div>Resiko Rendah</div>
                                            <div>(0-5)</div>
                                        </div>
                                        <div class="risk-card risk-medium" id="resikoSedangOntario">
                                            <div>Resiko Sedang</div>
                                            <div>(6-16)</div>
                                        </div>
                                        <div class="risk-card risk-high" id="resikoTinggiOntario">
                                            <div>Resiko Tinggi</div>
                                            <div>(17-30)</div>
                                        </div>
                                    </div>

                                    <div class="conclusion alert alert-success">
                                        <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                        <p class="conclusion-text mb-0 fs-5"><span
                                                id="kesimpulanOntario">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_lansia_kesimpulan ?? 'Risiko Rendah' }}</span>
                                        </p>
                                        <input type="hidden" name="risiko_jatuh_lansia_kesimpulan"
                                            id="risiko_jatuh_lansia_kesimpulan"
                                            value="{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_jatuh_lansia_kesimpulan ?? 'Risiko Rendah' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Risiko Decubitus -->
                        <div class="section-separator" id="risiko_decubitus">
                            <h5 class="section-title">8. PENGKAJIAN RISIKO DECUBITUS (SKALA NORTON)</h5>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih jenis penilaian risiko decubitus:</label>
                                <select disabled class="form-select custom-select" id="risikoDecubitusSkala"
                                    name="resiko_decubitus_jenis" onchange="showDecubitusForm(this.value)">
                                    <option value="">--Pilih Skala--</option>
                                    <option value="norton"
                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->resiko_decubitus_jenis ?? '') == 'norton' ? 'selected' : '' }}>
                                        Skala Norton</option>
                                </select>
                            </div>

                            <!-- Form Skala Norton -->
                            <div id="skala_nortonForm" class="risk-form"
                                style="display: {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->resiko_decubitus_jenis ?? '') == 'norton' ? 'block' : 'none' }};">
                                <h5 class="mb-4 text-center">8. PENGKAJIAN RISIKO DECUBITUS (SKALA NORTON)</h5>

                                <div class="factor-card">
                                    <div class="factor-title">Kondisi Fisik</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <select disabled class="form-select custom-select"
                                                name="norton_kondisi_fisik" onchange="updateConclusion('norton')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="4"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_fisik ?? '') == '4' ? 'selected' : '' }}>
                                                    Baik (Skor: 4)</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_fisik ?? '') == '3' ? 'selected' : '' }}>
                                                    Cukup (Skor: 3)</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_fisik ?? '') == '2' ? 'selected' : '' }}>
                                                    Buruk (Skor: 2)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_fisik ?? '') == '1' ? 'selected' : '' }}>
                                                    Sangat buruk (Skor: 1)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="score-badge"
                                                id="skor_kondisi_fisik">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_fisik ?? '0' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="factor-card">
                                    <div class="factor-title">Kondisi Mental</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <select disabled class="form-select custom-select"
                                                name="norton_kondisi_mental" onchange="updateConclusion('norton')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="4"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_mental ?? '') == '4' ? 'selected' : '' }}>
                                                    Compos mentis (Skor: 4)</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_mental ?? '') == '3' ? 'selected' : '' }}>
                                                    Apatis (Skor: 3)</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_mental ?? '') == '2' ? 'selected' : '' }}>
                                                    Delirium (Skor: 2)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_mental ?? '') == '1' ? 'selected' : '' }}>
                                                    Stupor (Skor: 1)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="score-badge"
                                                id="skor_kondisi_mental">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_mental ?? '0' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="factor-card">
                                    <div class="factor-title">Aktivitas</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <select disabled class="form-select custom-select" name="norton_aktivitas"
                                                onchange="updateConclusion('norton')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="4"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_aktivitas ?? '') == '4' ? 'selected' : '' }}>
                                                    Mandiri (Skor: 4)</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_aktivitas ?? '') == '3' ? 'selected' : '' }}>
                                                    Dipapah (Skor: 3)</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_aktivitas ?? '') == '2' ? 'selected' : '' }}>
                                                    Kursi roda (Skor: 2)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_aktivitas ?? '') == '1' ? 'selected' : '' }}>
                                                    Tirah baring (Skor: 1)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="score-badge"
                                                id="skor_aktivitas">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->norton_aktivitas ?? '0' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="factor-card">
                                    <div class="factor-title">Mobilitas</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <select disabled class="form-select custom-select" name="norton_mobilitas"
                                                onchange="updateConclusion('norton')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="4"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_mobilitas ?? '') == '4' ? 'selected' : '' }}>
                                                    Baik (Skor: 4)</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_mobilitas ?? '') == '3' ? 'selected' : '' }}>
                                                    Agak terbatas (Skor: 3)</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_mobilitas ?? '') == '2' ? 'selected' : '' }}>
                                                    Sangat terbatas (Skor: 2)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_mobilitas ?? '') == '1' ? 'selected' : '' }}>
                                                    Immobilisasi (Skor: 1)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="score-badge"
                                                id="skor_mobilitas">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->norton_mobilitas ?? '0' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="factor-card">
                                    <div class="factor-title">Inkontinensia</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <select disabled class="form-select custom-select"
                                                name="norton_inkontinensia" onchange="updateConclusion('norton')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="4"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_inkontinensia ?? '') == '4' ? 'selected' : '' }}>
                                                    Tidak (Skor: 4)</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_inkontinensia ?? '') == '3' ? 'selected' : '' }}>
                                                    Terkadang (Skor: 3)</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_inkontinensia ?? '') == '2' ? 'selected' : '' }}>
                                                    Sering (Skor: 2)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_inkontinensia ?? '') == '1' ? 'selected' : '' }}>
                                                    Selalu (Skor: 1)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="score-badge"
                                                id="skor_inkontinensia">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->norton_inkontinensia ?? '0' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="total-score-card">
                                    <h4 class="mb-3">TOTAL SKOR</h4>
                                    <div class="score-display" id="totalSkorNorton">
                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_fisik ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_mental ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_aktivitas ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_mobilitas ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_inkontinensia ?? 0) }}
                                    </div>
                                </div>

                                <div class="risk-level-cards">
                                    <div class="risk-card risk-low" id="resikoRendahNorton">
                                        <div>Resiko Rendah</div>
                                        <div>(16-20)</div>
                                    </div>
                                    <div class="risk-card risk-medium" id="resikoSedangNorton">
                                        <div>Resiko Sedang</div>
                                        <div>(12-15)</div>
                                    </div>
                                    <div class="risk-card risk-high" id="resikoTinggiNorton">
                                        <div>Resiko Tinggi</div>
                                        <div>(&lt; 12)</div>
                                    </div>
                                </div>

                                <div
                                    class="conclusion alert {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_fisik ?? 0) +
                                        ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_mental ?? 0) +
                                        ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_aktivitas ?? 0) +
                                        ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_mobilitas ?? 0) +
                                        ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_inkontinensia ?? 0) <
                                    12
                                        ? 'alert-danger'
                                        : (($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_fisik ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_kondisi_mental ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_aktivitas ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_mobilitas ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->norton_inkontinensia ?? 0) <=
                                        15
                                            ? 'alert-warning'
                                            : 'alert-success') }}">
                                    <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                    <p class="conclusion-text mb-0 fs-5"><span
                                            id="kesimpulanNorton">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_norton_kesimpulan ?? 'Risiko Rendah' }}</span>
                                    </p>
                                    <input type="hidden" name="risiko_norton_kesimpulan"
                                        id="risiko_norton_kesimpulan"
                                        value="{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->risiko_norton_kesimpulan ?? 'Risiko Rendah' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Aktivitas Harian -->
                        <div class="section-separator" id="aktivitas_harian">
                            <h5 class="section-title">9. PENGKAJIAN AKTIVITAS HARIAN (ADL)</h5>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih penilaian aktivitas harian:</label>
                                <select disabled class="form-select custom-select" id="aktivitasHarianSkala"
                                    name="aktivitas_harian_jenis" onchange="showADLForm(this.value)">
                                    <option value="">--Pilih Skala--</option>
                                    <option value="adl"
                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->aktivitas_harian_jenis ?? '') == 'adl' ? 'selected' : '' }}>
                                        Pengkajian ADL</option>
                                </select>
                            </div>

                            <!-- Form ADL -->
                            <div id="skala_adlForm" class="risk-form"
                                style="display: {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->aktivitas_harian_jenis ?? '') == 'adl' ? 'block' : 'none' }};">
                                <h5 class="mb-4 text-center">9. PENGKAJIAN AKTIVITAS HARIAN (ADL)</h5>

                                <div class="factor-card">
                                    <div class="factor-title">Makan / Memakai baju</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <select disabled class="form-select custom-select" name="adl_makan"
                                                onchange="updateConclusion('adl')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_makan ?? '') == '0' ? 'selected' : '' }}>
                                                    Mandiri (Skor: 0)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_makan ?? '') == '1' ? 'selected' : '' }}>
                                                    25% Dibantu (Skor: 1)</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_makan ?? '') == '2' ? 'selected' : '' }}>
                                                    50% Dibantu (Skor: 2)</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_makan ?? '') == '3' ? 'selected' : '' }}>
                                                    75% Dibantu (Skor: 3)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="score-badge"
                                                id="skor_makan">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->adl_makan ?? '0' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="factor-card">
                                    <div class="factor-title">Berjalan</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <select disabled class="form-select custom-select" name="adl_berjalan"
                                                onchange="updateConclusion('adl')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_berjalan ?? '') == '0' ? 'selected' : '' }}>
                                                    Mandiri (Skor: 0)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_berjalan ?? '') == '1' ? 'selected' : '' }}>
                                                    25% Dibantu (Skor: 1)</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_berjalan ?? '') == '2' ? 'selected' : '' }}>
                                                    50% Dibantu (Skor: 2)</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_berjalan ?? '') == '3' ? 'selected' : '' }}>
                                                    75% Dibantu (Skor: 3)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="score-badge"
                                                id="skor_berjalan">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->adl_berjalan ?? '0' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="factor-card">
                                    <div class="factor-title">Mandi / buang air</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <select disabled class="form-select custom-select" name="adl_mandi"
                                                onchange="updateConclusion('adl')">
                                                <option value="">Pilih kondisi</option>
                                                <option value="0"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_mandi ?? '') == '0' ? 'selected' : '' }}>
                                                    Mandiri (Skor: 0)</option>
                                                <option value="1"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_mandi ?? '') == '1' ? 'selected' : '' }}>
                                                    25% Dibantu (Skor: 1)</option>
                                                <option value="2"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_mandi ?? '') == '2' ? 'selected' : '' }}>
                                                    50% Dibantu (Skor: 2)</option>
                                                <option value="3"
                                                    {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_mandi ?? '') == '3' ? 'selected' : '' }}>
                                                    75% Dibantu (Skor: 3)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span class="score-badge"
                                                id="skor_mandi">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->adl_mandi ?? '0' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="total-score-card">
                                    <h4 class="mb-3">TOTAL SKOR</h4>
                                    <div class="score-display" id="totalSkorADL">
                                        {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_makan ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_berjalan ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_mandi ?? 0) }}
                                    </div>
                                </div>

                                <div
                                    class="conclusion alert {{ ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_makan ?? 0) +
                                        ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_berjalan ?? 0) +
                                        ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_mandi ?? 0) ==
                                    0
                                        ? 'alert-success'
                                        : (($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_makan ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_berjalan ?? 0) +
                                            ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_mandi ?? 0) <=
                                        3
                                            ? 'alert-info'
                                            : (($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_makan ?? 0) +
                                                ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_berjalan ?? 0) +
                                                ($asesmen->asesmenKetDewasaRanapResikoJatuh->adl_mandi ?? 0) <=
                                            6
                                                ? 'alert-warning'
                                                : 'alert-danger')) }}">
                                    <h6 class="fw-bold mb-2">Kesimpulan Penilaian:</h6>
                                    <p class="conclusion-text mb-0 fs-5"><span
                                            id="kesimpulanADL">{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->adl_kesimpulan ?? 'Mandiri (Skor: 0)' }}</span>
                                    </p>
                                    <input type="hidden" name="adl_kesimpulan" id="adl_kesimpulan"
                                        value="{{ $asesmen->asesmenKetDewasaRanapResikoJatuh->adl_kesimpulan ?? 'Mandiri' }}">
                                </div>
                            </div>
                        </div>

                        <!-- PENGKAJIAN EDUKASI/ PENDIDIKAN DAN PENGAJARAN -->
                        <div class="section-separator" id="pengkajian_edukasi">
                            <h5 class="section-title">10. PENGKAJIAN EDUKASI/ PENDIDIKAN DAN PENGAJARAN</h5>

                            <!-- Bicara -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Bicara:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="bicara[]"
                                                id="bicara_normal" value="normal"
                                                {{ in_array('normal', old('bicara', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->bicara ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bicara_normal">Normal</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="bicara[]"
                                                id="bicara_tidak_normal" value="tidak_normal"
                                                {{ in_array('tidak_normal', old('bicara', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->bicara ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bicara_tidak_normal">Tidak
                                                normal</label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input disabled type="text" class="form-control" name="bicara_lainnya"
                                            value="{{ $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->bicara_lainnya }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Bahasa sehari-hari -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Bahasa sehari-hari:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="bahasa_sehari[]" id="bahasa_sehari_indonesia" value="indonesia"
                                                {{ in_array('indonesia', old('bahasa_sehari', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->bahasa_sehari ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bahasa_sehari_indonesia">Indonesia
                                                (aktif/ pasif)</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="bahasa_sehari[]" id="bahasa_sehari_daerah" value="daerah"
                                                {{ in_array('daerah', old('bahasa_sehari', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->bahasa_sehari ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bahasa_sehari_daerah">Daerah</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="bahasa_sehari[]" id="bahasa_sehari_asing" value="asing"
                                                {{ in_array('asing', old('bahasa_sehari', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->bahasa_sehari ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="bahasa_sehari_asing">Bahasa
                                                asing</label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input disabled type="text" class="form-control"
                                            name="bahasa_sehari_lainnya"
                                            value="{{ $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->bahasa_sehari_lainnya }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Perlu penerjemah -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Perlu penerjemah:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="penerjemah[]" id="tidak_perlu_penerjemah" value="tidak"
                                                {{ in_array('tidak', old('penerjemah', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->penerjemah ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tidak_perlu_penerjemah">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="penerjemah[]" id="perlu_penerjemah_ya" value="ya"
                                                {{ in_array('ya', old('penerjemah', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->penerjemah ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perlu_penerjemah_ya">Ya, bahasa</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="penerjemah[]" id="perlu_penerjemah_bahasa_isyarat"
                                                value="bahasa_isyarat"
                                                {{ in_array('bahasa_isyarat', old('penerjemah', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->penerjemah ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perlu_penerjemah_bahasa_isyarat">Bahasa
                                                isyarat</label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input disabled type="text" class="form-control" name="penerjemah_bahasa"
                                            value="{{ $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->penerjemah_bahasa }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Hambatan komunikasi/ belajar -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Hambatan komunikasi/ belajar:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="hambatan[]"
                                                id="belajar_bahasa_hambatan" value="bahasa"
                                                {{ in_array('bahasa', old('hambatan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->hambatan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="belajar_bahasa_hambatan">Bahasa</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="hambatan[]"
                                                id="belajar_menulis" value="menulis"
                                                {{ in_array('menulis', old('hambatan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->hambatan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="belajar_menulis">Menulis</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="hambatan[]"
                                                id="belajar_cemas" value="cemas"
                                                {{ in_array('cemas', old('hambatan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->hambatan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="belajar_cemas">Cemas</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox" name="hambatan[]"
                                                id="belajar_lain_hambatan" value="lain"
                                                {{ in_array('lain', old('hambatan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->hambatan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="belajar_lain_hambatan">lain-lain</label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input disabled type="text" class="form-control" name="hambatan_lainnya"
                                            value="{{ $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->hambatan_lainnya }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Cara komunikasi yang disukai -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Cara komunikasi yang disukai:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="cara_komunikasi[]" id="komunikasi_audio_visual"
                                                value="audio_visual"
                                                {{ in_array('audio_visual', old('cara_komunikasi', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->cara_komunikasi ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="komunikasi_audio_visual">Audio-visual/
                                                gambar</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="cara_komunikasi[]" id="komunikasi_diskusi" value="diskusi"
                                                {{ in_array('diskusi', old('cara_komunikasi', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->cara_komunikasi ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="komunikasi_diskusi">Diskusi</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="cara_komunikasi[]" id="komunikasi_lain_komunikasi"
                                                value="lain"
                                                {{ in_array('lain', old('cara_komunikasi', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->cara_komunikasi ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="komunikasi_lain_komunikasi">Lain-lain</label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input disabled type="text" class="form-control"
                                            name="cara_komunikasi_lainnya"
                                            value="{{ $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->cara_komunikasi_lainnya }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Tingkat pendidikan -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tingkat pendidikan:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="pendidikan[]" id="pendidikan_tk" value="tk"
                                                {{ in_array('tk', old('pendidikan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->pendidikan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pendidikan_tk">TK</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="pendidikan[]" id="pendidikan_sd" value="sd"
                                                {{ in_array('sd', old('pendidikan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->pendidikan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pendidikan_sd">SD</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="pendidikan[]" id="pendidikan_smp" value="smp"
                                                {{ in_array('smp', old('pendidikan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->pendidikan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pendidikan_smp">SMP</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="pendidikan[]" id="pendidikan_smu" value="smu"
                                                {{ in_array('smu', old('pendidikan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->pendidikan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pendidikan_smu">SMU</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="pendidikan[]" id="pendidikan_akademi" value="akademi"
                                                {{ in_array('akademi', old('pendidikan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->pendidikan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pendidikan_akademi">Akademi</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="pendidikan[]" id="pendidikan_sarjana" value="sarjana"
                                                {{ in_array('sarjana', old('pendidikan', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->pendidikan ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pendidikan_sarjana">Sarjana</label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input disabled type="text" class="form-control" name="pendidikan_detail"
                                            value="{{ $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->pendidikan_detail }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Potensi kebutuhan pembelajaran -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Potensi kebutuhan pembelajaran:</label>
                                <div class="col-sm-10">
                                    <div class="d-flex flex-wrap gap-4">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="potensi_pembelajaran[]" id="potensi_proses_penyakit"
                                                value="proses_penyakit"
                                                {{ in_array('proses_penyakit', old('potensi_pembelajaran', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->potensi_pembelajaran ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="potensi_proses_penyakit">Proses
                                                penyakit</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="potensi_pembelajaran[]" id="potensi_pengobatan_tindakan"
                                                value="pengobatan_tindakan"
                                                {{ in_array('pengobatan_tindakan', old('potensi_pembelajaran', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->potensi_pembelajaran ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="potensi_pengobatan_tindakan">Pengobatan/tindakan</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="checkbox"
                                                name="potensi_pembelajaran[]" id="potensi_terapi_obat"
                                                value="terapi_obat"
                                                {{ in_array('terapi_obat', old('potensi_pembelajaran', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->potensi_pembelajaran ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="potensi_terapi_obat">Terapi/obat</label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="potensi_pembelajaran[]" id="potensi_nutrisi" value="nutrisi"
                                                    {{ in_array('nutrisi', old('potensi_pembelajaran', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->potensi_pembelajaran ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="potensi_nutrisi">Nutrisi</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="potensi_pembelajaran[]" id="lain_pembelajaran"
                                                    value="lain"
                                                    {{ in_array('lain', old('potensi_pembelajaran', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->potensi_pembelajaran ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="lain_pembelajaran">Lain-lain</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input disabled type="text" class="form-control"
                                            name="potensi_pembelajaran_lainnya"
                                            value="{{ $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->potensi_pembelajaran_lainnya }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Catatan Khusus -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Catatan Khusus:</label>
                                <div class="col-sm-10">
                                    <textarea disabled class="form-control" name="catatan_khusus" rows="4">{{ old('catatan_khusus', $asesmen->asesmenKetDewasaRanapPengkajianEdukasi->catatan_khusus ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Perencanaan Pulang Pasien (Discharge Planning) -->
                        <div class="section-separator" id="discharge-planning">
                            <h5 class="section-title">11. Perencanaan Pulang Pasien (Discharge Planning)</h5>

                            {{-- <div class="mb-4">
                            <label class="form-label">Diagnosis medis</label>
                            <input disabled type="text" class="form-control" name="diagnosis_medis"
                                value="{{ $asesmen->asesmenKetDewasaRanapDischargePlanning->diagnosis_medis }}">
                        </div> --}}

                            <div class="mb-4">
                                <label class="form-label">Usia lanjut (>60 th)</label>
                                <select disabled class="form-select" name="usia_lanjut">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ $asesmen->asesmenKetDewasaRanapDischargePlanning->usia_lanjut == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ $asesmen->asesmenKetDewasaRanapDischargePlanning->usia_lanjut == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Hambatan mobilitas</label>
                                <select disabled class="form-select" name="hambatan_mobilisasi">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ $asesmen->asesmenKetDewasaRanapDischargePlanning->hambatan_mobilisasi == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ $asesmen->asesmenKetDewasaRanapDischargePlanning->hambatan_mobilisasi == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Membutuhkan pelayanan medis berkelanjutan</label>
                                <select disabled class="form-select" name="penggunaan_media_berkelanjutan">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ $asesmen->asesmenKetDewasaRanapDischargePlanning->penggunaan_media_berkelanjutan == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ $asesmen->asesmenKetDewasaRanapDischargePlanning->penggunaan_media_berkelanjutan == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Keteraturan dalam mengonsumsi obat dalam aktivitas
                                    harian</label>
                                <select disabled class="form-select" name="ketergantungan_aktivitas">
                                    <option value="" selected disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ $asesmen->asesmenKetDewasaRanapDischargePlanning->ketergantungan_aktivitas == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ $asesmen->asesmenKetDewasaRanapDischargePlanning->ketergantungan_aktivitas == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Rencana Pulang Khusus</label>
                                <input disabled type="text" class="form-control" name="rencana_pulang_khusus"
                                    value="{{ $asesmen->asesmenKetDewasaRanapDischargePlanning->rencana_pulang_khusus }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Rencana Lama Perawatan</label>
                                <input disabled type="text" class="form-control" name="rencana_lama_perawatan"
                                    value="{{ $asesmen->asesmenKetDewasaRanapDischargePlanning->rencana_lama_perawatan }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Rencana Tanggal Pulang</label>
                                <input disabled type="date" class="form-control" name="rencana_tgl_pulang"
                                    value="{{ $asesmen->asesmenKetDewasaRanapDischargePlanning->rencana_tgl_pulang }}">
                            </div>

                            <div class="mt-4">
                                <label class="form-label">KESIMPULAN</label>
                                <div class="d-flex flex-column gap-2">
                                    <div class="alert alert-info d-none" id="reason-alert">
                                        <!-- Alasan akan ditampilkan di sini -->
                                    </div>
                                    <div class="alert alert-warning d-none" id="special-plan-alert">
                                        Membutuhkan rencana pulang khusus
                                    </div>
                                    <div class="alert alert-success d-none" id="no-special-plan-alert">
                                        Tidak membutuhkan rencana pulang khusus
                                    </div>
                                </div>
                                <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                    value="{{ $asesmen->asesmenKetDewasaRanapDischargePlanning->kesimpulan_planing ?? 'Tidak membutuhkan rencana pulang khusus' }}">
                            </div>
                        </div>

                        <!-- Diet Khusus -->
                        <div class="section-separator" id="diet_khusus">
                            <h5 class="section-title">12. DIET KHUSUS</h5>
                            <div class="mb-4">
                                <label class="form-label">Diet Khusus:</label>
                                <input disabled type="text" class="form-control" name="diet_khusus"
                                    value="{{ old('diet_khusus', $asesmen->asesmenKetDewasaRanapDietKhusus->diet_khusus ?? '') }}">
                            </div>

                            <!-- Ada pengaruh perawatan terhadap -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Ada pengaruh perawatan terhadap:</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="pengaruh_perawatan[]" id="pasien_keluarga"
                                                    value="pasien_keluarga"
                                                    {{ in_array(
                                                        'pasien_keluarga',
                                                        old(
                                                            'pengaruh_perawatan',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="pasien_keluarga">1. Pasien/
                                                    Keluarga</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input disabled class="form-check-input" type="radio"
                                                        name="pengaruh_ya_tidak_1" id="pengaruh_ya_1" value="ya"
                                                        {{ old('pengaruh_ya_tidak_1', $asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_ya_tidak_1 ?? '') === 'ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pengaruh_ya_1">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input disabled class="form-check-input" type="radio"
                                                        name="pengaruh_ya_tidak_1" id="pengaruh_tidak_1"
                                                        value="tidak"
                                                        {{ old('pengaruh_ya_tidak_1', $asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_ya_tidak_1 ?? '') === 'tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pengaruh_tidak_1">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="pengaruh_perawatan[]" id="pekerjaan" value="pekerjaan"
                                                    {{ in_array(
                                                        'pekerjaan',
                                                        old(
                                                            'pengaruh_perawatan',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="pelayanan">2. Pekerjaan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input disabled class="form-check-input" type="radio"
                                                        name="pengaruh_ya_tidak_2" id="pengaruh_ya_2" value="ya"
                                                        {{ old('pengaruh_ya_tidak_2', $asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_ya_tidak_2 ?? '') === 'ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pengaruh_ya_2">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input disabled class="form-check-input" type="radio"
                                                        name="pengaruh_ya_tidak_2" id="pengaruh_tidak_2"
                                                        value="tidak"
                                                        {{ old('pengaruh_ya_tidak_2', $asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_ya_tidak_2 ?? '') === 'tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pengaruh_tidak_2">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="pengaruh_perawatan[]" id="keuangan" value="keuangan"
                                                    {{ in_array(
                                                        'keuangan',
                                                        old(
                                                            'pengaruh_perawatan',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_perawatan, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="keuangan">3. Keuangan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input disabled class="form-check-input" type="radio"
                                                        name="pengaruh_ya_tidak_3" id="pengaruh_ya_3" value="ya"
                                                        {{ old('pengaruh_ya_tidak_3', $asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_ya_tidak_3 ?? '') === 'ya' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pengaruh_ya_3">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input disabled class="form-check-input" type="radio"
                                                        name="pengaruh_ya_tidak_3" id="pengaruh_tidak_3"
                                                        value="tidak"
                                                        {{ old('pengaruh_ya_tidak_3', $asesmen->asesmenKetDewasaRanapDietKhusus->pengaruh_ya_tidak_3 ?? '') === 'tidak' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="pengaruh_tidak_3">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Apakah pasien hidup/tinggal sendiri -->
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Apakah pasien hidup/tinggal sendiri setelah keluar
                                    dari rumah sakit?</label>
                                <div class="col-sm-6">
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="hidup_sendiri" id="hidup_ya" value="1"
                                                {{ old('1', $asesmen->asesmenKetDewasaRanapDietKhusus->hidup_sendiri ?? '') === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hidup_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="hidup_sendiri" id="hidup_tidak" value="tidak"
                                                {{ old('0', $asesmen->asesmenKetDewasaRanapDietKhusus->hidup_sendiri ?? '') === '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hidup_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Antisipasi terhadap masalah saat pulang -->
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Antisipasi terhadap masalah saat pulang:</label>
                                <div class="col-sm-6">
                                    <div class="d-flex gap-3 mb-2">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="antisipasi_masalah" id="antisipasi_tidak" value="0"
                                                {{ old('0', $asesmen->asesmenKetDewasaRanapDietKhusus->antisipasi_masalah ?? '') === '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="antisipasi_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="antisipasi_masalah" id="antisipasi_ya" value="1"
                                                {{ old('1', $asesmen->asesmenKetDewasaRanapDietKhusus->antisipasi_masalah ?? '') === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="antisipasi_ya">Ya</label>
                                        </div>
                                    </div>
                                    <input disabled type="text" class="form-control" name="antisipasi_jelaskan"
                                        value="{{ old('antisipasi_jelaskan', $asesmen->asesmenKetDewasaRanapDietKhusus->antisipasi_jelaskan ?? '') }}">
                                </div>
                            </div>

                            <!-- Memerlukan bantuan dalam hal -->
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Memerlukan bantuan dalam hal:</label>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="bantuan_hal[]" id="makan_minum" value="makan_minum"
                                                    {{ in_array(
                                                        'makan_minum',
                                                        old(
                                                            'bantuan_hal',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="makan_minum">Makan/ minum</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="bantuan_hal[]" id="konsumsi_obat" value="konsumsi_obat"
                                                    {{ in_array(
                                                        'konsumsi_obat',
                                                        old(
                                                            'bantuan_hal',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="konsumsi_obat">Konsumsi
                                                    obat</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="bantuan_hal[]" id="berpakaian" value="berpakaian"
                                                    {{ in_array(
                                                        'berpakaian',
                                                        old(
                                                            'bantuan_hal',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="berpakaian">Berpakaian</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="bantuan_hal[]" id="perawatan_luka" value="perawatan_luka"
                                                    {{ in_array(
                                                        'perawatan_luka',
                                                        old(
                                                            'bantuan_hal',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="perawatan_luka">Perawatan
                                                    luka</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="bantuan_hal[]" id="mandi_berpakaian"
                                                    value="mandi_berpakaian"
                                                    {{ in_array(
                                                        'mandi_berpakaian',
                                                        old(
                                                            'bantuan_hal',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="mandi_berpakaian">Mandi &
                                                    Berpakaian</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="bantuan_hal[]" id="menyiapkan_makanan"
                                                    value="menyiapkan_makanan"
                                                    {{ in_array(
                                                        'menyiapkan_makanan',
                                                        old(
                                                            'bantuan_hal',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="menyiapkan_makanan">Menyiapkan
                                                    makanan</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="bantuan_hal[]" id="edukasi_kesehatan"
                                                    value="edukasi_kesehatan"
                                                    {{ in_array(
                                                        'edukasi_kesehatan',
                                                        old(
                                                            'bantuan_hal',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="edukasi_kesehatan">Edukasi
                                                    Kesehatan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input disabled class="form-check-input" type="checkbox"
                                                    name="bantuan_hal[]" id="lainnya_bantuan" value="lainnya"
                                                    {{ in_array(
                                                        'lainnya',
                                                        old(
                                                            'bantuan_hal',
                                                            is_array($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal)
                                                                ? $asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                : ($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal
                                                                    ? json_decode($asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_hal, true)
                                                                    : []),
                                                        ),
                                                    )
                                                        ? 'checked'
                                                        : '' }}>
                                                <label class="form-check-label" for="lainnya_bantuan">Lainnya</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <input disabled type="text" class="form-control" name="bantuan_lainnya"
                                            value="{{ old('bantuan_lainnya', $asesmen->asesmenKetDewasaRanapDietKhusus->bantuan_lainnya ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Apakah pasien menggunakan peralatan medis -->
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Apakah pasien menggunakan peralatan medis di rumah
                                    setelah keluar rumah sakit (Kateter, NGT, Double lumen, Oksigen dll)?</label>
                                <div class="col-sm-6">
                                    <div class="d-flex gap-3 mb-2">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="peralatan_medis" id="peralatan_tidak" value="0"
                                                {{ old('0', $asesmen->asesmenKetDewasaRanapDietKhusus->peralatan_medis ?? '') === '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="peralatan_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="peralatan_medis" id="peralatan_ya" value="ya"
                                                {{ old('1', $asesmen->asesmenKetDewasaRanapDietKhusus->peralatan_medis ?? '') === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="peralatan_ya">Ya</label>
                                        </div>
                                    </div>
                                    <input disabled type="text" class="form-control" name="peralatan_jelaskan"
                                        value="{{ old('peralatan_jelaskan', $asesmen->asesmenKetDewasaRanapDietKhusus->peralatan_jelaskan ?? '') }}">
                                </div>
                            </div>

                            <!-- Apakah pasien memerlukan alat bantu -->
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Apakah pasien memerlukan alat bantu setelah keluar
                                    rumah sakit (ex: kursi roda, tongkat, walker dll)?</label>
                                <div class="col-sm-6">
                                    <div class="d-flex gap-3 mb-2">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio" name="alat_bantu"
                                                id="alat_bantu_tidak" value="0"
                                                {{ old('0', $asesmen->asesmenKetDewasaRanapDietKhusus->alat_bantu ?? '') === '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="alat_bantu_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio" name="alat_bantu"
                                                id="alat_bantu_ya" value="1"
                                                {{ old('1', $asesmen->asesmenKetDewasaRanapDietKhusus->alat_bantu ?? '') === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="alat_bantu_ya">Ya</label>
                                        </div>
                                    </div>
                                    <input disabled type="text" class="form-control" name="alat_bantu_jelaskan"
                                        value="{{ old('alat_bantu_jelaskan', $asesmen->asesmenKetDewasaRanapDietKhusus->alat_bantu_jelaskan ?? '') }}">
                                </div>
                            </div>

                            <!-- Apakah pasien memerlukan bantuan perawatan khusus -->
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Apakah memerlukan bantuan /perawatan khusus di
                                    rumah setelah keluar rumah sakit (homecare, home visit)?</label>
                                <div class="col-sm-6">
                                    <div class="d-flex gap-3 mb-2">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="perawatan_khusus" id="perawatan_khusus_tidak" value="0"
                                                {{ old('0', $asesmen->asesmenKetDewasaRanapDietKhusus->perawatan_khusus ?? '') === '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perawatan_khusus_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="perawatan_khusus" id="perawatan_khusus_ya" value="1"
                                                {{ old('0', $asesmen->asesmenKetDewasaRanapDietKhusus->perawatan_khusus ?? '') === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perawatan_khusus_ya">Ya</label>
                                        </div>
                                    </div>
                                    <input disabled type="text" class="form-control"
                                        name="perawatan_khusus_jelaskan"
                                        value="{{ old('perawatan_khusus_jelaskan', $asesmen->asesmenKetDewasaRanapDietKhusus->perawatan_khusus_jelaskan ?? '') }}">
                                </div>
                            </div>

                            <!-- Apakah pasien memiliki nyeri kronis -->
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Apakah pasien memiliki nyeri kronis dan kelelahan
                                    setelah keluar dari rumah sakit?</label>
                                <div class="col-sm-6">
                                    <div class="d-flex gap-3 mb-2">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="nyeri_kronis" id="nyeri_kronis_tidak" value="0"
                                                {{ old('1', $asesmen->asesmenKetDewasaRanapDietKhusus->nyeri_kronis ?? '') === '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nyeri_kronis_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="nyeri_kronis" id="nyeri_kronis_ya" value="1"
                                                {{ old('1', $asesmen->asesmenKetDewasaRanapDietKhusus->nyeri_kronis ?? '') === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="nyeri_kronis_ya">Ya</label>
                                        </div>
                                    </div>
                                    <input disabled type="text" class="form-control" name="nyeri_kronis_jelaskan"
                                        value="{{ old('nyeri_kronis_jelaskan', $asesmen->asesmenKetDewasaRanapDietKhusus->nyeri_kronis_jelaskan ?? '') }}">
                                </div>
                            </div>

                            <!-- Apakah pasien/ keluarga memerlukan keterampilan khusus -->
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Apakah pasien/ keluarga memerlukan keterampilan
                                    khusus setelah keluar dari rumah sakit (perawatan luka, injeksi, perawatan bayi,
                                    dll)?</label>
                                <div class="col-sm-6">
                                    <div class="d-flex gap-3 mb-2">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="keterampilan_khusus" id="keterampilan_tidak" value="0"
                                                {{ old('0', $asesmen->asesmenKetDewasaRanapDietKhusus->keterampilan_khusus ?? '') === '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="keterampilan_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="keterampilan_khusus" id="keterampilan_ya" value="1"
                                                {{ old('1', $asesmen->asesmenKetDewasaRanapDietKhusus->keterampilan_khusus ?? '') === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="keterampilan_ya">Ya</label>
                                        </div>
                                    </div>
                                    <input disabled type="text" class="form-control" name="keterampilan_jelaskan"
                                        value="{{ old('keterampilan_jelaskan', $asesmen->asesmenKetDewasaRanapDietKhusus->keterampilan_jelaskan ?? '') }}">
                                </div>
                            </div>

                            <!-- Apakah pasien perlu dirujuk ke komunitas -->
                            <div class="row mb-3">
                                <label class="col-sm-6 col-form-label">Apakah pasien perlu dirujuk ke komunitas?</label>
                                <div class="col-sm-6">
                                    <div class="d-flex gap-3 mb-2">
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="dirujuk_komunitas" id="dirujuk_tidak" value="0"
                                                {{ old('0', $asesmen->asesmenKetDewasaRanapDietKhusus->dirujuk_komunitas ?? '') === '0' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="dirujuk_tidak">Tidak</label>
                                        </div>
                                        <div class="form-check">
                                            <input disabled class="form-check-input" type="radio"
                                                name="dirujuk_komunitas" id="dirujuk_ya" value="1"
                                                {{ old('1', $asesmen->asesmenKetDewasaRanapDietKhusus->dirujuk_komunitas ?? '') === '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="dirujuk_ya">Ya</label>
                                        </div>
                                    </div>
                                    <input disabled type="text" class="form-control" name="dirujuk_jelaskan"
                                        value="{{ old('dirujuk_jelaskan', $asesmen->asesmenKetDewasaRanapDietKhusus->dirujuk_jelaskan ?? '') }}">
                                </div>
                            </div>

                            <!-- Catatan Khusus -->
                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label">CATATAN KHUSUS:</label>
                                <div class="col-sm-10">
                                    <textarea disabled class="form-control" name="catatan_khusus_diet" rows="4">{{ old('catatan_khusus_diet', $asesmen->asesmenKetDewasaRanapDietKhusus->catatan_khusus_diet ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- MASALAH/ DIAGNOSIS KEPERAWATAN  -->
                        <div class="section-separator" id="masalah_diagnosis">
                            <h5 class="section-title">13. MASALAH/ DIAGNOSIS KEPERAWATAN</h5>
                            <p class="text-muted mb-4">(Diisi berdasarkan hasil asesmen dan berurut sesuai masalah yang
                                dominan terlebih dahulu)</p>

                            <!-- Diagnosis Keperawatan Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-primary">
                                        <tr>
                                            <th width="50%">DIAGNOSA KEPERAWATAN</th>
                                            <th width="50%">RENCANA KEPERAWATAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- 1. Bersihan Jalan Nafas Tidak Efektif -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input rencana-perawatan-row-1"
                                                        type="checkbox" name="diagnosis[]"
                                                        value="bersihan_jalan_nafas" id="diag_bersihan_jalan_nafas"
                                                        onchange="toggleRencana('bersihan_jalan_nafas')"
                                                        {{ in_array('bersihan_jalan_nafas', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_bersihan_jalan_nafas">
                                                        <strong>Bersihan jalan nafas tidak efektif</strong> berhubungan
                                                        dengan spasme jalan nafas...
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input rencana-perawatan-row-1"
                                                        type="checkbox" name="diagnosis[]" value="risiko_aspirasi"
                                                        id="diag_risiko_aspirasi"
                                                        onchange="toggleRencana('risiko_aspirasi')"
                                                        {{ in_array('risiko_aspirasi', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_risiko_aspirasi">
                                                        <strong>Risiko aspirasi</strong> berhubungan dengan tingkat
                                                        kesadaran...
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input rencana-perawatan-row-1"
                                                        type="checkbox" name="diagnosis[]"
                                                        value="pola_nafas_tidak_efektif"
                                                        id="diag_pola_nafas_tidak_efektif"
                                                        onchange="toggleRencana('pola_nafas_tidak_efektif')"
                                                        {{ in_array('pola_nafas_tidak_efektif', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_pola_nafas_tidak_efektif">
                                                        <strong>Pola nafas tidak efektif</strong> berhubungan dengan depresi
                                                        pusat pernafasan...
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_bersihan_jalan_nafas" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="monitor_pola_nafas"
                                                            {{ in_array('monitor_pola_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor pola nafas ( frekuensi ,
                                                            kedalaman, usaha nafas )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="monitor_bunyi_nafas"
                                                            {{ in_array('monitor_bunyi_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor bunyi nafas tambahan (
                                                            mengi, wheezing, rhonchi )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]" value="monitor_sputum"
                                                            {{ in_array('monitor_sputum', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor sputum ( jumlah, warna,
                                                            aroma )</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="monitor_tingkat_kesadaran"
                                                            {{ in_array('monitor_tingkat_kesadaran', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tingkat kesadaran, batuk,
                                                            muntah dan kemampuan menelan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="monitor_kemampuan_batuk"
                                                            {{ in_array('monitor_kemampuan_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kemampuan batuk
                                                            efektif</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="pertahankan_kepatenan"
                                                            {{ in_array('pertahankan_kepatenan', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan kepatenan jalan nafas
                                                            dengan head-tilt dan chin -lift ( jaw – thrust jika curiga
                                                            trauma servikal ) </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="posisikan_semi_fowler"
                                                            {{ in_array('posisikan_semi_fowler', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisikan semi fowler atau
                                                            fowler</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="berikan_minum_hangat"
                                                            {{ in_array('berikan_minum_hangat', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan minum hangat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="fisioterapi_dada"
                                                            {{ in_array('fisioterapi_dada', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan fisioterapi dada, jika
                                                            perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="keluarkan_benda_padat"
                                                            {{ in_array('keluarkan_benda_padat', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Keluarkan benda padat dengan
                                                            forcep</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="penghisapan_lendir"
                                                            {{ in_array('penghisapan_lendir', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan penghisapan lendir</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="berikan_oksigen"
                                                            {{ in_array('berikan_oksigen', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="anjuran_asupan_cairan"
                                                            {{ in_array('anjuran_asupan_cairan', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjuran asupan cairan 2000
                                                            ml/hari, jika tidak kontra indikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="ajarkan_teknik_batuk"
                                                            {{ in_array('ajarkan_teknik_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik batuk
                                                            efektif</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_bersihan_jalan_nafas[]"
                                                            value="kolaborasi_pemberian_obat"
                                                            {{ in_array('kolaborasi_pemberian_obat', old('rencana_bersihan_jalan_nafas', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian
                                                            bronkodilator, ekspektoran, mukolitik, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 2. Penurunan Curah Jantung -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="penurunan_curah_jantung"
                                                        id="diag_penurunan_curah_jantung"
                                                        onchange="toggleRencana('penurunan_curah_jantung')"
                                                        {{ in_array('penurunan_curah_jantung', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}
                                                        onchange="toggleRencana('diag_penurunan_curah_jantung')">
                                                    <label class="form-check-label" for="diag_penurunan_curah_jantung">
                                                        <strong>Penurunan curah jantung</strong> berhubungan dengan
                                                        perubahan irama jantung, perubahan frekuensi jantung.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_penurunan_curah_jantung" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="identifikasi_tanda_gejala"
                                                            {{ in_array('identifikasi_tanda_gejala', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi tanda/gejala primer
                                                            penurunan curah jantung (meliputi dipsnea, kelelahan,
                                                            edema)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_tekanan_darah"
                                                            {{ in_array('monitor_tekanan_darah', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tekanan darah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_intake_output"
                                                            {{ in_array('monitor_intake_output', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output
                                                            cairan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_saturasi_oksigen"
                                                            {{ in_array('monitor_saturasi_oksigen', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor saturasi oksigen</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_keluhan_nyeri"
                                                            {{ in_array('monitor_keluhan_nyeri', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keluhan nyeri dada
                                                            (intensitas, lokasi, durasi, presivitasi yang mengurangi
                                                            nyeri)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="monitor_aritmia"
                                                            {{ in_array('monitor_aritmia', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor aritmia (kelainan irama
                                                            dan frekuensi)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="posisikan_pasien"
                                                            {{ in_array('posisikan_pasien', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisikan pasien semi fowler atau
                                                            fowler dengan kaki kebawah atau posisi nyaman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="berikan_terapi_relaksasi"
                                                            {{ in_array('berikan_terapi_relaksasi', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan therapi relaksasi untuk
                                                            mengurangi stres, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="berikan_dukungan_emosional"
                                                            {{ in_array('berikan_dukungan_emosional', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan dukungan emosional dan
                                                            spirital</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="berikan_oksigen_saturasi"
                                                            {{ in_array('berikan_oksigen_saturasi', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen untuk
                                                            mempertahankan saturasi oksigen >94%</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="anjurkan_beraktifitas"
                                                            {{ in_array('anjurkan_beraktifitas', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan beraktifitas fisik sesuai
                                                            toleransi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="anjurkan_berhenti_merokok"
                                                            {{ in_array('anjurkan_berhenti_merokok', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="ajarkan_mengukur_intake"
                                                            {{ in_array('ajarkan_mengukur_intake', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan pasien dan keluarga
                                                            mengukur intake dan output cairan harian</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_penurunan_curah_jantung[]"
                                                            value="kolaborasi_pemberian_terapi"
                                                            {{ in_array('kolaborasi_pemberian_terapi', old('rencana_penurunan_curah_jantung', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 3. Perfusi Perifer Tidak Efektif -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="perfusi_perifer"
                                                        id="diag_perfusi_perifer"
                                                        onchange="toggleRencana('perfusi_perifer')"
                                                        {{ in_array('perfusi_perifer', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_perfusi_perifer">
                                                        <strong>Perfusi perifer tidak efektif</strong> berhubungan dengan
                                                        hyperglikemia, penurunan konsentrasi hemoglobin, peningkatan tekanan
                                                        darah, kekurangan volume cairan, penurunan aliran arteri dan/atau
                                                        vena, kurang terpapar informasi tentang proses penyakit (misal:
                                                        diabetes melitus, hiperlipidmia).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_perfusi_perifer" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]" value="periksa_sirkulasi"
                                                            {{ in_array('periksa_sirkulasi', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa sirkulasi perifer (edema,
                                                            pengisian kapiler/CRT, suhu)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="identifikasi_faktor_risiko"
                                                            {{ in_array('identifikasi_faktor_risiko', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko
                                                            gangguan sirkulasi (diabetes, perokok, hipertensi, kadar
                                                            kolesterol tinggi)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="monitor_suhu_kemerahan"
                                                            {{ in_array('monitor_suhu_kemerahan', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor suhu, kemerahan, nyeri
                                                            atau bengkak pada ekstremitas.</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="hindari_pemasangan_infus"
                                                            {{ in_array('hindari_pemasangan_infus', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pemasangan infus atau
                                                            pengambilan darah di area keterbatasan perfusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="hindari_pengukuran_tekanan"
                                                            {{ in_array('hindari_pengukuran_tekanan', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pengukuran tekanan darah
                                                            pada ekstremitas dengan keterbatasan perfusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]" value="hindari_penekanan"
                                                            {{ in_array('hindari_penekanan', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari penekanan dan pemasangan
                                                            tourniqet pada area yang cedera</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="lakukan_pencegahan_infeksi"
                                                            {{ in_array('lakukan_pencegahan_infeksi', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan pencegahan infeksi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]" value="perawatan_kaki_kuku"
                                                            {{ in_array('perawatan_kaki_kuku', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan perawatan kaki dan
                                                            kuku</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="anjurkan_berhenti_merokok_perfusi"
                                                            {{ in_array('anjurkan_berhenti_merokok_perfusi', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berhenti merokok</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="anjurkan_berolahraga"
                                                            {{ in_array('anjurkan_berolahraga', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berolahraga rutin</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]" value="anjurkan_minum_obat"
                                                            {{ in_array('anjurkan_minum_obat', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan minum obat pengontrol
                                                            tekanan darah secara teratur</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_perfusi_perifer[]"
                                                            value="kolaborasi_terapi_perfusi"
                                                            {{ in_array('kolaborasi_terapi_perfusi', old('rencana_perfusi_perifer', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 4. Hipovolemia -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="hipovolemia" id="diag_hipovolemia"
                                                        onchange="toggleRencana('hipovolemia')"
                                                        {{ in_array('hipovolemia', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_hipovolemia">
                                                        <strong>Hipovolemia</strong> berhubungan dengan kehilangan cairan
                                                        aktif, peningkatan permeabilitas kapiler, kekurangan intake cairan,
                                                        evaporasi.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_hipovolemia" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]" value="periksa_tanda_gejala"
                                                            {{ in_array('periksa_tanda_gejala', old('rencana_hipovolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala
                                                            hipovolemia (frekuensi nadi meningkat, nadi teraba lemah,
                                                            tekanan darah penurun, turgor kulit menurun, membran mukosa
                                                            kering, volume urine menurun, haus, lemah)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]"
                                                            value="monitor_intake_output_hipovolemia"
                                                            {{ in_array('monitor_intake_output_hipovolemia', old('rencana_hipovolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output
                                                            cairan</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]" value="berikan_asupan_cairan"
                                                            {{ in_array('berikan_asupan_cairan', old('rencana_hipovolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan asupan cairan oral</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]" value="posisi_trendelenburg"
                                                            {{ in_array('posisi_trendelenburg', old('rencana_hipovolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Posisi modified
                                                            trendelenburg</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]"
                                                            value="anjurkan_memperbanyak_cairan"
                                                            {{ in_array('anjurkan_memperbanyak_cairan', old('rencana_hipovolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memperbanyak asupan
                                                            cairan oral</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]"
                                                            value="hindari_perubahan_posisi"
                                                            {{ in_array('hindari_perubahan_posisi', old('rencana_hipovolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menghindari perubahan
                                                            posisi mendadak</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipovolemia[]"
                                                            value="kolaborasi_terapi_hipovolemia"
                                                            {{ in_array('kolaborasi_terapi_hipovolemia', old('rencana_hipovolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 5. Hipervolemia -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="hipervolemia" id="diag_hipervolemia"
                                                        onchange="toggleRencana('hipervolemia')"
                                                        {{ in_array('hipervolemia', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_hipervolemia">
                                                        <strong>Hipervolemia</strong> berhubungan dengan kelebihan asupan
                                                        cairan, kelebihan asupan natrium, gangguan aliran balik vena.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_hipervolemia" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="periksa_tanda_hipervolemia"
                                                            {{ in_array('periksa_tanda_hipervolemia', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala
                                                            hipervolemia (dipsnea, edema, suara nafas tambahan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="identifikasi_penyebab_hipervolemia"
                                                            {{ in_array('identifikasi_penyebab_hipervolemia', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab
                                                            hipervolemia</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]" value="monitor_hemodinamik"
                                                            {{ in_array('monitor_hemodinamik', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor status hemodinamik
                                                            (frekuensi jantung, tekanan darah)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="monitor_intake_output_hipervolemia"
                                                            {{ in_array('monitor_intake_output_hipervolemia', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor intake dan output
                                                            cairan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]" value="monitor_efek_diuretik"
                                                            {{ in_array('monitor_efek_diuretik', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping diuretik
                                                            (hipotensi ortostatik, hipovolemia, hipokalemia,
                                                            hiponatremia)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]" value="timbang_berat_badan"
                                                            {{ in_array('timbang_berat_badan', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Timbang berat badan setiap hari
                                                            pada waktu yang sama</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]" value="batasi_asupan_cairan"
                                                            {{ in_array('batasi_asupan_cairan', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi asupan cairan dan
                                                            garam</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="tinggi_kepala_tempat_tidur"
                                                            {{ in_array('tinggi_kepala_tempat_tidur', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tinggi kepala tempat tidur 30 – 40
                                                            º</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="ajarkan_mengukur_cairan"
                                                            {{ in_array('ajarkan_mengukur_cairan', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mengukur dan mencatat
                                                            asupan dan haluaran cairan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="ajarkan_membatasi_cairan"
                                                            {{ in_array('ajarkan_membatasi_cairan', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara membatasi
                                                            cairan</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipervolemia[]"
                                                            value="kolaborasi_terapi_hipervolemia"
                                                            {{ in_array('kolaborasi_terapi_hipervolemia', old('rencana_hipervolemia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 6. Diare -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="diare" id="diag_diare"
                                                        onchange="toggleRencana('diare')"
                                                        {{ in_array('diare', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_diare">
                                                        <strong>Diare</strong> berhubungan dengan inflamasi
                                                        gastrointestinal, iritasi gastrointestinal, proses infeksi,
                                                        malabsorpsi.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_diare" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="identifikasi_penyebab_diare"
                                                            {{ in_array('identifikasi_penyebab_diare', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab diare
                                                            (inflamasi gastrointestinal, iritasi gastrointestinal, proses
                                                            infeksi, malabsorpsi, ansietas, stres, efek samping
                                                            obat)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="identifikasi_riwayat_makanan"
                                                            {{ in_array('identifikasi_riwayat_makanan', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi riwayat pemberian
                                                            makanan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]"
                                                            value="identifikasi_gejala_invaginasi"
                                                            {{ in_array('identifikasi_gejala_invaginasi', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi riwayat gejala
                                                            invaginasi (tangisan keras, kepucatan pada bayi)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="monitor_warna_volume_tinja"
                                                            {{ in_array('monitor_warna_volume_tinja', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor warna, volume, frekuensi
                                                            dan konsistensi tinja</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="monitor_tanda_hipovolemia"
                                                            {{ in_array('monitor_tanda_hipovolemia', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda dan gejala
                                                            hipovolemia (takikardi, nadi teraba lemah, tekanan darah turun,
                                                            turgor kulit turun, mukosa mulit kering, CRT melambat, BB
                                                            menurun)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="monitor_iritasi_kulit"
                                                            {{ in_array('monitor_iritasi_kulit', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor iritasi dan ulserasi kulit
                                                            di daerah perianal</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="monitor_jumlah_diare"
                                                            {{ in_array('monitor_jumlah_diare', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor jumlah pengeluaran
                                                            diare</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="berikan_asupan_cairan_oral"
                                                            {{ in_array('berikan_asupan_cairan_oral', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan asupan cairan oral
                                                            (larutan garam gula, oralit, pedialyte)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="pasang_jalur_intravena"
                                                            {{ in_array('pasang_jalur_intravena', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang jalur intravena</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="berikan_cairan_intravena"
                                                            {{ in_array('berikan_cairan_intravena', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan cairan intravena</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="anjurkan_makanan_porsi_kecil"
                                                            {{ in_array('anjurkan_makanan_porsi_kecil', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan makanan porsi kecil dan
                                                            sering secara bertahap</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="hindari_makanan_gas"
                                                            {{ in_array('hindari_makanan_gas', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menghindari makanan
                                                            pembentuk gas, pedas dan mengandung laktosa</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="lanjutkan_asi"
                                                            {{ in_array('lanjutkan_asi', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melanjutkan pemberian
                                                            ASI</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_diare[]" value="kolaborasi_terapi_diare"
                                                            {{ in_array('kolaborasi_terapi_diare', old('rencana_diare', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Koborasi pemberian therapi</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 7. Retensi Urine -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="retensi_urine"
                                                        id="diag_retensi_urine"
                                                        onchange="toggleRencana('retensi_urine')"
                                                        {{ in_array('retensi_urine', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_retensi_urine">
                                                        <strong>Retensi urine</strong> berhubungan dengan peningkatan
                                                        tekanan uretra, kerusakan arkus refleks, Blok spingter, disfungsi
                                                        neurologis (trauma, penyakit saraf), efek agen farmakologis
                                                        (atropine, belladona, psikotropik, antihistamin, opiate).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_retensi_urine" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="identifikasi_tanda_retensi"
                                                            {{ in_array('identifikasi_tanda_retensi', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi tanda dan gejala
                                                            retensi atau inkontinensia urine</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="identifikasi_faktor_penyebab"
                                                            {{ in_array('identifikasi_faktor_penyebab', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang
                                                            menyebabkan retensi atau inkontinensia urine</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="monitor_eliminasi_urine"
                                                            {{ in_array('monitor_eliminasi_urine', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor eliminasi urine
                                                            (frekuensi, konsistensi, aroma, volume dan warna)</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="catat_waktu_berkemih"
                                                            {{ in_array('catat_waktu_berkemih', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Catat waktu-waktu dan haluaran
                                                            berkemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="batasi_asupan_cairan"
                                                            {{ in_array('batasi_asupan_cairan', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi asupan cairan, jika
                                                            perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="ambil_sampel_urine"
                                                            {{ in_array('ambil_sampel_urine', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ambil sampel urine tengah
                                                            (midstream) atau kultur</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="ajarkan_tanda_infeksi"
                                                            {{ in_array('ajarkan_tanda_infeksi', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan tanda dan gejala infeksi
                                                            saluran kemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="ajarkan_mengukur_asupan"
                                                            {{ in_array('ajarkan_mengukur_asupan', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengukur asupan cairan dan
                                                            haluaran urine</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="ajarkan_spesimen_midstream"
                                                            {{ in_array('ajarkan_spesimen_midstream', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengambil spesimen urine
                                                            midstream</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="ajarkan_tanda_berkemih"
                                                            {{ in_array('ajarkan_tanda_berkemih', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan mengenali tanda berkemih
                                                            dan waktu yang tepat untuk berkemih</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="ajarkan_minum_cukup"
                                                            {{ in_array('ajarkan_minum_cukup', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan minum yang cukup, jika
                                                            tidak ada kontraindikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]" value="kurangi_minum_tidur"
                                                            {{ in_array('kurangi_minum_tidur', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan mengurangi minum
                                                            menjelang tidur</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_retensi_urine[]"
                                                            value="kolaborasi_supositoria"
                                                            {{ in_array('kolaborasi_supositoria', old('rencana_retensi_urine', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian obat
                                                            supositoria uretra, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 8. Nyeri Akut -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="nyeri_akut" id="diag_nyeri_akut"
                                                        onchange="toggleRencana('nyeri_akut')"
                                                        {{ in_array('nyeri_akut', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_nyeri_akut">
                                                        <strong>Nyeri akut</strong> b.d agen pencedera fisiologis (inflamsi,
                                                        iskemia, neoplasma), agen pencedera kimiawi (terbakar, bahan kimia
                                                        iritan), agen pencedera fisik (abses, amputasi, terbakar, terpotong,
                                                        mengangkat berat, prosedur operasi, trauma, latihan fisik
                                                        berlebihan).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_nyeri_akut" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_lokasi_nyeri"
                                                            {{ in_array('identifikasi_lokasi_nyeri', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi lokasi,
                                                            karakteristik, durasi, frekuensi, kualitas, intensitas
                                                            nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="identifikasi_skala_nyeri"
                                                            {{ in_array('identifikasi_skala_nyeri', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi skala nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_respons_nonverbal"
                                                            {{ in_array('identifikasi_respons_nonverbal', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi respons nyeri non
                                                            verbal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_faktor_nyeri"
                                                            {{ in_array('identifikasi_faktor_nyeri', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang
                                                            memperberat dan memperingan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_pengetahuan_nyeri"
                                                            {{ in_array('identifikasi_pengetahuan_nyeri', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengetahuan dan
                                                            keyaninan tentang nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_pengaruh_budaya"
                                                            {{ in_array('identifikasi_pengaruh_budaya', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh budaya
                                                            terhadap respon nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="identifikasi_pengaruh_kualitas_hidup"
                                                            {{ in_array('identifikasi_pengaruh_kualitas_hidup', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh nyeri pada
                                                            kualitas hidup</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="monitor_keberhasilan_terapi"
                                                            {{ in_array('monitor_keberhasilan_terapi', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keberhasilan terapi
                                                            komplementer yang sudah diberikan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="monitor_efek_samping_analgetik"
                                                            {{ in_array('monitor_efek_samping_analgetik', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping penggunaan
                                                            analgetil</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="berikan_teknik_nonfarmakologis"
                                                            {{ in_array('berikan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan teknik nonfarmakologis
                                                            untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi
                                                            musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi
                                                            terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="kontrol_lingkungan_nyeri"
                                                            {{ in_array('kontrol_lingkungan_nyeri', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kontrol lingkungan yang
                                                            memperberat rasa nyeri (suhu ruangan, pencahayaan,
                                                            kebisingan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="fasilitasi_istirahat"
                                                            {{ in_array('fasilitasi_istirahat', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi istirahat dan
                                                            tidur</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="pertimbangkan_strategi_nyeri"
                                                            {{ in_array('pertimbangkan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertimbangkan jenis dan sumber
                                                            nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="jelaskan_penyebab_nyeri"
                                                            {{ in_array('jelaskan_penyebab_nyeri', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan penyebab, periode, dan
                                                            pemicu nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="jelaskan_strategi_nyeri"
                                                            {{ in_array('jelaskan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan strategi meredakan
                                                            nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="anjurkan_monitor_nyeri"
                                                            {{ in_array('anjurkan_monitor_nyeri', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memonitor nyeri secara
                                                            mandiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="anjurkan_analgetik"
                                                            {{ in_array('anjurkan_analgetik', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan analgetik
                                                            secara tepat</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]"
                                                            value="ajarkan_teknik_nonfarmakologis"
                                                            {{ in_array('ajarkan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik nonfarmakologis
                                                            untuk mengurangin rasa nyeri</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_akut[]" value="kolaborasi_analgetik"
                                                            {{ in_array('kolaborasi_analgetik', old('rencana_nyeri_akut', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian analgetik,
                                                            jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 9. Nyeri Kronis -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="nyeri_kronis" id="diag_nyeri_kronis"
                                                        onchange="toggleRencana('nyeri_kronis')"
                                                        {{ in_array('nyeri_kronis', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_nyeri_kronis">
                                                        <strong>Nyeri kronis</strong> b.d kondisi muskuloskeletal kronis,
                                                        kerusakan sistem saraf, penekanan saraf, infiltrasi tumor,
                                                        ketidakseimbangan neurotransmiter, neuromodulator, dan reseptor,
                                                        gangguan imunitas, (neuropati terkait HIV, virus varicella-zoster),
                                                        gangguan fungsi metabolik, riwayat posisi kerja statis, peningkatan
                                                        indeks masa tubuh, kondisi pasca trauma, tekanan emosional, riwayat
                                                        penganiayaan (fisik, psikologis, seksual), riwayat penyalahgunaan
                                                        obat/zat.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_nyeri_kronis" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_lokasi_nyeri_kronis"
                                                            {{ in_array('identifikasi_lokasi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi lokasi,
                                                            karakteristik, durasi, frekuensi, kualitas, intensitas
                                                            nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_skala_nyeri_kronis"
                                                            {{ in_array('identifikasi_skala_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi skala nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_respons_nonverbal_kronis"
                                                            {{ in_array('identifikasi_respons_nonverbal_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi respons nyeri non
                                                            verbal</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_faktor_nyeri_kronis"
                                                            {{ in_array('identifikasi_faktor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor yang
                                                            memperberat dan memperingan nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_pengetahuan_nyeri_kronis"
                                                            {{ in_array('identifikasi_pengetahuan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengetahuan dan
                                                            keyaninan tentang nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_pengaruh_budaya_kronis"
                                                            {{ in_array('identifikasi_pengaruh_budaya_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh budaya
                                                            terhadap respon nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="identifikasi_pengaruh_kualitas_hidup_kronis"
                                                            {{ in_array('identifikasi_pengaruh_kualitas_hidup_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi pengaruh nyeri pada
                                                            kualitas hidup</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="monitor_keberhasilan_terapi_kronis"
                                                            {{ in_array('monitor_keberhasilan_terapi_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor keberhasilan terapi
                                                            komplementer yang sudah diberikan</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="monitor_efek_samping_analgetik_kronis"
                                                            {{ in_array('monitor_efek_samping_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor efek samping penggunaan
                                                            analgetil</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="berikan_teknik_nonfarmakologis_kronis"
                                                            {{ in_array('berikan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan teknik nonfarmakologis
                                                            untuk mengurangi rasa nyeri (TENS, hipnosis, akupresur, terapi
                                                            musik, biofeedback, terapi pijat, aromaterapi, teknik imajinasi
                                                            terbimbing, kompres hangat/dingin, terapi bermain)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="kontrol_lingkungan_nyeri_kronis"
                                                            {{ in_array('kontrol_lingkungan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kontrol lingkungan yang
                                                            memperberat rasa nyeri (suhu ruangan, pencahayaan,
                                                            kebisingan)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="fasilitasi_istirahat_kronis"
                                                            {{ in_array('fasilitasi_istirahat_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi istirahat dan
                                                            tidur</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="pertimbangkan_strategi_nyeri_kronis"
                                                            {{ in_array('pertimbangkan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertimbangkan jenis dan sumber
                                                            nyeri dalam pemilihan strategi meredakan nyeri</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="jelaskan_penyebab_nyeri_kronis"
                                                            {{ in_array('jelaskan_penyebab_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan penyebab, periode, dan
                                                            pemicu nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="jelaskan_strategi_nyeri_kronis"
                                                            {{ in_array('jelaskan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan strategi meredakan
                                                            nyeri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="anjurkan_monitor_nyeri_kronis"
                                                            {{ in_array('anjurkan_monitor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memonitor nyeri secara
                                                            mandiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="anjurkan_analgetik_kronis"
                                                            {{ in_array('anjurkan_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan analgetik
                                                            secara tepat</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="ajarkan_teknik_nonfarmakologis_kronis"
                                                            {{ in_array('ajarkan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan teknik nonfarmakologis
                                                            untuk mengurangin rasa nyeri</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_nyeri_kronis[]"
                                                            value="kolaborasi_analgetik_kronis"
                                                            {{ in_array('kolaborasi_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian analgetik,
                                                            jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 10. Hipertermia -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="hipertermia" id="diag_hipertermia"
                                                        onchange="toggleRencana('hipertermia')"
                                                        {{ in_array('hipertermia', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_hipertermia">
                                                        <strong>Hipertermia</strong> b.d dehidrasi, terpapar lingkungan
                                                        panas, peroses penyakit (infeksi, kanker), ketidaksesuaian pakaian
                                                        dengan suhu lingkungan, peningkatan laju metabolisme, respon trauma,
                                                        aktivitas berlebihan, penggunaan inkubator.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_hipertermia" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="identifikasi_penyebab_hipertermia"
                                                            {{ in_array('identifikasi_penyebab_hipertermia', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi penyebab hipertermia
                                                            (dehidrasi, terpapar lingkungan panas, penggunaan
                                                            inkubator)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="monitor_suhu_tubuh"
                                                            {{ in_array('monitor_suhu_tubuh', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor suhu tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="monitor_kadar_elektrolit"
                                                            {{ in_array('monitor_kadar_elektrolit', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kadar elektrolit</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="monitor_haluaran_urine"
                                                            {{ in_array('monitor_haluaran_urine', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor haluaran urine</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="monitor_komplikasi_hipertermia"
                                                            {{ in_array('monitor_komplikasi_hipertermia', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor komplikasi akibat
                                                            hipertermia</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="sediakan_lingkungan_dingin"
                                                            {{ in_array('sediakan_lingkungan_dingin', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Sediakan lingkungan yang
                                                            dingin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="longgarkan_pakaian"
                                                            {{ in_array('longgarkan_pakaian', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Longgarkan atau lepaskan
                                                            pakaian</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="basahi_kipasi_tubuh"
                                                            {{ in_array('basahi_kipasi_tubuh', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Basahi dan kipasi permukaan
                                                            tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="berikan_cairan_oral_hipertermia"
                                                            {{ in_array('berikan_cairan_oral_hipertermia', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan cairan oral</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="ganti_linen_hiperhidrosis"
                                                            {{ in_array('ganti_linen_hiperhidrosis', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ganti linen setiap hari atau lebih
                                                            sering jika mengalami hiperhidrosis (keringat berlebih)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="pendinginan_eksternal"
                                                            {{ in_array('pendinginan_eksternal', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan pendinginan eksternal
                                                            (selimut hipotermia atau kompres dingin pada dahi, leher, dada,
                                                            abdomen, aksila)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="hindari_antipiretik"
                                                            {{ in_array('hindari_antipiretik', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hindari pemberian antipiretik atau
                                                            aspirin</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="berikan_oksigen_hipertermia"
                                                            {{ in_array('berikan_oksigen_hipertermia', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan oksigen, jika
                                                            perlu</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]" value="anjurkan_tirah_baring"
                                                            {{ in_array('anjurkan_tirah_baring', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan tirah baring</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_hipertermia[]"
                                                            value="kolaborasi_cairan_elektrolit"
                                                            {{ in_array('kolaborasi_cairan_elektrolit', old('rencana_hipertermia', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian cairan dan
                                                            elektrolit intravena, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 11. Gangguan Mobilitas Fisik -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="gangguan_mobilitas_fisik"
                                                        id="diag_gangguan_mobilitas_fisik"
                                                        onchange="toggleRencana('gangguan_mobilitas_fisik')"
                                                        {{ in_array('gangguan_mobilitas_fisik', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_gangguan_mobilitas_fisik">
                                                        <strong>Gangguan mobilitas fisik</strong> b.d kerusakan intergritas
                                                        struktur tulang, perubahan metabolisme, ketidakbugaran fisik,
                                                        penurunan kendali otot, penurunan massa otot, penurunan kekuatan
                                                        otot, keterlambatan perkembangan, kekakuan sendi, kontraktur,
                                                        malnutrisi, gangguan muskuloskeletal, gangguan neuromuskular, indeks
                                                        masa tubuh diatas persentil ke-75 seusai usia, efek agen
                                                        farmakologis, program pembatasan gerak, nyeri, kurang terpapar
                                                        informasi tentang aktivitas fisik, kecemasan, gangguan kognitif,
                                                        keengganan melakukan pergerakan, gangguan sensoripersepsi.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_gangguan_mobilitas_fisik" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="identifikasi_nyeri_keluhan"
                                                            {{ in_array('identifikasi_nyeri_keluhan', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Indentifikasi adanya nyeri atau
                                                            keluhan fisik lainnya</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="identifikasi_toleransi_ambulasi"
                                                            {{ in_array('identifikasi_toleransi_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Indetifikasi toleransi fisik
                                                            melakukan ambulasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="monitor_frekuensi_jantung_ambulasi"
                                                            {{ in_array('monitor_frekuensi_jantung_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor frekuensi jantung dan
                                                            tekanan darah sebelum memulai ambulasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="monitor_kondisi_umum_ambulasi"
                                                            {{ in_array('monitor_kondisi_umum_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kondiri umum selama
                                                            melakukan ambulasi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="fasilitasi_aktivitas_ambulasi"
                                                            {{ in_array('fasilitasi_aktivitas_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi aktivitas ambulasi
                                                            dengan alat bantu (tongkat, kruk)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="fasilitasi_mobilisasi_fisik"
                                                            {{ in_array('fasilitasi_mobilisasi_fisik', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Fasilitasi melakukan mobilisasi
                                                            fisik, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="libatkan_keluarga_ambulasi"
                                                            {{ in_array('libatkan_keluarga_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Libatkan keluarga untuk membantu
                                                            pasien dalam meningkatkan ambulasi</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="jelaskan_tujuan_ambulasi"
                                                            {{ in_array('jelaskan_tujuan_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tujuan dan prosedur
                                                            ambulasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="anjurkan_ambulasi_dini"
                                                            {{ in_array('anjurkan_ambulasi_dini', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melakukan ambulasi
                                                            dini</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_mobilitas_fisik[]"
                                                            value="ajarkan_ambulasi_sederhana"
                                                            {{ in_array('ajarkan_ambulasi_sederhana', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan ambulasi sederhana yang
                                                            harus dilakukan (berjalan dari tempat tidur ke kursi roda,
                                                            berjalan dari tempat tidur ke kamar mandi, berjalan sesuai
                                                            toleransi)</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 12. Resiko Infeksi -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="resiko_infeksi"
                                                        id="diag_resiko_infeksi"
                                                        onchange="toggleRencana('resiko_infeksi')"
                                                        {{ in_array('resiko_infeksi', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_resiko_infeksi">
                                                        <strong>Resiko infeksi</strong> b.d efek prosedur invasif, penyakit
                                                        kronis (diabetes melitus), malnutrisi, peningkatan paparan organisme
                                                        patogen lingkungan, ketidakadekuatan pertahanan tubuh primer
                                                        (gangguan persitaltik, kerusakan integritas kulit, perubahan sekresi
                                                        PH, penurunan kerja siliaris, ketuban pecah lama, ketuban pecah
                                                        sebelum waktunya, merokok, statis cairan tubuh), ketidakadekuatan
                                                        pertahanan tubuh sekunder (penurunan hemoglobin, imununosupresi,
                                                        leukopenia, supresi respon inflamasi, vaksinasi tidak adekuat).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_resiko_infeksi" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="monitor_tanda_infeksi_sistemik"
                                                            {{ in_array('monitor_tanda_infeksi_sistemik', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda dan gejala infeksi
                                                            lokal dan sistemik</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="batasi_pengunjung"
                                                            {{ in_array('batasi_pengunjung', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Batasi jumlah pengunjung</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="perawatan_kulit_edema"
                                                            {{ in_array('perawatan_kulit_edema', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan perawatan kulit pada area
                                                            edema</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="cuci_tangan_kontak"
                                                            {{ in_array('cuci_tangan_kontak', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Cuci tangan sebelum dan sesudah
                                                            kontak dengan pasien dan lingkungan pasien</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="pertahankan_teknik_aseptik"
                                                            {{ in_array('pertahankan_teknik_aseptik', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan teknik aseptik pada
                                                            pasien beresiko tinggi</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="jelaskan_tanda_infeksi_edukasi"
                                                            {{ in_array('jelaskan_tanda_infeksi_edukasi', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tanda dan gejala
                                                            infeksi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="ajarkan_cuci_tangan"
                                                            {{ in_array('ajarkan_cuci_tangan', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mencuci tangan dengan
                                                            benar</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="ajarkan_etika_batuk"
                                                            {{ in_array('ajarkan_etika_batuk', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan etika batuk</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="ajarkan_periksa_luka"
                                                            {{ in_array('ajarkan_periksa_luka', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara memeriksa kondisi
                                                            luka atau luka operasi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="anjurkan_asupan_nutrisi"
                                                            {{ in_array('anjurkan_asupan_nutrisi', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan meningkatkan asupan
                                                            nutrisi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]"
                                                            value="anjurkan_asupan_cairan_infeksi"
                                                            {{ in_array('anjurkan_asupan_cairan_infeksi', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan meningkatkan asupan
                                                            cairan</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_infeksi[]" value="kolaborasi_imunisasi"
                                                            {{ in_array('kolaborasi_imunisasi', old('rencana_resiko_infeksi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian imunisasi,
                                                            jika perlu.</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 13. Konstipasi -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="konstipasi" id="diag_konstipasi"
                                                        onchange="toggleRencana('konstipasi')"
                                                        {{ in_array('konstipasi', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_konstipasi">
                                                        <strong>Konstipasi</strong> b.d penurunan motilitas
                                                        gastrointestinal, ketidaadekuatan pertumbuhan gigi, ketidakcukupan
                                                        diet, ketidakcukupan asupan serat, ketidakcukupan asupan serat,
                                                        ketidakcukupan asupan cairan, aganglionik (penyakit Hircsprung),
                                                        kelemahan otot abdomen.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_konstipasi" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="periksa_tanda_gejala_konstipasi"
                                                            {{ in_array('periksa_tanda_gejala_konstipasi', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa tanda dan gejala</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="periksa_pergerakan_usus"
                                                            {{ in_array('periksa_pergerakan_usus', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Periksa pergerakan usus,
                                                            karakteristik feses</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="identifikasi_faktor_risiko_konstipasi"
                                                            {{ in_array('identifikasi_faktor_risiko_konstipasi', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko
                                                            konstipasi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="anjurkan_diet_tinggi_serat"
                                                            {{ in_array('anjurkan_diet_tinggi_serat', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan diet tinggi serat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="masase_abdomen"
                                                            {{ in_array('masase_abdomen', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan masase abdomen, jika
                                                            perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="evakuasi_feses_manual"
                                                            {{ in_array('evakuasi_feses_manual', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lakukan evakuasi feses secara
                                                            manual, jika perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="berikan_enema"
                                                            {{ in_array('berikan_enema', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan enema atau intigasi, jika
                                                            perlu</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="jelaskan_etiologi_konstipasi"
                                                            {{ in_array('jelaskan_etiologi_konstipasi', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan etiologi masalah dan
                                                            alasan tindakan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="anjurkan_peningkatan_cairan_konstipasi"
                                                            {{ in_array('anjurkan_peningkatan_cairan_konstipasi', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan peningkatan asupan
                                                            cairan, jika tidak ada kontraindikasi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]"
                                                            value="ajarkan_mengatasi_konstipasi"
                                                            {{ in_array('ajarkan_mengatasi_konstipasi', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara mengatasi
                                                            konstipasi/impaksi</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_konstipasi[]" value="kolaborasi_obat_pencahar"
                                                            {{ in_array('kolaborasi_obat_pencahar', old('rencana_konstipasi', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi penggunaan obat
                                                            pencahar, jika perlu</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 14. Resiko Jatuh -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="resiko_jatuh" id="diag_resiko_jatuh"
                                                        onchange="toggleRencana('resiko_jatuh')"
                                                        {{ in_array('resiko_jatuh', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="diag_resiko_jatuh">
                                                        <strong>Resiko jatuh</strong> b.d usia lebih dari sama dengan 65
                                                        tahun (pada dewasa) atau kurang dari sama dengan 2 tahun (pada anak)
                                                        Riwayat jatuh, anggota gerak bawah prostesis (buatan), penggunaan
                                                        alat bantu berjalan, penurunan tingkat kesadaran, perubahan fungsi
                                                        kognitif, lingkungan tidak aman (licin, gelap, lingkungan asing),
                                                        kondisi pasca operasi, hipotensi ortostatik, perubahan kadar glukosa
                                                        darah, anemia, kekuatan otot menurun, gangguan pendengaran, gangguan
                                                        keseimbangan, gangguan penglihatan (glaukoma, katarak, ablasio
                                                        retina, neuritis optikus), neuropati, efek agen farmakologis
                                                        (sedasi, alkohol, anastesi umum).
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_resiko_jatuh" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="identifikasi_faktor_risiko_jatuh"
                                                            {{ in_array('identifikasi_faktor_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor risiko jatuh
                                                            (usia >65 tahun, penurunan tingkat kesadaran, defisit kognitif,
                                                            hipotensi ortostatik, gangguan keseimbangan, gangguan
                                                            penglihatan, neuropati)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="identifikasi_risiko_setiap_shift"
                                                            {{ in_array('identifikasi_risiko_setiap_shift', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi risiko jatuh
                                                            setidaknya sekali setiap shift atau sesuai dengan kebijakan
                                                            institusi</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="identifikasi_faktor_lingkungan"
                                                            {{ in_array('identifikasi_faktor_lingkungan', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Identifikasi faktor lingkungan
                                                            yang meningkatkan risiko jatuh (lantai licin, penerangan
                                                            kurang)</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="hitung_risiko_jatuh"
                                                            {{ in_array('hitung_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Hitung risiko jatuh dengan
                                                            menggunakan skala (Fall Morse Scale, humpty dumpty scale), jika
                                                            perlu</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="monitor_kemampuan_berpindah"
                                                            {{ in_array('monitor_kemampuan_berpindah', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor kemampuan berpindah dari
                                                            tempat tidur ke kursi roda dan sebaliknya</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="orientasikan_ruangan"
                                                            {{ in_array('orientasikan_ruangan', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Orientasikan ruangan pada pasien
                                                            dan keluarga</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="pastikan_roda_terkunci"
                                                            {{ in_array('pastikan_roda_terkunci', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pastikan roda tempat tidur dan
                                                            kursi roda selalu dalam kondisi terkunci</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="pasang_handrail"
                                                            {{ in_array('pasang_handrail', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang handrail tempat
                                                            tidur</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="atur_tempat_tidur"
                                                            {{ in_array('atur_tempat_tidur', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Atur tempat tidur mekanis pada
                                                            posisi terendah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="tempatkan_dekat_perawat"
                                                            {{ in_array('tempatkan_dekat_perawat', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Tempatkan pasien berisiko tinggi
                                                            jatuh dekat dengan pantauan perawat dari nurse station</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="gunakan_alat_bantu"
                                                            {{ in_array('gunakan_alat_bantu', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Gunakan alat bantu berjalan (kursi
                                                            roda, walker)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="dekatkan_bel"
                                                            {{ in_array('dekatkan_bel', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Dekatkan bel pemanggil dalam
                                                            jangkauan pasien</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="anjurkan_memanggil_perawat"
                                                            {{ in_array('anjurkan_memanggil_perawat', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan memanggil perawat jika
                                                            membutuhkan bantuan untuk berpindah</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="anjurkan_alas_kaki"
                                                            {{ in_array('anjurkan_alas_kaki', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan menggunakan alas kaki
                                                            yang tidak licin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="anjurkan_berkonsentrasi"
                                                            {{ in_array('anjurkan_berkonsentrasi', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan berkonsentrasi untuk
                                                            menjaga keseimbangan tubuh</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]"
                                                            value="anjurkan_melebarkan_jarak"
                                                            {{ in_array('anjurkan_melebarkan_jarak', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan melebarkan jarak kedua
                                                            kaki untuk meningkatkan keseimbangan saat berdiri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_resiko_jatuh[]" value="ajarkan_bel_pemanggil"
                                                            {{ in_array('ajarkan_bel_pemanggil', old('rencana_resiko_jatuh', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Ajarkan cara menggunakan bel
                                                            pemanggil untuk memanggil perawat</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- 15. Gangguan Integritas Kulit/Jaringan -->
                                        <tr>
                                            <td class="align-top">
                                                <div class="form-check mb-2">
                                                    <input disabled class="form-check-input" type="checkbox"
                                                        name="diagnosis[]" value="gangguan_integritas_kulit"
                                                        id="diag_gangguan_integritas_kulit"
                                                        onchange="toggleRencana('gangguan_integritas_kulit')"
                                                        {{ in_array('gangguan_integritas_kulit', old('diagnosis', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="diag_gangguan_integritas_kulit">
                                                        <strong>Gangguan integritas kulit/jaringan</strong> b.d perubahan
                                                        sirkulasi, perubahan status nutrisi (kelebihan atau kekurangan),
                                                        kekurangan/kelebihan volume cairan, penurunan mobilitas, bahan kimia
                                                        iritatif, suhu lingkungan yang ekstream, faktor mekanis (penekanan
                                                        pada tonjolan tulang, gesekan) atau faktor elektris
                                                        (elektrodiatermi, energi listrik bertegangan tinggi), efek samping
                                                        terapi radiasi, kelembapan, proses penuaan, neuropati perifer,
                                                        perubahan pigmentasi, perubahan hormonal, kurang terpapar informasi
                                                        tentang upaya mempertahankan/melindungi integritas jaringan.
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="align-top">
                                                <div id="rencana_gangguan_integritas_kulit" style="display: none;">
                                                    <strong>Observasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="monitor_karakteristik_luka"
                                                            {{ in_array('monitor_karakteristik_luka', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor karakteristik luka</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="monitor_tanda_infeksi"
                                                            {{ in_array('monitor_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Monitor tanda-tanda
                                                            infeksi</label>
                                                    </div>

                                                    <strong>Terapeutik:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="lepaskan_balutan"
                                                            {{ in_array('lepaskan_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Lepaskan balutan dan plester
                                                            secara perlahan</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="bersihkan_nacl"
                                                            {{ in_array('bersihkan_nacl', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Bersihkan dengan cairan NaCl atau
                                                            pembersih nontoksik</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="bersihkan_jaringan_nekrotik"
                                                            {{ in_array('bersihkan_jaringan_nekrotik', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Bersihkan jaringan
                                                            nekrotik</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="berikan_salep"
                                                            {{ in_array('berikan_salep', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Berikan salep yang sesuai ke
                                                            kulit/lesi, jika perlu</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="pasang_balutan"
                                                            {{ in_array('pasang_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pasang balutan sesuai jenis
                                                            luka</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="pertahankan_teknik_steril"
                                                            {{ in_array('pertahankan_teknik_steril', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Pertahankan teknik steril saat
                                                            melakukan perawatan luka</label>
                                                    </div>

                                                    <strong>Edukasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="jelaskan_tanda_infeksi"
                                                            {{ in_array('jelaskan_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Jelaskan tanda dan gejala
                                                            infeksi</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="anjurkan_makanan_tinggi_protein"
                                                            {{ in_array('anjurkan_makanan_tinggi_protein', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Anjurkan mengkonsumsi makanan
                                                            tinggi kalori dan protein</label>
                                                    </div>

                                                    <strong>Kolaborasi:</strong>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="kolaborasi_debridement"
                                                            {{ in_array('kolaborasi_debridement', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi prosedur
                                                            debridement</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input disabled class="form-check-input" type="checkbox"
                                                            name="rencana_gangguan_integritas_kulit[]"
                                                            value="kolaborasi_antibiotik"
                                                            {{ in_array('kolaborasi_antibiotik', old('rencana_gangguan_integritas_kulit', $asesmen->asesmenKetDewasaRanapDiagnosisKeperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Kolaborasi pemberian
                                                            antibiotik</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </form>
            </x-content-card>
        </div>
    </div>
@endsection
