<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.medis.patient-card')
        </div>

        <div class="col-md-9">

            <form method="POST" action="{{ route('operasi.pelayanan.asesmen.pra-anestesi.edukasi.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($asesmen->edukasiAnestesi->id)]) }}" enctype="multipart/form-data">
                @csrf
                @method('put')

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
                                            <label style="min-width: 200px;">Tanggal dan Jam Masuk</label>

                                            <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control me-3" value="{{ date('Y-m-d', strtotime($asesmen->edukasiAnestesi->tgl_op)) }}">
                                            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control"value="{{ date('H:i', strtotime($asesmen->edukasiAnestesi->jam_op)) }}">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="jenisAnestesi">
                                        <h5 class="section-title">2. Jenis Anestesi</h5>

                                        <div class="form-group">
                                            <label for="jenis_anestesi" style="min-width: 200px;">Jenis Anestesi Yang Digunakan</label>
                                            <select name="jenis_anestesi" id="jenis_anestesi" class="form-select">
                                                <option value="">--Pilih--</option>
                                                @foreach ($jenisAnastesi as $item)
                                                    <option value="{{ $item->kd_jenis_anastesi }}" @selected($item->kd_jenis_anastesi == $asesmen->edukasiAnestesi->jenis_anestesi)>{{ $item->jenis_anastesi }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="text-center">
                                            <p class="fw-bold fs-4">Penjelasan Singkat Jenis Anestesi</p>
                                        </div>

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr align="middle">
                                                    <th>Jenis Anestesi</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Anestesi Umum (GA – General Anesthesia)</td>
                                                    <td>
                                                        Pasien tidak sadar sepenuhnya selama operasi dan memerlukan alat bantu napas.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Anestesi Regional (Spinal, Epidural)</td>
                                                    <td>
                                                        Membius sebagian tubuh, pasien tetap sadar tetapi tidak merasakan nyeri di area tertentu.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Blok Perifer
                                                    </td>
                                                    <td>
                                                        Anestesi regional yang diberikan di sekitar saraf tertentu untuk membius bagian tubuh tertentu tanpa mempengaruhi kesadaran pasien.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sedasi Sedang dan Dalam</td>
                                                    <td>
                                                        Pasien dalam keadaan rileks atau tertidur ringan tanpa kehilangan kesadaran sepenuhnya
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Anestesia Topikal</td>
                                                    <td>
                                                        Membius area kecil tanpa mempengaruhi kesadaran pasien, misalnya untuk operasi kecil.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="section-separator" id="edukasiPasien">
                                        <h5 class="section-title">3. Edukasi Pasien</h5>
                                        <p>Bagian ini mencatat informasi yang telah diberikan kepada pasien untuk memastikan mereka memahami prosedur anestesi.</p>

                                        <div class="text-center">
                                            <p class="fw-bold fs-4">Penjelasan Singkat Jenis Anestesi</p>
                                        </div>

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr align="middle">
                                                    <th>Topik Edukasi</th>
                                                    <th>Penjelasan yang Harus Disampaikan ke Pasien</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Tujuan Pemberian Anestesi</td>
                                                    <td>
                                                        Mengapa anestesi diperlukan dalam prosedur yang akan dijalani.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Prosedur yang Akan Dilakukan
                                                    </td>
                                                    <td>
                                                        Langkah-langkah selama anestesi diberikan.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Manfaat dan Risiko Anestesi</td>
                                                    <td>
                                                        Efek positif anestesi serta risiko yang mungkin terjadi.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Efek Samping yang Mungkin Terjadi</td>
                                                    <td>
                                                        <ul style="margin: 0; padding-left: 20px;">
                                                            <li>Mual/muntah</li>
                                                            <li>Pusing</li>
                                                            <li>Reaksi alergi terhadap obat anestesi</li>
                                                            <li>Gangguan pernapasan</li>
                                                            <li>Sakit kepala pasca-anestesi</li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Instruksi Pra-Anestesi</td>
                                                    <td>
                                                        <ul style="margin: 0; padding-left: 20px;">
                                                            <li>Pasien harus puasa sebelum anestesi untuk mencegah aspirasi.</li>
                                                            <li>Penghentian obat tertentu sebelum operasi.</li>
                                                            <li>Memberitahu dokter jika memiliki riwayat alergi obat.</li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Instruksi Pasca-Anestesi</td>
                                                    <td>
                                                        <ul style="margin: 0; padding-left: 20px;">
                                                            <li> Pasien mungkin merasa lelah setelah anestesi.</li>
                                                            <li>Larangan mengemudi atau mengoperasikan mesin selama 24 jam setelah anestesi.</li>
                                                            <li>Pengelolaan nyeri pasca-tindakan jika diperlukan.</li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="form-group">
                                            <label for="edukasi_prosedur" style="min-width: 200px;">Edukasi tentang prosedur operasi</label>
                                            <select name="edukasi_prosedur" id="edukasi_prosedur" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="1" @selected($asesmen->edukasiAnestesi->edukasi_prosedur == '1')>Sudah</option>
                                                <option value="0" @selected($asesmen->edukasiAnestesi->edukasi_prosedur == '0')>Belum</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="persetujuanPasien">
                                        <h5 class="section-title">4. Persetujuan Pasien dan Keluarga</h5>

                                        <div class="form-group">
                                            <label for="pemahaman_pasien" style="min-width: 200px;">Pemahaman Pasien</label>
                                            <select name="pemahaman_pasien" id="pemahaman_pasien" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="1" @selected($asesmen->edukasiAnestesi->pemahaman_pasien == '1')>Baik</option>
                                                <option value="2" @selected($asesmen->edukasiAnestesi->pemahaman_pasien == '2')>Cukup</option>
                                                <option value="3" @selected($asesmen->edukasiAnestesi->pemahaman_pasien == '3')>Kurang</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="informed_consent" style="max-width: 200px;">Persetujuan Tindakan (Informed Consent)</label>
                                            <select name="informed_consent" id="informed_consent" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="1" @selected($asesmen->edukasiAnestesi->informed_consent == '1')>Ya</option>
                                                <option value="0" @selected($asesmen->edukasiAnestesi->informed_consent == '0')>Tidak</option>
                                            </select>
                                        </div>

                                        <p>Data Persetujuan Prosedur Anestesia dan sedasi yang akan dilakukan. Diisi oleh pasien/istri/suami anak/ayah/ibu.</p>

                                        <div class="form-group">
                                            <label for="nama_keluarga" style="min-width: 200px;">Nama Yang Bertanda Tangan</label>
                                            <input type="text" class="form-control" name="nama_keluarga" id="nama_keluarga" value="{{ $asesmen->edukasiAnestesi->nama_keluarga }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="usia_keluarga" style="min-width: 200px;">Usia (tahun)</label>
                                            <input type="number" class="form-control" name="usia_keluarga" id="usia_keluarga" value="{{ $asesmen->edukasiAnestesi->usia_keluarga }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="jenis_kelamin" style="min-width: 200px;">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                                <option value="">--Pilih--</option>
                                                <option value="1" @selected($asesmen->edukasiAnestesi->jenis_kelamin == '1')>Laki-Laki</option>
                                                <option value="0" @selected($asesmen->edukasiAnestesi->jenis_kelamin == '0')>Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="no_telepon" style="min-width: 200px;">No Telepon</label>
                                            <input type="number" class="form-control" name="no_telepon" id="no_telepon" value="{{ $asesmen->edukasiAnestesi->no_telepon }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="dokter_edukasi" style="max-width: 200px;">Dokter Yang Memberikan Edukasi</label>
                                            <select name="dokter_edukasi" id="dokter_edukasi" class="form-select select2">
                                                <option value="">--Pilih--</option>
                                                @foreach ($dokterAnastesi as $item)
                                                    <option value="{{ $item->kd_dokter }}" @selected($asesmen->edukasiAnestesi->dokter_edukasi == $item->kd_dokter)>{{ $item->dokter->nama_lengkap }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="" style="min-width: 200px;">Tanggal dan Jam Dilakukan</label>
                                            <input type="date" class="form-control" name="tgl_dilakukan" id="tgl_dilakukan" value="{{ date('Y-m-d', strtotime($asesmen->edukasiAnestesi->tgl_dilakukan)) }}">
                                            <input type="time" class="form-control" name="jam_dilakukan" id="jam_dilakukan" value="{{ date('H:i', strtotime($asesmen->edukasiAnestesi->jam_dilakukan)) }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="file_persetujuan" style="min-width: 200px;">HardCopy Form Persetujuan</label>
                                            <input type="file" class="form-control" name="file_persetujuan" id="file_persetujuan">
                                            <a href="{{ asset('storage/' . $asesmen->edukasiAnestesi->file_persetujuan) }}" target="_blank" class="btn btn-primary btn-sm">Lihat</a>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="persetujuanPasien">
                                        <h5 class="section-title">5. Catatan Tambahan</h5>

                                        <div class="form-group">
                                            <label for="pertanyaan_pasien" style="max-width: 200px;">Pertanyaan atau Kekhawatiran Pasien</label>
                                            <textarea name="pertanyaan_pasien" id="pertanyaan_pasien" class="form-control">{{ $asesmen->edukasiAnestesi->pertanyaan_pasien }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="rekomendasi_dokter" style="max-width: 200px;">Rekomendasi Tambahan Dari Dokter</label>
                                            <textarea name="rekomendasi_dokter" id="rekomendasi_dokter" class="form-control">{{ $asesmen->edukasiAnestesi->rekomendasi_dokter }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="lainnya" style="min-width: 200px;">Lain-Lain</label>
                                            <textarea name="lainnya" id="lainnya" class="form-control">{{ $asesmen->edukasiAnestesi->lainnya }}</textarea>
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
