@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.echocardiography.include')
@include('unit-pelayanan.rawat-inap.pelayanan.echocardiography.include-create')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Perbarui Echocardiography',
                    'description' =>
                        'Perbarui data echocardiography pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form id="echocardiography_form" method="POST"
                    action="{{ route('rawat-inap.echocardiography.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $echocardiography->id]) }}">
                    @csrf
                    @method('PUT')

                    <div class="echocardiography-form">

                        <!-- Informasi Dasar -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-calendar-alt icon-info"></i>
                                <span>INFORMASI DASAR</span>
                            </div>
                            <div class="section-content">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Tanggal:</label>
                                        <input type="date" class="form-control" name="tanggal"
                                            value="{{ old('tanggal', $echocardiography->tanggal) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Jam:</label>
                                        <input type="time" class="form-control" name="jam"
                                            value="{{ old('jam', $echocardiography->jam ? \Carbon\Carbon::parse($echocardiography->jam)->format('H:i') : '') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Diagnosa Klinik:</label>
                                        <input type="text" class="form-control" name="diagnosa_klinik"
                                            value="{{ old('diagnosa_klinik', $echocardiography->diagnosa_klinik) }}"
                                            placeholder="Masukkan diagnosa klinik...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengukuran M-MODE -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-ruler icon-measurement"></i>
                                <span>PENGUKURAN M-MODE</span>
                            </div>
                            <div class="section-content">
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label">IVSd (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="ivsd"
                                            value="{{ old('ivsd', $echocardiography->ivsd) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">LVIDd (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvidd"
                                            value="{{ old('lvidd', $echocardiography->lvidd) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">LVPWd (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvpwd"
                                            value="{{ old('lvpwd', $echocardiography->lvpwd) }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">IVSs (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="ivss"
                                            value="{{ old('ivss', $echocardiography->ivss) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">LVIDs (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvids"
                                            value="{{ old('lvids', $echocardiography->lvids) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">LVPWs (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvpws"
                                            value="{{ old('lvpws', $echocardiography->lvpws) }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">LVEF (Teich) (%):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvef_teich"
                                            value="{{ old('lvef_teich', $echocardiography->lvef_teich) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">LVFS (%):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvfs"
                                            value="{{ old('lvfs', $echocardiography->lvfs) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">RWT:</label>
                                        <input type="text" class="form-control" name="rwt"
                                            value="{{ old('rwt', $echocardiography->rwt) }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">LVMi (g/m²):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvmi"
                                            value="{{ old('lvmi', $echocardiography->lvmi) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">EPSS (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="epss"
                                            value="{{ old('epss', $echocardiography->epss) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">TAPSE (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="tapse"
                                            value="{{ old('tapse', $echocardiography->tapse) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengukuran 2 DIMENSIONS -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-cube icon-dimensions"></i>
                                <span>PENGUKURAN 2 DIMENSIONS</span>
                            </div>
                            <div class="section-content">
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label">A4Ch EDV (ml):</label>
                                        <input type="number" step="0.1" class="form-control" name="a4ch_edv"
                                            value="{{ old('a4ch_edv', $echocardiography->a4ch_edv) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">A4Ch ESV (ml):</label>
                                        <input type="number" step="0.1" class="form-control" name="a4ch_esv"
                                            value="{{ old('a4ch_esv', $echocardiography->a4ch_esv) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">EF A4Ch (%):</label>
                                        <input type="number" step="0.1" class="form-control" name="ef_a4ch"
                                            value="{{ old('ef_a4ch', $echocardiography->ef_a4ch) }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">A2Ch EDV (ml):</label>
                                        <input type="number" step="0.1" class="form-control" name="a2ch_edv"
                                            value="{{ old('a2ch_edv', $echocardiography->a2ch_edv) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">A2Ch ESV (ml):</label>
                                        <input type="number" step="0.1" class="form-control" name="a2ch_esv"
                                            value="{{ old('a2ch_esv', $echocardiography->a2ch_esv) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">EF A2Ch (%):</label>
                                        <input type="number" step="0.1" class="form-control" name="ef_a2ch"
                                            value="{{ old('ef_a2ch', $echocardiography->ef_a2ch) }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">EF Biplane (%):</label>
                                        <input type="number" step="0.1" class="form-control" name="ef_biplane"
                                            value="{{ old('ef_biplane', $echocardiography->ef_biplane) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">LAVI (ml/m²):</label>
                                        <input type="number" step="0.1" class="form-control" name="lavi"
                                            value="{{ old('lavi', $echocardiography->lavi) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">LVOT Diameter (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvot_diameter"
                                            value="{{ old('lvot_diameter', $echocardiography->lvot_diameter) }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">LVOT Area (cm²):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvot_area"
                                            value="{{ old('lvot_area', $echocardiography->lvot_area) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">RV ann. diameter (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="rv_ann_diameter"
                                            value="{{ old('rv_ann_diameter', $echocardiography->rv_ann_diameter) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">RV mid cavity (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="rv_mid_cavity"
                                            value="{{ old('rv_mid_cavity', $echocardiography->rv_mid_cavity) }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">RA major axis (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="ra_major_axis"
                                            value="{{ old('ra_major_axis', $echocardiography->ra_major_axis) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengukuran DOPPLER -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-wave-square icon-doppler"></i>
                                <span>PENGUKURAN DOPPLER</span>
                            </div>
                            <div class="section-content">
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <label class="form-label">PV Acct (mm):</label>
                                        <input type="number" step="0.1" class="form-control" name="pv_acct"
                                            value="{{ old('pv_acct', $echocardiography->pv_acct) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">RVOT VMAX (m/s):</label>
                                        <input type="number" step="0.1" class="form-control" name="rvot_vmax"
                                            value="{{ old('rvot_vmax', $echocardiography->rvot_vmax) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">E VELOCITY (m/s):</label>
                                        <input type="number" step="0.1" class="form-control" name="e_velocity"
                                            value="{{ old('e_velocity', $echocardiography->e_velocity) }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">A VELOCITY (m/s):</label>
                                        <input type="number" step="0.1" class="form-control" name="a_velocity"
                                            value="{{ old('a_velocity', $echocardiography->a_velocity) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">E/A:</label>
                                        <input type="number" step="0.1" class="form-control" name="e_a_ratio"
                                            value="{{ old('e_a_ratio', $echocardiography->e_a_ratio) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">E' (m/s):</label>
                                        <input type="number" step="0.1" class="form-control" name="e_prime"
                                            value="{{ old('e_prime', $echocardiography->e_prime) }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="form-label">E/E':</label>
                                        <input type="number" step="0.1" class="form-control" name="e_e_prime_ratio"
                                            value="{{ old('e_e_prime_ratio', $echocardiography->e_e_prime_ratio) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">E Desc. Time (ms):</label>
                                        <input type="number" step="1" class="form-control" name="e_desc_time"
                                            value="{{ old('e_desc_time', $echocardiography->e_desc_time) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">LVOT VMAX (m/s):</label>
                                        <input type="number" step="0.1" class="form-control" name="lvot_vmax"
                                            value="{{ old('lvot_vmax', $echocardiography->lvot_vmax) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-file-alt icon-description"></i>
                                <span>DESKRIPSI</span>
                            </div>
                            <div class="section-content">
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <textarea class="form-control" name="deskripsi" rows="6"
                                            placeholder="Masukkan deskripsi hasil pemeriksaan...">{{ old('deskripsi', $echocardiography->deskripsi) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kesimpulan -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-clipboard-check icon-conclusion"></i>
                                <span>KESIMPULAN</span>
                            </div>
                            <div class="section-content">
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <textarea class="form-control" name="kesimpulan" rows="4"
                                            placeholder="Masukkan kesimpulan hasil pemeriksaan...">{{ old('kesimpulan', $echocardiography->kesimpulan) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dokter Pemeriksa -->
                        <div class="form-section">
                            <div class="section-header">
                                <i class="fas fa-user-md icon-doctor"></i>
                                <span>DOKTER PEMERIKSA</span>
                            </div>
                            <div class="section-content">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Nama Dokter Pemeriksa:</label>
                                        <select id="dokter_pemeriksa" name="dokter_pemeriksa" class="form-select select2"
                                            required>
                                            <option value="">--Pilih Dokter Pemeriksa--</option>
                                            @foreach ($dokter as $item)
                                                <option value="{{ $item->kd_dokter }}"
                                                    {{ old('dokter_pemeriksa', $echocardiography->dokter_pemeriksa) == $item->kd_dokter ? 'selected' : '' }}>
                                                    {{ $item->nama_lengkap }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <x-button-submit>Perbarui</x-button-submit>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection
