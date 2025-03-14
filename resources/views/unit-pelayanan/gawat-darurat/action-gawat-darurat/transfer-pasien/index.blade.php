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
            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Transfer Pasien Ke Rawat Inap</h5>
            </div>

            <hr>

            <div class="form-section">

                <form
                    action="{{ route('transfer-rwi.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="#kd_spesial" class="form-label">Spesialisasi</label>
                                <select name="kd_spesial" id="kd_spesial" class="form-select select2" required>
                                    <option value="">--Pilih Spesialisasi--</option>
                                    @foreach ($spesialisasi as $spesialis)
                                        <option value="{{ $spesialis->kd_spesial }}">{{ $spesialis->spesialisasi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="#kd_dokter" class="form-label">Dokter</label>
                                <select name="kd_dokter" id="kd_dokter" class="form-select select2" required>
                                    <option value="">--Pilih Dokter--</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="#kd_kelas" class="form-label">Kelas</label>
                                <select name="kd_kelas" id="kd_kelas" class="form-select select2" required>
                                    <option value="">--Pilih Kelas--</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="#kd_unit" class="form-label">Ruang</label>
                                <select name="kd_unit" id="kd_unit" class="form-select select2" required>
                                    <option value="">--Pilih Ruang--</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="#no_kamar" class="form-label">Kamar</label>
                                <select name="no_kamar" id="no_kamar" class="form-select select2" required>
                                    <option value="">--Pilih Kamar--</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="#sisa_bed" class="form-label">Sisa Bed</label>
                                <input class="form-control" name="sisa_bed" type="text" id="sisa_bed" value="0"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Transfer</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('#kd_spesial').change(function(e) {
            let $this = $(this);
            let kdSpesial = $this.val();

            $.ajax({
                type: "post",
                url: "{{ route('transfer-rwi.get-dokter-spesial-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    kd_spesial: kdSpesial
                },
                dataType: "json",
                success: function(res) {
                    let status = res.status;
                    let msg = res.message;
                    let data = res.data;

                    if (status == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: msg
                        });

                        return false;
                    }

                    $('#kd_dokter').html(data.dokterOption);
                    $('#kd_kelas').html(data.kelasOption);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: 'Dokter dan Kelas gagal di cari !'
                    });
                }
            });
        });

        $('#kd_kelas').change(function(e) {
            let $this = $(this);
            let kdKelas = $this.val();

            $.ajax({
                type: "post",
                url: "{{ route('transfer-rwi.get-ruang-kelas-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    kd_kelas: kdKelas
                },
                dataType: "json",
                success: function(res) {
                    let status = res.status;
                    let msg = res.message;
                    let data = res.data;

                    if (status == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: msg
                        });

                        return false;
                    }

                    $('#kd_unit').html(data);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: 'Ruangan gagal di cari !'
                    });
                }
            });
        });


        $('#kd_unit').change(function(e) {
            let $this = $(this);
            let kdUnit = $this.val();

            $.ajax({
                type: "post",
                url: "{{ route('transfer-rwi.get-kamar-ruang-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    kd_unit: kdUnit
                },
                dataType: "json",
                success: function(res) {
                    let status = res.status;
                    let msg = res.message;
                    let data = res.data;

                    if (status == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: msg
                        });

                        return false;
                    }

                    $('#no_kamar').html(data);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: 'Kamar gagal di cari !'
                    });
                }
            });
        });


        $('#no_kamar').change(function(e) {
            let $this = $(this);
            let noKamar = $this.val();

            $.ajax({
                type: "post",
                url: "{{ route('transfer-rwi.get-sisa-bed-ajax', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    no_kamar: noKamar
                },
                dataType: "json",
                success: function(res) {
                    let status = res.status;
                    let msg = res.message;
                    let data = res.data;

                    if (status == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: msg
                        });

                        return false;
                    }

                    $('#sisa_bed').val(data);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: 'Sisa Bed gagal di cari !'
                    });
                }
            });
        });
    </script>
@endpush
