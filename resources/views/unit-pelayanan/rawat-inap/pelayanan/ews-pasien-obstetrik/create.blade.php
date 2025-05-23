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
                action="{{ route('rawat-inap.ews-pasien-obstetrik.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen text-center font-weight-bold mb-4">Early Warning System (EWS)
                                    Pasien Obstetrik
                                </h4>
                            </div>

                            <div class="section-separator" id="data-masuk">
                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required>
                                        <input type="time" class="form-control" name="jam_masuk" value="{{ date('H:i') }}" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Respirasi (per menit)</label>
                                    <select class="form-select" name="respirasi" id="respirasi" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value=">25" data-skor="3">>25</option>
                                        <option value="21-25" data-skor="2">21-25</option>
                                        <option value="12-20" data-skor="0">12-20</option>
                                        <option value="<12" data-skor="3"><12</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Saturasi O2</label>
                                    <select class="form-select" name="saturasi_o2" id="saturasi_o2" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="≥ 95" data-skor="0">≥ 95</option>
                                        <option value="92-95" data-skor="1">92-95</option>
                                        <option value="≤ 91" data-skor="3">≤ 91</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Suplemen O2</label>
                                    <select class="form-select" name="suplemen_o2" id="suplemen_o2" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="Tidak" data-skor="0">Tidak</option>
                                        <option value="Ya" data-skor="2">Ya</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tekanan Darah Sistolik (mmHg)</label>
                                    <select class="form-select" name="tekanan_darah" id="tekanan_darah" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="> 160" data-skor="3">> 160</option>
                                        <option value="151-160" data-skor="2">151-160</option>
                                        <option value="141-150" data-skor="1">141-150</option>
                                        <option value="91-140" data-skor="0">91-140</option>
                                        <option value="< 90" data-skor="3">< 90</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Detak Jantung (per menit)</label>
                                    <select class="form-select" name="detak_jantung" id="detak_jantung" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="> 120" data-skor="3">> 120</option>
                                        <option value="111-120" data-skor="2">111-120</option>
                                        <option value="101-110" data-skor="1">101-110</option>
                                        <option value="61-100" data-skor="0">61-100</option>
                                        <option value="50-60" data-skor="2">50-60</option>
                                        <option value="≤ 50" data-skor="3">≤ 50</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesadaran</label>
                                    <select class="form-select" name="kesadaran" id="kesadaran" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="Sadar" data-skor="0">Sadar</option>
                                        <option value="Nyeri/Verbal" data-skor="2">Nyeri/Verbal</option>
                                        <option value="Unresponsive" data-skor="code_blue">Unresponsive (Code Blue)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Temperatur (°C)</label>
                                    <select class="form-select" name="temperatur" id="temperatur" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="≤ 36" data-skor="2">≤ 36</option>
                                        <option value="36.1-37.2" data-skor="0">36.1-37.2</option>
                                        <option value="37.3-37.7" data-skor="1">37.3-37.7</option>
                                        <option value="> 37.7" data-skor="2">> 37.7</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Discharge/Lochia</label>
                                    <select class="form-select" name="discharge" id="discharge" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="Normal" data-skor="0">Normal</option>
                                        <option value="Abnormal" data-skor="2">Abnormal</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Proteinuria/hari</label>
                                    <select class="form-select" name="proteinuria" id="proteinuria" data-skor="0" required>
                                        <option value="" selected disabled>--Pilih--</option>
                                        <option value="Negatif" data-skor="0">Negatif</option>
                                        <option value="≥ 1" data-skor="1">≥ 1</option>
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

                                    <!-- Skor 1-4: Risiko Rendah -->
                                    <div id="kesimpulan-hijau" class="kesimpulan-card kesimpulan-hijau d-none">
                                        <div class="alert alert-success">
                                            <strong>Skor 1-4:</strong> Assessment segera oleh perawat senior, respon segera (maks 5 menit),
                                            eskalasi perawatan dan frekuensi monitoring per 4-6 jam. Jika diperlukan assessment oleh dokter jaga bangsal.
                                        </div>
                                    </div>

                                    <!-- Skor 5-6: Risiko Sedang -->
                                    <div id="kesimpulan-kuning" class="kesimpulan-card kesimpulan-kuning d-none">
                                        <div class="alert alert-warning">
                                            <strong>Skor 5-6:</strong> Assessment segera oleh dokter jaga (respon segera, maks 5 menit),
                                            konsultasi DPJP dan spesialis terkait, eskalasi perawatan dan monitoring tiap jam,
                                            pertimbangkan perawatan dengan monitoring yang sesuai (HCU).
                                        </div>
                                    </div>

                                    <!-- Skor ≥7 atau Code Blue: Risiko Tinggi -->
                                    <div id="kesimpulan-merah" class="kesimpulan-card kesimpulan-merah d-none">
                                        <div class="alert alert-danger">
                                            <strong>Skor ≥ 7 atau 1 Parameter Kriteria Blue (Risiko Tinggi):</strong>
                                            Resusitasi dan monitoring secara kontinyu oleh dokter jaga dan perawat senior,
                                            Aktivasi code blue kegawatan medis, respon Tim Medis Emergency (TME)/tim Code Blue segera (maksimal 10 menit),
                                            Informasikan dan konsultasikan ke DPJP.
                                        </div>
                                    </div>

                                    <!-- Code Blue Henti Jantung -->
                                    <div id="kesimpulan-code-blue" class="kesimpulan-card kesimpulan-code-blue d-none">
                                        <div class="alert alert-primary">
                                            <strong>HENTI NAFAS/JANTUNG:</strong>
                                            Lakukan RJP oleh petugas/tim primer, aktivasi code blue henti jantung,
                                            respon Tim Medis Emergency (TME)/tim Code Blue segera (maksimal 5 menit),
                                            informasikan dan konsultasikan dengan DPJP.
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden inputs untuk backend -->
                                <input type="hidden" id="ews-total-score" name="total_skor" value="0">
                                <input type="hidden" id="ews-hasil" name="hasil_ews" value="">
                                <input type="hidden" id="ews-code-blue" name="code_blue" value="0">
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
            let hasCodeBlue = false;

            // Get all select elements dengan nama yang sesuai
            const parameters = [
                'respirasi',
                'saturasi_o2',
                'suplemen_o2',
                'tekanan_darah',
                'detak_jantung',
                'kesadaran',
                'temperatur',
                'discharge',
                'proteinuria'
            ];

            parameters.forEach(function (param) {
                const select = document.getElementById(param);
                if (select && select.selectedIndex > 0) {
                    // Get score from data attribute
                    const selectedOption = select.options[select.selectedIndex];
                    const skorAttr = selectedOption.getAttribute('data-skor');

                    if (skorAttr === 'code_blue') {
                        hasCodeBlue = true;
                    } else {
                        const score = parseInt(skorAttr || 0);
                        totalScore += score;
                    }
                }
            });

            // Update total score display
            document.getElementById('total-skor').textContent = totalScore;
            document.getElementById('ews-total-score').value = totalScore;
            document.getElementById('ews-code-blue').value = hasCodeBlue ? 1 : 0;

            // Show appropriate conclusion based on score
            showEWSResult(totalScore, hasCodeBlue);
        }

        function showEWSResult(score, hasCodeBlue) {
            // Hide all conclusions first
            document.getElementById('kesimpulan-hijau').classList.add('d-none');
            document.getElementById('kesimpulan-kuning').classList.add('d-none');
            document.getElementById('kesimpulan-merah').classList.add('d-none');
            document.getElementById('kesimpulan-code-blue').classList.add('d-none');

            let result = '';

            // Prioritas tertinggi: Code Blue (Unresponsive)
            if (hasCodeBlue) {
                document.getElementById('kesimpulan-code-blue').classList.remove('d-none');
                result = 'CODE BLUE - HENTI NAFAS/JANTUNG';
            }
            // Skor 7 atau lebih: Risiko Tinggi
            else if (score >= 7) {
                document.getElementById('kesimpulan-merah').classList.remove('d-none');
                result = 'RISIKO TINGGI';
            }
            // Skor 5-6: Risiko Sedang
            else if (score >= 5 && score <= 6) {
                document.getElementById('kesimpulan-kuning').classList.remove('d-none');
                result = 'RISIKO SEDANG';
            }
            // Skor 1-4: Risiko Rendah
            else if (score >= 1 && score <= 4) {
                document.getElementById('kesimpulan-hijau').classList.remove('d-none');
                result = 'RISIKO RENDAH';
            }

            // Set hasil ke hidden input
            document.getElementById('ews-hasil').value = result;
        }

        // Add event listeners to all select elements
        document.addEventListener('DOMContentLoaded', function () {
            const parameters = [
                'respirasi',
                'saturasi_o2',
                'suplemen_o2',
                'tekanan_darah',
                'detak_jantung',
                'kesadaran',
                'temperatur',
                'discharge',
                'proteinuria'
            ];

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
