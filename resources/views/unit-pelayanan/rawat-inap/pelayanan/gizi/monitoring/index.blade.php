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
        
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }
        
        .badge-info {
            background-color: #17a2b8;
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

        .status-progress {
            font-size: 0.7rem;
            margin-top: 2px;
        }

        .progress-mini {
            height: 8px;
            margin-top: 3px;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .required {
            color: red;
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
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.gizi.anak.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="nav-link" aria-selected="false">
                                    Pengkajian Gizi Anak
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.gizi.dewasa.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="nav-link" aria-selected="true">
                                    Pengkajian Gizi Dewasa
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="{{ route('rawat-inap.gizi.monitoring.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="nav-link active" aria-selected="true">
                                    Monitoring dan Evaluasi
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                <div class="row">
                                    <div class="d-flex justify-content-between m-3">
                                        <div class="row w-100">
                                            <div class="col-md-8">
                                                <h6 class="mb-0">Data Gizi Dewasa</h6>
                                                <small class="text-muted">Pengisian dapat dilakukan secara bertahap</small>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <button type="button" class="btn btn-primary btn" data-bs-toggle="modal" data-bs-target="#modalTambahMonitoring">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tabel Data Monitoring --}}
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal/Jam</th>
                                                <th>Energi (Kkal)</th>
                                                <th>Protein (g)</th>
                                                <th>KH (g)</th>
                                                <th>Lemak (g)</th>
                                                <th>Masalah Perkembangan</th>
                                                <th>Tindak Lanjut</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($monitoringGizi as $index => $monitoring)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        @if($monitoring->tanggal_monitoring)
                                                            {{ \Carbon\Carbon::parse($monitoring->tanggal_monitoring)->format('d/m/Y H:i') }}
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($monitoring->energi, 1) }}</td>
                                                    <td>{{ number_format($monitoring->protein, 1) }}</td>
                                                    <td>{{ number_format($monitoring->karbohidrat, 1) }}</td>
                                                    <td>{{ number_format($monitoring->lemak, 1) }}</td>
                                                    <td>
                                                        @if($monitoring->masalah_perkembangan)
                                                            <span title="{{ $monitoring->masalah_perkembangan }}">
                                                                {{ Str::limit($monitoring->masalah_perkembangan, 30) }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($monitoring->tindak_lanjut)
                                                            <span title="{{ $monitoring->tindak_lanjut }}">
                                                                {{ Str::limit($monitoring->tindak_lanjut, 30) }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info" onclick="lihatDetail({{ $monitoring->id }})" title="Lihat Detail">
                                                            <i class="ti-eye"></i>
                                                        </button>
                                                        <form method="POST" action="{{ route('rawat-inap.gizi.monitoring.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id" value="{{ $monitoring->id }}">
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center text-muted py-4">
                                                        <i class="ti-clipboard text-muted" style="font-size: 2rem;"></i><br>
                                                        Belum ada data monitoring
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('unit-pelayanan.rawat-inap.pelayanan.gizi.monitoring.modal')
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Form validation
        $('#formTambahMonitoring').on('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            // Validasi field required
            $(this).find('input[required], textarea[required]').each(function() {
                if ($(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    errorMessage += 'Field ' + $(this).prev('label').text().replace('*', '') + ' harus diisi\n';
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Validasi nilai numerik
            const numericalFields = ['energi', 'protein', 'karbohidrat', 'lemak'];
            numericalFields.forEach(function(field) {
                const value = parseFloat($('#' + field).val());
                if (isNaN(value) || value < 0) {
                    isValid = false;
                    $('#' + field).addClass('is-invalid');
                    errorMessage += 'Field ' + $('#' + field).prev('label').text().replace('*', '') + ' harus berisi angka yang valid\n';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Terjadi kesalahan:\n' + errorMessage);
                return false;
            }

            // Show loading state
            $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="ti-reload me-2"></i>Menyimpan...');
        });

        // Reset form when modal is closed
        $('#modalTambahMonitoring').on('hidden.bs.modal', function() {
            $('#formTambahMonitoring')[0].reset();
            $('#formTambahMonitoring').find('.is-invalid').removeClass('is-invalid');
            $('#formTambahMonitoring').find('button[type="submit"]').prop('disabled', false).html('<i class="ti-save me-2"></i>Simpan Data');
            
            // Reset to current date and time
            $('#tanggal').val(new Date().toISOString().split('T')[0]);
            $('#jam').val(new Date().toTimeString().slice(0, 5));
        });

        // Remove invalid class on input change
        $('.form-control').on('input change', function() {
            $(this).removeClass('is-invalid');
        });
    });

    // Function untuk lihat detail
    function lihatDetail(id) {
        $('#detailContent').html('<div class="text-center"><i class="ti-reload fa-spin"></i> Memuat data...</div>');
        $('#modalDetailMonitoring').modal('show');

        // Ambil data dari tabel yang sudah ada (alternatif sederhana)
        const row = $('button[onclick="lihatDetail(' + id + ')"]').closest('tr');
        const cells = row.find('td');
        
        // Ambil tanggal dari kolom tanggal_monitoring (kolom index 1)
        const tanggalMonitoring = cells.eq(1).text().trim();
        
        const detailHtml = `
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Tanggal/Jam:</th>
                            <td><strong>${tanggalMonitoring !== '-' ? tanggalMonitoring : 'Tidak diketahui'}</strong></td>
                        </tr>
                        <tr>
                            <th>Energi:</th>
                            <td>${cells.eq(2).text()} Kkal</td>
                        </tr>
                        <tr>
                            <th>Protein:</th>
                            <td>${cells.eq(3).text()} g</td>
                        </tr>
                        <tr>
                            <th>Karbohidrat:</th>
                            <td>${cells.eq(4).text()} g</td>
                        </tr>
                        <tr>
                            <th>Lemak:</th>
                            <td>${cells.eq(5).text()} g</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="fw-bold">Masalah Perkembangan:</label>
                        <div class="border rounded p-2 bg-light" style="min-height: 60px;">
                            ${cells.eq(6).text() === '-' ? '<em class="text-muted">Tidak ada</em>' : cells.eq(6).text()}
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label class="fw-bold">Tindak Lanjut:</label>
                        <div class="border rounded p-2 bg-light" style="min-height: 60px;">
                            ${cells.eq(7).text() === '-' ? '<em class="text-muted">Tidak ada</em>' : cells.eq(7).text()}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-info">
                        <small><i class="ti-info-alt me-1"></i> Data monitoring berdasarkan tanggal dan jam yang telah diinput</small>
                    </div>
                </div>
            </div>
        `;
        
        $('#detailContent').html(detailHtml);
    }
</script>
@endpush