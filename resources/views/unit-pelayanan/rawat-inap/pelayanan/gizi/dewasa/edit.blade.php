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
                                    <h4 class="header-asesmen">Edit Pengkajian Gizi Dewasa</h4>
                                    <p>
                                        Pastikan semua data yang diperlukan telah diisi dengan benar. Setelah selesai, klik tombol "Update" untuk menyimpan perubahan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM edit gizi dewasa --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.gizi.dewasa.update', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                                'id' => $dataGiziDewasa->id
                            ]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="px-3">
                                <div>

                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" 
                                                       value="{{ \Carbon\Carbon::parse($dataGiziDewasa->waktu_asesmen)->format('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk" 
                                                       value="{{ \Carbon\Carbon::parse($dataGiziDewasa->waktu_asesmen)->format('H:i') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis Medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Masukkan diagnosis medis" 
                                                value="{{ old('diagnosis_medis', $dataGiziDewasa->diagnosis_medis) }}" required>
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
                                                                <input class="form-check-input" type="radio" name="makan_pagi" id="makan_pagi_ya" value="ya"
                                                                       {{ old('makan_pagi', $dataGiziDewasa->makan_pagi) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_pagi_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_pagi" id="makan_pagi_tidak" value="tidak"
                                                                       {{ old('makan_pagi', $dataGiziDewasa->makan_pagi) == 'tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_pagi_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="border rounded p-3">
                                                            <h6 class="mb-2 text-primary">Siang</h6>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_siang" id="makan_siang_ya" value="ya"
                                                                       {{ old('makan_siang', $dataGiziDewasa->makan_siang) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_siang_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_siang" id="makan_siang_tidak" value="tidak"
                                                                       {{ old('makan_siang', $dataGiziDewasa->makan_siang) == 'tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_siang_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="border rounded p-3">
                                                            <h6 class="mb-2 text-primary">Malam</h6>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_malam" id="makan_malam_ya" value="ya"
                                                                       {{ old('makan_malam', $dataGiziDewasa->makan_malam) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_malam_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_malam" id="makan_malam_tidak" value="tidak"
                                                                       {{ old('makan_malam', $dataGiziDewasa->makan_malam) == 'tidak' ? 'checked' : '' }}>
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
                                                       min="0" max="10" placeholder="0" 
                                                       value="{{ old('frekuensi_ngemil', $dataGiziDewasa->frekuensi_ngemil ?? 0) }}">
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
                                                                       value="tidak" {{ old('alergi_makanan', $dataGiziDewasa->alergi_makanan) == 'tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="alergi_makanan_tidak">
                                                                    <strong>Tidak</strong>
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline mb-3">
                                                                <input class="form-check-input" type="radio" name="alergi_makanan" id="alergi_makanan_ya" 
                                                                       value="ya" {{ old('alergi_makanan', $dataGiziDewasa->alergi_makanan) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="alergi_makanan_ya">
                                                                    <strong>Ya</strong>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <label class="form-label text-muted">Jenis alergi makanan:</label>
                                                            <textarea class="form-control" name="jenis_alergi" id="jenis_alergi" rows="3" 
                                                                      placeholder="Contoh: Telur, susu, kacang tanah, seafood, dll"
                                                                      {{ old('alergi_makanan', $dataGiziDewasa->alergi_makanan) != 'ya' ? 'readonly style=background-color:#f8f9fa;' : '' }}>{{ old('jenis_alergi', $dataGiziDewasa->jenis_alergi) }}</textarea>
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
                                                                       value="tidak" {{ old('pantangan_makanan', $dataGiziDewasa->pantangan_makanan) == 'tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="pantangan_makanan_tidak">
                                                                    <strong>Tidak</strong>
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline mb-3">
                                                                <input class="form-check-input" type="radio" name="pantangan_makanan" id="pantangan_makanan_ya" 
                                                                       value="ya" {{ old('pantangan_makanan', $dataGiziDewasa->pantangan_makanan) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="pantangan_makanan_ya">
                                                                    <strong>Ya</strong>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <label class="form-label text-muted">Jenis pantangan makanan:</label>
                                                            <textarea class="form-control" name="jenis_pantangan" id="jenis_pantangan" rows="3" 
                                                                      placeholder="Contoh: Makanan pedas, makanan berlemak, makanan tinggi garam, dll"
                                                                      {{ old('pantangan_makanan', $dataGiziDewasa->pantangan_makanan) != 'ya' ? 'readonly style=background-color:#f8f9fa;' : '' }}>{{ old('jenis_pantangan', $dataGiziDewasa->jenis_pantangan) }}</textarea>
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
                                                        @php
                                                            $gangguanGi = explode(',', old('gangguan_gi', $dataGiziDewasa->gangguan_gi ?? ''));
                                                            $gangguanOptions = [
                                                                'anoreksia' => 'Anoreksia',
                                                                'mual' => 'Mual',
                                                                'kesulitan_mengunyah' => 'Kesulitan Mengunyah',
                                                                'diare' => 'Diare',
                                                                'kesulitan_menelan' => 'Kesulitan Menelan',
                                                                'muntah' => 'Muntah',
                                                                'konstipasi' => 'Konstipasi',
                                                                'gangguan_gigi_geligi' => 'Gangguan Gigi Geligi'
                                                            ];
                                                        @endphp

                                                        @foreach($gangguanOptions as $value => $label)
                                                            <div class="col-md-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="gangguan_gi[]" 
                                                                           value="{{ $value }}" id="gi_{{ $value }}"
                                                                           {{ in_array($value, $gangguanGi) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="gi_{{ $value }}">
                                                                        {{ $label }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
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
                                                                <input class="form-check-input" type="radio" name="frekuensi_makan_rs" id="frekuensi_lebih" value="lebih_3x"
                                                                       {{ old('frekuensi_makan_rs', $dataGiziDewasa->frekuensi_makan_rs) == 'lebih_3x' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="frekuensi_lebih">
                                                                    <strong>Makan > 3x/hari</strong>
                                                                    <small class="text-muted d-block">Termasuk makan utama dan selingan</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="frekuensi_makan_rs" id="frekuensi_kurang" value="kurang_3x"
                                                                       {{ old('frekuensi_makan_rs', $dataGiziDewasa->frekuensi_makan_rs) == 'kurang_3x' ? 'checked' : '' }}>
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
                                                              placeholder="Contoh: Nasi, roti, kentang, mie, bubur">{{ old('makanan_pokok', $dataGiziDewasa->makanan_pokok) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Lauk Hewani</label>
                                                    <textarea class="form-control" name="lauk_hewani" rows="4" 
                                                              placeholder="Contoh: Ayam, ikan, daging, telur, susu, keju">{{ old('lauk_hewani', $dataGiziDewasa->lauk_hewani) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Lauk Nabati</label>
                                                    <textarea class="form-control" name="lauk_nabati" rows="4" 
                                                              placeholder="Contoh: Tahu, tempe, kacang-kacangan">{{ old('lauk_nabati', $dataGiziDewasa->lauk_nabati) }}</textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Sayur-sayuran</label>
                                                    <textarea class="form-control" name="sayuran" rows="4" 
                                                              placeholder="Contoh: Bayam, kangkung, wortel, brokoli">{{ old('sayuran', $dataGiziDewasa->sayuran) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Buah-buahan</label>
                                                    <textarea class="form-control" name="buah_buahan" rows="4" 
                                                              placeholder="Contoh: Pisang, apel, jeruk, pepaya">{{ old('buah_buahan', $dataGiziDewasa->buah_buahan) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Minuman</label>
                                                    <textarea class="form-control" name="minuman" rows="4" 
                                                              placeholder="Contoh: Air putih, susu, jus buah, teh">{{ old('minuman', $dataGiziDewasa->minuman) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="section-separator" id="recall-24-jam">
                                        <h5 class="section-title">4. Recall Makanan 24 Jam</h5>
                                        
                                        <div class="alert alert-info mb-4">
                                            <strong>Petunjuk:</strong> Isikan makanan dan minuman yang dikonsumsi dalam 24 jam terakhir
                                        </div>
                                    
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <h6 class="text-primary mb-3">Pagi Hari</h6>
                                                
                                                <div class="form-group">
                                                    <label class="form-label">Makan Pagi</label>
                                                    <textarea class="form-control" name="recall_makan_pagi" rows="4" 
                                                              placeholder="Contoh: Nasi putih 1 centong, telur dadar 1 butir, sayur bayam 1 mangkok">{{ old('recall_makan_pagi', $dataGiziDewasa->recall_makan_pagi) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label">Snack Pagi</label>
                                                    <textarea class="form-control" name="recall_snack_pagi" rows="4" 
                                                              placeholder="Contoh: Biskuit 2 keping, susu kotak 200ml">{{ old('recall_snack_pagi', $dataGiziDewasa->recall_snack_pagi) }}</textarea>
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-6">
                                                <h6 class="text-primary mb-3">Siang Hari</h6>
                                                
                                                <div class="form-group">
                                                    <label class="form-label">Makan Siang</label>
                                                    <textarea class="form-control" name="recall_makan_siang" rows="4" 
                                                              placeholder="Contoh: Nasi putih 1.5 centong, ayam goreng 1 potong, sayur sop 1 mangkok">{{ old('recall_makan_siang', $dataGiziDewasa->recall_makan_siang) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label">Snack Sore</label>
                                                    <textarea class="form-control" name="recall_snack_sore" rows="4" 
                                                              placeholder="Contoh: Buah pisang 1 buah, air putih 1 gelas">{{ old('recall_snack_sore', $dataGiziDewasa->recall_snack_sore) }}</textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <h6 class="text-primary mb-3">Malam Hari</h6>
                                                
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Makan Malam</label>
                                                            <textarea class="form-control" name="recall_makan_malam" rows="4" 
                                                                      placeholder="Contoh: Nasi putih 1 centong, ikan bakar 1 potong, sayur kangkung 1 mangkok">{{ old('recall_makan_malam', $dataGiziDewasa->recall_makan_malam) }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Snack Malam</label>
                                                            <textarea class="form-control" name="recall_snack_malam" rows="4" 
                                                                      placeholder="Contoh: Susu hangat 1 gelas, roti tawar 1 potong">{{ old('recall_snack_malam', $dataGiziDewasa->recall_snack_malam) }}</textarea>
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
                                                    @php
                                                        $asupanOptions = [
                                                            'lebih' => ['label' => 'LEBIH', 'desc' => 'Asupan berlebihan', 'class' => 'text-success'],
                                                            'baik' => ['label' => 'BAIK', 'desc' => 'Sesuai kebutuhan', 'class' => 'text-primary'],
                                                            'kurang' => ['label' => 'KURANG', 'desc' => 'Kurang dari kebutuhan', 'class' => 'text-warning'],
                                                            'buruk' => ['label' => 'BURUK', 'desc' => 'Sangat kurang', 'class' => 'text-danger']
                                                        ];
                                                    @endphp

                                                    @foreach($asupanOptions as $value => $option)
                                                        <div class="col-md-3">
                                                            <div class="border rounded p-4 text-center">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="asupan_sebelum_rs" id="asupan_{{ $value }}" value="{{ $value }}"
                                                                           {{ old('asupan_sebelum_rs', $dataGiziDewasa->asupan_sebelum_rs) == $value ? 'checked' : '' }}>
                                                                    <label class="form-check-label w-100" for="asupan_{{ $value }}">
                                                                        <h6 class="{{ $option['class'] }} mb-2">{{ $option['label'] }}</h6>
                                                                        <p class="text-muted small mb-0">{{ $option['desc'] }}</p>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="asesmen-gizi">
                                        <h5 class="section-title">6. Asesmen Gizi</h5>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Berat Badan (kg)</label>
                                            <input type="number" class="form-control" name="berat_badan" id="berat_badan" step="0.1" 
                                                   placeholder="Contoh: 50.5" 
                                                   value="{{ old('berat_badan', $dataGiziDewasa->asesmenGizi ? number_format((float)$dataGiziDewasa->asesmenGizi->berat_badan, 1, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Tinggi Badan (cm)</label>
                                            <input type="number" class="form-control" name="tinggi_badan" id="tinggi_badan" step="0.1" 
                                                   placeholder="Contoh: 165"
                                                   value="{{ old('tinggi_badan', $dataGiziDewasa->asesmenGizi ? number_format((float)$dataGiziDewasa->asesmenGizi->tinggi_badan, 1, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">IMT (kg/m²)</label>
                                            <input type="number" class="form-control" name="imt" id="imt" step="0.01" 
                                                   placeholder="Akan dihitung otomatis" readonly
                                                   value="{{ old('imt', $dataGiziDewasa->asesmenGizi ? number_format((float)$dataGiziDewasa->asesmenGizi->imt, 2, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Berat Badan Ideal/BBI (kg)</label>
                                            <input type="number" class="form-control" name="bbi" id="bbi" step="0.1" 
                                                   placeholder="Akan dihitung otomatis" readonly
                                                   value="{{ old('bbi', $dataGiziDewasa->asesmenGizi ? number_format((float)$dataGiziDewasa->asesmenGizi->bbi, 1, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Biokimia</label>
                                            <textarea class="form-control" name="biokimia" rows="4"
                                                placeholder="Sebutkan biokimia...">{{ old('biokimia', $dataGiziDewasa->asesmenGizi->biokimia ?? '') }}</textarea>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Kimia/Fisik</label>
                                            <textarea class="form-control" name="kimia_fisik" rows="4"
                                                placeholder="Sebutkan kimia/fisik...">{{ old('kimia_fisik', $dataGiziDewasa->asesmenGizi->kimia_fisik ?? '') }}</textarea>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Gizi dll</label>
                                            <textarea class="form-control" name="riwayat_gizi" rows="4"
                                                placeholder="Sebutkan riwayat gizi...">{{ old('riwayat_gizi', $dataGiziDewasa->asesmenGizi->riwayat_gizi ?? '') }}</textarea>
                                        </div>
                                    
                                    </div>

                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">7. Riwayat Alergi</h5>

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
                                                    @if($alergiPasien && $alergiPasien->count() > 0)
                                                        @foreach($alergiPasien as $alergi)
                                                            <tr>
                                                                <td>{{ $alergi->jenis_alergi }}</td>
                                                                <td>{{ $alergi->nama_alergi }}</td>
                                                                <td>{{ $alergi->reaksi }}</td>
                                                                <td>{{ $alergi->tingkat_keparahan }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger btn-sm remove-alergi">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr id="no-alergi-row">
                                                            <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosa_gizi">
                                        <h5 class="section-title">8. Diagnosa Gizi</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Diagnosa Gizi</label>
                                            <textarea class="form-control" name="diagnosa_gizi" rows="4"
                                                placeholder="Sebutkan diagnosa gizi...">{{ old('diagnosa_gizi', $dataGiziDewasa->diagnosa_gizi) }}</textarea>
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
                                                                   value="{{ old('umur', $dataGiziDewasa->intervensiGizi->umur ?? $dataMedis->pasien->umur) }}" step="0.1" readonly 
                                                                   style="background-color: #f8f9fa;">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Faktor Aktivitas</label>
                                                            <select class="form-control" name="faktor_aktivitas" id="faktor_aktivitas">
                                                                <option value="">Pilih Faktor Aktivitas</option>
                                                                <option value="1.2" {{ old('faktor_aktivitas', $dataGiziDewasa->intervensiGizi->faktor_aktivitas ?? '') == '1.2' ? 'selected' : '' }}>1.2 - Bed rest</option>
                                                                <option value="1.3" {{ old('faktor_aktivitas', $dataGiziDewasa->intervensiGizi->faktor_aktivitas ?? '') == '1.3' ? 'selected' : '' }}>1.3 - Mobilitas terbatas</option>
                                                                <option value="1.5" {{ old('faktor_aktivitas', $dataGiziDewasa->intervensiGizi->faktor_aktivitas ?? '') == '1.5' ? 'selected' : '' }}>1.5 - Aktivitas ringan</option>
                                                                <option value="1.7" {{ old('faktor_aktivitas', $dataGiziDewasa->intervensiGizi->faktor_aktivitas ?? '') == '1.7' ? 'selected' : '' }}>1.7 - Aktivitas sedang</option>
                                                                <option value="1.9" {{ old('faktor_aktivitas', $dataGiziDewasa->intervensiGizi->faktor_aktivitas ?? '') == '1.9' ? 'selected' : '' }}>1.9 - Aktivitas berat</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Faktor Stress</label>
                                                            <select class="form-control" name="faktor_stress" id="faktor_stress">
                                                                <option value="">Pilih Faktor Stress</option>
                                                                <option value="1.0" {{ old('faktor_stress', $dataGiziDewasa->intervensiGizi->faktor_stress ?? '') == '1.0' ? 'selected' : '' }}>1.0 - Normal</option>
                                                                <option value="1.2" {{ old('faktor_stress', $dataGiziDewasa->intervensiGizi->faktor_stress ?? '') == '1.2' ? 'selected' : '' }}>1.2 - Demam ringan</option>
                                                                <option value="1.3" {{ old('faktor_stress', $dataGiziDewasa->intervensiGizi->faktor_stress ?? '') == '1.3' ? 'selected' : '' }}>1.3 - Infeksi ringan</option>
                                                                <option value="1.5" {{ old('faktor_stress', $dataGiziDewasa->intervensiGizi->faktor_stress ?? '') == '1.5' ? 'selected' : '' }}>1.5 - Operasi besar</option>
                                                                <option value="1.8" {{ old('faktor_stress', $dataGiziDewasa->intervensiGizi->faktor_stress ?? '') == '1.8' ? 'selected' : '' }}>1.8 - Trauma berat</option>
                                                                <option value="2.0" {{ old('faktor_stress', $dataGiziDewasa->intervensiGizi->faktor_stress ?? '') == '2.0' ? 'selected' : '' }}>2.0 - Luka bakar luas</option>
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
                                                                           placeholder="Akan dihitung otomatis" value="{{ old('bee', $dataGiziDewasa->intervensiGizi->bee ?? '') }}" readonly>
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
                                                                           placeholder="Sama dengan BEE" value="{{ old('bmr', $dataGiziDewasa->intervensiGizi->bmr ?? '') }}" readonly>
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
                                                                           placeholder="Akan dihitung otomatis" value="{{ old('tee', $dataGiziDewasa->intervensiGizi->tee ?? '') }}" readonly>
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
                                                                           placeholder="Sesuaikan dengan kondisi klinis" value="{{ old('kebutuhan_kalori', $dataGiziDewasa->intervensiGizi->kebutuhan_kalori ?? '') }}">
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
                                                                                   value="biasa" id="bentuk_biasa" {{ old('bentuk_makanan', $dataGiziDewasa->intervensiGizi->bentuk_makanan ?? '') == 'biasa' ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="bentuk_biasa">Biasa</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="bentuk_makanan" 
                                                                                   value="lunak" id="bentuk_lunak" {{ old('bentuk_makanan', $dataGiziDewasa->intervensiGizi->bentuk_makanan ?? '') == 'lunak' ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="bentuk_lunak">Lunak</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="bentuk_makanan" 
                                                                                   value="cair" id="bentuk_cair" {{ old('bentuk_makanan', $dataGiziDewasa->intervensiGizi->bentuk_makanan ?? '') == 'cair' ? 'checked' : '' }}>
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
                                                                                   value="oral" id="pemberian_oral" {{ old('cara_pemberian', $dataGiziDewasa->intervensiGizi->cara_pemberian ?? '') == 'oral' ? 'checked' : '' }}>
                                                                            <label class="form-check-label" for="pemberian_oral">Oral</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="cara_pemberian" 
                                                                                   value="ngt" id="pemberian_ngt" {{ old('cara_pemberian', $dataGiziDewasa->intervensiGizi->cara_pemberian ?? '') == 'ngt' ? 'checked' : '' }}>
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
                                                                                   id="protein_persen" placeholder="%" step="0.1" value="{{ old('protein_persen', $dataGiziDewasa->intervensiGizi->protein_persen ?? '') }}">
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="protein_gram" 
                                                                                   id="protein_gram" placeholder="gram" value="{{ old('protein_gram', $dataGiziDewasa->intervensiGizi->protein_gram ?? '') }}" readonly>
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
                                                                                   id="lemak_persen" placeholder="%" step="0.1" value="{{ old('lemak_persen', $dataGiziDewasa->intervensiGizi->lemak_persen ?? '') }}">
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="lemak_gram" 
                                                                                   id="lemak_gram" placeholder="gram" value="{{ old('lemak_gram', $dataGiziDewasa->intervensiGizi->lemak_gram ?? '') }}" readonly>
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
                                                                                   id="kh_persen" placeholder="%" step="0.1" value="{{ old('kh_persen', $dataGiziDewasa->intervensiGizi->kh_persen ?? '') }}">
                                                                            <span class="input-group-text">%</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="input-group input-group-sm">
                                                                            <input type="number" class="form-control" name="kh_gram" 
                                                                                   id="kh_gram" placeholder="gram" value="{{ old('kh_gram', $dataGiziDewasa->intervensiGizi->kh_gram ?? '') }}" readonly>
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
                                                                      placeholder="Contoh: Diet DM 1500 Kkal, Diet Jantung II, Diet Rendah Garam, dll">{{ old('jenis_diet', $dataGiziDewasa->intervensiGizi->jenis_diet ?? '') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label fw-bold">Rencana Monitoring</label>
                                                            <textarea class="form-control" name="rencana_monitoring" rows="3" 
                                                                      placeholder="Contoh: Monitoring BB setiap hari, evaluasi asupan makan, pemeriksaan lab rutin">{{ old('rencana_monitoring', $dataGiziDewasa->intervensiGizi->rencana_monitoring ?? '') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    
                                            <!-- Catatan Khusus -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Catatan Intervensi Gizi</label>
                                                    <textarea class="form-control" name="catatan_intervensi" rows="4" 
                                                              placeholder="Catatan khusus, anjuran, atau hal-hal penting lainnya terkait intervensi gizi">{{ old('catatan_intervensi', $dataGiziDewasa->intervensiGizi->catatan_intervensi ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end mt-4">
                                        <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/dewasa") }}" 
                                           class="btn btn-secondary me-2">
                                            <i class="ti-arrow-left"></i> Batal
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti-check"></i> Update
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

{{-- Include modal dan script yang sama dengan create --}}
@include('unit-pelayanan.rawat-inap.pelayanan.gizi.dewasa.modal-create-alergi')

{{-- CSS dari include file --}}
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

        .progress-wrapper {
            background: #f8f9fa;
            border-radius: 8px;
        }

        .progress-status {
            display: flex;
            justify-content: space-between;
        }

        .progress-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        .progress-percentage {
            color: #198754;
            font-weight: 600;
        }

        .custom-progress {
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-custom {
            height: 100%;
            background-color: #097dd6;
            transition: width 0.6s ease;
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
        }

        .form-label {
            margin-bottom: 0.8rem;
            font-weight: 500;
        }

        .form-group label {
            margin-right: 1rem;
            padding-top: 0.5rem;
        }

        .fw-bold {
            font-weight: 600;
        }

        textarea.form-control {
            resize: vertical;
            padding: 12px;
            line-height: 1.5;
        }

        h6 {
            font-weight: 600;
            font-size: 1rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .border {
            border: 1px solid #dee2e6 !important;
        }

        .rounded {
            border-radius: 8px !important;
        }

        .text-center {
            text-align: center !important;
        }

        .form-check-label {
            cursor: pointer;
        }

        .diagnosis-section {
            margin-top: 1.5rem;
        }

        .diagnosis-row {
            padding: 0.5rem 1rem;
            border-color: #dee2e6 !important;
        }

        .diagnosis-item {
            background-color: transparent;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }

        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
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

        .pain-scale-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        .pain-scale-image {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
@endpush

{{-- JavaScript dari include file --}}
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            //====================================================================================//
            // Event handler untuk tombol Tambah Riwayat
            //====================================================================================// 
            let riwayatArray = [];

            function updateRiwayatJson() {
                document.getElementById('riwayatJson').value = JSON.stringify(riwayatArray);
            }

            document.getElementById('btnTambahRiwayat')?.addEventListener('click', function() {
                // Reset input di modal saat dibuka
                document.getElementById('namaPenyakit').value = '';
                document.getElementById('namaObat').value = '';
            });

            document.getElementById('btnTambahRiwayatModal')?.addEventListener('click', function() {
                const namaPenyakit = document.getElementById('namaPenyakit').value.trim();
                const namaObat = document.getElementById('namaObat').value.trim();
                const tbody = document.querySelector('#riwayatTable tbody');

                if (namaPenyakit || namaObat) {
                    // Buat object untuk riwayat
                    const riwayatEntry = {
                        penyakit: namaPenyakit || '-',
                        obat: namaObat || '-'
                    };

                    // Tambahkan ke array
                    riwayatArray.push(riwayatEntry);

                    // Buat baris baru untuk tabel
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${namaPenyakit || '-'}</td>
                        <td>${namaObat || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm hapus-riwayat">Hapus</button>
                        </td>
                    `;

                    tbody.appendChild(row);

                    // Tambahkan event untuk tombol hapus
                    row.querySelector('.hapus-riwayat')?.addEventListener('click', function() {
                        const index = riwayatArray.findIndex(item =>
                            item.penyakit === (namaPenyakit || '-') &&
                            item.obat === (namaObat || '-')
                        );
                        if (index !== -1) {
                            riwayatArray.splice(index, 1);
                        }
                        row.remove();
                        updateRiwayatJson();
                    });

                    // Update hidden input
                    updateRiwayatJson();

                    // Tutup modal
                    bootstrap.Modal.getInstance(document.getElementById('riwayatModal')).hide();
                } else {
                    alert('Mohon isi setidaknya salah satu field (Penyakit atau Obat)');
                }
            });

            // Reset modal saat ditutup
            const riwayatModal = document.getElementById('riwayatModal');
            riwayatModal?.addEventListener('hidden.bs.modal', function() {
                document.getElementById('namaPenyakit').value = '';
                document.getElementById('namaObat').value = '';
            });

            //==================================================================================================//
            // Fungsi IMT dan BBI untuk Dewasa
            //==================================================================================================//
            // Fungsi untuk menghitung IMT dan BBI untuk dewasa
            function hitungIMTdanBBI() {
                const beratBadan = parseFloat(document.getElementById('berat_badan').value);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan').value);
                
                if (beratBadan && tinggiBadan) {
                    // Hitung IMT (kg/m²)
                    const tinggiMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiMeter * tinggiMeter);
                    document.getElementById('imt').value = imt.toFixed(2);
                    
                    // Hitung BBI untuk dewasa menggunakan rumus Broca yang disesuaikan
                    let bbi;
                    if (tinggiBadan <= 100) {
                        bbi = tinggiBadan - 100;
                    } else if (tinggiBadan <= 110) {
                        bbi = (tinggiBadan - 100) * 0.9;
                    } else {
                        bbi = (tinggiBadan - 100) * 0.9 - ((tinggiBadan - 110) * 0.1);
                    }
                    
                    // Untuk dewasa, BBI minimal 3 kg
                    if (bbi < 3) bbi = 3;
                    
                    document.getElementById('bbi').value = bbi.toFixed(1);
                }
            }

            //==================================================================================================//
            // Fungsi Perhitungan Kebutuhan Energi
            //==================================================================================================//
            function hitungKebutuhanEnergi() {
                const beratBadan = parseFloat(document.getElementById('berat_badan').value);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan').value);
                const umur = parseFloat(document.getElementById('umur').value);
                const faktorAktivitas = parseFloat(document.getElementById('faktor_aktivitas').value);
                const faktorStress = parseFloat(document.getElementById('faktor_stress').value);
                const jenisKelamin = parseInt(document.querySelector('input[name="jenis_kelamin"]').value);

                if (beratBadan && tinggiBadan && umur) {
                    let bee;
                    
                    // Hitung BEE berdasarkan jenis kelamin
                    if (jenisKelamin === 1) { // Laki-laki
                        bee = 66 + (13.7 * beratBadan) + (5 * tinggiBadan) - (6.8 * umur);
                    } else { // Perempuan
                        bee = 655 + (9.6 * beratBadan) + (1.7 * tinggiBadan) - (4.7 * umur);
                    }

                    document.getElementById('bee').value = Math.round(bee);
                    document.getElementById('bmr').value = Math.round(bee); // BMR = BEE

                    // Hitung TEE jika ada faktor aktivitas dan stress
                    if (faktorAktivitas && faktorStress) {
                        const tee = bee * faktorAktivitas * faktorStress;
                        document.getElementById('tee').value = Math.round(tee);
                        
                        // Set default kebutuhan kalori sama dengan TEE
                        if (!document.getElementById('kebutuhan_kalori').value) {
                            document.getElementById('kebutuhan_kalori').value = Math.round(tee);
                        }
                    }
                }
            }

            //==================================================================================================//
            // Fungsi Perhitungan Makronutrien
            //==================================================================================================//
            function hitungMakronutrien() {
                const kebutuhanKalori = parseFloat(document.getElementById('kebutuhan_kalori').value);
                const proteinPersen = parseFloat(document.getElementById('protein_persen').value);
                const lemakPersen = parseFloat(document.getElementById('lemak_persen').value);
                const khPersen = parseFloat(document.getElementById('kh_persen').value);

                if (kebutuhanKalori) {
                    // Hitung protein (1g protein = 4 kalori)
                    if (proteinPersen) {
                        const proteinKalori = (proteinPersen / 100) * kebutuhanKalori;
                        const proteinGram = proteinKalori / 4;
                        document.getElementById('protein_gram').value = Math.round(proteinGram);
                    }

                    // Hitung lemak (1g lemak = 9 kalori)
                    if (lemakPersen) {
                        const lemakKalori = (lemakPersen / 100) * kebutuhanKalori;
                        const lemakGram = lemakKalori / 9;
                        document.getElementById('lemak_gram').value = Math.round(lemakGram);
                    }

                    // Hitung karbohidrat (1g karbohidrat = 4 kalori)
                    if (khPersen) {
                        const khKalori = (khPersen / 100) * kebutuhanKalori;
                        const khGram = khKalori / 4;
                        document.getElementById('kh_gram').value = Math.round(khGram);
                    }
                }
            }

            // Event listener untuk input berat badan dan tinggi badan
            document.getElementById('berat_badan')?.addEventListener('input', function() {
                hitungIMTdanBBI();
                hitungKebutuhanEnergi();
            });
            
            document.getElementById('tinggi_badan')?.addEventListener('input', function() {
                hitungIMTdanBBI();
                hitungKebutuhanEnergi();
            });

            // Event listener untuk faktor aktivitas dan stress
            document.getElementById('faktor_aktivitas')?.addEventListener('change', hitungKebutuhanEnergi);
            document.getElementById('faktor_stress')?.addEventListener('change', hitungKebutuhanEnergi);

            // Event listener untuk perhitungan makronutrien
            document.getElementById('kebutuhan_kalori')?.addEventListener('input', hitungMakronutrien);
            document.getElementById('protein_persen')?.addEventListener('input', hitungMakronutrien);
            document.getElementById('lemak_persen')?.addEventListener('input', hitungMakronutrien);
            document.getElementById('kh_persen')?.addEventListener('input', hitungMakronutrien);

            //==================================================================================================//
            // Fungsi section riwayat gizi
            //==================================================================================================//
            document.getElementById('alergi_makanan_tidak')?.addEventListener('change', function() {
                if (this.checked) {
                    const textarea = document.getElementById('jenis_alergi');
                    textarea.style.backgroundColor = '#f8f9fa';
                    textarea.setAttribute('readonly', true);
                    textarea.value = '';
                }
            });

            document.getElementById('alergi_makanan_ya')?.addEventListener('change', function() {
                if (this.checked) {
                    const textarea = document.getElementById('jenis_alergi');
                    textarea.style.backgroundColor = '#ffffff';
                    textarea.removeAttribute('readonly');
                    textarea.focus();
                }
            });

            // Event listeners untuk pantangan makanan
            document.getElementById('pantangan_makanan_tidak')?.addEventListener('change', function() {
                if (this.checked) {
                    const textarea = document.getElementById('jenis_pantangan');
                    textarea.style.backgroundColor = '#f8f9fa';
                    textarea.setAttribute('readonly', true);
                    textarea.value = '';
                }
            });

            document.getElementById('pantangan_makanan_ya')?.addEventListener('change', function() {
                if (this.checked) {
                    const textarea = document.getElementById('jenis_pantangan');
                    textarea.style.backgroundColor = '#ffffff';
                    textarea.removeAttribute('readonly');
                    textarea.focus();
                }
            });

            //==================================================================================================//
            // Mencegah form submit dengan tombol Enter
            //==================================================================================================//

            // Fungsi untuk mencegah submit form ketika Enter ditekan
            function preventEnterSubmit(event) {
                // Jika yang ditekan adalah Enter (keyCode 13)
                if (event.keyCode === 13 || event.which === 13) {
                    // Jika bukan textarea, prevent default
                    if (event.target.tagName.toLowerCase() !== 'textarea') {
                        event.preventDefault();
                        return false;
                    }
                    // Jika textarea, hanya prevent jika tidak ada Shift yang ditekan
                    else if (event.target.tagName.toLowerCase() === 'textarea' && !event.shiftKey) {
                        // Biarkan Enter untuk baris baru di textarea
                        return true;
                    }
                }
            }

            // Terapkan ke semua input dan textarea dalam form
            const formElements = document.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], input[type="time"], select, textarea');
            formElements.forEach(function(element) {
                element.addEventListener('keypress', preventEnterSubmit);
            });

            // Alternatif: Terapkan ke seluruh form
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('keypress', function(event) {
                    if (event.keyCode === 13 || event.which === 13) {
                        // Kecuali jika target adalah textarea atau tombol submit
                        if (event.target.tagName.toLowerCase() !== 'textarea' && 
                            event.target.type !== 'submit') {
                            event.preventDefault();
                            return false;
                        }
                    }
                });
            }

            // Hitung nilai awal saat halaman load (untuk edit)
            hitungIMTdanBBI();
            hitungKebutuhanEnergi();
            hitungMakronutrien();
        });
    </script>

    {{-- Script untuk manajemen alergi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==========================================
            // Manajemen Data Alergi Modal - SIMPLE FIX
            // ==========================================

            // Array untuk menyimpan data alergi sementara
            let alergiDataArray = [];

            // Cek apakah data alergi dari PHP ada
            try {
                const existingAlergiData = @json($alergiPasien ?? []);
                alergiDataArray = existingAlergiData.map(item => ({
                    jenis_alergi: item.jenis_alergi || '',
                    alergen: item.nama_alergi || '',
                    reaksi: item.reaksi || '',
                    tingkat_keparahan: item.tingkat_keparahan || '',
                    is_existing: true,
                    id: item.id || null
                }));
            } catch (e) {
                console.log('Data alergi tidak tersedia');
                alergiDataArray = [];
            }

            // Event listeners dengan pengecekan element
            const openAlergiModal = document.getElementById('openAlergiModal');
            if (openAlergiModal) {
                openAlergiModal.addEventListener('click', function() {
                    updateModalAlergiList();
                });
            }

            const addToAlergiList = document.getElementById('addToAlergiList');
            if (addToAlergiList) {
                addToAlergiList.addEventListener('click', function() {
                    const jenisAlergi = document.getElementById('modal_jenis_alergi')?.value?.trim();
                    const alergen = document.getElementById('modal_alergen')?.value?.trim();
                    const reaksi = document.getElementById('modal_reaksi')?.value?.trim();
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        return;
                    }

                    const isDuplicate = alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        return;
                    }

                    alergiDataArray.push({
                        jenis_alergi: jenisAlergi,
                        alergen: alergen,
                        reaksi: reaksi,
                        tingkat_keparahan: tingkatKeparahan,
                        is_existing: false
                    });

                    updateModalAlergiList();
                    resetAlergiForm();
                });
            }

            const saveAlergiData = document.getElementById('saveAlergiData');
            if (saveAlergiData) {
                saveAlergiData.addEventListener('click', function() {
                    updateMainAlergiTable();
                    updateHiddenAlergiInput();

                    const alergiModal = document.getElementById('alergiModal');
                    if (alergiModal && typeof bootstrap !== 'undefined') {
                        const modalInstance = bootstrap.Modal.getInstance(alergiModal);
                        if (modalInstance) modalInstance.hide();
                    }
                });
            }

            // Fungsi update modal list
            function updateModalAlergiList() {
                const tbody = document.getElementById('modalAlergiList');
                const noDataMessage = document.getElementById('noAlergiMessage');
                const countBadge = document.getElementById('alergiCount');

                if (!tbody) return;

                tbody.innerHTML = '';

                if (alergiDataArray.length === 0) {
                    if (noDataMessage) noDataMessage.style.display = 'block';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'none';
                } else {
                    if (noDataMessage) noDataMessage.style.display = 'none';
                    const table = tbody.closest('table');
                    if (table) table.style.display = 'table';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeAlergiFromModal(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                                ${item.is_existing ? '<small class="text-muted d-block">Dari DB</small>' : '<small class="text-success d-block">Baru</small>'}
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }

                if (countBadge) countBadge.textContent = alergiDataArray.length;
            }

            // Fungsi update main table
            function updateMainAlergiTable() {
                const tbody = document.querySelector('#createAlergiTable tbody');
                const noAlergiRow = document.getElementById('no-alergi-row');

                if (!tbody || !noAlergiRow) return;

                const existingRows = tbody.querySelectorAll('tr:not(#no-alergi-row)');
                existingRows.forEach(row => row.remove());

                if (alergiDataArray.length === 0) {
                    noAlergiRow.style.display = 'table-row';
                } else {
                    noAlergiRow.style.display = 'none';

                    alergiDataArray.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.jenis_alergi}</td>
                            <td>${item.alergen}</td>
                            <td>${item.reaksi}</td>
                            <td>
                                <span class="badge ${getKeparahanBadgeClass(item.tingkat_keparahan)}">
                                    ${item.tingkat_keparahan}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeAlergiFromMain(${index})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            }

            function updateHiddenAlergiInput() {
                const hiddenInput = document.getElementById('alergisInput');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(alergiDataArray);
                }
            }

            function resetAlergiForm() {
                const fields = ['modal_jenis_alergi', 'modal_alergen', 'modal_reaksi', 'modal_tingkat_keparahan'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }

            function getKeparahanBadgeClass(keparahan) {
                switch (keparahan.toLowerCase()) {
                    case 'ringan':
                        return 'bg-success';
                    case 'sedang':
                        return 'bg-warning';
                    case 'berat':
                        return 'bg-danger';
                    default:
                        return 'bg-secondary';
                }
            }

            // Fungsi global untuk onclick
            window.removeAlergiFromModal = function(index) {
                alergiDataArray.splice(index, 1);
                updateModalAlergiList();
            };

            window.removeAlergiFromMain = function(index) {
                alergiDataArray.splice(index, 1);
                updateMainAlergiTable();
                updateHiddenAlergiInput();
            };

            // Load awal
            updateMainAlergiTable();
        });
    </script>
@endpush

       