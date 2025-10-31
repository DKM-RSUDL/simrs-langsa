@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
        <style>
            .header-background {
                height: 100%;
                background-image: url("{{ asset('assets/img/background_gawat_darurat.png') }}");
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Tambah Pelayanan Medis',
                    'description' => 'Tambah data pelayanan medis dengan mengisi formulir di bawah ini.',
                ])

                <form
                    action="{{ route('rehab-medis.pelayanan.terapi.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post" class="d-flex flex-column gap-4">
                    @csrf

                    <!-- Waktu Pelayanan -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Waktu Pelayanan</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="date" name="tgl_pelayanan" class="form-control w-100"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-6">
                                    <input type="time" name="jam_pelayanan" class="form-control w-100"
                                        value="{{ date('H:i') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Dokter</label>
                            <select class="form-control select2 @error('dokter') is-invalid @enderror" id="dokter"
                                name="dokter" required>
                                <option value="">Pilih Dokter</option>
                                @foreach ($dokter as $item)
                                    <option value="{{ $item->kd_dokter }}"
                                        {{ old('dokter') == $item->kd_dokter ? 'selected' : '' }}>
                                        {{ $item->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    <hr>

                    <!-- Anamnesa dan Pemeriksaan -->
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="subjective" class="fw-bold">Anamesa</label>
                            <textarea class="form-control" name="subjective" id="subjective" style="height: 100px"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="objective" class="fw-bold">Objective</label>
                            <textarea class="form-control" name="objective" id="objective" style="height: 100px"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label for="assessment" class="fw-bold">Assessment</label>
                            <textarea class="form-control" name="assessment" id="assessment" style="height: 100px"></textarea>
                        </div>

                        <!-- Program / Tindakan -->
                        <div class="col-md-12">
                            <label for="program" class="fw-bold">Procedure</label>
                            <select id="program" class="form-select select2">
                                <option value="">--Pilih Tindakan--</option>
                                @foreach ($produk as $item)
                                    <option
                                        value='{"kd_produk" : "{{ $item->kd_produk }}", "tarif" : "{{ $item->tarif }}", "tgl_berlaku" : "{{ date('Y-m-d', strtotime($item->tgl_berlaku)) }}"}'>
                                        {{ $item->deskripsi }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Container hasil pilihan tindakan -->
                            <div class="w-100 mt-3" id="program-container">
                                <p class="text-muted m-0 small">Belum ada tindakan dipilih.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="text-end">
                        <x-button-submit />
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $('#program').change(function() {
            let $this = $(this);
            let nilai = $this.val();
            let teks = $this.find('option:selected').text();

            if (!nilai) return;

            // Cek apakah tindakan sudah ada
            let exists = false;
            let existingDiv = null;
            $('input[name="program[]"]').each(function() {
                let existing = JSON.parse($(this).val());
                let selected = JSON.parse(nilai);
                if (existing.kd_produk === selected.kd_produk) {
                    exists = true;
                    existingDiv = $(this).closest('div');
                    return false;
                }
            });

            if (exists) {
                // Highlight item yang sudah ada (tanpa alert)
                existingDiv.addClass('bg-warning-subtle');
                setTimeout(() => {
                    existingDiv.removeClass('bg-warning-subtle');
                }, 800);
                return;
            }

            // Hapus placeholder jika ada
            $('#program-container .text-muted').remove();

            // Tambah item baru
            let html = `
            <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2 bg-white shadow-sm">
                <p class="fw-bold text-primary m-0">${teks}</p>
                <input type="hidden" name="program[]" value='${nilai}'>
                <button type="button" class="btn-del-list text-danger border-0 bg-transparent">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
            $('#program-container').append(html);
        });

        // Hapus item dari daftar
        $(document).on('click', '.btn-del-list', function() {
            $(this).closest('div').remove();

            // Jika kosong, tampilkan placeholder
            if ($('#program-container').children().length === 0) {
                $('#program-container').html('<p class="text-muted m-0 small">Belum ada tindakan dipilih.</p>');
            }
        });
    </script>
@endpush
