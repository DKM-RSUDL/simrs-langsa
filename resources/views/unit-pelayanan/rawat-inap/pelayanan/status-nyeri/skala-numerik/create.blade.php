@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #00223b;
            text-align: center;
            margin-bottom: 1rem;
        }

        .btn-outline-primary {
            color: #097dd6;
            border-color: #097dd6;
        }

        .btn-outline-primary:hover {
            background-color: #097dd6;
            color: white;
        }

        .form-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1rem;
            font-size: 1.1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.25rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .pain-scale-selector {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .pain-scale-option {
            flex: 1;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 0.75rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .pain-scale-option:hover {
            border-color: #097dd6;
            background-color: #f8f9fa;
        }

        .pain-scale-option.selected {
            border-color: #097dd6;
            background-color: #e3f2fd;
        }

        .pain-scale-option input[type="radio"] {
            margin-bottom: 0.3rem;
            transform: scale(1.2);
        }

        .pain-scale-image {
            margin: 0.75rem 0;
            text-align: center;
        }

        .pain-scale-image img {
            width: 600px;
            height: 200px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .pain-value-input {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .pain-value-input input {
            width: 80px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .pain-status {
            background-color: #e3f2fd;
            border: 2px solid #097dd6;
            border-radius: 8px;
            padding: 0.75rem;
            text-align: center;
            margin-bottom: 0.75rem;
        }

        .pain-status-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #097dd6;
            margin-bottom: 0.25rem;
        }

        .pain-status-text {
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
        }

        .menjalar-group {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .menjalar-btn {
            flex: 1;
            padding: 0.5rem;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            background-color: white;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .menjalar-btn.selected {
            border-color: #097dd6;
            background-color: #e3f2fd;
            color: #097dd6;
        }

        .menjalar-keterangan {
            margin-top: 0.75rem;
            display: none;
        }

        .menjalar-keterangan.show {
            display: block;
        }

        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .radio-item {
            display: flex;
            align-items: center;
            background-color: white;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .radio-item:hover {
            border-color: #097dd6;
            background-color: #f8f9fa;
        }

        .radio-item input[type="radio"] {
            margin-right: 0.5rem;
            margin-bottom: 0;
            transform: scale(1.2);
            cursor: pointer;
        }

        .radio-item label {
            margin-bottom: 0;
            cursor: pointer;
            font-weight: 500;
            color: #495057;
            flex: 1;
        }

        .radio-item input[type="radio"]:checked + label {
            color: #097dd6;
            font-weight: 600;
        }

        .radio-item:has(input[type="radio"]:checked) {
            border-color: #097dd6;
            background-color: #e3f2fd;
        }

        .alert {
            margin-bottom: 0.75rem;
            padding: 0.75rem;
        }

        .form-check {
            margin-bottom: 0.5rem !important;
        }

        .form-check-input {
            margin-top: 0.125rem;
        }

        .form-check-label {
            margin-bottom: 0;
            padding-left: 0.25rem;
        }

        /* Responsive untuk radio buttons */
        @media (max-width: 768px) {
            .radio-group {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .radio-item {
                min-width: 100%;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }
            
            .pain-scale-selector {
                flex-direction: column;
            }
            
            .pain-scale-image img {
                width: 100%;
                height: 150px;
            }
            
            .form-section {
                padding: 0.5rem;
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
            <a href="{{ route('rawat-inap.status-nyeri.skala-numerik.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="painAssessmentForm" method="POST"
                action="{{ route('rawat-inap.status-nyeri.skala-numerik.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Form Pengkajian Status Nyeri Lanjutan Skala Numerik dan Wong Baker</h4>

                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Dasar</h5>
                            
                            <div class="form-group">
                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                <div class="datetime-group">
                                    <div class="datetime-item">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_implementasi" id="tanggal_implementasi" required>
                                    </div>
                                    <div class="datetime-item">
                                        <label>Jam</label>
                                        <input type="time" class="form-control" name="jam_implementasi" id="jam_implementasi" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pain Scale Selection -->
                        <div class="form-section">
                            <h5 class="section-title">Pilih Skala Nyeri</h5>
                            
                            <div class="pain-scale-selector">
                                <div class="pain-scale-option" data-scale="numerik">
                                    <input type="radio" name="pain_scale_type" value="numerik" id="numerik_scale" required>
                                    <label for="numerik_scale">Numerik Pain Scale</label>
                                </div>
                                <div class="pain-scale-option" data-scale="wong_baker">
                                    <input type="radio" name="pain_scale_type" value="wong_baker" id="wong_baker_scale" required>
                                    <label for="wong_baker_scale">Wong Baker Face Pain Scale</label>
                                </div>
                            </div>

                            <!-- Pain Scale Images -->
                            <div id="pain_scale_image" class="pain-scale-image" style="display: none;">
                                <img id="scale_image" src="" alt="Pain Scale">
                            </div>

                            <!-- Pain Value Input -->
                            <div class="form-group">
                                <label class="form-label">Nilai Nyeri (0-10)</label>
                                <div class="pain-value-input">
                                    <input type="number" class="form-control" name="pain_value" id="pain_value" min="0" max="10" onchange="updatePainStatus()" required>
                                    <span>/ 10</span>
                                </div>
                            </div>

                            <!-- Pain Status Display -->
                            <div id="pain_status" class="pain-status" style="display: none;">
                                <div class="pain-status-value" id="pain_status_value">-</div>
                                <div class="pain-status-text" id="pain_status_text">Masukkan nilai nyeri</div>
                            </div>
                        </div>

                        <!-- Pain Details Section -->
                        <div class="form-section">
                            <h5 class="section-title">Detail Nyeri</h5>
                            
                            <div class="form-group">
                                <label class="form-label">Lokasi Nyeri</label>
                                <input type="text" class="form-control" name="lokasi_nyeri" id="lokasi_nyeri" placeholder="Contoh: Kepala, Dada, Perut..." required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Durasi Nyeri (dalam menit)</label>
                                <input type="number" class="form-control" name="durasi_nyeri" id="durasi_nyeri" min="1" placeholder="Contoh: 30" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Apakah nyeri menjalar?</label>
                                <div class="menjalar-group">
                                    <button type="button" class="menjalar-btn" data-menjalar="ya">Ya</button>
                                    <button type="button" class="menjalar-btn" data-menjalar="tidak">Tidak</button>
                                </div>
                                <input type="hidden" name="menjalar" id="menjalar_value" required>
                                
                                <div id="menjalar_keterangan" class="menjalar-keterangan">
                                    <label class="form-label">Ke : </label>
                                    <input type="text" class="form-control" name="menjalar_keterangan" id="menjalar_keterangan_text" placeholder="Contoh: Kepala, Dada, Perut..." required>
                                </div>
                            </div>
                        </div>

                        <!-- Pain Characteristics Section -->
                        <div class="form-section">
                            <h5 class="section-title">Karakteristik Nyeri</h5>
                            
                            <!-- Kualitas Nyeri -->
                            <div class="form-group">
                                <label class="form-label">Kualitas Nyeri</label>
                                <div class="radio-group">
                                    @foreach($kualitasnyeri as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="kualitas_nyeri" value="{{ $item->id }}" id="kualitas_{{ $item->id }}" required>
                                            <label for="kualitas_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Faktor Pemberat -->
                            <div class="form-group">
                                <label class="form-label">Faktor Pemberat</label>
                                <div class="radio-group">
                                    @foreach($faktorpemberat as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="faktor_pemberat" value="{{ $item->id }}" id="pemberat_{{ $item->id }}" required>
                                            <label for="pemberat_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Faktor Peringan -->
                            <div class="form-group">
                                <label class="form-label">Faktor Peringan</label>
                                <div class="radio-group">
                                    @foreach($faktorperingan as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="faktor_peringan" value="{{ $item->id }}" id="peringan_{{ $item->id }}" required>
                                            <label for="peringan_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Efek Nyeri -->
                            <div class="form-group">
                                <label class="form-label">Efek Nyeri</label>
                                <div class="radio-group">
                                    @foreach($efeknyeri as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="efek_nyeri" value="{{ $item->id }}" id="efek_{{ $item->id }}" required>
                                            <label for="efek_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Jenis Nyeri -->
                            <div class="form-group">
                                <label class="form-label">Jenis Nyeri</label>
                                <div class="radio-group">
                                    @foreach($jenisnyeri as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="jenis_nyeri" value="{{ $item->id }}" id="jenis_{{ $item->id }}" required>
                                            <label for="jenis_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Frekuensi Nyeri -->
                            <div class="form-group">
                                <label class="form-label">Frekuensi Nyeri</label>
                                <div class="radio-group">
                                    @foreach($frekuensinyeri as $item)
                                        <div class="radio-item">
                                            <input type="radio" name="frekuensi_nyeri" value="{{ $item->id }}" id="frekuensi_{{ $item->id }}" required>
                                            <label for="frekuensi_{{ $item->id }}">{{ $item->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <!-- Pain Intervention Protocol Section -->
                        <div class="form-section" id="painInterventionSection" style="display: none;">
                            <h5 class="section-title">Protokol Intervensi Status Nyeri</h5>
                            
                            <!-- Intervensi untuk Nyeri Ringan -->
                            <div id="painLightInterventions" style="display: none;">
                                <div class="alert alert-info mb-3">
                                    <i class="ti-info-circle"></i> <strong>Protokol Derajat Nyeri Ringan (Skor 1-3)</strong>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_kaji_ulang_8jam" name="nr_kaji_ulang_8jam" value="1">
                                        <label class="form-check-label" for="nr_kaji_ulang_8jam">
                                            Kaji ulang nyeri setiap 8 Jam
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_edukasi_pasien" name="nr_edukasi_pasien" value="1">
                                        <label class="form-check-label" for="nr_edukasi_pasien">
                                            Edukasi pasien dan keluarga pasien mengenai nyeri
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_teknik_relaksasi" name="nr_teknik_relaksasi" value="1">
                                        <label class="form-check-label" for="nr_teknik_relaksasi">
                                            Ajarkan tehnik relaksasi seperti tarik nafas dalam & panjang, tehnik distraksi
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_posisi_nyaman" name="nr_posisi_nyaman" value="1">
                                        <label class="form-check-label" for="nr_posisi_nyaman">
                                            Beri posisi yang nyaman
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nr_nsaid" name="nr_nsaid" value="1">
                                        <label class="form-check-label" for="nr_nsaid">
                                            Bila perlu berikan Non Steroid Anti Inflammatory Drugs (NSAID)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Intervensi untuk Nyeri Sedang -->
                            <div id="painMediumInterventions" style="display: none;">
                                <div class="alert" style="background-color: #fff3cd; color: #856404; border-left: 4px solid #fd7e14;">
                                    <i class="ti-alert-triangle"></i> <strong>Protokol Derajat Nyeri Sedang (Skor 4-6)</strong>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_beritahu_tim_nyeri" name="ns_beritahu_tim_nyeri" value="1">
                                        <label class="form-check-label" for="ns_beritahu_tim_nyeri">
                                            Bila pasien sudah ditangani oleh tim tatalaksana nyeri, maka beritahukan ke tim tatalaksana nyeri
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_rujuk_tim_nyeri" name="ns_rujuk_tim_nyeri" value="1">
                                        <label class="form-check-label" for="ns_rujuk_tim_nyeri">
                                            Bila pasien belum pernah dirujuk ke tim tatalaksana nyeri, maka beritahukan ke DPJP untuk tatalaksana nyeri
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_kolaborasi_obat" name="ns_kolaborasi_obat" value="1">
                                        <label class="form-check-label" for="ns_kolaborasi_obat">
                                            Kolaborasi dengan dokter untuk pemberian NSAID, Paracetamol, Opioid lemah (setelah persetujuan DPJP atau tim tatalaksana nyeri)
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_teknik_relaksasi" name="ns_teknik_relaksasi" value="1">
                                        <label class="form-check-label" for="ns_teknik_relaksasi">
                                            Beritahukan pasien untuk tetap melakukan tehnik relaksasi dan tehnik distraksi yang disukai
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_posisi_nyaman" name="ns_posisi_nyaman" value="1">
                                        <label class="form-check-label" for="ns_posisi_nyaman">
                                            Pertahankan posisi yang nyaman sesuai dengan kondisi pasien
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_edukasi_pasien" name="ns_edukasi_pasien" value="1">
                                        <label class="form-check-label" for="ns_edukasi_pasien">
                                            Edukasi pasien dan keluarga pasien mengenai nyeri
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_kaji_ulang_2jam" name="ns_kaji_ulang_2jam" value="1">
                                        <label class="form-check-label" for="ns_kaji_ulang_2jam">
                                            Kaji ulang derajat nyeri setiap 2 jam, sampai nyeri teratasi (&lt;4)
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="ns_konsultasi_tim" name="ns_konsultasi_tim" value="1">
                                        <label class="form-check-label" for="ns_konsultasi_tim">
                                            Bila nyeri masih ada, konsultasikan ke Tim Tatalaksana Nyeri
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Intervensi untuk Nyeri Tinggi -->
                            <div id="painHighInterventions" style="display: none;">
                                <div class="alert alert-danger mb-3">
                                    <i class="ti-alert-triangle"></i> <strong>Protokol Derajat Nyeri Tinggi (Skor 7-10)</strong>
                                </div>
                                
                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nt_semua_langkah_sedang" name="nt_semua_langkah_sedang" value="1">
                                        <label class="form-check-label" for="nt_semua_langkah_sedang">
                                            Lakukan seluruh langkah derajat sedang
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="nt_kaji_ulang_1jam" name="nt_kaji_ulang_1jam" value="1">
                                        <label class="form-check-label" for="nt_kaji_ulang_1jam">
                                            Kaji ulang derajat nyeri setiap 1 jam, sampai nyeri menjadi nyeri sedang dikaji setiap 2 jam, dan bila nyeri telah teratasi setiap 8 jam
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-l px-2" id="simpan">
                                <i class="ti-save mr-2"></i> Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Set current date and time
            const now = new Date();
            $('#tanggal_implementasi').val(now.toISOString().split('T')[0]);
            $('#jam_implementasi').val(now.toTimeString().slice(0, 5));

            // Pain scale selection
            $('.pain-scale-option').on('click', function() {
                const scaleType = $(this).data('scale');
                
                // Update radio button
                $('input[name="pain_scale_type"]').prop('checked', false);
                $(this).find('input[type="radio"]').prop('checked', true);
                
                // Update visual selection
                $('.pain-scale-option').removeClass('selected');
                $(this).addClass('selected');
                
                // Update image
                if (scaleType === 'numerik') {
                    $('#scale_image').attr('src', "{{ asset('assets/img/asesmen/numerik.png') }}");
                } else {
                    $('#scale_image').attr('src', "{{ asset('assets/img/asesmen/asesmen.jpeg') }}");
                }
                
                // Show image
                $('#pain_scale_image').show();
                
                // Reset pain value and status
                $('#pain_value').val('');
                $('#pain_status').hide();
            });

            // Pain value input
            $('#pain_value').on('input keyup change', function() {
                updatePainStatus();
            });

            // Menjalar selection
            $('.menjalar-btn').on('click', function() {
                const choice = $(this).data('menjalar');
                
                // Update buttons
                $('.menjalar-btn').removeClass('selected');
                $(this).addClass('selected');
                
                // Update hidden input
                $('#menjalar_value').val(choice);
                
                if (choice === 'ya') {
                    $('#menjalar_keterangan').addClass('show');
                    $('#menjalar_keterangan_text').prop('required', true);
                } else {
                    $('#menjalar_keterangan').removeClass('show');
                    $('#menjalar_keterangan_text').prop('required', false).val('');
                }
            });

            // Event listener for checkbox styling
            $('.form-check-input').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).next('.form-check-label').addClass('text-primary');
                } else {
                    $(this).next('.form-check-label').removeClass('text-primary');
                }
            });

        });

        function updatePainStatus() {
            const painValue = parseInt($('#pain_value').val());
            const painScaleType = $('input[name="pain_scale_type"]:checked').val();
            
            // Hide status if no scale type is selected
            if (!painScaleType) {
                $('#pain_status').hide();
                return;
            }
            
            if (isNaN(painValue) || painValue < 0 || painValue > 10 || $('#pain_value').val() === '') {
                $('#pain_status').hide();
                return;
            }
            
            let statusText = '';
            
            if (painScaleType === 'numerik') {
                if (painValue === 0) statusText = 'Tidak Nyeri';
                else if (painValue >= 1 && painValue <= 3) statusText = 'Ringan';
                else if (painValue >= 4 && painValue <= 6) statusText = 'Sedang';
                else if (painValue >= 7 && painValue <= 9) statusText = 'Berat';
                else if (painValue === 10) statusText = 'Sangat Berat';
            } else if (painScaleType === 'wong_baker') {
                if (painValue === 0) statusText = 'Tidak Nyeri';
                else if (painValue >= 1 && painValue <= 3) statusText = 'Ringan';
                else if (painValue >= 4 && painValue <= 5) statusText = 'Mengganggu';
                else if (painValue >= 6 && painValue <= 7) statusText = 'Menyusahkan';
                else if (painValue >= 8 && painValue <= 9) statusText = 'Nyeri Berat';
                else if (painValue === 10) statusText = 'Sangat Hebat';
            }
            
            $('#pain_status_value').text(painValue);
            $('#pain_status_text').text(statusText);
            $('#pain_status').show();
        }

        function updatePainStatus() {
            const painValue = parseInt($('#pain_value').val());
            const painScaleType = $('input[name="pain_scale_type"]:checked').val();
            
            // Hide status if no scale type is selected
            if (!painScaleType) {
                $('#pain_status').hide();
                $('#painInterventionSection').hide();
                return;
            }
            
            if (isNaN(painValue) || painValue < 0 || painValue > 10 || $('#pain_value').val() === '') {
                $('#pain_status').hide();
                $('#painInterventionSection').hide();
                return;
            }
            
            let statusText = '';
            
            if (painScaleType === 'numerik') {
                if (painValue === 0) statusText = 'Tidak Nyeri';
                else if (painValue >= 1 && painValue <= 3) statusText = 'Ringan';
                else if (painValue >= 4 && painValue <= 6) statusText = 'Sedang';
                else if (painValue >= 7 && painValue <= 9) statusText = 'Berat';
                else if (painValue === 10) statusText = 'Sangat Berat';
            } else if (painScaleType === 'wong_baker') {
                if (painValue === 0) statusText = 'Tidak Nyeri';
                else if (painValue >= 1 && painValue <= 3) statusText = 'Ringan';
                else if (painValue >= 4 && painValue <= 5) statusText = 'Mengganggu';
                else if (painValue >= 6 && painValue <= 7) statusText = 'Menyusahkan';
                else if (painValue >= 8 && painValue <= 9) statusText = 'Nyeri Berat';
                else if (painValue === 10) statusText = 'Sangat Hebat';
            }
            
            $('#pain_status_value').text(painValue);
            $('#pain_status_text').text(statusText);
            $('#pain_status').show();
            
            // Show pain intervention protocol based on pain value
            showPainInterventionProtocol(painValue);
        }

        // Function untuk menampilkan protokol intervensi nyeri
        function showPainInterventionProtocol(painValue) {
            // Hide all intervention sections first
            $('#painInterventionSection').hide();
            $('#painLightInterventions').hide();
            $('#painMediumInterventions').hide();
            $('#painHighInterventions').hide();
            
            // Show appropriate intervention based on pain value
            if (painValue >= 1 && painValue <= 3) {
                // Nyeri Ringan
                $('#painInterventionSection').show();
                $('#painLightInterventions').show();
            } else if (painValue >= 4 && painValue <= 6) {
                // Nyeri Sedang
                $('#painInterventionSection').show();
                $('#painMediumInterventions').show();
            } else if (painValue >= 7 && painValue <= 10) {
                // Nyeri Tinggi
                $('#painInterventionSection').show();
                $('#painHighInterventions').show();
            }
            // Jika painValue = 0, tidak ada protokol yang ditampilkan
        }
        
    </script>
@endpush