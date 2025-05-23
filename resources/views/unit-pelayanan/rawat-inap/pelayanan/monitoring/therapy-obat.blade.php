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
                    <th scope="col" class="text-center" style="width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($therapies as $therapy)
                    <tr>
                        <td>{{ $therapy->jenis_terapi == 1 ? 'Terapi Oral' : ($therapy->jenis_terapi == 2 ? 'Terapi Injeksi' : ($therapy->jenis_terapi == 3 ? 'Drip' : 'Cairan')) }}</td>
                        <td>{{ $therapy->nama_obat }}</td>
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
                        <td colspan="3" class="text-center text-muted">Belum ada data terapi obat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal for Adding Therapy -->
    <div class="modal fade" id="therapyModal" tabindex="-1" aria-labelledby="therapyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold required">Jenis Terapi</label>
                                    <select class="form-select" name="jenis_terapi" required>
                                        <option value="">- Pilih Jenis Terapi -</option>
                                        <option value="1">Terapi Oral</option>
                                        <option value="2">Terapi Injeksi</option>
                                        <option value="3">Drip</option>
                                        <option value="4">Cairan</option>
                                    </select>
                                    <div class="invalid-feedback">Jenis terapi harus dipilih.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold required">Nama Obat</label>
                                    <input type="text" class="form-control" name="nama_obat" value="{{ old('nama_obat') }}" required>
                                    <div class="invalid-feedback">Nama obat harus diisi.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
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
            // Form validation before submission
            $('#therapyForm').on('submit', function(e) {
                const requiredFields = ['jenis_terapi', 'nama_obat'];
                let isValid = true;

                requiredFields.forEach(function(field) {
                    const fieldValue = $(`[name="${field}"]`).val();
                    if (!fieldValue || fieldValue.trim() === '') {
                        $(`[name="${field}"]`).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(`[name="${field}"]`).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua kolom yang wajib diisi!');
                }
            });
        });
    </script>
@endpush