<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persetujuan Transfusi Darah</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm;
            size: A4 portrait;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 11pt;
            line-height: 1.3;
        }

        .container {
            width: 100%;
            position: relative;
        }

        /* Header/Kop Surat */
        .header {
            text-align: center;
            position: relative;
            margin-bottom: 15px;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
            height: auto;
        }

        .kop-text {
            margin-left: 90px;
            text-align: center;
        }

        .rs-name {
            font-size: 14pt;
            font-weight: bold;
            margin: 2px 0;
        }

        .rs-address {
            font-size: 9pt;
            margin: 1px 0;
        }

        .doc-number {
            font-size: 8pt;
            margin-top: 5px;
            text-align: right;
        }

        .border-line {
            border-bottom: 2px solid black;
            margin-top: 10px;
            margin-bottom: 2px;
        }

        .border-line-2 {
            border-bottom: 1px solid black;
            margin-bottom: 15px;
        }

        /* Judul */
        .title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 15px 0 20px;
        }

        /* Content */
        .content {
            margin-bottom: 15px;
        }

        /* Patient Info Box */
        .patient-info {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .patient-info-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .patient-row {
            margin-bottom: 5px;
        }

        .patient-row .label {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }

        .patient-row .value {
            display: inline-block;
        }

        /* Form Fields */
        .form-section {
            margin-bottom: 15px;
        }

        .form-field {
            margin-bottom: 8px;
        }

        .form-field-label {
            display: inline-block;
            width: 150px;
            vertical-align: top;
        }

        .dotted-line {
            display: inline-block;
            border-bottom: 1px dotted #000;
            width: 350px;
            height: 15px;
            vertical-align: middle;
            position: relative;
        }

        .filled-value {
            position: absolute;
            top: -8px;
            left: 5px;
            font-weight: normal;
            font-size: 10pt;
            background: white;
            padding: 0 2px;
        }

        /* Checkbox styles */
        .checkbox-group {
            margin: 10px 0;
        }

        .checkbox-item {
            margin-bottom: 5px;
        }

        .checkbox {
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            display: inline-block;
            text-align: center;
            line-height: 12px;
            margin-right: 5px;
            font-size: 8pt;
        }

        .checkbox.checked {
            background-color: #000;
            color: white;
        }

        /* Agreement section */
        .agreement-section {
            margin: 15px 0;
            text-align: center;
        }

        .agreement-options {
            font-size: 12pt;
            font-weight: bold;
            margin: 10px 0;
        }

        .agreement-option {
            margin: 0 10px;
        }

        .agreement-option.selected {
            text-decoration: underline;
        }

        .agreement-option.not-selected {
            text-decoration: line-through;
        }

        /* Signature section */
        .signature-section {
            margin-top: 30px;
        }

        .signature-date {
            text-align: center;
            margin-bottom: 20px;
        }

        .signature-row {
            display: table;
            width: 100%;
            margin-top: 20px;
        }

        .signature-cell {
            display: table-cell;
            width: 25%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 50px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 150px;
            margin: 0 auto 5px;
            height: 1px;
        }

        .signature-name {
            font-size: 9pt;
            margin-top: 5px;
        }

        /* Footer */
        .footer {
            font-size: 8pt;
            margin-top: 20px;
            text-align: center;
        }

        /* Utility classes */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .small-text {
            font-size: 9pt;
        }

        /* Family section */
        .family-section {
            margin: 15px 0;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .family-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .family-field {
            margin-bottom: 5px;
        }

        .family-field .label {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }

        .family-field .value {
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header/Kop Surat -->
        <div class="header">
            @if(file_exists(public_path('assets/img/logo-langsa.png')))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo-langsa.png'))) }}"
                    alt="Logo RSUD Langsa" class="logo">
            @endif
            <div class="kop-text">
                <p class="rs-name">RSUD LANGSA</p>
                <p class="rs-address">Jl. Jend. A. Yani No. 1</p>
                <p class="rs-address">Telp: 0641- 22051 Kota Langsa</p>
            </div>
            <div class="doc-number">NO: F.3/IRM/Rev 0/2017</div>
        </div>

        <div class="border-line"></div>
        <div class="border-line-2"></div>

        <!-- Patient Info Box -->
        <div class="patient-info">
            <div class="patient-info-title">NRM</div>
            <div class="patient-row">
                <span class="label">Nama</span>
                <span class="value">: {{ $dataMedis->pasien->nama ?? '-' }}</span>
            </div>
            <div class="patient-row">
                <span class="label">Jenis Kelamin</span>
                <span class="value">: {{ $dataMedis->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }} *</span>
            </div>
            <div class="patient-row">
                <span class="label">Tanggal Lahir</span>
                <span class="value">: {{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : '-' }}</span>
            </div>
            <div class="small-text" style="margin-top: 5px;">(mohon diisi atau tempelkan stiker jika ada)</div>
        </div>

        <!-- Judul -->
        <div class="title">PERSETUJUAN TRANSFUSI DARAH/ PRODUK DARAH</div>

        <!-- Content -->
        <div class="content">
            <!-- Basic Patient Info -->
            <div class="form-section">
                <div class="form-field">
                    <span class="form-field-label">Nama Pasien</span>
                    <span class="dotted-line">
                        <span class="filled-value">{{ $dataMedis->pasien->nama ?? '' }}</span>
                    </span>
                    <span style="margin-left: 20px;">No. Rekam Medik</span>
                    <span class="dotted-line" style="width: 150px;">
                        <span class="filled-value">{{ $dataMedis->pasien->no_rm ?? '' }}</span>
                    </span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">Tanggal lahir</span>
                    <span class="dotted-line">
                        <span class="filled-value">{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : '' }}</span>
                    </span>
                    <span style="margin-left: 20px;">Jenis Kelamin</span>
                    <span style="margin-left: 10px;">: {{ $dataMedis->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">Diagnosa</span>
                    <span class="dotted-line">
                        <span class="filled-value">{{ $persetujuan->diagnosa ?? '' }}</span>
                    </span>
                </div>
            </div>

            <!-- Declarant Info -->
            <div class="form-section">
                <p><strong>Saya yang bertanda tangan di bawah ini,</strong></p>
                
                @if($persetujuan->persetujuan_untuk === 'keluarga')
                    <!-- Family Info -->
                    <div class="family-section">
                        <div class="family-field">
                            <span class="label">Nama</span>
                            <span class="dotted-line">
                                <span class="filled-value">{{ $persetujuan->nama_keluarga ?? '' }}</span>
                            </span>
                        </div>
                        
                        <div class="family-field">
                            <span class="label">Tanggal lahir</span>
                            <span class="dotted-line">
                                <span class="filled-value">{{ $persetujuan->tgl_lahir_keluarga ? $persetujuan->tgl_lahir_keluarga->format('d/m/Y') : '' }}</span>
                            </span>
                            <span style="margin-left: 20px;">Jenis Kelamin</span>
                            <span style="margin-left: 10px;">: {{ $persetujuan->jk_keluarga == 1 ? 'Laki-laki' : 'Perempuan' }}</span>
                        </div>
                        
                        <div class="family-field">
                            <span class="label">Alamat</span>
                            <span class="dotted-line">
                                <span class="filled-value">{{ $persetujuan->alamat_keluarga ?? '' }}</span>
                            </span>
                        </div>
                        
                        <div class="family-field">
                            <span class="label">No. Telp</span>
                            <span class="dotted-line" style="width: 150px;">
                                <span class="filled-value">{{ $persetujuan->no_telp_keluarga ?? '' }}</span>
                            </span>
                            <span style="margin-left: 20px;">No. KTP/SIM</span>
                            <span class="dotted-line" style="width: 150px;">
                                <span class="filled-value">{{ $persetujuan->no_ktp_keluarga ?? '' }}</span>
                            </span>
                        </div>
                        
                        <div class="family-field">
                            <span class="label">Hubungan dengan pihak yang diwakili</span>
                            <span class="dotted-line">
                                <span class="filled-value">{{ $persetujuan->hubungan_keluarga ?? '' }}</span>
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Education Info -->
            <div class="form-section">
                <p>Telah membaca atau dibacakan keterangan pada <strong>form edukasi transfusi darah</strong> (di halaman belakang) dan telah dijelaskan hal-hal terkait mengenai prosedur transfusi darah yang akan dilakukan terhadap diri saya sendiri / pihak yang saya wakili *), sehingga saya :</p>
                
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <span class="checkbox checked">✓</span>
                        <span>Memahami alasan saya / pihak yang saya wakili memerlukan darah dan produk darah</span>
                    </div>
                    <div class="checkbox-item">
                        <span class="checkbox checked">✓</span>
                        <span>Memahami risiko yang mungkin terjadi saat atau sesudah pelaksanaan pemberian darah dan produk darah</span>
                    </div>
                    <div class="checkbox-item">
                        <span class="checkbox checked">✓</span>
                        <span>Memahami alternatif pemberian darah dan produk darah</span>
                    </div>
                </div>
            </div>

            <!-- Agreement -->
            <div class="agreement-section">
                <p><strong>Dan saya menyatakan untuk</strong></p>
                <div class="agreement-options">
                    @if($persetujuan->persetujuan === 'setuju')
                        <span class="agreement-option selected">SETUJU</span> / <span class="agreement-option not-selected">TIDAK SETUJU</span>
                    @else
                        <span class="agreement-option not-selected">SETUJU</span> / <span class="agreement-option selected">TIDAK SETUJU</span>
                    @endif
                    <span class="small-text">*(coret salah satu)</span>
                </div>
                <p><strong>Atas pemberian darah dan produk darah terhadap diri saya sendiri / pihak yang saya wakili.</strong></p>
            </div>

            <!-- Signature Section -->
            <div class="signature-section">
                <div class="signature-date">
                    <span class="dotted-line" style="width: 150px;">
                        <span class="filled-value">Langsa</span>
                    </span>,
                    tanggal
                    <span class="dotted-line" style="width: 200px;">
                        <span class="filled-value">{{ $persetujuan->tanggal ? $persetujuan->tanggal->format('d/m/Y') : '' }}</span>
                    </span>
                    jam
                    <span class="dotted-line" style="width: 100px;">
                        <span class="filled-value">{{ $persetujuan->jam ? date('H:i', strtotime($persetujuan->jam)) : '' }}</span>
                    </span>
                </div>

                <div class="signature-row">
                    <div class="signature-cell">
                        <div class="signature-title">Yang menyatakan</div>
                        <div class="signature-line"></div>
                        <div class="signature-name">({{ $persetujuan->yang_menyatakan ?? '' }})</div>
                    </div>
                    <div class="signature-cell">
                        <div class="signature-title">Dokter</div>
                        <div class="signature-line"></div>
                        <div class="signature-name">({{ $persetujuan->dokter->nama_lengkap ?? '' }})</div>
                    </div>
                    <div class="signature-cell">
                        <div class="signature-title">Saksi 1</div>
                        <div class="signature-line"></div>
                        <div class="signature-name">({{ $persetujuan->nama_saksi1 ?? '' }})</div>
                    </div>
                    <div class="signature-cell">
                        <div class="signature-title">Saksi 2</div>
                        <div class="signature-line"></div>
                        <div class="signature-name">({{ $persetujuan->nama_saksi2 ?? '' }})</div>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="footer">
                <p>*) coret pada pernyataan yang tidak sesuai</p>
                <p style="text-align: left; margin-top: 30px;">
                    <strong>Untuk Edukasi/Informasi ada di halaman belakang</strong>
                    <span style="float: right;"><strong>NO: F.3/IRM/Rev 0/2017</strong></span>
                </p>
            </div>
        </div>
    </div>
</body>

</html>