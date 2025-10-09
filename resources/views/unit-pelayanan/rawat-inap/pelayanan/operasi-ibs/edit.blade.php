@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Edit Operasi (IBS)',
                    'description' => 'Edit data operasi (IBS) pasien rawat inap.',
                ])

                <form
                    action="{{ route('rawat-inap.operasi-ibs.update', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $operasi->tgl_op, $operasi->jam_op]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="tanggal_registrasi" class="form-label">Tgl. Registrasi</label>
                                <input type="date" class="form-control" id="tanggal_registrasi" name="tanggal_registrasi"
                                    value="{{ $operasi->tgl_op ? date('Y-m-d', strtotime($operasi->tgl_op)) : date('Y-m-d') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-7 col-md-5">
                            <div class="mb-3">
                                <label for="tanggal_jadwal" class="form-label">Tgl. Jadwal</label>
                                <input type="date" class="form-control" id="tanggal_jadwal" name="tanggal_jadwal"
                                    value="{{ $operasi->tgl_jadwal ? date('Y-m-d', strtotime($operasi->tgl_jadwal)) : date('Y-m-d') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-5 col-md-2">
                            <div class="mb-3">
                                <label for="jam_operasi" class="form-label">Jam Operasi</label>
                                <input type="time" class="form-control" id="jam_operasi" name="jam_operasi"
                                    value="{{ $operasi->jam_op ? date('H:i', strtotime($operasi->jam_op)) : date('H:i') }}"
                                    required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_tindakan" class="form-label">Jenis Tindakan</label>
                                <select class="form-select select2" id="jenis_tindakan" name="jenis_tindakan" required>
                                    <option value="">-- Pilih Tindakan --</option>
                                    @foreach ($products ?? [] as $prod)
                                        <option value="{{ $prod->kd_produk }}"
                                            {{ $operasi->kd_produk == $prod->kd_produk ? 'selected' : '' }}>
                                            {{ $prod->deskripsi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_operasi" class="form-label">Jenis Operasi</label>
                                <select class="form-select" id="jenis_operasi" name="jenis_operasi" required>
                                    <option value="">-- Pilih Jenis Operasi --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                <select class="form-select" id="spesialisasi" name="spesialisasi" required>
                                    <option value="">-- Pilih Spesialisasi --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sub_spesialisasi" class="form-label">Sub Spesialisasi</label>
                                <select class="form-select" id="sub_spesialisasi" name="sub_spesialisasi" required>
                                    <option value="">-- Pilih Sub Spesialisasi --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kamar_operasi" class="form-label">Kamar Operasi</label>
                                <select class="form-select select2" id="kamar_operasi" name="kamar_operasi" required>
                                    <option value="">-- Pilih Kamar Operasi --</option>
                                    @foreach ($kamarOperasi ?? [] as $kr)
                                        <option value="{{ $kr->no_kamar }}"
                                            {{ ($operasi->no_kamar ?? $operasi->kd_unit_kamar) == $kr->no_kamar ? 'selected' : '' }}>
                                            {{ $kr->nama_kamar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dokter" class="form-label">Dokter</label>
                                <select class="form-select select2" id="dokter" name="dokter" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach ($dokters ?? [] as $d)
                                        <option value="{{ $d->kd_dokter }}"
                                            {{ $operasi->kd_dokter == $d->kd_dokter ? 'selected' : '' }}>
                                            {{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="diagnosa_medis" class="form-label">Diagnosis Medis</label>
                                <input type="text" class="form-control" id="diagnosa_medis" name="diagnosa_medis"
                                    placeholder="Masukkan diagnosis medis..." value="{{ $operasi->diagnosis ?? '' }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan...">{{ $operasi->catatan ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="text-end">
                            <x-button-submit />
                        </div>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(function() {
            // URL sudah include 4 parameter wajib dari route helper
            const url =
                "{{ route('rawat-inap.operasi-ibs.product-details', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}";
            const kdUnit = "{{ $dataMedis->kd_unit }}";

            // helper to populate selects
            function populateProductDetails(r, selected = {}) {
                console.log('productDetails response:', r);

                // Jenis Operasi
                let jo = $('#jenis_operasi').empty().append('<option value="">-- Pilih Jenis Operasi --</option>')
                    .prop('disabled', false);
                (r.jenisOperasi || []).forEach(x => jo.append(
                    `<option value="${x.kd_jenis_op}">${x.jenis_op}</option>`));
                if (selected.jenis_operasi) jo.val(selected.jenis_operasi);
                jo.trigger('change');

                // Spesialisasi
                let sp = $('#spesialisasi').empty().append('<option value="">-- Pilih Spesialisasi --</option>')
                    .prop('disabled', false);
                (r.spesialisasi || []).forEach(x => sp.append(
                    `<option value="${x.kd_spesial}">${x.spesialisasi}</option>`));
                if (selected.spesialisasi) sp.val(selected.spesialisasi);
                sp.trigger('change');

                // Sub Spesialisasi
                let ssp = $('#sub_spesialisasi').empty().append(
                    '<option value="">-- Pilih Sub Spesialisasi --</option>').prop('disabled', false);
                (r.subSpesialisasi || []).forEach(x => ssp.append(
                    `<option value="${x.kd_sub_spc}">${x.sub_spesialisasi}</option>`));
                if (selected.sub_spesialisasi) ssp.val(selected.sub_spesialisasi);
                ssp.trigger('change');

                // only replace kamar list if server returned a non-empty array
                if (Array.isArray(r.kamarOperasi) && r.kamarOperasi.length > 0) {
                    const kr = $('#kamar_operasi');
                    kr.empty().append('<option value="">-- Pilih Kamar Operasi --</option>');
                    r.kamarOperasi.forEach(x => kr.append(
                        `<option value="${x.no_kamar}">${x.nama_kamar}</option>`));
                    if (selected.kamar) kr.val(selected.kamar);
                    // refresh select2 if present
                    kr.trigger('change');
                    if (kr.hasClass('select2')) kr.trigger('change.select2');
                }

                // only replace dokter list if server returned a non-empty array
                if (Array.isArray(r.dokters) && r.dokters.length > 0) {
                    const dk = $('#dokter');
                    dk.empty().append('<option value="">-- Pilih Dokter --</option>');
                    r.dokters.forEach(x => dk.append(`<option value="${x.kd_dokter}">${x.nama}</option>`));
                    if (selected.dokter) dk.val(selected.dokter);
                    dk.trigger('change');
                    if (dk.hasClass('select2')) dk.trigger('change.select2');
                }
            }

            $('#jenis_tindakan').on('change', function() {
                const kdProduk = $(this).val();

                if (!kdProduk) {
                    // Reset semua select jika tindakan dikosongkan
                    $('#jenis_operasi').empty().append(
                        '<option value="">-- Pilih Jenis Operasi --</option>').trigger('change');
                    $('#spesialisasi').empty().append('<option value="">-- Pilih Spesialisasi --</option>')
                        .trigger('change');
                    $('#sub_spesialisasi').empty().append(
                        '<option value="">-- Pilih Sub Spesialisasi --</option>').trigger('change');
                    return;
                }

                // TAMPILKAN LOADING STATE
                $('#jenis_operasi').empty().append('<option value="">Memproses...</option>').prop(
                    'disabled', true);
                $('#spesialisasi').empty().append('<option value="">Memproses...</option>').prop('disabled',
                    true);
                $('#sub_spesialisasi').empty().append('<option value="">Memproses...</option>').prop(
                    'disabled', true);

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        kd_produk: kdProduk
                    },
                    success: function(r) {
                        populateProductDetails(r, r.selected || {});
                    },
                    error: function(xhr) {
                        // KEMBALIKAN KE STATE NORMAL JIKA ERROR
                        $('#jenis_operasi').empty().append(
                            '<option value="">-- Pilih Jenis Operasi --</option>').prop(
                            'disabled', false).trigger('change');
                        $('#spesialisasi').empty().append(
                            '<option value="">-- Pilih Spesialisasi --</option>').prop(
                            'disabled', false).trigger('change');
                        $('#sub_spesialisasi').empty().append(
                            '<option value="">-- Pilih Sub Spesialisasi --</option>').prop(
                            'disabled', false).trigger('change');

                        alert('Error loading data');
                    }
                });
            });

            // On page load, if a product is already selected, trigger change to populate dependent selects
            const initialProduct = '{{ $operasi->kd_produk ?? '' }}';
            if (initialProduct) {
                // trigger ajax to fetch details and auto-select existing values
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        kd_produk: initialProduct
                    },
                    success: function(r) {
                        // ensure the selects from server align with current operasi values
                        const selected = {
                            jenis_operasi: '{{ $operasi->kd_jenis_op ?? '' }}',
                            spesialisasi: '{{ $operasi->kd_spc ?? '' }}',
                            sub_spesialisasi: '{{ $operasi->kd_sub_spc ?? '' }}',
                            dokter: '{{ $operasi->kd_dokter ?? '' }}',
                            kamar: '{{ $operasi->no_kamar ?? ($operasi->kd_unit_kamar ?? '') }}'
                        };
                        populateProductDetails(r, selected);
                    },
                    error: function() {
                        // ignore
                    }
                });
            }
        });
    </script>
@endpush
