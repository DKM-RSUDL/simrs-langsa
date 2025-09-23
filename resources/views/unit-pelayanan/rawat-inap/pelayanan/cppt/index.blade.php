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
            @include('components.navigation-ranap')

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
                        @include('unit-pelayanan.rawat-inap.pelayanan.cppt.modal')
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
                                            <form action="{{ route('rawat-inap.cppt.verifikasi', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" method="post">
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

    // GANTI KODE EDIT CPPT YANG SUDAH ADA DENGAN INI
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
        $this.prop('disabled', true);

        let url = "{{ route('rawat-inap.cppt.get-cppt-ajax', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}";

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

                            // Set key to input
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

                            // PERBAIKAN: Simpan data instruksi PPA untuk edit modal
                            console.log('Patient instruksi_ppa data:', patient.instruksi_ppa);
                            window.currentEditInstruksiPpaData = patient.instruksi_ppa || [];
                        }
                    }
                }

                // Tampilkan modal dulu
                $(target).modal('show');

                // PENTING: Initialize Instruksi PPA SETELAH modal ditampilkan
                setTimeout(() => {
                    console.log('Initializing edit PPA system...');
                    initEditInstruksiPpaSearchableSelect();
                    
                    // Load data PPA yang sudah disimpan
                    if (window.currentEditInstruksiPpaData && Array.isArray(window.currentEditInstruksiPpaData)) {
                        console.log('Loading PPA data:', window.currentEditInstruksiPpaData);
                        loadEditInstruksiPpaFromAjaxData(window.currentEditInstruksiPpaData);
                    } else {
                        console.log('No PPA data found, using empty array');
                        loadEditInstruksiPpaFromAjaxData([]);
                    }
                }, 800); // Delay lebih lama untuk memastikan modal benar-benar terbuka

                // Ubah teks tombol jadi edit
                button.html('Edit');
                button.prop('disabled', false);
            },
            error: function (xhr, status, error) {
                showToast('error', 'internal server error');
                button.html('Edit');
                button.prop('disabled', false);
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
        $('#editCpptModal #skalaNyeriBtn').text(skalaLabel);
    });

    $('#formEditCppt').submit(function(e) {
        let $this = $(this);
        let diagnoseNameEl = $this.find('input[name="diagnose_name[]"]');

        if(diagnoseNameEl.length < 1) {
            showToast('error', 'Diagnosa harus di tambah minimal 1!');
            return false;
        }
    });


    // ===========================================
    // SISTEM INSTRUKSI PPA - FIXED VERSION
    // Untuk Add Modal dan Edit Modal (Terpisah)
    // ===========================================

    // Data instruksi PPA untuk setiap CPPT (dari blade)
    const cpptInstruksiPpaData = {
        @foreach ($cppt as $key => $value)
            '{{ $value["urut_total"] }}': [
                @if(isset($value['instruksi_ppa']) && count($value['instruksi_ppa']) > 0)
                    @foreach ($value['instruksi_ppa'] as $instruksi)
                        {
                            ppa: '{{ $instruksi->ppa }}',
                            instruksi: '{{ addslashes($instruksi->instruksi) }}'
                        },
                    @endforeach
                @endif
            ],
        @endforeach
    };

    // Data karyawan
    const instruksiPpaKaryawanData = {
        @if(isset($karyawan) && count($karyawan) > 0)
            @foreach ($karyawan as $item)
                @php
                    $nama_lengkap = '';
                    if(!empty($item->gelar_depan)) $nama_lengkap .= $item->gelar_depan . ' ';
                    $nama_lengkap .= $item->nama;
                    if(!empty($item->gelar_belakang)) $nama_lengkap .= ', ' . $item->gelar_belakang;
                    $nama_lengkap_escaped = str_replace("'", "\\'", $nama_lengkap);
                @endphp
                '{{ $item->kd_karyawan }}': '{{ $nama_lengkap_escaped }}',
            @endforeach
        @endif
    };

    // Convert ke array untuk pencarian
    const karyawanArray = Object.keys(instruksiPpaKaryawanData).map(kode => ({
        kode: kode,
        nama: instruksiPpaKaryawanData[kode]
    }));

    // Global Variables untuk ADD Modal
    let addInstruksiPpaCounter = 0;
    let addInstruksiPpaData = [];
    let addSelectedPerawat = null;

    // Global Variables untuk EDIT Modal
    let editInstruksiPpaCounter = 0;
    let editInstruksiPpaData = [];
    let editSelectedPerawat = null;

    // ===========================================
    // HELPER FUNCTIONS
    // ===========================================

    // Helper function untuk get nama perawat dari kode
    function getPerawatNamaByKode(kode) {
        return instruksiPpaKaryawanData[kode] || kode;
    }

    // Escape HTML
    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.toString().replace(/[&<>"']/g, function(m) {
            return map[m];
        });
    }

    // Show alert (optional - bisa disesuaikan dengan sistem alert yang ada)
    function showInstruksiAlert(type, message) {
        // Bisa disesuaikan dengan sistem alert yang sudah ada
        console.log(`${type.toUpperCase()}: ${message}`);
        
        // Atau menggunakan sistem toast yang sudah ada
        if (typeof showToast === 'function') {
            showToast(type, message);
        }
    }

    // ===========================================
    // ADD MODAL FUNCTIONS
    // ===========================================

    // Initialize searchable select untuk ADD modal
    function initAddInstruksiPpaSearchableSelect() {
        const searchInput = $('#instruksi_ppa_search_input');
        const dropdown = $('#instruksi_ppa_dropdown');
        const hiddenInput = $('#instruksi_ppa_selected_value');

        // Clear previous events
        searchInput.off('input focus blur keydown');
        dropdown.off('click mouseenter');

        // Event ketik di input
        searchInput.on('input', function() {
            const query = $(this).val().toLowerCase();
            filterAddKaryawan(query);
        });

        // Event focus - tampilkan dropdown
        searchInput.on('focus', function() {
            dropdown.show();
            filterAddKaryawan($(this).val().toLowerCase());
        });

        // Event blur - sembunyikan dropdown setelah delay
        searchInput.on('blur', function() {
            setTimeout(() => {
                dropdown.hide();
            }, 200);
        });

        // Event keydown untuk navigasi
        searchInput.on('keydown', function(e) {
            const items = dropdown.find('.dropdown-item:visible');
            const active = dropdown.find('.dropdown-item.active');

            if (e.keyCode === 40) { // Arrow down
                e.preventDefault();
                if (active.length === 0) {
                    items.first().addClass('active');
                } else {
                    active.removeClass('active');
                    const next = active.nextAll('.dropdown-item:visible').first();
                    if (next.length > 0) {
                        next.addClass('active');
                    } else {
                        items.first().addClass('active');
                    }
                }
            } else if (e.keyCode === 38) { // Arrow up
                e.preventDefault();
                if (active.length === 0) {
                    items.last().addClass('active');
                } else {
                    active.removeClass('active');
                    const prev = active.prevAll('.dropdown-item:visible').first();
                    if (prev.length > 0) {
                        prev.addClass('active');
                    } else {
                        items.last().addClass('active');
                    }
                }
            } else if (e.keyCode === 13) { // Enter
                e.preventDefault();
                if (active.length > 0) {
                    active.click();
                }
            }
        });

        // Generate dropdown items untuk ADD
        generateAddDropdownItems();
    }

    // Generate dropdown items untuk ADD modal
    function generateAddDropdownItems() {
        const dropdown = $('#instruksi_ppa_dropdown');
        dropdown.empty();

        // Tambah opsi kosong
        dropdown.append(`
            <div class="dropdown-item" data-kode="" data-nama="">
                <span class="text-muted">-- Pilih Perawat/PPA --</span>
            </div>
        `);

        // Tambah opsi karyawan
        karyawanArray.forEach(item => {
            dropdown.append(`
                <div class="dropdown-item" data-kode="${item.kode}" data-nama="${escapeHtml(item.nama)}">
                    <i class="bi bi-person-badge text-primary me-2"></i>
                    ${escapeHtml(item.nama)}
                </div>
            `);
        });

        // Event click pada item
        dropdown.on('click', '.dropdown-item', function() {
            const kode = $(this).data('kode');
            const nama = $(this).data('nama');
            selectAddPerawat(kode, nama);
            dropdown.hide();
        });

        // Hover effect
        dropdown.on('mouseenter', '.dropdown-item', function() {
            dropdown.find('.dropdown-item.active').removeClass('active');
            $(this).addClass('active');
        });
    }

    // Filter karyawan untuk ADD modal
    function filterAddKaryawan(query) {
        const dropdown = $('#instruksi_ppa_dropdown');
        const items = dropdown.find('.dropdown-item');

        if (query === '') {
            items.show();
            return;
        }

        items.each(function() {
            const nama = $(this).text().toLowerCase();
            if (nama.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        dropdown.find('.dropdown-item.active').removeClass('active');
    }

    // Select perawat untuk ADD modal
    function selectAddPerawat(kode, nama) {
        const searchInput = $('#instruksi_ppa_search_input');
        const hiddenInput = $('#instruksi_ppa_selected_value');

        addSelectedPerawat = kode ? { kode: kode, nama: nama } : null;

        searchInput.val(nama || '');
        hiddenInput.val(kode || '');

        if (kode) {
            searchInput.removeClass('is-invalid').addClass('is-valid');
        } else {
            searchInput.removeClass('is-valid is-invalid');
        }
    }

    // Update tabel untuk ADD modal
    function updateAddInstruksiPpaTable() {
        const tbody = $('#instruksi_ppa_table_body');
        tbody.empty();

        if (addInstruksiPpaData.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        Belum ada instruksi yang ditambahkan
                    </td>
                </tr>
            `);
        } else {
            addInstruksiPpaData.forEach((item, index) => {
                tbody.append(`
                    <tr>
                        <td class="text-center fw-bold">${index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-badge text-primary me-2"></i>
                                <div>
                                    <strong>${escapeHtml(item.perawat_nama)}</strong><br>
                                    <small class="text-muted">${escapeHtml(item.perawat_kode)}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="mb-2">${escapeHtml(item.instruksi)}</div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="hapusAddInstruksiPpa(${item.id})"
                                    title="Hapus Instruksi">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }
    }

    // Update hidden inputs untuk ADD modal
    function updateAddInstruksiPpaHiddenInputs() {
        const container = $('#instruksi_ppa_hidden_inputs');
        container.empty();

        // Generate hidden inputs dalam format array
        addInstruksiPpaData.forEach((item, index) => {
            container.append(`
                <input type="hidden" name="perawat_kode[]" value="${escapeHtml(item.perawat_kode)}">
                <input type="hidden" name="perawat_nama[]" value="${escapeHtml(item.perawat_nama)}">
                <input type="hidden" name="instruksi_text[]" value="${escapeHtml(item.instruksi)}">
            `);
        });
    }

    // Update count badge untuk ADD modal
    function updateAddInstruksiPpaCountBadge() {
        const count = addInstruksiPpaData.length;
        const badge = $('#instruksi_ppa_count_badge');

        badge.text(count);
        badge.removeClass('bg-primary bg-success bg-warning bg-danger bg-secondary');

        if (count === 0) {
            badge.addClass('bg-secondary');
        } else if (count <= 2) {
            badge.addClass('bg-success');
        } else if (count <= 5) {
            badge.addClass('bg-primary');
        } else {
            badge.addClass('bg-warning');
        }
    }

    // Reset data untuk ADD modal
    function resetAddInstruksiPpaData() {
        addInstruksiPpaData = [];
        addInstruksiPpaCounter = 0;
        addSelectedPerawat = null;
        
        updateAddInstruksiPpaTable();
        updateAddInstruksiPpaCountBadge();

        // Clear form
        selectAddPerawat('', '');
        $('#instruksi_ppa_text_input').val('');
    }

    // Hapus instruksi untuk ADD modal
    function hapusAddInstruksiPpa(id) {
        const instruksi = addInstruksiPpaData.find(item => item.id === id);
        if (!instruksi) return;

        if (confirm(`Apakah Anda yakin ingin menghapus instruksi untuk: ${instruksi.perawat_nama}?`)) {
            addInstruksiPpaData = addInstruksiPpaData.filter(item => item.id !== id);
            updateAddInstruksiPpaTable();
            updateAddInstruksiPpaHiddenInputs();
            updateAddInstruksiPpaCountBadge();
            showInstruksiAlert('success', 'Instruksi berhasil dihapus!');
        }
    }

    // ===========================================
    // EDIT MODAL FUNCTIONS
    // ===========================================

    // Initialize searchable select untuk EDIT modal
    function initEditInstruksiPpaSearchableSelect() {
        const searchInput = $('#edit_instruksi_ppa_search_input');
        const dropdown = $('#edit_instruksi_ppa_dropdown');
        const hiddenInput = $('#edit_instruksi_ppa_selected_value');

        // Clear previous events
        searchInput.off('input focus blur keydown');
        dropdown.off('click mouseenter');

        // Event ketik di input
        searchInput.on('input', function() {
            const query = $(this).val().toLowerCase();
            filterEditKaryawan(query);
        });

        // Event focus - tampilkan dropdown
        searchInput.on('focus', function() {
            dropdown.show();
            filterEditKaryawan($(this).val().toLowerCase());
        });

        // Event blur - sembunyikan dropdown setelah delay
        searchInput.on('blur', function() {
            setTimeout(() => {
                dropdown.hide();
            }, 200);
        });

        // Event keydown untuk navigasi
        searchInput.on('keydown', function(e) {
            const items = dropdown.find('.dropdown-item:visible');
            const active = dropdown.find('.dropdown-item.active');

            if (e.keyCode === 40) { // Arrow down
                e.preventDefault();
                if (active.length === 0) {
                    items.first().addClass('active');
                } else {
                    active.removeClass('active');
                    const next = active.nextAll('.dropdown-item:visible').first();
                    if (next.length > 0) {
                        next.addClass('active');
                    } else {
                        items.first().addClass('active');
                    }
                }
            } else if (e.keyCode === 38) { // Arrow up
                e.preventDefault();
                if (active.length === 0) {
                    items.last().addClass('active');
                } else {
                    active.removeClass('active');
                    const prev = active.prevAll('.dropdown-item:visible').first();
                    if (prev.length > 0) {
                        prev.addClass('active');
                    } else {
                        items.last().addClass('active');
                    }
                }
            } else if (e.keyCode === 13) { // Enter
                e.preventDefault();
                if (active.length > 0) {
                    active.click();
                }
            }
        });

        // Generate dropdown items untuk EDIT
        generateEditDropdownItems();
    }

    // Generate dropdown items untuk EDIT modal
    function generateEditDropdownItems() {
        const dropdown = $('#edit_instruksi_ppa_dropdown');
        dropdown.empty();

        // Tambah opsi kosong
        dropdown.append(`
            <div class="dropdown-item" data-kode="" data-nama="">
                <span class="text-muted">-- Pilih Perawat/PPA --</span>
            </div>
        `);

        // Tambah opsi karyawan
        karyawanArray.forEach(item => {
            dropdown.append(`
                <div class="dropdown-item" data-kode="${item.kode}" data-nama="${escapeHtml(item.nama)}">
                    <i class="bi bi-person-badge text-primary me-2"></i>
                    ${escapeHtml(item.nama)}
                </div>
            `);
        });

        // Event click pada item
        dropdown.on('click', '.dropdown-item', function() {
            const kode = $(this).data('kode');
            const nama = $(this).data('nama');
            selectEditPerawat(kode, nama);
            dropdown.hide();
        });

        // Hover effect
        dropdown.on('mouseenter', '.dropdown-item', function() {
            dropdown.find('.dropdown-item.active').removeClass('active');
            $(this).addClass('active');
        });
    }

    // Filter karyawan untuk EDIT modal
    function filterEditKaryawan(query) {
        const dropdown = $('#edit_instruksi_ppa_dropdown');
        const items = dropdown.find('.dropdown-item');

        if (query === '') {
            items.show();
            return;
        }

        items.each(function() {
            const nama = $(this).text().toLowerCase();
            if (nama.includes(query)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        dropdown.find('.dropdown-item.active').removeClass('active');
    }

    // Select perawat untuk EDIT modal
    function selectEditPerawat(kode, nama) {
        const searchInput = $('#edit_instruksi_ppa_search_input');
        const hiddenInput = $('#edit_instruksi_ppa_selected_value');

        editSelectedPerawat = kode ? { kode: kode, nama: nama } : null;

        searchInput.val(nama || '');
        hiddenInput.val(kode || '');

        if (kode) {
            searchInput.removeClass('is-invalid').addClass('is-valid');
        } else {
            searchInput.removeClass('is-valid is-invalid');
        }
    }

    // Update tabel untuk EDIT modal
    function updateEditInstruksiPpaTable() {
        const tbody = $('#edit_instruksi_ppa_table_body');
        tbody.empty();

        if (editInstruksiPpaData.length === 0) {
            tbody.append(`
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                        Belum ada instruksi yang ditambahkan
                    </td>
                </tr>
            `);
        } else {
            editInstruksiPpaData.forEach((item, index) => {
                tbody.append(`
                    <tr>
                        <td class="text-center fw-bold">${index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-badge text-primary me-2"></i>
                                <div>
                                    <strong>${escapeHtml(item.perawat_nama)}</strong><br>
                                    <small class="text-muted">${escapeHtml(item.perawat_kode)}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="mb-2">${escapeHtml(item.instruksi)}</div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="hapusEditInstruksiPpa(${item.id})"
                                    title="Hapus Instruksi">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }
    }

    // Update hidden inputs untuk EDIT modal
    function updateEditInstruksiPpaHiddenInputs() {
        const container = $('#edit_instruksi_ppa_hidden_inputs');
        container.empty();

        // Generate hidden inputs dalam format array
        editInstruksiPpaData.forEach((item, index) => {
            container.append(`
                <input type="hidden" name="perawat_kode[]" value="${escapeHtml(item.perawat_kode)}">
                <input type="hidden" name="perawat_nama[]" value="${escapeHtml(item.perawat_nama)}">
                <input type="hidden" name="instruksi_text[]" value="${escapeHtml(item.instruksi)}">
            `);
        });
    }

    // Update count badge untuk EDIT modal
    function updateEditInstruksiPpaCountBadge() {
        const count = editInstruksiPpaData.length;
        const badge = $('#edit_instruksi_ppa_count_badge');

        badge.text(count);
        badge.removeClass('bg-primary bg-success bg-warning bg-danger bg-secondary');

        if (count === 0) {
            badge.addClass('bg-secondary');
        } else if (count <= 2) {
            badge.addClass('bg-success');
        } else if (count <= 5) {
            badge.addClass('bg-primary');
        } else {
            badge.addClass('bg-warning');
        }
    }

    // Load instruksi PPA dari AJAX response untuk EDIT modal
    function loadEditInstruksiPpaFromAjaxData(instruksiPpaArray) {
        // Reset data
        editInstruksiPpaData = [];
        editInstruksiPpaCounter = 0;

        // instruksiPpaArray sudah dalam format yang benar dari AJAX response
        if (instruksiPpaArray && Array.isArray(instruksiPpaArray)) {
            instruksiPpaArray.forEach(function(item) {
                editInstruksiPpaCounter++;
                editInstruksiPpaData.push({
                    id: editInstruksiPpaCounter,
                    perawat_kode: item.ppa,
                    perawat_nama: getPerawatNamaByKode(item.ppa),
                    instruksi: item.instruksi,
                    created_at: new Date().toLocaleString('id-ID')
                });
            });
        }

        // Update tampilan
        updateEditInstruksiPpaTable();
        updateEditInstruksiPpaHiddenInputs();
        updateEditInstruksiPpaCountBadge();
    }

    // Backward compatibility - untuk hardcode data (bisa dihapus nanti)
    function loadEditInstruksiPpaFromHardcode(urutTotal) {
        const instruksiList = cpptInstruksiPpaData[urutTotal] || [];
        loadEditInstruksiPpaFromAjaxData(instruksiList);
    }

    // Reset data untuk EDIT modal
    function resetEditInstruksiPpaData() {
        editInstruksiPpaData = [];
        editInstruksiPpaCounter = 0;
        editSelectedPerawat = null;
        
        updateEditInstruksiPpaTable();
        updateEditInstruksiPpaCountBadge();

        // Clear form
        selectEditPerawat('', '');
        $('#edit_instruksi_ppa_text_input').val('');
    }

    // Hapus instruksi untuk EDIT modal
    function hapusEditInstruksiPpa(id) {
        const instruksi = editInstruksiPpaData.find(item => item.id === id);
        if (!instruksi) return;

        if (confirm(`Apakah Anda yakin ingin menghapus instruksi untuk: ${instruksi.perawat_nama}?`)) {
            editInstruksiPpaData = editInstruksiPpaData.filter(item => item.id !== id);
            updateEditInstruksiPpaTable();
            updateEditInstruksiPpaHiddenInputs();
            updateEditInstruksiPpaCountBadge();
            showInstruksiAlert('success', 'Instruksi berhasil dihapus!');
        }
    }

    // ===========================================
    // EVENT HANDLERS
    // ===========================================

    // Initialize saat document ready
    $(document).ready(function() {
        console.log('Inisialisasi PPA Instruction System...');
        
        // Initialize ADD modal
        initAddInstruksiPpaSearchableSelect();
    });

    // Event handler untuk button tambah di ADD modal
    $(document).on('click', '#instruksi_ppa_tambah_btn', function() {
        const perawatKode = $('#instruksi_ppa_selected_value').val();
        const perawatNama = addSelectedPerawat ? addSelectedPerawat.nama : '';
        const instruksi = $('#instruksi_ppa_text_input').val().trim();

        // Validasi
        if (!perawatKode || perawatKode === '') {
            showInstruksiAlert('warning', 'Silakan pilih nama perawat terlebih dahulu!');
            $('#instruksi_ppa_search_input').removeClass('is-valid').addClass('is-invalid').focus();
            return;
        }

        if (!instruksi) {
            showInstruksiAlert('warning', 'Silakan isi instruksi terlebih dahulu!');
            $('#instruksi_ppa_text_input').focus();
            return;
        }

        // Tambah data
        addInstruksiPpaCounter++;
        const newInstruksi = {
            id: addInstruksiPpaCounter,
            perawat_kode: perawatKode,
            perawat_nama: perawatNama,
            instruksi: instruksi,
            created_at: new Date().toLocaleString('id-ID')
        };

        addInstruksiPpaData.push(newInstruksi);

        // Update tampilan
        updateAddInstruksiPpaTable();
        updateAddInstruksiPpaHiddenInputs();
        updateAddInstruksiPpaCountBadge();

        // Clear form
        selectAddPerawat('', '');
        $('#instruksi_ppa_text_input').val('');
        $('#instruksi_ppa_search_input').focus();

        showInstruksiAlert('success', `Instruksi untuk ${perawatNama} berhasil ditambahkan!`);
    });

    // Event handler untuk button tambah di EDIT modal
    $(document).on('click', '#edit_instruksi_ppa_tambah_btn', function() {
        const perawatKode = $('#edit_instruksi_ppa_selected_value').val();
        const perawatNama = editSelectedPerawat ? editSelectedPerawat.nama : '';
        const instruksi = $('#edit_instruksi_ppa_text_input').val().trim();

        // Validasi
        if (!perawatKode || perawatKode === '') {
            showInstruksiAlert('warning', 'Silakan pilih nama perawat terlebih dahulu!');
            $('#edit_instruksi_ppa_search_input').removeClass('is-valid').addClass('is-invalid').focus();
            return;
        }

        if (!instruksi) {
            showInstruksiAlert('warning', 'Silakan isi instruksi terlebih dahulu!');
            $('#edit_instruksi_ppa_text_input').focus();
            return;
        }

        // Tambah data
        editInstruksiPpaCounter++;
        const newInstruksi = {
            id: editInstruksiPpaCounter,
            perawat_kode: perawatKode,
            perawat_nama: perawatNama,
            instruksi: instruksi,
            created_at: new Date().toLocaleString('id-ID')
        };

        editInstruksiPpaData.push(newInstruksi);

        // Update tampilan
        updateEditInstruksiPpaTable();
        updateEditInstruksiPpaHiddenInputs();
        updateEditInstruksiPpaCountBadge();

        // Clear form
        selectEditPerawat('', '');
        $('#edit_instruksi_ppa_text_input').val('');
        $('#edit_instruksi_ppa_search_input').focus();

        showInstruksiAlert('success', `Instruksi untuk ${perawatNama} berhasil ditambahkan!`);
    });

    // Event handler untuk enter key di ADD modal
    $(document).on('keypress', '#instruksi_ppa_text_input', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#instruksi_ppa_tambah_btn').click();
        }
    });

    // Event handler untuk enter key di EDIT modal
    $(document).on('keypress', '#edit_instruksi_ppa_text_input', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('#edit_instruksi_ppa_tambah_btn').click();
        }
    });

    // ===========================================
    // MODAL EVENT HANDLERS
    // ===========================================

    // Event saat modal ADD dibuka
    $('#addCpptModal').on('show.bs.modal', function() {
        resetAddInstruksiPpaData();
        initAddInstruksiPpaSearchableSelect();
    });

    // Event saat modal ADD ditutup
    $('#addCpptModal').on('hidden.bs.modal', function() {
        resetAddInstruksiPpaData();
    });

    // Event saat modal EDIT dibuka
    $('#editCpptModal').on('show.bs.modal', function() {
        initEditInstruksiPpaSearchableSelect();
    });

    // Event saat modal EDIT ditutup
    $('#editCpptModal').on('hidden.bs.modal', function() {
        resetEditInstruksiPpaData();
    });

    // ===========================================
    // INTEGRATION DENGAN KODE YANG SUDAH ADA
    // ===========================================

    // Modifikasi event click edit CPPT yang sudah ada
    // Tambahkan ini ke dalam success callback AJAX yang sudah ada
    function initEditModalWithPpaData(urutTotalData) {
        // Set timeout untuk memastikan modal sudah terbuka
        setTimeout(() => {
            initEditInstruksiPpaSearchableSelect();
            loadEditInstruksiPpaFromHardcode(urutTotalData);
        }, 100);
    }
</script>
@endpush
