<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Resume Medis</title>

    <style>
        body {
            font-family: Arial, sans-serif;
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
        }

        main table {
            width: 100%;
            border-collapse: collapse;
        }

        main table th,
        main table td {
            text-align: left;
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        main table .table-section-title th {
            text-align: center;
            background-color: #dddddd
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
        <div class="center-column">
            <p>Resume Medis<br>Rawat Inap</p>
        </div>
        <div class="right-column">
            <table class="info-table">
                <tr>
                    <td><strong>No RM</strong></td>
                    <td>{{ $resume->kd_pasien }}</td>
                </tr>
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>{{ str()->title($resume->pasien->nama) }}</td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>
                        @php
                            $gender = '-';

                            if ($resume->pasien->jenis_kelamin == 1) {
                                $gender = 'Laki-Laki';
                            }
                            if ($resume->pasien->jenis_kelamin == 0) {
                                $gender = 'Perempuan';
                            }

                            echo $gender;
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>{{ date('d/m/Y', strtotime($resume->pasien->tgl_lahir)) }}</td>
                </tr>
            </table>
        </div>
    </header>

    <main>
        <table border="1">
            <tr>
                <th>Ruang</th>
                <td>{{ $resume->unit->nama_unit }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{ date('d/m/Y', strtotime($resume->tgl_masuk)) }}</td>
            </tr>
            <tr>
                <th>Tanggal Keluar</th>
                <td>{{ $resume->rmeResumeDet->tgl_pulang ? date('d/m/Y', strtotime($resume->rmeResumeDet->tgl_pulang)) : '-' }}
                </td>
            </tr>
            <tr>
                <th>Lama Dirawat</th>
                <td>
                    {{ !empty($resume->rmeResumeDet->tgl_pulang) ? selisihHari($resume->tgl_masuk, $resume->rmeResumeDet->tgl_pulang) + 1 . ' Hari' : '-' }}
                </td>
            </tr>
            <tr>
                <th>Jaminan</th>
                <td>{{ $dataMedis->customer->customer }}</td>
            </tr>
            <tr>
                <th>Anamnesis</th>
                <td>{{ $resume->anamnesis }}</td>
            </tr>
            <tr>
                <th>Hasil Pemeriksaan Fisik</th>
                <td>
                    {{ $hasilKonpas }}

                    @if (!empty($pemeriksaanFisik))
                        <br>
                        @foreach ($pemeriksaanFisik as $pf)
                            <br>
                            {{ $pf->itemFisik->nama }} : {{ $pf->keterangan }}
                        @endforeach
                    @endif
                </td>
            </tr>
            <tr>
                <th>Temuan Klinik Penunjang</th>
                <td>
                    <p>{{ $resume->pemeriksaan_penunjang }}</p>

                    <ul>
                        @if (count($labor) > 0)
                            <li>
                                <p><strong>Lab Test</strong></p>
                                <ol>
                                    @foreach ($labor as $lab)
                                        @foreach ($lab->details as $dt)
                                            <li>
                                                {{ $dt->produk->deskripsi }} <br>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ol>
                            </li>
                        @endif

                        @if (count($radiologi) > 0)
                            <li>
                                <p><strong>Rad Test</strong></p>
                                <ol>
                                    @foreach ($radiologi as $rad)
                                        @foreach ($rad->details as $dt)
                                            <li>
                                                {{ $dt->produk->deskripsi }} <br>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ol>
                            </li>
                        @endif
                    </ul>
                </td>
            </tr>
            <tr>
                <th>Diagnosis Primer</th>
                <td>{{ $resume->diagnosis[0] ?? '-' }}</td>
            </tr>
            <tr>
                <th>Diagnosis Sekunder</th>
                <td>
                    @if (isset($resume->diagnosis[1]))
                        @for ($i = 1; $i < count($resume->diagnosis); $i++)
                            - {{ $resume->diagnosis[$i] }} <br>
                        @endfor
                    @endif
                </td>
            </tr>
            <tr>
                <th>Tindakan</th>
                <td>
                    @if (count($tindakan) > 0)
                        {{-- <p><strong>Lainnya</strong></p> --}}
                        <ol>
                            @foreach ($tindakan as $tind)
                                <li>
                                    {{ $tind->produk->deskripsi }} <br>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Terapi Selama Dirawat</th>
                <td>
                    @foreach ($resepRawat as $item)
                        - {{ "$item->nama_obat $item->cara_pakai" }} <br>
                    @endforeach
                </td>
            </tr>

            {{-- @if ($resume->rmeResumeDet->tindak_lanjut_code == 6) --}}
            <tr>
                <th>Terapi Pulang</th>
                <td>
                    @foreach ($resepPulang as $item)
                        - {{ "$item->nama_obat $item->cara_pakai" }} <br>
                    @endforeach
                </td>
            </tr>
            {{-- @endif --}}

            <tr class="table-section-title">
                <th colspan="2">Anjuran / Follow up</th>
            </tr>
            <tr>
                <th>Diet</th>
                <td>{{ $resume->anjuran_diet }}</td>
            </tr>
            <tr>
                <th>Edukasi</th>
                <td>{{ $resume->anjuran_edukasi }}</td>
            </tr>
            <tr class="table-section-title">
                <th colspan="2">Tindak lanjut</th>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ tindakLanjutLabel($resume->rmeResumeDet->tindak_lanjut_code) }}</td>
            </tr>

            @if ($resume->rmeResumeDet->tindak_lanjut_code == 6)
                <tr>
                    <th>Waktu Pulang</th>
                    <td>{{ date('d/m/Y', strtotime($resume->rmeResumeDet->tgl_pulang)) . ' ' . date('H:i', strtotime($resume->rmeResumeDet->jam_pulang)) . ' WIB' }}
                    </td>
                </tr>
                <tr>
                    <th>Alasan Pulang</th>
                    <td>{{ alasanPulangLabel($resume->rmeResumeDet->alasan_pulang) }}</td>
                </tr>
                <tr>
                    <th>Kondisi Pulang</th>
                    <td>{{ kondisiPulangLabel($resume->rmeResumeDet->kondisi_pulang) }}</td>
                </tr>
            @endif

            @if ($resume->rmeResumeDet->tindak_lanjut_code == 5)
                <tr>
                    <th>Tujuan Rujuk</th>
                    <td>{{ $resume->rmeResumeDet->rs_rujuk }}</td>
                </tr>
                {{-- <tr>
                    <th>Alasan Rujuk</th>
                    <td>{{ alasanRujukLabel($resume->rmeResumeDet->alasan_rujuk) }}</td>
                </tr>
                <tr>
                    <th>Transportasi Rujuk</th>
                    <td>{{ transportasiRujukLabel($resume->rmeResumeDet->transportasi_rujuk) }}</td>
                </tr> --}}
            @endif

            @if ($resume->rmeResumeDet->tindak_lanjut_code == 8)
                <tr>
                    <th>Tanggal</th>
                    <td>{{ date('d/m/Y', strtotime($resume->rmeResumeDet->tgl_rajal)) }}</td>
                </tr>
                <tr>
                    <th>Poli</th>
                    <td>{{ $resume->rmeResumeDet->unitRajal->nama_unit }}</td>
                </tr>
            @endif

            @if ($resume->rmeResumeDet->tindak_lanjut_code == 9)
                <tr>
                    <th>Alasan</th>
                    <td>{{ $resume->rmeResumeDet->alasan_menolak_inap }}</td>
                </tr>
            @endif

            @if ($resume->rmeResumeDet->tindak_lanjut_code == 10)
                <tr>
                    <th>Waktu</th>
                    <td>{{ date('d/m/Y', strtotime($resume->rmeResumeDet->tgl_meninggal)) . ' ' . date('H:i', strtotime($resume->rmeResumeDet->jam_meninggal)) . ' WIB' }}
                    </td>
                </tr>
            @endif

            @if ($resume->rmeResumeDet->tindak_lanjut_code == 11)
                <tr>
                    <th>Waktu</th>
                    <td>{{ date('d/m/Y', strtotime($resume->rmeResumeDet->tgl_meninggal_doa)) . ' ' . date('H:i', strtotime($resume->rmeResumeDet->jam_meninggal_doa)) . ' WIB' }}
                    </td>
                </tr>
            @endif
        </table>
    </main>

    <footer>
        <div class="left-column">
            <p>DPJP yang merawat</p>
            <br>
            <img src="data:image/png;base64,{{ generateQrCode($dataMedis->dokter->nama_lengkap) }}" alt="QR Code">

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
