@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        #asesmenList .list-group-item:nth-child(even) {
            background-color: #edf7ff;
        }

        #asesmenList .list-group-item:nth-child(odd) {
            background-color: #ffffff;
        }

        #asesmenList .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .list-group-item {
            margin-bottom: 0.2rem;
            border-radius: 0.5rem !important;
            padding: 1rem;
            border: 1px solid #dee2e6;
            background: white;
            transition: all 0.2s;
        }

        .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        .gap-3 {
            gap: 1rem !important;
        }

        .gap-4 {
            gap: 1.5rem !important;
        }

        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }

        .btn i {
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-operasi')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="sign-tab" data-bs-toggle="tab" data-bs-target="#sign"
                                    type="button" role="tab" aria-controls="sign" aria-selected="true">Sebelum Induksi
                                    Anestesi (SIGN)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="timeout-tab" data-bs-toggle="tab" data-bs-target="#timeout"
                                    type="button" role="tab" aria-controls="timeout" aria-selected="false">Sebelum
                                    Insisi (TIME OUT)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="signout-tab" data-bs-toggle="tab" data-bs-target="#signout"
                                    type="button" role="tab" aria-controls="signout" aria-selected="false">Sebelum
                                    Tutup Luka Operasi (SIGN OUT)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <!-- Print Button -->
                                @if ($signin && $timeout && $signout)
                                    <div class="d-flex justify-content-end mb-3">
                                        <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.print', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                            class="btn btn-success btn-sm d-flex align-items-center" target="_blank"
                                            type="button">
                                            <i class="ti-printer me-1"></i> Print
                                        </a>
                                    </div>
                                @endif
                            </li>
                        </ul>



                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="sign" role="tabpanel"
                                aria-labelledby="sign-tab">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center m-3">
                                        @if (!$signin)
                                            <div>
                                                <h5 class="mb-0">Checklist Keselamatan Pasien (Sign In)</h5>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.create-signin', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary btn-sm d-flex align-items-center" type="button">
                                                    <i class="ti-plus me-1"></i> Tambah
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- data --}}
                                    <div class="list-group" id="signInList">
                                        @if ($signin)
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0 fw-bold">
                                                        <span class="badge bg-primary me-2">Sign In</span>
                                                        Sebelum Induksi Anestesi
                                                    </h6>
                                                    <small class="text-muted">{{ $signin->waktu_signin }}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <p class="mb-1"><i class="ti-user me-2"></i>Pasien:
                                                            {{ $dataMedis->pasien->nama_lengkap }}
                                                            ({{ $dataMedis->kd_pasien }})
                                                        </p>
                                                        <p class="mb-1"><i class="ti-medall-alt me-2"></i>Dokter
                                                            Anestesi:
                                                            {{ $signin->dokterAnestesi->dokter->nama_lengkap ?? 'Tidak Tersedia' }}
                                                        </p>
                                                        <p class="mb-1"><i class="ti-heart-broken me-2"></i>Perawat:
                                                            {{ $signin->perawatData->nama ?? 'Tidak Tersedia' }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.edit-signin', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $signin->id]) }}"
                                                            class="btn btn-sm btn-warning me-1">
                                                            <i class="ti-pencil me-1"></i>
                                                        </a>
                                                        <form method="POST"
                                                            action="{{ route('operasi.pelayanan.ceklist-keselamatan.destroy-signin', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $signin->id]) }}"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                data-confirm data-confirm-title="Anda yakin?"
                                                                data-confirm-text="Data yang dihapus tidak dapat dikembalikan"
                                                                title="Hapus operasi" aria-label="Hapus operasi">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="mt-3 bg-light p-3 rounded">
                                                    <h6 class="mb-2">Checklist Keselamatan:</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->identifikasi ? 'text-success' : 'text-danger' }}"></i>
                                                                Identifikasi dan gelang pasien:
                                                                <strong>{{ $signin->identifikasi ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->lokasi ? 'text-success' : 'text-danger' }}"></i>
                                                                Lokasi operasi:
                                                                <strong>{{ $signin->lokasi ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->prosedur ? 'text-success' : 'text-danger' }}"></i>
                                                                Prosedur operasi:
                                                                <strong>{{ $signin->prosedur ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->informed_anestesi ? 'text-success' : 'text-danger' }}"></i>
                                                                Informed consent anestesi:
                                                                <strong>{{ $signin->informed_anestesi ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->informed_operasi ? 'text-success' : 'text-danger' }}"></i>
                                                                Informed consent operasi:
                                                                <strong>{{ $signin->informed_operasi ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->tanda_lokasi ? 'text-success' : 'text-danger' }}"></i>
                                                                Lokasi operasi sudah diberi tanda:
                                                                <strong>{{ $signin->tanda_lokasi ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->mesin_obat ? 'text-success' : 'text-danger' }}"></i>
                                                                Mesin dan obat anestesi sudah dicek:
                                                                <strong>{{ $signin->mesin_obat ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->pulse_oximeter ? 'text-success' : 'text-danger' }}"></i>
                                                                Pulse oximeter sudah terpasang:
                                                                <strong>{{ $signin->pulse_oximeter ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->kesulitan_bernafas ? 'text-success' : 'text-danger' }}"></i>
                                                                Kesulitan bernafas/resiko aspirasi:
                                                                <strong>{{ $signin->kesulitan_bernafas ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->resiko_darah ? 'text-success' : 'text-danger' }}"></i>
                                                                Resiko kehilangan darah >500ml:
                                                                <strong>{{ $signin->resiko_darah ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signin->akses_intravena ? 'text-success' : 'text-danger' }}"></i>
                                                                Akses intravena/rencana terapi cairan:
                                                                <strong>{{ $signin->akses_intravena ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info mt-3">
                                                Belum ada data checklist Sign In. Silahkan tambahkan data baru.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="timeout" role="tabpanel" aria-labelledby="timeout-tab">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center m-3">
                                        @if (!$timeout)
                                            <div>
                                                <h5 class="mb-0">Checklist Keselamatan Pasien (Time Out)</h5>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.create-timeout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary btn-sm d-flex align-items-center"
                                                    type="button">
                                                    <i class="ti-plus me-1"></i> Tambah
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- data --}}
                                    <div class="list-group" id="timeoutList">
                                        @if ($timeout)
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0 fw-bold">
                                                        <span class="badge bg-info me-2">Time Out</span>
                                                        Sebelum Insisi
                                                    </h6>
                                                    <small
                                                        class="text-muted">{{ \Carbon\Carbon::parse($timeout->waktu_timeout)->format('d-m-Y H:i') }}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <p class="mb-1"><i class="ti-user me-2"></i>Pasien:
                                                            {{ $dataMedis->pasien->nama_lengkap }}
                                                            ({{ $dataMedis->kd_pasien }})
                                                        </p>
                                                        <p class="mb-1"><i class="ti-medall me-2"></i>Ahli Bedah:
                                                            {{ $timeout->dokterBedah->nama_lengkap ?? 'Tidak Tersedia' }}
                                                        </p>
                                                        <p class="mb-1"><i class="ti-medall-alt me-2"></i>Dokter
                                                            Anestesi:
                                                            {{ $timeout->dokterAnastesi->dokter->nama_lengkap ?? 'Tidak Tersedia' }}
                                                        </p>
                                                        <p class="mb-1"><i class="ti-heart-broken me-2"></i>Perawat:
                                                            {{ $timeout->perawatData->nama ?? 'Tidak Tersedia' }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.edit-timeout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $timeout->id]) }}"
                                                            class="btn btn-sm btn-warning me-1">
                                                            <i class="ti-pencil me-1"></i>
                                                        </a>
                                                        <form method="POST"
                                                            action="{{ route('operasi.pelayanan.ceklist-keselamatan.destroy-timeout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $timeout->id]) }}"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                data-confirm data-confirm-title="Anda yakin?"
                                                                data-confirm-text="Data yang dihapus tidak dapat dikembalikan"
                                                                title="Hapus operasi" aria-label="Hapus operasi">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="mt-3 bg-light p-3 rounded">
                                                    <h6 class="mb-2">Checklist Keselamatan:</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $timeout->konfirmasi_tim ? 'text-success' : 'text-danger' }}"></i>
                                                                Konfirmasi tim memperkenalkan diri:
                                                                <strong>{{ $timeout->konfirmasi_tim ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $timeout->konfirmasi_nama ? 'text-success' : 'text-danger' }}"></i>
                                                                Konfirmasi nama pasien:
                                                                <strong>{{ $timeout->konfirmasi_nama ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $timeout->konfirmasi_prosedur ? 'text-success' : 'text-danger' }}"></i>
                                                                Konfirmasi prosedur:
                                                                <strong>{{ $timeout->konfirmasi_prosedur ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $timeout->konfirmasi_lokasi ? 'text-success' : 'text-danger' }}"></i>
                                                                Konfirmasi lokasi insisi:
                                                                <strong>{{ $timeout->konfirmasi_lokasi ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $timeout->antibiotik_profilaksis ? 'text-success' : 'text-danger' }}"></i>
                                                                Antibiotik profilaksis diberikan:
                                                                <strong>{{ $timeout->antibiotik_profilaksis ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $timeout->foto_rontgen ? 'text-success' : 'text-danger' }}"></i>
                                                                Foto Rontgen/CT-Scan/MRI ditayangkan:
                                                                <strong>{{ $timeout->foto_rontgen ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            @if ($timeout->antibiotik_profilaksis)
                                                                <p class="mb-1 small">
                                                                    <i class="ti-medall me-1 text-info"></i>
                                                                    Nama antibiotik:
                                                                    <strong>{{ $timeout->nama_antibiotik ?: 'Tidak tercatat' }}</strong>
                                                                </p>
                                                                <p class="mb-1 small">
                                                                    <i class="ti-medall me-1 text-info"></i>
                                                                    Dosis antibiotik:
                                                                    <strong>{{ $timeout->dosis_antibiotik ?: 'Tidak tercatat' }}</strong>
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <h6 class="mb-2">Antisipasi Kejadian Kritis:</h6>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p class="mb-1 small">
                                                                <i class="ti-clipboard me-1 text-primary"></i>
                                                                <strong>Review dokter bedah:</strong>
                                                                {{ $timeout->review_bedah ?: 'Tidak ada catatan' }}
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i class="ti-clipboard me-1 text-primary"></i>
                                                                <strong>Review tim anestesi:</strong>
                                                                {{ $timeout->review_anastesi ?: 'Tidak ada catatan' }}
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i class="ti-clipboard me-1 text-primary"></i>
                                                                <strong>Review tim perawat:</strong>
                                                                {{ $timeout->review_perawat ?: 'Tidak ada catatan' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info mt-3">
                                                Belum ada data checklist Time Out. Silahkan tambahkan data baru.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="signout" role="tabpanel" aria-labelledby="signout-tab">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center m-3">
                                        @if (!$signout)
                                            <div>
                                                <h5 class="mb-0">Checklist Keselamatan Pasien (Sign Out)</h5>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.create-signout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                                    class="btn btn-primary btn-sm d-flex align-items-center"
                                                    type="button">
                                                    <i class="ti-plus me-1"></i> Tambah
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- data --}}
                                    <div class="list-group" id="signOutList">
                                        @if ($signout)
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0 fw-bold">
                                                        <span class="badge bg-success me-2">Sign Out</span>
                                                        Sebelum Tutup Luka Operasi
                                                    </h6>
                                                    <small class="text-muted">{{ $signout->waktu_signout }}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <p class="mb-1"><i class="ti-user me-2"></i>Pasien:
                                                            {{ $dataMedis->pasien->nama_lengkap }}
                                                            ({{ $dataMedis->kd_pasien }})
                                                        </p>
                                                        <p class="mb-1"><i class="ti-medall me-2"></i>Ahli Bedah:
                                                            @if ($signout->ahli_bedah && $signout->dokterBedah)
                                                                {{ $signout->dokterBedah->nama_lengkap }}
                                                            @else
                                                                Tidak Tersedia (ID:
                                                                {{ $signout->ahli_bedah ?? 'Kosong' }})
                                                            @endif
                                                        </p>
                                                        <p class="mb-1"><i class="ti-medall-alt me-2"></i>Dokter
                                                            Anestesi:
                                                            {{ $signout->dokterAnastesi->dokter->nama_lengkap ?? 'Tidak Tersedia' }}
                                                        </p>
                                                        <p class="mb-1"><i class="ti-heart-broken me-2"></i>Perawat:
                                                            {{ $signout->perawatData->nama ?? 'Tidak Tersedia' }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.edit-signout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $signout->id]) }}"
                                                            class="btn btn-sm btn-warning me-1">
                                                            <i class="ti-pencil me-1"></i>
                                                        </a>
                                                        <form method="POST"
                                                            action="{{ route('operasi.pelayanan.ceklist-keselamatan.destroy-signout', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $signout->id]) }}"
                                                            style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                data-confirm data-confirm-title="Anda yakin?"
                                                                data-confirm-text="Data yang dihapus tidak dapat dikembalikan"
                                                                title="Hapus operasi" aria-label="Hapus operasi">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="mt-3 bg-light p-3 rounded">
                                                    <h6 class="mb-2">Checklist Keselamatan:</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signout->konfirmasi_prosedur ? 'text-success' : 'text-danger' }}"></i>
                                                                Konfirmasi prosedur telah dilakukan:
                                                                <strong>{{ $signout->konfirmasi_prosedur ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signout->konfirmasi_instrumen ? 'text-success' : 'text-danger' }}"></i>
                                                                Konfirmasi instrumen lengkap:
                                                                <strong>{{ $signout->konfirmasi_instrumen ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signout->konfirmasi_spesimen ? 'text-success' : 'text-danger' }}"></i>
                                                                Konfirmasi spesimen (jika ada):
                                                                <strong>{{ $signout->konfirmasi_spesimen ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signout->masalah_peralatan ? 'text-success' : 'text-danger' }}"></i>
                                                                Tidak ada masalah peralatan:
                                                                <strong>{{ $signout->masalah_peralatan ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                            <p class="mb-1 small">
                                                                <i
                                                                    class="ti-check me-1 {{ $signout->review_tim ? 'text-success' : 'text-danger' }}"></i>
                                                                Review tim selesai:
                                                                <strong>{{ $signout->review_tim ? 'Ya' : 'Tidak' }}</strong>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @if ($signout->catatan_penting)
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <h6 class="mb-2">Catatan Penting:</h6>
                                                                <p class="mb-1 small">
                                                                    <i class="ti-clipboard me-1 text-primary"></i>
                                                                    <strong>{{ $signout->catatan_penting ?: 'Tidak ada catatan' }}</strong>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-info mt-3">
                                                Belum ada data checklist Sign Out. Silahkan tambahkan data baru.
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
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the stored active tab from localStorage
            const activeTab = localStorage.getItem('activeTab');

            // If there's a stored tab, activate it
            if (activeTab) {
                // Remove 'active' class from the default active tab and tab pane
                document.querySelectorAll('.nav-tabs .nav-link.active').forEach(tab => {
                    tab.classList.remove('active');
                });
                document.querySelectorAll('.tab-content .tab-pane.active').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });

                // Add 'active' class to the stored tab and its corresponding pane
                const targetTab = document.querySelector(`#${activeTab}-tab`);
                const targetPane = document.querySelector(`#${activeTab}`);
                if (targetTab && targetPane) {
                    targetTab.classList.add('active');
                    targetPane.classList.add('show', 'active');
                }
            }

            // Store the active tab in localStorage when a tab is clicked
            document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.id.replace('-tab', '');
                    localStorage.setItem('activeTab', tabId);
                });
            });
        });
    </script>

    <script src="{{ asset('js/helpers/confirm.js') }}"></script>
@endpush
