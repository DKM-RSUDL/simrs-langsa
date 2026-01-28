<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Pra Anestesi Perawat - {{ $dataMedis->pasien->nama ?? '-' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            color: #333;
        }

        h3,
        p {
            margin: 0;
            padding: 0;
        }

        /* HEADER STYLE */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0f0f0;
            margin-bottom: 15px;
        }

        .header-table td {
            vertical-align: middle;
            padding: 5px;
        }

        .brand-logo {
            width: 60px;
            height: auto;
            margin-right: 2px;
        }

        .brand-name {
            font-weight: 700;
            font-size: 14px;
        }

        .brand-info {
            font-size: 7px;
        }

        .title-main {
            font-size: 16px;
            font-weight: bold;
        }

        .hd-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            text-align: center;
        }

        .hd-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
        }

        /* PATIENT TABLE STYLE */
        .patient-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .patient-table th,
        .patient-table td {
            border: 1px solid #ccc;
            padding: 4px 6px;
            font-size: 9pt;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 120px;
        }

        /* SECTION AND FORM ROW STYLES */
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            background-color: #097dd6;
            /* WARNA BIRU HD */
            color: white;
            padding: 5px;
            margin: 15px 0 5px 0;
        }

        .data-list {
            list-style: none;
            padding-left: 0;
            margin: 5px 0 0 0;
        }

        .data-list li {
            margin-bottom: 2px;
        }

        .form-row {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .form-label,
        .form-value {
            display: table-cell;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .form-label {
            width: 30%;
            font-weight: bold;
        }

        .form-value {
            width: 70%;
            padding-left: 10px;
            text-align: justify;
        }

        .value-box {
            display: block;
            min-height: 20px;
            padding: 5px;
            background-color: #f9f9f9;
        }

        /* TABLE STYLES (untuk TTD dan Verifikasi) */
        .table-verifikasi {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 5px;
        }

        .table-verifikasi th,
        .table-verifikasi td {
            border: 1px solid #ddd;
            padding: 4px 8px;
        }

        .table-verifikasi th {
            background-color: #f0f0f0;
            text-align: center;
        }

        .check-symbol {
            font-family: DejaVu Sans, sans-serif;
            font-weight: bold;
            font-size: 11pt;
        }

        /* TTD STYLES */
        .ttd-container {
            margin-top: 50px;
            width: 100%;
            page-break-inside: avoid;
        }

        .ttd-cell {
            width: 50%;
            text-align: center;
            vertical-align: top;
            border: none;
        }
    </style>
</head>

<body>
    @php
        $pasien = $dataMedis->pasien ?? (object) [];
        $asesmenPerawat = $asesmenPerawat ?? (object) [];
        $perawatNama = $namaPerawat ?? '_________________________';

        // --- HELPER TRANSLATOR ---
        function getStatusMentalText($code)
        {
            $map = ['1' => 'Sadar Penuh', '2' => 'Bingung', '3' => 'Agitasi', '4' => 'Mengantuk', '5' => 'Koma'];
            return $map[$code] ?? '-';
        }
        function getAlatBantuText($code)
        {
            $map = [
                '1' => 'Kacamata',
                '2' => 'Lensa Kontak',
                '3' => 'Gigi Palsu',
                '4' => 'Alat Bantu Dengar',
                '5' => 'Lainnya',
            ];
            return $map[$code] ?? '-';
        }
        function getYesNoText($code)
        {
            $map = ['1' => 'Ya', '0' => 'Tidak'];
            return $map[$code] ?? '-';
        }
        // Variabel $perawat harus tersedia di print view, yang berasal dari controller.
        $id_penerima = $asesmenPerawat->id_perawat_penerima ?? null;
        $perawatPenerimaData = null;
        $namaPerawatPenerimaLengkap = '-';

        if ($id_penerima && isset($perawat)) {
            $perawatPenerimaData = collect($perawat)->firstWhere('kd_karyawan', $id_penerima);
        }

        if ($perawatPenerimaData) {
            $gelarDepan = $perawatPenerimaData->gelar_depan ?? '';
            $gelarBelakang = $perawatPenerimaData->gelar_belakang ?? '';
            $nama = str()->title($perawatPenerimaData->nama ?? '');
            $namaPerawatPenerimaLengkap = trim("{$gelarDepan} {$nama} {$gelarBelakang}");
        }
    @endphp

    {{-- ======================================================= --}}
    {{-- HEADER --}}
    {{-- ======================================================= --}}
    <table class="header-table">
        <tr>
            <td class="td-left" style="width: 40%;">
                <table class="brand-table">
                    <tr>
                        <td class="va-middle" style="width: 60px;"><img
                                src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo"
                                class="brand-logo"></td>
                        <td class="va-middle">
                            <p class="brand-name">RSUD Langsa</p>
                            <p class="brand-info">Jl. Jend. A. Yani No.1 Kota Langsa</p>
                            <p class="brand-info">Telp. 0641-22051, email: rsulangsa@gmail.com</p>
                            <p class="brand-info">www.rsud.langsakota.go.id</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="td-center" style="width: 40%; text-align: center;">
                <span class="title-main">ASESMEN PRA ANESTESI KEPERAWATAN</span>
            </td>
            <td class="td-right" style="width: 20%;">
                <div class="hd-box"><span class="hd-text">PERAWAT</span></div>
            </td>
        </tr>
    </table>

    {{-- INFORMASI PASIEN --}}
    {{-- INFORMASI PASIEN --}}
    <table class="patient-table">
        <tr>
            <th>No. RM</th>
            <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
            <th>Jenis Kelamin</th>
            <td>{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-Laki' : 'Wanita' }}</td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $pasien->nama ?? '-' }}</td>
            <th>Umur</th>
            <td>{{ $pasien->umur ?? '-' }} Tahun</td>
        </tr>
    </table>

    {{-- ======================================================= --}}
    {{-- SECTION 1: CATATAN KEPERAWATAN & VITAL SIGN --}}
    {{-- ======================================================= --}}
    <div class="section-title">1. Catatan Keperawatan Pra-Operasi & Vital Sign</div>

    <div class="form-row">
        <div class="form-label">Tanggal & Jam Masuk</div>
        <div class="form-value">
            : {{ date('d-m-Y', strtotime($asesmenPerawat->tgl_op)) ?? '-' }} Pukul
            {{ date('H:i', strtotime($asesmenPerawat->jam_op)) ?? '-' }} WIB
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Tek. Darah (mmHg)</div>
        <div class="form-value">
            : {{ $asesmenPerawat->sistole ?? '-' }} / {{ $asesmenPerawat->diastole ?? '-' }} mmHg
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Nadi / Nafas / Suhu</div>
        <div class="form-value">
            : {{ $asesmenPerawat->nadi ?? '-' }} | {{ $asesmenPerawat->nafas ?? '-' }} |
            {{ $asesmenPerawat->suhu ?? '-' }}°C
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">TB / BB / IMT / LPT</div>
        <div class="form-value">
            : {{ $asesmenPerawat->tinggi_badan ?? '-' }}cm | {{ $asesmenPerawat->berat_badan ?? '-' }}kg |
            {{ $asesmenPerawat->imt ?? '-' }} | {{ $asesmenPerawat->lpt ?? '-' }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Nilai Skala Nyeri VAS</div>
        <div class="form-value">
            : {{ $asesmenPerawat->skala_nyeri ?? '-' }} / 10
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Status Mental</div>
        <div class="form-value">
            : {{ getStatusMentalText($asesmenPerawat->status_mental) }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Alat Bantu Digunakan</div>
        <div class="form-value">
            : {{ getAlatBantuText($asesmenPerawat->alat_bantu) }}
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- SECTION 2: RIWAYAT & OPERASI --}}
    {{-- ======================================================= --}}
    <div class="form-row">
        <div class="form-label">Riwayat Penyakit Sekarang</div>
        <div class="form-value">
            : {{ implode(', ', $asesmenPerawat->penyakit_sekarang ?? []) }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Riwayat Penyakit Dahulu</div>
        <div class="form-value">
            : {{ implode(', ', $asesmenPerawat->penyakit_dahulu ?? []) }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Jenis/Nama Operasi</div>
        <div class="form-value">
            : {{ implode(', ', $asesmenPerawat->jenis_operasi ?? []) }}
        </div>
    </div>
    <div class="form-row">
        <div class="form-label">Tanggal dibedah dan Tempat</div>
        <div class="form-value">
            : {{ date('d-m-Y', strtotime($asesmenPerawat->tgl_bedah)) ?? '-' }} /
            {{ $asesmenPerawat->tempat_bedah ?? '-' }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Riwayat Alergi (Tabel)</div>
        <div class="form-value">
            @php $alergiList = $asesmenPerawat->alergi ?? []; @endphp
            @if (count($alergiList) > 0)
                <table class="table-verifikasi" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Alergen</th>
                            <th>Reaksi</th>
                            <th>Severe</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alergiList as $alergiJson)
                            @php $alergi = is_string($alergiJson) ? json_decode($alergiJson, true) : $alergiJson; @endphp
                            <tr>
                                <td>{{ $alergi['alergen'] ?? '-' }}</td>
                                <td>{{ $alergi['reaksi'] ?? '-' }}</td>
                                <td>{{ $alergi['severe'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                : Tidak ada riwayat alergi yang dicatat.
            @endif
        </div>
    </div>
    <div class="form-row">
        <div class="form-label">Hasil Laboratorium</div>
        <div class="form-value">
            : @if (!empty($asesmenPerawat->hasil_lab))
                {{ implode(', ', $asesmenPerawat->hasil_lab ?? []) }}
            @else
                -
            @endif
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Hasil Lab Lainnya</div>
        <div class="form-value">
            : {{ $asesmenPerawat->hasil_lab_lainnya ?? '-' }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Batuk / Flu / Demam</div>
        <div class="form-value">
            : {{ $asesmenPerawat->batuk == '1' ? 'Ya' : ($asesmenPerawat->batuk == '0' ? 'Tidak' : '-') }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Pasien Sedang Haid / Menstruasi</div>
        <div class="form-value">
            : {{ $asesmenPerawat->haid == '1' ? 'Ya' : ($asesmenPerawat->haid == '0' ? 'Tidak' : '-') }}
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- SECTION 3: PERSIAPAN OPERASI (VALIDASI CHECKBOX) --}}
    {{-- ======================================================= --}}
    <div class="section-title">3. Persiapan Operasi & Validasi Informasi Pasien</div>

    @php
        // Helper untuk menampilkan status verifikasi
        function displayVerifStatus($item, $savedPerawat, $savedRuangan)
        {
            $checkedPerawat = in_array($item, $savedPerawat) ? '✔' : '';
            $checkedRuangan = in_array($item . '_ruangan', $savedRuangan) ? '✔' : '';
            return "
                <td style='text-align: center; width: 25%;' class='check-symbol'>{$checkedPerawat}</td>
                <td style='text-align: center; width: 25%;' class='check-symbol'>{$checkedRuangan}</td>
            ";
        }
        $vp = $asesmenPerawat->verifikasi_pasien ?? [];
        $vpr = $asesmenPerawat->verifikasi_pasien_ruangan ?? [];
        $pp = $asesmenPerawat->persiapan_fisik_pasien ?? [];
        $ppr = $asesmenPerawat->persiapan_fisik_pasien_ruangan ?? [];
    @endphp

    <p style="font-weight: bold; margin-top: 10px;">Validasi Informasi Pasien</p>
    <table class="table-verifikasi">
        <thead>
            <tr>
                <th style="width: 50%;">Verifikasi Pasien</th>
                <th style="width: 25%;">Perawat Bedah</th>
                <th style="width: 25%;">Perawat Ruangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Periksa identitas pasien</td> {!! displayVerifStatus('identitas_pasien', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>Periksa gelang identitas / gelang operasi / gelang alergi</td> {!! displayVerifStatus('periksa_gelang', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>IPRI dan surat pengantar rawat</td> {!! displayVerifStatus('ipri', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>Jenis dan lokasi pembedahan dipastikan bersama pasien</td> {!! displayVerifStatus('lokasi_pembedahan', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>Periksa kelengkapan persetujuan pembedahan surat ijin operasi</td> {!! displayVerifStatus('persetujuan_operasi', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>Periksa kelengkapan persetujuan anestesi</td> {!! displayVerifStatus('persetujuan_anestesi', $vp, $vpr) !!}
            </tr>
            <tr>
                <td colspan="3" style="font-weight: bold; background-color: #f9f9f9;">Periksa kelengkapan hasil
                    konsultasi :</td>
            </tr>
            <tr>
                <td>1. Cardiologi</td> {!! displayVerifStatus('cardiologi', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>2. Pulmonology</td> {!! displayVerifStatus('pulmonology', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>3. Rehab Medik</td> {!! displayVerifStatus('rehab_medik', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>4. Dietation</td> {!! displayVerifStatus('dietation', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>Surat ketersediaan ICU bila dibutuhkan</td> {!! displayVerifStatus('surat_icu', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>Periksa kelengkapan status rawat inap / rawat jalan</td> {!! displayVerifStatus('kelengkapan_ranap', $vp, $vpr) !!}
            </tr>
            <tr>
                <td>Periksa kelengkapan X-ray / CT-Scan / MRI / EKG / Angiografi / Echo</td> {!! displayVerifStatus('kelengkapan_xray', $vp, $vpr) !!}
            </tr>
        </tbody>
    </table>

    <p style="font-weight: bold; margin-top: 20px;">Persiapan Fisik Pasien</p>
    <table class="table-verifikasi">
        <thead>
            <tr>
                <th style="width: 50%;">Persiapan Fisik Pasien</th>
                <th style="width: 25%;">Perawat Bedah</th>
                <th style="width: 25%;">Perawat Ruangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Puasa / makan dan minum terakhir</td> {!! displayVerifStatus('puasa', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Prothese luar dilepaskan (gigi palsu, lensa kontak)</td> {!! displayVerifStatus('prothese_luar', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Menggunakan prothese dalam (pacemaker, implant, prothese, panggul, VP shunt)</td>
                {!! displayVerifStatus('prothese_dalam', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Penjepit rambut / cat kuku / perhiasan dilepaskan</td> {!! displayVerifStatus('perhiasan', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Persiapan kulit / cukur</td> {!! displayVerifStatus('kulit_cukur', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Pengosongan kandung kemih / clysma</td> {!! displayVerifStatus('clysma', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Memastikan persediaan darah</td> {!! displayVerifStatus('persediaan_darah', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Alat bantu (kacamata, alat bantu dengar) disimpan</td> {!! displayVerifStatus('alat_bantu_disimpan', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Obat yang disertakan</td> {!! displayVerifStatus('obat_disertakan', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Obat terakhir yang diberikan</td> {!! displayVerifStatus('obat_terakhir', $pp, $ppr) !!}
            </tr>
            <tr>
                <td>Vaskulerakses (cimino), dll</td> {!! displayVerifStatus('vaskulerakses', $pp, $ppr) !!}
            </tr>
        </tbody>
    </table>

    {{-- ======================================================= --}}
    {{-- SECTION 4: LAIN-LAIN --}}
    {{-- ======================================================= --}}
    <div class="section-title">Diperiksa Oleh</div>
    <div class="form-row">
        <div class="form-label">Perawat Penerima</div>
        <div class="form-value">
            : {{ $namaPerawatPenerimaLengkap }}
        </div>
    </div>

    <div class="form-row">
        <div class="form-label">Waktu Diperiksa</div>
        <div class="form-value">
            : {{ date('d M Y', strtotime($asesmenPerawat->tgl_periksa ?? '')) }} Pukul
            {{ date('H:i', strtotime($asesmenPerawat->jam_periksa ?? '00:00:00')) }} WIB
        </div>
    </div>

    <div class="section-title">Persiapan Fisik Pasien</div>
    <div class="form-row">
        <div class="form-label">Site Marking (Terlampir)</div>
        <div class="form-value">
            : {{ getYesNoText($asesmenPerawat->site_marking) }}
        </div>
    </div>
    <div class="form-row">
        <div class="form-label">Penjelasan singkat oleh dokter ttg prosedur</div>
        <div class="form-value">
            : {{ getYesNoText($asesmenPerawat->penjelasan_prosedur) }}
        </div>
    </div>
    <div class="ttd-container">
        <table class="no-border" style="width: 100%;">
            <tr class="no-border">
                <td class="ttd-cell" style="width: 50%;">Perawat Ruangan,</td>
                <td class="ttd-cell" style="width: 50%;">Perawat Penerima,</td>
            </tr>
            <tr class="no-border">
                {{-- PERAWAT RUANGAN (DARI userCreate) --}}
                <td class="ttd-cell" style="padding-top: 60px;">
                    ( {{ $namaPerawatRuangan ?? '_____________________' }} )
                </td>

                {{-- PERAWAT PENERIMA (DARI id_perawat_penerima) --}}
                <td class="ttd-cell" style="padding-top: 60px;">
                    ( {{ $namaPerawatPenerimaLengkap ?? '_____________________' }} )
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
