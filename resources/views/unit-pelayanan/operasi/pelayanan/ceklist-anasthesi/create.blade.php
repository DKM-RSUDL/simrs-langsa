@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.laporan-anastesi.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Checklist Kesiapan Anesthesi',
                    'description' => 'Lengkapi formulir ceklist kesiapan anesthesi dengan benar.',
                ])
                <form method="POST"
                    action="{{ route('operasi.pelayanan.ceklist-anasthesi.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex flex-column gap-4">
                        <!-- Operation Information -->
                        <hr>
                        <div>

                            <div class="form-group">
                                <label style="min-width: 300px;">Ruangan</label>
                                <input type="text" class="form-control" name="ruangan">
                            </div>
                            <div class="form-group">
                                <label style="min-width: 300px;">Diagnosis</label>
                                <input type="text" class="form-control" name="diagnosis">
                            </div>
                            <div class="form-group">
                                <label style="min-width: 300px;">Teknik Anesthesia</label>
                                <input type="text" class="form-control" name="teknik_anesthesia">
                            </div>
                        </div>
                        <hr>

                        <!-- Checklist Sections -->
                        <div class="row mb-0">
                            <!-- Listrik Section -->
                            <div>
                                <h5 class="fw-bold">LISTRIK</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox"
                                                name="mesin_anesthesia_listrik[]" id="mesin_anesthesia_listrik"
                                                value="mesin_anesthesia_listrik">
                                            <label class="form-check-label" for="mesin_anesthesia_listrik">
                                                Mesin anesthesia terhubung dengan sumber listrik, indikator
                                                (+) menyala
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox"
                                                name="mesin_anesthesia_listrik[]" id="layar_pemantauan_listrik"
                                                value="layar_pemantauan_listrik">
                                            <label class="form-check-label" for="layar_pemantauan_listrik">
                                                Layar pemantauan terhubung dengan sumber listrik, indikator
                                                (+)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox"
                                                name="mesin_anesthesia_listrik[]" id="syringe_pump_listrik"
                                                value="syringe_pump_listrik">
                                            <label class="form-check-label" for="syringe_pump_listrik">
                                                Syringe pump terhubung dengan sumber listrik, indikator (+)
                                            </label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox"
                                                name="mesin_anesthesia_listrik[]" id="defibrilator_listrik"
                                                value="defibrilator_listrik">
                                            <label class="form-check-label" for="defibrilator_listrik">
                                                Defibrilator terhubung dengan sumber listrik, indikator (+)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Gas Medis Section -->
                        <div>
                            <h5 class="fw-bold">GAS MEDIS</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="gas_medis[]"
                                            id="selang_oksigen" value="selang_oksigen">
                                        <label class="form-check-label" for="selang_oksigen">
                                            Selang oksigen terhubung antara sumber gas dengan mesin
                                            anesthesia
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="gas_medis[]"
                                            id="flow_meter_o2" value="flow_meter_o2">
                                        <label class="form-check-label" for="flow_meter_o2">
                                            Flow meter O2 di mesin anesthesia berfungsi, aliran gas
                                            keluar dari mesin dapat dirasakan
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="gas_medis[]"
                                            id="compressed_air" value="compressed_air">
                                        <label class="form-check-label" for="compressed_air">
                                            Compressed air terhubung antara sumber gas dengan mesin
                                            anesthesia
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="gas_medis[]"
                                            id="n2o_terhubung" value="n2o_terhubung">
                                        <label class="form-check-label" for="n2o_terhubung">
                                            N2O terhubung antara sumber gas dengan mesin anesthesia
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="gas_medis[]"
                                            id="flow_meter_n2o" value="flow_meter_n2o">
                                        <label class="form-check-label" for="flow_meter_n2o">
                                            Flow meter N2O di mesin anesthesia berfungsi, aliran gas
                                            keluar mesin dapat dirasakan
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Mesin Anesthesia Section -->
                        <div>
                            <h5 class="fw-bold">MESIN ANESTHESIA</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="mesin_anesthesia[]"
                                            id="power_on" value="power_on">
                                        <label class="form-check-label" for="power_on">
                                            Power On
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="mesin_anesthesia[]"
                                            id="self_calibration" value="self_calibration">
                                        <label class="form-check-label" for="self_calibration">
                                            Self calibration : DONE
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="mesin_anesthesia[]"
                                            id="absorber_co2" value="absorber_co2">
                                        <label class="form-check-label" for="absorber_co2">
                                            Absorber CO2 dalam kondisi baik
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="mesin_anesthesia[]"
                                            id="tidak_kebocoran" value="tidak_kebocoran">
                                        <label class="form-check-label" for="tidak_kebocoran">
                                            Tidak ada kebocoran sirkuit nafas
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="mesin_anesthesia[]"
                                            id="zat_volatil" value="zat_volatil">
                                        <label class="form-check-label" for="zat_volatil">
                                            Zat volatil terisi
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Manajemen Jalan Nafas -->
                        <div>
                            <h5 class="fw-bold">MANAJEMEN JALAN NAFAS</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="manajemen_jalan_nafas[]"
                                            id="sungkup_muka" value="sungkup_muka">
                                        <label class="form-check-label" for="sungkup_muka">
                                            Sungkup muka dalam ukuran yang benar
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="manajemen_jalan_nafas[]"
                                            id="oropharyngeal_airway" value="oropharyngeal_airway">
                                        <label class="form-check-label" for="oropharyngeal_airway">
                                            Oropharyngeal airway (Guedel) dalam ukuran yang benar
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="manajemen_jalan_nafas[]"
                                            id="batang_laringoskop" value="batang_laringoskop">
                                        <label class="form-check-label" for="batang_laringoskop">
                                            Batang laringoskop berisi baterai
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="manajemen_jalan_nafas[]"
                                            id="bilah_laringoskop" value="bilah_laringoskop">
                                        <label class="form-check-label" for="bilah_laringoskop">
                                            Bilah laringoskop dalam ukuran yang benar
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="manajemen_jalan_nafas[]"
                                            id="gagang_bilah_laringoskop" value="gagang_bilah_laringoskop">
                                        <label class="form-check-label" for="gagang_bilah_laringoskop">
                                            Gagang dan bilah laringoskop berfungsi dengan baik
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="manajemen_jalan_nafas[]"
                                            id="ett_datai_mma" value="ett_datai_mma">
                                        <label class="form-check-label" for="ett_datai_mma">
                                            ETT datai MMA dalam ukuran yang benar dan tidak bocor
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="manajemen_jalan_nafas[]"
                                            id="stilet_introduser" value="stilet_introduser">
                                        <label class="form-check-label" for="stilet_introduser">
                                            Stilet (introduser)
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="manajemen_jalan_nafas[]"
                                            id="semprit_cuff" value="semprit_cuff">
                                        <label class="form-check-label" for="semprit_cuff">
                                            Semprit untuk mengembangkan cuff
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="manajemen_jalan_nafas[]"
                                            id="forceps_magill" value="forceps_magill">
                                        <label class="form-check-label" for="forceps_magill">
                                            Forceps magill
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Pemantauan -->
                        <div>
                            <h5 class="fw-bold">PEMANTAUAN</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                            id="kabel_ekg" value="kabel_ekg">
                                        <label class="form-check-label" for="kabel_ekg">
                                            Kabel EKG terhubung dengan layar pemantau
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                            id="elektroda_ekg" value="elektroda_ekg">
                                        <label class="form-check-label" for="elektroda_ekg">
                                            Elektroda EKG dalam jumlah dan ukuran yang sesuai
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                            id="nibp_terhubung" value="nibp_terhubung">
                                        <label class="form-check-label" for="nibp_terhubung">
                                            NIBP terhubung dengan layar pemantau dan berfungsi baik
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                            id="spo2_terhubung" value="spo2_terhubung">
                                        <label class="form-check-label" for="spo2_terhubung">
                                            SpO2 terhubung dengan layar pemantau dan berfungsi baik
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="pemantauan[]"
                                            id="pemantau_suhu" value="pemantau_suhu">
                                        <label class="form-check-label" for="pemantau_suhu">
                                            Pemantau suhu terhubung dengan layar pemantau
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Lain-lain -->
                        <div>
                            <h5 class="fw-bold">LAIN-LAIN</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                            id="stetoskop_tersedia" value="stetoskop_tersedia">
                                        <label class="form-check-label" for="stetoskop_tersedia">
                                            Stetoskop tersedia
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                            id="suction_berfungsi" value="suction_berfungsi">
                                        <label class="form-check-label" for="suction_berfungsi">
                                            Suction berfungsi baik
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                            id="selang_suction" value="selang_suction">
                                        <label class="form-check-label" for="selang_suction">
                                            Selang suction terhubung, kateter suction dalam ukuran yang
                                            benar
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                            id="plester_fiksasi" value="plester_fiksasi">
                                        <label class="form-check-label" for="plester_fiksasi">
                                            Plester dan fiksasi
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                            id="blanket_roll" value="blanket_roll">
                                        <label class="form-check-label" for="blanket_roll">
                                            Blanket roll/hemotherm/radiant heater terhubung dengan
                                            sumber listrik dan berfungsi baik
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                            id="blanket_roll_alas" value="blanket_roll_alas">
                                        <label class="form-check-label" for="blanket_roll_alas">
                                            Blanket roll dilapisi alas
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                            id="lidocain_spray" value="lidocain_spray">
                                        <label class="form-check-label" for="lidocain_spray">
                                            Lidocain spray/jelly
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="lain_lain[]"
                                            id="defibrillator_jelly" value="defibrillator_jelly">
                                        <label class="form-check-label" for="defibrillator_jelly">
                                            Defibrillator jelly
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Obat-obatan -->
                        <div>
                            <h5 class="fw-bold">OBAT-OBATAN</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                            id="epinefrin" value="epinefrin">
                                        <label class="form-check-label" for="epinefrin">
                                            Epinefrin
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                            id="atrofin" value="atrofin">
                                        <label class="form-check-label" for="atrofin">
                                            Atrofin
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                            id="sedatif" value="sedatif">
                                        <label class="form-check-label" for="sedatif">
                                            Sedatif (midazolam/propofol/etomidat/ketamin/tiopental)
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label style="min-width: 100px;">Lain-lain:</label>
                                        <input type="text" class="form-control" name="obat_lain">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                            id="opiat_opioid" value="opiat_opioid">
                                        <label class="form-check-label" for="opiat_opioid">
                                            Opiat/opioid
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                            id="pelumpuh_otot" value="pelumpuh_otot">
                                        <label class="form-check-label" for="pelumpuh_otot">
                                            Pelumpuh otot
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="obat_obatan[]"
                                            id="antibiotik" value="antibiotik">
                                        <label class="form-check-label" for="antibiotik">
                                            Antibiotik
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Pemeriksa dan Supervisor -->
                        <div>
                            <h5 class="fw-bold">PEMERIKSA DAN SUPERVISOR</h5>

                            <div class="form-group">
                                <label style="min-width: 300px;">Pemeriksa (Residen/perawat
                                    anestesi)</label>
                                <select class="form-select select2" name="pemeriksa" required>
                                    <option value="" disabled selected>Pilih Perawat</option>
                                    @foreach ($perawat as $p)
                                        <option value="{{ $p->kd_perawat }}">{{ $p->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label style="min-width: 300px;">Supervisor</label>
                                <select class="form-select select2" name="supervisor" required>
                                    <option value="" disabled selected>Pilih Perawat</option>
                                    @foreach ($perawat as $p)
                                        <option value="{{ $p->kd_perawat }}">{{ $p->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <x-button-submit />
                        </div>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize tooltips
                $('[data-toggle="tooltip"]').tooltip();

                // Optional: Add validation highlight
                $('.form-check-input').change(function() {
                    if ($(this).is(':checked')) {
                        $(this).closest('.form-check').addClass('text-success');
                    } else {
                        $(this).closest('.form-check').removeClass('text-success');
                    }
                });

                // Optional: Check all items in a section
                $('.check-all').click(function() {
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
                $('form').submit(function(event) {
                    // Check required fields
                    let hasErrors = false;

                    $('input[required], select[required], textarea[required]').each(function() {
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
                $('input, select, textarea').on('input change', function() {
                    $(this).removeClass('is-invalid');
                });
            });
        </script>
    @endpush
@endsection
