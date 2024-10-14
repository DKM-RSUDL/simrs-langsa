<!-- Modal -->
<div class="modal fade" id="detailPasienModal" tabindex="-1" aria-labelledby="detailPasienModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Side Column -->
                        <div class="col-md-3 border-right">
                            <div class="position-relative patient-card">
                                <div class="patient-photo-asesmen">
                                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="Patient Photo">
                                </div>

                                <div class="patient-info">
                                    <h6>{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</h6>
                                    <p class="mb-0">
                                        {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}
                                    </p>
                                    <small> {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn </small>

                                    <div class="patient-meta mt-2">
                                        <p class="mb-0"><i
                                                class="bi bi-file-earmark-medical"></i>RM:{{ $dataMedis->pasien->kd_pasien }}
                                        </p>
                                        <p class="mb-0"><i
                                                class="bi bi-calendar3"></i>{{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y') }}
                                        </p>
                                        <p><i class="bi bi-hospital"></i>{{ $dataMedis->unit->bagian->bagian }}
                                            ({{ $dataMedis->unit->nama_unit }})</p>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div class="card-header">
                                        <h4 class="text-primary">Informasi Pasien:</h4>
                                    </div>
                                    <div class="card-body">
                                        <p style="margin-bottom: 5px;"><strong>Alergi</strong></p>
                                        <ul style="margin-bottom: 5px; padding-left: 15px;">
                                            <li>Ikan Tongkol</li>
                                            <li>Asap</li>
                                        </ul>
                                        <p style="margin-bottom: 5px;"><strong>Golongan Darah</strong></p>
                                        <p style="margin-bottom: 5px;">A+</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Main Content Area -->
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="text-primary">Asesmen Awal Gawat Darurat Medis</h4>
                                    <p>Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan</p>
                                </div>
                                <div class="col-md-12">
                                    <div class="card w-100 h-100">
                                        <div class="card-body">

                                            <div class="form-line">
                                                <h6>Triage Pasien</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal/Jam</th>
                                                                <th>Dokter</th>
                                                                <th>Triage</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>23 Apr 2024 &nbsp; 13:30 Wib</td>
                                                                <td>dr. Nuansa Chalid</td>
                                                                <td>
                                                                    <div>
                                                                    </div>
                                                                </td>
                                                                <td><a href="#">detail</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Tindakan Resusitasi</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Air Way</th>
                                                                <th>Breathing</th>
                                                                <th>Circulation</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="hyperekstesi">
                                                                        <label class="form-check-label"
                                                                            for="hyperekstesi">Hyperekstesi</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="bersihkanJalanNafas">
                                                                        <label class="form-check-label"
                                                                            for="bersihkanJalanNafas">Bersihkan jalan
                                                                            nafas</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="intubasi">
                                                                        <label class="form-check-label"
                                                                            for="intubasi">Intubasi</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="bagAndMask">
                                                                        <label class="form-check-label"
                                                                            for="bagAndMask">Bag
                                                                            and Mask</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="bagAndTube">
                                                                        <label class="form-check-label"
                                                                            for="bagAndTube">Bag
                                                                            and Tube</label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="kompresiJantung">
                                                                        <label class="form-check-label"
                                                                            for="kompresiJantung">Kompresi
                                                                            jantung</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="balutTekan">
                                                                        <label class="form-check-label"
                                                                            for="balutTekan">Balut tekan</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="operasi">
                                                                        <label class="form-check-label"
                                                                            for="operasi">Operasi</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Keluhan/Anamnesis</h6>
                                                <textarea class="form-control mb-2" rows="3"
                                                    placeholder="Isikan keluhan dan anamnesis pasien, jika terjadi cidera jelaskan mekanisme cideranya"></textarea>
                                            </div>

                                            <div class="form-line">
                                                <h6>Riwayat Penyakit Pasien</h6>
                                                <textarea class="form-control mb-2" rows="3" placeholder="Isikan riwayat penyakit pasien"></textarea>
                                            </div>

                                            <div class="form-line">
                                                <h6>Riwayat Pengobatan</h6>
                                                <textarea class="form-control mb-2" rows="3" placeholder="Isikan riwayat pengobatan pasien"></textarea>
                                            </div>

                                            <div class="form-line">
                                                <h6>Riwayat Alergi</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Alergen</th>
                                                                <th>Reaksi</th>
                                                                <th>Serve</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Vital Sign</h6>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <label>TD (Sistole)</label>
                                                        <input type="number" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>TD (Diastole)</label>
                                                        <input type="number" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Nadi (x/mnt)</label>
                                                        <input type="number" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Resp (x/mnt)</label>
                                                        <input type="number" class="form-control">
                                                    </div>
                                                    <div class="col">
                                                        <label>Suhu (°C)</label>
                                                        <input type="number" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-2">
                                                        <label>GCS</label>
                                                        <select class="form-select">
                                                            <option selected disabled>Pilih</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label>AVPU</label>
                                                        <select class="form-select">
                                                            <option selected disabled>Pilih</option>
                                                            <option>Sadar Baik/Alert : 0</option>
                                                            <option>Berespon dengan kata-kata/Voice: 1</option>
                                                            <option>Hanya berespon jika dirangsang nyeri/pain: 2
                                                            </option>
                                                            <option>Pasien tidak sadar/unresponsive: 3</option>
                                                            <option>Gelisah atau bingung: 4</option>
                                                            <option>Acute Confusional States: 5</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label>SpO2 (tanpa O2)</label>
                                                        <input type="number" class="form-control">
                                                    </div>
                                                    <div class="col-3">
                                                        <label>SpO2 (dengan O2)</label>
                                                        <input type="number" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Skala Nyeri Visual Analog</h6>
                                                <p class="text-muted">*Pilih angka pada skala nyeri yang sesuai</p>
                                                <div class="row align-items-center mb-3">
                                                    <div class="col-md-6">
                                                        <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                                            alt="Descriptive Alt Text"
                                                            style="width: 100%; height: auto;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="mb-3">Karakteristik Nyeri</h6>
                                                        <div class="mb-2">
                                                            <label>Lokasi Nyeri</label>
                                                            <input type="text" id="lokasiNyeri"
                                                                class="form-control" placeholder="Lokasi Nyeri">
                                                        </div>
                                                        <div class="mb-2">
                                                            <label>Durasi</label>
                                                            <input type="text" id="durasiNyeri"
                                                                class="form-control" placeholder="Durasi Nyeri">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label for="manjalar">Manjalar</label>
                                                    <select id="manjalar" class="form-select">
                                                        <option selected disabled>Pilih</option>
                                                        <option>Ya</option>
                                                        <option>Tidak</option>
                                                    </select>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="frekuensi">Frekuensi</label>
                                                    <select id="frekuensi" class="form-select">
                                                        <option selected disabled>Pilih</option>
                                                        <option>Jarang</option>
                                                        <option>Hilang Timbul</option>
                                                        <option>Terus Menerus</option>
                                                        <option>Tidak Terbuka</option>
                                                    </select>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="kualitas">Kualitas</label>
                                                    <select id="kualitas" class="form-select">
                                                        <option selected disabled>Pilih</option>
                                                        <option>Nyeri Tumpul</option>
                                                        <option>Nyeri Tajam</option>
                                                        <option>Panas Terbakar</option>
                                                    </select>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="faktor-pemberat">Faktor Pemberat</label>
                                                    <select id="faktor-pemberat" class="form-select">
                                                        <option selected disabled>Pilih</option>
                                                        <option>Gerakan</option>
                                                        <option>Jarang</option>
                                                        <option>Hilang Timbul</option>
                                                    </select>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="faktor-peringanan">Faktor Peringanan</label>
                                                    <select id="faktor-peringanan" class="form-select">
                                                        <option selected disabled>Pilih</option>
                                                        <option>Pilih 1</option>
                                                        <option>Pilih 2</option>
                                                        <option>Pilih 3</option>
                                                    </select>
                                                </div>
                                                <div class="col mt-3">
                                                    <label for="efek-nyeri">Efek Nyeri</label>
                                                    <select id="efek-nyeri" class="form-select">
                                                        <option selected disabled>Pilih</option>
                                                        <option>Pilih 1</option>
                                                        <option>Pilih 2</option>
                                                        <option>Pilih 3</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <div class="pemeriksaan-fisik">
                                                    <h6>Pemeriksaan Fisik</h6>
                                                    <p class="text-small">Centang normal jika fisik yang dinilai
                                                        normal,
                                                        pilih tanda tambah
                                                        untuk menambah keterangan fisik yang ditemukan tidak normal.
                                                        Jika
                                                        tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1">Kepala</div>
                                                                    <div class="form-check me-2">
                                                                        <input type="checkbox"
                                                                            class="form-check-input"
                                                                            id="kepala-normal">
                                                                        <label class="form-check-label"
                                                                            for="kepala-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        data-target="kepala-keterangan">+</button>
                                                                </div>
                                                                <div class="keterangan mt-2" id="kepala-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Keterangan">
                                                                </div>
                                                            </div>
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1">Mata</div>
                                                                    <div class="form-check me-2">
                                                                        <input type="checkbox"
                                                                            class="form-check-input" id="mata-normal">
                                                                        <label class="form-check-label"
                                                                            for="mata-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        data-target="mata-keterangan">+</button>
                                                                </div>
                                                                <div class="keterangan mt-2" id="mata-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Keterangan">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1">Hidung</div>
                                                                    <div class="form-check me-2">
                                                                        <input type="checkbox"
                                                                            class="form-check-input"
                                                                            id="hidung-normal">
                                                                        <label class="form-check-label"
                                                                            for="hidung-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        data-target="hidung-keterangan">+</button>
                                                                </div>
                                                                <div class="keterangan mt-2" id="hidung-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Keterangan">
                                                                </div>
                                                            </div>
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1">Mulut</div>
                                                                    <div class="form-check me-2">
                                                                        <input type="checkbox"
                                                                            class="form-check-input"
                                                                            id="mulut-normal">
                                                                        <label class="form-check-label"
                                                                            for="mulut-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        data-target="mulut-keterangan">+</button>
                                                                </div>
                                                                <div class="keterangan mt-2" id="mulut-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Keterangan">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Pemeriksaan Penunjang Klinis</h6>
                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="{{ asset('assets/img/icons/test_tube.png') }}">
                                                    <h6 class="mb-0 me-3">Laboratorium</h6>
                                                    <button class="btn btn-sm">
                                                        <i class="bi bi-plus-square"></i> Tambah
                                                    </button>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal dan Jam</th>
                                                                <th>Nama Pemeriksaan</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="d-flex align-items-center mb-3">
                                                    <img src="{{ asset('assets/img/icons/microbeam_radiation_therapy.png') }}">
                                                    <h6 class="mb-0 me-3">Radiologi</h6>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal dan Jam</th>
                                                                <th>Nama Pemeriksaan</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Diagnosis</h6>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>  
                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">E-Resep</h6>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal dan Jam</th>
                                                                <th>Nama Obat</th>
                                                                <th>Dosis</th>
                                                                <th>Cara Pemberian</th>
                                                                <th>PPA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Catatan Pemberian Obat</h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal dan Jam</th>
                                                                <th>Nama Obat</th>
                                                                <th>Dosis</th>
                                                                <th>Cara Pemberian</th>
                                                                <th>PPA</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Tindakan</h6>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal dan Jam</th>
                                                                <th>Tindakan</th>
                                                                <th>PPA</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Observasi Lanjutan/Re-Triase</h6>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tanggal dan Jam</th>
                                                                <th>Keluhan</th>
                                                                <th>Vital Sign</th>
                                                                <th>Re-Triase/EWS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>
                                                                    <ul>
                                                                        <li>xxx</li>
                                                                        <li>xxx</li>
                                                                        <li>xxx</li>
                                                                    </ul>
                                                                </td>
                                                                <td>xxx</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Alat yang Terpasang</h6>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Alat yang terpasang</th>
                                                                <th>Lokasi</th>
                                                                <th>Ket</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                                <td>xxx</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="form-line">
                                                <h6>Kondisi Pasien sebelum meninggalkan IGD</h6>
                                                <textarea class="form-control mb-2" rows="3" placeholder="Isikan riwayat penyakit pasien"></textarea>
                                            </div>

                                            <div class="form-line">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="mb-0 me-3">Tindak Lanjut Pelayanan</h6>
                                                    <button class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-plus"></i> Tambah
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan ini ke tag <style> atau file CSS -->
<style>
    /* Sticky untuk side kiri khusus di dalam modal #detailPasienModal */
    #detailPasienModal .patient-card {
        position: sticky;
        top: 0;
        max-height: 100vh;
        overflow-y: auto;
        padding-right: 10px;
    }

    /* Scroll untuk konten di sebelah kanan hanya dalam modal */
    #detailPasienModal .col-md-9 {
        max-height: 100vh;
        overflow-y: auto;
    }

    /* Garis pemisah tipis antar section */
    .form-line {
        border-bottom: 1px solid #e0e0e0;
        /* Ubah warna dan ketebalan sesuai kebutuhan */
        margin-bottom: 20px;
        /* Tambahkan margin bawah untuk spasi antar section */
        padding-bottom: 15px;
    }

    .pemeriksaan-fisik {
        margin-bottom: 20px;
    }

    .pemeriksaan-item {
        margin-bottom: 15px;
        padding: 10px;
        border-bottom: 1px solid #e0e0e0;
    }

    .pemeriksaan-item:last-child {
        border-bottom: none;
    }

    .tambah-keterangan {
        padding: 0px 5px;
    }

    .keterangan {
        margin-top: 10px;
    }
</style>

@push('js')
    <script>
        document.querySelectorAll('.tambah-keterangan').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const targetElement = document.getElementById(targetId);
                if (targetElement.style.display === 'none') {
                    targetElement.style.display = 'block';
                } else {
                    targetElement.style.display = 'none';
                }
            });
        });

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('.row');
                const keteranganDiv = row.querySelector('.keterangan');
                const tambahButton = row.querySelector('.tambah-keterangan');
                if (this.checked) {
                    keteranganDiv.style.display = 'none';
                    tambahButton.disabled = true;
                } else {
                    tambahButton.disabled = false;
                }
            });
        });
    </script>
@endpush
