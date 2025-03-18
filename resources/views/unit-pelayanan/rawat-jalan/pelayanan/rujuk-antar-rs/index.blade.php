@extends('layouts.administrator.master')

@section('content')
        @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
        @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center m-3">
                <div class="row">
                    <!-- Filter by Service Type -->
                    <div class="col-md-2">
                        <select class="form-select" id="SelectServiceRawatJalan" aria-label="Pilih...">
                            <option value="semua" selected>Semua Pelayanan</option>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" name="start_date" id="startDateRawatJalan" class="form-control" placeholder="Dari Tanggal">
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="end_date" id="endDateRawatJalan" class="form-control" placeholder="S.d Tanggal">
                            </div>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" id="searchInputRawatJalan" class="form-control" placeholder="Cari..." aria-label="Cari">
                            <button type="button" class="btn btn-primary" id="searchBtnRawatJalan">Cari</button>
                        </div>
                    </div>

                    <!-- Add Button -->
                    <div class="col-md-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRujukAntarRsRawatJalan" type="button">
                            <i class="ti-plus"></i> Tambah
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="rujukanTableRawatJalan">
                    <thead class="table-primary">
                        <tr>
                            <th>Tanggal & Jam</th>
                            <th>Transportasi</th>
                            <th>Pendamping</th>
                            <th>Alasan Masuk/Dirujuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rujukan ?? [] as $r)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}
                                    {{ $r->jam ? \Carbon\Carbon::parse($r->jam)->format('H:i') : '-' }}
                                </td>
                                <td>
                                    @if($r->transportasi == 'ambulans')
                                        Ambulans RS
                                    @else
                                        {{ $r->detail_kendaraan }}
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ $r->nomor_polisi }}</small>
                                </td>
                                <td>
                                    @if($r->pendamping_dokter)
                                        <span class="badge bg-info">Dokter</span>
                                    @endif
                                    @if($r->pendamping_perawat)
                                        <span class="badge bg-info">Perawat</span>
                                    @endif
                                    @if($r->pendamping_keluarga)
                                        <span class="badge bg-info">Keluarga</span>
                                    @endif
                                    @if($r->pendamping_tidak_ada)
                                        <span class="badge bg-warning">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>
                                    {{ Str::limit($r->alasan_masuk_dirujuk, 50) }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info show-btn-rawat-jalan" data-id="{{ $r->id }}" data-bs-toggle="modal" data-bs-target="#showRujukAntarRsRawatJalan" title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning edit-btn-rawat-jalan" data-id="{{ $r->id }}" data-bs-toggle="modal" data-bs-target="#editRujukAntarRsRawatJalan" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form action="/unit-pelayanan/rawat-jalan/unit/{{ $dataMedis->kd_unit }}/pelayanan/{{ $dataMedis->kd_pasien }}/{{ $dataMedis->tgl_masuk }}/{{ $dataMedis->urut_masuk }}/rujuk-antar-rs/{{ $r->id }}" method="POST" class="d-inline delete-form-rawat-jalan">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn-rawat-jalan" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data rujukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Include the modals for create, edit and show --}}
    @include('unit-pelayanan.rawat-jalan.pelayanan.rujuk-antar-rs.create-modal', ['modalId' => 'createRujukAntarRsRawatJalan'])
    @include('unit-pelayanan.rawat-jalan.pelayanan.rujuk-antar-rs.edit-modal', ['modalId' => 'editRujukAntarRsRawatJalan'])
    @include('unit-pelayanan.rawat-jalan.pelayanan.rujuk-antar-rs.show-modal', ['modalId' => 'showRujukAntarRsRawatJalan'])
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable untuk Rawat Jalan
            if ($('#rujukanTableRawatJalan tbody tr').length > 0 && !$('#rujukanTableRawatJalan tbody tr:first td:first').text().includes('Belum ada data rujukan')) {
                $('#rujukanTableRawatJalan').DataTable({
                    "ordering": false,
                    "searching": true,
                    "paging": true,
                    "info": true,
                    "pageLength": 10,
                    "serverSide": false,
                    "language": {
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ data",
                        "zeroRecords": "Tidak ada data yang ditemukan",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "infoEmpty": "Tidak ada data tersedia",
                        "infoFiltered": "(difilter dari _MAX_ total data)",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        }
                    }
                });
            }

            // Konfirmasi hapus dengan SweetAlert untuk Rawat Jalan
            $(document).on('click', '.delete-btn-rawat-jalan', function () {
                const form = $(this).closest('form');
                const tanggal = form.closest('tr').find('td:first-child').text().trim();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus data rujukan yang dihapus tidak dapat dikembalikan!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: 'Terhapus!',
                            text: 'Data rujukan telah berhasil dihapus.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // Handle show button click untuk Rawat Jalan
            $(document).on('click', '.show-btn-rawat-jalan', function () {
                const id = $(this).data('id');
                const modal = $('#showRujukAntarRsRawatJalan');
                const kd_unit = '{{ $dataMedis->kd_unit ?? "" }}';
                const kd_pasien = '{{ $dataMedis->kd_pasien ?? "" }}';
                const tgl_masuk = '{{ $dataMedis->tgl_masuk ?? date('Y-m-d') }}';
                const urut_masuk = '{{ $dataMedis->urut_masuk ?? "" }}';

                window.currentShowIdRawatJalan = id;

                modal.find('.modal-body').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');

                const ajaxUrl = `/unit-pelayanan/rawat-jalan/unit/${kd_unit}/pelayanan/${kd_pasien}/${tgl_masuk}/${urut_masuk}/rujuk-antar-rs/${id}`;
                console.log('Calling Ajax with URL (Rawat Jalan):', ajaxUrl);

                $.ajax({
                    url: ajaxUrl,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        console.log("Show data received (Rawat Jalan):", response);
                        let html = formatDetailViewRawatJalan(response);
                        modal.find('.modal-body').html(html);
                    },
                    error: function (xhr) {
                        console.error("Error loading show data (Rawat Jalan):", xhr);
                        modal.find('.modal-body').html(`<div class="alert alert-danger">Error loading data: ${xhr.status} - ${xhr.statusText}</div>`);
                    }
                });
            });

            // Filter functionality untuk Rawat Jalan
            $('#searchBtnRawatJalan').click(function () {
                const searchTerm = $('#searchInputRawatJalan').val().toLowerCase();

                $('#rujukanTableRawatJalan tbody tr').each(function () {
                    const text = $(this).text().toLowerCase();
                    if (text.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Fungsi format waktu
            function formatTime(timeString) {
                if (!timeString) return '-';
                return timeString.substring(0, 5); // Format HH:MM
            }

            // Helper function to format detail view untuk Rawat Jalan
            function formatDetailViewRawatJalan(data) {
                const formatDate = (dateString) => {
                    if (!dateString) return '-';
                    const options = { year: 'numeric', month: 'long', day: 'numeric' };
                    return new Date(dateString).toLocaleDateString('id-ID', options);
                };

                let transportasi = data.transportasi === 'ambulans' ? 'Ambulans RS' : data.detail_kendaraan;
                let pendamping = [];
                if (data.pendamping_dokter == 1) pendamping.push('Dokter');
                if (data.pendamping_perawat == 1) pendamping.push('Perawat');
                if (data.pendamping_keluarga == 1) pendamping.push(`Keluarga: ${data.detail_keluarga}`);
                if (data.pendamping_tidak_ada == 1) pendamping.push('Tidak Ada');

                let alasan = [];
                if (data.alasan_tempat_penuh == 1) alasan.push('Tempat penuh');
                if (data.alasan_permintaan_keluarga == 1) alasan.push('Permintaan keluarga');
                if (data.alasan_perawatan_khusus == 1) alasan.push('Perawatan khusus');
                if (data.alasan_lainnya == 1) alasan.push(`Lainnya: ${data.detail_alasan_lainnya}`);

                let alergiHtml = '';
                if (data.alergi) {
                    try {
                        const alergiData = JSON.parse(data.alergi);
                        if (alergiData.length > 0) {
                            alergiHtml = '<ul>';
                            alergiData.forEach(function (item) {
                                alergiHtml += `<li><strong>${item.name}</strong>: ${item.reaction}</li>`;
                            });
                            alergiHtml += '</ul>';
                        } else {
                            alergiHtml = '<p>Tidak ada alergi</p>';
                        }
                    } catch (e) {
                        alergiHtml = '<p>Data alergi tidak tersedia</p>';
                    }
                } else {
                    alergiHtml = '<p>Tidak ada alergi</p>';
                }

                let diagnosisHtml = '';
                if (data.diagnosis) {
                    try {
                        const diagnosisData = JSON.parse(data.diagnosis);
                        if (diagnosisData.length > 0) {
                            diagnosisHtml = '<ul>';
                            diagnosisData.forEach(function (item) {
                                diagnosisHtml += `<li><strong>${item.code}</strong>: ${item.name}</li>`;
                            });
                            diagnosisHtml += '</ul>';
                        } else {
                            diagnosisHtml = '<p>Tidak ada diagnosis</p>';
                        }
                    } catch (e) {
                        diagnosisHtml = '<p>Data diagnosis tidak tersedia</p>';
                    }
                } else {
                    diagnosisHtml = '<p>Tidak ada diagnosis</p>';
                }

                return `
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Tanggal:</strong> ${formatDate(data.tanggal)}
                            </div>
                            <div class="col-md-6">
                                <strong>Jam:</strong> ${formatTime(data.jam) || '-'}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Transportasi:</strong> ${transportasi || '-'}
                            </div>
                            <div class="col-md-6">
                                <strong>Nomor Polisi:</strong> ${data.nomor_polisi || '-'}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Pendamping:</strong> ${pendamping.length ? pendamping.join(', ') : '-'}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Tanda Vital:</strong>
                                <ul>
                                    <li>Suhu: ${data.suhu || '-'}</li>
                                    <li>Tekanan Darah: ${data.sistole || '-'}/${data.diastole || '-'}</li>
                                    <li>Nadi: ${data.nadi || '-'}</li>
                                    <li>Respirasi: ${data.respirasi || '-'}</li>
                                    <li>Status Nyeri: ${data.status_nyeri || '-'}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Alasan Pindah RS:</strong> ${alasan.length ? alasan.join(', ') : '-'}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Alergi:</strong>
                                ${alergiHtml}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Alasan Masuk/Dirujuk:</strong>
                                <p>${data.alasan_masuk_dirujuk || '-'}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Hasil Pemeriksaan Penunjang:</strong>
                                <p>${data.hasil_pemeriksaan_penunjang || '-'}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Terapi/Pengobatan:</strong>
                                <p>${data.terapi || '-'}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Diagnosis:</strong>
                                ${diagnosisHtml}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Tindakan/Prosedur:</strong>
                                <p>${data.tindakan || '-'}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <strong>Edukasi Pasien/Keluarga:</strong>
                                <p>${data.edukasi_pasien || '-'}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        });
    </script>
@endpush
