@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Implementasi Asuhan Keperawatan</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-inap.asuhan-keperawatan.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label fw-bold">Tanggal Implementasi</label>
                                        <input type="date" class="form-control" name="tgl_implementasi"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-bold">Waktu</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="waktu" id="pagi"
                                                value="1">
                                            <label class="form-check-label" for="pagi">
                                                <i class="bi bi-sunrise text-warning"></i> Pagi
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="waktu" id="sore"
                                                value="2">
                                            <label class="form-check-label" for="sore">
                                                <i class="bi bi-sun text-orange"></i> Sore
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="waktu" id="malam"
                                                value="3">
                                            <label class="form-check-label" for="malam">
                                                <i class="bi bi-moon-stars text-primary"></i> Malam
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Implementasi Sections -->
                    <div class="row">
                        <!-- Airway Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-lungs text-primary me-2"></i>
                                        Airway (Kepatenan Jalan Nafas)
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="airway[]"
                                                        type="checkbox" id="head_tilt" value="head_tilt">
                                                    <span>Head tilt</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="airway[]"
                                                        type="checkbox" id="jaw_trust" value="jaw_trush">
                                                    <span>Jaw trust</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="airway[]"
                                                        type="checkbox" id="control_servicalis" value="servicalis">
                                                    <span>Control Servicalis</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="airway[]"
                                                        type="checkbox" id="nebulizer" value="nebulizer">
                                                    <span>Nebulizer</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="airway[]"
                                                        type="checkbox" id="batuk__efektif" value="batuk">
                                                    <span>Batuk efektif</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="airway[]"
                                                        type="checkbox" id="fisiotherapi__dada" value="fisiotherapi">
                                                    <span>Fisiotherapi dada</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="airway[]"
                                                        type="checkbox" id="suction" value="suction">
                                                    <span>Suction</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pernafasan Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-activity text-primary me-2"></i>
                                        Pernafasan (Oksigenasi)
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="pernafasan[]"
                                                        type="checkbox" id="monitoring" value="bunyi_nafas">
                                                    <span>Monitoring bunyi nafas</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="pernafasan[]"
                                                        type="checkbox" id="monitoring__sputum" value="sputum">
                                                    <span>Monitoring sputum</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="pernafasan[]"
                                                        type="checkbox" id="posisi__semi__fowler" value="fowler">
                                                    <span>Posisi semi fowler / fowler</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="pernafasan[]"
                                                        type="checkbox" id="saturasi__oksigen" value="oksigen">
                                                    <span>Saturasi oksigen</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tanda Vital Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-heart-pulse-fill text-primary me-2"></i>
                                        Tanda Vital
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="tanda_vital[]"
                                                        type="checkbox" id="mengukur__tekanan_darah" value="darah">
                                                    <span>Mengukur tekanan darah</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="tanda_vital[]"
                                                        type="checkbox" id="menghitung__pernafasan" value="pernafasan">
                                                    <span>Menghitung pernafasan</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="tanda_vital[]"
                                                        type="checkbox" id="menghitung__nadi" value="nadi">
                                                    <span>Menghitung nadi</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="tanda_vital[]"
                                                        type="checkbox" id="mengukur__temperature" value="temperature">
                                                    <span>Mengukur temperature</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="tanda_vital[]"
                                                        type="checkbox" id="observasi__perubahan" value="observasi">
                                                    <span>Observasi perubahan tanda2 vital</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rasa nyaman/ Nyeri Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-bandaid-fill text-primary me-2"></i>
                                        Rasa nyaman
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nyeri[]"
                                                        type="checkbox" id="identifikasi__lokasi" value="identifikasi">
                                                    <span>Identifikasi lokasi, frekuensi, intensitas dan skala
                                                        nyeri.</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nyeri[]"
                                                        type="checkbox" id="kompres__hangat" value="kompres">
                                                    <span>Kompres hangat/dingin</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nyeri[]"
                                                        type="checkbox" id="kontrol__lingkungan" value="kontrol">
                                                    <span>Kontrol lingkungan</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nyeri[]"
                                                        type="checkbox" id="fasilitasi__istirahat" value="istirahat">
                                                    <span>Fasilitasi istirahat dan tidur</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nyeri[]"
                                                        type="checkbox" id="massage" value="message">
                                                    <span>Massage</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nyeri[]"
                                                        type="checkbox" id="distraksi" value="distraksi">
                                                    <span>Distraksi</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nyeri[]"
                                                        type="checkbox" id="relaksasi" value="relaksasi">
                                                    <span>Relaksasi</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cairan/Nutrisi Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-droplet-fill text-primary me-2"></i>
                                        Cairan/Nutrisi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nutrisi[]"
                                                        type="checkbox" id="kaji__mual" value="mual">
                                                    <span>Kaji mual dan muntah.</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nutrisi[]"
                                                        type="checkbox" id="timbang__berat__badan" value="bb">
                                                    <span>Timbang berat badan</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <div class="list-group-item d-flex flex-column">
                                                    <label class="d-flex align-items-center gap-2">
                                                        <input class="form-check-input flex-shrink-0" name="nutrisi[]"
                                                            type="checkbox" id="memberi__makan__via" value="makan">
                                                        <span>Memberi makan via</span>
                                                    </label>
                                                    <input type="text" id="makan_via" class="form-control mt-2"
                                                        name="makan_via" placeholder="NGT, OGT, Parenteral, dll"
                                                        style="display:none;" disabled>
                                                </div>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nutrisi[]"
                                                        type="checkbox" id="memberi__asi" value="asi">
                                                    <span>Memberi ASI/PASI</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nutrisi[]"
                                                        type="checkbox" id="berikan__asupan" value="asupan">
                                                    <span>Berikan asupan cairan oral</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nutrisi[]"
                                                        type="checkbox" id="memasang__ngt" value="ngt">
                                                    <span>Memasang NGT/OGT</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="nutrisi[]"
                                                        type="checkbox" id="puasa" value="puasa">
                                                    <span>Puasa</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Eliminasi Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-droplet-half text-primary me-2"></i>
                                        Eliminasi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="eliminasi[]"
                                                        type="checkbox" id="monitor__inkontinensia"
                                                        value="inkontinensia">
                                                    <span>Monitor inkontinensia</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="eliminasi[]"
                                                        type="checkbox" id="memberikan__pispot" value="pispot">
                                                    <span>Memberikan pispot/urinal</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="eliminasi[]"
                                                        type="checkbox" id="pasang__kondom__cateter" value="kondom">
                                                    <span>Pasang kondom cateter</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="eliminasi[]"
                                                        type="checkbox" id="pasang__foley__cateter" value="foley">
                                                    <span>Pasang Foley cateter</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="eliminasi[]"
                                                        type="checkbox" id="kaji__konsistensi" value="fasces">
                                                    <span>Kaji konsistensi fasces</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="eliminasi[]"
                                                        type="checkbox" id="bladder__training" value="bladder">
                                                    <span>Bladder training</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="eliminasi[]"
                                                        type="checkbox" id="pencahar" value="pencahar">
                                                    <span>Pencahar</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- personal Hygiene Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-person-lines-fill text-primary me-2"></i>
                                        Perawatan diri, kebersihan diri, (personal Hygiene)
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0"
                                                        name="personal_hygiene[]" type="checkbox" id="bantu__mandi"
                                                        value="mandi">
                                                    <span>Bantu mandi di tempat tidur</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0"
                                                        name="personal_hygiene[]" type="checkbox" id="bantu__berpakaian"
                                                        value="berpakaian">
                                                    <span>Bantu berpakaian</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0"
                                                        name="personal_hygiene[]" type="checkbox" id="perawatan__kulit"
                                                        value="kulit">
                                                    <span>Perawatan kulit</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0"
                                                        name="personal_hygiene[]" type="checkbox" id="perawatan__rambut"
                                                        value="rambut">
                                                    <span>Perawatan rambut</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0"
                                                        name="personal_hygiene[]" type="checkbox" id="perawatan__kuku"
                                                        value="kuku">
                                                    <span>Perawatan kuku</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0"
                                                        name="personal_hygiene[]" type="checkbox"
                                                        id="perawatan__oral__hygiene" value="oral">
                                                    <span>Perawatan oral hygiene</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0"
                                                        name="personal_hygiene[]" type="checkbox"
                                                        id="perawatan__perineon" value="perineon">
                                                    <span>Perawatan perineon</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0"
                                                        name="personal_hygiene[]" type="checkbox" id="perawatan__vulva"
                                                        value="vulva">
                                                    <span>Perawatan vulva hygiene</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Obstetri dan Ginekologi Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-person-hearts text-primary me-2"></i>
                                        Obstetri dan Ginekologi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="ginekologi[]"
                                                        type="checkbox" id="pijat__oksitosin" value="oksitosin">
                                                    <span>Pijat oksitosin</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="ginekologi[]"
                                                        type="checkbox" id="kontraksi__uteri" value="uteri">
                                                    <span>Kontraksi uteri</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="ginekologi[]"
                                                        type="checkbox" id="kompresi__bimanual" value="bimanual">
                                                    <span>Kompresi bimanual internal/eksternal</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="ginekologi[]"
                                                        type="checkbox" id="breas__care" value="breas">
                                                    <span>Breas care</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="ginekologi[]"
                                                        type="checkbox" id="ftu" value="tfu">
                                                    <span>TFU (tinggi fundus uteri)</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Psiko Sosial Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-people-fill text-primary me-2"></i>
                                        Psiko Sosial
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="sosial[]"
                                                        type="checkbox" id="memberi__dukungan" value="dukungan">
                                                    <span>Memberi dukungan</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="sosial[]"
                                                        type="checkbox" id="melibatkan__keluarga" value="keluarga">
                                                    <span>Melibatkan keluarga</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edukasi Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-book-fill text-primary me-2"></i>
                                        Edukasi
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="edukasi[]"
                                                        type="checkbox" id="manajemen__nyeri" value="nyeri">
                                                    <span>Manajemen nyeri</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="edukasi[]"
                                                        type="checkbox" id="pencegahan__jatuh" value="jatuh">
                                                    <span>Pencegahan jatuh</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="edukasi[]"
                                                        type="checkbox" id="pencegahan__infeksi" value="infeksi">
                                                    <span>Pencegahan infeksi</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Risiko Cedera Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-shield-exclamation text-primary me-2"></i>
                                        Risiko Cedera
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="cedera[]"
                                                        type="checkbox" id="pasang__penghalang" value="handrail">
                                                    <span>Pasang penghalang tempat tidur/ Handrail</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="cedera[]"
                                                        type="checkbox" id="restrain" value="restrain">
                                                    <span>Restrain</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="cedera[]"
                                                        type="checkbox" id="pasang__pelindung" value="bayi">
                                                    <span>Pasang pelindung mata bayi</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="cedera[]"
                                                        type="checkbox" id="pastikan__roda" value="roda">
                                                    <span>Pastikan roda tempat tidur dan Kursi Roda selalu dalam kondisi
                                                        terkunci</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="cedera[]"
                                                        type="checkbox" id="gunakan__alat__bantu" value="alat_bantu">
                                                    <span>Gunakan alat bantu</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="cedera[]"
                                                        type="checkbox" id="berjalan" value="berjalan">
                                                    <span>berjalan (kursi roda, walker)</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lain - lain Section -->
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-three-dots text-primary me-2"></i>
                                        Lain - lain
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="lainnya[]"
                                                        type="checkbox" id="perawatan__luka" value="luka">
                                                    <span>Perawatan luka/GV</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="lainnya[]"
                                                        type="checkbox" id="perawatan__stoma" value="stoma">
                                                    <span>Perawatan stoma</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="lainnya[]"
                                                        type="checkbox" id="pasang__infus" value="infus">
                                                    <span>Pasang infus/IV line</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="lainnya[]"
                                                        type="checkbox" id="observasi__kejang" value="kejang">
                                                    <span>Observasi kejang</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="lainnya[]"
                                                        type="checkbox" id="perawatan__gips" value="gips">
                                                    <span>Perawatan Gips</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="lainnya[]"
                                                        type="checkbox" id="perawatan__luka__bakar" value="luka_bakar">
                                                    <span>Perawatan luka bakar</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" name="lainnya[]"
                                                        type="checkbox" id="Perawatan__mata" value="mata">
                                                    <span>Perawatan mata</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            const $checkbox = $('#memberi__makan__via');
            const $input = $('#makan_via');

            function syncMakanVia() {
                if ($checkbox.length === 0 || $input.length === 0) return;
                if ($checkbox.is(':checked')) {
                    $input.show().prop('disabled', false);
                } else {
                    $input.hide().prop('disabled', true).val('');
                }
            }

            // Inisialisasi dan event handler
            syncMakanVia();
            $checkbox.on('change', syncMakanVia);
        });
    </script>
@endpush
