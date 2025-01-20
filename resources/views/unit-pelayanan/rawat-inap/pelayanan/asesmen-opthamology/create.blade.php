@extends('layouts.administrator.master')


@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <h4 class="header-asesmen">Asesmen Awal Keperawatan Opthamology</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <div class="progress-wrapper">
                                        <div class="progress-status">
                                            <span class="progress-label">Progress Pengisian</span>
                                            <span class="progress-percentage">60%</span>
                                        </div>
                                        <div class="custom-progress">
                                            <div class="progress-bar-custom" style="width: 60%"></div>
                                        </div>
                                        <div class="mt-2">
                                            <small class="text-muted">6/10 bagian telah diisi</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN AWAL KEPERATAWAN --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.keperawatan.opthamology.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}">
                            @csrf
                            <div class="px-3">
                                <div>
                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal_masuk">
                                                <input type="time" class="form-control" name="jam_masuk">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kondisi Masuk</label>
                                            <select class="form-select" name="kondisi_masuk">
                                                <option selected disabled>Pilih</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="Jalan Kaki">Jalan Kaki</option>
                                                <option value="Kursi Roda">Kursi Roda</option>
                                                <option value="Brankar">Brankar</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis Masuk</label>
                                            <input type="text" class="form-control" name="diagnosis_masuk">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Barang Berharga</label>
                                            <input type="text" class="form-control" name="barang_berharga">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Ruang</label>
                                            <select class="form-select" name="ruang">
                                                <option selected disabled>Pilih</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="anamnesis">
                                        <h5 class="section-title">2. Anamnesis</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Anamnesis</label>
                                            <textarea class="form-control" name="anamnesis" rows="4"
                                                placeholder="keluhan utama dan riwayat penyakit sekarang"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="pemeriksaan-fisik">
                                        <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="sistole"
                                                        placeholder="Sistole">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="text" class="form-control" name="diastole"
                                                        placeholder="Diastole">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                            <input type="text" class="form-control" name="nadi"
                                                placeholder="frekuensi nadi per menit">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                            <input type="text" class="form-control" name="nafas"
                                                placeholder="frekuensi nafas per menit">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suhu (C)</label>
                                            <input type="text" class="form-control" name="suhu"
                                                placeholder="suhu dalam celcius">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sensorium</label>
                                            <input type="text" class="form-control" name="Sensorium"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Anemis</label>
                                            <input type="text" class="form-control" name="Anemis"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Ikhterik</label>
                                            <input type="text" class="form-control" name="Ikhterik"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Dyspnoe</label>
                                            <input type="text" class="form-control" name="Dyspnoe"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sianosis</label>
                                            <input type="text" class="form-control" name="Sianosis"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Edema</label>
                                            <input type="text" class="form-control" name="Edema"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">AVPU</label>
                                            <select class="form-select" name="avpu">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="0">Sadar Baik/Alert : 0</option>
                                                <option value="1">Berespon dengan kata-kata/Voice: 1</option>
                                                <option value="2">Hanya berespon jika dirangsang nyeri/pain: 2
                                                </option>
                                                <option value="3">Pasien tidak sadar/unresponsive: 3</option>
                                                <option value="4">Gelisah atau bingung: 4</option>
                                                <option value="5">Acute Confusional States: 5</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <h6>Pemeriksaan Fisik Komperenshif</h6>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">RPT</label>
                                                <input type="text" class="form-control" name="RPT"
                                                    placeholder="jelaskan">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">RPO</label>
                                                <input type="text" class="form-control" name="RPO"
                                                    placeholder="jelaskan">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Acuity Vision Oculi</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">A.V.O.D</label>
                                                        <input type="text" class="form-control" name="avdo"
                                                            placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">A.V.O.S</label>
                                                        <input type="text" class="form-control" name="avso"
                                                            placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Kor. Sph</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="kor_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="kor_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Cyl</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="cyl_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="cyl_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Menjadi</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="menjadi_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="menjadi_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">KMB</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="kmb_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="kmb_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tekanan Intraokular (TIO)</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">TOD</label>
                                                        <input type="text" class="form-control" name="tos"
                                                            placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">TOS</label>
                                                        <input type="text" class="form-control" name="tod"
                                                            placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h6>Opthamicus</h6>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Visus</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="visus_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="visus_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Visus Koreksi</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="koreksi_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="koreksi_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Refraksi Subyektif</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="subyektif_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="subyektif_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Refraksi Obyektif</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="obyektif_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="obyektif_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tekanan Intrakoular (TIO)</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="tio_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="tio_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Posisi</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="posisi_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="posisi_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Palpebra Inferior</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="palpebra_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="palpebra_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Conj. Tars Superior</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="superior_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="superior_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Conj. Tars. Inferior</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="inferior_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="inferior_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Conj. Bulbi</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="bulbi_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="bulbi_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Sclera</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="sclera_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="sclera_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Sclera</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="sclera_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="sclera_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Cornea</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="cornea_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="cornea_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Camera Oculi Anterior</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="camera_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="camera_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Pupil</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="pupil_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="pupil_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Iris</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="iris_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="iris_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Lensa</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="lensa_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="lensa_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Corpus Vitreous</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="corpus_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="corpus_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <h6>Fundus Oculi</h6>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Media</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="media_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="media_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Papil</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="sclera_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="sclera_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Macula</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="macula_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="macula_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Retina</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="retina_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="retina_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h6>Antropometri</h6>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tinggi Badan (Kg)</label>
                                                <input type="text" class="form-control" name="tinggi_badan">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                                <input type="text" class="form-control" name="berat_badan">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">IMT</label>
                                                <input type="text" class="form-control" name="imt">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">LPT</label>
                                                <input type="text" class="form-control" name="lpt">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Lingkar Kepala (Cm)</label>
                                                <input type="text" class="form-control" name="lingkar_kepala">
                                            </div>
                                        </div>

                                        <div class="alert alert-info mb-3 mt-4">
                                            <p class="mb-0 small">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk
                                                menambah
                                                keterangan fisik yang ditemukan tidak normal.
                                                Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                            </p>
                                        </div>

                                        <div class="row g-3">
                                            @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column gap-3">
                                                        @foreach ($chunk as $item)
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center border-bottom pb-2">
                                                                    <div class="flex-grow-1">{{ $item->nama }}</div>
                                                                    <div class="form-check me-3">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="{{ strtolower($item->nama) }}-normal"
                                                                            checked>
                                                                        <label class="form-check-label"
                                                                            for="{{ strtolower($item->nama) }}-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        type="button"
                                                                        data-target="{{ strtolower($item->nama) }}-keterangan">
                                                                        <i class="bi bi-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="keterangan mt-2"
                                                                    id="{{ strtolower($item->nama) }}-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ strtolower($item->nama) }}_keterangan"
                                                                        placeholder="Tambah keterangan jika tidak normal...">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="section-separator" id="riwayat-kesehatan">
                                        <h5 class="section-title">4. Riwayat Kesehatan</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openRiwayatModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>

                                        <div id="daftarRiwayatContainer" class="list-group">
                                            <!-- Daftar riwayat akan ditampilkan di sini -->
                                        </div>
                                    </div>

                                    <div class="section-separator" id="riwayat-kesehatan">
                                        <h5 class="section-title">5. Riwayat Penggunaan Obat</h5>
                                    </div>

                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">6. Alergi</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openAlergiModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>

                                        <div class="table-responsive">
                                            <table class="table" id="createAlergiTable">
                                                <thead>
                                                    <tr>
                                                        <th>Alergen</th>
                                                        <th>Reaksi</th>
                                                        <th>Severe</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table content will be dynamically populated -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="discharge-planning">
                                        <h5 class="section-title">7. Disharge Planning</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Lokasi nyeri">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Usia lanjut</label>
                                            <select class="form-select" name="usia_lanjut">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Hambatan mobilisasi</label>
                                            <select class="form-select" name="hambatan_mobilisasi">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                            <select class="form-select" name="penggunaan_media_berkelanjutan">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                                harian</label>
                                            <select class="form-select" name="ketergantungan_aktivitas">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Perkiraan lama hari dirawat</label>
                                            <input type="text" class="form-control" name="perkiraan_hari"
                                                placeholder="hari">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Rencana Tanggal Pulang</label>
                                            <input type="date" class="form-control" name="tanggal_pulang">
                                        </div>

                                        <div class="mt-4">
                                            <label class="form-label">KESIMPULAN</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="alert alert-warning">
                                                    Mebutuhkan rencana pulang khusus
                                                </div>
                                                <div class="alert alert-success">
                                                    Tidak mebutuhkan rencana pulang khusus
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="section-title">8. Diagnosis</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis Diferensial</label>
                                            <p class="text-muted small">Pilih tanda dokumen untuk mencari diagnosis diferensial, apabila tidak ada, pilih tanda tambah untuk menambah keterangan diagnosis diferensial yang tidak ditemukan.</p>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="diagnosisDiferensialInput" placeholder="Cari dan tambah Diagnosis Diferensial">
                                                <button class="btn btn-outline-primary" type="button" id="btnAddDiagnosisDiferensial">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <div class="list-group" id="diagnosisDiferensialList">
                                                <!-- List akan muncul disini -->
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis Kerja</label>
                                            <p class="text-muted small">Pilih tanda dokumen untuk mencari diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan diagnosis kerja yang tidak ditemukan.</p>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="diagnosisKerjaInput" placeholder="Cari dan tambah Diagnosis Kerja">
                                                <button class="btn btn-outline-primary" type="button" id="btnAddDiagnosisKerja">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <div class="list-group" id="diagnosisKerjaList">
                                                <!-- List akan muncul disini -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="implementasi">
                                        <h5 class="section-title">9. Implementasi</h5>

                                        <div class="mb-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    placeholder="Cari dan tambah Implemtasi">
                                                <button class="btn btn-outline-primary" type="button">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="list-group">
                                            <div class="list-group-item list-group-item-light">
                                                1. Memberikan antibiotik intravena sesuai jadwal.
                                            </div>
                                            <div class="list-group-item list-group-item-light">
                                                2. Mengajarkan pasien cara menggunakan inhaler untuk asma
                                            </div>
                                            <div class="list-group-item list-group-item-light">
                                                3. Membersihkan luka dengan cairan NaCl dan mengganti balutan setiap hari
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="implementasi-evaluasi">
                                        <h5 class="section-title">10. Evaluasi</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Tambah Evaluasi Keperawatan</label>
                                            <textarea class="form-control" rows="4" name="evaluasi_keperawatan"
                                                placeholder="Tambah evaluasi keperawatan..."></textarea>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.modal-create-alergi')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.modal-riwayat-kesehatan')
@endsection
