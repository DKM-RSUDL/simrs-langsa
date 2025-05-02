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
                <h5 class="text-secondary fw-bold">Monitoring Intensive Care Unit (ICCU) </h5>
            </div>

            <hr>

            <div class="form-section">
                <form action="#" method="post" id="iccuForm">
                    @csrf

                    <!-- Form Date and Time Section with Validation -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">                    
                                <small class="text-warning">
                                    <i class="bi bi-exclamation-triangle-fill"></i> 
                                    Mohon pastikan jam diisi dengan benar untuk keakuratan dokumentasi medis
                                </small>
                                <div class="col-md-6">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label fw-bold">Tanggal Implementasi <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="tgl_implementasi" id="tgl_implementasi" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 mb-md-0">
                                        <label class="form-label fw-bold">Jam Implementasi <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control" name="jam_implementasi" id="jam_implementasi" value="{{ date('H:i') }}" required>
                                        <div class="invalid-feedback" id="timeError">
                                            Pastikan format jam benar (HH:MM)
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Patient Information Section -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Informasi Pasien
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Indikasi ICCU <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="indikasi_iccu" rows="2" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Diagnosa <span class="text-danger">*</span></label>
                                        <input class="form-control" name="diagnosa" required></input>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Alergi</label>
                                        <textarea class="form-control" name="alergi" rows="2" placeholder="Tuliskan jika ada alergi"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Berat Badan (kg)</label>
                                                <input type="number" step="0.1" min="0" class="form-control" name="berat_badan" placeholder="kg">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Tinggi Badan (cm)</label>
                                                <input type="number" step="1" min="0" class="form-control" name="tinggi_badan" placeholder="cm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monitoring ICCU Parameters -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-heart-pulse-fill me-2"></i>
                                Monitoring ICCU Parameters
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Sistolik (mmHg)</label>
                                        <input type="number" class="form-control" name="sistolik" id="sistolik" min="0" max="300">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Diastolik (mmHg)</label>
                                        <input type="number" class="form-control" name="diastolik" id="diastolik" min="0" max="200">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">MAP</label>
                                        <input type="number" class="form-control" name="map" id="map" readonly>
                                        <small class="text-muted">Dihitung otomatis</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Heart Rate (HR) <small>bpm</small></label>
                                        <input type="number" class="form-control" name="hr" min="0" max="300">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Resp. Rate (RR) <small>x/menit</small></label>
                                        <input type="number" class="form-control" name="rr" min="0" max="100">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Suhu (°C)</label>
                                        <input type="number" step="0.1" class="form-control" name="temp" min="30" max="45">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">CVP <small>(Cm H<sub>2</sub>O)</small></label>
                                        <input type="number" step="0.1" class="form-control" name="cvp" min="0" max="50">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">EKG Record</label>
                                        <textarea class="form-control" name="ekg_record" rows="2" placeholder="Catatan hasil EKG"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- AGD Parameters -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="bi bi-droplet-fill me-2"></i>
                                Analisa Gas Darah (AGD) dan Parameter Laboratorium
                            </h6>
                        </div>
                        <div class="card-body">
                            <!-- AGD Parameters -->
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">pH</label>
                                        <input type="number" step="0.01" class="form-control" name="ph" min="0" max="14">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PO<sub>2</sub></label>
                                        <input type="number" step="0.1" class="form-control" name="po2">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">PCO<sub>2</sub></label>
                                        <input type="number" step="0.1" class="form-control" name="pco2">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">BE</label>
                                        <input type="number" step="0.1" class="form-control" name="be">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">HCO<sub>3</sub></label>
                                        <input type="number" step="0.1" class="form-control" name="hco3">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Saturasi O<sub>2</sub></label>
                                        <input type="number" step="0.1" class="form-control" name="saturasi_o2" min="0" max="100">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Elektrolit Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Elektrolit</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Na</label>
                                        <input type="number" step="0.1" class="form-control" name="na">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">K</label>
                                        <input type="number" step="0.1" class="form-control" name="k">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Cl</label>
                                        <input type="number" step="0.1" class="form-control" name="cl">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Renal Function Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Fungsi Ginjal</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ureum</label>
                                        <input type="number" step="0.1" class="form-control" name="ureum">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Creatinin</label>
                                        <input type="number" step="0.01" class="form-control" name="creatinin">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hematology Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Hematologi</h6>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Hb</label>
                                        <input type="number" step="0.1" class="form-control" name="hb">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Ht</label>
                                        <input type="number" step="0.1" class="form-control" name="ht">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Leukosit (L)</label>
                                        <input type="number" step="0.01" class="form-control" name="leukosit">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Trombosit (Tr)</label>
                                        <input type="number" class="form-control" name="trombosit">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Liver Function Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Fungsi Hati</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGOT</label>
                                        <input type="number" step="0.1" class="form-control" name="sgot">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">SGPT</label>
                                        <input type="number" step="0.1" class="form-control" name="sgpt">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Other Parameters -->
                            <h6 class="mb-3 border-bottom pb-2">Parameter Tambahan</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">KDGS (Gula Darah)</label>
                                        <input type="number" step="1" class="form-control" name="kdgs">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Albumin</label>
                                        <input type="number" step="0.1" class="form-control" name="albumin">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Kesadaran</label>
                                        <select class="form-select" name="kesadaran">
                                            <option value="">- Pilih -</option>
                                            <option value="compos_mentis">Compos Mentis</option>
                                            <option value="somnolence">Somnolence</option>
                                            <option value="sopor">Sopor</option>
                                            <option value="coma">Coma</option>
                                            <option value="delirium">Delirium</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Oxygen Therapy -->
                            <h6 class="mb-3 border-bottom pb-2">Terapi Oksigen</h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Terapi Oksigen</label>
                                        <textarea class="form-control" name="terapi_oksigen" rows="2" placeholder="Jenis dan dosis terapi oksigen yang diberikan"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Validasi jam
            $('#jam_implementasi').on('change', function() {
                const timePattern = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
                const timeValue = $(this).val();
                
                if (!timePattern.test(timeValue)) {
                    $(this).addClass('is-invalid');
                    $('#timeError').show();
                } else {
                    $(this).removeClass('is-invalid');
                    $('#timeError').hide();
                }
            });
            
            // Hitung MAP otomatis ketika sistolik atau diastolik berubah
            $('#sistolik, #diastolik').on('input', function() {
                calculateMAP();
            });
            
            // Fungsi untuk menghitung MAP
            function calculateMAP() {
                const sistolik = parseInt($('#sistolik').val()) || 0;
                const diastolik = parseInt($('#diastolik').val()) || 0;
                
                if (sistolik > 0 && diastolik > 0) {
                    // Rumus MAP = (SBP + 2 x DBP) / 3
                    const map = Math.round((sistolik + (2 * diastolik)) / 3);
                    $('#map').val(map);
                } else {
                    $('#map').val('');
                }
            }
            
            // Validasi form sebelum submit
            $('#iccuForm').on('submit', function(e) {
                const requiredFields = [
                    'tgl_implementasi', 
                    'jam_implementasi',
                    'indikasi_iccu',
                    'diagnosa'
                ];
                
                let isValid = true;
                
                requiredFields.forEach(function(field) {
                    const fieldValue = $(`[name="${field}"]`).val();
                    if (!fieldValue || fieldValue.trim() === '') {
                        $(`[name="${field}"]`).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(`[name="${field}"]`).removeClass('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi data yang wajib diisi!');
                }
            });
        });
    </script>
    @endpush
@endsection