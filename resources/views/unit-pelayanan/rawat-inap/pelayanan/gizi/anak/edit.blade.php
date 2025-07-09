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
                                        <h5 class="section-title">1. Tanggal Pengisian</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Pengisian</label>
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
                                                            $gangguanGi = old('gangguan_gi', 
                                                                $dataPengkajianGizi->gangguan_gi_array ?? 
                                                                ($dataPengkajianGizi->gangguan_gi ? explode(',', $dataPengkajianGizi->gangguan_gi) : [])
                                                            );
                                                            
                                                            if (is_string($gangguanGi)) {
                                                                $gangguanGi = explode(',', $gangguanGi);
                                                            }
                                                            
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

                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">Riwayat Alergi</h5>

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

                                    <div class="section-separator" id="antropometri">
                                        <h5 class="section-title">6. Antropometri</h5>

                                        <div class="alert alert-info mb-4">
                                            <strong>Informasi:</strong> Z-Score akan dihitung otomatis berdasarkan standar WHO Child Growth Standards 2006
                                        </div>
                                
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Kelamin</label>
                                            <input type="text" class="form-control bg-light" name="jenis_kelamin_display" 
                                                value="{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}" 
                                                readonly style="background-color: #f8f9fa;">
                                            
                                            <!-- Hidden inputs untuk WHO database -->
                                            <input type="hidden" name="jenis_kelamin" value="{{ $dataMedis->pasien->jenis_kelamin }}">
                                            <input type="hidden" name="jenis_kelamin_who" id="jenis_kelamin_who" 
                                                   value="{{ $dataMedis->pasien->jenis_kelamin == 1 ? 1 : ($dataMedis->pasien->jenis_kelamin == 0 ? 2 : null) }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Umur dan Tanggal Lahir</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="text" class="form-control bg-light" name="umur_display" 
                                                    value="{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->diffInMonths(\Carbon\Carbon::now()) : 'Tidak Diketahui' }} Bulan" 
                                                    readonly style="background-color: #f8f9fa;">
                                                <input type="text" class="form-control bg-light" name="tgl_lahir_display" 
                                                    value="{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }}" 
                                                    readonly style="background-color: #f8f9fa;">
                                            </div>
                                            <!-- Hidden inputs untuk perhitungan -->
                                            <input type="hidden" name="umur_tahun" value="{{ $dataMedis->pasien->umur }}">
                                            <input type="hidden" name="tgl_lahir" value="{{ $dataMedis->pasien->tgl_lahir }}">
                                            <input type="hidden" name="umur_bulan" id="umur_bulan" 
                                                value="{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->diffInMonths(\Carbon\Carbon::now()) : 0 }}">
                                        </div>

                                        <div class="row g-3 mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 220px;">Berat Badan (kg) <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="berat_badan" id="berat_badan" step="0.1" 
                                                           placeholder="Contoh: 8.5" required
                                                           value="{{ old('berat_badan', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->berat_badan, 1, '.', '') : '') }}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 220px;">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="tinggi_badan" id="tinggi_badan" step="0.1" 
                                                           placeholder="Contoh: 75.5" required
                                                           value="{{ old('tinggi_badan', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->tinggi_badan, 1, '.', '') : '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 220px;">Lingkar Kepala (cm)</label>
                                                    <input type="number" class="form-control" name="lingkar_kepala" step="0.1" 
                                                        placeholder="Contoh: 45.5"
                                                        value="{{ old('lingkar_kepala', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->lingkar_kepala, 1, '.', '') : '') }}">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label style="min-width: 220px;">Berat Badan Ideal/BBI (kg)</label>
                                                    <input type="number" class="form-control bg-light" name="bbi" id="bbi" step="0.1" 
                                                           placeholder="Akan dihitung otomatis" readonly style="background-color: #f8f9fa;"
                                                           value="{{ old('bbi', $dataPengkajianGizi->asesmenGizi->bbi ? number_format((float)$dataPengkajianGizi->asesmenGizi->bbi, 1, '.', '') : '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Z-Score Results -->
                                        <div class="mt-4">
                                            <h6 class="text-primary mb-3">
                                                <i class="fas fa-chart-line"></i> Hasil Z-Score (WHO Child Growth Standards)
                                            </h6>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label style="min-width: 220px;">BB/Usia (Z-Score)</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control bg-light" name="bb_usia" id="bb_usia" step="0.01" 
                                                                placeholder="Auto calculate"
                                                                value="{{ old('bb_usia', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->bb_usia, 2, '.', '') : '') }}">
                                                        </div>
                                                        <select class="form-select bg-light mt-2" name="bb_usia_status" id="bb_usia_status">
                                                            <option value="">Pilih Status</option>
                                                            <option value="severely_underweight">Severely Underweight (< -3 SD)</option>
                                                            <option value="underweight">Underweight (-3 SD s/d < -2 SD)</option>
                                                            <option value="normal">Normal (-2 SD s/d +1 SD)</option>
                                                            <option value="overweight">Overweight (> +1 SD)</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label style="min-width: 220px;">PB(TB)/Usia (Z-Score)</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control bg-light" name="pb_tb_usia" id="pb_tb_usia" step="0.01" 
                                                                placeholder="Auto calculate"
                                                                value="{{ old('pb_tb_usia', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->pb_tb_usia, 2, '.', '') : '') }}">
                                                        </div>
                                                        <select class="form-select bg-light mt-2" name="pb_tb_usia_status" id="pb_tb_usia_status">
                                                            <option value="">Pilih Status</option>
                                                            <option value="severely_stunted">Severely Stunted (< -3 SD)</option>
                                                            <option value="stunted">Stunted (-3 SD s/d < -2 SD)</option>
                                                            <option value="normal">Normal (-2 SD s/d +3 SD)</option>
                                                            <option value="tall">Tall (> +3 SD)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mt-2">
                                                    <div class="form-group">
                                                        <label style="min-width: 220px;">BB/TB(PB) (Z-Score)</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control bg-light" name="bb_tb" id="bb_tb" step="0.01" 
                                                                placeholder="Auto calculate"
                                                                value="{{ old('bb_tb', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->bb_tb, 2, '.', '') : '') }}">
                                                        </div>
                                                        <select class="form-select bg-light mt-2" name="bb_tb_status" id="bb_tb_status">
                                                            <option value="">Pilih Status</option>
                                                            <option value="severely_wasted">Severely Wasted (< -3 SD)</option>
                                                            <option value="wasted">Wasted (-3 SD s/d < -2 SD)</option>
                                                            <option value="normal">Normal (-2 SD s/d +1 SD)</option>
                                                            <option value="overweight">Overweight (+1 SD s/d +2 SD)</option>
                                                            <option value="obese">Obese (> +2 SD)</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label style="min-width: 220px;">IMT/Usia (Z-Score)</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control bg-light" name="imt_usia" id="imt_usia" step="0.01" 
                                                                placeholder="Auto calculate"
                                                                value="{{ old('imt_usia', $dataPengkajianGizi->asesmenGizi ? number_format((float)$dataPengkajianGizi->asesmenGizi->imt_usia, 2, '.', '') : '') }}">
                                                        </div>
                                                        <select class="form-select bg-light mt-2" name="imt_usia_status" id="imt_usia_status">
                                                            <option value="">Pilih Status</option>
                                                            <option value="severely_underweight">Severely Underweight (< -3 SD)</option>
                                                            <option value="underweight">Underweight (-3 SD s/d < -2 SD)</option>
                                                            <option value="normal">Normal (-2 SD s/d +1 SD)</option>
                                                            <option value="overweight">Overweight (+1 SD s/d +2 SD)</option>
                                                            <option value="obese">Obese (> +2 SD)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4" id="stunting_section" style="display: none;">
                                            <h6 class="text-warning mb-3">
                                                <i class="fas fa-exclamation-triangle"></i> Status Gizi Khusus
                                            </h6>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label style="min-width: 220px;">Status Stunting</label>
                                                        <input type="text" class="form-control bg-light" name="status_stunting" 
                                                               id="status_stunting" readonly 
                                                               style="background-color: #f8f9fa; font-weight: 600;"
                                                               value="{{ old('status_stunting', $dataPengkajianGizi->asesmenGizi->status_stunting ?? '') }}">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="alert alert-info mb-0" style="font-size: 0.875rem;">
                                                        <strong>Keterangan:</strong><br>
                                                        BB/Usia &lt; PB(TB)/Usia = Stunting<br>
                                                        BB/Usia ≥ PB(TB)/Usia = Tidak Stunting
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>

                                    <div class="section-separator" id="intervensi-gizi">
                                        <h5 class="section-title">Intervensi Gizi</h5>
                                        
                                        <div class="alert alert-info mb-4" id="info_normal">
                                            <strong>Informasi:</strong> Berikut adalah panduan kebutuhan gizi berdasarkan kelompok umur dan jenis kelamin
                                        </div>
                                        
                                        <div class="alert alert-warning mb-4" id="info_gizi_buruk" style="display: none;">
                                            <strong>Peringatan:</strong> Terdeteksi status gizi buruk (Severely Wasted). Menggunakan protokol rehabilitasi gizi buruk dengan fase bertahap.
                                        </div>
                                    
                                        <div class="row g-4">
                                            <!-- Tabel Kebutuhan Gizi Normal -->
                                            <div class="col-md-12" id="table_normal">
                                                <h6 class="mb-3 text-primary">KEBUTUHAN GIZI NORMAL</h6>
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-dark">
                                                            <tr class="text-center">
                                                                <th>GOL UMUR (thn)</th>
                                                                <th>PRIA (Kkal/kg BB)</th>
                                                                <th>WANITA (Kkal/kg BB)</th>
                                                                <th>GOL UMUR (thn)</th>
                                                                <th>PRIA (Kkal/kg BB)</th>
                                                                <th>WANITA (Kkal/kg BB)</th>
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
                                            
                                            <!-- Tabel Kebutuhan Gizi Buruk -->
                                            <div class="col-md-12" id="table_gizi_buruk" style="display: none;">
                                                <h6 class="mb-3 text-danger">PROTOKOL REHABILITASI GIZI BURUK</h6>
                                                
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped">
                                                        <thead class="table-danger">
                                                            <tr class="text-center">
                                                                <th width="20%">FASE REHABILITASI</th>
                                                                <th width="25%">KEBUTUHAN KALORI (Kkal/kg BB)</th>
                                                                <th width="25%">PROTEIN (gr/kg BB)</th>
                                                                <th width="30%">LEMAK (gr/kg BB)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="text-center">
                                                                <td><strong>Stabilisasi</strong></td>
                                                                <td class="text-primary"><strong>80-100</strong></td>
                                                                <td class="text-success"><strong>1-1.5</strong></td>
                                                                <td class="text-warning"><strong>0.5-1</strong></td>
                                                            </tr>
                                                            <tr class="text-center">
                                                                <td><strong>Transisi</strong></td>
                                                                <td class="text-primary"><strong>100-150</strong></td>
                                                                <td class="text-success"><strong>2-3</strong></td>
                                                                <td class="text-warning"><strong>1-1.5</strong></td>
                                                            </tr>
                                                            <tr class="text-center">
                                                                <td><strong>Rehabilitasi</strong></td>
                                                                <td class="text-primary"><strong>150-220</strong></td>
                                                                <td class="text-success"><strong>4-6</strong></td>
                                                                <td class="text-warning"><strong>2</strong></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <small class="text-muted">
                                                        <strong>Catatan:</strong> Karbohidrat dihitung otomatis sebagai sisa dari total kebutuhan kalori setelah dikurangi kalori protein dan lemak.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <!-- Perhitungan Kebutuhan Kalori -->
                                        <div class="row g-4 mt-2">
                                            <div class="col-md-12">
                                                <h6 class="mb-3 text-primary">PERHITUNGAN KEBUTUHAN KALORI</h6>
                                                
                                                <div class="row g-3">
                                                    <!-- Pilihan Normal: Golongan Umur -->
                                                    <div class="col-md-4" id="pilihan_normal">
                                                        <div class="form-group">
                                                            <label style="min-width: 200px;">Golongan Umur</label>
                                                            <select class="form-select" name="golongan_umur" id="golongan_umur">
                                                                <option value="">Pilih Golongan Umur</option>
                                                                <option value="1" {{ old('golongan_umur', $dataPengkajianGizi->intervensiGizi->golongan_umur ?? '') == '1' ? 'selected' : '' }}>0-1 Tahun</option>
                                                                <option value="2" {{ old('golongan_umur', $dataPengkajianGizi->intervensiGizi->golongan_umur ?? '') == '2' ? 'selected' : '' }}>1-3 Tahun</option>
                                                                <option value="3" {{ old('golongan_umur', $dataPengkajianGizi->intervensiGizi->golongan_umur ?? '') == '3' ? 'selected' : '' }}>4-6 Tahun</option>
                                                                <option value="4" {{ old('golongan_umur', $dataPengkajianGizi->intervensiGizi->golongan_umur ?? '') == '4' ? 'selected' : '' }}>6-9 Tahun</option>
                                                                <option value="5" {{ old('golongan_umur', $dataPengkajianGizi->intervensiGizi->golongan_umur ?? '') == '5' ? 'selected' : '' }}>10-13 Tahun</option>
                                                                <option value="6" {{ old('golongan_umur', $dataPengkajianGizi->intervensiGizi->golongan_umur ?? '') == '6' ? 'selected' : '' }}>14-18 Tahun</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Pilihan Gizi Buruk: Fase -->
                                                    <div class="col-md-4" id="pilihan_gizi_buruk" style="display: none;">
                                                        <div class="form-group">
                                                            <label style="min-width: 200px;">Fase</label>
                                                            <select class="form-select" name="golongan_umur" id="fase_rehabilitasi">
                                                                <option value="">Pilih Fase</option>
                                                                <option value="7" {{ old('golongan_umur', $dataPengkajianGizi->intervensiGizi->golongan_umur ?? '') == '7' ? 'selected' : '' }}>Stabilisasi</option>
                                                                <option value="8" {{ old('golongan_umur', $dataPengkajianGizi->intervensiGizi->golongan_umur ?? '') == '8' ? 'selected' : '' }}>Transisi</option>
                                                                <option value="9" {{ old('golongan_umur', $dataPengkajianGizi->intervensiGizi->golongan_umur ?? '') == '9' ? 'selected' : '' }}>Rehabilitasi</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label style="min-width: 200px;">Jenis Kelamin</label>
                                                            <input type="text" class="form-control bg-light" name="jenis_kelamin_kalori" 
                                                                   id="jenis_kelamin_kalori" readonly 
                                                                   value="{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Pria' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Wanita' : 'Tidak Diketahui') }}" 
                                                                   style="background-color: #f8f9fa;">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label style="min-width: 200px;">Rentang Kalori (Kkal/kg BB)</label>
                                                            <input type="text" class="form-control bg-light" name="rentang_kalori" 
                                                                   id="rentang_kalori" readonly 
                                                                   placeholder="Pilih golongan umur/fase terlebih dahulu" 
                                                                   style="background-color: #f8f9fa;"
                                                                   value="{{ old('rentang_kalori', $dataPengkajianGizi->intervensiGizi->rentang_kalori ?? '') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Input Kalori yang Dipilih -->
                                                <div class="row g-3 mt-2">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label style="min-width: 200px;">Kebutuhan Kalori (Kkal/kg BB) <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" name="kebutuhan_kalori_per_kg" 
                                                                   id="kebutuhan_kalori_per_kg" step="1" 
                                                                   placeholder="Sesuaikan dalam rentang yang tersedia"
                                                                   value="{{ old('kebutuhan_kalori_per_kg', $dataPengkajianGizi->intervensiGizi->kebutuhan_kalori_per_kg ?? '') }}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label style="min-width: 200px;">Total Kebutuhan Kalori (Kkal)</label>
                                                            <input type="number" class="form-control bg-light" name="total_kebutuhan_kalori" 
                                                                   id="total_kebutuhan_kalori" step="0.1" readonly 
                                                                   placeholder="Akan dihitung otomatis" style="background-color: #f8f9fa;"
                                                                   value="{{ old('total_kebutuhan_kalori', $dataPengkajianGizi->intervensiGizi->total_kebutuhan_kalori ?? '') }}">
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Hidden input untuk menyimpan mode perhitungan -->
                                                    <input type="hidden" name="mode_perhitungan" id="mode_perhitungan" 
                                                           value="{{ old('mode_perhitungan', $dataPengkajianGizi->intervensiGizi->mode_perhitungan ?? 'normal') }}">
                                                </div>
                                                
                                                <!-- Distribusi Makronutrien -->
                                                <div class="row g-3 mt-3">
                                                    <div class="col-md-12">
                                                        <h6 class="mb-3 text-primary">DISTRIBUSI MAKRONUTRIEN</h6>
                                                        
                                                        <!-- Mode Normal: Persentase -->
                                                        <div class="border rounded p-4 bg-light" id="makronutrien_normal">
                                                            <div class="row g-3">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label fw-bold">Protein</label>
                                                                        <div class="row g-2">
                                                                            <div class="col-6">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control" name="protein_persen" 
                                                                                        id="protein_persen" placeholder="12.5" step="0.1" 
                                                                                        value="{{ old('protein_persen', $dataPengkajianGizi->intervensiGizi->protein_persen ?? '12.5') }}">
                                                                                    <span class="input-group-text">%</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control bg-light" name="protein_gram" 
                                                                                        id="protein_gram" placeholder="gram" readonly style="background-color: #f8f9fa;"
                                                                                        value="{{ old('protein_gram', $dataPengkajianGizi->intervensiGizi->protein_gram ?? '') }}">
                                                                                    <span class="input-group-text">gr</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <small class="text-muted">= (% × Kalori ÷ 4)</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label fw-bold">Lemak</label>
                                                                        <div class="row g-2">
                                                                            <div class="col-6">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control" name="lemak_persen" 
                                                                                        id="lemak_persen" placeholder="30" step="0.1" 
                                                                                        value="{{ old('lemak_persen', $dataPengkajianGizi->intervensiGizi->lemak_persen ?? '30') }}">
                                                                                    <span class="input-group-text">%</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control bg-light" name="lemak_gram" 
                                                                                        id="lemak_gram" placeholder="gram" readonly style="background-color: #f8f9fa;"
                                                                                        value="{{ old('lemak_gram', $dataPengkajianGizi->intervensiGizi->lemak_gram ?? '') }}">
                                                                                    <span class="input-group-text">gr</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <small class="text-muted">= (% × Kalori ÷ 9)</small>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label fw-bold">Karbohidrat</label>
                                                                        <div class="row g-2">
                                                                            <div class="col-6">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control" name="kh_persen" 
                                                                                        id="kh_persen" placeholder="57.5" step="0.1" 
                                                                                        value="{{ old('kh_persen', $dataPengkajianGizi->intervensiGizi->kh_persen ?? '57.5') }}">
                                                                                    <span class="input-group-text">%</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control bg-light" name="kh_gram" 
                                                                                        id="kh_gram" placeholder="gram" readonly style="background-color: #f8f9fa;"
                                                                                        value="{{ old('kh_gram', $dataPengkajianGizi->intervensiGizi->kh_gram ?? '') }}">
                                                                                    <span class="input-group-text">gr</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <small class="text-muted">= (% × Kalori ÷ 4)</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Mode Gizi Buruk: Gram per kg BB -->
                                                        <div class="border rounded p-4" id="makronutrien_gizi_buruk" style="display: none; background-color: #fff3cd;">
                                                            <div class="alert alert-warning mb-3" style="margin-bottom: 1rem;">
                                                                <strong>Mode Rehabilitasi Gizi Buruk:</strong> Input dalam gram per kg berat badan. Karbohidrat otomatis dihitung sebagai sisa kalori.
                                                            </div>
                                                            
                                                            <div class="row g-3">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label fw-bold text-success">Protein</label>
                                                                        <div class="row g-2">
                                                                            <div class="col-8">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control" name="protein_gram_per_kg" 
                                                                                        id="protein_gram_per_kg" placeholder="0" step="0.1" min="0" max="10"
                                                                                        value="{{ old('protein_gram_per_kg', $dataPengkajianGizi->intervensiGizi->protein_gram_per_kg ?? '') }}">
                                                                                    <span class="input-group-text">gr/kg BB</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control bg-light" name="protein_gram_total" 
                                                                                        id="protein_gram_total" placeholder="total" readonly style="background-color: #f8f9fa;"
                                                                                        value="{{ old('protein_gram_total', $dataPengkajianGizi->intervensiGizi->protein_gram_total ?? '') }}">
                                                                                    <span class="input-group-text">gr</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <small class="text-muted" id="protein_range_info">Rentang: -</small>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label fw-bold text-warning">Lemak</label>
                                                                        <div class="row g-2">
                                                                            <div class="col-8">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control" name="lemak_gram_per_kg" 
                                                                                        id="lemak_gram_per_kg" placeholder="0" step="0.1" min="0" max="5"
                                                                                        value="{{ old('lemak_gram_per_kg', $dataPengkajianGizi->intervensiGizi->lemak_gram_per_kg ?? '') }}">
                                                                                    <span class="input-group-text">gr/kg BB</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control bg-light" name="lemak_gram_total" 
                                                                                        id="lemak_gram_total" placeholder="total" readonly style="background-color: #f8f9fa;"
                                                                                        value="{{ old('lemak_gram_total', $dataPengkajianGizi->intervensiGizi->lemak_gram_total ?? '') }}">
                                                                                    <span class="input-group-text">gr</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <small class="text-muted" id="lemak_range_info">Rentang: -</small>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label fw-bold text-primary">Karbohidrat</label>
                                                                        <div class="row g-2">
                                                                            <div class="col-8">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control bg-light" name="kh_gram_per_kg" 
                                                                                        id="kh_gram_per_kg" placeholder="auto" readonly style="background-color: #f8f9fa;"
                                                                                        value="{{ old('kh_gram_per_kg', $dataPengkajianGizi->intervensiGizi->kh_gram_per_kg ?? '') }}">
                                                                                    <span class="input-group-text">gr/kg BB</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <div class="input-group input-group-sm">
                                                                                    <input type="number" class="form-control bg-light" name="kh_gram_total" 
                                                                                        id="kh_gram_total" placeholder="total" readonly style="background-color: #f8f9fa;"
                                                                                        value="{{ old('kh_gram_total', $dataPengkajianGizi->intervensiGizi->kh_gram_total ?? '') }}">
                                                                                    <span class="input-group-text">gr</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <small class="text-muted">= Sisa kalori ÷ 4</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="asesmen-gizi">
                                        <h5 class="section-title">Asesmen Gizi</h5>

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

                                    <div class="section-separator" id="diagnosa_gizi">
                                        <h5 class="section-title">8. Diagnosa Gizi</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Diagnosa Gizi</label>
                                            <textarea class="form-control" name="diagnosa_gizi" rows="4"
                                                placeholder="Sebutkan diagnosa gizi...">{{ old('diagnosa_gizi', $dataPengkajianGizi->diagnosa_gizi) }}</textarea>
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
                document.getElementById('namaPenyakit').value = '';
                document.getElementById('namaObat').value = '';
            });

            document.getElementById('btnTambahRiwayatModal')?.addEventListener('click', function() {
                const namaPenyakit = document.getElementById('namaPenyakit').value.trim();
                const namaObat = document.getElementById('namaObat').value.trim();
                const tbody = document.querySelector('#riwayatTable tbody');

                if (namaPenyakit || namaObat) {
                    const riwayatEntry = {
                        penyakit: namaPenyakit || '-',
                        obat: namaObat || '-'
                    };

                    riwayatArray.push(riwayatEntry);

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${namaPenyakit || '-'}</td>
                        <td>${namaObat || '-'}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm hapus-riwayat">Hapus</button>
                        </td>
                    `;

                    tbody.appendChild(row);

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

                    updateRiwayatJson();
                    bootstrap.Modal.getInstance(document.getElementById('riwayatModal')).hide();
                } else {
                    alert('Mohon isi setidaknya salah satu field (Penyakit atau Obat)');
                }
            });

            const riwayatModal = document.getElementById('riwayatModal');
            riwayatModal?.addEventListener('hidden.bs.modal', function() {
                document.getElementById('namaPenyakit').value = '';
                document.getElementById('namaObat').value = '';
            });

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
            function preventEnterSubmit(event) {
                if (event.keyCode === 13 || event.which === 13) {
                    if (event.target.tagName.toLowerCase() !== 'textarea') {
                        event.preventDefault();
                        return false;
                    }
                    else if (event.target.tagName.toLowerCase() === 'textarea' && !event.shiftKey) {
                        return true;
                    }
                }
            }

            const formElements = document.querySelectorAll(
                'input[type="text"], input[type="number"], input[type="date"], input[type="time"], select, textarea'
            );
            formElements.forEach(function(element) {
                element.addEventListener('keypress', preventEnterSubmit);
            });

            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('keypress', function(event) {
                    if (event.keyCode === 13 || event.which === 13) {
                        if (event.target.tagName.toLowerCase() !== 'textarea' &&
                            event.target.type !== 'submit') {
                            event.preventDefault();
                            return false;
                        }
                    }
                });
            }

            //==================================================================================================//
            // Z-Score Calculator untuk Anak berdasarkan standar WHO
            //==================================================================================================//
            let whoDataFromDB = {
                weightForAge: @json($WhoWeightForAge ?? []),
                heightForAge: @json($WhoHeightForAge ?? []),
                bmiForAge: @json($WhoBmiForAge ?? []),
                weightForHeight: @json($WhoWeightForHeight ?? []),
                weightForLength: @json($WhoWeightForLength ?? []),
                headCircumferenceForAge: @json($WhoHeadCircumferenceForAge ?? [])
            };

            function safeParseDecimal(value) {
                if (typeof value === 'number' && !isNaN(value)) {
                    return value;
                }

                if (typeof value === 'string') {
                    const cleaned = value.replace(/['"]/g, '').trim();
                    const parsed = parseFloat(cleaned);
                    return isNaN(parsed) ? null : parsed;
                }

                if (typeof value === 'object' && value !== null) {
                    if (value.hasOwnProperty('value')) return safeParseDecimal(value.value);
                    if (value.hasOwnProperty('val')) return safeParseDecimal(value.val);
                    return null;
                }

                return null;
            }

            function extractLMSValues(dataItem) {
                let L = null, M = null, S = null;

                // Coba field names dengan huruf kecil sesuai model
                if (dataItem.l !== undefined) L = safeParseDecimal(dataItem.l);
                else if (dataItem.L !== undefined) L = safeParseDecimal(dataItem.L);

                if (dataItem.m !== undefined) M = safeParseDecimal(dataItem.m);
                else if (dataItem.M !== undefined) M = safeParseDecimal(dataItem.M);

                if (dataItem.s !== undefined) S = safeParseDecimal(dataItem.s);
                else if (dataItem.S !== undefined) S = safeParseDecimal(dataItem.S);

                if (L === null || M === null || S === null || M === 0 || S === 0) {
                    return null;
                }

                return { L, M, S };
            }

            function hitungBBIFromWHO(tinggiBadan, jenisKelamin, umurBulan) {
                if (!tinggiBadan || !jenisKelamin) {
                    return null;
                }

                let wfhData = null;
                if (umurBulan < 24 && whoDataFromDB.weightForLength && whoDataFromDB.weightForLength.length > 0) {
                    wfhData = whoDataFromDB.weightForLength;
                } else if (whoDataFromDB.weightForHeight && whoDataFromDB.weightForHeight.length > 0) {
                    wfhData = whoDataFromDB.weightForHeight;
                }

                if (!wfhData) {
                    return null;
                }

                const filteredData = wfhData.filter(item => {
                    const itemSex = parseInt(item.sex);
                    return itemSex === jenisKelamin;
                });

                if (filteredData.length === 0) {
                    return null;
                }

                const sample = filteredData[0];
                let heightKey;
                if ('height_cm' in sample) heightKey = 'height_cm';
                else if ('length_cm' in sample) heightKey = 'length_cm';
                else return null;

                filteredData.sort((a, b) => {
                    const aVal = safeParseDecimal(a[heightKey]);
                    const bVal = safeParseDecimal(b[heightKey]);
                    return (aVal || 0) - (bVal || 0);
                });

                // Cari exact match
                const exactMatch = filteredData.find(item => {
                    const itemHeight = safeParseDecimal(item[heightKey]);
                    return itemHeight !== null && Math.abs(itemHeight - tinggiBadan) < 0.1;
                });

                if (exactMatch) {
                    return safeParseDecimal(exactMatch.m) || safeParseDecimal(exactMatch.M);
                }

                // Interpolasi linear
                for (let i = 0; i < filteredData.length - 1; i++) {
                    const current = filteredData[i];
                    const next = filteredData[i + 1];
                    const currentHeight = safeParseDecimal(current[heightKey]);
                    const nextHeight = safeParseDecimal(next[heightKey]);

                    if (currentHeight !== null && nextHeight !== null && 
                        tinggiBadan >= currentHeight && tinggiBadan <= nextHeight) {
                        
                        const currentMedian = safeParseDecimal(current.m) || safeParseDecimal(current.M);
                        const nextMedian = safeParseDecimal(next.m) || safeParseDecimal(next.M);
                        
                        if (currentMedian !== null && nextMedian !== null) {
                            const ratio = (tinggiBadan - currentHeight) / (nextHeight - currentHeight);
                            return currentMedian + ratio * (nextMedian - currentMedian);
                        }
                    }
                }

                // Gunakan nilai terdekat jika di luar range
                const validHeights = filteredData.map(item => safeParseDecimal(item[heightKey])).filter(val => val !== null);
                if (validHeights.length === 0) return null;

                const minHeight = Math.min(...validHeights);
                const maxHeight = Math.max(...validHeights);

                if (tinggiBadan < minHeight) {
                    const firstItem = filteredData.find(item => safeParseDecimal(item[heightKey]) === minHeight);
                    return firstItem ? (safeParseDecimal(firstItem.m) || safeParseDecimal(firstItem.M)) : null;
                }

                if (tinggiBadan > maxHeight) {
                    const lastItem = filteredData.find(item => safeParseDecimal(item[heightKey]) === maxHeight);
                    return lastItem ? (safeParseDecimal(lastItem.m) || safeParseDecimal(lastItem.M)) : null;
                }

                return null;
            }

            function findLMSData(dataArray, sex, ageOrHeight, isHeight = false) {
                if (!dataArray || dataArray.length === 0) {
                    return null;
                }

                const sample = dataArray[0];
                let key;

                if (isHeight) {
                    if ('height_cm' in sample) key = 'height_cm';
                    else if ('length_cm' in sample) key = 'length_cm';
                    else return null;
                } else {
                    if ('age_months' in sample) key = 'age_months';
                    else return null;
                }

                const filteredData = dataArray.filter(item => {
                    const itemSex = parseInt(item.sex);
                    return itemSex === sex;
                });

                if (filteredData.length === 0) {
                    return null;
                }

                filteredData.sort((a, b) => {
                    const aVal = safeParseDecimal(a[key]);
                    const bVal = safeParseDecimal(b[key]);
                    return (aVal || 0) - (bVal || 0);
                });

                const validValues = filteredData.map(item => safeParseDecimal(item[key])).filter(val => val !== null);
                if (validValues.length === 0) {
                    return null;
                }

                const minVal = Math.min(...validValues);
                const maxVal = Math.max(...validValues);

                const exactMatch = filteredData.find(item => {
                    const itemValue = safeParseDecimal(item[key]);
                    return itemValue !== null && Math.abs(itemValue - ageOrHeight) < 0.1;
                });

                if (exactMatch) {
                    return extractLMSValues(exactMatch);
                }

                if (ageOrHeight < minVal) {
                    return extractLMSValues(filteredData[0]);
                }

                if (ageOrHeight > maxVal) {
                    return extractLMSValues(filteredData[filteredData.length - 1]);
                }

                for (let i = 0; i < filteredData.length - 1; i++) {
                    const current = filteredData[i];
                    const next = filteredData[i + 1];
                    const currentVal = safeParseDecimal(current[key]);
                    const nextVal = safeParseDecimal(next[key]);

                    if (currentVal !== null && nextVal !== null && ageOrHeight >= currentVal && ageOrHeight <= nextVal) {
                        const ratio = (ageOrHeight - currentVal) / (nextVal - currentVal);

                        const currentLMS = extractLMSValues(current);
                        const nextLMS = extractLMSValues(next);

                        if (!currentLMS || !nextLMS) {
                            return null;
                        }

                        return {
                            L: currentLMS.L + ratio * (nextLMS.L - currentLMS.L),
                            M: currentLMS.M + ratio * (nextLMS.M - currentLMS.M),
                            S: currentLMS.S + ratio * (nextLMS.S - currentLMS.S)
                        };
                    }
                }

                return null;
            }

            function calculateZScore(value, L, M, S) {
                if (!value || value <= 0 || !M || M <= 0 || !S || S <= 0) {
                    return null;
                }

                let zScore;

                if (Math.abs(L) < 0.01) {
                    zScore = Math.log(value / M) / S;
                } else {
                    zScore = (Math.pow(value / M, L) - 1) / (L * S);
                }

                if (Math.abs(zScore) > 6) {
                    return null;
                }

                return zScore;
            }

            function determineZScoreStatus(zScore, type) {
                if (zScore === null || isNaN(zScore)) return '';
                
                switch (type) {
                    case 'bb_usia':
                        if (zScore < -3) return 'severely_underweight';
                        if (zScore < -2) return 'underweight';
                        if (zScore > 1) return 'overweight';
                        return 'normal';
                        
                    case 'pb_tb_usia':
                        if (zScore < -3) return 'severely_stunted';
                        if (zScore < -2) return 'stunted';
                        if (zScore > 3) return 'tall';
                        return 'normal';
                        
                    case 'bb_tb':
                        if (zScore < -3) return 'severely_wasted';
                        if (zScore < -2) return 'wasted';
                        if (zScore > 2) return 'obese';
                        if (zScore > 1) return 'overweight';
                        return 'normal';
                        
                    case 'imt_usia':
                        if (zScore < -3) return 'severely_underweight';
                        if (zScore < -2) return 'underweight';
                        if (zScore > 2) return 'obese';
                        if (zScore > 1) return 'overweight';
                        return 'normal';
                        
                    default:
                        return '';
                }
            }

            // Function untuk check stunting status
            function checkStuntingStatus() {
                const bbUsiaZScore = parseFloat(document.querySelector('input[name="bb_usia"]')?.value || 0);
                const pbTbUsiaZScore = parseFloat(document.querySelector('input[name="pb_tb_usia"]')?.value || 0);
                const bbUsiaStatus = document.getElementById('bb_usia_status')?.value || '';
                const pbTbUsiaStatus = document.getElementById('pb_tb_usia_status')?.value || '';
                
                const stuntingSection = document.getElementById('stunting_section');
                const statusStuntingField = document.getElementById('status_stunting');
                
                if (!stuntingSection || !statusStuntingField) return;
                
                // Cek apakah ada status yang tidak normal
                const isAbnormal = (bbUsiaStatus && bbUsiaStatus !== 'normal') || 
                                  (pbTbUsiaStatus && pbTbUsiaStatus !== 'normal');
                
                // Cek apakah kedua Z-Score tersedia
                const hasValidZScores = bbUsiaZScore !== 0 && pbTbUsiaZScore !== 0 && 
                                       !isNaN(bbUsiaZScore) && !isNaN(pbTbUsiaZScore);
                
                if (isAbnormal && hasValidZScores) {
                    // Tampilkan section stunting
                    stuntingSection.style.display = 'block';
                    
                    // Tentukan status stunting berdasarkan perbandingan Z-Score
                    if (bbUsiaZScore < pbTbUsiaZScore) {
                        statusStuntingField.value = 'Stunting';
                        statusStuntingField.style.color = '#dc3545';
                        statusStuntingField.style.backgroundColor = '#f8d7da';
                    } else {
                        statusStuntingField.value = 'Tidak Stunting';
                        statusStuntingField.style.color = '#198754';
                        statusStuntingField.style.backgroundColor = '#d1e7dd';
                    }
                } else {
                    // Sembunyikan section stunting jika semua normal atau data tidak lengkap
                    stuntingSection.style.display = 'none';
                    statusStuntingField.value = '';
                }
            }

            //==================================================================================//
            // Data kalori dan makronutrien
            //==================================================================================//
            const kaloriData = {
                '1': { pria: '110-120', wanita: '110-120', min: 110, max: 120 },
                '2': { pria: '100', wanita: '100', min: 100, max: 100 },
                '3': { pria: '90', wanita: '90', min: 90, max: 90 },
                '4': { pria: '80-90', wanita: '60-80', min_pria: 80, max_pria: 90, min_wanita: 60, max_wanita: 80 },
                '5': { pria: '50-70', wanita: '40-55', min_pria: 50, max_pria: 70, min_wanita: 40, max_wanita: 55 },
                '6': { pria: '40-50', wanita: '40', min_pria: 40, max_pria: 50, min_wanita: 40, max_wanita: 40 }
            };

            const kaloriGiziBurukData = {
                '7': { range: '80-100', min: 80, max: 100 },
                '8': { range: '100-150', min: 100, max: 150 },
                '9': { range: '150-220', min: 150, max: 220 }
            };

            const makronutrienGiziBurukData = {
                '7': {
                    protein: { min: 1, max: 1.5 },
                    lemak: { min: 0.5, max: 1 }
                },
                '8': {
                    protein: { min: 2, max: 3 },
                    lemak: { min: 1, max: 1.5 }
                },
                '9': {
                    protein: { min: 4, max: 6 },
                    lemak: { min: 2, max: 2 } 
                }
            };

            // Function untuk check gizi buruk status
            function checkGiziBurukStatus() {
                const bbTbStatus = document.getElementById('bb_tb_status')?.value || '';
                const isGiziBuruk = bbTbStatus === 'severely_wasted';
                
                // Toggle tampilan berdasarkan status
                toggleGiziBurukMode(isGiziBuruk);
                
                return isGiziBuruk;
            }

            // Function untuk toggle makronutrien mode
            function toggleMakronutrienMode(isGiziBuruk) {
                const makronutrienNormal = document.getElementById('makronutrien_normal');
                const makronutrienGiziBuruk = document.getElementById('makronutrien_gizi_buruk');
                
                if (!makronutrienNormal || !makronutrienGiziBuruk) return;
                
                if (isGiziBuruk) {
                    makronutrienNormal.style.display = 'none';
                    makronutrienGiziBuruk.style.display = 'block';
                    resetMakronutrienGiziBuruk();
                } else {
                    makronutrienNormal.style.display = 'block';
                    makronutrienGiziBuruk.style.display = 'none';
                    resetMakronutrienNormal();
                }
            }

            function resetMakronutrienNormal() {
                const fields = ['protein_gram', 'lemak_gram', 'kh_gram'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }

            function resetMakronutrienGiziBuruk() {
                const fields = ['protein_gram_per_kg', 'protein_gram_total', 'lemak_gram_per_kg', 'lemak_gram_total', 'kh_gram_per_kg', 'kh_gram_total'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
                
                // Reset range info
                const proteinRangeInfo = document.getElementById('protein_range_info');
                const lemakRangeInfo = document.getElementById('lemak_range_info');
                if (proteinRangeInfo) proteinRangeInfo.textContent = 'Rentang: -';
                if (lemakRangeInfo) lemakRangeInfo.textContent = 'Rentang: -';
            }

            // Function untuk toggle mode normal vs gizi buruk
            function toggleGiziBurukMode(isGiziBuruk) {
                const tableNormal = document.getElementById('table_normal');
                const tableGiziBuruk = document.getElementById('table_gizi_buruk');
                const infoNormal = document.getElementById('info_normal');
                const infoGiziBuruk = document.getElementById('info_gizi_buruk');
                const pilihanNormal = document.getElementById('pilihan_normal');
                const pilihanGiziBuruk = document.getElementById('pilihan_gizi_buruk');
                const modePerhitungan = document.getElementById('mode_perhitungan');
                
                // Get kedua select element
                const golonganUmurSelect = document.getElementById('golongan_umur');
                const faseRehabilitasiSelect = document.getElementById('fase_rehabilitasi');
                
                if (!tableNormal || !tableGiziBuruk) return;
                
                if (isGiziBuruk) {
                    // Mode gizi buruk
                    tableNormal.style.display = 'none';
                    tableGiziBuruk.style.display = 'block';
                    if (infoNormal) infoNormal.style.display = 'none';
                    if (infoGiziBuruk) infoGiziBuruk.style.display = 'block';
                    if (pilihanNormal) pilihanNormal.style.display = 'none';
                    if (pilihanGiziBuruk) pilihanGiziBuruk.style.display = 'block';
                    if (modePerhitungan) modePerhitungan.value = 'gizi_buruk';
                    
                    // Disable select normal dan reset nilainya
                    if (golonganUmurSelect) {
                        golonganUmurSelect.disabled = true;
                        golonganUmurSelect.value = '';
                    }
                    
                    // Enable select fase rehabilitasi
                    if (faseRehabilitasiSelect) {
                        faseRehabilitasiSelect.disabled = false;
                    }
                    
                    // Toggle makronutrien mode
                    toggleMakronutrienMode(true);
                    
                } else {
                    // Mode normal
                    tableNormal.style.display = 'block';
                    tableGiziBuruk.style.display = 'none';
                    if (infoNormal) infoNormal.style.display = 'block';
                    if (infoGiziBuruk) infoGiziBuruk.style.display = 'none';
                    if (pilihanNormal) pilihanNormal.style.display = 'block';
                    if (pilihanGiziBuruk) pilihanGiziBuruk.style.display = 'none';
                    if (modePerhitungan) modePerhitungan.value = 'normal';
                    
                    // Enable select normal
                    if (golonganUmurSelect) {
                        golonganUmurSelect.disabled = false;
                    }
                    
                    // Disable select fase dan reset nilainya
                    if (faseRehabilitasiSelect) {
                        faseRehabilitasiSelect.disabled = true;
                        faseRehabilitasiSelect.value = '';
                    }
                    
                    // Toggle makronutrien mode
                    toggleMakronutrienMode(false);
                }
                
                // Reset form kalori
                resetKaloriForm();
            }

            // Function untuk reset form kalori
            function resetKaloriForm() {
                const fields = ['rentang_kalori', 'kebutuhan_kalori_per_kg', 'total_kebutuhan_kalori', 'protein_gram', 'lemak_gram', 'kh_gram'];
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
                
                const kebutuhanKaloriField = document.getElementById('kebutuhan_kalori_per_kg');
                if (kebutuhanKaloriField) {
                    kebutuhanKaloriField.disabled = true;
                }
            }

            // Function untuk update makronutrien range saat fase berubah
            function updateMakronutrienRange() {
                const faseRehabilitasi = document.getElementById('fase_rehabilitasi')?.value;
                const proteinField = document.getElementById('protein_gram_per_kg');
                const lemakField = document.getElementById('lemak_gram_per_kg');
                const proteinRangeInfo = document.getElementById('protein_range_info');
                const lemakRangeInfo = document.getElementById('lemak_range_info');
                
                if (!faseRehabilitasi || !proteinField || !lemakField) return;
                
                const makronutrienInfo = makronutrienGiziBurukData[faseRehabilitasi];
                if (!makronutrienInfo) return;
                
                // Set range untuk protein
                proteinField.min = makronutrienInfo.protein.min;
                proteinField.max = makronutrienInfo.protein.max;
                proteinField.placeholder = `${makronutrienInfo.protein.min}-${makronutrienInfo.protein.max}`;
                if (proteinRangeInfo) {
                    proteinRangeInfo.textContent = `Rentang: ${makronutrienInfo.protein.min}-${makronutrienInfo.protein.max} gr/kg BB`;
                }
                
                // Set range untuk lemak
                lemakField.min = makronutrienInfo.lemak.min;
                lemakField.max = makronutrienInfo.lemak.max;
                if (makronutrienInfo.lemak.min === makronutrienInfo.lemak.max) {
                    lemakField.value = makronutrienInfo.lemak.min;
                    lemakField.placeholder = makronutrienInfo.lemak.min.toString();
                    if (lemakRangeInfo) {
                        lemakRangeInfo.textContent = `Nilai: ${makronutrienInfo.lemak.min} gr/kg BB (tetap)`;
                    }
                } else {
                    lemakField.placeholder = `${makronutrienInfo.lemak.min}-${makronutrienInfo.lemak.max}`;
                    if (lemakRangeInfo) {
                        lemakRangeInfo.textContent = `Rentang: ${makronutrienInfo.lemak.min}-${makronutrienInfo.lemak.max} gr/kg BB`;
                    }
                }
                
                // Set default values
                if (makronutrienInfo.protein.min === makronutrienInfo.protein.max) {
                    proteinField.value = makronutrienInfo.protein.min;
                } else {
                    proteinField.value = (makronutrienInfo.protein.min + makronutrienInfo.protein.max) / 2;
                }
                
                // Hitung makronutrien
                calculateMakronutrienGiziBuruk();
            }

            // Function untuk hitung makronutrien gizi buruk
            function calculateMakronutrienGiziBuruk() {
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
                const totalKalori = parseFloat(document.getElementById('total_kebutuhan_kalori')?.value || 0);
                const proteinPerKg = parseFloat(document.getElementById('protein_gram_per_kg')?.value || 0);
                const lemakPerKg = parseFloat(document.getElementById('lemak_gram_per_kg')?.value || 0);
                
                if (!beratBadan || !totalKalori) {
                    resetMakronutrienGiziBuruk();
                    return;
                }
                
                // Hitung total protein dan lemak
                const proteinTotal = proteinPerKg * beratBadan;
                const lemakTotal = lemakPerKg * beratBadan;
                
                // Hitung kalori dari protein dan lemak
                const kaloriProtein = proteinTotal * 4; // 1g protein = 4 kkal
                const kaloriLemak = lemakTotal * 9; // 1g lemak = 9 kkal
                
                // Hitung sisa kalori untuk karbohidrat
                const sisaKalori = totalKalori - kaloriProtein - kaloriLemak;
                const karbohidratTotal = Math.max(0, sisaKalori / 4); // 1g karbohidrat = 4 kkal
                const karbohidratPerKg = beratBadan > 0 ? karbohidratTotal / beratBadan : 0;
                
                // Update fields
                const proteinTotalField = document.getElementById('protein_gram_total');
                const lemakTotalField = document.getElementById('lemak_gram_total');
                const khPerKgField = document.getElementById('kh_gram_per_kg');
                const khTotalField = document.getElementById('kh_gram_total');
                
                if (proteinTotalField) proteinTotalField.value = proteinTotal.toFixed(1);
                if (lemakTotalField) lemakTotalField.value = lemakTotal.toFixed(1);
                if (khPerKgField) khPerKgField.value = karbohidratPerKg.toFixed(1);
                if (khTotalField) khTotalField.value = karbohidratTotal.toFixed(1);
                
                // Update field tersembunyi untuk kompatibilitas dengan form submission
                const proteinGramField = document.getElementById('protein_gram');
                const lemakGramField = document.getElementById('lemak_gram');
                const khGramField = document.getElementById('kh_gram');
                
                if (proteinGramField) proteinGramField.value = proteinTotal.toFixed(1);
                if (lemakGramField) lemakGramField.value = lemakTotal.toFixed(1);
                if (khGramField) khGramField.value = karbohidratTotal.toFixed(1);
            }

            function updateZScoreStatus(zScore, statusFieldId, type) {
                const statusField = document.getElementById(statusFieldId);
                if (statusField) {
                    const status = determineZScoreStatus(zScore, type);
                    statusField.value = status;
                    
                    // Check stunting status
                    setTimeout(checkStuntingStatus, 100);
                    
                    // Check gizi buruk status
                    if (statusFieldId === 'bb_tb_status') {
                        setTimeout(checkGiziBurukStatus, 150);
                    }
                }
            }

            function hitungIMTdanBBI() {
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan')?.value || 0);
                const umurBulan = parseFloat(document.querySelector('input[name="umur_bulan"]')?.value || 0);
                const jenisKelamin = parseInt(document.getElementById('jenis_kelamin_who')?.value || 0);

                if (beratBadan && tinggiBadan) {
                    const tinggiMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiMeter * tinggiMeter);

                    if (tinggiBadan && jenisKelamin && umurBulan !== null) {
                        const bbi = hitungBBIFromWHO(tinggiBadan, jenisKelamin, umurBulan);
                        const bbiField = document.getElementById('bbi');
                        if (bbiField && bbi !== null) {
                            bbiField.value = bbi.toFixed(1);
                        } else if (bbiField) {
                            bbiField.value = '';
                        }
                    }
                }
            }

            function calculateAllZScoresFromDB() {
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan')?.value || 0);
                const umurBulan = parseFloat(document.querySelector('input[name="umur_bulan"]')?.value || 0);
                const jenisKelamin = parseInt(document.getElementById('jenis_kelamin_who')?.value || 0);

                if (!beratBadan || !tinggiBadan || !umurBulan || !jenisKelamin) {
                    return;
                }

                if (beratBadan <= 0 || beratBadan > 100 || tinggiBadan <= 0 || tinggiBadan > 200 || umurBulan < 0 || umurBulan > 240) {
                    return;
                }

                const tinggiMeter = tinggiBadan / 100;
                const imt = beratBadan / (tinggiMeter * tinggiMeter);

                try {
                    // Weight-for-Age Z-Score
                    if (whoDataFromDB.weightForAge && whoDataFromDB.weightForAge.length > 0) {
                        const wfaLMS = findLMSData(whoDataFromDB.weightForAge, jenisKelamin, umurBulan);
                        if (wfaLMS) {
                            const wfaZScore = calculateZScore(beratBadan, wfaLMS.L, wfaLMS.M, wfaLMS.S);
                            if (wfaZScore !== null) {
                                const bbUsiaField = document.querySelector('input[name="bb_usia"]');
                                if (bbUsiaField) {
                                    bbUsiaField.value = wfaZScore.toFixed(2);
                                }
                                updateZScoreStatus(wfaZScore, 'bb_usia_status', 'bb_usia');
                            }
                        }
                    }

                    // Height-for-Age Z-Score
                    if (whoDataFromDB.heightForAge && whoDataFromDB.heightForAge.length > 0) {
                        const hfaLMS = findLMSData(whoDataFromDB.heightForAge, jenisKelamin, umurBulan);
                        if (hfaLMS) {
                            const hfaZScore = calculateZScore(tinggiBadan, hfaLMS.L, hfaLMS.M, hfaLMS.S);
                            if (hfaZScore !== null) {
                                const pbTbUsiaField = document.querySelector('input[name="pb_tb_usia"]');
                                if (pbTbUsiaField) {
                                    pbTbUsiaField.value = hfaZScore.toFixed(2);
                                }
                                updateZScoreStatus(hfaZScore, 'pb_tb_usia_status', 'pb_tb_usia');
                            }
                        }
                    }

                    // Weight-for-Height Z-Score
                    let wfhData = null;
                    if (umurBulan < 24 && whoDataFromDB.weightForLength && whoDataFromDB.weightForLength.length > 0) {
                        wfhData = whoDataFromDB.weightForLength;
                    } else if (whoDataFromDB.weightForHeight && whoDataFromDB.weightForHeight.length > 0) {
                        wfhData = whoDataFromDB.weightForHeight;
                    }

                    if (wfhData) {
                        const wfhLMS = findLMSData(wfhData, jenisKelamin, tinggiBadan, true);
                        if (wfhLMS) {
                            const wfhZScore = calculateZScore(beratBadan, wfhLMS.L, wfhLMS.M, wfhLMS.S);
                            if (wfhZScore !== null) {
                                const bbTbField = document.querySelector('input[name="bb_tb"]');
                                if (bbTbField) {
                                    bbTbField.value = wfhZScore.toFixed(2);
                                }
                                updateZScoreStatus(wfhZScore, 'bb_tb_status', 'bb_tb');
                            }
                        }
                    }

                    // BMI-for-Age Z-Score
                    if (whoDataFromDB.bmiForAge && whoDataFromDB.bmiForAge.length > 0) {
                        const bmiLMS = findLMSData(whoDataFromDB.bmiForAge, jenisKelamin, umurBulan);
                        if (bmiLMS) {
                            const bmiZScore = calculateZScore(imt, bmiLMS.L, bmiLMS.M, bmiLMS.S);
                            if (bmiZScore !== null) {
                                const imtUsiaField = document.querySelector('input[name="imt_usia"]');
                                if (imtUsiaField) {
                                    imtUsiaField.value = bmiZScore.toFixed(2);
                                }
                                updateZScoreStatus(bmiZScore, 'imt_usia_status', 'imt_usia');
                            }
                        }
                    }
                } catch (error) {
                    // Silent error handling
                }
            }

            function updateKaloriRange() {
                const modePerhitungan = document.getElementById('mode_perhitungan')?.value || 'normal';
                const rentangKaloriField = document.getElementById('rentang_kalori');
                const kebutuhanKaloriField = document.getElementById('kebutuhan_kalori_per_kg');
                
                if (!rentangKaloriField || !kebutuhanKaloriField) return;
                
                if (modePerhitungan === 'gizi_buruk') {
                    // Mode gizi buruk - ambil nilai dari fase_rehabilitasi
                    const faseRehabilitasi = document.getElementById('fase_rehabilitasi')?.value;
                    
                    if (!faseRehabilitasi) {
                        return; // Jangan reset jika sedang dalam mode edit
                    }
                    
                    const kaloriInfo = kaloriGiziBurukData[faseRehabilitasi];
                    if (!kaloriInfo) return;
                    
                    rentangKaloriField.value = kaloriInfo.range;
                    
                    kebutuhanKaloriField.min = kaloriInfo.min;
                    kebutuhanKaloriField.max = kaloriInfo.max;
                    kebutuhanKaloriField.disabled = false;
                    kebutuhanKaloriField.placeholder = `Masukkan nilai antara ${kaloriInfo.min}-${kaloriInfo.max}`;
                    
                    // Jangan override value yang sudah ada kecuali kosong
                    if (!kebutuhanKaloriField.value) {
                        kebutuhanKaloriField.value = Math.round((kaloriInfo.min + kaloriInfo.max) / 2);
                    }
                    
                } else {
                    // Mode normal - ambil nilai dari golongan_umur
                    const golonganUmur = document.getElementById('golongan_umur')?.value;
                    const jenisKelamin = parseInt(document.getElementById('jenis_kelamin_who')?.value || 0);
                    
                    if (!golonganUmur || !jenisKelamin) {
                        return; // Jangan reset jika sedang dalam mode edit
                    }

                    const genderKey = jenisKelamin === 1 ? 'pria' : 'wanita';
                    const kaloriInfo = kaloriData[golonganUmur];
                    
                    if (!kaloriInfo) return;

                    rentangKaloriField.value = kaloriInfo[genderKey];
                    
                    let minVal, maxVal;
                    if (kaloriInfo[`min_${genderKey}`] !== undefined) {
                        minVal = kaloriInfo[`min_${genderKey}`];
                        maxVal = kaloriInfo[`max_${genderKey}`];
                    } else {
                        minVal = kaloriInfo.min;
                        maxVal = kaloriInfo.max;
                    }
                    
                    kebutuhanKaloriField.min = minVal;
                    kebutuhanKaloriField.max = maxVal;
                    kebutuhanKaloriField.disabled = false;
                    kebutuhanKaloriField.placeholder = `Masukkan nilai antara ${minVal}-${maxVal}`;
                    
                    // Jangan override value yang sudah ada kecuali kosong
                    if (!kebutuhanKaloriField.value) {
                        if (minVal === maxVal) {
                            kebutuhanKaloriField.value = minVal;
                        } else {
                            kebutuhanKaloriField.value = Math.round((minVal + maxVal) / 2);
                        }
                    }
                }
                
                // Hitung total kalori jika belum ada
                const totalKaloriField = document.getElementById('total_kebutuhan_kalori');
                if (!totalKaloriField.value) {
                    calculateTotalNutrition();
                }
            }

            function calculateTotalNutrition() {
                const kaloriPerKg = parseFloat(document.getElementById('kebutuhan_kalori_per_kg')?.value || 0);
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
                
                if (!kaloriPerKg || !beratBadan) {
                    const fields = ['total_kebutuhan_kalori', 'protein_gram', 'lemak_gram', 'kh_gram'];
                    fields.forEach(fieldId => {
                        const field = document.getElementById(fieldId);
                        if (field) field.value = '';
                    });
                    return;
                }
                
                const totalKalori = kaloriPerKg * beratBadan;
                const totalKaloriField = document.getElementById('total_kebutuhan_kalori');
                if (totalKaloriField) {
                    totalKaloriField.value = totalKalori.toFixed(0);
                }
                
                calculateMacronutrients(totalKalori);
            }
            
            function calculateMacronutrients(totalKalori = null) {
                const modePerhitungan = document.getElementById('mode_perhitungan')?.value || 'normal';
                
                if (modePerhitungan === 'gizi_buruk') {
                    calculateMakronutrienGiziBuruk();
                    return;
                }
                
                // Mode normal - gunakan persentase
                if (!totalKalori) {
                    const totalKaloriField = document.getElementById('total_kebutuhan_kalori');
                    totalKalori = parseFloat(totalKaloriField?.value || 0);
                }
                
                if (!totalKalori) return;
                
                const proteinPersen = parseFloat(document.getElementById('protein_persen')?.value || 0);
                const lemakPersen = parseFloat(document.getElementById('lemak_persen')?.value || 0);
                const khPersen = parseFloat(document.getElementById('kh_persen')?.value || 0);
                
                if (proteinPersen > 0) {
                    const proteinGram = (totalKalori * proteinPersen / 100) / 4;
                    const proteinField = document.getElementById('protein_gram');
                    if (proteinField) proteinField.value = proteinGram.toFixed(1);
                }
                
                if (lemakPersen > 0) {
                    const lemakGram = (totalKalori * lemakPersen / 100) / 9;
                    const lemakField = document.getElementById('lemak_gram');
                    if (lemakField) lemakField.value = lemakGram.toFixed(1);
                }
                
                if (khPersen > 0) {
                    const khGram = (totalKalori * khPersen / 100) / 4;
                    const khField = document.getElementById('kh_gram');
                    if (khField) khField.value = khGram.toFixed(1);
                }
            }

            function autoSelectAgeGroup() {
                const umurBulan = parseFloat(document.querySelector('input[name="umur_bulan"]')?.value || 0);
                const umurTahun = umurBulan / 12;
                
                let selectedGroup = '';
                if (umurTahun <= 1) selectedGroup = '1';
                else if (umurTahun <= 3) selectedGroup = '2';
                else if (umurTahun <= 6) selectedGroup = '3';
                else if (umurTahun <= 9) selectedGroup = '4';
                else if (umurTahun <= 13) selectedGroup = '5';
                else if (umurTahun <= 18) selectedGroup = '6';
                
                const golonganUmurField = document.getElementById('golongan_umur');
                const modePerhitungan = document.getElementById('mode_perhitungan')?.value || 'normal';
                
                // Hanya set jika dalam mode normal dan field tidak disabled
                if (selectedGroup && golonganUmurField && modePerhitungan === 'normal' && !golonganUmurField.disabled) {
                    golonganUmurField.value = selectedGroup;
                    updateKaloriRange();
                }
            }

            // Event listeners untuk Z-Score
            const beratBadanField = document.getElementById('berat_badan');
            const tinggiBadanField = document.getElementById('tinggi_badan');

            if (beratBadanField) {
                beratBadanField.addEventListener('input', function() {
                    hitungIMTdanBBI();
                    calculateAllZScoresFromDB();
                });
            }

            if (tinggiBadanField) {
                tinggiBadanField.addEventListener('input', function() {
                    hitungIMTdanBBI();
                    calculateAllZScoresFromDB();
                });
            }




            function initializeEditMode() {
                // Deteksi mode berdasarkan data yang ada
                const modePerhitungan = document.getElementById('mode_perhitungan')?.value || 'normal';
                const golonganUmur = document.getElementById('golongan_umur')?.value;
                const isGiziBuruk = modePerhitungan === 'gizi_buruk' || (golonganUmur && ['7', '8', '9'].includes(golonganUmur));
                
                // Set mode yang benar
                if (isGiziBuruk) {
                    toggleGiziBurukMode(true);
                    
                    // Pindahkan nilai golongan_umur ke fase_rehabilitasi jika diperlukan
                    if (golonganUmur && ['7', '8', '9'].includes(golonganUmur)) {
                        const faseRehabilitasiSelect = document.getElementById('fase_rehabilitasi');
                        if (faseRehabilitasiSelect) {
                            faseRehabilitasiSelect.value = golonganUmur;
                            updateKaloriRange();
                            updateMakronutrienRange();
                        }
                    }
                } else {
                    toggleGiziBurukMode(false);
                    if (golonganUmur) {
                        updateKaloriRange();
                    }
                }
                
                // Update kalkulasi jika data sudah ada
                const beratBadan = parseFloat(document.getElementById('berat_badan')?.value || 0);
                const tinggiBadan = parseFloat(document.getElementById('tinggi_badan')?.value || 0);
                
                if (beratBadan && tinggiBadan) {
                    hitungIMTdanBBI();
                    calculateAllZScoresFromDB();
                }
                
                // Update kalkulasi nutrisi jika data sudah ada
                const kaloriPerKg = parseFloat(document.getElementById('kebutuhan_kalori_per_kg')?.value || 0);
                if (kaloriPerKg && beratBadan) {
                    calculateTotalNutrition();
                }
                
                // Set status Z-Score select berdasarkan data yang ada
                setZScoreStatus();
            }

            // Function untuk set status Z-Score select
            function setZScoreStatus() {
                // BB/Usia Status
                const bbUsiaZScore = parseFloat(document.querySelector('input[name="bb_usia"]')?.value || 0);
                if (bbUsiaZScore) {
                    const status = determineZScoreStatus(bbUsiaZScore, 'bb_usia');
                    const statusField = document.getElementById('bb_usia_status');
                    if (statusField) statusField.value = status;
                }
                
                // PB(TB)/Usia Status
                const pbTbUsiaZScore = parseFloat(document.querySelector('input[name="pb_tb_usia"]')?.value || 0);
                if (pbTbUsiaZScore) {
                    const status = determineZScoreStatus(pbTbUsiaZScore, 'pb_tb_usia');
                    const statusField = document.getElementById('pb_tb_usia_status');
                    if (statusField) statusField.value = status;
                }
                
                // BB/TB Status
                const bbTbZScore = parseFloat(document.querySelector('input[name="bb_tb"]')?.value || 0);
                if (bbTbZScore) {
                    const status = determineZScoreStatus(bbTbZScore, 'bb_tb');
                    const statusField = document.getElementById('bb_tb_status');
                    if (statusField) statusField.value = status;
                }
                
                // IMT/Usia Status
                const imtUsiaZScore = parseFloat(document.querySelector('input[name="imt_usia"]')?.value || 0);
                if (imtUsiaZScore) {
                    const status = determineZScoreStatus(imtUsiaZScore, 'imt_usia');
                    const statusField = document.getElementById('imt_usia_status');
                    if (statusField) statusField.value = status;
                }
                
                // Check stunting dan gizi buruk status
                setTimeout(() => {
                    checkStuntingStatus();
                    checkGiziBurukStatus();
                }, 200);
            }




            setTimeout(() => {
                if (beratBadanField?.value && tinggiBadanField?.value) {
                    hitungIMTdanBBI();
                    calculateAllZScoresFromDB();
                }
            }, 2000);

            // Event listeners untuk kalori dan nutrisi
            document.getElementById('golongan_umur')?.addEventListener('change', function() {
                if (!this.disabled) {
                    updateKaloriRange();
                }
            });

            document.getElementById('fase_rehabilitasi')?.addEventListener('change', function() {
                if (!this.disabled) {
                    updateKaloriRange();
                    updateMakronutrienRange();
                }
            });
            
            document.getElementById('kebutuhan_kalori_per_kg')?.addEventListener('input', function() {
                const value = parseInt(this.value);
                const min = parseInt(this.min);
                const max = parseInt(this.max);
                
                if (value < min || value > max) {
                    this.setCustomValidity(`Nilai harus antara ${min} - ${max}`);
                } else {
                    this.setCustomValidity('');
                }
                
                calculateTotalNutrition();
            });
            
            document.getElementById('protein_persen')?.addEventListener('input', function() {
                calculateMacronutrients();
            });
            
            document.getElementById('lemak_persen')?.addEventListener('input', function() {
                calculateMacronutrients();
            });
            
            document.getElementById('kh_persen')?.addEventListener('input', function() {
                calculateMacronutrients();
            });
            
            document.getElementById('berat_badan')?.addEventListener('input', function() {
                setTimeout(calculateTotalNutrition, 100);
            });

            // Event listeners untuk makronutrien gizi buruk
            document.getElementById('protein_gram_per_kg')?.addEventListener('input', function() {
                const faseRehabilitasi = document.getElementById('fase_rehabilitasi')?.value;
                if (!faseRehabilitasi) return;
                
                const makronutrienInfo = makronutrienGiziBurukData[faseRehabilitasi];
                if (!makronutrienInfo) return;
                
                const value = parseFloat(this.value);
                const min = makronutrienInfo.protein.min;
                const max = makronutrienInfo.protein.max;
                
                if (value < min || value > max) {
                    this.setCustomValidity(`Nilai harus antara ${min} - ${max} gr/kg BB`);
                } else {
                    this.setCustomValidity('');
                }
                
                calculateMakronutrienGiziBuruk();
            });
            
            document.getElementById('lemak_gram_per_kg')?.addEventListener('input', function() {
                const faseRehabilitasi = document.getElementById('fase_rehabilitasi')?.value;
                if (!faseRehabilitasi) return;
                
                const makronutrienInfo = makronutrienGiziBurukData[faseRehabilitasi];
                if (!makronutrienInfo) return;
                
                const value = parseFloat(this.value);
                const min = makronutrienInfo.lemak.min;
                const max = makronutrienInfo.lemak.max;
                
                if (value < min || value > max) {
                    this.setCustomValidity(`Nilai harus antara ${min} - ${max} gr/kg BB`);
                } else {
                    this.setCustomValidity('');
                }
                
                calculateMakronutrienGiziBuruk();
            });

            // Monitor perubahan status untuk stunting dan gizi buruk
            const bbUsiaField = document.querySelector('input[name="bb_usia"]');
            const pbTbUsiaField = document.querySelector('input[name="pb_tb_usia"]');
            const bbUsiaStatusField = document.getElementById('bb_usia_status');
            const pbTbUsiaStatusField = document.getElementById('pb_tb_usia_status');
            const bbTbStatusField = document.getElementById('bb_tb_status');
            
            if (bbUsiaField) {
                bbUsiaField.addEventListener('change', checkStuntingStatus);
            }
            
            if (pbTbUsiaField) {
                pbTbUsiaField.addEventListener('change', checkStuntingStatus);
            }
            
            if (bbUsiaStatusField) {
                bbUsiaStatusField.addEventListener('change', checkStuntingStatus);
            }
            
            if (pbTbUsiaStatusField) {
                pbTbUsiaStatusField.addEventListener('change', checkStuntingStatus);
            }

            if (bbTbStatusField) {
                bbTbStatusField.addEventListener('change', checkGiziBurukStatus);
            }

            // Auto-select age group on page load
            setTimeout(autoSelectAgeGroup, 1500);

        });
    </script>
@endpush