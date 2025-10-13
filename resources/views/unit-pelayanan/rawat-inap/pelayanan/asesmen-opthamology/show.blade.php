@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Detail Asesmen Awal Medis Opthamology',
                    'description' => 'Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])
                    <!-- Informasi Dasar -->
                    <div class="mb-4">
                        <!-- 1. Data masuk -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>1. Data masuk</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Petugas :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->user->name ?? '-' }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tanggal Dan Jam Masuk :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ date('d M Y H:i', strtotime($asesmen->waktu_asesmen)) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Masuk :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamology->diagnosis_masuk ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kondisi Masuk :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamology->kondisi_masuk ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Barang Berharga :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamology->barang_berharga ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Anamnesis -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>2. Anamnesis</h5>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Anamnesis :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->anamnesis ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Pemeriksaan fisik -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>3. Pemeriksaan fisik</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tek. Darah (mmHg) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    Sistole: {{ $asesmen->rmeAsesmenKepOphtamologyFisik->sistole ?? '-' }}
                                                    mmHg<br>
                                                    Diastole: {{ $asesmen->rmeAsesmenKepOphtamologyFisik->diastole ?? '-' }}
                                                    mmHg
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nadi (Per Menit) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->nadi ?? '-' }} x/menit
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nafas (Per Menit) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->nafas ?? '-' }} x/menit
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Suhu (C) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->suhu ?? '-' }} °C
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Saturasi O2 :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    Tanpa bantuan:
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->spo2_tanpa_bantuan ?? '-' }}%<br>
                                                    Dengan bantuan:
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->spo2_dengan_bantuan ?? '-' }}%
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">AVPU :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->avpu ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <h5>Kondisi Fisik</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Sensorium :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->sensorium ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Anemis :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->anemis == 1 ? 'Ya' : 'Tidak' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Ikhterik :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->ikhterik == 1 ? 'Ya' : 'Tidak' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Dyspnoe :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->dyspnoe == 1 ? 'Ya' : 'Tidak' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Sianosis :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->sianosis == 1 ? 'Ya' : 'Tidak' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Edema :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->edema == 1 ? 'Ya' : 'Tidak' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Anthropometry section -->
                                    <div class="row mt-4">
                                        <h5>Antropometri</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tinggi Badan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->tinggi_badan ?? '-' }} cm
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Berat Badan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyFisik->berat_badan ?? '-' }} kg
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pemeriksaan Fisik Komprehensif -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>Pemeriksaan Fisik</h5>
                                            <p class="mb-3 small bg-info text-white rounded-3 p-2">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Hasil pemeriksaan fisik menyeluruh. Status pemeriksaan ditandai sebagai
                                                Normal jika tidak ditemukan kelainan pada saat pemeriksaan.
                                            </p>
                                        </div>

                                        @php
                                            $pemeriksaanFisikData = $asesmen->pemeriksaanFisik ?? collect([]);
                                            $totalItems = $pemeriksaanFisikData->count();
                                            $halfCount = ceil($totalItems / 2);
                                            $firstColumn = $pemeriksaanFisikData->take($halfCount);
                                            $secondColumn = $pemeriksaanFisikData->skip($halfCount);
                                        @endphp

                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @foreach ($firstColumn as $item)
                                                        <div
                                                            class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                            <span
                                                                class="fw-medium">{{ $item->itemFisik->nama ?? '' }}</span>
                                                            <div class="d-flex align-items-center gap-2">
                                                                @if ($item->is_normal)
                                                                    <span class="badge bg-success">Normal</span>
                                                                @else
                                                                    @if ($item->keterangan)
                                                                        <span class="badge bg-warning text-dark">Tidak
                                                                            Normal</span>
                                                                        <span
                                                                            class="text-muted small">{{ $item->keterangan }}</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Tidak
                                                                            Diperiksa</span>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="col-md-6">
                                                    @foreach ($secondColumn as $item)
                                                        <div
                                                            class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                            <span
                                                                class="fw-medium">{{ $item->itemFisik->nama ?? '' }}</span>
                                                            <div class="d-flex align-items-center gap-2">
                                                                @if ($item->is_normal)
                                                                    <span class="badge bg-success">Normal</span>
                                                                @else
                                                                    @if ($item->keterangan)
                                                                        <span class="badge bg-warning text-dark">Tidak
                                                                            Normal</span>
                                                                        <span
                                                                            class="text-muted small">{{ $item->keterangan }}</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Tidak
                                                                            Diperiksa</span>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Pemeriksaan Mata Komprehensif -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>4. Pemeriksaan Mata Komprehensif</h5>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">RPT :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->rpt ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">RPO :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->rpo ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">AVOD :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->avod ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">AVOS :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->avos ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">TIO TOD :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tio_tod ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">TIO TOS :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tio_tos ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">KMB Oculi Dextra :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->kmb_oculi_dextra ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">KMB Oculi Sinistra :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->kmb_oculi_sinistra ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <h5 class="mt-4">Data Refraksi</h5>
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>SPH</th>
                                                            <th>CYL</th>
                                                            <th>Menjadi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><strong>Oculi Dextra</strong></td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->sph_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->cyl_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->menjadi_oculi_dextra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Oculi Sinistra</strong></td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->sph_oculi_sinistra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->cyl_oculi_sinistra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->menjadi_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <h5 class="mt-4">Pemeriksaan Lengkap Mata</h5>
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Parameter</th>
                                                            <th>Oculi Dextra</th>
                                                            <th>Oculi Sinistra</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Visus</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->visus_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->visus_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Koreksi</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->koreksi_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->koreksi_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Subyektif</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->subyektif_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->subyektif_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Obyektif</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->obyektif_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->obyektif_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>TIO</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tio_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tio_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Posisi</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->posisi_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->posisi_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Palpebra</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->palpebra_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->palpebra_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Inferior</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->inferior_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->inferior_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tars Superior</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tars_superior_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tars_superior_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tars Inferior</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tars_inferior_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->tars_inferior_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bulbi</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->bulbi_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->bulbi_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sclera</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->sclera_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->sclera_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cornea</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->cornea_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->cornea_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Anterior</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->anterior_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->anterior_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pupil</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->pupil_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->pupil_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Iris</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->iris_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->iris_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Lensa</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->lensa_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->lensa_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Vitreous</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->vitreous_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->vitreous_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Media</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->media_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->media_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Papil</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->papil_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->papil_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Macula</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->macula_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->macula_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Retina</td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->retina_oculi_dextra ?? '-' }}
                                                            </td>
                                                            <td>{{ $asesmen->rmeAsesmenKepOphtamologyKomprehensif->retina_oculi_sinistra ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Status Nyeri -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>5. Status Nyeri</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Skala Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $jenisSkala =
                                                            $asesmen->rmeAsesmenKepOphtamologyStatusNyeri
                                                                ->jenis_skala_nyeri ?? '';
                                                        $skalaText = '';
                                                        switch ($jenisSkala) {
                                                            case 1:
                                                                $skalaText = 'Numeric Rating Scale (NRS)';
                                                                break;
                                                            case 2:
                                                                $skalaText =
                                                                    'Face, Legs, Activity, Cry, Consolability (FLACC)';
                                                                break;
                                                            case 3:
                                                                $skalaText =
                                                                    'Crying, Requires, Increased, Expression, Sleepless (CRIES)';
                                                                break;
                                                            default:
                                                                $skalaText = '-';
                                                        }
                                                    @endphp
                                                    {{ $skalaText }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nilai Skala Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->nilai_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyStatusNyeri->kesimpulan_nyeri ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Karakteristik Nyeri -->
                                    <div class="row mt-4">
                                        <h6 class="mb-3">Karakteristik Nyeri</h6>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Lokasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ optional($asesmen->rmeAsesmenKepOphtamologyStatusNyeri)->lokasi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Durasi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ optional($asesmen->rmeAsesmenKepOphtamologyStatusNyeri)->durasi ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Jenis Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = optional(
                                                            $asesmen->rmeAsesmenKepOphtamologyStatusNyeri,
                                                        );
                                                        $jenisNyeriId = $statusNyeri->jenis_nyeri ?? null;
                                                    @endphp

                                                    @if ($jenisNyeriId)
                                                        @foreach ($jenisnyeri as $jenis)
                                                            @if ($jenis->id == $jenisNyeriId)
                                                                {{ $jenis->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Frekuensi :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = optional(
                                                            $asesmen->rmeAsesmenKepOphtamologyStatusNyeri,
                                                        );
                                                        $frekuensiId = $statusNyeri->frekuensi ?? null;
                                                    @endphp

                                                    @if ($frekuensiId)
                                                        @foreach ($frekuensinyeri as $frekuensi)
                                                            @if ($frekuensi->id == $frekuensiId)
                                                                {{ $frekuensi->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Menjalar :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepOphtamologyStatusNyeri;
                                                        $menjalarId = $statusNyeri ? $statusNyeri->menjalar : null;
                                                    @endphp

                                                    @if ($menjalarId)
                                                        @foreach ($menjalar as $men)
                                                            @if ($men->id == $menjalarId)
                                                                {{ $men->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kualitas :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepOphtamologyStatusNyeri;
                                                        $kualitasId = $statusNyeri ? $statusNyeri->kualitas : null;
                                                    @endphp

                                                    @if ($kualitasId)
                                                        @foreach ($kualitasnyeri as $kualitas)
                                                            @if ($kualitas->id == $kualitasId)
                                                                {{ $kualitas->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Faktor Pemberat :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepOphtamologyStatusNyeri;
                                                        $faktorPemberatId = $statusNyeri
                                                            ? $statusNyeri->faktor_pemberat
                                                            : null;
                                                    @endphp

                                                    @if ($faktorPemberatId)
                                                        @foreach ($faktorpemberat as $pemberat)
                                                            @if ($pemberat->id == $faktorPemberatId)
                                                                {{ $pemberat->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Faktor Peringan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepOphtamologyStatusNyeri;
                                                        $faktorPeringanId = $statusNyeri
                                                            ? $statusNyeri->faktor_peringan
                                                            : null;
                                                    @endphp

                                                    @if ($faktorPeringanId)
                                                        @foreach ($faktorperingan as $peringan)
                                                            @if ($peringan->id == $faktorPeringanId)
                                                                {{ $peringan->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Efek Nyeri :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @php
                                                        $statusNyeri = $asesmen->rmeAsesmenKepOphtamologyStatusNyeri;
                                                        $efekNyeriId = $statusNyeri ? $statusNyeri->efek_nyeri : null;
                                                    @endphp

                                                    @if ($efekNyeriId)
                                                        @foreach ($efeknyeri as $efek)
                                                            @if ($efek->id == $efekNyeriId)
                                                                {{ $efek->name }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Riwayat Kesehatan -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>6. Riwayat Kesehatan</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Penyakit Yang Pernah Diderita :</label>
                                                @php
                                                    $penyakitDiderita = json_decode(
                                                        $asesmen->rmeAsesmenKepOphtamology->penyakit_yang_diderita ??
                                                            '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($penyakitDiderita))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Nama Penyakit</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($penyakitDiderita as $index => $penyakit)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $penyakit }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Kesehatan Keluarga :</label>
                                                @php
                                                    $riwayatKeluarga = json_decode(
                                                        $asesmen->rmeAsesmenKepOphtamology->riwayat_penyakit_keluarga ??
                                                            '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($riwayatKeluarga))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Riwayat Kesehatan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($riwayatKeluarga as $index => $riwayat)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $riwayat }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Penggunaan Obat :</label>
                                                @php
                                                    $riwayatObat = json_decode(
                                                        $asesmen->rmeAsesmenKepOphtamology->riwayat_penggunaan_obat ??
                                                            '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($riwayatObat))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Nama Obat</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($riwayatObat as $index => $obat)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $obat }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Alergi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>7. Alergi</h5>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Alergi :</label>
                                                @php
                                                    $alergis = json_decode($asesmen->riwayat_alergi ?? '[]', true);
                                                @endphp

                                                @if (!empty($alergis))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Jenis</th>
                                                                    <th>Alergen</th>
                                                                    <th>Reaksi</th>
                                                                    <th>Tingkat Keparahan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($alergis as $alergi)
                                                                    <tr>
                                                                        <td>{{ $alergi['jenis'] ?? '-' }}</td>
                                                                        <td>{{ $alergi['alergen'] ?? '-' }}</td>
                                                                        <td>{{ $alergi['reaksi'] ?? '-' }}</td>
                                                                        <td>{{ $alergi['keparahan'] ?? '-' }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span class="text-muted">Tidak ada riwayat alergi</span>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 9. Diagnosis -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>8. Diagnosis</h5>
                                        <div class="col-md-12">
                                            <!-- Diagnosis Banding -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Diagnosis Banding</label>
                                                @php
                                                    $diagnosisBanding = json_decode(
                                                        $asesmen->rmeAsesmenKepOphtamology->diagnosis_banding ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($diagnosisBanding))
                                                    <div class="bg-light p-3 rounded">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($diagnosisBanding as $diagnosis)
                                                                <li class="mb-2">
                                                                    <span
                                                                        class="badge bg-info">{{ $diagnosis }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom text-muted">
                                                        Tidak ada diagnosis banding
                                                    </p>
                                                @endif
                                            </div>

                                            <!-- Diagnosis Kerja -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Diagnosis Kerja</label>
                                                @php
                                                    $diagnosisKerja = json_decode(
                                                        $asesmen->rmeAsesmenKepOphtamology->diagnosis_kerja ?? '[]',
                                                        true,
                                                    );
                                                @endphp
                                                @if (!empty($diagnosisKerja))
                                                    <div class="bg-light p-3 rounded">
                                                        <ul class="list-unstyled mb-0">
                                                            @foreach ($diagnosisKerja as $diagnosis)
                                                                <li class="mb-2">
                                                                    <span
                                                                        class="badge bg-success">{{ $diagnosis }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <p class="form-control-plaintext border-bottom text-muted">
                                                        Tidak ada diagnosis kerja
                                                    </p>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>9. Rencana Penatalaksanaan Dan Pengobatan</h5>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="form-control" name="rencana_pengobatan" rows="4"
                                                    placeholder="Rencana Penatalaksanaan Dan Pengobatan" readonly>{{ old('rencana_pengobatan', isset($asesmen->rmeAsesmenKepOphtamology) ? $asesmen->rmeAsesmenKepOphtamology->rencana_pengobatan : '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>10. Prognosis</h5>
                                        <div class="col-md-12">
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">Prognosis</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamology->prognosis ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 8. Discharge Planning -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>11. Discharge Planning</h5>
                                        <div class="col-md-6">
                                            {{-- <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Medis</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->diagnosis_medis ?? '-' }}
                                                </p>
                                            </div> --}}

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Usia Lanjut</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang->usia_lanjut) &&
                                                            $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->usia_lanjut !== null)
                                                        {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->usia_lanjut == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Hambatan Mobilisasi</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang->hambatan_mobilisasi) &&
                                                            $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->hambatan_mobilisasi !== null)
                                                        {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->hambatan_mobilisasi == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Membutuhkan Pelayanan Medis</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang->membutuhkan_pelayanan_medis) &&
                                                            $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->membutuhkan_pelayanan_medis !== null)
                                                        {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->membutuhkan_pelayanan_medis == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Keterampilan Khusus</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_keterampilan_khusus) &&
                                                            $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_keterampilan_khusus !== null)
                                                        {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_keterampilan_khusus == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Alat Bantu</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_alat_bantu) &&
                                                            $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_alat_bantu !== null)
                                                        {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memerlukan_alat_bantu == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nyeri Kronis</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memiliki_nyeri_kronis) &&
                                                            $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memiliki_nyeri_kronis !== null)
                                                        {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->memiliki_nyeri_kronis == 0 ? 'Ya' : 'Tidak' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Perkiraan Lama Dirawat</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang->perkiraan_lama_dirawat) &&
                                                            $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->perkiraan_lama_dirawat !== null)
                                                        {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->perkiraan_lama_dirawat ?? '-' }}
                                                        Hari
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Rencana Tanggal Pulang</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if (isset($asesmen->rmeAsesmenKepOphtamologyRencanaPulang->rencana_pulang) &&
                                                            $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->rencana_pulang !== null)
                                                        {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->rencana_pulang ? \Carbon\Carbon::parse($asesmen->rmeAsesmenKepOphtamologyRencanaPulang->rencana_pulang)->format('d M Y') : '-' }}
                                                    @else
                                                        -
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Kesimpulan</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenKepOphtamologyRencanaPulang->kesimpulan ?? '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

            </x-content-card>
        </div>
    </div>
@endsection


@push('css')
    <style>
        .badge {
            font-size: 0.8rem;
            padding: 0.35em 0.65em;
        }

        .border-bottom {
            border-color: #dee2e6 !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .fw-medium {
            font-weight: 500 !important;
        }

        .py-2 {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }
    </style>
@endpush
