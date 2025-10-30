<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Asesmen Keperawatan & Medis</title>
    <style>
        /* ===== Base ===== */
        @page {
            margin: 0.5cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .bordered td,
        .bordered th {
            border: 1px solid #000;
            padding: 5px;
        }

        /* ===== Header (cleaned & centralized) ===== */
        header {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .td-left {
            width: 33%;
            text-align: left;
            vertical-align: middle;
        }

        .td-center {
            width: 33%;
            text-align: center;
            vertical-align: middle;
        }

        .td-right {
            width: 33%;
            text-align: right;
            vertical-align: middle;
        }

        .brand-table {
            border-collapse: collapse;
        }

        .va-middle {
            vertical-align: middle;
        }

        .brand-logo {
            width: 70px;
            height: auto;
            margin-right: 2px;
        }

        .brand-name {
            font-weight: 700;
            margin: 0;
            font-size: 16px;
        }

        .brand-info {
            margin: 0;
            font-size: 8px;
        }

        .form-title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .igd-title {
            font-size: 36px;
            font-weight: 700;
            margin: 0;
        }

        /* ===== Sections ===== */
        .section {
            margin-bottom: 15px;
        }

        .section-title {
            background-color: #f0f0f0;
            padding: 5px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .section-subtitle {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .col-header {
            font-weight: bold;
            width: 200px;
        }

        /* ===== Utilities ===== */
        .w-30 {
            width: 30%;
        }

        .w-33 {
            width: 33%;
        }

        .w-40 {
            width: 40%;
        }

        .w-50 {
            width: 50%;
        }

        .w-60 {
            width: 60%;
        }

        .w-15 {
            width: 15%;
        }

        .w-25 {
            width: 25%;
        }

        .w-35 {
            width: 35%;
        }

        .w-10 {
            width: 10%;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Pemeriksaan fisik (spasi antar baris) */
        .fisik-table {
            border-collapse: separate;
            border-spacing: 0 2px;
        }

        /* ===== Signature block ===== */
        .signature-wrap {
            width: 100%;
            text-align: right;
        }

        .signature-table {
            display: inline-table;
            text-align: right;
        }

        .signature-body {
            display: inline-table;
            text-align: center;
        }

        .signature-gap {
            height: 20px;
        }

        /* ===== Image in Nyeri ===== */
        .nyeri-image {
            width: 100%;
            max-width: 300px;
        }

        /* ===== Removed (UNUSED) selectors =====
           - header .left-column / .center-column / .right-column
           - header .header-logo
           - header .title
           - header .info-table / header .info-table td
           - .logo, .title (generic), .subtitle
           - .signature-section, .signature-box, .clear
           - .section table.bordered ul / li
        */
    </style>
</head>

<body>
    <header>
        <table class="header-table">
            <tr>
                <!-- Kolom 1: Logo + Keterangan -->
                <td class="td-left">
                    <table class="brand-table">
                        <tr>
                            <td class="va-middle">
                                <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa"
                                    class="brand-logo">
                            </td>
                            <td class="va-middle">
                                <p class="brand-name">RSUD Langsa</p>
                                <p class="brand-info">Jl. Jend. A. Yani No.1 Kota Langsa</p>
                                <p class="brand-info">Telp. 0641-22051, email: rsulangsa@gmail.com</p>
                                <p class="brand-info">www.rsud.langsakota.go.id</p>
                            </td>
                        </tr>
                    </table>
                </td>

                <!-- Kolom 2: ASESMEN MEDIS -->
                <td class="td-center">
                    <p class="form-title">FORM GAWAT DARURAT MEDIS</p>
                </td>

                <!-- Kolom 3: IGD -->
                <td class="td-right">
                    <p class="igd-title">IGD</p>
                </td>
            </tr>
        </table>
    </header>

    <div>
        <table>
            <tr>
                <td align="left" class="w-30">No. RM</td>
                <td class="section-subtitle" style="width:2px;">:</td>
                <td>{{ $asesmen->kd_pasien }}</td>
            </tr>
            <tr>
                <td align="left" class="w-30">Nama</td>
                <td class="section-subtitle" style="width:2px;">:</td>
                <td>{{ str()->title($asesmen->pasien->nama) }}</td>
            </tr>
            <tr>
                <td align="left" class="w-30">Jenis Kelamin</td>
                <td class="section-subtitle" style="width:2px;">:</td>
                <td>@php
                    $gender = '-';
                    if ($asesmen->pasien->jenis_kelamin == 1) {
                        $gender = 'Laki-Laki';
                    }
                    if ($asesmen->pasien->jenis_kelamin == 0) {
                        $gender = 'Perempuan';
                    }
                    echo $gender;
                @endphp</td>
            </tr>
            <tr>
                <td align="left" class="w-30">Tanggal Lahir</td>
                <td class="section-subtitle" style="width:2px;">:</td>
                <td>{{ date('d/m/Y', strtotime($asesmen->pasien->tgl_lahir)) }}</td>
            </tr>
        </table>
    </div>

    <!-- Triase Section -->
    <div class="section">
        <div class="section-title">TRIASE</div>
        <div style="padding: 5px;">
            <table class="bordered">
                <tr>
                    <th class="col-header">Warna</th>
                    <th class="col-header">Kesimpulan Triase</th>
                </tr>
                <tr>
                    <td>{{ $triase['warna'] ?? '-' }}</td>
                    <td>{{ $triase['label'] ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tindakan Resusitasi -->
    <div class="section">
        <div class="section-subtitle">TINDAKAN RESUSITASI:</div>
        <div>
            @php
                $tindakanResusitasi = is_string($asesmen->tindakan_resusitasi)
                    ? json_decode($asesmen->tindakan_resusitasi, true)
                    : (is_array($asesmen->tindakan_resusitasi)
                        ? $asesmen->tindakan_resusitasi
                        : []);
            @endphp
            <table>
                <tr>
                    <td align="left" class="w-30">Air Way</td>
                    <td class="section-subtitle" style="width:2px;">:</td>
                    <td>
                        @if (!empty($tindakanResusitasi['air_way']))
                            {{ implode(', ', $tindakanResusitasi['air_way']) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td align="left" class="w-30">Breathing</td>
                    <td class="section-subtitle" style="width:2px;">:</td>
                    <td>
                        @if (!empty($tindakanResusitasi['breathing']))
                            {{ implode(', ', $tindakanResusitasi['breathing']) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td align="left" class="w-30">Circulation</td>
                    <td class="section-subtitle" style="width:2px;">:</td>
                    <td>
                        @if (!empty($tindakanResusitasi['circulation']))
                            {{ implode(', ', $tindakanResusitasi['circulation']) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Anamnesis -->
    <div class="section">
        <div class="section-title">ANAMNESIS</div>
        <table>
            <tr>
                <td align="left" class="w-30 section-subtitle">KELUHAN UTAMA</td>
                <td class="section-subtitle" style="width:2px;">:</td>
                <td>
                    @if (!empty($tindakanResusitasi['air_way']))
                        {{ implode(', ', $tindakanResusitasi['air_way']) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td align="left" class="w-30 section-subtitle">RIWAYAT PENYAKIT</td>
                <td class="section-subtitle" style="width:2px;">:</td>
                <td>{{ $asesmen->riwayat_penyakit ?? '-' }}</td>
            </tr>
            <tr>
                <td align="left" class="w-30 section-subtitle">RIWAYAT PENYAKIT KELUARGA</td>
                <td class="section-subtitle" style="width:2px;">:</td>
                <td>{{ $asesmen->riwayat_penyakit ?? '-' }}</td>
            </tr>
            <tr>
                <td align="left" class="w-30 section-subtitle">RIWAYAT ALERGI</td>
                <td class="section-subtitle" style="width:2px;">:</td>
                <td>
                    @php
                        $riwayatAlergi = is_string($asesmen->riwayat_alergi)
                            ? json_decode($asesmen->riwayat_alergi, true)
                            : $asesmen->riwayat_alergi;
                    @endphp
                    @if (!empty($riwayatAlergi))
                        @foreach ($riwayatAlergi as $alergi)
                            {{ $alergi['jenis'] }}: {{ $alergi['alergen'] }}
                            (Reaksi: {{ $alergi['reaksi'] }}, Keparahan: {{ $alergi['keparahan'] }})
                            @if (!$loop->last)
                                <br>
                            @endif
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Vital Sign -->
    <div class="section">
        <div class="section-title">TANDA VITAL</div>
        @php
            $vitalSign = is_string($asesmen->vital_sign)
                ? json_decode($asesmen->vital_sign, true)
                : $asesmen->vital_sign;
        @endphp
        <table>
            <tr>
                <td class="w-15">Tekanan Darah</td>
                <td class="w-35">: {{ $vitalSign['td_sistole'] ?? '-' }}/{{ $vitalSign['td_diastole'] ?? '-' }} mmHg
                </td>
                <td class="w-15">Nadi</td>
                <td class="w-35">: {{ $vitalSign['nadi'] ?? '-' }} x/menit</td>
            </tr>
            <tr>
                <td class="w-15">Suhu</td>
                <td class="w-35">: {{ $vitalSign['suhu'] ?? '-' }} °C</td>
                <td class="w-15">Respirasi</td>
                <td class="w-35">: {{ $vitalSign['resp'] ?? '-' }} x/menit</td>
            </tr>
        </table>
    </div>

    <!-- Skala Nyeri Section -->
    <div class="section">
        <div class="section-subtitle">SKALA NYERI</div>
        <table class="bordered" style="margin-bottom: 10px;">
            <tr>
                <!-- Kolom kiri untuk gambar -->
                <td class="w-50" style="vertical-align: top; padding: 10px;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/asesmen/asesmen.jpeg'))) }}"
                        class="nyeri-image">
                </td>
                <!-- Kolom kanan untuk informasi nyeri -->
                <td class="w-50" style="vertical-align: top; padding: 10px;">
                    <table style="width: 100%;">
                        <tr>
                            <td class="w-40" style="padding: 3px; border: none;">Skala Nyeri</td>
                            <td class="w-60" style="padding: 3px; border: none;">: {{ $asesmen->skala_nyeri ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 3px; border: none;">Lokasi</td>
                            <td style="padding: 3px; border: none;">: {{ $asesmen->lokasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px; border: none;">Durasi</td>
                            <td style="padding: 3px; border: none;">: {{ $asesmen->durasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px; border: none;">Menjalar</td>
                            <td style="padding: 3px; border: none;">: {{ $asesmen->menjalar->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px; border: none;">Frekuensi</td>
                            <td style="padding: 3px; border: none;">: {{ $asesmen->frekuensiNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px; border: none;">Kualitas</td>
                            <td style="padding: 3px; border: none;">: {{ $asesmen->kualitasNyeri->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px; border: none;">Faktor Pemberat</td>
                            <td style="padding: 3px; border: none;">: {{ $asesmen->faktorPemberat->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px; border: none;">Faktor Peringan</td>
                            <td style="padding: 3px; border: none;">: {{ $asesmen->faktorPeringan->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px; border: none;">Efek Nyeri</td>
                            <td style="padding: 3px; border: none;">: {{ $asesmen->efekNyeri->name ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Pemeriksaan Fisik -->
    <div class="section">
        <div class="section-title">PEMERIKSAAN FISIK</div>
        @php
            $totalItems = count($asesmen->pemeriksaanFisik);
            $rows = ceil($totalItems / 2);
        @endphp
        <table class="fisik-table">
            @for ($i = 0; $i < $rows; $i++)
                <tr>
                    @if (isset($asesmen->pemeriksaanFisik[$i]))
                        @php
                            $pemeriksaanKiri = $asesmen->pemeriksaanFisik[$i];
                            $isNormalKiri = (int) $pemeriksaanKiri->is_normal === 1;
                        @endphp
                        <td class="w-20" style="border: none;">{{ $pemeriksaanKiri->itemFisik->nama ?? '-' }}</td>
                        <td class="w-25" style="border: none;">:
                            {{ $isNormalKiri ? 'Normal' : $pemeriksaanKiri->keterangan ?? '-' }}</td>
                    @else
                        <td class="w-20" style="border: none;"></td>
                        <td class="w-25" style="border: none;"></td>
                    @endif

                    <td class="w-10" style="border: none;"></td>

                    @if (isset($asesmen->pemeriksaanFisik[$i + $rows]))
                        @php
                            $pemeriksaanKanan = $asesmen->pemeriksaanFisik[$i + $rows];
                            $isNormalKanan = (int) $pemeriksaanKanan->is_normal === 1;
                        @endphp
                        <td class="w-20" style="border: none;">{{ $pemeriksaanKanan->itemFisik->nama ?? '-' }}</td>
                        <td class="w-25" style="border: none;">:
                            {{ $isNormalKanan ? 'Normal' : $pemeriksaanKanan->keterangan ?? '-' }}</td>
                    @else
                        <td class="w-20" style="border: none;"></td>
                        <td class="w-25" style="border: none;"></td>
                    @endif
                </tr>
            @endfor
        </table>
    </div>

    <!-- Alat Terpasang -->
    <div class="section">
        <div class="section-title">ALAT TERPASANG</div>
        <div style="padding: 5px;">
            @php
                $alatTerpasang = is_string($asesmen->alat_terpasang)
                    ? json_decode($asesmen->alat_terpasang, true)
                    : (is_array($asesmen->alat_terpasang)
                        ? $asesmen->alat_terpasang
                        : []);
            @endphp

            @if (!empty($alatTerpasang))
                <table class="bordered">
                    <tr>
                        <th>Jenis</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                    </tr>
                    @foreach ($alatTerpasang as $alat)
                        <tr>
                            <td>{{ $alat['nama'] ?? '-' }}</td>
                            <td>{{ $alat['lokasi'] ?? '-' }}</td>
                            <td>{{ $alat['keterangan'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>Tidak ada alat yang diberikan.</p>
            @endif
        </div>
    </div>

    <!-- Diagnosa -->
    <div class="section">
        <div class="section-title">DIAGNOSIS</div>
        <div style="padding: 5px; text-transform: capitalize;">
            @php
                $diagnosis = is_string($asesmen->diagnosis)
                    ? json_decode($asesmen->diagnosis, true)
                    : $asesmen->diagnosis;
            @endphp
            @if (!empty($diagnosis))
                @foreach ($diagnosis as $index => $item)
                    {{ $index + 1 }}. {{ $item }}@if (!$loop->last)
                        <br>
                    @endif
                @endforeach
            @else
                -
            @endif
        </div>
    </div>

    <!-- Kondisi Pasien -->
    <div class="section">
        <div class="section-title">KONDISI PASIEN SEBELUM MENINGGALKAN IGD</div>
        <div style="padding: 5px;">
            {{ $asesmen->kondisi_pasien ?? '-' }}
        </div>
    </div>

    <!-- Tindak Lanjut -->
    <div class="section">
        <div class="section-title">RENCANA TINDAK LANJUT PELAYANAN</div>
        <div class="info">
            @if ($asesmen->tindaklanjut[0] ?? false)
                <table>
                    <tr>
                        <td class="col-header">Status</td>
                        <td>: {{ $asesmen->tindaklanjut[0]['tindak_lanjut_name'] ?? '-' }}</td>
                    </tr>

                    @switch($asesmen->tindaklanjut[0]['tindak_lanjut_code'])
                        @case('1')
                            {{-- Rawat Inap --}}
                            <tr>
                                <td class="col-header">Keterangan</td>
                                <td>: {{ $asesmen->tindaklanjut[0]['keterangan'] ?? '-' }}</td>
                            </tr>
                        @break

                        @case('7')
                            {{-- Kamar Operasi --}}
                            <tr>
                                <td class="col-header">Kamar Operasi</td>
                                <td>: {{ $asesmen->tindaklanjut[0]['keterangan'] ?? '-' }}</td>
                            </tr>
                        @break

                        @case('5')
                            {{-- Rujuk RS Lain --}}
                            <tr>
                                <td class="col-header">Tujuan Rujuk</td>
                                <td>: {{ $asesmen->tindaklanjut[0]['tujuan_rujuk'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-header">Alasan Rujuk</td>
                                <td>: {{ $asesmen->tindaklanjut[0]['alasan_rujuk'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-header">Transportasi</td>
                                <td>: {{ $asesmen->tindaklanjut[0]['transportasi_rujuk'] ?? '-' }}</td>
                            </tr>
                        @break

                        @case('6')
                            {{-- Pulang Sembuh --}}
                            <tr>
                                <td class="col-header">Tanggal Pulang</td>
                                <td>: {{ date('d-m-Y', strtotime($asesmen->tindaklanjut[0]['tanggal_pulang'])) ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-header">Jam Pulang</td>
                                <td>: {{ substr($asesmen->tindaklanjut[0]['jam_pulang'], 11, 5) ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-header">Alasan Pulang</td>
                                <td>: {{ alasanPulangLabel($asesmen->tindaklanjut[0]['alasan_pulang']) ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-header">Kondisi Pulang</td>
                                <td>: {{ kondisiPulangLabel($asesmen->tindaklanjut[0]['kondisi_pulang']) ?? '-' }}</td>
                            </tr>
                        @break

                        @case('8')
                            {{-- Berobat Jalan --}}
                            <tr>
                                <td class="col-header">Tanggal Berobat</td>
                                <td>: {{ date('d-m-Y', strtotime($asesmen->tindaklanjut[0]['tanggal_rajal'])) ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="col-header">Poli Tujuan</td>
                                <td>: {{ $asesmen->tindaklanjut[0]['poli_unit_tujuan'] ?? '-' }}</td>
                            </tr>
                        @break

                        @case('9')
                            {{-- Menolak Rawat Inap --}}
                            <tr>
                                <td class="col-header">Alasan Menolak</td>
                                <td>: {{ $asesmen->tindaklanjut[0]['keterangan'] ?? '-' }}</td>
                            </tr>
                        @break

                        @case('10')
                            {{-- Meninggal Dunia --}}
                            <tr>
                                <td class="col-header">Tanggal Meninggal</td>
                                <td>: {{ date('d-m-Y', strtotime($asesmen->tindaklanjut[0]['tanggal_meninggal'])) ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-header">Jam Meninggal</td>
                                <td>: {{ substr($asesmen->tindaklanjut[0]['jam_meninggal'], 11, 5) ?? '-' }}</td>
                            </tr>
                        @break

                        @case('11')
                            {{-- DOA --}}
                            <tr>
                                <td class="col-header">Tanggal DOA</td>
                                <td>: {{ date('d-m-Y', strtotime($asesmen->tindaklanjut[0]['tanggal_meninggal'])) ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="col-header">Jam DOA</td>
                                <td>: {{ substr($asesmen->tindaklanjut[0]['jam_meninggal'], 11, 5) ?? '-' }}</td>
                            </tr>
                        @break
                    @endswitch
                </table>
            @else
                -
            @endif
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-wrap">
        <table class="signature-table">
            <tbody class="signature-body">
                <tr>
                    <td>Dokter Jaga IGD</td>
                </tr>
                <tr>
                    <td class="signature-gap"></td>
                </tr>
                <tr>
                    <td class="signature-gap"></td>
                </tr>
                <tr>
                    <td>{{ $asesmen->user->name ?? '_________________' }}</td>
                </tr>
                <tr>
                    <td>Tanggal: {{ date('d-m-Y H:i', strtotime($asesmen->waktu_asesmen)) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
