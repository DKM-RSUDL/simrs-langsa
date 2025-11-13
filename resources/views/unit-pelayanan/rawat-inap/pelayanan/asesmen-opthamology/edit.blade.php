@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.edit-include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-kep-anak')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Edit Asesmen Awal Medis Opthamology',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])
                    {{-- FORM ASESMEN KEPERATAWAN Opthamology --}}
                    <form method="POST"
                        action="{{ route('rawat-inap.asesmen.keperawatan.opthamology.update', [
                            'kd_unit' => $kd_unit,
                            'kd_pasien' => $kd_pasien,
                            'tgl_masuk' => $tgl_masuk,
                            'urut_masuk' => $urut_masuk,
                            'id' => $asesmen->id,
                        ]) }}">
                        @csrf
                        @method('PUT')
                        <div class="px-3">
                            {{-- 1. Data Masuk --}}
                            <div class="section-separator" id="data-masuk">
                                <h5 class="section-title">1. Data masuk</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Pengisian</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal_masuk"
                                            id="tanggal_masuk"
                                            value="{{ Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                            value="{{ Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('H:i') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Diagnosis Masuk</label>
                                    <input type="text" class="form-control" name="diagnosis_masuk"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamology->diagnosis_masuk ?? '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kondisi Masuk</label>
                                    <select class="form-select" name="kondisi_masuk">
                                        <option disabled>--Pilih--</option>
                                        <option value="Baik"
                                            {{ $asesmen->rmeAsesmenKepOphtamology->kondisi_masuk == 'Baik' ? 'selected' : '' }}>
                                            Baik</option>
                                        <option value="Sedang"
                                            {{ $asesmen->rmeAsesmenKepOphtamology->kondisi_masuk == 'Sedang' ? 'selected' : '' }}>
                                            Sedang</option>
                                        <option value="Buruk"
                                            {{ $asesmen->rmeAsesmenKepOphtamology->kondisi_masuk == 'Buruk' ? 'selected' : '' }}>
                                            Buruk</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Barang Berharga</label>
                                    <input type="text" class="form-control" name="barang_berharga"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamology->barang_berharga ?? '' }}">
                                </div>
                            </div>

                            {{-- 2. Anamnesis --}}
                            <div class="section-separator" id="anamnesis">
                                <h5 class="section-title">2. Anamnesis</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Anamnesis</label>
                                    <textarea class="form-control" name="anamnesis" rows="4"
                                        placeholder="keluhan utama dan riwayat penyakit sekarang">{{ $asesmen->anamnesis }}</textarea>
                                </div>
                            </div>

                            {{-- 3. Pemeriksaan Fisik --}}
                            <div class="section-separator" id="pemeriksaan-fisik">
                                <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <label class="form-label">Sistole</label>
                                            <input type="number" class="form-control" name="sistole"
                                                value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->sistole ?? '' }}"
                                                placeholder="Sistole">
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label">Diastole</label>
                                            <input type="number" class="form-control" name="diastole"
                                                value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->diastole ?? '' }}"
                                                placeholder="Diastole">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                    <input type="number" class="form-control" name="nadi"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->nadi ?? '' }}"
                                        placeholder="frekuensi nadi per menit">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                    <input type="number" class="form-control" name="nafas"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->nafas ?? '' }}"
                                        placeholder="frekuensi nafas per menit">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Suhu (C)</label>
                                    <input type="number" class="form-control" name="suhu"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->suhu ?? '' }}"
                                        placeholder="suhu dalam celcius">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <div class="flex-grow-1">
                                            <label class="form-label">Tanpa Bantuan O2</label>
                                            <input type="number" class="form-control" name="spo_o2_tanpa"
                                                value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->spo2_tanpa_bantuan ?? '' }}"
                                                placeholder="Tanpa bantuan O2">
                                        </div>
                                        <div class="flex-grow-1">
                                            <label class="form-label">Dengan Bantuan O2</label>
                                            <input type="number" class="form-control" name="spo_o2_dengan"
                                                value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->spo2_dengan_bantuan ?? '' }}"
                                                placeholder="Dengan bantuan O2">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Sensorium</label>
                                    <input type="text" class="form-control" name="sensorium"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->sensorium ?? '' }}"
                                        placeholder="Jelaskan">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Anemis</label>
                                    <input type="text" class="form-control" name="anemis"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->anemis ?? '' }}"
                                        placeholder="Jelaskan">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Ikhterik</label>
                                    <input type="text" class="form-control" name="ikhterik"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->ikhterik ?? '' }}"
                                        placeholder="Jelaskan">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Dyspnoe</label>
                                    <input type="text" class="form-control" name="dyspnoe"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->dyspnoe ?? '' }}"
                                        placeholder="Jelaskan">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Sianosis</label>
                                    <input type="text" class="form-control" name="sianosis"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->sianosis ?? '' }}"
                                        placeholder="Jelaskan">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Edema</label>
                                    <input type="text" class="form-control" name="edema"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->edema ?? '' }}"
                                        placeholder="Jelaskan">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">AVPU</label>
                                    <select class="form-select" name="avpu">
                                        <option disabled>--Pilih--</option>
                                        <option value="0"
                                            {{ $asesmen->rmeAsesmenKepOphtamologyFisik->avpu == '0' ? 'selected' : '' }}>
                                            Sadar
                                            Baik/Alert</option>
                                        <option value="1"
                                            {{ $asesmen->rmeAsesmenKepOphtamologyFisik->avpu == '1' ? 'selected' : '' }}>
                                            Berespon dengan kata-kata/Voice</option>
                                        <option value="2"
                                            {{ $asesmen->rmeAsesmenKepOphtamologyFisik->avpu == '2' ? 'selected' : '' }}>
                                            Hanya
                                            berespon jika dirangsang nyeri/pain</option>
                                        <option value="3"
                                            {{ $asesmen->rmeAsesmenKepOphtamologyFisik->avpu == '3' ? 'selected' : '' }}>
                                            Pasien tidak sadar/unresponsive</option>
                                        <option value="4"
                                            {{ $asesmen->rmeAsesmenKepOphtamologyFisik->avpu == '4' ? 'selected' : '' }}>
                                            Gelisah atau bingung</option>
                                        <option value="5"
                                            {{ $asesmen->rmeAsesmenKepOphtamologyFisik->avpu == '5' ? 'selected' : '' }}>
                                            Acute
                                            Confusional States</option>
                                    </select>
                                </div>

                                <div class="mt-4">
                                    <h6>Antropometri</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                        <input type="number" id="tinggi_badan" name="tinggi_badan"
                                            class="form-control"
                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->tinggi_badan ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                        <input type="number" id="berat_badan" name="berat_badan"
                                            class="form-control"
                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyFisik->berat_badan ?? '' }}">
                                    </div>
                                </div>

                                <div class="alert alert-info mb-3 mt-4">
                                    <p class="mb-0 small">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk menambah
                                        keterangan fisik yang ditemukan tidak normal.
                                        Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                    </p>
                                </div>

                                <div class="row g-3">
                                    <div class="pemeriksaan-fisik">
                                        <h6>Pemeriksaan Fisik</h6>
                                        <p class="text-small">Centang normal jika fisik yang dinilai normal,
                                            pilih tanda tambah untuk menambah keterangan fisik yang ditemukan tidak
                                            normal.
                                            Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                        </p>
                                        <div class="row">
                                            @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column gap-3">
                                                        @foreach ($chunk as $item)
                                                            @php
                                                                // Pastikan $item tersedia dan ambil data pemeriksaan fisik terkait
                                                                if (!empty($asesmen->pemeriksaanFisik)) {
                                                                    $pemeriksaanFisik = $asesmen->pemeriksaanFisik
                                                                        ->where('id_item_fisik', $item->id)
                                                                        ->first();
                                                                    $isNormal = $pemeriksaanFisik
                                                                        ? $pemeriksaanFisik->is_normal
                                                                        : 1;
                                                                    $keterangan = $pemeriksaanFisik
                                                                        ? $pemeriksaanFisik->keterangan
                                                                        : '';
                                                                } else {
                                                                    $isNormal = 1;
                                                                    $keterangan = '';
                                                                }
                                                            @endphp
                                                            <div class="pemeriksaan-item">
                                                                <div
                                                                    class="d-flex align-items-center border-bottom pb-2">
                                                                    <div class="flex-grow-1">{{ $item->nama }}</div>
                                                                    <div class="form-check me-3">
                                                                        <input type="checkbox"
                                                                            class="form-check-input"
                                                                            id="{{ $item->id }}-normal"
                                                                            name="{{ $item->id }}-normal"
                                                                            {{ $isNormal ? 'checked' : '' }}>
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
                                                                    style="display:{{ !$isNormal || $keterangan ? 'block' : 'none' }};">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ $item->id }}_keterangan"
                                                                        value="{{ $keterangan }}"
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

                            {{-- 4. Pemeriksaan Mata Komprehensif --}}
                            <div class="section-separator" id="pemeriksaan-mata">
                                <h5 class="section-title">4. Pemeriksaan Mata Komprehensif</h5>

                                <div class="mt-4">
                                    <h6>Pemeriksaan Fisik Komperenshif</h6>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">RPT</label>
                                        <input type="text" class="form-control" name="rpt"
                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->rpt ?? '' }}"
                                            placeholder="jelaskan">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">RPO</label>
                                        <input type="text" class="form-control" name="rpo"
                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->rpo ?? '' }}"
                                            placeholder="jelaskan">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Acuity Vision Oculi</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">A.V.O.D</label>
                                                <input type="text" class="form-control" name="avdo"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->avod ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">A.V.O.S</label>
                                                <input type="text" class="form-control" name="avso"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->avos ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kor. Sph</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Oculi Dextra</label>
                                                <input type="text" class="form-control" name="sph_oculi_dextra"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->sph_oculi_dextra ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Oculi Sinistra</label>
                                                <input type="text" class="form-control" name="sph_oculi_sinistra"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->sph_oculi_sinistra ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Cyl</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Oculi Dextra</label>
                                                <input type="text" class="form-control" name="cyl_oculi_dextra"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->cyl_oculi_dextra ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Oculi Sinistra</label>
                                                <input type="text" class="form-control" name="cyl_oculi_sinistra"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->cyl_oculi_sinistra ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Menjadi</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Oculi Dextra</label>
                                                <input type="text" class="form-control"
                                                    name="menjadi_oculi_dextra"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->menjadi_oculi_dextra ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Oculi Sinistra</label>
                                                <input type="text" class="form-control"
                                                    name="menjadi_oculi_sinistra"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->menjadi_oculi_sinistra ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">KMB</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Oculi Dextra</label>
                                                <input type="text" class="form-control" name="kmb_oculi_dextra"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->kmb_oculi_dextra ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Oculi Sinistra</label>
                                                <input type="text" class="form-control" name="kmb_oculi_sinistra"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->kmb_oculi_sinistra ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tekanan Intraokular (TIO)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">TOD</label>
                                                <input type="text" class="form-control" name="tio_tod"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tio_tod ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">TOS</label>
                                                <input type="text" class="form-control" name="tio_tos"
                                                    value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tio_tos ?? '' }}"
                                                    placeholder="jelaskan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h6>Pemeriksaan Lengkap Mata</h6>
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="25%">Parameter</th>
                                                    <th width="37.5%">Oculi Dextra</th>
                                                    <th width="37.5%">Oculi Sinistra</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Visus</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="visus_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->visus_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="visus_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->visus_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Koreksi</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="koreksi_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->koreksi_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="koreksi_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->koreksi_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Subyektif</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="subyektif_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->subyektif_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="subyektif_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->subyektif_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Obyektif</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="obyektif_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->obyektif_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="obyektif_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->obyektif_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>TIO</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="tio_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tio_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="tio_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tio_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Posisi</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="posisi_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->posisi_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="posisi_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->posisi_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Palpebra</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="palpebra_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->palpebra_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="palpebra_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->palpebra_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Inferior</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="inferior_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->inferior_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="inferior_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->inferior_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tars Superior</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="tars_superior_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tars_superior_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="tars_superior_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tars_superior_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tars Inferior</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="tars_inferior_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tars_inferior_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="tars_inferior_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tars_inferior_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Bulbi</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="bulbi_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->bulbi_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="bulbi_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->bulbi_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Sclera</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="sclera_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->sclera_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="sclera_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->sclera_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Cornea</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="cornea_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->cornea_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="cornea_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->cornea_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Anterior</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="anterior_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->anterior_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="anterior_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->anterior_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Pupil</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="pupil_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->pupil_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="pupil_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->pupil_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Iris</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="iris_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->iris_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="iris_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->iris_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Lensa</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="lensa_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->lensa_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="lensa_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->lensa_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Vitreous</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="vitreous_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->vitreous_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="vitreous_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->vitreous_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Media</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="media_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->media_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="media_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->media_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Papil</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="papil_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->papil_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="papil_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->papil_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Macula</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="macula_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->macula_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="macula_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->macula_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Retina</strong></td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="retina_oculi_dextra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->retina_oculi_dextra ?? '' }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="retina_oculi_sinistra"
                                                            value="{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->retina_oculi_sinistra ?? '' }}">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- 5. Status Nyeri --}}
                            <div class="section-separator" id="status-nyeri">
                                <h5 class="section-title">5. Status nyeri</h5>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                    <select class="form-select" name="jenis_skala_nyeri" id="jenis_skala_nyeri">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="NRS"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->jenis_skala_nyeri == 1 ? 'selected' : '' }}>
                                            Numeric Rating Scale (NRS)
                                        </option>
                                        <option value="FLACC"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->jenis_skala_nyeri == 2 ? 'selected' : '' }}>
                                            Face, Legs, Activity, Cry, Consolability (FLACC)
                                        </option>
                                        <option value="CRIES"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->jenis_skala_nyeri == 3 ? 'selected' : '' }}>
                                            Crying, Requires, Increased, Expression, Sleepless (CRIES)
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                    <input type="text" class="form-control" id="nilai_skala_nyeri"
                                        name="nilai_skala_nyeri" readonly
                                        value="{{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) ? $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->nilai_nyeri : '' }}">
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                    <input type="hidden" class="form-control" id="kesimpulan_nyeri"
                                        name="kesimpulan_nyeri"
                                        value="{{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) ? $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->kesimpulan_nyeri : '' }}">
                                    <div class="alert alert-success" id="kesimpulan_nyeri_alert">
                                        {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) &&
                                        $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->kesimpulan_nyeri
                                            ? $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->kesimpulan_nyeri
                                            : 'Pilih skala nyeri terlebih dahulu' }}
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <h6 class="mb-3">Karakteristik Nyeri</h6>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" class="form-control" name="lokasi_nyeri"
                                                value="{{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) ? $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->lokasi : '' }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Durasi</label>
                                            <input type="text" class="form-control" name="durasi_nyeri"
                                                value="{{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) ? $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->durasi : '' }}">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label class="form-label">Jenis nyeri</label>
                                            <select class="form-select" name="jenis_nyeri">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($jenisnyeri as $jenis)
                                                    <option value="{{ $jenis->id }}"
                                                        {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->jenis_nyeri == $jenis->id ? 'selected' : '' }}>
                                                        {{ $jenis->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Frekuensi</label>
                                            <select class="form-select" name="frekuensi_nyeri">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($frekuensinyeri as $frekuensi)
                                                    <option value="{{ $frekuensi->id }}"
                                                        {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->frekuensi == $frekuensi->id ? 'selected' : '' }}>
                                                        {{ $frekuensi->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label class="form-label">Menjalar?</label>
                                            <select class="form-select" name="nyeri_menjalar">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($menjalar as $menjalarItem)
                                                    <option value="{{ $menjalarItem->id }}"
                                                        {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->menjalar == $menjalarItem->id ? 'selected' : '' }}>
                                                        {{ $menjalarItem->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Kualitas</label>
                                            <select class="form-select" name="kualitas_nyeri">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($kualitasnyeri as $kualitas)
                                                    <option value="{{ $kualitas->id }}"
                                                        {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->kualitas == $kualitas->id ? 'selected' : '' }}>
                                                        {{ $kualitas->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-md-6">
                                            <label class="form-label">Faktor pemberat</label>
                                            <select class="form-select" name="faktor_pemberat">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($faktorpemberat as $pemberat)
                                                    <option value="{{ $pemberat->id }}"
                                                        {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->faktor_pemberat == $pemberat->id ? 'selected' : '' }}>
                                                        {{ $pemberat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Faktor peringan</label>
                                            <select class="form-select" name="faktor_peringan">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($faktorperingan as $peringan)
                                                    <option value="{{ $peringan->id }}"
                                                        {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->faktor_peringan == $peringan->id ? 'selected' : '' }}>
                                                        {{ $peringan->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">Efek Nyeri</label>
                                            <select class="form-select" name="efek_nyeri">
                                                <option selected disabled>--Pilih--</option>
                                                @foreach ($efeknyeri as $efek)
                                                    <option value="{{ $efek->id }}"
                                                        {{ isset($asesmen->rmeAsesmenKepOphtamologyStatusNyeri) && $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->efek_nyeri == $efek->id ? 'selected' : '' }}>
                                                        {{ $efek->name }}
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
                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            data-bs-toggle="modal" data-bs-target="#penyakitModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedPenyakitList" class="d-flex flex-column gap-2">
                                            <!-- Empty state message -->
                                            <div id="emptyState"
                                                class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                <i class="ti-info-circle mb-2"></i>
                                                <p class="mb-0">Belum ada penyakit yang ditambahkan</p>
                                            </div>
                                        </div>
                                        <!-- Hidden input to store the JSON data -->
                                        <input type="hidden" name="penyakit_diderita" id="penyakitDideritaInput"
                                            value="{{ $asesmen->rmeAsesmenKepOphtamology->penyakit_yang_diderita ?? '[]' }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Riwayat Kesehatan Keluarga</label>
                                    <div class="w-100">
                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                            <!-- Empty state message -->
                                            <div id="emptyStateRiwayat"
                                                class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                <i class="ti-info-circle mb-2"></i>
                                                <p class="mb-0">Belum ada riwayat kesehatan keluarga yang
                                                    ditambahkan.</p>
                                            </div>
                                        </div>
                                        <!-- Hidden input to store the JSON data -->
                                        <input type="hidden" name="riwayat_kesehatan_keluarga"
                                            id="riwayatKesehatanInput"
                                            value="{{ $asesmen->rmeAsesmenKepOphtamology->riwayat_penyakit_keluarga ?? '[]' }}">
                                    </div>
                                </div>
                            </div>

                            {{-- 6. Riwayat Kesehatan --}}
                            <div class="section-separator" id="riwayatObat">
                                <h5 class="section-title">6. Riwayat Penggunaan Obat</h5>

                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                    id="openObatModal">
                                    <i class="ti-plus"></i> Tambah
                                </button>
                                <input type="hidden" name="riwayat_penggunaan_obat" id="riwayatObatData"
                                    value="{{ $asesmen->rmeAsesmenKepOphtamology->riwayat_penggunaan_obat ?? '[]' }}">
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

                            {{-- 7. Alergi sectio --}}
                            <div class="section-separator" id="alergi">
                                <h5 class="section-title">7. Alergi</h5>
                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                    id="openAlergiModal">
                                    <i class="ti-plus"></i> Tambah
                                </button>
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
                                <input type="hidden" name="alergis" id="alergisInput"
                                    value='{{ $asesmen->riwayat_alergi ?? '[]' }}'>

                            </div>

                            <!-- 16. Diagnosa -->
                            <div class="section-separator" id="diagnosis">
                                <h5 class="fw-semibold mb-4">8. Diagnosis</h5>

                                @php
                                    // Parse existing diagnosis data from database
                                    $diagnosisBanding = !empty(
                                        $asesmen->rmeAsesmenKepOphtamology[0]->diagnosis_banding
                                    )
                                        ? json_decode(
                                            $asesmen->rmeAsesmenKepOphtamology[0]->diagnosis_banding,
                                            true,
                                        )
                                        : [];
                                    $diagnosisKerja = !empty($asesmen->rmeAsesmenKepOphtamology[0]->diagnosis_kerja)
                                        ? json_decode($asesmen->rmeAsesmenKepOphtamology[0]->diagnosis_kerja, true)
                                        : [];
                                @endphp

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
                                        <input type="text" id="diagnosis-banding-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Diagnosis Banding">
                                        <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>

                                    <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                        <!-- Existing diagnosis will be loaded here -->
                                    </div>

                                    <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                        value="{{ json_encode($diagnosisBanding) }}">
                                </div>

                                <!-- Diagnosis Kerja -->
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                        diagnosis kerja yang tidak ditemukan.</small>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-secondary"></i>
                                        </span>
                                        <input type="text" id="diagnosis-kerja-input"
                                            class="form-control border-start-0 ps-0"
                                            placeholder="Cari dan tambah Diagnosis Kerja">
                                        <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                            <i class="bi bi-plus-circle text-primary"></i>
                                        </span>
                                    </div>

                                    <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                        <!-- Existing diagnosis will be loaded here -->
                                    </div>

                                    <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                        value="{{ json_encode($diagnosisKerja) }}">
                                </div>
                            </div>

<div class="section-separator" id="rencana_pengobatan">
                                <h5 class="fw-semibold mb-4">9. Rencana Penatalaksanaan Dan Pengobatan</h5>

                                    <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                        placeholder="Rencana Penatalaksanaan Dan Pengobatan">{{ old('rencana_pengobatan', isset($asesmen->rmeAsesmenKepOphtamology) ? $asesmen->rmeAsesmenKepOphtamology->rencana_pengobatan : '') }}</textarea>
                            </div>

                            <div class="section-separator" id="prognosis">
                                <h5 class="fw-semibold mb-4">10. Prognosis</h5>
                                    <select class="form-select" name="paru_prognosis">
                                        <option value="" disabled
                                            {{ !old(
                                                'paru_prognosis',
                                                isset($asesmen->rmeAsesmenKepOphtamology) ? $asesmen->rmeAsesmenKepOphtamology->paru_prognosis : '',
                                            )
                                                ? 'selected'
                                                : '' }}>
                                            --Pilih Prognosis--</option>
                                        @forelse ($satsetPrognosis as $item)
                                            <option value="{{ $item->prognosis_id }}"
                                                {{ old(
                                                    'paru_prognosis',
                                                    isset($asesmen->rmeAsesmenKepOphtamology) ? $asesmen->rmeAsesmenKepOphtamology->paru_prognosis : '',
                                                ) == $item->prognosis_id
                                                    ? 'selected'
                                                    : '' }}>
                                                {{ $item->value ?? 'Field tidak ditemukan' }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Tidak ada data</option>
                                        @endforelse
                                    </select>
                            </div>

                            {{-- 8. Alergi sectio --}}
                            <div class="section-separator" id="discharge-planning">
                                <h5 class="section-title">11. Discharge Planning</h5>

                                {{-- <div class="mb-4">
                                    <label class="form-label">Diagnosis medis</label>
                                    <input type="text" class="form-control" name="diagnosis_medis"
                                        placeholder="Diagnosis"
                                        value="{{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->diagnosis_medis ?? '' }}">
                                </div> --}}

                                <div class="mb-4">
                                    <label class="form-label">Usia lanjut</label>
                                    <select class="form-select" name="usia_lanjut">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="Ya"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->usia_lanjut === 'Ya' ? 'selected' : '' }}>
                                            Ya
                                        </option>
                                        <option value="Tidak"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->usia_lanjut === 'Tidak' ? 'selected' : '' }}>
                                            Tidak
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Hambatan mobilisasi</label>
                                    <select class="form-select" name="hambatan_mobilisasi">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="ya"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->hambatan_mobilisasi === 'ya' ? 'selected' : '' }}>
                                            Ya
                                        </option>
                                        <option value="tidak"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->hambatan_mobilisasi === 'tidak' ? 'selected' : '' }}>
                                            Tidak
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                    <select class="form-select" name="penggunaan_media_berkelanjutan">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="ya"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->membutuhkan_pelayanan_medis === 'ya' ? 'selected' : '' }}>
                                            Ya
                                        </option>
                                        <option value="tidak"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->membutuhkan_pelayanan_medis === 'tidak' ? 'selected' : '' }}>
                                            Tidak
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                        harian</label>
                                    <select class="form-select" name="ketergantungan_aktivitas">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="ya">Ya</option>
                                        <option value="tidak">Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus Setelah
                                        Pulang</label>
                                    <select class="form-select" name="keterampilan_khusus">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="ya"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_keterampilan_khusus === 'ya' ? 'selected' : '' }}>
                                            Ya
                                        </option>
                                        <option value="tidak"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_keterampilan_khusus === 'tidak' ? 'selected' : '' }}>
                                            Tidak
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                        Sakit</label>
                                    <select class="form-select" name="alat_bantu">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="ya"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_alat_bantu === 'ya' ? 'selected' : '' }}>
                                            Ya
                                        </option>
                                        <option value="tidak"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_alat_bantu === 'tidak' ? 'selected' : '' }}>
                                            Tidak
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                        Pulang</label>
                                    <select class="form-select" name="nyeri_kronis">
                                        <option selected disabled>--Pilih--</option>
                                        <option value="ya"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memiliki_nyeri_kronis === 'ya' ? 'selected' : '' }}>
                                            Ya
                                        </option>
                                        <option value="tidak"
                                            {{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) && $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memiliki_nyeri_kronis === 'tidak' ? 'selected' : '' }}>
                                            Tidak
                                        </option>
                                    </select>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Perkiraan lama hari dirawat</label>
                                        <input type="text" class="form-control" name="perkiraan_hari"
                                            placeholder="hari"
                                            value="{{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) ? $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->perkiraan_lama_dirawat : '' }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Tanggal Pulang</label>
                                        <input type="date" class="form-control" name="tanggal_pulang"
                                            value="{{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) ? $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->rencana_pulang : '' }}">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="form-label">KESIMPULAN</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="alert alert-info">

                                        </div>
                                        <div class="alert alert-warning">
                                            Mebutuhkan rencana pulang khusus
                                        </div>
                                        <div class="alert alert-success">
                                            Tidak mebutuhkan rencana pulang khusus
                                        </div>
                                    </div>
                                    <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                        value="{{ isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang) ? $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->kesimpulan : 'Tidak mebutuhkan rencana pulang khusus' }}">
                                </div>
                            </div>


                            {{-- Final section - Submit button --}}
                            <div class="text-end">
                                <x-button-submit>Perbarui</x-button-submit>
                            </div>
                        </div>
                    </form>
            </x-content-card>
        </div>
    </div>
    {{-- Include modals --}}
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.modal-skalanyeri')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.edit-modal-create-alergi')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.edit-modal-create-obat')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-opthamology.edit-modal-riwayat-penyakit')
@endsection
