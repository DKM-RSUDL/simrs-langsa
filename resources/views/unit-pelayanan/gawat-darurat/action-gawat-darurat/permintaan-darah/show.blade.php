@extends('layouts.administrator.master')

@push('css')
    <style>
        .header-asesmen {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }

        .card {
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-control-plaintext {
            padding-top: calc(0.375rem + 1px);
        }

        .custom-control-label {
            cursor: pointer;
        }

        .table th {
            font-size: 0.9rem;
        }
    </style>
@endpush

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between">
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                @if ($order->status == 0)
                    <a href="{{ route('permintaan-darah.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $order->id]) }}"
                        class="btn btn-warning btn-sm ms-2" title="Edit">
                        <i class="ti-pencil"></i> Edit
                    </a>
                @endif
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2"
                        aria-expanded="true" aria-controls="collapseOne2">
                        <span class="fw-bold">Detail Order</span>
                    </button>
                </h2>
                <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne1"
                    data-bs-parent="#accordionExample2" style="">
                    <div class="accordion-body">

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Tipe</th>
                                                <td>
                                                    @if ($order->tipe == 0)
                                                        Biasa
                                                    @endif

                                                    @if ($order->tipe == 1)
                                                        Cito
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Unit Order</th>
                                                <td>{{ $order->unit->nama_unit }}</td>
                                            </tr>

                                            <tr>
                                                <th>Dokter</th>
                                                <td>{{ $order->dokter->nama_lengkap }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Nama OS</th>
                                                <td>{{ str()->title($order->pasien->nama) ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Jenis Kelamin</th>
                                                <td>{{ $order->pasien->jenis_kelamin == '0' ? 'Perempuan' : 'Laki-Laki' ?? '-' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>No RM</th>
                                                <td>{{ $order->kd_pasien ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Alamat</th>
                                                <td>{{ $order->pasien->alamat ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>No. HP</th>
                                                <td>{{ $order->pasien->telepon ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr align="middle" class="bg-light">
                                                <th colspan="2">DARAH LENGKAP (WHOLEBLOOD)</th>
                                            </tr>

                                            <tr>
                                                <th>WB Segar/Biasa</th>
                                                <td>{{ $order->wb ?? 0 }} ml</td>
                                            </tr>

                                            <tr align="middle" class="bg-light">
                                                <th colspan="2">DARAH MERAHPEKAT (PACKED RED CELL)</th>
                                            </tr>

                                            <tr>
                                                <th>PRC Biasa</th>
                                                <td>{{ $order->prc ?? 0 }} ml</td>
                                            </tr>

                                            <tr>
                                                <th>PRC Pediatric Leukodepleted</th>
                                                <td>{{ $order->prc_pediactric ?? 0 }} ml</td>
                                            </tr>

                                            <tr>
                                                <th>PRC Leukodepleted (dengan filter)</th>
                                                <td>{{ $order->prc_leukodepleted ?? 0 }} ml</td>
                                            </tr>

                                            <tr>
                                                <th>Washed Erythroyte (WE)</th>
                                                <td>{{ $order->washed_erythroyte ?? 0 }} ml</td>
                                            </tr>

                                            <tr>
                                                <th>Lain-lain</th>
                                                <td>{{ $order->lainnya ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Waktu Pengambilan Sampel</th>
                                                <td>{{ date('d M Y H:i', strtotime($order->waktu_pengambilan_sampel)) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Petugas</th>
                                                <td>{{ $order->petugas_pengambilan_sampel }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Tgl Order</th>
                                                <td>{{ date('d M Y', strtotime($order->tgl_pengiriman)) }}</td>
                                            </tr>

                                            <tr>
                                                <th>Tgl Diperlukan</th>
                                                <td>{{ date('d M Y', strtotime($order->tgl_diperlukan)) }}</td>
                                            </tr>

                                            <tr>
                                                <th>Diagnosa Kimia</th>
                                                <td>{{ $order->diagnosa_kimia }}</td>
                                            </tr>

                                            <tr>
                                                <th>Gol. Darah</th>
                                                <td>{{ $order->golDarah->jenis }}</td>
                                            </tr>

                                            <tr>
                                                <th>Alasan Transfusi</th>
                                                <td>{{ $order->alasan_transfusi }}</td>
                                            </tr>

                                            <tr>
                                                <th>HB</th>
                                                <td>{{ $order->hb }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Transfusi Sebelumnya</th>
                                                <td>{{ $order->tranfusi_sebelumnya ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Gejala Reaksi Transfusi</th>
                                                <td>{{ $order->reaksi_tranfusi ?? '-' }}</td>
                                            </tr>

                                            @if ($order->pasien->jenis_kelamin == 0)
                                                <tr>
                                                    <th>Pernah Hamil</th>
                                                    <td>{{ $order->pernah_hamil ?? '-' }}</td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <th>Pernah Abortus</th>
                                                <td>{{ $order->abortus_hdn || $order->abortus_hdn == 0 ? 'Tidak pernah' : 'Pernah' }}
                                                </td>
                                            </tr>

                                            <tr align="middle" class="bg-light">
                                                <th colspan="2">SEROLOGI</th>
                                            </tr>

                                            <tr>
                                                <th>Tempat</th>
                                                <td>{{ $order->serologi_dimana ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Waktu</th>
                                                <td>{{ $order->serologi_kapan ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Hasil</th>
                                                <td>{{ $order->serologi_hasil ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr align="middle" class="bg-light">
                                                <th colspan="2">THROMBOCYTE CONCENTRATE (TC)</th>
                                            </tr>

                                            <tr>
                                                <th>TC Biasa</th>
                                                <td>{{ $order->tc_biasa ?? 0 }} unit</td>
                                            </tr>

                                            <tr>
                                                <th>TC Apheresis</th>
                                                <td>{{ $order->tc_apheresis ?? 0 }} unit</td>
                                            </tr>

                                            <tr>
                                                <th>TC Pooled (Leukodepleted)</th>
                                                <td>{{ $order->tc_pooled ?? 0 }} unit</td>
                                            </tr>

                                            <tr align="middle" class="bg-light">
                                                <th colspan="2">PLASMA</th>
                                            </tr>

                                            <tr>
                                                <th>Plasma Cair (liquid Palsma)</th>
                                                <td>{{ $order->plasma_cair ?? 0 }} ml</td>
                                            </tr>

                                            <tr>
                                                <th>Plasma Segar Beku (FFP)</th>
                                                <td>{{ $order->plasma_segar_beku ?? 0 }} ml</td>
                                            </tr>

                                            <tr>
                                                <th>Ciyoprecipitate AHF</th>
                                                <td>{{ $order->ciyoprecipitate ?? 0 }} unit</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- @if ($order->status == 0)
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#prosesModal">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                    Terima / Proses
                                </button>
                            </div>
                        </div>
                        @endif --}}

                    </div>
                </div>
            </div>

            @if ($order->status == 1 || $order->status == 2)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
                            <span class="fw-bold">Penerimaan Sampel Darah</span>
                        </button>
                    </h2>
                    <div id="collapseTwo2" class="accordion-collapse collapse" aria-labelledby="headingTwo2"
                        data-bs-parent="#accordionExample2" style="">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="card mt-3">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Petugas Penerima</th>
                                                    <td>{{ $order->petugas_penerima_sampel ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Waktu Diterima</th>
                                                    <td>{{ date('d M Y', strtotime($order->tgl_terima_sampel)) . ' ' .
                date('H:i', strtotime($order->jam_terima_sampel)) }}
                                                        WIB</td>
                                                </tr>
                                                <tr>
                                                    <th>ABO</th>
                                                    <td>{{ $order->abo }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Rhesus</th>
                                                    <td>{{ $order->rhesus->jenis ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($order->status == 2)
                    <div class="accordion-item mt-5">
                        <h2 class="accordion-header" id="headingThree3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree3" aria-expanded="false" aria-controls="collapseThree3">
                                <span class="fw-bold">Pemeriksaan dan Pemberian Darah</span>
                            </button>
                        </h2>
                        <div id="collapseThree3" class="accordion-collapse collapse" aria-labelledby="headingThree3"
                            data-bs-parent="#accordionExample2" style="">
                            <div class="accordion-body">

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Petugas Pemeriksa</th>
                                                    <td>{{ $order->petugas_pemeriksa ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Waktu Periksa</th>
                                                    <td>
                                                        {{ date('d M Y', strtotime($order->tgl_periksa)) . ' ' . date(
                        'H:i',
                        strtotime($order->jam_periksa)
                    ) }}
                                                        WIB
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Hasil Pemeriksaan</th>
                                                    <td>
                                                        @if ($order->hasil_pemeriksaan == 0)
                                                            Tidak Cocok
                                                        @endif

                                                        @if ($order->hasil_pemeriksaan == 1)
                                                            Cocok
                                                        @endif

                                                        @if ($order->hasil_pemeriksaan == 2)
                                                            Tanpa Cross
                                                        @endif

                                                        @if ($order->hasil_pemeriksaan == 3)
                                                            Emergency
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Petugas yang Mengambil</th>
                                                    <td>{{ $order->petugas_ambil }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr align="middle">
                                                    <th>No</th>
                                                    <th>No Kantong</th>
                                                    <th>Jenis Darah</th>
                                                    <th>Gol. Darah</th>
                                                    <th>Tanggal Pengambilan</th>
                                                    <th>Vol (ML) CC Kantong</th>
                                                </tr>

                                                @foreach ($order->detail as $detail)
                                                    <tr>
                                                        <td align="middle">{{ $loop->iteration }}</td>
                                                        <td align="middle">{{ $detail->no_kantong ?? '-' }}</td>
                                                        <td align="middle">
                                                            @if ($detail->jenis_darah == 1)
                                                                WB
                                                            @endif

                                                            @if ($detail->jenis_darah == 2)
                                                                PRC
                                                            @endif

                                                            @if ($detail->jenis_darah == 3)
                                                                TC
                                                            @endif

                                                            @if ($detail->jenis_darah == 4)
                                                                PLASMA
                                                            @endif
                                                        </td>
                                                        <td align="middle">{{ $detail->golDarah->jenis ?? '-' }}</td>
                                                        <td align="middle">
                                                            {{ date('d M Y', strtotime($detail->tgl_pengambilan)) }}
                                                        </td>
                                                        <td align="middle">{{ $detail->vol_kantong }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @endif

        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Print functionality
            const printButton = document.getElementById('print_form');
            if (printButton) {
                printButton.addEventListener('click', function () {
                    window.print();
                });
            }

            // Reset confirmation
            const resetButton = document.getElementById('reset_form');
            if (resetButton) {
                resetButton.addEventListener('click', function (e) {
                    if (!confirm('Apakah Anda yakin ingin mereset form ini?')) {
                        e.preventDefault();
                    }
                });
            }

            // Form submission confirmation
            const form = document.getElementById('edukasiForm');

        });

        // Khusus Pasien wanita: Pernah hamil?
        document.addEventListener('DOMContentLoaded', function () {
            // Dapatkan referensi ke elemen-elemen yang diperlukan
            const radioYa = document.getElementById('radioDefault1Hamil');
            const radioTidak = document.getElementById('radioDefault2Hamil');
            const jumlahLabel = document.querySelector('label.mx-3');
            const jumlahInput = document.getElementById('pernah-hamil-jumlah'); // Gunakan ID yang sudah ada

            // Fungsi untuk menampilkan atau menyembunyikan input jumlah
            function toggleJumlahInput() {
                if (radioYa.checked) {
                    // Jika Ya dipilih, tampilkan jumlah
                    jumlahLabel.style.display = 'inline-block';
                    jumlahInput.style.display = 'inline-block';
                } else {
                    // Jika Tidak dipilih, sembunyikan jumlah
                    jumlahLabel.style.display = 'none';
                    jumlahInput.style.display = 'none';
                }
            }

            // Tambahkan event listener untuk radio button
            radioYa.addEventListener('change', toggleJumlahInput);
            radioTidak.addEventListener('change', toggleJumlahInput);

            // Jalankan fungsi saat halaman dimuat untuk mengatur tampilan awal
            toggleJumlahInput();
        });
    </script>
@endpush