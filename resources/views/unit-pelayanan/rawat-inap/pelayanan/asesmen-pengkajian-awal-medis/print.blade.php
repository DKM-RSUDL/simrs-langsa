<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Medis - Pengkajian Awal Medis</title>

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

        td,
        th {
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
            min-height: 60px;
        }

        .checkbox-group label {
            margin-right: 28px;
            display: inline-block;
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

        .td-right {
            width: 20%;
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

        .section-title {
            font-weight: bold;
            font-size: 11pt;
            padding-top: 12px;
        }

        .mini-label {
            font-weight: bold;
            width: 25%;
        }

        .pain-img {
            margin-top: 8px;
        }

        .pain-img img {
            width: 100%;
            max-width: 520px;
            height: auto;
        }

        .dotted-bottom {
            border-bottom: 1px dotted #444 !important;
        }
    </style>
</head>

<body>
    <div class="a4">

        @php
            // Data utama
            $asesmen = $data['asesmen'] ?? null;
            $medis = $asesmen->asesmenMedisRanap ?? null;
            $fisik = $asesmen->asesmenMedisRanapFisik ?? null;

            $tglIsi = $medis->tanggal ?? null;
            $jamIsi = $medis->jam ?? null;

            $dokterNama =
                $data['dataMedis']->dokter->nama_lengkap ??
                ($data['dataMedis']->dokter->NAMA ?? ($data['dataMedis']->nama_dokter ?? '-'));

            $riwayatObat = [];
            if (!empty($medis->riwayat_penggunaan_obat)) {
                $riwayatObat = json_decode($medis->riwayat_penggunaan_obat, true) ?? [];
            }

            $riwayatAlergi = [];
            if (!empty($asesmen->alergis)) {
                $riwayatAlergi = json_decode($asesmen->alergis, true) ?? [];
            }

            $kesadaranMap = [
                1 => 'Compos Mentis',
                2 => 'Apatis',
                3 => 'Somnolen',
                4 => 'Sopor',
                5 => 'Koma',
            ];
            $kesadaranText = $kesadaranMap[(int) ($medis->tingkat_kesadaran ?? 0)] ?? '-';

            // Skala nyeri
            $skalaNyeriNilai = $medis->skala_nyeri_nilai ?? ($medis->skala_nyeri ?? null);

            $prognosisText = $medis->paru_prognosis ?? null;
            if (!empty($data['satsetPrognosis']) && $medis && !empty($medis->paru_prognosis)) {
                $found = collect($data['satsetPrognosis'])->firstWhere('prognosis_id', $medis->paru_prognosis);
                if ($found) {
                    $prognosisText = $found->value ?? $medis->paru_prognosis;
                }
            }

            $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = @file_get_contents($logoPath);
            $logoBase64 = $logoData ? 'data:image/' . $logoType . ';base64,' . base64_encode($logoData) : null;

            // gambar skala nyeri base64 (dompdf-friendly)
            $painPath = public_path('assets/img/asesmen/asesmen.jpeg');
            $painType = pathinfo($painPath, PATHINFO_EXTENSION);
            $painData = @file_get_contents($painPath);
            $painBase64 = $painData ? 'data:image/' . $painType . ';base64,' . base64_encode($painData) : null;

            $boolYaTidak = function ($v) {
                if ($v === null || $v === '') {
                    return '-';
                }

                // boolean (false/true dari DB)
                if (is_bool($v)) {
                    return $v ? 'Tidak' : 'Ya';
                }

                // string / angka
                $vv = strtolower(trim((string) $v));
                if ($vv === '0') {
                    return 'Ya';
                }
                if ($vv === '1') {
                    return 'Tidak';
                }

                return $v;
            };
        @endphp


        {{-- HEADER --}}
        <table class="header-table">
            <tr>
                <td class="td-left">
                    <table class="brand-table">
                        <tr>
                            <td class="va-middle">
                                @if ($logoBase64)
                                    <img src="{{ $logoBase64 }}" style="width:70px; height:auto;">
                                @endif
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
                    <span class="title-sub">PENGKAJIAN AWAL MEDIS</span>
                </td>

                <td class="td-right">
                    <div class="unit-box">
                        <span class="unit-text" style="font-size: 14px; margin-top: 10px;">RAWAT INAP</span>
                    </div>
                </td>
            </tr>
        </table>

        {{-- IDENTITAS PASIEN --}}
        <table class="patient-table">
            <tr>
                <th>No. RM</th>
                <td>{{ $data['dataMedis']->pasien->kd_pasien ?? '-' }}</td>
                <th>Tgl. Lahir</th>
                <td>
                    {{ $data['dataMedis']->pasien->tgl_lahir
                        ? \Carbon\Carbon::parse($data['dataMedis']->pasien->tgl_lahir)->format('d M Y')
                        : '-' }}
                </td>
            </tr>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $data['dataMedis']->pasien->nama ?? '-' }}</td>
                <th>Umur</th>
                <td>{{ $data['dataMedis']->pasien->umur ?? '-' }} Tahun</td>
            </tr>
        </table>
        <br>

        {{-- ISI FORM --}}
        <table>

            {{-- 1. DATA MASUK --}}
            <tr>
                <td colspan="2" class="section-title">1. DATA MASUK</td>
            </tr>
            <tr>
                <td class="label">Tanggal & Jam Pengisian</td>
                <td class="value">
                    {{ $tglIsi ? \Carbon\Carbon::parse($tglIsi)->format('d M Y') : '-' }}
                    {{ $jamIsi ? \Carbon\Carbon::parse($jamIsi)->format('H:i') : '' }}
                </td>
            </tr>

            {{-- 2. ANAMNESIS --}}
            <tr>
                <td colspan="2" class="section-title">2. ANAMNESIS</td>
            </tr>
            <tr>
                <td class="label">Keluhan Utama</td>
                <td class="value">{{ $medis->keluhan_utama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat Penyakit Sekarang</td>
                <td class="value tall">{{ $medis->riwayat_penyakit_sekarang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat Penyakit Terdahulu</td>
                <td class="value tall">{{ $medis->riwayat_penyakit_terdahulu ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat Penyakit Keluarga</td>
                <td class="value">{{ $medis->riwayat_penyakit_keluarga ?? '-' }}</td>
            </tr>

            {{-- 3. RIWAYAT PENGGUNAAN OBAT --}}
            @php
                // Normalisasi data obat (json dari $medis->riwayat_penggunaan_obat)
                $obatRows = collect($riwayatObat ?? [])
                    ->map(function ($o) {
                        $nama = $o['namaObat'] ?? ($o['nama_obat'] ?? ($o['nama'] ?? ''));
                        $dosis = $o['dosis'] ?? '';
                        $satuan = $o['satuan'] ?? '';
                        $frekuensi = $o['frekuensi'] ?? '';
                        $keterangan = $o['keterangan'] ?? '';

                        // Aturan pakai bisa disimpan beda key
                        $aturan = $o['aturan_pakai'] ?? ($o['aturanPakai'] ?? '');

                        // Bentuk dosis seperti di show: "300 Tablet" (dosis + satuan)
                        $dosisText = trim($dosis . ' ' . $satuan);
                        if ($frekuensi !== '') {
                            $dosisText = trim($dosisText . ' ' . $frekuensi);
                        }

                        // Aturan pakai: kalau ada badge/angka di show, biasanya disimpan sebagai "3" + "Sesudah makan"
                        // jadi gabungkan aturan + keterangan bila ada
                        $aturanText = trim($aturan);
                        if ($keterangan !== '') {
                            $aturanText = $aturanText !== '' ? $aturanText . ' — ' . $keterangan : $keterangan;
                        }

                        return [
                            'nama' => $nama !== '' ? $nama : '-',
                            'dosis' => $dosisText !== '' ? $dosisText : '-',
                            'aturan' => $aturanText !== '' ? $aturanText : '-',
                        ];
                    })
                    ->values();

                $hasObat = $obatRows->count() > 0;
                $minRowsObat = 3;
            @endphp

            <tr>
                <td colspan="2" class="section-title">3. RIWAYAT PENGGUNAAN OBAT</td>
            </tr>

            <tr>
                <td colspan="2" class="checkbox-group" style="padding: 6px 0 10px 0;">
                    <label style="display:inline-flex; align-items:center; margin-right: 40px;">
                        <input type="checkbox" {{ !$hasObat ? 'checked' : '' }} style="margin-right:6px;">
                        Tidak ada
                    </label>
                    <label style="display:inline-flex; align-items:center;">
                        <input type="checkbox" {{ $hasObat ? 'checked' : '' }} style="margin-right:6px;">
                        Ada, sebutkan:
                    </label>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table style="width:100%; border-collapse:collapse;" border="1">
                        <thead>
                            <tr>
                                <th style="width:45%; text-align:left;">Nama Obat</th>
                                <th style="width:25%; text-align:left;">Dosis</th>
                                <th style="width:30%; text-align:left;">Aturan Pakai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($hasObat)
                                @foreach ($obatRows as $row)
                                    <tr>
                                        <td>{{ $row['nama'] }}</td>
                                        <td>{{ $row['dosis'] }}</td>
                                        <td>{{ $row['aturan'] }}</td>
                                    </tr>
                                @endforeach

                                {{-- Tambah baris kosong sampai minRows --}}
                                @if ($obatRows->count() < $minRowsObat)
                                    @for ($x = $obatRows->count(); $x < $minRowsObat; $x++)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                @endif
                            @else
                                @for ($x = 0; $x < $minRowsObat; $x++)
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endfor
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>


            {{-- 4. RIWAYAT ALERGI --}}
            @php
                $alergiFromAsesmen = [];
                if (!empty($medis->alergis)) {
                    $decoded = json_decode($medis->alergis, true);
                    if (is_array($decoded)) {
                        $alergiFromAsesmen = $decoded;
                    }
                }

                $alergiFromMaster = [];
                $masterCol = $data['alergiPasien'] ?? collect();
                if (
                    empty($alergiFromAsesmen) &&
                    $masterCol &&
                    method_exists($masterCol, 'count') &&
                    $masterCol->count() > 0
                ) {
                    $alergiFromMaster = $masterCol
                        ->map(function ($a) {
                            return [
                                'jenis_alergi' => $a->jenis_alergi ?? '-',
                                'alergen' => $a->nama_alergi ?? '-',
                                'reaksi' => $a->reaksi ?? '-',
                                'tingkat_keparahan' => $a->tingkat_keparahan ?? '-',
                            ];
                        })
                        ->toArray();
                }

                $alergiList = !empty($alergiFromAsesmen) ? $alergiFromAsesmen : $alergiFromMaster;

                $alergiRows = collect($alergiList)
                    ->map(function ($a) {
                        return [
                            'jenis' => $a['jenis_alergi'] ?? ($a['jenisAlergi'] ?? ($a['jenis'] ?? '-')),
                            'alergen' => $a['alergen'] ?? ($a['nama_alergi'] ?? ($a['namaAlergi'] ?? '-')),
                            'reaksi' => $a['reaksi'] ?? '-',
                            'tingkat' => $a['tingkat_keparahan'] ?? ($a['tingkatKeparahan'] ?? '-'),
                        ];
                    })
                    ->values();

                $hasAlergi = $alergiRows->count() > 0;
                $minRows = 5;
            @endphp

            <tr>
                <td colspan="2" class="section-title">4. RIWAYAT ALERGI</td>
            </tr>

            <tr>
                <td colspan="2" class="checkbox-group" style="padding: 6px 0 10px 0;">
                    <label style="display:inline-flex; align-items:center; margin-right: 40px;">
                        <input type="checkbox" {{ !$hasAlergi ? 'checked' : '' }} style="margin-right:6px;">
                        Tidak ada
                    </label>
                    <label style="display:inline-flex; align-items:center;">
                        <input type="checkbox" {{ $hasAlergi ? 'checked' : '' }} style="margin-right:6px;">
                        Ada, sebutkan:
                    </label>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table style="width:100%; border-collapse:collapse;" border="1">
                        <thead>
                            <tr>
                                <th style="width:5%; text-align:center;">No</th>
                                <th style="width:20%; text-align:left;">Jenis Alergi</th>
                                <th style="width:25%; text-align:left;">Alergen</th>
                                <th style="width:30%; text-align:left;">Reaksi</th>
                                <th style="width:20%; text-align:left;">Tingkat Keparahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($hasAlergi)
                                @foreach ($alergiRows as $i => $row)
                                    <tr>
                                        <td style="text-align:center;">{{ $i + 1 }}</td>
                                        <td>{{ $row['jenis'] }}</td>
                                        <td>{{ $row['alergen'] }}</td>
                                        <td>{{ $row['reaksi'] }}</td>
                                        <td>{{ $row['tingkat'] }}</td>
                                    </tr>
                                @endforeach
                                @if ($alergiRows->count() < $minRows)
                                    @for ($x = $alergiRows->count(); $x < $minRows; $x++)
                                        <tr>
                                            <td style="text-align:center;">{{ $x + 1 }}</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                @endif
                            @else
                                @for ($x = 0; $x < $minRows; $x++)
                                    <tr>
                                        <td style="text-align:center;">{{ $x + 1 }}</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                @endfor
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>



            {{-- 5. STATUS PRESENT --}}
            <tr>
                <td colspan="2" class="section-title">5. STATUS PRESENT</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%; margin-top: 6px; border-collapse: collapse;">
                        <tr>
                            <td class="mini-label">Tingkat Kesadaran</td>
                            <td class="value">{{ $kesadaranText }}</td>
                            <td class="mini-label">Tekanan Darah</td>
                            <td class="value">
                                {{ ($medis->sistole ?? null) && ($medis->diastole ?? null)
                                    ? $medis->sistole . '/' . $medis->diastole . ' mmHg'
                                    : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="mini-label">Nadi</td>
                            <td class="value">{{ $medis->nadi ?? '-' }}</td>
                            <td class="mini-label">Respirasi</td>
                            <td class="value">{{ $medis->respirasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="mini-label">Suhu</td>
                            <td class="value">{{ !is_null($medis->suhu ?? null) ? $medis->suhu . ' °C' : '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            {{-- 6. PEMERIKSAAN FISIK --}}
            <tr>
                <td colspan="2" class="section-title">6. PEMERIKSAAN FISIK</td>
            </tr>

            @php
                $fisikRows = [
                    'Kepala' => ['pengkajian_kepala', 'pengkajian_kepala_keterangan'],
                    'Mata' => ['pengkajian_mata', 'pengkajian_mata_keterangan'],
                    'THT' => ['pengkajian_tht', 'pengkajian_tht_keterangan'],
                    'Leher' => ['pengkajian_leher', 'pengkajian_leher_keterangan'],
                    'Mulut' => ['pengkajian_mulut', 'pengkajian_mulut_keterangan'],
                    'Jantung' => ['pengkajian_jantung', 'pengkajian_jantung_keterangan'],
                    'Thorax' => ['pengkajian_thorax', 'pengkajian_thorax_keterangan'],
                    'Abdomen' => ['pengkajian_abdomen', 'pengkajian_abdomen_keterangan'],
                    'Tulang Belakang' => ['pengkajian_tulang_belakang', 'pengkajian_tulang_belakang_keterangan'],
                    'Sistem Syaraf' => ['pengkajian_sistem_syaraf', 'pengkajian_sistem_syaraf_keterangan'],
                    'Genetalia' => ['pengkajian_genetalia', 'pengkajian_genetalia_keterangan'],
                    'Status Lokasi' => ['pengkajian_status_lokasi', 'pengkajian_status_lokasi_keterangan'],
                ];
            @endphp

            <tr>
                <td colspan="2">
                    <table style="width:100%; border-collapse:collapse; margin-top:6px;" border="1">
                        <thead>
                            <tr>
                                <th style="width:30%; text-align:left;">Bagian</th>
                                <th style="width:18%; text-align:center;">Status</th>
                                <th style="text-align:left;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fisikRows as $label => [$field, $ket])
                                @php
                                    $val = $fisik->$field ?? 1; // default normal
                                    $isNormal = (string) $val === '1' || $val === 1 || $val === true;
                                @endphp
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td style="text-align:center;">{{ $isNormal ? 'Normal' : 'Tidak Normal' }}</td>
                                    <td>{{ $fisik->$ket ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>

            {{-- 7. SKALA NYERI --}}
            <tr>
                <td colspan="2" class="section-title">7. SKALA NYERI</td>
            </tr>
            <tr>
                <td class="label">Nilai</td>
                <td class="value">{{ !is_null($skalaNyeriNilai) ? $skalaNyeriNilai : '-' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="pain-img">
                    @if ($painBase64)
                        <img src="{{ $painBase64 }}" alt="Wong Baker Pain Scale">
                    @endif
                </td>
            </tr>

            {{-- 8. DIAGNOSIS --}}
            <tr>
                <td colspan="2" class="section-title">8. DIAGNOSIS</td>
            </tr>
            <tr>
                <td class="label">Diagnosis Banding</td>
                <td class="value tall">{{ $medis->diagnosis_banding ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Diagnosis Kerja</td>
                <td class="value tall">{{ $medis->diagnosis_kerja ?? '-' }}</td>
            </tr>

            {{-- 8. RENCANA PENATALAKSANAAN --}}
            <tr>
                <td colspan="2" class="section-title">9. RENCANA PENATALAKSANAAN & PENGOBATAN</td>
            </tr>
            <tr>
                <td class="label">Rencana Pengobatan</td>
                <td class="value tall">{{ $medis->rencana_pengobatan ?? '-' }}</td>
            </tr>

            {{-- 10. PROGNOSIS --}}
            <tr>
                <td colspan="2" class="section-title">11. PROGNOSIS</td>
            </tr>
            <tr>
                <td class="label">Prognosis</td>
                <td class="value">{{ $prognosisText ?? '-' }}</td>
            </tr>


            {{-- 10. DISCHARGE PLANNING --}}
            <tr>
                <td colspan="2" class="section-title">10. PERENCANAAN PULANG PASIEN (DISCHARGE PLANNING)</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 100%; margin-top: 6px; border-collapse: collapse;" border="1">
                        <tr>
                            <td style="width:60%; font-weight:bold;">Usia lanjut (&gt; 60 th)</td>
                            <td style="text-align:center;">
                                {{ $boolYaTidak($medis->usia_lanjut) }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;">Hambatan mobilisasi</td>
                            <td style="text-align:center;">
                                {{ $boolYaTidak($medis->hambatan_mobilisasi) }}
                            </td>
                        </tr>

                        <tr>
                            <td style="font-weight:bold;">Membutuhkan pelayanan medis berkelanjutan</td>
                            <td style="text-align:center;">{{ $medis->penggunaan_media_berkelanjutan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold;">Ketergantungan aktivitas harian</td>
                            <td style="text-align:center;">{{ $medis->ketergantungan_aktivitas ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="label">Rencana Pulang Khusus</td>
                <td class="value tall empty-space">{{ $medis->rencana_pulang_khusus ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Rencana Lama Perawatan</td>
                <td class="value">{{ $medis->rencana_lama_perawatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Rencana Tanggal Pulang</td>
                <td class="value">
                    {{ !empty($medis->rencana_tgl_pulang)
                        ? \Carbon\Carbon::parse($medis->rencana_tgl_pulang)->translatedFormat('d F Y')
                        : '-' }}
                </td>
            </tr>
            <tr>
                <td class="label">Kesimpulan Planning</td>
                <td class="value tall">{{ $medis->kesimpulan_planing ?? '-' }}</td>
            </tr>



            {{-- Tanda tangan --}}
            <tr>
                <td colspan="2" style="padding-top: 34px; text-align: right;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 60%;"></td>
                            <td style="text-align: center; padding: 8px;">
                                Tanggal:
                                {{ $tglIsi ? \Carbon\Carbon::parse($tglIsi)->format('d-m-Y') : date('d-m-Y') }}
                                Jam:
                                {{ $jamIsi ? \Carbon\Carbon::parse($jamIsi)->format('H:i') : date('H:i') }}
                                <br><br>
                                Dokter yang memeriksa
                                <br><br><br><br>
                                ( .................................................. )
                                <br>
                                {{ $dokterNama }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
    </div>
</body>

</html>
