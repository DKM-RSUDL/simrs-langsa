@extends('layouts.administrator.master')
@include('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-morse.include')

@section('content')
    <style>
        .resiko_jatuh__header-asesmen {
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .resiko_jatuh__section-separator {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .resiko_jatuh__info-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #667eea;
        }

        .resiko_jatuh__score-display {
            font-size: 2.5rem;
            font-weight: bold;
            color: #667eea;
            text-align: center;
            margin: 20px 0;
        }

        .resiko_jatuh__btn-outline-primary {
            border-color: #667eea;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .resiko_jatuh__btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            transform: translateX(-3px);
        }

        .table-detail th {
            background-color: #f8f9fa;
            font-weight: 600;
            width: 30%;
        }

        .intervensi-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 8px;
            border-left: 4px solid #28a745;
        }

        .kategori-badge {
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 25px;
        }
    </style>

    <div class="row">
        <div class="col-md-3">
            @include('components.patient-card')
        </div>

        <div class="col-md-9">
            <x-content-card>
                <x-button-previous />
                @include('components.page-header', [
                    'title' => 'Rincian Pengkajian Resiko Jatuh - Skala Morse',
                    'description' =>
                        'Rincian data pengkajian resiko jatuh - skala morse pasien rawat inap.',
                ])
                <!-- Informasi Pengkajian -->
                <div class="resiko_jatuh__section-separator">
                    <h5><i class="ti-calendar mr-2"></i> Informasi Pengkajian</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless table-detail">
                                <tr>
                                    <th>Tanggal Pengkajian:</th>
                                    <td>{{ $skalaMorse->tanggal_formatted }}</td>
                                </tr>
                                <tr>
                                    <th>Hari Ke:</th>
                                    <td>{{ $skalaMorse->hari_ke }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless table-detail">
                                <tr>
                                    <th>Petugas:</th>
                                    <td>{{ str()->title($skalaMorse->userCreate->name ?? 'Tidak Diketahui') }}</td>
                                </tr>
                                <tr>
                                    <th>Shift:</th>
                                    <td>{{ $skalaMorse->shift_name }}</td>
                                </tr>
                                @if ($skalaMorse->userEdit)
                                    <tr>
                                        <th>Terakhir Diubah:</th>
                                        <td>{{ str()->title($skalaMorse->userEdit->name) }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Detail Penilaian -->
                <div class="resiko_jatuh__section-separator">
                    <h5><i class="ti-list-ol mr-2"></i> Detail Penilaian Resiko Jatuh</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Jawaban</th>
                                    <th>Skor</th>
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
                                    <th colspan="2" class="text-center"><strong>TOTAL SKOR</strong></th>
                                    <th class="text-center"><strong>{{ $skalaMorse->skor_total }}</strong></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Hasil Penilaian -->
                <div class="resiko_jatuh__section-separator">
                    <h5><i class="ti-stats-up mr-2"></i> Hasil Penilaian</h5>

                    <div class="text-center">
                        <div class="resiko_jatuh__score-display">{{ $skalaMorse->skor_total }}</div>

                        @switch($skalaMorse->kategori_resiko)
                            @case('RR')
                                <span class="badge bg-success kategori-badge">RESIKO RENDAH (RR)</span>
                                <p class="mt-3 text-muted">Skor 0-24: Resiko jatuh rendah</p>
                            @break

                            @case('RS')
                                <span class="badge bg-warning text-dark kategori-badge">RESIKO SEDANG (RS)</span>
                                <p class="mt-3 text-muted">Skor 25-44: Resiko jatuh sedang</p>
                            @break

                            @case('RT')
                                <span class="badge bg-danger kategori-badge">RESIKO TINGGI (RT)</span>
                                <p class="mt-3 text-muted">Skor ≥45: Resiko jatuh tinggi</p>
                            @break
                        @endswitch
                    </div>
                </div>

                <!-- Intervensi yang Dipilih -->
                @if ($skalaMorse->kategori_resiko == 'RR' && $skalaMorse->intervensi_rr)
                    <div class="resiko_jatuh__section-separator">
                        <h5 style="color: #28a745;"><i class="ti-shield mr-2"></i> Intervensi Pencegahan - Resiko Rendah
                        </h5>

                        @php $intervensiNames = $skalaMorse->getIntervensiNamesHtml(); @endphp
                        @if (count($intervensiNames) > 0)
                            @foreach ($intervensiNames as $index => $nama)
                                <div class="intervensi-item">
                                    <strong>{{ $index + 1 }}.</strong> {!! $nama !!}
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Tidak ada intervensi yang dipilih</p>
                        @endif
                    </div>
                @endif

                @if ($skalaMorse->kategori_resiko == 'RS' && $skalaMorse->intervensi_rs)
                    <div class="resiko_jatuh__section-separator">
                        <h5 style="color: #856404;"><i class="ti-alert mr-2"></i> Intervensi Pencegahan - Resiko Sedang</h5>

                        @php $intervensiNames = $skalaMorse->getIntervensiNamesHtml(); @endphp
                        @if (count($intervensiNames) > 0)
                            @foreach ($intervensiNames as $index => $nama)
                                <div class="intervensi-item" style="border-left-color: #ffc107;">
                                    <strong>{{ $index + 1 }}.</strong> {!! $nama !!}
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Tidak ada intervensi yang dipilih</p>
                        @endif
                    </div>
                @endif

                @if ($skalaMorse->kategori_resiko == 'RT' && $skalaMorse->intervensi_rt)
                    <div class="resiko_jatuh__section-separator">
                        <h5 style="color: #dc3545;"><i class="ti-alert mr-2"></i> Intervensi Pencegahan - Resiko Tinggi</h5>

                        @php $intervensiNames = $skalaMorse->getIntervensiNamesHtml(); @endphp
                        @if (count($intervensiNames) > 0)
                            @foreach ($intervensiNames as $index => $nama)
                                <div class="intervensi-item" style="border-left-color: #dc3545;">
                                    <strong>{{ $index + 1 }}.</strong> {!! $nama !!}
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">Tidak ada intervensi yang dipilih</p>
                        @endif
                    </div>
                @endif
            </x-content-card>
        </div>
    </div>
@endsection
