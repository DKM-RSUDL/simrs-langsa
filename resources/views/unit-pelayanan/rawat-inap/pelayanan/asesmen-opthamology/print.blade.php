<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Anamnesis - Ophthalmology</title>

   <style>
        * {
            box-sizing: border-box;
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8.5pt;
        }

        @page {
            size: A4;
            margin: 3mm 6mm;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .a4 {
            width: 100%;
            max-width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 4px 6px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 38%;
            padding-right: 8px;
        }

        .value {
            border-bottom: 1px solid #000;
            min-height: 22px;
        }

        .value.tall {
            min-height: 32px;
        }

        .value.empty-space {
            min-height: 60px; /* ruang tulis tangan jika kosong */
        }

        .checkbox-group {
            font-family: "DejaVu Sans", sans-serif !important;
        }

        .checkbox-group label {
            margin-right: 28px;
            display: inline-block;
        }



        input[type="checkbox"]:checked {
            background: #fff;
        }

        input[type="checkbox"]:checked::after {
            content: "\2713";          /* Unicode checkmark yang support di DejaVu Sans */
            position: absolute;
            top: -3px;
            left: 1px;
            font-size: 16px;
            color: #000;
            line-height: 1;
        }

        .obat-item {
            border-bottom: 1px dotted #666;
            padding: 2px 6px;
            margin-bottom: 2px;
        }

        .header {
            display: flex;
            align-items: stretch;
            margin-bottom: 10mm;
            border-bottom: 1px solid #000;
            width: 100%;
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



        .brand-table {
            border-collapse: collapse;
            background-color: transparent;
        }

        .va-middle {
            vertical-align: middle;
        }

        .brand-logo {
            width: 60px;
            height: auto;
            margin-right: 2px;
        }

        .brand-name {
            font-weight: 700;
            margin: 0;
            font-size: 14px;
        }

        .brand-info {
            margin: 0;
            font-size: 7px;
        }

        .title-main {
            display: block;
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .title-sub {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }



        .unit-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        .unit-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
        }



    </style>
</head>
    <body>
        <div class="a4">

            @php
                $asesmen = json_decode(json_encode($data['asesmen'] ?? null), false);
                $asesmen_kep_ophtamology = $asesmen->rme_asesmen_kep_ophtamology;
                $riwayat_penyakit_keluarga = json_decode($asesmen_kep_ophtamology->riwayat_penyakit_keluarga ?? '[]', true);
                $penyakit_yang_diderita    = json_decode($asesmen_kep_ophtamology->penyakit_yang_diderita ?? '[]', true);
                $riwayat_penggunaan_obat   = json_decode($asesmen_kep_ophtamology->riwayat_penggunaan_obat ?? '[]', true);
                $riwayat_alergi            = json_decode($asesmen->riwayat_alergi ?? '[]', true);
                $ophtamology_komprehensif = $asesmen->rme_asesmen_kep_ophtamology_komprehensif;

                $rencanaPulang = $data['asesmen']->rmeAsesmenKepOphtamologyRencanaPulang;

                $statusPresent = $data['asesmen']->rmeAsesmenKepOphtamologyFisik;
                $faktorpemberat = $data['faktorpemberat']

            @endphp

            <table class="header-table">
                <tr>
                    <td class="td-left">
                        <table class="brand-table">
                            <tr>
                                <td class="va-middle">
                                    @php
                                        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
                                        $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
                                        $logoData = file_get_contents($logoPath);
                                        $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
                                    @endphp

                                    <img src="{{ $logoBase64 }}" style="width:70px; height:auto;">
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
                    <td class="td-center">
                        <span class="title-main">ASESMEN MEDIS</span>
                        <span class="title-sub">OPTHAMOLOGY</span>
                    </td>
                    <td class="td-right">
                        <div class="unit-box"><span class="unit-text" style="font-size: 14px; margin-top : 10px;">RAWAT INAP</span></div>
                    </td>
                </tr>
            </table>

             <table class="patient-table">
                <tr>
                    <th>No. RM</th>
                    <td>{{ $data['dataMedis']->pasien->kd_pasien ?? '-' }}</td>
                    <th>Tgl. Lahir</th>
                    <td>{{ $data['dataMedis']->pasien->tgl_lahir ? \Carbon\Carbon::parse($data['dataMedis']->pasien->tgl_lahir)->format('d M Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Nama Pasien</th>
                    <td>{{ $data['dataMedis']->pasien->nama ?? '-' }}</td>
                    <th>Umur</th>
                    <td>{{ $data['dataMedis']->pasien->umur ?? '-' }} Tahun</td>
                </tr>
            </table>


            <table>
                <!-- Header Anamnesis -->
                <tr>
                    <td class="label">ANAMNESIS</td>
                    <td class="value">{{ $asesmen->anamnesis ?? '-' }}</td>
                </tr>

                <!-- Keluhan Utama -->
                <tr>
                    <td class="label">Keluhan utama :</td>
                    <td class="value">
                        {{ $asesmen->keluhan_utama ?? implode(', ', $penyakit_yang_diderita) ?: '–' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Lama keluhan:</td>
                    <td class="value">{{ $asesmen->lama_keluhan ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Pencetus / Faktor pemberat:</td>
                    <td class="value">
                        @foreach ($faktorpemberat as $value )
                            <label for="">{{ $value->name . ',' }}</label>
                        @endforeach
                    </td>
                </tr>

                <!-- Riwayat Penyakit Sekarang -->
                {{-- <tr>
                    <td  class="label" style="padding-top:0px;">Riwayat penyakit sekarang:</td>
                    <td  class="value tall empty-space">
                        {{ $asesmen->riwayat_penyakit_sekarang ?? '–' }}
                    </td>
                </tr> --}}

                <!-- Riwayat Penyakit Dahulu -->
                <tr>
                    <td  class="label">Riwayat penyakit terdahulu:</td>
                    <td  class="value">
                        {{ $asesmen->riwayat_penyakit_dahulu ?? implode(', ', $penyakit_yang_diderita) ?: '–' }}
                    </td>
                </tr>
                <tr>

                </tr>

                <!-- Riwayat Keluarga -->
                <tr>
                    <td  class="label">Riwayat penyakit dalam keluarga:</td>
                    <td  class="value">
                        {{ implode(', ', $riwayat_penyakit_keluarga) ?: 'Tidak ada / tidak diketahui' }}
                    </td>
                </tr>
                <tr>

                </tr>
            <!-- Riwayat Pengobatan -->
            <tr>
                <td colspan="2" class="label" style="padding-top: 0px;">Riwayat pengobatan / pemakaian obat saat ini:</td>
            </tr>
            <tr>
                <td colspan="2" class="checkbox-group" style="padding: 6px 0 8px 0;">
                    <label style="display: inline-flex; align-items: center; margin-right: 40px; white-space: nowrap;">
                        <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }} style="margin-right: 6px;">
                        Tidak ada
                    </label>
                    <label style="display: inline-flex; align-items: center; white-space: nowrap;">
                        <input type="checkbox" {{ !empty($riwayat_penggunaan_obat) ? 'checked' : '' }} style="margin-right: 6px;">
                        Ada, sebutkan:
                    </label>
                </td>
            </tr>

            @if(!empty($riwayat_penggunaan_obat))
                @foreach($riwayat_penggunaan_obat as $index => $obat)
                <tr>
                    <td class="label" style="padding-left: 30px; font-weight: normal;">
                        {{ $index + 1 }}.
                    </td>
                    <td class="value" style="border-bottom: 1px dotted #444; padding: 4px 8px;">
                        <strong>{{ $obat['namaObat'] ?? '-' }}</strong>
                        {{ $obat['dosis'] ?? '' }} {{ $obat['satuan'] ?? '' }},
                        {{ $obat['frekuensi'] ?? '-' }}
                        @if(!empty($obat['keterangan']))
                            — {{ $obat['keterangan'] }}
                        @endif
                    </td>
                </tr>
                @endforeach

                <!-- Tambahan ruang kosong untuk obat lain jika ditulis tangan -->
                @if(count($riwayat_penggunaan_obat) < 3)
                    @for($i = count($riwayat_penggunaan_obat); $i < 3; $i++)
                    <tr>
                        <td class="label" style="padding-left: 30px; font-weight: normal;">{{ $i + 1 }}.</td>
                        <td class="value" style="height: 5px; border-bottom: 1px dotted #444;"></td>
                    </tr>
                    @endfor
                @endif

            @else
                <!-- Jika tidak ada obat, beri ruang untuk tulis tangan -->
                <tr>
                    <td colspan="2" class="value" style="height: 20px; border-bottom: 1px dotted #444;"></td>
                </tr>
            @endif

                @if(!empty($riwayat_penggunaan_obat))
                    @foreach($riwayat_penggunaan_obat as $obat)
                    <tr>
                        <td colspan="2" class="obat-item">
                            • {{ $obat->namaObat ?? '-' }}
                            {{ $obat->dosis ?? '' }} {{ $obat->satuan ?? '' }},
                            {{ $obat->frekuensi ?? '' }}
                            {{ !empty($obat->keterangan) ? ' — ' . $obat->keterangan : '' }}
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr><td colspan="2" class="value" style="height:20px;"></td></tr>
                @endif

                <!-- Riwayat Alergi -->
                <tr>
                    <td colspan="2" class="label" style="padding-top: 0px;">Riwayat Alergi:</td>
                </tr>

                <tr>
                    <td colspan="2" class="checkbox-group" style="padding: 6px 0 10px 0;">
                        <label style="display: inline-flex; align-items: center; margin-right: 40px;">
                            <input type="checkbox" {{ empty($riwayat_alergi) ? 'checked' : '' }} style="margin-right: 6px;">
                            Tidak ada
                        </label>
                        <label style="display: inline-flex; align-items: center;">
                            <input type="checkbox" {{ !empty($riwayat_alergi) ? 'checked' : '' }} style="margin-right: 6px;">
                            Ada, sebutkan:
                        </label>
                    </td>
                </tr>

                @if(!empty($riwayat_alergi))
                    @foreach($riwayat_alergi as $index => $alergi)
                    <tr>
                        <td class="label" style="padding-left: 30px; font-weight: normal; width: 10%;">
                            {{ $index + 1 }}.
                        </td>
                        <td class="value" style="border-bottom: 1px dotted #444; padding: 0px;">
                            <strong>{{ $alergi['alergen'] ?? '-' }}</strong>
                            (Jenis: {{ $alergi['jenis'] ?? '-' }})
                            — Reaksi: {{ $alergi['reaksi'] ?? '-' }}
                            — Keparahan: {{ $alergi['keparahan'] ?? '-' }}
                        </td>
                    </tr>
                    @endforeach

                    <!-- Baris kosong tambahan untuk tulis tangan (maksimal total 4 item) -->
                    @if(count($riwayat_alergi) < 3)
                        @for($i = count($riwayat_alergi); $i < 3; $i++)
                        <tr>
                            <td class="label" style="padding-left: 30px; font-weight: normal;">
                                {{ $i + 1 }}.
                            </td>
                            <td class="value" style="height: 5px; border-bottom: 1px dotted #444;"></td>
                        </tr>
                        @endfor
                    @endif

                @else
                    <!-- Jika tidak ada alergi, beri ruang tulis tangan -->
                    <tr>
                        <td colspan="2" class="value" style="height: 10px; border-bottom: 1px dotted #444;"></td>
                    </tr>
                @endif



               <!-- Status Oftalmologi / Pemeriksaan Mata -->
                <tr>
                    <td colspan="2" class="label" style="padding-top: 12px; font-size: 11pt;">STATUS OFTALMOLOGI</td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table style="width: 100%; border-collapse: collapse; margin: 0; padding: 0; font-size: 9.5pt;">
                            <tr>
                                <td class="label" style="width: 20%; padding: 1px 3px;">RPT</td>
                                <td class="value" style="width: 30%;">{{ $ophtamology_komprehensif->rpt ?? '' }}</td>
                                <td style="width: 20%;"></td>
                                <td style="width: 30%;"></td>
                            </tr>
                            <tr>
                                <td class="label" style="padding: 1px 3px;">RPO</td>
                                <td class="value">{{ $ophtamology_komprehensif->rpo ?? '' }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="label" style="padding: 1px 3px;">A.V.O.D</td>
                                <td class="value">{{ $ophtamology_komprehensif->avod ?? '' }}</td>
                                <td class="label" style="padding: 1px 3px;">A.V.O.S</td>
                                <td class="value">{{ $ophtamology_komprehensif->avos ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="label" style="padding: 1px 3px;">Kor. sph</td>
                                <td class="value">{{ $ophtamology_komprehensif->sph_oculi_dextra ?? '' }}</td>
                                <td class="label" style="padding: 1px 3px;">Kor. sph</td>
                                <td class="value">{{ $ophtamology_komprehensif->sph_oculi_sinistra ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="label" style="padding: 1px 3px;">Cyl</td>
                                <td class="value">{{ $ophtamology_komprehensif->cyl_oculi_dextra ?? '' }}</td>
                                <td class="label" style="padding: 1px 3px;">Cyl</td>
                                <td class="value">{{ $ophtamology_komprehensif->cyl_oculi_sinistra ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="label" style="padding: 1px 3px;">Menjadi</td>
                                <td class="value">{{ $ophtamology_komprehensif->menjadi_oculi_dextra ?? '' }}</td>
                                <td class="label" style="padding: 1px 3px;">Menjadi</td>
                                <td class="value">{{ $ophtamology_komprehensif->menjadi_oculi_sinistra ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="label" style="padding: 1px 3px;">KMB</td>
                                <td class="value">{{ $ophtamology_komprehensif->kmb_oculi_dextra ?? '' }}</td>
                                <td class="label" style="padding: 1px 3px;">KMB</td>
                                <td class="value">{{ $ophtamology_komprehensif->kmb_oculi_sinistra ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="label" style="padding: 1px 3px;">TOD</td>
                                <td class="value">{{ $ophtamology_komprehensif->tio_tod ?? '' }}</td>
                                <td class="label" style="padding: 1px 3px;">TOS</td>
                                <td class="value">{{ $ophtamology_komprehensif->tio_tos ?? '' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Status Present -->
                <tr>
                    <td colspan="2" class="label" style="padding-top: 18px; font-size: 12pt;">STATUS PRESENT</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table style="width: 100%; margin-top: 8px; border-collapse: collapse;">
                            <tr>
                                <td class="label" style="width: 25%; padding: 4px 8px;">Sensorium</td>
                                <td class="value" style="width: 25%;">
                                    {{ $statusPresent['sensorium'] ?? '' }}
                                </td>

                                <td class="label" style="width: 25%; padding: 4px 8px;">Anemis</td>
                                <td class="value" style="width: 25%;">
                                    {{ $statusPresent['anemis'] ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="label" style="padding: 4px 8px;">Tekanan darah</td>
                                <td class="value">
                                    {{ ($statusPresent['sistole'] ?? '') && ($statusPresent['diastole'] ?? '')
                                        ? $statusPresent['sistole'].'/'.$statusPresent['diastole'].' mmHg'
                                        : '' }}
                                </td>

                                <td class="label" style="padding: 4px 8px;">Ikhterik</td>
                                <td class="value">
                                    {{ $statusPresent['ikhterik'] ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="label" style="padding: 4px 8px;">Frekuensi nadi</td>
                                <td class="value">
                                    {{ $statusPresent['nadi'] ?? '' }}
                                </td>

                                <td class="label" style="padding: 4px 8px;">Dyspnoe</td>
                                <td class="value">
                                    {{ $statusPresent['dyspnoe'] ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="label" style="padding: 4px 8px;">Frekuensi nafas</td>
                                <td class="value">
                                    {{ $statusPresent['nafas'] ?? '' }}
                                </td>

                                <td class="label" style="padding: 4px 8px;">Sianosis</td>
                                <td class="value">
                                    {{ $statusPresent['sianosis'] ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="label" style="padding: 4px 8px;">Temperatur</td>
                                <td class="value">
                                    {{ $statusPresent['suhu'] ?? '' }} °C
                                </td>

                                <td class="label" style="padding: 4px 8px;">Edema</td>
                                <td class="value">
                                    {{ $statusPresent['edema'] ?? '' }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- Pemeriksaan Oftalmologi Komprehensif -->

                <tr>
                    <td colspan="2">
                       <table border="1">
                            <tr>
                                <th style="width:35%; text-align:center;">Pengkajian Awal Medis Opthamology/ Mata</th>
                                <th style="width:30%; text-align:center;">SMF: PENYAKIT MATA</th>
                                <th style="width:35%; text-align:center;">NO RM: {{ $data['dataMedis']->kd_pasien }}</th>
                            </tr>
                       </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="label" style="font-size:12pt;">
                        STATUS OPTHALMICUS
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table style="width:100%; border-collapse:collapse; margin-top:0px; ">
                            <thead>
                                <tr>
                                    <th style="width:35%; text-align:center;">OCULI DEXTRA</th>
                                    <th style="width:30%; text-align:center;">PEMERIKSAAN</th>
                                    <th style="width:35%; text-align:center;"> OCULI SINISTRA</th>
                                </tr>
                            @php
                                    $path = public_path('assets/images/Ophthalmology/eye.png');
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $dataImage = file_get_contents($path);
                                    $eyeBase64 = 'data:image/' . $type . ';base64,' . base64_encode($dataImage);
                                @endphp

                                <tr>
                                    <td class="value" style="text-align:left; padding:6px; border-bottom:1px solid #999;">
                                        <img src="{{ $eyeBase64 }}" width="150px" alt="Eye">
                                    </td>

                                    <td class="label" style="text-align:center; font-weight:bold; border-bottom:1px solid #999;">
                                        Gambar
                                    </td>

                                    <td class="value" style="text-align:right; padding:6px; border-bottom:1px solid #999;">
                                    <img src="{{ $eyeBase64 }}" width="150px" alt="Eye">
                                    </td>
                                </tr>

                            </thead>

                            @php
                                $rows = [
                                    'Visus' => ['visus_oculi_dextra', 'visus_oculi_sinistra'],
                                    'Visus koreksi' => ['koreksi_oculi_dextra', 'koreksi_oculi_sinistra'],
                                    'Refraksi Subyektif' => ['subyektif_oculi_dextra', 'subyektif_oculi_sinistra'],
                                    'Refraksi Obyektif' => ['obyektif_oculi_dextra', 'obyektif_oculi_sinistra'],
                                    'TIO' => ['tio_oculi_dextra', 'tio_oculi_sinistra'],
                                    'Posisi' => ['posisi_oculi_dextra', 'posisi_oculi_sinistra'],
                                    'Palpebra superior' => ['palpebra_oculi_dextra', 'palpebra_oculi_sinistra'],
                                    'Palpebra inferior' => ['inferior_oculi_dextra', 'inferior_oculi_sinistra'],
                                    'Conj. Tars Superior' => ['tars_superior_oculi_dextra', 'tars_superior_oculi_sinistra'],
                                    'Conj. Tars Inferior' => ['tars_inferior_oculi_dextra', 'tars_inferior_oculi_sinistra'],
                                    'Conj. Bulbi' => ['bulbi_oculi_dextra', 'bulbi_oculi_sinistra'],
                                    'Sclera' => ['sclera_oculi_dextra', 'sclera_oculi_sinistra'],
                                    'Cornea' => ['cornea_oculi_dextra', 'cornea_oculi_sinistra'],
                                    'Camera Oculi Anterior' => ['anterior_oculi_dextra', 'anterior_oculi_sinistra'],
                                    'Pupil' => ['pupil_oculi_dextra', 'pupil_oculi_sinistra'],
                                    'Iris' => ['iris_oculi_dextra', 'iris_oculi_sinistra'],
                                    'Lensa' => ['lensa_oculi_dextra', 'lensa_oculi_sinistra'],
                                    'Corpus Vitreous' => ['vitreous_oculi_dextra', 'vitreous_oculi_sinistra'],
                                    'Fundus Oculi: Media' => ['media_oculi_dextra', 'media_oculi_sinistra'],
                                    'Papil' => ['papil_oculi_dextra', 'papil_oculi_sinistra'],
                                    'Macula' => ['macula_oculi_dextra', 'macula_oculi_sinistra'],
                                    'Retina' => ['retina_oculi_dextra', 'retina_oculi_sinistra'],
                                ];
                            @endphp

                            @foreach($rows as $label => [$od, $os])
                                <tr style="">
                                    <td class="value" style="text-align:left; height: 25px; padding:6px; border-bottom:1px solid #999;">
                                        {{ $ophtamology_komprehensif->$od ?? '' }}
                                    </td>

                                    <td class="label" style="text-align:center; height: 25px; font-weight:bold; border-bottom:1px solid #999;">
                                        {{ $label }}
                                    </td>

                                    <td class="value" style="text-align:right; height: 25px; padding:6px; border-bottom:1px solid #999;">
                                        {{ $ophtamology_komprehensif->$os ?? '' }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                    <tr>
                        <td colspan="2">
                        <table border="1">
                                <tr>
                                    <th style="width:35%; text-align:center;">Pengkajian Awal Medis Opthamology/ Mata</th>
                                    <th style="width:30%; text-align:center;">SMF: PENYAKIT MATA</th>
                                    <th style="width:35%; text-align:center;">NO RM: {{ $data['dataMedis']->kd_pasien }}</th>
                                </tr>
                        </table>
                        </td>
                    </tr>
                    <!-- DIAGNOSIS DIFERENSIAL -->
                    @php
                        $diagnosisBanding = json_decode($asesmen_kep_ophtamology->diagnosis_banding ?? '[]', true);
                        $diagnosisKerja   = json_decode($asesmen_kep_ophtamology->diagnosis_kerja ?? '[]', true);
                    @endphp
                    <tr>
                        <td class="label" style="padding:10px 6px; vertical-align:top;">
                            DIAGNOSIS DIFERENSIAL
                        </td>
                        <td class="value" style="padding:10px 6px;">
                            {{ !empty($diagnosisBanding) && count($diagnosisBanding) > 0
                                ? implode(', ', $diagnosisBanding)
                                : '–' }}
                        </td>
                    </tr>

                    <!-- DIAGNOSIS KERJA -->
                    <tr>
                        <td class="label" style="padding:14px 6px 10px; vertical-align:top;">
                            DIAGNOSIS KERJA
                        </td>
                        <td class="value" style="padding:14px 6px 10px;">
                            {{ !empty($diagnosisKerja) && count($diagnosisKerja) > 0
                                ? implode(', ', $diagnosisKerja)
                                : '–' }}
                        </td>
                    </tr>

                    <!-- RENCANA PEMERIKSAAN LAIN -->
                    <tr>
                        <td colspan="2"
                            class="label"
                            style="padding:16px 6px 8px; font-weight:bold;">
                            RENCANA PEMERIKSAAN LAIN
                        </td>
                    </tr>

                    <!-- RENCANA PENATALAKSANAAN DAN PENGOBATAN -->
                    <tr>
                        <td colspan="2"
                            class="label"
                            style="padding:18px 6px 8px; font-weight:bold;">
                            RENCANA PENATALAKSANAAN DAN PENGOBATAN
                        </td>
                    </tr>

                    <!-- PROGNOSIS -->
                    <tr>
                        <td class="label" style="padding:16px 6px 10px;">
                            PROGNOSIS
                        </td>

                        <td class="value" style="padding:16px 6px 10px;">
                            {{ $asesmen_kep_ophtamology->paru_prognosis ?? '–' }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"
                            style="height:32px; padding:6px 8px; border-bottom:1px solid #999;">
                        </td>
                    </tr>
                    <!-- PERENCANAAN PULANG PASIEN (DISCHARGE PLANNING) -->
                @php
                    // Ambil data rencana pulang



                    // Logika ketergantungan
                    $ketergantungan = (
                        ($rencanaPulang['memerlukan_keterampilan_khusus'] ?? '') == 'ya' ||
                        ($rencanaPulang['memerlukan_alat_bantu'] ?? '') == 'ya' ||
                        ($rencanaPulang['memiliki_nyeri_kronis'] ?? '') == 'ya'
                    );
                @endphp

                <tr>
                    <td colspan="2" class="label" style="padding-top: 18px; font-size: 12pt;">
                        PERENCANAAN PULANG PASIEN (DISCHARGE PLANNING)
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table style="width: 100%; margin-top: 8px; border-collapse: collapse;">

                            <!-- Usia lanjut (> 60 th) -->
                            <tr>
                                <td class="label" style="width: 55%; padding: 6px 8px;">
                                    Usia lanjut (> 60 th)
                                </td>
                                <td style="padding: 6px 8px; text-align: center;">
                                    <label style="margin-right: 30px;">
                                        <input type="checkbox"
                                            {{ $data['dataMedis']->pasien->umur >  60 ? 'checked' : '' }}>
                                        Ya
                                    </label>
                                    <label>
                                        <input type="checkbox"
                                            {{ $data['dataMedis']->pasien->umur   < 60 ? 'checked' : '' }}>
                                        Tidak
                                    </label>
                                </td>
                                <td rowspan="4" class="value"
                                    style="vertical-align: top; padding: 6px 8px; width: 35%; font-size: 10pt;">
                                    Jika salah satu jawaban “ya” maka pasien membutuhkan rencana pulang khusus.
                                </td>
                            </tr>

                            <!-- Hambatan mobilisasi -->
                            <tr>
                                <td class="label" style="padding: 6px 8px;">
                                    Hambatan mobilisasi
                                </td>
                                <td style="padding: 6px 8px; text-align: center;">
                                    <label style="margin-right: 30px;">
                                        <input type="checkbox"
                                            {{ $rencanaPulang['hambatan_mobilisasi']  == 'ya' ? 'checked' : '' }}>
                                        Ya
                                    </label>
                                    <label>
                                        <input type="checkbox"
                                            {{ $rencanaPulang['hambatan_mobilisasi'] == '0' ? 'checked' : '' }}>
                                        Tidak
                                    </label>
                                </td>
                            </tr>

                            <!-- Membutuhkan pelayanan medis -->
                            <tr>
                                <td class="label" style="padding: 6px 8px;">
                                    Membutuhkan pelayanan medis berkelanjutan
                                </td>
                                <td style="padding: 6px 8px; text-align: center;">
                                    <label style="margin-right: 30px;">
                                        <input type="checkbox"
                                            {{ $rencanaPulang['membutuhkan_pelayanan_medis']  == 'ya' ? 'checked' : '' }}>
                                        Ya
                                    </label>
                                    <label>
                                        <input type="checkbox"
                                            {{ $rencanaPulang['membutuhkan_pelayanan_medis']  == 'tidak' ? 'checked' : '' }}>
                                        Tidak
                                    </label>
                                </td>
                            </tr>

                            <!-- Ketergantungan aktivitas harian -->
                            <tr>
                                <td class="label" style="padding: 6px 8px;">
                                    Ketergantungan dengan orang lain dalam aktivitas harian
                                </td>
                                <td style="padding: 6px 8px; text-align: center;">
                                    <label style="margin-right: 30px;">
                                        <input type="checkbox" {{ $ketergantungan ? 'checked' : '' }}>
                                        Ya
                                    </label>
                                    <label>
                                        <input type="checkbox" {{ !$ketergantungan ? 'checked' : '' }}>
                                        Tidak
                                    </label>
                                </td>
                            </tr>

                            <!-- Rencana Pulang Khusus -->
                            <tr>
                                <td colspan="3" class="label"
                                    style="padding: 10px 8px 4px 8px; font-weight: bold; border-bottom: 1px solid #000;">
                                    Rencana Pulang Khusus:
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="value tall empty-space" style="height: 80px;">
                                    {{ $rencanaPulang['kesimpulan'] ?? '' }}
                                </td>
                            </tr>

                            <!-- Rencana Lama Perawatan -->
                            <tr>
                                <td class="label" style="padding: 10px 8px 4px 8px; width: 50%;">
                                    Rencana Lama Perawatan :
                                </td>
                                <td class="value" style="width: 50%; height: 40px;">
                                    {{ $rencanaPulang['perkiraan_lama_dirawat'] ?? '' }}
                                </td>
                            </tr>

                            <!-- Rencana Tanggal Pulang -->
                            <tr>
                                <td class="label" style="padding: 4px 8px;">
                                    Rencana Tanggal Pulang :
                                </td>
                                <td class="value" style="height: 40px;">
                                    {{ isset($rencanaPulang['rencana_pulang'])
                                        ? \Carbon\Carbon::parse($rencanaPulang['rencana_pulang'])->translatedFormat('d F Y')
                                        : '' }}
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>

                <!-- Tanda Tangan Dokter -->
                <tr>
                    <td colspan="2" style="padding-top: 40px; text-align: right;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="width: 60%;"></td>
                                <td style="text-align: center; padding: 8px;">
                                    Tanggal: {{ date('d-m-Y', strtotime($asesmen_kep_ophtamology->waktu_masuk)) }}
                                    Jam: {{ date('H:i', strtotime($asesmen_kep_ophtamology->waktu_masuk)) }}
                                    <br><br>
                                    Dokter yang memeriksa
                                    <br><br>
                                    <img src="{{ generateQrCode($data['dataMedis']->dokter->nama_lengkap, 120, 'svg_datauri') }}" alt="QR Code">
                                    <br>
                                    <br>
                                    {{ $data['dataMedis']->dokter->nama_lengkap     }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

        </div>
    </body>
</html>
