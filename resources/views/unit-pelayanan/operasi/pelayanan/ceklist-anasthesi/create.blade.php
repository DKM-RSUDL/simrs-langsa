@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.laporan-anastesi.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ route('operasi.pelayanan.laporan-anastesi.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form method="POST"
                action="{{ route('operasi.pelayanan.laporan-anastesi.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">                        
                        <div class="card-body">
                            <div class="px-3">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <h4 class="header-asesmen">CEKLIST KESIAPAN ANESTHESI</h4>
                                        <p>
                                            <i class="fas fa-info-circle me-2"></i> Isikan formulir ceklist kesiapan anesthesi dengan lengkap
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Operation Information -->
                            <div class="section-separator" id="jenisOperasi">                                

                                <div class="form-group">
                                    <label style="min-width: 200px;">Ruangan</label>
                                    <input type="text" class="form-control" name="ruangan" required>
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Diagnosis</label>
                                    <input type="text" class="form-control" name="diagnosis" required>
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 200px;">Teknik Anesthesia</label>
                                    <input type="text" class="form-control" name="teknik_anesthesia" required>
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
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="mesin_anesthesia_listrik" id="mesin_anesthesia_listrik">
                                                        <label class="form-check-label" for="mesin_anesthesia_listrik">
                                                            Mesin anesthesia terhubung dengan sumber listrik, indikator (+) menyala
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="layar_pemantauan_listrik" id="layar_pemantauan_listrik">
                                                        <label class="form-check-label" for="layar_pemantauan_listrik">
                                                            Layar pemantauan terhubung dengan sumber listrik, indikator (+)
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="syringe_pump_listrik" id="syringe_pump_listrik">
                                                        <label class="form-check-label" for="syringe_pump_listrik">
                                                            Syringe pump terhubung dengan sumber listrik, indikator (+)
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="defibrilator_listrik" id="defibrilator_listrik">
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
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="selang_oksigen" id="selang_oksigen">
                                                        <label class="form-check-label" for="selang_oksigen">
                                                            Selang oksigen terhubung antara sumber gas dengan mesin anesthesia
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="flow_meter_o2" id="flow_meter_o2">
                                                        <label class="form-check-label" for="flow_meter_o2">
                                                            Flow meter O2 di mesin anesthesia berfungsi, aliran gas keluar dari mesin dapat dirasakan
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="compressed_air" id="compressed_air">
                                                        <label class="form-check-label" for="compressed_air">
                                                            Compressed air terhubung antara sumber gas dengan mesin anesthesia
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="n2o_terhubung" id="n2o_terhubung">
                                                        <label class="form-check-label" for="n2o_terhubung">
                                                            N2O terhubung antara sumber gas dengan mesin anesthesia
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="flow_meter_n2o" id="flow_meter_n2o">
                                                        <label class="form-check-label" for="flow_meter_n2o">
                                                            Flow meter N2O di mesin anesthesia berfungsi, aliran gas keluar mesin dapat dirasakan
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mesin Anesthesia Section -->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <div class="card-header text-dark">
                                            <h5 class="mb-0 fw-bold">MESIN ANESTHESIA</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="power_on" id="power_on">
                                                        <label class="form-check-label" for="power_on">
                                                            Power On
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="self_calibration" id="self_calibration">
                                                        <label class="form-check-label" for="self_calibration">
                                                            Self calibration : DONE
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="absorber_co2" id="absorber_co2">
                                                        <label class="form-check-label" for="absorber_co2">
                                                            Absorber CO2 dalam kondisi baik
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="tidak_kebocoran" id="tidak_kebocoran">
                                                        <label class="form-check-label" for="tidak_kebocoran">
                                                            Tidak ada kebocoran sirkuit nafas
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="zat_volatil" id="zat_volatil">
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
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="sungkup_muka" id="sungkup_muka">
                                                        <label class="form-check-label" for="sungkup_muka">
                                                            Sungkup muka dalam ukuran yang benar
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="oropharyngeal_airway" id="oropharyngeal_airway">
                                                        <label class="form-check-label" for="oropharyngeal_airway">
                                                            Oropharyngeal airway (Guedel) dalam ukuran yang benar
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="batang_laringoskop" id="batang_laringoskop">
                                                        <label class="form-check-label" for="batang_laringoskop">
                                                            Batang laringoskop berisi baterai
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="bilah_laringoskop" id="bilah_laringoskop">
                                                        <label class="form-check-label" for="bilah_laringoskop">
                                                            Bilah laringoskop dalam ukuran yang benar
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="gagang_bilah_laringoskop" id="gagang_bilah_laringoskop">
                                                        <label class="form-check-label" for="gagang_bilah_laringoskop">
                                                            Gagang dan bilah laringoskop berfungsi dengan baik
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="ett_datai_mma" id="ett_datai_mma">
                                                        <label class="form-check-label" for="ett_datai_mma">
                                                            ETT datai MMA dalam ukuran yang benar dan tidak bocor
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="stilet_introduser" id="stilet_introduser">
                                                        <label class="form-check-label" for="stilet_introduser">
                                                            Stilet (introduser)
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="semprit_cuff" id="semprit_cuff">
                                                        <label class="form-check-label" for="semprit_cuff">
                                                            Semprit untuk mengembangkan cuff
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="forceps_magill" id="forceps_magill">
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
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="kabel_ekg" id="kabel_ekg">
                                                        <label class="form-check-label" for="kabel_ekg">
                                                            Kabel EKG terhubung dengan layar pemantau
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="elektroda_ekg" id="elektroda_ekg">
                                                        <label class="form-check-label" for="elektroda_ekg">
                                                            Elektroda EKG dalam jumlah dan ukuran yang sesuai
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="nibp_terhubung" id="nibp_terhubung">
                                                        <label class="form-check-label" for="nibp_terhubung">
                                                            NIBP terhubung dengan layar pemantau dan berfungsi baik
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="spo2_terhubung" id="spo2_terhubung">
                                                        <label class="form-check-label" for="spo2_terhubung">
                                                            SpO2 terhubung dengan layar pemantau dan berfungsi baik
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pemantau_suhu" id="pemantau_suhu">
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
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="stetoskop_tersedia" id="stetoskop_tersedia">
                                                        <label class="form-check-label" for="stetoskop_tersedia">
                                                            Stetoskop tersedia
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="suction_berfungsi" id="suction_berfungsi">
                                                        <label class="form-check-label" for="suction_berfungsi">
                                                            Suction berfungsi baik
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="selang_suction" id="selang_suction">
                                                        <label class="form-check-label" for="selang_suction">
                                                            Selang suction terhubung, kateter suction dalam ukuran yang benar
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="plester_fiksasi" id="plester_fiksasi">
                                                        <label class="form-check-label" for="plester_fiksasi">
                                                            Plester dan fiksasi
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="blanket_roll" id="blanket_roll">
                                                        <label class="form-check-label" for="blanket_roll">
                                                            Blanket roll/hemotherm/radiant heater terhubung dengan sumber listrik dan berfungsi baik
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="blanket_roll_alas" id="blanket_roll_alas">
                                                        <label class="form-check-label" for="blanket_roll_alas">
                                                            Blanket roll dilapisi alas
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="lidocain_spray" id="lidocain_spray">
                                                        <label class="form-check-label" for="lidocain_spray">
                                                            Lidocain spray/jelly
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="defibrillator_jelly" id="defibrillator_jelly">
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
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="epinefrin" id="epinefrin">
                                                        <label class="form-check-label" for="epinefrin">
                                                            Epinefrin
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="atrofin" id="atrofin">
                                                        <label class="form-check-label" for="atrofin">
                                                            Atrofin
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="sedatif" id="sedatif">
                                                        <label class="form-check-label" for="sedatif">
                                                            Sedatif (midazolam/propofol/etomidat/ketamin/tiopental)
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="min-width: 100px;">Lain-lain:</label>                                                                                                                
                                                        <input type="text" class="form-control" name="obat_lain" required>
                                                    </div>                                                    
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="opiat_opioid" id="opiat_opioid">
                                                        <label class="form-check-label" for="opiat_opioid">
                                                            Opiat/opioid
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="pelumpuh_otot" id="pelumpuh_otot">
                                                        <label class="form-check-label" for="pelumpuh_otot">
                                                            Pelumpuh otot
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="antibiotik" id="antibiotik">
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
                                            <input type="text" class="form-control" name="pemeriksa" required>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Supervisor</label>
                                            <input type="text" class="form-control" name="supervisor" required>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary" id="simpan">
                                    <i class="fas fa-save me-1"></i> Simpan
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