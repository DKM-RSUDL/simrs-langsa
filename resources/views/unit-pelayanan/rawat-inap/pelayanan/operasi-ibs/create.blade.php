@extends('layouts.administrator.master')

@section('content')
    <div class="row" style="height: auto;">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="card" style="height: auto;">
                <div class="card-body">
                    <a href="{{ url()->previous() }}" class="btn btn-light mb-4">
                        <i class="ti-arrow-left"></i> Kembali
                    </a>
                    <div class="d-flex justify-content-between align-items-center">
                        <h4>Tambah Operasi (IBS)</h4>
                    </div>

                    <form action="">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tgl. Registrasi</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-7 col-md-5">
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tgl. Jadwal</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-5 col-md-2">
                                <div class="mb-3">
                                    <label for="jam" class="form-label">Jam Operasi</label>
                                    <input type="time" class="form-control" id="jam" name="jam"
                                        value="{{ date('H:i') }}" required>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dokter" class="form-label">Jenis Tindakan</label>
                                    <select class="form-select" id="dokter" name="dokter" required>
                                        <option value="">-- Pilih Tindakan --</option>
                                        {{-- @foreach ($dokters as $dokter)
                                            <option value="{{ $dokter->id }}">{{ $dokter->name ?? $dokter->nama }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dokter" class="form-label">Jenis Operasi</label>
                                    <select class="form-select" id="dokter" name="dokter" required>
                                        <option value="">-- Pilih Jenis Operasi --</option>
                                        {{-- @foreach ($dokters as $dokter)
                                            <option value="{{ $dokter->id }}">{{ $dokter->name ?? $dokter->nama }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dokter" class="form-label">Spesialisasi</label>
                                    <select class="form-select" id="dokter" name="dokter" required>
                                        <option value="">-- Pilih Spesialisasi --</option>
                                        {{-- @foreach ($dokters as $dokter)
                                            <option value="{{ $dokter->id }}">{{ $dokter->name ?? $dokter->nama }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dokter" class="form-label">Sub Spesialisasi</label>
                                    <select class="form-select" id="dokter" name="dokter" required>
                                        <option value="">-- Pilih Sub Spesialisasi --</option>
                                        {{-- @foreach ($dokters as $dokter)
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
                                    <label for="dokter" class="form-label">Kamar Operasi</label>
                                    <select class="form-select" id="dokter" name="dokter" required>
                                        <option value="">-- Pilih Kamar Operasi --</option>
                                        {{-- @foreach ($dokters as $dokter)
                                            <option value="{{ $dokter->id }}">{{ $dokter->name ?? $dokter->nama }}</option>
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
                                    <label for="tindakan" class="form-label">Tindakan</label>
                                    <input type="text" class="form-control" id="tindakan" name="tindakan"
                                        placeholder="Masukkan tindakan..." required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan..."></textarea>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script></script>
@endpush
