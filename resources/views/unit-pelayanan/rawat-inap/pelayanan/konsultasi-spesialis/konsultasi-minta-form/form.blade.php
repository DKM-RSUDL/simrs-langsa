@extends('layouts.administrator.master')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @php
                    if (!empty($readonly) && !empty($Data)) {
                        $title = 'Respon Konsultasi Minta';
                    } elseif (!empty($Data)) {
                        $title = 'Edit Konsultasi Minta';
                    } else {
                        $title = 'Tambah Konsultasi Minta';
                    }
                @endphp
                @include('components.page-header', [
                    'title' => $title,
                    'description' => 'Isi formulir dibawah ini.',
                ])

               <form 
                    action="{{ route(
                        !empty($Data) 
                            ? 'rawat-inap.konsultasi-spesialis.update' 
                            : 'rawat-inap.konsultasi-spesialis.store', 
                        [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]
                    ) }}" 
                    method="POST"
                >
                    @csrf
                    @method(!empty($Data) ? 'PUT' : 'POST')

                    @if(!empty($Data))
                        <input type="hidden" name="id" value="{{ $Data->id }}">
                    @endif

                    <div class="row">
                        <div class="col-md-5">
                            {{-- Dokter Pengirim --}}
                            <label for="dokter_pengirim" class="form-label fw-bold h5 text-dark">Dokter Pengirim:</label>
                            <select 
                                id="dokter_pengirim" 
                                name="dokter_pengirim"
                                class="form-select select2 @error('dokter_pengirim') is-invalid @enderror" 
                                {{ !empty($readonly) ? 'disabled' : '' }}
                                required
                            >
                                <option value="">--Pilih Dokter--</option>
                                @foreach ($dokterPengirim as $dok)
                                    <option 
                                        value="{{ $dok->dokter->kd_dokter }}"
                                        @selected(
                                            (!empty($Data) && $dok->dokter->kd_dokter == $Data->dokter_pengirim) ||
                                            ($dok->dokter->kd_karyawan == auth()->user()->kd_karyawan)
                                        )
                                    >
                                        {{ $dok->dokter->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dokter_pengirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Tanggal & Jam Konsul --}}
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-7">
                                        <label for="tgl_konsul" class="form-label fw-bold h5 text-dark">Tanggal Konsul:</label>
                                        <input 
                                            type="date" 
                                            id="tgl_konsul" 
                                            name="tgl_konsul"
                                            value="{{ old('tgl_konsul', $Data->tanggal_konsul ?? '') }}"
                                            class="form-control @error('tgl_konsul') is-invalid @enderror" 
                                            {{ !empty($readonly) ? 'disabled' : '' }}
                                            required
                                        >
                                    </div>
                                    <div class="col-5">
                                        <label for="jam_konsul" class="form-label fw-bold h5 text-dark">Jam:</label>
                                        <input 
                                            type="time" 
                                            id="jam_konsul" 
                                            name="jam_konsul"
                                            value="{{ !empty($Data->jam_konsul) ? date('H:i', strtotime($Data->jam_konsul)) : '' }}"
                                            class="form-control @error('jam_konsul') is-invalid @enderror" 
                                            {{ !empty($readonly) ? 'disabled' : '' }}
                                            required
                                        >
                                    </div>
                                </div>
                                @error('tgl_konsul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @error('jam_konsul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Spesialisasi --}}
                            <div class="mt-3">
                                <label for="spesialisasi" class="form-label fw-bold h5 text-dark">Spesialisasi:</label>
                                <select 
                                    id="spesialisasi" 
                                    name="spesialisasi"
                                    class="form-select select2 @error('spesialisasi') is-invalid @enderror" 
                                    {{ !empty($readonly) ? 'disabled' : '' }}
                                    required
                                >
                                    <option value="">--Pilih Unit Pelayanan--</option>
                                    @foreach ($spesialisasi as $item)
                                        <option 
                                            value="{{ $item->kd_spesial }}" 
                                            @selected(!empty($Data) && $item->kd_spesial == $Data->kd_spesial)
                                        >
                                            {{ $item->spesialisasi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('spesialisasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Dokter Tujuan --}}
                            <div class="mt-3">
                                <label for="dokter_unit_tujuan" class="form-label fw-bold h5 text-dark">Tujuan Dokter:</label>
                                <select 
                                    id="dokter_unit_tujuan" 
                                    name="dokter_unit_tujuan"
                                    class="form-select select2 @error('dokter_unit_tujuan') is-invalid @enderror" 
                                    {{ !empty($readonly) ? 'disabled' : '' }}
                                    required
                                >
                                    <option value="">--Pilih Dokter--</option>
                                    @if(!empty($Listdokter))
                                        @foreach ($Listdokter as $item)
                                            <option 
                                                value="{{ $item->kd_dokter }}" 
                                                @selected(!empty($Data) && $item->kd_dokter == $Data->dokter_tujuan)
                                            >
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('dokter_unit_tujuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom kanan --}}
                        <div class="col-md-7">
                            <strong class="fw-bold">Catatan Klinik / Diagnosis</strong>
                            <textarea 
                                class="form-control @error('catatan') is-invalid @enderror" 
                                name="catatan" 
                                id="catatan" 
                                rows="3" 
                                {{ !empty($readonly) ? 'disabled' : '' }}
                                required
                            >{{ old('catatan', $Data->catatan ?? '') }}</textarea>
                            @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            <div class="mt-3">
                                <strong class="fw-bold">Konsul yang Diminta</strong>
                                <textarea 
                                    class="form-control @error('konsul') is-invalid @enderror" 
                                    name="konsul" 
                                    id="konsul" 
                                    rows="5" 
                                    {{ !empty($readonly) ? 'disabled' : '' }}
                                    required
                                >{{ old('konsul', $Data->konsul ?? '') }}</textarea>
                                @error('konsul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <input type="hidden" name="category" value="{{ !empty($readonly) ? 'terima' : 'minta' }}">
                            @if(!empty($readonly))
                                <div class="mt-3">
                                    <strong class="fw-bold">Jawaban</strong>
                                    <textarea 
                                        class="form-control @error('respon_konsul') is-invalid @enderror" 
                                        name="respon_konsul" 
                                        id="respon_konsul" 
                                        rows="5" 
                                        required
                                    >{{ old('respon_konsul', $Data->respon_konsul ?? '') }}</textarea>
                                    @error('respon_konsul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <x-button-submit />
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
<script>
$(document).ready(() => {
    $('#spesialisasi').on('change', function () {
        const value = $(this).val();

        if (!value) return; // kalau belum pilih, hentikan

        console.log('Spesialis dipilih:', value);

        // tampilkan status memproses
        $('#dokter_unit_tujuan')
            .prop('disabled', true)
            .html('<option value="">Memproses data dokter...</option>');

        $('#kelas_unit_tujuan')
            .prop('disabled', true)
            .html('<option value="">Memproses data kelas...</option>');

        // buat URL dinamis
        const baseUrl = "{{ route('rawat-inap.konsultasi-spesialis.getDokterBySpesial', [$dataMedis->kd_unit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk, 'kd_spesial'=> 'KD_SPESIAL']) }}";
        const url = baseUrl.replace('KD_SPESIAL', value);

        // simulasi delay pakai setTimeout
        setTimeout(() => {
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        $('#dokter_unit_tujuan')
                            .html(response.data.dokterOption)
                            .prop('disabled', false);
                    } else {
                        $('#dokter_unit_tujuan')
                            .html('<option value="">Gagal memuat data dokter</option>')
                            .prop('disabled', false);
                        console.warn(response.message);
                    }

                    // aktifkan kembali select kelas
                    $('#kelas_unit_tujuan').prop('disabled', false);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    $('#dokter_unit_tujuan')
                        .html('<option value="">Terjadi kesalahan</option>')
                        .prop('disabled', false);
                    $('#kelas_unit_tujuan')
                        .html('<option value="">Terjadi kesalahan</option>')
                        .prop('disabled', false);
                }
            });
        }, 1200); // delay 1,2 detik sebelum kirim request
    });
});
</script>
@endpush
