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
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="edukasiForm" method="POST"
                action="{{ route('permintaan-darah.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen text-center font-weight-bold mb-4">PERMINTAAN DARAH/PRODUK DARAH
                                </h4>
                                <p>Isikan data permintaan darah pasien dan keluarga terintegrasi</p>
                            </div>

                            <!-- Petunjuk Permintaan -->
                            <div class="section-separator mb-3">
                                <div class="card-header font-weight-bold">PETUNJUK PERMINTAAN:</div>
                                <div class="card-body">
                                    <ol class="pl-3 mb-0">
                                        <li>Satu Formulir untuk Satu kali permintaan</li>
                                        <li>Setiap permintaan Darah harus disertai sampel Pasien dalam tabung EDTA 3 ml</li>
                                        <li>Nama dan Identitas Pasien pada Formulir dan Contoh darah harus SAMA</li>
                                    </ol>
                                </div>
                                <div class="card-header font-weight-bold">PETUNJUK TRANSFUSI:</div>
                                <div class="card-body">
                                    <p class="mb-0">Pastikan Identitas Pasien dan Cocokkan etiket pada Kantong Darah,
                                        Label
                                        dan Formulir, Segera kembalikan bila tidak Cocok Ke Bank Darah Rumah Sakit (BDRS)
                                        setempat atau UTD PMI</p>
                                </div>
                            </div>

                            <!-- Urgency Section -->
                            <div class="section-separator mb-3">
                                <div class="card-header bg-white">
                                    <p class="font-weight-bold mb-0">Harap Diisi LENGKAP oleh Pihak Rumah Sakit: Untuk
                                        keamanan Transfusi</p>
                                </div>
                                <div class="card-body pt-2">
                                    <div class="form-row ml-auto justify-content-end">
                                        <div class="form-check form-check-inline mr-4">
                                            <input class="form-check-input" type="radio" name="TIPE" id="urgensi_biasa"
                                                value="0" checked required>
                                            <label class="form-check-label" for="urgensi_biasa">Biasa</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="TIPE" id="urgensi_cito"
                                                value="1" required>
                                            <label class="form-check-label" for="urgensi_cito">Cito (Harus disertai
                                                memo)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Permintaan -->
                            <div class="section-separator mb-3">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="kd_dokter" style="min-width: 200px;">Dokter yang meminta</label>

                                        <select name="KD_DOKTER" id="kd_dokter" class="form-select select2" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->dokter->kd_dokter }}">
                                                    {{ $dok->dokter->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tgl Pengiriman</label>
                                        <input type="date" class="form-control" name="TGL_PENGIRIMAN"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="diperlukan" style="min-width: 200px;">Diperlukan</label>
                                        <input type="date" class="form-control" name="TGL_DIPERLUKAN"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Diagnosa Kimia</label>
                                        <input type="text" class="form-control" name="DIAGNOSA_KIMIA" placeholder=""
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Alasan Transfusi</label>
                                        <input type="text" class="form-control" name="ALASAN_TRANSFUSI" placeholder=""
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="golda" style="min-width: 200px;">Golongan Darah</label>

                                        <select class="form-select" name="KODE_GOLDA" id="golda" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach ($gologanDarah as $darah)
                                                <option value="{{ $darah->kode }}">{{ $darah->jenis }}</option>
                                            @endforeach
                                        </select>

                                        <label class="ms-3">HB</label>

                                        <div class="input-group mb-3">
                                            <input type="number" name="HB" class="form-control"
                                                aria-describedby="basic-addon1" required>
                                            <span class="input-group-text" id="basic-addon1">g</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nama Suami/Istri Pasien</label>
                                        <input type="text" class="form-control" name="NAMA_SUAMI_ISTRI" placeholder=""
                                            required>

                                        <label class="mx-2">Register</label>
                                        <input type="text" class="form-control" name="KD_PASIEN"
                                            value="{{ $dataMedis->kd_pasien }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Medical History -->
                            <div class="section-separator mb-3">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Transfusi Sebelumnya</label>
                                        <input type="text" class="form-control" name="TRANFUSI_SEBELUMNYA"
                                            placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gejala Reaksi Transfusi</label>
                                        <input type="text" class="form-control" name="REAKSI_TRANFUSI"
                                            placeholder="">
                                    </div>

                                    <p class="fw-bold">Apakah pernah diperiksa Serologi golongan darah</p>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Dimana</label>
                                        <input type="text" class="form-control" name="SEROLOGI_DIMANA"
                                            placeholder="">

                                        <label class="mx-2">Kapan</label>
                                        <input type="date" class="form-control" name="SEROLOGI_KAPAN">

                                        <label class="mx-2">Hasil</label>
                                        <input type="text" class="form-control" name="SEROLOGI_HASIL" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Khusus Pasien wanita: Pernah hamil?</label>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="PERNAH_HAMIL"
                                                id="radioDefault1Hamil">
                                            <label class="form-check-label" for="radioDefault1Hamil">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check mx-2 mt-2">
                                            <input class="form-check-input" type="radio" name="PERNAH_HAMIL"
                                                id="radioDefault2Hamil" checked value="0">
                                            <label class="form-check-label" for="radioDefault2Hamil">
                                                Tidak
                                            </label>
                                        </div>

                                        <label class="mx-3">Jumlah</label>
                                        <input type="number" class="form-control" id="pernah-hamil-jumlah"
                                            name="PERNAH_HAMIL" placeholder="">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 300px;">Pernah Abortus atau Bayi kuning karena hemolisis
                                            (HDN)?</label>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="ABORTUS_HDN"
                                                id="radioDefault1Abortur" value="1">
                                            <label class="form-check-label" for="radioDefault1Abortur">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check mx-2 mt-2">
                                            <input class="form-check-input" type="radio" name="ABORTUS_HDN"
                                                id="radioDefault2Abortus" checked value="0">
                                            <label class="form-check-label" for="radioDefault2Abortus">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="section-separator mb-3">
                                <div class="card-body">
                                    <h5 class="font-weight-bold mb-3">DARAH LENGKAP (WHOLEBLOOD)</h5>
                                    <div class="input-group mb-3">
                                        <label style="min-width: 200px;">WB Segar / Biasa</label>
                                        <input type="number" class="form-control"name="WB">
                                        <span class="input-group-text">ml</span>
                                    </div>

                                    <h5 class="font-weight-bold mt-4 mb-3">DARAH MERAHPEKAT (PACKED RED CELL)</h5>
                                    <div class="input-group mb-3">
                                        <label style="min-width: 200px;">PRC Biasa</label>
                                        <input type="number" class="form-control"name="PRC">
                                        <span class="input-group-text">ml</span>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label style="min-width: 200px;">PRC Pediatric <br> Leukodepleted**</label>
                                        <input type="number" class="form-control" name="PRC_PEDIACTRIC" min="0">
                                        <span class="input-group-text">ml</span>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label style="min-width: 200px;">PRC Leukodepleted <br> (dengan
                                            filter)**</label>
                                        <input class="form-control" type="number" name="PRC_LEUKODEPLETED"
                                            min="0">
                                        <span class="input-group-text">ml</span>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label style="min-width: 200px;">Washed Erythrocyte (WE)</label>
                                        <input type="number" class="form-control" name="WASHED_ERYTHROYTE"
                                            min="0">
                                        <span class="input-group-text">ml</span>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lain-lain</label>
                                        <input type="text" class="form-control" name="LAINNYA" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="section-separator mb-3">
                                <div class="card-body">
                                    <h5 class="font-weight-bold mb-3">THROMBOCYTE CONCENTRATE (TC)</h5>
                                    <div class="input-group">
                                        <label style="min-width: 200px;">TC Biasa</label>
                                        <input type="number" class="form-control" name="TC_BIASA" min="0">

                                        <span class="input-group-text">unit</span>
                                    </div>

                                    <div class="input-group">
                                        <label style="min-width: 200px;">TC Apheresis*</label>
                                        <input type="number" class="form-control" name="TC_APHERESIS" min="0">
                                        <span class="input-group-text">unit</span>
                                    </div>

                                    <div class="input-group">
                                        <label style="min-width: 200px;">TC Pooled (Leukodepleted)**</label>
                                        <input type="number" class="form-control" name="TC_POOLED" min="0">
                                        <span class="input-group-text">unit</span>
                                    </div>

                                    <h5 class="font-weight-bold mt-4 mb-3">PLASMA</h5>
                                    <div class="input-group">
                                        <label style="min-width: 200px;">Plasma Cair (liquid Plasma)</label>
                                        <input type="number" class="form-control" name="PLASMA_CAIR" min="0">
                                        <span class="input-group-text">ml</span>
                                    </div>

                                    <div class="input-group">
                                        <label style="min-width: 200px;">Plasma Segar Beku (FFP)</label>
                                        <input type="number" class="form-control" name="PLASMA_SEGAR_BEKU"
                                            min="0">
                                        <span class="input-group-text">ml</span>
                                    </div>

                                    <div class="input-group">
                                        <label style="min-width: 200px;">Cryoprecipitate AHF</label>
                                        <input type="number" class="form-control" name="CIYOPRECIPITATE"
                                            min="0">
                                        <span class="input-group-text">unit</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Declaration -->
                            <div class="section-separator mb-3">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal Pengambilan Sampel</label>
                                        <input type="date" class="form-control" name="TGL_PENGAMBILAN_SAMPEL"
                                            value="{{ date('Y-m-d') }}" required>

                                        <label class="mx-2">Jam</label>
                                        <input type="time" class="form-control" name="WAKTU_PENGAMBILAN_SAMPEL"
                                            value="{{ date('H:i:s') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nama Petugas</label>
                                        <input type="text" class="form-control" name="PETUGAS_PENGAMBILAN_SAMPEL"
                                            placeholder="" required>
                                    </div>
                                </div>
                            </div>

                            <!-- UTD Section (Readonly) -->
                            <div class="mb-3 section-separator">
                                <div class="alert alert-secondary mt-3">
                                    <p class="mb-1"><b>PEMBERITAHUAN:</b></p>
                                    <ol class="pl-3 mb-0">
                                        <li>Darah dari Donor tidak diperjualbelikan namun memerlukan biaya pengolahan
                                            yang disebut Service Cost atau BPPD (Biaya Pengganti Pengolahan Darah)</li>
                                        <li>Biaya Pengganti Pengolahan Darah (BPPD) berlaku bagi setiap pemakai Darah
                                            tanpa terkecuali</li>
                                        <li>Pembayaran Biaya Pengganti Pengolahan Darah (BPPD) dilakukan di Rumah Sakit
                                            (Bila ada Kerjasama dengan UTD)</li>
                                        <li>Darah yang sudah di periksa tetap dikenakan Biaya</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary" id="simpan">
                                <i class="ti-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Print functionality
            const printButton = document.getElementById('print_form');
            if (printButton) {
                printButton.addEventListener('click', function() {
                    window.print();
                });
            }

            // Reset confirmation
            const resetButton = document.getElementById('reset_form');
            if (resetButton) {
                resetButton.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin mereset form ini?')) {
                        e.preventDefault();
                    }
                });
            }

            // Form submission confirmation
            const form = document.getElementById('edukasiForm');

        });

        // Khusus Pasien wanita: Pernah hamil?
        document.addEventListener('DOMContentLoaded', function() {
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
