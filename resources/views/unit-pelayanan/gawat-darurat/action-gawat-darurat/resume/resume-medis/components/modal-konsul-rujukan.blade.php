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
                        <select name="dokter_pengirim" id="dokter_pengirim" class="form-select">
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
                        <div class="mt-2 text-muted">
                            <small>Dokter saat ini: {{ $dokterPengirim->dokter->nama_lengkap }}</small>
                        </div>

                        <div class="mt-3">
                            <label for="tgl_order" class="form-label fw-bold h5 text-dark">Tanggal Konsul & Jam
                                :</label>
                            <input type="datetime-local" id="tgl_order" name="tgl_order" class="form-control"
                                value="{{ old('tgl_order', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div class="mt-3">
                            <label for="unit_tujuan">Kepada Unit Pelayanan:</label>
                            <select name="unit_tujuan" id="unit_tujuan" class="form-select" required>
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
                            <div class="mt-2 text-muted">
                                <small>Dokter saat ini: {{ $dokterPengirim->dokter->nama_lengkap }}</small>
                            </div>
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

                            <!-- Tampilkan informasi dokter saat ini -->
                            <div class="mt-2 text-muted">
                                <small>Dokter saat ini:
                                    @if ($dokterPengirim->dokter)
                                        {{ $dokterPengirim->dokter->nama_lengkap }}
                                    @endif
                                </small>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h6 class="fw-bold">Konsulen diharapkan</h6>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="konsulen_harap" value="1" id="konsul-sewaktu"
                                    @if ($dataResume->konsultasi->kd_konsulen_diharapkan == 1) checked @endif>
                                <label class="form-check-label" for="konsul-sewaktu">
                                    Konsul Sewaktu
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="konsulen_harap" value="2" id="rawat-bersama"
                                    @if ($dataResume->konsultasi->kd_konsulen_diharapkan == 2) checked @endif>
                                <label class="form-check-label" for="rawat-bersama">
                                    Rawat Bersama
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="konsulen_harap" value="3" id="alih-rawat"
                                    @if ($dataResume->konsultasi->kd_konsulen_diharapkan == 3) checked @endif>
                                <label class="form-check-label" for="alih-rawat">
                                    Alih Rawat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('konsulen_harap') is-invalid @enderror"
                                    type="radio" name="konsulen_harap" value="4" id="kembali-unit-asal"
                                    @if ($dataResume->konsultasi->kd_konsulen_diharapkan == 4) checked @endif>
                                <label class="form-check-label" for="kembali-unit-asal">
                                    kembali ke unit yang meminta untuk persetujuan tindakan & pengobatan
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="col-7">
                        <div class="mb-3">
                            <strong class="fw-bold">Catatan Klinik/Diagnosis</strong>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $dataResume->konsultasi->catatan ?? '-' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <strong class="fw-bold">Catatan Klinik/Konsul</strong>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="5">{{ $dataResume->konsultasi->konsul ?? '-' }}</textarea>
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
</script>
