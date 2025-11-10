<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Medis Hemodialisa - {{ $dataMedis->pasien->nama ?? '' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9pt;
            color: #333;
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
            position: relative;
            padding: 0;
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

        .hd-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        .hd-text {
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
            padding: 4px 6px;
            font-size: 9pt;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 120px;
        }

        .section {
            margin-top: 15px;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            background-color: #097dd6;
            color: white;
            padding: 5px;
            margin-bottom: 5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 4px 2px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }

        .data-table td:nth-child(1) {
            width: 200px;
            font-weight: 500;
        }

        .data-table td:nth-child(2) {
            width: 10px;
        }

        .data-table td:nth-child(3) {
            color: #000;
        }

        /* Pemeriksaan fisik (spasi antar baris) */
        .fisik-table {
            width: 100%;
            /* <-- TAMBAHKAN INI */
        }

        .fisik-table td {
            border: none;
            padding: 2px 4px;
        }

        .signature-block {
            margin-top: 40px;
            width: 100%;
            clear: both;
            page-break-inside: avoid;
        }

        .sig-left {
            float: left;
            width: 45%;
            text-align: center;
        }

        .sig-right {
            float: right;
            width: 45%;
            text-align: center;
        }

        .sig-name {
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @php
        // Inisialisasi variabel asesmen (jika null)
        $fisik = $asesmen->fisik;
        $penunjang = $asesmen->penunjang;
        $deskripsi = $asesmen->deskripsi;
        $evaluasi = $asesmen->evaluasi;

        // Diagnosis
        $diag_banding = $evaluasi ? json_decode($evaluasi->diagnosis_banding) : [];
        $diag_kerja = $evaluasi ? json_decode($evaluasi->diagnosis_kerja) : [];
    @endphp

    <header>
        <table class="header-table">
            <tr>
                <td class="td-left">
                    <table class="brand-table">
                        <tr>
                            <td class="va-middle"><img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}"
                                    alt="Logo" class="brand-logo"></td>
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
                    <span class="title-sub">HEMODIALISA (HD)</span>
                </td>
                <td class="td-right">
                    <div class="hd-box"><span class="hd-text">HEMODIALISA</span></div>
                </td>
            </tr>
        </table>
    </header>

    <table class="patient-table">
        <tr>
            <th>No. RM</th>
            <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
            <th>Tgl. Lahir</th>
            <td>{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d M Y') : '-' }}
            </td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $dataMedis->pasien->nama ?? '-' }}</td>
            <th>Umur</th>
            <td>{{ $dataMedis->pasien->umur ?? '-' }} Tahun</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $dataMedis->pasien->jns_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <th>Tgl. Asesmen</th>
            <td>{{ $asesmen->waktu_asesmen ? \Carbon\Carbon::parse($asesmen->waktu_asesmen)->format('d M Y H:i') : '-' }}
            </td>
        </tr>
    </table>

    <div class="section">
        <div class="section-title">1. ANAMNESIS</div>
        <table class="data-table">
            <tr>
                <td>Anamnesis</td>
                <td>:</td>
                <td>{!! nl2br(e($fisik->anamnesis ?? '-')) !!}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">2. PEMERIKSAAN FISIK (TANDA VITAL)</div>
        <table class="data-table">
            <tr>
                <td>Tekanan Darah</td>
                <td>:</td>
                <td>{{ $fisik->sistole ?? '-' }} / {{ $fisik->diastole ?? '-' }} mmHg</td>
            </tr>
            <tr>
                <td>Nadi</td>
                <td>:</td>
                <td>{{ $fisik->nadi ?? '-' }} x/menit</td>
            </tr>
            <tr>
                <td>Nafas</td>
                <td>:</td>
                <td>{{ $fisik->nafas ?? '-' }} x/menit</td>
            </tr>
            <tr>
                <td>Suhu</td>
                <td>:</td>
                <td>{{ $fisik->suhu ?? '-' }} °C</td>
            </tr>
            <tr>
                <td>Saturasi Oksigen (Tanpa O2)</td>
                <td>:</td>
                <td>{{ $fisik->so_tb_o2 ?? '-' }} %</td>
            </tr>
            <tr>
                <td>Saturasi Oksigen (Dengan O2)</td>
                <td>:</td>
                <td>{{ $fisik->so_db_o2 ?? '-' }} %</td>
            </tr>
            <tr>
                <td>AVPU</td>
                <td>:</td>
                <td>{{ $fisik->avpu ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tinggi Badan</td>
                <td>:</td>
                <td>{{ $fisik->tinggi_badan ?? '-' }} cm</td>
            </tr>
            <tr>
                <td>Berat Badan</td>
                <td>:</td>
                <td>{{ $fisik->berat_badan ?? '-' }} Kg</td>
            </tr>
            <tr>
                <td>Index Massa Tubuh (IMT)</td>
                <td>:</td>
                <td>{{ $fisik->imt ?? '-' }}</td>
            </tr>
        </table>
    </div>
    <div class="section">
        <div class="section-title">3. PEMERIKSAAN FISIK (STATUS GENERALIS)</div>

        @php
            $pemeriksaanFisikItems = $asesmen->pemeriksaanFisik ?? collect();
            $totalItems = $pemeriksaanFisikItems->count();
            // Hitung jumlah baris yang diperlukan untuk kolom kiri
            $rows = ceil($totalItems / 2);
        @endphp

        <table class="fisik-table">
            @for ($i = 0; $i < $rows; $i++)
                <tr>
                    @if (isset($pemeriksaanFisikItems[$i]))
                        @php $itemKiri = $pemeriksaanFisikItems[$i]; @endphp
                        <td class="w-20">{{ $itemKiri->itemFisik->nama ?? '-' }}</td>
                        <td class="w-25">:
                            {{ (int) $itemKiri->is_normal === 1 ? 'Normal' : $itemKiri->keterangan ?? '-' }}</td>
                    @else
                        <td class="w-20"></td>
                        <td class="w-25"></td>
                    @endif

                    <td class="w-10"></td>

                    @php $kananIndex = $i + $rows; @endphp
                    @if (isset($pemeriksaanFisikItems[$kananIndex]))
                        @php $itemKanan = $pemeriksaanFisikItems[$kananIndex]; @endphp
                        <td class="w-20">{{ $itemKanan->itemFisik->nama ?? '-' }}</td>
                        <td class="w-25">:
                            {{ (int) $itemKanan->is_normal === 1 ? 'Normal' : $itemKanan->keterangan ?? '-' }}</td>
                    @else
                        <td class="w-20"></td>
                        <td class="w-25"></td>
                    @endif
                </tr>
            @endfor
        </table>
    </div>
    <div class="section">
        <div class="section-title">4. RIWAYAT KESEHATAN & TERAPI</div>
        <table class="data-table">
            <tr>
                <td>Status Nyeri (Skala 0-10)</td>
                <td>:</td>
                <td>{{ $fisik->skala_nyeri ?? '-' }}</td>
            </tr>
            <tr>
                <td>Riwayat Penyakit Sekarang</td>
                <td>:</td>
                <td>
                    @if ($fisik && $fisik->penyakit_sekarang)
                        @foreach ($fisik->penyakit_sekarang as $p)
                            - {{ $p }} <br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Riwayat Penyakit Dahulu</td>
                <td>:</td>
                <td>
                    @if ($fisik && $fisik->penyakit_dahulu)
                        @foreach ($fisik->penyakit_dahulu as $p)
                            - {{ $p }} <br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Efek Samping Yang Dialami</td>
                <td>:</td>
                <td>{{ $fisik->efek_samping ?? '-' }}</td>
            </tr>
            <tr>
                <td>Terapi Obat dan Injeksi</td>
                <td>:</td>
                <td>
                    @if ($fisik && $fisik->terapi_obat)
                        @foreach ($fisik->terapi_obat as $obat_json)
                            @php $obat = json_decode($obat_json); @endphp
                            - {{ $obat->nama_obat ?? '' }} (Dosis: {{ $obat->dosis ?? '' }}, Waktu:
                            {{ $obat->waktu ?? '' }}) <br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">5. HASIL PEMERIKSAAN PENUNJANG</div>
        <table class="data-table">
            <tr>
                <td>HB / HbsAg / Anti HCV / Anti HIV</td>
                <td>:</td>
                <td>{{ $penunjang->hb ?? '-' }} / {{ $penunjang->hbsag ?? '-' }} / {{ $penunjang->hcv ?? '-' }} /
                    {{ $penunjang->hiv ?? '-' }}</td>
            </tr>
            <tr>
                <td>Ureum / Creatinin / Asam Urat</td>
                <td>:</td>
                <td>{{ $penunjang->ureum ?? '-' }} / {{ $penunjang->creatinin ?? '-' }} /
                    {{ $penunjang->asam_urat ?? '-' }}</td>
            </tr>
            <tr>
                <td>Natrium / Kalium / Calcium</td>
                <td>:</td>
                <td>{{ $penunjang->natrium ?? '-' }} / {{ $penunjang->kalium ?? '-' }} /
                    {{ $penunjang->calcium ?? '-' }}</td>
            </tr>
            <tr>
                <td>Gula Darah / Gol. Darah</td>
                <td>:</td>
                <td>{{ $penunjang->gula_darah ?? '-' }} / {{ $penunjang->gol_darah ?? '-' }}</td>
            </tr>
            <tr>
                <td>EKG / Rongent / USG</td>
                <td>:</td>
                <td>{{ $penunjang->ekg ?? '-' }} / {{ $penunjang->rongent ?? '-' }} / {{ $penunjang->usg ?? '-' }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">6. DESKRIPSI HEMODIALISIS</div>
        <table class="data-table">
            <tr>
                <td>Jenis Hemodialisis</td>
                <td>:</td>
                <td>{{ $deskripsi->jenis_hd ?? '-' }}</td>
            </tr>
            <tr>
                <td>Lama HD / Akses Vaskular</td>
                <td>:</td>
                <td>{{ $deskripsi->lama_hd ?? '-' }} jam / {{ $deskripsi->akses_vaskular ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kec. Darah (QB) / Kec. Dialisat (QD)</td>
                <td>:</td>
                <td>{{ $deskripsi->qb ?? '-' }} ml/menit / {{ $deskripsi->qd ?? '-' }} ml/menit</td>
            </tr>
            <tr>
                <td>UF Goal</td>
                <td>:</td>
                <td>{{ $deskripsi->uf_goal ?? '-' }} ml</td>
            </tr>
            <tr>
                <td>Heparinisasi Dosis Awal</td>
                <td>:</td>
                <td>{{ $deskripsi->dosis_awal ?? '-' }} IU</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">7. DIAGNOSIS & EVALUASI</div>
        <table class="data-table">
            <tr>
                <td>Diagnosis Banding</td>
                <td>:</td>
                <td>
                    @if (count($diag_banding) > 0)
                        @foreach ($diag_banding as $diag)
                            - {{ $diag }}<br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Diagnosis Kerja</td>
                <td>:</td>
                <td>
                    @if (count($diag_kerja) > 0)
                        @foreach ($diag_kerja as $diag)
                            - {{ $diag }}<br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Evaluasi Medis</td>
                <td>:</td>
                <td>{!! nl2br(e($evaluasi->evaluasi_medis ?? '-')) !!}</td>
            </tr>
        </table>
    </div>

    <div class="signature-block">
        <div class="sig-right">
            Dokter DPJP
            <div class="sig-name">
                ({{ $evaluasi->dokterDpjp->nama_lengkap ?? '..............................' }})
            </div>
        </div>
    </div>

</body>

</html>
