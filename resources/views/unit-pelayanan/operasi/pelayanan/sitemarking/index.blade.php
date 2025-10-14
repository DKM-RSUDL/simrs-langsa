@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        #asesmenList .list-group-item:nth-child(even) {
            background-color: #edf7ff;
        }

        #asesmenList .list-group-item:nth-child(odd) {
            background-color: #ffffff;
        }

        #asesmenList .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .list-group-item {
            margin-bottom: 0.2rem;
            border-radius: 0.5rem !important;
            padding: 1rem;
            border: 1px solid #dee2e6;
            background: white;
            transition: all 0.2s;
        }

        .list-group-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        .gap-3 {
            gap: 1rem !important;
        }

        .gap-4 {
            gap: 1.5rem !important;
        }

        .btn-sm {
            padding: 0.4rem 1rem;
            font-size: 0.875rem;
        }

        .btn i {
            font-size: 0.875rem;
        }

        .site-marking-info {
            background-color: #f8f9fa;
            border-left: 4px solid #4e73df;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .btn-site-marking {
            background-color: #4e73df;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-site-marking:hover {
            background-color: #375ad3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            @include('components.navigation-operasi')
            <x-content-card>

                @include('components.page-header', [
                    'title' => 'Penandaan Daerah Operasi',
                    'description' =>
                        'Site marking adalah proses penandaan lokasi pada tubuh pasien untuk mencegah kesalahan dalam
                        identifikasi area yang akan ditangani. Fitur ini memungkinkan tenaga medis untuk:',
                ])
                <ul list-style-type: disc; class="ms-4 -mt-5">
                        <li>Menandai lokasi spesifik pada gambar anatomi tubuh</li>
                        <li>Menambahkan catatan tentang kondisi pasien pada area tertentu</li>
                        <li>Mendokumentasikan perubahan kondisi secara visual</li>
                        <li>Meningkatkan akurasi dan keamanan dalam perawatan pasien</li>
                    </ul>

                <div class="d-flex justify-content-between align-items-center">
                    <h6>Riwayat Site Marking Pasien</h6>
                    <a href="{{ route('operasi.pelayanan.site-marking.create', ['kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk, 'urut_masuk' => $urut_masuk]) }}"
                        class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Site Marking Baru
                    </a>
                </div>

                @if ($siteMarkings->isNotEmpty())
                    <div class="list-group" id="markingList">
                        @foreach ($siteMarkings as $marking)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">Site Marking - {{ $marking->waktu_prosedure }}</div>
                                    <div class="text-muted">PPA Oleh:
                                        {{ $marking->creator ? $marking->creator->name : 'Tidak tersedia' }}</div>
                                    <div class="text-muted">Prosedur: {{ $marking->prosedure }}</div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('operasi.pelayanan.site-marking.show', ['kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk, 'urut_masuk' => $urut_masuk, 'id' => $marking->id]) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger btn-delete"
                                        data-id="{{ $marking->id }}" data-kd-pasien="{{ $kd_pasien }}"
                                        data-tgl-masuk="{{ $tgl_masuk }}" data-urut-masuk="{{ $urut_masuk }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Belum ada site marking untuk pasien ini. Silakan tambahkan
                        dengan menekan tombol "Tambah Site Marking Baru".
                    </div>
                @endif
            </x-content-card>
        </div>
    </div>

    <!-- Form untuk mengirim request delete -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('js')
    <!-- SweetAlert2 JS -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Implementasi SweetAlert untuk konfirmasi delete
            const deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const kdPasien = this.getAttribute('data-kd-pasien');
                    const tglMasuk = this.getAttribute('data-tgl-masuk');
                    const urutMasuk = this.getAttribute('data-urut-masuk');

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus Site Marking ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.getElementById('delete-form');
                            form.action =
                                "{{ route('operasi.pelayanan.site-marking.destroy', ['kd_pasien' => ':kd_pasien', 'tgl_masuk' => ':tgl_masuk', 'urut_masuk' => ':urut_masuk', 'id' => ':id']) }}"
                                .replace(':kd_pasien', kdPasien)
                                .replace(':tgl_masuk', tglMasuk)
                                .replace(':urut_masuk', urutMasuk)
                                .replace(':id', id);
                            form.submit();
                        }
                    });
                });
            });

            // Get the stored active tab from localStorage
            const activeTab = localStorage.getItem('activeTab');

            // If there's a stored tab, activate it
            if (activeTab) {
                // Remove 'active' class from the default active tab and tab pane
                document.querySelectorAll('.nav-tabs .nav-link.active').forEach(tab => {
                    tab.classList.remove('active');
                });
                document.querySelectorAll('.tab-content .tab-pane.active').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });

                // Add 'active' class to the stored tab and its corresponding pane
                const targetTab = document.querySelector(`#${activeTab}-tab`);
                const targetPane = document.querySelector(`#${activeTab}`);
                if (targetTab && targetPane) {
                    targetTab.classList.add('active');
                    targetPane.classList.add('show', 'active');
                }
            }

            // Store the active tab in localStorage when a tab is clicked
            document.querySelectorAll('.nav-tabs .nav-link').forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.id.replace('-tab', '');
                    localStorage.setItem('activeTab', tabId);
                });
            });

            // Show success message with SweetAlert if available in session
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // Show error message with SweetAlert if available in session
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}'
                });
            @endif
        });
    </script>
@endpush
