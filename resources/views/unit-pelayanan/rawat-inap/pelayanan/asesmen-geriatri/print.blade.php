<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Medis Geriatri - {{ $dataMedis->pasien->nama ?? '' }}</title>
    <style>
        @page {
            size: A4;
            margin: 3mm 6mm;
        }

        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8.5pt;
        }

        .a4 {
            width: 100%;
            max-width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px 6px;
            vertical-align: top;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0f0f0;
            padding: 0;
            position: relative;
        }

        .td-left {
            width: 40%;
            text-align: left;
            vertical-align: middle;
        }

        .td-center {
            width: 40%;
            text-align: center;
            vertical-align: middle;
        }

        .td-right {
            width: 20%;
            text-align: center;
            vertical-align: middle;
        }

        .brand-name {
            font-weight: 700;
            font-size: 14px;
            margin: 0;
        }

        .brand-info {
            font-size: 7px;
            margin: 0;
        }

        .title-main {
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin: 0;
        }

        .unit-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            width: 100%;
            text-align: center;
        }

        .unit-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
        }

        .patient-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .patient-table th,
        .patient-table td {
            border: 1px solid #ccc;
            padding: 5px 7px;
            font-size: 9pt;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 130px;
        }

        .section-title {
            font-weight: bold;
            font-size: 10.5pt;
            padding: 6px 0 3px 0;
            border-bottom: 1.5px solid #000;
            margin-top: 8px;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .label {
            font-weight: bold;
            width: 35%;
        }

        .value {
            border-bottom: 0.5px dotted #000;
            min-height: 18px;
        }

        .table-border {
            border: 1px solid #000;
            margin-top: 5px;
        }

        .table-border th,
        .table-border td {
            border: 1px solid #000;
            padding: 4px;
        }

        .bg-gray {
            background-color: #f2f2f2;
        }

        .keep-together {
            page-break-inside: avoid;
            display: block;
        }
    </style>
</head>

<body>
    @php
        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
        $logoData = @file_get_contents($logoPath);
        $logoBase64 = $logoData ? 'data:image/png;base64,' . base64_encode($logoData) : null;

        $displayArray = function ($json) {
            $data = is_array($json) ? $json : json_decode($json ?? '[]', true);
            return !empty($data) ? implode(', ', $data) : '-';
        };
    @endphp

    <div class="a4">
        <table class="header-table">
            <tr>
                <td class="td-left">
                    <table>
                        <tr>
                            <td>
                                @if ($logoBase64)
                                    <img src="{{ $logoBase64 }}" style="width:70px;">
                                @endif
                            </td>
                            <td>
                                <p class="brand-name">RSUD Langsa</p>
                                <p class="brand-info">Jl. Jend. A. Yani No.1 Kota Langsa</p>
                                <p class="brand-info">Telp. 0641-22051, email: rsulangsa@gmail.com</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="td-center">
                    <span class="title-main">ASESMEN MEDIS GERIATRI</span>
                    <span style="font-weight: bold; font-size: 12px;">RAWAT INAP</span>
                </td>
                <td class="td-right">
                    <div class="unit-box"><span class="unit-text">RM. 01</span></div>
                </td>
            </tr>
        </table>

        <table class="patient-table">
            <tr>
                <th>No. RM</th>
                <td>{{ $dataMedis->kd_pasien ?? '-' }}</td>
                <th>Tgl. Lahir</th>
                <td>{{ !empty($dataMedis->pasien->tgl_lahir) ? date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}
                </td>
            </tr>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $dataMedis->pasien->nama ?? '-' }}</td>
                <th>Jenis Kelamin</th>
                <td>{{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
        </table>

        <div class="section-title">1. DATA MASUK & ANAMNESIS</div>
        <table>
            <tr>
                <td class="label">Tanggal & Jam Pengisian</td>
                <td class="value">
                    {{ !empty($asesmenGeriatri->waktu_masuk) ? date('d-m-Y / H:i', strtotime($asesmenGeriatri->waktu_masuk)) : '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Kondisi Masuk</td>
                <td class="value">{{ $asesmenGeriatri->kondisi_masuk ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Anamnesis</td>
                <td class="value">{{ $asesmen->anamnesis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Keluhan Utama</td>
                <td class="value">{{ $asesmenGeriatri->keluhan_utama ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">2. TANDA-TANDA VITAL</div>
        <table class="table-border">
            <tr class="bg-gray">
                <th>TD (mmHg)</th>
                <th>Nadi (x/mnt)</th>
                <th>Suhu (&deg;C)</th>
                <th>RR (x/mnt)</th>
                <th>BB (kg)</th>
                <th>TB (cm)</th>
                <th>IMT</th>
            </tr>
            <tr align="center">
                <td>{{ $asesmenGeriatri->sistole }}/{{ $asesmenGeriatri->diastole }}</td>
                <td>{{ $asesmenGeriatri->nadi }}</td>
                <td>{{ $asesmenGeriatri->suhu }}</td>
                <td>{{ $asesmenGeriatri->respirasi }}</td>
                <td>{{ $asesmenGeriatri->berat_badan }}</td>
                <td>{{ $asesmenGeriatri->tinggi_badan }}</td>
                <td>{{ $asesmenGeriatri->imt }} ({{ $displayArray($kategoriImt) }})</td>
            </tr>
        </table>

        <div class="section-title">3. RIWAYAT KESEHATAN & PSIKOSOSIAL</div>
        <table>
            <tr>
                <td class="label">Riwayat Penyakit Sekarang</td>
                <td class="value">{{ $asesmenGeriatri->riwayat_penyakit_sekarang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kondisi Psikologi</td>
                <td class="value">{{ $asesmenGeriatri->kondisi_psikologi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kondisi Sosial Ekonomi</td>
                <td class="value">{{ $asesmenGeriatri->kondisi_sosial_ekonomi ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">4. ASESMEN GERIATRI KHUSUS</div>
        <table class="table-border">
            <tr>
                <td class="label bg-gray">ADL (Brathel Index)</td>
                <td>{{ $displayArray($adl) }}</td>
            </tr>
            <tr>
                <td class="label bg-gray">Kognitif (AMT)</td>
                <td>{{ $displayArray($kognitif) }}</td>
            </tr>
            <tr>
                <td class="label bg-gray">Status Depresi</td>
                <td>{{ $displayArray($depresi) }}</td>
            </tr>
            <tr>
                <td class="label bg-gray">Inkontinensia</td>
                <td>{{ $displayArray($inkontinensia) }}</td>
            </tr>
            <tr>
                <td class="label bg-gray">Insomnia</td>
                <td>{{ $displayArray($insomnia) }}</td>
            </tr>
        </table>

        <div class="keep-together">
            <div class="section-title">5. PEMERIKSAAN FISIK</div>
            <table class="table-border">
                <thead>
                    <tr class="bg-gray">
                        <th width="40%">Item Pemeriksaan</th>
                        <th>Hasil / Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($itemFisik as $item)
                        @php $pf = $pemeriksaanFisik[$item->id] ?? null; @endphp
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $pf ? ($pf->is_normal ? 'Normal' : 'Abnormal: ' . $pf->keterangan) : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="keep-together">
            <div class="section-title">6. RIWAYAT ALERGI</div>
            <table class="table-border">
                <tr class="bg-gray">
                    <th>Jenis Alergi</th>
                    <th>Alergen</th>
                    <th>Reaksi</th>
                    <th>Keparahan</th>
                </tr>
                @forelse($alergiPasien as $a)
                    <tr>
                        <td>{{ $a->jenis_alergi }}</td>
                        <td>{{ $a->nama_alergi }}</td>
                        <td>{{ $a->reaksi }}</td>
                        <td>{{ $a->tingkat_keparahan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" align="center">Tidak ada riwayat alergi</td>
                    </tr>
                @endforelse
            </table>
        </div>

        <div class="keep-together">
            <div class="section-title">7. PERENCANAAN PULANG</div>
            <table class="table-border">
                <tr>
                    <td class="label bg-gray">Usia Lanjut</td>
                    <td>{{ ($rencanaPulang->usia_lanjut ?? '') == '0' ? 'Ya' : 'Tidak' }}</td>
                    <td class="label bg-gray">Hambatan Mobilisasi</td>
                    <td>{{ ($rencanaPulang->hambatan_mobilisasi ?? '') == '0' ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td class="label bg-gray">Alat Bantu</td>
                    <td>{{ $rencanaPulang->memerlukan_alat_bantu ?? '-' }}</td>
                    <td class="label bg-gray">Nyeri Kronis</td>
                    <td>{{ $rencanaPulang->memiliki_nyeri_kronis ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label bg-gray">Kesimpulan</td>
                    <td colspan="3">{{ $rencanaPulang->kesimpulan ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 30px;">
            <br>
            <table width="100%">
                <tr>
                    <td width="65%"></td>
                    <td align="center">
                        Langsa,
                        {{ !empty($asesmen->waktu_asesmen) ? date('d-m-Y', strtotime($asesmen->waktu_asesmen)) : date('d-m-Y') }}<br>
                        Dokter Pemeriksa,<br><br>
                        @php
                            $namaDok = trim(
                                ($asesmen->user->karyawan->gelar_depan ?? '') .
                                    ' ' .
                                    ($asesmen->user->karyawan->nama ?? '') .
                                    ' ' .
                                    ($asesmen->user->karyawan->gelar_belakang ?? ''),
                            );
                        @endphp
                        @if ($namaDok)
                            <img src="{{ generateQrCode($namaDok, 100, 'svg_datauri') }}" alt="QR"><br>
                            <strong>{{ $namaDok }}</strong>
                        @else
                            <br><br><br>( __________________________ )
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
