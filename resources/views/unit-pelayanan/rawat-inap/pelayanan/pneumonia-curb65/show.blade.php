@extends('layouts.administrator.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/MedisGawatDaruratController.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('rawat-inap.pneumonia.curb-65.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    class="btn btn-outline-primary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                
                <div class="btn-group">
                    <a href="{{ route('rawat-inap.pneumonia.curb-65.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataCurb65->id]) }}"
                        class="btn btn-warning">
                        <i class="ti-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $dataCurb65->id }})">
                        <i class="ti-trash"></i> Hapus
                    </button>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="text-center text-primary fw-bold mb-4">Detail Penilaian CURB-65</h4>

                    <!-- Basic Information -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th colspan="2" class="text-center">Informasi Penilaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="30%" class="fw-semibold">Tanggal Implementasi</td>
                                    <td>{{ \Carbon\Carbon::parse($dataCurb65->tanggal_implementasi)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Jam Implementasi</td>
                                    <td>{{ \Carbon\Carbon::parse($dataCurb65->jam_implementasi)->format('H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Petugas</td>
                                    <td>{{ $dataCurb65->userCreated->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Dibuat</td>
                                    <td>{{ \Carbon\Carbon::parse($dataCurb65->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- CURB-65 Criteria -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th width="15%" class="text-center">CURB-65</th>
                                    <th width="50%">Gambaran Klinis</th>
                                    <th width="15%" class="text-center">Skor</th>
                                    <th width="20%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center fw-bold fs-4">C</td>
                                    <td>Confusion</td>
                                    <td class="text-center">1</td>
                                    <td class="text-center">
                                        @if($dataCurb65->confusion)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center fw-bold fs-4">U</td>
                                    <td>Blood Urea Nitrogen ≥ 20 mg/dL</td>
                                    <td class="text-center">1</td>
                                    <td class="text-center">
                                        @if($dataCurb65->urea)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center fw-bold fs-4">R</td>
                                    <td>Respiratory Rate ≥ 30 x/menit</td>
                                    <td class="text-center">1</td>
                                    <td class="text-center">
                                        @if($dataCurb65->respiratory)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center fw-bold fs-4">B</td>
                                    <td>Systolic BP ≤ 90 mmHg atau Diastolic BP ≤ 60 mmHg</td>
                                    <td class="text-center">1</td>
                                    <td class="text-center">
                                        @if($dataCurb65->blood_pressure)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center fw-bold fs-4">65</td>
                                    <td>Usia 65 Tahun</td>
                                    <td class="text-center">1</td>
                                    <td class="text-center">
                                        @if($dataCurb65->age_65)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="table-warning">
                                    <td colspan="2" class="text-center fw-bold">Total Skor</td>
                                    <td class="text-center fw-bold fs-5 text-primary">{{ $dataCurb65->total_skor }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Interpretation Result -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-secondary">
                                <tr>
                                    <th colspan="4" class="text-center">Hasil Interpretasi</th>
                                </tr>
                                <tr>
                                    <th width="15%" class="text-center">Total Skor</th>
                                    <th width="15%" class="text-center">% Mortalitas</th>
                                    <th width="25%">Level Resiko</th>
                                    <th width="45%">Perawatan Yang disarankan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-success">
                                    <td class="text-center fw-bold">{{ $dataCurb65->total_skor }}</td>
                                    <td class="text-center">{{ $dataCurb65->mortalitas }}</td>
                                    <td>
                                        @php
                                            $badgeClass = 'bg-success';
                                            if(str_contains(strtolower($dataCurb65->level_resiko), 'sedang-berat')) {
                                                $badgeClass = 'bg-warning text-dark';
                                            } elseif(str_contains(strtolower($dataCurb65->level_resiko), 'sedang')) {
                                                $badgeClass = 'bg-warning text-dark';
                                            } elseif(str_contains(strtolower($dataCurb65->level_resiko), 'berat')) {
                                                $badgeClass = 'bg-danger';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $dataCurb65->level_resiko }}</span>
                                    </td>
                                    <td>{{ $dataCurb65->perawatan_disarankan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Delete Form (Hidden) -->
            <form id="delete-form-{{ $dataCurb65->id }}" 
                action="{{ route('rawat-inap.pneumonia.curb-65.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataCurb65->id]) }}" 
                method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection

@push('js')
<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data CURB-65 ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush