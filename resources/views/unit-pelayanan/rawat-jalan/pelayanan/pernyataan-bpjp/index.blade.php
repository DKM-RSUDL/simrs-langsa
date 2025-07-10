@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .modal-dialog {
            max-width: 650px;
        }

        /* Style for the detail modal */
        .detail-table th {
            width: 30%;
            background-color: #f8f9fa;
        }

        .select2-container {
            z-index: 9999;
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
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        {{-- Tabs --}}
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="?tab=order" class="nav-link active" aria-selected="true">
                                    Pernyataan BPJP
                                </a>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active">
                                {{-- TAB 1. buatlah list disini --}}
                                <div class="row">
                                    <div class="d-flex justify-content-between m-3">
                                        <div class="row">
                                            <!-- Start Date -->
                                            <div class="col-md-2">
                                                <input type="date" name="start_date" id="start_date" class="form-control"
                                                    placeholder="Dari Tanggal">
                                            </div>

                                            <!-- End Date -->
                                            <div class="col-md-2">
                                                <input type="date" name="end_date" id="end_date" class="form-control"
                                                    placeholder="S.d Tanggal">
                                            </div>
                                            <div class="col-md-2">
                                                <a href="#" class="btn btn-secondary rounded-3" id="filterButton"><i
                                                        class="bi bi-funnel-fill"></i></a>
                                            </div>

                                            <!-- Search Bar -->
                                            <div class="col-md-4">
                                                <form method="GET" action="#">
                                                    <div class="input-group">
                                                        <input type="text" name="search" class="form-control"
                                                            placeholder="Cari nama dokter" aria-label="Cari"
                                                            value="{{ request('search') }}" aria-describedby="basic-addon1">
                                                        <button type="submit" class="btn btn-primary">Cari</button>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#pernyataanDPJPModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Diagnosis</th>
                                                    <th>Tanggal</th>
                                                    <th>Dokter</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($pernyataanDPJP as $index => $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->diagnosis }}</td>
                                                        <td>{{ date('d-m-Y', strtotime($item->tanggal)) }}</td>
                                                        <td>
                                                            @php
                                                                $dokterData = $dokter
                                                                    ->where('kd_dokter', $item->kd_dokter)
                                                                    ->first();
                                                                $namaDokter = $dokterData
                                                                    ? $dokterData->nama
                                                                    : 'Tidak ada data';
                                                            @endphp
                                                            {{ $namaDokter }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ url('unit-pelayanan/rawat-jalan/unit/' . $dataMedis->kd_unit . '/pelayanan/' . $dataMedis->kd_pasien . '/' . date('Y-m-d', strtotime($dataMedis->tgl_masuk)) . '/' . $dataMedis->urut_masuk . '/pernyataan-dpjp/' . $item->id . '/print-pdf') }}"
                                                                    class="btn btn-secondary btn-sm" target="_blank"
                                                                    title="Cetak PDF">
                                                                    <i class="ti-printer"></i>
                                                                </a>

                                                                <button type="button" class="btn btn-info btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#showPernyataanDPJPModal"
                                                                    data-id="{{ $item->id }}"
                                                                    data-diagnosis="{{ $item->diagnosis }}"
                                                                    data-tanggal="{{ date('d-m-Y', strtotime($item->tanggal)) }}"
                                                                    data-bidang="{{ $item->bidang_kewenangan_klinis }}"
                                                                    data-smf="{{ $item->smf }}"
                                                                    data-kd-dokter="{{ $item->kd_dokter }}"
                                                                    data-nama-dokter="{{ $namaDokter }}"
                                                                    data-status="{{ $item->status }}"
                                                                    data-createdby="{{ $item->creator->name ?? 'Sistem' }}"
                                                                    @if ($item->user_edit) data-updated="{{ date('d-m-Y H:i', strtotime($item->updated_at)) }}"
                                                                data-updatedby="{{ $item->editor->name ?? 'Sistem' }}" @endif
                                                                    title="Detail">
                                                                    <i class="ti-eye"></i>
                                                                </button>

                                                                <button type="button" class="btn btn-warning btn-sm ms-2"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#pernyataanDPJPModal"
                                                                    data-id="{{ $item->id }}"
                                                                    data-diagnosis="{{ $item->diagnosis }}"
                                                                    data-kd-dokter="{{ $item->kd_dokter }}"
                                                                    data-mode="edit" title="Edit">
                                                                    <i class="ti-pencil"></i>
                                                                </button>

                                                                <form
                                                                    action="{{ url('unit-pelayanan/rawat-jalan/unit/' . $dataMedis->kd_unit . '/pelayanan/' . $dataMedis->kd_pasien . '/' . date('Y-m-d', strtotime($dataMedis->tgl_masuk)) . '/' . $dataMedis->urut_masuk . '/pernyataan-dpjp/' . $item->id) }}"
                                                                    method="POST" class="delete-form"
                                                                    style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm ms-2" title="Hapus">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">Tidak ada data Pernyataan
                                                            BPJP</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                        <!-- Pagination -->
                                        <div class="d-flex justify-content-end">
                                            {{ $pernyataanDPJP->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pernyataan BPJP (Create/Edit) -->
    <div class="modal fade" id="pernyataanDPJPModal" tabindex="-1" aria-labelledby="pernyataanDPJPModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pernyataanDPJPModalLabel">Tambah Pernyataan DPJP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Form yang sudah diperbaiki sesuai dengan struktur URI -->
                <form id="pernyataanDPJPForm" method="POST"
                    action="{{ url('unit-pelayanan/rawat-jalan/unit/' . $dataMedis->kd_unit . '/pelayanan/' . $dataMedis->kd_pasien . '/' . date('Y-m-d', strtotime($dataMedis->tgl_masuk)) . '/' . $dataMedis->urut_masuk . '/pernyataan-dpjp') }}">
                    @csrf
                    <div class="modal-body">
                        <div id="methodField"></div>

                        <!-- Hidden inputs -->
                        <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien }}">
                        <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit }}">
                        <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk }}">
                        <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk }}">
                        <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="bidang_kewenangan_klinis"
                            value="{{ auth()->user()->bidang_kewenangan_klinis ?? '' }}">
                        <input type="hidden" name="smf" value="{{ auth()->user()->smf ?? '' }}">

                        <!-- Only visible field -->
                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Diagnosis <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="diagnosis" name="diagnosis" rows="3" required></textarea>
                            @error('diagnosis')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kd_dokter" class="form-label">Dokter <span class="text-danger">*</span></label>
                            <select name="kd_dokter" id="kd_dokter" class="form-select select2" required>
                                <option value="">--Pilih Dokter--</option>
                                @foreach ($dokter as $dok)
                                    <option value="{{ $dok->kd_dokter }}">{{ $dok->nama }}</option>
                                @endforeach
                            </select>
                            @error('kd_dokter')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-light bg-light" role="alert">
                            <p class="fw-bold">POIN PERNYATAAN</p>

                            <ol>
                                <li class="fw-semibold">Melaksanakan asuhan pasien diatas dengan penuh tanggungjawab;</li>
                                <li class="fw-semibold">Bila diperlukan, melakukan konsultasi dengan bidang / kompetensi
                                    lain;</li>
                                <li class="fw-semibold">Melaksanakan pembuatan rekam medis dengan lengkap dan benar serta
                                    menyerahkannya sesuai
                                    aturan yang berlaku.</li>
                            </ol>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pernyataan BPJP (Show) -->
    <div class="modal fade" id="showPernyataanDPJPModal" tabindex="-1" aria-labelledby="showPernyataanDPJPModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showPernyataanDPJPModalLabel">Detail Pernyataan DPJP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered detail-table">
                        <tbody>
                            <tr>
                                <th>Tanggal</th>
                                <td id="show-tanggal"></td>
                            </tr>
                            <tr>
                                <th>Diagnosis</th>
                                <td id="show-diagnosis"></td>
                            </tr>
                            <tr>
                                <th>Dokter</th>
                                <td id="show-dokter"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <div id="detail-action-buttons">
                        <!-- Action buttons will be added here dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            initSelect2();
        });

        // Reinisialisasi Select2 ketika modal dibuka
        $('#pernyataanDPJPModal').on('shown.bs.modal', function() {
            // Destroy existing Select2 instance before reinitializing
            initSelect2();
        });

        function initSelect2() {
            $('#pernyataanDPJPModal .select2').select2({
                dropdownParent: $('#pernyataanDPJPModal'),
                width: '100%'
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Attach SweetAlert to all delete forms
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data pernyataan BPJP ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Handle edit modal dengan field dokter
            const pernyataanDPJPModal = document.getElementById('pernyataanDPJPModal');
            if (pernyataanDPJPModal) {
                pernyataanDPJPModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const mode = button.getAttribute('data-mode');
                    const form = document.getElementById('pernyataanDPJPForm');
                    const modalTitle = this.querySelector('.modal-title');
                    const methodFieldDiv = document.getElementById('methodField');

                    // Reset form
                    form.reset();
                    methodFieldDiv.innerHTML = '';

                    if (mode === 'edit') {
                        const id = button.getAttribute('data-id');
                        const diagnosis = button.getAttribute('data-diagnosis');
                        const dokter = button.getAttribute('data-kd-dokter');

                        modalTitle.textContent = 'Edit Pernyataan BPJP';

                        // URL untuk edit
                        form.action = "{{ url('unit-pelayanan/rawat-jalan/unit') }}/" +
                            "{{ $dataMedis->kd_unit }}" +
                            "/pelayanan/" +
                            "{{ $dataMedis->kd_pasien }}" +
                            "/{{ date('Y-m-d', strtotime($dataMedis->tgl_masuk)) }}" +
                            "/{{ $dataMedis->urut_masuk }}" +
                            "/pernyataan-dpjp/" +
                            id;

                        // Add method PUT
                        methodFieldDiv.innerHTML = '@method('PUT')';

                        // Fill the form
                        document.getElementById('diagnosis').value = diagnosis;

                        // Mengatur nilai dokter jika ada
                        if (dokter) {
                            const dokterSelect = document.getElementById('kd_dokter');
                            if (dokterSelect) {
                                for (let i = 0; i < dokterSelect.options.length; i++) {
                                    if (dokterSelect.options[i].value === dokter) {
                                        dokterSelect.options[i].selected = true;
                                        break;
                                    }
                                }
                            }
                        }
                    } else {
                        modalTitle.textContent = 'Tambah Pernyataan DPJP';

                        // URL untuk store
                        form.action = "{{ url('unit-pelayanan/rawat-jalan/unit') }}/" +
                            "{{ $dataMedis->kd_unit }}" +
                            "/pelayanan/" +
                            "{{ $dataMedis->kd_pasien }}" +
                            "/{{ date('Y-m-d', strtotime($dataMedis->tgl_masuk)) }}" +
                            "/{{ $dataMedis->urut_masuk }}" +
                            "/pernyataan-dpjp";
                    }
                });
            }

            // Handle show/detail modal dengan dokter
            const showPernyataanDPJPModal = document.getElementById('showPernyataanDPJPModal');
            if (showPernyataanDPJPModal) {
                showPernyataanDPJPModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const diagnosis = button.getAttribute('data-diagnosis');
                    const tanggal = button.getAttribute('data-tanggal');
                    const namaDokter = button.getAttribute('data-nama-dokter') || 'Tidak ada data';

                    // Fill in the data
                    document.getElementById('show-tanggal').textContent = tanggal;
                    document.getElementById('show-diagnosis').textContent = diagnosis;
                    document.getElementById('show-dokter').textContent = namaDokter;

                    // Set status with badge
                    const statusBadge = status == 0 ?
                        '<span class="badge bg-warning">Draft</span>' :
                        '<span class="badge bg-success">Final</span>';
                    document.getElementById('show-status').innerHTML = statusBadge;

                    document.getElementById('show-created').textContent = created;

                    // Handle updated info if available
                    const updatedRow = document.getElementById('updated-row');
                    if (button.hasAttribute('data-updated') && button.hasAttribute('data-updatedby')) {
                        const updated = button.getAttribute('data-updatedby') + ' (' + button.getAttribute(
                            'data-updated') + ')';
                        document.getElementById('show-updated').textContent = updated;
                        updatedRow.style.display = '';
                    } else {
                        updatedRow.style.display = 'none';
                    }

                    // Set action buttons in modal footer
                    const actionButtonsContainer = document.getElementById('detail-action-buttons');
                    actionButtonsContainer.innerHTML = '';

                    // Only show edit and delete buttons if status is 0 (draft)
                    if (status == 0) {
                        // Edit button
                        const editButton = document.createElement('button');
                        editButton.type = 'button';
                        editButton.className = 'btn btn-warning me-2';
                        editButton.innerHTML = '<i class="ti-pencil"></i> Edit';
                        editButton.addEventListener('click', function() {
                            // Close this modal
                            const showModal = bootstrap.Modal.getInstance(showPernyataanDPJPModal);
                            showModal.hide();

                            // Open edit modal and populate it
                            const editButton = document.querySelector(
                                `button[data-id="${id}"][data-mode="edit"]`);
                            if (editButton) {
                                setTimeout(() => {
                                    editButton.click();
                                }, 500);
                            }
                        });

                        // Delete button
                        const deleteButton = document.createElement('button');
                        deleteButton.type = 'button';
                        deleteButton.className = 'btn btn-danger';
                        deleteButton.innerHTML = '<i class="ti-trash"></i> Hapus';
                        deleteButton.addEventListener('click', function() {
                            Swal.fire({
                                title: 'Apakah Anda yakin?',
                                text: 'Data pernyataan BPJP ini akan dihapus secara permanen!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Create and submit a form programmatically
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action =
                                        "{{ url('unit-pelayanan/rawat-jalan/unit') }}/" +
                                        "{{ $dataMedis->kd_unit }}" +
                                        "/pelayanan/" +
                                        "{{ $dataMedis->kd_pasien }}" +
                                        "/{{ date('Y-m-d', strtotime($dataMedis->tgl_masuk)) }}" +
                                        "/{{ $dataMedis->urut_masuk }}" +
                                        "/pernyataan-dpjp/" +
                                        id;

                                    const csrfToken = document.createElement('input');
                                    csrfToken.type = 'hidden';
                                    csrfToken.name = '_token';
                                    csrfToken.value = '{{ csrf_token() }}';

                                    const methodField = document.createElement('input');
                                    methodField.type = 'hidden';
                                    methodField.name = '_method';
                                    methodField.value = 'DELETE';

                                    form.appendChild(csrfToken);
                                    form.appendChild(methodField);
                                    document.body.appendChild(form);
                                    form.submit();
                                }
                            });
                        });

                        actionButtonsContainer.appendChild(editButton);
                        actionButtonsContainer.appendChild(deleteButton);
                    }
                });
            }
        });
    </script>
@endpush
