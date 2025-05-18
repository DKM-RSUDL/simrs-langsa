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
                                        <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk" value="{{ date('H:i') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesadaran (AVPU)</label>
                                    <select class="form-select" name="avpu" id="avpu" data-skor="0">
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
                                    <select class="form-select" name="saturasi_o2" id="saturasi_o2" data-skor="0">
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="≥ 95" data-skor="0">≥ 95</option>
                                        <option value="94-95" data-skor="1">94-95</option>
                                        <option value="92-93" data-skor="2">92-93</option>
                                        <option value="≤ 91" data-skor="3">≤ 91</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Dengan Bantuan O2</label>
                                    <select class="form-select" name="dengan_bantuan" id="dengan_bantuan" data-skor="0">
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="Tidak" data-skor="0">Tidak</option>
                                        <option value="Ya" data-skor="2">Ya</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tekanan Darah Sistolik (mmHg)</label>
                                    <select class="form-select" name="tekanan_darah" id="tekanan_darah" data-skor="0">
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
                                    <select class="form-select" name="nadi" id="nadi" data-skor="0">
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
                                    <select class="form-select" name="nafas" id="nafas" data-skor="0">
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
                                    <select class="form-select" name="temperatur" id="temperatur" data-skor="0">
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
