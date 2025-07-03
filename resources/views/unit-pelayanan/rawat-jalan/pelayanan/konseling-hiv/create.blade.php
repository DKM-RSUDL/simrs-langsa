@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .card-header {
                font-weight: bold;
            }

            .form-label {
                font-weight: 600;
                margin-bottom: 0.3rem;
            }

            .required::after {
                content: '*';
                color: red;
                margin-left: 0.2rem;
            }

            .invalid-feedback {
                display: none;
            }

            .is-invalid~.invalid-feedback {
                display: block;
            }

            .form-section {
                max-width: 100%;
            }

            .hidden {
                display: none;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Konseling HIV</h5>
            </div>

            <hr>

            <div class="form-section">
                <form action="" method="post" id="konselingHIVForm">
                    @csrf

                    <!-- Form Date and Time Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <small class="text-warning">
                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                            Pastikan jam diisi dengan benar untuk keakuratan dokumentasi medis
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold required">Tanggal Implementasi</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="tgl_implementasi"
                                                id="tgl_implementasi" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold required">Jam Implementasi</label>
                                        <div class="input-group">
                                            <input type="time" class="form-control" name="jam_implementasi" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Status Kunjungan</label>
                                        <select class="form-select" name="status_kunjungan">
                                            <option value="">Pilih Status</option>
                                            <option value="datang_sendiri">Datang Sendiri</option>
                                            <option value="dirujuk">Dirujuk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Status Rujukan</label>
                                        <select class="form-select" name="status_rujukan">
                                            <option value="">Pilih Status</option>
                                            <option value="tempat_kerja">Tempat Kerja</option>
                                            <option value="klp_dukungan">Klp DUkungan</option>
                                            <option value="pasangan">Pasangan</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-122">
                                    <div class="mb-3">
                                        <label class="form-label">Pasien Warga Binaan Pemasyarakatan (WBP) ?</label>
                                        <select class="form-select" name="warga_binaan">
                                            <option value="">Pilih Jawaban</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Reproduksi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Status Reproduksi</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Status Kehamilan</label>
                                        <select class="form-select" name="status_kehamilan" required>
                                            <option value="">Pilih Status</option>
                                            <option value="trimester_1">Trimester I</option>
                                            <option value="trimester_2">Trimester II</option>
                                            <option value="trimester_3">Trimester III</option>
                                            <option value="tidak_hamil">Tidak Hamil</option>
                                            <option value="tidak_tahu">Tidak Tahu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Umur Anak Terakhir (tahun)</label>
                                        <input type="number" class="form-control" name="umur_anak_terakhir" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah Anak Kandung</label>
                                        <input type="number" class="form-control" name="jumlah_anak_kandung" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pasangan Klien -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Informasi Pasangan Klien</h6>
                        </div>
                        <div class="card-body">
                            <!-- Jenis Kelamin Pasien -->
                            <div class="mb-3">
                                <label class="form-label required">Jenis Kelamin Pasien</label>
                                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="perempuan">Perempuan</option>
                                    <option value="laki_laki">Laki-laki</option>
                                </select>
                            </div>

                            <!-- Section untuk Pasien Perempuan -->
                            <div id="section_perempuan" class="hidden">
                                <div class="mb-3">
                                    <label class="form-label">Pasien memiliki pasangan tetap?</label>
                                    <select class="form-select" name="pasangan_tetap" id="pasangan_tetap">
                                        <option value="">Pilih Jawaban</option>
                                        <option value="ya">Ya</option>
                                        <option value="tidak">Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kelompok Risiko</label>
                                    <select class="form-select" name="kelompok_risiko" id="kelompok_risiko">
                                        <option value="">Pilih Kelompok Risiko</option>
                                        <option value="ps">PS (Pekerja Seks)</option>
                                        <option value="waria">Waria</option>
                                        <option value="pasangan_risti">Pasangan Risti</option>
                                        <option value="penasun">Penasun</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>

                                <div id="jenis_ps_section" class="mb-3 hidden">
                                    <label class="form-label">Jenis PS</label>
                                    <select class="form-select" name="jenis_ps" id="jenis_ps">
                                        <option value="">Pilih Jenis PS</option>
                                        <option value="langsung">Langsung</option>
                                        <option value="tidak_langsung">Tidak Langsung</option>
                                        <option value="pelanggan_ps">Pelanggan PS</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Section untuk Pasien Laki-laki -->
                            <div id="section_laki_laki" class="hidden">
                                <div class="mb-3">
                                    <label class="form-label">Punya pasangan perempuan?</label>
                                    <select class="form-select" name="pasangan_perempuan" id="pasangan_perempuan">
                                        <option value="">Pilih Jawaban</option>
                                        <option value="ya">Ya</option>
                                        <option value="tidak">Tidak</option>
                                    </select>
                                </div>

                                <div id="detail_pasangan_perempuan" class="hidden">
                                    <div class="mb-3">
                                        <label class="form-label">Apakah pasangan hamil?</label>
                                        <select class="form-select" name="pasangan_hamil" id="pasangan_hamil">
                                            <option value="">Pilih Jawaban</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                            <option value="tidak_tahu">Tidak Tahu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Pasangan (Tampil untuk kedua jenis kelamin) -->
                            <div id="detail_pasangan_common" class="hidden">
                                <hr class="my-3">
                                <h6 class="mb-3 text-primary">Detail Pasangan</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir Pasangan</label>
                                            <input type="date" class="form-control" name="tgl_lahir_pasangan">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Status HIV Pasangan</label>
                                            <select class="form-select" name="status_hiv_pasangan">
                                                <option value="">Pilih Status</option>
                                                <option value="positif">HIV Positif</option>
                                                <option value="negatif">HIV Negatif</option>
                                                <option value="tidak_tahu">Tidak Tahu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Tes Terakhir Pasangan</label>
                                            <input type="date" class="form-control" name="tgl_tes_terakhir_pasangan">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Konseling Pra Tes -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Konseling Pra Tes</h6>
                            <small class="text-muted">(Silakan bila dilakukan konseling /KTS)</small>
                        </div>
                        <div class="card-body">
                            <!-- Tanggal Konseling dan Status Klien -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Konseling Pra Tes HIV</label>
                                        <input type="date" class="form-control" name="tgl_konseling_pra_tes">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status Klien</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_klien" id="status_baru" value="baru">
                                                <label class="form-check-label" for="status_baru">Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_klien" id="status_lama" value="lama">
                                                <label class="form-check-label" for="status_lama">Lama</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alasan Tes HIV -->
                            <div class="mb-3">
                                <label class="form-label">Alasan Tes HIV (boleh diisi lebih dari satu)</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="ingin_tahu" value="ingin_tahu_saja">
                                            <label class="form-check-label" for="ingin_tahu">Ingin tahu saja</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="untuk_bekerja" value="untuk_bekerja">
                                            <label class="form-check-label" for="untuk_bekerja">Untuk bekerja</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="merasa_beresiko" value="merasa_beresiko">
                                            <label class="form-check-label" for="merasa_beresiko">Merasa beresiko</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="lainnya_alasan" value="lainnya">
                                            <label class="form-check-label" for="lainnya_alasan">Lainnya</label>
                                        </div>
                                        <input type="text" class="form-control mt-1" name="alasan_tes_lainnya" placeholder="Sebutkan...">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="mumpung_gratis" value="mumpung_gratis">
                                            <label class="form-check-label" for="mumpung_gratis">Mumpung gratis</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="ada_gejala" value="ada_gejala_tertentu">
                                            <label class="form-check-label" for="ada_gejala">Ada gejala tertentu</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="tes_ulang" value="tes_ulang_window_period">
                                            <label class="form-check-label" for="tes_ulang">Tes ulang (window period)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="akan_menikah" value="akan_menikah">
                                            <label class="form-check-label" for="akan_menikah">Akan menikah</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mengetahui Adanya Tes -->
                            <div class="mb-3">
                                <label class="form-label">Mengetahui Adanya Tes Dari (Pilih satu yang paling dominan)</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="brosur" value="brosur">
                                            <label class="form-check-label" for="brosur">Brosur</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="petugas_outreach" value="petugas_outreach">
                                            <label class="form-check-label" for="petugas_outreach">Petugas Outreach</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="koran" value="koran">
                                            <label class="form-check-label" for="koran">Koran</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="poster" value="poster">
                                            <label class="form-check-label" for="poster">Poster</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="tv" value="tv">
                                            <label class="form-check-label" for="tv">TV</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="lay_konselor" value="lay_konselor">
                                            <label class="form-check-label" for="lay_konselor">Lay Konselor</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="petugas_kesehatan" value="petugas_kesehatan">
                                            <label class="form-check-label" for="petugas_kesehatan">Petugas Kesehatan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="teman" value="teman">
                                            <label class="form-check-label" for="teman">Teman</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="lainnya_info" value="lainnya">
                                            <label class="form-check-label" for="lainnya_info">Lainnya</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kajian Tingkat Risiko -->
                            <div class="mb-4">
                                <h6 class="mb-3 text-primary">Kajian Tingkat Risiko:</h6>
                                
                                <!-- Hubungan Seks Vaginal Berisiko -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Hubungan Seks Vaginal Berisiko</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="seks_vaginal_berisiko" id="seks_vaginal_ya" value="ya">
                                                <label class="form-check-label" for="seks_vaginal_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="seks_vaginal_kapan" style="width: 100px;">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="seks_vaginal_berisiko" id="seks_vaginal_tidak" value="tidak">
                                                <label class="form-check-label" for="seks_vaginal_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Anal Seks Berisiko</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="anal_seks_berisiko" id="anal_seks_ya" value="ya">
                                                <label class="form-check-label" for="anal_seks_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="anal_seks_kapan" style="width: 100px;">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="anal_seks_berisiko" id="anal_seks_tidak" value="tidak">
                                                <label class="form-check-label" for="anal_seks_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bergantian Peralatan Suntik -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Bergantian Peralatan Suntik</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="bergantian_suntik" id="bergantian_suntik_ya" value="ya">
                                                <label class="form-check-label" for="bergantian_suntik_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="bergantian_suntik_kapan" style="width: 100px;">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="bergantian_suntik" id="bergantian_suntik_tidak" value="tidak">
                                                <label class="form-check-label" for="bergantian_suntik_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Transfusi Darah</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transfusi_darah" id="transfusi_darah_ya" value="ya">
                                                <label class="form-check-label" for="transfusi_darah_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="transfusi_darah_kapan" style="width: 100px;">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transfusi_darah" id="transfusi_darah_tidak" value="tidak">
                                                <label class="form-check-label" for="transfusi_darah_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transmisi Ibu ke Anak -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Transmisi Ibu ke Anak</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transmisi_ibu_anak" id="transmisi_ibu_anak_ya" value="ya">
                                                <label class="form-check-label" for="transmisi_ibu_anak_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="transmisi_ibu_anak_kapan" style="width: 100px;">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transmisi_ibu_anak" id="transmisi_ibu_anak_tidak" value="tidak">
                                                <label class="form-check-label" for="transmisi_ibu_anak_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lainnya (Sebutkan)</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <input type="text" class="form-control" name="lainnya_risiko" placeholder="Sebutkan...">
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="lainnya_risiko_kapan" style="width: 100px;">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Periode Jendela dan Kesediaan untuk Tes -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Periode Jendela (window periode)</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="periode_jendela" id="periode_jendela_ya" value="ya">
                                                <label class="form-check-label" for="periode_jendela_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="periode_jendela_kapan" style="width: 100px;">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="periode_jendela" id="periode_jendela_tidak" value="tidak">
                                                <label class="form-check-label" for="periode_jendela_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kesediaan untuk Tes</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesediaan_tes" id="kesediaan_tes_ya" value="ya">
                                                <label class="form-check-label" for="kesediaan_tes_ya">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesediaan_tes" id="kesediaan_tes_tidak" value="tidak">
                                                <label class="form-check-label" for="kesediaan_tes_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pernah Tes HIV Sebelumnya -->
                            <div class="mb-3">
                                <label class="form-label">Pernah Tes HIV Sebelumnya</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex gap-3 align-items-center mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pernah_tes_hiv" id="pernah_tes_ya" value="ya">
                                                <label class="form-check-label" for="pernah_tes_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Dimana:</span>
                                                <input type="text" class="form-control" name="pernah_tes_dimana" style="width: 150px;">
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pernah_tes_hiv" id="pernah_tes_tidak" value="tidak">
                                            <label class="form-check-label" for="pernah_tes_tidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span>Kapan:</span>
                                            <input type="text" class="form-control" name="pernah_tes_kapan" style="width: 120px;">
                                            <span>Hr/Bln/Thn*</span>
                                        </div>
                                        <div class="mb-2">
                                            <span>Hasil:</span>
                                            <div class="d-flex gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_tes_sebelumnya" id="hasil_non_reaktif" value="non_reaktif">
                                                    <label class="form-check-label" for="hasil_non_reaktif">Non Reaktif</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_tes_sebelumnya" id="hasil_reaktif" value="reaktif">
                                                    <label class="form-check-label" for="hasil_reaktif">Reaktif</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_tes_sebelumnya" id="hasil_tidak_tahu" value="tidak_tahu">
                                                    <label class="form-check-label" for="hasil_tidak_tahu">Tidak tahu</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Pemberian Informasi -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Pemberian Informasi</h6>
                            <small class="text-muted">(Silakan bila penawaran tes oleh petugas kesehatan /TIPK)</small>
                        </div>
                        <div class="card-body">
                            <!-- Tanggal Pemberian Informasi -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Pemberian Informasi</label>
                                        <input type="date" class="form-control" name="tgl_pemberian_informasi">
                                    </div>
                                </div>
                            </div>

                            <!-- Pernah Tes HIV Sebelumnya -->
                            <div class="mb-3">
                                <label class="form-label">Pernah Tes HIV Sebelumnya (* coret yang tidak perlu)</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex gap-3 align-items-center mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="pernah_tes_hiv_tipk" id="pernah_tes_ya_tipk" value="ya">
                                                <label class="form-check-label" for="pernah_tes_ya_tipk">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Dimana:</span>
                                                <input type="text" class="form-control" name="pernah_tes_dimana_tipk" style="width: 150px;">
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pernah_tes_hiv_tipk" id="pernah_tes_tidak_tipk" value="tidak">
                                            <label class="form-check-label" for="pernah_tes_tidak_tipk">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span>Kapan:</span>
                                            <input type="text" class="form-control" name="pernah_tes_kapan_tipk" style="width: 120px;">
                                            <span>Hr/Bln/Thn*</span>
                                        </div>
                                        <div class="mb-2">
                                            <span>Hasil:</span>
                                            <div class="d-flex gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_tes_sebelumnya_tipk" id="hasil_non_reaktif_tipk" value="non_reaktif">
                                                    <label class="form-check-label" for="hasil_non_reaktif_tipk">Non Reaktif</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_tes_sebelumnya_tipk" id="hasil_reaktif_tipk" value="reaktif">
                                                    <label class="form-check-label" for="hasil_reaktif_tipk">Reaktif</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_tes_sebelumnya_tipk" id="hasil_tidak_tahu_tipk" value="tidak_tahu">
                                                    <label class="form-check-label" for="hasil_tidak_tahu_tipk">Tidak tahu</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Penyakit Terkait Pasien -->
                            <div class="mb-3">
                                <label class="form-label">Penyakit Terkait Pasien (boleh diisi lebih dari satu)</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_tb" value="tb">
                                            <label class="form-check-label" for="penyakit_tb">TB</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_diare" value="diare">
                                            <label class="form-check-label" for="penyakit_diare">Diare</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_kandidiasis" value="kandidiasis_oraesovaginal">
                                            <label class="form-check-label" for="penyakit_kandidiasis">Kandidiasis oraesovaginal</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_dermatitis" value="dermatitis">
                                            <label class="form-check-label" for="penyakit_dermatitis">Dermatitis</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_lgv" value="lgv">
                                            <label class="form-check-label" for="penyakit_lgv">LGV</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_pcp" value="pcp">
                                            <label class="form-check-label" for="penyakit_pcp">PCP</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_herpes" value="herpes">
                                            <label class="form-check-label" for="penyakit_herpes">Herpes</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_toxoplasmosis" value="toxoplasmosis">
                                            <label class="form-check-label" for="penyakit_toxoplasmosis">Toxoplasmosis</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_wasting" value="wasting_syndrome">
                                            <label class="form-check-label" for="penyakit_wasting">Wasting syndrome</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_sifilis" value="sifilis">
                                            <label class="form-check-label" for="penyakit_sifilis">Sifilis</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_ims_lainnya" value="ims_lainnya">
                                            <label class="form-check-label" for="penyakit_ims_lainnya">IMS lainnya</label>
                                        </div>
                                        <input type="text" class="form-control mb-2" name="ims_lainnya_detail" placeholder="Sebutkan IMS lainnya...">
                                        
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_hepatitis" value="hepatitis">
                                            <label class="form-check-label" for="penyakit_hepatitis">Hepatitis</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="penyakit_terkait[]" id="penyakit_lainnya" value="lainnya">
                                            <label class="form-check-label" for="penyakit_lainnya">Lainnya</label>
                                        </div>
                                        <input type="text" class="form-control" name="penyakit_lainnya_detail" placeholder="Sebutkan penyakit lainnya...">
                                    </div>
                                </div>
                            </div>

                            <!-- Kesediaan untuk Tes -->
                            <div class="mb-3">
                                <label class="form-label">Kesediaan untuk Tes</label>
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kesediaan_tes_tipk" id="kesediaan_tes_ya_tipk" value="ya">
                                        <label class="form-check-label" for="kesediaan_tes_ya_tipk">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="kesediaan_tes_tipk" id="kesediaan_tes_tidak_tipk" value="tidak">
                                        <label class="form-check-label" for="kesediaan_tes_tidak_tipk">Tidak</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tes Antibodi HIV -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Tes Antibodi HIV</h6>
                        </div>
                        <div class="card-body">
                            <!-- Tanggal Tes HIV dan Jenis Tes -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Tes HIV (Tgl/Bln/Thn)</label>
                                        <input type="date" class="form-control" name="tgl_tes_hiv">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Tes HIV</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_tes_hiv" id="rapid_test" value="rapid_test">
                                                <label class="form-check-label" for="rapid_test">Rapid Test</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_tes_hiv" id="elisa" value="elisa">
                                                <label class="form-check-label" for="elisa">ELISA</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hasil Tes R1 -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Hasil Tes R1</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_tes_r1" id="r1_non_reaktif" value="non_reaktif">
                                            <label class="form-check-label" for="r1_non_reaktif">Non Reaktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_tes_r1" id="r1_reaktif" value="reaktif">
                                            <label class="form-check-label" for="r1_reaktif">Reaktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label">Nama Reagen</label>
                                    <input type="text" class="form-control" name="nama_reagen_r1" placeholder="Masukkan nama reagen R1">
                                </div>
                            </div>

                            <!-- Hasil Tes R2 -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Hasil Tes R2</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_tes_r2" id="r2_non_reaktif" value="non_reaktif">
                                            <label class="form-check-label" for="r2_non_reaktif">Non Reaktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_tes_r2" id="r2_reaktif" value="reaktif">
                                            <label class="form-check-label" for="r2_reaktif">Reaktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label">Nama Reagen</label>
                                    <input type="text" class="form-control" name="nama_reagen_r2" placeholder="Masukkan nama reagen R2">
                                </div>
                            </div>

                            <!-- Hasil Tes R3 -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Hasil Tes R3</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_tes_r3" id="r3_non_reaktif" value="non_reaktif">
                                            <label class="form-check-label" for="r3_non_reaktif">Non Reaktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_tes_r3" id="r3_reaktif" value="reaktif">
                                            <label class="form-check-label" for="r3_reaktif">Reaktif</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label">Nama Reagen</label>
                                    <input type="text" class="form-control" name="nama_reagen_r3" placeholder="Masukkan nama reagen R3">
                                </div>
                            </div>

                            <!-- Kesimpulan Hasil Test HIV -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Kesimpulan Hasil Test HIV</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kesimpulan_hasil_tes" id="kesimpulan_non_reaktif" value="non_reaktif">
                                            <label class="form-check-label" for="kesimpulan_non_reaktif">Non Reaktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kesimpulan_hasil_tes" id="kesimpulan_reaktif" value="reaktif">
                                            <label class="form-check-label" for="kesimpulan_reaktif">Reaktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kesimpulan_hasil_tes" id="kesimpulan_indeterminate" value="indeterminate">
                                            <label class="form-check-label" for="kesimpulan_indeterminate">Indeterminate</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nomor Registrasi Nasional PDP dan Tanggal Masuk PDP -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Registrasi Nasional PDP</label>
                                        <small class="text-muted d-block">(Diisi bila hasil tes positif)</small>
                                        <input type="text" class="form-control" name="nomor_registrasi_pdp" placeholder="Masukkan nomor registrasi">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tgl Masuk PDP</label>
                                        <small class="text-muted d-block">(dd/mm/yyyy)</small>
                                        <input type="date" class="form-control" name="tgl_masuk_pdp">
                                    </div>
                                </div>
                            </div>

                            <!-- Tindak Lanjut -->
                            <div class="mb-3">
                                <label class="form-label">Tindak Lanjut (TIPK)</label>
                                <small class="text-muted d-block">(boleh diisi lebih dari satu)</small>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut[]" id="rujuk_konseling" value="rujuk_konseling">
                                            <label class="form-check-label" for="rujuk_konseling">Rujuk konseling</label>
                                        </div>
                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tindak_lanjut[]" id="rujuk_ke_lain" value="rujuk_ke">
                                                <label class="form-check-label" for="rujuk_ke_lain">Rujuk ke</label>
                                            </div>
                                            <input type="text" class="form-control mt-1" name="rujuk_ke_detail" placeholder="Sebutkan tempat rujukan...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut[]" id="rujuk_pdp_ppia" value="rujuk_pdp_ppia">
                                            <label class="form-check-label" for="rujuk_pdp_ppia">Rujuk ke PDP dan PPIA</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Bagaimana Status HIV Pasangan</label>
                                    <select class="form-select" name="bagaimana_status_hiv_pasangan">
                                        <option value="">Pilih Status</option>
                                        <option value="hiv_minus">HIV (-)</option>
                                        <option value="hiv_plus">HIV (+)</option>
                                        <option value="tidak_tahu">Tidak Tahu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Konseling Pasca Tes -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Konseling Pasca Tes</h6>
                        </div>
                        <div class="card-body">
                            <!-- Tanggal Konseling Pasca Tes -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Konseling Pasca Tes (Tgl/Bln/Thn)</label>
                                        <input type="date" class="form-control" name="tgl_konseling_pasca_tes">
                                    </div>
                                </div>
                            </div>

                            <!-- Terima Hasil dan Kaji Gejala TB -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Terima Hasil</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="terima_hasil" id="terima_hasil_ya" value="ya">
                                            <label class="form-check-label" for="terima_hasil_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="terima_hasil" id="terima_hasil_tidak" value="tidak">
                                            <label class="form-check-label" for="terima_hasil_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kaji Gejala TB</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kaji_gejala_tb" id="kaji_gejala_ya" value="ya">
                                            <label class="form-check-label" for="kaji_gejala_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kaji_gejala_tb" id="kaji_gejala_tidak" value="tidak">
                                            <label class="form-check-label" for="kaji_gejala_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah Kondom yang Diberikan</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="jumlah_kondom" min="0">
                                        <span class="input-group-text">Buah</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tindak Lanjut (KTS) -->
                            <div class="mb-3">
                                <label class="form-label">Tindak Lanjut (KTS)</label>
                                <small class="text-muted d-block">(boleh diisi lebih dari satu)</small>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="tes_ulang" value="tes_ulang">
                                            <label class="form-check-label" for="tes_ulang">Tes ulang</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_pdp" value="rujuk_pdp">
                                            <label class="form-check-label" for="rujuk_pdp">Rujuk ke PDP</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_ptrm" value="rujuk_ptrm">
                                            <label class="form-check-label" for="rujuk_ptrm">Rujuk ke Layanan PTRM</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_ims" value="rujuk_ims">
                                            <label class="form-check-label" for="rujuk_ims">Rujuk ke Layanan IMS</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_ppia" value="rujuk_ppia">
                                            <label class="form-check-label" for="rujuk_ppia">Rujuk ke PPIA</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_rehab" value="rujuk_rehab">
                                            <label class="form-check-label" for="rujuk_rehab">Rujuk ke Rehab</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_lass" value="rujuk_lass">
                                            <label class="form-check-label" for="rujuk_lass">Rujuk ke Layanan LASS</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_tb" value="rujuk_tb">
                                            <label class="form-check-label" for="rujuk_tb">Rujuk ke Layanan TB</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_profesional" value="rujuk_profesional">
                                            <label class="form-check-label" for="rujuk_profesional">Rujuk ke Profesional</label>
                                        </div>
                                        <div class="mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_petugas" value="rujuk_petugas_pendukung">
                                                <label class="form-check-label" for="rujuk_petugas">Rujuk ke petugas pendukung, yaitu:</label>
                                            </div>
                                            <div class="ms-4 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="petugas_pendukung[]" id="komunitas" value="komunitas">
                                                    <label class="form-check-label" for="komunitas">1. Komunitas</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="petugas_pendukung[]" id="lsm" value="lsm">
                                                    <label class="form-check-label" for="lsm">2. LSM</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="petugas_pendukung[]" id="kader" value="kader">
                                                    <label class="form-check-label" for="kader">3. Kader</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="konseling_detail" value="konseling">
                                                <label class="form-check-label" for="konseling_detail">Konseling</label>
                                            </div>
                                            <div class="ms-4 mt-1">
                                                <small class="text-muted">
                                                    1. Pasangan<br>
                                                    2. Keluarga<br>
                                                    3. Pengungkapan positif<br>
                                                    4. Kepatuhan minum obat<br>
                                                    5. Perilaku<br>
                                                    6. Lain - lain
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Nama Konselor/Petugas Kesehatan -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Konselor / Petugas Kesehatan</label>
                                        <input type="text" class="form-control" name="nama_konselor" placeholder="Masukkan nama konselor/petugas kesehatan">
                                    </div>
                                </div>
                            </div>

                            <!-- Status Layanan dan Jenis Pelayanan -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Status Layanan</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_layanan" id="rumah_sakit" value="rumah_sakit">
                                            <label class="form-check-label" for="rumah_sakit">Rumah Sakit</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_layanan" id="puskesmas" value="puskesmas">
                                            <label class="form-check-label" for="puskesmas">Puskesmas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_layanan" id="klinik" value="klinik">
                                            <label class="form-check-label" for="klinik">Klinik</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Pelayanan</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_pelayanan" id="layanan_menetap" value="layanan_menetap">
                                            <label class="form-check-label" for="layanan_menetap">Layanan Menetap</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_pelayanan" id="layanan_bergerak" value="layanan_bergerak">
                                            <label class="form-check-label" for="layanan_bergerak">Layanan Bergerak</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Batas Akhir Formulir -->
                            <div class="text-center mt-4">
                                <hr>
                                <small class="text-muted">--- batas akhir formulir ---</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="" class="btn btn-secondary">
                                <i class="ti-arrow-left"></i> Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Handle select change events
            $('#jenis_kelamin').change(function() {
                var value = $(this).val();
                if (value === 'perempuan') {
                    $('#section_perempuan').removeClass('hidden');
                    $('#section_laki_laki').addClass('hidden');
                } else if (value === 'laki_laki') {
                    $('#section_laki_laki').removeClass('hidden');
                    $('#section_perempuan').addClass('hidden');
                } else {
                    $('#section_perempuan').addClass('hidden');
                    $('#section_laki_laki').addClass('hidden');
                }
                // Reset dan sembunyikan detail pasangan saat ganti gender
                $('#detail_pasangan_common').addClass('hidden');
                resetPasanganFields();
            });

            $('#pasangan_tetap').change(function() {
                var value = $(this).val();
                if (value === 'ya') {
                    $('#detail_pasangan_common').removeClass('hidden');
                } else {
                    $('#detail_pasangan_common').addClass('hidden');
                    resetPasanganFields();
                }
            });

            $('#pasangan_perempuan').change(function() {
                var value = $(this).val();
                if (value === 'ya') {
                    $('#detail_pasangan_perempuan').removeClass('hidden');
                    $('#detail_pasangan_common').removeClass('hidden');
                } else {
                    $('#detail_pasangan_perempuan').addClass('hidden');
                    $('#detail_pasangan_common').addClass('hidden');
                    resetPasanganFields();
                }
            });

            $('#kelompok_risiko').change(function() {
                var value = $(this).val();
                if (value === 'ps') {
                    $('#jenis_ps_section').removeClass('hidden');
                } else {
                    $('#jenis_ps_section').addClass('hidden');
                    $('#jenis_ps').val('');
                }
            });

            function resetPasanganFields() {
                // Reset semua field pasangan
                $('input[name="tgl_lahir_pasangan"]').val('');
                $('select[name="status_hiv_pasangan"]').val('');
                $('input[name="tgl_tes_terakhir_pasangan"]').val('');
                $('#pasangan_hamil').val('');
                $('#pasangan_tetap').val('');
                $('#pasangan_perempuan').val('');
            }

            // Form validation
            $('#konselingHIVForm').submit(function(e) {
                var isValid = true;
                var errorMessages = [];

                // Validate required fields
                if (!$('#jenis_kelamin').val()) {
                    errorMessages.push('Jenis kelamin harus dipilih');
                    isValid = false;
                }

                if (!$('#tgl_implementasi').val()) {
                    errorMessages.push('Tanggal implementasi harus diisi');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi field berikut:\n' + errorMessages.join('\n'));
                }
            });
        });
    </script>
@endpush