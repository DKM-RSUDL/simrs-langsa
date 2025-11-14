@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .patient-card .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .patient-card .nav-link.active p {
            color: #fff;
        }

        .patient-card img.rounded-circle {
            object-fit: cover;
        }

        .tab-content {
            flex-grow: 1;
            width: 350px;
        }

        #diagnoseList {
            min-height: 80px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px dashed #dee2e6;
        }

        .diag-item:hover {
            background: #f1f3f5 !important;
        }

        .drag-handle {
            cursor: grab;
            width: 40px;
        }

        .drag-handle:active {
            cursor: grabbing;
        }

        .dragging {
            opacity: 0.5;
            background: #0d6efd !important;
            transform: rotate(4deg);
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

            <!-- Content -->
            <div class="patient-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-primary mb-0">Catatan Perkembangan Pasien Terintegrasi</h6>
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
                        @include('unit-pelayanan.rawat-inap.pelayanan.cppt.modal')
                    </div>
                </div>

                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <!-- Sidebar navigation -->
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            @php
                                $i = 0;
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
                                        <div class="ms-3 text-start">
                                            <p class="mb-0"><strong>{{ $value['nama_penanggung'] }}</strong></p>
                                            <small class="text-sm">{{ str()->title($value['jenis_tenaga']) }}</small>
                                        </div>
                                    </div>
                                </button>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>

                        <!-- Tab content -->
                        <div class="tab-content flex-grow-1" id="v-pills-tabContent">
                            @php
                                // dd($cppt);
                                $j = 0;
                            @endphp

                            @foreach ($cppt as $key => $value)
                                <div class="tab-pane fade @if ($j == 0) show active @endif"
                                    id="v-pills-home-{{ $j }}" role="tabpanel">
                                    <!-- HEADER -->
                                    <div class="patient-card bg-light border rounded-3 shadow-sm p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('assets/img/profile.jpg') }}" alt="Avatar"
                                                    class="rounded-circle me-3" width="50" height="50">
                                                <div>
                                                    <p class="mb-0 fw-semibold text-dark">Catatan Perkembangan Pasien
                                                        Terintegrasi</p>
                                                    <small class="text-muted">
                                                        <strong>{{ $value['nama_penanggung'] }}</strong>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span
                                                    class="badge bg-primary-subtle text-dark border">{{ date('d M Y', strtotime($value['tanggal'])) }}</span><br>
                                                <small
                                                    class="text-muted">{{ date('H:i', strtotime($value['jam'])) }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- KONTEN -->
                                    <div class="bg-white border rounded-3 shadow-sm p-4 mb-4">
                                        @if (!empty($value['tipe_cppt']) && $value['tipe_cppt'] != 4)
                                            {{-- Format SOAP --}}
                                            @php $sections = ['S' => $value['anamnesis'], 'O' => $value['pemeriksaan_fisik'], 'A' => '', 'P' => $value['planning']]; @endphp

                                            <!-- Subjective -->
                                            <div class="mb-3 border-start border-primary ps-3">
                                                <h6 class="fw-bold text-primary mb-1">S (Subjective)</h6>
                                                <p class="mb-0">{{ $value['anamnesis'] ?? '-' }}</p>
                                            </div>

                                            <!-- Objective -->
                                            <div class="mb-3 border-start border-success ps-3">
                                                <h6 class="fw-bold text-success mb-1">O (Objective)</h6>
                                                <div class="row">
                                                    @foreach ($value['kondisi']['konpas'] as $val)
                                                        <div class="col-md-6 mb-1 small">
                                                            <i class="bi bi-caret-right-fill text-success"></i>
                                                            {{ $val['nama_kondisi'] }} :
                                                            <strong>{{ $val['hasil'] }}</strong> {{ $val['satuan'] }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <p class="mt-2 mb-0">{{ $value['pemeriksaan_fisik'] }}</p>
                                                <p class="mb-0">{{ $value['obyektif'] }}</p>
                                            </div>

                                            <!-- Assessment -->
                                            <div class="mb-3 border-start border-warning ps-3">
                                                <h6 class="fw-bold text-warning mb-1">A (Assessment)</h6>
                                                <ul class="mb-0">
                                                    @forelse ($value['cppt_penyakit'] as $v)
                                                        <li>{{ $v['nama_penyakit'] }}</li>
                                                    @empty
                                                        <li>-</li>
                                                    @endforelse
                                                </ul>
                                            </div>

                                            <!-- Plan -->
                                            <div class="border-start border-info ps-3">
                                                <h6 class="fw-bold text-info mb-1">P (Plan)</h6>
                                                <p class="mb-0">{{ $value['planning'] ?? '-' }}</p>
                                            </div>
                                        @else
                                            {{-- Format ADIME --}}
                                            <div class="mb-3 border-start border-primary ps-3">
                                                <h6 class="fw-bold text-primary mb-1">A (Assessment)</h6>
                                                <p class="mb-0">{{ $value['anamnesis'] ?? '-' }}</p>
                                                <div class="row mt-2">
                                                    @foreach ($value['kondisi']['konpas'] as $val)
                                                        <div class="col-md-6 mb-1 small">
                                                            <i class="bi bi-caret-right-fill text-primary"></i>
                                                            {{ $val['nama_kondisi'] }} :
                                                            <strong>{{ $val['hasil'] }}</strong> {{ $val['satuan'] }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="mb-3 border-start border-danger ps-3">
                                                <h6 class="fw-bold text-danger mb-1">D (Diagnosis)</h6>
                                                <ul class="mb-0">
                                                    @forelse ($value['cppt_penyakit'] as $v)
                                                        <li>{{ $v['nama_penyakit'] }}</li>
                                                    @empty
                                                        <li>-</li>
                                                    @endforelse
                                                </ul>
                                            </div>

                                            <div class="mb-3 border-start border-success ps-3">
                                                <h6 class="fw-bold text-success mb-1">I (Intervention)</h6>
                                                <p class="mb-0">{{ $value['pemeriksaan_fisik'] ?? '-' }}</p>
                                            </div>

                                            <div class="mb-3 border-start border-info ps-3">
                                                <h6 class="fw-bold text-info mb-1">M (Monitoring)</h6>
                                                <p class="mb-0">{{ $value['obyektif'] ?? '-' }}</p>
                                            </div>

                                            <div class="border-start border-secondary ps-3">
                                                <h6 class="fw-bold text-secondary mb-1">E (Evaluation)</h6>
                                                <p class="mb-0">{{ $value['planning'] ?? '-' }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- LIST INSTRUKSI -->
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-header bg-primary text-white fw-semibold">
                                            <i class="bi bi-list-check me-2"></i>List Instruksi PPA
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-striped mb-0 align-middle">
                                                    <thead class="table-light">
                                                        <tr class="text-center">
                                                            <th width="10%">No</th>
                                                            <th width="35%">Kode PPA</th>
                                                            <th>Instruksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($value['instruksi_ppa_nama'] as $index => $instruksi)
                                                            @php
                                                                $ppa_kode = is_array($instruksi)
                                                                    ? $instruksi['ppa']
                                                                    : $instruksi->ppa;
                                                                $karyawan_ppa = $karyawan
                                                                    ->where('kd_karyawan', $ppa_kode)
                                                                    ->first();
                                                                $nama_ppa = $karyawan_ppa
                                                                    ? trim(
                                                                        ($karyawan_ppa->gelar_depan
                                                                            ? $karyawan_ppa->gelar_depan . ' '
                                                                            : '') .
                                                                            $karyawan_ppa->nama .
                                                                            ($karyawan_ppa->gelar_belakang
                                                                                ? ', ' . $karyawan_ppa->gelar_belakang
                                                                                : ''),
                                                                    )
                                                                    : $ppa_kode;
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center fw-bold text-primary">
                                                                    {{ sprintf('%02d', $index + 1) }}</td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <span
                                                                            class="badge bg-info text-dark me-2">PPA</span>
                                                                        <div>
                                                                            <strong>{{ $nama_ppa }}</strong><br>
                                                                            <small
                                                                                class="text-muted">{{ $ppa_kode }}</small>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{ is_array($instruksi) ? $instruksi['instruksi'] : $instruksi->instruksi }}
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="3" class="text-center text-muted py-3">
                                                                    Tidak ada instruksi</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BUTTON AKSI -->
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        @if ($value['verified'])
                                            <span class="badge bg-success-subtle text-success border">
                                                <i class="bi bi-check-circle me-1"></i> Terverifikasi
                                            </span>
                                        @else
                                            @canany(['is-admin', 'is-dokter-umum', 'is-dokter-spesialis'])
                                                <form
                                                    action="{{ route('rawat-inap.cppt.verifikasi', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="kd_pasien"
                                                        value="{{ $dataMedis->kd_pasien }}">
                                                    <input type="hidden" name="no_transaksi"
                                                        value="{{ $dataMedis->no_transaksi }}">
                                                    <input type="hidden" name="kd_kasir"
                                                        value="{{ $dataMedis->kd_kasir }}">
                                                    <input type="hidden" name="tanggal" value="{{ $value['tanggal'] }}">
                                                    <input type="hidden" name="urut" value="{{ $value['urut'] }}">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-shield-check me-1"></i> Verifikasi DPJP
                                                    </button>
                                                </form>
                                            @endcanany
                                        @endif

                                        @if ($value['user_penanggung'] == auth()->user()->id && !$value['verified'])
                                            <button class="btn btn-outline-secondary btn-sm btn-edit-cppt"
                                                data-bs-target="#editCpptModal" data-tgl="{{ $value['tanggal'] }}"
                                                data-urut="{{ $value['urut'] }}" data-unit="{{ $value['kd_unit'] }}"
                                                data-transaksi="{{ $value['no_transaksi'] }}"
                                                data-urut-total="{{ $value['urut_total'] }}"
                                                data-tipe-cppt="{{ $value['tipe_cppt'] }}">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                @php $j++; @endphp
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('unit-pelayanan.rawat-inap.pelayanan.cppt.manage.index')
@endpush
