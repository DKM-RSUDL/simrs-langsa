@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url("unit-pelayanan/rawat-jalan/unit/$kd_unit/pelayanan/$kd_pasien/$tgl_masuk/$urut_masuk/asesmen") }}"
                class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>
            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h4 class="header-asesmen">Asesmen Medis Awal</h4>
                                    <p>
                                        Isikan Asesmen medis dalam 24 jam sejak pasien masuk ke unit pelayanan
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- FORM ASESMEN MEDIS AWAL --}}
                        <form method="POST"
                            action="{{ route('rawat-jalan.asesmen.medis.awal.store', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                            ]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="px-3">
                                <div>

                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Waktu Asesmen</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input type="date" class="form-control" name="waktu_asesmen" id="waktu_asesmen" value="{{ date('Y-m-d') }}">
                                                <input type="time" class="form-control" name="jam_masuk" id="jam_masuk" value="{{ date('H:i') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Keluhan Utama</label>
                                            <textarea class="form-control" name="keluhan_utama" rows="4"
                                                placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Pemeriksaan Fisik</label>
                                            <textarea class="form-control" name="pemeriksaan_fisik" rows="4"
                                                placeholder="Masukkan pemeriksaan fisik"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Planning</label>
                                            <textarea class="form-control" name="planning" rows="4"
                                                placeholder="Masukkan planning"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Edukasi</label>
                                            <textarea class="form-control" name="edukasi" rows="4"
                                                placeholder="Masukkan edukasi"></textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="section-title">2. Diagnosis</h5>

                                        <div class="mb-4">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="bi bi-search text-secondary"></i>
                                                </span>
                                                <input type="text" id="diagnosis-input"
                                                    class="form-control border-start-0 ps-0"
                                                    placeholder="Masukkan Diagnosis">
                                                <span class="input-group-text bg-white" id="add-diagnosis" style="cursor: pointer;">
                                                    <i class="bi bi-plus-circle text-primary"></i>
                                                </span>
                                            </div>

                                            <!-- List Diagnosis -->
                                            <div id="diagnosis-list" class="diagnosis-list bg-light p-3 rounded">
                                                <p class="text-muted m-0" id="no-diagnosis">Belum ada diagnosis ditambahkan</p>
                                            </div>

                                            <!-- Hidden input untuk dikirim ke backend -->
                                            <input type="hidden" id="diagnosis_banding" name="diagnosis_banding" value="[]">
                                        </div>
                                    </div>
                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">3. Alergi</h5>

                                        <button type="button" class="btn btn-sm btn-outline-secondary mb-3"
                                            id="openAlergiModal" data-bs-toggle="modal" data-bs-target="#alergiModal">
                                            <i class="ti-plus"></i> Tambah Alergi
                                        </button>
                                        <input type="hidden" name="alergis" id="alergisInput" value="[]">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="createAlergiTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="20%">Jenis Alergi</th>
                                                        <th width="25%">Alergen</th>
                                                        <th width="25%">Reaksi</th>
                                                        <th width="20%">Tingkat Keparahan</th>
                                                        <th width="10%">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="no-alergi-row">
                                                        <td colspan="5" class="text-center text-muted">Tidak ada data alergi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="text-end mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti-check"></i> Simpan
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let diagnosisData = [];
        const input = document.getElementById("diagnosis-input");
        const addBtn = document.getElementById("add-diagnosis");
        const list = document.getElementById("diagnosis-list");
        const hiddenInput = document.getElementById("diagnosis_banding");
        const noDiagnosis = document.getElementById("no-diagnosis");

        // Fungsi render ulang daftar diagnosis
        function renderDiagnosis() {
            list.innerHTML = "";
            if (diagnosisData.length === 0) {
                list.appendChild(noDiagnosis);
                noDiagnosis.style.display = "block";
                return;
            }
            noDiagnosis.style.display = "none";

            diagnosisData.forEach((diag, index) => {
                const item = document.createElement("div");
                item.className = "d-flex justify-content-between align-items-center border rounded px-3 py-2 mb-2 bg-white";
                item.innerHTML = `
                    <span>${diag}</span>
                    <button type="button" class="btn btn-sm btn-danger" data-index="${index}">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
                list.appendChild(item);
            });

            // event hapus
            list.querySelectorAll("button").forEach(btn => {
                btn.addEventListener("click", function () {
                    const idx = this.getAttribute("data-index");
                    diagnosisData.splice(idx, 1);
                    updateHiddenInput();
                    renderDiagnosis();
                });
            });
        }

        // Update hidden input untuk dikirim ke backend
        function updateHiddenInput() {
            hiddenInput.value = JSON.stringify(diagnosisData);
        }

        // Tambah diagnosis
        addBtn.addEventListener("click", function () {
            const value = input.value.trim();
            if (value !== "") {
                diagnosisData.push(value);
                updateHiddenInput();
                renderDiagnosis();
                input.value = "";
            }
        });

        // Enter key untuk langsung tambah
        input.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                addBtn.click();
            }
        });
    });
</script>
@endpush
@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-awal.modal-create-alergi')
@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-awal.include')
