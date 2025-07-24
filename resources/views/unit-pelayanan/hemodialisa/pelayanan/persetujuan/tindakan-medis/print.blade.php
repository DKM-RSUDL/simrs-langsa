<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form Persetujuan Tindakan Medis</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 20mm 15mm 20mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .header-row {
            display: table-row;
        }

        .hospital-info {
            display: table-cell;
            vertical-align: top;
            width: 30%;
            text-align: left;
        }

        .title-section {
            display: table-cell;
            vertical-align: top;
            width: 40%;
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            padding: 8px;
            line-height: 1.3;
        }

        .patient-info-cell {
            display: table-cell;
            vertical-align: top;
            width: 30%;
            text-align: right;
        }

        .hospital-info img {
            width: 50px;
            height: auto;
            vertical-align: middle;
            margin-right: 8px;
        }

        .hospital-info .info-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 10pt;
        }

        .hospital-info .info-text .title {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .hospital-info .info-text p {
            margin: 0;
            line-height: 1.2;
        }

        .patient-info-box {
            display: inline-block;
            text-align: left;
            border: 1px solid #000;
            padding: 8px;
            font-size: 10pt;
            width: 180px;
            box-sizing: border-box;
        }

        .patient-info-box p {
            margin: 0;
            line-height: 1.3;
            margin-bottom: 2px;
        }

        .content-section {
            margin: 15px 0;
        }

        .section-title {
            font-size: 11pt;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .form-group {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .form-label {
            width: 120px;
            display: inline-block;
            font-size: 10pt;
        }

        .form-input {
            flex: 1;
            padding: 2px 5px;
            min-height: 16px;
            background: transparent;
            border: none; /* Menghilangkan garis bawah */
        }

        .procedure-list {
            margin: 15px 0;
            padding-left: 0;
        }

        .procedure-list p {
            margin: 8px 0;
            font-size: 10pt;
            line-height: 1.4;
        }

        .procedure-item {
            margin: 6px 0;
            font-size: 10pt;
            padding-left: 20px;
        }

        .consent-text {
            text-align: justify;
            margin: 15px 0;
            font-size: 10pt;
            line-height: 1.4;
        }

        .signature-section {
            margin-top: 40px; /* Increased space between text and signature section */
        }

        /* Precise alignment for signature blocks */
        .signature-block {
            display: inline-block;
            text-align: center;
            width: 49%;
            vertical-align: top;
            padding-top: 5px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin-top: 60px;
            width: 200px; /* Adjust width for better alignment */
            display: inline-block;
        }

        .bold {
            font-weight: bold;
        }

        hr {
            border: 0.5px solid #000; 
            margin-top: 5px; 
            margin-bottom: 10px;
        }

        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 200px;
            margin-left: 10px;
        }

        .filled-data {
            font-weight: normal;
            text-decoration: none;
        }

        @media print {
            body {
                font-family: Arial, sans-serif;
            }
            
            .form-input {
                border-bottom: 1px solid #000;
            }
            
            .signature-line {
                border-bottom: 1px solid #000;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER SECTION -->
    <div class="header">
        <div class="header-row">
            <div class="hospital-info">
                @if (isset($logoPath) && file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo RSUD Langsa">
                @else
                    <div style="width: 50px; height: 50px; background: #e0e0e0; border: 1px solid #999; display: inline-block; vertical-align: middle; margin-right: 8px; text-align: center; line-height: 50px; font-size: 8pt; color: #666;">LOGO</div>
                @endif
                <div class="info-text">
                    <p class="title">RSUD LANGSA</p>
                    <p>Jl. Jend. A. Yani Kota Langsa</p>
                    <p>Telp. 0641 - 32051</p>
                    <p>rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="title-section">
                PERSETUJUAN TINDAKAN MEDIS
            </div>
            <div class="patient-info-cell">
                <div class="patient-info-box">
                    <p><b>NO RM: {{ $dataMedis->kd_pasien ?? 'N/A' }}</b></p>
                    <p>Nama: {{ $dataMedis->pasien->nama ?? 'N/A' }}</p>
                    <p>Jenis Kelamin:
                        {{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : 'N/A') }}
                    </p>
                    <p>Tgl Lahir:
                        {{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : 'N/A' }}
                    </p>
                    <p>Umur: {{ $dataMedis->pasien->umur ?? 'N/A' }} Tahun</p>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <!-- MAIN CONTENT -->
    <div class="content-section">
        <div class="section-title">
            Saya yang bertanda tangan di bawah ini:
        </div>

        @if($dataPersetujuan->tipe_penerima == 'pasien')
            <!-- Data Pasien -->
            <div class="form-group">
                <span class="form-label">Nama</span>
                <span class="form-input filled-data"> : {{ $dataMedis->pasien->nama ?? '________________________' }}</span>
            </div>

            <div class="form-group">
                <span class="form-label">Tempat/Tgl lahir</span>
                <span class="form-input filled-data">
                    : {{ $dataMedis->pasien->tempat_lahir ?? '' }}{{ $dataMedis->pasien->tempat_lahir && $dataMedis->pasien->tgl_lahir ? ', ' : '' }}{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : '________________________' }}
                </span>
            </div>

            <div class="form-group">
                <span class="form-label">Jenis Kelamin</span>
                <span class="form-input filled-data">
                    : {{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : '________________________') }}
                </span>
            </div>

            <div class="form-group">
                <span class="form-label">Alamat rumah</span>
                <span class="form-input filled-data"> : {{ $dataMedis->pasien->alamat ?? '________________________' }}</span>
            </div>
        @else
            <!-- Data Keluarga -->
            <div class="form-group">
                <span class="form-label">Nama</span>
                <span class="form-input filled-data"> : {{ $dataPersetujuan->nama_keluarga ?? '________________________' }}</span>
            </div>

            <div class="form-group">
                <span class="form-label">Tempat/Tgl lahir</span>
                <span class="form-input filled-data">
                    : {{ $dataPersetujuan->tempat_tgl_lahir_keluarga ?? '________________________' }}</span>
            </div>

            <div class="form-group">
                <span class="form-label">Jenis Kelamin</span>
                <span class="form-input filled-data">
                    : {{ $dataPersetujuan->jk_keluarga == 'L' ? 'Laki-laki' : ($dataPersetujuan->jk_keluarga == 'P' ? 'Perempuan' : '________________________') }}
                </span>
            </div>

            <div class="form-group">
                <span class="form-label">Hubungan keluarga</span>
                <span class="form-input filled-data"> : {{ $dataPersetujuan->status_keluarga ?? '________________________' }}</span>
            </div>

            <div class="form-group">
                <span class="form-label">Alamat rumah</span>
                <span class="form-input filled-data"> : {{ $dataPersetujuan->alamat_keluarga ?? '________________________' }}</span>
            </div>
        @endif

        <div class="procedure-list">
            <p>Telah menginginkan dan tidak keberatan untuk dilakukan tindakan-tindakan yang berhubungan dengan:</p>
            
            @php
                $tindakanList = $dataPersetujuan->tindakan ? json_decode($dataPersetujuan->tindakan, true) : [];
                $allTindakan = [
                    'hemodialisis' => 'HEMODIALISIS',
                    'akses_vascular_fmoralis' => 'AKSES VASCULAR FMORALIS', 
                    'akses_vascular_subclavicula' => 'AKSES VASCULAR SUBCLAVICULA CATHETER',
                    'akses_vascular_cimino' => 'AKSES VASCULAR ANTERIOR VENOUS FISTULA (CIMINO)'
                ];
            @endphp

            @foreach($allTindakan as $key => $label)
                <div class="procedure-item">
                    {{ $loop->iteration }}. {{ $label }}
                </div>
            @endforeach
        </div>

        <div class="consent-text">
            Serta memahami segala resiko yang mungkin terjadi akibat dilakukannya tindakan tersebut di atas dan menyerahkan seluruh wewenang kepada dokter RSUD Langsa terhadap diri saya/keluarga saya yaitu:
        </div>

        <!-- Data Pasien yang akan menjalani tindakan -->
        <div class="form-group">
            <span class="form-label">Nama</span>
            <span class="form-input filled-data"> : {{ $dataMedis->pasien->nama ?? '________________________' }}</span>
        </div>

        <div class="form-group">
            <span class="form-label">Tempat/Tgl lahir</span>
            <span class="form-input filled-data">
                : {{ $dataMedis->pasien->tempat_lahir ?? '' }}{{ $dataMedis->pasien->tempat_lahir && $dataMedis->pasien->tgl_lahir ? ', ' : '' }}{{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : '________________________' }}
            </span>
        </div>

        <div class="form-group">
            <span class="form-label">Jenis Kelamin</span>
            <span class="form-input filled-data">
                : {{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : '________________________') }}
            </span>
        </div>

        <div class="form-group">
            <span class="form-label">Alamat rumah</span>
            <span class="form-input filled-data"> : {{ $dataMedis->pasien->alamat ?? '________________________' }}</span>
        </div>

        <div class="consent-text">
            Demikian persetujuan ini dibuat tanpa paksaan dan tekanan dari siapapun dan untuk digunakan sebagaimana mestinya.
        </div>

        <div class="signature-section">
            <div class="signature-block">
                <p>Langsa, {{ $dataPersetujuan->tanggal_implementasi ? \Carbon\Carbon::parse($dataPersetujuan->tanggal_implementasi)->format('d-m-Y') : '___________________' }}</p>
                <p>Yang membuat pernyataan:</p>
                <div class="signature-line"></div>
                <p>
                    @if($dataPersetujuan->tipe_penerima == 'pasien')
                        ({{ $dataMedis->pasien->nama ?? '.................................' }})
                    @else
                        ({{ $dataPersetujuan->nama_keluarga ?? '.................................' }})
                    @endif
                </p>
                <p><strong>{{ ucfirst($dataPersetujuan->tipe_penerima ?? 'Pasien') }}</strong></p>
            </div>
            <div class="signature-block">
                <p>Saksi:</p>
                <br><br>
                <div class="signature-line"></div>
                <p>({{ $dataPersetujuan->userCreated->name ?? '.................................' }})</p>
                <p><strong>Dokter/perawat</strong></p>
            </div>
        </div>
    </div>
</body>

</html>
