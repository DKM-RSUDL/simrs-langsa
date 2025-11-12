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
            page-break-inside: avoid;
            /* Tambahkan ini agar section tidak terpotong */
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

        .fisik-table {
            width: 100%;
        }

        .fisik-table td {
            border: none;
            padding: 2px 4px;
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

        /* --- PERBAIKAN TTD --- */
        .signature-block {
            margin-top: 40px;
            width: 100%;
            clear: both;
            page-break-inside: avoid;
        }

        .sig-table {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .sig-table td {
            width: 33%;
            text-align: center;
            vertical-align: top;
            border: none;
            padding: 0;
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
                            {{ $fisik->avpu ?? '-' }}
                    @endswitch
                </td>
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
            <tr>
                <td>Luas Permukaan Tubuh (LPT)</td>
                <td>:</td>
                <td>{{ $fisik->lpt ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        @php
            // 1. Dapatkan MASTER LIST (pastikan dikirim dari controller)
            $masterItemList = ($itemFisik ?? collect())->values();

            // 2. Dapatkan data YANG DISIMPAN untuk asesmen ini
            //    Nama relasi "pemFisik" sudah benar (sesuai kode show Anda)
            $savedItems = $asesmen->pemFisik ?? collect();

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
                        $itemKiri = $masterItemList->get($i);
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
                    <b>Nilai Skala Nyeri:</b> {{ $fisik->skala_nyeri ?? '-' }}
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
        <div class="section-title">4. RIWAYAT KESEHATAN & TERAPI</div>
        <table class="data-table">
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
        </table>
        <div class="section">
            <div class="section-title">5. Terapi Obat dan Injeksi</div>
            <table class="obs-table">
                <thead>
                    <tr>
                        <th>Nama Obat</th>
                        <th>Dosis</th>
                        <th>Waktu Penggunaan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Ambil data obat dari relasi $fisik
                        $terapiObat = $fisik->terapi_obat ?? [];
                    @endphp

                    @if (is_array($terapiObat) && count($terapiObat) > 0)
                        @foreach ($terapiObat as $obat_json)
                            @php $obat = json_decode($obat_json, true); @endphp
                            <tr>
                                <td>{{ $obat['nama_obat'] ?? '-' }}</td>
                                <td>{{ $obat['dosis'] ?? '-' }}</td>
                                <td>{{ $obat['waktu'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" style="text-align: center;">- Tidak ada data -</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            </td>
            </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">6. HASIL PEMERIKSAAN PENUNJANG</div>
            <table class="data-table">
                <tr>
                    <td>HB / HbsAg / Anti HCV / Anti HIV</td>
                    <td>:</td>
                    <td>{{ $penunjang->hb ?? '-' }} / {{ $penunjang->hbsag ?? '-' }} / {{ $penunjang->hcv ?? '-' }} /
                        {{ $penunjang->hiv ?? '-' }}</td>
                </tr>
                <tr>
                    <!-- PERBAIKAN: Menambahkan Phospor -->
                    <td>Ureum / Creatinin / Asam Urat / Phospor</td>
                    <td>:</td>
                    <td>{{ $penunjang->ureum ?? '-' }} / {{ $penunjang->creatinin ?? '-' }} /
                        {{ $penunjang->asam_urat ?? '-' }} / {{ $penunjang->phospor ?? '-' }}</td>
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
                <!-- PERBAIKAN: Menambahkan Fe Serum & TIBC -->
                <tr>
                    <td>Fe Serum / TIBC</td>
                    <td>:</td>
                    <td>{{ $penunjang->fe_serum ?? '-' }} / {{ $penunjang->tibc ?? '-' }}</td>
                </tr>
                <tr>
                    <td>EKG / Rongent / USG</td>
                    <td>:</td>
                    <td>{{ $penunjang->ekg ?? '-' }} / {{ $penunjang->rongent ?? '-' }} /
                        {{ $penunjang->usg ?? '-' }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">7. DESKRIPSI HEMODIALISIS</div>
            <table class="data-table">
                <tr>
                    <td>Jenis Hemodialisis</td>
                    <td>:</td>
                    <td>
                        <!-- PERBAIKAN: Menambahkan logika untuk menampilkan teks -->
                        @if ($deskripsi->jenis_hd == 1)
                            Akut
                        @elseif ($deskripsi->jenis_hd == 2)
                            Kronik
                        @elseif ($deskripsi->jenis_hd == 3)
                            Pra Operasi
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <!-- PERBAIKAN: Menambahkan Bila Rutin -->
                <tr>
                    <td>Bila Rutin (x/minggu)</td>
                    <td>:</td>
                    <td>{{ $deskripsi->rutin ?? '-' }}</td>
                </tr>
                <!-- PERBAIKAN: Menambahkan Jenis Dialisat -->
                <tr>
                    <td>Jenis Dialisat</td>
                    <td>:</td>
                    <td>
                        @if ($deskripsi->jenis_dialisat == 1)
                            Asetat
                        @elseif ($deskripsi->jenis_dialisat == 2)
                            Bicabornat
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <!-- PERBAIKAN: Menambahkan Suhu Dialisat -->
                <tr>
                    <td>Suhu Dialisat</td>
                    <td>:</td>
                    <td>{{ $deskripsi->suhu_dialisat ?? '-' }} °C</td>
                </tr>
                <tr>
                    <td>Akses Vaskular</td>
                    <td>:</td>
                    <td>
                        <!-- PERBAIKAN: Menambahkan logika untuk menampilkan teks -->
                        @if ($deskripsi->akses_vaskular == 1)
                            Cimino
                        @elseif ($deskripsi->akses_vaskular == 2)
                            Femoral
                        @elseif ($deskripsi->akses_vaskular == 3)
                            CDL Jugularis
                        @elseif ($deskripsi->akses_vaskular == 4)
                            CDL Subclavia
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Lama HD</td>
                    <td>:</td>
                    <td>{{ $deskripsi->lama_hd ?? '-' }} jam
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="font-weight: bold; background-color: #f9f9f9;">Parameter Mesin</td>
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
                    <td colspan="5" style="font-weight: bold; background-color: #f9f9f9;">Heparinisasi </td>
                </tr>
                <tr>
                    <td>Dosis Awal</td>
                    <td>:</td>
                    <td>{{ $deskripsi->dosis_awal ?? '-' }} IU</td>
                </tr>
                <!-- PERBAIKAN: Menambahkan Heparinisasi Maintenance -->
                <tr>
                    <td>Maintenance (Kontinyu / Intermiten)</td>
                    <td>:</td>
                    <td>{{ $deskripsi->m_kontinyu ?? '-' }} IU / {{ $deskripsi->m_intermiten ?? '-' }} IU</td>
                </tr>
                <!-- PERBAIKAN: Menambahkan Tanpa Heparin / LMWH -->
                <tr>
                    <td>Tanpa Heparin / LMWH</td>
                    <td>:</td>
                    <td>{{ $deskripsi->tanpa_heparin ?? '-' }} / {{ $deskripsi->lmwh ?? '-' }} IU</td>
                </tr>
                <<tr>
                    <td colspan="5" style="font-weight: bold; background-color: #f9f9f9;">Program Profiling </td>
                    </tr>
                    <tr>
                        <td>Ultrafiltrasi</td>
                        <td>:</td>
                        <td>
                            {{ $deskripsi->ultrafiltrasi_mode ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Natrium Mode</td>
                        <td>:</td>
                        <td>
                            {{ $deskripsi->natrium_mode ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Bicarbonat Mode</td>
                        <td>:</td>
                        <td>
                            {{ $deskripsi->bicabornat_mode ?? '-' }}
                        </td>
                    </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">8. DIAGNOSIS</div>
            <table class="data-table">
                <tr>
                    <td>Diagnosis Banding</td>
                    <td>:</td>
                    <td>
                        @if (is_array($diag_banding) && count($diag_banding) > 0)
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
                        @if (is_array($diag_kerja) && count($diag_kerja) > 0)
                            @foreach ($diag_kerja as $diag)
                                - {{ $diag }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </table>
            <div class="section">
                <div class="section-title">9. EVALUASI</div>
                <table class="data-table">
                    <tr>
                        <td>Evaluasi Medis</td>
                        <td>:</td>
                        <td>{!! nl2br(e($evaluasi->evaluasi_medis ?? '-')) !!}</td>
                    </tr>
                </table>
            </div>

            <!-- PERBAIKAN: Mengganti TTD menjadi 3 Kolom -->
            <div class="signature-block">
                <table class="sig-table">
                    <tr>
                        <td>
                            Perawat
                            <div class="sig-name">
                                <!-- Mengambil nama dari relasi 'perawatPelaksana' -->
                                @if ($evaluasi && $evaluasi->perawatPelaksana)
                                    {{ $evaluasi->perawatPelaksana->gelar_depan ?? '' }}
                                    {{ $evaluasi->perawatPelaksana->nama ?? '....................' }}
                                    {{ $evaluasi->perawatPelaksana->gelar_belakang ?? '' }}
                                @else
                                    (..............................)
                                @endif
                            </div>
                        </td>
                        <td>
                            Dokter Pelaksana
                            <div class="sig-name">
                                <!-- Mengambil nama dari relasi 'dokterPelaksana' -->
                                ({{ $evaluasi->dokterPelaksana->nama_lengkap ?? '..............................' }})
                            </div>
                        </td>
                        <td>
                            Dokter DPJP
                            <div class="sig-name">
                                <!-- Mengambil nama dari relasi 'dokterDpjp' -->
                                ({{ $evaluasi->dokterDpjp->nama_lengkap ?? '..............................' }})
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

</body>

</html>
