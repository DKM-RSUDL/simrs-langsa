@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    <div class="row">
        <!-- Patient Card Section -->
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <!-- Main Content Section -->
        <div class="col-md-9">
            @include('components.navigation-ranap')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <!-- Navigation Tabs -->
                        <ul class="nav nav-tabs" id="mppTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.mpp.form-a.index', [
                                    $dataMedis->kd_unit,
                                    $dataMedis->kd_pasien,
                                    date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                    $dataMedis->urut_masuk,
                                ]) }}"
                                    class="nav-link active" aria-selected="true">
                                    <i class="ti-clipboard me-1"></i>Form A
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.mpp.form-b.index', [
                                    $dataMedis->kd_unit,
                                    $dataMedis->kd_pasien,
                                    date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                    $dataMedis->urut_masuk,
                                ]) }}"
                                    class="nav-link" aria-selected="false">
                                    <i class="ti-clipboard me-1"></i>Form B
                                </a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-3" id="mppTabContent">
                            <div class="tab-pane fade show active">
                                <!-- Header Actions -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="mb-0">Data Evaluasi Awal MPP - Form A</h5>
                                    <a href="{{ route('rawat-inap.mpp.form-a.create', [
                                        $dataMedis->kd_unit,
                                        $dataMedis->kd_pasien,
                                        date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                        $dataMedis->urut_masuk,
                                    ]) }}"
                                        class="btn btn-primary">
                                        <i class="ti-plus me-1"></i>Tambah Data
                                    </a>
                                </div>

                                <!-- Data Table Section -->
                                <div class="table-responsive">
                                    @if ($mppDataList->count() > 0)
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th width="5%" class="text-center">No</th>
                                                    <th>DPJP Utama</th>
                                                    <th>DPJP Tambahan</th>
                                                    <th class="text-center">Status Kriteria</th>
                                                    <th class="text-center">Tanggal Screening</th>
                                                    <th class="text-center">Tanggal Assessment</th>
                                                    <th class="text-center">Tanggal Identifikasi</th>
                                                    <th class="text-center">Tanggal Planning</th>
                                                    <th width="12%" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($mppDataList as $index => $mppData)
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>

                                                        <!-- DPJP Utama -->
                                                        <td>
                                                            @if ($mppData->dokterUtama)
                                                                <strong>{{ $mppData->dokterUtama->nama }}</strong>
                                                            @else
                                                                <span class="text-muted fst-italic">Belum ditentukan</span>
                                                            @endif
                                                        </td>

                                                        <!-- DPJP Tambahan -->
                                                        <td>
                                                            @if ($mppData->dokterTambahan)
                                                                {{ $mppData->dokterTambahan->nama }}
                                                            @else
                                                                <span class="text-muted fst-italic">Tidak ada</span>
                                                            @endif
                                                        </td>

                                                        <!-- Status Kriteria -->
                                                        <td class="text-center">
                                                            @php
                                                                $screeningCount = collect([
                                                                    $mppData->fungsi_kognitif,
                                                                    $mppData->risiko_tinggi,
                                                                    $mppData->potensi_komplain,
                                                                    $mppData->riwayat_kronis,
                                                                    $mppData->status_fungsional,
                                                                    $mppData->peralatan_medis,
                                                                    $mppData->gangguan_mental,
                                                                    $mppData->sering_igd,
                                                                    $mppData->perkiraan_asuhan,
                                                                    $mppData->sistem_pembiayaan,
                                                                    $mppData->length_of_stay,
                                                                    $mppData->rencana_pemulangan,
                                                                    $mppData->lain_lain,
                                                                ])->sum();

                                                                $assessmentCount = collect([
                                                                    $mppData->fisik_fungsional,
                                                                    $mppData->riwayat_kesehatan,
                                                                    $mppData->perilaku_psiko,
                                                                    $mppData->kesehatan_mental,
                                                                    $mppData->dukungan_keluarga,
                                                                    $mppData->finansial_asuransi,
                                                                    $mppData->riwayat_obat,
                                                                    $mppData->trauma_kekerasan,
                                                                    $mppData->health_literacy,
                                                                    $mppData->aspek_legal,
                                                                    $mppData->harapan_hasil,
                                                                ])->sum();

                                                                $identificationCount = collect([
                                                                    $mppData->tingkat_asuhan,
                                                                    $mppData->over_under_utilization,
                                                                    $mppData->ketidak_patuhan,
                                                                    $mppData->edukasi_kurang,
                                                                    $mppData->kurang_dukungan,
                                                                    $mppData->penurunan_determinasi,
                                                                    $mppData->kendala_keuangan,
                                                                    $mppData->pemulangan_rujukan,
                                                                ])->sum();

                                                                $planningCount = collect([
                                                                    $mppData->validasi_rencana,
                                                                    $mppData->rencana_informasi,
                                                                    $mppData->rencana_melibatkan,
                                                                    $mppData->fasilitas_penyelesaian,
                                                                    $mppData->bantuan_alternatif,
                                                                ])->sum();
                                                            @endphp

                                                            <div class="d-flex flex-column gap-1">
                                                                <span class="badge bg-info">
                                                                    <i class="ti-search me-1"></i>Screening:
                                                                    {{ $screeningCount }}
                                                                </span>
                                                                <span class="badge bg-success">
                                                                    <i class="ti-check me-1"></i>Assessment:
                                                                    {{ $assessmentCount }}
                                                                </span>
                                                                <span class="badge bg-warning">
                                                                    <i class="ti-eye me-1"></i>Identifikasi:
                                                                    {{ $identificationCount }}
                                                                </span>
                                                                <span class="badge bg-primary">
                                                                    <i class="ti-target me-1"></i>Planning:
                                                                    {{ $planningCount }}
                                                                </span>
                                                            </div>
                                                        </td>

                                                        <!-- Date Columns -->
                                                        @foreach (['screening', 'assessment', 'identification', 'planning'] as $dateType)
                                                            <td class="text-center">
                                                                @php
                                                                    $dateField = $dateType . '_date';
                                                                    $timeField = $dateType . '_time';
                                                                @endphp

                                                                @if ($mppData->$dateField)
                                                                    <div class="text-primary fw-bold">
                                                                        {{ date('d/m/Y', strtotime($mppData->$dateField)) }}
                                                                    </div>
                                                                    @if ($mppData->$timeField)
                                                                        <small class="text-muted">
                                                                            <i
                                                                                class="ti-time me-1"></i>{{ date('H:i', strtotime($mppData->$timeField)) }}
                                                                        </small>
                                                                    @endif
                                                                @else
                                                                    <span class="text-muted fst-italic">Belum
                                                                        dilakukan</span>
                                                                @endif
                                                            </td>
                                                        @endforeach

                                                        <!-- Action Buttons -->
                                                        <td class="text-center">
                                                            <div class="btn-group" role="group">

                                                                <a href="{{ route('rawat-inap.mpp.form-a.print', [
                                                                    'kd_unit' => $kd_unit,
                                                                    'kd_pasien' => $kd_pasien,
                                                                    'tgl_masuk' => $tgl_masuk,
                                                                    'urut_masuk' => $urut_masuk,
                                                                    'id' => $mppData->id,
                                                                ]) }}"
                                                                    class="btn btn-info btn-sm me-2" target="_blank">
                                                                    <i class="ti-printer"></i>
                                                                </a>

                                                                <a href="{{ route('rawat-inap.mpp.form-a.edit', [
                                                                    $dataMedis->kd_unit,
                                                                    $dataMedis->kd_pasien,
                                                                    date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                                    $dataMedis->urut_masuk,
                                                                    $mppData->id,
                                                                ]) }}"
                                                                    class="btn btn-warning btn-sm me-2" title="Edit Data"
                                                                    data-bs-toggle="tooltip">
                                                                    <i class="ti-pencil"></i>
                                                                </a>

                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm btn-delete"
                                                                    title="Hapus Data" data-bs-toggle="tooltip"
                                                                    data-id="{{ $mppData->id }}"
                                                                    data-url="{{ route('rawat-inap.mpp.form-a.destroy', [
                                                                        $dataMedis->kd_unit,
                                                                        $dataMedis->kd_pasien,
                                                                        date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                                        $dataMedis->urut_masuk,
                                                                        $mppData->id,
                                                                    ]) }}">
                                                                    <i class="ti-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <!-- Empty State -->
                                        <div class="text-center py-5">
                                            <div class="mb-4">
                                                <i class="ti-clipboard" style="font-size: 4rem; color: #dee2e6;"></i>
                                            </div>
                                            <h4 class="text-muted mb-3">Belum Ada Data Form A</h4>
                                            <p class="text-muted mb-4">
                                                Silakan tambah data evaluasi awal MPP dengan mengklik tombol
                                                <strong>"Tambah Data"</strong> di atas untuk memulai.
                                            </p>
                                            <a href="{{ route('rawat-inap.mpp.form-a.create', [
                                                $dataMedis->kd_unit,
                                                $dataMedis->kd_pasien,
                                                date('Y-m-d', strtotime($dataMedis->tgl_masuk)),
                                                $dataMedis->urut_masuk,
                                            ]) }}"
                                                class="btn btn-primary">
                                                <i class="ti-plus me-2"></i>Tambah Data Pertama
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

    <!-- Hidden form for delete action -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('js')
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Handle delete button click
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();

                const deleteUrl = $(this).data('url');
                const dataId = $(this).data('id');

                Swal.fire({
                    title: 'Konfirmasi Hapus Data',
                    html: `
                        <div class="text-start">
                            <p class="mb-2">Apakah Anda yakin ingin menghapus data <strong>Form A - Evaluasi Awal MPP</strong> ini?</p>
                            <div class="alert alert-warning">
                                <i class="ti-alert-triangle me-2"></i>
                                <strong>Peringatan:</strong> Data yang telah dihapus tidak dapat dikembalikan lagi.
                            </div>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus Data',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger ms-2',
                        cancelButton: 'btn btn-secondary me-2',
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Menghapus Data...',
                            html: 'Mohon tunggu sebentar.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Set form action and submit
                        $('#deleteForm').attr('action', deleteUrl);
                        $('#deleteForm').submit();
                    }
                });
            });

            // Show success message if data was deleted successfully
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#198754',
                    confirmButtonText: 'OK'
                });
            @endif

            // Show error message if deletion failed
            @if (session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endpush
