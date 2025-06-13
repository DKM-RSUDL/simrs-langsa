@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.include')
    @include('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form id="edukasiForm" method="POST"
                action="{{ route('rawat-inap.ews-pasien-dewasa.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen text-center font-weight-bold mb-4">Early Warning System (EWS)
                                    Pasien Dewasa
                                </h4>
                            </div>

                            <div class="section-separator" id="data-masuk">
                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}"
                                            required>
                                        <input type="time" class="form-control" name="jam_masuk" value="{{ date('H:i') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesadaran (AVPU)</label>
                                    <select class="form-select" name="avpu" id="avpu" data-skor="0" required>
                                        <option value="A" selected disabled>--Pilih--</option>
                                        <option value="A" data-skor="0">A - Alert (Sadar Baik)</option>
                                        <option value="V" data-skor="3">V - Voice (Berespon dengan kata-kata)</option>
                                        <option value="P" data-skor="3">P - Pain (Hanya berespon jika dirangsang nyeri)
                                        </option>
                                        <option value="U" data-skor="3">U - Unresponsive (Pasien tidak sadar)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Saturasi O2 (%)</label>
                                    <select class="form-select" name="saturasi_o2" id="saturasi_o2" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="≥ 95" data-skor="0">≥ 95</option>
                                        <option value="94-95" data-skor="1">94-95</option>
                                        <option value="92-93" data-skor="2">92-93</option>
                                        <option value="≤ 91" data-skor="3">≤ 91</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Dengan Bantuan O2</label>
                                    <select class="form-select" name="dengan_bantuan" id="dengan_bantuan" data-skor="0"
                                        required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="Tidak" data-skor="0">Tidak</option>
                                        <option value="Ya" data-skor="2">Ya</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tekanan Darah Sistolik (mmHg)</label>
                                    <select class="form-select" name="tekanan_darah" id="tekanan_darah" data-skor="0"
                                        required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="≥ 220" data-skor="3">≥ 220</option>
                                        <option value="111-219" data-skor="0">111-219</option>
                                        <option value="101-110" data-skor="1">101-110</option>
                                        <option value="91-100" data-skor="2">91-100</option>
                                        <option value="≤ 90" data-skor="3">≤ 90</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nadi (per menit)</label>
                                    <select class="form-select" name="nadi" id="nadi" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="≥ 131" data-skor="3">≥ 131</option>
                                        <option value="111-130" data-skor="2">111-130</option>
                                        <option value="91-110" data-skor="1">91-110</option>
                                        <option value="51-90" data-skor="0">51-90</option>
                                        <option value="41-50" data-skor="1">41-50</option>
                                        <option value="≤ 40" data-skor="3">≤ 40</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nafas (per menit)</label>
                                    <select class="form-select" name="nafas" id="nafas" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="≥ 25" data-skor="3">≥ 25</option>
                                        <option value="21-24" data-skor="2">21-24</option>
                                        <option value="12-20" data-skor="0">12-20</option>
                                        <option value="9-11" data-skor="1">9-11</option>
                                        <option value="≤ 8" data-skor="3">≤ 8</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Temperatur (°C)</label>
                                    <select class="form-select" name="temperatur" id="temperatur" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="≥ 39.1" data-skor="2">≥ 39.1</option>
                                        <option value="38.1-39.0" data-skor="1">38.1-39.0</option>
                                        <option value="36.1-38.0" data-skor="0">36.1-38.0</option>
                                        <option value="35.1-36.0" data-skor="1">35.1-36.0</option>
                                        <option value="≤ 35" data-skor="3">≤ 35</option>
                                    </select>
                                </div>

                                <div class="total-score-section">
                                    <h5 class="mb-3">TOTAL SKOR</h5>
                                    <div class="total-score-value" id="total-skor">0</div>
                                    <p class="mb-0 text-muted">Skor Early Warning System</p>
                                </div>

                                <!-- Kesimpulan Section -->
                                <div class="kesimpulan-section">
                                    <h5 class="mb-3">KESIMPULAN HASIL EWS</h5>

                                    <!-- Skor 0-4: Risiko Rendah -->
                                    <div id="kesimpulan-hijau" class="kesimpulan-card kesimpulan-hijau d-none">
                                        <strong>Total Skor 0-4:</strong> RISIKO RENDAH
                                    </div>

                                    <!-- Skor 5-6: Risiko Sedang -->
                                    <div id="kesimpulan-kuning" class="kesimpulan-card kesimpulan-kuning d-none">
                                        <strong>Skor 3 dalam satu parameter atau Total Skor 5-6:</strong> RISIKO SEDANG
                                    </div>

                                    <!-- Skor ≥7: Risiko Tinggi -->
                                    <div id="kesimpulan-merah" class="kesimpulan-card kesimpulan-merah d-none">
                                        <strong>Total Skor ≥ 7:</strong> RISIKO TINGGI
                                    </div>
                                </div>

                                <!-- Hidden inputs untuk backend -->
                                <input type="hidden" id="ews-total-score" name="total_skor" value="0">
                                <input type="hidden" id="ews-hasil" name="hasil_ews" value="">
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary" id="simpan">
                                    <i class="ti-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <p class="fw-bold text-center">INTERVENSI PENIALAIAN EARLY WARNING SYSTEM</p>
            <div class="container mt-2">
                <!-- Risk Assessment Table -->
                <div class="mb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-success text-white">
                                    <td class="text-center fw-bold">Total Skor 0-4</td>
                                    <td class="text-center fw-bold">RISIKO RENDAH</td>
                                </tr>
                                <tr class="bg-warning text-dark">
                                    <td class="text-center fw-bold">Skor 3 dalam satu parameter atau Total Skor : 5 - 6</td>
                                    <td class="text-center fw-bold">RISIKO SEDANG</td>
                                </tr>
                                <tr class="bg-danger text-white">
                                    <td class="text-center fw-bold">Total Skor ≥ 7</td>
                                    <td class="text-center fw-bold">RISIKO TINGGI</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Warning Levels Description -->
                    <div class="mt-3">
                        <p class="mb-1 fw-bold">Keterangan Tingkat kesadaran AVPU :</p>
                        <p class="mb-1"><span class="fw-bold">A : ALERT</span> &nbsp;&nbsp;&nbsp; Pasien sadar penuh</p>
                        <p class="mb-1"><span class="fw-bold">V : VOICE</span> &nbsp;&nbsp;&nbsp; Pasien membuat beberapa
                            jenis respon saat dipanggil berbicara, terdiri dari 3 komponen yang mempengaruhi yaitu mata,
                            suara atau motorik</p>
                        <p class="mb-1"><span class="fw-bold">P : PAIN</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pasien akan
                            berespon jika dirangsang sakit</p>
                        <p class="mb-1"><span class="fw-bold">U : UNRESPONSIVE</span> &nbsp;&nbsp;&nbsp; Tidak berespon,
                            jika pasien tidak memberikan respon terhadap suara, nyeri dsb</p>
                    </div>
                </div>

                <!-- Intervention Table -->
                <div class="mt-0">                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center fw-bold" style="width: 5%;">NO</th>
                                    <th class="text-center fw-bold" style="width: 15%;">NILAI EWS</th>
                                    <th class="text-center fw-bold" style="width: 20%;">FREKUENSI MONITORING</th>
                                    <th class="text-center fw-bold" style="width: 60%;">ASUHAN YANG DIBERIKAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">0</td>
                                    <td class="text-center">Minimal setiap 12 jam sekali</td>
                                    <td>Lanjutkan observasi/ monitoring secara rutin/per shift</td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-center">TOTAL SCORE<br>1 - 4</td>
                                    <td class="text-center">Minimal Setiap<br>4 - 6 Jam Sekali</td>
                                    <td>
                                        <strong>1.</strong> Perawat pelaksana menginformasikan kepada ketua tim / penanggung
                                        jawab jaga ruangan tentang siapa yang melaksanakan assesment selanjutnya.<br>
                                        <strong>2.</strong> Ketua Tim / penanggunggjawab harus membuat keputusan:<br>
                                        &nbsp;&nbsp;&nbsp; a. Meningkatkan frekuensi observasi / monitoring<br>
                                        &nbsp;&nbsp;&nbsp; b. Perawatan asuhan yang dibutuhkan oleh pasien
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td class="text-center">TOTAL SCORE<br>5 DAN 6 ATAU 3<br>DALAM 1 (SATU)<br>PARAMETER
                                    </td>
                                    <td class="text-center">Peningkatan<br>Frekuensi Observasi / Monitoring<br>Setidaknya
                                        Setiap<br>1 Jam Sekali</td>
                                    <td>
                                        <strong>1.</strong> Ketua Tim (Perawat) segera memberikan informasi tentang kondisi
                                        pasien kepada dokter jaga atau DPJP<br>
                                        <strong>2.</strong> Dokter jaga atau DPJP melakukan assesment sesuai kompetensinya
                                        dan menentukan kondisi pasien apakah dalam penyakit akut,<br>
                                        <strong>3.</strong> Siapkan fasilitas monitoring yang lebih canggih.
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td class="text-center">TOTAL SCORE 7<br>ATAU LEBIH</td>
                                    <td class="text-center">Lanjutkan Observasi / Monitoring<br>Tanda-Tanda Vital</td>
                                    <td>
                                        <strong>1.</strong> Ketua Tim (Perawat) segera memberikan informasi tentang kondisi
                                        pasien kepada dokter jaga atau DPJP<br>
                                        <strong>2.</strong> Rencanakan transfer pasien ke ruang intensive<br>
                                        <strong>3.</strong> Aktivasi code blue bila pasien henti jantung/henti nafas
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // Calculate EWS Score automatically
        function calculateEWSScore() {
            let totalScore = 0;

            // Get all select elements
            const parameters = ['avpu', 'saturasi_o2', 'dengan_bantuan', 'tekanan_darah', 'nafas', 'nadi', 'temperatur'];

            parameters.forEach(function (param) {
                const select = document.getElementById(param);
                if (select && select.selectedIndex > 0) {
                    // Get score from data attribute
                    const selectedOption = select.options[select.selectedIndex];
                    const score = parseInt(selectedOption.getAttribute('data-skor') || 0);
                    totalScore += score;
                }
            });

            // Update total score display
            document.getElementById('total-skor').textContent = totalScore;
            document.getElementById('ews-total-score').value = totalScore;

            // Show appropriate conclusion based on score
            showEWSResult(totalScore);
        }

        function showEWSResult(score) {
            // Hide all conclusions first
            document.getElementById('kesimpulan-hijau').classList.add('d-none');
            document.getElementById('kesimpulan-kuning').classList.add('d-none');
            document.getElementById('kesimpulan-merah').classList.add('d-none');

            let result = '';

            // Show conclusion based on score range (sesuai gambar)
            if (score >= 0 && score <= 4) {
                document.getElementById('kesimpulan-hijau').classList.remove('d-none');
                result = 'RISIKO RENDAH';
            } else if (score >= 5 && score <= 6) {
                document.getElementById('kesimpulan-kuning').classList.remove('d-none');
                result = 'RISIKO SEDANG';
            } else if (score >= 7) {
                document.getElementById('kesimpulan-merah').classList.remove('d-none');
                result = 'RISIKO TINGGI';
            }

            // Check for single parameter score of 3 (also medium risk)
            const parameters = ['avpu', 'saturasi_o2', 'dengan_bantuan', 'tekanan_darah', 'nafas', 'nadi', 'temperatur'];
            let hasThreeInSingleParam = false;

            parameters.forEach(function (param) {
                const select = document.getElementById(param);
                if (select && select.selectedIndex > 0) {
                    const selectedOption = select.options[select.selectedIndex];
                    const score = parseInt(selectedOption.getAttribute('data-skor') || 0);
                    if (score === 3) {
                        hasThreeInSingleParam = true;
                    }
                }
            });

            // Override to medium risk if single parameter = 3 and total score < 7
            if (hasThreeInSingleParam && score < 7) {
                // Hide all first
                document.getElementById('kesimpulan-hijau').classList.add('d-none');
                document.getElementById('kesimpulan-kuning').classList.add('d-none');
                document.getElementById('kesimpulan-merah').classList.add('d-none');

                // Show yellow (medium risk)
                document.getElementById('kesimpulan-kuning').classList.remove('d-none');
                result = 'RISIKO SEDANG';
            }

            document.getElementById('ews-hasil').value = result;
        }

        // Add event listeners to all select elements
        document.addEventListener('DOMContentLoaded', function () {
            const parameters = ['avpu', 'saturasi_o2', 'dengan_bantuan', 'tekanan_darah', 'nafas', 'nadi', 'temperatur'];

            parameters.forEach(function (param) {
                const select = document.getElementById(param);
                if (select) {
                    select.addEventListener('change', calculateEWSScore);
                }
            });

            // Initial calculation
            calculateEWSScore();
        });
    </script>
@endpush