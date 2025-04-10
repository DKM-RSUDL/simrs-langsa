<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.laporan-anastesi.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('operasi.pelayanan.laporan-anastesi.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form method="POST"
                action="{{ route('operasi.pelayanan.laporan-anastesi.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <div class="px-3">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <h4 class="header-asesmen">Asesmen Catatan Keperawatan Periopetif (Intra dan Pasca
                                            Operasi)</h4>
                                        <p>
                                            Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-3">
                                <div>


                                    <div class="section-separator" id="dataMasuk">
                                        <h5 class="section-title">1. Data Masuk</h5>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal dan Jam Masuk</label>
                                            <input type="date" name="tgl_data_masuk" id="tgl_masuk" class="form-control me-3" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" value="{{ \Carbon\Carbon::now()->format('H:i') }}">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="jenisOperasi">
                                        <h5 class="section-title">2. Jenis dan Tipe Operasi</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Dilakukan Operasi/Jenis Operasi</label>
                                            <input type="text" class="form-control" name="jenis_operasi">
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tipe Operasi</label>
                                            <select class="form-select" name="tipe_operasi">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Elektif">Elektif</option>
                                                <option value="Darurat">Darurat</option>
                                                <option value="Operasi ODC">Operasi ODC</option>
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
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                            <input type="time" name="jam_time_out" id="jam_time_out" class="form-control">
                                        </div>

                                        <!-- Tingkat Kesadaran Pasien Saat Masuk Kamar Operasi -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tingkat Kesadaran Pasien Saat Masuk Kamar
                                                Operasi</label>
                                            <select class="form-select" name="tingkat_kesadaran">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Terjaga">Terjaga</option>
                                                <option value="Mudah Dibangunkan">Mudah Dibangunkan</option>
                                            </select>
                                        </div>


                                        <!-- Posisi Pasien Selama Operasi -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Posisi Pasien Selama Operasi</label>
                                            <select class="form-select" name="posisi_pasien">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Telentang">Telentang</option>
                                                <option value="Litothomy">Litothomy</option>
                                                <option value="Tengkurap">Tengkurap</option>
                                                <option value="Lateral">Lateral</option>
                                            </select>
                                        </div>

                                        <!-- Posisi Lengan -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Posisi Lengan</label>
                                            <select class="form-select" name="posisi_lengan">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Terentang">Terentang</option>
                                                <option value="Terlipat">Terlipat</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select>
                                        </div>

                                        <!-- Posisi Kanula Intra Vena -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Posisi Kanula Intra Vena</label>
                                            <select class="form-select" name="posisi_kanula">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Tangan Kanan">Tangan Kanan</option>
                                                <option value="Tangan Kiri">Tangan Kiri</option>
                                                <option value="Arterial Line">Arterial Line</option>
                                                <option value="CVP">CVP</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select>
                                        </div>

                                        <!-- Pemasangan Kater Urin -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pemasangan Kater Urin</label>
                                            <select class="form-select" name="pemasangan_kater_urin">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- Bila Dilakukan Kater Urin -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bila Dilakukan Kater Urin</label>
                                            <select class="form-select" name="bila_kater_urin">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Kamar Operasi">Kamar Operasi</option>
                                                <option value="Ruangan">Ruangan</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select>
                                        </div>

                                        <!-- Persiapan Kulit -->
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Persiapan Kulit</label>
                                            <select class="form-select" name="persiapan_kulit">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Chlorhexidine/70%">Chlorhexidine/70%</option>
                                                <option value="Povidone-loclinHibiscrub">Povidone-loclinHibiscrub</option>
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
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                            <input type="time" name="jam_instrumen" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Prothese/Lmplant</label>
                                            <select class="form-select me-3" name="prothese">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                            <input type="time" name="jam_prothese" class="form-control">
                                        </div>

                                        <!-- Pemasangan Diathermy (Elektrokauter) -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Pemasangan Diathermy (Elektrokauter)</label>
                                            <select class="form-select" name="diathermy">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- Lokasi Diathermy (Elektrokauter) -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Lokasi Diathermy (Elektrokauter)</label>
                                            <select class="form-select" name="lokasi_diathermy">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Paha">Paha</option>
                                                <option value="Lengan">Lengan</option>
                                                <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                            </select>
                                        </div>

                                        <!-- Bila Ada, Kode Unit Elektrosurgical -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Bila Ada, Kode Unit Elektrosurgical</label>
                                            <input type="text" class="form-control" name="kode_unit_elektrosurgical">
                                        </div>

                                        <!-- Unit Pemasangan / Pendingin Operasi -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Unit Pemasangan / Pendingin Operasi</label>
                                            <select class="form-select" name="unit_pemasangan">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- Bila Ya, Pengaturan Temperatur Mulai -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Bila Ya, Pengaturan Temperatur Mulai</label>
                                            <input type="text" class="form-control" name="pengaturan_temperatur_mulai"
                                                placeholder="Suhu">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Kode Unit</label>
                                            <input type="text" class="form-control"
                                                name="kode_unit" placeholder="kode">
                                        </div>

                                        <!-- Pengaturan Temperatur Selesai -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Pengaturan Temperatur Selesai</label>
                                            <input type="text" class="form-control"
                                                name="pengaturan_temperatur_selesai" placeholder="Suhu">
                                        </div>

                                        <!-- Jam Mulai S/D Selesai -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Jam Mulai S/D Selesai</label>
                                            <input type="time" name="jam_temperatur_mulai" class="form-control me-3">
                                            <input type="time" name="jam_temperatur_selesai" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Pemakaian Tomiquet</label>
                                            <select class="form-select" name="pemakaian_tomiquet">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Pengawas Tomiquet</label>
                                            <input type="text" class="form-control" name="pengawas_tomiquet">
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
                                                            <input type="time" name="jam_lengan_kanan_mulai"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="time" name="jam_lengan_kanan_selesai"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="tekanan_lengan_kanan"
                                                                class="form-control" placeholder="mmHg">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label">Kaki Kanan</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="time" name="jam_kaki_kanan_mulai"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="time" name="jam_kaki_kanan_selesai"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="tekanan_kaki_kanan"
                                                                class="form-control" placeholder="mmHg">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label">Lengan Kiri</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="time" name="jam_lengan_kiri_mulai"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="time" name="jam_lengan_kiri_selesai"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="tekanan_lengan_kiri"
                                                                class="form-control" placeholder="mmHg">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label">Kaki Kiri</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="time" name="jam_kaki_kiri_mulai"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="time" name="jam_kaki_kiri_selesai"
                                                                class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="tekanan_kaki_kiri"
                                                                class="form-control" placeholder="mmHg">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pemakaian Laser -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Pemakaian Laser</label>
                                            <select class="form-select" name="pemakaian_laser">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <!-- Kode Model -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Kode Model</label>
                                            <input type="text" class="form-control" name="kode_model">
                                        </div>

                                        <!-- Pengawas Laser -->
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Pengawas Laser</label>
                                            <input type="text" class="form-control" name="pengawas_laser">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;">Pemaikan Implant</label>
                                            <select class="form-select" name="pemakaian_implant">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;"></label>
                                            <div class="d-flex gap-3" style="width: 100%;">

                                                <div class="flex-grow-1">
                                                    <label class="form-label">Pabrik</label>
                                                    <input type="text" class="form-control" name="pabrik"
                                                        placeholder="pabrik">
                                                </div>

                                                <div class="flex-grow-1">
                                                    <label class="form-label">Size</label>
                                                    <input type="text" class="form-control" name="size"
                                                        placeholder="Size">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 300px;"></label>
                                            <div class="d-flex gap-3" style="width: 100%;">

                                                <div class="flex-grow-1">
                                                    <label class="form-label">Type</label>
                                                    <input type="text" class="form-control" name="tipe"
                                                        placeholder="pabrik">
                                                </div>

                                                <div class="flex-grow-1">
                                                    <label class="form-label">No Seri</label>
                                                    <input type="text" class="form-control" name="no_seri"
                                                        placeholder="No. Seri">
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
                                                            <div class="form-check">
                                                                <label class="form-check-label">Hitung 1</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="kassa1" class="form-control"
                                                                placeholder="jumlah">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="jarum1" class="form-control"
                                                                placeholder="jumlah">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="instrumen1" class="form-control"
                                                                placeholder="jumlah">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label">Hitung 2</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="kassa2" class="form-control"
                                                                placeholder="jumlah">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="jarum2" class="form-control"
                                                                placeholder="jumlah">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="instrumen2" class="form-control"
                                                                placeholder="jumlah">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label">Hitung 3</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="kassa3" class="form-control"
                                                                placeholder="jumlah">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="jarum3" class="form-control"
                                                                placeholder="jumlah">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="instrumen3" class="form-control"
                                                                placeholder="jumlah">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="kassa" id="kassa_tidak_lengkap"
                                                                    value="Tidak Lengkap">
                                                                <label class="form-check-label"
                                                                    for="kassa_tidak_lengkap">Tidak Lengkap</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="jarum" id="jarum_tidak_lengkap"
                                                                    value="Tidak Lengkap">
                                                                <label class="form-check-label"
                                                                    for="jarum_tidak_lengkap">Tidak Lengkap</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="instrumen" id="instrumen_tidak_lengkap"
                                                                    value="Tidak Lengkap">
                                                                <label class="form-check-label"
                                                                    for="instrumen_tidak_lengkap">Tidak Lengkap</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="form-check">
                                                                <label class="form-check-label"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="kassa" id="kassa_tidak_perlu"
                                                                    value="Tidak perlu">
                                                                <label class="form-check-label"
                                                                    for="kassa_tidak_perlu">Tidak Perlu</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="jarum" id="jarum_tidak_perlu"
                                                                    value="Tidak perlu">
                                                                <label class="form-check-label"
                                                                    for="jarum_tidak_perlu">Tidak Perlu</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 align-items-center">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="instrumen" id="instrumen_tidak_perlu"
                                                                    value="Tidak perlu">
                                                                <label class="form-check-label"
                                                                    for="instrumen_tidak_perlu">Tidak Perlu</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <h6>Catatan :</h6>
                                        <p class="text-small">Jika dihitung tidak lengkap, setelah dicari tidak ditemukan.
                                            Dilakukan nya X-Ray
                                        </p>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Dilakukan X-Ray</label>
                                            <select class="form-select" name="dilakukan_xray">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Penggunaan Tampon</label>
                                            <select class="form-select" name="penggunaan_tampon">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bila Ya, Jenis Tampon</label>
                                            <input type="text" class="form-control" name="jenis_tampon">
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
                                                                placeholder="Tipe Drain">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="jenis_drain" class="form-control"
                                                                placeholder="Jenis Drain">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="ukuran_drain"
                                                                class="form-control" placeholder="Ukuran Drain">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="keterangan_drain"
                                                                class="form-control" placeholder="Keterangan Drain">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="tipe_drain2" class="form-control"
                                                                placeholder="Tipe Drain">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="jenis_drain2"
                                                                class="form-control" placeholder="Jenis Drain">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="ukuran_drain2"
                                                                class="form-control" placeholder="Ukuran Drain">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="keterangan_drain2"
                                                                class="form-control" placeholder="Keterangan Drain">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="tipe_drain3" class="form-control"
                                                                placeholder="Tipe Drain">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="jenis_drain3"
                                                                class="form-control" placeholder="Jenis Drain">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="ukuran_drain3"
                                                                class="form-control" placeholder="Ukuran Drain">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="keterangan_drain3"
                                                                class="form-control" placeholder="Keterangan Drain">
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Irigasi Luka</label>
                                            <select class="form-select" name="irigasi_luka">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Sodium Chloride 0,9%">Sodium Chloride 0,9%</option>
                                                <option value="AntiWolik Spray">AntiWolik Spray</option>
                                                <option value="Anbilotik">Anbilotik</option>
                                                <option value="H2O2">H2O2</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pemakaian Cairan</label>
                                            <select class="form-select me-3" name="pemakaian_cairan">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Sodium Chloride 0,9%">Sodium Chloride 0,9%</option>
                                                <option value="Glysin">Glysin</option>
                                                <option value="BSS Solution">BSS Solution</option>
                                                <option value="Air Untuk Irigasi">Air Untuk Irigasi</option>
                                            </select>
                                            <input type="number" class="form-control" name="banyak_pemakaian_cairan"
                                                placeholder="Liter">
                                        </div>

                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">7. Waktu dan Tim Medis</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Waktu Mulai Operasi</label>
                                            <input type="date" class="form-control me-3" name="waktu_mulai_operasi">
                                            <input type="time" class="form-control" name="jam_mulai_operasi">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Waktu Selesai Operasi</label>
                                            <input type="date" class="form-control me-3" name="waktu_selesai_operasi">
                                            <input type="time" class="form-control" name="jam_selesai_operasi">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Dokter Bedah</label>
                                            <select class="form-select select2" name="dokter_bedah">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($dokter as $d)
                                                    <option value="{{ $d->kd_dokter }}">{{ $d->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Dokter Anastesi</label>
                                            <select class="form-select" name="dokter_anastesi">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($dokterAnastesi as $da)
                                                    <option value="{{ $da->kd_dokter }}">{{ $da->dokter->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Penatara Anastesi</label>
                                            <select class="form-select select2" name="penatara_anastesi">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($perawat as $p)
                                                    <option value="{{ $p->kd_perawat }}">{{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Perawat Bedah</label>
                                            <select class="form-select select2" name="penatara_anastesi">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($perawat as $p)
                                                    <option value="{{ $p->kd_perawat }}">{{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>

                                    <div class="section-separator">
                                        <h5 class="section-title">8. Evaluasi Pasca Operasi</h5>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Pemeriksaan Kondisi Kulit Pra Operasi</label>
                                            <select class="form-select" name="pemeriksaan_kondisi_kulit_pra_operasi">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Utuh">Utuh</option>
                                                <option value="Menggelembung">Menggelembung</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Pemeriksaan Kondisi Kulit Pasca
                                                Operasi</label>
                                            <select class="form-select" name="pemeriksaan_kondisi_kulit_pasca_operasi">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Utuh">Utuh</option>
                                                <option value="Menggelembung">Menggelembung</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Balutan Luka</label>
                                            <select class="form-select" name="balutan_luka">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Tidak Ada">Tidak Ada</option>
                                                <option value="Pressure">Pressure</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Spesimen</label>
                                            <select class="form-select" name="spesimen">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Sodium Chloride 0,9%">Sodium Chloride 0,9%</option>
                                                <option value="AntiWolik Spray">AntiWolik Spray</option>
                                                <option value="Anbilotik">Anbilotik</option>
                                                <option value="H2O2">H2O2</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Jenis</label>
                                            <input type="text" class="form-control" name="jenis_spesimen">
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Jumlah Total Jaringan/Cairan
                                                Pemeriksaan</label>
                                            <input type="text" class="form-control" name="total_jaringan_cairan_pemeriksaan">
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Jenis dari Jaringan</label>
                                            <input type="text" class="form-control" name="jenis_jaringan">
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Jumlah dari Jaringan</label>
                                            <input type="text" class="form-control" name="jumlah_jaringan">
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 300px;">Keterangan</label>
                                            <textarea class="form-control" rows="3" name="keterangan"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="dokumentasiVerifikasi">
                                        <h5 class="section-title"
                                            style="color: #2c3e50; font-weight: 600; padding-bottom: 5px; margin-bottom: 20px;">
                                            9. Dokumentasi dan Verifikasi
                                        </h5>
                                        <div class="card shadow-sm"
                                            style="border: none; border-radius: 15px; background: #f8f9fa;">
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
                                                            <option selected disabled>--Pilih Perawat--</option>
                                                            @foreach ($perawat as $p)
                                                                <option value="{{ $p->kd_perawat }}"
                                                                    data-nama="{{ $p->nama }}">{{ $p->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div id="qrcode_perawat_instrumen" class="d-inline-block mb-2">
                                                        </div>
                                                        <p class="fw-medium" style="color: #7f8c8d;">
                                                            <span id="nama_perawat_instrumen" class="d-block mb-1"></span>
                                                            Ns. <span id="kode_perawat_instrumen"
                                                                class="badge bg-light text-dark px-3 py-1"
                                                                style="border-radius: 20px;">.........................</span>
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
                                                        <select class="form-select select2" name="perawat_sirkuler"
                                                            id="perawat_sirkuler" style="border-radius: 10px;">
                                                            <option selected disabled>--Pilih Perawat--</option>
                                                            @foreach ($perawat as $p)
                                                                <option value="{{ $p->kd_perawat }}"
                                                                    data-nama="{{ $p->nama }}">{{ $p->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 text-center">
                                                        <div id="qrcode_perawat_sirkuler" class="d-inline-block mb-2">
                                                        </div>
                                                        <p class="fw-medium" style="color: #7f8c8d;">
                                                            <span id="nama_perawat_sirkuler" class="d-block mb-1"></span>
                                                            Ns. <span id="kode_perawat_sirkuler"
                                                                class="badge bg-light text-dark px-3 py-1"
                                                                style="border-radius: 20px;">.........................</span>
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
                                                            <input type="date" class="form-control"
                                                                name="tanggal_pencatatan"
                                                                style="border-radius: 10px; max-width: 200px;">
                                                            <input type="time" class="form-control"
                                                                name="jam_pencatatan"
                                                                style="border-radius: 10px; max-width: 150px;">
                                                        </div>
                                                    </div>
                                                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode-generator/1.4.4/qrcode.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 jika belum
            $('.select2').select2();

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
