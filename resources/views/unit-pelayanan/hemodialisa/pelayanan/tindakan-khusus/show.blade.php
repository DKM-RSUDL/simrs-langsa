@extends('layouts.administrator.master')
@include('unit-pelayanan.hemodialisa.pelayanan.tindakan-khusus.include')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-hemodialisa')
        </div>

        <div class="col-md-9">
            <a href="{{ route('hemodialisa.pelayanan.tindakan-khusus.index', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                class="btn btn-outline-primary mb-3">
                <i class="ti-arrow-left"></i> Kembali
            </a>

            <form action="" method="">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="text-center mb-0">
                            <i class="fas fa-pills me-2"></i>
                            Edit Pemakaian Obat-Obatan / Tindakan Khusus
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
                                            name="tanggal"
                                            value="{{ old('tanggal', $tindakanKhusus->tanggal ? date('Y-m-d', strtotime($tindakanKhusus->tanggal)) : '') }}"
                                            required disabled>
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
                                            name="jam"
                                            value="{{ old('jam', $tindakanKhusus->jam ? date('H:i', strtotime($tindakanKhusus->jam)) : '') }}"
                                            required disabled>
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
                                            placeholder="Masukkan diagnosis pasien..." disabled>{{ old('diagnosis', $tindakanKhusus->diagnosis) }}</textarea>
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
                                            placeholder="Masukkan hasil laboratorium dan pemeriksaan penunjang..." disabled>{{ old('hasil_lab', $tindakanKhusus->hasil_lab) }}</textarea>
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
                                            placeholder="Masukkan detail obat-obatan dan tindakan yang diberikan..." disabled>{{ old('obat_tindakan', $tindakanKhusus->obat_tindakan) }}</textarea>
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
                                            placeholder="Rencana follow up..." disabled>{{ old('follow_up', $tindakanKhusus->follow_up) }}</textarea>
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
                                            placeholder="Catatan tambahan..." disabled>{{ old('catatan', $tindakanKhusus->catatan) }}</textarea>
                                        @error('catatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Alert Info -->
                        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <div>
                                <strong>Perhatian:</strong> Pastikan semua data yang dimasukkan sudah benar sebelum
                                menyimpan perubahan.
                                Data yang telah disimpan akan menggantikan data sebelumnya.
                            </div>
                        </div>

                        <!-- Last Updated Info -->
                        @if ($tindakanKhusus->updated_at && $tindakanKhusus->updated_at != $tindakanKhusus->created_at)
                            <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>Terakhir diperbarui:</strong>
                                    @if (is_string($tindakanKhusus->updated_at))
                                        {{ date('d/m/Y H:i', strtotime($tindakanKhusus->updated_at)) }}
                                    @else
                                        {{ $tindakanKhusus->updated_at->format('d/m/Y H:i') }}
                                    @endif
                                    @if ($tindakanKhusus->userEdit)
                                        oleh {{ $tindakanKhusus->userEdit->name }}
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </form>
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
            const jam = document.querySelector('input[name="jam"]').value; // Fixed: was jam_masuk

            if (!tanggal || !jam) {
                e.preventDefault();
                alert('Tanggal dan Jam harus diisi!');
                return false;
            }
        });
    </script>
@endpush
