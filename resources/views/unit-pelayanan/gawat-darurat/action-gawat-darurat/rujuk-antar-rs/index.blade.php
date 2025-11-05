@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                @include('components.page-header', [
                    'title' => 'Daftar Rujukan Gawat Darurat',
                    'description' => 'Berikut daftar rujukan keluar/antar RS.',
                ])
                <div class="row">
                    <div class="col-md-10 d-flex flex-wrap flex-md-nowrap gap-2">
                        <!-- Filter by Service Type -->
                        <div>
                            <select class="form-select" id="SelectService" aria-label="Pilih...">
                                <option value="semua" selected>Semua Pelayanan</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        placeholder="Dari Tanggal">
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        placeholder="S.d Tanggal">
                                </div>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div>
                            <div class="input-group">
                                <input type="text" name="search" id="searchInput" class="form-control"
                                    placeholder="Cari..." aria-label="Cari">
                                <button type="button" class="btn btn-primary" id="searchBtn">Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRujukAntarRs"
                            type="button">
                            <i class="ti-plus"></i> Tambah
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="rujukanTable">
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
                                        @if ($r->transportasi == 'ambulans')
                                            Ambulans RS
                                        @else
                                            {{ $r->detail_kendaraan }}
                                        @endif
                                        <br>
                                        <small class="text-muted">{{ $r->nomor_polisi }}</small>
                                    </td>
                                    <td>
                                        @if ($r->pendamping_dokter)
                                            <span class="badge bg-info">Dokter</span>
                                        @endif
                                        @if ($r->pendamping_perawat)
                                            <span class="badge bg-info">Perawat</span>
                                        @endif
                                        @if ($r->pendamping_keluarga)
                                            <span class="badge bg-info">Keluarga</span>
                                        @endif
                                        @if ($r->pendamping_tidak_ada)
                                            <span class="badge bg-warning">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ Str::limit($r->alasan_masuk_dirujuk, 50) }}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info show-btn" data-id="{{ $r->id }}"
                                            data-bs-toggle="modal" data-bs-target="#showRujukAntarRs" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $r->id }}"
                                            data-bs-toggle="modal" data-bs-target="#editRujukAntarRs" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form
                                            action="/unit-pelayanan/gawat-darurat/pelayanan/{{ $dataMedis->kd_pasien }}/{{ $dataMedis->tgl_masuk }}/{{ $dataMedis->urut_masuk }}/rujuk-antar-rs/{{ $r->id }}"
                                            method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn" title="Hapus">
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
            </x-content-card>
        </div>
    </div>

    {{-- Include the modals for create, edit and show --}}
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.rujuk-antar-rs.create-modal')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.rujuk-antar-rs.edit-modal')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.rujuk-antar-rs.show-modal')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable
            $('#rujukanTable').DataTable({
                "ordering": false,
                "searching": true,
                "paging": true,
                // "info": true,
                // "pageLength": 10,
                // "language": {
                //     "search": "Cari:",
                //     "lengthMenu": "Tampilkan _MENU_ data",
                //     "zeroRecords": "Tidak ada data yang ditemukan",
                //     "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                //     "infoEmpty": "Tidak ada data tersedia",
                //     "infoFiltered": "(difilter dari _MAX_ total data)",
                //     "paginate": {
                //         "first": "Pertama",
                //         "last": "Terakhir",
                //         "next": "Selanjutnya",
                //         "previous": "Sebelumnya"
                //     }
                // }
            });

            // Konfirmasi hapus dengan SweetAlert
            $(document).on('click', '.delete-btn', function() {
                const form = $(this).closest('form');
                const tanggal = form.closest('tr').find('td:first-child').text()
                    .trim(); // Ambil tanggal dari baris

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus data rujukan tanggal ${tanggal}. Data yang dihapus tidak dapat dikembalikan!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true // Membalikkan posisi tombol untuk UX yang lebih baik
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form jika dikonfirmasi
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

            // Handle show button click to fill the show modal
            $(document).on('click', '.show-btn', function() {
                const id = $(this).data('id');
                const modal = $('#showRujukAntarRs');

                // Store the current ID for edit button in show modal
                window.currentShowId = id;

                // Show loading
                modal.find('.modal-body').html(
                    '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                );

                // Fetch rujukan data
                $.ajax({
                    url: "/unit-pelayanan/gawat-darurat/pelayanan/{{ $dataMedis->kd_pasien }}/{{ $dataMedis->tgl_masuk }}/{{ $dataMedis->urut_masuk }}/rujuk-antar-rs/" +
                        id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log("Show data received:", response);
                        let html = formatDetailView(response);
                        modal.find('.modal-body').html(html);
                    },
                    error: function(xhr) {
                        console.error("Error loading show data:", xhr);
                        modal.find('.modal-body').html(
                            '<div class="alert alert-danger">Error loading data: ' + xhr
                            .status + ' - ' + xhr.statusText + '</div>');
                    }
                });
            });

            // Filter functionality
            $('#searchBtn').click(function() {
                const searchTerm = $('#searchInput').val().toLowerCase();

                $('#rujukanTable tbody tr').each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Handle delete button with confirmation
            $(document).on('click', '.delete-btn', function() {
                if (confirm('Apakah Anda yakin ingin menghapus data rujukan ini?')) {
                    $(this).closest('form.delete-form').submit();
                }
            });

            // Helper function to format detail view for show modal
            function formatDetailView(data) {
                const formatDate = (dateString) => {
                    if (!dateString) return '-';
                    const options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    return new Date(dateString).toLocaleDateString('id-ID', options);
                };

                // Format transportasi
                let transportasi = data.transportasi === 'ambulans' ? 'Ambulans RS' : data.detail_kendaraan;

                // Format pendamping
                let pendamping = [];
                if (data.pendamping_dokter == 1) pendamping.push('Dokter');
                if (data.pendamping_perawat == 1) pendamping.push('Perawat');
                if (data.pendamping_keluarga == 1) pendamping.push(`Keluarga: ${data.detail_keluarga}`);
                if (data.pendamping_tidak_ada == 1) pendamping.push('Tidak Ada');

                // Format alasan
                let alasan = [];
                if (data.alasan_tempat_penuh == 1) alasan.push('Tempat penuh');
                if (data.alasan_permintaan_keluarga == 1) alasan.push('Permintaan keluarga');
                if (data.alasan_perawatan_khusus == 1) alasan.push('Perawatan khusus');
                if (data.alasan_lainnya == 1) alasan.push(`Lainnya: ${data.detail_alasan_lainnya}`);

                // Format alergi
                let alergiHtml = '';
                if (data.alergi) {
                    try {
                        const alergiData = JSON.parse(data.alergi);
                        if (alergiData.length > 0) {
                            alergiHtml = '<ul>';
                            alergiData.forEach(function(item) {
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

                // Format diagnosis
                let diagnosisHtml = '';
                if (data.diagnosis) {
                    try {
                        const diagnosisData = JSON.parse(data.diagnosis);
                        if (diagnosisData.length > 0) {
                            diagnosisHtml = '<ul>';
                            diagnosisData.forEach(function(item) {
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
