<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Hasil Pemeriksaan Laboratorium</title>
    <link href="{{ public_path('assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <style>

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .logo-right {
            width: 100px;
        }

        .header-text {
            flex-grow: 1;
            text-align: center;
            margin: 0 20px;
        }

        .hospital-name {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .contact-info {
            font-size: 7pt;
            line-height: 1.2;
        }

        .divider {
            border-bottom: 2px solid #000;
            margin: 10px 0 20px;
        }

        .report-title {
            text-align: center;
            margin: 20px 0;
        }

        .report-title h2 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .report-number {
            text-align: center;
            font-size: 12pt;
            margin-bottom: 20px;
        }

        .patient-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .patient-info-column {
            width: 48%;
        }

        .info-row {
            display: flex;
            margin-bottom: 8px;
        }

        .info-label {
            width: 150px;
            font-weight: bold;
        }

        .info-value {
            flex-grow: 1;
        }

        @media print {
            body {
                margin: 2cm;
            }

            .container {
                max-width: 100% !important;
                padding: 0 !important;
            }
        }

        .info-container {
            display: flex;
            margin: 20px 0;
        }

        .info-left, .info-right {
            flex: 1;
        }

        .info-row {
            display: flex;
            margin: 8px 0;
            line-height: 1.2;
        }

        .info-label {
            width: 140px;
            margin-right: 5px;
        }

        .info-colon {
            width: 20px;
            text-align: center;
        }

        .info-value {
            flex: 1;
        }

        .info-text {
            margin: 0;
        }

        .info-italic {
            font-style: italic;
            color: #666;
            font-size: 11px;
            margin-top: 2px;
        }
    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD" class="logo">
            <div class="header-text">
                <div class="hospital-name">
                    INSTALASI LABORATORIUM<br>
                    RUMAH SAKIT UMUM DAERAH LANGSA
                </div>
                <div class="contact-info">
                    Alamat : Jln. Jend. A. Yani No.1 Kota Langsa, Telp. (0641) 22051 - 22800 (IGD), Fax. (0641)
                    22051<br>
                    Email : rsudlangsa.aceh@gmail.com, rsud@langsakota.go.id, Website : www.rsud.langsakota.go.id
                </div>
            </div>
            <img src="{{ public_path('assets/img/microscope.png') }}" alt="Logo Lab" class="logo logo-right">
        </header>

        <div class="divider"></div>

        <div class="report-title">
            <h2>HASIL PEMERIKSAAN LABORATORIUM KLINIK</h2>
            <p><i>Clinical Laboratory Examination Result</i></p>
        </div>

        <div class="report-number">
            NOMOR / NUMBER: {{ $dataMedis->registrasiHasil->no_lab ?? '0249689/LAB-RSUDL/2024' }}
        </div>

        <!-- Informasi Pasien -->
        <div class="info-container">
            <div class="info-left">
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">No. Rekam Medis</p>
                        <i class="info-italic">Medical Record Number</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ $dataMedis->kd_pasien }}</p>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">Pasien</p>
                        <i class="info-italic">Patient</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ $dataMedis->pasien->nama }}</p>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">NIK</p>
                        <i class="info-italic">Identity Number</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ $dataMedis->pasien->no_pengenal }}</p>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">Jenis Kelamin</p>
                        <i class="info-italic">Sex</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ $dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Laki-laki' }}</p>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">Tgl. Lahir/Umur</p>
                        <i class="info-italic">Date Of Birth/Age</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') }} / {{ $dataMedis->pasien->umur }}</p>
                </div>
            </div>

            <div class="info-right">
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">No. Lab</p>
                        <i class="info-italic">Lab. Number</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ $dataMedis->registrasiHasil->no_lab }}</p>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">Tgl. Reg</p>
                        <i class="info-italic">Registration Date</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ $dataMedis->registrasiHasil->tgl_reg }}</p>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">Tgl. Periksa</p>
                        <i class="info-italic">Check Date</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ date('d-m-Y H:i', strtotime($dataMedis->registrasiHasil->tgl_periksa)) }}</p>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">Tgl. Selesai</p>
                        <i class="info-italic">Date Of Completion</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ date('d-m-Y H:i', strtotime($dataMedis->registrasiHasil->tgl_selesai)) }}</p>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">Ruangan</p>
                        <i class="info-italic">Room</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ $dataMedis->unit->nama_unit }}</p>
                </div>
                <div class="info-row">
                    <div class="info-label">
                        <p class="info-text">Dokter Lab</p>
                        <i class="info-italic">Lab Doctor</i>
                    </div>
                    <div class="info-colon">:</div>
                    <p class="info-value">{{ $dataMedis->dokter->nama_lengkap }}</p>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item Test</th>
                    <th>Hasil</th>
                    <th>Satuan</th>
                    <th>Nilai Normal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataLabor as $labor)
                    @if (isset($labor->labResults) && !empty($labor->labResults))
                        @foreach ($labor->labResults as $namaProduk => $tests)
                            <tr class="table-secondary">
                                <td colspan="5" class="fw-bold">{{ $namaProduk }}</td>
                            </tr>
                            @foreach ($tests as $test)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $test['item_test'] }}</td>
                                    <td>{!! $test['hasil'] !!}</td>
                                    <td>{{ $test['satuan'] }}</td>
                                    <td>{{ $test['nilai_normal'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada hasil pemeriksaan</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
    </div>
    </div>
</body>

</html>
