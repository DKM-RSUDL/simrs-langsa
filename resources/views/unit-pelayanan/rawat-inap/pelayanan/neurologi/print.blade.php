<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Asesmen Neurologi</title>
    <style>
        @page {
            margin: 0.5cm 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            width: 100%;
            display: table;
            padding-bottom: 10px;
            border-bottom: 2px solid black;
            margin-bottom: 15px;
        }

        .left-column {
            float: left;
            width: 20%;
            text-align: center;
        }

        .center-column {
            float: left;
            width: 40%;
            text-align: center;
            padding: 10px 0;
        }

        .right-column {
            float: right;
            width: 35%;
        }

        .header-logo {
            width: 80px;
            margin-bottom: 5px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px;
            border: 1px solid #333;
        }

        .clear {
            clear: both;
        }

        .content-section {
            margin-top: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #f5f5f5;
            padding: 5px;
            font-weight: bold;
            border-left: 3px solid #333;
            margin-bottom: 10px;
            margin-top: 15px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .detail-table th,
        .detail-table td {
            padding: 4px;
            border: 1px solid #333;
            font-size: 10px;
        }

        .sign-area {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .sign-box {
            float: right;
            width: 200px;
            text-align: center;
        }

        .sign-box p {
            margin: 5px 0;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            margin-bottom: 10px;
        }

        .col-6 {
            width: 50%;
            float: left;
            padding-right: 5px;
            box-sizing: border-box;
        }

        .col-12 {
            width: 100%;
            float: left;
            box-sizing: border-box;
        }

        .col-3 {
            width: 25%;
            float: left;
            padding-right: 5px;
            box-sizing: border-box;
        }

        .col-4 {
            width: 33.33%;
            float: left;
            padding-right: 5px;
            box-sizing: border-box;
        }

        .form-label {
            font-weight: bold;
            display: block;
            margin-bottom: 3px;
        }

        .border-bottom {
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
            min-height: 15px;
        }

        .text-muted {
            color: #777;
            font-style: italic;
        }

        .badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }

        .bg-success {
            background-color: #28a745;
            color: white;
        }

        .bg-warning {
            background-color: #ffc107;
            color: #333;
        }

        .bg-danger {
            background-color: #dc3545;
            color: white;
        }

        .bg-info {
            background-color: #17a2b8;
            color: white;
        }

        .bg-secondary {
            background-color: #6c757d;
            color: white;
        }

        .text-primary {
            color: #0275d8;
        }

        h5 {
            font-size: 12px;
            margin: 10px 0;
        }

        h6 {
            font-size: 11px;
            margin: 8px 0;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <header>
        <div class="left-column">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}" class="header-logo" alt="Logo">
            <p>RSUD Langsa</p>
            <p>Jl. Jend. A. Yani No.1 Kota Langsa</p>
        </div>
        <div class="center-column">
            <h1 style="font-size: 16px;">Formulir Asesmen Neurologi</h1>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ optional($pasien)->kd_pasien ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ optional($pasien)->nama ? str()->title(optional($pasien)->nama) : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';
                            if (isset($pasien->jenis_kelamin)) {
                                if ($pasien->jenis_kelamin == 1) {
                                    $gender = 'Laki-Laki';
                                }
                                if ($pasien->jenis_kelamin == 0) {
                                    $gender = 'Perempuan';
                                }
                            }
                            echo $gender;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ optional($pasien)->tgl_lahir ? date('d/m/Y', strtotime(optional($pasien)->tgl_lahir)) : '-' }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
    </header>

    <!-- 2. Anamnesis -->
    <div class="section-title">Anamnesis</div>
    <table class="detail-table">
        <tr>
            <td width="25%" style="font-weight: bold;">Keluhan Utama</td>
            <td colspan="3">{{ $asesmen->rmeAsesmenNeurologi->keluhan_utama ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Riwayat Penyakit Sekarang</td>
            <td colspan="3">{{ $asesmen->rmeAsesmenNeurologi->riwayat_penyakit_sekarang ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Riwayat Penyakit Terdahulu</td>
            <td colspan="3">{{ $asesmen->rmeAsesmenNeurologi->riwayat_penyakit_terdahulu ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Riwayat Penyakit Keluarga</td>
            <td colspan="3">{{ $asesmen->rmeAsesmenNeurologi->riwayat_penyakit_keluarga ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Riwayat Pengobatan</td>
            <td colspan="3">
                @if (isset($asesmen->rmeAsesmenNeurologi->riwayat_pengobatan))
                    @if ($asesmen->rmeAsesmenNeurologi->riwayat_pengobatan === 0)
                        Tidak Ada
                    @elseif ($asesmen->rmeAsesmenNeurologi->riwayat_pengobatan === 1)
                        Ada
                        @if ($asesmen->rmeAsesmenNeurologi->riwayat_pengobatan_keterangan)
                            - {{ $asesmen->rmeAsesmenNeurologi->riwayat_pengobatan_keterangan }}
                        @endif
                    @else
                        Tidak Diketahui
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>
   
    <!-- 3. Riwayat Alergi -->
    <div class="section-title">Riwayat Alergi</div>
    @php
        $alergiData = [];
        if (isset($alergiPasien) && $alergiPasien) {
            try {
                $alergiData = json_decode($alergiPasien, true);
                if (!is_array($alergiData)) {
                    $alergiData = [];
                }
            } catch (\Exception $e) {
                $alergiData = [];
            }
        }
      
    @endphp
    

    @if (!empty($alergiData))
        <table class="detail-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Jenis</th>
                    <th width="35%">Alergen</th>
                    <th width="40%">Reaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alergiData as $index => $alergi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $alergi['jenis_alergi'] ?? '-' }}</td>
                        <td>{{ $alergi['nama_alergi'] ?? '-' }}</td>
                        <td>{{ $alergi['reaksi'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Tidak ada data alergi</p>
    @endif

    <!-- 4. Status Present / Pemeriksaan Fisik -->
    <div class="section-title">Status Present</div>
    <table class="detail-table">
        <tr>
            <td width="25%" style="font-weight: bold;">Tekanan Darah</td>
            <td width="25%">{{ $asesmen->rmeAsesmenNeurologi->darah_sistole ?? '-' }} mmHg</td>
            <td width="25%" style="font-weight: bold;">Suhu</td>
            <td width="25%">{{ $asesmen->rmeAsesmenNeurologi->suhu ?? '-' }} °C</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nadi</td>
            <td>{{ $asesmen->rmeAsesmenNeurologi->nadi ?? '-' }} x/menit</td>
            <td style="font-weight: bold;">Respirasi</td>
            <td>{{ $asesmen->rmeAsesmenNeurologi->respirasi ?? '-' }} x/menit</td>
        </tr>
    </table>

    @if ($asesmen->pemeriksaanFisik->isNotEmpty())
        <div style="margin-top: 10px; margin-bottom: 10px;">
            <strong>Pemeriksaan Fisik</strong>
        </div>

        @php
            $pemeriksaanFisikData = $asesmen->pemeriksaanFisik;
            $itemFisikNames = [];
            foreach ($itemFisik as $item) {
                $itemFisikNames[$item->id] = $item->nama;
            }

            $totalItems = count($pemeriksaanFisikData);
            $halfCount = ceil($totalItems / 2);
            $firstColumn = $pemeriksaanFisikData->take($halfCount);
            $secondColumn = $pemeriksaanFisikData->skip($halfCount);
        @endphp

        <table class="detail-table">
            <thead>
                <tr>
                    <th width="30%">Item</th>
                    <th width="20%">Status</th>
                    <th width="50%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemeriksaanFisikData as $item)
                    @php
                        $status = $item->is_normal;
                        $keterangan = $item->keterangan;
                        $itemId = $item->id_item_fisik;
                        $namaItem = $itemFisikNames[$itemId] ?? 'Item #' . $itemId;

                        $statusText = "Tidak Diperiksa";
                        if ($status == '0' || $status == 0) {
                            $statusText = "Tidak Normal";
                        } elseif ($status == '1' || $status == 1) {
                            $statusText = "Normal";
                        }
                    @endphp
                    <tr>
                        <td>{{ $namaItem }}</td>
                        <td>{{ $statusText }}</td>
                        <td>{{ ($status == '0' || $status == 0) && $keterangan ? $keterangan : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- 5. Sistem Syaraf -->
    @if ($asesmen->rmeAsesmenNeurologiSistemSyaraf)
        <div class="section-title">Sistem Syaraf</div>

        <!-- Kesadaran -->
        <div style="margin-top: 10px; margin-bottom: 5px;">
            <strong>Kesadaran</strong>
        </div>
        <table class="detail-table">
            <tr>
                <td width="25%" style="font-weight: bold;">Kesadaran Kualitatif</td>
                <td width="25%">{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif ?? '-' }}</td>
                <td width="25%" style="font-weight: bold;">Kesadaran Kuantitatif (GCS)</td>
                <td width="25%">
                    E: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif_e ?? '-' }},
                    M: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif_m ?? '-' }},
                    V: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kesadaran_kulitatif_v ?? '-' }}
                </td>
            </tr>
        </table>

        <!-- Pupil -->
        <div style="margin-top: 10px; margin-bottom: 5px;">
            <strong>Pupil</strong>
        </div>
        <table class="detail-table">
            <tr>
                <td width="25%" style="font-weight: bold;">Isokor/anisokor</td>
                <td width="25%">{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_isokor ?? '-' }}</td>
                <td width="25%" style="font-weight: bold;">Refleks cahaya</td>
                <td width="25%">
                    Kiri: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_cahaya_kiri ?? '-' }} /
                    Kanan: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_cahaya_kanan ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Diameter</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_anisokor ?? '-' }} mm</td>
                <td style="font-weight: bold;">Refleks kornea</td>
                <td>
                    Kiri: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_kornea_kiri ?? '-' }} /
                    Kanan: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->pupil_kornea_kanan ?? '-' }}
                </td>
            </tr>
        </table>

        <!-- Nervus Cranialis -->
        <table class="detail-table" style="margin-top: 10px;">
            <tr>
                <td width="25%" style="font-weight: bold;">Nervus Cranialis</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->nervus_cranialis ?? '-' }}</td>
            </tr>
        </table>

        <!-- Ekstremitas dan Refleks -->
        <div style="margin-top: 10px; margin-bottom: 5px;">
            <strong>Ekstremitas & Refleks</strong>
        </div>
        <table class="detail-table">
            <thead>
                <tr>
                    <th width="20%"></th>
                    <th width="20%">Atas Kanan</th>
                    <th width="20%">Atas Kiri</th>
                    <th width="20%">Bawah Kanan</th>
                    <th width="20%">Bawah Kiri</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight: bold;">Ekstremitas Gerakan</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_atas ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_kanan ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_bawah ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ekstremitas_kiri ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Refleks</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_atas ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_kanan ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_bawah ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_kiri ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Refleks Patologis</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_atas ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_kanan ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_bawah ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->refleks_patologis_kiri ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Kekuatan</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_atas ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_kanan ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_bawah ?? '-' }}</td>
                    <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kekuatan_kiri ?? '-' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Tes Bilateral -->
        <div style="margin-top: 10px; margin-bottom: 5px; page-break-inside: avoid;">
            <strong>Tes Bilateral</strong>
        </div>
        <table class="detail-table">
            <tr>
                <td width="25%" style="font-weight: bold;">Klonus</td>
                <td width="25%">
                    Kiri: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->klonus_kiri ?? '-' }} /
                    Kanan: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->klonus_kanan ?? '-' }}
                </td>
                <td width="25%" style="font-weight: bold;">Laseque</td>
                <td width="25%">
                    Kiri: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->laseque_kiri ?? '-' }} /
                    Kanan: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->laseque_kanan ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Patrick</td>
                <td>
                    Kiri: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->patrick_kiri ?? '-' }} /
                    Kanan: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->patrick_kanan ?? '-' }}
                </td>
                <td style="font-weight: bold;">Kontra Patrick</td>
                <td>
                    Kiri: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kontra_kiri ?? '-' }} /
                    Kanan: {{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kontra_kanan ?? '-' }}
                </td>
            </tr>
        </table>

        <!-- Tes Meningeal -->
        <div style="margin-top: 10px; margin-bottom: 5px; page-break-inside: avoid;">
            <strong>Tes Meningeal</strong>
        </div>
        <table class="detail-table">
            <tr>
                <td width="33%" style="font-weight: bold;">Kaku Kuduk</td>
                <td width="33%" style="font-weight: bold;">Tes Brudzinski</td>
                <td width="34%" style="font-weight: bold;">Tanda Kernig</td>
            </tr>
            <tr>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->kaku_kuduk ?? '-' }}</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tes_brudzinski ?? '-' }}</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tanda_kerning ?? '-' }}</td>
            </tr>
        </table>

        <!-- Tanda Cerebellum -->
        <div style="margin-top: 10px; margin-bottom: 5px; page-break-inside: avoid;">
            <strong>Tanda Cerebellum</strong>
        </div>
        <table class="detail-table">
            <tr>
                <td width="33%" style="font-weight: bold;">Nistagmus</td>
                <td width="33%" style="font-weight: bold;">Dismitri</td>
                <td width="34%" style="font-weight: bold;">Disdiadokokinesis</td>
            </tr>
            <tr>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->nistagmus ?? '-' }}</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->dismitri ?? '-' }}</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->disdiadokokinesis ?? '-' }}</td>
            </tr>
        </table>

        <!-- Tes Koordinasi -->
        <div style="margin-top: 10px; margin-bottom: 5px; page-break-inside: avoid;">
            <strong>Tes Koordinasi</strong>
        </div>
        <table class="detail-table">
            <tr>
                <td width="33%" style="font-weight: bold;">Tes Romberg</td>
                <td width="33%" style="font-weight: bold;">Ataksia</td>
                <td width="34%" style="font-weight: bold;">Cara Berjalan</td>
            </tr>
            <tr>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tes_romberg ?? '-' }}</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->ataksia ?? '-' }}</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->cara_berjalan ?? '-' }}</td>
            </tr>
        </table>

        <!-- Gerakan Involunter -->
        <div style="margin-top: 10px; margin-bottom: 5px; page-break-inside: avoid;">
            <strong>Gerakan Involunter</strong>
        </div>
        <table class="detail-table">
            <tr>
                <td width="25%" style="font-weight: bold;">Tremor</td>
                <td width="25%">{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->tremor ?? '-' }}</td>
                <td width="25%" style="font-weight: bold;">Khorea</td>
                <td width="25%">{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->khorea ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Balismus</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->balismus ?? '-' }}</td>
                <td style="font-weight: bold;">Atetose</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->atetose ?? '-' }}</td>
            </tr>
        </table>

        <!-- Sensibilitas dan Fungsi Vegetatif -->
        <div style="margin-top: 10px; margin-bottom: 5px; page-break-inside: avoid;">
            <strong>Sensibilitas dan Fungsi Vegetatif</strong>
        </div>
        <table class="detail-table">
            <tr>
                <td width="100%" style="font-weight: bold;">Sensibilitas</td>
            </tr>
            <tr>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->sensibilitas ?? '-' }}</td>
            </tr>
        </table>

        <table class="detail-table" style="margin-top: 5px;">
            <tr>
                <td width="50%" style="font-weight: bold;">Miksi</td>
                <td width="50%" style="font-weight: bold;">Defekasi</td>
            </tr>
            <tr>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->miksi ?? '-' }}</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiSistemSyaraf->defekasi ?? '-' }}</td>
            </tr>
        </table>
    @endif

    <!-- 6. Intensitas Nyeri -->
    @if ($asesmen->rmeAsesmenNeurologiIntensitasNyeri)
        <div class="section-title">Intensitas Nyeri</div>
        <table class="detail-table">
            <tr>
                <td width="25%" style="font-weight: bold;">Skala Nyeri</td>
                <td width="25%">
                    {{ $asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri ?? '0' }}/10
                    @php
                        $skala = $asesmen->rmeAsesmenNeurologiIntensitasNyeri->skala_nyeri ?? 0;
                        if ($skala == 0) {
                            echo " (Tidak Nyeri)";
                        } elseif ($skala <= 3) {
                            echo " (Nyeri Ringan)";
                        } elseif ($skala <= 6) {
                            echo " (Nyeri Sedang)";
                        } else {
                            echo " (Nyeri Berat)";
                        }
                    @endphp
                </td>
                <td width="25%" style="font-weight: bold;">Lokasi</td>
                <td width="25%">{{ $asesmen->rmeAsesmenNeurologiIntensitasNyeri->lokasi ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Durasi</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiIntensitasNyeri->durasi ?? '-' }}</td>
                <td style="font-weight: bold;">Frekuensi</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiIntensitasNyeri->frekuensi ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Nyeri Hilang Bila</td>
                <td colspan="3">{{ $asesmen->rmeAsesmenNeurologiIntensitasNyeri->nyeri_hilang_bila ?? '-' }}</td>
            </tr>
        </table>
    @endif

    <!-- 7. Diagnosis -->
    <div class="section-title">Diagnosis</div>
    <div style="margin-top: 10px; margin-bottom: 5px; page-break-inside: avoid;">
        <strong>Diagnosis Banding</strong>
    </div>
    @php
        $diagnosisBanding = isset($asesmen->rmeAsesmenNeurologiIntensitasNyeri->diagnosis_banding) ?
            json_decode($asesmen->rmeAsesmenNeurologiIntensitasNyeri->diagnosis_banding, true) : [];
    @endphp

    @if (!empty($diagnosisBanding) && is_array($diagnosisBanding))
        <table class="detail-table">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="90%">Diagnosis Banding</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($diagnosisBanding as $index => $diagnosis)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $diagnosis }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Tidak ada diagnosis banding</p>
    @endif

    <div style="margin-top: 10px; margin-bottom: 5px; page-break-inside: avoid;">
        <strong>Diagnosis Kerja</strong>
    </div>
    @php
        $diagnosisKerja = isset($asesmen->rmeAsesmenNeurologiIntensitasNyeri->diagnosis_kerja) ?
            json_decode($asesmen->rmeAsesmenNeurologiIntensitasNyeri->diagnosis_kerja, true) : [];
    @endphp

    @if (!empty($diagnosisKerja) && is_array($diagnosisKerja))
        <table class="detail-table">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th width="90%">Diagnosis Kerja</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($diagnosisKerja as $index => $diagnosis)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $diagnosis }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Tidak ada diagnosis kerja</p>
    @endif

    <!-- 8. Implementasi -->
    <div class="section-title">Implementasi</div>
    <p><strong>Rencana Penatalaksanaan dan Pengobatan</strong></p>

    <table class="detail-table" style="margin-top: 10px; page-break-inside: avoid;">
        <tr>
            <td colspan="2" style="background-color: #f5f5f5; font-weight: bold;">Rencana Penatalaksanaan</td>
        </tr>
      
        <tr>
            <td width="100%" style="vertical-align: top; padding: 0;">
                <!-- Observasi -->
                <table class="detail-table" style="margin: 0; border-top: none; border-left: none;">
                    @php
                        $observasi = $asesmen->rmeAsesmenNeurologiIntensitasNyeri->rencana_pengobatan ?
                            $asesmen->rmeAsesmenNeurologiIntensitasNyeri->rencana_pengobatan : ''
                    @endphp

                    @if (!empty($observasi))
                        <tr>
                            <td colspan="2" width="90%">{{ $observasi }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="2" style="border-left: none;" class="text-muted">Tidak ada data observasi</td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>

    <!-- Prognosis -->
    
    <table class="detail-table" style="margin-top: 10px; page-break-inside: avoid;">
        <tr>
            <td colspan="2" style="font-weight: bold; background-color: #f9f9f9;">Prognosis</td>
        </tr>
        dd($prognosis);

        @if (!empty($prognosis))
            <tr>
                <td colspan="2" width="10%">{{ $prognosis }}</td>
            </tr>
        @else
            <tr>
                <td colspan="2" class="text-muted">Tidak ada data prognosis</td>
            </tr>
        @endif
    </table>

    <!-- 9. Discharge Planning -->
    @if ($asesmen->rmeAsesmenNeurologiDischargePlanning)
        <div class="section-title">Discharge Planning</div>
        <table class="detail-table">
            <tr>
                <td width="50%" style="font-weight: bold;">Usia lanjut (> 60 th)</td>
                <td width="50%">{{ $asesmen->rmeAsesmenNeurologiDischargePlanning->usia_lanjut == 'ya' ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Hambatan mobilisasi</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiDischargePlanning->hambatan_mobilisasi == 'ya' ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Membutuhkan pelayanan medis berkelanjutan</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiDischargePlanning->pelayanan_medis == 'ya' ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Ketergantungan dengan orang lain dalam aktivitas harian</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiDischargePlanning->ketergantungan == 'ya' ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Rencana Pulang Khusus</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_pulang_khusus ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Rencana Lama Perawatan</td>
                <td>{{ $asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_lama_perawatan ?? '-' }} hari</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Rencana Tanggal Pulang</td>
                <td>
                    @if ($asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_tanggal_pulang)
                        {{ date('d M Y', strtotime($asesmen->rmeAsesmenNeurologiDischargePlanning->rencana_tanggal_pulang)) }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    @endif

    <!-- 10. Evaluasi -->
    <div class="section-title">Evaluasi</div>
    <table class="detail-table">
        <tr>
            <td width="25%" style="font-weight: bold;">Evaluasi Keperawatan</td>
            <td>{{ $asesmen->rmeAsesmenNeurologi->evaluasi_evaluasi_keperawatan ?? '-' }}</td>
        </tr>
    </table>

    <!-- Signature Area -->
    <div class="sign-area">
        <div class="sign-box">
            <p>Perawat yang Melakukan Asesmen Neurologi</p>
            <br><br><br>
            <p>( _________________________ )</p>
            <p>{{ $asesmen->user->name ?? '.............................' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
