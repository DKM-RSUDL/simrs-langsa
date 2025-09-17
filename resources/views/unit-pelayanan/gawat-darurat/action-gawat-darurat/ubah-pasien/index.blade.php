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
            <div class="form-section">
                <form
                    action="{{ route('transfer-rwi.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    {{-- START : DATA UPDATE --}}
                    <div class="text-center mt-1 mb-2">
                        <h5 class="text-secondary fw-bold">Cari dan Update Data Pasien</h5>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <div class="form-group -mb-1">
                                <label for="#nik_pasien" class="form-label">
                                    NIK/No. RM Pasien
                                </label>
                                <div class="input-group" style="margin-bottom: 0px">
                                    <input type="text" name="nik_pasien" id="nik_pasien" class="form-control"
                                        placeholder="NIK/No RM Pasien (Cth: 0-00-00-00)" aria-label="Nik Pasien"
                                        aria-describedby="button-nik-pasien" value="{{ old('nik_pasien') }}">
                                    <button class="btn btn-outline-secondary" type="button" id="button-nik-pasien">
                                        <i class="ti ti-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-label">Nama Pasien</label>
                                <input class="form-control" name="nama" type="text"
                                    placeholder="Masukkan nama asli pasien" id="nama" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" disabled>
                                    <option value="">--Pilih Jenis Kelamin--</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="0">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input class="form-control date" name="tanggal_lahir" type="text" id="tanggal_lahir"
                                    placeholder="yyyy-mm-dd" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usia" class="form-label">Usia</label>
                                <input class="form-control" name="usia" id="usia" value="0" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col">
                            <div class="form-group">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" placeholder="Masukkan alamat asli pasien"></textarea>
                            </div>
                        </div>
                    </div>
                    {{-- END : DATA UPDATE --}}

                    <hr style="border: none; height: 3px; background-color: blue;">

                    {{-- START : DATA ASLI --}}
                    <div class="text-center mt-1 mb-2 mt-4">
                        <h5 class="text-secondary fw-bold">Identitas Pasien Sebelumnya</h5>
                    </div>
                    <div class="d-flex gap-4 mb-1">
                        <div style="width: auth; height:150px">
                            <div style="border: 1px solid #ced4da; padding: 5px; border-radius: 5px;"
                                class="p-2 text-center">
                                <img src={{ asset('assets/images/avatar1.png') }} width="150" height="150"
                                    alt="Foto Pasien" class="img-fluid">
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="form-group">
                                <label for="kd_transaksi" class="form-label">No. Transaksi</label>
                                <input readonly class="form-control" name="kd_transaksi" type="text"
                                    placeholder="Masukkan no. transaksi" id="kd_transaksi" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-label">Nama Pasien</label>
                                <input readonly class="form-control" name="nama" type="text"
                                    placeholder="Masukkan nama asli pasien" id="nama" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                <select readonly name="jenis_kelamin" id="jenis_kelamin" class="form-select" disabled>
                                    <option value="" disabled>--Pilih Jenis Kelamin--</option>
                                    <option value="1">Laki-laki</option>
                                    <option value="0">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input readonly class="form-control date" name="tanggal_lahir" type="text"
                                    id="tanggal_lahir" placeholder="yyyy-mm-dd" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="usia" class="form-label">Usia</label>
                                <input readonly class="form-control" name="usia" id="usia" value="0"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col">
                            <div class="form-group">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea readonly class="form-control" name="alamat" id="alamat" placeholder="Masukkan alamat asli pasien"></textarea>
                            </div>
                        </div>
                    </div>
                    {{-- END : DATA ASLI --}}

                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Mulai Ubah</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

{{-- @push('js')
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

        @cannot('is-admin')
            $('#petugas_menyerahkan').on('mousedown focusin touchstart', function(e) {
                e.preventDefault();
            });
        @endcannot
    </script>
@endpush --}}
