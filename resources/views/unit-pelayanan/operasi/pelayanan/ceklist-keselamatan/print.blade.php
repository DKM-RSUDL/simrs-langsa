<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Checklist Keselamatan Pasien</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-left .hospital-info {
            display: inline-block;
        }

        .header-left h2 {
            font-size: 12px;
            margin: 0;
        }

        .header-left p {
            font-size: 10px;
            margin: 1px 0;
        }

        .header-right {
            text-align: right;
        }

        .header-right p {
            font-size: 10px;
            margin: 1px 0;
        }

        .main-title {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }

        .container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .section {
            flex: 1;
            border: 1px solid #000;
            padding: 5px;
            box-sizing: border-box;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        .section-subtitle {
            font-size: 9px;
            font-style: italic;
            text-align: center;
            margin-bottom: 5px;
        }

        .team-info {
            font-size: 9px;
            margin-bottom: 5px;
        }

        .team-info p {
            margin: 1px 0;
        }

        .table-checklist {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .table-checklist th,
        .table-checklist td {
            border: 1px solid #000;
            padding: 3px;
            vertical-align: top;
        }

        .table-checklist th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .table-checklist td {
            font-size: 9px;
        }

        .table-checklist .no-col {
            width: 8%;
            text-align: center;
        }

        .table-checklist .desc-col {
            width: 62%;
        }

        .table-checklist .yes-col,
        .table-checklist .no-col {
            width: 15%;
            text-align: center;
        }

        .table-signature {
            width: 100%;
            border-collapse: collapse;
        }

        .table-signature th,
        .table-signature td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
            font-size: 9px;
        }

        .table-signature th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .notes {
            font-size: 9px;
            margin-top: 5px;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }

            .container {
                gap: 5px;
            }

            .section {
                padding: 3px;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <img src="{{ asset('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="RSUD Langsa Logo"
                style="width: 40px; height: auto; margin-right: 10px;">
            <div class="hospital-info">
                <h2>RSUD LANGSA</h2>
                <p>Jl. Jend. A. Yani No.1</p>
                <p>Kota Langsa</p>
                <p>Telp: 0641-22051</p>
            </div>
        </div>
        <div class="header-right">
            <p><strong>No RM:</strong> {{ $dataMedis->kd_pasien }}</p>
            <p><strong>Nama:</strong> {{ $dataMedis->pasien->nama }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}</p>
            <p><strong>Tanggal Lahir:</strong>
                {{ \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') }}</p>
            <p><strong>Usia:</strong> {{ $dataMedis->pasien->umur }} Tahun</p>
        </div>
    </div>

    <div class="main-title">Ceklist Keselamatan Pasien Operasi</div>

    <!-- Main Container for Side-by-Side Sections -->
    <div class="container">
        <!-- Sign In Section -->
        <div class="section">
            <div class="section-title">Sebelum Induksi Anestesi (Sign In)</div>
            <div class="section-subtitle">Minimal oleh Perawat dan Dokter Anestesi</div>
            @if ($signInList->isNotEmpty())
                @foreach ($signInList as $signIn)
                    <div class="team-info">
                        <p><strong>KETERANGAN:</strong>
                            {{ \Carbon\Carbon::parse($signIn->waktu_signin)->format('d-m-Y H:i') }}</p>
                    </div>
                    <table class="table-checklist">
                        <thead>
                            <tr>
                                <th class="no-col">NO</th>
                                <th class="desc-col">KETERANGAN</th>
                                <th class="yes-col">YA</th>
                                <th class="no-col">TIDAK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="no-col">1</td>
                                <td class="desc-col"><strong>Pasien telah dikonfirmasikan</strong></td>
                                <td class="yes-col"></td>
                                <td class="no-col"></td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">a. Identifikasi dan gelang pasien</td>
                                <td class="yes-col">{{ $signIn->identifikasi ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->identifikasi ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">b. Lokasi operasi</td>
                                <td class="yes-col">{{ $signIn->lokasi ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->lokasi ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">c. Prosedur Operasi</td>
                                <td class="yes-col">{{ $signIn->prosedur ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->prosedur ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">d. Informed Consent Anestesi</td>
                                <td class="yes-col">{{ $signIn->informed_anestesi ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->informed_anestesi ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">e. Informed Consent Operasi</td>
                                <td class="yes-col">{{ $signIn->informed_operasi ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->informed_operasi ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">2</td>
                                <td class="desc-col">Lokasi operasi sudah diberi tanda?</td>
                                <td class="yes-col">{{ $signIn->tanda_lokasi ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->tanda_lokasi ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">3</td>
                                <td class="desc-col">Mesin dan obat-obat anestesi sudah di cek lengkap?</td>
                                <td class="yes-col">{{ $signIn->mesin_obat ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->mesin_obat ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">4</td>
                                <td class="desc-col">Pulse oximeter sudah terpasang dan berfungsi?</td>
                                <td class="yes-col">{{ $signIn->pulse_oximeter ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->pulse_oximeter ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">5</td>
                                <td class="desc-col">Kesulitan bernafas/resiko aspirasi?</td>
                                <td class="yes-col">{{ $signIn->kesulitan_bernafas ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->kesulitan_bernafas ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">6</td>
                                <td class="desc-col">Resiko kehilangan darah > 500 ml (7 ml/kg BB pada anak)?</td>
                                <td class="yes-col">{{ $signIn->resiko_darah ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->resiko_darah ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">7</td>
                                <td class="desc-col">Dua akses intravena/akses sentral dan rencana terapi cairan?</td>
                                <td class="yes-col">{{ $signIn->akses_intravena ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signIn->akses_intravena ? '' : '☑' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table-signature">
                        <thead>
                            <tr>
                                <th>Tim</th>
                                <th>Nama</th>
                                <th>Tanda Tangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ahli Anestesi</td>
                                <td>{{ $signIn->dokterAnestesi->dokter->nama_lengkap ?? 'Tidak Tersedia' }}</td>
                                <td>........</td>
                            </tr>
                            <tr>
                                <td>Perawat</td>
                                <td>{{ $signIn->perawatData->nama ?? 'Tidak Tersedia' }}</td>
                                <td>........</td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            @else
                <p style="text-align: center; font-size: 9px;">Data Sign In belum tersedia.</p>
            @endif
        </div>

        <!-- Time Out Section -->
        <div class="section">
            <div class="section-title">Sebelum Insisi (Time Out)</div>
            <div class="section-subtitle">Diisi oleh Perawat, Dokter Anestesi dan Operator</div>
            @if ($timeoutList->isNotEmpty())
                @foreach ($timeoutList as $timeout)
                    <div class="team-info">
                        <p><strong>KETERANGAN:</strong>
                            {{ \Carbon\Carbon::parse($timeout->waktu_timeout)->format('d-m-Y H:i') }}</p>
                    </div>
                    <table class="table-checklist">
                        <thead>
                            <tr>
                                <th class="no-col">NO</th>
                                <th class="desc-col">KETERANGAN</th>
                                <th class="yes-col">YA</th>
                                <th class="no-col">TIDAK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="no-col">1</td>
                                <td class="desc-col">Konfirmasi seluruh anggota tim telah memperkenalkan nama dan peran
                                </td>
                                <td class="yes-col">{{ $timeout->konfirmasi_tim ? '☑' : '' }}</td>
                                <td class="no-col">{{ $timeout->konfirmasi_tim ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">2</td>
                                <td class="desc-col"><strong>Dokter bedah, dokter anestesi dan Perawat melakukan
                                        konfirmasi secara Verbal:</strong></td>
                                <td class="yes-col"></td>
                                <td class="no-col"></td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">a. Nama pasien</td>
                                <td class="yes-col">{{ $timeout->konfirmasi_nama ? '☑' : '' }}</td>
                                <td class="no-col">{{ $timeout->konfirmasi_nama ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">b. Prosedur</td>
                                <td class="yes-col">{{ $timeout->konfirmasi_prosedur ? '☑' : '' }}</td>
                                <td class="no-col">{{ $timeout->konfirmasi_prosedur ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">c. Lokasi dimana insisi akan dibuat/posisi</td>
                                <td class="yes-col">{{ $timeout->konfirmasi_lokasi ? '☑' : '' }}</td>
                                <td class="no-col">{{ $timeout->konfirmasi_lokasi ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">3</td>
                                <td class="desc-col">Apakah antibiotic profilaksis sudah diberikan sebelumnya?</td>
                                <td class="yes-col">{{ $timeout->antibiotik_profilaksis ? '☑' : '' }}</td>
                                <td class="no-col">{{ $timeout->antibiotik_profilaksis ? '' : '☑' }}</td>
                            </tr>
                            @if ($timeout->antibiotik_profilaksis)
                                <tr>
                                    <td class="no-col"></td>
                                    <td class="desc-col">a. Nama antibiotic yang diberikan:
                                        </td>
                                    <td class="yes-col" colspan="2">{{ $timeout->nama_antibiotik ?: 'Tidak tercatat' }}</td>
                                </tr>
                                <tr>
                                    <td class="no-col"></td>
                                    <td class="desc-col">b. Dosis antibiotic yang diberikan:
                                        </td>
                                    <td class="yes-col" colspan="2">{{ $timeout->dosis_antibiotik ?: 'Tidak tercatat' }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="no-col">4</td>
                                <td class="desc-col"><strong>Antisipasi Kejadian Kritis:</strong></td>
                                <td class="yes-col"></td>
                                <td class="no-col"></td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">a. Review dokter bedah: langkah apa yang akan dilakukan bila kondisi kritis atau kejadian yang tidak diharapkan lamanya operasi, antisipasi kehilangan darah?</td>
                                <td class="yes-col" colspan="2">{{ $timeout->review_bedah ?: 'Tidak ada catatan' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">b. Review tim anestesi: apakah ada hal khusus yang perlu
                                    diperhatikan pada pasien?
                                    <br></td>
                                <td class="yes-col" colspan="2">{{ $timeout->review_anastesi ?: 'Tidak ada catatan' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">c. Review tim perawat: apakah peralatan sudah steril, adakah
                                    alat-alat yang perlu diperhatikan khusus atau dalam masalah?
                                    <br></td>
                                <td class="yes-col" colspan="2">{{ $timeout->review_perawat ?: 'Tidak ada catatan' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">5</td>
                                <td class="desc-col">Apakah foto rontgen/CT-Scan dan MRI telah ditayangkan?</td>
                                <td class="yes-col">{{ $timeout->foto_rontgen ? '☑' : '' }}</td>
                                <td class="no-col">{{ $timeout->foto_rontgen ? '' : '☑' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table-signature">
                        <thead>
                            <tr>
                                <th>Tim</th>
                                <th>Nama</th>
                                <th>Tanda Tangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ahli Bedah</td>
                                <td>{{ $timeout->dokterBedah->nama_lengkap ?? 'Tidak Tersedia' }}</td>
                                <td>........</td>
                            </tr>
                            <tr>
                                <td>Ahli Anestesi</td>
                                <td>{{ $timeout->dokterAnastesi->dokter->nama_lengkap ?? 'Tidak Tersedia' }}</td>
                                <td>........</td>
                            </tr>
                            <tr>
                                <td>Perawat</td>
                                <td>{{ $timeout->perawatData->nama ?? 'Tidak Tersedia' }}</td>
                                <td>........</td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            @else
                <p style="text-align: center; font-size: 9px;">Data Time Out belum tersedia.</p>
            @endif
        </div>

        <!-- Sign Out Section -->
        <div class="section">
            <div class="section-title">Sebelum Tutup Luka Operasi (Sign Out)</div>
            <div class="section-subtitle">Diisi oleh Perawat, Dokter Anestesi dan Operator</div>
            @if ($signoutList->isNotEmpty())
                @foreach ($signoutList as $signout)
                    <div class="team-info">
                        <p><strong>KETERANGAN:</strong>
                            {{ \Carbon\Carbon::parse($signout->waktu_signout)->format('d-m-Y H:i') }}</p>
                    </div>
                    <table class="table-checklist">
                        <thead>
                            <tr>
                                <th class="no-col">NO</th>
                                <th class="desc-col">KETERANGAN</th>
                                <th class="yes-col">YA</th>
                                <th class="no-col">TIDAK</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="no-col">1</td>
                                <td class="desc-col"><strong>Perawat melakukan konfirmasi secara verbal dengan
                                        tim:</strong></td>
                                <td class="yes-col"></td>
                                <td class="no-col"></td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">a. Nama prosedur tindakan telah dicatat</td>
                                <td class="yes-col">{{ $signout->konfirmasi_prosedur ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signout->konfirmasi_prosedur ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">b. Instrumen, sponge, dan jarum telah dihitung dengan benar</td>
                                <td class="yes-col">{{ $signout->konfirmasi_instrumen ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signout->konfirmasi_instrumen ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">c. Spesimen telah diberi label (termasuk nama pasien dan asal
                                    jaringan specimen)</td>
                                <td class="yes-col">{{ $signout->konfirmasi_spesimen ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signout->konfirmasi_spesimen ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col"></td>
                                <td class="desc-col">d. Adakah masalah dengan peralatan selama operasi?</td>
                                <td class="yes-col">{{ $signout->masalah_peralatan ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signout->masalah_peralatan ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">2</td>
                                <td class="desc-col">Dokter bedah, dokter Anestesi, dan perawat melakukan review
                                    masalah utama apa yang harus diperhatikan untuk penyembuhan dan manajemen pasien
                                    selanjutnya</td>
                                <td class="yes-col">{{ $signout->review_tim ? '☑' : '' }}</td>
                                <td class="no-col">{{ $signout->review_tim ? '' : '☑' }}</td>
                            </tr>
                            <tr>
                                <td class="no-col">3</td>
                                <td class="desc-col">Hal-hal yang harus diperhatikan:</td>
                                <td class="yes-col" colspan="2">{{ $signout->catatan_penting ?: 'Tidak ada catatan' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table-signature">
                        <thead>
                            <tr>
                                <th>Tim</th>
                                <th>Nama</th>
                                <th>Tanda Tangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ahli Bedah</td>
                                <td>{{ $signout->dokterBedah->nama_lengkap ?? 'Tidak Tersedia' }}</td>
                                <td>........</td>
                            </tr>
                            <tr>
                                <td>Ahli Anestesi</td>
                                <td>{{ $signout->dokterAnastesi->dokter->nama_lengkap ?? 'Tidak Tersedia' }}</td>
                                <td>........</td>
                            </tr>
                            <tr>
                                <td>Perawat</td>
                                <td>{{ $signout->perawatData->nama ?? 'Tidak Tersedia' }}</td>
                                <td>........</td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            @else
                <p style="text-align: center; font-size: 9px;">Data Sign Out belum tersedia.</p>
            @endif
        </div>
    </div>

    <div class="no-print mt-3">
        <a href="{{ route('operasi.pelayanan.ceklist-keselamatan.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
            class="btn btn-primary btn-sm">Kembali</a>
    </div>

</body>

</html>
