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

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100 shadow-sm">
                    <div class="card-body">
                        <div class="px-3">
                            <h4 class="header-asesmen">Edit Penundaan Pelayanan</h4>
                        </div>

                        <div class="px-3">

                            {{-- Info Umum --}}
                            <div class="section-separator">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="text" name="tanggal" id="tanggal" class="form-control date"
                                        value="{{ date('Y-m-d', strtotime($penundaan->tanggal)) }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="jam">Jam</label>
                                    <input type="time" name="jam" id="jam" class="form-control"
                                        value="{{ date('H:i', strtotime($penundaan->jam)) }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="status_penerima_informasi">Penerima informasi</label>
                                    <select name="status_penerima_informasi" id="status_penerima_informasi"
                                        class="form-select" disabled>
                                        <option value="">--Pilih--</option>
                                        <option value="1" @selected($penundaan->status_penerima_informasi == 1)>Pasien sendiri</option>
                                        <option value="2" @selected($penundaan->status_penerima_informasi == 2)>Keluarga pasien</option>
                                        <option value="3" @selected($penundaan->status_penerima_informasi == 3)>Penanggungjawab pasien
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group" id="penerima-informasi-wrap">
                                    <label for="nama_penerima_informasi">Nama Penerima Informasi</label>
                                    <input type="text" class="form-control" id="nama_penerima_informasi"
                                        name="nama_penerima_informasi" value="{{ $penundaan->nama_penerima_informasi }}"
                                        disabled>
                                </div>

                                <div class="form-group">
                                    <label for="kd_dokter">Dokter Pengirim</label>
                                    <select name="kd_dokter" id="kd_dokter" class="form-select select2" disabled>
                                        <option value="">--Pilih--</option>
                                        @foreach ($dokter as $dok)
                                            <option value="{{ $dok->kd_dokter }}" @selected($penundaan->kd_dokter == $dok->kd_dokter)>
                                                {{ $dok->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="pelayanan_diberikan">Pelayanan yang akan diberikan</label>
                                    <input type="text" class="form-control" id="pelayanan_diberikan"
                                        name="pelayanan_diberikan" value="{{ $penundaan->pelayanan_diberikan }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label for="manfaat_risiko_alternatif">Manfaat/ risiko alternatif</label>
                                    <input type="text" class="form-control" id="manfaat_risiko_alternatif"
                                        name="manfaat_risiko_alternatif" value="{{ $penundaan->manfaat_risiko_alternatif }}"
                                        disabled>
                                </div>

                                <div class="form-group">
                                    <label for="risiko_penundaan">Risiko Penundaan</label>
                                    <input type="text" class="form-control" id="risiko_penundaan" name="risiko_penundaan"
                                        value="{{ $penundaan->risiko_penundaan }}" disabled>
                                </div>
                            </div>

                            {{-- PENYEBAB --}}
                            <div class="section-separator" id="identitas-keluarga">
                                <h4 class="fw-semibold">PENYEBAB</h4>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" id="penyebab_kerusakan_alat" class="form-check-input me-1"
                                            @checked(!empty($penundaan->penyebab_kerusakan_alat)) @checked(!empty($penundaan->penyebab_kerusakan_alat))>
                                        <label for="penyebab_kerusakan_alat">Kerusakan alat</label>
                                    </div>
                                    <input type="text" name="penyebab_kerusakan_alat" class="form-control"
                                        value="{{ $penundaan->penyebab_kerusakan_alat }}" disabled>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" id="penyebab_kondisi_umum_pasien"
                                            class="form-check-input me-1" @checked(!empty($penundaan->penyebab_kondisi_umum_pasien))>
                                        <label for="penyebab_kondisi_umum_pasien">Kondisi Umum Pasien</label>
                                    </div>
                                    <input type="text" name="penyebab_kondisi_umum_pasien" class="form-control"
                                        value="{{ $penundaan->penyebab_kondisi_umum_pasien }}" disabled>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" id="penyebab_penundaan_penjadwalan"
                                            class="form-check-input me-1" @checked(!empty($penundaan->penyebab_penundaan_penjadwalan))>
                                        <label for="penyebab_penundaan_penjadwalan">Penundaan Penjadwalan</label>
                                    </div>
                                    <input type="text" name="penyebab_penundaan_penjadwalan" class="form-control"
                                        value="{{ $penundaan->penyebab_penundaan_penjadwalan }}" disabled>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" id="penyebab_pemadaman_listrik"
                                            class="form-check-input me-1" @checked(!empty($penundaan->penyebab_pemadaman_listrik))>
                                        <label for="penyebab_pemadaman_listrik">Pemadaman Instalasi Listrik</label>
                                    </div>
                                    <input type="text" name="penyebab_pemadaman_listrik" class="form-control"
                                        value="{{ $penundaan->penyebab_pemadaman_listrik }}" disabled>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" id="penyebab_lainnya" class="form-check-input me-1"
                                            @checked(!empty($penundaan->penyebab_lainnya))>
                                        <label for="penyebab_lainnya">Penyebab Lainnya</label>
                                    </div>
                                    <input type="text" name="penyebab_lainnya" class="form-control"
                                        value="{{ $penundaan->penyebab_lainnya }}" disabled>
                                </div>
                            </div>

                            {{-- ALTERNATIF --}}
                            <div class="section-separator" id="identitas-keluarga">
                                <h4 class="fw-semibold">ALTERNATIF</h4>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" id="alternatif_jadwal_ulang" class="form-check-input me-1"
                                            @checked(!empty($penundaan->alternatif_tgl))>
                                        <label for="alternatif_jadwal_ulang">Jadwal Ulang</label>
                                    </div>
                                    <div class="d-flex">
                                        <input type="date" name="alternatif_tgl" class="form-control me-2 date"
                                            value="{{ date('Y-m-d', strtotime($penundaan->alternatif_tgl)) }}" disabled>
                                        <input type="time" name="alternatif_jam" class="form-control"
                                            value="{{ date('H:i', strtotime($penundaan->alternatif_jam)) }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" id="alternatif_rujuk" class="form-check-input me-1"
                                            @checked(!empty($penundaan->alternatif_rujuk))>
                                        <label for="alternatif_rujuk">Rujuk Ke Faskes Lain</label>
                                    </div>
                                    <input type="text" name="alternatif_rujuk" class="form-control"
                                        value="{{ $penundaan->alternatif_rujuk }}" disabled>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" name="alternatif_kembali" id="alternatif_kembali"
                                            class="form-check-input me-1" @checked(!empty($penundaan->alternatif_kembali)) value="1"
                                            disabled>
                                        <label for="alternatif_kembali">Dikembalikan ke dokter pengirim</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="checkbox" id="alternatif_lainnya" class="form-check-input me-1"
                                            @checked(!empty($penundaan->alternatif_lainnya))>
                                        <label for="alternatif_lainnya">Alternatif lain</label>
                                    </div>
                                    <input type="text" name="alternatif_lainnya" class="form-control"
                                        value="{{ $penundaan->alternatif_lainnya }}" disabled>
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
            let statusPenerima = {{ $penundaan->status_penerima_informasi }};

            if (statusPenerima == 1) {
                $('#penerima-informasi-wrap').hide();
            }
        });
    </script>
@endpush
