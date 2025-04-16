<!-- Modal Riwayat Obat -->
<div class="modal fade" id="tambahObatCatatan" tabindex="-1" aria-labelledby="tambahObatCatatanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="obatModalLabel">Tambah Catatan Pemberian Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="catatanObatForm"
                    action="{{ route('rawat-inap.farmasi.catatanObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="cariObat" class="form-label">Cari Nama Obat</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cariObat" name="nama_obat" placeholder="Ketik nama obat..." required>
                            <button class="btn btn-outline-secondary" type="button" id="clearObat" style="display:none;">X</button>
                        </div>
                        <input type="hidden" id="selectedObatId" name="obat_id">
                        <div id="obatList" class="list-group mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small">Frekuensi/interval</label>
                                <select class="form-select" id="frekuensi" name="frekuensi" required>
                                    <option value="1 x 1 hari">1 x 1 hari</option>
                                    <option value="2 x 1 hari">2 x 1 hari</option>
                                    <option value="3 x 1 hari" selected>3 x 1 hari</option>
                                    <option value="4 x 1 hari">4 x 1 hari</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Keterangan</label>
                                <select class="form-select" id="keterangan" name="keterangan" required>
                                    <option value="Sebelum Makan">Sebelum Makan</option>
                                    <option value="Sesudah Makan" selected>Sesudah Makan</option>
                                    <option value="Saat Makan">Saat Makan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Dosis sekali minum</label>
                            <select class="form-select" id="dosis" name="dosis" required>
                                <option value="1/4">1/4</option>
                                <option value="1/2" selected>1/2</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" value="Tablet" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Freak</label>
                            <input type="number" class="form-control" id="freak" name="freak" value="1" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jam</label>
                            <input type="time" class="form-control" id="jam" name="jam" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Pemberian Obat</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                                  placeholder="Masukkan catatan pemberian obat..."></textarea>
                    </div>

                    <!-- Hidden input untuk kd_petugas -->
                    <input type="hidden" name="kd_petugas" value="{{ auth()->user()->id }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="btnSaveObat">Simpan</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Set tanggal default ke hari ini
        document.getElementById('tanggal').valueAsDate = new Date();
        
        // Set jam default ke waktu sekarang
        const now = new Date();
        const timeString = now.getHours().toString().padStart(2, '0') + ':' + 
                         now.getMinutes().toString().padStart(2, '0');
        document.getElementById('jam').value = timeString;
    </script>
@endpush