@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/anak") }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Edit Pengkajian Gizi Anak</h4>
                                    <p>
                                        Pastikan semua data yang diperlukan telah diisi dengan benar. Setelah selesai, klik tombol "Update" untuk menyimpan perubahan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM edit gizi anak --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.gizi.anak.update', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                                'id' => $dataPengkajianGizi->id
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
                                                       value="{{ \Carbon\Carbon::parse($dataPengkajianGizi->waktu_asesmen)->format('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk" 
                                                       value="{{ \Carbon\Carbon::parse($dataPengkajianGizi->waktu_asesmen)->format('H:i') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis Medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Masukkan diagnosis medis" 
                                                value="{{ old('diagnosis_medis', $dataPengkajianGizi->diagnosis_medis) }}" required>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="riwayat-gizi">
                                        <h5 class="section-title">2. Asuhan Gizi Anak</h5>
                                    
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
                                                                       {{ old('makan_pagi', $dataPengkajianGizi->makan_pagi) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_pagi_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_pagi" id="makan_pagi_tidak" value="tidak"
                                                                       {{ old('makan_pagi', $dataPengkajianGizi->makan_pagi) == 'tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_pagi_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="border rounded p-3">
                                                            <h6 class="mb-2 text-primary">Siang</h6>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_siang" id="makan_siang_ya" value="ya"
                                                                       {{ old('makan_siang', $dataPengkajianGizi->makan_siang) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_siang_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_siang" id="makan_siang_tidak" value="tidak"
                                                                       {{ old('makan_siang', $dataPengkajianGizi->makan_siang) == 'tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_siang_tidak">Tidak</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="border rounded p-3">
                                                            <h6 class="mb-2 text-primary">Malam</h6>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_malam" id="makan_malam_ya" value="ya"
                                                                       {{ old('makan_malam', $dataPengkajianGizi->makan_malam) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="makan_malam_ya">Ya</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="makan_malam" id="makan_malam_tidak" value="tidak"
                                                                       {{ old('makan_malam', $dataPengkajianGizi->makan_malam) == 'tidak' ? 'checked' : '' }}>
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
                                                       value="{{ old('frekuensi_ngemil', $dataPengkajianGizi->frekuensi_ngemil ?? 0) }}">
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
                                                                       value="tidak" {{ old('alergi_makanan', $dataPengkajianGizi->alergi_makanan) == 'tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="alergi_makanan_tidak">
                                                                    <strong>Tidak</strong>
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline mb-3">
                                                                <input class="form-check-input" type="radio" name="alergi_makanan" id="alergi_makanan_ya" 
                                                                       value="ya" {{ old('alergi_makanan', $dataPengkajianGizi->alergi_makanan) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="alergi_makanan_ya">
                                                                    <strong>Ya</strong>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <label class="form-label text-muted">Jenis alergi makanan:</label>
                                                            <textarea class="form-control" name="jenis_alergi" id="jenis_alergi" rows="3" 
                                                                      placeholder="Contoh: Telur, susu, kacang tanah, seafood, dll"
                                                                      {{ old('alergi_makanan', $dataPengkajianGizi->alergi_makanan) != 'ya' ? 'readonly style=background-color:#f8f9fa;' : '' }}>{{ old('jenis_alergi', $dataPengkajianGizi->jenis_alergi) }}</textarea>
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
                                                                       value="tidak" {{ old('pantangan_makanan', $dataPengkajianGizi->pantangan_makanan) == 'tidak' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="pantangan_makanan_tidak">
                                                                    <strong>Tidak</strong>
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline mb-3">
                                                                <input class="form-check-input" type="radio" name="pantangan_makanan" id="pantangan_makanan_ya" 
                                                                       value="ya" {{ old('pantangan_makanan', $dataPengkajianGizi->pantangan_makanan) == 'ya' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="pantangan_makanan_ya">
                                                                    <strong>Ya</strong>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <label class="form-label text-muted">Jenis pantangan makanan:</label>
                                                            <textarea class="form-control" name="jenis_pantangan" id="jenis_pantangan" rows="3" 
                                                                      placeholder="Contoh: Makanan pedas, makanan berlemak, makanan tinggi garam, dll"
                                                                      {{ old('pantangan_makanan', $dataPengkajianGizi->pantangan_makanan) != 'ya' ? 'readonly style=background-color:#f8f9fa;' : '' }}>{{ old('jenis_pantangan', $dataPengkajianGizi->jenis_pantangan) }}</textarea>
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
                                                            $gangguanGi = explode(',', old('gangguan_gi', $dataPengkajianGizi->gangguan_gi ?? ''));
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
                                                                       {{ old('frekuensi_makan_rs', $dataPengkajianGizi->frekuensi_makan_rs) == 'lebih_3x' ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="frekuensi_lebih">
                                                                    <strong>Makan > 3x/hari</strong>
                                                                    <small class="text-muted d-block">Termasuk makan utama dan selingan</small>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="frekuensi_makan_rs" id="frekuensi_kurang" value="kurang_3x"
                                                                       {{ old('frekuensi_makan_rs', $dataPengkajianGizi->frekuensi_makan_rs) == 'kurang_3x' ? 'checked' : '' }}>
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
                                                              placeholder="Contoh: Nasi, roti, kentang, mie, bubur">{{ old('makanan_pokok', $dataPengkajianGizi->makanan_pokok) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Lauk Hewani</label>
                                                    <textarea class="form-control" name="lauk_hewani" rows="4" 
                                                              placeholder="Contoh: Ayam, ikan, daging, telur, susu, keju">{{ old('lauk_hewani', $dataPengkajianGizi->lauk_hewani) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Lauk Nabati</label>
                                                    <textarea class="form-control" name="lauk_nabati" rows="4" 
                                                              placeholder="Contoh: Tahu, tempe, kacang-kacangan">{{ old('lauk_nabati', $dataPengkajianGizi->lauk_nabati) }}</textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Sayur-sayuran</label>
                                                    <textarea class="form-control" name="sayuran" rows="4" 
                                                              placeholder="Contoh: Bayam, kangkung, wortel, brokoli">{{ old('sayuran', $dataPengkajianGizi->sayuran) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Buah-buahan</label>
                                                    <textarea class="form-control" name="buah_buahan" rows="4" 
                                                              placeholder="Contoh: Pisang, apel, jeruk, pepaya">{{ old('buah_buahan', $dataPengkajianGizi->buah_buahan) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">Minuman</label>
                                                    <textarea class="form-control" name="minuman" rows="4" 
                                                              placeholder="Contoh: Air putih, susu, jus buah, teh">{{ old('minuman', $dataPengkajianGizi->minuman) }}</textarea>
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
                                                              placeholder="Contoh: Nasi putih 1 centong, telur dadar 1 butir, sayur bayam 1 mangkok">{{ old('recall_makan_pagi', $dataPengkajianGizi->recall_makan_pagi) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label">Snack Pagi</label>
                                                    <textarea class="form-control" name="recall_snack_pagi" rows="4" 
                                                              placeholder="Contoh: Biskuit 2 keping, susu kotak 200ml">{{ old('recall_snack_pagi', $dataPengkajianGizi->recall_snack_pagi) }}</textarea>
                                                </div>
                                            </div>
                                    
                                            <div class="col-md-6">
                                                <h6 class="text-primary mb-3">Siang Hari</h6>
                                                
                                                <div class="form-group">
                                                    <label class="form-label">Makan Siang</label>
                                                    <textarea class="form-control" name="recall_makan_siang" rows="4" 
                                                              placeholder="Contoh: Nasi putih 1.5 centong, ayam goreng 1 potong, sayur sop 1 mangkok">{{ old('recall_makan_siang', $dataPengkajianGizi->recall_makan_siang) }}</textarea>
                                                </div>
                                    
                                                <div class="form-group">
                                                    <label class="form-label">Snack Sore</label>
                                                    <textarea class="form-control" name="recall_snack_sore" rows="4" 
                                                              placeholder="Contoh: Buah pisang 1 buah, air putih 1 gelas">{{ old('recall_snack_sore', $dataPengkajianGizi->recall_snack_sore) }}</textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <h6 class="text-primary mb-3">Malam Hari</h6>
                                                
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Makan Malam</label>
                                                            <textarea class="form-control" name="recall_makan_malam" rows="4" 
                                                                      placeholder="Contoh: Nasi putih 1 centong, ikan bakar 1 potong, sayur kangkung 1 mangkok">{{ old('recall_makan_malam', $dataPengkajianGizi->recall_makan_malam) }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Snack Malam</label>
                                                            <textarea class="form-control" name="recall_snack_malam" rows="4" 
                                                                      placeholder="Contoh: Susu hangat 1 gelas, roti tawar 1 potong">{{ old('recall_snack_malam', $dataPengkajianGizi->recall_snack_malam) }}</textarea>
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
                                                                           {{ old('asupan_sebelum_rs', $dataPengkajianGizi->asupan_sebelum_rs) == $value ? 'checked' : '' }}>
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
                                                   placeholder="Contoh: 8.5" 
                                                   value="{{ old('berat_badan', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->berat_badan, 1, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Tinggi Badan (cm)</label>
                                            <input type="number" class="form-control" name="tinggi_badan" id="tinggi_badan" step="0.1" 
                                                   placeholder="Contoh: 75.5"
                                                   value="{{ old('tinggi_badan', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->tinggi_badan, 1, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">IMT (kg/m²)</label>
                                            <input type="number" class="form-control" name="imt" id="imt" step="0.01" 
                                                   placeholder="Akan dihitung otomatis" readonly
                                                   value="{{ old('imt', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->imt, 2, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Berat Badan Ideal/BBI (kg)</label>
                                            <input type="number" class="form-control" name="bbi" id="bbi" step="0.1" 
                                                   placeholder="Akan dihitung otomatis" readonly
                                                   value="{{ old('bbi', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->bbi, 1, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Status Gizi</label>
                                            <select class="form-control" name="status_gizi" id="status_gizi">
                                                <option value="">Pilih Status Gizi</option>
                                                @php
                                                    $statusGiziOptions = [
                                                        'Gizi Buruk' => 'Gizi Buruk',
                                                        'Gizi Kurang' => 'Gizi Kurang',
                                                        'Gizi Baik/Normal' => 'Gizi Baik/Normal',
                                                        'Gizi Lebih' => 'Gizi Lebih',
                                                        'Obesitas' => 'Obesitas'
                                                    ];
                                                @endphp
                                                @foreach($statusGiziOptions as $value => $label)
                                                    <option value="{{ $value }}" 
                                                            {{ old('status_gizi', $dataPengkajianGizi->asesmenGizi->status_gizi ?? '') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">BB/Usia (Z-Score)</label>
                                            <input type="number" class="form-control" name="bb_usia" step="0.01" 
                                                   placeholder="Contoh: -1.5"
                                                   value="{{ old('bb_usia', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->bb_usia, 2, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">BB/TB (Z-Score)</label>
                                            <input type="number" class="form-control" name="bb_tb" step="0.01" 
                                                   placeholder="Contoh: -2.0"
                                                   value="{{ old('bb_tb', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->bb_tb, 2, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">PB(TB)/Usia (Z-Score)</label>
                                            <input type="number" class="form-control" name="pb_tb_usia" step="0.01" 
                                                   placeholder="Contoh: -1.8"
                                                   value="{{ old('pb_tb_usia', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->pb_tb_usia, 2, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">IMT/Usia (Z-Score)</label>
                                            <input type="number" class="form-control" name="imt_usia" step="0.01" 
                                                   placeholder="Contoh: -1.2"
                                                   value="{{ old('imt_usia', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->imt_usia, 2, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Lingkar Kepala (cm)</label>
                                            <input type="number" class="form-control" name="lingkar_kepala" step="0.1" 
                                                   placeholder="Contoh: 45.5"
                                                   value="{{ old('lingkar_kepala', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->lingkar_kepala, 1, '.', '') : '') }}">
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Biokimia</label>
                                            <textarea class="form-control" name="biokimia" rows="4"
                                                placeholder="Sebutkan biokimia...">{{ old('biokimia', $dataPengkajianGizi->asesmenGizi->biokimia ?? '') }}</textarea>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Kimia/Fisik</label>
                                            <textarea class="form-control" name="kimia_fisik" rows="4"
                                                placeholder="Sebutkan kimia/fisik...">{{ old('kimia_fisik', $dataPengkajianGizi->asesmenGizi->kimia_fisik ?? '') }}</textarea>
                                        </div>
                                    
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Gizi dll</label>
                                            <textarea class="form-control" name="riwayat_gizi" rows="4"
                                                placeholder="Sebutkan riwayat gizi...">{{ old('riwayat_gizi', $dataPengkajianGizi->asesmenGizi->riwayat_gizi ?? '') }}</textarea>
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
                                                placeholder="Sebutkan diagnosa gizi...">{{ old('diagnosa_gizi', $dataPengkajianGizi->diagnosa_gizi) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="intervensi-gizi">
                                        <h5 class="section-title">9. Intervensi Gizi</h5>
                                        
                                        <div class="alert alert-info mb-4">
                                            <strong>Informasi:</strong> Berikut adalah panduan kebutuhan gizi berdasarkan kelompok umur dan jenis kelamin
                                        </div>
                                    
                                        <div class="row g-4">
                                            <!-- Tabel Kebutuhan Gizi -->
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">KEBUTUHAN GIZI</h6>
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-dark">
                                                            <tr class="text-center">
                                                                <th rowspan="2">GOL UMUR (thn)</th>
                                                                <th colspan="2">PRIA</th>
                                                                <th rowspan="2">GOL UMUR (thn)</th>
                                                                <th colspan="2">WANITA</th>
                                                            </tr>
                                                            <tr class="text-center">
                                                                <th>(Kkal/kg BB)</th>
                                                                <th>(Kkal/kg BB)</th>
                                                                <th>(Kkal/kg BB)</th>
                                                                <th>(Kkal/kg BB)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="text-center">
                                                                <td><strong>0-1</strong></td>
                                                                <td>110-120</td>
                                                                <td>110-120</td>
                                                                <td><strong>6-9</strong></td>
                                                                <td>80-90</td>
                                                                <td>60-80</td>
                                                            </tr>
                                                            <tr class="text-center">
                                                                <td><strong>1-3</strong></td>
                                                                <td>100</td>
                                                                <td>100</td>
                                                                <td><strong>10-13</strong></td>
                                                                <td>50-70</td>
                                                                <td>40-55</td>
                                                            </tr>
                                                            <tr class="text-center">
                                                                <td><strong>4-6</strong></td>
                                                                <td>90</td>
                                                                <td>90</td>
                                                                <td><strong>14-18</strong></td>
                                                                <td>40-50</td>
                                                                <td>40</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                    
                                            <!-- Informasi Tambahan -->
                                            <div class="col-md-12 mt-4">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="border rounded p-4 bg-light">
                                                            <h6 class="text-success mb-3">Catatan Penting</h6>
                                                            <ul class="list-unstyled mb-0">
                                                                <li class="mb-2">• Kebutuhan kalori disesuaikan dengan kondisi klinis anak</li>
                                                                <li class="mb-2">• Monitoring dilakukan secara berkala</li>
                                                                <li class="mb-2">• Evaluasi berdasarkan respons klinis dan antropometri</li>
                                                                <li class="mb-0">• Konsultasi dengan ahli gizi untuk penyesuaian diet</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="border rounded p-4 bg-light">
                                                            <h6 class="text-warning mb-3">Panduan Umum</h6>
                                                            <ul class="list-unstyled mb-0">
                                                                <li class="mb-2">• Berikan makanan sesuai kelompok umur</li>
                                                                <li class="mb-2">• Perhatikan tekstur makanan untuk anak</li>
                                                                <li class="mb-2">• Hindari makanan yang dapat menyebabkan alergi</li>
                                                                <li class="mb-0">• Pastikan kebersihan makanan dan alat makan</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end mt-4">
                                        <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/gizi/anak") }}" 
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
@include('unit-pelayanan.rawat-inap.pelayanan.gizi.anak.modal-create-alergi')

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
            // Fungsi IMT dan BBI
            //==================================================================================================//
            // Fungsi untuk menghitung IMT dan BBI
            function hitungIMTdanBBI() {
                const beratBadan = parseFloat(document.getElementById('berat_badan').value);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan').value);
                
                if (beratBadan && tinggiBadan) {
                    // Hitung IMT (kg/m²)
                    const tinggiMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiMeter * tinggiMeter);
                    document.getElementById('imt').value = imt.toFixed(2);
                    
                    // Hitung BBI untuk anak menggunakan rumus Broca yang disesuaikan
                    let bbi;
                    if (tinggiBadan <= 100) {
                        bbi = tinggiBadan - 100;
                    } else if (tinggiBadan <= 110) {
                        bbi = (tinggiBadan - 100) * 0.9;
                    } else {
                        bbi = (tinggiBadan - 100) * 0.9 - ((tinggiBadan - 110) * 0.1);
                    }
                    
                    // Untuk anak, BBI minimal 3 kg
                    if (bbi < 3) bbi = 3;
                    
                    document.getElementById('bbi').value = bbi.toFixed(1);
                }
            }

            // Event listener untuk input berat badan dan tinggi badan
            document.getElementById('berat_badan')?.addEventListener('input', hitungIMTdanBBI);
            document.getElementById('tinggi_badan')?.addEventListener('input', hitungIMTdanBBI);

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

            // Hitung IMT dan BBI saat halaman load (untuk edit)
            hitungIMTdanBBI();

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