@extends('layouts.administrator.master')

@include('unit-pelayanan.rawat-inap.pelayanan.asesmen-terminal.include')

@push('css')
    <style>
        .header-asesmen {
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .section-title {
            /* background: linear-gradient(135deg, #3498db 0%, #fff 100%); */
            color: black;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-section:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .subsection-title {
            color: #495057;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
            padding-left: 10px;
            border-left: 4px solid #007bff;
        }

        .checkbox-group {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
        }

        .checkbox-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            padding: 8px 0;
        }

        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            cursor: pointer;
            accent-color: #007bff;
        }

        .checkbox-item label {
            cursor: pointer;
            margin: 0;
            font-weight: 500;
            color: #495057;
            flex: 1;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background: #fff;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .radio-item:hover {
            border-color: #007bff;
            background: #f8f9ff;
        }

        .radio-item input[type="radio"]:checked+label {
            color: #007bff;
            font-weight: 600;
        }

        .radio-item input[type="radio"] {
            margin-right: 8px;
            accent-color: #007bff;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .alert-info {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        .section-number {
            display: inline-block;
            background: #007bff;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: bold;
            margin-right: 10px;
        }

        .text-input-group {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin-top: 10px;
        }

        .required-field::after {
            content: " *";
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .radio-group {
                flex-direction: column;
            }

            .radio-item {
                margin-bottom: 10px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">
                                        <i class="fas fa-clipboard-list me-2"></i>
                                        Asesmen Awal dan Ulang Pasien Terminal dan Keluarganya
                                    </h4>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Isikan Asesmen Keperawatan dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('rawat-inap.asesmen.keperawatan.terminal.index', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}" enctype="multipart/form-data">
                            @csrf

                            <div class="px-3">
                                <!-- Data Masuk -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">1</span>
                                        Data Masuk
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label required-field">Tanggal Masuk</label>
                                            <input type="date" class="form-control" name="tanggal" id="tanggal_masuk"
                                                value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required-field">Jam Masuk</label>
                                            <input type="time" class="form-control" name="jam_masuk" id="jam_masuk"
                                                value="{{ date('H:i') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 1: Gejala Seperti Mau Muntah -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">2</span>
                                        Gejala seperti mau muntah dan kesulitan bernafas
                                    </h5>

                                    <div class="subsection-title">1.1. Kegawatan pernafasan:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="dyspnoe" id="dyspnoe" value="1">
                                                    <label for="dyspnoe">Dyspnoe</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="nafas_tak_teratur" id="nafas_tak_teratur"
                                                        value="1">
                                                    <label for="nafas_tak_teratur">Nafas Tak teratur</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="ada_sekret" id="ada_sekret" value="1">
                                                    <label for="ada_sekret">Ada sekret</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="nafas_cepat_dangkal"
                                                        id="nafas_cepat_dangkal" value="1">
                                                    <label for="nafas_cepat_dangkal">Nafas cepat dan dangkal</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="nafas_melalui_mulut"
                                                        id="nafas_melalui_mulut" value="1">
                                                    <label for="nafas_melalui_mulut">Nafas melalui mulut</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="spo2_normal" id="spo2_normal" value="1">
                                                    <label for="spo2_normal">SpO₂ < normal</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="nafas_lambat" id="nafas_lambat" value="1">
                                                    <label for="nafas_lambat">Nafas lambat</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="mukosa_oral_kering" id="mukosa_oral_kering"
                                                        value="1">
                                                    <label for="mukosa_oral_kering">Mukosa oral kering</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="tak" id="tak" value="1">
                                                    <label for="tak">T.A.K</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title">1.2. Kegawatan Tikus otot:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="mual" id="mual" value="1">
                                                    <label for="mual">Mual</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="sulit_menelan" id="sulit_menelan"
                                                        value="1">
                                                    <label for="sulit_menelan">Sulit menelan</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="inkontinensia_alvi" id="inkontinensia_alvi"
                                                        value="1">
                                                    <label for="inkontinensia_alvi">Inkontinensia alvi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="penurunan_pergerakan"
                                                        id="penurunan_pergerakan" value="1">
                                                    <label for="penurunan_pergerakan">Penurunan Pergerakan tubuh</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="distensi_abdomen" id="distensi_abdomen"
                                                        value="1">
                                                    <label for="distensi_abdomen">Distensi Abdomen</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="tak2" id="tak2" value="1">
                                                    <label for="tak2">T.A.K</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="sulit_berbicara" id="sulit_berbicara"
                                                        value="1">
                                                    <label for="sulit_berbicara">Sulit Berbicara</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="inkontinensia_urine"
                                                        id="inkontinensia_urine" value="1">
                                                    <label for="inkontinensia_urine">Inkontinensia Urine</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="subsection-title">1.3. Nyeri:</div>
                                    <div class="radio-group">
                                        <div class="radio-item">
                                            <input type="radio" name="nyeri" id="nyeri_tidak" value="0">
                                            <label for="nyeri_tidak">Tidak</label>
                                        </div>
                                        <div class="radio-item">
                                            <input type="radio" name="nyeri" id="nyeri_ya" value="1">
                                            <label for="nyeri_ya">Ya</label>
                                        </div>
                                    </div>
                                    <div class="text-input-group" id="nyeri_keterangan" style="display: none;">
                                        <label class="form-label">Keterangan:</label>
                                        <textarea class="form-control" name="nyeri_keterangan" rows="2"
                                            placeholder="Jelaskan lokasi, intensitas, dan karakteristik nyeri..."></textarea>
                                    </div>

                                    <div class="subsection-title mt-4">1.4. Perlambatan Sirkulasi:</div>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="bercerak_sianosis" id="bercerak_sianosis"
                                                        value="1">
                                                    <label for="bercerak_sianosis">Bercerak dan sianosis pada
                                                        ekstremitas</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="gelisah" id="gelisah" value="1">
                                                    <label for="gelisah">Gelisah</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="lemas" id="lemas" value="1">
                                                    <label for="lemas">Lemas</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="kulit_dingin" id="kulit_dingin" value="1">
                                                    <label for="kulit_dingin">Kulit dingin dan berkeringat</label>
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="tekanan_darah" id="tekanan_darah"
                                                        value="1">
                                                    <label for="tekanan_darah">Tekanan Darah menurun</label>
                                                </div>
                                                <div class="text-input-group">
                                                    <label class="form-label">Nadi lambat dan lemah:</label>
                                                    <input type="text" class="form-control" name="nadi_lambat"
                                                        placeholder="Masukkan nilai...">
                                                </div>
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="tak3" id="tak3" value="1">
                                                    <label for="tak3">T.A.K</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 2: Faktor-faktor yang meningkatkan -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">3</span>
                                        Faktor-faktor yang meningkatkan dan membangkitkan gejala fisik
                                    </h5>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="melakukan_aktivitas"
                                                        id="melakukan_aktivitas" value="1">
                                                    <label for="melakukan_aktivitas">Melakukan aktivitas fisik</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="pindah_posisi" id="pindah_posisi"
                                                        value="1">
                                                    <label for="pindah_posisi">Pindah posisi</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-input-group">
                                            <label class="form-label">Lainnya:</label>
                                            <textarea class="form-control" name="faktor_lainnya" rows="2"
                                                placeholder="Sebutkan faktor lainnya..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section 3: Faktor-faktor yang meningkatkan -->
                                <div class="form-section">
                                    <h5 class="section-title">
                                        <span class="section-number">4</span>
                                        Manajemen gejala saat ini da respon pasien
                                    </h5>
                                    <div class="checkbox-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="melakukan_aktivitas"
                                                        id="melakukan_aktivitas" value="1">
                                                    <label for="melakukan_aktivitas">Melakukan aktivitas fisik</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkbox-item">
                                                    <input type="checkbox" name="pindah_posisi" id="pindah_posisi"
                                                        value="1">
                                                    <label for="pindah_posisi">Pindah posisi</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-input-group">
                                            <label class="form-label">Lainnya:</label>
                                            <textarea class="form-control" name="faktor_lainnya" rows="2"
                                                placeholder="Sebutkan faktor lainnya..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Continue with other sections... -->
                                <!-- I'll add the remaining sections following the same pattern -->

                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i> Simpan Asesmen
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // Show/hide nyeri keterangan
            $('input[name="nyeri"]').change(function () {
                if ($(this).val() === '1') {
                    $('#nyeri_keterangan').slideDown();
                } else {
                    $('#nyeri_keterangan').slideUp();
                }
            });

            // Form validation
            $('form').on('submit', function (e) {
                let isValid = true;
                let errorMessage = '';

                // Check required fields
                if (!$('#tanggal_masuk').val()) {
                    isValid = false;
                    errorMessage += 'Tanggal masuk harus diisi.\n';
                }

                if (!$('#jam_masuk').val()) {
                    isValid = false;
                    errorMessage += 'Jam masuk harus diisi.\n';
                }

                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                    return false;
                }
            });

            // Add visual feedback for checkbox interactions
            $('input[type="checkbox"]').change(function () {
                if ($(this).is(':checked')) {
                    $(this).closest('.checkbox-item').addClass('selected');
                } else {
                    $(this).closest('.checkbox-item').removeClass('selected');
                }
            });

            // Add visual feedback for radio interactions
            $('input[type="radio"]').change(function () {
                $('input[name="' + $(this).attr('name') + '"]').closest('.radio-item').removeClass('selected');
                $(this).closest('.radio-item').addClass('selected');
            });
        });
    </script>

    <style>
        .checkbox-item.selected {
            background-color: #e3f2fd;
            border-radius: 5px;
            padding: 8px;
        }

        .radio-item.selected {
            border-color: #007bff;
            background-color: #f8f9ff;
        }
    </style>
@endpush
