@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
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
            @include('components.navigation-rahab-medis')
            <x-content-card>
                @include('components.page-header', [
                    'title' => 'KFR/Asesmen/RE-Asesmen/Protokol Terapi',
                    'description' =>
                        'Kelola data KFR/Asesmen/RE-Asesmen/Protokol Terapi rehabilitasi medis di sini.',
                ])
                <div class="d-flex flex-column gap-2">
                    <div class="row">
                        <div class="col-10 d-flex flex-md-row flex-wrap flex-md-nowrap gap-2">
                            <!-- Select Option -->
                            <div>
                                <select class="form-select" id="SelectOption" aria-label="Pilih...">
                                    <option value="semua" selected>Semua Episode</option>
                                    <option value="option1">Episode Sekarang</option>
                                    <option value="option2">1 Bulan</option>
                                    <option value="option3">3 Bulan</option>
                                    <option value="option4">6 Bulan</option>
                                    <option value="option5">9 Bulan</option>
                                </select>
                            </div>

                            <!-- Start Date -->
                            <div>
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    placeholder="Dari Tanggal">
                            </div>

                            <!-- End Date -->
                            <div>
                                <input type="date" name="end_date" id="end_date" class="form-control"
                                    placeholder="S.d Tanggal">
                            </div>

                            <!-- Button Filter -->
                            <div>
                                <button id="filterButton" class="btn btn-secondary rounded-3"><i
                                        class="bi bi-funnel-fill"></i></button>
                            </div>

                            <!-- Search Bar -->
                            <div>
                                <form method="GET"
                                    action="{{ route('tindakan.index', ['kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d')]) }}">

                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Dokter & Tindakan" aria-label="Cari"
                                            value="{{ request('search') }}" aria-describedby="basic-addon1">
                                        <button type="submit" class="btn btn-primary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @if (count($tindakan) < 1)
                            <div class="col-md-2 text-end">
                                <a href="{{ route('rehab-medis.pelayanan.tindakan.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="btn btn-primary">
                                    <i class="ti-plus"></i> Tambah
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tindakan as $tdk)
                                    <tr>
                                        <td>
                                            {{ date('d M Y', strtotime($tdk->tgl_tindakan)) . ' ' . date('H:i', strtotime($tdk->jam_tindakan)) }}
                                            WIB
                                        </td>
                                        <td>{{ $tdk->karyawan?->gelar_depan . ' ' . str()->title($tdk->karyawan?->nama) . ' ' . $tdk->karyawan?->gelar_belakang }}
                                        </td>
                                        <td>
                                            <x-table-action>
                                                <a href="{{ route('rehab-medis.pelayanan.tindakan.print', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $tdk->id]) }}"
                                                    class="btn btn-sm btn-success">
                                                    <i class="ti-printer"></i>
                                                </a>
                                                <a href="{{ route('rehab-medis.pelayanan.tindakan.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $tdk->id]) }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                                <a href="{{ route('rehab-medis.pelayanan.tindakan.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $tdk->id]) }}"
                                                    class="btn btn-warning btn-sm"><i class="fas fa-pencil"></i></a>
                                                <form
                                                    action="{{ route('rehab-medis.pelayanan.tindakan.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ encrypt($tdk->id) }}">

                                                    <button type="submit" class="btn btn-sm btn-danger" data-confirm
                                                        data-confirm-title="Anda yakin?"
                                                        data-confirm-text="Data yang dihapus tidak dapat dikembalikan"
                                                        title="Hapus operasi" aria-label="Hapus operasi">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </x-table-action>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/helpers/confirm.js') }}"></script>
@endpush
