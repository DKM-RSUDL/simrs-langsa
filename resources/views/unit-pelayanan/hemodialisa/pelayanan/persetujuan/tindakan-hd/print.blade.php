<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Form Persetujuan Tindakan Hemodialisa</title>
    <style>
        @page {
            size: 8.5in 13in; /* Letter/F4 size */
            margin: 10mm 12mm 10mm 12mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .header-row {
            display: table-row;
        }

        .hospital-info {
            display: table-cell;
            vertical-align: top;
            width: 30%;
            text-align: left;
        }

        .title-section {
            display: table-cell;
            vertical-align: top;
            width: 40%;
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            padding: 6px 8px 0 8px;
            line-height: 1.3;
        }

        .patient-info-cell {
            display: table-cell;
            vertical-align: top;
            width: 30%;
            text-align: right;
        }

        .hospital-info img {
            width: 45px;
            height: auto;
            vertical-align: middle;
            margin-right: 6px;
        }

        .hospital-info .info-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 9pt;
        }

        .hospital-info .info-text .title {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 1px;
        }

        .hospital-info .info-text p {
            margin: 0;
            line-height: 1.2;
        }

        .patient-info-box {
            display: inline-block;
            text-align: left;
            border: 1px solid #000;
            padding: 6px;
            font-size: 9pt;
            width: 160px;
            box-sizing: border-box;
        }

        .patient-info-box p {
            margin: 0;
            line-height: 1.2;
        }

        .content-section {
            margin: 10px 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 9.5pt;
        }

        .info-table tr {
            border: 1px solid #000;
        }

        .info-table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        .info-table .header-cell {
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 3px 6px;
        }

        .info-table .number-cell {
            width: 4%;
            text-align: center;
            padding: 4px 3px;
        }

        .info-table .label-cell {
            width: 26%;
            padding: 4px 6px;
        }

        .info-table .content-cell {
            width: 65%;
            padding: 4px 6px;
            font-size: 9pt;
        }

        .info-table .check-cell {
            width: 5%;
            text-align: center;
            padding: 4px;
        }

        .check-box {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1px solid #000;
            vertical-align: middle;
            text-align: center;
            line-height: 9px;
            font-size: 9pt;
            background-color: #fff;
            position: relative;
        }

        .check-box.checked::after {
            content: "X";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            font-size: 9pt;
            line-height: 1;
        }

        .underline {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 120px;
            text-align: center;
            margin: 0 4px;
        }

        .declaration-text {
            text-align: justify;
            margin: 8px 0;
            font-size: 9.5pt;
            line-height: 1.3;
        }

        .signature-section {
            margin-top: 20px;
        }

        .signature-table {
            width: 100%;
            font-size: 9.5pt;
        }

        .signature-table td {
            text-align: center;
            vertical-align: top;
            padding: 8px;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin-top: 50px;
            width: 140px;
            display: inline-block;
        }

        .bold {
            font-weight: bold;
        }

        hr {
            border: 0.5px solid #000; 
            margin-top: 4px; 
            margin-bottom: 8px;
        }

        /* Additional space optimization */
        table {
            font-size: 9.5pt;
        }
        
        table td {
            padding: 2px 4px;
        }

        @media print {
            body {
                font-family: Arial, sans-serif;
            }
            .info-table {
                page-break-inside: avoid;
            }
            .check-box {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER SECTION -->
    <div class="header">
        <div class="header-row">
            <div class="hospital-info">
                @if (isset($logoPath) && file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo RSUD Langsa">
                @endif
                <div class="info-text">
                    <p class="title">RSUD LANGSA</p>
                    <p>Jl. Jend. A. Yani Kota Langsa</p>
                    <p>Telp. 0641 - 32051</p>
                    <p>rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="title-section">
                DOKUMENTASI PEMBERIAN INFORMASI<br>
                (Informed Consent)
            </div>
            <div class="patient-info-cell">
                <div class="patient-info-box">
                    <p><b>NO RM: {{ $dataMedis->kd_pasien ?? 'N/A' }}</b></p>
                    <p>Nama: {{ $dataMedis->pasien->nama ?? 'N/A' }}</p>
                    <p>Jenis Kelamin:
                        {{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : 'N/A') }}
                    </p>
                    <p>Tgl Lahir:
                        {{ $dataMedis->pasien->tgl_lahir ? Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d-m-Y') : 'N/A' }}
                    </p>
                    <p>Umur: {{ $dataMedis->pasien->umur ?? 'N/A' }} Tahun</p>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <!-- MAIN CONTENT -->
    <div class="content-section">
        <table style="width: 100%; margin-bottom: 8px;">
            <tr>
                <td style="width: 25%;">Nama Tindakan</td>
                <td style="width: 5%;">:</td>
                <td style="width: 70%;"><b>HEMODIALISIS</b></td>
            </tr>
            <tr>
                <td>DPJP</td>
                <td>:</td>
                <td>{{ $dataPersetujuan->dokter->nama_lengkap ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama Pemberi Informasi</td>
                <td>:</td>
                <td>
                    @php
                        $pemberiInfo = $dataPersetujuan->kd_karyawan;
                        $namaPemberi = '-';
                        
                        if ($pemberiInfo) {
                            if (strpos($pemberiInfo, 'dokter_') === 0) {
                                $kdDokter = str_replace('dokter_', '', $pemberiInfo);
                                $dokter = \App\Models\Dokter::where('kd_dokter', $kdDokter)->first();
                                $namaPemberi = $dokter ? $dokter->nama_lengkap : '-';
                            } elseif (strpos($pemberiInfo, 'karyawan_') === 0) {
                                $kdKaryawan = str_replace('karyawan_', '', $pemberiInfo);
                                $karyawan = \App\Models\HrdKaryawan::where('kd_karyawan', $kdKaryawan)->first();
                                if ($karyawan) {
                                    $namaPemberi = trim(($karyawan->gelar_depan ?? '') . ' ' . $karyawan->nama . ' ' . ($karyawan->gelar_belakang ?? ''));
                                }
                            }
                        }
                    @endphp
                    {{ $namaPemberi }}
                </td>
            </tr>
            <tr>
                <td>Penerima informasi/<br>pemberi persetujuan</td>
                <td>:</td>
                <td>
                    @if($dataPersetujuan->tipe_penerima == 'pasien')
                        Pasien
                    @elseif($dataPersetujuan->tipe_penerima == 'keluarga')
                        Keluarga ({{ $dataPersetujuan->status_keluarga ?? '-' }})
                    @else
                        -
                    @endif
                </td>
            </tr>
        </table>

        <!-- JENIS INFORMASI TABLE -->
        <table class="info-table">
            <tr>
                <td colspan="2" class="header-cell"><b>JENIS INFORMASI</b></td>
                <td class="header-cell"><b>ISI INFORMASI</b></td>
                <td class="header-cell"><b>Tanda</b></td>
            </tr>
            <tr>
                <td class="number-cell">1.</td>
                <td class="label-cell">Diagnosis (WD dan DD)</td>
                <td class="content-cell">Penyakit Gagal Ginjal Kronik (PGK/ CKD) stadium V, Acute Kidney Injury (AKI), Acute on CKD</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_diagnosis ? 'checked' : '' }}"></span>
                </td>
            </tr>
            <tr>
                <td class="number-cell">2.</td>
                <td class="label-cell">Dasar diagnosis</td>
                <td class="content-cell">Anamnesis, pemeriksaan lab, fisik dan EKG</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_dasar_diagnosis ? 'checked' : '' }}"></span>
                </td>
            </tr>
            <tr>
                <td class="number-cell">3.</td>
                <td class="label-cell">Tindakan kedokteran</td>
                <td class="content-cell">HEMODIALISIS</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_tindakan ? 'checked' : '' }}"></span>
                </td>
            </tr>
            <tr>
                <td class="number-cell">4.</td>
                <td class="label-cell">Indikasi tindakan</td>
                <td class="content-cell">Hypercalemi, Enchephalopaty uremicum, Acidosis Metabolic, Edema paru, Overhydrasi, Azotemia</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_indikasi ? 'checked' : '' }}"></span>
                </td>
            </tr>
            <tr>
                <td class="number-cell">5.</td>
                <td class="label-cell">Tata cara</td>
                <td class="content-cell">Darah dikeluarkan dari tubuh dan diedarkan menuju tabung (dialyser) di luar mesin. Selama penyaringan darah terjadi difusi dan ultrafiltrasi</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_tata_cara ? 'checked' : '' }}"></span>
                </td>
            </tr>
            <tr>
                <td class="number-cell">6.</td>
                <td class="label-cell">Tujuan</td>
                <td class="content-cell">Mengeluarkan toksin uremic dan mengatur cairan akibat penurunan laju filtrasi glomerulus</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_tujuan ? 'checked' : '' }}"></span>
                </td>
            </tr>
            <tr>
                <td class="number-cell">7.</td>
                <td class="label-cell">Resiko/ komplikasi</td>
                <td class="content-cell">Hypotensi, kram otot, mual, muntah, sakit kepala, kejang, perdarahan, emboli udara, gatal-gatal, penurunan kesadaran, kematian</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_resiko ? 'checked' : '' }}"></span>
                </td>
            </tr>
            <tr>
                <td class="number-cell">8.</td>
                <td class="label-cell">Prognosis</td>
                <td class="content-cell">Ad bonam</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_prognosis ? 'checked' : '' }}"></span>
                </td>
            </tr>
            <tr>
                <td class="number-cell">9.</td>
                <td class="label-cell">Alternatif</td>
                <td class="content-cell">Transplantasi ginjal, peritoneal dialysis</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_alternatif ? 'checked' : '' }}"></span>
                </td>
            </tr>
            <tr>
                <td class="number-cell">10.</td>
                <td class="label-cell">Lain-lain</td>
                <td class="content-cell">{{ $dataPersetujuan->info_lain_lain ?: '-' }}</td>
                <td class="check-cell">
                    <span class="check-box {{ $dataPersetujuan->info_lain_lain_check ? 'checked' : '' }}"></span>
                </td>
            </tr>
        </table>

        <!-- DECLARATION SECTION -->
        <div class="declaration-text">
            <p style="margin-bottom: 8px;">
                Dengan ini menyatakan bahwa saya, <b>{{ $dataPersetujuan->dokter->nama_lengkap ?? '_________________' }}</b> telah menerangkan hal-hal
                diatas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi.
            </p>
            
            <p style="margin-bottom: 8px;">
                Dengan ini menyatakan bahwa saya/ keluarga pasien
                <b>
                    @if($dataPersetujuan->tipe_penerima == 'pasien')
                        {{ $dataMedis->pasien->nama ?? '_________________' }}
                    @elseif($dataPersetujuan->tipe_penerima == 'keluarga')
                        {{ $dataPersetujuan->nama_keluarga ?? '_________________' }}
                    @else
                        _________________
                    @endif
                </b>
                telah menerima informasi sebagaimana diatas secara benar dan jelas dan memberikan kesempatan untuk bertanya, berdiskusi dan memahamimya.
            </p>
            
            <p style="font-size: 8.5pt; font-style: italic;">
                <b>Cat: Apabila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali
                atau keluarga terdekat.</b>
            </p>
        </div>

        <!-- CONSENT SECTION -->
        <div style="text-align: center; font-weight: bold; margin: 15px 0 8px 0; font-size: 11pt;">
            PERSETUJUAN/ PENOLAKAN TINDAKAN KEDOKTERAN
        </div>

        <div class="declaration-text">
            <p style="margin-bottom: 8px;">
                Saya yang bertanda tangan di bawah ini, nama: 
                <b>
                    @if($dataPersetujuan->tipe_penerima == 'pasien')
                        {{ $dataMedis->pasien->nama ?? '_________________' }}
                    @elseif($dataPersetujuan->tipe_penerima == 'keluarga')
                        {{ $dataPersetujuan->nama_keluarga ?? '_________________' }}
                    @else
                        _________________
                    @endif
                </b>, 
                umur: 
                <b style="min-width: 45px;">
                    @if($dataPersetujuan->tipe_penerima == 'pasien')
                        {{ $dataMedis->pasien->umur ?? '____' }}
                    @elseif($dataPersetujuan->tipe_penerima == 'keluarga')
                        {{ $dataPersetujuan->umur_keluarga ?? '____' }}
                    @else
                        ____
                    @endif
                </b> th, jenis kelamin:
                <b style="min-width: 80px;">
                    @if($dataPersetujuan->tipe_penerima == 'pasien')
                        {{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : '____') }}
                    @elseif($dataPersetujuan->tipe_penerima == 'keluarga')
                        {{ $dataPersetujuan->jk_keluarga ?? '____' }}
                    @else
                        ____
                    @endif
                </b>
                alamat: 
                <b style="min-width: 220px;">
                    @if($dataPersetujuan->tipe_penerima == 'pasien')
                        {{ $dataMedis->pasien->alamat ?? '_________________________________' }}
                    @elseif($dataPersetujuan->tipe_penerima == 'keluarga')
                        {{ $dataPersetujuan->alamat_keluarga ?? '_________________________________' }}
                    @else
                        _________________________________
                    @endif
                </b>,
            </p>
            
            <p style="margin-bottom: 8px;">
                dengan ini menyatakan <span class="bold">{{ strtoupper($dataPersetujuan->keputusan ?? 'SETUJU/ MENOLAK') }}</span> dilakukan tindakan <b>HEMODIALISIS</b> terhadap:
                <span class="bold" style="min-width: 120px;">
                    @if($dataPersetujuan->tipe_penerima == 'pasien')
                        saya
                    @elseif($dataPersetujuan->tipe_penerima == 'keluarga')
                        @php
                            $relasi = [
                                'suami' => 'suami',
                                'istri' => 'istri', 
                                'ayah' => 'ayah',
                                'ibu' => 'ibu',
                                'anak' => 'anak',
                                'saudara_kandung' => 'saudara',
                                'kakek' => 'kakek',
                                'nenek' => 'nenek',
                                'cucu' => 'cucu',
                                'menantu' => 'menantu',
                                'mertua' => 'mertua',
                                'keponakan' => 'keponakan',
                                'sepupu' => 'sepupu',
                                'wali' => 'anak',
                                'lainnya' => 'keluarga'
                            ];
                        @endphp
                        {{ $relasi[$dataPersetujuan->status_keluarga] ?? 'keluarga' }}
                    @else
                        saya/ suami/ istri/ anak/ ayah/ ibu*
                    @endif
                </span>
                saya yang bernama: <span class="bold">{{ $dataMedis->pasien->nama ?? '_________________' }}</span>,
                umur: <span class="bold" style="min-width: 45px;">{{ $dataMedis->pasien->umur ?? '____' }}</span> th,
                jenis kelamin: <span class="bold" style="min-width: 80px;">{{ ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki' : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : '____') }}</span>
            </p>
            
            <p style="margin-bottom: 8px;">
                Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan kepada saya, termasuk
                resiko dan komplikasi yang mungkin timbul. Saya juga menyadari bahwa ilmu kedokteran bukanlah ilmu pasti,
                maka keberhasilan dan kesembuhan sangat bergantung atas izin Tuhan Yang Maha Kuasa.
            </p>
        </div>

        <!-- SIGNATURE SECTION -->
        <div class="signature-section">
            <p style="text-align: right; margin-bottom: 8px; font-size: 9pt;">
                Kota Langsa, tanggal: 
                @if($dataPersetujuan->tanggal_implementasi)
                    {{ Carbon\Carbon::parse($dataPersetujuan->tanggal_implementasi)->format('d-m-Y') }}
                @else
                    ___/___/_____
                @endif
                pukul: 
                @if($dataPersetujuan->jam_implementasi)
                    {{ Carbon\Carbon::parse($dataPersetujuan->jam_implementasi)->format('H:i') }}
                @else
                    ___:___
                @endif
                WIB
            </p>
            
            <p style="text-align: center; margin: 15px 0 8px 0; font-size: 9.5pt;">Saksi-saksi:</p>
            
            <table class="signature-table">
                <tr>
                    <td style="width: 50%;">
                        <p style="margin-bottom: 5px;">Dokter</p>
                        <div class="signature-line"></div>
                        <p style="margin-top: 5px;">({{ $dataPersetujuan->dokter->nama_lengkap ?? '______________________' }})</p>
                        <p style="margin-top: 2px;">Nama dan TTD</p>
                    </td>
                    <td style="width: 50%;">
                        <p style="margin-bottom: 5px;">
                            @if($dataPersetujuan->tipe_penerima == 'pasien')
                                Pasien
                            @elseif($dataPersetujuan->tipe_penerima == 'keluarga')
                                Keluarga/Wali
                            @else
                                Pasien/Keluarga
                            @endif
                        </p>
                        <div class="signature-line"></div>
                        <p style="margin-top: 5px;">
                            @if($dataPersetujuan->tipe_penerima == 'pasien')
                                ({{ $dataMedis->pasien->nama ?? '______________________' }})
                            @elseif($dataPersetujuan->tipe_penerima == 'keluarga')
                                ({{ $dataPersetujuan->nama_keluarga ?? '______________________' }})
                            @else
                                (______________________)
                            @endif
                        </p>
                        <p style="margin-top: 2px;">Nama dan TTD</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>