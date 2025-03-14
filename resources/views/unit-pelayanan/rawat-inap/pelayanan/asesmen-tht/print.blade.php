<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Asesmen THT</title>
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
            padding-bottom: 20px;
            border-bottom: 2px solid black;
            margin-bottom: 20px;
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
            margin-top: 20px;
        }

        .section-title {
            background: #f5f5f5;
            padding: 5px;
            font-weight: bold;
            border-left: 3px solid #333;
            margin-bottom: 10px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .detail-table th,
        .detail-table td {
            padding: 5px;
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

        /* 9. Diangnosis */
        @media print {
            .print-section-header {
                page-break-inside: avoid;
                margin-top: 15px;
                margin-bottom: 10px;
                border-bottom: 1px solid #dee2e6;
                padding-bottom: 5px;
            }

            /* Perbaikan untuk layout kolom saat print */
            .row {
                display: flex !important;
                flex-wrap: wrap !important;
            }

            .print-column {
                width: 50% !important;
                float: left !important;
                page-break-inside: avoid;
                padding: 0 10px !important;
                box-sizing: border-box !important;
            }

            .print-card {
                margin-bottom: 15px !important;
                border: 1px solid #dee2e6 !important;
                border-radius: 4px !important;
            }

            .print-card-header {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color-adjust: exact;
                border-bottom: 1px solid #dee2e6 !important;
                padding: 8px 12px !important;
            }

            .print-table {
                width: 100% !important;
                border-collapse: collapse !important;
                margin-bottom: 0 !important;
            }

            .print-table th,
            .print-table td {
                padding: 6px !important;
                border: 1px solid #000 !important;
            }

            .print-table thead th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color-adjust: exact;
                font-weight: bold !important;
            }

            .print-table-responsive {
                overflow: visible !important;
            }

            /* Perbaikan untuk text yang terpotong */
            h5,
            h6 {
                font-weight: bold !important;
                margin: 0 0 5px 0 !important;
            }

            small {
                font-size: 80% !important;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="left-column">
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}"
                class="header-logo" alt="Logo">
            <p>RSUD Langsa</p>
            <p>Jl. Jend. A. Yani No.1 Kota Langsa</p>
        </div>
        <div class="center-column">
            <h1 style="font-size: 16px;">Formulir Asesmen THT</h1>
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

                            if ($pasien->jenis_kelamin == 1) {
                                $gender = 'Laki-Laki';
                            }
                            if ($pasien->jenis_kelamin == 0) {
                                $gender = 'Perempuan';
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

    <div class="section-title mt-3">1. Data masuk</div>
    <table class="detail-table">
        <tr>
            <td class="col-header">kondisi Masuk :</td>
            <td>:
                @php
                    $kondisiMasuk = $rmeAsesmenTht->kondisi_masuk ?? '-';
                    $kondisiMasukText = match ($kondisiMasuk) {
                        '1' => 'Mandiri',
                        '2' => 'Kursi Roda',
                        '3' => 'Brankar',
                        default => $kondisiMasuk,
                    };
                    echo $kondisiMasukText;
                @endphp
            </td>
            <td class="col-header">Ruang</td>
            <td>: {{ $asesmen->rmeAsesmenTht->ruang == 1 ? 'Ya' : 'Tidak' ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-header">Tanggal Masuk :</td>
            <td>{{ date('d M Y', strtotime($asesmen->rmeAsesmenTht->tgl_masuk)) ?? '-' }}</td>
            <td class="col-header">Jam Masuk :</td>
            <td>{{ date('H:i', strtotime($asesmen->rmeAsesmenTht->tgl_masuk)) ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title mt-3">2. Anamnesis</div>
    <table class="detail-table">
        <tr>
            <td class="col-header">Anamnesis :</td>
            <td>: {{ $asesmen->rmeAsesmenTht->anamnesis_anamnesis ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title mt-3">3. Pemeriksaan fisik</div>
    <table class="detail-table">
        <tr>
            <td class="col-header">Tek. Darah (mmHg) : <br>
                <span>- Sistole</span><br>
                <span>- Diastole</span>
            </td>
            <td><br>
                :
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['darah_sistole'] ?? '-' }}
                mmHg
                <br>
                :
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['darah_diastole'] ?? '-' }}
                mmHg
            </td>
            <td class="col-header">Nadi (Per Menit)</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['nadi'] ?? '-' }}
                Menit
            </td>
        </tr>
        <tr>
            <td class="col-header">Nafas (Per Menit) :</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['nafas'] ?? '-' }}
                Menit
            </td>
            <td class="col-header">Suhu (C) :</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['suhu'] ?? '-' }}
                °C
            </td>
        </tr>
        <tr>
            <td class="col-header">Sensorium :</td>
            <td>: {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['sensorium'] ?? '-' }}
            </td>
            <td class="col-header">KU/KP/KG :</td>
            <td>: {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['ku_kp_kg'] ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-header">AVPU :</td>
            <td colspan="3">:
                @php
                    $avpu = json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['avpu'] ?? null;
                    $avpuOptions = [
                        '0' => 'Sadar Baik/Alert : 0',
                        '1' => 'Berespon dengan kata-kata/Voice: 1',
                        '2' => 'Hanya berespon jika dirangsang nyeri/pain: 2',
                        '3' => 'Pasien tidak sadar/unresponsive: 3',
                        '4' => 'Gelisah atau bingung: 4',
                        '5' => 'Acute Confusional States: 5',
                    ];
                @endphp
                {{ $avpuOptions[$avpu] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Pemeriksaan Fisik Koprehensif Laringoskopi Indirex</td>
        </tr>
        <tr>
            <td class="col-header">Pangkal Lidah :</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['pangkal_lidah'] ?? '-' }}
            </td>
            <td class="col-header">Tonsil Lidah :</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['tonsil_lidah'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-header">Epiglotis :</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['epiglotis'] ?? '-' }}
            </td>
            <td class="col-header">Pita Suara :</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['pita_suara'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Daun Telinga</td>
        </tr>
        <tr>
            <td class="col-header">Nanah :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['daun_telinga_nanah_kana'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['daun_telinga_nanah_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Darah :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['daun_telinga_darah_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['daun_telinga_darah_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-header">Lainnya :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td colspan="3"><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['daun_telinga_lainnya_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['daun_telinga_lainnya_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Liang Telinga</td>
        </tr>
        <tr>
            <td class="col-header">Darah :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['liang_telinga_darah_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['liang_telinga_darah_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Nanah :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['liang_telinga_nanah_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['liang_telinga_nanah_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-header">Berbau :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['liang_telinga_berbau_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['liang_telinga_berbau_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Lainnya :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['liang_telinga_lainnya_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['liang_telinga_lainnya_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Tes Pendengaran</td>
        </tr>
        <tr>
            <td class="col-header">Renne Tes :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['tes_pendengaran_renne_res_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['tes_pendengaran_renne_res_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Weber Tes :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['tes_pendengaran_weber_tes_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['tes_pendengaran_weber_tes_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-header">Schwabach Test :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['tes_pendengaran_schwabach_test_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['tes_pendengaran_schwabach_test_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Bebisik :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['tes_pendengaran_bebisik_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['tes_pendengaran_bebisik_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Paranatal Sinus Senus Frontalis</td>
        </tr>
        <tr>
            <td class="col-header">Nyeri Tekan :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['senus_frontalis_nyeri_tekan_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['senus_frontalis_nyeri_tekan_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Transluminasi :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['senus_frontalis_transluminasi_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['senus_frontalis_transluminasi_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Sinus Maksinasi</td>
        </tr>
        <tr>
            <td class="col-header">Nyeri Tekan :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['sinus_maksinasi_nyari_tekan_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['sinus_maksinasi_nyari_tekan_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Transluminasi :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['sinus_maksinasi_transluminasi_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['sinus_maksinasi_transluminasi_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Rhinoscopi Anterior</td>
        </tr>
        <tr>
            <td class="col-header">Nyeri Tekan :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['rhinoscopi_anterior_cavun_nasi_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['rhinoscopi_anterior_cavun_nasi_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Konka Inferior :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['rhinoscopi_anterior_konka_inferior_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['rhinoscopi_anterior_konka_inferior_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-header">Septum Nasi :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td colspan="3"><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['rhinoscopi_anterior_septum_nasi_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['rhinoscopi_anterior_septum_nasi_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Rhinoscopi Pasterior</td>
        </tr>
        <tr>
            <td class="col-header">Septum Nasi :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td colspan="3"><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['rhinoscopi_pasterior_septum_nasi_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['rhinoscopi_pasterior_septum_nasi_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Meatus Nasi</td>
        </tr>
        <tr>
            <td class="col-header">Superior :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['meatus_nasi_superior_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['meatus_nasi_superior_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Media :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['meatus_nasi_media_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['meatus_nasi_media_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-header">Inferior :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td colspan="3"><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['meatus_nasi_inferior_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['meatus_nasi_inferior_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Membran Tympani</td>
        </tr>
        <tr>
            <td class="col-header">Warna :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['membran_tympani_warna_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['membran_tympani_warna_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Perforasi :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['membran_tympani_perforasi_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['membran_tympani_perforasi_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-header">lainnya :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td colspan="3"><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['membran_tympani_lainnya_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['membran_tympani_lainnya_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Hidung</td>
        </tr>
        <tr>
            <td class="col-header">Bentuk :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['hidung_bentuk_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['hidung_bentuk_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Luka :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['hidung_luka_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['hidung_luka_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-header">Bisul :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['hidung_bisul_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['hidung_bisul_kiri'] ?? '-' }}
            </td>
            <td class="col-header">Fissare :<br>
                <span>- Kanan</span> <br>
                <span>- Kiri</span>
            </td>
            <td><br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['hidung_fissare_kanan'] ?? '-' }}
                <br>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['hidung_fissare_kiri'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="font-weight: bold;">Antropometri</td>
        </tr>
        <tr>
            <td class="col-header">Tinggi Badan :</td>
            <td>
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['antropometri_tinggi_badan'] ?? '-' }}
            </td>
            <td class="col-header">Berat Badan :</td>
            <td>
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['antropometr_berat_badan'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td class="col-header">Indeks Massa Tubuh (IMT) :</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['antropometri_imt'] ?? '-' }}
            </td>
            <td class="col-header">Luas Permukaan Tubuh (LPT) :</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtPemeriksaanFisik, true)[0]['antropometri_lpt'] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <span style="font-weight: bold;">Pemeriksaan Fisik </span>
                <br>
                Centang normal jika fisik yang dinilai normal. Jika tidak dipilih, maka pemeriksaan tidak dilakukan.
            </td>
        </tr>
        @php
            $pemeriksaanFisikData = json_decode($asesmen->pemeriksaanFisik, true) ?: [];
            $totalItems = count($pemeriksaanFisikData);
            $halfCount = ceil($totalItems / 2);
            $firstColumn = array_slice($pemeriksaanFisikData, 0, $halfCount);
            $secondColumn = array_slice($pemeriksaanFisikData, $halfCount);
            $maxRows = max(count($firstColumn), count($secondColumn));
        @endphp

        @for ($i = 0; $i < $maxRows; $i++)
            <tr>
                <td class="col-header">
                    @if (isset($firstColumn[$i]))
                        Keterangan:
                    @else
                        &nbsp;
                    @endif
                </td>
                <td>
                    @if (isset($firstColumn[$i]))
                        : {{ $firstColumn[$i]['keterangan'] ?? '-' }}<br>
                        <strong>Status:</strong>
                        @php $status = $firstColumn[$i]['is_normal'] ?? null; @endphp
                        @if ($status === '0' || $status === 0)
                            Tidak Normal
                        @elseif($status === '1' || $status === 1)
                            Normal
                        @else
                            Tidak Diperiksa
                        @endif
                    @else
                        &nbsp;
                    @endif
                </td>

                <td class="col-header">
                    @if (isset($secondColumn[$i]))
                        Keterangan:
                    @else
                        &nbsp;
                    @endif
                </td>
                <td>
                    @if (isset($secondColumn[$i]))
                        : {{ $secondColumn[$i]['keterangan'] ?? '-' }}<br>
                        <strong>Status:</strong>
                        @php $status = $secondColumn[$i]['is_normal'] ?? null; @endphp
                        @if ($status === '0' || $status === 0)
                            Tidak Normal
                        @elseif($status === '1' || $status === 1)
                            Normal
                        @else
                            Tidak Diperiksa
                        @endif
                    @else
                        &nbsp;
                    @endif
                </td>
            </tr>
        @endfor
    </table>

    <div class="section-title mt-3">4. Riwayat Kesehatan</div>
    <table class="detail-table">
        <tr>
            <td class="col-header">Penyakit Yang Pernah Diderita</td>
            <td>
                @php
                    $penyakit = json_decode(
                        $asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['riwayat_kesehatan_penyakit_diderita'],
                        true,
                    );
                @endphp

                @if (!empty($penyakit))
                    <ol>
                        @foreach ($penyakit as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ol>
                @else
                    <span>Tidak ada</span>
                @endif
            </td>
            <td class="col-header">Riwayat Penyakit Keluarga</td>
            <td>
                @php
                    $Keluarga = json_decode(
                        $asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['riwayat_kesehatan_penyakit_keluarga'],
                        true,
                    );
                @endphp

                @if (!empty($Keluarga))
                    <ol>
                        @foreach ($Keluarga as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ol>
                @else
                    <span>Tidak ada</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">5. Riwayat Penggunaan Obat</div>
    @php
        $riwayatObat = json_decode(
            $asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['riwayat_penggunaan_obat'],
            true,
        );
    @endphp

    @if (!empty($riwayatObat))
        <table class="detail-table">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frekuensi</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayatObat as $obat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $obat['namaObat'] ?? '-' }}</td>
                        <td>{{ ($obat['dosis'] ?? '-') . ' ' . ($obat['satuan'] ?? '') }}
                        </td>
                        <td>{{ $obat['frekuensi'] ?? '-' }}</td>
                        <td>{{ $obat['keterangan'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>
            <span>Tidak ada</span>
        </p>
    @endif

    <div class="section-title mt-3">6. Alergi</div>
    @php
        $riwayatAlergi = json_decode($asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi[0]['alergi'], true);
    @endphp

    @if (!empty($riwayatAlergi))
        <table class="detail-table">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Alergen</th>
                    <th>Reaksi</th>
                    <th>Severe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($riwayatAlergi as $aler)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $aler['alergen'] ?? '-' }}</td>
                        <td>{{ ($aler['reaksi'] ?? '-') . ' ' . ($obat['satuan'] ?? '') }}
                        </td>
                        <td>{{ $aler['severe'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>
            <span>Tidak ada</span>
        </p>
    @endif

    <div class="section-title mt-3">7. Hasil Pemeriksaan Penunjang</div>
    <table class="detail-table">
        <tr>
            <td class="col-header">Darah</td>
            <td>
                @if ($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_darah)
                    @php
                        $filePath =
                            'storage/uploads/gawat-inap/asesmen-tht/' .
                            $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_darah;
                        $fileExtension = pathinfo(
                            $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_darah,
                            PATHINFO_EXTENSION,
                        );
                        $isPdf = strtolower($fileExtension) === 'pdf';
                    @endphp

                    <span>Hasil Pemeriksaan Darah</span> <br>

                    <a href="{{ asset($filePath) }}" target="_blank">
                        Lihat Lengkap
                    </a>
                @else
                    <span>Tidak ada file</span>
                @endif
            </td>
            <td class="col-header">Urine</td>
            <td>
                @if ($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_urine)
                    @php
                        $filePath =
                            'storage/uploads/gawat-inap/asesmen-tht/' .
                            $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_urine;
                        $fileExtension = pathinfo(
                            $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_urine,
                            PATHINFO_EXTENSION,
                        );
                        $isPdf = strtolower($fileExtension) === 'pdf';
                    @endphp

                    <span>Hasil Pemeriksaan Urine</span> <br>

                    <a href="{{ asset($filePath) }}" target="_blank">
                        Lihat Lengkap
                    </a>
                @else
                    <span>Tidak ada file</span>
                @endif
            </td>
        </tr>
        <tr>
            <td class="col-header">Rontgent</td>
            <td>
                @if ($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_rontgent)
                    @php
                        $filePath =
                            'storage/uploads/gawat-inap/asesmen-tht/' .
                            $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_rontgent;
                        $fileExtension = pathinfo(
                            $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_rontgent,
                            PATHINFO_EXTENSION,
                        );
                        $isPdf = strtolower($fileExtension) === 'pdf';
                    @endphp

                    <span>Hasil Pemeriksaan Rontgent</span> <br>

                    <a href="{{ asset($filePath) }}" target="_blank">
                        Lihat Lengkap
                    </a>
                @else
                    <span>Tidak ada file</span>
                @endif
            </td>
            <td class="col-header">Histopatology</td>
            <td>
                @if ($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_histopatology)
                    @php
                        $filePath =
                            'storage/uploads/gawat-inap/asesmen-tht/' .
                            $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_histopatology;
                        $fileExtension = pathinfo(
                            $asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_histopatology,
                            PATHINFO_EXTENSION,
                        );
                        $isPdf = strtolower($fileExtension) === 'pdf';
                    @endphp

                    <span>Hasil Pemeriksaan Histopatology</span> <br>

                    <a href="{{ asset($filePath) }}" target="_blank">
                        Lihat Lengkap
                    </a>
                @else
                    <span>Tidak ada file</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">8. Discharge Planning</div>
    <table class="detail-table">
        <tr>
            <td class="col-header">Diagnosis medis</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtDischargePlanning, true)[0]['dp_diagnosis_medis'] ?? '-' }}
            </td>
            <td class="col-header">Usia lanjut</td>
            <td>:
                @php
                    $usiaLanjut =
                        json_decode($asesmen->rmeAsesmenThtDischargePlanning, true)[0]['dp_usia_lanjut'] ?? '-';
                    if ($usiaLanjut == 1) {
                        echo 'Ya';
                    } elseif ($usiaLanjut == 0) {
                        echo 'Tidak';
                    } else {
                        echo '-';
                    }
                @endphp
            </td>
        </tr>
        <tr>
            <td class="col-header">Hambatan mobilisasi</td>
            <td>:
                @php
                    $mobilisasi =
                        json_decode($asesmen->rmeAsesmenThtDischargePlanning, true)[0]['dp_hambatan_mobilisasi'] ?? '-';
                    if ($mobilisasi == 1) {
                        echo 'Ya';
                    } elseif ($mobilisasi == 0) {
                        echo 'Tidak';
                    } else {
                        echo '-';
                    }
                @endphp
            </td>
            <td class="col-header">Membutuhkan pelayanan medis berkelanjutan</td>
            <td>:
                @php
                    $layananMedisLanjutan =
                        json_decode($asesmen->rmeAsesmenThtDischargePlanning, true)[0]['dp_layanan_medis_lanjutan'] ??
                        '-';
                    if ($layananMedisLanjutan == 1) {
                        echo 'Ya';
                    } elseif ($layananMedisLanjutan == 0) {
                        echo 'Tidak';
                    } else {
                        echo '-';
                    }
                @endphp
            </td>
        </tr>
        <tr>
            <td class="col-header">Ketergantungan dengan orang lain dalam
                aktivitas harian</td>
            <td>:
                @php
                    $tergantungOrangLain =
                        json_decode($asesmen->rmeAsesmenThtDischargePlanning, true)[0]['dp_tergantung_orang_lain'] ??
                        '-';
                    if ($tergantungOrangLain == 1) {
                        echo 'Ya';
                    } elseif ($tergantungOrangLain == 0) {
                        echo 'Tidak';
                    } else {
                        echo '-';
                    }
                @endphp
            </td>
            <td class="col-header">Perkiraan lama hari dirawat</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtDischargePlanning, true)[0]['dp_lama_dirawat'] ?? '-' }}
                Hari
            </td>
        </tr>
        <tr>
            <td class="col-header">Rencana Pulang</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtDischargePlanning, true)[0]['dp_rencana_pulang'] ?? '-' }}
            </td>
            <td class="col-header">Kesimpulan</td>
            <td>:
                {{ json_decode($asesmen->rmeAsesmenThtDischargePlanning, true)[0]['dp_kesimpulan'] ?? '-' }}
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">9. Diagnosis</div>
    <table class="detail-table">
        <tr>
            <td class="col-header">Diagnosis Banding</td>
            <td>
                @php
                    $diagnosisBanding = json_decode(
                        $asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['diagnosis_banding'] ?? '[]',
                        true,
                    );
                @endphp

                @if (!empty($diagnosisBanding))
                    @foreach ($diagnosisBanding as $diagnosis)
                        <ul>
                            <li>{{ $diagnosis }}</li>
                            <hr>
                        </ul>
                    @endforeach
                @else
                    <p>Tidak ada</p>
                @endif
            </td>
            <td>Diagnosis Kerja</td>
            <td>
                @php
                    $diagnosisKerja = json_decode(
                        $asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['diagnosis_kerja'] ?? '[]',
                        true,
                    );
                @endphp

                @if (!empty($diagnosisKerja))
                    @foreach ($diagnosisKerja as $diagnosis)
                        <ul>
                            <li>{{ $diagnosis }}</li>
                            <hr>
                        </ul>
                    @endforeach
                @else
                    <p>Tidak ada</p>
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">10. Implementasi</div>
    <table class="detail-table">
        <tr>
            <td colspan="4" style="text-weight">Rencana Penatalaksanaan dan Pengobatan</td>
        </tr>
        <tr>
            <td colspan="4">Pilih tanda dokumen untuk mencari
                rencana, apabila tidak ada, Pilih tanda tambah untuk menambah keterangan
                rencana Penatalaksanaan dan Pengobatan kerja yang tidak ditemukan.</td>
        </tr>
        <tr>
            <td class="col-header">Observasi</td>
            <td>
                @php
                    $observasi = json_decode(
                        $asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['observasi'] ?? '[]',
                        true,
                    );
                @endphp

                @if (!empty($observasi))
                    @foreach ($observasi as $diagnosis)
                        <ul>
                            <li>{{ $diagnosis }}</li>
                            <hr>
                        </ul>
                    @endforeach
                @else
                    <p>Tidak ada</p>
                @endif
            </td>
            <td>Terapeutik</td>
            <td>
                @php
                    $terapeutik = json_decode(
                        $asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['terapeutik'] ?? '[]',
                        true,
                    );
                @endphp

                @if (!empty($terapeutik))
                    @foreach ($terapeutik as $diagnosis)
                        <ul>
                            <li>{{ $diagnosis }}</li>
                            <hr>
                        </ul>
                    @endforeach
                @else
                    <p>Tidak ada</p>
                @endif
            </td>
        </tr>
        <tr>
            <td class="col-header">Edukasi</td>
            <td>
                @php
                    $edukasi = json_decode($asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['edukasi'] ?? '[]', true);
                @endphp

                @if (!empty($edukasi))
                    @foreach ($edukasi as $diagnosis)
                        <ul>
                            <li>{{ $diagnosis }}</li>
                            <hr>
                        </ul>
                    @endforeach
                @else
                    <p>Tidak ada</p>
                @endif
            </td>
            <td>Kolaborasi</td>
            <td>
                @php
                    $kolaborasi = json_decode(
                        $asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['kolaborasi'] ?? '[]',
                        true,
                    );
                @endphp

                @if (!empty($kolaborasi))
                    @foreach ($kolaborasi as $diagnosis)
                        <ul>
                            <li>{{ $diagnosis }}</li>
                            <hr>
                        </ul>
                    @endforeach
                @else
                    <p>Tidak ada</p>
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="4">
                Pilih tanda dokumen untuk mencari
                Prognosis, apabila tidak ada, Pilih tanda tambah untuk menambah
                keterangan
                Prognosis yang tidak ditemukan.
            </td>
        </tr>
        <tr>
            <td>Prognosis</td>
            <td colspan="3">
                @php
                    $prognosis = json_decode(
                        $asesmen->rmeAsesmenThtDiagnosisImplementasi[0]['prognosis'] ?? '[]',
                        true,
                    );
                @endphp

                @if (!empty($prognosis))
                    @foreach ($prognosis as $diagnosis)
                        <ul>
                            <li>{{ $diagnosis }}</li>
                            <hr>
                        </ul>
                    @endforeach
                @else
                    <p>Tidak ada</p>
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">11. Evaluasi</div>
    <table class="detail-table">
        <tr>
            <td class="col-header">Diagnosis medis</td>
            <td>:
                {{ $asesmen->rmeAsesmenTht->evaluasi_evaluasi_keperawatan ?? '-' }}
            </td>
        </tr>
    </table>


    <div class="sign-area">
        <div class="sign-box">
            <p>Perawat yang Melakukan Asesmen THT</p>
            <br><br><br>
            <p>( _________________________ )</p>
            <p>{{ $asesmen->user->name ?? '.............................' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>

</html>
