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
            @include('components.navigation-ranap-konsultasi')
            <x-content-card>
                @include('components.page-header', [
                    'title' => 'Daftar Tindakan',
                    'description' => 'Daftar data tindakan rawat jalan.',
                ])

                <div class="d-flex flex-md-row flex-wrap flex-md-nowrap gap-2">
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
                        <input type="date" name="end_date" id="end_date" class="form-control" placeholder="S.d Tanggal">
                    </div>

                    <!-- Button Filter -->
                    <div>
                        <button id="filterButton" class="btn btn-secondary rounded-3"><i
                                class="bi bi-funnel-fill"></i></button>
                    </div>

                    <!-- Search Bar -->
                    <div>
                        <form method="GET"
                            action="{{ route('rawat-inap.konsultasi.rincian.tindakan.indexTindakan', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk, 'urut_konsul' => $urut_konsul]) }}">

                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="dokter & Tindakan"
                                    aria-label="Cari" value="{{ request('search') }}" aria-describedby="basic-addon1">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Tindakan</th>
                                <th>Unit Pelayanan</th>
                                <th>PPA</th>
                                <th>Keterangan</th>
                                <th>Gambar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tindakan as $tdk)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($tdk->tgl_tindakan)->format('d M Y') }}
                                        {{ \Carbon\Carbon::parse($tdk->jam_tindakan)->format('H:i') }}</td>
                                    <td>
                                        <span class="text-primary fw-bold text-decoration-underline">
                                            {{ $tdk->produk->deskripsi }}
                                        </span>
                                    </td>
                                    <td>{{ $tdk->unit->nama_unit }} / {{ $tdk->produk->klas->klasifikasi }}</td>
                                    <td>{{ $tdk->ppa->nama_lengkap }}</td>
                                    <td>{{ $tdk->keterangan }}</td>
                                    <td>
                                        @if ($tdk->gambar)
                                            <img src="{{ asset('storage/' . $tdk->gambar) }}" alt="Gambar Tindakan"
                                                width="50" style="cursor: pointer;" data-bs-toggle="modal"
                                                data-bs-target="#previewImage"
                                                data-src="{{ asset('storage/' . $tdk->gambar) }}">
                                        @else
                                            Tidak ada gambar
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-content-card>
        </div>

        @include('unit-pelayanan.rawat-inap.pelayanan.konsultasi.rincian.tindakan.modal')
    </div>
@endsection

@push('js')
    {{-- Filter data to anas --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#SelectOption').change(function() {
                var periode = $(this).val();
                var queryString = '?periode=' + periode;
                window.location.href =
                    "{{ route('rawat-inap.konsultasi.rincian.tindakan.indexTindakan', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk, 'urut_konsul' => $urut_konsul]) }}" +
                    queryString;
            });
        });

        $(document).ready(function() {
            $('#filterButton').click(function(e) {
                e.preventDefault();

                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();

                if (!startDate || !endDate) {
                    alert('Silakan pilih tanggal awal dan tanggal akhir terlebih dahulu.');
                    return;
                }

                var queryString = '?start_date=' + startDate + '&end_date=' + endDate;

                window.location.href =
                    "{{ route('rawat-inap.konsultasi.rincian.tindakan.indexTindakan', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $dataMedis->kd_pasien, 'tgl_masuk' => \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk, 'urut_konsul' => $urut_konsul]) }}" +
                    queryString;
            });
        });

        // Script untuk preview gambar
        $(document).ready(function() {
            $('img[data-bs-toggle="modal"]').on('click', function() {
                var src = $(this).data('src');
                $('#previewImageSrc').attr('src', src);
            });
        });
    </script>
@endpush
