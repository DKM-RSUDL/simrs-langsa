@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <!-- Sweet Alert 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <style>
        /* .header-background {
                                            background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
                                        } */
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
                                    class="nav-link {{ request('tab', 'masuk') == 'masuk' ? 'active' : '' }}"
                                    aria-selected="true">Kriteria Masuk</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="?tab=keluar" class="nav-link {{ request('tab') == 'keluar' ? 'active' : '' }}"
                                    aria-selected="true">Kriteria Keluar</a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                <div class="d-flex justify-content-end mb-3">
                                    @if (!$kriteriaKeluar)
                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.icu.keluar.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                            class="btn btn-primary">
                                            <i class="ti-plus"></i> Tambah
                                        </a>
                                    @endif
                                </div>

                                {{-- Alert Success --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="ti-check"></i> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                {{-- Alert Error --}}
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="ti-alert-triangle"></i> {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="row">
                                    @if ($kriteriaKeluar)
                                        <div class="col-12">
                                            <div class="card border-left-success">
                                                <div class="card-header bg-success text-white">
                                                    <h5 class="mb-0">
                                                        <i class="ti-clipboard"></i> Data Kriteria Keluar ICU
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive mt-4">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="20%">Dokter Penliai</th>
                                                                <td>{{ $kriteriaKeluar->creator->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Waktu Keluar</th>
                                                                <td>{{ \Carbon\Carbon::parse($kriteriaKeluar->waktu_keluar)->format('d/m/Y H:i') }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3 text-success"><i class="ti-heart"></i> Vital Sign
                                                    </h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-sm">
                                                            <tr>
                                                                <th width="20%">GCS Total</th>
                                                                <td><strong>{{ $kriteriaKeluar->gcs_total }}</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tekanan Darah</th>
                                                                <td>{{ $kriteriaKeluar->td_sistole }}/{{ $kriteriaKeluar->td_diastole }}
                                                                    mmHg</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Nadi</th>
                                                                <td>{{ $kriteriaKeluar->nadi }} x/menit</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Respiratory Rate</th>
                                                                <td>{{ $kriteriaKeluar->rr }} x/menit</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Suhu</th>
                                                                <td>{{ $kriteriaKeluar->suhu }}°C</td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <h6 class="mt-4 mb-3 text-success"><i class="ti-list"></i> Kriteria
                                                        Prioritas Keluar</h6>
                                                    <div class="row">
                                                        @if ($kriteriaKeluar->prioritas_1)
                                                            <div class="col-md-6">
                                                                <div class="card border-left-success mb-3">
                                                                    <div class="card-header">
                                                                        <h6 class="mb-0">Prioritas 1<br>Pasien kritis,
                                                                            tidak stabil, yang memer-
                                                                            lukan terapi intensif / tertitrasi</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <ul class="list-unstyled mb-0">
                                                                            @foreach (explode(',', $kriteriaKeluar->prioritas_1) as $item)
                                                                                <li><i class="ti-check text-success"></i>
                                                                                    {{ trim($item) }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($kriteriaKeluar->prioritas_2)
                                                            <div class="col-md-6">
                                                                <div class="card border-left-warning mb-3">
                                                                    <div class="card-header">
                                                                        <h6 class="mb-0">Prioritas 2<br>Memerlukan
                                                                            pelayanan pemantauan
                                                                            ICU, dengan kondisi medis yang senan-
                                                                            tiasa berubah</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <ul class="list-unstyled mb-0">
                                                                            @foreach (explode(',', $kriteriaKeluar->prioritas_2) as $item)
                                                                                <li><i class="ti-check text-warning"></i>
                                                                                    {{ trim($item) }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if ($kriteriaKeluar->prioritas_3)
                                                            <div class="col-md-6">
                                                                <div class="card border-left-info mb-3">
                                                                    <div class="card-header">
                                                                        <h6 class="mb-0">Prioritas 3<br>Pasien kritis,
                                                                            tidak stabil, kemungkinan
                                                                            sembuh dan atau manfaat terapi di ICU
                                                                            sangat kecil</h6>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <ul class="list-unstyled mb-0">
                                                                            @foreach (explode(',', $kriteriaKeluar->prioritas_3) as $item)
                                                                                <li><i class="ti-check text-info"></i>
                                                                                    {{ trim($item) }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if ($kriteriaKeluar->diagnosa_kriteria)
                                                        <h6 class="mt-4 mb-3 text-success"><i class="ti-file-text"></i>
                                                            Diagnosa Kriteria</h6>
                                                        <div class="border-left-success">
                                                            <div class="card-body">
                                                                {{ $kriteriaKeluar->diagnosa_kriteria }}
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="mt-4 d-flex justify-content-end">
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.icu.keluar.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $kriteriaKeluar->id]) }}"
                                                            class="btn btn-warning me-2">
                                                            <i class="ti-pencil"></i> Edit
                                                        </a>
                                                        <a href="{{ route('rawat-inap.kriteria-masuk-keluar.icu.keluar.print', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $kriteriaKeluar->id]) }}"
                                                            class="btn btn-info me-2" target="_blank">
                                                            <i class="ti-printer"></i> Print
                                                        </a>
                                                        <form
                                                            action="{{ route('rawat-inap.kriteria-masuk-keluar.icu.keluar.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $kriteriaKeluar->id]) }}"
                                                            method="POST" style="display: inline-block;"
                                                            id="delete-form-{{ $kriteriaKeluar->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-delete"
                                                                data-form-id="delete-form-{{ $kriteriaKeluar->id }}">
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
                                                <div class="card-body text-center">
                                                    <i class="ti-clipboard" style="font-size: 48px; color: #ccc;"></i>
                                                    <h5 class="mt-3">Belum Ada Data Kriteria Keluar ICU</h5>
                                                    <p class="text-muted">Klik tombol "Tambah" untuk menambahkan data
                                                        kriteria keluar ICU</p>
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
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    <script>
        // Auto hide alert after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Sweet Alert untuk konfirmasi hapus
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
                    // Submit form
                    document.getElementById(formId).submit();
                }
            })
        });
    </script>
@endpush
