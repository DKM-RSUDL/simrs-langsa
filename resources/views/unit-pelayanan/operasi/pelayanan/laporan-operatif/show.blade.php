<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.laporan-operatif.patient-card')
        </div>

        <div class="col-md-9">

            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Rincian Laporan Operasi',
                    'description' => 'Rincian data laporan operasi pasien rawat inap.',
                ])

                <div class="section-separator mt-0" id="jenisAnestesi">
                    <h5 class="section-title">1. Informasi Operasi</h5>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="nama_tindakan_operasi" style="min-width: 200px;">Nama
                            Tindakan Operasi</label>
                        <input placeholder="Nama Tindakan Operasi" type="text" class="form-control"
                            name="nama_tindakan_operasi" id="nama_tindakan_operasi"
                            value="{{ $laporan->nama_tindakan_operasi }}" disabled>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="kd_jenis_anastesi" style="min-width: 200px;">Jenis
                            Anestesi Yang Digunakan</label>
                        <select name="kd_jenis_anastesi" id="kd_jenis_anastesi" class="form-select" disabled>
                            <option value="">--Pilih--</option>
                            @foreach ($jenisAnastesi as $item)
                                <option value="{{ $item->kd_jenis_anastesi }}" @selected($item->kd_jenis_anastesi == $laporan->kd_jenis_anastesi)>
                                    {{ $item->jenis_anastesi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="jenis_operasi" style="min-width: 200px;">Jenis
                            Operasi</label>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="kompleksitas"
                            style="min-width: 200px;">kompleksitas</label>
                        <select name="kompleksitas" id="kompleksitas" class="form-select" disabled>
                            <option value="">--Pilih--</option>
                            <option value="1" @selected($laporan->kompleksitas == '1')>Besar</option>
                            <option value="2" @selected($laporan->kompleksitas == '2')>Sedang</option>
                            <option value="3" @selected($laporan->kompleksitas == '3')>Kecil</option>
                            <option value="4" @selected($laporan->kompleksitas == '4')>Khusus</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="urgensi" style="min-width: 200px;">Urgensi</label>
                        <select name="urgensi" id="urgensi" class="form-select" disabled>
                            <option value="">--Pilih--</option>
                            <option value="1" @selected($laporan->urgensi == '1')>Cito (Darurat)</option>
                            <option value="2" @selected($laporan->urgensi == '2')>Elective (Terjadwal)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="kebersihan" style="min-width: 200px;">Kebersihan
                            Area Operasi</label>
                        <select name="kebersihan" id="kebersihan" class="form-select" disabled>
                            <option value="">--Pilih--</option>
                            <option value="1" @selected($laporan->kebersihan == '1')>Bersih</option>
                            <option value="2" @selected($laporan->kebersihan == '2')>Tercemar</option>
                            <option value="3" @selected($laporan->kebersihan == '3')>Kotor</option>
                        </select>
                    </div>
                </div>

                <div class="section-separator" id="edukasiPasien">
                    <h5 class="section-title">2. Diagnosa dan Komplikasi</h5>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="diagnosa_pra_operasi" style="min-width: 200px;">Diagnosa
                            Pra-Operasi</label>
                        <input placeholder="isi Diagnosa Pra-Operasi" type="text" class="form-control"
                            name="diagnosa_pra_operasi" id="diagnosa_pra_operasi"
                            value="{{ $laporan->diagnosa_pra_operasi }}" disabled>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="diagnosa_pasca_operasi"
                            style="min-width: 200px;">Diagnosa Pasca-Operasi</label>
                        <input placeholder="isi Diagnosa Pasca-Operasi" type="text" class="form-control"
                            name="diagnosa_pasca_operasi" id="diagnosa_pasca_operasi"
                            value="{{ $laporan->diagnosa_pasca_operasi }}" disabled>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="komplikasi" style="min-width: 200px;">Bila Ada
                            Komplikasi Selama Pembedahan</label>
                        <input placeholder="isi Komplikasi Selama Pembedahan" type="text" class="form-control"
                            name="komplikasi" id="komplikasi" value="{{ $laporan->komplikasi }}" disabled>
                    </div>
                </div>

                <div class="section-separator" id="persetujuanPasien">
                    <h5 class="section-title">3. Pemeriksaan Laboratorium & Patologi Anatomi (PA)</h5>

                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="pa" style="min-width: 200px;">Dikirim Untuk
                            Pemeriksaan PA</label>
                        <select name="pa" id="pa" class="form-select" disabled>
                            <option value="">--Pilih--</option>
                            <option value="1" @selected($laporan->pa == '1')>Ya</option>
                            <option value="0" @selected($laporan->pa == '0')>Tidak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="kultur" style="max-width: 200px;">Dikirim Untuk
                            kultur</label>
                        <select name="kultur" id="kultur" class="form-select" disabled>
                            <option value="">--Pilih--</option>
                            <option value="1" @selected($laporan->kultur == '1')>Ya</option>
                            <option value="0" @selected($laporan->kultur == '2')>Tidak</option>
                        </select>
                    </div>
                </div>

                <div class="section-separator" id="persetujuanPasien">
                    <h5 class="section-title">4. Tim Medis Yang Bertanggung Jawab</h5>

                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="kd_dokter_bedah" style="min-width: 200px;">Dokter
                            Ahli Bedah</label>
                        <select name="kd_dokter_bedah" id="kd_dokter_bedah" class="form-select select2" disabled>
                            <option value="">--Pilih--</option>
                            @foreach ($dokter as $dok)
                                <option value="{{ $dok->kd_dokter }}" @selected($dok->kd_dokter == $laporan->kd_dokter_bedah)>
                                    {{ $dok->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="kd_perawat_bedah" style="min-width: 200px;">Perawat
                            Bedah</label>
                        <select name="kd_perawat_bedah" id="kd_perawat_bedah" class="form-select select2" disabled>
                            <option value="">--Pilih--</option>
                            @foreach ($perawat as $prw)
                                <option value="{{ $prw->kd_perawat }}" @selected($prw->kd_perawat == $laporan->kd_perawat_bedah)>
                                    {{ $prw->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="kd_dokter_anastesi" style="min-width: 200px;">Dokter
                            Ahli Anestesi</label>
                        <select name="kd_dokter_anastesi" id="kd_dokter_anastesi" class="form-select select2" disabled>
                            <option value="">--Pilih--</option>
                            @foreach ($dokterAnastesi as $da)
                                <option value="{{ $da->kd_dokter }}" @selected($da->kd_dokter == $laporan->kd_dokter_anastesi)>
                                    {{ $da->dokter->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="kd_penata_anastesi" style="min-width: 200px;">Penata
                            Anestesi</label>
                        <select name="kd_penata_anastesi" id="kd_penata_anastesi" class="form-select select2" disabled>
                            <option value="">--Pilih--</option>
                            @foreach ($perawat as $prw)
                                <option value="{{ $prw->kd_perawat }}" @selected($prw->kd_perawat == $laporan->kd_penata_anastesi)>
                                    {{ $prw->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="section-separator" id="persetujuanPasien">
                    <h5 class="section-title">5. Pendarahan dan Transfusi</h5>

                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="pendarahan" style="min-width: 200px;">Pendarahan
                            Selama Operasi</label>
                        <div class="input-group">
                            <span class="input-group-text">+-</span>
                            <input placeholder="isi seberapa banyak pendarahan selama operasi" type="number"
                                class="form-control" name="pendarahan" id="pendarahan"
                                value="{{ $laporan->pendarahan }}" disabled>
                            <span class="input-group-text">cc</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="transfusi_darah" style="min-width: 200px;">Transfusi
                            Darah</label>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="wb" style="min-width: 200px;">WB (Whole
                            Blood)</label>
                        <div class="input-group">
                            <input placeholder="Isi seberapa banyak WB (Whole Blood)" type="number" class="form-control"
                                name="wb" id="wb" value="{{ $laporan->wb }}" disabled>
                            <span class="input-group-text">cc</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="prc" style="min-width: 200px;">PRC (Packed
                            Red Cells)</label>
                        <div class="input-group">
                            <input placeholder="Isi seberapa banyak PRC (Packed Red Cells)" type="number"
                                class="form-control" name="prc" id="prc" value="{{ $laporan->prc }}"
                                disabled>
                            <span class="input-group-text">cc</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 col-form-label" for="cryo" style="min-width: 200px;">Cryo
                            (Cryoprecipitate)</label>
                        <div class="input-group">
                            <input placeholder="Isi seberapa banyak Cryo (Cryoprecipitate)" type="number"
                                class="form-control" name="cryo" id="cryo" value="{{ $laporan->cryo }}"
                                disabled>
                            <span class="input-group-text">cc</span>
                        </div>
                    </div>
                </div>

                <div class="section-separator" id="dataMasuk">
                    <h5 class="section-title">6. Waktu Pelaksanaan Operasi</h5>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" style="min-width: 200px;">Waktu Mulai Operasi</label>

                        <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control me-3"
                            value="{{ date('Y-m-d', strtotime($laporan->tgl_mulai)) }}" disabled>
                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control"
                            value="{{ date('H:i', strtotime($laporan->jam_mulai)) }}" disabled>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" style="min-width: 200px;">Waktu Selesai Operasi</label>

                        <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control me-3"
                            value="{{ date('Y-m-d', strtotime($laporan->tgl_selesai)) }}" disabled>
                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control"
                            value="{{ date('H:i', strtotime($laporan->jam_selesai)) }}" disabled>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-form-label" style="min-width: 200px;">Lama Operasi</label>
                        <input type="text" name="lama_operasi" id="lama_operasi" class="form-control"
                            placeholder="Cth : 1 jam" value="{{ $laporan->lama_operasi }}" disabled>
                    </div>
                </div>

                <div class="section-separator mb-0" id="dataMasuk">
                    <h5 class="section-title">7. Laporan Prosedur Operasi</h5>
                    <div class="form-group">
                        <label for="laporan_prosedur_operasi" class="col-md-3 col-form-label"
                            style="min-width: 200px;">Laporan Prosedur Operasi</label>
                        <textarea placeholder="Jelaskan deskripsilengkap tentang prosedur bedah yang dilakukan "
                            name="laporan_prosedur_operasi" id="laporan_prosedur_operasi" class="form-control" disabled>{{ $laporan->laporan_prosedur_operasi }}</textarea>
                    </div>
                </div>

            </x-content-card>
        </div>
    </div>
@endsection
