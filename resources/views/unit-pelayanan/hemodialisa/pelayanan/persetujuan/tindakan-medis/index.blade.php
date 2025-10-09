@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .badge-setuju {
            background-color: #28a745;
            color: white;
        }

        .badge-menolak {
            background-color: #dc3545;
            color: white;
        }

        .badge-pasien {
            background-color: #17a2b8;
            color: white;
        }

        .badge-keluarga {
            background-color: #ffc107;
            color: black;
        }

        .info-breakdown {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .info-item {
            display: inline-block;
            margin-right: 0.3rem;
            padding: 0.1rem 0.2rem;
            background-color: #e9ecef;
            border-radius: 2px;
            font-size: 0.7rem;
        }

        .info-checked {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-hemodialisa')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="tindakanHd" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('hemodialisa.pelayanan.persetujuan.tindakan-hd.*')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    P. Tindakan HD
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.akses-femoralis.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('hemodialisa.pelayanan.persetujuan.akses-femoralis.*')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    P. Akses Femoralis
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-medis.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('hemodialisa.pelayanan.persetujuan.tindakan-medis.*')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    P. Tindakan Medis
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="nav-link @if (request()->routeIs('hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.*')) active @endif">
                                    <i class="bi bi-person-heart me-2"></i>
                                    Implementasi dan Evaluasi Keperawatan
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">

                                <div class="row">
                                    <form method="GET"
                                        action="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-medis.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                        <div class="row m-3">
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="ti-search"></i>
                                                    </span>
                                                    <input type="text" name="search" class="form-control"
                                                        placeholder="Cari dokter, tipe penerima..."
                                                        value="{{ request('search') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <input type="date" name="dari_tanggal" class="form-control"
                                                    placeholder="Dari Tanggal" value="{{ request('dari_tanggal') }}">
                                            </div>

                                            <div class="col-md-2">
                                                <input type="date" name="sampai_tanggal" class="form-control"
                                                    placeholder="Sampai Tanggal" value="{{ request('sampai_tanggal') }}">
                                            </div>

                                            <div class="col-md-2">
                                                <button class="btn btn-outline-secondary" type="submit">
                                                    <i class="ti-filter"></i> Filter
                                                </button>
                                            </div>

                                            <div class="col-md-3 text-end">
                                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-medis.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary">
                                                    <i class="ti-plus"></i> Tambah Data
                                                </a>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal & Jam</th>
                                                    <th>Penerima Info</th>
                                                    <th>Tindakan</th>
                                                    <th>Petugas Input</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($dataPersetujuan as $key => $item)
                                                    <tr>
                                                        <td>{{ $dataPersetujuan->firstItem() + $key }}</td>
                                                        <td>
                                                            {{ date('d-m-Y', strtotime($item->tanggal_implementasi)) }}
                                                            {{ date('H:i', strtotime($item->jam_implementasi)) }}
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $item->tipe_penerima }}">{{ ucfirst($item->tipe_penerima) }}</span>
                                                            @if ($item->tipe_penerima == 'pasien')
                                                                <div class="info-breakdown">
                                                                    Nama: {{ $dataMedis->pasien->nama }} | Umur:
                                                                    {{ $dataMedis->pasien->umur }} | JK:
                                                                    {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}
                                                                    | Alamat: {{ $dataMedis->pasien->alamat }}
                                                                </div>
                                                            @else
                                                                <div class="info-breakdown">
                                                                    Nama: {{ $item->nama_keluarga }} | Umur:
                                                                    {{ $item->umur_keluarga }} | JK:
                                                                    {{ $item->jk_keluarga }} | Status:
                                                                    {{ ucfirst($item->status_keluarga) }} | Alamat:
                                                                    {{ $item->alamat_keluarga }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <ul class="list-unstyled m-0">
                                                                @php
                                                                    $tindakanList =
                                                                        json_decode($item->tindakan, true) ?? [];
                                                                    $allTindakan = [
                                                                        'hemodialisis' => 'HEMODIALISIS',
                                                                        'akses_vascular_fmoralis' =>
                                                                            'AKSES VASCULAR FMORALIS',
                                                                        'akses_vascular_subclavicula' =>
                                                                            'AKSES VASCULAR SUBCLAVICULA CATHETER',
                                                                        'akses_vascular_cimino' =>
                                                                            'AKSES VASCULAR ANTERIOR VENOUS FISTULA (CIMINO)',
                                                                    ];
                                                                @endphp
                                                                @foreach ($allTindakan as $key => $label)
                                                                    @if (in_array($key, $tindakanList))
                                                                        <li class="info-item info-checked">
                                                                            {{ $label }}</li>
                                                                    @endif
                                                                @endforeach
                                                                @if (empty($tindakanList))
                                                                    <li class="info-item">Tidak ada tindakan</li>
                                                                @endif
                                                            </ul>
                                                        </td>
                                                        <td>{{ $item->userCreated->name ?? 'Tidak Diketahui' }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-medis.print-pdf', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-info btn-sm me-2" target="_blank"
                                                                    title="Lihat Detail">
                                                                    <i class="fas fa-print"></i>
                                                                </a>
                                                                <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-medis.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    class="btn btn-warning btn-sm me-2" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </a>
                                                                <form
                                                                    action="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-medis.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                    method="POST" style="display: inline;"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @if ($dataPersetujuan->isEmpty())
                                                    <tr>
                                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $dataPersetujuan->links() }}
                                    </div>

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
    <script></script>
@endpush
