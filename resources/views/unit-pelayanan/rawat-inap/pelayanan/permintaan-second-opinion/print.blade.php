<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orientasi Pasien Baru</title>
<style>
        @page {
            margin: 1cm 1cm;
            size: A4 portrait;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt;
            line-height: 1.2;
        }

        .container {
            width: 100%;
            position: relative;
        }

        /* Header/Kop Surat */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
            width: 100%;
            position: relative;
        }

        .logo-rs {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 60px;
            height: 60px;
            margin-right: 10px;
        }

        .kop-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .rs-name-1 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
        }

        .rs-address {
            font-size: 9pt;
            margin: 0;
            line-height: 1.3;
        }

        .border-line {
            border-bottom: 2px solid black;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .border-line-2 {
            border-bottom: 1px solid black;
            margin-bottom: 5px;
        }

        /* Judul */
        .title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 5px 0;
        }

        /* Content */
        .content {
            margin-bottom: 3px;
        }

        /* Form Fields */
        p {
            margin: 3px 0;
            font-size: 9pt;
        }

        .form-section {
            display: flex;
            flex-wrap: wrap;
        }

        .form-group {
            width: 48%;
            margin-right: 2%;
            margin-bottom: 3px;
            display: flex;
        }

        .form-label {
            width: 120px;
            font-size: 9pt;
        }

        .form-value {
            flex: 1;
            font-size: 9pt;
            border-bottom: 1px dotted #000;
            min-height: 15px;
            position: relative;
        }

        /* Checkbox Table */
        .checkbox-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }

        .checkbox-table th {
            background-color: #e9ecef;
            padding: 2px 5px;
            text-align: left;
            border-bottom: 1px solid #ccc;
            font-weight: bold;
            font-size: 9pt;
        }

        .checkbox-table td {
            padding: 2px 5px;
            font-size: 9pt;
            border: none;
            vertical-align: top;
        }

        .checkbox-item {
            display: flex;
            align-items: flex-start;
            margin: 2px 0;
        }

        .checkbox-text {
            margin-left: 3px;
        }

        /* Signature */
        .signature {
            text-align: right;
            margin-top: 10px;
            margin-right: 30px;
            font-size: 9pt;
        }

        .signature-city {
            margin-bottom: 2px;
        }

        .signature-title {
            margin-bottom: 20px;
        }

        .signature-name {
            width: 150px;
            border-bottom: 1px solid #000;
            display: inline-block;
            text-align: center;
            margin-bottom: 2px;
            min-height: 15px;
        }

        /* Patient Info Box */
        .patient-info {
            border: 1px solid #000;
            padding: 5px;
            width: 280px;
            font-size: 9pt;
            position: absolute;
            top: 0;
            right: 0;
        }

        .patient-info-row {
            display: flex;
            margin-bottom: 5px;
        }

        .patient-info-label {
            width: 100px;
            font-weight: normal;
        }

        .patient-info-value {
            flex: 1;
        }

        .rm-digits {
            display: flex;
        }

        .rm-box {
            border: 1px solid #000;
            width: 20px;
            height: 20px;
            margin-left: 2px;
            display: inline-block;
        }

        .clear {
            clear: both;
        }

        .compact-section {
            margin-bottom: 0;
        }

        /* Fixed width columns */
        .col-1-3 {
            width: 33.3%;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header/Kop Surat -->
        <div class="header">
            <div class="logo-rs">
                <img src="{{ public_path('assets/img/Logo-RSUD-Langsa-1.png') }}" alt="Logo RSUD Langsa" class="logo">
                <div class="kop-text">
                    <p class="rs-name-1">RSUD LANGSA</p>
                    <p class="rs-address">Jl. Jend. A. Yani, Kota Langsa</p>
                    <p class="rs-address">Telp: 0641- 22051</p>
                    <p class="rs-address">email: rsudlangsa.aceh@gmail.com</p>
                </div>
            </div>
            <div class="patient-info">
                <div class="patient-info-row">
                    <span class="patient-info-label">No RM</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->kd_pasien }}</span>
                </div>
                <div class="patient-info-row">
                    <span class="patient-info-label">Nama</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->nama }}</span>
                </div>
                <div class="patient-info-row">
                    <span class="patient-info-label">Jenis Kelamin</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}</span>
                </div>
                <div class="patient-info-row">
                    <span class="patient-info-label">Tanggal Lahir</span>
                    <span class="patient-info-value">: {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn
            ({{ $dataMedis->pasien->tgl_lahir ? \Carbon\Carbon::parse($dataMedis->pasien->tgl_lahir)->format('d/m/Y') : 'Tidak Diketahui' }})</span>
                </div>
            </div>
        </div>

        <div class="clear"></div>
        <div class="border-line"></div>
        <div class="border-line-2"></div>

        <!-- Judul -->
        <div class="title">ORIENTASI PASIEN BARU</div>

        <!-- Isi Surat -->
        <div class="content">
            <p>Saya yang bertanda tangan di bawah ini :</p>

            <div class="form-section">
                <div class="form-group">
                    <span class="form-label">Nama</span>
                    <span class="form-value">:
                        {{ $dataMedis->pasien->nama }}, {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'L' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'P' : '') }}, Usia:
                        {{ $dataMedis->pasien->umur ?? 'Tidak Diketahui' }} Thn
                    </span>
                </div>
                <div class="form-group" style="width: 100%">
                    <span class="form-label">Jenis Kelamin</span>
                    <span class="form-value">:
                        {{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}, Hub dengan
                        pasien:
                        {{ $orientasiPasienBaru->hubungan ?? 'aya (pasien) sendiri, Ayah, Ibu, Suami, Istri, Anak, Lain2.................' }}</span>
                </div>
            </div>

            <p>Benar bahwa saya telah menerima informasi tentang hal-hal di bawah ini :</p>

            <!-- 1. Tata tertib Rumah Sakit -->
            <div class="content compact-section">
                <table class="checkbox-table">
                    <tr>
                        <th colspan="3">1. Tata tertib Rumah Sakit</th>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('jam_berkunjung', $orientasiPasienBaru->tata_tertib ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Jam berkunjung</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('dilarang_merokok', $orientasiPasienBaru->tata_tertib ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Dilarang merokok</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('izin_keluar', $orientasiPasienBaru->tata_tertib ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Izin keluar kamar / rumah sakit</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('peraturan_menunggu_pasien', $orientasiPasienBaru->tata_tertib ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Peraturan menunggu pasien</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('menyimpan_barang', $orientasiPasienBaru->tata_tertib ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Menyimpan barang-barang milik pasien / keluarga</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('kebersihan_ruangan', $orientasiPasienBaru->tata_tertib ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Kebersihan dan kerapian ruangan</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 2. Penggunaan Fasilitas Ruangan -->
            <div class="content compact-section">
                <table class="checkbox-table">
                    <tr>
                        <th colspan="3">2. Penggunaan Fasilitas Ruangan</th>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('bel_pasien', $orientasiPasienBaru->fasilitas ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Bel Pasien</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('ac_kipas', $orientasiPasienBaru->fasilitas ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Air Conditioner (AC) / kipas angin</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('tv_lampu_kulkas', $orientasiPasienBaru->fasilitas ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Televisi/Lampu/Kulkas</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('tempat_tidur', $orientasiPasienBaru->fasilitas ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Tempat tidur</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('peralatan_makan', $orientasiPasienBaru->fasilitas ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Peralatan makan / meja makan pasien</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('kamar_mandi', $orientasiPasienBaru->fasilitas ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Kamar mandi (kloset, dll)</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('lemari_baju', $orientasiPasienBaru->fasilitas ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Lemari baju dan nakas (bed side cabinet)</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('sofa_kursi', $orientasiPasienBaru->fasilitas ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Sofa dan kursi</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('fasilitas_lainnya', $orientasiPasienBaru->fasilitas ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Lain2
                                    {{ $orientasiPasienBaru->fasilitas_lainnya_text ?? '..............' }}</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 3. Tenaga Medis yang merawat -->
            <div class="content compact-section">
                <table class="checkbox-table">
                    <tr>
                        <th colspan="2">3. Tenaga Medis yang merawat</th>
                    </tr>
                    <tr>
                        <td style="width: 50%">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('dokter_ruangan', $orientasiPasienBaru->tenaga_medis ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Dokter ruangan</span>
                            </div>
                        </td>
                        <td style="width: 50%">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('dokter_spesialis', $orientasiPasienBaru->tenaga_medis ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Dokter spesialis</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('waktu_visit', $orientasiPasienBaru->tenaga_medis ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Waktu visit dokter</span>
                            </div>
                        </td>
                        <td style="width: 50%">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('perawat', $orientasiPasienBaru->tenaga_medis ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Perawat</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 4. Kegiatan ruangan, meliputi -->
            <div class="content compact-section">
                <table class="checkbox-table">
                    <tr>
                        <th colspan="3">4. Kegiatan ruangan, meliputi :</th>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('aktivitas_rutin', $orientasiPasienBaru->kegiatan ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Aktifitas rutin (hand over, visite)</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('waktu_pergantian_dinas', $orientasiPasienBaru->kegiatan ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Waktu pergantian dinas</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('pemeriksaan_radiologi', $orientasiPasienBaru->kegiatan ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Pemeriksaan radiologi</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('info_pasien_pulang', $orientasiPasienBaru->kegiatan ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Informasi tentang pasien pulang</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('pemeriksaan_laboratorium', $orientasiPasienBaru->kegiatan ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Pemeriksaan laboratorium</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('kegiatan_lainnya', $orientasiPasienBaru->kegiatan ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Lain-lain:
                                    {{ $orientasiPasienBaru->kegiatan_lainnya_text ?? '......................................' }}</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 5. Lokasi di ruang perawatan dan sekitarnya -->
            <div class="content compact-section">
                <table class="checkbox-table">
                    <tr>
                        <th colspan="3">5. Lokasi di ruang perawatan dan sekitarnya</th>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('nurse_station', $orientasiPasienBaru->lokasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Nurse station</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('kamar_mandi', $orientasiPasienBaru->lokasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Kamar mandi</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('musholla', $orientasiPasienBaru->lokasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Musholla</span>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('lokasi_lainnya', $orientasiPasienBaru->lokasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Lain-lain:
                                    {{ $orientasiPasienBaru->lokasi_lainnya_text ?? '..................' }}</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 6. Administrasi tentang Pasien yang akan -->
            <div class="content compact-section">
                <table class="checkbox-table">
                    <tr>
                        <th colspan="3">6. Administrasi tentang Pasien yang akan</th>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('pulang_rawat', $orientasiPasienBaru->administrasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Pulang rawat</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('selisih_kamar', $orientasiPasienBaru->administrasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Selisih kamar</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('pindah_rs', $orientasiPasienBaru->administrasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Pindah rumah sakit</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('pindah_kamar', $orientasiPasienBaru->administrasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Pindah Kamar</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('pindah_ruangan', $orientasiPasienBaru->administrasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Pindah ruangan</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('administrasi_lainnya', $orientasiPasienBaru->administrasi ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Lain-lain:
                                    {{ $orientasiPasienBaru->administrasi_lainnya_text ?? '' }}</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 7. Barang-barang yang dibawa pasien -->
            <div class="content compact-section">
                <table class="checkbox-table">
                    <tr>
                        <th colspan="3">7. Barang-barang yang dibawa pasien</th>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('alat_pendengaran', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Alat pendengaran</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('gigi_palsu', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Gigi palsu</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('perhiasan', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Perhiasan</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('alat_pembayaran', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Alat pembayaran</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('kacamata', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Kacamata</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('alat_komunikasi', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Alat komunikasi</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('contact_lens', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Contact lens</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('jam_tangan', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Jam tangan</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('laptop', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Laptop</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('barang_lainnya_1', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Lain-lain:
                                    {{ $orientasiPasienBaru->barang_lainnya_1_text ?? '....................' }}</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('barang_lainnya_2', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Lain-lain:
                                    {{ $orientasiPasienBaru->barang_lainnya_2_text ?? '....................' }}</span>
                            </div>
                        </td>
                        <td class="col-1-3">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('barang_lainnya_3', $orientasiPasienBaru->barang ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Lain-lain:
                                    {{ $orientasiPasienBaru->barang_lainnya_3_text ?? '....................' }}</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 8. Informasi lainnya -->
            <div class="content compact-section">
                <table class="checkbox-table">
                    <tr>
                        <th colspan="1">8. Informasi lainnya</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('menutup_pengaman', $orientasiPasienBaru->informasi_lainnya ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Selalu menutup pengaman tempat tidur</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('tanggung_jawab_barang', $orientasiPasienBaru->informasi_lainnya ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Pasien dan keluarga bertanggung jawab penuh atas barang yang
                                    dibawa ke Rumah Sakit</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('barang_tidak_perlu', $orientasiPasienBaru->informasi_lainnya ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Barang yang tidak berhubungan dengan perawatan sebaiknya
                                    tidak perlu dibawa</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('tidak_merekam', $orientasiPasienBaru->informasi_lainnya ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Tidak merekam / mengambil gambar di lokasi Rumah Sakit tanpa
                                    izin pihak Rumah Sakit</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- 9. Kegawatdaruratan -->
            <div class="content compact-section">
                <table class="checkbox-table">
                    <tr>
                        <th colspan="2">9. Kegawatdaruratan</th>
                    </tr>
                    <tr>
                        <td style="width: 50%">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('kebakaran_gempa', $orientasiPasienBaru->kegawatdaruratan ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Kebakaran, gempa dan bencana lainnya</span>
                            </div>
                        </td>
                        <td style="width: 50%">
                            <div class="checkbox-item">
                                <input type="checkbox" {{ in_array('jalur_evakuasi', $orientasiPasienBaru->kegawatdaruratan ?? []) ? 'checked' : '' }} disabled>
                                <span class="checkbox-text">Jalur evakuasi dan titik kumpul</span>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Signature -->
            <div class="signature">
                <p class="signature-city">{{ $tanggalLengkap }}</p>
                <table style="width: 100%">
                    <tr>
                        <td style="width: 50%; text-align: center">
                            <p class="signature-title">Yang menerima informasi</p>
                            <br><br>
                            <p class="signature-name">{{ $orientasiPasienBaru->nama_penerima ?? '' }}</p>
                        </td>
                        <td style="width: 50%; text-align: center">
                            <p class="signature-title">Yang memberikan informasi</p>
                            <br><br>
                            <p class="signature-name">{{ $orientasiPasienBaru->userCreate->name ?? '' }}</p>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</body>

</html>
