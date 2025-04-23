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

                <div class="card mb-4 border-primary">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-0">
                                    <label class="form-label fw-bold">Tanggal Implementasi</label>
                                    <input type="date" class="form-control" name="tgl_implementasi" value="{{ date('Y-m-d', strtotime($asuhan->tgl_implementasi)) }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Waktu</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="waktu"
                                            id="pagi" value="1" @checked($asuhan->waktu == 1) disabled>
                                        <label class="form-check-label" for="pagi">
                                            <i class="bi bi-sunrise text-warning"></i> Pagi
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="waktu"
                                            id="sore" value="2" @checked($asuhan->waktu == 2) disabled>
                                        <label class="form-check-label" for="sore">
                                            <i class="bi bi-sun text-orange"></i> Sore
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="waktu"
                                            id="malam" value="3" @checked($asuhan->waktu == 3) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="airway[]" type="checkbox"
                                                    id="head_tilt" value="head_tilt" @checked(in_array('head_tilt', $asuhan->airway ?? [])) disabled>
                                                <span>Head tilt</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="airway[]" type="checkbox"
                                                    id="jaw_trust" value="jaw_trush" @checked(in_array('jaw_trush', $asuhan->airway ?? [])) disabled>
                                                <span>Jaw trust</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="airway[]" type="checkbox"
                                                    id="control_servicalis" value="servicalis" @checked(in_array('servicalis', $asuhan->airway ?? [])) disabled>
                                                <span>Control Servicalis</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="airway[]" type="checkbox"
                                                    id="nebulizer" value="nebulizer" @checked(in_array('nebulizer', $asuhan->airway ?? [])) disabled>
                                                <span>Nebulizer</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="airway[]" type="checkbox"
                                                    id="batuk__efektif" value="batuk" @checked(in_array('batuk', $asuhan->airway ?? [])) disabled>
                                                <span>Batuk efektif</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="airway[]" type="checkbox"
                                                    id="fisiotherapi__dada" value="fisiotherapi" @checked(in_array('fisiotherapi', $asuhan->airway ?? [])) disabled>
                                                <span>Fisiotherapi dada</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="airway[]" type="checkbox"
                                                    id="suction" value="suction" @checked(in_array('suction', $asuhan->airway ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="pernafasan[]" type="checkbox"
                                                    id="monitoring" value="bunyi_nafas" @checked(in_array('bunyi_nafas', $asuhan->pernafasan ?? [])) disabled>
                                                <span>Monitoring bunyi nafas</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="pernafasan[]" type="checkbox"
                                                    id="monitoring__sputum" value="sputum" @checked(in_array('sputum', $asuhan->pernafasan ?? [])) disabled>
                                                <span>Monitoring sputum</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="pernafasan[]" type="checkbox"
                                                    id="posisi__semi__fowler" value="fowler" @checked(in_array('fowler', $asuhan->pernafasan ?? [])) disabled>
                                                <span>Posisi semi fowler / fowler</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="pernafasan[]" type="checkbox"
                                                    id="saturasi__oksigen" value="oksigen" @checked(in_array('oksigen', $asuhan->pernafasan ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="tanda_vital[]" type="checkbox"
                                                    id="mengukur__tekanan_darah" value="darah" @checked(in_array('darah', $asuhan->tanda_vital ?? [])) disabled>
                                                <span>Mengukur tekanan darah</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tanda_vital[]" type="checkbox"
                                                    id="menghitung__pernafasan" value="pernafasan" @checked(in_array('pernafasan', $asuhan->tanda_vital ?? [])) disabled>
                                                <span>Menghitung pernafasan</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tanda_vital[]" type="checkbox"
                                                    id="menghitung__nadi" value="nadi" @checked(in_array('nadi', $asuhan->tanda_vital ?? [])) disabled>
                                                <span>Menghitung nadi</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tanda_vital[]" type="checkbox"
                                                    id="mengukur__temperature" value="temperature" @checked(in_array('temperature', $asuhan->tanda_vital ?? [])) disabled>
                                                <span>Mengukur temperature</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="tanda_vital[]" type="checkbox"
                                                    id="observasi__perubahan" value="observasi" @checked(in_array('observasi', $asuhan->tanda_vital ?? [])) disabled>
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
                                    Rasa nyaman/ Nyeri
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nyeri[]" type="checkbox"
                                                    id="identifikasi__lokasi" value="identifikasi" @checked(in_array('identifikasi', $asuhan->nyeri ?? [])) disabled>
                                                <span>Identifikasi lokasi, frekuensi, intensitas dan skala
                                                    nyeri.</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nyeri[]" type="checkbox"
                                                    id="kompres__hangat" value="kompres" @checked(in_array('kompres', $asuhan->nyeri ?? [])) disabled>
                                                <span>Kompres hangat/dingin</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nyeri[]" type="checkbox"
                                                    id="kontrol__lingkungan" value="kontrol" @checked(in_array('kontrol', $asuhan->nyeri ?? [])) disabled>
                                                <span>Kontrol lingkungan</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nyeri[]" type="checkbox"
                                                    id="fasilitasi__istirahat" value="istirahat" @checked(in_array('istirahat', $asuhan->nyeri ?? [])) disabled>
                                                <span>Fasilitasi istirahat dan tidur</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nyeri[]" type="checkbox"
                                                    id="massage" value="message" @checked(in_array('message', $asuhan->nyeri ?? [])) disabled>
                                                <span>Massage</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nyeri[]" type="checkbox"
                                                    id="distraksi" value="distraksi" @checked(in_array('distraksi', $asuhan->nyeri ?? [])) disabled>
                                                <span>Distraksi</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nyeri[]" type="checkbox"
                                                    id="relaksasi" value="relaksasi" @checked(in_array('relaksasi', $asuhan->nyeri ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="nutrisi[]" type="checkbox"
                                                    id="kaji__mual" value="mual" @checked(in_array('mual', $asuhan->nutrisi ?? [])) disabled>
                                                <span>Kaji mual dan muntah.</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nutrisi[]" type="checkbox"
                                                    id="timbang__berat__badan" value="bb" @checked(in_array('bb', $asuhan->nutrisi ?? [])) disabled>
                                                <span>Timbang berat badan</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nutrisi[]" type="checkbox"
                                                    id="memberi__makan__via" value="makan" @checked(in_array('makan', $asuhan->nutrisi ?? [])) disabled>
                                                <span>Memberi makan via</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nutrisi[]" type="checkbox"
                                                    id="memberi__asi" value="asi" @checked(in_array('asi', $asuhan->nutrisi ?? [])) disabled>
                                                <span>Memberi ASI/PASI</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nutrisi[]" type="checkbox"
                                                    id="berikan__asupan" value="asupan" @checked(in_array('asupan', $asuhan->nutrisi ?? [])) disabled>
                                                <span>Berikan asupan cairan oral</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nutrisi[]" type="checkbox"
                                                    id="memasang__ngt" value="ngt" @checked(in_array('ngt', $asuhan->nutrisi ?? [])) disabled>
                                                <span>Memasang NGT/OGT</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="nutrisi[]" type="checkbox"
                                                    id="puasa" value="puasa" @checked(in_array('puasa', $asuhan->nutrisi ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="eliminasi[]" type="checkbox"
                                                    id="monitor__inkontinensia" value="inkontinensia" @checked(in_array('inkontinensia', $asuhan->eliminasi ?? [])) disabled>
                                                <span>Monitor inkontinensia</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="eliminasi[]" type="checkbox"
                                                    id="memberikan__pispot" value="pispot" @checked(in_array('pispot', $asuhan->eliminasi ?? [])) disabled>
                                                <span>Memberikan pispot/urinal</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="eliminasi[]" type="checkbox"
                                                    id="pasang__kondom__cateter" value="kondom" @checked(in_array('kondom', $asuhan->eliminasi ?? [])) disabled>
                                                <span>Pasang kondom cateter</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="eliminasi[]" type="checkbox"
                                                    id="pasang__foley__cateter" value="foley" @checked(in_array('foley', $asuhan->eliminasi ?? [])) disabled>
                                                <span>Pasang Foley cateter</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="eliminasi[]" type="checkbox"
                                                    id="kaji__konsistensi" value="fasces" @checked(in_array('fasces', $asuhan->eliminasi ?? [])) disabled>
                                                <span>Kaji konsistensi fasces</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="eliminasi[]" type="checkbox"
                                                    id="bladder__training" value="bladder" @checked(in_array('bladder', $asuhan->eliminasi ?? [])) disabled>
                                                <span>Bladder training</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="eliminasi[]" type="checkbox"
                                                    id="pencahar" value="pencahar" @checked(in_array('pencahar', $asuhan->eliminasi ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="personal_hygiene[]" type="checkbox"
                                                    id="bantu__mandi" value="mandi" @checked(in_array('mandi', $asuhan->personal_hygiene ?? [])) disabled>
                                                <span>Bantu mandi di tempat tidur</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="personal_hygiene[]" type="checkbox"
                                                    id="bantu__berpakaian" value="berpakaian" @checked(in_array('berpakaian', $asuhan->personal_hygiene ?? [])) disabled>
                                                <span>Bantu berpakaian</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="personal_hygiene[]" type="checkbox"
                                                    id="perawatan__kulit" value="kulit" @checked(in_array('kulit', $asuhan->personal_hygiene ?? [])) disabled>
                                                <span>Perawatan kulit</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="personal_hygiene[]" type="checkbox"
                                                    id="perawatan__rambut" value="rambut" @checked(in_array('rambut', $asuhan->personal_hygiene ?? [])) disabled>
                                                <span>Perawatan rambut</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="personal_hygiene[]" type="checkbox"
                                                    id="perawatan__kuku" value="kuku" @checked(in_array('kuku', $asuhan->personal_hygiene ?? [])) disabled>
                                                <span>Perawatan kuku</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="personal_hygiene[]" type="checkbox"
                                                    id="perawatan__oral__hygiene" value="oral" @checked(in_array('oral', $asuhan->personal_hygiene ?? [])) disabled>
                                                <span>Perawatan oral hygiene</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="personal_hygiene[]" type="checkbox"
                                                    id="perawatan__perineon" value="perineon" @checked(in_array('perineon', $asuhan->personal_hygiene ?? [])) disabled>
                                                <span>Perawatan perineon</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="personal_hygiene[]" type="checkbox"
                                                    id="perawatan__vulva" value="vulva" @checked(in_array('vulva', $asuhan->personal_hygiene ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="ginekologi[]" type="checkbox"
                                                    id="pijat__oksitosin" value="oksitosin" @checked(in_array('oksitosin', $asuhan->ginekologi ?? [])) disabled>
                                                <span>Pijat oksitosin</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="ginekologi[]" type="checkbox"
                                                    id="kontraksi__uteri" value="uteri" @checked(in_array('uteri', $asuhan->ginekologi ?? [])) disabled>
                                                <span>Kontraksi uteri</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="ginekologi[]" type="checkbox"
                                                    id="kompresi__bimanual" value="bimanual" @checked(in_array('bimanual', $asuhan->ginekologi ?? [])) disabled>
                                                <span>Kompresi bimanual internal/eksternal</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="ginekologi[]" type="checkbox"
                                                    id="breas__care" value="breas" @checked(in_array('breas', $asuhan->ginekologi ?? [])) disabled>
                                                <span>Breas care</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="ginekologi[]" type="checkbox"
                                                    id="ftu" value="tfu" @checked(in_array('tfu', $asuhan->ginekologi ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="sosial[]" type="checkbox"
                                                    id="memberi__dukungan" value="dukungan" @checked(in_array('dukungan', $asuhan->sosial ?? [])) disabled>
                                                <span>Memberi dukungan</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="sosial[]" type="checkbox"
                                                    id="melibatkan__keluarga" value="keluarga" @checked(in_array('keluarga', $asuhan->sosial ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="edukasi[]" type="checkbox"
                                                    id="manajemen__nyeri" value="nyeri" @checked(in_array('nyeri', $asuhan->edukasi ?? [])) disabled>
                                                <span>Manajemen nyeri</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="edukasi[]" type="checkbox"
                                                    id="pencegahan__jatuh" value="jatuh" @checked(in_array('jatuh', $asuhan->edukasi ?? [])) disabled>
                                                <span>Pencegahan jatuh</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="edukasi[]" type="checkbox"
                                                    id="pencegahan__infeksi" value="infeksi" @checked(in_array('infeksi', $asuhan->edukasi ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="cedera[]" type="checkbox"
                                                    id="pasang__penghalang" value="handrail" @checked(in_array('handrail', $asuhan->cedera ?? [])) disabled>
                                                <span>Pasang penghalang tempat tidur/ Handrail</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="cedera[]" type="checkbox"
                                                    id="restrain" value="restrain" @checked(in_array('restrain', $asuhan->cedera ?? [])) disabled>
                                                <span>Restrain</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="cedera[]" type="checkbox"
                                                    id="pasang__pelindung" value="bayi @checked(in_array('bayi', $asuhan->cedera ?? [])) disabled">
                                                <span>Pasang pelindung mata bayi</span>
                                            </label>

                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="cedera[]" type="checkbox"
                                                    id="pastikan__roda" value="roda" @checked(in_array('roda', $asuhan->cedera ?? [])) disabled>
                                                <span>Pastikan roda tempat tidur dan Kursi Roda selalu dalam kondisi terkunci</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="cedera[]" type="checkbox"
                                                    id="gunakan__alat__bantu" value="alat_bantu" @checked(in_array('alat_bantu', $asuhan->cedera ?? [])) disabled>
                                                <span>Gunakan alat bantu</span>
                                            </label>

                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="cedera[]" type="checkbox"
                                                    id="berjalan" value="berjalan" @checked(in_array('berjalan', $asuhan->cedera ?? [])) disabled>
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
                                                <input class="form-check-input flex-shrink-0" name="lainnya[]" type="checkbox"
                                                    id="perawatan__luka" value="luka" @checked(in_array('luka', $asuhan->lainnya ?? [])) disabled>
                                                <span>Perawatan luka/GV</span>
                                            </label>
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lainnya[]" type="checkbox"
                                                    id="perawatan__stoma" value="stoma" @checked(in_array('stoma', $asuhan->lainnya ?? [])) disabled>
                                                <span>Perawatan stoma</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lainnya[]" type="checkbox"
                                                    id="pasang__infus" value="infus" @checked(in_array('infus', $asuhan->lainnya ?? [])) disabled>
                                                <span>Pasang infus/IV line</span>
                                            </label>

                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lainnya[]" type="checkbox"
                                                    id="observasi__kejang" value="kejang" @checked(in_array('kejang', $asuhan->lainnya ?? [])) disabled>
                                                <span>Observasi kejang</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="list-group">
                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lainnya[]" type="checkbox"
                                                    id="perawatan__gips" value="gips" @checked(in_array('gips', $asuhan->lainnya ?? [])) disabled>
                                                <span>Perawatan Gips</span>
                                            </label>

                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lainnya[]" type="checkbox"
                                                    id="perawatan__luka__bakar" value="luka_bakar" @checked(in_array('luka_bakar', $asuhan->lainnya ?? [])) disabled>
                                                <span>Perawatan luka bakar</span>
                                            </label>

                                            <label class="list-group-item d-flex gap-2">
                                                <input class="form-check-input flex-shrink-0" name="lainnya[]" type="checkbox"
                                                    id="Perawatan__mata" value="mata" @checked(in_array('mata', $asuhan->lainnya ?? [])) disabled>
                                                <span>Perawatan mata</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
