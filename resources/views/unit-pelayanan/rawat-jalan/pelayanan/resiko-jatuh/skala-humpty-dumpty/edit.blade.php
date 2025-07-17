@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2c3e50;
        }

        .header-asesmen {
            margin-top: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #097dd6;
            text-align: center;
            margin-bottom: 2rem;
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
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .section-title {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.2rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .score-display {
            background-color: #e3f2fd;
            border: 2px solid #097dd6;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .score-number {
            font-size: 2rem;
            font-weight: bold;
            color: #097dd6;
            margin-bottom: 0.5rem;
        }

        .score-category {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .score-category.low-risk {
            color: #28a745;
        }

        .score-category.high-risk {
            color: #dc3545;
        }

        .score-description {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .radio-group {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .radio-group .form-label {
            font-weight: 600;
            color: #097dd6;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 0.5rem;
        }

        .radio-options {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .radio-item {
            display: flex;
            align-items: flex-start;
            background-color: #f8f9fa;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .radio-item:hover {
            background-color: #e3f2fd;
            border-color: #097dd6;
        }

        .radio-item.selected {
            background-color: #e3f2fd;
            border-color: #097dd6;
            border-width: 2px;
        }

        .radio-item input[type="radio"] {
            margin-right: 0.75rem;
            margin-top: 0.1rem;
            transform: scale(1.3);
            accent-color: #097dd6;
        }

        .radio-item label {
            margin-bottom: 0 !important;
            cursor: pointer;
            font-weight: 500;
            line-height: 1.4;
            flex: 1;
        }

        .radio-value {
            background-color: #097dd6;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 0.5rem;
            min-width: 30px;
            text-align: center;
        }

        .form-check {
            padding-left: 1.5rem;
        }

        .form-check-input {
            margin-left: -1.5rem;
            transform: scale(1.2);
            accent-color: #097dd6;
        }

        .form-check-label {
            font-weight: 500;
            color: #495057;
            line-height: 1.4;
            margin-bottom: 0;
            cursor: pointer;
        }

        .form-check-input:checked + .form-check-label {
            color: #097dd6;
            font-weight: 600;
        }

        .alert {
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: none;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .ml-3 {
            margin-left: 1rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }

            .form-section {
                padding: 1rem;
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
            <a href="{{ route('rawat-jalan.resiko-jatuh.humpty-dumpty.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="humptyDumptyForm" method="POST"
                action="{{ route('rawat-jalan.resiko-jatuh.humpty-dumpty.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $dataHumptyDumpty->id]) }}">
                @csrf
                @method('PUT')

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Edit Pengkajian Resiko Jatuh Skala Humpty Dumpty</h4>

                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Dasar</h5>

                            <div class="form-group">
                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                <div class="datetime-group">
                                    <div class="datetime-item">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_implementasi" id="tanggal_implementasi"
                                            value="{{ date('Y-m-d', strtotime($dataHumptyDumpty->tanggal_implementasi)) }}" required>
                                    </div>
                                    <div class="datetime-item">
                                        <label>Jam</label>
                                        <input type="time" class="form-control" name="jam_implementasi" id="jam_implementasi"
                                            value="{{ date('H:i', strtotime($dataHumptyDumpty->jam_implementasi)) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shift" class="form-label">Shift</label>
                                <select class="form-control" id="shift" name="shift" required>
                                    <option value="">Pilih Shift</option>
                                    <option value="pagi" {{ $dataHumptyDumpty->shift == 'pagi' ? 'selected' : '' }}>Pagi</option>
                                    <option value="siang" {{ $dataHumptyDumpty->shift == 'siang' ? 'selected' : '' }}>Siang</option>
                                    <option value="malam" {{ $dataHumptyDumpty->shift == 'malam' ? 'selected' : '' }}>Malam</option>
                                </select>
                            </div>
                        </div>

                        <!-- Assessment Criteria Section -->
                        <div class="form-section">
                            <h5 class="section-title">Kriteria Penilaian Humpty Dumpty</h5>

                            <div class="form-group">
                                <div class="radio-group">
                                    <label class="form-label">Usia</label>
                                    <div class="radio-options">
                                        <div class="radio-item {{ $dataHumptyDumpty->usia == 4 ? 'selected' : '' }}">
                                            <input type="radio" id="usia_1" name="usia" value="4" class="assessment-field" data-field="usia"
                                                   {{ $dataHumptyDumpty->usia == 4 ? 'checked' : '' }} required>
                                            <label for="usia_1">&lt;3 tahun</label>
                                            <span class="radio-value">4</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->usia == 3 ? 'selected' : '' }}">
                                            <input type="radio" id="usia_2" name="usia" value="3" class="assessment-field" data-field="usia"
                                                   {{ $dataHumptyDumpty->usia == 3 ? 'checked' : '' }} required>
                                            <label for="usia_2">3 sampai 7 tahun</label>
                                            <span class="radio-value">3</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->usia == 2 ? 'selected' : '' }}">
                                            <input type="radio" id="usia_3" name="usia" value="2" class="assessment-field" data-field="usia"
                                                   {{ $dataHumptyDumpty->usia == 2 ? 'checked' : '' }} required>
                                            <label for="usia_3">7 sampai 13 tahun</label>
                                            <span class="radio-value">2</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->usia == 1 ? 'selected' : '' }}">
                                            <input type="radio" id="usia_4" name="usia" value="1" class="assessment-field" data-field="usia"
                                                   {{ $dataHumptyDumpty->usia == 1 ? 'checked' : '' }} required>
                                            <label for="usia_4">&gt;13 tahun</label>
                                            <span class="radio-value">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="radio-group">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <div class="radio-options">
                                        <div class="radio-item {{ $dataHumptyDumpty->jenis_kelamin == 2 ? 'selected' : '' }}">
                                            <input type="radio" id="jk_1" name="jenis_kelamin" value="2" class="assessment-field" data-field="jenis_kelamin"
                                                   {{ $dataHumptyDumpty->jenis_kelamin == 2 ? 'checked' : '' }} required>
                                            <label for="jk_1">Laki-laki</label>
                                            <span class="radio-value">2</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->jenis_kelamin == 1 ? 'selected' : '' }}">
                                            <input type="radio" id="jk_2" name="jenis_kelamin" value="1" class="assessment-field" data-field="jenis_kelamin"
                                                   {{ $dataHumptyDumpty->jenis_kelamin == 1 ? 'checked' : '' }} required>
                                            <label for="jk_2">Perempuan</label>
                                            <span class="radio-value">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="radio-group">
                                    <label class="form-label">Diagnosis</label>
                                    <div class="radio-options">
                                        <div class="radio-item {{ $dataHumptyDumpty->diagnosis == 3 ? 'selected' : '' }}">
                                            <input type="radio" id="diagnosis_1" name="diagnosis" value="3" class="assessment-field" data-field="diagnosis"
                                                   {{ $dataHumptyDumpty->diagnosis == 3 ? 'checked' : '' }} required>
                                            <label for="diagnosis_1">Perubahan oksigenasi (diagnosis respiratorik, dehidrasi, anemia, syncope, pusing)</label>
                                            <span class="radio-value">3</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->diagnosis == 2 ? 'selected' : '' }}">
                                            <input type="radio" id="diagnosis_2" name="diagnosis" value="2" class="assessment-field" data-field="diagnosis"
                                                   {{ $dataHumptyDumpty->diagnosis == 2 ? 'checked' : '' }} required>
                                            <label for="diagnosis_2">Gangguan perilaku / psikiatri</label>
                                            <span class="radio-value">2</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->diagnosis == 1 ? 'selected' : '' }}">
                                            <input type="radio" id="diagnosis_3" name="diagnosis" value="1" class="assessment-field" data-field="diagnosis"
                                                   {{ $dataHumptyDumpty->diagnosis == 1 ? 'checked' : '' }} required>
                                            <label for="diagnosis_3">Diagnosis lainnya</label>
                                            <span class="radio-value">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="radio-group">
                                    <label class="form-label">Gangguan Kognitif</label>
                                    <div class="radio-options">
                                        <div class="radio-item {{ $dataHumptyDumpty->gangguan_kognitif == 3 ? 'selected' : '' }}">
                                            <input type="radio" id="kognitif_1" name="gangguan_kognitif" value="3" class="assessment-field" data-field="gangguan_kognitif"
                                                   {{ $dataHumptyDumpty->gangguan_kognitif == 3 ? 'checked' : '' }} required>
                                            <label for="kognitif_1">Tidak menyadari keterbatasan dirinya</label>
                                            <span class="radio-value">3</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->gangguan_kognitif == 2 ? 'selected' : '' }}">
                                            <input type="radio" id="kognitif_2" name="gangguan_kognitif" value="2" class="assessment-field" data-field="gangguan_kognitif"
                                                   {{ $dataHumptyDumpty->gangguan_kognitif == 2 ? 'checked' : '' }} required>
                                            <label for="kognitif_2">Lupa akan adanya keterbatasan</label>
                                            <span class="radio-value">2</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->gangguan_kognitif == 1 ? 'selected' : '' }}">
                                            <input type="radio" id="kognitif_3" name="gangguan_kognitif" value="1" class="assessment-field" data-field="gangguan_kognitif"
                                                   {{ $dataHumptyDumpty->gangguan_kognitif == 1 ? 'checked' : '' }} required>
                                            <label for="kognitif_3">Orientasi baik terhadap diri sendiri</label>
                                            <span class="radio-value">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="radio-group">
                                    <label class="form-label">Faktor Lingkungan</label>
                                    <div class="radio-options">
                                        <div class="radio-item {{ $dataHumptyDumpty->faktor_lingkungan == 4 ? 'selected' : '' }}">
                                            <input type="radio" id="lingkungan_1" name="faktor_lingkungan" value="4" class="assessment-field" data-field="faktor_lingkungan"
                                                   {{ $dataHumptyDumpty->faktor_lingkungan == 4 ? 'checked' : '' }} required>
                                            <label for="lingkungan_1">Riwayat jatuh / bayi diletakkan di tempat tidur dewasa</label>
                                            <span class="radio-value">4</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->faktor_lingkungan == 3 ? 'selected' : '' }}">
                                            <input type="radio" id="lingkungan_2" name="faktor_lingkungan" value="3" class="assessment-field" data-field="faktor_lingkungan"
                                                   {{ $dataHumptyDumpty->faktor_lingkungan == 3 ? 'checked' : '' }} required>
                                            <label for="lingkungan_2">Pasien menggunakan alat bantu / bayi diletakkan di tempat tidur bayi / perabot rumah</label>
                                            <span class="radio-value">3</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->faktor_lingkungan == 2 ? 'selected' : '' }}">
                                            <input type="radio" id="lingkungan_3" name="faktor_lingkungan" value="2" class="assessment-field" data-field="faktor_lingkungan"
                                                   {{ $dataHumptyDumpty->faktor_lingkungan == 2 ? 'checked' : '' }} required>
                                            <label for="lingkungan_3">Pasien diletakkan di tempat tidur</label>
                                            <span class="radio-value">2</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->faktor_lingkungan == 1 ? 'selected' : '' }}">
                                            <input type="radio" id="lingkungan_4" name="faktor_lingkungan" value="1" class="assessment-field" data-field="faktor_lingkungan"
                                                   {{ $dataHumptyDumpty->faktor_lingkungan == 1 ? 'checked' : '' }} required>
                                            <label for="lingkungan_4">Area diluar rumah</label>
                                            <span class="radio-value">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="radio-group">
                                    <label class="form-label">Pembedahan/Sedasi/Anestesi</label>
                                    <div class="radio-options">
                                        <div class="radio-item {{ $dataHumptyDumpty->pembedahan_sedasi == 3 ? 'selected' : '' }}">
                                            <input type="radio" id="bedah_1" name="pembedahan_sedasi" value="3" class="assessment-field" data-field="pembedahan_sedasi"
                                                   {{ $dataHumptyDumpty->pembedahan_sedasi == 3 ? 'checked' : '' }} required>
                                            <label for="bedah_1">Dalam 24 jam</label>
                                            <span class="radio-value">3</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->pembedahan_sedasi == 2 ? 'selected' : '' }}">
                                            <input type="radio" id="bedah_2" name="pembedahan_sedasi" value="2" class="assessment-field" data-field="pembedahan_sedasi"
                                                   {{ $dataHumptyDumpty->pembedahan_sedasi == 2 ? 'checked' : '' }} required>
                                            <label for="bedah_2">Dalam 48 jam</label>
                                            <span class="radio-value">2</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->pembedahan_sedasi == 1 ? 'selected' : '' }}">
                                            <input type="radio" id="bedah_3" name="pembedahan_sedasi" value="1" class="assessment-field" data-field="pembedahan_sedasi"
                                                   {{ $dataHumptyDumpty->pembedahan_sedasi == 1 ? 'checked' : '' }} required>
                                            <label for="bedah_3">&gt;48 jam atau tidak menjalani pembedahan/sedasi/anestesi</label>
                                            <span class="radio-value">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="radio-group">
                                    <label class="form-label">Penggunaan Medikamentosa</label>
                                    <div class="radio-options">
                                        <div class="radio-item {{ $dataHumptyDumpty->penggunaan_medikamentosa == 3 ? 'selected' : '' }}">
                                            <input type="radio" id="obat_1" name="penggunaan_medikamentosa" value="3" class="assessment-field" data-field="penggunaan_medikamentosa"
                                                   {{ $dataHumptyDumpty->penggunaan_medikamentosa == 3 ? 'checked' : '' }} required>
                                            <label for="obat_1">Penggunaan multiple: sedative, obat hipnosis, barbiturate, fenotiazi, antidepresan, pencahar, diuretik, narkose</label>
                                            <span class="radio-value">3</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->penggunaan_medikamentosa == 2 ? 'selected' : '' }}">
                                            <input type="radio" id="obat_2" name="penggunaan_medikamentosa" value="2" class="assessment-field" data-field="penggunaan_medikamentosa"
                                                   {{ $dataHumptyDumpty->penggunaan_medikamentosa == 2 ? 'checked' : '' }} required>
                                            <label for="obat_2">Penggunaan salah satu obat di atas</label>
                                            <span class="radio-value">2</span>
                                        </div>
                                        <div class="radio-item {{ $dataHumptyDumpty->penggunaan_medikamentosa == 1 ? 'selected' : '' }}">
                                            <input type="radio" id="obat_3" name="penggunaan_medikamentosa" value="1" class="assessment-field" data-field="penggunaan_medikamentosa"
                                                   {{ $dataHumptyDumpty->penggunaan_medikamentosa == 1 ? 'checked' : '' }} required>
                                            <label for="obat_3">Penggunaan medikasi lainnya/tidak ada medikasi</label>
                                            <span class="radio-value">1</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Score Display Section -->
                        <div class="score-display" id="scoreDisplay">
                            <div class="score-number" id="totalScore">{{ $dataHumptyDumpty->total_skor }}</div>
                            <div class="score-category {{ $dataHumptyDumpty->kategori_risiko == 'Risiko Rendah' ? 'low-risk' : 'high-risk' }}" id="riskCategory">{{ $dataHumptyDumpty->kategori_risiko }}</div>
                            <div class="score-description" id="riskDescription">
                                @if($dataHumptyDumpty->kategori_risiko == 'Risiko Rendah')
                                    Skor 6-11: Pasien memiliki risiko jatuh rendah
                                @else
                                    Skor ≥12: Pasien memiliki risiko jatuh tinggi
                                @endif
                            </div>
                        </div>

                        <!-- Intervention Section -->
                        <div class="form-section" id="interventionSection">
                            <h5 class="section-title">Intervensi Pencegahan Jatuh</h5>

                            <!-- Intervensi untuk Risiko Rendah -->
                            <div id="lowRiskInterventions" style="{{ $dataHumptyDumpty->kategori_risiko == 'Risiko Rendah' ? 'display: block;' : 'display: none;' }}">
                                <div class="alert alert-info mb-3">
                                    <i class="ti-info-circle"></i> <strong>Intervensi untuk Risiko Rendah</strong>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="observasi_ambulasi" name="observasi_ambulasi" value="1"
                                               {{ $dataHumptyDumpty->observasi_ambulasi ? 'checked' : '' }}>
                                        <label class="form-check-label" for="observasi_ambulasi">
                                            Tingkatkan observasi bantuan yang sesuai saat ambulasi
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Orientasikan pasien terhadap lingkungan dan rutinitas RS</label>
                                    <div class="ml-3">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="orientasi_kamar_mandi" name="orientasi_kamar_mandi" value="1"
                                                   {{ $dataHumptyDumpty->orientasi_kamar_mandi ? 'checked' : '' }}>
                                            <label class="form-check-label" for="orientasi_kamar_mandi">
                                                Tunjukkan lokasi kamar mandi
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="orientasi_bertahap" name="orientasi_bertahap" value="1"
                                                   {{ $dataHumptyDumpty->orientasi_bertahap ? 'checked' : '' }}>
                                            <label class="form-check-label" for="orientasi_bertahap">
                                                Jika pasien linglung, orientasi dilaksanakan bertahap
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="tempatkan_bel" name="tempatkan_bel" value="1"
                                                   {{ $dataHumptyDumpty->tempatkan_bel ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tempatkan_bel">
                                                Tempatkan bel ditempat yang mudah dicapai
                                            </label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" id="instruksi_bantuan" name="instruksi_bantuan" value="1"
                                                   {{ $dataHumptyDumpty->instruksi_bantuan ? 'checked' : '' }}>
                                            <label class="form-check-label" for="instruksi_bantuan">
                                                Instruksikan meminta bantuan perawat sebelum turun dari tempat tidur
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="pagar_pengaman" name="pagar_pengaman" value="1"
                                               {{ $dataHumptyDumpty->pagar_pengaman ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pagar_pengaman">
                                            Pagar pengaman tempat tidur dinaikkan, kaji agar kaki/ tangan tidak tersangkut
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="tempat_tidur_rendah" name="tempat_tidur_rendah" value="1"
                                               {{ $dataHumptyDumpty->tempat_tidur_rendah ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tempat_tidur_rendah">
                                            Tempat tidur dalam posisi rendah dan terkunci
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="edukasi_perilaku" name="edukasi_perilaku" value="1"
                                               {{ $dataHumptyDumpty->edukasi_perilaku ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edukasi_perilaku">
                                            Edukasi perilaku yang lebih aman saat jatuh atau transfer
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="monitor_berkala" name="monitor_berkala" value="1"
                                               {{ $dataHumptyDumpty->monitor_berkala ? 'checked' : '' }}>
                                        <label class="form-check-label" for="monitor_berkala">
                                            Monitor kebutuhan pasien secara berkala (minimalnya tiap 2 jam)
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="anjuran_kaus_kaki" name="anjuran_kaus_kaki" value="1"
                                               {{ $dataHumptyDumpty->anjuran_kaus_kaki ? 'checked' : '' }}>
                                        <label class="form-check-label" for="anjuran_kaus_kaki">
                                            Anjurkan pasien tidak menggunakan kaus kaki atau sepatu yang licin
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="lantai_antislip" name="lantai_antislip" value="1"
                                               {{ $dataHumptyDumpty->lantai_antislip ? 'checked' : '' }}>
                                        <label class="form-check-label" for="lantai_antislip">
                                            Lantai kamar mandi dengan karpet antislip, tidak licin
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Intervensi untuk Risiko Tinggi -->
                            <div id="highRiskInterventions" style="{{ $dataHumptyDumpty->kategori_risiko == 'Risiko Tinggi' ? 'display: block;' : 'display: none;' }}">
                                <div class="alert alert-danger mb-3">
                                    <i class="ti-alert-triangle"></i> <strong>Intervensi untuk Risiko Tinggi</strong>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="semua_intervensi_rendah" name="semua_intervensi_rendah" value="1"
                                               {{ $dataHumptyDumpty->semua_intervensi_rendah ? 'checked' : '' }}>
                                        <label class="form-check-label" for="semua_intervensi_rendah">
                                            Lakukan SEMUA intervensi jatuh resiko rendah / standar
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="gelang_kuning" name="gelang_kuning" value="1"
                                               {{ $dataHumptyDumpty->gelang_kuning ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gelang_kuning">
                                            Pakailah gelang risiko jatuh berwarna kuning
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="pasang_gambar" name="pasang_gambar" value="1"
                                               {{ $dataHumptyDumpty->pasang_gambar ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pasang_gambar">
                                            Pasang gambar risiko jatuh diatas tempat tidur pasien dan pada pintu kamar pasien
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="tanda_daftar_nama" name="tanda_daftar_nama" value="1"
                                               {{ $dataHumptyDumpty->tanda_daftar_nama ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tanda_daftar_nama">
                                            Tempatkan tanda resiko pasien jatuh pada daftar nama pasien (warna kuning)
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="pertimbangkan_obat" name="pertimbangkan_obat" value="1"
                                               {{ $dataHumptyDumpty->pertimbangkan_obat ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pertimbangkan_obat">
                                            Pertimbangkan riwayat obat-obatan dan suplemen untuk mengevaluasi pengobatan
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="alat_bantu_jalan" name="alat_bantu_jalan" value="1"
                                               {{ $dataHumptyDumpty->alat_bantu_jalan ? 'checked' : '' }}>
                                        <label class="form-check-label" for="alat_bantu_jalan">
                                            Gunakan alat bantu jalan (walker, handrail)
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="pintu_terbuka" name="pintu_terbuka" value="1"
                                               {{ $dataHumptyDumpty->pintu_terbuka ? 'checked' : '' }}>
                                        <label class="form-check-label" for="pintu_terbuka">
                                            Biarkan pintu ruangan terbuka kecuali untuk tujuan isolasi
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="jangan_tinggalkan" name="jangan_tinggalkan" value="1"
                                               {{ $dataHumptyDumpty->jangan_tinggalkan ? 'checked' : '' }}>
                                        <label class="form-check-label" for="jangan_tinggalkan">
                                            Jangan tinggalkan pasien saat di ruangan diagnostic atau tindakan
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="dekat_nurse_station" name="dekat_nurse_station" value="1"
                                               {{ $dataHumptyDumpty->dekat_nurse_station ? 'checked' : '' }}>
                                        <label class="form-check-label" for="dekat_nurse_station">
                                            Penempatan pasien dekat nurse station untuk memudahkan observasi (24-48 jam)
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="bed_posisi_rendah" name="bed_posisi_rendah" value="1"
                                               {{ $dataHumptyDumpty->bed_posisi_rendah ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bed_posisi_rendah">
                                            Posisi Bed atur ke posisi paling rendah
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="edukasi_keluarga" name="edukasi_keluarga" value="1"
                                               {{ $dataHumptyDumpty->edukasi_keluarga ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edukasi_keluarga">
                                            Edukasi pasien/ keluarga yang harus diperhatikan sesuai protokol
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg px-4" id="simpan">
                                <i class="ti-save mr-2"></i> Update Data
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
            // Set initial state
            calculateScore();

            // Function to calculate total score
            function calculateScore() {
                let totalScore = 0;
                let filledCount = 0;

                // Check each assessment field that is checked
                $('.assessment-field:checked').each(function() {
                    const value = parseInt($(this).val());
                    if (value) {
                        totalScore += value;
                        filledCount++;
                    }
                });

                // Always show score if at least one field is filled
                if (filledCount > 0) {
                    updateScoreDisplay(totalScore, filledCount);
                } else {
                    $('#scoreDisplay').hide();
                    $('#interventionSection').hide();
                }
            }

            // Function to update score display
            function updateScoreDisplay(score, filledCount) {
                $('#totalScore').text(score);
                $('#scoreDisplay').show();

                const totalFields = 7; // Total number of assessment fields

                // Hide all intervention sections first
                $('#interventionSection').show();
                $('#lowRiskInterventions').hide();
                $('#highRiskInterventions').hide();

                if (filledCount < totalFields) {
                    // If not all fields filled, show partial score
                    $('#riskCategory').text('Skor Sementara').removeClass('low-risk high-risk');
                    $('#riskDescription').text(`Skor saat ini: ${score} (${filledCount}/${totalFields} kriteria terisi)`);
                } else {
                    // All fields filled, show final assessment
                    if (score >= 6 && score <= 11) {
                        $('#riskCategory').text('Risiko Rendah').removeClass('high-risk').addClass('low-risk');
                        $('#riskDescription').text('Skor 6-11: Pasien memiliki risiko jatuh rendah');

                        // Show low risk interventions
                        $('#lowRiskInterventions').show();

                    } else if (score >= 12) {
                        $('#riskCategory').text('Risiko Tinggi').removeClass('low-risk').addClass('high-risk');
                        $('#riskDescription').text('Skor ≥12: Pasien memiliki risiko jatuh tinggi');

                        // Show high risk interventions
                        $('#highRiskInterventions').show();

                    } else {
                        $('#riskCategory').text('Skor Tidak Valid').removeClass('low-risk high-risk');
                        $('#riskDescription').text('Skor di bawah 6: Hasil tidak sesuai dengan kriteria Humpty Dumpty');
                    }
                }
            }

            // Function untuk mengecek duplikasi (exclude current record)
            function checkDuplicateDateTime() {
                const tanggal = $('#tanggal_implementasi').val();
                const shift = $('#shift').val();
                const currentId = '{{ $dataHumptyDumpty->id }}';

                if (tanggal && shift) {
                    // AJAX call untuk mengecek duplikasi
                    $.ajax({
                        url: "{{ route('rawat-jalan.resiko-jatuh.humpty-dumpty.check-duplicate', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            tanggal_implementasi: tanggal,
                            shift: shift,
                            exclude_id: currentId // Add current ID to exclude from check
                        },
                        success: function(response) {
                            if (response.exists) {
                                // Show warning message
                                showDuplicateWarning(true);
                                $('#simpan').prop('disabled', true);
                            } else {
                                // Hide warning message
                                showDuplicateWarning(false);
                                $('#simpan').prop('disabled', false);
                            }
                        },
                        error: function() {
                            // On error, allow submission
                            showDuplicateWarning(false);
                            $('#simpan').prop('disabled', false);
                        }
                    });
                } else {
                    showDuplicateWarning(false);
                    $('#simpan').prop('disabled', false);
                }
            }

            // Function untuk menampilkan/menyembunyikan warning
            function showDuplicateWarning(show) {
                if (show) {
                    if ($('#duplicate-warning').length === 0) {
                        const warningHtml = `
                            <div id="duplicate-warning" class="alert alert-warning mt-2" style="border-left: 4px solid #ffc107;">
                                <i class="ti-alert-triangle"></i>
                                <strong>Peringatan:</strong> Data dengan tanggal dan shift ini sudah ada!
                            </div>
                        `;
                        $('#shift').closest('.form-group').after(warningHtml);
                    }
                    $('#duplicate-warning').show();
                } else {
                    $('#duplicate-warning').hide();
                }
            }

            // Event listener for checkbox styling
            $('.form-check-input').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).next('.form-check-label').addClass('text-primary');
                } else {
                    $(this).next('.form-check-label').removeClass('text-primary');
                }
            });

            // Event listener for assessment fields
            $('.assessment-field').on('change', function() {
                // Add selected class to radio item
                $('.radio-item').removeClass('selected');
                $('input[type="radio"]:checked').closest('.radio-item').addClass('selected');

                // Calculate score
                calculateScore();
            });

            // Add click handler for radio items
            $('.radio-item').on('click', function() {
                $(this).find('input[type="radio"]').prop('checked', true).trigger('change');
            });

            // Form validation
            $('#humptyDumptyForm').on('submit', function(e) {
                let isValid = true;
                let errorMessage = '';

                // Check required fields
                $('input[required]:not([type="radio"]), select[required]').each(function() {
                    if (!$(this).val()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                        errorMessage += '- ' + $(this).prev('label').text() + '\n';
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                // Check radio button groups
                $('input[type="radio"][required]').each(function() {
                    const name = $(this).attr('name');
                    if (!$('input[name="' + name + '"]:checked').length) {
                        isValid = false;
                        const groupLabel = $(this).closest('.radio-group').find('.form-label').first().text();
                        if (errorMessage.indexOf('- ' + groupLabel) === -1) {
                            errorMessage += '- ' + groupLabel + '\n';
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi field berikut:\n' + errorMessage);
                    return false;
                }

                // Check if all assessment fields are filled
                let allAssessmentFilled = true;
                const radioGroups = ['usia', 'jenis_kelamin', 'diagnosis', 'gangguan_kognitif', 'faktor_lingkungan', 'pembedahan_sedasi', 'penggunaan_medikamentosa'];

                radioGroups.forEach(function(groupName) {
                    if (!$('input[name="' + groupName + '"]:checked').length) {
                        allAssessmentFilled = false;
                    }
                });

                if (!allAssessmentFilled) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua kriteria penilaian Humpty Dumpty');
                    return false;
                }

                return true;
            });

            // Remove invalid class on input
            $('input, select').on('input change', function() {
                $(this).removeClass('is-invalid');
            });

            // Event listeners untuk tanggal dan shift
            $('#tanggal_implementasi, #shift').on('change', function() {
                checkDuplicateDateTime();
            });

            // Custom styling untuk disabled button
            $('#simpan').on('propertychange change', function() {
                if ($(this).prop('disabled')) {
                    $(this).addClass('btn-secondary').removeClass('btn-primary');
                    $(this).html('<i class="ti-ban mr-2"></i> Data Sudah Ada');
                } else {
                    $(this).addClass('btn-primary').removeClass('btn-secondary');
                    $(this).html('<i class="ti-save mr-2"></i> Update Data');
                }
            });

            // Initialize checkbox styling for pre-checked items
            $('.form-check-input:checked').each(function() {
                $(this).next('.form-check-label').addClass('text-primary');
            });

        });
    </script>
@endpush
