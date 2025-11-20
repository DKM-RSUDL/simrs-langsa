<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Operasi - {{ $dataMedis->pasien->nama ?? 'Pasien' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 15mm 10mm 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #000;
        }

        h2,
        h3,
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
            padding: 4px 6px;
            font-size: 9pt;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 120px;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .print-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
            font-size: 10pt;
        }

        .print-table .no-border {
            border: none;
            padding: 0;
        }

        .data-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .data-list li {
            padding: 2px 0;
        }

        .ttd-container {
            width: 100%;
            margin-top: 30px;
            font-size: 10pt;
        }

        .ttd-container .ttd-cell {
            width: 50%;
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        // --- HELPER FUNCTION (untuk mencegah redeclare error) ---
        if (!function_exists('renderCheckbox')) {
            function renderCheckbox($value, $targetValue, $label)
            {
                $isChecked = $value == $targetValue;
                $checkMark = $isChecked ? '&#x2713;' : '&nbsp;';
                $boxClass = $isChecked ? 'checked' : '';
                return "<span class='check-box-wrapper'><span class='checkbox {$boxClass}'>{$checkMark}</span><span class='checkbox-label'>{$label}</span></span>";
            }
        }

        // --- HELPER TRANSLATOR DARI KODE CREATE VIEW ---
        function getKompleksitasText($code)
        {
            $map = ['1' => 'Besar', '2' => 'Sedang', '3' => 'Kecil', '4' => 'Khusus'];
            return $map[$code] ?? '-';
        }
        function getUrgensiText($code)
        {
            $map = ['1' => 'Cito (Darurat)', '2' => 'Elective (Terjadwal)'];
            return $map[$code] ?? '-';
        }
        function getKebersihanText($code)
        {
            $map = ['1' => 'Bersih', '2' => 'Tercemar', '3' => 'Kotor'];
            return $map[$code] ?? '-';
        }
        function getPaKulturText($code)
        {
            $map = ['1' => 'Ya', '0' => 'Tidak'];
            return $map[$code] ?? '-';
        }

        // --- DEKLARASI VARIABEL LOKAL ---
        $pasien = $dataMedis->pasien ?? (object) [];
        $kunjungan = $dataMedis;

        // --- AMBIL NAMA TIM MEDIS (FIX) ---
        $dokterBedah = \App\Models\Dokter::where('kd_dokter', $laporan->kd_dokter_bedah)->value('nama_lengkap');
        $dokterAnastesi = \App\Models\Dokter::where('kd_dokter', $laporan->kd_dokter_anastesi)->value('nama_lengkap');
        $perawatBedah = \App\Models\Perawat::where('kd_perawat', $laporan->kd_perawat_bedah)->value('nama'); // Menggunakan 'nama'
        $penataAnastesi = \App\Models\Perawat::where('kd_perawat', $laporan->kd_penata_anastesi)->value('nama'); // Menggunakan 'nama'
        $jenisAnastesiMap = $jenisAnastesi->pluck('jenis_anastesi', 'kd_jenis_anastesi')->toArray();
        // --- DECODING JSON DARI LaporanOperasiController ---
        $diagnosaPra = is_string($laporan->diagnosa_pra_operasi)
            ? json_decode($laporan->diagnosa_pra_operasi, true)
            : $laporan->diagnosa_pra_operasi ?? [];
        $diagnosaPasca = is_string($laporan->diagnosa_pasca_operasi)
            ? json_decode($laporan->diagnosa_pasca_operasi, true)
            : $laporan->diagnosa_pasca_operasi ?? [];
        $komplikasiList = is_string($laporan->komplikasi)
            ? json_decode($laporan->komplikasi, true)
            : $laporan->komplikasi ?? [];

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
                    <span class="title-main">LAPORAN OPERASI</span>
                </td>
                <td class="td-right">
                    <div class="hd-box"><span class="hd-text">OPERASI</span></div>
                </td>
            </tr>
        </table>
    </header>

    {{-- ======================================================= --}}
    {{-- INFORMASI PASIEN --}}
    {{-- ======================================================= --}}
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
            <th>Tanggal Masuk</th>
            <td class="no-border w-30">{{ carbon_parse($kunjungan->tgl_masuk, null, 'd-m-Y') }}</td>
        </tr>
    </table>

    {{-- ======================================================= --}}
    {{-- ISI LAPORAN OPERASI (JENIS, DIAGNOSA, WAKTU) --}}
    {{-- ======================================================= --}}
    <table class="print-table" style="margin-top: 5px; width: 100%; border-collapse: collapse;">
        <tbody>

            <!-- IDENTITAS TINDAKAN -->
            <tr>
                <td colspan="2">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="border: none; width: 40%; font-weight: bold;">Nama Tindakan Operasi</td>
                            <td style="border: none;">: {{ $laporan->nama_tindakan_operasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td style="border: none; font-weight: bold;">Jenis Anastesi</td>
                            <td style="border: none;">:
                                {{ $jenisAnastesiMap[$laporan->kd_jenis_anastesi] ?? ($laporan->kd_jenis_anastesi ?? '-') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none; font-weight: bold;">Jenis Operasi</td>
                        <tr>
                            <td style="border: none;">(Kompleksitas)</td>
                            <td style="border: none;">: {{ getKompleksitasText($laporan->kompleksitas) }}</td>
                        </tr>
                        <tr>
                            <td style="border: none;">(Urgensi)</td>
                            <td style="border: none;">: {{ getUrgensiText($laporan->urgensi) }}</td>
                        </tr>
                        <tr>
                            <td style="border: none;">(Kebersihan)</td>
                            <td style="border: none;">: {{ getKebersihanText($laporan->kebersihan) }}</td>
                        </tr>
                        <tr>
                            <td style="border: none; font-weight: bold;">Dikirim untuk pemeriksaan PA</td>
                            <td style="border: none;">: {{ getPaKulturText($laporan->pa) }}</td>
                        </tr>
                        <tr>
                            <td style="border: none; font-weight: bold;">Dikirim untuk Kultur</td>
                            <td style="border: none;">: {{ getPaKulturText($laporan->kultur) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- TIM OPERASI -->
            <tr>
                <td style="width: 50%;">
                    <strong>Dokter Ahli Bedah :</strong>
                    <p style="margin-left: 10px;">{{ $dokterBedah ?? '-' }}</p>

                    <strong>Perawat Bedah:</strong>
                    <p style="margin-left: 10px;">{{ $perawatBedah ?? '-' }}</p>

                    <strong>Dokter Ahli Anestesi :</strong>
                    <p style="margin-left: 10px;">{{ $dokterAnastesi ?? '-' }}</p>

                    <strong>Penata Anestesi:</strong>
                    <p style="margin-left: 10px;">{{ $penataAnastesi ?? '-' }}</p>
                </td>

                <td style="width: 50%;">
                    <strong>Pendarahan Selama Operasi :</strong>
                    <p style="margin-left: 10px;">± {{ $laporan->pendarahan ?? 0 }} cc</p>

                    <strong>Transfusi (WB/PRC/Cryo):</strong>
                    <p style="margin-left: 10px;">
                        WB: {{ $laporan->wb ?? 0 }} cc |
                        PRC: {{ $laporan->prc ?? 0 }} cc |
                        Cryo: {{ $laporan->cryo ?? 0 }} cc
                    </p>
                </td>
            </tr>

            <!-- DIAGNOSA PRA -->
            <tr>
                <td colspan="2">
                    <strong>Diagnosa Pra Operasi</strong>
                    <ul class="data-list" style="margin-left: 10px;">
                        @forelse ($diagnosaPra as $diag)
                            <li>- {{ $diag }}</li>
                        @empty
                            <li>-</li>
                        @endforelse
                    </ul>
                </td>
            </tr>

            <!-- DIAGNOSA PASCA -->
            <tr>
                <td colspan="2">
                    <strong>Diagnosa Pasca Operasi:</strong>
                    <ul class="data-list" style="margin-left: 10px;">
                        @forelse ($diagnosaPasca as $diag)
                            <li>- {{ $diag }}</li>
                        @empty
                            <li>-</li>
                        @endforelse
                    </ul>
                </td>
            </tr>

            <!-- KOMPLIKASI -->
            <tr>
                <td colspan="2">
                    <strong>Komplikasi selama pembedahan (bila ada).</strong>
                    <ul class="data-list" style="margin-left: 10px;">
                        @forelse ($komplikasiList as $komp)
                            <li>- {{ $komp }}</li>
                        @empty
                            <li>-</li>
                        @endforelse
                    </ul>
                </td>
            </tr>

            <!-- JAM OPERASI (4 KOLOM RAPI) -->
            <tr>
                <td style="width: 25%;">
                    <strong>Tanggal Operasi :</strong>
                    <p style="margin-left: 10px;">{{ carbon_parse($laporan->tgl_mulai, null, 'd/m/Y') }}</p>
                </td>
                <td style="width: 25%;">
                    <strong>Mulai Jam :</strong>
                    <p style="margin-left: 10px;">{{ carbon_parse($laporan->jam_mulai, null, 'H:i') }} WIB</p>
                </td>
            </tr>
            <tr>
                <td style="width: 25%;">
                    <strong>Selesai Jam :</strong>
                    <p style="margin-left: 10px;">{{ carbon_parse($laporan->jam_selesai, null, 'H:i') }} WIB</p>
                </td>
                <td style="width: 25%;">
                    <strong>Lama Operasi :</strong>
                    <p style="margin-left: 10px;">{{ $laporan->lama_operasi ?? '-' }}</p>
                </td>
            </tr>

            <!-- LAPORAN PROSEDUR -->
            <tr>
                <td colspan="2" style="min-height: 250px;">
                    <strong>LAPORAN PROSEDUR OPERASI</strong>
                    <div style="margin-top: 5px; white-space: pre-wrap;">
                        {{ $laporan->laporan_prosedur_operasi ?? 'Tidak ada laporan prosedur operasi.' }}
                    </div>
                </td>
            </tr>

        </tbody>
    </table>


    {{-- ======================================================= --}}
    {{-- FOOTER DAN TANDA TANGAN --}}
    {{-- ======================================================= --}}
    <div class="ttd-container">
        <table class="no-border" style="width: 100%;">
            <tr class="no-border">
                <td class="ttd-cell"></td>
                <td class="ttd-cell">Dokter Ahli Bedah</td>
            </tr>
            <tr class="no-border">
                <td class="ttd-cell" style="padding-top: 50px;"></td>
                <td class="ttd-cell" style="padding-top: 50px;">
                    ( {{ $dokterBedah ?? '_____________________' }} )
                </td>
            </tr>
        </table>
    </div>


</body>

</html>
