<!-- Modal Tambah Rujukan Antar RS untuk Rawat Jalan -->
<div class="modal fade" id="createRujukAntarRsRawatJalan" tabindex="-1" aria-labelledby="createRujukAntarRsRawatJalanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createRujukAntarRsRawatJalanLabel">Tambah Rujukan Antar Rumah Sakit (Rawat Jalan)</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('rawat-jalan.rujuk-antar-rs.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggalRawatJalan" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggalRawatJalan" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jamRawatJalan" class="form-label">Jam</label>
                                <input type="time" name="jam" id="jamRawatJalan" class="form-control" value="{{ date('H:i') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Transportasi</label>
                                <div class="form-check">
                                    <input type="radio" name="transportasi" id="transportasiAmbulansRawatJalan" value="ambulans" class="form-check-input" checked>
                                    <label class="form-check-label" for="transportasiAmbulansRawatJalan">Ambulans RS</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="radio" name="transportasi" id="transportasiLainnyaRawatJalan" value="lainnya" class="form-check-input">
                                    <label class="form-check-label" for="transportasiLainnyaRawatJalan">Kendaraan lainnya:</label>
                                </div>
                                <input type="text" name="detail_kendaraan" id="detailKendaraanRawatJalan" class="form-control" placeholder="Sebutkan kendaraan lainnya" disabled>
                            </div>
                            <div class="form-group mt-3">
                                <label for="nomorPolisiRawatJalan" class="form-label">Nomor Polisi Kendaraan</label>
                                <input type="text" name="nomor_polisi" id="nomorPolisiRawatJalan" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Pendamping</label>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_dokter" id="pendampingDokterRawatJalan" value="1" class="form-check-input pendamping-option-rawat-jalan">
                                    <label class="form-check-label" for="pendampingDokterRawatJalan">Dokter</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_perawat" id="pendampingPerawatRawatJalan" value="1" class="form-check-input pendamping-option-rawat-jalan">
                                    <label class="form-check-label" for="pendampingPerawatRawatJalan">Perawat</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="pendamping_keluarga" id="pendampingKeluargaRawatJalan" value="1" class="form-check-input pendamping-option-rawat-jalan">
                                    <label class="form-check-label" for="pendampingKeluargaRawatJalan">Keluarga:</label>
                                </div>
                                <input type="text" name="detail_keluarga" id="detailKeluargaRawatJalan" class="form-control" placeholder="Sebutkan hubungan keluarga" disabled>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="pendamping_tidak_ada" id="pendampingTidakAdaRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="pendampingTidakAdaRawatJalan">Tidak ada</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Tanda-tanda vital saat pindah</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="suhuRawatJalan" class="form-label">Suhu:</label>
                                        <input type="number" name="suhu" id="suhuRawatJalan" step="0.1" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="sistoleRawatJalan" class="form-label">Sistole:</label>
                                        <input type="number" name="sistole" id="sistoleRawatJalan" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="diastoleRawatJalan" class="form-label">Diastole:</label>
                                        <input type="number" name="diastole" id="diastoleRawatJalan" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nadiRawatJalan" class="form-label">Nadi:</label>
                                        <input type="number" name="nadi" id="nadiRawatJalan" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="respirasiRawatJalan" class="form-label">Respirasi:</label>
                                        <input type="number" name="respirasi" id="respirasiRawatJalan" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="statusNyeriRawatJalan" class="form-label">Status nyeri:</label>
                                            <input type="number" name="status_nyeri" id="statusNyeriRawatJalan" min="0" max="10" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <img src="{{ asset('assets/img/asesmen/asesmen.jpeg') }}" alt="Skala Nyeri" class="img-fluid" style="max-height: 200px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Alasan pindah Rumah Sakit</label>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_tempat_penuh" id="alasanTempatPenuhRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="alasanTempatPenuhRawatJalan">Tempat penuh</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_permintaan_keluarga" id="alasanPermintaanKeluargaRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="alasanPermintaanKeluargaRawatJalan">Permintaan keluarga</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_perawatan_khusus" id="alasanPerawatanKhususRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="alasanPerawatanKhususRawatJalan">Perawatan Khusus</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="alasan_lainnya" id="alasanLainnyaRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="alasanLainnyaRawatJalan">Lainnya:</label>
                                </div>
                                <input type="text" name="detail_alasan_lainnya" id="detailAlasanLainnyaRawatJalan" class="form-control" placeholder="Sebutkan alasan lainnya" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Alergi -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Alergi</p>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="alergiNameRawatJalan" class="form-label">Nama Alergi</label>
                                            <input type="text" id="alergiNameRawatJalan" class="form-control" placeholder="Contoh: Penisilin">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="alergiReactionRawatJalan" class="form-label">Reaksi</label>
                                            <input type="text" id="alergiReactionRawatJalan" class="form-control" placeholder="Contoh: Ruam kulit">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary add-alergi-btn-rawat-jalan">
                                            <i class="bi bi-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="alergiListDisplayRawatJalan"></div>
                                    <input type="hidden" name="alergi" id="alergiInputRawatJalan">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Alasan Masuk/Dirujuk -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Alasan Masuk/Dirujuk</p>
                            <div class="form-group mt-3">
                                <textarea name="alasan_masuk_dirujuk" id="alasanMasukDirujukRawatJalan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Hasil Pemeriksaan Penunjang -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Hasil Pemeriksaan Penunjang Diagnostik</p>
                            <div class="form-group mt-3">
                                <textarea name="hasil_pemeriksaan_penunjang" id="hasilPemeriksaanPenunjangRawatJalan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Terapi/Pengobatan -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Terapi/Pengobatan serta hasil konsultasi selama di Rumah Sakit</p>
                            <div class="form-group mt-3">
                                <textarea name="terapi" id="terapiRawatJalan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Diagnosis -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Diagnosis</p>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="diagnosisNameRawatJalan" class="form-label">Diagnosis</label>
                                            <input type="text" id="diagnosisNameRawatJalan" class="form-control" placeholder="Contoh: Asthma bronchiale">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary add-diagnosis-btn-rawat-jalan">
                                            <i class="bi bi-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="diagnoseListDisplayRawatJalan"></div>
                                    <input type="hidden" name="diagnosis" id="diagnosisInputRawatJalan">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Tindakan/Prosedur -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Tindakan/Prosedur</p>
                            <div class="form-group mt-3">
                                <textarea name="tindakan" id="tindakanRawatJalan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Edukasi Pasien -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Edukasi pasien/keluarga</p>
                            <div class="form-group mt-3">
                                <textarea name="edukasi_pasien" id="edukasiPasienRawatJalan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        // Toggle detail_kendaraan untuk Rawat Jalan
        $('input[name="transportasi"]').change(function() {
            if ($(this).val() === 'lainnya') {
                $('#detailKendaraanRawatJalan').prop('disabled', false).focus();
            } else {
                $('#detailKendaraanRawatJalan').prop('disabled', true).val('');
            }
        });
        $('input[name="transportasi"]:checked').trigger('change');

        // Toggle detail_keluarga untuk Rawat Jalan
        $('#pendampingKeluargaRawatJalan').change(function() {
            if ($(this).is(':checked')) {
                $('#detailKeluargaRawatJalan').prop('disabled', false).focus();
            } else {
                $('#detailKeluargaRawatJalan').prop('disabled', true).val('');
            }
        });
        $('#pendampingKeluargaRawatJalan').trigger('change');

        // Toggle detail_alasan_lainnya untuk Rawat Jalan
        $('#alasanLainnyaRawatJalan').change(function() {
            if ($(this).is(':checked')) {
                $('#detailAlasanLainnyaRawatJalan').prop('disabled', false).focus();
            } else {
                $('#detailAlasanLainnyaRawatJalan').prop('disabled', true).val('');
            }
        });
        $('#alasanLainnyaRawatJalan').trigger('change');

        // Handle mutual exclusivity untuk pendamping_tidak_ada
        $('#pendampingTidakAdaRawatJalan').change(function() {
            if ($(this).is(':checked')) {
                $('.pendamping-option-rawat-jalan').prop('checked', false).trigger('change');
            }
        });
        $('.pendamping-option-rawat-jalan').change(function() {
            if ($(this).is(':checked')) {
                $('#pendampingTidakAdaRawatJalan').prop('checked', false);
            }
        });

        // Handle form submission untuk Rawat Jalan
        $('#createRujukAntarRsRawatJalan form').submit(function() {
            let alergiData = [];
            $('#alergiListDisplayRawatJalan .alergi-item-rawat-jalan').each(function() {
                const name = $(this).data('name');
                const reaction = $(this).data('reaction');
                if (name) alergiData.push({ name: name, reaction: reaction });
            });
            $('#alergiInputRawatJalan').val(JSON.stringify(alergiData));

            let diagnosisData = [];
            $('#diagnoseListDisplayRawatJalan .diagnosis-item-rawat-jalan').each(function() {
                const name = $(this).data('name');
                if (name) diagnosisData.push({ name: name });
            });
            $('#diagnosisInputRawatJalan').val(JSON.stringify(diagnosisData));

            return true;
        });

        // Fungsi tambah alergi untuk Rawat Jalan
        function addAlergiToListRawatJalan(name, reaction) {
            const alergiItem = `
                <div class="alergi-item-rawat-jalan card mb-2" data-name="${name}" data-reaction="${reaction}">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between">
                            <div><strong>${name}</strong><p class="m-0 text-muted">${reaction}</p></div>
                            <button type="button" class="btn btn-sm btn-danger remove-alergi-rawat-jalan"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>`;
            $('#alergiListDisplayRawatJalan').append(alergiItem);
        }

        // Fungsi tambah diagnosis untuk Rawat Jalan
        function addDiagnosisToListRawatJalan(name) {
            const diagnosisItem = `
                <div class="diagnosis-item-rawat-jalan card mb-2" data-name="${name}">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between">
                            <div><p class="m-0">${name}</p></div>
                            <button type="button" class="btn btn-sm btn-danger remove-diagnosis-rawat-jalan"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>`;
            $('#diagnoseListDisplayRawatJalan').append(diagnosisItem);
        }

        // Event handler untuk tombol tambah alergi
        $(document).on('click', '.add-alergi-btn-rawat-jalan', function() {
            const name = $('#alergiNameRawatJalan').val();
            const reaction = $('#alergiReactionRawatJalan').val();
            if (name && reaction) {
                addAlergiToListRawatJalan(name, reaction);
                $('#alergiNameRawatJalan').val('').focus();
                $('#alergiReactionRawatJalan').val('');
            }
        });

        // Event handler untuk tombol tambah diagnosis
        $(document).on('click', '.add-diagnosis-btn-rawat-jalan', function() {
            const name = $('#diagnosisNameRawatJalan').val();
            if (name) {
                addDiagnosisToListRawatJalan(name);
                $('#diagnosisNameRawatJalan').val('').focus();
            }
        });

        // Event handler untuk tombol hapus alergi dan diagnosis
        $(document).on('click', '.remove-alergi-rawat-jalan, .remove-diagnosis-rawat-jalan', function() {
            $(this).closest('.card').remove();
        });
    });
</script>
@endpush
