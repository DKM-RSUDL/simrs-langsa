@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-paru.show-include')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('rawat-inap.asesmen.medis.paru.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $asesmen->id]) }}"
                    class="btn btn-sm btn-info">
                    <i class="fas fa-print"></i> print
                </a>
                <a href="{{ route('rawat-inap.asesmen.medis.paru.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $asesmen->id]) }}"
                    class="btn btn-sm btn-secondary ms-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Asesmen Awal Medis Paru</h5>
                    <p class="mb-0">Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan</p>
                </div>
                <div class="card-body">

                    <!-- 1. Data masuk -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">1. Data masuk</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Petugas:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->user->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tanggal Dan Jam Masuk:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenParu->tanggal ? date('d M Y H:i', strtotime($asesmen->rmeAsesmenParu->tanggal)) : '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Anamnesis -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">2. Anamnesis</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Anamnesa:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenParu->anamnesa ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Riwayat Penyakit:</label>
                                            <p class="form-control-plaintext border-bottom">
                                                {{ $asesmen->rmeAsesmenParu->riwayat_penyakit ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Alergi:</label>
                                            @if($asesmen->rmeAlergiPasien->isNotEmpty())
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 25%;">Jenis Alergi</th>
                                                                <th style="width: 25%;">Alergen</th>
                                                                <th style="width: 25%;">Reaksi</th>
                                                                <th style="width: 25%;">Tingkat Keparahan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($asesmen->rmeAlergiPasien as $alergi)
                                                                <tr>
                                                                    <td>{{ $alergi->jenis_alergi ?? '-' }}</td>
                                                                    <td>{{ $alergi->nama_alergi ?? '-' }}</td>
                                                                    <td>{{ $alergi->reaksi ?? '-' }}</td>
                                                                    <td>{{ $alergi->tingkat_keparahan ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="form-control-plaintext border-bottom">-</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Riwayat Penyakit Terdahulu Dan Riwayat Pengobatan -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">3. Riwayat Penyakit Terdahulu Dan Riwayat Pengobatan</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 50%;">Riwayat Penyakit Terdahulu (RPT)
                                                </th>
                                                <th class="text-center" style="width: 50%;">Riwayat Penggunaan Obat (RPO)
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="p-3">
                                                    {{ $asesmen->rmeAsesmenParu->riwayat_penyakit_terdahulu ?? '-' }}
                                                </td>
                                                <td class="p-3">
                                                    {{ $asesmen->rmeAsesmenParu->riwayat_penggunaan_obat ?? '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Kebiasaan -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">4. Kebiasaan</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="label-col fw-bold">a. Merokok</td>
                                                <td>
                                                    @if($asesmen->rmeAsesmenParu->merokok == 'ya')
                                                        <span class="badge bg-warning">Ya</span>
                                                        - Jumlah: {{ $asesmen->rmeAsesmenParu->merokok_jumlah ?? 0 }}
                                                        batang/hari
                                                        - Lama: {{ $asesmen->rmeAsesmenParu->merokok_lama ?? 0 }} tahun
                                                    @else
                                                        <span class="badge bg-success">Tidak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col fw-bold">b. Alkohol</td>
                                                <td>
                                                    @if($asesmen->rmeAsesmenParu->alkohol == 'ya')
                                                        <span class="badge bg-warning">Ya</span>
                                                        - Jumlah: {{ $asesmen->rmeAsesmenParu->alkohol_jumlah ?? '-' }}
                                                    @else
                                                        <span class="badge bg-success">Tidak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col fw-bold">c. Obat-obatan</td>
                                                <td>
                                                    @if($asesmen->rmeAsesmenParu->obat_obatan == 'ya')
                                                        <span class="badge bg-warning">Ya</span>
                                                        - Jenis: {{ $asesmen->rmeAsesmenParu->obat_jenis ?? '-' }}
                                                    @else
                                                        <span class="badge bg-success">Tidak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Tanda-Tanda Vital -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">5. Tanda-Tanda Vital</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="label-col fw-bold">a. Sensorium</td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        {{ ucfirst(str_replace('_', ' ', $asesmen->rmeAsesmenParu->sensorium ?? '-')) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col fw-bold">b. Keadaan umum</td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        {{ ucfirst($asesmen->rmeAsesmenParu->keadaan_umum ?? '-') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col fw-bold">c. Tekanan darah</td>
                                                <td>
                                                    {{ $asesmen->rmeAsesmenParu->darah_sistole ?? '-' }}/{{ $asesmen->rmeAsesmenParu->darah_diastole ?? '-' }}
                                                    mmHg
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col fw-bold">d. Nadi/pulse</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            {{ $asesmen->rmeAsesmenParu->nadi ?? '-' }} x/menit
                                                        </div>
                                                        <div class="col-lg-6">
                                                            Dyspnoe:
                                                            <span
                                                                class="badge {{ $asesmen->rmeAsesmenParu->dyspnoe == 'ya' ? 'bg-warning' : 'bg-success' }}">
                                                                {{ ucfirst($asesmen->rmeAsesmenParu->dyspnoe ?? 'Tidak') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col fw-bold">e. Frekuensi Pernafasan</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            {{ $asesmen->rmeAsesmenParu->frekuensi_pernafasan ?? '-' }}
                                                            x/menit
                                                            ({{ ucfirst($asesmen->rmeAsesmenParu->pernafasan_tipe ?? '-') }})
                                                        </div>
                                                        <div class="col-lg-6">
                                                            Cyanose:
                                                            <span
                                                                class="badge {{ $asesmen->rmeAsesmenParu->cyanose == 'ya' ? 'bg-warning' : 'bg-success' }}">
                                                                {{ ucfirst($asesmen->rmeAsesmenParu->cyanose ?? 'Tidak') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col fw-bold">f. Temperatur</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            {{ $asesmen->rmeAsesmenParu->temperatur ?? '-' }} °C
                                                        </div>
                                                        <div class="col-lg-4">
                                                            Oedema:
                                                            <span
                                                                class="badge {{ $asesmen->rmeAsesmenParu->oedema == 'ya' ? 'bg-warning' : 'bg-success' }}">
                                                                {{ ucfirst($asesmen->rmeAsesmenParu->oedema ?? 'Tidak') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label-col fw-bold">g. Saturasi Oksigen</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            {{ $asesmen->rmeAsesmenParu->saturasi_oksigen ?? '-' }}%
                                                        </div>
                                                        <div class="col-lg-4">
                                                            Icterus:
                                                            <span
                                                                class="badge {{ $asesmen->rmeAsesmenParu->icterus == 'ya' ? 'bg-warning' : 'bg-success' }}">
                                                                {{ ucfirst($asesmen->rmeAsesmenParu->icterus ?? 'Tidak') }}
                                                            </span>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            Anemia:
                                                            <span
                                                                class="badge {{ $asesmen->rmeAsesmenParu->anemia == 'ya' ? 'bg-warning' : 'bg-success' }}">
                                                                {{ ucfirst($asesmen->rmeAsesmenParu->anemia ?? 'Tidak') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Pemeriksaan Fisik -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">6. Pemeriksaan Fisik</h5>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-3 small bg-info bg-opacity-10 text-dark rounded-3 p-2">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Centang normal jika fisik yang dinilai normal. Jika tidak dipilih, maka pemeriksaan
                                    tidak dilakukan.
                                </p>

                                @if($asesmen->pemeriksaanFisik->count() > 0 && $itemFisik->count() > 0)
                                    <div class="row">
                                        @php
                                            // Buat mapping pemeriksaan fisik berdasarkan id_item_fisik
                                            $pemeriksaanFisikMap = [];
                                            foreach ($asesmen->pemeriksaanFisik as $item) {
                                                $pemeriksaanFisikMap[$item->id_item_fisik] = $item;
                                            }

                                            // Buat mapping nama item fisik
                                            $itemFisikNames = [];
                                            foreach ($itemFisik as $item) {
                                                $itemFisikNames[$item->id] = $item->nama;
                                            }

                                            // Bagi item fisik menjadi 2 kolom
                                            $totalItems = $itemFisik->count();
                                            $halfCount = ceil($totalItems / 2);
                                            $firstColumn = $itemFisik->take($halfCount);
                                            $secondColumn = $itemFisik->skip($halfCount);
                                        @endphp

                                        <!-- Kolom Pertama -->
                                        <div class="col-md-6">
                                            @foreach ($firstColumn as $fisikItem)
                                                @php
                                                    // Cek apakah item ini ada dalam pemeriksaan
                                                    $pemeriksaanItem = $pemeriksaanFisikMap[$fisikItem->id] ?? null;
                                                    $status = $pemeriksaanItem->is_normal ?? null;
                                                    $keterangan = $pemeriksaanItem->keterangan ?? '';
                                                    $namaItem = $fisikItem->nama;
                                                @endphp
                                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                    <span>{{ $namaItem }}</span>
                                                    <div class="d-flex align-items-center">
                                                        @if ($status === '0' || $status === 0)
                                                            <span class="badge bg-warning text-dark me-2">Tidak Normal</span>
                                                        @elseif ($status === '1' || $status === 1)
                                                            <span class="badge bg-success me-2">Normal</span>
                                                        @else
                                                            <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($keterangan && ($status === '0' || $status === 0))
                                                    <div class="mt-1 mb-2">
                                                        <small class="text-muted">Keterangan: {{ $keterangan }}</small>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <!-- Kolom Kedua -->
                                        <div class="col-md-6">
                                            @foreach ($secondColumn as $fisikItem)
                                                @php
                                                    // Cek apakah item ini ada dalam pemeriksaan
                                                    $pemeriksaanItem = $pemeriksaanFisikMap[$fisikItem->id] ?? null;
                                                    $status = $pemeriksaanItem->is_normal ?? null;
                                                    $keterangan = $pemeriksaanItem->keterangan ?? '';
                                                    $namaItem = $fisikItem->nama;
                                                @endphp
                                                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                                    <span>{{ $namaItem }}</span>
                                                    <div class="d-flex align-items-center">
                                                        @if ($status === '0' || $status === 0)
                                                            <span class="badge bg-warning text-dark me-2">Tidak Normal</span>
                                                        @elseif ($status === '1' || $status === 1)
                                                            <span class="badge bg-success me-2">Normal</span>
                                                        @else
                                                            <span class="badge bg-secondary me-2">Tidak Diperiksa</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($keterangan && ($status === '0' || $status === 0))
                                                    <div class="mt-1 mb-2">
                                                        <small class="text-muted">Keterangan: {{ $keterangan }}</small>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Data pemeriksaan fisik tidak tersedia.
                                        <br>
                                        <small class="text-muted">
                                            Debug Info:
                                            Pemeriksaan Fisik: {{ $asesmen->pemeriksaanFisik->count() }} item,
                                            Item Fisik: {{ $itemFisik->count() }} item
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 7. Rencana Kerja Dan Penatalaksanaan -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">7. Rencana Kerja Dan Penatalaksanaan</h5>
                        <div class="card">
                            <div class="card-body">
                                @if($asesmen->rmeAsesmenParuRencanaKerja)
                                    @php $rencanaKerja = $asesmen->rmeAsesmenParuRencanaKerja; @endphp
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">a. Foto thorax:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->foto_thoraks ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->foto_thoraks ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">b. Pemeriksaan darah rutin:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->darah_rutin ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->darah_rutin ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">c. Pemeriksaan LED:</label>
                                                <span class="badge {{ $rencanaKerja->led ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->led ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">d. Pemeriksaan sputum BTA:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->sputum_bta ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->sputum_bta ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">e. Pemeriksaan KGDS:</label>
                                                <span class="badge {{ $rencanaKerja->kgds ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->kgds ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">f. Pemeriksaan faal hati (LFT):</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->faal_hati ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->faal_hati ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">g. Pemeriksaan faal ginjal (RFG):</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->faal_ginjal ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->faal_ginjal ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">h. Pemeriksaan elektrolit:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->elektrolit ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->elektrolit ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">i. Pemeriksaan albumin:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->albumin ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->albumin ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="fw-bold">j. Pemeriksaan asam urat:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->asam_urat ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->asam_urat ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">k. Faal paru (APE, spirometri):</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->faal_paru ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->faal_paru ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">l. CT Scan thoraks:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->ct_scan_thoraks ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->ct_scan_thoraks ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">m. Bronchoscopy:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->bronchoscopy ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->bronchoscopy ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">n. Proef Punctie:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->proef_punctie ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->proef_punctie ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">o. Aspirasi cairan pleura:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->aspirasi_cairan_pleura ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->aspirasi_cairan_pleura ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">p. Penanganan WSD:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->penanganan_wsd ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->penanganan_wsd ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">q. Biopsi Kelenjar:</label>
                                                <span
                                                    class="badge {{ $rencanaKerja->biopsi_kelenjar ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->biopsi_kelenjar ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="fw-bold">r. Mantoux Tes:</label>
                                                <span class="badge {{ $rencanaKerja->mantoux_tes ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $rencanaKerja->mantoux_tes ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            @if($rencanaKerja->lainnya)
                                                <div class="mb-3">
                                                    <label class="fw-bold">s. Lainnya:</label>
                                                    <p class="form-control-plaintext border-bottom">
                                                        {{ $rencanaKerja->lainnya }}
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted">Data rencana kerja tidak tersedia</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 8. Perencanaan Pulang Pasien -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">8. Perencanaan Pulang Pasien (Discharge Planning)</h5>
                        <div class="card">
                            <div class="card-body">
                                @if($asesmen->rmeAsesmenParuPerencanaanPulang)
                                    @php $dischargePlanning = $asesmen->rmeAsesmenParuPerencanaanPulang; @endphp
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Diagnosis medis:</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $dischargePlanning->diagnosis_medis ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Usia lanjut (>60 th):</label>
                                                <span
                                                    class="badge {{ $dischargePlanning->usia_lanjut == '0' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $dischargePlanning->usia_lanjut == '0' ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Hambatan mobilitas:</label>
                                                <span
                                                    class="badge {{ $dischargePlanning->hambatan_mobilisasi == '0' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ $dischargePlanning->hambatan_mobilisasi == '0' ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Membutuhkan pelayanan medis
                                                    berkelanjutan:</label>
                                                <span
                                                    class="badge {{ $dischargePlanning->penggunaan_media_berkelanjutan == 'ya' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($dischargePlanning->penggunaan_media_berkelanjutan ?? 'Tidak') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Keteraturan dalam mengonsumsi obat dalam
                                                    aktivitas harian:</label>
                                                <span
                                                    class="badge {{ $dischargePlanning->ketergantungan_aktivitas == 'ya' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($dischargePlanning->ketergantungan_aktivitas ?? 'Tidak') }}
                                                </span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Rencana Pulang Khusus:</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $dischargePlanning->rencana_pulang_khusus ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Rencana Lama Perawatan:</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $dischargePlanning->rencana_lama_perawatan ?? '-' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Rencana Tanggal Pulang:</label>
                                                <p class="form-control-plaintext border-bottom">
                                                    {{ $dischargePlanning->rencana_tgl_pulang ? date('d M Y', strtotime($dischargePlanning->rencana_tgl_pulang)) : '-' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <label class="form-label fw-bold">KESIMPULAN:</label>
                                        <div
                                            class="alert {{ strpos(strtolower($dischargePlanning->kesimpulan_planing ?? ''), 'tidak membutuhkan') !== false ? 'alert-success' : 'alert-warning' }}">
                                            {{ $dischargePlanning->kesimpulan_planing ?? 'Tidak ada kesimpulan' }}
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted">Data perencanaan pulang tidak tersedia</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 9. Diagnosis -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">9. Diagnosis</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Diagnosis Banding:</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis banding yang tidak ditemukan.</small>
                                            @php
                                                $diagnosisBanding = [];
                                                $diagnosisKerja = [];
                                                $observasi = [];
                                                $terapeutik = [];
                                                $edukasi = [];
                                                $kolaborasi = [];
                                                $prognosis = [];

                                                if ($asesmen->rmeAsesmenParuDiagnosisImplementasi) {
                                                    $implementasi = $asesmen->rmeAsesmenParuDiagnosisImplementasi;
                                                    $diagnosisBanding = json_decode($implementasi->diagnosis_banding ?? '[]', true);
                                                    $diagnosisKerja = json_decode($implementasi->diagnosis_kerja ?? '[]', true);
                                                    $observasi = json_decode($implementasi->observasi ?? '[]', true);
                                                    $terapeutik = json_decode($implementasi->terapeutik ?? '[]', true);
                                                    $edukasi = json_decode($implementasi->edukasi ?? '[]', true);
                                                    $kolaborasi = json_decode($implementasi->kolaborasi ?? '[]', true);
                                                    $prognosis = json_decode($implementasi->prognosis ?? '[]', true);
                                                }
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
                                            <label class="form-label fw-bold">Diagnosis Kerja:</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis kerja yang tidak ditemukan.</small>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($diagnosisKerja))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Diagnosis Kerja</th>
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

                                @if($asesmen->rmeAsesmenParuDiagnosisImplementasi && $asesmen->rmeAsesmenParuDiagnosisImplementasi->gambar_radiologi_paru)
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Gambar Radiologi Paru:</label>
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $asesmen->rmeAsesmenParuDiagnosisImplementasi->gambar_radiologi_paru) }}"
                                                        alt="Gambar Radiologi Paru" class="img-fluid rounded border"
                                                        style="max-width: 500px; max-height: 250px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- 10. Implementasi -->
                    <div class="section-separator mb-4">
                        <h5 class="section-title">10. Implementasi</h5>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan Pengobatan</label>
                                    <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                        rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                        rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Observasi:</label>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($observasi))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Observasi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($observasi as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item }}</td>
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
                                            <label class="form-label fw-bold">Terapeutik:</label>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($terapeutik))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Terapeutik</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($terapeutik as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item }}</td>
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
                                            <label class="form-label fw-bold">Edukasi:</label>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($edukasi))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Edukasi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($edukasi as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item }}</td>
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
                                            <label class="form-label fw-bold">Kolaborasi:</label>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($kolaborasi))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Kolaborasi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($kolaborasi as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item }}</td>
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
                                            <label class="form-label fw-bold">Prognosis:</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan Prognosis yang tidak ditemukan.</small>
                                            @php
                                                // Already defined above
                                            @endphp

                                            @if (!empty($prognosis))
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Prognosis</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($prognosis as $index => $item)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $item }}</td>
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

                </div>
            </div>
        </div>
    </div>
@endsection
