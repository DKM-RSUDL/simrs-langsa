<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>General Consent - {{ $dataMedis->pasien->nama ?? 'Pasien' }}</title>
    <style>
        @page {
            margin: 20px 60px;
            size: 21cm 29.7cm;
        }

        body {
            font-family: sans-serif;
            font-size: 11pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header-container {
            width: 100%;
            margin-bottom: 12px;
            padding-bottom: 10px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            padding: 0;
        }

        .logo-cell {
            width: 180px;
            text-align: center;
        }

        .logo-cell img {
            width: 60px;
            height: auto;
        }

        .header-content {
            text-align: center;
            padding-right: 40px;

        }
        
        .header-title {
            font-size: 12pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .header-title-top {
            margin-top: 30px;
        }

        .header-subtitle {
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .header-rs-name {
            font-size: 10pt;
            margin: 2px;
            padding: 0;
            font-weight: bold;
            line-height: 1.0;
        }

        .header-address {
            font-size: 8pt;
            margin: 2px;
            padding: 0;
            line-height: 1.0;
        }

        /* Document Title */
        .title {
            font-size: 12pt;
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 0;
        }

        .section-subtitle {
            margin-left: 20px;
            margin-top: 0;
        }

        .section-subtitle-sub {
            text-indent: 2em; 
        }

        .section-subtitle-1 {
            margin-left: 20px;
        }

        .check-container {
            display: flex;
        }

        .doc-number {
            font-size: 10pt;
            text-align: center;
            margin-bottom: 5px;
            font-style: bold;
            font-weight: bold;
        }

        /* Content Styling */
        .content p {
            text-align: justify;
            margin: 4px 0;
            font-size: 12pt;
        }

        /* Patient Data Table */
        .patient-info {
            width: 100%;
            margin: 10px 0;
        }
        
        .patient-data {
            width: 100%;
            margin: 5px 0 5px 50px;
            border-collapse: collapse;
        }

        .patient-data td {
            padding: 3px 0;
            vertical-align: top;
            font-size: 12pt;
        }

        .patient-data td:first-child {
            width: 120px;
            padding-left: 15px;
        }

        .patient-data td:nth-child(2) {
            width: 10px;
            text-align: center;
        }

        .patient-data td:nth-child(3) {
            padding-left: 5px;
        }

        /* Diagnosis Table */
        .diagnosis-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            margin: 15px 0;
        }

        .diagnosis-table th,
        .diagnosis-table td {
            border: 1px solid black;
            padding: 3px 5px;
            font-size: 10pt;
            vertical-align: top;
        }

        .diagnosis-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Signature Section */
        .signature {
            margin-top: 15px;
            text-align: right;
            font-size: 10pt;
        }

        .signature p {
            margin: 2px 0;
        }

        .signature-line {
            margin-top: 50px;
            width: 150px;
            display: inline-block;
        }

        /* Footer */
        .footer {
            font-size: 7pt;
            text-align: left;
            position: fixed;
            bottom: 10px;
            left: 10px;
            width: 100%;
        }

        .checkbox{
            display:inline-block; width:12px; height:12px;
            border:1px solid #000; line-height:12px; text-align:center;
            font-size:20pt; margin-right:6px;
        }
        .checkbox.checked::before{ content:"✓"; } /* atau "\2713" */

        /* Additional styles for inline cleanup */
        .patient-info-table {
            width: 100%;
        }

        .patient-info-table td:first-child {
            width: 120px;
        }

        .patient-info-table td:nth-child(2) {
            width: 10px;
        }

        .patient-info-table td:nth-child(4) {
            white-space: nowrap;
        }

        .patient-info-nowrap {
            white-space: nowrap;
        }

        .info-table {
            margin-left: 20px; 
            width: 90%; 
            border-collapse: collapse;
        }

        .info-table td:nth-child(2) {
            text-align: right;
        }

        .info-table td:nth-child(3) {
            text-align: left;
        }

        .dejavu-checkbox {
            font-family: 'DejaVu Sans', sans-serif; 
        }

        .section-bold {
            font-weight: bold;
        }

        .checkmark-symbol {
            display: inline-block;
            width: 14px; 
            height: 14px;
            font-size: 14pt;
            font-family: DejaVu Sans;
            line-height: 14px;
        }

        .signature-table {
            width: 100%; 
            margin-top: 20px; 
            margin-bottom: 20px;
        }

        .signature-table-bottom {
            margin-left: 20px; 
            width: 90%; 
            border-collapse: collapse; 
            margin-top: 20px;
        }

        .signature-center-60 {
            text-align: center; 
            width: 60%;
        }

        .signature-center-40 {
            text-align: center; 
            width: 40%;
        }

        .signature-right {
            text-align: right;
        }

        .signature-inline-center {
            display: inline-block; 
            text-align: center;
        }

        .date-time-small {
            font-size: 10px;
        }

        /* Ordered list styling */
        ol {
            padding-left: 20px;
            margin-top: 0;
            margin-bottom: 0;
        }

        ol li {
            margin: 4px 0;
            text-align: justify;
            font-size: 12pt;
        }

        ol ol {
            list-style-type: lower-alpha;
            padding-left: 25px;
        }

        .strikethrough {
            text-decoration: line-through;
        }
    </style>
</head>
<body>
     <!-- Header with Logo -->
    <div class="header-container">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}"
                    alt="Logo RSUD Langsa">
                    <p class="header-rs-name">RSUD LANGSA</p>
                     <p class="header-address">Jl. Jend. A. Yani. Kota Langsa</p>
                    <p class="header-address">Telp: 0641- 22051</p>
                    <p class="header-address">email: rsudlangsa.aceh@gmail.com</p>
                
                </td>
                <td class="header-content">
                    <p class="header-title header-title-top">PERSETUJUAN UMUM (GENERAL CONCENT)</p>
                    <p class="header-title">UNTUK MENDAPATKAN PELAYANAN KESEHATAN</p>
                    <p class="header-title">DI RSUD KOTA LANGSA</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Document Title -->
     <div>
        <div class="title">PASIEN DAN/ATAU WALI DIMINTA</div>
        <div class="title">MEMBACA, MEMAHAMI DAN MENGISI INFORMASI BERIKUT</div>
    </div>

    <div class="patient-info">
        <table class="patient-info-table">
            <tr>
                <td>Nama Pasien</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->tgl_lahir ? date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td colspan="4">{{ $dataMedis->pasien->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td>No. Telp</td>
                <td>:</td>
                <td colspan="4">{{ $dataMedis->pasien->telepon ?? '-' }}</td>
            </tr>
            <tr>
                 <td colspan="4" class="patient-info-nowrap">Selaku Pasien/Keluarga Pasien RSUD Kota Langsa, dengan ini menyatakan persetujuan:</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <div class="section">
            <div class="section-title">I. PERSETUJUAN UNTUK PERAWATAN DAN PENGOBATAN</div>
            <div class="section-subtitle">
                <ol>
                    <li>Saya mengetahui bahwa saya memiliki kondisi yang membutuhkan perawatan medis, saya mengizinkan dokter dan profesional kesehatan lainnya untuk melakukan prosedur diagnostik dan untuk memberikan pengobatan medis seperti yang diperlukan dalam penilaian profesional mereka. Prosedur diagnostik dan perawatan medis termasuk terapi tidak terbatas pada electrocardiograms, x-ray, tes darah, terapi fisik, dan pemberian obat.</li>
                    <li>Saya sadar bahwa praktik kedokteran bukanlah ilmu pasti dan saya mengakui bahwa tidak ada jaminan atas hasil apapun terhadap perawatan prosedur atau pemeriksaan apapun yang dilakukan terhadap saya.</li>
                    <li>Saya mengerti dan memahami bahwa
                        <ol>
                            <li>Saya memiliki hak untuk mengajukan pertanyaan tentang pengobatan yang diusulkan (termasuk identitas setiap orang yang memberikan atau mengamati pengobatan) setiap saat.</li>
                            <li>Saya mengerti dan memahami bahwa saya memiliki hak untuk menyetujui atau menolak setiap prosedur medis dan/atau terapi.</li>
                            <li>Saya mengerti bahwa RSUD Langsa merupakan rumah sakit yang menyelenggarakan pendidikan dan praktik klinik bagi mahasiswa kedokteran dan tenaga profesional lainnya dan saya bersedia berpartisipasi dan terlibat dalam perawatan dan pengembangan ilmu pengetahuan dibawah supervisi dokter penanggungjawab pelayanan (DPJP).</li>
                        </ol>
                    </li>
                </ol>
            </div>
        </div>

        <div class="section">
            <div class="section-title">II. BARANG–BARANG MILIK PASIEN</div>
            <div class="section-subtitle section-subtitle-sub">
                <p>Rumah Sakit Umum Daerah Langsa tidak memperkenankan pasien/keluarga membawa barang-barang berharga yang tidak diperlukan ke ruang rawat inap. Pasien yang tidak memiliki keluarga/ tidak mampu untuk melindungi barang-barangnya, atau tidak mampu membuat keputusan mengenai barang pribadinya, RSUD Langsa menyediakan tempat penitipan barang pada pos satpam sesuai dengan peraturan penyimpanan barang milik pasien di RSUD Langsa</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">III. PERSETUJUAN PELEPASAN INFORMASI</div>
            <div class="section-subtitle">
                <ol>
                    <li>Saya memahami informasi yang ada didalam diri saya termasuk Diagnosis, hasil laboratorium, dan hasil tes diagnostik yang akan digunakan untuk perawatan medis. Rumah Sakit Umum Langsa akan menjamin kerahasiannya.</li>
                    <li>Saya memberi wewenang kepada Rumah Sakit untuk memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan bila diperlukan untuk memproses klaim asuransi/BPJS/Jasaraharja/ perusahaan dan atau lembaga pemerintah.</li>
                    <li>Saya memberi wewenang kepada RSUD Langsa untuk memberikan informasi tentang diagnosis, hasil pelayanan dan pengobatan saya kepada:</li>
                </ol>
            </div>
            @if($generalConsent->info_nama_1 || $generalConsent->info_nama_2 || $generalConsent->info_nama_3)
            <div style="margin-left: 20px;">
                <table class="info-table">
                    <tbody>
                        @if($generalConsent->info_nama_1)
                        <tr>
                            <td>{{ $generalConsent->info_nama_1 }}</td>
                            <td>hubungan dengan pasien:</td>
                            <td>{{ $generalConsent->info_hubungan_pasien_1_name ?? '-' }}</td>
                        </tr>
                        @endif
                        @if($generalConsent->info_nama_2)
                        <tr>
                            <td>{{ $generalConsent->info_nama_2 }}</td>
                           <td>hubungan dengan pasien:</td>
                            <td>{{ $generalConsent->info_hubungan_pasien_2_name ?? '-' }}</td>
                        </tr>
                        @endif
                        @if($generalConsent->info_nama_3)
                        <tr>
                            <td>{{ $generalConsent->info_nama_3 }}</td>
                            <td>hubungan dengan pasien:</td>
                            <td>{{ $generalConsent->info_hubungan_pasien_3_name ?? '-' }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @endif

        </div>

        <div class="section">
            <div class="section-title">IV. HAK DAN TANGGUNG JAWAB PASIEN</div>
            <div class="section-subtitle">
                <ol>
                    <li>Saya memiliki hak untuk mengambil bagian dalam keputusan mengenai penyakit saya dan dalam hal perawatan medis dan rencana pengobatan.</li>
                    <li>Saya telah mendapat informasi tentang "HAK DAN TANGGUNG JAWAB PASIEN" di Rumah Sakit Umum Langsa melalui <strong>leaflet dan banner</strong> yang disediakan oleh petugas.</li>
                </ol>
            </div>
        </div>

        <div class="section">
            <div class="section-title">V. KEINGINAN PRIVASI PASIEN</div>
            <div class="section-subtitle">
                <ol>
                    <li>Saya 
                        @if($generalConsent->setuju_akses_privasi == 1)
                            <strong>mengijinkan</strong>
                        @else
                            <strong>tidak mengijinkan</strong>
                        @endif
                        Rumah Sakit memberi akses bagi: keluarga dan handai taulan serta orang-orang yang akan menjenguk saya. {{ $generalConsent->akses_privasi_keterangan ?? '.......................' }}
                    </li>
                    <li>Saya 
                        @if($generalConsent->setuju_privasi_khusus == 1)
                            <strong>menginginkan</strong>
                        @else
                            <strong>tidak menginginkan</strong>
                        @endif
                        privasi khusus. {{ $generalConsent->privasi_khusus_keterangan ?? '.......................' }}
                    </li>
                </ol>
            </div>
        </div>

        <div class="section">
            <div class="section-title">VI. INFORMASI RAWAT INAP</div>
            <div class="section-subtitle section-subtitle-sub">
                <p>Saya telah menerima informasi tentang peraturan yang diberlakukan oleh rumah sakit dan saya beserta keluarga bersedia untuk mematuhinya, termasuk akan mematuhi jam berkunjung pasien sesuai dengan aturan di rumah sakit.</p>
            </div>
            <div class="section-subtitle">
                <p><strong>Tambahan:</strong> {{ $generalConsent->rawat_inap_keterangan ?? '-' }}</p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">VII. INFORMASI BIAYA*</div>
                <div class="section-subtitle section-subtitle-sub">
                    <p>Saya menyatakan setuju sebagai pasien dengan status:</p>
                </div>
                <div class="section-subtitle">
                    <ol style="list-style-type: lower-alpha;">
                        <li><span class="checkbox dejavu-checkbox">{{ $generalConsent->biaya_status == 1 ? '✓' : '' }}</span> <span class="section-bold">STATUS UMUM</span> dengan membayar total biaya perawatan sesuai dengan rincian dan ketentuan RSUD Langsa.</li>
                        <li><span class="checkbox dejavu-checkbox">{{ $generalConsent->biaya_status == 2 ? '✓' : '' }}</span><span class="section-bold">DITANGGUNG PENJAMIN (*{{ $dataMedis->customer->customer ?? 'BPJS/PLN/JASA-RAHARJA' }})</span> dengan segera melengkapi persyaratan administrasi menurut ketentuan penjamin dan/atau peraturan yang berlaku (3×24 jam).</li>
                        <li>Apabila saya tidak melengkapi persyaratan pada batas waktu yang ditentukan penjamin dan/atau peraturan yang berlaku maka saya bersedia membayar seluruh biaya perawatan yang timbul selama saya dirawat di RSUD Kota Langsa.</li>
                    </ol>
                </div>

           <div class="signature-section header-content">
                <table class="signature-table">
                    <tr>
                        <td></td>
                        <td class="signature-right">
                            <div class="signature-inline-center">
                                <div>Tanda Tangan Petugas</div>
                                <div class="signature-line"></div>
                                <div>{{ $generalConsent->user->name ?? '-' }}</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-subtitle">
                <p>Dengan tanda tangan saya dibawah ini,saya menyatakan bahwa saya telah membaca dan memahami item pada Persetujuan Umum/General Consent</p>
            </div>
        </div>

        <div class="signature-section">
          <table class="signature-table-bottom">
                <tr>
                    <td class="signature-center-60">
                        <div>Tanda tangan dan nama pasien/keluarga<br /> (wali jika pasien < 18 tahun)</div>
                        <div class="signature-line"></div>
                        <div>{{ $generalConsent->pj_nama ?? '-' }}</div>
                        <div>
                            <div class="date-time-small">Tgl: {{ $generalConsent->tanggal ? date('d/m/Y', strtotime($generalConsent->tanggal)) : '-' }}</div>
                            <div class="date-time-small">Pukul: {{ $generalConsent->jam ? date('H:i', strtotime($generalConsent->jam)) : '-' }}</div>
                        </div>
                    </td>
                     <td class="signature-center-40">
                        <div>Saksi</div>
                        <div class="signature-line"></div>
                        <div>{{ $generalConsent->saksi_nama ?? '-' }}</div>
                        <div>
                            <div class="date-time-small">Tgl: {{ $generalConsent->tanggal ? date('d/m/Y', strtotime($generalConsent->tanggal)) : '-' }}</div>
                            <div class="date-time-small">Pukul: {{ $generalConsent->jam ? date('H:i', strtotime($generalConsent->jam)) : '-' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>