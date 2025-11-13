@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.include')

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Rincian Pengkajian Resiko Jatuh - Skala Morse',
                    'description' => 'Rincian data pengkajian resiko jatuh - skala morse pasien rawat inap.',
                ])

                <!-- Data Dasar -->
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Tanggal</label>
                            <div class="form-control-plaintext bg-light p-2 rounded">
                                {{ $skalaMorse->tanggal_formatted }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Hari ke</label>
                            <div class="form-control-plaintext bg-light p-2 rounded">
                                {{ $skalaMorse->hari_ke }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Shift</label>
                            <div class="form-control-plaintext bg-light p-2 rounded">
                                {{ $skalaMorse->shift_name }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Penilaian -->
                <div class="mb-4">
                    <h5 class="mb-3"><i class="ti-list-ol me-2"></i> Detail Penilaian Resiko Jatuh</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Jawaban</th>
                                    <th class="text-center">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>1. Riwayat Jatuh</strong></td>
                                    <td>{{ $skalaMorse->riwayat_jatuh_text }}</td>
                                    <td class="text-center">{{ $skalaMorse->riwayat_jatuh }}</td>
                                </tr>
                                <tr>
                                    <td><strong>2. Diagnosa Sekunder</strong></td>
                                    <td>{{ $skalaMorse->diagnosa_sekunder_text }}</td>
                                    <td class="text-center">{{ $skalaMorse->diagnosa_sekunder }}</td>
                                </tr>
                                <tr>
                                    <td><strong>3. Bantuan Ambulasi</strong></td>
                                    <td>{{ $skalaMorse->bantuan_ambulasi_text }}</td>
                                    <td class="text-center">{{ $skalaMorse->bantuan_ambulasi }}</td>
                                </tr>
                                <tr>
                                    <td><strong>4. Terpasang Infus</strong></td>
                                    <td>{{ $skalaMorse->terpasang_infus_text }}</td>
                                    <td class="text-center">{{ $skalaMorse->terpasang_infus }}</td>
                                </tr>
                                <tr>
                                    <td><strong>5. Cara / Gaya Berjalan</strong></td>
                                    <td>{{ $skalaMorse->gaya_berjalan_text }}</td>
                                    <td class="text-center">{{ $skalaMorse->gaya_berjalan }}</td>
                                </tr>
                                <tr>
                                    <td><strong>6. Status Mental</strong></td>
                                    <td>{{ $skalaMorse->status_mental_text }}</td>
                                    <td class="text-center">{{ $skalaMorse->status_mental }}</td>
                                </tr>
                            </tbody>
                            <tfoot class="table-warning">
                                <tr>
                                    <th colspan="2" class="text-center">TOTAL SKOR</th>
                                    <th class="text-center">{{ $skalaMorse->skor_total }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Hasil Skor -->
                <div class="mb-4">
                    <h5 class="mb-3">Hasil Penilaian</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <label class="form-label fw-bold">Skor Total</label>
                                    <p class="form-control-plaintext fs-2 fw-bold">{{ $skalaMorse->skor_total }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <label class="form-label fw-bold">Kategori Resiko</label>
                                    <p class="form-control-plaintext fs-2 fw-bold">
                                        @switch($skalaMorse->kategori_resiko)
                                            @case('RR')
                                                <span class="badge bg-success">RESIKO RENDAH (RR)</span>
                                            @break

                                            @case('RS')
                                                <span class="badge bg-warning text-dark">RESIKO SEDANG (RS)</span>
                                            @break

                                            @case('RT')
                                                <span class="badge bg-danger">RESIKO TINGGI (RT)</span>
                                            @break
                                        @endswitch
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Intervensi yang Dipilih -->
                @php $kat = $skalaMorse->kategori_resiko; @endphp

                {{-- Intervensi Rendah (tampil kalau RR/RS/RT dan ada data) --}}
                @if (in_array($kat, ['RR', 'RS', 'RT']) && $skalaMorse->intervensi_rr)
                    <div class="mb-4">
                        <h5 class="mb-3 text-success"><i class="ti-shield me-2"></i> Intervensi Pencegahan — Resiko Rendah
                        </h5>
                        @php $items = $skalaMorse->intervensi_rr ?? []; @endphp
                        @if (!empty($items) && count($items) > 0)
                            <ul class="list-group">
                                @foreach ($items as $idx => $val)
                                    <li class="list-group-item">
                                        <i class="ti-check text-success me-2"></i>
                                        {!! $val !!}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">Tidak ada intervensi yang dipilih</p>
                        @endif
                    </div>
                @endif

                {{-- Intervensi Sedang (tampil kalau RS/RT dan ada data) --}}
                @if (in_array($kat, ['RS', 'RT']) && $skalaMorse->intervensi_rs)
                    <div class="mb-4">
                        <h5 class="mb-3 text-warning"><i class="ti-alert me-2"></i> Intervensi Pencegahan — Resiko Sedang
                        </h5>
                        @php $items = $skalaMorse->intervensi_rs ?? []; @endphp
                        @if (!empty($items) && count($items) > 0)
                            <ul class="list-group">
                                @foreach ($items as $idx => $val)
                                    <li class="list-group-item">
                                        <i class="ti-check text-warning me-2"></i>
                                        {!! $val !!}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">Tidak ada intervensi yang dipilih</p>
                        @endif
                    </div>
                @endif

                {{-- Intervensi Tinggi (tampil hanya kalau RT dan ada data) --}}
                @if ($kat == 'RT' && $skalaMorse->intervensi_rt)
                    <div class="mb-4">
                        <h5 class="mb-3 text-danger"><i class="ti-alert me-2"></i> Intervensi Pencegahan — Resiko Tinggi
                        </h5>
                        @php $items = $skalaMorse->intervensi_rt ?? []; @endphp
                        @if (!empty($items) && count($items) > 0)
                            <ul class="list-group">
                                @foreach ($items as $idx => $val)
                                    <li class="list-group-item">
                                        <i class="ti-check text-danger me-2"></i>
                                        {!! $val !!}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">Tidak ada intervensi yang dipilih</p>
                        @endif
                    </div>
                @endif

                <!-- Informasi Petugas -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Informasi Petugas</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2"><strong>Nama Petugas:</strong>
                                    {{ $skalaMorse->userCreated->name ?? 'Unknown' }}</div>
                            </div>
                            <div class="col-md-6">
                                <div><strong>Dibuat Pada:</strong>
                                    {{ date('d/m/Y H:i', strtotime($skalaMorse->created_at)) }} WIB</div>
                            </div>
                        </div>
                    </div>
                </div>

            </x-content-card>

            <x-content-card>
                <!-- Keterangan -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title fw-bold">Kategori Risiko:</h6>
                                <ul class="mb-0" style="list-style: none;">
                                    <li class="mb-2">
                                        <span class="badge bg-success me-2">RR</span>
                                        <strong>Resiko Rendah (0 - 24)</strong>
                                    </li>
                                    <li class="mb-2">
                                        <span class="badge bg-warning text-dark me-2">RS</span>
                                        <strong>Resiko Sedang (25 - 44)</strong>
                                    </li>
                                    <li>
                                        <span class="badge bg-danger me-2">RT</span>
                                        <strong>Resiko Tinggi (≥ 45)</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title fw-bold">Pengkajian resiko jatuh dilakukan pada waktu:</h6>
                                <ol type="a" class="mb-0">
                                    <li class="mb-1">Saat pasien masuk RS / Initial Assessment (IA)</li>
                                    <li class="mb-1">Saat kondisi pasien berubah atau ada perubahan dalam terapi medik /
                                        Change Of Condition (CC)</li>
                                    <li class="mb-1">Saat pasien dipindahkan ke Unit lain / Ward Transfer (WT)</li>
                                    <li>Setelah kejadian jatuh / Post Fall (PF)</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </x-content-card>
        </div>
    </div>
@endsection
