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
                    'title' => 'Tambah Operasi (IBS)',
                    'description' =>
                        'Tambah data operasi (IBS) pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form
                    action="{{ route('rawat-inap.operasi-ibs.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="tanggal_registrasi" class="form-label">Tgl. Registrasi</label>
                                <input type="date" class="form-control" id="tanggal_registrasi" name="tanggal_registrasi"
                                    value="{{ old('tanggal_registrasi', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-7 col-md-5">
                            <div class="mb-3">
                                <label for="tanggal_jadwal" class="form-label">Tgl. Jadwal</label>
                                <input type="date" class="form-control" id="tanggal_jadwal" name="tanggal_jadwal"
                                    value="{{ old('tanggal_jadwal', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="col-5 col-md-2">
                            <div class="mb-3">
                                <label for="jam_operasi" class="form-label">Jam Operasi</label>
                                <input type="time" class="form-control" id="jam_operasi" name="jam_operasi"
                                    value="{{ old('jam_operasi', date('H:i')) }}" required>
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
                                            {{ old('jenis_tindakan') == $prod->kd_produk ? 'selected' : '' }}>
                                            {{ $prod->deskripsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_operasi" class="form-label">
                                    Jenis Operasi
                                    <span class="text-muted">(Otomatis)</span>
                                </label>
                                <input type="text" class="form-control bg-light" id="jenis_operasi_display"
                                    value="-- Otomatis terisi --" readonly>
                                {{-- Hidden input untuk value sebenarnya --}}
                                <input type="hidden" id="jenis_operasi" name="jenis_operasi">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                <select class="form-select select2" id="spesialisasi" name="spesialisasi" required>
                                    <option value="">-- Pilih Spesialisasi --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sub_spesialisasi" class="form-label">
                                    Sub Spesialisasi
                                    <span class="text-muted">(Otomatis)</span>
                                </label>
                                <input type="text" class="form-control bg-light" id="sub_spesialisasi_display"
                                    value="-- Otomatis terisi --" readonly>
                                {{-- Hidden input untuk value sebenarnya --}}
                                <input type="hidden" id="sub_spesialisasi" name="sub_spesialisasi">
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
                                            {{ old('kamar_operasi') == $kr->no_kamar ? 'selected' : '' }}>
                                            {{ $kr->nama_kamar }}
                                        </option>
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
                                            {{ old('dokter') == $d->kd_dokter ? 'selected' : '' }}>
                                            {{ $d->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="diagnosa_medis" class="form-label">Diagnosis Medis</label>
                                <input type="text" class="form-control" id="diagnosa_medis" name="diagnosa_medis"
                                    placeholder="Masukkan diagnosis medis..." value="{{ old('diagnosa_medis') }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan...">{{ old('catatan') }}</textarea>
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
            const url = "{{ route('rawat-inap.operasi-ibs.product-details', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}";

            $('#jenis_tindakan').on('change', function() {
                const kdProduk = $(this).val();

                if (!kdProduk) {
                    resetAllFields();
                    return;
                }

                showLoadingState();

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: { kd_produk: kdProduk },
                    success: function(response) {

                        // 1. JENIS OPERASI - Auto-select ✅ (READONLY)
                        if (response.jenisOperasi && response.jenisOperasi.length > 0 && response.selected.jenis_operasi) {
                            const jenisOp = response.jenisOperasi[0];
                            $('#jenis_operasi').val(jenisOp.kd_klas);
                            $('#jenis_operasi_display').val(jenisOp.klasifikasi);
                        } else {
                            $('#jenis_operasi').val('');
                            $('#jenis_operasi_display').val('-- Tidak tersedia --');
                        }

                        // 2. SPESIALISASI - User pilih manual ❌
                        let spSelect = $('#spesialisasi')
                            .empty()
                            .append('<option value="">-- Pilih Spesialisasi --</option>')
                            .prop('disabled', false);

                        if (response.spesialisasi && response.spesialisasi.length > 0) {
                            response.spesialisasi.forEach(item => {
                                spSelect.append(`<option value="${item.kd_spesial}">${item.spesialisasi}</option>`);
                            });
                        }
                        spSelect.trigger('change.select2');

                        // 3. SUB SPESIALISASI - Auto-select ✅ (READONLY)
                        if (response.selected.sub_spesialisasi) {
                            const subSpc = response.subSpesialisasi.find(x => x.kd_klas == response.selected.sub_spesialisasi);
                            $('#sub_spesialisasi').val(response.selected.sub_spesialisasi);
                            $('#sub_spesialisasi_display').val(subSpc ? subSpc.klasifikasi : response.selected.sub_spesialisasi);
                        } else {
                            $('#sub_spesialisasi').val('');
                            $('#sub_spesialisasi_display').val('-- Tidak tersedia --');
                        }
                    },
                    error: function(xhr) {
                        resetAllFields();

                        let errorMsg = 'Error loading data';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        alert(errorMsg);
                    }
                });
            });

            function resetAllFields() {
                // Reset Jenis Operasi
                $('#jenis_operasi').val('');
                $('#jenis_operasi_display').val('-- Otomatis terisi --');

                // Reset Spesialisasi
                $('#spesialisasi')
                    .empty()
                    .append('<option value="">-- Pilih Spesialisasi --</option>')
                    .prop('disabled', false)
                    .trigger('change.select2');

                // Reset Sub Spesialisasi
                $('#sub_spesialisasi').val('');
                $('#sub_spesialisasi_display').val('-- Otomatis terisi --');
            }

            function showLoadingState() {
                $('#jenis_operasi_display').val('Memproses...');
                $('#spesialisasi')
                    .empty()
                    .append('<option value="">Memproses...</option>')
                    .prop('disabled', true);
                $('#sub_spesialisasi_display').val('Memproses...');
            }
        });
    </script>
@endpush
