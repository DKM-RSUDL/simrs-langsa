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
                <h5 class="text-secondary fw-bold">Edit Konseling HIV</h5>
            </div>

            <hr>

            <div class="form-section">
                <form action="{{ route('rawat-jalan.konseling-hiv.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $konselingHiv->id]) }}" method="post" id="konselingHIVForm">
                    @csrf
                    @method('PUT')

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
                                                id="tgl_implementasi" value="{{ old('tgl_implementasi', $konselingHiv->tgl_implementasi ? \Carbon\Carbon::parse($konselingHiv->tgl_implementasi)->format('Y-m-d') : '') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold required">Jam Implementasi</label>
                                        <div class="input-group">
                                            <input type="time" class="form-control" name="jam_implementasi" 
                                                value="{{ old('jam_implementasi', $konselingHiv->jam_implementasi ? \Carbon\Carbon::parse($konselingHiv->jam_implementasi)->format('H:i:s') : '') }}" required>
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
                                            <option value="datang_sendiri" {{ old('status_kunjungan', $konselingHiv->status_kunjungan ?? '') == 'datang_sendiri' ? 'selected' : '' }}>Datang Sendiri</option>
                                            <option value="dirujuk" {{ old('status_kunjungan', $konselingHiv->status_kunjungan ?? '') == 'dirujuk' ? 'selected' : '' }}>Dirujuk</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Status Rujukan</label>
                                        <select class="form-select" name="status_rujukan">
                                            <option value="">Pilih Status</option>
                                            <option value="tempat_kerja" {{ old('status_rujukan', $konselingHiv->status_rujukan ?? '') == 'tempat_kerja' ? 'selected' : '' }}>Tempat Kerja</option>
                                            <option value="klp_dukungan" {{ old('status_rujukan', $konselingHiv->status_rujukan ?? '') == 'klp_dukungan' ? 'selected' : '' }}>Klp DUkungan</option>
                                            <option value="pasangan" {{ old('status_rujukan', $konselingHiv->status_rujukan ?? '') == 'pasangan' ? 'selected' : '' }}>Pasangan</option>
                                            <option value="lainnya" {{ old('status_rujukan', $konselingHiv->status_rujukan ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Pasien Warga Binaan Pemasyarakatan (WBP) ?</label>
                                        <select class="form-select" name="warga_binaan">
                                            <option value="">Pilih Jawaban</option>
                                            <option value="ya" {{ old('warga_binaan', $konselingHiv->warga_binaan ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="tidak" {{ old('warga_binaan', $konselingHiv->warga_binaan ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
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
                                        <select class="form-select" name="status_kehamilan">
                                            <option value="">Pilih Status</option>
                                            <option value="trimester_1" {{ old('status_kehamilan', $konselingHiv->status_kehamilan ?? '') == 'trimester_1' ? 'selected' : '' }}>Trimester I</option>
                                            <option value="trimester_2" {{ old('status_kehamilan', $konselingHiv->status_kehamilan ?? '') == 'trimester_2' ? 'selected' : '' }}>Trimester II</option>
                                            <option value="trimester_3" {{ old('status_kehamilan', $konselingHiv->status_kehamilan ?? '') == 'trimester_3' ? 'selected' : '' }}>Trimester III</option>
                                            <option value="tidak_hamil" {{ old('status_kehamilan', $konselingHiv->status_kehamilan ?? '') == 'tidak_hamil' ? 'selected' : '' }}>Tidak Hamil</option>
                                            <option value="tidak_tahu" {{ old('status_kehamilan', $konselingHiv->status_kehamilan ?? '') == 'tidak_tahu' ? 'selected' : '' }}>Tidak Tahu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Umur Anak Terakhir (tahun)</label>
                                        <input type="number" class="form-control" name="umur_anak_terakhir" 
                                            value="{{ old('umur_anak_terakhir', $konselingHiv->umur_anak_terakhir ?? '') }}" min="0">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Jumlah Anak Kandung</label>
                                        <input type="number" class="form-control" name="jumlah_anak_kandung" 
                                            value="{{ old('jumlah_anak_kandung', $konselingHiv->jumlah_anak_kandung ?? '') }}" min="0">
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
                                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="perempuan" {{ old('jenis_kelamin', $konselingHiv->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    <option value="laki_laki" {{ old('jenis_kelamin', $konselingHiv->jenis_kelamin ?? '') == 'laki_laki' ? 'selected' : '' }}>Laki-laki</option>
                                </select>
                            </div>

                            <!-- Section untuk Pasien Perempuan -->
                            <div id="section_perempuan" class="{{ (old('jenis_kelamin', $konselingHiv->jenis_kelamin ?? '') != 'perempuan') ? 'hidden' : '' }}">
                                <div class="mb-3">
                                    <label class="form-label">Pasien memiliki pasangan tetap?</label>
                                    <select class="form-select" name="pasangan_tetap" id="pasangan_tetap">
                                        <option value="">Pilih Jawaban</option>
                                        <option value="ya" {{ old('pasangan_tetap', $konselingHiv->pasangan_tetap ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                        <option value="tidak" {{ old('pasangan_tetap', $konselingHiv->pasangan_tetap ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kelompok Risiko</label>
                                    <select class="form-select" name="kelompok_risiko" id="kelompok_risiko">
                                        <option value="">Pilih Kelompok Risiko</option>
                                        <option value="ps" {{ old('kelompok_risiko', $konselingHiv->kelompok_risiko ?? '') == 'ps' ? 'selected' : '' }}>PS (Pekerja Seks)</option>
                                        <option value="waria" {{ old('kelompok_risiko', $konselingHiv->kelompok_risiko ?? '') == 'waria' ? 'selected' : '' }}>Waria</option>
                                        <option value="pasangan_risti" {{ old('kelompok_risiko', $konselingHiv->kelompok_risiko ?? '') == 'pasangan_risti' ? 'selected' : '' }}>Pasangan Risti</option>
                                        <option value="penasun" {{ old('kelompok_risiko', $konselingHiv->kelompok_risiko ?? '') == 'penasun' ? 'selected' : '' }}>Penasun</option>
                                        <option value="lainnya" {{ old('kelompok_risiko', $konselingHiv->kelompok_risiko ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>

                                <div id="jenis_ps_section" class="mb-3 {{ (old('kelompok_risiko', $konselingHiv->kelompok_risiko ?? '') != 'ps') ? 'hidden' : '' }}">
                                    <label class="form-label">Jenis PS</label>
                                    <select class="form-select" name="jenis_ps" id="jenis_ps">
                                        <option value="">Pilih Jenis PS</option>
                                        <option value="langsung" {{ old('jenis_ps', $konselingHiv->jenis_ps ?? '') == 'langsung' ? 'selected' : '' }}>Langsung</option>
                                        <option value="tidak_langsung" {{ old('jenis_ps', $konselingHiv->jenis_ps ?? '') == 'tidak_langsung' ? 'selected' : '' }}>Tidak Langsung</option>
                                        <option value="pelanggan_ps" {{ old('jenis_ps', $konselingHiv->jenis_ps ?? '') == 'pelanggan_ps' ? 'selected' : '' }}>Pelanggan PS</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Section untuk Pasien Laki-laki -->
                            <div id="section_laki_laki" class="{{ (old('jenis_kelamin', $konselingHiv->jenis_kelamin ?? '') != 'laki_laki') ? 'hidden' : '' }}">
                                <div class="mb-3">
                                    <label class="form-label">Punya pasangan perempuan?</label>
                                    <select class="form-select" name="pasangan_perempuan" id="pasangan_perempuan">
                                        <option value="">Pilih Jawaban</option>
                                        <option value="ya" {{ old('pasangan_perempuan', $konselingHiv->pasangan_perempuan ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                        <option value="tidak" {{ old('pasangan_perempuan', $konselingHiv->pasangan_perempuan ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>

                                <div id="detail_pasangan_perempuan" class="{{ (old('pasangan_perempuan', $konselingHiv->pasangan_perempuan ?? '') != 'ya') ? 'hidden' : '' }}">
                                    <div class="mb-3">
                                        <label class="form-label">Apakah pasangan hamil?</label>
                                        <select class="form-select" name="pasangan_hamil" id="pasangan_hamil">
                                            <option value="">Pilih Jawaban</option>
                                            <option value="ya" {{ old('pasangan_hamil', $konselingHiv->pasangan_hamil ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="tidak" {{ old('pasangan_hamil', $konselingHiv->pasangan_hamil ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            <option value="tidak_tahu" {{ old('pasangan_hamil', $konselingHiv->pasangan_hamil ?? '') == 'tidak_tahu' ? 'selected' : '' }}>Tidak Tahu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Detail Pasangan (Tampil untuk kedua jenis kelamin) -->
                            @php
                                $showDetailPasangan = false;
                                if (old('jenis_kelamin', $konselingHiv->jenis_kelamin ?? '') == 'perempuan' && old('pasangan_tetap', $konselingHiv->pasangan_tetap ?? '') == 'ya') {
                                    $showDetailPasangan = true;
                                } elseif (old('jenis_kelamin', $konselingHiv->jenis_kelamin ?? '') == 'laki_laki' && old('pasangan_perempuan', $konselingHiv->pasangan_perempuan ?? '') == 'ya') {
                                    $showDetailPasangan = true;
                                }
                            @endphp
                            <div id="detail_pasangan_common" class="{{ !$showDetailPasangan ? 'hidden' : '' }}">
                                <hr class="my-3">
                                <h6 class="mb-3 text-primary">Detail Pasangan</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Lahir Pasangan</label>
                                            <input type="date" class="form-control" name="tgl_lahir_pasangan" 
                                                value="{{ old('tgl_lahir_pasangan', $konselingHiv->tgl_lahir_pasangan ? \Carbon\Carbon::parse($konselingHiv->tgl_lahir_pasangan)->format('Y-m-d') : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Status HIV Pasangan</label>
                                            <select class="form-select" name="status_hiv_pasangan">
                                                <option value="">Pilih Status</option>
                                                <option value="positif" {{ old('status_hiv_pasangan', $konselingHiv->status_hiv_pasangan ?? '') == 'positif' ? 'selected' : '' }}>HIV Positif</option>
                                                <option value="negatif" {{ old('status_hiv_pasangan', $konselingHiv->status_hiv_pasangan ?? '') == 'negatif' ? 'selected' : '' }}>HIV Negatif</option>
                                                <option value="tidak_tahu" {{ old('status_hiv_pasangan', $konselingHiv->status_hiv_pasangan ?? '') == 'tidak_tahu' ? 'selected' : '' }}>Tidak Tahu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Tes Terakhir Pasangan</label>
                                            <input type="date" class="form-control" name="tgl_tes_terakhir_pasangan" 
                                                value="{{ old('tgl_tes_terakhir_pasangan', $konselingHiv->tgl_tes_terakhir_pasangan ? \Carbon\Carbon::parse($konselingHiv->tgl_tes_terakhir_pasangan)->format('Y-m-d') : '') }}">
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
                                        <input type="date" class="form-control" name="tgl_konseling_pra_tes" 
                                            value="{{ old('tgl_konseling_pra_tes', $konselingHiv->tgl_konseling_pra_tes ? \Carbon\Carbon::parse($konselingHiv->tgl_konseling_pra_tes)->format('Y-m-d') : '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status Klien</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_klien" id="status_baru" value="baru" 
                                                    {{ old('status_klien', $konselingHiv->status_klien ?? '') == 'baru' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status_baru">Baru</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status_klien" id="status_lama" value="lama" 
                                                    {{ old('status_klien', $konselingHiv->status_klien ?? '') == 'lama' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status_lama">Lama</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alasan Tes HIV -->
                            @php
                                $alasanTes = [];
                                if (isset($konselingHiv->alasan_tes)) {
                                    $alasanTes = is_string($konselingHiv->alasan_tes) ? json_decode($konselingHiv->alasan_tes, true) : $konselingHiv->alasan_tes;
                                    $alasanTes = $alasanTes ?? [];
                                }
                                $alasanTes = old('alasan_tes', $alasanTes);
                            @endphp
                            <div class="mb-3">
                                <label class="form-label">Alasan Tes HIV (boleh diisi lebih dari satu)</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="ingin_tahu" value="ingin_tahu_saja" 
                                                {{ in_array('ingin_tahu_saja', $alasanTes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ingin_tahu">Ingin tahu saja</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="untuk_bekerja" value="untuk_bekerja" 
                                                {{ in_array('untuk_bekerja', $alasanTes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="untuk_bekerja">Untuk bekerja</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="merasa_beresiko" value="merasa_beresiko" 
                                                {{ in_array('merasa_beresiko', $alasanTes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="merasa_beresiko">Merasa beresiko</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="lainnya_alasan" value="lainnya" 
                                                {{ in_array('lainnya', $alasanTes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="lainnya_alasan">Lainnya</label>
                                        </div>
                                        <input type="text" class="form-control mt-1" name="alasan_tes_lainnya" placeholder="Sebutkan..." 
                                            value="{{ old('alasan_tes_lainnya', $konselingHiv->alasan_tes_lainnya ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="mumpung_gratis" value="mumpung_gratis" 
                                                {{ in_array('mumpung_gratis', $alasanTes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mumpung_gratis">Mumpung gratis</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="ada_gejala" value="ada_gejala_tertentu" 
                                                {{ in_array('ada_gejala_tertentu', $alasanTes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ada_gejala">Ada gejala tertentu</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="tes_ulang" value="tes_ulang_window_period" 
                                                {{ in_array('tes_ulang_window_period', $alasanTes) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tes_ulang">Tes ulang (window period)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="alasan_tes[]" id="akan_menikah" value="akan_menikah" 
                                                {{ in_array('akan_menikah', $alasanTes) ? 'checked' : '' }}>
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
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="brosur" value="brosur" 
                                                {{ old('mengetahui_tes_dari', $konselingHiv->mengetahui_tes_dari ?? '') == 'brosur' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="brosur">Brosur</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="petugas_outreach" value="petugas_outreach" 
                                                {{ old('mengetahui_tes_dari', $konselingHiv->mengetahui_tes_dari ?? '') == 'petugas_outreach' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="petugas_outreach">Petugas Outreach</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="koran" value="koran" 
                                                {{ old('mengetahui_tes_dari', $konselingHiv->mengetahui_tes_dari ?? '') == 'koran' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="koran">Koran</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="poster" value="poster" 
                                                {{ old('mengetahui_tes_dari', $konselingHiv->mengetahui_tes_dari ?? '') == 'poster' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="poster">Poster</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="tv" value="tv" 
                                                {{ old('mengetahui_tes_dari', $konselingHiv->mengetahui_tes_dari ?? '') == 'tv' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tv">TV</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="lay_konselor" value="lay_konselor" 
                                                {{ old('mengetahui_tes_dari', $konselingHiv->mengetahui_tes_dari ?? '') == 'lay_konselor' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="lay_konselor">Lay Konselor</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="petugas_kesehatan" value="petugas_kesehatan" 
                                                {{ old('mengetahui_tes_dari', $konselingHiv->mengetahui_tes_dari ?? '') == 'petugas_kesehatan' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="petugas_kesehatan">Petugas Kesehatan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="teman" value="teman" 
                                                {{ old('mengetahui_tes_dari', $konselingHiv->mengetahui_tes_dari ?? '') == 'teman' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="teman">Teman</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mengetahui_tes_dari" id="lainnya_info" value="lainnya" 
                                                {{ old('mengetahui_tes_dari', $konselingHiv->mengetahui_tes_dari ?? '') == 'lainnya' ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="radio" name="seks_vaginal_berisiko" id="seks_vaginal_ya" value="ya" 
                                                    {{ old('seks_vaginal_berisiko', $konselingHiv->seks_vaginal_berisiko ?? '') == 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="seks_vaginal_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="seks_vaginal_kapan" style="width: 100px;" 
                                                    value="{{ old('seks_vaginal_kapan', $konselingHiv->seks_vaginal_kapan ?? '') }}">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="seks_vaginal_berisiko" id="seks_vaginal_tidak" value="tidak" 
                                                    {{ old('seks_vaginal_berisiko', $konselingHiv->seks_vaginal_berisiko ?? '') == 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="seks_vaginal_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Anal Seks Berisiko</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="anal_seks_berisiko" id="anal_seks_ya" value="ya" 
                                                    {{ old('anal_seks_berisiko', $konselingHiv->anal_seks_berisiko ?? '') == 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="anal_seks_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="anal_seks_kapan" style="width: 100px;" 
                                                    value="{{ old('anal_seks_kapan', $konselingHiv->anal_seks_kapan ?? '') }}">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="anal_seks_berisiko" id="anal_seks_tidak" value="tidak" 
                                                    {{ old('anal_seks_berisiko', $konselingHiv->anal_seks_berisiko ?? '') == 'tidak' ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="radio" name="bergantian_suntik" id="bergantian_suntik_ya" value="ya" 
                                                    {{ old('bergantian_suntik', $konselingHiv->bergantian_suntik ?? '') == 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="bergantian_suntik_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="bergantian_suntik_kapan" style="width: 100px;" 
                                                    value="{{ old('bergantian_suntik_kapan', $konselingHiv->bergantian_suntik_kapan ?? '') }}">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="bergantian_suntik" id="bergantian_suntik_tidak" value="tidak" 
                                                    {{ old('bergantian_suntik', $konselingHiv->bergantian_suntik ?? '') == 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="bergantian_suntik_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Transfusi Darah</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transfusi_darah" id="transfusi_darah_ya" value="ya" 
                                                    {{ old('transfusi_darah', $konselingHiv->transfusi_darah ?? '') == 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="transfusi_darah_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="transfusi_darah_kapan" style="width: 100px;" 
                                                    value="{{ old('transfusi_darah_kapan', $konselingHiv->transfusi_darah_kapan ?? '') }}">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transfusi_darah" id="transfusi_darah_tidak" value="tidak" 
                                                    {{ old('transfusi_darah', $konselingHiv->transfusi_darah ?? '') == 'tidak' ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="radio" name="transmisi_ibu_anak" id="transmisi_ibu_anak_ya" value="ya" 
                                                    {{ old('transmisi_ibu_anak', $konselingHiv->transmisi_ibu_anak ?? '') == 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="transmisi_ibu_anak_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="transmisi_ibu_anak_kapan" style="width: 100px;" 
                                                    value="{{ old('transmisi_ibu_anak_kapan', $konselingHiv->transmisi_ibu_anak_kapan ?? '') }}">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="transmisi_ibu_anak" id="transmisi_ibu_anak_tidak" value="tidak" 
                                                    {{ old('transmisi_ibu_anak', $konselingHiv->transmisi_ibu_anak ?? '') == 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="transmisi_ibu_anak_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lainnya (Sebutkan)</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <input type="text" class="form-control" name="lainnya_risiko" placeholder="Sebutkan..." 
                                                value="{{ old('lainnya_risiko', $konselingHiv->lainnya_risiko ?? '') }}">
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="lainnya_risiko_kapan" style="width: 100px;" 
                                                    value="{{ old('lainnya_risiko_kapan', $konselingHiv->lainnya_risiko_kapan ?? '') }}">
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
                                                <input class="form-check-input" type="radio" name="periode_jendela" id="periode_jendela_ya" value="ya" 
                                                    {{ old('periode_jendela', $konselingHiv->periode_jendela ?? '') == 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="periode_jendela_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Kapan:</span>
                                                <input type="text" class="form-control" name="periode_jendela_kapan" style="width: 100px;" 
                                                    value="{{ old('periode_jendela_kapan', $konselingHiv->periode_jendela_kapan ?? '') }}">
                                                <span>Hr/Bln/Thn*</span>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="periode_jendela" id="periode_jendela_tidak" value="tidak" 
                                                    {{ old('periode_jendela', $konselingHiv->periode_jendela ?? '') == 'tidak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="periode_jendela_tidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kesediaan untuk Tes</label>
                                        <div class="d-flex gap-3 align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesediaan_tes" id="kesediaan_tes_ya" value="ya" 
                                                    {{ old('kesediaan_tes', $konselingHiv->kesediaan_tes ?? '') == 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="kesediaan_tes_ya">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="kesediaan_tes" id="kesediaan_tes_tidak" value="tidak" 
                                                    {{ old('kesediaan_tes', $konselingHiv->kesediaan_tes ?? '') == 'tidak' ? 'checked' : '' }}>
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
                                                <input class="form-check-input" type="radio" name="pernah_tes_hiv" id="pernah_tes_ya" value="ya" 
                                                    {{ old('pernah_tes_hiv', $konselingHiv->pernah_tes_hiv ?? '') == 'ya' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="pernah_tes_ya">Ya</label>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span>Dimana:</span>
                                                <input type="text" class="form-control" name="pernah_tes_dimana" style="width: 150px;" 
                                                    value="{{ old('pernah_tes_dimana', $konselingHiv->pernah_tes_dimana ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pernah_tes_hiv" id="pernah_tes_tidak" value="tidak" 
                                                {{ old('pernah_tes_hiv', $konselingHiv->pernah_tes_hiv ?? '') == 'tidak' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="pernah_tes_tidak">Tidak</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span>Kapan:</span>
                                            <input type="text" class="form-control" name="pernah_tes_kapan" style="width: 120px;" 
                                                value="{{ old('pernah_tes_kapan', $konselingHiv->pernah_tes_kapan ?? '') }}">
                                            <span>Hr/Bln/Thn*</span>
                                        </div>
                                        <div class="mb-2">
                                            <span>Hasil:</span>
                                            <div class="d-flex gap-3 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_tes_sebelumnya" id="hasil_non_reaktif" value="non_reaktif" 
                                                        {{ old('hasil_tes_sebelumnya', $konselingHiv->hasil_tes_sebelumnya ?? '') == 'non_reaktif' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="hasil_non_reaktif">Non Reaktif</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_tes_sebelumnya" id="hasil_reaktif" value="reaktif" 
                                                        {{ old('hasil_tes_sebelumnya', $konselingHiv->hasil_tes_sebelumnya ?? '') == 'reaktif' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="hasil_reaktif">Reaktif</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasil_tes_sebelumnya" id="hasil_tidak_tahu" value="tidak_tahu" 
                                                        {{ old('hasil_tes_sebelumnya', $konselingHiv->hasil_tes_sebelumnya ?? '') == 'tidak_tahu' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="hasil_tidak_tahu">Tidak tahu</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Bagaimana Status HIV Pasangan -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">Bagaimana Status HIV Pasangan</label>
                                    <select class="form-select" name="bagaimana_status_hiv_pasangan">
                                        <option value="">Pilih Status</option>
                                        <option value="hiv_minus" {{ old('bagaimana_status_hiv_pasangan', $konselingHiv->bagaimana_status_hiv_pasangan ?? '') == 'hiv_minus' ? 'selected' : '' }}>HIV (-)</option>
                                        <option value="hiv_plus" {{ old('bagaimana_status_hiv_pasangan', $konselingHiv->bagaimana_status_hiv_pasangan ?? '') == 'hiv_plus' ? 'selected' : '' }}>HIV (+)</option>
                                        <option value="tidak_tahu" {{ old('bagaimana_status_hiv_pasangan', $konselingHiv->bagaimana_status_hiv_pasangan ?? '') == 'tidak_tahu' ? 'selected' : '' }}>Tidak Tahu</option>
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
                                        <input type="date" class="form-control" name="tgl_konseling_pasca_tes" 
                                            value="{{ old('tgl_konseling_pasca_tes', $konselingHiv->tgl_konseling_pasca_tes ? Carbon::parse($konselingHiv->tgl_konseling_pasca_tes)->format('Y-m-d') : '') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Terima Hasil dan Kaji Gejala TB -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label">Terima Hasil</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="terima_hasil" id="terima_hasil_ya" value="ya" 
                                                {{ old('terima_hasil', $konselingHiv->terima_hasil ?? '') == 'ya' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="terima_hasil_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="terima_hasil" id="terima_hasil_tidak" value="tidak" 
                                                {{ old('terima_hasil', $konselingHiv->terima_hasil ?? '') == 'tidak' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="terima_hasil_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kaji Gejala TB</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kaji_gejala_tb" id="kaji_gejala_ya" value="ya" 
                                                {{ old('kaji_gejala_tb', $konselingHiv->kaji_gejala_tb ?? '') == 'ya' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kaji_gejala_ya">Ya</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kaji_gejala_tb" id="kaji_gejala_tidak" value="tidak" 
                                                {{ old('kaji_gejala_tb', $konselingHiv->kaji_gejala_tb ?? '') == 'tidak' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="kaji_gejala_tidak">Tidak</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jumlah Kondom yang Diberikan</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="jumlah_kondom" min="0" 
                                            value="{{ old('jumlah_kondom', $konselingHiv->jumlah_kondom ?? '') }}">
                                        <span class="input-group-text">Buah</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tindak Lanjut (KTS) -->
                            @php
                                $tindakLanjutKts = [];
                                if (isset($konselingHiv->tindak_lanjut_kts)) {
                                    $tindakLanjutKts = is_string($konselingHiv->tindak_lanjut_kts) ? json_decode($konselingHiv->tindak_lanjut_kts, true) : $konselingHiv->tindak_lanjut_kts;
                                    $tindakLanjutKts = $tindakLanjutKts ?? [];
                                }
                                $tindakLanjutKts = old('tindak_lanjut_kts', $tindakLanjutKts);
                            @endphp
                            <div class="mb-3">
                                <label class="form-label">Tindak Lanjut (KTS)</label>
                                <small class="text-muted d-block">(boleh diisi lebih dari satu)</small>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="tes_ulang_kts" value="tes_ulang" 
                                                {{ in_array('tes_ulang', $tindakLanjutKts) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tes_ulang_kts">Tes ulang</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_pdp" value="rujuk_pdp" 
                                                {{ in_array('rujuk_pdp', $tindakLanjutKts) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rujuk_pdp">Rujuk ke PDP</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_ptrm" value="rujuk_ptrm" 
                                                {{ in_array('rujuk_ptrm', $tindakLanjutKts) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rujuk_ptrm">Rujuk ke Layanan PTRM</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_ims" value="rujuk_ims" 
                                                {{ in_array('rujuk_ims', $tindakLanjutKts) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rujuk_ims">Rujuk ke Layanan IMS</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_ppia" value="rujuk_ppia" 
                                                {{ in_array('rujuk_ppia', $tindakLanjutKts) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rujuk_ppia">Rujuk ke PPIA</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_rehab" value="rujuk_rehab" 
                                                {{ in_array('rujuk_rehab', $tindakLanjutKts) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rujuk_rehab">Rujuk ke Rehab</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_lass" value="rujuk_lass" 
                                                {{ in_array('rujuk_lass', $tindakLanjutKts) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rujuk_lass">Rujuk ke Layanan LASS</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_tb" value="rujuk_tb" 
                                                {{ in_array('rujuk_tb', $tindakLanjutKts) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rujuk_tb">Rujuk ke Layanan TB</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_profesional" value="rujuk_profesional" 
                                                {{ in_array('rujuk_profesional', $tindakLanjutKts) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rujuk_profesional">Rujuk ke Profesional</label>
                                        </div>
                                        <div class="mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="rujuk_petugas" value="rujuk_petugas_pendukung" 
                                                    {{ in_array('rujuk_petugas_pendukung', $tindakLanjutKts) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="rujuk_petugas">Rujuk ke petugas pendukung, yaitu:</label>
                                            </div>
                                            <div class="ms-4 mt-1">
                                                @php
                                                    $petugasPendukung = [];
                                                    if (isset($konselingHiv->petugas_pendukung)) {
                                                        $petugasPendukung = is_string($konselingHiv->petugas_pendukung) ? json_decode($konselingHiv->petugas_pendukung, true) : $konselingHiv->petugas_pendukung;
                                                        $petugasPendukung = $petugasPendukung ?? [];
                                                    }
                                                    $petugasPendukung = old('petugas_pendukung', $petugasPendukung);
                                                @endphp
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="petugas_pendukung[]" id="komunitas" value="komunitas" 
                                                        {{ in_array('komunitas', $petugasPendukung) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="komunitas">1. Komunitas</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="petugas_pendukung[]" id="lsm" value="lsm" 
                                                        {{ in_array('lsm', $petugasPendukung) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="lsm">2. LSM</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="petugas_pendukung[]" id="kader" value="kader" 
                                                        {{ in_array('kader', $petugasPendukung) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="kader">3. Kader</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tindak_lanjut_kts[]" id="konseling_detail" value="konseling" 
                                                    {{ in_array('konseling', $tindakLanjutKts) ? 'checked' : '' }}>
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
                                        <input type="text" class="form-control" name="nama_konselor" placeholder="Masukkan nama konselor/petugas kesehatan" 
                                            value="{{ old('nama_konselor', $konselingHiv->nama_konselor ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Status Layanan dan Jenis Pelayanan -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Status Layanan</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_layanan" id="rumah_sakit" value="rumah_sakit" 
                                                {{ old('status_layanan', $konselingHiv->status_layanan ?? '') == 'rumah_sakit' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rumah_sakit">Rumah Sakit</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_layanan" id="puskesmas" value="puskesmas" 
                                                {{ old('status_layanan', $konselingHiv->status_layanan ?? '') == 'puskesmas' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="puskesmas">Puskesmas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status_layanan" id="klinik" value="klinik" 
                                                {{ old('status_layanan', $konselingHiv->status_layanan ?? '') == 'klinik' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="klinik">Klinik</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Pelayanan</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_pelayanan" id="layanan_menetap" value="layanan_menetap" 
                                                {{ old('jenis_pelayanan', $konselingHiv->jenis_pelayanan ?? '') == 'layanan_menetap' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="layanan_menetap">Layanan Menetap</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_pelayanan" id="layanan_bergerak" value="layanan_bergerak" 
                                                {{ old('jenis_pelayanan', $konselingHiv->jenis_pelayanan ?? '') == 'layanan_bergerak' ? 'checked' : '' }}>
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
                                <i class="bi bi-save me-1"></i> Update
                            </button>
                            <a href="{{ route('rawat-jalan.konseling-hiv.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" class="btn btn-secondary">
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

                if (!$('#tgl_implementasi').val()) {
                    errorMessages.push('Tanggal implementasi harus diisi');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi field berikut:\n' + errorMessages.join('\n'));
                }
            });

            // Initialize visibility on page load
            var currentGender = $('#jenis_kelamin').val();
            if (currentGender === 'perempuan') {
                $('#section_perempuan').removeClass('hidden');
                $('#section_laki_laki').addClass('hidden');
                
                var pasanganTetap = $('#pasangan_tetap').val();
                if (pasanganTetap === 'ya') {
                    $('#detail_pasangan_common').removeClass('hidden');
                }

                var kelompokRisiko = $('#kelompok_risiko').val();
                if (kelompokRisiko === 'ps') {
                    $('#jenis_ps_section').removeClass('hidden');
                }
            } else if (currentGender === 'laki_laki') {
                $('#section_laki_laki').removeClass('hidden');
                $('#section_perempuan').addClass('hidden');
                
                var pasanganPerempuan = $('#pasangan_perempuan').val();
                if (pasanganPerempuan === 'ya') {
                    $('#detail_pasangan_perempuan').removeClass('hidden');
                    $('#detail_pasangan_common').removeClass('hidden');
                }
            }
        });
    </script>
@endpush