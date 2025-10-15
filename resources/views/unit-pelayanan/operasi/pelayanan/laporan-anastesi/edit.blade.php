<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')
    @include('unit-pelayanan.operasi.pelayanan.laporan-anastesi.include-script')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Asesmen Catatan Keperawatan Periopetif (Intra dan Pasca Operasi)',
                    'description' =>
                        'Perbarui data Asesmen Catatan Perioperatif dengan mengisi formulir di bawah ini.',
                ])
                <form method="POST"
                    action="{{ route('operasi.pelayanan.laporan-anastesi.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $laporanAnastesi->id]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="section-separator" id="dataMasuk">
                        <h5 class="section-title">1. Data Masuk</h5>
                        <div class="form-group">
                            <label style="min-width: 200px;">Tanggal dan Jam Masuk</label>
                            <input type="date" name="tgl_data_masuk" id="tgl_masuk" class="form-control me-3"
                                value="{{ $waktuLaporan ?? \Carbon\Carbon::now()->format('Y-m-d') }}">
                            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control"
                                value="{{ $jamLaporan ?? \Carbon\Carbon::now()->format('H:i') }}">
                        </div>
                    </div>

                    <div class="section-separator" id="jenisOperasi">
                        <h5 class="section-title">2. Jenis dan Tipe Operasi</h5>

                        <div class="form-group">
                            <label style="min-width: 200px;">Dilakukan Operasi/Jenis Operasi</label>
                            <select name="jenis_operasi" id="jenis_operasi" class="form-select select2 w-100">
                                <option value="">--Pilih--</option>
                                @foreach ($products as $item)
                                    <option value="{{ $item->kd_produk }}" @selected($item->kd_produk == $laporanAnastesi->jenis_operasi)>
                                        {{ $item->deskripsi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="min-width: 200px;">Tipe Operasi</label>
                            <select class="form-select" name="tipe_operasi">
                                <option disabled {{ $laporanAnastesi->tipe_operasi == null ? 'selected' : '' }}>--Pilih--
                                </option>
                                <option value="Elektif" {{ $laporanAnastesi->tipe_operasi == 'Elektif' ? 'selected' : '' }}>
                                    Elektif</option>
                                <option value="Darurat" {{ $laporanAnastesi->tipe_operasi == 'Darurat' ? 'selected' : '' }}>
                                    Darurat</option>
                                <option value="Operasi ODC"
                                    {{ $laporanAnastesi->tipe_operasi == 'Operasi ODC' ? 'selected' : '' }}>
                                    Operasi ODC</option>
                            </select>
                        </div>
                    </div>

                    <div class="section-separator" id="periapanPasien">
                        <h5 class="section-title">3. Persiapan Pasien dan Peralatan</h5>

                        <!-- Time Out (Pengecekan Awal Sebelum Operasi) -->
                        <div class="form-group">
                            <label style="min-width: 200px;">Time Out (Pengecekan Awal Sebelum
                                Operasi)</label>
                            <select class="form-select me-3" name="time_out">
                                <option disabled {{ $laporanAnastesi->time_out == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1" {{ $laporanAnastesi->time_out == '1' ? 'selected' : '' }}>Ya
                                </option>
                                <option value="0" {{ $laporanAnastesi->time_out == '0' ? 'selected' : '' }}>Tidak
                                </option>
                            </select>
                            <input type="time" name="jam_time_out" id="jam_time_out" class="form-control"
                                value="{{ $laporanAnastesi->jam_time_out ? date('H:i', strtotime($laporanAnastesi->jam_time_out)) : '' }}">
                        </div>

                        <!-- Tingkat Kesadaran Pasien Saat Masuk Kamar Operasi -->
                        <div class="form-group">
                            <label style="min-width: 200px;">Tingkat Kesadaran Pasien Saat Masuk Kamar
                                Operasi</label>
                            <select class="form-select" name="tingkat_kesadaran">
                                <option disabled {{ $laporanAnastesi->tingkat_kesadaran == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Terjaga"
                                    {{ $laporanAnastesi->tingkat_kesadaran == 'Terjaga' ? 'selected' : '' }}>
                                    Terjaga</option>
                                <option value="Mudah Dibangunkan"
                                    {{ $laporanAnastesi->tingkat_kesadaran == 'Mudah Dibangunkan' ? 'selected' : '' }}>
                                    Mudah Dibangunkan</option>
                            </select>
                        </div>

                        <!-- Posisi Pasien Selama Operasi -->
                        <div class="form-group">
                            <label style="min-width: 200px;">Posisi Pasien Selama Operasi</label>
                            <select class="form-select" name="posisi_pasien">
                                <option disabled {{ $laporanAnastesi->posisi_pasien == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Telentang"
                                    {{ $laporanAnastesi->posisi_pasien == 'Telentang' ? 'selected' : '' }}>
                                    Telentang</option>
                                <option value="Litothomy"
                                    {{ $laporanAnastesi->posisi_pasien == 'Litothomy' ? 'selected' : '' }}>
                                    Litothomy</option>
                                <option value="Tengkurap"
                                    {{ $laporanAnastesi->posisi_pasien == 'Tengkurap' ? 'selected' : '' }}>
                                    Tengkurap</option>
                                <option value="Lateral"
                                    {{ $laporanAnastesi->posisi_pasien == 'Lateral' ? 'selected' : '' }}>
                                    Lateral</option>
                            </select>
                        </div>

                        <!-- Posisi Lengan -->
                        <div class="form-group">
                            <label style="min-width: 200px;">Posisi Lengan</label>
                            <select class="form-select" name="posisi_lengan">
                                <option disabled {{ $laporanAnastesi->posisi_lengan == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Terentang"
                                    {{ $laporanAnastesi->posisi_lengan == 'Terentang' ? 'selected' : '' }}>
                                    Terentang</option>
                                <option value="Terlipat"
                                    {{ $laporanAnastesi->posisi_lengan == 'Terlipat' ? 'selected' : '' }}>
                                    Terlipat</option>
                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                            </select>
                        </div>

                        <!-- Posisi Kanula Intra Vena -->
                        <div class="form-group">
                            <label style="min-width: 200px;">Posisi Kanula Intra Vena</label>
                            <select class="form-select" name="posisi_kanula">
                                <option disabled {{ $laporanAnastesi->posisi_kanula == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Tangan Kanan"
                                    {{ $laporanAnastesi->posisi_kanula == 'Tangan Kanan' ? 'selected' : '' }}>
                                    Tangan Kanan</option>
                                <option value="Tangan Kiri"
                                    {{ $laporanAnastesi->posisi_kanula == 'Tangan Kiri' ? 'selected' : '' }}>
                                    Tangan Kiri</option>
                                <option value="Arterial Line"
                                    {{ $laporanAnastesi->posisi_kanula == 'Arterial Line' ? 'selected' : '' }}>
                                    Arterial Line</option>
                                <option value="CVP" {{ $laporanAnastesi->posisi_kanula == 'CVP' ? 'selected' : '' }}>CVP
                                </option>
                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                            </select>
                        </div>

                        <!-- Pemasangan Kater Urin -->
                        <div class="form-group">
                            <label style="min-width: 200px;">Pemasangan Kater Urin</label>
                            <select class="form-select" name="pemasangan_kater_urin">
                                <option disabled {{ $laporanAnastesi->pemasangan_kater_urin == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1"
                                    {{ $laporanAnastesi->pemasangan_kater_urin == '1' ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0"
                                    {{ $laporanAnastesi->pemasangan_kater_urin == '0' ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>

                        <!-- Bila Dilakukan Kater Urin -->
                        <div class="form-group">
                            <label style="min-width: 200px;">Bila Dilakukan Kater Urin</label>
                            <select class="form-select" name="bila_kater_urin">
                                <option disabled {{ $laporanAnastesi->bila_kater_urin == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Kamar Operasi"
                                    {{ $laporanAnastesi->dilakukan_kater == 'Kamar Operasi' ? 'selected' : '' }}>
                                    Kamar Operasi</option>
                                <option value="Ruangan"
                                    {{ $laporanAnastesi->dilakukan_kater == 'Ruangan' ? 'selected' : '' }}>
                                    Ruangan</option>
                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                            </select>
                        </div>

                        <!-- Persiapan Kulit -->
                        <div class="form-group">
                            <label style="min-width: 200px;">Persiapan Kulit</label>
                            <select class="form-select" name="persiapan_kulit">
                                <option disabled {{ $laporanAnastesi->persiapan_kulit == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Chlorhexidine/70%"
                                    {{ $laporanAnastesi->persiapan_kulit == 'Chlorhexidine/70%' ? 'selected' : '' }}>
                                    Chlorhexidine/70%</option>
                                <option value="Povidone-loclinHibiscrub"
                                    {{ $laporanAnastesi->persiapan_kulit == 'Povidone-loclinHibiscrub' ? 'selected' : '' }}>
                                    Povidone-loclinHibiscrub</option>
                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                            </select>
                        </div>
                    </div>

                    <div class="section-separator" id="penggunaanAlat">
                        <h5 class="section-title">4. Penggunaan Alat dan Teknologi Medis</h5>

                        <!-- Penggunaan Alat -->
                        <div class="form-group">
                            <label style="form-label">Cek Ketersidaan Alat</label>
                        </div>
                        <div class="form-group">
                            <label style="min-width: 300px;">Instrumen</label>
                            <select class="form-select me-3" name="instrumen">
                                <option disabled {{ $laporanAnastesiDtl->instrument == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1" {{ $laporanAnastesiDtl->instrument == '1' ? 'selected' : '' }}>Ya
                                </option>
                                <option value="0" {{ $laporanAnastesiDtl->instrument == '0' ? 'selected' : '' }}>
                                    Tidak
                                </option>
                            </select>
                            <input type="time" name="jam_instrumen" class="form-control"
                                value="{{ $laporanAnastesiDtl->instrument_time ? date('H:i', strtotime($laporanAnastesiDtl->instrument_time)) : '' }}">
                        </div>
                        <div class="form-group">
                            <label style="min-width: 300px;">Prothese/Lmplant</label>
                            <select class="form-select me-3" name="prothese">
                                <option disabled {{ $laporanAnastesiDtl->prothese == null ? 'selected' : '' }}>--Pilih--
                                </option>
                                <option value="1" {{ $laporanAnastesiDtl->prothese == '1' ? 'selected' : '' }}>Ya
                                </option>
                                <option value="0" {{ $laporanAnastesiDtl->prothese == '0' ? 'selected' : '' }}>Tidak
                                </option>
                            </select>
                            <input type="time" name="jam_prothese" class="form-control"
                                value="{{ $laporanAnastesiDtl->prothese_time ? date('H:i', strtotime($laporanAnastesiDtl->prothese_time)) : '' }}">
                        </div>

                        <!-- Pemasangan Diathermy (Elektrokauter) -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Pemasangan Diathermy (Elektrokauter)</label>
                            <select class="form-select" name="diathermy">
                                <option disabled {{ $laporanAnastesiDtl->pemakaian_diathermy == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1"
                                    {{ $laporanAnastesiDtl->pemakaian_diathermy == '1' ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0"
                                    {{ $laporanAnastesiDtl->pemakaian_diathermy == '0' ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>

                        <!-- Lokasi Diathermy (Elektrokauter) -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Lokasi Diathermy (Elektrokauter)</label>
                            <select class="form-select" name="lokasi_diathermy">
                                <option disabled {{ $laporanAnastesiDtl->lokasi_diathermy == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Paha"
                                    {{ $laporanAnastesiDtl->lokasi_diathermy == 'Paha' ? 'selected' : '' }}>
                                    Paha</option>
                                <option value="Lengan"
                                    {{ $laporanAnastesiDtl->lokasi_diathermy == 'Lengan' ? 'selected' : '' }}>
                                    Lengan</option>
                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                            </select>
                        </div>

                        <!-- Bila Ada, Kode Unit Elektrosurgical -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Bila Ada, Kode Unit Elektrosurgical</label>
                            <input type="text" class="form-control" name="kode_unit_elektrosurgical"
                                value="{{ $laporanAnastesiDtl->kode_elektrosurgical }}">
                        </div>

                        <!-- Unit Pemasangan / Pendingin Operasi -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Unit Pemasangan / Pendingin Operasi</label>
                            <select class="form-select" name="unit_pemasangan">
                                <option disabled {{ $laporanAnastesiDtl->unit_pemasangan == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1"
                                    {{ $laporanAnastesiDtl->unit_pemasangan == '1' ? 'selected' : '' }}>Ya
                                </option>
                                <option value="0"
                                    {{ $laporanAnastesiDtl->unit_pemasangan == '0' ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>

                        <!-- Bila Ya, Pengaturan Temperatur Mulai -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Bila Ya, Pengaturan Temperatur Mulai</label>
                            <input type="text" class="form-control" name="pengaturan_temperatur_mulai"
                                placeholder="Suhu" value="{{ $laporanAnastesiDtl->temperatur_mulai }}">
                        </div>

                        <div class="form-group">
                            <label style="min-width: 300px;">Kode Unit</label>
                            <input type="text" class="form-control" name="kode_unit" placeholder="kode"
                                value="{{ $laporanAnastesiDtl->kode_unit }}">
                        </div>

                        <!-- Pengaturan Temperatur Selesai -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Pengaturan Temperatur Selesai</label>
                            <input type="text" class="form-control" name="pengaturan_temperatur_selesai"
                                placeholder="Suhu" value="{{ $laporanAnastesiDtl->temperatur_selesai }}">
                        </div>

                        <!-- Jam Mulai S/D Selesai -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Jam Mulai S/D Selesai</label>
                            <input type="time" name="jam_temperatur_mulai" class="form-control me-3"
                                value="{{ $laporanAnastesiDtl->jam_temperatur_mulai ? date('H:i', strtotime($laporanAnastesiDtl->jam_temperatur_mulai)) : '' }}">
                            <input type="time" name="jam_temperatur_selesai" class="form-control"
                                value="{{ $laporanAnastesiDtl->jam_temperatur_selesai ? date('H:i', strtotime($laporanAnastesiDtl->jam_temperatur_selesai)) : '' }}">
                        </div>

                        <div class="form-group">
                            <label style="min-width: 300px;">Pemakaian Tomiquet</label>
                            <select class="form-select" name="pemakaian_tomiquet">
                                <option disabled {{ $laporanAnastesiDtl->pemakaian_tomiquet == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1"
                                    {{ $laporanAnastesiDtl->pemakaian_tomiquet == '1' ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0"
                                    {{ $laporanAnastesiDtl->pemakaian_tomiquet == '0' ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 300px;">Pengawas Tomiquet</label>
                            <input type="text" class="form-control" name="pengawas_tomiquet"
                                value="{{ $laporanAnastesiDtl->pengawas_tomiquet }}">
                        </div>

                        <!-- Lokasi Pemasangan Tomiquet -->
                        <div class="form-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Lokasi Pemasangan Tomiquet</th>
                                        <th scope="col">Waktu Mulai</th>
                                        <th scope="col">Waktu Selesai</th>
                                        <th scope="col">Tekanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">Lengan Kanan</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="jam_lengan_kanan_mulai" class="form-control"
                                                value="{{ $laporanAnastesiDtl->lengan_kanan_mulai ? date('H:i', strtotime($laporanAnastesiDtl->lengan_kanan_mulai)) : '' }}">
                                        </td>
                                        <td>
                                            <input type="time" name="jam_lengan_kanan_selesai" class="form-control"
                                                value="{{ $laporanAnastesiDtl->lengan_kanan_selesai ? date('H:i', strtotime($laporanAnastesiDtl->lengan_kanan_selesai)) : '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="tekanan_lengan_kanan" class="form-control"
                                                placeholder="mmHg"
                                                value="{{ $laporanAnastesiDtl->lengan_kanan_tekanan }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">Kaki Kanan</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="jam_kaki_kanan_mulai" class="form-control"
                                                value="{{ $laporanAnastesiDtl->kaki_kanan_mulai ? date('H:i', strtotime($laporanAnastesiDtl->kaki_kanan_mulai)) : '' }}">
                                        </td>
                                        <td>
                                            <input type="time" name="jam_kaki_kanan_selesai" class="form-control"
                                                value="{{ $laporanAnastesiDtl->kaki_kanan_selesai ? date('H:i', strtotime($laporanAnastesiDtl->kaki_kanan_selesai)) : '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="tekanan_kaki_kanan" class="form-control"
                                                placeholder="mmHg" value="{{ $laporanAnastesiDtl->kaki_kanan_tekanan }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">Lengan Kiri</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="jam_lengan_kiri_mulai" class="form-control"
                                                value="{{ $laporanAnastesiDtl->lengan_kiri_mulai ? date('H:i', strtotime($laporanAnastesiDtl->lengan_kiri_mulai)) : '' }}">
                                        </td>
                                        <td>
                                            <input type="time" name="jam_lengan_kiri_selesai" class="form-control"
                                                value="{{ $laporanAnastesiDtl->lengan_kiri_selesai ? date('H:i', strtotime($laporanAnastesiDtl->lengan_kiri_selesai)) : '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="tekanan_lengan_kiri" class="form-control"
                                                placeholder="mmHg"
                                                value="{{ $laporanAnastesiDtl->lengan_kiri_tekanan }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">Kaki Kiri</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="jam_kaki_kiri_mulai" class="form-control"
                                                value="{{ $laporanAnastesiDtl->kaki_kiri_mulai ? date('H:i', strtotime($laporanAnastesiDtl->kaki_kiri_mulai)) : '' }}">
                                        </td>
                                        <td>
                                            <input type="time" name="jam_kaki_kiri_selesai" class="form-control"
                                                value="{{ $laporanAnastesiDtl->kaki_kiri_selesai ? date('H:i', strtotime($laporanAnastesiDtl->kaki_kiri_selesai)) : '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="tekanan_kaki_kiri" class="form-control"
                                                placeholder="mmHg" value="{{ $laporanAnastesiDtl->kaki_kiri_tekanan }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pemakaian Laser -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Pemakaian Laser</label>
                            <select class="form-select" name="pemakaian_laser">
                                <option disabled {{ $laporanAnastesiDtl->pemakaian_laser == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1"
                                    {{ $laporanAnastesiDtl->pemakaian_laser == '1' ? 'selected' : '' }}>Ya
                                </option>
                                <option value="0"
                                    {{ $laporanAnastesiDtl->pemakaian_laser == '0' ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>

                        <!-- Kode Model -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Kode Model</label>
                            <input type="text" class="form-control" name="kode_model"
                                value="{{ $laporanAnastesiDtl->kode_model }}">
                        </div>

                        <div class="form-group">
                            <label style="min-width: 300px;">Pengawas Laser</label>
                            <input type="text" class="form-control" name="pengawas_laser"
                                value="{{ $laporanAnastesiDtl->pengawas_laser }}">
                        </div>

                        <div class="form-group">
                            <label style="min-width: 300px;">Pemaikan Implant</label>
                            <select class="form-select" name="pemakaian_implant">
                                <option selected disabled
                                    {{ $laporanAnastesiDtl->pemakaian_implant == null ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1"
                                    {{ $laporanAnastesiDtl->pemakaian_implant == '1' ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0"
                                    {{ $laporanAnastesiDtl->pemakaian_implant == '0' ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 300px;"></label>
                            <div class="d-flex gap-3" style="width: 100%;">

                                <div class="flex-grow-1">
                                    <label class="form-label">Pabrik</label>
                                    <input type="text" class="form-control" name="pabrik" placeholder="pabrik"
                                        value="{{ $laporanAnastesiDtl->pabrik }}">
                                </div>

                                <div class="flex-grow-1">
                                    <label class="form-label">Size</label>
                                    <input type="text" class="form-control" name="size" placeholder="Size"
                                        value="{{ $laporanAnastesiDtl->size }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 300px;"></label>
                            <div class="d-flex gap-3" style="width: 100%;">

                                <div class="flex-grow-1">
                                    <label class="form-label">Type</label>
                                    <input type="text" class="form-control" name="tipe" placeholder="pabrik"
                                        value="{{ $laporanAnastesiDtl->tipe }}">
                                </div>

                                <div class="flex-grow-1">
                                    <label class="form-label">No Seri</label>
                                    <input type="text" class="form-control" name="no_seri" placeholder="No. Seri"
                                        value="{{ $laporanAnastesiDtl->no_seri }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="section-separator" id="penghitunganAlat">
                        <h5 class="section-title">5. Penghitungan Alat dan Bahan Operasi</h5>
                        <div class="form-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Hitung</th>
                                        <th scope="col">Kasa</th>
                                        <th scope="col">Jarum</th>
                                        <th scope="col">Instrumen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check"><label class="form-check-label">Hitung
                                                    1</label></div>
                                        </td>
                                        <td><input type="text" name="kassa1" class="form-control"
                                                placeholder="jumlah"
                                                value="{{ $laporanAnastesiDtl2->kassa_satu ?? '' }}"></td>
                                        <td><input type="text" name="jarum1" class="form-control"
                                                placeholder="jumlah"
                                                value="{{ $laporanAnastesiDtl2->jarum_satu ?? '' }}"></td>
                                        <td><input type="text" name="instrumen1" class="form-control"
                                                placeholder="jumlah"
                                                value="{{ $laporanAnastesiDtl2->instrumen_satu ?? '' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check"><label class="form-check-label">Hitung
                                                    2</label></div>
                                        </td>
                                        <td><input type="text" name="kassa2" class="form-control"
                                                placeholder="jumlah" value="{{ $laporanAnastesiDtl2->kassa_dua ?? '' }}">
                                        </td>
                                        <td><input type="text" name="jarum2" class="form-control"
                                                placeholder="jumlah" value="{{ $laporanAnastesiDtl2->jarum_dua ?? '' }}">
                                        </td>
                                        <td><input type="text" name="instrumen2" class="form-control"
                                                placeholder="jumlah"
                                                value="{{ $laporanAnastesiDtl2->instrumen_dua ?? '' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check"><label class="form-check-label">Hitung
                                                    3</label></div>
                                        </td>
                                        <td><input type="text" name="kassa3" class="form-control"
                                                placeholder="jumlah"
                                                value="{{ $laporanAnastesiDtl2->kassa_tiga ?? '' }}"></td>
                                        <td><input type="text" name="jarum3" class="form-control"
                                                placeholder="jumlah"
                                                value="{{ $laporanAnastesiDtl2->jarum_tiga ?? '' }}"></td>
                                        <td><input type="text" name="instrumen3" class="form-control"
                                                placeholder="jumlah"
                                                value="{{ $laporanAnastesiDtl2->instrumen_tiga ?? '' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <input class="form-check-input" type="checkbox"
                                                    name="kassa_tidak_lengkap" id="kassa_tidak_lengkap"
                                                    value="Tidak Lengkap"
                                                    {{ $laporanAnastesiDtl2 && ($laporanAnastesiDtl2->kassa_satu || $laporanAnastesiDtl2->kassa_dua || $laporanAnastesiDtl2->kassa_tiga) ? '' : 'checked' }}>
                                                <label class="form-check-label" for="kassa_tidak_lengkap">Tidak
                                                    Lengkap</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <input class="form-check-input" type="checkbox"
                                                    name="jarum_tidak_lengkap" id="jarum_tidak_lengkap"
                                                    value="Tidak Lengkap"
                                                    {{ $laporanAnastesiDtl2 && ($laporanAnastesiDtl2->jarum_satu || $laporanAnastesiDtl2->jarum_dua || $laporanAnastesiDtl2->jarum_tiga) ? '' : 'checked' }}>
                                                <label class="form-check-label" for="jarum_tidak_lengkap">Tidak
                                                    Lengkap</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <input class="form-check-input" type="checkbox"
                                                    name="instrumen_tidak_lengkap" id="instrumen_tidak_lengkap"
                                                    value="Tidak Lengkap"
                                                    {{ $laporanAnastesiDtl2 && ($laporanAnastesiDtl2->instrumen_satu || $laporanAnastesiDtl2->instrumen_dua || $laporanAnastesiDtl2->instrumen_tiga) ? '' : 'checked' }}>
                                                <label class="form-check-label" for="instrumen_tidak_lengkap">Tidak
                                                    Lengkap</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <input class="form-check-input" type="checkbox" name="kassa_tidak_perlu"
                                                    id="kassa_tidak_perlu" value="Tidak perlu"
                                                    {{ $laporanAnastesiDtl2 && !$laporanAnastesiDtl2->kassa_satu && !$laporanAnastesiDtl2->kassa_dua && !$laporanAnastesiDtl2->kassa_tiga ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kassa_tidak_perlu">Tidak
                                                    Perlu</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <input class="form-check-input" type="checkbox" name="jarum_tidak_perlu"
                                                    id="jarum_tidak_perlu" value="Tidak perlu"
                                                    {{ $laporanAnastesiDtl2 && !$laporanAnastesiDtl2->jarum_satu && !$laporanAnastesiDtl2->jarum_dua && !$laporanAnastesiDtl2->jarum_tiga ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jarum_tidak_perlu">Tidak
                                                    Perlu</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 align-items-center">
                                                <input class="form-check-input" type="checkbox"
                                                    name="instrumen_tidak_perlu" id="instrumen_tidak_perlu"
                                                    value="Tidak perlu"
                                                    {{ $laporanAnastesiDtl2 && !$laporanAnastesiDtl2->instrumen_satu && !$laporanAnastesiDtl2->instrumen_dua && !$laporanAnastesiDtl2->instrumen_tiga ? 'checked' : '' }}>
                                                <label class="form-check-label" for="instrumen_tidak_perlu">Tidak
                                                    Perlu</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h6>Catatan :</h6>
                        <p class="text-small">Jika dihitung tidak lengkap, setelah dicari tidak ditemukan.
                            Dilakukan nya X-Ray</p>

                        <div class="form-group">
                            <label style="min-width: 200px;">Dilakukan X-Ray</label>
                            <select class="form-select" name="dilakukan_xray">
                                <option value=""
                                    {{ !$laporanAnastesiDtl2 || is_null($laporanAnastesiDtl2->dilakukan_xray) ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->dilakukan_xray == 1 ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->dilakukan_xray == 0 ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="min-width: 200px;">Penggunaan Tampon</label>
                            <select class="form-select" name="penggunaan_tampon">
                                <option value=""
                                    {{ !$laporanAnastesiDtl2 || is_null($laporanAnastesiDtl2->penggunaan_tampon) ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="1"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->penggunaan_tampon == 1 ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->penggunaan_tampon == 0 ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="min-width: 200px;">Bila Ya, Jenis Tampon</label>
                            <input type="text" class="form-control" name="jenis_tampon"
                                value="{{ $laporanAnastesiDtl2->jenis_tampon ?? '' }}">
                        </div>
                    </div>

                    <div class="section-separator" id="penggunaanCairan">
                        <h5 class="section-title">6. Penggunaan Cairan dan Drain</h5>
                        <div class="form-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Tipe Drain</th>
                                        <th scope="col">Jenis Drain</th>
                                        <th scope="col">Ukuran</th>
                                        <th scope="col">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" name="tipe_drain" class="form-control"
                                                placeholder="Tipe Drain"
                                                value="{{ $drainData[0]['tipe_drain'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="jenis_drain" class="form-control"
                                                placeholder="Jenis Drain"
                                                value="{{ $drainData[0]['jenis_drain'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="ukuran_drain" class="form-control"
                                                placeholder="Ukuran Drain" value="{{ $drainData[0]['ukuran'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan_drain" class="form-control"
                                                placeholder="Keterangan Drain"
                                                value="{{ $drainData[0]['keterangan'] ?? '' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="tipe_drain2" class="form-control"
                                                placeholder="Tipe Drain"
                                                value="{{ $drainData[1]['tipe_drain'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="jenis_drain2" class="form-control"
                                                placeholder="Jenis Drain"
                                                value="{{ $drainData[1]['jenis_drain'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="ukuran_drain2" class="form-control"
                                                placeholder="Ukuran Drain" value="{{ $drainData[1]['ukuran'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan_drain2" class="form-control"
                                                placeholder="Keterangan Drain"
                                                value="{{ $drainData[1]['keterangan'] ?? '' }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" name="tipe_drain3" class="form-control"
                                                placeholder="Tipe Drain"
                                                value="{{ $drainData[2]['tipe_drain'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="jenis_drain3" class="form-control"
                                                placeholder="Jenis Drain"
                                                value="{{ $drainData[2]['jenis_drain'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="ukuran_drain3" class="form-control"
                                                placeholder="Ukuran Drain" value="{{ $drainData[2]['ukuran'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="keterangan_drain3" class="form-control"
                                                placeholder="Keterangan Drain"
                                                value="{{ $drainData[2]['keterangan'] ?? '' }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 200px;">Irigasi Luka</label>
                            <select class="form-select" name="irigasi_luka">
                                <option value=""
                                    {{ !$laporanAnastesiDtl2 || !$laporanAnastesiDtl2->irigasi_luka ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Sodium Chloride 0,9%"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->irigasi_luka == 'Sodium Chloride 0,9%' ? 'selected' : '' }}>
                                    Sodium Chloride 0,9%</option>
                                <option value="AntiWolik Spray"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->irigasi_luka == 'AntiWolik Spray' ? 'selected' : '' }}>
                                    AntiWolik Spray</option>
                                <option value="Anbilotik"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->irigasi_luka == 'Anbilotik' ? 'selected' : '' }}>
                                    Anbilotik</option>
                                <option value="H2O2"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->irigasi_luka == 'H2O2' ? 'selected' : '' }}>
                                    H2O2</option>
                            </select>
                        </div>

                        <!-- Edit Form - Pemakaian Cairan -->
                        <div class="form-group">
                            <label class="col-md-3 col-form-label" style="min-width: 200px;">Pemakaian
                                Cairan</label>
                            <div class="w-100 d-flex flex-column">
                                <!-- Input Row -->
                                <div class="input-group mb-2">
                                    <select class="form-select" id="cairan-select" style="flex: 2;">
                                        <option value="">--Pilih Jenis Cairan--</option>
                                        <option value="Sodium Chloride 0,9%">Sodium Chloride 0,9%</option>
                                        <option value="Glyrin">Glyrin</option>
                                        <option value="BSS Solution">BSS Solution</option>
                                        <option value="Air Untuk Irigasi">Air Untuk Irigasi</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <input type="number" class="form-control" id="cairan-jumlah" placeholder="Liter"
                                        style="flex: 1;">
                                    <input type="text" class="form-control d-none" id="cairan-lainnya"
                                        placeholder="Sebutkan jenis cairan" style="flex: 1;">
                                    <span class="input-group-text bg-white" id="btn-add-cairan" style="cursor: pointer;">
                                        <i class="bi bi-plus-circle text-primary"></i>
                                    </span>
                                </div>

                                <!-- List Pemakaian Cairan -->
                                <div id="list-pemakaian-cairan" class="w-100">
                                    <p class="text-danger text-small" id="empty-cairan">Belum ada
                                        pemakaian cairan ditambahkan</p>
                                </div>

                                <!-- Hidden input untuk dikirim ke backend -->
                                <input type="hidden" name="pemakaian_cairan" id="hidden-pemakaian-cairan"
                                    value="{{ $laporanAnastesiDtl2->pemakaian_cairan ?? '[]' }}">
                            </div>
                        </div>
                    </div>

                    <div class="section-separator">
                        <h5 class="section-title">7. Waktu dan Tim Medis</h5>

                        <div class="form-group">
                            <label style="min-width: 200px;">Waktu Mulai Operasi</label>
                            <div class="d-flex gap-3 align-items-center">
                                <input type="date" class="form-control me-3" name="waktu_mulai_operasi"
                                    value="{{ $waktuMulaiOperasi ?? '' }}">
                                <input type="time" class="form-control" name="jam_mulai_operasi"
                                    value="{{ $jamMulaiOperasi ? date('H:i', strtotime($jamMulaiOperasi)) : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 200px;">Waktu Selesai Operasi</label>
                            <div class="d-flex gap-3 align-items-center">
                                <input type="date" class="form-control me-3" name="waktu_selesai_operasi"
                                    value="{{ $waktuSelesaiOperasi ?? '' }}">
                                <input type="time" class="form-control" name="jam_selesai_operasi"
                                    value="{{ $jamSelesaiOperasi ? date('H:i', strtotime($jamSelesaiOperasi)) : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 200px;">Dokter Bedah</label>
                            <select class="form-select select2" name="dokter_bedah">
                                <option value="" {{ !$laporanAnastesi->dokter_bedah ? 'selected' : '' }}>--Pilih--
                                </option>
                                @foreach ($dokter as $d)
                                    <option value="{{ $d->kd_dokter }}"
                                        {{ $laporanAnastesi->dokter_bedah == $d->kd_dokter ? 'selected' : '' }}>
                                        {{ $d->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 200px;">Dokter Anastesi</label>
                            <select class="form-select" name="dokter_anastesi">
                                <option value="" {{ !$laporanAnastesi->dokter_anastesi ? 'selected' : '' }}>
                                    --Pilih--
                                </option>
                                @foreach ($dokterAnastesi as $da)
                                    <option value="{{ $da->kd_dokter }}"
                                        {{ $laporanAnastesi->dokter_anastesi == $da->kd_dokter ? 'selected' : '' }}>
                                        {{ $da->dokter->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 200px;">Penatara Anastesi</label>
                            <select class="form-select select2" name="penatara_anastesi">
                                <option value="" {{ !$laporanAnastesi->penatara_anastesi ? 'selected' : '' }}>
                                    --Pilih--
                                </option>
                                @foreach ($perawat as $p)
                                    <option value="{{ $p->kd_perawat }}"
                                        {{ $laporanAnastesi->penatara_anastesi == $p->kd_perawat ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="min-width: 200px;">Perawat Bedah</label>
                            <select class="form-select select2" name="perawat_instrumen">
                                <option value="" {{ !$laporanAnastesi->perawat_instrumen ? 'selected' : '' }}>
                                    --Pilih--
                                </option>
                                @foreach ($perawat as $p)
                                    <option value="{{ $p->kd_perawat }}"
                                        {{ $laporanAnastesi->perawat_instrumen == $p->kd_perawat ? 'selected' : '' }}>
                                        {{ $p->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="section-separator">
                        <h5 class="section-title">8. Evaluasi Pasca Operasi</h5>
                        <div class="form-group">
                            <label style="min-width: 300px;">Pemeriksaan Kondisi Kulit Pra Operasi</label>
                            <select class="form-select" name="pemeriksaan_kondisi_kulit_pra_operasi">
                                <option value=""
                                    {{ !$laporanAnastesiDtl2 || !$laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pra_operasi ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Utuh"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pra_operasi == 'Utuh' ? 'selected' : '' }}>
                                    Utuh</option>
                                <option value="Menggelembung"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pra_operasi == 'Menggelembung' ? 'selected' : '' }}>
                                    Menggelembung</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="min-width: 300px;">Pemeriksaan Kondisi Kulit Pasca
                                Operasi</label>
                            <select class="form-select" name="pemeriksaan_kondisi_kulit_pasca_operasi">
                                <option value=""
                                    {{ !$laporanAnastesiDtl2 || !$laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pasca_operasi ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Utuh"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pasca_operasi == 'Utuh' ? 'selected' : '' }}>
                                    Utuh</option>
                                <option value="Menggelembung"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pasca_operasi == 'Menggelembung' ? 'selected' : '' }}>
                                    Menggelembung</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label style="min-width: 300px;">Balutan Luka</label>
                            <select class="form-select" name="balutan_luka">
                                <option value=""
                                    {{ !$laporanAnastesiDtl2 || !$laporanAnastesiDtl2->balutan_luka ? 'selected' : '' }}>
                                    --Pilih--</option>
                                <option value="Tidak Ada"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->balutan_luka == 'Tidak Ada' ? 'selected' : '' }}>
                                    Tidak Ada</option>
                                <option value="Pressure"
                                    {{ $laporanAnastesiDtl2 && $laporanAnastesiDtl2->balutan_luka == 'Pressure' ? 'selected' : '' }}>
                                    Pressure</option>
                            </select>
                        </div>
                        <!-- Form Spesimen (EDIT) -->
                        <div class="form-group">
                            <label style="min-width: 300px;">Spesimen</label>
                            <div class="w-100 d-flex flex-column">
                                <!-- Input Row -->
                                <div class="input-group mb-2">
                                    <select class="form-select" id="spesimen-select" style="flex: 1;">
                                        <option value="">--Pilih Kategori--</option>
                                        <option value="Histologi">Histologi</option>
                                        <option value="Kultur">Kultur</option>
                                        <option value="Frozen Section">Frozen Section</option>
                                        <option value="Sitologi">Sitologi</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>

                                    <!-- Checkbox (muncul kalau pilih Sitologi atau Lainnya) -->
                                    <div class="input-group-text bg-white" id="spesimen-checkbox-wrapper"
                                        style="display: none;">
                                        <input class="form-check-input mt-0" type="checkbox" id="spesimen-checkbox">
                                    </div>

                                    <input type="text" class="form-control" id="spesimen-jenis"
                                        placeholder="Jenis spesimen" style="flex: 2;">
                                    <span class="input-group-text bg-white" id="btn-add-spesimen"
                                        style="cursor: pointer;">
                                        <i class="bi bi-plus-circle text-primary"></i>
                                    </span>
                                </div>

                                <!-- List Spesimen -->
                                <div id="list-spesimen" class="w-100">
                                    <p class="text-danger text-small" id="empty-spesimen">Belum ada
                                        spesimen ditambahkan</p>
                                </div>

                                <!-- Hidden input - LOAD DATA EXISTING -->
                                <input type="hidden" name="spesimen" id="hidden-spesimen"
                                    value="{{ $laporanAnastesiDtl2->spesimen ?? '[]' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="min-width: 300px;">Jenis</label>
                            <input type="text" class="form-control" name="jenis_spesimen"
                                value="{{ $laporanAnastesiDtl2->jenis_spesimen ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label style="min-width: 300px;">Jumlah Total Jaringan/Cairan
                                Pemeriksaan</label>
                            <input type="text" class="form-control" name="total_jaringan_cairan_pemeriksaan"
                                value="{{ $laporanAnastesiDtl2->total_jaringan_cairan_pemeriksaan ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label style="min-width: 300px;">Jenis dari Jaringan</label>
                            <input type="text" class="form-control" name="jenis_jaringan"
                                value="{{ $laporanAnastesiDtl2->jenis_jaringan ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label style="min-width: 300px;">Jumlah dari Jaringan</label>
                            <input type="text" class="form-control" name="jumlah_jaringan"
                                value="{{ $laporanAnastesiDtl2->jumlah_jaringan ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label style="min-width: 300px;">Keterangan</label>
                            <textarea class="form-control" rows="3" name="keterangan">{{ $laporanAnastesiDtl2->keterangan ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="section-separator" id="dokumentasiVerifikasi">
                        <h5 class="section-title"
                            style="color: #2c3e50; font-weight: 600; padding-bottom: 5px; margin-bottom: 20px;">
                            9. Dokumentasi dan Verifikasi
                        </h5>
                        <div class="card shadow-sm" style="border: none; border-radius: 15px; background: #f8f9fa;">
                            <div class="card-body p-4">
                                <!-- E-Signature Perawat Instrumen -->
                                <div class="row mb-4 align-items-center">
                                    <div class="col-md-4">
                                        <label class="fw-bold mb-2" style="color: #34495e;">
                                            <i class="ti-user me-2" style="color: #3498db;"></i>
                                            E-Signature Perawat Instrumen
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select select2" name="perawat_instrumen"
                                            id="perawat_instrumen" style="border-radius: 10px;">
                                            <option value=""
                                                {{ !$laporanAnastesi->perawat_instrumen ? 'selected' : '' }}>
                                                --Pilih Perawat--</option>
                                            @foreach ($perawat as $p)
                                                <option value="{{ $p->kd_perawat }}" data-nama="{{ $p->nama }}"
                                                    {{ $laporanAnastesi->perawat_instrumen == $p->kd_perawat ? 'selected' : '' }}>
                                                    {{ $p->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div id="qrcode_perawat_instrumen" class="d-inline-block mb-2">
                                        </div>
                                        <p class="fw-medium" style="color: #7f8c8d;">
                                            <span id="nama_perawat_instrumen" class="d-block mb-1">
                                                {{ $laporanAnastesi->perawat_instrumen ? $perawat->firstWhere('kd_perawat', $laporanAnastesi->perawat_instrumen)->nama ?? '' : '' }}
                                            </span>
                                            Ns. <span id="kode_perawat_instrumen"
                                                class="badge bg-light text-dark px-3 py-1" style="border-radius: 20px;">
                                                {{ $laporanAnastesi->perawat_instrumen ?? '.........................' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <!-- E-Signature Perawat Sirkuler -->
                                <div class="row mb-4 align-items-center">
                                    <div class="col-md-4">
                                        <label class="fw-bold mb-2" style="color: #34495e;">
                                            <i class="ti-user me-2" style="color: #3498db;"></i>
                                            E-Signature Perawat Sirkuler
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select select2" name="perawat_sirkuler" id="perawat_sirkuler"
                                            style="border-radius: 10px;">
                                            <option value=""
                                                {{ !$laporanAnastesi->perawat_sirkuler ? 'selected' : '' }}>
                                                --Pilih Perawat--</option>
                                            @foreach ($perawat as $p)
                                                <option value="{{ $p->kd_perawat }}" data-nama="{{ $p->nama }}"
                                                    {{ $laporanAnastesi->perawat_sirkuler == $p->kd_perawat ? 'selected' : '' }}>
                                                    {{ $p->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div id="qrcode_perawat_sirkuler" class="d-inline-block mb-2">
                                        </div>
                                        <p class="fw-medium" style="color: #7f8c8d;">
                                            <span id="nama_perawat_sirkuler" class="d-block mb-1">
                                                {{ $laporanAnastesi->perawat_sirkuler ? $perawat->firstWhere('kd_perawat', $laporanAnastesi->perawat_sirkuler)->nama ?? '' : '' }}
                                            </span>
                                            Ns. <span id="kode_perawat_sirkuler"
                                                class="badge bg-light text-dark px-3 py-1" style="border-radius: 20px;">
                                                {{ $laporanAnastesi->perawat_sirkuler ?? '.........................' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Tanggal dan Jam Pencatatan -->
                                <div class="row mb-4 align-items-center">
                                    <div class="col-md-4">
                                        <label class="fw-bold mb-2" style="color: #34495e;">
                                            <i class="ti-calendar me-2" style="color: #3498db;"></i>
                                            Tanggal dan Jam Pencatatan
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="d-flex gap-3">
                                            <input type="date" class="form-control" name="tanggal_pencatatan"
                                                style="border-radius: 10px; max-width: 200px;"
                                                value="{{ $tanggalPencatatan ?? '' }}">
                                            <input type="time" class="form-control" name="jam_pencatatan"
                                                style="border-radius: 10px; max-width: 150px;"
                                                value="{{ $jamPencatatan ? date('H:i', strtotime($jamPencatatan)) : '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <x-button-submit id="simpan">Perbarui</x-button-submit>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
    <script>
        $(document).ready(function() {
            // Pasang event listener untuk Perawat Instrumen
            $('#perawat_instrumen').on('select2:select', function(e) {
                var kodePerawat = $(this).val();
                var namaPerawat = $(this).find('option:selected').data(
                    'nama'); // Ambil nama perawat dari data-nama
                console.log("Kode perawat instrumen yang dipilih:", kodePerawat);
                console.log("Nama perawat instrumen yang dipilih:", namaPerawat);

                // Update nama perawat dan kode perawat
                $('#nama_perawat_instrumen').text(namaPerawat || '');
                $('#kode_perawat_instrumen').text(kodePerawat || '.........................');
                generateQRCode('qrcode_perawat_instrumen', kodePerawat);
            });

            // Pasang event listener untuk Perawat Sirkuler
            $('#perawat_sirkuler').on('select2:select', function(e) {
                var kodePerawat = $(this).val();
                var namaPerawat = $(this).find('option:selected').data(
                    'nama'); // Ambil nama perawat dari data-nama
                console.log("Kode perawat sirkuler yang dipilih:", kodePerawat);
                console.log("Nama perawat sirkuler yang dipilih:", namaPerawat);

                // Update nama perawat dan kode perawat
                $('#nama_perawat_sirkuler').text(namaPerawat || '');
                $('#kode_perawat_sirkuler').text(kodePerawat || '.........................');
                generateQRCode('qrcode_perawat_sirkuler', kodePerawat);
            });

            // Fungsi untuk membuat QR code
            function generateQRCode(elementId, text) {
                // Hapus QR code sebelumnya jika ada
                $('#' + elementId).empty();

                if (!text) return; // Hindari error jika text kosong

                try {
                    // Buat QR code baru
                    var qr = qrcode(0, 'M');
                    qr.addData(text);
                    qr.make();

                    // Tampilkan QR code
                    $('#' + elementId).html(qr.createImgTag(5));
                } catch (err) {
                    console.error("Error generating QR code:", err);
                }
            }
        });
    </script>
@endpush
