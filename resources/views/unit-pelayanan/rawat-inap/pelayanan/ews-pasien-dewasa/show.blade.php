@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.ews-pasien-dewasa.include')

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
                <a href="{{ route('rawat-inap.ews-pasien-dewasa.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $ewsPasienDewasa->id]) }}"
                    class="btn btn-warning mr-2">
                    <i class="ti-pencil"></i> Edit
                </a>
                {{-- <a
                    href="{{ route('rawat-inap.ews-pasien-dewasa.exportPdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $ewsPasienDewasa->id]) }}"
                    class="btn btn-danger" target="_blank">
                    <i class="ti-file"></i> Export PDF
                </a> --}}
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
                                            value="{{ $ewsPasienDewasa->jam_masuk ?? date('H:i') }}">
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
                                        <option value="≥ 95" {{ $ewsPasienDewasa->saturasi_o2 == '≥ 95' ? 'selected' : '' }}>≥
                                            95</option>
                                        <option value="94-95" {{ $ewsPasienDewasa->saturasi_o2 == '94-95' ? 'selected' : '' }}>94-95</option>
                                        <option value="92-93" {{ $ewsPasienDewasa->saturasi_o2 == '92-93' ? 'selected' : '' }}>92-93</option>
                                        <option value="≤ 91" {{ $ewsPasienDewasa->saturasi_o2 == '≤ 91' ? 'selected' : '' }}>≤
                                            91</option>
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
                                        <option value="≥ 220" {{ $ewsPasienDewasa->tekanan_darah == '≥ 220' ? 'selected' : '' }}>≥ 220</option>
                                        <option value="111-219" {{ $ewsPasienDewasa->tekanan_darah == '111-219' ? 'selected' : '' }}>111-219</option>
                                        <option value="101-110" {{ $ewsPasienDewasa->tekanan_darah == '101-110' ? 'selected' : '' }}>101-110</option>
                                        <option value="91-100" {{ $ewsPasienDewasa->tekanan_darah == '91-100' ? 'selected' : '' }}>91-100</option>
                                        <option value="≤ 90" {{ $ewsPasienDewasa->tekanan_darah == '≤ 90' ? 'selected' : '' }}>≤ 90</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nadi (per menit)</label>
                                    <select class="form-select" name="nadi" id="nadi" disabled>
                                        <option value="">--Pilih--</option>
                                        <option value="≥ 131" {{ $ewsPasienDewasa->nadi == '≥ 131' ? 'selected' : '' }}>≥ 131
                                        </option>
                                        <option value="111-130" {{ $ewsPasienDewasa->nadi == '111-130' ? 'selected' : '' }}>
                                            111-130</option>
                                        <option value="91-110" {{ $ewsPasienDewasa->nadi == '91-110' ? 'selected' : '' }}>
                                            91-110</option>
                                        <option value="51-90" {{ $ewsPasienDewasa->nadi == '51-90' ? 'selected' : '' }}>51-90
                                        </option>
                                        <option value="41-50" {{ $ewsPasienDewasa->nadi == '41-50' ? 'selected' : '' }}>41-50
                                        </option>
                                        <option value="≤ 40" {{ $ewsPasienDewasa->nadi == '≤ 40' ? 'selected' : '' }}>≤ 40
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Nafas (per menit)</label>
                                    <select class="form-select" name="nafas" id="nafas" disabled>
                                        <option value="">--Pilih--</option>
                                        <option value="≥ 25" {{ $ewsPasienDewasa->nafas == '≥ 25' ? 'selected' : '' }}>≥ 25
                                        </option>
                                        <option value="21-24" {{ $ewsPasienDewasa->nafas == '21-24' ? 'selected' : '' }}>21-24
                                        </option>
                                        <option value="12-20" {{ $ewsPasienDewasa->nafas == '12-20' ? 'selected' : '' }}>12-20
                                        </option>
                                        <option value="9-11" {{ $ewsPasienDewasa->nafas == '9-11' ? 'selected' : '' }}>9-11
                                        </option>
                                        <option value="≤ 8" {{ $ewsPasienDewasa->nafas == '≤ 8' ? 'selected' : '' }}>≤ 8
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Temperatur (°C)</label>
                                    <select class="form-select" name="temperatur" id="temperatur" disabled>
                                        <option value="">--Pilih--</option>
                                        <option value="≥ 39.1" {{ $ewsPasienDewasa->temperatur == '≥ 39.1' ? 'selected' : '' }}>≥ 39.1</option>
                                        <option value="38.1-39.0" {{ $ewsPasienDewasa->temperatur == '38.1-39.0' ? 'selected' : '' }}>38.1-39.0</option>
                                        <option value="36.1-38.0" {{ $ewsPasienDewasa->temperatur == '36.1-38.0' ? 'selected' : '' }}>36.1-38.0</option>
                                        <option value="35.1-36.0" {{ $ewsPasienDewasa->temperatur == '35.1-36.0' ? 'selected' : '' }}>35.1-36.0</option>
                                        <option value="≤ 35" {{ $ewsPasienDewasa->temperatur == '≤ 35' ? 'selected' : '' }}>≤
                                            35</option>
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
        </div>
    </div>
@endsection
