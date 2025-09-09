<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informed Consent - {{ $dataMedis->pasien->nama ?? 'Pasien' }}</title>
    <style>
        @page {
            margin: 20px 20px;
            margin-left: 60px;
            size: 21cm 29.7cm; /* A4 portrait */
        }

        body {
            font-family: sans-serif;
            font-size: 11pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }

        /* ===== Header ===== */
        .header-container { width: 100%; margin-bottom: 12px; padding-bottom: 10px; }
        .header-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; padding: 0; }

        .logo-cell { width: 75px; text-align: center; }
        .logo-cell img { width: 60px; margin-top: 20px; height: auto; }

        .header-rs-name { font-size: 10pt; margin: 2px; margin-top: 30px; font-weight: bold; line-height: 1; }
        .header-address { font-size: 8pt; margin: 2px; line-height: 1; }

        .header-info-box {
            border: 2px solid black;
            border-radius: 10px;
            padding: 8px;
            width: 100%;
            font-size: 9pt;
        }
        .header-info-row { padding: 2px 0; }
        .header-info-label { width: 30%; }
        .header-info-underline { border-bottom: 1px solid black; }

        /* ===== Title ===== */
        .title { font-size: 12pt; font-weight: bold; text-align: center; margin: 10px 0 2px; }
        .subtitle { font-size: 12pt; font-weight: bold; text-align: center; font-style: italic; margin-bottom: 10px; }

        .content { font-size: 10pt; }

        /* ===== Patient Info Table ===== */
        .patient-info-table { width: 100%; border-collapse: collapse; }
        .patient-info-row-border { border-bottom: 1px solid black; }
        .patient-info-row-border-top { border-top: 1px solid black; border-bottom: 1px solid black; }
        .patient-info-cell { padding: 5px; }

        /* Lebar normal (2 baris atas) */
        .patient-info-label { width: 25%; }
        .patient-info-colon { width: 1%; }
        .patient-info-data { width: 74%; }

        /* Lebar khusus untuk baris Penerima (label + ":" gabung, lebih lebar) */
        .patient-info-label-wide { width: 70%; }
        .patient-info-data-narrow { width: 30%; }

        /* ===== Information Checklist ===== */
        .info-checklist-table { width: 100%; border-collapse: collapse; border: 1px solid black; }
        .info-checklist-header { border: 1px solid black; padding: 8px; text-align: center; font-weight: bold; background-color: #fafafa; }
        .info-checklist-cell { border: 1px solid black; padding: 8px; }
        .info-checklist-cell-center { border: 1px solid black; padding: 8px; text-align: center; font-family: 'DejaVu Sans', sans-serif; }

        /* ===== Section ===== */
        .section-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .section-cell-left { width: 70%; vertical-align: top; }
        .section-cell-right { width: 30%; vertical-align: top; padding: 10px; text-align: center; }
        .section-signature-space { height: 25px; }
        .section-signature-label { margin-top: 10px; padding-top: 5px; }

        /* ===== Signature ===== */
        .signature-section { margin-top: 12px; }
        .signature-sub-table { width: 100%; border-collapse: collapse; }
        .signature-sub-cell { width: 25%; text-align: center; vertical-align: top; }
        .signature-name-space { margin-bottom: 60px; }
        .signature-line { width: 120px; margin: 0 auto; height: 1px; }
        .signature-caption { font-style: italic; font-size: 9pt; margin-top: 5px; }

        /* ===== Note & page break ===== */
        .category-note { font-weight: bold; font-style: italic; }
        .page-break { page-break-before: always; }
    </style>
</head>
<body>
    <!-- ===== Header ===== -->
    <div class="header-container">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}" alt="Logo RSUD Langsa">
                </td>
                <td>
                    <p class="header-rs-name">RSUD LANGSA</p>
                    <p class="header-address">Jl. Jend. A. Yani. Kota Langsa</p>
                    <p class="header-address">Telp: 0641-22051</p>
                </td>
                <td>
                    <table class="header-info-box">
                        <tr>
                            <td class="header-info-row"><strong>NRM</strong></td>
                            <td class="header-info-row header-info-underline">: {{ $dataMedis->kd_pasien }}</td>
                        </tr>
                        <tr>
                            <td class="header-info-row header-info-label"><strong>Nama</strong></td>
                            <td class="header-info-row header-info-underline">: {{ $dataMedis->pasien->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="header-info-row"><strong>Jenis Kelamin</strong></td>
                            <td class="header-info-row">
                                : {{
                                    ($dataMedis->pasien->jenis_kelamin ?? '') == '1' ? 'Laki-laki'
                                    : (($dataMedis->pasien->jenis_kelamin ?? '') == '0' ? 'Perempuan' : '-')
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td class="header-info-row"><strong>Tanggal Lahir</strong></td>
                            <td class="header-info-row header-info-underline">
                                : {{ $dataMedis->pasien->tgl_lahir ? date('d/m/Y', strtotime($dataMedis->pasien->tgl_lahir)) : '-' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- ===== Title ===== -->
    <div class="title">PERSETUJUAN/PENOLAKAN TINDAKAN KEDOKTERAN</div>
    <div class="subtitle">(informed consent)</div>

    <div class="content">
        <!-- ===== Patient Info ===== -->
        <div class="patient-info">
            <table class="patient-info-table">
                <tr class="patient-info-row-border-top">
                    <td class="patient-info-cell patient-info-label">Nama Tindakan</td>
                    <td class="patient-info-cell patient-info-colon">:</td>
                    <td class="patient-info-cell patient-info-data">
                        {{ $informedConsent->tindakan_kedokteran ?? '-' }}
                    </td>
                </tr>
                <tr class="patient-info-row-border">
                    <td class="patient-info-cell patient-info-label">Nama Pemberi Informasi</td>
                    <td class="patient-info-cell patient-info-colon">:</td>
                    <td class="patient-info-cell patient-info-data">
                        {{ $informedConsent->nama_pemberi_info ?? '-' }}
                    </td>
                </tr>
                <tr class="patient-info-row-border" style="border-bottom: 0px solid white;">
                    <!-- Label + ":" gabung & lebih lebar -->
                    <td colspan="3" class="patient-info-cell patient-info-label">
                        Nama Penerima Informasi/Memberikan Persetujuan: {{ $informedConsent->nama_penerima_info ?? '-' }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- ===== Information Checklist ===== -->
        <div class="info-checklist-section">
            <table class="info-checklist-table">
                <thead>
                    <tr>
                        <th class="info-checklist-header">JENIS INFORMASI</th>
                        <th class="info-checklist-header">ISI INFORMASI</th>
                        <th class="info-checklist-header" style="font-family: DejaVu Sans;">Tanda ✓</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="info-checklist-cell">1. Diagnosis (WD dan DD)</td>
                        <td class="info-checklist-cell">{{ $informedConsent->diagnosis ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->diagnosis ? '✓' : '☐' }}</td>
                    </tr>
                    <tr>
                        <td class="info-checklist-cell">2. Dasar diagnosis</td>
                        <td class="info-checklist-cell">{{ $informedConsent->dasar_diagnosis ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->dasar_diagnosis ? '✓' : '☐' }}</td>
                    </tr>
                    <tr>
                        <td class="info-checklist-cell">3. Tindakan kedokteran</td>
                        <td class="info-checklist-cell">{{ $informedConsent->tindakan_kedokteran ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->tindakan_kedokteran ? '✓' : '☐' }}</td>
                    </tr>
                    <tr>
                        <td class="info-checklist-cell">4. Indikasi tindakan</td>
                        <td class="info-checklist-cell">{{ $informedConsent->indikasi_tindakan ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->indikasi_tindakan ? '✓' : '☐' }}</td>
                    </tr>
                    <tr>
                        <td class="info-checklist-cell">5. Tata cara</td>
                        <td class="info-checklist-cell">{{ $informedConsent->tata_cara ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->tata_cara ? '✓' : '☐' }}</td>
                    </tr>
                    <tr>
                        <td class="info-checklist-cell">6. Tujuan</td>
                        <td class="info-checklist-cell">{{ $informedConsent->tujuan ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->tujuan ? '✓' : '☐' }}</td>
                    </tr>
                    <tr>
                        <td class="info-checklist-cell">7. Risiko/komplikasi</td>
                        <td class="info-checklist-cell">{{ $informedConsent->resiko ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->resiko ? '✓' : '☐' }}</td>
                    </tr>
                    <tr>
                        <td class="info-checklist-cell">8. Prognosis</td>
                        <td class="info-checklist-cell">{{ $informedConsent->prognosis ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->prognosis ? '✓' : '☐' }}</td>
                    </tr>
                    <tr>
                        <td class="info-checklist-cell">9. Alternatif</td>
                        <td class="info-checklist-cell">{{ $informedConsent->alternatif ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->alternatif ? '✓' : '☐' }}</td>
                    </tr>
                    <tr>
                        <td class="info-checklist-cell">10. Lain-lain</td>
                        <td class="info-checklist-cell">{{ $informedConsent->lainnya ?? '' }}</td>
                        <td class="info-checklist-cell-center">{{ $informedConsent->lainnya ? '✓' : '☐' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ===== Pernyataan & TTD ===== -->
        <div class="section">
            <table class="section-table">
                <tr>
                    <td class="section-cell-left">
                        <p>Dengan ini menyatakan bahwa saya, <strong>{{ $informedConsent->nama_pemberi_info ?? '................................' }}</strong> telah menerangkan hal-hal di atas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi.</p>
                    </td>
                    <td class="section-cell-right">
                        <div>
                            <div>Tanda tangan dokter</div>
                            <div class="section-signature-space"></div>
                            <div class="section-signature-label">{{ $informedConsent->nama_pemberi_info ?? 'Nama & Tanda Tangan' }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="section-cell-left">
                        <p>Dengan ini menyatakan bahwa saya/keluarga pasien <strong>{{ $informedConsent->nama_penerima_info ?? '....................................' }}</strong> telah menerima informasi sebagaimana di atas dan saya beri tanda/paraf di kolom kanannya serta telah diberi kesempatan untuk bertanya, berdiskusi, dan memahaminya.</p>
                    </td>
                    <td class="section-cell-right">
                        <div>
                            <div>Tanda tangan pasien/kel</div>
                            <div class="section-signature-space"></div>
                            <div class="section-signature-label">{{ $informedConsent->nama_penerima_info ?? 'Nama & Tanda Tangan' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
            <p class="category-note">Cat: Apabila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat.</p>
        </div>

        <!-- ===== Page Break ===== -->
        <div class="page-break">
            <div class="title">PERSETUJUAN/PENOLAKAN TINDAKAN KEDOKTERAN*</div>
        </div>

        <!-- ===== Blok Persetujuan / Penolakan ===== -->
        <div class="section">
            <p>Saya yang bertanda tangan di bawah ini, nama: <strong>{{ $informedConsent->keluarga_nama ?? '-' }}</strong> umur: <strong>{{ $informedConsent->keluarga_umur ?? '-' }}</strong> tahun, jenis kelamin: <strong>{{ $informedConsent->keluarga_jenis_kelamin == 'L' ? 'Laki-laki' : ($informedConsent->keluarga_jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</strong>, alamat: <strong>{{ $informedConsent->keluarga_alamat ?? '-' }}</strong> dengan ini menyatakan: <strong>{{ $informedConsent->status_persetujuan_keluarga == 1 ? 'SETUJU' : ($informedConsent->status_persetujuan_keluarga == 0 ? 'MENOLAK' : 'SETUJU/MENOLAK') }}</strong></p>

            <p>Saya memahami perlunya dan manfaat tindakan tsb sebagaimana telah dijelaskan kepada saya, termasuk risiko dan komplikasi yang mungkin timbul. Saya juga menyadari bahwa ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan dan kesembuhan sangat bergantung atas izin Tuhan Yang Maha Kuasa.</p>
        </div>

        <!-- ===== Tanda Tangan Akhir ===== -->
        <div class="signature-section">
            <table class="signature-sub-table" style="margin-bottom:6px;">
                <tr>
                    <td style="width:60%;">
                        <p><strong>Kota Langsa, tanggal: {{ $informedConsent->tanggal ? date('d/m/Y', strtotime($informedConsent->tanggal)) : '................' }} / pukul {{ $informedConsent->jam ? date('H:i', strtotime($informedConsent->jam)) : '........' }} WIB</strong></p>
                    </td>
                    <td style="width:40%; text-align:center;">
                        <p>Saksi-saksi</p>
                    </td>
                </tr>
            </table>

            <table class="signature-sub-table">
                <tr>
                    <td class="signature-sub-cell">
                        <div class="signature-name-space"><strong>Yang menyatakan:</strong></div>
                        <div class="signature-line"></div>
                        <div class="signature-caption">{{ $informedConsent->keluarga_nama ?? '-' }}</div>
                    </td>
                    <td class="signature-sub-cell">
                        <div class="signature-name-space">Dokter</div>
                        <div class="signature-line"></div>
                        <div class="signature-caption">{{ $informedConsent->nama_pemberi_info ?? 'Nama Jelas dan TTD' }}</div>
                    </td>
                    <td class="signature-sub-cell">
                    <td class="signature-sub-cell">
                        <div class="signature-name-space">&nbsp;</div>
                        <div class="signature-line"></div>
                        <div class="signature-caption">1. {{ $informedConsent->saksi1_nama ?? '(...........................)' }}</div>
                    </td>
                    <td class="signature-sub-cell">
                        <div class="signature-name-space">&nbsp;</div>
                        <div class="signature-line"></div>
                        <div class="signature-caption">2. {{ $informedConsent->saksi2_nama ?? '(...........................)' }}</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
