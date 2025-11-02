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

    <table style="width:100%; border-bottom:2px solid #ccc;x;">
        <tr>
            <td style="width:35%;">
                <table>
                    <tr>
                        <td>
                            <div class="logo">RSUD LANGSA</div>
                        </td>
                        <td style="padding-left:6px; line-height:1.1;">
                            <div style="font-size:10.5pt; color:#4CAF50; font-weight:bold;">RSUD KOTA LANGSA</div>
                            <div class="tiny">Jl. Jend. A. Yani. No. 1. Kota Langsa</div>
                            <div class="tiny">Telp. 0641-22051, email: rsulangsa@gmail.com</div>
                            <div class="tiny">www.rsud.langsakota.go.id</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="text-center" style="font-size:13.5pt; font-weight:bold; width:40%;">
                PENGKAJIAN KEPERAWATAN GAWAT DARURAT
            </td>
            <td style="width:25%; text-align:right;">
                <span class="divider"></span><span class="divider yellow"></span><span class="igd">IGD</span>
            </td>
        </tr>
    </table>

    <!-- I. IDENTITAS PASIEN -->
    <div style="font-size:11pt; font-weight:bold; text-decoration:underline; 0;">I. IDENTITAS PASIEN</div>

    <table style="font-size:8pt; width:100%; border-collapse:collapse; line-height:1.2;">
        <tr>
            <td style="width:50%;">
                Nama pasien <input type="text" style="width:130px;">
                JK: <input type="checkbox"> Lk <input type="checkbox"> Pr
                <span style="color:#006400; font-weight:bold; margin-left:5px;">RM</span>
                <input type="text" class="rm-box" style="width:10px;">
                <input type="text" class="rm-box" style="width:10px;">
                <input type="text" class="rm-box" style="width:10px;">
                <input type="text" class="rm-box" style="width:10px;">
                <input type="text" class="rm-box" style="width:10px;">
            </td>
            <td>
                Tgl lahir <input type="text" class="input-date" style="width:20px;"> -
                <input type="text" class="input-date" style="width:20px;"> -
                <input type="text" class="input-date" style="width:30px;">
                Usia: <input type="text" style="width:30px;">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Keluarga: <input type="text" style="width:120px;">
                Ibu: <input type="text" style="width:80px;">
                Ayah: <input type="text" style="width:80px;">
                Suami: <input type="text" style="width:80px;">
                Isteri: <input type="text" style="width:80px;">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Pekerjaan <input type="text" style="width:250px;">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Alamat <input type="text" style="width:350px;">
                No HP: <input type="text" style="width:100px;">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Jaminan:
                <input type="checkbox"> JKN/BPJS
                <input type="checkbox"> JR
                <input type="checkbox"> Umum
                <input type="checkbox"> Lainnya <input type="text" style="width:70px;">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Datang tgl <input type="text" class="input-date" style="width:20px;"> -
                <input type="text" class="input-date" style="width:20px;"> -
                <input type="text" class="input-date" style="width:30px;">
                Pukul: <input type="text" style="width:35px;"> WIB
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Kendaraan:
                <input type="checkbox"> Ambulance
                <input type="checkbox"> Pribadi
                <input type="checkbox"> Lainnya
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Kunjungan:
                <input type="checkbox"> Datang sendiri
                <input type="checkbox"> Rujukan <input type="text" style="width:90px;">
                <input type="checkbox"> Diantar
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Diantar oleh: <input type="text" style="width:120px;">
                Usia: <input type="text" style="width:25px;"> Th
                Alamat: <input type="text" style="width:180px;">
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Status: <input type="text" value="Keluarga/polisi/lainnya*"
                    style="width:180px; background:#f9f9f9; font-size:7.8pt;">
            </td>
        </tr>
    </table>


    <!-- II. ABCD -->
    <div style="font-size:11.5pt; font-weight:bold; underline; 0 5px;">II.
        AIRWAY-BREATHING-CIRCULATION-DISABILITY</div>

    <!-- A. AIRWAY -->
    @php
        $airway = optional(value: $asesmenKepUmum);
        $tindakan = explode(',', $airway->airway_tindakan ?? '');
    @endphp

    <table style="border:1px solid #000; font-size:7.5pt; margin-top:5px; border-collapse:collapse; width:100%;">
        <tr>
            <!-- KOLOM PENILAIAN -->
            <td style="height : 250px; width:33.3%; border-right:1px solid #000; padding:3px; vertical-align:top;">
                <div
                    style="background:#eee; padding:2px 3px; font-weight:bold; font-size:8pt; border-bottom:1px solid #ccc;">
                    A. AIRWAY
                </div>

                <div style="margin-top:3px;">
                    <div>Status airway:
                        <span style="font-weight:bold;">
                            {{ isset($airway->airway_status) ? ucfirst($airway->airway_status) : '' }}
                        </span>
                    </div>

                    @if(isset($airway->airway_status) && $airway->airway_status === 'lainnya')
                        <div style="margin-left:8px;">Lainnya:
                            <span style="font-weight:bold;">{{ $airway->airway_lainnya ?? '' }}</span>
                        </div>
                    @endif

                    <div style="margin-top:3px;">Suara napas:
                        <span style="font-weight:bold;">
                            {{ isset($airway->airway_suara_nafas) ? ucfirst($airway->airway_suara_nafas) : '' }}
                        </span>
                    </div>
                </div>
            </td>

            <!-- KOLOM DIAGNOSIS -->
            <td style="width:33.3%; border-right:1px solid #000; padding:3px; vertical-align:top;">
                <div
                    style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                    Masalah / Diagnosis Keperawatan
                </div>

                <div style="margin-top:3px;">
                    <div style="font-weight:bold;">Jalan nafas tidak efektif : </div>
                    <div style="margin-left:8px;">
                        @if(isset($airway->airway_diagnosis) && $airway->airway_diagnosis == '1')
                            Aktual
                        @elseif(isset($airway->airway_diagnosis) && $airway->airway_diagnosis == '2')
                            Risiko
                        @endif
                    </div>
                </div>
            </td>

            <!-- KOLOM TINDAKAN -->
            <td style="width:33.4%; padding:3px; vertical-align:top;">
                <div
                    style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                    Tindakan Keperawatan
                </div>


                @if(!empty($tindakan))
                    <div style="margin-top:3px;">
                        @foreach ($tindakan as $item)
                            <div>- {{ preg_replace('/[^A-Za-z0-9\s\/-]/', '', $item) }}</div>
                        @endforeach
                    </div>
                @endif

            </td>

        </tr>
    </table>

    @php
        $breathing = $asesmenBreathing;

        $tindakan = isset($breathing->breathing_tindakan)
            ? explode(',', $breathing->breathing_tindakan)
            : [];
    @endphp

    <table border="1"
        style=" border:1px solid #000; font-size:7.5pt; margin-top:5px; border-collapse:collapse; width:100%;">
        <tr>
            <!-- KOLOM PENILAIAN -->
            <td style="height : 230px; width:33.3%; border-right:1px solid #000; padding:3px; vertical-align:top;">
                <div
                    style="background:#eee; padding:1.5px 3px; font-weight:bold; font-size:8pt; border-bottom:1px solid #ccc;">
                    B. BREATHING
                </div>

                <div style="margin-top:3px;">
                    {{-- Frekuensi Nafas --}}
                    @if(!empty($breathing->breathing_frekuensi_nafas))
                        <div>Frekuensi nafas/menit:
                            <span style="font-weight:bold;">{{ $breathing->breathing_frekuensi_nafas }}</span>
                        </div>
                    @endif

                    {{-- Pola Nafas --}}
                    @if(!empty($breathing->breathing_pola_nafas))
                        <div>Pola nafas:
                            <span style="font-weight:bold;">{{ $breathing->breathing_pola_nafas }}</span>
                        </div>
                    @endif

                    {{-- Bunyi Nafas --}}
                    @if(!empty($breathing->breathing_bunyi_nafas))
                        <div>Bunyi nafas:
                            <span style="font-weight:bold;">{{ $breathing->breathing_bunyi_nafas }}</span>
                        </div>
                    @endif

                    {{-- Irama Nafas --}}
                    @if(isset($breathing->breathing_irama_nafas))
                        <div>Irama nafas:
                            <span style="font-weight:bold;">
                                {{ $breathing->breathing_irama_nafas == '1' ? 'Teratur' : 'Tidak Teratur' }}
                            </span>
                        </div>
                    @endif

                    {{-- Tanda Distress Nafas --}}
                    @if(!empty($breathing->breathing_tanda_distress))
                        <div>Tanda distress nafas:
                            <span style="font-weight:bold;">{{ $breathing->breathing_tanda_distress }}</span>
                        </div>
                    @endif

                    {{-- Jalan Nafas --}}
                    @if(isset($breathing->breathing_jalan_nafas))
                        <div>Jalan nafas:
                            <span style="font-weight:bold;">
                                {{ $breathing->breathing_jalan_nafas == '1' ? 'Pernafasan Dada' : 'Pernafasan Perut' }}
                            </span>
                        </div>
                    @endif

                    {{-- Lainnya --}}
                    @if(!empty($breathing->breathing_lainnya))
                        <div>Lainnya:
                            <span style="font-weight:bold;">{{ $breathing->breathing_lainnya }}</span>
                        </div>
                    @endif
                </div>
            </td>

            <!-- KOLOM DIAGNOSIS -->
            <td style="width:33.3%; border-right:1px solid #000; padding:3px; vertical-align:top;">
                <div
                    style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                    Masalah/Diagnosis Keperawatan
                </div>

                <div style="margin-top:3px;">
                    {{-- Diagnosis Pola Nafas Tidak Efektif --}}
                    <div style="font-weight:bold;">Pola Nafas Tidak Efektif : </div>
                    <div style="margin-left:8px;">
                        @if($breathing->breathing_diagnosis_nafas == '1')
                            <span>Aktual</span>
                        @elseif($breathing->breathing_diagnosis_nafas == '2')
                            <span>Risiko</span>
                        @endif
                    </div>

                    {{-- Diagnosis Gangguan Pertukaran Gas --}}
                    <div style="font-weight:bold; margin-top:3px;">Gangguan Pertukaran Gas : </div>
                    <div style="margin-left:8px;">
                        @if($breathing->breathing_gangguan == '1')
                            <span>Aktual</span>
                        @elseif($breathing->breathing_gangguan == '2')
                            <span>Risiko</span>
                        @endif
                    </div>
                </div>
            </td>

            <!-- KOLOM TINDAKAN -->
            <td style="width:33.4%; padding:3px; vertical-align:top;">
                <div
                    style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                    Tindakan Keperawatan
                </div>

                @if(!empty($tindakan))
                    @if(!empty($tindakan))
                        <div style="margin-top:3px;">
                            @foreach ($tindakan as $item)
                                <div>- {{ preg_replace('/[^A-Za-z0-9\s\/-]/', '', $item) }}</div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </td>
        </tr>
    </table>

    <!-- C. CIRCULATION -->
    @php
        $circulation = $asesmenCirculation;

        $tindakan = $circulation->circulation_tindakan ?? '[]';
        $tindakan = json_decode($tindakan, true);

        // Jika json_decode gagal karena format string tidak valid, kita pakai cara manual
        if ($tindakan === null) {
            $tindakan = explode(',', str_replace(['[', ']', '"'], '', $circulation->circulation_tindakan));
        }
    @endphp

    <table style="border:1px solid #000; font-size:7.5pt; margin-top:5px; border-collapse:collapse; width:100%;">
        <tr>
            <!-- KOLOM PENILAIAN -->
            <td style="height : 230px; width:33.3%; border-right:1px solid #000; padding:3px; vertical-align:top;">
                <div
                    style="background:#eee; padding:1.5px 3px; font-weight:bold; font-size:8pt; border-bottom:1px solid #ccc;">
                    C. CIRCULATION
                </div>

                <div style="margin-top:3px;">
                    <div>Nadi:
                        <span style="font-weight:bold;">
                            {{ $circulation->circulation_nadi_irama ?? '' }} /
                            {{ $circulation->circulation_nadi_kekuatan ?? '' }}
                        </span>
                    </div>

                    <div>Tekanan darah (mmHg):
                        <span style="font-weight:bold;">
                            {{ $circulation->circulation_sistole ?? '-' }}/{{ $circulation->circulation_diastole ?? '-' }}
                        </span>
                    </div>

                    <div>Akral:
                        @if(($circulation->circulation_akral ?? '') == '1')
                            <span style="font-weight:bold;"> Normal</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div>Pucat:
                        @if(($circulation->circulation_pucat ?? '') == '1')
                            <span style="font-weight:bold;"> Ya</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div>Cianosis:
                        @if(($circulation->circulation_cianosis ?? '') == '1')
                            <span style="font-weight:bold;"> Ya</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div>Waktu pengisian kapiler:
                        @if(($circulation->circulation_kapiler ?? '') == '1')
                            <span style="font-weight:bold;"> Normal</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div>Kelembapan kulit:
                        @if(($circulation->circulation_kelembapan_kulit ?? '') == '1')
                            <span style="font-weight:bold;"> Normal</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div>Turgor kulit:
                        @if(($circulation->circulation_turgor ?? '') == '1')
                            <span style="font-weight:bold;"> Normal</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>

                    <div>Transfusi:
                        @if(($circulation->circulation_transfusi ?? '') == '1')
                            <span style="font-weight:bold;"> Ya</span>
                            (Jumlah: <span
                                style="font-weight:bold;">{{ $circulation->circulation_transfusi_jumlah ?? '-' }}</span>)
                        @else
                            <span>- Tidak</span>
                        @endif
                    </div>

                    <div>Lainnya:
                        <span style="font-weight:bold;">{{ $circulation->circulation_lain ?? '' }}</span>
                    </div>
                </div>
            </td>

            <!-- KOLOM DIAGNOSIS -->
            <td style="width:33.3%; border-right:1px solid #000; padding:3px; vertical-align:top;">
                <div
                    style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                    Masalah/Diagnosis Keperawatan
                </div>

                <div style="margin-top:3px;">
                    <div style="font-weight:bold;">Perfusi Jaringan Tidak Efektif</div>
                    <div style="margin-left:8px;">
                        @if(($circulation->circulation_diagnosis_perfusi ?? '') == '1')
                            <span> Aktual</span>
                        @elseif(($circulation->circulation_diagnosis_perfusi ?? '') == '2')
                            <span> Risiko</span>
                        @endif
                    </div>

                    <div style="font-weight:bold; margin-top:3px;">Risiko Syok : </div>
                    <div style="margin-left:8px;">
                        @if(($circulation->circulation_diagnosis_defisit ?? '') == '1')
                            <span> Aktual</span>
                        @elseif(($circulation->circulation_diagnosis_defisit ?? '') == '2')
                            <span> Risiko</span>
                        @endif
                    </div>
                </div>
            </td>

            <!-- KOLOM TINDAKAN -->
            <td style="width:33.4%; padding:3px; vertical-align:top;">
                <div
                    style="background:#ddd; padding:2px; border-bottom:1px solid #000; font-size:8pt; text-align:center; font-weight:bold;">
                    Tindakan Keperawatan
                </div>

                @if(!empty($tindakan))
                    @if(!empty($tindakan))
                        <div style="margin-top:3px;">
                            @foreach ($tindakan as $item)
                                <div>- {{ preg_replace('/[^A-Za-z0-9\s\/-]/', '', $item) }}</div>
                            @endforeach
                        </div>
                    @endif
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


    <table style="border:1px solid #000; font-size:8.8pt; margin-top:6px; border-collapse:collapse; width:100%;">
        <tr>
            <td colspan="3" style="font-weight:bold; background:#eee; padding:4px;">D. Disability</td>
        </tr>

        <tr>
            {{-- Kolom Pemeriksaan --}}
            <td style="width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">
                <div><strong>Pemeriksaan</strong></div>
                <div>GCS : {{ json_decode($asesmenDisability->vital_sign ?? '{}')->gcs ?? '-' }}</div>
                <div>Kesadaran : {{ $asesmenDisability->disability_kesadaran ?? '-' }}</div>
                <div>Pupil :
                    {{ $asesmenDisability->disability_isokor == '1' ? 'Isokor' : ($asesmenDisability->disability_isokor == '2' ? 'Anisokor' : '-') }},
                    Respon Cahaya :
                    {{ $asesmenDisability->disability_respon_cahaya == '1' ? 'Ya' : ($asesmenDisability->disability_respon_cahaya == '0' ? 'Tidak' : '-') }}
                </div>
                <div>Diameter Pupil : {{ $asesmenDisability->disability_diameter_pupil ?? '-' }} mm</div>
                <div>Motorik : {{ $asesmenDisability->disability_motorik == '1' ? 'Ya' : 'Tidak' }}</div>
                <div>Sensorik : {{ $asesmenDisability->disability_sensorik == '1' ? 'Ya' : 'Tidak' }}</div>
                <div>Kekuatan Otot : {{ $asesmenDisability->disability_kekuatan_otot ?? '-' }}</div>
            </td>

            {{-- Kolom Diagnosis --}}
            <td style="width:33.3%; border-right:1px solid #000; padding:4px 5px; vertical-align:top;">
                <div><strong>Diagnosis Keperawatan</strong></div>
                @php
                    $diagnosisList = [
                        'disability_diagnosis_perfusi' => 'Perfusi jaringan cereberal tidak efektif',
                        'disability_diagnosis_intoleransi' => 'Intoleransi aktivitas',
                        'disability_diagnosis_komunikasi' => 'Kendala komunikasi verbal',
                        'disability_diagnosis_kejang' => 'Kejang ulang',
                        'disability_diagnosis_kesadaran' => 'Penurunan kesadaran',
                    ];
                @endphp
                @foreach($diagnosisList as $key => $label)
                    @if(!empty($asesmenDisability->$key))
                        <div>- {{ $label }}
                            @php
                                $typeField = $key . '_type';
                                $type = $asesmenDisability->$typeField ?? null;
                            @endphp
                            @if($type == '1')
                                (Aktual)
                            @elseif($type == '2')
                                (Risiko)
                            @endif
                        </div>
                    @endif
                @endforeach
                @if(!empty($asesmenDisability->disability_lainnya))
                    <div>- {{ $asesmenDisability->disability_lainnya }}</div>
                @endif
            </td>

            {{-- Kolom Tindakan --}}
            <td style="width:33.3%; padding:4px 5px; vertical-align:top;">
                <div><strong>Tindakan Keperawatan</strong></div>
                @php
                    $tindakan = json_decode($asesmenDisability->disability_tindakan ?? '[]', true);
                @endphp
                @if(!empty($tindakan))
                    @foreach($tindakan as $item)
                        <div>- {{ ucwords(strtolower($item)) }}</div>
                    @endforeach
                @else
                    <div>-</div>
                @endif
            </td>
        </tr>
    </table>
    <h2 style="font-size:10pt;  margin-top: 350px">Skala Nyeri</h2>
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
                    <label><input type="checkbox" {{ ($nilai >= 1 && $nilai <= 3) ? 'checked' : '' }}> Ringan
                        (1–3)</label>
                    <label><input type="checkbox" {{ ($nilai >= 4 && $nilai <= 6) ? 'checked' : '' }}> Sedang
                        (4–6)</label>
                    <label><input type="checkbox" {{ ($nilai >= 7 && $nilai <= 9) ? 'checked' : '' }}> Berat (7–9)</label>
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
                    @if ($nyeri->skala_nyeri_jenis_id == $id)
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
                    @if ($nyeri->skala_nyeri_menjalar_id == $id)
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
                    @if ($nyeri->skala_nyeri_kualitas_id == $id)
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
                    @if ($nyeri->skala_nyeri_pemberat_id == $id)
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
                    @if ($nyeri->skala_nyeri_peringan_id == $id)
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
                    @if ($nyeri->skala_nyeri_frekuensi_id == $id)
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
            @foreach($agamaData as $index => $agama)
                @php
                    // cek apakah pasien punya agama yang sama
                    $checked = $asesmenKepUmum->spiritual_agama == $index ? 'checked' : '';
                @endphp
                <label style="margin-right:18px;">
                    <input type="checkbox" value="{{ $index }}" {{ $checked }}> {{ $agama }}
                </label>
            @endforeach
            <label style="margin-right:18px;">Lainnya:
                {{ $asesmenKepUmum->spiritual_agama_lain ?? '............' }}</label>
        </div>

        <div>
            <label>Pandangan Spiritual Pasien: </label>
            @php
                $pandanganOptions = [
                    1 => 'Takdir',
                    2 => 'Hukuman',
                    3 => 'Lainnya'
                ];
            @endphp

            @foreach($pandanganOptions as $key => $value)
                @php
                    $checked = $asesmenKepUmum->spiritual_nilai == $key ? 'checked' : '';
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
        <table border="1" style="width:100%; border-collapse:collapse; font-family:Arial,sans-serif; font-size:8px;">
            <tr>
                <th>
                    Penilaian Pengkajian
                </th>
                <th>
                    Ya
                </th>
                <th>
                    Tidak
                </th>
            </tr>
            <tr style="">
                <td style="padding:5px; vertical-align:middle;">
                    Pasien &lt; 2 Tahun
                    Menanyakan riwayat sakit: diare, muntah, gangguan keseimbangan, pusing, penglihatan, pengurusan obat
                    sesak, status kesadaran dan atau kejang, konsumsi obat
                </td>
                <td style="padding:5px; vertical-align:middle; width:30px; text-align:center; font-weight:bold;"></td>
                <td style="padding:5px; vertical-align:middle; width:30px; text-align:center; font-weight:bold;"></td>
            </tr>
            <tr style="">
                <td style="padding:5px; vertical-align:middle;">
                    Diagnosis sesuai pasien dengan penyakit Parkinson
                </td>
                <td style="padding:5px; vertical-align:middle; width:30px; text-align:center; font-weight:bold;"></td>
                <td style="padding:5px; vertical-align:middle; width:30px; text-align:center; font-weight:bold;"></td>
            </tr>
            <tr style="">
                <td style="padding:5px; vertical-align:middle;">
                    Skor nyeri sesuai pemeriksaan obat-obatan, riwayat irah bening lama, perubahan posisi
                    yang akan meningkatkan risiko jatuh
                </td>
                <td style="padding:5px; vertical-align:middle; width:30px; text-align:center; font-weight:bold;"></td>
                <td style="padding:5px; vertical-align:middle; width:30px; text-align:center; font-weight:bold;"></td>
            </tr>
            <tr style="">
                <td style="padding:5px; vertical-align:middle;">
                    Pasien saat ini sedang berada pada salah satu lokasi ini: rehab medik, ruangan dengan penanganan
                    khusus, atau kamar jenazah
                </td>
                <td style="padding:5px; vertical-align:middle; width:30px; text-align:center; font-weight:bold;"></td>
                <td style="padding:5px; vertical-align:middle; width:30px; text-align:center; font-weight:bold;"></td>
            </tr>
        </table>
        <table border="1"
            style="margin-top:5px; width:100%; border-collapse:collapse; font-family:Arial,sans-serif; font-size:14px; text-align:center;">
            <!-- Header -->
            <tr style="background-color:#f0f0f0; font-weight:bold; height:50px;">
                <td style="padding:5px; width:5%;">No</td>
                <td style="padding:5px; width:20%;">Hasil penilaian</td>
                <td style="padding:5px; width:25%;">Tindak lanjut</td>
                <td style="padding:5px; width:30%;">Intervensi</td>
                <td style="padding:5px; width:10%;">Ket</td>
                <td style="padding:5px; width:10%;">Paraf</td>
            </tr>

            <!-- Baris 1 -->
            <tr style="height:20px;">
                <td style="padding:5px; vertical-align:middle;">1</td>
                <td style="padding:5px; vertical-align:middle; text-align:left;">

                    <span style="font-size: 10px">Tidak Beresiko</span>
                </td>
                <td style="padding:5px; vertical-align:middle; text-align:left;">

                    <span style="font-size: 10px ">Tidak ditemukan a, b, c, d dan e</span>
                </td>
                <td style="padding:5px; vertical-align:middle; text-align:left;">
                    <span style="font-size: 10px "> Tidak ada tindakan </span>
                </td>
                <td style="padding:5px; vertical-align:middle;"></td>
                <td style="padding:5px; vertical-align:middle;"></td>
            </tr>

            <!-- Baris 2 -->
            <tr style="height:20px;">
                <td style="padding:5px; vertical-align:middle;">2</td>
                <td style="padding:5px; vertical-align:middle; text-align:left;">
                    <span style="font-size: 10px ">Berisiko jatuh</span>
                </td>
                <td style="padding:5px; vertical-align:middle; text-align:left;">
                    <span style="font-size: 10px ">Ditemukan salah satu atau lebih dari penilaian di atas
                </td></span>
                <td style="padding:5px; vertical-align:middle; text-align:left;">
                    <span style="font-size: 10px ">Lakukan tindakan pencegahan jatuh<br>
                        Pasang pita kuning<br>
                        Beri bantuan berjalan</span>
                </td>
                <td style="padding:5px; vertical-align:middle;"></td>
                <td style="padding:5px; vertical-align:middle;"></td>
            </tr>
        </table>
    </div>
    <h2>
        III. D. Status Psikologis
    </h2>
    <div>
        <table style="">
            <tr>
                <td rowspan="3">
                    Status Psikologis
                </td>
                <td>
                    <label style="margin-right:18px; "><input type="checkbox" value="1"> Tenang </label>
                    <label style="margin-right:18px; "><input type="checkbox" value="2"> Marah </label>
                    <label style="margin-right:18px; "><input type="checkbox" value="3"> Cemas </label>
                    <label style="margin-right:18px; "><input type="checkbox" value="4"> Gelisah </label>
                    <label style="margin-right:18px; "><input type="checkbox" value="5">Lainnya</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label style="margin-right:18px; "><input type="checkbox" value="1"> Sedih </label>
                    <label style="margin-right:18px; "><input type="checkbox" value="2"> Takut </label>
                    <label style="margin-right:18px; "><input type="checkbox" value="3"> Depresi </label>
                    <label style="margin-right:18px; "><input type="checkbox" value="4"> Cenderung Bunuh
                        Diri ke <span></span> </label>

                </td>
            </tr>
        </table>
        <label for="">Permasalahan yang di konsultasikan</label><input
            style="margin-top:10px; border-bottom : 1px solid black" type="text">

    </div>
    <h2>
        III. E. Status Sosial Budaya
    </h2>
    <div>
        <div>
            <label>Pekerjaan : </label>
            <label style="margin-right:18px; "><input type="checkbox" value="1"> PNS/TNI/POLRI </label>
            <label style="margin-right:18px; "><input type="checkbox" value="2"> Swasta</label>
            <label style="margin-right:18px; "><input type="checkbox" value="3"> BUMN </label>
            <label style="margin-right:18px; "><input type="checkbox" value="4"> Pensiunan </label>
            <label style="margin-right:18px; "><input type="checkbox" value="5"> Petani </label>
            <label style="margin-right:18px; "><input type="checkbox" value="5">Lainnya</label>
            <label style="margin-right:18px; ">...............</label>
        </div>
        <div>
            <label>Ada kesulitan memenuhi kebutuhan dasar : </label>
            <label style="margin-right:18px; "><input type="checkbox"> Tidak </label>
            <label style="margin-right:18px; "><input type="checkbox"> Ya, Jelaskan</label>
            <span></span>

            <label for="">Permasalahan yang di konsultasikan</label><input
                style="margin-top:10px; border-bottom : 1px solid black" type="text">
        </div>
        <div>
            <label>Hubungan Dengan Anggota Keluarga : </label>
            <label style="margin-right:18px; "><input type="checkbox" value="1"> Baik </label>
            <label style="margin-right:18px; "><input type="checkbox" value="2"> Tidak Baik</label>
            <br>
            <label style="margin-right:18px; "> Suku : </label>
            <span></span>
        </div>
        <div>
            <label>Pendidikan : </label>
            <label style="margin-right:18px; "><input type="checkbox" value="1"> SD </label>
            <label style="margin-right:18px; "><input type="checkbox" value="2"> SMP</label>
            <label style="margin-right:18px; "><input type="checkbox" value="3"> SMU </label>

            <label style="margin-right:18px; "> Diploma : </label>
            <span></span>

            <label style="margin-right:18px; "><input type="checkbox" value="5"> S-1 </label>
            <label style="margin-right:18px; "><input type="checkbox" value="5"> S-2 </label>
            <label style="margin-right:18px; "><input type="checkbox" value="5"> S-3 </label>
        </div>
        <div>
            <label>Budaya/Adat istiadat yang dipercayakan pasien : </label>
            <label style="margin-right:18px; "><input type="checkbox" value="1"> Tidak Ada </label>
            <label style="margin-right:18px; "><input type="checkbox" value="2"> Ada, Sebutkan : </label>
        </div>
    </div>


    <!-- JUDUL -->
    <h2>III.F. STATUS GIZI-MST</h2>

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
                <label style="display:flex;align-items:center;line-height:1.4;position:relative;">
                    <input type="checkbox" style="width:14px;">
                    <span style="flex:1;padding-left:6px;">Tidak ada</span>
                    <span style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">0</span>
                </label>
                <label style="display:flex;align-items:center;line-height:1.4;position:relative;">
                    <input type="checkbox" style="width:14px;">
                    <span style="flex:1;padding-left:6px;">Tidak yakin/ tidak tahu/ terasa baju longgar</span>
                    <span style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">2</span>
                </label>
            </div>
        </div>

        <div style="padding-left:20px;padding-top:6px;font-size:13.5px;color:#555;line-height:1.4;">
            Jika "Ya" berapa penurunan berat badan tersebut:
        </div>

        <div style="padding-top:4px;">
            <div style="position:relative;padding-left:40px;padding-right:40px;">
                <label style="display:flex;align-items:center;line-height:1.4;position:relative;">
                    <input type="checkbox" style="width:14px;height:8px;">
                    <span style="flex:1;padding-left:6px;">1 sd 5 Kg</span>
                    <span style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">1</span>
                </label>
                <label style="display:flex;align-items:center;line-height:1.4;position:relative;">
                    <input type="checkbox" style="width:14px;height:8px;">
                    <span style="flex:1;padding-left:6px;">6 sd 10 Kg</span>
                    <span style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">2</span>
                </label>
                <label style="display:flex;align-items:center;line-height:1.4;position:relative;">
                    <input type="checkbox" style="width:14px;height:8px;">
                    <span style="flex:1;padding-left:6px;">11 sd 15 Kg</span>
                    <span style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">3</span>
                </label>
                <label style="display:flex;align-items:center;line-height:1.4;position:relative;">
                    <input type="checkbox" style="width:14px;height:8px;">
                    <span style="flex:1;padding-left:6px;">> 15 Kg</span>
                    <span style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">4</span>
                </label>
            </div>
        </div>
    </div>

    <!-- PERTANYAAN 2 -->
    <div style="padding-top:10px;line-height:1.5;">
        <div>2. Apakah asupan makan berkurang karena tidak nafsu makan?</div>
        <div style="padding-top:6px;">
            <div style="position:relative;padding-left:20px;padding-right:40px;">
                <label style="display:flex;align-items:center;line-height:1.4;position:relative;">
                    <input type="checkbox" style="width:14px;height:8px;">
                    <span style="flex:1;padding-left:6px;">Tidak</span>
                    <span style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">0</span>
                </label>
                <label style="display:flex;align-items:center;line-height:1.4;position:relative;">
                    <input type="checkbox" style="width:14px;height:8px;">
                    <span style="flex:1;padding-left:6px;">Ya</span>
                    <span style="position:absolute;right:0;font-weight:bold;width:20px;text-align:right;">1</span>
                </label>
            </div>
        </div>
    </div>

    <!-- PERTANYAAN 3 -->
    <div style="line-height:1.5;">
        <div>
            3. Pasien dengan diagnosa khusus :
            <label style="display:inline-flex;align-items:center;padding-left:8px;">
                <input type="checkbox" style="width:14px;height:8px;"> Ya
            </label>
            <label style="display:inline-flex;align-items:center;padding-left:12px;">
                <input type="checkbox" style="width:14px;height:8px;"> Tidak
            </label>
        </div>
        <div style="padding-left:20px;padding-top:4px;font-size:13.5px;color:#555;line-height:1.4;">
            (Diabetes, Kemo, HD, geriatri, penurunan imun, dll disebutkan:
        </div>
    </div>

    <!-- TOTAL SKOR -->
    <table>
        <tr>
            <th style="text-align: left;    ">
                TOTAL SKOR
            </th>
            <th>
                <input type="text" readonly
                    style="width:48px;height:32px;text-align:center;border:2px solid #000;font-weight:bold;font-size:15px;">

            </th>
        </tr>
    </table>
    </div>

    <!-- CATATAN -->
    <div style="font-style:italic;color:#c00;font-weight:bold;font-size:13.5px;">
        (Bila skor ≥ 2 dan atau pasien dengan diagnosis/ kondisi khusus dilaporkan ke dokter pemeriksa)
    </div>
    <!-- Footer -->
    <table class="footer" style="width:100%;">
        <tr>
            <td style="width:50%;">Nomor: A3/IRM/Rev 02/2023</td>
            <td style="text-align:right;">Hal: 3 dari 4</td>
        </tr>
    </table>
    <h2>
        III.G. STATUS FUNGSIONAL
    </h2>
    <label style="margin-right:18px; "><input type="checkbox" value="1"> Mandiri </label>
    <label style="margin-right:18px; "><input type="checkbox" value="2"> Ketergantungan ringan</label>
    <label style="margin-right:18px; "><input type="checkbox" value="3"> Ketergantungan sedang </label>
    <label style="margin-right:18px; "><input type="checkbox" value="4"> Ketergantungan Berat </label>
    <label style="margin-right:18px; "><input type="checkbox" value="4"> Ketergantungan Total </label>
    <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:6px;">
        <tr>
            <td colspan="6" style="background:#f2f2f2; font-weight:bold; padding:5px;">
                III.H. EDUKASI/ PENDIDIKAN DAN PENGAJARAN
            </td>
        </tr>
        <tr>
            <td style="width:20%; vertical-align:top; padding:4px;">Bicara</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox"> Normal
                <input type="checkbox"> Tidak normal, gangguan bicara sejak:
                ____________________________________________
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Bahasa sehari-hari</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox"> Indonesia
                <input type="checkbox"> Aceh
                <input type="checkbox"> Lainnya: _________________________________
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Perlu penerjemah</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox"> Tidak
                <input type="checkbox"> Ya, bahasa: ______________________________
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Hambatan komunikasi</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox"> Bahasa
                <input type="checkbox"> Menulis
                <input type="checkbox"> Cemas
                <input type="checkbox"> Lainnya: ..................................................
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Media belajar yang disukai</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox"> Audio-visual
                <input type="checkbox"> Brosur
                <input type="checkbox"> Diskusi
                <input type="checkbox"> Lainnya: .............................................
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Tingkat Pendidikan</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox"> TK
                <input type="checkbox"> SD
                <input type="checkbox"> SMP
                <input type="checkbox"> SMA
                <input type="checkbox"> Sarjana ......................
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Edukasi yang dibutuhkan</td>
            <td colspan="5" style="padding:4px;">
                : <input type="checkbox"> Proses penyakit
                <input type="checkbox"> Pengobatan/Tindakan
                <input type="checkbox"> Terapi/Obat
                <input type="checkbox"> Nutrisi
                <input type="checkbox"> Lainnya: ..................................
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Catatan Khusus</td>
            <td colspan="5" style="padding:4px;">
                :
                ........................................................................................................................<br>
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
            <td style="width:35%; padding:4px;">: .......................................................</td>
            <td colspan="2" style="padding:4px; font-size:9pt;">
                Jika salah satu jawaban <b>"Ya"</b>, maka pasien membutuhkan rencana pulang khusus
            </td>
        </tr>
        <tr>
            <td style="padding:4px;">Usia Lanjut (&gt; 60 thn)</td>
            <td style="padding:4px;">: <input type="checkbox"> Ya <input type="checkbox"> Tidak</td>
            <td colspan="2" rowspan="4"></td>
        </tr>
        <tr>
            <td style="padding:4px;">Hambatan Mobilisasi</td>
            <td style="padding:4px;">: <input type="checkbox"> Ya <input type="checkbox"> Tidak</td>
        </tr>
        <tr>
            <td style="padding:4px;">Membutuhkan Pelayanan Medis Berkelanjutan</td>
            <td style="padding:4px;">: <input type="checkbox"> Ya <input type="checkbox"> Tidak</td>
        </tr>
        <tr>
            <td style="padding:4px;">Ketergantungan dengan orang lain dalam aktivitas harian</td>
            <td style="padding:4px;">: <input type="checkbox"> Ya <input type="checkbox"> Tidak</td>
        </tr>
    </table>
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
        <!-- Baris kosong untuk diisi -->
        <tr>
            <td style="height:35px; border:1px solid #000; height:20px;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
        </tr>
        <tr>
            <td style="height:35px; border:1px solid #000; height:20px;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
        </tr>
        <tr>
            <td style="height:35px; border:1px solid #000; height:20px;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
        </tr>
        <tr>
            <td style="height:35px; border:1px solid #000; height:20px;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
        </tr>
        <tr>
            <td style="height:35px; border:1px solid #000; height:20px;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
        </tr>
        <tr>
            <td style="height:35px; border:1px solid #000; height:20px;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
        </tr>
        <tr>
            <td style="height:35px; border:1px solid #000; height:20px;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
            <td style="height:35px; border:1px solid #000;"></td>
        </tr>
    </table>
    <!-- Bagian tanda tangan perawat pengkaji -->
    <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:8px; ">
        <tr>
            <td style="width:15%; padding:4px;">Tanggal</td>
            <td style="width:30%; border-bottom:1px solid #000;">&nbsp;</td>
            <td style="width:5%; text-align:right;">Jam :</td>
            <td style="width:10%; border-bottom:1px solid #000;">&nbsp;</td>
            <td style="width:5%; text-align:center;">WIB</td>
        </tr>
        <tr>
            <td style="padding:4px;">Perawat pengkaji</td>
            <td style="border-bottom:1px solid #000;">&nbsp;</td>
            <td style="text-align:right;">Tanda tangan :</td>
            <td colspan="2" style="border-bottom:1px solid #000;">&nbsp;</td>
        </tr>
    </table>

    <!-- Bagian penerimaan perawat ruang -->
    <table style="width:100%; border-collapse:collapse; font-size:9pt; margin-top:6px; ">
        <tr>
            <td style="width:40%; padding:4px;">Diterima perawat ruang :</td>
            <td style="width:60%; border-bottom:1px solid #000;">&nbsp;</td>
        </tr>
        <tr>
            <td style="padding:4px;">Tanggal :</td>
            <td style="border-bottom:1px solid #000;">&nbsp; &nbsp; - &nbsp; &nbsp; - &nbsp; &nbsp; Jam: __________ WIB
            </td>
        </tr>
        <tr style="height: 100px;">
            <td style="padding:4px;"></td>
            <td style="text-align:right; padding-right:20px;">
                Nama dan TTD perawat penerima<br>
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