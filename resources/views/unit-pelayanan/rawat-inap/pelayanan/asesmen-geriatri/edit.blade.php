@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
            <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Edit Asesmen Medis Geriatri',
                    'description' => 'Isikan Asesmen medis dalam 24 jam sejak pasien masuk ke unit pelayanan',
                ])

            {{-- FORM ASESMEN MEDIS GERIATRI --}}
            <form method="POST"
                action="{{ route('rawat-inap.asesmen.medis.geriatri.update', [
                    'kd_unit' => $kd_unit,
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                    'id' => $id,
                ]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="px-3">
                    <div>

                        <div class="section-separator" id="data-masuk">
                            <h5 class="section-title">1. Data masuk</h5>

                            <div class="form-group">
                                <label style="min-width: 200px;">Tanggal Dan Jam Pengisian</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    @php
                                        $waktuMasuk = $asesmenGeriatri->waktu_masuk
                                            ? Carbon\Carbon::parse($asesmenGeriatri->waktu_masuk)
                                            : Carbon\Carbon::parse($asesmen->waktu_asesmen);
                                    @endphp
                                    <input type="date" class="form-control" name="tanggal_masuk"
                                        id="tanggal_masuk" value="{{ $waktuMasuk->format('Y-m-d') }}">
                                    <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                        value="{{ $waktuMasuk->format('H:i') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Kondisi Masuk</label>
                                <select class="form-select" name="kondisi_masuk">
                                    <option selected disabled>Pilih</option>
                                    <option value="Mandiri"
                                        {{ $asesmenGeriatri->kondisi_masuk == 'Mandiri' ? 'selected' : '' }}>
                                        Mandiri</option>
                                    <option value="Jalan Kaki"
                                        {{ $asesmenGeriatri->kondisi_masuk == 'Jalan Kaki' ? 'selected' : '' }}>
                                        Jalan Kaki</option>
                                    <option value="Kursi Roda"
                                        {{ $asesmenGeriatri->kondisi_masuk == 'Kursi Roda' ? 'selected' : '' }}>
                                        Kursi Roda</option>
                                    <option value="Brankar"
                                        {{ $asesmenGeriatri->kondisi_masuk == 'Brankar' ? 'selected' : '' }}>
                                        Brankar</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 200px;">Diagnosis Masuk</label>
                                <input type="text" class="form-control" name="diagnosis_masuk"
                                    value="{{ $asesmenGeriatri->diagnosis_masuk }}">
                            </div>
                        </div>

                        <div class="section-separator" id="anamnesis">
                            <h5 class="section-title">2. Anamnesis</h5>

                            <div class="form-group">
                                <label style="min-width: 220px;">Anamnesis</label>
                                <input type="text" class="form-control" name="anamnesis"
                                    placeholder="Masukkan anamnesis" value="{{ $asesmen->anamnesis }}" required>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Keluhan Utama/Alasan Masuk RS</label>
                                <textarea class="form-control" name="keluhan_utama" rows="4"
                                    placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit" required>{{ $asesmenGeriatri->keluhan_utama }}</textarea>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Sensorium</label>
                                <select class="form-select" name="sensorium">
                                    <option value="" {{ !$asesmenGeriatri->sensorium ? 'selected' : '' }}
                                        disabled>
                                        --Pilih--</option>
                                    <option value="Compos Mentis"
                                        {{ $asesmenGeriatri->sensorium == 'Compos Mentis' ? 'selected' : '' }}>
                                        Compos Mentis</option>
                                    <option value="Apatis"
                                        {{ $asesmenGeriatri->sensorium == 'Apatis' ? 'selected' : '' }}>
                                        Apatis</option>
                                    <option value="Somnolen"
                                        {{ $asesmenGeriatri->sensorium == 'Somnolen' ? 'selected' : '' }}>
                                        Somnolen</option>
                                    <option value="Sopor"
                                        {{ $asesmenGeriatri->sensorium == 'Sopor' ? 'selected' : '' }}>
                                        Sopor</option>
                                    <option value="Coma"
                                        {{ $asesmenGeriatri->sensorium == 'Coma' ? 'selected' : '' }}>Coma
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Tekanan Darah (mmHg)</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    <div class="flex-grow-1">
                                        <label class="form-label">Sistole</label>
                                        <input type="number" class="form-control" name="tekanan_darah_sistole"
                                            placeholder="120" min="70" max="300"
                                            value="{{ $asesmenGeriatri->sistole }}">
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label">Diastole</label>
                                        <input type="number" class="form-control" name="tekanan_darah_diastole"
                                            placeholder="80" min="40" max="150"
                                            value="{{ $asesmenGeriatri->diastole }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Suhu (°C)</label>
                                <input type="text" class="form-control" name="suhu" step="0.1"
                                    placeholder="36.5" min="30" max="45"
                                    value="{{ $asesmenGeriatri->suhu }}">
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Respirasi (Per Menit)</label>
                                <input type="number" class="form-control" name="respirasi" placeholder="20"
                                    min="10" max="50" value="{{ $asesmenGeriatri->respirasi }}">
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Nadi (Per Menit)</label>
                                <input type="number" class="form-control" name="nadi" placeholder="80"
                                    min="40" max="200" value="{{ $asesmenGeriatri->nadi }}">
                            </div>

                            {{-- TAMBAHAN VITAL SIGN: BB, TB, IMT --}}
                            <div class="form-group">
                                <label style="min-width: 220px;">Berat Badan (Kg)</label>
                                <input type="number" class="form-control" name="berat_badan" id="berat_badan"
                                    placeholder="70" step="0.1" min="10" max="300"
                                    value="{{ $asesmenGeriatri->berat_badan }}">
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Tinggi Badan (Cm)</label>
                                <input type="number" class="form-control" name="tinggi_badan" id="tinggi_badan"
                                    placeholder="170" step="0.1" min="50" max="250"
                                    value="{{ $asesmenGeriatri->tinggi_badan }}">
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">IMT (Kg/m²)</label>
                                <input type="number" class="form-control" name="imt" id="imt"
                                    placeholder="Otomatis terhitung" step="0.1" readonly
                                    value="{{ $asesmenGeriatri->imt }}">
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Kategori IMT</label>
                                <div class="d-flex flex-column gap-2" style="width: 100%;">
                                    @php
                                        $kategoriImt = $asesmenGeriatri->kategori_imt
                                            ? json_decode($asesmenGeriatri->kategori_imt, true)
                                            : [];
                                    @endphp
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kategori_imt[]"
                                            value="Underweight" id="underweight"
                                            {{ in_array('Underweight', $kategoriImt) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="underweight">
                                            Underweight (< 18,0) </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kategori_imt[]"
                                            value="Normoweight" id="normoweight"
                                            {{ in_array('Normoweight', $kategoriImt) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="normoweight">
                                            Normoweight (18,0 - 22,9)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kategori_imt[]"
                                            value="Overweight" id="overweight"
                                            {{ in_array('Overweight', $kategoriImt) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="overweight">
                                            Overweight (23,0 - 24,9)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kategori_imt[]"
                                            value="Obese" id="obese"
                                            {{ in_array('Obese', $kategoriImt) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="obese">
                                            Obese (25,0 - 30,0)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kategori_imt[]"
                                            value="Morbid Obese" id="morbid_obese"
                                            {{ in_array('Morbid Obese', $kategoriImt) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="morbid_obese">
                                            Morbid Obese (> 30)
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="section-separator" id="riwayat-kesehatan">
                            <h5 class="section-title">3. Riwayat Kesehatan</h5>

                            <div class="form-group">
                                <label style="min-width: 220px;">Riwayat Penyakit Sekarang</label>
                                <textarea class="form-control" name="riwayat_penyakit_sekarang" rows="4"
                                    placeholder="Masukkan riwayat penyakit sekarang">{{ $asesmenGeriatri->riwayat_penyakit_sekarang }}</textarea>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Riwayat Penyakit Terdahulu</label>
                                <input type="text" class="form-control" name="riwayat_penyakit_terdahulu"
                                    placeholder="Masukkan riwayat penyakit terdahulu"
                                    value="{{ $asesmenGeriatri->riwayat_penyakit_terdahulu }}">
                            </div>

                        </div>

                        {{-- DATA PSIKOLOGI DAN SOSIAL EKONOMI --}}
                        <div class="section-separator" id="psikologi-sosial">
                            <h5 class="section-title">4. Data Psikologi dan Sosial Ekonomi</h5>

                            <div class="form-group">
                                <label style="min-width: 220px;">Kondisi Psikologi</label>
                                <select class="form-select" name="kondisi_psikologi">
                                    <option value=""
                                        {{ !$asesmenGeriatri->kondisi_psikologi ? 'selected' : '' }} disabled>
                                        --Pilih--</option>
                                    <option value="Tenang"
                                        {{ $asesmenGeriatri->kondisi_psikologi == 'Tenang' ? 'selected' : '' }}>
                                        Tenang</option>
                                    <option value="Cemas"
                                        {{ $asesmenGeriatri->kondisi_psikologi == 'Cemas' ? 'selected' : '' }}>
                                        Cemas</option>
                                    <option value="Agitasi"
                                        {{ $asesmenGeriatri->kondisi_psikologi == 'Agitasi' ? 'selected' : '' }}>
                                        Agitasi</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Kondisi Sosial Ekonomi</label>
                                <select class="form-select" name="kondisi_sosial_ekonomi">
                                    <option value=""
                                        {{ !$asesmenGeriatri->kondisi_sosial_ekonomi ? 'selected' : '' }}
                                        disabled>--Pilih--</option>
                                    <option value="Kurang"
                                        {{ $asesmenGeriatri->kondisi_sosial_ekonomi == 'Kurang' ? 'selected' : '' }}>
                                        Kurang</option>
                                    <option value="Cukup"
                                        {{ $asesmenGeriatri->kondisi_sosial_ekonomi == 'Cukup' ? 'selected' : '' }}>
                                        Cukup</option>
                                    <option value="Baik"
                                        {{ $asesmenGeriatri->kondisi_sosial_ekonomi == 'Baik' ? 'selected' : '' }}>
                                        Baik</option>
                                </select>
                            </div>

                        </div>

                        {{-- ASESMEN GERIATRI KHUSUS --}}
                        <div class="section-separator" id="asesmen-geriatri">
                            <h5 class="section-title">5. Asesmen Geriatri</h5>

                            @php
                                $adl = $asesmenGeriatri->adl
                                    ? json_decode($asesmenGeriatri->adl, true)
                                    : [];
                                $kognitif = $asesmenGeriatri->kognitif
                                    ? json_decode($asesmenGeriatri->kognitif, true)
                                    : [];
                                $depresi = $asesmenGeriatri->depresi
                                    ? json_decode($asesmenGeriatri->depresi, true)
                                    : [];
                                $inkontinensia = $asesmenGeriatri->inkontinensia
                                    ? json_decode($asesmenGeriatri->inkontinensia, true)
                                    : [];
                                $insomnia = $asesmenGeriatri->insomnia
                                    ? json_decode($asesmenGeriatri->insomnia, true)
                                    : [];
                            @endphp

                            <div class="form-group">
                                <label style="min-width: 220px;">ADL (Activities of Daily Living)</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="adl[]"
                                            value="Mandiri" id="adl_mandiri"
                                            {{ in_array('Mandiri', $adl) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="adl_mandiri">
                                            Mandiri
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="adl[]"
                                            value="Ketergantungan" id="adl_ketergantungan"
                                            {{ in_array('Ketergantungan', $adl) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="adl_ketergantungan">
                                            Ketergantungan
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Kognitif</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kognitif[]"
                                            value="Normal" id="kognitif_normal"
                                            {{ in_array('Normal', $kognitif) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kognitif_normal">
                                            Normal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="kognitif[]"
                                            value="Gangguan Kognitif" id="kognitif_gangguan"
                                            {{ in_array('Gangguan Kognitif', $kognitif) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="kognitif_gangguan">
                                            Gangguan Kognitif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Depresi</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="depresi[]"
                                            value="Normal" id="depresi_normal"
                                            {{ in_array('Normal', $depresi) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="depresi_normal">
                                            Normal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="depresi[]"
                                            value="Depresi" id="depresi_ada"
                                            {{ in_array('Depresi', $depresi) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="depresi_ada">
                                            Depresi
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Inkontinensia</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="inkontinensia[]" value="Tidak Ada Inkontinensia"
                                            id="inkontinensia_tidak"
                                            {{ in_array('Tidak Ada Inkontinensia', $inkontinensia) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inkontinensia_tidak">
                                            Tidak Ada Inkontinensia
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="inkontinensia[]" value="Inkontinensia"
                                            id="inkontinensia_ada"
                                            {{ in_array('Inkontinensia', $inkontinensia) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inkontinensia_ada">
                                            Inkontinensia
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 220px;">Insomnia</label>
                                <div class="d-flex gap-3" style="width: 100%;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="insomnia[]"
                                            value="Normal" id="insomnia_normal"
                                            {{ in_array('Normal', $insomnia) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="insomnia_normal">
                                            Normal
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="insomnia[]"
                                            value="Insomnia" id="insomnia_ada"
                                            {{ in_array('Insomnia', $insomnia) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="insomnia_ada">
                                            Insomnia
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="section-separator" id="alergi">
                            <h5 class="section-title">6. Alergi</h5>

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
                                            <td colspan="5" class="text-center text-muted">Tidak ada data
                                                alergi</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="section-separator" id="pemeriksaan-fisik">
                            <h5 class="section-title">7. Pemeriksaan Fisik</h5>
                            <div class="row g-3">
                                <div class="pemeriksaan-fisik">
                                    <h6>Pemeriksaan Fisik</h6>
                                    <p class="text-small">Centang normal jika fisik yang dinilai
                                        normal,
                                        pilih tanda tambah
                                        untuk menambah keterangan fisik yang ditemukan tidak normal.
                                        Jika
                                        tidak dipilih salah satunya, maka pemeriksaan tidak
                                        dilakukan.
                                    </p>
                                    <div class="row">
                                        @foreach ($itemFisik->chunk(ceil($itemFisik->count() / 2)) as $chunk)
                                            <div class="col-md-6">
                                                <div class="d-flex flex-column gap-3">
                                                    @foreach ($chunk as $item)
                                                        @php
                                                            $pemeriksaanData = $pemeriksaanFisik->get(
                                                                $item->id,
                                                            );
                                                            $isNormal = $pemeriksaanData
                                                                ? $pemeriksaanData->is_normal
                                                                : false;
                                                            $keterangan = $pemeriksaanData
                                                                ? $pemeriksaanData->keterangan
                                                                : '';
                                                        @endphp
                                                        <div class="pemeriksaan-item">
                                                            <div
                                                                class="d-flex align-items-center border-bottom pb-2">
                                                                <div class="flex-grow-1">
                                                                    {{ $item->nama }}
                                                                </div>
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
                                                                style="display:{{ !$isNormal && $keterangan ? 'block' : 'none' }};">
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

                        <div class="section-separator" id="discharge-planning">
                            <h5 class="section-title">8. Discharge Planning</h5>

                            {{-- <div class="mb-4">
                                <label class="form-label">Diagnosis medis</label>
                                <input type="text" class="form-control" name="diagnosis_medis"
                                    placeholder="Diagnosis"
                                    value="{{ $rencanaPulang->diagnosis_medis ?? '' }}">
                            </div> --}}

                            <div class="mb-4">
                                <label class="form-label">Usia lanjut</label>
                                <select class="form-select" name="usia_lanjut" id="usia_lanjut">
                                    <option value=""
                                        {{ !isset($rencanaPulang->usia_lanjut) ? 'selected' : '' }} disabled>
                                        --Pilih--</option>
                                    <option value="0"
                                        {{ isset($rencanaPulang->usia_lanjut) && $rencanaPulang->usia_lanjut == '0' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="1"
                                        {{ isset($rencanaPulang->usia_lanjut) && $rencanaPulang->usia_lanjut == '1' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Hambatan mobilisasi</label>
                                <select class="form-select" name="hambatan_mobilisasi"
                                    id="hambatan_mobilisasi">
                                    <option value=""
                                        {{ !isset($rencanaPulang->hambatan_mobilisasi) ? 'selected' : '' }}
                                        disabled>--Pilih--</option>
                                    <option value="0"
                                        {{ isset($rencanaPulang->hambatan_mobilisasi) && $rencanaPulang->hambatan_mobilisasi == '0' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="1"
                                        {{ isset($rencanaPulang->hambatan_mobilisasi) && $rencanaPulang->hambatan_mobilisasi == '1' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Membutuhkan penggunaan media berkelanjutan</label>
                                <select class="form-select" name="penggunaan_media_berkelanjutan"
                                    id="penggunaan_media_berkelanjutan">
                                    <option value=""
                                        {{ !isset($rencanaPulang->membutuhkan_pelayanan_medis) ? 'selected' : '' }}
                                        disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ isset($rencanaPulang->membutuhkan_pelayanan_medis) && $rencanaPulang->membutuhkan_pelayanan_medis == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ isset($rencanaPulang->membutuhkan_pelayanan_medis) && $rencanaPulang->membutuhkan_pelayanan_medis == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Ketergantungan dengan orang lain dalam aktivitas
                                    harian</label>
                                <select class="form-select" name="ketergantungan_aktivitas"
                                    id="ketergantungan_aktivitas">
                                    <option value=""
                                        {{ !isset($rencanaPulang->ketergantungan_aktivitas) ? 'selected' : '' }}
                                        disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ isset($rencanaPulang->ketergantungan_aktivitas) && $rencanaPulang->ketergantungan_aktivitas == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ isset($rencanaPulang->ketergantungan_aktivitas) && $rencanaPulang->ketergantungan_aktivitas == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Pasien / Keluarga Memerlukan Keterampilan Khusus
                                    Setelah Pulang</label>
                                <select class="form-select" name="keterampilan_khusus"
                                    id="keterampilan_khusus">
                                    <option value=""
                                        {{ !isset($rencanaPulang->memerlukan_keterampilan_khusus) ? 'selected' : '' }}
                                        disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ isset($rencanaPulang->memerlukan_keterampilan_khusus) && $rencanaPulang->memerlukan_keterampilan_khusus == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ isset($rencanaPulang->memerlukan_keterampilan_khusus) && $rencanaPulang->memerlukan_keterampilan_khusus == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Pasien Memerlukan Alat Bantu Setelah Keluar Rumah
                                    Sakit</label>
                                <select class="form-select" name="alat_bantu" id="alat_bantu">
                                    <option value=""
                                        {{ !isset($rencanaPulang->memerlukan_alat_bantu) ? 'selected' : '' }}
                                        disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ isset($rencanaPulang->memerlukan_alat_bantu) && $rencanaPulang->memerlukan_alat_bantu == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ isset($rencanaPulang->memerlukan_alat_bantu) && $rencanaPulang->memerlukan_alat_bantu == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Pasien Memiliki Nyeri Kronis Dan / Kebiasaan Setelah
                                    Pulang</label>
                                <select class="form-select" name="nyeri_kronis" id="nyeri_kronis">
                                    <option value=""
                                        {{ !isset($rencanaPulang->memiliki_nyeri_kronis) ? 'selected' : '' }}
                                        disabled>--Pilih--</option>
                                    <option value="ya"
                                        {{ isset($rencanaPulang->memiliki_nyeri_kronis) && $rencanaPulang->memiliki_nyeri_kronis == 'ya' ? 'selected' : '' }}>
                                        Ya</option>
                                    <option value="tidak"
                                        {{ isset($rencanaPulang->memiliki_nyeri_kronis) && $rencanaPulang->memiliki_nyeri_kronis == 'tidak' ? 'selected' : '' }}>
                                        Tidak</option>
                                </select>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Perkiraan lama hari dirawat</label>
                                    <input type="text" class="form-control" name="perkiraan_hari"
                                        placeholder="hari"
                                        value="{{ $rencanaPulang->perkiraan_lama_dirawat ?? '' }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Rencana Tanggal Pulang</label>
                                    <input type="date" class="form-control" name="tanggal_pulang"
                                        value="{{ $rencanaPulang->rencana_pulang ? \Carbon\Carbon::parse($rencanaPulang->rencana_pulang)->format('Y-m-d') : '' }}">
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="form-label">KESIMPULAN</label>
                                <div class="d-flex flex-column gap-2" id="kesimpulan-alerts">
                                    <div class="alert alert-info" id="alert-info" style="display: none;">
                                        Pilih semua Planning
                                    </div>
                                    <div class="alert alert-warning" id="alert-warning"
                                        style="display: none;">
                                        Mebutuhkan rencana pulang khusus
                                    </div>
                                    <div class="alert alert-success" id="alert-success"
                                        style="display: none;">
                                        Tidak mebutuhkan rencana pulang khusus
                                    </div>
                                </div>
                                <input type="hidden" id="kesimpulan" name="kesimpulan_planing"
                                    value="{{ $rencanaPulang->kesimpulan ?? 'Pilih semua Planning' }}">
                            </div>
                        </div>

                        {{-- <div class="section-separator" id="diagnosis">
                            <h5 class="fw-semibold mb-4">9. Diagnosis</h5>

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
                                    value="{{ $asesmenGeriatri->diagnosis_banding ?? '[]' }}">
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
                                    value="{{ $asesmenGeriatri->diagnosis_kerja ?? '[]' }}">
                            </div>
                        </div> --}}

                        <div class="text-end">
                            <x-button-submit>Perbarui</x-button-submit>
                        </div>

                    </div>
                </div>
            </form>
            </x-content-card>
        </div>
    </div>
@endsection

{{-- MODAL ALERGI --}}
<div class="modal fade" id="alergiModal" tabindex="-1" aria-labelledby="alergiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alergiModalLabel">Manajemen Data Alergi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Input Alergi -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Tambah Data Alergi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="modal_jenis_alergi" class="form-label">Jenis Alergi</label>
                                <select class="form-select" id="modal_jenis_alergi">
                                    <option value="">-- Pilih Jenis Alergi --</option>
                                    <option value="Obat">Obat</option>
                                    <option value="Makanan">Makanan</option>
                                    <option value="Udara">Udara</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_alergen" class="form-label">Alergen</label>
                                <input type="text" class="form-control" id="modal_alergen"
                                    placeholder="Contoh: Paracetamol, Seafood, Debu">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_reaksi" class="form-label">Reaksi</label>
                                <input type="text" class="form-control" id="modal_reaksi"
                                    placeholder="Contoh: Gatal, Ruam, Sesak nafas">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modal_tingkat_keparahan" class="form-label">Tingkat Keparahan</label>
                                <select class="form-select" id="modal_tingkat_keparahan">
                                    <option value="">-- Pilih Tingkat Keparahan --</option>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary btn-sm" id="addToAlergiList">
                                <i class="bi bi-plus"></i> Tambah ke Daftar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Daftar Alergi -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">Daftar Alergi Pasien</h6>
                        <span class="badge bg-primary" id="alergiCount">0</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Jenis Alergi</th>
                                        <th width="25%">Alergen</th>
                                        <th width="25%">Reaksi</th>
                                        <th width="20%">Tingkat Keparahan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="modalAlergiList">
                                    <!-- Data akan ditampilkan di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div id="noAlergiMessage" class="text-center text-muted py-3" style="display: none;">
                            <i class="bi bi-info-circle"></i> Belum ada data alergi
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveAlergiData">
                    <i class="bi bi-check"></i> Simpan Data Alergi
                </button>
            </div>
        </div>
    </div>
</div>

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
            display: flex;
            align-items: flex-start;
        }

        .form-group label {
            margin-right: 1rem;
            padding-top: 0.5rem;
        }

        /* Style untuk checkbox asesmen geriatri */
        .form-check-input:checked[name*="adl"],
        .form-check-input:checked[name*="kognitif"],
        .form-check-input:checked[name*="depresi"],
        .form-check-input:checked[name*="inkontinensia"],
        .form-check-input:checked[name*="insomnia"],
        .form-check-input:checked[name*="kategori_imt"] {
            background-color: #097dd6;
            border-color: #097dd6;
        }

        /* Discharge Planning Styles */
        #discharge-planning {
            background-color: #fff;
            border-radius: 8px;
        }

        #discharge-planning .form-select {
            transition: all 0.3s ease;
        }

        #discharge-planning .form-select:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        #kesimpulan-alerts {
            transition: all 0.3s ease;
        }

        #kesimpulan-alerts .alert {
            margin-bottom: 0.5rem;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Diagnosis Styles */
        .diagnosis-list {
            min-height: 80px;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .diagnosis-item {
            transition: all 0.2s ease;
            border: 1px solid #e3e6f0 !important;
        }

        .diagnosis-item:hover {
            background-color: #f8f9fa !important;
            border-color: #097dd6 !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .suggestions-list {
            max-height: 200px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: white;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .suggestion-item {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
            transition: background-color 0.2s ease;
        }

        .suggestion-item:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            //====================================================================================//
            // BMI Calculator dan Kategori IMT - EDIT MODE
            //====================================================================================//

            function calculateBMI() {
                const beratBadanInput = document.getElementById('berat_badan');
                const tinggiBadanInput = document.getElementById('tinggi_badan');
                const imtField = document.getElementById('imt');

                if (!beratBadanInput || !tinggiBadanInput || !imtField) return;

                const beratBadan = parseFloat(beratBadanInput.value);
                const tinggiBadan = parseFloat(tinggiBadanInput.value);

                // Reset semua checkbox kategori IMT
                const kategoriCheckboxes = document.querySelectorAll('input[name="kategori_imt[]"]');
                kategoriCheckboxes.forEach(checkbox => checkbox.checked = false);

                if (beratBadan && tinggiBadan && beratBadan > 0 && tinggiBadan > 0) {
                    // Konversi tinggi badan dari cm ke meter
                    const tinggiBadanMeter = tinggiBadan / 100;
                    const imt = beratBadan / (tinggiBadanMeter * tinggiBadanMeter);

                    // Tampilkan hasil IMT dengan 2 desimal
                    imtField.value = imt.toFixed(2);

                    // Tentukan kategori dan centang checkbox yang sesuai
                    if (imt < 18.0) {
                        const underweightCheckbox = document.getElementById('underweight');
                        if (underweightCheckbox) underweightCheckbox.checked = true;
                    } else if (imt >= 18.0 && imt <= 22.9) {
                        const normoweightCheckbox = document.getElementById('normoweight');
                        if (normoweightCheckbox) normoweightCheckbox.checked = true;
                    } else if (imt >= 23.0 && imt <= 24.9) {
                        const overweightCheckbox = document.getElementById('overweight');
                        if (overweightCheckbox) overweightCheckbox.checked = true;
                    } else if (imt >= 25.0 && imt <= 30.0) {
                        const obeseCheckbox = document.getElementById('obese');
                        if (obeseCheckbox) obeseCheckbox.checked = true;
                    } else if (imt > 30) {
                        const morbidObeseCheckbox = document.getElementById('morbid_obese');
                        if (morbidObeseCheckbox) morbidObeseCheckbox.checked = true;
                    }
                } else {
                    imtField.value = '';
                }
            }

            // Event listener untuk kalkulasi BMI
            const beratBadanInput = document.getElementById('berat_badan');
            const tinggiBadanInput = document.getElementById('tinggi_badan');

            if (beratBadanInput) {
                beratBadanInput.addEventListener('input', calculateBMI);
            }
            if (tinggiBadanInput) {
                tinggiBadanInput.addEventListener('input', calculateBMI);
            }

            //====================================================================================//
            // Checkbox handling untuk asesmen geriatri (mutual exclusive) - EDIT MODE
            //====================================================================================//

            // Fungsi untuk membuat checkbox saling eksklusif dalam grup yang sama
            function setupMutualExclusiveCheckboxes(groupName) {
                const checkboxes = document.querySelectorAll(`input[name="${groupName}[]"]`);

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            // Uncheck semua checkbox lain dalam grup yang sama
                            checkboxes.forEach(otherCheckbox => {
                                if (otherCheckbox !== this) {
                                    otherCheckbox.checked = false;
                                }
                            });
                        }
                    });
                });
            }

            // Setup untuk semua grup checkbox asesmen geriatri - cek dulu apakah elemen ada
            if (document.querySelector('input[name="adl[]"]')) {
                setupMutualExclusiveCheckboxes('adl');
            }
            if (document.querySelector('input[name="kognitif[]"]')) {
                setupMutualExclusiveCheckboxes('kognitif');
            }
            if (document.querySelector('input[name="depresi[]"]')) {
                setupMutualExclusiveCheckboxes('depresi');
            }
            if (document.querySelector('input[name="inkontinensia[]"]')) {
                setupMutualExclusiveCheckboxes('inkontinensia');
            }
            if (document.querySelector('input[name="insomnia[]"]')) {
                setupMutualExclusiveCheckboxes('insomnia');
            }

            // Untuk kategori IMT, biarkan hanya satu yang bisa dipilih
            const kategoriImtCheckboxes = document.querySelectorAll('input[name="kategori_imt[]"]');
            if (kategoriImtCheckboxes.length > 0) {
                kategoriImtCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            kategoriImtCheckboxes.forEach(otherCheckbox => {
                                if (otherCheckbox !== this) {
                                    otherCheckbox.checked = false;
                                }
                            });
                        }
                    });
                });
            }

            //====================================================================================//
            // ALERGI - EDIT MODE
            //====================================================================================//

            // Array untuk menyimpan data alergi sementara
            let alergiDataArray = [];

            // Load existing alergi data from PHP
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

            // Event listeners untuk alergi
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
                    const tingkatKeparahan = document.getElementById('modal_tingkat_keparahan')?.value
                        ?.trim();

                    if (!jenisAlergi || !alergen || !reaksi || !tingkatKeparahan) {
                        alert('Harap isi semua field alergi');
                        return;
                    }

                    const isDuplicate = alergiDataArray.some(item =>
                        item.jenis_alergi === jenisAlergi &&
                        item.alergen.toLowerCase() === alergen.toLowerCase()
                    );

                    if (isDuplicate) {
                        alert('Data alergi sudah ada');
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

            // Functions untuk alergi
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

            // Global functions untuk onclick events
            window.removeAlergiFromModal = function(index) {
                alergiDataArray.splice(index, 1);
                updateModalAlergiList();
            };

            window.removeAlergiFromMain = function(index) {
                alergiDataArray.splice(index, 1);
                updateMainAlergiTable();
                updateHiddenAlergiInput();
            };

            // Initial load untuk alergi
            updateMainAlergiTable();
            updateHiddenAlergiInput();

            //====================================================================================//
            // PEMERIKSAAN FISIK - EDIT MODE
            //====================================================================================//

            // Event listener untuk tombol tambah keterangan
            document.querySelectorAll('.tambah-keterangan').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const keteranganDiv = document.getElementById(targetId);
                    const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector(
                        '.form-check-input');

                    if (keteranganDiv && normalCheckbox) {
                        if (keteranganDiv.style.display === 'none') {
                            keteranganDiv.style.display = 'block';
                            normalCheckbox.checked = false;
                            // Focus pada input keterangan
                            const input = keteranganDiv.querySelector('input');
                            if (input) {
                                setTimeout(() => input.focus(), 100);
                            }
                        } else {
                            keteranganDiv.style.display = 'block';
                        }
                    }
                });
            });

            // Event listener untuk checkbox normal
            document.querySelectorAll('.pemeriksaan-item .form-check-input').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const keteranganDiv = this.closest('.pemeriksaan-item')?.querySelector(
                        '.keterangan');

                    if (keteranganDiv && this.checked) {
                        // Jika checkbox normal diceklis, sembunyikan keterangan dan kosongkan input
                        keteranganDiv.style.display = 'none';
                        const input = keteranganDiv.querySelector('input');
                        if (input) {
                            input.value = '';
                        }
                    }
                });
            });

            // Event listener untuk input keterangan - jika diisi, uncheck normal
            document.querySelectorAll('.keterangan input').forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        const normalCheckbox = this.closest('.pemeriksaan-item')?.querySelector(
                            '.form-check-input');
                        if (normalCheckbox) {
                            normalCheckbox.checked = false;
                        }
                    }
                });
            });

            //====================================================================================//
            // DISCHARGE PLANNING - EDIT MODE
            //====================================================================================//

            const dischargePlanningSection = document.getElementById('discharge-planning');
            const planningSelects = [
                'usia_lanjut',
                'hambatan_mobilisasi',
                'penggunaan_media_berkelanjutan',
                'ketergantungan_aktivitas',
                'keterampilan_khusus',
                'alat_bantu',
                'nyeri_kronis'
            ];

            const alertInfo = document.getElementById('alert-info');
            const alertWarning = document.getElementById('alert-warning');
            const alertSuccess = document.getElementById('alert-success');
            const kesimpulanInput = document.getElementById('kesimpulan');

            function updateDischargePlanningConclusion() {
                let needsSpecialPlan = false;
                let allSelected = true;

                // Cek semua select yang relevan untuk kesimpulan
                const relevantSelects = [
                    'usia_lanjut',
                    'hambatan_mobilisasi',
                    'penggunaan_media_berkelanjutan',
                    'keterampilan_khusus',
                    'alat_bantu',
                    'nyeri_kronis'
                ];

                relevantSelects.forEach(selectId => {
                    const select = document.getElementById(selectId);
                    if (select) {
                        if (!select.value) {
                            allSelected = false;
                        } else if (select.value === 'ya' || select.value === '0') {
                            needsSpecialPlan = true;
                        }
                    }
                });

                // Hide semua alert dulu
                alertInfo.style.display = 'none';
                alertWarning.style.display = 'none';
                alertSuccess.style.display = 'none';

                // Show alert sesuai kondisi
                if (!allSelected) {
                    alertInfo.style.display = 'block';
                    kesimpulanInput.value = 'Pilih semua Planning';
                } else if (needsSpecialPlan) {
                    alertWarning.style.display = 'block';
                    kesimpulanInput.value = 'Mebutuhkan rencana pulang khusus';
                } else {
                    alertSuccess.style.display = 'block';
                    kesimpulanInput.value = 'Tidak mebutuhkan rencana pulang khusus';
                }
            }

            // Add event listeners untuk semua select
            planningSelects.forEach(selectId => {
                const select = document.getElementById(selectId);
                if (select) {
                    select.addEventListener('change', updateDischargePlanningConclusion);
                }
            });

            // Trigger update kesimpulan untuk pertama kali
            updateDischargePlanningConclusion();

            //====================================================================================//
            // DIAGNOSIS - EDIT MODE
            //====================================================================================//

            // Initialize diagnosis management for both types
            if (document.getElementById('diagnosis-banding-input')) {
                initDiagnosisManagementEdit('diagnosis-banding', 'diagnosis_banding');
            }
            if (document.getElementById('diagnosis-kerja-input')) {
                initDiagnosisManagementEdit('diagnosis-kerja', 'diagnosis_kerja');
            }

            function initDiagnosisManagementEdit(prefix, hiddenFieldId) {
                const inputField = document.getElementById(`${prefix}-input`);
                const addButton = document.getElementById(`add-${prefix}`);
                const listContainer = document.getElementById(`${prefix}-list`);
                const hiddenInput = document.getElementById(hiddenFieldId);
                const suggestionsList = document.createElement('div');

                // Style suggestions list
                suggestionsList.className = 'suggestions-list position-absolute bg-white border rounded shadow';
                suggestionsList.style.zIndex = '1000';
                suggestionsList.style.maxHeight = '200px';
                suggestionsList.style.overflowY = 'auto';
                suggestionsList.style.width = 'calc(100% - 30px)';
                suggestionsList.style.display = 'none';

                // Insert suggestions list after input
                inputField.parentNode.insertBefore(suggestionsList, inputField.nextSibling);

                // Database options
                const dbMasterDiagnosis = {!! json_encode($rmeMasterDiagnosis->pluck('nama_diagnosis')) !!};

                // Prepare options array
                const diagnosisOptions = dbMasterDiagnosis.map(text => ({
                    id: text.toLowerCase().replace(/\s+/g, '_'),
                    text: text
                }));

                // Load initial data from hidden input (existing data)
                let diagnosisList = [];
                try {
                    const existingData = hiddenInput.value;
                    if (existingData && existingData !== '[]') {
                        diagnosisList = JSON.parse(existingData);
                    }
                    renderDiagnosisList();
                } catch (e) {
                    console.log(`Error parsing ${prefix} data:`, e);
                    diagnosisList = [];
                    updateHiddenInput();
                }

                // Input event listener for suggestions
                inputField.addEventListener('input', function() {
                    const inputValue = this.value.trim().toLowerCase();

                    if (inputValue) {
                        // Filter database options
                        const filteredOptions = diagnosisOptions.filter(option =>
                            option.text.toLowerCase().includes(inputValue)
                        );

                        // Show suggestions
                        showSuggestions(filteredOptions, inputValue);
                    } else {
                        // Hide suggestions if input is empty
                        suggestionsList.style.display = 'none';
                    }
                });

                // Function to show suggestions
                function showSuggestions(options, inputValue) {
                    suggestionsList.innerHTML = '';

                    if (options.length > 0) {
                        // Render existing options
                        options.forEach(option => {
                            const suggestionItem = document.createElement('div');
                            suggestionItem.className = 'suggestion-item p-2 cursor-pointer hover:bg-light';
                            suggestionItem.style.cursor = 'pointer';

                            // Highlight matching text
                            const text = option.text;
                            const lowerText = text.toLowerCase();
                            const lowerInput = inputValue.toLowerCase();
                            const index = lowerText.indexOf(lowerInput);

                            if (index >= 0) {
                                const before = text.substring(0, index);
                                const match = text.substring(index, index + inputValue.length);
                                const after = text.substring(index + inputValue.length);
                                suggestionItem.innerHTML = `${before}<strong>${match}</strong>${after}`;
                            } else {
                                suggestionItem.textContent = text;
                            }

                            suggestionItem.addEventListener('click', () => {
                                addDiagnosis(option.text);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(suggestionItem);
                        });

                        // Add option to create new if no exact match
                        if (!options.some(opt => opt.text.toLowerCase() === inputValue)) {
                            const newOptionItem = document.createElement('div');
                            newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                            newOptionItem.style.cursor = 'pointer';
                            newOptionItem.innerHTML =
                                `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                            newOptionItem.addEventListener('click', () => {
                                addDiagnosis(inputValue);
                                suggestionsList.style.display = 'none';
                            });
                            suggestionsList.appendChild(newOptionItem);
                        }

                        suggestionsList.style.display = 'block';
                    } else {
                        // If no options, show add new option
                        const newOptionItem = document.createElement('div');
                        newOptionItem.className = 'suggestion-item p-2 cursor-pointer text-primary';
                        newOptionItem.style.cursor = 'pointer';
                        newOptionItem.innerHTML = `<i class="bi bi-plus-circle me-1"></i> Tambah "${inputValue}"`;
                        newOptionItem.addEventListener('click', () => {
                            addDiagnosis(inputValue);
                            suggestionsList.style.display = 'none';
                        });
                        suggestionsList.appendChild(newOptionItem);
                        suggestionsList.style.display = 'block';
                    }
                }

                // Add diagnosis when plus button is clicked
                addButton.addEventListener('click', function() {
                    const diagnosisText = inputField.value.trim();
                    if (diagnosisText) {
                        addDiagnosis(diagnosisText);
                    }
                });

                // Add diagnosis when Enter key is pressed
                inputField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const diagnosisText = this.value.trim();
                        if (diagnosisText) {
                            addDiagnosis(diagnosisText);
                        }
                    }
                });

                // Close suggestions when clicking outside
                document.addEventListener('click', function(e) {
                    if (!inputField.contains(e.target) && !suggestionsList.contains(e.target)) {
                        suggestionsList.style.display = 'none';
                    }
                });

                function addDiagnosis(diagnosisText) {
                    // Check for duplicates
                    if (!diagnosisList.includes(diagnosisText)) {
                        diagnosisList.push(diagnosisText);
                        inputField.value = '';
                        renderDiagnosisList();
                        updateHiddenInput();
                        suggestionsList.style.display = 'none';
                    } else {
                        // Show duplicate feedback
                        alert(`"${diagnosisText}" sudah ada dalam daftar`);
                    }
                }

                function renderDiagnosisList() {
                    listContainer.innerHTML = '';

                    if (diagnosisList.length === 0) {
                        const emptyMessage = document.createElement('div');
                        emptyMessage.className = 'text-muted text-center py-3';
                        emptyMessage.innerHTML =
                            '<i class="bi bi-info-circle me-2"></i>Belum ada diagnosis yang ditambahkan';
                        listContainer.appendChild(emptyMessage);
                    } else {
                        diagnosisList.forEach((diagnosis, index) => {
                            const diagnosisItem = document.createElement('div');
                            diagnosisItem.className =
                                'diagnosis-item d-flex justify-content-between align-items-center mb-2 p-2 bg-white rounded border';

                            const diagnosisSpan = document.createElement('span');
                            diagnosisSpan.innerHTML = `<strong>${index + 1}.</strong> ${diagnosis}`;

                            const deleteButton = document.createElement('button');
                            deleteButton.className = 'btn btn-sm text-danger';
                            deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
                            deleteButton.type = 'button';
                            deleteButton.title = 'Hapus diagnosis';
                            deleteButton.addEventListener('click', function() {
                                diagnosisList.splice(index, 1);
                                renderDiagnosisList();
                                updateHiddenInput();
                            });

                            diagnosisItem.appendChild(diagnosisSpan);
                            diagnosisItem.appendChild(deleteButton);
                            listContainer.appendChild(diagnosisItem);
                        });
                    }
                }

                function updateHiddenInput() {
                    hiddenInput.value = JSON.stringify(diagnosisList);
                }

                // Initialize with existing data
                console.log(`${prefix} initialized with ${diagnosisList.length} items`);
            }

        });
    </script>
@endpush
