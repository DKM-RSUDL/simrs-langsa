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
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <form action="{{ route('rawat-jalan.layanan-rehab-medik.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}" method="post">
                @csrf

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-body">
                            <!-- Tanggal Pelayanan -->
                            <div class="row mb-4 mt-2">
                                <label class="col-sm-3 col-form-label">Waktu Pelayanan</label>
                                <div class="col-sm-9 d-flex">
                                    <input type="date" name="tgl_pelayanan" class="form-control" style="max-width: 200px;" value="{{ date('Y-m-d') }}">
                                    <input type="time" name="jam_pelayanan" class="form-control ms-3" style="max-width: 200px;" value="{{ date('H:i') }}">
                                </div>
                            </div>

                            <!-- Medical Form Fields -->
                            <div class="row g-4">
                                <!-- Anamnesa -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="anamnesa" id="anamnesa" style="height: 100px"></textarea>
                                        <label for="anamnesa">Anamesa</label>
                                    </div>
                                </div>

                                <!-- Pemeriksaan Fisik -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="pemeriksaan_fisik" id="pemeriksaan_fisik" style="height: 100px"></textarea>
                                        <label for="pemeriksaan_fisik">Pemeriksaan Fisik dan Uji Fungsi</label>
                                    </div>
                                </div>

                                <!-- Two Column Layout -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <strong class="fw-bold">
                                            Diagnosis Medis (ICD-10)
                                            <a href="javascript:void(0)"
                                                class="text-secondary text-decoration-none fw-bold ms-3"
                                                id="btn-diagnosis-medis-icd10"><i class="bi bi-plus-square"></i> Tambah</a>
                                        </strong>

                                        <div class="bg-light p-1 border rounded">
                                            <div style="max-height: 150px; overflow-y: auto;" id="diagnoseDisplay">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <strong class="fw-bold">
                                            Diagnosis Fungsi (ICD-10)
                                            <a href="javascript:void(0)" class="text-secondary text-decoration-none fw-bold ms-3" id="btn-diagnosis-fungsi-icd10">
                                                <i class="bi bi-plus-square"></i> Tambah
                                            </a>
                                        </strong>
                                        <div class="bg-light p-1 border rounded">
                                            <div style="max-height: 150px; overflow-y: auto;" id="diagnoseDisplayFungsi"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Full Width Fields -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="pemeriksaan_penunjang" id="pemeriksaan_penunjang" style="height: 100px"></textarea>
                                        <label for="pemeriksaan_penunjang">Pemeriksaan Penunjang</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <strong class="fw-bold">
                                            Tatalaksana KFR (ICD-9 CM)
                                            <a href="javascript:void(0)" class="text-secondary text-decoration-none fw-bold ms-3" id="btn-tatalaksana-kfricd9">
                                                <i class="bi bi-plus-square"></i> Tambah
                                            </a>
                                        </strong>
                                        <div class="bg-light p-1 border rounded">
                                            <div style="max-height: 150px; overflow-y: auto;" id="diagnoseDisplaytatalaksanakfr"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Work Disease Suspect Section -->
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-body">
                                            <label class="form-label fw-bold">Suspek penyakit akibat kerja</label>
                                            <div class="d-flex gap-4 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="suspek_penyakit" id="suspekYa" value="1"
                                                        onclick="toggleSuspekDetails(true)">
                                                    <label class="form-check-label" for="suspekYa">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="suspek_penyakit" id="suspekTidak" value="0"
                                                        onclick="toggleSuspekDetails(false)">
                                                    <label class="form-check-label" for="suspekTidak">Tidak</label>
                                                </div>
                                            </div>
                                            <div id="suspekDetails" style="display: none;">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="suspek_penyakit_ket" id="suspek_penyakit_ket" style="height: 100px"></textarea>
                                                    <label for="suspek_penyakit_ket">Keterangan Detail</label>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="anjuran" id="anjuran" style="height: 100px"></textarea>
                                                    <label for="anjuran">Anjuran</label>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="evaluasi" id="evaluasi" style="height: 100px"></textarea>
                                                    <label for="evaluasi">Evaluasi</label>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="diagnosa" id="diagnosa" style="height: 100px"></textarea>
                                                    <label for="diagnosa">Diagnosa</label>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="permintaan_terapi" id="permintaan_terapi" style="height: 100px"></textarea>
                                                    <label for="permintaan_terapi">Permintaan terapi</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @include('unit-pelayanan.rehab-medis.pelayanan.layanan.pelayanan-medis.modal-create-diagnosismedisicd10')
    @include('unit-pelayanan.rehab-medis.pelayanan.layanan.pelayanan-medis.modal-create-diagnosisfungsicd10')
    @include('unit-pelayanan.rehab-medis.pelayanan.layanan.pelayanan-medis.modal-create-tatalaksana-kfricd9')
@endsection


@push('js')
    <script>
        function toggleSuspekDetails(show) {
            const detailsDiv = document.getElementById('suspekDetails');
            detailsDiv.style.display = show ? 'block' : 'none';

            if (!show) {
                document.getElementById('work_disease_details').value = '';
            }
        }
    </script>
@endpush
