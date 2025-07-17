@extends('layouts.administrator.master')
@include('unit-pelayanan.gawat-darurat.action-gawat-darurat.ews-pasien-dewasa.include')

@section('content')
    @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('ews-pasien-dewasa.edit', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $ewsPasienDewasa->id]) }}"
                    class="btn btn-warning mr-2">
                    <i class="ti-pencil"></i> Edit
                </a>
                <a
                    href="{{ route('ews-pasien-dewasa.print-pdf', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $ewsPasienDewasa->id]) }}"
                    class="btn btn-danger ms-2" target="_blank">
                    <i class="bi bi-printer"></i> PDF
                </a>
            </div>

            <form method="POST" action="#" class="disabled-form">
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
                                        <input type="date" class="form-control" name="tanggal" disabled
                                            value="{{ $ewsPasienDewasa->tanggal ? Carbon\Carbon::parse($ewsPasienDewasa->tanggal)->format('Y-m-d') : date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk" disabled
                                            value="{{ $ewsPasienDewasa->jam_masuk ? Carbon\Carbon::parse($ewsPasienDewasa->jam_masuk)->format('H:i') : date('H:i') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesadaran (AVPU)</label>
                                    <select class="form-select" name="avpu" id="avpu" disabled>
                                        <option value="">--Pilih--</option>
                                        <option value="A" {{ $ewsPasienDewasa->avpu == 'A' ? 'selected' : '' }}>A - Alert
                                            (Sadar Baik)</option>
                                        <option value="V" {{ $ewsPasienDewasa->avpu == 'V' ? 'selected' : '' }}>V - Voice
                                            (Berespon dengan kata-kata)</option>
                                        <option value="P" {{ $ewsPasienDewasa->avpu == 'P' ? 'selected' : '' }}>P - Pain
                                            (Hanya berespon jika dirangsang nyeri)</option>
                                        <option value="U" {{ $ewsPasienDewasa->avpu == 'U' ? 'selected' : '' }}>U -
                                            Unresponsive (Pasien tidak sadar)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Saturasi O2 (%)</label>
                                    <select class="form-select" name="saturasi_o2" id="saturasi_o2" disabled>
                                        <option value="">--Pilih--</option>
                                        @php
                                            // Cek berbagai kemungkinan format untuk saturasi_o2
                                            $saturasiMatches = [
                                                '≥ 95' => ['≥ 95', '>= 95', '= 95', '>=95'],
                                                '94-95' => ['94-95'],
                                                '92-93' => ['92-93'],
                                                '≤ 91' => ['≤ 91', '<= 91', '= 91', '<=91'],
                                            ];
                                        @endphp

                                        <option value="≥ 95" {{ in_array($ewsPasienDewasa->saturasi_o2, $saturasiMatches['≥ 95']) ? 'selected' : '' }}>≥ 95</option>
                                        <option value="94-95" {{ in_array($ewsPasienDewasa->saturasi_o2, $saturasiMatches['94-95']) ? 'selected' : '' }}>94-95</option>
                                        <option value="92-93" {{ in_array($ewsPasienDewasa->saturasi_o2, $saturasiMatches['92-93']) ? 'selected' : '' }}>92-93</option>
                                        <option value="≤ 91" {{ in_array($ewsPasienDewasa->saturasi_o2, $saturasiMatches['≤ 91']) ? 'selected' : '' }}>≤ 91</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Dengan Bantuan O2</label>
                                    <select class="form-select" name="dengan_bantuan" id="dengan_bantuan" disabled>
                                        <option value="">--Pilih--</option>
                                        <option value="Tidak" {{ $ewsPasienDewasa->dengan_bantuan == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        <option value="Ya" {{ $ewsPasienDewasa->dengan_bantuan == 'Ya' ? 'selected' : '' }}>Ya
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tekanan Darah Sistolik (mmHg)</label>
                                    <select class="form-select" name="tekanan_darah" id="tekanan_darah" disabled>
                                        <option value="">--Pilih--</option>
                                        @php
                                            // Cek berbagai kemungkinan format untuk tekanan_darah
                                            $tekananMatches = [
                                                '≥ 220' => ['≥ 220', '>= 220', '= 220', '>=220'],
                                                '111-219' => ['111-219'],
                                                '101-110' => ['101-110'],
                                                '91-100' => ['91-100'],
                                                '≤ 90' => ['≤ 90', '<= 90', '= 90', '<=90'],
                                            ];
                                        @endphp

                                        <option value="≥ 220" {{ in_array($ewsPasienDewasa->tekanan_darah, $tekananMatches['≥ 220']) ? 'selected' : '' }}>≥ 220</option>
                                        <option value="111-219" {{ in_array($ewsPasienDewasa->tekanan_darah, $tekananMatches['111-219']) ? 'selected' : '' }}>111-219</option>
                                        <option value="101-110" {{ in_array($ewsPasienDewasa->tekanan_darah, $tekananMatches['101-110']) ? 'selected' : '' }}>101-110</option>
                                        <option value="91-100" {{ in_array($ewsPasienDewasa->tekanan_darah, $tekananMatches['91-100']) ? 'selected' : '' }}>91-100</option>
                                        <option value="≤ 90" {{ in_array($ewsPasienDewasa->tekanan_darah, $tekananMatches['≤ 90']) ? 'selected' : '' }}>≤ 90</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nadi (per menit)</label>
                                    <select class="form-select" name="nadi" id="nadi" disabled>
                                        <option value="">--Pilih--</option>
                                        @php
                                            // Cek berbagai kemungkinan format untuk nadi
                                            $nadiMatches = [
                                                '≥ 131' => ['≥ 131', '>= 131', '= 131', '>=131'],
                                                '111-130' => ['111-130'],
                                                '91-110' => ['91-110'],
                                                '51-90' => ['51-90'],
                                                '41-50' => ['41-50'],
                                                '≤ 40' => ['≤ 40', '<= 40', '= 40', '<=40'],
                                            ];
                                        @endphp

                                        <option value="≥ 131" {{ in_array($ewsPasienDewasa->nadi, $nadiMatches['≥ 131']) ? 'selected' : '' }}>≥ 131</option>
                                        <option value="111-130" {{ in_array($ewsPasienDewasa->nadi, $nadiMatches['111-130']) ? 'selected' : '' }}>111-130</option>
                                        <option value="91-110" {{ in_array($ewsPasienDewasa->nadi, $nadiMatches['91-110']) ? 'selected' : '' }}>91-110</option>
                                        <option value="51-90" {{ in_array($ewsPasienDewasa->nadi, $nadiMatches['51-90']) ? 'selected' : '' }}>51-90</option>
                                        <option value="41-50" {{ in_array($ewsPasienDewasa->nadi, $nadiMatches['41-50']) ? 'selected' : '' }}>41-50</option>
                                        <option value="≤ 40" {{ in_array($ewsPasienDewasa->nadi, $nadiMatches['≤ 40']) ? 'selected' : '' }}>≤ 40</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nafas (per menit)</label>
                                    <select class="form-select" name="nafas" id="nafas" disabled>
                                        <option value="">--Pilih--</option>
                                        @php
                                            // Cek berbagai kemungkinan format untuk nafas
                                            $nafasMatches = [
                                                '≥ 25' => ['≥ 25', '>= 25', '= 25', '>=25'],
                                                '21-24' => ['21-24'],
                                                '12-20' => ['12-20'],
                                                '9-11' => ['9-11'],
                                                '≤ 8' => ['≤ 8', '<= 8', '= 8', '<=8'],
                                            ];
                                        @endphp

                                        <option value="≥ 25" {{ in_array($ewsPasienDewasa->nafas, $nafasMatches['≥ 25']) ? 'selected' : '' }}>≥ 25</option>
                                        <option value="21-24" {{ in_array($ewsPasienDewasa->nafas, $nafasMatches['21-24']) ? 'selected' : '' }}>21-24</option>
                                        <option value="12-20" {{ in_array($ewsPasienDewasa->nafas, $nafasMatches['12-20']) ? 'selected' : '' }}>12-20</option>
                                        <option value="9-11" {{ in_array($ewsPasienDewasa->nafas, $nafasMatches['9-11']) ? 'selected' : '' }}>9-11</option>
                                        <option value="≤ 8" {{ in_array($ewsPasienDewasa->nafas, $nafasMatches['≤ 8']) ? 'selected' : '' }}>≤ 8</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Temperatur (°C)</label>
                                    <select class="form-select" name="temperatur" id="temperatur" disabled>
                                        <option value="">--Pilih--</option>
                                        @php
                                            // Cek berbagai kemungkinan format untuk temperatur
                                            $temperaturMatches = [
                                                '≥ 39.1' => ['≥ 39.1', '>= 39.1', '= 39.1', '>=39.1'],
                                                '38.1-39.0' => ['38.1-39.0'],
                                                '36.1-38.0' => ['36.1-38.0'],
                                                '35.1-36.0' => ['35.1-36.0'],
                                                '≤ 35' => ['≤ 35', '<= 35', '= 35', '<=35'],
                                            ];
                                        @endphp

                                        <option value="≥ 39.1" {{ in_array($ewsPasienDewasa->temperatur, $temperaturMatches['≥ 39.1']) ? 'selected' : '' }}>≥ 39.1</option>
                                        <option value="38.1-39.0" {{ in_array($ewsPasienDewasa->temperatur, $temperaturMatches['38.1-39.0']) ? 'selected' : '' }}>38.1-39.0</option>
                                        <option value="36.1-38.0" {{ in_array($ewsPasienDewasa->temperatur, $temperaturMatches['36.1-38.0']) ? 'selected' : '' }}>36.1-38.0</option>
                                        <option value="35.1-36.0" {{ in_array($ewsPasienDewasa->temperatur, $temperaturMatches['35.1-36.0']) ? 'selected' : '' }}>35.1-36.0</option>
                                        <option value="≤ 35" {{ in_array($ewsPasienDewasa->temperatur, $temperaturMatches['≤ 35']) ? 'selected' : '' }}>≤ 35</option>
                                    </select>
                                </div>

                                <!-- Total Score Section -->
                                <div class="total-score-section">
                                    <h5 class="mb-3">TOTAL SKOR</h5>
                                    <div class="total-score-value">{{ $ewsPasienDewasa->total_skor }}</div>
                                    <p class="mb-0 text-muted">Skor Early Warning System</p>
                                </div>

                                <!-- Kesimpulan Section -->
                                <div class="kesimpulan-section">
                                    <h5 class="mb-3">KESIMPULAN HASIL EWS</h5>

                                    @if($ewsPasienDewasa->hasil_ews == 'RISIKO RENDAH')
                                        <div class="kesimpulan-card kesimpulan-hijau">
                                            <strong>Total Skor 0-4:</strong> RISIKO RENDAH
                                        </div>
                                    @elseif($ewsPasienDewasa->hasil_ews == 'RISIKO SEDANG')
                                        <div class="kesimpulan-card kesimpulan-kuning">
                                            <strong>Skor 3 dalam satu parameter atau Total Skor 5-6:</strong> RISIKO SEDANG
                                        </div>
                                    @elseif($ewsPasienDewasa->hasil_ews == 'RISIKO TINGGI')
                                        <div class="kesimpulan-card kesimpulan-merah">
                                            <strong>Total Skor ≥ 7:</strong> RISIKO TINGGI
                                        </div>
                                    @endif
                                </div>

                                <!-- Hidden inputs untuk backend -->
                                <input type="hidden" id="ews-total-score" name="total_skor"
                                    value="{{ $ewsPasienDewasa->total_skor }}">
                                <input type="hidden" id="ews-hasil" name="hasil_ews"
                                    value="{{ $ewsPasienDewasa->hasil_ews }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <p class="fw-bold text-center">INTERVENSI PENIALAIAN EARLY WARNING SYSTEM</p>
            <div class="mt-2">
                <!-- Risk Assessment Table -->
                <div class="mb-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr class="bg-success text-white">
                                    <td class="text-start fw-bold">Total Skor 0-4</td>
                                    <td class="text-start fw-bold">RISIKO RENDAH</td>
                                </tr>
                                <tr class="bg-warning text-dark">
                                    <td class="text-start fw-bold">Skor 3 dalam satu parameter atau Total Skor : 5 - 6</td>
                                    <td class="text-start fw-bold">RISIKO SEDANG</td>
                                </tr>
                                <tr class="bg-danger text-white">
                                    <td class="text-start fw-bold">Total Skor ≥ 7</td>
                                    <td class="text-start fw-bold">RISIKO TINGGI</td>
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
