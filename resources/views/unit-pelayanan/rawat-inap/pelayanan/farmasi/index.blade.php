@extends('layouts.administrator.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        /* .header-background { background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");} */
        .modal-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
        }

        #editObatModal {
            z-index: 1060;
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
                                <button class="nav-link active" id="resep-tab" data-bs-toggle="tab" data-bs-target="#resep"
                                    type="button" role="tab" aria-controls="resep" aria-selected="true">E-Resep Obat &
                                    BMHP</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="catatan-tab" data-bs-toggle="tab" data-bs-target="#riwayat"
                                    type="button" role="tab" aria-controls="riwayat" aria-selected="false">Riwayat
                                    Penggunaan Obat</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="catatan-tab-2" data-bs-toggle="tab"
                                    data-bs-target="#catatanTab" type="button" role="tab" aria-controls="catatanTab"
                                    aria-selected="false">
                                    Catatan Pemberian Obat</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="rekonsiliasi-tab" data-bs-toggle="tab"
                                    data-bs-target="#rekonsiliasi" type="button" role="tab"
                                    aria-controls="rekonsiliasi" aria-selected="false">Rekonsiliasi Obat</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="rekonsiliasi-transfer-tab" data-bs-toggle="tab"
                                    data-bs-target="#rekonsiliasiTransfer" type="button" role="tab"
                                    aria-controls="rekonsiliasiTransfer" aria-selected="false">
                                    Rekonsiliasi Obat Transfer
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="e-resep-obat-pulang-tab" data-bs-toggle="tab"
                                    data-bs-target="#e-resep-obat-pulang" type="button" role="tab"
                                    aria-controls="e-resep-obat-pulang" aria-selected="false">
                                    E-Resep Obat Pulang
                                </button>
                            </li>
                        </ul>

                        {{-- Tab Content --}}
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="resep" role="tabpanel"
                                aria-labelledby="resep-tab">
                                {{-- TAB 1. buatlah list disini --}}
                                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.tabsresep')
                            </div>
                            <div class="tab-pane fade" id="riwayat" role="tabpanel" aria-labelledby="catatan-tab">
                                {{-- TAB 2. buatlah list disini --}}
                                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.tab-riwayat.riwayat')
                            </div>
                            <div class="tab-pane fade" id="catatanTab" role="tabpanel" aria-labelledby="catatan-tab-2">
                                {{-- TAB 3. buatlah list disini --}}
                                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.tabcatatan')
                            </div>
                            <div class="tab-pane fade" id="rekonsiliasi" role="tabpanel" aria-labelledby="rekonsiliasi-tab">
                                {{-- TAB 4. buatlah list disini --}}
                                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.tabsrekonsiliasi')
                            </div>
                            <div class="tab-pane fade" id="rekonsiliasiTransfer" role="tabpanel"
                                aria-labelledby="rekonsiliasi-transfer-tab">
                                <!-- TAB 5. Rekonsiliasi Obat Transfer -->
                                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.tabsrekonsiliasitransfer')
                            </div>
                            <div class="tab-pane fade" id="e-resep-obat-pulang" role="tabpanel"
                                aria-labelledby="e-resep-obat-pulang-tab">
                                {{-- TAB 6. E-Resep Obat Pulang --}}
                                @include('unit-pelayanan.rawat-inap.pelayanan.farmasi.tab-eresep-pulang.resep')
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
            // Simpan tab aktif ke localStorage saat tab berubah
            $('#myTab .nav-link').on('shown.bs.tab', function(e) {
                const activeTabId = $(e.target).attr(
                    'id'); // Misal: resep-tab, riwayat-tab, rekonsiliasi-tab
                localStorage.setItem('activeMainTab', activeTabId);
            });

            // Pulihkan tab aktif saat halaman dimuat
            const savedTab = localStorage.getItem('activeMainTab');
            if (savedTab) {
                $(`#${savedTab}`).tab('show'); // Aktifkan tab yang tersimpan
            }


            function formatDateTime(date, time) {
                if (!date || !time) {
                    return '';
                }

                let formattedDate;
                if (date.includes('-')) {
                    formattedDate = date;
                } else if (date.includes('/')) {
                    const parts = date.split('/');
                    formattedDate = `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
                } else {
                    return '';
                }

                const formattedTime = time.length === 5 ? time + ':00' : time;
                return `${formattedDate} ${formattedTime}`;
            }

            // Jika URL berisi ?open=resep maka aktifkan tab resep saat halaman dimuat
            (function() {
                try {
                    const params = new URLSearchParams(window.location.search);
                    if (params.get('open') === 'resep') {
                        // Show resep tab
                        const resepTab = document.getElementById('resep-tab');
                        if (resepTab) {
                            $(resepTab).tab('show');
                        }
                    }
                } catch (e) {
                    console.error('Error processing open param:', e);
                }
            })();

        });
    </script>
@endpush
