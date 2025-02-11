<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Asesmen Keperawatan & Medis</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        header {
            width: 100%;
            display: table;
            padding-bottom: 30px;
            border-bottom: 2px solid black
        }

        header .left-column {
            display: table-cell;
            width: 20%;
            vertical-align: top;
            text-align: center;
        }

        header .left-column p {
            margin: 5px;
        }

        header .center-column {
            display: table-cell;
            width: auto;
            vertical-align: middle;
            text-align: center;
        }

        header .center-column p {
            font-size: 25px;
            font-weight: 700;
        }

        header .right-column {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }

        header .header-logo {
            width: 80px;
        }

        header .title {
            font-size: 24px;
            font-weight: bold;
        }

        header .info-table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        header .info-table td {
            padding: 8px;
            border: 1px solid black;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }

        .subtitle {
            font-size: 14px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.bordered td,
        table.bordered th {
            border: 1px solid #000;
            padding: 5px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            background-color: #f0f0f0;
            padding: 5px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .col-header {
            font-weight: bold;
            width: 200px;
        }

        .signature-section {
            margin-top: 50px;
        }

        .signature-box {
            float: left;
            width: 45%;
            text-align: center;
        }

        .clear {
            clear: both;
        }

        @page {
            margin: 0.5cm;
        }

        .section table.bordered ul {
            margin: 5px 0;
        }

        .section table.bordered ul li {
            margin: 3px 0;
        }
    </style>
</head>

<body>
    <header>
        <div class="left-column">
            <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" class="header-logo" alt="Logo">
            <p>RSUD Langsa</p>
            <p>Jl. Jend. A. Yani No.1 Kota Langsa</p>
        </div>
        <div class="center-column">
            <p>ASESMEN MEDIS<br>IGD</p>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ $asesmen->kd_pasien }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ str()->title($asesmen->pasien->nama) }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';

                            if ($asesmen->pasien->jenis_kelamin == 1) {
                                $gender = 'Laki-Laki';
                            }
                            if ($asesmen->pasien->jenis_kelamin == 0) {
                                $gender = 'Perempuan';
                            }

                            echo $gender;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ date('d/m/Y', strtotime($asesmen->pasien->tgl_lahir)) }}</td>
                </tr>
            </table>
        </div>
    </header>

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
        <div class="section-title">TINDAKAN RESUSITASI</div>
        <div style="padding: 5px;">
            @php
                $tindakanResusitasi = is_string($asesmen->tindakan_resusitasi)
                    ? json_decode($asesmen->tindakan_resusitasi, true)
                    : (is_array($asesmen->tindakan_resusitasi)
                        ? $asesmen->tindakan_resusitasi
                        : []);
            @endphp
            <table class="bordered">
                <tr>
                    <th>Air Way</th>
                    <th>Breathing</th>
                    <th>Circulation</th>
                </tr>
                <tr>
                    <td>
                        @if (!empty($tindakanResusitasi['air_way']))
                            @foreach ($tindakanResusitasi['air_way'] as $item)
                                • {{ $item }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if (!empty($tindakanResusitasi['breathing']))
                            @foreach ($tindakanResusitasi['breathing'] as $item)
                                • {{ $item }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if (!empty($tindakanResusitasi['circulation']))
                            @foreach ($tindakanResusitasi['circulation'] as $item)
                                • {{ $item }}<br>
                            @endforeach
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
        <div style="padding: 5px;">{{ $asesmen->anamnesis ?? '-' }}</div>
    </div>

    <!-- Riwayat -->
    <div class="section">
        <div class="section-title">RIWAYAT</div>
        <table>
            <tr>
                <td class="col-header">Riwayat Penyakit</td>
                <td>: {{ $asesmen->riwayat_penyakit ?? '-' }}</td>
            </tr>
            <tr>
                <td>Riwayat Penyakit Keluarga</td>
                <td>: {{ $asesmen->riwayat_penyakit_keluarga ?? '-' }}</td>
            </tr>
            <tr>
                <td>Riwayat Pengobatan</td>
                <td>: {{ $asesmen->riwayat_pengobatan ?? '-' }}</td>
            </tr>
            <td>Riwayat Alergi</td>
            <td>:
                @php
                    $riwayatAlergi = is_string($asesmen->riwayat_alergi)
                        ? json_decode($asesmen->riwayat_alergi, true)
                        : $asesmen->riwayat_alergi;
                @endphp
                @if (!empty($riwayatAlergi))
                    @foreach ($riwayatAlergi as $alergi)
                        {{ $alergi['jenis'] }}: {{ $alergi['alergen'] }}
                        (Reaksi: {{ $alergi['reaksi'] }},
                        Keparahan: {{ $alergi['keparahan'] }})
                        @if (!$loop->last)
                            <br>
                        @endif
                    @endforeach
                @else
                    -
                @endif
            </td>
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
        <table class="bordered">
            <tr>
                <td>Tekanan Darah</td>
                <td>: {{ $vitalSign['td_sistole'] ?? '-' }}/{{ $vitalSign['td_diastole'] ?? '-' }} mmHg</td>
                <td>Nadi</td>
                <td>: {{ $vitalSign['nadi'] ?? '-' }} x/menit</td>
            </tr>
            <tr>
                <td>Suhu</td>
                <td>: {{ $vitalSign['suhu'] ?? '-' }} °C</td>
                <td>Respirasi</td>
                <td>: {{ $vitalSign['resp'] ?? '-' }} x/menit</td>
            </tr>
        </table>
    </div>

    <!-- Antropometri Section -->
    {{-- <div class="section">
        <div class="section-title">ANTROPOMETRI</div>
        @php
            $antropometri = is_string($asesmen->antropometri)
                ? json_decode($asesmen->antropometri, true)
                : $asesmen->antropometri;
        @endphp
        <table class="bordered">
            <tr>
                <td width="25%">Tinggi Badan</td>
                <td width="25%">: {{ $antropometri['tb'] ?? '-' }} meter</td>
                <td width="25%">Berat Badan</td>
                <td width="25%">: {{ $antropometri['bb'] ?? '-' }} kg</td>
            </tr>
            <tr>
                <td>Lingkar Kepala</td>
                <td>: {{ $antropometri['ling_kepala'] ?? '-' }} cm</td>
                <td>LPT</td>
                <td>: {{ $antropometri['lpt'] ?? '-' }} cm</td>
            </tr>
            <tr>
                <td>IMT</td>
                <td colspan="3">: {{ $antropometri['imt'] ?? '-' }}</td>
            </tr>
        </table>
    </div> --}}

    <!-- Skala Nyeri Section -->
    <div class="section">
        <div class="section-title">SKALA NYERI</div>
        <table class="bordered" style="margin-bottom: 10px;">
            <tr>
                <!-- Kolom kiri untuk gambar -->
                <td width="40%" style="vertical-align: top; padding: 10px;">
                    <!-- Gunakan placeholder image atau base64 encoded image -->
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/asesmen/asesmen.jpeg'))) }}"
                        style="width: 100%; max-width: 300px;">
                </td>
                <!-- Kolom kanan untuk informasi nyeri -->
                <td width="60%" style="vertical-align: top; padding: 10px;">
                    <table style="width: 100%;">
                        <tr>
                            <td width="40%" style="padding: 3px; border: none;">Skala Nyeri</td>
                            <td width="60%" style="padding: 3px; border: none;">: {{ $asesmen->skala_nyeri ?? '-' }}
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

    <div class="section">
        <div class="section-title">PEMERIKSAAN FISIK</div>
        <table style="border-collapse: separate; border-spacing: 0 2px;">
            @php
                $totalItems = count($asesmen->pemeriksaanFisik);
                $rows = ceil($totalItems / 2);
            @endphp

            @for ($i = 0; $i < $rows; $i++)
                <tr>
                    <!-- Kolom Kiri -->
                    @if (isset($asesmen->pemeriksaanFisik[$i]))
                        @php
                            $pemeriksaanKiri = $asesmen->pemeriksaanFisik[$i];
                            $isNormalKiri = (int) $pemeriksaanKiri->is_normal === 1; // Pastikan integer
                        @endphp
                        <td width="20%" style="border: none;">{{ $pemeriksaanKiri->itemFisik->nama ?? '-' }}</td>
                        <td width="25%" style="border: none;">
                            : {{ $isNormalKiri ? 'Normal' : $pemeriksaanKiri->keterangan ?? '-' }}
                        </td>
                    @else
                        <td width="20%" style="border: none;"></td>
                        <td width="25%" style="border: none;"></td>
                    @endif

                    <!-- Spasi/Jarak -->
                    <td width="10%" style="border: none;"></td>

                    <!-- Kolom Kanan -->
                    @if (isset($asesmen->pemeriksaanFisik[$i + $rows]))
                        @php
                            $pemeriksaanKanan = $asesmen->pemeriksaanFisik[$i + $rows];
                            $isNormalKanan = (int) $pemeriksaanKanan->is_normal === 1; // Pastikan integer
                        @endphp
                        <td width="20%" style="border: none;">{{ $pemeriksaanKanan->itemFisik->nama ?? '-' }}</td>
                        <td width="25%" style="border: none;">
                            : {{ $isNormalKanan ? 'Normal' : $pemeriksaanKanan->keterangan ?? '-' }}
                        </td>
                    @else
                        <td width="20%" style="border: none;"></td>
                        <td width="25%" style="border: none;"></td>
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
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                    </tr>
                    @foreach ($alatTerpasang as $index => $alat)
                        <tr>
                            <td>{{ $index + 1 }}</td>
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
        <div class="section-title">TINDAK LANJUT</div>
        <div class="info">
            @if ($asesmen->tindaklanjut[0] ?? false)
                <table>
                    <tr>
                        <td class="col-header">Status</td>
                        <td>: {{ $asesmen->tindaklanjut[0]['tindak_lanjut_name'] ?? '-' }}</td>
                    </tr>
                    @if (!empty($asesmen->tindaklanjut[0]['keterangan']))
                        <tr>
                            <td class="col-header">Keterangan</td>
                            <td>: {{ $asesmen->tindaklanjut[0]['keterangan'] }}</td>
                        </tr>
                    @endif
                    @if (!empty($asesmen->tindaklanjut[0]['tanggal_meninggal']) && !empty($asesmen->tindaklanjut[0]['jam_meninggal']))
                        <tr>
                            <td class="col-header">Waktu Meninggal</td>
                            <td>: {{ date('d-m-Y', strtotime($asesmen->tindaklanjut[0]['tanggal_meninggal'])) }}
                                {{ $asesmen->tindaklanjut[0]['jam_meninggal'] }}</td>
                        </tr>
                    @endif
                    @if (!empty($asesmen->tindaklanjut[0]['tgl_kontrol_ulang']))
                        <tr>
                            <td class="col-header">Tanggal Kontrol</td>
                            <td>: {{ date('d-m-Y', strtotime($asesmen->tindaklanjut[0]['tgl_kontrol_ulang'])) }}</td>
                        </tr>
                    @endif
                </table>
            @else
                -
            @endif
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-box">
            <p>Dokter</p>
            <br><br><br>
            <p>( {{ $asesmen->user->name ?? '_________________' }} )</p>
            <p>Tanggal: {{ date('d-m-Y H:i', strtotime($asesmen->waktu_asesmen)) }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>

</html>
