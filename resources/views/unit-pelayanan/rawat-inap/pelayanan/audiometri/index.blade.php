@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .audiometri-card {
            transition: transform 0.2s;
        }

        .audiometri-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .hearing-level {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .hearing-normal {
            background-color: #d4edda;
            color: #155724;
        }

        .hearing-mild {
            background-color: #fff3cd;
            color: #856404;
        }

        .hearing-moderate {
            background-color: #ffeaa7;
            color: #856404;
        }

        .hearing-severe {
            background-color: #f8d7da;
            color: #721c24;
        }

        .hearing-profound {
            background-color: #dc3545;
            color: white;
        }

        .table-audiometri th {
            background-color: #097dd6;
            color: white;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }

        .table-audiometri td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-show {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-show:hover {
            background-color: #138496;
            border-color: #117a8b;
            color: white;
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
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">

                                <div class="row">
                                    <form method="GET"
                                        action="{{ route('rawat-inap.audiometri.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                        <div class="row m-3">
                                            <div class="col-md-9">
                                                <h5 class="mb-0">
                                                    <i class="ti-volume mr-2"></i>
                                                    Riwayat Pemeriksaan Audiometri
                                                </h5>
                                                <small class="text-muted">Data pemeriksaan pendengaran pasien</small>
                                            </div>
                                            <div class="col-md-3 text-end">
                                                <a href="{{ route('rawat-inap.audiometri.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah
                                                </a>
                                            </div>
                                        </div>
                                    </form>

                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                                            <strong>Berhasil!</strong> {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
                                            <strong>Error!</strong> {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <div class="mx-3">
                                        @if ($dataAudiometri->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm table-hover table-audiometri">
                                                    <thead>
                                                        <tr>
                                                            <th width="5%">No</th>
                                                            <th width="15%">Tanggal & Jam</th>
                                                            <th width="15%">Pemeriksa</th>
                                                            <th width="12%">AC Kanan</th>
                                                            <th width="12%">BC Kanan</th>
                                                            <th width="12%">AC Kiri</th>
                                                            <th width="12%">BC Kiri</th>
                                                            <th width="17%">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($dataAudiometri as $index => $item)
                                                            @php
                                                                $acKanan = json_decode($item->data_ac_kanan, true);
                                                                $bcKanan = json_decode($item->data_bc_kanan, true);
                                                                $acKiri = json_decode($item->data_ac_kiri, true);
                                                                $bcKiri = json_decode($item->data_bc_kiri, true);

                                                                function getHearingLevel($average)
                                                                {
                                                                    if ($average === null) {
                                                                        return [
                                                                            'level' => 'Tidak Ada Data',
                                                                            'class' => 'bg-secondary text-white',
                                                                        ];
                                                                    }
                                                                    if ($average <= 25) {
                                                                        return [
                                                                            'level' => 'Normal',
                                                                            'class' => 'hearing-normal',
                                                                        ];
                                                                    }
                                                                    if ($average <= 40) {
                                                                        return [
                                                                            'level' => 'Ringan',
                                                                            'class' => 'hearing-mild',
                                                                        ];
                                                                    }
                                                                    if ($average <= 70) {
                                                                        return [
                                                                            'level' => 'Sedang',
                                                                            'class' => 'hearing-moderate',
                                                                        ];
                                                                    }
                                                                    if ($average <= 90) {
                                                                        return [
                                                                            'level' => 'Berat',
                                                                            'class' => 'hearing-severe',
                                                                        ];
                                                                    }
                                                                    return [
                                                                        'level' => 'Sangat Berat',
                                                                        'class' => 'hearing-profound',
                                                                    ];
                                                                }

                                                                $acKananLevel = getHearingLevel(
                                                                    $acKanan['rata_rata'] ?? null,
                                                                );
                                                                $bcKananLevel = getHearingLevel(
                                                                    $bcKanan['rata_rata'] ?? null,
                                                                );
                                                                $acKiriLevel = getHearingLevel(
                                                                    $acKiri['rata_rata'] ?? null,
                                                                );
                                                                $bcKiriLevel = getHearingLevel(
                                                                    $bcKiri['rata_rata'] ?? null,
                                                                );
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>
                                                                    <strong>{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y') }}</strong><br>
                                                                    <small
                                                                        class="text-muted">{{ \Carbon\Carbon::parse($item->jam_pemeriksaan)->format('H:i') }}
                                                                        WIB</small>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="fw-bold">{{ $item->pemeriksa ?: '-' }}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="hearing-level {{ $acKananLevel['class'] }}">
                                                                        {{ $acKananLevel['level'] }}
                                                                    </span>
                                                                    @if ($acKanan['rata_rata'])
                                                                        <br><small
                                                                            class="text-muted">{{ $acKanan['rata_rata'] }}
                                                                            dB HL</small>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="hearing-level {{ $bcKananLevel['class'] }}">
                                                                        {{ $bcKananLevel['level'] }}
                                                                    </span>
                                                                    @if ($bcKanan['rata_rata'])
                                                                        <br><small
                                                                            class="text-muted">{{ $bcKanan['rata_rata'] }}
                                                                            dB HL</small>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="hearing-level {{ $acKiriLevel['class'] }}">
                                                                        {{ $acKiriLevel['level'] }}
                                                                    </span>
                                                                    @if ($acKiri['rata_rata'])
                                                                        <br><small
                                                                            class="text-muted">{{ $acKiri['rata_rata'] }}
                                                                            dB HL</small>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="hearing-level {{ $bcKiriLevel['class'] }}">
                                                                        {{ $bcKiriLevel['level'] }}
                                                                    </span>
                                                                    @if ($bcKiri['rata_rata'])
                                                                        <br><small
                                                                            class="text-muted">{{ $bcKiri['rata_rata'] }}
                                                                            dB HL</small>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group" role="group">
                                                                        <a href="{{ route('rawat-inap.audiometri.show', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                            class="btn btn-sm btn-show"
                                                                            title="Lihat Detail">
                                                                            <i class="ti-eye"></i> Detail
                                                                        </a>
                                                                        <a href="{{ route('rawat-inap.audiometri.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                            class="btn btn-sm btn-outline-primary"
                                                                            title="Edit Data">
                                                                            <i class="ti-pencil"></i>
                                                                        </a>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-danger"
                                                                            onclick="confirmDelete({{ $item->id }})"
                                                                            title="Hapus Data">
                                                                            <i class="ti-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-center py-5">
                                                <div class="mb-3">
                                                    <i class="ti-volume" style="font-size: 4rem; color: #dee2e6;"></i>
                                                </div>
                                                <h5 class="text-muted">Belum Ada Data Audiometri</h5>
                                                <p class="text-muted">Silakan tambah pemeriksaan audiometri baru untuk
                                                    pasien ini.</p>
                                                <a href="{{ route('rawat-inap.audiometri.create', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus mr-2"></i>Tambah Pemeriksaan Pertama
                                                </a>
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
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="ti-alert-triangle text-warning mr-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus data audiometri ini?</p>
                    <small class="text-danger">Data yang dihapus tidak dapat dikembalikan.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti-close mr-1"></i>Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti-trash mr-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function confirmDelete(id) {
            const deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `{{ url()->current() }}/${id}`;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }

        // Auto hide alert after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    if (alert.querySelector('.btn-close')) {
                        alert.querySelector('.btn-close').click();
                    }
                });
            }, 5000);
        });
    </script>
@endpush
