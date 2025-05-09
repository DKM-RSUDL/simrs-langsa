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
            border-bottom: 2px solid black
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
            margin-top: 30px;
            text-align: justify;
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
            margin-top: 30px;
        }

        footer div {
            display: table-cell;
            vertical-align: top;
            text-align: center;
        }

        footer div .name-konsulen {
            margin: 80px 0 0 0;
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
    </main>

    <footer>
        <div class="left-column">
            <p>DPJP yang merawat</p>
            <p class="name-konsulen">{{ $dataMedis->dokter->nama_lengkap }}</p>
            <p class="identity-num">
                @php
                    $identityNum = 'Id Peg. ' . $dataMedis->dokter->kd_karyawan;
                    if (!empty($dataMedis->dokter->detail->nip_baru)) {
                        $identityNum = 'NIP. ' . $dataMedis->dokter->detail->nip_baru;
                    }
                    echo $identityNum;
                @endphp
            </p>
        </div>

        {{-- <div class="right-column">
            <p>Dokter Konsulen</p>
            <p class="name-konsulen">{{ $konsultasi->dokterTujuan->nama_lengkap }}</p>
            <p class="identity-num">
                @php
                    $identityNum = 'Id Peg. ' . $konsultasi->dokterTujuan->kd_karyawan;
                    if(!empty($konsultasi->dokterTujuan->detail->nip_baru)) $identityNum = 'NIP. ' . $konsultasi->dokterTujuan->detail->nip_baru;
                    echo $identityNum;
                @endphp
            </p>
        </div> --}}
    </footer>
</body>

</html>
