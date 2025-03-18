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
                <h5 class="text-secondary fw-bold">Serah Terima Pasien Antar Ruang</h5>
            </div>

            <hr>
            <div class="form-section">

                <form action="{{ route('serah-terima-pasien.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">SBAR</h5>
                                <input type="hidden" name="kd_pasien" value="{{ $dataMedis->pasien->kd_pasien }}">
                                <input type="hidden" name="validateForm" value="{{ $validateForm }}">
                                <div class="row g-3">
                                    <div class="col-12 mb-3">
                                        <label>Subjective</label>
                                        <textarea name="subjective" placeholder="Data subjektif" class="form-control" rows="5" {{ $validateForm == 'no' ? 'readonly' : '' }}>{{ old('subjective', $serahTerimaData->subjective ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Background</label>
                                        <textarea name="background" placeholder="Background" class="form-control" rows="5" {{ $validateForm == 'no' ? 'readonly' : '' }}> {{ old('background', $serahTerimaData->background ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Assessment</label>
                                        <textarea name="assessment" placeholder="Assessment" class="form-control" rows="5" {{ $validateForm == 'no' ? 'readonly' : '' }}> {{ old('assessment', $serahTerimaData->assessment ?? '') }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Recommendation</label>
                                        <textarea name="recomendation" placeholder="Recommendation" class="form-control" rows="5" {{ $validateForm == 'no' ? 'readonly' : '' }}> {{ old('recomendation', $serahTerimaData->recomendation ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <div class="col-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">Yang Menyerahkan:</h5>
                                <div class="mb-3">
                                    <label>Dari Unit/ Ruang</label>
                                    <input type="text" name="from_unit" value="{{ $dataMedis->unit->nama_unit }}" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Tujuan ke Unit/ Ruang</label>
                                    @if($validateForm == 'yes')
                                            <select name="kd_unit" id="kd_unit" class="form-select select2" {{ $validateForm == 'no' ? 'disabled' : '' }} required>
                                                @php
                                                    $selectedUnit = $tujuanUnit ? $tujuanUnit->kd_unit : old('kd_unit');
                                                @endphp
                                                @foreach ($unit as $tujuan)
                                                    <option value="{{$tujuan->kd_unit }}" {{ $selectedUnit == $tujuan->kd_unit ? 'selected' : '' }}>
                                                        {{$tujuan->nama_unit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    @else
                                         <input type="text" name="kd_unit" value="{{ $serahTerimaData->nama_unit }}" class="form-control" readonly>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label>Petugas yang Menyerahkan</label>
                                    <select name="petugas_menyerahkan" id="petugas_menyerahkan" class="form-select select2" {{ $validateForm == 'no' ? 'disabled' : '' }} required>
                                        <option value="{{ $serahTerimaData->petugas_menyerahkan ?? Auth::user()->id }}" selected>
                                            {{ $serahTerimaData->nama_menyerahkan ?? Auth::user()->name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal_menyerahkan" value="{{ $serahTerimaData->tanggal_menyerahkan ?? date('Y-m-d') }}" {{ $validateForm == 'no' ? 'readonly' : '' }} class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Jam</label>
                                        <input type="time" name="jam_menyerahkan" value="{{ isset($serahTerimaData->jam_menyerahkan) ? \Carbon\Carbon::parse($serahTerimaData->jam_menyerahkan)->format('H:i:s') : now()->format('H:i:s') }}" {{ $validateForm == 'no' ? 'readonly' : '' }} class="form-control">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button>
                            </div>
                
                            <div class="mb-4">
                                <h5 class="fw-bold">Yang Menerima:</h5>
                                <div class="mb-3">
                                    <label>Diterima di Ruang/ Unit Pelayanan</label>
                                    @if($validateForm == 'no')
                                            <select name="nm_unit_tujuan" id="nm_unit_tujuan" class="form-select select2" {{ $validateForm == 'yes' ? 'disabled' : '' }} required>
                                                @php
                                                    $selectedUnit = $serahTerimaData ? $serahTerimaData->kd_unit_tujuan : old('kd_unit');
                                                @endphp
                                                @foreach ($unit as $tujuan)
                                                    <option value="{{$tujuan->kd_unit }}" {{ $selectedUnit == $tujuan->kd_unit ? 'selected' : '' }}>
                                                        {{$tujuan->nama_unit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                    @else
                                         <input type="text" name="nm_unit_tujuan" value="" class="form-control" disabled>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label>Petugas yang Menerima</label>
                                    <select name="petugas_terima" id="petugas_terima" class="form-select select2" {{ $validateForm == 'yes' ? 'disabled' : '' }} required>
                                        @if($validateForm == 'yes')
                                            <option value="" selected>-- Pilih Petugas --</option>
                                        @else
                                            <option value="{{ $serahTerimaData->petugas_terima ?? Auth::user()->id }}" selected>
                                                {{ $serahTerimaData->nama_menerima ?? Auth::user()->name }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal_terima" value="{{ $serahTerimaData->tanggal_terima ?? date('Y-m-d') }}" {{ $validateForm == 'yes' ? 'readonly' : '' }} class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Jam</label>
                                        <input type="time" name="jam_terima" value="{{ isset($serahTerimaData->jam_terima) ? \Carbon\Carbon::parse($serahTerimaData->jam_terima)->format('H:i:s') : now()->format('H:i:s') }}" {{ $validateForm == 'yes' ? 'readonly' : '' }} class="form-control">
                                    </div>
                                </div>
                                <input type="hidden" name="status" value="{{$status}}">
                                
                                <button type="button" class="btn btn-primary w-100">Validasi petugas yang menerima</button>
                            </div>
                        </div>
                    </div>
                
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-danger">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
                
                

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>

        //ajax
        $(document).ready(function() {
            const validateForm = "{{ $validateForm }}";

            // Inisialisasi awal Select2
            $('#petugas_menyerahkan, #petugas_terima').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: '--pilih petugas--',
                allowClear: true
            });

            // Fungsi memuat petugas menyerahkan
            function loadPetugasMenyerahkan(kdUnit) {
                $('#petugas_menyerahkan').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: "{{ route('serah-terima-pasien.get-petugas-unit-ajax',[$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kd_unit: kdUnit
                    },
                    dataType: "json",
                    success: function(res) {
                        let options = `<option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }} (Anda)</option>`;
                        if (res.status === 'success') {
                            options += res.data.petugasOption;
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                        }
                        $('#petugas_menyerahkan').html(options).prop('disabled', false);
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Data petugas gagal diambil!' });
                        $('#petugas_menyerahkan').html('<option>--pilih petugas--</option>').prop('disabled', false);
                    }
                });
            }

            // Fungsi memuat petugas menerima
            function loadPetugasMenerima(kdUnit) {
                $('#petugas_terima').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: "{{ route('serah-terima-pasien.get-petugas-unit-ajax',[$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        kd_unit: kdUnit
                    },
                    dataType: "json",
                    success: function(res) {
                        let options = `<option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->name }} (Anda)</option>`;
                        if (res.status === 'success') {
                            options += res.data.petugasOption;
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                        }
                        $('#petugas_terima').html(options).prop('disabled', false);
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Data petugas gagal diambil!' });
                        $('#petugas_terima').html('<option>--pilih petugas--</option>').prop('disabled', false);
                    }
                });
            }

            // Event change untuk kd_unit (Menyerahkan)
            $('#kd_unit').change(function() {
                if (validateForm === 'yes') {
                    let kdUnit = $(this).val();
                    loadPetugasMenyerahkan(kdUnit);
                }
            });

            // Event change untuk nm_unit_tujuan (Menerima)
            $('#nm_unit_tujuan').change(function() {
                if (validateForm === 'no') {
                    let kdUnit = $(this).val();
                    loadPetugasMenerima(kdUnit);
                }
            });

            // Trigger load awal berdasarkan validateForm
            if (validateForm === 'yes') {
                loadPetugasMenyerahkan($('#kd_unit').val());
            } else if (validateForm === 'no') {
                loadPetugasMenerima($('#nm_unit_tujuan').val());
            }
        });



    </script>
@endpush
