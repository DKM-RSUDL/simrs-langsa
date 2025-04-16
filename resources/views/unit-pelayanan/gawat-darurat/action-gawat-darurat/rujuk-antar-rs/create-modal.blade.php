<!-- Modal Tambah Rujukan Antar RS -->
<div class="modal fade" id="createRujukAntarRs" tabindex="-1" aria-labelledby="createRujukAntarRsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createRujukAntarRsLabel">Tambah Rujukan Antar Rumah Sakit</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('rujuk-antar-rs.store', ['kd_pasien' => $dataMedis->kd_pasien ?? '', 'tgl_masuk' => $dataMedis->tgl_masuk ?? date('Y-m-d'), 'urut_masuk' => $dataMedis->urut_masuk ?? '']) }}" method="POST">
                @csrf
                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien ?? '' }}">
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit ?? '3' }}">
                <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk ?? date('Y-m-d') }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk ?? '' }}">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam" class="form-label">Jam</label>
                                <input type="time" name="jam" id="jam" class="form-control" value="{{ date('H:i') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Transportasi</label>
                                <div class="form-check">
                                    <input type="radio" name="transportasi" id="transportasi_ambulans" value="ambulans" class="form-check-input" checked>
                                    <label class="form-check-label" for="transportasi_ambulans">Ambulans RS</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="radio" name="transportasi" id="transportasi_lainnya" value="lainnya" class="form-check-input">
                                    <label class="form-check-label" for="transportasi_lainnya">Kendaraan lainnya:</label>
                                </div>
                                <input type="text" name="detail_kendaraan" id="detail_kendaraan" class="form-control" placeholder="Sebutkan kendaraan lainnya" disabled>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Nomor Polisi Kendaraan</label>
                                <input type="text" name="nomor_polisi" id="nomor_polisi" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Pendamping</label>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_dokter" id="pendamping_dokter" value="1" class="form-check-input pendamping-option">
                                    <label class="form-check-label" for="pendamping_dokter">Dokter</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_perawat" id="pendamping_perawat" value="1" class="form-check-input pendamping-option">
                                    <label class="form-check-label" for="pendamping_perawat">Perawat</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="pendamping_keluarga" id="pendamping_keluarga" value="1" class="form-check-input pendamping-option">
                                    <label class="form-check-label" for="pendamping_keluarga">Keluarga:</label>
                                </div>
                                <input type="text" name="detail_keluarga" id="detail_keluarga" class="form-control" placeholder="Sebutkan hubungan keluarga" disabled>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="pendamping_tidak_ada" id="pendamping_tidak_ada" value="1" class="form-check-input">
                                    <label class="form-check-label" for="pendamping_tidak_ada">Tidak ada</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Tanda-tanda vital saat pindah</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Suhu:</label>
                                        <input type="number" name="suhu" id="suhu" step="0.1" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sistole:</label>
                                        <input type="number" name="sistole" id="sistole" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Diastole:</label>
                                        <input type="number" name="diastole" id="diastole" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nadi:</label>
                                        <input type="number" name="nadi" id="nadi" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Respirasi:</label>
                                        <input type="number" name="respirasi" id="respirasi" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Status nyeri:</label>
                                            <input type="number" name="status_nyeri" id="status_nyeri" min="0" max="10" class="form-control">
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
                                    <input type="checkbox" name="alasan_tempat_penuh" id="alasan_tempat_penuh" value="1" class="form-check-input">
                                    <label class="form-check-label" for="alasan_tempat_penuh">Tempat penuh</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_permintaan_keluarga" id="alasan_permintaan_keluarga" value="1" class="form-check-input">
                                    <label class="form-check-label" for="alasan_permintaan_keluarga">Permintaan keluarga</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_perawatan_khusus" id="alasan_perawatan_khusus" value="1" class="form-check-input">
                                    <label class="form-check-label" for="alasan_perawatan_khusus">Perawatan Khusus</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="alasan_lainnya" id="alasan_lainnya" value="1" class="form-check-input">
                                    <label class="form-check-label" for="alasan_lainnya">Lainnya:</label>
                                </div>
                                <input type="text" name="detail_alasan_lainnya" id="detail_alasan_lainnya" class="form-control" placeholder="Sebutkan alasan lainnya" disabled>
                            </div>
                        </div>
                    </div>
                    <!-- Sisa form (alergi, diagnosis, dll.) tetap sama -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Alergi</p>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="alergi_name" class="form-label">Nama Alergi</label>
                                            <input type="text" id="alergi_name" class="form-control" placeholder="Contoh: Penisilin">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="alergi_reaction" class="form-label">Reaksi</label>
                                            <input type="text" id="alergi_reaction" class="form-control" placeholder="Contoh: Ruam kulit">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary add-alergi-btn">
                                            <i class="bi bi-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="alergiListDisplay"></div>
                                    <input type="hidden" name="alergi" id="alergiInput">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Sisa form (Alasan Masuk, Hasil Pemeriksaan, dll.) tetap sama -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Alasan Masuk/Dirujuk</p>
                            <div class="form-group mt-3">
                                <textarea name="alasan_masuk_dirujuk" id="alasan_masuk_dirujuk" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Hasil Pemeriksaan Penunjang Diagnostik</p>
                            <div class="form-group mt-3">
                                <textarea name="hasil_pemeriksaan_penunjang" id="hasil_pemeriksaan_penunjang" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Terapi/ Pengobatan serta hasil konsultasi selama di Rumah Sakit</p>
                            <div class="form-group mt-3">
                                <textarea name="terapi" id="terapi" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Diagnosis</p>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="diagnosis_name" class="form-label">Diagnosis</label>
                                            <input type="text" id="diagnosis_name" class="form-control" placeholder="Contoh: Asthma bronchiale">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary add-diagnosis-btn">
                                            <i class="bi bi-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="diagnoseListDisplay"></div>
                                    <input type="hidden" name="diagnosis" id="diagnosisInput">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Tindakan / Prosedur:</p>
                            <div class="form-group mt-3">
                                <textarea name="tindakan" id="tindakan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Edukasi pasien / keluarga: </p>
                            <div class="form-group mt-3">
                                <textarea name="edukasi_pasien" id="edukasi_pasien" class="form-control" rows="4"></textarea>
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
        // Toggle detail_kendaraan input based on transportasi selection
        $('input[name="transportasi"]').change(function() {
            if ($(this).val() === 'lainnya') {
                $('#detail_kendaraan').prop('disabled', false).focus();
            } else {
                $('#detail_kendaraan').prop('disabled', true).val('');
            }
        });
        $('input[name="transportasi"]:checked').trigger('change');

        // Toggle detail_keluarga input based on pendamping_keluarga checkbox
        $('#pendamping_keluarga').change(function() {
            if ($(this).is(':checked')) {
                $('#detail_keluarga').prop('disabled', false).focus();
            } else {
                $('#detail_keluarga').prop('disabled', true).val('');
            }
        });
        $('#pendamping_keluarga').trigger('change');

        // Toggle detail_alasan_lainnya input based on alasan_lainnya checkbox
        $('#alasan_lainnya').change(function() {
            if ($(this).is(':checked')) {
                $('#detail_alasan_lainnya').prop('disabled', false).focus();
            } else {
                $('#detail_alasan_lainnya').prop('disabled', true).val('');
            }
        });
        $('#alasan_lainnya').trigger('change');

        // Handle mutual exclusivity for pendamping_tidak_ada
        $('#pendamping_tidak_ada').change(function() {
            if ($(this).is(':checked')) {
                $('.pendamping-option').prop('checked', false).trigger('change');
            }
        });
        $('.pendamping-option').change(function() {
            if ($(this).is(':checked')) {
                $('#pendamping_tidak_ada').prop('checked', false);
            }
        });

        // Handle form submission
        $('#createRujukAntarRs form').submit(function() {
            let alergiData = [];
            $('#alergiListDisplay .alergi-item').each(function() {
                const name = $(this).data('name');
                const reaction = $(this).data('reaction');
                if (name) alergiData.push({ name: name, reaction: reaction });
            });
            $('#alergiInput').val(JSON.stringify(alergiData));

            let diagnosisData = [];
            $('#diagnoseListDisplay .diagnosis-item').each(function() {
                const name = $(this).data('name');
                if (name) diagnosisData.push({ name: name });
            });
            $('#diagnosisInput').val(JSON.stringify(diagnosisData));

            return true;
        });

        function addAlergiToList(name, reaction) {
            const alergiItem = `
                <div class="alergi-item card mb-2" data-name="${name}" data-reaction="${reaction}">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between">
                            <div><strong>${name}</strong><p class="m-0 text-muted">${reaction}</p></div>
                            <button type="button" class="btn btn-sm btn-danger remove-alergi"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>`;
            $('#alergiListDisplay').append(alergiItem);
        }

        function addDiagnosisToList(name) {
            const diagnosisItem = `
                <div class="diagnosis-item card mb-2" data-name="${name}">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between">
                            <div><p class="m-0">${name}</p></div>
                            <button type="button" class="btn btn-sm btn-danger remove-diagnosis"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>`;
            $('#diagnoseListDisplay').append(diagnosisItem);
        }

        $(document).on('click', '.add-alergi-btn', function() {
            const name = $('#alergi_name').val();
            const reaction = $('#alergi_reaction').val();
            if (name && reaction) {
                addAlergiToList(name, reaction);
                $('#alergi_name').val('').focus();
                $('#alergi_reaction').val('');
            }
        });

        $(document).on('click', '.add-diagnosis-btn', function() {
            const name = $('#diagnosis_name').val();
            if (name) {
                addDiagnosisToList(name);
                $('#diagnosis_name').val('').focus();
            }
        });

        $(document).on('click', '.remove-alergi, .remove-diagnosis', function() {
            $(this).closest('.card').remove();
        });
    });
</script>
@endpush
