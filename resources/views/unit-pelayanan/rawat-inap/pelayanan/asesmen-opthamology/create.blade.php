@extends('layouts.administrator.master')


@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Asesmen Awal Keperawatan Opthamology</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
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
                                                <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" value="{{ date('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk" value="{{ date('H:i') }}">
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
                                            <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Tanpa Bantuan O2</label>
                                                    <input type="number" class="form-control" name="spo_o2_tanpa"
                                                        placeholder="Tanpa bantuan O2">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Dengan Bantuan O2</label>
                                                    <input type="number" class="form-control" name="spo_o2_dengan"
                                                        placeholder="Dengan bantuan O2">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suhu (C)</label>
                                            <input type="text" class="form-control" name="suhu"
                                                placeholder="suhu dalam celcius">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sensorium</label>
                                            <input type="text" class="form-control" name="sensorium"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Anemis</label>
                                            <input type="text" class="form-control" name="anemis"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Ikhterik</label>
                                            <input type="text" class="form-control" name="ikhterik"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Dyspnoe</label>
                                            <input type="text" class="form-control" name="dyspnoe"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Sianosis</label>
                                            <input type="text" class="form-control" name="sianosis"
                                                placeholder="Jelaskan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Edema</label>
                                            <input type="text" class="form-control" name="edema"
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
                                                <input type="text" class="form-control" name="rpt"
                                                    placeholder="jelaskan">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">RPO</label>
                                                <input type="text" class="form-control" name="rpo"
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
                                                            name="sph_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="sph_oculi_sinistra" placeholder="jelaskan">
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
                                                        <input type="text" class="form-control" name="tio_tod"
                                                            placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">TOS</label>
                                                        <input type="text" class="form-control" name="tio_tos"
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
                                                <label style="min-width: 200px;">Palpebra Superior</label>
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
                                                <label style="min-width: 200px;">Palpebra Inferior</label>
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
                                                <label style="min-width: 200px;">Conj. Tars Superior</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="tars_superior_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="tars_superior_oculi_sinistra" placeholder="jelaskan">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Conj. Tars. Inferior</label>
                                                <div class="d-flex gap-3" style="width: 100%;">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Dextra</label>
                                                        <input type="text" class="form-control"
                                                            name="tars_inferior_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="tars_inferior_oculi_sinistra" placeholder="jelaskan">
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
                                                            name="anterior_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="anterior_oculi_sinistra" placeholder="jelaskan">
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
                                                            name="vitreous_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="vitreous_oculi_sinistra" placeholder="jelaskan">
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
                                                            name="papil_oculi_dextra" placeholder="jelaskan">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Oculi Sinistra</label>
                                                        <input type="text" class="form-control"
                                                            name="papil_oculi_sinistra" placeholder="jelaskan">
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
                                                <label style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                                <input type="number" id="tinggi_badan" name="tinggi_badan"
                                                    class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                                <input type="number" id="berat_badan" name="berat_badan"
                                                    class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">IMT</label>
                                                <input type="text" class="form-control bg-light" id="imt"
                                                    name="imt" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">LPT</label>
                                                <input type="text" class="form-control bg-light" id="lpt"
                                                    name="lpt" readonly>
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
                                                <div class="row">
                                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                        <div class="col-md-6">
                                                            <div class="d-flex flex-column gap-3">
                                                                @foreach ($chunk as $item)
                                                                    <div class="pemeriksaan-item">
                                                                        <div
                                                                            class="d-flex align-items-center border-bottom pb-2">
                                                                            <div class="flex-grow-1">{{ $item->nama }}
                                                                            </div>
                                                                            <div class="form-check me-3">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    id="{{ $item->id }}-normal"
                                                                                    name="{{ $item->id }}-normal"
                                                                                    checked>
                                                                                <label class="form-check-label"
                                                                                    for="{{ $item->id }}-normal">Normal</label>
                                                                            </div>
                                                                            <button
                                                                                class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                                type="button"
                                                                                data-target="{{ $item->id }}-keterangan">
                                                                                <i class="bi bi-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="keterangan mt-2"
                                                                            id="{{ $item->id }}-keterangan"
                                                                            style="display:none;">
                                                                            <input type="text" class="form-control"
                                                                                name="{{ $item->id }}_keterangan"
                                                                                placeholder="Tambah keterangan jika tidak normal...">
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-nyeri">
                                        <h5 class="section-title">4. Status nyeri</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                            <select class="form-select" name="jenis_skala_nyeri" id="jenis_skala_nyeri">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="NRS">Numeric Rating Scale (NRS)</option>
                                                <option value="FLACC">Face, Legs, Activity, Cry, Consolability (FLACC)
                                                </option>
                                                <option value="CRIES">Crying, Requires, Increased, Expression, Sleepless
                                                    (CRIES)</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                            <input type="text" class="form-control" id="nilai_skala_nyeri"
                                                name="nilai_skala_nyeri" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                            <input type="hidden" class="form-control" id="kesimpulan_nyeri"
                                                name="kesimpulan_nyeri">
                                            <div class="alert alert-success" id="kesimpulan_nyeri_alert">
                                                Pilih skala nyeri terlebih dahulu
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h6 class="mb-3">Karakteristik Nyeri</h6>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Lokasi</label>
                                                    <input type="text" class="form-control" name="lokasi_nyeri">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Durasi</label>
                                                    <input type="text" class="form-control" name="durasi_nyeri">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Jenis nyeri</label>
                                                    <select class="form-select" name="jenis_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($jenisnyeri as $jenis)
                                                            <option value="{{ $jenis->id }}">{{ $jenis->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Frekuensi</label>
                                                    <select class="form-select" name="frekuensi_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($frekuensinyeri as $frekuensi)
                                                            <option value="{{ $frekuensi->id }}">{{ $frekuensi->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Menjalar?</label>
                                                    <select class="form-select" name="nyeri_menjalar">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($menjalar as $menjalar)
                                                            <option value="{{ $menjalar->id }}">{{ $menjalar->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kualitas</label>
                                                    <select class="form-select" name="kualitas_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($kualitasnyeri as $kualitas)
                                                            <option value="{{ $kualitas->id }}">{{ $kualitas->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Faktor pemberat</label>
                                                    <select class="form-select" name="faktor_pemberat">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($faktorpemberat as $pemberat)
                                                            <option value="{{ $pemberat->id }}">{{ $pemberat->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Faktor peringan</label>
                                                    <select class="form-select" name="faktor_peringan">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($faktorperingan as $peringan)
                                                            <option value="{{ $peringan->id }}">{{ $peringan->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">Efek Nyeri</label>
                                                    <select class="form-select" name="efek_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($efeknyeri as $efek)
                                                            <option value="{{ $efek->id }}">{{ $efek->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="riwayat-kesehatan">
                                        <h5 class="section-title">5. Riwayat Kesehatan</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Penyakit Yang Pernah Diderita</label>
                                            <div class="w-100">
                                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" data-bs-toggle="modal" data-bs-target="#penyakitModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedPenyakitList" class="d-flex flex-column gap-2">
                                                    <!-- Empty state message -->
                                                    <div id="emptyState" class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                        <i class="ti-info-circle mb-2"></i>
                                                        <p class="mb-0">Belum ada penyakit yang ditambahkan</p>
                                                    </div>
                                                </div>
                                                <!-- Hidden input to store the JSON data -->
                                                <input type="hidden" name="penyakit_diderita" id="penyakitDideritaInput">
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label style="min-width: 200px;">Riwayat Kesehatan Keluarga</label>
                                            <div class="w-100">
                                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                                    <!-- Empty state message -->
                                                    <div id="emptyStateRiwayat" class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                        <i class="ti-info-circle mb-2"></i>
                                                        <p class="mb-0">Belum ada riwayat kesehatan keluarga yang ditambahkan.</p>
                                                    </div>
                                                </div>
                                                <!-- Hidden input to store the JSON data -->
                                                <input type="hidden" name="riwayat_kesehatan_keluarga" id="riwayatKesehatanInput">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="section-separator" id="riwayatObat">
                                        <h5 class="section-title">6. Riwayat Penggunaan Obat</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openObatModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <input type="hidden" name="riwayat_penggunaan_obat" id="riwayatObatData" value="[]">
                                        <div class="table-responsive">
                                            <table class="table" id="createRiwayatObatTable">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Obat</th>
                                                        <th>Dosis</th>
                                                        <th>Aturan Pakai</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table content will be dynamically populated -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">7. Alergi</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openAlergiModal">
                                            <i class="fa fa-plus"></i> Tambah
                                        </button>
                                        <input type="hidden" name="alergis" id="alergisInput">
                                        <div class="table-responsive">
                                            <table class="table" id="createAlergiTable">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis</th>
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
                                        <h5 class="section-title">8. Discharge Planning</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Diagnosis">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Usia lanjut</label>
                                            <select class="form-select" name="usia_lanjut">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="0">Ya</option>
                                                <option value="1">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Hambatan mobilisasi</label>
                                            <select class="form-select" name="hambatan_mobilisasi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="0">Ya</option>
                                                <option value="1">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                            <select class="form-select" name="penggunaan_media_berkelanjutan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                                harian</label>
                                            <select class="form-select" name="ketergantungan_aktivitas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus
                                                Setelah
                                                Pulang</label>
                                            <select class="form-select" name="keterampilan_khusus">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                                Sakit</label>
                                            <select class="form-select" name="alat_bantu">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                                Pulang</label>
                                            <select class="form-select" name="nyeri_kronis">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Perkiraan lama hari dirawat</label>
                                                <input type="text" class="form-control" name="perkiraan_hari" placeholder="hari">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label">Rencana Tanggal Pulang</label>
                                                <input type="date" class="form-control" name="tanggal_pulang">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label class="form-label">KESIMPULAN</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="alert alert-info">
                                                    Pilih semua Planning
                                                </div>
                                                <div class="alert alert-warning">
                                                    Mebutuhkan rencana pulang khusus
                                                </div>
                                                <div class="alert alert-success">
                                                    Tidak mebutuhkan rencana pulang khusus
                                                </div>
                                            </div>
                                            <input type="hidden" id="kesimpulan" name="kesimpulan_planing" value="Tidak mebutuhkan rencana pulang khusus">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="fw-semibold mb-4">9. Diagnosis</h5>

                                        <!-- Diagnosis Banding -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis banding yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-banding-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Banding">
                                                <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Diagnosis items will be added here dynamically -->
                                            </div>
                                            
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="diagnosis_banding" name="diagnosis_banding" value="[]">
                                        </div>

                                        <!-- Diagnosis Kerja -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis kerja yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-kerja-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Kerja">
                                                <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Diagnosis items will be added here dynamically -->
                                            </div>
                                            
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja" value="[]">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="implemetasi" style="margin-bottom: 2rem;">
                                        <h5 class="fw-semibold mb-4">10. Implementasi</h5>

                                        <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan Pengobatan</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                                rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                        </div>

                                        <!-- Observasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Observasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="observasi-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Observasi">
                                                <span class="input-group-text bg-white" id="add-observasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="observasi-list" class="list-group mb-2 bg-light">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="observasi" name="observasi" value="[]">
                                        </div>

                                        <!-- Terapeutik Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Terapeutik</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="terapeutik-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Terapeutik">
                                                <span class="input-group-text bg-white" id="add-terapeutik">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="terapeutik-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="terapeutik" name="terapeutik" value="[]">
                                        </div>

                                        <!-- Edukasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Edukasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="edukasi-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Edukasi">
                                                <span class="input-group-text bg-white" id="add-edukasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="edukasi-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="edukasi" name="edukasi" value="[]">
                                        </div>

                                        <!-- Kolaborasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Kolaborasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="kolaborasi-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Kolaborasi">
                                                <span class="input-group-text bg-white" id="add-kolaborasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="kolaborasi-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="kolaborasi" name="kolaborasi" value="[]">
                                        </div>

                                        <!-- Kolaborasi Section -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold">Prognosis</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan
                                                Prognosis yang tidak ditemukan.</small>
                                                <!-- sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis -->
                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="rencana-input" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Rencana Penatalaksanaan">
                                                <span class="input-group-text bg-white" id="add-rencana">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="rencana-list" class="list-group mb-3">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="rencana_penatalaksanaan" name="prognosis" value="[]">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="implementasi-evaluasi">
                                        <h5 class="section-title">11. Evaluasi</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Tambah Evaluasi Keperawatan</label>
                                            <textarea class="form-control" rows="4" name="evaluasi_keperawatan"
                                                placeholder="Tambah evaluasi keperawatan..."></textarea>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
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
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.modal-create-obat')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.modal-riwayatkeluarga')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.modal-penyakitdiderita')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.modal-skalanyeri')
@endsection
