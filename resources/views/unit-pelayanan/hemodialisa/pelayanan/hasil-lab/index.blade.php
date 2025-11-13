@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .table th {
            background-color: #e3f2fd;
            color: #1976d2;
            font-weight: 600;
            border-bottom: 2px solid #1976d2;
        }

        .btn-action {
            margin: 0 2px;
            padding: 5px 8px;
            font-size: 12px;
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table {
            margin-bottom: 0;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .serologic-tests .test-item {
            margin-bottom: 4px;
        }

        .serologic-tests .badge {
            font-size: 10px;
            padding: 3px 6px;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .serologic-tests small {
            font-size: 9px;
            margin-left: 5px;
        }

        .lab-summary {
            font-size: 12px;
            color: #6c757d;
        }

        .lab-summary .badge {
            font-size: 10px;
            margin-right: 5px;
        }

        .btn-group .btn {
            border-radius: 3px;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
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

            <x-content-card>
                @include('components.page-header', [
                    'title' => 'Daftar Data Hasil Lab',
                    'description' => 'Daftar data hasil lab hemodialisa.',
                ])

                <!-- Header -->
                <div class="text-end">
                    <a href="{{ route('hemodialisa.pelayanan.hasil-lab.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                        class="btn btn-primary">
                        <i class="ti-plus"></i> Tambah Data
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">Tanggal</th>
                                <th width="10%">Waktu</th>
                                <th width="15%">Pemeriksaan</th>
                                <th width="23%">Hasil Lab Utama</th>
                                <th width="20%">Serologi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataHasilLab as $index => $lab)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="text-primary fw-bold">
                                            {{ date('d/m/Y', strtotime($lab->tanggal_implementasi)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ date('H:i', strtotime($lab->jam_implementasi)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="lab-summary">
                                            @if ($lab->pemeriksaan_urine_rutin)
                                                <span class="badge badge-success">Urine</span>
                                            @endif
                                            @if ($lab->pemeriksaan_feres_rutin)
                                                <span class="badge badge-warning">Feses</span>
                                            @endif
                                            @if ($lab->pemeriksaan_lain_lain)
                                                <span class="badge badge-info">Lainnya</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if ($lab->detail && $lab->detail->count() > 0)
                                            @php $detail = $lab->detail->first(); @endphp
                                            <div class="lab-summary">
                                                @if ($detail->hb)
                                                    <div><strong>HB:</strong> {{ number_format($detail->hb, 1) }}
                                                        g/dL</div>
                                                @endif
                                                @if ($detail->ureum_pre)
                                                    <div><strong>Ureum Pre:</strong>
                                                        {{ number_format($detail->ureum_pre, 1) }} mg/dL</div>
                                                @endif
                                                @if ($detail->kreatinin_pre)
                                                    <div><strong>Kreatinin Pre:</strong>
                                                        {{ number_format($detail->kreatinin_pre, 1) }} mg/dL</div>
                                                @endif
                                                @if ($detail->glukosa_sewaktu)
                                                    <div><strong>Glukosa:</strong>
                                                        {{ number_format($detail->glukosa_sewaktu, 1) }} mg/dL</div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($lab->detail && $lab->detail->count() > 0)
                                            @php $detail = $lab->detail->first(); @endphp
                                            <div class="serologic-tests">
                                                @if ($detail->hbsag_rapid)
                                                    <div class="test-item">
                                                        <span
                                                            class="badge {{ $detail->hbsag_rapid == 'Positif' ? 'badge-danger' : 'badge-success' }}">
                                                            HBsAg
                                                        </span>
                                                        <small>{{ $detail->hbsag_rapid }}</small>
                                                    </div>
                                                @endif
                                                @if ($detail->anti_hcv_rapid)
                                                    <div class="test-item">
                                                        <span
                                                            class="badge {{ $detail->anti_hcv_rapid == 'Positif' ? 'badge-danger' : 'badge-success' }}">
                                                            Anti-HCV
                                                        </span>
                                                        <small>{{ $detail->anti_hcv_rapid }}</small>
                                                    </div>
                                                @endif
                                                @if ($detail->anti_hiv_rapid)
                                                    <div class="test-item">
                                                        <span
                                                            class="badge {{ $detail->anti_hiv_rapid == 'Positif' ? 'badge-danger' : 'badge-success' }}">
                                                            Anti-HIV
                                                        </span>
                                                        <small>{{ $detail->anti_hiv_rapid }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <x-table-action>
                                            <!-- Tombol Lihat -->
                                            <a href="{{ route('hemodialisa.pelayanan.hasil-lab.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $lab->id]) }}"
                                                class="btn btn-info btn-sm btn-action" title="Lihat Detail">
                                                <i class="ti-eye"></i>
                                            </a>

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('hemodialisa.pelayanan.hasil-lab.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $lab->id]) }}"
                                                class="btn btn-warning btn-sm btn-action" title="Edit Data">
                                                <i class="ti-pencil"></i>
                                            </a>
                                              <!-- Tombol print -->
                                            <a href="{{ route('hemodialisa.pelayanan.hasil-lab.print-pdf', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $lab->id]) }}"
                                                class="btn btn-sm btn-info mx-1" target="_blank" title="Cetak">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <!-- Tombol Delete -->
                                            <form method="POST"
                                                action="{{ route('hemodialisa.pelayanan.hasil-lab.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $lab->id]) }}"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-action"
                                                    title="Hapus Data">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </x-table-action>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <i class="ti-clipboard"></i>
                                            <h6>Belum ada data hasil lab</h6>
                                            <p class="text-muted">Klik tombol "Tambah Data" untuk menambahkan hasil
                                                lab baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-content-card>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $(document).ready(function() {

            // Loading state for Tambah Data button
            $('.btn-primary').on('click', function(e) {
                const $btn = $(this);
                const originalHtml = $btn.html();

                // Show loading state
                $btn.prop('disabled', true);
                $btn.html('<i class="spinner-border spinner-border-sm mr-2" role="status"></i> Memuat...');
                $btn.addClass('btn-loading');
            });

            // Loading state for View (Show) button
            $('.btn-info').on('click', function(e) {
                const $btn = $(this);
                const originalHtml = $btn.html();

                // Show loading state
                $btn.prop('disabled', true);
                $btn.html('<i class="spinner-border spinner-border-sm" role="status"></i>');
                $btn.addClass('btn-loading');
            });

            // Loading state for Edit button
            $('.btn-warning').on('click', function(e) {
                const $btn = $(this);
                const originalHtml = $btn.html();

                // Show loading state
                $btn.prop('disabled', true);
                $btn.html('<i class="spinner-border spinner-border-sm" role="status"></i>');
                $btn.addClass('btn-loading');
            });

            // Enhanced delete confirmation with loading
            $('.btn-danger').on('click', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const $form = $btn.closest('form');

                // Show confirmation dialog
                if (confirm('Apakah Anda yakin ingin menghapus data hasil lab ini?')) {
                    // Show loading state
                    $btn.prop('disabled', true);
                    $btn.html('<i class="spinner-border spinner-border-sm" role="status"></i>');
                    $btn.addClass('btn-loading');

                    // Submit form after short delay for visual feedback
                    setTimeout(function() {
                        $form.submit();
                    }, 300);
                }
            });

            // Generic loading for any link that navigates away
            $('a:not([href^="#"]):not([href^="javascript:"]):not(.no-loading)').on('click', function(e) {
                const $link = $(this);

                // Skip if already has loading or is external link
                if ($link.hasClass('btn-loading') || $link.attr('href').startsWith('http')) {
                    return;
                }

                // Add loading class for visual feedback
                $link.addClass('btn-loading');
            });

            // Re-enable buttons if user navigates back
            $(window).on('pageshow', function(event) {
                if (event.originalEvent.persisted) {
                    $('.btn-loading').each(function() {
                        const $btn = $(this);
                        $btn.prop('disabled', false);
                        $btn.removeClass('btn-loading');

                        // Restore original content based on button type
                        if ($btn.hasClass('btn-primary')) {
                            $btn.html('<i class="ti-plus"></i> Tambah Data');
                        } else if ($btn.hasClass('btn-info')) {
                            $btn.html('<i class="ti-eye"></i>');
                        } else if ($btn.hasClass('btn-warning')) {
                            $btn.html('<i class="ti-pencil"></i>');
                        } else if ($btn.hasClass('btn-danger')) {
                            $btn.html('<i class="ti-trash"></i>');
                        }
                    });
                }
            });
        });
    </script>
@endpush
