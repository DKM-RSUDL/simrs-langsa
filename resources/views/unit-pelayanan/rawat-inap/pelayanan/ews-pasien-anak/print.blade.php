<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Early Warning System (EWS) Pasien Anak</title>
    <style>
        @page {
            size: A4;
            margin: 3mm 6mm;
        }

        .a4 {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8.5pt;
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

        /* EWS specific styles */
        .ews-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 6pt;
            margin-top: 10px;
        }

        .ews-table th,
        .ews-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            height: 14px;
        }

        .ews-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .parameter-col {
            width: 90px;
            text-align: left !important;
            padding-left: 4px !important;
            font-weight: bold;
            white-space: nowrap;
        }

        .nilai-col {
            width: 60px;
        }

        .skor-col {
            width: 20px;
        }

        .cell-green {
            background-color: #90EE90;
        }

        .cell-yellow {
            background-color: #FFFF00;
        }

        .cell-red {
            background-color: #FF6347;
        }

        .hasil-ews {
            margin-top: 8px;
            font-size: 7pt;
            font-weight: bold;
        }

        .hasil-ews-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .hasil-ews-table td {
            padding: 4px;
            border: 1px solid #000;
            font-size: 6pt;
            text-align: center;
        }

        .hasil-low {
            background-color: #90EE90;
        }

        .hasil-medium {
            background-color: #FFFF00;
        }

        .hasil-high {
            background-color: #FF6347;
        }

        .intervention-page {
            font-size: 8pt;
            margin-top: 20px;
        }

        .intervention-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0;
        }

        .risk-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .risk-table td {
            border: 2px solid #000;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 10pt;
        }

        .risk-low {
            background-color: #90EE90;
        }

        .risk-medium {
            background-color: #FFFF00;
        }

        .risk-high {
            background-color: #FF6347;
            color: white;
        }

        .avpu-explanation {
            margin: 15px 0;
            font-size: 9pt;
        }

        .avpu-explanation p {
            margin: 3px 0;
        }

        .intervention-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .intervention-table th,
        .intervention-table td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 8pt;
        }

        .intervention-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .intervention-table td {
            vertical-align: top;
        }

        .footer {
            margin-top: 10px;
            font-size: 6pt;
            text-align: right;
        }

        .small-text {
            font-size: 5pt;
        }

        /* Print specific */
        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <div class="a4">

        @php
            // logo base64 (dompdf-friendly)
            $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = @file_get_contents($logoPath);
            $logoBase64 = $logoData ? 'data:image/' . $logoType . ';base64,' . base64_encode($logoData) : null;
        @endphp

        <table class="header-table">
            <tr>
                <td class="td-left">
                    <table class="brand-table">
                        <tr>
                            <td class="va-middle">
                                @if ($logoBase64)
                                    <img src="{{ $logoBase64 }}" alt="Logo RSUD Langsa"
                                        style="width: 50px; height: 50px;">
                                @endif
                            </td>
                            <td class="va-middle">
                                <p class="brand-name">RSUD LANGSA</p>
                                <p class="brand-info">Jl. Jend. A. Yani, Kota Langsa</p>
                                <p class="brand-info">Telp: 0641-22051</p>
                                <p class="brand-info">Email: rsudlangsa.aceh@gmail.com</p>
                            </td>
                        </tr>
                    </table>
                </td>

                <td class="td-center">
                    <span class="title-main">EARLY WARNING SYSTEM (EWS)</span>
                    <span class="title-sub">PASIEN ANAK</span>
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
                <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
                <th>Tgl. Lahir</th>
                <td>
                    {{ !empty($dataMedis->pasien->tgl_lahir) ? date('d M Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}
                </td>
            </tr>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $dataMedis->pasien->nama ?? '-' }}</td>
                <th>Jenis Kelamin</th>
                <td>
                    @php
                        $gender = '-';
                        if (isset($dataMedis->pasien->jenis_kelamin)) {
                            $gender = (string) $dataMedis->pasien->jenis_kelamin === '1' ? 'Laki-Laki' : 'Perempuan';
                        }
                    @endphp
                    {{ $gender }}
                </td>
            </tr>
        </table>

        <br>

        @php
            // Pastikan ewsRecords diurutkan berdasarkan tanggal dan jam
            $sortedRecords = $ewsRecords->sortBy(function ($record) {
                return Carbon\Carbon::parse($record->tanggal)->format('Y-m-d') .
                    ' ' .
                    Carbon\Carbon::parse($record->jam_masuk)->format('H:i:s');
            });
        @endphp

        @if ($sortedRecords->isEmpty())
            <p style="text-align: center; font-size: 8pt;">Tidak ada data EWS yang tersedia untuk tanggal
                {{ \Carbon\Carbon::parse($recordDate)->format('d/m/Y') }}.</p>
        @else
            <table class="ews-table">
                <thead>
                    <tr>
                        <th rowspan="3" class="parameter-col">PARAMETER</th>
                        <th colspan="2" rowspan="2">Tanggal & Jam</th>
                        @foreach ($sortedRecords as $record)
                            <th>{{ \Carbon\Carbon::parse($record->tanggal)->format('d/m/Y') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($sortedRecords as $record)
                            <th>{{ \Carbon\Carbon::parse($record->jam_masuk)->format('H:i') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="nilai-col">Penilaian</th>
                        <th class="skor-col">Skor</th>
                        @foreach ($sortedRecords as $record)
                            <th></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- KEADAAN UMUM -->
                    <tr>
                        <td rowspan="4" class="parameter-col">KEADAAN UMUM</td>
                        <td class="nilai-col">Interaksi biasa</td>
                        <td class="skor-col cell-green">0</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 0 ? 'cell-green' : '' }}">
                                {{ $record->keadaan_umum == 0 ? '0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Somnolen</td>
                        <td class="skor-col cell-yellow">1</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 1 ? 'cell-yellow' : '' }}">
                                {{ $record->keadaan_umum == 1 ? '1' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Iritabel, tidak dapat ditenangkan</td>
                        <td class="skor-col cell-yellow">2</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 2 ? 'cell-yellow' : '' }}">
                                {{ $record->keadaan_umum == 2 ? '2' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Letargi, gelisah, penurunan respon terhadap nyeri</td>
                        <td class="skor-col cell-red">3</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->keadaan_umum == 3 ? 'cell-red' : '' }}">
                                {{ $record->keadaan_umum == 3 ? '3' : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- KARDIOVASKULAR -->
                    <tr>
                        <td rowspan="4" class="parameter-col">KARDIOVASKULAR</td>
                        <td class="nilai-col">Tidak sianosis ATAU pengisian kapiler < 2 detik</td>
                        <td class="skor-col cell-green">0</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 0 ? 'cell-green' : '' }}">
                                {{ $record->kardiovaskular == 0 ? '0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Tampak pucat ATAU pengisian kapiler 2 detik</td>
                        <td class="skor-col cell-yellow">1</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 1 ? 'cell-yellow' : '' }}">
                                {{ $record->kardiovaskular == 1 ? '1' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Tampak sianotik ATAU pengisian kapiler >2 detik ATAU Takikardi >20 × di
                            atas
                            parameter HR sesuai usia/menit</td>
                        <td class="skor-col cell-yellow">2</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 2 ? 'cell-yellow' : '' }}">
                                {{ $record->kardiovaskular == 2 ? '2' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Sianotik dan motlet, ATAU pengisian kapiler >5 detik, ATAU Takikardi >30x
                            di
                            atas parameter HR sesuai usia/menit ATAU Bradikardia sesuai usia</td>
                        <td class="skor-col cell-red">3</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->kardiovaskular == 3 ? 'cell-red' : '' }}">
                                {{ $record->kardiovaskular == 3 ? '3' : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- RESPIRASI -->
                    <tr>
                        <td rowspan="4" class="parameter-col">RESPIRASI</td>
                        <td class="nilai-col">Respirasi dalam parameter normal, tidak terdapat retraksi</td>
                        <td class="skor-col cell-green">0</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 0 ? 'cell-green' : '' }}">
                                {{ $record->respirasi == 0 ? '0' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Takipnea >10x di atas parameter RR sesuai usia/menit, ATAU Menggunakan
                            otot
                            alat bantu napas, ATAU menggunakan FiO2 lebih dari 30%</td>
                        <td class="skor-col cell-yellow">1</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 1 ? 'cell-yellow' : '' }}">
                                {{ $record->respirasi == 1 ? '1' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Takipnea >20x di atas parameter RR sesuai usia/menit, ATAU Ada retraksi,
                            ATAU
                            menggunakan FiO2 lebih dari 40%</td>
                        <td class="skor-col cell-yellow">2</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 2 ? 'cell-yellow' : '' }}">
                                {{ $record->respirasi == 2 ? '2' : '' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="nilai-col">Laju respirasi >30x di atas parameter normal ATAU Bradipneu di mana
                            frekuensi
                            nafas lebih rendah 5 atau lebih, sesuai usia, disertai dengan retraksi berat ATAU
                            menggunakan
                            FiO2 lebih dari 50% (NRM 8 liter/menit)</td>
                        <td class="skor-col cell-red">3</td>
                        @foreach ($ewsRecords as $record)
                            <td class="record-col {{ $record->respirasi == 3 ? 'cell-red' : '' }}">
                                {{ $record->respirasi == 3 ? '3' : '' }}</td>
                        @endforeach
                    </tr>

                    <!-- TOTAL SKOR -->
                    <tr>
                        <td colspan="2" style="text-align: center; font-weight: bold;">TOTAL SKOR</td>
                        <td class="skor-col"></td>
                        @foreach ($ewsRecords as $record)
                            <td style="font-weight: bold;">{{ $record->total_skor ?? '-' }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>

            @php
                // Ambil record terbaru untuk menentukan hasil EWS
                $latestRecord = $ewsRecords->last();
                $totalSkor = $latestRecord ? $latestRecord->total_skor : 0;

                // Tentukan kategori berdasarkan total skor
                $kategoriHasil = '';
                $classHasil = '';
                $keteranganDetail = '';

                if ($totalSkor >= 5) {
                    $kategoriHasil = 'Skor ≥ 5: PERUBAHAN SIGNIFIKAN';
                    $classHasil = 'hasil-high';
                    $keteranganDetail =
                        'Ada perubahan yang signifikan, lakukan resusitasi, monitoring secara kontinyu, aktivasi code blue kegawatan medis, respon Tim Medis Emergency (TME) segera, maksimal 10 menit, informasikan dan konsultasikan ke DPJP.';
                } elseif ($totalSkor >= 3) {
                    $kategoriHasil = 'Skor 3-4 atau Skor 3 pada Satu Parameter: PENURUNAN KONDISI';
                    $classHasil = 'hasil-medium';
                    $keteranganDetail =
                        'Ada peningkatan kondisi pasien, assessment oleh dokter jaga bangsal. Lakukan evaluasi ulang setiap 2 jam atau lebih cepat, konsultasi ke DPJP, lakukan terapi sesuai instruksi, jika diperlukan dipindahkan ke area dengan monitoring yang sesuai.';
                } else {
                    $kategoriHasil = 'Skor 0-2: PASIEN STABIL';
                    $classHasil = 'hasil-low';
                    $keteranganDetail =
                        'Pasien dalam keadaan stabil, jika skor 0 lakukan evaluasi secara rutin tiap 8 jam, jika skor naik 1 atau 2, lakukan evaluasi setiap 4 jam, jika diperlukan assessment oleh dokter jaga bangsal.';
                }

                // Cek apakah ada parameter dengan skor 3 (kondisi khusus)
                $hasParameterSkor3 = false;
                if ($latestRecord) {
                    if (
                        $latestRecord->keadaan_umum == 3 ||
                        $latestRecord->kardiovaskular == 3 ||
                        $latestRecord->respirasi == 3
                    ) {
                        $hasParameterSkor3 = true;
                        if ($totalSkor < 5) {
                            $kategoriHasil = 'Skor 3-4 atau Skor 3 pada Satu Parameter: PENURUNAN KONDISI';
                            $classHasil = 'hasil-medium';
                            $keteranganDetail =
                                'Ada peningkatan kondisi pasien, assessment oleh dokter jaga bangsal. Lakukan evaluasi ulang setiap 2 jam atau lebih cepat, konsultasi ke DPJP, lakukan terapi sesuai instruksi, jika diperlukan dipindahkan ke area dengan monitoring yang sesuai.';
                        }
                    }
                }
            @endphp

            <div class="hasil-ews">HASIL EARLY WARNING SCORING:</div>
            <table class="hasil-ews-table">
                <tr>
                    <td class="{{ $classHasil }}">
                        <strong>Total Skor: {{ $totalSkor }}</strong> <br>
                        {{-- {{ $kategoriHasil }}<br> --}}
                        {{ $keteranganDetail }}
                    </td>
                </tr>
            </table>
        @endif

        <div class="footer">
            <p style="font-size: 12px">Nama dan Paraf:</p>
            <p style="margin-top: 40px; font-size: 12px;">
                {{ str()->title($ewsPasienAnak->userCreate->name ?? '-') }}</p>
            <p class="small-text" style="font-size: 12px">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
            </p>
            @if (isset($ewsPasienAnak) && $ewsPasienAnak->userCreate && $ewsPasienAnak->userCreate->jabatan)
                <p>{{ $ewsPasienAnak->userCreate->jabatan }}</p>
            @endif
        </div>

        <!-- Halaman Kedua: Protokol dan Tabel Vital Signs -->
        <div class="page-break"></div>

        <div class="protocol-title">PROTOKOL ASSESSMENT DAN INTERVENSI EWS ANAK</div>

        <!-- Tabel Kategori Skor -->
        <div class="protocol-section">
            <table class="protocol-table">
                <tbody>
                    <tr>
                        <td class="skor-0-2">Skor 0-2</td>
                        <td class="protocol-text">Pasien dalam keadaan stabil, jika skor 0 lakukan evaluasi secara rutin
                            tiap 8 jam, jika skor naik 1 atau 2, lakukan evaluasi setiap 4 jam, jika di perlukan
                            assessment oleh dokter jaga bangsal.</td>
                    </tr>
                    <tr>
                        <td class="skor-3-4">Skor 3-4</td>
                        <td class="protocol-text">Ada peningkatan kondisi pasien, assessment oleh dokter jaga bangsal.
                            Lakukan evaluasi ulang setiap 2 jam atau lebih cepat, konsultasi ke DPJP, lakukan terapi
                            sesuai instruksi, jika diperlukan dipindahkan ke area dengan monitoring yang sesuai.
                        </td>
                    </tr>
                    <tr>
                        <td class="skor-5-plus">Skor > 5</td>
                        <td class="protocol-text">Ada perubahan yang signifikan, lakukan resusitasi, monitoring secara
                            kontinyu, aktivasi code blue kegawatan medis, respon Tim Medis Emergency (TME) segera,
                            maksimal 10 menit, informasikan dan konsultasikan ke DPJP.</td>
                    </tr>
                    <tr>
                        <td class="skor-henti">HENTI NAFAS/JANTUNG</td>
                        <td class="protocol-text">Lakukan RJP oleh petugas/ tim primer, aktivasi code blue henti jantung
                            respon Tim Medis Emergency (TME), maksimal 5 menit, informasikan dan konsultasikan ke
                            DPJP.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabel Data Vital Signs berdasarkan Usia -->
        <div class="vital-signs-section">
            <table class="vital-signs-table">
                <thead>
                    <tr>
                        <th class="kategori-header">Kategori</th>
                        <th class="usia-header">Usia</th>
                        <th class="nadi-header">Nadi saat istirahat (x/menit)</th>
                        <th class="nafas-header">Nafas saat istirahat (x/menit)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="kategori-cell">Neonatus</td>
                        <td class="data-cell">0-1 bln</td>
                        <td class="data-cell">100-180</td>
                        <td class="data-cell">40-60</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Bayi</td>
                        <td class="data-cell">1-12 bln</td>
                        <td class="data-cell">100-180</td>
                        <td class="data-cell">35-40</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Balita</td>
                        <td class="data-cell">13-36 bln</td>
                        <td class="data-cell">70-110</td>
                        <td class="data-cell">25-30</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Pra Sekolah</td>
                        <td class="data-cell">4-6 Thn</td>
                        <td class="data-cell">70-110</td>
                        <td class="data-cell">21-23</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Sekolah</td>
                        <td class="data-cell">7-12 Thn</td>
                        <td class="data-cell">70-110</td>
                        <td class="data-cell">19-21</td>
                    </tr>
                    <tr>
                        <td class="kategori-cell">Remaja</td>
                        <td class="data-cell">13-19 Thn</td>
                        <td class="data-cell">55-90</td>
                        <td class="data-cell">16-18</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>
