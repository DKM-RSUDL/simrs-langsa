@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/dewasa") }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Pengkajian Gizi Dewasa</h4>
                                    <p>
                                        Pastikan semua data yang diperlukan
                                        telah diisi dengan benar. Setelah selesai, klik tombol "Simpan" untuk menyimpan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM gizi dewasa --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.gizi.dewasa.store', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="px-3">
                                <div>

                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" value="{{ date('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk" value="{{ date('H:i') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis Medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Masukkan diagnosis medis" required>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="riwayat-gizi">
                                        <h5 class="section-title">2. Riwayat Gizi</h5>
                                    
                                        <!-- Kebiasaan Makan -->
                                        <div class="form-group">
                                            <label style="min-width: 230px;">Kebiasaan Makan</label>
                                            <div style="width: 100%;">
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <div class="border rounded p-3">
                                                            <h6 class="mb-2 text-primary">Pagi</h6>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_pagi" id="makan_pagi_ya" value="ya">
                                                                <label class="form-check-label" for="makan_pagi_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_pagi" id="makan_pagi_tidak" value="tidak">
                                                                <label class="form-check-label" for="makan_pagi_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="border rounded p-3">
                                                            <h6 class="mb-2 text-primary">Siang</h6>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_siang" id="makan_siang_ya" value="ya">
                                                                <label class="form-check-label" for="makan_siang_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_siang" id="makan_siang_tidak" value="tidak">
                                                                <label class="form-check-label" for="makan_siang_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="border rounded p-3">
                                                            <h6 class="mb-2 text-primary">Malam</h6>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_malam" id="makan_malam_ya" value="ya">
                                                                <label class="form-check-label" for="makan_malam_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_malam" id="makan_malam_tidak" value="tidak">
                                                                <label class="form-check-label" for="makan_malam_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Kebiasaan Makan Selingan/Ngemil -->
                                        <div class="form-group">
                                            <label style="min-width: 230px;">Kebiasaan Ngemil</label>
                                            <div class="d-flex align-items-center gap-2" style="width: 300px;">
                                                <input type="number" class="form-control" name="frekuensi_ngemil" id="frekuensi_ngemil" 
                                                       min="0" max="10" placeholder="0" value="0">
                                                <span class="text-muted">kali/hari</span>
                                            </div>
                                        </div>
                                    
                                        <!-- Alergi Makanan -->
                                        <div class="form-group">
                                            <label style="min-width: 230px;">Alergi Makanan</label>
                                            <div style="width: 100%;">
                                                <div class="border rounded p-3">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-check form-check-inline mb-3">
                                                                <input class="form-check-input" type="radio" name="alergi_makanan" id="alergi_makanan_tidak" 
                                                                       value="tidak" checked>
                                                                <label class="form-check-label" for="alergi_makanan_tidak">
                                                                    <strong>Tidak</strong>
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline mb-3">
                                                                <input class="form-check-input" type="radio" name="alergi_makanan" id="alergi_makanan_ya" 
                                                                       value="ya">
                                                                <label class="form-check-label" for="alergi_makanan_ya">
                                                                    <strong>Ya</strong>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <label class="form-label text-muted">Jenis alergi makanan:</label>
                                                            <textarea class="form-control" name="jenis_alergi" id="jenis_alergi" rows="3" 
                                                                      placeholder="Contoh: Telur, susu, kacang tanah, seafood, dll" 
                                                                      readonly style="background-color: #f8f9fa;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Pantangan Makanan -->
                                        <div class="form-group">
                                            <label style="min-width: 230px;">Pantangan Makanan</label>
                                            <div style="width: 100%;">
                                                <div class="border rounded p-3">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-check form-check-inline mb-3">
                                                                <input class="form-check-input" type="radio" name="pantangan_makanan" id="pantangan_makanan_tidak" 
                                                                       value="tidak" checked>
                                                                <label class="form-check-label" for="pantangan_makanan_tidak">
                                                                    <strong>Tidak</strong>
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline mb-3">
                                                                <input class="form-check-input" type="radio" name="pantangan_makanan" id="pantangan_makanan_ya" 
                                                                       value="ya">
                                                                <label class="form-check-label" for="pantangan_makanan_ya">
                                                                    <strong>Ya</strong>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <label class="form-label text-muted">Jenis pantangan makanan:</label>
                                                            <textarea class="form-control" name="jenis_pantangan" id="jenis_pantangan" rows="3" 
                                                                      placeholder="Contoh: Makanan pedas, makanan berlemak, makanan tinggi garam, dll" 
                                                                      readonly style="background-color: #f8f9fa;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Gangguan Gastrointestinal -->
                                        <div class="form-group">
                                            <label style="min-width: 230px;">Gangguan Gastrointestinal</label>
                                            <div style="width: 100%;">
                                                <div class="border rounded p-3">
                                                    <div class="row g-3">
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="gangguan_gi[]" value="anoreksia" id="gi_anoreksia">
                                                                <label class="form-check-label" for="gi_anoreksia">
                                                                    Anoreksia
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="gangguan_gi[]" value="mual" id="gi_mual">
                                                                <label class="form-check-label" for="gi_mual">
                                                                    Mual
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="gangguan_gi[]" value="kesulitan_mengunyah" id="gi_mengunyah">
                                                                <label class="form-check-label" for="gi_mengunyah">
                                                                    Kesulitan Mengunyah
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="gangguan_gi[]" value="diare" id="gi_diare">
                                                                <label class="form-check-label" for="gi_diare">
                                                                    Diare
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="gangguan_gi[]" value="kesulitan_menelan" id="gi_menelan">
                                                                <label class="form-check-label" for="gi_menelan">
                                                                    Kesulitan Menelan
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="gangguan_gi[]" value="muntah" id="gi_muntah">
                                                                <label class="form-check-label" for="gi_muntah">
                                                                    Muntah
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="gangguan_gi[]" value="konstipasi" id="gi_konstipasi">
                                                                <label class="form-check-label" for="gi_konstipasi">
                                                                    Konstipasi
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="gangguan_gi[]" value="gangguan_gigi_geligi" id="gi_gigi">
                                                                <label class="form-check-label" for="gi_gigi">
                                                                    Gangguan Gigi Geligi
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Frekuensi Makan Sebelum Masuk RS -->
                                        <div class="form-group">
                                            <label style="min-width: 230px;">Frekuensi Makan Sebelum Masuk RS</label>
                                            <div style="width: 100%;">
                                                <div class="border rounded p-3">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="frekuensi_makan_rs" id="frekuensi_lebih" value="lebih_3x">
                                                                <label class="form-check-label" for="frekuensi_lebih">
                                                                    <strong>Makan > 3x/hari</strong>
                                                                    <small class="text-muted d-block">Termasuk makan utama dan selingan</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="frekuensi_makan_rs" id="frekuensi_kurang" value="kurang_3x">
                                                                <label class="form-check-label" for="frekuensi_kurang">
                                                                    <strong>Makan < 3x/hari</strong>
                                                                    <small class="text-muted d-block">Kurang dari frekuensi normal</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>

                                    <div class="section-separator" id="bahan-makanan">
                                        <h5 class="section-title">3. Bahan Makanan yang Bisa Dikonsumsi</h5>
                                    
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Makanan Pokok</label>
                                                    <textarea class="form-control" name="makanan_pokok" rows="4" 
                                                              placeholder="Contoh: Nasi, roti, kentang, mie, bubur"></textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Lauk Hewani</label>
                                                    <textarea class="form-control" name="lauk_hewani" rows="4" 
                                                              placeholder="Contoh: Ayam, ikan, daging, telur, susu, keju"></textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Lauk Nabati</label>
                                                    <textarea class="form-control" name="lauk_nabati" rows="4" 
                                                              placeholder="Contoh: Tahu, tempe, kacang-kacangan"></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Sayur-sayuran</label>
                                                    <textarea class="form-control" name="sayuran" rows="4" 
                                                              placeholder="Contoh: Bayam, kangkung, wortel, brokoli"></textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Buah-buahan</label>
                                                    <textarea class="form-control" name="buah_buahan" rows="4" 
                                                              placeholder="Contoh: Pisang, apel, jeruk, pepaya"></textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Minuman</label>
                                                    <textarea class="form-control" name="minuman" rows="4" 
                                                              placeholder="Contoh: Air putih, susu, jus buah, teh"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="section-separator" id="recall-24-jam">
                                        <h5 class="section-title">4. Recall Makanan 24 Jam</h5>
                                        
                                        <div class="alert alert-info mb-4">
                                            <strong>Petunjuk:</strong> Isikan makanan dan minuman yang dikonsumsi anak dalam 24 jam terakhir
                                        </div>
                                    
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <h6 class="text-primary mb-3">Pagi Hari</h6>
                                                
                                                <div class="form-group">
                                                    <label class="form-label">Makan Pagi</label>
                                                    <textarea class="form-control" name="recall_makan_pagi" rows="4" 
                                                              placeholder="Contoh: Nasi putih 1 centong, telur dadar 1 butir, sayur bayam 1 mangkok"></textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label">Snack Pagi</label>
                                                    <textarea class="form-control" name="recall_snack_pagi" rows="4" 
                                                              placeholder="Contoh: Biskuit 2 keping, susu kotak 200ml"></textarea>
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-6">
                                                <h6 class="text-primary mb-3">Siang Hari</h6>
                                                
                                                <div class="form-group">
                                                    <label class="form-label">Makan Siang</label>
                                                    <textarea class="form-control" name="recall_makan_siang" rows="4" 
                                                              placeholder="Contoh: Nasi putih 1.5 centong, ayam goreng 1 potong, sayur sop 1 mangkok"></textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label">Snack Sore</label>
                                                    <textarea class="form-control" name="recall_snack_sore" rows="4" 
                                                              placeholder="Contoh: Buah pisang 1 buah, air putih 1 gelas"></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <h6 class="text-primary mb-3">Malam Hari</h6>
                                                
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Makan Malam</label>
                                                            <textarea class="form-control" name="recall_makan_malam" rows="4" 
                                                                      placeholder="Contoh: Nasi putih 1 centong, ikan bakar 1 potong, sayur kangkung 1 mangkok"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Snack Malam</label>
                                                            <textarea class="form-control" name="recall_snack_malam" rows="4" 
                                                                      placeholder="Contoh: Susu hangat 1 gelas, roti tawar 1 potong"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="section-separator" id="asupan-sebelum-rs">
                                        <h5 class="section-title">5. Asupan Sebelum Masuk RS</h5>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Penilaian Asupan Makanan</label>
                                            <div style="width: 100%;">
                                                <div class="row g-4">
                                                    <div class="col-md-3">
                                                        <div class="border rounded p-4 text-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="asupan_sebelum_rs" id="asupan_lebih" value="lebih">
                                                                <label class="form-check-label w-100" for="asupan_lebih">
                                                                    <h6 class="text-success mb-2">LEBIH</h6>
                                                                    <p class="text-muted small mb-0">Asupan berlebihan</p>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <div class="border rounded p-4 text-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="asupan_sebelum_rs" id="asupan_baik" value="baik">
                                                                <label class="form-check-label w-100" for="asupan_baik">
                                                                    <h6 class="text-primary mb-2">BAIK</h6>
                                                                    <p class="text-muted small mb-0">Sesuai kebutuhan</p>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <div class="border rounded p-4 text-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="asupan_sebelum_rs" id="asupan_kurang" value="kurang">
                                                                <label class="form-check-label w-100" for="asupan_kurang">
                                                                    <h6 class="text-warning mb-2">KURANG</h6>
                                                                    <p class="text-muted small mb-0">Kurang dari kebutuhan</p>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3">
                                                        <div class="border rounded p-4 text-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="asupan_sebelum_rs" id="asupan_buruk" value="buruk">
                                                                <label class="form-check-label w-100" for="asupan_buruk">
                                                                    <h6 class="text-danger mb-2">BURUK</h6>
                                                                    <p class="text-muted small mb-0">Sangat kurang</p>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="asesmen-gizi">
                                        <h5 class="section-title">6. Asesmen Gizi</h5>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Berat Badan (kg)</label>
                                            <input type="number" class="form-control" name="berat_badan" id="berat_badan" step="0.1" 
                                                   placeholder="Contoh: 50.5">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Tinggi Badan (cm)</label>
                                            <input type="number" class="form-control" name="tinggi_badan" id="tinggi_badan" step="0.1" 
                                                   placeholder="Contoh: 165">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">IMT (kg/m²)</label>
                                            <input type="number" class="form-control" name="imt" id="imt" step="0.01" 
                                                   placeholder="Akan dihitung otomatis" readonly>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Berat Badan Ideal/BBI (kg)</label>
                                            <input type="number" class="form-control" name="bbi" id="bbi" step="0.1" 
                                                   placeholder="Akan dihitung otomatis" readonly>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Status Gizi</label>
                                            <select class="form-control" name="status_gizi" id="status_gizi">
                                                <option value="">Pilih Status Gizi</option>
                                                <option value="Gizi Buruk">Gizi Buruk</option>
                                                <option value="Gizi Kurang">Gizi Kurang</option>
                                                <option value="Gizi Baik/Normal">Gizi Baik/Normal</option>
                                                <option value="Gizi Lebih">Gizi Lebih</option>
                                                <option value="Obesitas">Obesitas</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Biokimia</label>
                                            <textarea class="form-control" name="biokimia" rows="4"
                                                placeholder="Sebutkan biokimia..."></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Kimia/Fisik</label>
                                            <textarea class="form-control" name="kimia_fisik" rows="4"
                                                placeholder="Sebutkan kimia/fisik..."></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Gizi dll</label>
                                            <textarea class="form-control" name="riwayat_gizi" rows="4"
                                                placeholder="Sebutkan riwayat gizi..."></textarea>
                                        </div>
                                    
                                    </div>

                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">7.Riwayat Alergi</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                        <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="createAlergiTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="20%">Jenis Alergi</th>
                                                        <th width="25%">Alergen</th>
                                                        <th width="25%">Reaksi</th>
                                                        <th width="20%">Tingkat Keparahan</th>
                                                        <th width="10%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="no-alergi-row">
                                                        <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosa_gizi">
                                        <h5 class="section-title">8. Diagnosa Gizi</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Diagnosa Gizi</label>
                                            <textarea class="form-control" name="diagnosa_gizi" rows="4"
                                                placeholder="Sebutkan diagnosa gizi..."></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="intervensi-gizi">
                                        <h5 class="section-title">9. Intervensi Gizi</h5>
                                        
                                        <div class="alert alert-info mb-4">
                                            <strong>Informasi:</strong> Perhitungan kebutuhan gizi berdasarkan data antropometri dan kondisi klinis pasien
                                        </div>
                                    
                                        <div class="row g-4">
                                            <!-- Data Input Dasar -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">DATA DASAR PERHITUNGAN</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Jenis Kelamin</label>
                                                            <input type="text" class="form-control" 
                                                                   value="{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}" 
                                                                   readonly style="background-color: #f8f9fa;">
                                                            <input type="hidden" name="jenis_kelamin" value="{{ $dataMedis->pasien->jenis_kelamin }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Umur (tahun)</label>
                                                            <input type="number" class="form-control" name="umur" id="umur" 
                                                                   value="{{ $dataMedis->pasien->umur }}" step="0.1" readonly 
                                                                   style="background-color: #f8f9fa;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Faktor Aktivitas</label>
                                                            <select class="form-control" name="faktor_aktivitas" id="faktor_aktivitas">
                                                                <option value="">Pilih Faktor Aktivitas</option>
                                                                <option value="1.2">1.2 - Bed rest</option>
                                                                <option value="1.3">1.3 - Mobilitas terbatas</option>
                                                                <option value="1.5">1.5 - Aktivitas ringan</option>
                                                                <option value="1.7">1.7 - Aktivitas sedang</option>
                                                                <option value="1.9">1.9 - Aktivitas berat</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Faktor Stress</label>
                                                            <select class="form-control" name="faktor_stress" id="faktor_stress">
                                                                <option value="">Pilih Faktor Stress</option>
                                                                <option value="1.0">1.0 - Normal</option>
                                                                <option value="1.2">1.2 - Demam ringan</option>
                                                                <option value="1.3">1.3 - Infeksi ringan</option>
                                                                <option value="1.5">1.5 - Operasi besar</option>
                                                                <option value="1.8">1.8 - Trauma berat</option>
                                                                <option value="2.0">2.0 - Luka bakar luas</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- Perhitungan BEE -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">PERHITUNGAN KEBUTUHAN ENERGI</h6>
                                                <div class="border rounded p-4 bg-light">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">BEE (Basal Energy Expenditure)</label>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" name="bee" id="bee" 
                                                                           placeholder="Akan dihitung otomatis" readonly>
                                                                    <span class="input-group-text">Kkal</span>
                                                                </div>
                                                                <small class="text-muted mt-1 d-block">
                                                                    <strong>Pria:</strong> 66 + (13,7 × BB kg) + (5 × TB cm) - (6,8 × Umur thn)<br>
                                                                    <strong>Wanita:</strong> 655 + (9,6 × BB kg) + (1,7 × TB cm) - (4,7 × Umur thn)
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">BMR (Basal Metabolic Rate)</label>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" name="bmr" id="bmr" 
                                                                           placeholder="Sama dengan BEE" readonly>
                                                                    <span class="input-group-text">Kkal</span>
                                                                </div>
                                                                <small class="text-muted">BMR = BEE</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- Perhitungan TEE -->
                                            <div class="col-md-12">
                                                <div class="border rounded p-4 bg-light">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">TEE (Total Energy Expenditure)</label>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" name="tee" id="tee" 
                                                                           placeholder="Akan dihitung otomatis" readonly>
                                                                    <span class="input-group-text">Kkal</span>
                                                                </div>
                                                                <small class="text-muted">TEE = BEE × Faktor Aktivitas × Faktor Stress</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Kebutuhan Kalori (DIET)</label>
                                                                <div class="input-group">
                                                                    <input type="number" class="form-control" name="kebutuhan_kalori" id="kebutuhan_kalori" 
                                                                           placeholder="Sesuaikan dengan kondisi klinis">
                                                                    <span class="input-group-text">Kkal</span>
                                                                </div>
                                                                <small class="text-muted">Dapat disesuaikan berdasarkan kondisi klinis</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- Bentuk Makanan dan Pemberian -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">BENTUK MAKANAN DAN CARA PEMBERIAN</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label fw-bold">Bentuk Makanan</label>
                                                            <div class="border rounded p-3">
                                                                <div class="row g-2">
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="bentuk_makanan" 
                                                                                   value="biasa" id="bentuk_biasa">
                                                                            <label class="form-check-label" for="bentuk_biasa">Biasa</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="bentuk_makanan" 
                                                                                   value="lunak" id="bentuk_lunak">
                                                                            <label class="form-check-label" for="bentuk_lunak">Lunak</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="bentuk_makanan" 
                                                                                   value="cair" id="bentuk_cair">
                                                                            <label class="form-check-label" for="bentuk_cair">Cair</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label fw-bold">Cara Pemberian</label>
                                                            <div class="border rounded p-3">
                                                                <div class="row g-2">
                                                                    <div class="col-md-6">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="cara_pemberian" 
                                                                                   value="oral" id="pemberian_oral">
                                                                            <label class="form-check-label" for="pemberian_oral">Oral</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="cara_pemberian" 
                                                                                   value="ngt" id="pemberian_ngt">
                                                                            <label class="form-check-label" for="pemberian_ngt">NGT</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- Perhitungan Makronutrien -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">KEBUTUHAN MAKRONUTRIEN</h6>
                                                <div class="border rounded p-4 bg-light">
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Protein</label>
                                                                <div class="row g-2">
                                                                    <div class="col-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="protein_persen" 
                                                                                   id="protein_persen" placeholder="%" step="0.1" min="10" max="30" value="15">
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="protein_gram" 
                                                                                   id="protein_gram" placeholder="gram" readonly>
                                                                            <span class="input-group-text">gr</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <small class="text-muted">= (% × BB) atau (% × Kalori ÷ 4)</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Lemak</label>
                                                                <div class="row g-2">
                                                                    <div class="col-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="lemak_persen" 
                                                                                   id="lemak_persen" placeholder="%" step="0.1" min="20" max="35" value="25">
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="lemak_gram" 
                                                                                   id="lemak_gram" placeholder="gram" readonly>
                                                                            <span class="input-group-text">gr</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <small class="text-muted">= (% × BB) atau (% × Kalori ÷ 9)</small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="form-label fw-bold">Karbohidrat</label>
                                                                <div class="row g-2">
                                                                    <div class="col-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="kh_persen" 
                                                                                   id="kh_persen" placeholder="%" step="0.1" min="45" max="65" value="60">
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="kh_gram" 
                                                                                   id="kh_gram" placeholder="gram" readonly>
                                                                            <span class="input-group-text">gr</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <small class="text-muted">= (% × BB) atau (% × Kalori ÷ 4)</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- Rencana Diet -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">RENCANA DIET DAN MONITORING</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label fw-bold">Jenis Diet</label>
                                                            <textarea class="form-control" name="jenis_diet" rows="3" 
                                                                      placeholder="Contoh: Diet DM 1500 Kkal, Diet Jantung II, Diet Rendah Garam, dll"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label fw-bold">Rencana Monitoring</label>
                                                            <textarea class="form-control" name="rencana_monitoring" rows="3" 
                                                                      placeholder="Contoh: Monitoring BB setiap hari, evaluasi asupan makan, pemeriksaan lab rutin"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- Catatan Khusus -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Catatan Intervensi Gizi</label>
                                                    <textarea class="form-control" name="catatan_intervensi" rows="4" 
                                                              placeholder="Catatan khusus, anjuran, atau hal-hal penting lainnya terkait intervensi gizi"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Script ini akan ditambahkan ke dalam include.blade.php yang sudah ada -->


                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti-check"></i> Simpan
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('unit-pelayanan.rawat-inap.pelayanan.gizi.dewasa.modal-create-alergi')
@include('unit-pelayanan.rawat-inap.pelayanan.gizi.dewasa.include')
