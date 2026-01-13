<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Medis Anak</title>
    <style>
        @page {
            size: A4;
            margin: 3mm 6mm;
        }

        body {
            margin: 0;
            padding: 0;
        }

        * {
            box-sizing: border-box;
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8.5pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 3px 5px;
            vertical-align: top;
        }

        /* --- HEADER & IDENTITAS --- */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0f0f0;
            padding: 0;
            margin-bottom: 10px;
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
            margin-bottom: 15px;
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
            background-color: transparent;
            padding: 5px 0 5px 0;
            margin-top: 12px;
            border: none;
            display: block;
        }

        .bordered-table,
        .bordered-table th,
        .bordered-table td {
            border: 1px solid #000;
        }

        .label {
            font-weight: bold;
            width: 30%;
        }

        .value {
            border-bottom: 1px dotted #999;
        }

        .va-middle {
            vertical-align: middle;
        }
    </style>
</head>

<body>

    @php
        // Helper Data Extraction
        $asesmen = $data['asesmen'] ?? null;
        $medis = $asesmen->asesmenMedisAnak ?? null;
        $fisik = $asesmen->asesmenMedisAnakFisik ?? null;
        $dtl = $asesmen->asesmenMedisAnakDtl ?? null;
        $pasien = $data['dataMedis']->pasien ?? null;
        $dokter = $data['dataMedis']->dokter ?? null;

        $tglMasuk = $medis->tanggal ?? null;
        $jamMasuk = $medis->jam ?? null;

        // Logo Logic
        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
        $logoData = @file_get_contents($logoPath);
        $logoBase64 = $logoData ? 'data:image/png;base64,' . base64_encode($logoData) : null;

        // Helper Function untuk Checkbox
        function cb($condition)
        {
            return $condition ? '<span class="cb-symbol">☑</span>' : '<span class="cb-symbol">☐</span>';
        }
    @endphp

    {{-- KOP SURAT --}}
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
                <span class="title-sub">ASESMEN MEDIS ANAK</span>
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

    {{-- 1. DATA MASUK --}}
    <div class="section-title">1. DATA MASUK</div>
    <table>
        <tr>
            <td class="label">Tanggal & Jam Pengisian</td>
            <td class="value">
                : {{ $tglMasuk ? \Carbon\Carbon::parse($tglMasuk)->format('d-m-Y') : '-' }}
                {{ $jamMasuk ? \Carbon\Carbon::parse($jamMasuk)->format('H:i') : '' }}
            </td>
        </tr>
    </table>

    {{-- 2. ANAMNESIS --}}
    <div class="section-title">2. ANAMNESIS</div>
    <table>
        <tr>
            <td class="label">Anamnesis</td>
            <td class="value">: {{ $medis->anamnesis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Keluhan Utama</td>
            <td class="value">: {{ $medis->keluhan_utama ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Riwayat Penyakit Terdahulu</td>
            <td class="value">: {{ $medis->riwayat_penyakit_terdahulu ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Riwayat Penyakit Keluarga</td>
            <td class="value">: {{ $medis->riwayat_penyakit_keluarga ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Keadaan Umum</td>
            <td class="value">: {{ $medis->riwayat_penyakit_sekarang ?? '-' }}</td>
        </tr>
    </table>

    {{-- 3. RIWAYAT OBAT --}}
    <div class="section-title">3. RIWAYAT PENGGUNAAN OBAT</div>
    <table class="bordered-table" style="margin-top: 5px;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th>Nama Obat</th>
                <th>Dosis</th>
                <th>Aturan Pakai</th>
            </tr>
        </thead>
        <tbody>
            @php
                $rawObat = $medis->riwayat_penggunaan_obat ?? [];
                $obatList = is_array($rawObat) ? $rawObat : json_decode($rawObat, true);

                if (!is_array($obatList)) {
                    $obatList = [];
                }
            @endphp

            @forelse($obatList as $obat)
                <tr>
                    <td>
                        {{ $obat['namaObat'] ?? ($obat['nama_obat'] ?? ($obat['nama'] ?? '-')) }}
                    </td>
                    <td>
                        @php
                            $dosis = $obat['dosis'] ?? '';
                            $satuan = $obat['satuan'] ?? '';
                            $dosisLengkap = trim($dosis . ' ' . $satuan);
                        @endphp
                        {{ $dosisLengkap ?: '-' }}
                    </td>
                    <td>
                        @php
                            $aturan = $obat['aturanPakai'] ?? ($obat['aturan_pakai'] ?? ($obat['aturan'] ?? ''));
                            $frekuensi = $obat['frekuensi'] ?? '';
                            $keterangan = $obat['keterangan'] ?? '';

                            if (empty($aturan)) {
                                $parts = [];
                                if (!empty($frekuensi)) {
                                    $parts[] = $frekuensi;
                                }
                                if (!empty($keterangan)) {
                                    $parts[] = $keterangan;
                                }
                                $aturan = implode(' - ', $parts);
                            }
                        @endphp
                        {{ $aturan ?: '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada riwayat penggunaan obat</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- 4. ALERGI --}}
    <div class="section-title">4. RIWAYAT ALERGI</div>
    @php
        $rawAlergi = $asesmen->alergis ?? [];
        $alergiList = is_array($rawAlergi) ? $rawAlergi : json_decode($rawAlergi, true);
        if (!is_array($alergiList)) {
            $alergiList = [];
        }

        if (empty($alergiList) && isset($data['alergiPasien'])) {
            $alergiList = $data['alergiPasien']
                ->map(function ($item) {
                    return [
                        'jenis_alergi' => $item->jenis_alergi,
                        'alergen' => $item->nama_alergi,
                        'reaksi' => $item->reaksi,
                        'tingkat_keparahan' => $item->tingkat_keparahan,
                    ];
                })
                ->toArray();
        }
    @endphp
    @if (empty($alergiList))
        <div>Tidak ada alergi yang diketahui.</div>
    @else
        <table class="bordered-table" style="margin-top: 5px;">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th>Jenis</th>
                    <th>Alergen</th>
                    <th>Reaksi</th>
                    <th>Tingkat Keparahan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alergiList as $al)
                    <tr>
                        <td>{{ $al['jenis_alergi'] ?? ($al['jenis'] ?? '-') }}</td>
                        <td>{{ $al['alergen'] ?? ($al['nama_alergi'] ?? '-') }}</td>
                        <td>{{ $al['reaksi'] ?? '-' }}</td>
                        <td>{{ $al['tingkat_keparahan'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- 5. STATUS PRESENT --}}
    <div class="section-title">5. STATUS PRESENT</div>
    @php
        $rawVS = $medis->vital_sign ?? [];
        $vitalSign = is_array($rawVS) ? $rawVS : json_decode($rawVS, true);
        $gcs = $vitalSign['gcs'] ?? '-';
    @endphp
    <table style="width: 100%;">
        <tr>
            <td width="25%"><strong>Kesadaran</strong></td>
            <td width="25%">: {{ $medis->kesadaran ?? '-' }}</td>
            <td width="25%"><strong>GCS</strong></td>
            <td width="25%">: {{ $gcs }}</td>
        </tr>
        <tr>
            <td><strong>Tekanan Darah</strong></td>
            <td>: {{ $medis->sistole ?? '-' }} / {{ $medis->diastole ?? '-' }} mmHg</td>
            <td><strong>Nadi</strong></td>
            <td>: {{ $medis->nadi ?? '-' }} x/menit</td>
        </tr>
        <tr>
            <td><strong>Respirasi (RR)</strong></td>
            <td>: {{ $medis->rr ?? '-' }} x/menit</td>
            <td><strong>Suhu</strong></td>
            <td>: {{ $medis->suhu ?? '-' }} °C</td>
        </tr>
        <tr>
            <td><strong>Berat Badan</strong></td>
            <td>: {{ $medis->berat_badan ?? '-' }} Kg</td>
            <td><strong>Tinggi Badan</strong></td>
            <td>: {{ $medis->tinggi_badan ?? '-' }} Cm</td>
        </tr>
    </table>

    {{-- 6. PEMERIKSAAN FISIK --}}
    <div class="section-title">6. PEMERIKSAAN FISIK</div>
    <table class="bordered-table" style="font-size: 8pt;">
        <tr>
            <td width="20%"><strong>Kepala</strong></td>
            <td>
                a. Bentuk: {{ $fisik->kepala_bentuk ?? '-' }}<br>
                b. UUB: {{ $fisik->kepala_uub ?? '-' }}<br>
                c. Rambut: {{ $fisik->kepala_rambut ?? '-' }}<br>
                d. Lain: {{ $fisik->kepala_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>2. Mata</strong></td>
            <td>
                {!! cb($fisik->mata_pucat ?? false) !!} Pucat &nbsp;&nbsp;
                {!! cb($fisik->mata_ikterik ?? false) !!} Ikterik <br>
                Pupil:
                {!! cb(($fisik->pupil_isokor ?? '') == 'Isokor') !!} Isokor &nbsp;
                {!! cb(($fisik->pupil_isokor ?? '') == 'Anisokor') !!} Anisokor <br>
                Refleks Cahaya: {{ $fisik->refleks_cahaya ?? '( ... / ... )' }} &nbsp;
                Refleks Kornea: {{ $fisik->refleks_kornea ?? '( ... / ... )' }} <br>
                Lain-lain: {{ $fisik->mata_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>3. Hidung</strong></td>
            <td>
                Nafas cuping hidung:
                {!! cb(($fisik->nafas_cuping ?? 0) == 1) !!} Ya &nbsp;
                {!! cb(($fisik->nafas_cuping ?? 0) == 0) !!} Tidak <br>
                Lain-lain: {{ $fisik->hidung_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>4. Telinga</strong></td>
            <td>Cairan: {{ $fisik->telinga_cairan ?? 0 ? 'Ya' : 'Tidak' }} | Lain: {{ $fisik->telinga_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>5.Mulut</strong></td>
            <td>
                Sianosis: {{ $fisik->mulut_sianosis ?? 0 ? 'Ya' : 'Tidak' }} | Lidah:
                {{ $fisik->mulut_lidah ?? '-' }}<br>
                Tenggorokan: {{ $fisik->mulut_tenggorokan ?? '-' }} | Lain: {{ $fisik->mulut_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>6.Leher</strong></td>
            <td>
                Pembesaran Kelenjar: {{ $fisik->leher_kelenjar ?? 0 ? 'Ya' : 'Tidak' }} | TVJ:
                {{ $fisik->leher_vena ?? 0 ? 'Ya' : 'Tidak' }}<br>
                Lain: {{ $fisik->leher_lain ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>Thoraks</strong></td>
            <td>
                @php
                    $rawTB = $fisik->thoraks_bentuk ?? [];
                    $tb = is_array($rawTB) ? $rawTB : json_decode($rawTB, true);
                    $tb = is_array($tb) ? $tb : [];
                @endphp
                Bentuk: {{ !empty($tb) ? implode(', ', $tb) : '-' }} | Retraksi:
                {{ $fisik->thoraks_retraksi ?? '-' }}<br>
                Jantung HR: {{ $fisik->thoraks_hr ?? '-' }} | Bunyi: {{ $fisik->thoraks_bunyi_jantung ?? '-' }} |
                Murmur: {{ $fisik->thoraks_murmur ?? '-' }}<br>
                Paru RR: {{ $fisik->thoraks_rr ?? '-' }} | Suara Nafas: {{ $fisik->thoraks_suara_nafas ?? '-' }} |
                Tambahan: {{ $fisik->thoraks_suara_tambahan ?? '-' }}<br>
                Merintih: {{ $fisik->thoraks_merintih ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>Abdomen</strong></td>
            <td>
                Distensi: {{ $fisik->abdomen_distensi ?? '-' }} | Bising Usus:
                {{ $fisik->abdomen_bising_usus ?? '-' }}<br>
                Venekasi: {{ $fisik->abdomen_venekasi ?? 0 ? 'Ya' : 'Tidak' }} | Hepar:
                {{ $fisik->abdomen_hepar ?? '-' }} | Lien: {{ $fisik->abdomen_lien ?? '-' }}
            </td>
        </tr>
        <tr>
            <td><strong>Genetalia & Anus</strong></td>
            <td>Genetalia: {{ ucfirst($fisik->genetalia ?? '-') }} | Anus: {{ $fisik->anus_keterangan ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Ekstremitas</strong></td>
            <td>Kapiler: {{ $fisik->kapiler ?? '-' }} | Refleks: {{ $fisik->ekstremitas_refleks ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Kulit</strong></td>
            <td>
                @php
                    $rawKulit = $fisik->kulit ?? [];
                    $kulit = is_array($rawKulit) ? $rawKulit : json_decode($rawKulit, true);
                    $kulit = is_array($kulit) ? $kulit : [];
                @endphp
                {{ !empty($kulit) ? implode(', ', $kulit) : '-' }}
                {{ $fisik->kulit_lainnya ? '(' . $fisik->kulit_lainnya . ')' : '' }}
            </td>
        </tr>
        <tr>
            <td><strong>Kuku</strong></td>
            <td>
                @php
                    $rawKuku = $fisik->kuku ?? [];
                    $kuku = is_array($rawKuku) ? $rawKuku : json_decode($rawKuku, true);
                    $kuku = is_array($kuku) ? $kuku : [];
                @endphp
                {{ !empty($kuku) ? implode(', ', $kuku) : '-' }}
                {{ $fisik->kuku_lainnya ? '(' . $fisik->kuku_lainnya . ')' : '' }}
            </td>
        </tr>
    </table>

    {{-- 7. PENGKAJIAN KHUSUS PEDIATRIK --}}
    <div class="section-title">7. PENGKAJIAN KHUSUS PEDIATRIK (< 5 TAHUN)</div>
            <table class="bordered-table">
                <tr>
                    <td width="30%"><strong>Riwayat Prenatal</strong></td>
                    <td>
                        Lama Kehamilan: {{ $dtl->lama_kehamilan ?? '-' }} bulan/minggu<br>
                        Komplikasi: {{ $dtl->komplikasi ?? 0 ? 'Ya (PEB/DM/HT/PP)' : 'Tidak' }}<br>
                        Masalah Maternal: {{ $dtl->maternal ?? 0 ? 'Ya' : 'Tidak' }}
                        ({{ $dtl->maternal_keterangan ?? '-' }})
                    </td>
                </tr>
                <tr>
                    <td><strong>Riwayat Natal</strong></td>
                    <td>
                        Persalinan (PV/SC/FE/VE): {{ $dtl->persalinan ?? 0 ? 'Ya' : 'Tidak' }}<br>
                        Penyulit Persalinan: {{ $dtl->penyulit_persalinan ?? 0 ? 'Ya' : 'Tidak' }}<br>
                        Lainnya: {{ $dtl->lainnya_sebukan ?? 0 ? 'Ya' : 'Tidak' }}
                        ({{ $dtl->lainnya_keterangan ?? '-' }})
                    </td>
                </tr>
                <tr>
                    <td><strong>Riwayat Post Natal</strong></td>
                    <td>
                        Prematur/Aterm/Post Term: {{ $dtl->prematur_aterm ?? 0 ? 'Ya' : 'Tidak' }}<br>
                        KMK/SMK/BMK: {{ $dtl->kmk_smk_bmk ?? 0 ? 'Ya' : 'Tidak' }}<br>
                        Pasca NICU: {{ $dtl->pasca_nicu ?? 0 ? 'Ya' : 'Tidak' }}
                    </td>
                </tr>
            </table>

            {{-- 8. RIWAYAT IMUNISASI --}}
            <div class="section-title">8. RIWAYAT IMUNISASI</div>
            @php
                $imunisasi = [];
                if (isset($dtl->riwayat_imunisasi)) {
                    $rawImun = $dtl->riwayat_imunisasi;
                    $imunisasi = is_array($rawImun) ? $rawImun : json_decode($rawImun, true);
                }
                $imunisasi = is_array($imunisasi) ? $imunisasi : [];

                function isChecked($val, $arr)
                {
                    return in_array($val, $arr) ? '☑' : '☐';
                }
            @endphp
            <table style="width: 100%; font-size: 8pt;">
                <tr>
                    <td>{{ isChecked('hep_b_ii', $imunisasi) }} Hep B II</td>
                    <td>{{ isChecked('hep_b_iii', $imunisasi) }} Hep B III</td>
                    <td>{{ isChecked('hep_b_iv', $imunisasi) }} Hep B IV</td>
                    <td>{{ isChecked('hep_b_v', $imunisasi) }} Hep B V</td>
                </tr>
                <tr>
                    <td>{{ isChecked('dpt_ii', $imunisasi) }} DPT II</td>
                    <td>{{ isChecked('dpt_iii', $imunisasi) }} DPT III</td>
                    <td>{{ isChecked('bcg', $imunisasi) }} BCG</td>
                    <td></td>
                </tr>
                <tr>
                    <td>{{ isChecked('booster_ii', $imunisasi) }} Booster II</td>
                    <td>{{ isChecked('booster_iii', $imunisasi) }} Booster III</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>{{ isChecked('hib_ii', $imunisasi) }} HiB II</td>
                    <td>{{ isChecked('hib_iii', $imunisasi) }} HiB III</td>
                    <td>{{ isChecked('hib_iv', $imunisasi) }} HiB IV</td>
                    <td></td>
                </tr>
                <tr>
                    <td>{{ isChecked('mmr', $imunisasi) }} MMR</td>
                    <td>{{ isChecked('varilrix', $imunisasi) }} Varilrix</td>
                    <td>{{ isChecked('typhim', $imunisasi) }} Typhim</td>
                    <td></td>
                </tr>
            </table>

            {{-- 9. TUMBUH KEMBANG & DATA LAHIR --}}
            <div class="section-title">9. RIWAYAT TUMBUH KEMBANG</div>
            <table class="bordered-table">
                <tr>
                    <td colspan="2" style="background-color: #f9f9f9;"><strong>Data Kelahiran</strong></td>
                </tr>
                <tr>
                    <td>Lahir Umur Kehamilan: {{ $dtl->lahir_umur_kehamilan ?? '-' }}</td>
                    <td>LK saat lahir: {{ $dtl->lk_saat_lahir ?? '-' }} cm</td>
                </tr>
                <tr>
                    <td>BB saat lahir: {{ $dtl->bb_saat_lahir ?? '-' }} gram</td>
                    <td>TB saat lahir: {{ $dtl->tb_saat_lahir ?? '-' }} cm</td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #f9f9f9;"><strong>Riwayat Perawatan</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        Pernah dirawat: {{ $dtl->pernah_dirawat ?? 0 ? 'Ya' : 'Tidak' }}<br>
                        Tanggal:
                        {{ $dtl->tanggal_dirawat ?? false ? \Carbon\Carbon::parse($dtl->tanggal_dirawat)->format('d-m-Y') : '-' }}
                        | Jam: {{ $dtl->jam_dirawat ?? '-' }}<br>
                        Keterangan (Jaundice/RDS/PJB): {{ $dtl->jaundice_rds_pjb ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #f9f9f9;"><strong>Nutrisi</strong></td>
                </tr>
                <tr>
                    <td colspan="2">
                        ASI sampai: {{ $dtl->asi_sampai_umur ?? '-' }} | Sufor:
                        {{ $dtl->pemberian_susu_formula ?? '-' }} |
                        MPASI: {{ $dtl->makanan_tambahan_umur ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="background-color: #f9f9f9;"><strong>Milestone Motorik (Bulan)</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Tengkurap: {{ $dtl->tengkurap_bulan ?? '-' }} | Merangkak:
                        {{ $dtl->merangkak_bulan ?? '-' }} | Duduk:
                        {{ $dtl->duduk_bulan ?? '-' }} | Berdiri: {{ $dtl->berdiri_bulan ?? '-' }}<br>
                        Lainnya: {{ $dtl->milestone_lainnya ?? '-' }}
                    </td>
                </tr>
            </table>

            {{-- 10. PEMERIKSAAN PENUNJANG --}}
            <div class="section-title">10. HASIL PEMERIKSAAN PENUNJANG</div>
            <table class="bordered-table">
                <tr>
                    <td width="30%"><strong>Laboratorium</strong></td>
                    <td>{{ $dtl->hasil_laboratorium ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Radiologi</strong></td>
                    <td>{{ $dtl->hasil_radiologi ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Lainnya</strong></td>
                    <td>{{ $dtl->hasil_lainnya ?? '-' }}</td>
                </tr>
            </table>

            {{-- 11. DIAGNOSIS --}}
            {{-- 11. DIAGNOSIS --}}
            <div class="section-title">11. DIAGNOSIS</div>
            @php
                // Helper untuk memformat diagnosis
                function formatDiagnosis($raw)
                {
                    if (empty($raw)) {
                        return '-';
                    }

                    if (is_array($raw)) {
                        return implode(', ', $raw);
                    }

                    if (is_string($raw)) {
                        $decoded = json_decode($raw, true);

                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            return implode(', ', $decoded);
                        }
                    }

                    return $raw;
                }

                $strDB = formatDiagnosis($dtl->diagnosis_banding ?? null);
                $strDK = formatDiagnosis($dtl->diagnosis_kerja ?? null);
            @endphp
            <table>
                <tr>
                    <td class="label">Diagnosis Banding</td>
                    <td class="value">{{ $strDB }}</td>
                </tr>
                <tr>
                    <td class="label">Diagnosis Kerja</td>
                    <td class="value">{{ $strDK }}</td>
                </tr>
            </table>

            {{-- 12. RENCANA PENATALAKSANAAN --}}
            <div class="section-title">12. RENCANA PENATALAKSANAAN & PENGOBATAN</div>
            <table>
                <tr>
                    <td class="label">Rencana Pengobatan</td>
                    <td class="value">{{ $dtl->rencana_pengobatan ?? '-' }}</td>
                </tr>
            </table>
            {{-- 12. PROGNOSIS --}}
            <div class="section-title">12. PROGNOSIS</div>
            @php

                $kodePrognosis = $dtl->paru_prognosis ?? '-';
                $prognosisText = $kodePrognosis;

                if (!empty($data['satsetPrognosis']) && !empty($kodePrognosis)) {
                    $found = collect($data['satsetPrognosis'])->firstWhere('prognosis_id', $kodePrognosis);

                    if ($found) {
                        $prognosisText = $found->value;
                    }
                }
            @endphp
            <table>
                <tr>
                    <td class="label">Prognosis</td>
                    {{-- Tampilkan hasil pencarian teksnya --}}
                    <td class="value">{{ $prognosisText }}</td>
                </tr>
            </table>


            {{-- 14. DISCHARGE PLANNING --}}
            <div class="section-title">14. PERENCANAAN PULANG (DISCHARGE PLANNING)</div>
            <table class="bordered-table">
                <tr>
                    <td width="70%">Hambatan Mobilitas</td>
                    <td width="30%">
                        {{ isset($dtl->hambatan_mobilisasi) ? ($dtl->hambatan_mobilisasi == '1' ? 'Ya' : 'Tidak') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Pelayanan Medis Berkelanjutan</td>
                    <td>{{ ucfirst($dtl->penggunaan_media_berkelanjutan ?? '-') }}</td>
                </tr>
                <tr>
                    <td>Ketergantungan Aktivitas Harian</td>
                    <td>{{ ucfirst($dtl->ketergantungan_aktivitas ?? '-') }}</td>
                </tr>
                <tr>
                    <td>Rencana Pulang Khusus</td>
                    <td>{{ $dtl->rencana_pulang_khusus ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Rencana Lama Perawatan</td>
                    <td>{{ $dtl->rencana_lama_perawatan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Rencana Tanggal Pulang</td>
                    <td>
                        {{ $dtl->rencana_tgl_pulang ?? false ? \Carbon\Carbon::parse($dtl->rencana_tgl_pulang)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Kesimpulan</strong></td>
                    <td><strong>{{ $dtl->kesimpulan_planing ?? '-' }}</strong></td>
                </tr>
            </table>

            {{-- TANDA TANGAN --}}
            <table style="width: 100%; margin-top: 30px;">
                <tr>
                    <td width="60%"></td>
                    <td width="40%" style="text-align: center;">
                        Langsa,
                        {{ $tglMasuk ? \Carbon\Carbon::parse($tglMasuk)->translatedFormat('d F Y') : date('d F Y') }}
                        <br>
                        Dokter Penanggung Jawab Pelayanan (DPJP)
                        <br>
                        <img src="{{ generateQrCode(($asesmen->user->karyawan->gelar_depan ?? '') . ' ' . str()->title($asesmen->user->karyawan->nama ?? '') . ' ' . ($asesmen->user->karyawan->gelar_belakang ?? ''), 100, 'svg_datauri') }}"
                                    alt="QR Petugas">
                        <br>
                        {{ ($asesmen->user->karyawan->gelar_depan ?? '') . ' ' . str()->title($asesmen->user->karyawan->nama ?? '') . ' ' . ($asesmen->user->karyawan->gelar_belakang ?? '') }}
                    </td>
                </tr>
            </table>

</body>

</html>
