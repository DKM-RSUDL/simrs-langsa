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
            <a href="{{ url()->previous() }}" class="btn">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form action="{{ route('rehab-medis.pelayanan.layanan.program.update', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($program->id)]) }}" method="post">
                @csrf
                @method('put')

                <div class="d-flex justify-content-center">
                    <div class="card w-100 h-100">
                        <div class="card-header text-center border-bottom">
                            <h5 class="text-secondary fw-bold">Serah Terima Pasien Antar Ruang</h5>
                        </div>

                        <div class="card-body mt-3">

                            <div class="form-group">
                                <label style="max-width: 200px;">Waktu pelayanan</label>
                                <div class="d-flex">
                                    <input type="date" name="tgl_pelayanan" class="form-control me-3" value="{{ date('Y-m-d', strtotime($program->tgl_pelayanan)) }}">
                                    <input type="time" name="jam_pelayanan" class="form-control" value="{{ date('H:i', strtotime($program->jam_pelayanan)) }}">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="program">Program</label>
                                <select id="program" class="form-select select2">
                                    <option value="">--Pilih Tindakan--</option>
                                    @foreach ($produk as $item)
                                        <option value='{"kd_produk" : "{{ $item->kd_produk }}", "tarif" : "{{ $item->tarif }}", "tgl_berlaku" : "{{ date('Y-m-d', strtotime($item->tgl_berlaku)) }}"}'>{{ $item->deskripsi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-50 mt-3 rounded-2 p-2" id="program-container">
                                @foreach ($program->detail as $item)
                                    <div class="d-flex justify-content-between border-bottom border-secondary align-items-center mb-3">
                                        <p class="fw-bold text-primary m-0">{{ $item->produk->deskripsi }}</p>
                                        <input type="hidden" name="program[]" value='{"kd_produk" : "{{ $item->kd_produk }}", "tarif" : "{{ $item->tarif }}"}'>
                                        <button type="button" class="btn-del-list text-danger border-0">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('js')
    <script>
        $('#program').change(function() {
            let $this = $(this);
            let nilai = $this.val();
            let teks = $this.find('option:selected').text();

            let html = `<div class="d-flex justify-content-between border-bottom border-secondary align-items-center mb-3">
                            <p class="fw-bold text-primary m-0">${teks}</p>
                            <input type="hidden" name="program[]" value='${nilai}'>
                            <button type="button" class="btn-del-list text-danger border-0">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>`;

            $('#program-container').append(html);
        });

        $(document).on('click', '.btn-del-list', function() {
            let $this = $(this);
            let parent = $this.closest('.d-flex');

            $(parent).remove();
        });
    </script>
@endpush
