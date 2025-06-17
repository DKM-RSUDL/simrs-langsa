@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .section-separator {
            border-top: 2px solid #097dd6;
            margin: 2rem 0;
            padding-top: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-check {
            margin: 0;
            padding-left: 1.5rem;
            min-height: auto;
        }

        .form-check-input {
            margin-top: 0.3rem;
        }

        .form-check label {
            margin-right: 0;
            padding-top: 0;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        /* Styling untuk kartu edukasi */
        .edukasi-cards {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .edukasi-card {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .edukasi-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .edukasi-card .form-group {
            margin-bottom: 1.5rem;
        }

        .edukasi-card .form-check {
            margin-bottom: 0.5rem;
        }

        .edukasi-card .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .edukasi-card .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 5px rgba(9, 125, 214, 0.3);
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="edukasiForm" method="POST"
                action="{{ route('rawat-inap.privasi.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Tambah Permintaan Privasi dan Keamanan</h4>
                            </div>

                            <div class="px-3">

                                {{-- Info Umum --}}
                                <div class="section-separator">
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ date('Y-m-d') }}" required readonly>
                                    </div>
                                </div>

                                {{-- IDENTITAS KELUARGA --}}
                                <div class="section-separator">
                                    <h4 class="fw-semibold">IDENTITAS KELUARGA</h4>

                                    <div class="form-group">
                                        <label for="keluarga_hubungan_pasien" style="min-width: 200px;">Status keluarga dgn
                                            pasien</label>
                                        <select name="keluarga_hubungan_pasien" id="keluarga_hubungan_pasien"
                                            class="form-select" required>
                                            <option value="">--Pilih--</option>
                                            <option value="1">Diri sendiri</option>
                                            <option value="2">Istri</option>
                                            <option value="3">Suami</option>
                                            <option value="4">Anak</option>
                                            <option value="5">Ayah</option>
                                            <option value="6">Ibu</option>
                                            <option value="7">Lain-lain</option>
                                        </select>
                                    </div>

                                    <div id="identitas-keluarga">
                                        <div class="form-group">
                                            <label for="keluarga_nama">Nama</label>
                                            <input type="text" name="keluarga_nama" id="keluarga_nama"
                                                class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="keluarga_tempat_lahir">Tempat Lahir</label>
                                            <input type="text" name="keluarga_tempat_lahir" id="keluarga_tempat_lahir"
                                                class="form-control" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="keluarga_tgl_lahir">Tanggal Lahir</label>
                                            <input type="text" name="keluarga_tgl_lahir" id="keluarga_tgl_lahir"
                                                class="form-control date" required readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="keluarga_jenis_kelamin">Jenis
                                                Kelamin</label>
                                            <select name="keluarga_jenis_kelamin" id="keluarga_jenis_kelamin"
                                                class="form-select" required>
                                                <option value="">--Pilih--</option>
                                                <option value="0">Perempuan</option>
                                                <option value="1">Laki-Laki</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="keluarga_alamat">Alamat rumah</label>
                                            <textarea name="keluarga_alamat" id="keluarga_alamat" class="form-control" required></textarea>
                                        </div>
                                    </div>

                                </div>

                                {{-- PRIVASI --}}
                                <div class="section-separator">
                                    <h4 class="fw-semibold mb-3">PRIVASI</h4>

                                    <div class="form-group">
                                        <label for="status_privasi">Status privasi</label>
                                        <select name="status_privasi" id="status_privasi" class="form-select">
                                            <option value="">--Pilih--</option>
                                            <option value="0">Tidak Mengizinkan</option>
                                            <option value="1">Mengizinkan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="privasi_nama">Nama Sdr/i</label>
                                        <input type="text" class="form-control" name="privasi_nama" id="privasi_nama">
                                    </div>
                                </div>

                                {{-- PRIVASI KHUSUS --}}
                                <div class="section-separator">
                                    <h4 class="fw-semibold mb-3">PRIVASI KHUSUS</h4>

                                    <div class="form-group">
                                        <div class="d-flex">
                                            <label style="min-width: 200px;">Privasi Khusus</label>
                                            <div class="">
                                                <div class="">
                                                    <input type="checkbox" name="privasi_khusus[]" id="privasi_wawancara"
                                                        class="form-check-input" value="wawancara">
                                                    <label for="privasi_wawancara">Wawancara Klinis</label>
                                                </div>

                                                <div class="">
                                                    <input type="checkbox" name="privasi_khusus[]" id="privasi_fisik"
                                                        class="form-check-input" value="fisik">
                                                    <label for="privasi_fisik">Pemeriksaan Fisik</label>
                                                </div>

                                                <div class="">
                                                    <input type="checkbox" name="privasi_khusus[]" id="privasi_perawatan"
                                                        class="form-check-input" value="perawatan">
                                                    <label for="privasi_perawatan">Perawatan/Tindakan</label>
                                                </div>

                                                <div class="">
                                                    <input type="checkbox" name="privasi_khusus[]" id="privasi_lain"
                                                        class="form-check-input" value="lainnya">
                                                    <label for="privasi_lain">Lainnya</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" id="privasi_perawatan_input">
                                        <label for="tindakan_privasi">Nama perawatan/tindakan privasi</label>
                                        <input type="text" class="form-control" name="tindakan_privasi"
                                            id="tindakan_privasi">
                                    </div>

                                    <div class="form-group" id="privasi_lainnya_input">
                                        <label for="privasi_lainnya">Privasi Lainnya</label>
                                        <input type="text" class="form-control" name="privasi_lainnya"
                                            id="privasi_lainnya">
                                    </div>

                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#identitas-keluarga').hide();
            $('#identitas-keluarga input,select,textarea').prop('required', false);
            $('#keluarga_hubungan_pasien').prop('required', true);
            $('.form-group#privasi_perawatan_input').hide();
            $('.form-group#privasi_lainnya_input').hide();
        });

        $('#keluarga_hubungan_pasien').change(function() {
            let nilai = $(this).val();

            if (nilai == 1) {
                $('#identitas-keluarga').hide();
                $('#identitas-keluarga input,select,textarea').prop('required', false);
            } else {
                $('#identitas-keluarga').show();
                $('#identitas-keluarga input,select,textarea').prop('required', true);
            }
        });


        $('input[name="privasi_khusus[]"]').change(function() {
            let $this = $(this);
            let privasi = $this.val();
            let isChecked = $this.is(':checked');

            if (privasi == 'perawatan') {
                (isChecked) ? $('.form-group#privasi_perawatan_input').show(): $(
                    '.form-group#privasi_perawatan_input').hide();
            }

            if (privasi == 'lainnya') {
                (isChecked) ? $('.form-group#privasi_lainnya_input').show(): $('.form-group#privasi_lainnya_input')
                    .hide();
            }
        });
    </script>
@endpush
