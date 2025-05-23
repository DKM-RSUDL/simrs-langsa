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
                                <a href="?tab=masuk"
                                    class="nav-link {{ request()->query('tab', 'masuk') == 'masuk' ? 'active' : '' }}"
                                    aria-selected="true">Kriteria Masuk NICU</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="?tab=keluar"
                                    class="nav-link {{ request()->query('tab') == 'keluar' ? 'active' : '' }}"
                                    aria-selected="false">Kriteria Keluar NICU</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            {{-- Kriteria Masuk Tab --}}
                            <div class="tab-pane fade show {{ request()->query('tab', 'masuk') == 'masuk' ? 'active' : '' }}"
                                id="masuk-tab-pane" role="tabpanel" aria-labelledby="masuk-tab" tabindex="0">
                                <div class="d-flex justify-content-end my-3">
                                    @if(!$dataNicu) {{-- Only show "Tambah" if no Masuk NICU data exists --}}
                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.nicu.create', [
                                            'kd_unit' => $dataMedis->kd_unit,
                                            'kd_pasien' => $dataMedis->kd_pasien,
                                            'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                            'urut_masuk' => $dataMedis->urut_masuk
                                        ]) }}"
                                            class="btn btn-primary">
                                            <i class="ti-plus"></i> Tambah Data NICU
                                        </a>
                                    @endif
                                </div>

                                {{-- Alert Success --}}
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="ti-check"></i> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- Alert Error --}}
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="ti-alert-triangle"></i> {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="row">
                                    @if($dataNicu)
                                        <div class="col-12">
                                            <div class="card border-left-primary">
                                                <div class="card-header bg-primary text-white">
                                                    <h5 class="mb-0">
                                                        <i class="ti-clipboard"></i> Data Kriteria Masuk NICU
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="25%">Dokter Penilai</th>
                                                                <td>{{ $dataNicu->dokter->nama ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Waktu Masuk</th>
                                                                <td>{{ \Carbon\Carbon::parse($dataNicu->tanggal)->format('d/m/Y') }} {{ \Carbon\Carbon::parse($dataNicu->jam)->format('H:i') }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3 text-primary"><i class="ti-heart"></i> Kriteria Masuk</h6>
                                                    <div class="row">
                                                        @php
                                                            $kriteriaMasukMap = [
                                                                'kriteria_1' => 'BBLR (1000-1500 gram dengan komplikasi respirasi sindrome)',
                                                                'kriteria_2' => 'Masa gestasi kurang dari 28 minggu dengan komplikasi respirasi distress sindrome (RDS)',
                                                                'kriteria_3' => 'Post Date: dengan tanda-tanda Sepsis, masa kehamilan 42 minggu dengan RDS',
                                                                'kriteria_4_main' => 'Bayi dengan kelainan kongenital',
                                                                'kriteria_4_bibir' => 'Bibir sumbing',
                                                                'kriteria_4_atresia' => 'Atresia ani',
                                                                'kriteria_4_acephali' => 'An acephali',
                                                                'kriteria_4_polidactily' => 'Polidactily',
                                                                'kriteria_5_main' => 'Asfiksia berat',
                                                                'kriteria_5_rr' => 'RR: > 70 x/m',
                                                                'kriteria_5_takipnoe' => 'Takipnoe',
                                                                'kriteria_5_apgar' => 'Apgar score: 0-3',
                                                                'kriteria_5_retraksi' => 'Retraksi dinding dada',
                                                                'kriteria_5_sianosis' => 'Sianosis',
                                                                'kriteria_5_merintih' => 'Merintih',
                                                                'kriteria_6_main' => 'Sepsis neonatorum',
                                                                'kriteria_6_leukocyte' => 'Leukocyte: >20.000',
                                                                'kriteria_6_rr' => 'RR 70',
                                                                'kriteria_6_temp' => 'Temp: >38°C / <36°C',
                                                                'kriteria_6_hr' => 'HR: >160 x/m atau <100 x/i',
                                                                'kriteria_6_malas' => 'Malas minum',
                                                                'kriteria_7' => 'Distres nafas berat',
                                                                'kriteria_8' => 'Tetanus neonatorum',
                                                                'kriteria_9' => 'Kejang pada bayi / neonatal seizure',
                                                                'kriteria_10' => 'Bayi diare'
                                                            ];
                                                            $hasMasukCriteria = false;
                                                        @endphp
                                                        @foreach($kriteriaMasukMap as $field => $label)
                                                            @if($dataNicu->$field)
                                                                @php $hasMasukCriteria = true; @endphp
                                                                <div class="col-md-12 mb-2">
                                                                    <i class="ti-check text-success"></i> {{ $label }}
                                                                    @if(isset($dataNicu->{'keterangan_' . str_replace('kriteria_', '', $field)}))
                                                                        <br><small class="text-muted ms-3">Keterangan: {{ $dataNicu->{'keterangan_' . str_replace('kriteria_', '', $field)} }}</small>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        @if(!$hasMasukCriteria)
                                                            <div class="col-12 text-muted">Tidak ada kriteria masuk yang dipilih.</div>
                                                        @endif
                                                    </div>

                                                    <div class="mt-4 d-flex justify-content-end">
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.nicu.edit', [
                                                            'kd_unit' => $dataNicu->kd_unit,
                                                            'kd_pasien' => $dataNicu->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataNicu->tgl_masuk)),
                                                            'urut_masuk' => $dataNicu->urut_masuk
                                                        ]) }}" class="btn btn-warning me-2">
                                                            <i class="ti-pencil"></i> Edit
                                                        </a>
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.nicu.print', [
                                                            'kd_unit' => $dataNicu->kd_unit,
                                                            'kd_pasien' => $dataNicu->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataNicu->tgl_masuk)),
                                                            'urut_masuk' => $dataNicu->urut_masuk
                                                        ]) }}" class="btn btn-info me-2" target="_blank">
                                                            <i class="ti-printer"></i> Print
                                                        </a>
                                                        <form action="{{ route('rawat-inap.kriteria-masuk-keluar.nicu.destroy', [
                                                            'kd_unit' => $dataNicu->kd_unit,
                                                            'kd_pasien' => $dataNicu->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataNicu->tgl_masuk)),
                                                            'urut_masuk' => $dataNicu->urut_masuk
                                                        ]) }}" method="POST" style="display: inline-block;" id="delete-form-masuk-{{ $dataNicu->kd_pasien }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-delete" data-form-id="delete-form-masuk-{{ $dataNicu->kd_pasien }}">
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
                                                    <h5 class="mt-3">Belum Ada Data Kriteria Masuk NICU</h5>
                                                    <p class="text-muted">Silahkan tambahkan data kriteria masuk NICU.</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Kriteria Keluar Tab --}}
                            <div class="tab-pane fade show {{ request()->query('tab') == 'keluar' ? 'active' : '' }}"
                                id="keluar-tab-pane" role="tabpanel" aria-labelledby="keluar-tab" tabindex="0">
                                <div class="d-flex justify-content-end my-3">
                                    {{-- Tambah button handled in masuk tab; edit/print/delete shown if data exists --}}
                                </div>
                                <div class="row">
                                    @if($dataKeluarNicu)
                                        <div class="col-12">
                                            <div class="card border-left-success">
                                                <div class="card-header bg-success text-white">
                                                    <h5 class="mb-0">
                                                        <i class="ti-clipboard"></i> Data Kriteria Keluar NICU
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="25%">Dokter Penilai</th>
                                                                <td>{{ $dataKeluarNicu->dokter->nama ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Waktu Keluar</th>
                                                                <td>{{ \Carbon\Carbon::parse($dataKeluarNicu->tanggal)->format('d/m/Y') }} {{ \Carbon\Carbon::parse($dataKeluarNicu->jam)->format('H:i') }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3 text-success"><i class="ti-list"></i> Kriteria Keluar</h6>
                                                    <div class="row">
                                                        @php
                                                            $kriteriaKeluarMap = [
                                                                'kriteria_keluar_1' => 'BBLR bayi sudah normal berat badannya ≥ 1800 gr',
                                                                'kriteria_keluar_2' => 'Kondisi yang sudah membaik',
                                                                'kriteria_keluar_3' => 'Apgar Score 7-10',
                                                                'kriteria_keluar_4' => 'Kadar bilirubin normal',
                                                                'kriteria_keluar_5' => 'Gerakan aktif, refleks isap kuat'
                                                            ];
                                                            $hasKeluarCriteria = false;
                                                        @endphp
                                                        @foreach($kriteriaKeluarMap as $field => $label)
                                                            @if($dataKeluarNicu->$field)
                                                                @php $hasKeluarCriteria = true; @endphp
                                                                <div class="col-md-12 mb-2">
                                                                    <i class="ti-check text-success"></i> {{ $label }}
                                                                    @if(isset($dataKeluarNicu->{'keterangan_keluar_' . str_replace('kriteria_keluar_', '', $field)}))
                                                                        <br><small class="text-muted ms-3">Keterangan: {{ $dataKeluarNicu->{'keterangan_keluar_' . str_replace('kriteria_keluar_', '', $field)} }}</small>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        @if(!$hasKeluarCriteria)
                                                            <div class="col-12 text-muted">Tidak ada kriteria keluar yang dipilih.</div>
                                                        @endif
                                                    </div>

                                                    <div class="mt-4 d-flex justify-content-end">
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.nicu.edit', [
                                                            'kd_unit' => $dataKeluarNicu->kd_unit,
                                                            'kd_pasien' => $dataKeluarNicu->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataKeluarNicu->tgl_masuk)),
                                                            'urut_masuk' => $dataKeluarNicu->urut_masuk
                                                        ]) }}" class="btn btn-warning me-2">
                                                            <i class="ti-pencil"></i> Edit
                                                        </a>
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.nicu.print', [
                                                            'kd_unit' => $dataKeluarNicu->kd_unit,
                                                            'kd_pasien' => $dataKeluarNicu->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataKeluarNicu->tgl_masuk)),
                                                            'urut_masuk' => $dataKeluarNicu->urut_masuk
                                                        ]) }}" class="btn btn-info me-2" target="_blank">
                                                            <i class="ti-printer"></i> Print
                                                        </a>
                                                        <form action="{{ route('rawat-inap.kriteria-masuk-keluar.nicu.destroy', [
                                                            'kd_unit' => $dataKeluarNicu->kd_unit,
                                                            'kd_pasien' => $dataKeluarNicu->kd_pasien,
                                                            'tgl_masuk' => date('Y-m-d', strtotime($dataKeluarNicu->tgl_masuk)),
                                                            'urut_masuk' => $dataKeluarNicu->urut_masuk
                                                        ]) }}" method="POST" style="display: inline-block;" id="delete-form-keluar-{{ $dataKeluarNicu->kd_pasien }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-delete" data-form-id="delete-form-keluar-{{ $dataKeluarNicu->kd_pasien }}">
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
                                                    <h5 class="mt-3">Belum Ada Data Kriteria Keluar NICU</h5>
                                                    <p class="text-muted">Silahkan tambahkan data kriteria keluar NICU.</p>
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