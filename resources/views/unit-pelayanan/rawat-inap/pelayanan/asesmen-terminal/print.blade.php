@php
    $asesmen = $data['asesmen'] ?? null;
@endphp

<div class="terminal-print-wrapper">
    <style>
        .terminal-print-wrapper {
            font-family: "DejaVu Sans", "Helvetica", "Arial", sans-serif !important;
            font-size: 8pt;
            padding: 10px;
            background: white;
        }

        .terminal-print-wrapper .a4 {
            width: 100%;
            max-width: 100%;
        }

        .terminal-print-wrapper table {
            width: 100%;
            border-collapse: collapse;
        }

        .terminal-print-wrapper td,
        .terminal-print-wrapper th {
            padding: 4px 6px;
            vertical-align: top;
        }

        .terminal-print-wrapper .label {
            font-weight: bold;
            width: 38%;
            padding-right: 8px;
        }

        .terminal-print-wrapper .value {
            border-bottom: 1px solid #000;
            min-height: 22px;
        }

        .terminal-print-wrapper .value.tall {
            min-height: 32px;
        }

        .terminal-print-wrapper .value.empty-space {
            min-height: 60px;
        }

        .terminal-print-wrapper .checkbox-group {
            font-family: "DejaVu Sans", sans-serif !important;
        }

        .terminal-print-wrapper .checkbox-group label {
            margin-right: 28px;
            display: inline-block;
        }

        .terminal-print-wrapper input[type="checkbox"]:checked {
            background: #fff;
        }

        .terminal-print-wrapper input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            top: -10px;
            left: 1px;
            font-size: 16px;
            color: #000;
            line-height: 1;
        }

        .terminal-print-wrapper .obat-item {
            border-bottom: 1px dotted #666;
            padding: 2px 6px;
            margin-bottom: 2px;
        }

        .terminal-print-wrapper .header {
            display: flex;
            align-items: stretch;
            margin-bottom: 10mm;
            border-bottom: 1px solid #000;
            width: 100%;
        }

        .terminal-print-wrapper .patient-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .terminal-print-wrapper .patient-table th,
        .terminal-print-wrapper .patient-table td {
            border: 1px solid #ccc;
            padding: 5px 7px;
            font-size: 9pt;
        }

        .terminal-print-wrapper .patient-table th {
            background-color: #f2f2f2;
            text-align: left;
            width: 130px;
        }

        .terminal-print-wrapper .header-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f0f0f0;
            padding: 0;
            position: relative;
        }

        .terminal-print-wrapper .td-left {
            width: 40%;
            text-align: left;
            vertical-align: middle;
        }

        .terminal-print-wrapper .td-center {
            width: 40%;
            text-align: center;
            vertical-align: middle;
        }

        .terminal-print-wrapper .brand-table {
            border-collapse: collapse;
            background-color: transparent;
        }

        .terminal-print-wrapper .va-middle {
            vertical-align: middle;
        }

        .terminal-print-wrapper .brand-logo {
            width: 60px;
            height: auto;
            margin-right: 2px;
        }

        .terminal-print-wrapper .brand-name {
            font-weight: 700;
            margin: 0;
            font-size: 14px;
        }

        .terminal-print-wrapper .brand-info {
            margin: 0;
            font-size: 7px;
        }

        .terminal-print-wrapper .title-main {
            display: block;
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .terminal-print-wrapper .title-sub {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin: 0;
        }

        .terminal-print-wrapper .unit-box {
            background-color: #bbbbbb;
            padding: 15px 0px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }

        .terminal-print-wrapper .unit-text {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
        }

        .terminal-print-wrapper .page-break {
            page-break-before: always;
        }

        .terminal-print-wrapper .cb {
            display: flex;
            align-items: center;
            gap: 20px;
            line-height: 1.4;
            margin-bottom: 2px;
        }

        .terminal-print-wrapper .cb input[type="checkbox"] {
            margin: 0;
            width: 25px;
            height: 15px;
            position: relative;
            top: -1px;
        }
    </style>

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
                <span class="title-main">ASESMEN AWAL DAN ULANG</span>
                <span class="title-sub">PASIEN TERMINAL DAN KELUARGA</span>
            </td>
            <td class="td-right">
                <div class="unit-box"><span class="unit-text" style="font-size: 14px; margin-top : 10px;">RAWAT
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
            <td>
                {{ $data['dataMedis']->pasien->tgl_lahir
                    ? \Carbon\Carbon::parse($data['dataMedis']->pasien->tgl_lahir)->age . ' tahun'
                    : '-' }}
            </td>
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td colspan="4"><strong>1. Gejala seperti mau muntah dan kesulitan bernafas</strong></td>
        </tr>

        <!-- 1.1 -->
        <tr>
            <td class="label" style="vertical-align: top; width : 120px;">1.1. Kegawatan pernafasan:</td>
            <td class="value">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->dyspnoe ? 'checked' : '' }}><span>Dyspnoe</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->nafas_tak_teratur ? 'checked' : '' }}><span>Nafas tak
                                teratur</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->nafas_tak_teratur ? 'checked' : '' }}><span>Ada
                                sekret</span></div>
                    </div>
                </div>
            </td>
            <td class="value">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->nafas_cepat_dangkal ? 'checked' : '' }}><span>Nafas
                                cepat dan dangkal</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->nafas_melalui_mulut ? 'checked' : '' }}><span>Nafas
                                melalui mulut</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->spo2_normal ? 'checked' : '' }}><span>SpO<sub>2</sub>
                                &lt; normal</span></div>
                    </div>
                </div>

            </td>
            <td class="value">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->nafas_lambat ? 'checked' : '' }}><span>Nafas
                                lambat</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->mukosa_oral_kering ? 'checked' : '' }}><span>Mukosa
                                oral kering</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->tak ? 'checked' : '' }}><span>T.A.K</span></div>
                    </div>
                </div>

            </td>
        </tr>
        <!-- 1.2 -->
        <tr>
            <td class="label" style="vertical-align: top;">1.2. Kehilangan tonus otot:</td>
            <td class="value">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->mual ? 'checked' : '' }}><span>Mual</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->sulit_menelan ? 'checked' : '' }}><span>Sulit
                                menelan</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->inkontinensia_alvi ? 'checked' : '' }}><span>Inkontinensia
                                alvi</span></div>
                    </div>
                </div>
            </td>
            <td class="value">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->penurunan_pergerakan ? 'checked' : '' }}><span>Penurunan
                                pergerakan tubuh</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->distensi_abdomen ? 'checked' : '' }}><span>Distensi
                                abdomen</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminal->sulit_berbicara ? 'checked' : '' }}><span>Sulit
                                berbicara</span></div>
                    </div>
                </div>

            </td>
            <td class="value">
                <div style="display:flex; gap:40px;">
                    <div class="cb"><input type="checkbox"><span>Inkontinensia urine</span></div>
                    <div class="cb"><input type="checkbox"><span>T.A.K</span></div>
                </div>
            </td>
        </tr>
        <!-- 1.3 -->
        <tr>
            <td class="label">1.3. Nyeri:</td>
            <td class="value" colspan="3">
                <div style="display:flex; gap:30px;">
                    <div class="cb"><input type="checkbox"
                            {{ !$asesmen->rmeAsesmenTerminal->nyeri ? 'checked' : '' }}><span>Tidak</span>
                    </div>
                    <div class="cb">
                        <input type="checkbox" {{ $asesmen->rmeAsesmenTerminal->nyeri ? 'checked' : '' }}>
                        {{-- @php
                        dd($asesmen->rmeAsesmenTerminal->nyeri_keterangan);
                        @endphp --}}
                        <span>Ya, lokasi: {{ $asesmen->rmeAsesmenTerminal->nyeri_keterangan ?? '' }}</span>
                    </div>
                </div>
            </td>
        </tr>


        <!-- 1.4 -->
        <tr>
            <td colspan="2"><strong>1.4. Perlambatan Sirkulasi :</strong></td>
            <td>
                <div style="display:flex; gap:30px;">
                    <div class="cb"> <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminal->bercerak_sianosis ? 'checked' : '' }}> Berak darah
                        sianosis pada ekstremitas</div>
                    <div class="cb"><input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminal->gelisah ? 'checked' : '' }}>
                        Gelisah </div>
                    <div class="cb"><input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminal->lemas ? 'checked' : '' }}>
                        Lemas</div>
                </div>
            </td>
            <td>
                <div style="display:flex; gap:30px;">
                    <div class="cb"> <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminal->kulit_dingin ? 'checked' : '' }}>Kulit dingin dan
                        berkeringat </div>
                    <div class="cb"> <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminal->tekanan_darah ? 'checked' : '' }}> Nadi lambat dan lemah
                    </div>
                    <div class="cb"> <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminal->tak3 ? 'checked' : '' }}>
                        T.A.K</div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4"><strong>2. Faktor Faktor yang meningkatkan dan membangkitkan gejala fisik </strong></td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="display:flex; gap:30px;">
                    <div class="cb"> <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminalFmo->melakukan_aktivitas ? 'checked' : '' }}> Melakukan
                        Aktifitas Fisik</div>
                </div>
            </td>
            <td>
                <div style="display:flex; gap:30px;">
                    <div class="cb"> <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminalFmo->pindah_posisi ? 'checked' : '' }}> Pindah Posisi</div>
                </div>
            </td>
            <td>
                <div style="display:flex; gap:30px;">
                    <div class="cb"> <input
                            type="checkbox">{{ $asesmen->rmeAsesmenTerminalFmo->faktor_lainnya ?? '' }}
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4"><strong>3. Manajemen gejala saat ini dan respon pasien : <br> Masalah Keperawatan
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div style="display:flex; gap:30px;">
                    <div class="cb">
                        <input type="checkbox" {{ $asesmen->rmeAsesmenTerminalFmo->masalah_mual ? 'checked' : '' }}>
                        <span>Mual</span>
                    </div>
                    <div class="cb">
                        <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminalFmo->masalah_perubahan_persepsi ? 'checked' : '' }}>
                        <span>Perubahan persepsi sensori</span>
                    </div>
                    <div class="cb">
                        <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminalFmo->masalah_pola_nafas ? 'checked' : '' }}">
                        <span>Pola nafas tidak efektif</span>
                    </div>
                </div>
            </td>

            <td>
                <div style="display:flex; gap:30px;">
                    <div class="cb">
                        <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminalFmo->masalah_nyeri_akut ? 'checked' : '' }}>
                        <span> Nyeri akut</span>
                    </div>
                    <div class="cb">
                        <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminalFmo->masalah_konstipasi ? 'checked' : '' }}">
                        <span>Konstipasi</span>
                    </div>
                    {{-- <div class="cb">
                        <input type="checkbox">
                        <span>Koping kronis</span>
                    </div> --}}
                </div>
            </td>

            <td>
                <div style="display:flex; gap:30px;">
                    {{-- <div class="cb">
                        <input type="checkbox">
                        <span>Bersihan jalan nafas tidak efektif</span>
                    </div> --}}
                    <div class="cb">
                        <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminalFmo->masalah_defisit_perawatan ? 'checked' : '' }}>
                        <span>Defisit perawatan diri</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4"><strong>4. Orientasi Spiritual pasien dan keluarga</strong>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                Apakah Perlu Pelayanan Spiritual ?
            </td>
            <td colspan="1">
                <div style="display:flex; gap:30px;">
                    <div class="cb">
                        <input type="checkbox"
                            {{ !$asesmen->rmeAsesmenTerminalFmo->perlu_pelayanan_spiritual ? 'checked' : '' }}>
                        Tidak
                    </div>
                </div>
            </td>

            <td colspan="1">
                <div style="display:flex; gap:30px;">
                    <div class="cb">
                        <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminalFmo->perlu_pelayanan_spiritual ? 'checked' : '' }}>
                        Ya
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4"><strong>5. Urusan dan kebutuhan spiritual pasien dan keluarga seperti putus asa,
                    penderitaan, rasa bersalah, pengampunan : </strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Perlu Di Doakan ?
            </td>
            <td colspan="1">
                <div style="display:flex; gap:30px;">
                    <div class="cb">
                        <input type="checkbox"
                            {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_didoakan ? 'checked' : '' }}>
                        Tidak
                    </div>
                </div>
            </td>

            <td colspan="1">
                <div style="display:flex; gap:30px;">
                    <div class="cb">
                        <input type="checkbox" {{ $asesmen->rmeAsesmenTerminalUsk->perlu_didoakan ? 'checked' : '' }}>
                        Ya
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Perlu Bimbingan Rohani ?
            </td>
            <td colspan="1">
                <div style="display:flex; gap:30px;">
                    <div class="cb">
                        <input type="checkbox"
                            {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_bimbingan_rohani ? 'checked' : '' }}>
                        Tidak
                    </div>
                </div>
            </td>

            <td colspan="1">
                <div style="display:flex; gap:30px;">
                    <div class="cb">
                        <input type="checkbox"
                            {{ $asesmen->rmeAsesmenTerminalUsk->perlu_bimbingan_rohani ? 'checked' : '' }}>
                        Ya
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="4"><strong>6. Status Psikososial dan keluarga : <br> 6.1 Apakah Ada Orang Yang Ingin
                    Dihubungi
                    Saat Ini ? <input type="checkbox"
                        {{ !$asesmen->rmeAsesmenTerminalUsk->orang_dihubungi ? 'checked' : '' }}> Tidak
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="cb">
                    <input type="checkbox" {{ $asesmen->rmeAsesmenTerminalUsk->orang_dihubungi ? 'checked' : '' }}>
                    Ya,
                    Siapa <span></span> Hubungan dengan Pasien Sebagai :
                    <span>{{ $asesmen->rmeAsesmenTerminalUsk->hubungan_pasien ?? '' }}</span> <br>
                    Nama : <span>{{ $asesmen->rmeAsesmenTerminalUsk->dinama ?? '' }} </span> Dimana :
                    <span>{{ $asesmen->rmeAsesmenTerminalUsk->nama_dihubungi ?? '' }}</span> No. Telepon/Hp :
                    <span>{{ $asesmen->rmeAsesmenTerminalUsk->no_telp_hp ?? '' }}</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="cb">
                    <strong>
                        6.2 Bagaimana rencana perawatan selanjutnya ?
                    </strong>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="cb">
                    <input type="checkbox" {{ $asesmen->rmeAsesmenTerminalUsk->tetap_dirawat_rs ? 'checked' : '' }}>
                    Tetap Di Rawat di RS
                </div>
            </td>
            <td colspan="2">
                <div class="cb">
                    <input type="checkbox" {{ $asesmen->rmeAsesmenTerminalUsk->dirawat_rumah ? 'checked' : '' }}>
                    Dirawat Dirumah
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <div class="cb">

                    Apakah Sudah Disiapkan ?
                </div>
            </td>
            <td colspan="">
                <div class="cb">
                    <input type="checkbox"
                        {{ $asesmen->rmeAsesmenTerminalUsk->lingkungan_rumah_siap ? 'checked' : '' }}> Ya
                </div>
            </td>
            <td colspan="">
                <div class="cb">
                    <input type="checkbox"
                        {{ !$asesmen->rmeAsesmenTerminalUsk->lingkungan_rumah_siap ? 'checked' : '' }}>Tidak
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="cb">
                    Jika Ya, Apakah ada yang mampu merawat pasien di rumah ?
                </div>
            </td>
            <td>
                <div class="cb">
                    <input type="checkbox"
                        {{ $asesmen->rmeAsesmenTerminalUsk->mampu_merawat_rumah ? 'checked' : '' }}>Ya. Oleh :
                    <span>{{ $asesmen->rmeAsesmenTerminalUsk->perawat_rumah_oleh ?? '' }}</span>
                </div>
            </td>
            <td>
                <div class="cb">
                    <input type="checkbox"
                        {{ !$asesmen->rmeAsesmenTerminalUsk->mampu_merawat_rumah ? 'checked' : '' }}>Tidak<span></span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="cb">
                    Jika Tidak, apakah perlu difasilitasi RS (Home Care) ?
                </div>
            </td>
            <td>
                <div class="cb">
                    <input type="checkbox" {{ $asesmen->rmeAsesmenTerminalUsk->perlu_home_care ? 'checked' : '' }}> Ya
                    <span></span>
                </div>
            </td>
            <td>
                <div class="cb">
                    <input type="checkbox"
                        {{ !$asesmen->rmeAsesmenTerminalUsk->perlu_home_care ? 'checked' : '' }}>Tidak<span></span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="cb">
                    <strong>
                        6.3 Reaksi Pasien Atas Penyakit nya <br> Asesmen Informasi ?
                    </strong>
                </div>
            </td>
        </tr>
        <tr>
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_menyangkal ? 'checked' : '' }}><span>Menyangkal</span>
                        </div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_marah ? 'checked' : '' }}><span>Marah</span>
                        </div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_takut ? 'checked' : '' }}><span>Takut</span>
                        </div>
                    </div>
                </div>
            </td>
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_sedih_menangis ? 'checked' : '' }}><span>Sedih
                                / Menangis</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_rasa_bersalah ? 'checked' : '' }}><span>Rasa
                                bersalah</span></div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_ketidak_berdayaan ? 'checked' : '' }}"><span>Ketidak
                                Berdayaan</span></div>
                    </div>
                </div>

            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="cb">
                    <strong>
                        Masalah Keperawatan ?
                    </strong>
                </div>
            </td>
        </tr>
        <tr>
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_anxietas ? 'checked' : '' }}><span>Anxietas</span>
                        </div>

                    </div>
                </div>
            </td>
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->reaksi_distress_spiritual ? 'checked' : '' }}><span>Disstres
                                Spiritual</span></div>

                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="cb">
                    <strong>6.4 Reaksi keluarga atas penyakit pasien</strong>
                </div>
            </td>
        </tr>

        <tr>
            <!-- KOLOM KIRI -->
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb">
                            <input type="checkbox" name="keluarga_marah" id="keluarga_marah" value="1"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_marah ? 'checked' : '' }} disabled>
                            <label for="keluarga_marah">Marah</label>
                        </div>

                        <div class="cb">
                            <input type="checkbox" name="keluarga_gangguan_tidur" id="keluarga_gangguan_tidur"
                                value="1"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_gangguan_tidur ? 'checked' : '' }}
                                disabled>
                            <label for="keluarga_gangguan_tidur">Gangguan tidur</label>
                        </div>

                        <div class="cb">
                            <input type="checkbox" name="keluarga_penurunan_konsentrasi"
                                id="keluarga_penurunan_konsentrasi" value="1"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_penurunan_konsentrasi ? 'checked' : '' }}
                                disabled>
                            <label for="keluarga_penurunan_konsentrasi">Penurunan Konsentrasi</label>
                        </div>

                        <div class="cb">
                            <input type="checkbox" name="keluarga_ketidakmampuan_memenuhi_peran"
                                id="keluarga_ketidakmampuan_memenuhi_peran" value="1"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_ketidakmampuan_memenuhi_peran ? 'checked' : '' }}
                                disabled>
                            <label for="keluarga_ketidakmampuan_memenuhi_peran">
                                Ketidakmampuan memenuhi peran yang diharapkan
                            </label>
                        </div>

                        <div class="cb">
                            <input type="checkbox" name="keluarga_kurang_berkomunikasi"
                                id="keluarga_kurang_berkomunikasi" value="1"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_kurang_berkomunikasi ? 'checked' : '' }}
                                disabled>
                            <label for="keluarga_kurang_berkomunikasi">
                                Keluarga kurang berkomunikasi dengan pasien
                            </label>
                        </div>
                    </div>
                </div>
            </td>

            <!-- KOLOM KANAN -->
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb">
                            <input type="checkbox" name="keluarga_leth_lelah" id="keluarga_leth_lelah"
                                value="1"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_leth_lelah ? 'checked' : '' }} disabled>
                            <label for="keluarga_leth_lelah">Letih / lelah</label>
                        </div>

                        <div class="cb">
                            <input type="checkbox" name="keluarga_rasa_bersalah" id="keluarga_rasa_bersalah"
                                value="1"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_rasa_bersalah ? 'checked' : '' }}
                                disabled>
                            <label for="keluarga_rasa_bersalah">Rasa bersalah</label>
                        </div>

                        <div class="cb">
                            <input type="checkbox" name="keluarga_perubahan_pola_komunikasi"
                                id="keluarga_perubahan_pola_komunikasi" value="1"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_perubahan_pola_komunikasi ? 'checked' : '' }}
                                disabled>
                            <label for="keluarga_perubahan_pola_komunikasi">
                                Perubahan kebiasaan pola komunikasi
                            </label>
                        </div>

                        <div class="cb">
                            <input type="checkbox" name="keluarga_kurang_berpartisipasi"
                                id="keluarga_kurang_berpartisipasi" value="1"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_kurang_berpartisipasi ? 'checked' : '' }}
                                disabled>
                            <label for="keluarga_kurang_berpartisipasi">
                                Keluarga kurang berpartisipasi membuat keputusan dalam perawatan pasien
                            </label>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="cb">
                    <strong>
                        Masalah Keperawatan ?
                    </strong>
                </div>
            </td>
        </tr>
        <tr>
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->masalah_koping_individu_tidak_efektif ? 'checked' : '' }}><span>Anxietas</span>
                        </div>

                    </div>
                </div>
            </td>
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->masalah_distress_spiritual ? 'checked' : '' }}><span>Disstres
                                Spiritual</span></div>

                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <div class="cb">
                    <strong>
                        7. Kebutuhan dukungan atau kelonggaran pelayanan bagi pasien, Keluarga dan pemberi pelayanan
                        lain :
                    </strong>
                </div>
            </td>
        </tr>
        <tr>
            <td class="value" colspan="4">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->pasien_perlu_didampingi ? 'checked' : '' }}><span>Pasien
                                Perlu Di dampingi keluarga</span></div>

                    </div>
                </div>
            </td>

        </tr>
        <tr>
            <td class="value" colspan="4">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->keluarga_dapat_mengunjungi_luar_waktu ? 'checked' : '' }}><span>Keluarga
                                dapat mengunjungi pasien di luar waktu
                                berkunjung</span></div>

                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="value" colspan="4">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb"><input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalUsk->sahabat_dapat_mengunjungi ? 'checked' : '' }}"><span>Sahabat
                                dapat mengunjungi pasien di luar waktu
                                berkunjungi</span></div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="cb">
                    <strong>
                        8. Apakah ada kebutuhan akan alternatif atau tingkat pelayanan lain :
                    </strong>
                </div>
            </td>
        </tr>
        <tr>
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb">
                            <div><input type="checkbox"
                                    {{ $asesmen->rmeAsesmenTerminalAf->alternatif_tidak ? 'checked' : '' }}><span>Tidak
                                </span></div>
                            <div> <input type="checkbox"
                                    {{ $asesmen->rmeAsesmenTerminalAf->alternatif_donasi_organ ? 'checked' : '' }}><span>Donasi
                                    Organ : </span></div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb">
                            <div> <input type="checkbox"
                                    {{ $asesmen->rmeAsesmenTerminalAf->alternatif_autopsi ? 'checked' : '' }}><span>Autopsi
                                </span></div>
                            <div>
                                <span>Keterangan : {{ $asesmen->rmeAsesmenTerminal->nyeri_keterangan ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </td>

        </tr>
        <tr>
            <td colspan="4">
                <div class="cb">
                    <strong>
                        9. Faktor resiko keluarga yang ditinggalkan : <br>
                        Asesmen Informasi :
                    </strong>
                </div>
            </td>
        </tr>
        <tr>
            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb">
                            <input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_marah ? 'checked' : '' }}disabled>
                            <span>Marah</span>
                        </div>

                        <div class="cb">
                            <input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_depresi ? 'checked' : '' }}disabled>
                            <span>Depresi</span>
                        </div>

                        <div class="cb">
                            <input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_rasa_bersalah ? 'checked' : '' }}disabled>
                            <span>Rasa Bersalah</span>
                        </div>

                        <div class="cb">
                            <input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_perubahan_kebiasaan ? 'checked' : '' }}disabled>
                            <span>Perubahan Kebiasaan Pola Komunikasi</span>
                        </div>

                        <div class="cb">
                            <input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_tidak_mampu_memenuhi ? 'checked' : '' }}disabled>
                            <span>Ketidakmampuan memenuhi peran yang diharapkan</span>
                        </div>
                    </div>
                </div>
            </td>

            <td class="value" colspan="2">
                <div style="display:flex; gap:40px;">
                    <div>
                        <div class="cb">
                            <input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_leth_lelah ? 'checked' : '' }}
                                disabled>
                            <span>Letih / Lelah</span>
                        </div>

                        <div class="cb">
                            <input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_gangguan_tidur ? 'checked' : '' }}
                                disabled>
                            <span>Gangguan Tidur</span>
                        </div>

                        <div class="cb">
                            <input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_sedih_menangis ? 'checked' : '' }}
                                disabled>
                            <span>Sedih / Menangis</span>
                        </div>

                        <div class="cb">
                            <input type="checkbox"
                                {{ $asesmen->rmeAsesmenTerminalAf->faktor_resiko_penurunan_konsentrasi ? 'checked' : '' }}
                                disabled>
                            <span>Penurunan Konsentrasi</span>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <div class="cb">
                    <strong>Masalah Keperawatan</strong>
                </div>
            </td>
        </tr>

        <tr>
            <td class="value" colspan="2">
                <div class="cb">
                    <input type="checkbox"
                        {{ $asesmen->rmeAsesmenTerminalAf->masalah_koping_keluarga_tidak_efektif ? 'checked' : '' }}
                        disabled>
                    <span>Koping keluarga tidak efektif</span>
                </div>
            </td>

            <td class="value" colspan="2">
                <div class="cb">
                    <input type="checkbox"
                        {{ $asesmen->rmeAsesmenTerminalAf->masalah_distress_spiritual_keluarga ? 'checked' : '' }}
                        disabled>
                    <span>Distress Spiritual</span>
                </div>
            </td>
        </tr>

    </table>
    <!-- Tanda Tangan -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <!-- KIRI : TANGGAL & JAM -->
            <td width="50%" valign="top">
                <p>
                    Tanggal :
                    {{ optional($asesmen->rmeAsesmenParu)->tanggal
                        ? date('d/m/Y', strtotime($asesmen->rmeAsesmenParu->tanggal))
                        : '.............................' }}
                </p>
                <p>
                    Jam :
                    {{ optional($asesmen->rmeAsesmenParu)->jam_masuk
                        ? date('H:i', strtotime($asesmen->rmeAsesmenParu->jam_masuk))
                        : '.............................' }}
                </p>
            </td>

            <!-- KANAN : QR + DOKTER -->
            <td width="50%" valign="top" align="right">
                <div style="text-align:center; display:inline-block;">
                    <p>Dokter yang memeriksa</p>

                    <img src="{{ generateQrCode(
                        trim(
                            ($asesmen->user->karyawan->gelar_depan ?? '') .
                                ' ' .
                                str()->title($asesmen->user->karyawan->nama ?? '') .
                                ' ' .
                                ($asesmen->user->karyawan->gelar_belakang ?? ''),
                        ),
                        100,
                        'svg_datauri',
                    ) }}"
                        alt="QR Petugas" style="margin:6px 0;">

                    <p>
                        {{ trim(
                            ($asesmen->user->karyawan->gelar_depan ?? '') .
                                ' ' .
                                str()->title($asesmen->user->karyawan->nama ?? '') .
                                ' ' .
                                ($asesmen->user->karyawan->gelar_belakang ?? ''),
                        ) }}
                    </p>
                </div>
            </td>
        </tr>
    </table>
</div>
