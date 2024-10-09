@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .patient-card .nav-link.active {
            background-color: #0056b3;
            color: #fff;
        }

        .patient-card img.rounded-circle {
            object-fit: cover;
        }

        .tab-content {
            flex-grow: 1;
            width: 350px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation')
            {{-- @component('components.navigation', ['navItems' => $navItems])
            @endcomponent --}}

            <!-- Content -->
            <div class="patient-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-primary mb-0">Catatan Perkembangan Pasien Terintegrasi</h6>
                    <h6 class="text-secondary mb-0">Grafik</h6>
                </div>

                <div class="row g-3">
                    <!-- Select PPA Option -->
                    <div class="col-md-2">
                        <select class="form-select" id="SelectOption" aria-label="Pilih...">
                            <option value="semua" selected>Semua PPA</option>
                            <option value="option1">Dokter Spesialis</option>
                            <option value="option2">Dokter Umum</option>
                            <option value="option3">Perawat/bidan</option>
                            <option value="option4">Nutrisionis</option>
                            <option value="option5">Apoteker</option>
                            <option value="option6">Fisioterapis</option>
                        </select>
                    </div>

                    <!-- Select Episode Option -->
                    <div class="col-md-2">
                        <select class="form-select" id="SelectEpisode" aria-label="Pilih...">
                            <option value="semua" selected>Semua Episode</option>
                            <option value="Episode1">Episode Sekarang</option>
                            <option value="Episode2">1 Bulan</option>
                            <option value="Episode3">3 Bulan</option>
                            <option value="Episode4">6 Bulan</option>
                            <option value="Episode5">9 Bulan</option>
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div class="col-md-2">
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            placeholder="Dari Tanggal">
                    </div>

                    <!-- End Date -->
                    <div class="col-md-2">
                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
                    </div>

                    <!-- Search Bar -->
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Cari" aria-label="Cari"
                                aria-describedby="basic-addon1">
                        </div>
                    </div>

                    <!-- Add Button -->
                    <!-- Include the modal file -->
                    <div class="col-md-2">
                        @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.cppt.modal')
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <!-- Sidebar navigation -->
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            @php
                                $i=0;
                            @endphp
                            @foreach ($cppt as $key => $value)
                                <button class="nav-link @if ($i == 0) active @endif"
                                    id="v-pills-home-tab-{{ $i }}" data-bs-toggle="pill"
                                    href="#v-pills-home-{{ $i }}" role="tab"
                                    aria-selected="{{ $i == 0 }}">
                                    <div class="d-flex align-items-center">
                                        <div class="text-center me-2">
                                            <strong class="d-block">
                                                {{ date('d M', strtotime($value['tanggal'])) }}
                                            </strong>
                                            <small class="d-block">
                                                {{ date('H:i', strtotime($value['jam'])) }}
                                            </small>
                                        </div>
                                        <img src="{{ asset('assets/img/profile.jpg') }}" alt="Avatar"
                                            class="rounded-circle" width="50" height="50">
                                        <div class="ms-3">
                                            <p class="mb-0"><strong>{{ $value['nama_penanggung'] }}</strong></p>
                                            <small class="text-muted">{{ $value['nama_unit'] }}</small>
                                        </div>
                                    </div>
                                </button>
                                @php
                                    $i++;
                                @endphp
                            @endforeach

                            {{-- @foreach ($tabContents as $index => $content)
                                <button class="nav-link @if ($index == 0) active @endif"
                                    id="v-pills-home-tab-{{ $index }}" data-bs-toggle="pill"
                                    href="#v-pills-home-{{ $index }}" role="tab"
                                    aria-selected="{{ $index == 0 }}">
                                    <div class="d-flex align-items-center">
                                        <div class="text-center me-2">
                                            <strong class="d-block">
                                                {{ date('d M', strtotime($content['tanggal'])) }}
                                            </strong>
                                            <small class="d-block">
                                                {{ $content['time'] }}
                                            </small>
                                        </div>
                                        <img src="{{ asset('assets/img/' . $content['avatar']) }}" alt="Avatar"
                                            class="rounded-circle" width="50" height="50">
                                        <div class="ms-3">
                                            <p class="mb-0"><strong>{{ $content['name'] }}</strong></p>
                                            <small class="text-muted">{{ $content['role'] }}</small>
                                        </div>
                                    </div>
                                </button>
                            @endforeach --}}
                        </div>

                        <!-- Tab content -->
                        <div class="tab-content flex-grow-1" id="v-pills-tabContent">
                            @php
                                $j = 0;
                            @endphp
                            @foreach ($cppt as $key => $value)
                                <div class="tab-pane fade @if ($j == 0) show active @endif"
                                id="v-pills-home-{{ $j }}" role="tabpanel">
                                    <div class="patient-card bg-secondary-subtle">
                                        <p class="mb-0 text-end">{{ date('d M Y', strtotime($value['tanggal'])) }} {{ date('H:i', strtotime($value['jam'])) }}</p>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/img/profile.jpg') }}" alt="Avatar"
                                                class="rounded-circle" width="50" height="50">
                                            <div class="ms-3">
                                                <p class="mb-0 fw-bold">Catatan Perkembangan Pasien Terintegrasi</p>
                                                <small class="text-muted">
                                                    <span class="fw-bold">{{ $value['nama_penanggung'] }}</span>
                                                    ({{ $value['nama_unit'] }})
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Subjective -->
                                    <div class="row mt-3">
                                        <div class="col-1">
                                            <h6><strong>S</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <p>{{ $value['anamnesis'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Objective -->
                                    <div class="row">
                                        <div class="col-1">
                                            <h6><strong>O</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <div class="row">
                                                @foreach ($value['kondisi']['konpas'] as $item => $val)
                                                    <div class="col-md-6 mb-2">{{ $val['nama_kondisi'] .' : '. $val['hasil'] .' '. $val['satuan'] }}</div>
                                                @endforeach
                                                {{-- <div class="col-md-3">TD: {{ $content['objective']['TD'] }}</div>
                                                <div class="col-md-3">RR: {{ $content['objective']['RR'] }}</div>
                                                <div class="col-md-3">TB: {{ $content['objective']['TB'] }}</div> --}}
                                            </div>
                                            {{-- <div class="row">
                                                <div class="col-md-3">Temp: {{ $content['objective']['Temp'] }}</div>
                                                <div class="col-md-3">Resp: {{ $content['objective']['Resp'] }}</div>
                                                <div class="col-md-3">BB: {{ $content['objective']['BB'] }}</div>
                                            </div> --}}
                                            <p>{{ $value['obyektif'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Assessment -->
                                    <div class="row">
                                        <div class="col-1">
                                            <h6><strong>A</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <ul>
                                                @foreach ($value['cppt_penyakit'] as $p => $v)
                                                    <li>{{ $v['nama_penyakit'] }}</li>
                                                @endforeach

                                                {{-- @foreach ($content['assessment'] as $assessment)
                                                    <li>{{ $assessment }}</li>
                                                @endforeach --}}
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Plan -->
                                    <div class="row mt-3">
                                        <div class="col-1">
                                            <h6><strong>P</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <ul>
                                                <li>{{ $value['planning'] }}</li>

                                                {{-- @foreach ($content['plan'] as $plan)
                                                    <li>{{ $plan }}</li>
                                                @endforeach --}}
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Button -->
                                    <div class="d-flex justify-content-between mt-4">
                                        @if ($value['verified'])
                                            <p class="m-0 p-0 text-success">
                                                <i class="ti-check"></i>
                                                Terverifikasi
                                            </p>
                                        @else
                                            <form action="{{ route('cppt.verifikasi', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}" method="post">
                                                @csrf
                                                @method('put')

                                                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                                                <input type="hidden" name="no_transaksi" value="{{ $dataMedis->no_transaksi }}">
                                                <input type="hidden" name="kd_kasir" value="{{ $dataMedis->kd_kasir }}">
                                                <input type="hidden" name="tanggal" value="{{ $value['tanggal'] }}">
                                                <input type="hidden" name="urut" value="{{ $value['urut'] }}">
                                                <button type="submit" class="btn btn-primary">Verifikasi DPJP</button>
                                            </form>
                                        @endif
                    
                                        <button class="btn btn-primary btn-edit-cppt" data-bs-target="#editCpptModal" data-tgl="{{ $value['tanggal'] }}" data-urut="{{ $value['urut'] }}" data-unit="{{ $value['kd_unit'] }}" data-transaksi="{{ $value['no_transaksi'] }}" data-urut-total="{{ $value['urut_total'] }}">Edit</button>
                                    </div>
                                </div>

                                @php
                                    $j++;
                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

<script>
    // add
    var searchInputDiagnose = $('#addDiagnosisModal #searchInput');
    var dataListDiagnose = $('#addDiagnosisModal #dataList');

    $('#addDiagnosisModal #btnAddListDiagnosa').click(function(e) {
        e.preventDefault();
        var searchInputValue = $(searchInputDiagnose).val();

        if(searchInputValue != '') {
            $('#listDiagnosa').append(`<li>${searchInputValue}</li>`);
            $(searchInputDiagnose).val('');
        }
    });

    $('#addDiagnosisModal #btnSaveDiagnose').click(function(e) {
        
        var dignoseListContent = '';
        let diagnoses = $('#addDiagnosisModal #listDiagnosa li');

        $(diagnoses).each(function (i, e) {
            dignoseListContent += `<div>
                                        <a href="#" class="fw-bold">${$(e).text()}</a>
                                        <input type="hidden" name="diagnose_name[]" value="${$(e).text()}"
                                    </div>`;
            
        });

        $('#addCpptModal #diagnoseList').html(dignoseListContent);
        $('#addDiagnosisModal .btn-close').trigger('click');
    });

    $('#addCpptModal input[name="skala_nyeri"]').change(function(e) {
        var $this = $(this);
        var skalaValue = $this.val();

        if(skalaValue > 10) {
            skalaValue = 10;
            $this.val(10);
        }

        if(skalaValue < 0) {
            skalaValue = 0;
            $this.val(0);
        }

        var valColor = 'btn-success';
        let skalaLabel = 'Tidak Nyeri'

        if(skalaValue > 1 && skalaValue <= 3) skalaLabel = "Nyeri Ringan";
        if(skalaValue > 3 && skalaValue <= 5) skalaLabel = "Nyeri Sedang";
        if(skalaValue > 5 && skalaValue <= 7) skalaLabel = "Nyeri Parah";
        if(skalaValue > 7 && skalaValue <= 9) skalaLabel = "Nyeri Sangat Parah";
        if(skalaValue > 9) skalaLabel = "Nyeri Terburuk";

        if(skalaValue > 3 && skalaValue <= 7) valColor = 'btn-warning';
        if(skalaValue > 7 && skalaValue <= 10) valColor = 'btn-danger';

        $('#addCpptModal #skalaNyeriBtn').removeClass('btn-success');
        $('#addCpptModal #skalaNyeriBtn').removeClass('btn-warning');
        $('#addCpptModal #skalaNyeriBtn').removeClass('btn-danger');
        $('#addCpptModal #skalaNyeriBtn').addClass(valColor);
        $('#addCpptModal #skalaNyeriBtn').text(skalaLabel);
    });

    $('#formAddCppt').submit(function(e) {
        let $this = $(this);
        let diagnoseNameEl = $this.find('input[name="diagnose_name[]"]');
        
        if(diagnoseNameEl.length < 1) {
            showToast('error', 'Diagnosa harus di tambah minimal 1!');
            return false;
        }
    });

    // edit
    var tanggal, urut, unit, button;
    var editDataListDiagnose = $('#editDiagnosisModal #dataList');
    var editSearchInputDiagnose = $('#editDiagnosisModal #searchInput');

    $('.btn-edit-cppt').click(function(e) {
        e.preventDefault();

        var $this = $(this);
        var tanggalData = $this.attr('data-tgl');
        var urutData = $this.attr('data-urut');
        var urutTotalData = $this.attr('data-urut-total');
        var unitData = $this.attr('data-unit');
        var transaksiData = $this.attr('data-transaksi');
        var target = $this.attr('data-bs-target');

        tanggal = tanggalData;
        urut = urutData;
        unit = unitData;
        button = $this;

        // Ubah teks tombol dan tambahkan spinner
        $this.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...');
        $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung


        var url = "{{ route('cppt.get-cppt-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}";

        $.ajax({
            type: "post",
            url: url,
            data: {
                _token: "{{ csrf_token() }}",
                kd_pasien: "{{ $dataMedis->kd_pasien }}",
                no_transaksi: "{{ $dataMedis->no_transaksi }}",
                tanggal: tanggal,
                urut: urut,
                kd_unit: unit
            },
            dataType: "json",
            success: function (response) {

                if(response.status == 'success') {
                    var data = response.data;
                    

                    for (let key in data) {
                        if (data.hasOwnProperty(key)) {
                            let patient = data[key];

                            //set key to input
                            $(target).find('input[name="tgl_cppt"]').val(tanggalData);
                            $(target).find('input[name="urut_cppt"]').val(urutData);
                            $(target).find('input[name="urut_total_cppt"]').val(urutTotalData);
                            $(target).find('input[name="unit_cppt"]').val(unitData);
                            $(target).find('input[name="no_transaksi"]').val(transaksiData);
                            $(target).find('#anamnesis').val(patient.anamnesis);
                            $(target).find('#lokasi').val(patient.lokasi);
                            $(target).find('#durasi').val(patient.durasi);
                            $(target).find('#pemeriksaan_fisik').val(patient.pemeriksaan_fisik);
                            $(target).find('#data_objektif').val(patient.obyektif);
                            $(target).find('#planning').val(patient.planning);

                            // skala nyeri set value
                            var skalaNyeri = patient.skala_nyeri;
                            var valColor = 'btn-success';
                            let skalaLabel = 'Tidak Nyeri'

                            if(skalaNyeri > 1 && skalaNyeri <= 3) skalaLabel = "Nyeri Ringan";
                            if(skalaNyeri > 3 && skalaNyeri <= 5) skalaLabel = "Nyeri Sedang";
                            if(skalaNyeri > 5 && skalaNyeri <= 7) skalaLabel = "Nyeri Parah";
                            if(skalaNyeri > 7 && skalaNyeri <= 9) skalaLabel = "Nyeri Sangat Parah";
                            if(skalaNyeri > 9) skalaLabel = "Nyeri Terburuk";

                            if(skalaNyeri > 3 && skalaNyeri <= 7) valColor = 'btn-warning';
                            if(skalaNyeri > 7 && skalaNyeri <= 10) valColor = 'btn-danger';

                            $(target).find('#skalaNyeriBtn').removeClass('btn-success');
                            $(target).find('#skalaNyeriBtn').removeClass('btn-warning');
                            $(target).find('#skalaNyeriBtn').removeClass('btn-danger');
                            $(target).find('#skalaNyeriBtn').addClass(valColor);
                            $(target).find('#skalaNyeriBtn').text(skalaLabel);

                            $(target).find('#skala_nyeri').val(skalaNyeri);

                            // tanda vital set value
                            var kondisi = patient.kondisi;
                            var konpas = kondisi.konpas;

                            for(let i in konpas) {
                                if(konpas.hasOwnProperty(i)) {
                                    let kondisi = konpas[i];

                                    $(target).find(`#kondisi${kondisi.id_kondisi}`).val(kondisi.hasil);
                                }
                            }

                            // set pemberat value
                            $(target).find(`#pemberat option[value="${patient?.pemberat?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#peringan option[value="${patient?.peringan?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#kualitas_nyeri option[value="${patient?.kualitas?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#frekuensi_nyeri option[value="${patient?.frekuensi?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#menjalar option[value="${patient?.menjalar?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#jenis_nyeri option[value="${patient?.jenis?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`input[name="tindak_lanjut"][value="${patient.tindak_lanjut_code}"]`).attr('checked', 'checked');

                            // diagnosis set value
                            var penyakit = patient.cppt_penyakit;
                            var dignoseListContent = '';
                            
                            for(let d in penyakit) {
                                if(penyakit.hasOwnProperty(d)) {
                                    let diag = penyakit[d];

                                    dignoseListContent += `<div class="diag-item-wrap">
                                                                <a href="#" class="fw-bold text-decoration-none">
                                                                    <div class="d-flex align-items-center justify-content-between">                            
                                                                        <p class="m-0 p-0">${diag.nama_penyakit}</p>
                                                                        <span class="btnListDiagnose">
                                                                            <i class="ti-close text-danger"></i>
                                                                        </span>
                                                                    </div>
                                                                </a>
                                                                <input type="hidden" name="diagnose_name[]" value="${diag.nama_penyakit}">
                                                            </div>`;

                                }
                            }
                            
                            $(target).find('#diagnoseList').html(dignoseListContent);
                        }
                    }
                }

                $(target).modal('show');
                // Ubah teks tombol jadi edit
                button.html('Edit');
                button.prop('disabled', false);
            },
            error: function (xhr, status, error) {
                // Penanganan jika terjadi error
                // console.log("Error:", error);
                // console.log("Status:", status);
                // console.log("XHR Object:", xhr);
                // alert("Terjadi kesalahan: " + error);
                showToast('error', 'internal server error');
            }
        });
    });

    // delete old diagnose list
    $(document).on('click', '#editCpptModal .btnListDiagnose', function(e) {
        e.preventDefault();
        var $this = $(this);
        $(this).closest('.diag-item-wrap').remove();
    })

    $('#editDiagnosisModal #btnAddListDiagnosa').click(function(e) {
        e.preventDefault();
        var searchInputValue = $(editSearchInputDiagnose).val();

        if(searchInputValue != '') {
            $('#editDiagnosisModal #listDiagnosa').append(`<li>${searchInputValue}</li>`);
            $(editSearchInputDiagnose).val('');
        }
    });

    $('#editDiagnosisModal #btnSaveDiagnose').click(function(e) {
        var dignoseListContent = '';
        let diagnoses = $('#editDiagnosisModal #listDiagnosa li');

        $(diagnoses).each(function (i, e) {
            dignoseListContent += `<div class="diag-item-wrap">
                                        <a href="#" class="fw-bold text-decoration-none">
                                            <div class="d-flex align-items-center justify-content-between">                            
                                                <p class="m-0 p-0">${$(e).text()}</p>
                                                <span class="btnListDiagnose">
                                                    <i class="ti-close text-danger"></i>
                                                </span>
                                            </div>
                                        </a>
                                        <input type="hidden" name="diagnose_name[]" value="${$(e).text()}">
                                    </div>`;
            
        });

        $('#editCpptModal #diagnoseList').html(dignoseListContent);
        $('#editDiagnosisModal .btn-close').trigger('click');
    });

    // Button add diagnosis from edit cppt modal
    $('#editCpptModal #openEditDiagnosisModal').click(function(e) {
        var $this = $(this);
        var target = $this.attr('data-bs-target');

        var modalKedua = new bootstrap.Modal($(target), {
            backdrop: 'static', // Agar tidak menutup modal pertama ketika klik di luar modal kedua
            keyboard: false // Agar tidak bisa ditutup dengan tombol ESC
        });

        $(target).modal('show');
    });

    $('#editCpptModal #editDiagnosisModal').on('show.bs.modal', function(e) {
        var $this = $(this);
        var penyakitList = $('#editCpptModal #diagnoseList p');
        let listNamaPenyakitHtml = '';

        $.each(penyakitList, function (i, el) { 
            var nmDiag = $(el).text();

            if(nmDiag != '') {
                listNamaPenyakitHtml += `<li>${nmDiag}</li>`;
            }
        });

        $this.find('#listDiagnosa').html(listNamaPenyakitHtml);
    });

    $('#editCpptModal input[name="skala_nyeri"]').change(function(e) {
        var $this = $(this);
        var skalaValue = $this.val();

        if(skalaValue > 10) {
            skalaValue = 10;
            $this.val(10);
        }

        if(skalaValue < 0) {
            skalaValue = 0;
            $this.val(0);
        }

        var valColor = 'btn-success';
        let skalaLabel = 'Tidak Nyeri'

        if(skalaValue > 1 && skalaValue <= 3) skalaLabel = "Nyeri Ringan";
        if(skalaValue > 3 && skalaValue <= 5) skalaLabel = "Nyeri Sedang";
        if(skalaValue > 5 && skalaValue <= 7) skalaLabel = "Nyeri Parah";
        if(skalaValue > 7 && skalaValue <= 9) skalaLabel = "Nyeri Sangat Parah";
        if(skalaValue > 9) skalaLabel = "Nyeri Terburuk";

        if(skalaValue > 3 && skalaValue <= 7) valColor = 'btn-warning';
        if(skalaValue > 7 && skalaValue <= 10) valColor = 'btn-danger';

        $('#editCpptModal #skalaNyeriBtn').removeClass('btn-success');
        $('#editCpptModal #skalaNyeriBtn').removeClass('btn-warning');
        $('#editCpptModal #skalaNyeriBtn').removeClass('btn-danger');
        $('#editCpptModal #skalaNyeriBtn').addClass(valColor);
        $('#editCpptModal #skalaNyeriBtn').text(skalaValue);
    });

    $('#formEditCppt').submit(function(e) {
        let $this = $(this);
        let diagnoseNameEl = $this.find('input[name="diagnose_name[]"]');
        
        if(diagnoseNameEl.length < 1) {
            showToast('error', 'Diagnosa harus di tambah minimal 1!');
            return false;
        }
    });

</script>

{{-- <script>
    let typingTimer;
    let debounceTime = 500;
    var dataListDiagnose = $('#addDiagnosisModal #dataList');
    var datalistDiagnoseAdd = $('#addDiagnosisModal #dataListAdd');
    var searchInputDiagnose = $('#addDiagnosisModal #searchInput');

    $(searchInputDiagnose).keyup(function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            var $this = $('#addDiagnosisModal #searchInput');
            var url = "{{ route('cppt.get-icd10-ajax', [$dataMedis->pasien->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))]) }}";

            $.ajax({
                type: "post",
                url: url,
                data: {
                    '_token': "{{ csrf_token() }}",
                    'data': $this.val()
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success') {
                        var dataDiag = response.data.diagnosa;
                        var dataDiagCount = response.data.count;

                        var html = '';
                        if(dataDiagCount > 0) {
                            $.each(dataDiag, function (i, e) {
                                html += `<li><a class="dropdown-item" data-kode="${e.kd_penyakit}" href="#">${e.penyakit}</a></li>`;
                            });
                        } else {
                            html += `<li><a class="dropdown-item" data-kode="" href="#">--Data tidak ditemukan--</a></li>`;
                        }

                        $(dataListDiagnose).html(html);
                        $(dataListDiagnose).show();
                    }
                }
            });
        }, debounceTime);
    });

    var diagnoseSelection = '';
    var diagnoseSelectionAll = '';
    var diagnoseSelectionText = [];

    $(document).on('click', '#addDiagnosisModal #dataList li', function(e) {
        var $this = $(this);
        var text = $this.find('.dropdown-item').text();
        var kode = $this.find('.dropdown-item').attr('data-kode');

        if(kode != '') {
            $(searchInputDiagnose).val(text);
            diagnoseSelection = kode;
            $(dataListDiagnose).hide();
        }
    });

    $('#addDiagnosisModal #btnAddListDiagnosa').click(function(e) {
        e.preventDefault();
        var searchInputValue = $(searchInputDiagnose).val();

        if(searchInputValue != '') {
            $('#listDiagnosa').append(`<li>${searchInputValue}</li>`);
            diagnoseSelectionAll += (diagnoseSelectionAll != '') ? `,${diagnoseSelection}` : diagnoseSelection;

            diagnoseSelectionText.push(searchInputValue);
            $(datalistDiagnoseAdd).val(diagnoseSelectionAll);
            $(searchInputDiagnose).val('');
            diagnoseSelection = '';
        }
    });

    $('#addDiagnosisModal #btnSaveDiagnose').click(function(e) {
        var dignoseListContent = '';

        diagnoseSelectionText.forEach(e => {
            dignoseListContent += `<a href="#" class="fw-bold">${e}</a> <br>`;
        });

        $('#addCpptModal #daftarDiagnosaInput').val($(datalistDiagnoseAdd).val());
        $('#addCpptModal #diagnoseList').html(dignoseListContent);
        $('#addDiagnosisModal .btn-close').trigger('click');
    });

    $('#addCpptModal input[name="skala_nyeri"]').change(function(e) {
        var $this = $(this);
        var skalaValue = $this.val();

        if(skalaValue > 10) {
            skalaValue = 10;
            $this.val(10);
        }

        if(skalaValue < 0) {
            skalaValue = 0;
            $this.val(0);
        }

        var valColor = 'btn-success';

        if(skalaValue > 3 && skalaValue <= 7) valColor = 'btn-warning';
        if(skalaValue > 7 && skalaValue <= 10) valColor = 'btn-danger';

        $('#addCpptModal #skalaNyeriBtn').removeClass('btn-success');
        $('#addCpptModal #skalaNyeriBtn').removeClass('btn-warning');
        $('#addCpptModal #skalaNyeriBtn').removeClass('btn-danger');
        $('#addCpptModal #skalaNyeriBtn').addClass(valColor);
    });

    // edit
    var tanggal, urut, unit, button;

    $('.btn-edit-cppt').click(function(e) {
        e.preventDefault();

        var $this = $(this);
        var tanggalData = $this.attr('data-tgl');
        var urutData = $this.attr('data-urut');
        var unitData = $this.attr('data-unit');
        var target = $this.attr('data-bs-target');

        tanggal = tanggalData;
        urut = urutData;
        unit = unitData;
        button = $this;

        // Ubah teks tombol dan tambahkan spinner
        $this.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...');
        $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung


        var url = "{{ route('cppt.get-cppt-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}";

        $.ajax({
            type: "post",
            url: url,
            data: {
                _token: "{{ csrf_token() }}",
                kd_pasien: "{{ $dataMedis->kd_pasien }}",
                no_transaksi: "{{ $dataMedis->no_transaksi }}",
                tanggal: tanggal,
                urut: urut,
                kd_unit: unit
            },
            dataType: "json",
            success: function (response) {

                if(response.status == 'success') {
                    var data = response.data;

                    for (let key in data) {
                        if (data.hasOwnProperty(key)) {
                            let patient = data[key];

                            //set key to input
                            $(target).find('input[name="tgl_cppt"]').val(tanggalData);
                            $(target).find('input[name="urut_cppt"]').val(urutData);
                            $(target).find('input[name="unit_cppt"]').val(unitData);
                            $(target).find('#anamnesis').val(patient.anamnesis);
                            $(target).find('#lokasi').val(patient.lokasi);
                            $(target).find('#durasi').val(patient.durasi);
                            $(target).find('#pemeriksaan_fisik').val(patient.pemeriksaan_fisik);
                            $(target).find('#data_objektif').val(patient.obyektif);
                            $(target).find('#planning').val(patient.planning);

                            // skala nyeri set value
                            var skalaNyeri = patient.skala_nyeri;
                            var valColor = 'btn-success';

                            if(skalaNyeri > 3 && skalaNyeri <= 7) valColor = 'btn-warning';
                            if(skalaNyeri > 7 && skalaNyeri <= 10) valColor = 'btn-danger';

                            $(target).find('#skalaNyeriBtn').removeClass('btn-success');
                            $(target).find('#skalaNyeriBtn').removeClass('btn-warning');
                            $(target).find('#skalaNyeriBtn').removeClass('btn-danger');
                            $(target).find('#skalaNyeriBtn').addClass(valColor);

                            $(target).find('#skala_nyeri').val(skalaNyeri);

                            // tanda vital set value
                            var kondisi = patient.kondisi;
                            var konpas = kondisi.konpas;

                            for(let i in konpas) {
                                if(konpas.hasOwnProperty(i)) {
                                    let kondisi = konpas[i];

                                    $(target).find(`#kondisi${kondisi.id_kondisi}`).val(kondisi.hasil);
                                }
                            }

                            // set pemberat value
                            $(target).find(`#pemberat option[value="${patient?.pemberat?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#peringan option[value="${patient?.peringan?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#kualitas_nyeri option[value="${patient?.kualitas?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#frekuensi_nyeri option[value="${patient?.frekuensi?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#menjalar option[value="${patient?.menjalar?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`#jenis_nyeri option[value="${patient?.jenis?.id || ''}"]`).attr('selected', 'selected');
                            $(target).find(`input[name="tindak_lanjut"][value="${patient.tindak_lanjut_code}"]`).attr('checked', 'checked');

                            // diagnosis set value
                            var penyakit = patient.penyakit;
                            var kdPenyakitList = '';
                            var kdPenyakitListArr = [];
                            var diagnoseInputHtmlList = '';
                            var htmlDiagnoseListText = '';
                            
                            for(let d in penyakit) {
                                if(penyakit.hasOwnProperty(d)) {
                                    let diag = penyakit[d];

                                    kdPenyakitListArr.push(diag.kd_penyakit);

                                    htmlDiagnoseListText += `<a href="#" data-kode="${diag.kd_penyakit}" class="fw-bold btnListDiagnose text-decoration-none">
                                                                <div class="d-flex align-items-center justify-content-between">                            
                                                                    <p class="m-0 p-0">${diag.nama_penyakit}</p>
                                                                    <i class="ti-close text-danger"></i>
                                                                </div>
                                                            </a> <br>
                                                                
                                    `;

                                    diagnoseInputHtmlList += `<input type="hidden" name="diagnosis[]" class="diag-input" value="${diag.kd_penyakit}">`;

                                }
                            }
                            
                            $(target).find('#diagnoseList').html(htmlDiagnoseListText);
                            $(target).find('#diagnoseListInput').html(diagnoseInputHtmlList);
                        }
                    }
                }

                $(target).modal('show');
                // Ubah teks tombol jadi edit
                button.html('Edit');
                button.prop('disabled', false);
            },
            error: function (xhr, status, error) {
                // Penanganan jika terjadi error
                // console.log("Error:", error);
                // console.log("Status:", status);
                // console.log("XHR Object:", xhr);
                // alert("Terjadi kesalahan: " + error);
                showToast('error', 'internal server error');
            }
        });
    });

    // delete old diagnose list
    $(document).on('click', '#editCpptModal .btnListDiagnose', function(e) {
        e.preventDefault();
        
        var $this = $(this);
        var kdPenyakit = $this.attr('data-kode');
        var inputEl = $(`#editCpptModal .diag-input[value="${kdPenyakit}"]`);

        $($this).remove();
        $(inputEl).remove();
    })

    // add diagnose cppt edit
    var editDataListDiagnose = $('#editDiagnosisModal #dataList');
    var editDatalistDiagnoseAdd = $('#editDiagnosisModal #dataListAdd');
    var editSearchInputDiagnose = $('#editDiagnosisModal #searchInput');

    $(editSearchInputDiagnose).keyup(function () { 
        clearTimeout(typingTimer);
        typingTimer = setTimeout(function() {
            var $this = $('#editDiagnosisModal #searchInput');
            var url = "{{ route('cppt.get-icd10-ajax', [$dataMedis->pasien->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk))]) }}";

            $.ajax({
                type: "post",
                url: url,
                data: {
                    '_token': "{{ csrf_token() }}",
                    'data': $this.val()
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success') {
                        var dataDiag = response.data.diagnosa;
                        var dataDiagCount = response.data.count;
                        
                        var html = '';
                        if(dataDiagCount > 0) {
                            $.each(dataDiag, function (i, e) { 
                                html += `<li><a class="dropdown-item" data-kode="${e.kd_penyakit}" href="#">${e.penyakit}</a></li>`;
                            });
                        } else {
                            html += `<li><a class="dropdown-item" data-kode="" href="#">--Data tidak ditemukan--</a></li>`;
                        }

                        $(editDataListDiagnose).html(html);
                        $(editDataListDiagnose).show();
                    }
                }
            });
        }, debounceTime);
    });

    var editDiagnoseSelection = '';
    var editDiagnoseSelectionAll = '';
    var editDiagnoseSelectionText = [];

    $(document).on('click', '#editDiagnosisModal #dataList li', function(e) {
        var $this = $(this);
        var text = $this.find('.dropdown-item').text();
        var kode = $this.find('.dropdown-item').attr('data-kode');
        
        if(kode != '') {
            $(editSearchInputDiagnose).val(text);
            editDiagnoseSelection = kode;
            $(editDataListDiagnose).hide();
        }
    });

    $('#editDiagnosisModal #btnAddListDiagnosa').click(function(e) {
        e.preventDefault();
        var searchInputValue = $(editSearchInputDiagnose).val();
        
        if(searchInputValue != '') {
            $('#editDiagnosisModal #listDiagnosa').append(`<li>${searchInputValue}</li>`);
            editDiagnoseSelectionAll = $('#editDiagnosisModal #dataListAdd').val();
            editDiagnoseSelectionAll += (editDiagnoseSelectionAll != '') ? `,${editDiagnoseSelection}` : editDiagnoseSelection;

            $(editDatalistDiagnoseAdd).val(editDiagnoseSelectionAll);
            $(editSearchInputDiagnose).val('');
            editDiagnoseSelection = '';
        }
    });

    $('#editDiagnosisModal #btnSaveDiagnose').click(function(e) {
        var diagnoseListContent = '';
        var diagnoseInputHtmlList = '';

        var newKdDiagnoseVal = $('#editDiagnosisModal #dataListAdd').val();
        var newKdDiagnoseList = newKdDiagnoseVal.split(',');
        var newNameDiagnoseList = $('#editDiagnosisModal #listDiagnosa li');

        for (let i = 0; i < newNameDiagnoseList.length; i++) {
            var diagName = $(newNameDiagnoseList[i]).text();
            var diagCode = newKdDiagnoseList[i];

            diagnoseListContent += `<a href="#" data-kode="${diagCode}" class="fw-bold btnListDiagnose text-decoration-none">
                                        <div class="d-flex align-items-center justify-content-between">                            
                                            <p class="m-0 p-0">${diagName}</p>
                                            <i class="ti-close text-danger"></i>
                                        </div>
                                    </a> <br>
            `;

            diagnoseInputHtmlList += `<input type="hidden" name="diagnosis[]" class="diag-input" value="${diagCode}">`;
        }

        $('#editCpptModal #diagnoseList').html(diagnoseListContent);
        $('#editCpptModal #diagnoseListInput').html(diagnoseInputHtmlList);
        $('#editDiagnosisModal .btn-close').trigger('click');
    });


    // Button add diagnosis from edit cppt modal
    $('#editCpptModal #openEditDiagnosisModal').click(function(e) {
        var $this = $(this);
        var target = $this.attr('data-bs-target');

        var modalKedua = new bootstrap.Modal($(target), {
            backdrop: 'static', // Agar tidak menutup modal pertama ketika klik di luar modal kedua
            keyboard: false // Agar tidak bisa ditutup dengan tombol ESC
        });

        $(target).modal('show');
    });

    $('#editCpptModal #editDiagnosisModal').on('show.bs.modal', function(e) {
        var $this = $(this);
        var oldKdPenyakitList = $('#editCpptModal #diagnoseListInput .diag-input');
        var oldNamaPenyakitEl = $('#editCpptModal .btnListDiagnose p'); 
        
        var kdPenyakitList = '';
        var namaPenyakitArr = [];
        var listNamaPenyakitHtml = '';
        
        $.each(oldKdPenyakitList, function (i, el) { 
            if($(el).val() != '') {
                kdPenyakitList += (kdPenyakitList != '') ? ',' + $(el).val() : $(el).val();
            }
        });
        
        $.each(oldNamaPenyakitEl, function (i, el) { 
            var nmDiag = $(el).text();

            if(nmDiag != '') {
                listNamaPenyakitHtml += `<li>${nmDiag}</li>`;
            }
        });

        $this.find('#dataListAdd').val(kdPenyakitList);
        $this.find('#listDiagnosa').html(listNamaPenyakitHtml);
    });

    $('#editCpptModal input[name="skala_nyeri"]').change(function(e) {
        var $this = $(this);
        var skalaValue = $this.val();

        if(skalaValue > 10) {
            skalaValue = 10;
            $this.val(10);
        }

        if(skalaValue < 0) {
            skalaValue = 0;
            $this.val(0);
        }

        var valColor = 'btn-success';

        if(skalaValue > 3 && skalaValue <= 7) valColor = 'btn-warning';
        if(skalaValue > 7 && skalaValue <= 10) valColor = 'btn-danger';

        $('#editCpptModal #skalaNyeriBtn').removeClass('btn-success');
        $('#editCpptModal #skalaNyeriBtn').removeClass('btn-warning');
        $('#editCpptModal #skalaNyeriBtn').removeClass('btn-danger');
        $('#editCpptModal #skalaNyeriBtn').addClass(valColor);
    });

</script> --}}
@endpush
