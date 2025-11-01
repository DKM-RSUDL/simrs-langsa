@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation')

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
                                                <small>Resp: {{ $vitalSign->nadi ?? '__' }}
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
                                                        <th>Hasil</th>
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
                                    <strong class="fw-bold">Hasil Pemeriksaan Penunjang</strong>
                                    <textarea class="form-control" id="pemeriksaan_penunjang" rows="3">{{ $dataResume->pemeriksaan_penunjang ?? '-' }}</textarea>
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
                                            <li>
                                                <a href="#"
                                                    class="fw-bold">{{ $dataResume->listTindakanPasien->produk->deskripsi ?? '-' }}</a>
                                            </li>
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
                                            <div class="col-md-6">
                                                {{-- <a href="javascript:void(0)" id="btn-tgl-kontrol-ulang"
                                            class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                            <input type="radio" id="kontrol" name="tindak_lanjut_name"
                                                class="form-check-input me-2" value="Kontrol ulang, tgl:"
                                                data-code="2"
                                                {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '2' ? 'checked' : '' }}>
                                            <label for="kontrol">Kontrol ulang, tgl:<span id="selected-date">
                                                    {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '2' ? $dataResume->rmeResumeDet->tgl_kontrol_ulang : '' }}
                                                </span></label>
                                        </a> --}}

                                                {{-- <a href="javascript:void(0)" id="btn-konsul-rujukan"
                                            class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                            <input type="radio" id="konsul" name="tindak_lanjut_name"
                                                class="form-check-input me-2" value="Konsul/Rujuk Internal Ke:"
                                                data-code="4"
                                                {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '4' ? 'checked' : '' }}>
                                            <label for="konsul">Konsul/Rujuk Internal Ke:
                                                <span id="selected-unit-tujuan"
                                                    data-unit-id="{{ $dataResume->rmeResumeDet->unit_rujuk_internal ?? '' }}">
                                                    {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '4' ? $dataResume->rmeResumeDet->unitRujukanInternal?->nama_unit : '' }}
                                                </span>
                                            </label>
                                        </a> --}}

                                                <a href="#" id="btn-rawat-inap"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="rawat" name="tindak_lanjut_name"
                                                        class="form-check-input me-2" value="Rawat Inap" data-code="1"
                                                        {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '1' ? 'checked' : '' }}>
                                                    <label for="rawat">Rawat Inap</label>
                                                </a>

                                                <a href="#" id=""
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="kamar-operasi" name="tindak_lanjut_name"
                                                        class="form-check-input me-2" value="Kamar Operasi"
                                                        data-code="7"
                                                        {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '7' ? 'checked' : '' }}>
                                                    <label for="kamar-operasi">Kamar Operasi</label>
                                                </a>

                                                <a href="javascript:void(0)" id="btn-rs-rujuk-bagian"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="rujuk_rs_lain" name="tindak_lanjut_name"
                                                        class="form-check-input me-2" value="Rujuk RS Lain"
                                                        data-code="5"
                                                        {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '5' ? 'checked' : '' }}>
                                                    <label for="rujuk_rs_lain">Rujuk RS lain
                                                        <span id="selected-rs-info"
                                                            class="text-muted fst-italic small ms-2" hidden>
                                                            @if (($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '5')
                                                                {{ $dataResume->rmeResumeDet->rs_rujuk ?? '' }}
                                                                {{ $dataResume->rmeResumeDet->alasan_rujuk ?? '' }}
                                                            @endif
                                                        </span>
                                                    </label>
                                                </a>

                                                <a href="#"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none"
                                                    id="btnPulang">
                                                    <input type="radio" name="tindak_lanjut_name"
                                                        class="form-check-input me-2" value="Pulang" data-code="6"
                                                        {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '6' ? 'checked' : '' }}>
                                                    <label for="selesai">Pulang <span></span></label>
                                                </a>

                                            </div>

                                            <div class="col-md-6">
                                                <a href="javascript:void(0)" id="btn-berobat-jalanke-poli"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="berobat-jalanke-poli-radio"
                                                        name="tindak_lanjut_name" class="form-check-input me-2"
                                                        value="Berobat Jalan ke Poli" data-code="8"
                                                        {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '8' ? 'checked' : '' }}>
                                                    <label for="berobat-jalanke-poli-radio">
                                                        Berobat Jalan Ke Poli
                                                        <span id="selected-poli-info"
                                                            class="text-muted fst-italic small ms-2" hidden></span>
                                                    </label>
                                                </a>

                                                <a href="javascript:void(0)" id="btn-menolak-rawat-inap"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="menolak-rawat-inap-radio"
                                                        name="tindak_lanjut_name" class="form-check-input me-2"
                                                        value="Menolak Rawat Inap" data-code="9"
                                                        {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '9' ? 'checked' : '' }}>
                                                    <label for="menolak-rawat-inap-radio">
                                                        Menolak Rawat Inap
                                                        <span id="selected-menolak-info"
                                                            class="text-muted fst-italic small ms-2" hidden></span>
                                                    </label>
                                                </a>

                                                <a href="javascript:void(0)" id="btn-meninggal-dunia"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="meninggal-dunia-radio"
                                                        name="tindak_lanjut_name" class="form-check-input me-2"
                                                        value="Meninggal Dunia" data-code="10"
                                                        {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '10' ? 'checked' : '' }}>
                                                    <label for="meninggal-dunia-radio">
                                                        Meninggal Dunia
                                                        <span id="selected-meninggal-info"
                                                            class="text-muted fst-italic small ms-2" hidden></span>
                                                    </label>
                                                </a>

                                                <a href="javascript:void(0)" id="btn-doa"
                                                    class="tindak-lanjut-option d-block mb-2 text-decoration-none">
                                                    <input type="radio" id="doa-radio" name="tindak_lanjut_name"
                                                        class="form-check-input me-2" value="DOA (death on arrival)"
                                                        data-code="11"
                                                        {{ ($dataResume->rmeResumeDet->tindak_lanjut_code ?? '') == '11' ? 'checked' : '' }}>
                                                    <label for="doa-radio">
                                                        DOA (death on arrival)
                                                        <span id="selected-doa-info"
                                                            class="text-muted fst-italic small ms-2" hidden></span>
                                                    </label>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('resume.pdf', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($dataResume->id)]) }}"
                            target="_blank" class="btn btn-sm btn-info">
                            <i class="bi bi-printer"></i>
                            Print
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" id="update">Ubah</button>
                        <button type="button" class="btn btn-sm btn-success" id="btnValidate">Validasi</button>
                        <a href="{{ route('resume.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))]) }}"
                            class="btn btn-sm btn-secondary">Close</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-create-diagnosi')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-kode-icd')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-kode-icd9')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-pulang')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-rs-rujuk-bagian')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-view-labor-create')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-berobat-jalan')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-rawat-inap')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-meninggal-dunia')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.resume.resume-medis.components.modal-doa')
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

            const kd_pasien = '{{ $dataMedis->kd_pasien }}';
            const tgl_masuk = '{{ $dataMedis->tgl_masuk }}';
            const resume_id = '{{ $dataResume->id ?? null }}';

            const previousTglKontrolUlang = '{{ $dataResume->rmeResumeDet->tgl_kontrol_ulang ?? '' }}';
            const previousRsRujukBagian = '{{ $dataResume->rmeResumeDet->rs_rujuk_bagian ?? '' }}';

            const previousRsRujuk = '{{ $dataResume->rmeResumeDet->rs_rujuk ?? '' }}';
            const previousAlasanRujuk = '{{ $dataResume->rmeResumeDet->alasan_rujuk ?? '' }}';
            const previousTransportasiRujuk = '{{ $dataResume->rmeResumeDet->transportasi_rujuk ?? '' }}';

            const previousTglRajal = '{{ $dataResume->rmeResumeDet->tgl_rajal ?? '' }}';
            const previousUnitRajal = '{{ $dataResume->rmeResumeDet->unit_rajal ?? '' }}';

            const previousAlasanMenolakInap = '{{ $dataResume->rmeResumeDet->alasan_menolak_inap ?? '' }}';

            const previousTglMeninggal = '{{ $dataResume->rmeResumeDet->tgl_meninggal ?? '' }}';
            const previousJamMeninggal = '{{ $dataResume->rmeResumeDet->jam_meninggal ?? '' }}';
            const previousTglMeninggalDoa = '{{ $dataResume->rmeResumeDet->tgl_meninggal_doa ?? '' }}';
            const previousJamMeninggalDoa = '{{ $dataResume->rmeResumeDet->jam_meninggal_doa ?? '' }}';

            const previousUnitRujukInternal = '{{ $dataResume->rmeResumeDet->unit_rujuk_internal ?? '' }}';
            const previousTglPulang = '{{ $dataResume->rmeResumeDet->tgl_pulang ?? '' }}';
            const previousJamPulang = '{{ $dataResume->rmeResumeDet->jam_pulang ?? '' }}';
            const previousAlasanPulang = '{{ $dataResume->rmeResumeDet->alasan_pulang ?? '' }}';
            const previousKondisiPulang = '{{ $dataResume->rmeResumeDet->kondisi_pulang ?? '' }}';


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
            formData.append('pemeriksaan_penunjang', $('#pemeriksaan_penunjang').val().trim());

            // const diagnosisArray = $('#diagnoseDisplay').children()
            //     .map(function() {
            //         return $(this).find('.fw-bold').text().trim();
            //     }).get().filter(Boolean);
            // if (diagnosisArray.length === 0) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Error',
            //         text: 'Minimal satu diagnosis harus diisi'
            //     });
            //     return;
            // }
            // formData.append('diagnosis', JSON.stringify(diagnosisArray));

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
            console.log('Data diagnosis yang akan disimpan:', dataDiagnosis);
            formData.append('diagnosis', JSON.stringify(dataDiagnosis));
            // return false;


            // Get ICD-10 data
            const icd10Array = $('#icdList').children()
                .map(function() {
                    return $(this).text().trim().split(' ')[0];
                }).get().filter(Boolean);
            // if (icd10Array.length === 0) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Error',
            //         text: 'Minimal satu ICD 10 harus diisi'
            //     });
            //     return;
            // }
            formData.append('icd_10', JSON.stringify(icd10Array));

            // Get ICD-9 data
            const icd9Array = $('#icd9List').children()
                .map(function() {
                    return $(this).text().trim().split(' ')[0];
                }).get().filter(Boolean);
            // if (icd9Array.length === 0) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Error',
            //         text: 'Minimal satu ICD 9 harus diisi'
            //     });
            //     return;
            // }
            formData.append('icd_9', JSON.stringify(icd9Array));

            // Get Alergi
            const Alergirray = $('#list-alergi').children()
                .map(function() {
                    return $(this).text();
                }).get().filter(Boolean);
            formData.append('alergi', JSON.stringify(Alergirray));

            // Get control ulang tgl
            const ControlUlangTgl = $('#selected-date').text().trim() || previousTglKontrolUlang;
            formData.append('tgl_kontrol_ulang', ControlUlangTgl);

            // Get Rujuk RS lain bagian
            const rsRujuk = $('#rs-rujuk').val() || previousRsRujuk;
            formData.append('rs_rujuk', rsRujuk);
            const alasanRujuk = $('#alasan_rujuk').val() || previousAlasanRujuk;
            formData.append('alasan_rujuk', alasanRujuk);
            const transportasiRujuk = $('#transportasi_rujuk').val() || previousTransportasiRujuk;
            formData.append('transportasi_rujuk', transportasiRujuk);

            // Get Berobat Jalan Ke Poli
            const tglRajal = $('#tgl-rajal').val() || previousTglRajal;
            formData.append('tgl_rajal', tglRajal);
            const unitRajal = $('#unit_rajal').val() || previousUnitRajal;
            formData.append('unit_rajal', unitRajal);

            // Get Alasan menolak inap
            const MenolakInap = $('#alasan-menolak').val() || previousAlasanMenolakInap;
            formData.append('alasan_menolak_inap', MenolakInap);

            // Get Meninggal Dunia
            const tglMeninggal = $('#tgl-meninggal').val() || previousTglMeninggal;
            formData.append('tgl_meninggal', tglMeninggal);
            const jamMeninggal = $('#jam-meninggal').val() || previousJamMeninggal;
            formData.append('jam_meninggal', jamMeninggal);

            // Get DOA (death on arrival)
            const tglMeninggalDoa = $('#tgl-meninggal-doa').val() || previousTglMeninggalDoa;
            formData.append('tgl_meninggal_doa', tglMeninggalDoa);
            const jamMeninggalDoa = $('#jam-meninggal-doa').val() || previousJamMeninggalDoa;
            formData.append('jam_meninggal_doa', jamMeninggalDoa);

            // Ambil ID unit dari atribut data-unit-id
            const unitId = $('#selected-unit-tujuan').attr('data-unit-id') || previousUnitRujukInternal;
            console.log('Sending unit_rujuk_internal:', unitId);
            formData.append('unit_rujuk_internal', unitId);

            // tindak lanjut pulang
            let tglPulangTL = $('#selesaiKlinikModal #tgl_pulang').val() || previousTglPulang;
            let jamPulangTL = $('#selesaiKlinikModal #jam_pulang').val() || previousJamPulang;
            let alasanPulangTL = $('#selesaiKlinikModal #alasan_pulang').val() || previousAlasanPulang;
            let kondisiPulangTL = $('#selesaiKlinikModal #kondisi_pulang').val() || previousKondisiPulang;

            formData.append('tgl_pulang', tglPulangTL);
            formData.append('jam_pulang', jamPulangTL);
            formData.append('alasan_pulang', alasanPulangTL);
            formData.append('kondisi_pulang', kondisiPulangTL);

            formData.append('anjuran_diet', $('#anjuran_diet').val().trim());
            formData.append('anjuran_edukasi', $('#anjuran_edukasi').val().trim());

            formData.append('tindak_lanjut_name', tindakLanjutElement.val());
            formData.append('tindak_lanjut_code', tindakLanjutElement.data('code'));

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
                        $.ajax({
                                url: `/unit-pelayanan/gawat-darurat/pelayanan/${kd_pasien}/${tgl_masuk}/resume/${resume_id}`,
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
                'pemeriksaan_penunjang': 'Pemeriksaan Penunjang'
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
    </script>
@endpush
