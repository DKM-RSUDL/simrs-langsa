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
                action="{{ route('rawat-inap.anestesi-sedasi.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, encrypt($anestesi->id)]) }}">
                @csrf
                @method('put')

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Edit Persetujuan Anestesi dan Sedasi</h4>
                            </div>

                            <div class="px-3">
                                {{-- Info Umum --}}
                                <div class="section-separator">
                                    <div class="form-group">
                                        <label for="tanggal">Tanggal</label>
                                        <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                            value="{{ date('Y-m-d', strtotime($anestesi->tanggal)) }}" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="jam">Jam</label>
                                        <input type="time" name="jam" id="jam" class="form-control"
                                            value="{{ date('H:i', strtotime($anestesi->jam)) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="kd_dokter">Dokter</label>
                                        <select name="kd_dokter" id="kd_dokter" class="form-select select2" required>
                                            <option value="">--Pilih--</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}" @selected($dok->kd_dokter == $anestesi->kd_dokter)>
                                                    {{ $dok->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_saksi_keluarga">Nama Saksi Keluarga</label>
                                        <input type="text" class="form-control" id="nama_saksi_keluarga"
                                            name="nama_saksi_keluarga" value="{{ $anestesi->nama_saksi_keluarga }}"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label for="nama_saksi">Nama Saksi</label>
                                        <input type="text" class="form-control" id="nama_saksi" name="nama_saksi"
                                            value="{{ $anestesi->nama_saksi }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="status_keluarga" style="min-width: 200px;">Status Pasien dgn
                                            Keluarga</label>
                                        <select name="status_keluarga" id="status_keluarga" class="form-select" required>
                                            <option value="">--Pilih--</option>
                                            <option value="1" @selected($anestesi->status_keluarga == 1)>Diri sendiri</option>
                                            <option value="2" @selected($anestesi->status_keluarga == 2)>Istri</option>
                                            <option value="3" @selected($anestesi->status_keluarga == 3)>Suami</option>
                                            <option value="4" @selected($anestesi->status_keluarga == 4)>Anak</option>
                                            <option value="5" @selected($anestesi->status_keluarga == 5)>Ayah</option>
                                            <option value="6" @selected($anestesi->status_keluarga == 6)>Ibu</option>
                                            <option value="7" @selected($anestesi->status_keluarga == 7)>Lain-lain</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- IDENTITAS KELUARGA --}}
                                <div class="section-separator" id="identitas-keluarga">
                                    <h4 class="fw-semibold">IDENTITAS KELUARGA</h4>

                                    <div class="form-group">
                                        <label for="keluarga_nama" style="min-width: 200px;">Nama</label>
                                        <input type="text" name="keluarga_nama" id="keluarga_nama" class="form-control"
                                            value="{{ $anestesi->keluarga_nama }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="keluarga_usia" style="min-width: 200px;">Usia (tahun)</label>
                                        <input type="number" name="keluarga_usia" id="keluarga_usia" class="form-control"
                                            value="{{ $anestesi->keluarga_usia }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="keluarga_jenis_kelamin" style="min-width: 200px;">Jenis
                                            Kelamin</label>
                                        <select name="keluarga_jenis_kelamin" id="keluarga_jenis_kelamin"
                                            class="form-select" required>
                                            <option value="">--Pilih--</option>
                                            <option value="0" @selected($anestesi->keluarga_jenis_kelamin == 0)>Perempuan</option>
                                            <option value="1" @selected($anestesi->keluarga_jenis_kelamin == 1)>Laki-Laki</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="keluarga_alamat" style="min-width: 200px;">Alamat</label>
                                        <textarea name="keluarga_alamat" id="keluarga_alamat" class="form-control" required>{{ $anestesi->keluarga_alamat }}</textarea>
                                    </div>
                                </div>

                                {{-- TINDAKAN --}}
                                <div class="section-separator"">
                                    <h4 class="fw-semibold">TINDAKAN ANESTESI</h4>

                                    <div class="form-group">
                                        <div class="d-flex">
                                            <label style="min-width: 200px;">Tindakan</label>
                                            <div class="">
                                                <div class="">
                                                    <input type="checkbox" name="tindakan[]" id="umum"
                                                        class="form-check-input" value="Anestesi Umum"
                                                        @checked(in_array('Anestesi Umum', $anestesi->tindakan))>
                                                    <label for="umum">Anestesi Umum</label>
                                                </div>
                                                <div class="">
                                                    <input type="checkbox" name="tindakan[]" id="kombinasi"
                                                        class="form-check-input" value="Kombinasi Spinal-Epidural"
                                                        @checked(in_array('Kombinasi Spinal-Epidural', $anestesi->tindakan))>
                                                    <label for="kombinasi">Kombinasi Spinal-Epidural</label>
                                                </div>
                                                <div class="">
                                                    <input type="checkbox" name="tindakan[]" id="sedasi"
                                                        class="form-check-input" value="Sedasi"
                                                        @checked(in_array('Sedasi', $anestesi->tindakan))>
                                                    <label for="sedasi">Sedasi</label>
                                                </div>
                                                <div class="">
                                                    <input type="checkbox" name="tindakan[]" id="kaudal"
                                                        class="form-check-input" value="Anestesi Kaudal"
                                                        @checked(in_array('Anestesi Kaudal', $anestesi->tindakan))>
                                                    <label for="kaudal">Anestesi Kaudal</label>
                                                </div>
                                                <div class="">
                                                    <input type="checkbox" name="tindakan[]" id="spinal"
                                                        class="form-check-input" value="Anestesi Spinal"
                                                        @checked(in_array('Anestesi Spinal', $anestesi->tindakan))>
                                                    <label for="spinal">Anestesi Spinal</label>
                                                </div>
                                                <div class="">
                                                    <input type="checkbox" name="tindakan[]" id="saraf"
                                                        class="form-check-input" value="Blok Saraf Perifer"
                                                        @checked(in_array('Blok Saraf Perifer', $anestesi->tindakan))>
                                                    <label for="saraf">Blok Saraf Perifer</label>
                                                </div>
                                                <div class="">
                                                    <input type="checkbox" name="tindakan[]" id="epidural"
                                                        class="form-check-input" value="Anestesi Epidural"
                                                        @checked(in_array('Anestesi Epidural', $anestesi->tindakan))>
                                                    <label for="epidural">Anestesi Epidural</label>
                                                </div>
                                                <div class="">
                                                    <input type="checkbox" name="tindakan[]" id="lainnya"
                                                        class="form-check-input" value="Lain-lain"
                                                        @checked(in_array('Lain-lain', $anestesi->tindakan))>
                                                    <label for="lainnya">Lain-lain</label>
                                                    <input type="text" class="form-control" name="tindakan_lainnya"
                                                        id="tindakan_lainnya"
                                                        value="{{ in_array('Lain-lain', $anestesi->tindakan) ? $anestesi->tindakan_lainnya : '' }}"
                                                        {{ in_array('Lain-lain', $anestesi->tindakan) ? '' : 'disabled' }}>
                                                </div>
                                            </div>
                                        </div>
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

            let statusKlg = {{ $anestesi->status_keluarga }}

            if (statusKlg == 1) {
                $('#identitas-keluarga').hide();
                $('#identitas-keluarga input,select,textarea').prop('required', false);
            }
        });

        $('#status_keluarga').change(function() {
            let nilai = $(this).val();

            if (nilai == 1) {
                $('#identitas-keluarga').hide();
                $('#identitas-keluarga input,select,textarea').prop('required', false);
            } else {
                $('#identitas-keluarga').show();
                $('#identitas-keluarga input,select,textarea').prop('required', true);
            }
        });

        $('#lainnya').change(function() {
            let $this = $(this);

            if ($this.is(':checked')) {
                $('#tindakan_lainnya').prop('disabled', false);
                $('#tindakan_lainnya').prop('required', true);
            } else {
                $('#tindakan_lainnya').prop('disabled', true);
                $('#tindakan_lainnya').prop('required', false);
            }
        });
    </script>
@endpush
