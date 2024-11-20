<div class="modal fade" id="modal-view-resume" tabindex="-1" aria-labelledby="extraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header  bg-primary">
                <h5 class="modal-title text-white" id="extraLargeModalLabel">Resume Medis Gawat Darurat</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="post_id">
                <div class="row">
                    <div class="col-md-2">
                        <div class="patient-card">
                            <div class="patient-photo">
                                <img src="{{ asset('assets/img/profile.jpg') }}" alt="Patient Photo">
                            </div>

                            <div class="patient-info">
                                <h6><strong>{{ $dataMedis->pasien->nama ?? 'Tidak Diketahui' }}</strong></h6>
                                <small class="mb-0">
                                    {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }},
                                    {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn
                                    ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})
                                </small>
                                <p class="mb-0 fw-bold">RM:
                                    {{ $dataMedis->pasien->kd_pasien ?? '-' }}</p>

                                <div class="patient-meta mt-2">
                                    <p class="mb-0">
                                        <i class="bi bi-calendar3"></i>
                                        {{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d M Y') ?? '-' }}
                                    </p>
                                    <p>
                                        <i class="bi bi-hospital"></i>
                                        {{ $dataMedis->unit->bagian->bagian ?? '-' }}
                                        ({{ $dataMedis->unit->nama_unit ?? '-' }})
                                    </p>
                                </div>
                            </div>

                            <div class="info__pasien">
                                <div class="bg-secondary rounded-2 p-1">
                                    <h6 class="text-white text-center">Informasi Pasien</h6>
                                </div>
                                <div class="info__pasien">
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h6 class="fw-bold">ALERGI</h6>
                                        </div>

                                        <hr class="text-secondary">
                                    </div>
                                    <ul class="p-2">
                                        @if (isset($dataResume->alergi) && is_array($dataResume->alergi))
                                            @foreach ($dataResume->alergi as $alergi)
                                                <li>{{ $alergi }}</li>
                                            @endforeach
                                        @else
                                            <li>-</li>
                                        @endif
                                    </ul>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h6 class="fw-bold">GOL. DARAH</h6>
                                            <hr class="text-secondary">
                                            <span>{{ $dataMedis->pasien->golonganDarah->jenis ?? 'Tidak Diketahui' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="col__dua">
                            <label class="form-label fw-bold">Anamnesis/ Keluhan Utama</label>
                            <textarea class="form-control" rows="3" readonly>{{ $dataResume->anamnesis ?? '-' }}</textarea>

                            <div class="mt-4">
                                <strong class="fw-bold">Pemeriksaan Fisik</strong>
                                <div class="bg-light p-3 border rounded">
                                    <div class="row">
                                        <div class="col-6 col-md-4">
                                            <small>TD:
                                                {{ $dataResume->konpas['sistole']['hasil'] ?? '__' }} /
                                                {{ $dataResume->konpas['distole']['hasil'] ?? '__' }} mmHg
                                            </small><br>
                                            <small>Temp: {{ $dataResume->konpas['suhu']['hasil'] ?? '__' }}
                                                C</small><br>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <small>
                                                RR:
                                                {{ $dataResume->konpas['respiration_rate']['hasil'] ?? '__' }}
                                                x/mnt
                                            </small><br>
                                            <small>Resp: {{ $dataResume->konpas['nadi']['hasil'] ?? '__' }}
                                                x/mnt</small>
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <small>TB:
                                                {{ $dataResume->konpas['tinggi_badan']['hasil'] ?? '__' }}
                                                M</small><br>
                                            <small>BB:
                                                {{ $dataResume->konpas['berat_badan']['hasil'] ?? '__' }}
                                                Kg</small><br>
                                        </div>
                                    </div>

                                </div>
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
                                                            <td>{{ \Carbon\Carbon::parse($order->tgl_order)->format('d M Y H:i') }}
                                                            </td>
                                                            <td>
                                                                @php
                                                                    $statusOrder = $detail->status_order;
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
                                                                    class="btn-view-labor"
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
                                                    <th>Hasil</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $counter = 1;
                                                @endphp
                                                @foreach ($dataRagiologi as $order)
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
                                                            <td><a href="#">Lihat Hasil</a></td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <strong class="fw-bold">Hasil Pemeriksaan Penunjang Lainnya</strong>
                                <textarea class="form-control" id="pemeriksaan_penunjang" rows="3" readonly>{{ $dataResume->pemeriksaan_penunjang ?? '-' }}</textarea>
                            </div>

                            <div class="mt-3">
                                <strong class="fw-bold">
                                    Diagnosis
                                </strong>

                                <div class="bg-light p-3 border rounded">
                                    <div style="max-height: 150px; overflow-y: auto;">
                                        <ol type="1">
                                            @if (isset($dataResume->diagnosis) && is_array($dataResume->diagnosis))
                                                @foreach ($dataResume->diagnosis as $diagnosis)
                                                    <li>{{ $diagnosis }}</li>
                                                @endforeach
                                            @else
                                                <li>-</li>
                                            @endif
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <strong class="fw-bold">Kode ICD 10 (Koder)
                                </strong>
                                <div class="bg-light p-3 border rounded">
                                    <ul class="list p-3" id="icdList">
                                        @if (isset($dataResume->icd_10) && is_array($dataResume->icd_10))
                                            @foreach ($dataResume->icd_10 as $icd10)
                                                <li>{{ $icd10 }}</li>
                                            @endforeach
                                        @else
                                            <li>-</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-5">
                        <strong class="fw-bold">Tindakan/Prosedur</strong>
                        <div class="bg-light p-3 border rounded">
                            <div style="max-height: 150px; overflow-y: auto;">
                                <ol type="1">
                                    <li>
                                        <a href="#"
                                            class="fw-bold">{{ $dataResume->listTindakanPasien->produk->deskripsi ?? '-' }}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <div class="mt-3">
                            <strong class="fw-bold">Kode ICD-9 CM (Koder)
                            </strong>
                            <div class="bg-light p-3 border rounded">
                                <ul class="list p-3" id="icd9List">
                                    @if (isset($dataResume->icd_9) && is_array($dataResume->icd_9))
                                        @foreach ($dataResume->icd_9 as $icd9)
                                            <li>{{ $icd9 }}</li>
                                        @endforeach
                                    @else
                                        <li>-</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="mt-3">
                            <strong class="fw-bold">Resep Obat</strong>
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
                                                @foreach ($riwayatObatHariIni as $obat)
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
                            <strong class="fw-bold">Tindak Lanjut</strong>
                            <div class="bg-light p-3 border rounded">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="#"
                                            class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                            <input type="radio" id="kontrol" class="form-check-input me-2"
                                                value="{{ $dataResume->rmeResumeDet->tindak_lanjut_name ?? '-' }}"
                                                data-code="1" checked>
                                            <label
                                                for="kontrol">{{ $dataResume->rmeResumeDet->tindak_lanjut_name ?? '-' }}</label>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-info"><i class="bi bi-printer"></i> Print</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-view-labor')

<script>
    $('#btn-view-resume').on('click', function() {
        $('#modal-view-resume').modal('show');
    });
</script>
