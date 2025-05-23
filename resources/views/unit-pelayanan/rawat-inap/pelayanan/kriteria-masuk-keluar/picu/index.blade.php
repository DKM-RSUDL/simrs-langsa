@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <style>
        .status-badge {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }
        .btn-action {
            margin: 0 2px;
        }
        .table-responsive {
            min-height: 10px;
        }
        .nav-tabs .nav-link {
            color: #2c3e50;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            background-color: #f8f9fa;
            border-color: #dee2e6 #dee2e6 #fff;
        }
        /* Styles from ICU reference */
        .card.border-left-primary {
            border-left: 0.25rem solid #007bff !important;
        }
        .card.border-left-success {
            border-left: 0.25rem solid #28a745 !important;
        }
        .card.border-left-warning {
            border-left: 0.25rem solid #ffc107 !important;
        }
        .card.border-left-info {
            border-left: 0.25rem solid #17a2b8 !important;
        }
        .card.border-left-secondary {
            border-left: 0.25rem solid #6c757d !important;
        }
        .text-primary {
            color: #007bff !important;
        }
        .text-success {
            color: #28a745 !important;
        }
        .text-warning {
            color: #ffc107 !important;
        }
        .text-info {
            color: #17a2b8 !important;
        }
        .text-secondary {
            color: #6c757d !important;
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

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="?tab=masuk" class="nav-link {{ request()->query('tab', 'masuk') == 'masuk' ? 'active' : '' }}" aria-selected="true">Kriteria Masuk PICU</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="?tab=keluar" class="nav-link {{ request()->query('tab') == 'keluar' ? 'active' : '' }}" aria-selected="false">Kriteria Keluar PICU</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            {{-- Kriteria Masuk Tab --}}
                            <div class="tab-pane fade show {{ request()->query('tab', 'masuk') == 'masuk' ? 'active' : '' }}" id="masuk-tab-pane" role="tabpanel" aria-labelledby="masuk-tab" tabindex="0">
                                <div class="d-flex justify-content-end my-3">
                                    @if(!$dataPICU) {{-- Only show "Tambah" if no Masuk PICU data exists --}}
                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.picu.create', [
                                            'kd_unit' => $dataMedis->kd_unit,
                                            'kd_pasien' => $dataMedis->kd_pasien,
                                            'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                            'urut_masuk' => $dataMedis->urut_masuk
                                        ]) }}"
                                            class="btn btn-primary">
                                            <i class="ti-plus"></i> Tambah Data PICU
                                        </a>
                                    @endif
                                </div>

                                {{-- Alert Success --}}
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="ti-check"></i> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- Alert Error --}}
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="ti-alert-triangle"></i> {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="row">
                                    @if($dataPICU)
                                        <div class="col-12">
                                            <div class="card border-left-primary">
                                                <div class="card-header bg-primary text-white">
                                                    <h5 class="mb-0">
                                                        <i class="ti-clipboard"></i> Data Kriteria Masuk PICU
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="25%">Dokter Penilai</th>
                                                                <td>{{ $dataPICU->dokter->nama ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Waktu Masuk</th>
                                                                <td>{{ \Carbon\Carbon::parse($dataPICU->tanggal)->format('d/m/Y') }} {{ \Carbon\Carbon::parse($dataPICU->jam)->format('H:i') }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3 text-primary"><i class="ti-heart"></i> Kriteria Masuk</h6>
                                                    <div class="row">
                                                        @php
                                                            $kriteriaMasukMap = [
                                                                'kriteria_1_main' => 'Gangguan pernapasan: (RR, Sianosis, Retraksi, Merintih, Nafas Cuping)',
                                                                'kriteria_1_rr' => 'Respiratory Rate (RR) abnormal',
                                                                'kriteria_1_sianosis' => 'Sianosis',
                                                                'kriteria_1_retraksi' => 'Retraksi',
                                                                'kriteria_1_merintih' => 'Merintih',
                                                                'kriteria_1_nafas_cuping' => 'Nafas Cuping',
                                                                'kriteria_2_main' => 'Gangguan sirkulasi: (Nadi, HR, TD Nadi, RR, Akral)',
                                                                'kriteria_2_nadi' => 'Nadi abnormal',
                                                                'kriteria_2_hr' => 'Heart Rate (HR) abnormal',
                                                                'kriteria_2_tekanan_nadi' => 'Tekanan Nadi abnormal',
                                                                'kriteria_2_rr' => 'Respiratory Rate (RR) abnormal',
                                                                'kriteria_2_akral' => 'Akral dingin',
                                                                'kriteria_3' => 'Kejang',
                                                                'kriteria_4' => 'Penurunan kesadaran (GCS < 10 atau ada tanda-tanda gagal napas dan syok)',
                                                                'kriteria_5' => 'Intoksikasi',
                                                                'kriteria_6_main' => 'Dehidrasi berat: (Takikardia, Mata cekung, Letargi, Anuria, Malas minum)',
                                                                'kriteria_6_takikardia' => 'Takikardia',
                                                                'kriteria_6_mata' => 'Mata cekung',
                                                                'kriteria_6_letargi' => 'Letargi',
                                                                'kriteria_6_anuria' => 'Anuria',
                                                                'kriteria_6_malas_minum' => 'Malas minum',
                                                                'kriteria_7' => 'Syok',
                                                                'kriteria_8' => 'Kegagalan organ: Ginjal, Hati, Jantung, Otak',
                                                                'kriteria_9' => 'Membutuhkan ventilator'
                                                            ];
                                                            $hasMasukCriteria = false;
                                                        @endphp
                                                        @foreach($kriteriaMasukMap as $field => $label)
                                                            @if($dataPICU->$field)
                                                                @php $hasMasukCriteria = true; @endphp
                                                                <div class="col-md-12 mb-2">
                                                                    <i class="ti-check text-success"></i> {{ $label }}
                                                                    @if(isset($dataPICU->{'keterangan_' . str_replace('kriteria_', '', $field)}))
                                                                        <br><small class="text-muted ms-3">Keterangan: {{ $dataPICU->{'keterangan_' . str_replace('kriteria_', '', $field)} }}</small>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        @if(!$hasMasukCriteria)
                                                            <div class="col-12 text-muted">Tidak ada kriteria masuk yang dipilih.</div>
                                                        @endif
                                                    </div>

                                                    @if($dataPICU->diagnosa_kriteria)
                                                        <h6 class="mt-4 mb-3 text-primary"><i class="ti-file-text"></i> Diagnosa Kriteria</h6>
                                                        <div class="border-left-primary p-3">
                                                            {{ $dataPICU->diagnosa_kriteria }}
                                                        </div>
                                                    @endif

                                                    <div class="mt-4 d-flex justify-content-end">
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.picu.edit', [
                                                            'kd_unit' => $dataPICU->kd_unit,
                                                            'kd_pasien' => $dataPICU->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataPICU->tgl_masuk)),
                                                            'urut_masuk' => $dataPICU->urut_masuk
                                                        ]) }}" class="btn btn-warning me-2">
                                                            <i class="ti-pencil"></i> Edit
                                                        </a>
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.picu.print', [
                                                            'kd_unit' => $dataPICU->kd_unit,
                                                            'kd_pasien' => $dataPICU->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataPICU->tgl_masuk)),
                                                            'urut_masuk' => $dataPICU->urut_masuk
                                                        ]) }}" class="btn btn-info me-2" target="_blank">
                                                            <i class="ti-printer"></i> Print
                                                        </a>
                                                        <form action="{{ route('rawat-inap.kriteria-masuk-keluar.picu.destroy', [
                                                            'kd_unit' => $dataPICU->kd_unit,
                                                            'kd_pasien' => $dataPICU->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataPICU->tgl_masuk)),
                                                            'urut_masuk' => $dataPICU->urut_masuk
                                                        ]) }}" method="POST" style="display: inline-block;" id="delete-form-masuk-{{ $dataPICU->kd_pasien }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-delete" data-form-id="delete-form-masuk-{{ $dataPICU->kd_pasien }}">
                                                                <i class="ti-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body text-center py-5">
                                                    <i class="ti-clipboard" style="font-size: 48px; color: #ccc;"></i>
                                                    <h5 class="mt-3">Belum Ada Data Kriteria Masuk PICU</h5>
                                                    <p class="text-muted">Silahkan tambahkan data kriteria masuk PICU.</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Kriteria Keluar Tab --}}
                            <div class="tab-pane fade show {{ request()->query('tab') == 'keluar' ? 'active' : '' }}" id="keluar-tab-pane" role="tabpanel" aria-labelledby="keluar-tab" tabindex="0">
                                <div class="d-flex justify-content-end my-3">
                                    {{-- The "Tambah" button is already handled by the 'masuk' tab.
                                         Edit/Print/Delete for Keluar PICU will be available if data exists. --}}
                                </div>
                                <div class="row">
                                    @if($dataKeluarPICU)
                                        <div class="col-12">
                                            <div class="card border-left-success">
                                                <div class="card-header bg-success text-white">
                                                    <h5 class="mb-0">
                                                        <i class="ti-clipboard"></i> Data Kriteria Keluar PICU
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="25%">Dokter Penilai</th>
                                                                <td>{{ $dataKeluarPICU->dokter->nama ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Waktu Keluar</th>
                                                                <td>{{ \Carbon\Carbon::parse($dataKeluarPICU->tanggal)->format('d/m/Y') }} {{ \Carbon\Carbon::parse($dataKeluarPICU->jam)->format('H:i') }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3 text-success"><i class="ti-list"></i> Kriteria Keluar</h6>
                                                    <div class="row">
                                                        @php
                                                            $kriteriaKeluarMap = [
                                                                'kriteria_keluar_1' => 'Hemodinamik stabil tanpa obat inotropik vasoaktif',
                                                                'kriteria_keluar_2' => 'Respirasi stabil tanpa alat bantu napas',
                                                                'kriteria_keluar_3' => 'Tidak ada aritmia mengancam jiwa',
                                                                'kriteria_keluar_4' => 'Keseimbangan cairan dan elektrolit stabil',
                                                                'kriteria_keluar_5' => 'Kesadaran membaik dan stabil',
                                                                'kriteria_keluar_6' => 'Nutrisi adekuat',
                                                                'kriteria_keluar_7' => 'Mampu memenuhi kebutuhan diri secara mandiri'
                                                            ];
                                                            $hasKeluarCriteria = false;
                                                        @endphp
                                                        @foreach($kriteriaKeluarMap as $field => $label)
                                                            @if($dataKeluarPICU->$field)
                                                                @php $hasKeluarCriteria = true; @endphp
                                                                <div class="col-md-12 mb-2">
                                                                    <i class="ti-check text-success"></i> {{ $label }}
                                                                    @if(isset($dataKeluarPICU->{'keterangan_keluar_' . str_replace('kriteria_keluar_', '', $field)}))
                                                                        <br><small class="text-muted ms-3">Keterangan: {{ $dataKeluarPICU->{'keterangan_keluar_' . str_replace('kriteria_keluar_', '', $field)} }}</small>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        @if(!$hasKeluarCriteria)
                                                            <div class="col-12 text-muted">Tidak ada kriteria keluar yang dipilih.</div>
                                                        @endif
                                                    </div>

                                                    <div class="mt-4 d-flex justify-content-end">
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.picu.edit', [
                                                            'kd_unit' => $dataKeluarPICU->kd_unit,
                                                            'kd_pasien' => $dataKeluarPICU->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataKeluarPICU->tgl_masuk)),
                                                            'urut_masuk' => $dataKeluarPICU->urut_masuk
                                                        ]) }}" class="btn btn-warning me-2">
                                                            <i class="ti-pencil"></i> Edit
                                                        </a>
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.picu.print', [
                                                            'kd_unit' => $dataKeluarPICU->kd_unit,
                                                            'kd_pasien' => $dataKeluarPICU->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataKeluarPICU->tgl_masuk)),
                                                            'urut_masuk' => $dataKeluarPICU->urut_masuk
                                                        ]) }}" class="btn btn-info me-2" target="_blank">
                                                            <i class="ti-printer"></i> Print
                                                        </a>
                                                        <form action="{{ route('rawat-inap.kriteria-masuk-keluar.picu.destroy', [
                                                            'kd_unit' => $dataKeluarPICU->kd_unit,
                                                            'kd_pasien' => $dataKeluarPICU->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataKeluarPICU->tgl_masuk)),
                                                            'urut_masuk' => $dataKeluarPICU->urut_masuk
                                                        ]) }}" method="POST" style="display: inline-block;" id="delete-form-keluar-{{ $dataKeluarPICU->kd_pasien }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-delete" data-form-id="delete-form-keluar-{{ $dataKeluarPICU->kd_pasien }}">
                                                                <i class="ti-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body text-center py-5">
                                                    <i class="ti-clipboard" style="font-size: 48px; color: #ccc;"></i>
                                                    <h5 class="mt-3">Belum Ada Data Kriteria Keluar PICU</h5>
                                                    <p class="text-muted">Silahkan tambahkan data kriteria keluar PICU.</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    <script>
        // Auto hide alert after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.classList.add('fade');
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            });
        }, 5000);

        // Sweet Alert for delete confirmation
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();

            const formId = $(this).data('form-id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        });
    </script>
@endpush