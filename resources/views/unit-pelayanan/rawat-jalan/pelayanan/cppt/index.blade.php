@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .patient-card .nav-link.active {
            background-color: #0056b3;
            color: #fff;
        }

        .patient-card .nav-link.active small {
            color: white !important;
        }

        .patient-card img.rounded-circle {
            object-fit: cover;
        }

        .tab-content {
            flex-grow: 1;
            width: 350px;
        }

        .select2-container {
            z-index: 9999;
        }

        .modal-dialog {
            z-index: 1050 !important;
        }

        .modal-content {
            overflow: visible !important;
        }

        .select2-dropdown {
            z-index: 99999 !important;
        }

        /* Menghilangkan elemen Select2 yang tidak diinginkan */
        .select2-container+.select2-container {
            display: none;
        }

        /* Menyamakan tampilan Select2 dengan Bootstrap */
        .select2-container--default .select2-selection--single {
            height: calc(1.5em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 0;
            padding-right: 0;
            color: #495057;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + 0.75rem);
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #6c757d transparent transparent transparent;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent #6c757d transparent;
        }

        .select2-container--default .select2-dropdown {
            border-color: #80bdff;
            border-radius: 0.25rem;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #007bff;
        }

        /* Fokus */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-rajal')

            <!-- Content -->
            <div class="patient-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-primary mb-0">Catatan Perkembangan Pasien Terintegrasi</h6>
                    <h6 class="text-secondary mb-0">Grafik</h6>
                </div>

                <form
                    action="{{ route('rawat-jalan.cppt.search', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    <div class="row g-3">
                        <!-- Select PPA Option -->
                        <div class="col-md-2">
                            <select class="form-select" name="ppa" id="selectPpa">
                                <option value="" selected>Semua PPA</option>
                                <option value="dokter_spesialis">Dokter Spesialis</option>
                                <option value="dokter_umum">Dokter Umum</option>
                                <option value="perawat">Perawat/bidan</option>
                                <option value="nutrisionis">Nutrisionis</option>
                                <option value="apoteker">Apoteker</option>
                                <option value="fisioterapis">Fisioterapis</option>
                            </select>
                        </div>

                        <!-- Select Episode Option -->
                        <div class="col-md-2">
                            <select class="form-select" name="episode" id="SelectEpisode">
                                <option value="" selected>Semua Episode</option>
                                <option value="sekarang">Episode Sekarang</option>
                                <option value="1_bulan">1 Bulan</option>
                                <option value="3_bulan">3 Bulan</option>
                                <option value="6_bulan">6 Bulan</option>
                                <option value="9_bulan">9 Bulan</option>
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-2">
                            <input type="date" name="tgl_awal" id="tgl_awal" class="form-control"
                                placeholder="Dari Tanggal">
                        </div>

                        <!-- End Date -->
                        <div class="col-md-2">
                            <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control"
                                placeholder="S.d Tanggal">
                        </div>

                        <!-- Search Bar -->
                        <div class="col-md-2">
                            <div class="input-group mb-3">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                </form>

                <!-- Add Button -->
                <!-- Include the modal file -->
                <div class="col-md-2">
                    <div class="d-grid gap-2">
                        <button class="btn mb-2 btn-primary" data-bs-toggle="modal" data-bs-target="#addCpptModal"
                            type="button">
                            <i class="ti-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="d-flex align-items-start">
                    <!-- Sidebar navigation -->
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($cppt as $key => $value)
                            <button class="nav-link @if ($i == 0) active @endif"
                                id="v-pills-home-tab-{{ $i }}" data-bs-toggle="pill"
                                href="#v-pills-home-{{ $i }}" role="tab" aria-selected="{{ $i == 0 }}">
                                <div class="d-flex align-items-center">
                                    <div class="text-center me-2">
                                        <strong class="d-block">
                                            {{ date('d M', strtotime($value['tanggal'])) }}
                                        </strong>
                                        <small class="d-block">
                                            {{ date('H:i', strtotime($value['jam'])) }}
                                        </small>
                                    </div>
                                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="Avatar" class="rounded-circle"
                                        width="50" height="50">
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
                                    <p class="mb-0 text-end">{{ date('d M Y', strtotime($value['tanggal'])) }}
                                        {{ date('H:i', strtotime($value['jam'])) }}</p>
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
                                                <div class="col-md-6 mb-2">
                                                    {{ $val['nama_kondisi'] . ' : ' . $val['hasil'] . ' ' . $val['satuan'] }}
                                                </div>
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
                                        <form
                                            action="{{ route('rawat-jalan.cppt.verifikasi', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                                            method="post">
                                            @csrf
                                            @method('put')

                                            <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                                            <input type="hidden" name="no_transaksi"
                                                value="{{ $dataMedis->no_transaksi }}">
                                            <input type="hidden" name="kd_kasir" value="{{ $dataMedis->kd_kasir }}">
                                            <input type="hidden" name="tanggal" value="{{ $value['tanggal'] }}">
                                            <input type="hidden" name="urut" value="{{ $value['urut'] }}">
                                            <button type="submit" class="btn btn-primary">Verifikasi DPJP</button>
                                        </form>
                                    @endif

                                    <button class="btn btn-primary btn-edit-cppt" data-bs-target="#editCpptModal"
                                        data-tgl="{{ $value['tanggal'] }}" data-urut="{{ $value['urut'] }}"
                                        data-unit="{{ $value['kd_unit'] }}"
                                        data-transaksi="{{ $value['no_transaksi'] }}"
                                        data-urut-total="{{ $value['urut_total'] }}">Edit</button>
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

    @include('unit-pelayanan.rawat-jalan.pelayanan.cppt.modal')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            initSelect2();
        });

        // form konsul validate
        function checkKonsulFormValidation(modal = '') {
            let formFields = {
                'Dokter Pengirim': $(`${modal} #konsulModal #dokter_pengirim`).val(),
                'Tanggal Konsul': $(`${modal} #konsulModal #tgl_konsul`).val(),
                'Jam Konsul': $(`${modal} #konsulModal #jam_konsul`).val(),
                'Unit Tujuan': $(`${modal} #konsulModal #unit_tujuan`).val(),
                'Dokter Tujuan': $(`${modal} #konsulModal #dokter_unit_tujuan`).val(),
                'Konsulen Harap': $(`${modal} #konsulModal input[name="konsulen_harap"]:checked`).val(),
                'Catatan': $(`${modal} #konsulModal #catatan`).val(),
                'Konsul': $(`${modal} #konsulModal #konsul`).val()
            };

            // Cek field kosong
            let emptyFields = Object.entries(formFields)
                .filter(([_, value]) => !value || value.trim() === '')
                .map(([key, _]) => key);

            if (emptyFields.length > 0) {
                showToast('error', `Kolom berikut masih kosong: ${emptyFields.join(', ')}`);
                return false;
            }

            let unitTujuan = $(`${modal} #konsulModal #unit_tujuan`).val();
            let namaUnitTujuan = $(`${modal} #konsulModal #unit_tujuan option[value="${unitTujuan}"]`).text();
            $(`${modal} #unit-rujuk-internal-label`).text(namaUnitTujuan);
            return true;
        }

        // form kontrol ulang validate
        function checkKontrolFormValidation(modal = '') {
            let tglKontrol = $(`${modal} #kontrolModal #tgl_kontrol`).val();

            if (tglKontrol == '') {
                showToast('error', 'Tanggal kontrol harus di isi!');
                return false;
            }


            $(`${modal} #tgl-kontrol-label`).text(tglKontrol);
            return true;
        }

        // form kontrol ulang validate
        function checkRSLainFormValidation(modal = '') {
            let namaRS = $(`${modal} #rsLainModal #nama_rs`).val();
            let bagianRS = $(`${modal} #rsLainModal #bagian_rs`).val();

            let formFields = {
                'RS Tujuan': namaRS,
                'Bagian RS Tujuan': bagianRS,
            };

            // Cek field kosong
            let emptyFields = Object.entries(formFields)
                .filter(([_, value]) => !value || value.trim() === '')
                .map(([key, _]) => key);

            if (emptyFields.length > 0) {
                showToast('error', `Kolom berikut masih kosong: ${emptyFields.join(', ')}`);
                return false;
            }

            $(`${modal} #rs-tujuan-label`).text(`${bagianRS} (${namaRS})`);
            return true;
        }

        // konsultasi form
        // Reinisialisasi Select2 ketika modal dibuka
        $('#addCpptModal .konsul-modal').on('shown.bs.modal', function() {
            // Destroy existing Select2 instance before reinitializing
            initSelect2();

        });

        function initSelect2() {
            $('#addCpptModal .konsul-modal .form-select').select2({
                dropdownParent: $('#addCpptModal .konsul-modal'),
                width: '100%'
            });
        }

        // unit di pilih / diubah
        $('.konsul-modal #unit_tujuan').on('change', function(e) {
            // let $selectedOption = $(e.currentTarget).find("option:selected");
            // let optVal = $selectedOption.val();
            let $this = $(this);
            let optVal = $this.val();

            $.ajax({
                type: "post",
                url: "{{ route('konsultasi.get-dokter-unit', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "kd_unit": optVal
                },
                dataType: "json",
                beforeSend: function() {
                    $('.konsul-modal #dokter_unit_tujuan').prop('disabled', true);
                },
                complete: function() {
                    $('.konsul-modal #dokter_unit_tujuan').prop('disabled', false);
                },
                success: function(res) {

                    if (res.status == 'success') {
                        let data = res.data;
                        let optHtml = '<option value="">--Pilih Dokter--</option>';

                        data.forEach(e => {
                            optHtml +=
                                `<option value="${e.dokter.kd_dokter}">${e.dokter.nama_lengkap}</option>`;
                        });

                        $('.konsul-modal #dokter_unit_tujuan').html(optHtml);
                    } else {
                        showToast('error', 'Internet server error');
                    }

                },
                error: function(xhr, status, error) {
                    showToast('error', 'Internal server error');
                }
            });

        });

        // add
        var searchInputDiagnose = $('#addDiagnosisModal #searchInput');
        var dataListDiagnose = $('#addDiagnosisModal #dataList');

        $('#addDiagnosisModal #btnAddListDiagnosa').click(function(e) {
            e.preventDefault();
            var searchInputValue = $(searchInputDiagnose).val();

            if (searchInputValue != '') {
                $('#listDiagnosa').append(`<li>${searchInputValue}</li>`);
                $(searchInputDiagnose).val('');
            }
        });

        $('#addDiagnosisModal #btnSaveDiagnose').click(function(e) {

            var dignoseListContent = '';
            let diagnoses = $('#addDiagnosisModal #listDiagnosa li');

            $(diagnoses).each(function(i, e) {
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

            if (skalaValue > 10) {
                skalaValue = 10;
                $this.val(10);
            }

            if (skalaValue < 0) {
                skalaValue = 0;
                $this.val(0);
            }

            var valColor = 'btn-success';
            let skalaLabel = 'Tidak Nyeri'

            if (skalaValue > 1 && skalaValue <= 3) skalaLabel = "Nyeri Ringan";
            if (skalaValue > 3 && skalaValue <= 5) skalaLabel = "Nyeri Sedang";
            if (skalaValue > 5 && skalaValue <= 7) skalaLabel = "Nyeri Parah";
            if (skalaValue > 7 && skalaValue <= 9) skalaLabel = "Nyeri Sangat Parah";
            if (skalaValue > 9) skalaLabel = "Nyeri Terburuk";

            if (skalaValue > 3 && skalaValue <= 7) valColor = 'btn-warning';
            if (skalaValue > 7 && skalaValue <= 10) valColor = 'btn-danger';

            $('#addCpptModal #skalaNyeriBtn').removeClass('btn-success');
            $('#addCpptModal #skalaNyeriBtn').removeClass('btn-warning');
            $('#addCpptModal #skalaNyeriBtn').removeClass('btn-danger');
            $('#addCpptModal #skalaNyeriBtn').addClass(valColor);
            $('#addCpptModal #skalaNyeriBtn').text(skalaLabel);
        });

        // konsul
        $('#addCpptModal #plan_rujuk_internal').click(function(e) {
            let modalKedua = new bootstrap.Modal($('#addCpptModal #konsulModal'), {
                backdrop: 'static',
                // keyboard: false
            });

            modalKedua.show();
        });

        $('#addCpptModal #konsulModal .btn-save-konsul').click(function(e) {
            // get value konsul
            let $this = $(this);
            if (checkKonsulFormValidation('#addCpptModal')) $('#addCpptModal #konsulModal').modal('hide');
        });

        // kontrol ulang
        $('#addCpptModal #plan_konrol_ulang').click(function(e) {
            let modalKedua = new bootstrap.Modal($('#addCpptModal #kontrolModal'), {
                backdrop: 'static',
                // keyboard: false
            });

            modalKedua.show();
        });

        $('#addCpptModal #kontrolModal .btn-save-kontrol').click(function(e) {
            // get value konsul
            let $this = $(this);
            if (checkKontrolFormValidation('#addCpptModal')) $('#addCpptModal #kontrolModal').modal('hide');
        });

        // rujuk RS Lain
        $('#addCpptModal #plan_rujuk').click(function(e) {
            let modalKedua = new bootstrap.Modal($('#addCpptModal #rsLainModal'), {
                backdrop: 'static',
                // keyboard: false
            });

            modalKedua.show();
        });

        $('#addCpptModal #rsLainModal .btn-save-rs-lain').click(function(e) {
            // get value konsul
            let $this = $(this);
            if (checkRSLainFormValidation('#addCpptModal')) $('#addCpptModal #rsLainModal').modal('hide');
        });

        $('#formAddCppt').submit(function(e) {
            let $this = $(this);
            let diagnoseNameEl = $this.find('input[name="diagnose_name[]"]');
            let tindakLanjut = $this.find('input[name="tindak_lanjut"]:checked').val();

            if (diagnoseNameEl.length < 1) {
                showToast('error', 'Diagnosa harus di tambah minimal 1!');
                return false;
            }

            // Tindak Lanjut Konsul
            if (tindakLanjut == 4) {
                if (!checkKonsulFormValidation('#addCpptModal')) return false;
            }

            // Tindak Lanjut kontrol ulang
            if (tindakLanjut == 2) {
                if (!checkKontrolFormValidation('#addCpptModal')) return false;
            }

            // Tindak Lanjut rujuk rs lain
            if (tindakLanjut == 5) {
                if (!checkRSLainFormValidation('#addCpptModal')) return false;
            }

        });

        // edit
        var tanggal, urut, unit, button;
        var editDataListDiagnose = $('#editDiagnosisModal #dataList');
        var editSearchInputDiagnose = $('#editDiagnosisModal #searchInput');
        let cpptDataDetail;

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
            $this.html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Proses...'
            );
            $this.prop('disabled', true); // Nonaktifkan tombol selama proses berlangsung


            let url =
                "{{ route('rawat-jalan.cppt.get-cppt-ajax', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}";

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
                success: function(response) {

                    if (response.status == 'success') {
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

                                if (skalaNyeri > 1 && skalaNyeri <= 3) skalaLabel = "Nyeri Ringan";
                                if (skalaNyeri > 3 && skalaNyeri <= 5) skalaLabel = "Nyeri Sedang";
                                if (skalaNyeri > 5 && skalaNyeri <= 7) skalaLabel = "Nyeri Parah";
                                if (skalaNyeri > 7 && skalaNyeri <= 9) skalaLabel =
                                    "Nyeri Sangat Parah";
                                if (skalaNyeri > 9) skalaLabel = "Nyeri Terburuk";

                                if (skalaNyeri > 3 && skalaNyeri <= 7) valColor = 'btn-warning';
                                if (skalaNyeri > 7 && skalaNyeri <= 10) valColor = 'btn-danger';

                                $(target).find('#skalaNyeriBtn').removeClass('btn-success');
                                $(target).find('#skalaNyeriBtn').removeClass('btn-warning');
                                $(target).find('#skalaNyeriBtn').removeClass('btn-danger');
                                $(target).find('#skalaNyeriBtn').addClass(valColor);
                                $(target).find('#skalaNyeriBtn').text(skalaLabel);

                                $(target).find('#skala_nyeri').val(skalaNyeri);

                                // tanda vital set value
                                var kondisi = patient.kondisi;
                                var konpas = kondisi.konpas;

                                for (let i in konpas) {
                                    if (konpas.hasOwnProperty(i)) {
                                        let kondisi = konpas[i];

                                        $(target).find(`#kondisi${kondisi.id_kondisi}`).val(kondisi
                                            .hasil);
                                    }
                                }

                                // set pemberat value
                                $(target).find(
                                        `#pemberat option[value="${patient?.pemberat?.id || ''}"]`)
                                    .attr('selected', 'selected');
                                $(target).find(
                                        `#peringan option[value="${patient?.peringan?.id || ''}"]`)
                                    .attr('selected', 'selected');
                                $(target).find(
                                    `#kualitas_nyeri option[value="${patient?.kualitas?.id || ''}"]`
                                ).attr('selected', 'selected');
                                $(target).find(
                                    `#frekuensi_nyeri option[value="${patient?.frekuensi?.id || ''}"]`
                                ).attr('selected', 'selected');
                                $(target).find(
                                        `#menjalar option[value="${patient?.menjalar?.id || ''}"]`)
                                    .attr('selected', 'selected');
                                $(target).find(
                                        `#jenis_nyeri option[value="${patient?.jenis?.id || ''}"]`)
                                    .attr('selected', 'selected');
                                $(target).find(
                                    `input[name="tindak_lanjut"][value="${patient.tindak_lanjut_code}"]`
                                ).attr('checked', 'checked');

                                let tindakLanjut = patient.tindak_lanjut_code;


                                if (tindakLanjut == '2') {
                                    $('#editCpptModal #tgl-kontrol-label').text(
                                        `${patient.tgl_kontrol_ulang}`);
                                    $('#editCpptModal #kontrolModal #tgl_kontrol').val(patient
                                        .tgl_kontrol_ulang);
                                }

                                if (tindakLanjut == '4') {
                                    $('#editCpptModal #unit-rujuk-internal-label').text(
                                        `${patient.nama_unit_tujuan_konsul}`);
                                }

                                if (tindakLanjut == '5') {
                                    $('#editCpptModal #rs-tujuan-label').text(
                                        `${patient.rs_rujuk_bagian} (${patient.rs_rujuk})`);

                                    $('#editCpptModal #rsLainModal #nama_rs').val(patient.rs_rujuk);
                                    $('#editCpptModal #rsLainModal #bagian_rs').val(patient
                                        .rs_rujuk_bagian);
                                }

                                // diagnosis set value
                                var penyakit = patient.cppt_penyakit;
                                var dignoseListContent = '';

                                for (let d in penyakit) {
                                    if (penyakit.hasOwnProperty(d)) {
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
                error: function(xhr, status, error) {
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

            if (searchInputValue != '') {
                $('#editDiagnosisModal #listDiagnosa').append(`<li>${searchInputValue}</li>`);
                $(editSearchInputDiagnose).val('');
            }
        });

        $('#editDiagnosisModal #btnSaveDiagnose').click(function(e) {
            var dignoseListContent = '';
            let diagnoses = $('#editDiagnosisModal #listDiagnosa li');

            $(diagnoses).each(function(i, e) {
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

            $.each(penyakitList, function(i, el) {
                var nmDiag = $(el).text();

                if (nmDiag != '') {
                    listNamaPenyakitHtml += `<li>${nmDiag}</li>`;
                }
            });

            $this.find('#listDiagnosa').html(listNamaPenyakitHtml);
        });

        $('#editCpptModal input[name="skala_nyeri"]').change(function(e) {
            var $this = $(this);
            var skalaValue = $this.val();

            if (skalaValue > 10) {
                skalaValue = 10;
                $this.val(10);
            }

            if (skalaValue < 0) {
                skalaValue = 0;
                $this.val(0);
            }

            var valColor = 'btn-success';
            let skalaLabel = 'Tidak Nyeri'

            if (skalaValue > 1 && skalaValue <= 3) skalaLabel = "Nyeri Ringan";
            if (skalaValue > 3 && skalaValue <= 5) skalaLabel = "Nyeri Sedang";
            if (skalaValue > 5 && skalaValue <= 7) skalaLabel = "Nyeri Parah";
            if (skalaValue > 7 && skalaValue <= 9) skalaLabel = "Nyeri Sangat Parah";
            if (skalaValue > 9) skalaLabel = "Nyeri Terburuk";

            if (skalaValue > 3 && skalaValue <= 7) valColor = 'btn-warning';
            if (skalaValue > 7 && skalaValue <= 10) valColor = 'btn-danger';

            $('#editCpptModal #skalaNyeriBtn').removeClass('btn-success');
            $('#editCpptModal #skalaNyeriBtn').removeClass('btn-warning');
            $('#editCpptModal #skalaNyeriBtn').removeClass('btn-danger');
            $('#editCpptModal #skalaNyeriBtn').addClass(valColor);
            $('#editCpptModal #skalaNyeriBtn').text(skalaLabel);
        });

        // TINDAK LANNUT
        // kontrol ulang
        $('#editCpptModal #plan_konrol_ulang').click(function(e) {

            let modalKedua = new bootstrap.Modal($('#editCpptModal #kontrolModal'), {
                backdrop: 'static',
                // keyboard: false
            });

            modalKedua.show();
        });

        $('#editCpptModal #kontrolModal .btn-save-kontrol').click(function(e) {
            // get value konsul
            let $this = $(this);
            if (checkKontrolFormValidation('#editCpptModal')) $('#editCpptModal #kontrolModal').modal('hide');
        });

        // rujuk RS Lain
        $('#editCpptModal #plan_rujuk').click(function(e) {

            let modalKedua = new bootstrap.Modal($('#editCpptModal #rsLainModal'), {
                backdrop: 'static',
                // keyboard: false
            });

            modalKedua.show();
        });

        $('#editCpptModal #rsLainModal .btn-save-rs-lain').click(function(e) {
            // get value konsul
            let $this = $(this);
            if (checkRSLainFormValidation('#editCpptModal')) $('#editCpptModal #rsLainModal').modal('hide');
        });

        $('#formEditCppt').submit(function(e) {
            let $this = $(this);
            let diagnoseNameEl = $this.find('input[name="diagnose_name[]"]');
            let tindakLanjut = $this.find('input[name="tindak_lanjut"]:checked').val();

            if (diagnoseNameEl.length < 1) {
                showToast('error', 'Diagnosa harus di tambah minimal 1!');
                return false;
            }

            // Tindak Lanjut Konsul
            // if (tindakLanjut == 4) {
            //     if (!checkKonsulFormValidation('#editCpptModal')) return false;
            // }

            // Tindak Lanjut kontrol ulang
            if (tindakLanjut == 2) {
                if (!checkKontrolFormValidation('#editCpptModal')) return false;
            }

            // Tindak Lanjut rujuk rs lain
            if (tindakLanjut == 5) {
                if (!checkRSLainFormValidation('#editCpptModal')) return false;
            }

        });
    </script>
@endpush
