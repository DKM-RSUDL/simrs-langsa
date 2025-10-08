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
            {{-- <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Transfer Pasien Ke Rawat Inap</h5>
            </div>

            <hr> --}}

            <div class="form-section">

                <form
                    action="{{ route('transfer-rwi.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="w-100 p-3 bg-light text-center border border-4">
                                <p class="m-0 fw-bold fs-4">Serah Terima / Order HD</p>
                            </div>
                        </div>
                    </div>

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
                                            <option value="{{ $item->kd_unit }}" @selected($item->kd_unit == $nginap->kd_unit_kamar)>
                                                {{ $item->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="petugas_menyerahkan">Petugas yang Menyerahkan</label>
                                    <select name="petugas_menyerahkan" id="petugas_menyerahkan" class="form-select select2"
                                        required>
                                        <option value="">--Pilih--</option>
                                        <option value="{{ auth()->user()->kd_karyawan }}" selected>
                                            {{ auth()->user()->karyawan->gelar_depan . ' ' . str()->title(auth()->user()->karyawan->nama) . ' ' . auth()->user()->karyawan->gelar_belakang }}
                                        </option>

                                        {{-- @foreach ($petugasIGD as $item)
                                            @if ($item->kd_karyawan != auth()->user()->kd_karyawan)
                                                <option value="{{ $item->kd_karyawan }}">
                                                    {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' . $item->gelar_belakang }}
                                                </option>
                                            @endif
                                        @endforeach --}}
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
                            </div>
                        </div>
                    </div>
                    {{-- END : HANDOVER --}}

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

        @cannot('is-admin')
            $('#petugas_menyerahkan').on('mousedown focusin touchstart', function(e) {
                e.preventDefault();
            });
        @endcannot
    </script>
@endpush
