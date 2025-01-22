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
            @include('unit-pelayanan.operasi.pelayanan.include.nav')


            <div class="container-fluid py-3">
                <!-- Form Header -->
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h5 class="mb-0 text-secondary fw-bold">LAPORAN OPERASI</h5>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama Tindakan Operasi:</label>
                                    <textarea class="form-control" rows="4"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jenis Operasi:</label>
                                    <div class="row g-3">
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="besar">
                                                <label class="form-check-label" for="besar">Besar</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="khusus">
                                                <label class="form-check-label" for="khusus">Khusus</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="bersih">
                                                <label class="form-check-label" for="bersih">Bersih</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="sedang">
                                                <label class="form-check-label" for="sedang">Sedang</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="cyto">
                                                <label class="form-check-label" for="cyto">Cyto</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="tercemar">
                                                <label class="form-check-label" for="tercemar">Tercemar</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="kecil">
                                                <label class="form-check-label" for="kecil">Kecil</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="elective">
                                                <label class="form-check-label" for="elective">Elective</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="kotor">
                                                <label class="form-check-label" for="kotor">Kotor</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Jenis Anesthesi:</label>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="ga">
                                                <label class="form-check-label" for="ga">GA</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="perifer">
                                                <label class="form-check-label" for="perifer">Perifer</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="epidural">
                                                <label class="form-check-label" for="epidural">Epidural</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="lokal">
                                                <label class="form-check-label" for="lokal">lokal</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="spinal">
                                                <label class="form-check-label" for="spinal">Spinal</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="lainnya">
                                                <label class="form-check-label" for="lainnya">Lainnya</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label">Dikirim untuk Pemeriksaan PA:</label>
                                        <div class="">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pa"
                                                    id="paYa">
                                                <label class="form-check-label" for="paYa">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="pa"
                                                    id="paTidak">
                                                <label class="form-check-label" for="paTidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Dikirim untuk kultur:</label>
                                        <div class="">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="kultur"
                                                    id="kulturYa">
                                                <label class="form-check-label" for="kulturYa">Ya</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="kultur"
                                                    id="kulturTidak">
                                                <label class="form-check-label" for="kulturTidak">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Section -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Dokter Ahli Bedah:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Asisten:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Perdarahan:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control">
                                        <span class="input-group-text">cc</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Dokter Ahli Anesthesi:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Asisten/Penata:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Transfusi: WB/ PRC/ FFP/ Cryo</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control">
                                        <span class="input-group-text">cc</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Diagnosa Pra Operasi:</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Diagnosa Pasca Operasi:</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Komplikasi selama pembedahan (bila ada):</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Operasi:</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Mulai Jam:</label>
                                <input type="time" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Selesai Jam:</label>
                                <input type="time" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">LAPORAN PROSEDUR OPERASI</label>
                            <textarea class="form-control" rows="10"></textarea>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
