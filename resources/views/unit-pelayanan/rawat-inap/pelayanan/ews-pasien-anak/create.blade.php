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
                action="{{ route('rawat-inap.ews-pasien-anak.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100 shadow-sm">
                        <div class="card-body">
                            <div class="px-3">
                                <h4 class="header-asesmen text-center font-weight-bold mb-4">Early Warning System (EWS) Pasien Anak</h4>
                            </div>

                            <div class="section-separator" id="data-masuk">
                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk" value="{{ date('H:i') }}">
                                    </div>
                                </div>

                                <div class="form-group section-separator">
                                    <label style="min-width: 200px;">KEADAAN UMUM</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keadaan_umum" id="ku0" value="KU0" data-skor="0" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="ku0">Interaksi biasa.</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keadaan_umum" id="ku1" value="KU1" data-skor="1" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="ku1">Somnolen</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keadaan_umum" id="ku2" value="KU2" data-skor="2" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="ku2">Iritabel, tidak dapat ditenangkan</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keadaan_umum" id="ku3" value="KU3" data-skor="3" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="ku3">Letargi, gelisah, penurunan respon terhadap nyeri.</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group section-separator">
                                    <label style="min-width: 200px;">KARDIOVASKULAR</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kardiovaskular" id="kv0" value="KV0" data-skor="0" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="kv0">Tidak sianosis ATAU pengisian kapiler < 2 detik.</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kardiovaskular" id="kv1" value="KV1" data-skor="1" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="kv1">Tampak pucat ATAU pengisian kapiler 2 detik.</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kardiovaskular" id="kv2" value="KV2" data-skor="2" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="kv2">Tampak sianotik ATAU pengisian kapiler >2 detik ATAU Takikardi >20 × di atas parameter HR sesuai usia/menit.</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kardiovaskular" id="kv3" value="KV3" data-skor="3" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="kv3">Sianotik dan motlet, ATAU pengisian kapiler >5 detik, ATAU Takikardi >30x di atas parameter HR sesuai usia/menit ATAU Bradikardia sesuai usia.</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group section-separator">
                                    <label style="min-width: 200px;">RESPIRASI</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="respirasi" id="rs0" value="RS0" data-skor="0" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="rs0">Respirasi dalam parameter normal, tidak terdapat retraksi</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="respirasi" id="rs1" value="RS1" data-skor="1" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="rs1">Takipnea >10x di atas parameter RR sesuai usia/menit, ATAU Menggunakan otot alat bantu napas, ATAU menggunakan FiO2 lebih dari 30%.</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="respirasi" id="rs2" value="RS2" data-skor="2" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="rs2">Takipnea >20x di atas parameter RR sesuai usia/menit, ATAU Ada retraksi, ATAU menggunakan FiO2 lebih dari 40%.</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="respirasi" id="rs3" value="RS3" data-skor="3" onchange="calculateEWSScore()">
                                            <label class="form-check-label" for="rs3">Laju respirasi >30x di atas parameter normal ATAU Bradipneu di mana frekuensi nafas lebih rendah 5 atau lebih, sesuai usia, disertai dengan retraksi berat ATAU menggunakan FiO2 lebih dari 50% (NRM 8 liter/menit)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="total-score-section section-separator">
                                    <h5 class="mb-3">TOTAL SKOR</h5>
                                    <div class="total-score-value" id="total-skor">0</div>
                                    <p class="mb-0 text-muted">Skor Early Warning System</p>
                                </div>

                                <!-- Kesimpulan Section -->
                                <div class="kesimpulan-section">
                                    <h5 class="mb-3">KESIMPULAN HASIL EWS</h5>
                                    <div id="kesimpulan-hijau" class="kesimpulan-card kesimpulan-hijau d-none">
                                        <strong>Total Skor 0-2:</strong> PASIEN STABIL
                                    </div>
                                    <div id="kesimpulan-kuning" class="kesimpulan-card kesimpulan-kuning d-none">
                                        <strong>Total Skor 3-4 atau Skor 3 pada Satu Parameter:</strong> PENURUNAN KONDISI
                                    </div>
                                    <div id="kesimpulan-merah" class="kesimpulan-card kesimpulan-merah d-none">
                                        <strong>Total Skor ≥ 5:</strong> PERUBAHAN SIGNIFIKAN
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
        function calculateEWSScore() {
            let totalScore = 0;
            const parameters = ['keadaan_umum', 'kardiovaskular', 'respirasi'];

            parameters.forEach(function (param) {
                const checkedRadio = document.querySelector(`input[name="${param}"]:checked`);
                if (checkedRadio) {
                    const score = parseInt(checkedRadio.getAttribute('data-skor') || 0);
                    totalScore += score;
                }
            });

            document.getElementById('total-skor').textContent = totalScore;
            document.getElementById('ews-total-score').value = totalScore;
            showEWSResult(totalScore);
        }

        function showEWSResult(score) {
            document.getElementById('kesimpulan-hijau').classList.add('d-none');
            document.getElementById('kesimpulan-kuning').classList.add('d-none');
            document.getElementById('kesimpulan-merah').classList.add('d-none');

            let result = '';

            if (score >= 0 && score <= 2) {
                document.getElementById('kesimpulan-hijau').classList.remove('d-none');
                result = 'PASIEN STABIL';
            } else if (score >= 3 && score <= 4) {
                document.getElementById('kesimpulan-kuning').classList.remove('d-none');
                result = 'PENURUNAN KONDISI';
            } else if (score >= 5) {
                document.getElementById('kesimpulan-merah').classList.remove('d-none');
                result = 'PERUBAHAN SIGNIFIKAN';
            }

            const parameters = ['keadaan_umum', 'kardiovaskular', 'respirasi'];
            let hasThreeInSingleParam = false;

            parameters.forEach(function (param) {
                const checkedRadio = document.querySelector(`input[name="${param}"]:checked`);
                if (checkedRadio) {
                    const score = parseInt(checkedRadio.getAttribute('data-skor') || 0);
                    if (score === 3) {
                        hasThreeInSingleParam = true;
                    }
                }
            });

            if (hasThreeInSingleParam && score < 5) {
                document.getElementById('kesimpulan-hijau').classList.add('d-none');
                document.getElementById('kesimpulan-kuning').classList.remove('d-none');
                document.getElementById('kesimpulan-merah').classList.add('d-none');
                result = 'PENURUNAN KONDISI';
            }

            document.getElementById('ews-hasil').value = result;
        }

        document.addEventListener('DOMContentLoaded', function () {
            calculateEWSScore();
        });
    </script>
@endpush
