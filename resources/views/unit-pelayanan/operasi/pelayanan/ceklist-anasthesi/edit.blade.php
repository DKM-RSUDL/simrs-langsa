@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.laporan-anastesi.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form method="POST"
                action="{{ route('operasi.pelayanan.ceklist-anasthesi.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $ceklistKesiapanAnesthesi->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <div class="px-3">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h4 class="header-asesmen mb-0">CEKLIST KESIAPAN ANESTHESI</h4>
                                                <p class="mt-2 mb-0">
                                                    <i class="fas fa-info-circle me-2"></i> Isikan formulir ceklist kesiapan anesthesi dengan lengkap
                                                </p>
                                            </div>
                                            <a href="{{ route('operasi.pelayanan.ceklist-anasthesi.show', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $ceklistKesiapanAnesthesi->id]) }}"
                                                class="btn btn-info btn-sm px-3">
                                                <i class="fas fa-eye me-1"></i>
                                                Lihat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Operation Information -->
                            <div class="section-separator" id="jenisOperasi">

                                <div class="form-group">
                                    <label style="min-width: 200px;">Ruangan</label>
                                    <input type="text" class="form-control" name="ruangan"
                                        value="{{ isset($ceklistKesiapanAnesthesi->ruangan) ? $ceklistKesiapanAnesthesi->ruangan : '' }}"
                                        >
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Diagnosis</label>
                                    <input type="text" class="form-control" name="diagnosis"
                                        value="{{ isset($ceklistKesiapanAnesthesi->diagnosis) ? $ceklistKesiapanAnesthesi->diagnosis : '' }}"
                                        >
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Teknik Anesthesia</label>
                                    <input type="text" class="form-control" name="teknik_anesthesia"
                                        value="{{ isset($ceklistKesiapanAnesthesi->teknik_anesthesia) ? $ceklistKesiapanAnesthesi->teknik_anesthesia : '' }}"
                                        >
                                </div>
                            </div>

                            <!-- Checklist Sections -->
                            <div class="row">
                                <!-- Listrik Section -->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <div class="card-header text-dark">
                                            <h5 class="mb-0 fw-bold">LISTRIK</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @php
                                                    $listrik = isset($ceklistKesiapanAnesthesi->mesin_anesthesia_listrik) && $ceklistKesiapanAnesthesi->mesin_anesthesia_listrik
                                                        ? json_decode($ceklistKesiapanAnesthesi->mesin_anesthesia_listrik, true) : [];
                                                    if (!is_array($listrik)) {
                                                        $listrik = [$listrik];
                                                    }
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="mesin_anesthesia_listrik" value="mesin_anesthesia_listrik" name="mesin_anesthesia_listrik[]"
                                                            {{ in_array('mesin_anesthesia_listrik', $listrik) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="mesin_anesthesia_listrik">
                                                            Mesin anestesi terhubung dengan sumber listrik, indikator (+)
                                                            menyala
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="layar_pemantauan_listrik" value="layar_pemantauan_listrik" name="mesin_anesthesia_listrik[]"
                                                            {{ in_array('layar_pemantauan_listrik', $listrik) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="layar_pemantauan_listrik">
                                                            Layar pemantauan terhubung dengan sumber listrik, indikator (+)
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="syringe_pump_listrik" value="syringe_pump_listrik" name="mesin_anesthesia_listrik[]"                                                             {{ in_array('syringe_pump_listrik', $listrik) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="syringe_pump_listrik">
                                                            Syringe pump terhubung dengan sumber listrik, indikator (+)
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="defibrilator_listrik" value="defibrilator_listrik" name="mesin_anesthesia_listrik[]"                                                             {{ in_array('defibrilator_listrik', $listrik) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="defibrilator_listrik">
                                                            Defibrilator terhubung dengan sumber listrik, indikator (+)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Gas Medis Section -->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <div class="card-header text-dark">
                                            <h5 class="mb-0 fw-bold">GAS MEDIS</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @php
                                                    $gasMedis = isset($ceklistKesiapanAnesthesi->gas_medis) && $ceklistKesiapanAnesthesi->gas_medis
                                                        ? json_decode($ceklistKesiapanAnesthesi->gas_medis, true) : [];
                                                    if (!is_array($gasMedis)) {
                                                        $gasMedis = [$gasMedis];
                                                    }
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="selang_oksigen" name="gas_medis[]"
                                                            value="selang_oksigen" {{ in_array('selang_oksigen', $gasMedis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="selang_oksigen">
                                                            Selang oksigen terhubung antara sumber gas dengan mesin anestesi
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="flow_meter_o2" name="gas_medis[]"
                                                            value="flow_meter_o2" {{ in_array('flow_meter_o2', $gasMedis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flow_meter_o2">
                                                            Flow meter O2 di mesin anestesi berfungsi, aliran gas keluar
                                                            dari mesin dapat dirasakan
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="compressed_air" name="gas_medis[]"
                                                            value="compressed_air" {{ in_array('compressed_air', $gasMedis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="compressed_air">
                                                            Compressed air terhubung antara sumber gas dengan mesin anestesi
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="n2o_terhubung" name="gas_medis[]"
                                                            value="n2o_terhubung" {{ in_array('n2o_terhubung', $gasMedis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="n2o_terhubung">
                                                            N2O terhubung antara sumber gas dengan mesin anestesi
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="flow_meter_n2o" name="gas_medis[]"
                                                            value="flow_meter_n2o" {{ in_array('flow_meter_n2o', $gasMedis) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flow_meter_n2o">
                                                            Flow meter N2O di mesin anestesi berfungsi, aliran gas keluar
                                                            mesin dapat dirasakan
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mesin Anestesi Section -->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <div class="card-header text-dark">
                                            <h5 class="mb-0 fw-bold">MESIN ANASTHESIA</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @php
                                                    $mesinAnasthesia = isset($ceklistKesiapanAnesthesi->mesin_anesthesia) && $ceklistKesiapanAnesthesi->mesin_anesthesia
                                                        ? json_decode($ceklistKesiapanAnesthesi->mesin_anesthesia, true) : [];
                                                    if (!is_array($mesinAnasthesia)) {
                                                        $mesinAnasthesia = [$mesinAnasthesia];
                                                    }
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="power_on" name="mesin_anesthesia[]"
                                                            value="power_on" {{ in_array('power_on', $mesinAnasthesia) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="power_on">
                                                            Power On
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="mesin_anesthesia[]"
                                                            id="self_calibration" value="self_calibration" {{ in_array('self_calibration', $mesinAnasthesia) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="self_calibration">
                                                            Self calibration: DONE
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="absorber_co2" name="mesin_anesthesia[]"
                                                            value="absorber_co2" {{ in_array('absorber_co2', $mesinAnasthesia) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="absorber_co2">
                                                            Absorber CO2 dalam kondisi baik
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="tidak_kebocoran" name="mesin_anesthesia[]"
                                                            value="tidak_kebocoran" {{ in_array('tidak_kebocoran', $mesinAnasthesia) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="tidak_kebocoran">
                                                            Tidak ada kebocoran sirkuit nafas
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" id="zat_volatil" name="mesin_anesthesia[]"
                                                            value="zat_volatil" {{ in_array('zat_volatil', $mesinAnasthesia) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="zat_volatil">
                                                            Zat volatil terisi
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Manajemen Jalan Nafas -->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <div class="card-header text-dark">
                                            <h5 class="mb-0 fw-bold">MANAJEMEN JALAN NAFAS</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @php
                                                    $manajemenJalanNafas = isset($ceklistKesiapanAnesthesi->manajemen_jalan_nafas) && $ceklistKesiapanAnesthesi->manajemen_jalan_nafas
                                                        ? json_decode($ceklistKesiapanAnesthesi->manajemen_jalan_nafas, true) : [];
                                                    if (!is_array($manajemenJalanNafas)) {
                                                        $manajemenJalanNafas = [$manajemenJalanNafas];
                                                    }
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="manajemen_jalan_nafas[]" id="sungkup_muka"
                                                            value="sungkup_muka" {{ in_array('sungkup_muka', $manajemenJalanNafas) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="sungkup_muka">
                                                            Sungkup muka dalam ukuran yang benar
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="manajemen_jalan_nafas[]" id="oropharyngeal_airway"
                                                            value="oropharyngeal_airway"  {{ in_array('oropharyngeal_airway', $manajemenJalanNafas) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="oropharyngeal_airway">
                                                            Oropharyngeal airway (Guedel) dalam ukuran yang benar
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="manajemen_jalan_nafas[]" id="batang_laringoskop"
                                                            value="batang_laringoskop" {{ in_array('batang_laringoskop', $manajemenJalanNafas) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="batang_laringoskop">
                                                            Batang laringoskop berisi baterai
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="manajemen_jalan_nafas[]" id="bilah_laringoskop"
                                                            value="bilah_laringoskop" {{ in_array('bilah_laringoskop', $manajemenJalanNafas) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bilah_laringoskop">
                                                            Bilah laringoskop dalam ukuran yang benar
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="manajemen_jalan_nafas[]" id="gagang_bilah_laringoskop"
                                                            value="gagang_bilah_laringoskop" {{ in_array('gagang_bilah_laringoskop', $manajemenJalanNafas) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="gagang_bilah_laringoskop">
                                                            Gagang dan bilah laringoskop berfungsi dengan baik
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="manajemen_jalan_nafas[]" id="ett_datai_mma"
                                                            value="ett_datai_mma" {{ in_array('ett_datai_mma', $manajemenJalanNafas) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="ett_datai_mma">
                                                            ETT datai MMA dalam ukuran yang benar dan tidak bocor
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="manajemen_jalan_nafas[]" id="stilet_introduser"
                                                            value="stilet_introduser" {{ in_array('stilet_introduser', $manajemenJalanNafas) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="stilet_introduser">
                                                            Stilet (introduser)
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="manajemen_jalan_nafas[]" id="semprit_cuff"
                                                            value="semprit_cuff" {{ in_array('semprit_cuff', $manajemenJalanNafas) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="semprit_cuff">
                                                            Semprit untuk mengembangkan cuff
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="manajemen_jalan_nafas[]" id="forceps_magill"
                                                            value="forceps_magill" {{ in_array('forceps_magill', $manajemenJalanNafas) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="forceps_magill">
                                                            Forceps magill
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pemantauan -->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <div class="card-header text-dark">
                                            <h5 class="mb-0 fw-bold">PEMANTAUAN</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @php
                                                    $Pemantauan = isset($ceklistKesiapanAnesthesi->pemantauan) && $ceklistKesiapanAnesthesi->pemantauan
                                                        ? json_decode($ceklistKesiapanAnesthesi->pemantauan, true) : [];
                                                    if (!is_array($Pemantauan)) {
                                                        $Pemantauan = [$Pemantauan];
                                                    }
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                                            id="kabel_ekg" value="kabel_ekg" {{ in_array('kabel_ekg', $Pemantauan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="kabel_ekg">
                                                            Kabel EKG terhubung dengan layar pemantau
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                                            id="elektroda_ekg" value="elektroda_ekg" {{ in_array('elektroda_ekg', $Pemantauan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="elektroda_ekg">
                                                            Elektroda EKG dalam jumlah dan ukuran yang sesuai
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                                            id="nibp_terhubung" value="nibp_terhubung" {{ in_array('nibp_terhubung', $Pemantauan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="nibp_terhubung">
                                                            NIBP terhubung dengan layar pemantau dan berfungsi baik
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                                            id="spo2_terhubung" value="spo2_terhubung" {{ in_array('spo2_terhubung', $Pemantauan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="spo2_terhubung">
                                                            SpO2 terhubung dengan layar pemantau dan berfungsi baik
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                                            id="pemantau_suhu" value="pemantau_suhu" {{ in_array('pemantau_suhu', $Pemantauan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pemantau_suhu">
                                                            Pemantau suhu terhubung dengan layar pemantau
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Lain-lain -->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <div class="card-header text-dark">
                                            <h5 class="mb-0 fw-bold">LAIN-LAIN</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @php
                                                    $lainLain = isset($ceklistKesiapanAnesthesi->lain_lain) && $ceklistKesiapanAnesthesi->lain_lain
                                                        ? json_decode($ceklistKesiapanAnesthesi->lain_lain, true) : [];
                                                    if (!is_array($lainLain)) {
                                                        $lainLain = [$lainLain];
                                                    }
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                                            id="stetoskop_tersedia" value="stetoskop_tersedia" {{ in_array('stetoskop_tersedia', $lainLain) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="stetoskop_tersedia">
                                                            Stetoskop tersedia
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                                            id="suction_berfungsi" value="suction_berfungsi" {{ in_array('suction_berfungsi', $lainLain) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="suction_berfungsi">
                                                            Suction berfungsi baik
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                                            id="selang_suction" value="selang_suction" {{ in_array('selang_suction', $lainLain) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="selang_suction">
                                                            Selang suction terhubung, kateter suction dalam ukuran yang
                                                            benar
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                                            id="plester_fiksasi" value="plester_fiksasi" {{ in_array('plester_fiksasi', $lainLain) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="plester_fiksasi">
                                                            Plester dan fiksasi
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                                            id="blanket_roll" value="blanket_roll" {{ in_array('blanket_roll', $lainLain) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="blanket_roll">
                                                            Blanket roll/hemotherm/radiant heater terhubung dengan sumber
                                                            listrik dan berfungsi baik
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                                            id="blanket_roll_alas" value="blanket_roll_alas" {{ in_array('blanket_roll_alas', $lainLain) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="blanket_roll_alas">
                                                            Blanket roll dilapisi alas
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                                            id="lidocain_spray" value="lidocain_spray" {{ in_array('lidocain_spray', $lainLain) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="lidocain_spray">
                                                            Lidocain spray/jelly
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                                            id="defibrillator_jelly" value="defibrillator_jelly" {{ in_array('defibrillator_jelly', $lainLain) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="defibrillator_jelly">
                                                            Defibrillator jelly
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Obat-obatan -->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <div class="card-header text-dark">
                                            <h5 class="mb-0 fw-bold">OBAT-OBATAN</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @php
                                                    $obatObatan = isset($ceklistKesiapanAnesthesi->obat_obatan) && $ceklistKesiapanAnesthesi->obat_obatan
                                                        ? json_decode($ceklistKesiapanAnesthesi->obat_obatan, true) : [];
                                                    if (!is_array($obatObatan)) {
                                                        $obatObatan = [$obatObatan];
                                                    }
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                                            id="epinefrin" value="epinefrin" {{ in_array('epinefrin', $obatObatan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="epinefrin">
                                                            Epinefrin
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                                            id="atrofin" value="atrofin" {{ in_array('atrofin', $obatObatan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="atrofin">
                                                            Atrofin
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                                            id="sedatif" value="sedatif" {{ in_array('sedatif', $obatObatan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="sedatif">
                                                            Sedatif (midazolam/propofol/etomidat/ketamin/tiopental)
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="min-width: 100px;">Lain-lain:</label>
                                                        <input type="text" class="form-control" name="obat_lain" value="{{$ceklistKesiapanAnesthesi->obat_lain ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                                            id="opiat_opioid" value="opiat_opioid" {{ in_array('opiat_opioid', $obatObatan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="opiat_opioid">
                                                            Opiat/opioid
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                                            id="pelumpuh_otot" value="pelumpuh_otot" {{ in_array('pelumpuh_otot', $obatObatan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pelumpuh_otot">
                                                            Pelumpuh otot
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                                            id="antibiotik" value="antibiotik" {{ in_array('antibiotik', $obatObatan) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="antibiotik">
                                                            Antibiotik
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pemeriksa dan Supervisor -->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <div class="card-header text-dark">
                                            <h5 class="mb-0 fw-bold">PEMERIKSA DAN SUPERVISOR</h5>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Pemeriksa (Residen/perawat anestesi)</label>
                                            <input type="text" class="form-control" name="pemeriksa" value="{{$ceklistKesiapanAnesthesi->pemeriksa ?? '' }}">
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Supervisor</label>
                                            <input type="text" class="form-control" name="supervisor" value="{{$ceklistKesiapanAnesthesi->supervisor ?? '' }}">
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">
                                    <i class="fas fa-save me-1"></i> Simpan Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Initialize tooltips
                $('[data-toggle="tooltip"]').tooltip();

                // Optional: Add validation highlight
                $('.form-check-input').change(function () {
                    if ($(this).is(':checked')) {
                        $(this).closest('.form-check').addClass('text-success');
                    } else {
                        $(this).closest('.form-check').removeClass('text-success');
                    }
                });

                // Optional: Check all items in a section
                $('.check-all').click(function () {
                    const section = $(this).data('section');
                    $(`.${section} .form-check-input`).prop('checked', true).change();
                });

                // Optional: Calculate completion percentage
                function updateCompletionStatus() {
                    const total = $('.form-check-input').length;
                    const checked = $('.form-check-input:checked').length;
                    const percentage = Math.round((checked / total) * 100);

                    $('#completion-percentage').text(percentage);
                    $('#completion-progress').css('width', percentage + '%');

                    if (percentage < 50) {
                        $('#completion-progress').removeClass('bg-success bg-warning').addClass('bg-danger');
                    } else if (percentage < 90) {
                        $('#completion-progress').removeClass('bg-success bg-danger').addClass('bg-warning');
                    } else {
                        $('#completion-progress').removeClass('bg-danger bg-warning').addClass('bg-success');
                    }
                }

                $('.form-check-input').change(updateCompletionStatus);

                // Initialize completion status
                updateCompletionStatus();

                // Form validation before submit
                $('form').submit(function (event) {
                    // Check required fields
                    let hasErrors = false;

                    $('input[required], select[required], textarea[required]').each(function () {
                        if (!$(this).val()) {
                            $(this).addClass('is-invalid');
                            hasErrors = true;
                        } else {
                            $(this).removeClass('is-invalid');
                        }
                    });

                    if (hasErrors) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: 'Mohon lengkapi semua field yang wajib diisi.',
                            confirmButtonColor: '#3085d6'
                        });

                        // Scroll to first error
                        $('html, body').animate({
                            scrollTop: $('.is-invalid:first').offset().top - 100
                        }, 500);
                    }
                });

                // Clear validation on input
                $('input, select, textarea').on('input change', function () {
                    $(this).removeClass('is-invalid');
                });
            });
        </script>
    @endpush
@endsection
