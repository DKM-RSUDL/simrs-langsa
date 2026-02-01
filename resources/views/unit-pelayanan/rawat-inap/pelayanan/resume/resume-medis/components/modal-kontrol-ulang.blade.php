<div class="modal fade" id="modal-create-kontrol-ulang" tabindex="-1" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallModalLabel">Poli Pengobatan Lanjutan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="form-group mb-3">
                    <label for="unit-kontrol" class="form-label">Poli</label>
                    <select name="unit_kontrol_ulang" id="unit-kontrol" class="form-select">
                        <option value="">--Pilih Poli--</option>
                        @foreach ($unitKonsul as $unit)
                            <option value="{{ $unit->kd_unit }}" @selected($unit->kd_unit == $dataResume->poli_pengobatan_lanjutan)>{{ $unit->nama_unit }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="kontrol-ulang" class="form-label">Tanggal Kontrol</label>
                    <input type="date" class="form-control" id="kontrol-ulang" name="tgl_kontrol_ulang"
                        value="{{ !empty($dataResume->tgl_pengobatan_lanjutan) ? date('Y-m-d', strtotime($dataResume->tgl_pengobatan_lanjutan)) : '' }}" min="{{ !empty($dataResume->tgl_pengobatan_lanjutan) ? date('Y-m-d', strtotime($dataResume->tgl_pengobatan_lanjutan)) : date('Y-m-d') }}">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" id="btn-simpan-kontrol">Simpan</button>
            </div>
        </div>
    </div>
</div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            // Handler modal
            $('#btnPoliLanjutan').on('click', function() {
                // $(this).find('input[type="radio"]').prop('checked', true);
                $('#modal-create-kontrol-ulang').modal('show');
            });

            // Handler tombol simpan
            $('#btn-simpan-kontrol').on('click', function() {
                let selectedDate = $('#kontrol-ulang').val();
                let selectedUnit = $('#unit-kontrol').val();
                let unitText = $('#unit-kontrol option:selected').text();

                if (selectedDate && selectedUnit) {
                    $('#selected-date').text(selectedDate);
                    $('#poli-lanjutan-info').text(`(${selectedDate} -- ${unitText})`);
                    $('#modal-create-kontrol-ulang').modal('hide');
                } else {
                    alert('Silahkan isi inputan secara lengkap !');
                }
            });
        });
    </script>
@endpush
