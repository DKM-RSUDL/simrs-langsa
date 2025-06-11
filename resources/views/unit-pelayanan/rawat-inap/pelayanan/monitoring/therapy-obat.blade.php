<div>
    <div class="d-flex justify-content-end align-items-center mb-3">
        <div class="alert alert-info d-flex align-items-center me-3 mb-0" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            Tambahkan terapi obat yang diberikan kepada pasien di unit {{ $title }} untuk keperluan monitoring intensif.
        </div>
        <button type="button" class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#therapyModal">
            <i class="fas fa-plus"></i> Tambah Terapi Obat
        </button>
    </div>

    <!-- Therapy Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover" id="therapyList">
            <thead class="table-primary">
                <tr>
                    <th scope="col" class="text-center">Jenis Terapi</th>
                    <th scope="col" class="text-center">Nama Obat</th>
                    <th scope="col" class="text-center">Dihitung ke Balance</th>
                    <th scope="col" class="text-center" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($therapies as $therapy)
                    <tr>
                        <td>{{ $therapy->jenis_terapi == 1 ? 'Terapi Oral' : ($therapy->jenis_terapi == 2 ? 'Terapi Injeksi' : ($therapy->jenis_terapi == 3 ? 'Drip' : 'Cairan')) }}</td>
                        <td>{{ $therapy->nama_obat }}</td>
                        <td class="text-center">
                            <span class="badge {{ $therapy->dihitung ? 'bg-success' : 'bg-secondary' }}">
                                {{ $therapy->dihitung ? 'Ya' : 'Tidak' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('rawat-inap.monitoring.destroy-therapy', ['kd_unit' => $dataMedis->kd_unit, 'kd_pasien' => $kd_pasien, 'tgl_masuk' => $tgl_masuk, 'urut_masuk' => $urut_masuk, 'id' => $therapy->id]) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus terapi ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada data terapi obat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal for Adding Multiple Therapies -->
    <div class="modal fade" id="therapyModal" tabindex="-1" aria-labelledby="therapyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('rawat-inap.monitoring.store-therapy', [
                        'kd_unit' => $dataMedis->kd_unit,
                        'kd_pasien' => $kd_pasien,
                        'tgl_masuk' => $tgl_masuk,
                        'urut_masuk' => $urut_masuk,
                    ]) }}" method="post" id="therapyForm">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="therapyModalLabel">
                            <i class="bi bi-capsule me-2"></i> Tambah Terapi Obat
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info mb-3" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Form ini digunakan untuk mencatat terapi obat pada pasien di unit {{ $title }} untuk keperluan monitoring intensif.
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Daftar Terapi Obat</h6>
                            <button type="button" class="btn btn-success btn-sm" id="addTherapyRow">
                                <i class="fas fa-plus"></i> Tambah Baris
                            </button>
                        </div>

                        <div id="therapyContainer">
                            <!-- Initial therapy row -->
                            <div class="therapy-row border rounded p-3 mb-3" style="position: relative;">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold required">Jenis Terapi</label>
                                        <select class="form-select" name="therapies[0][jenis_terapi]" required>
                                            <option value="">- Pilih Jenis Terapi -</option>
                                            <option value="1">Terapi Oral</option>
                                            <option value="2">Terapi Injeksi</option>
                                            <option value="3">Drip</option>
                                            <option value="4">Cairan</option>
                                        </select>
                                        <div class="invalid-feedback">Jenis terapi harus dipilih.</div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label fw-bold required">Nama Obat</label>
                                        <input type="text" class="form-control" name="therapies[0][nama_obat]" required>
                                        <div class="invalid-feedback">Nama obat harus diisi.</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Dihitung ke Balance</label>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="therapies[0][dihitung]" value="1" id="dihitung_0">
                                            <label class="form-check-label" for="dihitung_0">
                                                Ya, hitung ke balance
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm remove-therapy-row" style="position: absolute; top: 5px; right: 5px; display: none;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Semua
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            let therapyIndex = 1;

            // Add new therapy row
            $('#addTherapyRow').on('click', function() {
                const newRow = `
                    <div class="therapy-row border rounded p-3 mb-3" style="position: relative;">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold required">Jenis Terapi</label>
                                <select class="form-select" name="therapies[${therapyIndex}][jenis_terapi]" required>
                                    <option value="">- Pilih Jenis Terapi -</option>
                                    <option value="1">Terapi Oral</option>
                                    <option value="2">Terapi Injeksi</option>
                                    <option value="3">Drip</option>
                                    <option value="4">Cairan</option>
                                </select>
                                <div class="invalid-feedback">Jenis terapi harus dipilih.</div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold required">Nama Obat</label>
                                <input type="text" class="form-control" name="therapies[${therapyIndex}][nama_obat]" required>
                                <div class="invalid-feedback">Nama obat harus diisi.</div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Dihitung ke Balance</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="therapies[${therapyIndex}][dihitung]" value="1" id="dihitung_${therapyIndex}">
                                    <label class="form-check-label" for="dihitung_${therapyIndex}">
                                        Ya, hitung ke balance
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm remove-therapy-row" style="position: absolute; top: 5px; right: 5px;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                
                $('#therapyContainer').append(newRow);
                therapyIndex++;
                updateRemoveButtons();
            });

            // Remove therapy row
            $(document).on('click', '.remove-therapy-row', function() {
                $(this).closest('.therapy-row').remove();
                updateRemoveButtons();
            });

            // Update remove buttons visibility
            function updateRemoveButtons() {
                const rows = $('.therapy-row');
                if (rows.length > 1) {
                    $('.remove-therapy-row').show();
                } else {
                    $('.remove-therapy-row').hide();
                }
            }

            // Form validation before submission
            $('#therapyForm').on('submit', function(e) {
                let isValid = true;
                
                $('.therapy-row').each(function(index) {
                    const jenisSelect = $(this).find('select[name*="[jenis_terapi]"]');
                    const namaInput = $(this).find('input[name*="[nama_obat]"]');
                    
                    // Validate jenis terapi
                    if (!jenisSelect.val() || jenisSelect.val().trim() === '') {
                        jenisSelect.addClass('is-invalid');
                        isValid = false;
                    } else {
                        jenisSelect.removeClass('is-invalid');
                    }
                    
                    // Validate nama obat
                    if (!namaInput.val() || namaInput.val().trim() === '') {
                        namaInput.addClass('is-invalid');
                        isValid = false;
                    } else {
                        namaInput.removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua kolom yang wajib diisi pada setiap baris terapi!');
                }
            });

            // Reset form when modal is closed
            $('#therapyModal').on('hidden.bs.modal', function() {
                // Keep only first row
                $('.therapy-row:not(:first)').remove();
                
                // Reset first row
                $('.therapy-row:first select').val('');
                $('.therapy-row:first input[type="text"]').val('');
                $('.therapy-row:first input[type="checkbox"]').prop('checked', false);
                
                // Remove validation classes
                $('.therapy-row:first .form-control, .therapy-row:first .form-select').removeClass('is-invalid');
                
                updateRemoveButtons();
                therapyIndex = 1;
            });

            // Initial update of remove buttons
            updateRemoveButtons();
        });
    </script>
@endpush