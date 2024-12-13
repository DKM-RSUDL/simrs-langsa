<!-- Modal -->
<div class="modal fade" id="modal-create-pelayanan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <span class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-hospital-user me-2"></i>FORMULIR LAYANAN KEDOKTERAN FISIK DAN REHABILITASI
                </span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-md me-2"></i>II. Diisi oleh Dokter KFR
                        </h5>
                    </div>

                    <div class="card-body">
                        <form id="medicalForm" action="#" method="POST">
                            @csrf

                            <!-- Tanggal Pelayanan -->
                            <div class="row mb-4 mt-2">
                                <label class="col-sm-3 col-form-label">Tanggal Pelayanan</label>
                                <div class="col-sm-9">
                                    <input type="date" name="tanggal_pelayanan" class="form-control" style="max-width: 200px;">
                                </div>
                            </div>

                            <!-- Medical Form Fields -->
                            <div class="row g-4">
                                <!-- Anamnesa -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="anamesa" id="anamesa" style="height: 100px"></textarea>
                                        <label for="anamesa">Anamesa</label>
                                    </div>
                                </div>

                                <!-- Pemeriksaan Fisik -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="physical_exam" id="physical_exam" style="height: 100px"></textarea>
                                        <label for="physical_exam">Pemeriksaan Fisik dan Uji Fungsi</label>
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
                                        <textarea class="form-control" name="supporting_exam" id="supporting_exam" style="height: 100px"></textarea>
                                        <label for="supporting_exam">Pemeriksaan Penunjang</label>
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
                                                        name="work_disease_suspect" id="suspekYa" value="ya"
                                                        onclick="toggleSuspekDetails(true)">
                                                    <label class="form-check-label" for="suspekYa">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="work_disease_suspect" id="suspekTidak" value="tidak"
                                                        onclick="toggleSuspekDetails(false)">
                                                    <label class="form-check-label" for="suspekTidak">Tidak</label>
                                                </div>
                                            </div>
                                            <div id="suspekDetails" style="display: none;">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="work_disease_details" id="work_disease_details" style="height: 100px"></textarea>
                                                    <label for="work_disease_details">Keterangan Detail</label>
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
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('unit-pelayanan.rehab-medis.pelayanan.layanan.pelayanan-medis.modal-create-diagnosismedisicd10')
@include('unit-pelayanan.rehab-medis.pelayanan.layanan.pelayanan-medis.modal-create-diagnosisfungsicd10')
@include('unit-pelayanan.rehab-medis.pelayanan.layanan.pelayanan-medis.modal-create-tatalaksana-kfricd9')

<!-- JavaScript for handling the work disease suspect section -->
<script>
    $('#btn-create-pelayanan').on('click', function() {
        $('#modal-create-pelayanan').modal('show');
    });

    function toggleSuspekDetails(show) {
        const detailsDiv = document.getElementById('suspekDetails');
        detailsDiv.style.display = show ? 'block' : 'none';

        if (!show) {
            document.getElementById('work_disease_details').value = '';
        }
    }

    // Initialize Bootstrap Modal
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modal-create-pelayanan');

        // Clear form when modal is closed
        modal.addEventListener('hidden.bs.modal', function() {
            document.getElementById('medicalForm').reset();
            toggleSuspekDetails(false);
        });
    });
</script>
