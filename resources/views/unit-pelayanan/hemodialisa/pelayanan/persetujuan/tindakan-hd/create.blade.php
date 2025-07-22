@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        .form-label {
            font-weight: 600;
            margin-bottom: 0.3rem;
            color: #2c3e50;
            font-size: 0.85rem;
        }

        .header-asesmen {
            margin-top: 0.5rem;
            font-size: 1.3rem;
            font-weight: 600;
            color: #0c82dc;
            text-align: center;
            margin-bottom: 1.2rem;
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
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1.2rem;
        }

        .section-title {
            font-weight: 600;
            color: #004b85;
            margin-bottom: 1rem;
            font-size: 1rem;
            border-bottom: 2px solid #097dd6;
            padding-bottom: 0.3rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 0.3rem;
            display: block;
            font-size: 0.8rem;
        }

        .form-control {
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 0.5rem;
            font-size: 0.85rem;
            height: auto;
        }

        .form-control:focus {
            border-color: #097dd6;
            box-shadow: 0 0 0 0.15rem rgba(9, 125, 214, 0.25);
        }

        .datetime-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }

        .datetime-item label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.75rem;
        }

        .row {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        .row > [class*="col-"] {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .information-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            font-size: 0.85rem;
        }

        .information-table th,
        .information-table td {
            border: 1px solid #dee2e6;
            padding: 0.7rem;
            text-align: left;
            vertical-align: top;
        }

        .information-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            width: 20%;
        }

        .information-table td {
            background-color: white;
        }

        .information-table .center-column {
            width: 60%;
        }

        .information-table .checkbox-column {
            width: 20%;
            text-align: center;
        }

        .checkbox-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-check-input {
            margin: 0;
            transform: scale(1.2);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .datetime-group {
                grid-template-columns: 1fr;
            }
            
            .form-section {
                padding: 0.8rem;
            }

            .information-table {
                font-size: 0.75rem;
            }

            .information-table th,
            .information-table td {
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
            <a href="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" class="btn btn-outline-primary mb-2">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form id="consentForm" method="POST"
                action="{{ route('hemodialisa.pelayanan.persetujuan.tindakan-hd.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="header-asesmen">Form Persetujuan Tindakan Hemodialisa</h4>

                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Dasar</h5>
                            
                            <div class="form-group">
                                <label class="form-label">Tanggal dan Jam Implementasi</label>
                                <div class="datetime-group">
                                    <div class="datetime-item">
                                        <label>Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal_implementasi" id="tanggal_implementasi">
                                    </div>
                                    <div class="datetime-item">
                                        <label>Jam</label>
                                        <input type="time" class="form-control" name="jam_implementasi" id="jam_implementasi">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dpjp" class="form-label">DPJP (Dokter Penanggung Jawab Pelayanan)</label>
                                        <select class="form-control select2" style="width: 100%" id="dpjp" name="dpjp">
                                            <option value="">Pilih Dokter</option>
                                            @foreach ($dokter as $dok)
                                                <option value="{{ $dok->kd_dokter }}">{{ $dok->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pemberi_informasi" class="form-label">Nama Pemberi Informasi</label>
                                        <select class="form-control select2" style="width: 100%" id="pemberi_informasi" name="pemberi_informasi">
                                            <option value="">Pilih Dokter/Perawat</option>
                                            <optgroup label="Dokter">
                                                @foreach ($dokter as $dok)
                                                    <option value="dokter_{{ $dok->kd_dokter }}">{{ $dok->nama_lengkap }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="Perawat/Staff">
                                                @foreach ($karyawan as $staff)
                                                    <option value="karyawan_{{ $staff->kd_karyawan }}">
                                                        {{ trim(($staff->gelar_depan ?? '') . ' ' . $staff->nama . ' ' . ($staff->gelar_belakang ?? '')) }}
                                                        ({{ $staff->profesi ?? 'Perawat' }})
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tipe_penerima" class="form-label">Yang Menerima Informasi/Memberikan Persetujuan</label>
                                <select class="form-control" id="tipe_penerima" name="tipe_penerima">
                                    <option value="">Pilih...</option>
                                    <option value="pasien">Pasien</option>
                                    <option value="keluarga">Keluarga</option>
                                </select>
                            </div>

                            <!-- Section untuk Pasien -->
                            <div id="section_pasien" class="form-group" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Nama Pasien</label>
                                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" value="{{ $dataMedis->pasien->nama ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="form-label">Umur</label>
                                            <input type="text" class="form-control" id="umur_pasien" name="umur_pasien" value="{{ $dataMedis->pasien->umur ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <input type="text" class="form-control" id="jk_pasien" name="jk_pasien" value="{{ $dataMedis->pasien->jenis_kelamin == 1 ? 'Laki-laki' : ($dataMedis->pasien->jenis_kelamin == 0 ? 'Perempuan' : 'Tidak Diketahui') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">Alamat</label>
                                            <input type="text" class="form-control" id="alamat_pasien" name="alamat_pasien" value="{{ $dataMedis->pasien->alamat ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section untuk Keluarga -->
                            <div id="section_keluarga" style="display: none;">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="nama_keluarga" class="form-label">Nama Keluarga</label>
                                            <input type="text" class="form-control" id="nama_keluarga" name="nama_keluarga" placeholder="Nama lengkap keluarga">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="umur_keluarga" class="form-label">Umur</label>
                                            <input type="number" class="form-control" id="umur_keluarga" name="umur_keluarga" placeholder="Umur" min="1" max="120">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="jk_keluarga" class="form-label">Jenis Kelamin</label>
                                            <select class="form-control" id="jk_keluarga" name="jk_keluarga">
                                                <option value="">Pilih</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="status_keluarga" class="form-label">Status</label>
                                            <select class="form-control" id="status_keluarga" name="status_keluarga">
                                                <option value="">Pilih Status</option>
                                                <option value="suami">Suami</option>
                                                <option value="istri">Istri</option>
                                                <option value="ayah">Ayah</option>
                                                <option value="ibu">Ibu</option>
                                                <option value="anak">Anak</option>
                                                <option value="saudara_kandung">Saudara Kandung</option>
                                                <option value="kakek">Kakek</option>
                                                <option value="nenek">Nenek</option>
                                                <option value="cucu">Cucu</option>
                                                <option value="menantu">Menantu</option>
                                                <option value="mertua">Mertua</option>
                                                <option value="keponakan">Keponakan</option>
                                                <option value="sepupu">Sepupu</option>
                                                <option value="wali">Wali</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="alamat_keluarga" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" id="alamat_keluarga" name="alamat_keluarga" placeholder="Alamat lengkap keluarga">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Information Content Section -->
                        <div class="form-section">
                            <h5 class="section-title">Informasi Tindakan Hemodialisa</h5>
                            
                            <table class="information-table">
                                <thead>
                                    <tr>
                                        <th>Jenis Informasi</th>
                                        <th class="center-column">Isi Informasi</th>
                                        <th class="checkbox-column">Tanda ✓</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1. Diagnosis (WD dan DD)</td>
                                        <td>Penyakit Gagal Ginjal Kronik (PGK/ CKD) stadium V, Acute Kidney Injury (AKI), Acute on CKD</td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_diagnosis" id="info_diagnosis" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2. Dasar diagnosis</td>
                                        <td>Anamnesis, pemeriksaan lab, fisik dan EKG</td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_dasar_diagnosis" id="info_dasar_diagnosis" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3. Tindakan kedokteran</td>
                                        <td>HEMODIALISIS</td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_tindakan" id="info_tindakan" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4. Indikasi tindakan</td>
                                        <td>Hypercalemi, Enchephalopaty uremicum, Acidosis Metabolic, Edema paru, Overhydrasi, Azotemia</td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_indikasi" id="info_indikasi" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5. Tata cara</td>
                                        <td>Darah dikeluarkan dari tubuh dan diedarkan menuju tabung (dialyser) di luar mesin. Selama penyaringan darah terjadi difusi dan ultrafiltrasi</td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_tata_cara" id="info_tata_cara" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>6. Tujuan</td>
                                        <td>Mengeluarkan toksin uremic dan mengatur cairan akibat penurunan laju filtrasi glomerulus</td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_tujuan" id="info_tujuan" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>7. Resiko/ komplikasi</td>
                                        <td>Hypotensi, kram otot, mual, muntah, sakit kepala, kejang, perdarahan, emboli udara, gatal-gatal, penurunan kesadaran, kematian</td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_resiko" id="info_resiko" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>8. Prognosis</td>
                                        <td>Ad bonam</td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_prognosis" id="info_prognosis" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>9. Alternatif</td>
                                        <td>Transplantasi ginjal, peritoneal dialysis</td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_alternatif" id="info_alternatif" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10. Lain-lain</td>
                                        <td>
                                            <textarea class="form-control" name="info_lain_lain" id="info_lain_lain" rows="2" placeholder="Keterangan tambahan..."></textarea>
                                        </td>
                                        <td class="checkbox-column">
                                            <div class="checkbox-wrapper">
                                                <input type="checkbox" class="form-check-input" name="info_lain_lain_check" id="info_lain_lain_check" value="1">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Declaration Section -->
                        <div class="form-section">
                            <h5 class="section-title">Pernyataan Dokter</h5>
                            <p style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
                                Dengan ini menyatakan bahwa saya, dr.<span id="display_dpjp" style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; margin: 0 5px;">_________________</span> telah menerangkan hal-hal diatas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi.
                            </p>
                            
                            <p style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
                                Dengan ini menyatakan bahwa saya <span id="display_penerima_info" style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; margin: 0 5px;">_________________</span> telah menerima informasi sebagaimana di atas dan saya beri tanda/ paraf di kolom kanannya serta telah diberi kesempatan untuk bertanya, berdiskusi dan memahaminya.
                            </p>
                            
                            <p style="font-size: 0.85rem; font-style: italic; margin-bottom: 1.5rem;">
                                <strong>Cat: Apabila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat.</strong>
                            </p>
                        </div>

                        <!-- Consent/Refusal Section -->
                        <div class="form-section">
                            <h5 class="section-title">PERSETUJUAN/ PENOLAKAN TINDAKAN KEDOKTERAN</h5>
                            
                            <p style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
                                Saya yang bertanda tangan di bawah ini, nama: <span id="display_nama_penandatangan" style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; margin: 0 5px;">_________________</span>, umur: <span id="display_umur_penandatangan" style="border-bottom: 1px solid #000; min-width: 50px; display: inline-block; margin: 0 5px;">____</span> th, jenis kelamin: <span id="display_jk_penandatangan" style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; margin: 0 5px;">____</span>, alamat: <span id="display_alamat_penandatangan" style="border-bottom: 1px solid #000; min-width: 300px; display: inline-block; margin: 0 5px;">_________________________________</span>,
                            </p>
                            
                            <p style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
                                dengan ini menyatakan <strong>SETUJU/ MENOLAK</strong> dilakukan tindakan <strong>HEMODIALISIS</strong> terhadap: <span id="display_target_pasien" style="border-bottom: 1px solid #000; min-width: 150px; display: inline-block; margin: 0 5px;">saya/ suami/ istri/ anak/ ayah/ ibu*</span> saya yang bernama: <span id="display_nama_target" style="border-bottom: 1px solid #000; min-width: 200px; display: inline-block; margin: 0 5px;">_________________</span>, umur: <span id="display_umur_target" style="border-bottom: 1px solid #000; min-width: 50px; display: inline-block; margin: 0 5px;">____</span> th, jenis kelamin: <span id="display_jk_target" style="border-bottom: 1px solid #000; min-width: 100px; display: inline-block; margin: 0 5px;">____</span>
                            </p>
                            
                            <p style="font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">
                                Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan kepada saya, termasuk resiko dan komplikasi yang mungkin timbul. Saya juga menyadari bahwa ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan dan kesembuhan sangat bergantung atas izin Tuhan Yang Maha Kuasa.
                            </p>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Pilihan Keputusan</label>
                                        <select class="form-control" name="keputusan" id="keputusan">
                                            <option value="">Pilih Keputusan</option>
                                            <option value="setuju">SETUJU</option>
                                            <option value="menolak">MENOLAK</option>
                                        </select>
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

            // Set tanggal dan jam saat ini
            const now = new Date();
            const today = now.toISOString().split('T')[0];
            const currentTime = now.toTimeString().split(' ')[0].substring(0, 5);
            
            $('#tanggal_implementasi').val(today);
            $('#jam_implementasi').val(currentTime);

            // Handle tipe penerima informasi
            $('#tipe_penerima').on('change', function() {
                const tipe = $(this).val();
                
                // Hide semua section
                $('#section_pasien').hide();
                $('#section_keluarga').hide();
                
                // Show section yang dipilih
                if (tipe === 'pasien') {
                    $('#section_pasien').show();
                    // Trigger update untuk data pasien yang sudah ada
                    setTimeout(function() {
                        updatePenandatangan();
                    }, 100);
                } else if (tipe === 'keluarga') {
                    $('#section_keluarga').show();
                }
                
                // Update display fields
                updatePenandatangan();
            });

            // Update DPJP display
            $('#dpjp').on('change', function() {
                const selectedText = $('#dpjp option:selected').text();
                if (selectedText && selectedText !== 'Pilih Dokter') {
                    $('#display_dpjp').text(selectedText);
                } else {
                    $('#display_dpjp').text('_________________');
                }
            });
            
            // Update nama penandatangan dan target
            function updatePenandatangan() {
                const tipe = $('#tipe_penerima').val();
                
                if (tipe === 'pasien') {
                    const namaPasien = $('#nama_pasien').val();
                    const umurPasien = $('#umur_pasien').val();
                    const jkPasien = $('#jk_pasien').val();
                    const alamatPasien = $('#alamat_pasien').val();
                    
                    $('#display_nama_penandatangan').text(namaPasien || '_________________');
                    $('#display_umur_penandatangan').text(umurPasien || '____');
                    $('#display_jk_penandatangan').text(jkPasien || '____');
                    $('#display_alamat_penandatangan').text(alamatPasien || '_________________________________');
                    $('#display_target_pasien').text('saya');
                    $('#display_nama_target').text(namaPasien || '_________________');
                    $('#display_umur_target').text(umurPasien || '____');
                    $('#display_jk_target').text(jkPasien || '____');
                    $('#display_penerima_info').text(namaPasien || '_________________');
                    
                } else if (tipe === 'keluarga') {
                    const namaKeluarga = $('#nama_keluarga').val();
                    const umurKeluarga = $('#umur_keluarga').val();
                    const jkKeluarga = $('#jk_keluarga').val();
                    const statusKeluarga = $('#status_keluarga').val();
                    const alamatKeluarga = $('#alamat_keluarga').val();
                    const namaPasien = $('#nama_pasien').val();
                    const umurPasien = $('#umur_pasien').val();
                    const jkPasien = $('#jk_pasien').val();
                    
                    $('#display_nama_penandatangan').text(namaKeluarga || '_________________');
                    $('#display_umur_penandatangan').text(umurKeluarga || '____');
                    $('#display_jk_penandatangan').text(jkKeluarga || '____');
                    $('#display_alamat_penandatangan').text(alamatKeluarga || '_________________________________');
                    $('#display_penerima_info').text(namaKeluarga || '_________________');
                    
                    // Convert status to display text
                    let targetText = 'saya';
                    switch(statusKeluarga) {
                        case 'suami': targetText = 'suami'; break;
                        case 'istri': targetText = 'istri'; break;
                        case 'ayah': targetText = 'ayah'; break;
                        case 'ibu': targetText = 'ibu'; break;
                        case 'anak': targetText = 'anak'; break;
                        case 'saudara_kandung': targetText = 'saudara'; break;
                        case 'kakek': targetText = 'kakek'; break;
                        case 'nenek': targetText = 'nenek'; break;
                        case 'cucu': targetText = 'cucu'; break;
                        case 'menantu': targetText = 'menantu'; break;
                        case 'mertua': targetText = 'mertua'; break;
                        case 'keponakan': targetText = 'keponakan'; break;
                        case 'sepupu': targetText = 'sepupu'; break;
                        case 'wali': targetText = 'anak'; break;
                        default: targetText = statusKeluarga || 'saya';
                    }
                    
                    $('#display_target_pasien').text(targetText);
                    $('#display_nama_target').text(namaPasien || '_________________');
                    $('#display_umur_target').text(umurPasien || '____');
                    $('#display_jk_target').text(jkPasien || '____');
                } else {
                    // Reset all displays when no type selected
                    $('#display_nama_penandatangan').text('_________________');
                    $('#display_umur_penandatangan').text('____');
                    $('#display_jk_penandatangan').text('____');
                    $('#display_alamat_penandatangan').text('_________________________________');
                    $('#display_target_pasien').text('saya/ suami/ istri/ anak/ ayah/ ibu*');
                    $('#display_nama_target').text('_________________');
                    $('#display_umur_target').text('____');
                    $('#display_jk_target').text('____');
                    $('#display_penerima_info').text('_________________');
                }
            }
            
            // Bind update events untuk semua fields yang mempengaruhi display
            $('#nama_keluarga, #umur_keluarga, #jk_keluarga, #status_keluarga, #alamat_keluarga').on('input keyup change', function() {
                updatePenandatangan();
            });

            // Form validation (optional, tidak required lagi)
            $('#consentForm').on('submit', function(e) {
                // Validasi minimal satu checkbox informasi harus dicentang
                const infoCheckboxes = [
                    'info_diagnosis',
                    'info_dasar_diagnosis', 
                    'info_tindakan',
                    'info_indikasi',
                    'info_tata_cara',
                    'info_tujuan',
                    'info_resiko',
                    'info_prognosis',
                    'info_alternatif'
                ];
                
                let hasCheckedInfo = false;
                infoCheckboxes.forEach(function(checkboxName) {
                    if ($('#' + checkboxName).is(':checked')) {
                        hasCheckedInfo = true;
                    }
                });

                // Check jika ada isi di lain-lain dan checkbox lain-lain dicentang
                const lainLainText = $('#info_lain_lain').val();
                const lainLainCheck = $('#info_lain_lain_check').is(':checked');
                
                if (lainLainText && lainLainText.trim() !== '' && lainLainCheck) {
                    hasCheckedInfo = true;
                }
                
                if (!hasCheckedInfo) {
                    alert('Mohon centang minimal satu informasi yang telah dijelaskan kepada pasien/keluarga.');
                    e.preventDefault();
                    return false;
                }
            });

            // Handle checkbox lain-lain
            $('#info_lain_lain').on('input', function() {
                const hasText = $(this).val().trim() !== '';
                if (hasText) {
                    $('#info_lain_lain_check').prop('checked', true);
                } else {
                    $('#info_lain_lain_check').prop('checked', false);
                }
            });

            // Auto check lain-lain checkbox when text is entered
            $('#info_lain_lain_check').on('change', function() {
                if (!$(this).is(':checked')) {
                    $('#info_lain_lain').val('');
                }
            });

            // Initialize displays on page load
            updatePenandatangan();
        });
    </script>
@endpush