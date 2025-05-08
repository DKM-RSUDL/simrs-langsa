<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan DPJP</title>
    <style>
        @page {
            margin: 1.5cm 1.5cm; /* Mengurangi margin halaman */
            size: A4 portrait;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 11pt; /* Mengurangi ukuran font dasar */
            line-height: 1.3; /* Mengurangi line height */
        }
        
        .container {
            width: 100%;
            position: relative;
        }
        
        /* Header/Kop Surat */
        .header {
            text-align: center;
            position: relative;
            margin-bottom: 5px; /* Mengurangi margin */
        }
        
        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 100px; /* Ukuran logo lebih kecil */
            height: auto;
        }
        
        .kop-text {
            margin-left: 75px;
        }
        
        .rs-name-1 {
            font-size: 13pt;
            font-weight: bold;
            margin: 0;
        }
        
        .rs-name-2 {
            font-size: 13pt;
            font-weight: bold;
            margin: 0;
        }
        
        .rs-address {
            font-size: 9pt;
            margin: 1px 0; /* Mengurangi margin */
        }
        
        .rs-city {
            font-size: 10pt;
            font-weight: bold;
            margin: 1px 0;
        }
        
        .border-line {
            border-bottom: 2px solid black;
            margin-top: 5px;
            margin-bottom: 2px;
        }
        
        .border-line-2 {
            border-bottom: 1px solid black;
            margin-bottom: 10px;
        }
        
        /* Judul */
        .title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0 2px; /* Mengurangi margin */
        }
        
        .subtitle {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            margin: 0 0 10px; /* Mengurangi margin */
        }
        
        /* Content */
        .content {
            margin-bottom: 5px; /* Mengurangi margin */
        }
        
        /* Form Fields */
        p {
            margin: 5px 0; /* Mengurangi margin paragraf */
        }
        
        .form-fields {
            margin-bottom: 10px; /* Mengurangi margin */
        }
        
        .form-field {
            margin-bottom: 3px; /* Mengurangi jarak antar field */
        }
        
        .form-field-label {
            display: inline-block;
            width: 180px; /* Mengurangi lebar label */
            vertical-align: top;
        }
        
        .dotted-line {
            display: inline-block;
            border-bottom: 1px dotted #000;
            width: 300px;
            height: 15px; /* Mengurangi tinggi */
            vertical-align: middle;
            position: relative;
        }
        
        .real-value {
            position: absolute;
            top: -5px;
            left: 5px;
            font-weight: normal;
            font-size: 10pt; /* Ukuran teks isian lebih kecil */
        }
        
        /* Duties List */
        .duties {
            margin: 5px 0; /* Mengurangi margin */
        }
        
        .duty-item {
            margin-bottom: 2px; /* Mengurangi jarak */
            text-align: justify;
        }
        
        .duty-number {
            display: inline-block;
            width: 15px; /* Mengurangi lebar nomor */
            vertical-align: top;
        }
        
        .duty-text {
            display: inline-block;
            width: calc(100% - 20px);
            font-size: 10pt; /* Teks tugas sedikit lebih kecil */
        }
        
        /* Signature */
        .signature {
            text-align: right;
            margin-top: 15px; /* Mengurangi margin */
            margin-right: 40px;
        }
        
        .signature-city {
            margin-bottom: 2px;
            font-size: 10pt;
        }
        
        .signature-title {
            margin-bottom: 30px; /* Ruang untuk tanda tangan */
            font-size: 10pt;
        }
        
        .signature-name {
            width: 180px; /* Mengurangi lebar garis */
            border-bottom: 1px solid #000;
            display: inline-block;
            text-align: center;
            margin-bottom: 2px;
        }
        
        .signature-label {
            font-size: 9pt;
        }
        
        /* Footer */
        .footer {
            font-size: 9pt;
            font-style: italic;
            margin-top: 10px; /* Mengurangi margin */
        }
        
        .doc-number {
            text-align: right;
            font-size: 8pt;
            margin-top: 10px; /* Mengurangi margin */
        }
        
        /* Compact gender and date format */
        .compact-field {
            display: flex;
            align-items: center;
        }
        
        .date-format {
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header/Kop Surat -->
        <div class="header">            
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo-dpjp.png'))) }}" alt="Logo Kota Langsa" class="logo">
            <div class="kop-text">
                <p class="rs-name-1">PEMERINTAH KOTA LANGSA</p>
                <p class="rs-name-2">RUMAH SAKIT UMUM DAERAH LANGSA</p>
                <p class="rs-address">Alamat : Jln. Jend. A. Yani No.1 Kota Langsa – Provinsi Aceh</p>
                <p class="rs-address">Telp. (0641) 21457 – 22800 (IGD) - 21009 (Farmasi) Fax. (0641) 22051</p>
                <p class="rs-address">E-mail : rsudlangsa.aceh@gmail.com, website: www.rsud.langsakota.go.id</p>
                <p class="rs-city">KOTA LANGSA</p>
            </div>
        </div>
        
        <div class="border-line"></div>
        <div class="border-line-2"></div>
        
        <!-- Judul -->
        <div class="title">SURAT PERNYATAAN</div>
        <div class="subtitle">DOKTER PENANGGUNG JAWAB PELAYANAN</div>
        
        <!-- Isi Surat -->
        <div class="content">
            <p>Yang bertanda tangan di bawah ini :</p>
            
            <div class="form-fields">
                <div class="form-field">
                    <span class="form-field-label">Nama</span>
                    <span>: </span>
                    <span class="dotted-line">
                        <span class="real-value">{{ $pernyataanDPJP->dokter->nama_lengkap ?? '' }}</span>
                    </span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">Bidang Kewenangan Klinis</span>
                    <span>: </span>
                    <span class="dotted-line">
                        <span class="real-value">{{ $pernyataanDPJP->dokter->spesialis->spesialisasi->spesialisasi ?? '' }}</span>
                    </span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">SMF</span>
                    <span>: </span>
                    <span class="dotted-line">
                        <span class="real-value">{{ $pernyataanDPJP->dokter->spesialis->spesialisasi->spesialisasi ?? '' }}</span>
                    </span>
                </div>
            </div>
            
            <p>Dengan ini menyatakan bersedia untuk menjadi Dokter Penanggung Jawab Pelayanan (DPJP) atas pasien :</p>
            
            <div class="form-fields">
                <div class="form-field">
                    <span class="form-field-label">Nama</span>
                    <span>: </span>
                    <span class="dotted-line">
                        <span class="real-value">{{ $dataMedis->pasien->nama ?? '' }}</span>
                    </span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">No. Rekam Medis</span>
                    <span>: </span>
                    <span class="dotted-line">
                        <span class="real-value">{{ $dataMedis->pasien->kd_pasien ?? '' }}</span>
                    </span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">Jenis Kelamin</span>
                    <span>:</span>
                    <span class="dotted-line">
                        <span class="real-value">
                    @if(isset($dataMedis->pasien->jenis_kelamin))
                        @if($dataMedis->pasien->jenis_kelamin == 'L')
                            <span class="gender-option">Laki-laki</span>
                        @else
                            <span class="gender-option">Perempuan</span>
                        @endif
                    @endif
                        </span>
                    </span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">Tanggal Lahir</span>
                    <span>:</span>
                    <span class="dotted-line">
                        <span class="real-value">
                            @if(isset($dataMedis->pasien->tgl_lahir))
                                <span class="date-format">{{ date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) }}</span>
                            @endif
                        </span>
                    </span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">Alamat</span>
                    <span>: </span>
                    <span class="dotted-line">
                        <span class="real-value">{{ $dataMedis->pasien->alamat ?? '' }}</span>
                    </span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">Tempat Dirawat</span>
                    <span>: </span>
                    <span class="dotted-line">
                        <span class="real-value">{{ $dataMedis->unit->nama_unit ?? '' }}</span>
                    </span>
                </div>
                
                <div class="form-field">
                    <span class="form-field-label">Diagnosis</span>
                    <span>: </span>
                    <span class="dotted-line">
                        <span class="real-value">{{ $pernyataanDPJP->diagnosis ?? '' }}</span>
                    </span>
                </div>
            </div>
            
            <p>Sesuai kompetensi dan kewenangan klinis yang saya miliki dengan tugas :</p>
            
            <div class="duties">
                <div class="duty-item">
                    <span class="duty-number">1.</span>
                    <span class="duty-text">Melaksanakan asuhan pasien diatas dengan penuh tanggungjawab;</span>
                </div>
                
                <div class="duty-item">
                    <span class="duty-number">2.</span>
                    <span class="duty-text">Bila diperlukan, melakukan konsultasi dengan bidang / kompetensi lain;</span>
                </div>
                
                <div class="duty-item">
                    <span class="duty-number">3.</span>
                    <span class="duty-text">Melaksanakan pembuatan rekam medis dengan lengkap dan benar serta menyerahkannya sesuai aturan yang berlaku.</span>
                </div>
            </div>
            
            <p>Demikian surat pernyataan ini dibuat untuk digunakan sebagaimana mestinya dengan penuh tanggung jawab.</p>
        </div>
        
        <!-- Tanda Tangan -->
        <div class="signature">
            <div class="signature-city">Langsa {{ $tanggalLengkap }}</div>
            <div class="signature-title">Yang membuat pernyataan;</div>
            <br>
            <div class="signature-name">&nbsp;</div>
            <div>({{ $pernyataanDPJP->dokter->nama_lengkap ?? '' }})</div>
        </div>
    </div>
</body>
</html>