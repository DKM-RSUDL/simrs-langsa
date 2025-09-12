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
                            action="{{ route('rawat-jalan.asesmen.medis.awal.update', [
                                'kd_unit' => $kd_unit,
                                'kd_pasien' => $kd_pasien,
                                'tgl_masuk' => $tgl_masuk,
                                'urut_masuk' => $urut_masuk,
                                'id' => $id,
                            ]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="px-3">
                                <div>

                                    <div class="section-separator" id="data-masuk">
                                        <h5 class="section-title">1. Data masuk</h5>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Waktu Asesmen</label>
                                            <div class="d-flex gap-3" style="width: 100%;">
                                                <input disabled type="date" class="form-control" name="waktu_asesmen"
                                                    id="waktu_asesmen"
                                                    value="{{ old('waktu_asesmen', isset($rmeAsesmen->asesmenMedisAwal) ? \Carbon\Carbon::parse($rmeAsesmen->asesmenMedisAwal->waktu_asesmen)->format('Y-m-d') : '') }}">
                                                <input disabled type="time" class="form-control" name="jam_masuk"
                                                    id="jam_masuk"
                                                    value="{{ old('jam_masuk', isset($rmeAsesmen->asesmenMedisAwal) ? \Carbon\Carbon::parse($rmeAsesmen->asesmenMedisAwal->waktu_asesmen)->format('H:i') : '') }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Keluhan Utama</label>
                                            <textarea disabled class="form-control" name="keluhan_utama" rows="4"
                                                placeholder="Masukkan keluhan utama atau alasan masuk rumah sakit">{{ old('keluhan_utama', $rmeAsesmen->asesmenMedisAwal->keluhan_utama ?? '') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Pemeriksaan Fisik</label>
                                            <textarea disabled class="form-control" name="pemeriksaan_fisik" rows="4"
                                                placeholder="Masukkan pemeriksaan fisik">{{ old('pemeriksaan_fisik', $rmeAsesmen->asesmenMedisAwal->pemeriksaan_fisik ?? '') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Planning</label>
                                            <textarea disabled class="form-control" name="planning" rows="4" placeholder="Masukkan planning">{{ old('planning', $rmeAsesmen->asesmenMedisAwal->planning ?? '') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label style="min-width: 220px;">Edukasi</label>
                                            <textarea disabled class="form-control" name="edukasi" rows="4" placeholder="Masukkan edukasi">{{ old('edukasi', $rmeAsesmen->asesmenMedisAwal->edukasi ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="section-separator" id="diagnosis">
                                        <h5 class="section-title">2. Diagnosis</h5>

                                        <div class="mb-4">

                                            <!-- List Diagnosis -->
                                            <div id="diagnosis-list" class="diagnosis-list bg-light p-3 rounded">
                                                <p class="text-muted m-0" id="no-diagnosis">Belum ada diagnosis ditambahkan
                                                </p>
                                            </div>

                                            <!-- Hidden input untuk dikirim ke backend -->
                                            <input type="hidden" id="diagnosis_banding" name="diagnosis_banding"
                                                value='{{ old('diagnosis_banding', json_encode(is_array($rmeAsesmen->asesmenMedisAwal->diagnosis) ? $rmeAsesmen->asesmenMedisAwal->diagnosis : json_decode($rmeAsesmen->asesmenMedisAwal->diagnosis, true) ?? [])) }}'>
                                        </div>
                                    </div>
                                    <div class="section-separator" id="alergi">
                                        <h5 class="section-title">3. Alergi</h5>
                                        <input type="hidden" name="alergis" id="alergisInput"
                                            value='{{ old('alergis', json_encode($alergiPasien)) }}'>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="createAlergiTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="20%">Jenis Alergi</th>
                                                        <th width="25%">Alergen</th>
                                                        <th width="25%">Reaksi</th>
                                                        <th width="20%">Tingkat Keparahan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="no-alergi-row">
                                                        <td colspan="5" class="text-center text-muted">Tidak ada data
                                                            alergi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById("diagnosis-input");
            const addBtn = document.getElementById("add-diagnosis");
            const list = document.getElementById("diagnosis-list");
            const hiddenInput = document.getElementById("diagnosis_banding");
            const noDiagnosis = document.getElementById("no-diagnosis");

            // Inisialisasi diagnosisData dari hidden input, pastikan selalu array
            let diagnosisData = [];
            try {
                const parsed = JSON.parse(hiddenInput.value);
                diagnosisData = Array.isArray(parsed) ? parsed : [];
            } catch (e) {
                diagnosisData = [];
            }

            // Fungsi render ulang daftar diagnosis
            function renderDiagnosis() {
                if (!list || !noDiagnosis) return;
                list.innerHTML = "";
                if (!Array.isArray(diagnosisData) || diagnosisData.length === 0) {
                    list.appendChild(noDiagnosis);
                    noDiagnosis.style.display = "block";
                    return;
                }
                noDiagnosis.style.display = "none";

                diagnosisData.forEach((diag, index) => {
                    const item = document.createElement("div");
                    item.className =
                        "d-flex justify-content-between align-items-center border rounded px-3 py-2 mb-2 bg-white";
                    item.innerHTML = `
                        <span>${diag}</span>
                    `;
                    list.appendChild(item);
                });

                // event hapus
                list.querySelectorAll("button").forEach(btn => {
                    btn.addEventListener("click", function() {
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
            if (addBtn) {
                addBtn.addEventListener("click", function() {
                    const value = input.value.trim();
                    if (value !== "") {
                        diagnosisData.push(value);
                        updateHiddenInput();
                        renderDiagnosis();
                        input.value = "";
                    }
                });
            }

            // Enter key untuk langsung tambah
            if (input) {
                input.addEventListener("keypress", function(e) {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        if (addBtn) addBtn.click();
                    }
                });
            }

            // Render diagnosis saat halaman dimuat
            renderDiagnosis();
        });
    </script>
@endpush
@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-awal.show-alergi')
@include('unit-pelayanan.rawat-jalan.pelayanan.asesmen-awal.include')
