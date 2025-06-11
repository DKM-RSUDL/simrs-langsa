@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        /* Tab styling */
        /* Monitoring list styling - simplified for dense lists */
        #monitoringInList .list-group-item {
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            padding: 0.75rem;
            border: 1px solid #d2d2d2;
            transition: background-color 0.2s;
        }

        #monitoringInList .list-group-item:hover {
            background-color: #f9f9f9;
        }

        #monitoringInList .list-group-item:nth-child(even) {
            background-color: #fafafa;
        }

        /* Action icons */
        .btn-icon {
            width: 2.2rem;
            height: 2.2rem;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color 0.2s;
        }

        .btn-icon i {
            font-size: 0.875rem;
        }

        .btn-icon-info {
            color: #fff;
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-icon-warning {
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-icon-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Add button styling */
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.75rem;
            font-size: 0.875rem;
            font-weight: normal;
            border-radius: 0.375rem;
        }

        .btn-add i {
            font-size: 0.875rem;
        }

        /* Compact vital signs */
        .vital-statsss {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 0.5rem;
            font-size: 0.8125rem;
        }

        .vital-itemmmm {
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
        }

        /* Utility classes */
        .record-title {
            font-size: 0.9375rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: #333;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .time-badge {
            color: #0d6efd;
            font-weight: 600;
            background-color: rgba(13, 110, 253, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
            margin-left: 8px;
            display: inline-flex;
            align-items: center;
        }

        .time-badge i {
            margin-right: 4px;
            font-size: 0.8rem;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
        }

        .bg-purple {
            background-color: #6f42c1;
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
                    <div class="card-body p-4">
                        {{-- Dynamic Title Based on kd_unit --}}
                        @php
                            $unitTitles = [
                                '10015' => 'Monitoring ICCU',
                                '10016' => 'Monitoring ICU',
                                '10131' => 'Monitoring NICU',
                                '10132' => 'Monitoring PICU',
                            ];
                            $title = isset($unitTitles[$dataMedis->kd_unit])
                                ? $unitTitles[$dataMedis->kd_unit]
                                : 'Monitoring Intensive Care';
                        @endphp

                        {{-- Tabs --}}
                        <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="monitoring-tab" data-bs-toggle="tab"
                                    data-bs-target="#monitoring" type="button" role="tab" aria-controls="monitoring"
                                    aria-selected="true">{{ $title }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="therapy-tab" data-bs-toggle="tab" data-bs-target="#therapy"
                                    type="button" role="tab" aria-controls="therapy" aria-selected="false">Therapy Obat
                                    {{ $title }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="hasilmonit-tab" data-bs-toggle="tab"
                                    data-bs-target="#hasilmonit" type="button" role="tab" aria-controls="hasilmonit"
                                    aria-selected="false">Hasil {{ $title }}</button>
                            </li>

                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="monitoring" role="tabpanel"
                                aria-labelledby="monitoring-tab">
                                <div>
                                    <div class="d-flex justify-content-end align-items-center mb-3">
                                        <a href="{{ route('rawat-inap.monitoring.create', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk, 'urut_masuk' => $urut_masuk]) }}"
                                            class="btn btn-primary btn-add">
                                            <i class="fas fa-plus"></i> Tambah Monitoring
                                        </a>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover" id="monitoringInList">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th scope="col" class="text-center">Tanggal</th>
                                                    <th scope="col" class="text-center">Jam</th>
                                                    <th scope="col" class="text-center">Pembuat</th>
                                                    <th scope="col" class="text-center">Vital Signs</th>
                                                    <th scope="col" class="text-center">Hari Rawat Ke</th>
                                                    <th scope="col" class="text-center" style="width: 150px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($monitoringRecords as $record)
                                                    <tr>
                                                        <td class="text-center">{{ Carbon\Carbon::parse($record->tgl_implementasi)->format('d M Y') }}</td>
                                                        <td class="text-center">
                                                            <span class="time-badge">
                                                                <i class="far fa-clock"></i>
                                                                {{ Carbon\Carbon::parse($record->jam_implementasi)->format('H:i') }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $record->userCreator->name ?? 'Unknown' }}</td>
                                                        <td>
                                                            <div class="vital-statsss">
                                                                <span class="vital-itemmm">TD: <strong>{{ number_format($record->detail->sistolik ?? 0, 0) }}/{{ number_format($record->detail->diastolik ?? 0, 0) }}</strong></span>
                                                                <span class="vital-itemmm">HR: <strong>{{ number_format($record->detail->hr ?? 0, 0) }}</strong></span>
                                                                <span class="vital-itemmm">RR: <strong>{{ number_format($record->detail->rr ?? 0, 0) }}</strong></span>
                                                                <span class="vital-itemmm">Suhu: <strong>{{ number_format($record->detail->temp ?? 0, 1) }}°C</strong></span>
                                                                <span class="vital-itemmm">MAP: <strong>{{ number_format($record->detail->map ?? 0, 0) }}</strong></span>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-purple">{{ $record->hari_rawat }}</span>
                                                        <td class="text-center">
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                <a href="{{ route('rawat-inap.monitoring.show', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk, 'urut_masuk' => $urut_masuk, 'id' => $record->id]) }}"
                                                                   class="btn btn-icon btn-icon-info" title="Lihat Detail">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('rawat-inap.monitoring.edit', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk, 'urut_masuk' => $urut_masuk, 'id' => $record->id]) }}"
                                                                   class="btn btn-icon btn-icon-warning" title="Edit Data">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <button type="button"
                                                                            class="btn btn-icon btn-icon-danger delete-btn"
                                                                            data-id="{{ $record->id }}" title="Hapus Data">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center empty-state">
                                                            <i class="fas fa-clipboard-list fa-2x mb-3 text-muted"></i>
                                                            <h6>Belum ada data monitoring</h6>
                                                            <p class="text-muted small">Silahkan tambahkan data monitoring baru</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="hasilmonit" role="tabpanel" aria-labelledby="hasilmonit-tab">
                                <div class="empty-state">
                                    @include('unit-pelayanan.rawat-inap.pelayanan.monitoring.hasil-monitoring')
                                </div>
                            </div>

                            <div class="tab-pane fade" id="therapy" role="tabpanel" aria-labelledby="therapy-tab">
                                @include('unit-pelayanan.rawat-inap.pelayanan.monitoring.therapy-obat')
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
            // SweetAlert delete confirmation
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();

                var recordId = $(this).data('id');
                var deleteUrl =
                    "{{ route('rawat-inap.monitoring.destroy', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk, 'urut_masuk' => $urut_masuk, 'id' => ':id']) }}";
                deleteUrl = deleteUrl.replace(':id', recordId);

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus data monitoring ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Memproses...',
                            html: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Create form and submit
                        var form = $('<form></form>').attr({
                            method: 'POST',
                            action: deleteUrl
                        }).css('display', 'none');

                        // Add CSRF token
                        form.append($('<input>').attr({
                            type: 'hidden',
                            name: '_token',
                            value: '{{ csrf_token() }}'
                        }));

                        // Add method spoofing
                        form.append($('<input>').attr({
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        }));

                        // Append to body, submit, then remove
                        $('body').append(form);
                        form.submit();
                    }
                });
            });

            // Store the active tab in localStorage when a tab is clicked
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('id'));
            });

            // On page load, retrieve the active tab from localStorage and activate it
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('#' + activeTab).tab('show');
            }
        });
    </script>
@endpush