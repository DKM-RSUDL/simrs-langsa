{{-- Modal Copy CPO --}}
<div class="modal fade" id="copyCPOModal" tabindex="-1" aria-labelledby="copyCPOModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="copyCPOModalLabel">
                    Salin Catatan Pemberian Obat (CPO)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="copyCPOForm"
                action="{{ route('rawat-inap.farmasi.catatanObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf

                <div class="modal-body">
                    <!-- Nama Obat -->
                    <div class="mb-3">
                        <label for="copy_nama_obat" class="form-label fw-semibold">Nama Obat</label>
                        <input type="text" class="form-control" name="nama_obat" id="copy_nama_obat"
                            placeholder="Nama Obat" required readonly>
                    </div>

                    <!-- Aturan Pakai -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Aturan Pakai</label>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small">Frekuensi/Interval</label>
                                <input type="text" class="form-control" name="frekuensi" id="copy_frekuensi"
                                    placeholder="Contoh: 3x sehari" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Keterangan</label>
                                <textarea name="keterangan" id="copy_keterangan" class="form-control" rows="2"
                                    placeholder="Oral/Injeksi atau lainnya" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Dosis, Satuan, Validasi -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small">Dosis</label>
                            <input type="text" class="form-control" name="dosis" id="copy_dosis"
                                placeholder="Contoh: 500" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Satuan</label>
                            <input type="text" class="form-control" id="copy_satuan" name="satuan"
                                placeholder="mg/ml/tablet" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Perlu Validasi</label>
                            <select name="is_validasi" id="copy_is_validasi" class="form-select" required>
                                <option value="">--Pilih--</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal dan Jam -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small">Tanggal</label>
                            <input type="date" class="form-control" id="copy_tanggal" name="tanggal"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Jam</label>
                            <input type="time" class="form-control" id="copy_jam" name="jam"
                                value="{{ date('H:i') }}" required>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="copy_catatan" class="form-label">Catatan Pemberian Obat</label>
                        <textarea class="form-control" id="copy_catatan" name="catatan" rows="3"
                            placeholder="Masukkan catatan pemberian obat..."></textarea>
                    </div>

                    <!-- Info Data Asli -->
                    <div class="alert alert-info border-0 shadow-sm">
                        <strong class="d-block mb-2">Data Resep Asli:</strong>
                        <div id="original_data_info" class="small text-muted"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Tutup
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>Simpan CPO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('css')
<style>
    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .modal-header {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }

    #copy_nama_obat:read-only {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .form-label.fw-semibold {
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .form-label.small {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk tombol CPO
    document.querySelectorAll('.btn-copy-cpo').forEach(function(button) {
        button.addEventListener('click', function() {
            // Ambil data dari data attributes
            const namaObat = this.getAttribute('data-nama-obat') || '';
            const dosis = this.getAttribute('data-dosis') || '';
            const satuan = this.getAttribute('data-satuan') || '';
            const frekuensi = this.getAttribute('data-frekuensi') || '';
            const keterangan = this.getAttribute('data-keterangan') || '';
            const tanggal = this.getAttribute('data-tanggal') || '';
            const dokter = this.getAttribute('data-dokter') || '';

            // Isi form modal
            document.getElementById('copy_nama_obat').value = namaObat;
            document.getElementById('copy_dosis').value = dosis;
            document.getElementById('copy_satuan').value = satuan;
            document.getElementById('copy_frekuensi').value = frekuensi;
            document.getElementById('copy_keterangan').value = keterangan;

            // Set default validasi
            document.getElementById('copy_is_validasi').value = '1';

            // Reset catatan
            document.getElementById('copy_catatan').value = '';

            // Format info data asli
            const originalInfo = `
                <div class="row g-2">
                    <div class="col-6"><strong>Tanggal:</strong> ${tanggal || 'Tidak ada'}</div>
                    <div class="col-6"><strong>Dokter:</strong> ${dokter || 'Tidak ada'}</div>
                    <div class="col-12"><strong>Obat:</strong> ${namaObat || 'Tidak ada'}</div>
                    <div class="col-6"><strong>Dosis:</strong> ${dosis || 'Tidak ada'} ${satuan}</div>
                    <div class="col-6"><strong>Frekuensi:</strong> ${frekuensi || 'Tidak ada'}</div>
                </div>
            `;
            document.getElementById('original_data_info').innerHTML = originalInfo;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('copyCPOModal'));
            modal.show();
        });
    });

    // Reset form ketika modal ditutup
    document.getElementById('copyCPOModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('copyCPOForm').reset();
        document.getElementById('copy_tanggal').value = '{{ date('Y-m-d') }}';
        document.getElementById('copy_jam').value = '{{ date('H:i') }}';
        document.getElementById('original_data_info').innerHTML = '';
    });
});
</script>
@endpush
