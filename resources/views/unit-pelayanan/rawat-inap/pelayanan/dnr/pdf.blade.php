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
            font-size: 16px;
        }

        main .letter-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 30px;
        }

        footer {
            width: 100%;
            display: table;
            margin-top: 10px;
            font-size: 16px;
        }

        footer div {
            display: table-cell;
            vertical-align: top;
            text-align: center;
            width: fit-content;
        }

        footer div .name-konsulen {
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
            FORMULIR PENOLAKAN RESUSITASI <br>
            DO NOT RESUSCITATE (DNR)
        </p>

        <p>
            Formulir ini adalah perintah dokter di mana tenaga medis emergensi tidak boleh melakukan
            resusitasi bila pasien dengan identitas di bawah ini mengalami henti jantung (di mana tidak ada
            denyut nadi) atau henti napas (tidak ada pernapasan spontan). Formulir ini juga
            menginstruksikan kepada tenaga medis emergensi untuk tetap melakukan intervensi atau
            pengobatan atau tata laksana lainnya sebelum terjadi henti napas atau henti jantung.
        </p>

        <p>
            <strong>Identitas Pasien</strong>
            <br>
            Nama lengkap pasien: {{ $dataMedis->pasien->nama }}
            <br>
            Tempat & tanggal lahir pasien: {{ $dataMedis->pasien->tempat_lahir ?? '-' }} /
            {{ date('d-m-Y', strtotime($dataMedis->pasien->tgl_lahir)) }}
        </p>

        <p>
            <strong>Pernyataan dan Instruksi Dokter</strong>
            <br>
            Saya, dokter yang bertandatangan di bawah ini menginstruksikan tenaga medis emergensi untuk
            melakukan hal yang tertulis di bawah ini:
            <br>
        </p>

        <ul>
            <li>
                @if ($dnr->instruksi == 1)
                    Usaha komprehensif untuk mencegah henti napas atau henti jantung <strong>TANPA</strong> melakukan
                    intubasi. DNR jika henti napas atau henti jantung terjadi. <strong>TIDAK</strong> melakukan CPR.
                @endif

                @if ($dnr->instruksi == 2)
                    Usaha suportif sebelum terjadi henti napas atau henti jantung yang meliputi pembukaan
                    jalan napas secara non-invasif, pemberian oksigen, mengontrol perdarahan,
                    memposisikan pasien dengan nyaman, bidai, obat-obatan anti-nyeri. <strong>TIDAK</strong> melakukan
                    CPR bila henti napas atau henti jantung terjadi.
                @endif
            </li>
        </ul>

        <p>
            Saya, dokter yang bertandatangan di bawah ini menyatakan bahwa keputusan DNR di atas
            diambil setelah pasien diberi penjelasan; dan <i>informed consent</i> diperoleh dari:
        </p>

        <ul>
            <li>
                @if ($dnr->keputusan == 1)
                    Pasien sendiri
                @endif
                @if ($dnr->keputusan == 2)
                    Tenaga kesehatan yang ditunjuk pasien
                @endif
                @if ($dnr->keputusan == 3)
                    Wali yang sah atas pasien (termasuk yang ditunjuk pengadilan)
                @endif
                @if ($dnr->keputusan == 4)
                    Anggota keluarga pasien
                @endif
            </li>
        </ul>

        <p>
            Jika hal di atas tidak dimungkinkan, maka saya, dokter yang bertandatangan di bawah ini
            memberikan perintah DNR di atas berdasarkan pada:
        </p>

        <ul>
            <li>
                @if ($dnr->dasar_perintah == 1)
                    Instruksi pasien sebelumnya
                @endif
                @if ($dnr->dasar_perintah == 2)
                    Keputusan dua orang dokter bahwa CPR akan memberikan hasil yang tidak efektif
                @endif
            </li>
        </ul>

        <table style="margin-left: 40px;">
            <tr>
                <td>Nama Dokter</td>
                <td>:</td>
                <td>{{ $dnr->dokter->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Nomor Induk Dokter</td>
                <td>:</td>
                <td>{{ empty($dnr->dokter->detail->nip_baru) ? $dnr->dokter->detail->kd_karyawan : $dnr->dokter->detail->nip_baru }}
                </td>
            </tr>
            <tr>
                <td>Nomor HP Dokter</td>
                <td>:</td>
                <td>{{ $dnr->no_hp_dokter }}</td>
            </tr>
        </table>
        
    </main>

    <footer>
        <div class="">
            <p style="margin: 0;">Langsa, {{ date('d-m-Y', strtotime($dnr->tanggal)) }}</p>
            <p style="margin: 0;">Dokter yg menyatakan</p>
            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
            <p class="name-konsulen">{{ $dnr->dokter->nama_lengkap }}</p>
        </div>
    </footer>
</body>

</html>
