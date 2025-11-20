<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Rincian Pra Operasi Medis',
                    'description' => 'Rincian data pra operasi medis.',
                ])

                <div class="section-separator" id="dataMasuk">
                    <h5 class="section-title">1. Data Masuk</h5>
                    <div class="form-group">
                        <label style="min-width: 200px;">Tanggal dan Jam Masuk</label>

                        <input type="date" name="tgl_masuk" id="tgl_masuk"
                            value="{{ date('Y-m-d', strtotime($asesmen->praOperatifMedis->tgl_op)) }}"
                            class="form-control me-3" disabled>
                        <input type="time" name="jam_masuk" id="jam_masuk"
                            value="{{ date('H:i', strtotime($asesmen->praOperatifMedis->tgl_op)) }}" class="form-control"
                            disabled>
                    </div>
                </div>

                <div class="section-separator" id="diagnosaPraOperatif">
                    <h5 class="section-title">2. Diagnosa Pra Operatif</h5>

                    <div class="form-group">
                        <label for="diagnosa_pra_operatif" style="min-width: 200px;">Diagnosis Pra Operatif</label>
                        <textarea name="diagnosa_pra_operatif" id="diagnosa_pra_operatif" class="form-control" disabled>{{ $asesmen->praOperatifMedis->diagnosa_pra_operasi }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="timing_tindakan" style="min-width: 200px;">Timing Tindakan</label>
                        <textarea name="timing_tindakan" id="timing_tindakan" class="form-control" disabled>{{ $asesmen->praOperatifMedis->timing_tindakan }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="indikasi_tindakan" style="min-width: 200px;">Indikasi Tindakan</label>
                        <textarea name="indikasi_tindakan" id="indikasi_tindakan" class="form-control" disabled>{{ $asesmen->praOperatifMedis->indikasi_tindakan }}</textarea>
                    </div>
                </div>

                <div class="section-separator" id="rencanaTindakan">
                    <h5 class="section-title">3. Rencana Tindakan dan Prosedur</h5>

                    <div class="form-group">
                        <label for="rencana_tindakan" style="min-width: 200px;">Rencana Tindakan</label>
                        <textarea name="rencana_tindakan" id="rencana_tindakan" class="form-control" disabled>{{ $asesmen->praOperatifMedis->rencana_tindakan }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="prosedur_tindakan" style="min-width: 200px;">Prosedur Tindakan</label>
                        <textarea name="prosedur_tindakan" id="prosedur_tindakan" class="form-control" disabled>{{ $asesmen->praOperatifMedis->prosedur_tindakan }}</textarea>
                    </div>
                </div>

                <div class="section-separator" id="timingDanAlternatifTindakan">
                    <h5 class="section-title">4. Timing dan Alternatif Tindakan</h5>

                    <div class="form-group">
                        <label style="min-width: 200px;">Waktu Tindakan</label>

                        <input type="date" name="tgl_tindakan" id="tgl_tindakan" class="form-control me-3"
                            value="{{ date('Y-m-d', strtotime($asesmen->praOperatifMedis->waktu_tindakan)) }}" disabled>
                        <input type="time" name="jam_tindakan" id="jam_tindakan" class="form-control"
                            value="{{ date('H:i', strtotime($asesmen->praOperatifMedis->jam_tindakan)) }}" disabled>
                    </div>

                    <div class="form-group">
                        <label for="alternatif_lain" style="min-width: 200px;">Alternatif Lain</label>
                        <textarea name="alternatif_lain" id="alternatif_lain" class="form-control" disabled>{{ $asesmen->praOperatifMedis->alternatif_lain }}</textarea>
                    </div>
                </div>

                <div class="section-separator" id="rencanaTindakan">
                    <h5 class="section-title">5. Risiko dan Pemantauan</h5>

                    <div class="form-group">
                        <label for="resiko" style="min-width: 200px;">Risiko/Komplikasi</label>
                        <textarea name="resiko" id="resiko" class="form-control" disabled>{{ $asesmen->praOperatifMedis->resiko }}</textarea>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection
