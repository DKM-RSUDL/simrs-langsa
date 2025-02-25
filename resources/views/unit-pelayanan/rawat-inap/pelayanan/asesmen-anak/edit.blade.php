@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.edit-include')

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
                                    <h4 class="header-asesmen">Edit Asesmen Awal Keperawatan Anak</h4>
                                    <p>
                                        Isikan Asesmen awal dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN KEPERATAWAN ANAK --}}
                        <form method="POST"
                            action="{{ route('rawat-inap.asesmen.keperawatan.anak.update', [
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
                                            <option disabled>--Pilih--</option>
                                            <option value="Mandiri"
                                                {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Mandiri' ? 'selected' : '' }}>
                                                Mandiri</option>
                                            <option value="Tempat Tidur"
                                                {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Tempat Tidur' ? 'selected' : '' }}>
                                                Tempat Tidur</option>
                                            <option value="Jalan Kaki"
                                                {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Jalan Kaki' ? 'selected' : '' }}>
                                                Jalan Kaki</option>
                                            <option value="Kursi Roda"
                                                {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Kursi Roda' ? 'selected' : '' }}>
                                                Kursi Roda</option>
                                            <option value="Brankar"
                                                {{ $asesmen->rmeAsesmenKepAnak->cara_masuk == 'Brankar' ? 'selected' : '' }}>
                                                Brankar</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kasus Trauma</label>
                                        <select class="form-select" name="kasus_trauma">
                                            <option disabled>--Pilih--</option>
                                            <option value="Kecelakaan Lalu Lintas"
                                                {{ $asesmen->rmeAsesmenKepAnak->kasus_trauma == 'Kecelakaan Lalu Lintas' ? 'selected' : '' }}>
                                                Kecelakaan Lalu Lintas</option>
                                            <option value="Kecelakaan Anak"
                                                {{ $asesmen->rmeAsesmenKepAnak->kasus_trauma == 'Kecelakaan Anak' ? 'selected' : '' }}>
                                                Kecelakaan Anak</option>
                                            <option value="Kecelakaan Rumah Tangga"
                                                {{ $asesmen->rmeAsesmenKepAnak->kasus_trauma == 'Kecelakaan Rumah Tangga' ? 'selected' : '' }}>
                                                Kecelakaan Rumah Tangga</option>
                                            <option value="Non Trauma"
                                                {{ $asesmen->rmeAsesmenKepAnak->kasus_trauma == 'Non Trauma' ? 'selected' : '' }}>
                                                Non Trauma</option>
                                        </select>
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

                                {{-- 3. Pemeriksaan Fisik --}}
                                <div class="section-separator" id="pemeriksaan-fisik">
                                    <h5 class="section-title">3. Pemeriksaan fisik</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tek. Darah (mmHg)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Sistole</label>
                                                <input type="number" class="form-control" name="sistole"
                                                    value="{{ $asesmen->rmeAsesmenKepAnakFisik->sistole }}"
                                                    placeholder="Sistole">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Diastole</label>
                                                <input type="number" class="form-control" name="diastole"
                                                    value="{{ $asesmen->rmeAsesmenKepAnakFisik->diastole }}"
                                                    placeholder="Diastole">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nadi (Per Menit)</label>
                                        <input type="number" class="form-control" name="nadi"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->nadi }}"
                                            placeholder="frekuensi nadi per menit">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nafas (Per Menit)</label>
                                        <input type="number" class="form-control" name="nafas"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->nafas }}"
                                            placeholder="frekuensi nafas per menit">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Suhu (C)</label>
                                        <input type="number" class="form-control" name="suhu"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->suhu }}"
                                            placeholder="suhu dalam celcius">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Saturasi Oksigen (%)</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Tanpa Bantuan O2</label>
                                                <input type="number" class="form-control" name="saturasi_o2_tanpa"
                                                    value="{{ $asesmen->rmeAsesmenKepAnakFisik->spo2_tanpa_bantuan }}"
                                                    placeholder="Tanpa bantuan O2">
                                            </div>
                                            <div class="flex-grow-1">
                                                <label class="form-label">Dengan Bantuan O2</label>
                                                <input type="number" class="form-control" name="saturasi_o2_dengan"
                                                    value="{{ $asesmen->rmeAsesmenKepAnakFisik->spo2_dengan_bantuan }}"
                                                    placeholder="Dengan bantuan O2">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option disabled>--Pilih--</option>
                                            <option value="Compos Mentis"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Compos Mentis' ? 'selected' : '' }}>
                                                Compos Mentis</option>
                                            <option value="Apatis"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Apatis' ? 'selected' : '' }}>
                                                Apatis</option>
                                            <option value="Sopor"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Sopor' ? 'selected' : '' }}>
                                                Sopor</option>
                                            <option value="Coma"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Coma' ? 'selected' : '' }}>
                                                Coma</option>
                                            <option value="Somnolen"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->kesadaran == 'Somnolen' ? 'selected' : '' }}>
                                                Somnolen</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">AVPU</label>
                                        <select class="form-select" name="avpu">
                                            <option disabled>--Pilih--</option>
                                            <option value="0"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->avpu == '0' ? 'selected' : '' }}>Sadar
                                                Baik/Alert</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->avpu == '1' ? 'selected' : '' }}>
                                                Berespon dengan kata-kata/Voice</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->avpu == '2' ? 'selected' : '' }}>Hanya
                                                berespon jika dirangsang nyeri/pain</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->avpu == '3' ? 'selected' : '' }}>
                                                Pasien tidak sadar/unresponsive</option>
                                            <option value="4"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->avpu == '4' ? 'selected' : '' }}>
                                                Gelisah atau bingung</option>
                                            <option value="5"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->avpu == '5' ? 'selected' : '' }}>Acute
                                                Confusional States</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Penglihatan</label>
                                        <select class="form-select" name="penglihatan">
                                            <option disabled>--Pilih--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->penglihatan == '1' ? 'selected' : '' }}>
                                                Baik</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->penglihatan == '2' ? 'selected' : '' }}>
                                                Rusak</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->penglihatan == '3' ? 'selected' : '' }}>
                                                Alat Bantu</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pendengaran</label>
                                        <select class="form-select" name="pendengaran">
                                            <option disabled>--Pilih--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->pendengaran == '1' ? 'selected' : '' }}>
                                                Baik</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->pendengaran == '2' ? 'selected' : '' }}>
                                                Rusak</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->pendengaran == '3' ? 'selected' : '' }}>
                                                Alat Bantu</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Bicara</label>
                                        <select class="form-select" name="bicara">
                                            <option disabled>--Pilih--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->bicara == '1' ? 'selected' : '' }}>
                                                Normal</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->bicara == '2' ? 'selected' : '' }}>
                                                Gangguan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Refleks Menelan</label>
                                        <select class="form-select" name="refleks_menelan">
                                            <option disabled>--Pilih--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->refleksi_menelan == '1' ? 'selected' : '' }}>
                                                Normal</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->refleksi_menelan == '3' ? 'selected' : '' }}>
                                                Rusak</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->refleksi_menelan == '2' ? 'selected' : '' }}>
                                                Sulit</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pola Tidur</label>
                                        <select class="form-select" name="pola_tidur">
                                            <option disabled>--Pilih--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->pola_tidur == '1' ? 'selected' : '' }}>
                                                Normal</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->pola_tidur == '2' ? 'selected' : '' }}>
                                                Masalah</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Luka</label>
                                        <select class="form-select" name="luka">
                                            <option disabled>--Pilih--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->luka == '1' ? 'selected' : '' }}>
                                                Normal</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->luka == '2' ? 'selected' : '' }}>
                                                Gangguan</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->luka == '3' ? 'selected' : '' }}>Tidak
                                                Ada Luka</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Defekasi</label>
                                        <select class="form-select" name="defekasi">
                                            <option disabled>--Pilih--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->defekasi == '1' ? 'selected' : '' }}>
                                                Tidak Ada</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->defekasi == '2' ? 'selected' : '' }}>
                                                Ada, Normal</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->defekasi == '3' ? 'selected' : '' }}>
                                                Konsitipasi</option>
                                            <option value="4"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->defekasi == '4' ? 'selected' : '' }}>
                                                Inkontinesia Alvi</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Miksi</label>
                                        <select class="form-select" name="miksi">
                                            <option disabled>--Pilih--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->miksi == '1' ? 'selected' : '' }}>
                                                Normal</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->miksi == '2' ? 'selected' : '' }}>
                                                Retensio</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->miksi == '3' ? 'selected' : '' }}>
                                                Inkontinesia Urine</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gastrointestinal</label>
                                        <select class="form-select" name="gastrointestinal">
                                            <option disabled>--Pilih--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->gastrointestinal == '1' ? 'selected' : '' }}>
                                                Normal</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->gastrointestinal == '2' ? 'selected' : '' }}>
                                                Nausea</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenKepAnakFisik->gastrointestinal == '3' ? 'selected' : '' }}>
                                                Muntah</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Lahir Umur Kehamilan</label>
                                        <input type="text" class="form-control" name="umur_kehamilan"
                                            value="{{ $asesmen->rmeAsesmenKepAnakFisik->lahir_umur_kehamilan }}"
                                            placeholder="minggu/bulan">
                                    </div>

                                    <div class="mt-4">
                                        <h6>Pemeriksaan Lanjutan</h6>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">ASI Sampai Umur</label>
                                            <input type="text" class="form-control" name="Asi_Sampai_Umur"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->asi_Sampai_Umur }}"
                                                placeholder="minggu/bulan">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Alasan Berhenti Menyusui</label>
                                            <input type="text" class="form-control" name="alasan_berhenti_menyusui"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->alasan_berhenti_menyusui }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Masalah Neonatus</label>
                                            <input type="text" class="form-control" name="masalah_neonatus"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->masalah_neonatus }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Kelainan Kongenital</label>
                                            <input type="text" class="form-control" name="kelainan_kongenital"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->kelainan_kongenital }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tengkurap</label>
                                            <input type="text" class="form-control" name="tengkurap"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->tengkurap }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Merangkak</label>
                                            <input type="text" class="form-control" name="merangkak"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->merangkak }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Duduk</label>
                                            <input type="text" class="form-control" name="duduk"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->duduk }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Berdiri</label>
                                            <input type="text" class="form-control" name="berdiri"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->berdiri }}">
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6>Antropometri</h6>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tinggi Badan (Cm)</label>
                                            <input type="number" id="tinggi_badan" name="tinggi_badan"
                                                class="form-control"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->tinggi_badan }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Berat Badan (Kg)</label>
                                            <input type="number" id="berat_badan" name="berat_badan"
                                                class="form-control"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->berat_badan }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">IMT</label>
                                            <input type="text" class="form-control bg-light" id="imt"
                                                name="imt" readonly
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->imt }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">LPT</label>
                                            <input type="text" class="form-control bg-light" id="lpt"
                                                name="lpt" readonly
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->lpt }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Lingkar Kepala (Cm)</label>
                                            <input type="text" class="form-control" name="lingkar_kepala"
                                                value="{{ $asesmen->rmeAsesmenKepAnakFisik->lingkar_kepala }}">
                                        </div>
                                    </div>

                                    <div class="alert alert-info mb-3 mt-4">
                                        <p class="mb-0 small">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Centang normal jika fisik yang dinilai normal, pilih tanda tambah untuk menambah
                                            keterangan fisik yang ditemukan tidak normal.
                                            Jika tidak dipilih salah satunya, maka pemeriksaan tidak dilakukan.
                                        </p>
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
                                            <option disabled>--Pilih--</option>
                                            <option value="NRS"
                                                {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->jenis_skala_nyeri == 1 ? 'selected' : '' }}>
                                                Numeric Rating Scale (NRS)</option>
                                            <option value="FLACC"
                                                {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->jenis_skala_nyeri == 2 ? 'selected' : '' }}>
                                                Face, Legs, Activity, Cry, Consolability (FLACC)</option>
                                            <option value="CRIES"
                                                {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->jenis_skala_nyeri == 3 ? 'selected' : '' }}>
                                                Crying, Requires, Increased, Expression, Sleepless (CRIES)</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nilai Skala Nyeri</label>
                                        <input type="text" class="form-control" id="nilai_skala_nyeri"
                                            name="nilai_skala_nyeri" readonly
                                            value="{{ $asesmen->rmeAsesmenKepAnakStatusNyeri->nilai_nyeri }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesimpulan Nyeri</label>
                                        <input type="hidden" class="form-control" id="kesimpulan_nyeri"
                                            name="kesimpulan_nyeri"
                                            value="{{ $asesmen->rmeAsesmenKepAnakStatusNyeri->kesimpulan_nyeri }}">
                                        <div class="alert alert-success" id="kesimpulan_nyeri_alert">
                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->kesimpulan_nyeri ?? 'Pilih skala nyeri terlebih dahulu' }}
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-3">Karakteristik Nyeri</h6>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Lokasi</label>
                                                <input type="text" class="form-control" name="lokasi_nyeri"
                                                    value="{{ $asesmen->rmeAsesmenKepAnakStatusNyeri->lokasi }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Durasi</label>
                                                <input type="text" class="form-control" name="durasi_nyeri"
                                                    value="{{ $asesmen->rmeAsesmenKepAnakStatusNyeri->durasi }}">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <div class="col-md-6">
                                                <label class="form-label">Jenis nyeri</label>
                                                <select class="form-select" name="jenis_nyeri">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($jenisnyeri as $jenis)
                                                        <option value="{{ $jenis->id }}"
                                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->jenis_nyeri == $jenis->id ? 'selected' : '' }}>
                                                            {{ $jenis->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Frekuensi</label>
                                                <select class="form-select" name="frekuensi_nyeri">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($frekuensinyeri as $frekuensi)
                                                        <option value="{{ $frekuensi->id }}"
                                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->frekuensi == $frekuensi->id ? 'selected' : '' }}>
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
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($menjalar as $menjalarItem)
                                                        <option value="{{ $menjalarItem->id }}"
                                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->menjalar == $menjalarItem->id ? 'selected' : '' }}>
                                                            {{ $menjalarItem->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Kualitas</label>
                                                <select class="form-select" name="kualitas_nyeri">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($kualitasnyeri as $kualitas)
                                                        <option value="{{ $kualitas->id }}"
                                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->kualitas == $kualitas->id ? 'selected' : '' }}>
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
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($faktorpemberat as $pemberat)
                                                        <option value="{{ $pemberat->id }}"
                                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->faktor_pemberat == $pemberat->id ? 'selected' : '' }}>
                                                            {{ $pemberat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Faktor peringan</label>
                                                <select class="form-select" name="faktor_peringan">
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($faktorperingan as $peringan)
                                                        <option value="{{ $peringan->id }}"
                                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->faktor_peringan == $peringan->id ? 'selected' : '' }}>
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
                                                    <option disabled>--Pilih--</option>
                                                    @foreach ($efeknyeri as $efek)
                                                        <option value="{{ $efek->id }}"
                                                            {{ $asesmen->rmeAsesmenKepAnakStatusNyeri->efek_nyeri == $efek->id ? 'selected' : '' }}>
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
                                                data-bs-toggle="modal" data-bs-target="#editPenyakitModal">
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
                                            <input type="hidden" name="penyakit_diderita" id="penyakitDideritaInput"
                                                value='{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->penyakit_yang_diderita ?? '[]' }}'>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Kecelakaan</label>
                                        <select class="form-select" name="riwayat_kecelakaan">
                                            <option disabled>--Pilih--</option>
                                            @php $riwayatKecelakaan = $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_kecelakaan; @endphp
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
                                                <option disabled>--Pilih--</option>
                                                <option value="Ya"
                                                    {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_rawat_inap == 'Ya' ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="Tidak"
                                                    {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_rawat_inap == 'Tidak' ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                            <input type="date" class="form-control" name="tanggal_rawat_inap"
                                                value="{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tanggal_riwayat_rawat_inap }}"
                                                style="width: 200px;">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Operasi</label>
                                        <select class="form-select" name="riwayat_operasi">
                                            <option disabled>--Pilih--</option>
                                            <option value="Ya"
                                                {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_operasi == 'Ya' ? 'selected' : '' }}>
                                                Ya</option>
                                            <option value="Tidak"
                                                {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_operasi == 'Tidak' ? 'selected' : '' }}>
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
                                                value='{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->nama_operasi ?? '[]' }}'>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Riwayat Kesehatan Keluarga</label>
                                        <div class="w-100">
                                            <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                                data-bs-toggle="modal" data-bs-target="#riwayatKeluargaModal">
                                                <i class="ti-plus"></i> Tambah
                                            </button>
                                            <div id="selectedRiwayatList" class="d-flex flex-column gap-2">
                                                @if ($asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_penyakit_keluarga)
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
                                                value="{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->riwayat_penyakit_keluarga }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Konsumsi Obat-Obatan</label>
                                        <input type="text" class="form-control" name="konsumsi_obat"
                                            value="{{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->konsumsi_obat }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tumbuh Kembang Dibanding
                                            Saudara-Saudaranya</label>
                                        <select class="form-select" name="tumbuh_kembang">
                                            <option disabled>--Pilih--</option>
                                            <option value="Sama"
                                                {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tumbuh_kembang == 'Sama' ? 'selected' : '' }}>
                                                Sama</option>
                                            <option value="Cepat"
                                                {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tumbuh_kembang == 'Cepat' ? 'selected' : '' }}>
                                                Cepat</option>
                                            <option value="Lambat"
                                                {{ $asesmen->rmeAsesmenKepAnakRiwayatKesehatan->tumbuh_kembang == 'Lambat' ? 'selected' : '' }}>
                                                Lambat</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- 6. Alergi sectio --}}
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

                                {{-- 7. Risiko Jatuh --}}
                                <div class="section-separator" id="risiko_jatuh">
                                    <h5 class="section-title">7. Risiko Jatuh</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Pilih jenis penilaian risiko jatuh sesuai dengan kondisi
                                            pasien:</label>
                                        <select class="form-select" id="risikoJatuhSkala" name="resiko_jatuh_jenis"
                                            onchange="showForm(this.value)">
                                            <option value="">--Pilih Skala--</option>
                                            <option value="1"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 1 ? 'selected' : '' }}>
                                                Skala Umum</option>
                                            <option value="2"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 2 ? 'selected' : '' }}>
                                                Skala Morse</option>
                                            <option value="3"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 3 ? 'selected' : '' }}>
                                                Skala Humpty-Dumpty / Pediatrik</option>
                                            <option value="4"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 4 ? 'selected' : '' }}>
                                                Skala Ontario Modified Stratify Sydney / Lansia</option>
                                            <option value="5"
                                                {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_jenis == 5 ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                    </div>

                                    <!-- Form Skala Umum 1 -->
                                    <div id="skala_umumForm" class="risk-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Umum</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien berusia < dari 2 tahun?</label>
                                                    <select class="form-select" name="risiko_jatuh_umum_usia"
                                                        onchange="updateConclusion('umum')">
                                                        <option value="">pilih</option>
                                                        <option value="1"
                                                            {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_usia == 1 ? 'selected' : '' }}>
                                                            Ya</option>
                                                        <option value="0"
                                                            {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_usia == 0 ? 'selected' : '' }}>
                                                            Tidak</option>
                                                    </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien dalam kondisi sebagai geriatri,
                                                dizzines, vertigo, gangguan keseimbangan, gangguan penglihatan, penggunaan
                                                obat sedasi, status kesadaran dan atau kejiwaan, konsumsi alkohol?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_kondisi_khusus">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_kondisi_khusus == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_kondisi_khusus == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien didiagnosis sebagai pasien dengan
                                                penyakit parkinson?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_diagnosis_parkinson">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien sedang mendapatkan obat sedasi, riwayat
                                                tirah baring lama, perubahan posisi yang akan meningkatkan risiko
                                                jatuh?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_pengobatan_berisiko">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien saat ini sedang berada pada salah satu
                                                lokasi ini: rehab medik, ruangan dengan penerangan kurang dan
                                                bertangga?</label>
                                            <select class="form-select" onchange="updateConclusion('umum')"
                                                name="risiko_jatuh_umum_lokasi_berisiko">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div
                                            class="conclusion {{ strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_umum ?? '', 'Berisiko') !== false ? 'bg-danger' : 'bg-success' }}">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_umum ?? 'Tidak berisiko jatuh' }}</span>
                                            </p>
                                            <input type="hidden" name="risiko_jatuh_umum_kesimpulan"
                                                id="risiko_jatuh_umum_kesimpulan"
                                                value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_umum ?? 'Tidak berisiko jatuh' }}">
                                        </div>
                                    </div>

                                    <!-- Form Skala Morse 2 -->
                                    <div id="skala_morseForm" class="risk-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Morse</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien pernah mengalami Jatuh?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_riwayat_jatuh"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="25"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien memiliki diagnosis skunder?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_diagnosis_sekunder"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="15"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien membutuhkan bantuan ambulasi?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_bantuan_ambulasi"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="30"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi == 0 ? 'selected' : '' }}>
                                                    Meja/ kursi</option>
                                                <option value="15"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi == 1 ? 'selected' : '' }}>
                                                    Kruk/ tongkat/ alat bantu berjalan</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi == 2 ? 'selected' : '' }}>
                                                    Tidak ada/ bed rest/ bantuan perawat</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien terpasang infus?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_terpasang_infus"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="20"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_terpasang_infus == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana cara berjalan pasien?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_cara_berjalan"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan == 0 ? 'selected' : '' }}>
                                                    Normal/ bed rest/ kursi roda</option>
                                                <option value="20"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan == 1 ? 'selected' : '' }}>
                                                    Terganggu</option>
                                                <option value="10"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_cara_berjalan == 2 ? 'selected' : '' }}>
                                                    Lemah</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana status mental pasien?</label>
                                            <select class="form-select" name="risiko_jatuh_morse_status_mental"
                                                onchange="updateConclusion('morse')">
                                                <option value="">pilih</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental == 0 ? 'selected' : '' }}>
                                                    Beroroentasi pada kemampuannya</option>
                                                <option value="15"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_morse_status_mental == 1 ? 'selected' : '' }}>
                                                    Lupa akan keterbatasannya</option>
                                            </select>
                                        </div>
                                        <div
                                            class="conclusion {{ strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_morse ?? '', 'Tinggi') !== false ? 'bg-danger' : (strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_morse ?? '', 'Sedang') !== false ? 'bg-warning' : 'bg-success') }}">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_morse ?? 'Risiko Rendah' }}</span>
                                            </p>
                                            <input type="hidden" name="risiko_jatuh_morse_kesimpulan"
                                                id="risiko_jatuh_morse_kesimpulan"
                                                value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_morse ?? 'Risiko Rendah' }}">
                                        </div>
                                    </div>

                                    <!-- Form Risiko Skala Humpty Dumpty 3 -->
                                    <div id="skala_humptyForm" class="risk-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko Skala Humpty Dumpty/ Pediatrik</h5>
                                        <div class="mb-3">
                                            <label class="form-label">Usia Anak?</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_usia_anak"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="4"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 0 ? 'selected' : '' }}>
                                                    Dibawah 3 tahun</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 1 ? 'selected' : '' }}>
                                                    3-7 tahun</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 2 ? 'selected' : '' }}>
                                                    7-13 tahun</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_usia_anak == 3 ? 'selected' : '' }}>
                                                    Diatas 13 tahun</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis kelamin</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_jenis_kelamin"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin == 0 ? 'selected' : '' }}>
                                                    Laki-laki</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin == 1 ? 'selected' : '' }}>
                                                    Perempuan</option>
                                            </select>
                                        </div>
                                        <!-- Lanjutkan dengan field Humpty Dumpty lainnya -->
                                        <div class="mb-3">
                                            <label class="form-label">Diagnosis</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_diagnosis"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="4"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 0 ? 'selected' : '' }}>
                                                    Diagnosis Neurologis</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 1 ? 'selected' : '' }}>
                                                    Perubahan oksigennasi (diangnosis respiratorik, dehidrasi, anemia,
                                                    syncope, pusing, dsb)</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 2 ? 'selected' : '' }}>
                                                    Gangguan perilaku /psikiatri</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_diagnosis == 3 ? 'selected' : '' }}>
                                                    Diagnosis lainnya</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Gangguan Kognitif</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_gangguan_kognitif"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif == 0 ? 'selected' : '' }}>
                                                    Tidak menyadari keterbatasan dirinya</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif == 1 ? 'selected' : '' }}>
                                                    Lupa akan adanya keterbatasan</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif == 2 ? 'selected' : '' }}>
                                                    Orientasi baik terhadap dari sendiri</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Faktor Lingkungan</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_faktor_lingkungan"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="4"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 0 ? 'selected' : '' }}>
                                                    Riwayat jatuh /bayi diletakkan di tempat tidur dewasa</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 1 ? 'selected' : '' }}>
                                                    Pasien menggunakan alat bantu /bayi diletakkan di tempat tidur bayi /
                                                    perabot rumah</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 2 ? 'selected' : '' }}>
                                                    Pasien diletakkan di tempat tidur</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan == 3 ? 'selected' : '' }}>
                                                    Area di luar rumah sakit</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Pembedahan/ sedasi/ Anestesi</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_pembedahan"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan == 0 ? 'selected' : '' }}>
                                                    Dalam 24 jam</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan == 1 ? 'selected' : '' }}>
                                                    Dalam 48 jam</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_pembedahan == 2 ? 'selected' : '' }}>
                                                    > 48 jam atau tidak menjalani pembedahan/sedasi/anestesi</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Penggunaan Medika mentosa</label>
                                            <select class="form-select" name="risiko_jatuh_pediatrik_penggunaan_mentosa"
                                                onchange="updateConclusion('humpty')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa == 0 ? 'selected' : '' }}>
                                                    Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi,
                                                    antidepresan, pencahar, diuretik, narkose</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa == 1 ? 'selected' : '' }}>
                                                    Penggunaan salah satu obat diatas</option>
                                                <option value="1"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa == 2 ? 'selected' : '' }}>
                                                    Penggunaan medikasi lainnya/tidak ada mediksi</option>
                                            </select>
                                        </div>

                                        <div
                                            class="conclusion {{ strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_pediatrik ?? '', 'Tinggi') !== false ? 'bg-danger' : 'bg-success' }}">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_pediatrik ?? 'Risiko Rendah' }}</span>
                                            </p>
                                            <input type="hidden" name="risiko_jatuh_pediatrik_kesimpulan"
                                                id="risiko_jatuh_pediatrik_kesimpulan"
                                                value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_pediatrik ?? 'Risiko Rendah' }}">
                                        </div>
                                    </div>

                                    <div id="skala_ontarioForm" class="risk-form" style="display: none;">
                                        <h5 class="mb-4">Penilaian Risiko Jatuh Skala Ontario Modified Stratify Sydney/
                                            Lansia</h5>

                                        <!-- 1. Riwayat Jatuh -->
                                        <h6 class="mb-3">1. Riwayat Jatuh</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien datang kerumah sakit karena
                                                jatuh?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_jatuh_saat_masuk_rs"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="6"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien memiliki 2 kali atau apakah pasien mengalami
                                                jatuh dalam 2 bulan terakhir ini/ diagnosis multiple?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_riwayat_jatuh_2_bulan"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="6"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 2. Status Mental -->
                                        <h6 class="mb-3">2. Status Mental</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien bingung? (Tidak dapat membuat
                                                keputusan, jaga jarak tempatnya, gangguan daya ingat)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_status_bingung"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="14"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_bingung) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_bingung == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_bingung) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_bingung == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien disorientasi? (tidak menyadarkan waktu,
                                                tempat atau orang)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_status_disorientasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="14"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_disorientasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_disorientasi == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_disorientasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_disorientasi == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami agitasi? (keresahan, gelisah,
                                                dan cemas)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_status_agitasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="14"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_agitasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_agitasi == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_agitasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_status_agitasi == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 3. Penglihatan -->
                                        <h6 class="mb-3">3. Penglihatan</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien memakai Kacamata? </label>
                                            <select class="form-select" name="risiko_jatuh_lansia_kacamata"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kacamata == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kacamata == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami kelainya
                                                penglihatan/buram?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_kelainan_penglihatan"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mempunyai glukoma/ katarak/ degenerasi
                                                makula?</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_glukoma"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_glukoma == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_glukoma == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 4. Kebiasaan Berkemih -->
                                        <h6 class="mb-3">4. Kebiasaan Berkemih</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat perubahan perilaku berkemih?
                                                (frekuensi, urgensi, inkontinensia, noktura)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_perubahan_berkemih"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke tempat tidur) -->
                                        <h6 class="mb-3">5. Transfer (dari tempat tidur ke kursi dan kembali lagi ke
                                            tempat tidur)</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Mandiri (boleh menolak saat bantu jatuh)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_transfer_mandiri"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan sedikit bantuan (1 orang) / dalam
                                                pengawasan</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_transfer_bantuan_sedikit"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Memerlukan bantuan yang nyata (2 orang)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_transfer_bantuan_nyata"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tidak dapat duduk dengan seimbang, perlu bantuan
                                                total</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_transfer_bantuan_total"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <!-- 6. Mobilitas Pasien -->
                                        <h6 class="mb-3">6. Mobilitas Pasien</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Mandiri (dapat menggunakan alat bantu jalan)</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_mobilitas_mandiri"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">berjalan dengan bantuan 1 orang (verbal/
                                                fisik)</label>
                                            <select class="form-select"
                                                name="risiko_jatuh_lansia_mobilitas_bantuan_1_orang"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="1"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang == 1 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang == 0 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Menggunakan kusi roda</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_mobilitas_kursi_roda"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="2"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Imobilisasi</label>
                                            <select class="form-select" name="risiko_jatuh_lansia_mobilitas_imobilisasi"
                                                onchange="updateConclusion('ontario')">
                                                <option value="">pilih</option>
                                                <option value="3"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi == 0 ? 'selected' : '' }}>
                                                    Ya</option>
                                                <option value="0"
                                                    {{ isset($asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi) && $asesmen->rmeAsesmenKepAnakRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi == 1 ? 'selected' : '' }}>
                                                    Tidak</option>
                                            </select>
                                        </div>

                                        <div
                                            class="conclusion {{ strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_lansia ?? '', 'Tinggi') !== false ? 'bg-danger' : (strpos($asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_lansia ?? '', 'Sedang') !== false ? 'bg-warning' : 'bg-success') }}">
                                            <p class="conclusion-text">Kesimpulan: <span
                                                    id="kesimpulanTextForm">{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_lansia ?? 'Risiko Rendah' }}</span>
                                            </p>
                                            <input type="hidden" name="risiko_jatuh_lansia_kesimpulan"
                                                id="risiko_jatuh_lansia_kesimpulan"
                                                value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->kesimpulan_skala_lansia ?? 'Risiko Rendah' }}">
                                        </div>
                                    </div>

                                    <!-- Bagian Intervensi Risiko Jatuh -->
                                    <div class="mb-4">
                                        <h6 class="mb-3">Intervensi Risiko Jatuh</h6>
                                        <p class="mb-2">Tambah tindakan intervensi risiko jatuh:</p>

                                        <button type="button" class="btn btn-sm btn-outline-secondary btn-tindakan-keperawatan mb-3" data-bs-toggle="modal" data-bs-target="#tindakanKeperawatanRisikoJatuhModal">
                                            <i class="ti-plus"></i> Tambah
                                        </button>
                                        <div id="selectedTindakanList-risikojatuh" class="d-flex flex-column gap-2">
                                            @if($asesmen->rmeAsesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh)
                                                @php
                                                    $intervensiList = json_decode($asesmen->rmeAsesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh, true);
                                                @endphp
                                                @foreach($intervensiList as $index => $item)
                                                    <div class="p-2 bg-light rounded d-flex justify-content-between align-items-center">
                                                        <span>{{ $item }}</span>
                                                        <button type="button" class="btn btn-sm btn-danger delete-tindakan" data-index="{{ $index }}" data-target="risikojatuh">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <input type="hidden" name="intervensi_risiko_jatuh_json" id="intervensi_risiko_jatuh_json" value='{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->intervensi_risiko_jatuh ?? "[]" }}'>
                                    </div>
                                    <!-- Hidden input for lainnya -->
                                    <input type="hidden" id="skala_lainnya" name="risiko_jatuh_lainnya" value="{{ $asesmen->rmeAsesmenKepAnakRisikoJatuh->resiko_jatuh_lainnya ?? '' }}">
                                    </div>
                                </div>

                                <!-- 8. Risiko dekubitus -->
                                <div class="section-separator" id="decubitus">
                                    <h5 class="section-title">8. Risiko dekubitus</h5>
                                    <p class="text-muted">Pilih jenis Skala Risiko Dekubitus sesuai kondisi pasien</p>

                                    <div class="form-group mb-4">
                                        <select class="form-select" id="skalaRisikoDekubitus" name="jenis_skala_dekubitus">
                                            <option value="" disabled>--Pilih Skala--</option>
                                            <option value="norton" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->jenis_skala == 1 ? 'selected' : '' }}>Skala Norton</option>
                                            <option value="braden" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->jenis_skala == 2 ? 'selected' : '' }}>Skala Braden</option>
                                        </select>
                                    </div>

                                    <!-- Form Skala Norton -->
                                    <div id="formNorton" class="decubitus-form" style="display: none;">
                                        <h6 class="mb-4">Penilaian Risiko DECUBITUS Skala Norton</h6>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi Fisik</label>
                                            <select class="form-select bg-light" name="kondisi_fisik">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik == '4' ? 'selected' : '' }}>Baik</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik == '3' ? 'selected' : '' }}>Sedang</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik == '2' ? 'selected' : '' }}>Buruk</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_fisik == '1' ? 'selected' : '' }}>Sangat Buruk</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kondisi mental</label>
                                            <select class="form-select bg-light" name="kondisi_mental">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental == '4' ? 'selected' : '' }}>Sadar</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental == '3' ? 'selected' : '' }}>Apatis</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental == '2' ? 'selected' : '' }}>Bingung</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_kondisi_mental == '1' ? 'selected' : '' }}>Stupor</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Aktivitas</label>
                                            <select class="form-select bg-light" name="norton_aktivitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas == '4' ? 'selected' : '' }}>Aktif</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas == '3' ? 'selected' : '' }}>Jalan dengan bantuan</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas == '2' ? 'selected' : '' }}>Terbatas di kursi</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_aktivitas == '1' ? 'selected' : '' }}>Terbatas di tempat tidur</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Mobilitas</label>
                                            <select class="form-select bg-light" name="norton_mobilitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas == '4' ? 'selected' : '' }}>Bebas bergerak</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas == '3' ? 'selected' : '' }}>Agak terbatas</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas == '2' ? 'selected' : '' }}>Sangat terbatas</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_mobilitas == '1' ? 'selected' : '' }}>Tidak dapat bergerak</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Inkontinensia</label>
                                            <select class="form-select bg-light" name="inkontinensia">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia == '4' ? 'selected' : '' }}>Tidak ada</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia == '3' ? 'selected' : '' }}>Kadang-kadang</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia == '2' ? 'selected' : '' }}>Biasanya urin</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->norton_inkontenesia == '1' ? 'selected' : '' }}>Urin dan feses</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div id="kesimpulanNorton" 
                                                    class="alert {{ strpos($asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos($asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                                    {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? 'Risiko Rendah' }}
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
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi == '1' ? 'selected' : '' }}>Keterbatasan Penuh</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi == '2' ? 'selected' : '' }}>Sangat Terbatas</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi == '3' ? 'selected' : '' }}>Keterbatasan Ringan</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_persepsi == '4' ? 'selected' : '' }}>Tidak Ada Gangguan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Kelembapan</label>
                                            <select class="form-select bg-light" name="kelembapan">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan == '1' ? 'selected' : '' }}>Selalu Lembap</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan == '2' ? 'selected' : '' }}>Umumnya Lembap</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan == '3' ? 'selected' : '' }}>Kadang-Kadang Lembap</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_kelembapan == '4' ? 'selected' : '' }}>Jarang Lembap</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Aktivitas</label>
                                            <select class="form-select bg-light" name="braden_aktivitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas == '1' ? 'selected' : '' }}>Total di Tempat Tidur</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas == '2' ? 'selected' : '' }}>Dapat Duduk</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas == '3' ? 'selected' : '' }}>Berjalan Kadang-kadang</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_aktivitas == '4' ? 'selected' : '' }}>Dapat Berjalan-jalan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Mobilitas</label>
                                            <select class="form-select bg-light" name="braden_mobilitas">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas == '1' ? 'selected' : '' }}>Tidak Mampu Bergerak Sama sekali</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas == '2' ? 'selected' : '' }}>Sangat Terbatas</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas == '3' ? 'selected' : '' }}>Tidak Ada Masalah</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_mobilitas == '4' ? 'selected' : '' }}>Tanpa Keterbatasan</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Nutrisi</label>
                                            <select class="form-select bg-light" name="nutrisi">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi == '1' ? 'selected' : '' }}>Sangat Buruk</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi == '2' ? 'selected' : '' }}>Kurang Menucukup</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi == '3' ? 'selected' : '' }}>Mencukupi</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_nutrisi == '4' ? 'selected' : '' }}>Sangat Baik</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label">Pergesekan dan Pergeseran</label>
                                            <select class="form-select bg-light" name="pergesekan">
                                                <option value="" disabled>--Pilih--</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_pergesekan == '1' ? 'selected' : '' }}>Bermasalah</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_pergesekan == '2' ? 'selected' : '' }}>Potensial Bermasalah</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->braden_pergesekan == '3' ? 'selected' : '' }}>Keterbatasan Ringan</option>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <div class="d-flex gap-2">
                                                <span class="fw-bold">Kesimpulan :</span>
                                                <div id="kesimpulanBraden" 
                                                    class="alert {{ strpos($asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '', 'Tinggi') !== false ? 'alert-danger' : (strpos($asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? '', 'Sedang') !== false ? 'alert-warning' : 'alert-success') }} mb-0 flex-grow-1">
                                                    {{ $asesmen->rmeAsesmenKepAnakResikoDekubitus->decubitus_kesimpulan ?? 'Kesimpulan Skala Braden' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 9. Status Psikologis -->
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
                                                                $kondisiPsikologis = json_decode($asesmen->rmeAsesmenKepAnakStatusPsikologis->kondisi_psikologis ?? '[]', true);
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
                                        <input type="hidden" name="kondisi_psikologis_json" id="kondisi_psikologis_json" value='{{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->kondisi_psikologis ?? "[]" }}'>
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
                                                            $gangguanPerilaku = json_decode($asesmen->rmeAsesmenKepAnakStatusPsikologis->gangguan_perilaku ?? '[]', true);
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
                                        <input type="hidden" name="gangguan_perilaku_json" id="gangguan_perilaku_json" value='{{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->gangguan_perilaku ?? "[]" }}'>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Potensi menyakiti diri sendiri/orang lain</label>
                                        <select class="form-select" name="potensi_menyakiti">
                                            <option value="" disabled>pilih</option>
                                            <option value="0" {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->potensi_menyakiti == 0 ? 'selected' : '' }}>Ya</option>
                                            <option value="1" {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->potensi_menyakiti == 1 ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Anggota Keluarga Gangguan Jiwa</label>
                                        <select class="form-select" name="anggota_keluarga_gangguan_jiwa">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="0" {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->keluarga_gangguan_jiwa == 0 ? 'selected' : '' }}>Ya</option>
                                            <option value="1" {{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->keluarga_gangguan_jiwa == 1 ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Lainnya</label>
                                        <input type="text" class="form-control" name="psikologis_lainnya" value="{{ $asesmen->rmeAsesmenKepAnakStatusPsikologis->lainnya }}">
                                    </div>
                                </div>

                                <!-- 10. Statsu Spiritual -->
                                <div class="section-separator" id="status_spiritual">
                                    <h5 class="section-title">10. Status Spiritual</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Keyakinan Agama</label>
                                        <select class="form-select" name="keyakinan_agama">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="Islam" {{ $asesmen->rmeAsesmenKepAnak->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Protestan" {{ $asesmen->rmeAsesmenKepAnak->agama == 'Protestan' ? 'selected' : '' }}>Protestan</option>
                                            <option value="Khatolik" {{ $asesmen->rmeAsesmenKepAnak->agama == 'Khatolik' ? 'selected' : '' }}>Khatolik</option>
                                            <option value="Budha" {{ $asesmen->rmeAsesmenKepAnak->agama == 'Budha' ? 'selected' : '' }}>Budha</option>
                                            <option value="Hindu" {{ $asesmen->rmeAsesmenKepAnak->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Konghucu" {{ $asesmen->rmeAsesmenKepAnak->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                            <option value="Lainnya" {{ $asesmen->rmeAsesmenKepAnak->agama == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pandangan Pasien Terhadap Penyakit Nya</label>
                                        <select class="form-select" name="pandangan_terhadap_penyakit">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="Takdir" {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit == 'Takdir' ? 'selected' : '' }}>Takdir</option>
                                            <option value="Hukuman" {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit == 'Hukuman' ? 'selected' : '' }}>Hukuman</option>
                                            <option value="Tidak Ada" {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            <option value="Lainnya" {{ $asesmen->rmeAsesmenKepAnak->pandangan_terhadap_penyakit == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 11. Statsu Ekonomi -->
                                <div class="section-separator" id="status_sosial_ekonomi">
                                    <h5 class="section-title">11. Status Sosial Ekonomi</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Pekerjaan</label>
                                        <select class="form-select" name="pekerjaan_pasien">
                                            <option value="" {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="Belum Bekerja" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan == 'Belum Bekerja' ? 'selected' : '' }}>Belum Bekerja</option>
                                            <option value="Purnawaktu" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan == 'Purnawaktu' ? 'selected' : '' }}>Purnawaktu</option>
                                            <option value="Paruh Waktu" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan == 'Paruh Waktu' ? 'selected' : '' }}>Paruh Waktu</option>
                                            <option value="Pensiunan" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_pekerjaan == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status Pernikahan</label>
                                        <div class="d-flex gap-3" style="width: 100%;">
                                            <select class="form-select flex-grow-1" name="status_pernikahan">
                                                <option value="" {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_status_pernikahan ? 'selected' : '' }}>--Pilih--</option>
                                                <option value="Menikah" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_status_pernikahan == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                                                <option value="Belum Menikah" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_status_pernikahan == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                                <option value="Cerai" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_status_pernikahan == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tempat Tinggal</label>
                                        <select class="form-select" name="tempat_tinggal">
                                            <option value="" {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tempat_tinggal ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="Rumah" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tempat_tinggal == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                                            <option value="Asrama" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tempat_tinggal == 'Asrama' ? 'selected' : '' }}>Asrama</option>
                                            <option value="Lainnya" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tempat_tinggal == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Curiga Penganiayaan</label>
                                        <select class="form-select" name="curiga_penganiayaan">
                                            <option value="" {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_curiga_penganiayaan ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="Ya" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_curiga_penganiayaan == 'Ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="Tidak" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_curiga_penganiayaan == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Status Tinggal Dengan Keluarga</label>
                                        <select class="form-select" name="status_tinggal">
                                            <option value="" {{ !$asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga ? 'selected' : '' }}>--Pilih--</option>
                                            <option value="Orang Tua" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                            <option value="Wali" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga == 'Wali' ? 'selected' : '' }}>Wali</option>
                                            <option value="Lainnya" {{ $asesmen->rmeAsesmenKepAnakSosialEkonomi?->sosial_ekonomi_tinggal_dengan_keluarga == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 12. Status Gizi -->
                                <div class="section-separator" id="status_gizi">
                                    <h5 class="section-title">12. Status Gizi</h5>
                                    <div class="form-group mb-4">
                                        <select class="form-select" name="gizi_jenis" id="nutritionAssessment">
                                            <option value="">--Pilih--</option>
                                            <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_jenis == 1 ? 'selected' : '' }}>Malnutrition Screening Tool (MST)</option>
                                            <option value="2" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_jenis == 2 ? 'selected' : '' }}>The Mini Nutritional Assessment (MNA)</option>
                                            <option value="3" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_jenis == 3 ? 'selected' : '' }}>Strong Kids (1 bln - 18 Tahun)</option>
                                            <option value="5" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_jenis == 5 ? 'selected' : '' }}>Tidak Dapat Dinilai</option>
                                        </select>
                                    </div>

                                    <!-- MST Form -->
                                    <div id="mst" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi Malnutrition Screening Tool (MST)</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?</label>
                                            <select class="form-select" name="gizi_mst_penurunan_bb">
                                                <option value="">pilih</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_penurunan_bb == '0' ? 'selected' : '' }}>Tidak ada penurunan Berat Badan (BB)</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_penurunan_bb == '2' ? 'selected' : '' }}>Tidak yakin/ tidak tahu/ terasa baju lebi longgar</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_penurunan_bb == '3' ? 'selected' : '' }}>Ya ada penurunan BB</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jika jawaban di atas "Ya ada penurunan BB", berapa penurunan BB tersebut?</label>
                                            <select class="form-select" name="gizi_mst_jumlah_penurunan_bb">
                                                <option value="0">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_jumlah_penurunan_bb == '1' ? 'selected' : '' }}>1-5 kg</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_jumlah_penurunan_bb == '2' ? 'selected' : '' }}>6-10 kg</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_jumlah_penurunan_bb == '3' ? 'selected' : '' }}>11-15 kg</option>
                                                <option value="4" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_jumlah_penurunan_bb == '4' ? 'selected' : '' }}>>15 kg</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah asupan makan berkurang karena tidak nafsu makan?</label>
                                            <select class="form-select" name="gizi_mst_nafsu_makan_berkurang">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_nafsu_makan_berkurang == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_nafsu_makan_berkurang == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pasien didiagnosa khusus seperti: DM, Cancer (kemoterapi), Geriatri, GGk (hemodialisis), Penurunan Imun</label>
                                            <select class="form-select" name="gizi_mst_diagnosis_khusus">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_diagnosis_khusus == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_diagnosis_khusus == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="mstConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success">Kesimpulan: 0-1 tidak berisiko malnutrisi</div>
                                            <div class="alert alert-warning">Kesimpulan: ≥ 2 berisiko malnutrisi</div>
                                            <input type="hidden" name="gizi_mst_kesimpulan" id="gizi_mst_kesimpulan" value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mst_kesimpulan }}">
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
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_penurunan_asupan_3_bulan == '0' ? 'selected' : '' }}>Mengalami penurunan asupan makanan yang parah</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_penurunan_asupan_3_bulan == '1' ? 'selected' : '' }}>Mengalami penurunan asupan makanan sedang</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_penurunan_asupan_3_bulan == '2' ? 'selected' : '' }}>Tidak mengalami penurunan asupan makanan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah pasien mengalami kehilangan Berat Badan (BB) selama 3 bulan terakhir?
                                            </label>
                                            <select class="form-select" name="gizi_mna_kehilangan_bb_3_bulan">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kehilangan_bb_3_bulan == '0' ? 'selected' : '' }}>Kehilangan BB lebih dari 3 Kg</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kehilangan_bb_3_bulan == '1' ? 'selected' : '' }}>Tidak tahu</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kehilangan_bb_3_bulan == '2' ? 'selected' : '' }}>Kehilangan BB antara 1 s.d 3 Kg</option>
                                                <option value="3" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kehilangan_bb_3_bulan == '3' ? 'selected' : '' }}>Tidak ada kehilangan BB</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Bagaimana mobilisasi atau pergerakan pasien?</label>
                                            <select class="form-select" name="gizi_mna_mobilisasi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_mobilisasi == '0' ? 'selected' : '' }}>Hanya di tempat tidur atau kursi roda</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_mobilisasi == '1' ? 'selected' : '' }}>Dapat turun dari tempat tidur tapi tidak dapat jalan-jalan</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_mobilisasi == '2' ? 'selected' : '' }}>Dapat jalan-jalan</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Apakah Pasien mengalami stres psikologi atau penyakit akut selama 3 bulan terakhir?
                                            </label>
                                            <select class="form-select" name="gizi_mna_stress_penyakit_akut">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_stress_penyakit_akut == '0' ? 'selected' : '' }}>Ya</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_stress_penyakit_akut == '1' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah pasien mengalami masalah neuropsikologi?</label>
                                            <select class="form-select" name="gizi_mna_status_neuropsikologi">
                                                <option value="">-- Pilih --</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_status_neuropsikologi == '0' ? 'selected' : '' }}>Demensia atau depresi berat</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_status_neuropsikologi == '1' ? 'selected' : '' }}>Demensia ringan</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_status_neuropsikologi == '2' ? 'selected' : '' }}>Tidak mengalami masalah neuropsikologi</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Berat Badan (BB) pasien? (Kg)</label>
                                            <input type="number" name="gizi_mna_berat_badan" class="form-control" id="mnaWeight" min="1" step="0.1" placeholder="Masukkan berat badan dalam Kg" value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_berat_badan }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Berapa Tinggi Badan (TB) pasien? (cm)</label>
                                            <input type="number" name="gizi_mna_tinggi_badan" class="form-control" id="mnaHeight" min="1" step="0.1" placeholder="Masukkan tinggi badan dalam cm" value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_tinggi_badan }}">
                                        </div>

                                        <!-- IMT -->
                                        <div class="mb-3">
                                            <label class="form-label">Indeks Massa Tubuh (IMT)</label>
                                            <div class="text-muted small mb-2">
                                                <i>Rumus IMT = BB (Kg) / (TB (m))²</i>
                                            </div>
                                            <input type="number" name="gizi_mna_imt" class="form-control bg-light" id="mnaBMI" readonly placeholder="IMT akan terhitung otomatis" value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_imt }}">
                                        </div>

                                        <!-- Kesimpulan -->
                                        <div id="mnaConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-info mb-3" style="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kesimpulan ? 'display: none;' : '' }}">
                                                Silakan isi semua parameter di atas untuk melihat kesimpulan
                                            </div>
                                            <div class="alert alert-success" style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kesimpulan ?? '', 'Tidak Beresiko') !== false ? '' : 'display: none;' }}">
                                                Kesimpulan: Total Skor ≥ 12 (Tidak Beresiko Malnutrisi)
                                            </div>
                                            <div class="alert alert-warning" style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kesimpulan ?? '', 'Beresiko') !== false ? '' : 'display: none;' }}">
                                                Kesimpulan: Total Skor ≤ 11 (Beresiko Malnutrisi)
                                            </div>
                                            <input type="hidden" name="gizi_mna_kesimpulan" id="gizi_mna_kesimpulan" value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_mna_kesimpulan }}">
                                        </div>
                                    </div>

                                    <!-- Strong Kids Form -->
                                    <div id="strong-kids" class="assessment-form" style="display: none;">
                                        <h6 class="mb-3">Penilaian Gizi Strong Kids</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah anak tampa kurus kehilangan lemak subkutan, kehilangan massa otot, dan/ atau wajah cekung?</label>
                                            <select class="form-select" name="gizi_strong_status_kurus">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_status_kurus == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_status_kurus == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penurunan BB selama satu bulan terakhir (untuk semua usia)?
                                                (berdasarkan penilaian objektif data BB bila ada/penilaian subjektif dari orang tua pasien ATAU tidak ada peningkatan berat badan atau tinggi badan (pada bayi < 1 tahun) selama 3 bulan terakhir)</label>
                                            <select class="form-select" name="gizi_strong_penurunan_bb">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penurunan_bb == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penurunan_bb == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Apakah salah satu dari hal berikut ini ada? <br>
                                                - Diare berlabihan (>= 5 kali perhari) dan/atau muntah(>3 klai perhari) selama 1-3 hari terakhir
                                                - Penurunan asupan makanan selama 1-3 hari terakhir
                                                - Intervensi gizi yang sudah ada sebelumnya (misalnya, ONS atau pemberian maka selang)</label>
                                            <select class="form-select" name="gizi_strong_gangguan_pencernaan">
                                                <option value="">pilih</option>
                                                <option value="1" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_gangguan_pencernaan == '1' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_gangguan_pencernaan == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko mengalaman mainutrisi? <br>
                                                <a href="#"><i>Lihat penyakit yang berisiko malnutrisi</i></a></label>
                                            <select class="form-select" name="gizi_strong_penyakit_berisiko">
                                                <option value="">pilih</option>
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penyakit_berisiko == '2' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_penyakit_berisiko == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        <!-- Nilai -->
                                        <div id="strongKidsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success" style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">Kesimpulan: 0 (Beresiko rendah)</div>
                                            <div class="alert alert-warning" style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">Kesimpulan: 1-3 (Beresiko sedang)</div>
                                            <div class="alert alert-danger" style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">Kesimpulan: 4-5 (Beresiko Tinggi)</div>
                                            <input type="hidden" name="gizi_strong_kesimpulan" id="gizi_strong_kesimpulan" value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_strong_kesimpulan }}">
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
                                                <option value="2" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_jatuh_saat_masuk_rs == '2' ? 'selected' : '' }}>Ya</option>
                                                <option value="0" {{ $asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_jatuh_saat_masuk_rs == '0' ? 'selected' : '' }}>Tidak</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Add more NRS form fields here -->
                                        
                                        <!-- Nilai -->
                                        <div id="nrsConclusion" class="risk-indicators mt-4">
                                            <div class="alert alert-success" style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_kesimpulan ?? '', 'rendah') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko rendah</div>
                                            <div class="alert alert-warning" style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_kesimpulan ?? '', 'sedang') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko sedang</div>
                                            <div class="alert alert-danger" style="{{ strpos($asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_kesimpulan ?? '', 'Tinggi') !== false ? '' : 'display: none;' }}">Kesimpulan: Beresiko Tinggi</div>
                                            <input type="hidden" name="gizi_nrs_kesimpulan" id="gizi_nrs_kesimpulan" value="{{ $asesmen->rmeAsesmenKepAnakGizi->gizi_nrs_kesimpulan }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- 13. Status Fungsinal -->
                                <div class="section-separator" id="status-fungsional">
                                    <h5 class="section-title">13. Status Fungsional</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Pilih jenis Skala Pengkajian Aktivitas Harian (ADL) sesuai kondisi pasien</label>
                                        <select class="form-select" name="skala_fungsional" id="skala_fungsional">
                                            <option value="" disabled>Pilih Skala Fungsional</option>
                                            <option value="Pengkajian Aktivitas" {{ $asesmen->rmeAsesmenKepAnakStatusFungsional->jenis_skala == 1 ? 'selected' : '' }}>Pengkajian Aktivitas Harian</option>
                                            <option value="Lainnya" {{ $asesmen->rmeAsesmenKepAnakStatusFungsional->jenis_skala == 2 ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Nilai Skala ADL</label>
                                        <input type="text" class="form-control" id="adl_total" name="adl_total" readonly value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional->nilai_skala_adl }}">
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Kesimpulan Fungsional</label>
                                        <div id="adl_kesimpulan" class="alert {{ $asesmen->rmeAsesmenKepAnakStatusFungsional->kesimpulan_fungsional ? 
                                            (strpos($asesmen->rmeAsesmenKepAnakStatusFungsional->kesimpulan_fungsional, 'Ketergantungan Total') !== false ? 'alert-danger' : 
                                            (strpos($asesmen->rmeAsesmenKepAnakStatusFungsional->kesimpulan_fungsional, 'Ketergantungan Berat') !== false ? 'alert-warning' : 
                                            (strpos($asesmen->rmeAsesmenKepAnakStatusFungsional->kesimpulan_fungsional, 'Ketergantungan Sedang') !== false ? 'alert-info' : 'alert-success'))) 
                                            : 'alert-info' }}">
                                            {{ $asesmen->rmeAsesmenKepAnakStatusFungsional->kesimpulan_fungsional ?: 'Pilih skala aktivitas harian terlebih dahulu' }}
                                        </div>
                                    </div>
                                    
                                    <!-- Hidden fields untuk menyimpan data ADL -->
                                    <input type="hidden" id="adl_jenis_skala" name="adl_jenis_skala" value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional->jenis_skala }}">
                                    <input type="hidden" id="adl_makan" name="adl_makan" value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional->makan }}">
                                    <input type="hidden" id="adl_makan_value" name="adl_makan_value" value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional->makan_value }}">
                                    <input type="hidden" id="adl_berjalan" name="adl_berjalan" value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional->berjalan }}">
                                    <input type="hidden" id="adl_berjalan_value" name="adl_berjalan_value" value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional->berjalan_value }}">
                                    <input type="hidden" id="adl_mandi" name="adl_mandi" value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional->mandi }}">
                                    <input type="hidden" id="adl_mandi_value" name="adl_mandi_value" value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional->mandi_value }}">
                                    <input type="hidden" id="adl_kesimpulan_value" name="adl_kesimpulan_value" value="{{ $asesmen->rmeAsesmenKepAnakStatusFungsional->kesimpulan_fungsional }}">
                                </div>

                                <!-- 14. Kebutuhan Edukasi -->
                                <div class="section-separator" id="kebutuhan-edukasi">
                                    <h5 class="section-title">14. Status Kebutuhan Edukasi, Pendidikan dan Pengajaran</h5>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Gaya Bicara</label>
                                        <select class="form-select" name="gaya_bicara">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="normal" {{ $asesmen->rmeAsesmenKepAnak->gaya_bicara == 'normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="lambat" {{ $asesmen->rmeAsesmenKepAnak->gaya_bicara == 'lambat' ? 'selected' : '' }}>Lambat</option>
                                            <option value="cepat" {{ $asesmen->rmeAsesmenKepAnak->gaya_bicara == 'cepat' ? 'selected' : '' }}>Cepat</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Bahasa Sehari-Hari</label>
                                        <select class="form-select" name="bahasa_sehari_hari">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="Bahasa Indonesia" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                            <option value="Aceh" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                                            <option value="Batak" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Batak' ? 'selected' : '' }}>Batak</option>
                                            <option value="Minangkabau" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Minangkabau' ? 'selected' : '' }}>Minangkabau</option>
                                            <option value="Melayu" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Melayu' ? 'selected' : '' }}>Melayu</option>
                                            <option value="Sunda" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Sunda' ? 'selected' : '' }}>Sunda</option>
                                            <option value="Jawa" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Jawa' ? 'selected' : '' }}>Jawa</option>
                                            <option value="Madura" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Madura' ? 'selected' : '' }}>Madura</option>
                                            <option value="Bali" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Bali' ? 'selected' : '' }}>Bali</option>
                                            <option value="Sasak" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Sasak' ? 'selected' : '' }}>Sasak</option>
                                            <option value="Banjar" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Banjar' ? 'selected' : '' }}>Banjar</option>
                                            <option value="Bugis" {{ $asesmen->rmeAsesmenKepAnak->bahasa == 'Bugis' ? 'selected' : '' }}>Bugis</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Perlu Penerjemah</label>
                                        <select class="form-select" name="perlu_penerjemah">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya" {{ $asesmen->rmeAsesmenKepAnak->perlu_penerjemahan == 'ya' ? 'selected' : '' }}>Ya</option>
                                            <option value="tidak" {{ $asesmen->rmeAsesmenKepAnak->perlu_penerjemahan == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Hambatan Komunikasi</label>
                                        <select class="form-select" name="hambatan_komunikasi">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="tidak_ada" {{ $asesmen->rmeAsesmenKepAnak->hambatan_komunikasi == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                            <option value="pendengaran" {{ $asesmen->rmeAsesmenKepAnak->hambatan_komunikasi == 'pendengaran' ? 'selected' : '' }}>Gangguan Pendengaran</option>
                                            <option value="bicara" {{ $asesmen->rmeAsesmenKepAnak->hambatan_komunikasi == 'bicara' ? 'selected' : '' }}>Gangguan Bicara</option>
                                            <option value="bahasa" {{ $asesmen->rmeAsesmenKepAnak->hambatan_komunikasi == 'bahasa' ? 'selected' : '' }}>Perbedaan Bahasa</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Media Disukai</label>
                                        <select class="form-select" name="media_disukai">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="cetak" {{ $asesmen->rmeAsesmenKepAnak->media_disukai == 'cetak' ? 'selected' : '' }}>Media Cetak</option>
                                            <option value="video" {{ $asesmen->rmeAsesmenKepAnak->media_disukai == 'video' ? 'selected' : '' }}>Video</option>
                                            <option value="diskusi" {{ $asesmen->rmeAsesmenKepAnak->media_disukai == 'diskusi' ? 'selected' : '' }}>Diskusi Langsung</option>
                                            <option value="demonstrasi" {{ $asesmen->rmeAsesmenKepAnak->media_disukai == 'demonstrasi' ? 'selected' : '' }}>Demonstrasi</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tingkat Pendidikan</label>
                                        <select class="form-select" name="tingkat_pendidikan">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="SD" {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'SMA' ? 'selected' : '' }}>SMA</option>
                                            <option value="Diploma" {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                                            <option value="Sarjana" {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'Sarjana' ? 'selected' : '' }}>Sarjana</option>
                                            <option value="Tidak Sekolah" {{ $asesmen->rmeAsesmenKepAnak->tingkat_pendidikan == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 15. Plan -->
                                <div class="section-separator" id="discharge-planning">
                                    <h5 class="section-title">15. Discharge Planning</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Diagnosis medis</label>
                                        <input type="text" class="form-control" name="diagnosis_medis"
                                            placeholder="Diagnosis"
                                            value="{{ $asesmen->rmeAsesmenKepAnakRencanaPulang->diagnosis_medis ?? '' }}">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Usia lanjut</label>
                                        <select class="form-select" name="usia_lanjut">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="0" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->usia_lanjut == '0' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="1" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->usia_lanjut == '1' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Hambatan mobilisasi</label>
                                        <select class="form-select" name="hambatan_mobilisasi">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="0" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->hambatan_mobilisasi == '0' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="1" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->hambatan_mobilisasi == '1' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                        <select class="form-select" name="penggunaan_media_berkelanjutan">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->membutuhkan_pelayanan_medis == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->membutuhkan_pelayanan_medis == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas harian</label>
                                        <select class="form-select" name="ketergantungan_aktivitas">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya">Ya</option>
                                            <option value="tidak">Tidak</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus Setelah Pulang</label>
                                        <select class="form-select" name="keterampilan_khusus">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->memerlukan_keterampilan_khusus == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->memerlukan_keterampilan_khusus == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah Sakit</label>
                                        <select class="form-select" name="alat_bantu">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->memerlukan_alat_bantu == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->memerlukan_alat_bantu == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah Pulang</label>
                                        <select class="form-select" name="nyeri_kronis">
                                            <option value="" disabled>--Pilih--</option>
                                            <option value="ya" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->memiliki_nyeri_kronis == 'ya' ? 'selected' : '' }}>
                                                Ya
                                            </option>
                                            <option value="tidak" 
                                                {{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->memiliki_nyeri_kronis == 'tidak' ? 'selected' : '' }}>
                                                Tidak
                                            </option>
                                        </select>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Perkiraan lama hari dirawat</label>
                                            <input type="text" class="form-control" name="perkiraan_hari" 
                                                placeholder="hari"
                                                value="{{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->perkiraan_lama_dirawat ?? '' }}">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label">Rencana Tanggal Pulang</label>
                                            <input type="date" class="form-control" name="tanggal_pulang"
                                                value="{{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->rencana_pulang ?? '' }}">
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
                                            value="{{ optional($asesmen->rmeAsesmenKepAnakRencanaPulang)->kesimpulan ?? 'Tidak mebutuhkan rencana pulang khusus' }}">
                                    </div>
                                </div>

                                <!-- 16. Diagnosa -->
                                <div class="section-separator" id="diagnosis">
                                    <h5 class="fw-semibold mb-4">16. Diagnosis</h5>

                                    @php
                                    // Parse existing diagnosis data from database
                                    $diagnosisBanding = !empty($asesmen->rmeAsesmenKepAnak->diagnosis_banding) 
                                        ? json_decode($asesmen->rmeAsesmenKepAnak->diagnosis_banding, true) 
                                        : [];
                                    $diagnosisKerja = !empty($asesmen->rmeAsesmenKepAnak->diagnosis_kerja) 
                                        ? json_decode($asesmen->rmeAsesmenKepAnak->diagnosis_kerja, true) 
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
                                            <input type="text" id="diagnosis-banding-input" class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Diagnosis Banding">
                                            <span class="input-group-text bg-white" id="add-diagnosis-banding">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>

                                        <div id="diagnosis-banding-list" class="diagnosis-list bg-light p-3 rounded">
                                            @forelse($diagnosisBanding as $index => $diagnosis)
                                                <div class="diagnosis-item d-flex justify-content-between align-items-center mb-2">
                                                    <span>{{ $index + 1 }}. {{ $diagnosis }}</span>
                                                    <button type="button" class="btn btn-sm text-danger delete-diagnosis" 
                                                        data-type="banding" data-index="{{ $index }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <div class="text-muted fst-italic">Belum ada diagnosis banding</div>
                                            @endforelse
                                        </div>

                                        <!-- Hidden input for form submission -->
                                        <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                            value="{{ json_encode($diagnosisBanding) }}">
                                    </div>

                                    <!-- Diagnosis Kerja -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold mb-2">Diagnosis Kerja</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari diagnosis kerja, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan diagnosis kerja yang tidak ditemukan.</small>

                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="diagnosis-kerja-input" class="form-control border-start-0 ps-0"
                                                placeholder="Cari dan tambah Diagnosis Kerja">
                                            <span class="input-group-text bg-white" id="add-diagnosis-kerja">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>

                                        <div id="diagnosis-kerja-list" class="diagnosis-list bg-light p-3 rounded">
                                            @forelse($diagnosisKerja as $index => $diagnosis)
                                                <div class="diagnosis-item d-flex justify-content-between align-items-center mb-2">
                                                    <span>{{ $index + 1 }}. {{ $diagnosis }}</span>
                                                    <button type="button" class="btn btn-sm text-danger delete-diagnosis" 
                                                        data-type="kerja" data-index="{{ $index }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <div class="text-muted fst-italic">Belum ada diagnosis kerja</div>
                                            @endforelse
                                        </div>

                                        <!-- Hidden input for form submission -->
                                        <input type="hidden" id="diagnosis_kerja" name="diagnosis_kerja"
                                            value="{{ json_encode($diagnosisKerja) }}">
                                    </div>
                                </div>

                                <!-- 17. Implementasi -->
                                <div class="section-separator" style="margin-bottom: 2rem;">
                                    <h5 class="fw-semibold mb-4">16. Implementasi</h5>

                                    @php
                                        // Parse data implementasi dari database (sesuaikan dengan field di model asesmen anak)
                                        $observasi = !empty($asesmen->rmeAsesmenKepAnak->observasi) 
                                            ? json_decode($asesmen->rmeAsesmenKepAnak->observasi, true) 
                                            : [];
                                        $terapeutik = !empty($asesmen->rmeAsesmenKepAnak->terapeutik) 
                                            ? json_decode($asesmen->rmeAsesmenKepAnak->terapeutik, true) 
                                            : [];
                                        $edukasi = !empty($asesmen->rmeAsesmenKepAnak->edukasi) 
                                            ? json_decode($asesmen->rmeAsesmenKepAnak->edukasi, true) 
                                            : [];
                                        $kolaborasi = !empty($asesmen->rmeAsesmenKepAnak->kolaborasi) 
                                            ? json_decode($asesmen->rmeAsesmenKepAnak->kolaborasi, true) 
                                            : [];
                                        $prognosis = !empty($asesmen->rmeAsesmenKepAnak->prognosis) 
                                            ? json_decode($asesmen->rmeAsesmenKepAnak->prognosis, true) 
                                            : [];
                                    @endphp

                                    <!-- Rencana Penatalaksanaan dan Pengobatan -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Rencana Penatalaksanaan dan Pengobatan</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari rencana, atau tanda tambah untuk menambah keterangan rencana yang tidak ditemukan.</small>
                                    </div>

                                    <!-- Observasi Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Observasi</label>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="observasi-input" class="form-control border-start-0 ps-0" placeholder="Cari dan tambah Observasi">
                                            <span class="input-group-text bg-white" id="add-observasi">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="observasi-list" class="list-group mb-2">
                                            @forelse($observasi as $index => $item)
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $index + 1 }}. {{ $item }}</span>
                                                    <button type="button" class="btn btn-sm text-danger delete-item" data-type="observasi" data-index="{{ $index }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <div class="list-group-item text-muted fst-italic">Belum ada data observasi</div>
                                            @endforelse
                                        </div>
                                        <input type="hidden" id="observasi" name="observasi" value="{{ json_encode($observasi) }}">
                                    </div>

                                    <!-- Terapeutik Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Terapeutik</label>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="terapeutik-input" class="form-control border-start-0 ps-0" placeholder="Cari dan tambah Terapeutik">
                                            <span class="input-group-text bg-white" id="add-terapeutik">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="terapeutik-list" class="list-group mb-2">
                                            @forelse($terapeutik as $index => $item)
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $index + 1 }}. {{ $item }}</span>
                                                    <button type="button" class="btn btn-sm text-danger delete-item" data-type="terapeutik" data-index="{{ $index }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <div class="list-group-item text-muted fst-italic">Belum ada data terapeutik</div>
                                            @endforelse
                                        </div>
                                        <input type="hidden" id="terapeutik" name="terapeutik" value="{{ json_encode($terapeutik) }}">
                                    </div>

                                    <!-- Edukasi Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Edukasi</label>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="edukasi-input" class="form-control border-start-0 ps-0" placeholder="Cari dan tambah Edukasi">
                                            <span class="input-group-text bg-white" id="add-edukasi">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="edukasi-list" class="list-group mb-2">
                                            @forelse($edukasi as $index => $item)
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $index + 1 }}. {{ $item }}</span>
                                                    <button type="button" class="btn btn-sm text-danger delete-item" data-type="edukasi" data-index="{{ $index }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <div class="list-group-item text-muted fst-italic">Belum ada data edukasi</div>
                                            @endforelse
                                        </div>
                                        <input type="hidden" id="edukasi" name="edukasi" value="{{ json_encode($edukasi) }}">
                                    </div>

                                    <!-- Kolaborasi Section -->
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2">Kolaborasi</label>
                                        <div class="input-group mt-2">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="kolaborasi-input" class="form-control border-start-0 ps-0" placeholder="Cari dan tambah Kolaborasi">
                                            <span class="input-group-text bg-white" id="add-kolaborasi">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="kolaborasi-list" class="list-group mb-2">
                                            @forelse($kolaborasi as $index => $item)
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $index + 1 }}. {{ $item }}</span>
                                                    <button type="button" class="btn btn-sm text-danger delete-item" data-type="kolaborasi" data-index="{{ $index }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <div class="list-group-item text-muted fst-italic">Belum ada data kolaborasi</div>
                                            @endforelse
                                        </div>
                                        <input type="hidden" id="kolaborasi" name="kolaborasi" value="{{ json_encode($kolaborasi) }}">
                                    </div>

                                    <!-- Prognosis Section -->
                                    <div class="mb-4">
                                        <label class="text-primary fw-semibold">Prognosis</label>
                                        <small class="d-block text-secondary mb-3">Pilih tanda dokumen untuk mencari prognosis, atau tanda tambah untuk menambah keterangan prognosis yang tidak ditemukan.</small>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="bi bi-search text-secondary"></i>
                                            </span>
                                            <input type="text" id="prognosis-input" class="form-control border-start-0 ps-0" placeholder="Cari dan tambah Prognosis">
                                            <span class="input-group-text bg-white" id="add-prognosis">
                                                <i class="bi bi-plus-circle text-primary"></i>
                                            </span>
                                        </div>
                                        <div id="prognosis-list" class="list-group mb-3">
                                            @forelse($prognosis as $index => $item)
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $index + 1 }}. {{ $item }}</span>
                                                    <button type="button" class="btn btn-sm text-danger delete-item" data-type="prognosis" data-index="{{ $index }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @empty
                                                <div class="list-group-item text-muted fst-italic">Belum ada data prognosis</div>
                                            @endforelse
                                        </div>
                                        <input type="hidden" id="prognosis" name="prognosis" value="{{ json_encode($prognosis) }}">
                                    </div>
                                </div>

                                <!-- 18. Evaluasi -->
                                <div class="section-separator" style="margin-bottom: 2rem;" id="evaluasi">
                                    <h5 class="fw-semibold mb-4">18. Evaluasi</h5>
                                    <div class="form-group">
                                        <label style="min-width: 200px;">Tambah Evaluasi Keperawatan</label>
                                        <textarea class="form-control" name="evaluasi_keperawatan" rows="4"
                                            placeholder="Evaluasi Keperawaran">{{ $asesmen->rmeAsesmenKepAnak->evaluasi ?? '' }}</textarea>
                                    </div>
                                </div>


                                {{-- Final section - Submit button --}}
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
    {{-- Include modals --}}
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.edit-modal-create-alergi')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-skalanyeri')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.edit-modal-penyakitdiderita')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.edit-modal-jenisoperasi')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-riwayatkeluarga')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-intervensirisikojatuh')
    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-anak.modal-skala-adl')
@endsection
