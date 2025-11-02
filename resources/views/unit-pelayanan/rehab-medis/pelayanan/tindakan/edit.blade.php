@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Perbarui KFR/Asesmen/RE-Asesmen/Protokol Terapi',
                    'description' =>
                        'Perbarui Data KFR/Asesmen/RE-Asesmen/Protokol Terapi dengan mengisi formulir di bawah ini.',
                ])

                <form
                    action="{{ route('rehab-medis.pelayanan.tindakan.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($tindakan->id)]) }}"
                    method="post" class="d-flex flex-column gap-4">
                    @csrf
                    @method('put')

                    <!-- Waktu Pelayanan -->
                    <div class="row">
                        <label class="col-md-6" for="tgl_tindakan">Waktu Tindakan</label>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" name="tgl_tindakan" class="form-control w-100"
                                        value="{{ date('Y-m-d', strtotime($tindakan->tgl_tindakan)) }}"">
                                </div>
                                <div class="col-6">
                                    <input type="time" name="jam_tindakan" class="form-control w-100"
                                        value="{{ date('H:i', strtotime($tindakan->jam_tindakan)) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="subjective" class="fw-bold">Subjective</label>
                            <textarea class="form-control" name="subjective" id="subjective" style="height: 100px">{{ $tindakan->subjective }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="objective" class="fw-bold">Objective</label>
                            <textarea class="form-control" name="objective" id="objective" style="height: 100px">{{ $tindakan->objective }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="assessment" class="fw-bold">Assessment</label>
                            <textarea class="form-control" name="assessment" id="assessment" style="height: 100px">{{ $tindakan->assessment }}</textarea>
                        </div>

                        <!-- Program / Tindakan -->
                        <div class="col-md-12">
                            <label for="planning_goal" class="fw-bold">Planning</label>
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <label for="planning_goal">a. Goal of Treatment</label>
                                    <textarea class="form-control" name="planning_goal" id="planning_goal" style="height: 70px">{{ $tindakan->planning_goal }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="planning_tindakan">b. Tindakan/Program Rehabilitasi Medik</label>
                                    <textarea class="form-control" name="planning_tindakan" id="planning_tindakan" style="height: 70px">{{ $tindakan->planning_tindakan }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="planning_edukasi">c. Edukasi</label>
                                    <textarea class="form-control" name="planning_edukasi" id="planning_edukasi" style="height: 70px">{{ $tindakan->planning_edukasi }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="planning_frekuensi">d. Frekuensi Kunjungan</label>
                                    <textarea class="form-control" name="planning_frekuensi" id="planning_frekuensi" style="height: 70px">{{ $tindakan->planning_frekuensi }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="rencana_tindak_lanjut" class="fw-bold">Rencana Tindakan
                                Lanjut(Evaluasi/Rujuk/Selesai)</label>
                            <textarea class="form-control" name="rencana_tindak_lanjut" id="rencana_tindak_lanjut" style="height: 100px">{{ $tindakan->rencana_tindak_lanjut }}</textarea>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="text-end">
                        <x-button-submit>Perbarui</x-button-submit>
                    </div>

                </form>
            </x-content-card>
        </div>
    </div>
@endsection
