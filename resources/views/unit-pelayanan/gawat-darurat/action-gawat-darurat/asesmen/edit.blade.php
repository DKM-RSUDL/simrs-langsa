<!-- Modal Edit -->
<div class="modal fade" id="editAsesmenModal" tabindex="-1" aria-labelledby="editAsesmenLabel" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAsesmenLabel">Edit Asesmen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form id="editAsesmenForm">
                        <!-- Tindakan Resusitasi -->
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
                                                        name="edit_tindakan_resusitasi[air_way][]" value="Hyperekstesi"
                                                        id="edit_hyperekstesi">
                                                    <label class="form-check-label"
                                                        for="edit_hyperekstesi">Hyperekstesi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[air_way][]"
                                                        value="Bersihkan jalan nafas" id="edit_bersihkanJalanNafas">
                                                    <label class="form-check-label"
                                                        for="edit_bersihkanJalanNafas">Bersihkan jalan nafas</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[air_way][]" value="Intubasi"
                                                        id="edit_intubasi">
                                                    <label class="form-check-label" for="edit_intubasi">Intubasi</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[breathing][]"
                                                        value="Bag and Mask" id="edit_bagAndMask">
                                                    <label class="form-check-label" for="edit_bagAndMask">Bag and
                                                        Mask</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[breathing][]"
                                                        value="Bag and Tube" id="edit_bagAndTube">
                                                    <label class="form-check-label" for="edit_bagAndTube">Bag and
                                                        Tube</label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[circulation][]"
                                                        value="Kompresi jantung" id="edit_kompresiJantung">
                                                    <label class="form-check-label" for="edit_kompresiJantung">Kompresi
                                                        jantung</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[circulation][]"
                                                        value="Balut tekan" id="edit_balutTekan">
                                                    <label class="form-check-label" for="edit_balutTekan">Balut
                                                        tekan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        name="edit_tindakan_resusitasi[circulation][]" value="Operasi"
                                                        id="edit_operasi">
                                                    <label class="form-check-label" for="edit_operasi">Operasi</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Form fields -->
                        <div class="form-line">
                            <h6>Keluhan/Anamnesis</h6>
                            <textarea class="form-control mb-2" rows="3" name="edit_anamnesis"></textarea>
                        </div>

                        <div class="form-line">
                            <h6>Riwayat Penyakit Pasien</h6>
                            <textarea class="form-control mb-2" rows="3" name="edit_riwayat_penyakit"></textarea>
                        </div>

                        <div class="form-line">
                            <h6>Riwayat Penyakit Keluarga Pasien</h6>
                            <textarea class="form-control mb-2" rows="3" name="edit_riwayat_penyakit_keluarga"></textarea>
                        </div>

                        <div class="form-line">
                            <h6>Riwayat Pengobatan</h6>
                            <textarea class="form-control mb-2" rows="3" name="edit_riwayat_pengobatan"></textarea>
                        </div>

                        <div class="form-line">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 me-3">Riwayat Alergi</h6>
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.edit-alergimodal')
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="editAlergiTable">
                                    <thead>
                                        <tr>
                                            <th>Jenis</th>
                                            <th>Alergen</th>
                                            <th>Reaksi</th>
                                            <th>Serve</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-line">
                            <h6>Vital Sign</h6>
                            <div class="row mb-3">
                                <div class="col">
                                    <label>TD (Sistole)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_td_sistole">
                                </div>
                                <div class="col">
                                    <label>TD (Diastole)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_td_diastole">
                                </div>
                                <div class="col">
                                    <label>Nadi (x/mnt)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_nadi">
                                </div>
                                <div class="col">
                                    <label>Resp (x/mnt)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_resp">
                                </div>
                                <div class="col">
                                    <label>Suhu (°C)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_suhu">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-2 position-relative">
                                    <label>GCS</label>
                                    <input type="text" class="form-control" id="edit_gcsValue"
                                        name="edit_vital_sign[gcs_display]" readonly onclick="openEditGCSModal()">
                                    <i class="bi bi-pencil position-absolute"
                                        style="top: 50%; right: 10px; transform: translateY(-50%);"
                                        onclick="openEditGCSModal()"></i>
                                    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.edit-gcs')
                                </div>
                                <div class="col-4">
                                    <label>AVPU</label>
                                    <select class="form-select" name="edit_vital_sign_avpu">
                                        <option selected disabled>--Pilih--</option>
                                        <option>Sadar Baik/Alert</option>
                                        <option>Berespon dengan kata-kata/Voice</option>
                                        <option>Hanya berespon jika dirangsang nyeri/pain
                                        </option>
                                        <option>Pasien tidak sadar/unresponsive</option>
                                        <option>Gelisah atau bingung</option>
                                        <option>Acute Confusional States</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label>SpO2 (tanpa O2)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_spo2_tanpa_o2">
                                </div>
                                <div class="col-3">
                                    <label>SpO2 (dengan O2)</label>
                                    <input type="number" class="form-control" name="edit_vital_sign_spo2_dengan_o2">
                                </div>
                            </div>
                        </div>

                        <div class="form-line">
                            <h6>Antropometri</h6>
                            <div class="row mb-3">
                                <div class="col">
                                    <label>TB (cm)</label>
                                    <input type="number" class="form-control" name="edit_antropometri_tb">
                                </div>
                                <div class="col">
                                    <label>BB (kg)</label>
                                    <input type="number" class="form-control" name="edit_antropometri_bb">
                                </div>
                                <div class="col">
                                    <label>Ling. Kepala</label>
                                    <input type="number" class="form-control" name="edit_antropometri_ling_kepala">
                                </div>
                                <div class="col">
                                    <label>LPT</label>
                                    <input type="number" class="form-control" name="edit_antropometri_lpt">
                                </div>
                                <div class="col">
                                    <label>IMT</label>
                                    <input type="number" class="form-control" name="edit_antropometri_imt">
                                </div>
                            </div>
                        </div>

                        <div class="form-line">
                            <h6>Skala Nyeri Visual Analog</h6>
                            <p class="text-muted">*Pilih angka pada skala nyeri yang sesuai</p>
                            <div class="row align-items-center mb-3">
                                <div class="col-md-6">
                                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}"
                                        alt="Descriptive Alt Text" style="width: 100%; height: auto;">
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-3">Karakteristik Nyeri</h6>
                                    <div class="mb-2">
                                        <label>Skala Nyeri</label>
                                        <input type="number" name="edit_skala_nyeri" min="0" max="10"
                                            class="form-control" value="0">
                                    </div>
                                    <div class="mb-2">
                                        <label>Lokasi Nyeri</label>
                                        <input type="text" name="edit_lokasi" class="form-control"
                                            placeholder="Lokasi Nyeri">
                                    </div>
                                    <div class="mb-2">
                                        <label>Durasi</label>
                                        <input type="text" name="edit_durasi" class="form-control"
                                            placeholder="Durasi Nyeri">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <!-- Manjalar -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold mb-2">Manjalar</label>
                                    <div class="karakteristik-nyeri">
                                        @foreach ($menjalar as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="edit_menjalar"
                                                    id="edit_manjalar_{{ $option->id }}"
                                                    value="{{ $option->id }}">
                                                <label class="form-check-label"
                                                    for="edit_manjalar_{{ $option->id }}">
                                                    {{ $option->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Frekuensi -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold mb-2">Frekuensi</label>
                                    <div class="karakteristik-nyeri">
                                        @foreach ($frekuensinyeri as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="edit_frekuensi"
                                                    id="edit_frekuensi_{{ $option->id }}"
                                                    value="{{ $option->id }}">
                                                <label class="form-check-label"
                                                    for="edit_frekuensi_{{ $option->id }}">
                                                    {{ $option->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Kualitas -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold mb-2">Kualitas</label>
                                    <div class="karakteristik-nyeri">
                                        @foreach ($kualitasnyeri as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="edit_kualitas"
                                                    id="edit_kualitas_{{ $option->id }}"
                                                    value="{{ $option->id }}">
                                                <label class="form-check-label"
                                                    for="edit_kualitas_{{ $option->id }}">
                                                    {{ $option->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Faktor Pemberat -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold mb-2">Faktor Pemberat</label>
                                    <div class="karakteristik-nyeri">
                                        @foreach ($faktorpemberat as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="edit_faktor_pemberat"
                                                    id="edit_pemberat_{{ $option->id }}"
                                                    value="{{ $option->id }}">
                                                <label class="form-check-label"
                                                    for="edit_pemberat_{{ $option->id }}">
                                                    {{ $option->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Faktor Peringanan -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold mb-2">Faktor Peringanan</label>
                                    <div class="karakteristik-nyeri">
                                        @foreach ($faktorperingan as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="edit_faktor_peringan"
                                                    id="edit_peringan_{{ $option->id }}"
                                                    value="{{ $option->id }}">
                                                <label class="form-check-label"
                                                    for="edit_peringan_{{ $option->id }}">
                                                    {{ $option->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Efek Nyeri -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold mb-2">Efek Nyeri</label>
                                    <div class="karakteristik-nyeri">
                                        @foreach ($efeknyeri as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="edit_efek_nyeri"
                                                    id="edit_efek_{{ $option->id }}" value="{{ $option->id }}">
                                                <label class="form-check-label" for="edit_efek_{{ $option->id }}">
                                                    {{ $option->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
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
                                    tidak dipilih salah satunya, maka pemeriksaan tidak
                                    dilakukan.
                                </p>
                                <div class="row" id="edit_pemeriksaan_fisik_container">
                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                        <div class="col-md-6">
                                            @foreach ($chunk as $item)
                                                <div class="pemeriksaan-item">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1">
                                                            {{ $item->nama }}</div>
                                                        <div class="form-check me-2">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="{{ $item->id }}-normal">
                                                            <label class="form-check-label"
                                                                for="{{ $item->id }}-normal">Normal</label>
                                                        </div>
                                                        <button
                                                            class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                            type="button"
                                                            data-target="{{ $item->id }}-keterangan">+</button>
                                                    </div>
                                                    <div class="keterangan mt-2" id="{{ $item->id }}-keterangan"
                                                        style="display:none;">
                                                        <input type="text" class="form-control"
                                                            placeholder="Keterangan">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <div class="form-line">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 me-3">Diagnosis</h6>
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.edit-diagnosismodal')
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="editDiagnoseList">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-line">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 me-3">Observasi Lanjutan/Re-Triase</h6>
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.edit-retriasemodal')
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered" id="editreTriaseTable">
                                    <thead>
                                        <tr>
                                            <th>Tanggal dan Jam</th>
                                            <th>Keluhan</th>
                                            <th>Vital Sign</th>
                                            <th>Re-Triase/EWS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data re-triase akan ditampilkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-line">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 me-3">Alat yang Terpasang</h6>
                                @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.asesmen.edit-alatyangterpasang')
                            </div>
                            <div class="table-responsive mb-3">
                                <table class="table table-bordered" id="editalatTable">
                                    <thead>
                                        <tr>
                                            <th>Alat yang terpasang</th>
                                            <th>Lokasi</th>
                                            <th>Ket</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data akan ditampilkan di sini -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-line">
                            <h6>Kondisi Pasien sebelum meninggalkan IGD</h6>
                            <textarea class="form-control mb-2" rows="3" name="edit_kondisi_pasien"></textarea>
                        </div>

                        <div class="form-line">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 me-3">Tindak Lanjut Pelayanan</h6>
                            </div>

                            <div class="mb-3">
                                <div>
                                    <input type="radio" name="edit_tindakLanjut" value="rawatInap" id="edit_rawatInap"> 
                                    <label for="edit_rawatInap">Rawat Inap</label>
                                </div>
                                <div>
                                    <input type="radio" name="edit_tindakLanjut" value="rujukKeluar" id="edit_rujukKeluar">
                                    <label for="edit_rujukKeluar">Rujuk Keluar RS Lain</label>
                                </div>
                                <div>
                                    <input type="radio" name="edit_tindakLanjut" value="pulangSembuh" id="edit_pulangSembuh">
                                    <label for="edit_pulangSembuh">Pulang</label>
                                </div>
                                <div>
                                    <input type="radio" name="edit_tindakLanjut" value="berobatJalan" id="edit_berobatJalan">
                                    <label for="edit_berobatJalan">Berobat Jalan Ke Poli</label>
                                </div>
                                <div>
                                    <input type="radio" name="edit_tindakLanjut" value="menolakRawatInap" id="edit_menolakRawatInap">
                                    <label for="edit_menolakRawatInap">Menolak Rawat Inap</label>
                                </div>
                                <div>
                                    <input type="radio" name="edit_tindakLanjut" value="meninggalDunia" id="edit_meninggalDunia">
                                    <label for="edit_meninggalDunia">Meninggal Dunia</label>
                                </div>
                                <div>
                                    <input type="radio" name="edit_tindakLanjut" value="deathoffarrival" id="edit_deathoffarrival">
                                    <label for="edit_deathoffarrival">DOA</label>
                                </div>
                            </div>

                            <!-- Form untuk setiap opsi tindak lanjut -->

                            <div class="mb-3" id="edit_formRawatInap" style="display: none;">
                                <div class="mb-3">
                                    <label for="edit_tanggalRawatInap" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="edit_tanggalRawatInap" name="edit_tanggalRawatInap">
                                </div>

                                <div class="mb-3">
                                    <label for="edit_jamRawatInap" class="form-label">Jam</label>
                                    <input type="time" class="form-control" id="edit_jamRawatInap" name="edit_jamRawatInap">
                                </div>

                                <div class="mb-3">
                                    <label for="edit_keluhanUtama_ranap" class="form-label">Keluhan Utama & Riwayat Penyakit </label>
                                    <textarea class="form-control" id="edit_keluhanUtama_ranap" name="edit_keluhanUtama_ranap" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_hasilPemeriksaan_ranap" class="form-label">Hasil Pemeriksaan Penunjang Klinis</label>
                                    <textarea class="form-control" id="edit_hasilPemeriksaan_ranap" name="edit_hasilPemeriksaan_ranap" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_jalannyaPenyakit_ranap" class="form-label">Jalannya Penyakit & Hasil Konsultasi</label>
                                    <textarea class="form-control" id="edit_jalannyaPenyakit_ranap" name="edit_jalannyaPenyakit_ranap" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_diagnosis_ranap" class="form-label">Diagnosis</label>
                                    <textarea class="form-control" id="edit_diagnosis_ranap" name="edit_diagnosis_ranap" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_tindakan_ranap" class="form-label">Tindakan yang Telah Dilakukan</label>
                                    <textarea class="form-control" id="edit_tindakan_ranap" name="edit_tindakan_ranap" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_anjuran_ranap" class="form-label">Anjuran</label>
                                    <textarea class="form-control" id="edit_anjuran_ranap" name="edit_anjuran_ranap" rows="3"></textarea>
                                </div>
                            </div>

                            <div id="edit_formMenolakRawatInap" style="display: none;">
                                <label for="edit_alasanMenolak" class="form-label">Alasan</label>
                                <textarea class="form-control" id="edit_alasanMenolak" name="edit_alasanMenolak" rows="3"></textarea>
                            </div>

                            <div id="edit_formRujukKeluar" style="display: none;">
                                <div class="mb-3">
                                    <label for="edit_tujuan_rujuk" class="form-label">Tujuan Rujuk</label>
                                    <input type="text" class="form-control" id="edit_tujuan_rujuk" name="edit_tujuan_rujuk">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_alasan_rujuk" class="form-label">Alasan Rujuk</label>
                                    <select class="form-select" id="edit_alasan_rujuk" name="edit_alasan_rujuk">
                                        <option selected disabled>Pilih Alasan Rujuk</option>
                                        <option value="1">Indikasi Medis</option>
                                        <option value="2">Kamar Penuh</option>
                                        <option value="3">Permintaan Pasien</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_transportasi_rujuk" class="form-label">Transportasi Rujuk</label>
                                    <select class="form-select" id="edit_transportasi_rujuk" name="edit_transportasi_rujuk">
                                        <option selected disabled>Pilih Transportasi Rujuk</option>
                                        <option value="1">Ambulance</option>
                                        <option value="2">Kendaraan Pribadi</option>
                                        <option value="3">Lainnya</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3" id="edit_formpulangSembuh" style="display: none;">
                                <label for="edit_tanggalPulang" class="form-label">Tanggal Pulang</label>
                                <input type="date" class="form-control" id="edit_tanggalPulang" name="edit_tanggalPulang">
                                <label for="edit_jamPulang" class="form-label mt-2">Jam Pulang</label>
                                <input type="time" class="form-control" id="edit_jamPulang" name="edit_jamPulang">
                                <div class="mb-3">
                                    <label for="edit_alasn_pulang" class="form-label">Alasan Pulang</label>
                                    <select class="form-select" id="edit_alasn_pulang" name="edit_alasn_pulang">
                                        <option selected disabled>Pilih Alasan Pulang</option>
                                        <option value="1">Sembuh</option>
                                        <option value="2">Indikasi Medis</option>
                                        <option value="3">Permintaan Pasien</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_kondisi_pulang" class="form-label">Kondisi Pulang</label>
                                    <select class="form-select" id="edit_kondisi_pulang" name="edit_kondisi_pulang">
                                        <option selected disabled>Pilih Kondisi Pulang</option>
                                        <option value="1">Mandiri</option>
                                        <option value="2">Tidak Mandiri</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3" id="edit_formberobatJalan" style="display: none;">
                                <label for="edit_tanggal_rajal" class="form-label">Tanggal Berobat</label>
                                <input type="date" class="form-control mb-2" name="edit_tanggal_rajal" id="edit_tanggal_rajal">
                                <label for="edit_poli_unit_tujuan" class="form-label">Poli</label>
                                <select class="form-select" id="edit_poli_unit_tujuan" name="edit_poli_unit_tujuan">
                                    <option selected disabled>Pilih Poli</option>
                                    @foreach($unitPoli as $poli)
                                        <option value="{{ $poli->kd_unit }}">{{ $poli->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="edit_formmeninggalDunia" style="display: none;">
                                <label for="edit_tanggalMeninggal" class="form-label">Tanggal Meninggal</label>
                                <input type="date" class="form-control mb-2" name="edit_tanggalMeninggal" id="edit_tanggalMeninggal">
                                <label for="edit_jamMeninggal" class="form-label mt-2">Jam Meninggal</label>
                                <input type="time" class="form-control" id="edit_jamMeninggal" name="edit_jamMeninggal">
                            </div>

                            <div class="mb-3" id="edit_formDOA" style="display: none;">
                                <label for="edit_tanggalDoa" class="form-label">Tanggal Meninggal</label>
                                <input type="date" class="form-control mb-2" name="edit_tanggalDoa" id="edit_tanggalDoa">
                                <label for="edit_jamDoa" class="form-label mt-2">Jam Meninggal</label>
                                <input type="time" class="form-control" id="edit_jamDoa" name="edit_jamDoa">
                            </div>

                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnUpdateAsesmen">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Variable global
        let originalAlergiData = [];
        let originalDiagnosisData = [];
        let originalAlatData = [];
        let editTindakLanjutData = null;
        let originalResusitasiData = null;

        // Fungsi Edit Tindak Lanjut
        function fillEditTindakLanjut(data) {
            if (!data.tindaklanjut) return;
            
            const tindakLanjut = data.tindaklanjut;
            
            // Reset semua form
            $('input[name="edit_tindakLanjut"]').prop('checked', false);
            hideAllEditTindakLanjutForms();
            
            // Set radio button sesuai tindak lanjut
            switch(tindakLanjut.tindak_lanjut_code) {
                case 1: // Rawat Inap
                    $('input[name="edit_tindakLanjut"][value="rawatInap"]').prop('checked', true);
                    $('#edit_formRawatInap').show();
                    $('#edit_tanggalRawatInap').val(tindakLanjut.tanggal_rawat_inap);
                    $('#edit_jamRawatInap').val(tindakLanjut.jam_rawat_inap);
                    $('#edit_keluhanUtama_ranap').val(tindakLanjut.keluhan_utama_ranap);
                    $('#edit_hasilPemeriksaan_ranap').val(tindakLanjut.hasil_pemeriksaan_ranap);
                    $('#edit_jalannyaPenyakit_ranap').val(tindakLanjut.jalannya_penyakit_ranap);
                    $('#edit_diagnosis_ranap').val(tindakLanjut.diagnosis_ranap);
                    $('#edit_tindakan_ranap').val(tindakLanjut.tindakan_ranap);
                    $('#edit_anjuran_ranap').val(tindakLanjut.anjuran_ranap);
                    break;
                case 5: // Rujuk RS Lain
                    $('input[name="edit_tindakLanjut"][value="rujukKeluar"]').prop('checked', true);
                    $('#edit_formRujukKeluar').show();
                    $('#edit_tujuan_rujuk').val(tindakLanjut.tujuan_rujuk);
                    $('#edit_alasan_rujuk').val(tindakLanjut.alasan_rujuk);
                    $('#edit_transportasi_rujuk').val(tindakLanjut.transportasi_rujuk);
                    break;
                case 6: // Pulang
                    $('input[name="edit_tindakLanjut"][value="pulangSembuh"]').prop('checked', true);
                    $('#edit_formPulangSembuh').show();
                    // Isi form pulang
                    break;
                case 8: // Berobat Jalan
                    $('input[name="edit_tindakLanjut"][value="berobatJalan"]').prop('checked', true);
                    $('#edit_formberobatJalan').show();
                    // Isi form berobat jalan
                    break;
                case 9: // Menolak Rawat Inap
                    $('input[name="edit_tindakLanjut"][value="menolakRawatInap"]').prop('checked', true);
                    $('#edit_formMenolakRawatInap').show();
                    // Isi form menolak rawat inap
                    break;
                case 10: // Meninggal Dunia
                    $('input[name="edit_tindakLanjut"][value="meninggalDunia"]').prop('checked', true);
                    $('#edit_formmeninggalDunia').show();
                    $('#edit_tanggalMeninggal').val(tindakLanjut.tanggal_meninggal);
                    $('#edit_jamMeninggal').val(tindakLanjut.jam_meninggal);
                    break;
                case 11: // DOA
                    $('input[name="edit_tindakLanjut"][value="deathoffarrival"]').prop('checked', true);
                    $('#edit_formDOA').show();
                    $('#edit_tanggalDoa').val(tindakLanjut.tanggal_meninggal);
                    $('#edit_jamDoa').val(tindakLanjut.jam_meninggal);
                    break;
                default:
                    break;
            }
            
            editTindakLanjutData = tindakLanjut;
        }

        function hideAllEditTindakLanjutForms() {
            $('#edit_formRawatInap').hide();
            $('#edit_formMenolakRawatInap').hide();
            $('#edit_formRujukKeluar').hide();
            $('#edit_formpulangSembuh').hide();
            $('#edit_formberobatJalan').hide();
            $('#edit_formDOA').hide();
            $('#edit_formmeninggalDunia').hide();
        }

        $('input[name="edit_tindakLanjut"]').on('change', function() {
            hideAllEditTindakLanjutForms();
            const selectedValue = $(this).val();
            
            switch(selectedValue) {
                case 'rawatInap':
                    $('#edit_formRawatInap').show();
                    break;
                case 'rujukKeluar':
                    $('#edit_formRujukKeluar').show();
                    break;
                case 'pulangSembuh':
                    $('#edit_formpulangSembuh').show();
                    break;
                case 'berobatJalan':
                    $('#edit_formberobatJalan').show();
                    break;
                case 'menolakRawatInap':
                    $('#edit_formMenolakRawatInap').show();
                    break;
                case 'meninggalDunia':
                    $('#edit_formmeninggalDunia').show();
                    break;
                case 'deathoffarrival':
                    $('#edit_formDOA').show();
                    break;
                default:
                    break;
            }
        });


        // Fungsi untuk mengumpulkan data tindak lanjut saat update
        function collectEditTindakLanjutData() {
            const selectedOption = $('input[name="edit_tindakLanjut"]:checked').val();
            if (!selectedOption) return null;
            
            const tindakLanjutData = {
                option: selectedOption
            };
            
            switch(selectedOption) {
                case 'rawatInap':
                    tindakLanjutData.tanggal_rawat_inap = $('#edit_tanggalRawatInap').val();
                    tindakLanjutData.jam_rawat_inap = $('#edit_jamRawatInap').val();
                    tindakLanjutData.keluhan_utama_ranap = $('#edit_keluhanUtama_ranap').val();
                    tindakLanjutData.hasil_pemeriksaan_ranap = $('#edit_hasilPemeriksaan_ranap').val();
                    tindakLanjutData.jalannya_penyakit_ranap = $('#edit_jalannyaPenyakit_ranap').val();
                    tindakLanjutData.diagnosis_ranap = $('#edit_diagnosis_ranap').val();
                    tindakLanjutData.tindakan_ranap = $('#edit_tindakan_ranap').val();
                    tindakLanjutData.anjuran_ranap = $('#edit_anjuran_ranap').val();
                    break;
                case 'rujukKeluar':
                    tindakLanjutData.tujuan_rujuk = $('#edit_tujuan_rujuk').val();
                    tindakLanjutData.alasan_rujuk = $('#edit_alasan_rujuk').val();
                    tindakLanjutData.transportasi_rujuk = $('#edit_transportasi_rujuk').val();
                    break;
                case 'pulangSembuh':
                    tindakLanjutData.tanggal_pulang = $('#edit_tanggalPulang').val();
                    tindakLanjutData.jam_pulang = $('#edit_jamPulang').val();
                    tindakLanjutData.alasan_pulang = $('#edit_alasan_pulang').val();
                    tindakLanjutData.transportasi_pulang = $('#edit_transportasi_pulang').val();
                    break;
                case 'berobatJalan':
                    tindakLanjutData.tanggal_berobat = $('#edit_tanggalBerobat').val();
                    tindakLanjutData.jam_berobat = $('#edit_jamBerobat').val();
                    break;
                case 'menolakRawatInap':
                    tindakLanjutData.alasan_menolak = $('#edit_alasanMenolak').val();
                    break;
                case 'meninggalDunia':    
                    tindakLanjutData.tanggal_meninggal = $('#edit_tanggalMeninggal').val();
                    tindakLanjutData.jam_meninggal = $('#edit_jamMeninggal').val();
                    break;
                case 'deathoffarrival':
                    tindakLanjutData.tanggal_meninggal = $('#edit_tanggalDoa').val();
                    tindakLanjutData.jam_meninggal = $('#edit_jamDoa').val();
                    break;
                default:
                    break;
            }
            
            return tindakLanjutData;
        }

        // Fungsi edit
        function editAsesmen(id) {
            const button = event.target.closest('button');
            const url = button.dataset.url;

            const modal = new bootstrap.Modal(document.getElementById('editAsesmenModal'));

            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    console.log('Success Response:', response);
                    Swal.close();
                    if (response.status === 'success') {
                        fillEditForm(response.data.asesmen);
                        fillEditPemeriksaanFisik(response.data.asesmen.pemeriksaan_fisik);
                        window.currentAsesmenId = id;
                        modal.show();
                    } else {
                        Swal.fire('Error', 'Data tidak ditemukan', 'error');
                    }
                },
                error: function(xhr) {
                    console.log('Error Response:', xhr.responseJSON);
                    Swal.close();
                    Swal.fire('Error', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
                }
            });
        }

        // Fungsi mengisi form
        function fillEditForm(data) {
            // console.log('Raw data:', data);

            const asesmenData = data.asesmen;

            // Fill textarea data
            $('textarea[name="edit_anamnesis"]').val(data.anamnesis || '');
            $('textarea[name="edit_riwayat_penyakit"]').val(data.riwayat_penyakit || '');
            $('textarea[name="edit_riwayat_penyakit_keluarga"]').val(data.riwayat_penyakit_keluarga || '');
            $('textarea[name="edit_riwayat_pengobatan"]').val(data.riwayat_pengobatan || '');
            $('textarea[name="edit_kondisi_pasien"]').val(data.show_kondisi_pasien || '');
            $('input[name="edit_skala_nyeri"]').val(data.show_skala_nyeri || '');
            $('input[name="edit_lokasi"]').val(data.show_lokasi || '');
            $('input[name="edit_durasi"]').val(data.show_durasi || '');

            // Tandai radio button yang sesuai
            if (asesmenData.menjalar_id) {
                $(`input[name="edit_menjalar"][value="${asesmenData.menjalar_id}"]`).prop('checked', true);
            }
            
            if (asesmenData.frekuensi_nyeri_id) {
                $(`input[name="edit_frekuensi"][value="${asesmenData.frekuensi_nyeri_id}"]`).prop('checked', true);
            }
            
            if (asesmenData.kualitas_nyeri_id) {
                $(`input[name="edit_kualitas"][value="${asesmenData.kualitas_nyeri_id}"]`).prop('checked', true);
            }
            
            if (asesmenData.faktor_pemberat_id) {
                $(`input[name="edit_faktor_pemberat"][value="${asesmenData.faktor_pemberat_id}"]`).prop('checked', true);
            }
            
            if (asesmenData.faktor_peringan_id) {
                $(`input[name="edit_faktor_peringan"][value="${asesmenData.faktor_peringan_id}"]`).prop('checked', true);
            }
            
            if (asesmenData.efek_nyeri && asesmenData.efek_nyeri.id) {
                $(`input[name="edit_efek_nyeri"][value="${asesmenData.efek_nyeri.id}"]`).prop('checked', true);
            }


            originalResusitasiData = data.tindakan_resusitasi;

            const tindakanResusitasi = typeof data.tindakan_resusitasi === 'string' ?
                JSON.parse(data.tindakan_resusitasi) : data.tindakan_resusitasi;
            fillEditTindakanResusitasi(tindakanResusitasi);

            // Isi vital sign
            if (data.vital_sign) {
                const vitalSign = typeof data.vital_sign === 'string' ?
                    JSON.parse(data.vital_sign) : data.vital_sign;

                $('input[name="edit_vital_sign_td_sistole"]').val(vitalSign.td_sistole || '');
                $('input[name="edit_vital_sign_td_diastole"]').val(vitalSign.td_diastole || '');
                $('input[name="edit_vital_sign_nadi"]').val(vitalSign.nadi || '');
                $('input[name="edit_vital_sign_resp"]').val(vitalSign.resp || '');
                $('input[name="edit_vital_sign_suhu"]').val(vitalSign.suhu || '');

                if (vitalSign.gcs) {
                    const gcs = vitalSign.gcs;

                    // Set nilai untuk masing-masing komponen GCS
                    $(`input[name="edit_gcs_eye"][value="${gcs.eye.value}"]`).prop('checked', true);
                    $(`input[name="edit_gcs_verbal"][value="${gcs.verbal.value}"]`).prop('checked', true);
                    $(`input[name="edit_gcs_motoric"][value="${gcs.motoric.value}"]`).prop('checked', true);

                    // Set total nilai GCS pada input
                    document.getElementById('edit_gcsValue').value = gcs.total;
                    window.gcsData = gcs;
                } else {
                    document.getElementById('edit_gcsValue').value = window.gcsData?.total || '-';
                }

                $('select[name="edit_vital_sign_avpu"]').val(vitalSign.avpu || '');
                $('input[name="edit_vital_sign_spo2_tanpa_o2"]').val(vitalSign.spo2_tanpa_o2 || '');
                $('input[name="edit_vital_sign_spo2_dengan_o2"]').val(vitalSign.spo2_dengan_o2 || '');
            }

            // Isi antropometri
            if (data.antropometri) {
                const antropometri = typeof data.antropometri === 'string' ?
                    JSON.parse(data.antropometri) : data.antropometri;

                $('input[name="edit_antropometri_tb"]').val(antropometri.tb || '');
                $('input[name="edit_antropometri_bb"]').val(antropometri.bb || '');
                $('input[name="edit_antropometri_ling_kepala"]').val(antropometri.ling_kepala || '');
                $('input[name="edit_antropometri_lpt"]').val(antropometri.lpt || '');
                $('input[name="edit_antropometri_imt"]').val(antropometri.imt || '');
            }

            // Parse dan isi riwayat alergi
            const riwayatAlergi = typeof data.riwayat_alergi === 'string' ?
                JSON.parse(data.riwayat_alergi) : data.riwayat_alergi;
            originalAlergiData = riwayatAlergi || [];
            fillEditAlergiTable(riwayatAlergi);

            // Parse alat yang terpasang
            const alatTerpasang = typeof data.alat_terpasang === 'string' ?
                JSON.parse(data.alat_terpasang) : data.alat_terpasang;
            originalAlatData = alatTerpasang || [];
            fillEditAlatTable(alatTerpasang);

            if (data.show_diagnosis && Array.isArray(data.show_diagnosis)) {
                // Set data diagnosis ke variable global
                window.originalDiagnosisData = [...data.show_diagnosis];

                // Update tampilan di form utama
                const diagnosisHtml = window.originalDiagnosisData.map((diagnosis, index) => `
                    <div class="diagnosis-item mb-2">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <span class="badge bg-primary">${index + 1}</span>
                            </div>
                            <div class="flex-grow-1">
                                ${diagnosis}
                            </div>
                        </div>
                    </div>
                `).join('');

                $('#editDiagnoseList').html(diagnosisHtml);
            } else {
                window.originalDiagnosisData = [];
                $('#editDiagnoseList').html('<em>Tidak ada diagnosis</em>');
            }

            if (data.retriase_data && Array.isArray(data.retriase_data)) {
                originalReTriaseData = data.retriase_data;
                updateEditReTriaseTable();
            } else {
                originalReTriaseData = [];
                updateEditReTriaseTable();
            }

        }

        // Fungsi untuk format tanggal dari database
        function formatDate(dateString) {
            if (!dateString || dateString === '1900-01-01 00:00:00.000') return '';
            return dateString.split(' ')[0]; // Ambil bagian tanggal saja
        }

        // Fungsi untuk format jam dari database
        function formatTime(timeString) {
            if (!timeString || timeString === '1900-01-01 00:00:00.000') return '';
            return timeString.split(' ')[1].substring(0, 5); // Ambil bagian jam:menit
        }

        // Fungsi untuk memperbarui tampilan tabel Re-Triase
        function updateEditReTriaseTable() {
            const tbody = $('#editreTriaseTable tbody');
            tbody.empty();

            if (!originalReTriaseData || originalReTriaseData.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">
                            <em>Tidak ada data re-triase</em>
                        </td>
                    </tr>
                `);
                return;
            }

            originalReTriaseData.forEach((data) => {
                // Parse vital sign data
                let vitalSignData;
                try {
                    vitalSignData = typeof data.vitalsign_retriase === 'string' ?
                        JSON.parse(data.vitalsign_retriase) : data.vitalsign_retriase;
                } catch (e) {
                    console.error('Error parsing vital sign data:', e);
                    vitalSignData = {};
                }

                // Format vital signs untuk tampilan
                const formattedVitalSigns = `
                    <ul class="list-unstyled mb-0">
                        ${vitalSignData.td_sistole ? `<li>TD: ${vitalSignData.td_sistole}/${vitalSignData.td_diastole} mmHg</li>` : ''}
                        ${vitalSignData.nadi ? `<li>Nadi: ${vitalSignData.nadi} x/mnt</li>` : ''}
                        ${vitalSignData.resp ? `<li>Respirasi: ${vitalSignData.resp} x/mnt</li>` : ''}
                        ${vitalSignData.suhu ? `<li>Suhu: ${vitalSignData.suhu}°C</li>` : ''}
                        ${vitalSignData.spo2_tanpa_o2 ? `<li>SpO2 (tanpa O2): ${vitalSignData.spo2_tanpa_o2}%</li>` : ''}
                        ${vitalSignData.spo2_dengan_o2 ? `<li>SpO2 (dengan O2): ${vitalSignData.spo2_dengan_o2}%</li>` : ''}
                        ${vitalSignData.gcs ? `<li>GCS: ${vitalSignData.gcs}</li>` : ''}
                        ${vitalSignData.avpu ? `<li>AVPU: ${vitalSignData.avpu}</li>` : ''}
                    </ul>
                `;

                // Get triase badge class
                const getTriaseClass = (kodeTriase) => {
                    switch (parseInt(kodeTriase)) {
                        case 5:
                            return 'bg-dark text-white'; // Meninggal
                        case 4:
                            return 'bg-danger text-white'; // Emergency
                        case 3:
                            return 'bg-danger text-white'; // Emergency
                        case 2:
                            return 'bg-warning text-dark'; // Urgency
                        case 1:
                            return 'bg-success text-white'; // False Emergency
                        default:
                            return 'bg-secondary text-white';
                    }
                };

                const row = `
                    <tr>
                        <td class="align-middle">${data.tanggal_triase}</td>
                        <td class="align-middle">${data.anamnesis_retriase || '-'}</td>
                        <td class="align-middle">
                            <div class="vital-signs-container">
                                ${formattedVitalSigns}
                            </div>
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge ${getTriaseClass(data.kode_triase)} px-3 py-2">
                                ${data.hasil_triase || '-'}
                            </span>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // Fungsi untuk menentukan kelas triase berdasarkan kode
        function getTriaseClass(kode_triase) {
            switch (parseInt(kode_triase)) {
                case 5:
                    return 'triase-doa'; // Hitam
                case 4:
                    return 'triase-resusitasi'; // Merah
                case 3:
                    return 'triase-emergency'; // Merah
                case 2:
                    return 'triase-urgent'; // Kuning
                case 1:
                    return 'triase-false-emergency'; // Hijau
                default:
                    return '';
            }
        }

        // Memastikan tabel re-triase diperbarui saat data tersedia
        $('#editAsesmenModal').on('show.bs.modal', function() {
            updateEditReTriaseTable();
        });

        function updateMainDiagnosisView() {
            const diagnosisHtml = window.originalDiagnosisData.map((diagnosis, index) => `
                <div class="diagnosis-item mb-2">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <span class="badge bg-primary">${index + 1}</span>
                        </div>
                        <div class="flex-grow-1">
                            ${diagnosis}
                        </div>
                    </div>
                </div>
            `).join('');

            $('#editDiagnoseList').html(diagnosisHtml || '<em>Tidak ada diagnosis</em>');
        }

        // Fungsi mengisi tindakan resusitasi
        function fillEditTindakanResusitasi(tindakanData) {
            $('input[name^="edit_tindakan_resusitasi"]').each(function() {
                $(this).prop('checked', false).data('original-state', false);
            });

            if (!tindakanData) return;

            // Parse data jika dalam bentuk string
            if (typeof tindakanData === 'string') {
                try {
                    tindakanData = JSON.parse(tindakanData);
                } catch (e) {
                    console.error('Error parsing tindakan resusitasi:', e);
                    return;
                }
            }

            if (tindakanData.air_way && Array.isArray(tindakanData.air_way)) {
                tindakanData.air_way.forEach(item => {
                    const checkbox = $(`input[name="edit_tindakan_resusitasi[air_way][]"][value="${item}"]`);
                    checkbox.prop('checked', true).data('original-state', true);
                });
            }

            if (tindakanData.breathing && Array.isArray(tindakanData.breathing)) {
                tindakanData.breathing.forEach(item => {
                    const checkbox = $(`input[name="edit_tindakan_resusitasi[breathing][]"][value="${item}"]`);
                    checkbox.prop('checked', true).data('original-state', true);
                });
            }

            if (tindakanData.circulation && Array.isArray(tindakanData.circulation)) {
                tindakanData.circulation.forEach(item => {
                    const checkbox = $(`input[name="edit_tindakan_resusitasi[circulation][]"][value="${item}"]`);
                    checkbox.prop('checked', true).data('original-state', true);
                });
            }
        }

        // Event handler untuk delete alergi
        $(document).on('click', '.delete-edit-alergi', function() {
            $('#editAddAlergi').data('hasChanges', true);

            $(this).closest('tr').remove();

            if ($('#editAlergiTable tbody tr').length === 0) {
                $('#editAlergiTable tbody').html(`
                <tr>
                    <td colspan="5" class="text-center">
                        <em>Tidak ada data alergi</em>
                    </td>
                </tr>
            `);
            }
        });

        // Fungsi mengisi tabel alergi
        function fillEditAlergiTable(alergiData) {
            const tbody = $('#editAlergiTable tbody');
            tbody.empty();

            if (!alergiData || !Array.isArray(alergiData) || alergiData.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="5" class="text-center">
                            <em>Tidak ada data alergi</em>
                        </td>
                    </tr>
                `);
                return;
            }

            alergiData.forEach((alergi, index) => {
                const row = `
                    <tr>
                        <td>${alergi.jenis || '-'}</td>
                        <td>${alergi.alergen || '-'}</td>
                        <td>${alergi.reaksi || '-'}</td>
                        <td>${alergi.keparahan || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger delete-edit-alergi" data-index="${index}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function collectEditTindakanResusitasi() {

            let air_way_all = $('#editAsesmenModal input[name="edit_tindakan_resusitasi[air_way][]"]:checkbox:checked').map(
                function() {
                    return $(this).val();
                }).get();

            let breathing_all = $('#editAsesmenModal input[name="edit_tindakan_resusitasi[breathing][]"]:checkbox:checked')
                .map(function() {
                    return $(this).val();
                }).get();

            let circulation_all = $(
                '#editAsesmenModal input[name="edit_tindakan_resusitasi[circulation][]"]:checkbox:checked').map(
                function() {
                    return $(this).val();
                }).get();

            return {
                air_way: air_way_all,
                breathing: breathing_all,
                circulation: circulation_all
            };
        }

        // Fungsi collect data alergi
        function collectEditAlergi() {
            return originalAlergiData;
        }

        function fillEditAlatTable(alatData) {
            const tbody = $('#editalatTable tbody');
            tbody.empty();

            if (!alatData || !Array.isArray(alatData) || alatData.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="4" class="text-center">
                            <em>Tidak ada alat yang terpasang</em>
                        </td>
                    </tr>
                `);
                return;
            }

            alatData.forEach((alat, index) => {
                const row = `
                    <tr>
                        <td>${alat.nama || '-'}</td>
                        <td>${alat.lokasi || '-'}</td>
                        <td>${alat.keterangan || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger delete-edit-alat" data-index="${index}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        // Event handler untuk delete alat
        $(document).on('click', '.delete-edit-alat', function() {
            const index = $(this).data('index');
            originalAlatData.splice(index, 1);
            fillEditAlatTable(originalAlatData);
        });

        // Event handler untuk modal edit alat
        $('#openEditAlatModal').click(function() {
            $('#editAlatModal').modal('show');
        });

        // Event handler untuk simpan alat
        $('#simpanEditAlat').click(function() {
            const namaAlat = $('#editNamaAlat').val();
            const lokasiAlat = $('#editLokasiAlat').val();
            const keteranganAlat = $('#editKeteranganAlat').val();

            if (!namaAlat || !lokasiAlat || !keteranganAlat) {
                alert('Harap isi semua field');
                return;
            }

            const newAlat = {
                nama: namaAlat,
                lokasi: lokasiAlat,
                keterangan: keteranganAlat
            };

            originalAlatData.push(newAlat);
            fillEditAlatTable(originalAlatData);
            $('#editAlatModal').modal('hide');
            resetEditAlatForm();
        });

        // Fungsi reset form
        function resetEditAlatForm() {
            $('#editNamaAlat').val('');
            $('#editLokasiAlat').val('');
            $('#editKeteranganAlat').val('');
        }

        // Fungsi untuk collect data alat
        function collectEditAlat() {
            return originalAlatData;
        }

        function fillEditPemeriksaanFisik(pemeriksaanFisik) {
            const container = $('#edit_pemeriksaan_fisik_container'); // Unique container for edit

            container.empty();

            pemeriksaanFisik.forEach(function(item) {
                const isChecked = item.is_normal === '1';
                const keterangan = item.keterangan || '';

                const itemHtml = `
                    <div class="col-md-6 pemeriksaan-item mb-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">${item.nama_item}</div>
                            <div class="form-check me-2">
                                <input type="checkbox" class="form-check-input edit-pemeriksaan-fisik-checkbox" 
                                    id="edit_${item.id_item_fisik}_normal" ${isChecked ? 'checked' : ''} 
                                    data-id="${item.id_item_fisik}">
                                <label class="form-check-label" for="edit_${item.id_item_fisik}_normal">
                                    ${isChecked ? 'Normal' : 'Tidak Normal'}
                                </label>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary toggle-keterangan-btn" type="button"
                                data-bs-toggle="collapse" 
                                data-bs-target="#edit_keterangan_${item.id_item_fisik}"
                                style="display: ${isChecked ? 'none' : 'inline-block'};">
                                Keterangan
                            </button>
                        </div>
                        <div id="edit_keterangan_${item.id_item_fisik}" class="collapse mt-2 ${!isChecked ? 'show' : ''}">
                            <input type="text" class="form-control edit-keterangan-field" 
                                value="${keterangan}">
                        </div>
                    </div>
                `;

                container.append(itemHtml);
            });

            // Add event listeners to handle checkbox toggle
            $('.edit-pemeriksaan-fisik-checkbox').change(function() {
                const isChecked = $(this).is(':checked');
                const label = $(this).next('label');
                const keteranganBtn = $(this).closest('.pemeriksaan-item').find('.toggle-keterangan-btn');
                const keteranganField = $(this).closest('.pemeriksaan-item').find('.collapse');

                // Update label text and toggle keterangan field/button
                label.text(isChecked ? 'Normal' : 'Tidak Normal');
                keteranganBtn.toggle(!isChecked);
                if (isChecked) {
                    keteranganField.collapse('hide');
                } else {
                    keteranganField.collapse('show');
                }
            });
        }


        function collectEditPemeriksaanFisik() {
            const pemeriksaanFisikData = [];

            $('#edit_pemeriksaan_fisik_container .edit-pemeriksaan-fisik-checkbox').each(function() {
                const id = $(this).data('id');
                const isNormal = $(this).is(':checked') ? '1' : '0';
                const keterangan = $(this).closest('.pemeriksaan-item').find('.edit-keterangan-field').val() || '';

                pemeriksaanFisikData.push({
                    id_item_fisik: id,
                    is_normal: isNormal,
                    keterangan: keterangan
                });
            });

            return pemeriksaanFisikData;
        }


        $('#btnUpdateAsesmen').click(function(event) {
            event.preventDefault();

            // if ($(this).prop('disabled')) return;
            $(this).prop('disabled', true);

            const formData = {
                _method: 'PUT',
                urut_masuk: "{{ $dataMedis->urut_masuk }}",
                tindakan_resusitasi: collectEditTindakanResusitasi(),
                pemeriksaan_fisik: collectEditPemeriksaanFisik(),
                anamnesis: $('textarea[name="edit_anamnesis"]').val(),
                riwayat_penyakit: $('textarea[name="edit_riwayat_penyakit"]').val(),
                riwayat_penyakit_keluarga: $('textarea[name="edit_riwayat_penyakit_keluarga"]').val(),
                riwayat_pengobatan: $('textarea[name="edit_riwayat_pengobatan"]').val(),
                kondisi_pasien: $('textarea[name="edit_kondisi_pasien"]').val(),
                vital_sign: {
                    td_sistole: $('input[name="edit_vital_sign_td_sistole"]').val() || null,
                    td_diastole: $('input[name="edit_vital_sign_td_diastole"]').val() || null,
                    nadi: $('input[name="edit_vital_sign_nadi"]').val() || null,
                    resp: $('input[name="edit_vital_sign_resp"]').val() || null,
                    suhu: $('input[name="edit_vital_sign_suhu"]').val() || null,
                    gcs: window.gcsData || null,
                    avpu: $('select[name="edit_vital_sign_avpu"]').val() || null,
                    spo2_tanpa_o2: $('input[name="edit_vital_sign_spo2_tanpa_o2"]').val() || null,
                    spo2_dengan_o2: $('input[name="edit_vital_sign_spo2_dengan_o2"]').val() || null
                },
                antropometri: {
                    tb: $('input[name="edit_antropometri_tb"]').val() || null,
                    bb: $('input[name="edit_antropometri_bb"]').val() || null,
                    ling_kepala: $('input[name="edit_antropometri_ling_kepala"]').val() || null,
                    lpt: $('input[name="edit_antropometri_lpt"]').val() || null,
                    imt: $('input[name="edit_antropometri_imt"]').val() || null

                },
                menjalar_id: $('input[name="edit_menjalar"]:checked').val() || null,
                frekuensi_nyeri_id: $('input[name="edit_frekuensi"]:checked').val() || null,
                kualitas_nyeri_id: $('input[name="edit_kualitas"]:checked').val() || null,
                faktor_pemberat_id: $('input[name="edit_faktor_pemberat"]:checked').val() || null,
                faktor_peringan_id: $('input[name="edit_faktor_peringan"]:checked').val() || null,
                efek_nyeri: $('input[name="edit_efek_nyeri"]:checked').val() || null,
                
                riwayat_alergi: collectEditAlergi(),
                skala_nyeri: $('input[name="edit_skala_nyeri"]').val(),
                lokasi: $('input[name="edit_lokasi"]').val(),
                durasi: $('input[name="edit_durasi"]').val(),
                
                diagnosis: window.originalDiagnosisData,
                retriase_data: window.originalReTriaseData,
                alat_terpasang: collectEditAlat(),
                tindak_lanjut_data: collectEditTindakLanjutData(),

            };

            const editButton = $(`button[onclick="editAsesmen('${window.currentAsesmenId}')"]`);
            const baseUrl = editButton.data('url');
            const updateUrl = baseUrl.replace('/show', '');

            console.log('Data yang dikirim:', formData);

            $.ajax({
                url: updateUrl,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(response) {
                    console.log('Success Response:', response);
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Data berhasil diupdate',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', 'Gagal menyimpan data', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseJSON);
                    Swal.fire('Error', xhr.responseJSON?.message ||
                        'Terjadi kesalahan saat menyimpan data', 'error');
                },
                complete: function() {
                    $('#btnUpdateAsesmen').prop('disabled', false);
                }
            });
        });

        // Reset flags saat modal dibuka/ditutup
        $('#editAsesmenModal').on('show.bs.modal', function() {
            $('#editAddAlergi').data('hasChanges', false);
        });

        $('#editAsesmenModal').on('hidden.bs.modal', function() {
            $('#editAddAlergi').data('hasChanges', false);
            originalAlergiData = [];
        });

        // Tambahkan event listener untuk input BB dan TB
        $('input[name="edit_antropometri_bb"], input[name="edit_antropometri_tb"]').on('input', function() {
            calculateIMTAndLPT();
        });

        function calculateIMTAndLPT() {
            const bb = parseFloat($('input[name="edit_antropometri_bb"]').val()); // BB dalam kg
            const tb = parseFloat($('input[name="edit_antropometri_tb"]').val()); // TB dalam cm
            
            // Hitung IMT dan LPT jika BB dan TB tersedia
            if (!isNaN(bb) && !isNaN(tb) && tb > 0) {
                // IMT = BB / (TB/100)²
                const imt = (bb / ((tb/100) * (tb/100))).toFixed(1);
                $('input[name="edit_antropometri_imt"]').val(imt);
                
                // LPT menggunakan TB dalam cm
                $('input[name="edit_antropometri_lpt"]').val(tb); // LPT sama dengan TB dalam cm
            } else {
                // Kosongkan field jika data tidak lengkap
                $('input[name="edit_antropometri_imt"]').val('');
                $('input[name="edit_antropometri_lpt"]').val('');
            }
        }

        // Set input IMT dan LPT menjadi readonly
        $('input[name="edit_antropometri_imt"], input[name="edit_antropometri_lpt"]').prop('readonly', true);

    </script>
@endpush
