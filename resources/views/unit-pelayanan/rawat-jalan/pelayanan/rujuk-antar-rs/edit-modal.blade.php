<!-- Modal Edit Rujukan Antar RS untuk Rawat Jalan -->
<div class="modal fade" id="editRujukAntarRsRawatJalan" tabindex="-1" aria-labelledby="editRujukAntarRsRawatJalanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editRujukAntarRsRawatJalanLabel">Edit Rujukan Antar Rumah Sakit (Rawat Jalan)</h5>
                <button type="button" class="btn-close btn-close-modified" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="editRujukAntarRsRawatJalanForm">
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
                                <label for="editTanggalRawatJalan" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="editTanggalRawatJalan" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editJamRawatJalan" class="form-label">Jam</label>
                                <input type="time" name="jam" id="editJamRawatJalan" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Transportasi</label>
                                <div class="form-check">
                                    <input type="radio" name="transportasi" id="editTransportasiAmbulansRawatJalan" value="ambulans" class="form-check-input">
                                    <label class="form-check-label" for="editTransportasiAmbulansRawatJalan">Ambulans RS</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="radio" name="transportasi" id="editTransportasiLainnyaRawatJalan" value="lainnya" class="form-check-input">
                                    <label class="form-check-label" for="editTransportasiLainnyaRawatJalan">Kendaraan lainnya:</label>
                                </div>
                                <input type="text" name="detail_kendaraan" id="editDetailKendaraanRawatJalan" class="form-control" placeholder="Sebutkan kendaraan lainnya" disabled>
                            </div>
                            <div class="form-group mt-3">
                                <label for="editNomorPolisiRawatJalan" class="form-label">Nomor Polisi Kendaraan</label>
                                <input type="text" name="nomor_polisi" id="editNomorPolisiRawatJalan" class="form-control">
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Pendamping</label>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_dokter" id="editPendampingDokterRawatJalan" value="1" class="form-check-input edit-pendamping-option-rawat-jalan">
                                    <label class="form-check-label" for="editPendampingDokterRawatJalan">Dokter</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="pendamping_perawat" id="editPendampingPerawatRawatJalan" value="1" class="form-check-input edit-pendamping-option-rawat-jalan">
                                    <label class="form-check-label" for="editPendampingPerawatRawatJalan">Perawat</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="pendamping_keluarga" id="editPendampingKeluargaRawatJalan" value="1" class="form-check-input edit-pendamping-option-rawat-jalan">
                                    <label class="form-check-label" for="editPendampingKeluargaRawatJalan">Keluarga:</label>
                                </div>
                                <input type="text" name="detail_keluarga" id="editDetailKeluargaRawatJalan" class="form-control" placeholder="Sebutkan hubungan keluarga" disabled>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="pendamping_tidak_ada" id="editPendampingTidakAdaRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="editPendampingTidakAdaRawatJalan">Tidak ada</label>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label class="form-label">Tanda-tanda vital saat pindah</label>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="editSuhuRawatJalan" class="form-label">Suhu:</label>
                                        <input type="number" name="suhu" id="editSuhuRawatJalan" step="0.1" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editSistoleRawatJalan" class="form-label">Sistole:</label>
                                        <input type="number" name="sistole" id="editSistoleRawatJalan" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editDiastoleRawatJalan" class="form-label">Diastole:</label>
                                        <input type="number" name="diastole" id="editDiastoleRawatJalan" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editNadiRawatJalan" class="form-label">Nadi:</label>
                                        <input type="number" name="nadi" id="editNadiRawatJalan" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="editRespirasiRawatJalan" class="form-label">Respirasi:</label>
                                        <input type="number" name="respirasi" id="editRespirasiRawatJalan" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="editStatusNyeriRawatJalan" class="form-label">Status nyeri:</label>
                                            <input type="number" name="status_nyeri" id="editStatusNyeriRawatJalan" min="0" max="10" class="form-control">
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
                                    <input type="checkbox" name="alasan_tempat_penuh" id="editAlasanTempatPenuhRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="editAlasanTempatPenuhRawatJalan">Tempat penuh</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_permintaan_keluarga" id="editAlasanPermintaanKeluargaRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="editAlasanPermintaanKeluargaRawatJalan">Permintaan keluarga</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="alasan_perawatan_khusus" id="editAlasanPerawatanKhususRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="editAlasanPerawatanKhususRawatJalan">Perawatan Khusus</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="alasan_lainnya" id="editAlasanLainnyaRawatJalan" value="1" class="form-check-input">
                                    <label class="form-check-label" for="editAlasanLainnyaRawatJalan">Lainnya:</label>
                                </div>
                                <input type="text" name="detail_alasan_lainnya" id="editDetailAlasanLainnyaRawatJalan" class="form-control" placeholder="Sebutkan alasan lainnya" disabled>
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
                                            <label for="editAlergiNameRawatJalan" class="form-label">Nama Alergi</label>
                                            <input type="text" id="editAlergiNameRawatJalan" class="form-control" placeholder="Contoh: Penisilin">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="editAlergiReactionRawatJalan" class="form-label">Reaksi</label>
                                            <input type="text" id="editAlergiReactionRawatJalan" class="form-control" placeholder="Contoh: Ruam kulit">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary edit-add-alergi-btn-rawat-jalan">
                                            <i class="bi bi-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="editAlergiListDisplayRawatJalan"></div>
                                    <input type="hidden" name="alergi" id="editAlergiInputRawatJalan">
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
                                <textarea name="alasan_masuk_dirujuk" id="editAlasanMasukDirujukRawatJalan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Hasil Pemeriksaan Penunjang -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Hasil Pemeriksaan Penunjang Diagnostik</p>
                            <div class="form-group mt-3">
                                <textarea name="hasil_pemeriksaan_penunjang" id="editHasilPemeriksaanPenunjangRawatJalan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Terapi/Pengobatan -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Terapi/Pengobatan serta hasil konsultasi selama di Rumah Sakit</p>
                            <div class="form-group mt-3">
                                <textarea name="terapi" id="editTerapiRawatJalan" class="form-control" rows="4"></textarea>
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
                                            <label for="editDiagnosisNameRawatJalan" class="form-label">Diagnosis</label>
                                            <input type="text" id="editDiagnosisNameRawatJalan" class="form-control" placeholder="Contoh: Asthma bronchiale">
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary edit-add-diagnosis-btn-rawat-jalan">
                                            <i class="bi bi-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="bg-secondary-subtle rounded-2 p-3" id="editDiagnoseListDisplayRawatJalan"></div>
                                    <input type="hidden" name="diagnosis" id="editDiagnosisInputRawatJalan">
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
                                <textarea name="tindakan" id="editTindakanRawatJalan" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Edukasi Pasien -->
                    <div class="border-bottom border-primary mt-3"></div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="fs-5 fw-bold">Edukasi pasien/keluarga</p>
                            <div class="form-group mt-3">
                                <textarea name="edukasi_pasien" id="editEdukasiPasienRawatJalan" class="form-control" rows="4"></textarea>
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
        // Handling edit button click untuk Rawat Jalan
        $(document).on('click', '.edit-btn-rawat-jalan', function() {
            const id = $(this).data('id');
            const modal = $('#editRujukAntarRsRawatJalan');
            modal.find('form')[0].reset();
            const formAction = `/unit-pelayanan/rawat-jalan/unit/{{ $dataMedis->kd_unit }}/pelayanan/{{ $dataMedis->kd_pasien }}/{{ $dataMedis->tgl_masuk }}/{{ $dataMedis->urut_masuk }}/rujuk-antar-rs/${id}`;
            modal.find('form').attr('action', formAction);
            modal.find('.modal-title').after('<div id="editLoadingIndicatorRawatJalan" class="alert alert-info">Memuat data...</div>');

            $.ajax({
                url: `/unit-pelayanan/rawat-jalan/unit/{{ $dataMedis->kd_unit }}/pelayanan/{{ $dataMedis->kd_pasien }}/{{ $dataMedis->tgl_masuk }}/{{ $dataMedis->urut_masuk }}/rujuk-antar-rs/${id}/edit`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#editLoadingIndicatorRawatJalan').remove();
                    console.log("Edit data received (Rawat Jalan):", data);
                    fillFormWithDataRawatJalan(data);
                    initializeFormStateRawatJalan();
                },
                error: function(xhr) {
                    console.error("Error AJAX (Rawat Jalan):", xhr);
                    $('#editLoadingIndicatorRawatJalan').remove();
                    modal.find('.modal-title').after(`<div class="alert alert-danger">Error: ${xhr.status} - ${xhr.statusText}</div>`);
                }
            });
        });

        // Fill form with retrieved data untuk Rawat Jalan
        function fillFormWithDataRawatJalan(data) {
            setInputValue('editTanggalRawatJalan', data.tanggal);
            setInputValue('editJamRawatJalan', data.jam);
            document.getElementById('editTransportasiAmbulansRawatJalan').checked = data.transportasi === 'ambulans';
            document.getElementById('editTransportasiLainnyaRawatJalan').checked = data.transportasi === 'lainnya';
            setInputValue('editDetailKendaraanRawatJalan', data.detail_kendaraan);
            setInputValue('editNomorPolisiRawatJalan', data.nomor_polisi);

            // Pendamping checkboxes
            document.getElementById('editPendampingDokterRawatJalan').checked = data.pendamping_dokter === '1';
            document.getElementById('editPendampingPerawatRawatJalan').checked = data.pendamping_perawat === '1';
            document.getElementById('editPendampingKeluargaRawatJalan').checked = data.pendamping_keluarga === '1';
            document.getElementById('editPendampingTidakAdaRawatJalan').checked = data.pendamping_tidak_ada === '1';
            setInputValue('editDetailKeluargaRawatJalan', data.detail_keluarga);

            // Tanda vital
            setInputValue('editSuhuRawatJalan', data.suhu);
            setInputValue('editSistoleRawatJalan', data.sistole);
            setInputValue('editDiastoleRawatJalan', data.diastole);
            setInputValue('editNadiRawatJalan', data.nadi);
            setInputValue('editRespirasiRawatJalan', data.respirasi);
            setInputValue('editStatusNyeriRawatJalan', data.status_nyeri);

            // Alasan checkboxes
            document.getElementById('editAlasanTempatPenuhRawatJalan').checked = data.alasan_tempat_penuh === '1';
            document.getElementById('editAlasanPermintaanKeluargaRawatJalan').checked = data.alasan_permintaan_keluarga === '1';
            document.getElementById('editAlasanPerawatanKhususRawatJalan').checked = data.alasan_perawatan_khusus === '1';
            document.getElementById('editAlasanLainnyaRawatJalan').checked = data.alasan_lainnya === '1';
            setInputValue('editDetailAlasanLainnyaRawatJalan', data.detail_alasan_lainnya);

            // Text areas
            setTextareaValue('editAlasanMasukDirujukRawatJalan', data.alasan_masuk_dirujuk);
            setTextareaValue('editHasilPemeriksaanPenunjangRawatJalan', data.hasil_pemeriksaan_penunjang);
            setTextareaValue('editTerapiRawatJalan', data.terapi);
            setTextareaValue('editTindakanRawatJalan', data.tindakan);
            setTextareaValue('editEdukasiPasienRawatJalan', data.edukasi_pasien);

            // Trigger change events
            setTimeout(function() {
                $('input[name="transportasi"]').trigger('change');
                $('#editPendampingKeluargaRawatJalan').trigger('change');
                $('#editAlasanLainnyaRawatJalan').trigger('change');
            }, 50);

            // Alergi
            $('#editAlergiListDisplayRawatJalan').empty();
            if (data.alergi) {
                try {
                    let alergiData = typeof data.alergi === 'string' ? JSON.parse(data.alergi) : data.alergi;
                    alergiData.forEach(item => addEditAlergiToListRawatJalan(item.name, item.reaction));
                    $('#editAlergiInputRawatJalan').val(typeof data.alergi === 'string' ? data.alergi : JSON.stringify(alergiData));
                } catch (e) {
                    console.error('Error parsing alergi data (Rawat Jalan):', e);
                }
            }

            // Diagnosis
            $('#editDiagnoseListDisplayRawatJalan').empty();
            if (data.diagnosis) {
                try {
                    let diagnosisData = typeof data.diagnosis === 'string' ? JSON.parse(data.diagnosis) : data.diagnosis;
                    diagnosisData.forEach(item => addEditDiagnosisToListRawatJalan(item.name));
                    const updatedDiagnosisData = diagnosisData.map(item => ({ name: item.name }));
                    $('#editDiagnosisInputRawatJalan').val(JSON.stringify(updatedDiagnosisData));
                } catch (e) {
                    console.error('Error parsing diagnosis data (Rawat Jalan):', e);
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

        // Initialize form state untuk Rawat Jalan
        function initializeFormStateRawatJalan() {
            if (document.getElementById('editTransportasiLainnyaRawatJalan').checked)
                $('#editDetailKendaraanRawatJalan').prop('disabled', false);
            else
                $('#editDetailKendaraanRawatJalan').prop('disabled', true).val('');

            if (document.getElementById('editPendampingKeluargaRawatJalan').checked)
                $('#editDetailKeluargaRawatJalan').prop('disabled', false);
            else
                $('#editDetailKeluargaRawatJalan').prop('disabled', true).val('');

            if (document.getElementById('editAlasanLainnyaRawatJalan').checked)
                $('#editDetailAlasanLainnyaRawatJalan').prop('disabled', false);
            else
                $('#editDetailAlasanLainnyaRawatJalan').prop('disabled', true).val('');
        }

        // Event handlers untuk form elements
        $('input[name="transportasi"]').change(function() {
            if ($(this).val() === 'lainnya')
                $('#editDetailKendaraanRawatJalan').prop('disabled', false).focus();
            else
                $('#editDetailKendaraanRawatJalan').prop('disabled', true).val('');
        });

        $('#editPendampingKeluargaRawatJalan').change(function() {
            if ($(this).is(':checked'))
                $('#editDetailKeluargaRawatJalan').prop('disabled', false).focus();
            else
                $('#editDetailKeluargaRawatJalan').prop('disabled', true).val('');
        });

        $('#editAlasanLainnyaRawatJalan').change(function() {
            if ($(this).is(':checked'))
                $('#editDetailAlasanLainnyaRawatJalan').prop('disabled', false).focus();
            else
                $('#editDetailAlasanLainnyaRawatJalan').prop('disabled', true).val('');
        });

        $('#editPendampingTidakAdaRawatJalan').change(function() {
            if ($(this).is(':checked'))
                $('.edit-pendamping-option-rawat-jalan').prop('checked', false).trigger('change');
        });

        $('.edit-pendamping-option-rawat-jalan').change(function() {
            if ($(this).is(':checked'))
                $('#editPendampingTidakAdaRawatJalan').prop('checked', false);
        });

        // Form submission handler untuk Rawat Jalan
        $('#editRujukAntarRsRawatJalan form').submit(function() {
            let alergiData = [];
            $('#editAlergiListDisplayRawatJalan .alergi-item-rawat-jalan').each(function() {
                const name = $(this).data('name');
                const reaction = $(this).data('reaction');
                if (name) alergiData.push({ name: name, reaction: reaction });
            });
            $('#editAlergiInputRawatJalan').val(JSON.stringify(alergiData));

            let diagnosisData = [];
            $('#editDiagnoseListDisplayRawatJalan .diagnosis-item-rawat-jalan').each(function() {
                const name = $(this).data('name');
                if (name) diagnosisData.push({ name: name });
            });
            $('#editDiagnosisInputRawatJalan').val(JSON.stringify(diagnosisData));

            return true;
        });

        // Alergi handlers untuk Rawat Jalan
        function addEditAlergiToListRawatJalan(name, reaction) {
            const alergiItem = `
                <div class="alergi-item-rawat-jalan card mb-2" data-name="${name}" data-reaction="${reaction}">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between">
                            <div><strong>${name}</strong><p class="m-0 text-muted">${reaction}</p></div>
                            <button type="button" class="btn btn-sm btn-danger remove-alergi-rawat-jalan"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>`;
            $('#editAlergiListDisplayRawatJalan').append(alergiItem);
        }

        // Diagnosis handlers untuk Rawat Jalan
        function addEditDiagnosisToListRawatJalan(name) {
            const diagnosisItem = `
                <div class="diagnosis-item-rawat-jalan card mb-2" data-name="${name}">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between">
                            <div><p class="m-0">${name}</p></div>
                            <button type="button" class="btn btn-sm btn-danger remove-diagnosis-rawat-jalan"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>`;
            $('#editDiagnoseListDisplayRawatJalan').append(diagnosisItem);
        }

        // Alergi add button handler untuk Rawat Jalan
        $(document).on('click', '.edit-add-alergi-btn-rawat-jalan', function() {
            const name = $('#editAlergiNameRawatJalan').val();
            const reaction = $('#editAlergiReactionRawatJalan').val();
            if (name && reaction) {
                addEditAlergiToListRawatJalan(name, reaction);
                $('#editAlergiNameRawatJalan').val('').focus();
                $('#editAlergiReactionRawatJalan').val('');
            }
        });

        // Diagnosis add button handler untuk Rawat Jalan
        $(document).on('click', '.edit-add-diagnosis-btn-rawat-jalan', function() {
            const name = $('#editDiagnosisNameRawatJalan').val();
            if (name) {
                addEditDiagnosisToListRawatJalan(name);
                $('#editDiagnosisNameRawatJalan').val('').focus();
            }
        });

        // Remove button handlers untuk Rawat Jalan
        $(document).on('click', '.remove-alergi-rawat-jalan, .remove-diagnosis-rawat-jalan', function() {
            $(this).closest('.card').remove();
        });
    });
</script>
@endpush
