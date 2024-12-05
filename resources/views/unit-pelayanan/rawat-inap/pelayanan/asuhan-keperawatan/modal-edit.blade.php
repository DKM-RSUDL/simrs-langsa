<div class="modal fade" id="modal-asuhan-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="bi bi-clipboard2-pulse me-2"></i>EDIT IMPLEMENTASI ASUHAN KEPERAWATAN RAWAT INAP
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAsuhanKeperawatan">
                    <!-- Header Section with Card -->
                    <div class="card mb-4 border-primary">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label fw-bold">Tanggal Implementasi</label>
                                        <input type="date" class="form-control" name="tanggal">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-bold">Waktu</label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="waktu"
                                                id="pagi" checked>
                                            <label class="form-check-label" for="pagi">
                                                <i class="bi bi-sunrise text-warning"></i> Pagi
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="waktu"
                                                id="sore" disabled>
                                            <label class="form-check-label" for="sore">
                                                <i class="bi bi-sun text-orange"></i> Sore
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="waktu"
                                                id="malam" disabled>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="head_tilt" checked>
                                                    <span>Head tilt</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="jaw_trust" disabled>
                                                    <span>Jaw trust</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="nebulizer" checked>
                                                    <span>Nebulizer</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="batuk__efektif" disabled>
                                                    <span>Batuk efektif</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="fisiotherapi__dada" disabled>
                                                    <span>Fisiotherapi dada</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="suction" disabled>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="monitoring" disabled>
                                                    <span>Monitoring bunyi nafas</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="monitoring__sputum" checked>
                                                    <span>Monitoring sputum</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="posisi__semi__fowler" disabled>
                                                    <span>Posisi semi fowler / fowler</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="saturasi__oksigen" disabled>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="mengukur__tekanan_darah" disabled>
                                                    <span>Mengukur tekanan darah</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="menghitung__pernafasan" disabled>
                                                    <span>Menghitung pernafasan</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="menghitung__nadi" disabled>
                                                    <span>Menghitung nadi</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="mengukur__temperature" disabled>
                                                    <span>Mengukur temperature</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="observasi__perubahan" checked>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="identifikasi__lokasi" disabled>
                                                    <span>Identifikasi lokasi, frekuensi, intensitas dan skala
                                                        nyeri.</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="kompres__hangat" checked>
                                                    <span>Kompres hangat/dingin</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="kontrol__lingkungan" disabled>
                                                    <span>Kontrol lingkungan</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="fasilitasi__istirahat" disabled>
                                                    <span>Fasilitasi istirahat dan tidur</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="massage" disabled>
                                                    <span>Massage</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="distraksi" checked>
                                                    <span>Distraksi</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="relaksasi" disabled>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="kaji__mual" disabled>
                                                    <span>Kaji mual dan muntah.</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="timbang__berat__badan" checked>
                                                    <span>Timbang berat badan</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="memberi__makan__via" disabled>
                                                    <span>Memberi makan via</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="memberi__asi" disabled>
                                                    <span>Memberi ASI/PASI</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="berikan__asupan" disabled>
                                                    <span>Berikan asupan cairan oral</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="memasang__ngt" disabled>
                                                    <span>Memasang NGT/OGT</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="puasa">
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="monitor__inkontinensia" disabled>
                                                    <span>Monitor inkontinensia</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="memberikan__pispot" disabled>
                                                    <span>Memberikan pispot/urinal</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pasang__kondom__cateter" checked>
                                                    <span>Pasang kondom cateter</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pasang__foley__cateter" checked>
                                                    <span>Pasang Foley cateter</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="kaji__konsistensi" disabled>
                                                    <span>Kaji konsistensi fasces</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="bladder__training" disabled>
                                                    <span>Bladder training</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pencahar">
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="bantu__mandi" disabled>
                                                    <span>Bantu mandi di tempat tidur</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="bantu__berpakaian" disabled>
                                                    <span>Bantu berpakaian</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__kulit" checked>
                                                    <span>Perawatan kulit</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__rambut" disabled>
                                                    <span>Perawatan rambut</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__kuku" disabled>
                                                    <span>Perawatan kuku</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__oral__hygiene" disabled>
                                                    <span>Perawatan oral hygiene</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__perineon" disabled>
                                                    <span>Perawatan perineon</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__vulva" disabled>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pijat__oksitosin" checked>
                                                    <span>Pijat oksitosin</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="kontraksi__uter" disabled>
                                                    <span>Kontraksi uter</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="kompresi__bimanual" disabled>
                                                    <span>Kompresi bimanual internal/eksternal</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="breas__care" disabled>
                                                    <span>Breas care</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="ftu" disabled>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="memberi__dukungan" checked>
                                                    <span>Memberi dukungan</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="melibatkan__keluarga" disabled>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="manajemen__nyeri" checked>
                                                    <span>Manajemen nyeri</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pencegahan__jatuh" disabled>
                                                    <span>Pencegahan jatuh</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pencegahan__infeksi" disabled>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pasang__penghalang" disabled>
                                                    <span>Pasang penghalang tempat tidur/ Handrail</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="restrain" disabled>
                                                    <span>Restrain</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pasang__pelindung" disabled>
                                                    <span>Pasang pelindung mata bayi</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pastikan__roda" checked>
                                                    <span>Pastikan roda tempat tidur dan Kursi Roda selalu dalam kondisi terkunc</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="gunakan__alat__bantu" checked>
                                                    <span>Gunakan alat bantu</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="berjalan" checked>
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
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__luka" disabled>
                                                    <span>Perawatan luka/GV</span>
                                                </label>
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__stoma" disabled>
                                                    <span>Perawatan stoma</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="pasang__infus" disabled>
                                                    <span>Pasang infus/IV line</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="observasi__kejang" checked>
                                                    <span>Observasi kejang</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="list-group">
                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__gips" disabled>
                                                    <span>Perawatan Gips</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="perawatan__luka__bakar" disabled>
                                                    <span>Perawatan luka bakar</span>
                                                </label>

                                                <label class="list-group-item d-flex gap-2">
                                                    <input class="form-check-input flex-shrink-0" type="checkbox"
                                                        id="Perawatan__mata" disabled>
                                                    <span>Perawatan mata</span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Tutup
                </button>
                <button type="submit" class="btn btn-primary" form="formAsuhanKeperawatan">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-xl {
        max-width: 1140px;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        cursor: pointer;
    }

    .list-group-item {
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .text-orange {
        color: #fd7e14;
    }

    .modal-header {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
    }
</style>

@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btn-asuhan-edit').on('click', function() {
                $('#modal-asuhan-edit').modal('show');
            });

            $('#formAsuhanKeperawatan').on('submit', function(e) {
                e.preventDefault();
                // Tambahkan logika penyimpanan data di sini

                let formData = {
                    tanggal: $('input[name="tanggal"]').val(),
                    waktu: $('input[name="waktu"]:checked').attr('id'),
                    airway: {
                        head_tilt: $('#head_tilt').is(':checked'),
                        jaw_trust: $('#jaw_trust').is(':checked'),
                        nebulizer: $('#nebulizer').is(':checked')
                    },
                    pernafasan: {
                        monitor: $('#monitor').is(':checked'),
                        posisi: $('#posisi').is(':checked')
                    }
                };

                console.log(formData);
                // Lakukan ajax request untuk menyimpan data
            });
        });
    </script>
@endpush
