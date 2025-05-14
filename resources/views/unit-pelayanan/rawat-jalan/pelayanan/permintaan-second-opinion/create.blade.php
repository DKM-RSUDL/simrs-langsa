@extends('layouts.administrator.master')

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
    @endpush

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <a href="{{ url()->previous() }}" class="btn btn-outline-info">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <div class="text-center mt-1 mb-2">
                <h5 class="text-secondary fw-bold">Permintaan Second Opinion</h5>
            </div>

            <hr>

            <div class="form-section">
                <form
                    action="{{ route('rawat-jalan.permintaan-second-opinion.store', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf

                    <div class="card mb-4 border-primary">
                        <div class="card-header text-dark">
                            <h6 class="mb-0">INFORMASI UMUM</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="informasi-tanggal" class="form-label">Tanggal <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('informasi_tanggal') is-invalid @enderror"
                                            id="informasi-tanggal" name="informasi_tanggal" value="{{ old('informasi_tanggal', date('Y-m-d')) }}"
                                            required>
                                        @error('informasi_tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="informasi-jam" class="form-label">Jam <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control @error('informasi_jam') is-invalid @enderror" id="informasi-jam"
                                            name="informasi_jam" value="{{ old('informasi_jam', date('H:i')) }}" required>
                                        @error('informasi_jam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama_saksi" class="form-label">Nama Saksi <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama_saksi') is-invalid @enderror"
                                            id="nama_saksi" name="nama_saksi" value="{{ old('nama_saksi') }}" required>
                                        @error('nama_saksi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rs_second_opinion" class="form-label">RS Second Opinion <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('rs_second_opinion') is-invalid @enderror"
                                            id="rs_second_opinion" name="rs_second_opinion"
                                            value="{{ old('rs_second_opinion') }}" required>
                                        @error('rs_second_opinion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian
                                            Dokumen</label>
                                        <input type="date"
                                            class="form-control @error('tanggal_pengembalian') is-invalid @enderror"
                                            id="tanggal_pengembalian" name="tanggal_pengembalian"
                                            value="{{ old('tanggal_pengembalian') }}">
                                        @error('tanggal_pengembalian')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 border-primary">
                        <div class="card-header text-dark">
                            <h6 class="mb-0">DATA PEMINJAM</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="peminjam-nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('peminjam_nama') is-invalid @enderror"
                                            id="peminjam-nama" name="peminjam_nama" value="{{ old('peminjam_nama') }}" required>
                                        @error('peminjam_nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <div class="form-check me-4">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    id="laki_laki" value="1" {{ old('jenis_kelamin') == '1' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="laki_laki">Laki-laki</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    id="perempuan" value="0" {{ old('jenis_kelamin') == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perempuan">Perempuan</label>
                                            </div>
                                        </div>
                                        @error('jenis_kelamin')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tgl_lahir" class="form-label">Tanggal Lahir <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror"
                                            id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required>
                                        @error('tgl_lahir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_kartu_identitas" class="form-label">No Kartu Identitas <span
                                                class="text-danger">*</span></label>
                                        <input type="number"
                                            class="form-control @error('no_kartu_identitas') is-invalid @enderror"
                                            id="no_kartu_identitas" name="no_kartu_identitas"
                                            value="{{ old('no_kartu_identitas') }}" required>
                                        @error('no_kartu_identitas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="alamat" class="form-label">Alamat <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                            name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="hubungan" class="form-label">Hubungan dengan Pasien <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('hubungan') is-invalid @enderror"
                                            id="hubungan" name="hubungan" value="{{ old('hubungan') }}"
                                            placeholder="Masukkan hubungan dengan pasien" required>
                                        @error('hubungan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 border-primary">
                        <div class="card-header text-dark d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">DOKUMEN</h6>
                            <button type="button" class="btn btn-sm btn-light" id="tambah_dokumen">
                                <i class="ti-plus"></i> Tambah Dokumen
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="dokumen_container">
                                <div class="row mb-3 dokumen-item">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="form-label">Nama Dokumen </label>
                                            <input type="text"
                                                class="form-control @error('nama_dokumen.*') is-invalid @enderror"
                                                name="nama_dokumen[]">
                                            @error('nama_dokumen.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove-dokumen" style="display: none;">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <p class="text-muted small">
                                        <i class="ti-info-alt me-1"></i> Dokumen yang dipinjam harus dikembalikan sesuai
                                        dengan tanggal pengembalian yang ditentukan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dynamic document handling
            const tambahDokumenBtn = document.getElementById('tambah_dokumen');
            const dokumenContainer = document.getElementById('dokumen_container');

            function updateRemoveButtons() {
                const dokumenItems = document.querySelectorAll('.dokumen-item');
                dokumenItems.forEach((item, index) => {
                    const removeBtn = item.querySelector('.remove-dokumen');
                    if (removeBtn) {
                        removeBtn.style.display = dokumenItems.length > 1 ? 'block' : 'none';
                    }
                });
            }

            if (tambahDokumenBtn && dokumenContainer) {
                tambahDokumenBtn.addEventListener('click', function () {
                    const dokumenItems = document.querySelectorAll('.dokumen-item');
                    const newDokumenItem = dokumenItems[0].cloneNode(true);

                    // Clear input value and reset validation state
                    const inputField = newDokumenItem.querySelector('input[name="nama_dokumen[]"]');
                    if (inputField) {
                        inputField.value = '';
                        inputField.classList.remove('is-invalid');
                        const invalidFeedback = newDokumenItem.querySelector('.invalid-feedback');
                        if (invalidFeedback) {
                            invalidFeedback.textContent = '';
                        }
                    }

                    // Bind remove event to the new button
                    const removeButton = newDokumenItem.querySelector('.remove-dokumen');
                    if (removeButton) {
                        removeButton.addEventListener('click', function () {
                            newDokumenItem.remove();
                            updateRemoveButtons();
                        });
                    }

                    dokumenContainer.appendChild(newDokumenItem);
                    updateRemoveButtons();
                });

                // Initialize remove buttons
                dokumenContainer.addEventListener('click', function (e) {
                    if (e.target.closest('.remove-dokumen')) {
                        const dokumenItems = document.querySelectorAll('.dokumen-item');
                        if (dokumenItems.length > 1) {
                            e.target.closest('.dokumen-item').remove();
                            updateRemoveButtons();
                        }
                    }
                });

                // Initial state
                updateRemoveButtons();
            }
        });
    </script>
@endpush
