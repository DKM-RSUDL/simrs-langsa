<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Second Opinion</title>
    <style>
        @page {
            margin: 1cm 1cm;
            size: A4 portrait;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt;
            line-height: 1.2;
        }

        .container {
            width: 100%;
            position: relative;
        }

        /* Header/Kop Surat */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
            width: 100%;
            position: relative;
        }

        .logo-rs {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin-right: 10px;
        }

        .kop-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .rs-name-1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
        }

        .rs-address {
            font-size: 9pt;
            margin: 0;
            line-height: 1.3;
        }

        .border-line {
            border-bottom: 2px solid black;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .border-line-2 {
            border-bottom: 1px solid black;
            margin-bottom: 5px;
        }

        /* Judul */
        .title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 5px 0;
        }

        /* Content */
        .content {
            margin-bottom: 3px;
        }

        /* Form Fields */
        p {
            margin: 3px 0;
            font-size: 9pt;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .form-table td {
            padding: 2px 0;
            font-size: 9pt;
        }

        .form-table .label {
            width: 120px;
            text-align: left;
            padding-right: 10px;
        }

        .form-table .value {
            border-bottom: 1px dotted #000;
            min-height: 15px;
            padding-left: 5px;
        }

        /* Patient Info Box */
        .patient-info {
            border: 1px solid #000;
            padding: 5px;
            width: 280px;
            font-size: 9pt;
            position: absolute;
            top: 0;
            right: 0;
        }

        .patient-info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .patient-info-label {
            width: 100px;
            font-weight: normal;
        }

        .patient-info-value {
            flex: 1;
        }

        /* Fixed Signature Section */
        .signature-section {
            margin-top: 20px;
            position: relative;
        }

        .closing-statement {
            margin-bottom: 15px;
            font-size: 9pt;
        }

        .signature-location {
            text-align: right;
            margin-bottom: 30px;
            font-size: 9pt;
        }

        .signature-location .location {
            border-bottom: 1px dotted #000;
            min-width: 120px;
            text-align: center;
            display: inline-block;
            padding-bottom: 2px;
        }

        .signature-location .time {
            border-bottom: 1px dotted #000;
            min-width: 60px;
            text-align: center;
            display: inline-block;
            padding-bottom: 2px;
        }

        .signature-row {
            display: table;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 20px;
        }

        .signature-box {
            display: table-cell;
            text-align: center;
            padding: 0 10px;
            vertical-align: top;
        }

        .signature-title {
            margin-bottom: 10px;
            font-size: 9pt;
        }

        .signature-space {
            min-height: 40px;
            margin-bottom: 5px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin: 0 auto;
            width: 120px;
            text-align: center;
            padding-bottom: 2px;
            font-size: 9pt;
        }

        /* Return Section */
        .return-section {
            margin-top: 10px;
            width: 100%;
        }

        .return-section .return-line {
            margin-bottom: 15px;
            font-size: 9pt;
        }

        .return-section .return-line .dotted {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 120px;
            padding-bottom: 2px;
        }

        .return-signatures {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .return-box {
            display: table-cell;
            padding: 0 20px;
            font-size: 9pt;
        }

        .return-box .dotted {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 120px;
            padding-bottom: 2px;
        }

        /* Special styling for circled text */
        .hubungan-pasien {
            position: relative;
            display: inline;
        }

        .option-circle {
            border: 1px solid #000;
            border-radius: 50%;
            padding: 2px 8px;
            margin: 0 2px;
            display: inline-block;
            text-align: center;
            min-width: 15px;
        }

        /* Document List */
        .document-list {
            margin-left: 20px;
            font-size: 9pt;
        }

        .clear {
            clear: both;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header/Kop Surat -->
        <div class="header">
            <div class="logo-rs">
                <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa" class="logo">
                <div class="kop-text">
                    <p class="rs-name-1">RSUD LANGSA</p>
                    <p class="rs-address">Jl. Jend. A. Yani, Kota Langsa</p>
                    <p class="rs-address">Telp: 0641- 22051</p>
                    <p class="rs-address">email: rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="patient-info">
                <div class="patient-info-row">
                    <span class="patient-info-label">No RM</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->kd_pasien }}</span>
                </div>
                <div class="patient-info-row">
                    <span class="patient-info-label">Nama</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->nama }}</span>
                </div>
                <div class="patient-info-row">
                    <span class="patient-info-label">Jenis Kelamin</span>
                    <span class="patient-info-value">:
                        {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}
                        *</span>
                </div>
                <div class="patient-info-row">
                    <span class="patient-info-label">Tanggal Lahir</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn
                        ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})</span>
                </div>
            </div>
        </div>

        <div class="clear"></div>
        <div class="border-line"></div>
        <div class="border-line-2"></div>

        <!-- Judul -->
        <div class="title">PERMINTAAN SECOND OPINION</div>

        <!-- Isi Surat -->
        <div class="content">
            <p>Saya yang bertanda tangan di bawah ini :</p>

            <table class="form-table">
                <tr>
                    <td class="label">Nama</td>
                    <td class="value">: {{ $secondOpinion->peminjam_nama ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="value">:
                        {{ $secondOpinion->jenis_kelamin == 1 ? 'Laki-Laki' : ($secondOpinion->jenis_kelamin == 0 ? 'Perempuan' : '') }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Tgl Lahir</td>
                    <td class="value">:
                        {{ $secondOpinion->tgl_lahir ? \Carbon\Carbon::parse($secondOpinion->tgl_lahir)->format('d/m/Y') : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">No Kartu Identitas</td>
                    <td class="value">: {{ $secondOpinion->no_kartu_identitas }}</td>
                </tr>
                <tr>
                    <td class="label">Alamat</td>
                    <td class="value">: {{ $secondOpinion->alamat }}</td>
                </tr>
            </table>

            <p>Bertindak atas nama * {{ $secondOpinion->hubungan ?? '' }}</p>

            <table class="form-table">
                <tr>
                    <td class="label">Nama</td>
                    <td class="value">: {{ $dataMedis->pasien->nama ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Jenis Kelamin</td>
                    <td class="value">:
                        {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-Laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : '') }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Tgl Lahir</td>
                    <td class="value">:
                        {{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">No Rekam Medis</td>
                    <td class="value">: {{ $dataMedis->pasien->kd_pasien ?? '' }}</td>
                </tr>
            </table>

            <p>Dengan ini menyatakan dengan sadar dan sesungguhnya bahwa:</p>

            <ol style="margin-left: 20px; font-size: 9pt;">
                <li>Telah menerima dan memahami informasi mengenai penyakit diri saya/pasien dan tindakan penanganan
                    awal yang telah dilakukan dokter RSUD Langsa.</li>
                <li>Meminta kepada pihak RSUD Langsa untuk diberikan kesempatan mencari second opinion/pendapat kedua
                    terhadap alternatif diagnosa/pengobatan diri saya/pasien tersebut di rumah sakit:
                    {{ $secondOpinion->rs_second_opinion ?? '...................' }}</li>
                <li>Segala sarana, biaya maupun fasilitas untuk mencari second opinion menjadi tanggung jawab diri
                    saya/pasien/keluarga.</li>
                <li>Untuk keperluan tersebut, kami meminjam hasil pemeriksaan penunjang diagnosis antar lain:</li>
                <ul style="margin-left: 20px; font-size: 9pt;">
                    @if($secondOpinion->nama_dokumen)
                        @php
                            $dokumenArray = json_decode($secondOpinion->nama_dokumen, true);
                        @endphp
                        @if(is_array($dokumenArray) && !empty($dokumenArray))
                            @foreach($dokumenArray as $index => $dokumen)
                                <li>{{ chr(97 + $index) }}. {{ $dokumen }}</li>
                            @endforeach
                        @else
                            <li>Tidak ada dokumen</li>
                        @endif
                    @else
                        <li>Tidak ada dokumen</li>
                    @endif
                </ul>

            </ol>

            <!-- Fixed Signature Section -->
            <div class="signature-section">
                <p class="closing-statement">Demikian permintaan ini saya buat dengan sebenarnya.</p>

                <div class="signature-location">
                    <span>Kota Langsa, </span>
                    <span
                        class="location">{{ $secondOpinion->informasi_tanggal ? \Carbon\Carbon::parse($secondOpinion->informasi_tanggal)->locale('id')->isoFormat('D MMMM Y') : '.......................' }}</span>
                    <span> Pukul:</span>
                    <span
                        class="time">{{ $secondOpinion->informasi_jam ? date('H:i', strtotime($secondOpinion->informasi_jam)) : '........' }}</span>
                </div>

                <div class="signature-row">
                    <div class="signature-box">
                        <div class="signature-title">Petugas</div>
                        <div class="signature-space"></div>
                        <div class="signature-line">
                            ({{ $secondOpinion->userCreate->name ?? '........................................' }})</div>
                    </div>
                    <div class="signature-box">
                        <div class="signature-title">Saksi</div>
                        <div class="signature-space"></div>
                        <div class="signature-line">
                            ({{ $secondOpinion->nama_saksi ?? '..................................' }})</div>
                    </div>
                    <div class="signature-box">
                        <div class="signature-title">Yang menyatakan:</div>
                        <div class="signature-space"></div>
                        <div class="signature-line">
                            ({{ $secondOpinion->peminjam_nama ?? '.....................................' }})</div>
                    </div>
                </div>

                <br>
                <div class="return-section">
                    <div class="return-line">
                        <span>Tanggal/waktu pengembalian dokumen yang dipinjam:</span>
                        <span
                            class="dotted">{{ $secondOpinion->tanggal_pengembalian ? \Carbon\Carbon::parse($secondOpinion->tanggal_pengembalian)->format('d/m/Y') : '...........................' }}</span>
                    </div>

                    <div class="return-signatures">
                        <div class="return-box">
                            <span>Petugas: </span>
                            <span class="dotted">{{ $secondOpinion->userCreate->name }}</span>
                        </div>
                        <div class="return-box">
                            <span>Peminjam: </span>
                            <span class="dotted">{{ $secondOpinion->peminjam_nama }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
