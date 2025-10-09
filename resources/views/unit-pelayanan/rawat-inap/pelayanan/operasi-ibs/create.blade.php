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
                    'description' => 'Tambah data operasi (IBS) pasien rawat inap dengan mengisi formulir di bawah ini.',
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
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-7 col-md-5">
                            <div class="mb-3">
                                <label for="tanggal_jadwal" class="form-label">Tgl. Jadwal</label>
                                <input type="date" class="form-control" id="tanggal_jadwal" name="tanggal_jadwal"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-5 col-md-2">
                            <div class="mb-3">
                                <label for="jam_operasi" class="form-label">Jam Operasi</label>
                                <input type="time" class="form-control" id="jam_operasi" name="jam_operasi"
                                    value="{{ date('H:i') }}" required>
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
                                        <option value="{{ $prod->kd_produk }}">{{ $prod->deskripsi }}</option>
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
                                        <option value="{{ $kr->no_kamar }}">{{ $kr->nama_kamar }}</option>
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
                                        <option value="{{ $d->kd_dokter }}">{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="diagnosa_medis" class="form-label">Diagnosis Medis</label>
                                <input type="text" class="form-control" id="diagnosa_medis" name="diagnosa_medis"
                                    placeholder="Masukkan diagnosis medis..." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan..."></textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
            const url = "{{ route('rawat-inap.operasi-ibs.product-details', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}";
            const kdUnit = "{{ $dataMedis->kd_unit }}";

            $('#jenis_tindakan').on('change', function() {
                const kdProduk = $(this).val();

                if (!kdProduk) {
                    // Reset semua select jika tindakan dikosongkan
                    $('#jenis_operasi').empty().append('<option value="">-- Pilih Jenis Operasi --</option>');
                    $('#spesialisasi').empty().append('<option value="">-- Pilih Spesialisasi --</option>');
                    $('#sub_spesialisasi').empty().append('<option value="">-- Pilih Sub Spesialisasi --</option>');
                    return;
                }

                // TAMPILKAN LOADING STATE
                $('#jenis_operasi').empty().append('<option value="">Memproses...</option>').prop('disabled', true);
                $('#spesialisasi').empty().append('<option value="">Memproses...</option>').prop('disabled', true);
                $('#sub_spesialisasi').empty().append('<option value="">Memproses...</option>').prop('disabled', true);

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        kd_produk: kdProduk
                    },
                    success: function(r) {
                        // Jenis Operasi
                        let jo = $('#jenis_operasi').empty().append('<option value="">-- Pilih Jenis Operasi --</option>').prop('disabled', false);
                        (r.jenisOperasi || []).forEach(x => jo.append(`<option value="${x.kd_jenis_op}">${x.jenis_op}</option>`));
                        if (r.selected.jenis_operasi) {
                            jo.val(r.selected.jenis_operasi);
                            console.log('✅ Auto-selected Jenis Operasi:', r.selected.jenis_operasi);
                        }

                        // Spesialisasi
                        let sp = $('#spesialisasi').empty().append('<option value="">-- Pilih Spesialisasi --</option>').prop('disabled', false);
                        (r.spesialisasi || []).forEach(x => sp.append(`<option value="${x.kd_spesial}">${x.spesialisasi}</option>`));
                        if (r.selected.spesialisasi) {
                            sp.val(r.selected.spesialisasi);
                            console.log('✅ Auto-selected Spesialisasi:', r.selected.spesialisasi);
                        }

                        // Sub Spesialisasi
                        let ssp = $('#sub_spesialisasi').empty().append('<option value="">-- Pilih Sub Spesialisasi --</option>').prop('disabled', false);
                        (r.subSpesialisasi || []).forEach(x => ssp.append(`<option value="${x.kd_sub_spc}">${x.sub_spesialisasi}</option>`));
                        if (r.selected.sub_spesialisasi) {
                            ssp.val(r.selected.sub_spesialisasi);
                            console.log('✅ Auto-selected Sub Spesialisasi:', r.selected.sub_spesialisasi);
                        }
                    },
                    error: function(xhr) {
                        // KEMBALIKAN KE STATE NORMAL JIKA ERROR
                        $('#jenis_operasi').empty().append('<option value="">-- Pilih Jenis Operasi --</option>').prop('disabled', false);
                        $('#spesialisasi').empty().append('<option value="">-- Pilih Spesialisasi --</option>').prop('disabled', false);
                        $('#sub_spesialisasi').empty().append('<option value="">-- Pilih Sub Spesialisasi --</option>').prop('disabled', false);

                        alert('Error loading data');
                    }
                });
            });
        });
    </script>
@endpush
