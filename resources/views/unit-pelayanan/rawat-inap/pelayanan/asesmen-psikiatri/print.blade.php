<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Medis Psikiatri - {{ $pasien->nama ?? '' }}</title>
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

        .title-sub {
            font-size: 14px;
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

        .fw-bold {
            font-weight: bold;
        }

        .keep-together {
            page-break-inside: avoid;
            display: block;
        }
    </style>
</head>

<body>
    @php
        // Mapping Relasi dari Controller
        $psik = $asesmenPsikiatri;
        $psikDtl = $asesmenPsikiatriDtl;
        $alergi = $alergiPasien;

        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
        $logoData = @file_get_contents($logoPath);
        $logoBase64 = $logoData ? 'data:image/png;base64,' . base64_encode($logoData) : null;

        // Helper Decode JSON
        $decode = function ($val) {
            if (empty($val)) {
                return [];
            }
            $d = is_string($val) ? json_decode($val, true) : $val;
            return is_array($d) ? $d : [];
        };

        // Prognosis Label
        $prognosisLabel = '-';
        if (!empty($psikDtl->prognosis)) {
            $prognosisLabel =
                \App\Models\SatsetPrognosis::where('prognosis_id', $psikDtl->prognosis)->value('value') ??
                $psikDtl->prognosis;
        }
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
                    <span class="title-main">ASESMEN MEDIS PSIKIATRI</span>
                    <span class="title-sub">PENGKAJIAN AWAL MEDIS PSIKIATRI</span>
                </td>
                <td class="td-right">
                    <div class="unit-box"><span class="unit-text">RAWAT INAP</span></div>
                </td>
            </tr>
        </table>

        <table class="patient-table">
            <tr>
                <th>No. RM</th>
                <td>{{ $pasien->kd_pasien ?? '-' }}</td>
                <th>Tgl. Lahir</th>
                <td>{{ !empty($pasien->tgl_lahir) ? date('d-m-Y', strtotime($pasien->tgl_lahir)) : '-' }}</td>
            </tr>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $pasien->nama ?? '-' }}</td>
                <th>Jenis Kelamin</th>
                <td>{{ ($pasien->jenis_kelamin ?? '') == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
        </table>

        <div class="section-title">1. DATA MASUK</div>
        <table>
            <tr>
                <td class="label">Tanggal & Jam Pengisian</td>
                <td class="value">
                    {{ !empty($asesmen->waktu_asesmen) ? date('d-m-Y / H:i', strtotime($asesmen->waktu_asesmen)) : '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Kondisi Masuk</td>
                <td class="value">{{ $psik->kondisi_masuk ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Diagnosis Masuk</td>
                <td class="value">{{ $psik->diagnosis_masuk ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">2. PENGKAJIAN MEDIS</div>
        <table>
            <tr>
                <td class="label">Anamnesis</td>
                <td class="value">{{ $psik->anamnesis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Keluhan Utama</td>
                <td class="value">{{ $psik->keluhan_utama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Sensorium</td>
                <td class="value">{{ $psik->sensorium ?? '-' }}</td>
            </tr>
        </table>

        <table class="table-border" style="margin-top: 10px;">
            <tr class="bg-gray">
                <th colspan="4" style="text-align: left;">TANDA VITAL & FISIK</th>
            </tr>
            <tr>
                <td width="25%"><strong>TD:</strong>
                    {{ $psik->tekanan_darah_sistole ?? '-' }}/{{ $psik->tekanan_darah_diastole ?? '-' }} mmHg</td>
                <td width="25%"><strong>Suhu:</strong> {{ $psik->suhu ?? '-' }} °C</td>
                <td width="25%"><strong>Nadi:</strong> {{ $psik->nadi ?? '-' }} x/mnt</td>
                <td width="25%"><strong>Respirasi:</strong> {{ $psik->respirasi ?? '-' }} x/mnt</td>
            </tr>
            <tr>
                <td><strong>Skala Nyeri:</strong> {{ $psik->skala_nyeri ?? '-' }}</td>
                <td><strong>Kategori Nyeri:</strong> {{ $psik->kategori_nyeri ?? '-' }}</td>
                <td><strong>ADL:</strong> {{ $psik->adl ?? '-' }}</td>
                <td><strong>Resiko Jatuh:</strong> {{ $psik->resiko_jatuh ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Alat Bantu:</strong> {{ $psik->alat_bantu ?? '-' }}</td>
                <td colspan="2"><strong>Cacat Tubuh:</strong> {{ $psik->cacat_tubuh ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">3. ALERGI</div>
        <table class="table-border">
            <tr class="bg-gray">
                <th>Jenis Alergi</th>
                <th>Alergen</th>
                <th>Reaksi</th>
                <th>Tingkat Keparahan</th>
            </tr>
            @forelse($alergi as $a)
                <tr>
                    <td>{{ $a->jenis_alergi ?? '-' }}</td>
                    <td>{{ $a->nama_alergi ?? '-' }}</td>
                    <td>{{ $a->reaksi ?? '-' }}</td>
                    <td>{{ $a->tingkat_keparahan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data alergi</td>
                </tr>
            @endforelse
        </table>

        <div class="section-title">4. PENGKAJIAN MEDIS (RIWAYAT)</div>
        <table>
            <tr>
                <td class="label">Riwayat Penyakit Sekarang</td>
                <td class="value">{{ $psikDtl->riwayat_penyakit_sekarang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat Penyakit Terdahulu</td>
                <td class="value">{{ $psikDtl->riwayat_penyakit_terdahulu ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat Perkembangan Kanak</td>
                <td class="value">{{ $psikDtl->riwayat_penyakit_perkembangan_masa_kanak ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat Penyakit Dewasa</td>
                <td class="value">{{ $psikDtl->riwayat_penyakit_masa_dewasa ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Terapi yang diberikan</td>
                <td class="value">{{ $psikDtl->terapi_diberikan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat Kesehatan Keluarga</td>
                <td class="value">
                    @php
                        $riwayatKeluarga = json_decode($psikDtl->riwayat_kesehatan_keluarga, true);
                    @endphp
                    {{ is_array($riwayatKeluarga) ? implode(', ', $riwayatKeluarga) : $psikDtl->riwayat_kesehatan_keluarga ?? '-' }}
                </td>
            </tr>
        </table>

        <div class="section-title">5. PEMERIKSAAN FISIK</div>
        <table>
            <tr>
                <td class="label">Pemeriksaan Psikiatri</td>
                <td class="value">{{ $psikDtl->pemeriksaan_psikiatri ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Internis</td>
                <td class="value">{{ $psikDtl->status_internis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Neurologi</td>
                <td class="value">{{ $psikDtl->status_neorologi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Pemeriksaan Penunjang</td>
                <td class="value">{{ $psikDtl->pemeriksaan_penunjang ?? '-' }}</td>
            </tr>
        </table>

        <div class="keep-together">
            <div class="section-title">6. DIAGNOSIS</div>
            <table class="table-border">
                <tr>
                    <td width="30%" class="bg-gray"><strong>Diagnosis Banding</strong></td>
                    <td>{{ implode(', ', $decode($psikDtl->diagnosis_banding)) ?: '-' }}</td>
                </tr>
            </table>
            <table class="table-border" style="margin-top: 5px;">
                <tr>
                    <td width="20%"><strong>Axis I:</strong></td>
                    <td>{{ $psikDtl->axis_i ?? '-' }}</td>
                    <td width="20%"><strong>Axis II:</strong></td>
                    <td>{{ $psikDtl->axis_ii ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Axis III:</strong></td>
                    <td>{{ $psikDtl->axis_iii ?? '-' }}</td>
                    <td><strong>Axis IV:</strong></td>
                    <td>{{ $psikDtl->axis_iv ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Axis V:</strong></td>
                    <td colspan="3">{{ $psikDtl->axis_v ?? '-' }}</td>
                </tr>
            </table>

            <div class="section-title">7. PROGNOSIS DAN THERAPY</div>
            <table>
                <tr>
                    <td class="label">Therapy</td>
                    <td class="value">{{ $psikDtl->therapi ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Prognosis</td>
                    <td class="value">{{ $prognosisLabel }}</td>
                </tr>
            </table>

            <br>
            <table width="100%">
                <tr>
                    <td width="65%"></td>
                    <td align="center">
                        Langsa,
                        {{ !empty($asesmen->waktu_asesmen) ? date('d-m-Y', strtotime($asesmen->waktu_asesmen)) : date('d-m-Y') }}<br>
                        Dokter yang memeriksa,<br><br>
                        @php
                            $namaDok =
                                ($asesmen->user->karyawan->gelar_depan ?? '') .
                                ' ' .
                                ($asesmen->user->karyawan->nama ?? '') .
                                ' ' .
                                ($asesmen->user->karyawan->gelar_belakang ?? '');
                            $namaDok = trim($namaDok);
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
</body>

</html>
