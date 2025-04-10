@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.edit-include')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-inap/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen/medis/umum") }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Edit Asesmen Awal Keperawatan Umum</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN KEPERATAWAN UMUM --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.keperawatan.umum.update', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                                'id' => $asesmen->id,
                            ]) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="px-3">

                                {{-- 1. Data Masuk --}}
                                <div class="section-separator" id="data-masuk">
                                    <h5 class="section-title">1. Data masuk</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <input type="date" class="form-control" name="tanggal_masuk"
                                                id="tanggal_masuk"
                                                value="{{ Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('Y-m-d') }}">
                                            <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                value="{{ Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('H:i') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tiba Di Ruang Rawat Dengan Cara</label>
                                        <select class="form-select" name="cara_masuk">
                                            <option value="" disabled {{ empty($asesmen->asesmenKepUmumDetail->cara_masuk) ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="Mandiri" {{ $asesmen->asesmenKepUmumDetail->cara_masuk == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                            <option value="Tempat Tidur" {{ $asesmen->asesmenKepUmumDetail->cara_masuk == 'Tempat Tidur' ? 'selected' : '' }}>Tempat Tidur</option>
                                            <option value="Jalan Kaki" {{ $asesmen->asesmenKepUmumDetail->cara_masuk == 'Jalan Kaki' ? 'selected' : '' }}>Jalan Kaki</option>
                                            <option value="Kursi Roda" {{ $asesmen->asesmenKepUmumDetail->cara_masuk == 'Kursi Roda' ? 'selected' : '' }}>Kursi Roda</option>
                                            <option value="Brankar" {{ $asesmen->asesmenKepUmumDetail->cara_masuk == 'Brankar' ? 'selected' : '' }}>Brankar</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Diagnosa Masuk</label>
                                        <input type="text" class="form-control" name="diagnosa_masuk" 
                                            value="{{ $asesmen->asesmenKepUmumDetail->diagnosa_masuk ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Barang Berharga</label>
                                        <input type="text" class="form-control" name="barang_berharga" 
                                            value="{{ $asesmen->asesmenKepUmumDetail->barang_berharga ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Alat Bantu</label>
                                        <input type="text" class="form-control" name="alat_bantu" 
                                            value="{{ $asesmen->asesmenKepUmumDetail->alat_bantu ?? '' }}">
                                    </div>
                                </div>

                                {{-- 2. Anamnesis --}}
                                <div class="section-separator" id="anamnesis">
                                    <h5 class="section-title">2. Anamnesis</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Anamnesis</label>
                                        <textarea class="form-control" name="anamnesis" rows="4"
                                            placeholder="keluhan utama dan riwayat penyakit sekarang">{{ $asesmen->anamnesis }}</textarea>
                                    </div>
                                </div>

                                {{-- 3. Pemeriksaan fisik --}}
                                <div class="section-separator" id="pemeriksaan-fisik">
                                    <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            
                                            <div class="flex-grow-1">
                                                <label class="form-label">Sistole</label>
                                                <input type="number" class="form-control" name="sistole"
                                                    placeholder="Sistole" value="{{ $asesmen->asesmenKepUmumDetail->sistole ?? '' }}">
                                            </div>
                                            
                                            <div class="flex-grow-1">
                                                <label class="form-label">Diastole</label>
                                                <input type="number" class="form-control" name="diastole"
                                                    placeholder="Diastole" value="{{ $asesmen->asesmenKepUmumDetail->diastole ?? '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                        <input type="number" class="form-control" name="nadi"
                                            placeholder="frekuensi nadi per menit" value="{{ $asesmen->asesmenKepUmumDetail->nadi ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                        <input type="number" class="form-control" name="nafas"
                                            placeholder="frekuensi nafas per menit" value="{{ $asesmen->asesmenKepUmumDetail->nafas ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Suhu (C)</label>
                                        <input type="number" class="form-control" name="suhu"
                                            placeholder="suhu dalam celcius" value="{{ $asesmen->asesmenKepUmumDetail->suhu ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Tanpa Bantuan O2</label>
                                                <input type="number" class="form-control" name="spo_tanpa_o2"
                                                        placeholder="Tanpa bantuan O2" value="{{ $asesmen->asesmenKepUmumDetail->spo_tanpa_o2 ?? '' }}">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Dengan Bantuan O2</label>
                                                <input type="number" class="form-control" name="spo_dengan_o2"
                                                    placeholder="Dengan bantuan O2" value="{{ $asesmen->asesmenKepUmumDetail->spo_dengan_o2 ?? '' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">AVPU</label>
                                        <select class="form-select" name="avpu">
                                            <option value="" disbale {{ empty($asesmen->asesmenKepUmumDetail->avpu) ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="0" {{ $asesmen->asesmenKepUmumDetail->avpu == '0' ? 'selected' : '' }}>Sadar Baik/Alert</option>
                                            <option value="1" {{ $asesmen->asesmenKepUmumDetail->avpu == '1' ? 'selected' : '' }}>Berespon dengan kata-kata/Voice</option>
                                            <option value="2" {{ $asesmen->asesmenKepUmumDetail->avpu == '2' ? 'selected' : '' }}>Hanya berespon jika dirangsang nyeri/pain</option>
                                            <option value="3" {{ $asesmen->asesmenKepUmumDetail->avpu == '3' ? 'selected' : '' }}>Pasien tidak sadar/unresponsive</option>
                                            <option value="4" {{ $asesmen->asesmenKepUmumDetail->avpu == '4' ? 'selected' : '' }}>Gelisah atau bingung</option>
                                            <option value="5" {{ $asesmen->asesmenKepUmumDetail->avpu == '5' ? 'selected' : '' }}>Acute Confusional States</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Glasgow Coma Scale</label>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-primary me-2" id="btnGcs"
                                                data-bs-toggle="modal"
                                                data-bs-target="#gcsModal">Skor</button>
                                            <input type="number" class="form-control" name="gcs_score"
                                                id="gcs_score" readonly value="{{ $asesmen->asesmenKepUmumDetail->gcs ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6>Antropometri</h6>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                            <input type="number" id="tinggi_badan" name="tinggi_badan" class="form-control" 
                                                value="{{ $asesmen->asesmenKepUmumDetail->tinggi_badan ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                            <input type="number" id="berat_badan" name="berat_badan" class="form-control" 
                                                value="{{ $asesmen->asesmenKepUmumDetail->berat_badan ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">IMT</label>
                                            <input type="text" class="form-control bg-light" id="imt" name="imt" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">LPT</label>
                                            <input type="text" class="form-control bg-light" id="lpt" name="lpt" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lingkar Kepala (Cm)</label>
                                            <input type="number" class="form-control" name="lingkar_kepala"
                                            value="{{ $asesmen->asesmenKepUmumDetail->lingkar_kepala ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="pemeriksaan-fisik">
                                            <h6>Pemeriksaan Fisik</h6>
                                            <p class="text-small">Centang normal jika fisik yang dinilai normal,
                                                pilih tanda tambah untuk menambah keterangan fisik yang ditemukan tidak
                                                normal.
                                                Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                            </p>
                                            <div class="row">
                                                @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                    <div class="col-md-6">
                                                        <div class="d-flex flex-column gap-3">
                                                            @foreach ($chunk as $item)
                                                                @php
                                                                    // Pastikan $item tersedia dan ambil data pemeriksaan fisik terkait
                                                                    if (!empty($asesmen->pemeriksaanFisik)) {
                                                                        $pemeriksaanFisik = $asesmen->pemeriksaanFisik
                                                                            ->where('id_item_fisik', $item->id)
                                                                            ->first();
                                                                        $isNormal = $pemeriksaanFisik
                                                                            ? $pemeriksaanFisik->is_normal
                                                                            : 1;
                                                                        $keterangan = $pemeriksaanFisik
                                                                            ? $pemeriksaanFisik->keterangan
                                                                            : '';
                                                                    } else {
                                                                        $isNormal = 1;
                                                                        $keterangan = '';
                                                                    }
                                                                @endphp
                                                                <div class="pemeriksaan-item">
                                                                    <div
                                                                        class="d-flex align-items-center border-bottom pb-2">
                                                                        <div class="flex-grow-1">{{ $item->nama }}</div>
                                                                        <div class="form-check me-3">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                id="{{ $item->id }}-normal"
                                                                                name="{{ $item->id }}-normal"
                                                                                {{ $isNormal ? 'checked' : '' }}>
                                                                            <label class="form-check-label"
                                                                                for="{{ $item->id }}-normal">Normal</label>
                                                                        </div>
                                                                        <button
                                                                            class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                            type="button"
                                                                            data-target="{{ $item->id }}-keterangan">
                                                                            <i class="bi bi-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="keterangan mt-2"
                                                                        id="{{ $item->id }}-keterangan"
                                                                        style="display:{{ !$isNormal || $keterangan ? 'block' : 'none' }};">
                                                                        <input type="text" class="form-control"
                                                                            name="{{ $item->id }}_keterangan"
                                                                            value="{{ $keterangan }}"
                                                                            placeholder="Tambah keterangan jika tidak normal...">
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

                                 {{-- 4. Status Nyeri --}}
                                <div class="section-separator" id="status-nyeri">
                                    <h5 class="section-title">4. Status nyeri</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                        <select class="form-select" name="jenis_skala_nyeri" id="jenis_skala_nyeri">
                                            <option value="" disabled {{ empty($asesmenKepUmumStatusNyeri->jenis_skala_nyeri) ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="NRS"
                                                {{ $asesmen->asesmenKepUmumStatusNyeri->jenis_skala_nyeri == 1 ? 'selected' : '' }}>
                                                Numeric Rating Scale (NRS)</option>
                                            <option value="FLACC"
                                                {{ $asesmen->asesmenKepUmumStatusNyeri->jenis_skala_nyeri == 2 ? 'selected' : '' }}>
                                                Face, Legs, Activity, Cry, Consolability (FLACC)</option>
                                            <option value="CRIES"
                                                {{ $asesmen->asesmenKepUmumStatusNyeri->jenis_skala_nyeri == 3 ? 'selected' : '' }}>
                                                Crying, Requires, Increased, Expression, Sleepless (CRIES)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                        <input type="text" class="form-control" id="nilai_skala_nyeri"
                                            name="nilai_skala_nyeri" readonly
                                            value="{{ $asesmen->asesmenKepUmumStatusNyeri->nilai_nyeri }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                        <input type="hidden" class="form-control" id="kesimpulan_nyeri"
                                            name="kesimpulan_nyeri"
                                            value="{{ $asesmen->asesmenKepUmumStatusNyeri->kesimpulan_nyeri }}">
                                        <div class="alert alert-success" id="kesimpulan_nyeri_alert">
                                            {{ $asesmen->asesmenKepUmumStatusNyeri->kesimpulan_nyeri ?? 'Pilih skala nyeri terlebih dahulu' }}
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-3">Karakteristik Nyeri</h6>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" name="lokasi_nyeri"
                                                    value="{{ $asesmen->asesmenKepUmumStatusNyeri->lokasi }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Durasi</label>
                                                <input type="text" class="form-control" name="durasi_nyeri"
                                                    value="{{ $asesmen->asesmenKepUmumStatusNyeri->durasi }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Jenis nyeri</label>
                                                <select class="form-select" name="jenis_nyeri">
                                                    <option disabled {{ empty($asesmen->asesmenKepUmumStatusNyeri->jenis_nyeri) ? 'selected' : '' }}>--Pilih--</option>
                                                    @foreach ($jenisnyeri as $jenis)
                                                        <option value="{{ $jenis->id }}"
                                                            {{ $asesmen->asesmenKepUmumStatusNyeri->jenis_nyeri == $jenis->id ? 'selected' : '' }}>
                                                            {{ $jenis->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Frekuensi</label>
                                                <select class="form-select" name="frekuensi_nyeri">
                                                    <option disabled {{ empty($asesmen->asesmenKepUmumStatusNyeri->frekuensi) ? 'selected' : '' }}>--Pilih--</option>
                                                    @foreach ($frekuensinyeri as $frekuensi)
                                                        <option value="{{ $frekuensi->id }}"
                                                            {{ $asesmen->asesmenKepUmumStatusNyeri->frekuensi == $frekuensi->id ? 'selected' : '' }}>
                                                            {{ $frekuensi->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Menjalar?</label>
                                                <select class="form-select" name="nyeri_menjalar">
                                                    <option disabled {{ empty($asesmen->asesmenKepUmumStatusNyeri->menjalarItem) ? 'selected' : '' }}>--Pilih--</option>
                                                    @foreach ($menjalar as $menjalarItem)
                                                        <option value="{{ $menjalarItem->id }}"
                                                            {{ $asesmen->asesmenKepUmumStatusNyeri->menjalar == $menjalarItem->id ? 'selected' : '' }}>
                                                            {{ $menjalarItem->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Kualitas</label>
                                                <select class="form-select" name="kualitas_nyeri">
                                                    <option disabled {{ empty($asesmen->asesmenKepUmumStatusNyeri->kualitas) ? 'selected' : '' }}>--Pilih--</option>
                                                    @foreach ($kualitasnyeri as $kualitas)
                                                        <option value="{{ $kualitas->id }}"
                                                            {{ $asesmen->asesmenKepUmumStatusNyeri->kualitas == $kualitas->id ? 'selected' : '' }}>
                                                            {{ $kualitas->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Faktor pemberat</label>
                                                <select class="form-select" name="faktor_pemberat">
                                                    <option disabled {{ empty($asesmen->asesmenKepUmumStatusNyeri->faktor_pemberat) ? 'selected' : '' }}>--Pilih--</option>
                                                    @foreach ($faktorpemberat as $pemberat)
                                                        <option value="{{ $pemberat->id }}"
                                                            {{ $asesmen->asesmenKepUmumStatusNyeri->faktor_pemberat == $pemberat->id ? 'selected' : '' }}>
                                                            {{ $pemberat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Faktor peringan</label>
                                                <select class="form-select" name="faktor_peringan">
                                                    <option disabled {{ empty($asesmen->asesmenKepUmumStatusNyeri->faktor_peringan) ? 'selected' : '' }}>--Pilih--</option>
                                                    @foreach ($faktorperingan as $peringan)
                                                        <option value="{{ $peringan->id }}"
                                                            {{ $asesmen->asesmenKepUmumStatusNyeri->faktor_peringan == $peringan->id ? 'selected' : '' }}>
                                                            {{ $peringan->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label class="form-label">Efek Nyeri</label>
                                                <select class="form-select" name="efek_nyeri">
                                                    <option disabled {{ empty($asesmen->asesmenKepUmumStatusNyeri->faktor_peringan) ? 'selected' : '' }}>--Pilih--</option>
                                                    @foreach ($efeknyeri as $efek)
                                                        <option value="{{ $efek->id }}"
                                                            {{ $asesmen->asesmenKepUmumStatusNyeri->efek_nyeri == $efek->id ? 'selected' : '' }}>
                                                            {{ $efek->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- 5. Riwayat Kesehatan --}}
                                <div class="section-separator" id="riwayat-kesehatan">
                                    <h5 class="section-title">5. Riwayat Kesehatan</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Penyakit Yang Pernah Diderita</label>
                                        <div class="w-100">
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                data-bs-toggle="modal" data-bs-target="#penyakitModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="selectedPenyakitList" class="d-flex flex-column gap-2">
                                                <!-- List will be populated via JavaScript -->
                                                <div id="emptyState"
                                                    class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                    <i class="ti-info-circle mb-2"></i>
                                                    <p class="mb-0">Belum ada penyakit yang ditambahkan</p>
                                                </div>
                                            </div>
                                            <input type="hidden" name="penyakit_yang_diderita" id="penyakitDideritaInput"
                                                value='{{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) ? ($asesmen->rmeAsesmenKepUmumRiwayatKesehatan->penyakit_yang_diderita ?? '[]') : '[]' }}'>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Kecelakaan</label>
                                        <select class="form-select" name="riwayat_kecelakaan">
                                            <option value="">--Pilih--</option>
                                            @php 
                                                $riwayatKecelakaan = isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) ? 
                                                    $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->riwayat_kecelakaan : null; 
                                            @endphp
                                            <option value="Kecelakaan Lalu Lintas"
                                                {{ $riwayatKecelakaan == 'Kecelakaan Lalu Lintas' ? 'selected' : '' }}>
                                                Kecelakaan Lalu Lintas</option>
                                            <option value="Kecelakaan Kerja"
                                                {{ $riwayatKecelakaan == 'Kecelakaan Kerja' ? 'selected' : '' }}>
                                                Kecelakaan Kerja</option>
                                            <option value="Kecelakaan Rumah Tangga"
                                                {{ $riwayatKecelakaan == 'Kecelakaan Rumah Tangga' ? 'selected' : '' }}>
                                                Kecelakaan Rumah Tangga</option>
                                            <option value="Kecelakaan Olahraga"
                                                {{ $riwayatKecelakaan == 'Kecelakaan Olahraga' ? 'selected' : '' }}>
                                                Kecelakaan Olahraga</option>
                                            <option value="Kecelakaan Lainnya"
                                                {{ $riwayatKecelakaan == 'Kecelakaan Lainnya' ? 'selected' : '' }}>
                                                Kecelakaan Lainnya</option>
                                            <option value="Tidak Ada"
                                                {{ $riwayatKecelakaan == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Rawat Inap</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <select class="form-select flex-grow-1" name="riwayat_rawat_inap">
                                                <option value="">--Pilih--</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->riwayat_rawat_inap == '1' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->riwayat_rawat_inap == '0' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                            <input type="date" class="form-control" name="tanggal_rawat_inap"
                                                value="{{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) ? $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->tanggal_riwayat_rawat_inap : '' }}"
                                                style="width: 200px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Operasi</label>
                                        <select class="form-select" name="riwayat_operasi">
                                            <option value="">--Pilih--</option>
                                            <option value="Ya"
                                                {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->riwayat_operasi == 'Ya' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="Tidak"
                                                {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->riwayat_operasi == 'Tidak' ? 'selected' : '' }}>
                                                Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Jenis/Nama Operasi</label>
                                        <div class="w-100">
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                data-bs-toggle="modal" data-bs-target="#operasiModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="selectedOperasiList" class="d-flex flex-column gap-2">
                                                <div id="emptyStateOperasi"
                                                    class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                    <i class="ti-info-circle mb-2"></i>
                                                    <p class="mb-0">Belum ada operasi yang ditambahkan</p>
                                                </div>
                                            </div>
                                            <input type="hidden" name="jenis_operasi" id="jenisOperasiInput"
                                                value='{{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) ? ($asesmen->rmeAsesmenKepUmumRiwayatKesehatan->nama_operasi ?? '[]') : '[]' }}'>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Konsumsi Obat-Obatan (Jika Ada)</label>
                                        <select class="form-select" name="konsumsi_obat">
                                            <option value="">--Pilih--</option>
                                            <option value="Ya" {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->konsumsi_obat == 'Ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="Tidak" {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->konsumsi_obat == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Merokok ?</label>
                                        <select class="form-select" name="merokok">
                                            <option value="">--Pilih--</option>
                                            <option value="Ya" {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->merokok == 'Ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="Tidak" {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->merokok == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Alkohol</label>
                                        <select class="form-select" name="alkohol">
                                            <option value="">--Pilih--</option>
                                            <option value="Ya" {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->alkohol == 'Ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="Tidak" {{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->alkohol == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Kesehatan Keluarga</label>
                                        <div class="w-100">
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                                @if (isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) && $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->riwayat_penyakit_keluarga)
                                                    <!-- List riwayat kesehatan keluarga akan di-populate via JavaScript -->
                                                @else
                                                    <div id="emptyStateRiwayat"
                                                        class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                        <i class="ti-info-circle mb-2"></i>
                                                        <p class="mb-0">Belum ada riwayat kesehatan keluarga yang
                                                            ditambahkan.</p>
                                                    </div>
                                                @endif
                                            </div>
                                            <input type="hidden" name="riwayat_kesehatan_keluarga"
                                                id="riwayatKesehatanInput"
                                                value="{{ isset($asesmen->rmeAsesmenKepUmumRiwayatKesehatan) ? $asesmen->rmeAsesmenKepUmumRiwayatKesehatan->riwayat_penyakit_keluarga : '' }}">
                                        </div>
                                    </div>
                                </div>

                                {{-- 6. Riwyat Obat --}}
                                <div class="section-separator" id="riwayatObat">
                                    <h5 class="section-title">6. Riwayat Penggunaan Obat</h5>

                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="openObatModal">
                                        <i class="ti-plus"></i> Tambah
                                    </button>
                                    <input type="hidden" name="riwayat_penggunaan_obat" id="riwayatObatData" 
                                        value="{{ $asesmen->asesmenKepUmumDetail->riwayat_penggunaan_obat ?? '[]' }}">
                                    <div class="table-responsive">
                                        <table class="table" id="createRiwayatObatTable">
                                            <thead>
                                                <tr>
                                                    <th>Nama Obat</th>
                                                    <th>Dosis</th>
                                                    <th>Aturan Pakai</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Table content will be dynamically populated -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {{-- 8. Edit Alergi --}}
                                <div class="section-separator" id="alergi">
                                    <h5 class="section-title">7. Alergi</h5>
                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                        id="openAlergiModal">
                                        <i class="ti-plus"></i> Tambah
                                    </button>
                                    <div class="table-responsive">
                                        <table class="table" id="createAlergiTable">
                                            <thead>
                                                <tr>
                                                    <th>Jenis</th>
                                                    <th>Alergen</th>
                                                    <th>Reaksi</th>
                                                    <th>Severe</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Table content will be dynamically populated -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <input type="hidden" name="alergis" id="alergisInput"
                                        value='{{ $asesmen->riwayat_alergi ?? '[]' }}'>

                                </div>


                                {{-- 10. Dekubitus --}}
                                <div class="section-separator" id="decubitus">
                                    <h5 class="section-title">9. Risiko dekubitus</h5>
                                    <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>

                                    <div class="form-group mb-4">
                                        <select class="form-select" id="skalaRisikoDekubitus" name="jenis_skala_dekubitus">
                                            <option value="" disabled>--Pilih Skala--</option>
                                            <option value="norton" {{ $asesmen->asesmenKepUmumRisikoDekubitus->jenis_skala == 1 ? 'selected' : '' }}>Skala Norton</option>
                                            <option value="braden" {{ $asesmen->asesmenKepUmumRisikoDekubitus->jenis_skala == 2 ? 'selected' : '' }}>Skala Braden</option>
                                        </select>
                                    </div>

                                    <!-- Form Skala Norton -->
                                    <div id="formNorton" class="decubitus-form" style="display: none;">
                                        <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi Fisik</label>
                                            <select class="form-select bg-light" name="kondisi_fisik">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_kondisi_fisik == '4' ? 'selected' : '' }}>Baik</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_kondisi_fisik == '3' ? 'selected' : '' }}>Sedang</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_kondisi_fisik == '2' ? 'selected' : '' }}>Buruk</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_kondisi_fisik == '1' ? 'selected' : '' }}>Sangat Buruk</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi mental</label>
                                            <select class="form-select bg-light" name="kondisi_mental">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_kondisi_mental == '4' ? 'selected' : '' }}>Sadar</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_kondisi_mental == '3' ? 'selected' : '' }}>Apatis</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_kondisi_mental == '2' ? 'selected' : '' }}>Bingung</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_kondisi_mental == '1' ? 'selected' : '' }}>Stupor</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Aktivitas</label>
                                            <select class="form-select bg-light" name="norton_aktivitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_aktivitas == '4' ? 'selected' : '' }}>Aktif</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_aktivitas == '3' ? 'selected' : '' }}>Jalan dengan bantuan</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_aktivitas == '2' ? 'selected' : '' }}>Terbatas di kursi</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_aktivitas == '1' ? 'selected' : '' }}>Terbatas di tempat tidur</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Mobilitas</label>
                                            <select class="form-select bg-light" name="norton_mobilitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_mobilitas == '4' ? 'selected' : '' }}>Bebas bergerak</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_mobilitas == '3' ? 'selected' : '' }}>Agak terbatas</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_mobilitas == '2' ? 'selected' : '' }}>Sangat terbatas</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_mobilitas == '1' ? 'selected' : '' }}>Tidak dapat bergerak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Inkontinensia</label>
                                            <select class="form-select bg-light" name="inkontinensia">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_inkontenesia == '4' ? 'selected' : '' }}>Tidak ada</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_inkontenesia == '3' ? 'selected' : '' }}>Kadang-kadang</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_inkontenesia == '2' ? 'selected' : '' }}>Biasanya urin</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->norton_inkontenesia == '1' ? 'selected' : '' }}>Urin dan feses</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div id="kesimpulanNorton" 
                                                    class="alert {{ strpos($asesmen->asesmenKepUmumRisikoDekubitus->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos($asesmen->asesmenKepUmumRisikoDekubitus->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                                    {{ $asesmen->asesmenKepUmumRisikoDekubitus->decubitus_kesimpulan ?? 'Risiko Rendah' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Skala Braden -->
                                    <div id="formBraden" class="decubitus-form" style="display: none;">
                                        <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Braden</h6>
                                        <div class="mb-4">
                                            <label class="form-label">Persepsi Sensori</label>
                                            <select class="form-select bg-light" name="persepsi_sensori">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_persepsi == '1' ? 'selected' : '' }}>Keterbatasan Penuh</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_persepsi == '2' ? 'selected' : '' }}>Sangat Terbatas</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_persepsi == '3' ? 'selected' : '' }}>Keterbatasan Ringan</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_persepsi == '4' ? 'selected' : '' }}>Tidak Ada Gangguan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kelembapan</label>
                                            <select class="form-select bg-light" name="kelembapan">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_kelembapan == '1' ? 'selected' : '' }}>Selalu Lembap</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_kelembapan == '2' ? 'selected' : '' }}>Umumnya Lembap</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_kelembapan == '3' ? 'selected' : '' }}>Kadang-Kadang Lembap</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_kelembapan == '4' ? 'selected' : '' }}>Jarang Lembap</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Aktivitas</label>
                                            <select class="form-select bg-light" name="braden_aktivitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_aktivitas == '1' ? 'selected' : '' }}>Total di Tempat Tidur</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_aktivitas == '2' ? 'selected' : '' }}>Dapat Duduk</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_aktivitas == '3' ? 'selected' : '' }}>Berjalan Kadang-kadang</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_aktivitas == '4' ? 'selected' : '' }}>Dapat Berjalan-jalan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Mobilitas</label>
                                            <select class="form-select bg-light" name="braden_mobilitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_mobilitas == '1' ? 'selected' : '' }}>Tidak Mampu Bergerak Sama sekali</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_mobilitas == '2' ? 'selected' : '' }}>Sangat Terbatas</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_mobilitas == '3' ? 'selected' : '' }}>Tidak Ada Masalah</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_mobilitas == '4' ? 'selected' : '' }}>Tanpa Keterbatasan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Nutrisi</label>
                                            <select class="form-select bg-light" name="nutrisi">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_nutrisi == '1' ? 'selected' : '' }}>Sangat Buruk</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_nutrisi == '2' ? 'selected' : '' }}>Kurang Menucukup</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_nutrisi == '3' ? 'selected' : '' }}>Mencukupi</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_nutrisi == '4' ? 'selected' : '' }}>Sangat Baik</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pergesekan dan Pergeseran</label>
                                            <select class="form-select bg-light" name="pergesekan">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_pergesekan == '1' ? 'selected' : '' }}>Bermasalah</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_pergesekan == '2' ? 'selected' : '' }}>Potensial Bermasalah</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumRisikoDekubitus->braden_pergesekan == '3' ? 'selected' : '' }}>Keterbatasan Ringan</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div id="kesimpulanBraden" 
                                                    class="alert {{ strpos($asesmen->asesmenKepUmumRisikoDekubitus->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos($asesmen->asesmenKepUmumRisikoDekubitus->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                                    {{ $asesmen->asesmenKepUmumRisikoDekubitus->decubitus_kesimpulan ?? 'Kesimpulan Skala Braden' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- 11. Psikologis --}}
                                <div class="section-separator" id="statusPsikologis">
                                    <h5 class="section-title">9. Status Psikologis</h5>

                                    <div class="mb-4">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <label>Kondisi Psikologis</label>
                                            <div class="dropdown-wrapper" style="position: relative;">
                                                <button type="button" class="btn btn-sm btn-primary" id="btnKondisiPsikologis">
                                                    <i class="ti-plus"></i>
                                                </button>
                                                <div class="dropdown-menu" id="dropdownKondisiPsikologis" style="display: none; position: absolute; z-index: 1000;">
                                                    <div class="p-2">
                                                        <div class="fw-bold mb-2">STATUS PSIKOLOGIS PASIEN</div>
                                                        <div class="kondisi-options">
                                                            @php
                                                                $kondisiPsikologis = json_decode($asesmen->asesmenKepUmumStatusPsikologis->kondisi_psikologis ?? '[]', true);
                                                            @endphp
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Tidak ada kelainan" id="kondisi1" 
                                                                    {{ in_array('Tidak ada kelainan', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi1">Tidak ada kelainan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Cemas" id="kondisi2"
                                                                    {{ in_array('Cemas', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi2">Cemas</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Takut" id="kondisi3"
                                                                    {{ in_array('Takut', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi3">Takut</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Marah" id="kondisi4"
                                                                    {{ in_array('Marah', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi4">Marah</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Sedih" id="kondisi5"
                                                                    {{ in_array('Sedih', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi5">Sedih</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Tenang" id="kondisi6"
                                                                    {{ in_array('Tenang', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi6">Tenang</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Tidak semangat" id="kondisi7"
                                                                    {{ in_array('Tidak semangat', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi7">Tidak semangat</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Tertekan" id="kondisi8"
                                                                    {{ in_array('Tertekan', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi8">Tertekan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Depresi" id="kondisi9"
                                                                    {{ in_array('Depresi', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi9">Depresi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="Sulit tidur" id="kondisi10"
                                                                    {{ in_array('Sulit tidur', $kondisiPsikologis) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="kondisi10">Sulit tidur</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="selectedKondisiPsikologis" class="d-flex gap-2 flex-wrap">
                                                <!-- Selected items will be displayed here as badges -->
                                            </div>
                                        </div>
                                        <input type="hidden" name="kondisi_psikologis_json" id="kondisi_psikologis_json" value='{{ $asesmen->asesmenKepUmumStatusPsikologis->kondisi_psikologis ?? "[]" }}'>
                                    </div>

                                    <div class="mb-4">
                                        <div class="d-flex align-items-start gap-2 mb-2">
                                            <label>Gangguan Perilaku</label>
                                            <div class="dropdown-wrapper" style="position: relative;">
                                                <button type="button" class="btn btn-sm btn-primary" id="btnGangguanPerilaku">
                                                    <i class="ti-plus"></i>
                                                </button>

                                                <!-- Dropdown Menu -->
                                                <div class="dropdown-menu p-2 shadow-sm" id="dropdownGangguanPerilaku"
                                                    style="display: none; position: absolute; z-index: 1000; min-width: 250px; background: white; border: 1px solid rgba(0,0,0,.15); border-radius: 4px;">
                                                    <div class="fw-bold mb-2">GANGGUAN PERILAKU</div>
                                                    <div class="perilaku-options">
                                                        @php
                                                            $gangguanPerilaku = json_decode($asesmen->asesmenKepUmumStatusPsikologis->gangguan_perilaku ?? '[]', true);
                                                        @endphp
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" value="Tidak Ada Gangguan" id="perilaku1"
                                                                {{ in_array('Tidak Ada Gangguan', $gangguanPerilaku) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="perilaku1">Tidak Ada Gangguan</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" value="Perilaku Kekerasan" id="perilaku2"
                                                                {{ in_array('Perilaku Kekerasan', $gangguanPerilaku) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="perilaku2">Perilaku Kekerasan</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" value="Halusinasi" id="perilaku3"
                                                                {{ in_array('Halusinasi', $gangguanPerilaku) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="perilaku3">Halusinasi</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="selectedGangguanPerilaku" class="d-flex gap-2 flex-wrap align-items-center">
                                                <!-- Selected items will be displayed here as badges -->
                                            </div>
                                        </div>
                                        <input type="hidden" name="gangguan_perilaku_json" id="gangguan_perilaku_json" value='{{ $asesmen->asesmenKepUmumStatusPsikologis->gangguan_perilaku ?? "[]" }}'>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Potensi menyakiti diri sendiri/orang lain</label>
                                        <select class="form-select" name="potensi_menyakiti">
                                            <option value="" {{ $asesmen->asesmenKepUmumStatusPsikologis->potensi_menyakiti == null ? 'selected' : '' }} disabled>pilih</option>
                                            <option value="0" {{ $asesmen->asesmenKepUmumStatusPsikologis->potensi_menyakiti == 0 ? 'selected' : '' }}>Ya</option>
                                            <option value="1" {{ $asesmen->asesmenKepUmumStatusPsikologis->potensi_menyakiti == 1 ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Anggota Keluarga Gangguan Jiwa</label>
                                        <select class="form-select" name="anggota_keluarga_gangguan_jiwa">
                                            <option value="" disabled {{ empty($asesmen->asesmenKepUmumStatusPsikologis->keluarga_gangguan_jiwa) ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="0" {{ $asesmen->asesmenKepUmumStatusPsikologis->keluarga_gangguan_jiwa == 0 ? 'selected' : '' }}>Ya</option>
                                            <option value="1" {{ $asesmen->asesmenKepUmumStatusPsikologis->keluarga_gangguan_jiwa == 1 ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Lainnya</label>
                                        <input type="text" class="form-control" name="psikologis_lainnya" value="{{ $asesmen->asesmenKepUmumStatusPsikologis->lainnya }}">
                                    </div>
                                </div>

                                {{-- 12. Spritiual --}}
                                <div class="section-separator" id="status_spiritual">
                                    <h5 class="section-title">10. Status Spiritual</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Keyakinan Agama</label>
                                        <select class="form-select" name="keyakinan_agama">
                                            <option value="" {{ $asesmen->asesmenKepUmum->keyakinan_agama == null ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="Islam" {{ $asesmen->asesmenKepUmum->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Protestan" {{ $asesmen->asesmenKepUmum->agama == 'Protestan' ? 'selected' : '' }}>Protestan</option>
                                            <option value="Khatolik" {{ $asesmen->asesmenKepUmum->agama == 'Khatolik' ? 'selected' : '' }}>Khatolik</option>
                                            <option value="Budha" {{ $asesmen->asesmenKepUmum->agama == 'Budha' ? 'selected' : '' }}>Budha</option>
                                            <option value="Hindu" {{ $asesmen->asesmenKepUmum->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Konghucu" {{ $asesmen->asesmenKepUmum->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                            <option value="Lainnya" {{ $asesmen->asesmenKepUmum->agama == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pandangan Pasien Terhadap Penyakit Nya</label>
                                        <select class="form-select" name="pandangan_terhadap_penyakit">
                                            <option value="" {{ $asesmen->asesmenKepUmum->pandangan_terhadap_penyakit == null ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="Takdir" {{ $asesmen->asesmenKepUmum->pandangan_terhadap_penyakit == 'Takdir' ? 'selected' : '' }}>Takdir</option>
                                            <option value="Hukuman" {{ $asesmen->asesmenKepUmum->pandangan_terhadap_penyakit == 'Hukuman' ? 'selected' : '' }}>Hukuman</option>
                                            <option value="Tidak Ada" {{ $asesmen->asesmenKepUmum->pandangan_terhadap_penyakit == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            <option value="Lainnya" {{ $asesmen->asesmenKepUmum->pandangan_terhadap_penyakit == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="section-separator" id="status_sosial_ekonomi">
                                    <h5 class="section-title">11. Status Sosial Ekonomi</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pekerjaan</label>
                                        <select class="form-select" name="pekerjaan_pasien">
                                            <option value="" {{ !$asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_pekerjaan ? 'selected' : '' }}>--Pilih--</option>
                                            @foreach ($pekerjaan as $kerjaan)
                                                <option value="{{ $kerjaan->kd_pekerjaan }}"
                                                    {{ old('sosial_ekonomi_pekerjaan', $asesmen->asesmenKepUmumSosialEkonomi->sosial_ekonomi_pekerjaan ?? '') == $kerjaan->kd_pekerjaan ? 'selected' : '' }}>
                                                    {{ $kerjaan->pekerjaan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status Pernikahan</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <select class="form-select flex-grow-1" name="status_pernikahan">
                                                <option value="" {{ !$asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_status_pernikahan ? 'selected' : '' }}>--Pilih--</option>
                                                <option value="Menikah" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_status_pernikahan == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                                <option value="Belum Menikah" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_status_pernikahan == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                                <option value="Cerai" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_status_pernikahan == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tempat Tinggal</label>
                                        <select class="form-select" name="tempat_tinggal">
                                            <option value="" {{ !$asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_tempat_tinggal ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="Rumah" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_tempat_tinggal == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                                            <option value="Asrama" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_tempat_tinggal == 'Asrama' ? 'selected' : '' }}>Asrama</option>
                                            <option value="Lainnya" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_tempat_tinggal == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Curiga Penganiayaan</label>
                                        <select class="form-select" name="curiga_penganiayaan">
                                            <option value="" {{ !$asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_curiga_penganiayaan ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="Ya" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_curiga_penganiayaan == 'Ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="Tidak" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_curiga_penganiayaan == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status Tinggal Dengan Keluarga</label>
                                        <select class="form-select" name="status_tinggal">
                                            <option value="" {{ !$asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="Orang Tua" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                            <option value="Wali" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga == 'Wali' ? 'selected' : '' }}>Wali</option>
                                            <option value="Lainnya" {{ $asesmen->asesmenKepUmumSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="section-separator" id="status_gizi">
                                    <h5 class="section-title">10. Status Gizi</h5>
                                    <div class="form-group mb-4">
                                        <select class="form-select" name="gizi_jenis" id="nutritionAssessment">
                                            <option value="">--Pilih--</option>
                                            <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_jenis == 1 ? 'selected' : '' }}>Malnutrition Screening Tool (MST)</option>
                                            <option value="2" {{ $asesmen->asesmenKepUmumGizi->gizi_jenis == 2 ? 'selected' : '' }}>The Mini Nutritional Assessment (MNA)</option>
                                            <option value="3" {{ $asesmen->asesmenKepUmumGizi->gizi_jenis == 3 ? 'selected' : '' }}>Strong Kids (1 bln - 18 Tahun)</option>
                                            <option value="5" {{ $asesmen->asesmenKepUmumGizi->gizi_jenis == 5 ? 'selected' : '' }}>Tidak Dapat Dinilai</option>
                                        </select>
                                    </div>

                                    <!-- MST Form -->
                                    <div id="mst" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?</label>
                                            <select class="form-select" name="gizi_mst_penurunan_bb">
                                                <option value="">pilih</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_penurunan_bb == '0' ? 'selected' : '' }}>Tidak ada penurunan Berat Badan (BB)</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_penurunan_bb == '2' ? 'selected' : '' }}>Tidak yakin/ tidak tahu/ terasa baju lebi longgar</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_penurunan_bb == '3' ? 'selected' : '' }}>Ya ada penurunan BB</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB", berapa penurunan BB tersebut?</label>
                                            <select class="form-select" name="gizi_mst_jumlah_penurunan_bb">
                                                <option value="0">pilih</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_jumlah_penurunan_bb == '1' ? 'selected' : '' }}>1-5 kg</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_jumlah_penurunan_bb == '2' ? 'selected' : '' }}>6-10 kg</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_jumlah_penurunan_bb == '3' ? 'selected' : '' }}>11-15 kg</option>
                                                <option value="4" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_jumlah_penurunan_bb == '4' ? 'selected' : '' }}>>15 kg</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu makan?</label>
                                            <select class="form-select" name="gizi_mst_nafsu_makan_berkurang">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_nafsu_makan_berkurang == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_nafsu_makan_berkurang == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer (kemoterapi), Geriatri, GGk (hemodialisis), Penurunan Imun</label>
                                            <select class="form-select" name="gizi_mst_diagnosis_khusus">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_diagnosis_khusus == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_mst_diagnosis_khusus == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="mstConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko malnutrisi</div>
                                            <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi</div>
                                            <input type="hidden" name="gizi_mst_kesimpulan" id="gizi_mst_kesimpulan" value="{{ $asesmen->asesmenKepUmumGizi->gizi_mst_kesimpulan }}">
                                        </div>
                                    </div>

                                    <!-- MNA Form -->
                                    <div id="mna" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi The Mini Nutritional Assessment (MNA) / Lansia</h6>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah pasien mengalami penurunan asupan makanan selama 3 bulan terakhir karena hilang selera makan, masalah pencernaan, kesulitan mengunyah atau menelan?
                                            </label>
                                            <select class="form-select" name="gizi_mna_penurunan_asupan_3_bulan">
                                                <option value="">--Pilih--</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_penurunan_asupan_3_bulan == '0' ? 'selected' : '' }}>Mengalami penurunan asupan makanan yang parah</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_penurunan_asupan_3_bulan == '1' ? 'selected' : '' }}>Mengalami penurunan asupan makanan sedang</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_penurunan_asupan_3_bulan == '2' ? 'selected' : '' }}>Tidak mengalami penurunan asupan makanan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah pasien mengalami kehilangan Berat Badan (BB) selama 3 bulan terakhir?
                                            </label>
                                            <select class="form-select" name="gizi_mna_kehilangan_bb_3_bulan">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_kehilangan_bb_3_bulan == '0' ? 'selected' : '' }}>Kehilangan BB lebih dari 3 Kg</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_kehilangan_bb_3_bulan == '1' ? 'selected' : '' }}>Tidak tahu</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_kehilangan_bb_3_bulan == '2' ? 'selected' : '' }}>Kehilangan BB antara 1 s.d 3 Kg</option>
                                                <option value="3" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_kehilangan_bb_3_bulan == '3' ? 'selected' : '' }}>Tidak ada kehilangan BB</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana mobilisasi atau pergerakan pasien?</label>
                                            <select class="form-select" name="gizi_mna_mobilisasi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_mobilisasi == '0' ? 'selected' : '' }}>Hanya di tempat tidur atau kursi roda</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_mobilisasi == '1' ? 'selected' : '' }}>Dapat turun dari tempat tidur tapi tidak dapat jalan-jalan</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_mobilisasi == '2' ? 'selected' : '' }}>Dapat jalan-jalan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah Pasien mengalami stres psikologi atau penyakit akut selama 3 bulan terakhir?
                                            </label>
                                            <select class="form-select" name="gizi_mna_stress_penyakit_akut">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_stress_penyakit_akut == '0' ? 'selected' : '' }}>Ya</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_stress_penyakit_akut == '1' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami masalah neuropsikologi?</label>
                                            <select class="form-select" name="gizi_mna_status_neuropsikologi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_status_neuropsikologi == '0' ? 'selected' : '' }}>Demensia atau depresi berat</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_status_neuropsikologi == '1' ? 'selected' : '' }}>Demensia ringan</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumGizi->gizi_mna_status_neuropsikologi == '2' ? 'selected' : '' }}>Tidak mengalami masalah neuropsikologi</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                            <input type="number" name="gizi_mna_berat_badan" class="form-control" id="mnaWeight" min="1" step="0.1" placeholder="Masukkan berat badan dalam Kg" value="{{ $asesmen->asesmenKepUmumGizi->gizi_mna_berat_badan }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Tinggi Badan (TB) pasien? (cm)</label>
                                            <input type="number" name="gizi_mna_tinggi_badan" class="form-control" id="mnaHeight" min="1" step="0.1" placeholder="Masukkan tinggi badan dalam cm" value="{{ $asesmen->asesmenKepUmumGizi->gizi_mna_tinggi_badan }}">
                                        </div>

                                        <!-- IMT -->
                                        <div class="mb-3">
                                            <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                            <div class="text-muted small mb-2">
                                                <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                            </div>
                                            <input type="number" name="gizi_mna_imt" class="form-control bg-light" id="mnaBMI" readonly placeholder="IMT akan terhitung otomatis" value="{{ $asesmen->asesmenKepUmumGizi->gizi_mna_imt }}">
                                        </div>

                                        <!-- Kesimpulan -->
                                        <div id="mnaConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-info mb-3" style="{{ $asesmen->asesmenKepUmumGizi->gizi_mna_kesimpulan ? 'display: none;' : '' }}">
                                                Silakan isi semua parameter di atas untuk melihat kesimpulan
                                            </div>
                                            <div class="alert alert-success" style="{{ strpos($asesmen->asesmenKepUmumGizi->gizi_mna_kesimpulan ?? '', 'Tidak Beresiko') !== false ? '' : 'display: none;' }}">
                                                Kesimpulan: Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)
                                            </div>
                                            <div class="alert alert-warning" style="{{ strpos($asesmen->asesmenKepUmumGizi->gizi_mna_kesimpulan ?? '', 'Beresiko') !== false ? '' : 'display: none;' }}">
                                                Kesimpulan: Total Skor ≤ 11 (Beresiko Malnutrisi)
                                            </div>
                                            <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan" value="{{ $asesmen->asesmenKepUmumGizi->gizi_mna_kesimpulan }}">
                                        </div>
                                    </div>

                                    <!-- Strong Kids Form -->
                                    <div id="strong-kids" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah anak tampa kurus kehilangan lemak subkutan, kehilangan massa otot, dan/ atau wajah cekung?</label>
                                            <select class="form-select" name="gizi_strong_status_kurus">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_strong_status_kurus == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_strong_status_kurus == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penurunan BB selama satu bulan terakhir (untuk semua usia)?
                                                (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif dari orang tua pasien ATAU tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1 tahun) selama 3 bulan terakhir)</label>
                                            <select class="form-select" name="gizi_strong_penurunan_bb">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_strong_penurunan_bb == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_strong_penurunan_bb == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah salah satu dari hal berikut ini ada? <br>
                                                - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari) selama 1-3 hari terakhir
                                                - Penurunan asupan makanan selama 1-3 hari terakhir
                                                - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau pemberian maka selang)</label>
                                            <select class="form-select" name="gizi_strong_gangguan_pencernaan">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->asesmenKepUmumGizi->gizi_strong_gangguan_pencernaan == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_strong_gangguan_pencernaan == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko mengalaman mainutrisi? <br>
                                                <a href="#"><i>Lihat penyakit yang berisiko malnutrisi</i></a></label>
                                            <select class="form-select" name="gizi_strong_penyakit_berisiko">
                                                <option value="">pilih</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumGizi->gizi_strong_penyakit_berisiko == '2' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_strong_penyakit_berisiko == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success" style="{{ strpos($asesmen->asesmenKepUmumGizi->gizi_strong_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">Kesimpulan: 0 (Beresiko rendah)</div>
                                            <div class="alert alert-warning" style="{{ strpos($asesmen->asesmenKepUmumGizi->gizi_strong_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">Kesimpulan: 1-3 (Beresiko sedang)</div>
                                            <div class="alert alert-danger" style="{{ strpos($asesmen->asesmenKepUmumGizi->gizi_strong_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">Kesimpulan: 4-5 (Beresiko Tinggi)</div>
                                            <input type="hidden" name="gizi_strong_kesimpulan" id="gizi_strong_kesimpulan" value="{{ $asesmen->asesmenKepUmumGizi->gizi_strong_kesimpulan }}">
                                        </div>
                                    </div>

                                    <!-- Form NRS -->
                                    <div id="nrs" class="assessment-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko NRS</h5>

                                        <!-- NRS Form fields here -->
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien datang kerumah sakit karena jatuh?</label>
                                            <select class="form-select" name="gizi_nrs_jatuh_saat_masuk_rs">
                                                <option value="">pilih</option>
                                                <option value="2" {{ $asesmen->asesmenKepUmumGizi->gizi_nrs_jatuh_saat_masuk_rs == '2' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->asesmenKepUmumGizi->gizi_nrs_jatuh_saat_masuk_rs == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Add more NRS form fields here -->
                                        
                                        <!-- Nilai -->
                                        <div id="nrsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success" style="{{ strpos($asesmen->asesmenKepUmumGizi->gizi_nrs_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko rendah</div>
                                            <div class="alert alert-warning" style="{{ strpos($asesmen->asesmenKepUmumGizi->gizi_nrs_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko sedang</div>
                                            <div class="alert alert-danger" style="{{ strpos($asesmen->asesmenKepUmumGizi->gizi_nrs_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko Tinggi</div>
                                            <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan" value="{{ $asesmen->asesmenKepUmumGizi->gizi_nrs_kesimpulan }}">
                                        </div>
                                    </div>
                                </div>


                                <div class="section-separator" id="status-fungsional">
                                    <h5 class="section-title">11. Status Fungsional</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Pilih jenis Skala Pengkajian Aktivitas Harian (ADL) sesuai kondisi pasien</label>
                                        <select class="form-select" name="skala_fungsional" id="skala_fungsional">
                                            <option value="" disabled selected>Pilih Skala Fungsional</option>
                                            <option value="Pengkajian Aktivitas" {{ isset($asesmen->asesmenKepUmumStatusFungsional) && $asesmen->asesmenKepUmumStatusFungsional->jenis_skala == 1 ? 'selected' : '' }}>Pengkajian Aktivitas Harian</option>
                                            <option value="Lainnya" {{ isset($asesmen->asesmenKepUmumStatusFungsional) && $asesmen->asesmenKepUmumStatusFungsional->jenis_skala == 2 ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nilai Skala ADL</label>
                                        <input type="text" class="form-control" id="adl_total" name="adl_total" readonly value="{{ isset($asesmen->asesmenKepUmumStatusFungsional) ? $asesmen->asesmenKepUmumStatusFungsional->nilai_skala_adl : '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesimpulan Fungsional</label>
                                        <div id="adl_kesimpulan" class="alert {{ isset($asesmen->asesmenKepUmumStatusFungsional) && $asesmen->asesmenKepUmumStatusFungsional->kesimpulan_fungsional ? 
                                            (strpos($asesmen->asesmenKepUmumStatusFungsional->kesimpulan_fungsional, 'Ketergantungan Total') !== false ? 'alert-danger' : 
                                            (strpos($asesmen->asesmenKepUmumStatusFungsional->kesimpulan_fungsional, 'Ketergantungan Berat') !== false ? 'alert-warning' : 
                                            (strpos($asesmen->asesmenKepUmumStatusFungsional->kesimpulan_fungsional, 'Ketergantungan Sedang') !== false ? 'alert-info' : 'alert-success'))) 
                                            : 'alert-info' }}">
                                            {{ isset($asesmen->asesmenKepUmumStatusFungsional) && $asesmen->asesmenKepUmumStatusFungsional->kesimpulan_fungsional ? $asesmen->asesmenKepUmumStatusFungsional->kesimpulan_fungsional : 'Pilih skala aktivitas harian terlebih dahulu' }}
                                        </div>
                                    </div>
                                    
                                    <!-- Hidden fields untuk menyimpan data ADL -->
                                    <input type="hidden" id="adl_jenis_skala" name="adl_jenis_skala" value="{{ isset($asesmen->asesmenKepUmumStatusFungsional) ? $asesmen->asesmenKepUmumStatusFungsional->jenis_skala : '' }}">
                                    <input type="hidden" id="adl_makan" name="adl_makan" value="{{ isset($asesmen->asesmenKepUmumStatusFungsional) ? $asesmen->asesmenKepUmumStatusFungsional->makan : '' }}">
                                    <input type="hidden" id="adl_makan_value" name="adl_makan_value" value="{{ isset($asesmen->asesmenKepUmumStatusFungsional) ? $asesmen->asesmenKepUmumStatusFungsional->makan_value : '' }}">
                                    <input type="hidden" id="adl_berjalan" name="adl_berjalan" value="{{ isset($asesmen->asesmenKepUmumStatusFungsional) ? $asesmen->asesmenKepUmumStatusFungsional->berjalan : '' }}">
                                    <input type="hidden" id="adl_berjalan_value" name="adl_berjalan_value" value="{{ isset($asesmen->asesmenKepUmumStatusFungsional) ? $asesmen->asesmenKepUmumStatusFungsional->berjalan_value : '' }}">
                                    <input type="hidden" id="adl_mandi" name="adl_mandi" value="{{ isset($asesmen->asesmenKepUmumStatusFungsional) ? $asesmen->asesmenKepUmumStatusFungsional->mandi : '' }}">
                                    <input type="hidden" id="adl_mandi_value" name="adl_mandi_value" value="{{ isset($asesmen->asesmenKepUmumStatusFungsional) ? $asesmen->asesmenKepUmumStatusFungsional->mandi_value : '' }}">
                                    <input type="hidden" id="adl_kesimpulan_value" name="adl_kesimpulan_value" value="{{ isset($asesmen->asesmenKepUmumStatusFungsional) ? $asesmen->asesmenKepUmumStatusFungsional->kesimpulan_fungsional : '' }}">
                                </div>

                                <div class="section-separator" id="kebutuhan-edukasi">
                                    <h5 class="section-title">12. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gaya Bicara</label>
                                        <select class="form-select" name="kebutuhan_edukasi_gaya_bicara">
                                            <option value="" disabled {{ !$asesmen->asesmenKepUmum || !$asesmen->asesmenKepUmum->kebutuhan_edukasi_gaya_bicara ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="normal" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_gaya_bicara == 'normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="lambat" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_gaya_bicara == 'lambat' ? 'selected' : '' }}>Lambat</option>
                                            <option value="cepat" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_gaya_bicara == 'cepat' ? 'selected' : '' }}>Cepat</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Bahasa Sehari-Hari</label>
                                        <select class="form-select" name="kebutuhan_edukasi_bahasa_sehari_hari">
                                            <option value="" disabled {{ !$asesmen->asesmenKepUmum || !$asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="Bahasa Indonesia" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                            <option value="Aceh" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                                            <option value="Batak" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Batak' ? 'selected' : '' }}>Batak</option>
                                            <option value="Minangkabau" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Minangkabau' ? 'selected' : '' }}>Minangkabau</option>
                                            <option value="Melayu" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Melayu' ? 'selected' : '' }}>Melayu</option>
                                            <option value="Sunda" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Sunda' ? 'selected' : '' }}>Sunda</option>
                                            <option value="Jawa" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Jawa' ? 'selected' : '' }}>Jawa</option>
                                            <option value="Madura" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Madura' ? 'selected' : '' }}>Madura</option>
                                            <option value="Bali" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Bali' ? 'selected' : '' }}>Bali</option>
                                            <option value="Sasak" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Sasak' ? 'selected' : '' }}>Sasak</option>
                                            <option value="Banjar" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Banjar' ? 'selected' : '' }}>Banjar</option>
                                            <option value="Bugis" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari == 'Bugis' ? 'selected' : '' }}>Bugis</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Perlu Penerjemah</label>
                                        <select class="form-select" name="kebutuhan_edukasi_perlu_penerjemah">
                                            <option value="" disabled {{ !$asesmen->asesmenKepUmum || !$asesmen->asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="ya" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah == 'ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="tidak" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hambatan Komunikasi</label>
                                        <select class="form-select" name="kebutuhan_edukasi_hambatan_komunikasi">
                                            <option value="" disabled {{ !$asesmen->asesmenKepUmum || !$asesmen->asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="tidak_ada" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            <option value="pendengaran" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi == 'pendengaran' ? 'selected' : '' }}>Gangguan Pendengaran</option>
                                            <option value="bicara" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi == 'bicara' ? 'selected' : '' }}>Gangguan Bicara</option>
                                            <option value="bahasa" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi == 'bahasa' ? 'selected' : '' }}>Perbedaan Bahasa</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media Disukai</label>
                                        <select class="form-select" name="kebutuhan_edukasi_media_belajar">
                                            <option value="" disabled {{ !$asesmen->asesmenKepUmum || !$asesmen->asesmenKepUmum->kebutuhan_edukasi_media_belajar ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="cetak" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_media_belajar == 'cetak' ? 'selected' : '' }}>Media Cetak</option>
                                            <option value="video" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_media_belajar == 'video' ? 'selected' : '' }}>Video</option>
                                            <option value="diskusi" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_media_belajar == 'diskusi' ? 'selected' : '' }}>Diskusi Langsung</option>
                                            <option value="demonstrasi" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_media_belajar == 'demonstrasi' ? 'selected' : '' }}>Demonstrasi</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pendidikan</label>
                                        <select class="form-select" name="kebutuhan_edukasi_tingkat_pendidikan">
                                            <option value="" disabled {{ !$asesmen->asesmenKepUmum || empty($asesmen->asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan) ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="SD" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan === 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan === 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan === 'SMA' ? 'selected' : '' }}>SMA</option>
                                            <option value="Diploma" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan === 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                            <option value="Sarjana" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan === 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                                            <option value="Tidak Sekolah" {{ $asesmen->asesmenKepUmum && $asesmen->asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan === 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="section-separator" id="discharge-planning">
                                    <h5 class="section-title">13. Discharge Planning</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Diagnosis medis</label>
                                        <input type="text" class="form-control" name="diagnosis_medis"
                                            placeholder="Diagnosis"
                                            value="{{ $asesmen->asesmenKepUmumRencanaPulang->diagnosis_medis ?? '' }}">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Usia lanjut</label>
                                        <select class="form-select" name="usia_lanjut">
                                            <option value="" {{ optional($asesmen->asesmenKepUmumRencanaPulang)->usia_lanjut == null ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="0" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->usia_lanjut == '0' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="1" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->usia_lanjut == '1' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Hambatan mobilisasi</label>
                                        <select class="form-select" name="hambatan_mobilisasi">
                                            <option value="" {{ optional($asesmen->asesmenKepUmumRencanaPulang)->hambatan_mobilisasi == null ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="0" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->hambatan_mobilisasi == '0' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="1" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->hambatan_mobilisasi == '1' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                        <select class="form-select" name="penggunaan_media_berkelanjutan">
                                            <option value="" {{ optional($asesmen->asesmenKepUmumRencanaPulang)->penggunaan_media_berkelanjutan == null ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="ya" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->membutuhkan_pelayanan_medis == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->membutuhkan_pelayanan_medis == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas harian</label>
                                        <select class="form-select" name="ketergantungan_aktivitas">
                                            <option value="" {{ optional($asesmen->asesmenKepUmumRencanaPulang)->ketergantungan_aktivitas == null ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus Setelah Pulang</label>
                                        <select class="form-select" name="keterampilan_khusus">
                                            <option value="" {{ optional($asesmen->asesmenKepUmumRencanaPulang)->memerlukan_keterampilan_khusus == null ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="ya" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->memerlukan_keterampilan_khusus == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->memerlukan_keterampilan_khusus == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah Sakit</label>
                                        <select class="form-select" name="alat_bantu">
                                            <option value="" {{ optional($asesmen->asesmenKepUmumRencanaPulang)->memerlukan_alat_bantu == null ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="ya" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->memerlukan_alat_bantu == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->memerlukan_alat_bantu == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah Pulang</label>
                                        <select class="form-select" name="nyeri_kronis">
                                            <option value="" {{ optional($asesmen->asesmenKepUmumRencanaPulang)->memiliki_nyeri_kronis == null ? 'selected' : '' }} disabled>--Pilih--</option>
                                            <option value="ya" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->memiliki_nyeri_kronis == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak" 
                                                {{ optional($asesmen->asesmenKepUmumRencanaPulang)->memiliki_nyeri_kronis == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Perkiraan lama hari dirawat</label>
                                            <input type="text" class="form-control" name="perkiraan_hari" 
                                                placeholder="hari"
                                                value="{{ optional($asesmen->asesmenKepUmumRencanaPulang)->perkiraan_lama_dirawat ?? '' }}">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label">Rencana Tanggal Pulang</label>
                                            <input type="date" class="form-control" name="tanggal_pulang"
                                                value="{{ optional($asesmen->asesmenKepUmumRencanaPulang)->rencana_pulang ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <label class="form-label">KESIMPULAN</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="alert alert-info">
                                                Pilih semua Planning
                                            </div>
                                            <div class="alert alert-warning">
                                                Mebutuhkan rencana pulang khusus
                                            </div>
                                            <div class="alert alert-success">
                                                Tidak mebutuhkan rencana pulang khusus
                                            </div>
                                        </div>
                                        <input type="hidden" id="kesimpulan" name="kesimpulan_planing" 
                                            value="{{ optional($asesmen->asesmenKepUmumRencanaPulang)->kesimpulan ?? 'Tidak mebutuhkan rencana pulang khusus' }}">
                                    </div>
                                </div>


                                <!-- 16. Diagnosa -->
                                <div class="section-separator" id="diagnosis">
                                    <h5 class="fw-semibold mb-4">9. Diagnosis</h5>

                                    @php
                                        // Parse existing diagnosis data from database
                                        $diagnosisBanding = !empty($asesmen->RmeAsesmenKepUmumDtl[0]->diagnosis_banding)
                                            ? json_decode($asesmen->RmeAsesmenKepUmumDtl[0]->diagnosis_banding, true)
                                            : [];
                                        $diagnosisKerja = !empty($asesmen->RmeAsesmenKepUmumDtl[0]->diagnosis_kerja)
                                            ? json_decode($asesmen->RmeAsesmenKepUmumDtl[0]->diagnosis_kerja, true)
                                            : [];
                                    @endphp

                                    <!-- Diagnosis Banding -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold mb-2">Diagnosis Banding</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari diagnosis banding, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan diagnosis banding yang tidak ditemukan.</small>

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="diagnosis-banding-input" class="form-control border-start-0 ps-0" placeholder="Cari dan tambah Diagnosis Banding">
                                            <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>

                                        <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                            <!-- Existing diagnosis will be loaded here -->
                                        </div>

                                        <input type="hidden" id="diagnosis_banding" name="diagnosis_banding" value="{{ json_encode($diagnosisBanding) }}">
                                    </div>

                                    <!-- Diagnosis Kerja -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan diagnosis kerja yang tidak ditemukan.</small>

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="diagnosis-kerja-input" class="form-control border-start-0 ps-0" placeholder="Cari dan tambah Diagnosis Kerja">
                                            <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>

                                        <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                            <!-- Existing diagnosis will be loaded here -->
                                        </div>

                                        <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja" value="{{ json_encode($diagnosisKerja) }}">
                                    </div>

                                </div>

                                <!-- 17. Implementasi -->
                                <div class="section-separator" style="margin-bottom: 2rem;">
                                    <h5 class="fw-semibold mb-4">10. Implementasi</h5>

                                    @php
                                    // Parse existing implementation data
                                    $implementationData = [
                                    'observasi' => !empty($asesmen->RmeAsesmenKepUmumDtl[0]->observasi)
                                    ? json_decode($asesmen->RmeAsesmenKepUmumDtl[0]->observasi, true) :
                                    [],
                                    'terapeutik' => !empty($asesmen->RmeAsesmenKepUmumDtl[0]->terapeutik)
                                    ? json_decode($asesmen->RmeAsesmenKepUmumDtl[0]->terapeutik, true) :
                                    [],
                                    'edukasi' => !empty($asesmen->RmeAsesmenKepUmumDtl[0]->edukasi)
                                    ? json_decode($asesmen->RmeAsesmenKepUmumDtl[0]->edukasi, true) : [],
                                    'kolaborasi' => !empty($asesmen->RmeAsesmenKepUmumDtl[0]->kolaborasi)
                                    ? json_decode($asesmen->RmeAsesmenKepUmumDtl[0]->kolaborasi, true) :
                                    [],
                                    'prognosis' => !empty($asesmen->RmeAsesmenKepUmumDtl[0]->prognosis)
                                    ? json_decode($asesmen->RmeAsesmenKepUmumDtl[0]->prognosis, true) : []
                                    ];
                                    @endphp

                                    <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan
                                            Pengobatan</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            rencana, apabila tidak ada,
                                            Pilih tanda tambah untuk menambah keterangan rencana yang tidak
                                            ditemukan.</small>
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
                                        <div id="observasi-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <input type="hidden" id="observasi" name="observasi"
                                            value="{{ json_encode($implementationData['observasi']) }}">
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
                                        <div id="terapeutik-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <input type="hidden" id="terapeutik" name="terapeutik"
                                            value="{{ json_encode($implementationData['terapeutik']) }}">
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
                                        <div id="edukasi-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <input type="hidden" id="edukasi" name="edukasi"
                                            value="{{ json_encode($implementationData['edukasi']) }}">
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
                                        <div id="kolaborasi-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <input type="hidden" id="kolaborasi" name="kolaborasi"
                                            value="{{ json_encode($implementationData['kolaborasi']) }}">
                                    </div>

                                    <!-- Prognosis Section -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Prognosis</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                            Prognosis,
                                            apabila tidak ada, Pilih tanda tambah untuk menambah keterangan Prognosis
                                            yang tidak ditemukan.</small>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="prognosis-input"
                                                class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Prognosis">
                                            <span class="input-group-text bg-white" id="add-prognosis">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="prognosis-list" class="list-group mb-2 mt-2 bg-light p-3 rounded">
                                            <!-- Items will be added here dynamically -->
                                        </div>
                                        <input type="hidden" id="prognosis" name="prognosis"
                                            value="{{ json_encode($implementationData['prognosis']) }}">
                                    </div>
                                </div>

                                <!-- 18. Evaluasi -->
                                <div class="section-separator" style="margin-bottom: 2rem;" id="evaluasi">
                                    <h5 class="fw-semibold mb-4">18. Evaluasi</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tambah Evaluasi Keperawatan</label>
                                        <textarea class="form-control" name="evaluasi_keperawatan" rows="4"
                                            placeholder="Evaluasi Keperawaran">{{ $asesmen->RmeAsesmenKepUmumDtl->evaluasi ?? '' }}</textarea>
                                    </div>
                                </div>


                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-gcs')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-skalanyeri')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-riwayatkeluarga')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-penyakitdiderita')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-jenisoperasi')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.edit-modal-create-obat')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.edit-modal-create-alergi')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-intervensirisikojatuh')
                                @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-skala-adl')
                                

                                {{-- Submit button placeholder (will be replaced with full form) --}}
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary">Update Asesmen</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection