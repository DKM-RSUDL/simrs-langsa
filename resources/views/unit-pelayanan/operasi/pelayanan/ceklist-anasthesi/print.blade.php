<style>
    body {
        font-family: "DejaVu Sans", sans-serif !important;
        font-size: 8px !important;
        /* diperkecil dari 13px */
    }



    .title-box {
        border-bottom: 1px solid #000;
        padding-bottom: 5px;
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 15px;
        /* turun dari 16px */
    }

    .header-grid {
        display: grid;
        row-gap: 4px;
        margin-bottom: 12px;
        font-size: 11px;
    }

    .table-section {
        width: 300px;
        border-collapse: collapse;
        margin-top: 8px;
        font-size: 11px;
    }

    .table-section th,
    .table-section td {
        border: 1px solid #000;
        padding: 5px;
        vertical-align: top;
    }

    .section-title {
        font-weight: bold;
        background: #eee;
        font-size: 11.5px;
    }

    .check-option {
        margin-bottom: 3px;
        line-height: 1;
    }

    .checkbox {
        border: 1px solid #000;
        display: inline-block;
        width: 10px;
        /* diperkecil dari 15px */
        height: 10px;
        margin-right: 6px;
        text-align: center;
        line-height: 10px;
        font-size: 10px;
        /* diperkecil */
        font-weight: bold;
        font-family: "DejaVu Sans", sans-serif !important;
        vertical-align: middle;
    }

    .footer-sign {
        width: 1050px;
        margin-top: 15px;
        font-size: 11px;
    }

    .footer-sign td {
        padding: 5px;
        height: 70px;
        
    }

    .header-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #f0f0f0;
        padding: 0;
        position: relative;
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
        position: relative;
        padding: 0;
    }

    .hd-box {
        background-color: #bbbbbb;
        padding: 15px 0px;
        width: 100%;
        margin: 0 auto;
        text-align: center;
    }

    .hd-text {
        font-size: 18px;
        font-weight: bold;
        color: #ffffff;
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

    .form-label {
        font-weight: bold;
    }

    .normal-text {
        font-weight: 100;
    }
</style>

<div class="form-container">

    <header>
        <table class="header-table">
            <tr>
                <td class="td-left">
                    <table class="brand-table">
                        <tr>
                            <td class="va-middle"><img
                                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/Logo-RSUD-Langsa-1.png'))) }}"
                                    alt="RSUD Langsa Logo" style="width: 40px; height: auto; margin-right: 10px;"></td>
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
                    <span class="title-main">LAPORAN OPERASI (CEKLIST)</span>
                </td>
                <td class="td-right">
                    <div class="hd-box"><span class="hd-text">OPERASI</span></div>
                </td>
            </tr>
        </table>
    </header>

    <div class="header-grid">
        <div class="form-label">
            Nama Pasien: <span class="normal-text">{{ $dataMedis->pasien->nama }}</span>
        </div>

        <div class="form-label">
            Tanggal Lahir:
            <span class="normal-text">{{ date("d-m-Y", strtotime($dataMedis->pasien->tgl_lahir)) }}</span>
        </div>

        <div class="form-label">
            Jenis Kelamin:
            <span class="normal-text">
                {{ $dataMedis->pasien->jenis_kelamin == '1' ? 'Laki-Laki' : 'Perempuan' }}
            </span>
        </div>

        <div class="form-label">
            Alamat: <span class="normal-text">{{ $dataMedis->pasien->alamat }}</span>
        </div>
    </div>

    @php
        function parseList($value)
        {
            if (!$value)
                return [];
            return json_decode($value, true) ?? [];
        }

        // List dari database
        $listListrik = parseList($ceklistKesiapanAnesthesi->mesin_anesthesia_listrik);
        $listGas = parseList($ceklistKesiapanAnesthesi->gas_medis);
        $listMesin = parseList($ceklistKesiapanAnesthesi->mesin_anesthesia);
        $listJalanNafas = parseList($ceklistKesiapanAnesthesi->manajemen_jalan_nafas);
        $listPemantauan = parseList($ceklistKesiapanAnesthesi->pemantauan);
        $listLainLain = parseList($ceklistKesiapanAnesthesi->lain_lain);
        $listObat = parseList($ceklistKesiapanAnesthesi->obat_obatan);

        // Centang Unicode langsung
        function isChecked($array, $key)
        {
            return in_array($key, $array) ? '✔' : '';
        }

        // Nama teknik
        $teknik = '';
        foreach ($jenisAnastesi as $item) {
            if ($item->kd_jenis_anastesi == $ceklistKesiapanAnesthesi->teknik_anesthesia) {
                $teknik = $item->jenis_anastesi;
                break;
            }
        }
    @endphp


    <table>
        <tr>
            <td style="font-size : 10px; font-weight: bold; padding-right: 8px;">Ruangan</td>
            <td style="font-size : 10px;" >: {{ $ceklistKesiapanAnesthesi->ruangan }}</td>
        </tr>
        <tr>
            <td style="font-size : 10px; font-weight: bold; padding-right: 8px;">Diagnosis</td>
            <td style="font-size : 10px;" >: {{ $ceklistKesiapanAnesthesi->diagnosis }}</td>
        </tr>
        <tr>
            <td style="font-size : 10px; font-weight: bold; padding-right: 8px;">Teknik Anesthesia</td>
            <td style="font-size : 10px;" >: {{ $teknik }}</td>
        </tr>
    </table>


    <table border="1" style="width : 700px">
        <!-- Listrik -->
        <tr>
            <td class="section-title">Listrik</td>
            <td>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listListrik, 'mesin_anesthesia_listrik') !!}</span>
                    Mesin anesthesia terhubung dengan sumber listrik, indikator daya menyala.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listListrik, 'layar_pemantauan_listrik') !!}</span>
                    Layar pemantauan terhubung dengan sumber listrik, indikator daya menyala.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listListrik, 'syringe_pump_listrik') !!}</span>
                    Syringe pump terhubung dengan sumber listrik, indikator daya menyala.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listListrik, 'defibrillator_listrik') !!}</span>
                    Defibrillator terhubung dengan sumber listrik, indikator daya menyala.
                </div>
            </td>
        </tr>


        <!-- Gas Medis -->
        <tr>
            <td class="section-title">Gas Medis</td>
            <td>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listGas, 'selang_o2') !!}</span>
                    Selang oksigen terhubung antara sumber gas dengan mesin anaesthesia.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listGas, 'compressed_air') !!}</span>
                    Compressed air terhubung antara sumber gas dengan mesin anaesthesia.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listGas, 'n2o_connected') !!}</span>
                    N₂O terhubung antara sumber gas dengan mesin anaesthesia.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listGas, 'o2_meter_function') !!}</span>
                    Flow meter O₂ di mesin anaesthesia berfungsi, aliran gas keluar dari mesin dapat dirasakan.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listGas, 'n2o_meter_function') !!}</span>
                    Flow meter N₂O di mesin anaesthesia berfungsi, aliran gas keluar dari mesin dapat dirasakan.
                </div>

            </td>
        </tr>


        <!-- Mesin Anesthesia -->
        <tr>
            <td class="section-title">Mesin Anesthesia</td>
            <td>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listMesin, 'power_on') !!}</span>
                    Power On
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listMesin, 'self_calibration') !!}</span>
                    Self calibration : DONE
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listMesin, 'absorber_co2') !!}</span>
                    Absorber CO₂ dalam kondisi baik
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listMesin, 'tidak_kebocoran') !!}</span>
                    Tidak ada kebocoran sirkuit nafas
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listMesin, 'zat_volatil') !!}</span>
                    Zat volatil terisi
                </div>

            </td>
        </tr>


        <!-- Manajemen Jalan Nafas -->
        <tr>
            <td class="section-title">Manajemen Jalan Nafas</td>
            <td>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listJalanNafas, 'sungkup_muka') !!}</span>
                    Sungkup muka dalam ukuran yang benar
                </div>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listJalanNafas, 'oropharyngeal_airway') !!}</span>
                    Oropharyngeal airway (Guedel) dalam ukuran yang benar
                </div>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listJalanNafas, 'batang_laringoskop') !!}</span>
                    Batang laringoskop berisi baterai
                </div>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listJalanNafas, 'bilah_laringoskop') !!}</span>
                    Bilah laringoskop dalam ukuran yang benar
                </div>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listJalanNafas, 'laring_laringoskop') !!}</span>
                    Gagang dan bilah laringoskop berfungsi dengan baik
                </div>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listJalanNafas, 'ett') !!}</span>
                    ETT dalam ukuran yang benar dan tidak bocor
                </div>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listJalanNafas, 'stilet') !!}</span>
                    Stilet (introducer)
                </div>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listJalanNafas, 'syringe_cuff') !!}</span>
                    Syringe untuk mengembangkan cuff
                </div>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listJalanNafas, 'forceps_magill') !!}</span>
                    Forceps magill
                </div>
            </td>
        </tr>

        <!-- Pemantauan -->
        <tr>
            <td class="section-title">Pemantauan</td>
            <td>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listPemantauan, 'kabel_ekg') !!}</span>
                    Kabel EKG terhubung dengan layar pemantau.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listPemantauan, 'nibp') !!}</span>
                    Elektroda EKG dalam jumlah dan ukuran yang sesuai.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listPemantauan, 'oksigen_saturasi') !!}</span>
                    NIBP terhubung dengan layar pemantau dan berfungsi baik.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listPemantauan, 'suhu_tubuh') !!}</span>
                    SpO₂ terhubung dengan layar pemantau dan berfungsi baik.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listPemantauan, 'suhu_tubuh') !!}</span>
                    Pemantau suhu terhubung dengan layar pemantau.
                </div>
            </td>
        </tr>

        <!-- Lain-lain -->
        <tr>
            <td class="section-title">Lain-lain</td>
            <td>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listLainLain, 'sabun') !!}</span>
                    Stetoskop tersedia.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listLainLain, 'sabun') !!}</span>
                    Suction berfungsi baik.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listLainLain, 'sabun') !!}</span>
                    Selang suction terhubung, kateter suction dalam ukuran yang benar.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listLainLain, 'sabun') !!}</span>
                    Plester dan fiksasi.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listLainLain, 'blanket_roll') !!}</span>
                    Blanket roll / hemotherm / radiant heater terhubung dengan sumber listrik dan berfungsi baik.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listLainLain, 'blanket_roll') !!}</span>
                    Blanket roll dilapisi alas.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listLainLain, 'alat_injeksi') !!}</span>
                    Lidocain spray / jelly.
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listLainLain, 'alat_injeksi') !!}</span>
                    Defibrillator jelly.
                </div>
            </td>
        </tr>

        <!-- Obat-obatan -->
        <tr>
            <td class="section-title">Obat-obatan</td>
            <td>
                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listObat, 'epinefrin') !!}</span>
                    Epinefrin
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listObat, 'epinefrin') !!}</span>
                    Atrofin
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listObat, 'epinefrin') !!}</span>
                    Sedatif (midazolam/ propofol/ etomidat/ ketamin/ bipental
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listObat, 'atrofin') !!}</span>
                    Lain-lain: ………………………………………
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listObat, 'atrofin') !!}</span>
                    Opiat/ opioid
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listObat, 'atrofin') !!}</span>
                    Pelumpuh otot
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listObat, 'propofol') !!}</span>
                    Antibiotik
                </div>

                <div class="check-option">
                    <span class="checkbox">{!! isChecked($listObat, 'propofol') !!}</span>
                    ……………………………………………
                </div>
            </td>
        </tr>
    </table>

    @php
        // Ambil nama pemeriksa dari list perawat
        $namaPemeriksa = '';
        foreach ($perawat as $p) {
            if ($ceklistKesiapanAnesthesi->pemeriksa == $p->kd_perawat) {
                $namaPemeriksa = $p->nama;
                break;
            }
        }

        // Jika ada supervisor, sesuaikan seperti ini:
        $namaSupervisor = '';
        foreach ($perawat as $p) {
            if ($ceklistKesiapanAnesthesi->supervisor == $p->kd_perawat) {
                $namaSupervisor = $p->nama;
                break;
            }
        }
    @endphp


   <table class="footer-sign">
        <tr>
            <td>
                Pemeriksa: <strong>{{ $namaPemeriksa }}</strong><br><br><br>
                Tanda tangan:
            </td>
            <td>
                Supervisor: <strong>{{ $namaSupervisor }}</strong><br><br><br>
                Tanda tangan:
            </td>
        </tr>
    </table>

</div>