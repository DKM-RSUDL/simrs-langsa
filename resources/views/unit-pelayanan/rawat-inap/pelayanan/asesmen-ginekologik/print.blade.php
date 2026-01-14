<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Medis Ginekologik - {{ $pasien->nama ?? '' }}</title>
    <style>
        @page {
            size: A4;
            margin: 3mm 6mm;
        }

        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8.5pt;
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
            padding: 4px 6px;
            vertical-align: top;
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

        .td-right {
            width: 20%;
            text-align: center;
            vertical-align: middle;
        }

        .brand-name {
            font-weight: 700;
            font-size: 14px;
            margin: 0;
        }

        .brand-info {
            font-size: 7px;
            margin: 0;
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
            text-align: center;
        }

        .unit-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
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

        .section-title {
            font-weight: bold;
            font-size: 11pt;
            padding: 8px 0 4px 0;
            border-bottom: 1px solid #000;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
            width: 35%;
        }

        .value {
            border-bottom: 0.5px dotted #000;
            min-height: 18px;
        }

        .table-border {
            border: 1px solid #000;
            margin-top: 5px;
        }

        .table-border th,
        .table-border td {
            border: 1px solid #000;
            padding: 4px;
        }

        .bg-gray {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    @php
        // Mapping Relasi dari Controller
        $ginek = $rmeAsesmenGinekologik;
        $vital = $rmeAsesmenGinekologikTandaVital;
        $fisikRadio = $asesmen->rmeAsesmenGinekologikPemeriksaanFisik;
        $ekstremitas = $rmeAsesmenGinekologikEkstremitasGinekologik;
        $discharge = $rmeAsesmenGinekologikPemeriksaanDischarge;
        $dxImpl = $rmeAsesmenGinekologikDiagnosisImplementasi;
        $pfDynamic = $asesmen->pemeriksaanFisik;

        // Logo RSUD Langsa
        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
        $logoData = @file_get_contents($logoPath);
        $logoBase64 = $logoData ? 'data:image/png;base64,' . base64_encode($logoData) : null;

        // Helper Decode JSON
        $decode = function ($val) {
            if (empty($val)) {
                return [];
            }
            $d = is_string($val) ? json_decode($val, true) : $val;
            return is_array($d) ? $d : [];
        };

        // Helper Normal/Abnormal
        $fmtNormal = function ($val, $ket = '') {
            if ($val === null || $val === '') {
                return '-';
            }
            return ($val == '1' ? 'Normal' : 'Abnormal') . ($ket ? ' (' . $ket . ')' : '');
        };

        // Prognosis Label
        $prognosisLabel = '-';
        if (!empty($ginek->paru_prognosis)) {
            $prognosisLabel =
                \App\Models\SatsetPrognosis::where('prognosis_id', $ginek->paru_prognosis)->value('value') ??
                $ginek->paru_prognosis;
        }
    @endphp

    <div class="a4">
        <table class="header-table">
            <tr>
                <td class="td-left">
                    <table>
                        <tr>
                            <td>
                                @if ($logoBase64)
                                    <img src="{{ $logoBase64 }}" style="width:70px;">
                                @endif
                            </td>
                            <td>
                                <p class="brand-name">RSUD Langsa</p>
                                <p class="brand-info">Jl. Jend. A. Yani No.1 Kota Langsa</p>
                                <p class="brand-info">Telp. 0641-22051, email: rsulangsa@gmail.com</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="td-center">
                    <span class="title-main">ASESMEN MEDIS GINEKOLOGIK</span>
                    <span class="title-sub">Pengkajian Awal
                        Medis Ginekologik</span>
                </td>
                <td class="td-right">
                    <div class="unit-box"><span class="unit-text">RAWAT INAP</span></div>
                </td>
            </tr>
        </table>

        <table class="patient-table">
            <tr>
                <th>No. RM</th>
                <td>{{ $pasien->kd_pasien ?? '-' }}</td>
                <th>Tgl. Lahir</th>
                <td>{{ !empty($pasien->tgl_lahir) ? date('d-m-Y', strtotime($pasien->tgl_lahir)) : '-' }}</td>
            </tr>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $pasien->nama ?? '-' }}</td>
                <th>Jenis Kelamin</th>
                <td>{{ ($pasien->jenis_kelamin ?? '') == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
        </table>

        <div class="section-title">1. DATA MASUK</div>
        <table>
            <tr>
                <td class="label">Tanggal & Jam Pengisian</td>
                <td class="value">{{ !empty($ginek->tanggal) ? date('d-m-Y', strtotime($ginek->tanggal)) : '-' }} /
                    {{ $ginek->jam_masuk ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kondisi Masuk</td>
                <td class="value">{{ $ginek->kondisi_masuk ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Diagnosis Masuk</td>
                <td class="value">{{ $ginek->diagnosis_masuk ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">2. G/P/A (Gravida, Para, Abortus)</div>
        <table style="text-align: center;">
            <tr>
                <td style="border: 1px solid #ccc;"><strong>G:</strong> {{ $ginek->gravida ?? '0' }}</td>
                <td style="border: 1px solid #ccc;"><strong>P:</strong> {{ $ginek->para ?? '0' }}</td>
                <td style="border: 1px solid #ccc;"><strong>A:</strong> {{ $ginek->abortus ?? '0' }}</td>
            </tr>
        </table>

        <div class="section-title">3. KELUHAN UTAMA & RIWAYAT HAID</div>
        <table>
            <tr>
                <td class="label">Keluhan Utama</td>
                <td class="value">{{ $ginek->keluhan_utama ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Riwayat Penyakit</td>
                <td class="value">{{ $ginek->riwayat_penyakit ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 5px 0;">
                    <strong>Riwayat Haid:</strong> Siklus: {{ $ginek->siklus ?? '-' }} Hari |
                    HPHT: {{ !empty($ginek->hpht) ? date('d-m-Y', strtotime($ginek->hpht)) : '-' }} |
                    Usia Kehamilan: {{ $ginek->usia_kehamilan_display ?? '-' }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <strong>Perkawinan:</strong> Jumlah: {{ $ginek->jumlah ?? '0' }} Kali |
                    Dengan Suami Sekarang: {{ $ginek->tahun ?? '-' }} |
                    Jumlah Suami: {{ $ginek->jumlah_suami ?? '0' }}
                </td>
            </tr>
        </table>

        <div class="section-title">4. RIWAYAT OBSTETRIK</div>
        <table class="table-border">
            <tr class="bg-gray">
                <th>Keadaan</th>
                <th>Cara Persalinan</th>
                <th>Nifas</th>
                <th>Tgl Lahir</th>
                <th>Keadaan Anak</th>
                <th>Penolong</th>
            </tr>
            @forelse($decode($ginek->riwayat_obstetrik) as $obs)
                <tr>
                    <td>{{ $obs['keadaan'] ?? '-' }}</td>
                    <td>{{ $obs['cara_persalinan'] ?? '-' }}</td>
                    <td>{{ $obs['keadaan_nifas'] ?? '-' }}</td>
                    <td>{{ $obs['tanggal_lahir'] ?? '-' }}</td>
                    <td>{{ $obs['keadaan_anak'] ?? '-' }}</td>
                    <td>{{ $obs['tempat_penolong'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Tidak ada riwayat obstetrik</td>
                </tr>
            @endforelse
        </table>

        <div class="section-title">5. RIWAYAT PENYAKIT DAHULU (Termasuk Operasi & KB)</div>
        <div style="min-height: 40px; border: 0.5px solid #ccc; padding: 5px;">
            {{ $ginek->riwayat_penyakit_dahulu ?? '-' }}</div>

        <div class="section-title">6. TANDA VITAL</div>
        <table class="table-border">
            <tr>
                <td width="25%"><strong>TD:</strong>
                    {{ $vital->tekanan_darah_sistole ?? '-' }}/{{ $vital->tekanan_darah_diastole ?? '-' }} mmHg</td>
                <td width="25%"><strong>Suhu:</strong> {{ $vital->suhu ?? '-' }} °C</td>
                <td width="25%"><strong>Nadi:</strong> {{ $vital->nadi ?? '-' }} x/mnt</td>
                <td width="25%"><strong>Respirasi:</strong> {{ $vital->respirasi ?? '-' }} x/mnt</td>
            </tr>
            <tr>
                <td><strong>Sat. O2:</strong> {{ $vital->nafas ?? '-' }} %</td>
                <td><strong>BB:</strong> {{ $vital->berat_badan ?? '-' }} kg</td>
                <td><strong>TB:</strong> {{ $vital->tinggi_badan ?? '-' }} cm</td>
                <td></td>
            </tr>
        </table>

        <div class="section-title">7. PEMERIKSAAN FISIK</div>
        <table class="table-border">
            <tr>
                <td width="30%"><strong>Kesadaran</strong></td>
                <td colspan="3">{{ $fisikRadio->paru_kesadaran ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Kepala</strong></td>
                <td>{{ $fmtNormal($fisikRadio->kepala, $fisikRadio->kepala_keterangan) }}</td>
                <td><strong>Leher</strong></td>
                <td>{{ $fmtNormal($fisikRadio->leher, $fisikRadio->leher_keterangan) }}</td>
            </tr>
            <tr>
                <td><strong>Mata</strong></td>
                <td>{{ $fmtNormal($fisikRadio->mata, $fisikRadio->mata_keterangan) }}</td>
                <td><strong>Tenggorokan</strong></td>
                <td>{{ $fmtNormal($fisikRadio->tenggorokan, $fisikRadio->tenggorokan_keterangan) }}</td>
            </tr>
            <tr>
                <td><strong>Hidung</strong></td>
                <td>{{ $fmtNormal($fisikRadio->hidung, $fisikRadio->hidung_keterangan) }}</td>
                <td><strong>Mulut/Gigi</strong></td>
                <td>{{ $fmtNormal($fisikRadio->mulut_gigi, $fisikRadio->mulut_gigi_keterangan) }}</td>
            </tr>
            <tr>
                <td><strong>Dada (Jantung)</strong></td>
                <td>{{ $fmtNormal($fisikRadio->jantung, $fisikRadio->jantung_keterangan) }}</td>
                <td><strong>Dada (Paru)</strong></td>
                <td>{{ $fmtNormal($fisikRadio->paru, $fisikRadio->paru_keterangan) }}</td>
            </tr>
            <tr>
                <td><strong>Perut (Hati)</strong></td>
                <td>{{ $fmtNormal($fisikRadio->hati, $fisikRadio->hati_keterangan) }}</td>
                <td><strong>Perut (Limpa)</strong></td>
                <td>{{ $fmtNormal($fisikRadio->limpa, $fisikRadio->limpa_keterangan) }}</td>
            </tr>
            <tr>
                <td><strong>Kulit</strong></td>
                <td colspan="3">{{ $fmtNormal($fisikRadio->kulit, $fisikRadio->kulit_keterangan) }}</td>
            </tr>
        </table>

        <div class="section-title">8. PEMERIKSAAN EKSTREMITAS</div>
        <table class="table-border">
            <tr class="bg-gray">
                <th>Lokasi</th>
                <th>Edema</th>
                <th>Varises</th>
                <th>Refleks</th>
            </tr>
            <tr>
                <td>Ekstremitas Atas</td>
                <td>{{ $ekstremitas->edema_atas ?? '-' }}</td>
                <td>{{ $ekstremitas->varises_atas ?? '-' }}</td>
                <td>{{ $ekstremitas->refleks_atas ?? '-' }}</td>
            </tr>
            <tr>
                <td>Ekstremitas Bawah</td>
                <td>{{ $ekstremitas->edema_bawah ?? '-' }}</td>
                <td>{{ $ekstremitas->varises_bawah ?? '-' }}</td>
                <td>{{ $ekstremitas->refleks_bawah ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="4"><strong>Catatan:</strong> {{ $ekstremitas->catatan_ekstremitas ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">9. STATUS GINEKOLOGIK & PEMERIKSAAN</div>
        <table>
            <tr>
                <td class="label">Keadaan Umum</td>
                <td class="value">{{ $ekstremitas->keadaan_umum ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Inspekulo (Spekulum)</td>
                <td class="value">{{ $ekstremitas->inspekulo ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">VT (Vaginal Toucher)</td>
                <td class="value">{{ $ekstremitas->vt ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">RT (Rectal Toucher)</td>
                <td class="value">{{ $ekstremitas->rt ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">10. HASIL PEMERIKSAAN PENUNJANG</div>
        <table>
            <tr>
                <td class="label">1. Laboratorium</td>
                <td class="value">{{ $discharge->laboratorium ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">2. USG</td>
                <td class="value">{{ $discharge->usg ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">3. Radiologi</td>
                <td class="value">{{ $discharge->radiologi ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">4. Lainnya</td>
                <td class="value">{{ $discharge->penunjang_lainnya ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">11. DIAGNOSIS, PROGNOSIS & RENCANA PENGOBATAN</div>
        <table>
            <tr>
                <td class="label">Diagnosis Banding</td>
                <td class="value">{{ implode(', ', $decode($dxImpl->diagnosis_banding)) ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label">Diagnosis Kerja</td>
                <td class="value">{{ implode(', ', $decode($dxImpl->diagnosis_kerja)) ?: '-' }}</td>
            </tr>
            <tr>
                <td class="label">Rencana Penatalaksanaan</td>
                <td class="value">{{ $ginek->rencana_pengobatan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Prognosis</td>
                <td class="value">{{ $prognosisLabel }}</td>
            </tr>
        </table>

        <div class="section-title">12. PERENCANAAN PULANG (DISCHARGE PLANNING)</div>
        <table class="table-border">
            <tr>
                <td>Usia Lanjut: {{ $discharge->usia_lanjut == '0' ? 'Ya' : 'Tidak' }}</td>
                <td>Hambatan Mobilisasi: {{ $discharge->hambatan_mobilisasi == '0' ? 'Ya' : 'Tidak' }}</td>
            </tr>
            <tr>
                <td>Media Berkelanjutan: {{ $discharge->penggunaan_media_berkelanjutan ?? '-' }}</td>
                <td>Ketergantungan Aktivitas: {{ $discharge->ketergantungan_aktivitas ?? '-' }}</td>
            </tr>
            <tr>
                <td>Keterampilan Khusus: {{ $discharge->keterampilan_khusus ?? '-' }}</td>
                <td>Alat Bantu: {{ $discharge->alat_bantu ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nyeri Kronis: {{ $discharge->nyeri_kronis ?? '-' }}</td>
                <td>Lama Dirawat: {{ $discharge->perkiraan_hari ?? '-' }} Hari</td>
            </tr>
            <tr>
                <td>Rencana Tgl Pulang:
                    {{ !empty($discharge->tanggal_pulang) ? date('d-m-Y', strtotime($discharge->tanggal_pulang)) : '-' }}
                </td>
                <td><strong>Kesimpulan:</strong> {{ $discharge->kesimpulan_planing ?? '-' }}</td>
            </tr>
        </table>

        <br>
        <table width="100%">
            <tr>
                <td width="65%"></td>
                <td align="center">
                    Langsa,
                    {{ !empty($ginek->tanggal) ? date('d-m-Y', strtotime($ginek->tanggal)) : date('d-m-Y') }}<br>
                    Dokter yang memeriksa,<br><br>
                    @php
                        $namaDok =
                            ($asesmen->user->karyawan->gelar_depan ?? '') .
                            ' ' .
                            ($asesmen->user->karyawan->nama ?? '') .
                            ' ' .
                            ($asesmen->user->karyawan->gelar_belakang ?? '');
                        $namaDok = trim($namaDok);
                    @endphp
                    @if ($namaDok)
                        <img src="{{ generateQrCode($namaDok, 100, 'svg_datauri') }}" alt="QR"><br>
                        <strong>{{ $namaDok }}</strong>
                    @else
                        <br><br><br>( __________________________ )
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
