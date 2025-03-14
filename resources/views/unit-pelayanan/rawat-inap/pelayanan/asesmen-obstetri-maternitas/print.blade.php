<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Asesmen Obstetri Maternitas</title>
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
            <h1 style="font-size: 16px;">Formulir Asesmen Awal Medis Obstetri</h1>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ isset($pasien) && $pasien ? $pasien->kd_pasien : '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ $pasien->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @if(isset($pasien) && $pasien && isset($pasien->jenis_kelamin))
                            @if($pasien->jenis_kelamin == 1)
                                Laki-Laki
                            @elseif($pasien->jenis_kelamin == 0)
                                Perempuan
                            @else
                                -
                            @endif
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>
                        @if(isset($pasien) && $pasien && isset($pasien->tgl_lahir))
                            {{ date('d/m/Y', strtotime($pasien->tgl_lahir)) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="clear"></div>
    </header>

    <div class="section-title mt-3">1. Data masuk</div>
    <table class="detail-table">
        <tr>
            <td style="width: 25%"><strong>Petugas</strong></td>
            <td style="width: 25%">{{ $asesmen->user->name ?? '-' }}</td>
            <td style="width: 25%"><strong>Pemeriksaan antenatal di RS Langsa</strong></td>
            <td style="width: 25%">
                @if (isset($asesmen->asesmenObstetri->antenatal_rs))
                    @if ($asesmen->asesmenObstetri->antenatal_rs == 0)
                        Tidak
                    @elseif($asesmen->asesmenObstetri->antenatal_rs == 1)
                        Ya
                    @else
                        Tidak Diketahui
                    @endif
                @else
                    -
                @endif
                <br>
                berapa kali: {{ $asesmen->asesmenObstetri->antenatal_rs_count ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>Tanggal Dan Jam Masuk</strong></td>
            <td>
                @if (isset($asesmen->asesmenObstetri->tgl_masuk))
                    {{ date('d M Y H:i', strtotime($asesmen->asesmenObstetri->tgl_masuk)) }}
                @else
                    -
                @endif
            </td>
            <td><strong>Pemeriksaan antenatal di tempat lain</strong></td>
            <td>
                @if (isset($asesmen->asesmenObstetri->antenatal_lain))
                    @if ($asesmen->asesmenObstetri->antenatal_lain == 0)
                        Tidak
                    @elseif($asesmen->asesmenObstetri->antenatal_lain == 1)
                        Ya
                    @else
                        Tidak Diketahui
                    @endif
                @else
                    -
                @endif
                <br>
                berapa kali: {{ $asesmen->asesmenObstetri->antenatal_lain_count ?? '-' }}
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">2. Anamnesis</div>
    <table class="detail-table">
        <tr>
            <td style="width: 25%"><strong>Anamnesis</strong></td>
            <td style="width: 75%">
                @if(isset($asesmen->asesmenObstetri->anamnesis_anamnesis))
                    {{ $asesmen->asesmenObstetri->anamnesis_anamnesis }}
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">3. Pemeriksaan Fisik Detail</div>
    <table class="detail-table">
        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Tanda Vital</td>
        </tr>
        <tr>
            <td style="width: 25%"><strong>Keadaan Umum</strong></td>
            <td style="width: 25%">{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->keadaan_umum ?? '-' }}</td>
            <td style="width: 25%"><strong>Tek Darah (mmHg)</strong></td>
            <td style="width: 25%">
                Sistole: {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->tekanan_darah_sistole ?? '-' }}<br>
                Diastole: {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->tekanan_darah_sistole ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>Nadi (Per Menit)</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->nadi ?? '-' }}</td>
            <td><strong>Pernafasan (Per Menit)</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->pernafasan ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Suhu (C)</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->suhu ?? '-' }}</td>
            <td><strong>Kesadaran</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>AVPU</strong></td>
            <td colspan="3">
                @php
                    $avpuOptions = [
                        0 => 'Sadar Baik/Alert : 0',
                        1 => 'Berespon dengan kata-kata/Voice: 1',
                        2 => 'Hanya berespon jika dirangsang nyeri/pain: 2',
                        3 => 'Pasien tidak sadar/unresponsive: 3',
                        4 => 'Gelisah atau bingung: 4',
                        5 => 'Acute Confusional States: 5',
                    ];
                    $kesadaran = isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik) ?
                        $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kesadaran : null;
                @endphp
                {{ isset($kesadaran) && isset($avpuOptions[$kesadaran]) ? $avpuOptions[$kesadaran] : '-' }}
            </td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Pemeriksaan Fisik Komprehensif</td>
        </tr>
        <tr>
            <td><strong>Posisi Janin</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_posisi_janin }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td><strong>Presentasi Janin</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_presentasi_janin }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Tinggi Fundus Uteri (Cm)</strong></td>
            <td colspan="3">{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->komprehensif_tinggi_fundus ?? '-' }}</td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Kontraksi (HIS)</td>
        </tr>
        <tr>
            <td><strong>Frekuensi</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_frekuensi ?? '-' }}</td>
            <td><strong>Letak Janin</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_letak_janin))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_letak_janin == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_letak_janin == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_letak_janin }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Irama</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_irama))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_irama == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_irama == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_irama }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td><strong>Sikap Janin</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->kontraksi_sikap_janin }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Denyut Jantung Janin (DJJ)</td>
        </tr>
        <tr>
            <td><strong>Frekuensi</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_frekuensi ?? '-' }}</td>
            <td><strong>Irama</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_irama))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_irama == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_irama == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->djj_irama }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Serviks</td>
        </tr>
        <tr>
            <td><strong>Konsistensi</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->Konsistensi))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->Konsistensi == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->Konsistensi == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->Konsistensi }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td><strong>Station</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_station ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Penurunan</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_penurunan ?? '-' }}</td>
            <td><strong>Pembukaan</strong></td>
            <td>
                {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_pembukaan ?? '-' }}
                <br>
                jam:
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_jam_pembukaan))
                    {{ \Carbon\Carbon::parse($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_jam_pembukaan)->format('H:i') }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Posisi</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_posisi ?? '-' }}</td>
            <td><strong>Irama</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_irama))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_irama == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_irama == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->serviks_irama }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Panggul</td>
        </tr>
        <tr>
            <td><strong>Promontorium</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_promontorium))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_promontorium == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_promontorium == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_promontorium }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td><strong>Spina Ischiadika</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_spina_ischiadika }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Line Terminalis</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_line_terminalis))
                    @if($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_line_terminalis == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_line_terminalis == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_line_terminalis }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td><strong>Arkus Pubis</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_arkus_pubis ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Lengkung Sakrum</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_lengkung_sakrum ?? '-' }}</td>
            <td><strong>Dinding Samping</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_dinding_samping ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Simpulan</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_simpulan ?? '-' }}</td>
            <td><strong>Pembukaan (Cm)</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_pembukaan_cm ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Selaput Ketuban</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_selaput_ketuban ?? '-' }}</td>
            <td><strong>Air Ketuban</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_air_ketuban ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Presentasi</strong></td>
            <td colspan="3">{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->panggul_presentasi ?? '-' }}</td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Antropometri</td>
        </tr>
        <tr>
            <td><strong>Tinggi Badan</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometri_tinggi_badan ?? '-' }}</td>
            <td><strong>Berat Badan</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometr_berat_badan ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Indeks Massa Tubuh (IMT)</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometri_imt ?? '-' }}</td>
            <td><strong>Luas Permukaan Tubuh (LPT)</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriPemeriksaanFisik->antropometri_lpt ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="4">
                <span style="font-weight: bold;">Pemeriksaan Fisik </span>
                <br>
                <span style="font-style: italic; font-size: 9px;">Centang normal jika fisik yang dinilai normal. Jika tidak dipilih, maka pemeriksaan tidak dilakukan.</span>
            </td>
        </tr>

        @php
            // Check if $asesmen->pemeriksaanFisik is a string or collection
            $pemeriksaanFisikData = [];

            if (is_string($asesmen->pemeriksaanFisik)) {
                // If it's a JSON string, decode it
                $pemeriksaanFisikData = json_decode($asesmen->pemeriksaanFisik, true) ?: [];
            } elseif (is_object($asesmen->pemeriksaanFisik) && method_exists($asesmen->pemeriksaanFisik, 'toArray')) {
                // If it's a collection, convert to array
                $pemeriksaanFisikData = $asesmen->pemeriksaanFisik->toArray();
            } elseif (is_array($asesmen->pemeriksaanFisik)) {
                // If it's already an array
                $pemeriksaanFisikData = $asesmen->pemeriksaanFisik;
            }

            $totalItems = count($pemeriksaanFisikData);
            $halfCount = ceil($totalItems / 2);
            $firstColumn = array_slice($pemeriksaanFisikData, 0, $halfCount);
            $secondColumn = array_slice($pemeriksaanFisikData, $halfCount);
            $maxRows = max(count($firstColumn), count($secondColumn));
        @endphp

        @for ($i = 0; $i < $maxRows; $i++)
            <tr>
                <td class="col-header" style="width: 20%;">
                    @if (isset($firstColumn[$i]))
                        @if (isset($itemFisik[$firstColumn[$i]['id_item_fisik']]))
                            <strong>{{ $itemFisik[$firstColumn[$i]['id_item_fisik']]->nama }}</strong>
                        @else
                            <strong>Item #{{ $firstColumn[$i]['id_item_fisik'] ?? '' }}</strong>
                        @endif
                    @else
                        &nbsp;
                    @endif
                </td>
                <td style="width: 30%;">
                    @if (isset($firstColumn[$i]))
                        @php $status = $firstColumn[$i]['is_normal'] ?? null; @endphp
                        @if ($status === '0' || $status === 0)
                            <span style="color: #856404; background-color: #fff3cd; padding: 2px 5px; border-radius: 3px;">Tidak Normal</span>
                        @elseif($status === '1' || $status === 1)
                            <span style="color: #155724; background-color: #d4edda; padding: 2px 5px; border-radius: 3px;">Normal</span>
                        @else
                            <span style="color: #6c757d; background-color: #f8f9fa; padding: 2px 5px; border-radius: 3px;">Tidak Diperiksa</span>
                        @endif

                        @if (isset($firstColumn[$i]['keterangan']) && ($status === '0' || $status === 0))
                            <div style="font-size: 9px; font-style: italic; margin-top: 3px;">
                                Keterangan: {{ $firstColumn[$i]['keterangan'] }}
                            </div>
                        @endif
                    @else
                        &nbsp;
                    @endif
                </td>

                <td class="col-header" style="width: 20%;">
                    @if (isset($secondColumn[$i]))
                        @if (isset($itemFisik[$secondColumn[$i]['id_item_fisik']]))
                            <strong>{{ $itemFisik[$secondColumn[$i]['id_item_fisik']]->nama }}</strong>
                        @else
                            <strong>Item #{{ $secondColumn[$i]['id_item_fisik'] ?? '' }}</strong>
                        @endif
                    @else
                        &nbsp;
                    @endif
                </td>
                <td style="width: 30%;">
                    @if (isset($secondColumn[$i]))
                        @php $status = $secondColumn[$i]['is_normal'] ?? null; @endphp
                        @if ($status === '0' || $status === 0)
                            <span style="color: #856404; background-color: #fff3cd; padding: 2px 5px; border-radius: 3px;">Tidak Normal</span>
                        @elseif($status === '1' || $status === 1)
                            <span style="color: #155724; background-color: #d4edda; padding: 2px 5px; border-radius: 3px;">Normal</span>
                        @else
                            <span style="color: #6c757d; background-color: #f8f9fa; padding: 2px 5px; border-radius: 3px;">Tidak Diperiksa</span>
                        @endif

                        @if (isset($secondColumn[$i]['keterangan']) && ($status === '0' || $status === 0))
                            <div style="font-size: 9px; font-style: italic; margin-top: 3px;">
                                Keterangan: {{ $secondColumn[$i]['keterangan'] }}
                            </div>
                        @endif
                    @else
                        &nbsp;
                    @endif
                </td>
            </tr>
        @endfor
    </table>

    <div class="section-title mt-3">4. Status Nyeri</div>
    <table class="detail-table">
        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Status Nyeri</td>
        </tr>
        <tr>
            <td style="width: 25%"><strong>Jenis Skala Nyeri</strong></td>
            <td style="width: 25%">{{ $asesmen->rmeAsesmenObstetriStatusNyeri->jenis_skala_nyeri ?? '-' }}</td>
            <td style="width: 25%"><strong>Nilai Skala Nyeri</strong></td>
            <td style="width: 25%">{{ $asesmen->rmeAsesmenObstetriStatusNyeri->skala_nyeri ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Kesimpulan Nyeri</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriStatusNyeri->kesimpulan_nyeri ?? '-' }}</td>
            <td><strong>Lokasi</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriStatusNyeri->lokasi_nyeri ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Durasi</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriStatusNyeri->durasi_nyeri ?? '-' }}</td>
            <td><strong>Jenis nyeri</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriStatusNyeri->jenis_nyeri ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Frekuensi</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriStatusNyeri->frekuensi_nyeri ?? '-' }}</td>
            <td><strong>Menjalar</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriStatusNyeri->menjalar))
                    @if($asesmen->rmeAsesmenObstetriStatusNyeri->menjalar == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->menjalar == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->menjalar }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Kualitas</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriStatusNyeri->kualitas_nyeri ?? '-' }}</td>
            <td><strong>Faktor pemberat</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriStatusNyeri->faktor_pemberat ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Faktor peringan</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriStatusNyeri->faktor_peringan ?? '-' }}</td>
            <td><strong>Efek Nyeri</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri) && $asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri)
                    @php
                        $efekNyeri = is_string($asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri) ?
                            json_decode($asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri, true) :
                            $asesmen->rmeAsesmenObstetriStatusNyeri->efek_nyeri;
                    @endphp
                    @if(is_array($efekNyeri))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($efekNyeri as $efek)
                                <li style="font-size: 9px;">{{ $efek }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $efekNyeri }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">5. Riwayat Kesehatan</div>
    <table class="detail-table">
        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Status Obstetri dan Menstruasi</td>
        </tr>
        <tr>
            <td style="width: 25%"><strong>Status Obstetri</strong></td>
            <td style="width: 25%">
                Gravid: {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->gravid ?? '-' }}<br>
                Partus: {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->partus ?? '-' }}<br>
                Abortus: {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->abortus ?? '-' }}
            </td>
            <td style="width: 25%"><strong>Siklus</strong></td>
            <td style="width: 25%">{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->siklus ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Lama Haid</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->lama_haid ?? '-' }}</td>
            <td><strong>Hari Pertama Haid Terakhir</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->hari_pht ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Usia Kehamilan</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->usia_kehamilan ?? '-' }}</td>
            <td><strong>Perkawinan</strong></td>
            <td>
                {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->perkawinan_kali ?? '-' }} kali<br>
                Tahun: {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->perkawinan_usia ?? '-' }}
            </td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Riwayat Kehamilan Sekarang</td>
        </tr>
        <tr>
            <td><strong>Riwayat Kehamilan Sekarang</strong></td>
            <td colspan="3">
                @if(isset($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang) && $asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang)
                    @php
                        $riwayatKehamilanSekarang = is_string($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang) ?
                            json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang, true) :
                            $asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_kehamilan_sekarang;
                    @endphp
                    @if(is_array($riwayatKehamilanSekarang))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($riwayatKehamilanSekarang as $item)
                                <li style="font-size: 9px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $riwayatKehamilanSekarang }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Penambahan BB Selama Hamil (Kg)</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->penambahan_bb ?? '-' }}</td>
            <td><strong>Kebiasaan Ibu Sewaktu Hamil</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil) && $asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil)
                    @php
                        $kebiasaanIbuHamil = is_string($asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil) ?
                            json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil, true) :
                            $asesmen->rmeAsesmenObstetriRiwayatKesehatan->kebiasaan_ibu_hamil;
                    @endphp
                    @if(is_array($kebiasaanIbuHamil))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($kebiasaanIbuHamil as $item)
                                <li style="font-size: 9px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $kebiasaanIbuHamil }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Dukungan Sosial</td>
        </tr>
        <tr>
            <td><strong>Dukungan Sosial</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriStatusNyeri->dukungan_sosial))
                    @if($asesmen->rmeAsesmenObstetriStatusNyeri->dukungan_sosial == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->dukungan_sosial == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->dukungan_sosial }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td><strong>Kehamilan Diinginkan</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriStatusNyeri->kehamilan_diinginkan))
                    @if($asesmen->rmeAsesmenObstetriStatusNyeri->kehamilan_diinginkan == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->kehamilan_diinginkan == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->kehamilan_diinginkan }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Pendamping</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping) && $asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping)
                    @php
                        $pendamping = is_string($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping) ?
                            json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping, true) :
                            $asesmen->rmeAsesmenObstetriRiwayatKesehatan->pendamping;
                    @endphp
                    @if(is_array($pendamping))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($pendamping as $item)
                                <li style="font-size: 9px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $pendamping }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td><strong>Pengambilan Keputusan</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan) && $asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan)
                    @php
                        $pengambilanKeputusan = is_string($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan) ?
                            json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan, true) :
                            $asesmen->rmeAsesmenObstetriRiwayatKesehatan->pengambilan_keputusan;
                    @endphp
                    @if(is_array($pengambilanKeputusan))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($pengambilanKeputusan as $item)
                                <li style="font-size: 9px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $pengambilanKeputusan }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Riwayat Kesehatan</td>
        </tr>
        <tr>
            <td><strong>Eliminasi (Defekasi)</strong></td>
            <td>{{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->eliminasi ?? '-' }}</td>
            <td><strong>Riwayat Rawat Inap</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriStatusNyeri->riwayat_rawat_inap))
                    @if($asesmen->rmeAsesmenObstetriStatusNyeri->riwayat_rawat_inap == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->riwayat_rawat_inap == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->riwayat_rawat_inap }}
                    @endif
                    <br>
                    Tanggal: {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->tanggal_rawat ?? '-' }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Konsumsi Obat-Obatan</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriStatusNyeri->konsumsi_obat))
                    @if($asesmen->rmeAsesmenObstetriStatusNyeri->konsumsi_obat == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->konsumsi_obat == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->konsumsi_obat }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td><strong>Pemeriksaan antenatal di tempat lain</strong></td>
            <td>
                @if(isset($asesmen->rmeAsesmenObstetriStatusNyeri->antenatal_lain))
                    @if($asesmen->rmeAsesmenObstetriStatusNyeri->antenatal_lain == 1)
                        Ya
                    @elseif($asesmen->rmeAsesmenObstetriStatusNyeri->antenatal_lain == 0)
                        Tidak
                    @else
                        {{ $asesmen->rmeAsesmenObstetriStatusNyeri->antenatal_lain }}
                    @endif
                    <br>
                    Berapa kali: {{ $asesmen->rmeAsesmenObstetriRiwayatKesehatan->berapa_kali ?? '-' }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Riwayat Penyakit Keluarga</strong></td>
            <td colspan="3">
                @if(isset($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa) && $asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa)
                    @php
                        $riwayatPenyakitKeluarga = is_string($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa) ?
                            json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa, true) :
                            $asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_penyakin_keluarwa;
                    @endphp
                    @if(is_array($riwayatPenyakitKeluarga))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($riwayatPenyakitKeluarga as $item)
                                <li style="font-size: 9px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $riwayatPenyakitKeluarga }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <!-- Riwayat Obstetrik Table -->
    <div class="section-title mt-3">Riwayat Obstetrik</div>
    <table class="detail-table">
        @if(isset($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik) && $asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik)
            @php
                $riwayatObstetrik = is_string($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik) ?
                    json_decode($asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik, true) :
                    $asesmen->rmeAsesmenObstetriRiwayatKesehatan->riwayat_obstetrik;
            @endphp
            @if(is_array($riwayatObstetrik) && count($riwayatObstetrik) > 0)
                <tr style="background-color: #f5f5f5; font-weight: bold; text-align: center;">
                    <td style="width: 5%;">No</td>
                    <td style="width: 15%;">Kehamilan</td>
                    <td style="width: 15%;">Persalinan</td>
                    <td style="width: 15%;">Nifas</td>
                    <td style="width: 15%;">Tgl Lahir</td>
                    <td style="width: 15%;">Anak</td>
                    <td style="width: 20%;">Tempat</td>
                </tr>
                @foreach($riwayatObstetrik as $index => $riwayat)
                    <tr style="text-align: center; font-size: 9px;">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $riwayat['keadaanKehamilan'] ?? '-' }}</td>
                        <td>{{ $riwayat['caraPersalinan'] ?? '-' }}</td>
                        <td>{{ $riwayat['keadaanNifas'] ?? '-' }}</td>
                        <td>{{ $riwayat['tanggalLahir'] ?? '-' }}</td>
                        <td>{{ $riwayat['keadaanAnak'] ?? '-' }}</td>
                        <td>{{ $riwayat['tempatDanPenolong'] ?? '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td style="text-align: center;">Tidak ada data riwayat obstetrik</td>
                </tr>
            @endif
        @else
            <tr>
                <td style="text-align: center;">Tidak ada data riwayat obstetrik</td>
            </tr>
        @endif
    </table>

    <div class="section-title mt-3">6. Hasil Pemeriksaan Penunjang</div>
    <table class="detail-table">
        <tr>
            <td colspan="4" style="background-color: #f5f5f5; font-weight: bold;">Hasil Pemeriksaan Penunjang</td>
        </tr>
        <tr>
            <td style="width: 25%"><strong>Darah</strong></td>
            <td style="width: 25%">
                @if(isset($asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_darah) && $asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_darah)
                    <span>Tersedia (Lihat di sistem)</span>
                @else
                    <span>Tidak ada file</span>
                @endif
            </td>
            <td style="width: 25%"><strong>Rontgent</strong></td>
            <td style="width: 25%">
                @if(isset($asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_rontgent) && $asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_rontgent)
                    <span>Tersedia (Lihat di sistem)</span>
                @else
                    <span>Tidak ada file</span>
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Urine</strong></td>
            <td>
                @if(isset($asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_urine) && $asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_urine)
                    <span>Tersedia (Lihat di sistem)</span>
                @else
                    <span>Tidak ada file</span>
                @endif
            </td>
            <td><strong>Histopatology</strong></td>
            <td>
                @if(isset($asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_histopatology) && $asesmen->asesmenObstetri->hasil_pemeriksaan_penunjang_histopatology)
                    <span>Tersedia (Lihat di sistem)</span>
                @else
                    <span>Tidak ada file</span>
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">7. Diagnosis</div>
    <table class="detail-table">
        <tr>
            <td colspan="2" style="background-color: #f5f5f5; font-weight: bold;">Diagnosis</td>
        </tr>
        <tr>
            <td style="width: 50%; vertical-align: top;"><strong>Diagnosis Banding</strong></td>
            <td style="width: 50%; vertical-align: top;"><strong>Diagnosis Kerja</strong></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                @if(isset($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_banding) && $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_banding)
                    @php
                        $diagnosisBanding = is_string($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_banding) ?
                            json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_banding, true) :
                            $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_banding;
                    @endphp
                    @if(is_array($diagnosisBanding))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($diagnosisBanding as $item)
                                <li style="font-size: 10px; margin-bottom: 3px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $diagnosisBanding }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td style="vertical-align: top;">
                @if(isset($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_kerja) && $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_kerja)
                    @php
                        $diagnosisKerja = is_string($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_kerja) ?
                            json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_kerja, true) :
                            $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->diagnosis_kerja;
                    @endphp
                    @if(is_array($diagnosisKerja))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($diagnosisKerja as $item)
                                <li style="font-size: 10px; margin-bottom: 3px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $diagnosisKerja }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">8. Implementasi</div>
    <table class="detail-table">
        <tr>
            <td colspan="2" style="background-color: #f5f5f5; font-weight: bold;">Rencana Penatalaksanaan dan Pengobatan</td>
        </tr>
        <tr>
            <td style="width: 50%; vertical-align: top;"><strong>Observasi</strong></td>
            <td style="width: 50%; vertical-align: top;"><strong>Terapeutik</strong></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                @if(isset($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->observasi) && $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->observasi)
                    @php
                        $observasi = is_string($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->observasi) ?
                            json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->observasi, true) :
                            $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->observasi;
                    @endphp
                    @if(is_array($observasi))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($observasi as $item)
                                <li style="font-size: 10px; margin-bottom: 3px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $observasi }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td style="vertical-align: top;">
                @if(isset($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->terapeutik) && $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->terapeutik)
                    @php
                        $terapeutik = is_string($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->terapeutik) ?
                            json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->terapeutik, true) :
                            $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->terapeutik;
                    @endphp
                    @if(is_array($terapeutik))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($terapeutik as $item)
                                <li style="font-size: 10px; margin-bottom: 3px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $terapeutik }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td style="width: 50%; vertical-align: top;"><strong>Edukasi</strong></td>
            <td style="width: 50%; vertical-align: top;"><strong>Kolaborasi</strong></td>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                @if(isset($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->edukasi) && $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->edukasi)
                    @php
                        $edukasi = is_string($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->edukasi) ?
                            json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->edukasi, true) :
                            $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->edukasi;
                    @endphp
                    @if(is_array($edukasi))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($edukasi as $item)
                                <li style="font-size: 10px; margin-bottom: 3px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $edukasi }}
                    @endif
                @else
                    -
                @endif
            </td>
            <td style="vertical-align: top;">
                @if(isset($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->kolaborasi) && $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->kolaborasi)
                    @php
                        $kolaborasi = is_string($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->kolaborasi) ?
                            json_decode($asesmen->rmeAsesmenObstetriDiagnosisImplementasi->kolaborasi, true) :
                            $asesmen->rmeAsesmenObstetriDiagnosisImplementasi->kolaborasi;
                    @endphp
                    @if(is_array($kolaborasi))
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($kolaborasi as $item)
                                <li style="font-size: 10px; margin-bottom: 3px;">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ $kolaborasi }}
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    <div class="section-title mt-3">9. Evaluasi</div>
    <table class="detail-table">
        <tr>
            <td style="background-color: #f5f5f5; font-weight: bold;">Evaluasi</td>
        </tr>
        <tr>
            <td>
                <strong>Diagnosis medis</strong>:
                {{ $asesmen->asesmenObstetri->evaluasi_evaluasi ?? '-' }}
            </td>
        </tr>
    </table>

    <div class="sign-area">
        <div class="sign-box">
            <p>Perawat yang Melakukan Asesmen Awal Medis Obstetri</p>
            <br><br><br>
            <p>( _________________________ )</p>
            <p>{{ $asesmen->user->name ?? '.............................' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>

</html>
