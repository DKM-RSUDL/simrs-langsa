@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-ranap')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-header text-center">
                        <h5 class="card-title fw-bold">Detail Resume Medis</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Anamnesis/ Keluhan Utama</label>
                                <textarea class="form-control" rows="3" id="anamnesis">{{ $dataResume->anamnesis ?? '-' }}</textarea>

                                <div class="mt-4">
                                    <strong class="fw-bold">Pemeriksaan Fisik</strong>
                                    <div class="bg-light p-3 border rounded">
                                        <div class="row">
                                            <div class="col-6 col-md-4">
                                                <small>TD:
                                                    {{ $vitalSign->sistole ?? '__' }} /
                                                    {{ $vitalSign->diastole ?? '__' }} mmHg
                                                </small><br>
                                                <small>Temp: {{ $vitalSign->suhu ?? '__' }}
                                                    C</small><br>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <small>
                                                    RR:
                                                    {{ $vitalSign->respiration ?? '__' }}
                                                    x/mnt
                                                </small><br>
                                                <small>Nadi: {{ $vitalSign->nadi ?? '__' }}
                                                    x/mnt</small>
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <small>TB:
                                                    {{ $vitalSign->tinggi_badan ?? '__' }}
                                                    M</small><br>
                                                <small>BB:
                                                    {{ $vitalSign->berat_badan ?? '__' }}
                                                    Kg</small><br>
                                            </div>
                                        </div>

                                    </div>

                                    <textarea class="form-control mt-2" rows="3" id="pemeriksaan_fisik">{{ $dataResume->pemeriksaan_fisik ?? '' }}</textarea>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Hasil Pemeriksaan Laboratorium</strong>
                                    <div class="bg-light p-3 border rounded">
                                        <div style="max-height: 200px; overflow-y: auto;">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Pemeriksaan</th>
                                                        <th>Tgl</th>
                                                        <th>Status</th>
                                                        <th>Hasil</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $counter = 1; @endphp
                                                    @foreach ($dataLabor as $order)
                                                        @foreach ($order->details as $detail)
                                                            <tr>
                                                                <td>{{ $counter }}</td>
                                                                <td>
                                                                    {{ $detail->produk->deskripsi ?? 'Tidak ada deskripsi' }}
                                                                </td>
                                                                <td>
                                                                    {{ \Carbon\Carbon::parse($order->tgl_order)->format('d M Y H:i') }}
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $statusOrder = $order->status_order;
                                                                        $statusLabel = '';

                                                                        if ($statusOrder == 0) {
                                                                            $statusLabel = 'Diproses';
                                                                        }
                                                                        if ($statusOrder == 1) {
                                                                            $statusLabel = 'Diorder';
                                                                        }
                                                                        if ($statusOrder == 2) {
                                                                            $statusLabel = 'Selesai';
                                                                        }
                                                                    @endphp

                                                                    {!! $statusLabel !!}
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn-view-labor-create"
                                                                        data-kd-order="{{ $order->kd_order }}"
                                                                        data-nomor="{{ $counter }}"
                                                                        data-nama-pemeriksaan="{{ $detail->produk->deskripsi ?? 'Pemeriksaan' }}"
                                                                        data-klasifikasi="{{ $detail->labResults[$detail->produk->deskripsi]['klasifikasi'] ?? 'Tidak ada klasifikasi' }}">
                                                                        Lihat Hasil
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @php $counter++; @endphp
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Hasil Pemeriksaan Radiologi</strong>
                                    <div class="bg-light p-3 border rounded">
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            <table class="table table-bordered table-hover">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>Pemeriksaan</th>
                                                        <th>Tgl</th>
                                                        <th>Status</th>
                                                        {{-- <th>Hasil</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $counter = 1;
                                                    @endphp
                                                    @foreach ($dataRadiologi as $order)
                                                        @foreach ($order->details as $radiologi)
                                                            <tr>
                                                                <td>{{ $counter++ }}</td>
                                                                <td>
                                                                    {{ $radiologi->produk->deskripsi ?? 'Tidak ada deskripsi' }}
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($radiologi->tgl_order)->format('d M Y H:i') }}
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $statusOrder = $radiologi->status_order;
                                                                        $statusLabel = '';

                                                                        if ($statusOrder == 0) {
                                                                            $statusLabel = 'Diproses';
                                                                        }
                                                                        if ($statusOrder == 1) {
                                                                            $statusLabel = 'Diorder';
                                                                        }
                                                                        if ($statusOrder == 2) {
                                                                            $statusLabel = 'Selesai';
                                                                        }
                                                                    @endphp

                                                                    {!! $statusLabel !!}
                                                                </td>
                                                                {{-- <td><a href="#">Lihat Hasil</a></td> --}}
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Hasil Pemeriksaan Laboratorium</strong>
                                    <textarea class="form-control" id="pemeriksaan_penunjang" rows="3">{{ $dataResume->pemeriksaan_penunjang ?? '' }}</textarea>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Hasil Pemeriksaan Radiologi</strong>
                                    <textarea class="form-control" id="pemeriksaan_rad" rows="3">
                                        @if (!empty($dataResume->pemeriksaan_rad))
                                            {{ $dataResume->pemeriksaan_rad }}
                                        @else
                                            @foreach ($radHasil as $item)
                                                {{ $item['hasil'] }}
                                            @endforeach
                                        @endif
                                    </textarea>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">
                                        Diagnosis
                                        <a href="javascript:void(0)"
                                            class="text-secondary text-decoration-none fw-bold ms-3" id="btn-diagnosis">
                                            <i class="bi bi-plus-square"></i> Tambah
                                        </a>
                                    </strong>

                                    <div class="bg-light p-3 border rounded">
                                        <div style="max-height: 150px; overflow-y: auto;" id="diagnoseDisplay">
                                            <div class="diagnosis-list">
                                                <!-- Items will be inserted here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Kode ICD 10 (Koder)
                                        <a href="javascript:void(0)"
                                            class="text-secondary text-decoration-none fw-bold ms-3" id="btn-kode-icd">
                                            <i class="bi bi-plus-square"></i> Tambah
                                        </a>
                                    </strong>
                                    <div class="bg-light p-3 border rounded">
                                        <ul class="list" id="icdList">
                                            <!-- Kode ICD akan ditambahkan di sini -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <strong class="fw-bold">Tindakan/Prosedur</strong>
                                <div class="bg-light p-3 border rounded">
                                    <div style="max-height: 150px; overflow-y: auto;">
                                        <ol type="1">
                                            @foreach ($tindakan as $tind)
                                                <li>
                                                    {{ $tind->produk->deskripsi }}
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Kode ICD-9 CM (Koder)
                                        <a href="javascript:void(0)"
                                            class="text-secondary text-decoration-none fw-bold ms-3" id="btn-kode-icd9">
                                            <i class="bi bi-plus-square"></i> Tambah</a>
                                    </strong>
                                    <div class="bg-light p-3 border rounded">
                                        <ul class="list" id="icd9List">
                                            {{-- Daftar Kode ICD-9 akan muncul di sini --}}
                                        </ul>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Resep Obat Dirawat</strong>
                                    <div class="bg-light p-3 border rounded">
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>Nama Obat</th>
                                                            <th>Frek</th>
                                                            <th>Dosis</th>
                                                            {{-- <th>Qty</th> --}}
                                                            {{-- <th>Rate</th> --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach ($riwayatObatHariIni as $obat)
                                                            {{-- <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>
                                                                    {{ $obat->nama_obat ?? '-' }}
                                                                </td>
                                                                <td>{{ $obat->jumlah_takaran }}
                                                                    {{ $obat->satuan_takaran }}
                                                                </td>
                                                                <td>{{ explode(',', $obat->cara_pakai)[0] }}</td>
                                                                <td>{{ (int) $obat->jumlah ?? '-' }}</td>
                                                                <td>-</td>
                                                            </tr> --}}

                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>
                                                                    {{ $obat->nama_obat ?? '-' }}
                                                                </td>
                                                                <td>{{ $obat->frekuensi }}</td>
                                                                <td>{{ $obat->dosis }}
                                                                    {{ $obat->satuan }}
                                                                </td>
                                                                {{-- <td>{{ $obat->freak ?? '-' }}</td>
                                                                <td>-</td> --}}
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Resep Obat Pulang</strong>
                                    <div class="bg-light p-3 border rounded">
                                        <div style="max-height: 150px; overflow-y: auto;">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead class="table-secondary">
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>Nama Obat</th>
                                                            <th>Dosis</th>
                                                            <th>Frek</th>
                                                            <th>Qty</th>
                                                            <th>Rate</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($resepPulang as $obat)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>
                                                                    {{ $obat->nama_obat ?? '-' }}
                                                                </td>
                                                                <td>{{ $obat->jumlah_takaran }}
                                                                    {{ $obat->satuan_takaran }}
                                                                </td>
                                                                <td>{{ explode(',', $obat->cara_pakai)[0] }}</td>
                                                                <td>{{ (int) $obat->jumlah ?? '-' }}</td>
                                                                <td>-</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Anjuran/Follow up</strong>

                                    <div class="form-group">
                                        <label for="anjuran_diet" class="form-label">Diet</label>
                                        <textarea class="form-control" id="anjuran_diet" rows="3">{{ $dataResume->anjuran_diet ?? '-' }}</textarea>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="anjuran_edukasi" class="form-label">Edukasi</label>
                                        <textarea class="form-control" id="anjuran_edukasi" rows="3">{{ $dataResume->anjuran_edukasi ?? '-' }}</textarea>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Tindak Lanjut</strong>
                                    <div class="bg-light p-3 border rounded">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btn-sembuh-ulang"
                                                        class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                        <input type="radio" id="sembuh" name="tindak_lanjut_name"
                                                            class="form-check-input me-2" value="sembuh" data-code="12"
                                                            {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '12' ? 'checked' : '' }}>
                                                        <label for="sembuh">Sembuh</label>
                                                    </a>
                                                    <a href="javascript:void(0)" id="btn-berobat_jalan-ulang"
                                                        class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                        <input type="radio" id="berobat_jalan"
                                                            name="tindak_lanjut_name" class="form-check-input me-2"
                                                            value="Dapat berobat jalan" data-code="13"
                                                            {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '13' ? 'checked' : '' }}>
                                                        <label for="berobat_jalan">Dapat berobat jalan</label>
                                                    </a>
                                                    <a href="javascript:void(0)" id="btn-paps-ulang"
                                                        class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                        <input type="radio" id="paps" name="tindak_lanjut_name"
                                                            class="form-check-input me-2" value="PAPS" data-code="14"
                                                            {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '14' ? 'checked' : '' }}>
                                                        <label for="paps">PAPS</label>
                                                    </a>
                                                </div>

                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btn-rs-rujuk-bagian"
                                                        class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                        <input type="radio" id="rujuk" name="tindak_lanjut_name"
                                                            class="form-check-input me-2" value="Rujuk RS lain bagian:"
                                                            data-code="5"
                                                            {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '5' ? 'checked' : '' }}>
                                                        <label for="rujuk">Rujuk RS lain bagian:
                                                            <span id="selected-rs-info">
                                                                @if (($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '5')
                                                                    {{ $dataResume->rmeResumeDet->rs_rujuk ?? '' }}
                                                                    ({{ $dataResume->rmeResumeDet->rs_rujuk_bagian ?? '' }})
                                                                @endif
                                                            </span>
                                                        </label>
                                                    </a>
                                                    <a href="javascript:void(0)" id="btn-meninggal-kurang48"
                                                        class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                        <label for="meninggal_kurang48">
                                                            <input type="radio" id="meninggal_kurang48"
                                                                name="tindak_lanjut_name" class="form-check-input me-2"
                                                                value="Meninggal kurang dari 48 Jam" data-code="15"
                                                                {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '15' ? 'checked' : '' }}>
                                                            Meninggal kurang dari 48
                                                            Jam
                                                    </a>
                                                    </label>
                                                    <a href="javascript:void(0)" id="btn-meninggal-lebih48"
                                                        class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                        <label for="meninggal_lebih48">
                                                            <input type="radio" id="meninggal_lebih48"
                                                                name="tindak_lanjut_name" class="form-check-input me-2"
                                                                value="Meninggal lebih dari 48 Jam" data-code="16"
                                                                {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '16' ? 'checked' : '' }}>
                                                            Meninggal lebih dari 48 Jam
                                                    </a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Kondisi Saat Pulang</strong>

                                    <div class="bg-light p-3 border rounded">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btnMandiri"
                                                        class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                        <input type="radio" id="mandiri" name="kondisi_saat_pulang"
                                                            class="form-check-input me-2" value="1" @checked($dataResume->kondisi_saat_pulang == 1)>
                                                        <label for="mandiri">Mandiri</label>
                                                    </a>
                                                </div>

                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btnTidakMandiri"
                                                        class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                        <input type="radio" id="tidakMandiri" name="kondisi_saat_pulang"
                                                            class="form-check-input me-2" value="2" @checked($dataResume->kondisi_saat_pulang == 2)>
                                                        <label for="tidakMandiri">Tidak Mandiri
                                                            <span id="selected-kondisi-pulang-info">
                                                                {{ !empty($dataResume->keterangan_kondisi_pulang) ? ": $dataResume->keterangan_kondisi_pulang" : '' }}
                                                            </span>
                                                        </label>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Pengobatan Lanjutan</strong>

                                    <div class="bg-light p-3 border rounded">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btnPoliLanjutan"
                                                        class="pengobatan-lanjutan d-block mb-2 text-decoration-none">
                                                        <input type="radio" id="poli-lanjutan" name="pengobatan_lanjutan"
                                                            class="form-check-input me-2" value="1" @checked($dataResume->pengobatan_lanjutan == 1)>
                                                        <label for="poli-lanjutan">Poli
                                                            <span id="poli-lanjutan-info">
                                                                {{ !empty($dataResume->poliPengobatanLanjutan->nama_unit) ? ": $dataResume->tgl_pengobatan_lanjutan -- {$dataResume->poliPengobatanLanjutan->nama_unit}" : '' }}
                                                            </span>
                                                        </label>
                                                    </a>
                                                </div>

                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btnPuskesmas"
                                                        class="pengobatan-lanjutan d-block mb-2 text-decoration-none">
                                                        <input type="radio" id="puskesmas-lanjutan" name="pengobatan_lanjutan"
                                                            class="form-check-input me-2" value="2" @checked($dataResume->pengobatan_lanjutan == 2)>
                                                        <label for="puskesmas-lanjutan">Puskesmas</label>
                                                    </a>
                                                </div>

                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btnRSlain"
                                                        class="pengobatan-lanjutan d-block mb-2 text-decoration-none">
                                                        <input type="radio" id="rslain-lanjutan" name="pengobatan_lanjutan"
                                                            class="form-check-input me-2" value="3" @checked($dataResume->pengobatan_lanjutan == 3)>
                                                        <label for="rslain-lanjutan">RS Lain
                                                            <span id="rs-lain-info">
                                                                {{ !empty($dataResume->rs_pengobatan_lanjutan) ? ": $dataResume->rs_pengobatan_lanjutan" : '' }}
                                                            </span>
                                                        </label>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <strong class="fw-bold">Terjadi Kedaruratan hubungi :</strong>

                                    <div class="bg-light p-3 border rounded">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btnRsTerdekat"
                                                        class="kedaruratan d-block mb-2 text-decoration-none">
                                                        <input type="checkbox" id="rs-terdekat" name="kedaruratan[]"
                                                            class="form-check-input me-2" value="1" @checked($dataResume->kedaruratan == 1)>
                                                        <label for="rs-terdekat">RS Terdekat
                                                            <span id="rs-terdekat-info">
                                                                {{-- {{ !empty($dataResume->poliPengobatanLanjutan->nama_unit) ? ": $dataResume->tgl_kedaruratan -- {$dataResume->poliPengobatanLanjutan->nama_unit}" : '' }} --}}
                                                            </span>
                                                        </label>
                                                    </a>
                                                </div>

                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btnPuskesmasTerdekat"
                                                        class="kedaruratan d-block mb-2 text-decoration-none">
                                                        <input type="checkbox" id="puskesmas-terdekat" name="kedaruratan[]"
                                                            class="form-check-input me-2" value="2" @checked($dataResume->kedaruratan == 2)>
                                                        <label for="puskesmas-terdekat">Puskesmas, klinik terdekat</label>
                                                    </a>
                                                </div>

                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" id="btnPetugasKesehatan"
                                                        class="kedaruratan d-block mb-2 text-decoration-none">
                                                        <input type="checkbox" id="petugasKesTerdekat" name="kedaruratan[]"
                                                            class="form-check-input me-2" value="3" @checked($dataResume->kedaruratan == 3)>
                                                        <label for="petugasKesTerdekat">Petugas Kesehatan Terdekat
                                                            <span id="petugasKesTerdekatInfo">
                                                                {{ !empty($dataResume->rs_kedaruratan) ? ": $dataResume->rs_kedaruratan" : '' }}
                                                            </span>
                                                        </label>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('rawat-inap.rawat-inap-resume.pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($dataResume->id)]) }}"
                            target="_blank" class="btn btn-sm btn-info">
                            <i class="bi bi-printer"></i>
                            Print
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" id="update">Ubah</button>
                        {{-- <button type="button" class="btn btn-sm btn-success" id="btnValidate">Validasi</button> --}}
                        <a href="{{ route('resume.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))]) }}"
                            class="btn btn-sm btn-secondary">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- MODAL TIDAK MANDIRI --}}
    <div class="modal fade" id="modalTidakMandiri" tabindex="-1" aria-labelledby="modalTidakMandiriLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTidakMandiriLabel">Kondisi Pulang Tidak Mandiri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="rs-rujuk" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keteranganTidakMandiri" name="keterangan_tidak_mandiri"
                        value="{{ $dataResume->keterangan_kondisi_pulang }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanTidakMandiri">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL RS LAIN LANJUTAN --}}
    <div class="modal fade" id="modalRSlain" tabindex="-1" aria-labelledby="modalRSlainLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalRSlainLabel">RS Lain Pengobatan Lanjutan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="rsPengobatanLanjutan" class="form-label">Nama RS</label>
                    <input type="text" class="form-control" id="rsPengobatanLanjutan" name="rs_pengobatan_lanjutan"
                        value="{{ $dataResume->rs_pengobatan_lanjutan }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSimpanRsLain">Simpan</button>
                </div>
            </div>
        </div>
    </div>


    @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-create-diagnosi')
    @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-input-diagnosis')
    @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-kode-icd')
    @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-kode-icd9')
    {{-- @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-konsul-rujukan') --}}
    {{-- @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-create-alergi') --}}
    @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-view-labor-create')
    @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-kontrol-ulang')
    @include('unit-pelayanan.rawat-inap.pelayanan.resume.resume-medis.components.modal-rs-rujuk-bagian')
@endsection


@push('js')
    <script>
        $('#btn-edit-resume').on('click', function() {
            $('#modal-edit-resume').modal('show');
        });

        $('.tindak-lanjut-option').on('click', function(e) {
            e.preventDefault();
            $(this).find('input[type="radio"]').prop('checked', true);
        });

        // validasi
        $('#btnValidate').click(function(e) {
            let $this = $(this);
            let resumeId = "{{ encrypt($dataResume->id) }}";

            Swal.fire({
                title: "Konfirmasi",
                text: "Apakah anda yakin ingin validasi resume ? Resume yang telah divalidasi tidak dapat dirubah kembali",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "post",
                        url: "{{ route('resume.validasi', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            resume_id: resumeId
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $this.html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                            );
                            $this.prop('disabled', true);
                        },
                        success: function(res) {
                            let status = res.status;
                            let msg = res.message;

                            if (status == 'error') {
                                Swal.fire({
                                    title: "Error",
                                    text: msg,
                                    icon: "error",
                                    allowOutsideClick: false
                                });

                                return false;
                            }

                            Swal.fire({
                                title: "Success",
                                text: 'Resume berhasil di validasi !',
                                icon: "success",
                                allowOutsideClick: false
                            });

                            window.location.reload();
                        },
                        complete: function() {
                            $this.html('Validasi');
                            $this.prop('disabled', false);
                        },
                        error: function() {
                            Swal.fire({
                                title: "Error",
                                text: "Internal Server Error !",
                                icon: "error"
                            });
                        }
                    });

                }
            });

        });

        // simpan data
        $('#update').click(function(e) {
            e.preventDefault();

            const tindakLanjutElement = $('input[name="tindak_lanjut_name"]:checked');
            if (!tindakLanjutElement.length) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Error',
                    text: 'Mohon pilih tindak lanjut terlebih dahulu'
                });
                return false;
            }

            const kondisiPulangEl = $('input[name="kondisi_saat_pulang"]:checked');
            const pengobatanLanjutanEl = $('input[name="pengobatan_lanjutan"]:checked');
            // if (!kondisiPulangEl.length) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Validasi Error',
            //         text: 'Mohon pilih kondisi saat pulang terlebih dahulu'
            //     });
            //     return false;
            // }

            const resume_id = '{{ $dataResume->id ?? null }}';

            // Deklarasi di awal script
            const previousTglKontrolUlang = '{{ $dataResume->rmeResumeDet->tgl_kontrol_ulang ?? '' }}';
            const previousRsRujukBagian = '{{ $dataResume->rmeResumeDet->rs_rujuk_bagian ?? '' }}';
            const previousRsRujuk = '{{ $dataResume->rmeResumeDet->rs_rujuk ?? '' }}';
            const previousUnitRujukInternal = '{{ $dataResume->rmeResumeDet->unit_rujuk_internal ?? '' }}';


            // Ambil resume_id, biarkan null jika tidak ada
            if (!resume_id || resume_id === 'null') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Resume Tidak Tersedia',
                    text: 'Data resume belum tersedia. Silahkan buat resume baru terlebih dahulu.',
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!validateForm()) {
                return;
            }
            let formData = new FormData();

            formData.append('anamnesis', $('#anamnesis').val().trim());
            formData.append('pemeriksaan_fisik', $('#pemeriksaan_fisik').val().trim());
            formData.append('pemeriksaan_penunjang', $('#pemeriksaan_penunjang').val().trim());
            formData.append('pemeriksaan_rad', $('#pemeriksaan_rad').val().trim());


            // Ambil diagnosis berdasarkan urutan saat ini dari diagnosis-list
            // Di bagian ajax untuk menyimpan ke database
            if (dataDiagnosis.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Minimal satu diagnosis harus diisi'
                });
                return;
            }
            formData.append('diagnosis', JSON.stringify(dataDiagnosis));
            // return false;


            // Get ICD-10 data
            formData.append('penyakit', JSON.stringify(penyakitList));

            // Get ICD-9 data
            const icd9Array = $('#icd9List').children()
                .map(function() {
                    return $(this).text().trim().split(' ')[0];
                }).get().filter(Boolean);

            formData.append('icd_9', JSON.stringify(icd9Array));

            // Get control ulang tgl - only if "Kontrol ulang" is selected
            let ControlUlangTgl = null;

            if (tindakLanjutElement.length && tindakLanjutElement.data('code') == '2') {
                // Only get date if "Kontrol ulang" option is selected
                ControlUlangTgl = $('#selected-date').text().trim() || previousTglKontrolUlang;
                // Validate if it's a proper date, not text like "sembuh"
                if (ControlUlangTgl && (ControlUlangTgl === 'sembuh' || ControlUlangTgl === 'meninggal' ||
                        ControlUlangTgl.includes('Jam'))) {
                    ControlUlangTgl = null; // Don't send invalid date strings
                }
            }

            if (ControlUlangTgl) {
                formData.append('tgl_kontrol_ulang', ControlUlangTgl);
            }

            // Get Rujuk RS lain bagian
            const RujukRSBagian = $('#selected-rs-info').text().trim();
            let rs_rujuk_bagian, rs_rujuk;
            if (RujukRSBagian) {
                const parts = RujukRSBagian.split(' - ');
                rs_rujuk_bagian = parts[0].trim() || previousRsRujukBagian;
                rs_rujuk = parts.length > 1 ? parts[1].trim() || previousRsRujuk : previousRsRujuk;
            } else {
                rs_rujuk_bagian = previousRsRujukBagian;
                rs_rujuk = previousRsRujuk;
            }
            formData.append('rs_rujuk_bagian', rs_rujuk_bagian);
            formData.append('rs_rujuk', rs_rujuk);

            // Ambil ID unit dari atribut data-unit-id
            const unitId = $('#selected-unit-tujuan').attr('data-unit-id') || previousUnitRujukInternal;
            // console.log('Sending unit_rujuk_internal:', unitId);
            formData.append('unit_rujuk_internal', unitId);

            // Get Alergi
            const Alergirray = $('#list-alergi').children()
                .map(function() {
                    return $(this).text();
                }).get().filter(Boolean);
            formData.append('alergi', JSON.stringify(Alergirray));

            // Use the tindakLanjutElement that was already defined above
            formData.append('tindak_lanjut_name', tindakLanjutElement.val());
            formData.append('tindak_lanjut_code', tindakLanjutElement.data('code'));

            formData.append('anjuran_diet', $('#anjuran_diet').val().trim());
            formData.append('anjuran_edukasi', $('#anjuran_edukasi').val().trim());


            // KONDISI SAAT PULANG
            let kondisiPulangVal = kondisiPulangEl.attr('value');
            formData.append('kondisi_saat_pulang', kondisiPulangVal);
            let kondisiPulangKeterangan = '';

            if(kondisiPulangVal == '2') {
                kondisiPulangKeterangan = $('#keteranganTidakMandiri').val();
                if (!kondisiPulangKeterangan) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Error',
                        text: 'Mohon lengkapi keterangan kondisi saat pulang terlebih dahulu'
                    });
                    return false;
                }
            }

            formData.append('keterangan_kondisi_pulang', kondisiPulangKeterangan);


            // PENGOBATAN LANJUTAN
            let pengobatanLanjutanVal = pengobatanLanjutanEl.attr('value');
            formData.append('pengobatan_lanjutan', pengobatanLanjutanVal);

            formData.append('rs_pengobatan_lanjutan', $('#rsPengobatanLanjutan').val());
            formData.append('poli_pengobatan_lanjutan', $('#unit-kontrol').val());
            formData.append('tgl_pengobatan_lanjutan', $('#kontrol-ulang').val());

            formData.append('_method', 'PUT');


            // Show konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengubah data resume ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve, reject) => {

                        let urlUpdate =
                            `{{ route('rawat-inap.rawat-inap-resume.update', [
                                'kd_unit' => $dataMedis->kd_unit,
                                'kd_pasien' => $dataMedis->kd_pasien,
                                'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'),
                                'urut_masuk' => $dataMedis->urut_masuk,
                                'id' => ':id',
                            ]) }}`
                            .replace(':id', resume_id);

                        $.ajax({
                                url: urlUpdate,
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                }
                            })
                            .done(response => resolve(response))
                            .fail(xhr => reject(xhr));
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    const response = result.value;
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            $('#modal-edit-resume').modal('hide');
                            // window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan saat memperbarui data.'
                        });
                    }
                }
            }).catch(error => {
                console.error('Error details:', error);
                let errorMessage = "Terjadi kesalahan saat memperbarui data.";
                if (error.responseJSON) {
                    if (error.responseJSON.errors) {
                        errorMessage = Object.values(error.responseJSON.errors).join("\n");
                    } else if (error.responseJSON.message) {
                        errorMessage = error.responseJSON.message;
                    }
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            });
        });

        // Form validation function
        function validateForm() {
            const requiredFields = {
                'anamnesis': 'Anamnesis',
                // 'pemeriksaan_penunjang': 'Pemeriksaan Penunjang'
            };
            let isValid = true;

            // Check required fields
            for (const [fieldId, fieldName] of Object.entries(requiredFields)) {
                const value = $(`#${fieldId}`).val().trim();
                if (!value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Error',
                        text: `${fieldName} wajib diisi`
                    });
                    return false;
                }
            }

            // Check tindak lanjut
            const tindakLanjutChecked = $('input[name="tindak_lanjut_name"]:checked').length > 0;
            if (!tindakLanjutChecked) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Error',
                    text: 'Mohon pilih tindak lanjut terlebih dahulu'
                });
                return false;
            }

            return true;
        }

        // Helper function
        function sanitizeInput(input) {
            return input ? input.trim() : '';
        }

        $('input[name="tindak_lanjut_name"]').on('change', function() {
            console.log('Radio button changed:', $(this).val());
            console.log('Code:', $(this).data('code'));
        });

        // TIDAK MANDIRI

        $('#btnTidakMandiri').on('click', function(e) {
            let $this = $(this);
            // Check radio button
            $this.find('input[type="radio"]').prop('checked', true);
            // Tampilkan modal
            $('#modalTidakMandiri').modal('show');
        });

        $('#btnSimpanTidakMandiri').on('click', function() {
            let keterangan = $('#keteranganTidakMandiri').val();

            if (keterangan) {
                updateTidakMandiriDisplay(keterangan);
                $('#modalTidakMandiri').modal('hide');
            } else {
                alert('Silahkan lengkapi data Keterangan Tidak Mandiri');
            }
        });

        // Fungsi untuk update tampilan rujukan
        function updateTidakMandiriDisplay(keterangan) {
            // Update span di modal utama
            $('#selected-kondisi-pulang-info').text(`: ${keterangan}`);
            // Check radio button
            $('#tidakMandiri').prop('checked', true);
        }

        // PENGOBATAN LANJUTAN
        $('#btnRSlain').click(function() {
            $('#modalRSlain').modal('show');
        });

        $('#btnSimpanRsLain').click(() => {
            let keterangan = $('#rsPengobatanLanjutan').val();

            if (keterangan) {
                // Update span di modal utama
                $('#rs-lain-info').text(`: ${keterangan}`);
                $('#modalRSlain').modal('hide');
            } else {
                alert('Silahkan isi RS pengobatan lanjutan !');
            }
        });
    </script>
@endpush
