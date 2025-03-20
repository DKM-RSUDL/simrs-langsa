<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Asesmen Keperawatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
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

        .patient-info,
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .patient-info td,
        .detail-table td {
            padding: 5px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        .section-title {
            background: #f5f5f5;
            padding: 5px;
            font-weight: bold;
            border-left: 3px solid #333;
            /* margin-bottom: 10px; */
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 10px;
        }

        .sign-box {
            width: 45%;
            float: right;
            text-align: center;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .detail-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .detail-table th,
    .detail-table td {
        padding: 5px;
        border: 1px solid #333;
    }
    .text-center {
        text-align: center;
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
            <p>Formulir Asesmen Keperawatan & Medis<br>IGD</p>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ $pasien->kd_pasien }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ str()->title($pasien->nama) }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';

                            if($pasien->jenis_kelamin == 1) $gender = 'Laki-Laki';
                            if($pasien->jenis_kelamin == 0) $gender = 'Perempuan';

                            echo $gender;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ date('d/m/Y', strtotime($pasien->tgl_lahir)) }}</td>
                </tr>
            </table>
        </div>
    </header>


    <div class="section-title mt-3">1. Status Airway</div>
    <table class="detail-table">
        <tr>
            <td class="col-header">Status Airway</td>
            <td>: {{ $asesmenKepUmum->airway_status ?? '-' }}</td>
            <td class="col-header">Suara Nafas</td>
            <td>: {{ $asesmenKepUmum->airway_suara_nafas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Diagnosis Keperawatan</td>
            <td>:
                @php
                    $jenisDiagnosis = $asesmenKepUmum->airway_diagnosis ?? '-';
                    switch ($jenisDiagnosis) {
                        case '1':
                            echo 'Aktual';
                            break;
                        case '2':
                            echo 'Resiko';
                            break;
                        default:
                            echo $jenisDiagnosis;
                    }
                @endphp
            </td>
            <td>Tindakan Keperawatan</td>
            <td>
                @if(!empty($asesmenKepUmum->airway_tindakan))
                    @php
                        $tindakan = json_decode($asesmenKepUmum->airway_tindakan, true) ?? [];
                    @endphp
                    @if(is_array($tindakan) && count($tindakan) > 0)
                        <ul class="list-unstyled mb-0">
                            @foreach($tindakan as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $asesmenKepUmum->airway_tindakan }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">2. Status Breathing</div>
    <table class="detail-table">
        <tr>
            <td>Pola Nafas</td>
            <td>: {{ $asesmenBreathing->breathing_pola_nafas ?? '-' }}</td>
            <td>Bunyi nafas</td>
            <td>: {{ $asesmenBreathing->breathing_bunyi_nafas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Irama Nafas</td>
            <td>:
                @php
                    $breathingIramaNafas = $asesmenBreathing->breathing_irama_nafas ?? '-';
                    switch ($breathingIramaNafas) {
                        case '1':
                            echo 'Teratur';
                            break;
                        case '2':
                            echo 'Tidak Teratur';
                            break;
                        default:
                            echo $breathingIramaNafas;
                    }
                @endphp
            </td>
            <td>Tanda Distress Nafas</td>
            <td>: {{ $asesmenBreathing->breathing_tanda_distress ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jalan Pernafasan</td>
            <td>:
                @php
                    $breathingJalanNafas = $asesmenBreathing->breathing_jalan_nafas ?? '-';
                    switch ($breathingJalanNafas) {
                        case '1':
                            echo 'Pernafasan Dada';
                            break;
                        case '2':
                            echo 'Pernafasan Perut';
                            break;
                        default:
                            echo $breathingJalanNafas;
                    }
                @endphp
            </td>
            <td>Lainnya</td>
            <td>: {{ $asesmenBreathing->breathing_lainnya ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pola Nafas Tidak Efektif</td>
            <td>:
                @php
                    $breathingDiagnosisNafas = $asesmenBreathing->breathing_diagnosis_nafas ?? '-';
                    switch ($breathingDiagnosisNafas) {
                        case '1':
                            echo 'Aktual';
                            break;
                        case '2':
                            echo 'Resiko';
                            break;
                        default:
                            echo $breathingDiagnosisNafas;
                    }
                @endphp
            </td>
            <td>Gangguan Pertukaran Gas</td>
            <td>:
                @php
                    $breathingGangguan = $asesmenBreathing->breathing_gangguan ?? '-';
                    switch ($breathingGangguan) {
                        case '1':
                            echo 'Aktual';
                            break;
                        case '2':
                            echo 'Resiko';
                            break;
                        default:
                            echo $breathingGangguan;
                    }
                @endphp
            </td>
        </tr>
        <tr>
            <td>Tindakan Keperawatan</td>
            <td colspan="3">
                @if($asesmenBreathing->breathing_tindakan)
                    @php
                        $tindakan = json_decode($asesmenBreathing->breathing_tindakan, true);
                    @endphp
                    @if(is_array($tindakan))
                        <ul class="list-unstyled mb-0">
                            @foreach($tindakan as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $asesmenBreathing->breathing_tindakan }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">3. Status Circulation</div>
    <table class="detail-table">
        <tr>
            <td>Akral</td>
            <td>:
                @php
                    $circulationakral = $asesmenCirculation->circulation_akral ?? '-';
                    echo ($circulationakral === '1') ? 'Hangat' : ($circulationakral === '2' ? 'Dingin' : $circulationakral);
                @endphp
            </td>
            <td>Pucat</td>
            <td>:
                @php
                    $circulationpucat = $asesmenCirculation->circulation_pucat ?? '-';
                    echo ($circulationpucat === '0') ? 'Tidak' : ($circulationpucat === '1' ? 'Ya' : $circulationpucat);
                @endphp
            </td>
        </tr>
        <tr>
            <td>Cianoisis</td>
            <td>:
                @php
                    $circulationcianosis = $asesmenCirculation->circulation_cianosis ?? '-';
                    echo ($circulationcianosis === '0') ? 'Tidak' : ($circulationcianosis === '1' ? 'Ya' : $circulationcianosis);
                @endphp
            </td>
            <td>Pengisian Kapiler</td>
            <td>:
                @php
                    $circulationkapiler = $asesmenCirculation->circulation_kapiler ?? '-';
                    echo ($circulationkapiler === '1') ? '< 2 Detik' : ($circulationkapiler === '2' ? '> 2 Detik' : $circulationkapiler);
                @endphp
            </td>
        </tr>
        <tr>
            <td>Kelembapan Kulit</td>
            <td>:
                @php
                    $circulationkelembapankulit = $asesmenCirculation->circulation_kelembapan_kulit ?? '-';
                    echo ($circulationkelembapankulit === '1') ? 'Lembab' : ($circulationkelembapankulit === '2' ? 'Kering' : $circulationkelembapankulit);
                @endphp
            </td>
            <td>Tugor</td>
            <td>:
                @php
                    $circulationturgor = $asesmenCirculation->circulation_turgor ?? '-';
                    echo ($circulationturgor === '1') ? 'Normal' : ($circulationturgor === '0' ? 'Kurang' : $circulationturgor);
                @endphp
            </td>
        </tr>
        <tr>
            <td>Transfursi Darah
                <p>Jumlah Transfursi (cc)</p>
            </td>
            <td>:
                @php
                    $circulationtransfusi = $asesmenCirculation->circulation_transfusi ?? '-';
                    echo ($circulationtransfusi === '1') ? 'Ya' : ($circulationtransfusi === '0' ? 'Tidak' : $circulationtransfusi);
                @endphp
                <p>: {{ $asesmenCirculation->circulation_transfusi_jumlah ?? '-' }}</p>
            </td>
            <td>Lainnya</td>
            <td>: {{ $asesmenCirculation->circulation_lain ?? '-' }}</td>
        </tr>
        <tr>
            <td>Diagnosis Keperawatan <br>
                - Perfusi Jaringan Perifer Tidak Efektif <br>
                - Defisit Volume Cairan
            </td>
            <td><br>
                :
                @php
                    $circulationdiagnosisperfusi = $asesmenCirculation->circulation_diagnosis_perfusi ?? '-';
                    echo ($circulationdiagnosisperfusi === '1') ? 'Aktual' : ($circulationdiagnosisperfusi === '2' ? 'Risiko' : $circulationdiagnosisperfusi);
                @endphp
                <br>
                :
                @php
                    $circulationdiagnosisdefisit = $asesmenCirculation->circulation_diagnosis_defisit ?? '-';
                    echo ($circulationdiagnosisdefisit === '1') ? 'Aktual' : ($circulationdiagnosisdefisit === '2' ? 'Risiko' : $circulationdiagnosisdefisit);
                @endphp
            </td>
            <td>Tindakan Keperawatan</td>
            <td>
                @if($asesmenCirculation->circulation_tindakan)
                    @php
                        $circulationtindakan = json_decode($asesmenCirculation->circulation_tindakan, true);
                    @endphp
                    @if(is_array($circulationtindakan))
                        <ul class="list-unstyled mb-0">
                            @foreach($circulationtindakan as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $asesmenCirculation->circulation_tindakan }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">4. Status Disability</div>
    <table class="detail-table">
        <tr>
            <td>Kesadaran</td>
            <td>:
                {{ $asesmenDisability->disability_kesadaran ?? '-' }}
            </td>
            <td>Pupil <br>
                - Isokor/Anisokor
                <br>
                - Respon Cahaya
            </td>
            <td><br>:
                @php
                    $disabilityisokor = $asesmenDisability->disability_isokor ?? '-';
                    echo ($disabilityisokor === '1') ? 'Isokor' : ($disabilityisokor === '2' ? 'Anisokor' : $disabilityisokor);
                @endphp
                <br>:
                @php
                    $disabilityresponcahaya = $asesmenDisability->disability_respon_cahaya ?? '-';
                    echo ($disabilityresponcahaya === '1') ? 'Isokor' : ($disabilityresponcahaya === '2' ? 'Anisokor' : $disabilityresponcahaya);
                @endphp
            </td>
        </tr>
        <tr>
            <td>Diameter Pupil (mm)</td>
            <td>: {{ $asesmenDisability->disability_diameter_pupil ?? '-' }}</td>
            <td>Ekstremitas <br>
                - Motorik <br>
                - Sensorik
            </td>
            <td>
                <br>:
                @php
                    $disabilitymotorik = $asesmenDisability->disability_motorik ?? '-';
                    echo ($disabilitymotorik === '1') ? 'Ya' : ($disabilitymotorik === '0' ? 'Tidak' : $disabilitymotorik);
                @endphp
                <br>:
                @php
                    $disabilitysensorik = $asesmenDisability->disability_sensorik ?? '-';
                    echo ($disabilitysensorik === '1') ? 'Ya' : ($disabilitysensorik === '0' ? 'Tidak' : $disabilitysensorik);
                @endphp
            </td>
        </tr>
        <tr>
            <td>Kekuatan Otot</td>
            <td>: {{ $asesmenDisability->disability_kekuatan_otot }}</td>
            <td>Diagnosis Keperawatan <br>
                - Perfusi jaringan cereberal tidak efektif <br>
                - Intoleransi aktivitas <br>
                - Kendala komunikasi verbal <br>
                - Kejang ulang <br>
                - Penurunan kesadaran
            </td>
            <td>
                <br>:
                @php
                    $disabilitydiagnosisperfusi = $asesmenDisability->disability_diagnosis_perfusi ?? '-';
                    echo ($disabilitydiagnosisperfusi === '1') ? 'Aktual' : ($disabilitydiagnosisperfusi === '2' ? 'Resiko' : $disabilitydiagnosisperfusi);
                @endphp
                <br>:
                @php
                    $disabilitydiagnosisintoleransi = $asesmenDisability->disability_diagnosis_intoleransi ?? '-';
                    echo ($disabilitydiagnosisintoleransi === '1') ? 'Aktual' : ($disabilitydiagnosisintoleransi === '2' ? 'Resiko' : $disabilitydiagnosisintoleransi);
                @endphp
                <br>:
                @php
                    $disabilitydiagnosiskomunikasi = $asesmenDisability->disability_diagnosis_komunikasi ?? '-';
                    echo ($disabilitydiagnosiskomunikasi === '1') ? 'Aktual' : ($disabilitydiagnosiskomunikasi === '2' ? 'Resiko' : $disabilitydiagnosiskomunikasi);
                @endphp
                <br>:
                @php
                    $disabilitydiagnosiskejang = $asesmenDisability->disability_diagnosis_kejang ?? '-';
                    echo ($disabilitydiagnosiskejang === '1') ? 'Aktual' : ($disabilitydiagnosiskejang === '2' ? 'Resiko' : $disabilitydiagnosiskejang);
                @endphp
                <br>:
                @php
                    $disabilitydiagnosiskesadaran = $asesmenDisability->disability_diagnosis_kesadaran ?? '-';
                    echo ($disabilitydiagnosiskesadaran === '1') ? 'Aktual' : ($disabilitydiagnosiskesadaran === '2' ? 'Resiko' : $disabilitydiagnosiskesadaran);
                @endphp
            </td>
        </tr>
        <tr>
            <td>Lainnya</td>
            <td>: {{ $asesmenDisability->disability_lainnya ?? '-' }}</td>
            <td>Tindakan Keperawatan</td>
            <td>
                @if($asesmenDisability->disability_tindakan)
                    @php
                        $disabilitytindakan = json_decode($asesmenDisability->disability_tindakan, true);
                    @endphp
                    @if(is_array($disabilitytindakan))
                        <ul class="list-unstyled mb-0">
                            @foreach($disabilitytindakan as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $asesmenDisability->disability_tindakan }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">5. Status Exposure</div>
    <table class="detail-table">
        <tr>
            <td>Deformitas <br> Daerah</td>
            <td>:
                @php
                    $exposuredeformitas = $asesmenExposure->exposure_deformitas ?? '-';
                    echo ($exposuredeformitas === '1') ? 'Ya' : ($exposuredeformitas === '0' ? 'Tidak' : $exposuredeformitas);
                @endphp
                <br>: {{ $asesmenExposure->exposure_deformitas_daerah ?? '-' }}
            </td>
            <td>Kontusion <br> Daerah</td>
            <td>:
                @php
                    $exposure_kontusion = $asesmenExposure->exposure_kontusion ?? '-';
                    echo ($exposure_kontusion === '1') ? 'Ya' : ($exposure_kontusion === '0' ? 'Tidak' : $exposure_kontusion);
                @endphp
                <br>: {{ $asesmenExposure->exposure_kontusion_daerah ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>Abrasi <br> Daerah</td>
            <td>:
                @php
                    $exposureabrasi = $asesmenExposure->exposure_abrasi ?? '-';
                    echo ($exposureabrasi === '1') ? 'Ya' : ($exposureabrasi === '0' ? 'Tidak' : $exposureabrasi);
                @endphp
                <br>: {{ $asesmenExposure->exposure_abrasi_daerah ?? '-' }}
            </td>
            <td>Penetrasi <br> Daerah</td>
            <td>:
                @php
                    $exposurepenetrasi = $asesmenExposure->exposure_penetrasi ?? '-';
                    echo ($exposurepenetrasi === '1') ? 'Ya' : ($exposurepenetrasi === '0' ? 'Tidak' : $exposurepenetrasi);
                @endphp
                <br>: {{ $asesmenExposure->exposure_penetrasi_daerah ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>Laserasi <br> Daerah</td>
            <td>:
                @php
                    $exposurelaserasi = $asesmenExposure->exposure_laserasi ?? '-';
                    echo ($exposurelaserasi === '1') ? 'Ya' : ($exposurelaserasi === '0' ? 'Tidak' : $exposurelaserasi);
                @endphp
                <br>: {{ $asesmenExposure->exposure_laserasi_daerah ?? '-' }}
            </td>
            <td>Edema <br> Daerah</td>
            <td>:
                @php
                    $exposureedema = $asesmenExposure->exposure_edema ?? '-';
                    echo ($exposureedema === '1') ? 'Ya' : ($exposureedema === '0' ? 'Tidak' : $exposureedema);
                @endphp
                <br>: {{ $asesmenExposure->exposure_edema_daerah ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>Kedalaman luka (cm)</td>
            <td>:
                {{ $asesmenExposure->exposure_kedalaman_luka ?? '-' }}
            </td>
            <td>Lainnya</td>
            <td>:
                {{ $asesmenExposure->exposure_lainnya ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>Diagnosis Keperawatan <br>
                - Kerusakan Mobilitas Fisik <br>
                - Kerusakan Integritas Jaringan
            </td>
            <td><br>:
                @php
                    $exposurediagnosismobilitasi = $asesmenExposure->exposure_diagnosis_mobilitasi ?? '-';
                    echo ($exposurediagnosismobilitasi === '1') ? 'Aktual' : ($exposurediagnosismobilitasi === '2' ? 'Resiko' : $exposurediagnosismobilitasi);
                @endphp
                <br>:
                @php
                    $exposurediagosisintegritas = $asesmenExposure->exposure_diagosis_integritas ?? '-';
                    echo ($exposurediagosisintegritas === '1') ? 'Aktual' : ($exposurediagosisintegritas === '2' ? 'Resiko' : $exposurediagosisintegritas);
                @endphp
            </td>
            <td>Lainnya</td>
            <td>:
                {{ $asesmenExposure->exposure_diagnosis_lainnya ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>Tindakan Keperawatan</td>
            <td colspan="3">
                @if($asesmenExposure->exposure_tindakan)
                    @php
                        $exposuretindakan = json_decode($asesmenExposure->exposure_tindakan, true);
                    @endphp
                    @if(is_array($exposuretindakan))
                        <ul class="list-unstyled mb-0">
                            @foreach($exposuretindakan as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $asesmenExposure->exposure_tindakan }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title">6. Skala Nyeri</div>
    <table class="detail-table">
        <tr>
            <td>Skala Nyeri</td>
            <td>: {{ $asesmenSkalaNyeri->skala_nyeri ?? '-' }}</td>
            <td>Lokasi</td>
            <td>: {{ $asesmenSkalaNyeri->skala_nyeri_lokasi ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pemberat</td>
            <td>: {{ $faktorPemberatData[$asesmenSkalaNyeri->skala_nyeri_pemberat_id] ?? '-' }}</td>
            <td>Kualitas</td>
            <td>: {{ $kualitasNyeriData[$asesmenSkalaNyeri->skala_nyeri_kualitas_id] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Menjalar</td>
            <td>: {{ $menjalarData[$asesmenSkalaNyeri->skala_nyeri_menjalar_id] ?? '-' }}</td>
            <td>Durasi</td>
            <td>: {{ $asesmenSkalaNyeri->skala_nyeri_durasi ?? '-' }}</td>
        </tr>
        <tr>
            <td>Peringan</td>
            <td>: {{ $faktorPeringanData[$asesmenSkalaNyeri->skala_nyeri_peringan_id] ?? '-' }}</td>
            <td>Frekuensi</td>
            <td>: {{ $frekuensiNyeriData[$asesmenSkalaNyeri->skala_nyeri_frekuensi_id] ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jenis</td>
            <td colspan="3">: {{ $jenisNyeriData[$asesmenSkalaNyeri->skala_nyeri_jenis_id] ?? '-' }}</td>
        </tr>
    </table>

    @php
    // Mendapatkan jenis risiko jatuh
    $risikoJatuhJenis = $asesmenRisikoJatuh->resiko_jatuh_jenis ?? null;
    @endphp

    <div class="section-title">7. Risiko Jatuh</div>

    @switch($risikoJatuhJenis)
        @case('1') {{-- Skala Umum --}}
        <table class="detail-table table table-bordered">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">Penilaian Risiko Jatuh - Skala Umum</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Apakah pasien berusia < dari 2 tahun?</td>
                    <td>
                        @php
                        $risikojatuhumumusia = $asesmenRisikoJatuh->risiko_jatuh_umum_usia ?? '-';
                        echo ($risikojatuhumumusia === '1') ? 'Ya' : ($risikojatuhumumusia === '0' ? 'Tidak' : $risikojatuhumumusia);
                        @endphp
                    </td>
                    <td>Apakah pasien dalam kondisi sebagai geriatri, dizzines, vertigo, gangguan keseimbangan, gangguan penglihatan, penggunaan obat sedasi, status kesadaran dan atau kejiwaan, konsumsi alkohol?</td>
                    <td>
                        @php
                        $risikojatuhumumkondisikhusus = $asesmenRisikoJatuh->risiko_jatuh_umum_kondisi_khusus ?? '-';
                        echo ($risikojatuhumumkondisikhusus === '1') ? 'Ya' : ($risikojatuhumumkondisikhusus === '0' ? 'Tidak' : $risikojatuhumumkondisikhusus);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Apakah pasien didiagnosis sebagai pasien dengan penyakit parkinson?</td>
                    <td>
                        @php
                        $risikojatuhumumdiagnosisparkinson = $asesmenRisikoJatuh->risiko_jatuh_umum_diagnosis_parkinson ?? '-';
                        echo ($risikojatuhumumdiagnosisparkinson === '1') ? 'Ya' : ($risikojatuhumumdiagnosisparkinson === '0' ? 'Tidak' : $risikojatuhumumdiagnosisparkinson);
                        @endphp
                    </td>
                    <td>Apakah pasien sedang mendapatkan obat sedasi, riwayat tirah baring lama, perubahan posisi yang akan meningkatkan risiko jatuh?</td>
                    <td>
                        @php
                        $risikojatuhumumpengobatanberisiko = $asesmenRisikoJatuh->risiko_jatuh_umum_pengobatan_berisiko ?? '-';
                        echo ($risikojatuhumumpengobatanberisiko === '1') ? 'Ya' : ($risikojatuhumumpengobatanberisiko === '0' ? 'Tidak' : $risikojatuhumumpengobatanberisiko);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <strong>Kesimpulan:</strong>
                        {{ $asesmenRisikoJatuh->risiko_jatuh_umum_kesimpulan ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
        @break

        @case('2') {{-- Skala Morse --}}
        <table class="detail-table table table-bordered">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">Penilaian Risiko Jatuh - Skala Morse</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Pasien pernah mengalami Jatuh?</td>
                    <td>
                        @php
                        $riwayatJatuh = $asesmenRisikoJatuh->risiko_jatuh_morse_riwayat_jatuh ?? '-';
                        echo ($riwayatJatuh === '25') ? 'Ya' : ($riwayatJatuh === '0' ? 'Tidak' : $riwayatJatuh);
                        @endphp
                    </td>
                    <td>Pasien memiliki diagnosis sekunder?</td>
                    <td>
                        @php
                        $diagnosisSekunder = $asesmenRisikoJatuh->risiko_jatuh_morse_diagnosis_sekunder ?? '-';
                        echo ($diagnosisSekunder === '15') ? 'Ya' : ($diagnosisSekunder === '0' ? 'Tidak' : $diagnosisSekunder);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Pasien membutuhkan bantuan ambulasi?</td>
                    <td>
                        @php
                        $bantuanAmbulasi = $asesmenRisikoJatuh->risiko_jatuh_morse_bantuan_ambulasi ?? '-';
                        $bantuanAmbulsiText = match($bantuanAmbulasi) {
                            '30' => 'Meja/kursi',
                            '15' => 'Kruk/tongkat/alat bantu berjalan',
                            '0' => 'Tidak ada/bed rest/bantuan perawat',
                            default => $bantuanAmbulasi
                        };
                        echo $bantuanAmbulsiText;
                        @endphp
                    </td>
                    <td>Pasien terpasang infus?</td>
                    <td>
                        @php
                        $terpasangInfus = $asesmenRisikoJatuh->risiko_jatuh_morse_terpasang_infus ?? '-';
                        echo ($terpasangInfus === '20') ? 'Ya' : ($terpasangInfus === '0' ? 'Tidak' : $terpasangInfus);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Bagaimana cara berjalan pasien?</td>
                    <td>
                        @php
                        $caraBerjalan = $asesmenRisikoJatuh->risiko_jatuh_morse_cara_berjalan ?? '-';
                        $caraBerjalanText = match($caraBerjalan) {
                            '0' => 'Normal/bed rest/kursi roda',
                            '20' => 'Terganggu',
                            '10' => 'Lemah',
                            default => $caraBerjalan
                        };
                        echo $caraBerjalanText;
                        @endphp
                    </td>
                    <td>Bagaimana status mental pasien?</td>
                    <td>
                        @php
                        $statusMental = $asesmenRisikoJatuh->risiko_jatuh_morse_status_mental ?? '-';
                        $statusMentalText = match($statusMental) {
                            '0' => 'Berorientasi pada kemampuannya',
                            '15' => 'Lupa akan keterbatasannya',
                            default => $statusMental
                        };
                        echo $statusMentalText;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <strong>Kesimpulan:</strong>
                        {{ $asesmenRisikoJatuh->risiko_jatuh_morse_kesimpulan ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
        @break

        @case('3') {{-- Skala Humpty Dumpty / Pediatrik --}}
        <table class="detail-table table table-bordered">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">Penilaian Risiko Jatuh - Skala Humpty Dumpty / Pediatrik</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Usia Anak</td>
                    <td>
                        @php
                        $usiaAnak = $asesmenRisikoJatuh->risiko_jatuh_pediatrik_usia_anak ?? '-';
                        $usiaAnakText = match($usiaAnak) {
                            '4' => 'Dibawah 3 tahun',
                            '3' => '3-7 tahun',
                            '2' => '7-13 tahun',
                            '1' => 'Diatas 13 tahun',
                            default => $usiaAnak
                        };
                        echo $usiaAnakText;
                        @endphp
                    </td>
                    <td>Jenis Kelamin</td>
                    <td>
                        @php
                        $jenisKelamin = $asesmenRisikoJatuh->risiko_jatuh_pediatrik_jenis_kelamin ?? '-';
                        echo ($jenisKelamin === '2') ? 'Laki-laki' : ($jenisKelamin === '1' ? 'Perempuan' : $jenisKelamin);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Diagnosis</td>
                    <td>
                        @php
                        $diagnosis = $asesmenRisikoJatuh->risiko_jatuh_pediatrik_diagnosis ?? '-';
                        $diagnosisText = match($diagnosis) {
                            '4' => 'Diagnosis Neurologis',
                            '3' => 'Perubahan oksigennasi (diagnosis respiratorik, dehidrasi, anemia, syncope, pusing, dsb)',
                            '2' => 'Gangguan perilaku/psikiatri',
                            '1' => 'Diagnosis lainnya',
                            default => $diagnosis
                        };
                        echo $diagnosisText;
                        @endphp
                    </td>
                    <td>Gangguan Kognitif</td>
                    <td>
                        @php
                        $gangguanKognitif = $asesmenRisikoJatuh->risiko_jatuh_pediatrik_gangguan_kognitif ?? '-';
                        $gangguanKognitifText = match($gangguanKognitif) {
                            '3' => 'Tidak menyadari keterbatasan dirinya',
                            '2' => 'Lupa akan adanya keterbatasan',
                            '1' => 'Orientasi baik terhadap diri sendiri',
                            default => $gangguanKognitif
                        };
                        echo $gangguanKognitifText;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Faktor Lingkungan</td>
                    <td>
                        @php
                        $FaktorLingkunganKognitif = $asesmenRisikoJatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? '-';
                        $FaktorLingkunganKognitifText = match($FaktorLingkunganKognitif) {
                            '4' => 'Riwayat jatuh /bayi diletakkan di tempat tidur dewasa',
                            '3' => 'Pasien menggunakan alat bantu /bayi diletakkan di tempat tidur bayi /perabot rumah',
                            '2' => 'Pasien diletakkan di tempat tidur',
                            '1' => 'Area di luar rumah sakit',
                            default => $FaktorLingkunganKognitif
                        };
                        echo $FaktorLingkunganKognitifText;
                        @endphp
                    </td>
                    <td>Pembedahan/ sedasi/ Anestesi</td>
                    <td>
                        @php
                        $pediatrikPembedahan = $asesmenRisikoJatuh->risiko_jatuh_pediatrik_pembedahan ?? '-';
                        $pediatrikPembedahanText = match($pediatrikPembedahan) {
                            '3' => 'Dalam 24 jam',
                            '2' => 'Dalam 48 jam',
                            '1' => '> 48 jam atau tidak menjalani pembedahan/sedasi/anestesi',
                            default => $pediatrikPembedahan
                        };
                        echo $pediatrikPembedahanText;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Penggunaan Medika mentos</td>
                    <td colspan="3">
                        @php
                        $pediatrikPenggunaanMentosa = $asesmenRisikoJatuh->risiko_jatuh_pediatrik_penggunaan_mentosa ?? '-';
                        $pediatrikPenggunaanMentosaText = match($pediatrikPenggunaanMentosa) {
                            '3' => 'Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi, antidepresan, pencahar, diuretik, narkose',
                            '2' => 'Penggunaan salah satu obat diatas',
                            '1' => 'Penggunaan medikasi lainnya/tidak ada mediksi',
                            default => $pediatrikPenggunaanMentosa
                        };
                        echo $pediatrikPenggunaanMentosaText;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <strong>Kesimpulan:</strong>
                        {{ $asesmenRisikoJatuh->risiko_jatuh_pediatrik_kesimpulan ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
        @break

        @case('4') {{-- Skala Ontario Modified Stratify Sydney / Lansia --}}
        <table class="detail-table table table-bordered">
            <thead>
                <tr>
                    <th colspan="4" class="text-center">Penilaian Risiko Jatuh - Skala Ontario Modified Stratify Sydney / Lansia</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Apakah pasien datang kerumah sakit karena jatuh?</td>
                    <td>
                        @php
                        $jatuhSaatMasukRs = $asesmenRisikoJatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs ?? '-';
                        echo ($jatuhSaatMasukRs === '6') ? 'Ya' : ($jatuhSaatMasukRs === '0' ? 'Tidak' : $jatuhSaatMasukRs);
                        @endphp
                    </td>
                    <td>Pasien memiliki 2 kali atau apakah pasien mengalami jatuh dalam 2 bulan terakhir ini/ diagnosis multiple?</td>
                    <td>
                        @php
                        $riwayatJatuh2Bulan = $asesmenRisikoJatuh->risiko_jatuh_lansia_riwayat_jatuh_2_bulan ?? '-';
                        echo ($riwayatJatuh2Bulan === '6') ? 'Ya' : ($riwayatJatuh2Bulan === '0' ? 'Tidak' : $riwayatJatuh2Bulan);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Apakah pasien bingung? (Tidak dapat membuat keputusan, jaga jarak tempatnya, gangguan daya ingat)</td>
                    <td>
                        @php
                        $statusBingung = $asesmenRisikoJatuh->risiko_jatuh_lansia_status_bingung ?? '-';
                        echo ($statusBingung === '14') ? 'Ya' : ($statusBingung === '0' ? 'Tidak' : $statusBingung);
                        @endphp
                    </td>
                    <td>Apakah pasien disorientasi? (tidak menyadarkan waktu, tempat atau orang)</td>
                    <td>
                        @php
                        $statusDisorientasi = $asesmenRisikoJatuh->risiko_jatuh_lansia_status_disorientasi ?? '-';
                        echo ($statusDisorientasi === '14') ? 'Ya' : ($statusDisorientasi === '0' ? 'Tidak' : $statusDisorientasi);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Apakah pasien mengalami agitasi? (keresahan, gelisah, dan cemas)</td>
                    <td>
                        @php
                        $lansiaStatusAgitasi = $asesmenRisikoJatuh->risiko_jatuh_lansia_status_agitasi ?? '-';
                        echo ($lansiaStatusAgitasi === '14') ? 'Ya' : ($lansiaStatusAgitasi === '0' ? 'Tidak' : $lansiaStatusAgitasi);
                        @endphp
                    </td>
                    <td>Apakah pasien memakai Kacamata?</td>
                    <td>
                        @php
                        $jatuhLansiaKacamata = $asesmenRisikoJatuh->risiko_jatuh_lansia_kacamata ?? '-';
                        echo ($jatuhLansiaKacamata === '1') ? 'Ya' : ($jatuhLansiaKacamata === '0' ? 'Tidak' : $jatuhLansiaKacamata);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Apakah pasien mengalami kelainya penglihatan/buram?</td>
                    <td>
                        @php
                        $lansiaKelainanPenglihatan = $asesmenRisikoJatuh->risiko_jatuh_lansia_kelainan_penglihatan ?? '-';
                        echo ($lansiaKelainanPenglihatan === '1') ? 'Ya' : ($lansiaKelainanPenglihatan === '0' ? 'Tidak' : $lansiaKelainanPenglihatan);
                        @endphp
                    </td>
                    <td>Apakah pasien mempunyai glukoma/ katarak/ degenerasi makula?</td>
                    <td>
                        @php
                        $jatuhLansiaGlukoma = $asesmenRisikoJatuh->risiko_jatuh_lansia_glukoma ?? '-';
                        echo ($jatuhLansiaGlukoma === '1') ? 'Ya' : ($jatuhLansiaGlukoma === '0' ? 'Tidak' : $jatuhLansiaGlukoma);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Apakah terdapat perubahan perilaku berkemih? (frekuensi, urgensi, inkontinensia, noktura)</td>
                    <td>
                        @php
                        $lansiaPerubahanBerkemih = $asesmenRisikoJatuh->risiko_jatuh_lansia_perubahan_berkemih ?? '-';
                        echo ($lansiaPerubahanBerkemih === '2') ? 'Ya' : ($lansiaPerubahanBerkemih === '0' ? 'Tidak' : $lansiaPerubahanBerkemih);
                        @endphp
                    </td>
                    <td>Mandiri (boleh menolak saat bantu jatuh)</td>
                    <td>
                        @php
                        $lansia_transfer_mandiri = $asesmenRisikoJatuh->risiko_jatuh_lansia_transfer_mandiri ?? '-';
                        echo ($lansia_transfer_mandiri === '0') ? 'Ya' : ($lansia_transfer_mandiri === '0' ? 'Tidak' : $lansia_transfer_mandiri);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Memerlukan sedikit bantuan (1 orang) / dalam pengawasan</td>
                    <td>
                        @php
                        $lansia_transfer_bantuan_sedikit = $asesmenRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_sedikit ?? '-';
                        echo ($lansia_transfer_bantuan_sedikit === '1') ? 'Ya' : ($lansia_transfer_bantuan_sedikit === '0' ? 'Tidak' : $lansia_transfer_bantuan_sedikit);
                        @endphp
                    </td>
                    <td>Memerlukan bantuan yang nyata (2 orang)</td>
                    <td>
                        @php
                        $lansia_transfer_bantuan_nyata = $asesmenRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_nyata ?? '-';
                        echo ($lansia_transfer_bantuan_nyata === '2') ? 'Ya' : ($lansia_transfer_bantuan_nyata === '0' ? 'Tidak' : $lansia_transfer_bantuan_nyata);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Tidak dapat duduk dengan seimbang, perlu bantuan total</td>
                    <td>
                        @php
                        $lansia_transfer_bantuan_total = $asesmenRisikoJatuh->risiko_jatuh_lansia_transfer_bantuan_total ?? '-';
                        echo ($lansia_transfer_bantuan_total === '3') ? 'Ya' : ($lansia_transfer_bantuan_total === '0' ? 'Tidak' : $lansia_transfer_bantuan_total);
                        @endphp
                    </td>
                    <td>Mandiri (dapat menggunakan alat bantu jalan)</td>
                    <td>
                        @php
                        $jatuh_lansia_mobilitas_mandiri = $asesmenRisikoJatuh->risiko_jatuh_lansia_mobilitas_mandiri ?? '-';
                        echo ($jatuh_lansia_mobilitas_mandiri === '0') ? 'Ya' : ($jatuh_lansia_mobilitas_mandiri === '0' ? 'Tidak' : $jatuh_lansia_mobilitas_mandiri);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>berjalan dengan bantuan 1 orang (verbal/ fisik)</td>
                    <td>
                        @php
                        $lansia_mobilitas_bantuan_1_orang = $asesmenRisikoJatuh->risiko_jatuh_lansia_mobilitas_bantuan_1_orang ?? '-';
                        echo ($lansia_mobilitas_bantuan_1_orang === '1') ? 'Ya' : ($lansia_mobilitas_bantuan_1_orang === '0' ? 'Tidak' : $lansia_mobilitas_bantuan_1_orang);
                        @endphp
                    </td>
                    <td>Menggunakan kusi roda</td>
                    <td>
                        @php
                        $lansia_mobilitas_kursi_roda = $asesmenRisikoJatuh->risiko_jatuh_lansia_mobilitas_kursi_roda ?? '-';
                        echo ($lansia_mobilitas_kursi_roda === '2') ? 'Ya' : ($lansia_mobilitas_kursi_roda === '0' ? 'Tidak' : $lansia_mobilitas_kursi_roda);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>Imobilisasi</td>
                    <td colspan="3">
                        @php
                        $jatuh_lansia_mobilitas_imobilisasi = $asesmenRisikoJatuh->risiko_jatuh_lansia_mobilitas_imobilisasi ?? '-';
                        echo ($jatuh_lansia_mobilitas_imobilisasi === '3') ? 'Ya' : ($jatuh_lansia_mobilitas_imobilisasi === '0' ? 'Tidak' : $jatuh_lansia_mobilitas_imobilisasi);
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <strong>Kesimpulan:</strong>
                        {{ $asesmenRisikoJatuh->risiko_jatuh_lansia_kesimpulan ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
        @break

        @case('5') {{-- Lainnya --}}
        <table class="detail-table table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Penilaian Risiko Jatuh - Lainnya</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>risiko jatuh pada lainnya.</td>
                </tr>
            </tbody>
        </table>
        @break

        @default
        <div class="text-center" role="alert">
            Belum ada penilaian risiko jatuh yang dipilih.
        </div>
    @endswitch

    {{-- Bagian Intervensi Risiko Jatuh --}}
    @if(!empty($asesmenRisikoJatuh->risik_jatuh_tindakan))
    <table class="detail-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;">No</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            @php
                $interventions = json_decode($asesmenRisikoJatuh->risik_jatuh_tindakan, true) ?? [];
            @endphp
            @if(is_array($interventions) && count($interventions) > 0)
                @foreach($interventions as $index => $intervensi)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $intervensi }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="text-center">
                        Tidak ada tindakan intervensi yang tercatat
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    @endif

    <div class="section-title">8. Status Psikologis</div>
    <table class="detail-table">
        <tr>
            <td>Kondisi psikologis</td>
            <td>:{{ optional($asesmenKepUmum)->psikologis_kondisi ?? '-' }}</td>
            <td>Potensi menyakiti diri sendiri/orang lain</td>
            <td>:
                @php
                    $psikologisPotensiMenyakiti = $asesmenKepUmum->psikologis_potensi_menyakiti ?? '-';
                    echo ($psikologisPotensiMenyakiti === '1') ? 'Ya' : ($psikologisPotensiMenyakiti === '0' ? 'Tidak' : $psikologisPotensiMenyakiti);
                @endphp
            </td>
        </tr>
        <tr>
            <td>Lainnya</td>
            <td colspan="3">: {{ $asesmenKepUmum->psikologis_lainnya }}</td>
        </tr>
    </table>

    <div class="section-title">9. Status Spiritual</div>
    <table class="detail-table">
        <tr>
            <td>Agama/Kepercayaan</td>
            <td>: {{ isset($agamaData[$asesmenKepUmum->spiritual_agama]) ? $agamaData[$asesmenKepUmum->spiritual_agama] : '-' }}</td>
            <td>Nilai Nilai Spritiual Pasien</td>
            <td>: {{ $asesmenKepUmum->spiritual_nilai }}</td>
        </tr>
    </table>

    <div class="section-title">10. Status Sosial Ekonomi</div>
    <table class="detail-table">
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ isset($pekerjaanData[$asesmenSosialEkonomi->sosial_ekonomi_pekerjaan]) ? $pekerjaanData[$asesmenSosialEkonomi->sosial_ekonomi_pekerjaan] : '-' }}</td>
            <td>Tingkat penghasilan</td>
            <td>: {{ $asesmenSosialEkonomi->sosial_ekonomi_tingkat_penghasilan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Status pernikahan</td>
            <td>:
                @php
                    $ekonomiStatusPernikahan = $asesmenSosialEkonomi->sosial_ekonomi_status_pernikahan ?? '-';
                    switch ($ekonomiStatusPernikahan) {
                        case '0':
                            echo 'Belum Kawin';
                            break;
                        case '1':
                            echo 'Kawin';
                            break;
                        case '2':
                            echo 'Janda';
                            break;
                        case '3':
                            echo 'Duda';
                            break;
                        default:
                            echo $ekonomiStatusPernikahan;
                    }
                @endphp
            </td>
            <td>Status pendidikan</td>
            <td>: {{ isset($pendidikanData[$asesmenSosialEkonomi->sosial_ekonomi_status_pernikahan]) ? $pendidikanData[$asesmenSosialEkonomi->sosial_ekonomi_status_pernikahan] : '-' }}</td>
        </tr>
        <tr>
            <td>Tempat tinggal</td>
            <td>: {{ $asesmenSosialEkonomi->sosial_ekonomi_tempat_tinggal }}</td>
            <td>Status tinggal dengan keluarga</td>
            <td>: {{ $asesmenSosialEkonomi->sosial_ekonomi_tinggal_dengan_keluarga }}</td>
        </tr>
        <tr>
            <td>Curiga penganiayaan</td>
            <td>:
                @php
                    $ekonomiCurigaPenganiayaan = $asesmenSosialEkonomi->sosial_ekonomi_curiga_penganiayaan ?? '-';
                    echo ($ekonomiCurigaPenganiayaan === '1') ? 'Ada' : ($ekonomiCurigaPenganiayaan === '0' ? 'Tidak Ada' : $ekonomiCurigaPenganiayaan);
                @endphp
            </td>
            <td>Lainnya</td>
            <td>: {{ $asesmenSosialEkonomi->sosial_ekonomi_keterangan_lain }}</td>
        </tr>
    </table>

    @php
    // Mendapatkan jenis penilaian gizi
    $jenisGizi = $asesmenStatusGizi->gizi_jenis ?? null;
    @endphp

    <div class="section-title">11. Status Gizi</div>

    @switch($jenisGizi)
        @case('1')
        <table class="detail-table">
            <tbody>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold;">
                        Penilaian Gizi - Malnutrition Screening Tool (MST)
                    </td>
                </tr>
                <tr>
                    <td>Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?</td>
                    <td>
                        @php
                        $penurunanBB = $asesmenStatusGizi->gizi_mst_penurunan_bb ?? '-';
                        $penurunanBBText = match($penurunanBB) {
                            '0' => 'Tidak ada penurunan Berat Badan (BB)',
                            '2' => 'Tidak yakin/ tidak tahu/ terasa baju lebih longgar',
                            '3' => 'Ya ada penurunan BB',
                            default => $penurunanBB
                        };
                        @endphp
                        : {{ $penurunanBBText }}
                    </td>
                </tr>
                <tr>
                    <td>Jika ada penurunan BB, berapa jumlahnya?</td>
                    <td>
                        @php
                        $jumlahPenurunanBB = $asesmenStatusGizi->gizi_mst_jumlah_penurunan_bb ?? '-';
                        $jumlahPenurunanBBText = match($jumlahPenurunanBB) {
                            '1' => '1-5 kg',
                            '2' => '6-10 kg',
                            '3' => '11-15 kg',
                            '4' => '>15 kg',
                            default => $jumlahPenurunanBB
                        };
                        @endphp
                        : {{ $jumlahPenurunanBBText }}
                    </td>
                </tr>
                <tr>
                    <td>Apakah asupan makan berkurang karena tidak nafsu makan?</td>
                    <td>: {{ $asesmenStatusGizi->gizi_mst_nafsu_makan_berkurang == '1' ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td>Pasien didiagnosa khusus seperti: DM, Cancer (kemoterapi), Geriatri, GGk (hemodialisis), Penurunan Imun</td>
                    <td>: {{ $asesmenStatusGizi->gizi_mst_diagnosis_khusus == '1' ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Kesimpulan:</strong> {{ $asesmenStatusGizi->gizi_mst_kesimpulan ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
        @break

        @case('2')
        <table class="detail-table">
            <tbody>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold;">
                        Penilaian Gizi - The Mini Nutritional Assessment (MNA) / Lansia
                    </td>
                </tr>
                <tr>
                    <td>Penurunan asupan makanan selama 3 bulan terakhir</td>
                    <td>
                        @php
                        $penurunanAsupan = $asesmenStatusGizi->gizi_mna_penurunan_asupan_3_bulan ?? '-';
                        $penurunanAsupanText = match($penurunanAsupan) {
                            '0' => 'Mengalami penurunan asupan makanan yang parah',
                            '1' => 'Mengalami penurunan asupan makanan sedang',
                            '2' => 'Tidak mengalami penurunan asupan makanan',
                            default => $penurunanAsupan
                        };
                        @endphp
                        : {{ $penurunanAsupanText }}
                    </td>
                </tr>
                <!-- Lanjutkan dengan format yang sama untuk field lainnya -->
                <tr>
                    <td>Berat Badan (BB)</td>
                    <td>: {{ $asesmenStatusGizi->gizi_mna_berat_badan ?? '-' }} Kg</td>
                </tr>
                <tr>
                    <td>Tinggi Badan (TB)</td>
                    <td>: {{ $asesmenStatusGizi->gizi_mna_tinggi_badan ?? '-' }} cm</td>
                </tr>
                <tr>
                    <td>Indeks Massa Tubuh (IMT)</td>
                    <td>: {{ $asesmenStatusGizi->gizi_mna_imt ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Kesimpulan:</strong> {{ $asesmenStatusGizi->gizi_mna_kesimpulan ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
        @break

        @case('3')
        <table class="detail-table">
            <tbody>
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold;">
                        Penilaian Gizi - Strong Kids (1 bln - 18 Tahun)
                    </td>
                </tr>
                <tr>
                    <td>Status Kurus</td>
                    <td>: {{ $asesmenStatusGizi->gizi_strong_status_kurus == '1' ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td>Penurunan Berat Badan</td>
                    <td>: {{ $asesmenStatusGizi->gizi_strong_penurunan_bb == '1' ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td>Gangguan Pencernaan</td>
                    <td>: {{ $asesmenStatusGizi->gizi_strong_gangguan_pencernaan == '1' ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td>Penyakit Berisiko Malnutrisi</td>
                    <td>: {{ $asesmenStatusGizi->gizi_strong_penyakit_berisiko == '2' ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Kesimpulan:</strong> {{ $asesmenStatusGizi->gizi_strong_kesimpulan ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
        @break

        @case('5')
        <table class="detail-table">
            <tbody>
                <tr>
                    <td style="text-align: center; font-weight: bold;">
                        Penilaian Gizi - Tidak Dapat Dinilai
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        Alasan tidak dapat dilakukan penilaian gizi:
                        {{ $asesmenStatusGizi->gizi_tidak_dapat_dinilai_alasan ?? 'Tidak ada keterangan' }}
                    </td>
                </tr>
            </tbody>
        </table>
        @break

        @default
        <table class="detail-table">
            <tbody>
                <tr>
                    <td style="text-align: center;">
                        Belum ada penilaian status gizi yang dipilih.
                    </td>
                </tr>
            </tbody>
        </table>
    @endswitch

    <div class="section-title">12. Status Fungsional</div>
    <table class="detail-table">
        <tr>
            <td>Status Fungsional</td>
            <td>: {{ $asesmenKepUmum->status_fungsional }}</td>
        </tr>
    </table>

    <div class="section-title">13. Kebutuhan Edukasi, Pendidikan dan Pengajaran</div>
    <table class="detail-table">
        <tr>
            <td>Gaya bicara</td>
            <td>:
                @php
                    $edukasiGayaBicara = $asesmenKepUmum->kebutuhan_edukasi_gaya_bicara ?? '-';
                    switch ($edukasiGayaBicara) {
                        case '0':
                            echo 'Normal';
                            break;
                        case '1':
                            echo 'Tidak Normal';
                            break;
                        case '2':
                            echo 'Belum Bisa Bicara';
                            break;
                        default:
                            echo $edukasiGayaBicara;
                    }
                @endphp
            </td>
            <td>Bahasa sehari-hari</td>
            <td>: {{ $asesmenKepUmum->kebutuhan_edukasi_bahasa_sehari_hari }}</td>
        </tr>
        <tr>
            <td>Perlu penerjemah</td>
            <td>:
                @php
                    $edukasiPerluPenerjemah = $asesmenKepUmum->kebutuhan_edukasi_perlu_penerjemah ?? '-';
                    echo ($edukasiPerluPenerjemah === '1') ? 'Ya' : ($edukasiPerluPenerjemah === '0' ? 'Tidak' : $edukasiPerluPenerjemah);
                @endphp
            </td>
            <td>Hambatan komunikasi</td>
            <td>: {{ $asesmenKepUmum->kebutuhan_edukasi_hambatan_komunikasi }}</td>
        </tr>
        <tr>
            <td>Media belajar yang disukai</td>
            <td>: {{ $asesmenKepUmum->kebutuhan_edukasi_media_belajar }}</td>
            <td>Tingkat pendidikan</td>
            <td>: {{ $asesmenKepUmum->kebutuhan_edukasi_tingkat_pendidikan }}</td>
        </tr>
        <tr>
            <td>Edukasi yang dibutuhkan</td>
            <td>: {{ $asesmenKepUmum->kebutuhan_edukasi_edukasi_dibutuhkan }}</td>
            <td>Lainnya</td>
            <td>: {{ $asesmenKepUmum->kebutuhan_edukasi_keterangan_lain }}</td>
        </tr>
    </table>

    <div class="section-title">14. Discharge Planning</div>
    <table class="detail-table">
        <tr>
            <td>Diagnosis medis</td>
            <td>: {{ $asesmenKepUmum->discharge_planning_usia_lanjut }}</td>
            <td>Hambatan mobilisasi</td>
            <td>: {{ $asesmenKepUmum->discharge_planning_hambatan_mobilisasi }}</td>
        </tr>
        <tr>
            <td>Membutuhkan pelayanan medis berkelanjutan</td>
            <td>: {{ $asesmenKepUmum->discharge_planning_pelayanan_medis }}</td>
            <td>Ketergantungan dengan orang lain dalam
                aktivitas harian</td>
            <td>: {{ $asesmenKepUmum->discharge_planning_ketergantungan_aktivitas }}</td>
        </tr>
        <tr>
            <td>Kesimpulan</td>
            <td colspan="3">: {{ $asesmenKepUmum->discharge_planning_kesimpulan }}</td>
        </tr>
    </table>

    <div class="section-title">15. Evaluasi</div>
    <table class="detail-table">
        <tr>
            <td>Evaluasi</td>
            <td>: {{ $asesmenKepUmum->evaluasi }}</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <div class="sign-area mt-5">
        <div class="sign-box">
            <p>Perawat yang Melakukan Asesmen</p>
            <br><br><br>
            <p>( _________________________ )</p>
            <p>Nama: {{ optional($asesmen->user)->name ?? '.............................' }}</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
