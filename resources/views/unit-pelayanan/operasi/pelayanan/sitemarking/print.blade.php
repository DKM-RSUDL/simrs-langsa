<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penandaan Daerah Operasi (Site Marking)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            line-height: 1.4;
            background-color: #fff;
        }

        .container {
            width: 100%;
            max-width: 190mm;
            /* A4 width minus margins */
            margin: 0 auto;
            border: 1px solid #000;
            padding: 2mm;
            box-sizing: border-box;
            background-color: #fff;
        }

        .header {
            display: flex;
            align-items: stretch;
            margin-bottom: 10mm;
            border-bottom: 1px solid #000;
        }

        .logo-info-section {
            width: 30%;
            padding: 5px;
            display: flex;
            align-items: center;
            background-color: #d9d9d9;
        }

        .logo-info-section img {
            width: 60px;
            height: auto;
            margin-right: 10px;
        }

        .contact-info {
            font-size: 8px;
            line-height: 1.3;
        }

        .contact-info h3 {
            font-size: 12px;
            font-weight: bold;
            margin: 0 0 2px 0;
            text-transform: uppercase;
        }

        .contact-info p {
            margin: 0;
        }

        .title-section {
            width: 50%;
            text-align: center;
            padding: 10px 5px;
            border-left: 1px solid #d9d9d9;
            border-right: 1px solid #d9d9d9;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #d9d9d9;
        }

        .title-section h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 0;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .title-section p {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .gender-section {
            width: 20%;
            text-align: center;
            padding: 5px;
            background-color: #777;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gender-section p {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3mm;
        }

        .col-6 {
            width: 48%;
        }

        .form-group {
            margin-bottom: 2mm;
        }

        .form-group label {
            font-weight: bold;
            display: inline-block;
        }

        .form-group span {
            display: inline-block;
        }

        .diagram-section {
            margin-top: 5mm;
            margin-bottom: 5mm;
            display: flex;
            justify-content: center;
            border: 1px solid #000000;
        }

        .left-column {
            width: 48%;
            display: flex;
            flex-direction: column;
            gap: 3mm;
        }

        .right-column {
            width: 48%;
            display: flex;
            flex-direction: column;
            gap: 3mm;
        }

        .diagram-col {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .diagram-col.full-body {
            width: 100%;
        }

        .diagram-col.foot {
            width: 100%;
        }

        .diagram-col.small {
            width: 100%;
        }

        .image-wrapper {
            position: relative;
            overflow: hidden;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .image-wrapper.full-body {
            width: 100%;
            height: 95mm;
            max-width: 80mm;
        }

        .image-wrapper.foot {
            width: 100%;
            height: 40mm;
            max-width: 80mm;
        }

        .image-wrapper.small {
            width: 100%;
            height: 30mm;
            max-width: 80mm;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .diagram-label {
            font-size: 10px;
            margin-top: 2mm;
            text-align: center;
            line-height: 1.2;
        }

        /* Signature box styles */
        .signature-box {
            border: 1px solid #000000;
            padding: 10px;
            margin-top: 5mm;
            margin-bottom: 5mm;
        }

        .signature-box .notes-section {
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .signature-box .form-group {
            margin-bottom: 5mm;
        }

        .signature-box .signature-section {
            margin-top: 15px;
            padding-top: 10px;
        }

        .notes-section {
            margin-bottom: 5mm;
        }

        .notes-section label {
            font-weight: bold;
        }

        .signature-section {
            margin-top: 5mm;
        }

        .signature-section .row {
            display: flex;
            justify-content: space-between;
        }

        .signature-section .col-6 {
            text-align: center;
        }

        .signature-section img {
            max-width: 40mm;
            height: auto;
        }

        .signature-section p {
            margin: 2mm 0 0;
            font-size: 10px;
        }

        .footer {
            margin-top: 5mm;
            font-size: 10px;
            display: flex;
            justify-content: space-between;
        }

        .underline {
            border-bottom: 1px solid #000;
            display: inline-block;
            width: 40mm;
            text-align: center;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }

            body {
                padding: 0 !important;
                margin: 0 !important;
            }

            .container {
                border: none;
                padding: 0;
                width: 100%;
                max-width: none;
            }

            .image-wrapper {
                page-break-inside: avoid;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .diagram-section {
                page-break-inside: avoid;
            }

            .signature-box {
                page-break-inside: avoid;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo-info-section">
                <img src="{{ asset('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa">
                <div class="contact-info">
                    <h3>RSUD LANGSA</h3>
                    <p>Jl. Jend. A. Yani, No. 1, Kota Langsa</p>
                    <p>Telp: 0641-21822</p>
                    <p>email: rsudlangsa.aceh@gmail.com</p>
                    <p>www.rsudlangsakota.go.id</p>
                </div>
            </div>
            <div class="title-section">
                <h2>PENANDAAN DAERAH OPERASI</h2>
                <p>(SITE MARKING)</p>
            </div>
            <div class="gender-section">
                <p>{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'PRIA' : 'WANITA' }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Prosedur:</label>
                    <span class="underline">{{ $siteMarking->prosedure }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Tanggal prosedur:</label>
                    <span
                        class="underline">{{ \Carbon\Carbon::parse($siteMarking->waktu_prosedure)->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="diagram-section">
            <!-- Kolom Kiri: Full Body dan Kaki -->
            <div class="left-column">
                <div class="diagram-col full-body">
                    <div class="image-wrapper full-body">
                        @if (isset($markingImages['full-body']) && Storage::exists($markingImages['full-body']))
                            <img src="{{ Storage::url($markingImages['full-body']) }}" alt="Full Body">
                        @else
                            <img src="{{ asset('assets/images/sitemarking/' . ($dataMedis->pasien->jenis_kelamin == 1 ? '7.png' : '1.png')) }}"
                                alt="Full Body Default">
                        @endif
                    </div>
                    <div class="diagram-label">Kanan Kiri Kanan Kiri</div>
                </div>
                <div class="diagram-col foot">
                    <div class="image-wrapper foot">
                        @if (isset($markingImages['foot']) && Storage::exists($markingImages['foot']))
                            <img src="{{ Storage::url($markingImages['foot']) }}" alt="Foot">
                        @else
                            <img src="{{ asset('assets/images/sitemarking/' . ($dataMedis->pasien->jenis_kelamin == 1 ? '12.png' : '5.png')) }}"
                                alt="Foot Default">
                        @endif
                    </div>
                    <div class="diagram-label">plantar (posterior) dorsal (anterior) Kanan Kiri Kanan Kiri</div>
                </div>
            </div>
            <!-- Kolom Kanan: 4 Diagram Kecil (1 per baris) -->
            <div class="right-column">
                <div class="diagram-col small">
                    <div class="image-wrapper small">
                        @if (isset($markingImages['head-front-back']) && Storage::exists($markingImages['head-front-back']))
                            <img src="{{ Storage::url($markingImages['head-front-back']) }}" alt="Head Front Back">
                        @else
                            <img src="{{ asset('assets/images/sitemarking/' . ($dataMedis->pasien->jenis_kelamin == 1 ? '9.png' : '3.png')) }}"
                                alt="Head Front Back Default">
                        @endif
                    </div>
                    <div class="diagram-label">Kanan Kiri Kanan Kiri</div>
                </div>
                <div class="diagram-col small">
                    <div class="image-wrapper small">
                        @if (isset($markingImages['head-side']) && Storage::exists($markingImages['head-side']))
                            <img src="{{ Storage::url($markingImages['head-side']) }}" alt="Head Side">
                        @else
                            <img src="{{ asset('assets/images/sitemarking/' . ($dataMedis->pasien->jenis_kelamin == 1 ? '8.png' : '2.png')) }}"
                                alt="Head Side Default">
                        @endif
                    </div>
                    <div class="diagram-label">Kanan Kiri</div>
                </div>
                <div class="diagram-col small">
                    <div class="image-wrapper small">
                        @if (isset($markingImages['hand-palmar']) && Storage::exists($markingImages['hand-palmar']))
                            <img src="{{ Storage::url($markingImages['hand-palmar']) }}" alt="Hand Palmar">
                        @else
                            <img src="{{ asset('assets/images/sitemarking/' . ($dataMedis->pasien->jenis_kelamin == 1 ? '10.png' : '4.png')) }}"
                                alt="Hand Palmar Default">
                        @endif
                    </div>
                    <div class="diagram-label">palmar (anterior) Kanan Kiri</div>
                </div>
                <div class="diagram-col small">
                    <div class="image-wrapper small">
                        @if (isset($markingImages['hand-dorsal']) && Storage::exists($markingImages['hand-dorsal']))
                            <img src="{{ Storage::url($markingImages['hand-dorsal']) }}" alt="Hand Dorsal">
                        @else
                            <img src="{{ asset('assets/images/sitemarking/' . ($dataMedis->pasien->jenis_kelamin == 1 ? '11.png' : '6.png')) }}"
                                alt="Hand Dorsal Default">
                        @endif
                    </div>
                    <div class="diagram-label">dorsal (posterior) Kanan Kiri</div>
                </div>
            </div>
        </div>

        <div class="signature-box">
            <div class="notes-section">
                <label>Saya menyatakan bahwa lokasi operasi yang telah ditetapkan pada diagram di atas adalah benar:</label>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Tanggal:</label>
                        <span class="underline"></span>
                    </div>
                    <div class="form-group">
                        <label>Pasien/Keluarga:</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Tanggal:</label>
                        <span class="underline"></span>
                    </div>
                    <div class="form-group">
                        <label>Dokter:</label>
                        <span></span>
                    </div>
                </div>
            </div>

            <div class="signature-section">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <br>
                            @if ($siteMarking->tanda_tangan_pasien && Storage::exists($siteMarking->tanda_tangan_pasien))
                                <img src="{{ Storage::url($siteMarking->tanda_tangan_pasien) }}" alt="Tanda Tangan Pasien">
                            @else
                                <p class="text-muted">Tanda tangan tidak tersedia</p>
                            @endif
                            <p>({{ $dataMedis->pasien->nama }})</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <br>
                            @if ($siteMarking->tanda_tangan_dokter && Storage::exists($siteMarking->tanda_tangan_dokter))
                                <img src="{{ Storage::url($siteMarking->tanda_tangan_dokter) }}" alt="Tanda Tangan Dokter">
                            @else
                                <p class="text-muted">Tanda tangan tidak tersedia</p>
                            @endif
                            <p>({{ $siteMarking->dokter->nama_lengkap ?? 'Tidak Diketahui' }})</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <span>Penandaan daerah operasi ({{ $dataMedis->pasien->jenis_kelamin == 1 ? 'PRIA' : 'WANITA' }})</span>
            <span>Nomor Dokumen: HB-ISM/Rev 0/2017</span>
        </div>
    </div>

    <script>
        // Auto print setelah halaman dimuat
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500); // Beri waktu singkat untuk memastikan gambar dimuat
        };
    </script>
</body>

</html>