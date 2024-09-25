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
                                    <h6>{{ $patient->nama ?? 'Tidak Diketahui' }}</h6>
                                    <p class="mb-0">
                                        xxxxxx
                                    </p>
                                    <small> 50 Thn </small>

                                    <div class="patient-meta mt-2">
                                        <p class="mb-0"><i class="bi bi-file-earmark-medical"></i>RM: 0-76-34-33</p>
                                        <p class="mb-0"><i class="bi bi-calendar3"></i>31 Jan 2025 - 31 Jan 2025</p>
                                        <p><i class="bi bi-hospital"></i>Rawat Jalan (Klinik Internis Pria)</p>
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
                                            <!-- Triage Pasien -->
                                            <h5>Triage Pasien</h5>
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
                                                                <div><span
                                                                        class="badge bg-warning text-dark">Triase</span>
                                                                </div>
                                                            </td>
                                                            <td><a href="#">detail</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Tindakan Resusitasi -->
                                            <h5>Tindakan Resusitasi</h5>
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
                                                                    <label class="form-check-label" for="bagAndMask">Bag
                                                                        and Mask</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="bagAndTube">
                                                                    <label class="form-check-label" for="bagAndTube">Bag
                                                                        and Tube</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="kompresiJantung">
                                                                    <label class="form-check-label"
                                                                        for="kompresiJantung">Kompresi jantung</label>
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

                                            <!-- Keluhan/Anamnesis -->
                                            <h5>Keluhan/Anamnesis</h5>
                                            <textarea class="form-control mb-2" rows="3" placeholder="Submit Your Order Information"></textarea>

                                            <!-- Riwayat Penyakit Pasien -->
                                            <h5>Riwayat Penyakit Pasien</h5>
                                            <textarea class="form-control mb-2" rows="3" placeholder="Submit Your Order Information"></textarea>

                                            <!-- Riwayat Pengobatan -->
                                            <h5>Riwayat Pengobatan</h5>
                                            <textarea class="form-control mb-2" rows="3" placeholder="Submit Your Order Information"></textarea>

                                            <!-- Riwayat Alergi -->
                                            <h5>Riwayat Alergi</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal/Jam</th>
                                                            <th>Dokter</th>
                                                            <th>Triage</th>
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

                                            <!-- Riwayat Perawatan -->
                                            <h5>Vital Sign</h5>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label>TD (Sistole)</label>
                                                    <input type="number" class="form-control" placeholder="Input 1">
                                                </div>
                                                <div class="col">
                                                    <label>TD (Sistole)</label>
                                                    <input type="number" class="form-control" placeholder="Input 2">
                                                </div>
                                                <div class="col">
                                                    <label>Nadi (x/mnt)</label>
                                                    <input type="number" class="form-control" placeholder="Input 3">
                                                </div>
                                                <div class="col">
                                                    <label>Suhu (°C)</label>
                                                    <input type="number" class="form-control" placeholder="Input 4">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label>Resp (x/mnt)</label>
                                                    <input type="number" class="form-control" placeholder="Input 5">
                                                </div>
                                                <div class="col">
                                                    <label>SPO (tanpa O2)</label>
                                                    <input type="number" class="form-control" placeholder="Input 6">
                                                </div>
                                                <div class="col">
                                                    <label>SPO (dengan O2)</label>
                                                    <input type="number" class="form-control" placeholder="Input 7">
                                                </div>
                                                <div class="col">
                                                    <label>CGS</label>
                                                    <input type="number" class="form-control" placeholder="Input 8">
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
