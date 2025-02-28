<!-- create -->
@extends('layouts.administrator.master')

@section('content')
    @include('unit-pelayanan.operasi.pelayanan.include')

    <div class="row">
        <div class="col-md-3">
            @include('unit-pelayanan.operasi.pelayanan.asesmen.pra-anestesi.medis.patient-card')
        </div>

        <div class="col-md-9">

            <form method="POST" action="{{ route('operasi.pelayanan.asesmen.pra-anestesi.medis.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">

                            <div class="px-3">
                                <div>
                                    <a href="{{ url()->previous() }}" class="btn">
                                        <i class="ti-arrow-left"></i> Kembali
                                    </a>

                                    <div class="section-separator" id="dataMasuk">
                                        <h5 class="section-title">1. Data Masuk</h5>
                                        <div class="form-group">
                                            <label style="min-width: 200px;">Tanggal dan Jam Masuk</label>

                                            <input type="date" name="tgl_masuk" id="tgl_masuk" value="{{ date('Y-m-d', strtotime($asesmen->praOperatifMedis->tgl_op)) }}" class="form-control me-3">
                                            <input type="time" name="jam_masuk" id="jam_masuk" value="{{ date('H:i', strtotime($asesmen->praOperatifMedis->tgl_op)) }}" class="form-control">
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosaPraOperatif">
                                        <h5 class="section-title">2. Diagnosa Pra Operatif</h5>

                                        <div class="form-group">
                                            <label for="diagnosa_pra_operatif" style="min-width: 200px;">Diagnosis Pra Operatif</label>
                                            <textarea name="diagnosa_pra_operatif" id="diagnosa_pra_operatif" class="form-control">{{ $asesmen->praOperatifMedis->diagnosa_pra_operasi }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="timing_tindakan" style="min-width: 200px;">Timing Tindakan</label>
                                            <textarea name="timing_tindakan" id="timing_tindakan" class="form-control">{{ $asesmen->praOperatifMedis->timing_tindakan }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="indikasi_tindakan" style="min-width: 200px;">Indikasi Tindakan</label>
                                            <textarea name="indikasi_tindakan" id="indikasi_tindakan" class="form-control">{{ $asesmen->praOperatifMedis->indikasi_tindakan }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="rencanaTindakan">
                                        <h5 class="section-title">3. Rencana Tindakan dan Prosedur</h5>

                                        <div class="form-group">
                                            <label for="rencana_tindakan" style="min-width: 200px;">Rencana Tindakan</label>
                                            <textarea name="rencana_tindakan" id="rencana_tindakan" class="form-control">{{ $asesmen->praOperatifMedis->rencana_tindakan }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="prosedur_tindakan" style="min-width: 200px;">Prosedur Tindakan</label>
                                            <textarea name="prosedur_tindakan" id="prosedur_tindakan" class="form-control">{{ $asesmen->praOperatifMedis->prosedur_tindakan }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="timingDanAlternatifTindakan">
                                        <h5 class="section-title">4. Timing dan Alternatif Tindakan</h5>

                                        <div class="form-group">
                                            <label style="min-width: 200px;">Waktu Tindakan</label>

                                            <input type="date" name="tgl_tindakan" id="tgl_tindakan" class="form-control me-3" value="{{ date('Y-m-d', strtotime($asesmen->praOperatifMedis->waktu_tindakan)) }}">
                                            <input type="time" name="jam_tindakan" id="jam_tindakan" class="form-control" value="{{ date('H:i', strtotime($asesmen->praOperatifMedis->waktu_tindakan)) }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="alternatif_lain" style="min-width: 200px;">Alternatif Lain</label>
                                            <textarea name="alternatif_lain" id="alternatif_lain" class="form-control">{{ $asesmen->praOperatifMedis->alternatif_lain }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="rencanaTindakan">
                                        <h5 class="section-title">5. Risiko dan Pemantauan</h5>

                                        <div class="form-group">
                                            <label for="resiko" style="min-width: 200px;">Risiko/Komplikasi</label>
                                            <textarea name="resiko" id="resiko" class="form-control">{{ $asesmen->praOperatifMedis->resiko }}</textarea>
                                        </div>

                                        <p class="fs-5 fw-bold">Pemantauan Pasca-Tindakan</p>

                                        <div class="form-group align-items-center">
                                            <label style="min-width: 200px;">Tek. Darah (mmHg)</label>

                                            <div class="me-4">
                                                <label for="sistole" class="form-label">Sistole</label>
                                                <input type="number" name="sistole" id="sistole" class="form-control" value="{{ $asesmen->praOperatifMedis->sistole }}">
                                            </div>

                                            <div class="">
                                                <label for="diastole" class="form-label">Diastole</label>
                                                <input type="number" name="diastole" id="diastole" class="form-control" value="{{ $asesmen->praOperatifMedis->diastole }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="nadi" style="min-width: 200px;">Nadi (Per Menit)</label>
                                            <input type="number" name="nadi" id="nadi" class="form-control" value="{{ $asesmen->praOperatifMedis->nadi }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="nafas" style="min-width: 200px;">Nafas (Per Menit)</label>
                                            <input type="number" name="nafas" id="nafas" class="form-control" value="{{ $asesmen->praOperatifMedis->nafas }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="suhu" style="min-width: 200px;">Suhu (C)</label>
                                            <input type="number" name="suhu" id="suhu" class="form-control" value="{{ $asesmen->praOperatifMedis->suhu }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="evaluasi" style="min-width: 200px;">Evaluasi Luka Operasi</label>
                                            <textarea name="evaluasi" id="evaluasi" class="form-control">{{ $asesmen->praOperatifMedis->evaluasi }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="penanganan_nyeri" style="min-width: 200px;">Penanganan Nyeri Pasca Operasi</label>
                                            <textarea name="penanganan_nyeri" id="penanganan_nyeri" class="form-control">{{ $asesmen->praOperatifMedis->penanganan_nyeri }}</textarea>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
