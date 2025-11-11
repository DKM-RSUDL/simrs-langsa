<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Keperawatan Hemodialisa - {{ $dataMedis->pasien->nama ?? '' }}</title>
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

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            margin: 0;
            padding: 0;
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
            padding: 5px 7px;
            font-size: 10pt;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 130px;
        }

        .section {
            margin-top: 15px;
            page-break-inside: avoid;
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
            padding: 5px 3px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }

        .data-table td:nth-child(1) {
            width: 220px;
            font-weight: 500;
        }

        .data-table td:nth-child(2) {
            width: 10px;
        }

        .data-table td:nth-child(3) {
            color: #000;
        }

        .fisik-table {
            width: 100%;
        }

        .fisik-table td {
            border: none;
            padding: 2px 4px;
        }

        .w-10 {
            width: 10%;
        }

        .w-20 {
            width: 20%;
        }

        .w-25 {
            width: 25%;
        }

        .obs-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
            margin-top: 5px;
        }

        .obs-table th,
        .obs-table td {
            border: 1px solid #999;
            padding: 4px;
        }

        .obs-table th {
            background-color: #f2f2f2;
        }

        .alergi-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .alergi-table th,
        .alergi-table td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
        }

        .alergi-table th {
            background-color: #f2f2f2;
        }

        .signature-block {
            margin-top: 50px;
            width: 100%;
            clear: both;
            page-break-inside: avoid;
        }

        .sig-name {
            margin-top: 0;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    @php
        // Inisialisasi variabel agar aman
        $kep = $asesmen->keperawatan;
        $fisik = $asesmen->keperawatanPemeriksaanFisik;
        $pempen = $asesmen->keperawatanPempen;
        $gizi = $asesmen->keperawatanStatusGizi;
        $risikoJatuh = $asesmen->keperawatanRisikoJatuh;
        $psikososial = $asesmen->keperawatanStatusPsikososial;
        $preekripsi = $asesmen->keperawatanMonitoringPreekripsi;
        $heparinisasi = $asesmen->keperawatanMonitoringHeparinisasi;
        $tindakanKep = $asesmen->keperawatanMonitoringTindakan;
        $intrahd = $asesmen->keperawatanMonitoringIntrahd;
        $posthd = $asesmen->keperawatanMonitoringPosthd;

        // Alergi dari RmeHdAsesmenKeperawatan (bukan RmeAlergiPasien)
        $alergiData = $kep ? json_decode($kep->alergi, true) : [];
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
                    <span class="title-main">ASESMEN KEPERAWATAN</span>
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
                <td>{!! nl2br(e($kep->anamnesis ?? '-')) !!}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">2.TANDA VITAL</div>
        @if ($fisik)
            <table class="data-table">
                <tr>
                    <td>Tekanan Darah</td>
                    <td>:</td>
                    <td>{{ $fisik->fisik_sistole ?? '-' }} / {{ $fisik->fisik_diastole ?? '-' }} mmHg</td>
                </tr>
                <tr>
                    <td>Nadi / Nafas / Suhu</td>
                    <td>:</td>
                    <td>{{ $fisik->fisik_nadi ?? '-' }} x/menit / {{ $fisik->fisik_nafas ?? '-' }} x/menit /
                        {{ $fisik->fisik_suhu ?? '-' }} °C</td>
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
                    <td>
                        @switch($fisik->avpu)
                            @case('0')
                                Sadar Baik/Alert: 0
                            @break

                            @case('1')
                                Berespon dengan kata-kata/Voice: 1
                            @break

                            @case('2')
                                Hanya berespons jika dirangsang nyeri/Pain: 2
                            @break

                            @case('3')
                                Pasien tidak sadar/Unresponsive: 3
                            @break

                            @case('4')
                                Gelisah atau bingung: 4
                            @break

                            @case('5')
                                Acute Confusional States: 5
                            @break

                            @default
                                <!-- Jika nilainya null atau tidak ada di daftar, tampilkan strip -->
                                {{ $fisik->avpu ?? '-' }}
                        @endswitch
                    </td>
                </tr>
                <tr>
                    <td>Edema / Konjungtiva / Dehidrasi</td>
                    <td>:</td>
                    <td>{{ $fisik->edema == '1' ? 'Ya' : 'Tidak' }} /
                        {{ $fisik->konjungtiva == '1' ? 'Anemis' : 'Tidak Anemis' }} /
                        {{ $fisik->dehidrasi == '1' ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="font-weight: bold; background-color: #f9f9f9; padding-top: 10px;">
                        Antropometri</td>
                </tr>
                <tr>
                    <td>Tinggi Badan / Berat Badan</td>
                    <td>:</td>
                    <td>{{ $fisik->tinggi_badan ?? '-' }} cm / {{ $fisik->berat_badan ?? '-' }} Kg</td>
                </tr>
                <tr>
                    <td>Index Massa Tubuh (IMT)</td>
                    <td>:</td>
                    <td>{{ $fisik->imt ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Luas Permukaan Tubuh (LPT)</td>
                    <td>:</td>
                    <td>{{ $fisik->lpt ?? '-' }}</td>
                </tr>
            </table>
        @else
            <p>Tidak ada data.</p>pemeriksaan fisik
        @endif
    </div>

    <div class="section">
        @php
            // 1. Dapatkan MASTER LIST (pastikan dikirim dari controller)
            //    Gunakan ->values() untuk memastikan key-nya 0, 1, 2, ...
            $masterItemList = ($itemFisik ?? collect())->values();

            // 2. Dapatkan data YANG DISIMPAN untuk asesmen ini
            $savedItems = $asesmen->pemeriksaanFisik ?? collect();

            // 3. Hitung jumlah baris berdasarkan MASTER LIST
            $totalItems = $masterItemList->count();
            $rows = ceil($totalItems / 2);
        @endphp

        <table class="fisik-table" style="width: 100%;">
            <tr>
                <td colspan="5" style="font-weight: bold; background-color: #f9f9f9;">Pemeriksaan Fisik</td>
            </tr>

            @for ($i = 0; $i < $rows; $i++)
                <tr>
                    @php
                        // --- Item Kolom Kiri ---
                        // Ambil item dari MASTER LIST
                        $itemKiri = $masterItemList->get($i);

                        // Cari data yang tersimpan:
                        // "Cari di $savedItems di mana 'item_fisik_id' sama dengan ID master list ($itemKiri->id)"
                        $savedKiri = $itemKiri ? $savedItems->firstWhere('id_item_fisik', $itemKiri->id) : null;
                    @endphp

                    @if ($itemKiri)
                        <td class="w-20" style="width: 20%;">{{ $itemKiri->nama ?? '-' }}</td>
                        <td class="w-25" style="width: 25%;">:
                            @if ($savedKiri)
                                {{ (int) $savedKiri->is_normal === 1 ? 'Normal' : $savedKiri->keterangan ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                    @else
                        <td class="w-20" style="width: 20%;"></td>
                        <td class="w-25" style="width: 25%;"></td>
                    @endif

                    <td class="w-10" style="width: 10%;"></td>

                    @php
                        // --- Item Kolom Kanan ---
                        $kananIndex = $i + $rows;
                        $itemKanan = $masterItemList->get($kananIndex);

                        // Cari data yang tersimpan
                        $savedKanan = $itemKanan ? $savedItems->firstWhere('id_item_fisik', $itemKanan->id) : null;
                    @endphp

                    @if ($itemKanan)
                        <td class="w-20" style="width: 20%;">{{ $itemKanan->nama ?? '-' }}</td>
                        <td class="w-25" style="width: 25%;">:
                            @if ($savedKanan)
                                {{ (int) $savedKanan->is_normal === 1 ? 'Normal' : $savedKanan->keterangan ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                    @else
                        <td class="w-20" style="width: 20%;"></td>
                        <td class="w-25" style="width: 25%;"></td>
                    @endif
                </tr>
            @endfor
        </table>
    </div>

    <div class="section">
        <div class="section-title">3. STATUS NYERI</div>
        <table class="data-table" style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%; vertical-align: top; border-right: 1px solid #ccc; padding: 5px;">
                    <b>Jenis Skala Nyeri:</b> Scale NRS, VAS, VRS
                    <br>
                    <b>Nilai Skala Nyeri:</b> {{ $kep->status_skala_nyeri ?? '-' }}
                    <br><br>
                    <img src="{{ public_path('assets/img/asesmen/numerik.png') }}" alt="Numeric Scale"
                        style="width: 100%;">
                </td>
                <td style="width: 50%; vertical-align: top; padding: 5px;">
                    <b>Wong Baker Faces Scale:</b>
                    <br><br>
                    <img src="{{ public_path('assets/img/asesmen/asesmen.jpeg') }}" alt="Wong Baker Scale"
                        style="width: 100%;">
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">4. RIWAYAT KESEHATAN</div>
        @if ($kep)
            <table class="data-table">
                <tr>
                    <td>Gagal Ginjal Stadium</td>
                    <td>:</td>
                    <td>{{ $kep->gagal_ginjal_stadium ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jenis Gagal Ginjal</td>
                    <td>:</td>
                    <td>{{ $kep->jenis_gagal_ginjal ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Lama Menjalani HD</td>
                    <td>:</td>
                    <td>{{ $kep->lama_menjalani_hd ?? '-' }} {{ $kep->lama_menjalani_hd_unit ?? '' }}</td>
                </tr>
                <tr>
                    <td>Jadwal HD Rutin</td>
                    <td>:</td>
                    <td>{{ $kep->jadwal_hd_rutin ?? '-' }} / Minggu</td>
                </tr>
                <tr>
                    <td>Sesak Nafas / Nyeri Dada</td>
                    <td>:</td>
                    <td>{{ $kep->sesak_nafas ?? '-' }}</td>
                </tr>
            </table>
        @else
            <p>Tidak ada data.</p>
        @endif
    </div>
    <div class="section">
        <div class="section-title">5. PEMERIKSAAN PENUNJANG</div>
        @if ($pempen)
            <table class="data-table">
                <tr>
                    <td colspan="3" style="font-weight: bold; background-color: #f9f9f9;">Pre Hemodialisis</td>
                </tr>
                <tr>
                    <td>EKG / Rongent / USG / Dll</td>
                    <td>:</td>
                    <td>{{ $pempen->pre_ekg ?? '-' }} / {{ $pempen->pre_rontgent ?? '-' }} /
                        {{ $pempen->pre_usg ?? '-' }} / {{ $pempen->pre_dll ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="3" style="font-weight: bold; background-color: #f9f9f9;">Post Hemodialisis</td>
                </tr>
                <tr>
                    <td>EKG / Rongent / USG / Dll</td>
                    <td>:</td>
                    <td>{{ $pempen->post_ekg ?? '-' }} / {{ $pempen->post_rontgent ?? '-' }} /
                        {{ $pempen->post_usg ?? '-' }} / {{ $pempen->post_dll ?? '-' }}</td>
                </tr>
            </table>
        @else
            <p>Tidak ada data.</p>
        @endif
    </div>

    <div class="section">
        <div class="section-title">6. ALERGI</div>
        <table class="alergi-table">
            <thead>
                <tr>
                    <th>Alergen (Nama Alergi)</th>
                    <th>Reaksi</th>
                    <th>Severe (Tingkat Keparahan)</th>
                </tr>
            </thead>
            <tbody>
                @if (is_array($alergiData) && count($alergiData) > 0)
                    @foreach ($alergiData as $alergi)
                        <tr>
                            <td>{{ $alergi['alergen'] ?? '-' }}</td>
                            <td>{{ $alergi['reaksi'] ?? '-' }}</td>
                            <td>{{ $alergi['severe'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" style="text-align: center;">Tidak ada data alergi</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>



    <div class="section">
        <div class="section-title">7. STATUS GIZI</div>
        @if ($gizi)
            <table class="data-table">
                <tr>
                    <td>Tanggal Pengkajian</td>
                    <td>:</td>
                    <td>{{ $gizi->gizi_tanggal_pengkajian ? \Carbon\Carbon::parse($gizi->gizi_tanggal_pengkajian)->format('d M Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Skore MIS</td>
                    <td>:</td>
                    <td>{{ $gizi->gizi_skore_mis ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Kesimpulan</td>
                    <td>:</td>
                    <td>{{ $gizi->gizi_kesimpulan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Rencana Pengkajian Ulang MIS</td>
                    <td>:</td>
                    <td>{{ $gizi->gizi_rencana_pengkajian ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Rekomendasi</td>
                    <td>:</td>
                    <td>{{ $gizi->gizi_rekomendasi ?? '-' }}</td>
                </tr>
            </table>
        @else
            <p>Tidak ada data.</p>
        @endif
    </div>

    <div class="section">
        <div class="section-title">8. RISIKO JATUH (SKALA MORSE)</div>
        @if ($risikoJatuh)
            <table class="data-table">
                <tr>
                    <td>Riwayat Jatuh</td>
                    <td>:</td>
                    <td>{{ $risikoJatuh->riwayat_jatuh ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Diagnosa Sekunder > 1</td>
                    <td>:</td>
                    <td>{{ $risikoJatuh->diagnosa_sekunder ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alat Bantu Jalan</td>
                    <td>:</td>
                    <td>{{ $risikoJatuh->alat_bantu ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Terpasang Infus</td>
                    <td>:</td>
                    <td>{{ $risikoJatuh->infus ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Cara Berjalan</td>
                    <td>:</td>
                    <td>{{ $risikoJatuh->cara_berjalan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Status Mental</td>
                    <td>:</td>
                    <td>{{ $risikoJatuh->status_mental ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background-color: #f9f9f9;">Total Skor</td>
                    <td style="font-weight: bold; background-color: #f9f9f9;">:</td>
                    <td style="font-weight: bold; background-color: #f9f9f9;">
                        {{ $risikoJatuh->risiko_jatuh_skor ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; background-color: #f9f9f9;">Kesimpulan</td>
                    <td style="font-weight: bold; background-color: #f9f9f9;">:</td>
                    <td style="font-weight: bold; background-color: #f9f9f9;">
                        {{ $risikoJatuh->risiko_jatuh_kesimpulan ?? '-' }}</td>
                </tr>
            </table>
        @else
            <p>Tidak ada data.</p>
        @endif
    </div>

    <div class="section">
        <div class="section-title">9. STATUS PSIKOSOSIAL</div>
        @if ($psikososial)
            <table class="data-table">
                <tr>
                    <td>Tanggal Pengkajian</td>
                    <td>:</td>
                    <td>{{ $psikososial->tanggal_pengkajian_psiko ? \Carbon\Carbon::parse($psikososial->tanggal_pengkajian_psiko)->format('d M Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Kendala Komunikasi</td>
                    <td>:</td>
                    <td>{{ $psikososial->kendala_komunikasi ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Yang Merawat di Rumah</td>
                    <td>:</td>
                    <td>{{ $psikososial->yang_merawat ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Kondisi Psikologis</td>
                    <td>:</td>
                    <td>{{ $psikososial->kondisi_psikologis ? implode(', ', json_decode($psikososial->kondisi_psikologis_json, true) ?? []) : '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Kepatuhan Pelayanan</td>
                    <td>:</td>
                    <td>{{ $psikososial->kepatuhan_layanan ?? '-' }}</td>
                </tr>
            </table>
        @else
        @endif
    </div>

    <div class="section">
        <div class="section-title">10. MONITORING HEMODIALISIS</div>

        <p style="font-weight: bold; margin-top: 5px; background-color: #f9f9f9; padding: 3px;">Preskripsi Hemodialisis:
        </p>
        @if ($preekripsi)
            <table class="data-table" style="margin-left: 10px;">
                <tr>
                    <td colspan="3" style="font-weight: bold;">Inisiasi:</td>
                </tr>
                <tr>
                    <td>HD Ke</td>
                    <td>:</td>
                    <td>{{ $preekripsi->inisiasi_hd_ke ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nomor Mesin</td>
                    <td>:</td>
                    <td>{{ $preekripsi->inisiasi_nomor_mesin ?? '-' }}</td>
                </tr>
                <tr>
                    <td>BB HD Lalu</td>
                    <td>:</td>
                    <td>{{ $preekripsi->inisiasi_bb_hd_lalu ?? '-' }}Kg</td>
                </tr>
                <tr>
                    <td>Tekanan Vena</td>
                    <td>:</td>
                    <td>{{ $preekripsi->inisiasi_tekanan_vena ?? '-' }} ml/mnt</td>
                </tr>
                <tr>
                    <td>Lama HD</td>
                    <td>:</td>
                    <td>
                        {{ $preekripsi->inisiasi_lama_hd ?? '-' }} Jam</td>
                </tr>
                <tr>
                    <td>Program Profiling</td>
                    <td>:</td>
                    <td>
                        UF: {{ $preekripsi->inisiasi_uf_profiling_detail ?? '-' }} |
                        Bicarbonat: {{ $preekripsi->inisiasi_bicarbonat_profiling_detail ?? '-' }} |
                        Na: {{ $preekripsi->inisiasi_na_profiling_detail ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-weight: bold;">Akut:</td>
                </tr>
                <tr>
                    <td>Type Dializer</td>
                    <td>:</td>
                    <td>{{ $preekripsi->akut_type_dializer ?? '-' }}</td>
                </tr>
                <tr>
                    <td>UF Goal</td>
                    <td>:</td>
                    <td>{{ $preekripsi->akut_uf_goal ?? '-' }} </td>
                </tr>
                <tr>
                    <td>BB Pre HD</td>
                    <td>:</td>
                    <td>{{ $preekripsi->akut_bb_pre_hd ?? '-' }} Kg</td>
                </tr>
                <tr>
                    <td>Tekanan Arteri</td>
                    <td>:</td>
                    <td>{{ $preekripsi->akut_tekanan_arteri ?? '-' }} ml/mnt</td>
                </tr>
                <tr>
                    <td>ISO UF</td>
                    <td>:</td>
                    <td>{{ $preekripsi->akut_laju_uf ?? '-' }} ml </td>
                </tr>
                <tr>
                    <td>Lama ISO UF</td>
                    <td>:</td>
                    <td>{{ $preekripsi->akut_lama_laju_uf ?? '-' }} jam</td>
                </tr>
                <tr>
                    <td colspan="3" style="font-weight: bold;">Rutin:</td>
                </tr>
                <tr>
                    <td>N/R Ke / BB Kering / BB Post HD / TMP</td>
                    <td>:</td>
                    <td>{{ $preekripsi->rutin_nr_ke ?? '-' }} / {{ $preekripsi->rutin_bb_kering ?? '-' }} Kg /
                        {{ $preekripsi->rutin_bb_post_hd ?? '-' }} Kg / {{ $preekripsi->rutin_tmp ?? '-' }} mmHg</td>
                </tr>
                <tr>
                    <td>Vaskular Aksesbilling</td>
                    <td>:</td>
                    <td>
                        AV Shunt: {{ $preekripsi->rutin_av_shunt_detail ?? '-' }} |
                        CDL: {{ $preekripsi->rutin_cdl_detail ?? '-' }} |
                        Femoral: {{ $preekripsi->rutin_femoral_detail ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-weight: bold;">Pre Op:</td>
                </tr>
                <tr>
                    <td>Dialisat / Bicarbonat</td>
                    <td>:</td>
                    <td>{{ $preekripsi->preop_dialisat ?? '-' }} / {{ $preekripsi->preop_bicarbonat ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Conductivity / Kalium / Suhu / Base Na</td>
                    <td>:</td>
                    <td>{{ $preekripsi->preop_conductivity ?? '-' }} / {{ $preekripsi->preop_kalium ?? '-' }} /
                        {{ $preekripsi->preop_suhu_dialisat ?? '-' }} / {{ $preekripsi->preop_base_na ?? '-' }}</td>
                </tr>
            </table>
        @else
            <p style="margin-left: 10px;">Tidak ada data preskripsi.</p>
        @endif

        <p style="font-weight: bold; margin-top: 10px; background-color: #f9f9f9; padding: 3px;">Heparinisasi:</p>
        @if ($heparinisasi)
            <table class="data-table" style="margin-left: 10px;">
                <tr>
                    <td>Dosis Sirkulasi / Awal</td>
                    <td>:</td>
                    <td>{{ $heparinisasi->dosis_sirkulasi ?? '-' }} IU / {{ $heparinisasi->dosis_awal ?? '-' }} IU
                    </td>
                </tr>
                <tr>
                    <td>Maintenance Kontinyu / Intermiten</td>
                    <td>:</td>
                    <td>{{ $heparinisasi->maintenance_kontinyu ?? '-' }} IU/jam /
                        {{ $heparinisasi->maintenance_intermiten ?? '-' }} IU/jam</td>
                </tr>
                <tr>
                    <td>Tanpa Heparin / LMWH</td>
                    <td>:</td>
                    <td>{{ $heparinisasi->tanpa_heparin ?? '-' }} / {{ $heparinisasi->lmwh ?? '-' }} IU</td>
                </tr>
                <tr>
                    <td>Program Bilas NaCl</td>
                    <td>:</td>
                    <td>{{ $heparinisasi->program_bilas_nacl ?? '-' }}</td>
                </tr>
            </table>
        @else
            <p style="margin-left: 10px;">Tidak ada data heparinisasi.</p>
        @endif

        <p style="font-weight: bold; margin-top: 10px; background-color: #f9f9f9; padding: 3px;">Tindakan Keperawatan
            (Pra HD):</p>
        @if ($tindakanKep)
            <table class="data-table" style="margin-left: 10px;">
                <tr>
                    <td>Waktu / TD</td>
                    <td>:</td>
                    <td>{{ $tindakanKep->prehd_waktu_pre_hd ? \Carbon\Carbon::parse($tindakanKep->prehd_waktu_pre_hd)->format('H:i') : '-' }}
                        / {{ $tindakanKep->prehd_sistole ?? '-' }}/{{ $tindakanKep->prehd_diastole ?? '-' }} mmHg
                    </td>
                </tr>
                <tr>
                    <td>QB / QD / UF Rate</td>
                    <td>:</td>
                    <td>{{ $tindakanKep->prehd_qb ?? '-' }} / {{ $tindakanKep->prehd_qd ?? '-' }} /
                        {{ $tindakanKep->prehd_uf_rate ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nadi / Nafas / Suhu</td>
                    <td>:</td>
                    <td>{{ $tindakanKep->prehd_nadi ?? '-' }} / {{ $tindakanKep->prehd_nafas ?? '-' }} /
                        {{ $tindakanKep->prehd_suhu ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Intake (NaCl / Minum / Lain)</td>
                    <td>:</td>
                    <td>{{ $tindakanKep->prehd_nacl ?? '-' }} ml / {{ $tindakanKep->prehd_minum ?? '-' }} ml /
                        {{ $tindakanKep->prehd_intake_lain ?? '-' }} ml</td>
                </tr>
                <tr>
                    <td>Output</td>
                    <td>:</td>
                    <td>{{ $tindakanKep->prehd_output ?? '-' }} ml</td>
                </tr>
            </table>
        @else
            <p style="margin-left: 10px;">Tidak ada data tindakan Pra HD.</p>
        @endif
        <div class="section" style="page-break-inside: avoid;">
            <p style="font-weight: bold; margin-top: 10px; background-color: #f9f9f9; padding: 3px;">Daftar Observasi
                Intra
                Tindakan HD</p>
            @if ($intrahd && $intrahd->observasi_data)
                @php
                    $observasiData = json_decode($intrahd->observasi_data, true);
                @endphp
                <table class="obs-table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>QB</th>
                            <th>QD</th>
                            <th>UF Rate</th>
                            <th>TD (mmHg)</th>
                            <th>Nadi</th>
                            <th>Nafas</th>
                            <th>Suhu</th>
                            <th>NaCl</th>
                            <th>Minum</th>
                            <th>Lain</th>
                            <th>Output</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (is_array($observasiData) && count($observasiData) > 0)
                            @foreach ($observasiData as $obs)
                                <tr>
                                    <td>{{ $obs['waktu'] ?? '-' }}</td>
                                    <td>{{ $obs['qb'] ?? '-' }}</td>
                                    <td>{{ $obs['qd'] ?? '-' }}</td>
                                    <td>{{ $obs['uf_rate'] ?? '-' }}</td>
                                    <td>{{ $obs['td'] ?? '-' }}</td>
                                    <td>{{ $obs['nadi'] ?? '-' }}</td>
                                    <td>{{ $obs['nafas'] ?? '-' }}</td>
                                    <td>{{ $obs['suhu'] ?? '-' }}</td>
                                    <td>{{ $obs['nacl'] ?? '-' }}</td>
                                    <td>{{ $obs['minum'] ?? '-' }}</td>
                                    <td>{{ $obs['lain_lain'] ?? '-' }}</td>
                                    <td>{{ $obs['output'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12" style="text-align: center;">Tidak ada data observasi intra HD.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            @else
                <p style="margin-left: 10px;">Tidak ada data observasi intra HD.</p>
            @endif

            <p style="font-weight: bold; margin-top: 10px; background-color: #f9f9f9; padding: 3px;">Post HD</p>
            @if ($posthd)
                <table class="data-table" style="margin-left: 10px;">
                    <tr>
                        <td>Lama Waktu Post HD</td>
                        <td>:</td>
                        <td>{{ $posthd->lama_waktu_post_hd ?? '-' }} menit</td>
                    </tr>
                    <tr>
                        <td>Tekanan Darah</td>
                        <td>:</td>
                        <td>{{ $posthd->sistole_post ?? '-' }}/{{ $posthd->diastole_post ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nadi</td>
                        <td>:</td>
                        <td>
                            {{ $posthd->nadi_post ?? '-' }} x/mnt</td>
                    </tr>
                    <tr>
                        <td>Nafas</td>
                        <td>:</td>
                        <td>{{ $posthd->nafas_post ?? '-' }} x/mnt</td>
                    </tr>
                    <tr>
                        <td>Suhu</td>
                        <td>:</td>
                        <td>{{ $posthd->suhu_post ?? '-' }} °C</td>
                    </tr>
                    <tr>
                        <td>Jumlah Cairan Intake</td>
                        <td>:</td>
                        <td>{{ $posthd->jumlah_cairan_intake ?? '-' }} ml</td>
                    </tr>
                    <tr>
                        <td>Jumlah Cairan Output</td>
                        <td>:</td>
                        <td>{{ $posthd->jumlah_cairan_output ?? '-' }}ml</td>
                    </tr>
                    <tr>
                        <td>Ultrafiltration Total</td>
                        <td>:</td>
                        <td>{{ $posthd->ultrafiltration_total ?? '-' }} ml</td>
                    </tr>
                    <tr>
                        <td>Keterangan SOAPIE</td>
                        <td>:</td>
                        <td>{!! nl2br(e($posthd->keterangan_soapie ?? '-')) !!}</td>
                    </tr>
                </table>
            @else
                <p style="margin-left: 10px;">Tidak ada data tindakan Post HD.</p>
            @endif
        </div>

        <div class="section">
            <div class="section-title">11. PENYULIT SELAMA HD</div>
            @if ($kep)
                <table class="data-table">
                    <tr>
                        <td>Klinis</td>
                        <td>:</td>
                        <td>{{ $kep->klinis_values ? implode(', ', json_decode($kep->klinis_values, true) ?? []) : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Teknis</td>
                        <td>:</td>
                        <td>{{ $kep->teknis_values ? implode(', ', json_decode($kep->teknis_values, true) ?? []) : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Mesin</td>
                        <td>:</td>
                        <td>{{ $kep->mesin ?? '-' }}</td>
                    </tr>
                </table>
            @else
                <p>Tidak ada data.</p>
            @endif
        </div>

        <div class="section">
            <div class="section-title">12. DISCHARGE PLANNING</div>
            @if ($kep)
                <table class="data-table">
                    <tr>
                        <td>Rencana Pulang</td>
                        <td>:</td>
                        <td>{{ $kep->rencana_pulang_values ? implode(', ', json_decode($kep->rencana_pulang_values, true) ?? []) : '-' }}
                        </td>
                    </tr>
                </table>
            @else
                <p>Tidak ada data.</p>
            @endif
        </div>

        <div class="section">
            <div class="section-title">13. SOAP (EVALUASI)</div>
            @if ($kep)
                <table class="data-table">
                    <tr>
                        <td style="width: 100px;">Subjective</td>
                        <td>:</td>
                        <td>{!! nl2br(e($kep->soap_s ?? '-')) !!}</td>
                    </tr>
                    <tr>
                        <td>Objective</td>
                        <td>:</td>
                        <td>{!! nl2br(e($kep->soap_o ?? '-')) !!}</td>
                    </tr>
                    <tr>
                        <td>Assessment</td>
                        <td>:</td>
                        <td>{!! nl2br(e($kep->soap_a ?? '-')) !!}</td>
                    </tr>
                    <tr>
                        <td>Planning</td>
                        <td>:</td>
                        <td>{!! nl2br(e($kep->soap_p ?? '-')) !!}</td>
                    </tr>
                </table>
            @else
                <p>Tidak ada data.</p>
            @endif
        </div>

        <div class="section">
            <div class="section-title">14. TANDA TANGAN DAN VERIFIKASI</div>

            @php
                // Ambil nama Perawat Pemeriksa
                $namaPerawatPemeriksa = '-';
                if ($kep && $kep->perawat_pemeriksa && $perawat) {
                    $pemeriksa = $perawat->firstWhere('kd_karyawan', $kep->perawat_pemeriksa);
                    if ($pemeriksa) {
                        $namaPerawatPemeriksa =
                            ($pemeriksa->gelar_depan ? $pemeriksa->gelar_depan . ' ' : '') .
                            $pemeriksa->nama .
                            ($pemeriksa->gelar_belakang ? ', ' . $pemeriksa->gelar_belakang : '');
                    }
                }

                // Ambil nama Dokter DPJP
                $namaDokterDpjp = '-';
                if ($kep && $kep->dokter_pelaksana && $dokterPelaksana) {
                    $dpjp = $dokterPelaksana->firstWhere('dokter.kd_dokter', $kep->dokter_pelaksana);
                    if ($dpjp) {
                        $namaDokterDpjp = $dpjp->dokter->nama_lengkap;
                    }
                }

                // Ambil nama Perawat Bertugas (JSON)
                $perawatBertugasList = $kep ? json_decode($kep->perawat_bertugas, true) ?? [] : [];
            @endphp

            <table class="data-table" style="margin-top: 20px;">
                <tr>
                    <td style="width: 33%; text-align: center; vertical-align: top;">
                        Perawat Pemeriksa Akses Vaskular
                        <div style="height: 60px;"></div>
                        <div class="sig-name" style="margin-top: 0;">
                            ({{ $namaPerawatPemeriksa }})
                        </div>
                    </td>

                    <td style="width: 33%; text-align: center; vertical-align: top;">
                        Perawat Yang Bertugas
                        <div style="height: 60px;"></div>
                        <div class="sig-name" style="margin-top: 0; line-height: 1.5;">
                            @if (count($perawatBertugasList) > 0)
                                @foreach ($perawatBertugasList as $pBertugas)
                                    ({{ $pBertugas['nama'] ?? '..............................' }})
                                    <br>
                                @endforeach
                            @else
                                (..............................)
                            @endif
                        </div>
                    </td>

                    <td style="width: 33%; text-align: center; vertical-align: top;">
                        Dokter DPJP
                        <div style="height: 60px;"></div>
                        <div class="sig-name" style="margin-top: 0;">
                            ({{ $namaDokterDpjp }})
                        </div>
                    </td>
                </tr>
            </table>
        </div>

</body>

</html>
