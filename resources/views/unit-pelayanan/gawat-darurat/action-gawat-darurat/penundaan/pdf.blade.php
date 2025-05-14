<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Penundaan Pelayanan IGD</title>

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
            font-size: 16px;
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
            font-size: 16px;
        }

        footer div {
            display: table-cell;
            vertical-align: top;
            text-align: center;
            width: fit-content;
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
            PENUNDAAN PELAYANAN
        </p>

        <p>
            Saya yang bertanda tangan di bawah ini yang menerima informasi:
        </p>
        <p>
            @if ($penundaan->status_penerima_informasi == 1)
                Pasien sendiri,
            @endif
            @if ($penundaan->status_penerima_informasi == 2)
                Keluarga pasien,
            @endif
            @if ($penundaan->status_penerima_informasi == 3)
                Penanggungjawab pasien,
            @endif

            nama {{ $penundaan->nama_penerima_informasi }}
        </p>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->nama }}</td>
            </tr>
            <tr>
                <td>No Rekam Medis</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->kd_pasien }}</td>
            </tr>
            <tr>
                <td>Tempat/ Tgl Lahir</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->tempat_lahir . ' / ' . date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) }}
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $dataMedis->pasien->jenis_kelamin == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Ruangan</td>
                <td>:</td>
                <td>{{ $dataMedis->unit->nama_unit }}</td>
            </tr>
            <tr>
                <td>Nama Dokter Pengirim</td>
                <td>:</td>
                <td>{{ $penundaan->dokter->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Pelayanan yang akan diberikan</td>
                <td>:</td>
                <td>{{ $penundaan->pelayanan_diberikan }}</td>
            </tr>
        </table>

        <p>
            Dengan ini menyatakan bahwa saya telah menerima informasi terhadap penundaan pelayanan disebabkan:
        </p>

        <table style="margin-left: 40px;">
            @if (!empty($penundaan->penyebab_kerusakan_alat))
                <tr>
                    <td>Kerusakan Alat</td>
                    <td>:</td>
                    <td>{{ $penundaan->penyebab_kerusakan_alat }}</td>
                </tr>
            @endif

            @if (!empty($penundaan->penyebab_kondisi_umum_pasien))
                <tr>
                    <td>Kondisi umum pasien</td>
                    <td>:</td>
                    <td>{{ $penundaan->penyebab_kondisi_umum_pasien }}</td>
                </tr>
            @endif

            @if (!empty($penundaan->penyebab_penundaan_penjadwalan))
                <tr>
                    <td>Penundaan Penjadwalan</td>
                    <td>:</td>
                    <td>{{ $penundaan->penyebab_penundaan_penjadwalan }}</td>
                </tr>
            @endif

            @if (!empty($penundaan->penyebab_pemadaman_listrik))
                <tr>
                    <td>Pemadaman Instalasi Listrik</td>
                    <td>:</td>
                    <td>{{ $penundaan->penyebab_pemadaman_listrik }}</td>
                </tr>
            @endif

            @if (!empty($penundaan->penyebab_lainnya))
                <tr>
                    <td>Penyebab lain</td>
                    <td>:</td>
                    <td>{{ $penundaan->penyebab_lainnya }}</td>
                </tr>
            @endif
        </table>

        <p>
            Maka dengan ini saya <strong>setuju</strong> untuk dilakukan penundaan pelayanan dengan alternatif:
        </p>

        <table style="margin-left: 40px;">
            @if (!empty($penundaan->alternatif_tgl))
                <tr>
                    <td>Dijadwalkan ulang dan menjadi prioritas, jadwal yang akan datang:
                        {{ date('d-m-Y', strtotime($penundaan->alternatif_tgl)) . ' ' . date('H:i', strtotime($penundaan->alternatif_jam)) }}
                        WIB</td>
                </tr>
            @endif

            @if (!empty($penundaan->alternatif_rujuk))
                <tr>
                    <td>Dirujuk ke layanan kesehatan lain, ke {{ $penundaan->alternatif_rujuk }}</td>
                </tr>
            @endif

            @if (!empty($penundaan->alternatif_kembali))
                <tr>
                    <td>Dikembalikan ke dokter pengirim.</td>
                </tr>
            @endif

            @if (!empty($penundaan->alternatif_lainnya))
                <tr>
                    <td>Lainnya : {{ $penundaan->alternatif_lainnya }}</td>
                </tr>
            @endif
        </table>

        <table>
            <tr>
                <td>Manfaat/ risiko alternatif yang ditawarkan</td>
                <td>:</td>
                <td>{{ $penundaan->manfaat_risiko_alternatif }}</td>
            </tr>
            <tr>
                <td>Risiko penundaan pelayanan</td>
                <td>:</td>
                <td>{{ $penundaan->risiko_penundaan }}</td>
            </tr>
        </table>
    </main>

    <footer>
        <div class="">
            <p style="margin: 0;">Menyetujui:</p>
            <p style="margin: 0;">Pasien/ keluarga</p>
            <p class="name-konsulen">{{ $penundaan->nama_penerima_informasi }}</p>
        </div>

        <div class="">
            <p>Mengetahui DPJP</p>
            <p class="name-konsulen">{{ $penundaan->dokter->nama_lengkap }}</p>
        </div>

        <div class="">
            <p style="margin: 0;">Kota Langsa, {{ date('d-m-Y', strtotime($penundaan->tanggal)) }} Pukul:
                {{ date('H:i', strtotime($penundaan->jam)) }} WIB</p>
            <p style="margin: 0;">Pemberi Informasi</p>
            <p class="name-konsulen">
                {{ $penundaan->userCreate->karyawan->gelar_depan . ' ' . str()->title($penundaan->userCreate->karyawan->nama) . ' ' . $penundaan->userCreate->karyawan->gelar_belakang }}
            </p>
        </div>
    </footer>
</body>

</html>
