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

        /* Modal Styles */
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
            font-size: 0.85rem;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: #0c82dc;
            text-align: center;
            margin-bottom: 1.2rem;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .form-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.2rem;
        }

        .section-title {
            font-weight: 600;
            color: #004b85;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.3rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
            font-size: 0.8rem;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
            font-size: 0.85rem;
            height: auto;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.15rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.75rem;
        }

        .row {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        .row > [class*="col-"] {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .btn-loading .btn-text {
            visibility: hidden;
        }

        .btn-loading .spinner-border {
            display: inline-block !important;
        }

        .spinner-border {
            display: none;
            width: 1rem;
            height: 1rem;
            vertical-align: middle;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }

            .form-section {
                padding: 0.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('unit-pelayanan.hemodialisa.component.navigation')

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
                                    <form method="GET" action="{{ route('hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                        <div class="row m-3">
                                            <div class="col-md-3">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="ti-search"></i>
                                                    </span>
                                                    <input type="text" name="search" class="form-control" placeholder="Cari dokter, tipe penerima..." value="{{ request('search') }}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <input type="date" name="dari_tanggal" class="form-control" placeholder="Dari Tanggal" value="{{ request('dari_tanggal') }}">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <input type="date" name="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="{{ request('sampai_tanggal') }}">
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <button class="btn btn-outline-secondary" type="submit">
                                                    <i class="ti-filter"></i> Filter
                                                </button>
                                            </div>
                                            
                                            <div class="col-md-3 text-end">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                                    <i class="ti-plus"></i> Tambah Data
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal & Jam</th>
                                                    <th>Diagnosis Keperawatan</th>
                                                    <th>Implementasi Keperawatan</th>
                                                    <th>Evaluasi Keperawatan</th>
                                                    <th>Petugas Input</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($dataPersetujuan as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->tanggal_implementasi)->format('d-m-Y') }} 
                                                            {{ \Carbon\Carbon::parse($item->jam_implementasi)->format('H:i') }}
                                                        </td>
                                                        <td>{{ $item->diagnosis_keperawatan }}</td>
                                                        <td>{{ $item->implementasi_keperawatan }}</td>
                                                        <td>{{ $item->evaluasi_keperawatan }}</td>
                                                        <td>{{ $item->userCreated->name ?? 'Tidak Diketahui' }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-warning edit-btn" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#editModal" 
                                                                data-id="{{ $item->id }}"
                                                                data-url="{{ route('hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}">
                                                                <i class="ti-pencil"></i> Edit
                                                            </button>
                                                            <form action="{{ route('hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $item->id]) }}"
                                                                method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                    <i class="ti-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">Tidak ada data tersedia</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Create Modal -->
                        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title header-asesmen" id="createModalLabel">Form Persetujuan Implementasi Evaluasi Keperawatan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="createForm" method="POST"
                                            action="{{ route('hemodialisa.pelayanan.persetujuan.implementasi-evaluasi-keperawatan.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                                            @csrf

                                            <div class="form-group">
                                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                                <div class="datetime-group">
                                                    <div class="datetime-item">
                                                        <label>Tanggal</label>
                                                        <input type="date" class="form-control" name="tanggal_implementasi" id="create_tanggal_implementasi">
                                                    </div>
                                                    <div class="datetime-item">
                                                        <label>Jam</label>
                                                        <input type="time" class="form-control" name="jam_implementasi" id="create_jam_implementasi">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Diagnosis Keperawatan Section -->
                                            <div class="form-section">
                                                <h5 class="section-title">Diagnosis Keperawatan</h5>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="diagnosis_keperawatan" placeholder="Masukkan diagnosis keperawatan" required>
                                                </div>
                                            </div>

                                            <!-- Implementasi Keperawatan Section -->
                                            <div class="form-section">
                                                <h5 class="section-title">Implementasi Keperawatan</h5>
                                                <div class="form-group">
                                                    <textarea rows="4" name="implementasi_keperawatan" id="create_implementasi_keperawatan" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <!-- Evaluasi Keperawatan Section -->
                                            <div class="form-section">
                                                <h5 class="section-title">Evaluasi Keperawatan</h5>
                                                <div class="form-group">
                                                    <textarea rows="4" name="evaluasi_keperawatan" id="create_evaluasi_keperawatan" class="form-control mt-2"></textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" form="createForm" class="btn btn-primary" id="create_simpan">
                                            <span class="btn-text"><i class="ti-save mr-2"></i> Simpan Data</span>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title header-asesmen" id="editModalLabel">Edit Persetujuan Implementasi Evaluasi Keperawatan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editForm" method="POST" action="">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="id" id="edit_id">

                                            <div class="form-group">
                                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                                <div class="datetime-group">
                                                    <div class="datetime-item">
                                                        <label>Tanggal</label>
                                                        <input type="date" class="form-control" name="tanggal_implementasi" id="edit_tanggal_implementasi">
                                                    </div>
                                                    <div class="datetime-item">
                                                        <label>Jam</label>
                                                        <input type="time" class="form-control" name="jam_implementasi" id="edit_jam_implementasi">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Diagnosis Keperawatan Section -->
                                            <div class="form-section">
                                                <h5 class="section-title">Diagnosis Keperawatan</h5>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="diagnosis_keperawatan" id="edit_diagnosis_keperawatan" required>
                                                </div>
                                            </div>

                                            <!-- Implementasi Keperawatan Section -->
                                            <div class="form-section">
                                                <h5 class="section-title">Implementasi Keperawatan</h5>
                                                <div class="form-group">
                                                    <textarea rows="4" name="implementasi_keperawatan" id="edit_implementasi_keperawatan" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <!-- Evaluasi Keperawatan Section -->
                                            <div class="form-section">
                                                <h5 class="section-title">Evaluasi Keperawatan</h5>
                                                <div class="form-group">
                                                    <textarea rows="4" name="evaluasi_keperawatan" id="edit_evaluasi_keperawatan" class="form-control mt-2"></textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" form="editForm" class="btn btn-primary" id="edit_simpan">
                                            <span class="btn-text"><i class="ti-save mr-2"></i> Simpan Perubahan</span>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        </button>
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
    $(document).ready(function() {
        // Auto submit form when filter dates change
        $('input[name="dari_tanggal"], input[name="sampai_tanggal"]').on('change', function() {
            $(this).closest('form').submit();
        });

        // Set current date and time in create modal form
        var currentDate = new Date();
        var formattedDate = currentDate.toISOString().split('T')[0];
        $('#create_tanggal_implementasi').val(formattedDate);
        var formattedTime = currentDate.toTimeString().split(' ')[0].substring(0, 5);
        $('#create_jam_implementasi').val(formattedTime);

        // Handle create form submission via AJAX
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            var $button = $('#create_simpan');
            $button.addClass('btn-loading').prop('disabled', true);
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $('#createModal').modal('hide');
                    location.reload(); // Refresh page to update table
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menyimpan data: ' + (xhr.responseJSON?.message || 'Silakan coba lagi.'));
                },
                complete: function() {
                    $button.removeClass('btn-loading').prop('disabled', false);
                }
            });
        });

        // Handle edit button click to populate edit modal
        $('.edit-btn').on('click', function() {
            var editUrl = $(this).data('url');
            var id = $(this).data('id');

            // Fetch data for the selected item
            $.ajax({
                url: editUrl,
                method: 'GET',
                success: function(data) {
                    $('#edit_id').val(id);
                    $('#editForm').attr('action', editUrl.replace('/edit', '')); // Set form action to update route
                    $('#edit_tanggal_implementasi').val(data.tanggal_implementasi);
                    $('#edit_jam_implementasi').val(data.jam_implementasi);
                    $('#edit_diagnosis_keperawatan').val(data.diagnosis_keperawatan);
                    $('#edit_implementasi_keperawatan').val(data.implementasi_keperawatan);
                    $('#edit_evaluasi_keperawatan').val(data.evaluasi_keperawatan);
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat mengambil data: ' + (xhr.responseJSON?.message || 'Silakan coba lagi.'));
                }
            });
        });

        // Handle edit form submission via AJAX
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            var $button = $('#edit_simpan');
            $button.addClass('btn-loading').prop('disabled', true);
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize() + '&_method=PUT',
                success: function(response) {
                    $('#editModal').modal('hide');
                    location.reload(); // Refresh page to update table
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat memperbarui data: ' + (xhr.responseJSON?.message || 'Silakan coba lagi.'));
                },
                complete: function() {
                    $button.removeClass('btn-loading').prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush