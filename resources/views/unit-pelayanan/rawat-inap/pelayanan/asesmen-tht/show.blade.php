@extends('layouts.administrator.master')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card-keperawatan')
        </div>

        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="ti-arrow-left"></i> Kembali
                </a>
                <div>
                    <a href="#" class="btn btn-outline-primary" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Asesmen THT</h5>
                </div>
                <div class="card-body">
                    <!-- Informasi Dasar -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Informasi Dasar</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Waktu Asesmen</th>
                                    <td>{{ $asesmen->waktu_asesmen }}</td>
                                </tr>
                                <tr>
                                    <th>Petugas</th>
                                    <td>{{ $asesmen->user->name ?? 'Tidak ada data' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Kondisi Masuk</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="40%">Kondisi Masuk</th>
                                    <td>{{ $asesmen->rmeAsesmenTht->kondisi_masuk == 1 ? 'Normal' : 'Tidak Normal' }}</td>
                                </tr>
                                <tr>
                                    <th>Ruang</th>
                                    <td>{{ $asesmen->rmeAsesmenTht->ruang == 1 ? 'Ruang Biasa' : 'ICU/HCU' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Pemeriksaan Fisik -->
                    @if($asesmen->rmeAsesmenThtPemeriksaanFisik->count() > 0)
                    <div class="mb-4">
                        <h6 class="fw-bold">Pemeriksaan Fisik</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="25%">Sistole</th>
                                    <td>{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->darah_sistole }} mmHg</td>
                                    <th width="25%">Diastole</th>
                                    <td>{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->darah_diastole }} mmHg</td>
                                </tr>
                                <tr>
                                    <th>Nadi</th>
                                    <td>{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->nadi }} bpm</td>
                                    <th>Nafas</th>
                                    <td>{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->nafas }} x/menit</td>
                                </tr>
                                <tr>
                                    <th>Suhu</th>
                                    <td>{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->suhu }} °C</td>
                                    <th>Tinggi Badan</th>
                                    <td>{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->antropometri_tinggi_badan }} cm</td>
                                </tr>
                                <tr>
                                    <th>Berat Badan</th>
                                    <td>{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->antropometr_berat_badan }} kg</td>
                                    <th>IMT</th>
                                    <td>{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->antropometri_imt }}</td>
                                </tr>
                                <tr>
                                    <th>Sensorium</th>
                                    <td colspan="3">{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->sensorium }}</td>
                                </tr>
                                <tr>
                                    <th>KU/KP/KG</th>
                                    <td colspan="3">{{ $asesmen->rmeAsesmenThtPemeriksaanFisik[0]->ku_kp_kg }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Anamnesis -->
                    @if($asesmen->rmeAsesmenTht)
                    <div class="mb-4">
                        <h6 class="fw-bold">Anamnesis</h6>
                        <div class="card">
                            <div class="card-body">
                                {{ $asesmen->rmeAsesmenTht->anamnesis_anamnesis ?? 'Tidak ada data' }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Hasil Pemeriksaan Penunjang -->
                    @if($asesmen->rmeAsesmenTht)
                    <div class="mb-4">
                        <h6 class="fw-bold">Hasil Pemeriksaan Penunjang</h6>
                        <div class="row">
                            @if($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_darah)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header">Pemeriksaan Darah</div>
                                    <div class="card-body">
                                        <img src="{{ asset('storage/'.$asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_darah) }}"
                                            class="img-fluid" alt="Hasil Pemeriksaan Darah">
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_urine)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header">Pemeriksaan Urine</div>
                                    <div class="card-body">
                                        <img src="{{ asset('storage/'.$asesmen->rmeAsesmenTht->hasil_pemeriksaan_penunjang_urine) }}"
                                            class="img-fluid" alt="Hasil Pemeriksaan Urine">
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Evaluasi Keperawatan -->
                    @if($asesmen->rmeAsesmenTht)
                    <div class="mb-4">
                        <h6 class="fw-bold">Evaluasi Keperawatan</h6>
                        <div class="card">
                            <div class="card-body">
                                {{ $asesmen->rmeAsesmenTht->evaluasi_evaluasi_keperawatan ?? 'Tidak ada data' }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
