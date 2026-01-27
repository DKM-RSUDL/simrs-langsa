<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Keperawatan Perinatologi - {{ $data['dataMedis']->pasien->nama ?? '-' }}</title>
    <style>
        @page {
            size: A4;
            margin: 3mm 6mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "DejaVu Sans", sans-serif;
            font-size: 8.5pt;
            line-height: 1.3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 3px 5px;
            vertical-align: top;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0f0f0;
            padding: 0;
            margin-bottom: 10px;
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

        .td-right {
            width: 20%;
            text-align: center;
            vertical-align: middle;
        }

        .brand-table {
            border-collapse: collapse;
            background-color: transparent;
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
            font-size: 16px;
            font-weight: bold;
            display: block;
            margin: 0;
        }

        .title-sub {
            font-size: 14px;
            font-weight: bold;
            display: block;
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

        .va-middle {
            vertical-align: middle;
        }

        .patient-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            margin-bottom: 15px;
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

        .section-title {
            font-weight: bold;
            font-size: 9pt;
            background-color: #ddd;
            padding: 4px 5px;
            border: 1px solid #000;
            margin: 10px 0 5px 0;
        }

        .bordered-table,
        .bordered-table th,
        .bordered-table td {
            border: 1px solid #000;
        }

        .bordered-table th {
            background-color: #f2f2f2;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        // Data Perinatologi
        $asesmen = $data['asesmen'];
        $peri = $asesmen->rmeAsesmenPerinatology;
        $fisik = $asesmen->rmeAsesmenPerinatologyFisik;
        $lanjut = $asesmen->rmeAsesmenPerinatologyPemeriksaanLanjut;
        $pasien = $data['dataMedis']->pasien;
        $dekubitus = $asesmen->rmeAsesmenPerinatologyResikoDekubitus;
        $jenisSkala = $dekubitus->jenis_skala ?? 0;

        // Logic Logo
        $logoBase64 = $data['logoBase64'] ?? null;
        if (!$logoBase64) {
            $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
            $logoData = @file_get_contents($logoPath);
            $logoBase64 = $logoData ? 'data:image/png;base64,' . base64_encode($logoData) : null;
        }

        function check($val)
        {
            return $val ? '&#9745;' : '&#9744;';
        }

        // --- Mapping Data Perinatologi ---
        $nyeri = $asesmen->rmeAsesmenPerinatologyStatusNyeri;
        $mapJenisNyeri = ['1' => 'Nyeri Akut', '2' => 'Nyeri Kronis'];
        $mapFrekuensi = ['1' => 'Jarang', '2' => 'Hilang Timbul', '3' => 'Terus Menerus'];
        $mapMenjalar = ['1' => 'Ya', '2' => 'Tidak'];
        $mapKualitas = ['1' => 'Nyeri Tumpul', '2' => 'Nyeri Tajam', '3' => 'Panas/Terbakar', '4' => 'Berdenyut'];
        $mapFaktor = ['1' => 'Aktivitas', '2' => 'Gelap', '3' => 'Posisi', '4' => 'Lain-lain'];
        $mapEfek = ['1' => 'Mual/Muntah', '2' => 'Gangguan Tidur', '3' => 'Nafsu Makan Berkurang'];

        $mapNortonFisik = [4 => 'Baik', 3 => 'Sedang', 2 => 'Buruk', 1 => 'Sangat Buruk'];
        $mapNortonMental = [4 => 'Sadar', 3 => 'Apatis', 2 => 'Bingung', 1 => 'Stupor'];
        $mapNortonAktivitas = [
            4 => 'Aktif',
            3 => 'Jalan/Bantuan',
            2 => 'Kursi Roda',
            1 => 'Ditempat Tidur',
        ];
        $mapNortonMobilitas = [
            4 => 'Bebas',
            3 => 'Agak Terbatas',
            2 => 'Sangat Terbatas',
            1 => 'Tidak Mampu',
        ];
        $mapNortonInkonten = [
            4 => 'Tidak Ada',
            3 => 'Kadang-kadang',
            2 => 'Selalu Urin',
            1 => 'Urin & Fases',
        ];

        $mapBradenSensori = [
            1 => 'Keterbatasan Penuh',
            2 => 'Sangat Terbatas',
            3 => 'Keterbatasan Ringan',
            4 => 'Tidak Ada Gangguan',
        ];
        $mapBradenKelembapan = [
            1 => 'Selalu Lembap',
            2 => 'Umumnya Lembap',
            3 => 'Kadang-Kadang Lembap',
            4 => 'Jarang Lembap',
        ];
        $mapBradenAktivitas = [
            1 => 'Total di Tempat Tidur',
            2 => 'Dapat Duduk',
            3 => 'Berjalan Kadang-kadang',
            4 => 'Dapat Berjalan-jalan',
        ];
        $mapBradenMobilitas = [
            1 => 'Tidak Mampu Bergerak Sama sekali',
            2 => 'Sangat Terbatas',
            3 => 'Tidak Ada Masalah',
            4 => 'Tanpa Keterbatasan',
        ];
        $mapBradenNutrisi = [
            1 => 'Sangat Buruk',
            2 => 'Kurang Mencukupi',
            3 => 'Mencukupi',
            4 => 'Sangat Baik',
        ];
        $mapBradenGesekan = [
            1 => 'Bermasalah',
            2 => 'Potensial Bermasalah',
            3 => 'Keterbatasan Ringan',
        ];
    @endphp

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td class="td-left">
                <table class="brand-table">
                    <tr>
                        <td class="va-middle">
                            @if ($logoBase64)
                                <img src="{{ $logoBase64 }}" style="width:70px; height:auto;">
                            @endif
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
                <span class="title-main">ASESMEN KEPERAWATAN</span>
                <span class="title-sub">PERINATOLOGY</span>
            </td>

            <td class="td-right">
                <div class="unit-box">
                    <span class="unit-text" style="font-size: 14px; margin-top: 10px;">RAWAT INAP</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- IDENTITAS PASIEN --}}
    <table class="patient-table">
        <tr>
            <th>No. RM</th>
            <td>{{ $pasien->kd_pasien ?? '-' }}</td>
            <th>Tgl. Lahir</th>
            <td>
                {{ $pasien->tgl_lahir ? \Carbon\Carbon::parse($pasien->tgl_lahir)->format('d M Y') : '-' }}
            </td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $pasien->nama ?? '-' }}</td>
            <th>Jenis Kelamin</th>
            <td>{{ ($peri->jenis_kelamin ?? '') == '0' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
    </table>

    {{-- 1. DATA MASUK --}}
    <div class="section-title">1. DATA MASUK</div>
    <table>
        <tr>
            <td width="20%"><strong>Tgl Pengisian</strong></td>
            <td>: {{ date('d-m-Y H:i', strtotime($asesmen->waktu_asesmen)) }}</td>
            <td width="20%"><strong>Petugas</strong></td>
            <td>: {{ $asesmen->user->name ?? '-' }}</td>
        </tr>
    </table>

    {{-- 2. IDENTITAS BAYI & ORANG TUA --}}
    <div class="section-title">2. IDENTITAS BAYI & ORANG TUA</div>
    <table class="bordered-table" style="width: 100%; border-collapse: collapse; table-layout: fixed;">
        <tr>
            <td width="20%"><strong>Nama Bayi</strong></td>
            <td width="30%">{{ $peri->nama_bayi ?? '-' }}</td>
            <td width="20%"><strong>NIK Ibu</strong></td>
            <td width="30%">{{ $peri->nik_ibu ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tgl Lahir & Jam</strong></td>
            <td>{{ date('d-m-Y & H:i', strtotime($asesmen->tgl_lahir_bayi)) }}</td>
            <td><strong>Agama Orang Tua</strong></td>
            <td>{{ $peri->agama_orang_tua ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Nama Ibu</strong></td>
            <td>{{ $peri->nama_ibu ?? '-' }}</td>
            <td><strong>Alamat</strong></td>
            <td>{{ $peri->alamat ?? '-' }}</td>
        </tr>

        <tr>
            {{-- Telapak kaki Bayi --}}
            <td colspan="2" style="vertical-align: top; border: 1px solid #000; padding: 5px;">
                <strong style="display: block; margin-bottom: 5px; text-align: center;">TELAPAK KAKI BAYI</strong>
                <table style="width: 100%; border: none; table-layout: fixed;">
                    <tr>
                        <td style="border: none; text-align: center;">
                            <small>Kiri</small><br>
                            @if (!empty($asesmen->rmeAsesmenPerinatology->telapak_kaki_bayi_kiri))
                                <img src="{{ public_path('storage/' . $asesmen->rmeAsesmenPerinatology->telapak_kaki_bayi_kiri) }}"
                                    style="height: 120px; max-width: 100%; object-fit: contain;">
                            @else
                                <div style="height: 120px; border: 1px dashed #ccc; line-height: 120px; color: #999;">[
                                    Kosong ]</div>
                            @endif
                        </td>
                        <td style="border: none; text-align: center;">
                            <small>Kanan</small><br>
                            @if (!empty($asesmen->rmeAsesmenPerinatology->telapak_kaki_bayi_kanan))
                                <img src="{{ public_path('storage/' . $asesmen->rmeAsesmenPerinatology->telapak_kaki_bayi_kanan) }}"
                                    style="height: 120px; max-width: 100%; object-fit: contain;">
                            @else
                                <div style="height: 120px; border: 1px dashed #ccc; line-height: 120px; color: #999;">[
                                    Kosong ]</div>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
            {{-- Sidik Jari Bayi  --}}
            <td colspan="2" style="vertical-align: top; border: 1px solid #000; padding: 5px;">
                <strong style="display: block; margin-bottom: 5px; text-align: center;">SIDIK JARI BAYI</strong>
                <table style="width: 100%; border: none; table-layout: fixed;">
                    <tr>
                        <td style="border: none; text-align: center;">
                            <small>Kiri</small><br>
                            @if (!empty($asesmen->rmeAsesmenPerinatology->sidik_jari_bayi_kiri))
                                <img src="{{ public_path('storage/' . $asesmen->rmeAsesmenPerinatology->sidik_jari_bayi_kiri) }}"
                                    style="height: 120px; max-width: 100%; object-fit: contain;">
                            @else
                                <div style="height: 120px; border: 1px dashed #ccc; line-height: 120px; color: #999;">[
                                    Kosong ]</div>
                            @endif
                        </td>
                        <td style="border: none; text-align: center;">
                            <small>Kanan</small><br>
                            @if (!empty($asesmen->rmeAsesmenPerinatology->sidik_jari_bayi_kanan))
                                <img src="{{ public_path('storage/' . $asesmen->rmeAsesmenPerinatology->sidik_jari_bayi_kanan) }}"
                                    style="height: 120px; max-width: 100%; object-fit: contain;">
                            @else
                                <div style="height: 120px; border: 1px dashed #ccc; line-height: 120px; color: #999;">[
                                    Kosong ]</div>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- SIDIK JARI IBU  --}}
        <tr>
            <td colspan="4" style="border: 1px solid #000; padding: 5px;">
                <strong style="display: block; margin-bottom: 5px; text-align: center;">SIDIK JARI IBU</strong>
                <table style="width: 100%; border: none; table-layout: fixed;">
                    <tr>
                        <td style="border: none; text-align: center;">
                            <small>Jari Kiri Ibu</small><br>
                            @if (!empty($asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kiri))
                                <img src="{{ public_path('storage/' . $asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kiri) }}"
                                    style="height: 120px; max-width: 100%; object-fit: contain;">
                            @else
                                <div style="height: 120px; border: 1px dashed #ccc; line-height: 120px; color: #999;">[
                                    Kosong ]</div>
                            @endif
                        </td>
                        <td style="border: none; text-align: center;">
                            <small>Jari Kanan Ibu</small><br>
                            @if (!empty($asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kanan))
                                <img src="{{ public_path('storage/' . $asesmen->rmeAsesmenPerinatology->sidik_jari_ibu_kanan) }}"
                                    style="height: 120px; max-width: 100%; object-fit: contain;">
                            @else
                                <div style="height: 120px; border: 1px dashed #ccc; line-height: 120px; color: #999;">[
                                    Kosong ]</div>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- 3. ANAMNESIS --}}
    <div class="section-title">3. ANAMNESIS</div>
    <table class="bordered-table">
        <tr>
            <td colspan="5"><strong>Anamnesis:</strong> {{ $asesmen->anamnesis ?? '-' }}</td>
        </tr>
    </table>

    {{-- 4. PEMERIKSAAN FISIK DASAR --}}
    <div class="section-title">4. PEMERIKSAAN FISIK</div>
    <table class="bordered-table" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td width="25%"><strong>Nadi:</strong> {{ $fisik->frekuensi_nadi ?? '-' }} x/mnt
                ({{ $fisik->status_frekuensi ?? '-' }})</td>
            <td width="25%"><strong>Nafas:</strong> {{ $fisik->nafas ?? '-' }} x/mnt</td>
            <td width="25%"><strong>Suhu:</strong> {{ $fisik->suhu ?? '-' }} °C</td>
            <td width="25%"><strong>Kesadaran:</strong> {{ $fisik->kesadaran ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="3"><strong>Saturasi O2:</strong>
                Tanpa O2: {{ $fisik->spo2_tanpa_bantuan ?? '-' }}% |
                Dengan O2: {{ $fisik->spo2_dengan_bantuan ?? '-' }}%
            </td>
            <td width="25%"><strong>AVPU:</strong> {{ $fisik->avpu ?? '-' }}</td>
        </tr>
    </table>

    {{-- PEMERIKSAAN LANJUTAN --}}
    <div class="section-title">PEMERIKSAAN LANJUTAN</div>
    <table class="bordered-table" style="width: 100%; border-collapse: collapse;">
        {{-- KULIT --}}
        <tr>
            <td width="20%"><strong>Warna Kulit</strong></td>
            <td width="30%">{{ $lanjut->warna_kulit ?? '-' }}</td>
            <td width="20%"><strong>Sianosis</strong></td>
            <td width="30%">{{ $lanjut->sianosis ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Kemerahan / Rash</strong></td>
            <td>{{ $lanjut->kemerahan ?? '-' }}</td>
            <td><strong>Turgor Kulit</strong></td>
            <td>{{ $lanjut->turgor_kulit ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tanda Lahir</strong></td>
            <td>{{ $lanjut->tanda_lahir ?? '-' }}</td>
            <td><strong>Fontanel Anterior</strong></td>
            <td>{{ $lanjut->fontanel_anterior ?? '-' }}</td>
        </tr>

        {{-- KEPALA & WAJAH --}}
        <tr>
            <td><strong>Sutura Sagitalis</strong></td>
            <td>{{ $lanjut->sutura_sagitalis ?? '-' }}</td>
            <td><strong>Gambaran Wajah</strong></td>
            <td>{{ $lanjut->gambaran_wajah ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Cephalhemeton</strong></td>
            <td>{{ $lanjut->cephalhemeton ?? '-' }}</td>
            <td><strong>Caput Succedaneun</strong></td>
            <td>{{ $lanjut->caput_succedaneun ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Mulut</strong></td>
            <td>{{ $lanjut->mulut ?? '-' }}</td>
            <td><strong>Mucosa Mulut</strong></td>
            <td>{{ $lanjut->mucosa_mulut ?? '-' }}</td>
        </tr>

        {{-- DADA & PERNAFASAN --}}
        <tr>
            <td><strong>Dada & Paru-paru</strong></td>
            <td>{{ $lanjut->dada_paru ?? '-' }}</td>
            <td><strong>Suara Nafas</strong></td>
            <td>{{ $lanjut->suara_nafas ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Respirasi</strong></td>
            <td>{{ $lanjut->respirasi ?? '-' }}</td>
            <td><strong>Down Score</strong></td>
            <td>{{ $lanjut->down_score ?? '-' }}</td>
        </tr>

        {{-- JANTUNG & PERUT --}}
        <tr>
            <td><strong>Bunyi Jantung</strong></td>
            <td>{{ $lanjut->bunyi_jantung ?? '-' }}</td>
            <td><strong>CRT</strong></td>
            <td>{{ $lanjut->waktu_pengisian_kapiler ?? '-' }} detik</td>
        </tr>
        <tr>
            <td><strong>Keadaan Perut</strong></td>
            <td>{{ $lanjut->keadaan_perut ?? '-' }}</td>
            <td><strong>Umbilikus</strong></td>
            <td>{{ $lanjut->umbilikus ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Warna Umbilikus</strong></td>
            <td>{{ $lanjut->warna_umbilikus ?? '-' }}</td>
            <td><strong>Genitalis</strong></td>
            <td>{{ $lanjut->genitalis ?? '-' }}</td>
        </tr>

        {{-- MOTORIK & EKSTREMITAS --}}
        <tr>
            <td><strong>Gerakan</strong></td>
            <td>{{ $lanjut->gerakan ?? '-' }}</td>
            <td><strong>Tonus/Aktivitas</strong></td>
            <td>{{ $lanjut->aktivitas ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Menangis</strong></td>
            <td>{{ $lanjut->menangis ?? '-' }}</td>
            <td><strong>Ekstremitas Atas</strong></td>
            <td>{{ $lanjut->ekstremitas_atas ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Ekstremitas Bawah</strong></td>
            <td>{{ $lanjut->ekstremitas_bawah ?? '-' }}</td>
            <td><strong>Tulang Belakang</strong></td>
            <td>{{ $lanjut->tulang_belakang ?? '-' }}</td>
        </tr>

        {{-- REFLEKS --}}
        <tr>
            <td><strong>Refleks</strong></td>
            <td>{{ $lanjut->refleks ?? '-' }}</td>
            <td><strong>Genggaman</strong></td>
            <td>{{ $lanjut->genggaman ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Menghisap</strong></td>
            <td colspan="3">{{ $lanjut->menghisap ?? '-' }}</td>
        </tr>
    </table>

    {{-- ANTROPOMETRI --}}
    <div class="keep-together">
        <div class="section-title">ANTROPOMETRI</div>
        <table class="bordered-table">
            <tr>
                <td><strong>TB:</strong> {{ $fisik->tinggi_badan ?? '-' }} cm</td>
                <td><strong>BB:</strong> {{ $fisik->berat_badan ?? '-' }} kg</td>
                <td><strong>LK:</strong> {{ $fisik->lingkar_kepala ?? '-' }} cm</td>
                <td><strong>LD:</strong> {{ $fisik->lingkar_dada ?? '-' }} cm</td>
                <td><strong>LP:</strong> {{ $fisik->lingkar_perut ?? '-' }} cm</td>
            </tr>
        </table>
    </div>

    {{-- PEMERIKSAAN FISIK MENYELURUH --}}
    <div class="section-title">PEMERIKSAAN FISIK MENYELURUH</div>
    <table class="bordered-table">
        @foreach ($asesmen->pemeriksaanFisik->chunk(2) as $chunk)
            <tr>
                @foreach ($chunk as $item)
                    <td width="20%">{{ $item->itemFisik->nama ?? '' }}</td>
                    <td width="30%">
                        {{ $item->is_normal ? 'Normal' : 'Tidak Normal (' . $item->keterangan . ')' }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    {{-- RIWAYAT IBU --}}
    <div class="section-title">5. RIWAYAT KESEHATAN IBU</div>
    @php $ibu = $asesmen->rmeAsesmenPerinatologyRiwayatIbu; @endphp
    <table class="bordered-table">
        <tr>
            <td width="25%"><strong>Pemeriksaan Hamil</strong></td>
            <td>{{ $ibu->pemeriksaan_kehamilan ?? '-' }}</td>
            <td width="25%"><strong>Tempat Pemeriksaan</strong></td>
            <td>{{ $ibu->tempat_pemeriksaan ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Usia Kehamilan</strong></td>
            <td>{{ $ibu->usia_kehamilan ?? '-' }}</td>
            <td><strong>Cara Persalinan</strong></td>
            <td>{{ $ibu->cara_persalinan ?? '-' }}</td>
        </tr>
    </table>

    {{-- 6. STATUS NYERI --}}
    <div class="section-title">6. STATUS NYERI</div>
    <table class="bordered-table" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td width="25%"><strong>Metode:</strong>
                {{ ['1' => 'NRS', '2' => 'FLACC', '3' => 'CRIES'][$nyeri->jenis_skala_nyeri ?? 0] ?? '-' }}
            </td>
            <td width="25%"><strong>Skor:</strong> {{ $nyeri->nilai_nyeri ?? '0' }}</td>
            <td width="50%" colspan="2"><strong>Kesimpulan:</strong> {{ $nyeri->kesimpulan_nyeri ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Karakteristik Nyeri</div>
    <table class="bordered-table" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td width="25%"><strong>Lokasi:</strong> {{ $nyeri->lokasi ?? '-' }}</td>
            <td width="25%"><strong>Durasi:</strong> {{ $nyeri->durasi ?? '-' }}</td>
            <td width="25%"><strong>Jenis Nyeri:</strong> {{ $mapJenisNyeri[$nyeri->jenis_nyeri] ?? '-' }}</td>
            <td width="25%"><strong>Frekuensi:</strong> {{ $mapFrekuensi[$nyeri->frekuensi] ?? '-' }}</td>
        </tr>
        <tr>
            <td width="25%"><strong>Faktor Pemberat:</strong> {{ $mapFaktor[$nyeri->faktor_pemberat] ?? '-' }}</td>
            <td width="25%"><strong>Faktor Peringan:</strong> {{ $mapFaktor[$nyeri->faktor_peringan] ?? '-' }}</td>
            <td width="25%"><strong>Menjalar ke:</strong> {{ $mapMenjalar[$nyeri->menjalar] ?? '-' }}</td>
            <td width="25%"><strong>Kualitas:</strong> {{ $mapKualitas[$nyeri->kualitas] ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="4"><strong>Efek Nyeri:</strong> {{ $mapEfek[$nyeri->efek_nyeri] ?? '-' }}</td>
        </tr>
    </table>

    {{-- 8. RISIKO JATUH --}}
    <div class="keep-together">
        <div class="section-title">8. RISIKO JATUH</div>
        @php
            $jatuh = $asesmen->rmeAsesmenPerinatologyRisikoJatuh;
            $jenis = $jatuh->resiko_jatuh_jenis ?? 0;
        @endphp

        <p><strong>Metode Penilaian:</strong>
            {{ [
                '1' => 'Umum',
                '2' => 'Morse',
                '3' => 'Humpty Dumpty / Pediatrik',
                '4' => 'Ontario Modified Stratify Sydney / Lansia',
                '5' => 'Lainnya',
            ][$jenis] ?? '-' }}
        </p>

        {{-- Tampilan Tabel Skala Umum --}}
        @if ($jenis == 1)
            <table class="bordered-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th width="80%">Parameter Skala Umum</th>
                        <th class="text-center">Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Apakah pasien berusia < dari 2 tahun?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_umum_usia) && $jatuh->risiko_jatuh_umum_usia == 1 ? 'Ya' : 'Tidak' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Apakah pasien dalam kondisi sebagai geriatri, dizzines, vertigo, gangguan keseimbangan,
                            gangguan
                            penglihatan, penggunaan obat sedasi, status kesadaran dan atau kejiwaan, konsumsi alkohol?
                        </td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_umum_kondisi_khusus) && $jatuh->risiko_jatuh_umum_kondisi_khusus == 1 ? 'Ya' : 'Tidak' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Apakah pasien didiagnosis sebagai pasien dengan penyakit parkinson?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_umum_diagnosis_parkinson) && $jatuh->risiko_jatuh_umum_diagnosis_parkinson == 1 ? 'Ya' : 'Tidak' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Apakah pasien sedang mendapatkan obat sedasi, riwayat tirah baring lama, perubahan posisi
                            yang
                            akan meningkatkan risiko jatuh?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_umum_pengobatan_berisiko) && $jatuh->risiko_jatuh_umum_pengobatan_berisiko == 1 ? 'Ya' : 'Tidak' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Apakah pasien saat ini sedang berada pada salah satu lokasi ini: rehab medik, ruangan dengan
                            penerangan kurang dan bertangga?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_umum_lokasi_berisiko) && $jatuh->risiko_jatuh_umum_lokasi_berisiko == 1 ? 'Ya' : 'Tidak' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <p><strong>Kesimpulan:</strong> {{ $jatuh->kesimpulan_skala_umum ?? '-' }}</p>

            {{-- Tampilan Tabel Skala Morse --}}
        @elseif ($jenis == 2)
            <table class="bordered-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th width="75%">Parameter Morse</th>
                        <th class="text-center">Hasil (Skor)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pasien pernah mengalami Jatuh?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_morse_riwayat_jatuh) && $jatuh->risiko_jatuh_morse_riwayat_jatuh == 0 ? 'Ya (25)' : 'Tidak (0)' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pasien memiliki diagnosis sekunder?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_morse_diagnosis_sekunder) && $jatuh->risiko_jatuh_morse_diagnosis_sekunder == 0 ? 'Ya (15)' : 'Tidak (0)' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pasien membutuhkan bantuan ambulasi?</td>
                        <td class="text-center">
                            @php $ab = $jatuh->risiko_jatuh_morse_bantuan_ambulasi ?? ''; @endphp
                            {{ $ab == 0 ? 'Meja/kursi (30)' : ($ab == 1 ? 'Kruk/Tongkat (15)' : 'Tidak ada/Bed rest (0)') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pasien terpasang infus?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_morse_terpasang_infus) && $jatuh->risiko_jatuh_morse_terpasang_infus == 0 ? 'Ya (20)' : 'Tidak (0)' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Gaya Berjalan?</td>
                        <td class="text-center">
                            @php $cb = $jatuh->risiko_jatuh_morse_cara_berjalan ?? ''; @endphp
                            {{ $cb == 1 ? 'Terganggu (20)' : ($cb == 2 ? 'Lemah (10)' : 'Normal (0)') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Status Mental?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_morse_status_mental) && $jatuh->risiko_jatuh_morse_status_mental == 1 ? 'Lupa keterbatasan (15)' : 'Sadar kemampuan (0)' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <p><strong>Kesimpulan:</strong> {{ $jatuh->kesimpulan_skala_morse ?? '-' }}</p>

            {{-- Tampilan Tabel Humpty Dumpty --}}
        @elseif ($jenis == 3)
            <table class="bordered-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th width="75%">Parameter Humpty Dumpty</th>
                        <th class="text-center">Hasil (Skor)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Usia Anak</td>
                        <td class="text-center">
                            {{ [0 => 'Dibawah 3 th (4)', 1 => '3-7 th (3)', 2 => '7-13 th (2)', 3 => '>13 th (1)'][$jatuh->risiko_jatuh_pediatrik_usia_anak ?? -1] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_pediatrik_jenis_kelamin) && $jatuh->risiko_jatuh_pediatrik_jenis_kelamin == 0 ? 'Laki-laki (2)' : 'Perempuan (1)' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Diagnosis</td>
                        <td class="text-center">
                            {{ [0 => 'Neurologis (4)', 1 => 'Oksigenasi (3)', 2 => 'Psikiatri (2)', 3 => 'Lainnya (1)'][$jatuh->risiko_jatuh_pediatrik_diagnosis ?? -1] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Gangguan Kognitif</td>
                        <td class="text-center">
                            {{ [0 => 'Tdk menyadari (3)', 1 => 'Lupa (2)', 2 => 'Orientasi baik (1)'][$jatuh->risiko_jatuh_pediatrik_gangguan_kognitif ?? -1] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Faktor Lingkungan</td>
                        <td class="text-center">
                            {{ [0 => 'Riw. Jatuh (4)', 1 => 'Alat bantu (3)', 2 => 'Tempat tidur (2)', 3 => 'Luar RS (1)'][$jatuh->risiko_jatuh_pediatrik_faktor_lingkungan ?? -1] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pembedahan/Sedasi/Anestesi</td>
                        <td class="text-center">
                            {{ [0 => '<24 jam (3)', 1 => '<48 jam (2)', 2 => '>48 jam (1)'][$jatuh->risiko_jatuh_pediatrik_pembedahan ?? -1] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Penggunaan Medikamentosa</td>
                        <td class="text-center">
                            {{ [0 => 'Multiple (3)', 1 => 'Salah satu (2)', 2 => 'Lainnya/Tdk ada (1)'][$jatuh->risiko_jatuh_pediatrik_penggunaan_mentosa ?? -1] ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <p><strong>Kesimpulan:</strong> {{ $jatuh->kesimpulan_skala_pediatrik ?? '-' }}</p>

            {{-- Tampilan Tabel Ontario (Lansia) --}}
        @elseif ($jenis == 4)
            <table class="bordered-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f2f2f2;">
                        <th width="80%">Parameter Ontario (Lansia)</th>
                        <th class="text-center">Hasil</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Apakah pasien datang karena jatuh?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs) && $jatuh->risiko_jatuh_lansia_jatuh_saat_masuk_rs == 0 ? 'Ya' : 'Tidak' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Apakah pasien bingung?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_lansia_status_bingung) && $jatuh->risiko_jatuh_lansia_status_bingung == 0 ? 'Ya' : 'Tidak' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Apakah terdapat perubahan perilaku berkemih?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_lansia_perubahan_berkemih) && $jatuh->risiko_jatuh_lansia_perubahan_berkemih == 0 ? 'Ya' : 'Tidak' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Mobilitas (Imobilisasi)?</td>
                        <td class="text-center">
                            {{ isset($jatuh->risiko_jatuh_lansia_mobilitas_imobilisasi) && $jatuh->risiko_jatuh_lansia_mobilitas_imobilisasi == 0 ? 'Ya' : 'Tidak' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <p><strong>Kesimpulan:</strong> {{ $jatuh->kesimpulan_skala_lansia ?? '-' }}</p>
        @endif

        <p><strong>Intervensi Risiko Jatuh:</strong></p>
        <ul style="margin-top:0; padding-left: 20px;">
            @php $intervensi = json_decode($jatuh->intervensi_risiko_jatuh ?? '[]', true); @endphp
            @forelse($intervensi as $item)
                <li>{{ $item }}</li>
            @empty
                <li>-</li>
            @endforelse
        </ul>
    </div>

    {{-- 9. RISIKO DEKUBITUS --}}
    <div class="section-title">9. RISIKO DEKUBITUS</div>

    <p><strong>Jenis Skala:</strong>
        {{ $jenisSkala == 1 ? 'Skala Norton' : ($jenisSkala == 2 ? 'Skala Braden' : '-') }}
    </p>

    @if ($jenisSkala == 1)
        <table class="bordered-table" style="width: 100%; border-collapse: collapse; font-size: 7.5pt;">
            <tr style="background-color: #f2f2f2;">
                <th width="20%">Kondisi Fisik</th>
                <th width="20%">Mental</th>
                <th width="20%">Aktivitas</th>
                <th width="20%">Mobilitas</th>
                <th width="20%">Inkontinensia</th>
            </tr>
            <tr>
                <td>{{ $mapNortonFisik[$dekubitus->norton_kondisi_fisik ?? 0] ?? '-' }}</td>
                <td>{{ $mapNortonMental[$dekubitus->norton_kondisi_mental ?? 0] ?? '-' }}</td>
                <td>{{ $mapNortonAktivitas[$dekubitus->norton_aktivitas ?? 0] ?? '-' }}</td>
                <td>{{ $mapNortonMobilitas[$dekubitus->norton_mobilitas ?? 0] ?? '-' }}</td>
                <td>{{ $mapNortonInkonten[$dekubitus->norton_inkontenesia ?? 0] ?? '-' }}</td>
            </tr>
        </table>
    @elseif($jenisSkala == 2)
        <table class="bordered-table" style="width: 100%; border-collapse: collapse; font-size: 7.5pt;">
            <tr style="background-color: #f2f2f2;">
                <th width="16%">Sensori</th>
                <th width="16%">Kelembapan</th>
                <th width="16%">Aktivitas</th>
                <th width="16%">Mobilitas</th>
                <th width="16%">Nutrisi</th>
                <th width="20%">Pergesekan</th>
            </tr>
            <tr>
                <td>{{ $mapBradenSensori[$dekubitus->braden_persepsi ?? 0] ?? '-' }}</td>
                <td>{{ $mapBradenKelembapan[$dekubitus->braden_kelembapan ?? 0] ?? '-' }}</td>
                <td>{{ $mapBradenAktivitas[$dekubitus->braden_aktivitas ?? 0] ?? '-' }}</td>
                <td>{{ $mapBradenMobilitas[$dekubitus->braden_mobilitas ?? 0] ?? '-' }}</td>
                <td>{{ $mapBradenNutrisi[$dekubitus->braden_nutrisi ?? 0] ?? '-' }}</td>
                <td>{{ $mapBradenGesekan[$dekubitus->braden_pergesekan ?? 0] ?? '-' }}</td>
            </tr>
        </table>
    @endif

    <table class="bordered-table" style="margin-top: 5px;">
        <tr>
            <td width="25%"><strong>Kesimpulan</strong></td>
            <td>{{ $dekubitus->decubitus_kesimpulan ?? '-' }}</td>
        </tr>
    </table>

    {{-- 10. STATUS GIZI --}}
    <div class="section-title">10. STATUS GIZI</div>
    @php $gizi = $asesmen->rmeAsesmenPerinatologyGizi; @endphp
    <table class="bordered-table">
        <tr>
            <td width="25%"><strong>Metode Screening</strong></td>
            <td colspan="3">
                @if (($gizi->gizi_jenis ?? '') == 1)
                    MST (Malnutrition Screening Tool)
                @elseif(($gizi->gizi_jenis ?? '') == 2)
                    MNA (Mini Nutritional Assessment)
                @elseif(($gizi->gizi_jenis ?? '') == 3)
                    Strong Kids (1 bln - 18 Tahun)
                @else
                    Tidak Dapat Dinilai
                @endif
            </td>
        </tr>
    </table>

    {{-- TAMPILAN DETAIL BERDASARKAN METODE --}}
    @if (($gizi->gizi_jenis ?? '') == 1)
        {{-- DETAIL MST --}}
        <table class="bordered-table" style="width: 100%; border-collapse: collapse; margin-top: 5px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th width="85%">Parameter Penilaian Gizi MST</th>
                    <th class="text-center">Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 6 bulan terakhir?</td>
                    <td class="text-center">
                        {{ [0 => 'Tidak', 2 => 'Ragu', 3 => 'Ya'][$gizi->gizi_mst_penurunan_bb ?? -1] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Jika Ya, berapa penurunan BB tersebut?</td>
                    <td class="text-center">
                        {{ [0 => '0 kg', 1 => '1-5 kg', 2 => '6-10 kg', 3 => '11-15 kg', 4 => '>15 kg'][$gizi->gizi_mst_jumlah_penurunan_bb ?? 0] }}
                    </td>
                </tr>
                <tr>
                    <td>Apakah asupan makan berkurang karena tidak nafsu makan?</td>
                    <td class="text-center">
                        {{ ($gizi->gizi_mst_nafsu_makan_berkurang ?? '') == '1' ? 'Ya' : 'Tidak' }}</td>
                </tr>
                <tr>
                    <td>Pasien didiagnosa khusus (DM, Cancer, Geriatri, GGK, Penurunan Imun)?</td>
                    <td class="text-center">
                        {{ ($gizi->gizi_mst_diagnosis_khusus ?? '') == '1' ? 'Ya' : 'Tidak' }}</td>
                </tr>
            </tbody>
        </table>
    @elseif(($gizi->gizi_jenis ?? '') == 2)
        {{-- DETAIL MNA --}}
        <table class="bordered-table" style="width: 100%; border-collapse: collapse; margin-top: 5px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th width="85%">Parameter Penilaian Gizi MNA</th>
                    <th class="text-center">Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Penurunan asupan makanan selama 3 bulan terakhir?</td>
                    <td class="text-center">
                        {{ [0 => 'Parah (0)', 1 => 'Sedang (1)', 2 => 'Tidak ada (2)'][$gizi->gizi_mna_penurunan_asupan_3_bulan ?? -1] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Kehilangan Berat Badan selama 3 bulan terakhir?</td>
                    <td class="text-center">
                        {{ [0 => '>3kg (0)', 1 => 'Tidak tahu (1)', 2 => '1-3kg (2)', 3 => 'Tidak ada (3)'][$gizi->gizi_mna_kehilangan_bb_3_bulan ?? -1] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Mobilisasi atau pergerakan pasien?</td>
                    <td class="text-center">
                        {{ [0 => 'Bedrest/Kursi Roda (0)', 1 => 'Terbatas (1)', 2 => 'Bebas Jalan (2)'][$gizi->gizi_mna_mobilisasi ?? -1] ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>Stres psikologi atau penyakit akut 3 bulan terakhir?</td>
                    <td class="text-center">
                        {{ ($gizi->gizi_mna_stress_penyakit_akut ?? '') == '0' ? 'Ya (0)' : 'Tidak (1)' }}</td>
                </tr>
                <tr>
                    <td>Masalah neuropsikologi?</td>
                    <td class="text-center">
                        {{ [0 => 'Demensia/Depresi Berat (0)', 1 => 'Demensia Ringan (1)', 2 => 'Tidak ada (2)'][$gizi->gizi_mna_status_neuropsikologi ?? -1] ?? '-' }}
                    </td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td colspan="2">
                        <strong>Antropometri:</strong>
                        BB: {{ $gizi->gizi_mna_berat_badan ?? '-' }} kg |
                        TB: {{ $gizi->gizi_mna_tinggi_badan ?? '-' }} cm |
                        IMT: {{ $gizi->gizi_mna_imt ?? '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
    @elseif(($gizi->gizi_jenis ?? '') == 3)
        {{-- DETAIL STRONG KIDS --}}
        <table class="bordered-table" style="width: 100%; border-collapse: collapse; margin-top: 5px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th width="85%">Parameter Penilaian Gizi Strong Kids</th>
                    <th class="text-center">Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Apakah anak tampak kurus, kehilangan lemak subkutan, massa otot, atau wajah cekung?</td>
                    <td class="text-center">
                        {{ ($gizi->gizi_strong_status_kurus ?? '') == '1' ? 'Ya (1)' : 'Tidak (0)' }}</td>
                </tr>
                <tr>
                    <td>Apakah terdapat penurunan BB selama satu bulan terakhir atau tidak ada peningkatan BB/TB?</td>
                    <td class="text-center">
                        {{ ($gizi->gizi_strong_penurunan_bb ?? '') == '1' ? 'Ya (1)' : 'Tidak (0)' }}</td>
                </tr>
                <tr>
                    <td>Apakah terdapat diare/muntah berlebihan atau penurunan asupan makan 1-3 hari terakhir?</td>
                    <td class="text-center">
                        {{ ($gizi->gizi_strong_gangguan_pencernaan ?? '') == '1' ? 'Ya (1)' : 'Tidak (0)' }}</td>
                </tr>
                <tr>
                    <td>Apakah terdapat penyakit atau keadaan yang mengakibatkan pasien berisiko malnutrisi?</td>
                    {{-- Index Ya untuk Strong Kids poin 4 adalah 2 --}}
                    <td class="text-center">
                        {{ ($gizi->gizi_strong_penyakit_berisiko ?? '') == '2' ? 'Ya (2)' : 'Tidak (0)' }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <table class="bordered-table" style="margin-top: 5px;">
        <tr>
            <td width="25%"><strong>Kesimpulan Gizi</strong></td>
            <td colspan="3" class="text-bold" style="background-color: #f9f9f9;">
                @if (($gizi->gizi_jenis ?? '') == 1)
                    {{ $gizi->gizi_mst_kesimpulan ?? '-' }}
                @elseif(($gizi->gizi_jenis ?? '') == 2)
                    {{ $gizi->gizi_mna_kesimpulan ?? '-' }}
                @elseif(($gizi->gizi_jenis ?? '') == 3)
                    {{ $gizi->gizi_strong_kesimpulan ?? '-' }}
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    {{-- 11. STATUS FUNGSIONAL --}}
    <div class="section-title">11. STATUS FUNGSIONAL</div>
    @php $fungsional = $asesmen->rmeAsesmenPerinatologyStatusFungsional; @endphp
    <table class="bordered-table">
        <tr>
            <td width="25%"><strong>Jenis Skala</strong></td>
            <td colspan="3">
                @php
                    $mapSkala = [
                        1 => 'Pengkajian Aktivitas Harian',
                        2 => 'Lainnya',
                    ];
                @endphp
                {{ $mapSkala[$fungsional->jenis_skala ?? 0] ?? '-' }}
            </td>
        </tr>
        <tr>
            <td width="25%"><strong>Nilai Skala ADL</strong></td>
            <td>{{ $fungsional->nilai_skala_adl ?? '0' }}</td>
            <td width="25%"><strong>Kesimpulan</strong></td>
            <td class="text-bold">{{ $fungsional->kesimpulan_fungsional ?? '-' }}</td>
        </tr>
    </table>

    {{-- 12. STATUS KEBUTUHAN EDUKASI --}}
    <div class="section-title">12. STATUS KEBUTUHAN EDUKASI, PENDIDIKAN DAN PENGAJARAN</div>
    <table class="bordered-table">
        <tr>
            <td width="25%"><strong>Gaya Bicara</strong></td>
            <td>{{ ucfirst($asesmen->rmeAsesmenPerinatology->gaya_bicara ?? '-') }}</td>
            <td width="25%"><strong>Bahasa</strong></td>
            <td>{{ $asesmen->rmeAsesmenPerinatology->bahasa ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Hambatan</strong></td>
            <td>{{ str_replace('_', ' ', $asesmen->rmeAsesmenPerinatology->hambatan_komunikasi ?? '-') }}</td>
            <td><strong>Media Disukai</strong></td>
            <td>{{ ucfirst($asesmen->rmeAsesmenPerinatology->media_disukai ?? '-') }}</td>
        </tr>
        <tr>
            <td width="25%"><strong>Perlu Penerjemah</strong></td>
            <td>{{ ucfirst($asesmen->rmeAsesmenPerinatology->perlu_penerjemahan ?? '-') }}</td>
            <td width="25%"><strong>Pendidikan</strong></td>
            <td>{{ $asesmen->rmeAsesmenPerinatology->tingkat_pendidikan ?? '-' }}</td>
        </tr>

    </table>

    {{-- 13. DISCHARGE PLANNING --}}
    <div class="section-title">13. DISCHARGE PLANNING</div>
    @php $pulang = $asesmen->rmeAsesmenPerinatologyRencanaPulang; @endphp
    <table class="bordered-table">
        <tr>
            <td width="40%"><strong>Usia Lanjut</strong></td>
            <td>{{ ($pulang->usia_lanjut ?? '') == '0' ? 'Ya' : 'Tidak' }}</td>
            <td width="40%"><strong>Keterampilan Khusus</strong></td>
            <td>{{ ucfirst($pulang->memerlukan_keterampilan_khusus ?? '-') }}</td>
        </tr>
        <tr>
            <td><strong>Hambatan Mobilisasi</strong></td>
            <td>{{ ($pulang->hambatan_mobilisasi ?? '') == '0' ? 'Ya' : 'Tidak' }}</td>
            <td><strong>Alat Bantu</strong></td>
            <td>{{ ucfirst($pulang->memerlukan_alat_bantu ?? '-') }}</td>
        </tr>
        <tr>
            <td><strong>Membutuhkan penggunaan media berkelanjutan</strong></td>
            <td>{{ ($pulang->membutuhkan_pelayanan_medis ?? '') == '0' ? 'Ya' : 'Tidak' }}</td>
            <td><strong>Bantuan Aktivitas Harian</strong></td>
            <td>{{ ($pulang->ketergantungan_aktivitas ?? '') == 'ya' ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td><strong>Pasien / Keluarga Memerlukan Keterampilan Khusus Setelah Pulang</strong></td>
            <td>{{ ($pulang->memerlukan_keterampilan_khusus ?? '') == 'ya' ? 'Ya' : 'Tidak' }}</td>
            <td><strong>Nyeri Kronis</strong></td>
            <td>{{ ucfirst($pulang->memiliki_nyeri_kronis ?? '-') }}</td>
        </tr>
        <tr>
            <td><strong>Lama Dirawat (Perkiraan)</strong></td>
            <td>{{ $pulang->perkiraan_lama_dirawat ?? '-' }} hari</td>
            <td><strong>Pasien Memerlukan Alat Bantu Setelah Keluar Rumah Sakit</strong></td>
            <td>{{ ($pulang->memerlukan_alat_bantu ?? '') == 'ya' ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <td><strong>Rencana Tgl Pulang</strong></td>
            <td>{{ $pulang->rencana_pulang ?? '-' }}</td>
            <td><strong>Kesimpulan</strong></td>
            <td>{{ $pulang->kesimpulan ?? '-' }}</td>
        </tr>
    </table>

    {{-- 14. MASALAH / DIAGNOSIS KEPERAWATAN --}}
    <div class="section-title">14. MASALAH / DIAGNOSIS KEPERAWATAN</div>
    <table class="bordered-table">
        <thead>
            <tr>
                <th width="45%">Masalah / Diagnosis Keperawatan</th>
                <th width="55%">Rencana Keperawatan (Intervensi)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $keperawatan = $asesmen->rmeAsesmenKepPerinatologyKeperawatan;
                $diagnosisList = $keperawatan->diagnosis ?? [];
            @endphp
            @forelse ($diagnosisList as $kd)
                <tr>
                    <td class="text-bold">• {{ ucwords(str_replace('_', ' ', $kd)) }}</td>
                    <td>
                        @php
                            $rencanaField = 'rencana_' . $kd;
                            $intervensiItems = $keperawatan->$rencanaField ?? [];
                        @endphp
                        @if (!empty($intervensiItems))
                            <ul style="margin: 0; padding-left: 15px;">
                                @foreach ($intervensiItems as $item)
                                    <li>{{ ucfirst(str_replace('_', ' ', $item)) }}</li>
                                @endforeach
                            </ul>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Tidak ada diagnosis yang dipilih.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <table style="margin-top: 30px;">
        <tr>
            <td width="60%"></td>
            <td width="40%" class="text-center">
                Langsa, {{ \Carbon\Carbon::parse($asesmen->waktu_asesmen)->translatedFormat('d F Y') }}<br>
                Perawat Penanggung Jawab,<br><br>
                @if ($asesmen->user->name)
                    <img src="{{ generateQrCode($asesmen->user->name, 70, 'svg_datauri') }}" alt="QR Signature"><br>
                @endif
                <strong>( {{ $asesmen->user->name ?? '-' }} )</strong>
            </td>
        </tr>
    </table>
</body>

</html>
