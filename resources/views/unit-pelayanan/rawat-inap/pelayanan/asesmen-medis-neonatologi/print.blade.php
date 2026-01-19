<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Asesmen Medis Neonatologi - {{ $dataMedis->pasien->nama ?? '' }}</title>
    <style>
        /* CSS Standard Rekam Medis */
        @page {
            size: A4;
            margin: 5mm 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8.5pt;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        td,
        th {
            padding: 3px 5px;
            vertical-align: top;
        }

        /* Header Style */
        .header-table {
            background-color: #f0f0f0;
            border-bottom: 1px solid #000;
        }

        .td-left {
            width: 45%;
            vertical-align: middle;
        }

        .td-center {
            width: 35%;
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
            font-size: 7.5px;
            margin: 0;
        }

        .title-main {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .unit-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            text-align: center;
        }

        .unit-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
        }

        /* Pasien Card */
        .patient-table th,
        .patient-table td {
            border: 1px solid #ccc;
            padding: 5px;
        }

        .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 120px;
        }

        /* Section Styling */
        .section-title {
            font-weight: bold;
            font-size: 10pt;
            padding: 5px 0 2px 0;
            border-bottom: 1.5px solid #000;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .dots-value {
            border-bottom: 0.5px dotted #000;
            min-height: 16px;
        }

        .table-border {
            border: 1px solid #000;
        }

        .table-border th,
        .table-border td {
            border: 1px solid #000;
            padding: 4px;
        }

        .bg-gray {
            background-color: #f2f2f2;
        }

        /* Point List Styling */
        .list-container {
            display: block;
            width: 100%;
        }

        .list-row {
            display: block;
            margin-bottom: 3px;
            clear: both;
        }

        .list-label {
            display: inline-block;
            width: 160px;
            font-weight: bold;
        }

        .list-dash {
            display: inline-block;
            width: 10px;
        }

        .list-text {
            display: inline-block;
        }

        .keep-together {
            page-break-inside: avoid;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        /* Checkbox Style for Print */
        .cb-print {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
            margin-right: 2px;
        }

        .cb-item {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    @php
        $neo = $asesmen->asesmenMedisNeonatologi;
        $fisik = $asesmen->asesmenMedisNeonatologiFisikGeneralis;
        $dtl = $asesmen->asesmenMedisNeonatologiDtl;
        $pasien = $dataMedis->pasien;

        $logoPath = public_path('assets/img/Logo-RSUD-Langsa-1.png');
        $logoData = @file_get_contents($logoPath);
        $logoBase64 = $logoData ? 'data:image/png;base64,' . base64_encode($logoData) : null;

        $decode = function ($val) {
            if (empty($val)) {
                return [];
            }
            return is_string($val) ? json_decode($val, true) : $val;
        };
        $fmt = function ($val) use ($decode) {
            $arr = $decode($val);
            return is_array($arr) ? implode(', ', $arr) : '-';
        };

        // HELPER UNTUK CHECKBOX (Radio/Single Value)
        $cb = function ($actual, $expected) {
            return $actual == $expected
                ? '<span class="cb-print">&#9745;</span>' // Centang
                : '<span class="cb-print">&#9744;</span>'; // Kotak Kosong
        };

        // HELPER UNTUK CHECKBOX ARRAY (Multiple Value)
        // PERBAIKAN: Menambahkan pengecekan is_array agar tidak error jika data berupa integer/string
        $cba = function ($needle, $haystack) use ($decode) {
            $arr = is_array($haystack) ? $haystack : $decode($haystack);

            // Jaga-jaga jika hasil decode bukan array (misal null atau integer)
            if (!is_array($arr)) {
                $arr = [];
            }

            return in_array($needle, $arr)
                ? '<span class="cb-print">&#9745;</span>'
                : '<span class="cb-print">&#9744;</span>';
        };
    @endphp

    <div class="a4">
        <table class="header-table">
            <tr>
                <td class="td-left">
                    <table>
                        <tr>
                            <td>
                                @if ($logoBase64)
                                    <img src="{{ $logoBase64 }}" style="width:65px;">
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
                    <span class="title-main">Pengkajian Awal Medis
                        Neonatologi Bayi Sakit</span>
                </td>
                <td class="td-right">
                    <div class="unit-box"><span class="unit-text">RAWAT INAP</span></div>
                </td>
            </tr>
        </table>

        <table class="patient-table">
            <tr>
                <th>No. Rekam Medis</th>
                <td>{{ $dataMedis->kd_pasien ?? '-' }}</td>
                <th>Tanggal Lahir</th>
                <td>{{ !empty($pasien->tgl_lahir) ? date('d-m-Y', strtotime($pasien->tgl_lahir)) : '-' }}</td>
            </tr>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $pasien->nama ?? '-' }}</td>
                <th>Jenis Kelamin</th>
                <td>{{ ($pasien->jenis_kelamin ?? '') == '1' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
        </table>

        <div class="section-title">1. Data Masuk</div>
        <div class="list-container">
            <div class="list-row"><span class="list-label">Tgl & Jam Pengisian</span><span class="list-dash">:</span>
                {{ !empty($neo->tanggal) ? date('d-m-Y', strtotime($neo->tanggal)) : '-' }} /
                {{ !empty($neo->jam) ? date('H:i', strtotime($neo->jam)) : '-' }}
            </div>
            <div class="list-row"><span class="list-label">No. HP Keluarga</span><span class="list-dash">:</span>
                {{ $neo->no_hp ?? '-' }}</div>
            <div class="list-row">
                <span class="list-label">Transportasi Datang</span><span class="list-dash">:</span>
                <span class="list-text">
                    {!! $cba('kendaraan_pribadi', $neo->transportasi) !!} Kendaraan pribadi &nbsp;
                    {!! $cba('ambulance', $neo->transportasi) !!} Ambulance &nbsp;
                    {!! $cba('kendaraan_lainnya', $neo->transportasi) !!} Lainnya
                    {{ $neo->kendaraan_lainnya_detail ? '(' . $neo->kendaraan_lainnya_detail . ')' : '' }}
                </span>
            </div>
        </div>

        <div class="section-title">2. Alergi</div>
        <table class="table-border" style="margin-top: 5px;">
            <tr class="bg-gray">
                <th width="25%">Jenis Alergi</th>
                <th width="25%">Alergen</th>
                <th width="25%">Reaksi</th>
                <th width="25%">Keparahan</th>
            </tr>
            @forelse($alergiPasien as $a)
                <tr>
                    <td>{{ $a->jenis_alergi }}</td>
                    <td>{{ $a->nama_alergi }}</td>
                    <td>{{ $a->reaksi }}</td>
                    <td>{{ $a->tingkat_keparahan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada riwayat alergi</td>
                </tr>
            @endforelse
        </table>

        <div class="section-title">3. Anamnesis</div>
        <div class="list-container">
            <div class="list-row"><span class="list-label">Anamnesis</span><span class="list-dash">:</span>
                {{ $neo->anamnesis ?? '-' }}</div>
            <div class="list-row"><span class="list-label">Riwayat Lahir</span><span class="list-dash">:</span>
                {!! $cb($neo->lahir, '1') !!} Lahir di RSU Langsa &nbsp;
                {!! $cb($neo->lahir, '0') !!} Luar RSU Langsa {{ $neo->lahir == '0' ? '(' . $neo->lahir_rs_lain . ')' : '' }}
            </div>
            <div class="list-row"><span class="list-label">Keluhan Utama Bayi</span><span class="list-dash">:</span>
                {{ $neo->keluahan_bayi ?? '-' }}</div>
        </div>

        <div class="keep-together">
            <div class="section-title">4. Riwayat Antenatal, Intranatal & Penyakit Ibu</div>
            <table class="table-border">
                <tr class="bg-gray">
                    <th width="33%">A. Antenatal</th>
                    <th width="33%">B. Intranatal</th>
                    <th width="34%">C. Penyakit Ibu</th>
                </tr>
                <tr>
                    <td>
                        <div class="list-row"><span style="width:80px; display:inline-block;">Anak Ke</span>:
                            {{ $neo->anak_ke ?? '-' }}</div>
                        <div class="list-row"><span style="width:80px; display:inline-block;">ANC</span>:
                            {!! $cb($neo->anc, '1') !!} Ya &nbsp; {!! $cb($neo->anc, '0') !!} Tidak</div>
                        <div class="list-row"><span style="width:80px; display:inline-block;">USG</span>:
                            {{ $neo->usg_kali ?? '0' }} kali</div>
                        <div class="list-row"><span style="width:80px; display:inline-block;">HPHT</span>:
                            {{ !empty($neo->hpht_tanggal) ? date('d-m-Y', strtotime($neo->hpht_tanggal)) : '-' }}</div>
                        <div class="list-row"><span style="width:80px; display:inline-block;">Taksiran</span>:
                            {{ !empty($neo->taksiran_tanggal) ? date('d-m-Y', strtotime($neo->taksiran_tanggal)) : '-' }}
                        </div>
                        <div class="list-row">Nyeri BAK: {!! $cb($neo->nyeri_bak, '1') !!} Ya &nbsp; {!! $cb($neo->nyeri_bak, '0') !!} Tidak
                        </div>
                        <div class="list-row">Keputihan: {!! $cb($neo->keputihan, '1') !!} Ya &nbsp; {!! $cb($neo->keputihan, '0') !!}
                            Tidak</div>
                    </td>
                    <td>
                        <div class="list-row">Perdarahan: {!! $cb($neo->perdarahan, '1') !!} Ya &nbsp; {!! $cb($neo->perdarahan, '0') !!}
                            Tidak</div>
                        <div class="list-row">Ketuban Pecah:
                            {!! $cb($neo->ketuban_pecah, '1') !!} Ya
                            ({{ $neo->ketuban_pecah == '1' && !empty($neo->ketuban_jam) ? date('H:i', strtotime($neo->ketuban_jam)) : '-' }})
                            &nbsp;
                            {!! $cb($neo->ketuban_pecah, '0') !!} Tidak</div>
                        <div class="list-row">Gawat Janin: {!! $cb($neo->gawat_janin, '1') !!} Ya &nbsp; {!! $cb($neo->gawat_janin, '0') !!}
                            Tidak</div>
                        <div class="list-row">Demam:
                            {!! $cb($neo->demam, '1') !!} Ya ({{ $neo->demam == '1' ? $neo->demam_suhu . '°C' : '-' }})
                            &nbsp;
                            {!! $cb($neo->demam, '0') !!} Tidak
                        </div>
                        <div class="list-row">Deksametason:
                            {!! $cb($neo->terapi_deksametason, '1') !!} Ya
                            ({{ $neo->terapi_deksametason == '1' ? $neo->deksametason_kali . 'x' : '-' }}) &nbsp;
                            {!! $cb($neo->terapi_deksametason, '0') !!} T
                        </div>
                        <div class="list-row">Terapi Lain: {{ $neo->terapi_lain ?? '-' }}</div>
                    </td>
                    <td>
                        <div style="font-size: 8pt;">
                            <div class="cb-item">{!! $cba('dm', $neo->riwayat_penyakit_ibu) !!} DM</div>
                            <div class="cb-item">{!! $cba('hepatitisb', $neo->riwayat_penyakit_ibu) !!} Hepatitis B</div>
                            <div class="cb-item">{!! $cba('ekimosis', $neo->riwayat_penyakit_ibu) !!} Ekimosis</div>
                            <div class="cb-item">{!! $cba('tb', $neo->riwayat_penyakit_ibu) !!} TB</div>
                            <div class="cb-item">{!! $cba('hypertensi', $neo->riwayat_penyakit_ibu) !!} Hypertensi</div>
                            <div class="cb-item">{!! $cba('hiv_aids', $neo->riwayat_penyakit_ibu) !!} HIV/AIDS</div>
                            <div class="cb-item">{!! $cba('jantung', $neo->riwayat_penyakit_ibu) !!} Jantung</div>
                            <div class="cb-item">{!! $cba('asthma', $neo->riwayat_penyakit_ibu) !!} Asthma</div>
                        </div>
                        <div class="list-row" style="margin-top:4px;">Lainnya:
                            {{ $neo->riwayat_penyakit_ibu_lain ?? '-' }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="keep-together">
            <div class="section-title">5. Pemeriksaan Fisik (Status Present)</div>
            <table class="table-border">
                <tr>
                    <td><strong>Postur:</strong> {{ $fisik->postur_tubuh ?? '-' }}</td>
                    <td><strong>Tangis:</strong> {{ $fisik->tangis ?? '-' }}</td>
                    <td><strong>Denyut Jantung:</strong> {{ $fisik->denyut_jantung ?? '-' }} x/m</td>
                    <td><strong>Nadi:</strong> {{ $fisik->nadi ?? '-' }} x/m</td>
                </tr>
                <tr>
                    <td><strong>Respirasi:</strong> {{ $fisik->respirasi ?? '-' }} x/m</td>
                    <td><strong>Suhu:</strong> {{ $fisik->temperatur ?? '-' }} °C</td>
                    <td><strong>SpO2:</strong> {{ $fisik->spo ?? '-' }} %</td>
                    <td><strong>Skor Nyeri:</strong>
                        {!! $cb($fisik->skor_nyeri, '<5') !!} &lt;5 &nbsp;
                        {!! $cb($fisik->skor_nyeri, '5-9') !!} 5-9 &nbsp;
                        {!! $cb($fisik->skor_nyeri, '>=10') !!} &ge;10
                    </td>
                </tr>
                <tr>
                    <td><strong>BBL:</strong> {{ $fisik->bbl_pbl ?? '-' }}</td>
                    <td><strong>BB Skg:</strong> {{ $fisik->bb_sekarang ?? '-' }} g</td>
                    <td><strong>PB Skg:</strong> {{ $fisik->pb_sekarang ?? '-' }} cm</td>
                    <td><strong>LK / LD:</strong> {{ $fisik->lk_ld ?? '-' }} cm</td>
                </tr>
                <tr>
                    <td><strong>Ballard Score:</strong> {{ $fisik->bollard_score ?? '-' }}</td>
                    <td><strong>Down Score:</strong> {{ $fisik->down_score ?? '-' }}</td>
                    <td colspan="2">
                        Anemia: {!! $cb($fisik->anemia, '1') !!} Ya {!! $cb($fisik->anemia, '0') !!} T |
                        Ikterik: {!! $cb($fisik->ikterik, '1') !!} Ya {!! $cb($fisik->ikterik, '0') !!} T |
                        Sianosis: {!! $cb($fisik->sianosis, '1') !!} Ya {!! $cb($fisik->sianosis, '0') !!} T <br>
                        Merintih: {!! $cb($fisik->merintih, '1') !!} Ya {!! $cb($fisik->merintih, '0') !!} T |
                        Dispnoe: {!! $cb($fisik->dispnoe, '1') !!} Ya {!! $cb($fisik->dispnoe, '0') !!} T |
                        Edema: {!! $cb($fisik->edema, '1') !!} Ya {!! $cb($fisik->edema, '0') !!} T
                    </td>
                </tr>
            </table>
        </div>

        <div class="keep-together">
            <div class="section-title">6. Status Generalis</div>
            <table class="table-border">
                <tr>
                    <td class="bg-gray fw-bold" width="160px">1. Kepala</td>
                    <td>
                        <div class="list-row">a.Bentuk: {{ $fisik->kepala_bentuk ?? '-' }} </div>
                        <div class="list-row">b.UUB: {{ $fisik->kepala_uub ?? '-' }}</div>
                        <div class="list-row">c.UUK: {{ $fisik->kepala_uuk ?? '-' }}</div>
                        <div class="list-row">d.Caput: {!! $cb($fisik->caput_sucedaneum, '1') !!} Ya {!! $cb($fisik->caput_sucedaneum, '0') !!} T</div>
                        <div class="list-row">e.Cephalo: {!! $cb($fisik->cephalohematom, '1') !!} Ya {!! $cb($fisik->cephalohematom, '0') !!} T</div>
                        <div class="list-row">Ø: {{ $fisik->kepala_lp ?? '-' }} cm </div>
                        <div class="list-row">f.Lainnya: {{ $fisik->kepala_lain ?? '-' }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">2. Mata</td>
                    <td>
                        Pucat: {!! $cba('1', $fisik->mata_pucat) !!} Ya |
                        Ikterik: {!! $cba('1', $fisik->mata_ikterik) !!} Ya |
                        Pupil: {!! $cb($fisik->pupil, 'isokor') !!} Isokor {!! $cb($fisik->pupil, 'anisokor') !!} Anisokor <br>
                        Ref. Cahaya: {{ $fisik->refleks_cahaya ?? '-' }} |
                        Ref. Kornea: {{ $fisik->refleks_kornea ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">3. Hidung</td>
                    <td>Nafas Cuping: {!! $cb($fisik->nafas_cuping, '1') !!} Ya {!! $cb($fisik->nafas_cuping, '0') !!} T |
                        Lainnya: {{ $fisik->hidung_lain ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">4. Telinga</td>
                    <td>Keterangan: {{ $fisik->telinga_keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">5. Mulut</td>
                    <td>Sianosis: {!! $cb($fisik->mulut_sianosis, '1') !!} Ya {!! $cb($fisik->mulut_sianosis, '0') !!} T |
                        Lidah: {{ $fisik->mulut_lidah ?? '-' }} | Tenggorokan: {{ $fisik->mulut_tenggorokan ?? '-' }}
                        |
                        Lainnya: {{ $fisik->mulut_lain ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">6. Leher</td>
                    <td>KGB: {{ $fisik->leher_kgb ?? '-' }} | TVJ: {{ $fisik->leher_tvj ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">7. Thoraks</td>
                    <td>
                        <div class="list-row">Bentuk:
                            {!! $cba('simetris', $fisik->thoraks_bentuk) !!} Simetris
                            {!! $cba('asimetris', $fisik->thoraks_bentuk) !!} Asimetris
                            | Areola Mamae: {{ $fisik->thoraks_areola_mamae ?? '-' }}</div>
                        <div class="list-row"><strong>Jantung:</strong> HR: {{ $fisik->thoraks_hr }} |
                            Murmur: {{ $fisik->thoraks_murmur }} |
                            Bunyi: {{ $fisik->thoraks_bunyi_jantung }}</div>
                        <div class="list-row"><strong>Paru:</strong> Retraksi: {{ $fisik->thoraks_retraksi }} |
                            Merintih: {{ $fisik->thoraks_merintih }} | RR: {{ $fisik->thoraks_rr }} |
                            Suara Nafas: {{ $fisik->thoraks_suara_nafas }} ({{ $fisik->thoraks_suara_tambahan }})
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">8. Abdomen</td>
                    <td>
                        <div class="list-row">Distensi: {{ $fisik->abdomen_distensi ?? '-' }} |
                            Bising Usus: {{ $fisik->abdomen_bising_usus ?? '-' }} |
                            Venektasi: {!! $cb($fisik->abdomen_venektasi, '1') !!} Ya {!! $cb($fisik->abdomen_venektasi, '0') !!} T |
                            Hepar: {{ $fisik->abdomen_hepar ?? '-' }} | Lien: {{ $fisik->abdomen_lien ?? '-' }}</div>
                        <div class="list-row"><strong>Tali Pusat:</strong>
                            {!! $cba('segar', $fisik->abdomen_tali_pusat) !!} Segar
                            {!! $cba('layu', $fisik->abdomen_tali_pusat) !!} Layu
                            {!! $cba('bau', $fisik->abdomen_tali_pusat) !!} Bau
                            {!! $cba('kering', $fisik->abdomen_tali_pusat) !!} Kering
                            {!! $cba('basah', $fisik->abdomen_tali_pusat) !!} Basah
                        </div>
                        <div class="list-row">
                            Arteri: {!! $cb($fisik->abdomen_arteri, '1') !!} 1 {!! $cb($fisik->abdomen_arteri, '2') !!} 2 |
                            Vena: {!! $cb($fisik->abdomen_vena, '1') !!} 1 |
                            Kelainan: {{ $fisik->abdomen_kelainan }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">9. Genetalia</td>
                    <td>
                        {!! $cb($fisik->genetalia, 'laki-laki') !!} Laki-laki &nbsp;
                        {!! $cb($fisik->genetalia, 'perempuan') !!} Perempuan &nbsp;
                        {!! $cb($fisik->genetalia, 'ambigus') !!} Ambigus
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">10. Anus</td>
                    <td>Ket: {{ $fisik->anus_keterangan ?? '-' }} | Mekonium:
                        {!! $cb($fisik->anus_mekonium, '1') !!} Ya {!! $cb($fisik->anus_mekonium, '0') !!} T</td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">11. Ekstremitas</td>
                    <td>Plantar Creases:
                        {!! $cba('1/3 anterior', $fisik->plantar_creases) !!} 1/3 Ant &nbsp;
                        {!! $cba('2/3 anterior', $fisik->plantar_creases) !!} 2/3 Ant &nbsp;
                        {!! $cba('>2/3 anterior', $fisik->plantar_creases) !!} >2/3 Ant
                        <br>
                        CRT:
                        {!! $cb($fisik->waktu_pengisian_kapiler, '<2') !!} &lt;2 dtk &nbsp;
                        {!! $cb($fisik->waktu_pengisian_kapiler, '>2') !!} &gt;2 dtk
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">12. Kulit</td>
                    <td>
                        <div class="cb-item">{!! $cba('pucat', $fisik->kulit) !!} Pucat</div>
                        <div class="cb-item">{!! $cba('ikterik', $fisik->kulit) !!} Ikterik</div>
                        <div class="cb-item">{!! $cba('mottled', $fisik->kulit) !!} Mottled</div>
                        <div class="cb-item">{!! $cba('ptekie', $fisik->kulit) !!} Ptekie</div>
                        <div class="cb-item">{!! $cba('ekimosis', $fisik->kulit) !!} Ekimosis</div>
                        <div class="cb-item">{!! $cba('hematoma', $fisik->kulit) !!} Hematoma</div>
                        <div class="cb-item">{!! $cba('sklerema', $fisik->kulit) !!} Sklerema</div>
                        ({{ $fisik->kulit_lainnya }})
                    </td>
                </tr>
                <tr>
                    <td class="bg-gray fw-bold">13. Kuku</td>
                    <td>
                        <div class="cb-item">{!! $cba('sianosis', $fisik->kuku) !!} Sianosis</div>
                        <div class="cb-item">{!! $cba('meconium stain', $fisik->kuku) !!} Meconium Stain</div>
                        <div class="cb-item">{!! $cba('panjang', $fisik->kuku) !!} Panjang</div>
                        ({{ $fisik->kuku_lainnya }})
                    </td>
                </tr>
            </table>
        </div>

        <div class="keep-together">
            <div class="section-title">7. Apgar Skor</div>
            <table class="table-border text-center">
                <tr class="bg-gray">
                    <th>Kriteria</th>
                    <th>1 Menit</th>
                    <th>5 Menit</th>
                </tr>
                <tr>
                    <td>Warna Kulit (Appearance)</td>
                    <td>{{ $dtl->appearance_1 }}</td>
                    <td>{{ $dtl->appearance_5 }}</td>
                </tr>
                <tr>
                    <td>Denyut Jantung (Pulse)</td>
                    <td>{{ $dtl->pulse_1 }}</td>
                    <td>{{ $dtl->pulse_5 }}</td>
                </tr>
                <tr>
                    <td>Refleks (Grimace)</td>
                    <td>{{ $dtl->grimace_1 }}</td>
                    <td>{{ $dtl->grimace_5 }}</td>
                </tr>
                <tr>
                    <td>Tonus Otot (Activity)</td>
                    <td>{{ $dtl->activity_1 }}</td>
                    <td>{{ $dtl->activity_5 }}</td>
                </tr>
                <tr>
                    <td>Usaha Nafas (Respiration)</td>
                    <td>{{ $dtl->respiration_1 }}</td>
                    <td>{{ $dtl->respiration_5 }}</td>
                </tr>
                <tr class="fw-bold bg-gray">
                    <td>TOTAL</td>
                    <td>{{ $dtl->total_1_minute }}</td>
                    <td>{{ $dtl->total_5_minute }}</td>
                </tr>
                <tr>
                    <td colspan="3">Total Gabungan: {{ $dtl->total_combined }}</td>
                </tr>
            </table>
        </div>

        <div class="keep-together">
            <div class="section-title">8. Diagnosis Ibu, Persalinan & Faktor Resiko</div>
            <div class="list-container">

                <div class="list-row" style="margin-bottom: 8px;">
                    <table style="width: 100%; border: none; margin-bottom: 0;">
                        <tr>
                            <td style="width: 160px; font-weight: bold; border: none; padding: 0;">Diagnosis Ibu</td>
                            <td style="width: 10px; border: none; padding: 0;">:</td>
                            <td style="border: none; padding: 0;">
                                @if ($dtl->diagnosis_ibu_1)
                                    <div style="display: block;">1. {{ $dtl->diagnosis_ibu_1 }}</div>
                                @endif
                                @if ($dtl->diagnosis_ibu_2)
                                    <div style="display: block;">2. {{ $dtl->diagnosis_ibu_2 }}</div>
                                @endif
                                @if ($dtl->diagnosis_ibu_3)
                                    <div style="display: block;">3. {{ $dtl->diagnosis_ibu_3 }}</div>
                                @endif
                                @if (!$dtl->diagnosis_ibu_1 && !$dtl->diagnosis_ibu_2 && !$dtl->diagnosis_ibu_3)
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="list-row" style="margin-bottom: 8px;">
                    <table style="width: 100%; border: none; margin-bottom: 0;">
                        <tr>
                            <td style="width: 160px; font-weight: bold; border: none; padding: 0;">Cara Persalinan</td>
                            <td style="width: 10px; border: none; padding: 0;">:</td>
                            <td style="border: none; padding: 0;">
                                <div class="cb-item">{!! $cba('spontan', $dtl->cara_persalinan) !!} Spontan</div>
                                <div class="cb-item">{!! $cba('sc', $dtl->cara_persalinan) !!} SC</div>
                                <div class="cb-item">{!! $cba('vacum', $dtl->cara_persalinan) !!} Vacum</div>
                                <div class="cb-item">{!! $cba('forceps', $dtl->cara_persalinan) !!} Forceps</div>
                                <div style="margin-top: 4px; font-weight: bold;">Indikasi: {{ $dtl->indikasi ?? '-' }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="list-row" style="margin-bottom: 8px;">
                    <table style="width: 100%; border: none; margin-bottom: 0;">
                        <tr>
                            <td style="width: 160px; font-weight: bold; border: none; padding: 0;">Faktor Resiko Mayor
                            </td>
                            <td style="width: 10px; border: none; padding: 0;">:</td>
                            <td style="border: none; padding: 0;">
                                <div style="font-size: 8pt; line-height: 1.3;">
                                    <div class="cb-item">{!! $cba('demam', $dtl->faktor_resiko_mayor) !!} Demam (>38°C)</div>
                                    <div class="cb-item">{!! $cba('kpd_18', $dtl->faktor_resiko_mayor) !!} KPD > 18 Jam</div>
                                    <div class="cb-item">{!! $cba('korioamnionitis', $dtl->faktor_resiko_mayor) !!} Korioamnionitis</div>
                                    <div class="cb-item">{!! $cba('fetal_distress', $dtl->faktor_resiko_mayor) !!} Fetal distress</div>
                                    <div class="cb-item">{!! $cba('ketuban_berbau', $dtl->faktor_resiko_mayor) !!} Ketuban berbau</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="list-row">
                    <table style="width: 100%; border: none; margin-bottom: 0;">
                        <tr>
                            <td style="width: 160px; font-weight: bold; border: none; padding: 0;">Faktor Resiko Minor
                            </td>
                            <td style="width: 10px; border: none; padding: 0;">:</td>
                            <td style="border: none; padding: 0;">
                                <div style="font-size: 8pt; line-height: 1.3;">
                                    <div class="cb-item">{!! $cba('kpd_12', $dtl->faktor_resiko_minor) !!} KPD > 12 Jam</div>
                                    <div class="cb-item">{!! $cba('apgar_skor', $dtl->faktor_resiko_minor) !!} APGAR Skor 1'&lt;5 atau 5'&lt; 7
                                    </div>
                                    <div class="cb-item">{!! $cba('bblsr', $dtl->faktor_resiko_minor) !!} BBLSR (&lt;1500g)</div>
                                    <div class="cb-item">{!! $cba('gestasi', $dtl->faktor_resiko_minor) !!} Gestasi &lt; 37 mggu</div>
                                    <div class="cb-item">{!! $cba('gemelli', $dtl->faktor_resiko_minor) !!} Gemelli</div>
                                    <div class="cb-item">{!! $cba('keputihan_tdk_diobati', $dtl->faktor_resiko_minor) !!} Keputihan tdk diobati</div>
                                    <div class="cb-item">{!! $cba('isk_susp_isk', $dtl->faktor_resiko_minor) !!} ISK/ Susp. ISK</div>
                                    <div class="cb-item">{!! $cba('ibu_demam', $dtl->faktor_resiko_minor) !!} Ibu demam > 38°C</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>

        <div class="section-title">9. Refleks Primitif</div>
        <table class="table-border">
            <tr>
                <td>Moro: {!! $cb($dtl->refleks_moro, '1') !!} Ya {!! $cb($dtl->refleks_moro, '0') !!} T</td>
                <td>Rooting: {!! $cb($dtl->refleks_rooting, '1') !!} Ya {!! $cb($dtl->refleks_rooting, '0') !!} T</td>
                <td>Palmar Grasp: {!! $cb($dtl->refleks_palmar_grasping, '1') !!} Ya {!! $cb($dtl->refleks_palmar_grasping, '0') !!} T</td>
            </tr>
            <tr>
                <td>Sucking: {!! $cb($dtl->refleks_sucking, '1') !!} Ya {!! $cb($dtl->refleks_sucking, '0') !!} T</td>
                <td>Plantar Grasp: {!! $cb($dtl->refleks_plantar_grasping, '1') !!} Ya {!! $cb($dtl->refleks_plantar_grasping, '0') !!} T</td>
                <td>Tonic Neck: {!! $cb($dtl->refleks_tonic_neck, '1') !!} Ya {!! $cb($dtl->refleks_tonic_neck, '0') !!} T</td>
            </tr>
        </table>

        <div class="section-title">10. Kelainan Bawaan</div>
        <div class="dots-value">1. {{ $dtl->kelainan_bawaan_1 ?? '-' }}, 2. {{ $dtl->kelainan_bawaan_2 ?? '-' }},
            3. {{ $dtl->kelainan_bawaan_3 ?? '-' }}, 4. {{ $dtl->kelainan_bawaan_4 ?? '-' }}</div>

        <div class="section-title">11. Pemeriksaan Penunjang</div>
        <div class="list-row"><span class="list-label">Laboratorium</span><span class="list-dash">:</span>
            {{ $dtl->hasil_laboratorium ?? '-' }}</div>
        <div class="list-row"><span class="list-label">Radiologi</span><span class="list-dash">:</span>
            {{ $dtl->hasil_radiologi ?? '-' }}</div>
        <div class="list-row"><span class="list-label">Lainnya</span><span class="list-dash">:</span>
            {{ $dtl->hasil_lainnya ?? '-' }}</div>

        <div class="section-title">12. Diagnosis</div>
        <div class="list-row"><span class="list-label">Diagnosis Kerja</span><span class="list-dash">:</span>
            {{ $fmt($dtl->diagnosis_kerja) }}</div>
        <div class="list-row"><span class="list-label">Diagnosis Banding</span><span class="list-dash">:</span>
            {{ $fmt($dtl->diagnosis_banding) }}</div>

        <div class="section-title">13. Rencana Pengobatan</div>
        <div class="dots-value">{{ $dtl->rencana_pengobatan ?? '-' }}</div>

        <div class="section-title">14. Prognosis</div>
        <div class="dots-value">@php
            $prognosis = $satsetPrognosis->where('prognosis_id', $dtl->prognosis)->first();
            echo $prognosis->value ?? '-';
        @endphp</div>

        <div class="keep-together">
            <div class="section-title">15. Perencanaan Pulang (Discharge Planning)</div>
            <div class="list-container">
                <div class="list-row"><span class="list-label">Ada yg Merawat Bayi</span><span
                        class="list-dash">:</span>
                    {!! $cb($dtl->usia_menarik_bayi, 'ya') !!} Ya ({{ $dtl->keterangan_usia }}) &nbsp;
                    {!! $cb($dtl->usia_menarik_bayi, 'tidak') !!} Tidak ({{ $dtl->keterangan_tidak_usia }})
                </div>
                <div class="list-row"><span class="list-label">Antisipasi Masalah</span><span
                        class="list-dash">:</span>
                    {!! $cb($dtl->masalah_pulang, 'ya') !!} Ya ({{ $dtl->keterangan_masalah_pulang }}) &nbsp;
                    {!! $cb($dtl->masalah_pulang, 'tidak') !!} Tidak
                </div>
                <div class="list-row"><span class="list-label">Resiko Finansial</span><span
                        class="list-dash">:</span>
                    {!! $cb($dtl->beresiko_finansial, 'ya') !!} Ya &nbsp;
                    {!! $cb($dtl->beresiko_finansial, 'tidak') !!} Tidak
                </div>
                <div class="list-row"><span class="list-label">Edukasi Diperlukan</span><span
                        class="list-dash">:</span>
                    <div style="margin-left: 175px; margin-top: -15px;">
                        <div class="cb-item">{!! $cba('menyusui', $dtl->edukasi) !!} Menyusui</div>
                        <div class="cb-item">{!! $cba('memandikan', $dtl->edukasi) !!} Memandikan</div>
                        <div class="cb-item">{!! $cba('berpakaian', $dtl->edukasi) !!} Berpakaian</div>
                        <div class="cb-item">{!! $cba('perawatan_bayi_dasar', $dtl->edukasi) !!} Perawatan dasar</div>
                        <div class="cb-item">{!! $cba('mengukur_suhu', $dtl->edukasi) !!} Mengukur suhu</div>
                        <div class="cb-item">{!! $cba('perawatan_kulit_kelamin', $dtl->edukasi) !!} Perawatan kulit/kelamin</div>
                        <div class="cb-item">{!! $cba('lainnya', $dtl->edukasi) !!} Lainnya
                            ({{ $dtl->edukasi_lainnya_keterangan }})</div>
                    </div>
                </div>
                <div class="list-row"><span class="list-label">Ada yg Membantu</span><span class="list-dash">:</span>
                    {!! $cb($dtl->ada_membantu, 'ada') !!} Ada ({{ $dtl->keterangan_membantu }}) &nbsp;
                    {!! $cb($dtl->ada_membantu, 'tidak') !!} Tidak
                </div>
                <div class="list-row"><span class="list-label">Lama Rawat</span><span class="list-dash">:</span>
                    {{ $dtl->perkiraan_lama_rawat ?? '-' }} Hari</div>
                <div class="list-row"><span class="list-label">Rencana Pulang</span><span class="list-dash">:</span>
                    {{ !empty($dtl->rencana_tanggal_pulang) ? date('d-m-Y', strtotime($dtl->rencana_tanggal_pulang)) : '-' }}
                </div>
            </div>
        </div>

        <table width="100%" style="margin-top: 40px;">
            <tr>
                <td width="65%"></td>
                <td align="center">
                    Langsa,
                    {{ !empty($asesmen->waktu_asesmen) ? date('d-m-Y', strtotime($asesmen->waktu_asesmen)) : date('d-m-Y') }}<br>
                    Dokter Pemeriksa,<br><br>
                    @php
                        $namaDok = trim(
                            ($asesmen->user->karyawan->gelar_depan ?? '') .
                                ' ' .
                                ($asesmen->user->karyawan->nama ?? '') .
                                ' ' .
                                ($asesmen->user->karyawan->gelar_belakang ?? ''),
                        );
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
