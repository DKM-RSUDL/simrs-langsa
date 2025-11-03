@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .verification-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .nav-link.active {
            background-color: #007bff !important;
            color: white !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                {{-- Tabs --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="?tab=pengelolaan" class="nav-link active" aria-selected="false">
                            Pengelolaan
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="?tab=monitoring" class="nav-link" aria-selected="true">
                            Monitoring
                        </a>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active">
                        {{-- TAB 1. Pengelolaan --}}
                        @include('components.page-header', [
                            'title' => 'Data Pengelolaan Pengawasan Darah',
                            'description' => 'Daftar data pengelolaan pengawasan darah pasien gawat darurat.',
                        ])
                        <div class="d-flex flex-column gap-2">
                            <div class="text-end d-flex gap-2 justify-content-end">
                                <a href="{{ route('pengawasan-darah.print', [
                                    'kd_pasien' => $dataMedis->kd_pasien,
                                    'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                    'urut_masuk' => $dataMedis->urut_masuk,
                                ]) }}"
                                    class="btn btn-success" target="_blank">
                                    <i class="bi bi-printer"></i> Print
                                </a>
                                <a href="{{ route('pengawasan-darah.pengelolaan.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="btn btn-primary">
                                    <i class="ti-plus"></i> Tambah
                                </a>
                            </div>
                            {{-- Data Table --}}
                            @if ($pengelolaanDarah->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Transfusi Ke</th>
                                                <th>No. Seri Kantong</th>
                                                <th>Status Verifikasi</th>
                                                <th>Petugas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengelolaanDarah as $index => $data)
                                                <tr>
                                                    <td>{{ $pengelolaanDarah->firstItem() + $index }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($data->tanggal)) }}</td>
                                                    <td>{{ date('H:i', strtotime($data->jam)) }}</td>
                                                    <td>
                                                        <span class="badge bg-primary">Ke-{{ $data->transfusi_ke }}</span>
                                                    </td>
                                                    <td>{{ $data->nomor_seri_kantong }}</td>
                                                    <td>
                                                        @php
                                                            $verifikasi = [
                                                                $data->riwayat_komponen_sesuai,
                                                                $data->identitas_label_sesuai,
                                                                $data->golongan_darah_sesuai,
                                                                $data->volume_sesuai,
                                                                $data->kantong_utuh,
                                                                $data->tidak_expired,
                                                            ];
                                                            $totalSesuai = array_sum($verifikasi);
                                                        @endphp

                                                        @if ($totalSesuai == 6)
                                                            <span class="badge bg-success">Semua Sesuai</span>
                                                        @elseif($totalSesuai >= 4)
                                                            <span class="badge bg-warning">{{ $totalSesuai }}/6
                                                                Sesuai</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ $totalSesuai }}/6
                                                                Sesuai</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <small>
                                                            P1: {{ $data->petugas1->nama ?? 'N/A' }}<br>
                                                            P2: {{ $data->petugas2->nama ?? 'N/A' }}
                                                        </small>
                                                    </td>
                                                    {{-- Update bagian tombol aksi di tabel pengelolaan --}}
                                                    <td>
                                                        <x-table-action>
                                                            <a href="{{ route('pengawasan-darah.pengelolaan.show', [
                                                                'kd_pasien' => $dataMedis->kd_pasien,
                                                                'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                                'urut_masuk' => $dataMedis->urut_masuk,
                                                                'id' => $data->id,
                                                            ]) }}"
                                                                class="btn btn-info btn-sm" title="Lihat Detail">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="{{ route('pengawasan-darah.pengelolaan.edit', [
                                                                'kd_pasien' => $dataMedis->kd_pasien,
                                                                'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                                'urut_masuk' => $dataMedis->urut_masuk,
                                                                'id' => $data->id,
                                                            ]) }}"
                                                                class="btn btn-warning btn-sm" title="Edit">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <form
                                                                action="{{ route('pengawasan-darah.pengelolaan.destroy', [
                                                                    'kd_pasien' => $dataMedis->kd_pasien,
                                                                    'tgl_masuk' => date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                                    'urut_masuk' => $dataMedis->urut_masuk,
                                                                    'id' => $data->id,
                                                                ]) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')

                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    data-confirm data-confirm-title="Anda yakin?"
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

                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-end">
                                        {{ $pengelolaanDarah->links() }}
                                    </div>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm table-hover">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Transfusi Ke</th>
                                                <th>No. Seri Kantong</th>
                                                <th>Status Verifikasi</th>
                                                <th>Petugas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="8" class="text-center">Tidak ada data Pengelolaan
                                                    Pengawasan Darah</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/helpers/confirm.js') }}"></script>
@endpush
