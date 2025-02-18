@extends('layouts.administrator.master')


@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-kep-anak')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Asesmen Awal Keperawatan Anak</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN AWAL KEPERATAWAN --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.keperawatan.anak.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}">
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
                                            <label style="min-width: 200px;">Tiba Di Ruang Rawat Dengan Cara</label>
                                            <select class="form-select" name="cara_masuk">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="Tempat Tidur">Tempat Tidur</option>
                                                <option value="Jalan Kaki">Jalan Kaki</option>
                                                <option value="Kursi Roda">Kursi Roda</option>
                                                <option value="Brankar">Brankar</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kasus Trauma</label>
                                            <select class="form-select" name="kasus_trauma">
                                                <option selected disabled>--Pilih--</option>
                                                <option value="Kecelakaan Lalu Lintas">Kecelakaan Lalu Lintas</option>
                                                <option value="Kecelakaan Anak">Kecelakaan Anak</option>
                                                <option value="Kecelakaan Rumah Tangga">Kecelakaan Rumah Tangga</option>
                                                <option value="Non Trauma">Non Trauma</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="anamnesis">
                                        <h5 class="section-title">2. Anamnesis</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Anamnesis</label>
                                            <textarea class="form-control" name="anamnesis" rows="4"
                                                placeholder="keluhan utama dan riwayat penyakit sekarang"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="pemeriksaan-fisik">
                                        <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Sistole</label>
                                                    <input type="text" class="form-control" name="sistole"
                                                        placeholder="Sistole">
                                                </div>
                                                
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Diastole</label>
                                                    <input type="text" class="form-control" name="diastole"
                                                        placeholder="Diastole">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                            <input type="text" class="form-control" name="nadi"
                                                placeholder="frekuensi nadi per menit">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                            <input type="text" class="form-control" name="nafas"
                                                placeholder="frekuensi nafas per menit">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Suhu (C)</label>
                                            <input type="text" class="form-control" name="suhu"
                                                placeholder="suhu dalam celcius">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Tanpa Bantuan O2</label>
                                                    <input type="text" class="form-control" name="saturasi_o2_tanpa"
                                                        placeholder="Tanpa bantuan O2">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <label class="form-label">Dengan Bantuan O2</label>
                                                    <input type="text" class="form-control" name="saturasi_o2_dengan"
                                                        placeholder="Dengan bantuan O2">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesadaran</label>
                                            <select class="form-select" name="kesadaran">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Compos Mentis">Compos Mentis</option>
                                                <option value="Apatis">Apatis</option>
                                                <option value="Sopor">Sopor</option>
                                                <option value="Coma">Coma</option>
                                                <option value="Somnolen">Somnolen</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">AVPU</label>
                                            <select class="form-select" name="avpu">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="0">Sadar Baik/Alert</option>
                                                <option value="1">Berespon dengan kata-kata/Voice</option>
                                                <option value="2">Hanya berespon jika dirangsang nyeri/pain
                                                </option>
                                                <option value="3">Pasien tidak sadar/unresponsive</option>
                                                <option value="4">Gelisah atau bingung</option>
                                                <option value="5">Acute Confusional States</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Penglihatan</label>
                                            <select class="form-select" name="penglihatan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Rusak">Rusak</option>
                                                <option value="Alat Bantu">Alat Bantu</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pendengaran</label>
                                            <select class="form-select" name="pendengaran">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Baik">Baik</option>
                                                <option value="Rusak">Rusak</option>
                                                <option value="Alat Bantu">Alat Bantu</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bicara</label>
                                            <select class="form-select" name="bicara">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Gangguan">Gangguan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Refleks Menelan</label>
                                            <select class="form-select" name="refleks_menelan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Rusak">Rusak</option>
                                                <option value="Sulit">Sulit</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pola Tidur</label>
                                            <select class="form-select" name="pola_tidur">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Masalah">Masalah</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Luka</label>
                                            <select class="form-select" name="luka">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Gangguan">Gangguan</option>
                                                <option value="Tidak Ada Luka">Tidak Ada Luka</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Defekasi</label>
                                            <select class="form-select" name="defekasi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Tidak Ada">Tidak Ada</option>
                                                <option value="Ada, Normal">Ada, Normal</option>
                                                <option value="Konsitipasi">Konsitipasi</option>
                                                <option value="Inkontinesia Alvi">Inkontinesia Alvi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Miksi</label>
                                            <select class="form-select" name="miksi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Retensio">Retensio</option>
                                                <option value="Inkontinesia Urine">Inkontinesia Urine</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Gastrointestinal</label>
                                            <select class="form-select" name="gastrointestinal">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Normal">Normal</option>
                                                <option value="Nausea">Nausea</option>
                                                <option value="Muntah">Muntah</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lahir Umur Kehamilan</label>
                                            <input type="text" class="form-control" name="umur_kehamilan"
                                                placeholder="minggu/bulan">
                                        </div>

                                        <div class="mt-4">
                                            <h6>Pemeriksaan Lanjutan</h6>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">ASI Sampai Umur</label>
                                                <input type="text" class="form-control" name="Asi_Sampai_Umur"
                                                    placeholder="minggu/bulan">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Alasan Berhenti Menyusui</label>
                                                <input type="text" class="form-control"
                                                    name="alasan_berhenti_menyusui">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Masalah Neonatus</label>
                                                <input type="text" class="form-control" name="masalah_neonatus">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Kelainan Kongenital</label>
                                                <input type="text" class="form-control" name="kelainan_kongenital">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tengkurap</label>
                                                <input type="text" class="form-control" name="tengkurap">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Merangkak</label>
                                                <input type="text" class="form-control" name="merangkak">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Duduk</label>
                                                <input type="text" class="form-control" name="duduk">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Berdiri</label>
                                                <input type="text" class="form-control" name="berdiri">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h6>Antropometri</h6>
                                            <div class="form-group">
                                                <label style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                                <input type="number" id="tinggi_badan" name="tinggi_badan" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                                <input type="number" id="berat_badan" name="berat_badan" class="form-control">
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
                                                <input type="text" class="form-control" name="lingkar_kepala">
                                            </div>
                                        </div>

                                        <div class="alert alert-info mb-3 mt-4">
                                            <p class="mb-0 small">
                                                <i class="bi bi-info-circle me-2"></i>
                                                Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk
                                                menambah
                                                keterangan fisik yang ditemukan tidak normal.
                                                Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                            </p>
                                        </div>

                                        <div class="row g-3">
                                            @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                                <div class="col-md-6">
                                                    <div class="d-flex flex-column gap-3">
                                                        @foreach ($chunk as $item)
                                                            <div class="pemeriksaan-item">
                                                                <div class="d-flex align-items-center border-bottom pb-2">
                                                                    <div class="flex-grow-1">{{ $item->nama }}</div>
                                                                    <div class="form-check me-3">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="{{ strtolower($item->nama) }}-normal"
                                                                            checked>
                                                                        <label class="form-check-label"
                                                                            for="{{ strtolower($item->nama) }}-normal">Normal</label>
                                                                    </div>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary tambah-keterangan"
                                                                        type="button"
                                                                        data-target="{{ strtolower($item->nama) }}-keterangan">
                                                                        <i class="bi bi-plus"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="keterangan mt-2"
                                                                    id="{{ strtolower($item->nama) }}-keterangan"
                                                                    style="display:none;">
                                                                    <input type="text" class="form-control"
                                                                        name="{{ strtolower($item->nama) }}_keterangan"
                                                                        placeholder="Tambah keterangan jika tidak normal...">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-nyeri">
                                        <h5 class="section-title">4. Status nyeri</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis Skala NYERI</label>
                                            <select class="form-select" name="jenis_skala_nyeri" id="jenis_skala_nyeri">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="NRS">Numeric Rating Scale (NRS)</option>
                                                <option value="FLACC">Face, Legs, Activity, Cry, Consolability (FLACC)</option>
                                                <option value="CRIES">Crying, Requires, Increased, Expression, Sleepless (CRIES)</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                            <input type="text" class="form-control" id="nilai_skala_nyeri" name="nilai_skala_nyeri" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                            <div class="alert alert-success" id="kesimpulan_nyeri_alert">
                                                Pilih skala nyeri terlebih dahulu
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h6 class="mb-3">Karakteristik Nyeri</h6>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Lokasi</label>
                                                    <input type="text" class="form-control"
                                                        name="lokasi_nyeri">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Durasi</label>
                                                    <input type="text" class="form-control"
                                                        name="durasi_nyeri">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Jenis nyeri</label>
                                                    <select class="form-select" name="jenis_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach ($jenisnyeri as $jenis )
                                                            <option value="{{ $jenis->id }}">{{ $jenis->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Frekuensi</label>
                                                    <select class="form-select" name="frekuensi_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach($frekuensinyeri as $frekuensi)
                                                            <option value="{{ $frekuensi->id }}">{{ $frekuensi->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Menjalar?</label>
                                                    <select class="form-select" name="nyeri_menjalar">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach($menjalar as $menjalar)
                                                            <option value="{{ $menjalar->id }}">{{ $menjalar->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Kualitas</label>
                                                    <select class="form-select" name="kualitas_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach($kualitasnyeri as $kualitas)
                                                            <option value="{{ $kualitas->id }}">{{ $kualitas->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Faktor pemberat</label>
                                                    <select class="form-select" name="faktor_pemberat">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach($faktorpemberat as $pemberat)
                                                            <option value="{{ $pemberat->id }}">{{ $pemberat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Faktor peringan</label>
                                                    <select class="form-select" name="faktor_peringan">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach($faktorperingan as $peringan)
                                                            <option value="{{ $peringan->id }}">{{ $peringan->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">Efek Nyeri</label>
                                                    <select class="form-select" name="efek_nyeri">
                                                        <option value="" selected disabled>--Pilih--</option>
                                                        @foreach($efeknyeri as $efek)
                                                            <option value="{{ $efek->id }}">{{ $efek->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="riwayat-kesehatan">
                                        <h5 class="section-title">5. Riwayat Kesehatan</h5>
                                        
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Penyakit Yang Pernah Diderita</label>
                                            <div class="w-100">
                                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" data-bs-toggle="modal" data-bs-target="#penyakitModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedPenyakitList" class="d-flex flex-column gap-2">
                                                    <!-- Empty state message -->
                                                    <div id="emptyState" class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                        <i class="ti-info-circle mb-2"></i>
                                                        <p class="mb-0">Belum ada penyakit yang ditambahkan</p>
                                                    </div>
                                                </div>
                                                <!-- Hidden input to store the JSON data -->
                                                <input type="hidden" name="penyakit_diderita" id="penyakitDideritaInput">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Riwayat Kecelakaan</label>
                                            <select class="form-select" name="riwayat_kecelakaan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Kecelakaan Lalu Lintas">Kecelakaan Lalu Lintas</option>
                                                <option value="Kecelakaan Kerja">Kecelakaan Kerja</option>
                                                <option value="Kecelakaan Rumah Tangga">Kecelakaan Rumah Tangga</option>
                                                <option value="Kecelakaan Olahraga">Kecelakaan Olahraga</option>
                                                <option value="Kecelakaan Lainnya">Kecelakaan Lainnya</option>
                                                <option value="Tidak Ada"> Tidak Ada </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Riwayat Rawat Inap</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <select class="form-select flex-grow-1"
                                                    name="riwayat_rawat_inap">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="Ya">Ya</option>
                                                    <option value="Tidak">Tidak</option>
                                                </select>
                                                <input type="date" class="form-control"
                                                    name="tanggal_rawat_inap" style="width: 200px;">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Riwayat Operasi</label>
                                            <select class="form-select" name="riwayat_operasi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Jenis/Nama Operasi</label>
                                            <div class="w-100">
                                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" data-bs-toggle="modal" data-bs-target="#operasiModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedOperasiList" class="d-flex flex-column gap-2">
                                                    <!-- Empty state message -->
                                                    <div id="emptyStateOperasi" class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                        <i class="ti-info-circle mb-2"></i>
                                                        <p class="mb-0">Belum ada operasi yang ditambahkan.</p>
                                                    </div>
                                                </div>
                                                <!-- Hidden input to store the JSON data -->
                                                <input type="hidden" name="jenis_operasi" id="jenisOperasiInput">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label style="min-width: 200px;">Riwayat Kesehatan Keluarga</label>
                                            <div class="w-100">
                                                <button type="button" class="btn btn-sm btn-outline-secondary mb-3" data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                                    <i class="ti-plus"></i> Tambah
                                                </button>
                                                <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                                    <!-- Empty state message -->
                                                    <div id="emptyStateRiwayat" class="border border-dashed border-secondary rounded p-3 text-center text-muted">
                                                        <i class="ti-info-circle mb-2"></i>
                                                        <p class="mb-0">Belum ada riwayat kesehatan keluarga yang ditambahkan.</p>
                                                    </div>
                                                </div>
                                                <!-- Hidden input to store the JSON data -->
                                                <input type="hidden" name="riwayat_kesehatan_keluarga" id="riwayatKesehatanInput">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Konsumsi Obat-Obatan</label>
                                            <input type="text" class="form-control" name="konsumsi_obat">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tumbuh Kembang Dibanding
                                                Saudara-Saudaranya</label>
                                            <select class="form-select" name="tumbuh_kembang">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Sama">Sama</option>
                                                <option value="Cepat">Cepat</option>
                                                <option value="Lambat">Lambat</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">6. Alergi</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openAlergiModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>

                                        <div class="table-responsive">
                                            <table class="table" id="createAlergiTable">
                                                <thead>
                                                    <tr>
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
                                    </div>

                                    <div class="section-separator" id="risiko-jatuh">
                                        <h5 class="section-title">7. Risiko Jatuh</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan
                                                kondisi
                                                pasien:</label>
                                            <select class="form-select" id="risikoJatuhSkala">
                                                <option value="">--Pilih Skala--</option>
                                                <option value="skala_umum">Skala Umum</option>
                                                <option value="skala_morse">Skala Morse</option>
                                                <option value="skala_humpty">Skala Humpty-Dumpty / Pediatrik</option>
                                                <option value="skala_ontario">Skala Ontario Modified Stratify Sydney /
                                                    Lansia
                                                </option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <!-- Form Skala Umum -->
                                        <div id="skala_umumForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Umum</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien berusia < dari 2 tahun?</label>
                                                        <select class="form-select" onchange="updateConclusion('umum')">
                                                            <option value="">--Pilih--</option>
                                                            <option value="ya">Ya</option>
                                                            <option value="tidak">Tidak</option>
                                                        </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien dalam kondisi sebagai geriatri,
                                                    dizzines, vertigo,
                                                    gangguan keseimbangan, gangguan penglihatan, penggunaan obat sedasi,
                                                    status
                                                    kesadaran dan
                                                    atau kejiwaan, konsumsi alkohol?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien didiagnosis sebagai pasien dengan
                                                    penyakit
                                                    parkinson?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien sedang mendapatkan obat sedasi,
                                                    riwayat
                                                    tirah baring
                                                    lama, perubahan posisi yang akan meningkatkan risiko jatuh?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien saat ini sedang berada pada salah
                                                    satu
                                                    lokasi ini: rehab
                                                    medik, ruangan dengan penerangan kurang dan bertangga?</label>
                                                <select class="form-select" onchange="updateConclusion('umum')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="ya">Ya</option>
                                                    <option value="tidak">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span id="kesimpulanTextForm">Tidak
                                                        berisiko jatuh</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Memperbaiki bagian Form Skala Morse -->
                                        <div id="skala_morseForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Morse</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien pernah mengalami Jatuh?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="25">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki diagnosis skunder?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="15">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien membutuhkan bantuan ambulasi?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0">Meja/ kursi</option>
                                                    <option value="15">Kruk/ tongkat/ alat bantu berjalan</option>
                                                    <option value="30">Tidak ada/ bed rest/ bantuan perawat</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien terpasang infus?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="20">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0">Normal/ bed rest/ kursi roda</option>
                                                    <option value="10">Terganggu</option>
                                                    <option value="20">Lemah</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana status mental pasien?</label>
                                                <select class="form-select" onchange="updateConclusion('morse')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0">Beroroentasi pada kemampuannya</option>
                                                    <option value="15">Lupa akan keterbatasannya</option>
                                                </select>
                                            </div>
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">Tidak
                                                        berisiko jatuh</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Form Risiko Skala Humpty Dumpty -->
                                        <div id="skala_humptyForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik</h5>
                                            <div class="mb-3">
                                                <label class="form-label">Usia Anak?</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="4">Dibawah 3 tahun</option>
                                                    <option value="3">3-7 tahun</option>
                                                    <option value="2">7-13 tahun</option>
                                                    <option value="1">Diatas 13 tahun</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis kelamin</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="2">Laki-laki</option>
                                                    <option value="1">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Diagnosis</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="4">Diagnosis Neurologis</option>
                                                    <option value="3">Perubahan oksigennasi (diangnosis respiratorik,
                                                        dehidrasi, anemia,
                                                        syncope, pusing, dsb)</option>
                                                    <option value="2">Gangguan perilaku /psikiatri</option>
                                                    <option value="1">Diagnosis lainnya</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Gangguan Kognitif</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="3">Tidak menyadari keterbatasan dirinya</option>
                                                    <option value="2">Lupa akan adanya keterbatasan</option>
                                                    <option value="1">Orientasi baik terhadap dari sendiri</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Faktor Lingkungan</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="4">Riwayat jatuh /bayi diletakkan di tempat tidur
                                                        dewasa</option>
                                                    <option value="3">Pasien menggunakan alat bantu /bayi diletakkan
                                                        di
                                                        tempat tidur bayi /
                                                        perabot rumah</option>
                                                    <option value="2">Pasien diletakkan di tempat tidur</option>
                                                    <option value="1">Area di luar rumah sakit</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pembedahan/ sedasi/ Anestesi</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="3">Dalam 24 jam</option>
                                                    <option value="2">Dalam 48 jam</option>
                                                    <option value="1">> 48 jam atau tidak menjalani pembedahan
                                                        /sedasi
                                                        /anestesi</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Penggunaan Medika mentosa</label>
                                                <select class="form-select" onchange="updateConclusion('humpty')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="3">Penggunaan multiple: sedative, obat hipnosis,
                                                        barbiturate, fenotiazi,
                                                        antidepresan, pencahar, diuretik, narkose</option>
                                                    <option value="2">Penggunaan salah satu obat diatas</option>
                                                    <option value="1">Penggunaan medikasi lainnya/tidak ada mediksi
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">Tidak
                                                        berisiko jatuh</span>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Form Skala Humpty Dumpty -->
                                        <div id="skala_ontarioForm" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify
                                                Sydney/
                                                Lansia</h5>

                                            <!-- 1. Riwayat Jatuh -->
                                            <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                    jatuh?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki 2 kali atau apakah pasien
                                                    mengalami
                                                    jatuh dalam 2
                                                    bulan terakhir ini/ diagnosis multiple?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 2. Status Mental -->
                                            <h6 class="mb-3">2. Status Mental</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien bingung? (Tidak dapat membuat
                                                    keputusan, jaga jarak
                                                    tempatnya, gangguan daya ingat)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan
                                                    waktu, tempat atau
                                                    orang)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami agitasi? (keresahan,
                                                    gelisah, dan
                                                    cemas)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 3. Penglihatan -->
                                            <h6 class="mb-3">3. Penglihatan</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien memiliki kataraks?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami kelainya
                                                    penglihatan/buram?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mempunyai glukoma/ katarak/
                                                    degenerasi
                                                    makula?</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 4. Kebiasaan Berkemih -->
                                            <h6 class="mb-3">4. Kebiasaan Berkemih</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah terdapat perubahan perilaku berkemih?
                                                    (frekuensi, urgensi,
                                                    inkontinensia, noktura)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur) -->
                                            <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                                tempat tidur)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0">Ya</option>
                                                    <option value="1">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                    pengawasan</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                    total</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 6. Mobilitas Pasien -->
                                            <h6 class="mb-3">6. Mobilitas Pasien</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (dapat menggunakan alat bantu
                                                    jalan)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0">Ya</option>
                                                    <option value="1">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                                    fisik)</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Menggunakan kusi roda</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Imobilisasi</label>
                                                <select class="form-select" onchange="updateConclusion('ontario')">
                                                    <option value="">--Pilih--</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <div class="conclusion bg-success">
                                                <p class="conclusion-text">Kesimpulan: <span
                                                        id="kesimpulanTextForm">Tidak
                                                        berisiko jatuh</span>
                                                </p>
                                            </div>
                                        </div>


                                        <div class="mb-4">
                                            <h6 class="mb-3">Intervensi Risiko Jatuh</h6>
                                            <p class="mb-2">Tambah tindakan intervensi risiko jatuh:</p>

                                            <button type="button"
                                                class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3"
                                                data-bs-target="#tindakanKeperawatanRisikoJatuhModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="selectedTindakanList-risikojatuh" class="d-flex flex-column gap-2">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="decubitus">
                                        <h5 class="section-title">8. Risiko dekubitus</h5>
                                        <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>

                                        <div class="form-group mb-4">
                                            <select class="form-select" id="skalaRisikoDekubitus"
                                                name="jenis_skala_dekubitus">
                                                <option value="" selected disabled>Pilih skala Decubitus</option>
                                                <option value="norton">Skala Norton</option>
                                                <option value="braden">Skala Braden</option>
                                            </select>
                                        </div>

                                        <!-- Form Skala Norton -->
                                        <div id="formNorton" class="decubitus-form" style="display: none;">
                                            <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                            <div class="mb-4">
                                                <label class="form-label">Kondisi Fisik</label>
                                                <select class="form-select bg-light" name="kondisi_fisik">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="4">Baik</option>
                                                    <option value="3">Sedang</option>
                                                    <option value="2">Buruk</option>
                                                    <option value="1">Sangat Buruk</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Kondisi mental</label>
                                                <select class="form-select bg-light" name="kondisi_mental">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="4">Sadar</option>
                                                    <option value="3">Apatis</option>
                                                    <option value="2">Bingung</option>
                                                    <option value="1">Stupor</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Aktivitas</label>
                                                <select class="form-select bg-light" name="aktivitas">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="4">Aktif</option>
                                                    <option value="3">Jalan dengan bantuan</option>
                                                    <option value="2">Terbatas di kursi</option>
                                                    <option value="1">Terbatas di tempat tidur</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Mobilitas</label>
                                                <select class="form-select bg-light" name="mobilitas">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="4">Bebas bergerak</option>
                                                    <option value="3">Agak terbatas</option>
                                                    <option value="2">Sangat terbatas</option>
                                                    <option value="1">Tidak dapat bergerak</option>
                                                </select>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Inkontinensia</label>
                                                <select class="form-select bg-light" name="inkontinensia">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="4">Tidak ada</option>
                                                    <option value="3">Kadang-kadang</option>
                                                    <option value="2">Biasanya urin</option>
                                                    <option value="1">Urin dan feses</option>
                                                </select>
                                            </div>

                                            <div class="mt-4">
                                                <div class="d-flex gap-2">
                                                    <span class="fw-bold">Kesimpulan :</span>
                                                    <div id="kesimpulanNorton"
                                                        class="alert alert-success mb-0 flex-grow-1">
                                                        Risiko Rendah
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Skala Braden -->
                                        <div id="formBraden" class="decubitus-form" style="display: none;">
                                            <!-- Add Braden scale form fields -->
                                        </div>

                                    </div>

                                    <div class="section-separator" id="statusPsikologis">
                                        <h5 class="section-title">9. Status Psikologis</h5>

                                        <div class="mb-4">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <label>Kondisi Psikologis</label>
                                                <div class="dropdown-wrapper" style="position: relative;">
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        id="btnKondisiPsikologis">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                    <div class="dropdown-menu" id="dropdownKondisiPsikologis"
                                                        style="display: none; position: absolute; z-index: 1000;">
                                                        <div class="p-2">
                                                            <div class="fw-bold mb-2">STATUS PSIKOLOGIS PASIEN</div>
                                                            <div class="kondisi-options">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Tidak ada kelainan" id="kondisi1">
                                                                    <label class="form-check-label" for="kondisi1">Tidak
                                                                        ada
                                                                        kelainan</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Cemas" id="kondisi2">
                                                                    <label class="form-check-label"
                                                                        for="kondisi2">Cemas</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Takut" id="kondisi3">
                                                                    <label class="form-check-label"
                                                                        for="kondisi3">Takut</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Marah" id="kondisi4">
                                                                    <label class="form-check-label"
                                                                        for="kondisi4">Marah</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Sedih" id="kondisi5">
                                                                    <label class="form-check-label"
                                                                        for="kondisi5">Sedih</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Tenang" id="kondisi6">
                                                                    <label class="form-check-label"
                                                                        for="kondisi6">Tenang</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Tidak semangat" id="kondisi7">
                                                                    <label class="form-check-label" for="kondisi7">Tidak
                                                                        semangat</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Tertekan" id="kondisi8">
                                                                    <label class="form-check-label"
                                                                        for="kondisi8">Tertekan</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Depresi" id="kondisi9">
                                                                    <label class="form-check-label"
                                                                        for="kondisi9">Depresi</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="Sulit tidur" id="kondisi10">
                                                                    <label class="form-check-label" for="kondisi10">Sulit
                                                                        tidur</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="selectedKondisiPsikologis" class="d-flex gap-2 flex-wrap">
                                                    <!-- Selected items will be displayed here as badges -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="d-flex align-items-start gap-2 mb-2">
                                                <label>Gangguan Perilaku</label>
                                                <div class="dropdown-wrapper" style="position: relative;">
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        id="btnGangguanPerilaku">
                                                        <i class="ti-plus"></i>
                                                    </button>

                                                    <!-- Dropdown Menu -->
                                                    <div class="dropdown-menu p-2 shadow-sm" id="dropdownGangguanPerilaku"
                                                        style="display: none; position: absolute; z-index: 1000; min-width: 250px; background: white; border: 1px solid rgba(0,0,0,.15); border-radius: 4px;">
                                                        <div class="fw-bold mb-2">GANGGUAN PERILAKU</div>
                                                        <div class="perilaku-options">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Tidak Ada Gangguan" id="perilaku1">
                                                                <label class="form-check-label" for="perilaku1">Tidak Ada
                                                                    Gangguan</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Perilaku Kekerasan" id="perilaku2">
                                                                <label class="form-check-label" for="perilaku2">Perilaku
                                                                    Kekerasan</label>
                                                            </div>
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="Halusinasi" id="perilaku3">
                                                                <label class="form-check-label"
                                                                    for="perilaku3">Halusinasi</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="selectedGangguanPerilaku"
                                                    class="d-flex gap-2 flex-wrap align-items-center">
                                                    <!-- Selected items will be displayed here as badges -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Potensi menyakiti diri sendiri/orang lain</label>
                                            <select class="form-select" name="potensi_menyakiti">
                                                <option value="" selected disabled>pilih</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Anggota Keluarga Gangguan Jiwa</label>
                                            <select class="form-select" name="anggota_keluarga_gangguan_jiwa">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Lainnya</label>
                                            <input type="text" class="form-control" name="psikologis_lainnya">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status_spiritual">
                                        <h5 class="section-title">10. Status Spiritual</h5>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Keyakinan Agama</label>
                                            <select class="form-select" name="keyakinan_agama">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen">Kristen</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pandangan Pasien Terhadap Penyakit Nya</label>
                                            <select class="form-select" name="riwayat_kecelakaan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status_sosial_ekonomi">
                                        <h5 class="section-title">11. Status Sosial Ekonomi</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pekerjaan</label>
                                            <select class="form-select" name="pekerjaan_pasien">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Belum Bekerja">Belum Bekerja</option>
                                                <option value="Purnawaktu">Purnawaktu</option>
                                                <option value="Paruh Waktu">Paruh Waktu</option>
                                                <option value="Pensiunan">Pensiunan</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status Pernikahan</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <select class="form-select flex-grow-1" name="status_pernikahan">
                                                    <option value="" selected disabled>--Pilih--</option>
                                                    <option value="Menikah">Menikah</option>
                                                    <option value="Belum Menikah">Belum Menikah</option>
                                                    <option value="Cerai">Cerai</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tempat Tinggal</label>
                                            <select class="form-select" name="tempat_tinggal">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Rumah">Rumah</option>
                                                <option value="Asrama">Asrama</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Curiga Penganiayaan</label>
                                            <select class="form-select" name="curiga_penganiayaan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Ya">Ya</option>
                                                <option value="Tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Status Tinggal Dengan Keluarga</label>
                                            <select class="form-select" name="status_tinggal">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="Orang Tua">Orang Tua</option>
                                                <option value="Wali">Wali</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="section-separator" id="status_gizi">
                                        <h5 class="section-title">12. Status Gizi</h5>
                                        <div class="form-group mb-4">
                                            <select class="form-select" name="gizi_jenis" id="nutritionAssessment">
                                                <option value="">--Pilih--</option>
                                                <option value="1">Malnutrition Screening Tool (MST)</option>
                                                <option value="2">The Mini Nutritional Assessment (MNA)</option>
                                                <option value="3">Strong Kids (1 bln - 18 Tahun)</option>
                                                <option value="5">Tidak Dapat Dinilai</option>
                                            </select>
                                        </div>

                                        <!-- MST Form -->
                                        <div id="mst" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak
                                                    diinginkan dalam 6 bulan
                                                    terakhir?</label>
                                                <select class="form-select" name="gizi_mst_penurunan_bb">
                                                    <option value="">pilih</option>
                                                    <option value="0">Tidak ada penurunan Berat Badan (BB)</option>
                                                    <option value="2">Tidak yakin/ tidak tahu/ terasa baju lebi
                                                        longgar</option>
                                                    <option value="3">Ya ada penurunan BB</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB",
                                                    berapa
                                                    penurunan BB
                                                    tersebut?</label>
                                                <select class="form-select" name="gizi_mst_jumlah_penurunan_bb">
                                                    <option value="0">pilih</option>
                                                    <option value="1">1-5 kg</option>
                                                    <option value="2">6-10 kg</option>
                                                    <option value="3">11-15 kg</option>
                                                    <option value="4">>15 kg</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu
                                                    makan?</label>
                                                <select class="form-select" name="gizi_mst_nafsu_makan_berkurang">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer
                                                    (kemoterapi), Geriatri, GGk
                                                    (hemodialisis), Penurunan Imum</label>
                                                <select class="form-select" name="gizi_mst_diagnosis_khusus">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <!-- Nilai -->
                                            <div id="mstConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko malnutrisi
                                                </div>
                                                <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi</div>
                                                <input type="hidden" name="gizi_mst_kesimpulan"
                                                    id="gizi_mst_kesimpulan">
                                            </div>
                                        </div>

                                        <!-- MNA Form -->
                                        <div id="mna" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi The Mini Nutritional Assessment (MNA) /
                                                Lansia</h6>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Apakah pasien mengalami penurunan asupan makanan selama 3 bulan terakhir
                                                    karena hilang selera makan, masalah pencernaan, kesulitan mengunyah atau
                                                    menelan?
                                                </label>
                                                <select class="form-select" name="gizi_mna_penurunan_asupan_3_bulan">
                                                    <option value="">--Pilih--</option>
                                                    <option value="0">Mengalami penurunan asupan makanan yang parah
                                                    </option>
                                                    <option value="1">Mengalami penurunan asupan makanan sedang
                                                    </option>
                                                    <option value="2">Tidak mengalami penurunan asupan makanan
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Apakah pasien mengalami kehilangan Berat Badan (BB) selama 3 bulan
                                                    terakhir?
                                                </label>
                                                <select class="form-select" name="gizi_mna_kehilangan_bb_3_bulan">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="0">Kehilangan BB lebih dari 3 Kg</option>
                                                    <option value="1">Tidak tahu</option>
                                                    <option value="2">Kehilangan BB antara 1 s.d 3 Kg</option>
                                                    <option value="3">Tidak ada kehilangan BB</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Bagaimana mobilisasi atau pergerakan
                                                    pasien?</label>
                                                <select class="form-select" name="gizi_mna_mobilisasi">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="0">Hanya di tempat tidur atau kursi roda</option>
                                                    <option value="1">Dapat turun dari tempat tidur tapi tidak dapat
                                                        jalan-jalan</option>
                                                    <option value="2">Dapat jalan-jalan</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Apakah Pasien mengalami stres psikologi atau penyakit akut selama 3
                                                    bulan terakhir?
                                                </label>
                                                <select class="form-select" name="gizi_mna_stress_penyakit_akut">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="1">Tidak</option>
                                                    <option value="0">Ya</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami masalah
                                                    neuropsikologi?</label>
                                                <select class="form-select" name="gizi_mna_status_neuropsikologi">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="0">Demensia atau depresi berat</option>
                                                    <option value="1">Demensia ringan</option>
                                                    <option value="2">Tidak mengalami masalah neuropsikologi</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                                <input type="number" name="gizi_mna_berat_badan" class="form-control"
                                                    id="mnaWeight" min="1" step="0.1"
                                                    placeholder="Masukkan berat badan dalam Kg">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Berapa Tinggi Badan (TB) pasien? (cm)</label>
                                                <input type="number" name="gizi_mna_tinggi_badan"
                                                    class="form-control" id="mnaHeight" min="1"
                                                    step="0.1" placeholder="Masukkan tinggi badan dalam cm">
                                            </div>

                                            <!-- IMT -->
                                            <div class="mb-3">
                                                <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                                <div class="text-muted small mb-2">
                                                    <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                                </div>
                                                <input type="number" name="gizi_mna_imt"
                                                    class="form-control bg-light" id="mnaBMI" readonly
                                                    placeholder="IMT akan terhitung otomatis">
                                            </div>

                                            <!-- Kesimpulan -->
                                            <div id="mnaConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-info mb-3">
                                                    Silakan isi semua parameter di atas untuk melihat kesimpulan
                                                </div>
                                                <div class="alert alert-success" style="display: none;">
                                                    Kesimpulan: Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)
                                                </div>
                                                <div class="alert alert-warning" style="display: none;">
                                                    Kesimpulan: Total Skor ≤ 11 (Beresiko Malnutrisi)
                                                </div>
                                                <input type="hidden" name="gizi_mna_kesimpulan"
                                                    id="gizi_mna_kesimpulan">
                                            </div>
                                        </div>

                                        <!-- Strong Kids Form -->
                                        <div id="strong-kids" class="assessment-form" style="display: none;">
                                            <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah anak tampa kurus kehilangan lemak
                                                    subkutan, kehilangan massa otot, dan/ atau wajah cekung?</label>
                                                <select class="form-select" name="gizi_strong_status_kurus">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah terdapat penurunan BB selama satu bulan
                                                    terakhir (untuk semua usia)?
                                                    (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif
                                                    dari
                                                    orang tua pasien ATAu
                                                    tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1
                                                        tahun) selama 3 bulan terakhir)</label>
                                                        <select class="form-select" name="gizi_strong_penurunan_bb">
                                                            <option value="">pilih</option>
                                                            <option value="1">Ya</option>
                                                            <option value="0">Tidak</option>
                                                        </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Apakah salah satu dari hal berikut ini ada? <br>
                                                    - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari)
                                                    selama 1-3 hari terakhir
                                                    - Penurunan asupan makanan selama 1-3 hari terakhir
                                                    - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau
                                                    pemberian
                                                    maka selang)</label>
                                                <select class="form-select" name="gizi_strong_gangguan_pencernaan">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah terdapat penyakit atau keadaan yang
                                                    mengakibatkan pasien berisiko
                                                    mengalaman mainutrisi? <br>
                                                    <a href="#"><i>Lihat penyakit yang berisiko
                                                            malnutrisi</i></a></label>
                                                <select class="form-select" name="gizi_strong_penyakit_berisiko">
                                                    <option value="">pilih</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <!-- Nilai -->
                                            <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-success">Kesimpulan: 0 (Beresiko rendah)</div>
                                                <div class="alert alert-warning">Kesimpulan: 1-3 (Beresiko sedang)</div>
                                                <div class="alert alert-success">Kesimpulan: 4-5 (Beresiko Tinggi)</div>
                                                <input type="hidden" name="gizi_strong_kesimpulan"
                                                    id="gizi_strong_kesimpulan">
                                            </div>
                                        </div>

                                        <!-- Form NRS -->
                                        <div id="nrs" class="risk-form">
                                            <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify
                                                Sydney/
                                                Lansia</h5>

                                            <!-- 1. Riwayat Jatuh -->
                                            <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                    jatuh?</label>
                                                <select class="form-select" name="gizi_nrs_jatuh_saat_masuk_rs"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pasien memiliki jika tidak, apakah pasien
                                                    mengalami
                                                    jatuh dalam 2 bulan
                                                    terakhir ini? diagnosis skunder?</label>
                                                <select class="form-select" name="gizi_nrs_jatuh_2_bulan_terakhir"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="2">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 2. Status Mental -->
                                            <h6 class="mb-3">2. Status Mental</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien delirium? (Tidak dapat membuat
                                                    keputusan, pola pikir tidak
                                                    terorganisir, gangguan daya ingat)</label>
                                                <select class="form-select" name="gizi_nrs_status_delirium"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan
                                                    waktu, tempat atau
                                                    orang)</label>
                                                <select class="form-select" name="gizi_nrs_status_disorientasi"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengalami agitasi? (keresahan,
                                                    gelisah, dan
                                                    cemas)</label>
                                                <select class="form-select" name="gizi_nrs_status_agitasi"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 3. Penglihatan -->
                                            <h6 class="mb-3">3. Penglihatan</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien memakai kacamata?</label>
                                                <select class="form-select" name="gizi_nrs_menggunakan_kacamata"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien mengaluh adanya penglihatan
                                                    buram?</label>
                                                <select class="form-select" name="gizi_nrs_keluhan_penglihatan_buram"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah pasien menpunyai glaukoma/ katarak/
                                                    degenerasi makula?</label>
                                                <select class="form-select" name="gizi_nrs_degenerasi_makula"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 4. Kebiasaan Berkemih -->
                                            <h6 class="mb-3">4. Kebiasaan Berkemih</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Apakah terdapat perubahan perilaku berkemih?
                                                    (frekuensi, urgensi,
                                                    inkontinensia, nokturia)</label>
                                                <select class="form-select" name="gizi_nrs_perubahan_berkemih"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur) -->
                                            <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                                tempat tidur)</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                                <select class="form-select" name="gizi_nrs_transfer_mandiri"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Ya</option>
                                                    <option value="1">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                    pengawasan</label>
                                                <select class="form-select" name="gizi_nrs_transfer_bantuan_1_orang"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                                <select class="form-select" name="gizi_nrs_transfer_bantuan_2_orang"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                    total</label>
                                                <select class="form-select" name="gizi_nrs_transfer_bantuan_total"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>

                                            <!-- 6. Mobilitas Pasien -->
                                            <h6 class="mb-3">6. Mobilitas Pasien</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Mandiri (dapat menggunakan alat bantu
                                                    jalan)</label>
                                                <select class="form-select" name="gizi_nrs_mobilitas_mandiri"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="0">Ya</option>
                                                    <option value="1">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                                    fisik)</label>
                                                <select class="form-select" name="gizi_nrs_mobilitas_bantuan_1_orang"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Menggunakan kusi roda</label>
                                                <select class="form-select" name="gizi_nrs_mobilitas_kursi_roda"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Imobilisasi</label>
                                                <select class="form-select" name="gizi_nrs_mobilitas_imobilisasi"
                                                    onchange="updateConclusion('ontario')">
                                                    <option value="">pilih</option>
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak</option>
                                                </select>
                                            </div>
                                            <!-- Nilai -->
                                            <div id="nrsConclusion" class="risk-indicators mt-4">
                                                <div class="alert alert-success">Kesimpulan: Beresiko rendah</div>
                                                <div class="alert alert-warning">Kesimpulan: Beresiko sedang</div>
                                                <div class="alert alert-danger">Kesimpulan: Beresiko Tinggi</div>
                                                <input type="hidden" name="gizi_nrs_kesimpulan"
                                                    id="gizi_nrs_kesimpulan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="status-fungsional">
                                        <h5 class="section-title">13. Status Fungsional</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Pilih jenis Skala Pengkajian Aktivitas Harian (ADL) sesuai kondisi pasien</label>
                                            <select class="form-select" name="skala_fungsional" id="skala_fungsional">
                                                <option value="" selected disabled>Pilih Skala Fungsional</option>
                                                <option value="Pengkajian Aktivitas">Pengkajian Aktivitas Harian</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Nilai Skala ADL</label>
                                            <input type="text" class="form-control" id="adl_total" name="adl_total" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kesimpulan Fungsional</label>
                                            <div id="adl_kesimpulan" class="alert alert-info">
                                                Pilih skala aktivitas harian terlebih dahulu
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="kebutuhan-edukasi">
                                        <h5 class="section-title">14. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran
                                        </h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Gaya Bicara</label>
                                            <select class="form-select" name="gaya_bicara">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="normal">Normal</option>
                                                <option value="lambat">Lambat</option>
                                                <option value="cepat">Cepat</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Bahasa Sehari-Hari</label>
                                            <select class="form-select" name="bahasa_sehari_hari">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="indonesia">Bahasa Indonesia</option>
                                                <option value="daerah">Bahasa Daerah</option>
                                                <option value="asing">Bahasa Asing</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Perlu Penerjemah</label>
                                            <select class="form-select" name="perlu_penerjemah">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Hambatan Komunikasi</label>
                                            <select class="form-select" name="hambatan_komunikasi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="tidak_ada">Tidak Ada</option>
                                                <option value="pendengaran">Gangguan Pendengaran</option>
                                                <option value="bicara">Gangguan Bicara</option>
                                                <option value="bahasa">Perbedaan Bahasa</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Media Disukai</label>
                                            <select class="form-select" name="media_disukai">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="cetak">Media Cetak</option>
                                                <option value="video">Video</option>
                                                <option value="diskusi">Diskusi Langsung</option>
                                                <option value="demonstrasi">Demonstrasi</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tingkat Pendidikan</label>
                                            <select class="form-select" name="tingkat_pendidikan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="sd">SD</option>
                                                <option value="smp">SMP</option>
                                                <option value="sma">SMA</option>
                                                <option value="diploma">Diploma</option>
                                                <option value="sarjana">Sarjana</option>
                                                <option value="tidak_sekolah">Tidak Sekolah</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="discharge-planning">
                                        <h5 class="section-title">15. Discharge Planning</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Diagnosis medis</label>
                                            <input type="text" class="form-control" name="diagnosis_medis"
                                                placeholder="Diagnosis">
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Usia lanjut</label>
                                            <select class="form-select" name="usia_lanjut">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Hambatan mobilisasi</label>
                                            <select class="form-select" name="hambatan_mobilisasi">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                            <select class="form-select" name="penggunaan_media_berkelanjutan">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                                harian</label>
                                            <select class="form-select" name="ketergantungan_aktivitas">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus
                                                Setelah
                                                Pulang</label>
                                            <select class="form-select" name="keterampilan_khusus">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                                Sakit</label>
                                            <select class="form-select" name="alat_bantu">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                                Pulang</label>
                                            <select class="form-select" name="nyeri_kronis">
                                                <option value="" selected disabled>--Pilih--</option>
                                                <option value="ya">Ya</option>
                                                <option value="tidak">Tidak</option>
                                            </select>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label">Perkiraan lama hari dirawat</label>
                                                <input type="text" class="form-control" name="perkiraan_hari" placeholder="hari">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label class="form-label">Rencana Tanggal Pulang</label>
                                                <input type="date" class="form-control" name="tanggal_pulang">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <label class="form-label">KESIMPULAN</label>
                                            <div class="d-flex flex-column gap-2">
                                                <div class="alert alert-warning">
                                                    Mebutuhkan rencana pulang khusus
                                                </div>
                                                <div class="alert alert-success">
                                                    Tidak mebutuhkan rencana pulang khusus
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                         <h5 class="fw-semibold mb-4">15. Diagnosis</h5>

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
                                                <input type="text" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Banding">
                                                <span class="input-group-text bg-white">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div class="diagnosis-list bg-light p-3 rounded">
                                                <div class="diagnosis-item mb-2">
                                                    <span>1. Deficit Perawatan Diri (Self-Care Deficit)</span>
                                                </div>
                                                <div class="diagnosis-item">
                                                    <span>2. Risiko Infeksi (Risk for Infection)</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Diagnosis Kerja -->
                                        <div class="mb-4">
                                            <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                            <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari
                                                diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah
                                                keterangan
                                                diagnosis kerja yang tidak ditemukan.</small>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" class="form-control border-start-0 ps-0"
                                                    placeholder="Cari dan tambah Diagnosis Kerja">
                                                <span class="input-group-text bg-white">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <div class="diagnosis-list bg-light p-3 rounded">
                                                <div class="diagnosis-item mb-2">
                                                    <span>1. Deficit Perawatan Diri (Self-Care Deficit)</span>
                                                </div>
                                                <div class="diagnosis-item">
                                                    <span>2. Risiko Infeksi (Risk for Infection)</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="section-separator" id="implementasi">
                                        <h5 class="section-title">17. Implementasi</h5>

                                        <!-- Rencana Penatalaksanaan -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h6 class="mb-0">Rencana Penatalaksanaan dan Pengobatan</h6>
                                            </div>
                                            <div class="card-body">
                                                <!-- Observasi -->
                                                <div class="border-bottom pb-3 mb-3">
                                                    <h6 class="mb-2">Observasi</h6>
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" placeholder="Cari dan tambah observasi">
                                                        <button class="btn btn-outline-primary" type="button">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="list-group">
                                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span>1. Monitor pola nafas ( frekuensi, kedalaman, usaha nafas )</span>
                                                            <button class="btn btn-sm btn-link text-danger p-0">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Terapeutik -->
                                                <div class="border-bottom pb-3 mb-3">
                                                    <h6 class="mb-2">Terapeutik</h6>
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" placeholder="Cari dan tambah terapeutik">
                                                        <button class="btn btn-outline-primary" type="button">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="list-group">
                                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span>1. Berikan minum hangat</span>
                                                            <button class="btn btn-sm btn-link text-danger p-0">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span>2. Posisikan semi fowler atau fowler</span>
                                                            <button class="btn btn-sm btn-link text-danger p-0">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edukasi -->
                                                <div class="border-bottom pb-3 mb-3">
                                                    <h6 class="mb-2">Edukasi</h6>
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" placeholder="Cari dan tambah edukasi">
                                                        <button class="btn btn-outline-primary" type="button">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="list-group">
                                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span>1. Anjuran asupan cairan 2000 ml/hari</span>
                                                            <button class="btn btn-sm btn-link text-danger p-0">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Kolaborasi -->
                                                <div class="mb-0">
                                                    <h6 class="mb-2">Kolaborasi</h6>
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" placeholder="Cari dan tambah kolaborasi">
                                                        <button class="btn btn-outline-primary" type="button">
                                                            <i class="bi bi-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="list-group">
                                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span>1. Kolaborasi pemberian bronkodilator</span>
                                                            <button class="btn btn-sm btn-link text-danger p-0">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Prognosis -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="mb-0">Prognosis</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" placeholder="Cari dan tambah prognosis">
                                                    <button class="btn btn-outline-primary" type="button">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                                <div class="list-group">
                                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                                        <span>1. Memberikan antibiotik intravena sesuai jadwal</span>
                                                        <button class="btn btn-sm btn-link text-danger p-0">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="evaluasi">
                                        <h5 class="section-title">18. Evaluasi</h5>

                                        <div class="mb-4">
                                            <label class="form-label">Tambah Evaluasi Keperawatan</label>
                                            <textarea class="form-control" rows="4" name="evaluasi_keperawatan"
                                                placeholder="Tambah evaluasi keperawatan..."></textarea>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-create-alergi')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-skalanyeri')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-penyakitdiderita')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-jenisoperasi')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-riwayatkeluarga')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-intervensirisikojatuh')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-skala-adl')

@endsection


