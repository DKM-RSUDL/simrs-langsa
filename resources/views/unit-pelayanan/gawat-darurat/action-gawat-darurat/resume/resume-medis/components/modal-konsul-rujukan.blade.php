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
                        <select id="kd_dokter" name="kd_dokter" class="form-select" disabled>
                            @foreach ($dataDokter as $d)
                                @if($d->dokter->kd_karyawan == auth()->user()->kd_karyawan)
                                    <option value="{{ $d->dokter->kd_dokter }}" selected>
                                        {{ $d->dokter->nama_lengkap }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <input type="hidden" name="kd_dokter" value="{{ $dataDokter->where('dokter.kd_karyawan', auth()->user()->kd_karyawan)->first()->dokter->kd_dokter }}">

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
                            <label for="unit_tujuan" class="form-label fw-bold h5 text-dark">Kepada Unit Pelayanan
                                :</label>
                            <select id="unit_tujuan" name="unit_tujuan"
                                class="form-select select2 @error('unit_tujuan') is-invalid @enderror">
                                <option value="">-Pilih Unit Pelayanan-</option>
                                @foreach ($unitKonsul as $unt)
                                    <option value="{{ $unt->kd_unit }}">{{ $unt->nama_unit }}</option>
                                @endforeach
                            </select>
                            @error('unit_tujuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <label for="dokter_unit_tujuan" class="form-label fw-bold h5 text-dark">Yth Dokter
                                :</label>
                            <select id="dokter_unit_tujuan" name="dokter_unit_tujuan"
                                class="form-select select2 @error('dokter_unit_tujuan') is-invalid @enderror">
                                <option value="">--Pilih Dokter--</option>
                            </select>
                            @error('dokter_unit_tujuan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
    // Inisialisasi Select2 untuk semua select
    $('.select2').select2({
        width: '100%'
    });

    // Inisialisasi
    const previousUnitId = '{{ $dataResume->rmeResumeDet->unit_rujuk_internal ?? '' }}';
    const dokterContainer = $('#dokter_container');

    // Sembunyikan container dokter saat awal
    dokterContainer.hide();

    // Nilai awal jika ada
    if (previousUnitId) {
        $('#unit_tujuan').val(previousUnitId).trigger('change');
    }

    // Event saat modal dibuka
    $('#btn-konsul-rujukan').on('click', function(e) {
        e.preventDefault();
        $('#konsul').prop('checked', true);
        $('#modal-konsul-rujukan').modal('show');
    });

    // Event saat unit dipilih/diubah
    $('#unit_tujuan').on('change', function() {
        const unitId = $(this).val();
        const dokterSelect = $('#dokter_unit_tujuan');
        const selectedUnitText = $(this).find("option:selected").text();

        // Reset dan sembunyikan dokter jika tidak ada unit dipilih
        if (!unitId) {
            dokterSelect.empty().append('<option value="">--Pilih Dokter--</option>');
            // Reset text di radio button
            $('#selected-unit-tujuan').text('').attr('data-unit-id', '');
            updateKonsulText();
            return;
        }

        // Update text unit di radio button
        $('#selected-unit-tujuan')
            .text(selectedUnitText)
            .attr('data-unit-id', unitId);
        updateKonsulText();

        // Ajax request untuk mendapatkan dokter
        $.ajax({
            type: "POST",
            url: "{{ route('konsultasi.get-dokter-unit', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk]) }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "kd_unit": unitId
            },
            dataType: "json",
            beforeSend: function() {
                dokterSelect.prop('disabled', true);
                dokterSelect.empty().append('<option value="">Loading...</option>');
            },
            success: function(response) {
                dokterSelect.empty().append('<option value="">--Pilih Dokter--</option>');

                if (response.status === 'success' && response.data && response.data.length > 0) {
                    response.data.forEach(function(item) {
                        dokterSelect.append(
                            `<option value="${item.dokter.kd_dokter}">${item.dokter.nama_lengkap}</option>`
                        );
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi',
                        text: 'Tidak ada dokter yang tersedia di unit ini'
                    });
                }
            },
            error: function(xhr) {
                dokterSelect.empty().append('<option value="">--Pilih Dokter--</option>');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat data dokter'
                });
            },
            complete: function() {
                dokterSelect.prop('disabled', false);
                dokterSelect.trigger('change');
            }
        });
    });

    // Event saat dokter dipilih
    $('#dokter_unit_tujuan').on('change', function() {
        updateKonsulText();
    });

    // Fungsi untuk update text konsul
    function updateKonsulText() {
        const selectedUnit = $('#unit_tujuan option:selected').text().trim();
        const selectedDokter = $('#dokter_unit_tujuan option:selected').text().trim();
        let konsulText = 'Konsul/Rujuk Internal Ke: ' + selectedUnit;

        if (selectedDokter && selectedDokter !== '--Pilih Dokter--') {
            konsulText += ' - Dr. ' + selectedDokter;
        }

        $('#konsul').val(konsulText);

        // Tampilkan unit yang dipilih
        if (selectedUnit && selectedUnit !== '-Pilih Unit Pelayanan-') {
            $('#selected-unit-tujuan').text(selectedUnit);
        } else {
            $('#selected-unit-tujuan').text('');
        }
    }

    // Set tanggal dan jam otomatis saat modal dibuka
    $('#btn-konsul-rujukan').on('click', function(e) {
        e.preventDefault();
        $('#konsul').prop('checked', true);

        // Set tanggal hari ini
        const today = new Date();
        const date = today.toISOString().split('T')[0];
        $('#tgl_konsul').val(date);

        // Set jam saat ini
        const hours = String(today.getHours()).padStart(2, '0');
        const minutes = String(today.getMinutes()).padStart(2, '0');
        $('#jam_konsul').val(`${hours}:${minutes}`);

        $('#modal-konsul-rujukan').modal('show');
    });

    // Handler simpan data
    $('#btn-simpan-konsul-rujukan').on('click', function() {
        // Ambil nilai form
        const formData = {
            unit_tujuan: $('#unit_tujuan').val(),
            dokter_unit_tujuan: $('#dokter_unit_tujuan').val(),
            tgl_konsul: $('#tgl_konsul').val(),
            jam_konsul: $('#jam_konsul').val(),
            konsulen_harap: $('input[name="kd_konsulen_diharapkan"]:checked').val(),
            catatan: $('textarea[name="catatan"]').val(),
            konsul: $('textarea[name="konsul"]').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        // Validasi
        if (!formData.unit_tujuan || formData.unit_tujuan === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silahkan pilih unit pelayanan terlebih dahulu!'
            });
            return;
        }

        if ($('#dokter_container').is(':visible') && (!formData.dokter_unit_tujuan || formData.dokter_unit_tujuan === "")) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Silahkan pilih dokter terlebih dahulu!'
            });
            return;
        }

        if (!formData.tgl_konsul || !formData.jam_konsul || !formData.konsulen_harap) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Mohon lengkapi semua field yang diperlukan!'
            });
            return;
        }

        // Update UI
        const selectedUnit = $('#unit_tujuan option:selected').text().trim();
        const selectedDokter = $('#dokter_unit_tujuan option:selected').text().trim();

        let konsulText = 'Konsul/Rujuk Internal Ke: ' + selectedUnit;
        if (selectedDokter) {
            konsulText += ' - Dr. ' + selectedDokter;
        }

        $('#konsul').prop('checked', true).val(konsulText);
        $('#modal-konsul-rujukan').modal('hide');
    });

    // Reset form saat modal ditutup
    $('#modal-konsul-rujukan').on('hidden.bs.modal', function() {
        if (!$('#selected-unit-tujuan').text().trim()) {
            $('#konsul').prop('checked', false);
        }
    });
});

</script>
