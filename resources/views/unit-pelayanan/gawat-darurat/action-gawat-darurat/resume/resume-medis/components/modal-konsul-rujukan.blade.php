<div class="modal fade" id="modal-konsul-rujukan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Konsultasi/ Rujukan Intern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-5">
                        <label for="dokter_pengirim" class="form-label fw-bold">Dokter Pengirim:</label>
                        <select name="kd_dokter" id="dokter_pengirim" class="form-select">
                            <option value="">-Pilih Dokter Pengirim-</option>
                            @foreach ($dataDokter as $dok)
                                <option value="{{ $dok->dokter->kd_dokter }}"
                                    {{ $dokterPengirim->dokter->kd_dokter == $dok->dokter->kd_dokter ? 'selected' : '' }}>
                                    {{ $dok->dokter->nama_lengkap }}
                                    {{ $dokterPengirim->dokter->kd_dokter == $dok->dokter->kd_dokter ? '(Dokter Saat Ini)' : '' }}
                                </option>
                            @endforeach
                        </select>

                        @error('dokter_pengirim')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-7">
                                    <label for="tgl_konsul" class="form-label fw-bold h5 text-dark">Tanggal Konsul
                                        :</label>
                                    <input type="date" id="tgl_konsul" name="tgl_konsul"
                                        class="form-control @error('tgl_konsul') is-invalid @enderror">
                                </div>
                                <div class="col-5">
                                    <label for="jam_konsul" class="form-label fw-bold h5 text-dark">Jam :</label>
                                    <input type="time" id="jam_konsul" name="jam_konsul"
                                        class="form-control @error('jam_konsul') is-invalid @enderror">
                                </div>
                            </div>

                            @error('tgl_konsul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            @error('jam_konsul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="unit_tujuan">Kepada Unit Pelayanan:</label>
                            <select name="kd_unit_tujuan" id="unit_tujuan" class="form-select" required>
                                <option value="">-Pilih Unit Pelayanan-</option>
                                @foreach ($unitKonsul as $unt)
                                    <option value="{{ $unt->kd_unit }}" data-id="{{ $unt->kd_unit }}"
                                        {{ ($dataResume->rmeResumeDet->unit_rujuk_internal ?? '') == $unt->id ? 'selected' : '' }}>
                                        {{ $unt->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit_tujuan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="kd_dokter_tujuan" class="form-label fw-bold">Yth Dokter :</label>
                            <select name="kd_dokter_tujuan" id="kd_dokter_tujuan" class="form-select">
                                <option value="">-Pilih Dokter Pengirim-</option>
                                @foreach ($dataDokter as $dok)
                                    <option value="{{ $dok->dokter->kd_dokter }}"
                                        {{ $dokterPengirim->dokter->kd_dokter == $dok->dokter->kd_dokter ? 'selected' : '' }}>
                                        {{ $dok->dokter->nama_lengkap }}
                                        {{ $dokterPengirim->dokter->kd_dokter == $dok->dokter->kd_dokter ? '(Dokter Saat Ini)' : '' }}
                                    </option>
                                @endforeach
                            </select>

                            @error('kd_dokter_tujuan')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <h6 class="fw-bold">Konsulen diharapkan</h6>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="kd_konsulen_diharapkan" value="1" id="konsul-sewaktu"
                                    @if (isset($dataResume) && isset($dataResume->konsultasi) && $dataResume->konsultasi->kd_konsulen_diharapkan == 1) checked @endif>
                                <label class="form-check-label" for="konsul-sewaktu">
                                    Konsul Sewaktu
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="kd_konsulen_diharapkan" value="2" id="rawat-bersama"
                                    @if (isset($dataResume) && isset($dataResume->konsultasi) && $dataResume->konsultasi->kd_konsulen_diharapkan == 2) checked @endif>
                                <label class="form-check-label" for="rawat-bersama">
                                    Rawat Bersama
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="kd_konsulen_diharapkan" value="3" id="alih-rawat"
                                    @if (isset($dataResume) && isset($dataResume->konsultasi) && $dataResume->konsultasi->kd_konsulen_diharapkan == 3) checked @endif>
                                <label class="form-check-label" for="alih-rawat">
                                    Alih Rawat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="kd_konsulen_diharapkan" value="4" id="kembali-unit-asal"
                                    @if (isset($dataResume) && isset($dataResume->konsultasi) && $dataResume->konsultasi->kd_konsulen_diharapkan == 4) checked @endif>
                                <label class="form-check-label" for="kembali-unit-asal">
                                    kembali ke unit yang meminta untuk persetujuan tindakan & pengobatan
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="col-7">
                        <div class="mb-3">
                            <strong class="fw-bold">Catatan Klinik/Diagnosis</strong>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="catatan">{{ $dataResume->konsultasi->catatan ?? '-' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <strong class="fw-bold">Catatan Klinik/Konsul</strong>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="konsul">{{ $dataResume->konsultasi->konsul ?? '-' }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-simpan-konsul-rujukan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi
        const previousUnitId = '{{ $dataResume->rmeResumeDet->unit_rujuk_internal ?? '' }}';

        // nilai awal jika ada
        if (previousUnitId) {
            $('#unit_tujuan').val(previousUnitId);
        }

        $('#btn-konsul-rujukan').on('click', function(e) {
            e.preventDefault();
            $('#konsul').prop('checked', true);
            $('#modal-konsul-rujukan').modal('show');
        });

        // simpan pilihan unit
        $('#btn-simpan-konsul-rujukan').on('click', function() {
            const selectedUnit = $('#unit_tujuan');
            const unitId = selectedUnit.val();
            const unitName = selectedUnit.find('option:selected').text().trim();

            // Validasi
            if (!unitId || unitId === "" || unitId === "-Pilih Unit Pelayanan-") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan pilih unit pelayanan terlebih dahulu!'
                });
                return;
            }

            // Update
            $('#selected-unit-tujuan')
                .text(unitName)
                .attr('data-unit-id', unitId);

            // Update radio
            $('#konsul')
                .prop('checked', true)
                .val('Konsul/Rujuk Internal Ke: ' + unitName);

            $('#modal-konsul-rujukan').modal('hide');
        });

        $('#modal-konsul-rujukan').on('hidden.bs.modal', function() {
            if (!$('#selected-unit-tujuan').text().trim()) {
                $('#konsul').prop('checked', false);
            }
        });
    });

    // tambah konsultasi untuk store ke databases.
    const kd_pasien = '{{ $dataMedis->kd_pasien }}';
    const tgl_masuk = '{{ $dataMedis->tgl_masuk }}';
    const urut_masuk = '{{ $dataMedis->urut_masuk }}';

    $(document).ready(function() {
        // Updated AJAX submission
        $('#btn-simpan-konsul-rujukan').on('click', function() {
            // Get all form values
            const formData = {
                dokter_pengirim: $('#dokter_pengirim').val(), // kd_dokter
                dokter_unit_tujuan: $('#kd_dokter_tujuan').val(), // kd_dokter_tujuan
                tgl_konsul: $('#tgl_konsul').val(), // tgl_masuk_tujuan
                jam_konsul: $('#jam_konsul').val(), // jam_masuk_tujuan
                unit_tujuan: $('#unit_tujuan').val(), // kd_unit_tujuan
                konsulen_harap: $('input[name="kd_konsulen_diharapkan"]:checked')
            .val(), // kd_konsulen_diharapkan
                catatan: $('textarea[name="catatan"]').val(), // catatan
                konsul: $('textarea[name="konsul"]').val(), // konsul
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            // Basic validation
            if (!formData.unit_tujuan || !formData.tgl_konsul || !formData.jam_konsul ||
                !formData.dokter_pengirim || !formData.dokter_unit_tujuan || !formData.konsulen_harap) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Mohon lengkapi semua field yang diperlukan!'
                });
                return;
            }

            // Add loading state
            const btnSimpan = $(this);
            btnSimpan.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
            );

            // Send Ajax request
            $.ajax({
                url: `/unit-pelayanan/gawat-darurat/pelayanan/${kd_pasien}/${tgl_masuk}/resume`,
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Success:', response);
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Close modal
                                $('#modal-konsul-rujukan').modal('hide');
                                // Reload page to refresh data
                                // location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    let errorMessage = 'Terjadi kesalahan dalam menyimpan data';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                },
                complete: function() {
                    // Reset button state
                    btnSimpan.prop('disabled', false).html('Simpan');
                }
            });
        });
    });
</script>
