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
                <a href="{{ route('rawat-inap.pneumonia.psi.index', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                    class="btn btn-outline-primary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                
                <div class="btn-group">
                    <a href="{{ route('rawat-inap.pneumonia.psi.edit', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataPsi->id]) }}"
                        class="btn btn-warning">
                        <i class="ti-pencil"></i> Edit
                    </a>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $dataPsi->id }})">
                        <i class="ti-trash"></i> Hapus
                    </button>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="text-center text-primary fw-bold mb-4">Detail Penilaian Pneumonia Severity Index (PSI)</h4>

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
                                    <td>{{ \Carbon\Carbon::parse($dataPsi->tanggal_implementasi)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Jam Implementasi</td>
                                    <td>{{ \Carbon\Carbon::parse($dataPsi->jam_implementasi)->format('H:i') }} WIB</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Petugas</td>
                                    <td>{{ $dataPsi->userCreated->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Dibuat</td>
                                    <td>{{ \Carbon\Carbon::parse($dataPsi->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Demographic Factors -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th colspan="4" class="text-center">Faktor Demografi</th>
                                </tr>
                                <tr>
                                    <th width="50%">Parameter</th>
                                    <th width="15%" class="text-center">Skor</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="20%" class="text-center">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Gender & Umur</td>
                                    <td class="text-center">
                                        @if($dataPsi->gender_age == 'male')
                                            {{ $dataPsi->umur_laki ?? 0 }}
                                        @else
                                            {{ ($dataPsi->umur_perempuan ?? 0) - 10 }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($dataPsi->gender_age == 'male')
                                            <span class="badge bg-info">Laki-laki</span>
                                        @else
                                            <span class="badge bg-pink">Perempuan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $dataPsi->gender_age == 'male' ? ($dataPsi->umur_laki ?? 0) : ($dataPsi->umur_perempuan ?? 0) }} tahun
                                    </td>
                                </tr>
                                <tr>
                                    <td>Penghuni Panti Werdha</td>
                                    <td class="text-center">{{ $dataPsi->panti_werdha ? 10 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->panti_werdha)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Comorbid Conditions -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-warning">
                                <tr>
                                    <th colspan="4" class="text-center">Penyakit Penyerta</th>
                                </tr>
                                <tr>
                                    <th width="50%">Parameter</th>
                                    <th width="15%" class="text-center">Skor</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="20%" class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Keganasan</td>
                                    <td class="text-center">{{ $dataPsi->keganasan ? 30 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->keganasan)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+30</td>
                                </tr>
                                <tr>
                                    <td>Penyakit Hati</td>
                                    <td class="text-center">{{ $dataPsi->penyakit_hati ? 20 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->penyakit_hati)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+20</td>
                                </tr>
                                <tr>
                                    <td>Gagal Jantung Kongestif</td>
                                    <td class="text-center">{{ $dataPsi->jantung_kongestif ? 10 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->jantung_kongestif)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+10</td>
                                </tr>
                                <tr>
                                    <td>Penyakit Serebrovaskular</td>
                                    <td class="text-center">{{ $dataPsi->serebrovaskular ? 10 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->serebrovaskular)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+10</td>
                                </tr>
                                <tr>
                                    <td>Penyakit Ginjal</td>
                                    <td class="text-center">{{ $dataPsi->penyakit_ginjal ? 10 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->penyakit_ginjal)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+10</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Physical Examination -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-info">
                                <tr>
                                    <th colspan="4" class="text-center">Pemeriksaan Fisik</th>
                                </tr>
                                <tr>
                                    <th width="50%">Parameter</th>
                                    <th width="15%" class="text-center">Skor</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="20%" class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Gangguan Kesadaran</td>
                                    <td class="text-center">{{ $dataPsi->gangguan_kesadaran ? 20 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->gangguan_kesadaran)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+20</td>
                                </tr>
                                <tr>
                                    <td>Frekuensi Nafas ≥ 30x/menit</td>
                                    <td class="text-center">{{ $dataPsi->frekuensi_nafas ? 20 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->frekuensi_nafas)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+20</td>
                                </tr>
                                <tr>
                                    <td>Tekanan Sistolik < 90 mmHg</td>
                                    <td class="text-center">{{ $dataPsi->tekanan_sistolik ? 20 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->tekanan_sistolik)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+20</td>
                                </tr>
                                <tr>
                                    <td>Suhu Tubuh < 35°C atau ≥ 40°C</td>
                                    <td class="text-center">{{ $dataPsi->suhu_tubuh ? 15 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->suhu_tubuh)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+15</td>
                                </tr>
                                <tr>
                                    <td>Frekuensi Nadi ≥ 125x/menit</td>
                                    <td class="text-center">{{ $dataPsi->frekuensi_nadi ? 10 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->frekuensi_nadi)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+10</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Laboratory Results -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-success">
                                <tr>
                                    <th colspan="4" class="text-center">Hasil Laboratorium</th>
                                </tr>
                                <tr>
                                    <th width="50%">Parameter</th>
                                    <th width="15%" class="text-center">Skor</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="20%" class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>pH Arteri < 7.35</td>
                                    <td class="text-center">{{ $dataPsi->ph_rendah ? 30 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->ph_rendah)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+30</td>
                                </tr>
                                <tr>
                                    <td>Ureum ≥ 30 mg/dL</td>
                                    <td class="text-center">{{ $dataPsi->ureum_tinggi ? 20 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->ureum_tinggi)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+20</td>
                                </tr>
                                <tr>
                                    <td>Natrium < 130 mmol/L</td>
                                    <td class="text-center">{{ $dataPsi->natrium_rendah ? 20 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->natrium_rendah)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+20</td>
                                </tr>
                                <tr>
                                    <td>Glukosa ≥ 250 mg/dL</td>
                                    <td class="text-center">{{ $dataPsi->glukosa_tinggi ? 10 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->glukosa_tinggi)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+10</td>
                                </tr>
                                <tr>
                                    <td>Hematokrit < 30%</td>
                                    <td class="text-center">{{ $dataPsi->hematokrit_rendah ? 10 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->hematokrit_rendah)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+10</td>
                                </tr>
                                <tr>
                                    <td>PO2 < 60 mmHg atau O2 Sat < 90%</td>
                                    <td class="text-center">{{ $dataPsi->o2_rendah ? 10 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->o2_rendah)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+10</td>
                                </tr>
                                <tr>
                                    <td>Efusi Pleura</td>
                                    <td class="text-center">{{ $dataPsi->efusi_pleura ? 10 : 0 }}</td>
                                    <td class="text-center">
                                        @if($dataPsi->efusi_pleura)
                                            <span class="badge bg-success">Ya</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">+10</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Score -->
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th colspan="2" class="text-center">Total Skor PSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-warning">
                                    <td width="50%" class="text-center fw-bold fs-5">Total Skor</td>
                                    <td class="text-center fw-bold fs-4 text-primary">{{ $dataPsi->total_skor }}</td>
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
                                    <th width="45%">Rekomendasi Perawatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-success">
                                    <td class="text-center fw-bold">{{ $dataPsi->total_skor }}</td>
                                    <td class="text-center">{{ $dataPsi->mortalitas }}</td>
                                    <td>
                                        @php
                                            $badgeClass = 'bg-success';
                                            if($dataPsi->total_skor >= 131) {
                                                $badgeClass = 'bg-danger';
                                            } elseif($dataPsi->total_skor >= 91) {
                                                $badgeClass = 'bg-warning text-dark';
                                            } elseif($dataPsi->total_skor >= 71) {
                                                $badgeClass = 'bg-info';
                                            } elseif($dataPsi->total_skor >= 51) {
                                                $badgeClass = 'bg-primary';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $dataPsi->level_resiko }}</span>
                                    </td>
                                    <td>{{ $dataPsi->rekomendasi_perawatan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Additional Criteria (if any) -->
                    @if($dataPsi->kriteria_tambahan)
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">Kriteria Tambahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $dataPsi->kriteria_tambahan }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Delete Form (Hidden) -->
            <form id="delete-form-{{ $dataPsi->id }}" 
                action="{{ route('rawat-inap.pneumonia.psi.destroy', [$dataMedis->kd_unit, $dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, $dataPsi->id]) }}" 
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
    if (confirm('Apakah Anda yakin ingin menghapus data Pneumonia PSI ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush