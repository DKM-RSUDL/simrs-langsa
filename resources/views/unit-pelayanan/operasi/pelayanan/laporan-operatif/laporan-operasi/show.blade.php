<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.laporan-operatif.laporan-operasi.patient-card')
        </div>

        <div class="col-md-9">

            <form method="POST" action="" enctype="multipart/form-data">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">

                            <div class="px-3">
                                <div>
                                    <a href="{{ url()->previous() }}" class="btn">
                                        <i class="ti-arrow-left"></i> Kembali
                                    </a>

                                    <div class="section-separator" id="dataMasuk">
                                        <h5 class="section-title">1. Data Masuk</h5>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" style="min-width: 200px;">Tanggal dan Jam Masuk</label>
                                            <div class="col-md-4">
                                                <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="time" name="jam_masuk" id="jam_masuk" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="jenisAnestesi">
                                        <h5 class="section-title">2. Informasi Operasi</h5>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="nama_tindakan_operasi" style="min-width: 200px;">Nama Tindakan Operasi</label>
                                            <input placeholder="Nama Tindakan Operasi" type="text" class="form-control" name="nama_tindakan_operasi" id="nama_tindakan_operasi">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="jenis_anestesi" style="min-width: 200px;">Jenis Anestesi Yang Digunakan</label>
                                            <select name="jenis_anestesi" id="jenis_anestesi" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="">contoh</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="jenis_operasi" style="min-width: 200px;">Jenis Operasi</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="kompleksitas" style="min-width: 200px;">kompleksitas</label>
                                            <select name="kompleksitas" id="kompleksitas" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="Besar">Besar</option>
                                                <option value="Sedang">Sedang</option>
                                                <option value="Kecil">Kecil</option>
                                                <option value="Khusus">Khusus</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="urgensi" style="min-width: 200px;">Urgensi</label>
                                            <select name="urgensi" id="urgensi" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="cito">Cito (Darurat)</option>
                                                <option value="Elecive">Elecive (Terjadwal)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="kebersihan_area_operasi" style="min-width: 200px;">Kebersihan Area Operasi</label>
                                            <select name="kebersihan_area_operasi" id="kebersihan_area_operasi" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="bersih">Bersih</option>
                                                <option value="tercemar">Tercemar</option>
                                                <option value="kotor">Kotor</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="edukasiPasien">
                                        <h5 class="section-title">3. Diagnosa dan Komplikasi</h5>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="diagnosa_praoperasi" style="min-width: 200px;">Diagnosa Pra-Operasi</label>
                                            <input placeholder="isi Diagnosa Pra-Operasi" type="text" class="form-control" name="diagnosa_praoperasi" id="diagnosa_praoperasi">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="diagnosa_pascaoperasi" style="min-width: 200px;">Diagnosa Pasca-Operasi</label>
                                            <input placeholder="isi Diagnosa Pasca-Operasi" type="text" class="form-control" name="diagnosa_pascaoperasi" id="diagnosa_pascaoperasi">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="Kompilkasi" style="min-width: 200px;">Bila Ada Kompilkasi Selama Pembedahan</label>
                                            <input placeholder="isi Kompilkasi Selama Pembedahan" type="text" class="form-control" name="Kompilkasi" id="Kompilkasi">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="persetujuanPasien">
                                        <h5 class="section-title">4. Pemeriksaan Laboratorium & Patologi Anatomi (PA)</h5>

                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="pemeriksaan_pa" style="min-width: 200px;">Dikirim Untuk Pemeriksaan PA</label>
                                            <select name="pemeriksaan_pa" id="pemeriksaan_pa" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="pemeriksaan_kultur" style="max-width: 200px;">Dikirim Untuk kultur</label>
                                            <select name="pemeriksaan_kultur" id="pemeriksaan_kultur" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="section-separator" id="persetujuanPasien">
                                        <h5 class="section-title">5. Tim Medis Yang Bertanggung Jawab</h5>

                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="dokter_bedah" style="min-width: 200px;">Dokter Ahli Bedah</label>
                                            <input placeholder="isi nama Dokter Ahli Bedah" type="text" class="form-control" name="dokter_bedah" id="dokter_bedah">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="perawat_bedah" style="min-width: 200px;">Perawat Bedah</label>
                                            <input placeholder="isi nama Perawat Bedah" type="text" class="form-control" name="perawat_bedah" id="perawat_bedah">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="dokter_anestesi" style="min-width: 200px;">Dokter Ahli Anestesi</label>
                                            <input placeholder="isi nama Dokter Ahli Anestesi" type="text" class="form-control" name="dokter_anestesi" id="dokter_anestesi">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="penata_anestesi" style="min-width: 200px;">Penata Anestesi</label>
                                            <input placeholder="isi nama Penata Anestesi" type="text" class="form-control" name="penata_anestesi" id="penata_anestesi">
                                        </div>
                                    </div>
                                    <div class="section-separator" id="persetujuanPasien">
                                        <h5 class="section-title">6. Pendarahan dan Transfusi</h5>

                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="pendarahan_selama_operasi" style="min-width: 200px;">Pendarahan Selama Operasi</label>
                                            <div class="input-group">
                                                <span class="input-group-text">+-</span>
                                                <input placeholder="isi seberapa banyak pendarahan selama operasi" type="number" class="form-control" name="pendarahan_selama_operasi" id="pendarahan_selama_operasi">
                                                <span class="input-group-text">cc</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="transfusi_darah" style="min-width: 200px;">Transfusi Darah</label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="wb" style="min-width: 200px;">WB (Whole Blood)</label>
                                            <div class="input-group">
                                                <input placeholder="Isi seberapa banyak WB (Whole Blood)" type="number" class="form-control" name="wb" id="wb">
                                                <span class="input-group-text">cc</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="prc" style="min-width: 200px;">PRC (Packed Red Cells)</label>
                                            <div class="input-group">
                                                <input placeholder="Isi seberapa banyak PRC (Packed Red Cells)" type="number" class="form-control" name="prc" id="prc">
                                                <span class="input-group-text">cc</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="cryo" style="min-width: 200px;">Cryo (Cryoprecipitate)</label>
                                            <div class="input-group">
                                                <input placeholder="Isi seberapa banyak Cryo (Cryoprecipitate)" type="number" class="form-control" name="cryo" id="cryo">
                                                <span class="input-group-text">cc</span>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="section-separator" id="dataMasuk">
                                        <h5 class="section-title">7. Waktu Pelaksanaan Operasi</h5>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" style="min-width: 200px;">Waktu Mulai Operasi</label>

                                            <input type="date" name="tgl_mulai" id="tgl_mulai" class="form-control me-3">
                                            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" style="min-width: 200px;">Waktu Selesai Operasi</label>

                                            <input type="date" name="tgl_selesai" id="tgl_selesai" class="form-control me-3">
                                            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" style="min-width: 200px;">Lama Operasi</label>
                                            <input type="time" name="lama_operasi" id="lama_operasi" class="form-control">
                                        </div>
                                    </div>
                                    <div class="section-separator" id="dataMasuk">
                                        <h5 class="section-title">8. Laporan Prosedur Operasi</h5>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" style="min-width: 200px;">Laporan Prosedur Operasi</label>
                                            <textarea placeholder="Jelaskan deskripsilengkap tentang prosedur bedah yang dilakukan " name="laporan_prosedur_operasi" id="laporan_prosedur_operasi" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="persetujuanPasien">
                                        <h5 class="section-title">9. Tanda Tangan Verifikasi</h5>

                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="dokter_bedah" style="max-width: 200px;">Signature Dokter Bedah</label>
                                            <select name="dokter_bedah" id="dokter_bedah" class="form-select select2">
                                                <option value="">--Pilih--</option>
                                                <option value="">ADAM YORDAN</option>
                                               
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-form-label" for="dokter_anestesi" style="max-width: 200px;">Signature Dokter Anestesi</label>
                                            <select name="dokter_anestesi" id="dokter_anestesi" class="form-select select2">
                                                <option value="">--Pilih--</option>
                                                <option value="">ADAM YORDAN</option>
                                            </select>
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
