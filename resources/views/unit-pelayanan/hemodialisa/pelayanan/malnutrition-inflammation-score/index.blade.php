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
            @include('unit-pelayanan.hemodialisa.component.navigation')

            <div class="d-flex justify-content-center">
                <div class="card w-100 h-100">
                    <div class="card-body">

                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Data Malnutrition Inflammation Score</h4>
                            <a href="{{ route('hemodialisa.pelayanan.malnutrition-inflammation-score.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                class="btn btn-primary">
                                <i class="ti-plus"></i> Tambah Data
                            </a>
                        </div>

                        <!-- Alert Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Data Table -->
                        @if($skorMalnutrisi->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal & Jam</th>
                                            <th>BB/TB/BMI</th>
                                            <th>Total Skor</th>
                                            <th>Interpretasi</th>
                                            <th>Diagnosis</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($skorMalnutrisi as $index => $data)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>{{ \Carbon\Carbon::parse($data->tgl_rawat)->format('d/m/Y') }}</strong><br>
                                                    <small class="text-muted">{{ $data->jam_rawat }}</small>
                                                </td>
                                                <td>
                                                    <strong>BB:</strong> {{ $data->berat_badan }} kg<br>
                                                    <strong>TB:</strong> {{ $data->tinggi_badan }} cm<br>
                                                    <strong>IMT:</strong> {{ number_format($data->imt_result, 2) }}
                                                </td>
                                                <td class="text-center">
                                                    <h5>
                                                        <span class="badge 
                                                            @if($data->total_skor < 6) bg-success
                                                            @elseif($data->total_skor == 6) bg-warning
                                                            @else bg-danger
                                                            @endif">
                                                            {{ $data->total_skor }}/30
                                                        </span>
                                                    </h5>
                                                </td>
                                                <td>
                                                    <span class="badge 
                                                        @if($data->total_skor < 6) bg-success
                                                        @elseif($data->total_skor == 6) bg-warning text-dark
                                                        @else bg-danger
                                                        @endif">
                                                        @if($data->total_skor < 6)
                                                            NORMAL
                                                        @elseif($data->total_skor == 6)
                                                            BORDERLINE
                                                        @else
                                                            MALNUTRISI
                                                        @endif
                                                    </span>
                                                    <br><small class="text-muted">{{ $data->interpretasi }}</small>
                                                </td>
                                                <td>
                                                    {{ $data->diagnosis_medis ?? '-' }}
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-info me-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $data->id }}">
                                                            <i class="ti-eye"></i>
                                                        </button>
                                                        <a href="{{ route('hemodialisa.pelayanan.malnutrition-inflammation-score.edit', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($data->id)]) }}" class="btn btn-warning me-1">
                                                            <i class="ti-pencil"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $data->id }}">
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Delete Modal - Tambahkan setelah Detail Modal -->
                                            <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-center">
                                                                <i class="ti-alert-triangle text-warning" style="font-size: 48px;"></i>
                                                                <h5 class="mt-3">Yakin ingin menghapus data ini?</h5>
                                                                <p class="text-muted">
                                                                    Data MIS tanggal <strong>{{ \Carbon\Carbon::parse($data->tgl_rawat)->format('d/m/Y') }}</strong> 
                                                                    akan dihapus secara permanen dan tidak dapat dikembalikan.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <form action="{{ route('hemodialisa.pelayanan.malnutrition-inflammation-score.destroy', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk, encrypt($data->id)]) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="ti-trash"></i> Ya, Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Detail Modal -->
                                            <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Detail MIS - {{ \Carbon\Carbon::parse($data->tgl_rawat)->format('d/m/Y') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6 class="text-primary">A. RIWAYAT MEDIS</h6>
                                                                    <ul class="list-unstyled">
                                                                        <li>1. Perubahan BB Kering: <strong>{{ $data->perubahan_bb_kering }} poin</strong></li>
                                                                        <li>2. Asupan Diet: <strong>{{ $data->asupan_diet }} poin</strong></li>
                                                                        <li>3. Gejala GI: <strong>{{ $data->gejala_gastrointestinal }} poin</strong></li>
                                                                        <li>4. Kapasitas Fungsional: <strong>{{ $data->kapasitas_fungsional }} poin</strong></li>
                                                                        <li>5. Komorbiditas: <strong>{{ $data->komorbiditas }} poin</strong></li>
                                                                    </ul>

                                                                    <h6 class="text-primary">B. PEMERIKSAAN FISIK</h6>
                                                                    <ul class="list-unstyled">
                                                                        <li>6. Cadangan Lemak: <strong>{{ $data->berkurang_cadangan_lemak }} poin</strong></li>
                                                                        <li>7. Massa Otot: <strong>{{ $data->kehilangan_masa_oto }} poin</strong></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <h6 class="text-primary">C. UKURAN TUBUH</h6>
                                                                    <ul class="list-unstyled">
                                                                        <li>8. Indeks Massa Tubuh: <strong>{{ $data->indeks_masa_tubuh }} poin</strong></li>
                                                                    </ul>

                                                                    <h6 class="text-primary">D. PARAMETER LAB</h6>
                                                                    <ul class="list-unstyled">
                                                                        <li>9. Albumin Serum: <strong>{{ $data->albumin_serum }} poin</strong></li>
                                                                        <li>10. TIBC: <strong>{{ $data->tibc }} poin</strong></li>
                                                                    </ul>

                                                                    <hr>
                                                                    <h6 class="text-success">HASIL AKHIR</h6>
                                                                    <p><strong>Total Skor:</strong> {{ $data->total_skor }}/30</p>
                                                                    <p><strong>Interpretasi:</strong> {{ $data->interpretasi }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="ti-clipboard-list" style="font-size: 48px; color: #6c757d;"></i>
                                </div>
                                <h5 class="text-muted">Belum Ada Data</h5>
                                <p class="text-muted">Belum ada data Malnutrition Inflammation Score untuk pasien ini.</p>
                                <a href="{{ route('hemodialisa.pelayanan.malnutrition-inflammation-score.create', [$dataMedis->kd_pasien, date('Y-m-d', strtotime($dataMedis->tgl_masuk)), $dataMedis->urut_masuk]) }}"
                                    class="btn btn-primary">
                                    <i class="ti-plus"></i> Tambah Data Pertama
                                </a>
                            </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
   
@endpush