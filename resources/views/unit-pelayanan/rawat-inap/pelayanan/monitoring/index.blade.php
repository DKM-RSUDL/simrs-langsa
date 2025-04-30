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
        .vital-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 0.5rem;
            font-size: 0.8125rem;
        }

        .vital-item {
            background-color: #f8f9fa;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
        }

        /* Search input styling */
        .filter-input {
            border-radius: 0.375rem;
            padding: 0.5rem 1rem;
            border: 1px solid #ced4da;
        }

        /* Filter section improved */
        .filters-container {
            display: flex;
            gap: 0.75rem;
        }

        .filter-group {
            flex: 1;
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
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="filters-container">
                                            <div class="filter-group">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fas fa-search text-muted"></i>
                                                    </span>
                                                    <input type="text" class="form-control border-start-0 filter-input"
                                                        id="searchInput" placeholder="Cari History monitoring...">
                                                </div>
                                            </div>
                                            <div class="filter-group">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-end-0">
                                                        <i class="fas fa-calendar text-muted"></i>
                                                    </span>
                                                    <input type="date" class="form-control border-start-0 filter-input"
                                                        id="dateFilter" placeholder="Filter berdasarkan tanggal">
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('rawat-inap.monitoring.create', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk, 'urut_masuk' => $urut_masuk]) }}"
                                            class="btn btn-primary btn-add">
                                            <i class="fas fa-plus"></i> Tambah Monitoring
                                        </a>
                                    </div>

                                    {{-- data --}}
                                    <div class="list-group" id="monitoringInList">
                                        @if ($monitoringRecords->count() > 0)
                                            @foreach ($monitoringRecords as $record)
                                                <div class="list-group-item">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h5 class="record-title">
                                                                {{ Carbon\Carbon::parse($record->tgl_implementasi)->format('d M Y') }}
                                                                <span class="time-badge">
                                                                    <i
                                                                        class="far fa-clock"></i>{{ Carbon\Carbon::parse($record->jam_implementasi)->format('H:i') }}
                                                                </span>
                                                            </h5>
                                                            <div class="d-flex gap-2 record-meta">
                                                                <span><i class="fas fa-user-md me-1"></i>
                                                                    {{ $record->userCreator->name ?? 'Unknown' }}</span>
                                                                <span class="ms-2"><i class="fas fa-stethoscope me-1"></i>
                                                                    {{ $record->diagnosa }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-2">
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
                                                    </div>

                                                    <div class="vital-stats">
                                                        <span class="vital-item">TD:
                                                            <strong>{{ number_format($record->detail->sistolik ?? 0, 0) }}/{{ number_format($record->detail->diastolik ?? 0, 0) }}</strong></span>
                                                        <span class="vital-item">HR:
                                                            <strong>{{ number_format($record->detail->hr ?? 0, 0) }}</strong></span>
                                                        <span class="vital-item">RR:
                                                            <strong>{{ number_format($record->detail->rr ?? 0, 0) }}</strong></span>
                                                        <span class="vital-item">Suhu:
                                                            <strong>{{ number_format($record->detail->temp ?? 0, 1) }}°C</strong></span>
                                                        <span class="vital-item">MAP:
                                                            <strong>{{ number_format($record->detail->map ?? 0, 0) }}</strong></span>
                                                        <span class="vital-item">GCS:
                                                            <strong>E{{ number_format($record->detail->gcs_eye ?? 0, 0) }}V{{ number_format($record->detail->gcs_verbal ?? 0, 0) }}M{{ number_format($record->detail->gcs_motor ?? 0, 0) }}</strong>
                                                            ({{ number_format($record->detail->gcs_total ?? 0, 0) }})
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="empty-state">
                                                <i class="fas fa-clipboard-list fa-2x mb-3 text-muted"></i>
                                                <h6>Belum ada data monitoring</h6>
                                                <p class="text-muted small">Silahkan tambahkan data monitoring baru</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="hasilmonit" role="tabpanel" aria-labelledby="hasilmonit-tab">
                                <div class="empty-state">
                                    @include('unit-pelayanan.rawat-inap.pelayanan.monitoring.hasil-monitoring')
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
            // Pencarian teks
            $("#searchInput").on("keyup", function() {
                filterRecords();
            });

            // Filter tanggal
            $("#dateFilter").on("change", function() {
                filterRecords();
            });

            // Fungsi untuk menerapkan filter teks dan tanggal secara bersamaan
            function filterRecords() {
                var searchValue = $("#searchInput").val().toLowerCase();
                var dateValue = $("#dateFilter").val(); // Format: YYYY-MM-DD

                $("#monitoringInList .list-group-item").each(function() {
                    // Filter berdasarkan teks
                    var textMatch = $(this).text().toLowerCase().indexOf(searchValue) > -1;

                    // Filter berdasarkan tanggal
                    var dateMatch = true; // Default true jika tidak ada filter tanggal
                    if (dateValue) {
                        var recordDate = $(this).data('date'); // Ambil dari data-date
                        dateMatch = recordDate === dateValue;
                    }

                    // Tampilkan hanya jika kedua kondisi terpenuhi
                    $(this).toggle(textMatch && dateMatch);
                });

                // Periksa apakah ada hasil yang ditampilkan
                checkEmptyResults();
            }

            // Fungsi untuk memformat tanggal dari string (contoh: "26 Apr 2023" -> "2023-04-26")
            function formatRecordDate(dateString) {
                var months = {
                    'Jan': '01',
                    'Feb': '02',
                    'Mar': '03',
                    'Apr': '04',
                    'May': '05',
                    'Jun': '06',
                    'Jul': '07',
                    'Aug': '08',
                    'Sep': '09',
                    'Oct': '10',
                    'Nov': '11',
                    'Dec': '12'
                };

                // Gunakan regex untuk mengekstrak komponen tanggal
                var match = dateString.match(/(\d{1,2})\s+([A-Za-z]{3})\s+(\d{4})/);
                if (match) {
                    var day = match[1].padStart(2, '0'); // Tambah leading zero jika perlu
                    var month = months[match[2]];
                    var year = match[3];
                    return `${year}-${month}-${day}`; // Format: YYYY-MM-DD
                }
                return null;
            }

            // Set atribut data-date untuk setiap item saat halaman dimuat
            $("#monitoringInList .list-group-item").each(function() {
                var recordDate = $(this).find('.record-title').text().trim();
                var formattedDate = formatRecordDate(recordDate);
                if (formattedDate) {
                    $(this).attr('data-date', formattedDate);
                }
            });

            // Fungsi untuk memeriksa apakah tidak ada hasil yang ditampilkan
            function checkEmptyResults() {
                var visibleItems = $("#monitoringInList .list-group-item:visible").length;
                var noDataMessageExists = $("#monitoringInList .empty-state").length > 0;

                if (visibleItems === 0) {
                    // Jika tidak ada hasil, tampilkan pesan kosong
                    if ($("#no-results-message").length === 0) {
                        // Hapus pesan "Belum ada data monitoring" jika ada
                        $("#monitoringInList .empty-state").remove();

                        $("#monitoringInList").append(
                            '<div id="no-results-message" class="empty-state">' +
                            '<i class="fas fa-search fa-2x mb-3 text-muted"></i>' +
                            '<h6>Tidak ada data yang sesuai dengan filter</h6>' +
                            '<p class="text-muted small">Coba ubah kriteria pencarian atau tanggal</p>' +
                            '</div>'
                        );
                    }
                } else {
                    // Jika ada hasil, hapus pesan "Tidak ada data"
                    $("#no-results-message").remove();
                    // Jika tidak ada data sama sekali dan tidak ada pesan empty-state, tambahkan kembali
                    if (noDataMessageExists && $("#monitoringInList .empty-state").length === 0) {
                        $("#monitoringInList").append(
                            '<div class="empty-state">' +
                            '<i class="fas fa-clipboard-list fa-2x mb-3 text-muted"></i>' +
                            '<h6>Belum ada data monitoring</h6>' +
                            '<p class="text-muted small">Silahkan tambahkan data monitoring baru</p>' +
                            '</div>'
                        );
                    }
                }
            }

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
        });
    </script>
@endpush
