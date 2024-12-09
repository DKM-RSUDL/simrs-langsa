<!-- Modal Tambah Resep -->
<div class="modal fade" id="addRujukAntarRs" tabindex="-1" aria-labelledby="addRujukAntarRsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addGeneralConsentModalLabel">Rujuk Antar Rumah Sakit</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <form action="#" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam" class="form-label">Jam</label>
                                <input type="time" name="jam" id="jam" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Transportasi</label>
                                <div class="form-check">
                                    <input type="checkbox" name="transportasi_ambulans" id="transportasi_ambulans"
                                        class="form-check-input">
                                    <label class="form-check-label">Ambulans RS</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="transportasi_lainnya" id="transportasi_lainnya"
                                        class="form-check-input">
                                    <label class="form-check-label">Kendaraan lainnya:</label>
                                </div>
                                <input type="text" name="detail_kendaraan" id="detail_kendaraan" class="form-control"
                                    placeholder="Sebutkan kendaraan lainnya">
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">Nomor Polisi Kendaraan</label>
                                <input type="text" name="nomor_polisi" id="nomor_polisi" class="form-control">
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">Pendamping</label>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_dokter" id="pendamping_dokter"
                                        class="form-check-input">
                                    <label class="form-check-label">Dokter</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_perawat" id="pendamping_perawat"
                                        class="form-check-input">
                                    <label class="form-check-label">Perawat</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="pendamping_keluarga" id="pendamping_keluarga"
                                        class="form-check-input">
                                    <label class="form-check-label">Keluarga:</label>
                                </div>
                                <input type="text" name="detail_keluarga" id="detail_keluarga" class="form-control"
                                    placeholder="Sebutkan hubungan keluarga">
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="pendamping_tidak_ada" id="pendamping_tidak_ada"
                                        class="form-check-input">
                                    <label class="form-check-label">Tidak ada</label>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">Tanda-tanda vital saat pindah</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Suhu:</label>
                                        <input type="text" name="suhu" id="suhu" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tensi:</label>
                                        <input type="text" name="tensi" id="tensi" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nadi:</label>
                                        <input type="text" name="nadi" id="nadi" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Respirasi:</label>
                                        <input type="text" name="respirasi" id="respirasi" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Status nyeri:</label>
                                            <input type="number" name="status_nyeri" id="status_nyeri"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}" alt="Skala Nyeri"
                                            class="img-fluid" style="max-height: 200px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">Alasan pindah Rumah Sakit</label>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_tempat_penuh" id="alasan_tempat_penuh"
                                        class="form-check-input">
                                    <label class="form-check-label">Tempat penuh</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_permintaan_keluarga"
                                        id="alasan_permintaan_keluarga" class="form-check-input">
                                    <label class="form-check-label">Permintaan keluarga</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_perawatan_khusus"
                                        id="alasan_perawatan_khusus" class="form-check-input">
                                    <label class="form-check-label">Perawatan Khusus</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="alasan_lainnya" id="alasan_lainnya"
                                        class="form-check-input">
                                    <label class="form-check-label">Lainnya:</label>
                                </div>
                                <input type="text" name="detail_alasan_lainnya" id="detail_alasan_lainnya"
                                    class="form-control" placeholder="Sebutkan alasan lainnya">
                            </div>

                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Alergi</p>
                            @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.rujuk-antar-rs.modal-alergi')
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="alergiList">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Alasan Masuk/Dirujuk</p>
                            <div class="form-group mt-3">
                                <textarea name="alasan_masuk_dirujuk" id="alasan_masuk_dirujuk" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Hasil Pemeriksaan Penunjang Diagnostik</p>
                            <div class="form-group mt-3">
                                <textarea name="hasil_pemeriksaan_penunjang" id="hasil_pemeriksaan_penunjang" class="form-control" rows="4"
                                    required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Terapi/ Pengobatan serta hasil konsultasi selama di Rumah Sakit</p>
                            <div class="form-group mt-3">
                                <textarea name="terapi" id="terapi" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Diagnosis</p>
                            @include('unit-pelayanan.gawat-darurat.action-gawat-darurat.rujuk-antar-rs.modal-diagnosis')
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="diagnoseList">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Tindakan / Prosedur :</p>
                            <div class="form-group mt-3">
                                <textarea name="Tindakan" id="Tindakan" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-bottom border-primary mt-3"></div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Edukasi pasien / keluarga: </p>
                            <div class="form-group mt-3">
                                <textarea name="edukasi_pasien" id="edukasi_pasien" class="form-control" rows="4" required></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Jumlah dan Total di Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script></script>
@endpush
