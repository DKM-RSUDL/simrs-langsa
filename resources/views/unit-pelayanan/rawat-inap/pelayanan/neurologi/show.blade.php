@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.neurologi.show-include')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                <div>
                    <a href="{{ route('rawat-inap.asesmen.medis.neurologi.print-pdf', [
                        $asesmen->kd_unit,
                        $asesmen->pasien->kd_pasien,
                        \Carbon\Carbon::parse($asesmen->tgl_masuk)->format('Y-m-d'),
                        $asesmen->urut_masuk,
                        $asesmen->id
                    ]) }}" class="btn btn-outline-primary" target="_blank">
                        <i class="bi bi-printer"></i>
                        Print PDF
                    </a>
                </div>
            </div>

            <div class="">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Asesmen Awal Medis Neurologi</h5>
                    <p>Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan</p>
                </div>
                <div class="card-body">
                    <!-- Informasi Dasar -->
                    <div class="mb-4">

                        <!--  Anamnesis -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>Anamnesis</h5>

                                        <!-- Keluhan Utama -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Keluhan utama/ Alasan masuk RS :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenNeurologi->keluhan_utama ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Riwayat Penyakit Sekarang -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat penyakit sekarang :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenNeurologi->riwayat_penyakit_sekarang ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Riwayat Penyakit Terdahulu -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat penyakit terdahulu :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenNeurologi->riwayat_penyakit_terdahulu ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Riwayat Penyakit Keluarga -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat penyakit dalam keluarga :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenNeurologi->riwayat_penyakit_keluarga ?? '-' }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Riwayat Pengobatan -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Riwayat Pengobatan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    @if ($asesmen->rmeAsesmenNeurologi->riwayat_pengobatan === 0)
                                                        <span class="badge bg-secondary">Tidak Ada</span>
                                                    @elseif ($asesmen->rmeAsesmenNeurologi->riwayat_pengobatan === 1)
                                                        <span class="badge bg-info">Ada</span>
                                                        @if ($asesmen->rmeAsesmenNeurologi->riwayat_pengobatan_keterangan)
                                                            <br><span
                                                                class="mt-1 d-inline-block">{{ $asesmen->rmeAsesmenNeurologi->riwayat_pengobatan_keterangan }}</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-secondary">Tidak Diketahui</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Riwayat Alergi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>Riwayat Alergi</h5>
                                        <div class="col-md-12">
                                            @php
                                                $alergiData = [];
                                                if ($asesmen->rmeAsesmenNeurologi->riwayat_alergi) {
                                                    $alergiData = json_decode(
                                                        $asesmen->rmeAsesmenNeurologi->riwayat_alergi,
                                                        true,
                                                    );
                                                }
                                            @endphp

                                            @if (!empty($alergiData))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Jenis</th>
                                                                <th>Alergen</th>
                                                                <th>Reaksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($alergiData as $index => $alergi)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $alergi['jenis'] ?? '-' }}</td>
                                                                    <td>{{ $alergi['alergen'] ?? '-' }}</td>
                                                                    <td>{{ $alergi['reaksi'] ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="form-control-plaintext border-bottom">
                                                    <span class="text-muted">Tidak ada data alergi</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Pemeriksaan Fisik -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>Status Present</h5>

                                        <!-- Status Present -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tekanan Darah (mmHg) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenNeurologi->tekanan_darah ?? '-' }} mmHg
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nadi (Per Menit) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenNeurologi->nadi ?? '-' }} x/menit
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Suhu (°C) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenNeurologi->suhu ?? '-' }} °C
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Respirasi (Per Menit) :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenNeurologi->respirasi ?? '-' }} x/menit
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Pemeriksaan Fisik Lainnya -->
                                        @if ($asesmen->pemeriksaanFisik->isNotEmpty())
                                            <div class="col-12">
                                                <h6 class="mt-3 mb-3">Pemeriksaan Fisik</h6>
                                                <p class="mb-3 small bg-info bg-opacity-10 text-dark rounded-3 p-2">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    Centang normal jika fisik yang dinilai normal. Jika tidak dipilih, maka
                                                    pemeriksaan tidak dilakukan.
                                                </p>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    @php
                                                        $pemeriksaanFisikData = $asesmen->pemeriksaanFisik;
                                                        $itemFisikNames = [];
                                                        foreach ($itemFisik as $item) {
                                                            $itemFisikNames[$item->id] = $item->nama;
                                                        }

                                                        $totalItems = count($pemeriksaanFisikData);
                                                        $halfCount = ceil($totalItems / 2);
                                                        $firstColumn = $pemeriksaanFisikData->take($halfCount);
                                                        $secondColumn = $pemeriksaanFisikData->skip($halfCount);
                                                    @endphp
                                                    <div class="col-md-6">
                                                        @foreach ($firstColumn as $item)
                                                            @php
                                                                $status = $item->is_normal;
                                                                $keterangan = $item->keterangan;
                                                                $itemId = $item->id_item_fisik;
                                                                $namaItem =
                                                                    $itemFisikNames[$itemId] ?? 'Item #' . $itemId;
                                                            @endphp
                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                                <span>{{ $namaItem }}</span>
                                                                <div class="d-flex align-items-center">
                                                                    @if ($status == '0' || $status == 0)
                                                                        <span class="badge bg-warning text-dark me-2">Tidak
                                                                            Normal</span>
                                                                    @elseif ($status == '1' || $status == 1)
                                                                        <span class="badge bg-success me-2">Normal</span>
                                                                    @else
                                                                        <span class="badge bg-secondary me-2">Tidak
                                                                            Diperiksa</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if ($keterangan && ($status == '0' || $status == 0))
                                                                <div class="mt-1 mb-2">
                                                                    <small class="text-muted">Keterangan:
                                                                        {{ $keterangan }}</small>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="col-md-6">
                                                        @foreach ($secondColumn as $item)
                                                            @php
                                                                $status = $item->is_normal;
                                                                $keterangan = $item->keterangan;
                                                                $itemId = $item->id_item_fisik;
                                                                $namaItem =
                                                                    $itemFisikNames[$itemId] ?? 'Item #' . $itemId;
                                                            @endphp
                                                            <div
                                                                class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                                <span>{{ $namaItem }}</span>
                                                                <div class="d-flex align-items-center">
                                                                    @if ($status == '0' || $status == 0)
                                                                        <span class="badge bg-warning text-dark me-2">Tidak
                                                                            Normal</span>
                                                                    @elseif ($status == '1' || $status == 1)
                                                                        <span class="badge bg-success me-2">Normal</span>
                                                                    @else
                                                                        <span class="badge bg-secondary me-2">Tidak
                                                                            Diperiksa</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @if ($keterangan && ($status == '0' || $status == 0))
                                                                <div class="mt-1 mb-2">
                                                                    <small class="text-muted">Keterangan:
                                                                        {{ $keterangan }}</small>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Sistem Syaraf -->
                        @if ($asesmen->rmeAsesmenNeurologiSistemSyaraf)
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>Sistem Syaraf</h5>

                                            <!-- Kesadaran -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">Kesadaran</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Kesadaran Kualitatif
                                                                :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Kesadaran Kuantitatif (GCS)
                                                                :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                E:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif_e ?? '-' }},
                                                                M:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif_m ?? '-' }},
                                                                V:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif_v ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Pupil -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">Pupil</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Isokor/anisokor :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_isokor ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Diameter :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_anisokor ?? '-' }}
                                                                mm
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Refleks cahaya :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                Kiri:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_cahaya_kiri ?? '-' }}
                                                                /
                                                                Kanan:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_cahaya_kanan ?? '-' }}
                                                            </p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Refleks kornea :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                Kiri:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_kornea_kiri ?? '-' }}
                                                                /
                                                                Kanan:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_kornea_kanan ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Nervus Cranialis -->
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Nervus Cranialis :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->nervus_cranialis ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Ekstremitas dan Refleks -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">Ekstremitas & Refleks</h6>

                                                <div class="table-responsive mb-4">
                                                    <table class="table table-bordered">
                                                        <thead class="bg-light">
                                                            <tr>
                                                                <th></th>
                                                                <th>Atas Kanan</th>
                                                                <th>Atas Kiri</th>
                                                                <th>Bawah Kanan</th>
                                                                <th>Bawah Kiri</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="fw-bold">Ekstremitas Gerakan</td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_atas ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_kanan ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_bawah ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_kiri ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Refleks</td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_atas ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_kanan ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_bawah ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_kiri ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Refleks Patologis</td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_atas ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_kanan ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_bawah ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_kiri ?? '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Kekuatan</td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_atas ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_kanan ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_bawah ?? '-' }}
                                                                </td>
                                                                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_kiri ?? '-' }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Tes Bilateral -->
                                                <div class="row mb-4">
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Klonus :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                Kiri:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->klonus_kiri ?? '-' }}
                                                                /
                                                                Kanan:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->klonus_kanan ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Laseque :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                Kiri:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->laseque_kiri ?? '-' }}
                                                                /
                                                                Kanan:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->laseque_kanan ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Patrick :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                Kiri:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->patrick_kiri ?? '-' }}
                                                                /
                                                                Kanan:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->patrick_kanan ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Kontra Patrick :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                Kiri:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kontra_kiri ?? '-' }}
                                                                /
                                                                Kanan:
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kontra_kanan ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tes Meningeal -->
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Kaku Kuduk :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kaku_kuduk ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Tes Brudzinski :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tes_brudzinski ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Tanda Kernig :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tanda_kerning ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tanda Cerebellum -->
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Nistagmus :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->nistagmus ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Dismitri :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->dismitri ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Disdiadokokinesis :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->disdiadokokinesis ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tes Koordinasi -->
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Tes Romberg :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tes_romberg ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Ataksia :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ataksia ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Cara Berjalan :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->cara_berjalan ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Gerakan Involunter -->
                                                <div class="row mb-4">
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Tremor :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tremor ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Khorea :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->khorea ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Balismus :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->balismus ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Atetose :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->atetose ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Sensibilitas dan Fungsi Vegetatif -->
                                                <div class="row mb-4">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Sensibilitas :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->sensibilitas ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Miksi :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->miksi ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Defekasi :</label>
                                                            <p class="form-control-plaintext border-bottom">
                                                                {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->defekasi ?? '-' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- 6. Intensitas Nyeri -->
                        @if ($asesmen->rmeAsesmenNeurologiIntensitasNyeri)
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>Intensitas Nyeri</h5>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Skala Nyeri :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        <span
                                                            class="badge {{ $asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri > 5 ? 'bg-danger' : ($asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri > 3 ? 'bg-warning' : 'bg-success') }}">
                                                            {{ $asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri ?? '0' }}/10
                                                        </span>
                                                        <span class="ms-2">
                                                            @if (($asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri ?? 0) == 0)
                                                                Tidak Nyeri
                                                            @elseif (($asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri ?? 0) <= 3)
                                                                Nyeri Ringan
                                                            @elseif (($asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri ?? 0) <= 6)
                                                                Nyeri Sedang
                                                            @else
                                                                Nyeri Berat
                                                            @endif
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- 8. Diagnosis -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>Diagnosis</h5>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis Banding :</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk
                                                    mencari
                                                    diagnosis banding,
                                                    apabila tidak ada, Pilih tanda tambah untuk menambah
                                                    keterangan diagnosis banding yang tidak ditemukan.</small>
                                                @php
                                                    $diagnosisBanding = json_decode(
                                                        $asesmen->rmeAsesmenNeurologiIntensitasNyeri->diagnosis_banding ?? '[]',
                                                        true,
                                                    );
                                                @endphp

                                                @if (!empty($diagnosisBanding))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Diagnosis Banding</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($diagnosisBanding as $index => $diagnosis)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $diagnosis }}</td>
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
                                                <label class="form-label fw-bold">Diagnosis Kerja :</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk
                                                    mencari
                                                    diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                    keterangan diagnosis kerja yang tidak ditemukan.</small>
                                                @php
                                                    $diagnosisKerja = json_decode(
                                                        $asesmen->rmeAsesmenNeurologiIntensitasNyeri->diagnosis_kerja ?? '[]',
                                                        true,
                                                    );
                                                @endphp

                                                @if (!empty($diagnosisKerja))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Diagnosis Banding</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($diagnosisKerja as $index => $diagnosis)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $diagnosis }}</td>
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

                        <!-- 10. Implementasi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>Implementasi</h5>
                                        <p>Rencana Penatalaksanaan dan Pengobatan</p>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                            rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Observasi :</label>
                                                @php
                                                    $observasi = json_decode(
                                                        $asesmen->rmeAsesmenNeurologiIntensitasNyeri->observasi ??
                                                            '[]',
                                                        true,
                                                    );
                                                @endphp

                                                @if (!empty($observasi))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Diagnosis Banding</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($observasi as $index => $diagnosis)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $diagnosis }}</td>
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
                                                <label class="form-label fw-bold">Terapeutik :</label>
                                                @php
                                                    $terapeutik = json_decode(
                                                        $asesmen->rmeAsesmenNeurologiIntensitasNyeri->terapeutik ??
                                                            '[]',
                                                        true,
                                                    );
                                                @endphp

                                                @if (!empty($terapeutik))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Diagnosis Banding</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($terapeutik as $index => $diagnosis)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $diagnosis }}</td>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Edukasi :</label>
                                                @php
                                                    $edukasi = json_decode(
                                                        $asesmen->rmeAsesmenNeurologiIntensitasNyeri->edukasi ??
                                                            '[]',
                                                        true,
                                                    );
                                                @endphp

                                                @if (!empty($edukasi))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Diagnosis Banding</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($edukasi as $index => $diagnosis)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $diagnosis }}</td>
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
                                                <label class="form-label fw-bold">Kolaborasi :</label>
                                                @php
                                                    $kolaborasi = json_decode(
                                                        $asesmen->rmeAsesmenNeurologiIntensitasNyeri->kolaborasi ??
                                                            '[]',
                                                        true,
                                                    );
                                                @endphp

                                                @if (!empty($kolaborasi))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Diagnosis Banding</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($kolaborasi as $index => $diagnosis)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $diagnosis }}</td>
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Prognosis :</label>
                                                <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk
                                                    mencari
                                                    Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                    keterangan
                                                    Prognosis yang tidak ditemukan.</small>
                                                @php
                                                    $prognosis = json_decode(
                                                        $asesmen->rmeAsesmenNeurologiIntensitasNyeri->prognosis ??
                                                            '[]',
                                                        true,
                                                    );
                                                @endphp

                                                @if (!empty($prognosis))
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Diagnosis Banding</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($prognosis as $index => $diagnosis)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $diagnosis }}</td>
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

                        <!-- 7. Discharge Planning -->
                        @if ($asesmen->rmeAsesmenNeurologiDischargePlanning)
                            <div class="tab-pane fade show">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <h5>Discharge Planning</h5>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Usia lanjut (> 60 th) :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->usia_lanjut == 'ya' ? 'Ya' : 'Tidak' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Hambatan mobilisasi :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->hambatan_mobilisasi == 'ya' ? 'Ya' : 'Tidak' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Membutuhkan pelayanan medis
                                                        berkelanjutan
                                                        :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->pelayanan_medis == 'ya' ? 'Ya' : 'Tidak' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Ketergantungan dengan orang lain
                                                        dalam
                                                        aktivitas harian :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->ketergantungan == 'ya' ? 'Ya' : 'Tidak' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Rencana Pulang Khusus :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_pulang_khusus ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Rencana Lama Perawatan :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_lama_perawatan ?? '-' }}
                                                        hari
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Rencana Tanggal Pulang :</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        @if ($asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_tanggal_pulang)
                                                            {{ date('d M Y', strtotime($asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_tanggal_pulang)) }}
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
                        @endif

                        <!-- 11. Evaluasi -->
                        <div class="tab-pane fade show">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>Evaluasi</h5>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Evaluasi Keperawatan :</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $asesmen->rmeAsesmenNeurologi->evaluasi_evaluasi_keperawatan ?? '-' }}
                                                </p>
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
    </div>
@endsection
