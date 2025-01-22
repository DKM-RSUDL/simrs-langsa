<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Hasil Pemeriksaan Laboratorium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 2cm;
            padding: 0;
            font-family: "Times New Roman", Times, serif;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .hospital-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }

        .hospital-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .logo-left {
            margin-right: 20px;
        }

        .logo-right {
            margin-left: 20px;
        }

        .hospital-title {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .contract-title {
            text-align: center;
            margin: 15px 0;
        }

        .contract-title h5 {
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 5px;
            text-decoration: underline;
        }

        .contract-title p {
            margin: 5px 0;
            font-size: 12pt;
        }

        .contract-number {
            text-align: center;
            margin: 10px 0;
            font-size: 12pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th {
            background-color: #ffffff !important;
            color: black;
            font-weight: bold;
            border: 1px solid #000;
        }

        table th,
        table td {
            padding: 8px;
            border: 1px solid #000;
            font-size: 11pt;
        }

        @media print {
            @page {
                margin: 0;
            }

            body {
                margin: 2cm;
            }

            .container {
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            .card-body {
                padding: 0 !important;
            }

            table {
                width: 100% !important;
            }

            /* Hide browser's header and footer */
            head,
            header,
            footer,
            title {
                display: none !important;
            }

            /* Force background colors to print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <!-- Hospital Header -->
                        <div class="hospital-header">
                            <div class="header-content">
                                <img src="{{ asset('https://rsud.langsakota.go.id/wp-content/uploads/2020/03/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD" class="hospital-logo logo-left">
                                <div>
                                    <div class="fw-bold">INSTALASI LABORATORIUM</div>
                                    <div class="fw-bold">RUMAH SAKIT UMUM DAERAH LANGSA</div>
                                    <p>Alamat : Jln. Jend. A. Yani No.1 Kota Langsa, Telp. (0641) 22051 - 22800 (IGD), Fax. (0641) 22051</p>
                                    <p>Email : rsudlangsa.aceh@gmail.com, rsud@langsakota.go.id, Website : www.rsud.langsakota.go.id</p>
                                </div>
                                <img src="{{ asset('https://sippn.menpan.go.id/images/article/large/logo-kota-langsa1.png') }}" alt="Logo Kota" class="hospital-logo logo-right">
                            </div>
                        </div>

                        <!-- Contract Title -->
                        <div class="contract-title">
                            <h6 class="fw-bold">HASIL PEMERIKSAAN LABORATORIUM KLINIK</h6>
                            <i>Clinical Laboratory Examination Result</i>
                        </div>

                        <!-- Contract Number -->
                        <div class="contract-number">
                            <p>NOMOR / NUMBER: 0249689/LAB-RSUDL/2024</p>
                        </div>

                        <!-- Informasi Pasien -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless" border="0">
                                    <tr>
                                        <td>No. Rekam Medis<i>Medical Record Number</i></td>
                                        <td>: {{ $dataMedis->kd_pasien }}</td>
                                    </tr>
                                    <tr>
                                        <td width="150">Pasien<i>Patient</i></td>
                                        <td>: {{ $dataMedis->pasien->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir</td>
                                        <td>: {{ \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="150">Dokter</td>
                                        <td>: {{ $dataMedis->dokter->nama_lengkap }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Periksa</td>
                                        <td>: {{ \Carbon\Carbon::parse($dataMedis->tgl_masuk)->format('d/m/Y') }}</td>
                                    </tr>
                                    @if ($dataDiagnosis)
                                        <tr>
                                            <td>Diagnosis</td>
                                            <td>: {{ implode(', ', $diagnosisList) }}</td>
                                        </tr>
                                    @endif
                                </table>
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
