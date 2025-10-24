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

                <form
                    action="{{ route('transfer-rwi.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    {{-- START : TRANSFER --}}
                    @include('components.page-header', [
                        'title' => 'Transfer Pasien Ke Rawat Inap',
                        'description' => 'Lengkapi data transfer pasien ke rawat inap.',
                    ])

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="#kd_spesial" class="form-label">Spesialisasi</label>
                                <select name="kd_spesial" id="kd_spesial" class="form-select select2" required>
                                    <option value="">--Pilih Spesialisasi--</option>
                                    @foreach ($spesialisasi as $spesialis)
                                        <option value="{{ $spesialis->kd_spesial }}">{{ $spesialis->spesialisasi }}
                                        </option>
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
                    <hr>
                    {{-- END : TRANSFER --}}

                    {{-- START : HANDOVER --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">SBAR</h5>
                                <div class="row g-3">
                                    <div class="col-12 mb-3">
                                        <label>Subjective</label>
                                        <textarea name="subjective" placeholder="Data subjektif" class="form-control" rows="5" required>{{ old('subjective') }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Background</label>
                                        <textarea name="background" placeholder="Background" class="form-control" rows="5" required>{{ old('background') }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Assessment</label>
                                        <textarea name="assessment" placeholder="Assessment" class="form-control" rows="5" required>{{ old('assessment') }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Recommendation</label>
                                        <textarea name="recomendation" placeholder="Recommendation" class="form-control" rows="5" required>{{ old('recomendation') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">Yang Menyerahkan:</h5>
                                <div class="mb-3">
                                    <label for="kd_unit_asal">Dari Unit/ Ruang</label>
                                    <select name="kd_unit_asal" id="kd_unit_asal" class="form-select select2" disabled>
                                        <option value="">--Pilih--</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->kd_unit }}" @selected($item->kd_unit == 3)>
                                                {{ $item->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="mb-3">
                                    <label for="kd_unit_tujuan">Tujuan ke Unit/ Ruang</label>
                                    <select name="kd_unit_tujuan" id="kd_unit_tujuan" class="form-select select2" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($unitTujuan as $item)
                                            <option value="{{ $item->kd_unit }}">
                                                {{ $item->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="mb-3">
                                    <label for="petugas_menyerahkan">Petugas yang Menyerahkan</label>
                                    <select name="petugas_menyerahkan" id="petugas_menyerahkan" class="form-select select2"
                                        required>
                                        <option value="">--Pilih--</option>
                                        <option value="{{ auth()->user()->kd_karyawan }}" selected>
                                            {{ auth()->user()->karyawan->gelar_depan . ' ' . str()->title(auth()->user()->karyawan->nama) . ' ' . auth()->user()->karyawan->gelar_belakang }}
                                        </option>

                                        @foreach ($petugasIGD as $item)
                                            @if ($item->kd_karyawan != auth()->user()->kd_karyawan)
                                                <option value="{{ $item->kd_karyawan }}">
                                                    {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' . $item->gelar_belakang }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal_menyerahkan" value="{{ date('Y-m-d') }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Jam</label>
                                        <input type="time" name="jam_menyerahkan" value="{{ date('H:i') }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                                {{-- <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button> --}}
                            </div>

                            {{-- <div class="mb-4">
                                <h5 class="fw-bold">Yang Menerima:</h5>
                                <div class="mb-3">
                                    <label>Diterima di Ruang/ Unit Pelayanan</label>
                                    <input type="text" class="form-control" value="" disabled>
                                </div>
                                <div class="mb-3">
                                    <label>Petugas yang Menerima</label>
                                    <input type="text" class="form-control" value="" disabled>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label>Tanggal</label>
                                        <input type="date" value="" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Jam</label>
                                        <input type="time" value="" class="form-control" disabled>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    {{-- END : HANDOVER --}}

                    <div class="text-end">
                        <x-button-submit>
                            Transfer
                        </x-button-submit>
                    </div>
                </form>

            </x-content-card>
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

        @cannot('is-admin')
            $('#petugas_menyerahkan').on('mousedown focusin touchstart', function(e) {
                e.preventDefault();
            });
        @endcannot
    </script>
@endpush
