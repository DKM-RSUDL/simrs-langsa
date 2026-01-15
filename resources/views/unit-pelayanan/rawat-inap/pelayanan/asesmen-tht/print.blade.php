<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen THT</title>
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
            font-size: 11pt;
            padding-top: 12px;
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
    </style>
</head>

<body>
    <div class="a4">

        @php
            // pola variabel
            $asesmen = $asesmen ?? ($data['asesmen'] ?? null);

            // pasien
            $pasien = $pasien ?? ($data['dataMedis']->pasien ?? ($asesmen->pasien ?? null));

            // user/perawat
            $userName = $asesmen->user->name ?? ($user->name ?? '.............................');

            // logo base64 (dompdf-friendly)
            $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = @file_get_contents($logoPath);
            $logoBase64 = $logoData ? 'data:image/' . $logoType . ';base64,' . base64_encode($logoData) : null;

            // Helper: ambil 1 record dari relasi (Model / Collection / array)
            $firstRel = function ($rel) {
                if ($rel instanceof \Illuminate\Support\Collection) {
                    return $rel->first();
                }
                if (is_array($rel)) {
                    return $rel[0] ?? null;
                }
                return $rel; // Model atau null
            };

            // Relasi utama
            $rmeTht = $firstRel($asesmen->rmeAsesmenTht ?? null);
            $pfTht = $firstRel($asesmen->rmeAsesmenThtPemeriksaanFisik ?? null);
            $rk = $firstRel($asesmen->rmeAsesmenThtRiwayatKesehatanObatAlergi ?? null);
            $dp = $firstRel($asesmen->rmeAsesmenThtDischargePlanning ?? null);
            $dxImpl = $firstRel($asesmen->rmeAsesmenThtDiagnosisImplementasi ?? null);

            // Data masuk
            $tglMasuk = $rmeTht->tgl_masuk ?? null;

            // kondisi masuk mapping
            $kondisiMasuk = $rmeTht->kondisi_masuk ?? '-';
            $kondisiMasukText = match ((string) $kondisiMasuk) {
                '1' => 'Mandiri',
                '2' => 'Kursi Roda',
                '3' => 'Brankar',
                default => $kondisiMasuk,
            };

            // Helper aman json decode list
            $decodeList = function ($val) {
                if (empty($val)) {
                    return [];
                }
                $d = is_string($val) ? json_decode($val, true) : $val;
                return is_array($d) ? $d : [];
            };

            // obat & alergi & riwayat penyakit
            $riwayatObat = $decodeList($rk->riwayat_penggunaan_obat ?? null);
            $riwayatAlergi = $decodeList($rk->alergi ?? null);
            $penyakitDiderita = $decodeList($rk->riwayat_kesehatan_penyakit_diderita ?? null);
            $penyakitKeluarga = $decodeList($rk->riwayat_kesehatan_penyakit_keluarga ?? null);

            // diagnosis & implementasi
            $diagnosisBanding = $decodeList($dxImpl->diagnosis_banding ?? null);
            $diagnosisKerja = $decodeList($dxImpl->diagnosis_kerja ?? null);

            $observasi = $decodeList($dxImpl->observasi ?? null);
            $terapeutik = $decodeList($dxImpl->terapeutik ?? null);
            $edukasi = $decodeList($dxImpl->edukasi ?? null);
            $kolaborasi = $decodeList($dxImpl->kolaborasi ?? null);

            // Prognosis (label dari SatsetPrognosis)
            $prognosisLabel = '-';
            if (!empty($dxImpl->tht_prognosis ?? null)) {
                $pid = (string) $dxImpl->tht_prognosis;

                // Prefer data dari controller kalau tersedia
                if (isset($satsetPrognosis) && $satsetPrognosis instanceof \Illuminate\Support\Collection) {
                    $found = $satsetPrognosis->firstWhere('prognosis_id', $pid);
                    $prognosisLabel = $found->value ?? $pid;
                } else {
                    // fallback query
                    $prognosisLabel = \App\Models\SatsetPrognosis::where('prognosis_id', $pid)->value('value') ?? $pid;
                }
            }

            // waktu isi (ambil dari waktu asesmen kalau ada)
            $waktuIsi = $asesmen->waktu_asesmen ?? null;
            $tglIsi = $waktuIsi ? \Carbon\Carbon::parse($waktuIsi)->format('Y-m-d') : null;
            $jamIsi = $waktuIsi ? \Carbon\Carbon::parse($waktuIsi)->format('H:i') : null;

            $dokterNama =
                $data['dataMedis']->dokter->nama_lengkap ??
                ($data['dataMedis']->dokter->NAMA ?? ($data['dataMedis']->nama_dokter ?? '-'));

            // AVPU map
            $avpu = $pfTht->avpu ?? null;
            $avpuOptions = [
                '0' => 'Sadar Baik/Alert : 0',
                '1' => 'Berespon dengan kata-kata/Voice: 1',
                '2' => 'Hanya berespon jika dirangsang nyeri/pain: 2',
                '3' => 'Pasien tidak sadar/unresponsive: 3',
                '4' => 'Gelisah atau bingung: 4',
                '5' => 'Acute Confusional States: 5',
            ];
        @endphp

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
                    <span class="title-main">ASESMEN THT</span>
                    <span class="title-sub">FORMULIR ASESMEN THT</span>
                </td>

                <td class="td-right">
                    <div class="unit-box">
                        <span class="unit-text" style="font-size: 14px; margin-top: 10px;">RAWAT INAP</span>
                    </div>
                </td>
            </tr>
        </table>
        <table class="patient-table">
            <tr>
                <th>No. RM</th>
                <td>{{ $pasien->kd_pasien ?? '-' }}</td>
                <th>Tgl. Lahir</th>
                <td>
                    {{ !empty($pasien->tgl_lahir) ? date('d M Y', strtotime($pasien->tgl_lahir)) : '-' }}
                </td>
            </tr>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $pasien->nama ?? '-' }}</td>
                <th>Jenis Kelamin</th>
                <td>
                    @php
                        $gender = '-';
                        if (isset($pasien->jenis_kelamin)) {
                            $gender = (string) $pasien->jenis_kelamin === '1' ? 'Laki-Laki' : 'Perempuan';
                        }
                    @endphp
                    {{ $gender }}
                </td>
            </tr>
        </table>

        <br>

        <table>
            {{-- 1. DATA MASUK --}}
            <tr>
                <td colspan="2" class="section-title">1. DATA MASUK</td>
            </tr>
            <tr>
                <td class="label" style="width: 10%;">Tanggal Masuk</td>
                <td class="value" style="width: 90%;">{{ $tglMasuk ? date('d M Y', strtotime($tglMasuk)) : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jam Masuk</td>
                <td class="value">{{ $tglMasuk ? date('H:i', strtotime($tglMasuk)) : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kondisi Masuk</td>
                <td class="value">{{ $kondisiMasukText ?? '-' }}</td>
            </tr>

            {{-- 2. ANAMNESIS --}}
            <tr>
                <td colspan="2" class="section-title">2. ANAMNESIS</td>
            </tr>
            <tr>
                <td class="label">Anamnesis</td>
                <td class="value tall">{{ $rmeTht->anamnesis_anamnesis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat penyakit sekarang</td>
                <td class="value tall">{{ $rmeTht->penyakit_sekarang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat penyakit terdahulu</td>
                <td class="value tall">{{ $rmeTht->penyakit_terdahulu ?? '-' }}</td>
            </tr>

            {{-- 3. RIWAYAT OBAT --}}
            <tr>
                <td colspan="2" class="section-title">3. RIWAYAT PENGGUNAAN OBAT</td>
            </tr>
            <tr>
                <td colspan="2">
                    @php
                        $hasObat = !empty($riwayatObat);
                    @endphp

                    <div class="checkbox-group" style="padding: 6px 0 10px 0;">
                        <label style="display:inline-flex; align-items:center; margin-right: 40px;">
                            <input type="checkbox" {{ !$hasObat ? 'checked' : '' }} style="margin-right:6px;">
                            Tidak ada
                        </label>
                        <label style="display:inline-flex; align-items:center;">
                            <input type="checkbox" {{ $hasObat ? 'checked' : '' }} style="margin-right:6px;">
                            Ada, sebutkan:
                        </label>
                    </div>

                    <table style="width:100%; border-collapse:collapse;" border="1">
                        <thead>
                            <tr>
                                <th style="width:35%; text-align:left;">Nama Obat</th>
                                <th style="width:20%; text-align:left;">Dosis</th>
                                <th style="width:20%; text-align:left;">Frekuensi</th>
                                <th style="width:25%; text-align:left;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($hasObat)
                                @foreach ($riwayatObat as $obat)
                                    <tr>
                                        <td>{{ $obat['namaObat'] ?? '-' }}</td>
                                        <td>{{ trim(($obat['dosis'] ?? '-') . ' ' . ($obat['satuan'] ?? '')) }}</td>
                                        <td>{{ $obat['frekuensi'] ?? '-' }}</td>
                                        <td>{{ $obat['keterangan'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" style="text-align:center;">Tidak ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>

            {{-- 4. ALERGI --}}
            <tr>
                <td colspan="2" class="section-title">4. ALERGI</td>
            </tr>
            <tr>
                <td colspan="2">
                    @php

                        $riwayatAlergi = $decodeList($rk->alergi ?? null);

                        if (empty($riwayatAlergi) && isset($alergiPasien)) {
                            $riwayatAlergi = collect($alergiPasien)
                                ->map(function ($a) {
                                    return [
                                        'alergen' => $a->nama_alergi ?? ($a->alergen ?? '-'),
                                        'reaksi' => $a->reaksi ?? '-',
                                        'severe' => $a->tingkat_keparahan ?? ($a->severe ?? '-'),
                                    ];
                                })
                                ->toArray();
                        }

                        $hasAlergi = !empty($riwayatAlergi);
                    @endphp

                    <div class="checkbox-group" style="padding: 6px 0 10px 0;">
                        <label style="display:inline-flex; align-items:center; margin-right: 40px;">
                            <input type="checkbox" {{ !$hasAlergi ? 'checked' : '' }} style="margin-right:6px;">
                            Tidak ada
                        </label>
                        <label style="display:inline-flex; align-items:center;">
                            <input type="checkbox" {{ $hasAlergi ? 'checked' : '' }} style="margin-right:6px;">
                            Ada, sebutkan:
                        </label>
                    </div>

                    <table style="width:100%; border-collapse:collapse;" border="1">
                        <thead>
                            <tr>
                                <th style="width:5%; text-align:center;">No</th>
                                <th style="width:30%; text-align:left;">Alergen</th>
                                <th style="width:45%; text-align:left;">Reaksi</th>
                                <th style="width:20%; text-align:left;">Severe</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($hasAlergi)
                                @foreach ($riwayatAlergi as $i => $aler)
                                    <tr>
                                        <td style="text-align:center;">{{ $i + 1 }}</td>
                                        <td>{{ is_array($aler) ? $aler['alergen'] ?? '-' : $aler ?? '-' }}</td>
                                        <td>{{ is_array($aler) ? $aler['reaksi'] ?? '-' : '-' }}</td>
                                        <td>{{ is_array($aler) ? $aler['severe'] ?? '-' : '-' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" style="text-align:center;">Tidak ada data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>

            {{-- 6. PEMERIKSAAN FISIK --}}
            <tr>
                <td colspan="2" class="section-title">6. PEMERIKSAAN FISIK</td>
            </tr>

            <tr>
                <td colspan="2">
                    <table style="width:100%; border-collapse:collapse; margin-top:6px;" border="1">
                        <tbody>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Tekanan Darah</td>
                                <td style="width:20%;">
                                    {{ $pfTht->darah_sistole ?? '-' }} / {{ $pfTht->darah_diastole ?? '-' }} mmHg
                                </td>
                                <td style="width:20%; font-weight:bold;">Nadi</td>
                                <td>{{ $pfTht->nadi ?? '-' }} /menit</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Nafas</td>
                                <td>{{ $pfTht->nafas ?? '-' }} /menit</td>
                                <td style="font-weight:bold;">Suhu</td>
                                <td>{{ $pfTht->suhu ?? '-' }} °C</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Sensorium</td>
                                <td>{{ $pfTht->sensorium ?? '-' }}</td>
                                <td style="font-weight:bold;">KU/KP/KG</td>
                                <td>{{ $pfTht->ku_kp_kg ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">AVPU</td>
                                <td colspan="3">{{ $avpuOptions[(string) $avpu] ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            {{-- Sub Pemeriksaan Fisik Koprehensif --}}
            <tr>
                <td colspan="2" class="section-title">PEMERIKSAAN FISIK KOPREHENSIF</td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top:8px;">
                    <table style="width:100%; border-collapse:collapse;" border="1">
                        <tbody>
                            <tr>
                                <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Daun Telinga</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Nanah (Kanan/Kiri)</td>
                                <td>{{ $pfTht->daun_telinga_nanah_kana ?? '-' }} /
                                    {{ $pfTht->daun_telinga_nanah_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Darah (Kanan/Kiri)</td>
                                <td>{{ $pfTht->daun_telinga_darah_kanan ?? '-' }} /
                                    {{ $pfTht->daun_telinga_darah_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Lainnya (Kanan/Kiri)</td>
                                <td colspan="3">{{ $pfTht->daun_telinga_lainnya_kanan ?? '-' }} /
                                    {{ $pfTht->daun_telinga_lainnya_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Liang Telinga</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Darah (Kanan/Kiri)</td>
                                <td>{{ $pfTht->liang_telinga_darah_kanan ?? '-' }} /
                                    {{ $pfTht->liang_telinga_darah_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Nanah (Kanan/Kiri)</td>
                                <td>{{ $pfTht->liang_telinga_nanah_kanan ?? '-' }} /
                                    {{ $pfTht->liang_telinga_nanah_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Berbau (Kanan/Kiri)</td>
                                <td>{{ $pfTht->liang_telinga_berbau_kanan ?? '-' }} /
                                    {{ $pfTht->liang_telinga_berbau_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Lainnya (Kanan/Kiri)</td>
                                <td>{{ $pfTht->liang_telinga_lainnya_kanan ?? '-' }} /
                                    {{ $pfTht->liang_telinga_lainnya_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Membran
                                        Tympani</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Warna (Kanan/Kiri)</td>
                                <td>{{ $pfTht->membran_tympani_warna_kanan ?? '-' }} /
                                    {{ $pfTht->membran_tympani_warna_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Perforasi (Kanan/Kiri)</td>
                                <td>{{ $pfTht->membran_tympani_perforasi_kanan ?? '-' }} /
                                    {{ $pfTht->membran_tympani_perforasi_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Lainnya (Kanan/Kiri)</td>
                                <td colspan="3">{{ $pfTht->membran_tympani_lainnya_kanan ?? '-' }} /
                                    {{ $pfTht->membran_tympani_lainnya_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Tes
                                        Pendengaran</strong>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Rinne (Kanan/Kiri)</td>
                                <td>{{ $pfTht->tes_pendengaran_renne_res_kanan ?? '-' }} /
                                    {{ $pfTht->tes_pendengaran_renne_res_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Weber (Kanan/Kiri)</td>
                                <td>{{ $pfTht->tes_pendengaran_weber_tes_kanan ?? '-' }} /
                                    {{ $pfTht->tes_pendengaran_weber_tes_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Schwabach (Kanan/Kiri)</td>
                                <td>{{ $pfTht->tes_pendengaran_schwabach_test_kanan ?? '-' }} /
                                    {{ $pfTht->tes_pendengaran_schwabach_test_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Bebisik (Kanan/Kiri)</td>
                                <td>{{ $pfTht->tes_pendengaran_bebisik_kanan ?? '-' }} /
                                    {{ $pfTht->tes_pendengaran_bebisik_kiri ?? '-' }}</td>
                            </tr>
                            <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Rhinoscopi
                                    Anterior</strong>
                            </td>
                            <tr>
                                <td style="font-weight:bold;">Cavum Nasi (Kanan/Kiri)</td>
                                <td>{{ $pfTht->rhinoscopi_anterior_cavun_nasi_kanan ?? '-' }} /
                                    {{ $pfTht->rhinoscopi_anterior_cavun_nasi_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Konka Inferior (Kanan/Kiri)</td>
                                <td>{{ $pfTht->rhinoscopi_anterior_konka_inferior_kanan ?? '-' }} /
                                    {{ $pfTht->rhinoscopi_anterior_konka_inferior_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Septum Nasi (Kanan/Kiri)</td>
                                <td colspan="3">{{ $pfTht->rhinoscopi_anterior_septum_nasi_kanan ?? '-' }} /
                                    {{ $pfTht->rhinoscopi_anterior_septum_nasi_kiri ?? '-' }}</td>
                            </tr>

                            <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Rhinoscopi
                                    Posterior</strong>
                            </td>
                            <tr>
                                <td style="font-weight:bold;">Septum Nasi (Kanan/Kiri)</td>
                                <td>{{ $pfTht->rhinoscopi_pasterior_septum_nasi_kanan ?? '-' }} /
                                    {{ $pfTht->rhinoscopi_pasterior_septum_nasi_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Fasso Rosenmuler (Kanan/Kiri)</td>
                                <td>{{ $pfTht->rhinoscopi_fasso_rossenmuler_kanan ?? '-' }} /
                                    {{ $pfTht->rhinoscopi_fasso_rossenmuler_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Superior (Kanan/Kiri)</td>
                                <td>{{ $pfTht->rhinoscopi_superior_kanan ?? '-' }} /
                                    {{ $pfTht->rhinoscopi_superior_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Media (Kanan/Kiri)</td>
                                <td>{{ $pfTht->rhinoscopi_media_kanan ?? '-' }} /
                                    {{ $pfTht->rhinoscopi_media_kiri ?? '-' }}</td>
                            </tr>

                            <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Meatus Nasi</strong>
                            </td>
                            <tr>
                                <td style="font-weight:bold;">Superior (Kanan/Kiri)</td>
                                <td>{{ $pfTht->meatus_nasi_superior_kanan ?? '-' }} /
                                    {{ $pfTht->meatus_nasi_superior_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Media (Kanan/Kiri)</td>
                                <td>{{ $pfTht->meatus_nasi_media_kanan ?? '-' }} /
                                    {{ $pfTht->meatus_nasi_media_kiri ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Inferior (Kanan/Kiri)</td>
                                <td colspan="3">{{ $pfTht->meatus_nasi_inferior_kanan ?? '-' }} /
                                    {{ $pfTht->meatus_nasi_inferior_kiri ?? '-' }}</td>
                            </tr>
                            <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Hidung</strong>
                            </td>
                            <tr>
                                <td style="font-weight:bold;">Bentuk (Kanan/Kiri)</td>
                                <td>{{ $pfTht->hidung_bentuk_kanan ?? '-' }} / {{ $pfTht->hidung_bentuk_kiri ?? '-' }}
                                </td>
                                <td style="font-weight:bold;">Luka (Kanan/Kiri)</td>
                                <td>{{ $pfTht->hidung_luka_kanan ?? '-' }} / {{ $pfTht->hidung_luka_kiri ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Bisul (Kanan/Kiri)</td>
                                <td>{{ $pfTht->hidung_bisul_kanan ?? '-' }} / {{ $pfTht->hidung_bisul_kiri ?? '-' }}
                                </td>
                                <td style="font-weight:bold;">Fissare (Kanan/Kiri)</td>
                                <td>{{ $pfTht->hidung_fissare_kanan ?? '-' }} /
                                    {{ $pfTht->hidung_fissare_kiri ?? '-' }}</td>
                            </tr>

                            <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Sinus Frontalis</strong>
                            </td>
                            <tr>
                                <td style="font-weight:bold;">Nyeri Tekan (Kanan/Kiri)</td>
                                <td>{{ $pfTht->senus_frontalis_nyeri_tekan_kanan ?? '-' }} /
                                    {{ $pfTht->senus_frontalis_nyeri_tekan_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Transluminasi (Kanan/Kiri)</td>
                                <td>{{ $pfTht->senus_frontalis_transluminasi_kanan ?? '-' }} /
                                    {{ $pfTht->senus_frontalis_transluminasi_kiri ?? '-' }}</td>
                            </tr>
                            <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Sinus Maksinasi</strong>
                            </td>
                            <tr>
                                <td style="font-weight:bold;">Nyeri Tekan (Kanan/Kiri)</td>
                                <td>{{ $pfTht->sinus_maksinasi_nyari_tekan_kanan ?? '-' }} /
                                    {{ $pfTht->sinus_maksinasi_nyari_tekan_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Transluminasi (Kanan/Kiri)</td>
                                <td>{{ $pfTht->sinus_maksinasi_transluminasi_kanan ?? '-' }} /
                                    {{ $pfTht->sinus_maksinasi_transluminasi_kiri ?? '-' }}</td>
                            </tr>
                            <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Laringoskopi
                                    Indirex</strong>
                            </td>
                            <tr>
                                <td style="width:25%; font-weight:bold;">Pangkal Lidah</td>
                                <td style="width:25%;">{{ $pfTht->pangkal_lidah ?? '-' }}</td>
                                <td style="width:25%; font-weight:bold;">Tonsil Lidah</td>
                                <td style="width:25%;">{{ $pfTht->tonsil_lidah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Epiglotis</td>
                                <td>{{ $pfTht->epiglotis ?? '-' }}</td>
                                <td style="font-weight:bold;">Pita Suara</td>
                                <td>{{ $pfTht->pita_suara ?? '-' }}</td>
                            </tr>
                            <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Plica Vokalis</strong>
                            </td>
                            <tr>
                                <td style="font-weight:bold;">Bentuk (Kanan/Kiri)</td>
                                <td>{{ $pfTht->plica_vokalis_bentuk_kanan ?? '-' }} /
                                    {{ $pfTht->plica_vokalis_bentuk_kiri ?? '-' }}</td>
                                <td style="font-weight:bold;">Warna (Kanan/Kiri)</td>
                                <td>{{ $pfTht->plica_vokalis_warna_kanan ?? '-' }} /
                                    {{ $pfTht->plica_vokalis_warna_kiri ?? '-' }}</td>
                            </tr>
                            <td colspan="4" style="background-color: #a3a3a3d0;"><strong>Antropometri</strong>
                            </td>
                            <tr>
                                <td style="font-weight:bold;">Tinggi Badan</td>
                                <td>{{ $pfTht->antropometri_tinggi_badan ?? '-' }}</td>
                                <td style="font-weight:bold;">Berat Badan</td>
                                <td>{{ $pfTht->antropometr_berat_badan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">IMT</td>
                                <td>{{ $pfTht->antropometri_imt ?? '-' }}</td>
                                <td style="font-weight:bold;">LPT</td>
                                <td>{{ $pfTht->antropometri_lpt ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <td colspan="2" style="padding-top:8px;">
                <div style="font-weight:bold;">Pemeriksaan Fisik</div>
                <div>Centang normal jika fisik yang dinilai normal. Jika tidak dipilih, maka pemeriksaan tidak
                    dilakukan.</div>

                @php
                    $pfItems = $pemeriksaanFisik ?? ($asesmen->pemeriksaanFisik ?? []);
                    if ($pfItems instanceof \Illuminate\Support\Collection) {
                        $pfItems = $pfItems->all();
                    }
                @endphp

                <table style="width:100%; border-collapse:collapse; margin-top:6px;" border="1">
                    <thead>
                        <tr>
                            <th style="width:35%; text-align:left;">Item</th>
                            <th style="width:65%; text-align:left;">Hasil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pfItems as $it)
                            @php
                                $nama =
                                    $it->itemFisik->nama ??
                                    ($it->mrItemFisik->nama ?? ($it->item->nama ?? ($it->nama ?? '-')));
                                $isNormal = $it->is_normal ?? null;
                                $ket = $it->keterangan ?? '';
                            @endphp
                            <tr>
                                <td>{{ $nama }}</td>
                                <td>
                                    @if ($isNormal === 1 || $isNormal === '1')
                                        Normal
                                    @elseif($isNormal === 0 || $isNormal === '0')
                                        Tidak normal{{ $ket ? ' - ' . $ket : '' }}
                                    @else
                                        Tidak diperiksa
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </td>
            </tr>

            {{-- 5. RIWAYAT KESEHATAN --}}
            <tr>
                <td colspan="2" class="section-title">5. RIWAYAT KESEHATAN</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width:100%; border-collapse:collapse; margin-top:6px;" border="1">
                        <thead>
                            <tr>
                                <th style="width:50%; text-align:left;">Penyakit Yang Pernah Diderita</th>
                                <th style="width:50%; text-align:left;">Riwayat Penyakit Keluarga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @if (!empty($penyakitDiderita))
                                        <ol style="margin:0; padding-left:16px;">
                                            @foreach ($penyakitDiderita as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($penyakitKeluarga))
                                        <ol style="margin:0; padding-left:16px;">
                                            @foreach ($penyakitKeluarga as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            {{-- 7. HASIL LABORATORIUM --}}
            <tr>
                <td colspan="2" class="section-title">7. HASIL LABORATORIUM</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width:100%; border-collapse:collapse; margin-top:6px;" border="1">
                        <tbody>
                            <tr>
                                <td style="width:30%; font-weight:bold;">Darah</td>
                                <td style="width:70%;">{{ $rmeTht->darah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Urine</td>
                                <td>{{ $rmeTht->urine ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>


            {{-- 7. HASIL PEMERIKSAAN PENUNJANG --}}
            <tr>
                <td colspan="2" class="section-title">8. HASIL PENUNJANG</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width:100%; border-collapse:collapse; margin-top:6px;" border="1">
                        <tbody>
                            <tr>
                                <td style="width:25%; font-weight:bold;">Rontgent</td>
                                <td style="width:75%;">{{ $rmeTht->rontgent ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Gistopatology</td>
                                <td>{{ $rmeTht->gistopatology ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            {{-- 9. DIAGNOSIS --}}
            <tr>
                <td colspan="2" class="section-title">9. DIAGNOSIS</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width:100%; border-collapse:collapse; margin-top:6px;" border="1">
                        <thead>
                            <tr>
                                <th style="width:50%; text-align:left;">Diagnosis Banding</th>
                                <th style="width:50%; text-align:left;">Diagnosis Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @if (!empty($diagnosisBanding))
                                        <ul style="margin:0; padding-left:16px;">
                                            @foreach ($diagnosisBanding as $d)
                                                <li>{{ $d }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($diagnosisKerja))
                                        <ul style="margin:0; padding-left:16px;">
                                            @foreach ($diagnosisKerja as $d)
                                                <li>{{ $d }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        Tidak ada
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="section-title">10. RENCANA PENATALAKSANAAN DAN PENGOBATAN</td>
            </tr>
            <tr>
                <td class="label">Rencana</td>
                <td class="value tall">{{ $rmeTht->rencana_penatalaksanaan ?? '-' }}</td>
            </tr>

            <tr>
                <td colspan="2" class="section-title">11. PROGNOSIS</td>
            </tr>
            <tr>
                <td class="label">Prognosis</td>
                <td class="value tall">{{ $prognosisLabel }}</td>
            </tr>

            {{-- 8. DISCHARGE PLANNING --}}
            <tr>
                <td colspan="2" class="section-title">12. DISCHARGE PLANNING</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width:100%; border-collapse:collapse; margin-top:6px;" border="1">
                        <tbody>
                            <tr>
                                <td style="width:70%; font-weight:bold;">Usia lanjut</td>
                                <td style="text-align:center;">
                                    @php
                                        $v = $dp->dp_usia_lanjut ?? null;
                                        echo $v === '1' || $v === 1 ? 'Ya' : ($v === '0' || $v === 0 ? 'Tidak' : '-');
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Hambatan mobilisasi</td>
                                <td style="text-align:center;">
                                    @php
                                        $v = $dp->dp_hambatan_mobilisasi ?? null;
                                        echo $v === '1' || $v === 1 ? 'Ya' : ($v === '0' || $v === 0 ? 'Tidak' : '-');
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Membutuhkan pelayanan medis berkelanjutan</td>
                                <td style="text-align:center;">
                                    @php
                                        $v = $dp->dp_layanan_medis_lanjutan ?? null;
                                        echo $v === '1' || $v === 1 ? 'Ya' : ($v === '0' || $v === 0 ? 'Tidak' : '-');
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold;">Ketergantungan aktivitas harian</td>
                                <td style="text-align:center;">
                                    @php
                                        $v = $dp->dp_tergantung_orang_lain ?? null;
                                        echo $v === '1' || $v === 1 ? 'Ya' : ($v === '0' || $v === 0 ? 'Tidak' : '-');
                                    @endphp
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="label">Perkiraan lama hari dirawat</td>
                <td class="value">{{ $dp->dp_lama_dirawat ?? '-' }} Hari</td>
            </tr>
            <tr>
                <td class="label">Rencana Pulang</td>
                <td class="value tall">{{ $dp->dp_rencana_pulang ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kesimpulan</td>
                <td class="value tall">{{ $dp->dp_kesimpulan ?? '-' }}</td>
            </tr>


            {{-- TANDA TANGAN (Dokter yang memeriksa + QR) --}}
            <tr>
                <td style="width: 60%;"></td>
                <td style="text-align: center; padding: 8px;">
                    Tanggal:
                    {{ $tglIsi ? \Carbon\Carbon::parse($tglIsi)->format('d-m-Y') : date('d-m-Y') }}
                    Jam:
                    {{ $jamIsi ? \Carbon\Carbon::parse($jamIsi)->format('H:i') : date('H:i') }}
                    <br><br>
                    Dokter yang memeriksa
                    <br><br>

                    @php
                        $namaDokter =
                            ($asesmen->user->karyawan->gelar_depan ?? '') .
                            ' ' .
                            str()->title($asesmen->user->karyawan->nama ?? '') .
                            ' ' .
                            ($asesmen->user->karyawan->gelar_belakang ?? '');
                        $namaDokter = trim($namaDokter);
                    @endphp

                    @if ($namaDokter !== '')
                        <img src="{{ generateQrCode($namaDokter, 120, 'svg_datauri') }}" alt="QR Code">
                        <br>
                        {{ $namaDokter }}
                    @else
                        ( _________________________ )
                        <br>
                        -
                    @endif
                </td>
            </tr>


        </table>
    </div>
</body>

</html>
