@extends('layouts.administrator.master')

@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.edit-include')

@push('css')
    <style>
        #status-ginekologik .card {
            transition: all 0.3s ease;
        }

        #status-ginekologik .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #status-ginekologik textarea {
            min-height: 100px;
            resize: vertical;
        }

        #status-ginekologik .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .character-counter {
            margin-top: 5px;
            font-size: 0.875rem;
        }

        #status-ginekologik .border-success {
            border-color: #28a745 !important;
        }

        #status-ginekologik .border-warning {
            border-color: #ffc107 !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-info mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Asesmen Medis Ginekologik</h4>
                                    <p>
                                        Isikan Asesmen medis dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN MEDIS GINEKOLOGIK --}}
                        <form method="POST" enctype="multipart/form-data" action="{{ route('rawat-inap.asesmen.medis.ginekologik.update', [
                                'kd_unit' => request()->route('kd_unit'),
                                'kd_pasien' => request()->route('kd_pasien'),
                                'tgl_masuk' => request()->route('tgl_masuk'),
                                'urut_masuk' => request()->route('urut_masuk'),
                                'id' => $asesmen->id
                            ]) }}">
                            @csrf
                            @method('PUT')
                            <div class="px-3">
                                <div>

                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="tanggal" id="tanggal_masuk"
                                                    value="{{ $asesmen->rmeAsesmenGinekologik->tanggal ?? date('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                    value="{{ $asesmen->rmeAsesmenGinekologik->jam_masuk ?? date('H:i') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kondisi Masuk</label>
                                            <select class="form-select" name="kondisi_masuk">
                                                <option selected disabled>Pilih</option>
                                                <option value="Mandiri" {{ ($asesmen->rmeAsesmenGinekologik->kondisi_masuk ?? '') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                                <option value="Jalan Kaki" {{ ($asesmen->rmeAsesmenGinekologik->kondisi_masuk ?? '') == 'Jalan Kaki' ? 'selected' : '' }}>Jalan Kaki</option>
                                                <option value="Kursi Roda" {{ ($asesmen->rmeAsesmenGinekologik->kondisi_masuk ?? '') == 'Kursi Roda' ? 'selected' : '' }}>Kursi Roda</option>
                                                <option value="Brankar" {{ ($asesmen->rmeAsesmenGinekologik->kondisi_masuk ?? '') == 'Brankar' ? 'selected' : '' }}>Brankar</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Diagnosis Masuk</label>
                                            <input type="text" class="form-control" name="diagnosis_masuk"
                                                value="{{ $asesmen->rmeAsesmenGinekologik->diagnosis_masuk ?? '' }}">
                                        </div>
                                    </div>

                                    {{-- 2. G/P/A (GRAVIDA, PARA, ABORTUS) --}}
                                    <div class="section-separator" id="gpa">
                                        <h5 class="section-title">2. G/P/A (Gravida, Para, Abortus)</h5>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>G</label>
                                                    <input type="number" class="form-control" name="gravida" placeholder="0"
                                                        min="0" max="20"
                                                        value="{{ $asesmen->rmeAsesmenGinekologik->gravida ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>P</label>
                                                    <input type="number" class="form-control" name="para" placeholder="0"
                                                        min="0" max="20"
                                                        value="{{ $asesmen->rmeAsesmenGinekologik->para ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>A</label>
                                                    <input type="number" class="form-control" name="abortus" placeholder="0"
                                                        min="0" max="20"
                                                        value="{{ $asesmen->rmeAsesmenGinekologik->abortus ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 3. KELUHAN UTAMA --}}
                                    <div class="section-separator" id="keluhan-utama">
                                        <h5 class="section-title">3. Keluhan Utama</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Keluhan Utama/Alasan Masuk RS</label>
                                            <textarea class="form-control" name="keluhan_utama" rows="4"
                                                placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit">{{ $asesmen->rmeAsesmenGinekologik->keluhan_utama ?? '' }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Penyakit</label>
                                            <input type="text" class="form-control" name="riwayat_penyakit"
                                                placeholder="Masukkan riwayat penyakit"
                                                value="{{ $asesmen->rmeAsesmenGinekologik->riwayat_penyakit ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Riwayat Haid</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Siklus</label>
                                                    <div class="input-group">
                                                        <input type="number" name="siklus" class="form-control"
                                                            placeholder="Hari" min="1"
                                                            value="{{ $asesmen->rmeAsesmenGinekologik->siklus ?? '' }}">
                                                        <span class="input-group-text">Hari</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">HPHT</label>
                                                    <input type="number" class="form-control" name="hpht"
                                                        placeholder="Hari Pertama Haid Terakhir"
                                                        value="{{ $asesmen->rmeAsesmenGinekologik->hpht ?? '' }}">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Usia Kehamilan</label>
                                                    <input type="number" class="form-control" name="usia_kehamilan"
                                                        placeholder="Usia Kehamilan"
                                                        value="{{ $asesmen->rmeAsesmenGinekologik->usia_kehamilan ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Perkawinan</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Jumlah</label>
                                                    <div class="input-group">
                                                        <input type="number" name="jumlah" class="form-control"
                                                            placeholder="Total" min="1"
                                                            value="{{ $asesmen->rmeAsesmenGinekologik->jumlah ?? '' }}">
                                                        <span class="input-group-text">Kali</span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Dengan Suami Sekarang</label>
                                                    <div class="input-group">
                                                        <input type="number" name="tahun" class="form-control"
                                                            placeholder="berapa tahun" min="1"
                                                            value="{{ $asesmen->rmeAsesmenGinekologik->tahun ?? '' }}">
                                                        <span class="input-group-text">Tahun</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- 4. RIWAYAT OBSTETRIK --}}
                                    <div class="section-separator" id="riwayat-obstetrik">
                                        <h5 class="section-title">4. Riwayat Obstetrik</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openObstetrikModal">
                                            <i class="ti-plus"></i> Tambah Riwayat Obstetrik
                                        </button>
                                        <input type="hidden" name="riwayat_obstetrik" id="obstetrikInput"
                                            value="{{ $asesmen->rmeAsesmenGinekologik->riwayat_obstetrik ?? '[]' }}">
                                        <div class="table-responsive">
                                            <table class="table" id="obstetrikTable">
                                                <thead>
                                                    <tr>
                                                        <th>Keadaan</th>
                                                        <th>Kehamilan</th>
                                                        <th>Cara Persalinan</th>
                                                        <th>Keadaan Nifas</th>
                                                        <th>Tanggal Lahir</th>
                                                        <th>Keadaan Anak</th>
                                                        <th>Tempat dan Penolong</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Table content will be dynamically populated -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- 5. Riwayat Penaykit terdahulu --}}
                                    <div class="section-separator" id="riwayat-penyakit-terdahulu">
                                        <h5 class="section-title">5. Riwayat penyakit dahulu/ termasuk operasi dan Keluarga
                                            Berencana</h5>
                                        <div class="form-group">
                                            <textarea class="form-control" name="riwayat_penyakit_dahulu" rows="5"
                                                placeholder="Masukkan riwayat penyakit dahulu">{{ $asesmen->rmeAsesmenGinekologik->riwayat_penyakit_dahulu ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    {{-- 6. Tanda Vital --}}
                                    <div class="section-separator">
                                        <h5 class="section-title">6. Tanda Vital</h5>
                                        <div class="form-group">
                                            <label style="min-width: 220px;">Tekanan Darah (mmHg)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Sistole</label>
                                                    <input type="number" class="form-control" name="tekanan_darah_sistole"
                                                        value="{{ $asesmen->rmeAsesmenGinekologikTandaVital->tekanan_darah_sistole ?? '' }}">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Diastole</label>
                                                    <input type="number" class="form-control" name="tekanan_darah_diastole"
                                                        value="{{ $asesmen->rmeAsesmenGinekologikTandaVital->tekanan_darah_diastole ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Suhu (°C)</label>
                                            <input type="number" class="form-control" name="suhu" step="0.1"
                                                value="{{ $asesmen->rmeAsesmenGinekologikTandaVital->suhu ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Respirasi (Per Menit)</label>
                                            <input type="number" class="form-control" name="respirasi"
                                                value="{{ $asesmen->rmeAsesmenGinekologikTandaVital->respirasi ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Nadi (Per Menit)</label>
                                            <input type="number" class="form-control" name="nadi"
                                                value="{{ $asesmen->rmeAsesmenGinekologikTandaVital->nadi ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Nafas (Per Menit)</label>
                                            <input type="number" class="form-control" name="nafas"
                                                value="{{ $asesmen->rmeAsesmenGinekologikTandaVital->nafas ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Berat Badan (Kg)</label>
                                            <input type="number" class="form-control" name="berat_badan"
                                                value="{{ $asesmen->rmeAsesmenGinekologikTandaVital->berat_badan ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Tinggi Badan (Cm)</label>
                                            <input type="number" class="form-control" name="tinggi_badan"
                                                value="{{ $asesmen->rmeAsesmenGinekologikTandaVital->tinggi_badan ?? '' }}">
                                        </div>
                                    </div>

                                    {{-- 7. Pemeriksaan Fisik --}}
                                    <div class="section-separator" id="pemeriksaan-fisik">
                                        <h5 class="section-title">7. Pemeriksaan Fisik</h5>
                                        <div class="row g-3">
                                            <div class="pemeriksaan-fisik">
                                                <h6>Pemeriksaan Fisik</h6>
                                                <p class="text-small">Centang normal jika fisik yang dinilai normal, pilih
                                                    tanda tambah
                                                    untuk menambah keterangan fisik yang ditemukan tidak normal. Jika tidak
                                                    dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                                </p>
                                                <div class="row">
                                                    @php
                                                        // PERBAIKAN: Buat mapping pemeriksaan fisik berdasarkan id_item_fisik
                                                        $pemeriksaanFisikMap = [];
                                                        foreach ($asesmen->pemeriksaanFisik as $item) {
                                                            $pemeriksaanFisikMap[$item->id_item_fisik] = $item;
                                                        }
                                                    @endphp
                                                    @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                        <div class="col-md-6">
                                                            <div class="d-flex flex-column gap-3">
                                                                @foreach ($chunk as $item)
                                                                    @php
                                                                        // PERBAIKAN: Cek apakah item ini ada dalam pemeriksaan
                                                                        $pemeriksaanItem = $pemeriksaanFisikMap[$item->id] ?? null;
                                                                        $isNormal = $pemeriksaanItem ? ($pemeriksaanItem->is_normal == 1) : true;
                                                                        $keterangan = $pemeriksaanItem->keterangan ?? '';
                                                                        $showKeterangan = !$isNormal && !empty($keterangan);
                                                                    @endphp
                                                                    <div class="pemeriksaan-item">
                                                                        <div class="d-flex align-items-center border-bottom pb-2">
                                                                            <div class="flex-grow-1">{{ $item->nama }}</div>
                                                                            <div class="form-check me-3">
                                                                                <input type="checkbox" class="form-check-input"
                                                                                    id="{{ $item->id }}-normal"
                                                                                    name="{{ $item->id }}-normal" {{ $isNormal ? 'checked' : '' }}>
                                                                                <label class="form-check-label"
                                                                                    for="{{ $item->id }}-normal">Normal</label>
                                                                            </div>
                                                                            <button class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                                type="button" data-target="{{ $item->id }}-keterangan">
                                                                                <i class="bi bi-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="keterangan mt-2" id="{{ $item->id }}-keterangan"
                                                                            style="display:{{ $showKeterangan ? 'block' : 'none' }};">
                                                                            <input type="text" class="form-control"
                                                                                name="{{ $item->id }}_keterangan"
                                                                                placeholder="Tambah keterangan jika tidak normal..."
                                                                                value="{{ $keterangan }}">
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 8. PEMERIKSAAN EKSTREMITAS --}}
                                    <div class="section-separator" id="pemeriksaan-ekstremitas">
                                        <h5 class="section-title">8. Pemeriksaan Ekstremitas</h5>

                                        <div class="row">
                                            {{-- Ekstremitas Atas --}}
                                            <div class="col-md-6">
                                                <div class="card h-100">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 fw-semibold">Ekstremitas Atas</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Edema</label>
                                                            <div class="d-flex gap-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="edema_atas" id="edema_atas_ada" value="ada" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->edema_atas ?? '') == 'ada' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edema_atas_ada">
                                                                        Ada
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="edema_atas" id="edema_atas_tidak"
                                                                        value="tidak" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->edema_atas ?? '') == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edema_atas_tidak">
                                                                        Tidak
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Varises</label>
                                                            <div class="d-flex gap-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="varises_atas" id="varises_atas_ada"
                                                                        value="ada" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->varises_atas ?? '') == 'ada' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="varises_atas_ada">
                                                                        Ada
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="varises_atas" id="varises_atas_tidak"
                                                                        value="tidak" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->varises_atas ?? '') == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="varises_atas_tidak">
                                                                        Tidak
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-0">
                                                            <label class="form-label fw-semibold">Refleks</label>
                                                            <div class="d-flex gap-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="refleks_atas" id="refleks_atas_positif"
                                                                        value="positif" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->refleks_atas ?? '') == 'positif' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="refleks_atas_positif">
                                                                        Positif
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="refleks_atas" id="refleks_atas_negatif"
                                                                        value="negatif" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->refleks_atas ?? '') == 'negatif' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="refleks_atas_negatif">
                                                                        Negatif
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Ekstremitas Bawah --}}
                                            <div class="col-md-6">
                                                <div class="card h-100">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 fw-semibold">Ekstremitas Bawah</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Edema</label>
                                                            <div class="d-flex gap-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="edema_bawah" id="edema_bawah_ada" value="ada"
                                                                        {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->edema_bawah ?? '') == 'ada' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edema_bawah_ada">
                                                                        Ada
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="edema_bawah" id="edema_bawah_tidak"
                                                                        value="tidak" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->edema_bawah ?? '') == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="edema_bawah_tidak">
                                                                        Tidak
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Varises</label>
                                                            <div class="d-flex gap-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="varises_bawah" id="varises_bawah_tidak"
                                                                        value="tidak" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->varises_bawah ?? '') == 'tidak' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="varises_bawah_tidak">
                                                                        Tidak
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-0">
                                                            <label class="form-label fw-semibold">Refleks</label>
                                                            <div class="d-flex gap-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="refleks_bawah" id="refleks_bawah_positif"
                                                                        value="positif" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->refleks_bawah ?? '') == 'positif' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="refleks_bawah_positif">
                                                                        Positif
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="refleks_bawah" id="refleks_bawah_negatif"
                                                                        value="negatif" {{ ($asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->refleks_bawah ?? '') == 'negatif' ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="refleks_bawah_negatif">
                                                                        Negatif
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Summary Status (Optional) --}}
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6 class="fw-semibold mb-3">Catatan Tambahan</h6>
                                                        <textarea class="form-control" name="catatan_ekstremitas" rows="3"
                                                            placeholder="Masukkan catatan tambahan tentang pemeriksaan ekstremitas jika diperlukan...">{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->catatan_ekstremitas ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 9. STATUS GINEKOLOGIK DAN PEMERIKSAAN --}}
                                    <div class="section-separator" id="status-ginekologik">
                                        <h5 class="section-title">9. Status Ginekologik dan Pemeriksaan</h5>

                                        <div class="row">
                                            {{-- Column 1 --}}
                                            <div class="col-md-6">
                                                <div class="card mb-3">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 fw-semibold">Status Umum</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Keadaan Umum</label>
                                                            <input type="text" class="form-control" name="keadaan_umum"
                                                                value="{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->keadaan_umum ?? '' }}"
                                                                placeholder="Masukkan keadaan umum pasien">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Status Ginekologik</label>
                                                            <input type="text" class="form-control"
                                                                name="status_ginekologik"
                                                                value="{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->status_ginekologik ?? '' }}"
                                                                placeholder="Masukkan status ginekologik">
                                                        </div>

                                                        <div class="mb-0">
                                                            <label class="form-label fw-semibold">Pemeriksaan</label>
                                                            <input type="text" class="form-control" name="pemeriksaan"
                                                                value="{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->pemeriksaan ?? '' }}"
                                                                placeholder="Masukkan hasil pemeriksaan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Column 2 --}}
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0 fw-semibold">Pemeriksaan Detail</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Inspekulo</label>
                                                            <textarea class="form-control" name="inspekulo" rows="4"
                                                                placeholder="Hasil pemeriksaan inspekulo...">{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->inspekulo ?? '' }}</textarea>
                                                            <small class="text-muted">Pemeriksaan dengan spekulum</small>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">VT (Vaginal
                                                                Toucher)</label>
                                                            <textarea class="form-control" name="vt" rows="4"
                                                                placeholder="Hasil pemeriksaan VT/vaginal toucher...">{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->vt ?? '' }}</textarea>
                                                            <small class="text-muted">Pemeriksaan dalam per vagina</small>
                                                        </div>

                                                        <div class="mb-0">
                                                            <label class="form-label fw-semibold">RT (Rectal
                                                                Toucher)</label>
                                                            <textarea class="form-control" name="rt" rows="4"
                                                                placeholder="Hasil pemeriksaan RT/rectal toucher...">{{ $asesmen->rmeAsesmenGinekologikEkstremitasGinekologik->rt ?? '' }}</textarea>
                                                            <small class="text-muted">Pemeriksaan dalam per rektal</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 10. HASIL PEMERIKSAAN PENUNJANG --}}
                                    <div class="section-separator" id="pemeriksaan-penunjang">
                                        <h5 class="section-title">10. Hasil Pemeriksaan Penunjang</h5>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">1. Laboratorium</label>
                                                <textarea class="form-control" name="laboratorium" rows="6"
                                                    placeholder="Masukkan hasil pemeriksaan laboratorium...">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->laboratorium ?? '' }}</textarea>
                                                <small class="text-muted">Hasil lab darah, urin, dan pemeriksaan
                                                    laboratorium lainnya</small>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">2. USG</label>
                                                <textarea class="form-control" name="usg" rows="6"
                                                    placeholder="Masukkan hasil pemeriksaan USG...">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->usg ?? '' }}</textarea>
                                                <small class="text-muted">Hasil USG abdomen, transvaginal, atau USG
                                                    lainnya</small>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">3. Radiologi</label>
                                                <textarea class="form-control" name="radiologi" rows="6"
                                                    placeholder="Masukkan hasil pemeriksaan radiologi...">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->radiologi ?? '' }}</textarea>
                                                <small class="text-muted">Hasil X-Ray, CT Scan, MRI, dan pemeriksaan
                                                    radiologi lainnya</small>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">4. Lainnya</label>
                                                <textarea class="form-control" name="penunjang_lainnya" rows="6"
                                                    placeholder="Masukkan hasil pemeriksaan penunjang lainnya...">{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->penunjang_lainnya ?? '' }}</textarea>
                                                <small class="text-muted">Hasil pemeriksaan penunjang lain yang belum
                                                    tercantum di atas</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="discharge-planning">
                                        <h5 class="section-title">11. Discharge Planning</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Diagnosis"
                                                value="{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->diagnosis_medis ?? '' }}">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Usia lanjut</label>
                                            <select class="form-select" name="usia_lanjut">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="0" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->usia_lanjut ?? '') === '0' ? 'selected' : '' }}>Ya</option>
                                                <option value="1" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->usia_lanjut ?? '') === '1' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Hambatan mobilisasi</label>
                                            <select class="form-select" name="hambatan_mobilisasi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="0" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->hambatan_mobilisasi ?? '') === '0' ? 'selected' : '' }}>Ya</option>
                                                <option value="1" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->hambatan_mobilisasi ?? '') === '1' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                            <select class="form-select" name="penggunaan_media_berkelanjutan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->penggunaan_media_berkelanjutan ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                                <option value="tidak" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->penggunaan_media_berkelanjutan ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                                harian</label>
                                            <select class="form-select" name="ketergantungan_aktivitas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->ketergantungan_aktivitas ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                                <option value="tidak" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->ketergantungan_aktivitas ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus
                                                Setelah Pulang</label>
                                            <select class="form-select" name="keterampilan_khusus">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->keterampilan_khusus ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                                <option value="tidak" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->keterampilan_khusus ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                                Sakit</label>
                                            <select class="form-select" name="alat_bantu">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->alat_bantu ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                                <option value="tidak" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->alat_bantu ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                                Pulang</label>
                                            <select class="form-select" name="nyeri_kronis">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->nyeri_kronis ?? '') == 'ya' ? 'selected' : '' }}>Ya</option>
                                                <option value="tidak" {{ ($asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->nyeri_kronis ?? '') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Perkiraan lama hari dirawat</label>
                                                <input type="text" class="form-control" name="perkiraan_hari"
                                                    placeholder="hari"
                                                    value="{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->perkiraan_hari ?? '' }}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Rencana Tanggal Pulang</label>
                                                <input type="date" class="form-control" name="tanggal_pulang"
                                                    value="{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->tanggal_pulang ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label class="form-label">KESIMPULAN</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="alert alert-info">
                                                    Pilih semua Planning
                                                </div>
                                                <div class="alert alert-warning">
                                                    Membutuhkan rencana pulang khusus
                                                </div>
                                                <div class="alert alert-success">
                                                    Tidak membutuhkan rencana pulang khusus
                                                </div>
                                            </div>
                                            <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                                value="{{ $asesmen->rmeAsesmenGinekologikPemeriksaanDischarge->kesimpulan_planing ?? 'Tidak membutuhkan rencana pulang khusus' }}">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="fw-semibold mb-4">12. Diagnosis</h5>

                                        <!-- Diagnosis Banding -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis banding yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-banding-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Banding">
                                                <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Diagnosis items will be added here dynamically -->
                                            </div>

                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                                value="{{ $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->diagnosis_banding ?? '[]' }}">
                                        </div>

                                        <!-- Diagnosis Kerja -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan diagnosis kerja yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-kerja-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Kerja">
                                                <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                                <!-- Diagnosis items will be added here dynamically -->
                                            </div>

                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                                value="{{ $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->diagnosis_kerja ?? '[]' }}">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="implemetasi" style="margin-bottom: 2rem;">
                                        <h5 class="fw-semibold mb-4">13. Implementasi</h5>

                                        <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan
                                                Pengobatan</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                                rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</small>
                                        </div>

                                        <!-- Observasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Observasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="observasi-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Observasi">
                                                <span class="input-group-text bg-white" id="add-observasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="observasi-list" class="list-group mb-2 bg-light">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="observasi" name="observasi"
                                                value="{{ $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->observasi ?? '[]' }}">
                                        </div>

                                        <!-- Terapeutik Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Terapeutik</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="terapeutik-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Terapeutik">
                                                <span class="input-group-text bg-white" id="add-terapeutik">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="terapeutik-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="terapeutik" name="terapeutik"
                                                value="{{ $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->terapeutik ?? '[]' }}">
                                        </div>

                                        <!-- Edukasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Edukasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="edukasi-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Edukasi">
                                                <span class="input-group-text bg-white" id="add-edukasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="edukasi-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="edukasi" name="edukasi"
                                                value="{{ $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->edukasi ?? '[]' }}">
                                        </div>

                                        <!-- Kolaborasi Section -->
                                        <div class="mb-4">
                                            <label class="fw-semibold mb-2">Kolaborasi</label>
                                            <div class="input-group mt-2">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="kolaborasi-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Kolaborasi">
                                                <span class="input-group-text bg-white" id="add-kolaborasi">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>
                                            <div id="kolaborasi-list" class="list-group mb-2">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="kolaborasi" name="kolaborasi"
                                                value="{{ $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->kolaborasi ?? '[]' }}">
                                        </div>

                                        <!-- Prognosis Section -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold">Prognosis</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                                                Prognosis yang tidak ditemukan.</small>
                                            <!-- sudah terlanjut buat ke rpp jadi yang di ubah hanya name sesuai DB saja ke prognosis -->
                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="rencana-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Rencana Penatalaksanaan">
                                                <span class="input-group-text bg-white" id="add-rencana">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div id="rencana-list" class="list-group mb-3">
                                                <!-- Items will be added here dynamically -->
                                            </div>
                                            <!-- Hidden input to store JSON data -->
                                            <input type="hidden" id="rencana_penatalaksanaan" name="prognosis"
                                                value="{{ $asesmen->rmeAsesmenGinekologikDiagnosisImplementasi->prognosis ?? '[]' }}">
                                        </div>
                                    </div>

                                    <div class="text-end mt-4">
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
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-ginekologik.modal-edit-alergi')

    <!-- JavaScript untuk interaksi form -->
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function untuk mengatur warna card berdasarkan selection
            function updateCardStatus() {
                const cards = document.querySelectorAll('#pemeriksaan-ekstremitas .card');

                cards.forEach(function (card) {
                    const radioButtons = card.querySelectorAll('input[type="radio"]');
                    let hasSelection = false;
                    let hasAbnormal = false;

                    radioButtons.forEach(function (radio) {
                        if (radio.checked) {
                            hasSelection = true;
                            // Check jika ada nilai abnormal (ada, positif)
                            if (radio.value === 'ada' || radio.value === 'positif') {
                                hasAbnormal = true;
                            }
                        }
                    });

                    // Reset classes
                    card.classList.remove('border-success', 'border-warning', 'border-danger');

                    // Apply appropriate border color
                    if (hasSelection) {
                        if (hasAbnormal) {
                            card.classList.add('border-warning');
                        } else {
                            card.classList.add('border-success');
                        }
                    }
                });
            }

            // Add event listeners to all radio buttons
            const allRadios = document.querySelectorAll('#pemeriksaan-ekstremitas input[type="radio"]');
            allRadios.forEach(function (radio) {
                radio.addEventListener('change', updateCardStatus);
            });

            // Validation helper
            function validateEkstremitas() {
                const requiredGroups = [
                    'edema_atas', 'varises_atas', 'refleks_atas',
                    'edema_bawah', 'varises_bawah', 'refleks_bawah'
                ];

                let incompleteFields = [];

                requiredGroups.forEach(function (groupName) {
                    const checked = document.querySelector(`input[name="${groupName}"]:checked`);
                    if (!checked) {
                        incompleteFields.push(groupName.replace('_', ' ').toUpperCase());
                    }
                });

                return {
                    isValid: incompleteFields.length === 0,
                    missingFields: incompleteFields
                };
            }

            // Expose validation function globally if needed
            window.validateEkstremitas = validateEkstremitas;

            // Initial status update
            updateCardStatus();

            // Optional: Add summary display
            function updateSummary() {
                const summary = document.getElementById('ekstremitas-summary');
                if (summary) {
                    let summaryText = '';

                    // Check ekstremitas atas
                    const edemaAtas = document.querySelector('input[name="edema_atas"]:checked');
                    const varisesAtas = document.querySelector('input[name="varises_atas"]:checked');
                    const refleksAtas = document.querySelector('input[name="refleks_atas"]:checked');

                    if (edemaAtas && varisesAtas && refleksAtas) {
                        summaryText +=
                            `Ekstremitas Atas: Edema ${edemaAtas.value}, Varises ${varisesAtas.value}, Refleks ${refleksAtas.value}. `;
                    }

                    // Check ekstremitas bawah
                    const edemaBawah = document.querySelector('input[name="edema_bawah"]:checked');
                    const varisesBawah = document.querySelector('input[name="varises_bawah"]:checked');
                    const refleksBawah = document.querySelector('input[name="refleks_bawah"]:checked');

                    if (edemaBawah && varisesBawah && refleksBawah) {
                        summaryText +=
                            `Ekstremitas Bawah: Edema ${edemaBawah.value}, Varises ${varisesBawah.value}, Refleks ${refleksBawah.value}.`;
                    }

                    summary.textContent = summaryText;
                }
            }

            // Update summary on radio change
            allRadios.forEach(function (radio) {
                radio.addEventListener('change', updateSummary);
            });

            //-------------------------------------------------------------------------//
            // Function untuk auto-resize textarea
            function autoResize(element) {
                element.style.height = 'auto';
                element.style.height = element.scrollHeight + 'px';
            }

            // Apply auto-resize to all textareas in ginekologik section
            const textareas = document.querySelectorAll('#status-ginekologik textarea');
            textareas.forEach(function (textarea) {
                // Initial resize
                autoResize(textarea);

                // Add event listener for dynamic resizing
                textarea.addEventListener('input', function () {
                    autoResize(this);
                });

                // Add focus effect
                textarea.addEventListener('focus', function () {
                    this.parentNode.querySelector('.form-label').classList.add('text-primary');
                });

                textarea.addEventListener('blur', function () {
                    this.parentNode.querySelector('.form-label').classList.remove('text-primary');
                });
            });

            // Function untuk validation
            function validateGinekologik() {
                const fields = [{
                    name: 'keadaan_umum',
                    label: 'Keadaan Umum'
                },
                {
                    name: 'status_ginekologik',
                    label: 'Status Ginekologik'
                },
                {
                    name: 'pemeriksaan',
                    label: 'Pemeriksaan'
                },
                {
                    name: 'inspekulo',
                    label: 'Inspekulo'
                },
                {
                    name: 'vt',
                    label: 'VT'
                },
                {
                    name: 'rt',
                    label: 'RT'
                }
                ];

                let emptyFields = [];

                fields.forEach(function (field) {
                    const element = document.querySelector(`[name="${field.name}"]`);
                    if (element && !element.value.trim()) {
                        emptyFields.push(field.label);
                    }
                });

                return {
                    isValid: emptyFields.length === 0,
                    emptyFields: emptyFields
                };
            }

            // Add validation indicators
            const inputs = document.querySelectorAll('#status-ginekologik input, #status-ginekologik textarea');
            inputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    if (this.value.trim()) {
                        this.classList.remove('border-warning');
                        this.classList.add('border-success');
                    } else {
                        this.classList.remove('border-success');
                        this.classList.add('border-warning');
                    }
                });

                // Initial state
                if (input.value.trim()) {
                    input.classList.add('border-success');
                }
            });

            // Character counter for textareas (optional)
            function addCharCounter(textarea, maxLength = 500) {
                const counter = document.createElement('small');
                counter.className = 'text-muted character-counter';
                counter.style.float = 'right';
                textarea.parentNode.insertBefore(counter, textarea.nextSibling);

                function updateCounter() {
                    const remaining = maxLength - textarea.value.length;
                    counter.textContent = `${textarea.value.length}/${maxLength} karakter`;

                    if (remaining < 50) {
                        counter.classList.add('text-warning');
                    } else {
                        counter.classList.remove('text-warning');
                    }
                }

                textarea.addEventListener('input', updateCounter);
                updateCounter();
            }

            // Add character counters to textareas
            textareas.forEach(function (textarea) {
                if (textarea.name !== 'catatan_ginekologik') {
                    addCharCounter(textarea);
                }
            });

            // Expose validation function globally
            window.validateGinekologik = validateGinekologik;

            // Auto-capitalize first letter untuk text inputs
            const textInputs = document.querySelectorAll('#status-ginekologik input[type="text"]');
            textInputs.forEach(function (input) {
                input.addEventListener('input', function () {
                    let value = this.value;
                    if (value.length > 0) {
                        this.value = value.charAt(0).toUpperCase() + value.slice(1);
                    }
                });
            });

        });
    </script>
@endpush
