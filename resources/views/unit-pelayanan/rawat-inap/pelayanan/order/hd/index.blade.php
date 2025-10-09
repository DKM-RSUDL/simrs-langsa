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
                    'title' => 'Serah Terima / Order HD',
                    'description' =>
                        'Order pelayanan Hemodialisa (HD) pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form
                    action="{{ route('transfer-rwi.store', [$dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

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

                                        @foreach ($petugas as $item)
                                            <option value="{{ $item->kd_karyawan }}">
                                                {{ $item->gelar_depan . ' ' . str()->title($item->nama) . ' ' . $item->gelar_belakang }}
                                            </option>
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
                            </div>
                        </div>
                    </div>
                    {{-- END : HANDOVER --}}

                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Order</button>
                        </div>
                    </div>
                </form>

            </x-content-card>

        </div>
    </div>
@endsection
