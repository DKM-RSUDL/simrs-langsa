@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="edukasiForm" method="POST"
                action="{{ route('permintaan-darah.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen text-center font-weight-bold mb-4">PERMINTAAN DARAH/PRODUK DARAH
                                </h4>
                                <p>Isikan data permintaan darah pasien dan keluarga terintegrasi</p>
                            </div>

                            <!-- Petunjuk Permintaan -->
                            <div class="section-separator mb-3">
                                <div class="card-header font-weight-bold">PETUNJUK PERMINTAAN:</div>
                                <div class="card-body">
                                    <ol class="pl-3 mb-0">
                                        <li>Satu Formulir untuk Satu kali permintaan</li>
                                        <li>Setiap permintaan Darah harus disertai sampel Pasien dalam tabung EDTA 3 ml</li>
                                        <li>Nama dan Identitas Pasien pada Formulir dan Contoh darah harus SAMA</li>
                                    </ol>
                                </div>
                                <div class="card-header font-weight-bold">PETUNJUK TRANSFUSI:</div>
                                <div class="card-body">
                                    <p class="mb-0">Pastikan Identitas Pasien dan Cocokkan etiket pada Kantong Darah, Label
                                        dan Formulir, Segera kembalikan bila tidak Cocok Ke Bank Darah Rumah Sakit (BDRS)
                                        setempat atau UTD PMI</p>
                                </div>
                            </div>

                            <!-- Urgency Section -->
                            <div class="section-separator mb-3">
                                <div class="card-header bg-white">
                                    <p class="font-weight-bold mb-0">Harap Diisi LENGKAP oleh Pihak Rumah Sakit: Untuk
                                        keamanan Transfusi</p>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="form-row ml-auto justify-content-end">
                                        <div class="form-check form-check-inline mr-4">
                                            <input class="form-check-input" type="radio" name="urgensi" id="urgensi_biasa"
                                                value="Biasa" checked>
                                            <label class="form-check-label" for="urgensi_biasa">Biasa</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="urgensi" id="urgensi_cito"
                                                value="Cito">
                                            <label class="form-check-label" for="urgensi_cito">Cito (Harus disertai
                                                memo)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Permintaan -->
                            <div class="section-separator mb-3">
                                <div class="card-body">
                                    <!-- Hospital Information -->
                                    <div class="form-group">
                                        <label style="min-width: 200px;">RS</label>
                                        <input type="text" class="form-control" name="rs" placeholder=""
                                            style="min-width: 200px;" value="Rumah Sakit Langsa">

                                        <label class="mx-3">Bagian</label>
                                        <input type="text" class="form-control" name="bagian" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Alamat RS</label>
                                        <input type="text" class="form-control" name="alamat_rs" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Dokter yang meminta</label>
                                        <input type="text" class="form-control" name="dokter_peminta" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tgl Pengiriman</label>
                                        <input type="date" class="form-control" name="tgl_pengiriman"
                                            value="{{ date('Y-m-d') }}">

                                        <label class="mx-3">Diperlukan</label>
                                        <input type="text" class="form-control" name="diperlukan" placeholder="diperlukan">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Diagnosa Kimia</label>
                                        <input type="text" class="form-control" name="diagnosa_kimia" placeholder="">

                                        <label class="mx-3">Golda</label>
                                        <select class="form-control" name="golda">
                                            <option value="">-- Pilih --</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Alasan Transfusi</label>
                                        <input type="text" class="form-control" name="alasan_transfusi" placeholder="">

                                        <label class="mx-3">HB</label>
                                        <input type="text" class="form-control" name="hb" placeholder="">

                                        <span class="mx-1">g</span>

                                    </div>
                                </div>
                            </div>

                            <!-- Patient Information -->
                            <div class="section-separator mb-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nama OS</label>
                                        <input type="text" class="form-control" name="nama_os" placeholder="">

                                        <div class="form-check mx-2">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                id="radioDefault1">
                                            <label class="form-check-label" for="radioDefault1">
                                                LK
                                            </label>
                                        </div>
                                        <div class="form-check mx-2">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                id="radioDefault2" checked>
                                            <label class="form-check-label" for="radioDefault2">
                                                PR
                                            </label>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nama Suami/Istri</label>
                                        <input type="text" class="form-control" name="nama_suami_istri" placeholder="">

                                        <label class="mx-2">Register</label>
                                        <input type="text" class="form-control" name="register" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tgl Lahir/Usia</label>
                                        <input type="date" class="form-control" name="tgl_lahir_usia" placeholder="">

                                        <label class="mx-2">Usia</label>
                                        <input type="text" class="form-control" name="usia" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Alamat</label>
                                        <textarea class="form-control" name="alamat" rows="2"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">No. HP</label>
                                        <input type="text" class="form-control" name="no_hp" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <!-- Medical History -->
                            <div class="section-separator mb-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Transfusi Sebelumnya</label>
                                        <input type="text" class="form-control" name="transfusi_sebelumnya" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gejala Reaksi Transfusi</label>
                                        <input type="text" class="form-control" name="gejala_reaksi_transfusi"
                                            placeholder="">
                                    </div>

                                    <p class="fw-bold">Apakah pernah diperiksa Serologi golongan darah (* Contoh 5 test)</p>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Dimana</label>
                                        <input type="text" class="form-control" name="serology_dimana" placeholder="">

                                        <label class="mx-2">Kapan</label>
                                        <input type="date" class="form-control" name="serology_kapan">

                                        <label class="mx-2">Hasil</label>
                                        <input type="text" class="form-control" name="serology_hasil" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Khusus Pasien wanita: Pernah hamil?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pernah_hamil"
                                                id="radioDefault1Hamil">
                                            <label class="form-check-label" for="radioDefault1Hamil">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check mx-2">
                                            <input class="form-check-input" type="radio" name="pernah_hamil"
                                                id="radioDefault2Hamil" checked>
                                            <label class="form-check-label" for="radioDefault2Hamil">
                                                Tidak
                                            </label>
                                        </div>

                                        <label class="mx-3">jln.</label>
                                        <input type="text" class="form-control" name="jln" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Pernah Abortus atau Bayi kuning karena hemolisis
                                            (HDN)?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pernah_abortus_hdn"
                                                id="radioDefault1Abortur">
                                            <label class="form-check-label" for="radioDefault1Abortur">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check mx-2">
                                            <input class="form-check-input" type="radio" name="pernah_abortus_hdn"
                                                id="radioDefault2Abortus" checked>
                                            <label class="form-check-label" for="radioDefault2Abortus">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="section-separator mb-3">
                                <div class="card-body">
                                    <h5 class="font-weight-bold mb-3">DARAH LENGKAP (WHOLEBLOOD)</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">WB Segar / Biasa</label>
                                        <input type="number" class="form-control" name="wb_segar_biasa" min="0">

                                        <span class="form-control-plaintext mx-2">ml</span>
                                    </div>

                                    <h5 class="font-weight-bold mt-4 mb-3">DARAH MERAHPEKAT (PACKED RED CELL)</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">PRC Biasa</label>
                                        <input type="number" class="form-control" name="prc_biasa" min="0">

                                        <span class="form-control-plaintext mx-2">ml</span>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">PRC Pediatric Leukodepleted**</label>
                                        <input type="number" class="form-control" name="prc_pediatric_leukodepleted"
                                            min="0">

                                        <span class="form-control-plaintext mx-2">ml</span>

                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">PRC Leukodepleted (dengan
                                            filter)**</label>
                                        <input class="form-control" type="number" name="prc_leukodepleted_filter" min="0">
                                        <span class="form-control-plaintext mx-2">ml</span>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Washed Erythrocyte (WE)</label>
                                        <input type="number" class="form-control" name="washed_erythrocyte" min="0">
                                        <span class="form-control-plaintext mx-2">ml</span>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lain-lain</label>
                                        <input type="text" class="form-control" name="lain_lain" placeholder="">
                                    </div>

                                    <div class="text-muted small mt-3">
                                        <p class="mb-1">*Coret yang tidak perlu</p>
                                        <p class="mb-0">**Leukodepleted dgn Filter Leukosit</p>
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator mb-3">
                                <div class="card-body">
                                    <h5 class="font-weight-bold mb-3">THROMBOCYTE CONCENTRATE (TC)</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">TC Biasa</label>
                                        <input type="number" class="form-control" name="tc_biasa" min="0">

                                        <span class="form-control-plaintext mx-2">unit</span>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">TC Apheresis*</label>
                                        <input type="number" class="form-control" name="tc_apheresis" min="0">
                                        <span class="form-control-plaintext mx-2">unit</span>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">TC Pooled (Leukodepleted)**</label>
                                        <input type="number" class="form-control" name="tc_pooled_leukodepleted" min="0">
                                        <span class="form-control-plaintext mx-2">unit</span>
                                    </div>

                                    <h5 class="font-weight-bold mt-4 mb-3">PLASMA</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Plasma Cair (liquid Plasma)</label>
                                        <input type="number" class="form-control" name="plasma_cair" min="0">
                                        <span class="form-control-plaintext mx-2">ml</span>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Plasma Segar Beku (FFP)</label>
                                        <input type="number" class="form-control" name="plasma_segar_beku" min="0">
                                        <span class="form-control-plaintext mx-2">ml</span>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Cryoprecipitate AHF</label>
                                        <input type="number" class="form-control" name="cryoprecipitate_ahf" min="0">
                                        <span class="form-control-plaintext mx-2">unit</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Declaration -->
                            <div class="section-separator mb-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <label class="custom-control-label" for="declarationCheck">
                                                Saya menyatakan Darah yang saya ambil sesuai dengan nama Pasien tertulis di
                                                FORM ini dan di TABEL dibedside
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal Pengambilan Sampel</label>
                                        <input type="date" class="form-control" name="tgl_pengambilan_sampel"
                                            value="{{ date('Y-m-d') }}">

                                        <label class="mx-2">Jam</label>
                                        <input type="time" class="form-control" name="jam_pengambilan_sampel">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nama Petugas</label>
                                        <input type="text" class="form-control" name="nama_petugas" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanda Tangan</label>
                                        <input type="text" class="form-control" name="tanda_tangan" placeholder="">
                                    </div>

                                    <p class="fw-bold">Mengetahui:</p>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Dokter Unit Transfusi Darah</label>
                                        <input type="text" class="form-control" name="dokter_unit" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nama dan Ttd Dokter yang meminta darah dan Cap
                                            rumah sakit</label>
                                        <input type="text" class="form-control" name="nama_dokter" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <!-- UTD Section (Readonly) -->
                            <div class="mb-3 section-separator">
                                <div class="text-dark">
                                    <h5 class="mb-0">PENERIMAAN SAMPEL (Diisi oleh Petugas BDRS/UTD)</h5>
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Nama OS</label>
                                    <input type="text" class="form-control" name="nama_os" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">diterima Oleh</label>
                                    <input type="text" class="form-control" name="serology_dditerima_oleh" placeholder="">

                                    <label class="mx-2">tgl</label>
                                    <input type="date" class="form-control" name="rgl">

                                    <label class="mx-2">jam</label>
                                    <input type="time" class="form-control" name="jam" placeholder="">
                                </div>

                                <div class="text-dark">
                                    <h5 class="mb-0">PEMERIKSAAN DAN PEMBERIAN DARAH (Diisi oleh Petugas BDRS)</h5>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">diperiksa Oleh</label>
                                    <input type="text" class="form-control" name="serology_dditerima_oleh" placeholder="">

                                    <label class="mx-2">tgl</label>
                                    <input type="date" class="form-control" name="rgl">

                                    <label class="mx-2">jam</label>
                                    <input type="time" class="form-control" name="jam" placeholder="">
                                </div>

                                <div class="text-dark">
                                    <h6 class="mb-0">Dengan hasil pemeriksaan COCOK/TIDAK COCOK/TANPA CROSS/EMERGENCY*
                                        dengan perician</h6>
                                </div>

                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-4 text-center">
                                            <div class="card-body p-2">
                                                <h6>A B O</h6>
                                                <input type="text" class="form-control" name="abo"
                                                    placeholder="Masukkan golongan darah">
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="card-body p-2">
                                                <h6>RHESUS</h6>
                                                <input type="text" class="form-control" name="rhesus"
                                                    placeholder="Masukkan rhesus">
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <div class="card-body p-2">
                                                <h6>Pemeriksa</h6>
                                                <input type="text" class="form-control" name="pemeriksa"
                                                    placeholder="Masukkan nama pemeriksa">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button id="btn-add-row" class="btn btn-primary">Tambah Baris</button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="data-table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>No. Kantong</th>
                                                        <th>Jenis Darah</th>
                                                        <th>Gol. Darah</th>
                                                        <th>Tanggal Pengambilan</th>
                                                        <th>Vol(ML) CC Kantong</th>
                                                        <th>Nama Petugas</th>
                                                        <th>Nama yang Mengambil</th>
                                                        <th>Tanda Tangan</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-body">
                                                    @for ($i = 1; $i <= 2; $i++)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td><input type="text" name="no_kantong[]"
                                                                    class="form-control form-control-sm"></td>
                                                            <td>
                                                                <select name="jenis_darah[]"
                                                                    class="form-control form-control-sm">
                                                                    <option value="">Pilih</option>
                                                                    <option value="WB">Whole Blood</option>
                                                                    <option value="PRC">Packed Red Cell</option>
                                                                    <option value="TC">Thrombocyte Concentrate</option>
                                                                    <option value="FFP">Fresh Frozen Plasma</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="golongan_darah[]"
                                                                    class="form-control form-control-sm">
                                                                    <option value="">Pilih</option>
                                                                    <option value="A">A</option>
                                                                    <option value="B">B</option>
                                                                    <option value="AB">AB</option>
                                                                    <option value="O">O</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="date" name="tanggal_pengambilan[]"
                                                                    class="form-control form-control-sm"></td>
                                                            <td><input type="number" name="volume[]"
                                                                    class="form-control form-control-sm"></td>
                                                            <td><input type="text" name="nama_petugas[]"
                                                                    class="form-control form-control-sm"></td>
                                                            <td><input type="text" name="nama_pengambil[]"
                                                                    class="form-control form-control-sm"></td>
                                                            <td>
                                                                <div class="signature-container">
                                                                    <canvas class="signature-pad" width="150"
                                                                        height="60"></canvas>
                                                                    <input type="hidden" name="tanda_tangan[]"
                                                                        class="signature-data">
                                                                    <div class="mt-1">
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-secondary btn-clear-signature">Hapus
                                                                            TTD</button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td><button type="button"
                                                                    class="btn btn-danger btn-sm btn-delete-row">Hapus</button>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="alert alert-secondary mt-3">
                                        <p class="mb-1"><b>PEMBERITAHUAN:</b></p>
                                        <ol class="pl-3 mb-0">
                                            <li>Darah dari Donor tidak diperjualbelikan namun memerlukan biaya pengolahan
                                                yang disebut Service Cost atau BPPD (Biaya Pengganti Pengolahan Darah)</li>
                                            <li>Biaya Pengganti Pengolahan Darah (BPPD) berlaku bagi setiap pemakai Darah
                                                tanpa terkecuali</li>
                                            <li>Pembayaran Biaya Pengganti Pengolahan Darah (BPPD) dilakukan di Rumah Sakit
                                                (Bila ada Kerjasama dengan UTD)</li>
                                            <li>Darah yang sudah di periksa tetap dikenakan Biaya</li>
                                        </ol>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <small class="text-muted">*Lembar Putih: Bag. Adm. dan Keuangan</small>
                                                </div>
                                                <div>
                                                    <small class="text-muted">*Lembar Merah: RS (Medical Record)</small>
                                                </div>
                                                <div>
                                                    <small class="text-muted">*Lembar Kuning: UTD</small>
                                                </div>
                                                <div>
                                                    <small class="text-muted">*Lembar Biru: Untuk BDRS</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">
                                    <i class="ti-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .header-asesmen {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }

        .card {
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control-plaintext {
            padding-top: calc(0.375rem + 1px);
        }

        .custom-control-label {
            cursor: pointer;
        }

        .table th {
            font-size: 0.9rem;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Print functionality
            const printButton = document.getElementById('print_form');
            if (printButton) {
                printButton.addEventListener('click', function () {
                    window.print();
                });
            }

            // Reset confirmation
            const resetButton = document.getElementById('reset_form');
            if (resetButton) {
                resetButton.addEventListener('click', function (e) {
                    if (!confirm('Apakah Anda yakin ingin mereset form ini?')) {
                        e.preventDefault();
                    }
                });
            }

            // Form submission confirmation
            const form = document.getElementById('edukasiForm');

        });

        // add data dalma tabel
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi counter untuk nomor baris
            let rowCounter = {{ count(old('no_kantong', [])) > 0 ? count(old('no_kantong', [])) : 2 }};

            // Inisialisasi SignaturePad untuk baris awal
            initializeSignaturePads();

            // Fungsi untuk menambah baris baru
            document.getElementById('btn-add-row').addEventListener('click', function (e) {
                // Mencegah reload halaman
                e.preventDefault();

                rowCounter++;

                const tbody = document.getElementById('table-body');
                const newRow = document.createElement('tr');

                newRow.innerHTML = `
                <td>${rowCounter}</td>
                <td><input type="text" name="no_kantong[]" class="form-control form-control-sm"></td>
                <td>
                    <select name="jenis_darah[]" class="form-control form-control-sm">
                        <option value="">Pilih</option>
                        <option value="WB">Whole Blood</option>
                        <option value="PRC">Packed Red Cell</option>
                        <option value="TC">Thrombocyte Concentrate</option>
                        <option value="FFP">Fresh Frozen Plasma</option>
                    </select>
                </td>
                <td>
                    <select name="golongan_darah[]" class="form-control form-control-sm">
                        <option value="">Pilih</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </td>
                <td><input type="date" name="tanggal_pengambilan[]" class="form-control form-control-sm"></td>
                <td><input type="number" name="volume[]" class="form-control form-control-sm"></td>
                <td><input type="text" name="nama_petugas[]" class="form-control form-control-sm"></td>
                <td><input type="text" name="nama_pengambil[]" class="form-control form-control-sm"></td>
                <td>
                    <div class="signature-container">
                        <canvas class="signature-pad" width="150" height="60"></canvas>
                        <input type="hidden" name="tanda_tangan[]" class="signature-data">
                        <div class="mt-1">
                            <button type="button" class="btn btn-sm btn-secondary btn-clear-signature">Hapus TTD</button>
                        </div>
                    </div>
                </td>
                <td><button type="button" class="btn btn-danger btn-sm btn-delete-row">Hapus</button></td>
            `;

                tbody.appendChild(newRow);

                // Tambahkan event listener untuk tombol hapus di baris baru
                const deleteButton = newRow.querySelector('.btn-delete-row');
                deleteButton.addEventListener('click', function () {
                    deleteRow(this);
                });

                // Inisialisasi SignaturePad untuk baris baru
                initializeSignaturePad(newRow.querySelector('.signature-pad'));
            });

            // Fungsi untuk menghapus baris
            function deleteRow(button) {
                const row = button.closest('tr');
                row.remove();

                // Perbarui nomor urut setelah menghapus baris
                updateRowNumbers();
            }

            // Fungsi untuk memperbarui nomor urut
            function updateRowNumbers() {
                let i = 1;
                document.querySelectorAll('#table-body tr').forEach(row => {
                    row.cells[0].textContent = i++;
                });
                rowCounter = i - 1;
            }

            // Pasang event listener untuk tombol hapus pada baris awal
            document.querySelectorAll('.btn-delete-row').forEach(button => {
                button.addEventListener('click', function () {
                    deleteRow(this);
                });
            });

            // Inisialisasi semua SignaturePad
            function initializeSignaturePads() {
                document.querySelectorAll('.signature-pad').forEach(canvas => {
                    initializeSignaturePad(canvas);
                });
            }

            // Inisialisasi SignaturePad untuk satu canvas
            function initializeSignaturePad(canvas) {
                const signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgb(255, 255, 255)',
                    penColor: 'rgb(0, 0, 0)'
                });

                // Simpan data tanda tangan ke hidden input saat tanda tangan berubah
                signaturePad.onEnd = function () {
                    const dataURL = signaturePad.toDataURL();
                    canvas.closest('.signature-container').querySelector('.signature-data').value = dataURL;
                };

                // Tambahkan event listener untuk tombol hapus tanda tangan
                const clearButton = canvas.closest('.signature-container').querySelector('.btn-clear-signature');
                clearButton.addEventListener('click', function () {
                    signaturePad.clear();
                    canvas.closest('.signature-container').querySelector('.signature-data').value = '';
                });
            }

            // Form submit handler untuk mengumpulkan data
            document.getElementById('form-data').addEventListener('submit', function (e) {
                // Kumpulkan data dari semua baris
                const rows = document.querySelectorAll('#table-body tr');
                const data = [];

                rows.forEach((row, index) => {
                    const inputs = row.querySelectorAll('input:not(.signature-data), select');
                    const signatureData = row.querySelector('.signature-data').value;

                    const rowData = {
                        no: index + 1,
                        no_kantong: inputs[0].value,
                        jenis_darah: inputs[1].value,
                        golongan_darah: inputs[2].value,
                        tanggal_pengambilan: inputs[3].value,
                        volume: inputs[4].value,
                        nama_petugas: inputs[5].value,
                        nama_pengambil: inputs[6].value,
                        tanda_tangan: signatureData
                    };

                    data.push(rowData);
                });

                // Simpan data ke input hidden sebagai JSON
                document.getElementById('json-data').value = JSON.stringify(data);
            });
        });
    </script>
@endpush
