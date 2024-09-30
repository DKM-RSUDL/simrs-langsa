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
    @php
        // Prepare navigation items
        $tglMasukData = date('Y-m-d', strtotime($dataMedis->tgl_masuk));

        $navItems = [
            ['icon' => 'verified_badge.png', 'label' => 'Asesmen', 'link' => route('asesmen.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'positive_dynamic.png', 'label' => 'CPPT', 'link' => route('cppt.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'tools.png', 'label' => 'Tindakan', 'link' => route('tindakan.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'agree.png', 'label' => 'Konsultasi', 'link' => route('konsultasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'test_tube.png', 'label' => 'Labor', 'link' => route('labor.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'microbeam_radiation_therapy.png', 'label' => 'Radiologi', 'link' => route('radiologi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'pill.png', 'label' => 'Farmasi', 'link' => route('farmasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'info.png', 'label' => 'Edukasi', 'link' => route('edukasi.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'goal.png', 'label' => 'Care Plan', 'link' => route('careplan.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
            ['icon' => 'cv.png', 'label' => 'Resume', 'link' => route('resume.index', [$dataMedis->pasien->kd_pasien, $tglMasukData])],
        ];

        // Prepare content for each tab
        // $tabContents = [
        //     [
        //         'tanggal' => '02 Mar 2024',
        //         'time' => '8:30',
        //         'avatar' => 'profile.jpg',
        //         'name' => 'Ns. Aleyndra, S.Kep',
        //         'role' => 'Perawat Klinik Internis',
        //         'subjective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        //         'objective' => [
        //             'TD' => '___ / ___ mmHg',
        //             'RR' => '___ x/mnt',
        //             'TB' => '___ M',
        //             'Temp' => '___ C',
        //             'Resp' => '___ x/mnt',
        //             'BB' => '___ Kg',
        //         ],
        //         'assessment' => ['Hipertensi Kronis', 'Dyspepsia', 'Depresive Episode'],
        //         'plan' => ['Stabilisasi TD sampai batas normal', 'Terapi obat', 'Lanjutkan perawatan'],
        //     ],
        //     [
        //         'tanggal' => '03 Mar 2024',
        //         'time' => '9:30',
        //         'avatar' => 'profile1.jpg',
        //         'name' => 'Dr. Amanda',
        //         'role' => 'Perawat Klinik Internis',
        //         'subjective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        //         'objective' => [
        //             'TD' => '___ / ___ mmHg',
        //             'RR' => '___ x/mnt',
        //             'TB' => '___ M',
        //             'Temp' => '___ C',
        //             'Resp' => '___ x/mnt',
        //             'BB' => '___ Kg',
        //         ],
        //         'assessment' => ['Hipertensi Kronis', 'Dyspepsia', 'Depresive Episode'],
        //         'plan' => ['Stabilisasi TD sampai batas normal', 'Terapi obat', 'Lanjutkan perawatan'],
        //     ],
        //     [
        //         'tanggal' => '01 Mar 2024',
        //         'time' => '10:30',
        //         'avatar' => 'profile2.jpg',
        //         'name' => 'Ns. Eka Wira , S.Kep ',
        //         'role' => 'Perawat Klinik Internis',
        //         'subjective' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        //         'objective' => [
        //             'TD' => '___ / ___ mmHg',
        //             'RR' => '___ x/mnt',
        //             'TB' => '___ M',
        //             'Temp' => '___ C',
        //             'Resp' => '___ x/mnt',
        //             'BB' => '___ Kg',
        //         ],
        //         'assessment' => ['Hipertensi Kronis', 'Dyspepsia', 'Depresive Episode'],
        //         'plan' => ['Stabilisasi TD sampai batas normal', 'Terapi obat', 'Lanjutkan perawatan'],
        //     ],
        // ];

    @endphp

    <div class="row">
        <div class="col-md-3">
            @component('components.patient-card', ['patient' => $dataMedis->pasien])
            @endcomponent
        </div>

        <div class="col-md-9">
            @component('components.navigation', ['navItems' => $navItems])
            @endcomponent

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
                                                @foreach ($value['penyakit'] as $p => $v)
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
                                        <button class="btn btn-primary">Verifikasi DPJP</button>
                                        <button class="btn btn-primary btn-edit-cppt" data-bs-target="#editCpptModal" data-tgl="{{ $value['tanggal'] }}" data-urut="{{ $value['urut'] }}" data-unit="{{ $value['kd_unit'] }}">Edit</button>
                                    </div>
                                </div>

                                @php
                                    $j++;
                                @endphp
                            @endforeach

                            {{-- @foreach ($tabContents as $index => $content)
                                <div class="tab-pane fade @if ($index == 0) show active @endif"
                                    id="v-pills-home-{{ $index }}" role="tabpanel">
                                    <div class="patient-card bg-secondary-subtle">
                                        <p class="mb-0 text-end">{{ $content['tanggal'] }} {{ $content['time'] }}</p>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/img/' . $content['avatar']) }}" alt="Avatar"
                                                class="rounded-circle" width="50" height="50">
                                            <div class="ms-3">
                                                <p class="mb-0 fw-bold">Catatan Perkembangan Pasien Terintegrasi</p>
                                                <small class="text-muted">
                                                    <span class="fw-bold">{{ $content['name'] }}</span>
                                                    ({{ $content['role'] }})
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
                                            <p>{{ $content['subjective'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Objective -->
                                    <div class="row">
                                        <div class="col-1">
                                            <h6><strong>O</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <div class="row">
                                                <div class="col-md-3">TD: {{ $content['objective']['TD'] }}</div>
                                                <div class="col-md-3">RR: {{ $content['objective']['RR'] }}</div>
                                                <div class="col-md-3">TB: {{ $content['objective']['TB'] }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Temp: {{ $content['objective']['Temp'] }}</div>
                                                <div class="col-md-3">Resp: {{ $content['objective']['Resp'] }}</div>
                                                <div class="col-md-3">BB: {{ $content['objective']['BB'] }}</div>
                                            </div>
                                            <p>{{ $content['subjective'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Assessment -->
                                    <div class="row">
                                        <div class="col-1">
                                            <h6><strong>A</strong></h6>
                                        </div>
                                        <div class="col-11">
                                            <ul>
                                                @foreach ($content['assessment'] as $assessment)
                                                    <li>{{ $assessment }}</li>
                                                @endforeach
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
                                                @foreach ($content['plan'] as $plan)
                                                    <li>{{ $plan }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Button -->
                                    <div class="d-flex justify-content-between mt-4">
                                        <button class="btn btn-primary">Verifikasi DPJP</button>
                                        <button class="btn btn-primary">Edit</button>
                                    </div>
                                </div>
                            @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     const searchInput = document.getElementById('searchInput');
    //     const dataList = document.getElementById('dataList');
    //     const items = dataList.querySelectorAll('.dropdown-item');

    //     dropdown saat input di klik
    //     searchInput.addEventListener('focus', function () {
    //         dataList.classList.add('show');
    //     });

    //     dropdown user mulai mengetik
    //     searchInput.addEventListener('input', function () {
    //         const filter = searchInput.value.toLowerCase();
    //         let hasVisibleItems = false;

    //         items.forEach(function (item) {
    //             const text = item.textContent.toLowerCase();
    //             if (text.includes(filter)) {
    //                 item.style.display = 'block';
    //                 hasVisibleItems = true;
    //             } else {
    //                 item.style.display = 'none';
    //             }
    //         });

    //         // Jika tidak ada item yang cocok, tutup dropdown
    //         if (hasVisibleItems) {
    //             dataList.classList.add('show');
    //         } else {
    //             dataList.classList.remove('show');
    //         }
    //     });

    //     // Event listener untuk klik pada item dropdown
    //     items.forEach(function (item) {
    //         item.addEventListener('click', function () {
    //             searchInput.value = this.textContent;
    //             dataList.classList.remove('show');
    //         });
    //     });

    //     // Menyembunyikan dropdown saat klik di luar
    //     document.addEventListener('click', function (event) {
    //         if (!event.target.closest('.dropdown')) {
    //             dataList.classList.remove('show');
    //         }
    //     });
    // });

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

    $('input[name="skala_nyeri"]').change(function(e) {
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

        $(target).modal('show');
    });

    $('#editCpptModal').on('show.bs.modal', function(e)
    {

        var $this = $(this);
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
                console.log(response);

                if(response.status == 'success') {
                    var data = response.data;

                    for (let key in data) {
                        if (data.hasOwnProperty(key)) {
                            let patient = data[key];

                            //set key to input
                            $this.find('#anamnesis').val(patient.anamnesis);
                            $this.find('#lokasi').val(patient.lokasi);
                            $this.find('#durasi').val(patient.durasi);
                            $this.find('#pemeriksaan_fisik').val(patient.pemeriksaan_fisik);
                            $this.find('#data_objektif').val(patient.obyektif);
                            $this.find('#planning').val(patient.planning);

                            // skala nyeri set value
                            var skalaNyeri = patient.skala_nyeri;
                            var valColor = 'btn-success';

                            if(skalaNyeri > 3 && skalaNyeri <= 7) valColor = 'btn-warning';
                            if(skalaNyeri > 7 && skalaNyeri <= 10) valColor = 'btn-danger';

                            $this.find('#skalaNyeriBtn').removeClass('btn-success');
                            $this.find('#skalaNyeriBtn').removeClass('btn-warning');
                            $this.find('#skalaNyeriBtn').removeClass('btn-danger');
                            $this.find('#skalaNyeriBtn').addClass(valColor);

                            $this.find('#skala_nyeri').val(skalaNyeri);

                            // tanda vital set value
                            var kondisi = patient.kondisi;
                            var konpas = kondisi.konpas;

                            for(let i in konpas) {
                                if(konpas.hasOwnProperty(i)) {
                                    let kondisi = konpas[i];

                                    $this.find(`#kondisi${kondisi.id_kondisi}`).val(kondisi.hasil);
                                }
                            }
                        }
                    }
                }

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
                showToast('error', xhr.responseJSON.message);
            }
        });
    })

</script>
@endpush
