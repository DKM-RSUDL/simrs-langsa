<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VISUM ET REPERTUM OTOPSI</title>
    <style>
        @page {
            margin: 2cm 1.5cm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        
        .header h2 {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            margin-bottom: 3px;
        }
        
        .section {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        
        .info-table td,
        .info-table th {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
            text-align: left;
        }
        
        .info-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 28%;
        }
        
        .patient-info {
            background-color: #f9f9f9;
            border: 1px solid #000;
            padding: 12px;
            margin-bottom: 15px;
        }
        
        .patient-row {
            margin-bottom: 6px;
            overflow: hidden;
        }
        
        .patient-label {
            font-weight: bold;
            width: 150px;
            float: left;
        }
        
        .patient-value {
            margin-left: 150px;
        }
        
        .content-box {
            border: 1px solid #000;
            padding: 8px;
            min-height: 60px;
            margin-bottom: 8px;
            background-color: #fafafa;
        }
        
        .signature-section {
            margin-top: 30px;
            width: 100%;
        }
        
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            margin: 50px 20px 8px 20px;
        }
        
        .footer-info {
            margin-top: 25px;
            font-size: 9px;
            text-align: center;
            color: #666;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        em {
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>VISUM ET REPERTUM OTOPSI</h1>
        <h2>INSTALASI KEDOKTERAN FORENSIK</h2>
        <p>RUMAH SAKIT UMUM DAERAH LANGSA</p>
        <p>Jl. Jenderal Ahmad Yani No. 1, Langsa, Aceh</p>
    </div>

    <!-- Basic Information -->
    <div class="section">
        <div class="section-title">Informasi Dasar Pemeriksaan</div>
        <table class="info-table">
            <tr>
                <th>Tanggal Pengisian</th>
                <td>{{ $visumOtopsi->tanggal ? date('d/m/Y', strtotime($visumOtopsi->tanggal)) : '-' }}</td>
            </tr>
            <tr>
                <th>Jam Pengisian</th>
                <td>{{ $visumOtopsi->jam ? date('H:i', strtotime($visumOtopsi->jam)) : '-' }} WIB</td>
            </tr>
            <tr>
                <th>Nomor Visum</th>
                <td>{{ $visumOtopsi->nomor ?? '-' }}</td>
            </tr>
            <tr>
                <th>Perihal</th>
                <td>{{ $visumOtopsi->perihal ?? '-' }}</td>
            </tr>
            <tr>
                <th>Lampiran</th>
                <td>{{ $visumOtopsi->lampiran ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Patient Information -->
    <div class="section">
        <div class="section-title">Data Pasien/Korban</div>
        <div class="patient-info">
            <div class="patient-row">
                <div class="patient-label">Nama Lengkap:</div>
                <div class="patient-value">{{ $dataMedis->pasien->nama ?? '-' }}</div>
            </div>
            <div class="patient-row">
                <div class="patient-label">Umur/Tanggal Lahir:</div>
                <div class="patient-value">{{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Tahun
                @if($dataMedis->pasien->tgl_lahir)
                    ({{ \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') }})
                @endif
                </div>
            </div>
            <div class="patient-row">
                <div class="patient-label">Jenis Kelamin:</div>
                <div class="patient-value">
                    @if($dataMedis->pasien->jenis_kelamin == 1)
                        Laki-laki
                    @elseif($dataMedis->pasien->jenis_kelamin == 0)
                        Perempuan
                    @else
                        Tidak Diketahui
                    @endif
                </div>
            </div>
            <div class="patient-row">
                <div class="patient-label">Agama:</div>
                <div class="patient-value">{{ $dataMedis->pasien->agama->agama ?? '-' }}</div>
            </div>
            <div class="patient-row">
                <div class="patient-label">Alamat:</div>
                <div class="patient-value">{{ $dataMedis->pasien->alamat ?? '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Visum et Repertum -->
    <div class="section">
        <div class="section-title">Visum et Repertum</div>
        <div class="content-box">
            {!! $visumOtopsi->visum_et_repertum ?? '<em>Tidak ada data</em>' !!}
        </div>
    </div>

    <!-- Wawancara -->
    <div class="section">
        <div class="section-title">Hasil Wawancara</div>
        <div class="content-box">
            {!! $visumOtopsi->wawancara ?? '<em>Tidak ada data</em>' !!}
        </div>
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Pemeriksaan Luar -->
    <div class="section">
        <div class="section-title">Pemeriksaan Luar</div>
        
        <table class="info-table">
            <tr>
                <th>Penutup Mayat</th>
                <td>{!! $visumOtopsi->penutup_mayat ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Label Mayat</th>
                <td>{!! $visumOtopsi->label_mayat ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Pakaian Mayat</th>
                <td>{!! $visumOtopsi->pakaian_mayat ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Benda di Samping</th>
                <td>{{ $visumOtopsi->benda_disamping ?? '-' }}</td>
            </tr>
            <tr>
                <th>Aksesoris</th>
                <td>{{ $visumOtopsi->aksesoris ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Identifikasi -->
    <div class="section">
        <div class="section-title">Identifikasi</div>
        
        <div style="margin-bottom: 10px;">
            <strong>Identifikasi Umum:</strong>
            <div class="content-box">
                {!! $visumOtopsi->identifikasi_umum_keterangan ?? '<em>Tidak ada data</em>' !!}
            </div>
        </div>
        
        <div style="margin-bottom: 10px;">
            <strong>Tanda-tanda Kematian:</strong>
            <div class="content-box">
                {!! $visumOtopsi->tanda_kematian ?? '<em>Tidak ada data</em>' !!}
            </div>
        </div>
        
        <div style="margin-bottom: 10px;">
            <strong>Identifikasi Khusus:</strong>
            <div class="content-box">
                {!! $visumOtopsi->identifikasi_khusus_keterangan ?? '<em>Tidak ada data</em>' !!}
            </div>
        </div>
    </div>

    <!-- Hasil Pemeriksaan Luar Detail -->
    <div class="section">
        <div class="section-title">Hasil Pemeriksaan Luar</div>
        
        <table class="info-table">
            <tr>
                <th>Kepala</th>
                <td>{!! $visumOtopsi->kepala_luar ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Wajah</th>
                <td>{!! $visumOtopsi->wajah ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Mata</th>
                <td>{!! $visumOtopsi->mata ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Mulut</th>
                <td>{!! $visumOtopsi->mulut ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Leher</th>
                <td>{!! $visumOtopsi->leher_luar ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Dada</th>
                <td>{!! $visumOtopsi->dada_luar ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Punggung</th>
                <td>{!! $visumOtopsi->punggung ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Perut</th>
                <td>{!! $visumOtopsi->perut_luar ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Anggota Gerak Atas</th>
                <td>{!! $visumOtopsi->anggota_gerak_atas ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Anggota Gerak Bawah</th>
                <td>{!! $visumOtopsi->anggota_gerak_bawah ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Kemaluan</th>
                <td>{!! $visumOtopsi->kemaluan ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Anus</th>
                <td>{!! $visumOtopsi->anus ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
        </table>
    </div>

    <!-- Page Break -->
    <div class="page-break"></div>

    <!-- Hasil Pemeriksaan Dalam -->
    <div class="section">
        <div class="section-title">Hasil Pemeriksaan Dalam</div>
        
        <table class="info-table">
            <tr>
                <th>Kepala</th>
                <td>{!! $visumOtopsi->kepala_dalam ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Leher</th>
                <td>{!! $visumOtopsi->leher_dalam ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Dada</th>
                <td>{!! $visumOtopsi->dada_dalam ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
            <tr>
                <th>Perut</th>
                <td>{!! $visumOtopsi->perut_dalam ?? '<em>Tidak ada data</em>' !!}</td>
            </tr>
        </table>
    </div>

    <!-- Kesimpulan -->
    <div class="section">
        <div class="section-title">Kesimpulan</div>
        <div class="content-box" style="min-height: 80px;">
            {!! $visumOtopsi->kesimpulan ?? '<em>Tidak ada kesimpulan</em>' !!}
        </div>
    </div>

    <!-- Penutup -->
    <div class="section">
        <p style="text-align: justify; margin-bottom: 15px;">
            Demikian Visum et Repertum ini dibuat dengan sebenarnya berdasarkan hasil pemeriksaan mayat 
            yang telah dilakukan dengan seksama dan teliti sesuai dengan ilmu kedokteran forensik.
        </p>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td>
                    <p><strong>Langsa, 
                    @if($visumOtopsi->tanggal)
                        {{ date('d', strtotime($visumOtopsi->tanggal)) . ' ' . \Carbon\Carbon::parse($visumOtopsi->tanggal)->locale('id')->monthName . ' ' . date('Y', strtotime($visumOtopsi->tanggal)) }}
                    @else
                        {{ date('d') . ' ' . \Carbon\Carbon::now()->locale('id')->monthName . ' ' . date('Y') }}
                    @endif
                    </strong></p>
                    <br>
                    <p><strong>Dokter Pemeriksa</strong></p>
                    <div class="signature-line"></div>
                    <p><strong>{{ $visumOtopsi->userCreated->name ?? 'Dr. [Nama Dokter]' }}</strong></p>
                    <p>NIP. [Nomor Induk Pegawai]</p>
                </td>
                <td>
                    <br><br><br>
                    <p><strong>Kepala Instalasi Forensik</strong></p>
                    <div class="signature-line"></div>
                    <p><strong>Dr. [Nama Kepala Instalasi]</strong></p>
                    <p>NIP. [Nomor Induk Pegawai]</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer Information -->
    <div class="footer-info">
        <p>Dokumen dicetak pada: {{ now()->format('d/m/Y H:i:s') }} WIB</p>
        <p>No. Registrasi: {{ $dataMedis->kd_pasien }} | No. Transaksi: {{ $dataMedis->no_transaksi ?? '-' }}</p>
    </div>
</body>
</html>