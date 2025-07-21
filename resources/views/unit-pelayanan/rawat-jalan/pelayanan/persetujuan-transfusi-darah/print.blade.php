<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Persetujuan Transfusi Darah</title>
    <style>
        @page {
            margin: 1.5cm 1cm 1cm 1cm;
            size: A4 portrait;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .logo-section {
            display: table-cell;
            width: 15%;
            vertical-align: middle;
            text-align: center;
        }

        .title-section {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }

        .patient-info {
            display: table-cell;
            width: 35%;
            vertical-align: top;
        }

        .logo-box {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
        }

        .hospital-name {
            font-size: 10px;
            font-weight: bold;
            margin-top: 5px;
        }

        .hospital-address {
            font-size: 8px;
            margin-top: 2px;
        }

        .main-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .form-number {
            font-size: 9px;
            margin-top: 5px;
        }

        .patient-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        .patient-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
        }

        .patient-table .label {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 30%;
        }

        .nrm-box {
            float: right;
            width: 180px;
            border: 2px solid #000;
            padding: 8px;
            margin-top: -20px;
            background: white;
        }

        .nrm-title {
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            margin-bottom: 5px;
        }

        .nrm-grid {
            display: table;
            width: 100%;
        }

        .nrm-boxes {
            display: table-cell;
            width: 50px;
        }

        .nrm-info {
            display: table-cell;
            padding-left: 10px;
            font-size: 9px;
        }

        .checkbox-row {
            display: table;
            width: 100%;
            margin: 3px 0;
        }

        .checkbox-cell {
            display: table-cell;
            width: 15px;
            vertical-align: top;
        }

        .checkbox {
            width: 10px;
            height: 10px;
            border: 1px solid #000;
            display: inline-block;
            margin-right: 5px;
        }

        .checkbox.checked {
            background-color: #000;
        }

        .content {
            margin-top: 30px;
            clear: both;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 8px;
            text-align: center;
            text-transform: uppercase;
        }

        .form-row {
            margin-bottom: 8px;
            display: table;
            width: 100%;
        }

        .form-label {
            display: table-cell;
            width: 120px;
            font-weight: bold;
            vertical-align: top;
        }

        .form-value {
            display: table-cell;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            vertical-align: bottom;
        }

        .form-line {
            border-bottom: 1px solid #000;
            min-height: 20px;
            display: inline-block;
            min-width: 200px;
        }

        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-row {
            display: table;
            width: 100%;
            margin-top: 40px;
        }

        .signature-cell {
            display: table-cell;
            width: 25%;
            text-align: center;
            vertical-align: top;
            padding: 0 5px;
        }

        .signature-box {
            height: 60px;
            border-bottom: 1px solid #000;
            margin-bottom: 5px;
        }

        .signature-label {
            font-size: 10px;
            font-weight: bold;
        }

        .checkbox-group {
            margin: 10px 0;
        }

        .checkbox-inline {
            display: inline-block;
            margin-right: 20px;
        }

        .underline {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 150px;
            padding-bottom: 2px;
        }

        .center {
            text-align: center;
        }

        .mt-10 { margin-top: 10px; }
        .mt-15 { margin-top: 15px; }
        .mt-20 { margin-top: 20px; }
        .mb-10 { margin-bottom: 10px; }
        .mb-15 { margin-bottom: 15px; }

        .page-break {
            page-break-before: always;
        }

        /* Specific form styling */
        .patient-data {
            margin-bottom: 20px;
        }

        .consent-statement {
            margin: 15px 0;
            line-height: 1.4;
        }

        .checkbox-list {
            margin: 2px 0;
            padding-left: 0;
        }

        .checkbox-item {
            display: table;
            width: 100%;
            margin: 5px 0;
        }

        .decision-section {
            margin: 20px 0;
            text-align: center;
        }

        .decision-options {
            display: inline-block;
            margin: 0 20px;
        }

        .location-date {
            margin: 30px 0 20px 0;
            text-align: center;
        }

        .clear-fix {
            clear: both;
        }
        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo-box">
                    @if(file_exists(public_path('assets/img/Logo-RSUD-Langsa-1.png')))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}"
                             style="width: 50px; height: 50px;" alt="Logo RSUD Langsa">
                    @else
                        LOGO
                    @endif
                </div>
                <div class="hospital-name">RSUD LANGSA</div>
                <div class="hospital-address">Jl. Jend. A. Yani No. 1<br>Telp: 0641-22051 Kota Langsa</div>
            </div>

            <div class="title-section">
                <h1 class="main-title">PERSETUJUAN TRANSFUSI DARAH/ PRODUK DARAH</h1>
            </div>

            <div class="patient-info">

                <table class="patient-table">
                    <tr>
                        <td class="label">NRM</td>
                        <td>{{ $dataMedis->pasien->kd_pasien ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama</td>
                        <td>{{ $dataMedis->pasien->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Kelamin</td>
                        <td>
                            @if(isset($dataMedis->pasien->jenis_kelamin))
                                {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}
                            @else
                                Laki-laki / Perempuan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Lahir</td>
                        <td>{{ $dataMedis->pasien->tgl_lahir ? date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Patient Basic Info -->
        <div class="patient-data">
            <div class="form-row">
                <div class="form-label">Nama Pasien</div>
                <div class="form-value">: {{ $dataMedis->pasien->nama ?? '_______________________________________________________________' }}</div>
            </div>

            <div class="form-row">
                <div class="form-label">No. Rekam Medik</div>
                <div class="form-value">: {{ $dataMedis->pasien->kd_pasien ?? '__________________' }}</div>
            </div>

            <div class="form-row">
                <div class="form-label">Tanggal lahir</div>
                <div class="form-value">: {{ $dataMedis->pasien->tgl_lahir ? date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) : '____________________________' }}</div>
            </div>

            <div class="form-row">
                <div class="form-label">Jenis Kelamin</div>
                <div class="form-value">:
                    @if(isset($dataMedis->pasien->jenis_kelamin))
                        {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}
                    @else
                        Laki-laki/Perempuan
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-label">Diagnosa</div>
                <div class="form-value">: {{ $persetujuan->diagnosa ?? '____________________________' }}</div>
            </div>
        </div>

        <!-- Declaration Section -->
        <div class="section">
            <p><strong>Saya yang bertanda tangan di bawah ini,</strong></p>

            @if($persetujuan->persetujuan_untuk === 'keluarga')
                <!-- Family/Guardian Data -->
                <div style="margin: 15px 0;  margin-left: 20px;">
                    <div class="form-row">
                        <div class="form-label">• Nama</div>
                        <div class="form-value">: {{ $persetujuan->nama_keluarga ?? '_______________________________________________________________' }}</div>
                    </div>

                    <div class="form-row">
                        <div class="form-label">• Tanggal lahir</div>
                        <div class="form-value">: {{ $persetujuan->tgl_lahir_keluarga ? $persetujuan->tgl_lahir_keluarga->format('d/m/Y') : '___________________________' }}
                            &nbsp;&nbsp;&nbsp;&nbsp;Jenis Kelamin&nbsp;&nbsp;&nbsp;&nbsp;: {{ $persetujuan->jk_keluarga !== null ? ($persetujuan->jk_keluarga == 1 ? 'Laki-laki' : 'Perempuan') : 'Laki-laki / Perempuan' }}</div>
                    </div>

                    <div class="form-row">
                        <div class="form-label">• Alamat</div>
                        <div class="form-value">: {{ $persetujuan->alamat_keluarga ?? '_______________________________________________________________' }}</div>
                    </div>

                    <div class="form-row" style="margin-top: 10px; margin-left: 120px;">
                        <span>No. Telp {{ $persetujuan->no_telp_keluarga ?? '____________________' }}</span>
                        <span style="margin-left: 40px;">No. KTP/SIM : {{ $persetujuan->no_ktp_keluarga ?? '_______________________' }}</span>
                    </div>

                    <div class="form-row">
                        <div class="form-label">• Hubungan dengan pihak yang diwakili</div>
                        <div class="form-value">: {{ $persetujuan->hubungan_keluarga ?? '_______________________________________________' }}</div>
                    </div>
                </div>
            @endif

            <!-- Consent Statement -->
            <div class="consent-statement">
                <p>
                    Telah membaca atau dibacakan keterangan pada <strong>form edukasi transfusi darah</strong> (di halaman belakang) dan telah
                    dijelaskan hal-hal terkait mengenai prosedur transfusi darah yang akan dilakukan terhadap diri saya sendiri /
                    pihak yang saya wakili *), sehingga saya :
                </p>

                <div class="checkbox-list">
                    <div class="checkbox-item">
                        <ul>
                            <li>Memahami alasan saya / pihak yang saya wakili memerlukan darah dan produk darah</li>
                            <li>Memahami risiko yang mungkin terjadi saat atau sesudah pelaksanaan pemberian darah dan produk darah</li>
                            <li>Memahami alternatif pemberian darah dan produk darah</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Decision Section -->
            <div class="decision-section">
                <p><strong>Dan saya menyatakan untuk</strong></p>
                <div style="margin: 15px 0; font-size: 14px;">
                    <span style="margin-right: 40px; {{ $persetujuan->persetujuan === 'setuju' ? 'text-decoration: underline; font-weight: bold;' : '' }}">
                        SETUJU
                    </span>
                    <span>/</span>
                    <span style="margin-left: 40px; {{ $persetujuan->persetujuan === 'tidak_setuju' ? 'text-decoration: underline; font-weight: bold;' : '' }}">
                        TIDAK SETUJU
                    </span>
                    <span style="font-size: 10px;"> *(coret salah satu)</span>
                </div>
                <p><strong>Atas pemberian darah dan produk darah terhadap diri saya sendiri / pihak yang saya wakili.</strong></p>
            </div>

            <!-- Location and Date -->
            <div class="location-date">
                <span class="underline" style="min-width: 150px;">
                    {{ $persetujuan->tanggal ? 'Langsa' : '______________________' }}
                </span>,
                tanggal
                <span class="underline" style="min-width: 200px;">
                    {{ $persetujuan->tanggal ? $persetujuan->tanggal->format('d F Y') : '________________________________' }}
                </span>
                jam
                <span class="underline" style="min-width: 100px;">
                    {{ $persetujuan->jam ? date('H:i', strtotime($persetujuan->jam)) : '_____________' }}
                </span>
            </div>

            <!-- Signatures -->
            <div class="signature-section">
                <div class="signature-row">
                    <div class="signature-cell">
                        <div class="signature-label">Yang menyatakan</div>
                        <div class="signature-box"></div>
                        <div>({{ $persetujuan->yang_menyatakan ?? '_____________________' }})</div>
                    </div>

                    <div class="signature-cell">
                        <div class="signature-label">Dokter</div>
                        <div class="signature-box"></div>
                        <div>({{ $persetujuan->dokter ? ($dokter->where('kd_dokter', $persetujuan->dokter)->first()->nama_lengkap ?? 'Tidak ada dokter dipilih') : 'Tidak ada dokter dipilih' }})</div>
                    </div>

                    <div class="signature-cell">
                        <div class="signature-label">Saksi 1</div>
                        <div class="signature-box"></div>
                        <div>({{ $persetujuan->nama_saksi1 ?? '_____________________' }})</div>
                    </div>

                    <div class="signature-cell">
                        <div class="signature-label">Saksi 2</div>
                        <div class="signature-box"></div>
                        <div>({{ $persetujuan->nama_saksi2 ?? '_____________________' }})</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Page Break untuk halaman 2 -->
        <div class="page-break"></div>

        <!-- Consent Statement -->
        <div class="consent-statement" style="margin-right: 10px; margin-left: 10px;">
            <h3 style="text-align: center">FORM EDUKASI PEMBERIAN DARAH DAN PRODUK DARAH</h3>
            <h5>
                1. APA ITU DARAH DAN PRODUK DARAH?
            </h5>
            <p style="margin-left: 10px;">
                Darah yang mengalir dalam tubuh manusia adalah cairan yang mempunyai banyak kegunaan. Salah satu kegunaannya adalah
                mengantarkan oksigen dan makanan kedalam sel. Untuk itu dari, darah mempunyai banyak komponen yang membuat darah menjadi
                cairan yang kompleks. Sebagai satu kesatuan, darah bisa disebut sebagai darah lengkap atau Whole Blood / WB.
                Darah lengkap ini bisa dipisah menjadi beberapa bagian yang biasa dikenal sebagai komponen darah atau produk darah. Beberapa
                komponen darah yang biasa diberikan adalah :
            </p>
            <ol type="a">
                <li><strong>Sel Darah Merah</strong> atau <strong>Eritrosit</strong> : Sel darah yang membawa oksigen ke dalam sel.</li>
                <li><strong>Sel Darah Putih</strong> atau <strong>Leukosit</strong> : sel darah yang menjaga tubuh dari penyakit infeksi seperti bakteri</li>
                <li><strong>Keping Darah</strong> atau <strong>Trombosit</strong> : Sel darah yang menghentikan perdarahan untuk sementara</li>
                <li><strong>Plasma</strong> : terdiri dari 92% air, 7% protein dan 1 % mineral. Sesuai kebutuhan, plasma dapat menjadi beberapa bagian seperti faktor
                    pembekuan, albumin dan globulin.</li>
            </ol>

            <h5 style="margin-top: 5px;">2. KENAPA ANDA TAHU KELUARGA ANDA MEMBUTUHKAN PEMBERIAN DARAH DAN PRODUK DARAH?</h5>
            <p style="margin-left: 10px">
                Pemberian darah dan produk darah atau yang biasa dikenal sebagai tranfusi darah biasanya perlu dilakukan ketika seseorang mengalami
                suatu hal yang menyebabkan darah atau komponen darah berkurang baik dalam jumlah maupun fungsinya. Salah satu hal yang mungkin
                menyebabkab anda membutuhkan darah adalah pelaksanaan operasi dengan pendarahan yang banyak. Dokter memutuskan untuk
                memberikan darah setelah mempertimbangkan banyak hal seperti keadaan kesehatan anda dan riwayat penyakit yang pernah anda
                derita. Anda bisa menanyakan lebih lanjut mengenai alasan pemberian darah ini kepada dokter yang merawat anda.
            </p>

            <h5 style="margin-top: 5px">3. DARI MANA DARAH YANG DIBERIKAN BERASAL? </h5>
            <p style="margin-left: 10px">
                Darah yang anda terima berasal dari seseorang yang menyumbang darah. Umumnya, darah yang ditransfusi kepada pasien di RSUD dr.
                Kota Langsa adalah darah yang di sumbangkan di Unit Tranfusi Darah PMI Kota Langsa.
            </p>

            <h5 style="margin-top: 5px">4. APA MANFAAT PEMBERIAN DARAH DAN PRODUK DARAH?</h5>
            <p style="margin-left: 10px">
                Darah dan produk darah diberikan dengan maksud untuk menyelamatkan nyawa atau untuk memperbaiki kualitas hidup dari seseorang.
            </p>

            <h5 style="margin-top: 5px">5. APA RESIKO DARI PEMBERIAN DARAH DAN PRODUK DARAH?</h5>
            <p style="margin-left: 10px">
                Seperti umumnya tindakan medik yang lain, pemberian darah dan produk darah mempunyai berbagai resiko. Namun, darah yang diberikan
                telah melalui berbagai proses yang membuat resiko ini menjadi sangat kecil.
                Beberapa resiko yang mungkin terjadi mencakup :
            </p>
            <ol type="a">
                <li>
                    Penularan penyakit menular lewat transfusi darah, seperti HIV, Hepatitis B, Hepatitis C dan sifilis darah yang berasal dari Unit Tranfusi
                    darah PMI Kota Langsa telah melalui proses pemeriksaan terhadap keempat penyakit tersebut diatas. Bila hasil pemeriksaan
                    memperlihatkan adanya kemungkinan didapatkan dari pendonor yang memiliki salah satu dari penyakit ini, maka darah tersebut akan
                    dibuang
                </li>
                <li>
                    Reaksi tranfusi darah ringan dan sementara. <br>
                    Reaksi tranfusi yang ringan dan sementara dapat terjadi pada 1 dari 100 pasien yang mendapat tranfusi. Hal yang biasanya terjadi
                    dapat berupa demam, menggigil atau timbulnya bengkak atau warna kemerahan pada kulit.
                    Beritahu pada dokter apabila hal ini pernah terjadi pada pelaksanaan tranfusi sebelumnya bila hal ini terjadi saat pelaksanaan tranfusi
                </li>
                <li>
                    Alloimunisasi atau pembentukan zat kekebalan atau antibodi. <br>
                    Pada beberapa keadaan, pemberian darah dan produk darah dapat menyebabkan tubuh membuat zat kekebalan atau antibodi
                    terhadap darah yang diberikan. Umumnya hal ini tidak menimbulkan gejala dan tidak membahayakan nyawa pasien. Namun,
                    pemeriksaan tambahan biasanya perlu dilakukan sebelum pelaksanaan pemberian darah dan produk darah berikutnya.
                </li>
            </ol>

            <h5 style="margin-top: 5px">6. KENAPA ANDA HARUS MEMBAYAR UNTUK PEMBERIAN DARAH DAN PRODUK DARAH?</h5>
            <p style="margin-left: 10px">
                Darah diberikan secara Cuma-Cuma atau gratis oleh orang yang menyumbang darah.
                Namun, darah tersebut perlu diolah terlebih dahulu sebelum dapat diberikan kepada pasien pengolahan ini menimbulkan biaya yang biasa
                disebut sebagai biaya pengganti pengolahan darah service cost.
                Beberapa pengolahan yang membutuhkan biaya tersebut mencakup :
            </p>
            <ol type="a">
                <li>Rekruitmen donor atau usaha untuk mencari donor darah sehingga persediaan darah cukup tidak perlu menunggu lama sebelum bias
                    mendapatkan darah.
                </li>
                <li>
                    Proses pendonoran darah yang memerlukan biaya seperti pembelian kantong darah dan pendukung proses pendonoran darah.
                </li>
                <li>
                    Pemeriksaan keadaan darah seperti pemeriksaan terhadap penyakit menular lewat tranfusi pemeriksaan antara dengan donor.
                </li>
            </ol>

            <h5 style="margin-top: 5px">7. APA PILIHAN YANG DAPAT ANDA AMBIL</h5>
            <p style="margin-left: 10px">
                Beberapa pilihan mengenai tranfusi yang dapat anda ambil adalah :
            </p>
            <ol type="a">
                <li>Tranfusi autologus <br>
                    Tranfusi autologus adalah pemberian darah yang diambil dari tubuh pasien sendiri. Cara ini umumnya dapat dilakukan pada pasien
                    yang akan menjalani operasi.
                </li>
                <li>
                    Tranfusi darah dari keluarga <br>
                    Tranfusi darah dari keluarga adalah pemberian darah yang didonorkan oleh keluarga pasien unit. Tranfusi darah PMI Kota Langsa
                    biasanya membutuhkan waktu sekitar 12 jam untuk melakukan pemrosesan darah sebelum pemeriksaan kecocokan antara
                    pasien dan donor bisa dilakukan.
                </li>
                <li>
                    Tidak tranfusi <br>
                    Pilihan ini mempunyai resiko terhadap kesehatan pasien. Diskusikan kemungkinan yang dapat terjadi bila anda menolak pemberian
                    darah dan produk darah dari dokter yang merawat anda.
                </li>
            </ol>

            <h5 style="margin-top: 5px">8. HAL LAIN</h5>
            <p style="margin-left: 10px">
                Anda mempunyai hak untuk menanyakan dan mendiskusikan lebih lanjut mengenai berbagai hal mengenai pemberian darah dan produk
                darah dengan dokter yang merawat anda dan jangan ragu untuk melakukan hal tersebut.
            </p>

        </div>

    </div>
</body>
</html>
