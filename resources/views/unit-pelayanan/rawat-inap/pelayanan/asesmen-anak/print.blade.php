<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Keperawatan Anak - {{ $data['dataMedis']->pasien->nama ?? '-' }}</title>
    <style>
        /* --- STYLE DARI MEDIS (Agar ukuran kertas & font sama persis) --- */
        @page {
            size: A4;
            margin: 3mm 6mm;
            [cite_start]
            /* Margin disamakan dengan Medis [cite: 260] */
        }

        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            [cite_start]
            /* Disamakan dengan Medis [cite: 261] */
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8.5pt;
            [cite_start]
            /* Ukuran font disamakan dengan Medis [cite: 261] */
            line-height: 1.3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 5px; Hapus ini agar sama dengan default Medis */
        }

        td,
        th {
            padding: 3px 5px;
            [cite_start]
            /* Padding disamakan dengan Medis [cite: 263] */
            vertical-align: top;
        }

        /* --- HEADER & IDENTITAS (Style Medis) --- */
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

        /* --- Tabel Identitas Pasien (Style Khusus Medis) --- */
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

        /* --- STYLE BAWAAN KEPERAWATAN (JANGAN DIHAPUS agar body ke bawah aman) --- */
        /* SECTIONS */
        .section-title {
            font-weight: bold;
            font-size: 9pt;
            background-color: #ddd;
            padding: 4px 5px;
            margin-top: 10px;
            border: 1px solid #000;
            margin-bottom: 5px;
        }

        /* Bordered table untuk isi asesmen (beda dengan patient-table header) */
        .bordered-table,
        .bordered-table th,
        .bordered-table td {
            border: 1px solid #000;
        }

        .bordered-table th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 3px 4px;
            /* Kembalikan padding khusus tabel body */
        }

        /* Override padding untuk bordered-table td agar sesuai style lama */
        .bordered-table td {
            padding: 3px 4px;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .mb-1 {
            margin-bottom: 4px;
        }

        .mt-2 {
            margin-top: 8px;
        }

        .badge {
            display: inline-block;
            padding: 1px 3px;
            border: 1px solid #666;
            border-radius: 3px;
            font-size: 7pt;
            margin-right: 2px;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    @php
        $asesmen = $data['asesmen'] ?? null;
        $kepAnak = $asesmen->rmeAsesmenKepAnak ?? null;
        $fisik = $asesmen->rmeAsesmenKepAnakFisik ?? null;
        $pasien = $data['dataMedis']->pasien ?? null;

        // Logika Logo disamakan dengan Medis (menggunakan path jika ada, atau fallback ke data)
        $logoBase64 = $data['logoBase64'] ?? null;
        if (!$logoBase64) {
            $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
            $logoData = @file_get_contents($logoPath);
            $logoBase64 = $logoData ? 'data:image/png;base64,' . base64_encode($logoData) : null;
        }

        // Helper untuk menampilkan Checkbox
        function checkbox($val)
        {
            return $val ? '&#9745;' : '&#9744;';
        }
    @endphp

    {{-- KOP SURAT (Struktur Persis Medis) --}}
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
                <span class="title-sub">ASESMEN KEPERAWATAN ANAK</span>
            </td>

            <td class="td-right">
                <div class="unit-box">
                    <span class="unit-text" style="font-size: 14px; margin-top: 10px;">RAWAT INAP</span>
                </div>
            </td>
        </tr>
    </table>

    {{-- IDENTITAS PASIEN (Menggunakan class 'patient-table' dan struktur Medis: Tgl Lahir format 'd M Y' & Kolom Umur) --}}
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
            <th>Umur</th>
            <td>{{ $pasien->umur ?? '-' }} Tahun</td>
        </tr>
    </table>

    {{-- 1. DATA MASUK --}}
    <div class="section-title">1. DATA MASUK</div>
    <table>
        <tr>
            <td width="20%"><strong>Petugas</strong></td>
            <td width="30%">: {{ $asesmen->user->name ?? '-' }}</td>
            <td width="20%"><strong>Cara Masuk</strong></td>
            <td width="30%">: {{ $kepAnak->cara_masuk ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Waktu</strong></td>
            <td>: {{ date('d-m-Y H:i', strtotime($asesmen->waktu_asesmen)) }}</td>
            <td><strong>Kasus Trauma</strong></td>
            <td>: {{ $kepAnak->kasus_trauma ?? '-' }}</td>
        </tr>
    </table>

    {{-- 2. ANAMNESIS --}}
    <div class="section-title">2. ANAMNESIS</div>
    <table class="bordered-table">
        <tr>
            <td width="25%"><strong>Anamnesis</strong></td>
            <td>{{ $kepAnak->anamnesis ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Keluhan Utama</strong></td>
            <td>{{ $kepAnak->keluhan_utama ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Riw. Kesehatan Sekarang</strong></td>
            <td>{{ $kepAnak->riwayat_kesehatan_sekarang ?? '-' }}</td>
        </tr>
    </table>

    {{-- 3. PEMERIKSAAN FISIK --}}
    <div class="section-title">3. PEMERIKSAAN FISIK</div>

    {{-- TTV --}}
    <table class="bordered-table" style="margin-bottom: 10px;">
        <tr>
            <td width="25%"><strong>TD:</strong> {{ $fisik->sistole ?? '-' }}/{{ $fisik->diastole ?? '-' }} mmHg
            </td>
            <td width="25%"><strong>Nadi:</strong> {{ $fisik->nadi ?? '-' }} x/menit</td>
            <td width="25%"><strong>Nafas:</strong> {{ $fisik->nafas ?? '-' }} x/menit</td>
            <td width="25%"><strong>Suhu:</strong> {{ $fisik->suhu ?? '-' }} °C</td>
        </tr>
        <tr>
            <td colspan="4"><strong>Saturasi O2:</strong> Tanpa bantuan ({{ $fisik->spo2_tanpa_bantuan ?? '-' }}%) |
                Dengan bantuan ({{ $fisik->spo2_dengan_bantuan ?? '-' }}%)</td>
        </tr>
    </table>

    {{-- Split Layout for Status --}}
    <table width="100%">
        <tr>
            <td width="50%" valign="top" style="padding-right: 5px;">
                <p class="text-bold mb-1" style="border-bottom: 1px solid #000;">A. Kesadaran & Status Mental</p>
                <table class="bordered-table">
                    <tr>
                        <td width="40%">Kesadaran</td>
                        <td>{{ $fisik->kesadaran ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>GCS</td>
                        <td>{{ $kepAnak->gcs ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Penglihatan</td>
                        <td>{{ ['1' => 'Baik', '2' => 'Rusak', '3' => 'Alat Bantu'][$fisik->penglihatan ?? 0] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pendengaran</td>
                        <td>{{ ['1' => 'Baik', '2' => 'Rusak', '3' => 'Alat Bantu'][$fisik->pendengaran ?? 0] ?? '-' }}
                        </td>
                    </tr>
                </table>

                <p class="text-bold mb-1 mt-2" style="border-bottom: 1px solid #000;">B. Status Komunikasi</p>
                <table class="bordered-table">
                    <tr>
                        <td width="40%">Bicara</td>
                        <td>{{ ['1' => 'Normal', '2' => 'Gangguan'][$fisik->bicara ?? 0] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Refleks Menelan</td>
                        <td>{{ ['1' => 'Normal', '2' => 'Sulit', '3' => 'Rusak'][$fisik->refleksi_menelan ?? 0] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pola Tidur</td>
                        <td>{{ ['1' => 'Normal', '2' => 'Masalah'][$fisik->pola_tidur ?? 0] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Luka</td>
                        <td>{{ ['1' => 'Normal', '2' => 'Gangguan', '3' => 'Tidak Ada Luka'][$fisik->luka ?? 0] ?? '-' }}
                        </td>
                    </tr>
                </table>
                <p class="text-bold mb-1" style="border-bottom: 1px solid #000;">C. Status Eliminasi</p>
                <table class="bordered-table">
                    <tr>
                        <td width="40%">Defekasi</td>
                        <td>{{ ['1' => 'Tidak Ada', '2' => 'Normal', '3' => 'Konstipasi', '4' => 'Inkontinensia'][$fisik->defekasi ?? 0] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Miksi</td>
                        <td>{{ ['1' => 'Normal', '2' => 'Retensio', '3' => 'Inkontinensia'][$fisik->miksi ?? 0] ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Gastrointestinal</td>
                        <td>{{ ['1' => 'Normal', '2' => 'Nausea', '3' => 'Muntah'][$fisik->gastroentestinal ?? 0] ?? '-' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <p class="text-bold mb-1 mt-2">D. Riwayat Kelahiran & Perkembangan</p>
    <table class="bordered-table">
        <tr>
            <td width="50%"><strong>Lahir Umur Kehamilan:</strong> {{ $fisik->lahir_umur_kehamilan ?? '-' }}</td>
            <td width="50%"><strong>ASI Sampai Umur:</strong> {{ $fisik->asi_Sampai_Umur ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Alasan Berhenti Menyusui:</strong> {{ $fisik->alasan_berhenti_menyusui ?? '-' }}</td>
            <td><strong>Masalah Neonatus:</strong> {{ $fisik->masalah_neonatus ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Kelainan Kongenital:</strong> {{ $fisik->kelainan_kongenital ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Motorik:</strong>
                Tengkurap ({{ $fisik->tengkurap ?? '-' }}) |
                Merangkak ({{ $fisik->merangkak ?? '-' }}) |
                Duduk ({{ $fisik->duduk ?? '-' }}) |
                Berdiri ({{ $fisik->berdiri ?? '-' }})
            </td>
        </tr>
    </table>

    <p class="text-bold mb-1 mt-2">E. Antropometri</p>
    <table class="bordered-table">
        <tr>
            <td>TB: {{ $fisik->tinggi_badan ?? '-' }} cm</td>
            <td>BB: {{ $fisik->berat_badan ?? '-' }} kg</td>
            <td>LK: {{ $fisik->lingkar_kepala ?? '-' }} cm</td>
            <td>IMT: {{ $fisik->imt ?? '-' }}</td>
            <td>LPT: {{ $fisik->lpt ?? '-' }}</td>
        </tr>
    </table>

    {{-- Pemeriksaan Fisik Menyeluruh --}}
    <p class="text-bold mb-1 mt-2">F. Hasil Pemeriksaan Fisik Menyeluruh</p>
    <table class="bordered-table" style="font-size: 7pt;">
        @php
            $pemeriksaanFisikData = $asesmen->pemeriksaanFisik ?? collect([]);
        @endphp
        @if ($pemeriksaanFisikData->count() > 0)
            @foreach ($pemeriksaanFisikData->chunk(2) as $chunk)
                <tr>
                    @foreach ($chunk as $item)
                        <td width="20%">{{ $item->itemFisik->nama ?? '' }}</td>
                        <td width="30%">
                            @if ($item->is_normal)
                                <b>Normal</b>
                            @else
                                @if ($item->keterangan)
                                    <b>Tidak Normal:</b> {{ $item->keterangan }}
                                @else
                                    <i>Tidak Diperiksa</i>
                                @endif
                            @endif
                        </td>
                    @endforeach
                    @if ($chunk->count() < 2)
                        <td colspan="2"></td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4">Tidak ada data pemeriksaan fisik menyeluruh.</td>
            </tr>
        @endif
    </table>

    {{-- 4. STATUS NYERI --}}
    <div class="section-title">4. STATUS NYERI</div>
    @php
        $nyeri = $asesmen->rmeAsesmenKepAnakStatusNyeri ?? null;
        $skalaNyeri = ['1' => 'NRS', '2' => 'FLACC', '3' => 'CRIES'][$nyeri->jenis_skala_nyeri ?? 0] ?? '-';
    @endphp
    <table class="bordered-table">
        <tr>
            <td width="20%"><strong>Metode</strong></td>
            <td width="30%">: {{ $skalaNyeri }}</td>
            <td width="20%"><strong>Nilai (Skor)</strong></td>
            <td width="30%">: {{ $nyeri->nilai_nyeri ?? '0' }} ({{ $nyeri->kesimpulan_nyeri ?? '-' }})</td>
        </tr>
    </table>
    <table class="bordered-table" style="margin-top:5px; width: 100%; table-layout: fixed;">
        <tr>
            <th width="20%">Lokasi</th>
            <th width="20%">Durasi</th>
            <th width="20%">Jenis Nyeri</th>
            <th width="20%">Frekuensi</th>
            <th width="20%">Kualitas</th>
        </tr>
        <tr>
            <td>{{ $nyeri->lokasi ?? '-' }}</td>
            <td>{{ $nyeri->durasi ?? '-' }}</td>
            <td>{{ $nyeri->jenisNyeriRelasi->name ?? '-' }}</td>
            <td>{{ $nyeri->frekuensiRelasi->name ?? '-' }}</td>
            <td>{{ $nyeri->kualitasRelasi->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Menjalar</th>
            <th>Faktor Pemberat</th>
            <th>Faktor Peringan</th>
            <th colspan="2">Efek Nyeri</th>
        </tr>
        <tr>
            <td>{{ $nyeri->menjalarRelasi->name ?? '-' }}</td>
            <td>{{ $nyeri->faktorPemberatRelasi->name ?? '-' }}</td>
            <td>{{ $nyeri->faktorPeringanRelasi->name ?? '-' }}</td>
            <td colspan="2">{{ $nyeri->efekNyeriRelasi->name ?? '-' }}</td>
        </tr>
        </tr>
    </table>

    {{-- 5. RIWAYAT KESEHATAN --}}
    <div class="section-title">5. RIWAYAT KESEHATAN</div>
    @php $rk = $asesmen->rmeAsesmenKepAnakRiwayatKesehatan; @endphp
    <table class="bordered-table">
        <tr>
            <td width="30%"><strong>Penyakit Pernah Diderita</strong></td>
            <td>{{ implode(', ', json_decode($rk->penyakit_yang_diderita ?? '[]')) ?: '-' }}</td>
        </tr>
        <tr>
            <td><strong>Riwayat Kecelakaan</strong></td>
            <td>{{ implode(', ', json_decode($rk->riwayat_kecelakaan_lalu ?? '[]')) ?: '-' }}</td>
        </tr>
        <tr>
            <td><strong>Riwayat Rawat Inap</strong></td>
            <td>
                {{ $rk->riwayat_rawat_inap ?? 0 ? 'Ya' : 'Tidak' }}
                @if ($rk->tanggal_riwayat_rawat_inap)
                    (Tgl: {{ \Carbon\Carbon::parse($rk->tanggal_riwayat_rawat_inap)->format('d-m-Y') }})
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Riwayat Operasi</strong></td>
            <td>{{ $rk->riwayat_operasi ?? '-' }} ({{ implode(', ', json_decode($rk->nama_operasi ?? '[]')) }})</td>
        </tr>
        <tr>
            <td><strong>Tumbuh Kembang vs Saudara</strong></td>
            <td>{{ $rk->tumbuh_kembang ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Riwayat Kes. Keluarga</strong></td>
            <td>{{ implode(', ', json_decode($rk->riwayat_penyakit_keluarga ?? '[]')) ?: '-' }}</td>
        </tr>
        <tr>
            <td><strong>Konsumsi Obat-obatan</strong></td>
            <td>{{ $rk->konsumsi_obat ?? '-' }}</td>
        </tr>
    </table>

    {{-- 6. ALERGI --}}
    <div class="section-title">6. ALERGI</div>
    @php
        $alergis = \App\Models\RmeAlergiPasien::where('kd_pasien', $pasien->kd_pasien)->get();
    @endphp
    @if ($alergis->count() > 0)
        <table class="bordered-table">
            <tr>
                <th>Jenis</th>
                <th>Alergen</th>
                <th>Reaksi</th>
                <th>Keparahan</th>
            </tr>
            @foreach ($alergis as $al)
                <tr>
                    <td>{{ $al->jenis_alergi }}</td>
                    <td>{{ $al->nama_alergi }}</td>
                    <td>{{ $al->reaksi }}</td>
                    <td>{{ $al->tingkat_keparahan }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>Tidak ada riwayat alergi.</p>
    @endif

    {{-- 7. RISIKO JATUH --}}
    <div class="section-title">7. RISIKO JATUH</div>
    @php $rj = $asesmen->rmeAsesmenKepAnakRisikoJatuh; @endphp
    <p><strong>Metode Penilaian:</strong>
        {{ ['1' => 'Umum', '2' => 'Morse', '3' => 'Humpty Dumpty', '4' => 'Ontario/Lansia', '5' => 'Lainnya'][$rj->resiko_jatuh_jenis ?? 0] ?? '-' }}
    </p>

    @if (($rj->resiko_jatuh_jenis ?? 0) == 2)
        {{-- Tabel Morse (Menjawab permintaan field yang hilang) --}}
        <table class="bordered-table">
            <tr>
                <th width="70%">Parameter</th>
                <th>Hasil</th>
            </tr>
            <tr>
                <td>Riwayat Jatuh (baru saja atau dlm 3 bulan terakhir)</td>
                <td>{{ ($rj->risiko_jatuh_morse_riwayat_jatuh ?? 0) == 25 ? 'Ya (25)' : 'Tidak (0)' }}</td>
            </tr>
            <tr>
                <td>Diagnosis Sekunder (lebih dari satu diagnosa)</td>
                <td>{{ ($rj->risiko_jatuh_morse_diagnosis_sekunder ?? 0) == 15 ? 'Ya (15)' : 'Tidak (0)' }}</td>
            </tr>
            <tr>
                <td>Alat Bantu</td>
                <td>
                    @php $ab = $rj->risiko_jatuh_morse_bantuan_ambulasi ?? 0; @endphp
                    {{ $ab == 30 ? 'Meja/Kursi (30)' : ($ab == 15 ? 'Tongkat/Alat Bantu (15)' : 'Tidak ada/Bedrest/Perawat (0)') }}
                </td>
            </tr>
            <tr>
                <td>Terpasang Infus</td>
                <td>{{ ($rj->risiko_jatuh_morse_terpasang_infus ?? 0) == 20 ? 'Ya (20)' : 'Tidak (0)' }}</td>
            </tr>
            <tr>
                <td>Cara Berjalan</td>
                <td>
                    @php $cb = $rj->risiko_jatuh_morse_cara_berjalan ?? 0; @endphp
                    {{ $cb == 20 ? 'Terganggu (20)' : ($cb == 10 ? 'Lemah (10)' : 'Normal/Bedrest (0)') }}
                </td>
            </tr>
            <tr>
                <td>Status Mental</td>
                <td>{{ ($rj->risiko_jatuh_morse_status_mental ?? 0) == 15 ? 'Lupa Keterbatasan (15)' : 'Orientasi Baik (0)' }}
                </td>
            </tr>
        </table>
        <p><strong>Kesimpulan:</strong> {{ $rj->kesimpulan_skala_morse ?? '-' }}</p>
    @elseif(($rj->resiko_jatuh_jenis ?? 0) == 3)
        {{-- Tabel Humpty Dumpty --}}
        <table class="bordered-table">
            <tr>
                <th width="70%">Parameter</th>
                <th>Skor</th>
            </tr>
            <tr>
                <td>Usia</td>
                <td>{{ [4 => '<3 th', 3 => '3-7 th', 2 => '7-13 th', 1 => '>13 th'][$rj->risiko_jatuh_pediatrik_usia_anak ?? 0] ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>{{ ($rj->risiko_jatuh_pediatrik_jenis_kelamin ?? 0) == 2 ? 'Laki-laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
                <td>Diagnosis</td>
                <td>{{ [4 => 'Neurologis', 3 => 'Oksigenasi', 2 => 'Psikiatri', 1 => 'Lainnya'][$rj->risiko_jatuh_pediatrik_diagnosis ?? 0] ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>Ggn Kognitif</td>
                <td>{{ [3 => 'Tdk Menyadari', 2 => 'Lupa', 1 => 'Orientasi Baik'][$rj->risiko_jatuh_pediatrik_gangguan_kognitif ?? 0] ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>Lingkungan</td>
                <td>{{ [4 => 'Riw. Jatuh', 3 => 'Alat Bantu', 2 => 'Bed', 1 => 'Luar RS'][$rj->risiko_jatuh_pediatrik_faktor_lingkungan ?? 0] ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>Sedasi/Op</td>
                <td>{{ [3 => '<24 jam', 2 => '<48 jam', 1 => '>48 jam'][$rj->risiko_jatuh_pediatrik_pembedahan ?? 0] ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>Obat</td>
                <td>{{ [3 => 'Multiple', 2 => 'Salah satu', 1 => 'Lainnya'][$rj->risiko_jatuh_pediatrik_penggunaan_mentosa ?? 0] ?? '-' }}
                </td>
            </tr>
        </table>
        <p><strong>Kesimpulan:</strong> {{ $rj->kesimpulan_skala_pediatrik ?? '-' }}</p>
    @else
        <p>Detail tabel untuk jenis skala ini tidak ditampilkan (Lihat Sistem).</p>
        <p><strong>Kesimpulan:</strong> {{ $rj->kesimpulan_skala_umum ?? ($rj->kesimpulan_skala_lansia ?? '-') }}</p>
    @endif

    <p><strong>Intervensi Risiko Jatuh:</strong></p>
    <ul style="margin-top:0;">
        @forelse(json_decode($rj->intervensi_risiko_jatuh ?? '[]') as $item)
            <li>{{ $item }}</li>
        @empty
            <li>-</li>
        @endforelse
    </ul>

    {{-- 8. RISIKO DEKUBITUS --}}
    <div class="section-title">8. RISIKO DEKUBITUS</div>
    @php
        $rd = $asesmen->rmeAsesmenKepAnakResikoDekubitus;
        $jenisSkala = $rd->jenis_skala ?? 0;
    @endphp

    <p><strong>Jenis Skala Dekubitus :</strong>
        {{ $jenisSkala == 1 ? 'Skala Norton' : ($jenisSkala == 2 ? 'Skala Braden' : '-') }}</p>

    @if ($jenisSkala == 1)
        {{-- Logika Mapping Norton --}}
        @php
            $nortonFisik = [4 => 'Baik (4)', 3 => 'Sedang (3)', 2 => 'Buruk (2)', 1 => 'Sangat Buruk (1)'];
            $nortonMental = [4 => 'Sadar (4)', 3 => 'Apatis (3)', 2 => 'Bingung (2)', 1 => 'Stupor (1)'];
            $nortonAktivitas = [
                4 => 'Aktif (4)',
                3 => 'Jalan dengan bantuan (3)',
                2 => 'Terbatas di kursi (2)',
                1 => 'Terbatas di tempat tidur (1)',
            ];
            $nortonMobilitas = [
                4 => 'Bebas bergerak (4)',
                3 => 'Agak terbatas (3)',
                2 => 'Sangat terbatas (2)',
                1 => 'Tidak dapat bergerak (1)',
            ];
            $nortonInkontinensia = [
                4 => 'Tidak ada (4)',
                3 => 'Kadang-kadang (3)',
                2 => 'Biasanya urin (2)',
                1 => 'Urin dan feses (1)',
            ];

            $totalNorton =
                ($rd->norton_kondisi_fisik ?? 0) +
                ($rd->norton_kondisi_mental ?? 0) +
                ($rd->norton_aktivitas ?? 0) +
                ($rd->norton_mobilitas ?? 0) +
                ($rd->norton_inkontenesia ?? 0);
        @endphp

        <table class="bordered-table">
            <tr>
                <th width="20%">Kondisi Fisik</th>
                <th width="20%">Mental</th>
                <th width="20%">Aktivitas</th>
                <th width="20%">Mobilitas</th>
                <th width="20%">Inkontinensia</th>
            </tr>
            <tr>
                <td>{{ $nortonFisik[$rd->norton_kondisi_fisik ?? 0] ?? '-' }}</td>
                <td>{{ $nortonMental[$rd->norton_kondisi_mental ?? 0] ?? '-' }}</td>
                <td>{{ $nortonAktivitas[$rd->norton_aktivitas ?? 0] ?? '-' }}</td>
                <td>{{ $nortonMobilitas[$rd->norton_mobilitas ?? 0] ?? '-' }}</td>
                <td>{{ $nortonInkontinensia[$rd->norton_inkontenesia ?? 0] ?? '-' }}</td>
            </tr>
        </table>
        <p><strong>Total Skor:</strong> {{ $totalNorton }} | <strong>Kesimpulan:</strong>
            {{ $rd->decubitus_kesimpulan ?? '-' }}</p>
    @elseif($jenisSkala == 2)
        {{-- Logika Mapping Braden --}}
        @php
            $bradenSensori = [
                1 => 'Keterbatasan Penuh (1)',
                2 => 'Sangat Terbatas (2)',
                3 => 'Keterbatasan Ringan (3)',
                4 => 'Tidak Ada Gangguan (4)',
            ];
            $bradenKelembapan = [
                1 => 'Selalu Lembap (1)',
                2 => 'Umumnya Lembap (2)',
                3 => 'Kadang-Kadang Lembap (3)',
                4 => 'Jarang Lembap (4)',
            ];
            $bradenAktivitas = [
                1 => 'Total di Tempat Tidur (1)',
                2 => 'Dapat Duduk (2)',
                3 => 'Berjalan Kadang-kadang (3)',
                4 => 'Dapat Berjalan-jalan (4)',
            ];
            $bradenMobilitas = [
                1 => 'Tidak Mampu Bergerak (1)',
                2 => 'Sangat Terbatas (2)',
                3 => 'Tidak Ada Masalah (3)',
                4 => 'Tanpa Keterbatasan (4)',
            ];
            $bradenNutrisi = [
                1 => 'Sangat Buruk (1)',
                2 => 'Kurang Mencukupi (2)',
                3 => 'Mencukupi (3)',
                4 => 'Sangat Baik (4)',
            ];
            $bradenGesekan = [1 => 'Bermasalah (1)', 2 => 'Potensial Bermasalah (2)', 3 => 'Keterbatasan Ringan (3)'];

            $totalBraden =
                ($rd->braden_persepsi ?? 0) +
                ($rd->braden_kelembapan ?? 0) +
                ($rd->braden_aktivitas ?? 0) +
                ($rd->braden_mobilitas ?? 0) +
                ($rd->braden_nutrisi ?? 0) +
                ($rd->braden_pergesekan ?? 0);
        @endphp

        <table class="bordered-table">
            <tr>
                <th width="16%">Sensori</th>
                <th width="16%">Kelembapan</th>
                <th width="16%">Aktivitas</th>
                <th width="16%">Mobilitas</th>
                <th width="16%">Nutrisi</th>
                <th width="20%">Pergesekan</th>
            </tr>
            <tr>
                <td>{{ $bradenSensori[$rd->braden_persepsi ?? 0] ?? '-' }}</td>
                <td>{{ $bradenKelembapan[$rd->braden_kelembapan ?? 0] ?? '-' }}</td>
                <td>{{ $bradenAktivitas[$rd->braden_aktivitas ?? 0] ?? '-' }}</td>
                <td>{{ $bradenMobilitas[$rd->braden_mobilitas ?? 0] ?? '-' }}</td>
                <td>{{ $bradenNutrisi[$rd->braden_nutrisi ?? 0] ?? '-' }}</td>
                <td>{{ $bradenGesekan[$rd->braden_pergesekan ?? 0] ?? '-' }}</td>
            </tr>
        </table>
        <p><strong>Total Skor:</strong> {{ $totalBraden }} | <strong>Kesimpulan:</strong>
            {{ $rd->decubitus_kesimpulan ?? '-' }}</p>
    @endif

    {{-- 9. STATUS PSIKOLOGIS --}}
    <div class="section-title">9. STATUS PSIKOLOGIS</div>
    @php $psi = $asesmen->rmeAsesmenKepAnakStatusPsikologis; @endphp
    <table class="bordered-table">
        <tr>
            <td width="30%"><strong>Kondisi Psikologis</strong></td>
            <td>
                @foreach (json_decode($psi->kondisi_psikologis ?? '[]') as $k)
                    <span class="badge">{{ $k }}</span>
                @endforeach
            </td>
        </tr>
        <tr>
            <td><strong>Gangguan Perilaku</strong></td>
            <td>
                @foreach (json_decode($psi->gangguan_perilaku ?? '[]') as $g)
                    <span class="badge">{{ $g }}</span>
                @endforeach
            </td>
        </tr>
        <tr>
            <td><strong>Potensi Menyakiti</strong></td>
            <td>{{ ($psi->potensi_menyakiti ?? -1) === 0 ? 'Ya' : (($psi->potensi_menyakiti ?? -1) === 1 ? 'Tidak' : '-') }}
            </td>
        </tr>
        <tr>
            <td><strong>Kel. Gangguan Jiwa</strong></td>
            <td>{{ ($psi->keluarga_gangguan_jiwa ?? -1) === 0 ? 'Ya' : (($psi->keluarga_gangguan_jiwa ?? -1) === 1 ? 'Tidak' : '-') }}
            </td>
        </tr>
        <tr>
            <td><strong>Lainnya</strong></td>
            <td>{{ $psi->lainnya ?? '-' }}</td>
        </tr>
    </table>

    {{-- 10. STATUS SPIRITUAL --}}
    <div class="section-title">10. STATUS SPIRITUAL</div>
    <table class="bordered-table">
        <tr>
            <td width="30%"><strong>Agama</strong></td>
            <td>{{ $kepAnak->agama ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Pandangan thd Penyakit</strong></td>
            <td>{{ $kepAnak->pandangan_terhadap_penyakit ?? '-' }}</td>
        </tr>
    </table>

    {{-- 11. STATUS SOSIAL EKONOMI --}}
    <div class="section-title">11. STATUS SOSIAL EKONOMI</div>
    @php $sos = $asesmen->rmeAsesmenKepAnakSosialEkonomi; @endphp
    <table class="bordered-table">
        <tr>
            <td width="25%"><strong>Pekerjaan:</strong> {{ $sos->sosial_ekonomi_pekerjaan ?? '-' }}</td>
            <td width="25%"><strong>Status Nikah:</strong> {{ $sos->sosial_ekonomi_status_pernikahan ?? '-' }}
            </td>
            <td width="50%"><strong>Tempat Tinggal:</strong> {{ $sos->sosial_ekonomi_tempat_tinggal ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Curiga Penganiayaan:</strong>
                {{ $sos->sosial_ekonomi_curiga_penganiayaan ?? '-' }}</td>
            <td><strong>Tinggal dgn Keluarga:</strong> {{ $sos->sosial_ekonomi_tinggal_dengan_keluarga ?? '-' }}</td>
        </tr>
    </table>

    {{-- 12. STATUS GIZI --}}
    <div class="section-title">12. STATUS GIZI</div>
    @php
        $gizi = $asesmen->rmeAsesmenKepAnakGizi;
        $jGizi = $gizi->gizi_jenis ?? 0;
    @endphp
    <p><strong>Metode:</strong> {{ [1 => 'MST', 2 => 'MNA', 3 => 'Strong Kids', 4 => 'NRS'][$jGizi] ?? '-' }}</p>

    @if ($jGizi == 1)
        {{-- MST --}}
        <table class="bordered-table">
            <tr>
                <td>Turun BB 6 bln</td>
                <td>{{ [0 => 'Tidak', 2 => 'Ragu', 3 => 'Ya'][$gizi->gizi_mst_penurunan_bb ?? 0] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jml Turun</td>
                <td>{{ [0 => '0', 1 => '1-5kg', 2 => '6-10kg', 3 => '11-15kg', 4 => '>15kg'][$gizi->gizi_mst_jumlah_penurunan_bb ?? 0] ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>Nafsu Makan </td>
                <td>{{ ($gizi->gizi_mst_nafsu_makan_berkurang ?? 0) == 1 ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td>Diagnosis Khusus</td>
                <td>{{ ($gizi->gizi_mst_diagnosis_khusus ?? 0) == 1 ? 'Ya' : 'Tidak' }}</td>
        </table>
        <p><strong>Kesimpulan:</strong> {{ $gizi->gizi_mst_kesimpulan ?? '-' }}</p>
    @elseif($jGizi == 3)
        {{-- Strong Kids --}}
        <table class="bordered-table">
            <tr>
                <td>Tampak Kurus</td>
                <td>{{ ($gizi->gizi_strong_status_kurus ?? 0) == 1 ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td>Turun BB 1 bln</td>
                <td>{{ ($gizi->gizi_strong_penurunan_bb ?? 0) == 1 ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td>Diare/Muntah</td>
                <td>{{ ($gizi->gizi_strong_gangguan_pencernaan ?? 0) == 1 ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td>Penyakit Risiko</td>
                <td>{{ ($gizi->gizi_strong_penyakit_berisiko ?? 0) == 1 ? 'Ya' : 'Tidak' }}</td>
            </tr>
        </table>
        <p><strong>Kesimpulan:</strong> {{ $gizi->gizi_strong_kesimpulan ?? '-' }}</p>
    @else
        <p><strong>Kesimpulan:</strong> {{ $gizi->gizi_mna_kesimpulan ?? '-' }}</p>
    @endif

    {{-- 13. STATUS FUNGSIONAL --}}
    <div class="section-title">13. STATUS FUNGSIONAL</div>
    @php $fung = $asesmen->rmeAsesmenKepAnakStatusFungsional; @endphp
    <p><strong>Skala:</strong> {{ ($fung->jenis_skala ?? 0) == 1 ? 'ADL' : '-' }}</p>
    <p><strong>Kesimpulan (Makan/ADL):</strong> {{ $fung->kesimpulan ?? '-' }}</p>

    {{-- 14. KEBUTUHAN EDUKASI --}}
    <div class="section-title">14. EDUKASI & KOMUNIKASI</div>
    <table class="bordered-table">
        <tr>
            <td><strong>Gaya Bicara:</strong> {{ $kepAnak->gaya_bicara ?? '-' }}</td>
            <td><strong>Bahasa:</strong> {{ $kepAnak->bahasa ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Penerjemah:</strong> {{ $kepAnak->perlu_penerjemahan ?? '-' }}</td>
            <td><strong>Hambatan:</strong> {{ $kepAnak->hambatan_komunikasi ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Media:</strong> {{ $kepAnak->media_disukai ?? '-' }}</td>
            <td><strong>Pendidikan:</strong> {{ $kepAnak->tingkat_pendidikan ?? '-' }}</td>
        </tr>
    </table>

    {{-- 15. DISCHARGE PLANNING --}}
    <div class="section-title">15. DISCHARGE PLANNING</div>
    @php $dp = $asesmen->rmeAsesmenKepAnakRencanaPulang; @endphp
    <table class="bordered-table">
        <tr>
            <td width="50%">
                Usia Lanjut: {{ ($dp->usia_lanjut ?? -1) == 0 ? 'Ya' : 'Tidak' }}<br>
                Hambatan Mobilisasi: {{ ($dp->hambatan_mobilisasi ?? -1) == 0 ? 'Ya' : 'Tidak' }}<br>
                Pelayanan Medis Berkelanjutan: {{ $dp->membutuhkan_pelayanan_medis ?? '-' }}<br>
                Keterampilan Khusus: {{ $dp->memerlukan_keterampilan_khusus ?? '-' }}
            </td>
            <td width="50%">
                Alat Bantu: {{ $dp->memerlukan_alat_bantu ?? '-' }}<br>
                Nyeri Kronis: {{ $dp->memiliki_nyeri_kronis ?? '-' }}<br>
                Ketergantungan Aktivitas: {{ $dp->ketergantungan_aktivitas ?? '-' }}<br>
                Lama Rawat: {{ $dp->perkiraan_lama_dirawat ?? '-' }} Hari<br>
                Rencana Pulang:
                {{ $dp->rencana_pulang ? \Carbon\Carbon::parse($dp->rencana_pulang)->format('d-m-Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="2"><strong>Kesimpulan:</strong> {{ $dp->kesimpulan ?? '-' }}</td>
        </tr>
    </table>

    {{-- 16. DIAGNOSIS --}}
    <div class="section-title">16. MASALAH / DIAGNOSIS KEPERAWATAN</div>
    <table class="bordered-table">
        <thead>
            <tr>
                <th width="40%">DIAGNOSA</th>
                <th>RENCANA / INTERVENSI</th>
            </tr>
        </thead>
        <tbody>
            @php
                $diagSelected = $asesmen->rmeAsesmenKepAnakKeperawatan->diagnosis ?? [];

                // Mapping lengkap
                $mapping = [
                    'bersihan_jalan_nafas' => [
                        'title' => 'Bersihan jalan nafas tidak efektif',
                        'field' => 'rencana_bersihan_jalan_nafas',
                    ],
                    'risiko_aspirasi' => ['title' => 'Risiko Aspirasi', 'field' => 'rencana_bersihan_jalan_nafas'],
                    'pola_nafas_tidak_efektif' => [
                        'title' => 'Pola nafas tidak efektif',
                        'field' => 'rencana_bersihan_jalan_nafas',
                    ],

                    'penurunan_curah_jantung' => [
                        'title' => 'Penurunan curah jantung',
                        'field' => 'rencana_penurunan_curah_jantung',
                    ],
                    'perfusi_perifer' => [
                        'title' => 'Perfusi perifer tidak efektif',
                        'field' => 'rencana_perfusi_perifer',
                    ],
                    'hipovolemia' => ['title' => 'Hipovolemia', 'field' => 'rencana_hipovolemia'],
                    'hipervolemia' => ['title' => 'Hipervolemia', 'field' => 'rencana_hipervolemia'],
                    'diare' => ['title' => 'Diare', 'field' => 'rencana_diare'],
                    'retensi_urine' => ['title' => 'Retensi Urine', 'field' => 'rencana_retensi_urine'],
                    'nyeri_akut' => ['title' => 'Nyeri Akut', 'field' => 'rencana_nyeri_akut'],
                    'nyeri_kronis' => ['title' => 'Nyeri Kronis', 'field' => 'rencana_nyeri_kronis'],
                    'hipertermia' => ['title' => 'Hipertermia', 'field' => 'rencana_hipertermia'],
                    'gangguan_mobilitas_fisik' => [
                        'title' => 'Gangguan Mobilitas Fisik',
                        'field' => 'rencana_gangguan_mobilitas_fisik',
                    ],
                    'resiko_infeksi' => ['title' => 'Risiko Infeksi', 'field' => 'rencana_resiko_infeksi'],
                    'konstipasi' => ['title' => 'Konstipasi', 'field' => 'rencana_konstipasi'],
                    'resiko_jatuh' => ['title' => 'Risiko Jatuh', 'field' => 'rencana_resiko_jatuh'],
                    'gangguan_integritas_kulit' => [
                        'title' => 'Gangguan Integritas Kulit',
                        'field' => 'rencana_gangguan_integritas_kulit',
                    ],
                ];
            @endphp
            @forelse($diagSelected as $d)
                <tr>
                    <td><strong>{{ $mapping[$d]['title'] ?? ucfirst(str_replace('_', ' ', $d)) }}</strong></td>
                    <td>
                        @php
                            $field = $mapping[$d]['field'] ?? 'rencana_' . $d;
                            $intervensi = $asesmen->rmeAsesmenKepAnakKeperawatan->$field ?? [];
                        @endphp
                        @if (!empty($intervensi))
                            <ul style="margin: 0; padding-left: 15px;">
                                @foreach ($intervensi as $item)
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
                    <td colspan="2" class="text-center">Tidak ada diagnosis yang dipilih</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <table style="margin-top: 20px;">
        <tr>
            <td width="60%"></td>
            <td width="40%" class="text-center">
                Langsa, {{ \Carbon\Carbon::parse($asesmen->waktu_asesmen)->translatedFormat('d F Y') }} <br>
                Perawat Penanggung Jawab, <br><br>
                @if ($asesmen->user->name)
                    <img src="{{ generateQrCode($asesmen->user->name, 70, 'svg_datauri') }}" alt="QR"><br>
                @endif
                ( {{ $asesmen->user->name ?? '-' }} )
            </td>
        </tr>
    </table>
</body>

</html>
