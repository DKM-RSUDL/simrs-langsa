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

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .form-row label {
            min-width: 200px;
            margin-bottom: 0;
            margin-right: 1rem;
        }

        .form-row .form-control {
            flex: 1;
        }

        .checkbox-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .section-header {
            background-color: #f8f9fa;
            padding: 0.5rem;
            font-weight: 600;
            text-align: center;
            border: 1px solid #dee2e6;
            margin-bottom: 1rem;
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
            <form id="hemodialisisForm" method="POST" action="#">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen">Form Data Pasien Hemodialisis</h4>
                            </div>

                            <!-- DATA PASIEN -->
                            <div class="px-3">
                                <div class="section-separator">
                                    <div class="section-header">DATA PASIEN</div>

                                    <div class="form-row">
                                        <label for="nama_lengkap">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <div class="checkbox-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    id="laki_laki" value="L" required>
                                                <label class="form-check-label" for="laki_laki">Laki-laki</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    id="perempuan" value="P" required>
                                                <label class="form-check-label" for="perempuan">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <label for="agama">Agama</label>
                                        <input type="text" name="agama" id="agama" class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="tanggal_lahir">Tanggal Lahir/ Usia</label>
                                        <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="pendidikan">Pendidikan</label>
                                        <input type="text" name="pendidikan" id="pendidikan" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="status_pernikahan">Status Pernikahan</label>
                                        <input type="text" name="status_pernikahan" id="status_pernikahan"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="alamat_lengkap">Alamat lengkap</label>
                                        <input type="text" name="alamat_lengkap" id="alamat_lengkap" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="rt_rw">RT/ RW</label>
                                        <input type="text" name="rt_rw" id="rt_rw" class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="desa_kelurahan">Desa/ Kelurahan</label>
                                        <input type="text" name="desa_kelurahan" id="desa_kelurahan" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" name="kecamatan" id="kecamatan" class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="kab_kota">Kab/ Kota</label>
                                        <input type="text" name="kab_kota" id="kab_kota" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="provinsi">Provinsi</label>
                                        <input type="text" name="provinsi" id="provinsi" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="no_telpon">No Telpon/ HP</label>
                                        <input type="text" name="no_telpon" id="no_telpon" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="no_identitas">No Identitas</label>
                                        <input type="text" name="no_identitas" id="no_identitas" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="no_kartu_bpjs">No Kartu BPJS</label>
                                        <input type="text" name="no_kartu_bpjs" id="no_kartu_bpjs"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="riwayat_alergi">Riwayat alergi</label>
                                        <input type="text" name="riwayat_alergi" id="riwayat_alergi"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <!-- IDENTITAS PENANGGUNG JAWAB PASIEN -->
                            <div class="px-3">
                                <div class="section-separator">
                                    <div class="section-header">IDENTITAS PENANGGUNG JAWAB PASIEN</div>

                                    <div class="form-row">
                                        <label for="nama_penanggung_jawab">Nama</label>
                                        <input type="text" name="nama_penanggung_jawab" id="nama_penanggung_jawab"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="hubungan_keluarga">Hubungan keluarga</label>
                                        <input type="text" name="hubungan_keluarga" id="hubungan_keluarga"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="alamat_penanggung_jawab">Alamat</label>
                                        <input type="text" name="alamat_penanggung_jawab" id="alamat_penanggung_jawab"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="pekerjaan_penanggung_jawab">Pekerjaan</label>
                                        <input type="text" name="pekerjaan_penanggung_jawab"
                                            id="pekerjaan_penanggung_jawab" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <!-- DATA HEMODIALISIS -->
                            <div class="px-3">
                                <div class="section-separator">
                                    <div class="section-header">DATA HEMODIALISIS (Diisi petugas HD)</div>

                                    <div class="form-row">
                                        <label for="hd_pertama_kali">HD pertama kali tanggal</label>
                                        <input type="date" name="hd_pertama_kali" id="hd_pertama_kali"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="mulai_hd_rutin">Mulai HD rutin tanggal</label>
                                        <input type="date" name="mulai_hd_rutin" id="mulai_hd_rutin"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="frekuensi_hd">Frekuensi HD</label>
                                        <input type="text" name="frekuensi_hd" id="frekuensi_hd" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="status_pembayaran">Status pembayaran</label>
                                        <input type="text" name="status_pembayaran" id="status_pembayaran"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="dokter_pengirim">Dokter pengirim</label>
                                        <input type="text" name="dokter_pengirim" id="dokter_pengirim"
                                            class="form-control" required>
                                    </div>

                                    <div class="form-row">
                                        <label for="asal_rujukan">Asal rujukan</label>
                                        <input type="text" name="asal_rujukan" id="asal_rujukan" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="diagnosis">Diagnosis</label>
                                        <input type="text" name="diagnosis" id="diagnosis" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="etiologi">Etiologi</label>
                                        <input type="text" name="etiologi" id="etiologi" class="form-control"
                                            required>
                                    </div>

                                    <div class="form-row">
                                        <label for="penyakit_penyerta">Penyakit penyerta</label>
                                        <input type="text" name="penyakit_penyerta" id="penyakit_penyerta"
                                            class="form-control" required>
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
