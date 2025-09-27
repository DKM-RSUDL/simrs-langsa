<!-- Modal Tambah Resep -->
<div class="modal fade" id="addInformedConsentModal" tabindex="-1" aria-labelledby="addInformedConsentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addInformedConsentModalLabel">Buat Informed Consent</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <form
                action="{{ route('rawat-inap.informed-consent.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam" class="form-label">Jam</label>
                                <input type="time" name="jam" id="jam" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Informasi Tindakan</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pemberi_info" class="form-label">Nama Pemberi Informasi</label>
                                <input type="text" name="nama_pemberi_info" id="nama_pemberi_info"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_penerima_info" class="form-label">Nama Penerima Informasi</label>
                                <input type="text" name="nama_penerima_info" id="nama_penerima_info"
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="diagnosis" class="form-label">Diagnosis (WD dan DD)</label>
                                <textarea name="diagnosis" id="diagnosis" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="dasar_diagnosis" class="form-label">Dasar Diagnosis</label>
                                <textarea name="dasar_diagnosis" id="dasar_diagnosis" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="tindakan_kedokteran" class="form-label">Tindakan Kedokteran</label>
                                <textarea name="tindakan_kedokteran" id="tindakan_kedokteran" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="indikasi_tindakan" class="form-label">Indikasi Tindakan</label>
                                <textarea name="indikasi_tindakan" id="indikasi_tindakan" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="tata_cara" class="form-label">Tata Cara</label>
                                <textarea name="tata_cara" id="tata_cara" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tujuan" class="form-label">Tujuan</label>
                                <textarea name="tujuan" id="tujuan" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="resiko" class="form-label">Resiko / Komplikasi</label>
                                <textarea name="resiko" id="resiko" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="prognosis" class="form-label">Prognosis</label>
                                <textarea name="prognosis" id="prognosis" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="alternatif" class="form-label">Alternatif</label>
                                <textarea name="alternatif" id="alternatif" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="lainnya" class="form-label">Lain - lain</label>
                                <textarea name="lainnya" id="lainnya" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Identitas Pasien/Keluarga</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keluarga_nama" class="form-label">Nama</label>
                                <input type="text" name="keluarga_nama" id="keluarga_nama" class="form-control"
                                    required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="keluarga_umur" class="form-label">Umur</label>
                                <input type="number" name="keluarga_umur" id="keluarga_umur" class="form-control"
                                    required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="keluarga_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="keluarga_jenis_kelamin" id="keluarga_jenis_kelamin" class="form-select"
                                    required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Laki-Laki</option>
                                    <option value="0">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keluarga_alamat" class="form-label">Alamat</label>
                                <textarea name="keluarga_alamat" id="keluarga_alamat" class="form-control" required></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <label for="keluarga_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                                <select name="keluarga_hubungan_pasien" id="keluarga_hubungan_pasien"
                                    class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="0">Diri Sendiri</option>
                                    <option value="1">Orang Tua</option>
                                    <option value="2">Anak</option>
                                    <option value="3">Saudara Kandung</option>
                                    <option value="4">Suami</option>
                                    <option value="5">Istri</option>
                                    <option value="6">Kakek</option>
                                    <option value="7">Nenek</option>
                                    <option value="8">Cucu</option>
                                    <option value="9">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Identitas Saksi 1</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saksi1_nama" class="form-label">Nama</label>
                                <input type="text" name="saksi1_nama" id="saksi1_nama" class="form-control"
                                    required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="saksi1_tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="saksi1_tgl_lahir" id="saksi1_tgl_lahir"
                                    class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="saksi1_alamat" class="form-label">Alamat</label>
                                <textarea name="saksi1_alamat" id="saksi1_alamat" class="form-control" required></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saksi1_nohp" class="form-label">No HP</label>
                                <input type="number" name="saksi1_nohp" id="saksi1_nohp" class="form-control"
                                    required>
                            </div>

                            <div class="form-group mt-3">
                                <label for="saksi1_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                                <select name="saksi1_hubungan_pasien" id="saksi1_hubungan_pasien" class="form-select"
                                    required>
                                    <option value="">--Pilih--</option>
                                    <option value="0">Diri Sendiri</option>
                                    <option value="1">Orang Tua</option>
                                    <option value="2">Anak</option>
                                    <option value="3">Saudara Kandung</option>
                                    <option value="4">Suami</option>
                                    <option value="5">Istri</option>
                                    <option value="6">Kakek</option>
                                    <option value="7">Nenek</option>
                                    <option value="8">Cucu</option>
                                    <option value="9">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Identitas Saksi 2</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saksi2_nama" class="form-label">Nama</label>
                                <input type="text" name="saksi2_nama" id="saksi2_nama" class="form-control">
                            </div>

                            <div class="form-group mt-3">
                                <label for="saksi2_tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="saksi2_tgl_lahir" id="saksi2_tgl_lahir"
                                    class="form-control">
                            </div>

                            <div class="form-group mt-3">
                                <label for="saksi2_alamat" class="form-label">Alamat</label>
                                <textarea name="saksi2_alamat" id="saksi2_alamat" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="saksi2_nohp" class="form-label">No HP</label>
                                <input type="number" name="saksi2_nohp" id="saksi2_nohp" class="form-control">
                            </div>

                            <div class="form-group mt-3">
                                <label for="saksi2_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                                <select name="saksi2_hubungan_pasien" id="saksi2_hubungan_pasien"
                                    class="form-select">
                                    <option value="">--Pilih--</option>
                                    <option value="0">Diri Sendiri</option>
                                    <option value="1">Orang Tua</option>
                                    <option value="2">Anak</option>
                                    <option value="3">Saudara Kandung</option>
                                    <option value="4">Suami</option>
                                    <option value="5">Istri</option>
                                    <option value="6">Kakek</option>
                                    <option value="7">Nenek</option>
                                    <option value="8">Cucu</option>
                                    <option value="9">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-4 fw-bold">Persetujuan/Penolakan</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_menerangkan_informasi" class="form-label">Petugas/Dokter telah
                                    menerangkan informasi</label>
                                <select name="status_menerangkan_informasi" id="status_menerangkan_informasi"
                                    class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Sudah</option>
                                    <option value="0">Belum</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_persetujuan_keluarga" class="form-label">Status Persetujuan
                                    Pasien/Keluarga</label>
                                <select name="status_persetujuan_keluarga" id="status_persetujuan_keluarga"
                                    class="form-select" required>
                                    <option value="">--Pilih--</option>
                                    <option value="1">Setuju</option>
                                    <option value="0">Menolak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jumlah dan Total di Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Tambah Resep -->
<div class="modal fade" id="showInformedConsentModal" tabindex="-1" aria-labelledby="showInformedConsentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="showInformedConsentModalLabel">Informed Consent</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jam" class="form-label">Jam</label>
                            <input type="time" name="jam" id="jam" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="border-bottom border-primary mt-3"></div>

                <div class="row mt-3">
                    <div class="col-12">
                        <p class="fs-4 fw-bold">Informasi Tindakan</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_pemberi_info" class="form-label">Nama Pemberi Informasi</label>
                            <input type="text" name="nama_pemberi_info" id="nama_pemberi_info"
                                class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_penerima_info" class="form-label">Nama Penerima Informasi</label>
                            <input type="text" name="nama_penerima_info" id="nama_penerima_info"
                                class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="border-bottom border-primary mt-3"></div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="diagnosis" class="form-label">Diagnosis (WD dan DD)</label>
                            <textarea name="diagnosis" id="diagnosis" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="dasar_diagnosis" class="form-label">Dasar Diagnosis</label>
                            <textarea name="dasar_diagnosis" id="dasar_diagnosis" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="tindakan_kedokteran" class="form-label">Tindakan Kedokteran</label>
                            <textarea name="tindakan_kedokteran" id="tindakan_kedokteran" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="indikasi_tindakan" class="form-label">Indikasi Tindakan</label>
                            <textarea name="indikasi_tindakan" id="indikasi_tindakan" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="tata_cara" class="form-label">Tata Cara</label>
                            <textarea name="tata_cara" id="tata_cara" class="form-control" disabled></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tujuan" class="form-label">Tujuan</label>
                            <textarea name="tujuan" id="tujuan" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="resiko" class="form-label">Resiko / Komplikasi</label>
                            <textarea name="resiko" id="resiko" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="prognosis" class="form-label">Prognosis</label>
                            <textarea name="prognosis" id="prognosis" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="alternatif" class="form-label">Alternatif</label>
                            <textarea name="alternatif" id="alternatif" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label for="lainnya" class="form-label">Lain - lain</label>
                            <textarea name="lainnya" id="lainnya" class="form-control" disabled></textarea>
                        </div>
                    </div>
                </div>

                <div class="border-bottom border-primary mt-3"></div>

                <div class="row mt-3">
                    <div class="col-12">
                        <p class="fs-4 fw-bold">Identitas Pasien/Keluarga</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keluarga_nama" class="form-label">Nama</label>
                            <input type="text" name="keluarga_nama" id="keluarga_nama" class="form-control"
                                disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="keluarga_umur" class="form-label">Umur</label>
                            <input type="number" name="keluarga_umur" id="keluarga_umur" class="form-control"
                                disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="keluarga_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="keluarga_jenis_kelamin" id="keluarga_jenis_kelamin" class="form-select"
                                disabled>
                                <option value="">--Pilih--</option>
                                <option value="1">Laki-Laki</option>
                                <option value="0">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="keluarga_alamat" class="form-label">Alamat</label>
                            <textarea name="keluarga_alamat" id="keluarga_alamat" class="form-control" disabled></textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label for="keluarga_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                            <select name="keluarga_hubungan_pasien" id="keluarga_hubungan_pasien" class="form-select"
                                disabled>
                                <option value="">--Pilih--</option>
                                <option value="0">Diri Sendiri</option>
                                <option value="1">Orang Tua</option>
                                <option value="2">Anak</option>
                                <option value="3">Saudara Kandung</option>
                                <option value="4">Suami</option>
                                <option value="5">Istri</option>
                                <option value="6">Kakek</option>
                                <option value="7">Nenek</option>
                                <option value="8">Cucu</option>
                                <option value="9">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border-bottom border-primary mt-3"></div>

                <div class="row mt-3">
                    <div class="col-12">
                        <p class="fs-4 fw-bold">Identitas Saksi 1</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="saksi1_nama" class="form-label">Nama</label>
                            <input type="text" name="saksi1_nama" id="saksi1_nama" class="form-control" disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="saksi1_tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="saksi1_tgl_lahir" id="saksi1_tgl_lahir" class="form-control"
                                disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="saksi1_alamat" class="form-label">Alamat</label>
                            <textarea name="saksi1_alamat" id="saksi1_alamat" class="form-control" disabled></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="saksi1_nohp" class="form-label">No HP</label>
                            <input type="number" name="saksi1_nohp" id="saksi1_nohp" class="form-control" disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="saksi1_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                            <select name="saksi1_hubungan_pasien" id="saksi1_hubungan_pasien" class="form-select"
                                disabled>
                                <option value="">--Pilih--</option>
                                <option value="0">Diri Sendiri</option>
                                <option value="1">Orang Tua</option>
                                <option value="2">Anak</option>
                                <option value="3">Saudara Kandung</option>
                                <option value="4">Suami</option>
                                <option value="5">Istri</option>
                                <option value="6">Kakek</option>
                                <option value="7">Nenek</option>
                                <option value="8">Cucu</option>
                                <option value="9">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border-bottom border-primary mt-3"></div>

                <div class="row mt-3">
                    <div class="col-12">
                        <p class="fs-4 fw-bold">Identitas Saksi 2</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="saksi2_nama" class="form-label">Nama</label>
                            <input type="text" name="saksi2_nama" id="saksi2_nama" class="form-control" disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="saksi2_tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="saksi2_tgl_lahir" id="saksi2_tgl_lahir"
                                class="form-control" disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="saksi2_alamat" class="form-label">Alamat</label>
                            <textarea name="saksi2_alamat" id="saksi2_alamat" class="form-control" disabled></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="saksi2_nohp" class="form-label">No HP</label>
                            <input type="number" name="saksi2_nohp" id="saksi2_nohp" class="form-control" disabled>
                        </div>

                        <div class="form-group mt-3">
                            <label for="saksi2_hubungan_pasien" class="form-label">Hubungan Pasien</label>
                            <select name="saksi2_hubungan_pasien" id="saksi2_hubungan_pasien" class="form-select" disabled>
                                <option value="">--Pilih--</option>
                                <option value="0">Diri Sendiri</option>
                                <option value="1">Orang Tua</option>
                                <option value="2">Anak</option>
                                <option value="3">Saudara Kandung</option>
                                <option value="4">Suami</option>
                                <option value="5">Istri</option>
                                <option value="6">Kakek</option>
                                <option value="7">Nenek</option>
                                <option value="8">Cucu</option>
                                <option value="9">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="border-bottom border-primary mt-3"></div>

                <div class="row mt-3">
                    <div class="col-12">
                        <p class="fs-4 fw-bold">Persetujuan/Penolakan</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_menerangkan_informasi" class="form-label">Petugas/Dokter telah
                                menerangkan informasi</label>
                            <select name="status_menerangkan_informasi" id="status_menerangkan_informasi"
                                class="form-select" disabled>
                                <option value="">--Pilih--</option>
                                <option value="1">Sudah</option>
                                <option value="0">Belum</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status_persetujuan_keluarga" class="form-label">Status Persetujuan
                                Pasien/Keluarga</label>
                            <select name="status_persetujuan_keluarga" id="status_persetujuan_keluarga"
                                class="form-select" disabled>
                                <option value="">--Pilih--</option>
                                <option value="1">Setuju</option>
                                <option value="0">Menolak</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah dan Total di Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('.ttd-canvas').css('background-color', '#bdbdbd');

        // canvas PJ
        let canvasPJ = $("#canvasPJ")[0];
        let resetCanvasPJ = $("#resetCanvasPJ")[0];

        // Call signature with the root element and the options object, saving its reference in a variable
        let componentPJ = Signature(canvasPJ, {
            width: 500,
            height: 100,
            instructions: "Penanggung Jawab Pasien"
        });

        $(resetCanvasPJ).click(() => {
            componentPJ.value = [];
        });

        $(canvasPJ).mouseup(function(e) {
            setTimeout(() => {

                // Dapatkan data tanda tangan
                const dataURLpj = componentPJ.getImage().split(',')[1];

                // Konversi ke file
                const blobBinaryPj = atob(dataURLpj);
                const arrayPj = [];

                for (let i = 0; i < blobBinaryPj.length; i++) {
                    arrayPj.push(blobBinaryPj.charCodeAt(i));
                }

                const filePj = new File([new Uint8Array(arrayPj)], 'signature-pj.png', {
                    type: 'image/png'
                });

                // Buat DataTransfer object
                const dataTransferPj = new DataTransfer();
                dataTransferPj.items.add(filePj);

                // Masukkan ke input file
                $('#ttd_pj').prop('files', dataTransferPj.files);

            }, 1000);
        });

        // canvas Saksi 1
        let canvasSaksi1 = $("#canvasSaksi1")[0];
        let resetCanvasSaksi1 = $("#resetCanvasSaksi1")[0];

        // Call signature with the root element and the options object, saving its reference in a variable
        let componentSaksi1 = Signature(canvasSaksi1, {
            width: 500,
            height: 100,
            instructions: "Saksi 1"
        });

        $(resetCanvasSaksi1).click(() => {
            componentSaksi1.value = [];
        });


        $(canvasSaksi1).mouseup(function(e) {
            setTimeout(() => {

                // Dapatkan data tanda tangan
                const dataURLSaksi1 = componentSaksi1.getImage().split(',')[1];

                // Konversi ke file
                const blobBinarySaksi1 = atob(dataURLSaksi1);
                const arraySaksi1 = [];

                for (let i = 0; i < blobBinarySaksi1.length; i++) {
                    arraySaksi1.push(blobBinarySaksi1.charCodeAt(i));
                }

                const fileSaksi1 = new File([new Uint8Array(arraySaksi1)], 'signature-saksi1.png', {
                    type: 'image/png'
                });

                // Buat DataTransfer object
                const dataTransferSaksi1 = new DataTransfer();
                dataTransferSaksi1.items.add(fileSaksi1);

                // Masukkan ke input file
                $('#ttd_saksi_1').prop('files', dataTransferSaksi1.files);

            }, 1000);
        });


        // canvas Saksi 2
        let canvasSaksi2 = $("#canvasSaksi2")[0];
        let resetCanvasSaksi2 = $("#resetCanvasSaksi2")[0];

        // Call signature with the root element and the options object, saving its reference in a variable
        let componentSaksi2 = Signature(canvasSaksi2, {
            width: 500,
            height: 100,
            instructions: "Saksi 2"
        });

        $(resetCanvasSaksi2).click(() => {
            componentSaksi2.value = [];
        });

        $(canvasSaksi2).mouseup(function(e) {
            setTimeout(() => {

                // Dapatkan data tanda tangan
                const dataURLSaksi2 = componentSaksi2.getImage().split(',')[1];

                // Konversi ke file
                const blobBinarySaksi2 = atob(dataURLSaksi2);
                const arraySaksi2 = [];

                for (let i = 0; i < blobBinarySaksi2.length; i++) {
                    arraySaksi2.push(blobBinarySaksi2.charCodeAt(i));
                }

                const fileSaksi2 = new File([new Uint8Array(arraySaksi2)], 'signature-saksi2.png', {
                    type: 'image/png'
                });

                // Buat DataTransfer object
                const dataTransferSaksi2 = new DataTransfer();
                dataTransferSaksi2.items.add(fileSaksi2);

                // Masukkan ke input file
                $('#ttd_saksi_2').prop('files', dataTransferSaksi2.files);

            }, 1000);
        });
    </script>
@endpush
