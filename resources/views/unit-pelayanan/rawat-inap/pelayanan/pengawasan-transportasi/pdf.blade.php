<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Pengawasan Transportasi Rawat Inap</title>

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
            font-size: 14px;
        }

        main .letter-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 30px;
            text-decoration: underline;
        }

        footer {
            width: 100%;
            display: table;
            margin-top: 10px;
            font-size: 14px;
        }

        footer div {
            display: table-cell;
            vertical-align: top;
            text-align: center;
            width: fit-content;
        }

        footer div .name-konsulen {
            margin: 30px 0 0 0;
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
            PENGAWASAN TRANSPORTASI PASIEN
        </p>

        <table style="width: 100%" border="1">
            <tr>
                <td colspan="3"><strong>Dari : </strong> {{ $pengawasan->asal_keberangkatan }}</td>
            </tr>
            <tr>
                <td colspan="3">
                    <strong>Keperluan transportasi : </strong>
                    @if ($pengawasan->keperluan == 1)
                        Rujuk ke RS : {{ $pengawasan->rs_rujuk }}
                    @endif

                    @if ($pengawasan->keperluan == 2)
                        Masuk/alih rawat inap
                    @endif

                    @if ($pengawasan->keperluan == 3)
                        Pindah RS
                    @endif

                    @if ($pengawasan->keperluan == 4)
                        Pra/ pasca tindakan
                    @endif

                    @if ($pengawasan->keperluan == 5)
                        Penjemputan
                    @endif

                    @if ($pengawasan->keperluan == 6)
                        Evakuasi
                    @endif
                </td>
            </tr>
            <tr style="background-color: #dadada">
                <th align="middle" colspan="3">Kondisi Pasien Saat Berangkat</th>
            </tr>
            <tr>
                <td colspan="3">
                    <strong>Waktu : </strong>
                    {{ date('d-m-Y', strtotime($pengawasan->tanggal_berangkat)) . ' ' . date('H:i', strtotime($pengawasan->jam_berangkat)) }}
                    WIB
                </td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align: top;">
                    <strong>Catatan Khusus : </strong>
                    <br>
                    {{ $pengawasan->catatan_khusus_berangkat }}
                </td>
                <td>
                    <table border="0" style="width: 100%">
                        <tr>
                            <td>Tek. Darah</td>
                            <td>:</td>
                            <td>{{ $pengawasan->sistole_berangkat . '/' . $pengawasan->diastole_berangkat }}</td>
                            <td align="right">
                                mmHg
                            </td>
                        </tr>
                        <tr>
                            <td>Frek. Nadi</td>
                            <td>:</td>
                            <td>{{ $pengawasan->nadi_berangkat }}</td>
                            <td align="right">
                                kali/mnt
                            </td>
                        </tr>
                        <tr>
                            <td>Frek. Nafas</td>
                            <td>:</td>
                            <td>{{ $pengawasan->nafas_berangkat }}</td>
                            <td align="right">
                                kali/mnt
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table border="0" style="width: 100%">
                        <tr>
                            <td>Suhu</td>
                            <td>:</td>
                            <td>{{ $pengawasan->suhu_berangkat }} &deg;C</td>
                            <td align="right">
                            </td>
                        </tr>
                        <tr>
                            <td>Skala nyeri (VAS)</td>
                            <td>:</td>
                            <td>{{ $pengawasan->skala_nyeri_berangkat }}</td>
                            <td align="right">

                            </td>
                        </tr>
                        <tr>
                            <td>GCS</td>
                            <td>:</td>
                            <td>
                                E: {{ $pengawasan->gcs_e_berangkat }}
                                M: {{ $pengawasan->gcs_m_berangkat }}
                                V: {{ $pengawasan->gcs_v_berangkat }}
                            </td>
                            <td align="right"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Skor resiko nafas :

                    @if ($pengawasan->resiko_nafas_berangkat == 1)
                        Tidak beresiko
                    @endif
                    @if ($pengawasan->resiko_nafas_berangkat == 2)
                        Resiko rendah
                    @endif
                    @if ($pengawasan->resiko_nafas_berangkat == 3)
                        Resiko tinggi
                    @endif
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-top: 20px;" border="1">
            <tr>
                <td colspan="2">
                    <strong>Kriteria Transportasi pasien:</strong>

                    @if ($pengawasan->kriteria == 1)
                        Emergensi
                    @endif

                    @if ($pengawasan->kriteria == 2)
                        Urgensi
                    @endif

                    @if ($pengawasan->kriteria == 3)
                        Non-urgensi
                    @endif
                </td>
            </tr>

            <tr>
                <td style="text-align: center; background-color: #dadada;">
                    <strong>Nama petugas transportasi</strong>
                </td>
                <td style="text-align: center; background-color: #dadada;">
                    <strong>Cara transportasi</strong>
                </td>
            </tr>

            <tr>
                <td>
                    <table style="width: 100%;" border="0">
                        <tr>
                            <td>Dokter</td>
                            <td>:</td>
                            <td>{{ $pengawasan->dokter->nama_lengkap ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Perawat</td>
                            <td>:</td>
                            <td>{{ $pengawasan->perawat->gelar_depan ?? '' }}
                                {{ str()->title($pengawasan->perawat->nama ?? '') }}
                                {{ $pengawasan->perawat->gelar_belakang ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Pramu husada</td>
                            <td>:</td>
                            <td>{{ $pengawasan->pramuhusada->gelar_depan ?? '' }}
                                {{ str()->title($pengawasan->pramuhusada->nama ?? '') }}
                                {{ $pengawasan->pramuhusada->gelar_belakang ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Pengemudi</td>
                            <td>:</td>
                            <td>{{ $pengawasan->pengemudi->gelar_depan ?? '' }}
                                {{ str()->title($pengawasan->pengemudi->nama ?? '') }}
                                {{ $pengawasan->pengemudi->gelar_belakang ?? '' }}</td>
                        </tr>
                    </table>
                </td>

                <td style="text-align: center;">
                    @if ($pengawasan->cara_transportasi == 1)
                        Kursi roda
                    @endif
                    @if ($pengawasan->cara_transportasi == 2)
                        Brankar RJP
                    @endif
                    @if ($pengawasan->cara_transportasi == 3)
                        Brankar non RJP
                    @endif
                    @if ($pengawasan->cara_transportasi == 4)
                        Ambulans : {{ $pengawasan->plat_ambulans }}
                    @endif
                    @if ($pengawasan->cara_transportasi == 5)
                        Gawat darurat
                    @endif
                    @if ($pengawasan->cara_transportasi == 6)
                        Non gawat darurat
                    @endif
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-top: 20px;" border="1">
            <tr style="background-color: #dadada;">
                <td style="text-align: center;" colspan="{{ count($pengawasan->detail) + 1 }}"><strong>Pengawasan
                        Selama Transportasi</strong></td>
            </tr>

            <tr>
                <td style="text-align: center;"><strong>Jam</strong>
                </td>

                @foreach ($pengawasan->detail as $jam)
                    <td style="text-align: center;">{{ date('H:i', strtotime($jam->jam_pengawasan)) }} WIB</td>
                @endforeach
            </tr>

            <tr>
                <td>
                    Tek. Darah (mmHg)
                </td>

                @foreach ($pengawasan->detail as $darah)
                    <td style="text-align: center;">
                        {{ $darah->sistole_pengawasan . '/' . $darah->diastole_pengawasan }}</td>
                @endforeach
            </tr>

            <tr>
                <td>
                    Frek. Nadi (x/mnt)
                </td>

                @foreach ($pengawasan->detail as $nadi)
                    <td style="text-align: center;">
                        {{ $nadi->nadi_pengawasan }}</td>
                @endforeach
            </tr>

            <tr>
                <td>
                    Frek. Nafas (x/mnt)
                </td>

                @foreach ($pengawasan->detail as $nafas)
                    <td style="text-align: center;">
                        {{ $nafas->nafas_pengawasan }}</td>
                @endforeach
            </tr>

            <tr>
                <td>
                    Suhu (&deg;C)
                </td>

                @foreach ($pengawasan->detail as $suhu)
                    <td style="text-align: center;">
                        {{ $suhu->suhu_pengawasan }}</td>
                @endforeach
            </tr>

            <tr>
                <td>
                    Skor nyeri (1-10)
                </td>

                @foreach ($pengawasan->detail as $skala_nyeri)
                    <td style="text-align: center;">
                        {{ $skala_nyeri->skala_nyeri_pengawasan }}</td>
                @endforeach
            </tr>

            <tr>
                <td>
                    G C S
                </td>

                @foreach ($pengawasan->detail as $gcs)
                    <td style="text-align: center;">
                        E: {{ $gcs->gcs_e_pengawasan }}
                        M: {{ $gcs->gcs_m_pengawasan }}
                        V: {{ $gcs->gcs_v_pengawasan }}
                    </td>
                @endforeach
            </tr>

            <tr>
                <td>
                    <strong>Masalah</strong>
                </td>
                <td colspan="{{ count($pengawasan->detail) + 1 }}">
                    :
                    {{ $pengawasan->masalah }}
                </td>
            </tr>

            <tr>
                <td>
                    <strong>Tindakan</strong>
                </td>
                <td colspan="{{ count($pengawasan->detail) + 1 }}">
                    :
                    {{ $pengawasan->tindakan }}
                </td>
            </tr>
        </table>

        <table style="width: 100%; margin-top: 20px;" border="1">
            <tr style="background-color: #dadada">
                <th align="middle" colspan="3">Kondisi Pasien Saat Sampai Tujuan</th>
            </tr>
            <tr>
                <td colspan="3">
                    <strong>Waktu : </strong>
                    {{ date('d-m-Y', strtotime($pengawasan->tanggal_sampai)) . ' ' . date('H:i', strtotime($pengawasan->jam_sampai)) }}
                    WIB
                </td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align: top;">
                    <strong>Catatan Khusus : </strong>
                    <br>
                    {{ $pengawasan->catatan_khusus_sampai }}
                </td>
                <td>
                    <table border="0" style="width: 100%">
                        <tr>
                            <td>Tek. Darah</td>
                            <td>:</td>
                            <td>{{ $pengawasan->sistole_sampai . '/' . $pengawasan->diastole_sampai }}</td>
                            <td align="right">
                                mmHg
                            </td>
                        </tr>
                        <tr>
                            <td>Frek. Nadi</td>
                            <td>:</td>
                            <td>{{ $pengawasan->nadi_sampai }}</td>
                            <td align="right">
                                kali/mnt
                            </td>
                        </tr>
                        <tr>
                            <td>Frek. Nafas</td>
                            <td>:</td>
                            <td>{{ $pengawasan->nafas_sampai }}</td>
                            <td align="right">
                                kali/mnt
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table border="0" style="width: 100%">
                        <tr>
                            <td>Suhu</td>
                            <td>:</td>
                            <td>{{ $pengawasan->suhu_sampai }} &deg;C</td>
                            <td align="right">
                            </td>
                        </tr>
                        <tr>
                            <td>Skala nyeri (VAS)</td>
                            <td>:</td>
                            <td>{{ $pengawasan->skala_nyeri_sampai }}</td>
                            <td align="right">

                            </td>
                        </tr>
                        <tr>
                            <td>GCS</td>
                            <td>:</td>
                            <td>
                                E: {{ $pengawasan->gcs_e_sampai }}
                                M: {{ $pengawasan->gcs_m_sampai }}
                                V: {{ $pengawasan->gcs_v_sampai }}
                            </td>
                            <td align="right"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    Skor resiko nafas :

                    @if ($pengawasan->resiko_nafas_sampai == 1)
                        Tidak beresiko
                    @endif
                    @if ($pengawasan->resiko_nafas_sampai == 2)
                        Resiko rendah
                    @endif
                    @if ($pengawasan->resiko_nafas_sampai == 3)
                        Resiko tinggi
                    @endif
                </td>
            </tr>
        </table>
    </main>

    <footer>
        <div>
            <p>Petugas Penerima Pasien</p>
            <img src="{{ generateQrCode($pengawasan->petugas_penerima, 100, 'svg_datauri') }}" alt="QR">
            <p class="name-konsulen">
                {{ $pengawasan->petugas_penerima }}
            </p>
        </div>

        <div>
            <p>Petugas Transportasi</p>
            <img src="{{ generateQrCode($pengawasan->userCreate->karyawan->nama, 100, 'svg_datauri') }}"
                alt="QR">
            <p class="name-konsulen">
                {{ $pengawasan->userCreate->karyawan->gelar_depan ?? '' }}
                {{ str()->title($pengawasan->userCreate->karyawan->nama ?? '') }}
                {{ $pengawasan->userCreate->karyawan->gelar_belakang ?? '' }}
            </p>
        </div>
    </footer>
</body>

</html>
