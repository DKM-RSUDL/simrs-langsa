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
                <a href="{{ route('rawat-inap.ews-pasien-obstetrik.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $ewsPsienObstetrik->id]) }}"
                    class="btn btn-warning mr-2">
                    <i class="ti-pencil"></i> Edit
                </a>
                <a href="{{ route('rawat-inap.ews-pasien-obstetrik.print-pdf', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, $ewsPsienObstetrik->id]) }}"
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
                                    Pasien Obstetrik
                                </h4>
                            </div>

                            <div class="section-separator" id="data-masuk">
                                <div class="form-group">
                                    <label style="min-width: 200px;">Tanggal Dan Jam Masuk</label>
                                    <div class="d-flex gap-3" style="width: 100%;">
                                        <input type="date" class="form-control" name="tanggal" disabled
                                            value="{{ $ewsPsienObstetrik->tanggal ? Carbon\Carbon::parse($ewsPsienObstetrik->tanggal)->format('Y-m-d') : date('Y-m-d') }}">
                                        <input type="time" class="form-control" name="jam_masuk" disabled
                                            value="{{ $ewsPsienObstetrik->jam_masuk ? Carbon\Carbon::parse($ewsPsienObstetrik->jam_masuk)->format('H:i') : date('H:i') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Respirasi (per menit)</label>
                                    <select class="form-select" name="respirasi" id="respirasi" disabled>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $respirasiMatches = [
                                                '>25' => ['>25', '> 25', '>=25', '>= 25'],
                                                '21-25' => ['21-25'],
                                                '12-20' => ['12-20'],
                                                '<12' => ['<12', '<=12', '<= 12', '=12'],
                                            ];
                                        @endphp
                                        <option value=">25" {{ in_array($ewsPsienObstetrik->respirasi, $respirasiMatches['>25']) ? 'selected' : '' }}>>25</option>
                                        <option value="21-25" {{ in_array($ewsPsienObstetrik->respirasi, $respirasiMatches['21-25']) ? 'selected' : '' }}>21-25</option>
                                        <option value="12-20" {{ in_array($ewsPsienObstetrik->respirasi, $respirasiMatches['12-20']) ? 'selected' : '' }}>12-20</option>
                                        <option value="<12" {{ in_array($ewsPsienObstetrik->respirasi, $respirasiMatches['<12']) ? 'selected' : '' }}><12</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Saturasi O2</label>
                                    <select class="form-select" name="saturasi_o2" id="saturasi_o2" disabled>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $saturasiMatches = [
                                                '≥ 95' => ['≥ 95', '>= 95', '= 95', '>=95'],
                                                '92-95' => ['92-95'],
                                                '≤ 91' => ['≤ 91', '<= 91', '= 91', '<=91'],
                                            ];
                                        @endphp
                                        <option value="≥ 95" {{ in_array($ewsPsienObstetrik->saturasi_o2, $saturasiMatches['≥ 95']) ? 'selected' : '' }}>≥ 95</option>
                                        <option value="92-95" {{ in_array($ewsPsienObstetrik->saturasi_o2, $saturasiMatches['92-95']) ? 'selected' : '' }}>92-95</option>
                                        <option value="≤ 91" {{ in_array($ewsPsienObstetrik->saturasi_o2, $saturasiMatches['≤ 91']) ? 'selected' : '' }}>≤ 91</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Suplemen O2</label>
                                    <select class="form-select" name="suplemen_o2" id="suplemen_o2" disabled>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $suplemenMatches = [
                                                'Tidak' => ['Tidak', 'tidak', 'No'],
                                                'Ya' => ['Ya', 'ya', 'Yes'],
                                            ];
                                        @endphp
                                        <option value="Tidak" {{ in_array($ewsPsienObstetrik->suplemen_o2, $suplemenMatches['Tidak']) ? 'selected' : '' }}>Tidak</option>
                                        <option value="Ya" {{ in_array($ewsPsienObstetrik->suplemen_o2, $suplemenMatches['Ya']) ? 'selected' : '' }}>Ya</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Tekanan Darah Sistolik (mmHg)</label>
                                    <select class="form-select" name="tekanan_darah" id="tekanan_darah" disabled>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $tekananDarahMatches = [
                                                '> 160' => ['> 160', '>160', '>= 160', '>=160'],
                                                '151-160' => ['151-160'],
                                                '141-150' => ['141-150'],
                                                '91-140' => ['91-140'],
                                                '< 90' => ['< 90', '<= 90', '<=90', '= 90'],
                                            ];
                                        @endphp
                                        <option value="> 160" {{ in_array($ewsPsienObstetrik->tekanan_darah, $tekananDarahMatches['> 160']) ? 'selected' : '' }}>> 160</option>
                                        <option value="151-160" {{ in_array($ewsPsienObstetrik->tekanan_darah, $tekananDarahMatches['151-160']) ? 'selected' : '' }}>151-160</option>
                                        <option value="141-150" {{ in_array($ewsPsienObstetrik->tekanan_darah, $tekananDarahMatches['141-150']) ? 'selected' : '' }}>141-150</option>
                                        <option value="91-140" {{ in_array($ewsPsienObstetrik->tekanan_darah, $tekananDarahMatches['91-140']) ? 'selected' : '' }}>91-140</option>
                                        <option value="< 90" {{ in_array($ewsPsienObstetrik->tekanan_darah, $tekananDarahMatches['< 90']) ? 'selected' : '' }}>< 90</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Detak Jantung (per menit)</label>
                                    <select class="form-select" name="detak_jantung" id="detak_jantung" disabled>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $detakJantungMatches = [
                                                '> 120' => ['> 120', '>120', '>= 120', '>=120'],
                                                '111-120' => ['111-120'],
                                                '101-110' => ['101-110'],
                                                '61-100' => ['61-100'],
                                                '50-60' => ['50-60'],
                                                '≤ 50' => ['≤ 50', '<= 50', '<=50', '= 50'],
                                            ];
                                        @endphp
                                        <option value="> 120" {{ in_array($ewsPsienObstetrik->detak_jantung, $detakJantungMatches['> 120']) ? 'selected' : '' }}>> 120</option>
                                        <option value="111-120" {{ in_array($ewsPsienObstetrik->detak_jantung, $detakJantungMatches['111-120']) ? 'selected' : '' }}>111-120</option>
                                        <option value="101-110" {{ in_array($ewsPsienObstetrik->detak_jantung, $detakJantungMatches['101-110']) ? 'selected' : '' }}>101-110</option>
                                        <option value="61-100" {{ in_array($ewsPsienObstetrik->detak_jantung, $detakJantungMatches['61-100']) ? 'selected' : '' }}>61-100</option>
                                        <option value="50-60" {{ in_array($ewsPsienObstetrik->detak_jantung, $detakJantungMatches['50-60']) ? 'selected' : '' }}>50-60</option>
                                        <option value="≤ 50" {{ in_array($ewsPsienObstetrik->detak_jantung, $detakJantungMatches['≤ 50']) ? 'selected' : '' }}>≤ 50</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Kesadaran</label>
                                    <select class="form-select" name="kesadaran" id="kesadaran" disabled>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $kesadaranMatches = [
                                                'Sadar' => ['Sadar', 'sadar'],
                                                'Nyeri/Verbal' => ['Nyeri/Verbal', 'nyeri/verbal'],
                                                'Unresponsive' => ['Unresponsive', 'unresponsive'],
                                            ];
                                        @endphp
                                        <option value="Sadar" {{ in_array($ewsPsienObstetrik->kesadaran, $kesadaranMatches['Sadar']) ? 'selected' : '' }}>Sadar</option>
                                        <option value="Nyeri/Verbal" {{ in_array($ewsPsienObstetrik->kesadaran, $kesadaranMatches['Nyeri/Verbal']) ? 'selected' : '' }}>Nyeri/Verbal</option>
                                        <option value="Unresponsive" {{ in_array($ewsPsienObstetrik->kesadaran, $kesadaranMatches['Unresponsive']) ? 'selected' : '' }}>Unresponsive (Code Blue)</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Temperatur (°C)</label>
                                    <select class="form-select" name="temperatur" id="temperatur" disabled>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $temperaturMatches = [
                                                '≤ 36' => ['≤ 36', '<= 36', '<=36', '= 36'],
                                                '36.1-37.2' => ['36.1-37.2'],
                                                '37.3-37.7' => ['37.3-37.7'],
                                                '> 37.7' => ['> 37.7', '>37.7', '>= 37.7', '>=37.7'],
                                            ];
                                        @endphp
                                        <option value="≤ 36" {{ in_array($ewsPsienObstetrik->temperatur, $temperaturMatches['≤ 36']) ? 'selected' : '' }}>≤ 36</option>
                                        <option value="36.1-37.2" {{ in_array($ewsPsienObstetrik->temperatur, $temperaturMatches['36.1-37.2']) ? 'selected' : '' }}>36.1-37.2</option>
                                        <option value="37.3-37.7" {{ in_array($ewsPsienObstetrik->temperatur, $temperaturMatches['37.3-37.7']) ? 'selected' : '' }}>37.3-37.7</option>
                                        <option value="> 37.7" {{ in_array($ewsPsienObstetrik->temperatur, $temperaturMatches['> 37.7']) ? 'selected' : '' }}>> 37.7</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Discharge/Lochia</label>
                                    <select class="form-select" name="discharge" id="discharge" disabled>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $dischargeMatches = [
                                                'Normal' => ['Normal', 'normal'],
                                                'Abnormal' => ['Abnormal', 'abnormal'],
                                            ];
                                        @endphp
                                        <option value="Normal" {{ in_array($ewsPsienObstetrik->discharge, $dischargeMatches['Normal']) ? 'selected' : '' }}>Normal</option>
                                        <option value="Abnormal" {{ in_array($ewsPsienObstetrik->discharge, $dischargeMatches['Abnormal']) ? 'selected' : '' }}>Abnormal</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="min-width: 200px;">Proteinuria/hari</label>
                                    <select class="form-select" name="proteinuria" id="proteinuria" disabled>
                                        <option value="" disabled>--Pilih--</option>
                                        @php
                                            $proteinuriaMatches = [
                                                'Negatif' => ['Negatif', 'negatif', 'Negative'],
                                                '≥ 1' => ['≥ 1', '>= 1', '>=1', '= 1'],
                                            ];
                                        @endphp
                                        <option value="Negatif" {{ in_array($ewsPsienObstetrik->proteinuria, $proteinuriaMatches['Negatif']) ? 'selected' : '' }}>Negatif</option>
                                        <option value="≥ 1" {{ in_array($ewsPsienObstetrik->proteinuria, $proteinuriaMatches['≥ 1']) ? 'selected' : '' }}>≥ 1</option>
                                    </select>
                                </div>

                                <!-- Total Score Section -->
                                <div class="total-score-section">
                                    <h5 class="mb-3">TOTAL SKOR</h5>
                                    <div class="total-score-value">{{ $ewsPsienObstetrik->total_skor ?? 0 }}</div>
                                    <p class="mb-0 text-muted">Skor Early Warning System</p>
                                </div>

                                <!-- Kesimpulan Section -->
                                <div class="kesimpulan-section">
                                    <h5 class="mb-3">KESIMPULAN HASIL EWS</h5>

                                    @if($ewsPsienObstetrik->hasil_ews == 'RISIKO RENDAH')
                                        <div class="kesimpulan-card kesimpulan-hijau">
                                            <div class="alert alert-success">
                                                <strong>Skor 1-4:</strong> Assessment segera oleh perawat senior, respon segera (maks 5 menit),
                                                eskalasi perawatan dan frekuensi monitoring per 4-6 jam. Jika diperlukan assessment oleh dokter jaga bangsal.
                                            </div>
                                        </div>
                                    @elseif($ewsPsienObstetrik->hasil_ews == 'RISIKO SEDANG')
                                        <div class="kesimpulan-card kesimpulan-kuning">
                                            <div class="alert alert-warning">
                                                <strong>Skor 5-6:</strong> Assessment segera oleh dokter jaga (respon segera, maks 5 menit),
                                                konsultasi DPJP dan spesialis terkait, eskalasi perawatan dan monitoring tiap jam,
                                                pertimbangkan perawatan dengan monitoring yang sesuai (HCU).
                                            </div>
                                        </div>
                                    @elseif($ewsPsienObstetrik->hasil_ews == 'RISIKO TINGGI')
                                        <div class="kesimpulan-card kesimpulan-merah">
                                            <div class="alert alert-danger">
                                                <strong>Skor ≥ 7 atau 1 Parameter Kriteria Blue (Risiko Tinggi):</strong>
                                                Resusitasi dan monitoring secara kontinyu oleh dokter jaga dan perawat senior,
                                                Aktivasi code blue kegawatan medis, respon Tim Medis Emergency (TME)/tim Code Blue segera (maksimal 10 menit),
                                                Informasikan dan konsultasikan ke DPJP.
                                            </div>
                                        </div>
                                    @elseif($ewsPsienObstetrik->hasil_ews == 'CODE BLUE - HENTI NAFAS/JANTUNG')
                                        <div class="kesimpulan-card kesimpulan-code-blue">
                                            <div class="alert alert-dark">
                                                <strong>HENTI NAFAS/JANTUNG:</strong>
                                                Lakukan RJP oleh petugas/tim primer, aktivasi code blue henti jantung,
                                                respon Tim Medis Emergency (TME)/tim Code Blue segera (maksimal 5 menit),
                                                informasikan dan konsultasikan dengan DPJP.
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Hidden inputs untuk backend -->
                                <input type="hidden" id="ews-total-score" name="total_skor"
                                    value="{{ $ewsPsienObstetrik->total_skor ?? 0 }}">
                                <input type="hidden" id="ews-hasil" name="hasil_ews"
                                    value="{{ $ewsPsienObstetrik->hasil_ews ?? '' }}">
                                <input type="hidden" id="ews-code-blue" name="code_blue"
                                    value="{{ $ewsPsienObstetrik->code_blue ?? 0 }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
