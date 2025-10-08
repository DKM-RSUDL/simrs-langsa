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
                    'title' => 'Tambah Operasi (IBS)',
                    'description' =>
                        'Tambah data operasi (IBS) pasien rawat inap dengan mengisi formulir di bawah ini.',
                ])

                <form action="">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="tanggal_registrasi" class="form-label">Tgl. Registrasi</label>
                                <input type="date" class="form-control" id="tanggal_registrasi" name="tanggal_registrasi"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-7 col-md-5">
                            <div class="mb-3">
                                <label for="tanggal_jadwal" class="form-label">Tgl. Jadwal</label>
                                <input type="date" class="form-control" id="tanggal_jadwal" name="tanggal_jadwal"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-5 col-md-2">
                            <div class="mb-3">
                                <label for="jam_operasi" class="form-label">Jam Operasi</label>
                                <input type="time" class="form-control" id="jam_operasi" name="jam_operasi"
                                    value="{{ date('H:i') }}" required>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_tindakan" class="form-label">Jenis Tindakan</label>
                                <select class="form-select" id="jenis_tindakan" name="jenis_tindakan" required>
                                    <option value="">-- Pilih Tindakan --</option>
                                    {{-- @foreach ($dokters as $dokter)
                                            <option value="{{ $dokter->id }}">{{ $dokter->name ?? $dokter->nama }}</option>
                                        @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jenis_operasi" class="form-label">Jenis Operasi</label>
                                <select class="form-select" id="jenis_operasi" name="jenis_operasi" required>
                                    <option value="">-- Pilih Jenis Operasi --</option>
                                    {{-- @foreach ($jenis_operasis as $jenis_operasi)
                                            <option value="{{ $dokter->id }}">{{ $dokter->name ?? $dokter->nama }}</option>
                                        @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="spesialisasi" class="form-label">Spesialisasi</label>
                                <select class="form-select" id="spesialisasi" name="spesialisasi" required>
                                    <option value="">-- Pilih Spesialisasi --</option>
                                    {{-- @foreach ($spesialisasis as $dokter)
                                            <option value="{{ $dokter->id }}">{{ $dokter->name ?? $dokter->nama }}</option>
                                        @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sub_spesialisasi" class="form-label">Sub Spesialisasi</label>
                                <select class="form-select" id="sub_spesialisasi" name="sub_spesialisasi" required>
                                    <option value="">-- Pilih Sub Spesialisasi --</option>
                                    {{-- @foreach ($sub_spesialisasis as $sub_spesialisasi)
                                            <option value="{{ $dokter->id }}">{{ $dokter->name ?? $dokter->nama }}</option>
                                        @endforeach --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kamar_operasi" class="form-label">Kamar Operasi</label>
                                <select class="form-select" id="kamar_operasi" name="kamar_operasi" required>
                                    <option value="">-- Pilih Kamar Operasi --</option>
                                    {{-- @foreach ($kamar_operasis as $kamar_operasi)
                                            <option value="{{ $kamar_operasi->id }}">{{ $kamar_operasi->name ?? $kamar_operasi->nama }}</option>
                                        @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dokter" class="form-label">Dokter</label>
                                <select class="form-select" id="dokter" name="dokter" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    {{-- @foreach ($dokters as $dokter)
                                            <option value="{{ $dokter->id }}">{{ $dokter->name ?? $dokter->nama }}</option>
                                        @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="diagnosa_medis" class="form-label">Diagnosis Medis</label>
                                <input type="text" class="form-control" id="diagnosa_medis" name="diagnosa_medis"
                                    placeholder="Masukkan diagnosis medis..." required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan..."></textarea>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </x-content-card>
        </div>
    </div>
@endsection

@push('js')
    <script></script>
@endpush
