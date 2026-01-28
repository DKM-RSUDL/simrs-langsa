<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengkajian Keperawatan Gawat Darurat - IGD</title>
    <style>
        @page {
            size: A4;
            margin: 5mm 5mm;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9.5pt;
            line-height: 1.35;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            vertical-align: top;
            padding: 0;
        }

        input[type="text"] {
            border: none;
            border-bottom: 1px solid #000;
            font-family: inherit;
            font-size: inherit;
            background: transparent;
        }

        input[type="checkbox"] {
            width: 5px;
            height: 5px;
            margin-bottom: 10px;
            margin-right: 8px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .small {
            font-size: 8pt;
        }

        .tiny {
            font-size: 7.5pt;
        }

        .rm-box {
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            text-align: center;
            display: inline-block;
            font-size: 8.5pt;
        }

        .input-date {
            width: 20px;
            text-align: center;
        }

        .input-inline {
            width: 40px;
            display: inline-block;
        }

        .input-unit {
            font-size: 8pt;
            margin-left: 3px;
        }

        .sub {
            margin-left: 18px;
        }

        .diagnosis {
            margin: 4px 0;
        }

        .logo {
            width: 45px;
            height: 45px;
            background: #4CAF50;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 8pt;
        }

        .divider {
            width: 4px;
            height: 22px;
            background: #4CAF50;
            display: inline-block;
        }

        .yellow {
            background: #FFD700;
        }

        .igd {
            background: #000;
            color: white;
            font-size: 17pt;
            font-weight: bold;
            padding: 2px 7px;
        }

        .footer {
            font-size: 7.8pt;
            border-top: 1px dashed #999;
            padding-top: 6px;
            margin-top: 18px;
        }

        label {
            font-size: 10px
        }


        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            padding: 0;
            vertical-align: top;
        }

        .sub {
            padding-left: 10px;
        }

        .header {
            background: #ddd;
            font-weight: bold;
            padding: 1.2px 2.5px;
            font-size: 7.8pt;
            border-bottom: 1px solid #000;
        }

        .sub-header {
            background: #eee;
            font-weight: bold;
            padding: 1.2px 2.5px;
            font-size: 7.6pt;
        }

        .cell {
            padding: 1.5px 2.5px;
        }

        .border-r {
            border-right: 1px solid #000;
        }

        .item {
            margin: 0.5px 0;
            display: flex;
            align-items: center;
        }

        .diag {
            margin: 0.5px 0 2px 10px;
            display: flex;
            gap: 5px;
            font-size: 7.2pt;
        }

        .gap {
            margin-top: 1.8px;
        }

        .small {
            font-size: 7pt;
        }

        .center {
            text-align: center;
        }

        .w50 {
            width: 50%;
        }

        .w33 {
            width: 33.3%;
        }

        .bg-yellow {
            background: #fff3cd;
        }

        .bg-blue {
            background: #cce5ff;
        }

        .bg-green {
            background: #d4edda;
        }

        .bg-orange {
            background: #f8d7da;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <!-- Logo + Info Rumah Sakit -->
            <td style="width:35%; vertical-align:top;">
                <table style="border-collapse:collapse;">
                    <tr>
                        <td style="width:60px;">
                            <img width="60"
                                src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}">
                        </td>
                        <td style="padding-left:5px; line-height:1.2;">
                            <div style="font-size:10pt; font-weight:bold;">RSUD Langsa</div>
                            <div style="font-size:8pt;">Jl. Jend. A. Yani No. 1 Kota Langsa</div>
                            <div style="font-size:8pt;">Telp. 0641-22051, email: rsulangsa@gmail.com</div>
                            <div style="font-size:8pt;">www.rsud.langsakota.go.id</div>
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Judul Tengah -->
            <td style="width:45%; text-align:center; vertical-align:middle;">
                <div style="font-size:11pt; font-weight:bold;">PENGKAJIAN KEPERAWATAN </div>
                <div style="font-size:11pt; font-weight:bold;">GAWAT DARURAT</div>
            </td>

            <!-- IGD di kanan -->
            <td style="width:20%; text-align:right; vertical-align:top;">
                <div style="font-size:16pt; font-weight:bold;">IGD</div>
            </td>
        </tr>
    </table>
    <hr style="border:1px solid #000; margin-top:4px;">

    <!-- IDENTITAS PASIEN -->
    @php
        $p = $pasien;
        $tglLahir = \Carbon\Carbon::parse($p->tgl_lahir);
        $usia = $tglLahir->age;
        $tglLahirFormatted = $tglLahir->format('d/m/Y');
    @endphp
    <div style="font-size:11.5pt; font-weight:bold; underline; 0 5px;">I.
        IDENTITAS PASIEN
    </div>
    <table style="width:100%; font-size:9pt; line-height:1.4; border-collapse:collapse; margin-top:4px;">
        <tr>
            <td style="width:25%;">No. RM</td>
            <td style="width:2%;">:</td>
            <td>{{ $p->kd_pasien ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $p->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ ($p->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $tglLahirFormatted }}</td>
        </tr>
    </table>




    <!-- II. ABCD -->
    <div style="font-size:11.5pt; font-weight:bold; underline; 0 5px; margin-top : 5px;">II.
        A. AIRWAY-BREATHING-CIRCULATION-DISABILITY
    </div>

    <!-- A. AIRWAY -->
    @php
        $airway = optional($asesmenKepUmum);
        $tindakan = explode(',', $airway->airway_tindakan ?? '');
    @endphp

    <table style="border:1px solid #000; font-size:8.8pt; margin-top:6px; border-collapse:collapse; width:100%;">
        <tr>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">
                A.Airway</td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">
                Diagnosis Keperawatan</td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">
                Tindakan Keperawatan</td>
        </tr>

        <tr>
            {{-- Pemeriksaan --}}
            <td style="height:250px; width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">

                <div>Status airway: {{ ucfirst($airway->airway_status ?? '-') }}</div>
                @if (($airway->airway_status ?? '') === 'lainnya')
                    <div>Lainnya: {{ $airway->airway_lainnya ?? '-' }}</div>
                @endif
                <div>Suara napas: {{ ucfirst($airway->airway_suara_nafas ?? '-') }}</div>
            </td>

            {{-- Diagnosis --}}
            <td style="width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">

                @if (!empty($airway->airway_diagnosis))
                    <div>- Jalan napas tidak efektif
                        @if ($airway->airway_diagnosis == '1')
                            (Aktual)
                        @elseif($airway->airway_diagnosis == '2')
                            (Risiko)
                        @endif
                    </div>
                @else
                    <div>-</div>
                @endif
            </td>

            {{-- Tindakan --}}
            <td style="width:33.3%; padding:4px 5px; vertical-align:top;">
                @if (!empty($tindakan))
                    @foreach ($tindakan as $item)
                        <div>- {{ preg_replace('/[^A-Za-z0-9\s\/-]/', '', $item) }}</div>
                    @endforeach
                @else
                    <div>-</div>
                @endif
            </td>
        </tr>
    </table>

    @php
        $breathing = $asesmenBreathing;
        $tindakan = isset($breathing->breathing_tindakan) ? explode(',', $breathing->breathing_tindakan) : [];
    @endphp

    <table style="border:1px solid #000; font-size:8.8pt; margin-top:6px; border-collapse:collapse; width:100%;">
        <tr>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">
                B. Breathing</td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">
                Diagnosis Keperawatan</td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">
                Tindakan Keperawatan</td>
        </tr>

        <tr>
            {{-- Pemeriksaan --}}
            <td style="height:250px; width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">

                @if (!empty($breathing->breathing_frekuensi_nafas))
                    <div>Frekuensi napas/menit: {{ $breathing->breathing_frekuensi_nafas }}</div>
                @endif
                @if (!empty($breathing->breathing_pola_nafas))
                    <div>Pola napas: {{ $breathing->breathing_pola_nafas }}</div>
                @endif
                @if (!empty($breathing->breathing_bunyi_nafas))
                    <div>Bunyi napas: {{ $breathing->breathing_bunyi_nafas }}</div>
                @endif
                @if (isset($breathing->breathing_irama_nafas))
                    <div>Irama napas: {{ $breathing->breathing_irama_nafas == '1' ? 'Teratur' : 'Tidak Teratur' }}
                    </div>
                @endif
                @if (!empty($breathing->breathing_tanda_distress))
                    <div>Tanda distress napas: {{ $breathing->breathing_tanda_distress }}</div>
                @endif
                @if (isset($breathing->breathing_jalan_nafas))
                    <div>Jalan napas:
                        {{ $breathing->breathing_jalan_nafas == '1' ? 'Pernafasan Dada' : 'Pernafasan Perut' }}</div>
                @endif
                @if (!empty($breathing->breathing_lainnya))
                    <div>Lainnya: {{ $breathing->breathing_lainnya }}</div>
                @endif
            </td>

            {{-- Diagnosis --}}
            <td style="width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">

                @if (!empty($breathing->breathing_diagnosis_nafas))
                    <div>- Pola napas tidak efektif
                        @if ($breathing->breathing_diagnosis_nafas == '1')
                            (Aktual)
                        @elseif($breathing->breathing_diagnosis_nafas == '2')
                            (Risiko)
                        @endif
                    </div>
                @endif
                @if (!empty($breathing->breathing_gangguan))
                    <div>- Gangguan pertukaran gas
                        @if ($breathing->breathing_gangguan == '1')
                            (Aktual)
                        @elseif($breathing->breathing_gangguan == '2')
                            (Risiko)
                        @endif
                    </div>
                @endif
                @if (empty($breathing->breathing_diagnosis_nafas) && empty($breathing->breathing_gangguan))
                    <div>-</div>
                @endif
            </td>

            {{-- Tindakan --}}
            <td style="width:33.3%; padding:4px 5px; vertical-align:top;">
                @if (!empty($tindakan))
                    @foreach ($tindakan as $item)
                        <div>- {{ preg_replace('/[^A-Za-z0-9\s\/-]/', '', $item) }}</div>
                    @endforeach
                @else
                    <div>-</div>
                @endif
            </td>
        </tr>
    </table>


    <!-- C. CIRCULATION -->
    @php
        $circulation = $asesmenCirculation;
        $tindakan = $circulation->circulation_tindakan ?? '[]';
        $tindakan = json_decode($tindakan, true);
        if ($tindakan === null) {
            $tindakan = explode(',', str_replace(['[', ']', '"'], '', $circulation->circulation_tindakan ?? ''));
        }
    @endphp

    <table style="border:1px solid #000; font-size:8.8pt; margin-top:6px; border-collapse:collapse; width:100%;">
        <tr>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">
                C. Circulation</td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">
                Diagnosis Keperawatan</td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; text-align:center; font-weight:bold;">
                Tindakan Keperawatan</td>
        </tr>

        <tr>
            {{-- Pemeriksaan --}}
            <td style="height:220px; width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">

                <div>Nadi:
                    {{ $circulation->circulation_nadi_irama ?? '-' }}/{{ $circulation->circulation_nadi_kekuatan ?? '-' }}
                </div>
                <div>Tekanan darah (mmHg):
                    {{ $circulation->circulation_sistole ?? '-' }}/{{ $circulation->circulation_diastole ?? '-' }}
                </div>
                <div>Akral: {{ ($circulation->circulation_akral ?? '') == '1' ? 'Normal' : '-' }}</div>
                <div>Pucat: {{ ($circulation->circulation_pucat ?? '') == '1' ? 'Ya' : '-' }}</div>
                <div>Cianosis: {{ ($circulation->circulation_cianosis ?? '') == '1' ? 'Ya' : '-' }}</div>
                <div>Waktu pengisian kapiler: {{ ($circulation->circulation_kapiler ?? '') == '1' ? 'Normal' : '-' }}
                </div>
                <div>Kelembapan kulit: {{ ($circulation->circulation_kelembapan_kulit ?? '') == '1' ? 'Normal' : '-' }}
                </div>
                <div>Turgor kulit: {{ ($circulation->circulation_turgor ?? '') == '1' ? 'Normal' : '-' }}</div>
                <div>Transfusi: {{ ($circulation->circulation_transfusi ?? '') == '1' ? 'Ya' : 'Tidak' }}
                    @if (($circulation->circulation_transfusi ?? '') == '1')
                        (Jumlah: {{ $circulation->circulation_transfusi_jumlah ?? '-' }})
                    @endif
                </div>
                <div>Lainnya: {{ $circulation->circulation_lain ?? '-' }}</div>
            </td>

            {{-- Diagnosis --}}
            <td style="width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">

                @if (!empty($circulation->circulation_diagnosis_perfusi))
                    <div>- Perfusi jaringan tidak efektif
                        @if ($circulation->circulation_diagnosis_perfusi == '1')
                            (Aktual)
                        @elseif($circulation->circulation_diagnosis_perfusi == '2')
                            (Risiko)
                        @endif
                    </div>
                @endif
                @if (!empty($circulation->circulation_diagnosis_defisit))
                    <div>- Risiko syok
                        @if ($circulation->circulation_diagnosis_defisit == '1')
                            (Aktual)
                        @elseif($circulation->circulation_diagnosis_defisit == '2')
                            (Risiko)
                        @endif
                    </div>
                @endif
                @if (empty($circulation->circulation_diagnosis_perfusi) && empty($circulation->circulation_diagnosis_defisit))
                    <div>-</div>
                @endif
            </td>

            {{-- Tindakan --}}
            <td style="width:33.3%; padding:4px 5px; vertical-align:top;">
                @if (!empty($tindakan))
                    @foreach ($tindakan as $item)
                        <div>- {{ preg_replace('/[^A-Za-z0-9\s\/-]/', '', $item) }}</div>
                    @endforeach
                @else
                    <div>-</div>
                @endif
            </td>
        </tr>
    </table>



    <!-- Footer -->
    <table class="footer" style="width:100%; margin-top:18px;">
        <tr>
            <td style="width:50%;">Nomor: A3/IRM/Rev 02/2023</td>
            <td style="text-align:right;">Hal: 1 dari 4</td>
        </tr>
    </table>


    <table style=" border:1px solid #000; font-size:8.8pt; margin-top:6px; border-collapse:collapse; width:100%;">
        <tr>

            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                D. Disability
            </td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                Masalah/Diagnosis Keperawatan
            </td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                Tindakan Keperawatan
            </td>

        </tr>

        <tr>
            {{-- Kolom Pemeriksaan --}}
            <td style="height:240px; width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">
                <div>GCS :
                    {{ !empty(json_decode($asesmenDisability->vital_sign ?? '{}')->gcs) ? json_decode($asesmenDisability->vital_sign)->gcs : '-' }}
                </div>
                <div>Kesadaran :
                    {{ !empty($asesmenDisability->disability_kesadaran) ? $asesmenDisability->disability_kesadaran : '-' }}
                </div>
                <div>Pupil :
                    {{ !empty($asesmenDisability->disability_isokor)
                        ? ($asesmenDisability->disability_isokor == '1'
                            ? 'Isokor'
                            : ($asesmenDisability->disability_isokor == '2'
                                ? 'Anisokor'
                                : '-'))
                        : '-' }},
                    Respon Cahaya :
                    {{ isset($asesmenDisability->disability_respon_cahaya)
                        ? ($asesmenDisability->disability_respon_cahaya == '1'
                            ? 'Ya'
                            : ($asesmenDisability->disability_respon_cahaya == '0'
                                ? 'Tidak'
                                : '-'))
                        : '-' }}
                </div>
                <div>Diameter Pupil :
                    {{ !empty($asesmenDisability->disability_diameter_pupil) ? $asesmenDisability->disability_diameter_pupil . ' mm' : '-' }}
                </div>
                <div>Motorik :
                    {{ isset($asesmenDisability->disability_motorik)
                        ? ($asesmenDisability->disability_motorik == '1'
                            ? 'Ya'
                            : 'Tidak')
                        : '-' }}
                </div>
                <div>Sensorik :
                    {{ isset($asesmenDisability->disability_sensorik)
                        ? ($asesmenDisability->disability_sensorik == '1'
                            ? 'Ya'
                            : 'Tidak')
                        : '-' }}
                </div>
                <div>Kekuatan Otot :
                    {{ !empty($asesmenDisability->disability_kekuatan_otot) ? $asesmenDisability->disability_kekuatan_otot : '-' }}
                </div>
            </td>


            {{-- Kolom Diagnosis --}}
            <td style="width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">

                @php
                    $diagnosisList = [
                        'disability_diagnosis_perfusi' => 'Perfusi jaringan cereberal tidak efektif',
                        'disability_diagnosis_intoleransi' => 'Intoleransi aktivitas',
                        'disability_diagnosis_komunikasi' => 'Kendala komunikasi verbal',
                        'disability_diagnosis_kejang' => 'Kejang ulang',
                        'disability_diagnosis_kesadaran' => 'Penurunan kesadaran',
                    ];
                @endphp
                @foreach ($diagnosisList as $key => $label)
                    @if (!empty($asesmenDisability->$key))
                        <div>- {{ $label }}
                            @php
                                $typeField = $key . '_type';
                                $type = $asesmenDisability->$typeField ?? null;
                            @endphp
                            @if ($type == '1')
                                (Aktual)
                            @elseif($type == '2')
                                (Risiko)
                            @endif
                        </div>
                    @endif
                @endforeach
                @if (!empty($asesmenDisability->disability_lainnya))
                    <div>- {{ $asesmenDisability->disability_lainnya }}</div>
                @endif
            </td>

            {{-- Kolom Tindakan --}}
            <td style="width:33.3%; padding:4px 5px; vertical-align:top;">
                @php
                    $tindakan = json_decode($asesmenDisability->disability_tindakan ?? '[]', true);
                @endphp
                @if (!empty($tindakan))
                    @foreach ($tindakan as $item)
                        <div>- {{ ucwords(strtolower($item)) }}</div>
                    @endforeach
                @else
                    <div>-</div>
                @endif
            </td>
        </tr>
    </table>
    <table style="border:1px solid #000; font-size:8.8pt; margin-top:6px; border-collapse:collapse; width:100%;">
        <tr>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                E. Exposure
            </td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                Masalah/Diagnosis Keperawatan
            </td>
            <td
                style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                Tindakan Keperawatan
            </td>
        </tr>
        <tr>
            {{-- Kolom Pemeriksaan --}}
            <td style="height:230px; width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">

                @php
                    $exp = !empty($asesmenExposure) ? (object) $asesmenExposure : null;

                @endphp

                <div>Deformitas :
                    {{ isset($exp->exposure_deformitas) ? ($exp->exposure_deformitas == '1' ? 'Ya' : 'Tidak') : '-' }}
                    @if (!empty($exp->exposure_deformitas_daerah))
                        ({{ $exp->exposure_deformitas_daerah }})
                    @endif
                </div>

                <div>Kontusion :
                    {{ isset($exp->exposure_kontusion) ? ($exp->exposure_kontusion == '1' ? 'Ya' : 'Tidak') : '-' }}
                    @if (!empty($exp->exposure_kontusion_daerah))
                        ({{ $exp->exposure_kontusion_daerah }})
                    @endif
                </div>

                <div>Abrasi :
                    {{ isset($exp->exposure_abrasi) ? ($exp->exposure_abrasi == '1' ? 'Ya' : 'Tidak') : '-' }}
                    @if (!empty($exp->exposure_abrasi_daerah))
                        ({{ $exp->exposure_abrasi_daerah }})
                    @endif
                </div>

                <div>Penetrasi :
                    {{ isset($exp->exposure_penetrasi) ? ($exp->exposure_penetrasi == '1' ? 'Ya' : 'Tidak') : '-' }}
                    @if (!empty($exp->exposure_penetrasi_daerah))
                        ({{ $exp->exposure_penetrasi_daerah }})
                    @endif
                </div>

                <div>Laserasi :
                    {{ isset($exp->exposure_laserasi) ? ($exp->exposure_laserasi == '1' ? 'Ya' : 'Tidak') : '-' }}
                    @if (!empty($exp->exposure_laserasi_daerah))
                        ({{ $exp->exposure_laserasi_daerah }})
                    @endif
                </div>

                <div>Edema :
                    {{ isset($exp->exposure_edema) ? ($exp->exposure_edema == '1' ? 'Ya' : 'Tidak') : '-' }}
                    @if (!empty($exp->exposure_edema_daerah))
                        ({{ $exp->exposure_edema_daerah }})
                    @endif
                </div>

                <div>Kedalaman Luka :
                    {{ !empty($exp->exposure_kedalaman_luka) ? $exp->exposure_kedalaman_luka . ' cm' : '-' }}
                </div>

                <div>Lainnya :
                    {{ !empty($exp->exposure_lainnya) ? $exp->exposure_lainnya : '-' }}
                </div>
            </td>

            {{-- Kolom Diagnosis --}}
            <td style="width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">
                @php
                    $diagnosisList = [
                        'exposure_diagnosis_mobilitasi' => 'Kerusakan Mobilitas Fisik',
                        'exposure_diagosis_integritas' => 'Kerusakan Integritas Jaringan',
                    ];
                    $hasDiagnosis = false;
                @endphp

                @foreach ($diagnosisList as $key => $label)
                    @if (!empty($exp->$key))
                        @php $hasDiagnosis = true; @endphp
                        <div>- {{ $label }}
                            @php
                                $typeField = $key . '_type';
                                $type = $exp->$typeField ?? $exp->$key;
                            @endphp
                            @if ($type == '1')
                                (Aktual)
                            @elseif($type == '2')
                                (Risiko)
                            @endif
                        </div>
                    @endif
                @endforeach

                @if (!empty($exp->exposure_diagnosis_lainnya))
                    @php $hasDiagnosis = true; @endphp
                    <div>- {{ $exp->exposure_diagnosis_lainnya }}</div>
                @endif

                @if (!$hasDiagnosis)
                    <div>-</div>
                @endif
            </td>

            {{-- Kolom Tindakan --}}
            <td style="width:33.3%; padding:4px 5px; vertical-align:top;">
                @php
                    $tindakan = json_decode($exp->exposure_tindakan ?? '[]', true);
                @endphp

                @if (!empty($tindakan))
                    @foreach ($tindakan as $item)
                        <div>- {{ ucwords(strtolower($item)) }}</div>
                    @endforeach
                @else
                    <div>-</div>
                @endif
            </td>
        </tr>
    </table>

    <h2 style="font-size:10pt;">E. Skala Nyeri</h2>
    <table style="border:1px solid #000; border-collapse:collapse; width:100%; font-size:8pt;">
        <tr>
            <th style="border:1px solid #000; background:#eee; padding:5px; width:50%;">
                A. Numeric Rating Pain Scale
            </th>
            <th style="border:1px solid #000; background:#eee; padding:5px; width:50%;">
                B. Wong Baker Face Pain Scale
            </th>
        </tr>

        <tr>
            {{-- Kolom A - Numeric Scale --}}
            <td style="border:1px solid #000; vertical-align:top; padding:6px;">
                <div style="text-align:center; margin-bottom:6px;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/asesmen/numerik.png'))) }}"
                        width="350px" height="150px">
                </div>

                @php
                    $nyeri = $asesmenSkalaNyeri;
                    $nilai = (int) ($nyeri->skala_nyeri ?? 0);
                @endphp

                <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:8px; line-height:1.6;">
                    <label><input type="checkbox" {{ $nilai === 0 ? 'checked' : '' }}> Tidak Nyeri (0)</label>
                    <label><input type="checkbox" {{ $nilai >= 1 && $nilai <= 3 ? 'checked' : '' }}> Ringan
                        (1–3)</label>
                    <label><input type="checkbox" {{ $nilai >= 4 && $nilai <= 6 ? 'checked' : '' }}> Sedang
                        (4–6)</label>
                    <label><input type="checkbox" {{ $nilai >= 7 && $nilai <= 9 ? 'checked' : '' }}> Berat
                        (7–9)</label>
                    <label><input type="checkbox" {{ $nilai == 10 ? 'checked' : '' }}> Sangat Berat (10)</label>
                </div>
            </td>

            {{-- Kolom B - Wong Baker Face Scale --}}
            <td style="border:1px solid #000; vertical-align:top; padding:6px;">
                <div style="text-align:center; margin-bottom:6px;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/asesmen/asesmen.jpeg'))) }}"
                        width="350px" alt="Wong Baker Pain Scale">
                </div>

                @php
                    $nilaiB = (int) ($nyeri->skala_nyeri_nilai ?? 0);
                @endphp

                <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:8px; line-height:1.6;">
                    <label><input type="checkbox" {{ $nilaiB === 0 ? 'checked' : '' }}> Tidak Nyeri (0)</label>
                    <label><input type="checkbox" {{ $nilaiB === 2 ? 'checked' : '' }}> Ringan (2)</label>
                    <label><input type="checkbox" {{ $nilaiB === 4 ? 'checked' : '' }}> Mengganggu (4)</label>
                    <label><input type="checkbox" {{ $nilaiB === 6 ? 'checked' : '' }}> Menyusahkan (6)</label>
                    <label><input type="checkbox" {{ $nilaiB === 8 ? 'checked' : '' }}> Nyeri Hebat (8)</label>
                    <label><input type="checkbox" {{ $nilaiB === 10 ? 'checked' : '' }}> Sangat Hebat (10)</label>
                </div>
            </td>
        </tr>
    </table>



    <table style="width:100%; border-collapse:collapse; font-family:Arial,sans-serif; font-size:10px;">
        <tr style="height:18px; border:1px solid black;">
            <td style="padding:4px 10px; font-weight:bold; vertical-align:middle; width:160px;">Lokasi nyeri</td>
            <td style="padding:4px 10px; text-align:center; vertical-align:middle;">:</td>
            <td style="padding:4px 10px; vertical-align:middle;">
                <strong>{{ $nyeri->skala_nyeri_lokasi ?? '-' }}</strong>
            </td>
        </tr>

        <tr style="height:18px; border:1px solid black;">
            <td style="padding:4px 10px; font-weight:bold; vertical-align:middle;">Jenis nyeri</td>
            <td style="padding:4px 10px; text-align:center; vertical-align:middle;">:</td>
            <td style="padding:4px 10px; vertical-align:middle;">
                @foreach ($jenisNyeriData as $id => $name)
                    @if (isset($nyeri->skala_nyeri_jenis) && $nyeri->skala_nyeri_jenis_id == $id)
                        <strong>{{ $name }}</strong>
                    @endif
                @endforeach
            </td>
        </tr>

        <tr style="height:18px; border:1px solid black;">
            <td style="padding:4px 10px; font-weight:bold; vertical-align:middle;">Durasi nyeri</td>
            <td style="padding:4px 10px; text-align:center; vertical-align:middle;">:</td>
            <td style="padding:4px 10px; vertical-align:middle;">
                <strong>{{ $nyeri->skala_nyeri_durasi ?? '-' }}</strong>
            </td>
        </tr>

        <tr style="height:18px; border:1px solid black;">
            <td style="padding:4px 10px; font-weight:bold; vertical-align:middle;">Menjalar</td>
            <td style="padding:4px 10px; text-align:center; vertical-align:middle;">:</td>
            <td style="padding:4px 10px; vertical-align:middle;">
                @foreach ($menjalarData as $id => $name)
                    @if (isset($nyeri->skala_nyeri_menjalar_id) && $nyeri->skala_nyeri_menjalar_id == $id)
                        <strong>{{ $name }}</strong>
                    @endif
                @endforeach
            </td>
        </tr>

        <tr style="height:18px; border:1px solid black;">
            <td style="padding:4px 10px; font-weight:bold; vertical-align:middle;">Kualitas nyeri</td>
            <td style="padding:4px 10px; text-align:center; vertical-align:middle;">:</td>
            <td style="padding:4px 10px; vertical-align:middle;">
                @foreach ($kualitasNyeriData as $id => $name)
                    @if (isset($nyeri->skala_nyeri_kualitas_id) && $nyeri->skala_nyeri_kualitas_id == $id)
                        <strong>{{ $name }}</strong>
                    @endif
                @endforeach
            </td>
        </tr>

        <tr style="height:18px; border:1px solid black;">
            <td style="padding:4px 10px; font-weight:bold; vertical-align:middle;">Faktor pemberat</td>
            <td style="padding:4px 10px; text-align:center; vertical-align:middle;">:</td>
            <td style="padding:4px 10px; vertical-align:middle;">
                @foreach ($faktorPemberatData as $id => $name)
                    @if (isset($nyeri->skala_nyeri_pemberat_id) && $nyeri->skala_nyeri_pemberat_id == $id)
                        <strong>{{ $name }}</strong>
                    @endif
                @endforeach
            </td>
        </tr>

        <tr style="height:18px; border:1px solid black;">
            <td style="padding:4px 10px; font-weight:bold; vertical-align:middle;">Faktor peringan</td>
            <td style="padding:4px 10px; text-align:center; vertical-align:middle;">:</td>
            <td style="padding:4px 10px; vertical-align:middle;">
                @foreach ($faktorPeringanData as $id => $name)
                    @if (isset($nyeri->skala_nyeri_peringan_id) && $nyeri->skala_nyeri_peringan_id == $id)
                        <strong>{{ $name }}</strong>
                    @endif
                @endforeach
            </td>
        </tr>

        <tr style="height:18px; border:1px solid black;">
            <td style="padding:4px 10px; font-weight:bold; vertical-align:middle;">Frekuensi nyeri</td>
            <td style="padding:4px 10px; text-align:center; vertical-align:middle;">:</td>
            <td style="padding:4px 10px; vertical-align:middle;">
                @foreach ($frekuensiNyeriData as $id => $name)
                    @if (isset($nyeri->skala_nyeri_frekuensi_id) && $nyeri->skala_nyeri_frekuensi_id == $id)
                        <strong>{{ $name }}</strong>
                    @endif
                @endforeach
            </td>
        </tr>
    </table>
    <table class="footer" style="width:100%; margin-top:18px;">
        <tr>
            <td style="width:50%;">Nomor: A3/IRM/Rev 02/2023</td>
            <td style="text-align:right;">Hal: 2 dari 4</td>
        </tr>
    </table>


    <h2>III. B. Status Spiritual</h2>
    <div>
        <div>
            <label>Agama Yang Dianut : </label>
            @foreach ($agamaData as $index => $agama)
                @php
                    // cek apakah pasien punya agama yang sama
                    $checked = isset($asesmenKepUmum) && $asesmenKepUmum->spiritual_agama == $index ? 'checked' : '';
                @endphp
                <label style="margin-right:18px;">
                    <input type="checkbox" value="{{ $index }}" {{ $checked }}> {{ $agama }}
                </label>
            @endforeach
            <label style="margin-right:18px;">Lainnya:
                {{ isset($asesmenKepUmum) && $asesmenKepUmum->spiritual_agama_lain ?? '............' }}</label>
        </div>

        <div>
            <label>Pandangan Spiritual Pasien: </label>
            @php
                $pandanganOptions = [
                    1 => 'Takdir',
                    2 => 'Hukuman',
                    3 => 'Lainnya',
                ];
            @endphp

            @foreach ($pandanganOptions as $key => $value)
                @php
                    $checked = isset($asesmenKepUmum) && $asesmenKepUmum->spiritual_nilai == $key ? 'checked' : '';
                @endphp
                <label style="margin-right:18px;">
                    <input type="checkbox" value="{{ $key }}" {{ $checked }}> {{ $value }}
                </label>
            @endforeach
            <label style="margin-right:18px;">{{ $asesmenKepUmum->spiritual_nilai_lain ?? '............' }}</label>
        </div>
    </div>

    <h2>
        III. C. Risiko Jatuh
    </h2>

    <div>
        <table border="1"
            style="width:100%; border-collapse:collapse; font-family:Arial,sans-serif; font-size:8px;">
            <tr>
                <th style="width:80%;">Penilaian Pengkajian</th>
                <th style="width:20%;">Hasil</th>
            </tr>

            <tr>
                <td style="padding:5px; vertical-align:middle;">
                    Pasien &lt; 2 Tahun<br>
                    Menanyakan riwayat sakit: diare, muntah, gangguan keseimbangan, pusing, penglihatan,
                    pengurusan obat sesak, status kesadaran dan atau kejang, konsumsi obat
                </td>
                <td style="text-align:center; font-weight:bold; vertical-align:middle;">
                    {{ $asesmenRisikoJatuh != null && $asesmenRisikoJatuh->risiko_jatuh_umum_usia == 1 ? 'Ya' : 'Tidak' }}
                </td>
            </tr>

            <tr>
                <td style="padding:5px; vertical-align:middle;">
                    Diagnosis sesuai pasien dengan penyakit Parkinson
                </td>
                <td style="text-align:center; font-weight:bold; vertical-align:middle;">
                    {{ $asesmenRisikoJatuh != null && $asesmenRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson == 1 ? 'Ya' : 'Tidak' }}
                </td>
            </tr>

            <tr>
                <td style="padding:5px; vertical-align:middle;">
                    Skor nyeri sesuai pemeriksaan obat-obatan, riwayat irah bening lama, perubahan posisi
                    yang akan meningkatkan risiko jatuh
                </td>
                <td style="text-align:center; font-weight:bold; vertical-align:middle;">
                    {{ $asesmenRisikoJatuh != null && $asesmenRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko == 1 ? 'Ya' : 'Tidak' }}
                </td>
            </tr>

            <tr>
                <td style="padding:5px; vertical-align:middle;">
                    Pasien saat ini sedang berada pada salah satu lokasi ini: rehab medik, ruangan dengan penanganan
                    khusus, atau kamar jenazah
                </td>
                <td style="text-align:center; font-weight:bold; vertical-align:middle;">
                    {{ $asesmenRisikoJatuh != null && $asesmenRisikoJatuh->risiko_jatuh_umum_lokasi_berisiko == 1 ? 'Ya' : 'Tidak' }}
                </td>
            </tr>
        </table>
    </div>


    <h2>
        III. D. Status Psikologis
    </h2>
    <div style="font-size:9pt; width:100%;">
        <table style="width:100%;">
            <tr>
                <td style="width:25%; vertical-align:top; padding:3px;">
                    <strong>Status Psikologis :</strong>
                </td>
                <td style="width:25%; vertical-align:top; padding:3px;">
                    {{ $asesmenKepUmum->psikologis_kondisi ?? '–' }}
                </td>
                <td style="width:35%; vertical-align:top; padding:3px;">
                    <strong>Potensi menyakiti diri sendiri/orang lain :</strong>
                </td>
                <td style="width:15%; vertical-align:top; padding:3px; text-align:left;">
                    {{ $asesmenKepUmum->psikologis_potensi_menyakiti ? 'Ya' : '–' }}
                </td>
            </tr>
        </table>

        <div style="margin-top:10px;">
            <label>Psikologi Lainya : </label>
            <label for="">{{ $asesmenKepUmum->psikologis_lainnya ?? '-' }}</label>
        </div>
    </div>

    <h2>
        III. E. Status Sosial Budaya
    </h2>

    @php
        $pekerjaan = $asesmenSosialEkonomi->pekerjaan->pekerjaan;

        $tingkatPenghasilan = $asesmenSosialEkonomi->sosial_ekonomi_tingkat_penghasilan ?? '–';

        $statusPernikahan = match ($asesmenSosialEkonomi->sosial_ekonomi_status_pernikahan ?? null) {
            '0' => 'Belum Kawin',
            '1' => 'Kawin',
            '2' => 'Janda',
            '3' => 'Duda',
            default => '–',
        };

        $statusPendidikan = $pendidikanData[$asesmenSosialEkonomi->sosial_ekonomi_status_pendidikan ?? 0];

        $tempatTinggal = $asesmenSosialEkonomi->sosial_ekonomi_tempat_tinggal ?? '–';
        $tinggalDenganKeluarga = $asesmenSosialEkonomi->sosial_ekonomi_tinggal_dengan_keluarga ?? '–';

        $curigaPenganiayaan = match ($asesmenSosialEkonomi->sosial_ekonomi_curiga_penganiayaan ?? null) {
            '1' => 'Ada',
            '0' => 'Tidak Ada',
            default => '–',
        };

        $curigaHubunganKeluarga = match ($asesmenSosialEkonomi->sosial_ekonomi_curiga_hubungan_keluarga ?? null) {
            '1' => 'Baik',
            '0' => 'Tidak Baik',
            default => '–',
        };

        $curigaKesulitan = match ($asesmenSosialEkonomi->sosial_ekonomi_curiga_kesulitan ?? null) {
            '1' => 'Ya',
            '0' => 'Tidak',
            default => '–',
        };

        $curigaSuku = $asesmenSosialEkonomi->sosial_ekonomi_curiga_suku ?? '–';
        $curigaBudaya = $asesmenSosialEkonomi->sosial_ekonomi_curiga_budaya ?? '–';
        $keteranganLain = $asesmenSosialEkonomi->sosial_ekonomi_keterangan_lain ?? '–';
    @endphp


    <table style="width:100%; border-collapse:collapse; font-size:8pt;">
        <tr>
            <th style="border:1px solid #000; background:#eee; padding:3px;">Aspek Sosial & Ekonomi</th>
            <th style="border:1px solid #000; background:#eee; padding:3px;">Keterangan</th>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Pekerjaan</td>
            <td style="border:1px solid #000; padding:3px;">{{ $pekerjaan }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Tingkat Penghasilan</td>
            <td style="border:1px solid #000; padding:3px;">{{ $tingkatPenghasilan }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Status Pernikahan</td>
            <td style="border:1px solid #000; padding:3px;">{{ $statusPernikahan }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Status Pendidikan</td>
            <td style="border:1px solid #000; padding:3px;">{{ $statusPendidikan }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Tempat Tinggal</td>
            <td style="border:1px solid #000; padding:3px;">{{ $tempatTinggal }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Tinggal Dengan Keluarga</td>
            <td style="border:1px solid #000; padding:3px;">{{ $tinggalDenganKeluarga }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Curiga Penganiayaan</td>
            <td style="border:1px solid #000; padding:3px;">{{ $curigaPenganiayaan }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Hubungan Dengan Keluarga</td>
            <td style="border:1px solid #000; padding:3px;">{{ $curigaHubunganKeluarga }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Kesulitan Ekonomi</td>
            <td style="border:1px solid #000; padding:3px;">{{ $curigaKesulitan }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Suku</td>
            <td style="border:1px solid #000; padding:3px;">{{ $curigaSuku }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Budaya</td>
            <td style="border:1px solid #000; padding:3px;">{{ $curigaBudaya }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:3px;">Keterangan Lain</td>
            <td style="border:1px solid #000; padding:3px;">{{ $keteranganLain }}</td>
        </tr>
    </table>



    <!-- JUDUL -->
    <h2>III.F. STATUS GIZI-MST</h2>
    <div style="">

        @php
            $gizi = $asesmenStatusGizi ?? (object) [];
        @endphp

        <!-- PERTANYAAN 1 -->
        <div>
            <table>
                <tr>
                    <td style="width : 90%">
                        1. Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?
                    </td>
                    <td style="text-align:center">
                        Skor
                    </td>
                </tr>
            </table>

            <div style="padding-top:6px;">
                <div style="position:relative;padding-left:20px;padding-right:40px;">
                    @if ($gizi->gizi_mst_penurunan_bb == '0')
                        <label style="display:flex;align-items:center;line-height:1.4;position:relative;">

                            <span style="flex:1;padding-left:6px;">Tidak ada</span>
                            <span
                                style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">0</span>
                        </label>
                    @elseif($gizi->gizi_mst_penurunan_bb == '2')
                        <label style="display:flex;align-items:center;line-height:1.4;position:relative;">

                            <span style="flex:1;padding-left:6px;">Tidak yakin/ tidak tahu/ terasa baju longgar</span>
                            <span
                                style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">2</span>
                        </label>
                    @endif
                </div>
            </div>

            @if ($gizi->gizi_mst_jumlah_penurunan_bb)
                <div style="padding-left:20px;padding-top:6px;font-size:13.5px;color:#555;line-height:1.4;">
                    Jika "Ya" berapa penurunan berat badan tersebut:
                </div>

                <div style="padding-top:4px;">
                    <div style="position:relative;padding-left:40px;padding-right:40px;">
                        @if ($gizi->gizi_mst_jumlah_penurunan_bb == '1')
                            <label style="display:flex;align-items:center;line-height:1.4;position:relative;">

                                <span style="flex:1;padding-left:6px;">1 sd 5 Kg</span>
                                <span
                                    style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">1</span>
                            </label>
                        @elseif($gizi->gizi_mst_jumlah_penurunan_bb == '2')
                            <label style="display:flex;align-items:center;line-height:1.4;position:relative;">

                                <span style="flex:1;padding-left:6px;">6 sd 10 Kg</span>
                                <span
                                    style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">2</span>
                            </label>
                        @elseif($gizi->gizi_mst_jumlah_penurunan_bb == '3')
                            <label style="display:flex;align-items:center;line-height:1.4;position:relative;">

                                <span style="flex:1;padding-left:6px;">11 sd 15 Kg</span>
                                <span
                                    style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">3</span>
                            </label>
                        @elseif($gizi->gizi_mst_jumlah_penurunan_bb == '4')
                            <label style="display:flex;align-items:center;line-height:1.4;position:relative;">

                                <span style="flex:1;padding-left:6px;">> 15 Kg</span>
                                <span
                                    style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">4</span>
                            </label>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- PERTANYAAN 2 -->
        <div style="padding-top:10px;line-height:1.5;">
            <div>2. Apakah asupan makan berkurang karena tidak nafsu makan?</div>
            <div style="padding-top:6px;">
                <div style="position:relative;padding-left:20px;padding-right:40px;">
                    @if ($gizi->gizi_mst_nafsu_makan_berkurang == '0')
                        <label style="display:flex;align-items:center;line-height:1.4;position:relative;">

                            <span style="flex:1;padding-left:6px;">Tidak</span>
                            <span
                                style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">0</span>
                        </label>
                    @elseif($gizi->gizi_mst_nafsu_makan_berkurang == '1')
                        <label style="display:flex;align-items:center;line-height:1.4;position:relative;">

                            <span style="flex:1;padding-left:6px;">Ya</span>
                            <span
                                style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">1</span>
                        </label>
                    @endif
                </div>
            </div>
        </div>

        <!-- PERTANYAAN 3 -->
        <div style="line-height:1.5;">
            <div>
                3. Pasien dengan diagnosa khusus :
                @if ($gizi->gizi_mst_diagnosis_khusus == '1')
                    <label style="display:inline-flex;align-items:center;padding-left:8px;">
                        Ya
                    </label>
                @elseif($gizi->gizi_mst_diagnosis_khusus == '0')
                    <label style="display:inline-flex;align-items:center;padding-left:12px;">
                        Tidak
                    </label>
                @endif
            </div>
            <div style="padding-left:20px;padding-top:4px;font-size:13.5px;color:#555;line-height:1.4;">
                (Diabetes, Kemo, HD, geriatri, penurunan imun, dll disebutkan:)
            </div>
        </div>

        <!-- TOTAL SKOR -->
        @php
            $totalSkor = 0;
            if ($gizi->gizi_mst_penurunan_bb !== null) {
                $totalSkor += (int) $gizi->gizi_mst_penurunan_bb;
            }
            if ($gizi->gizi_mst_jumlah_penurunan_bb !== null) {
                $totalSkor += (int) $gizi->gizi_mst_jumlah_penurunan_bb;
            }
            if ($gizi->gizi_mst_nafsu_makan_berkurang !== null) {
                $totalSkor += (int) $gizi->gizi_mst_nafsu_makan_berkurang;
            }
        @endphp

        <table>
            <tr>
                <th style="text-align: left;">TOTAL SKOR</th>
                <th>
                    <input type="text" readonly value="{{ $totalSkor ?: '' }}"
                        style="width:48px;height:32px;text-align:center;border:2px solid #000;font-weight:bold;font-size:15px;">
                </th>
            </tr>
        </table>
    </div>

    <!-- CATATAN -->
    @if ($totalSkor >= 2 || $gizi->gizi_mst_diagnosis_khusus == '1')
        <div style="font-style:italic;color:#c00;font-weight:bold;font-size:13.5px; height : 30px;">
            (Bila skor > 2 dan atau pasien dengan diagnosis/ kondisi khusus dilaporkan ke dokter pemeriksa)
        </div>
    @endif

    <!-- FOOTER -->
    <table class="footer" style="width:100%;">
        <tr>
            <td style="width:50%;">Nomor: A3/IRM/Rev 02/2023</td>
            <td style="text-align:right;">Hal: 3 dari 4</td>
        </tr>
    </table>

    <h2>
        III.G. STATUS FUNGSIONAL
    </h2>
    @php
        $statusFungsionalOptions = [
            'Mandiri',
            'Ketergantungan Ringan',
            'Ketergantungan Sedang',
            'Ketergantungan Berat',
            'Ketergantungan Total',
        ];
    @endphp
    @foreach ($statusFungsionalOptions as $index => $item)
        <label style="margin-right:18px; "><input type="checkbox"
                {{ $item == $asesmenKepUmum->status_fungsional ? 'checked' : '' }} value="{{ $index }}">
            {{ $item }}</label>
    @endforeach

    @php
        $data = $asesmenKepUmum;
    @endphp
    <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:6px;">
        <tr>
            <td colspan="6" style="background:#f2f2f2; font-weight:bold; padding:5px;">
                III.H. EDUKASI/ PENDIDIKAN DAN PENGAJARAN
            </td>
        </tr>
        <tr>
            <td style="width:20%; vertical-align:top; padding:4px;">Bicara</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox" {{ $data->kebutuhan_edukasi_gaya_bicara == '1' ? 'checked' : '' }}> Normal
                <input type="checkbox" {{ $data->kebutuhan_edukasi_gaya_bicara == '0' ? 'checked' : '' }}> Tidak
                normal, gangguan bicara sejak:
                ____________________________________________
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Bahasa sehari-hari</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox"
                    {{ strtolower($data->kebutuhan_edukasi_bahasa_sehari_hari) == 'indonesia' ? 'checked' : '' }}>
                Indonesia
                <input type="checkbox"
                    {{ strtolower($data->kebutuhan_edukasi_bahasa_sehari_hari) == 'aceh' ? 'checked' : '' }}> Aceh
                <input type="checkbox"
                    {{ !in_array(strtolower($data->kebutuhan_edukasi_bahasa_sehari_hari), ['indonesia', 'aceh', '']) && $data->kebutuhan_edukasi_bahasa_sehari_hari !== null ? 'checked' : '' }}>
                Lainnya: {{ $data->kebutuhan_edukasi_bahasa_sehari_hari ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Perlu penerjemah</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox" {{ $data->kebutuhan_edukasi_perlu_penerjemah == '0' ? 'checked' : '' }}>
                Tidak
                <input type="checkbox" {{ $data->kebutuhan_edukasi_perlu_penerjemah == '1' ? 'checked' : '' }}> Ya
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Hambatan komunikasi</td>
            <td colspan="5" style="padding:4px;">
                : {{ $data->kebutuhan_edukasi_hambatan_komunikasi ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Media belajar yang disukai</td>
            <td colspan="5" style="padding:4px;">
                : {{ $data->kebutuhan_edukasi_media_belajar ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Tingkat Pendidikan</td>
            <td colspan="5" style="padding:4px;">
                : {{ $data->kebutuhan_edukasi_tingkat_pendidikan ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Edukasi yang dibutuhkan</td>
            <td colspan="5" style="padding:4px;">
                : {{ $data->kebutuhan_edukasi_edukasi_dibutuhkan ?? '' }}
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Catatan Khusus</td>
            <td colspan="5" style="padding:4px;">
                : {{ $data->kebutuhan_edukasi_keterangan_lain ?? '' }}<br>
                ..............................................................................................................................
            </td>
        </tr>
    </table>
    <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:6px;">
        <tr>
            <td colspan="4" style="background:#f2f2f2; font-weight:bold; padding:5px;">
                III.I. PERENCANAAN PEMULANGAN PASIEN/ DISCHARGE PLANNING
            </td>
        </tr>
        <tr>
            <td style="width:25%; padding:4px;">Diagnosa Medis</td>
            <td style="width:35%; padding:4px;">:
                {{ $asesmenKepUmum->discharge_planning_diagnosis_medis ?? '.......................................................' }}
            </td>
            <td colspan="2" style="padding:4px; font-size:9pt;">
                Jika salah satu jawaban <b>"Ya"</b>, maka pasien membutuhkan rencana pulang khusus
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Usia Lanjut (&gt; 60 thn)</td>
            <td style="padding:4px;">: {{ $asesmenKepUmum->discharge_planning_usia_lanjut ?? '' }}</td>
            <td colspan="2" rowspan="4"></td>
        </tr>
        <tr>
            <td style="padding:4px;">Hambatan Mobilisasi</td>
            <td style="padding:4px;">: {{ $asesmenKepUmum->discharge_planning_hambatan_mobilisasi ?? '' }}</td>

        </tr>
        <tr>
            <td style="padding:4px;">Membutuhkan Pelayanan Medis Berkelanjutan</td>
            <td style="padding:4px;">: {{ $asesmenKepUmum->discharge_planning_hambatan_mobilisasi ?? '' }}</td>
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Ketergantungan dengan orang lain dalam aktivitas harian</td>
            <td style="padding:4px;">:{{ $asesmenKepUmum->discharge_planning_pelayanan_medis ?? '' }}</td>
        </tr>
    </table>

    <div style="height : 445px;">
        <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:6px; border:1px solid #000;">
            <tr>
                <td colspan="6" style="background:#f2f2f2; font-weight:bold; padding:5px; border:1px solid #000;">
                    IV. IMPLEMENTASI DAN EVALUASI KEPERAWATAN
                </td>
            </tr>
            <tr style="text-align:center; font-weight:bold;">
                <td style="width:12%; border:1px solid #000; padding:4px;">Tgl dan Jam</td>
                <td style="width:25%; border:1px solid #000; padding:4px;">Tindakan Keperawatan</td>
                <td style="width:8%; border:1px solid #000; padding:4px;">Prf</td>
                <td style="width:12%; border:1px solid #000; padding:4px;">Tgl dan Jam</td>
                <td style="width:35%; border:1px solid #000; padding:4px;">Evaluasi Keperawatan</td>
                <td style="width:8%; border:1px solid #000; padding:4px;">Prf</td>
            </tr>

            @php
                // Decode JSON
                $implementasi = json_decode($asesmenKepUmum->implementasi_keperawatan ?? '[]', true);
                $evaluasi = json_decode($asesmenKepUmum->evaluasi_keperawatan ?? '[]', true);

                // Tentukan jumlah baris maksimal
                $maxRows = max(count($implementasi), count($evaluasi), 1);
            @endphp

            @for ($i = 0; $i < $maxRows; $i++)
                <tr>
                    <!-- Implementasi: Tgl & Jam -->
                    <td style="border:1px solid #000; padding:4px; vertical-align:top; text-align:center;">
                        @if (isset($implementasi[$i]))
                            {{ \Carbon\Carbon::parse($implementasi[$i]['date'])->format('d/m/Y') }}<br>
                            {{ $implementasi[$i]['time'] }}
                        @endif
                    </td>

                    <!-- Implementasi: Tindakan -->
                    <td style="border:1px solid #000; padding:4px; vertical-align:top;">
                        @if (isset($implementasi[$i]))
                            {{ $implementasi[$i]['action'] }}
                        @endif
                    </td>

                    <!-- Implementasi: Paraf (kosong) -->
                    <td style="border:1px solid #000; padding:4px; vertical-align:top; text-align:center;">
                        &nbsp;
                    </td>

                    <!-- Evaluasi: Tgl & Jam -->
                    <td style="border:1px solid #000; padding:4px; vertical-align:top; text-align:center;">
                        @if (isset($evaluasi[$i]))
                            {{ \Carbon\Carbon::parse($evaluasi[$i]['date'])->format('d/m/Y') }}<br>
                            {{ $evaluasi[$i]['time'] }}
                        @endif
                    </td>

                    <!-- Evaluasi: SOAP -->
                    <td style="border:1px solid #000; padding:4px; vertical-align:top; font-size:8pt;">
                        @if (isset($evaluasi[$i]))
                            <strong>S:</strong> {{ $evaluasi[$i]['subjective'] ?? '' }}<br>
                            <strong>O:</strong> {{ $evaluasi[$i]['objective'] ?? '' }}<br>
                            <strong>A:</strong> {{ $evaluasi[$i]['assessment'] ?? '' }}<br>
                            <strong>P:</strong> {{ $evaluasi[$i]['planning'] ?? '' }}
                        @endif
                    </td>

                    <!-- Evaluasi: Paraf (kosong) -->
                    <td style="border:1px solid #000; padding:4px; vertical-align:top; text-align:center;">
                        &nbsp;
                    </td>
                </tr>
            @endfor

            <!-- Tambahkan baris kosong jika data kurang dari 5 baris (opsional) -->
            @if ($maxRows < 5)
                @for ($i = $maxRows; $i < 5; $i++)
                    <tr>
                        <td style="border:1px solid #000; padding:4px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:4px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:4px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:4px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:4px;">&nbsp;</td>
                        <td style="border:1px solid #000; padding:4px;">&nbsp;</td>
                    </tr>
                @endfor
            @endif
        </table>
        <!-- Bagian tanda tangan perawat pengkaji -->
        @php
            // Tanggal dan jam hari ini (format Indonesia)
            $today = \Carbon\Carbon::now();
            $dateFormatted = $today->format('d-m-Y'); // 05-11-2025
            $timeFormatted = $today->format('H:i'); // 14:30
        @endphp

        <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:8px;">
            <tr>
                <td style="width:15%; padding:4px;">Tanggal</td>
                <td style="width:30%; border-bottom:1px solid #000; padding:0 4px;">
                    {{ $dateFormatted }}
                </td>
                <td style="width:5%; text-align:right;">Jam :</td>
                <td style="width:10%; border-bottom:1px solid #000; padding:0 4px;">
                    {{ $timeFormatted }}
                </td>
                <td style="width:5%; text-align:center;">WIB</td>
            </tr>

        </table>

        <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:50px;">
            <tr>
                <td style="padding:4px;">Perawat pengkaji</td>
                <td colspan="2" style="width:50px; border-bottom:1px solid #000;">&nbsp;</td>
                <td style="text-align:right;">Tanda tangan :</td>
                <td colspan="2" style="width:100px; border-bottom:1px solid #000;">&nbsp;</td>
            </tr>
        </table>

        <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:8px; height : 130px;">
            <tr>
                <td style="width:40%; padding:4px;">Diterima perawat ruang :</td>
                <td style="width:60%; border-bottom:1px solid #000;">&nbsp;</td>
            </tr>
            <tr>
                <td style="padding:4px;">Tanggal :</td>
                <td style="border-bottom:1px solid #000; padding:0 4px;">
                    {{ $dateFormatted }} &nbsp; Jam: {{ $timeFormatted }} WIB
                </td>
            </tr>
        </table>
        <!-- Bagian penerimaan perawat ruang -->
        <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:60px;  ">

            <tr style="height: 100px;">
                <td style="padding:4px;"></td>
                <td style="text-align:center; width : 230px;">
                    {{ $asesmen?->user?->name }}
                    <br>
                    (<span style="display:inline-block; width:200px; border-bottom:1px solid #000;">&nbsp;</span>)
                </td>
            </tr>
        </table>
        <table class="footer" style="width:100%; margin-top:18px;">
            <tr>
                <td style="width:50%;">Nomor: A3/IRM/Rev 02/2023</td>
                <td style="text-align:right;">Hal: 4 dari 4</td>
            </tr>
        </table>

</body>

</html>
