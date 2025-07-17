{{-- Modal Tambah Monitoring --}}
<div class="modal fade" id="modalTambahMonitoring" tabindex="-1" aria-labelledby="modalTambahMonitoringLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahMonitoringLabel">
                    <i class="ti-plus me-2"></i>Tambah Data Monitoring Gizi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTambahMonitoring" method="POST" action="{{ route('rawat-jalan.gizi.monitoring.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        {{-- Tanggal dan Jam --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal" class="form-label">Tanggal <span class="required">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam" class="form-label">Jam <span class="required">*</span></label>
                                <input type="time" class="form-control" id="jam" name="jam" value="{{ date('H:i') }}" required>
                            </div>
                        </div>
                    </div>

                    {{-- Energi dan Protein --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="energi" class="form-label">Energi <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="energi" name="energi" placeholder="Masukkan nilai energi" step="0.1" min="0" required>
                                    <span class="input-group-text">Kkal</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="protein" class="form-label">Protein <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="protein" name="protein" placeholder="Masukkan nilai protein" step="0.1" min="0" required>
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Karbohidrat dan Lemak --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="karbohidrat" class="form-label">Karbohidrat (KH) <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="karbohidrat" name="karbohidrat" placeholder="Masukkan nilai karbohidrat" step="0.1" min="0" required>
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lemak" class="form-label">Lemak <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="lemak" name="lemak" placeholder="Masukkan nilai lemak" step="0.1" min="0" required>
                                    <span class="input-group-text">g</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Masalah Perkembangan --}}
                    <div class="form-group">
                        <label for="masalah_perkembangan" class="form-label">Masalah Perkembangan</label>
                        <textarea class="form-control" id="masalah_perkembangan" name="masalah_perkembangan" rows="3" placeholder="Deskripsikan masalah perkembangan yang ditemukan (jika ada)"></textarea>
                    </div>

                    {{-- Tindak Lanjut --}}
                    <div class="form-group">
                        <label for="tindak_lanjut" class="form-label">Tindak Lanjut</label>
                        <textarea class="form-control" id="tindak_lanjut" name="tindak_lanjut" rows="3" placeholder="Deskripsikan tindak lanjut yang akan dilakukan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="ti-close me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti-save me-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Modal Detail Monitoring --}}
<div class="modal fade" id="modalDetailMonitoring" tabindex="-1" aria-labelledby="modalDetailMonitoringLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailMonitoringLabel">
                    <i class="ti-eye me-2"></i>Detail Data Monitoring Gizi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent">
                    <!-- Detail content akan dimuat di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ti-close me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>