<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    @page {
        size: A4;
        margin: 3mm 3mm;
    }

    body {
        box-sizing: border-box;
        font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
        font-size: 8pt;
        margin: 0;
        padding: 0;
    }

    .a4 {
        width: 100%;
        max-width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td,
    th {
        padding: 1.5px 3px;
        vertical-align: top;
    }

    .label {
        font-weight: bold;
        width: 17%;
        padding-right: 8px;
        text-align: left;
    }

    .value {

        min-height: 22px;
    }

    .value.tall {
        min-height: 32px;
    }

    .value.empty-space {
        min-height: 60px;
        /* ruang tulis tangan jika kosong */
    }

    .checkbox-group {
        font-family: "DejaVu Sans", sans-serif !important;
    }

    .checkbox-group label {
        margin-right: 28px;
        display: inline-block;
    }



    input[type="checkbox"]:checked {
        background: #fff;
    }

    input[type="checkbox"]:checked::after {
        content: "";
        /* content: "\2713"; */
        /* Unicode checkmark yang support di DejaVu Sans */
        position: absolute;
        top: -10px;
        left: 1px;
        font-size: 16px;
        color: #000;
        line-height: 1;
    }

    .obat-item {
        border-bottom: 1px dotted #666;
        padding: 2px 6px;
        margin-bottom: 2px;
    }

    .header {
        display: flex;
        align-items: stretch;
        margin-bottom: 10mm;
        border-bottom: 1px solid #000;
        width: 100%;
    }

    .patient-table {
        width: 100%;
        margin-top: 15px;
        border-collapse: collapse;
    }

    .patient-table th,
    .patient-table td {
        border: 1px solid #ccc;
        padding: 5px 7px;
        font-size: 9pt;
    }

    .patient-table th {
        background-color: #f2f2f2;
        text-align: left;
        width: 130px;
    }

    .header-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #f0f0f0;
        padding: 0;
        position: relative;
    }

    .td-left {
        width: 40%;
        text-align: left;
        vertical-align: middle;
    }

    .td-center {
        width: 40%;
        text-align: center;
        vertical-align: middle;
    }



    .brand-table {
        border-collapse: collapse;
        background-color: transparent;
    }

    .va-middle {
        vertical-align: middle;
    }

    .brand-logo {
        width: 60px;
        height: auto;
        margin-right: 2px;
    }

    .brand-name {
        font-weight: 700;
        margin: 0;
        font-size: 14px;
    }

    .brand-info {
        margin: 0;
        font-size: 7px;
    }

    .title-main {
        display: block;
        font-size: 16px;
        font-weight: bold;
        margin: 0;
    }

    .title-sub {
        display: block;
        font-size: 14px;
        font-weight: bold;
        margin: 0;
    }



    .unit-box {
        background-color: #bbbbbb;
        padding: 15px 0px;
        width: 100%;
        margin: 0 auto;
        text-align: center;
    }

    .unit-text {
        font-size: 18px;
        font-weight: bold;
        color: #ffffff;
    }

    .page-break {
        page-break-before: always;
    }


    .header-asesmen {
        margin-top: 1rem;
        font-size: 1.5rem;
        font-weight: 600;
    }



    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .form-label.fw-bold {
        font-weight: 600 !important;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .text-justify {
        text-align: justify;
    }

    .badge {
        font-size: 0.75rem;
    }

    .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    /* Site Marking Show Styles */
    .site-marking-container {
        border: 2px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
        position: relative;
        background-color: red;
    }


    .marking-list-item-show {
        padding: 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        margin-bottom: 8px;
        background: #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .marking-badge {
        font-size: 10px;
        padding: 4px 8px;
    }

    #anatomyImageShow {
        display: block;
        max-width: 100%;
        height: auto;
    }

    #markingCanvasShow {
        pointer-events: none;
    }

    .marking-detail {
        font-size: 0.875rem;
    }

    .marking-color-indicator {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: inline-block;
        border: 2px solid #fff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }
</style>

<body>
    @php
        $asesmen = json_decode(json_encode($data['asesmen'] ?? null), false);
    @endphp

    <table class="header-table">
        <tr>
            <td class="td-left">
                <table class="brand-table">
                    <tr>
                        <td class="va-middle">
                            @php
                                $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
                                $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
                                $logoData = file_get_contents($logoPath);
                                $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
                            @endphp
                            <img src="{{ $logoBase64 }}" style="width:70px; height:auto;">
                        </td>
                        <td class="va-middle">
                            <p class="brand-name">RSUD Langsa</p>
                            <p class="brand-info">Jl. Jend. A. Yani No.1 Kota Langsa</p>
                            <p class="brand-info">Telp. 0641-22051, email: rsulangsa@gmail.com</p>
                            <p class="brand-info">www.rsud.langsakota.go.id</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="td-center">
                <span class="title-main">ASESMEN AWAL KEPERAWATAN</span>
                <span class="title-sub">RAWAT INAP DEWASA</span>
            </td>
            <td class="td-right">
                <div class="unit-box"><span class="unit-text" style="font-size: 14px; margin-top:10px;">RAWAT
                        INAP</span></div>
            </td>
        </tr>
    </table>

    <table class="patient-table">
        <tr>
            <th>No. RM</th>
            <td>{{ $data['dataMedis']->pasien->kd_pasien ?? '-' }}</td>
            <th>Tgl. Lahir</th>
            <td>{{ $data['dataMedis']->pasien->tgl_lahir ? \Carbon\Carbon::parse($data['dataMedis']->pasien->tgl_lahir)->format('d M Y') : '-' }}
            </td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $data['dataMedis']->pasien->nama ?? '-' }}</td>
            <th>Umur</th>
            <td>{{ $data['dataMedis']->pasien->umur ?? '-' }} Tahun</td>
        </tr>
    </table>

    <table style="">
        <tr>
            <td colspan="2" class="label" style=" font-size: 10pt;">Data Umum</td>
        </tr>

        <tr>
            <td colspan="2">
                <table>
                    <tr>
                        <th class="label">Nadi :</th>
                        <td class="value">{{ $asesmen->asesmen_ket_dewasa_ranap->nadi }} kali/mnt </td>
                        <th class="label">TD :</th>
                        <td class="value">
                            {{ $asesmen->asesmen_ket_dewasa_ranap->distole }}/{{ $asesmen->asesmen_ket_dewasa_ranap->sistole }}
                            mmHg</td>
                        <th class="label">Nafas : </th>
                        <td class="value">{{ $asesmen->asesmen_ket_dewasa_ranap->nafas }} kali/mnt </td>
                        <th class="label">Suhu :</th>
                        <td class="value">{{ $asesmen->asesmen_ket_dewasa_ranap->suhu }} ºC</td>
                    </tr>
                    <tr>
                        <th class="label">SaO2</th>
                        <td class="value">{{ $asesmen->asesmen_ket_dewasa_ranap->sao2 }} %</td>
                        <th class="label">TB : </th>
                        <td class="value">{{ $asesmen->asesmen_ket_dewasa_ranap->tb }} Cm</td>
                        <th class="label">BB : </th>
                        <td colspan="2" class="value">"{{ $asesmen->asesmen_ket_dewasa_ranap->bb }} Kg</td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- <tr>
            <td>
                <table border="1">
                    <tr>

                        <th>
                            <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Mandiri
                        </th>
                        <th>
                            <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Tempat Tidur
                        </th>
                        <th>
                            <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Lainnya :
                        </th>
                    </tr>
                </table>
            </td>
            <td></td>
        </tr> --}}
        @php
            $dokter = $data['masterData']['dokter'];
        @endphp
        <tr>
            <td colspan="2">
                <table border="1">
                    <tr>
                        <td class="label">Dokter (DPJP) :</td>
                        <td class="value">

                            @foreach ($dokter as $dok)
                                @if ($asesmen->asesmen_ket_dewasa_ranap->kd_dokter == $dok->kd_dokter)
                                    {{ $dok->nama_lengkap }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Diagnosis Masuk:</td>
                        <td class="value"> {{ $asesmen->asesmen_ket_dewasa_ranap->diagnosis_masuk ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Keluhan Utama</td>
                        <td class="value">{{ $asesmen->asesmen_ket_dewasa_ranap->keluhan_utama ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="1">
                    <tr>
                        <td class="label">
                            Alergi :
                        </td>
                        <td>
                            <input type="checkbox" {{ empty($riwayat_alergi) ? 'checked' : '' }}
                                style="margin-right: 6px;">
                            Tidak ada
                        </td>
                        <td>
                            <input type="checkbox" {{ !empty($riwayat_alergi) ? 'checked' : '' }}
                                style="margin-right: 6px;">
                            Ada, sebutkan:
                        </td>

                    </tr>
                </table>
            </td>

        </tr>

        @if (!empty($riwayat_alergi))
            @foreach ($riwayat_alergi as $index => $alergi)
                <tr>
                    <td colspan="2" class="label" style="padding-left: 30px; font-weight: normal; width: 10%;">
                        {{ $index + 1 }}.
                        <strong>{{ $alergi['alergen'] ?? '-' }}</strong>
                        (Jenis: {{ $alergi['jenis'] ?? '-' }})
                        — Reaksi: {{ $alergi['reaksi'] ?? '-' }}
                        — Keparahan: {{ $alergi['keparahan'] ?? '-' }}
                    </td>

                </tr>
            @endforeach
        @endif
        {{-- @php
        dd($asesmen);
        @endphp --}}
        <tr>
            <td colspan="2">
                <table border="1">
                    {{-- <tr>
                        <td class="label">Jenis Reaksi :</td>
                        <td colspan="4" class="value">
                    </tr> --}}
                    <tr>
                        <th class="label">
                            Barang Berharga
                        </th>
                        <td>
                            <input type="checkbox"
                                {{ old('barang_berharga', $asesmen->asesmen_ket_dewasa_ranap->barang_berharga ?? '') === 'perhiasan' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Mandiri
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ old('barang_berharga', $asesmen->asesmen_ket_dewasa_ranap->barang_berharga ?? '') === 'uang' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Tempat Tidur
                        </td>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ old('barang_berharga', $asesmen->asesmen_ket_dewasa_ranap->barang_berharga ?? '') === 'lainnya' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Lainnya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap->barang_berharga_lainnya }}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="1">
                    <tr>
                        <td class="label">Alat bantu yang digunakan :</td>

                        <td colspan="5" class="value">
                            @php
                                $bantuanValue =
                                    $asesmen->asesmen_ket_dewasa_ranap_resiko_jatuh
                                        ->risiko_jatuh_morse_bantuan_ambulasi ?? '';
                                $bantuanOptions = [
                                    '0' => 'Tidak ada / bedrest / bantuan perawat ',
                                    '15' => 'Kruk / tongkat / alat bantu berjalan ',
                                    '30' => 'Meja / kursi ',
                                ];

                            @endphp

                            @foreach ($bantuanOptions as $value => $label)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="risiko_jatuh_morse_bantuan_ambulasi" value="{{ $value }}"
                                        {{ $bantuanValue == $value ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ $label }}</label>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Barang Berharga
                        </th>
                        <td>
                            <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }}
                                style="">
                            Kacamata
                        </td>
                        <td>
                            <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }}
                                style="">
                            Lensa kontak
                        </td>
                        <td>
                            <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }}
                                style=""> Gigi
                            palsu
                        </td>
                        <td>
                            <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }}
                                style=""> Alat
                            bantu dengar
                        </td>
                        <td>
                            <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }}
                                style="">
                            Lainnya :
                        </td>

                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="label" style="font-size: 10pt;">RIWAYAT PASIEN</td>
        </tr>
        <tr>
            <td colspan="2" class="label" style="font-size: 8pt;">Riwayat pasien: (penyakit utama/ operasi/
                cidera
                mayor)</td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="1">
                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('hypertensi', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style="">
                            Hypertensi
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('infark_myiokard', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style="">
                            myiokard
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('stroke', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style=""> Stroke
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('jantung_koroner', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style=""> Alat
                            Jantung Koroner
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('opok', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style="">
                            PPOK
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('asthma', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style="">
                            Asthma
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('tb', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style=""> Gigi
                            TB
                        </td>

                        <td>
                            <input type="checkbox"
                                {{ in_array('penyakit_paru_lainnya', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style="">
                            Paru lainnya
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('diabetes_mellitus', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style="">
                            Mellitus
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('riwayat_pasien_hepatitis', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style="">
                            Hepatitis
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('ulkus', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style=""> Gigi
                            Ulkus
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('gagal_ginjal', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style=""> Alat
                            Gagal Ginjal
                        </td>

                    </tr>
                    <tr>

                        <td>
                            <input type="checkbox"
                                {{ in_array('kanker', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style="">
                            Kanker
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('kejang', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style=""> Gigi
                            Kejang
                        </td>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('jiwa', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style=""> Alat
                            Jiwa
                        </td>

                    </tr>
                    <tr>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('hypertensi', old('riwayat_pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien ?? [])) ? 'checked' : '' }}
                                style="">
                            Lainnya:
                        </td>
                        <td coplspan="2">
                            {{ $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_pasien_lain }}</td>
                    </tr>

                    <tr>
                        <td class="col-header">ALERGI :</td>
                        <td colspan="3">
                            <table class="table table-bordered" id="createAlergiTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="20%">Jenis Alergi</th>
                                        <th width="25%">Alergen</th>
                                        <th width="25%">Reaksi</th>
                                        <th width="20%">Tingkat Keparahan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="no-alergi-row">
                                        <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                    </tr>
                                </tbody>
                                @push('modals')
                                    @include('unit-pelayanan.rawat-inap.pelayanan.asesmen-umum.modal-show-alergi')
                                @endpush
                            </table>
                        </td>
                    </tr>
                    <tr>
                        @php
                            $alkoholObat = $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->alkohol_obat ?? '';

                            $alkoholJenisRaw = $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->alkohol_jenis ?? [];
                            $alkoholJumlahRaw = $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->alkohol_jumlah ?? [];

                            /**
                             * Pastikan jadi array (jika dari JSON)
                             */
                            $alkoholJenis = is_string($alkoholJenisRaw)
                                ? json_decode($alkoholJenisRaw, true)
                                : (array) $alkoholJenisRaw;
                            $alkoholJumlah = is_string($alkoholJumlahRaw)
                                ? json_decode($alkoholJumlahRaw, true)
                                : (array) $alkoholJumlahRaw;

                            /**
                             * Convert ke array of object
                             */
                            $alkoholList = [];

                            foreach ($alkoholJenis as $index => $jenis) {
                                $alkoholList[] = (object) [
                                    'jenis' => $jenis,
                                    'jumlah' => $alkoholJumlah[$index] ?? null,
                                ];
                            }
                        @endphp
                        <td class="col-header">Alkohol</td>
                        <td colspan="3">
                            <table style="width: 100%; border-collapse: collapse; font-size: 10px;">

                                <tr>

                                    <td>
                                        <span class="checkbox-group">
                                            <input type="checkbox" {{ $alkoholObat === 'tidak' ? 'checked' : '' }}
                                                disabled>
                                            Tidak
                                        </span>

                                        <span class="checkbox-group">
                                            <input type="checkbox" {{ $alkoholObat === 'ya' ? 'checked' : '' }}
                                                disabled>
                                            Ada
                                        </span>

                                        @if ($alkoholObat === 'ya' && !empty($alkoholList))
                                            , sebutkan :
                                            @foreach ($alkoholList as $item)
                                                <span class="alkohol-item">
                                                    Jenis : {{ $item->jenis }},
                                                    Jumlah : {{ $item->jumlah ?? '-' }}
                                                </span>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        @php
                            $merokok = $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->merokok ?? '';

                            $merokokJenisRaw = $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->merokok_jenis ?? [];
                            $merokokJumlahRaw = $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->merokok_jumlah ?? [];

                            /**
                             * Pastikan jadi array (jika dari JSON)
                             */
                            $merokokJenis = is_string($merokokJenisRaw)
                                ? json_decode($merokokJenisRaw, true)
                                : (array) $merokokJenisRaw;
                            $merokokJumlah = is_string($merokokJumlahRaw)
                                ? json_decode($merokokJumlahRaw, true)
                                : (array) $merokokJumlahRaw;

                            /**
                             * Convert ke array of object
                             */
                            $merokokList = [];

                            foreach ($merokokJenis as $index => $jenis) {
                                $merokokList[] = (object) [
                                    'jenis' => $jenis,
                                    'jumlah' => $merokokJumlah[$index] ?? null,
                                ];
                            }
                        @endphp
                        <td class="col-header">Merokok</td>
                        <td colspan="3">
                            <table style="width: 100%; border-collapse: collapse; font-size: 10px;">

                                <tr>

                                    <td>
                                        <span class="checkbox-group">
                                            <input type="checkbox" {{ $merokok === 'tidak' ? 'checked' : '' }}
                                                disabled>
                                            Tidak
                                        </span>

                                        <span class="checkbox-group">
                                            <input type="checkbox" {{ $merokok === 'ya' ? 'checked' : '' }} disabled>
                                            Ada
                                        </span>

                                        @if ($merokok === 'ya' && !empty($merokokList))
                                            , sebutkan :
                                            @foreach ($merokokList as $item)
                                                <span class="alkohol-item">
                                                    Jenis : {{ $item->jenis }},
                                                    Jumlah : {{ $item->jumlah ?? '-' }}
                                                </span>
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="label" style=" font-size: 10pt;">RIWAYAT KELUARGA</td>
        </tr>
        @php
            $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga;
        @endphp
        <tr>
            <td colspan="2">
                <table border="1">
                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('penyakit_jantung', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style="">
                            Penyakit jantung
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('Hypertensi', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style="">
                            Hypertensi
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('Stroke', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style=""> Gigi
                            Stroke
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('Asthma', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style=""> Alat
                            Asthma
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('gangguan_jiwa', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style="">
                            Gangguan jiwa
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('gagal_ginjal', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style=""> Gigi
                            Gagal ginjal
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('lainnya', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style=""> Alat
                            Lainnya
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('kanker', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style="">
                            Kanker
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('kejang', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style="">
                            Kejang
                        </td>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('gangguan_hematologi', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style=""> Gigi
                            Gangguan hematologi
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('diabetes', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style=""> Alat
                            Diabetes
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('hepatitis', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style="">
                            Hepatitis
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('TB', old('riwayat_keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->riwayat_keluarga ?? [])) ? 'checked' : '' }}
                                style=""> Gigi
                            TB
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="label" style=" font-size: 10pt;">Psikososial/ ekonomi</td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="1">
                    <tr>
                        <th class="label">
                            Status pernikahan
                        </th>
                        <td>
                            <input type="checkbox"
                                {{ old('menikah', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_status_pernikahan ?? '') === 'menikah' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Menikah
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ old('belum_menikah', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_status_pernikahan ?? '') === 'belum_menikah' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Belum menikah
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ old('duda_janda', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_status_pernikahan ?? '') === 'duda_janda' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Duda/janda :
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Keluarga
                        </th>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ old('tinggal_serumah', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_keluarga ?? '') === 'tinggal_serumah' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Tinggal serumah
                        </td>
                        <td colspan="5">
                            <input type="checkbox"
                                {{ old('tinggal_sendiri', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_keluarga ?? '') === 'tinggal_sendiri' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Tempat Sendiri
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Tempat tinggal
                        </th>
                        <td>
                            <input type="checkbox"
                                {{ old('rumah', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_tempat_tinggal ?? '') === 'rumah' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Rumah
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ old('panti_asuhan', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_tempat_tinggal ?? '') === 'panti_asuhan' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Panti asuhan
                        </td>
                        <td colspan="5">
                            <input type="checkbox"
                                {{ old('panti_asuhan', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_tempat_tinggal ?? '') === 'lainnya' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Lainnya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_lainnya }}
                        </td>
                    </tr>
                    <tr>
                        <th class="label" rowspan="2">
                            Pekerjaan
                        </th>
                        <td colspan="7">
                            {{ $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_pekerjaan ?? ' ' }}
                        </td>

                    </tr>
                    <tr>

                        <td>
                            <input type="checkbox"
                                {{ in_array('purnawaktu', old('psikososial_aktivitas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Purnawaktu
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('paruh_waktu', old('psikososial_aktivitas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Paruh waktu
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('pensiunan', old('psikososial_aktivitas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Pensiunan
                        </td>
                        <td colspan="4">
                            <input type="checkbox"
                                {{ in_array('lainnya', old('psikososial_aktivitas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Lainya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas_lain }}
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Aktivitas
                        </th>
                        <td>
                            <input type="checkbox"
                                {{ in_array('aktivitas_mandiri', old('psikososial_aktivitas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Mandiri
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('tongkat', old('psikososial_aktivitas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Tongkat
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('kursi_roda', old('psikososial_aktivitas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Kursi Roda
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('tirah_baring', old('psikososial_aktivitas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Tirah baring
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('lainnya2', old('psikososial_aktivitas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Lainya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_aktivitas_lainnya2 }}
                        </td>
                    </tr>
                    {{-- @php
                    dd($asesmen);
                    @endphp --}}
                    <tr>
                        <td class="label" style="width: 25%;">
                            Curiga penganiayaan / penelantaran
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ old('ya', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_curiga_penganiayaan ?? '') === 'ya' ? 'checked' : '' }}>
                            Ya


                        </td>
                        <td colspan="6">
                            <input type="checkbox"
                                {{ old('tidak', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_curiga_penganiayaan ?? '') === 'tidak' ? 'checked' : '' }}>
                            Tidak
                        </td>
                    </tr>
                    <tr>
                        <td class="label">
                            Status emosional
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ old('kooperatif', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_status_emosional ?? '') === 'kooperatif' ? 'checked' : '' }}>
                            Kooperatif
                        </td>

                        <td>
                            <input type="checkbox"
                                {{ old('cemas', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_status_emosional ?? '') === 'cemas' ? 'checked' : '' }}>
                            Cemas
                        </td>

                        <td>
                            <input type="checkbox"
                                {{ old('depresi', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_status_emosional ?? '') === 'depresi' ? 'checked' : '' }}>
                            Depresi
                        </td>

                        <td colspan="4">
                            <input type="checkbox"
                                {{ old('ingin_mengakhiri_hidup', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->psikososial_status_emosional ?? '') === 'ingin_mengakhiri_hidup' ? 'checked' : '' }}>
                            Ingin mengakhiri hidup
                        </td>
                    </tr>
                    {{-- <tr>
                        <td class="label">
                            Potensi menyakiti diri sendiri / orang lain
                        </td>
                        <td>
                            <input type="checkbox" {{ old('potensi_menyakiti', $asesmen->potensi_menyakiti ?? '') == 'ya' ? 'checked' : '' }}>
                            Ya
                        </td>
                        <td colspan="6">
                            <input type="checkbox" {{ old('potensi_menyakiti', $asesmen->potensi_menyakiti ?? '') == 'tidak' ? 'checked' : '' }}>
                            Tidak
                        </td>
                    </tr> --}}
                    <tr>
                        <td class="label">
                            Keluarga terdekat
                        </td>
                        <td colspan="3">
                            <strong>Hubungan:</strong>
                            {{ $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->keluarga_terdekat_nama ?? '................................' }}
                        </td>
                        <td colspan="4">
                            <strong>Telpon:</strong>
                            {{ $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->keluarga_terdekat_telepon ?? '................................' }}
                        </td>

                    </tr>
                    <tr>
                        <td class="label">
                            Informasi didapat dari
                        </td>

                        {{-- @php
                            dd($asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->informasi_didapat_dari );
                        @endphp --}}
                        <td>
                            <input type="checkbox"
                                {{ old('pasien', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->informasi_didapat_dari ?? '') === 'pasien' ? 'checked' : '' }}>
                            Pasien
                        </td>

                        <td>
                            <input type="checkbox"
                                {{ old('keluarga', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->informasi_didapat_dari ?? '') === 'keluarga' ? 'checked' : '' }}>
                            Keluarga
                        </td>

                        <td colspan="5">
                            <input type="checkbox"
                                {{ old('lainnya', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->informasi_didapat_dari ?? '') === 'lainnya' ? 'checked' : '' }}>
                            Lainnya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->informasi_didapat_dari_lainnya ?? '.................' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="width: 20%;">
                            Spiritual
                        </td>
                        <td colspan="7">
                            <strong>Agama :</strong>
                            &nbsp;
                            <input type="checkbox"
                                {{ in_array('islam', old('agama', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->agama ?? [])) ? 'checked' : '' }}>
                            Islam
                            &nbsp;&nbsp;
                            <input type="checkbox"
                                {{ in_array('kristen', old('agama', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->agama ?? [])) ? 'checked' : '' }}>
                            Khatolik
                            &nbsp;&nbsp;
                            <input type="checkbox"
                                {{ in_array('protestan', old('protestan', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->agama ?? [])) ? 'checked' : '' }}>
                            Protestan
                            &nbsp;&nbsp;
                            <input type="checkbox"
                                {{ in_array('budha', old('budha', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->agama ?? [])) ? 'checked' : '' }}>
                            Budha
                            &nbsp;&nbsp;
                            <input type="checkbox"
                                {{ in_array('hindu', old('hindu', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->agama ?? [])) ? 'checked' : '' }}>
                            Hindu
                            &nbsp;&nbsp;
                            <input type="checkbox"
                                {{ in_array('konghucu', old('konghucu', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasien->agama ?? [])) ? 'checked' : '' }}>
                            Konghucu
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        {{-- @php
        dd($asesmen);
        @endphp --}}


        <tr class="page-break">
            <td colspan="4" class="label" style=" font-size: 10pt;">PEMERIKSAAN FISIK</td>
        </tr>
        <tr>
            <td colspan="4">
                <table border="1">
                    <tr>
                        <td class="label" colspan="3">
                            Pemeriksaan mata, telinga, hidung, tenggorokan
                        </td>
                        <td style="text-align:right;">
                            <input type="checkbox"
                                {{ old('mata_telinga_hidung_normal', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung_normal ?? '') == 'normal' ? 'checked' : '' }}>
                            <strong>Normal</strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('gangguan_visus', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Gangguan visus
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('glucoma', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Glaukoma
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('sulit_mendengar', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Sulit mendengar
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('gusi', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Gusi
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('kemerahan', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Kemerahan
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('drainase', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Drainase
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('buta', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Buta
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ old('tuli', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? '') ? 'checked' : '' }}>
                            Tuli
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('gigi', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Gigi
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('rasa_terbakar', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Rasa terbakar
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('luka', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Luka
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('lainnya', old('mata_telinga_hidung', $asesmen->asesmen_ket_dewasa_ranap_fisik->mata_telinga_hidung ?? [])) ? 'checked' : '' }}>
                            Lainnya
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <strong>Catatan:</strong>
                            {{ $asesmen->pmttht_catatan ?? '............................................................' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" colspan="3">
                            Pemeriksaan paru (kecepatan, kedalaman, pola, suara nafas)
                        </td>
                        <td style="text-align:right;">
                            <input type="checkbox"
                                {{ old('pemeriksaan_paru_normal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru_normal ?? '') == 'normal' ? 'checked' : '' }}>
                            <strong>Normal</strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ old('asimetris', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru_normal ?? '') == 'normal' ? 'checked' : '' }}>
                            Asimetris
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('takipnea', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            Takipnea
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('ronki', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            Ronki
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]" id="kiri_1"
                                value="kiri_1"
                                {{ in_array('kiri_1', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasienFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kiri_1">Kiri</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]" id="kanan_1"
                                value="kanan_1"
                                {{ in_array('kanan_1', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasienFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kanan_1">Kanan</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]" id="batuk"
                                value="batuk"
                                {{ in_array('batuk', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_riwayat_pasienFisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="batuk">Batuk</label>
                        </td>


                    </tr>

                    <tr>
                        <td>
                            <input type="checkbox"
                                {{ in_array('barrel_chest', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            Barrel chest
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('bradipnea_1', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            Bradipnea
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('mengi_wheezing', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            Mengi / wheezing
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]" id="kiri_2"
                                value="kiri_2"
                                {{ in_array('kiri_2', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kiri_2">Kiri</label>
                        </td>
                    </tr>

                    <tr>

                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]" id="kanan_2"
                                value="kanan_2"
                                {{ in_array('kanan_2', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kanan_2">Kanan</label>
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('kiri_2', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            Warna dahak
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]" id="sesak"
                                value="sesak"
                                {{ in_array('sesak', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="sesak">Sesak</label>
                            </div>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]" id="dangkal"
                                value="dangkal"
                                {{ in_array('dangkal', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="dangkal">Dangkal</label>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                id="menghilang" value="menghilang"
                                {{ in_array('menghilang', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="menghilang">Menghilang</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]" id="kiri_3"
                                value="kiri_3"
                                {{ in_array('kiri_3', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kiri_3">Kiri</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]" id="kanan_3"
                                value="kanan_3"
                                {{ in_array('kanan_3', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kanan_3">Kanan</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_paru[]"
                                id="lainnya_paru" value="lainnya"
                                {{ in_array('lainnya', old('pemeriksaan_paru', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_paru ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="lainnya_paru">Lainnya</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>Catatan:</strong>
                            {{ $asesmen->paru_catatan ?? '............................................................' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" colspan="3">
                            Pemeriksaan gastrointestinal
                        </td>
                        <td style="text-align:right;">
                            <input class="" type="checkbox" name="pemeriksaan_gastrointestinal_normal"
                                id="pemeriksaan_gastrointestinal_normal" value="normal"
                                {{ old('pemeriksaan_gastrointestinal_normal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal_normal ?? '') == 'normal' ? 'checked' : '' }}>
                            <strong>Normal</strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_distensi" value="distensi"
                                {{ in_array('distensi', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_gastrointestinal_distensi">Distensi</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_bisingususmenurun" value="bising_usus_menurun"
                                {{ in_array('bising_usus_menurun', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_gastrointestinal_bisingususmenurun">Bising
                                usus menurun</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_anoreksia" value="anoreksia"
                                {{ in_array('anoreksia', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_gastrointestinal_anoreksia">Anoreksia</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_disfagia" value="disfagia"
                                {{ in_array('disfagia', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_gastrointestinal_disfagia">Disfagia</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_diare" value="diare"
                                {{ in_array('diare', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_gastrointestinal_diare">Diare</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_klismagliserin" value="klisma_sput_gliserin"
                                {{ in_array('klisma_sput_gliserin', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_gastrointestinal_klismagliserin">Klisma
                                sput gliserin</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_mual" value="mual_muntah"
                                {{ in_array('mual_muntah', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_gastrointestinal_mual">Mual/muntah</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_bisingusmenurun2" value="bising_usus_menurun2"
                                {{ in_array('bising_usus_menurun2', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_gastrointestinal_bisingusmenurun2">Bising
                                usus meningkat</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_intoleransidiet" value="intoleransi_diet"
                                {{ in_array('intoleransi_diet', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_gastrointestinal_intoleransidiet">Intoleransi diet</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_konstipasi" value="konstipasi"
                                {{ in_array('konstipasi', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_gastrointestinal_konstipasi">Konstipasi</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_gastrointestinal[]"
                                id="pemeriksaan_gastrointestinal_babberakhir" value="bab_berakhir"
                                {{ in_array('bab_berakhir', old('pemeriksaan_gastrointestinal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_gastrointestinal_babberakhir">BAB
                                terakhir : </label>
                        </td>
                        <td>
                            {{ $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_gastrointestinal_bab_terakhir ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <input type="checkbox"
                                {{ in_array('diet_khusus', old('gi', $asesmen->gi ?? [])) ? 'checked' : '' }}>
                            Diet khusus:
                            {{ $asesmen->asesmen_ket_dewasa_ranap_fisik->diet_khusus ?? '...................................................' }}
                        </td>
                    </tr>
                    {{-- @php
                    dd($asesmen);
                    @endphp --}}

                    <tr>
                        <td colspan="4">
                            <strong>Catatan:</strong>
                            {{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->catatan_khusus_diet ?? ('' ?? '............................................................') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" colspan="3">
                            Pemeriksaan kardiovaskular
                        </td>
                        <td style="text-align:right;">
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular_normal ?? '' }}>
                            <strong>Normal</strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_takikardi" value="takikardi"
                                {{ in_array('takikardi', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_kardiovaskular_takikardi">Takikardi</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_iregular" value="iregular"
                                {{ in_array('iregular', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_kardiovaskular_iregular">Iregular</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_tingling" value="tingling"
                                {{ in_array('tingling', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_kardiovaskular_tingling">Tingling</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_edema" value="edema"
                                {{ in_array('edema', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_kardiovaskular_edema">Edema</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_denyutnadilemah" value="denyut_nadi_lemah"
                                {{ in_array('denyut_nadi_lemah', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_kardiovaskular_denyutnadilemah">Denyut
                                nadi
                                lemah</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_bradikardi" value="bradikardi"
                                {{ in_array('bradikardi', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_kardiovaskular_bradikardi">Bradikardi</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_murmur" value="murmur"
                                {{ in_array('murmur', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_kardiovaskular_murmur">Murmur</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_baal" value="baal"
                                {{ in_array('baal', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_kardiovaskular_baal">Baal</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_fatique" value="fatique"
                                {{ in_array('fatique', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_kardiovaskular_fatique">Fatique</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_kardiovaskular[]"
                                id="pemeriksaan_kardiovaskular_denyuttidakada" value="denyut_tidak_ada"
                                {{ in_array('denyut_tidak_ada', old('pemeriksaan_kardiovaskular', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_kardiovaskular_denyuttidakada">Denyut
                                tidak
                                ada</label>
                        </td>
                        <td colspan="2"></td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <strong>Catatan:</strong>
                            {{ $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_kardiovaskular_catatan ?? ('' ?? '............................................................') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" colspan="3">
                            Pemeriksaan Genitourinaria dan Ginekologi
                        </td>
                        <td style="text-align:right;">
                            <input type="checkbox"
                                {{ old('pemeriksaan_genitourinaria_ginekologi_normal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi_normal ?? '') == 'normal' ? 'checked' : '' }}>
                            <strong>Normal</strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]"
                                id="pemeriksaan_genitourinaria_ginekologi_kateteri" value="kateter"
                                {{ in_array('kateter', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_genitourinaria_ginekologi_kateteri">Kateter</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]"
                                id="pemeriksaan_genitourinaria_ginekologi_hesitansi" value="hesitansi"
                                {{ in_array('hesitansi', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_genitourinaria_ginekologi_hesitansi">Hesitansi</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]"
                                id="pemeriksaan_genitourinaria_ginekologi_hematuria" value="hematuria"
                                {{ in_array('hematuria', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_genitourinaria_ginekologi_hematuria">Hematuria</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]"
                                id="pemeriksaan_genitourinaria_ginekologi_menopouse" value="menopouse"
                                {{ in_array('menopouse', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_genitourinaria_ginekologi_menopouse">Menopouse</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]"
                                id="pemeriksaan_genitourinaria_ginekologi_sekret_abnormal" value="sekret_abnormal"
                                {{ in_array('sekret_abnormal', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_genitourinaria_ginekologi_sekret_abnormal">Sekret abnormal</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]"
                                id="pemeriksaan_genitourinaria_ginekologi_urostomy" value="urostomy"
                                {{ in_array('urostomy', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_genitourinaria_ginekologi_urostomy">Urostomy</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]"
                                id="pemeriksaan_genitourinaria_inkontinesia" value="inkontinesia"
                                {{ in_array('inkontinesia', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_genitourinaria_inkontinesia">Inkontinesia</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]"
                                id="pemeriksaan_genitourinaria_nokturia" value="nokturia"
                                {{ in_array('nokturia', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_nokturia">Nokturia</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_disuria"
                                value="disuria"
                                {{ in_array('disuria', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_disuria">Disuria</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]"
                                id="pemeriksaan_genitourinaria_menstruasi_terakhir" value="menstruasi_terakhir"
                                {{ in_array('menstruasi_terakhir', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_genitourinaria_menstruasi_terakhir">Menstruasi terakhir</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox"
                                name="pemeriksaan_genitourinaria_ginekologi[]" id="pemeriksaan_genitourinaria_hamil"
                                value="hamil"
                                {{ in_array('hamil', old('pemeriksaan_genitourinaria_ginekologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_hamil">Hamil</label>
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <strong>Catatan:</strong>
                            {{ $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_genitourinaria_ginekologi_catatan ?? '............................................................' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" colspan="3">
                            Pemeriksaan Neurologi (orientasi, verbal, kekuatan)
                        </td>
                        <td style="text-align:right;">
                            <input type="checkbox"
                                {{ old('neuro_normal', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi_normal ?? '') == 'ya' ? 'checked' : '' }}>
                            <strong>Normal</strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_neurologi_dalam_sedasi" value="dalam_sedasi"
                                {{ in_array('dalam_sedasi', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_neurologi_dalam_sedasi">Dalam
                                sedasi</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_neurologi_vertigo" value="vertigo"
                                {{ in_array('vertigo', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_neurologi_vertigo">Vertigo</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_neurologi_afasia" value="afasia"
                                {{ in_array('afasia', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_neurologi_afasia">Afasia</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_neurologi_tremor" value="tremor"
                                {{ in_array('tremor', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_neurologi_tremor">Tremor</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_neurologi_tidak_stabil" value="tidak_stabil"
                                {{ in_array('tidak_stabil', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_neurologi_tidak_stabil">Tidak
                                stabil</label>
                        </td>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_neurologi_letargi" value="letargi"
                                {{ in_array('letargi', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_neurologi_letargi">Letargi</label>
                        </td>

                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_sakit_kepala" value="sakit_kepala"
                                {{ in_array('sakit_kepala', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_sakit_kepala">Sakit
                                kepala</label>
                        </td>

                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_Bicara_tidak_jelas" value="Bicara_tidak_jelas"
                                {{ in_array('Bicara_tidak_jelas', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_Bicara_tidak_jelas">Bicara
                                tidak jelas</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_baal" value="baal"
                                {{ in_array('baal', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_baal">Baal</label>
                        </td>

                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_paralisis" value="paralisis"
                                {{ in_array('paralisis', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="pemeriksaan_genitourinaria_paralisis">Paralisis</label>
                        </td>

                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_semi_koma" value="semi_koma"
                                {{ in_array('semi_koma', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_semi_koma">Semi
                                koma</label>
                        </td>

                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_pupil_tidak_reaktif" value="pupil_tidak_reaktif"
                                {{ in_array('pupil_tidak_reaktif', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_pupil_tidak_reaktif">Pupil
                                tidak reaktif</label>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_kejang" value="kejang"
                                {{ in_array('kejang', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_kejang">Kejang</label>
                        </td>

                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_tingling" value="tingling"
                                {{ in_array('tingling', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_tingling">Tingling</label>
                        </td>

                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_genggaman_lemah" value="genggaman_lemah"
                                {{ in_array('genggaman_lemah', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_genggaman_lemah">Genggaman
                                lemah</label>
                        </td>

                        <td>
                            <input class="form-check-input" type="checkbox" name="pemeriksaan_neurologi[]"
                                id="pemeriksaan_genitourinaria_lainnya" value="lainnya"
                                {{ in_array('lainnya', old('pemeriksaan_neurologi', $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="pemeriksaan_genitourinaria_lainnya">Lainnya</label>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <strong>Catatan:</strong>
                            {{ $asesmen->asesmen_ket_dewasa_ranap_fisik->pemeriksaan_neurologi_catatan ?? '............................................................' }}
                        </td>
                    </tr>



                </table>
            </td>
        </tr>
        @php
            $listKesadaran = ['Compos Mentis', 'Apatis', 'Somnolen', 'Sopor', 'Koma'];

            $selectedKesadaran = old('kesadaran', $asesmen->asesmen_ket_dewasa_ranap_fisik->kesadaran ?? '');

        @endphp

        <tr>
            <td class="label" colspan="4">
                Kesadaran :
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table>
                    @foreach ($listKesadaran as $items)
                        <td>
                            <input class="form-check-input" type="checkbox"
                                {{ $selectedKesadaran == $items ? 'checked' : '' }}>
                            {{ $items }}
                        </td>
                    @endforeach
                </table>
            </td>
        </tr>
        @php
            $vitalSigns = is_array($asesmen->vital_sign)
                ? $asesmen->vital_sign
                : (is_string($asesmen->asesmen_ket_dewasa_ranap_fisik->vital_sign)
                    ? json_decode($asesmen->asesmen_ket_dewasa_ranap_fisik->vital_sign, true)
                    : []);
            $gcsValue = $vitalSigns['gcs'] ?? '';

            // Contoh data string dari DB
            $gcsString = $gcsValue ?? '12 E3 V4 M5';

            // Ambil E, V, M dari string
            preg_match('/E(\d)/', $gcsString, $e);
            preg_match('/V(\d)/', $gcsString, $v);
            preg_match('/M(\d)/', $gcsString, $m);

            $gcs = [
                'E' => $e[1] ?? null,
                'V' => $v[1] ?? null,
                'M' => $m[1] ?? null,
            ];

            $totalGcs = array_sum(array_filter($gcs));

        @endphp
        <tr>
            <td colspan="3">
                <table border="1" width="100%">
                    <thead>
                        <tr>
                            <th>Glasgow Coma Scale</th>
                            <th>Dewasa</th>
                            <th>Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $eye = [
                                4 => 'Terbuka spontan',
                                3 => 'Terbuka saat dipanggil / diperintah',
                                2 => 'Terbuka terhadap rangsangan nyeri',
                                1 => 'Tidak merespon',
                            ];

                            $verbal = [
                                5 => 'Orientasi baik',
                                4 => 'Disorientasi / bingung',
                                3 => 'Jawaban tidak sesuai',
                                2 => 'Merancau (erangan / teriakan)',
                                1 => 'Tidak ada respon',
                            ];

                            $motoric = [
                                6 => 'Mengikuti perintah',
                                5 => 'Melokalisasi nyeri',
                                4 => 'Menarik diri (withdrawl) dari nyeri',
                                3 => 'Fleksi abnormal anggota gerak thd rangsangan',
                                2 => 'Ekstensi abnormal anggota gerak thd rangsangan',
                                1 => 'Tidak merespon',
                            ];
                        @endphp

                        <tr>
                            <td><strong>Eye / Mata</strong></td>
                            <td>{{ $eye[$gcs['E']] ?? '-' }}</td>
                            <td>{{ $gcs['E'] }}</td>
                        </tr>

                        <tr>
                            <td><strong>Verbal / Suara</strong></td>
                            <td>{{ $verbal[$gcs['V']] ?? '-' }}</td>
                            <td>{{ $gcs['V'] }}</td>
                        </tr>

                        <tr>
                            <td><strong>Motoric / Gerakan</strong></td>
                            <td>{{ $motoric[$gcs['M']] ?? '-' }}</td>
                            <td>{{ $gcs['M'] }}</td>
                        </tr>

                        <tr>
                            <td colspan="2" class="text-end"><strong>Total Skor</strong></td>
                            <td><strong>{{ $totalGcs }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="1">
                    <!-- Judul -->
                    <tr>
                        <td class="label" colspan="5">
                            <strong>4. PENGKAJIAN STATUS NUTRISI</strong>
                        </td>
                    </tr>

                    <!-- Soal 1 -->
                    <tr>
                        <td width="3%"><strong>1</strong></td>
                        <td colspan="2">
                            Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?
                        </td>
                        <td width="5%" class="text-center"><strong>Skor</strong></td>
                        <td rowspan="6" width="25%" valign="top">
                            Bila skor ≥ 2 dan atau pasien dengan diagnosis khusus dilakukan pengkajian lebih lanjut oleh
                            Dietisien
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->bb_turun == 0 ? 'checked' : '' }}>
                            Tidak ada
                        </td>
                        <td></td>
                        <td class="text-center">0</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->bb_turun == 2 ? 'checked' : '' }}>
                            Tidak yakin / tidak tahu / terasa baju longgar
                        </td>
                        <td class="text-center">2</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td colspan="3">
                            Jika <strong>"Ya"</strong> berapa penurunan berat badan tersebut:
                            {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->bb_turun_range }}
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->bb_turun_range == 1 ? 'checked' : '' }}>
                            1 s/d 5 Kg
                        </td>
                        <td></td>
                        <td class="text-center">1</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->bb_turun_range == 2 ? 'checked' : '' }}>
                            6 s/d 10 Kg
                        </td>
                        <td></td>
                        <td class="text-center">2</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->bb_turun_range == 3 ? 'checked' : '' }}F>
                            11 s/d 15 Kg
                        </td>
                        <td></td>
                        <td class="text-center">3</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->bb_turun_range == 4 ? 'checked' : '' }}>
                            &gt;
                        </td>
                        <td></td>
                        <td class="text-center">4</td>
                        <td></td>
                    </tr>

                    <!-- Soal 2 -->
                    <tr>
                        <td><strong>2</strong></td>
                        <td colspan="2">
                            Apakah asupan makan berkurang karena tidak nafsu makan?
                        </td>
                        <td class="text-center"></td>
                        <td rowspan="3" valign="top">
                            Sudah dibaca dan diketahui oleh dietisien
                            <br><br>
                            {{-- <input type="checkbox" {{
                                $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->nafsu_makan == 1 ? 'checked' : '' }}>
                            Ya, pukul:
                            <br>
                            <input type="checkbox" {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->nafsu_makan ==
                            0 ? 'checked' : '' }}>
                            Tidak --}}
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->nafsu_makan == 0 ? 'checked' : '' }}>
                            Tidak
                        </td>
                        <td></td>
                        <td class="text-center">0</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->nafsu_makan == 1 ? 'checked' : '' }}>
                            Ya
                        </td>
                        <td></td>
                        <td class="text-center">1</td>
                    </tr>

                    <!-- Soal 3 -->
                    <tr>
                        <td><strong>3</strong></td>
                        <td colspan="3">
                            Pasien dengan diagnosa khusus :
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->diagnosa_khusus == 'ya' ? 'checked' : '' }}>
                            Ya
                            &nbsp;
                            <input type="checkbox"
                                {{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->diagnosa_khusus == 'tidak' ? 'checked' : '' }}>
                            Tidak
                            <br>
                            <small>(Diabetes, Kemo, HD, geriatri, penurunan imun, dll sebutkan)</small>
                        </td>
                        <td></td>
                    </tr>

                    <!-- Total Skor -->
                    <tr>
                        <td colspan="3" class="text-end">
                            <strong>TOTAL SKOR</strong>
                        </td>
                        <td class="text-center">
                            <strong>{{ $asesmen->asesmen_ket_dewasa_ranap_status_nutrisi->status_nutrisi_total }}</strong>
                        </td>
                        <td></td>
                    </tr>

                </table>
            </td>
        </tr>
        {{-- <tr>
            <td colspan="4">
                <table border="1">
                    <tr>
                        <td class="label" colspan="3">
                            Pemeriksaan muskuloskeletal dan kulit (mobilitas, fungsi sendi, warna kulit, turgor)
                        </td>
                        <td style="text-align:right;">
                            <input type="checkbox" {{ old('muskuloskeletal_normal',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->muskuloskeletal_normal ?? '') == 'normal' ?
                            'checked' : '' }}>
                            <strong>Normal</strong>
                        </td>
                    </tr>

                    <!-- Mobilitas -->
                    <tr>
                        <td>Mobilitas</td>
                        <td>
                            <input type="checkbox" {{ in_array('normal', old('mobilitas',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->mobilitas ?? [])) ? 'checked' : '' }}>
                            Normal
                        </td>
                        <td colspan="2">
                            <input type="checkbox" {{ in_array('dibantu', old('mobilitas',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->mobilitas ?? [])) ? 'checked' : '' }}>
                            Dibantu
                        </td>
                    </tr>

                    <!-- Fungsi Sendi -->
                    <tr>
                        <td>Fungsi sendi</td>
                        <td>
                            <input type="checkbox" {{ in_array('normal', old('fungsi_sendi',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->fungsi_sendi ?? [])) ? 'checked' : '' }}>
                            Normal
                        </td>
                        <td>
                            <input type="checkbox" {{ in_array('deformitas', old('fungsi_sendi',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->fungsi_sendi ?? [])) ? 'checked' : '' }}>
                            Deformitas
                        </td>
                        <td>
                            <input type="checkbox" {{ in_array('atrofi', old('fungsi_sendi',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->fungsi_sendi ?? [])) ? 'checked' : '' }}>
                            Atrofi
                        </td>
                    </tr>

                    <!-- Extremitas -->
                    <tr>
                        <td>Extremitas</td>
                        <td>
                            <input type="checkbox" {{ in_array('normal', old('extremitas',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->extremitas ?? [])) ? 'checked' : '' }}>
                            Normal
                        </td>
                        <td>
                            <input type="checkbox" {{ in_array('oedema', old('extremitas',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->extremitas ?? [])) ? 'checked' : '' }}>
                            Oedema
                        </td>
                        <td>
                            <input type="checkbox" {{ in_array('deformitas', old('extremitas',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->extremitas ?? [])) ? 'checked' : '' }}>
                            Deformitas
                        </td>
                    </tr>

                    <!-- Warna Kulit -->
                    <tr>
                        <td>Warna kulit</td>
                        <td>
                            <input type="checkbox" {{ in_array('normal', old('warna_kulit',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->warna_kulit ?? [])) ? 'checked' : '' }}>
                            Normal
                        </td>
                        <td>
                            <input type="checkbox" {{ in_array('pucat', old('warna_kulit',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->warna_kulit ?? [])) ? 'checked' : '' }}>
                            Pucat
                        </td>
                        <td>
                            <input type="checkbox" {{ in_array('kemerahan', old('warna_kulit',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->warna_kulit ?? [])) ? 'checked' : '' }}>
                            Kemerahan
                            &nbsp;
                            <input type="checkbox" {{ in_array('lainnya', old('warna_kulit',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->warna_kulit ?? [])) ? 'checked' : '' }}>
                            Lainnya
                        </td>
                    </tr>

                    <!-- Turgor -->
                    <tr>
                        <td>Turgor</td>
                        <td>
                            <input type="checkbox" {{ in_array('normal', old('turgor',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->turgor ?? [])) ? 'checked' : '' }}>
                            Normal
                        </td>
                        <td colspan="2">
                            <input type="checkbox" {{ in_array('buruk', old('turgor',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->turgor ?? [])) ? 'checked' : '' }}>
                            Buruk
                            &nbsp;
                            <input type="checkbox" {{ in_array('lainnya', old('turgor',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->turgor ?? [])) ? 'checked' : '' }}>
                            Lainnya
                        </td>
                    </tr>

                    <!-- Permukaan Kulit -->
                    <tr>
                        <td>Permukaan kulit</td>
                        <td>
                            <input type="checkbox" {{ in_array('normal', old('permukaan_kulit',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->permukaan_kulit ?? [])) ? 'checked' : '' }}>
                            Normal
                        </td>
                        <td>
                            <input type="checkbox" {{ in_array('lembab', old('permukaan_kulit',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->permukaan_kulit ?? [])) ? 'checked' : '' }}>
                            Lembab
                        </td>
                        <td>
                            <input type="checkbox" {{ in_array('dingin', old('permukaan_kulit',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->permukaan_kulit ?? [])) ? 'checked' : '' }}>
                            Dingin
                            &nbsp;
                            <input type="checkbox" {{ in_array('panas', old('permukaan_kulit',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->permukaan_kulit ?? [])) ? 'checked' : '' }}>
                            Panas
                        </td>
                    </tr>

                    <!-- Kondisi Luka -->
                    <tr>
                        <td>Kondisi luka</td>
                        <td>
                            <input type="checkbox" {{ in_array('tidak_ada', old('kondisi_luka',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->kondisi_luka ?? [])) ? 'checked' : '' }}>
                            Tidak Ada
                        </td>
                        <td colspan="2">
                            <input type="checkbox" {{ in_array('ada', old('kondisi_luka',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->kondisi_luka ?? [])) ? 'checked' : '' }}>
                            Ada
                            &nbsp;
                            <input type="checkbox" {{ in_array('luka_bersih', old('kondisi_luka',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->kondisi_luka ?? [])) ? 'checked' : '' }}>
                            Luka bersih
                            &nbsp;
                            <input type="checkbox" {{ in_array('luka_kotor', old('kondisi_luka',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->kondisi_luka ?? [])) ? 'checked' : '' }}>
                            Luka kotor
                            &nbsp;
                            <input type="checkbox" {{ in_array('jahitan', old('kondisi_luka',
                                $asesmen->asesmen_ket_dewasa_ranap_fisik->kondisi_luka ?? [])) ? 'checked' : '' }}>
                            Jahitan luka
                        </td>
                    </tr>

                    <!-- Catatan -->
                    <tr>
                        <td colspan="4">
                            <strong>Catatan:</strong>
                            {{ $asesmen->muskuloskeletal_catatan ??
                            '............................................................' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr> --}}
        <tr>
            <td colspan="4" class="label" style=" font-size: 10pt;">PENGKAJIAN STATUS NYERI</td>
        </tr>
        @php
            function image_to_base64($relativePath)
            {
                $path = public_path($relativePath);

                if (!file_exists($path)) {
                    return null;
                }

                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);

                return 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        @endphp
        <tr>
            <td colspan="2">
                <table border="1" class="table table-bordered">
                    <tr>
                        <td>
                            A.Numeric Rating Pain Scale
                        </td>
                        <td>
                            B.Wong Baker Faces Pain Scale
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="card">
                                <div class="card-body text-center">
                                    @php
                                        $numericBase64 = image_to_base64('assets/img/asesmen/numerik.png');
                                    @endphp

                                    @if ($numericBase64)
                                        <img src="{{ $numericBase64 }}" style="width : 380px;" class="img-fluid">
                                    @else
                                        <p class="text-muted">Gambar tidak tersedia</p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="card">
                                <div class="card-body text-center">
                                    @php
                                        $wongBase64 = image_to_base64('assets/img/asesmen/asesmen.jpeg');
                                    @endphp

                                    @if ($wongBase64)
                                        <img src="{{ $wongBase64 }}" style="width : 360px;" class="img-fluid">
                                    @else
                                        <p class="text-muted">Gambar tidak tersedia</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>

        <tr>
            <td colspan="2">
                <table border="1" cellpadding="8" cellspacing="0"
                    style="border-collapse: collapse; width:100%; font-family:Arial;">
                    <tr>
                        <th class="label">
                            Lokasi nyeri
                        </th>
                        <td class="value" colspan="13">
                            {{ old('lokasi_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->lokasi_nyeri ?? '') }}
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Jenis nyeri
                        </th>
                        <td colspan="7">
                            <input type="checkbox"
                                {{ in_array('akut', old('jenis_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->jenis_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Akut
                        </td>
                        <td colspan="6">
                            <input type="checkbox"
                                {{ in_array('kronik', old('jenis_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->jenis_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Kronik
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Frekuensi nyeri
                        </th>
                        <td colspan="4">
                            <input type="checkbox"
                                {{ in_array('jarang', old('frekuensi_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->frekuensi_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Jarang
                        </td>
                        <td colspan="4">
                            <input type="checkbox"
                                {{ in_array('hilang_timbul', old('frekuensi_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->frekuensi_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Hilang timbul
                        </td>
                        <td colspan="5">
                            <input type="checkbox"
                                {{ in_array('terus_menerus', old('frekuensi_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->frekuensi_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Terus menerus
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Durasi nyeri
                        </th>
                        <td colspan="13">
                            {{ old('durasi_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->durasi_nyeri ?? '') }}
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Menjalar
                        </th>
                        <td colspan="6">
                            <input type="checkbox"
                                {{ old('nyeri_menjalar', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->nyeri_menjalar ?? '') == 'tidak' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Tidak
                        </td>
                        <td colspan="7">
                            <input type="checkbox"
                                {{ old('nyeri_menjalar', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->nyeri_menjalar ?? '') == 'ya' ? 'checked' : '' }}
                                style="margin-right: 6px;"> Ya, ke :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->durasi_nyeri_lokasi ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Kualitas nyeri
                        </th>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('nyeri_tumpul', old('kualitas_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->kualitas_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Nyeri tumpul
                        </td>
                        <td colspan="5">
                            <input type="checkbox"
                                {{ in_array('nyeri_tajam', old('kualitas_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->kualitas_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Nyeri tajam
                        </td>
                        <td colspan="6">
                            <input type="checkbox"
                                {{ in_array('panas_terbakar', old('kualitas_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->kualitas_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Panas/ terbakar
                        </td>
                    </tr>
                    <tr>
                        <th class="label">
                            Faktor pemberat
                        </th>
                        <td>
                            <input type="checkbox"
                                {{ in_array('cahaya', old('faktor_pemberat', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->faktor_pemberat ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Cahaya
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('gelap', old('faktor_pemberat', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->faktor_pemberat ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Gelap
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('berbaring', old('faktor_pemberat', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->faktor_pemberat ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Berbaring
                        </td>
                        <td colspan="6">
                            <input type="checkbox"
                                {{ in_array('gerakan', old('faktor_pemberat', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->faktor_pemberat ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Gerakan
                        </td>

                    </tr>
                    <tr>
                        <th class="label">
                            Faktor peringan
                        </th>
                        <td>
                            <input type="checkbox"
                                {{ in_array('cahaya', old('faktor_peringan', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->faktor_peringan ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Cahaya
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('gelap', old('faktor_peringan', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->faktor_peringan ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Gelap
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('berbaring', old('faktor_peringan', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->faktor_peringan ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Berbaring
                        </td>
                        <td colspan="6">
                            <input type="checkbox"
                                {{ in_array('gerakan', old('faktor_peringan', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->faktor_peringan ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Gerakan
                        </td>

                    </tr>
                    <tr>
                        <th class="label">
                            Efek nyeri
                        </th>
                        <td>
                            <input type="checkbox"
                                {{ in_array('mual_muntah', old('efek_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->efek_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Mual/ muntah
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('tidur', old('efek_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->efek_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Tidur
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('nafsu_makan', old('efek_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->efek_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Nafsu makan :
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('muntah', old('efek_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->efek_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Muntah :
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('aktivitas', old('efek_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->efek_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Aktivitas :
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <input type="checkbox"
                                {{ in_array('emosi', old('efek_nyeri', $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->efek_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Emosi :
                        </td>
                        <td colspan="7">
                            <input type="checkbox"
                                {{ in_array('emosi', old('lainya', $asesmen->CC->efek_nyeri ?? [])) ? 'checked' : '' }}
                                style="margin-right: 6px;"> Lainnya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_skala_nyeri->efek_nyeri_lainnya_text ?? '' }}
                        </td>
                    </tr>
                    <!-- sisanya bisa ditambah sendiri dengan pola yang sama -->
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="label" style=" font-size: 2pt;">6.A. PENGKAJIAN RESIKO JATUH SKALA MORSE (USIA
                19
                s.d 59 Tahun)</td>
        </tr>
        @php
            $morse = $asesmen->asesmen_ket_dewasa_ranap_resiko_jatuh ?? null;

            $rows = [
                [
                    'label' => 'Riwayat Jatuh',
                    'nilai' => $morse->risiko_jatuh_morse_riwayat_jatuh ?? 0,
                    'ket' => ($morse->risiko_jatuh_morse_riwayat_jatuh ?? 0) == 25 ? 'Ya' : 'Tidak',
                ],
                [
                    'label' => 'Diagnosis Sekunder (> 2 diagnosis)',
                    'nilai' => $morse->risiko_jatuh_morse_diagnosis_sekunder ?? 0,
                    'ket' => ($morse->risiko_jatuh_morse_diagnosis_sekunder ?? 0) == 15 ? 'Ya' : 'Tidak',
                ],
                [
                    'label' => 'Alat Bantu',
                    'nilai' => $morse->risiko_jatuh_morse_bantuan_ambulasi ?? 0,
                    'ket' => match ($morse->risiko_jatuh_morse_bantuan_ambulasi ?? 0) {
                        15 => 'Kruk / Tongkat / Alat bantu',
                        30 => 'Meja / Kursi',
                        default => 'Tidak ada / Bedrest / Bantuan perawat',
                    },
                ],
                [
                    'label' => 'Terpasang Infus',
                    'nilai' => $morse->risiko_jatuh_morse_terpasang_infus ?? 0,
                    'ket' => ($morse->risiko_jatuh_morse_terpasang_infus ?? 0) == 20 ? 'Ya' : 'Tidak',
                ],
                [
                    'label' => 'Gaya Berjalan',
                    'nilai' => $morse->risiko_jatuh_morse_cara_berjalan ?? 0,
                    'ket' => match ($morse->risiko_jatuh_morse_cara_berjalan ?? 0) {
                        10 => 'Lemah',
                        20 => 'Terganggu',
                        default => 'Normal / Bedrest / Kursi roda',
                    },
                ],
                [
                    'label' => 'Status Mental',
                    'nilai' => $morse->risiko_jatuh_morse_status_mental ?? 0,
                    'ket' =>
                        ($morse->risiko_jatuh_morse_status_mental ?? 0) == 15
                            ? 'Lupa akan keterbatasannya'
                            : 'Berorientasi pada kemampuannya',
                ],
            ];

            $total = collect($rows)->sum('nilai');
        @endphp
        <tr>
            <td colspan="2">

                <table width="100%" border="1" cellspacing="0" cellpadding="6"
                    style="border-collapse:collapse; font-size:12px">
                    <thead>
                        <tr style="background:#f0f0f0; text-align:center">
                            <th width="5%">No</th>
                            <th width="45%">Faktor Risiko</th>
                            <th width="30%">Kondisi Pasien</th>
                            <th width="20%">Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $i => $row)
                            <tr>
                                <td align="center">{{ $i + 1 }}</td>
                                <td>{{ $row['label'] }}</td>
                                <td>{{ $row['ket'] }}</td>
                                <td align="center">{{ $row['nilai'] }}</td>
                            </tr>
                        @endforeach

                        <tr style="font-weight:bold; background:#fafafa">
                            <td colspan="3" align="right">TOTAL SKOR</td>
                            <td align="center">{{ $total }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        {{-- KESIMPULAN --}}
        @php
            $kesimpulan = $total <= 24 ? 'Risiko Rendah' : ($total <= 44 ? 'Risiko Sedang' : 'Risiko Tinggi');
        @endphp

        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="8"
                    style="border-collapse:collapse; font-size:13px">
                    <tr>
                        <td width="30%"><strong>Kesimpulan</strong></td>
                        <td width="70%"><strong>{{ $kesimpulan }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        @php
            $ontario = $asesmen->asesmen_ket_dewasa_ranap_resiko_jatuh;
        @endphp

        <tr class="page-break">
            <td colspan="4" class="label" style=" font-size: 10pt;">6.A. PENGKAJIAN RESIKO JATUH SKALA MORSE
                (USIA 19
                6.B. PENGKAJIAN RISIKO JATUH KHUSUS LANSIA / GERIATRI
                <br>(Usia &gt; 60 Tahun)
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="6"
                    style="border-collapse:collapse;font-size:12px">

                    <thead>
                        <tr style="background:#f2f2f2;text-align:center">
                            <th width="5%">No</th>
                            <th width="45%">Parameter</th>
                            <th width="30%">Kondisi Pasien</th>
                            <th width="20%">Nilai</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- 1. RIWAYAT JATUH --}}
                        <tr>
                            <td align="center">1</td>
                            <td>Datang ke RS karena jatuh</td>
                            <td>{{ $ontario->ontario_jatuh_saat_masuk === null ? '-' : ($ontario->ontario_jatuh_saat_masuk == 6 ? 'Ya' : 'Tidak') }}
                            </td>
                            <td align="center">{{ $ontario->ontario_jatuh_saat_masuk ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">2</td>
                            <td>Riwayat jatuh 2 bulan terakhir</td>
                            <td>{{ $ontario->ontario_jatuh_2_bulan === null ? '-' : ($ontario->ontario_jatuh_2_bulan == 6 ? 'Ya' : 'Tidak') }}
                            </td>
                            <td align="center">{{ $ontario->ontario_jatuh_2_bulan ?? '-' }}</td>
                        </tr>

                        {{-- 2. STATUS MENTAL --}}
                        <tr>
                            <td align="center">3</td>
                            <td>Delirium</td>
                            <td>{{ $ontario->ontario_delirium === null ? '-' : ($ontario->ontario_delirium == 14 ? 'Ya' : 'Tidak') }}
                            </td>
                            <td align="center">{{ $ontario->ontario_delirium ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">4</td>
                            <td>Disorientasi</td>
                            <td>{{ $ontario->ontario_disorientasi === null ? '-' : ($ontario->ontario_disorientasi == 14 ? 'Ya' : 'Tidak') }}
                            </td>
                            <td align="center">{{ $ontario->ontario_disorientasi ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">5</td>
                            <td>Agitasi</td>
                            <td>{{ $ontario->ontario_agitasi === null ? '-' : ($ontario->ontario_agitasi == 14 ? 'Ya' : 'Tidak') }}
                            </td>
                            <td align="center">{{ $ontario->ontario_agitasi ?? '-' }}</td>
                        </tr>

                        {{-- 3. PENGLIHATAN --}}
                        <tr>
                            <td align="center">6</td>
                            <td>Menggunakan kacamata</td>
                            <td>{{ $ontario->ontario_kacamata === null ? '-' : ($ontario->ontario_kacamata == 1 ? 'Ya' : 'Tidak') }}
                            </td>
                            <td align="center">{{ $ontario->ontario_kacamata ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">7</td>
                            <td>Penglihatan buram</td>
                            <td>{{ $ontario->ontario_penglihatan_buram === null ? '-' : ($ontario->ontario_penglihatan_buram == 1 ? 'Ya' : 'Tidak') }}
                            </td>
                            <td align="center">{{ $ontario->ontario_penglihatan_buram ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">8</td>
                            <td>Glaukoma / Katarak / Degenerasi makula</td>
                            <td>{{ $ontario->ontario_glaukoma === null ? '-' : ($ontario->ontario_glaukoma == 1 ? 'Ya' : 'Tidak') }}
                            </td>
                            <td align="center">{{ $ontario->ontario_glaukoma ?? '-' }}</td>
                        </tr>

                        {{-- 4. BERKEMIH --}}
                        <tr>
                            <td align="center">9</td>
                            <td>Perubahan kebiasaan berkemih</td>
                            <td>{{ $ontario->ontario_berkemih === null ? '-' : ($ontario->ontario_berkemih == 2 ? 'Ya' : 'Tidak') }}
                            </td>
                            <td align="center">{{ $ontario->ontario_berkemih ?? '-' }}</td>
                        </tr>

                        {{-- 5. TRANSFER --}}
                        <tr>
                            <td align="center">10</td>
                            <td>Kemampuan transfer</td>
                            <td>
                                @if ($ontario->ontario_transfer === null)
                                    -
                                @elseif($ontario->ontario_transfer == 0)
                                    Mandiri
                                @elseif($ontario->ontario_transfer == 1)
                                    Bantuan 1 orang
                                @elseif($ontario->ontario_transfer == 2)
                                    Bantuan 2 orang
                                @else
                                    Bantuan total
                                @endif
                            </td>
                            <td align="center">{{ $ontario->ontario_transfer ?? '-' }}</td>
                        </tr>

                        {{-- 6. MOBILITAS --}}
                        <tr>
                            <td align="center">11</td>
                            <td>Kemampuan mobilitas</td>
                            <td>
                                @if ($ontario->ontario_mobilitas === null)
                                    -
                                @elseif($ontario->ontario_mobilitas == 0)
                                    Mandiri
                                @elseif($ontario->ontario_mobilitas == 1)
                                    Bantuan 1 orang
                                @elseif($ontario->ontario_mobilitas == 2)
                                    Kursi roda
                                @else
                                    Imobilisasi
                                @endif
                            </td>
                            <td align="center">{{ $ontario->ontario_mobilitas ?? '-' }}</td>
                        </tr>

                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="8"
                    style="border-collapse:collapse;font-size:13px">
                    <tr>
                        <td width="30%"><strong>Kesimpulan</strong></td>
                        <td width="70%"><strong>{{ $ontario->risiko_jatuh_lansia_kesimpulan ?? '-' }}</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        @php
            $norton = $asesmen->asesmen_ket_dewasa_ranap_resiko_jatuh;

            $totalNorton =
                ($norton->norton_kondisi_fisik ?? 0) +
                ($norton->norton_kondisi_mental ?? 0) +
                ($norton->norton_aktivitas ?? 0) +
                ($norton->norton_mobilitas ?? 0) +
                ($norton->norton_inkontinensia ?? 0);
        @endphp

        <tr class="">
            <td colspan="4" class="label" style=" font-size: 10pt;"> 7. PENGKAJIAN RISIKO DECUBITUS (SKALA
                NORTON)
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="6"
                    style="border-collapse:collapse;font-size:12px">

                    <thead>
                        <tr style="background:#f2f2f2;text-align:center">
                            <th width="5%">No</th>
                            <th width="45%">Parameter</th>
                            <th width="30%">Kondisi Pasien</th>
                            <th width="20%">Skor</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td align="center">1</td>
                            <td>Kondisi Fisik</td>
                            <td>
                                @if ($norton->norton_kondisi_fisik === null)
                                    -
                                @elseif($norton->norton_kondisi_fisik == 4)
                                    Baik
                                @elseif($norton->norton_kondisi_fisik == 3)
                                    Cukup
                                @elseif($norton->norton_kondisi_fisik == 2)
                                    Buruk
                                @else
                                    Sangat Buruk
                                @endif
                            </td>
                            <td align="center">{{ $norton->norton_kondisi_fisik ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">2</td>
                            <td>Kondisi Mental</td>
                            <td>
                                @if ($norton->norton_kondisi_mental === null)
                                    -
                                @elseif($norton->norton_kondisi_mental == 4)
                                    Compos Mentis
                                @elseif($norton->norton_kondisi_mental == 3)
                                    Apatis
                                @elseif($norton->norton_kondisi_mental == 2)
                                    Delirium
                                @else
                                    Stupor
                                @endif
                            </td>
                            <td align="center">{{ $norton->norton_kondisi_mental ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">3</td>
                            <td>Aktivitas</td>
                            <td>
                                @if ($norton->norton_aktivitas === null)
                                    -
                                @elseif($norton->norton_aktivitas == 4)
                                    Mandiri
                                @elseif($norton->norton_aktivitas == 3)
                                    Dipapah
                                @elseif($norton->norton_aktivitas == 2)
                                    Kursi Roda
                                @else
                                    Tirah Baring
                                @endif
                            </td>
                            <td align="center">{{ $norton->norton_aktivitas ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">4</td>
                            <td>Mobilitas</td>
                            <td>
                                @if ($norton->norton_mobilitas === null)
                                    -
                                @elseif($norton->norton_mobilitas == 4)
                                    Baik
                                @elseif($norton->norton_mobilitas == 3)
                                    Agak Terbatas
                                @elseif($norton->norton_mobilitas == 2)
                                    Sangat Terbatas
                                @else
                                    Immobilisasi
                                @endif
                            </td>
                            <td align="center">{{ $norton->norton_mobilitas ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">5</td>
                            <td>Inkontinensia</td>
                            <td>
                                @if ($norton->norton_inkontinensia === null)
                                    -
                                @elseif($norton->norton_inkontinensia == 4)
                                    Tidak
                                @elseif($norton->norton_inkontinensia == 3)
                                    Terkadang
                                @elseif($norton->norton_inkontinensia == 2)
                                    Sering
                                @else
                                    Selalu
                                @endif
                            </td>
                            <td align="center">{{ $norton->norton_inkontinensia ?? '-' }}</td>
                        </tr>

                        <tr style="font-weight:bold;background:#fafafa">
                            <td colspan="3" align="center">TOTAL SKOR</td>
                            <td align="center">{{ $totalNorton }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="8"
                    style="border-collapse:collapse;font-size:13px">
                    <tr>
                        <td width="30%"><strong>Kesimpulan</strong></td>
                        <td width="70%">
                            <strong>{{ $norton->risiko_norton_kesimpulan ?? '-' }}</strong>
                            <br>
                            <small>
                                @if ($totalNorton < 12)
                                    Risiko Tinggi
                                @elseif($totalNorton <= 15)
                                    Risiko Sedang
                                @else
                                    Risiko Rendah
                                @endif
                            </small>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        @php
            $adl = $asesmen->asesmen_ket_dewasa_ranap_resiko_jatuh;

            $totalADL = ($adl->adl_makan ?? 0) + ($adl->adl_berjalan ?? 0) + ($adl->adl_mandi ?? 0);
        @endphp
        <tr class="">
            <td colspan="4" class="label" style=" font-size: 10pt;"> 8.. PENGKAJIAN AKTIVITAS HARIAN (ADL)
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="6"
                    style="border-collapse:collapse;font-size:12px">

                    <thead>
                        <tr style="background:#f2f2f2;text-align:center">
                            <th width="5%">No</th>
                            <th width="45%">Aktivitas</th>
                            <th width="30%">Kondisi Pasien</th>
                            <th width="20%">Skor</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td align="center">1</td>
                            <td>Makan / Memakai Baju</td>
                            <td>
                                @if ($adl->adl_makan === null)
                                    -
                                @elseif($adl->adl_makan == 0)
                                    Mandiri
                                @elseif($adl->adl_makan == 1)
                                    25% Dibantu
                                @elseif($adl->adl_makan == 2)
                                    50% Dibantu
                                @else
                                    75% Dibantu
                                @endif
                            </td>
                            <td align="center">{{ $adl->adl_makan ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">2</td>
                            <td>Berjalan</td>
                            <td>
                                @if ($adl->adl_berjalan === null)
                                    -
                                @elseif($adl->adl_berjalan == 0)
                                    Mandiri
                                @elseif($adl->adl_berjalan == 1)
                                    25% Dibantu
                                @elseif($adl->adl_berjalan == 2)
                                    50% Dibantu
                                @else
                                    75% Dibantu
                                @endif
                            </td>
                            <td align="center">{{ $adl->adl_berjalan ?? '-' }}</td>
                        </tr>

                        <tr>
                            <td align="center">3</td>
                            <td>Mandi / Buang Air</td>
                            <td>
                                @if ($adl->adl_mandi === null)
                                    -
                                @elseif($adl->adl_mandi == 0)
                                    Mandiri
                                @elseif($adl->adl_mandi == 1)
                                    25% Dibantu
                                @elseif($adl->adl_mandi == 2)
                                    50% Dibantu
                                @else
                                    75% Dibantu
                                @endif
                            </td>
                            <td align="center">{{ $adl->adl_mandi ?? '-' }}</td>
                        </tr>

                        <tr style="font-weight:bold;background:#fafafa">
                            <td colspan="3" align="center">TOTAL SKOR</td>
                            <td align="center">{{ $totalADL }}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="100%" border="1" cellspacing="0" cellpadding="8"
                    style="border-collapse:collapse;font-size:13px">
                    <tr>
                        <td width="30%"><strong>Kesimpulan</strong></td>
                        <td width="70%">
                            <strong>{{ $adl->adl_kesimpulan ?? '-' }}</strong>
                            <br>
                            <small>
                                @if ($totalADL == 0)
                                    Mandiri
                                @elseif($totalADL <= 3)
                                    Ketergantungan Ringan
                                @elseif($totalADL <= 6)
                                    Ketergantungan Sedang
                                @else
                                    Ketergantungan Total
                                @endif
                            </small>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        {{-- @php
        dd($asesmen);
        @endphp --}}
        <tr class="">
            <td colspan="4" class="label" style=" font-size: 10pt;"> 9. PENGKAJIAN EDUKASI / PENDIDIKAN DAN
                PENGAJARAN
            </td>
        </tr>
        <tr>
            <td colspan="8">
                <table border="1" width="100%" cellspacing="0" cellpadding="6"
                    style="border-collapse:collapse;font-size:12px">
                    {{-- BICARA --}}
                    <tr>
                        <th class="label" width="20%">Bicara</th>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('normal', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->bicara ?? []) ? 'checked' : '' }}>
                            Normal
                        </td>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('tidak_normal', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->bicara ?? []) ? 'checked' : '' }}>
                            Tidak normal
                        </td>
                        <td colspan="3">
                            Lainnya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->bicara_lainnya ?? '................' }}
                        </td>
                    </tr>

                    {{-- BAHASA SEHARI-HARI --}}
                    <tr>
                        <th class="label">Bahasa sehari-hari</th>
                        <td>
                            <input type="checkbox"
                                {{ in_array('indonesia', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->bahasa_sehari ?? []) ? 'checked' : '' }}>
                            Indonesia
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('daerah', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->bahasa_sehari ?? []) ? 'checked' : '' }}>
                            Daerah
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('asing', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->bahasa_sehari ?? []) ? 'checked' : '' }}>
                            Asing
                        </td>
                        <td colspan="4">
                            Lainnya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->bahasa_sehari_lainnya ?? '................' }}
                        </td>
                    </tr>

                    {{-- PENERJEMAH --}}
                    <tr>
                        <th class="label">Perlu penerjemah</th>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('tidak', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->penerjemah ?? []) ? 'checked' : '' }}>
                            Tidak
                        </td>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('ya', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->penerjemah ?? []) ? 'checked' : '' }}>
                            Ya
                        </td>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('bahasa_isyarat', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->penerjemah ?? []) ? 'checked' : '' }}>
                            Bahasa isyarat
                        </td>
                        <td>
                            Bahasa :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->penerjemah_bahasa ?? '........' }}
                        </td>
                    </tr>

                    {{-- HAMBATAN --}}
                    <tr>
                        <th class="label">Hambatan komunikasi / belajar</th>
                        <td>
                            <input type="checkbox"
                                {{ in_array('bahasa', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->hambatan ?? []) ? 'checked' : '' }}>
                            Bahasa
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('menulis', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->hambatan ?? []) ? 'checked' : '' }}>
                            Menulis
                        </td>
                        <td>
                            <input type="checkbox"
                                {{ in_array('cemas', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->hambatan ?? []) ? 'checked' : '' }}>
                            Cemas
                        </td>
                        <td colspan="4">
                            <input type="checkbox"
                                {{ in_array('lain', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->hambatan ?? []) ? 'checked' : '' }}>
                            Lainnya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->hambatan_lainnya ?? '........' }}
                        </td>
                    </tr>

                    {{-- CARA KOMUNIKASI --}}
                    <tr>
                        <th class="label">Cara komunikasi disukai</th>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('audio_visual', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->cara_komunikasi ?? []) ? 'checked' : '' }}>
                            Audio visual
                        </td>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('diskusi', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->cara_komunikasi ?? []) ? 'checked' : '' }}>
                            Diskusi
                        </td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('lain', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->cara_komunikasi ?? []) ? 'checked' : '' }}>
                            Lainnya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->cara_komunikasi_lainnya ?? '........' }}
                        </td>
                    </tr>

                    {{-- PENDIDIKAN --}}
                    <tr>
                        <th class="label">Tingkat pendidikan</th>
                        <td><input type="checkbox"
                                {{ in_array('tk', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->pendidikan ?? []) ? 'checked' : '' }}>
                            TK</td>
                        <td><input type="checkbox"
                                {{ in_array('sd', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->pendidikan ?? []) ? 'checked' : '' }}>
                            SD</td>
                        <td><input type="checkbox"
                                {{ in_array('smp', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->pendidikan ?? []) ? 'checked' : '' }}>
                            SMP</td>
                        <td><input type="checkbox"
                                {{ in_array('smu', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->pendidikan ?? []) ? 'checked' : '' }}>
                            SMU</td>
                        <td><input type="checkbox"
                                {{ in_array('akademi', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->pendidikan ?? []) ? 'checked' : '' }}>
                            Akademi</td>
                        <td colspan="2">
                            <input type="checkbox"
                                {{ in_array('sarjana', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->pendidikan ?? []) ? 'checked' : '' }}>
                            Sarjana :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->pendidikan_detail ?? '........' }}
                        </td>
                    </tr>

                    {{-- POTENSI PEMBELAJARAN --}}
                    <tr>
                        <th class="label">Potensi kebutuhan pembelajaran</th>
                        <td><input type="checkbox"
                                {{ in_array('proses_penyakit', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->potensi_pembelajaran ?? []) ? 'checked' : '' }}>
                            Proses penyakit</td>
                        <td><input type="checkbox"
                                {{ in_array('pengobatan_tindakan', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->potensi_pembelajaran ?? []) ? 'checked' : '' }}>
                            Pengobatan</td>
                        <td><input type="checkbox"
                                {{ in_array('terapi_obat', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->potensi_pembelajaran ?? []) ? 'checked' : '' }}>
                            Terapi obat</td>
                        <td><input type="checkbox"
                                {{ in_array('nutrisi', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->potensi_pembelajaran ?? []) ? 'checked' : '' }}>
                            Nutrisi</td>
                        <td colspan="3">
                            <input type="checkbox"
                                {{ in_array('lain', $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->potensi_pembelajaran ?? []) ? 'checked' : '' }}>
                            Lainnya :
                            {{ $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->potensi_pembelajaran_lainnya ?? '........' }}
                        </td>
                    </tr>

                    {{-- CATATAN --}}
                    <tr>
                        <th class="label">Catatan khusus</th>
                        <td colspan="7">
                            {{ $asesmen->asesmen_ket_dewasa_ranap_pengkajian_edukasi->catatan_khusus ?? '...........................................' }}
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        @php
            $dischargePlanning = optional($asesmen->asesmen_ket_dewasa_ranap_discharge_planning);
        @endphp
        <tr class="page-break">
            <td colspan="4" class="label" style=" font-size: 10pt;"> 10. PERENCANAAN PULANG PASIEN (DISCHARGE
                PLANNING)
        </tr>


        <tr>
            <td colspan="2">
                <table>
                    <tr>
                        <td>Usia lanjut (&gt; 60 th)</td>
                        <td>
                            <input type="checkbox" disabled
                                {{ $dischargePlanning->usia_lanjut == 'ya' ? 'checked' : '' }}>
                            Ya
                            <input type="checkbox" disabled
                                {{ $dischargePlanning->usia_lanjut == 'tidak' ? 'checked' : '' }}>
                            Tidak
                        </td>
                        <td rowspan="4" style="text-align:center;font-weight:bold;">
                            Jika salah satu jawaban "ya" <br> maka pasien membutuhkan <br> rencana pulang khusus.
                        </td>
                    </tr>
                    <tr>
                        <td>Hambatan mobilisasi</td>
                        <td>
                            <input type="checkbox" disabled
                                {{ $dischargePlanning->hambatan_mobilisasi == 'ya' ? 'checked' : '' }}> Ya
                            <input type="checkbox" disabled
                                {{ $dischargePlanning->hambatan_mobilisasi == 'tidak' ? 'checked' : '' }}> Tidak
                        </td>
                    </tr>
                    <tr>
                        <td>Membutuhkan pelayanan medis berkelanjutan</td>
                        <td>
                            <input type="checkbox" disabled
                                {{ $dischargePlanning->penggunaan_media_berkelanjutan == 'ya' ? 'checked' : '' }}> Ya
                            <input type="checkbox" disabled
                                {{ $dischargePlanning->penggunaan_media_berkelanjutan == 'tidak' ? 'checked' : '' }}>
                            Tidak
                        </td>
                    </tr>
                    <tr>
                        <td>Ketergantungan aktivitas harian</td>
                        <td>
                            <input type="checkbox" disabled
                                {{ $dischargePlanning->ketergantungan_aktivitas == 'ya' ? 'checked' : '' }}> Ya
                            <input type="checkbox" disabled
                                {{ $dischargePlanning->ketergantungan_aktivitas == 'tidak' ? 'checked' : '' }}> Tidak
                        </td>
                    </tr>
                </table>

            </td>
        </tr>

        @if ($dischargePlanning->kesimpulan_planing)
            <div style="margin-top:5px;border:1px solid #000;padding:5px;">
                <strong>Kesimpulan:</strong><br>
                {{ $dischargePlanning->kesimpulan_planing }}
            </div>
        @endif

    </table>
    <table border="1" class="table table-bordered" style="width:100%; border-collapse: collapse;">
        <tr class="">
            <td colspan="4" class="label" style=" font-size: 10pt;">12. DIET KHUSUS
        </tr>
        <!-- Diet Khusus -->
        <tr>
            <td style="font-weight:bold; width:25%;">Diet Khusus</td>
            <td colspan="3">
                {{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->diet_khusus ?? '....................................' }}
            </td>
        </tr>

        <!-- Pengaruh Perawatan -->
        <tr>
            <td rowspan="3" style="font-weight:bold; vertical-align:top;">Ada pengaruh perawatan terhadap</td>
            <td>
                <input type="checkbox" disabled
                    {{ in_array('pasien_keluarga', $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->pengaruh_perawatan ?? []) ? 'checked' : '' }}>
                1.
                Pasien/Keluarga
            </td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->pengaruh_ya_tidak_1 ?? '') === 'ya' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->pengaruh_ya_tidak_1 ?? '') === 'tidak' ? 'checked' : '' }}>
                Tidak
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" disabled
                    {{ in_array('pekerjaan', $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->pengaruh_perawatan ?? []) ? 'checked' : '' }}>
                2.
                Pekerjaan
            </td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->pengaruh_ya_tidak_2 ?? '') === 'ya' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->pengaruh_ya_tidak_2 ?? '') === 'tidak' ? 'checked' : '' }}>
                Tidak
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" disabled
                    {{ in_array('keuangan', $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->pengaruh_perawatan ?? []) ? 'checked' : '' }}>
                3.
                Keuangan
            </td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->pengaruh_ya_tidak_3 ?? '') === 'ya' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->pengaruh_ya_tidak_3 ?? '') === 'tidak' ? 'checked' : '' }}>
                Tidak
            </td>
        </tr>

        <!-- Hidup Sendiri -->
        <tr>
            <td style="font-weight:bold;">Hidup/Tinggal sendiri?</td>
            <td colspan="3">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->hidup_sendiri ?? '') === '1' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->hidup_sendiri ?? '') === '0' ? 'checked' : '' }}>
                Tidak
            </td>
        </tr>

        <!-- Antisipasi Masalah -->
        <tr>
            <td style="font-weight:bold;">Antisipasi terhadap masalah saat pulang</td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->antisipasi_masalah ?? '') === '1' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->antisipasi_masalah ?? '') === '0' ? 'checked' : '' }}>
                Tidak
            </td>
            <td>{{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->antisipasi_jelaskan ?? '....................................' }}
            </td>
        </tr>

        <!-- Memerlukan Bantuan -->
        <tr>
            <td style="font-weight:bold;">Memerlukan bantuan dalam hal</td>
            <td colspan="3">
                @foreach (['makan_minum' => 'Makan/Minum', 'konsumsi_obat' => 'Konsumsi obat', 'berpakaian' => 'Berpakaian', 'perawatan_luka' => 'Perawatan luka', 'mandi_berpakaian' => 'Mandi & Berpakaian', 'menyiapkan_makanan' => 'Menyiapkan makanan', 'edukasi_kesehatan' => 'Edukasi Kesehatan', 'lainnya' => 'Lainnya'] as $key => $label)
                    <input type="checkbox" disabled
                        {{ in_array($key, $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->bantuan_hal ?? []) ? 'checked' : '' }}>
                    {{ $label }}
                    &nbsp;
                @endforeach
                <br>
                {{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->bantuan_lainnya ?? '' }}
            </td>
        </tr>

        <!-- Peralatan Medis -->
        <tr>
            <td style="font-weight:bold;">Peralatan medis di rumah</td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->peralatan_medis ?? '') === '1' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->peralatan_medis ?? '') === '0' ? 'checked' : '' }}>
                Tidak
            </td>
            <td>{{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->peralatan_jelaskan ?? '....................................' }}
            </td>
        </tr>

        <!-- Alat Bantu -->
        <tr>
            <td style="font-weight:bold;">Memerlukan alat bantu</td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->alat_bantu ?? '') === '1' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->alat_bantu ?? '') === '0' ? 'checked' : '' }}>
                Tidak
            </td>
            <td>{{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->alat_bantu_jelaskan ?? '....................................' }}
            </td>
        </tr>

        <!-- Perawatan Khusus -->
        <tr>
            <td style="font-weight:bold;">Perawatan khusus</td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->perawatan_khusus ?? '') === '1' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->perawatan_khusus ?? '') === '0' ? 'checked' : '' }}>
                Tidak
            </td>
            <td>{{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->perawatan_khusus_jelaskan ?? '....................................' }}
            </td>
        </tr>

        <!-- Nyeri Kronis -->
        <tr>
            <td style="font-weight:bold;">Nyeri kronis / kelelahan</td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->nyeri_kronis ?? '') === '1' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->nyeri_kronis ?? '') === '0' ? 'checked' : '' }}>
                Tidak
            </td>
            <td>{{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->nyeri_kronis_jelaskan ?? '....................................' }}
            </td>
        </tr>

        <!-- Keterampilan Khusus -->
        <tr>
            <td style="font-weight:bold;">Keterampilan khusus pasien/keluarga</td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->keterampilan_khusus ?? '') === '1' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->keterampilan_khusus ?? '') === '0' ? 'checked' : '' }}>
                Tidak
            </td>
            <td>{{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->keterampilan_jelaskan ?? '....................................' }}
            </td>
        </tr>

        <!-- Dirujuk Komunitas -->
        <tr>
            <td style="font-weight:bold;">Dirujuk ke komunitas</td>
            <td colspan="2">
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->dirujuk_komunitas ?? '') === '1' ? 'checked' : '' }}>
                Ya
                <input type="checkbox" disabled
                    {{ ($asesmen->asesmen_ket_dewasa_ranap_diet_khusus->dirujuk_komunitas ?? '') === '0' ? 'checked' : '' }}>
                Tidak
            </td>
            <td>{{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->dirujuk_jelaskan ?? '....................................' }}
            </td>
        </tr>

        <!-- Catatan Khusus -->
        <tr>
            <td style="font-weight:bold;">Catatan Khusus</td>
            <td colspan="3">
                {{ $asesmen->asesmen_ket_dewasa_ranap_diet_khusus->catatan_khusus_diet ?? '....................................' }}
            </td>
        </tr>
    </table>
    <table class="page-break table table-bordered">
        <thead class="table-primary">
            <tr>
                <th width="50%">DIAGNOSA KEPERAWATAN</th>
                <th width="50%">RENCANA KEPERAWATAN</th>
            </tr>
        </thead>
        {{-- @php
        dd($asesmen)
        @endphp --}}
        <tbody>
            <!-- 1. Bersihan Jalan Nafas Tidak Efektif -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input rencana-perawatan-row-1" type="checkbox" name="diagnosis[]"
                            value="bersihan_jalan_nafas" id="diag_bersihan_jalan_nafas"
                            onchange="toggleRencana('bersihan_jalan_nafas')"
                            {{ in_array('bersihan_jalan_nafas', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_bersihan_jalan_nafas">
                            <strong>Bersihan jalan nafas tidak efektif</strong> berhubungan dengan spasme jalan nafas...
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input rencana-perawatan-row-1" type="checkbox" name="diagnosis[]"
                            value="risiko_aspirasi" id="diag_risiko_aspirasi"
                            onchange="toggleRencana('risiko_aspirasi')"
                            {{ in_array('risiko_aspirasi', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_risiko_aspirasi">
                            <strong>Risiko aspirasi</strong> berhubungan dengan tingkat kesadaran...
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input rencana-perawatan-row-1" type="checkbox" name="diagnosis[]"
                            value="pola_nafas_tidak_efektif" id="diag_pola_nafas_tidak_efektif"
                            onchange="toggleRencana('pola_nafas_tidak_efektif')"
                            {{ in_array('pola_nafas_tidak_efektif', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_pola_nafas_tidak_efektif">
                            <strong>Pola nafas tidak efektif</strong> berhubungan dengan depresi pusat pernafasan...
                        </label>
                    </div>
                </td>

                <td class="align-top">
                    <div id="rencana_bersihan_jalan_nafas">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="monitor_pola_nafas"
                                {{ in_array('monitor_pola_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor pola nafas ( frekuensi , kedalaman, usaha nafas
                                )</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="monitor_bunyi_nafas"
                                {{ in_array('monitor_bunyi_nafas', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor bunyi nafas tambahan ( mengi, wheezing, rhonchi
                                )</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="monitor_sputum"
                                {{ in_array('monitor_sputum', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor sputum ( jumlah, warna, aroma )</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="monitor_tingkat_kesadaran"
                                {{ in_array('monitor_tingkat_kesadaran', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor tingkat kesadaran, batuk, muntah dan kemampuan
                                menelan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="monitor_kemampuan_batuk"
                                {{ in_array('monitor_kemampuan_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor kemampuan batuk efektif</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="pertahankan_kepatenan"
                                {{ in_array('pertahankan_kepatenan', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pertahankan kepatenan jalan nafas dengan head-tilt dan
                                chin
                                -lift ( jaw – thrust jika curiga trauma servikal ) </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="posisikan_semi_fowler"
                                {{ in_array('posisikan_semi_fowler', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Posisikan semi fowler atau fowler</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="berikan_minum_hangat"
                                {{ in_array('berikan_minum_hangat', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan minum hangat</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="fisioterapi_dada"
                                {{ in_array('fisioterapi_dada', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Lakukan fisioterapi dada, jika perlu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="keluarkan_benda_padat"
                                {{ in_array('keluarkan_benda_padat', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Keluarkan benda padat dengan forcep</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="penghisapan_lendir"
                                {{ in_array('penghisapan_lendir', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Lakukan penghisapan lendir</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="berikan_oksigen"
                                {{ in_array('berikan_oksigen', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan oksigen</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="anjuran_asupan_cairan"
                                {{ in_array('anjuran_asupan_cairan', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjuran asupan cairan 2000 ml/hari, jika tidak kontra
                                indikasi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="ajarkan_teknik_batuk"
                                {{ in_array('ajarkan_teknik_batuk', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan teknik batuk efektif</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_bersihan_jalan_nafas[]"
                                value="kolaborasi_pemberian_obat"
                                {{ in_array('kolaborasi_pemberian_obat', old('rencana_bersihan_jalan_nafas', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_bersihan_jalan_nafas ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kolaborasi pemberian bronkodilator, ekspektoran,
                                mukolitik,
                                jika perlu</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 2. Penurunan Curah Jantung -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]"
                            value="penurunan_curah_jantung" id="diag_penurunan_curah_jantung"
                            onchange="toggleRencana('penurunan_curah_jantung')"
                            {{ in_array('penurunan_curah_jantung', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}
                            onchange="toggleRencana('diag_penurunan_curah_jantung')">
                        <label class="form-check-label" for="diag_penurunan_curah_jantung">
                            <strong>Penurunan curah jantung</strong> berhubungan dengan perubahan irama jantung,
                            perubahan frekuensi jantung.
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_penurunan_curah_jantung">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="identifikasi_tanda_gejala"
                                {{ in_array('identifikasi_tanda_gejala', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi tanda/gejala primer penurunan curah jantung
                                (meliputi dipsnea, kelelahan, edema)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="monitor_tekanan_darah"
                                {{ in_array('monitor_tekanan_darah', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor tekanan darah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="monitor_intake_output"
                                {{ in_array('monitor_intake_output', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor intake dan output cairan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="monitor_saturasi_oksigen"
                                {{ in_array('monitor_saturasi_oksigen', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor saturasi oksigen</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="monitor_keluhan_nyeri"
                                {{ in_array('monitor_keluhan_nyeri', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor keluhan nyeri dada (intensitas, lokasi, durasi,
                                presivitasi yang mengurangi nyeri)</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="monitor_aritmia"
                                {{ in_array('monitor_aritmia', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor aritmia (kelainan irama dan frekuensi)</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="posisikan_pasien"
                                {{ in_array('posisikan_pasien', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Posisikan pasien semi fowler atau fowler dengan kaki
                                kebawah
                                atau posisi nyaman</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="berikan_terapi_relaksasi"
                                {{ in_array('berikan_terapi_relaksasi', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan therapi relaksasi untuk mengurangi stres, jika
                                perlu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="berikan_dukungan_emosional"
                                {{ in_array('berikan_dukungan_emosional', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan dukungan emosional dan spirital</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="berikan_oksigen_saturasi"
                                {{ in_array('berikan_oksigen_saturasi', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan oksigen untuk mempertahankan saturasi oksigen
                                >94%</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="anjurkan_beraktifitas"
                                {{ in_array('anjurkan_beraktifitas', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan beraktifitas fisik sesuai toleransi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="anjurkan_berhenti_merokok"
                                {{ in_array('anjurkan_berhenti_merokok', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan berhenti merokok</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="ajarkan_mengukur_intake"
                                {{ in_array('ajarkan_mengukur_intake', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan pasien dan keluarga mengukur intake dan output
                                cairan harian</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_penurunan_curah_jantung[]" value="kolaborasi_pemberian_terapi"
                                {{ in_array('kolaborasi_pemberian_terapi', old('rencana_penurunan_curah_jantung', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_penurunan_curah_jantung ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Koborasi pemberian therapi</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 3. Perfusi Perifer Tidak Efektif -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]"
                            value="perfusi_perifer" id="diag_perfusi_perifer"
                            onchange="toggleRencana('perfusi_perifer')"
                            {{ in_array('perfusi_perifer', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_perfusi_perifer">
                            <strong>Perfusi perifer tidak efektif</strong> berhubungan dengan hyperglikemia, penurunan
                            konsentrasi hemoglobin, peningkatan tekanan darah, kekurangan volume cairan, penurunan
                            aliran arteri dan/atau vena, kurang terpapar informasi tentang proses penyakit (misal:
                            diabetes melitus, hiperlipidmia).
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_perfusi_perifer">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="periksa_sirkulasi"
                                {{ in_array('periksa_sirkulasi', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Periksa sirkulasi perifer (edema, pengisian kapiler/CRT,
                                suhu)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="identifikasi_faktor_risiko"
                                {{ in_array('identifikasi_faktor_risiko', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi faktor risiko gangguan sirkulasi (diabetes,
                                perokok, hipertensi, kadar kolesterol tinggi)</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="monitor_suhu_kemerahan"
                                {{ in_array('monitor_suhu_kemerahan', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor suhu, kemerahan, nyeri atau bengkak pada
                                ekstremitas.</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="hindari_pemasangan_infus"
                                {{ in_array('hindari_pemasangan_infus', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Hindari pemasangan infus atau pengambilan darah di area
                                keterbatasan perfusi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="hindari_pengukuran_tekanan"
                                {{ in_array('hindari_pengukuran_tekanan', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Hindari pengukuran tekanan darah pada ekstremitas dengan
                                keterbatasan perfusi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="hindari_penekanan"
                                {{ in_array('hindari_penekanan', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Hindari penekanan dan pemasangan tourniqet pada area yang
                                cedera</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="lakukan_pencegahan_infeksi"
                                {{ in_array('lakukan_pencegahan_infeksi', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Lakukan pencegahan infeksi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="perawatan_kaki_kuku"
                                {{ in_array('perawatan_kaki_kuku', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Lakukan perawatan kaki dan kuku</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="anjurkan_berhenti_merokok_perfusi"
                                {{ in_array('anjurkan_berhenti_merokok_perfusi', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan berhenti merokok</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="anjurkan_berolahraga"
                                {{ in_array('anjurkan_berolahraga', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan berolahraga rutin</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="anjurkan_minum_obat"
                                {{ in_array('anjurkan_minum_obat', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan minum obat pengontrol tekanan darah secara
                                teratur</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_perfusi_perifer[]"
                                value="kolaborasi_terapi_perfusi"
                                {{ in_array('kolaborasi_terapi_perfusi', old('rencana_perfusi_perifer', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_perfusi_perifer ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Koborasi pemberian therapi</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 4. Hipovolemia -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipovolemia"
                            id="diag_hipovolemia" onchange="toggleRencana('hipovolemia')"
                            {{ in_array('hipovolemia', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_hipovolemia">
                            <strong>Hipovolemia</strong> berhubungan dengan kehilangan cairan aktif, peningkatan
                            permeabilitas kapiler, kekurangan intake cairan, evaporasi.
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_hipovolemia">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]"
                                value="periksa_tanda_gejala"
                                {{ in_array('periksa_tanda_gejala', old('rencana_hipovolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Periksa tanda dan gejala hipovolemia (frekuensi nadi
                                meningkat, nadi teraba lemah, tekanan darah penurun, turgor kulit menurun, membran
                                mukosa kering, volume urine menurun, haus, lemah)</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]"
                                value="monitor_intake_output_hipovolemia"
                                {{ in_array('monitor_intake_output_hipovolemia', old('rencana_hipovolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor intake dan output cairan</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]"
                                value="berikan_asupan_cairan"
                                {{ in_array('berikan_asupan_cairan', old('rencana_hipovolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan asupan cairan oral</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]"
                                value="posisi_trendelenburg"
                                {{ in_array('posisi_trendelenburg', old('rencana_hipovolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Posisi modified trendelenburg</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]"
                                value="anjurkan_memperbanyak_cairan"
                                {{ in_array('anjurkan_memperbanyak_cairan', old('rencana_hipovolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan memperbanyak asupan cairan oral</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]"
                                value="hindari_perubahan_posisi"
                                {{ in_array('hindari_perubahan_posisi', old('rencana_hipovolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan menghindari perubahan posisi mendadak</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipovolemia[]"
                                value="kolaborasi_terapi_hipovolemia"
                                {{ in_array('kolaborasi_terapi_hipovolemia', old('rencana_hipovolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipovolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Koborasi pemberian therapi</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 5. Hipervolemia -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipervolemia"
                            id="diag_hipervolemia" onchange="toggleRencana('hipervolemia')"
                            {{ in_array('hipervolemia', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_hipervolemia">
                            <strong>Hipervolemia</strong> berhubungan dengan kelebihan asupan cairan, kelebihan asupan
                            natrium, gangguan aliran balik vena.
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_hipervolemia">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="periksa_tanda_hipervolemia"
                                {{ in_array('periksa_tanda_hipervolemia', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Periksa tanda dan gejala hipervolemia (dipsnea, edema,
                                suara
                                nafas tambahan)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="identifikasi_penyebab_hipervolemia"
                                {{ in_array('identifikasi_penyebab_hipervolemia', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi penyebab hipervolemia</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="monitor_hemodinamik"
                                {{ in_array('monitor_hemodinamik', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor status hemodinamik (frekuensi jantung, tekanan
                                darah)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="monitor_intake_output_hipervolemia"
                                {{ in_array('monitor_intake_output_hipervolemia', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor intake dan output cairan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="monitor_efek_diuretik"
                                {{ in_array('monitor_efek_diuretik', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor efek samping diuretik (hipotensi ortostatik,
                                hipovolemia, hipokalemia, hiponatremia)</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="timbang_berat_badan"
                                {{ in_array('timbang_berat_badan', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Timbang berat badan setiap hari pada waktu yang
                                sama</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="batasi_asupan_cairan"
                                {{ in_array('batasi_asupan_cairan', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Batasi asupan cairan dan garam</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="tinggi_kepala_tempat_tidur"
                                {{ in_array('tinggi_kepala_tempat_tidur', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Tinggi kepala tempat tidur 30 – 40 º</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="ajarkan_mengukur_cairan"
                                {{ in_array('ajarkan_mengukur_cairan', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan cara mengukur dan mencatat asupan dan haluaran
                                cairan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="ajarkan_membatasi_cairan"
                                {{ in_array('ajarkan_membatasi_cairan', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan cara membatasi cairan</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipervolemia[]"
                                value="kolaborasi_terapi_hipervolemia"
                                {{ in_array('kolaborasi_terapi_hipervolemia', old('rencana_hipervolemia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipervolemia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Koborasi pemberian therapi</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 6. Diare -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]" value="diare"
                            id="diag_diare" onchange="toggleRencana('diare')"
                            {{ in_array('diare', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_diare">
                            <strong>Diare</strong> berhubungan dengan inflamasi gastrointestinal, iritasi
                            gastrointestinal, proses infeksi, malabsorpsi.
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_diare">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="identifikasi_penyebab_diare"
                                {{ in_array('identifikasi_penyebab_diare', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi penyebab diare (inflamasi gastrointestinal,
                                iritasi gastrointestinal, proses infeksi, malabsorpsi, ansietas, stres, efek samping
                                obat)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="identifikasi_riwayat_makanan"
                                {{ in_array('identifikasi_riwayat_makanan', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi riwayat pemberian makanan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="identifikasi_gejala_invaginasi"
                                {{ in_array('identifikasi_gejala_invaginasi', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi riwayat gejala invaginasi (tangisan keras,
                                kepucatan pada bayi)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="monitor_warna_volume_tinja"
                                {{ in_array('monitor_warna_volume_tinja', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor warna, volume, frekuensi dan konsistensi
                                tinja</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="monitor_tanda_hipovolemia"
                                {{ in_array('monitor_tanda_hipovolemia', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor tanda dan gejala hipovolemia (takikardi, nadi
                                teraba
                                lemah, tekanan darah turun, turgor kulit turun, mukosa mulit kering, CRT melambat, BB
                                menurun)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="monitor_iritasi_kulit"
                                {{ in_array('monitor_iritasi_kulit', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor iritasi dan ulserasi kulit di daerah
                                perianal</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="monitor_jumlah_diare"
                                {{ in_array('monitor_jumlah_diare', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor jumlah pengeluaran diare</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="berikan_asupan_cairan_oral"
                                {{ in_array('berikan_asupan_cairan_oral', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan asupan cairan oral (larutan garam gula, oralit,
                                pedialyte)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="pasang_jalur_intravena"
                                {{ in_array('pasang_jalur_intravena', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pasang jalur intravena</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="berikan_cairan_intravena"
                                {{ in_array('berikan_cairan_intravena', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan cairan intravena</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="anjurkan_makanan_porsi_kecil"
                                {{ in_array('anjurkan_makanan_porsi_kecil', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan makanan porsi kecil dan sering secara
                                bertahap</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="hindari_makanan_gas"
                                {{ in_array('hindari_makanan_gas', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan menghindari makanan pembentuk gas, pedas dan
                                mengandung laktosa</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="lanjutkan_asi"
                                {{ in_array('lanjutkan_asi', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan melanjutkan pemberian ASI</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_diare[]"
                                value="kolaborasi_terapi_diare"
                                {{ in_array('kolaborasi_terapi_diare', old('rencana_diare', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_diare ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Koborasi pemberian therapi</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 7. Retensi Urine -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]" value="retensi_urine"
                            id="diag_retensi_urine" onchange="toggleRencana('retensi_urine')"
                            {{ in_array('retensi_urine', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_retensi_urine">
                            <strong>Retensi urine</strong> berhubungan dengan peningkatan tekanan uretra, kerusakan
                            arkus refleks, Blok spingter, disfungsi neurologis (trauma, penyakit saraf), efek agen
                            farmakologis (atropine, belladona, psikotropik, antihistamin, opiate).
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_retensi_urine">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="identifikasi_tanda_retensi"
                                {{ in_array('identifikasi_tanda_retensi', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi tanda dan gejala retensi atau inkontinensia
                                urine</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="identifikasi_faktor_penyebab"
                                {{ in_array('identifikasi_faktor_penyebab', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi faktor yang menyebabkan retensi atau
                                inkontinensia urine</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="monitor_eliminasi_urine"
                                {{ in_array('monitor_eliminasi_urine', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor eliminasi urine (frekuensi, konsistensi, aroma,
                                volume dan warna)</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="catat_waktu_berkemih"
                                {{ in_array('catat_waktu_berkemih', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Catat waktu-waktu dan haluaran berkemih</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="batasi_asupan_cairan"
                                {{ in_array('batasi_asupan_cairan', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Batasi asupan cairan, jika perlu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="ambil_sampel_urine"
                                {{ in_array('ambil_sampel_urine', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ambil sampel urine tengah (midstream) atau kultur</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="ajarkan_tanda_infeksi"
                                {{ in_array('ajarkan_tanda_infeksi', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan tanda dan gejala infeksi saluran kemih</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="ajarkan_mengukur_asupan"
                                {{ in_array('ajarkan_mengukur_asupan', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan mengukur asupan cairan dan haluaran urine</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="ajarkan_spesimen_midstream"
                                {{ in_array('ajarkan_spesimen_midstream', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan mengambil spesimen urine midstream</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="ajarkan_tanda_berkemih"
                                {{ in_array('ajarkan_tanda_berkemih', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan mengenali tanda berkemih dan waktu yang tepat
                                untuk
                                berkemih</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="ajarkan_minum_cukup"
                                {{ in_array('ajarkan_minum_cukup', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan minum yang cukup, jika tidak ada
                                kontraindikasi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="kurangi_minum_tidur"
                                {{ in_array('kurangi_minum_tidur', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan mengurangi minum menjelang tidur</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_retensi_urine[]"
                                value="kolaborasi_supositoria"
                                {{ in_array('kolaborasi_supositoria', old('rencana_retensi_urine', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_retensi_urine ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kolaborasi pemberian obat supositoria uretra, jika
                                perlu</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 8. Nyeri Akut -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]" value="nyeri_akut"
                            id="diag_nyeri_akut" onchange="toggleRencana('nyeri_akut')"
                            {{ in_array('nyeri_akut', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_nyeri_akut">
                            <strong>Nyeri akut</strong> b.d agen pencedera fisiologis (inflamsi, iskemia, neoplasma),
                            agen pencedera kimiawi (terbakar, bahan kimia iritan), agen pencedera fisik (abses,
                            amputasi, terbakar, terpotong, mengangkat berat, prosedur operasi, trauma, latihan fisik
                            berlebihan).
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_nyeri_akut">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="identifikasi_lokasi_nyeri"
                                {{ in_array('identifikasi_lokasi_nyeri', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi,
                                kualitas, intensitas nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="identifikasi_skala_nyeri"
                                {{ in_array('identifikasi_skala_nyeri', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi skala nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="identifikasi_respons_nonverbal"
                                {{ in_array('identifikasi_respons_nonverbal', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="identifikasi_faktor_nyeri"
                                {{ in_array('identifikasi_faktor_nyeri', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan
                                nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="identifikasi_pengetahuan_nyeri"
                                {{ in_array('identifikasi_pengetahuan_nyeri', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang
                                nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="identifikasi_pengaruh_budaya"
                                {{ in_array('identifikasi_pengaruh_budaya', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="identifikasi_pengaruh_kualitas_hidup"
                                {{ in_array('identifikasi_pengaruh_kualitas_hidup', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="monitor_keberhasilan_terapi"
                                {{ in_array('monitor_keberhasilan_terapi', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah
                                diberikan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="monitor_efek_samping_analgetik"
                                {{ in_array('monitor_efek_samping_analgetik', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="berikan_teknik_nonfarmakologis"
                                {{ in_array('berikan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri
                                (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik
                                imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="kontrol_lingkungan_nyeri"
                                {{ in_array('kontrol_lingkungan_nyeri', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu
                                ruangan, pencahayaan, kebisingan)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="fasilitasi_istirahat"
                                {{ in_array('fasilitasi_istirahat', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="pertimbangkan_strategi_nyeri"
                                {{ in_array('pertimbangkan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan
                                strategi meredakan nyeri</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="jelaskan_penyebab_nyeri"
                                {{ in_array('jelaskan_penyebab_nyeri', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="jelaskan_strategi_nyeri"
                                {{ in_array('jelaskan_strategi_nyeri', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="anjurkan_monitor_nyeri"
                                {{ in_array('anjurkan_monitor_nyeri', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="anjurkan_analgetik"
                                {{ in_array('anjurkan_analgetik', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="ajarkan_teknik_nonfarmakologis"
                                {{ in_array('ajarkan_teknik_nonfarmakologis', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa
                                nyeri</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_akut[]"
                                value="kolaborasi_analgetik"
                                {{ in_array('kolaborasi_analgetik', old('rencana_nyeri_akut', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_akut ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kolaborasi pemberian analgetik, jika perlu</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 9. Nyeri Kronis -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]" value="nyeri_kronis"
                            id="diag_nyeri_kronis" onchange="toggleRencana('nyeri_kronis')"
                            {{ in_array('nyeri_kronis', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_nyeri_kronis">
                            <strong>Nyeri kronis</strong> b.d kondisi muskuloskeletal kronis, kerusakan sistem saraf,
                            penekanan saraf, infiltrasi tumor, ketidakseimbangan neurotransmiter, neuromodulator, dan
                            reseptor, gangguan imunitas, (neuropati terkait HIV, virus varicella-zoster), gangguan
                            fungsi metabolik, riwayat posisi kerja statis, peningkatan indeks masa tubuh, kondisi pasca
                            trauma, tekanan emosional, riwayat penganiayaan (fisik, psikologis, seksual), riwayat
                            penyalahgunaan obat/zat.
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_nyeri_kronis">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="identifikasi_lokasi_nyeri_kronis"
                                {{ in_array('identifikasi_lokasi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi lokasi, karakteristik, durasi, frekuensi,
                                kualitas, intensitas nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="identifikasi_skala_nyeri_kronis"
                                {{ in_array('identifikasi_skala_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi skala nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="identifikasi_respons_nonverbal_kronis"
                                {{ in_array('identifikasi_respons_nonverbal_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi respons nyeri non verbal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="identifikasi_faktor_nyeri_kronis"
                                {{ in_array('identifikasi_faktor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi faktor yang memperberat dan memperingan
                                nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="identifikasi_pengetahuan_nyeri_kronis"
                                {{ in_array('identifikasi_pengetahuan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi pengetahuan dan keyaninan tentang
                                nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="identifikasi_pengaruh_budaya_kronis"
                                {{ in_array('identifikasi_pengaruh_budaya_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi pengaruh budaya terhadap respon nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="identifikasi_pengaruh_kualitas_hidup_kronis"
                                {{ in_array('identifikasi_pengaruh_kualitas_hidup_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi pengaruh nyeri pada kualitas hidup</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="monitor_keberhasilan_terapi_kronis"
                                {{ in_array('monitor_keberhasilan_terapi_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor keberhasilan terapi komplementer yang sudah
                                diberikan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="monitor_efek_samping_analgetik_kronis"
                                {{ in_array('monitor_efek_samping_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor efek samping penggunaan analgetil</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="berikan_teknik_nonfarmakologis_kronis"
                                {{ in_array('berikan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan teknik nonfarmakologis untuk mengurangi rasa nyeri
                                (TENS, hipnosis, akupresur, terapi musik, biofeedback, terapi pijat, aromaterapi, teknik
                                imajinasi terbimbing, kompres hangat/dingin, terapi bermain)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="kontrol_lingkungan_nyeri_kronis"
                                {{ in_array('kontrol_lingkungan_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kontrol lingkungan yang memperberat rasa nyeri (suhu
                                ruangan, pencahayaan, kebisingan)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="fasilitasi_istirahat_kronis"
                                {{ in_array('fasilitasi_istirahat_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Fasilitasi istirahat dan tidur</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="pertimbangkan_strategi_nyeri_kronis"
                                {{ in_array('pertimbangkan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pertimbangkan jenis dan sumber nyeri dalam pemilihan
                                strategi meredakan nyeri</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="jelaskan_penyebab_nyeri_kronis"
                                {{ in_array('jelaskan_penyebab_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Jelaskan penyebab, periode, dan pemicu nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="jelaskan_strategi_nyeri_kronis"
                                {{ in_array('jelaskan_strategi_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Jelaskan strategi meredakan nyeri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="anjurkan_monitor_nyeri_kronis"
                                {{ in_array('anjurkan_monitor_nyeri_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan memonitor nyeri secara mandiri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="anjurkan_analgetik_kronis"
                                {{ in_array('anjurkan_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan menggunakan analgetik secara tepat</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="ajarkan_teknik_nonfarmakologis_kronis"
                                {{ in_array('ajarkan_teknik_nonfarmakologis_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan teknik nonfarmakologis untuk mengurangin rasa
                                nyeri</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_nyeri_kronis[]"
                                value="kolaborasi_analgetik_kronis"
                                {{ in_array('kolaborasi_analgetik_kronis', old('rencana_nyeri_kronis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_nyeri_kronis ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kolaborasi pemberian analgetik, jika perlu</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 10. Hipertermia -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]" value="hipertermia"
                            id="diag_hipertermia" onchange="toggleRencana('hipertermia')"
                            {{ in_array('hipertermia', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_hipertermia">
                            <strong>Hipertermia</strong> b.d dehidrasi, terpapar lingkungan panas, peroses penyakit
                            (infeksi, kanker), ketidaksesuaian pakaian dengan suhu lingkungan, peningkatan laju
                            metabolisme, respon trauma, aktivitas berlebihan, penggunaan inkubator.
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_hipertermia">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="identifikasi_penyebab_hipertermia"
                                {{ in_array('identifikasi_penyebab_hipertermia', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi penyebab hipertermia (dehidrasi, terpapar
                                lingkungan panas, penggunaan inkubator)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="monitor_suhu_tubuh"
                                {{ in_array('monitor_suhu_tubuh', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor suhu tubuh</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="monitor_kadar_elektrolit"
                                {{ in_array('monitor_kadar_elektrolit', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor kadar elektrolit</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="monitor_haluaran_urine"
                                {{ in_array('monitor_haluaran_urine', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor haluaran urine</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="monitor_komplikasi_hipertermia"
                                {{ in_array('monitor_komplikasi_hipertermia', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor komplikasi akibat hipertermia</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="sediakan_lingkungan_dingin"
                                {{ in_array('sediakan_lingkungan_dingin', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Sediakan lingkungan yang dingin</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="longgarkan_pakaian"
                                {{ in_array('longgarkan_pakaian', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Longgarkan atau lepaskan pakaian</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="basahi_kipasi_tubuh"
                                {{ in_array('basahi_kipasi_tubuh', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Basahi dan kipasi permukaan tubuh</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="berikan_cairan_oral_hipertermia"
                                {{ in_array('berikan_cairan_oral_hipertermia', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan cairan oral</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="ganti_linen_hiperhidrosis"
                                {{ in_array('ganti_linen_hiperhidrosis', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ganti linen setiap hari atau lebih sering jika mengalami
                                hiperhidrosis (keringat berlebih)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="pendinginan_eksternal"
                                {{ in_array('pendinginan_eksternal', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Lakukan pendinginan eksternal (selimut hipotermia atau
                                kompres dingin pada dahi, leher, dada, abdomen, aksila)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="hindari_antipiretik"
                                {{ in_array('hindari_antipiretik', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Hindari pemberian antipiretik atau aspirin</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="berikan_oksigen_hipertermia"
                                {{ in_array('berikan_oksigen_hipertermia', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan oksigen, jika perlu</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="anjurkan_tirah_baring"
                                {{ in_array('anjurkan_tirah_baring', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan tirah baring</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_hipertermia[]"
                                value="kolaborasi_cairan_elektrolit"
                                {{ in_array('kolaborasi_cairan_elektrolit', old('rencana_hipertermia', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_hipertermia ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kolaborasi pemberian cairan dan elektrolit intravena, jika
                                perlu</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 11. Gangguan Mobilitas Fisik -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]"
                            value="gangguan_mobilitas_fisik" id="diag_gangguan_mobilitas_fisik"
                            onchange="toggleRencana('gangguan_mobilitas_fisik')"
                            {{ in_array('gangguan_mobilitas_fisik', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_gangguan_mobilitas_fisik">
                            <strong>Gangguan mobilitas fisik</strong> b.d kerusakan intergritas struktur tulang,
                            perubahan metabolisme, ketidakbugaran fisik, penurunan kendali otot, penurunan massa otot,
                            penurunan kekuatan otot, keterlambatan perkembangan, kekakuan sendi, kontraktur, malnutrisi,
                            gangguan muskuloskeletal, gangguan neuromuskular, indeks masa tubuh diatas persentil ke-75
                            seusai usia, efek agen farmakologis, program pembatasan gerak, nyeri, kurang terpapar
                            informasi tentang aktivitas fisik, kecemasan, gangguan kognitif, keengganan melakukan
                            pergerakan, gangguan sensoripersepsi.
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_gangguan_mobilitas_fisik">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="identifikasi_nyeri_keluhan"
                                {{ in_array('identifikasi_nyeri_keluhan', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Indentifikasi adanya nyeri atau keluhan fisik
                                lainnya</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="identifikasi_toleransi_ambulasi"
                                {{ in_array('identifikasi_toleransi_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Indetifikasi toleransi fisik melakukan ambulasi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="monitor_frekuensi_jantung_ambulasi"
                                {{ in_array('monitor_frekuensi_jantung_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor frekuensi jantung dan tekanan darah sebelum
                                memulai
                                ambulasi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="monitor_kondisi_umum_ambulasi"
                                {{ in_array('monitor_kondisi_umum_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor kondiri umum selama melakukan ambulasi</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_aktivitas_ambulasi"
                                {{ in_array('fasilitasi_aktivitas_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Fasilitasi aktivitas ambulasi dengan alat bantu (tongkat,
                                kruk)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="fasilitasi_mobilisasi_fisik"
                                {{ in_array('fasilitasi_mobilisasi_fisik', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Fasilitasi melakukan mobilisasi fisik, jika perlu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="libatkan_keluarga_ambulasi"
                                {{ in_array('libatkan_keluarga_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Libatkan keluarga untuk membantu pasien dalam meningkatkan
                                ambulasi</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="jelaskan_tujuan_ambulasi"
                                {{ in_array('jelaskan_tujuan_ambulasi', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Jelaskan tujuan dan prosedur ambulasi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="anjurkan_ambulasi_dini"
                                {{ in_array('anjurkan_ambulasi_dini', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan melakukan ambulasi dini</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_mobilitas_fisik[]" value="ajarkan_ambulasi_sederhana"
                                {{ in_array('ajarkan_ambulasi_sederhana', old('rencana_gangguan_mobilitas_fisik', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_mobilitas_fisik ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan ambulasi sederhana yang harus dilakukan (berjalan
                                dari tempat tidur ke kursi roda, berjalan dari tempat tidur ke kamar mandi, berjalan
                                sesuai toleransi)</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 12. Resiko Infeksi -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]"
                            value="resiko_infeksi" id="diag_resiko_infeksi"
                            onchange="toggleRencana('resiko_infeksi')"
                            {{ in_array('resiko_infeksi', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_resiko_infeksi">
                            <strong>Resiko infeksi</strong> b.d efek prosedur invasif, penyakit kronis (diabetes
                            melitus), malnutrisi, peningkatan paparan organisme patogen lingkungan, ketidakadekuatan
                            pertahanan tubuh primer (gangguan persitaltik, kerusakan integritas kulit, perubahan sekresi
                            PH, penurunan kerja siliaris, ketuban pecah lama, ketuban pecah sebelum waktunya, merokok,
                            statis cairan tubuh), ketidakadekuatan pertahanan tubuh sekunder (penurunan hemoglobin,
                            imununosupresi, leukopenia, supresi respon inflamasi, vaksinasi tidak adekuat).
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_resiko_infeksi">
                        <strong>Observasi:</strong>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="monitor_tanda_infeksi_sistemik"
                                {{ in_array('monitor_tanda_infeksi_sistemik', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor tanda dan gejala infeksi lokal dan
                                sistemik</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="batasi_pengunjung"
                                {{ in_array('batasi_pengunjung', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Batasi jumlah pengunjung</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="perawatan_kulit_edema"
                                {{ in_array('perawatan_kulit_edema', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan perawatan kulit pada area edema</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="cuci_tangan_kontak"
                                {{ in_array('cuci_tangan_kontak', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Cuci tangan sebelum dan sesudah kontak dengan pasien dan
                                lingkungan pasien</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="pertahankan_teknik_aseptik"
                                {{ in_array('pertahankan_teknik_aseptik', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pertahankan teknik aseptik pada pasien beresiko
                                tinggi</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="jelaskan_tanda_infeksi_edukasi"
                                {{ in_array('jelaskan_tanda_infeksi_edukasi', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="ajarkan_cuci_tangan"
                                {{ in_array('ajarkan_cuci_tangan', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan cara mencuci tangan dengan benar</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="ajarkan_etika_batuk"
                                {{ in_array('ajarkan_etika_batuk', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan etika batuk</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="ajarkan_periksa_luka"
                                {{ in_array('ajarkan_periksa_luka', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan cara memeriksa kondisi luka atau luka
                                operasi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="anjurkan_asupan_nutrisi"
                                {{ in_array('anjurkan_asupan_nutrisi', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan meningkatkan asupan nutrisi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="anjurkan_asupan_cairan_infeksi"
                                {{ in_array('anjurkan_asupan_cairan_infeksi', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan meningkatkan asupan cairan</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_infeksi[]"
                                value="kolaborasi_imunisasi"
                                {{ in_array('kolaborasi_imunisasi', old('rencana_resiko_infeksi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_infeksi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kolaborasi pemberian imunisasi, jika perlu.</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 13. Konstipasi -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]" value="konstipasi"
                            id="diag_konstipasi" onchange="toggleRencana('konstipasi')"
                            {{ in_array('konstipasi', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_konstipasi">
                            <strong>Konstipasi</strong> b.d penurunan motilitas gastrointestinal, ketidaadekuatan
                            pertumbuhan gigi, ketidakcukupan diet, ketidakcukupan asupan serat, ketidakcukupan asupan
                            serat, ketidakcukupan asupan cairan, aganglionik (penyakit Hircsprung), kelemahan otot
                            abdomen.
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_konstipasi">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="periksa_tanda_gejala_konstipasi"
                                {{ in_array('periksa_tanda_gejala_konstipasi', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Periksa tanda dan gejala</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="periksa_pergerakan_usus"
                                {{ in_array('periksa_pergerakan_usus', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Periksa pergerakan usus, karakteristik feses</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="identifikasi_faktor_risiko_konstipasi"
                                {{ in_array('identifikasi_faktor_risiko_konstipasi', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi faktor risiko konstipasi</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="anjurkan_diet_tinggi_serat"
                                {{ in_array('anjurkan_diet_tinggi_serat', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan diet tinggi serat</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="masase_abdomen"
                                {{ in_array('masase_abdomen', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Lakukan masase abdomen, jika perlu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="evakuasi_feses_manual"
                                {{ in_array('evakuasi_feses_manual', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Lakukan evakuasi feses secara manual, jika perlu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="berikan_enema"
                                {{ in_array('berikan_enema', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan enema atau intigasi, jika perlu</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="jelaskan_etiologi_konstipasi"
                                {{ in_array('jelaskan_etiologi_konstipasi', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Jelaskan etiologi masalah dan alasan tindakan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="anjurkan_peningkatan_cairan_konstipasi"
                                {{ in_array('anjurkan_peningkatan_cairan_konstipasi', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan peningkatan asupan cairan, jika tidak ada
                                kontraindikasi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="ajarkan_mengatasi_konstipasi"
                                {{ in_array('ajarkan_mengatasi_konstipasi', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan cara mengatasi konstipasi/impaksi</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_konstipasi[]"
                                value="kolaborasi_obat_pencahar"
                                {{ in_array('kolaborasi_obat_pencahar', old('rencana_konstipasi', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_konstipasi ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kolaborasi penggunaan obat pencahar, jika perlu</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 14. Resiko Jatuh -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]" value="resiko_jatuh"
                            id="diag_resiko_jatuh" onchange="toggleRencana('resiko_jatuh')"
                            {{ in_array('resiko_jatuh', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_resiko_jatuh">
                            <strong>Resiko jatuh</strong> b.d usia lebih dari sama dengan 65 tahun (pada dewasa) atau
                            kurang dari sama dengan 2 tahun (pada anak) Riwayat jatuh, anggota gerak bawah prostesis
                            (buatan), penggunaan alat bantu berjalan, penurunan tingkat kesadaran, perubahan fungsi
                            kognitif, lingkungan tidak aman (licin, gelap, lingkungan asing), kondisi pasca operasi,
                            hipotensi ortostatik, perubahan kadar glukosa darah, anemia, kekuatan otot menurun, gangguan
                            pendengaran, gangguan keseimbangan, gangguan penglihatan (glaukoma, katarak, ablasio retina,
                            neuritis optikus), neuropati, efek agen farmakologis (sedasi, alkohol, anastesi umum).
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_resiko_jatuh">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="identifikasi_faktor_risiko_jatuh"
                                {{ in_array('identifikasi_faktor_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi faktor risiko jatuh (usia >65 tahun,
                                penurunan
                                tingkat kesadaran, defisit kognitif, hipotensi ortostatik, gangguan keseimbangan,
                                gangguan penglihatan, neuropati)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="identifikasi_risiko_setiap_shift"
                                {{ in_array('identifikasi_risiko_setiap_shift', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi risiko jatuh setidaknya sekali setiap shift
                                atau sesuai dengan kebijakan institusi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="identifikasi_faktor_lingkungan"
                                {{ in_array('identifikasi_faktor_lingkungan', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Identifikasi faktor lingkungan yang meningkatkan risiko
                                jatuh (lantai licin, penerangan kurang)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="hitung_risiko_jatuh"
                                {{ in_array('hitung_risiko_jatuh', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Hitung risiko jatuh dengan menggunakan skala (Fall Morse
                                Scale, humpty dumpty scale), jika perlu</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="monitor_kemampuan_berpindah"
                                {{ in_array('monitor_kemampuan_berpindah', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor kemampuan berpindah dari tempat tidur ke kursi
                                roda
                                dan sebaliknya</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="orientasikan_ruangan"
                                {{ in_array('orientasikan_ruangan', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Orientasikan ruangan pada pasien dan keluarga</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="pastikan_roda_terkunci"
                                {{ in_array('pastikan_roda_terkunci', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pastikan roda tempat tidur dan kursi roda selalu dalam
                                kondisi terkunci</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="pasang_handrail"
                                {{ in_array('pasang_handrail', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pasang handrail tempat tidur</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="atur_tempat_tidur"
                                {{ in_array('atur_tempat_tidur', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Atur tempat tidur mekanis pada posisi terendah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="tempatkan_dekat_perawat"
                                {{ in_array('tempatkan_dekat_perawat', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Tempatkan pasien berisiko tinggi jatuh dekat dengan
                                pantauan
                                perawat dari nurse station</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="gunakan_alat_bantu"
                                {{ in_array('gunakan_alat_bantu', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Gunakan alat bantu berjalan (kursi roda, walker)</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="dekatkan_bel"
                                {{ in_array('dekatkan_bel', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Dekatkan bel pemanggil dalam jangkauan pasien</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="anjurkan_memanggil_perawat"
                                {{ in_array('anjurkan_memanggil_perawat', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan memanggil perawat jika membutuhkan bantuan untuk
                                berpindah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="anjurkan_alas_kaki"
                                {{ in_array('anjurkan_alas_kaki', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan menggunakan alas kaki yang tidak licin</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="anjurkan_berkonsentrasi"
                                {{ in_array('anjurkan_berkonsentrasi', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan berkonsentrasi untuk menjaga keseimbangan
                                tubuh</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="anjurkan_melebarkan_jarak"
                                {{ in_array('anjurkan_melebarkan_jarak', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan melebarkan jarak kedua kaki untuk meningkatkan
                                keseimbangan saat berdiri</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="rencana_resiko_jatuh[]"
                                value="ajarkan_bel_pemanggil"
                                {{ in_array('ajarkan_bel_pemanggil', old('rencana_resiko_jatuh', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_resiko_jatuh ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Ajarkan cara menggunakan bel pemanggil untuk memanggil
                                perawat</label>
                        </div>
                    </div>
                </td>
            </tr>

            <!-- 15. Gangguan Integritas Kulit/Jaringan -->
            <tr>
                <td class="align-top">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="diagnosis[]"
                            value="gangguan_integritas_kulit" id="diag_gangguan_integritas_kulit"
                            onchange="toggleRencana('gangguan_integritas_kulit')"
                            {{ in_array('gangguan_integritas_kulit', old('diagnosis', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->diagnosis ?? [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="diag_gangguan_integritas_kulit">
                            <strong>Gangguan integritas kulit/jaringan</strong> b.d perubahan sirkulasi, perubahan
                            status nutrisi (kelebihan atau kekurangan), kekurangan/kelebihan volume cairan, penurunan
                            mobilitas, bahan kimia iritatif, suhu lingkungan yang ekstream, faktor mekanis (penekanan
                            pada tonjolan tulang, gesekan) atau faktor elektris (elektrodiatermi, energi listrik
                            bertegangan tinggi), efek samping terapi radiasi, kelembapan, proses penuaan, neuropati
                            perifer, perubahan pigmentasi, perubahan hormonal, kurang terpapar informasi tentang upaya
                            mempertahankan/melindungi integritas jaringan.
                        </label>
                    </div>
                </td>
                <td class="align-top">
                    <div id="rencana_gangguan_integritas_kulit">
                        <strong>Observasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="monitor_karakteristik_luka"
                                {{ in_array('monitor_karakteristik_luka', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor karakteristik luka</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="monitor_tanda_infeksi"
                                {{ in_array('monitor_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Monitor tanda-tanda infeksi</label>
                        </div>

                        <strong>Terapeutik:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="lepaskan_balutan"
                                {{ in_array('lepaskan_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Lepaskan balutan dan plester secara perlahan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="bersihkan_nacl"
                                {{ in_array('bersihkan_nacl', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Bersihkan dengan cairan NaCl atau pembersih
                                nontoksik</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="bersihkan_jaringan_nekrotik"
                                {{ in_array('bersihkan_jaringan_nekrotik', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Bersihkan jaringan nekrotik</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="berikan_salep"
                                {{ in_array('berikan_salep', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Berikan salep yang sesuai ke kulit/lesi, jika
                                perlu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="pasang_balutan"
                                {{ in_array('pasang_balutan', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pasang balutan sesuai jenis luka</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="pertahankan_teknik_steril"
                                {{ in_array('pertahankan_teknik_steril', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Pertahankan teknik steril saat melakukan perawatan
                                luka</label>
                        </div>

                        <strong>Edukasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="jelaskan_tanda_infeksi"
                                {{ in_array('jelaskan_tanda_infeksi', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Jelaskan tanda dan gejala infeksi</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="anjurkan_makanan_tinggi_protein"
                                {{ in_array('anjurkan_makanan_tinggi_protein', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Anjurkan mengkonsumsi makanan tinggi kalori dan
                                protein</label>
                        </div>

                        <strong>Kolaborasi:</strong>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_debridement"
                                {{ in_array('kolaborasi_debridement', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kolaborasi prosedur debridement</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="rencana_gangguan_integritas_kulit[]" value="kolaborasi_antibiotik"
                                {{ in_array('kolaborasi_antibiotik', old('rencana_gangguan_integritas_kulit', $asesmen->asesmen_ket_dewasa_ranap_diagnosis_keperawatan->rencana_gangguan_integritas_kulit ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label">Kolaborasi pemberian antibiotik</label>
                        </div>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</body>

</html>
