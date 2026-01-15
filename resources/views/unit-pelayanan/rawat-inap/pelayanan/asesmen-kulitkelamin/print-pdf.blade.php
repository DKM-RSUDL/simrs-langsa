



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Anamnesis - Ophthalmology</title>

    <style>
        /* Your original styles remain unchanged — I didn't modify CSS */
        * { box-sizing: border-box; font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important; font-size: 8.5pt; }
        @page { size: A4; margin: 3mm 6mm; }
        body { margin: 0; padding: 0; }
        .a4 { width: 100%; max-width: 100%; }
        table { width: 100%; border-collapse: collapse; }
        td, th { padding: 4px 6px; vertical-align: top; }
        .label { font-weight: bold; width: 38%; padding-right: 8px; }
        .value { border-bottom: 1px solid #000; min-height: 22px; }
        .value.tall { min-height: 32px; }
        .value.empty-space { min-height: 60px; }
        .checkbox-group label { margin-right: 28px; display: inline-block; }
        /* ... rest of your styles unchanged ... */
    </style>
</head>
   <style>
        * {
            box-sizing: border-box;
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8.5pt;
        }

        @page {
            size: A4;
            margin: 3mm 6mm;
        }

        body {
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
            padding: 4px 6px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            width: 38%;
            padding-right: 8px;
        }

        .value {
            border-bottom: 1px solid #000;
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
            top: -3px;
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
        $asesmenKulitKelamin = $data['asesmenKulitKelamin'];
        $riwayat_penyakit_keluarga = json_decode($asesmenKulitKelamin->riwayat_penyakit_keluarga ?? '[]', true);
        $penyakit_yang_diderita = json_decode($asesmenKulitKelamin->penyakit_yang_diderita ?? '[]', true);
        $riwayat_penggunaan_obat = json_decode($asesmenKulitKelamin->riwayat_penggunaan_obat ?? '[]', true);
        $riwayat_alergi = json_decode($asesmen->riwayat_alergi ?? '[]', true);
        $rencanaPulang = $data['rencanaPulang'];
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
                <span class="title-main">ASESMEN MEDIS</span>
                <span class="title-sub">PENYAKIT KULIT & KELAMIN</span>
            </td>
            <td class="td-right">
                <div class="unit-box"><span class="unit-text" style="font-size: 14px; margin-top:10px;">RAWAT INAP</span></div>
            </td>
        </tr>
    </table>

    <table class="patient-table">
        <tr>
            <th>No. RM</th>
            <td>{{ $data['dataMedis']->pasien->kd_pasien ?? '-' }}</td>
            <th>Tgl. Lahir</th>
            <td>{{ $data['dataMedis']->pasien->tgl_lahir ? \Carbon\Carbon::parse($data['dataMedis']->pasien->tgl_lahir)->format('d M Y') : '-' }}</td>
        </tr>
        <tr>
            <th>Nama Pasien</th>
            <td>{{ $data['dataMedis']->pasien->nama ?? '-' }}</td>
            <th>Umur</th>
            <td>{{ $data['dataMedis']->pasien->umur ?? '-' }} Tahun</td>
        </tr>
    </table>

    <table style="margin-top: 20px;">
        <tr>
            <td class="label">ANAMNESIS / Keluhan Utama</td>
            <td class="value">{{ $asesmen->anamnesis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Riwayat penyakit terdahulu:</td>
            <td class="value">{{ $asesmen->riwayat_penyakit_dahulu ?? implode(', ', $penyakit_yang_diderita) ?: '–' }}</td>
        </tr>
        <tr>
            <td class="label">Riwayat penyakit dalam keluarga:</td>
            <td class="value">{{ implode(', ', $riwayat_penyakit_keluarga) ?: 'Tidak ada / tidak diketahui' }}</td>
        </tr>

        <tr>
            <td colspan="2" class="label" style="padding-top: 0px;">Riwayat pengobatan / pemakaian obat saat ini:</td>
        </tr>
        <tr>
            <td colspan="2" class="checkbox-group" style="padding: 6px 0 8px 0;">
                <label style="display: inline-flex; align-items: center; margin-right: 40px; white-space: nowrap;">
                    <input type="checkbox" {{ empty($riwayat_penggunaan_obat) ? 'checked' : '' }} style="margin-right: 6px;"> Tidak ada
                </label>
                <label style="display: inline-flex; align-items: center; white-space: nowrap;">
                    <input type="checkbox" {{ !empty($riwayat_penggunaan_obat) ? 'checked' : '' }} style="margin-right: 6px;"> Ada, sebutkan:
                </label>
            </td>
        </tr>

        @if(!empty($riwayat_penggunaan_obat))
            @foreach($riwayat_penggunaan_obat as $index => $obat)
                <tr>
                    <td class="label" style="padding-left: 30px; font-weight: normal;">{{ $index + 1 }}.</td>
                    <td class="value" style="border-bottom: 1px dotted #444;">
                        <strong>{{ $obat['namaObat'] ?? '-' }}</strong>
                        {{ $obat['dosis'] ?? '' }} {{ $obat['satuan'] ?? '' }},
                        {{ $obat['frekuensi'] ?? '-' }}
                        @if(!empty($obat['keterangan'])) — {{ $obat['keterangan'] }} @endif
                    </td>
                </tr>
            @endforeach
        @endif

        <tr>
            <td colspan="2" class="label" style="padding-top: 0px;">Riwayat Alergi:</td>
        </tr>
        <tr>
            <td colspan="2" class="checkbox-group" style="padding: 6px 0 10px 0;">
                <label style="display: inline-flex; align-items: center; margin-right: 40px;">
                    <input type="checkbox" {{ empty($riwayat_alergi) ? 'checked' : '' }} style="margin-right: 6px;"> Tidak ada
                </label>
                <label style="display: inline-flex; align-items: center;">
                    <input type="checkbox" {{ !empty($riwayat_alergi) ? 'checked' : '' }} style="margin-right: 6px;"> Ada, sebutkan:
                </label>
            </td>
        </tr>

        @if(!empty($riwayat_alergi))
            @foreach($riwayat_alergi as $index => $alergi)
                <tr>
                    <td class="label" style="padding-left: 30px; font-weight: normal; width: 10%;">{{ $index + 1 }}.</td>
                    <td class="value" style="border-bottom: 1px dotted #444; padding: 0px;">
                        <strong>{{ $alergi['alergen'] ?? '-' }}</strong>
                        (Jenis: {{ $alergi['jenis'] ?? '-' }})
                        — Reaksi: {{ $alergi['reaksi'] ?? '-' }}
                        — Keparahan: {{ $alergi['keparahan'] ?? '-' }}
                    </td>
                </tr>
            @endforeach
        @endif

        <tr>
            <td colspan="2" class="label" style="padding-top: 18px; font-size: 12pt;">STATUS PRESENT</td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="width: 100%; margin-top: 8px; border-collapse: collapse;">
                    <tr>
                        <td class="label" style="width: 25%;">Sensorium</td>
                        <td class="value" style="width: 25%;">{{ $data['asesmenKulitKelamin']->sensorium ?? '' }}</td>
                        <td class="label" style="width: 25%;">Tekanan darah</td>
                        <td class="value">
                            @if(!empty($data['asesmenKulitKelamin']->tekanan_darah_sistole) && !empty($data['asesmenKulitKelamin']->tekanan_darah_diastole))
                                {{ $data['asesmenKulitKelamin']->tekanan_darah_sistole }}/{{ $data['asesmenKulitKelamin']->tekanan_darah_diastole }} mmHg
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Respirasi</td>
                        <td class="value">{{ $data['asesmenKulitKelamin']->respirasi ?? '' }}</td>
                        <td class="label">Suhu</td>
                        <td class="value">{{ $data['asesmenKulitKelamin']->suhu ?? '' }} °C</td>
                    </tr>
                    <tr>
                        <td class="label">Nadi</td>
                        <td class="value">{{ $data['asesmenKulitKelamin']->nadi ?? '' }}</td>
                        <td></td><td></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="label" style="padding-top: 18px; font-size: 12pt;">PEMERIKSAAN FISIK</td>
        </tr>
        <tr>
            <td colspan="2" style="padding:0;">
                <table class="table table-bordered mb-0">
                    <tbody>
                        @foreach ($data['itemFisik']->chunk(2) as $chunk)
                            <tr>
                                @foreach ($chunk as $item)
                                    @php
                                        $pemeriksaanData = $data['pemeriksaanFisik']->get($item->id);
                                        $isNormal = $pemeriksaanData ? $pemeriksaanData->is_normal : false;
                                        $keterangan = $pemeriksaanData ? $pemeriksaanData->keterangan : '';
                                    @endphp
                                    <td style="width:50%; vertical-align: top; padding:6px;">
                                        <table class="table table-borderless table-sm mb-1 w-100">
                                            <tr>
                                                <td style="width:45%; font-weight:600;">{{ $item->nama }}</td>
                                                <td style="width:25%;">
                                                    <input type="checkbox" id="{{ $item->id }}-normal" {{ $isNormal ? 'checked' : '' }}>
                                                    <label for="{{ $item->id }}-normal">Normal</label>
                                                </td>
                                            </tr>
                                        </table>
                                        <div style="display:{{ !$isNormal && $keterangan ? 'block' : 'none' }};">
                                            <input type="text" class="form-control form-control-sm" value="{{ $keterangan }}" placeholder="Keterangan jika tidak normal">
                                        </div>
                                    </td>
                                @endforeach
                                @if ($chunk->count() < 2)
                                    <td style="width:50%;"></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>

        <!-- Skala Nyeri -->
        <tr class="page-break">
            <td colspan="2" class="label" style="padding-top: 18px; font-size: 12pt;">SKALA NYERI</td>
        </tr>
        <tr>
            <td class="checkbox-group" style="padding: 6px 0 10px 0;">
                <div class="text-center">
                    <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}" alt="Skala Nyeri Visual" class="img-fluid mb-3" style="max-height: 200px;">
                </div>
            </td>
            <td>
                @php
                    $nilai = $asesmen->skala_nyeri ?? 0;
                    $kategori = match(true) {
                        $nilai >= 1 && $nilai <= 3 => 'Nyeri Ringan',
                        $nilai >= 4 && $nilai <= 6 => 'Nyeri Sedang',
                        $nilai >= 7 && $nilai <= 9 => 'Nyeri Berat',
                        $nilai == 10 => 'Nyeri Tak Tertahankan',
                        default => ''
                    };
                @endphp
                <div>Skala Nyeri (1-10) : {{ $nilai }}</div>
                <div>Kategori Nyeri : {{ $kategori }}</div>
            </td>
        </tr>

        <!-- Diagnosis -->
        @php
            $diagnosisBanding = json_decode($asesmenKulitKelamin->diagnosis_banding ?? '[]', true);
            $diagnosisKerja  = json_decode($asesmenKulitKelamin->diagnosis_kerja  ?? '[]', true);
        @endphp
   
        <tr>
            <!-- Left Column: Diagnosis, Rencana, Prognosis -->
            <td style="width: 50%; vertical-align: top; padding-right: 12px;">
                <table style="width: 100%; border-collapse: collapse; height : 400px;">
                    <tr>
                        <td class="label" style="width: 40%; font-weight: bold; padding: 8px 10px; background: #f8f9fa; border: 1px solid #dee2e6;">
                            DIAGNOSIS DIFERENSIAL
                        </td>
                        <td class="value" style="padding: 8px 10px; border: 1px solid #dee2e6; border-left: none;">
                            {{ !empty($diagnosisBanding) ? implode(', ', $diagnosisBanding) : '–' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="width: 40%; font-weight: bold; padding: 8px 10px; background: #f8f9fa; border: 1px solid #dee2e6;">
                            DIAGNOSIS KERJA
                        </td>
                        <td class="value" style="padding: 8px 10px; border: 1px solid #dee2e6; border-left: none;">
                            {{ !empty($diagnosisKerja) ? implode(', ', $diagnosisKerja) : '–' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="width: 40%; font-weight: bold; padding: 8px 10px; background: #f8f9fa; border: 1px solid #dee2e6;">
                            RENCANA PENATALAKSANAAN DAN PENGOBATAN
                        </td>
                        <td class="value" style="padding: 8px 10px; border: 1px solid #dee2e6; border-left: none; min-height: 60px;">
                            {{ $rmeAsesmenKepOphtamology->rencana_pengobatan ?? '–' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label" style="width: 40%; font-weight: bold; padding: 8px 10px; background: #f8f9fa; border: 1px solid #dee2e6;">
                            PROGNOSIS
                        </td>
                        <td class="value" style="padding: 8px 10px; border: 1px solid #dee2e6; border-left: none;">
                            @php
                                $valuePrognosis = null;
                                foreach ($data['satsetPrognosis'] ?? [] as $item) {
                                    if ($item->prognosis_id == $asesmenKulitKelamin->paru_prognosis) {
                                        $valuePrognosis = $item->value;
                                        break;
                                    }
                                }
                            @endphp
                            {{ $valuePrognosis ?? '–' }}
                        </td>
                    </tr>
                </table>
            </td>

            <!-- Right Column: Site Marking -->
            <td style="width: 50%; vertical-align: top; padding-left: 12px;">
                
                <div class="site-marking-container" style="width: 280px; max-width: 100%; position: relative; background: #f8f9fa; border: 2px solid #dee2e6; border-radius: 6px; overflow: hidden;">
                    <img src="{{ asset('assets/images/sitemarking/kulit-kelamin.png') }}" 
                        id="anatomyImageShow" 
                        style="display: block; width: 100%; height: auto;">
                    <canvas id="markingCanvasShow" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 10; pointer-events: none;"></canvas>
                </div>

                <div class="mt-2" style="margin-top: 10px;">
                    <small class="text-muted">
                        <i class="ti-info"></i> Penandaan anatomi yang telah dibuat saat asesmen
                    </small>
                </div>
            </td>
        </tr>
        <!-- Discharge Planning -->
        <tr>
            <td colspan="2" class="label" style="padding-top: 18px; font-size: 12pt;">PERENCANAAN PULANG PASIEN (DISCHARGE PLANNING)</td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="width: 100%; margin-top: 8px; border-collapse: collapse;">
                    @php
                        $ketergantungan = (
                            ($rencanaPulang['memerlukan_keterampilan_khusus'] ?? '') == 'ya' ||
                            ($rencanaPulang['memerlukan_alat_bantu'] ?? '') == 'ya' ||
                            ($rencanaPulang['memiliki_nyeri_kronis'] ?? '') == 'ya'
                        );
                    @endphp

                    <tr>
                        <td class="label" style="width:55%;">Usia lanjut (> 60 th)</td>
                        <td style="text-align:center;">
                            <label><input type="checkbox" {{ ($rencanaPulang['usia_lanjut'] ?? '') == 'Ya' ? 'checked' : '' }}> Ya</label>
                            <label><input type="checkbox" {{ ($rencanaPulang['usia_lanjut'] ?? '') != 'Ya' ? 'checked' : '' }}> Tidak</label>
                        </td>
                        <td rowspan="4" class="value" style="vertical-align:top; width:35%;">
                            Jika salah satu jawaban “ya” maka pasien membutuhkan rencana pulang khusus.
                        </td>
                    </tr>

                    <!-- Add the other discharge planning rows similarly ... -->

                    <tr>
                        <td class="label">Rencana Lama Perawatan :</td>
                        <td class="value">{{ $rencanaPulang['perkiraan_lama_dirawat'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Rencana Tanggal Pulang :</td>
                        <td class="value">
                            {{ isset($rencanaPulang['rencana_pulang']) ? \Carbon\Carbon::parse($rencanaPulang['rencana_pulang'])->translatedFormat('d F Y') : '' }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Signature -->
        <tr>
            <td colspan="2" style="padding-top: 40px; text-align: right;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 60%;"></td>
                        <td style="text-align: center; padding: 8px;">
                            Tanggal: {{ date('d-m-Y', strtotime($asesmenKulitKelamin->waktu_masuk ?? 'now')) }}
                            Jam: {{ date('H:i', strtotime($asesmenKulitKelamin->waktu_masuk ?? 'now')) }}
                            <br><br>
                            Dokter yang memeriksa
                            <br><br>
                            <img src="{{ generateQrCode(($data['asesmen']->user->karyawan->gelar_depan ?? '') . ' ' . str()->title($data['asesmen']->user->karyawan->nama ?? '') . ' ' . ($data['asesmen']->user->karyawan->gelar_belakang ?? ''), 100, 'svg_datauri') }}" alt="QR Petugas">
                            <br><br>
                            {{ ($data['asesmen']->user->karyawan->gelar_depan ?? '') . ' ' . str()->title($data['asesmen']->user->karyawan->nama ?? '') . ' ' . ($data['asesmen']->user->karyawan->gelar_belakang ?? '') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <script>
        // Your original site marking script remains here (unchanged)
        document.addEventListener("DOMContentLoaded", function () {
            function initSiteMarkingShow() {
                const image = document.getElementById('anatomyImageShow');
                const canvas = document.getElementById('markingCanvasShow');

                // Check if elements exist
                if (!image || !canvas  ) {
                    console.log('Site marking elements not found - no marking data available');
                    return;
                }

                const ctx = canvas.getContext('2d');
                let markings = [];

                // Load existing data from PHP
                try {
                    const siteMarkingData = @json($asesmenKulitKelamin->site_marking_data ?? '[]');
                    if (siteMarkingData && siteMarkingData !== '[]') {
                        markings = typeof siteMarkingData === 'string' ? JSON.parse(siteMarkingData) : siteMarkingData;
                    }
                } catch (e) {
                    console.error('Error parsing site marking data:', e);
                    markings = [];
                }

                // Setup canvas
                setupCanvasShow();

                // Load and display markings
                loadMarkingsShow();

                function setupCanvasShow() {
                    function updateCanvasSize() {
                        canvas.width = image.offsetWidth;
                        canvas.height = image.offsetHeight;
                        canvas.style.width = image.offsetWidth + 'px';
                        canvas.style.height = image.offsetHeight + 'px';

                        // Redraw all markings
                        redrawCanvasShow();
                    }

                    // Update canvas size when image loads
                    image.onload = updateCanvasSize;

                    // Update canvas size when window resizes
                    window.addEventListener('resize', updateCanvasSize);

                    // Initial setup
                    if (image.complete) {
                        updateCanvasSize();
                    }
                }

                function loadMarkingsShow() {
                    
                  

                    // Draw markings on canvas
                    setTimeout(() => {
                        redrawCanvasShow();
                    }, 100);
                }

              
                function drawArrowShow(ctx, startX, startY, endX, endY, color) {
                    ctx.strokeStyle = color;
                    ctx.fillStyle = color;
                    ctx.lineWidth = 3;
                    ctx.lineCap = 'round';

                    // Draw line
                    ctx.beginPath();
                    ctx.moveTo(startX, startY);
                    ctx.lineTo(endX, endY);
                    ctx.stroke();

                    // Calculate arrow head
                    const angle = Math.atan2(endY - startY, endX - startX);
                    const arrowLength = 15;
                    const arrowAngle = Math.PI / 6;

                    // Draw arrow head
                    ctx.beginPath();
                    ctx.moveTo(endX, endY);
                    ctx.lineTo(
                        endX - arrowLength * Math.cos(angle - arrowAngle),
                        endY - arrowLength * Math.sin(angle - arrowAngle)
                    );
                    ctx.moveTo(endX, endY);
                    ctx.lineTo(
                        endX - arrowLength * Math.cos(angle + arrowAngle),
                        endY - arrowLength * Math.sin(angle + arrowAngle)
                    );
                    ctx.stroke();
                }

                function redrawCanvasShow() {
                    // Clear canvas
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    // Draw all markings
                    markings.forEach(marking => {
                        if (marking.startX !== undefined && marking.startY !== undefined &&
                            marking.endX !== undefined && marking.endY !== undefined) {

                            const startX = (marking.startX / 100) * canvas.width;
                            const startY = (marking.startY / 100) * canvas.height;
                            const endX = (marking.endX / 100) * canvas.width;
                            const endY = (marking.endY / 100) * canvas.height;

                            drawArrowShow(ctx, startX, startY, endX, endY, marking.color || '#dc3545');
                        }
                    });
                }

                console.log('Site Marking Show Mode: Initialized with', markings.length, 'markings');
            }
            initSiteMarkingShow();
            window.print();
        });
    </script>

</body>
</html>