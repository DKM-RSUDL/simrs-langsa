<div class="modal fade" id="tambahObatCatatan" tabindex="-1" aria-labelledby="tambahObatCatatanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="obatModalLabel">Tambah Catatan Pemberian Obat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="catatanObatForm"
                action="{{ route('rawat-inap.farmasi.catatanObat', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                method="post">
                @csrf
                <div class="modal-body position-relative">
                    <!-- Nama Obat -->
                    <div class="mb-3 position-relative">
                        <label for="nama_obat" class="form-label">Nama Obat</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nama_obat" id="nama_obat"
                                placeholder="Nama Obat" required>
                        </div>
                    </div>

                    <!-- Aturan Pakai -->
                    <div class="mb-3">
                        <label class="form-label">Aturan Pakai</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="form-label small">Frekuensi/Interval</label>
                                <input type="text" class="form-control form-control-sm" name="frekuensi"
                                    id="frekuensi">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Dosis, Satuan, Freak -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label small">Dosis Sekali Minum</label>
                            <input type="text" class="form-control form-control-sm" name="dosis" id="dosis">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Satuan</label>
                            <input type="text" class="form-control form-control-sm" id="satuan" name="satuan"
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small">Perlu Validasi</label>
                            <select name="is_validasi" id="is_validasi" class="form-select form-select-sm" required>
                                <option value="">--Pilih--</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal dan Jam -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small">Tanggal</label>
                            <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Jam</label>
                            <input type="time" class="form-control form-control-sm" id="jam" name="jam"
                                value="{{ date('H:i') }}" required>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Pemberian Obat</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3"
                            placeholder="Masukkan catatan pemberian obat..."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Tutup
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    <style>
        #obatListCatatan {
            position: absolute;
            width: 100%;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1050;
            display: block;
            margin-top: 0;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        #obatListCatatan a {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid #e9ecef;
        }

        #obatListCatatan a:last-child {
            border-bottom: none;
        }

        .modal-content {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .modal-header {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endpush
