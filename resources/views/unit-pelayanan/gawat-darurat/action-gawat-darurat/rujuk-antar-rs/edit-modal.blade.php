<!-- Modal Edit Rujukan Antar RS -->
<div class="modal fade" id="editRujukAntarRs" tabindex="-1" aria-labelledby="editRujukAntarRsLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editRujukAntarRsLabel">Edit Rujukan Antar Rumah Sakit</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->kd_pasien ?? '' }}">
                <input type="hidden" name="kd_unit" value="{{ $dataMedis->kd_unit ?? '3' }}">
                <input type="hidden" name="tgl_masuk" value="{{ $dataMedis->tgl_masuk ?? date('Y-m-d') }}">
                <input type="hidden" name="urut_masuk" value="{{ $dataMedis->urut_masuk ?? '' }}">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_jam" class="form-label">Jam</label>
                                <input type="time" name="jam" id="edit_jam" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Transportasi</label>
                                <div class="form-check">
                                    <input type="radio" name="transportasi" id="edit_transportasi_ambulans" value="ambulans" class="form-check-input">
                                    <label class="form-check-label" for="edit_transportasi_ambulans">Ambulans RS</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="radio" name="transportasi" id="edit_transportasi_lainnya" value="lainnya" class="form-check-input">
                                    <label class="form-check-label" for="edit_transportasi_lainnya">Kendaraan lainnya:</label>
                                </div>
                                <input type="text" name="detail_kendaraan" id="edit_detail_kendaraan" class="form-control" placeholder="Sebutkan kendaraan lainnya" disabled>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Nomor Polisi Kendaraan</label>
                                <input type="text" name="nomor_polisi" id="edit_nomor_polisi" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Pendamping</label>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_dokter" id="edit_pendamping_dokter" value="1" class="form-check-input edit-pendamping-option">
                                    <label class="form-check-label" for="edit_pendamping_dokter">Dokter</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_perawat" id="edit_pendamping_perawat" value="1" class="form-check-input edit-pendamping-option">
                                    <label class="form-check-label" for="edit_pendamping_perawat">Perawat</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="pendamping_keluarga" id="edit_pendamping_keluarga" value="1" class="form-check-input edit-pendamping-option">
                                    <label class="form-check-label" for="edit_pendamping_keluarga">Keluarga:</label>
                                </div>
                                <input type="text" name="detail_keluarga" id="edit_detail_keluarga" class="form-control" placeholder="Sebutkan hubungan keluarga" disabled>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="pendamping_tidak_ada" id="edit_pendamping_tidak_ada" value="1" class="form-check-input">
                                    <label class="form-check-label" for="edit_pendamping_tidak_ada">Tidak ada</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Tanda-tanda vital saat pindah</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Suhu:</label>
                                        <input type="number" name="suhu" id="edit_suhu" step="0.1" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Sistole:</label>
                                        <input type="number" name="sistole" id="edit_sistole" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Diastole:</label>
                                        <input type="number" name="diastole" id="edit_diastole" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Nadi:</label>
                                        <input type="number" name="nadi" id="edit_nadi" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Respirasi:</label>
                                        <input type="number" name="respirasi" id="edit_respirasi" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Status nyeri:</label>
                                            <input type="number" name="status_nyeri" id="edit_status_nyeri" min="0" max="10" class="form-control">
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
                                    <input type="checkbox" name="alasan_tempat_penuh" id="edit_alasan_tempat_penuh" value="1" class="form-check-input">
                                    <label class="form-check-label" for="edit_alasan_tempat_penuh">Tempat penuh</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_permintaan_keluarga" id="edit_alasan_permintaan_keluarga" value="1" class="form-check-input">
                                    <label class="form-check-label" for="edit_alasan_permintaan_keluarga">Permintaan keluarga</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_perawatan_khusus" id="edit_alasan_perawatan_khusus" value="1" class="form-check-input">
                                    <label class="form-check-label" for="edit_alasan_perawatan_khusus">Perawatan Khusus</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="alasan_lainnya" id="edit_alasan_lainnya" value="1" class="form-check-input">
                                    <label class="form-check-label" for="edit_alasan_lainnya">Lainnya:</label>
                                </div>
                                <input type="text" name="detail_alasan_lainnya" id="edit_detail_alasan_lainnya" class="form-control" placeholder="Sebutkan alasan lainnya" disabled>
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
                                            <label for="edit_alergi_name" class="form-label">Nama Alergi</label>
                                            <input type="text" id="edit_alergi_name" class="form-control" placeholder="Contoh: Penisilin">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="edit_alergi_reaction" class="form-label">Reaksi</label>
                                            <input type="text" id="edit_alergi_reaction" class="form-control" placeholder="Contoh: Ruam kulit">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary edit-add-alergi-btn">
                                            <i class="bi bi-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="edit_alergiListDisplay"></div>
                                    <input type="hidden" name="alergi" id="edit_alergiInput">
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
                                <textarea name="alasan_masuk_dirujuk" id="edit_alasan_masuk_dirujuk" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Hasil Pemeriksaan Penunjang Diagnostik</p>
                            <div class="form-group mt-3">
                                <textarea name="hasil_pemeriksaan_penunjang" id="edit_hasil_pemeriksaan_penunjang" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Terapi/ Pengobatan serta hasil konsultasi selama di Rumah Sakit</p>
                            <div class="form-group mt-3">
                                <textarea name="terapi" id="edit_terapi" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Diagnosis</p>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="edit_diagnosis_name" class="form-label">Diagnosis</label>
                                            <input type="text" id="edit_diagnosis_name" class="form-control" placeholder="Contoh: Asthma bronchiale">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary edit-add-diagnosis-btn">
                                            <i class="bi bi-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="edit_diagnoseListDisplay"></div>
                                    <input type="hidden" name="diagnosis" id="edit_diagnosisInput">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Tindakan / Prosedur:</p>
                            <div class="form-group mt-3">
                                <textarea name="tindakan" id="edit_tindakan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Edukasi pasien / keluarga: </p>
                            <div class="form-group mt-3">
                                <textarea name="edukasi_pasien" id="edit_edukasi_pasien" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
    // Handling edit button click
    $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const modal = $('#editRujukAntarRs');
        modal.find('form')[0].reset();
        const formAction = `/unit-pelayanan/gawat-darurat/pelayanan/{{ $dataMedis->kd_pasien }}/{{ $dataMedis->tgl_masuk }}/{{ $dataMedis->urut_masuk }}/rujuk-antar-rs/${id}`;
        modal.find('form').attr('action', formAction);
        modal.find('.modal-title').after('<div id="editLoadingIndicator" class="alert alert-info">Memuat data...</div>');

        $.ajax({
            url: `/unit-pelayanan/gawat-darurat/pelayanan/{{ $dataMedis->kd_pasien }}/{{ $dataMedis->tgl_masuk }}/{{ $dataMedis->urut_masuk }}/rujuk-antar-rs/${id}/edit`,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#editLoadingIndicator').remove();
                console.log("Edit data received:", data);
                fillFormWithData(data);
                initializeFormState();
            },
            error: function(xhr) {
                console.error("Error AJAX:", xhr);
                $('#editLoadingIndicator').remove();
                modal.find('.modal-title').after(`<div class="alert alert-danger">Error: ${xhr.status} - ${xhr.statusText}</div>`);
            }
        });
    });

    // Fill form with retrieved data
    function fillFormWithData(data) {
        setInputValue('edit_tanggal', data.tanggal);
        setInputValue('edit_jam', data.jam);
        document.getElementById('edit_transportasi_ambulans').checked = data.transportasi === 'ambulans';
        document.getElementById('edit_transportasi_lainnya').checked = data.transportasi === 'lainnya';
        setInputValue('edit_detail_kendaraan', data.detail_kendaraan);
        setInputValue('edit_nomor_polisi', data.nomor_polisi);

        // Pendamping checkboxes
        document.getElementById('edit_pendamping_dokter').checked = data.pendamping_dokter === '1';
        document.getElementById('edit_pendamping_perawat').checked = data.pendamping_perawat === '1';
        document.getElementById('edit_pendamping_keluarga').checked = data.pendamping_keluarga === '1';
        document.getElementById('edit_pendamping_tidak_ada').checked = data.pendamping_tidak_ada === '1';
        setInputValue('edit_detail_keluarga', data.detail_keluarga);

        // Tanda vital
        setInputValue('edit_suhu', data.suhu);
        setInputValue('edit_sistole', data.sistole);
        setInputValue('edit_diastole', data.diastole);
        setInputValue('edit_nadi', data.nadi);
        setInputValue('edit_respirasi', data.respirasi);
        setInputValue('edit_status_nyeri', data.status_nyeri);

        // Alasan checkboxes
        document.getElementById('edit_alasan_tempat_penuh').checked = data.alasan_tempat_penuh === '1';
        document.getElementById('edit_alasan_permintaan_keluarga').checked = data.alasan_permintaan_keluarga === '1';
        document.getElementById('edit_alasan_perawatan_khusus').checked = data.alasan_perawatan_khusus === '1';
        document.getElementById('edit_alasan_lainnya').checked = data.alasan_lainnya === '1';
        setInputValue('edit_detail_alasan_lainnya', data.detail_alasan_lainnya);

        // Text areas
        setTextareaValue('edit_alasan_masuk_dirujuk', data.alasan_masuk_dirujuk);
        setTextareaValue('edit_hasil_pemeriksaan_penunjang', data.hasil_pemeriksaan_penunjang);
        setTextareaValue('edit_terapi', data.terapi);
        setTextareaValue('edit_tindakan', data.tindakan);
        setTextareaValue('edit_edukasi_pasien', data.edukasi_pasien);

        // Trigger change events
        setTimeout(function() {
            $('input[name="transportasi"]').trigger('change');
            $('#edit_pendamping_keluarga').trigger('change');
            $('#edit_alasan_lainnya').trigger('change');
        }, 50);

        // Alergi
        $('#edit_alergiListDisplay').empty();
        if (data.alergi) {
            try {
                let alergiData = typeof data.alergi === 'string' ? JSON.parse(data.alergi) : data.alergi;
                alergiData.forEach(item => addEditAlergiToList(item.name, item.reaction));
                $('#edit_alergiInput').val(typeof data.alergi === 'string' ? data.alergi : JSON.stringify(alergiData));
            } catch (e) {
                console.error('Error parsing alergi data:', e);
            }
        }

        // Diagnosis - Modified to remove ICD codes
        $('#edit_diagnoseListDisplay').empty();
        if (data.diagnosis) {
            try {
                let diagnosisData = typeof data.diagnosis === 'string' ? JSON.parse(data.diagnosis) : data.diagnosis;
                diagnosisData.forEach(item => {
                    // Only use the diagnosis name, ignore the code
                    addEditDiagnosisToList(item.name);
                });

                // Convert existing data to the new format (without codes)
                const updatedDiagnosisData = diagnosisData.map(item => ({ name: item.name }));
                $('#edit_diagnosisInput').val(JSON.stringify(updatedDiagnosisData));
            } catch (e) {
                console.error('Error parsing diagnosis data:', e);
            }
        }
    }

    // Helper functions
    function setInputValue(id, value) {
        document.getElementById(id).value = value || '';
    }

    function setTextareaValue(id, value) {
        document.getElementById(id).value = value || '';
    }

    // Initialize form state based on current values
    function initializeFormState() {
        if (document.getElementById('edit_transportasi_lainnya').checked)
            $('#edit_detail_kendaraan').prop('disabled', false);
        else
            $('#edit_detail_kendaraan').prop('disabled', true).val('');

        if (document.getElementById('edit_pendamping_keluarga').checked)
            $('#edit_detail_keluarga').prop('disabled', false);
        else
            $('#edit_detail_keluarga').prop('disabled', true).val('');

        if (document.getElementById('edit_alasan_lainnya').checked)
            $('#edit_detail_alasan_lainnya').prop('disabled', false);
        else
            $('#edit_detail_alasan_lainnya').prop('disabled', true).val('');
    }

    // Event handlers for form elements
    $('input[name="transportasi"]').change(function() {
        if ($(this).val() === 'lainnya')
            $('#edit_detail_kendaraan').prop('disabled', false).focus();
        else
            $('#edit_detail_kendaraan').prop('disabled', true).val('');
    });

    $('#edit_pendamping_keluarga').change(function() {
        if ($(this).is(':checked'))
            $('#edit_detail_keluarga').prop('disabled', false).focus();
        else
            $('#edit_detail_keluarga').prop('disabled', true).val('');
    });

    $('#edit_alasan_lainnya').change(function() {
        if ($(this).is(':checked'))
            $('#edit_detail_alasan_lainnya').prop('disabled', false).focus();
        else
            $('#edit_detail_alasan_lainnya').prop('disabled', true).val('');
    });

    $('#edit_pendamping_tidak_ada').change(function() {
        if ($(this).is(':checked'))
            $('.edit-pendamping-option').prop('checked', false).trigger('change');
    });

    $('.edit-pendamping-option').change(function() {
        if ($(this).is(':checked'))
            $('#edit_pendamping_tidak_ada').prop('checked', false);
    });

    // Form submission handler
    $('#editRujukAntarRs form').submit(function() {
        // Process alergi data
        let alergiData = [];
        $('#edit_alergiListDisplay .alergi-item').each(function() {
            const name = $(this).data('name');
            const reaction = $(this).data('reaction');
            if (name) alergiData.push({ name: name, reaction: reaction });
        });
        $('#edit_alergiInput').val(JSON.stringify(alergiData));

        // Process diagnosis data - Modified to remove ICD codes
        let diagnosisData = [];
        $('#edit_diagnoseListDisplay .diagnosis-item').each(function() {
            const name = $(this).data('name');
            if (name) diagnosisData.push({ name: name });
        });
        $('#edit_diagnosisInput').val(JSON.stringify(diagnosisData));

        return true;
    });

    // Alergi handlers
    function addEditAlergiToList(name, reaction) {
        const alergiItem = `
            <div class="alergi-item card mb-2" data-name="${name}" data-reaction="${reaction}">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between">
                        <div><strong>${name}</strong><p class="m-0 text-muted">${reaction}</p></div>
                        <button type="button" class="btn btn-sm btn-danger remove-alergi"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>`;
        $('#edit_alergiListDisplay').append(alergiItem);
    }

    // Modified: Diagnosis handlers (removed code parameter)
    function addEditDiagnosisToList(name) {
        const diagnosisItem = `
            <div class="diagnosis-item card mb-2" data-name="${name}">
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between">
                        <div><p class="m-0">${name}</p></div>
                        <button type="button" class="btn btn-sm btn-danger remove-diagnosis"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>`;
        $('#edit_diagnoseListDisplay').append(diagnosisItem);
    }

    // Alergi add button handler
    $(document).on('click', '.edit-add-alergi-btn', function() {
        const name = $('#edit_alergi_name').val();
        const reaction = $('#edit_alergi_reaction').val();
        if (name && reaction) {
            addEditAlergiToList(name, reaction);
            $('#edit_alergi_name').val('').focus();
            $('#edit_alergi_reaction').val('');
        }
    });

    // Modified: Diagnosis add button handler (removed code input)
    $(document).on('click', '.edit-add-diagnosis-btn', function() {
        const name = $('#edit_diagnosis_name').val();
        if (name) {
            addEditDiagnosisToList(name);
            $('#edit_diagnosis_name').val('').focus();
        }
    });

    // Remove button handlers
    $(document).on('click', '.remove-alergi, .remove-diagnosis', function() {
        $(this).closest('.card').remove();
    });
});
</script>
@endpush
