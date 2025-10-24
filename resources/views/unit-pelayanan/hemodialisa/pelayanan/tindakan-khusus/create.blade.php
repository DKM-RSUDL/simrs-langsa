@extends('layouts.administrator.master')
@include('unit-pelayanan.hemodialisa.pelayanan.tindakan-khusus.include')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-hemodialisa')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />

                @include('components.page-header', [
                    'title' => 'Tambah Data Tindakan Khusus Hemodialisis',
                    'description' => 'Tambah Data Umum Pasien Hemodialisis dengan mengisi formulir di bawah ini.',
                ])

                {{-- Display Success/Error Messages --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h6><i class="fas fa-exclamation-triangle me-2"></i>Terjadi kesalahan validasi:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form
                    action="{{ route('hemodialisa.pelayanan.tindakan-khusus.store', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    method="post">
                    @csrf
                    <div class="card-header bg-primary">
                        <h4 class="text-center text-white mb-0">
                            <i class="fas fa-pills me-2"></i>
                            Pemakaian Obat-Obatan / Tindakan Khusus
                        </h4>
                    </div>

                    <div class="card-body">
                        <!-- Entry Form -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Tanggal -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-calendar me-1"></i>Tanggal <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                            name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Jam -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-clock me-1"></i>Jam <span class="text-danger">*</span>
                                        </label>
                                        <input type="time" class="form-control @error('jam') is-invalid @enderror"
                                            name="jam" value="{{ old('jam', date('H:i')) }}" required>
                                        @error('jam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Diagnosis -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-stethoscope me-1"></i>Diagnosis
                                        </label>
                                        <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" rows="3"
                                            placeholder="Masukkan diagnosis pasien...">{{ old('diagnosis') }}</textarea>
                                        @error('diagnosis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Hasil Lab dan Penunjang -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-flask me-1"></i>Hasil Lab dan Penunjang
                                        </label>
                                        <textarea class="form-control @error('hasil_lab') is-invalid @enderror" name="hasil_lab" rows="3"
                                            placeholder="Masukkan hasil laboratorium dan pemeriksaan penunjang...">{{ old('hasil_lab') }}</textarea>
                                        @error('hasil_lab')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Obat-obatan dan Tindakan -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-pills me-1"></i>Obat-obatan dan Tindakan
                                        </label>
                                        <textarea class="form-control @error('obat_tindakan') is-invalid @enderror" name="obat_tindakan" rows="4"
                                            placeholder="Masukkan detail obat-obatan dan tindakan yang diberikan...">{{ old('obat_tindakan') }}</textarea>
                                        @error('obat_tindakan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Follow Up -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-arrow-right me-1"></i>Follow Up
                                        </label>
                                        <textarea class="form-control @error('follow_up') is-invalid @enderror" name="follow_up" rows="3"
                                            placeholder="Rencana follow up...">{{ old('follow_up') }}</textarea>
                                        @error('follow_up')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Catatan -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-sticky-note me-1"></i>Catatan
                                        </label>
                                        <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" rows="3"
                                            placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                                        @error('catatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <div>
                                <strong>Petunjuk:</strong> Isi semua field yang diperlukan dengan lengkap dan akurat.
                                Field yang bertanda <span class="text-danger">*</span> wajib diisi.
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end">
                            <x-button-submit />
                        </div>
                    </div>
        </div>
        </form>
        </x-content-card>
    </div>
    </div>
@endsection

@push('js')
    <script>
        // Auto-resize textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        });

        // Form validation before submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const tanggal = document.querySelector('input[name="tanggal"]').value;
            const jam = document.querySelector('input[name="jam"]').value;

            if (!tanggal || !jam) {
                e.preventDefault();
                alert('Tanggal dan Jam wajib diisi!');
                return false;
            }
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-success')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);
    </script>
@endpush
