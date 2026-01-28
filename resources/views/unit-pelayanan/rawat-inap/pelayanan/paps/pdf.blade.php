<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print PAPS Rawat Inap</title>

    <style>
        body {
            font-family: sans-serif;
        }

        header {
            width: 100%;
            display: table;
            padding-bottom: 30px;
            border-bottom: 2px solid black;
            font-size: 13px;
        }

        header .left-column {
            display: table-cell;
            width: 20%;
            vertical-align: top;
            text-align: center;
        }

        header .left-column p {
            margin: 5px;
        }

        header .center-column {
            display: table-cell;
            width: auto;
            vertical-align: middle;
            text-align: center;
        }

        header .center-column p {
            font-size: 25px;
            font-weight: 700;
        }

        header .right-column {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }

        header .header-logo {
            width: 80px;
        }

        header .title {
            font-size: 24px;
            font-weight: bold;
        }

        header .info-table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        header .info-table td {
            padding: 8px;
            border: 1px solid black;
        }

        main {
            /* margin-top: 10px; */
            text-align: justify;
            font-size: 13px;
        }

        main .letter-title {
            text-align: center;
            font-weight: 700;
            text-decoration: underline;
            margin-bottom: 30px;
        }

        footer {
            width: 100%;
            display: table;
            /* margin-top: 30px; */
            font-size: 13px;
        }

        footer div {
            display: table-cell;
            vertical-align: top;
            text-align: center;
            width: fit-content;
        }

        footer div .name-konsulen {
            margin: 110px 0 0 0;
            font-weight: 600;
            text-decoration: underline;
        }

        footer div .label-konsulen {
            margin: 10px 0 0 0;
            font-weight: 600;
            text-decoration: underline;
        }

        footer div .identity-num {
            margin: 0;
        }
    </style>
</head>

<body>
    <header>
        <div class="left-column">
            <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" class="header-logo" alt="Logo">
            <p>RSUD Langsa</p>
            <p>Jl. Jend. A. Yani No.1 Kota Langsa</p>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ $dataMedis->kd_pasien }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ str()->title($dataMedis->pasien->nama) }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';

                            if ($dataMedis->pasien->jenis_kelamin == 1) {
                                $gender = 'Laki-Laki';
                            }
                            if ($dataMedis->pasien->jenis_kelamin == 0) {
                                $gender = 'Perempuan';
                            }

                            echo $gender;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) }}</td>
                </tr>
            </table>
        </div>
    </header>

    <main>
        <p class="letter-title">
            PERNYATAAN PULANG ATAS PERMINTAAN SENDIRI (PAPS)
        </p>

        <p>
            Yang bertanda tangan di bawah ini Dokter Penanggung Jawab Pelayanan (DPJP), dengan ini saya telah
            menjelaskan kemungkinan-kemungkinan bahaya serta resiko yang akan timbul apabila menghentikan perawatan
            (pulang paksa) terhadap pasien yang belum sembuh dari penyakitnya antara lain:
        </p>

        <table style="width: 100%;">
            @foreach ($paps->detail as $item)
                <tr>
                    <td align="middle">{{ $loop->iteration }}</td>
                    <td>Diagnosis : {{ $item->diagnosis }}</td>
                    <td>Risiko : {{ $item->risiko }}</td>
                </tr>
            @endforeach
        </table>

        <p>
            Dan juga yang bertanda tangan di bawah ini:
        </p>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $paps->keluarga_nama }}</td>
            </tr>
            <tr>
                <td>Usia</td>
                <td>:</td>
                <td>{{ $paps->keluarga_usia }}</td>
            </tr>
            <tr>
                <td>JK</td>
                <td>:</td>
                <td>{{ $paps->keluarga_jenis_kelamin == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $paps->keluarga_alamat }}</td>
            </tr>
            <tr>
                <td>No KTP</td>
                <td>:</td>
                <td>{{ $paps->keluarga_ktp }}</td>
            </tr>
        </table>

        <ol style="font-weight: 600;">
            <li style="margin-bottom: 10px;">
                Menyatakan dengan sesungguhnya bahwa saya telah mendapat penjelasan dari dokter/ perawat dan mengerti
                kemungkinan-kemungkinan bahaya serta resiko yang akan timbul apabila menghentikan perawatan (pulang
                paksa) terhadap pasien yang belum sembuh dari penyakitnya.
            </li>
            <li>
                Memahami dengan dengan sesungguhnya bahwa pembiayaan perawatan mengikuti ketentuan BPJS Kesehatan
                tentang pulang APS termasuk tidak dijamin apabila dirawat kembali.
            </li>
        </ol>

        <p>Dengan ini menyatakan untuk: <strong>MENGHENTIKAN PERAWATAN (PULANG PAKSA)</strong> dengan alasan:
            <br>
            {{ $paps->alasan }}
        </p>
        <p>
            Terhadap

            @if ($paps->status_keluarga == 1)
                diri saya sendiri
            @endif
            @if ($paps->status_keluarga == 2)
                Istri saya
            @endif
            @if ($paps->status_keluarga == 3)
                Suami saya
            @endif
            @if ($paps->status_keluarga == 4)
                Anak saya
            @endif
            @if ($paps->status_keluarga == 5)
                Ayah saya
            @endif
            @if ($paps->status_keluarga == 6)
                Ibu saya
            @endif
            @if ($paps->status_keluarga == 7)
                Keluarga saya
            @endif
            :
        </p>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->nama }}</td>
            </tr>
            <tr>
                <td>Usia</td>
                <td>:</td>
                <td>{{ hitungUmur(date('Y-m-d', strtotime($dataMedis->pasien->tgl_lahir))) }}</td>
            </tr>
            <tr>
                <td>JK</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->jenis_kelamin == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->alamat }}</td>
            </tr>
            <tr>
                <td>No KTP</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->no_pengenal }}</td>
            </tr>
        </table>

        <p>
            Demikian surat pernyataan ini saya buat dengan penuh kesadaran, tanpa paksaan serta menerima semua resiko
            dan tidak akan menuntut kepada pihak manapun.
        </p>
    </main>

    <footer>
        <div>
            <p>Saksi 1</p>
            <p class="name-konsulen" style="margin-top: 50px;">{{ $paps->saksi_1 }}</p>
            <p style="margin-top: 40px;">Saksi 2</p>
            <p class="name-konsulen" style="margin-top: 50px;">{{ $paps->saksi_2 }}</p>
        </div>

        <div class="center-column">
            <p>Dokter yang merawat</p>
            <img src="{{ generateQrCode($paps->dokter->nama_lengkap, 100, 'svg_datauri') }}" alt="QR">
            <p class="label-konsulen">{{ $paps->dokter->nama_lengkap }}</p>
            <p class="identity-num">
                @php
                    $identityNum = 'Id Peg. ' . $paps->dokter->kd_karyawan;
                    if (!empty($paps->dokter->detail->nip_baru)) {
                        $identityNum = 'NIP. ' . $paps->dokter->detail->nip_baru;
                    }
                    echo $identityNum;
                @endphp
            </p>
        </div>

        <div>
            <p>Tanggal : {{ date('d-m-Y', strtotime($paps->tanggal)) }} Jam : {{ date('H:i', strtotime($paps->jam)) }}
                WIB</p>
            <p>Pasien/Keluarga</p>
            <p class="name-konsulen">{{ $paps->keluarga_nama }}</p>
        </div>
    </footer>
</body>

</html>
