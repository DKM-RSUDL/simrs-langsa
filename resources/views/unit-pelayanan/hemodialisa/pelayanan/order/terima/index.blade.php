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
                    'title' => 'Terima Order HD',
                    'description' =>
                        'Terima Order pelayanan Hemodialisa (HD) dengan mengisi formulir di bawah ini.',
                ])

                <form action="{{ route('hemodialisa.terima-order.store', [encrypt($order->id)]) }}" method="post">
                    @csrf

                    {{-- START : HANDOVER --}}
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">SBAR</h5>
                                <div class="row g-3">
                                    <div class="col-12 mb-3">
                                        <label>Subjective</label>
                                        <textarea name="subjective" placeholder="Data subjektif" class="form-control" rows="5" disabled>{{ old('subjective', $serahTerima->subjective) }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Background</label>
                                        <textarea name="background" placeholder="Background" class="form-control" rows="5" disabled>{{ old('background', $serahTerima->background) }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Assessment</label>
                                        <textarea name="assessment" placeholder="Assessment" class="form-control" rows="5" disabled>{{ old('assessment', $serahTerima->assessment) }}</textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label>Recommendation</label>
                                        <textarea name="recomendation" placeholder="Recommendation" class="form-control" rows="5" disabled>{{ old('recomendation', $serahTerima->recomendation) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-4">
                                <h5 class="fw-bold">Yang Menyerahkan:</h5>
                                <div class="mb-3">
                                    <label for="kd_unit_asal">Dari Unit/ Ruang</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $order->unit_asal->nama_unit }}">
                                </div>

                                <div class="mb-3">
                                    <label for="petugas_menyerahkan">Petugas yang Menyerahkan</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $serahTerima->petugasAsal->gelar_depan . ' ' . str()->title($serahTerima->petugasAsal->nama) . ' ' . $serahTerima->petugasAsal->gelar_belakang }}">
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label>Tanggal</label>
                                        <input type="date" name="tanggal_menyerahkan"
                                            value="{{ $serahTerima->tanggal_menyerahkan }}" class="form-control" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Jam</label>
                                        <input type="time" name="jam_menyerahkan"
                                            value="{{ date('H:i', strtotime($serahTerima->jam_menyerahkan)) }}"
                                            class="form-control" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold">Yang Menerima:</h5>
                                <div class="mb-3">
                                    <label>Diterima di Ruang/ Unit Pelayanan</label>
                                    <input type="text" class="form-control"
                                        value="{{ $serahTerima->unitTujuan->nama_unit ?? '' }}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label>Petugas yang Menerima</label>
                                    <select name="petugas_terima" id="petugas_terima" class="form-select select2" required>
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
                                        <input type="date" name="tanggal_terima"
                                            value="{{ !empty($serahTerima->tanggal_terima) ? date('Y-m-d', strtotime($serahTerima->tanggal_terima)) : date('Y-m-d') }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Jam</label>
                                        <input type="time" name="jam_terima"
                                            value="{{ !empty($serahTerima->jam_terima) ? date('H:i', strtotime($serahTerima->jam_terima)) : date('H:i') }}"
                                            class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="fw-bold">Tindakan:</h5>
                                <div class="mb-3">
                                    <label>Nama Tindakan</label>
                                    <select name="kd_produk" id="kd_produk" class="form-select select2" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($produk as $item)
                                            <option value="{{ $item->kd_produk }}" data-tarif="{{ $item->tarif }}"
                                                data-tgl="{{ $item->tgl_berlaku }}">
                                                {{ $item->deskripsi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Dokter</label>
                                    <select name="kd_dokter" id="kd_dokter" class="form-select select2" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($dokter as $item)
                                            <option value="{{ $item->kd_dokter }}">
                                                {{ $item->dokter->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="asal_pasien" value="2">
                            <input type="hidden" name="kd_kasir" value="17">
                            <input type="hidden" name="tarif" id="tarif" class="form-control"
                                placeholder="Tarif" readonly>
                            <input type="hidden" name="tgl_berlaku" id="tgl_berlaku" class="form-control"
                                placeholder="tgl_berlaku" readonly>
                        </div>
                    </div>
                    {{-- END : HANDOVER --}}

                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <x-button-submit>Terima</x-button-submit>
                        </div>
                    </div>
                </form>

            </x-content-card>

        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#kd_produk').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var tarif = selectedOption.data('tarif');
                var tgl_berlaku = selectedOption.data('tgl');

                $('#tarif').val(tarif ? tarif : '');
                $('#tgl_berlaku').val(tgl_berlaku ? tgl_berlaku : '');
            });
        });
    </script>
@endpush
